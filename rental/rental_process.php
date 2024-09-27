<?php
session_start();
header('Content-Type: application/json');

function isDateInRange($date, $start, $end) {
    return ($date >= $start && $date <= $end);
}

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the necessary keys exist in the POST data
    $required_keys = ["product_id", "start_date", "end_date", "payment_method"];
    if (array_diff($required_keys, array_keys($_POST))) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required form data.']);
        exit;
    }

    // Retrieve form data
    $product_id = $_POST["product_id"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $payment_method = $_POST["payment_method"];
    
    // Retrieve user ID from session
    $user_id = $_SESSION['id'];

    // Connect to the database
    include '../connect.php';
    $connection = new mysqli($host, $username, $password, $dbname);

    // Check connection
    if ($connection->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $connection->connect_error]);
        exit;
    }

    // Check if the unit is under maintenance
    $maintenance_sql = "SELECT status FROM units WHERE id = ?";
    $maintenance_stmt = $connection->prepare($maintenance_sql);
    $maintenance_stmt->bind_param("i", $product_id);
    $maintenance_stmt->execute();
    $maintenance_result = $maintenance_stmt->get_result();

    if ($maintenance_result->num_rows == 0) {
        echo json_encode(['status' => 'error', 'message' => 'Product not found.']);
        exit;
    }

    $maintenance_row = $maintenance_result->fetch_assoc();
    if ($maintenance_row['status'] === 'maintenance') {
        echo json_encode(['status' => 'error', 'message' => 'This unit is currently under maintenance and cannot be rented.']);
        exit;
    }

    $sql = "SELECT start_date, end_date FROM rentals WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch occupied dates
    $occupied_dates = [];
    while ($row = $result->fetch_assoc()) {
        $occupied_dates[] = ['start_date' => $row['start_date'], 'end_date' => $row['end_date']];
    }

    // Check if any occupied date conflicts with the selected rental dates
    foreach ($occupied_dates as $occupied_date) {
        if (isDateInRange($start_date, $occupied_date['start_date'], $occupied_date['end_date']) ||
            isDateInRange($end_date, $occupied_date['start_date'], $occupied_date['end_date'])) {
            echo json_encode(['status' => 'error', 'message' => 'Selected dates conflict with existing rentals.']);
            exit;
        }
    }

    // Get the price of the product from the units table
    $price_sql = "SELECT price_cost FROM units WHERE id = ?";
    $price_stmt = $connection->prepare($price_sql);
    if (!$price_stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Database error. Please try again later.']);
        exit;
    }
    $price_stmt->bind_param("s", $product_id);
    $price_stmt->execute();
    $price_result = $price_stmt->get_result();

    if ($price_result->num_rows == 0) {
        echo json_encode(['status' => 'error', 'message' => 'Product not found.']);
        exit;
    }

    $price_row = $price_result->fetch_assoc();
    $amount = $price_row['price_cost'];

    // Insert the rental details into the database
    $sql = "INSERT INTO rentals (product_id, start_date, end_date, payment_method, user_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Database error. Please try again later.']);
        exit;
    }
    $stmt->bind_param("sssss", $product_id, $start_date, $end_date, $payment_method, $user_id);

    if ($stmt->execute()) {
        // Get the last inserted rental_id
        $rental_id = $stmt->insert_id;

        date_default_timezone_set('Asia/Manila');

        // Insert the sales details into the database
        $sale_date = date("Y-m-d");
        $sales_sql = "INSERT INTO sales (rental_id, sale_date, amount) VALUES (?, ?, ?)";
        $sales_stmt = $connection->prepare($sales_sql);
        if (!$sales_stmt) {
            echo json_encode(['status' => 'error', 'message' => 'Database error. Please try again later.']);
            exit;
        }
        $sales_stmt->bind_param("iss", $rental_id, $sale_date, $amount);

        if ($sales_stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Car rented successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $sales_stmt->error]);
        }

        $sales_stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);
    }

    $conn->close();
    $stmt->close();
    $price_stmt->close();
    $connection->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
