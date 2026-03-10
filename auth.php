<?php
require 'db.php';
session_start();

if (isset($_POST['do_register'])) {
    $fio = $_POST['fio'];
    $login = $_POST['login'];
    $email = $_POST['email'];
    
    $password = sha1($_POST['password']); 
    $role = 'user'; 

    $sql = "INSERT INTO users (fio, login, email, password, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$fio, $login, $email, $password, $role]);

    header('Location: index.php?success=registered');
    exit();
}

if (isset($_POST['do_login'])) {
    $login = $_POST['login'];
    $password = sha1($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ? AND password = ?");
    $stmt->execute([$login, $password]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header('Location: groom/admin.php');
        } else {
            header('Location: user/profile.php');
        }
        exit();
    } else {
        echo "Неверный логин или пароль!";
    }
}
?>