<?php 
include("../includes/config.php");

if(isset($_SESSION['user_id'])){
if(isset($_POST['role'])){
   echo $ID=$_GET['ID'];
   echo $role=$_POST['role'];
    $sql1="UPDATE account SET role=? where account_id=?";
    $stmt1=mysqli_prepare($conn,$sql1);
    mysqli_stmt_bind_param($stmt1,'si',$role,$ID);
    mysqli_stmt_execute($stmt1);
    if(mysqli_stmt_affected_rows($stmt1)>0){
        header("location: index.php");
        exit;
    }
}


if(isset($_POST['update'])){
    echo $_FILES['file']['error'];
    echo $_SESSION['update_id'];
    echo $fname=trim(ucwords($_POST['firstname']));
    echo $lname=trim(ucwords($_POST['lastname']));
    echo $age=trim($_POST['age']);
    echo $gender=trim($_POST['gender']);    
    echo $contact=trim($_POST['contact']);
    echo $username=trim($_POST['username']);
    echo $filename=$_FILES['file']['name'];
    $file_temp=$_FILES['file']['tmp_name'];
    $allowed=array('jpg','jpeg','png');
 echo $current_path="uploads/".trim($_POST['current']);
    try{
        mysqli_begin_transaction($conn);    
        $sql2="UPDATE user SET first_name=?, last_name=?, age=?, sex=?, contacts=? where user_id=?";
        $stmt2=mysqli_prepare($conn,$sql2);
        mysqli_stmt_bind_param($stmt2,'ssisii',$fname,$lname,$age,$gender,$contact,$_SESSION['update_id']);
        mysqli_stmt_execute($stmt2);
        
        if(mysqli_stmt_affected_rows($stmt2)>=0){
           if($_FILES['file']['error']==0){
            $file_ext=explode('.',$filename);
            echo $extension=strtolower(end($file_ext));
             
             if(in_array($extension,$allowed)){
                 echo $newfile=uniqid('',true).".".$extension;
                 $location="uploads/".$newfile;
                 $sql3="UPDATE account SET username=?, profile_img=? where user_id=?";
                 $stmt3=mysqli_prepare($conn,$sql3);
                 mysqli_stmt_bind_param($stmt3,'ssi',$username,$password,$newfile,$_SESSION['update_id']);
                 mysqli_stmt_execute($stmt3);
 
                 if(mysqli_stmt_affected_rows($stmt3)>0){
                 if(file_exists($current_path)){
                     if(unlink($current_path)){
                      if(move_uploaded_file($file_temp,$location)){
                       mysqli_commit($conn);
                       header("location:index.php");
                       exit;
                       
                      }else{
                         throw new Exception("failed to move your file");
                      }
                     }else{
                         throw new Exception("failed to override you current profile");
                     }
                 }else{
                     if(move_uploaded_file($file_temp,$location)){
                         mysqli_commit($conn);
                         $_SESSION['update_id']=array();
                         header("location:index.php");
                         exit;
                        }else{
                           throw new Exception("failed to move and create your file");
                        }
                 }
                 }else{
                     throw new Exception("cant update your account");
                 }
             }else{
                 throw new Exception("invalid image format");
             }
           }else{
            $sql3="UPDATE account SET username=?, password=? where user_id=?";
            $stmt3=mysqli_prepare($conn,$sql3);
            mysqli_stmt_bind_param($stmt3,'ssi',$username,$password,$_SESSION['update_id']);
            mysqli_stmt_execute($stmt3);
            if(mysqli_stmt_affected_rows($stmt3)>=0){
                mysqli_commit($conn);
                header("location:index.php");
                exit;
            }else{
                throw new Exception("error2");
            }

           }
        } else{
            throw new Exception("user information update failed in the database");
        }
      
    
}catch(Exception $e){
mysqli_rollback($conn);
print "encountered an error:".$e->getMessage();
}
}


}

?>