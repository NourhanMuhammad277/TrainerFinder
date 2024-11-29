<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['pswd'];
    
    $sql = "SELECT * FROM admins WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($email === 'nourhan2712@gmail.com' && $password === 'nourhan27122003') {
        session_start();
        $_SESSION['admin_id'] = 1; 
        header("Location: admin.php"); 
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
           
            var_dump($user['password']); 
            var_dump(password_verify($password, $user['password']));
            
            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                header("Location: Home.php"); 
                exit();
            } else {
                echo "Invalid password for user.";
            }
        } else {
            echo "No user or admin found with that email.";
        }

    $username = $_POST['txt'];
    $confirm_password = $_POST['confirm_pswd'];

    if ($password === $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (email, password, username) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $email, $hashed_password, $username);
        if ($stmt->execute()) {
            echo "Signup successful!";
            header("Location: Home.php"); // Redirect to Home.php after signup
            exit(); 
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Passwords do not match.";
    }
    }
}

$conn->close();
?>
