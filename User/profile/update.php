<?php 
include("../../administrator/includes/config.php");

if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'user' && isset($_SESSION['role'])){

if(isset($_POST['update'])){
    echo $_FILES['file']['error'];
    echo $UID= $_SESSION['update_id'];
    echo $user_id=$_POST['user_id'];
    echo $fname=trim(ucwords($_POST['firstname']));
    echo $lname=trim(ucwords($_POST['lastname']));
    echo $age=trim($_POST['age']);
    echo $gender=trim($_POST['gender']);    
    echo $contact=trim($_POST['contact']);
    echo $username=trim($_POST['username']);
    echo $new_pass=trim($_POST['new_password']);
    echo $confirm_pass=trim($_POST['confirm_password']);
    echo $filename=$_FILES['file']['name'];
    $file_temp=$_FILES['file']['tmp_name'];
    $allowed=array('jpg','jpeg','png');
    $file_delete=trim($_POST['current']);
 echo $current_path="../../administrator/customer/uploads/".((!empty($file_delete)=== true) ? $file_delete : 'qweqweqwe' );
 if (
    preg_match("/^[a-zA-Z\s]/", $fname) && preg_match("/^[a-zA-Z\s]/", $lname) &&
    ($age >= 12 && $age <= 120) && strlen($contact)==11 &&
    preg_match("/[a-zA-Z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,6}/", $username) && $new_pass === $confirm_pass){
 try{
    $pswd=sha1($new_pass);
        mysqli_begin_transaction($conn);    
        $sql2="UPDATE user SET first_name=?, last_name=?, age=?, sex=?, contacts=? where user_id=?";
        $stmt2=mysqli_prepare($conn,$sql2);
        mysqli_stmt_bind_param($stmt2,'ssissi',$fname,$lname,$age,$gender,$contact,$user_id);
        mysqli_stmt_execute($stmt2);
        
        if(mysqli_stmt_affected_rows($stmt2)>=0){
           if($_FILES['file']['error']==0){
            $file_ext=explode('.',$filename);
            echo $extension=strtolower(end($file_ext));
             
             if(in_array($extension,$allowed)){
                 echo $newfile=uniqid('',true).".".$extension;
                 $location="../../administrator/customer/uploads/".$newfile;
                 $sql3="UPDATE account SET username=?,password=?, profile_img=? where account_id=?";
                 $stmt3=mysqli_prepare($conn,$sql3);
                 mysqli_stmt_bind_param($stmt3,'sssi',$username,$pswd,$newfile,$UID);
                 mysqli_stmt_execute($stmt3);
 
                 if(mysqli_stmt_affected_rows($stmt3)>0){
                 if(file_exists($current_path)){
                     if(unlink($current_path)){
                      if(move_uploaded_file($file_temp,$location)){
                       mysqli_commit($conn);
                       header("location:edit.php");
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
                         header("location:edit.php");
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
            $sql3="UPDATE account SET username=?, password=? where account_id=?";
            $stmt3=mysqli_prepare($conn,$sql3);
            mysqli_stmt_bind_param($stmt3,'ssi',$username,$pswd,$UID);
            mysqli_stmt_execute($stmt3);
            if(mysqli_stmt_affected_rows($stmt3)>=0){
                mysqli_commit($conn);
                // header("location:edit.php");
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
    }else{
        print "Please check you details/password";
    }
}


}else{
    $_SESSION['unauthenticated_error']="suspicious_access";
    header("location:http:/Tech-IT/Administrator/customer/index.php");
    exit;
  }

?>