<?php
session_start();
include "db.php";

if (isset($_POST['uname']) && isset($_POST['password']) && isset($_POST['cpassword']) && isset($_POST['employee_id']) && isset($_POST['role_id'])) {

    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);
    $cpass = validate($_POST['cpassword']);
    $employee_id = validate($_POST['employee_id']);
    $role_id = validate($_POST['role_id']); // Get role_id from the form

    // Validation
    if (empty($uname)) {
        header("Location: index1.php?error=Username is required");
        exit();
    } else if (empty($pass)) {
        header("Location: index1.php?error=Password is required");
        exit();
    } else if ($pass !== $cpass) {
        header("Location: index1.php?error=Passwords do not match");
        exit();
    } else if (empty($employee_id)) {
        header("Location: index1.php?error=Employee ID is required");
        exit();
    } else if (empty($role_id)) {
        header("Location: index1.php?error=Role ID is required");
        exit();
    }

    // Check if employee ID exists in employee table
    $stmt = $conn->prepare("SELECT * FROM employee WHERE id = ?");
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $employee_result = $stmt->get_result();

    if ($employee_result->num_rows == 0) {
        header("Location: index1.php?error=Employee ID does not exist");
        exit();
    }

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: index1.php?error=Username already exists");
        exit();
    } else {
        // Hash the password
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

        // Check if the role_id is valid before inserting into the users table
        // Prepare and bind for inserting into users table
        $stmt = $conn->prepare("INSERT INTO users (username, password, employee_id, role_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $uname, $hashed_password, $employee_id, $role_id);
        
        // Execute and check for errors
        if ($stmt->execute()) {
            echo "User registered successfully with Employee ID: " . $employee_id;
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
} else {
    header("Location: index1.php");
    exit();
}
?>
