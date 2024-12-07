<?php
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$conn = new mysqli('localhost', 'root', '', 'TrainerFinder');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepared statement to find trainers based on location and sport
$stmt = $conn->prepare(query: "SELECT username,sport,location,day_time,reservations FROM accepted_trainers WHERE id = ?");
$varLocation = intval($id);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo '<div>'.$row['username'] .'</div>';
    echo ' <div>'. $row['sport'] . '</div>';
    echo ' <div>'.$row['location'] .'</div>';
    echo ' <div>'.$row['day_time'] .'</div>';
    echo ' <div>'.$row['reservations'] .'</div>';

}

$stmt->close();
$conn->close();