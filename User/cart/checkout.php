<?php 
include '../../Administrator/includes/config.php';

// Check if user is logged in
if(!isset($_SESSION['user_id']) && !isset($_SESSION['role']) && !isset($_SESSION['status'])){
    $_SESSION['unauthenticated_user']='yes';
    header("location:http:../../Administrator/customer/login.php");
    exit;
}else{

// Initialize total amount
$total_amount = 0;
$item_total = 0;

// Begin transaction
mysqli_begin_transaction($conn);

try {
    // Fetch cart items for the current user
    $cart_query = "SELECT product_id, quantity FROM cart WHERE account_id = ?";
    $cart_stmt = mysqli_prepare($conn, $cart_query);
    mysqli_stmt_bind_param($cart_stmt, "i", $_SESSION['user_id']);
    mysqli_stmt_execute($cart_stmt);
    $cart_result = mysqli_stmt_get_result($cart_stmt);

    if (!$cart_result) {
        throw new Exception("Error fetching cart items: " . mysqli_error($conn));
    }

    $order_items = [];

    // Collect items and calculate total
    while ($row = mysqli_fetch_assoc($cart_result)) {
        $product_id = $row['product_id'];
        $quantity = $row['quantity'];

        // Fetch product price
        $product_query = "SELECT price FROM product WHERE product_id = ?";
        $product_stmt = mysqli_prepare($conn, $product_query);
        mysqli_stmt_bind_param($product_stmt, "i", $product_id);
        mysqli_stmt_execute($product_stmt);
        $product_result = mysqli_stmt_get_result($product_stmt);

        if (!$product_result) {
            throw new Exception("Error fetching product price: " . mysqli_error($conn));
        }

        $product = mysqli_fetch_assoc($product_result);
        $price = $product['price'];
        $total_amount += $price * $quantity;
        $item_total = $price * $quantity;
        $order_items[] = [
            'product_id' => $product_id,
            'quantity' => $quantity,
            'price' => $price,
            'total' => $item_total
        ];
    }

    if ($total_amount == 0) {
        header("location:cart.php");
        exit();
    }

    // Insert into orders table
    $order_query = "INSERT INTO orders (account_id, orderDate, total_amount) VALUES (?, NOW(), ?)";
    $order_stmt = mysqli_prepare($conn, $order_query);
    mysqli_stmt_bind_param($order_stmt, "id", $_SESSION['user_id'], $total_amount);
    mysqli_stmt_execute($order_stmt);

    if (mysqli_stmt_affected_rows($order_stmt) <= 0) {
        throw new Exception("Error inserting into orders: " . mysqli_error($conn));
    }

    // Get the last inserted order ID
    $order_id = mysqli_insert_id($conn);

    // Insert each item into orderline
    $orderline_query = "INSERT INTO orderline (order_id, product_id, quantity, unit_price, total_price, created) VALUES (?, ?, ?, ?, ?, NOW())";
    $orderline_stmt = mysqli_prepare($conn, $orderline_query);

    foreach ($order_items as $item) {
        mysqli_stmt_bind_param($orderline_stmt, "iiidd", $order_id, $item['product_id'], $item['quantity'], $item['price'], $item['total']);
        mysqli_stmt_execute($orderline_stmt);

        if (mysqli_stmt_affected_rows($orderline_stmt) <= 0) {
            throw new Exception("Error inserting into orderline: " . mysqli_error($conn));
        }
    }

    // Clear user's cart
    $clear_cart_query = "DELETE FROM cart WHERE account_id = ?";
    $clear_cart_stmt = mysqli_prepare($conn, $clear_cart_query);
    mysqli_stmt_bind_param($clear_cart_stmt, "i", $_SESSION['user_id']);
    mysqli_stmt_execute($clear_cart_stmt);

    if (mysqli_stmt_affected_rows($clear_cart_stmt) <= 0) {
        throw new Exception("Error clearing cart: " . mysqli_error($conn));
    }

    // Commit the transaction
    mysqli_commit($conn);

    echo "Checkout successful! Total amount: $" . $total_amount;
    header("location: ../Shop.php");
    exit();

} catch (Exception $e) {
    // Rollback the transaction in case of error
    mysqli_rollback($conn);
    die("Transaction failed: " . $e->getMessage());
}
}
?>
    