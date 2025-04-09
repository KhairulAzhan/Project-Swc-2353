<?php
session_start();
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

        /* Product Detail Section */
        .product-detail {
            display: flex;
            padding: 20px;
            gap: 20px;
        }

        .product-images {
            flex: 1;
        }

        .product-images img {
            width: 100%;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .product-info {
            flex: 1;
            padding: 20px;
        }

        .product-info h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .product-info p {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
        }

        .size-selector {
            margin-bottom: 20px;
        }

        .size-selector label {
            font-size: 16px;
            font-weight: bold;
            margin-right: 10px;
        }

        .size-selector select {
            padding: 5px;
            font-size: 16px;
        }

        .add-to-cart {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }

        .add-to-cart:hover {
            background-color: #0056b3;
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
                    <?php
                    if (isset($_SESSION['customer_id'])) {
                        echo '<a href="account.php">My Profile</a>';
                        echo '<a href="logout.php">Logout</a>';
                    } elseif (isset($_SESSION['admin_id'])) {
                        echo '<a href="admin_dashboard.php">Admin Panel</a>';
                        echo '<a href="logout.php">Logout</a>';
                    } else {
                        echo '<a href="login/login.php">User Login</a>';
                        echo '<a href="admin_login.php">Admin Login</a>';
                    }
                    ?>
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
            <li><a href="Home.php#">HOME</a></li>
            <li class="dropdown">
                <a href="catalog.php#">CATALOG</a>
                <div class="dropdown-content">
                    <a href="Clothes.php">Clothes</a>
                    <a href="Shoes.php">Shoes</a>
                    <a href="Hoodie.php">Hoodies</a>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Product Detail Section -->
    <div class="product-detail">
        <div class="product-images">
            <img src="gambar/shirt4.png" alt="Baju 4">
        </div>
        <div class="product-info">
            <h1>Baju 4</h1>
            <p>RM50</p>
            <p>100% Cotton</p>
            <div class="size-selector">
                <label for="size">Size:</label>
                <select id="size">
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                </select>
            </div>
            <button class="add-to-cart">Add To Cart</button>
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
        function addToCartAndRedirect() {
            
            const productName = "Baju 4"; 
            const productPrice = 50; 
            const selectedSize = document.getElementById("size").value;

            
            const cartItems = JSON.parse(localStorage.getItem("cart")) || [];
            cartItems.push({ name: productName, price: productPrice, size: selectedSize });
            localStorage.setItem("cart", JSON.stringify(cartItems));

            // Redirect ke halaman pembayaran
            window.location.href = "http://localhost/Projek2.0/bayar/cart.php"; 
        }


        // Event listener untuk button "Tambah ke Troli"
        document.querySelector(".add-to-cart").addEventListener("click", addToCartAndRedirect);
    </script>
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