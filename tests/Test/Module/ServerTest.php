<?php
namespace ryunosuke\Test\WebDebugger\Module;

use ryunosuke\Test\WebDebugger\AbstractTestCase;
use ryunosuke\WebDebugger\Html\Raw;
use ryunosuke\WebDebugger\Module\Server;

class ServerTest extends AbstractTestCase
{
    private $server;
    private $get;
    private $post;
    private $files;

    function setUp(): void
    {
        parent::setUp();

        $this->server = $_SERVER;
        $this->get = $_GET;
        $this->post = $_POST;
        $this->files = $_FILES;
    }

    function tearDown(): void
    {
        parent::tearDown();

        $_SERVER = $this->server;
        $_GET = $this->get;
        $_POST = $this->post;
        $_FILES = $this->files;
    }

    function test_fook()
    {
        $module = new Server();
        $module->initialize();

        $response = $module->fook(['is_ajax' => true, 'path' => 'phpinfo']);
        $this->assertTrue($response instanceof Raw);
        $this->assertStringContainsString("phpinfo", (string) $response);

        $_POST['session'] = '{"a": 1, "b": 2}';
        $response = $module->fook(['is_ajax' => true, 'path' => 'savesession']);
        $this->assertTrue($response);

        $_POST['session'] = 'hoge';
        $response = $module->fook(['is_ajax' => true, 'path' => 'savesession']);
        $this->assertContains('json format is invalid', $response);
    }

    function test_gather()
    {
        $_FILES = [
            'file1' => [
                'name'     => '',
                'type'     => '',
                'tmp_name' => '',
                'error'    => 4,
                'size'     => 0,
            ],
            'file2' => [
                'name'     => [''],
                'type'     => [''],
                'tmp_name' => [''],
                'error'    => [4],
                'size'     => [0],
            ],
            'file3' => [
                'name'     => [['sub' => ''],],
                'type'     => [['sub' => ''],],
                'tmp_name' => [['sub' => ''],],
                'error'    => [['sub' => 4],],
                'size'     => [['sub' => 0],],
            ],
        ];

        $module = new Server();
        $module->initialize();
        $stored = $module->gather([]);
        $this->assertArrayHasKey('GET', $stored);
        $this->assertArrayHasKey('POST', $stored);
        $this->assertArrayHasKey('FILES', $stored);
        $this->assertArrayHasKey('COOKIE', $stored);
        $this->assertArrayHasKey('SESSION(param)', $stored);
        $this->assertArrayHasKey('SESSION(data)', $stored);
        $this->assertArrayHasKey('SERVER', $stored);
    }

    function test_getError()
    {
        $_GET['same'] = 'hoge';
        $_POST['same'] = 'fuga';
        $_SERVER['HTTPS'] = 'on';

        $module = new Server();
        $module->initialize();
        $error = $module->getError($module->gather([]));
        $this->assertStringContainsString('has same key', $error);
        $this->assertStringContainsString('has vulnerability', $error);
    }

    function test_render()
    {
        $_GET['same'] = 'hoge';
        $_POST['same'] = 'fuga';
        $_SERVER['HTTPS'] = 'on';

        $module = new Server();
        $module->initialize();
        $htmls = $module->render($module->gather([]));
        $this->assertStringContainsString('<caption>GET', $htmls);
        $this->assertStringContainsString('<caption>POST', $htmls);
        $this->assertStringContainsString('<caption>FILES', $htmls);
        $this->assertStringContainsString('<caption>COOKIE', $htmls);
        $this->assertStringContainsString('<caption>SESSION', $htmls);
        $this->assertStringContainsString('<caption>SERVER', $htmls);

        $this->assertEquals(6, substr_count($htmls, 'color:red'));
    }

    function test_console()
    {
        $module = new Server();
        $module->initialize();
        $consoles = $module->console($module->gather([]));
        $this->assertArrayHasKey('hashtable', $consoles['GET']);
        $this->assertArrayHasKey('hashtable', $consoles['POST']);
        $this->assertArrayHasKey('hashtable', $consoles['FILES']);
        $this->assertArrayHasKey('hashtable', $consoles['COOKIE']);
        $this->assertArrayHasKey('hashtable', $consoles['SESSION(param)']);
        $this->assertArrayHasKey('hashtable', $consoles['SESSION(data)']);
        $this->assertArrayHasKey('hashtable', $consoles['SERVER']);
    }
}
