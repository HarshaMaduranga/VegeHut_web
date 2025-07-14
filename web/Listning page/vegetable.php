<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $farmeremail = $_POST['farmeremail'];
    $farmername = $_POST['farmername'];
    $location = $_POST['location'];
    $vegetabletype = $_POST['vegetabletype'];
    $amount = $_POST['amount'];
    $price = $_POST['price'];
    $contactnumber = $_POST['contactnumber'];
    $description = $_POST['description'];

    $sql = "INSERT INTO vegetable(farmer_email,farmer_name,location,vegetable_type,amount,price,contact_number,discripotion) VALUES ('$farmeremail', '$farmername', '$location', '$vegetabletype', '$amount','$price' ,'$contactnumber' ,'$description')";

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
