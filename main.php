<?php
include_once('userFunction.php');


$loginMessage = ""; 

if (isset($_POST['btnlogin'])) {
    $login_email = $_POST['Login_email'];
    $login_pswrd = $_POST['Login_pswrd'];

    if (empty($login_email) || empty($login_pswrd)) {
       
        $loginMessage = "Email and password are required.";
    } else {
        $result = Authentication($login_email, $login_pswrd);

        if ($result === true) {
            
            $loginMessage = "Login successful. Redirecting...";
            
        } else {
            
            $loginMessage = "Login failed. Please check your email and password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css\bootstrap\css\bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
</head>
<body style="background: url(img/10.jpg);  background-size: cover; background-position: center;">
    <div class="container" style="margin-top: 2rem;">
        <div class="row justify-content-center">
            <div class="col-md-6 mt-6">
                <div class="card" style="background-color:rgba(0,0,0,.55);">
                    <div class="card-header">
                        <style>
                            .form-group label {
            color: #FFFFFF; 
        }
                            h3 {
                                color: white;
                            }
                        </style>
                        <br>
                        <center><h3>Admin Page</h3></center>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="form-group mt-2">
                                <label for="">Enter e-mail</label>
                                <input type="text" name="Login_email" id="email" class="form-control">
                            </div>
                            <div class="form-group mt-2">
                                <label for="">Enter password</label>
                                <input type="password" name="Login_pswrd" id="password" class="form-control">
                                <br>
                            </div>
                            <div class="form-group mt-2">
                                <input type="submit" value="Login" name="btnlogin" class="btn btn-outline-info">
                                <input type="reset" value="Reset" name="btnlogin" class="btn btn-outline-warning">
                               
                            </div>
                            <br><br><br><br><br>
                            <?php
                            
                            if (!empty($loginMessage)) {
                                echo '<div class="alert alert-danger">' . $loginMessage . '</div>';
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   
    <footer class="footer  d-flex flex-column-reverse align-items-center" id="contact">
        <div class="credit">
            <h3>Created by<span>Eshan Dananjaya</span> |all rights reserved !</h3> 
        </div>
     
    </footer>
</body>
</html>