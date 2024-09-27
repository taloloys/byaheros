<?php
// Include the connection file
include '../connect.php';

// Check if product ID is provided in the query parameters
if (isset($_GET['id'])) {
    // Sanitize the product ID
    $unitId = $_GET['id'];

    // Establish connection to the database
    $conn = new mysqli($host, $username, $password, $dbname);

    // Check for connection errors
    if ($conn->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $connection->connect_error]);
        exit;
    }

    // Prepare and execute SQL query to fetch occupied dates
    $sql = "SELECT start_date, end_date FROM rentals WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $unitId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch occupied dates
    $occupied_dates = [];
    while ($row = $result->fetch_assoc()) {
        $occupied_dates[] = ['start_date' => $row['start_date'], 'end_date' => $row['end_date']];
    }

    // Return occupied dates as JSON
    echo json_encode(['status' => 'success', 'occupied_dates' => $occupied_dates]);

    // Close the database connection
    $stmt->close();
    $connection->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'No product ID provided']);
}
?>
