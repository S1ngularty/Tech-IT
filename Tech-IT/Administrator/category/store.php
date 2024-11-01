<?php 
include("../includes/config.php");

if(isset($_POST['create'])){
  try { 
    mysqli_begin_transaction($conn);
    $sql="INSERT INTO category (category_name) values (?) ";
    $stmt1=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt1,'s',trim($_POST['create']));
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

?>