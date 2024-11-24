<?php 
// session_start(); // Ensure session is started
include("../../administrator/includes/config.php");

if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'user') {
    $account_id = $_SESSION['user_id'];

    // Use prepared statements to prevent SQL injection
    $sql1 = "SELECT * FROM user INNER JOIN account USING(user_id) WHERE account_id = ?";
    $stmt = $conn->prepare($sql1);
    $stmt->bind_param("i", $account_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch associative array
    if ($row = $result->fetch_assoc()) {
        $_SESSION['update_id'] = $account_id; // Store in session
    } else {
        echo "No user found.";
        exit;
    }
} else {
    $_SESSION['unauthenticated_error'] = "suspicious_access";
    header("Location: http://Tech-IT/Administrator/customer/index.php");
    exit;
}
?>
<style>
/* body{
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
} */
</style>
<body> 
   <center> <h2>Update Account</h2></center>
    <div class="container">
        
        <form action="update.php" method="post" enctype="multipart/form-data">
        <div class="content">
            <div class="div3">
                <img src="uploads/<?php echo $row['profile_img'] ?>" alt="">
                <input type="hidden" name="current" value="<?php echo $row['profile_img'] ?>">
                <div class="profile">
                    <label for="" class="form-label">Profile</label>
                    <input type="file" name="file" class="form-control">
                </div>
            </div>
        <div class="div1">
                <div class="firstname">
                    <label for="" class="form-label">First Name</label>
                    <input type="text" name="firstname" class="form-control" value="<?php echo $row['first_name'] ?>" required>
                </div>
                <br>
                <div class="lastname">
                    <label for="" class="form-label">Last Name</label>
                     <input type="text" class="form-control" name="lastname" value="<?php echo $row['last_name'] ?>" required>
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
                        <option value="male" <?php echo ($row['sex']=='Male' ? 'selected': ''); ?> >Male</option>
                        <option value="female" <?php echo ($row['sex']=='Female' ? 'selected': ''); ?>>Female</option>
                    </select>
                </div>
                <br>
            </div>
            <div class="div2">
            <div class="username">
                    <label for="" class="form-label">Username</label>
                     <input type="email" class="form-control" name="username" value="<?php echo $row['username'] ?>" placeholder="User@example.com" required>
                </div>
                <br>
                <div class="contact">
                    <label for="" class="form-label">Contacts</label>
                    <input type="tel" name="contact" value="<?php echo $row['contacts']?>" class="form-control" required>
                </div>
            </div>
            </div>
            <div class="btn">
                    <button type="submit" class="btn btn-primary" name='update' value="update">Update</button>
                </div>
            </form> 
           

    </div>
</body>


</html>