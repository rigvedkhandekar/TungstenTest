<?php
include '../../util/config.php';
include '../../util/util.php';
include '../../util/check-faculty-session.php';


function errorOccured()
{
    header("location:../../create-exam/errors");
}

function paperCreated($eid)
{
    header("location:../../admin/all-exams/index.php?success=$eid");

}



if (isset($_POST['generate-paper'])) {

    $eid = $_POST['eid'];
    $query = "Select * from exam_data where eid = :eid";
    $result = query($query,['eid'=>$eid]);
    $data = $result->fetch();
    $no_of_mcqs = $data['no_of_mcqs'];
    $no_of_sq = $data['no_of_sq'];
    $no_of_lq = $data['no_of_lq'];

    for ($i = 1; $i <= $no_of_mcqs; $i++) {
        $qid = "q_1_" . $i;
        $qstn = $_POST["q_1_" . $i . "_"][0];
        $opa = $_POST["q_1_" . $i . "_"][1];
        $opb = $_POST["q_1_" . $i . "_"][2];
        $opc = $_POST["q_1_" . $i . "_"][3];
        $opd = $_POST["q_1_" . $i . "_"][4];
        $ans = $_POST["q_1_" . $i . "_"][5];


            $query = "INSERT INTO `mcq_questions`(`id`, `qid`, `eid`, `question`, `a`, `b`, `c`, `d`, `answer`) VALUES (NULL,:qid,:eid,:qstn,:opa,:opb,:opc,:opd,:ans)";
            //echo $query;
            $result = query($query,['qid'=>$qid,'eid'=>$eid,'qstn'=>$qstn,'opa'=>$opa,'opb'=>$opb,'opc'=>$opc,'opd'=>$opd,'ans'=>$ans]);

            if ($result->rowCount()<=0) {
                errorOccured();
            }



    }

    for ($i = 0; $i < $no_of_sq; $i++) {
        $i++;
        $qid = "q_2_" . $i;
        $i--;

        $qstn = $_POST["q_2_"][$i];

            $query = "INSERT INTO `short_questions`(`id`, `qid`, `eid`, `question`) VALUES (NULL,:qid,:eid,:qstn)";
            $result = query($query,['qid'=>$qid,'eid'=>$eid,'qstn'=>$qstn]);
            if (!$result->rowCount() >= 1) {
                errorOccured();
            }


    }

    for ($i = 0; $i < $no_of_lq; $i++) {
        $i++;
        $qid = "q_3_" . $i;
        $i--;


        $qstn = $_POST["q_3_"][$i];

            $query = "INSERT INTO `large_questions`(`id`, `qid`, `eid`, `question`) VALUES (NULL,:qid,:eid,:qstn)";
            $result = query($query,['qid'=>$qid,'eid'=>$eid,'qstn'=>$qstn]);
            if (!$result->rowCount() >= 1) {
                errorOccured();
            }
            else
            {
                paperCreated($eid);
            }


    }

}


?>
