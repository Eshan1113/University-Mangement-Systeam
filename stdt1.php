<?php
include_once('db_conn.php');
$db_conn = connection();

$stid = "";
$name = "";
$age = "";
$email = "";
$dgname = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stid = $_POST["stid"];
    $name = $_POST["name"];
    $age = $_POST["age"];
    $email = $_POST["email"];
    $dgname = $_POST["dgname"];

    do {
        if (empty($stid) || empty($name) || empty($age) || empty($email) || empty($dgname)) {
            $errorMessage = "All the fields are required";
            break;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = "Invalid email address";
            break;
        }
        $checkStidQuery = "SELECT stid FROM student_tb WHERE stid = '$stid'";
        $resultStid = $db_conn->query($checkStidQuery);

        if ($resultStid->num_rows > 0) {
            $errorMessage = "Index Number already exists.";
            break;
        }
        $checkEmailQuery = "SELECT email FROM student_tb WHERE email = '$email'";
        $resultEmail = $db_conn->query($checkEmailQuery);

        if ($resultEmail->num_rows > 0) {
            $errorMessage = "Email address already exists.";
            break;
        }

        $insertSql = "INSERT INTO student_tb(stid, name ,age, email,dgname) 
        VALUES ('$stid', '$name', '$age', '$email','$dgname')";

        $sqlresult = $db_conn->query($insertSql);

        if (!$sqlresult) {
            $errorMessage = "Invalid query: " . $db_conn->error;
            break;
        }

        $stid = "";
        $name = "";
        $age = "";
        $email = "";
        $dgname = "";

        $successMessage = "User added correctly";

    } while (false);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Add Page</title>
    <link rel="stylesheet" href="style1.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        label{
            color:white;
            font-weight:bolder;
        }
        h2{
            color:white;
            text-align:center;
        }
    </style>
    <script>
      
        function showSuccessMessage(message) {
            var successDiv = document.createElement("div");
            successDiv.className = "alert alert-success alert-dismissible fade show";
            successDiv.innerHTML = "<strong>" + message + "</strong><button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
            document.body.appendChild(successDiv);
        }

      
        <?php
        if (!empty($successMessage)) {
            echo "showSuccessMessage('$successMessage');";
        }
        ?>
    </script>
</head>
<body style="background: url(img/10.jpg); background-size: cover; background-position: center;">
    <div class="container my-5">
        <h2>Add New Student</h2>
        <a href="admin.php" class="btn btn-primary">
            <i class="bi bi-house-door-fill"></i> Home
        </a>
        <a href="stdt.php" class="btn btn-warning">
            <i class="bi bi-house-door-fill"></i> View Student Details
        </a>

        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>$errorMessage</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
        ?>

        <br><br>

        <form method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Index Number</label>
                <div class="col-sm-6">
                    <input type="text" name="stid" id="stid" class="form-control" value="<?php echo $stid; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Student Name</label>
                <div class="col-sm-6">
                    <input type="text" name="name" id="name" class="form-control" value="<?php echo $name; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Student Age</label>
                <div class="col-sm-6">
                    <input type="text" name="age" id="age" class="form-control" value="<?php echo $age; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="text" name="email" id="email" class="form-control" value="<?php echo $email; ?>">
                </div>
            </div>
            <tr>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label"><td>Select Degree Program</td></label>
                    <td>
                        <div class="col-sm-6">
                            <select name="dgname" name="dgname" id="dgname" class="form-control" value="<?php echo $dgname; ?>">
                                <option value="BSc in INFORMATION TECHNOLOGY">BSc in Information Technology</option>
                                <option value="Bachelor of Business Management">Bachelor of Business Management (Hons)</option>
                                <option value="BA General Degree program">BA General Degree program</option>
                            </select>
                        </div>
                    </div>
                </tr>
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
                        <a class="btn btn-warning" href="admin.php" role="button">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </body>
    </html>