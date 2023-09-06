<?php
include_once('db_conn.php');
$db_conn = connection();

$errorMessage = "";
$successMessage = "";

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $deleteSql = "DELETE FROM login_tb WHERE id=$id";

    if ($db_conn->query($deleteSql)) {
        session_start();
        $_SESSION['successMessage'] = "User deleted successfully!";
    } else {
        $errorMessage = "Error deleting user: " . $db_conn->error;
    }
}
header("Location: userdt.php");
exit;
?>