<?php
include 'connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $vegetable_type = $_POST['vegetabletype'];
    $amount = $_POST['amount'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $email = $_SESSION['email'] ?? '';

    $sql = "INSERT INTO vegetables(vegetabletype,amount,price,description,email) VALUES ('$vegetable_type', '$amount', '$price', '$description','$email')";

    if ($conn->query($sql) === TRUE) {
        echo '
        <div style="max-width: 500px; margin: 40px auto; padding: 20px; background: #e6ffed; border: 2px solid #28a745; border-radius: 10px; text-align: center; font-family: sans-serif;">
            <h3 style="color: #155724;">✅ Data inserted successfully!</h3>
            <a href="../listings.html" style="display: inline-block; margin-top: 10px; padding: 10px 20px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;">
    OK
</a>

        </div>
        ';
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>