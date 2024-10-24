<?php
// Database connection
$conn = new mysqli('localhost', 'username', 'password', 'database');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch trainers
$result = $conn->query("SELECT * FROM trainers");
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="trainer-profile">';
        echo '<h3>' . $row['name'] . '</h3>';
        echo '<p>' . $row['specialty'] . '</p>';
        echo '</div>';
    }
} else {
    echo "No trainers found.";
}
$conn->close();
?>
