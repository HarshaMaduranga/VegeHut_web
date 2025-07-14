<?php
$conn = new mysqli("localhost", "root", "", "vegehut");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM vegetable where vegetable_type='beetroot'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='seller'>";
        echo "<p>seller:" . htmlspecialchars($row['farmer_name']) . "</p>";
        echo "<p>Location: " . htmlspecialchars($row['location']) . "</p>";
        echo "<p>Amount: " . $row['amount'] . "kg</p>";
        echo "<p>Price: Rs. " . $row['price'] . "/kg</p>";
        echo "<p>Contact number: <a href='https://wa.me/" . $row['contact_number'] . "' target='_blank'>" . $row['contact_number'] . "</a></p>";
        echo "<p>Description: " . htmlspecialchars($row['discripotion']) . "</p>";
        echo "</div>";
    }
} else {
    echo "<p>No sellers found.</p>";
}

$conn->close();
?>