<?php
session_start();
if (!(isset($_SESSION['faculty']) && isset($_SESSION['faculty-session']['key'])))
{
    header("location:../../admin/login/");
}
?>