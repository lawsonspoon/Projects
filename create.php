<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Initialize error array
    $errors = [];

    // Username validation
    $username = trim($_POST['username']);
    if (empty($username)) {
        $errors[] = 'Username is required.';
    }

    // Employee ID validation
    $employee_id = trim($_POST['employee_id']);
    if (empty($employee_id)) {
        $errors[] = 'Employee ID is required.';
    }

    // Department ID validation
    $department_id = trim($_POST['department_id']);
    if (empty($department_id)) {
        $errors[] = 'Department ID is required.';
    }

    // Shift ID validation
    $shift_id = trim($_POST['shift_id']);
    if (empty($shift_id)) {
        $errors[] = 'Shift ID is required.';
    }

    // Address validation
    $address = trim($_POST['address']);
    if (empty($address)) {
        $errors[] = 'Address is required.';
    }

    // In time validation
    $in_time = trim($_POST['in_time']);
    if (empty($in_time)) {
        $errors[] = 'In time is required.';
    }

    // Notes validation
    $notes = trim($_POST['notes']);

    // Image validation
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image = $_FILES['image'];
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $imageExt = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));

        if (!in_array($imageExt, $allowedExtensions)) {
            $errors[] = 'Invalid image file type. Allowed: jpg, jpeg, png, gif.';
        }

        if ($image['size'] > 5000000) { // 5MB limit
            $errors[] = 'Image size must be less than 5MB.';
        }
    } else {
        $errors[] = 'Please upload an image.';
    }

    // Lack of validation
    $lack_of = trim($_POST['lack_of']);

    // In status validation
    $in_status = trim($_POST['in_status']);
    if (empty($in_status)) {
        $errors[] = 'In status is required.';
    }

    // Out time validation
    $out_time = trim($_POST['out_time']);
    if (empty($out_time)) {
        $errors[] = 'Out time is required.';
    }

    // Out status validation
    $out_status = trim($_POST['out_status']);
    if (empty($out_status)) {
        $errors[] = 'Out status is required.';
    }

    // If no errors, process the form
    if (empty($errors)) {
        // Move the uploaded image
        $newImageName = uniqid() . '.' . $imageExt;
        move_uploaded_file($image['tmp_name'], 'uploads/' . $newImageName);

        // Sanitize input before inserting into the database
        $username = $conn->real_escape_string($username);
        $employee_id = $conn->real_escape_string($employee_id);
        $department_id = $conn->real_escape_string($department_id);
        $shift_id = $conn->real_escape_string($shift_id);
        $address = $conn->real_escape_string($address);
        $notes = $conn->real_escape_string($notes);
        $lack_of = $conn->real_escape_string($lack_of);
        $in_status = $conn->real_escape_string($in_status);
        $out_status = $conn->real_escape_string($out_status);

        // Insert into the database
        $sql = "INSERT INTO attendance (username, employee_id, department_id, shift_id, address, in_time, notes, image, lack_of, in_status, out_time, out_status) 
                VALUES ('$username', '$employee_id', '$department_id', '$shift_id', '$address', '$in_time', '$notes', '$newImageName', '$lack_of', '$in_status', '$out_time', '$out_status')";

        if ($conn->query($sql) === TRUE) {
            header("Location: index.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        // Display validation errors
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
}
?>

<!-- HTML Form -->
<form action="create.php" method="POST" enctype="multipart/form-data">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="text" name="employee_id" placeholder="Employee ID" required><br>
    <input type="text" name="department_id" placeholder="Department ID" required><br>
    <input type="text" name="shift_id" placeholder="Shift ID" required><br>
    <input type="text" name="address" placeholder="Address" required><br>
    <input type="datetime-local" name="in_time" required><br>
    <textarea name="notes" placeholder="Notes"></textarea><br>
    <input type="file" name="image" required><br>
    <input type="text" name="lack_of" placeholder="Lack Of"><br>
    <input type="text" name="in_status" placeholder="In Status" required><br>
    <input type="datetime-local" name="out_time" required><br>
    <input type="text" name="out_status" placeholder="Out Status" required><br>
    <button type="submit">Add Attendance</button>
</form>
