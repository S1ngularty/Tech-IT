<?php 
include("../includes/config.php");

    print "<pre>";
    echo $fname=trim(ucwords($_POST['firstname']));
    echo $lname=trim(ucwords($_POST['lastname']));
    echo $age=trim($_POST['age']);
    echo $gender=trim($_POST['gender']);
    echo $contact=trim($_POST['contact']);
    echo $username=trim($_POST['username']);
    echo $password=trim(sha1($_POST['password']));
    echo $role=trim($_POST['role']);
    echo $filename=$_FILES['file']['name'];
  echo  $file_temp=$_FILES['file']['tmp_name'];
  echo  $_FILES['file']['error'];
    $allowed=array('jpg','jpeg','png');
print "</pre>";

    try{
    mysqli_begin_transaction($conn);
    $sql1="INSERT INTO user (first_name,last_name,age,sex,contacts)values(?,?,?,?,?)";
    $stmt1=mysqli_prepare($conn,$sql1);
    mysqli_stmt_bind_param($stmt1,'ssisi',$fname,$lname,$age,$gender,$contact);
mysqli_stmt_execute($stmt1);
echo $last_ID=mysqli_insert_id($conn);

if(mysqli_stmt_affected_rows($stmt1)>0){
    if( $_FILES['file']['error']==0){
    $file_ext=explode('.',$filename);
$extension=strtolower(end($file_ext));

if(in_array($extension,$allowed)){
    echo $newfile=uniqid('',true).".".$extension;
    $location="uploads/".$newfile;  

    $sql2="INSERT INTO account (user_id,username,password,role,profile_img)values(?,?,?,?,?)";
    $stmt2=mysqli_prepare($conn,$sql2);
    mysqli_stmt_bind_param($stmt2,'issss',$last_ID,$username,$password,$role,$newfile);
    mysqli_stmt_execute($stmt2);

    if(mysqli_stmt_affected_rows($stmt2)>0){
    if(move_uploaded_file($file_temp,$location)){
        mysqli_commit($conn);
        header("location:login.php");
        exit;
    }else{
        throw new Exception("failed to move the file");
    }
    }else{
        throw new Exception("failed to store your account in the database");
    }
}else{
   throw new Exception("invalid image format");
}
    }else{
        $sql2="INSERT INTO account (user_id,username,password,role)values(?,?,?,?)";
    $stmt2=mysqli_prepare($conn,$sql2);
    mysqli_stmt_bind_param($stmt2,'isss',$last_ID,$username,$password,$role);
    mysqli_stmt_execute($stmt2);

    if(mysqli_stmt_affected_rows($stmt2)>0){
        mysqli_commit($conn);
        header("location:login.php");
        exit;
    }else{
        throw new Exception("failed to store your account in the database");
    }
    }
}else{
    throw new Exception("failed to store in the database the statement 1");
}



    }catch(Exception $e){
    mysqli_rollback($conn);
    print "encountered an error:".$e->getMessage();
    }
    




?>