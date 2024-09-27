<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Byaheros Sign Up</title>
    <link rel="stylesheet" href="sign.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="signup.js?v=1"></script>

</head>
<body>
<div class="container">
        <div class="left"><img src="byaheros.jpg" alt=""></div>
        <div class="right">
            <a href="../index.html" class="back"><i class="fas fa-arrow-left"></i></a>
            <h2>Sign Up</h2>
            <form method="post">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" placeholder="Enter Username" required autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" placeholder="Enter Email" required autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" placeholder="Enter Password" required autocomplete="off">
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" name="terms" id="terms" required>
                    <label for="terms">By creating an account you aggree to our <a href="#">terms and conditions.</a></label>
                </div>
                <button type="submit">Sign Up</button>
            </form>
            <label>Already have an account? <a href="login.php">Log in</a></label>
        </div>
    </div>
    
</body>
</html>
<?php
include '../connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate input data
    if (!empty($username) && !empty($email) && !empty($password)) {
        // Hash the password before saving to the database
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        // Prepare an insert statement
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";

        if($statement = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $statement->bind_param("sss", $username, $email, $password_hashed);

            // Attempt to execute the prepared statement
            if($statement->execute()){
                // Call the JavaScript function to display success message
                echo '<script>showSuccessMessage();</script>';
            } else{
                // Call the JavaScript function to display error message
                echo '<script>showErrorMessage();</script>';
            }
        }

        // Close statement
        $statement->close();
    }
}

// Close connection
$conn->close();

?>






