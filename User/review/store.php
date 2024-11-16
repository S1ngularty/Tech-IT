<?php 
include '../../Administrator/includes/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Please log in to review products.";
    exit;
}

$account_id = $_SESSION['user_id'];
$product_id = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;

// Begin transaction
mysqli_begin_transaction($conn);

try {
    // Debugging: Check passed values
    //echo "Account ID: $account_id, Product ID: $product_id<br>";

    // Prepare and execute statement to check purchase
    $sql_check = "SELECT ol.product_id
                  FROM orderline ol
                  INNER JOIN orders o ON ol.order_id = o.order_id
                  WHERE o.account_id = ? AND ol.product_id = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    if (!$stmt_check) {
        echo "Error in SQL statement: " . mysqli_error($conn);
        exit;
    }

    mysqli_stmt_bind_param($stmt_check, 'ii', $account_id, $product_id);
    mysqli_stmt_execute($stmt_check);
    $stmt_result = mysqli_stmt_get_result($stmt_check);

    if (!$stmt_result) {
        echo "Error fetching result: " . mysqli_error($conn);
        exit;
    }

    // Check if the user has purchased the product
    if (mysqli_num_rows($stmt_result) > 0) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $comment = $_POST['comment'];
            $rating = $_POST['rating'];

            // Insert review
            $sql_comment = "INSERT INTO review (account_id, product_id, comment, rating, create_at) 
                            VALUES (?, ?, ?, ?, NOW())";
            $stmt_insert = mysqli_prepare($conn, $sql_comment);
            if (!$stmt_insert) {
                echo "Error in SQL statement: " . mysqli_error($conn);
                mysqli_rollback($conn);
                exit;
            }

            mysqli_stmt_bind_param($stmt_insert, "iisi", $account_id, $product_id, $comment, $rating);

            if (mysqli_stmt_execute($stmt_insert)) {
                echo "Review submitted successfully.";
                mysqli_commit($conn);
              //  header("location:../cart/product.php");
            } else {
                echo "Error submitting review: " . mysqli_stmt_error($stmt_insert);
                mysqli_rollback($conn);
            }

            mysqli_stmt_close($stmt_insert);
        }
    } else {
        echo "You can only review products you have purchased.";
    }

    mysqli_stmt_close($stmt_check);
    mysqli_free_result($stmt_result);
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
    mysqli_rollback($conn);
}

mysqli_close($conn);
//header("location:../cart/product.php");

?>
