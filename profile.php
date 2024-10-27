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

// Prepare the SQL query to fetch user data
$sql = "SELECT username, email FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); // Bind the user ID parameter
$stmt->execute();
$result = $stmt->get_result();

// Check if a user is found
if ($result->num_rows > 0) {
    // Fetch user data
    $user = $result->fetch_assoc();
} else {
    // Handle case where user is not found
    echo "User not found.";
    exit();
}
// Add this code in your profile.php to handle the form submission.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ensure the user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: Login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $location = $_POST['location'];
    $sport = $_POST['sport'];
    $dayTime = implode(',', $_POST['dayTime']); // Store as comma-separated string
    $certificate = $_FILES['certificate']['name']; // File upload logic here

    // Move uploaded file
    move_uploaded_file($_FILES['certificate']['tmp_name'], "uploads/" . $certificate);

    // Insert application into the database
    $sql = "INSERT INTO trainer_applications (user_id, location, sport, day_time, certificate) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $user_id, $location, $sport, $dayTime, $certificate);
    $stmt->execute();
    $stmt->close();
    
    // Optionally, display a success message
    echo '<script>alert("Application submitted successfully!");</script>';
}

// Close the statement and connection
$stmt->close();
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
            margin: 0;
            padding: 0;
            background-color: black;
            color: white;
        }
        nav {
            background-color: #28a745; /* Navbar color */
        }
        .card {
            background-color: #343a40; /* Dark background for the card */
            border: none; /* Remove the default border */
            margin: 20px auto;
            max-width: 600px;
        }
        .card-title {
            color: #28a745; /* Green color for the title */
        }
        .card-text {
            color: #ffffff; /* White color for the text */
        }
        label ,#applyModalLabel{
            color: black; /* Change label color to black */
        }
        .error {
            color: red; /* Error message color */
        }
        /* Style for multi-select dropdown */
        .multi-select {
            height: 150px; /* Set a height for the dropdown */
            overflow-y: auto; /* Add a scrollbar if needed */
        }
    </style>
    <script>
        function validateForm(event) {
            event.preventDefault(); // Prevent form submission
            let isValid = true;

            // Clear previous error messages
            document.querySelectorAll('.error').forEach(el => el.textContent = '');

            // Get values from inputs
            const dayTimeSelections = Array.from(document.getElementById('dayTime').selectedOptions);
            const certificate = document.getElementById('certificate').files.length;

            // Validate day and time selections
            if (dayTimeSelections.length === 0) {
                document.getElementById('dayTimeError').textContent = 'At least one day and time must be selected';
                isValid = false;
            }

            // Validate certificate
            if (certificate === 0) {
                document.getElementById('certificateError').textContent = 'Certificate image is required';
                isValid = false;
            }

            // If valid, submit the form
            if (isValid) {
                document.getElementById('applyForm').submit(); // Submit the form if valid
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
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="Home.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="trainers.php">Trainers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="about.php">About Us</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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

<div class="modal fade" id="applyModal" tabindex="-1" role="dialog" aria-labelledby="applyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="applyModalLabel">Trainer Application</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="applyForm" onsubmit="validateForm(event)">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="location">Location</label>
                        <select class="form-control" id="location">
                            <option value="" disabled selected>Select your location</option>
                            <option value="New Cairo">New Cairo</option>
                            <option value="Nasr City">Nasr City</option>
                            <option value="Sheraton">Sheraton</option>
                            <option value="Korba">Korba</option>
                            <option value="Manial">Manial</option>
                            <option value="6th of October">6th of October</option>
                            <option value="Dokki">Dokki</option>
                        </select>
                        <span class="error" id="locationError"></span>
                    </div>
                    <div class="form-group">
                        <label for="sport">Sport</label>
                        <select class="form-control" id="sport">
                            <option value="" disabled selected>Select your sport</option>
                            <option value="Squash">Squash</option>
                            <option value="Padel">Padel</option>
                            <option value="Basketball">Basketball</option>
                            <option value="Football">Football</option>
                            <option value="Crossfit">Crossfit</option>
                        </select>
                        <span class="error" id="sportError"></span>
                    </div>
                    <div class="form-group">
                        <label for="dayTime">Select Day and Time</label>
                        <select multiple class="form-control multi-select" id="dayTime">
                            <option value="Monday 08:00 AM">Monday 08:00 AM</option>
                            <option value="Monday 08:30 AM">Monday 08:30 AM</option>
                            <option value="Monday 09:00 AM">Monday 09:00 AM</option>
                            <option value="Monday 09:30 AM">Monday 09:30 AM</option>
                            <option value="Monday 10:00 AM">Monday 10:00 AM</option>
                            <option value="Monday 10:30 AM">Monday 10:30 AM</option>
                            <option value="Monday 11:00 AM">Monday 11:00 AM</option>
                            <option value="Monday 11:30 AM">Monday 11:30 AM</option>
                            <option value="Tuesday 08:00 AM">Tuesday 08:00 AM</option>
                            <option value="Tuesday 08:30 AM">Tuesday 08:30 AM</option>
                            <option value="Tuesday 09:00 AM">Tuesday 09:00 AM</option>
                            <option value="Tuesday 09:30 AM">Tuesday 09:30 AM</option>
                            <option value="Tuesday 10:00 AM">Tuesday 10:00 AM</option>
                            <option value="Tuesday 10:30 AM">Tuesday 10:30 AM</option>
                            <option value="Tuesday 11:00 AM">Tuesday 11:00 AM</option>
                            <option value="Tuesday 11:30 AM">Tuesday 11:30 AM</option>
                            <option value="Wednesday 08:00 AM">Wednesday 08:00 AM</option>
                            <option value="Wednesday 08:30 AM">Wednesday 08:30 AM</option>
                            <option value="Wednesday 09:00 AM">Wednesday 09:00 AM</option>
                            <option value="Wednesday 09:30 AM">Wednesday 09:30 AM</option>
                            <option value="Wednesday 10:00 AM">Wednesday 10:00 AM</option>
                            <option value="Wednesday 10:30 AM">Wednesday 10:30 AM</option>
                            <option value="Wednesday 11:00 AM">Wednesday 11:00 AM</option>
                            <option value="Wednesday 11:30 AM">Wednesday 11:30 AM</option>
                            <option value="Thursday 08:00 AM">Thursday 08:00 AM</option>
                            <option value="Thursday 08:30 AM">Thursday 08:30 AM</option>
                            <option value="Thursday 09:00 AM">Thursday 09:00 AM</option>
                            <option value="Thursday 09:30 AM">Thursday 09:30 AM</option>
                            <option value="Thursday 10:00 AM">Thursday 10:00 AM</option>
                            <option value="Thursday 10:30 AM">Thursday 10:30 AM</option>
                            <option value="Thursday 11:00 AM">Thursday 11:00 AM</option>
                            <option value="Thursday 11:30 AM">Thursday 11:30 AM</option>
                            <option value="Friday 08:00 AM">Friday 08:00 AM</option>
                            <option value="Friday 08:30 AM">Friday 08:30 AM</option>
                            <option value="Friday 09:00 AM">Friday 09:00 AM</option>
                            <option value="Friday 09:30 AM">Friday 09:30 AM</option>
                            <option value="Friday 10:00 AM">Friday 10:00 AM</option>
                            <option value="Friday 10:30 AM">Friday 10:30 AM</option>
                            <option value="Friday 11:00 AM">Friday 11:00 AM</option>
                            <option value="Friday 11:30 AM">Friday 11:30 AM</option>
                            <option value="Saturday 08:00 AM">Saturday 08:00 AM</option>
                            <option value="Saturday 08:30 AM">Saturday 08:30 AM</option>
                            <option value="Saturday 09:00 AM">Saturday 09:00 AM</option>
                            <option value="Saturday 09:30 AM">Saturday 09:30 AM</option>
                            <option value="Saturday 10:00 AM">Saturday 10:00 AM</option>
                            <option value="Saturday 10:30 AM">Saturday 10:30 AM</option>
                            <option value="Saturday 11:00 AM">Saturday 11:00 AM</option>
                            <option value="Saturday 11:30 AM">Saturday 11:30 AM</option>
                            <option value="Sunday 08:00 AM">Sunday 08:00 AM</option>
                            <option value="Sunday 08:30 AM">Sunday 08:30 AM</option>
                            <option value="Sunday 09:00 AM">Sunday 09:00 AM</option>
                            <option value="Sunday 09:30 AM">Sunday 09:30 AM</option>
                            <option value="Sunday 10:00 AM">Sunday 10:00 AM</option>
                            <option value="Sunday 10:30 AM">Sunday 10:30 AM</option>
                            <option value="Sunday 11:00 AM">Sunday 11:00 AM</option>
                            <option value="Sunday 11:30 AM">Sunday 11:30 AM</option>
                        </select>
                        <span class="error" id="dayTimeError"></span>
                    </div>
                    <div class="form-group">
                        <label for="certificate">Upload Certificate</label>
                        <input type="file" class="form-control" id="certificate" accept="image/*">
                        <span class="error" id="certificateError"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="submitApplication" onclick="validateForm(event)">Submit Application</button>
            </div>
        </div>
    </div>
</div>

<!-- Thank You Modal -->
<div class="modal fade" id="thankYouModal" tabindex="-1" role="dialog" aria-labelledby="thankYouModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="thankYouModalLabel">Thank You!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Thank you for applying! Please check your email for acceptance.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
