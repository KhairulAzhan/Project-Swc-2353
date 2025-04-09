<?php
session_start();
require __DIR__ . '/../db_connect.php';

if (!isset($_SESSION['customer_id'])) {
    header("Location: http://localhost/Projek2.0/login/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bank = $_POST['bank'];
    $amount = $_POST['amount'];

    if (!empty($bank) && !empty($amount) && is_numeric($amount) && $amount > 0) {
        $customer_id = $_SESSION['customer_id'];

        // Pastikan pesanan wujud dalam database
        $sql_order = "SELECT order_id FROM orders WHERE customer_id = ? ORDER BY order_date DESC LIMIT 1";
        $stmt_order = $conn->prepare($sql_order);
        $stmt_order->bind_param("i", $customer_id);
        $stmt_order->execute();
        $result_order = $stmt_order->get_result();
        $order = $result_order->fetch_assoc();
        $stmt_order->close();

        if ($order) {
            $order_id = $order['order_id'];

            // Simpan pembayaran dalam jadual payments
            $sql = "INSERT INTO payments (order_id, bank, amount_paid, payment_date) VALUES (?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isd", $order_id, $bank, $amount);

            if ($stmt->execute()) {
                echo "<script>localStorage.removeItem('cart');</script>";

                $_SESSION['payment_details'] = [
                    'order_id' => $order_id,
                    'amount' => $amount,
                    'bank' => $bank,
                    'date' => date('d/m/Y H:i:s')
                ];

                header("Location: done_payment.php");
                exit();
            } else {
                $payment_error = "Pembayaran gagal! Sila cuba lagi.";
            }
            $stmt->close();
        } else {
            $payment_error = "Tiada pesanan ditemui untuk pelanggan ini.";
        }
    } else {
        $payment_error = "Sila pilih bank dan pastikan jumlah pembayaran sah!";
    }
}


$conn->close();
?>


<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - KZ Shop</title>
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

        /* Cart Section */
        .cart-section {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .cart-section h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .cart-section ul {
            list-style: none;
            padding: 0;
        }

        .cart-section ul li {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-section p {
            text-align: right;
            font-weight: bold;
        }

        .delete-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: red;
            padding: 5px;
        }

        /* Payment Section */
        .payment-section {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .payment-section h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .payment-section label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .payment-section select, 
        .payment-section input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .payment-section button {
            width: 100%;
            padding: 10px;
            background-color: black;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .payment-section button:hover {
            background-color: #333;
        }

        /* Error Message */
        .error-message {
            color: #ff0000;
            text-align: center;
            margin-bottom: 20px;
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
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        SUPPORT LOCAL
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
            <a href="cart.php">
                <button><i class="fa-solid fa-cart-shopping"></i></button>
            </a>
        </div>
    </header>

    <!-- Navigation -->
    <nav>
        <ul>
            <li><a href="http://localhost/Projek2.0/home.php">HOME</a></li>
            <li class="dropdown">
                <a href="catalog.php">CATALOG</a>
                <div class="dropdown-content">
                    <a href="http://localhost/Projek2.0/Clothes.php">Clothes</a>
                    <a href="http://localhost/Projek2.0/Shoes.php">Shoes</a>
                    <a href="http://localhost/Projek2.0/Hoodie.php">Hoodies</a>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Cart Section -->
    <div class="cart-section">
        <h2>CART</h2>
        <ul id="cart-items">
            <!-- Cart items will be displayed here -->
        </ul>
        <p>TOTAL: <span id="total-amount">RM0</span></p>
    </div>

    <!-- Payment Section -->
    <div class="payment-section">
        <h2>CHECKOUT</h2>
        
        <?php if(isset($payment_error)): ?>
            <div class="error-message"><?php echo $payment_error; ?></div>
        <?php endif; ?>
        
        <form action="http://localhost/Projek2.0/paymentdone/done_payment.php" method="POST">
            <label for="bank">Select Bank:</label>
            <select id="bank" name="bank" required>
                <option value="">-- Select Bank --</option>
                <option value="maybank">Maybank</option>
                <option value="cimb">CIMB</option>
                <option value="public">Public Bank</option>
                <option value="rhb">RHB Bank</option>
            </select>

            <label for="amount">Total Amount:</label>
            <input type="number" id="amount" name="amount" readonly>

            <button type="submit">Pay Now</button>
        </form>
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
        // Display cart and calculate total
        function displayCartAndCalculateTotal() {
            const cartItems = JSON.parse(localStorage.getItem("cart")) || [];
            const cartItemsElement = document.getElementById("cart-items");
            const totalAmountElement = document.getElementById("total-amount");
            const amountInput = document.getElementById("amount");

            let totalAmount = 0;
            cartItemsElement.innerHTML = "";

            cartItems.forEach((item, index) => {
                const li = document.createElement("li");
                li.innerHTML = `
                    <span>${item.name} - RM${item.price.toFixed(2)}</span>
                    <button class="delete-btn" data-index="${index}">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                `;
                cartItemsElement.appendChild(li);
                totalAmount += item.price;
            });

            totalAmountElement.textContent = `RM${totalAmount.toFixed(2)}`;
            amountInput.value = totalAmount.toFixed(2);
        }

        // Remove item from cart
        document.addEventListener("click", function(e) {
            if (e.target.closest(".delete-btn")) {
                const index = e.target.closest(".delete-btn").dataset.index;
                if (confirm("Are you sure you want to remove this item?")) {
                    const cartItems = JSON.parse(localStorage.getItem("cart")) || [];
                    cartItems.splice(index, 1);
                    localStorage.setItem("cart", JSON.stringify(cartItems));
                    displayCartAndCalculateTotal();
                }
            }
        });

        // Search function
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
                alert("Product not found. Please try keywords like 'baju', 'kasut', or 'hoodie'.");
            }
        }

        // Initialize page
        document.addEventListener("DOMContentLoaded", function() {
            displayCartAndCalculateTotal();
            
            document.querySelector(".search-container button").addEventListener("click", handleSearch);
            document.querySelector(".search-container input").addEventListener("keypress", function(event) {
                if (event.key === "Enter") handleSearch();
            });
        });
    </script>
</body>
</html>