<?php 
include '../../Administrator/includes/config.php';

if(!isset($_SESSION['user_id']) && !isset($_SESSION['role']) && !isset($_SESSION['status'])){
    $_SESSION['unauthenticated_user']='yes';
    header("location:http:../../Administrator/customer/login.php");
    exit;
}else{

$total_amount = 0;
$item_total = 0;

mysqli_begin_transaction($conn);

try {
    $cart_query = "SELECT product_id, quantity FROM cart WHERE account_id = ?";
    $cart_stmt = mysqli_prepare($conn, $cart_query);
    mysqli_stmt_bind_param($cart_stmt, "i", $_SESSION['user_id']);
    mysqli_stmt_execute($cart_stmt);
    $cart_result = mysqli_stmt_get_result($cart_stmt);

    if (!$cart_result) {
        throw new Exception("Error fetching cart items: " . mysqli_error($conn));
    }

    $order_items = [];

    while ($row = mysqli_fetch_assoc($cart_result)) {
        $product_id = $row['product_id'];
        $quantity = $row['quantity'];

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

    $order_query = "INSERT INTO orders (account_id, orderDate, total_amount) VALUES (?, NOW(), ?)";
    $order_stmt = mysqli_prepare($conn, $order_query);
    mysqli_stmt_bind_param($order_stmt, "id", $_SESSION['user_id'], $total_amount);
    mysqli_stmt_execute($order_stmt);

    if (mysqli_stmt_affected_rows($order_stmt) <= 0) {
        throw new Exception("Error inserting into orders: " . mysqli_error($conn));
    }

    $order_id = mysqli_insert_id($conn);

    $orderline_query = "INSERT INTO orderline (order_id, product_id, quantity, unit_price, total_price, created) VALUES (?, ?, ?, ?, ?, NOW())";
    $orderline_stmt = mysqli_prepare($conn, $orderline_query);

    foreach ($order_items as $item) {
        mysqli_stmt_bind_param($orderline_stmt, "iiidd", $order_id, $item['product_id'], $item['quantity'], $item['price'], $item['total']);
        mysqli_stmt_execute($orderline_stmt);

        if (mysqli_stmt_affected_rows($orderline_stmt) <= 0) {
            throw new Exception("Error inserting into orderline: " . mysqli_error($conn));
        }

        $update_stock_query = "UPDATE stocks SET stock = stock - ? WHERE product_id = ?";
        $update_stock_stmt = mysqli_prepare($conn, $update_stock_query);
        mysqli_stmt_bind_param($update_stock_stmt, "ii", $item['quantity'], $item['product_id']);
        mysqli_stmt_execute($update_stock_stmt);

        if (mysqli_stmt_affected_rows($update_stock_stmt) <= 0) {
            throw new Exception("Error updating stock: " . mysqli_error($conn));
        }
    }

    $clear_cart_query = "DELETE FROM cart WHERE account_id = ?";
    $clear_cart_stmt = mysqli_prepare($conn, $clear_cart_query);
    mysqli_stmt_bind_param($clear_cart_stmt, "i", $_SESSION['user_id']);
    mysqli_stmt_execute($clear_cart_stmt);

    if (mysqli_stmt_affected_rows($clear_cart_stmt) <= 0) {
        throw new Exception("Error clearing cart: " . mysqli_error($conn));
    }

    mysqli_commit($conn);

    echo "Checkout successful! Total amount: $" . $total_amount;
    header("location: ../Shop.php");
    exit();

} catch (Exception $e) {
    mysqli_rollback($conn);
    die("Transaction failed: " . $e->getMessage());
}
}
?>
