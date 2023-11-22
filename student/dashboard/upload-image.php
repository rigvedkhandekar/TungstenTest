<?php
include '../../util/config.php';
include '../../util/check-student-session.php';

$sid = $_SESSION['student-session']['key'];

$folderPath = 'capture_images/';
$image_parts = explode(";base64,", $_POST['image']);
$image_type_aux = explode("image/", $image_parts[0]);
$image_type = $image_type_aux[1];
$image_base64 = base64_decode($image_parts[1]);
$file = $folderPath . $sid . '.png';
file_put_contents($file, $image_base64);
echo json_encode(["Image uploaded successfully."]);


?>
