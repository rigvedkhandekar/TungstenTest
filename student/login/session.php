<?php

include '../../util/config.php';

session_start ();

if (isset($_POST['contactNo']) && isset($_POST['year']))
{
$_SESSION['student']=true;
$_SESSION['student-session'] = array();
$_SESSION['student-session'] ['key'] = $_POST['contactNo'];
$_SESSION['student-session'] ['year'] = $_POST['year'];
$_SESSION['student-session'] ['dept'] = $_POST['dept'];


}

else {
      header("location:../../student/login/index.php");
}
?>
