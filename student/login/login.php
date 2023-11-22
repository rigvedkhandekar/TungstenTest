<?php
use Nullix\CryptoJsAes\CryptoJsAes;
include '../../util/config.php';
require '../../util/CryptoJsAes.php';
require '../../util/AeshHash.php';

session_start ();
session_destroy ();

if (isset ($_POST['submit-login']) && is_numeric($_POST['submit-login']))
{

    $rollno = $_POST['rollno'];
    $dept = $_POST['dept'];
    $year = $_POST['year'];

    if ($year == "3rd")
        $query = "SELECT * from `student_data_3_2019_2020` where `rollno` = :rollno AND `dept` = :dept";

    else
        $query = "SELECT * from `student_data_2_2019_2020` where `rollno` = :rollno AND `dept` = :dept";

    $stmt = $pdo->prepare($query);
    $stmt->execute(['rollno' => $rollno, 'dept' => $dept]);
    $result = $stmt->fetch();

    if ($stmt->rowCount() == 1 && !(is_null($result['contact_no'])))
    {
        //$contact_no = CryptoJsAes::encrypt($result['contact_no'], AesHash::$salt);
        $contact_no = $result['contact_no'];
        
        echo json_encode(array(
            'success' => '1',
            'contact_no' => $contact_no
        ));



    }

    else
        var_dump(http_response_code(409));


}


?>