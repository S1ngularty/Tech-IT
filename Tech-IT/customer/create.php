<?php 
include("../includes/config.php");


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTDNEpUTHQoQUJMHLrErGJyHg89uy71MyuH5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
    <div class="container">
        <form action="store.php" method="post" enctype="multipart/form-data">
            <div class="div1">
                <div class="firstname">
                    <label for="" class="form-label">First Name</label>
                    <input type="text" name="firstname" class="form-control" required>
                </div>
                <div class="lastname">
                    <label for="" class="form-label">Last Name</label>
                     <input type="text" class="form-control" name="firstname" required>
                </div>
                <div class="age">
                    <label for="" class="form-label">Age</label>
                    <input type="number" name="age" class="form-control">
                </div>
                <div class="gender">
                    <label for="" class="form-label">Gender</label>
                    <select name="gender_select" id="">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="contact">
                    <label for="" class="form-label">Contacts</label>
                    <input type="tel" name="contact" class="form-control" required>
                </div>
            </div>
            <div class="div2">
            <div class="username">
                    <label for="" class="form-label">Username</label>
                     <input type="email" class="form-control" name="username" placeholder="User@example.com" required>
                </div>
                <div class="password">
                    <label for="" class="form-label">Password</label>
                     <input type="password  " class="form-control" name="password" required>
                </div>
                <div class="role">
                    <label for="" class="form-label">Role</label>
                    <select name="role_select" id="">
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>