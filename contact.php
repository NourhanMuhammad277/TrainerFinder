<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Validation and email sending logic
    mail("your-email@example.com", "New Contact Message", $message, "From: " . $email);
    echo "Message sent!";
}
