<?php
namespace ryunosuke\Test\WebDebugger;

use ryunosuke\WebDebugger\Debugger;
use ryunosuke\WebDebugger\GlobalFunction;
use ryunosuke\WebDebugger\Module\Ajax;
use ryunosuke\WebDebugger\Module\Database;
use ryunosuke\WebDebugger\Module\History;
use ryunosuke\WebDebugger\Module\Performance;
use ryunosuke\WebDebugger\Module\Server;

class DebuggerTest extends AbstractTestCase
{
    private $server;
    private $get;
    private $post;
    private $cookie;

    function setUp(): void
    {
        parent::setUp();

        $this->server = $_SERVER;
        $this->get = $_GET;
        $this->post = $_POST;
        $this->cookie = $_COOKIE;

        $_SERVER['REQUEST_URI'] = '/document-root/hogefugapiyo?12345';
        $_SERVER['REQUEST_METHOD'] = 'GET';
    }

    function tearDown(): void
    {
        parent::tearDown();

        $_SERVER = $this->server;
        $_GET = $this->get;
        $_POST = $this->post;
        $_COOKIE = $this->cookie;

        GlobalFunction::header_remove();
    }

    function test_cookieoption()
    {
        $_COOKIE['WebDebuggerOptions'] = json_encode([Performance::class => ['enable' => false]]);
        $module = Performance::getInstance();
        $debugger = new Debugger();
        $debugger->initialize([
            Performance::class => $module,
        ]);
        $this->assertTrue($module->isDisabled());
    }

    function test_initialize()
    {
        $debugger = new Debugger([
            'fookpath' => 'hogefugapiyo',
        ]);
        $request = new \ReflectionProperty($debugger, 'request');
        $request->setAccessible(true);
        $this->assertEquals([
            'id'                => '20001224123456.123',
            'time'              => GlobalFunction::microtime(true),
            'url'               => '/document-root/hogefugapiyo?12345',
            'path'              => '/document-root/hogefugapiyo',
            'method'            => 'GET',
            'is_ajax'           => false,
            'is_internal'       => true,
            'if_modified_since' => 0,
            'is_ignore'         => false,
            'workfile'          => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'wd-working' . DIRECTORY_SEPARATOR . '20001224123456.123',
            'workpath'          => 'hogefugapiyo/request-20001224123456.123',
        ], $request->getValue($debugger));
    }

    function test_ignore()
    {
        $debugger = new Debugger([
            'ignore' => '#.*#',
        ]);
        $debugger->initialize([
            Performance::class => [],
        ]);
        $this->assertNull($debugger->start());
    }

    function test_start_fook()
    {
        $_SERVER['REQUEST_URI'] = '/document-root/hogefugapiyo/phpinfo';
        $_SERVER['HTTP_X_REQUESTED_WITH'] = true;

        $debugger = new Debugger([
            'fookpath' => 'hogefugapiyo',
        ]);
        $debugger->initialize([
            Server::class => [],
        ]);
        $this->assertStringContainsString('phpinfo()', (string) $debugger->start());
    }

    function test_start_stopprg()
    {
        $_SERVER['REQUEST_URI'] = '/document-root/no-match';
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $debugger = new Debugger([
            'fookpath' => 'hogefugapiyo',
        ]);
        $debugger->initialize([
            Performance::class => [],
        ]);
        $debugger->start();
        echo '<span>%9$s</span>';
        GlobalFunction::header('Location: /other<あ>');
        GlobalFunction::call_shutdown_function();
        ob_end_flush();
        $this->assertNotContains('Location: /other', GlobalFunction::headers_list());
        $this->expectOutputRegex('#Redirecting to.*/other&lt;あ&gt;.*<iframe#us');
    }

    function test_start_noserializable()
    {
        $_SERVER['REQUEST_URI'] = '/document-root/no-match';

        $debugger = new Debugger([
            'fookpath' => 'hogefugapiyo',
        ]);
        $debugger->initialize([
            Server::class => [],
        ]);
        $debugger->start();
        $_GET['pdo'] = $this->getPdoConnection();
        ob_end_flush();
        $this->expectOutputString('');
    }

    function test_start_response()
    {
        $_SERVER['REQUEST_URI'] = '/document-root/no-match';

        $debugger = new Debugger([
            'fookpath' => 'hogefugapiyo',
            'rtype'    => ['html', 'console'],
        ]);
        $debugger->initialize([
            Performance::class => [],
        ]);
        $debugger->start();
        echo '<html><head></head><body></body></html>';
        GlobalFunction::call_shutdown_function();
        ob_end_flush();
        $this->assertStringContainsString('X-ChromeLogger-Data', implode("\n", GlobalFunction::headers_list()));
        $this->expectOutputRegex('#<!-- this is web debugger head injection -->#u');
        $this->expectOutputRegex('#<!-- this is web debugger body injection -->#u');
    }

    function test_start_response_ajax()
    {
        $_SERVER['REQUEST_URI'] = '/document-root/no-match';
        $_SERVER['HTTP_X_REQUESTED_WITH'] = true;

        $debugger = new Debugger([
            'fookpath' => 'hogefugapiyo',
            'rtype'    => ['html'],
        ]);
        $debugger->initialize([
            Ajax::class     => [],
            Server::class   => [],
            Database::class => ['pdo' => new Database\LoggablePDO($this->getPdoConnection())],
            History::class  => [],
        ]);
        $debugger->start();
        ob_end_flush();
        $headers = array_values(preg_grep('#^X-Debug-Ajax:#u', GlobalFunction::headers_list()));
        $this->assertEquals(1, preg_match('#^X-Debug-Ajax: (.+)#u', $headers[0], $m));
        GlobalFunction::call_shutdown_function();
        return $m[1];
    }

    /**
     * @depends test_start_response_ajax
     * @param $request_id
     */
    function test_start_response_ajax_request($request_id)
    {
        $_SERVER['REQUEST_URI'] = '/document-root/' . $request_id;

        $debugger = new Debugger([
            'fookpath' => 'hogefugapiyo',
            'rtype'    => 'html',
        ]);
        $debugger->initialize([
            Ajax::class     => [],
            Server::class   => [],
            Database::class => ['pdo' => new Database\LoggablePDO($this->getPdoConnection())],
            History::class  => [],
        ]);
        $response = $debugger->start();
        $this->assertContains('<div class="debug_plugin">', $response);
        $this->assertContains('<caption>SERVER</caption>', $response);
    }

    /**
     * @depends test_start_response_ajax
     * @param $request_id
     */
    function test_start_response_ajax_nofile($request_id)
    {
        $_SERVER['REQUEST_URI'] = '/document-root/' . preg_replace('/request-\d/', 'request-9', $request_id);

        $debugger = new Debugger([
            'fookpath' => 'hogefugapiyo',
            'rtype'    => 'html',
        ]);
        $debugger->initialize([
            Ajax::class    => [],
            Server::class  => [],
            History::class => [],
        ]);
        $response = $debugger->start();
        $this->assertContains('is not found', $response);
    }
}
