<?php
include '../util/config.php';
include '../util/util.php';
include '../util/check-student-session.php';

function checkMcq($qid,$option)
{
  $query = "SELECT * FROM mcq_questions where qid = :qid";
  $result = query($query,['qid'=>$qid]);
  $data = $result->fetch();
  $answer = $data['answer'];

  if ($option == $answer)
  {
    return true;
  }
  else {
    return false;
  }
}

function updateExamAttempt($eid,$sid,$isForcedSubmit)
{
  $submission_time = date('H:i:s');
  $query = "UPDATE `attempts` set `submission_time` = :submission_time , `isForcedSubmit` = :isForcedSubmit where `eid` = :eid AND `sid` = :sid";
  $result = query($query,['submission_time'=>$submission_time,'isForcedSubmit'=>$isForcedSubmit,'eid'=>$eid,'sid'=>$sid]);
  if ($result->rowCount() == 0)
  {
    var_dump(http_response_code(400));
  }
  else
  {
    echo json_encode(array('attempt-success'=>true));
  }
}


if (isset($_POST['submit-paper']) && $_POST['submit-paper'] == '1' && isset($_POST['eid']))
{
  unset($_SESSION['exam']['eid']);
  $sid = $_SESSION['student-session']['key'];
  $eid = $_POST['eid'];
  $query = "SELECT * FROM `exam_data` where `eid` = :eid";
  $result = query ($query,['eid'=>$eid]);
  $data = $result->fetch();
  $mcq_marks = $data['mcq_marks'];
  $no_of_mcqs = $data['no_of_mcqs'];
  $no_of_sq = $data['no_of_sq'];
  $no_of_lq = $data['no_of_lq'];
  $isForcedSubmit = isset($_POST['isForcedSubmit']) ? $_POST['isForcedSubmit'] : 0;
//  echo "isForce".$isForcedSubmit;

  updateExamAttempt ($eid,$sid,$isForcedSubmit);


  for ($i=1; $i<=$no_of_mcqs; $i++)
  {
      $aid = "q_1_".$i;
      $answer = isset($_POST["q_1_".$i."_"][0]) ? $_POST["q_1_".$i."_"][0] : NULL;
//      echo $answer;
      if (checkMcq($aid,$answer))
      {
        $marks = $mcq_marks;
      }

      else {
        $marks = 0;
      }

      $query = "INSERT INTO `mcq_answers` VALUES (NULL,:aid,:eid,:sid,:answer,:marks)";
      $result = query($query,['aid'=>$aid,'eid'=>$eid,'sid'=>$sid,'answer'=>$answer,'marks'=>$marks]);

  }

  for ($i=0; $i<$no_of_sq; $i++)
  {
    $i++;
      $aid = "q_2_".$i;
    $i--;

        $answer = isset($_POST["q_2_"][$i]) ? $_POST["q_2_"][$i] : NULL;
//        echo $answer;

      $query = "INSERT INTO `short_answers` VALUES (NULL,:aid,:eid,:sid,:answer,NULL)";
//      echo $query;
      $result = query($query,['aid'=>$aid,'eid'=>$eid,'sid'=>$sid,'answer'=>$answer]);
  }

  for ($i=0; $i<$no_of_lq; $i++)
  {
    $i++;

      $aid = "q_3_".$i;
//      echo $aid;
      $i--;

      $answer = isset($_POST["q_3_"][$i]) ? $_POST["q_3_"][$i] : NULL;

      $query = "INSERT INTO `large_answers` VALUES (NULL,:aid,:eid,:sid,:answer,NULL)";
//      echo $query;
      $result = query($query,['aid'=>$aid,'eid'=>$eid,'sid'=>$sid,'answer'=>$answer]);

  }

}
else
{
  header("location:../../student/dashboard/");
}

?>
