<?php
session_start();

if (isset($_SESSION['successMessage'])) {
    $successMessage = $_SESSION['successMessage'];
    unset($_SESSION['successMessage']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="style1.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>

    <link rel="stylesheet" href="css\bootstrap\css\bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

</head>
<br>
<body style="background: url(img/18.jpg); background-size: cover; ">
<br>

    <div class="container my-5">
        <h2 style="color:white;">Student Details</h2>
        <a href="teacherpn.php" class="btn btn-primary">
            <i class="bi bi-house-door-fill"></i>Back
        </a>
        <a href="teacherviwe.php" class=" btn btn-success">
            <i class="btn-sm"></i>View Result </a>
        <a href="index.php" class="btn btn-danger">
            <i class="bi bi-house-door-fill"></i>Logout
        </a>
        <br>
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th>INDEX NUMBER</th>
                    <th>Name</th>
                    <th>Degree Program</th>
                    <th>Add Result</th>
                   
                    
                </tr>
            </thead>
            <tbody>
                <?php
                include_once('db_conn.php');
                $db_conn = connection();

               
                if (isset($_GET['stid']) && is_numeric($_GET['stid'])) {
                    $stid = $_GET['stid'];
                    $query = "SELECT * FROM student_tb WHERE stid = $stid";
                } else {
                    
                    $query = "SELECT * FROM student_tb";
                }

                $result = mysqli_query($db_conn, $query);

                while ($row = $result->fetch_assoc()) {
                    echo "
                        <tr class='table-primary'>
                            <td>{$row['stid']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['dgname']}</td>
                            <td>
                                <a class='btn btn-primary btn-sm' href='teacherad.php?id={$row['stid']}'>Add Result</a>
                            </td>
                            
                            
                        </tr>";
                }
                ?>

            </tbody>
        </table>
    </div>
</body>
</html>