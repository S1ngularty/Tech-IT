<?php
include '../Administrator/includes/config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Please log in to add products to your account.";
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['product_id'], $_POST['quantity'])) { // Fixed $_POST usage
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        $sql4 = "INSERT INTO cart (user_id, product_id, quantity, date_placed) VALUES (?,?,?,NOW())";
        $stmt4 = mysqli_prepare($conn, $sql4);

        if ($stmt4) {
            mysqli_stmt_bind_param($stmt4, 'iii', $user_id, $product_id, $quantity);
            if (!mysqli_stmt_execute($stmt4)) {
                throw new Exception("ERROR: Could not add order to user.");
            }
            mysqli_stmt_close($stmt4);
        } else {
            throw new Exception("ERROR: Could not prepare query for orders.");
        }

        mysqli_commit($conn);
        echo "Product is added to your cart successfully.";
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo $e->getMessage();
    }
} else {
    echo "Required data is missing.";
}

mysqli_close($conn);
?>
