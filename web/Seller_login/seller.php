<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $district = $_POST['district'];
    $contact_number = $_POST['contact_number'];

    $sql = "INSERT INTO seller(firstname,lastname,email,password,district,contact_number) VALUES ('$firstname', '$lastname', '$email', '$password', '$district','$contact_number')";

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