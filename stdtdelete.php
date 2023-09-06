<?php
include_once('db_conn.php');
$db_conn = connection();

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = $_GET["id"]; 

    
    $deleteSubjectSql = "DELETE FROM subjectmrks WHERE stid = ?";
    $stmt = $db_conn->prepare($deleteSubjectSql);
    $stmt->bind_param("i", $id); 
    if ($stmt->execute()) {
       
        $deleteStudentSql = "DELETE FROM student_tb WHERE stid = ?";
        $stmt = $db_conn->prepare($deleteStudentSql);
        $stmt->bind_param("i", $id); 
        if ($stmt->execute()) {
           
            header("location: stdt.php");
            exit;
        } else {
            echo "Error deleting record from student_tb: " . $stmt->error;
        }
    } else {
        echo "Error deleting record from subjectmrks: " . $stmt->error;
    }
} else {
    echo "Invalid ID provided.";
}
?>