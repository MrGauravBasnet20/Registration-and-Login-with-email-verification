<?php
session_start();
include('includes/header.php');
include('includes/navbar.php');
$page_title="Login Form";
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
                        <h5>Resend Email verification</h5>
                    </div>
                    <div class="card-body">
                            <form action="resend-code.php" method="POST">
                                <div class="form-group mb-3 ">
                           
                                <div class="form-group mb-3">
                                    <label for="">Email Address</label>
                                    <input type="text" class="form-control" name="email">
                                </div>
                             
                                <div class="form-group">
                                    <button type="submit"class="btn btn-primary"name="resend_login_btn">Send</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php');?>