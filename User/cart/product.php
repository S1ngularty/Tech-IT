<?php
include '../../Administrator/includes/config.php';
if (isset($_GET['product_id'])) {
    $product_id = (int)$_GET['product_id'];
} else {
    header("Location: shop.php");
    exit;
}


 
$sql_display = "SELECT product_id, product_name, price, product_description, product_img, date_added , s.stock
                FROM product inner join stocks s using(product_id)
                WHERE product_id = $product_id";
$result = mysqli_query($conn, $sql_display);
$product = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['product_name']; ?> - Tech-IT</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<style>
/* Product Interface */
.product-interface {
    max-width: 800px;
    margin: 50px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
}

.product-interface img {
    width: 100%;
    height: auto;
    border-radius: 10px;
    margin-bottom: 20px;
}

.product-details {
    text-align: left;
}

.product-title {
    font-size: 24px;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}

.product-price {
    font-size: 20px;
    color: #28a745;
    margin: 10px 0;
}

.product-stock {
    font-size: 16px;
    color: #888;
}

.product-description {
    font-size: 14px;
    color: #555;
    margin: 20px 0;
}

.add-to-cart, .checkout {
    background-color: #dc3545;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}

.add-to-cart:hover, .checkout:hover {
    background-color: #c82333;
}

.checkout {
    background-color: #28a745;
}

.review-section {
    margin-top: 30px;
    padding: 20px;
    border-top: 1px solid #ddd;
}

.review-title {
    font-size: 20px;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}

.review-item {
    border-bottom: 1px solid #ddd;
    padding: 10px 0;
}

.review-rating i {
    color: #ffcc00;
}

.review-text {
    font-size: 14px;
    color: #555;
    margin-top: 5px;
}

.rating-input {
    display: flex;
    align-items: center;
    gap: 5px;
    margin-top: 10px;
}

.rating-input label {
    font-size: 14px;
    color: #333;
}

.rating-input select,
.rating-input textarea {
    padding: 5px;
    font-size: 14px;
}

.rating-input textarea {
    width: 100%;
}

.rating-submit {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 10px;
}
.product-controls {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 15px; /* Adds spacing between the elements */
    margin-top: 20px;
}

.rating-submit:hover {
    background-color: #218838;
}
</style>
<body>
<div class="product-interface">
    <!-- Product Image -->
  <form action="store.php" method="post" enctype="multipart/form-data">
  <img src="../../Administrator/Product/uploads/<?php echo $product['product_img']; ?>" alt="<?php echo $product['product_name']; ?>">

<!-- Product Details -->
<div class="product-details">
    <h2 class="product-title"><?php echo $product['product_name']; ?></h2>
    <p class="product-price">$<?php echo $product['price']; ?></p>
    <!-- <p class="product-stock">Stock available: <?php // echo $product['stock']; ?></p> -->
    <p class="product-description"><?php echo $product['product_description']; ?></p>
    
    <!-- Quantity Control -->
<div class="product-controls">
<input type="hidden" name="product_id" value="<?php echo $product['product_id'];  ?>">
<input type="number" name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>" step="1" style="width: 50px; margin-right:10px;">
<button class="add-to-cart" name="add" type="submit">Add to Cart</button>
<button class="checkout">Checkout</button>
</div>
  </form>


    <!-- Review Section -->
    <div class="review-section">
        <h3 class="review-title">Customer Reviews</h3>

        <!-- Sample Review Item -->
        <div class="review-item">
            <div class="review-rating">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="far fa-star"></i> <!-- Example Rating: 4 out of 5 -->
            </div>
            <p class="review-text">"Great product! Quality is amazing."</p>
        </div>

        <!-- Leave a Review -->
        <div class="leave-review">
            <h4>Leave a Review</h4>
            <form action="submit_review.php" method="POST">
                <div class="rating-input">
                    <label for="rating">Rating:</label>
                    <select name="rating" id="rating" required>
                        <option value="5">5 - Excellent</option>
                        <option value="4">4 - Good</option>
                        <option value="3">3 - Average</option>
                        <option value="2">2 - Poor</option>
                        <option value="1">1 - Very Poor</option>
                    </select>
                </div>
                <div class="rating-input">
                    <label for="review_text">Your Review:</label>
                    <textarea name="review_text" id="review_text" rows="3" required></textarea>
                </div>
                <button type="submit" class="rating-submit">Submit Review</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
