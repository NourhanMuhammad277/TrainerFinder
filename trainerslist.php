<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include('db.php');

// Check if the user is an admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in as admin
    exit();
}

// Handle delete action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $sql = "DELETE FROM accepted_trainers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "<script>alert('Trainer deleted successfully.'); window.location.href = 'trainerslist.php';</script>";
    } else {
        echo "<script>alert('Error deleting trainer.');</script>";
    }
    $stmt->close();
}

// Fetch all trainers
$sql = "SELECT * FROM accepted_trainers";
$result = $conn->query($sql);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
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
        .card {
            background-color: #343a40;
            color: white;
            border: none;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .btn-warning, .btn-danger {
            margin: 5px;
        }
    </style>
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this trainer?');
        }
    </script>
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
            <li class="nav-item">
                <a class="nav-link" href="admin.php">Admin Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="trainer_application.php">Trainer Applications</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user"></i> Admin
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="login.php">Log Out</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center mb-4">Trainer List</h2>
    <div class="card">
        <div class="card-body">
            <?php if ($result && $result->num_rows > 0): ?>
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User ID</th>
                            <th>Certificate</th>
                            <th>Location</th>
                            <th>Sport</th>
                            <th>Day/Time</th>
                            <th>Status</th>
                            <th>Approved At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                                <td>
                                    <a href="uploads/<?php echo htmlspecialchars($row['certificate']); ?>" target="_blank">View Certificate</a>
                                </td>
                                <td><?php echo htmlspecialchars($row['location']); ?></td>
                                <td><?php echo htmlspecialchars($row['sport']); ?></td>
                                <td><?php echo htmlspecialchars($row['day_time']); ?></td>
                                <td><?php echo htmlspecialchars($row['state']); ?></td>
                                <td><?php echo htmlspecialchars($row['approved_at']); ?></td>
                                <td>
                                    <form method="POST" style="display: inline;" onsubmit="return confirmDelete()">
                                        <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                    <a href="edit_trainer.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center">No trainers found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
