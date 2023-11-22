<?php
include 'config.php';

session_start();
session_destroy ();

header("location:../../student/login/index.php");

?>
