<?php 
session_start();
include('includes/header.php');
include('includes/navbar.php');
$page_title="Registration ";
?>
    <link rel="stylesheet" href="styles.css">
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
                        <h5>Registration</h5>
                    </div>
                    <div class="card-body">
                            <form id="registerForm"action="code.php" method="POST">
                                <div class="form-group mb-3 ">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">Email</label>
                                    <input type="text" class="form-control" name="email">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">Password</label>
                                    <input type="text" class="form-control" name="password">
                                </div>
                             
                                <div class="form-group">
                                    <button type="submit"class="btn btn-primary" name="register-btn"id="submitBtn">Register Now</button>
                                </div>
                                <div id="loader" class="loader" style="display: none;"></div>
                            </form>
                            <script src="scripts.js"></script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php');?>