<?php
session_start();
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
                        <h5>Change Password</h5>
                    </div>
                    <div class="card-body">
                            <form action="password_reset_code.php" method="POST">
                                <input type="text"value="<?php if(isset($_GET['token'])){echo $_GET['token'];}?> "name="password_token">
                                <div class="form-group mb-3 ">

                                <div class="form-group mb-3">
                                    <label for="">Email Address</label>
                                    <input type="text" placeholder="Enter Email" class="form-control" name="email" value="<?php if(isset($_GET['email'])){echo $_GET['email'];}?> ">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">New Password</label>
                                    <input type="text" name="new_password" class="form-control" placeholder="New Password">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">Confirm Password</label>
                                    <input type="text" name="confirm_password" class="form-control" placeholder="Re-enter Password">
                                </div>
                             
                             
                                <div class="form-group mb-3">

                                    <button type="submit"class="btn btn-primary"name="password_update">Update Password</button>
                                
                                </div>
                            </form>
                          
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php');?>