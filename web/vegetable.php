<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $farmer_email = $_POST['name'];
    $farmer_name = $_POST['farmername'];
    $location = $_POST['location'];
    $vegetable_type = $_POST['vegetabletype'];
    $amount = $_POST['amount'];
    $price = $_POST['price'];
    $contact_number = $_POST['contactnumber'];
    $discripotion = $_POST['description'];

    // Insert into database
    $sql = "INSERT INTO vegetable(name,farmername,location,vegetabletype,amount,price,contactnumber,description) VALUES ('$farmer_email', '$farmer_name', '$location', '$vegetable_type', '$amount', '$price' , '$contact_number' , '$discripotion')";

    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
