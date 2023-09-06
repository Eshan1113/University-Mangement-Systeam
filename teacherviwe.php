<?php
include_once('db_conn.php');
$db_conn = connection();

$stid = "";
$degree = "";
$errorMessage = "";
$successMessage = "";

$studentDegrees = array(); 

$query = "SELECT stid, dgname FROM student_tb"; 

$result = $db_conn->query($query);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $studentDegrees[$row['stid']] = $row['dgname']; 
    }
    $result->free();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
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
 
</head>
<body style="background: url(img/18.jpg); background-size: cover; background-position: center;">
    <div class="container my-5">
        <h2>View Result</h2>
        <a href="teacherpn.php" class="btn btn-warning">
            <i class="bi bi-house-door-fill"></i> Home
        </a>
        <a href="index.php" class="btn btn-danger">
            <i class="bi bi-house-door-fill"></i>Logout
        </a>
       
        <?php
        if(!empty($errorMessage)){
            echo"
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>$errorMessage</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
        
        ?>
        
        <form method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Select Semester</label>
                <div class="col-sm-6">
                    <select name="semester" id="semester" class="form-control">
                        <option value="1">01 Semester</option>
                        <option value="2">02 Semester</option>
                        <option value="3">03 Semester</option>		
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Student ID</label>
                <div class="col-sm-6">
                    <select name="stid" id="stid" class="form-control" onchange="getStudentName()">
                        <?php
                        foreach ($studentDegrees as $studentId => $degree) {
                            echo "<option value='$studentId'>$studentId - $degree</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Student Name</label>
                <div class="col-sm-6">
                    <input type="text" name="name" id="name" class="form-control" readonly>
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
                    <button type="submit" class="btn btn-success" value="">View Marks</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-danger" href="teachermarks.php" role="button">Cancel</a>
                </div>
        </form>
    </div>
    <?php


$errorMessage = "";
$errorMessage = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $semester = $_POST["semester"];
    $stid = $_POST["stid"];

    if (empty($stid) || !is_numeric($stid)) {
        $errorMessage = "Invalid Student ID provided.";
    } else {
        $selectSql = "SELECT * FROM subjectmrks WHERE stid = ? AND semester = ?";
        $stmt = $db_conn->prepare($selectSql);
        $stmt->bind_param("is", $stid, $semester);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            $totalCredits = 0;
            $totalGradePoints = 0;

            if ($result->num_rows > 0) {
                echo '<table class="table table-primary custom-table">';
        
                echo '</table>';
            } else {
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                echo '<strong>User Result Not Available</strong>';
                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '</div>';
            }
        } else {
            $errorMessage = "Error executing the query: " . $stmt->error;
        }

            

            if ($result->num_rows > 0) {
              
                echo '<table class="table table-primary custom-table">';
                echo '<thead class="table-dark">';
                echo '<tr>';
                echo '<th>INDEX NUMBER</th>';
                echo '<th>Semester</th>';
                echo '<th>Subject</th>';
                echo '<th>Marks</th>';
                echo '<th>Grade</th>';
                echo '<th>Result</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['stid'] . '</td>';
                    echo '<td>' . $row['semester'] . '</td>';
                    echo '<td>' . $row['subject'] . '</td>';
                    echo '<td>' . $row['marks'] . '</td>';
                    

                    $gradePoint = getGradePoint($row['marks']);
                    $creditHours = getCreditHours($row['subject']);
                    
                    echo '<td>' . $gradePoint . '</td>';
                    echo '<td>' . getResult($gradePoint) . '</td>';
                    echo '</tr>';
                    
                    $totalGradePoints += ($gradePoint * $creditHours);
                    $totalCredits += $creditHours;

                    echo '</tr>';
                }
                $gpa = ($totalGradePoints / $totalCredits);
              
                echo '<tr>';
                echo '<td colspan="4">Total Credits: ' . $totalCredits . '</td>';
                echo '<td>GPA:</td>';
                echo '<td>' . number_format($gpa, 2) . '</td>';
                echo '</tbody>';
                echo '</table>';
            } else {
                $errorMessage = "No marks found for the provided Student ID and Semester.";
            }
        
       
        $stmt->close();
    }
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
?>
   <script>
        function getStudentName() {
            var selectedStid = document.getElementById("stid").value;
            if (selectedStid !== "") {
               
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "userFunction.php?stid=" + selectedStid, true);

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                      
                        var studentName = xhr.responseText;
                        document.getElementById("name").value = studentName;
                    }
                };

                xhr.send();
            } else {
                document.getElementById("name").value = "";
            }
        }
    </script>
</body>
</html>
