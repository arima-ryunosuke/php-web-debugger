<?php
namespace ryunosuke\WebDebugger\Module;

use ryunosuke\WebDebugger\Html\HashTable;
use ryunosuke\WebDebugger\Html\Raw;

class Performance extends AbstractModule
{
    /** @var self */
    private static $instance;

    private $start_time;

    private $timelines;

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
            'function' => 'dtime',
        ], $options);

        $this->start_time = isset($_SERVER['REQUEST_TIME_FLOAT']) ? $_SERVER['REQUEST_TIME_FLOAT'] : microtime(true);
        $this->timelines = [];

        if (!function_exists($options['function'])) {
            $funcname = $options['function'];
            $class = __CLASS__;
            eval("function $funcname(){return call_user_func_array('$class::time', func_get_args());}");
        }

        self::$instance = $this;
    }

    protected function _finalize()
    {
        self::$instance = null;
    }

    protected function _time($name = null)
    {
        $traces = \ryunosuke\WebDebugger\backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, [
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

    protected function _gather()
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

        return [
            'Performance' => [
                'ProcessTime'  => number_format(microtime(true) - $this->start_time, 6),
                'MemoryUsage'  => number_format(memory_get_peak_usage(true)),
                'IncludedFile' => get_included_files(),
            ],
            'Timeline'    => $timelines,
        ];
    }

    protected function _render($stored)
    {
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
                            <?= htmlspecialchars(number_format($timeline['time'] * 1000, 3)); ?>ms
                        </div>
                    </td>
                </tr>
                <?php $left += $timeline['time']; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php
        $html = ob_get_clean();

        return [
            'Performance' => new HashTable('Performance', $stored['Performance']),
            'Timeline'    => new Raw($html),
        ];
    }

    protected function _console($stored)
    {
        return [
            'Performance' => ['hashtable' => $stored['Performance']],
            'Timeline'    => ['table' => $stored['Timeline']],
        ];
    }
}
