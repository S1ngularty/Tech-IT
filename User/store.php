<?php
include '../Administrator/includes/config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Please log in to add products to your account.";
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['product_id'], $_POST['total_amount'], $_POST['status'])) {
    $product_id = $_POST['product_id'];
    $total_amount = $_POST['total_amount'];
    $status = $_POST['status'];

    //Kulang pa sa orderline 
    mysqli_begin_transaction($conn);

    try {
        $sql4 = "INSERT INTO orders (user_id, orderDate, total_amount, status) VALUES (?, NOW(), ?, ?)";
        $stmt4 = mysqli_prepare($conn, $sql4);

        if ($stmt4) {
            mysqli_stmt_bind_param($stmt4, 'ids', $user_id, $total_amount, $status);
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
