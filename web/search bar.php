<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search - VegeHut.lk</title>
    <link rel="stylesheet" href="css/searchstyle.css">
</head>
<body>

<header>
    <h1>Search for Vegetables</h1>
    <p>Find fresh produce from local farmers</p>
</header>

<div class="search-container">
    <form method="POST" action="">
        <input type="text" id="searchInput" name="query" placeholder="Enter vegetable name" required />
        <button type="submit">Search</button>
    </form>

    <div class="results" id="searchResults">
        <?php
        $conn = new mysqli("localhost", "root", "", "vegehut");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['query'])) {
            $search = $_POST['query'];

            $sql = "SELECT vegetables.vegetabletype, vegetables.amount, vegetables.price, vegetables.description,
                           seller.firstname, seller.lastname, seller.district, seller.contact_number 
                    FROM vegetables
                    INNER JOIN seller ON vegetables.email = seller.email
                    WHERE LOWER(vegetables.vegetabletype) = LOWER(?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $search);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div style='background-color: #d1e7dd; border-radius: 8px; padding: 15px; margin-top: 20px; font-family: Arial, sans-serif;'>";
                    echo "<p><strong>Seller:</strong> " . htmlspecialchars($row['firstname'] . " " . $row['lastname']) . "</p>";
                    echo "<p><strong>Location:</strong> " . htmlspecialchars($row['district']) . "</p>";
                    echo "<p><strong>Amount:</strong> " . $row['amount'] . "kg</p>";
                    echo "<p><strong>Price:</strong> Rs. " . $row['price'] . "/kg</p>";
                    echo "<p><strong>Contact:</strong> <a href='https://wa.me/" . $row['contact_number'] . "' target='_blank'>" . $row['contact_number'] . "</a></p>";
                    echo "<p><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p style='margin-top: 20px;'>No sellers found for '" . htmlspecialchars($search) . "'.</p>";
            }

            $stmt->close();
        }

        $conn->close();
        ?>
    </div>
</div>

</body>
</html>