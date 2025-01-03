<?php 
include "../../Administrator/includes/config.php";
if(!isset($_SESSION['user_id']) && !isset($_SESSION['role']) && !isset($_SESSION['status'])){
    $_SESSION['unauthenticated_user']='yes';
    header("location:http:../../Administrator/customer/login.php");
    exit;
}else{
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
            mysqli_stmt_bind_param($stmt6, 'ii', $quantity, $cart_id);
        if (mysqli_stmt_execute($stmt6)){
            mysqli_commit($conn);
            echo "Product updated successfully";
            header("location:cart.php");
            exit;
        } else{
            throw new Exception("Failed to update product");
        } 
        
    } catch (Exception $e){
        mysqli_rollback($conn);
        echo "error:" . $e->getMessage();
}
} else {
    echo "Required data is missing";
}
mysqli_close($conn);
}
?>
