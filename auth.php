<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['pswd'];
    
    // Example for login
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Successful login
            session_start();
            $_SESSION['user_id'] = $user['id'];
            header("Location: Home.php"); // Redirect to Home.php
            exit(); // Make sure to call exit after redirect
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that email.";
    }
    
    // Example for signup (you might have separate forms and logic)
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
            exit(); // Make sure to call exit after redirect
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Passwords do not match.";
    }
}

$conn->close();
?>
