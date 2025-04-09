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

        /* Filter and Sort */
        .filter-sort {
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .filter-sort select {
            padding: 5px;
            width: 150px;
        }

        /* Product Grid */
         .product-grid {
         display: grid;
         grid-template-columns: repeat(4, 1fr); /* 4 items per row */
         gap: 20px; /* Jarak antara item */
         padding: 20px;
         }

        .product-card {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .product-card img {
            width: 100%;
            height: auto;
        }

        .product-card h3 {
            margin: 10px 0;
            font-size: 16px;
        }

        .product-card p {
            font-size: 14px;
            color: #555;
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
            <li><a href="Home.php">HOME</a></li>
            <li class="dropdown">
                <a href="catalog.php">CATALOG</a>
                <div class="dropdown-content">
                    <a href="Clothes.php">Clothes</a>
                    <a href="Shoes.php">Shoes</a>
                    <a href="Hoodie.php">Hoodies</a>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Filter and Sort -->
    <div class="filter-sort">
        <select id="category-filter">
            <option value="all">All</option>
            <option value="clothing">Clothes</option>
            <option value="shoes">Shoes</option>
            <option value="hoodies">Hoodies</option>
        </select>
        <select id="sort-by">
            <option value="default">Sort By</option>
            <option value="price-low-to-high">Price: Low to High</option>
            <option value="price-high-to-low">Price: High to Low</option>
        </select>
    </div>

    <!-- Product Grid -->
    <div class="product-grid">
    <!-- Product Baju -->
    <a href="Produk Detail Baju1.php" class="product-link">
        <div class="product-card" data-category="clothing" data-price="50">
            <img src="gambar/shirt1.png" alt="Baju 1">
            <h3>Baju 1</h3>
            <p>RM50</p>
        </div>
    </a>
    <a href="Produk Detail Baju2.php#" class="product-link">
        <div class="product-card" data-category="clothing" data-price="50">
            <img src="gambar/shirt2.png" alt="Baju 2">
            <h3>Baju 2</h3>
            <p>RM50</p>
        </div>
    </a>
    <a href="Produk Detail Baju3.php#" class="product-link">
        <div class="product-card" data-category="clothing" data-price="50">
            <img src="gambar/shirt3.png" alt="Baju 3">
            <h3>Baju 3</h3>
            <p>RM50</p>
        </div>
    </a>
    <a href="Produk Detail Baju4.php#" class="product-link">
        <div class="product-card" data-category="clothing" data-price="50">
            <img src="gambar/shirt4.png" alt="Baju 4">
            <h3>Baju 4</h3>
            <p>RM50</p>
        </div>
    </a>

    <!-- Product Kasut -->
    <a href="produk detail kasut1.php" class="product-link">
        <div class="product-card" data-category="shoes" data-price="120">
            <img src="gambar/shoes1.png" alt="Kasut 1">
            <h3>Kasut 1</h3>
            <p>RM120</p>
        </div>
    </a>
    <a href="produk detail kasut2.php" class="product-link">
        <div class="product-card" data-category="shoes" data-price="120">
            <img src="gambar/shoes2.png" alt="Kasut 2">
            <h3>Kasut 2</h3>
            <p>RM120</p>
        </div>
    </a>
    <a href="produk detail kasut3.php" class="product-link">
        <div class="product-card" data-category="shoes" data-price="120">
            <img src="gambar/shoes3.png" alt="Kasut 3">
            <h3>Kasut 3</h3>
            <p>RM120</p>
        </div>
    </a>
    <a href="produk detail kasut4.php" class="product-link">
        <div class="product-card" data-category="shoes" data-price="120">
            <img src="gambar/shoes4.png" alt="Kasut 4">
            <h3>Kasut 4</h3>
            <p>RM120</p>
        </div>
    </a>

    <!-- Product Hoodies -->
    <a href="produk detail hoodie1.php" class="product-link">
        <div class="product-card" data-category="hoodies" data-price="80">
            <img src="gambar/hoodie1.png" alt="Hoodie 1">
            <h3>Hoodie 1</h3>
            <p>RM80</p>
        </div>
    </a>
    <a href="produk detail hoodie2.php" class="product-link">
        <div class="product-card" data-category="hoodies" data-price="80">
            <img src="gambar/hoodie2.png" alt="Hoodie 2">
            <h3>Hoodie 2</h3>
            <p>RM80</p>
        </div>
    </a>
    <a href="produk detail hoodie3.php" class="product-link">
        <div class="product-card" data-category="hoodies" data-price="80">
            <img src="gambar/hoodie3.png" alt="Hoodie 3">
            <h3>Hoodie 3</h3>
            <p>RM80</p>
        </div>
    </a>
    <a href="produk detail hoodie4.php" class="product-link">
        <div class="product-card" data-category="hoodies" data-price="80">
            <img src="gambar/hoodie4.png" alt="Hoodie 4">
            <h3>Hoodie 4</h3>
            <p>RM80</p>
        </div>
    </a>
    </div>
    

    <!-- Footer -->
    <footer>
        <h1>ABOUT US</h1>
        <p>KZ CLOTHING IS A LOCAL BRAND FROM MALAYSIA FOUNDED BY KHAIRUL AZHAN.</p>
    </footer>
    <div class="footer-bottom">
        <div>
            <h3>ADDRESS</h3>
            <p>123, Tepi Rumah, Kuala Lumpur</p>
        </div>
        <div>
            <h3>CONTACT NUMBER</h3>
            <p>Telefon: +6012-3456789</p>
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
        // JavaScript untuk Filter dan Sort
        const categoryFilter = document.getElementById("category-filter");
        const sortBy = document.getElementById("sort-by");
        const productGrid = document.querySelector(".product-grid");

        categoryFilter.addEventListener("change", filterProducts);
        sortBy.addEventListener("change", sortProducts);

        function filterProducts() {
            const selectedCategory = categoryFilter.value;
            const products = document.querySelectorAll(".product-card");

            products.forEach(product => {
                const productCategory = product.getAttribute("data-category");

                if (selectedCategory === "all" || productCategory === selectedCategory) {
                    product.style.display = "block";
                } else {
                    product.style.display = "none";
                }
            });
        }

        function sortProducts() {
    const selectedSort = sortBy.value;
    const productLinks = Array.from(document.querySelectorAll(".product-link")); // Ambil elemen <a>

    if (selectedSort === "price-low-to-high") {
        productLinks.sort((a, b) => {
            const priceA = parseFloat(a.querySelector(".product-card").getAttribute("data-price"));
            const priceB = parseFloat(b.querySelector(".product-card").getAttribute("data-price"));
            return priceA - priceB;
        });
    } else if (selectedSort === "price-high-to-low") {
        productLinks.sort((a, b) => {
            const priceA = parseFloat(a.querySelector(".product-card").getAttribute("data-price"));
            const priceB = parseFloat(b.querySelector(".product-card").getAttribute("data-price"));
            return priceB - priceA;
        });
    }

    // Clear product grid
    productGrid.innerHTML = "";

    // Append sorted product links
    productLinks.forEach(link => {
        productGrid.appendChild(link);
    });
}
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

        // Event listener untuk butang search
        document.querySelector(".search-container button").addEventListener("click", handleSearch);

        // Event listener untuk tekan "Enter" dalam input search
        document.querySelector(".search-container input").addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                handleSearch();
            }
        });
    </script>
</body>
</html>