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

// Handle form submission for updating trainer details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {
    $trainer_id = $_POST['update_id'];
    $user_id = $_POST['user_id'];
    $certificate = $_POST['certificate'];
    $location = $_POST['location'];
    $sport = $_POST['sport'];
    $day_time = $_POST['day_time'];
    $state = $_POST['state'];

    // Update the trainer details in the database
    $sql = "UPDATE accepted_trainers SET user_id = ?, certificate = ?, location = ?, sport = ?, day_time = ?, state = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssi", $user_id, $certificate, $location, $sport, $day_time, $state, $trainer_id);

    if ($stmt->execute()) {
        echo "<script>alert('Trainer details updated successfully.'); window.location.href = 'trainerslist.php';</script>";
    } else {
        echo "<script>alert('Error updating trainer details.');</script>";
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
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
        }
        header, .navbar {
            background: #28a745;
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
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .btn-danger {
            margin: 5px;
            background-color: #dc3545;
            border: none;
        }
        .table-dark {
            background-color: #343a40;
            color: #ffffff;
        }
        .table-dark th, .table-dark td {
            vertical-align: middle;
        }
        .card-header {
            background-color: #28a745;
            color: #ffffff;
            font-size: 1.25rem;
            padding: 10px;
        }
        .form-button {
            display: inline-block;
            margin-top: 10px;
        }
        .form-button button {
            width: 120px;
        }
    </style>
    <script>
        function openEditModal(id, user_id, certificate, location, sport, day_time, state) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_user_id').value = user_id;
            document.getElementById('edit_certificate').value = certificate;
            document.getElementById('edit_location').value = location;
            document.getElementById('edit_sport').value = sport;
            document.getElementById('edit_day_time').value = day_time;
            document.getElementById('edit_state').value = state;
            $('#editTrainerModal').modal('show');
        }
    </script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <a class="navbar-brand" href="#">
        <img src="images/ss.png" alt="Logo">
        Trainer Finder
    </a>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="admin.php">Admin Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="trainer_applications.php">Trainer Applications</a>
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
                                    <button type="button" class="btn btn-warning btn-sm" onclick="openEditModal(
                                        <?php echo htmlspecialchars($row['id']); ?>, 
                                        '<?php echo htmlspecialchars($row['user_id']); ?>',
                                        '<?php echo htmlspecialchars($row['certificate']); ?>', 
                                        '<?php echo htmlspecialchars($row['location']); ?>', 
                                        '<?php echo htmlspecialchars($row['sport']); ?>', 
                                        '<?php echo htmlspecialchars($row['day_time']); ?>', 
                                        '<?php echo htmlspecialchars($row['state']); ?>'
                                    )">Edit</button>
                                    <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this trainer?')">
                                        <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
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

<!-- Edit Trainer Modal -->
<div class="modal fade" id="editTrainerModal" tabindex="-1" role="dialog" aria-labelledby="editTrainerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTrainerModalLabel">Edit Trainer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="update_id" id="edit_id">
                    <div class="form-group">
                        <label for="edit_user_id">User ID</label>
                        <input type="text" class="form-control" id="edit_user_id" name="user_id" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_certificate">Certificate</label>
                        <input type="text" class="form-control" id="edit_certificate" name="certificate" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_location">Location</label>
                        <input type="text" class="form-control" id="edit_location" name="location" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_sport">Sport</label>
                        <input type="text" class="form-control" id="edit_sport" name="sport" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_day_time">Day/Time</label>
                        <input type="text" class="form-control" id="edit_day_time" name="day_time" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_state">Status</label>
                        <input type="text" class="form-control" id="edit_state" name="state" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
