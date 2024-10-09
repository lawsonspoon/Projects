<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script>
        function fetchRoles() {
            const employeeId = document.querySelector('select[name="employee_id"]').value;
            const roleSelect = document.querySelector('select[name="role_id"]');

            // Clear previous options
            roleSelect.innerHTML = '<option value="">--Select Role--</option>';

            if (employeeId) {
                // Make AJAX request to fetch roles
                const xhr = new XMLHttpRequest();
                xhr.open("GET", `get_roles.php?employee_id=${employeeId}`, true);
                xhr.onload = function() {
                    if (this.status == 200) {
                        const roles = JSON.parse(this.responseText);
                        roles.forEach(role => {
                            roleSelect.innerHTML += `<option value="${role.id}">${role.role_name}</option>`;
                        });
                    } else {
                        console.error('Error fetching roles');
                    }
                };
                xhr.send();
            }
        }
    </script>
</head>
<body>
    <form action="register.php" method="post">
        <h2>Register</h2>
        <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>
        
        <label>UserName</label>
        <input type="text" name="uname" placeholder="UserName" required><br>

        <label>Password</label>
        <input type="password" name="password" placeholder="Password" required><br>

        <label>Confirm Password</label>
        <input type="password" name="cpassword" placeholder="Confirm Password" required><br>
        
        <label>Employee ID</label>
        <select name="employee_id" required onchange="fetchRoles()">
            <option value="">--Select Employee ID--</option>
            <?php
            include "db.php"; 

            $query = "SELECT id FROM employee"; 
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['id'] . "</option>";
                }
            } else {
                echo "<option value=''>No Employee IDs Available</option>";
            }
            ?>
        </select>
        <br>

        <label>Role</label>
        <select name="role_id" required>
            <option value="">--Select Role--</option>
			<option value= 1>admin</option>
           <option value= 2 >Employee</option>
        </select>
        <br>

        <button type="submit">Register</button>

        <!-- Add link back to login page -->
        <p>Already have an account? <a href="index.php">Login here</a></p>
    </form>
</body>
</html>
