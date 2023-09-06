<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="css\bootstrap\css\bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>ABC UNIVERSITY</title>
    <style>
.custom-navbar {
      background-color: rgba(119, 67, 219, 0.7); 
        }
    .custom-navbar .navbar-brand {
        color: #fff;
        padding-right: 20px;
        }
    .custom-navbar .nav-link {
        color: #fff ;
        }
    #showcase h1{
            color: #F9F9F9; 
            
        }
     body {
        background-size: cover;
        background-position: center;
        transition: background-image 1s ease-in-out;
           
        }
    .check-result-button {
        background-color: #F31559; 
        color: #fff ; 
        border: none;
    padding: 10px 20px;
    border-radius: 5px; 
    transition: background-color 0.3s ease-in-out; 
    text-decoration: none; 
}

.check-result-button:hover {
    background-color: #0056b3; 
    color: #fff; 
}
#admin-login-link:hover,
#teacher-login-link:hover {
    color: #0056b3; 
}
.navbar-nav .nav-item {
    margin-right: 20px;
}

</style>    
</head>
<body style="background-image: url('img/4.jpg'); overflow: hidden;">

<nav class="navbar navbar-expand-lg navbar-light custom-navbar fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">ABC UNIVERSITY</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Login
                    </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
    <li><a id="admin-login-link" class="dropdown-item" href="main.php">Admin Login & Teacher Login</a></li>
    
</ul>
            </ul>
            <ul class="navbar-nav">
            <a class="nav-link check-result-button" href="checkresult.php">Check Your Result</a>
            </ul>
        </div>
    </div>
</nav>

<header id="showcase">
    <h1>Welcome To ABC UNIVERSITY</h1>
    <h1>Learning Management System</h1>
</header>

<script>
    
    const backgroundImages = ["img/12.jpg","img/10.jpg","img/11.jpg","img/13.jpg"];
    let currentImageIndex = 0;

    function changeBackgroundImage() {
        document.body.style.backgroundImage = `url(${backgroundImages[currentImageIndex]})`;
        currentImageIndex = (currentImageIndex + 1) % backgroundImages.length;
    }

    
    changeBackgroundImage();

    
    setInterval(changeBackgroundImage, 5000);
</script>
</body>
</html>
