<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search - VegeHut.lk</title>
    <link rel="stylesheet" href="css/searchstyle.css">
    <style>
        nav {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
      border-bottom: 1px solid rgba(255, 255, 255, 0.18);
    }

  .logo-title {
    display: flex;
    align-items: center;
    gap: 12px; 
}

.logo-title img {
    height: 60px; 
    width: auto;
}

.logo-title h1 {
    margin: 0;
    font-size: 2rem; 
    font-weight: bold;
    color: #49c26d; 
}

    nav .nav-links {
      display: flex;
      gap: 2rem;
      align-items: center;
    }

    nav a {
      color: #333;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
      position: relative;
    }

    nav a::before {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 0;
      height: 2px;
      background: linear-gradient(135deg, #fafdfa, #2E7D32);
      transition: width 0.3s ease;
    }

    nav a:hover::before {
      width: 100%;
    }

    nav a:hover {
      color: #4CAF50;
    }

    </style>
</head>
<body>
<nav>
    <div class="logo-title">
      <img src="images/logo.png" alt="logo">
      <h1 class="text-xl font-bold text-gray-900">VegeHut</h1>
    </div>
    <div class="nav-links">
      <a href="homepage.html">Home</a>
      <a href="listings.html">Listings</a>
      <a href="vegehut_aboutus.html">About Us</a>
      <a href="Seller_login/signup.html">Seller Mode</a>
    </div>
  </nav>
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