<?php
$my_file = 'data/' . str_replace(' ', '-', strtolower($_POST['title'])) . '-' . md5(microtime(true)) . '.yml';
$handle = fopen($my_file, 'w') or die('Cannot open file:  ' . $my_file);
$data =
'name: "' . $_POST['title'] . '"' . "\r\n" .
'timeline:' . "\r\n" .
'    -' . "\r\n" .
'        stamp: "' . date('F jS, Y H:i:s') . '"' . "\r\n" . // r
'        content: "Project created"';
fwrite($handle, $data);
header('Location: ../ProjectHub');
?>