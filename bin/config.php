<?php
return [
    'path_map'  => function ($file) {
        return str_replace("/mnt/windows/", "C:/local/path", $file);
    },
    'exec_path' => 'C:/path/to/phpstorm.exe -l %2$s %1$s',
];
