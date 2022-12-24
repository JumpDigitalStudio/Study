<?php
// Еcли пользовательской сессии не существует, перенаправляем на страницу авторизации
session_start();
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
	header('Location: /account/authorization.php');
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Личный кабинет &mdash; Free & Furious</title>

	<!-- Meta & connection -->
	<? require($_SERVER["DOCUMENT_ROOT"] . "/modules/meta.php"); ?>
</head>

<body>
	<!-- Header -->
	<? require($_SERVER["DOCUMENT_ROOT"] . "/modules/header.php"); ?>

	<!-- Account panel -->
	<div class="section__background hero-wrap ftco-degree-bg" style="background-image: url('/resources/images/bg_1.jpg');" data-stellar-background-ratio="0.5">
		<div class="container">
			<div class="account">
				<div class="panel">
					<!-- Left panel -->
					<div class="panel__settings">
						<div class="panel__title">
							<h1>Меню</h1>
						</div>
						<div class="panel__set">
							<img src="/resources/icons/icon_user_bl.png" alt="Личный кабинет">
							<p class="text">Личный кабинет</p>
						</div>
						<div class="panel__set">
							<img src="/resources/icons/icon_cars.png" alt="Мои заказы">
							<p class="text">Мои заказы</p>
						</div>
						<div class="panel__set">
							<img src="/resources/icons/icon_settings.png" alt="Безопасность">
							<p class="text">Безопасность</p>
						</div>
						<a href="/vendor/logout.php" class="panel__set">
							<img src="/resources/icons/icon_logout.png" alt="Выход">
							<input class="link" type="submit" name="submit" value="Выход">
						</a>
					</div>
					<!-- Main window -->
					<div class="panel__content">
						<!-- Title -->
						<div class="panel__title">
							<h1>Личный кабинет</h1>
						</div>
						<!-- Username -->
						<div class="panel__username">
							<img src="/resources/icons/icon_user.png" alt="Пользователь">
							<p>
								<? if (isset($_SESSION['user'])) {
									echo 'Добро пожаловать, ' . $_SESSION['user']['login'];
								} else {
									echo 'Пользователь';
								} ?>
							</p>
						</div>
						<!-- Userdata -->
						<form action="" method="POST" class="panel__userdata">
							<label for="email">Ваша эл. почта:</label>
							<input class="account__input panel__input" type="email" value="
							<? if (isset($_SESSION['user'])) {
								echo $_SESSION['user']['mail'];
							} else {
								echo 'Эл. почта';
							} ?>" name="email" maxlength="150" disabled>
							<label for="pol">Ваш пол:</label>
							<input class="account__input panel__input" type="text" placeholder="Не указано" name="pol" maxlength="32" minlength="8">
							<label for="birthday">Ваша дата рождения:</label>
							<input class="account__input panel__input" type="date" name="birthday" maxlength="32" minlength="8">
							<div class="panel__btn">
								<input type="submit" name="submit" class="account__btn btn btn-secondary" value="Обновить информацию">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Footer -->
	<? require($_SERVER["DOCUMENT_ROOT"] . "/modules/footer.php"); ?>


	<!-- Preloader -->
	<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
			<circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
			<circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#01d28e" />
	</div>


	<!-- Connection -->
	<? require($_SERVER["DOCUMENT_ROOT"] . "/modules/scripts.php"); ?>
</body>

</html>