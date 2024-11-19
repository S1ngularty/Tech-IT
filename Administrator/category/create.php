<?php 
if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin' && isset($_SESSION['role'])){
 print "<div id='pop_create' class='popup'>
 <div class='popup-content'>
     <a href='#' class='close-button' style='padding-bottom:10px; text-decoration:none;'>&times;</a>
     <br>
     <form action='store.php' method='post'>
         <input type='text' name='create' class='form-control' value='' placeholder='Create Category Name'>
         <input type='hidden' name='category_id' value=''>
         <br>
         <input type='submit' value='Create' class='btn btn-primary' style='width:100%;'>
     </form>
 </div>
</div>";

}else{
    $_SESSION['unauthenticated_error']="suspicious_access";
    header("location:http:/Tech-IT/Administrator/customer/index.php");
    exit;
  }


?>