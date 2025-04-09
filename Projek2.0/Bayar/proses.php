<?php
session_start();
require __DIR__ . '/../db_connect.php';


if (!isset($_SESSION['customer_id'])) {
    header("Location: http://localhost/Projek2.0/login/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bank = trim($_POST['bank']);
    $amount_paid = floatval($_POST['amount_paid']);
    $customer_id = $_SESSION['customer_id'];

    
    if (empty($bank) || empty($amount_paid) || $amount_paid <= 0) {
        die("Sila pilih bank yang sah dan masukkan jumlah yang betul!");
    }

    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        die("Troli anda kosong!");
    }

    
    $conn->begin_transaction();

    try {
        
        $sql_order = "INSERT INTO orders (customer_id, order_date, total_amount) VALUES (?, NOW(), ?)";
        $stmt_order = $conn->prepare($sql_order);
        if (!$stmt_order) {
            throw new Exception("Orders SQL Error: " . $conn->error);
        }
        $stmt_order->bind_param("id", $customer_id, $amount_paid);
        if (!$stmt_order->execute()) {
            throw new Exception("Orders Execute Error: " . $stmt_order->error);
        }
        $order_id = $conn->insert_id;

        
        foreach ($_SESSION['cart'] as $product_id => $details) {
            $quantity = intval($details['quantity']);
            $price = floatval($details['price']);
            $subtotal = $quantity * $price;

            $sql_order_items = "INSERT INTO order_items (order_id, product_id, quantity, subtotal) VALUES (?, ?, ?, ?)";
            $stmt_order_items = $conn->prepare($sql_order_items);
            if (!$stmt_order_items) {
                throw new Exception("Order Items SQL Error: " . $conn->error);
            }
            $stmt_order_items->bind_param("iiid", $order_id, $product_id, $quantity, $subtotal);
            if (!$stmt_order_items->execute()) {
                throw new Exception("Order Items Execute Error: " . $stmt_order_items->error);
            }
        }

        // Simpan pembayaran dalam payments
        $sql_payment = "INSERT INTO payments (order_id, bank, amount_paid, payment_date) VALUES (?, ?, ?, NOW())";
        $stmt_payment = $conn->prepare($sql_payment);
        if (!$stmt_payment) {
            throw new Exception("Payments SQL Error: " . $conn->error);
        }
        $stmt_payment->bind_param("isd", $order_id, $bank, $amount_paid);
        if (!$stmt_payment->execute()) {
            throw new Exception("Payments Execute Error: " . $stmt_payment->error);
        }

        
        $conn->commit();

        
        unset($_SESSION['cart']);

        echo "<script>
                alert('Pembayaran berjaya! Jumlah: RM " . number_format($amount_paid, 2) . "');
                localStorage.removeItem('cart');
                window.location.href='home.php';
              </script>";

    } catch (Exception $e) {
        $conn->rollback();
        die("Transaksi Gagal: " . $e->getMessage());
    }
}

$conn->close();
?>
