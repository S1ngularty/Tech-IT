<?php 
include '../Administrator/includes/config.php';
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
<style>
    /* Header */
/* Navbar */
#navbar {
    background-color: #333;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 50px;
    width: 100%;
    z-index: 1;
    position: fixed;
}

#navbar ul {
    display: flex;
    align-items: center;
    width: 100%;
}

#logo {
    font-size: 24px;
    color: #fff;
    margin-right: 20px;
}

.search-form {
    display: flex;
    justify-content: center;
    align-items: center;
    flex: 1;
}

.search-form input[type="text"] {
    width: 300px;
    padding: 5px;
    border: none;
    border-radius: 5px;
}

.search-form button {
    background: none;
    border: none;
    color: #fff;
    cursor: pointer;
    padding: 0 8px;
    font-size: 16px;
}

.category-dropdown {
    margin-left: 10px;
    padding: 5px;
    border-radius: 5px;
    border: none;
}

.nav-links {
    display: flex;
    gap: 20px;
    font-size: 18px;
}

.nav-links li {
    color: #fff;
    list-style: none;
}

.nav-links li a {
    text-decoration: none;
    color: #fff;
}

.main-content {
    padding: 100px 20px 20px;
}

/* Product Grid */
.product-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* 3 items per row */
    gap: 35px;
    margin-top: 20px;
}

.product-card {
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 15px;
    text-align: center;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
}

.product-card img {
    width: 100%;
    height: 300px;
    object-fit: cover;
    border-radius: 10px;
}


.product-card h5 {
    font-size: 18px;
    margin: 10px 0;
    font-weight: bold
}

.product-card p {
    font-size: 14px;
    color: #555;
}

.product-card .price {
    font-size: 16px;
    color: #333;
    font-weight: bold;
}

.product-card button {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 5px;
    cursor: pointer;
}

.product-card button:hover {
    background-color: #218838;
}
/* Icon group styling */
.icon-group {
    display: flex;
    align-items: center;
    gap: 15px;
}



</style>
<body>
   <!-- Header -->
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
            <?php 
            $sql1= 'SELECT * FROM category';
            $result=mysqli_query($conn, $sql1);
            while($row=mysqli_fetch_assoc($result)){
                print "<option value='{$row['category_id']}'> {$row['category_name']} </option>";
            }
            ?>    
            </select>
        </form>
        
        <!-- Shopping and Notification Icons -->
        <div class="icon-group">
            <a href="Shop.php">
                <i class="fas fa-shopping-bag" style="color:#fff; margin-right:15px;"></i>
            </a>
            <a href="notification.php">
                <i class="fas fa-bell" style="color:#fff; margin-right:15px;"></i>
            </a>
            <a href="cart/cart.php">
                <i class="fas fa-cart-shopping" style="color:#fff; margin-right:15px;"></i>
            </a>
        </div>
        
        <div class="nav-links">
            <li><a href="#">Profile</a></li>
            <li><a href="http:/Tech-IT/administrator/customer/logout.php">Log out</a></li>
        </div>
    </ul>
</nav>

    <!-- Main Content -->
    <div class="main-content">
    <div class="product-container">
        <?php 
        $sql_display = "SELECT * FROM product inner join stocks using (product_id)";
        $result = mysqli_query($conn, $sql_display);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="product-card">';
                echo '<img src="../Administrator/Product/uploads/' . $row['product_img'] . '" alt="Product Image">';
                echo '<h5>' . $row['product_name'] . '</h5>';
                echo '<p>' . $row['product_description'] . '</p>';
                echo '<p class="price">$' . $row['price'] . '</p>';

                echo '<form action="cart/store.php" method="POST">';
                echo '<input type="hidden" name="product_id" value="' . $row['product_id'] . '">';
                echo '<input type="number" name="quantity" value="1" min="1" max="'.$row["stock"].'" step="1" style="width: 70px; margin-right:20px;">';
                echo '<input type="hidden" name="status" value="In Cart">';
                echo '<button type="submit">Add to Cart</button>';
                echo '</form>';
                echo '<a href="cart/product.php?product_id=' . $row['product_id'] . '">View Product</a>';

                echo '</div>';
            }
        } else {
            echo "No products found.";
        }
        ?>
    </div>
</div>
<!-- Checkout Button -->
<!-- <div class="checkout-button-container">
    <form action="cart/checkout.php" method="POST">
        <button type="submit" class="checkout-button">Checkout</button>
    </form>
</div> -->

<!-- To be coded:
 clicking the product container, the user will be redirected to the product.php
 slim the product container a little -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>