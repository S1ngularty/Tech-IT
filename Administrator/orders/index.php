<?php 
include("../includes/config.php");
include('../structure/Header.html');
include('../structure/sidebar.html');

if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin' && isset($_SESSION['role'])){
   $sort;


$sql="SELECT * FROM orders inner join account a USING(account_id)";
$result=mysqli_query($conn,$sql);

if(mysqli_affected_rows($conn)>0){
    print "<body> <div class='container'>
     <div class='acton' id='action_form'>
   
    </div>
   
    <div class='table_div'>
  <table width='50%' cellpadding='6' class='table'>
    <tr>
    <th>Account</th>
    <th>Amount</th>
    <th>Ordered Date</th>
    <th>Order Status</th>
    </tr>";
   
    while($row= mysqli_fetch_assoc($result)){
        $status=($row['status']==='pending') ? 'selected' : '';
        $status2=($row['status']==='shipped') ? 'selected' : '';
print "<tr>
<td>{$row['email']}</td>
<td>{$row['total_amount']}</td>
<td>{$row['orderDate']}</td>
<td> <form action=update.php method='post'>
<input type='hidden' name='ID' value='{$row['order_id']}'>
    <select class='form-select' name='stat' onchange='this.form.submit()'>
    <option value='pending' $status >Pending</option>
    <option value='shipped'$status2 >Shipped</option>
    </select>
    </form></td>
</tr>";


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
        grid-area: 1/2/7/10;
        padding: 30px;
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



}else{
  $_SESSION['unauthenticated_error']="suspicious_access";
  header("location:http:/Tech-IT/Administrator/customer/index.php");
  exit;
}


?>