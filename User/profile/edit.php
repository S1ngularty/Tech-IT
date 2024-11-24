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
/* General Styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f7fc;
}

.container {
    width: 60%;
    margin: 50px auto;
    padding: 30px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    color: #333;
    margin-bottom: 30px;
}

form {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: space-between;
}

.content {
    display: flex;
    gap: 30px;
    width: 100%;
}

/* Input and Label Styles */
input[type="text"], input[type="email"], input[type="number"], input[type="tel"], select, input[type="file"], input[type="password"] {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border-radius: 4px;
    border: 1px solid #ddd;
    box-sizing: border-box;
    font-size: 14px;
}

input[type="file"] {
    padding: 3px;
}

label {
    font-weight: bold;
    margin-bottom: 5px;
    font-size: 14px;
}

select {
    padding: 12px;
    font-size: 14px;
}

/* Profile Image Section */
.div3 {
    text-align: center;
    width: 25%;
}

.div3 img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    border: 2px solid #ddd;
    margin-bottom: 10px;
}

.div3 input[type="file"] {
    margin-top: 10px;
}

/* User Info Sections */
.div1, .div2 {
    width: 48%;
    padding: 20px;
}

.div1 {
    border-right: 1px solid #ddd;
}

/* Button Styling */
.btn {
    display: flex;  /* Using flex */
    justify-content: flex-end;  /* Align the button to the right */
    margin-top: 30px;
    position:relative;
    left: 400px;
}

.btn button {
    padding: 12px 25px;
    background-color: #28a745;
    border: none;
    color: white;
    font-size: 16px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn button:hover {
    background-color: #218838;
}
</style>

<body> 
   <center> <h2>Update Account</h2></center>
    <div class="container">
        
        <form action="update.php" method="post" enctype="multipart/form-data">
        <div class="content">
            <div class="div3">
                <img src="../../administrator/customer/uploads/<?php echo $row['profile_img'] ?>" alt="Profile Image">
                <input type="hidden" name="current" value="<?php echo $row['profile_img'] ?>">
                <input type="hidden" name="user_id" value="<?php echo $row['user_id'] ?>">
                <div class="profile">
                    <label for="file" class="form-label">Profile Image</label>
                    <input type="file" name="file" class="form-control">
                </div>
            </div>
        <div class="div1">
                <div class="firstname">
                    <label for="firstname" class="form-label">First Name</label>
                    <input type="text" name="firstname" class="form-control" value="<?php echo $row['first_name'] ?>" required>
                </div>
                <div class="lastname">
                    <label for="lastname" class="form-label">Last Name</label>
                     <input type="text" class="form-control" name="lastname" value="<?php echo $row['last_name'] ?>" required>
                </div>
                <div class="age">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" name="age" value="<?php echo $row['age'] ?>" class="form-control">
                </div>
                <div class="gender">
                    <label for="gender" class="form-label">Gender</label>
                    <select name="gender" id="gender" class="form-select">
                        <option value="male" <?php echo ($row['sex']=='Male' ? 'selected': ''); ?> >Male</option>
                        <option value="female" <?php echo ($row['sex']=='Female' ? 'selected': ''); ?>>Female</option>
                    </select>
                </div>
            </div>
            <div class="div2">
                <div class="username">
                    <label for="username" class="form-label">Username</label>
                     <input type="email" class="form-control" name="username" value="<?php echo $row['username'] ?>" placeholder="User@example.com" required>
                </div>
                <div class="contact">
                    <label for="contact" class="form-label">Contacts</label>
                    <input type="text" name="contact" value="<?php echo $row['contacts']?>" class="form-control" required>
                </div>
                <!-- Change Password Inputs -->
                <div class="password">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" name="new_password" class="form-control">
                </div>
                <div class="password">
                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                    <input type="password" name="confirm_password" class="form-control">
                </div>
            </div>
            </div>

            <div class="btn">
                <button type="submit" class="btn btn-primary" name="update" value="update">Update</button>
            </div>
        </form> 
    </div>
</body>
