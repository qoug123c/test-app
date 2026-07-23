<?php
require_once('functions.php');
// var_dump($_POST);  // ここを追記
// exit;
createData($_POST);
header('Location: ./index.php');