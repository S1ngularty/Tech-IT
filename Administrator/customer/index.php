<?php 
include("../includes/config.php");
include('../structure/Header.html');
include('../structure/sidebar.html');

if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin' && isset($_SESSION['role'])){
    $sql="SELECT * FROM account INNER JOIN user USING(user_id)";
    $result=mysqli_query($conn,$sql);

    if(mysqli_affected_rows($conn)>0){
        print "<body> <div class='container'> 
            <div class='table_div'>
                <table width='50%' cellpadding='6' class='table'>
                    <tr>
                        <th>Customer ID</th>
                        <th>Full Name</th>
                        <th>Account</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>";

        while($row= mysqli_fetch_assoc($result)){
            $status = ($row['account_status'] != 'activate') ? 'activate' : 'deactivate';
            $checked = ($row['account_status'] != 'activate') ? '' : 'checked';
            $statusText = ($row['account_status'] == 'activate') ? 'Activate' : 'Deactivate';
            
            print "<tr>
                <td>{$row['account_id']}</td>
                <td>{$row['first_name']} &nbsp {$row['last_name']}</td>
                <td><a href='view.php?id={$row['account_id']}' style='text-decoration:none;'>{$row['email']}</a></td>
<td>
    <form action='update.php?ID={$row['account_id']}' method='post' class='role-form'>
        <label class='role-label'>
            <input type='radio' name='role' value='admin' 
                ".(($row['role'] == 'admin') ? 'checked' : '')." 
                onclick='this.form.submit()' ".(($status=='activate')? 'disabled' :'').">
            <span class='role-text'>Admin</span>
        </label>
        <label class='role-label'>
            <input type='radio' name='role' value='user' 
                ".(($row['role'] == 'user') ? 'checked' : '')." 
                onclick='this.form.submit()' ".(($status=='activate')? 'disabled' :'').">
            <span class='role-text'>User</span>
        </label>
    </form>
</td>

                <td class='action-icons'>
                    <!-- Edit Icon -->
                    <a href='edit.php?id={$row['user_id']}' title='Edit'>
                        <i class='fas fa-edit edit-icon'></i>
                    </a>
                    
                    <!-- Delete Icon -->
                    <a href='delete.php?id={$row['user_id']}' title='Delete'>
                        <i class='fas fa-trash-alt delete-icon'></i>
                    </a>

                    <!-- Activate / Deactivate Toggle -->
                    <form action='update.php?id={$row['account_id']}&stat={$status}' method='post'>
                        <div class='status-label'>{$statusText}</div>
                        <label class='switch'>
                            <input type='checkbox' name='stat' value='{$status}' $checked onchange='this.form.submit()'>
                            <span class='slider round'></span>
                        </label>
                    </form>
                </td>
            </tr>";
        }
        print "</table></div></div></body>";
    }
?>
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<style>
    body .container {
        grid-area: 2/3/7/16;
        display: grid;
        gap: 10px;
        padding: 0%;
        grid-template-columns: repeat(15, 1fr);
        grid-template-rows: repeat(5, 100px);
    }
    .table_div {
        grid-area: 2/2/5/13;
    }
    tr {
        text-align: center;
    }
    .action-icons {
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        gap: 20px;
    }
    .action-icons a {
        text-decoration: none;
        color: inherit;
    }
    .action-icons i {
        font-size: 18px;
        cursor: pointer;
        transition: transform 0.3s ease, color 0.3s ease;
    }
    .action-icons i:hover {
        transform: scale(1.1);
        color: #007bff;
    }
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 25px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 50px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 15px;
        width: 15px;
        border-radius: 50px;
        left: 5px;
        bottom: 5px;
        background-color: white;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #4CAF50;
    }

    input:checked + .slider:before {
        transform: translateX(25px);
    }

    .slider.round {
        border-radius: 50px;
    }

    .status-label {
        font-size: 14px;
        font-weight: bold;
        margin-right: 10px;
    }

    .delete-icon {
        font-size: 20px;
        color: #dc3545; 
        transition: color 0.3s ease;
    }

    .edit-icon:hover {
        color: #28a745;
    }

    .delete-icon:hover {
        color: #dc3545;
    }

.role-form {
    display: flex;
    justify-content: center;
    gap: 15px;
}

.role-label {
    display: flex;
    align-items: center;
    gap: 5px;
    cursor: pointer;
}

.role-label input {
    margin: 0;
}

.role-label input:checked + .role-text {
    font-weight: bold;
    color: #007bff;
}

.role-text {
    margin: 0;
    font-size: 14px;
}

</style>

<?php 
} else {
    $_SESSION['unauthenticated_error'] = "suspicious_access";
    header("location: login.php");
    exit;
}
?>
