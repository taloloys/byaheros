<?php
// Include the connection file
include '../connect.php';

// Check if product ID is provided in the query parameters
if(isset($_GET['id'])) {
    // Sanitize the product ID
    $unitId = $_GET['id'];

    // Establish connection to the database
    $connection = new mysqli($host, $username, $password, $dbname);

    // Check for connection errors
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Prepare and execute SQL query to fetch product details
    $sql = "SELECT * FROM units WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $unitId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the product exists
    if ($result->num_rows > 0) {
        // Fetch product details
        $product = $result->fetch_assoc();
    } else {
        // Redirect back to the products page if the product does not exist
        header("Location: ../units/cards.php");
        exit;
    }

    // Prepare and execute SQL query to fetch occupied dates for the product
    $sqlOccupied = "SELECT start_date, end_date FROM rentals WHERE product_id = ?";
    $stmtOccupied = $connection->prepare($sqlOccupied);
    $stmtOccupied->bind_param("i", $unitId);
    $stmtOccupied->execute();
    $resultOccupied = $stmtOccupied->get_result();

    $occupiedDates = [];
    while ($row = $resultOccupied->fetch_assoc()) {
        $start = new DateTime($row['start_date']);
        $end = new DateTime($row['end_date']);
        $end->modify('+1 day'); // include the end date
        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($start, $interval, $end);

        foreach ($daterange as $date) {
            $occupiedDates[] = $date->format("Y-m-d");
        }
    }

    // Close the database connection
    $connection->close();
} else {
    // Redirect back to the products page if no product ID is provided
    header("Location: ../units/cards.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Form</title>
    <style>
        
    </style>
    <link rel="stylesheet" href="rental.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="rentals.js"></script>
    <script>
         $(function() {
        var occupiedDates = <?php echo json_encode($occupiedDates); ?>;
        function disableDates(date) {
            var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
            if (occupiedDates.indexOf(string) != -1) {
                return [false, "occupied-date"];
            }
            return [true, ""];
        }
        $("#start_date, #end_date").datepicker({
            beforeShowDay: disableDates,
            dateFormat: 'yy-mm-dd'
        });
    });
    </script>
</head>
<body>
    <h2>Rental Form</h2>
    <div class="rental-container">
        <div class="product-details">
            <h3><?php echo $product['name']; ?></h3>
            <img src="../admin/units/<?php echo $product['car_image']; ?>" alt="<?php echo $product['alt_text']; ?>">
            <p><?php echo $product['description']; ?></p>
            <p><?php echo '₱' . $product['price_cost'] . '/Day'; ?></p>
        </div>
        <div class="rental-form">
            <form action="rental_process.php" method="post" id="rentalForm">
                <a href="../units/cards.php" class="back-button"><i class="fas fa-arrow-left"></i></a>
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" required><br><br>
                
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" required><br><br>
                
                <label for="payment_method">Payment Method:</label>
                <select id="payment_method" name="payment_method" required>
                    <option value="Credit card">Credit Card</option>
                    <option value="Debit card">Debit Card</option>
                    <option value="Gcash">Gcash</option>
                </select><br><br>
                
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
    <script src="rental.js"></script>
</body>
</html>

