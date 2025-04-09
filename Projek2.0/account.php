<?php
session_start();
if (!isset($_SESSION['customer_id'])) {
    header("Location: http://localhost/Projek2.0/login/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalog - KZ Shop</title>
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
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        WELCOME
    </div>

    <!-- Header -->
    <header>
        <div class="logo">
            <a href="home.php#"><img src="gambar/logo brand.png" alt="KZ Logo"></a>
        </div>
        <div class="search-container">
            <input type="text" placeholder="SEARCH">
            <button><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
        <div class="icons">
            <div class="dropdown">
                <button><i class="fa-solid fa-user"></i></button>
                <div class="dropdown-content">
                    <a href="account.php">My Account</a>
                    <a href="logout.php">Logout</a>
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
            <!-- Link untuk Home -->
            <li>
                <a href="home.php#">
                    HOME
                </a>
            </li>

            <!-- Dropdown untuk Catalog -->
            <li class="dropdown">
                <a href="catalog.php">
                    CATALOG
                </a>
                <div class="dropdown-content">
                    <a href="Clothes.php">Clothes</a>
                    <a href="Shoes.php">Shoes</a>
                    <a href="Hoodie.php">Hoodies</a>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Account Section -->
    <div class="account-container">
        <div class="account-header">
            <h1>MY ACCOUNT</h1>
            <p>WELCOME BACK, <?php echo htmlspecialchars($_SESSION['customer_name']); ?>!</p>
        </div>
        
        <div class="account-details">
            <div class="detail-item">
                <span class="detail-label">Name:</span>
                <span class="detail-value"><?php echo htmlspecialchars($_SESSION['customer_name']); ?></span>
            </div>
            
            <div class="detail-item">
                <span class="detail-label">Email:</span>
                <span class="detail-value"><?php echo htmlspecialchars($_SESSION['customer_email']); ?></span>
            </div>
            
        </div>
        
        <div class="account-actions">
            <a href="logout.php" class="btn btn-danger">LOGOUT</a>
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
        // Fungsi untuk search
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

            // Cari kata kunci yang sesuai
            const redirectUrl = validKeywords[searchInput];

            if (redirectUrl) {
                // Redirect ke halaman yang sesuai
                window.location.href = redirectUrl;
            } else {
                // Paparkan mesej "Not Found"
                alert("Produk tidak ditemui. Sila cuba kata kunci lain seperti 'baju', 'kasut', atau 'hoodie'.");
            }
        }

        // Event listener untuk butang carian
        document.querySelector(".search-container button").addEventListener("click", handleSearch);

        // Event listener untuk tekan "Enter" dalam input carian
        document.querySelector(".search-container input").addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                handleSearch();
            }
        });
    </script>
</body>
</html>