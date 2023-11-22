<?php
include '../../util/config.php';
include '../../util/util.php';
include '../../util/check-faculty-session.php';
require ('../../tools/fpdf/fpdf.php');

class PDF extends FPDF
{
    public $eid, $examiner, $edate, $total_marks;

    public function setData($eid, $examiner, $edate, $total_marks)
    {
        $this->eid = $eid;
        $this->examiner = $examiner;
        $this->edate = $edate;
        $this->total_marks = $total_marks;

    }

// Page header
    function Header()
    {
        if ($this->PageNo() == 1) {
            // Add your stuff here

            // Logo
            $this->Image('../../template/img/header.jpg', 3, 3);

            $this->Ln(35);
            // Arial bold 15
            $this->SetFont('Arial', 'B', 12);
            // Move to the right
            $this->Cell(30, 0, 'Exam ID :', 0, 0, 'L');
            $this->Cell(-8);
            $this->SetFont('Arial', '', 12);
            $this->Cell(30, 0, $this->eid, 0, 0, 'L');

            $this->Cell(85);
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(30, 0, 'Date : ', 0, 0, 'R');
            $this->SetFont('Arial', '', 12);
            $this->Cell(30, 0, $this->edate, 0, 0, 'L');

            $this->Ln(10);

            $this->SetFont('Arial', 'B', 12);
            $this->Cell(30, 0, 'Examiner : ', 0, 0, 'L');
            $this->Cell(-7);
            $this->SetFont('Arial', '', 12);
            $this->Cell(30, 0, $this->examiner, 0, 0, 'L');


            $this->Cell(85);

            $this->SetFont('Arial', 'B', 12);
            $this->Cell(30, 0, 'Marks : ', 0, 0, 'R');
            $this->SetFont('Arial', '', 12);
            $this->Cell(30, 0, $this->total_marks, 0, 0, 'L');


            $this->Ln(10);

            $this->Cell(75);
            $this->Cell(30, 10, 'RESULT', 1, 0, 'C');
            $this->Ln(10);
        }
    }

// Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', '', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'R');
    }
}

function exportPdf($dataSet)
{
    $data = $dataSet->fetch();
    $eid = $data['eid'];
    $examiner = $data['faculty_name'];
    $edate = $data['exam_date'];
    $total_marks = $data['exam_marks'];
    $passing_marks = $data['passing_marks'];



    $pdf = new PDF();
    $pdf->setData($eid, $examiner, $edate, $total_marks);
    $pdf->AddPage();
    $pdf->ln();
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(15, 12, 'R.N.', 1, 0, 'C');
    $pdf->Cell(75, 12, 'Name', 1, 0, 'C');
    $pdf->Cell(25, 12, 'Start Time', 1, 0, 'C');
    $pdf->Cell(25, 12, 'End Time', 1, 0, 'C');
    $pdf->Cell(25, 12, 'Forced?', 1, 0, 'C');
    $pdf->Cell(25, 12, 'Score', 1, 0, 'C');


    while ($data = $dataSet->fetch()) {
        $pdf->SetFont('Arial', '', 11);
        $pdf->Ln();
        if ($data['isForcedSubmit']) {
            $data['isForcedSubmit'] = 'Yes';
        } else {
            $data['isForcedSubmit'] = 'No';
        }

        if (is_null($data['start_time'])) {
            $data['start_time'] = 'N/A';
            $data['submission_time'] = 'N/A';
            $data['isForcedSubmit'] = 'N/A';
            $data['score'] = 'ABSENT';
        }
        else if($data['score'] < $passing_marks)
        {
            $data['score'] = $data['score'] . " / FAIL";
        }


        $i = 0;
        foreach ($data as $column) {
            $i++;
            if ($i <= 5)
                continue;
            else if ($i == 6)
                $pdf->Cell(15, 12, $column, 1, 0, 'C');
            else if ($i == 7)
                $pdf->Cell(75, 12, $column, 1, 0, 'C');
            else if ($i == 11) {
                if ($column == 'ABSENT') {
                    $pdf->SetTextColor('255', '0', '0');
                }
                $pdf->Cell(25, 12, $column, 1, 0, 'C');
                $pdf->SetTextColor('0', '0', '0');


            } else
                $pdf->Cell(25, 12, $column, 1, 0, 'C');

        }
    }
    $pdf->Output('D', 'Result-' . $eid . '.pdf');
}


if (isset($_GET['export-result']) && $_GET['export-result'] == 1 && isset($_GET['eid']) && isset($_GET['year']) && isset($_GET['dept'])) {
    $eid = hex2bin($_GET['eid']);
    $year = hex2bin($_GET['year']);
    $dept = hex2bin($_GET['dept']);

    if ($year == '3')
        $query = "SELECT `faculty`.`faculty_name`, `exam_data`.`exam_date`,`exam_data`.`eid`,`exam_data`.`exam_marks`, `exam_data`.`passing_marks`, `student_data_3_2019_2020`.`rollno`, `student_data_3_2019_2020`.`name`, `attempts`.`start_time`, `submission_time`, `isForcedSubmit`, `score` from `student_data_3_2019_2020` LEFT JOIN `attempts` on `student_data_3_2019_2020`.contact_no = attempts.sid AND `attempts`.`eid`= :eid INNER JOIN `exam_data` ON exam_data.eid = :eid2 INNER JOIN `faculty` ON `faculty`.`fid` = `exam_data`.`concerned_faculty` WHERE `student_data_3_2019_2020`.`dept` = :dept ORDER BY `student_data_3_2019_2020`.`rollno` ASC";
    else if ($year == '2')
        $query = "SELECT `faculty`.`faculty_name`, `exam_data`.`exam_date`,`exam_data`.`eid`,`exam_data`.`exam_marks`, `exam_data`.`passing_marks`, `student_data_2_2019_2020`.`rollno`, `student_data_2_2019_2020`.`name`, `attempts`.`start_time`, `submission_time`, `isForcedSubmit`, `score` from `student_data_2_2019_2020` LEFT JOIN `attempts` on `student_data_2_2019_2020`.contact_no = attempts.sid AND `attempts`.`eid`= :eid INNER JOIN `exam_data` ON exam_data.eid = :eid2 INNER JOIN `faculty` ON `faculty`.`fid` = `exam_data`.`concerned_faculty` WHERE `student_data_2_2019_2020`.`dept` = :dept ORDER BY `student_data_2_2019_2020`.`rollno` ASC";

    $result = query($query, ['eid' => $eid, 'eid2' => $eid, 'dept' => $dept]);
    $count = $result->rowCount();
    if ($count <= 0) {
        header("location:../../admin/all-exams/");
    } else
        exportPdf($result);
} else {
    header("location:../../admin/all-exams/");
}

