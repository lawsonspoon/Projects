<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REAC Attendance Management System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
        <h2 class="text-center">Manage Attendance Record</h2>
<div class="mt-4">
    <form action="create_attendance.php" method="POST" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username" required>
            </div>
            <div class="form-group col-md-4">
                <label for="employee_id">Employee ID</label>
                <input type="number" class="form-control" name="employee_id" id="employee_id" required>
            </div>
            <div class="form-group col-md-4">
                <label for="department_id">Department ID</label>
                <input type="number" class="form-control" name="department_id" id="department_id" required>
            </div>
            <div class="form-group col-md-4">
                <label for="shift_id">Shift ID</label>
                <input type="number" class="form-control" name="shift_id" id="shift_id" required>
            </div>
            <div class="form-group col-md-4">
                <label for="address">Address</label>
                <input type="text" class="form-control" name="address" id="address" required>
            </div>
            <div class="form-group col-md-4">
                <label for="in_time">In Time</label>
                <input type="time" class="form-control" name="in_time" id="in_time" required>
            </div>
            <div class="form-group col-md-4">
                <label for="notes">Notes</label>
                <textarea class="form-control" name="notes" id="notes"></textarea>
            </div>
            <div class="form-group col-md-4">
                <label for="image">Image</label>
                <input type="file" class="form-control" name="image" id="image" accept="image/*" required>
            </div>
            <div class="form-group col-md-4">
                <label for="lack_of">Lack Of</label>
                <input type="text" class="form-control" name="lack_of" id="lack_of">
            </div>
            <div class="form-group col-md-4">
                <label for="in_status">In Status</label>
                <select name="in_status" class="form-control" id="in_status" required>
                    <option value="">--Select Status--</option>
                    <option value="Present">Present</option>
                    <option value="Absent">Absent</option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="out_time">Out Time</label>
                <input type="time" class="form-control" name="out_time" id="out_time">
            </div>
            <div class="form-group col-md-4">
                <label for="out_status">Out Status</label>
                <select name="out_status" class="form-control" id="out_status">
                    <option value="">--Select Status--</option>
                    <option value="Overtime">Overtime</option>
                    <option value="Ontime">Ontime</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit Attendance</button>
    </form>
</div>


    <div class="container mt-5">
        <h2 class="text-center">Attendance Records</h2>

        <?php
        include 'conn.php';

        $sql = "SELECT * FROM attendance";
        $result = $conn->query($sql);
        ?>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Employee ID</th>
                    <th>Department ID</th>
                    <th>Shift ID</th>
                    <th>Address</th>
                    <th>In Time</th>
                    <th>Notes</th>
                    <th>Image</th>
                    <th>Lack Of</th>
                    <th>In Status</th>
                    <th>Out Time</th>
                    <th>Out Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['id']}</td>";
                        echo "<td>{$row['username']}</td>";
                        echo "<td>{$row['employee_id']}</td>";
                        echo "<td>{$row['department_id']}</td>";
                        echo "<td>{$row['shift_id']}</td>";
                        echo "<td>{$row['address']}</td>";
                        echo "<td>{$row['in_time']}</td>";
                        echo "<td>{$row['notes']}</td>";
                        echo "<td><img src='uploads/{$row['image']}' class='img-fluid' style='width:100px;height:100px;'></td>";
                        echo "<td>{$row['lack_of']}</td>";
                        echo "<td>{$row['in_status']}</td>";
                        echo "<td>{$row['out_time']}</td>";
                        echo "<td>{$row['out_status']}</td>";
                        echo "<td>
                                <a href='update.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a> 
                                <a href='delete.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='13' class='text-center'>No records found</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

