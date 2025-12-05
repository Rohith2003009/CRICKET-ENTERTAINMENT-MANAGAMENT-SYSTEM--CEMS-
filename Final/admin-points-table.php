<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "cricketdb");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Define an array to map team names to flag image URLs
$team_flags = [
    'India' => 'https://upload.wikimedia.org/wikipedia/en/4/41/Flag_of_India.svg',
    'Australia' => 'https://upload.wikimedia.org/wikipedia/commons/8/88/Flag_of_Australia_%28converted%29.svg',
    'England' => 'https://cdn.britannica.com/44/344-050-94536674/Flag-England.jpg',
    'South Africa' => 'https://upload.wikimedia.org/wikipedia/commons/a/af/Flag_of_South_Africa.svg',
    'New Zealand' => 'https://upload.wikimedia.org/wikipedia/commons/a/a0/Flag_of_New_Zealand.svg',
    'Pakistan' => 'https://upload.wikimedia.org/wikipedia/commons/3/32/Flag_of_Pakistan.svg',
    'Srilanka' => 'https://cdn.britannica.com/13/4413-050-98188B5C/Flag-Sri-Lanka.jpg',
    'Bangladesh' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f9/Flag_of_Bangladesh.svg/1200px-Flag_of_Bangladesh.svg.png',
    'West Indies' => 'https://static.vecteezy.com/system/resources/previews/024/289/394/non_2x/illustration-of-west-indies-flag-design-vector.jpg',
    'Afghanistan' => 'https://cdn.britannica.com/40/5340-004-B25ED5CF/Flag-Afghanistan.jpg',
];

// Delete team and reorder IDs
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    
    $delete_query = "DELETE FROM points_table WHERE id = ?";
    $stmt = mysqli_prepare($conn, $delete_query);
    mysqli_stmt_bind_param($stmt, "i", $delete_id);

    if (mysqli_stmt_execute($stmt)) {
        // Reorder IDs after deletion
        $reorder_query = "SET @new_id = 0;
                          UPDATE points_table SET id = (@new_id := @new_id + 1) ORDER BY id ASC;
                          ALTER TABLE points_table AUTO_INCREMENT = 1;";
        mysqli_multi_query($conn, $reorder_query);
    }
    header("Location: admin-points-table.php");
    exit;
}

// Update team details
if (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_GET['id'];
    $position = $_POST['position'];
    $team_name = $_POST['team_name'];
    $matches_played = $_POST['matches_played'];
    $won = $_POST['won'];
    $lost = $_POST['lost'];
    $drawn = $_POST['drawn'];
    $points = $_POST['points'];
    $percentage = $_POST['percentage'];

    // Update the team information in the database
    $update_query = "UPDATE points_table SET position=?, team_name=?, matches_played=?, won=?, lost=?, drawn=?, points=?, percentage=? WHERE id=?";
    $stmt_update = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt_update, "isiiiiidi", $position, $team_name, $matches_played, $won, $lost, $drawn, $points, $percentage, $id);
    mysqli_stmt_execute($stmt_update);

    // Recalculate and update positions based on points and percentage
    $recalculate_query = "SELECT * FROM points_table ORDER BY points DESC, percentage DESC";
    $result = mysqli_query($conn, $recalculate_query);
    $new_position = 1;

    // Update positions for each team based on the recalculated order
    while ($row = mysqli_fetch_assoc($result)) {
        $update_position_query = "UPDATE points_table SET position = ? WHERE id = ?";
        $stmt_position = mysqli_prepare($conn, $update_position_query);
        mysqli_stmt_bind_param($stmt_position, "ii", $new_position, $row['id']);
        mysqli_stmt_execute($stmt_position);
        $new_position++;
    }

    header("Location: admin-points-table.php");
    exit;
}

// Fetch data for displaying and editing
$query = "SELECT * FROM points_table ORDER BY position ASC";
$result = mysqli_query($conn, $query);

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $edit_query = "SELECT * FROM points_table WHERE id = ?";
    $stmt_edit = mysqli_prepare($conn, $edit_query);
    mysqli_stmt_bind_param($stmt_edit, "i", $id);
    mysqli_stmt_execute($stmt_edit);
    $edit_result = mysqli_stmt_get_result($stmt_edit);
    $edit_row = mysqli_fetch_assoc($edit_result);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Points Table</title>
    <style>
       body {
      font-family: Arial, sans-serif;
      background: linear-gradient(to bottom, #2193b0, #6dd5ed);
      background-size: cover;
      height: 100vh;
      margin: 0;
      padding: 0;
    }

    nav {
            height: 80px;
            width: 100%;
            background: rgba(28, 57, 120, 0.8); /* Darker transparent blue background */
            backdrop-filter: blur(10px); /* Glass effect */
            position: fixed;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); /* Increased shadow for better visibility */
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding-right: 20px;
        }

.nav-menu {
    list-style: none;
    display: flex;
    justify-content: flex-start;
    padding: 10px;
    margin: 0;
    flex-grow: 1;
    padding-left: 50px; /* Increased spacing */
    padding-top: 30px;
}

