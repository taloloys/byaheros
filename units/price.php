<?php
// Include connect.php
include '../connect.php';

// Establish database connection
$connection = new mysqli($host, $username, $password, $dbname);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Query to retrieve distinct price values
$price_query = "SELECT DISTINCT price_cost FROM units ORDER BY price_cost ASC";
$price_result = $connection->query($price_query);

$prices = [];
if ($price_result->num_rows > 0) {
    // Collect distinct prices into an array
    while ($row = $price_result->fetch_assoc()) {
        $prices[] = $row["price_cost"];
    }
}

// Close database connection
$connection->close();

// Output prices as JSON
header('Content-Type: application/json');
echo json_encode($prices);
?>
