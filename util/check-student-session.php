<?php

session_start();

if (!(isset($_SESSION['student']) && isset($_SESSION['student-session']['key']))) {
    header("location:../../student/login/");
}
?>