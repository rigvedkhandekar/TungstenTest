<?php
include '../../util/config.php';
include '../../util/util.php';
include '../../util/check-faculty-session.php';

if (isset($_POST['eid']) && isset($_POST['sid']))
{
$no_of_sq = '';
$no_of_lq = '';

function updateExaminedStatus($eid,$sid,$fid)
{
  $examined_time = date('H:i:s');
  $query = "UPDATE `attempts` set `isExamined` = '1' , `examined_time` = :examined_time, `examiner` = :fid where `eid` = :eid AND `sid` = :sid";
  $result = query($query,['examined_time'=>$examined_time,'fid'=>$fid,'eid'=>$eid,'sid'=>$sid]);
  if ($result->rowCount() <= 0)
  {
    echo "attempt failed";
  }
  else
  {
    echo json_encode(array('examined'=>true));
  }
}

function getCounts ($eid)
{
  $query = "SELECT * FROM `exam_data` where `eid` = :eid";
  $result = query ($query,['eid'=>$eid]);
  $data = $result->fetch();

  $GLOBALS['$no_of_sq'] = $data['no_of_sq'];
  $GLOBALS['$no_of_lq'] = $data['no_of_lq'];
}


if (isset($_POST['examine-paper']) && $_POST['examine-paper'] == 1)
{

  $fid = $_SESSION['faculty-session']['key'];
  $eid = $_POST['eid'];
  $sid = $_POST['sid'];

  getCounts ($eid);
  updateExaminedStatus ($eid,$sid,$fid);



  for ($i=0; $i<$GLOBALS['$no_of_sq']; $i++)
  {
    $i++;
      $aid = "q_2_".$i;
//      echo "aid".$aid;
    $i--;

    $marks = isset($_POST["q_2_"][$i]) ? $_POST["q_2_"][$i] : NULL;


    $query = "UPDATE `short_answers` SET `marks`= :marks WHERE `eid`= :eid AND `sid`= :sid AND `aid` = :aid";
//    echo $query;
    $result = query($query,['marks'=>$marks, 'eid'=>$eid, 'sid'=>$sid, 'aid'=>$aid]);

  }

  for ($i=0; $i<$GLOBALS['$no_of_lq']; $i++)
  {

    $i++;
      $aid = "q_3_".$i;
//      echo "aid".$aid;
    $i--;

    $marks = isset($_POST["q_3_"][$i]) ? $_POST["q_3_"][$i] : NULL;


    $query = "UPDATE `large_answers` SET `marks`= :marks WHERE `eid`= :eid AND `sid`= :sid AND `aid` = :aid";
//    echo $query;
    $result = query($query,['marks'=>$marks, 'eid'=>$eid, 'sid'=>$sid, 'aid'=>$aid]);;


  }

}
}
else {
  header("location:../../admin/all-exams");
}




 ?>
