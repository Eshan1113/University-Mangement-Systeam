<?php
include_once('db_conn.php');
$db_conn = connection();

$id = "";
$name = "";
$age = "";
$email = "";


$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (!isset($_GET["id"])) {
        header('Location:admin.php');
        exit;
    }

    $id = $_GET["id"];

    $insertSql = "SELECT * FROM student_tb WHERE Id=$id";
    $sqlresult = $db_conn->query($insertSql);

    if ($sqlresult->num_rows > 0) {
        $row = $sqlresult->fetch_assoc();

        $name = $row['name'];
        $age = $row['age'];
        $email = $row['email'];
      
    }
}else {
        $id = $_POST["id"];
        $name = $_POST['name'];
        $age = $_POST['age'];   
        $email = $_POST['email']; 
    
        do {
            if (empty($name) || empty($age) || empty($email)) {
                $errorMessage = "All the fields are required";
                break;
            }
            $insertSql = "UPDATE student_tb" .
                " SET name = '$name', age = '$age', email = '$email'" .
                " WHERE id = $id";
    
            $sqlresult = $db_conn->query($insertSql);
    
            if (!$sqlresult) {
                $errorMessage = "Invalid query: " . $db_conn->error;
                break;
            }
    
            $successMessage = "Client updated correctly!";
        } while (false);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Update Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
          <style>
        label{
            color:white;
            font-weight:bolder;
        }
      
    </style>
        </head>
        <body style="background: url(img/9.jpg); background-size: cover; ">
<div class="container my-5">
    <h2 style= "color: white ;font-size: 30px; text-align: center; font-weight:bolder">Update Student Details</h2>
    <br>
    <?php
    if (!empty($errorMessage)) {
        echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>$errorMessage</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }
    ?>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Name</label>
            <div class="col-sm-6">
                <input type="text" name="name" id="name" class="form-control" value="<?php echo $name; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">AGE</label>
            <div class="col-sm-6">
                <input type="age" name="age" id="age" class="form-control"
                       value="<?php echo $age; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-6">
                <input type="email" name="email" id="email" class="form-control"
                       value="<?php echo $email; ?>">
            </div>
        </div>

        <?php
        if (!empty($successMessage)) {
            echo "
            <div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>$successMessage</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
        ?>


        <div class="row mb-3">
            <div class="offset-sm-3 col-sm-3 d-grid">
                <button type="submit" class="btn btn-success" value="">Submit</button>
            </div>
            <div class="col-sm-3 d-grid">
                <a class="btn btn-primary" href="stdt.php" role="button">Cancel</a>
            </div>
        </div>

    </form>
    

</div>
</body>
</html>