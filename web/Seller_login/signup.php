<?php
include 'connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the ID and Email exist in the database
    $stmt = $conn->prepare("SELECT email,password FROM seller WHERE email = ? AND password = ?");
    $stmt->bind_param("is", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['email'] = $email;
        header("Location: Seller mode.html");
        exit();
    } else {
        echo "❌ ID and Email do not match our records!";
    }

    $stmt->close();
    $conn->close();
}
?>
