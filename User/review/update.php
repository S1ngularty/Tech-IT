<?php
include '../../Administrator/includes/config.php';

if(!isset($_SESSION['user_id']) && !isset($_SESSION['role']) && !isset($_SESSION['status'])){
    $_SESSION['unauthenticated_user']='yes';
    header("location:http:../../Administrator/customer/login.php");
    exit;
}else{
// Check if the user is logged in
if (!isset($_SESSION['user_id']) && !isset($_POST['update_btn'])) {
    echo "Please log in to update your review.";
    exit;
}

$review_id = isset($_POST['review_id']) ? (int) $_POST['review_id'] : 0;
$product_id = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;
echo $rating = isset($_POST['rating']) ? (int) $_POST['rating'] : 0;
$comment = isset($_POST['comment']) ? $_POST['comment'] : '';
// Ensure the review exists and belongs to the user
$sql_check = "SELECT * FROM review WHERE review_id = ? AND account_id = ?";
$stmt_check = mysqli_prepare($conn, $sql_check);
mysqli_stmt_bind_param($stmt_check, 'ii', $review_id, $_SESSION['user_id']);
mysqli_stmt_execute($stmt_check);
$check_result = mysqli_stmt_get_result($stmt_check);

if (mysqli_num_rows($check_result) == 0) {
    echo "Review not found or you do not have permission to edit it.";
    exit;
}

// Update the review in the database
echo $sql_update = "UPDATE review SET rating = ?, comment = ? WHERE review_id = ? AND account_id = ?";
$stmt_update = mysqli_prepare($conn, $sql_update);
echo $acct_id=$_SESSION['user_id'];
mysqli_stmt_bind_param($stmt_update, 'isii', $rating, $comment, $review_id,$acct_id );
mysqli_stmt_execute($stmt_update);

if (mysqli_stmt_affected_rows($stmt_update) > 0) {
    echo "Review updated successfully!";
    header("location: http:/Tech-IT/User/cart/product.php?product_id=$product_id");
    exit();
} else {
    echo "Failed to update the review.";
}

mysqli_stmt_close($stmt_update);
}
?>
