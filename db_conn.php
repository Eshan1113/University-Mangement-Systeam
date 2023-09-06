<?php

function connection() {
    $db_host = 'localhost';
    $db_user = 'root';
    $db_password = '';
    $db_name = 'gg';

    $conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    return $conn;
}
class databaseConnection{
	public function __construct(){
		global $conn;}}

?>