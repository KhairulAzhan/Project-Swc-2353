<?php
session_start();
require __DIR__ . '/../db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $_SESSION['error'] = "Please fill in all fields";
        header("Location: http://localhost/Projek2.0/login/login.php");
        exit();
    }

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format";
        header("Location: http://localhost/Projek2.0/login/login.php");
        exit();
    }

    try {
        // Using MySQLi prepared statements
        $stmt = $conn->prepare("SELECT customer_id, customer_name, email, password FROM customers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            // Verify password (plain text comparison - INSECURE for production!)
            if ($password === $user['password']) {
                // Regenerate session ID to prevent session fixation
                session_regenerate_id(true);
                
                // Set session variables
                $_SESSION['customer_id'] = $user['customer_id'];
                $_SESSION['customer_name'] = $user['customer_name'];
                $_SESSION['customer_email'] = $user['email'];
                $_SESSION['last_activity'] = time();

                // Redirect to account page
                header("Location: http://localhost/Projek2.0/account.php");
                exit();
            } else {
                $_SESSION['error'] = "Invalid email or password";
            }
        } else {
            $_SESSION['error'] = "Invalid email or password";
        }
    } catch (mysqli_sql_exception $e) {
        error_log("Database error: " . $e->getMessage());
        $_SESSION['error'] = "A system error occurred. Please try again later.";
    }

    // Redirect back to login page if authentication fails
    header("Location: http://localhost/Projek2.0/login/login.php");
    exit();
}

// Redirect to login page if accessed directly
header("Location: http://localhost/Projek2.0/login/login.php");
exit();
?>