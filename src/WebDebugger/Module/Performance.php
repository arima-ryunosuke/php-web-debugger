<?php
namespace ryunosuke\WebDebugger\Module;

use ryunosuke\WebDebugger\GlobalFunction;
use ryunosuke\WebDebugger\Html\ArrayTable;
use ryunosuke\WebDebugger\Html\HashTable;
use ryunosuke\WebDebugger\Html\Popup;
use ryunosuke\WebDebugger\Html\Raw;
use function ryunosuke\WebDebugger\backtrace;
use function ryunosuke\WebDebugger\multiexplode;
use function ryunosuke\WebDebugger\profiler;

class Performance extends AbstractModule
{
    /** @var self */
    private static $instance;

    private $start_time;

    private $timelines;

    private $cputimes;

    private $profiler_options;

    private $profiler = [];

    public static function time($name = '')
    {
        if (self::$instance === null) {
            throw new \DomainException('Performance Module is not initialized.');
        }

        return self::$instance->_time($name);
    }

    protected function _initialize(array $options = [])
    {
        $options = array_replace_recursive([
            /**
             * string グローバル関数の名前
             *
             * function を与えるとその名前でグローバル関数として定義される。
             * デフォルトは `dtime` で、何らかの任意の名前を指定しても重複しない限り問題ないはず。
             * ただし、変更した場合は IDE 等でエラーが出るので何らかの対処をしたほうがよい。
             * （`dtime` であれば tests/bootstrap.php でダミー定義してるのでエラーにはならないはず）。
             */
            'function'         => 'dtime',
            // プロファイル時に無視する呼び出し
            'profiler_options' => [],
        ], $options);

        $this->start_time = isset($_SERVER['REQUEST_TIME_FLOAT']) ? $_SERVER['REQUEST_TIME_FLOAT'] : microtime(true);
        $this->timelines = [];
        $this->cputimes = function_exists('posix_times') ? posix_times() : null;

        if (!function_exists($options['function'])) {
            $funcname = $options['function'];
            $class = __CLASS__;
            eval(/** @lang */"function $funcname(){return call_user_func_array('$class::time', func_get_args());}");
        }

        $this->profiler_options = $options['profiler_options'];

        self::$instance = $this;
    }

    protected function _finalize()
    {
        self::$instance = null;
        // 色々やっているのは念の為
        unset($this->profiler);
        $this->profiler = [];
        gc_collect_cycles();
    }

    protected function _time($name = null)
    {
        $traces = backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, [
            // 自身の time でもグローバルな dtime でもないものを探す
            'file'  => function ($file) {
                return strpos($file, __FILE__) === false;
            },
            'limit' => 1,
        ]);

