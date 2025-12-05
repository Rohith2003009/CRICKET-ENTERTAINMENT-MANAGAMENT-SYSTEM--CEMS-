<?php
$conn = new mysqli('localhost', 'root', '', 'cricketdb');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $issue_id = intval($_POST['issue_id']);
    $message = $conn->real_escape_string($_POST['message']);

    if (!empty($message)) {
        // Insert admin's reply into the conversations table
        if ($conn->query("INSERT INTO conversations (issue_id, sender, message) VALUES ($issue_id, 'admin', '$message')")) {
            echo "Reply sent successfully!<br>";  // Debug message
        } else {
            echo "Error: " . $conn->error . "<br>";  // Debug message
        }
    } else {
        echo "Message cannot be empty!<br>";
    }
}

// Fetch all issues
$issues = $conn->query("SELECT * FROM issues");

if ($issues) {
    while ($row = $issues->fetch_assoc()) {
        $issue_id = $row['id'];
        $email = $row['email'];

        echo "<h3>Conversation with {$email}:</h3>";

        // Fetch all messages for the current issue
        $result = $conn->query("SELECT * FROM conversations WHERE issue_id = $issue_id ORDER BY created_at");

        if ($result) {
            echo "<div style='border: 1px solid #ccc; padding: 10px;'>";
            while ($message = $result->fetch_assoc()) {
                $sender = $message['sender'] === 'user' ? $email : 'Admin';
                echo "<p><strong>{$sender}:</strong> {$message['message']} <br><small>{$message['created_at']}</small></p>";
            }
            echo "</div>";
        } else {
            echo "Error fetching conversation: " . $conn->error . "<br>";  // Debug message
        }

        // Admin reply form
        echo '<form method="POST" style="margin-top: 10px;">
                <input type="hidden" name="issue_id" value="' . $issue_id . '">
                <textarea name="message" placeholder="Reply to this issue" rows="3" required></textarea>
                <button type="submit">Send Reply</button>
              </form>';
    }
} else {
    echo "Error fetching issues: " . $conn->error . "<br>";  // Debug message
}

$conn->close();
?>
