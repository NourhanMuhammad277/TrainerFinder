<!DOCTYPE html>
<html lang="en">
<head>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Finder</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: black;
            color: white; /* Change text color to white for better readability */
        }
        header {
            background: black;
            color: #ffffff;
            padding: 20px 0;
            text-align: center;
        }
        .logo {
            text-align: center;
        }
        .logo-image {
            width: 100px;
            height: auto;
            margin-bottom: 10px;
        }
        nav {
            margin: 20px 0;
        }
        nav a {
            margin: 0 15px;
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
        }
        .hero {
            background-image: url('images/ttt.jpg');
            background-size: cover;
            color: #ffffff;
            padding: 100px 0;
            text-align: center;
        }
        .hero h1 {
            font-size: 50px;
        }
        .hero p {
            font-size: 20px;
        }
        .content {
            padding: 20px;
            text-align: center;
        }
        .card {
            display: inline-block;
            margin: 15px;
            padding: 20px;
            background: white;
            border: 1px solid #28a745;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .card img {
            max-width: 100%; /* This allows the image to resize to fit its parent */
            border-radius: 8px; /* Maintain existing styling */
        }
        .trainer-image {
            max-width: 200px; /* Set to a smaller max-width */
            height: auto; /* Maintain aspect ratio */
            margin-bottom: 15px; /* Add space below the image */
        }
        .details-button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }
        .details-button:hover {
            background-color: #218838;
        }
        .video-slider {
            position: relative;
            margin: 20px 0;
        }
        .video-slider video {
            width: 100%;
            display: none;
        }
      
        .video-slider video.active {
            display: block;
        }
        .slider-controls {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
        }
        .slider-button {
            background-color: #28a745;
            border: none;
            color: white;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
        }
        .footer {
            background-color: #343a40;
            color: #ffffff;
            padding: 20px 0;
        }
        .section-title {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .contact-info {
            list-style-type: none;
            padding: 0;
        }
        #ss{
            color:black;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        }
        #sport
        {
            font-family:Verdana, Geneva, Tahoma, sans-serif;
            color:black;
            font-style: bold;
        }
        .contact-info li {
            margin: 5px 0;
        }
        .social-icons {
            margin: 15px 0;
        }
        .social-icons a {
            margin: 0 10px;
            color: white;
        }
        .contact-form {
            margin-top: 20px;
        }
        .contact-form .form-group {
            margin-bottom: 15px;
        }
    </style>
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
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Trainers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php"><i class="fas fa-user"></i></a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="hero">
        <h1>Welcome to Trainer Finder</h1>
        <p>Your ultimate destination for all things sports!</p>
    </div>

    <div class="content">
        <h2>Featured Sports</h2>
        <div class="card">
            <h3 id="sport">Basketball</h3>
            <p id="ss">Join us for the latest news, scores, and events.</p>
        </div>
        <div class="card">
            <h3 id="sport">Soccer</h3>
            <p id="ss" >Get updates on your favorite teams and matches.</p>
        </div>
        <div class="card">
            <h3 id="sport">Fitness</h3>
            <p id="ss">Find workout tips, routines, and personal trainers.</p>
        </div>

        <h2 id="trainers">Find Our Trainers</h2>
        <div class="card">
            <img src="images/coach1.jpg" alt="John Doe" class="trainer-image">
            <h3>John Doe</h3>
            <p>Expert in Strength Training</p>
            <button class="details-button">Details</button>
        </div>
        <div class="card">
            <img src="images/coach22.jpg" alt="Jane Smith" class="trainer-image">
            <h3>Jane Smith</h3>
            <p>Certified Yoga Instructor</p>
            <button class="details-button">Details</button>
        </div>
        <div class="card">
            <img src="images/coach33.jpg" alt="Mark Johnson" class="trainer-image">
            <h3>Mark Johnson</h3>
            <p>Specialist in Cardio and Endurance</p>
            <button class="details-button">Details</button>
        </div>

        <h2 id="videos">Video Slider</h2>
        <div class="video-slider">
            <video class="active" controls>
                <source src="videos/fitness2.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <video controls>
                <source src="videos/1.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <video controls>
                <source src="videos/fitness3.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="slider-controls">
                <button class="slider-button" id="prevButton">&lt;</button>
                <button class="slider-button" id="nextButton">&gt;</button>
            </div>
        </div>
    </div>

    <footer class="footer bg-dark text-white">
        <div class="container">
            <div class="row py-4">
                <div class="col-md-4">
                    <h3 class="section-title">About Us</h3>
                    <p>At Trainer Finder, we connect you with professional trainers who can help you achieve your fitness goals, no matter where you are on your fitness journey.</p>
                </div>
                <div class="col-md-4">
                    <h3 class="section-title">Our Address</h3>
                    <ul class="contact-info">
                        <li><i class="fas fa-map-marker-alt"></i> 198 West 21th Street, Suite 721 New York, NY 10016</li>
                        <li><i class="fas fa-phone"></i> +1 235 2355 98</li>
                        <li><i class="fas fa-envelope"></i> <a href="mailto:info@yoursite.com">info@yoursite.com</a></li>
                        <li><i class="fas fa-globe"></i> <a href="#">www.yoursite.com</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h3 class="section-title">Drop Us a Line</h3>
                    <form class="contact-form">
                        <div class="form-group">
                            <label for="name" class="sr-only">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Name" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <label for="message" class="sr-only">Message</label>
                            <textarea class="form-control" id="message" rows="4" placeholder="Message" required></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-md">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="social-icons">
                        <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-dribbble"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-youtube"></i></a>
                    </p>
                    <p>&copy; 2024 Trainer Finder. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        const videos = document.querySelectorAll('.video-slider video');
        let currentVideo = 0;

        // Show the first video
        videos[currentVideo].classList.add('active');

        // Function to change video
        function changeVideo(direction) {
            videos[currentVideo].classList.remove('active');
            currentVideo = (currentVideo + direction + videos.length) % videos.length;
            videos[currentVideo].classList.add('active');
        }

        // Event listeners for buttons
        document.getElementById('prevButton').addEventListener('click', function() {
            changeVideo(-1);
        });
        document.getElementById('nextButton').addEventListener('click', function() {
            changeVideo(1);
        });
    </script>

</body>
</html>
