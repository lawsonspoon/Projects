<?php 
session_start(); 
include "db.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);

    if (empty($uname)) {
        header("Location: index.php?error=Username is required");
        exit();
    }else if(empty($pass)){
        header("Location: index.php?error=Password is required");
        exit();
    }else{
        // Prepare statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $uname);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($stmt->error) {
            error_log("SQL error: " . $stmt->error);
            header("Location: index.php?error=Database error");
            exit();
        }

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            // Compare plaintext password
            if ($pass === $row['password']) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['id'] = $row['id'];
                header("Location: http://localhost/REACEmployeeManagementSystem/attendance/index.php");
                exit();
            }else{
                header("Location: index.php?error=Incorrect Username or password");
                exit();
            }
        }else{
            header("Location: index.php?error=Incorrect Username or password");
            exit();
        }
    }
}else{
    header("Location: index.php");
    exit();
}
?>
