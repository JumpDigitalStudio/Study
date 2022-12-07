<?php
//Запускаем сессию
session_start();
require_once __DIR__ . ("/../auth_reg/dbconnect.php");
$_SESSION["error_messages"] = '';
//Объявляем ячейку для добавления успешных сообщений
$_SESSION["success_messages"] = '';
if (isset($_GET['token']) && !empty($_GET['token'])) {
	$token = $_GET['token'];
} else {
	$_SESSION["error_messages"] = "<div class='error_message'>Отсутствует проверочный код.</div>";
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: " . $address_site . "/ru/profile/recovery/");
	exit();
}
//Проверяем, если существует переменная email в глобальном массиве GET
if (isset($_GET['email']) && !empty($_GET['email'])) {
	$email = $_GET['email'];
} else {
	$_SESSION["error_messages"] = "<div class='error_message'>Отсутствует e-mail адрес.</div>";
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: " . $address_site . "/ru/profile/recovery/");
	exit();
}
$query_select_user = $mysqli->query("SELECT reset_pass_token FROM `reg_users_main` WHERE `email` = '" . $email . "'");
//Если ошибок в запросе нет
if (($row = $query_select_user->fetch_assoc()) != false) {
	//Если такой пользователь существует
	if ($query_select_user->num_rows == 1) {
		//Проверяем совпадает ли token
		if ($token == $row['reset_pass_token']) {
?>
			<?php
			session_start();
			if (isset($_SESSION['user'])) {
				header('Location: /ru/account/');
			}
			?>
			<!DOCTYPE html>
			<html lang="ru">

			<head>
				<meta charset="UTF-8">
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<meta name="description" content="Быстрый старт твоего канала. Никакой накрутки, только живые просмторы. Полностью автоматизированный сервис продвижения.">
				<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
				<link rel="icon" href="/favicon.ico" type="images/x-icon">
				<link rel="stylesheet" href="/styles/css/header.css">
				<link rel="stylesheet" href="/styles/css/icons.css">
				<link rel="stylesheet" href="/styles/css/animate.min.css" />
				<link rel="stylesheet" type="text/css" title="light" href="/ru/profile/sign.css">
				<link rel="preconnect" href="https://fonts.googleapis.com">
				<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
				<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;700&family=Raleway:wght@300;400;500;700&family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
				<title>Создание нового пароля</title>
			</head>

			<body>
				<!-- Bounding shell UPTUBE -->
				<div class="wrapper">
					<!-- Main page UPTUBE -->
					<main class="page" id="sec">
						<section class="page_sec">
							<div class="sign">
								<div class="sign__cont">
									<form action="/vendor/rec_pass/update_pass.php" method="POST" class="cont__sign sign__in">
										<p class='sign__title'>Новый пароль</p>
										<div class="message">
											<?
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
										<input class="input" type="password" placeholder="Новый пароль" name="password" maxlength="32" minlength="8" required>
										<input class="input" type="password" placeholder="Повторите пароль" name="reqpass" maxlength="32" minlength="8" required>
										<input type="hidden" name="token" value="<?= $token ?>">
										<input type="hidden" name="email" value="<?= $email ?>">
										<input type="submit" class="sendform" name="sub_but_auth" value="Сохранить">
										<p class="sign_link">Вспомнили пароль? <a href="/ru/profile/sign-in/"> Назад</a>
								</div>
							</div>
						</section>
						<div class="back__black"></div>
					</main>
				</div>
				<!-- UPTUBE JS -->
				<script src="/app/webkit-engine/determinant.js"></script>
				<script src="/app/webkit-form/jquery.maskedinput.min.js"></script>
				<script src="/app/webkit-form/jquery.validate.min.js"></script>
				<script src="https://kit.fontawesome.com/c11f28b2d4.js" crossorigin="anonymous"></script>
				<script src="//code-ya.jivosite.com/widget/RLNHVd4Yot" async></script>
			</body>

			</html>
<?;
			exit();
		} else {
			$_SESSION["error_messages"] = "<div class='error_message'>Неправильный проверочный код.</div>";
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: " . $address_site . "/ru/profile/recovery/");
			exit();
		}
	} else {
		$_SESSION["error_messages"] = "<div class='error_message'>Пользователь с указанным e-mail адресом не зарегистрирован.</div>";
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/ru/profile/recovery/");
		exit();
	}
} else {
	$_SESSION["error_messages"] = "<div class='error_message'>Ошибка работы сервиса. Обратитесь в поддержку.</div>";
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: " . $address_site . "/ru/profile/recovery/");
	exit();
}

// Завершение запроса выбора пользователя из таблицы users
$query_select_user->close();

//Закрываем подключение к БД
$mysqli->close();
