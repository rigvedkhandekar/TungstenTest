<?php
include '../../util/config.php';
include '../../util/check-faculty-session.php';
include '../../util/util.php';
require '../../util/PHPExcel/Classes/PHPExcel.php';
require_once '../../util/PHPExcel/Classes/PHPExcel/IOFactory.php';

if (isset($_POST['upload-qb'])) {

    $qbType = $_POST['qb_type'];
    $uploadfile = $_FILES['qb_file']['tmp_name'];
    $fileName = $_FILES['qb_file'] ['name'];
//    echo $uploadfile;
    $objExcel = PHPExcel_IOFactory::load($uploadfile);

    if ($qbType == 1) {
        $output = '';
        $output .= "  
           <h6 class='text-success'>File : $fileName Successfully Uploaded.</h6>
                <table class='table table-bordered'>  
                     <tr>  
                          <th>Topic Name</th>  
                          <th>Question</th>  
                          <th>Option A</th>  
                          <th>Option B</th>  
                          <th>Option C</th>  
                          <th>Option D</th>  
                          <th>Answer</th>                          
                          <th>Difficulty</th>
                          

                     </tr>  
                     ";
        foreach ($objExcel->getWorksheetIterator() as $worksheet) {
            $highestrow = $worksheet->getHighestRow();
            for ($row = 0; $row <= $highestrow; $row++) {
                $sub_id = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                $topic_name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $question = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $a = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                $b = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                $c = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                $d = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                $answer = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                $difficulty = $worksheet->getCellByColumnAndRow(8, $row)->getValue();

                if ($sub_id != '' && $topic_name != '' && $question != '' && $a != '' && $b != '' && $c != '' && $d != '' && $answer != '' && $difficulty != '') {
                    $query = "INSERT INTO `qb_mcq_questions` (`sub_id`, `topic_name`, `question`, `a`, `b`, `c`, `d`, `answer`, `difficulty`) VALUES (:sub_id,:topic_name,:question,:a,:b,:c,:d,:answer,:difficulty)";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute(['sub_id' => $sub_id, 'topic_name' => $topic_name, 'question' => $question, 'a' => $a, 'b' => $b, 'c' => $c, 'd' => $d, 'answer' => $answer, 'difficulty' => $difficulty]);
                    $output .= '  
                     <tr>  
                          <td>' . $topic_name . '</td>  
                          <td>' . $question . '</td>  
                          <td>' . $a . '</td>  
                          <td>' . $b . '</td>  
                          <td>' . $c . '</td>  
                          <td>' . $d . '</td>  
                          <td>' . $answer . '</td>  
                          <td>' . $difficulty . '</td>  


                     </tr>  
                     ';
                }
            }
            $output .= '</table>';
            echo $output;
        }
    }

    else if ($qbType == 2)
    {
        $output = '';
        $output .= "  
           <h6 class='text-success'>File : $fileName Successfully Uploaded.</h6>
                <table class='table table-bordered'>  
                     <tr>  
                          <th>Topic Name</th>  
                          <th>Question</th>                        
                          <th>Difficulty</th>                        

                     </tr>  
                     ";
        foreach ($objExcel->getWorksheetIterator() as $worksheet) {
            $highestrow = $worksheet->getHighestRow();
            for ($row = 0; $row <= $highestrow; $row++) {
                $sub_id = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                $topic_name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $question = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $difficulty = $worksheet->getCellByColumnAndRow(3, $row)->getValue();

                if ($sub_id != '' && $topic_name != '' && $question != '' && $difficulty != '') {
                    $query = "INSERT INTO `qb_short_questions`(`sub_id`, `topic_name`, `question`, `difficulty`) VALUES (:sub_id,:topic_name,:question,:difficulty)";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute(['sub_id' => $sub_id, 'topic_name' => $topic_name, 'question' => $question, 'difficulty' => $difficulty]);
                    $output .= '  
                     <tr>  
                          <td>' . $topic_name . '</td>  
                          <td>' . $question . '</td>  
                          <td>' . $difficulty . '</td>  

                     </tr>  
                     ';
                }
            }
            $output .= '</table>';
            echo $output;
        }
    }

    else
    {
        $output = '';
        $output .= "  
           <h6 class='text-success'>File : $fileName Successfully Uploaded.</h6>
                <table class='table table-bordered'>  
                     <tr>  
                          <th>Topic Name</th>  
                          <th>Question</th>                        
                          <th>Difficulty</th>                        

                     </tr>  
                     ";
        foreach ($objExcel->getWorksheetIterator() as $worksheet) {
            $highestrow = $worksheet->getHighestRow();
            for ($row = 0; $row <= $highestrow; $row++) {
                $sub_id = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                $topic_name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $question = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $difficulty = $worksheet->getCellByColumnAndRow(3, $row)->getValue();

                if ($sub_id != '' && $topic_name != '' && $question != '' && $difficulty != '') {
                    $query = "INSERT INTO `qb_long_questions`(`sub_id`, `topic_name`, `question`, `difficulty`) VALUES (:sub_id,:topic_name,:question,:difficulty)";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute(['sub_id' => $sub_id, 'topic_name' => $topic_name, 'question' => $question, 'difficulty' => $difficulty]);
                    $output .= '  
                     <tr>  
                          <td>' . $topic_name . '</td>  
                          <td>' . $question . '</td>  
                          <td>' . $difficulty . '</td>  

                     </tr>  
                     ';
                }
            }
            $output .= '</table>';
            echo $output;
        }
    }
}
