<?php
include '../connect.php';
$connection = new mysqli($host, $username, $password, $dbname);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$sql = "SELECT * FROM units";


$whereClause = [];

if(isset($_GET['search']) || isset($_GET['year']) || isset($_GET['price'])) {
    
    if (!empty($_GET['search'])) {
        $search = $connection->real_escape_string($_GET['search']);
        $whereClause[] = "(name LIKE '%$search%' OR description LIKE '%$search%')";
    }

    
    if (!empty($_GET['year'])) {
        $year = $connection->real_escape_string($_GET['year']);
        $whereClause[] = "year_manufactured = '$year'";
    }

    
    if (!empty($_GET['price'])) {
        $price = $connection->real_escape_string($_GET['price']);
        $whereClause[] = "price_cost = '$price'";
    }

    
    if (!empty($whereClause)) {
        $sql .= " WHERE " . implode(" AND ", $whereClause);
    }
}

session_start();


if (!isset($_SESSION['username'])) {
    $rentalUrl = '../signup/login.php';
} else {
    $rentalUrl = '../rental/rental_form.php?id=';
}


$result = $connection->query($sql);

echo '<div class="container" id="unitContainer">';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="card">';
        echo '<img src="../admin/units/'. htmlspecialchars($row["car_image"]). '" alt="'. htmlspecialchars($row["alt_text"]). '">';
        echo '<div class="card-content">';
        echo '<h2>'. htmlspecialchars($row["name"]). '</h2>';
        echo '<p>'. htmlspecialchars($row["description"]). '</p>';
    
        $status = $row["status"];
        $buttonLink = $rentalUrl;
        $buttonText = "Rent Now";
    
        
        if ($status == 'maintenance') {
            $buttonText = "Under Maintenance";
            $buttonClass = "maintenance-button";
            $buttonLink = "#";
        } else {
            $buttonText = "Rent Now";
            $buttonClass = ""; 
            $buttonLink = "../rental/rental_form.php?id=". $row["id"];
        }


        echo '<a href="'. htmlspecialchars($buttonLink).'" class="'. $buttonClass.'">'. htmlspecialchars($buttonText). '</a>';


    
        echo '</div></div>';
    }
} else {
    echo '<div class="no-match-container">';
    echo '<div class="no-match">';
    echo "We're Sorry. We were not able to find a match.";
    echo '</div></div>';   
}

echo '</div>'; 

$connection->close();
?>
