<?php
session_start();
include ('dbcon.php');
if (isset($_POST['login_btn'])) {

    if (!empty(trim($email = $_POST['email'])) && $password = $_POST['password']) {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $login_query = "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1";
        $login_query_run = mysqli_query($con, $login_query);

        if (mysqli_num_rows($login_query_run) > 0) {
            $row = mysqli_fetch_array($login_query_run);

            if ($row['verify_status'] == "1") {
                $_SESSION['authenticated'] = TRUE;
                $_SESSION['auth_user'] = [
                    'username' => $row['name'],
                    'email' => $row['email'], ];
                $_SESSION['status'] = "You are Logged in succesfully";
                header("Location: dashboard.php");
                exit(0);
            }
             else {
                $_SESSION['status'] = "Email Not Verified";
                header("Location: login.php");
                exit(0);
            }

        } else {
            $_SESSION['status'] = "Invalid Email Or Password";
            header("Location: login.php");
            exit(0);
        }

    } else {
        $_SESSION['status'] = "All Fields Are Required";
        header("Location: login.php");
        exit(0);
    }

} else {

}
?>