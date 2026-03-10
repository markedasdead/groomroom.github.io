<?php
session_start();
require '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

// Получаем заявки и имена админов через JOIN
$sql = "SELECT a.*, u.fio as admin_name 
        FROM applications a 
        LEFT JOIN users u ON a.admin_id = u.id 
        ORDER BY a.created_at DESC";
$stmt = $pdo->query($sql);
$orders = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <title>Панель администратора — GroomRoom</title>
</head>
<body>
    <header class="header">
        <div class="header__left-side"><p class="header__title">groomroom admin</p></div>
        <div class="header__right-side">
            <a href="../logout.php" class="action-button">Выйти</a>
        </div>
    </header>

    <main class="active">
        <p class="main__title">Управление заявками</p>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Питомец</th>
                    <th>Папка с фото</th>
                    <th>Статус</th>
                    <th>Администратор</th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['pet_name']) ?></td>
                    <td><?= htmlspecialchars($order['photo_folder']) ?></td>
                    <td><span class="status-badge"><?= $order['status'] ?></span></td>
                    <td><?= $order['admin_name'] ? htmlspecialchars($order['admin_name']) : '<i>Не назначен</i>' ?></td>
                    <td>
                        <form action="update_status.php" method="POST" style="display: flex; gap: 5px;">
                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                            <select name="new_status" class="status-select">
                                <option value="Новая" <?= $order['status'] == 'Новая' ? 'selected' : '' ?>>Новая</option>
                                <option value="Обработка данных" <?= $order['status'] == 'Обработка данных' ? 'selected' : '' ?>>В обработке</option>
                                <option value="Услуга оказана" <?= $order['status'] == 'Услуга оказана' ? 'selected' : '' ?>>Оказана</option>
                            </select>
                            <button type="submit" class="action-button" style="padding: 5px 15px; font-size: 14px;">OK</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>