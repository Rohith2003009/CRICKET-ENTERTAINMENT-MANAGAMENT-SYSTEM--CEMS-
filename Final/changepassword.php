<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: 1.html");
    exit;
}

// Connect to database
$conn = mysqli_connect("localhost", "root", "", "cricketdb");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve user data
$user_id = $_SESSION["user_id"];
$query = "SELECT * FROM registration WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    // Verify the current password
    if (password_verify($current_password, $user["password"])) {
        // Check if new passwords match
        if ($new_password === $confirm_password) {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update password in the database
            $update_query = "UPDATE registration SET password='$hashed_password' WHERE id='$user_id'";
            if (mysqli_query($conn, $update_query)) {
                echo "Password updated successfully.";
                header("Location: profile.php"); // Redirect to profile page after update
                exit;
            } else {
                echo "Error updating password: " . mysqli_error($conn);
            }
        } else {
            echo "New passwords do not match.";
        }
    } else {
        echo "Current password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <style>
        /* Styling for change password form */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, rgba(52, 152, 219, 0.3), rgba(241, 196, 15, 0.3));
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 20px;
            width: 300px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Change Password</h2>
        <form method="POST" action="changepassword.php">
            <label>Current Password:</label><br>
            <input type="password" name="current_password" required><br>
            <label>New Password:</label><br>
            <input type="password" name="new_password" required><br>
            <label>Confirm New Password:</label><br>
            <input type="password" name="confirm_password" required><br>
            <input type="submit" value="Update Password">
        </form>
    </div>
</body>
</html>
