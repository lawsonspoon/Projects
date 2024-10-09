<?php
include 'conn.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM attendance WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $employee_id = $_POST['employee_id'];
    $department_id = $_POST['department_id'];
    $shift_id = $_POST['shift_id'];
    $address = $_POST['address'];
    $in_time = $_POST['in_time'];
    $notes = $_POST['notes'];
    $lack_of = $_POST['lack_of'];
    $in_status = $_POST['in_status'];
    $out_time = $_POST['out_time'];
    $out_status = $_POST['out_status'];

    $sql = "UPDATE attendance SET username='$username', employee_id='$employee_id', department_id='$department_id', shift_id='$shift_id', 
            address='$address', in_time='$in_time', notes='$notes', lack_of='$lack_of', in_status='$in_status', out_time='$out_time', 
            out_status='$out_status' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}
?>

<!-- HTML Form -->
<form action="update.php?id=<?php echo $id; ?>" method="POST">
    <input type="text" name="username" value="<?php echo $row['username']; ?>" required><br>
    <input type="text" name="employee_id" value="<?php echo $row['employee_id']; ?>" required><br>
    <input type="text" name="department_id" value="<?php echo $row['department_id']; ?>" required><br>
    <input type="text" name="shift_id" value="<?php echo $row['shift_id']; ?>" required><br>
    <input type="text" name="address" value="<?php echo $row['address']; ?>" required><br>
    <input type="datetime-local" name="in_time" value="<?php echo $row['in_time']; ?>" required><br>
    <textarea name="notes"><?php echo $row['notes']; ?></textarea><br>
    <input type="text" name="lack_of" value="<?php echo $row['lack_of']; ?>"><br>
    <input type="text" name="in_status" value="<?php echo $row['in_status']; ?>" required><br>
    <input type="datetime-local" name="out_time" value="<?php echo $row['out_time']; ?>" required><br>
    <input type="text" name="out_status" value="<?php echo $row['out_status']; ?>" required><br>
    <button type="submit">Update</button>
</form>
