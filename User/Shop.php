<?php 
include '../Administrator/includes/config.php';

if(!isset($_SESSION['user_id']) && !isset($_SESSION['role']) && !isset($_SESSION['status'])){
    $_SESSION['unauthenticated_user']='yes';
    header("location:http:../Administrator/customer/login.php");
    exit;
}else{
    // Retrieve category and search parameters from the URL (if set)
    $category_filter = isset($_GET['category_id']) ? $_GET['category_id'] : '';
    $search_term = isset($_GET['search']) ? $_GET['search'] : '';

    // SQL query to display products, with category and search filters
    $sql_display = "SELECT * FROM product 
                    INNER JOIN stocks USING (product_id)
                    LEFT JOIN product_category ON product.product_id = product_category.product_id 
                    LEFT JOIN category ON product_category.category_id = category.category_id 
                    WHERE stock > 0";

    // Apply category filter if a category is selected
    if ($category_filter) {
        $sql_display .= " AND category.category_id = '$category_filter'";
    }

    // Apply search filter if a search term is provided
    if ($search_term) {
        $sql_display .= " AND (product.product_name LIKE '%$search_term%' OR product.product_description LIKE '%$search_term%')";
    }

    $result = mysqli_query($conn, $sql_display);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech-IT</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<style>
    /* Header styles here (unchanged) */
    #navbar {
        background-color: #333;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 50px;
        width: 100%;
        z-index: 1;
        position: fixed;
    }

    #navbar ul {
        display: flex;
        align-items: center;
        width: 100%;
    }

    #logo {
        font-size: 24px;
        color: #fff;
        margin-right: 20px;
    }

    .search-form {
        display: flex;
        justify-content: center;
        align-items: center;
        flex: 1;
    }

    .search-form input[type="text"] {
        width: 300px;
        padding: 5px;
        border: none;
        border-radius: 5px;
    }

    .search-form button {
        background: none;
        border: none;
        color: #fff;
        cursor: pointer;
        padding: 0 8px;
        font-size: 16px;
    }

    .category-dropdown {
        margin-left: 10px;
        padding: 5px;
        border-radius: 5px;
        border: none;
    }

    .nav-links {
        display: flex;
        gap: 20px;
        font-size: 18px;
    }

    .nav-links li {
        color: #fff;
        list-style: none;
    }

    .nav-links li a {
        text-decoration: none;
        color: #fff;
    }

    /* Header and Navbar styles remain unchanged */

    .main-content {
        padding: 100px 20px 20px;
    }

    /* Product Grid */
    .product-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* 3 items per row */
        gap: 35px;
        margin-top: 20px;
    }

    .product-card {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px;
        text-align: center;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }

    /* Ensure that images are responsive and maintain their aspect ratio */
    .product-card img {
        width: 100%; /* Take up full width of the card */
        height: auto; /* Maintain aspect ratio */
        max-height: 300px; /* Set a maximum height to prevent large images */
        object-fit: cover; /* Make sure the image covers the available space */
        border-radius: 10px;
        transition: transform 0.3s ease-in-out; /* Optional zoom effect on hover */
    }

    /* Add a zoom effect on hover for better user experience */
    .product-card img:hover {
        transform: scale(1.05);
    }

    .product-card h5 {
        font-size: 18px;
        margin: 10px 0;
        font-weight: bold;
    }

    .product-card p {
        font-size: 14px;
        color: #555;
    }

    .product-card .price {
        font-size: 16px;
        color: #333;
        font-weight: bold;
    }

    .product-card button {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .product-card button:hover {
        background-color: #218838;
    }

    
</style>
<body>
   <!-- Header -->
<nav id="navbar">
    <ul>
        <li id="logo"><strong>Tech-IT</strong></li>
        <form action="shop.php" method="get" class="search-form" id="searchForm">
            <input type="text" name="search" value="<?php echo htmlspecialchars($search_term); ?>" placeholder="Search...">
            <button type="submit">
                <i class="fas fa-magnifying-glass"></i>
            </button>
            <select class="category-dropdown" name="category_id" onchange="this.form.submit()">
                <option value="">All Categories</option>
                <?php 
                $sql1 = 'SELECT * FROM category';
                $result_categories = mysqli_query($conn, $sql1);
                while ($row = mysqli_fetch_assoc($result_categories)) {
                    echo "<option value='{$row['category_id']}' " . ($row['category_id'] == $category_filter ? 'selected' : '') . ">{$row['category_name']}</option>";
                }
                ?>    
            </select>
        </form>
        
        <!-- Icons and other nav items here (unchanged) -->
        
        <div class="icon-group">
            <a href="Shop.php">
                <i class="fas fa-shopping-bag" style="color:#fff; margin-right:15px;"></i>
            </a>
            <a href="notification.php">
                <i class="fas fa-bell" style="color:#fff; margin-right:15px;"></i>
            </a>
            <a href="cart/cart.php">
                <i class="fas fa-cart-shopping" style="color:#fff; margin-right:15px;"></i>
            </a>
        </div>
        
        <div class="nav-links">
            <li><a href="profile/edit.php">Profile</a></li>
            <li><a href="http:/Tech-IT/administrator/customer/logout.php">Log out</a></li>
        </div>
    </ul>
</nav>

    <!-- Main Content -->
    <div class="main-content">
        
    <div class="product-container">
    <?php 
    // If there are products returned from the query, display them
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="product-card">';
            echo '<a href="cart/product.php?product_id=' . $row['product_id'] . '" style="text-decoration: none; color: inherit;">';
            echo '<img src="../Administrator/Product/uploads/' . $row['product_img'] . '" alt="Product Image">';
            echo '<h5>' . $row['product_name'] . '</h5>';
            echo '<p>' . $row['product_description'] . '</p>';
            echo '<p class="price">$' . $row['price'] . '</p>';
            echo '</a>';
            echo '<form action="cart/store.php" method="POST">';
            echo '<input type="hidden" name="product_id" value="' . $row['product_id'] . '">';
            echo '<input type="number" name="quantity" value="1" min="1" max="' . $row['stock'] . '" step="1" style="width: 70px; margin-right:20px;">';
            echo '<input type="hidden" name="status" value="In Cart">';
            echo '<button type="submit">Add to Cart</button>';
            echo '</form>';
            echo '</div>';
        }
    } else {
        echo "No products found.";
    }
    ?>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php 
}
?>
