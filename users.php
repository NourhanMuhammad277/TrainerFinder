<?php
include 'db.php'; 

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle user deletion
if (isset($_GET['delete_id'])) {
    $deleteId = (int)$_GET['delete_id'];
    $deleteQuery = "DELETE FROM users WHERE id = $deleteId";

    if (mysqli_query($conn, $deleteQuery)) {
        header("Location: users.php?message=User deleted successfully.");
        exit;
    } else {
        echo "Error deleting user: " . mysqli_error($conn);
    }
}

if (isset($_GET['id'])) {
    $userId = (int)$_GET['id'];
    
    $query = "SELECT username, email FROM users WHERE id = $userId";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        
        $updateQuery = "UPDATE users SET username = '$username', email = '$email' WHERE id = $userId";
        if (mysqli_query($conn, $updateQuery)) {
            header("Location: users.php?message=User updated successfully.");
            exit;
        } else {
            echo "Error updating user: " . mysqli_error($conn);
        }
    }
}

$query = "SELECT id, username, email FROM users"; 
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List | Trainer Finder</title>
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
            width: auto;   
            margin-right: 10px;
        }
        nav a {
            color: #ffffff;
            font-weight: bold;
        }
        .content {
            padding: 20px;
        }
        table {
            width: 100%;
            background-color: #343a40;
            border-radius: 8px;
            margin-top: 20px;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #495057;
        }
        tr:hover {
            background-color: #495057;
        }
        .icon {
            cursor: pointer;
            color: #ffffff;
        }
        .icon:hover {
            color: #28a745;
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
                
                <li class="nav-item">
                    <a class="nav-link" href="admin.php">Admin Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Login.php">Log Out</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="content">
        <h1>Users List</h1>
        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_GET['message']); ?></div>
        <?php endif; ?>
        <table class="table table-dark">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td>
                            <span class="icon" onclick="location.href='users.php?id=<?php echo $row['id']; ?>'">
                                <i class="fas fa-edit"></i> Edit
                            </span>
                            &nbsp;
                            <span class="icon" onclick="if(confirm('Are you sure you want to delete this user?')) location.href='users.php?delete_id=<?php echo $row['id']; ?>'">
                                <i class="fas fa-trash-alt"></i> Delete
                            </span>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <?php if (isset($_GET['id'])): ?>
            <h2>Edit User</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        <?php endif; ?>
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
