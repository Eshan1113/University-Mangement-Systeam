<?php
include_once('db_conn.php');
$db_conn = connection();

$stid = "";
$name = "";

$semester_gpa = array();
$semester_total_credits = array();
$error_message = ""; 

if (isset($_GET['stid'])) {
    $stid = $_GET['stid'];
    if (!isValidStid($stid)) {
        $error_message = "Invalid Student INDEX Number";
    } else {
        $sql_student = "SELECT name FROM student_tb WHERE stid = ?";
        $stmt_student = $db_conn->prepare($sql_student);
        $stmt_student->bind_param("s", $stid);
        $stmt_student->execute();
        $result_student = $stmt_student->get_result();

        if ($result_student->num_rows > 0) {
            $student_data = $result_student->fetch_assoc();
            $name = $student_data['name'];
        } else {

            $error_message = "Student Not Found"; 
        }

        $stmt_student->close();

        $sql = "SELECT * FROM subjectmrks WHERE stid = ?";
        $stmt = $db_conn->prepare($sql);
        $stmt->bind_param("s", $stid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
           
            foreach (array(1, 2, 3) as $semester) {
                $semester_gpa[$semester] = 0.0;
                $semester_total_credits[$semester] = 0;
            }
            echo '<table class="table table-primary custom-table custom-table-size">';
            echo '<thead class="table-dark">';
            echo '<tr>';
            echo '<th>INDEX NUMBER</th>';
            echo '<th>Semester</th>';
            echo '<th>Student Name</th>';
            echo '<th>Subject</th>';
            echo '<th>Result</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = $result->fetch_assoc()) {
                $semester = $row['semester'];
                
                echo '<tr>';
                echo '<td>' . $row['stid'] . '</td>';
                echo '<td>' . $semester . '</td>';
                echo '<td>' . $name . '</td>';
                echo '<td>' . $row['subject'] . '</td>';

                $gradePoint = getGradePoint($row['marks']);
                $creditHours = getCreditHours($row['subject']);

                $semester_gpa[$semester] += ($gradePoint * $creditHours);
                $semester_total_credits[$semester] += $creditHours;

                echo '<td>' . getResult($gradePoint) . '</td>';
                echo '</tr>';
            }

            foreach (array(1, 2, 3) as $semester) {
                $gpa = ($semester_total_credits[$semester] > 0) ? 
                    number_format(($semester_gpa[$semester] / $semester_total_credits[$semester]), 2) : 0.00;
                
                echo '<tr>';
                echo '<td colspan="4">Semester ' . $semester . ' GPA:</td>';
                echo '<td>' . $gpa . '</td>';
                echo '</tr>';
            }

            $stmt->close();
        } else {
            echo "<p>Database query error.</p>";
        }
    }
}
function isValidStid($stid) {
 
    return !empty($stid);
}

function getGradePoint($marks) {
    if ($marks >= 80) {
        return 4.00;
    } elseif ($marks >= 70) {
        return 3.70;
    } elseif ($marks >= 65) {
        return 3.30;
    } elseif ($marks >= 60) {
        return 3.00;
    } elseif ($marks >= 55) {
        return 2.70;
    } elseif ($marks >= 50) {
        return 2.30;
    } elseif ($marks >= 45) {
        return 2.00;
    } elseif ($marks >= 40) {
        return 1.70;
    } elseif ($marks >= 35) {
        return 1.30;
    } elseif ($marks >= 30) {
        return 1.00;
    } else {
        return 0.00;
    }
}

function getResult($gradePoint) {
    if ($gradePoint >= 4.00) {
        return 'A';
    } elseif ($gradePoint >= 3.70) {
        return 'A-';
    } elseif ($gradePoint >= 3.30) {
        return 'B+';
    } elseif ($gradePoint >= 3.00) {
        return 'B';
    } elseif ($gradePoint >= 2.70) {
        return 'B-';
    } elseif ($gradePoint >= 2.30) {
        return 'C+';
    } elseif ($gradePoint >= 2.00) {
        return 'C';
    } elseif ($gradePoint >= 1.70) {
        return 'C-';
    } elseif ($gradePoint >= 1.30) {
        return 'D+';
    } elseif ($gradePoint >= 1.00) {
        return 'D';
    } else {
        return 'Fail';
    }
}

function getCreditHours($subject) {
    $creditHours = [
        "DBMS" => 3,
        "DBMS Lab" => 1,
        "Mathematics" => 4,
        "Programming" => 3,
        "Programming Lab" => 1,
        "English" => 4,
        "Physics" => 3,
        "Chemistry" => 3,
        "Psychology" => 3,
    ];
    return isset($creditHours[$subject]) ? $creditHours[$subject] : 0;
}

$db_conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student Mark Sheet</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">

    <style>
         .custom-navbar {
            background-color: rgba(119, 67, 219, 0.7);
        }
        .custom-table-size {
            width: 80%; 
            margin: 0 auto;
        }

        .custom-navbar .navbar-brand {
            color: #fff;
            padding-right: 20px;
        }
        body {
            background: url(img/bg.jpg);
            background-size: cover;
            text-align: center;
        }

        .form-container {
            background-color: rgba(255, 0, 0, 0.5);
            padding: 100px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            width: 50%;
            margin: 0 auto;
            color: white;
        }

        .btn-success {
            background-color: #28a745; 
            border-color: #28a745; 
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        #stid {
            width: 100%;
            padding: 10px;
            border: 1px solid #28a745;
            border-radius: 5px;
            font-size: 16px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light custom-navbar fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">ABC UNIVERSITY</a>
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
<br><br>
<br>
<div class="form-container">
    <h2>View Student Mark Sheet</h2>
    <form method="get">
        <label for="stid">Enter Student INDEX Number: </label>
        <input type="text" name="stid" id="stid" required>
        <br><br>
        <button type="submit" class="btn btn-success">View Mark Sheet</button>
     
    </form>
</div>
<br>
<?php if (!empty($error_message)): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error_message; ?>
    </div>
<?php endif; ?>

</body>
</html>
