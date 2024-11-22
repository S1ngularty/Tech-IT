<?php 
include("../includes/config.php");

if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin' && isset($_SESSION['role'])){

   if(!empty($_POST['stat'])){
    echo $ID =$_POST['ID'];
    echo $stat=$_POST['stat'];
    $sql1="UPDATE orders SET status=? WHERE order_id=?";
    $stmt=mysqli_prepare($conn,$sql1);
    mysqli_stmt_bind_param($stmt,'si',$stat,$ID);
    if(mysqli_stmt_execute($stmt)){
        header("location: index.php");
        exit;
    }
   }


}else{
    $_SESSION['unauthenticated_error']="suspicious_access";
    header("location:http:/Tech-IT/Administrator/customer/index.php");
    exit;
  }

?>