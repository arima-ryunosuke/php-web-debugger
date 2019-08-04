<?php

require __DIR__ . '/include.php';

header('Content-type: application/json');

$response = $pdo->query('Select sleep(2)')->fetch(\PDO::FETCH_ASSOC);
$response['body'] = '<body>dummy body</body>';
echo json_encode($response, JSON_UNESCAPED_SLASHES);
