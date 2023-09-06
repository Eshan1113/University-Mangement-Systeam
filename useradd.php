<?php
include_once('db_conn.php');
$db_conn = connection();

$Login_email = "";
$Login_pswrd = "";
$Login_role = "";
$age = "";
$nic = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Login_email = $_POST["Login_email"];
    $Login_pswrd = $_POST["Login_pswrd"];
    $Login_role = $_POST["Login_role"];
    $age = $_POST["age"];
    $nic = $_POST["nic"];

    if (empty($Login_email) || empty($Login_pswrd) || empty($Login_role) || empty($age) || empty($nic)) {
        $errorMessage = "All fields are required.";
    } else {
        
        $checkEmailSql = "SELECT * FROM login_tb WHERE Login_email = ?";
        $checkEmailStmt = $db_conn->prepare($checkEmailSql);
        $checkEmailStmt->bind_param("s", $Login_email);
        $checkEmailStmt->execute();
        $checkEmailResult = $checkEmailStmt->get_result();

        if ($checkEmailResult->num_rows > 0) {
            $errorMessage = "User with this email already exists.";
        } else {
          
            $checkNicSql = "SELECT * FROM login_tb WHERE nic = ?";
            $checkNicStmt = $db_conn->prepare($checkNicSql);
            $checkNicStmt->bind_param("s", $nic);
            $checkNicStmt->execute();
            $checkNicResult = $checkNicStmt->get_result();

            if ($checkNicResult->num_rows > 0) {
                $errorMessage = "User with this NIC number already exists.";
            } else {
                $insertSql = "INSERT INTO login_tb (Login_email, Login_pswrd, Login_role, age, nic) 
                VALUES (?, ?, ?, ?, ?)";

                $insertStmt = $db_conn->prepare($insertSql);
                $insertStmt->bind_param("sssss", $Login_email, $Login_pswrd, $Login_role, $age, $nic);

                if ($insertStmt->execute()) {
                    $successMessage = "User added successfully.";
                } else {
                    $errorMessage = "Error adding user: " . $db_conn->error;
                }
            }
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\bootstrap\css\bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>User ADD Page </title>
    <style>
    body {
        background-image: url('img/13.jpg');
        background-size: 100%;
        overflow: hidden;

    }
    label {
        color: white;
        font-weight: bolder;
    }

    h2 {
        color: white;
        text-align: center;
    }
</style>
</head>
<body>
    <div class="container my-5">
        <h2>New User</h2><a href="admin.php" class="btn btn-primary">
  <i class="bi bi-house-door-fill"></i> Home</a>
  <a href="userdt.php" class="btn btn-warning">
  <i class="bi bi-house-door-fill"></i>Viwe User & Admin Details</a>
  
       
  <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>$errorMessage</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }

       
        ?>

        <br>
        <br>
        <form method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                <input type="email" name="Login_email" id="Login_email" class="form-control" value="<?php echo $Login_email; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-6">
                <input type="password" name="Login_pswrd" id="Login_pswrd" class="form-control" value="<?php echo $Login_pswrd; ?>">
                </div>
            </div>
            <div class="row mb-3">
    <label class="col-sm-3 col-form-label">Login Role</label>
    <div class="col-sm-6">
        <select name="Login_role" id="Login_role" class="form-control">
            <option value="user" <?php if ($Login_role == 'user') echo ' $Login_role; ?'; ?>>User</option>
            <option value="admin" <?php if ($Login_role == 'admin') echo ' $Login_role; ?'; ?>>Admin</option>
        </select>
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
            if(!empty($successMessage)){
                echo"
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
                    <a class="btn btn-danger" href="admin.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
    <script>
    function validateForm() {
        var email = document.getElementById("Login_email").value;
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (email === "") {
            alert("Email is required.");
            return false;
        } else if (!emailRegex.test(email)) {
            alert("Invalid email address format.");
            return false;
        }

        return true;
    }
</script>
</body>
</html>