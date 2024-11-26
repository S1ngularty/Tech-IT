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
    display: flex;  
    justify-content: flex-end;  
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

/* Modal Styling */
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

.modal.active {
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const openModal = document.getElementById('openModal');
    const modal = document.getElementById('passwordModal');
    const closeModal = document.querySelector('.close-btn');

    openModal.addEventListener('click', function () {
        modal.classList.add('active');
    });

    closeModal.addEventListener('click', function () {
        modal.classList.remove('active');
    });
});
</script>

<body> 
   <center><h2>Update Account</h2></center>
   <div class="container">
        <form action="update.php" method="post" enctype="multipart/form-data">
            <div class="content">
                <!-- Profile Section -->
                <div class="div3">
                    <img src="../../administrator/customer/uploads/<?php echo $row['profile_img'] ?>" alt="Profile Image">
                    <input type="hidden" name="current" value="<?php echo $row['profile_img'] ?>">
                    <input type="hidden" name="user_id" value="<?php echo $row['user_id'] ?>">
                    <label for="file" class="form-label">Profile Image</label>
                    <input type="file" name="file" class="form-control">
                </div>
                
                <!-- Other User Info Sections -->
                <!-- Code here for other div1 and div2 details -->
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
                     <input type="email" class="form-control" name="username" value="<?php echo $row['email'] ?>" placeholder="User@example.com" required>
                </div>
                <div class="contact">
                    <label for="contact" class="form-label">Contacts</label>
                    <input type="text" name="contact" value="<?php echo $row['contacts']?>" class="form-control" required>
                </div>
                <!-- Change Password Modal Trigger -->
                <div class="password">
                    <button type="button" name="update_password" id="openModal" class="btn btn-secondary">Change Password</button>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="btn">
                <button type="submit" class="btn btn-primary" name="update">Update</button>
            </div>
        </form>

        <!-- Modal -->
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
                    <button type="submit" name="update_password`" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</body>
