<?php

include_once('db_conn.php');

$db_conn = connection();

if (isset($_GET['stid'])) {
    $stid = $_GET['stid'];
    $studentName = getStudentName($stid);
    echo $studentName;
}

function getStudentName($studentId) {
    global $db_conn;
    
    $query = "SELECT stid, name FROM student_tb WHERE stid = ?";
    $stmt = $db_conn->prepare($query);
    $stmt->bind_param("i", $studentId);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['name'];
        }
    }
    
    return "N/A";
}
function userRegistration($username, $useremail, $userpassword, $userphone, $usernic){
    $db_conn = connection();

    $insertSql = "INSERT INTO user_tb (User_name, User_email, User_mobile, User_NIC,) 
    VALUES ('$username', '$useremail', '$userphone', '$usernic', 1)";

    $sqlresult = mysqli_query($db_conn, $insertSql);

    if (!$sqlresult) {
        echo "Database error: " . mysqli_error($db_conn);
    }

    if ($sqlresult) {
        $newPassword = md5($userpassword);

        $insertlogin = "INSERT INTO login_tb (Login_email, Login_pswrd, Login_role) 
        VALUES ('$useremail', '$newPassword', 'user', 1)";

        $loginresult = mysqli_query($db_conn, $insertlogin);

        if (!$loginresult) {
            echo "Database error: " . mysqli_error($db_conn);
        } else {
            return "Your Registration Successful!";
        }
    } else {
        return "Please Try Again!";
    }
}
function Authentication($Login_email, $Login_pswrd) {
    $db_conn = connection();
    $sqlfetchuser = "SELECT * FROM login_tb WHERE Login_email = '$Login_email';";
    $sqlresult = mysqli_query($db_conn, $sqlfetchuser);

    if (!$sqlresult) {
            echo "Database error: " . mysqli_error($db_conn);
        }

        $newpass = ($Login_pswrd);

        $norow = mysqli_num_rows($sqlresult);



        if($norow > 0){
            $rec = mysqli_fetch_assoc($sqlresult);

        if($rec['Login_pswrd']== $newpass){
                if($rec['Login_role'] == 'admin'){
                    header('location:admin.php');
                }else{
                    header('location:teacherpn.php');
                }
            }else{
                return("Your account has been diactivated!");
            }
        }else{
            return("Password is incorrect!");
        } 
    
        return("No records are found!");
    }


?>