<?php
include '../../Administrator/includes/config.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

if (isset($_POST['product_id'], $_POST['quantity'])) { 
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    mysqli_begin_transaction($conn);

       $sql1="SELECT * FROM cart where product_id=$product_id && account_id={$_SESSION['user_id']}";
       $result=mysqli_query($conn,$sql1);

      
       if( mysqli_num_rows($result)> 0) {
        try{
        $row=mysqli_fetch_assoc($result);
        $cart_id = $row ["cart_id"];
         $override="UPDATE cart SET quantity=? where cart_id=?";
         $stmt=mysqli_prepare($conn,$override);
         mysqli_stmt_bind_param($stmt,'ii',$quantity,$cart_id);
         if(mysqli_stmt_execute($stmt)) {
            mysqli_commit($conn);
            header("location:cart.php");
            exit;
         }
         
        }catch(Exception $e) {
            mysqli_rollback($conn);
            print "error :". $e->getMessage();
        }
    }else{
       

        
    try {
        $sql4 = "INSERT INTO cart (account_id, product_id, quantity, date_placed) VALUES (?,?,?,NOW())";
        $stmt4 = mysqli_prepare($conn, $sql4);
            mysqli_stmt_bind_param($stmt4, 'iii', $user_id, $product_id, $quantity);
            if (mysqli_stmt_execute($stmt4)) {
                mysqli_commit($conn);
        echo "Product is added to your cart successfully.";
        header("location:../Shop.php");
        exit;
            }
      
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo $e->getMessage();
    }
    }

} else {
    echo "Required data is missing.";
}



}else{
    print "please login first!";
    exit;
}



mysqli_close($conn);
?>