<?php
// Include the database connection
include('db_connection.php'); 

// Check if the ID parameter is passed
if (isset($_GET['id'])) {
    $team_id = (int)$_GET['id']; // Secure the team_id by casting it to an integer

    // Fetch the current team details from the database
    $query = "SELECT * FROM points_table WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $team_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $team = mysqli_fetch_assoc($result);

        // Check if the team exists
        if (!$team) {
            echo "Team not found!";
            exit;
        }
    }
} else {
    echo "No team ID provided!";
    exit;
}

// Handle form submission to update team data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id']; // New team ID
    $position = $_POST['position'];
    $team_name = $_POST['team_name'];
    $matches_played = $_POST['matches_played'];
    $won = $_POST['won'];
    $lost = $_POST['lost'];
    $drawn = $_POST['drawn'];
    $points = $_POST['points'];
    $percentage = $_POST['percentage'];
    
    // Flag upload handling
    if (isset($_FILES['flag']) && $_FILES['flag']['error'] == 0) {
        $flag = $_FILES['flag']['name'];
        $target_dir = "uploads/flags/";
        $target_file = $target_dir . basename($flag);

        // Move the uploaded file to the server
        if (move_uploaded_file($_FILES['flag']['tmp_name'], $target_file)) {
            echo "Flag uploaded successfully.";
        } else {
            echo "Error uploading flag.";
            $flag = $team['flag']; // Keep existing flag if upload fails
        }
    } else {
        $flag = $team['flag']; // Keep existing flag if no new flag uploaded
    }

    // Update the team details in the database
    $update_query = "UPDATE points_table SET id = ?, position = ?, team_name = ?, matches_played = ?, won = ?, lost = ?, drawn = ?, points = ?, percentage = ?, flag = ? WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $update_query)) {
        mysqli_stmt_bind_param($stmt, "iisiiiiisis", $id, $position, $team_name, $matches_played, $won, $lost, $drawn, $points, $percentage, $flag, $team_id);
        if (mysqli_stmt_execute($stmt)) {
            echo "Team updated successfully!";
            header("Location: admin-points-table.php"); // Redirect to points table after update
            exit;
        } else {
            echo "Error updating team: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Points Table</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(to bottom, #2193b0, #6dd5ed);
      height: 100vh;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .container {
      background: rgba(255, 255, 255, 0.9);
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      width: 80%;
      max-width: 600px;
    }
    h1 {
      text-align: center;
    }
    label {
      display: block;
      margin: 10px 0 5px;
    }
    input[type="text"], input[type="number"], input[type="file"] {
      width: 100%;
      padding: 8px;
      margin: 5px 0 15px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }
    .submit-btn {
      background-color: #2193b0;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      width: 100%;
    }
    .submit-btn:hover {
      background-color: #1e8a9c;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Edit Points Table</h1>
    <form action="" method="POST" enctype="multipart/form-data">
      <label for="id">Team ID:</label>
      <input type="number" id="id" name="id" value="<?php echo $team['id']; ?>" required>

      <label for="position">Position:</label>
      <input type="number" id="position" name="position" value="<?php echo $team['position']; ?>" required>

      <label for="team_name">Team Name:</label>
      <input type="text" id="team_name" name="team_name" value="<?php echo $team['team_name']; ?>" required>

      <label for="matches_played">Matches Played:</label>
      <input type="number" id="matches_played" name="matches_played" value="<?php echo $team['matches_played']; ?>" required>

      <label for="won">Won:</label>
      <input type="number" id="won" name="won" value="<?php echo $team['won']; ?>" required>

      <label for="lost">Lost:</label>
      <input type="number" id="lost" name="lost" value="<?php echo $team['lost']; ?>" required>

      <label for="drawn">Drawn:</label>
      <input type="number" id="drawn" name="drawn" value="<?php echo $team['drawn']; ?>" required>

      <label for="points">Points:</label>
      <input type="number" id="points" name="points" value="<?php echo $team['points']; ?>" required>

      <label for="percentage">Percentage:</label>
      <input type="number" id="percentage" name="percentage" value="<?php echo $team['percentage']; ?>" required>

      <label for="flag">Team Flag:</label>
      <input type="file" id="flag" name="flag">
      <small>Current flag: <?php echo $team['flag'] ? $team['flag'] : 'No flag'; ?></small><br><br>

      <button type="submit" class="submit-btn">Save Changes</button>
    </form>
  </div>
</body>
</html>

<?php
// Close the connection
mysqli_close($conn);
?>
