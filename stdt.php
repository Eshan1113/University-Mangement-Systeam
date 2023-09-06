<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="style1.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details Page</title>
    
    <link rel="stylesheet" href="css\bootstrap\css\bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    
</head>
<body style="background: url(img/11.jpg); background-size: cover; ">
<div class="container my-5">
    <h2 style ="color:white;">Student Details</h2>
    <a href="stdt1.php" class="btn btn-primary">
  <i class="bi bi-house-door-fill"></i>Back</a>
    <a href="index.php" class="btn btn-danger">
  <i class="bi bi-house-door-fill"></i>Logout
</a>
    <br>
    <table class="table">
        <thead class="table-dark">
            <tr>
                <th>INDEX NUMBER</th>
                <th>Name</th>
                <th>Age</th>
                <th>E-mail</th>
                <th>Degree Program</th>
                <th>Edit & Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include_once('db_conn.php');
            $db_conn = connection();
            
            $query = "SELECT * FROM student_tb";
            $result = mysqli_query($db_conn, $query);
            
            while ($row = $result->fetch_assoc()) {
                echo "
                    <tr  class='table-primary'>
                        <td>{$row['stid']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['age']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['dgname']}</td>
                        <td>
                            <a class='btn btn-primary btn-sm' href='Update.php?stid={$row['stid']}'>Update</a>
                            <a class='btn btn-danger btn-sm' href='stdtdelete.php?stid={$row['stid']}'>Delete</a>
                        </td>
                    </tr>";
                
            }
            ?>
            
        </tbody>
    </table>
</div>



</body>
</html>