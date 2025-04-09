<?php
session_start();
include 'db_connect.php'; 

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - KZ Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* CSS styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .dashboard-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        .stat-card {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #333;
            color: white;
        }
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 8px 15px;
            background-color: #ff4444;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }
        .logout-btn:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>

<!-- Dashboard Container -->
<div class="dashboard-container">
    <!-- Logout Button -->
    <a href="?logout" class="logout-btn">
        <i class="fas fa-sign-out-alt"></i> LOGOUT
    </a>

    <h1>ADMIN DASHBOARD</h1>
    <p>Overview of shop performance and recent activities</p>

    <!-- Stats Cards -->
    <div class="stat-card">
        <h3>Total Orders</h3>
        <div class="stat-value">
            <?php
            $sql = "SELECT COUNT(order_id) as total_orders FROM orders";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            echo $row['total_orders'];
            ?>
        </div>
    </div>

    <div class="stat-card">
        <h3>Total Revenue</h3>
        <div class="stat-value">
            RM 
            <?php
            $sql = "SELECT SUM(total_amount) as total_revenue FROM orders";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            echo number_format($row['total_revenue'], 2);
            ?>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <h2>Recent Orders</h2>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer ID</th>
                <th>Date</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT order_id, customer_id, order_date, total_amount FROM orders ORDER BY order_date DESC LIMIT 5";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['order_id'] . "</td>";
                    echo "<td>" . $row['customer_id'] . "</td>";
                    echo "<td>" . $row['order_date'] . "</td>";
                    echo "<td>RM " . number_format($row['total_amount'], 2) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No orders found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Recent Payments Table -->
    <h2>Recent Payments</h2>
    <table>
        <thead>
            <tr>
                <th>Payment ID</th>
                <th>Order ID</th>
                <th>Bank</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT payment_id, order_id, bank, amount_paid, payment_date FROM payments ORDER BY payment_date DESC LIMIT 5";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['payment_id'] . "</td>";
                    echo "<td>" . $row['order_id'] . "</td>";
                    echo "<td>" . $row['bank'] . "</td>";
                    echo "<td>RM " . number_format($row['amount_paid'], 2) . "</td>";
                    echo "<td>" . $row['payment_date'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No payments found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Close database connection -->
<?php $conn->close(); ?>

</body>
</html>