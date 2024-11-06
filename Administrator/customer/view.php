<?php 
include("../includes/config.php");
include('../structure/Header.html');
include('../structure/sidebar.html');

if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin' && isset($_SESSION['role'])){
$sql1="SELECT * FROM user inner join account using(user_id) where user_id={$_GET['id']}";
$result=mysqli_query($conn,$sql1);
$row=mysqli_fetch_assoc($result);
$_SESSION['update_id']=$_GET['id'];
?>

<style>
body{
    padding: 0%;
    margin: 0%;
    
}

body .container{
    grid-area: 3/5/7/15;
height: 500px;
width: 950px;
box-shadow:  0 0 10px rgba(0, 0, 0, 0.4);
border-radius: 8px;
padding: 40px;

}
form{
    display: flex;
    gap: 20px;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}
.content{
    display: flex;
    justify-content: center;
    gap: 50px;
}
.btn{
    width: 100%;
}

img{
    height: 300px;
    width: 310px;
    border: solid thin;
    border-radius: 50%;
}
</style>
<body> 
   <center> <h2>Update Account</h2></center>
    <div class="container">
        
        <form action="update.php" method="post" enctype="multipart/form-data">
        <div class="content">
            <div class="div3">
                <img src="uploads/<?php echo $row['profile_img'] ?>" alt="">
            </div>
        <div class="div1">
                <div class="firstname">
                    <label for="" class="form-label">First Name</label>
                    <input type="text" name="firstname" class="form-control" value="<?php echo $row['first_name'] ?>" disabled>
                </div>
                <br>
                <div class="lastname">
                    <label for="" class="form-label">Last Name</label>
                     <input type="text" class="form-control" name="lastname" value="<?php echo $row['last_name'] ?>" disabled>
                </div>
                <br>
                <div class="age">
                    <label for="" class="form-label">Age</label>
                    <input type="number" name="age" value="<?php echo $row['age'] ?>" class="form-control" disabled>
                </div>
                <br>
                <div class="gender">
                    <label for="" class="form-label">Gender</label>
                    <select name="gender" id="" class="form-select" disabled>
                        <option value="male" <?php echo ($row['sex']=='Male' ? 'selected': ''); ?> >Male</option>
                        <option value="female" <?php echo ($row['sex']=='Female' ? 'selected': ''); ?>>Female</option>
                    </select>
                </div>
                <br>
            </div>
            <div class="div2">
            <div class="username">
                    <label for="" class="form-label">Username</label>
                     <input type="email" class="form-control" name="username" value="<?php echo $row['username'] ?>" disabled placeholder="User@example.com" required>
                </div>
                <br>
                <div class="role">
                    <label for="" class="form-label">Role</label>
                    <input type="text" class="form-control" value="<?php echo $row['role'] ?>" disabled>
                </div>
                <br>
                <div class="contact">
                    <label for="" class="form-label">Contacts</label>
                    <input type="tel" name="contact" value="<?php echo $row['contacts']?>" class="form-control" disabled>
                </div>
            </div>
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