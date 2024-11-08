<?php 
include("../includes/config.php");
if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin' && isset($_SESSION['role'])){
if(isset($_POST['create'])){

echo $item=$_POST['product_name'];
echo $price=$_POST['price'];
echo $description=$_POST['description'];
echo $categoy=$_POST['category'];
echo $stocks=$_POST['stocks'];
echo $filename=$_FILES['file']['name'];
    $file_temp=$_FILES['file']['tmp_name'];
    $allowed=array('jpg','jpeg','png');

    $file_ext=explode('.',$filename);
    $extension=strtolower(end($file_ext));
try{
    if(in_array($extension,$allowed)){
        echo $newfile=uniqid('',true).".".$extension;
        $location="uploads/".$newfile;  
    mysqli_begin_transaction($conn);
    $sql1="INSERT INTO product (product_name,price,product_description,product_img,date_added) values (?,?,?,?,now())";
    $stmt1=mysqli_prepare($conn,$sql1);
    mysqli_stmt_bind_param($stmt1,'siss',$item,$price,$description,$newfile);
    mysqli_stmt_execute($stmt1);
    $last_id= mysqli_insert_id($conn);
     
    if($last_id>0){
        $sql2="INSERT INTO stocks (product_id, stock) values (?,?)";
        $stmt2=mysqli_prepare($conn,$sql2);
        mysqli_stmt_bind_param($stmt2,'ii',$last_id,$stocks);
        
        $sql3="INSERT INTO product_category (category_id,product_id) values(?,?)";
        $stmt3=mysqli_prepare($conn,$sql3);
        mysqli_stmt_bind_param($stmt3,'ii',$categoy,$last_id);
        
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_execute($stmt3);

        if(mysqli_stmt_affected_rows($stmt2)>0 && mysqli_stmt_affected_rows($stmt3)>0){
        if(move_uploaded_file($file_temp,$location)){
            mysqli_commit($conn);
        header("location: index.php");
        exit;
        }
        }else{
            throw new exception ("failed to unsert in stocks product_category table");
        }


    }else{
        throw new Exception("couldnt get the last ID");
    }
}else{
    throw new Exception('invalid image type');
}
}catch(Exception $e){
    mysqli_rollback($conn);
    print "encountered an error". $e->getMessage();
}



}

}else{
    $_SESSION['unauthenticated_error']="suspicious_access";
    header("location:http:/Tech-IT/Administrator/customer/index.php");
    exit;
  }


?>