<?php
session_start();
require '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

if (isset($_POST['order_id']) && isset($_POST['new_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];
    $current_admin_id = $_SESSION['user_id']; 

    $sql = "UPDATE applications SET status = ?, admin_id = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$new_status, $current_admin_id, $order_id])) {
        header('Location: admin.php?success=1');
    } else {
        echo "Ошибка при обновлении данных.";
    }
}