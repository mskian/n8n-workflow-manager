<?php

include 'connection.php';

$msg = [];

header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('X-Content-Type-Options: nosniff');
header('Strict-Transport-Security: max-age=63072000');
header('Content-type:application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
header('X-Robots-Tag: noindex, nofollow', true);

$result = $conn->query('SELECT * FROM n8n');
$row = $result->fetch(PDO::FETCH_ASSOC);
$verify = $row['status'];
$msg['message'] = $verify;
echo json_encode($msg);

?>