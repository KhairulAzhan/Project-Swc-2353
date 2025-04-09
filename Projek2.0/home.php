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

        /* Slider */
        .slider {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            width: 100%;
        }

        .slides {
            position: relative;
            width: 100%;
            max-width: 1920px;
        }

        .slides img {
            display: none;
            width: 100%;
            max-width: 100%;
            height: auto;
            transition: opacity 1s ease-in-out;
        }

        .slides img.active {
            display: block;
        }

        /* Dot Navigation */
        .dot-container {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2;
            text-align: center;
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 20px;
        }

        .dot {
            cursor: pointer;
            height: 15px;
            width: 15px;
            margin: 0 5px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .dot.active {
            background-color: #333;
        }

        /* Header Baju */
        .header.baju h2 {
        font-size: 24px;
        color: #333;
        font-weight: bold;
        margin: 20px 0;
        }

        /* Product Section */
        .product-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 20px;
            flex-wrap: wrap;
        }

        .product-box {
            flex: 1 1 calc(25% - 40px);
            max-width: calc(25% - 40px);
            box-sizing: border-box;
        }

        .product-box img {
            width: 100%;
            height: auto;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-box img:hover {
            transform: scale(1.05);
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }


        /*video*/
        .video-container {
        width: 100%;
        max-width: 1920px; /* Sesuaikan dengan lebar slider */
        margin: 20px auto; /* Berikan jarak atas dan bawah */
        text-align: center; /* Pusatkan video */
        }

        video {
        width: 100%;
        height: auto;
        border-radius: 10px; /* Tambahkan border radius jika diperlukan */
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); /* Tambahkan shadow jika diperlukan */
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
    <script defer>
        document.addEventListener("DOMContentLoaded", function() {
            let slideIndex = 0;
            const slides = document.querySelectorAll(".slides img");
            const dots = document.querySelectorAll(".dot");
            let slideInterval;

            function showSlides() {
                slides.forEach((slide, index) => {
                    slide.style.display = index === slideIndex ? "block" : "none";
                });
                dots.forEach((dot, index) => {
                    dot.classList.toggle("active", index === slideIndex);
                });
                slideIndex = (slideIndex + 1) % slides.length;
            }

            function startAutoSlide() {
                slideInterval = setTimeout(() => {
                    showSlides();
                    startAutoSlide();
                }, 8000);
            }

            function currentSlide(index) {
                clearTimeout(slideInterval);
                slideIndex = index;
                showSlides();
                startAutoSlide();
            }

            dots.forEach((dot, index) => {
                dot.addEventListener("click", () => currentSlide(index));
            });

            showSlides();
            startAutoSlide();

            // Dropdown Menu
            document.querySelectorAll(".dropdown").forEach(item => {
                item.addEventListener("mouseenter", () => {
                    item.querySelector(".dropdown-content").style.display = "block";
                });
                item.addEventListener("mouseleave", () => {
                    item.querySelector(".dropdown-content").style.display = "none";
                });
            });
        });
    </script>
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
        <?php
        
        if (isset($_SESSION['customer_id'])) {
            // Jika sudah login, tunjuk link ke profile dan logout
            echo '<a href="account.php">My Profile</a>';
        } elseif (isset($_SESSION['admin_id'])) {
            // Jika admin login
            echo '<a href="admin_dashboard.php">Admin Panel</a>';
            echo '<a href="logout.php">Logout</a>';
        } else {
            // Jika belum login, tunjuk pilihan login
            echo '<a href="login/login.php">User Login</a>';
            echo '<a href="admin/login.php">Admin Login</a>';
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
    <!-- Slider -->
    <div class="slider">
        <div class="slides">
            <img src="gambar/slider1.png" alt="Slide 1" class="active">
            <img src="gambar/slider2.png" alt="Slide 2">
        </div>
        <div class="dot-container">
            <span class="dot active"></span>
            <span class="dot"></span>
        </div>
    </div>

    <!-- Header Baju -->
    <div class="header baju" style="text-align: center; margin: 20px auto;">
       <h2>CLOTHES</h2>
    </div>
    
    <!-- Product Section Baju -->
    <div class="product-container">
        <div class="product-box"><a href="http://localhost/Projek2.0/Produk%20Detail%20Baju1.php"><img src="gambar/shirt1.png" alt="Baju 1"></a></div>
        <div class="product-box"><a href="http://localhost/Projek2.0/Produk%20Detail%20Baju2.php"><img src="gambar/shirt2.png" alt="Baju 2"></a></div>
        <div class="product-box"><a href="http://localhost/Projek2.0/Produk%20Detail%20Baju3.php"><img src="gambar/shirt3.png" alt="Baju 3"></a></div>
        <div class="product-box"><a href="http://localhost/Projek2.0/Produk%20Detail%20Baju4.php"><img src="gambar/shirt4.png" alt="Baju 4"></a></div>
    </div>

    <!-- Header Kasut -->
    <div class="header baju" style="text-align: center; margin: 20px auto;">
       <h2>SHOES</h2>
    </div>

    <!-- Product Section Kasut -->
    <div class="product-container">
        <div class="product-box"><a href="Produk Detail Kasut1.php"><img src="gambar/shoes1.png" alt="Kasut 1"></a></div>
        <div class="product-box"><a href="Produk Detail Kasut2.php"><img src="gambar/shoes2.png" alt="Kasut 2"></a></div>
        <div class="product-box"><a href="Produk Detail Kasut3.php"><img src="gambar/shoes3.png" alt="Kasut 3"></a></div>
        <div class="product-box"><a href="Produk Detail Kasut4.php"><img src="gambar/shoes4.png" alt="Kasut 4"></a></div>
    </div>

    <!-- Header Hoodie -->
    <div class="header baju" style="text-align: center; margin: 20px auto;">
       <h2>HOODIES</h2>
    </div>

    <!-- Product Section Kasut -->
    <div class="product-container">
        <div class="product-box"><a href="Produk Detail Hoodie1.php"><img src="gambar/hoodie1.png" alt="Hoodie 1"></a></div>
        <div class="product-box"><a href="Produk Detail Hoodie2.php"><img src="gambar/hoodie2.png" alt="Hoodie 2"></a></div>
        <div class="product-box"><a href="Produk Detail Hoodie3.php"><img src="gambar/hoodie3.png" alt="Hoodie 3"></a></div>
        <div class="product-box"><a href="Produk Detail Hoodie4.php"><img src="gambar/hoodie4.png" alt="Hoodie 4"></a></div>
    </div>

    <!-- Video Section -->
    <div class="video-container">
    <video width="100%" controls>
        <source src="gambar/Video.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
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