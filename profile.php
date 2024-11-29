<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start(); // Start the session to access user data

// Include the database connection file
include('db.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php"); // Redirect to login if not logged in
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch user data (including email and username)
$sql = "SELECT username, email FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

// Handle trainer application form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $location = $_POST['location'];
    $sport = $_POST['sport'];
    $dayTime = implode(',', $_POST['dayTime']); // Store as a comma-separated string
    $certificate = $_FILES['certificate']['name'];
    $email = $user['email']; // Get the email from the fetched user data
    $username = $user['username']; // Get the username from the fetched user data

    // Move uploaded file to the uploads directory
    if (!file_exists('uploads')) {
        mkdir('uploads', 0777, true);
    }
    $uploadPath = "uploads/" . basename($certificate);
    if (move_uploaded_file($_FILES['certificate']['tmp_name'], $uploadPath)) {
        // Insert application into the database with a default state of 'pending'
        $sql = "INSERT INTO trainer_applications (user_id, username, email, location, sport, day_time, certificate, state) 
                VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')";
        $stmt = $conn->prepare($sql);
        // Correct the bind_param to match 7 values: user_id (int), username (string), email (string), location (string), sport (string), day_time (string), certificate (string)
        $stmt->bind_param("issssss", $user_id, $username, $email, $location, $sport, $dayTime, $certificate);
        if ($stmt->execute()) {
            echo '<script>alert("Application submitted successfully!");</script>';
        } else {
            echo '<script>alert("Failed to submit application. Please try again.");</script>';
        }
    } else {
        echo '<script>alert("Failed to upload certificate. Please try again.");</script>';
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Trainer Finder</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: white;
        }
        nav {
            background-color: #28a745;
        }
        .card {
            background-color: #343a40;
            border: none;
            margin: 20px auto;
            max-width: 600px;
        }
        .card-title {
            color: #28a745;
        }
        label, #applyModalLabel {
            color: black;
        }
        .error {
            color: red;
        }
        .multi-select {
            height: 150px;
            overflow-y: auto;
        }
    </style>
    <script>
        function validateForm(event) {
            event.preventDefault(); // Prevent default form submission
            let isValid = true;

            // Clear previous error messages
            document.querySelectorAll('.error').forEach(el => el.textContent = '');

            const dayTimeSelections = Array.from(document.getElementById('dayTime').selectedOptions);
            const certificate = document.getElementById('certificate').files.length;

            // Validate day and time selections
            if (dayTimeSelections.length === 0) {
                document.getElementById('dayTimeError').textContent = 'At least one day and time must be selected';
                isValid = false;
            }

            
                    // Validate certificate upload
                    if (certificate === 0) {
                document.getElementById('certificateError').textContent = 'Certificate image is required';
                isValid = false;
            }

            if (isValid) {
                document.getElementById('applyForm').submit();
            }
        }
    </script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <a class="navbar-brand" href="#">
        <img src="images/ss.png" alt="Logo" style="height:30px; width:30px; margin-right:10px;">
        Trainer Finder
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="Home.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="trainers.php">Trainers</a></li>
            <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                    <i class="fas fa-user"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="profile.php">View Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="login.php">Log Out</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center mb-4">User Profile</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Profile Information</h5>
            <p class="card-text"><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <button class="btn btn-success" data-toggle="modal" data-target="#applyModal">Apply as a Trainer</button>
        </div>
    </div>
</div>

<div class="modal fade" id="applyModal" tabindex="-1" role="dialog" aria-labelledby="applyModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="applyModalLabel">Trainer Application</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="applyForm" method="POST" enctype="multipart/form-data" onsubmit="validateForm(event)">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="location">Location</label>
                        <select class="form-control" id="location" name="location">
                            <option value="" disabled selected>Select your location</option>
                            <option value="New Cairo">New Cairo</option>
                            <option value="Nasr City">Nasr City</option>
                            <option value="Sheraton">Sheraton</option>
                            <option value="Korba">Korba</option>
                            <option value="Manial">Manial</option>
                            <option value="6th of October">6th of October</option>
                            <option value="Dokki">Dokki</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sport">Sport</label>
                        <select class="form-control" id="sport" name="sport">
                            <option value="" disabled selected>Select your sport</option>
                            <option value="Squash">Squash</option>
                            <option value="Padel">Padel</option>
                            <option value="Basketball">Basketball</option>
                            <option value="Tennis">Tennis</option>
                            <option value="Football">Football</option>
                            <option value="Boxing">Boxing</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dayTime">Available Days and Times</label>
                        <select multiple class="form-control multi-select" id="dayTime" name="dayTime[]">
                            <option value="Monday 02:00 PM">Monday 02:00 PM</option>
                            <option value="Monday 05:00 PM">Monday 05:00 PM</option>
                            <option value="Tuesday 11:00 AM">Tuesday 11:00 AM</option>
                            <option value="Wednesday 03:00 PM">Wednesday 03:00 PM</option>
                            <option value="Friday 10:00 AM">Friday 10:00 AM</option>
                        </select>
                        <span id="dayTimeError" class="error"></span>
                    </div>
                   
<div class="form-group">
    <label for="certificate">Upload Certificate</label>
    <input type="file" class="form-control" id="certificate" name="certificate" accept=".pdf">
    <span class="error" id="certificateError"></span>
</div>
                    <button type="submit" class="btn btn-success">Submit Application</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
