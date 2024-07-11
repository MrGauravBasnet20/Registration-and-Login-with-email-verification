<?php
session_start();
    include("dbcon.php");
    use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
function send_password_reset($get_name, $get_email,$token){
    $mail = new PHPMailer(true);
    // $mail->SMTPDebug =2;
    $mail->isSMTP();
    $mail->SMTPAuth = true;

    $mail->Host ="smtp.gmail.com";
    $mail->Username="gauravgauravbasnet@gmail.com";
    $mail->Password="dgga vecb cccr ypik";

    $mail->SMTPSecure ="tls";
    $mail->Port =587;

    $mail->setFrom("gauravgauravbasnet@gmail.com",$get_name);
    $mail->addAddress($get_email);
    
    $mail->isHTML(true);
    $mail->Subject="Reset Password";

    $email_template="
    <h2>You Have Registered With Our Verification Method</h2>
    <h5>You are receiving this email because we received a password reset request from your account</h5>
    <br><br/>
    <a href='http://localhost/LoginSystem/password_change.php?token=$token&email=$get_email'>Click Me </a>
    ";
    $mail->Body =$email_template;
    $mail->send();
}
    if(isset($_POST['password_reset_link'])){
        $email= mysqli_real_escape_string($con, $_POST['email']);
        $token = md5(rand());
        $check_email="SELECT email FROM users WHERE email='$email' LIMIT 1";
        $check_email_run = mysqli_query($con, $check_email);

        if(mysqli_num_rows($check_email_run)>0)
        {
            $row = mysqli_fetch_array($check_email_run);
            $get_name= $row['name'];
            $get_email= $row['email'];

            $update_token= "UPDATE users SET verify_token='$token' WHERE email='$get_email'LIMIT 1";
            $update_query_run= mysqli_query($con, $update_token);
            if($update_query_run){

                    send_password_reset($get_name,$get_email,$token);
                    $_SESSION['status']= "Password reset link has been sent";
                    header("Location: password_reset.php");
                    exit(0);
            }
            else{
                $_SESSION['status']= "Something went wrong. #1";
                header("Location: password_reset.php");
                exit(0);
            }


        }
        else{
            $_SESSION['status']= "No Email Found";
            header("Location: password_reset.php");
            exit(0);

        }

    }

    if(isset($_POST['password_update'])){
        $email= mysqli_real_escape_string($con,$_POST['email']);
        $new_password= mysqli_real_escape_string($con,$_POST['new_password']);
        $confirm_password=mysqli_real_escape_string($con, $_POST['confirm_password']);
        $token= mysqli_real_escape_string($con,$_POST['password_token']);

        if(!empty($token) ){

            if(!empty($confirm_password) && !empty($new_password) && !empty($email)){

                //checking validity of token
                $check_token ="SELECT verify_token FROM users WHERE verify_token='$token' limit 1";
                $check_token_run = mysqli_query($con, $check_token);

                if(mysqli_num_rows($check_token_run)>0)
                {

                    if($new_password==$confirm_password)
                    {
                        $update_password="UPDATE users SET password = '$new_password' WHERE verify_token='$token' LIMIT 1";
                        $update_password_run=mysqli_query($con, $update_password);

                        if($update_password_run){
                            $_SESSION['status']= "Password Updated Succesfully!!";
                            header("Location: login.php");
                            exit(0);    
                        }
                        else{
                            $_SESSION['status']= "Something went wrong";
                            header("Location: password_change.php?token=$token&email=$email");
                            exit(0);
                        }
                    }
                    else{
                        $_SESSION['status']= "Both entered password should match";
                        header("Location: password_change.php?token=$token&email=$email");
                        exit(0);
                    }
                }
                else{
                    $_SESSION['status']= "Something went wrong";
                    header("Location: password_change.php?token=$token&email=$email");
                    exit(0);
                }

            }
            else{
                $_SESSION['status']= "All Field are required";
                header("Location: password_change.php?token=$token&email=$email");
                exit(0);
            }
        }
        else{
            $_SESSION['status']= "Please reclick the sent link in your gmail";
            header("Location: password_change.php?token=$token&email=$email");
            exit(0);
        }


    }
?>