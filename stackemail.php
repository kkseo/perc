<?php
require_once(__DIR__.'/phpmailer/PHPMailer.php');
require_once(__DIR__.'/phpmailer/Exception.php');
require_once(__DIR__.'/phpmailer/SMTP.php');

//include_once('/../phpmailer/Exception.php');

//include_once('/phpmailer/SMTP.php');
if(isset($_FILES['uploaded_file'])){

    //$errors= array();
    $file_name = $_FILES['uploaded_file']['name'];
    $file_size = $_FILES['uploaded_file']['size'];
    $file_tmp = $_FILES['uploaded_file']['tmp_name'];
    $file_type = $_FILES['uploaded_file']['type'];
    $file_name_array = explode('.',$file_name);
    $file_ext = strtolower(end($file_name_array));
	
    $expensions= array("jpeg","jpg","png","pdf","doc","docx","ppt","txt");

    if(in_array($file_ext,$expensions)=== false){
        $errors[]="extension not allowed, please choose a PDF, JPEG or PNG file.";
    }

    if($file_size > 2097152) {
        $errors[]='File size must be excately 2 MB';
    }

    if(empty($errors)==true) {
        move_uploaded_file($file_tmp,$file_name); //The folder where you would like your file to be saved
        echo "Success";
    }else{
        print_r($errors);
    }
}

// PHPMailer script below

$email = $_POST['email'] ;
$name = $_POST['name'] ;
$phone = $_POST['number'] ;


//use PHPMailer\PHPMailer\PHPMailer;
//require(class.PHPMailer.php);
//require('phpmailer/Exception.php');
$mail = new \PHPMailer\PHPMailer\PHPMailer();

$mail->IsSMTP();

$mail->Host = "smtp.gmail.com";

$mail->SMTPAuth = true;
$mail->Username = "percmailer@gmail.com"; // SMTP username
$mail->Password = "Illustrator2018"; // SMTP password
$mail->addAttachment($file_name);
$mail->From = $email;
$mail->SMTPSecure = 'tls';
$mail->Port = 587; //SMTP port
$mail->addAddress("percmailer@gmail.com", "percmailer");
$mail->Subject = "You have an email from a website visitor!";
$mail->Body ="Name".$name."\n"."Email address".$email."\n"."You received cv file from customer now";
//$mail->AltBody = $message;

if(!$mail->Send())
{
    echo "Message could not be sent///. <p>";
    echo "Mailer Error: " . $mail->ErrorInfo;
    exit;
}

echo "<script>alert('Message has been sent')</script>";
?>