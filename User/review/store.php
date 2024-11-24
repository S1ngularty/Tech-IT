<?php 
include '../../Administrator/includes/config.php';
if(!isset($_SESSION['user_id']) && !isset($_SESSION['role']) && !isset($_SESSION['status'])){
    $_SESSION['unauthenticated_user']='yes';
    header("location:http:../../Administrator/customer/login.php");
    exit;
}else{

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo "Please log in to review products.";
        exit;
    }

    $account_id = $_SESSION['user_id'];
    $product_id = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;

    // List of bad words to check for
    $bad_words = ["abuse", "idiot", "dumb", "stupid", "fool", "heck", "crap", "hell", 
    "damn", "bastard", "moron", "slut", "whore", "retard", "faggot", 
    "asshole", "bitch", "cunt", "dick", "shit", "fuck", "nigger", "nigga", 
    "piss", "prick", "twat", "wanker", "cock", "ballsack", "bollocks", 
    "bugger", "jackass", "arse", "douche", "ho", "tits", "boobs", 
    "motherfucker", "sonofabitch", "pussy", "jerk","putangina", "gago", "tangina", "tarantado", "ulol", "tanga", 
    "bobo", "lintik", "bwisit", "gunggong", "hayop", "lecheng", 
    "pakyu", "peste", "siraulo", "kupal", "kantutan", "hindot", 
    "kupal", "putragis", "ungas", "ulol"]; 

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

        // Check if the user has purchased the product
        if (mysqli_num_rows($stmt_result) > 0) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $comment = $_POST['comment'];
                $rating = $_POST['rating'];

                // Check and replace bad words in the comment using preg_match
                foreach ($bad_words as $bad_word) {
                    // Use preg_match to find bad words and replace them
                    if (preg_match("/\b" . preg_quote($bad_word, '/') . "\b/i", $comment)) {
                        // Replace the bad word with asterisks of the same length
                        $comment = preg_replace("/\b" . preg_quote($bad_word, '/') . "\b/i", str_repeat('*', strlen($bad_word)), $comment);
                    }
                }

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
}
?>
