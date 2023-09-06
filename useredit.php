<?php
include_once('db_conn.php');
$db_conn = connection();

$id = "";
$Login_email = "";
$Login_role = "";
$age = "";
$nic = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (!isset($_GET["id"])) {
        header('Location: userdt.php');
        exit;
    }

    $id = $_GET["id"];

    $selectSql = "SELECT * FROM login_tb WHERE Id=$id";
    $sqlresult = $db_conn->query($selectSql);

    if ($sqlresult->num_rows > 0) {
        $row = $sqlresult->fetch_assoc();

        $Login_email = $row['Login_email'];
        $Login_role = $row['Login_role'];
        $age = $row['age'];
        $nic = $row['nic'];
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST["id"];
    $Login_email = $_POST['Login_email'];
    $Login_role = $_POST['Login_role'];
    $age = $_POST["age"];
    $nic = $_POST["nic"];

    if (empty($Login_email) || empty($Login_role) || empty($age) || empty($nic)) {
        $errorMessage = "All the fields are required";
    } else {
        $updateSql = "UPDATE login_tb" .
            " SET Login_email = '$Login_email', Login_role = '$Login_role', age = '$age', nic = '$nic'" .
            " WHERE id = $id";

        $sqlresult = $db_conn->query($updateSql);

        if (!$sqlresult) {
            $errorMessage = "Invalid query: " . $db_conn->error;
        } else {
            $successMessage = "Client updated correctly!";
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
    <title>User Upadte Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        label {
            color: white;
            font-weight: bolder;
        }
    </style>
</head>
<body style="background: url(img/9.jpg); background-size: cover; ">
<div class="container my-5">
    <h2 style="color: white; font-size: 30px; text-align: center; font-weight: bolder">Update Details</h2>
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
            <label class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-6">
                <input type="email" name="Login_email" id="Login_email" class="form-control"
                       value="<?php echo $Login_email; ?>">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Login Role</label>
            <div class="col-sm-6">
                <input type="text" name="Login_role" id="Login_role" class="form-control"
                       value="<?php echo $Login_role; ?>">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Age</label>
            <div class="col-sm-6">
                <input type="text" name="age" id="age" class="form-control" value="<?php echo $age; ?>">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">NIC Number</label>
            <div class="col-sm-6">
                <input type="text" name="nic" id="nic" class="form-control" value="<?php echo $nic; ?>">
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
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
            <div class="col-sm-3 d-grid">
                <a class="btn btn-danger" href="userdt.php" role="button">Cancel</a>
            </div>
        </div>
    </form>
    
</div>
</body>
</html>
