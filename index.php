<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Find Your Trainer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
            /* Prevent scrolling */
        }

        #nav {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: black;
            color: white;
            /* Change text color to white for better readability */
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

        .video-container {
            position: relative;
            height: 100%;
            overflow: hidden;
        }

        .background-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Ensures video covers the entire container */
            position: absolute;
            top: 0;
            left: 0;
            z-index: 0;
            /* Set a lower z-index so the overlay is above */
        }

        .overlay {
            position: absolute;
            top: 50%;
            left: 20px;
            /* Position to the left */
            transform: translateY(-50%);
            color: white;
            text-align: left;
            z-index: 1;
            /* Set a higher z-index so it is above the video */
        }

        .animated-text {
            font-size: 2rem;
            animation: fadeIn 2s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .join-button {
            margin-top: 20px;
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            background-color: white;
            color: black;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .join-button:hover {
            background-color: green;
            color: white;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success" id="nav">
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
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="trainers.php">Trainers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About Us</a>
                </li>
              
                <li class="nav-item">
                    <a class="nav-link" href="Login.php"><i class="fas fa-user"></i></a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="video-container">
        <video autoplay muted loop class="background-video">
            <source src="videos/main.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="overlay">
            <h1 class="animated-text text-success bold ">Welcome to Find Your Trainer</h1>
            <button class="join-button">JOIN US</button>
        </div>
    </div>

    <script>
        document.querySelector('.join-button').addEventListener('click', function() {
            window.location.href = 'Login.php'; 
        });
    </script>
</body>

</html>