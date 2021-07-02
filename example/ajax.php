<?php

require __DIR__ . '/include.php';

header('Content-type: application/json');

$response = $connection->fetchAssociative('Select sleep(2)');
$response['body'] = '<body>dummy body</body>';
echo json_encode($response, JSON_UNESCAPED_SLASHES);
