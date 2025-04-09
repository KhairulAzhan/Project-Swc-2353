<?php
session_start();
require __DIR__ . '/../db_connect.php';

$errors = [];
$formData = ['name' => '', 'email' => '', 'phone' => '', 'address' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');

    $formData = compact('name', 'email', 'phone', 'address');

    // Validation
    if (strlen($name) < 3) {
        $errors[] = "Full name must be at least 3 characters.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    } else {
        $stmt = $conn->prepare("SELECT email FROM customers WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = "Email already registered.";
        }
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if (!preg_match('/^[0-9]{10,15}$/', $phone)) {
        $errors[] = "Invalid phone number format.";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['formData'] = $formData;
        header("Location: index.php");
        exit();
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO customers (customer_name, email, password, phone, address) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $email, $password, $phone, $address]);

    $_SESSION['user_id'] = $conn->lastInsertId();
    $_SESSION['user_name'] = $name;
    $_SESSION['logged_in'] = true;

    header("Location: http://localhost/Projek2.0/home.php");
    exit();
}
?>
