<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['pswd'];
    
    // Check in admins table first
    $sql = "SELECT * FROM admins WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Direct check for specific admin credentials
    if ($email === 'nourhan2712@gmail.com' && $password === 'nourhan27122003') {
        session_start();
        $_SESSION['admin_id'] = 1; // Assuming you know the admin's ID or can fetch it
        header("Location: admin.php"); // Redirect to admin dashboard
        exit();
    }

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin['password'])) {
            // Successful admin login
            session_start();
            $_SESSION['admin_id'] = $admin['id'];
            header("Location: admin.php"); // Redirect to admin dashboard
            exit();
        } else {
            echo "Invalid password for admin.";
        }
    } else {
        // If not admin, check users table
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Debugging: Display the hash in the database and attempt password verification
            var_dump($user['password']); // Check the stored hash
            var_dump(password_verify($password, $user['password'])); // Check password verification result
            
            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                header("Location: Home.php"); // Redirect to Home.php for users
                exit();
            } else {
                echo "Invalid password for user.";
            }
        } else {
            echo "No user or admin found with that email.";
        }
    }
}

$conn->close();
?>
