<?php
// Connect to database
$conn = mysqli_connect("localhost", "root", "", "cricketdb");

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Initialize error message variable
$error_message = "";

// Login admin
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $loginame = $_POST["loginame"];
  $password = $_POST["password"];

  // Retrieve admin from database
  $query = "SELECT * FROM admin WHERE loginame = '$loginame' AND password = '$password'";
  $result = mysqli_query($conn, $query);

  // Check if admin exists
  if (mysqli_num_rows($result) > 0) {
    // Start session
    session_start();
    $_SESSION["admin_login"] = true;
    header("Location: admin-home.html");
    exit;
  } else {
    $error_message = "Invalid login name or password!";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <style>
    /* Global Reset */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Roboto', sans-serif;
        background: url('https://t3.ftcdn.net/jpg/06/59/60/16/360_F_659601641_dms0A1wuIBjQwsGFZpiLpzBQRpyG59nY.jpg') no-repeat center center/cover;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        overflow: hidden;
        position: relative; /* Set to relative so that absolute positioning works */
    }

    /* Glass Effect */
    .container {
        width: 360px;
        padding: 30px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(15px);
        border-radius: 30px;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.2);
        text-align: center;
        animation: fadeIn 1s ease;
    }

    /* Heading Styles */
    h1 {
        font-size: 25px;
        color: black;
        margin-bottom: 25px;
        letter-spacing: 2px;
    }

    /* Label Styles */
    label {
        font-size: 16px;
        color: black;
        font-weight: bold;
        display: block;
        margin-bottom: 10px;
        text-align: left;
    }

    /* Input Fields */
    input[type="text"], input[type="password"] {
        width: 100%;
        padding: 12px;
        margin-bottom: 18px;
        border-radius: 30px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        background: rgba(255, 255, 255, 0.2);
        color: black;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    /* Focus Effect */
    input[type="text"]:focus, input[type="password"]:focus {
        border-color: #4A90E2;
        background: rgba(255, 255, 255, 0.4);
        box-shadow: 0 0 10px rgba(74, 144, 226, 0.6);
    }

    /* Hover Effect */
    input[type="text"]:hover, input[type="password"]:hover {
        background: rgba(255, 255, 25, 0.3);
        border-color: #4A90E2;
    }

    /* Submit Button */
    input[type="submit"] {
        width: 100%;
        padding: 14px;
        background: rgba(28, 139, 45, 0.3);
        color: black;
        border: 1px solid rgba(28, 139, 45, 0.6);
        border-radius: 30px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
        backdrop-filter: blur(10px);
    }

    /* Hover Effect */
    input[type="submit"]:hover {
        background: rgba(28, 139, 45, 0.5);
        border-color: rgba(28, 139, 45, 0.8);
        box-shadow: 0 0 10px rgba(28, 139, 45, 0.8);
    }

    /* Active Effect */
    input[type="submit"]:active {
        background: rgba(28, 139, 45, 0.6);
        border-color: rgba(28, 139, 45, 1);
        transform: translateY(2px);
    }

    /* Error Message Styling */
    .error-message {
        color: yellow;
        font-size: 25px;
        font-weight: bold;
        margin: 10px 0;
        text-align: center;
    }

    /* Go Back Button */
    .go-back-btn {
        position: absolute;
        top: 20px; /* Position from the top */
        left: 20px; /* Position from the left */
        padding: 10px 20px;
        background: rgba(28, 139, 45, 0.3);
        color: black;
        border: 1px solid rgba(28, 139, 45, 0.6);
        border-radius: 30px;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
        backdrop-filter: blur(10px);
        z-index: 10; /* Ensure the button stays on top of other elements */
    }

    .go-back-btn:hover {
        background: rgba(28, 139, 45, 0.5);
        border-color: rgba(28, 139, 45, 0.8);
        box-shadow: 0 0 10px rgba(28, 139, 45, 0.8);
    }

    .go-back-btn:active {
        background: rgba(28, 139, 45, 0.6);
        border-color: rgba(28, 139, 45, 1);
        transform: translateY(2px);
    }

    /* Animation */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
  </style>
</head>
<body>
  <button class="go-back-btn" onclick="window.location.href='registration.php'">Go Back</button>

  <div class="container">
    <h1>Admin Login</h1>
    
    <!-- Error Message -->
    <?php if ($error_message): ?>
      <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form action="admin-login.php" method="post">
      <label for="loginame">Login Name:</label>
      <input type="text" name="loginame" id="loginame" required>

      <label for="password">Password:</label>
      <input type="password" name="password" id="password" required>

      <input type="submit" value="Login">
    </form>
  </div>
</body>
</html>
