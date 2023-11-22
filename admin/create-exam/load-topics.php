<?php
include '../../util/config.php';
include '../../util/check-faculty-session.php';
include '../../util/util.php';

if (!isset($_POST['load_topics'])) {

    $sub_id = $_POST['sub_id'];
    $output = "";
    $query = "select distinct topic_name from ( select topic_name from qb_mcq_questions WHERE sub_id = '$sub_id' union all select topic_name from qb_short_questions WHERE sub_id = '$sub_id' union all select topic_name from qb_long_questions WHERE sub_id = '$sub_id' ) a order by topic_name";
    $result = query($query, []);
    $i = 0;
        while ($data = $result->fetch())
        {
            $i = $i + 1;
        $topic_name = $data['topic_name'];

        $output .= "<input class='border-checkbox' type='checkbox' name='avlbl_topics[]' id='avlbl_topics$i' value='$topic_name'>
            <label class='border-checkbox-label' for='avlbl_topics$i'>$topic_name</label>";
        }
    echo $output;
}