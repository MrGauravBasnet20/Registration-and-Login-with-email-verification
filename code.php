<?php
// Start the session to store status messages
session_start();

// Include the database connection file
include ('dbcon.php');

// Use PHPMailer for sending email
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

/**
 * Sends an email verification link to the user's email address
 *
 * @param string $name The name of the recipient
 * @param string $email The recipient's email address
 * @param string $verify_token The token used for email verification
 */
function sendemail_verify($name, $email, $verify_token)
{
    $mail = new PHPMailer(true);
    // $mail->SMTPDebug = 2; // Enable verbose debug output
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->SMTPAuth = true; // Enable SMTP authentication

    // SMTP server configuration
    $mail->Host = "smtp.gmail.com";
    $mail->Username = "gauravgauravbasnet@gmail.com";
    $mail->Password = "dgga vecb cccr ypik";

    $mail->SMTPSecure = "tls"; // Enable TLS encryption
    $mail->Port = 587; // TCP port to connect to

    // Email sender and recipient configuration
    $mail->setFrom("gauravgauravbasnet@gmail.com", $name);
    $mail->addAddress($email);

    // Email content configuration
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = "Email Verification From Gaurav";

    // Email template
    $email_template = "
    <h2>You Have Registered With Our Verification Method</h2>
    <h5>Verify your email address to login with the link below</h5>
    <br><br/>
    <a href='http://localhost/LoginSystem/verify-email.php?token=$verify_token'>Click Me</a>
    ";
    $mail->Body = $email_template;

    // Send the email
    $mail->send();
    // echo 'Message has been sent';
}

/**
 * Validates the password according to given criteria
 *
 * @param string $password The password to validate
 * @return bool Returns true if the password meets the criteria, false otherwise
 */
function validate_password($password) {
    // Check if the password is at least 8 characters long and contains at least one letter
    if (strlen($password) >= 8 && preg_match('/[a-zA-Z]/', $password)) {
        return true;
    } else {
        return false;
    }
}

// Check if the registration form is submitted
if (isset($_POST['register-btn'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $verify_token = md5(rand()); // Generate a random verification token

    // Validate the password
    if (!validate_password($password)) {
        $_SESSION['status'] = "Password must be at least 8 characters long and contain at least one letter.";
        header("Location: register.php");
        exit();
    }

    // Check if the email already exists in the database
    $check_email_query = "SELECT email FROM users WHERE email='$email' LIMIT 1";
    $check_email_query_run = mysqli_query($con, $check_email_query);
    if (mysqli_num_rows($check_email_query_run) > 0) {
        $_SESSION['status'] = "Email id already exists";
        header("Location: register.php");
    } else {
        // Insert the user data into the users table
        $query = "INSERT INTO users (name, email, password, verify_token) VALUES ('$name', '$email', '$password', '$verify_token')";
        $query_run = mysqli_query($con, $query);
        if ($query_run) {
            // Send the email verification link
            sendemail_verify($name, $email, $verify_token);
            $_SESSION['status'] = "Registration Successful! The link has been sent to your email address";
            header("Location: register.php");
        } else {
            $_SESSION['status'] = "Registration Failed";
            header("Location: register.php");
        }
    }
}
?>
