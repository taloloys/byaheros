<?php
// Include connect.php
include '../connect.php';

// Establish database connection
$connection = new mysqli($host, $username, $password, $dbname);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Query to retrieve distinct years of manufacture
$year_query = "SELECT DISTINCT year_manufactured FROM units ORDER BY year_manufactured DESC";
$year_result = $connection->query($year_query);

$years = [];
if ($year_result->num_rows > 0) {
    // Collect distinct years into an array
    while ($row = $year_result->fetch_assoc()) {
        $years[] = $row["year_manufactured"];
    }
}

// Close database connection
$connection->close();

// Output years as JSON
header('Content-Type: application/json');
echo json_encode($years);
?>
