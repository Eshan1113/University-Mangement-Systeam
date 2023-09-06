<?php
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');

include_once('db_conn.php');
$db_conn = connection();

$stid = "";
$dgname = "";
$subject = "";
$semester = "";
$marks = "";
$credit = "";


$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stid = $_POST["stid"];
    $subject = $_POST["subject"];
    $semester = $_POST["semester"];
    $marks = $_POST["marks"];
    $credit = $_POST["credit"];
   

    if (empty($stid) || empty($subject) || empty($semester) || empty($marks) || empty($credit)) {
        $errorMessage = "All fields are required";
    } elseif (!is_numeric($marks) || !is_numeric($credit)) {
        $errorMessage = "Marks and Number of Credit should be numeric values";
    } else {
        
        $checkQuery = "SELECT * FROM subjectmrks WHERE stid = ? AND subject = ? AND semester = ?";
        $checkStmt = $db_conn->prepare($checkQuery);
        if (!$checkStmt) {
            $errorMessage = "Error preparing query: " . $db_conn->error;
        } else {
            $checkStmt->bind_param("sss", $stid, $subject, $semester);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();

            if ($checkResult->num_rows > 0) {
                $errorMessage = "This subject is already added for the selected student and semester.";
            } else {
               
                $query = "SELECT dgname FROM student_tb WHERE stid = ?";
                $stmt = $db_conn->prepare($query);
                if (!$stmt) {
                    $errorMessage = "Error preparing query: " . $db_conn->error;
                } else {
                    $stmt->bind_param("s", $stid);
                    $stmt->execute();
                    $stmt->bind_result($dgname);
                    $stmt->fetch();
                    $stmt->close();

                    $insertSql = "INSERT INTO subjectmrks (subject, semester, marks, credit, stid) VALUES ( ?, ?, ?, ?, ?)";
                    $stmt = $db_conn->prepare($insertSql);
                    if (!$stmt) {
                        $errorMessage = "Error preparing query: " . $db_conn->error;
                    } else {
                        $stmt->bind_param("sssss", $subject, $semester, $marks, $credit, $stid);

                        if ($stmt->execute()) {
                            $successMessage = "Data inserted successfully";
                            $stid = "";
                            $subject = "";
                            $semester = "";
                            $marks = "";
                            $credit = "";
                           
                        } else {
                            $errorMessage = "Error inserting data: " . $stmt->error;
                        }
                        $stmt->close();
                    }
                }
            }
            $checkStmt->close();
        }
    }
}

$studentDegrees = array();

$query = "SELECT stid, dgname FROM student_tb";

$result = $db_conn->query($query);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $studentDegrees[$row['stid']] = $row['dgname'];
    }
    $result->free();
}

$db_conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="style1.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
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
<body style="background: url(img/18.jpg); background-size: cover; background-position: center;">
<div class="container my-5">
    <h2>Add a Student Subject Marks</h2>
    <a href="admin.php" class="btn btn-warning">
        <i class="bi bi-house-door-fill"></i> Home
    </a>
    <a href="index.php" class="btn btn-danger">
        <i class="bi bi-house-door-fill"></i> Logout
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

    <form method="post">
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Student ID</label>
            <div class="col-sm-6">
                <select name="stid" id="stid" class="form-control">
                    <?php
                    foreach ($studentDegrees as $studentId => $degree) {
                        echo "<option value='$studentId'>$studentId</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Degree Name</label>
            <div class="col-sm-6">
                <input type="text" name="dgname" id="dgname" class="form-control" value="<?php echo $dgname; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Select Semester</label>
            <div class="col-sm-6">
                <select name="semester" id="semester" class="form-control">
                    <option value="1" <?php if ($semester == '1') echo 'selected'; ?>>01 Semester</option>
                    <option value="2" <?php if ($semester == '2') echo 'selected'; ?>>02 Semester</option>
                    <option value="3" <?php if ($semester == '3') echo 'selected'; ?>>03 Semester</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Select Subject</label>
            <div class="col-sm-6">
                <select name="subject" id="subject" class="form-control">
                    <option value="DBMS" <?php if ($subject == 'DBMS') echo 'selected'; ?>>Database management</option>
                    <option value="DBMS Lab" <?php if ($subject == 'DBMS Lab') echo 'selected'; ?>>DBMS Lab</option>
                    <option value="Mathematics" <?php if ($subject == 'Mathematics') echo 'selected'; ?>>Mathematics</option>
                    <option value="Programming" <?php if ($subject == 'Programming') echo 'selected'; ?>>Programming</option>
                    <option value="Programming Lab" <?php if ($subject == 'Programming Lab') echo 'selected'; ?>>Programming Lab</option>
                    <option value="English" <?php if ($subject == 'English') echo 'selected'; ?>>English</option>
                    <option value="Physics" <?php if ($subject == 'Physics') echo 'selected'; ?>>Physics</option>
                    <option value="Chemistry" <?php if ($subject == 'Chemistry') echo 'selected'; ?>>Chemistry</option>
                    <option value="Psychology" <?php if ($subject == 'Psychology') echo 'selected'; ?>>Psychology</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Input Marks</label>
            <div class="col-sm-6">
                <input type="text" name="marks" id="marks" class="form-control" value="<?php echo $marks; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Number of Credit</label>
            <div class="col-sm-6">
                <select name="credit" id="credit" class="form-control">
                    <option value="3" <?php if ($credit == '3') echo 'selected'; ?>>DBMS => 3</option>
                    <option value="1" <?php if ($credit == '1') echo 'selected'; ?>>DBMS Lab => 1</option>
                    <option value="4" <?php if ($credit == '4') echo 'selected'; ?>>Mathematics => 4</option>
                    <option value="3" <?php if ($credit == '3') echo 'selected'; ?>>Programming => 3</option>
                    <option value="1" <?php if ($credit == '1') echo 'selected'; ?>>Programming Lab => 1</option>
                    <option value="4" <?php if ($credit == '4') echo 'selected'; ?>>English => 4</option>
                    <option value="3" <?php if ($credit == '3') echo 'selected'; ?>>Physics => 3</option>
                    <option value="3" <?php if ($credit == '3') echo 'selected'; ?>>Chemistry => 3</option>
                    <option value="3" <?php if ($credit == '3') echo 'selected'; ?>>Psychology => 3</option>
                </select>
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
                <button type="submit" class="btn btn-success" value="">Add Marks</button>
            </div>
            <div class="col-sm-3 d-grid">
                <a class="btn btn-danger" href="stdtmrks.php" role="button">Cancel</a>
            </div>
        </div>
    </form>
</div>
<script>
    document.getElementById("stid").addEventListener("change", function () {
        var selectedStudentId = this.value;
        var degreeInput = document.getElementById("dgname");
        if (selectedStudentId in <?php echo json_encode($studentDegrees); ?>) {
            degreeInput.value = <?php echo json_encode($studentDegrees); ?>[selectedStudentId];
        } else {
            degreeInput.value = "";
        }
    });
</script>
</body>
</html>