        $this->timelines[] = [
            'name' => $name ?: $traces[0]['file'] ?? null,
            'time' => microtime(true) - $this->start_time,
            'file' => $traces[0]['file'] ?? null,
            'line' => $traces[0]['line'] ?? null,
        ];
    }

    protected function _setting()
    {
        if (!empty($this->setting['profile'])) {
            $this->profiler = profiler($this->profiler_options);
        }
    }

    protected function _gather(array $request): array
    {
        $last = null;
        $timelines = [];
        foreach ($this->timelines as $n => $timeline) {
            if ($n === 0) {
                $last = $timeline;
                continue;
            }
            $timelines[] = [
                    'name' => $last['name'] . ' ～ ' . $timeline['name'],
                    'time' => $timeline['time'] - $last['time'],
                ] + $timeline;
            $last = $timeline;
        }

        $opcache = GlobalFunction::opcache_get_status() ?: ['opcache_enabled' => false];
        if (isset($opcache['scripts'])) {
            foreach ($opcache['scripts'] as &$script) {
                $script = [
                    'full_path'     => $script['full_path'],
                    'hits'          => $script['hits'],
                    'memory_usage'  => $script['memory_consumption'],
                    'last_used'     => date('Y/m/d H:i:s', $script['last_used_timestamp']),
                    'last_modified' => date('Y/m/d H:i:s', $script['timestamp']),
                ];
            }
        }

        $profiles = [];
        foreach ($this->profiler as $callee => $callers) {
            $callerlist = [];
            foreach ($callers as $caller => $times) {
                $elem = array_combine(['file', 'line'], multiexplode('#', $caller, -2));
                $elem['times'] = array_sum($times);
                $callerlist[] = $elem;
            }
            $totals = array_merge(...array_values($callers));
            $count = count($totals);
            $center = (int) ($count / 2);
            $min = min($totals);
            $max = max($totals);
            $sum = array_sum($totals);
            $avg = $sum / $count;
            $med = $count % 2 === 1 ? $totals[$center] : ($totals[$center - 1] + $totals[$center]) / 2;
            $profiles[] = [
                ''       => '-',
                'callee' => $callee,
                'count'  => $count,
                'min'    => $min,
                'max'    => $max,
                'sum'    => $sum,
                'avg'    => $avg,
                'med'    => $med,
                'caller' => $callerlist,
            ];
        }

        $processTime = microtime(true) - $this->start_time;
        $performance = [
            'ProcessTime'  => $processTime,
            'CPU(user)'    => null,
            'CPU(system)'  => null,
            'MemoryUsage'  => memory_get_peak_usage(true),
            'IncludedFile' => get_included_files(),
        ];
        // @codeCoverageIgnoreStart
        if ($this->cputimes !== null) {
            $CLK_TCK = 100; // sysconf(_SC_CLK_TCK);
            $cputimes = posix_times();
            $gen = fn($time) => sprintf("%.3f %%(%d times)", $time / $CLK_TCK / $processTime * 100, $time);
            $performance['CPU(user)'] = $gen($cputimes['utime'] - $this->cputimes['utime']);
            $performance['CPU(system)'] = $gen($cputimes['stime'] - $this->cputimes['stime']);
        }
        // @codeCoverageIgnoreEnd

        return [
            'Performance' => array_filter($performance, fn($p) => $p !== null),
            'Timeline'    => $timelines,
            'OPcache'     => $opcache,
            'Profile'     => $profiles,
        ];
    }

    protected function _getCount($stored): ?int
    {
        return count($stored['Timeline']);
    }

    protected function _getError($stored): array
    {
        $result = [];
        if (count($stored['Timeline'])) {
            $result[] = 'has ' . count($stored['Timeline']) . ' timeline';
        }
        return $result;
    }

    protected function _getHtml($stored): string
    {
        $caption = new Raw('Profile <label><input name="profile" class="debug_plugin_setting" type="checkbox">profile</label>');

        ob_start();
        ?>
        <table class="debug_table" style="width:100%;">
            <caption>Timeline</caption>

            <thead>
            <tr>
                <th class="nowrap" style=""></th>
                <th class="nowrap" style="width:15%">period</th>
                <th class="nowrap" style="width:85%">timeline</th>
            </tr>
            </thead>

            <tbody>
            <?php $left = 0; ?>
            <?php $total = array_reduce($stored['Timeline'], function ($carry, $v) { return $carry + $v['time']; }, 0); ?>
            <?php foreach ($stored['Timeline'] as $timeline) : ?>
                <tr>
                    <td class="nowrap">
                        <?= $this->toOpenable($timeline)['']; ?>
                    </td>
                    <td class="nowrap">
                        <?= htmlspecialchars($timeline['name']); ?>
                    </td>
                    <td class="nowrap">
                        <div
                            class="bar"
                            style="text-align:right; background: #ccf; position: relative;left: <?= htmlspecialchars($left / $total * 98); ?>%;width: <?= htmlspecialchars($timeline['time'] / $total * 98); ?>%;"
                        >
                            <?= htmlspecialchars($timeline['time'] * 1000); ?>ms
                        </div>
                    </td>
                </tr>
                <?php $left += $timeline['time']; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php
        $timelinehtml = ob_get_clean();

        $stored['OPcache']['memory_usage'] = new HashTable('', $stored['OPcache']['memory_usage'] ?? [], []);
        $stored['OPcache']['interned_strings_usage'] = new HashTable('', $stored['OPcache']['interned_strings_usage'] ?? []);
        $stored['OPcache']['opcache_statistics'] = new HashTable('', $stored['OPcache']['opcache_statistics'] ?? []);
        $stored['OPcache']['preload_statistics'] = new HashTable('', $stored['OPcache']['preload_statistics'] ?? []);
        $stored['OPcache']['scripts'] = new ArrayTable('', $stored['OPcache']['scripts'] ?? []);

        foreach ($stored['Profile'] as &$profile) {
            try {
                $parts = preg_split('#::|->#', $profile['callee'], 2);
                $ref = count($parts) > 1 ? new \ReflectionMethod(...$parts) : new \ReflectionFunction(...$parts);
                if (!$ref->isInternal()) {
                    $profile[''] = $this->toOpenable([
                        'file' => $ref->getFileName(),
                        'line' => $ref->getStartLine(),
                    ])[''];
                }
            }
            catch (\ReflectionException $e) {
            }
            $popuptitle = sprintf('caller(%d)', count($profile['caller']));
            $profile['caller'] = new Popup($popuptitle, new ArrayTable('', array_map([$this, 'toOpenable'], $profile['caller'])));
        }

        return implode('', [
            new HashTable('Performance', $stored['Performance']),
            new Raw($timelinehtml),
            new HashTable('OPcache', $stored['OPcache']),
            new ArrayTable($caption, $stored['Profile']),
        ]);
    }
}
