<?php  
include('includes/config.php');
include('structure/Header.html');
include('structure/sidebar.html');
if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin' && isset($_SESSION['role'])){
echo $_SESSION['user_id'];
$sql1="SELECT * FROM user  inner join account using(user_id) order by user_id DESC LIMIT 1";
$result1=mysqli_query($conn,$sql1);
if(mysqli_num_rows($result1)>0){
    $row1=mysqli_fetch_assoc($result1);
}
$sql2="SELECT * FROM product order by product_id DESC LIMIT 1";
$result2=mysqli_query($conn,$sql2);
if(mysqli_num_rows($result2)>0){
    $row2=mysqli_fetch_assoc($result2);
}
$sql3="SELECT category_name FROM  category order by category_name DESC LIMIT 3";
$result3=mysqli_query($conn,$sql3);
if(mysqli_num_rows($result3)>0){
    $row3=mysqli_fetch_assoc($result3);
}
// $sql4="SELECT * FROM orders  order by review_id DESC LIMIT 1";
// $result4=mysqli_query($conn,$sql4);
// if(mysqli_num_rows($result4)>0){
//     $row4=mysqli_fetch_assoc($result4);
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
   body .container{
   grid-area: 2/5/7/15;
   display: grid;
   gap: 10px;
   padding: 0%;
grid-template-columns: 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px;
grid-template-rows: 100px 100px 150px 100px 50px;
    }
    body .container #box{
        border: blue solid thin;
        margin: 5px;
        border-radius: 5px;
        padding: 10px;
    }
    body .container .box1{
        grid-area: 1/1/3/5;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    body .container .box2{
        grid-area: 1/5/3/9;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
     body .container .box4{
        grid-area: 3/5/5/9;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    body .container .box3{
        grid-area: 3/1/5/5;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    body .container #box .view{
        height: 80px;
        justify-content: end;
        display: flex;
        align-items: end;
     
    }
    body .container #box .content{
        padding-top: 5px;
    }
    
</style>
<body>
<div class="container">
    <div class="box1" id="box">
        <div class="content">
        <strong>New Account</strong><br><hr>
        <strong>Name: </strong><?php echo $row1['first_name']." ".$row1['last_name']; ?><br>
        <strong>Age: </strong><?php echo $row1['age'] ?><br>
        <strong>Phone Number: </strong><?php echo $row1['contacts'] ?><br>
        
    </div>
   <div class="view"> <a href="<?php print "http:/Tech-IT/Administrator/customer/view.php?id={$row1['account_id']}"; ?>" class="btn btn-primary">View More</a></div>
</div>
    <div id="box" class="box2">
    <div class="content">
    <strong>New Product</strong><br><hr>
        <strong>Product Name: </strong><?php echo $row2['product_name']; ?><br>
        <strong>Price: </strong><?php echo $row2['price'] ?><br>
        <strong>Date Added: </strong><?php echo $row2['date_added'] ?><br>
    </div>
   <div class="view"> <a href="<?php print "http:/Tech-IT/Administrator/Product/edit.php?id={$row2['product_id']}"; ?>" class="btn btn-primary ">View More</a></div>
    </div>
    <div id="box" class="box3">
    <div class="content">
    <strong>New Category</strong><br><hr>
        <?php 
        $c=1;
        foreach($row3 as $key){
            print "<strong>Category $c</strong>".$key."<br>";
            $c++;
        }
        ?>
    </div>
   <div class="view"> <a href="<?php print "http:/Tech-IT/Administrator/Product/edit.php?id={$row2['product_id']}"; ?>" class="btn btn-primary ">View More</a></div>
    </div>
    <div id="box" class="box4">
    <div class="content">
        <p><strong>Database</strong>- A systematically organized collection of data stored electronically,
         designed to allow efficient retrieval, management, and updating.
</p>
    </div>
   <div class="view"> <button class="btn btn-primary">View More</button></div>
    </div>
</div>  
</body>
</html>
<?php 
}else{
    $_SESSION['unauthenticated_error']="suspicious_access";
    header("location:http:/Tech-IT/Administrator/customer/login.php");
    exit;
}
?>