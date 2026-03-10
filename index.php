<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GroomRoom — Главная</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="logo/logo_groom.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chiron+GoRound+TC:wght@200..900&display=swap" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="header__left-side">
            <p class="header__title">groomroom</p>
        </div>
        <div class="header__right-side">
            <button class="action-button header__button-register" id="registerBtn">Регистрация</button>
            <button class="action-button header__button-login" id="loginBtn">Войти</button>
        </div>
    </header>

    <main class="main-page" id="main">
        <section class="examples">
            <p class="section__title">Наши работы</p>
            <div class="examples-grid">
                <?php
                    require 'db.php';

                    $stmt = $pdo->query("SELECT pet_name, photo_folder FROM applications WHERE status = 'Услуга оказана' ORDER BY created_at DESC LIMIT 4");

                    while ($row = $stmt->fetch()) {
                        echo '
                        <div class="example-card">
                            <div class="card__img" style="background-image: url(uploads/' . $row['photo_folder'] . '/after.png); background-position: center; background-size: cover"></div>
                            <div class="card__content">
                                <p class="pet-name">' . htmlspecialchars($row['pet_name']) . '</p>
                            </div>  
                        </div>';
                    }
                    ?>
            </div>
        </section>
    </main>

    <main class="login active" id="login">
    <p class="main__title">Войти в аккаунт</p>
    <form action="auth.php" method="POST" class="auth-form">
        <input type="text" name="login" placeholder="Логин" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit" name="do_login" class="action-button">Войти</button>
    </form>
</main>

<main class="register" id="register">
    <p class="main__title">Зарегистрироваться</p>
    <form action="auth.php" method="POST" class="auth-form">
        <input type="text" name="fio" placeholder="ФИО" required>
        <input type="text" name="login" placeholder="Логин" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit" name="do_register" class="action-button">Создать аккаунт</button>
    </form>
</main>

<script src="script.js"></script>
</body>
</html>