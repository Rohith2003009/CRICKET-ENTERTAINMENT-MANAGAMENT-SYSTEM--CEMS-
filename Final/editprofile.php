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

// Retrieve current user data
$user_id = $_SESSION["user_id"];
$query = "SELECT * FROM registration WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Update user data if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $phone = mysqli_real_escape_string($conn, $_POST["phone"]);

    // Update query
    $update_query = "UPDATE registration SET username='$username', email='$email', phone='$phone' WHERE id='$user_id'";
    if (mysqli_query($conn, $update_query)) {
        // Update session variables
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['phone'] = $phone;

        // Redirect back to profile page after update
        header("Location: profile.php");
        exit;
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <style>
/* Gradient background */
body {
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

/* Container styling with glass effect */
.form-container {
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(12px);
    border-radius: 15px;
    padding: 30px;
    width: 320px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
    text-align: center;
}

/* Title styling */
h2 {
    color: #fff;
    font-size: 1.8em;
    margin-bottom: 15px;
}

/* Label styling */
label {
    display: block;
    color: #ddd;
    font-weight: bold;
    margin: 10px 0 5px;
}

/* Input fields styling */
input[type="text"], input[type="email"] {
    width: 100%;
    padding: 12px;
    margin: 8px 0;
    border-radius: 8px;
    border: 1px solid #ddd;
    font-size: 1em;
    color: #333;
    box-sizing: border-box;
    transition: border-color 0.3s;
}

/* Focus effect on input fields */
input[type="text"]:focus, input[type="email"]:focus {
    border-color: #6a11cb;
    outline: none;
}

/* Button styling */
input[type="submit"] {
    background: linear-gradient(135deg, #ff6f61, #d32f2f);
    color: #fff;
    padding: 12px 0;
    width: 100%;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1em;
    font-weight: bold;
    margin-top: 15px;
    transition: background 0.3s, transform 0.3s;
}

/* Hover effect on button */
input[type="submit"]:hover {
    background: linear-gradient(135deg, #d32f2f, #ff6f61);
    transform: scale(1.05);
}

/* Additional focus and form container animations */
input[type="text"], input[type="email"], input[type="submit"] {
    transition: box-shadow 0.3s ease;
}
input[type="text"]:focus, input[type="email"]:focus {
    box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
}
</style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Profile</h2>
        <form method="POST" action="editprofile.php">
            <label>Username:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label>Phone:</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>

            <input type="submit" value="Update Profile">
        </form>
    </div>
</body>
</html>
