<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Trainer Finder</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: black;
            color: white;
        }
        header, .navbar {
            background: black;
            color: #ffffff;
        }
        .navbar-brand img {
            height: 30px;
            width: 30px;
            margin-right: 10px;
        }
        nav a {
            color: #ffffff;
            font-weight: bold;
        }
        .content {
            padding: 20px;
        }
        .admin-section {
            background-color: #343a40;
            padding: 20px;
            border-radius: 8px;
            color: white;
            text-align: center;
        }
        .admin-section h2 {
            font-size: 28px;
            margin-bottom: 20px;
        }
        .admin-section button {
            background-color: #28a745;
            border: none;
            padding: 10px 20px;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .admin-section button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <a class="navbar-brand" href="#">
            <img src="images/ss.png" alt="Logo">
            Trainer Finder
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">

            </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin.php">Admin Dashboard</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i> Admin
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="Login.php">Log Out</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="content">
        <h1>Admin Dashboard</h1>
        <div class="admin-section">
            <h2>Manage Trainer Applications</h2>
            <p>Review and approve or reject trainer applications.</p>
            <button onclick="location.href='trainer_applications.php'">Go to Applications</button>
        </div>

        <div class="admin-section" style="margin-top: 20px;">
            <h2>View All Users</h2>
            <p>View and manage the users registered on the platform.</p>
            <button onclick="location.href='users.php'">View Users</button>
        </div>

        <div class="admin-section" style="margin-top: 20px;">
            <h2>Site Settings and Reports</h2>
            <p>Configure site settings or view detailed reports.</p>
            <button onclick="location.href='settings.php'">Settings & Reports</button>
        </div>
    </div>

    <footer class="footer bg-dark text-center text-white mt-5 py-4">
        <div class="container">
            <p>&copy; 2024 Trainer Finder. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
