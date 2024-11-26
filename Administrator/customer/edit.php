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
height: 550px;
width: 950px;
border: solid thin;
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
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
}

.modal:target {
    display: flex;
}

.modal-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    width: 40%;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    position: relative;
}

.close-btn {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 28px;
    text-decoration: none;
    color: #aaa;
}

.close-btn:hover {
    color: black;
}

.form-group {
    margin-bottom: 15px;
    text-align: left;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.btn-primary {
    background-color: #007bff;
    border: none;
    color: white;
    padding: 10px 15px;
    border-radius: 4px;
    cursor: pointer;
}

.btn-primary:hover {
    background-color: #0056b3;
    .modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
}
}

.modal:target {
    display: flex;
}


.modal-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    width: 40%;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    position: relative;
}


.close-btn {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 28px;
    text-decoration: none;
    color: #aaa;
}

.close-btn:hover {
    color: black;
}

.form-group {
    margin-bottom: 15px;
    text-align: left;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.btn-primary {
    background-color: #007bff;
    border: none;
    color: white;
    padding: 10px 15px;
    border-radius: 4px;
    cursor: pointer;
}

.btn-primary:hover {
    background-color: #0056b3;
}

</style>
<body> 
   <center> <h2>Update Account</h2></center>
    <div class="container">
       <?php include("../alert.php"); ?>
       <form action="update.php" method="post" enctype="multipart/form-data">
    <div class="content">
        <div class="div3">
            <img src="uploads/<?php echo $row['profile_img'] ?>" alt="">
            <input type="hidden" name="current" value="<?php echo $row['profile_img'] ?>">
            <input type="hidden" name="user_id" value="<?php echo $row['user_id'] ?>">
            <div class="profile">
                <label for="" class="form-label">Profile</label>
                <input type="file" name="file" class="form-control">
            </div>
        </div>
        <div class="div1">
            <div class="firstname">
                <input type="hidden" name="ID" value="<?php echo $_GET['id']; ?>">
                <label for="" class="form-label">First Name</label>
                <input type="text" name="firstname" class="form-control" value="<?php echo $row['first_name'] ?>">
            </div>
            <br>
            <div class="lastname">
                <label for="" class="form-label">Last Name</label>
                <input type="text" class="form-control" name="lastname" value="<?php echo $row['last_name'] ?>">
            </div>
            <br>
            <div class="age">
                <label for="" class="form-label">Age</label>
                <input type="number" name="age" value="<?php echo $row['age'] ?>" class="form-control">
            </div>
            <br>
            <div class="gender">
                <label for="" class="form-label">Gender</label>
                <select name="gender" id="" class="form-select">
                    <option value="male" <?php echo ($row['sex'] == 'Male' ? 'selected' : ''); ?>>Male</option>
                    <option value="female" <?php echo ($row['sex'] == 'Female' ? 'selected' : ''); ?>>Female</option>
                </select>
            </div>
            <br>
        </div>
        <div class="div2">
            <div class="username">
                <label for="" class="form-label">Username</label>
                <input type="email" class="form-control" name="username" value="<?php echo $row['email'] ?>" placeholder="User@example.com">
            </div>
            <br>
            <div class="role">
                <label for="" class="form-label">Role</label>
                <input type="text" class="form-control" value="<?php echo $row['role'] ?>" disabled>
            </div>
            <br>
            <div class="contact">
                <label for="" class="form-label">Contacts</label>
                <input type="text" name="contact" value="<?php echo $row['contacts'] ?>" class="form-control">
            </div>
            <br>
            <div class="password">
                <a href="#passwordModal" class="btn btn-secondary">Change Password</a>
            </div>
        </div>
    </div>
    <div class="btn">
        <button type="submit" class="btn btn-primary" name="update" value="update">Update</button>
    </div>
</form>

<div id="passwordModal" class="modal">
    <div class="modal-content">
        <a href="#" class="close-btn">&times;</a>
        <h3>Change Password</h3>
        <form action="update.php" method="post">
            <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
            <input type="hidden" name="current_password" value="<?php echo $row['password']; ?>">
            <div class="form-group">
                <label for="oldPassword">Old Password</label>
                <input type="password" id="oldPassword" name="old_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="newPassword">New Password</label>
                <input type="password" id="newPassword" name="new_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" name="update_password" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
</body>


<?php 
}else{
    $_SESSION['unauthenticated_error']="suspicious_access";
    header("location:http:/Tech-IT/Administrator/customer/index.php");
    exit;
  }


?>