.nav-menu li {
    margin: 0 35px; /* Increased spacing between menu items */
    position: relative;
}

.nav-menu li:not(:first-child):not(:nth-child(1)):not(:last-child)::after {
    content: "";
    position: absolute;
    right: -30px;  /* Adjust spacing */
    top: 30%;
    transform: translateY(-50%);
    height: 60px;  /* Adjust height as needed */
    width: 2px;  /* Thickness of the line */
    background-color: white; /* Change color as needed */
}


.nav-menu a {
    text-decoration: none;
    font-size: 1.5em; /* Increased text size */
    color: white;
    font-weight: bold;
    transition: color 0.3s ease;
}

.nav-menu a:hover {
    color: #FFD700;
}

.nav-logo {
        height: 60px; 
        width: auto;  
        margin-left: 20px;
        margin-top: -15px;
        }

        /* Dropdown Menu Styles */
        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            background-color: rgba(28, 94, 179, 0.9);
            backdrop-filter: blur(10px);
            padding: 10px;
            z-index: 1;
            width: 180px;
            top: 100%;
            left: 0;
            border-radius: 10px;
        }

        .dropdown-menu li {
            padding: 5px 0;
        }

        .dropdown-menu li a {
            color: white;
            font-size: 1em;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        /* Hamburger Menu for Mobile */
        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }

        .hamburger div {
            width: 25px;
            height: 3px;
            background-color: white;
            margin: 4px 0;
            transition: 0.4s;
        }

        .nav-menu.active {
            display: block;
            flex-direction: column;
            width: 100%;
            background: rgba(28, 94, 179, 0.9);
            position: absolute;
            top: 80px;
            left: 0;
            text-align: center;
        }
        .container {
            width: 800px;
            padding: 20px;
            background: #dfe4e9;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin: 100px auto;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background: #2193b0;
            color: #fff;
        }
    </style>
</head>
<body>
      <header>
        <nav>
            <div class="hamburger" onclick="toggleMenu()">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <ul class="nav-menu">
                <li>
                    <a href="admin-home.html">
                    <img src="logo.jpg" alt="Logo" class='nav-logo'>
                </a>
                </li>
                <li><a href="admin-home.html" class="active">Home</a></li>
                <li><a href="registered-users.php">Registered Users</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">Support</a>
                    <ul class="dropdown-menu">
                        <li><a href="admin_dashboard.php">Contact Us</a></li>
                    </ul>
                </li>
                <li><a href="registration.php">Signout</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h1>Admin Points Table</h1>
        
        <?php if (isset($edit_row)) { ?>
        <h2>Edit Team</h2>
        <form method="POST" action="admin-points-table.php?id=<?php echo $edit_row['id']; ?>">
            <label for="position">Position:</label>
            <input type="number" name="position" value="<?php echo $edit_row['position']; ?>" required><br>

            <label for="team_name">Team Name:</label>
            <input type="text" name="team_name" value="<?php echo $edit_row['team_name']; ?>" required><br>

            <label for="matches_played">Matches Played:</label>
            <input type="number" name="matches_played" value="<?php echo $edit_row['matches_played']; ?>" required><br>

            <label for="won">Won:</label>
            <input type="number" name="won" value="<?php echo $edit_row['won']; ?>" required><br>

            <label for="lost">Lost:</label>
            <input type="number" name="lost" value="<?php echo $edit_row['lost']; ?>" required><br>

            <label for="drawn">Drawn:</label>
            <input type="number" name="drawn" value="<?php echo $edit_row['drawn']; ?>" required><br>

            <label for="points">Points:</label>
            <input type="number" name="points" value="<?php echo $edit_row['points']; ?>" required><br>

            <label for="percentage">Percentage:</label>
            <input type="number" name="percentage" value="<?php echo $edit_row['percentage']; ?>" required><br>

            <button type="submit">Update Team</button>
        </form>
        <?php } ?>

        <h2>Points Table</h2>
        <table>
            <tr>
                <th>Position</th>
                <th>Team</th>
                <th>Matches Played</th>
                <th>Won</th>
                <th>Lost</th>
                <th>Drawn</th>
                <th>Points</th>
                <th>Percentage</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row["position"]; ?></td>
                    <td>
                        <?php 
                        $flag_url = isset($team_flags[$row["team_name"]]) ? $team_flags[$row["team_name"]] : '';
                        if ($flag_url) { ?>
                            <img src="<?php echo $flag_url; ?>" alt="Flag" style="width: 30px; height: 20px;">
                        <?php } ?>
                        <?php echo $row["team_name"]; ?>
                    </td>
                    <td><?php echo $row["matches_played"]; ?></td>
                    <td><?php echo $row["won"]; ?></td>
                    <td><?php echo $row["lost"]; ?></td>
                    <td><?php echo $row["drawn"]; ?></td>
                    <td><?php echo $row["points"]; ?></td>
                    <td><?php echo $row["percentage"]; ?>%</td>
                    <td>
                        <a href="admin-points-table.php?id=<?php echo $row['id']; ?>">Edit</a>
                        <a href="admin-points-table.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
