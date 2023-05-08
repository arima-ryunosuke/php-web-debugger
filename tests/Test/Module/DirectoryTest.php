<?php
namespace ryunosuke\Test\WebDebugger\Module;

use ryunosuke\Test\WebDebugger\AbstractTestCase;
use ryunosuke\WebDebugger\Module\Directory;
use function ryunosuke\WebDebugger\file_set_tree;
use function ryunosuke\WebDebugger\mkdir_p;
use function ryunosuke\WebDebugger\rm_rf;

class DirectoryTest extends AbstractTestCase
{
    private $dir1, $dir2;

    function setUp(): void
    {
        parent::setUp();

        $this->dir1 = sys_get_temp_dir() . '/dir1';
        $this->dir2 = sys_get_temp_dir() . '/dir2';

        rm_rf($this->dir1);
        rm_rf($this->dir2);
        mkdir_p($this->dir1);
        mkdir_p($this->dir2);
        file_set_tree($this->dir1, [
            'sub1' => [
                'file1.txt' => 'file1',
                'file2.txt' => 'file2',
                'sub2'      => [
                    'file3.txt' => 'file3',
                    'file4.txt' => 'file4',
                ],
            ],
        ]);
        file_set_tree($this->dir2, [
            'sub3' => [
                'file1.txt' => 'file1',
                'file2.txt' => 'file2',
                'sub4'      => [
                    'file3.txt' => 'file3',
                    'file4.txt' => 'file4',
                ],
            ],
        ]);
    }

    function test_fook()
    {
        $module = new Directory();
        $module->initialize([
            $this->dir1 => [],
        ]);

        $_POST['fullpath'] = "{$this->dir1}/sub1/file1.txt";
        $this->assertFileExists("{$this->dir1}/sub1/file1.txt");
        $response = $module->fook(['is_ajax' => true, 'path' => 'deletedirfile']);
        $this->assertEquals('ok', $response);
        $this->assertFileDoesNotExist("{$this->dir1}/sub1/file1.txt");

        $_POST['dirname'] = realpath($this->dir1);
        $this->assertFileExists("{$this->dir1}/sub1/sub2/file3.txt");
        $this->assertFileExists("{$this->dir1}/sub1/sub2/file4.txt");
        $response = $module->fook(['is_ajax' => true, 'path' => 'cleardirfile']);
        $this->assertEquals('ok', $response);
        $this->assertFileDoesNotExist("{$this->dir1}/sub1/sub2/file3.txt");
        $this->assertFileDoesNotExist("{$this->dir1}/sub1/sub2/file4.txt");
    }

    function test_all()
    {
        $module = new Directory();
        $module->initialize([
            $this->dir1 => [],
            $this->dir2 => [
                'list' => function ($path) { return strpos($path, 'sub4') === false; },
                'head' => function ($path) { return 'misc'; },
            ],
        ]);

        $stored = $module->gather([]);
        $this->assertArrayHasKey(realpath($this->dir1), $stored);
        $this->assertArrayHasKey(realpath($this->dir2), $stored);
        $this->assertArrayHasKey(realpath("{$this->dir1}/sub1/sub2/file3.txt"), $stored[realpath($this->dir1)]);
        $this->assertArrayHasKey(realpath("{$this->dir1}/sub1/sub2/file4.txt"), $stored[realpath($this->dir1)]);
        $this->assertArrayNotHasKey(realpath("{$this->dir2}/sub3/sub4/file3.txt"), $stored[realpath($this->dir2)]);
        $this->assertArrayNotHasKey(realpath("{$this->dir2}/sub3/sub4/file4.txt"), $stored[realpath($this->dir2)]);

        $count = $module->getCount($stored);
        $this->assertEquals(6, $count);

        $html = $module->render($stored);
        $this->assertStringContainsString('span class="dirname"', $html);
        $this->assertStringContainsString('class="cleardirfile"', $html);
        $this->assertStringContainsString('class="deletedirfile"', $html);
    }
}
