<?php 
include("../includes/config.php");


if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin' && isset($_SESSION['role'])){
  try{
    $delete_path="uploads/".trim($_GET['img']);
    mysqli_begin_transaction($conn);
    $sql="DELETE FROM product where product_id=?";
    $stmt1=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt1,'i',$_GET['id']);
    if(mysqli_stmt_execute($stmt1)){
     if(file_exists($delete_path)){
        if(unlink($delete_path)){
             mysqli_commit($conn);
             header("location:index.php");
             exit;
         }else{
            throw new Exception("failed to delete the file");
        }
     }else{
      mysqli_commit($conn);
      header("location:index.php");
      exit;
     }
    }else{
        throw new Exception("failed to execute the statement 1");
    }
  }catch(Exception $e){
    mysqli_rollback($conn);
    print "error:". $e-> getMessage();
  }
}else{
  $_SESSION['unauthenticated_error']="suspicious_access";
  header("location:http:/Tech-IT/Administrator/customer/index.php");
  exit;
}



?>