<?php 
include("../includes/config.php");
include('../structure/Header.html');
include('../structure/sidebar.html');

if(isset($_SESSION['user_id'])){
$sql="SELECT *  FROM account inner join user using(user_id)";
$result=mysqli_query($conn,$sql);

// if(isset($_POST['action_btn']) && $_POST['action']=='delete'){
//   header("location:delete.php?id={$_POST['userID']}");
//   exit;
// }elseif(isset($_POST['action_btn']) && $_POST['action']=='edit'){
//   header("location:edit.php");
//   exit;
// }if(isset($_POST['action_btn']) && $_POST['action']=='view'){
//   header("location:view.php");
//   exit;
// }


if(mysqli_affected_rows($conn)>0){
    print "<body> <div class='container'> <div class='table_div'>
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
<td>{$row['account_id']}</td>
<td>{$row['first_name']} &nbsp {$row['last_name']}</td>
<td><a href='view.php?id={$row['account_id']}' style='text-decoration:none;'>{$row['username']}<a></td>
<td><form action='update.php?ID={$row['account_id']}' method='post'><input type='radio' ".($row['role']=='admin'? 'checked' : '')." name='role' value='admin' onclick='this.form.submit()'><label class=='form-control'>Admin</label>
<input type='radio'  name='role' value='user'".($row['role']=='user'? 'checked' : '')." onclick='this.form.submit()'  ><label class=='form-control'>User</label></form></td>
<td><button type='submit' name='edit' value='edit' class='btn btn-primary'><a href='edit.php?id={$row['user_id']}' style='color:white; text-decoration:none;'>Edit</a></button>
<button type='submit' name='delete' value='delete' class='btn btn-danger' ><a href='delete.php?id={$row['user_id']}' style='color:white; text-decoration:none;'>Delete</a></button></td>
<input type ='hidden' name='IDs[]' value='{$row['account_id']}'></tr>";

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