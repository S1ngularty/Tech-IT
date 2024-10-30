<?php 
include("../includes/config.php");

if(isset($_SESSION['user_id'])){
if(isset($_POST['role'])){
    $ID=$_POST['ID'];
    $role=$_POST['role'];
    $sql1="UPDATE account SET role=? where account_id=?";
    $stmt1=mysqli_prepare($conn,$sql1);
    mysqli_stmt_bind_param($stmt1,'si',$role,$ID);
    mysqli_stmt_execute($stmt1);
    if(mysqli_stmt_affected_rows($stmt1)>0){
        header("location: index.php");
        exit;
    }
}



}

?>