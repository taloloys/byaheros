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
    <title>Units</title>
    
    <link rel="stylesheet" href="../styler.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header class="header">
        <div class="logo">
            <h2> BYAHEROS</h2>
        </div>

        <nav>
            <a href="<?php echo $isLoggedIn ? '../user/dashboard.php' : '../index.html'; ?>">HOME</a>
            <a href="cards.php">UNITS</a>
            <?php if ($isLoggedIn): ?>
                <div class="dropdown">
                <span class="dropbtn bold-uppercase"><?php echo htmlspecialchars(strtoupper($_SESSION['username'])); ?></span>
                    <div class="dropdown-content">
                        <a href="../user/profile.php">View History</a>
                        <a href="../user/logout.php">Log Out</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="../signup/login.php">LOG IN</a>
                <a href="../signup/signup.php"><button>SIGN UP</button></a>
            <?php endif; ?>
        </nav>
    </header>

    <div class="sakyanans">
        <div class="abilabol">
            <h1 class="title">Byaheros Car Rentals - Cebu</h1>
            <h2 class="sub-title">AVAILABLE UNITS</h2>
        </div>

        <div class="search-container">
            <input type="search" id="searchInput" placeholder="Search...">
            <datalist id="searchSuggestions">
            </datalist>
            <select id="yearSelect">
                <option value="">Select Year</option>
            </select>
            <select id="priceSelect">
                <option value="">Select Price</option>
            </select>
            <button onclick="applyFilters()">Search</button>
        </div>

        <div class="container" id="unitContainer">
            <!-- mao nani -->
        </div>
    </div>

    <script src="cards.js"></script>
</body>
</html>
