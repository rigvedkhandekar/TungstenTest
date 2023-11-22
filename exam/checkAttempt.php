<?php
include '../util/config.php';
include '../util/util.php';
include '../util/check-student-session.php';

if (isset($_POST['eid']))
{
  $eid = hex2bin($_POST['eid']);
  $sid = $_SESSION['student-session']['key'];
  $query = "SELECT COUNT(*) as count from `attempts` where `eid` = :eid AND `sid` = :sid";
  $result = query($query,['eid'=>$eid, 'sid'=>$sid]);
  $count =  $result->fetchColumn();
  echo $count['count'];
  print_r($count);

  if ($count > 0)
  {
    var_dump(http_response_code(409));
  }

  else {
    echo "not attempted";
  }

}

else {

    header("location:../../student/dashboard/index.php?error=409");

}

?>
