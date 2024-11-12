<?php 
include '../../administrator/includes/config.php';

if (isset($_SESSION['user_id'])) {
    

echo $user_id = $_SESSION['user_id'];

$sql_display = "SELECT  p.product_name, p.price, c.quantity, p.product_description, p.product_img, p.date_added, c.date_placed, c.cart_id
                FROM product p 
                INNER JOIN cart c ON p.product_id = c.product_id
                WHERE c.account_id = ?";
$stmt = mysqli_prepare($conn, $sql_display);
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Tech-IT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Navbar */
        #navbar {
            background-color: #333;
            display: flex;
            align-items: right;
            justify-content: right;
            padding: 15px 50px;
            position: fixed;
            top: 0px;
            width: 100%;
            z-index: 1;
        }
/* #navbar {
    background-color: #333;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 50px;
    width: 100%;
    z-index: 1;
    position: fixed;
} */
        #logo {
            font-size: 24px;
            color: #fff;
            font-weight: bold;
            position: absolute;
            left: 50px;
        }

        .nav-links {
            display: flex;
            gap: 30px;
            margin-bottom: 5px;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-links li {
            list-style: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-links li a {
            color: #fff;
            text-decoration: none;

            /* font-weight: bold; */
        }

        /* Main Content */
        .main-content {
            padding: 100px 20px 20px;
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

        /* Buttons */
        .product-card .btn-danger, .product-card .btn-update {
            padding: 5px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .product-card .btn-danger {
            background-color: #dc3545;
            color: white;
            border: none;
        }

        .product-card .btn-update {
            background-color: #007bff;
            color: white;
            border: none;
            margin-left: 10px;
        }

        .product-card .btn-danger:hover {
            background-color: #c82333;
        }

        .product-card .btn-update:hover {
            background-color: #0056b3;
        }
        .checkout-button-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
}

.checkout-button {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
}

.checkout-button:hover {
    background-color: #218838;
}
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav id="navbar">
        <div id="logo">Tech-IT</div>
        <ul class="nav-links">
            <li><a href="#">Profile</a></li>
            <li><a href="http:/Tech-IT/administrator/customer/logout.php">Log out</a></li>
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
                    echo '<img src="../../Administrator/Product/uploads/' . $row['product_img'] . '" alt="Product Image">';
                    echo '<h5>' . $row['product_name'] . '</h5>';
                    echo '<p>' . $row['product_description'] . '</p>';
                    echo '<p class="price">Price: $' . $row['price'] . '</p>';
                    echo '<p class="quantity">Quantity in Cart: ' . $row['quantity'] . '</p>';
                    echo '<p class="date-added">Added on: ' . date("F j, Y", strtotime($row['date_added'])) . '</p>';
                    echo '<p class="date-placed">Date Placed: ' . date("F j, Y", strtotime($row['date_placed'])) . '</p>';
                    echo '<a href="delete.php?id=' . $row['cart_id'] . '" class="btn btn-danger btn-remove">Remove from Cart</a>';
                    echo '<form action="update.php" method="POST" style="display:inline-block;">';
                    echo '<input type="hidden" name="cart_id" value="' . $row['cart_id'] . '">';
                    echo '<input type="number" name="quantity" value="' . $row['quantity'] . '" min="1" step="1" style="width: 50px; margin-right:10px; margin-left:20px;">';
                    echo '<button type="submit" class="btn-update">Update Quantity</button>';
                    echo '</form>';
                    echo '</div>';
                }
            }
             else {
                echo "<p>Your cart is currently empty.</p>";
                echo $user_id;
            }
        }else{
            print "login first!";
            exit;
        }
            ?>
        </div>
    </div>
    <div class="checkout-button-container">
    <form action="checkout.php" method="POST">
        <button type="submit" class="checkout-button">Checkout</button>
    </form>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>