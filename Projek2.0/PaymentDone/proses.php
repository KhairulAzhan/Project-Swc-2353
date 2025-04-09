<?php
session_start();
require __DIR__ . '/../db_connect.php'; 


if (!isset($_SESSION['customer_id'])) {
    header("Location: http://localhost/Projek2.0/login/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bank = $_POST['bank'] ?? '';
    $amount = $_POST['amount'] ?? 0;
    $customer_id = $_SESSION['customer_id'];

    
    if (empty($bank) || $amount <= 0) {
        echo "<script>alert('Sila pilih bank dan masukkan jumlah yang sah!'); window.history.back();</script>";
        exit();
    }

    try {
        
        $conn->beginTransaction();

        // create rekod baru
        $order_sql = "INSERT INTO orders (customer_id, order_date, total_amount) VALUES (?, NOW(), ?)";
        $order_stmt = $conn->prepare($order_sql);
        $order_stmt->execute([$customer_id, $amount]);
        $order_id = $conn->lastInsertId();

        // Dapatkan item dari cart 
        if (!isset($_POST['cart_data']) || empty($_POST['cart_data'])) {
            throw new Exception("Data cart tidak diterima!");
        }

        $cart_items = json_decode($_POST['cart_data'], true);
        if (!is_array($cart_items)) {
            throw new Exception("Format data cart tidak sah!");
        }

        // Masukan item pesanan ke dalam order_items
        foreach ($cart_items as $item) {
            $product_id = $item['id'] ?? 0;
            $quantity = $item['quantity'] ?? 1;
            $subtotal = $item['price'] * $quantity;

            if ($product_id > 0 && $quantity > 0) {
                $item_sql = "INSERT INTO order_items (order_id, product_id, quantity, subtotal) VALUES (?, ?, ?, ?)";
                $item_stmt = $conn->prepare($item_sql);
                $item_stmt->execute([$order_id, $product_id, $quantity, $subtotal]);
            }
        }

        // Simpan info pembayaran
        $payment_sql = "INSERT INTO payments (order_id, bank, amount_paid, payment_date) VALUES (?, ?, ?, NOW())";
        $payment_stmt = $conn->prepare($payment_sql);
        $payment_stmt->execute([$order_id, $bank, $amount]);
        $payment_id = $conn->lastInsertId();

       
        $conn->commit();

        
        $_SESSION['payment_details'] = [
            'order_id' => $order_id,
            'payment_id' => $payment_id,
            'amount' => $amount,
            'bank' => $bank,
            'date' => date('d/m/Y H:i:s')
        ];

        
        echo json_encode(['status' => 'success', 'redirect' => 'done_payment.php']);
        exit();

    } catch (Exception $e) {
        
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }
        echo json_encode(['status' => 'error', 'message' => "Pembayaran gagal: " . $e->getMessage()]);
        exit();
    }
}
?>
