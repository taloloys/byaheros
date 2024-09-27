<?php
session_start();

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Byaheros Car Rental Services</title>
    <link rel="stylesheet" href="../styler.css">
</head>
<body>
    <header class="header">
        <div class="logo">
            <h2>BYAHEROS</h2>
        </div>
        <nav>
            <a href="dashboard.php">HOME</a>
            <a href="../units/cards.php">UNITS</a>
            <?php if ($isLoggedIn): ?>
                <div class="dropdown">
                <span class="dropbtn bold-uppercase"><?php echo htmlspecialchars(strtoupper($_SESSION['username'])); ?></span>
                    <div class="dropdown-content">
                        <a href="profile.php">View History</a>
                        <a href="logout.php">Log Out</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="../login.php">Login</a>
                <a href="../signup.php">Sign Up</a>
            <?php endif; ?>
        </nav>
    </header>

    <div class="intro-section">
        <div class="byahero_pic">
            <img src="byaheros.jpg" alt="Byaheros">
        </div>

        <div class="description">
            <p>Unlock Your Adventures With</p>
            <p class="kolor">Byaheros Car Rental <br>Services - Cebu</p>
        </div>

        <div class="description1">
            <p>NEED A CAR FOR YOUR TRAVEL HERE IN CEBU?</p>
            <p> For your comfort, convenience and budget ride choose</p> 
            <p>Byaheros Car Rental Services - Cebu </p>
        </div>

        <div class="signup">
            <a href="../units/cards.php"><button>RENT NOW</button></a>
        </div>

        <div class="brand">
            <img src="toyota-svgrepo-com.svg" alt="Toyota">
            <img src="mitsubishi-svgrepo-com.svg" alt="Mitsubishi">
        </div>
    </div>
</body>
</html>
