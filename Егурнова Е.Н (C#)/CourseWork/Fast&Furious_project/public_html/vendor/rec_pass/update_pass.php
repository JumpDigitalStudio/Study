<?php
//Запускаем сессию
session_start();
//Добавляем файл подключения к БД
require_once __DIR__ . ("/../auth_reg/dbconnect.php");
$_SESSION["error_messages"] = '';
$_SESSION["success_messages"] = '';
if (isset($_POST["sub_but_auth"]) && !empty($_POST["sub_but_auth"])) {

	if (isset($_POST['token']) && !empty($_POST['token'])) {
		$token = $_POST['token'];
	} else {
		$_SESSION["error_messages"] = "<div class='error_message'>Отсутствует проверочный код.</div>";
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/vendor/rec_pass/set_new_pass.php?email=$email&token=$token");
		exit();
	}

	if (isset($_POST['email']) && !empty($_POST['email'])) {
		$email = $_POST['email'];
	} else {
		$_SESSION["error_messages"] = "<div class='error_message'>Отсутствует e-mail адрес.</div>";
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/vendor/rec_pass/set_new_pass.php?email=$email&token=$token");
		exit();
	}
	if (isset($_POST["password"]) && isset($_POST["reqpass"])) {
		//Обрезаем пробелы с начала и с конца строки
		$password = trim($_POST["password"]);
		$reqpass = trim($_POST["reqpass"]);
		if (!empty($password) && !empty($reqpass)) {
			if ($password === $reqpass) {
				$password = htmlspecialchars($password, ENT_QUOTES);
				//Шифруем пароль
				$password = md5($password . "uptube");
			} else {
				$_SESSION["error_messages"] .= "<div class='error_message'>Пароли не совпадают.</div>";
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: " . $address_site . "/vendor/rec_pass/set_new_pass.php?email=$email&token=$token");
				exit();
			}
		} else {
			// Сохраняем в сессию сообщение об ошибке. 
			$_SESSION["error_messages"] .= "<div class='error_message'>Укажите Ваш пароль.</div>";
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: " . $address_site . "/vendor/rec_pass/set_new_pass.php?email=$email&token=$token");
			exit();
		}
	} else {
		$_SESSION["error_messages"] .= "<div class='error_message'>Отсутствует поле для ввода пароля. Обратитесь в поддержку.</div>";
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/vendor/rec_pass/set_new_pass.php?email=$email&token=$token");
		exit();
	}
	$query_update_password = $mysqli->query("UPDATE reg_users_main SET password='$password' WHERE email='$email'");
	$query_reset_token = $mysqli->query("UPDATE reg_users_main SET reset_pass_token='NULL' WHERE email='$email'");

	if (!$query_update_password && !$query_reset_token) {
		$_SESSION["error_messages"] = "<div class='error_message'>Ошибка работы сервиса. Обратитесь в поддержку.</div>";
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/vendor/rec_pass/set_new_pass.php?email=$email&token=$token");
		exit();
	} else {
		$_SESSION["success_messages"] = "<div class='succ_message'>Пароль успешно изменён.</div>";
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/ru/profile/sign-in/");
		exit();
	}
} else {
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: " . $address_site . "/ru/error/directly_error/");
	exit();
}
