<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech-IT</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <nav id="navbar">
        <ul>
            <li id="logo"><strong>Tech-IT</strong></li>
            <form action="" class="search-form">
                <input type="text" placeholder="Search...">
                <button type="submit">
                    <i class="fas fa-magnifying-glass"></i>
                </button>
                <select class="category-dropdown">
                    <option value="">Category</option>
                    <option value="laptops">Laptops</option>
                    <option value="phones">Phones</option>
                    <option value="accessories">Accessories</option>
                </select>
            </form>
            <i class="fas fa-cart-shopping"></i>
            <div class="nav-links">
                <li><a href="#">Profile</a></li>
                <li><a href="http:/Tech-IT/customer/logout.php">Log out</a></li>
            </div>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="product-container">
            <!-- Product Cards -->
            <div class="product-card">
                <img src="https://via.placeholder.com/300x200" alt="Product Image">
                <h5>Product Name</h5>
                <p>Product description goes here.</p>
                <p class="price">$99.99</p>
                <button>Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="https://via.placeholder.com/300x200" alt="Product Image">
                <h5>Another Product</h5>
                <p>Another description with highlights.</p>
                <p class="price">$149.99</p>
                <button>Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="https://via.placeholder.com/300x200" alt="Product Image">
                <h5>Third Product</h5>
                <p>Description for the third product.</p>
                <p class="price">$199.99</p>
                <button>Add to Cart</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
