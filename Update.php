<?php
include_once('db_conn.php');
$db_conn = connection();

$stid = "";
$name = "";
$age = "";
$email = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (!isset($_GET["stid"])) {
        header('Location: admin.php');
        exit;
    }

    $stid = $_GET["stid"];

    $insertSql = "SELECT * FROM student_tb WHERE stid=?";
    $stmt = $db_conn->prepare($insertSql);
    $stmt->bind_param("i", $stid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $name = $row['name'];
        $age = $row['age'];
        $email = $row['email'];
    }
} else {
    $stid = $_POST["stid"];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $email = $_POST['email'];

    do {
        if (empty($stid) || empty($name) || empty($age) || empty($email)) {
            $errorMessage = "All the fields are required";
            break;
        }

        $updateSql = "UPDATE student_tb SET name=?, age=?, email=? WHERE stid=?";
        $stmt = $db_conn->prepare($updateSql);
        $stmt->bind_param("sssi", $name, $age, $email, $stid);
        $stmt->execute();

        if ($stmt->error) {
            $errorMessage = "Invalid query: " . $stmt->error;
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
    <meta name="viewport" content="wstidth=device-wstidth, initial-scale=1.0">
    <title>Admin</title>
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
        <body style="background: url(img/19.jpg); background-size: cover; ">
<div class="container my-5">
    <h2 style= "color: white ;font-size: 30px; text-align: center; font-weight:bolder">Update Details</h2>
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
        <input type="hidden" name="stid" value="<?php echo $stid; ?>">
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Name</label>
            <div class="col-sm-6">
                <input type="text" name="name" stid="name" class="form-control" value="<?php echo $name; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Age</label>
            <div class="col-sm-6">
                <input type="age" name="age" stid="age" class="form-control"
                       value="<?php echo $age; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-6">
                <input type="text" name="email" stid="email" class="form-control"
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
            <div class="offset-sm-3 col-sm-3 d-grstid">
                <button type="submit" class="btn btn-success" value="">Submit</button>
                <a class="btn btn-primary" href="admin.php" role="button">Cancel</a>
            </div>
            
        </div>

    </form>
 

</div>
</body>
</html>