<?php
session_start();
include('dbcon.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
function  resend_email_verify($name, $email,$verify_token)
{
    $mail = new PHPMailer(true);
    // $mail->SMTPDebug =2;
    $mail->isSMTP();
    $mail->SMTPAuth = true;

    $mail->Host ="smtp.gmail.com";
    $mail->Username="gauravgauravbasnet@gmail.com";
    $mail->Password="dgga vecb cccr ypik";

    $mail->SMTPSecure ="tls";
    $mail->Port =587;

    $mail->setFrom("gauravgauravbasnet@gmail.com",$name);
    $mail->addAddress($email);
    
    $mail->isHTML(true);
    $mail->Subject="Resend-Email Verification From Gaurav";

    $email_template="
    <h2>You Have Registered With Our Verification Method</h2>
    <h5>Verify your email address to Login with the given below link</h5>
    <br><br/>
    <a href='http://localhost/LoginSystem/verify-email.php?token=$verify_token'>Click Me </a>
    ";
    $mail->Body =$email_template;
    $mail->send();
}
    if(isset($_POST['resend_login_btn']))
    {
        if(!empty(trim($_POST['email'])))
        {
            $email = mysqli_real_escape_string($con, $_POST['email']);
            $checkemail_query= "SELECT * FROM users WHERE email = '$email'LIMIT 1";
            $checkemail_query_run = mysqli_query($con, $checkemail_query);
            if(mysqli_num_rows($checkemail_query_run)>0){
                $row = mysqli_fetch_array($checkemail_query_run);
                if($row['verify_status']=='0')
                {
                    $name=$row['name'];
                    $email= $row['email'];
                    $verify_token=$row['verify_token'];
                    resend_email_verify($name, $email,$verify_token);
                    $_SESSION['status']="Link has been sent to your email address";
                    header("Location: resend_email_verification.php");
                    exit(0);    
                }
                else{
                    $_SESSION['status']="Email Already Verified";
                header("Location: login.php");
                exit(0); 
                }

            }
            else{
                $_SESSION['status']="Please register email first";
                header("Location: register.php");
                exit(0);
            }
        }
        else{
            $_SESSION['status']="Please enter email";
            header("Location: resend_email_verification.php");
            exit(0);
        }
        
    }

?>