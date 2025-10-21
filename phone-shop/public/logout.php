<?php
session_start();
include '../app/config.php';
session_destroy();
header("Location: index.php");
exit;
