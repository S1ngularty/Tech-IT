<?php 
include("../includes/config.php");
$query2="SELECT category_id FROM category where category_name = 'Uncategorized'";
$result2=mysqli_query($conn,$query2);
$default=mysqli_fetch_assoc($result2);

$query="SELECT product_id FROM product_category where category_id={$_GET['id']}";
$result=mysqli_query($conn,$query);

$c;
  try { 
    mysqli_begin_transaction($conn);
    while($row=mysqli_fetch_assoc($result)){
        echo $sql2="UPDATE product_category SET category_id = ?
         where product_id= ?";
        $stmt3=mysqli_prepare($conn,$sql2);
        mysqli_stmt_bind_param($stmt3,'ii',$default['category_id'],$row['product_id']);
       if( mysqli_stmt_execute($stmt3)){
        $c++;
       }
    }
     
  if($c>0) { 
    $sql="DELETE FROM category WHERE category_id=? ";
    $stmt1=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt1,'i',$_GET['id']);
    if(mysqli_stmt_execute($stmt1)){
        mysqli_commit($conn);
        header("location:edit.php");
        exit;
    }else{
        throw new Exception("failed to delete!");
    }
}else{
    throw new Exception("no affected rows");
}
}catch(Exception $e){
    mysqli_rollback($conn);
    print "error : ".$e->getMessage();
}


?>