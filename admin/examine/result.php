<?php
include '../../util/config.php';
include '../../util/util.php';
include '../../util/check-faculty-session.php';

if (isset($_POST['eid']) && isset($_POST['sid']))
{
  $eid = $_POST['eid'];
  $sid = $_POST['sid'];

  if (isset($_POST['generate-result']) && $_POST['generate-result'] == 1) {
    $query = "UPDATE attempts set attempts.score = ( SELECT SUM(total) from (SELECT `mcq_answers`.`marks` as total from `mcq_answers` WHERE `mcq_answers`.`eid` = :eid1 AND `mcq_answers`.`sid` = :sid1 UNION ALL SELECT `short_answers`.`marks`from `short_answers`WHERE `short_answers`.`eid` = :eid2 AND `short_answers`.`sid` = :sid2 UNION ALL SELECT `large_answers`.`marks` from `large_answers` WHERE `large_answers`.`eid` = :eid3 AND `large_answers`.`sid` = :sid3) x) where `attempts`.`eid` = :eid4 AND `attempts`.`sid` = :sid4";
    $result = $pdo->prepare($query);
    $result->execute(['eid1'=>$eid,'eid2'=>$eid,'eid3'=>$eid,'eid4'=>$eid,'sid1'=>$sid,'sid2'=>$sid,'sid3'=>$sid,'sid4'=>$sid]);
    if ($result->rowCount() <= 0) {
      var_dump(http_response_code(409));
    }
    else
    {
      echo json_encode(array('result-generated'=>true));
    }

  }


}
else {
  // header("location:../../admin/all-exams");
}




 ?>
