<?php 
include("../includes/config.php");


if(isset($_SESSION['user_id'])){
   try{
    mysqli_begin_transaction($conn);
    $sql2="SELECT profile_img FROM account where user_id={$_GET['id']}";
    $result=mysqli_query($conn,$sql2);
    $row=mysqli_fetch_assoc($result);
    
    echo $path="uploads/".trim($row['profile_img']);
    if(file_exists($path)){
        if(unlink($path)){
            $sql="DELETE FROM user where user_id=?";
        $stmt1=mysqli_prepare($conn,$sql);
        mysqli_stmt_bind_param($stmt1,'i',$_GET['id']);
        mysqli_stmt_execute($stmt1);
    
        if(mysqli_stmt_affected_rows($stmt1)>0){
            mysqli_commit($conn);
            header("location:index.php");
            exit;
        }else{
            throw new  Exception("failed to delete the account! (unlink)");
        }
        }else{
            throw new Exception("couldnt delete your profile ");
        }
    }else{
        $sql="DELETE FROM user where user_id=?";
        $stmt1=mysqli_prepare($conn,$sql);
        mysqli_stmt_bind_param($stmt1,'i',$_GET['id']);
        mysqli_stmt_execute($stmt1);
    
        if(mysqli_stmt_affected_rows($stmt1)>0){
            header("location:index.php");
            exit;
        }else{
            throw new  Exception("failed to delete the account!");
        }
    }
        
   }catch(Exception $e){
    mysqli_rollback($conn);
    print "encountered an error:".$e->getMessage();

   }
}



?>