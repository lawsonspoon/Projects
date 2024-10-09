<?php
include "db.php"; 

if (isset($_GET['employee_id'])) {
    $employee_id = (int)$_GET['employee_id'];

    // Prepare and execute the query to fetch roles based on the employee ID
    $stmt = $conn->prepare("SELECT id, role_name FROM user_role WHERE employee_id = ?"); // Adjust this query based on your actual database design
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $roles = [];
    while ($row = $result->fetch_assoc()) {
        $roles[] = $row;
    }

    // Return roles as JSON
    echo json_encode($roles);
}
?>
