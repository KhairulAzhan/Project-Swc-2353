<?php
session_start();
require __DIR__ . '/../db_connect.php';

if (!isset($_SESSION['customer_id'])) {
    header("Location: http://localhost/Projek2.0/login/login.php");
    exit();
}

if (!isset($_SESSION['customer_name'])) {
    $_SESSION['customer_name'] = "Customers"; // Tetapkan nilai default jika tidak ada
}


$customer_id = $_SESSION['customer_id'];
$order_id = isset($_GET['order_id']) ? htmlspecialchars($_GET['order_id']) : 'N/A';
$amount_paid = isset($_GET['amount_paid']) ? floatval($_GET['amount_paid']) : 0.00;
$payment_date = isset($_GET['date']) ? htmlspecialchars($_GET['date']) : date('Y-m-d H:i:s');

// Simpan ke dalam database
if ($order_id !== 'N/A' && $amount_paid > 0) {
    $stmt = $conn->prepare("INSERT INTO payments (order_id, customer_id, amount_paid, payment_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sids", $order_id, $customer_id, $amount_paid, $payment_date);
    
    if ($stmt->execute()) {
        $payment_status = "Succeeded";
    } else {
        $payment_status = "Failed";
    }
    $stmt->close();
} else {
    $payment_status = "Invalid Data";
}

$conn->close();


