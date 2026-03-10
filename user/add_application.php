<?php
session_start();
require '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: ../index.php');
    exit();
}

if (isset($_POST['send_app'])) {
    $user_id = $_SESSION['user_id'];
    $pet_name = $_POST['pet_name'];

    $stmt = $pdo->query("SELECT MAX(id) as max_id FROM applications");
    $result = $stmt->fetch();
    $next_number = ($result['max_id'] ?? 0) + 1;
    $folder_name = 'upl' . str_pad($next_number, 3, '0', STR_PAD_LEFT);

    $target_dir = "../uploads/" . $folder_name . "/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (!empty($_FILES['photos']['name'][0])) {
        foreach ($_FILES['photos']['tmp_name'] as $key => $tmp_name) {
            $file_name = $_FILES['photos']['name'][$key];
            $file_target = $target_dir . basename($file_name);
            
            move_uploaded_file($tmp_name, $file_target);
        }
    }

    $sql = "INSERT INTO applications (user_id, pet_name, photo_folder) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$user_id, $pet_name, $folder_name])) {
        header('Location: profile.php?success=1');
    } else {
        echo "Ошибка при создании заявки.";
    }
    exit();
}