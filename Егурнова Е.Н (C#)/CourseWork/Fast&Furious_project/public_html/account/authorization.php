<?php
// Еcли пользовательская сессия существует, перенаправляем на страницу личного кабинета
session_start();
if (isset($_SESSION['user'])) {
	header('Location: /account/account.php');
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Вход &mdash; Free & Furious</title>

	<!-- Meta & connection -->
	<? require($_SERVER["DOCUMENT_ROOT"] . "/modules/meta.php"); ?>
</head>

<body>
	<!-- Header -->
	<? require($_SERVER["DOCUMENT_ROOT"] . "/modules/header.php"); ?>

	<!-- Autorization -->
	<div class="section__background hero-wrap ftco-degree-bg" style="background-image: url('/resources/images/bg_1.jpg');" data-stellar-background-ratio="0.5">
		<div class="container">
			<!-- Autorization form -->
			<div class="account">
				<div class="account__container">
					<!-- Title + icon -->
					<div class="account__title">
						<img src="/resources/icons/icon_auth.png" alt="Авторизация">
						<h1>Авторизация</h1>
					</div>
					<!-- Setup error or sucess functions -->
					<div class="account__message message">
						<?php

						//Если в сессии существуют сообщения об ошибках, то выводим их
						if (isset($_SESSION["error_messages"]) && !empty($_SESSION["error_messages"])) {
							echo $_SESSION["error_messages"];
							//Уничтожаем чтобы не выводились заново при обновлении страницы
							unset($_SESSION["error_messages"]);
						}
						//Если в сессии существуют радостные сообщения, то выводим их
						if (isset($_SESSION["success_messages"]) && !empty($_SESSION["success_messages"])) {
							echo $_SESSION["success_messages"];
							//Уничтожаем чтобы не выводились заново при обновлении страницы
							unset($_SESSION["success_messages"]);
						}

						?>
					</div>
					<!-- Content -->
					<form action="/vendor/auth.php" method="POST" class="account__form">
						<input class="account__input" type="email" placeholder="Эл. почта" name="email" maxlength="150" required>
						<input class="account__input" type="password" placeholder="Пароль" name="password" maxlength="32" minlength="8" required>
						<input type="submit" name="submit" class="account__btn btn btn-secondary" value="Войти">
						<p class="account__text">Нет аккаунта? <a href="/account/registration.php"> Регистрация</a>
					</form>
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