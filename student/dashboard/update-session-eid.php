<?php
include '../../util/config.php';
include '../../util/check-student-session.php';

if (isset($_POST['eid'])) {
      $eid = $_POST['eid'];
      $_SESSION['exam'] = array();
      $_SESSION['exam']['eid'] = $eid;
} else {

      header("location:../../student/dashboard/");
}
?>
