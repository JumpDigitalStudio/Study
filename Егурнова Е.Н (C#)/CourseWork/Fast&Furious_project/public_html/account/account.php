<?php
// Еcли пользовательской сессии не существует, перенаправляем на страницу авторизации
session_start();
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
	header('Location: /account/authorization.php');

	// Проверка наличия сессии пользователя
} else if (isset($_SESSION['user'])) {

	// Проверка нулевого дня	
	if (isset($_SESSION['user']['login'])) {
		if (!isset($_SESSION['user']['fio']) || !isset($_SESSION['user']['pol'])) {
			$client_login = 'Добро пожаловать, ' . $_SESSION['user']['login'] . '<br> При первом посещении заполните недостающие данные';
		} else {
			$client_login = 'Здравствуйте, ' . $_SESSION['user']['login'];
		}
	} else {
		$client_login = 'Здравствуй, пользователь';
	}

	// Проверка наличия даты регистрации
	if (isset($_SESSION['user']['datereg'])) {
		$client_date_reg = 'Дата регистрации: ' . substr($_SESSION['user']['datereg'], 0, strpos($_SESSION['user']['datereg'], ' '));
	} else {
		$client_date_reg = 'Настройки безопасности';
	}

	// Проверка наличия ФИО пользователя
	if (isset($_SESSION['user']['fio'])) {
		$client_fio = $_SESSION['user']['fio'];
	} else {
		$client_fio = 'Не указано';
	}

	// Проверка наличия половой принадлежности пользователя
	if (isset($_SESSION['user']['pol'])) {
		$client_pol = $_SESSION['user']['pol'];
	} else {
		$client_pol = 'Не указано';
	}

	// Проверка наличия половой принадлежности пользователя
	if (isset($_SESSION['user']['ordersnum'])) {
		$client_orders_num = 'Ваши заказы: ' . $_SESSION['user']['ordersnum'];
	} else {
		$client_orders_num = 'Пока нет машин';
	}

	// Проверка наличия даты обновления пароля
	if (isset($_SESSION['user']['dateupdate'])) {
		$client_pass_update = 'Последнее обновление пароля: ' . substr($_SESSION['user']['dateupdate'], 0, strpos($_SESSION['user']['dateupdate'], ' '));
	} else {
		$client_pass_update = 'Последнее обновление пароля: при регистрации';
	}
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
						<div class="panel__set-title">
							<h1>Меню</h1>
						</div>
						<div class="panel__set" onclick="openPanel('cabinet')">
							<img src="/resources/icons/icon_user_bl.png" alt="Личный кабинет">
							<p class="text">Личный кабинет</p>
						</div>
						<div class="panel__set" onclick="openPanel('orders')">
							<img src="/resources/icons/icon_cars_bl.png" alt="Мои заказы">
							<p class="text">Мой гараж</p>
						</div>
						<div class="panel__set" onclick="openPanel('security')">
							<img src="/resources/icons/icon_settings_bl.png" alt="Безопасность">
							<p class="text">Безопасность</p>
						</div>
						<a href="/vendor/logout.php" class="panel__set">
							<img src="/resources/icons/icon_logout.png" alt="Выход">
							<input class="link" type="submit" name="submit" value="Выход">
						</a>
					</div>
					<!-- Main panel -->
					<div class="panel__content">
						<!-- Client cabinet -->
						<div class="panel__panel active" id="cabinet">
							<!-- Title -->
							<div class="panel__title">
								<h1>Личный кабинет</h1>
							</div>
							<!-- Username -->
							<div class="panel__username">
								<p> <img src="/resources/icons/icon_salut.png" alt="Пользователь"><? echo $client_login; ?></p>
							</div>
							<!-- Setup error or sucess functions -->
							<div class="message">
								<!-- Errors output -->
								<p style="color: #FA5252;">
									<?php
									if (isset($_SESSION["error_messages"]) && !empty($_SESSION["error_messages"])) {
										echo $_SESSION["error_messages"];
										unset($_SESSION["error_messages"]);
									} ?>
								</p>
								<!-- Success output -->
								<p style="color: #01d28e;">
									<?php
									if (isset($_SESSION["success_messages"]) && !empty($_SESSION["success_messages"])) {
										echo $_SESSION["success_messages"];
										unset($_SESSION["success_messages"]);
									} ?>
								</p>
							</div>
							<!-- Userdata -->
							<form action="/vendor/update.php" method="POST" class="panel__userdata">
								<label for="fio">Ваше полное имя (ФИО):</label>
								<input class="account__input panel__input" type="text" placeholder="<? echo $client_fio; ?>" name="fio" maxlength="250" minlength="8" required>
								<label for="email">Ваша эл. почта:</label>
								<input class="account__input panel__input" type="email" value="<? echo $_SESSION['user']['mail']; ?>" name="email" maxlength="150" disabled>
								<label for="pol">Ваш пол:</label>
								<input class="account__input panel__input" type="text" placeholder="<? echo $client_pol; ?>" name="pol" maxlength="7" minlength="7" required>
								<div class="panel__btn">
									<input type="submit" name="submit" class="account__btn btn btn-secondary" value="Сохранить изменения">
								</div>
							</form>
						</div>
						<!-- Client orders -->
						<div class="panel__panel" id="orders">
							<!-- Title -->
							<div class="panel__title">
								<h1>Мой гараж</h1>
							</div>
							<div class="panel__username">
								<img src="/resources/icons/icon_cars.png" alt="Заказы">
								<p><? echo $client_orders_num; ?></p>
							</div>
						</div>
						<!-- Client security -->
						<div class="panel__panel" id="security">
							<!-- Title -->
							<div class="panel__title">
								<h1>Безопасность</h1>
							</div>
							<div class="panel__username">
								<img src="/resources/icons/icon_settings.png" alt="Дата регистрации">
								<p> <? echo $client_date_reg; ?></p>
							</div>
							<div class="panel__username">
								<img src="/resources/icons/icon_pass.png" alt="Последняя смена пароля">
								<p style="color: #000 !important;"> <? echo $client_pass_update; ?></p>
							</div>
							<!-- Setup error or sucess functions -->
							<div class="message">
								<!-- Errors output -->
								<p style="color: #FA5252;">
									<?php
									if (isset($_SESSION["password_error"]) && !empty($_SESSION["password_error"])) {
										echo $_SESSION["password_error"];
										unset($_SESSION["password_error"]);
									} ?>
								</p>
								<!-- Success output -->
								<p style="color: #01d28e;">
									<?php
									if (isset($_SESSION["password_success"]) && !empty($_SESSION["password_success"])) {
										echo $_SESSION["password_success"];
										unset($_SESSION["password_success"]);
									} ?>
								</p>
							</div>
							<!-- Userdata -->
							<form action="/vendor/newpassword.php" method="POST" class="panel__userdata">
								<label for="old_password">Ваш текущий пароль:</label>
								<input class="account__input panel__input" type="password" placeholder="********" name="old_password" maxlength="32" minlength="8" required>
								<label for="password">Ваш новый пароль:</label>
								<input class="account__input panel__input" type="password" placeholder="Введите пароль" name="password" maxlength="32" minlength="8" required>
								<label for="reqpass">Повторите новый пароль:</label>
								<input class="account__input panel__input" type="password" placeholder="Повторите пароль" name="reqpass" maxlength="32" minlength="8" required>
								<div class="panel__btn">
									<input type="submit" name="submit" class="account__btn btn btn-secondary" value="Обновить пароль">
								</div>
							</form>
						</div>
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

	<? if (isset($_SESSION["security"]) && !empty($_SESSION["security"])) {
		if ($_SESSION["security"] == true) {
			echo "
			<script>
				openPanel('security');
			</script>";
			unset($_SESSION["security"]);
		}
	} ?>
</body>

</html>