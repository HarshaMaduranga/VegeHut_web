<?php
$conn = new mysqli("localhost", "root", "", "vegehut");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT vegetables.vegetabletype, vegetables.amount, vegetables.price, vegetables.description, 
               seller.firstname, seller.lastname, seller.district, seller.contact_number 
        FROM vegetables
        INNER JOIN seller ON vegetables.email = seller.email
        WHERE vegetables.vegetabletype = 'Potato'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='seller'>";
        echo "<p>Seller: " . htmlspecialchars($row['firstname'] . " " . $row['lastname']) . "</p>";
        echo "<p>Location: " . htmlspecialchars($row['district']) . "</p>";
        echo "<p>Amount: " . $row['amount'] . "kg</p>";
        echo "<p>Price: Rs. " . $row['price'] . "/kg</p>";
        echo "<p>Contact: <a href='https://wa.me/" . $row['contact_number'] . "' target='_blank'>" . $row['contact_number'] . "</a></p>";
        echo "<p>Description: " . htmlspecialchars($row['description']) . "</p>";
        echo "</div>";
    }
} else {
    echo "<p>No sellers found.</p>";
}

$conn->close();
?>