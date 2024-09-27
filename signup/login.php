

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="sign.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="login.js"></script>
</head>
<body>
    <div class="container">
        <div class="left"><img src="byaheros.jpg" alt=""></div>
        <div class="right">
        <a href="../index.html" class="back"><i class="fas fa-arrow-left"></i></a>
            <h2>Login</h2>
            <form action="login_process.php" method="post" id="loginForm">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" placeholder="Enter Username" required autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" placeholder="Enter Password" required autocomplete="off">
                </div>
                <button type="submit">Login</button>
            </form>
            <p>Don't have an account? <a href="signup.php">Sign up</a></p>
        </div>
    </div>
    
    
</body>
</html>



