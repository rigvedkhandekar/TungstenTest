<?php
include '../util/config.php';
include '../util/util.php';
include '../util/check-student-session.php';

if (isset($_POST['eid']))
{

  $eid = $_POST['eid'];
  $sid = $_SESSION['student-session']['key'];
  $start_time = date('H:i:s');

  try {
    $query = "INSERT INTO `attempts` (`eid`, `sid`, `start_time`) values (:eid,:sid,:start_time)";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['eid'=>$eid,'sid'=>$sid,'start_time'=>$start_time]);

    if (!$stmt->rowCount() > 0)
    {

    }
    else
    {

      echo json_encode(array('success'=>1));
    }

  }
  catch (Exception $e)
  {

    $errorCode = $e->getCode();
    echo $errorCode;
    var_dump(http_response_code(400));

  }


}

else {

    header("location:../../student/dashboard/");

}

?>
