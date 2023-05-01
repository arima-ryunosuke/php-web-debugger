<?php

require __DIR__ . '/include.php';

switch ($_GET['type'] ?? '') {
    case 'plain':
        header('Content-type: text/plain');
        echo "response";
        break;
    case 'json':
        header('Content-type: application/json');
        echo json_encode(['title' => '日本語です', 'elm1', 'elm2', 'elm3']);
        break;
    case 'xml':
        header('Content-type: application/xml;charset=utf8');
        echo '<?xml version="1.0"?><root><title>日本語です</title><p>node1</p><p>node2</p><p>node3</p></root>';
        break;
}
