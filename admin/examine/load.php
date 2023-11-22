<?php
include '../../util/config.php';
include '../../util/check-faculty-session.php';
include '../../util/util.php';

if (!(isset($_POST['eid']) && isset($_POST['year']) && isset($_POST['dept']))) {
  header("location:../../admin/examine/");
}
else {
  $eid = $_POST['eid'];
  // echo $eid;
  $year = $_POST['year'];

  $dept = $_POST['dept'];

  if ($year == '3')
  {
  $query = "SELECT student_data_3_2019_2020.name,student_data_3_2019_2020.rollno,student_data_3_2019_2020.contact_no, `id`, `eid`, `sid`, `start_time`, `submission_time`, `isForcedSubmit`, `isExamined` FROM `attempts` INNER JOIN student_data_3_2019_2020 ON `attempts`.`sid` = `student_data_3_2019_2020`.`contact_no` where eid = :eid AND `isExamined` IS NULL LIMIT 1";
  }
  else if ($year == '2')
  {
  $query = "SELECT student_data_2_2019_2020.name,student_data_2_2019_2020.rollno,student_data_2_2019_2020.contact_no, `id`, `eid`, `sid`, `start_time`, `submission_time`, `isForcedSubmit`, `isExamined` FROM `attempts` INNER JOIN student_data_3_2019_2020 ON `attempts`.`sid` = `student_data_3_2019_2020`.`contact_no` where eid = :eid AND `isExamined` IS NULL LIMIT 1";
  }

  $result = query ($query,['eid'=>$eid]);
  $studentData = $result->fetch();
  $sid = $studentData['sid'];


  $loadSa = "SELECT `exam_data`.`sq_marks` as `max_marks`, `short_questions`.`question`, `sid`, `answer`, `marks` FROM `short_answers` INNER JOIN `short_questions` ON `short_answers`.`eid` = `short_questions`.`eid` AND `short_answers`.`aid` = `short_questions`.`qid` INNER JOIN `exam_data` ON `exam_data`.`eid` = `short_questions`.`eid` WHERE `short_answers`.`eid` = :eid AND `sid` = :sid";
  $loadLa = "SELECT `exam_data`.`lq_marks` as `max_marks`, `large_questions`.`question`, `sid`, `answer`, `marks` FROM `large_answers` INNER JOIN `large_questions` ON `large_answers`.`eid` = `large_questions`.`eid` AND `large_answers`.`aid` = `large_questions`.`qid` INNER JOIN `exam_data` ON `exam_data`.`eid` = `large_questions`.`eid` WHERE `large_answers`.`eid` = :eid AND `sid` = :sid";

   $result_sa = $pdo->prepare($loadSa);
   $result_sa->execute(['eid'=>$eid, 'sid'=>$sid]);

    $result_la = $pdo->prepare($loadLa);
    $result_la->execute(['eid'=>$eid, 'sid'=>$sid]);


  $short_data = array ();
  $short_data['answers'] = array ();

  $large_data = array();
  $large_data['answers'] = array ();


  while ($data = $result_sa->fetch())
  {
    $short_data['answers'] [$data['question']] = $data['answer'];
    $short_data['max_marks'] = $data['max_marks'];
  }

  while ($data = $result_la->fetch())
  {
    $large_data['answers'] [$data['question']] = $data['answer'];
    $large_data['max_marks'] = $data['max_marks'];

  }

  if (is_null($studentData['name']) && is_null($studentData['rollno']))
  {

    var_dump(http_response_code(409));

  }

  else {
    echo json_encode(
      array(
        array(
        'name' => $studentData['name'],
        'rollno'=> $studentData['rollno'],
        'sid'=> $studentData['contact_no'],
        'start_time' => $studentData['start_time'],
        'end_time' => $studentData['submission_time'],
        'isForcedSubmit' => $studentData['isForcedSubmit']),
        array(
        'short_answers' => $short_data,
        'large_answers' => $large_data)
      )
      );
  }



}
