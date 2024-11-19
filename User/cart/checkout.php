<?php 
include '../../Administrator/includes/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Initialize total amount
$total_amount = 0;

// Fetch cart items for the current user
$query = "SELECT product_id, quantity FROM cart WHERE account_id = {$_SESSION['user_id']}";
$result = mysqli_query($conn, $query);

// Error checking for query execution
if (!$result) {
    die("Error fetching cart items: " . mysqli_error($conn));
}

$order_items = [];

// Collect items and calculate total
while ($row = mysqli_fetch_assoc($result)) {
    $product_id = $row['product_id'];
    $quantity = $row['quantity'];
    
    // Fetch product price
    $product_query = "SELECT price FROM product WHERE product_id = $product_id";
    $product_result = mysqli_query($conn, $product_query);
    
    if (!$product_result) {
        die("Error fetching product price: " . mysqli_error($conn));
    }
    
    $product = mysqli_fetch_assoc($product_result);
    $price = $product['price'];
    $total_amount += $price * $quantity;
    
    $order_items[] = [
        'product_id' => $product_id,
        'quantity' => $quantity,
        'price' => $price
    ];
}

// Insert into orders table
$order_query = "INSERT INTO orders (account_id,orderDate, total_amount) VALUES ({$_SESSION['user_id']},NOW(), $total_amount )";
$order_result = mysqli_query($conn, $order_query);

if (!$order_result) {
    die("Error inserting into orders: " . mysqli_error($conn));
}

// Get the last inserted order ID
$order_id = mysqli_insert_id($conn);

// Insert each item into orderline
foreach ($order_items as $item) {
    $orderline_query = "INSERT INTO orderline (order_id, product_id, quantity, unit_price) VALUES ($order_id, {$item['product_id']}, {$item['quantity']}, {$item['price']})";
    $orderline_result = mysqli_query($conn, $orderline_query);

    if (!$orderline_result) {
        die("Error inserting into orderline: " . mysqli_error($conn));
    }
}

// Clear user's cart
$clear_cart_query = "DELETE FROM cart WHERE account_id = {$_SESSION['user_id']}";
$clear_cart_result = mysqli_query($conn, $clear_cart_query);

if (!$clear_cart_result) {
    die("Error clearing cart: " . mysqli_error($conn));
}

echo "Checkout successful! Total amount: $" . $total_amount;
?>
