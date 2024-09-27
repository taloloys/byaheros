<?php
session_start();
include '../connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Database error. Please try again later.'
        ]);
        exit;
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

      
        if ($user['status'] === 'active') {
       
            if (password_verify($password, $user['password'])) {
            
                $_SESSION["username"] = $username;
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $user['id'];

                echo json_encode([
                    'status' => 'success',
                    'message' => 'Login successful'
                ]);
            } else {
                
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Invalid username or password'
                ]);
            }
        } else {
            
            echo json_encode([
                'status' => 'error',
                'message' => 'Your account is currently blocked. Please contact support for assistance.'
            ]);
        }
    } else {
        
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid username or password'
        ]);
    }

    $stmt->close();
} else {

    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method'
    ]);
}
?>
