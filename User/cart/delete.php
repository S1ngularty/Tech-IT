<?php 
include '../../Administrator/includes/config.php';

if(!isset($_SESSION['user_id']) && !isset($_SESSION['role']) && !isset($_SESSION['status'])){
    $_SESSION['unauthenticated_user']='yes';
    header("location:http:../../Administrator/customer/login.php");
    exit;
}else{
if (isset($_SESSION['user_id'])) {
    try {
        mysqli_begin_transaction($conn);
        
        $sql5 = "DELETE FROM cart WHERE cart_id = ?";
        $stmt5 = mysqli_prepare($conn, $sql5);
                if (isset($_GET['id'])) {
            mysqli_stmt_bind_param($stmt5, 'i', $_GET['id']);
            if (mysqli_stmt_execute($stmt5)) {
                mysqli_commit($conn);
                header("location: cart.php");
                exit;
            } else {
                throw new Exception("Failed to remove from cart");
            }
        } else {
            throw new Exception("No cart ID provided");
        }
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "Error: " . $e->getMessage();
    }
}
}
?>