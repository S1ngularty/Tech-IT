<?php 
include '../../Administrator/includes/config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "Please log in to review products.";
    exit;
}




?>