<?php 
include("../includes/config.php");
include('../structure/Header.html');
include('../structure/sidebar.html');

if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin' && isset($_SESSION['role'])){

    $sql="SELECT *  FROM product left join stocks using(product_id) left join
    product_category pc using(product_id) left join category c on c.category_id=pc.category_id where product_id={$_GET['id']}";
   $result=mysqli_query($conn,$sql);
   $row= mysqli_fetch_assoc($result);
?>

<style>
body{
    padding: 0%;
    margin: 0%;
    
}

body .container{
    grid-area: 3/5/7/15;
height: 520px;
width: 950px;
box-shadow:  0 0 10px rgba(0, 0, 0, 0.5);
border-radius: 8px;
padding: 40px;

}
form{
    display: flex;
    gap: 20px;
    justify-content: space-evenly;
    align-items: center;
    flex-direction: column;
}
.content{
    display: flex;
    justify-content: space-evenly;
    gap: 20px;
}
.button{
    width: 100%;
}

img{
    height: 250px;
    width: 260px;
    box-shadow:  0 0 10px rgba(0, 0, 0, 0.3);
    border-radius: 5px;
}
.btn{
    width: 100%;
    border-color: orangered;
    color: orangered;
    background-color: #fff;
}
.btn:hover{
    border-color: orangered;
    color: #fff;
    background-color: orangered;
}
</style>
<body> 
   <center> <h2>Create New Item</h2></center>
    <div class="container">
        
        <form action="update.php" method="post" enctype="multipart/form-data">
        <div class="content">
            <div class="div3">
                <img src="uploads/<?php echo $row['product_img'] ?>" alt="">
                <input type="hidden" name="current" value="<?php echo $row['product_img'] ?>">
                <div class="product-appearance">
                    <br>
                    <label for="" class="form-label">Product Appearance</label>
                    <input type="file" name="file" class="form-control">
                </div>
            </div>
        <div class="div1">
                <div class="product_name">
                    <label for="" class="form-label">Product Name</label>
                    <input type="text" name="product_name" class="form-control" value="<?php echo $row['product_name'] ?>" required>
                </div>
                <br>
                <div class="price">
                    <label for="" class="form-label">Price</label>
                     <input type="number" class="form-control" name="price" value="<?php echo $row['price'] ?>" required>
                </div>
                <br>
                <div class="description">
                    <label for="" class="form-label">Product Description</label>
                   <textarea class="form-control" name="description" style="border-radius: 5px;" id="" rows="5" cols="50"><?php echo $row['product_description'] ?></textarea>
                </div>  
                <br>
            </div>
            <div class="div2">
            <div class="category">
                    <label for="" class="form-label">Category</label>
                    <select name="category" id="" class="form-select">
                        <?php 
                        $current_category=$row['category_id'];
                        $query="SELECT * FROM category";
                        $result1=mysqli_query($conn,$query);
                        while($row1= mysqli_fetch_assoc($result1)){
                            if($row1['category_id']==$current_category){
                                print "<option value='{$row1['category_id']}' selected>{$row1['category_name']}</option>";
                            }else{
                                print "<option value='{$row1['category_id']}'>{$row1['category_name']}</option>";
                            }
                        }

                        ?>
                    </select>
                </div>
                <br>
                <div class="stocks">
                    <label for="" class="form-label">Stocks</label>
                    <input type="number" name="stocks" value="<?php echo $row['stock'] ?>" class="form-control" required>
                </div>
            </div>
            </div>
            <div class="button">
                    <button type="submit" class="btn btn-primary" name='update' value="<?php echo $row['product_id'] ?>">Update</button>
                </div>
            </form> 
           

    </div>
</body>


<?php 
}else{
    $_SESSION['unauthenticated_error']="suspicious_access";
    header("location:http:/Tech-IT/Administrator/customer/index.php");
    exit;
  }


?>