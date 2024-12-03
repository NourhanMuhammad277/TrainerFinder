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

// Handle user deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully.'); window.location.href = 'users.php';</script>";
    } else {
        echo "<script>alert('Error deleting user.');</script>";
    }
    $stmt->close();
}

// Fetch all users
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List | Trainer Finder</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script defer src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script defer src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
        function openEditModal(id, username, email) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_username').value = username;
            document.getElementById('edit_email').value = email;
            $('#editUserModal').modal('show');
        }

        function confirmDelete() {
            return confirm('Are you sure you want to delete this user?');
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
                <a class="nav-link" href="Login.php">Log Out</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center mb-4">Users List</h2>
    <div class="card">
        <div class="card-body">
            <?php if ($result && $result->num_rows > 0): ?>
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td>
                                    <form method="POST" style="display: inline;" onsubmit="return confirmDelete()">
                                        <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                    <button type="button" class="btn btn-warning btn-sm" onclick="openEditModal(
                                        <?php echo htmlspecialchars($row['id']); ?>, 
                                        '<?php echo htmlspecialchars($row['username']); ?>',
                                        '<?php echo htmlspecialchars($row['email']); ?>'
                                    )">Edit</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center">No users found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="update_id" id="edit_id">
                    <div class="form-group">
                        <label for="edit_username">Username</label>
                        <input type="text" class="form-control" id="edit_username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


</body>
</html>
