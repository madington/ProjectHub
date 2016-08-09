<?php
$my_file = 'data/' . $_GET['project'] . '.yml';
unlink($my_file);
header('Location: ../ProjectHub');