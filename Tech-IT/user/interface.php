<?php
include '../includes/config.php';
?>

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

    <!-- Product display part palang wala pang function yung button -->
    <div class="main-content">
        <div class="product-container">
            <?php 
            $sql_display="SELECT * FROM product";
            $result = mysqli_query($conn, $sql_display);
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="product-card">';
                    echo '<img src="' . $row['product_img'] . '" alt="Product Image">';
                    echo '<h5>' . $row['product_name'] .'</h5>';
                    echo '<p>' . $row['product_description'] . '</p>';
                    echo '<p class="price">$' . $row['price'] . '</p>';
                    echo '<button>Add to Cart</button>';
                    echo '</div>';
                }
            } else {
                echo "No products found.";
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
