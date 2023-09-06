<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <style>
        .custom-navbar {
            background-color: rgba(119, 67, 219, 0.7);
        }

        .custom-navbar .navbar-brand {
            color: #fff;
            padding-right: 20px;
        }

        body {
            background: url(img/bg.jpg);
            background-size: cover;
        }

        .card:hover {
        transform: scale(1.05); 
        transition: transform 0.2s ease-in-out;
    }

    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light custom-navbar fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a href="index.php" class="btn btn-danger">
            <i class="bi bi-house-door-fill"></i> Logout
        </a>
    </div>
</nav>
<br>
<br>
<br>

<div class="container mt-5 card-container">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-4 mb-4"> 
            <div class="card" style="background-color: #007BFF;">
                <img src="img/16.jpg" class="card-img-top" alt="User Image">
                <div class="card-body">
                    <h5 class="card-title" style="color: white;">Add User</h5>
                    <a href="useradd.php" class="btn btn-primary">Go to User Page</a>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-4 mb-4"> 
            <div class="card" style="background-color: #28a745;">
                <img src="img/15.jpg" class="card-img-top" alt="Student Image">
                <div class="card-body">
                    <h5 class="card-title" style="color: white;">Add Student</h5>
                    <a href="stdt1.php" class="btn btn-success">Go to Student Page</a>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-4 mb-4">  
            <div class="card" style="background-color: #ffc107;">
                <img src="img/17.jpg" class="card-img-top" alt="Marks Image">
                <div class="card-body">
                    <h5 class="card-title" style="color: white;">Add Student Marks</h5>
                    <a href="stdtmrks.php" class="btn btn-warning">Go to Marks Page</a>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<br>
<br>
<footer class="footer d-flex flex-column-reverse align-items-center" id="contact" style="background-color: ; color: #fff;">
    <div class="credit">
        <h3>Created by <span>Eshan Dananjaya</span> | All rights reserved!</h3>
    </div>
</footer>
</body>
</html>
