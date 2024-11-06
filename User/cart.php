<?php 
include '../Administrator/includes/config.php'; // Database connection
if (!isset($_SESSION['user_id'])) {
    echo "Please log in to add products to your account.";
    exit;
}
// Fetch products with cart details
$sql_display = "SELECT p.product_name, p.price, c.quantity, p.product_description, p.product_img, p.date_added, c.date_placed, c.cart_id
                FROM product p 
                INNER JOIN cart c ON p.product_id = c.product_id";
$result = mysqli_query($conn, $sql_display);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Tech-IT</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<style>
/* Navbar */
#navbar {
    background-color: #333;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 50px;
    width: 100%;
    z-index: 1;
    position: fixed;
    top: 0;
}

#logo {
    font-size: 24px;
    color: #fff;
    font-weight: bold;
}

.nav-links {
    display: flex;
    gap: 20px;
}

.nav-links li {
    list-style: none;
}

.nav-links li a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
}

/* Main Content */
.main-content {
    padding: 100px 20px 20px; /* Adjust for fixed navbar */
}

/* Product Container */
.product-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
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
    height: 200px;
    object-fit: cover;
    border-radius: 10px;
}

.product-card h5 {
    font-size: 18px;
    margin: 10px 0;
}

.product-card p {
    font-size: 14px;
    color: #555;
}

.product-card .price, .product-card .quantity, .product-card .date-added, .product-card .date-placed {
    font-size: 14px;
    color: #333;
    margin: 5px 0;
}

.product-card button {
    background-color: #dc3545; /* Cart removal button */
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 5px;
    cursor: pointer;
}

.product-card button:hover {
    background-color: #c82333;
}
</style>
<body>
    <!-- Navbar -->
    <nav id="navbar">
        <div id="logo">Tech-IT</div>
        <ul class="nav-links">
            <li><a href="#">Profile</a></li>
            <li><a href="http:/Tech-IT/customer/logout.php">Log out</a></li>
        </ul>
    </nav>

 <!-- Main Content -->
 <div class="main-content">
        <h2>Shopping Cart</h2>
        <div class="product-container">
            <?php 
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="product-card">';
                    echo '<img src="../Administrator/Product/uploads/' . $row['product_img'] . '" alt="Product Image">';
                    echo '<h5>' . $row['product_name'] . '</h5>';
                    echo '<p>' . $row['product_description'] . '</p>';
                    echo '<p class="price">Price: $' . $row['price'] . '</p>';
                    echo '<p class="quantity">Quantity in Cart: ' . $row['quantity'] . '</p>';
                    echo '<p class="date-added">Added on: ' . date("F j, Y", strtotime($row['date_added'])) . '</p>';
                    echo '<p class="date-placed">Date Placed: ' . date("F j, Y", strtotime($row['date_placed'])) . '</p>';
                 //   echo '<form action="delete.php" method="POST">';
                  //  echo '<input type="hidden" name="cart_id" value="' . $row['cart_id'] . '">';
                  echo '<a href="delete.php?id=' . $row['cart_id'] . '" class="btn btn-danger">Remove from Cart</a>';
                  // echo '</form>';
                    echo '</div>';
//<button type='submit' class='btn btn-danger' name='delete' value='delete'><a href='delete.php?id={$row['category_id']}' style='color:#fff; text-decoration:none;'>Delete</a></button>

                }
            } else {
                echo "<p>Your cart is currently empty.</p>";
            }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
