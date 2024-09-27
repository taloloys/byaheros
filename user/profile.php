<?php
session_start();
include '../connect.php';

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['id'];
$username = $_SESSION['username'];

// Pagination settings
$limit = 4; // Number of entries per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch the total number of rentals for the user
$total_sql = "SELECT COUNT(*) as total FROM rentals WHERE user_id = ?";
$total_stmt = $conn->prepare($total_sql);
$total_stmt->bind_param("i", $user_id);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_row = $total_result->fetch_assoc();
$total_entries = $total_row['total'];
$total_pages = ceil($total_entries / $limit);

// Fetch the user's rental information with limit, offset and order by start_date in descending order
$sql = "SELECT rentals.*, units.name as product_name, units.car_image, units.description, units.price_cost 
        FROM rentals 
        JOIN units ON rentals.product_id = units.id 
        WHERE rentals.user_id = ? 
        ORDER BY rentals.start_date DESC
        LIMIT ?, ?";
$stmt = $conn->prepare($sql);       

if ($stmt === false) {
    echo "Error preparing statement: " . $conn->error;
    exit;
}

$stmt->bind_param("iii", $user_id, $start, $limit);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="../styler.css">
    <style>
        body{
            overflow-y: hidden;
        }
        
        .profile-section {
            margin: 120px auto;
            width: 100%;
            max-width: 950px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            text-align: center; /* Center align table content */
        }

        th, td {
            padding: 8px;
            text-align: center; /* Center align table content */
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            max-width: 100px;
            height: auto;
        }

        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination a {
            text-decoration: none;
            color: #333;
            padding: 5px 10px;
            border: 1px solid #ccc;
            margin: 0 5px;
            border-radius: 3px;
        }

        .pagination a.active {
            background-color: #007bff;
            color: #fff;
        }

        .username {
            color: #F7AF30; /* Setting the color to #F7AF30 */
            text-transform: uppercase;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">
            <h2>BYAHEROS</h2>
        </div>
        <nav>
            <a href="dashboard.php">HOME</a>
            <a href="../units/cards.php">UNITS</a>
            <div class="dropdown">
                <span class="dropbtn bold-uppercase"><?php echo htmlspecialchars(strtoupper($username)); ?></span>
                <div class="dropdown-content">
                    <a href="profile.php">View History</a>
                    <a href="logout.php">Log Out</a>
                </div>
            </div>
        </nav>
    </header>

    <div class="profile-section">
        <h2>Welcome, <span style="color: #F7AF30; text-transform: uppercase;" ><?php echo htmlspecialchars($username); ?></span> </h2>
        <h3>Your Rented Cars</h3>
        
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Product Image</th>
                        <th>Product Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Price</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><img src="../admin/units/<?php echo htmlspecialchars($row['car_image']); ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>"></td>
                            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['start_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['end_date']); ?></td>
                            <td>₱<?php echo htmlspecialchars($row['price_cost']); ?>/Day</td>
                            <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?>">&laquo; Previous</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>" <?php if ($i === $page) echo 'class="active"'; ?>><?php echo $i; ?></a>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?php echo $page + 1; ?>">Next &raquo;</a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <p>You have not rented any cars yet.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
