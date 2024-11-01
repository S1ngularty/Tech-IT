<?php 
include("../includes/config.php");
include('../structure/Header.html');
include('../structure/sidebar.html');

if(isset($_SESSION['user_id'])){
   $sort;


$sql="SELECT *  FROM product left join stocks using(product_id) left join
 product_category pc using(product_id) left join category c on c.category_id=pc.category_id $sort";
$result=mysqli_query($conn,$sql);

if(mysqli_affected_rows($conn)>0){
    print "<body> <div class='container'>
     <div class='acton' id='action_form'>
    <form action=index.php method='post'>
    <label class='form-label'>Sort</label>
    <select class='form-select' name='sort' onchange='this.form.submit()'>
    <option value='order by product_name ASC'>Acending</option>
    <option value='order by product_name DESC'>Descending</option>
    </select>
    </form>
    </div>
    <div class='create'>
  <button type='submit' name='delete' value='delete' class='btn btn-primary' ><a href='create.php' style='color:white; text-decoration:none;'>Create New</a></button>
    </div>
    <div class='table_div'>
  <table width='50%' cellpadding='6' class='table'>
    <tr>
    <th>Product ID</th>
    <th>Product Name</th>
    <th>Price</th>
    <th>Category</th>
    <th>Date Added</th>
    <th>Stock</th>
    <th>Action</th>
    </tr>";
    while($row= mysqli_fetch_assoc($result)){
print "<tr>
<td>{$row['product_id']}</td>
<td>{$row['product_name']}</td>
<td>{$row['price']}</td>
<td>{$row['category_name']}</td>
<td>{$row['date_added']}</td>
<td>{$row['stock']}</td>
<td><button type='submit' name='edit' value='edit' class='btn btn-primary'><a href='edit.php?id={$row['product_id']}' style='color:white; text-decoration:none;'>Edit</a></button>
<button type='submit' name='delete' value='delete' class='btn btn-danger' ><a href='delete.php?id={$row['product_id']}&img={$row['product_img']}' style='color:white; text-decoration:none;'>Delete</a></button></td>";


    }
    print "</table></div></div></body>";
}
?>
<style>
      body .container{
   grid-area: 2/5/7/15;
   display: grid;
   gap: 10px;
   padding: 0%;
grid-template-columns: 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px;
grid-template-rows: 100px 100px 100px 100px 100px 50px;
      }
      .create{
        grid-area: 1/8/2/10;
        display: flex;
        align-items: end;
        padding-bottom: 30px;
      }

      .action,#action_form{
        grid-area: 1/1/1/3;
        display: flex;
        align-items: end;
      }

      .table_div{
        grid-area: 2/1/7/10;
        padding: 30px;
        border: thin solid;
        border-radius: 10px;
      }

      tr{
        text-align: center;
      }

      .select_div{
        grid-area:1/2/2/3 ;
        display: flex;
        justify-content:start ;
        flex-direction: column;
   
      }

      #action_label{
        grid-area:1/1/2/2 ;
        display: flex;
        justify-content:start ;
      }

      form{
        width: 100%;
        height: 100%;
      }
</style>

<?php 



}

?>