<?php
session_start();
require '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: ../index.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM applications WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$my_orders = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <title>Мой профиль — GroomRoom</title>
</head>
<body>
    <header class="header">
        <div class="header__left-side"><p class="header__title">groomroom</p></div>
        <div class="header__right-side">
            <a href="../index.php" class="action-button">На главную</a>
            <a href="../logout.php" class="action-button">Выйти</a>
        </div>
    </header>

    <main class="active">
        <section class="create-application">
            <p class="section__title">Новая запись</p>
            <form action="add_application.php" method="POST" class="auth-form" enctype="multipart/form-data">
                <input type="text" name="pet_name" placeholder="Кличка питомца" required>
                
                <p style="font-size: 14px; margin-top: 10px;">Выберите фото питомца (ДО):</p>
                <input type="file" name="photos[]" multiple accept="image/*" required>
                
                <button type="submit" name="send_app" class="action-button">Записаться</button>
            </form>
        </section>

        <hr style="margin: 40px 0; border: 0; border-top: 1px solid #cad2c5;">

        <p class="main__title">Мои записи на стрижку</p>
        
        <div class="examples-grid" style="margin-top: 30px;">
            <?php foreach ($my_orders as $order): ?>
                <div class="example-card">
                    <div class="card__img" style="background-image: url(../uploads/<?= $order['photo_folder'] ?: 'no-photo.png' ?>/after.png); background-position: center; background-size: cover;"></div>
                    <div class="card__content">
                        <p class="pet-name"><?= htmlspecialchars($order['pet_name']) ?></p>
                        <p style="padding-left: 20px;">Статус: <strong><?= $order['status'] ?></strong></p>
                        <p style="padding-left: 20px; font-size: 14px; opacity: 0.6;"><?= $order['created_at'] ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>