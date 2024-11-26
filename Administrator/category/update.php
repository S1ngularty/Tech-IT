<?php 
include("../includes/config.php");
if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin' && isset($_SESSION['role'])){
if(isset($_POST['edit'])){
  try { 
    mysqli_begin_transaction($conn);
    $sql="UPDATE category SET category_name=? where category_id=?";
    $stmt1=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt1,'si',$_POST['edit'],$_POST['category_id'] );
    if(mysqli_stmt_execute($stmt1)){
        mysqli_commit($conn);
        header("location:edit.php");
        exit;
    }else{
        throw new Exception("failed to update!");
    }
}catch(Exception $e){
    mysqli_rollback($conn);
    print "error : ".$e->getMessage();
}
}else{
    print "is not set";
}
}else{
    $_SESSION['unauthenticated_error']="suspicious_access";
    header("location:http:/Tech-IT/Administrator/customer/index.php");
    exit;
  }
?>