<?php
include 'connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_SESSION['email'] ?? '';
    $vegType = $_POST['vegetabletype'];

    $stmt = $conn->prepare("SELECT amount, price, description FROM vegetables WHERE vegetabletype = ? AND email = ?");
    $stmt->bind_param("ss", $vegType, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(["amount" => "", "price" => "", "description" => ""]);
    }

    $stmt->close();
}
    // 🔄 Update logic
    if (isset($_POST['update'])) {
        $amount = $_POST['amount'] ?? 0;
        $price = $_POST['price'] ?? 0;
        $description = $_POST['description'] ?? '';

        $stmt = $conn->prepare("UPDATE vegetables SET amount = ?, price = ?, description = ? WHERE vegetabletype = ? AND email = ?");
        $stmt->bind_param("idsss", $amount, $price, $description, $vegType, $email);

        if ($stmt->execute()) {
            echo "<div style='color: green; font-weight: bold;'>✅ Vegetable updated successfully!</div>";
        } else {
            echo "<div style='color: red;'>❌ Update failed: " . $stmt->error . "</div>";
        }

        $stmt->close();
    }

    // 🗑️ Delete logic
    if (isset($_POST['delete'])) {
        $stmt = $conn->prepare("DELETE FROM vegetables WHERE vegetabletype = ? AND email = ?");
        $stmt->bind_param("ss", $vegType, $email);

        if ($stmt->execute()) {
            echo "<div style='color: orange; font-weight: bold;'>🗑️ Vegetable deleted successfully!</div>";
        } else {
            echo "<div style='color: red;'>❌ Delete failed: " . $stmt->error . "</div>";
        }

        $stmt->close();
    }

    $conn->close();
?>
