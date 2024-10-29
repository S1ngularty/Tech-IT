<?php 
include("../includes/config.php");
include('../structure/Header.html');
include('../structure/sidebar.html');

if(isset($_SESSION['user_id'])){
$sql="SELECT *  FROM account inner join user using(user_id)";
$result=mysqli_query($conn,$sql);

if(isset($_POST['action'])){ 
  $action=$_POST['action'];
  print "<button class='btn btn-primary' name='account_action' value='$action'>$action</button>";
}elseif(isset($_POST['action']) && $_POST['action']==='role' ){
  print "<input type='radio' name='admin_radio' value='admin' onclick='this.form.submit()'><input type='radio' name='user_radio' value='user' onclick='this.form.submit()'>";
}

else{
  $action='view';
  print "<button class='btn btn-primary' name='account_action' value='$action'>$action</button>";
}

if(mysqli_affected_rows($conn)>0){
    print "<body> <div class='container'> <div class='table_div'>  <form action='edit.php' method='post'>
    <label for='action' id='action_label'>Action:</label>
    <div class='select_div'>
    <select id='action' name='action' onchange='this.form.submit()' class='form-control'>
    <option value='view'".($action==='view' ? 'selected' :'')." >View</option>
    <option value='edit'".($action==='edit' ? 'selected' :'')." >Edit</option>
    <option value='role'".($action==='role' ? 'selected' :'').">Role</option>
    <option value='delete'".($action==='delete' ? 'selected' :'').">Delete</option>
    </select>
    </div>
  <table width='50%' cellpadding='6' class='table'>
    <tr>
    <th>Customer ID</th>
    <th>Full Name</th>
    <th>Account</th>
    <th>Role</th>
    <th>Action</th>
    </tr>";
    while($row= mysqli_fetch_assoc($result)){
print "<tr>
<td>{$row['account_id']}</td><td>{$row['first_name']}</td><td>{$row['username']}</td>
<td>{$row['role']}</td><td><button class='btn btn-primary' name='account_action' value='$action'>$action</button></td>";
    }
    print "</table></form></div></div></body>";
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

      .table_div{
        grid-area: 2/1/5/9;
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