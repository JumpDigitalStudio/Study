<?php
// Отключение вывода предупреждений
ini_set('display_errors', 'Off');
// Запуск сессии
session_start();
?>

<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	<div class="container">
		<a class="navbar-brand" href="/index.php">Free&<span>Furious</span></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="oi oi-menu"></span> Меню
		</button>

		<div class="collapse navbar-collapse" id="ftco-nav">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item"><a href="/index.php" class="nav-link">Главная</a></li>
				<li class="nav-item"><a href="/pages/about.php" class="nav-link">О нас</a></li>
				<li class="nav-item"><a href="/pages/car.php" class="nav-link">Модели</a></li>
				<li class="nav-item"><a href="/pages/contact.php" class="nav-link">Контакты</a></li>
				<li class="nav-item nav-item__user">
					<?php
					if (isset($_SESSION['user'])) {
						echo '
						<img src="/resources/icons/icon_user.png" class="nav-logo" alt="Личный кабинет">
						<a href="/account/authorization.php" class="nav-link nav-link__bold">' . $_SESSION['user']['login'] . '</a>';
					} else {
						echo '<a href="/account/authorization.php" class="nav-link">Личный кабинет</a>';
					}
					?>
				</li>
			</ul>
		</div>
	</div>
</nav>