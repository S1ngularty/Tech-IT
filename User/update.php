<?php 
include "../Administrator/includes/config.php";
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "Please log in to update products in your cart.";
    exit;
}
if (isset($_POST['cart_id']) && $_POST['quantity']){
    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['quantity'];
    

    if ($quantity<1){
    echo "The product quantity must be atleast 1";
    exit;
    }


    try{
        mysqli_begin_transaction($conn);
        $sql6="UPDATE cart SET quantity =? WHERE cart_id=?";
        $stmt6=mysqli_prepare($conn, $sql6);
        if ($stmt6){
            mysqli_stmt_bind_param($stmt6, 'ii', $quantity, $cart_id);
        if (mysqli_stmt_execute($stmt6)){
            mysqli_commit($conn);
            echo "Product updated successfully";
        } else{
            throw new Exception("Failed to update product");
        } 
        mysqli_stmt_close($stmt6);
        }else{
            throw new Exception("Failed to prepare update query");
        }
        
    } catch (Exception $e){
        mysqli_rollback($conn);
        echo "error:" . $e->getMessage();
}
} else {
    echo "Required data is missing";
}
mysqli_close($conn);

?>