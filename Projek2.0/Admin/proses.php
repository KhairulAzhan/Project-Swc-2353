<?php
session_start();
require __DIR__ . '/../db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $_SESSION['error'] = "Please fill in all fields";
        header("Location: http://localhost/Projek2.0/admin/login.php");
        exit();
    }

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format";
        header("Location: http://localhost/Projek2.0/admin/login.php");
        exit();
    }

    try {
        // Using MySQLi prepared statements
        $stmt = $conn->prepare("SELECT admin_id, admin_name, email, password FROM admin WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            // In production, use password_verify() with hashed passwords
            if ($password === $user['password']) { // WARNING: Plain text comparison - insecure!
                // Regenerate session ID to prevent fixation
                session_regenerate_id(true);
                
                // Set admin session variables
                $_SESSION['admin_id'] = $user['admin_id'];
                $_SESSION['admin_name'] = $user['admin_name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['last_activity'] = time();
                $_SESSION['is_admin'] = true;

                // Redirect to admin dashboard
                header("Location: http://localhost/Projek2.0/admindashboard.php");
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
    header("Location: http://localhost/Projek2.0/admin/login.php");
    exit();
}

// Redirect to login page if accessed directly
header("Location: http://localhost/Projek2.0/admin/login.php");
exit();
?>