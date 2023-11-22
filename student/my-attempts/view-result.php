<?php
use Nullix\CryptoJsAes\CryptoJsAes;
include '../../util/config.php';
include '../../util/util.php';
include '../../util/check-student-session.php';
require '../../util/CryptoJsAes.php';
require '../../util/AeshHash.php';

if (!(isset($_POST['eid']))) {
    var_dump(http_response_code(409));
}
else {
  $eid = $_POST['eid'];
  $sid = $_SESSION['student-session']['key'];

  $loadMcq = "SELECT `mcq_questions`.`question` as `question`,`mcq_questions`.`a`,`mcq_questions`.`b`,`mcq_questions`.`c`,`mcq_questions`.`d`,`mcq_questions`.`answer` as `answer`, `exam_data`.`mcq_marks` as `max_marks`, `sid`, `mcq_answers`.`answer` as `sanswer`, `marks` FROM `mcq_answers` INNER JOIN `mcq_questions` ON `mcq_answers`.`eid` = `mcq_questions`.`eid` AND `mcq_answers`.`aid` = `mcq_questions`.`qid` INNER JOIN `exam_data` ON `exam_data`.`eid` = `mcq_answers`.`eid` WHERE `mcq_answers`.`eid` = :eid AND `sid` = :sid";
  $loadSa = "SELECT `short_questions`.`question`, `exam_data`.`sq_marks` as `max_marks`, `sid`, `answer`, `marks` FROM `short_answers` INNER JOIN `short_questions` ON `short_answers`.`eid` = `short_questions`.`eid` AND `short_answers`.`aid` = `short_questions`.`qid` INNER JOIN `exam_data` ON `exam_data`.`eid` = `short_answers`.`eid` WHERE `short_answers`.`eid` = :eid AND `sid` = :sid";
  $loadLa = "SELECT `large_questions`.`question`, `exam_data`.`lq_marks` as `max_marks`, `sid`, `answer`, `marks` FROM `large_answers` INNER JOIN `large_questions` ON `large_answers`.`eid` = `large_questions`.`eid` AND `large_answers`.`aid` = `large_questions`.`qid` INNER JOIN `exam_data` ON `exam_data`.`eid` = `large_answers`.`eid` WHERE `large_answers`.`eid` = :eid AND `sid` = :sid";

  $result_mcq = $pdo->prepare($loadMcq);
  $result_mcq->execute(['eid' => $eid, 'sid' => $sid]);

  $result_sa = $pdo->prepare($loadSa);
  $result_sa->execute(['eid' => $eid, 'sid' => $sid]);

  $result_la = $pdo->prepare($loadLa);
  $result_la->execute(['eid' => $eid, 'sid' => $sid]);

  $mcq_data = array ();
  $mcq_data['answers'] = array ();


  $short_data = array ();
  $short_data['answers'] = array ();

  $large_data = array();
  $large_data['answers'] = array ();


  while ($data = $result_mcq->fetch())
  {
    $mcq_data['answers'] [$data['question']] = array ($data['a'],$data['b'],$data['c'],$data['d'],$data['answer'],$data['sanswer'],$data['marks']);
    $mcq_data['max_marks'] = $data['max_marks'];
  }


  while ($data = $result_sa->fetch())
  {
    $short_data['answers'] [$data['question']] = array ($data['answer'],$data['marks']);
    $short_data['max_marks'] = $data['max_marks'];
  }

  while ($data = $result_la->fetch())
  {
    $large_data['answers'] [$data['question']] = array ($data['answer'],$data['marks']);
    $large_data['max_marks'] = $data['max_marks'];

  }
//    $mcq_data = CryptoJsAes::encrypt($mcq_data, AesHash::$salt);
//    $short_data = CryptoJsAes::encrypt($short_data, AesHash::$salt);
//    $large_data = CryptoJsAes::encrypt($large_data, AesHash::$salt);


    echo json_encode(
        array(
        'mcq_answers' => $mcq_data,
        'short_answers' => $short_data,
        'large_answers' => $large_data
        )
      );
}
