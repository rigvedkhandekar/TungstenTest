<?php

include '../../util/config.php';
include '../../util/util.php';

session_start ();
session_destroy ();

if (isset ($_POST['submit-login']) && $_POST['submit-login'] == 1 && $_POST['input_email'] && $_POST['input_password'])
{
    $email = $_POST['input_email'];
    $password = md5($_POST['input_password']);

    $query = "SELECT * from `faculty` where `faculty_email` = :email AND faculty_password = :password";
    $result = query($query,['email'=>$email,'password'=>$password]);
    $data = $result->fetch();

    if ($result->rowCount() > 0)
    {
        session_start ();
        $_SESSION['faculty']=true;
        $_SESSION['faculty-session']['key'] = $data['fid'];
        echo json_encode(array('login-success'=>true));
    }

    else
    {
        var_dump(http_response_code(409));
    }
}

?>
