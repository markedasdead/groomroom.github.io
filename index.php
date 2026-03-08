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
            <button class="action-button header__button-register">Регистрация</button>
            <button class="action-button header__button-login">Войти</button>
        </div>
    </header>

    <main class="main-page active">
        <section class="examples">
            <p class="section__title">Наши работы</p>
            <div class="examples-grid">
                <?php
                    require 'db.php';

                    $stmt = $pdo->query("SELECT pet_name, photos FROM applications WHERE status = 'Услуга оказана' ORDER BY created_at DESC LIMIT 4");

                    while ($row = $stmt->fetch()) {
                        echo '
                        <div class="example-card">
                            <img src="images/' . $row['photos'] . '" alt="' . $row['pet_name'] . '" class="card__img">
                            <div class="card__content">
                                <h3 class="pet-name">' . htmlspecialchars($row['pet_name']) . '</h3>
                            </div>
                        </div>';
                    }
                    ?>
            </div>
        </section>
    </main>

    <main class="login">

    </main>

    <main class="register">

    </main>
</body>
</html>