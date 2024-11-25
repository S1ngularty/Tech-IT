<?php
include '../administrator/includes/config.php';
if(!isset($_SESSION['user_id']) && !isset($_SESSION['role']) && !isset($_SESSION['status'])){
    $_SESSION['unauthenticated_user']='yes';
    header("location:http:../Administrator/customer/login.php");
    exit;
}else{

if (!isset($_SESSION['user_id'])) {
    echo "Please log in first!";
    exit;
}

$user_id = $_SESSION['user_id']; // The user_id from session is being used here

// Fetch purchase history for the current user where the status is "shipped"
$sql = "SELECT o.order_id, o.orderDate, o.total_amount, o.status,
               ol.product_id, p.product_name, p.product_img, ol.quantity, ol.unit_price, ol.total_price, ol.created
        FROM order_details_view o
        INNER JOIN orderline ol ON o.order_id = ol.order_id
        INNER JOIN product p ON ol.product_id = p.product_id
        WHERE o.account_id = ? AND o.status = 'shipped'"; // Filtering by account_id and status

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    die("Error preparing statement: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, 'i', $user_id); // Binding the parameter for user_id
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Group data by order_id
$orders = [];
while ($row = mysqli_fetch_assoc($result)) {
    $orders[$row['order_id']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase History</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .history-container {
            max-width: 900px;
            margin: 0 auto;
        }
        .order {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            margin-bottom: 20px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .order-header h3 {
            font-size: 20px;
            color: #333;
        }
        .order-header span {
            font-size: 14px;
            color: #666;
        }
        .order-items {
            margin-top: 10px;
        }
        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
        .order-item:last-child {
            border-bottom: none;
        }
        .order-item img {
            width: 60px;
            height: 60px;
            border-radius: 5px;
            object-fit: cover;
            margin-right: 15px;  /* Adjust margin between image and details */
        }
        .order-item-details {
            flex: 1;
            margin-left: 10px;
        }
        .order-item-details h4 {
            font-size: 16px;
            color: #333;
            margin: 0;
        }
        .order-item-details p {
            font-size: 14px;
            color: #666;
            margin: 5px 0;
        }
        .order-footer {
            margin-top: 15px;
            text-align: right;
        }
        .order-footer span {
            font-size: 16px;
            color: #333;
            font-weight: bold;
        }
        .back-btn {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            font-size: 16px;
            color: #007BFF;
            cursor: pointer;
        }
        .back-btn i {
            margin-right: 8px;
        }
        .back-btn:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="back-btn" onclick="window.history.back();">
    <i class="fas fa-arrow-left"></i> Return to previous page
</div>

<div class="history-container">
    <h1>Purchase History</h1>
    <?php if (!empty($orders)): ?>
        <?php foreach ($orders as $order_id => $order_items): ?>
            <div class="order">
                <div class="order-header">
                    <h3>Order ID: <?= $order_id; ?></h3>
                    <span>Placed on: <?= date("F j, Y", strtotime($order_items[0]['orderDate'])); ?></span>
                </div>
                <div class="order-items">
                    <?php foreach ($order_items as $item): ?>
                        <div class="order-item">
                            <img src="../Administrator/Product/uploads/<?= $item['product_img']; ?>" alt="<?= $item['product_name']; ?>" class="product-img">
                            <div class="order-item-details">
                                <h4><?= $item['product_name']; ?></h4>
                                <p>Quantity: <?= $item['quantity']; ?></p>
                                <p>Unit Price: $<?= number_format($item['unit_price'], 2); ?></p>
                            </div>
                            <p>Total: $<?= number_format($item['total_price'], 2); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="order-footer">
                    <span>Total Amount: $<?= number_format($order_items[0]['total_amount'], 2); ?> (<?= ucfirst($order_items[0]['status']); ?>)</span>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>You have no purchase history.</p>
    <?php endif; ?>
</div>


</body>
</html>

<?php } ?>
