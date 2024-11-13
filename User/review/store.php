<?php 
include '../../Administrator/includes/config.php';
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Please log in to review products.";
    exit;
}

$account_id = $_SESSION['user_id'];
$product_id = isset($_GET['product_id']) ? (int) $_GET['product_id'] : 0;

// Begin transaction
mysqli_begin_transaction($conn);

try {
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
 

    // If the product has been purchased
    if (mysqli_num_rows($stmt_result) > 0) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $comment = $_POST['comment'];
            if (isset($stmt_result) && $stmt_result !== null) {
                if (mysqli_num_rows($stmt_result) > 0) {
                    // Display form or other content for leaving a review
                } else {
                    echo "You can only review products you have.";
                }
            } else {
                echo "Error: No result set available. Check if the SQL query executed successfully.";
            }
            
//$rating = $_POST['rating'];

            // Insert review
            $sql_comment = "INSERT INTO review (account_id, product_id, comment, create_at) VALUES (?, ?, ?, NOW())";
            $stmt_insert = mysqli_prepare($conn, $sql_comment);
            mysqli_stmt_bind_param($stmt_insert, "iis", $account_id, $product_id, $comment);

            if (mysqli_stmt_execute($stmt_insert)) {
                echo "Review submitted successfully.";
                mysqli_commit($conn);
            } else {
                echo "Error submitting review: " . mysqli_stmt_error($stmt_insert);
                mysqli_rollback(mysql: $conn);
            }

            mysqli_stmt_close($stmt_insert);
        }
    } else {
        echo "You can only review products you have purchased.";
    }

    // Free result and close statement
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
    mysqli_rollback($conn);
}

mysqli_close($conn);
?>
