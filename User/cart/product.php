<?php
include '../../Administrator/includes/config.php';

// Check if product_id exists
if (isset($_GET['product_id'])) {
    $product_id = (int)$_GET['product_id'];
} else {
    header("Location: shop.php");
    exit;
}

// Retrieve product details
$sql_display = "SELECT product_id, product_name, price, product_description, product_img, s.stock 
                FROM product 
                INNER JOIN stocks s USING(product_id) 
                WHERE product_id = $product_id";
$result = mysqli_query($conn, $sql_display);
$product = mysqli_fetch_assoc($result);

// Fetch reviews for the product
$sql_reviews = "SELECT r.review_id, r.rating, r.comment, a.username, r.create_at, r.account_id 
                FROM review r
                INNER JOIN account a ON r.account_id = a.account_id
                WHERE r.product_id = ?
                ORDER BY r.create_at DESC";

$stmt_reviews = mysqli_prepare($conn, $sql_reviews);

if ($stmt_reviews) {
    mysqli_stmt_bind_param($stmt_reviews, "i", $product['product_id']);
    mysqli_stmt_execute($stmt_reviews);
    $reviews_result = mysqli_stmt_get_result($stmt_reviews);
}

// Check if user is logged in
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['product_name']; ?> - Tech-IT</title>
    <style>
        /* Product Interface */
        .product-interface {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
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
            font-size: 16px;
            font-weight: bold;
        }

        .add-to-cart:hover, .checkout:hover {
            background-color: #c82333;
        }

        .checkout {
            background-color: #28a745;
        }

        .checkout:hover {
            background-color: #218838;
        }

        .product-controls {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 15px;
            margin-top: 20px;
        }

        .product-controls input[type="number"] {
            width: 60px;
            padding: 5px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
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
            display: flex;
            justify-content: space-between;
        }

        .review-rating i {
            color: #ffcc00;
        }

        .review-text {
            font-size: 14px;
            color: #555;
            margin-top: 5px;
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

        .rating-submit:hover {
            background-color: #218838;
        }

        .edit-icon {
            cursor: pointer;
            color: #007bff;
        }

        .edit-form {
            margin-top: 20px;
        }

        .edit-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="product-interface">
    <form action="../User/review/store.php" method="post">
        <img src="../../Administrator/Product/uploads/<?php echo $product['product_img']; ?>" alt="<?php echo $product['product_name']; ?>">
        <div class="product-details">
            <h2 class="product-title"><?php echo $product['product_name']; ?></h2>
            <p class="product-price">$<?php echo $product['price']; ?></p>
            <p class="product-description"><?php echo $product['product_description']; ?></p>
            <div class="product-controls">
                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>">
                <button class="add-to-cart" name="add" type="submit">Add to Cart</button>
                <button class="checkout">Checkout</button>
            </div>
        </div>
    </form>
    <div class="review-section">
        <h3 class="review-title">Reviews</h3>
        <?php if ($reviews_result && mysqli_num_rows($reviews_result) > 0) : ?>
            <?php while ($review = mysqli_fetch_assoc($reviews_result)) : ?>
                <div class="review-item">
                    <div class="review-rating">
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <?php if ($i <= $review['rating']) : ?>
                                <i class="fas fa-star"></i>
                            <?php else : ?>
                                <i class="far fa-star"></i>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                    <p class="review-text">"<?php echo htmlspecialchars($review['comment']); ?>"</p>
                    <small class="review-meta">- <?php echo htmlspecialchars($review['username']); ?> on <?php echo date("F j, Y", strtotime($review['create_at'])); ?></small>

                    <!-- Display pencil icon if the logged-in user is the author -->
                    <?php if ($user_id && $user_id == $review['account_id']) : ?>
                        <span class="edit-icon">
                            <form method="post" action="">
                                <input type="hidden" name="edit_review_id" value="<?php echo $review['review_id']; ?>">
                                <button type="submit" style="background:none;border:none;color:#007bff;">&#9998;</button>
                            </form>
                        </span>
                        
                        <!-- Review edit form (hidden by default) -->
                        <?php
                        if (isset($_POST['edit_review_id']) && $_POST['edit_review_id'] == $review['review_id']) {
                            echo '<form action="../review/update.php" method="post" class="edit-form">
                                <input type="hidden" name="review_id" value="' . $review['review_id'] . '">
                                <textarea name="updated_comment" rows="4" required>' . htmlspecialchars($review['comment']) . '</textarea>
                                <button type="submit" class="rating-submit">Update Review</button>
                            </form>';
                        }
                        ?>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <p>No reviews yet. Be the first to review this product!</p>
        <?php endif; ?>

        <!-- Review submission form -->
        <h4>Submit Your Review</h4>
        <form action="../review/store.php" method="post">
            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
            <div>
                <label for="rating">Rating:</label>
                <select name="rating" id="rating" required>
                    <option value="1">1 Star</option>
                    <option value="2">2 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="5">5 Stars</option>
                </select>
            </div>
            <div>
                <label for="comment">Comment:</label>
                <textarea name="comment" id="comment" rows="4" required></textarea>
            </div>
            <button type="submit" class="rating-submit">Submit Review</button>
        </form>
    </div>
</div>
</body>
</html>
