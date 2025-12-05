<?php
$conn = new mysqli('localhost', 'root', '', 'cricketdb');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Dynamically fetch the latest issue ID
$issue_result = $conn->query("SELECT id, email FROM issues ORDER BY created_at DESC LIMIT 1");

if ($issue_result && $issue_result->num_rows > 0) {
    $issue_data = $issue_result->fetch_assoc();
    $issue_id = $issue_data['id'];
    $user_email = $issue_data['email'];

    // Fetch all messages for the conversation
    $result = $conn->query("SELECT * FROM conversations WHERE issue_id = $issue_id ORDER BY created_at");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sender = $row['sender'] === 'user' ? $user_email : 'Admin';
            $timestamp = $row['created_at']; // The timestamp of the message
            $class = $row['sender'] === 'user' ? 'message user' : 'message admin';
            echo "<div class='$class'>
                    <div class='content'>
                        <strong>{$sender}:</strong> {$row['message']}
                        <br><small class='timestamp'>{$timestamp}</small>
                    </div>
                </div>";
        }
    } else {
        echo "<p>No conversation messages found for this issue.</p>";
    }
} else {
    echo "<p>No issues found in the database.</p>";
}

$conn->close();
?>
