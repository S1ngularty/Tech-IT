<?php 
include("../includes/config.php");
include('../structure/Header.html');
include('../structure/sidebar.html');
include('create.php');

if(isset($_SESSION['user_id'])){

    $sql="SELECT c.category_name, 
    COUNT(pc.product_id) AS category_count, 
    c.category_id FROM  category c LEFT JOIN product_category pc 
    ON c.category_id = pc.category_id GROUP BY  c.category_id HAVING 
    COUNT(pc.product_id) >= 0 ";
    $result = mysqli_query($conn, $sql);

    if(mysqli_affected_rows($conn) > 0){
        print "<body> <div class='container'>
        <div id='create-btn'>
         <a href='#pop_create'  class='btn btn-primary'>Create</a>
        </div>
            <div class='table_div'>
                <table width='50%' cellpadding='6' class='table'>
                    <tr>
                        <th>Category Name</th>
                        <th>Total Products</th>
                        <th>Action</th>
                    </tr>";

        while($row = mysqli_fetch_assoc($result)){
            print "<tr>
                <td>{$row['category_name']}</td>
                <td>{$row['category_count']}</td>
                <td>
                    <a href='#pop_edit_{$row['category_id']}' class='btn btn-primary'>Edit</a>
                    <button type='submit' class='btn btn-danger' name='delete' value='delete'><a href='delete.php?id={$row['category_id']}' style='color:#fff; text-decoration:none;'>Delete</a></button>
                </td>
            </tr>";

            // Popup for editing
            print "<div id='pop_edit_{$row['category_id']}' class='popup'>
                <div class='popup-content'>
                    <a href='#' class='close-button' style='padding-bottom:10px; text-decoration:none;'>&times;</a>
                    <br>
                    <form action='update.php' method='post'>
                        <input type='text' name='edit' class='form-control' value='{$row['category_name']}' placeholder='Edit Category Name'>
                        <input type='hidden' name='category_id' value='{$row['category_id']}'>
                        <br>
                        <input type='submit' value='Submit' class='btn btn-primary' style='width:100%;'>
                    </form>
                </div>
            </div>";
        }

        print "</table></div></div></body>";
    }
}
?>

<style>
    body .container {
        grid-area: 2/5/7/15;
        display: grid;
        gap: 10px;
        padding: 0;
        grid-template-columns: repeat(10, 100px);
        grid-template-rows: repeat(5, 100px);
    }

#create-btn{
    grid-area: 1/9/2/10;
    display: flex;
    align-items: end;
}

    .popup {
        display: none; /* Hidden by default */
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
    }

    .popup:target {
        display: flex; /* Show the popup when targeted */
    }

    .popup-content {
        background-color: white;
        padding: 20px;
        border-radius: 5px;
        text-align: center;
    }

    .close-button {
        cursor: pointer;
        font-size: 28px;
        float: right;
        margin-top: -10px;
    }

    .table_div {
        grid-area: 2/1/7/10;
        padding: 30px;
        border: thin solid;
        border-radius: 10px;
    }

    tr {
        text-align: center;
    }
</style>
