<?php 
include("../includes/config.php");
include('../structure/Header.html');
include('../structure/sidebar.html');

if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin' && isset($_SESSION['role'])) {
    $sort;

    $sql = "SELECT * FROM product 
            LEFT JOIN stocks USING (product_id) 
            LEFT JOIN product_category pc USING (product_id) 
            LEFT JOIN category c ON c.category_id = pc.category_id $sort";
    $result = mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        print "<body>
            <div class='container'>
                <div class='acton' id='action_form'>
                    <form action='index.php' method='post'>
                        <label class='form-label'>Sort</label>
                        <select class='form-select' name='sort' onchange='this.form.submit()'>
                            <option value='order by product_name ASC'>Ascending</option>
                            <option value='order by product_name DESC'>Descending</option>
                        </select>
                    </form>
                </div>
                <div class='create'>
                    <a href='create.php' class='create-link'>Create New</a>
                </div>
                <div class='table_div'>
                    <table width='50%' cellpadding='6' class='table'>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Date Added</th>
                            <th>Stock</th>
                            <th>Action</th>
                        </tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            print "<tr>
                <td>{$row['product_id']}</td>
                <td>{$row['product_name']}</td>
                <td>{$row['price']}</td>
                <td>{$row['category_name']}</td>
                <td>{$row['date_added']}</td>
                <td>{$row['stock']}</td>
                <td class='action-icons'>
                    <!-- Edit Icon -->
                    <a href='edit.php?id={$row['product_id']}' title='Edit'>
                        <i class='fas fa-edit'></i>
                    </a>
                    
                    <!-- Delete Icon -->
                    <a href='delete.php?id={$row['product_id']}&img={$row['product_img']}' title='Delete'>
                        <i class='fas fa-trash-alt delete-icon'></i>
                    </a>
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
        grid-area: 2/5/7/15;
        display: grid;
        gap: 10px;
        padding: 0%;
        grid-template-columns: repeat(10, 1fr);
        grid-template-rows: repeat(5, 100px) 50px;
    }

    .create {
        grid-area: 1/8/2/10;
        display: flex;
        align-items: flex-end;
        padding-bottom: 30px;
    }

    .create-link {
        text-decoration: none;
        font-weight: bold;
        font-size: 16px;
        padding: 10px 20px;
        background-color: #28a745; /* Bootstrap Green */
        color: white;
        border-radius: 5px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s, transform 0.2s;
    }

    .create-link:hover {
        background-color: #218838; /* Slightly darker green */
        transform: translateY(-2px);
    }

    .action, #action_form {
        grid-area: 1/1/1/3;
        display: flex;
        align-items: flex-end;
    }

    .table_div {
        grid-area: 2/1/7/10;
        padding: 30px;
        border: thin solid #ddd;
        border-radius: 10px;
        background-color: #f9f9f9;
    }

    tr {
        text-align: center;
    }

    .action-icons {
        display: flex;
        gap: 15px;
        justify-content: center;
        align-items: center;
    }

    .action-icons a {
        text-decoration: none;
    }

    /* Specific Style for Edit Icon */
    .action-icons .fas.fa-edit {
        color: black;
        font-size: 18px;
        transition: color 0.3s, transform 0.2s;
    }

    .action-icons .fas.fa-edit:hover {
        color: #0056b3; /* Blue on hover */
        transform: scale(1.1);
    }

    /* Specific Style for Delete Icon */
    .action-icons .fas.fa-trash-alt {
        color: red;
        font-size: 18px;
        transition: transform 0.2s;
    }

    .action-icons .fas.fa-trash-alt:hover {
        transform: scale(1.1);
    }
</style>


<?php 
} else {
    $_SESSION['unauthenticated_error'] = "suspicious_access";
    header("location:http:/Tech-IT/Administrator/customer/index.php");
    exit;
}
?>