?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bayaran Selesai - KZ Shop</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* General Styles */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            box-sizing: border-box;
        }

        /* Top Bar */
        .top-bar {
            text-align: center;
            background-color: black;
            color: white;
            padding: 10px;
        }

        /* Header */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #fff;
            border-bottom: 1px solid #ddd;
        }

        .logo img {
            width: 150px;
            height: auto;
        }

        .search-container input {
            padding: 5px;
            width: 200px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .search-container button {
            background: none;
            border: none;
            cursor: pointer;
        }

        /* Icons Section */
        .icons {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .icons button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            color: #333;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            min-width: 150px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 5px;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            font-size: 14px;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Navigation */
        nav {
            display: flex;
            justify-content: center;
            background-color: #f5f5f5;
            padding: 10px;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
            margin: 0;
            padding: 0;
        }

        nav ul li a {
            text-decoration: none;
            color: #000;
            font-weight: bold;
        }

        /* Dropdown Menu */
        .dropdown {
            position: relative;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            min-width: 150px;
            z-index: 10;
        }

        .dropdown-content a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: black;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Account Section */
        .account-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .account-header {
            margin-bottom: 30px;
        }

        .account-header h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }

        .account-details {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 30px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
            align-items: center;
        }

        .detail-label {
            font-weight: bold;
            color: #555;
        }

        .detail-value {
            color: #333;
        }

        .account-actions {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background-color: #000;
            color: white;
        }

        .btn-primary:hover {
            background-color: #333;
        }

        .btn-danger {
            background-color: #ff0000;
            color: white;
        }

        .btn-danger:hover {
            background-color: #cc0000;
        }

        /* Footer */
        footer {
            text-align: center;
            background-color: black;
            color: white;
            padding: 20px;
        }

        footer h1 {
            margin: 0;
        }

        footer p {
            margin: 10px 0;
        }

        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fffb64;
            color: black;
            padding: 20px;
            text-align: center;
        }

        .footer-bottom div {
            flex: 1;
        }

        .footer-bottom ul {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .footer-bottom ul li a img {
            width: 30px;
            height: 30px;
        }

        /* Payment Completion Section */
        .payment-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .payment-header {
            margin-bottom: 30px;
        }

        .payment-header h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }

        .payment-success {
            color: #4CAF50;
            font-size: 72px;
            margin-bottom: 20px;
        }

        .payment-details {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 30px;
            text-align: left;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: bold;
            color: #555;
            width: 40%;
        }

        .detail-value {
            color: #333;
            width: 60%;
            text-align: right;
        }

        .payment-actions {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-continue {
            background-color: #000;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn-continue:hover {
            background-color: #333;
        }

        .thank-you {
            font-size: 18px;
            margin: 20px 0;
            color: #555;
        }

        .order-number {
            font-weight: bold;
            color: #000;
            font-size: 20px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        THANK YOU FOR YOUR SUPPORT
    </div>

    <!-- Header -->
    <header>
        <div class="logo">
            <a href="http://localhost/Projek2.0/home.php"><img src="../gambar/logo brand.png" alt="KZ Logo"></a>
        </div>
        <div class="search-container">
            <input type="text" placeholder="SEARCH">
            <button><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
        <div class="icons">
            <div class="dropdown">
                <button><i class="fa-solid fa-user"></i></button>
                <div class="dropdown-content">
                    <a href="http://localhost/Projek2.0/account.php">My Account</a>
                    <a href="http://localhost/Projek2.0/logout.php">Logout</a>
                </div>
            </div>
            <a href="http://localhost/Projek2.0/bayar/cart.php">
                <button><i class="fa-solid fa-cart-shopping"></i></button>
            </a>
        </div>
    </header>

    <!-- Navigation -->
    <nav>
        <ul>
            <li><a href="http://localhost/Projek2.0/home.php">HOME</a></li>
            <li class="dropdown">
                <a href="http://localhost/Projek2.0/catalog.php">CATALOG</a>
                <div class="dropdown-content">
                    <a href="http://localhost/Projek2.0/Clothes.php">Clothes</a>
                    <a href="http://localhost/Projek2.0/Shoes.php">Shoes</a>
                    <a href="http://localhost/Projek2.0/Hoodie.php">Hoodies</a>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Payment Completion Section -->
    <div class="payment-container">
        <div class="payment-header">
            <div class="payment-success">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1>Your Payment Has Been Successful</h1>
            <p class="thank-you">Thank you for your purchase, <?php echo htmlspecialchars($_SESSION['customer_name']); ?>!</p>
            <p class="order-number">Order NO : <?php echo $order_id; ?></p>
        </div>
        
        <div class="payment-details">
            <div class="detail-row">
                <span class="detail-label">Payment Status:</span>
                <span class="detail-value" style="color: #4CAF50; font-weight: bold;">Succeeded</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Total Payment:</span>
                <span class="detail-value">RM <?php echo number_format($amount_paid, 2); ?></span>

            </div>
        </div>
        
    </div>

    <!-- Footer -->
    <footer>
        <h1>ABOUT US</h1>
        <p>KZ CLOTHING IS A LOCAL BRAND FROM MALAYSIA FOUNDED BY KHAIRUL AZHAN.</p>
    </footer>
    <div class="footer-bottom">
        <div>
            <h3>ADDRESS</h3>
            <a href="https://maps.app.goo.gl/NJ5jLzKYBm4oRz7KA"><p>123, Tepi Rumah, Kuala Lumpur</p></a>
        </div>
        <div>
            <h3>CONTACT NUMBER</h3>
            <a href="https://web.whatsapp.com/"><p>Telefon: +6012-3456789</p></a>
        </div>
        <div>
            <h3>FOLLOW US</h3>
            <ul>
                <li><a href="https://www.facebook.com/adidas"><img src="https://brand.assets.adidas.com/image/upload/f_auto,q_auto,fl_lossy/NE_Wfacebook_image_footer_tcm217_875964_307e7730ff.png" alt="Facebook"></a></li>
                <li><a href="https://www.instagram.com/adidas/"><img src="https://brand.assets.adidas.com/image/upload/f_auto,q_auto,fl_lossy/NE_Winstagram_logo_footer_tcm221_875968_97cba77886.png" alt="Instagram"></a></li>
                <li><a href="https://twitter.com/adidas"><img src="https://brand.assets.adidas.com/image/upload/f_auto,q_auto,fl_lossy/NEW_Black_icon_Twitter_logo_transparent_PNG_tcm217_875966_0b2a89f2cf.png" alt="Twitter"></a></li>
                <li><a href="https://www.pinterest.com/adidas/"><img src="https://brand.assets.adidas.com/image/upload/f_auto,q_auto,fl_lossy/NE_Wpinterest_logo_footer_tcm217_875965_cee56ad835.png" alt="Pinterest"></a></li>
                <li><a href="https://www.tiktok.com/@adidas?lang=en"><img src="https://brand.assets.adidas.com/image/upload/f_auto,q_auto,fl_lossy/NE_Wtiktok_black_share_icon1189_tcm221_875969_892f4e5559.png" alt="TikTok"></a></li>
                <li><a href="https://www.youtube.com/c/adidas"><img src="https://brand.assets.adidas.com/image/upload/f_auto,q_auto,fl_lossy/NE_Wyoutube_icon_footer_tcm217_875967_85d1e76b8a.png" alt="YouTube"></a></li>
            </ul>
        </div>
    </div>

    <script>
        // Search function remains the same
        function handleSearch() {
            const searchInput = document.querySelector(".search-container input").value.toLowerCase();
            const validKeywords = {
                "baju": "clothes.php",
                "clothes": "clothes.php",
                "kasut": "shoes.php",
                "shoes": "shoes.php",
                "hoodie": "hoodie.php",
                "hoodies": "hoodie.php"
            };

            const redirectUrl = validKeywords[searchInput];

            if (redirectUrl) {
                window.location.href = redirectUrl;
            } else {
                alert("Produk tidak ditemui. Sila cuba kata kunci lain seperti 'baju', 'kasut', atau 'hoodie'.");
            }
        }

        document.querySelector(".search-container button").addEventListener("click", handleSearch);
        document.querySelector(".search-container input").addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                handleSearch();
            }
        });
    </script>
</body>
</html>