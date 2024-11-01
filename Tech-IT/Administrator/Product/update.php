<?php 
include("../includes/config.php");
if(isset($_POST['update'])){
   echo $name=$_POST['product_name'];
   echo $price=$_POST['price'];
   echo $description=$_POST['description'];
   echo $category=$_POST['category'];
   echo $stock=$_POST['stocks'];
   echo $filename=$_FILES['file']['name'];
   $file_temp=$_FILES['file']['tmp_name'];
   $allowed=array('jpg','jpeg','png');
 $current_path="uploads/".trim($_POST['current']);
 $file_ext=explode('.',$filename);
 echo $extension=strtolower(end($file_ext));

try{
    mysqli_begin_transaction($conn);
    $sql1;
    $stmt1;
    $execute;
    if ($_FILES['file']['error'] == 0) {
        if(in_array($extension,$allowed)){
            echo $newfile=uniqid('',true).".".$extension;
            $location="uploads/".$newfile;
        $sql1 = "UPDATE product SET product_name=?, price=?, product_description=?, product_img=? WHERE product_id=?";
        $stmt1 = mysqli_prepare($conn, $sql1);
        mysqli_stmt_bind_param($stmt1, 'sissi', $name, $price, $description, $newfile, $_POST['update']);
        if(mysqli_stmt_execute($stmt1)){
            if(file_exists($current_path)){
                if(unlink($current_path)){
                if(move_uploaded_file($file_temp,$location)){
                 echo   $execute=1;
                }else{
                    throw new Exception("failed to move the file (1)");
                }
            }else{
                throw new Exception("couldnt delete the file");
            }
            }else{
                if(move_uploaded_file($file_temp,$location)){
                    echo   $execute=1;
                   }else{
                    throw new Exception("failed to move the file (2)");
                } 
            }
        }else{
            throw new Exception("failed to execute the statement 1");
        }
    }else{
        throw new Exception("invalid image type");
    }
    } else {
        $sql1 = "UPDATE product SET product_name=?, price=?, product_description=? WHERE product_id=?";
        $stmt1 = mysqli_prepare($conn, $sql1);
        mysqli_stmt_bind_param($stmt1, 'sisi', $name, $price, $description, $_POST['update']);
        $execute=(mysqli_stmt_execute($stmt1)) ? 1 : 0;
    }

    if($execute==1){
        $sq2="UPDATE product_category SET category_id=? where product_id =? ";
        $stmt2=mysqli_prepare($conn,$sq2);
        mysqli_stmt_bind_param($stmt2,'ii',$category,$_POST['update']);
        if(mysqli_stmt_execute($stmt2)){
            $sql3="UPDATE stocks SET stock=? where product_id=?";
            $stmt3=mysqli_prepare($conn,$sql3);
            mysqli_stmt_bind_param($stmt3,'ii',$stock,$_POST['update']);
            if(mysqli_stmt_execute($stmt3)){
                mysqli_commit($conn);
                header("location:index.php");
                exit;
            }else{
                throw new Exception("failed to execute the statement 3");
            }
        }else{
            throw new Exception("failed to execute the statement 2");
        }
    }else{
        throw new Exception("the execute variable has value of false");
    }
}catch(Exception $e){
    mysqli_rollback($conn);
    print "encountered an error:" .$e->getMessage();
}

} 

?>