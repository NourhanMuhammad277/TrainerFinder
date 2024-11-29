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

// Handle accept/deny actions
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'], $_POST['application_id'])) {
    $application_id = intval($_POST['application_id']);
    $action = $_POST['action'];

    // Fetch application details for the specified ID
    $sql_fetch = "SELECT * FROM trainer_applications WHERE id = ?";
    $stmt_fetch = $conn->prepare($sql_fetch);
    $stmt_fetch->bind_param("i", $application_id);
    $stmt_fetch->execute();
    $result_fetch = $stmt_fetch->get_result();

    if ($result_fetch->num_rows > 0) {
        $application = $result_fetch->fetch_assoc();
        $user_id = $application['user_id'];
        $certificate = $application['certificate'];
        $location = $application['location'];
        $sport = $application['sport'];
        $day_time = $application['day_time'];

        // Fetch user details (username, email, password)
        $sql_user = "SELECT username, email, password FROM users WHERE id = ?";
        $stmt_user = $conn->prepare($sql_user);
        $stmt_user->bind_param("i", $user_id);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();
        
        if ($result_user->num_rows > 0) {
            $user = $result_user->fetch_assoc();
            $username = $user['username'];
            $email = $user['email'];
         
            if ($action === 'accept') {
                // Insert into `accepted_trainers`
                $sql_insert = "INSERT INTO accepted_trainers (user_id, username, email, certificate, location, sport, day_time, state, approved_at) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, 'accepted', NOW())";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bind_param("issssss", $user_id, $username, $email, $certificate, $location, $sport, $day_time);

                if ($stmt_insert->execute()) {
                    // Update the application state in `trainer_applications`
                    $sql_update = "UPDATE trainer_applications SET state = 'accepted' WHERE id = ?";
                    $stmt_update = $conn->prepare($sql_update);
                    $stmt_update->bind_param("i", $application_id);
                    $stmt_update->execute();

                    echo "<script>alert('Trainer accepted and added to database successfully.'); window.location.href = 'trainerslist.php';</script>";
                } else {
                    echo "<script>alert('Error adding trainer to accepted list. Please try again.');</script>";
                }
                $stmt_insert->close();
            } elseif ($action === 'deny') {
                // Update the application state to `denied`
                $sql_update = "UPDATE trainer_applications SET state = 'denied' WHERE id = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("i", $application_id);

                if ($stmt_update->execute()) {
                    echo "<script>alert('Trainer application denied successfully.'); window.location.href = 'trainerslist.php';</script>";
                } else {
                    echo "<script>alert('Error denying application. Please try again.');</script>";
                }
                $stmt_update->close();
            }
        } else {
            echo "<script>alert('User details not found.');</script>";
        }
        $stmt_user->close();
    } else {
        echo "<script>alert('Application not found.');</script>";
    }

    $stmt_fetch->close();
}

// Fetch all pending applications
$sql = "SELECT ta.id, u.username, u.email, ta.location, ta.sport, ta.day_time, ta.certificate, ta.state 
        FROM trainer_applications ta 
        JOIN users u ON ta.user_id = u.id
        WHERE ta.state = 'pending'";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Applications</title>
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
        }
        .btn-success, .btn-danger {
            margin: 5px;
        }
    </style>
    <script>
        function confirmAction(action) {
            return confirm(`Are you sure you want to ${action} this application?`);
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
            <li class="nav-item"><a class="nav-link" href="admin.php">Admin Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="login.php">Log Out</a></li>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center mb-4">Trainer Applications</h2>
    <div class="card">
        <div class="card-body">
            <?php if ($result && $result->num_rows > 0): ?>
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Location</th>
                            <th>Sport</th>
                            <th>Day/Time</th>
                            <th>Certificate</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['location']); ?></td>
                                <td><?php echo htmlspecialchars($row['sport']); ?></td>
                                <td><?php echo htmlspecialchars($row['day_time']); ?></td>
                                <td>
                                    <a href="uploads/<?php echo htmlspecialchars($row['certificate']); ?>" target="_blank">View Certificate</a>
                                </td>
                                <td>
                                    <form method="POST" style="display: inline;" onsubmit="return confirmAction('accept')">
                                        <input type="hidden" name="application_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                        <button type="submit" name="action" value="accept" class="btn btn-success btn-sm">Accept</button>
                                    </form>
                                    <form method="POST" style="display: inline;" onsubmit="return confirmAction('deny')">
                                        <input type="hidden" name="application_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                        <button type="submit" name="action" value="deny" class="btn btn-danger btn-sm">Deny</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center">No pending applications at the moment.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
