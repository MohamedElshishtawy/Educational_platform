<?php

ob_start();

session_start();
//if he has sessions

if (!isset($_SESSION['se']) || !$_SESSION['se'] == 'AD' ||! $_SESSION['id'] == '18542') {
  session_destroy();
  headre("location: ../");
  exit();
}

include_once '../init.php';

include_once '../'.$connect;

include_once '../'.$functions;

include_once $db_prog;

$title = 'الإدارة';

include_once $header;
include_once $footer;