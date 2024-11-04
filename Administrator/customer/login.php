<?php 
include("../includes/config.php");

if(isset($_POST['login'])){
    $sql1="SELECT account_id, role FROM account where username=? && password=?";
    $stmt1=mysqli_prepare($conn,$sql1);
    mysqli_stmt_bind_param($stmt1,'ss',$_POST['username'],sha1($_POST['password']));
    $result=mysqli_stmt_execute($stmt1);
        mysqli_stmt_store_result($stmt1);
        mysqli_stmt_bind_result($stmt1,$ID,$role);
        if(mysqli_stmt_num_rows($stmt1)>0){
            mysqli_stmt_fetch($stmt1);
            $_SESSION['user_id']=$ID;
       if($role==='admin'){
        header("location:../index.php");
        exit;
       }
        } else  {
        print "account doesn't exist";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<style>
    body{
        padding:0%;
        margin: 0%;
        font-family: Arial, sans-serif;
    }
    .container{
        display:flex;
        justify-content: center;
        align-items: center;
        padding-top: 100px;
    }

    form{
        box-shadow:  0 0 10px rgba(0, 0, 0, 0.3);
        width: 400px;
        height: 450px;
        padding: 50px 30px;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        gap:20px;
    }

    button{
        width: 100%;
    }
    .label{
        text-align: center;
    }
    #create{
       text-align: center;
    }
</style>
<body>
    <div class="container">
  <form action="login.php" method="post" enctype="multipart/form-data">
    <div class="label">
        <h3>LOG IN</h3>
    </div>
<div id="username">
    <label for="username" class="form-label">Username</label>
    <input type="text" class="form-control" name="username" placeholder="User@example.com" required>
</div>
<div id="password">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" name="password" required>
</div>
<div id="login">
    <button class="btn btn-primary" name="login" value="access">Log In</button>
</div>
<div id="create">
   <p>Don't have an account?<a href="create.php">Create</a></p>
</div>
  </form>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>