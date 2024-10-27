<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Trainers - Trainer Finder</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: black;
            color: white;
            font-family: Arial, sans-serif;
        }
        nav {
            background-color: #28a745;
        }
        .hero-section {
            background: url('images/trainers-banner.jpg') no-repeat center center;
            background-size: cover;
            height: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            text-align: center;
        }
        .hero-section h1 {
            font-size: 3rem;
            font-weight: bold;
        }
        .search-section {
            margin: 40px auto;
            padding: 20px;
            max-width: 800px;
            background-color: #343a40;
            border-radius: 8px;
        }
        .search-section h2 {
            color: #28a745;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }
        .results-section {
            margin: 40px auto;
            max-width: 800px;
        }
        .trainer-card {
            background-color: #444;
            padding: 20px;
            margin: 10px 0;
            border-radius: 8px;
            color: #fff;
        }
        .trainer-card h3 {
            color: #28a745;
            margin-bottom: 10px;
        }
        .footer {
            background-color: #343a40;
            color: #ffffff;
            padding: 20px 0;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="#">
        <img src="images/ss.png" alt="Logo" style="height:30px; width:30px; margin-right:10px;">
        Trainer Finder
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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

<!-- Hero Section -->
<div class="hero-section">
    <h1>Find Your Trainer</h1>
</div>

<!-- Search Section -->
<div class="search-section">
    <h2>Search for Trainers</h2>
    <form method="GET" action="trainers.php">
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
                <option value="Football">Football</option>
                <option value="Crossfit">Crossfit</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success btn-block">Find Trainers</button>
    </form>
</div>

<!-- Results Section -->
<div class="results-section">
    <?php
    if (isset($_GET['location']) && isset($_GET['sport'])) {
        $location = $_GET['location'];
        $sport = $_GET['sport'];

        // Database connection (adjust as needed)
        $conn = new mysqli('localhost', 'username', 'password', 'TrainerFinder');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepared statement to find trainers based on location and sport
        $stmt = $conn->prepare("SELECT * FROM trainers WHERE location = ? AND sport = ?");
        $stmt->bind_param("ss", $location, $sport);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="trainer-card">';
                echo '<h3>' . htmlspecialchars($row['username']) . '</h3>';
                echo '<p><strong>Sport:</strong> ' . htmlspecialchars($row['sport']) . '</p>';
                echo '<p><strong>Location:</strong> ' . htmlspecialchars($row['location']) . '</p>';
                echo '<p><strong>Available Timings:</strong> ' . htmlspecialchars($row['timings']) . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>No trainers found for the selected location and sport.</p>';
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</div>

<footer class="footer">
    <div class="container text-center">
        <h4>Contact Us</h4>
        <ul class="contact-info">
            <li>Email: nourhanmuhammad@trainerfinder.com</li>
            <li>Phone: +1 234 567 890</li>
            <li>Address: 123 Fitness Lane, Workout City, USA</li>
        </ul>
        <div class="social-icons">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
        </div>
        <p>&copy; 2024 Trainer Finder. All rights reserved.</p>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
