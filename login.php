<?php
session_start();

if(isset($_SESSION['authenticated']))
{

    $_SESSION['status']="You are already logged in";
    header('Location:dashboard.php');
    exit(0);
}
include('includes/header.php');
include('includes/navbar.php');
$page_title="Login";
?>
<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
            <?php
                    if(isset($_SESSION['status']))
                    {
                        ?>
                        <div class="alert alert-success">
                            <h5><?= $_SESSION['status'];?></h5>
                        </div>
                        <?php
                        unset($_SESSION['status']);
                
                    }
                    ?>
                <div class="card shadow">
                    <div class="card-header">
                        <h5>Login</h5>
                    </div>
                    <div class="card-body">
                            <form action="logincode.php" method="POST">
                                <div class="form-group mb-3 ">
                           
                                <div class="form-group mb-3">
                                    <label for="">Email</label>
                                    <input type="text" class="form-control" name="email">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">Password</label>
                                    <input type="text" class="form-control" name="password">
                                </div>
                             
                                <div class="form-group">

                                    <button type="submit"class="btn btn-primary"name="login_btn">Login Now</button>
                                    <a href="password_reset.php"class="float-end">Forget Password?</a>
                                </div>
                            </form>
                            <hr>
                            <h6>
                                Didn't receive verification email?
                                <a href="resend_email_verification.php">Resend</a>
                            </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php');?>