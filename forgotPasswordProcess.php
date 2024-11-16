<?php

require "connection.php";

include "SMTP.php";
include "PHPMailer.php";
include "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

if (isset($_GET["e"]) && isset($_GET["acc_type"])) {

    $email = $_GET["e"];
    $acc_type = $_GET["acc_type"];

    if (empty($email)) {
        echo ("Please enter the email");
    } else if (strlen($email) > 100) {
        echo ("Email should be less than 100 characters");
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo ("Invalid Email");
    } else {

        if($acc_type == "user"){
            $result_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "'");
        }else{
            $result_rs = Database::search("SELECT * FROM `admin` WHERE `email`='" . $email . "'");
        }

        if ($result_rs->num_rows == 1) {
            $code = uniqid();

            if($acc_type == "user"){
                Database::iud("UPDATE `user` SET `verification_code` = '" . $code . "' 
                WHERE `email` = '" . $email . "'");
            }else{
                Database::iud("UPDATE `admin` SET `verification_code` = '" . $code . "' 
                WHERE `email` = '" . $email . "'");
            }

            $mail = new PHPMailer;
            $mail->IsSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'varshhari0@gmail.com';
            $mail->Password = 'psuvjmkjhiwooyee';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom('raviduyashith123@gmail.com', 'Reset Password'); 
            $mail->addReplyTo('raviduyashith123@gmail.com', 'Reset Password'); 
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Musicate Forgot Password Verification Code';
            $bodyContent = '<span>Your Verification code is <br/>' . $code . '<br/>. Please donot share this with anyone. If you did not request this somebody might be trying to log into your account. Please take the necessary steps to secure your account.</span>';
            $mail->Body    = $bodyContent;

            if(!$mail->send()){
                echo("Verification Code sending failed. Please try again");
            }else{
                echo("success");
            }

        } else {
            echo ($acc_type=="user"?"You are not a valid user":"You are not a valid admin");
        }
    }
} else {
    echo ("Something went wrong. Please try again");
}
