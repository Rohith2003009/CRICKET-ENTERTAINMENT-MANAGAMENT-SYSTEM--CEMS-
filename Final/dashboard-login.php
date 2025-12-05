<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
	header("Location: login.php");
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
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Display user dashboard
?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
	
</head>
<body>
	<div class="container">
		<h1>Welcome, <?php echo $user["first_name"]; ?>!</h1>
		<p>Your Email: <?php echo $user["email"]; ?></p>
		<p>Your Profile:</p>
		<img src="profile.php?id=<?php echo $user["id"]; ?>">
	</div>
</body>
</html>