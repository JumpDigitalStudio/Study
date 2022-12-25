<?php
// Отключение вывода предупреждений
ini_set('display_errors', 'Off');


//Запускаем сессию
session_start();
//Добавляем файл подключения к БД
require_once("config.php");


//Объявляем ячейку для добавления ошибок
$_SESSION["password_error"] = '';
//Объявляем ячейку для добавления успешных сообщений
$_SESSION["password_success"] = '';


// Объявляем переменную для выполнения скрипта
$_SESSION["security"] = '';


// Проверяем нажата ли кнопка "Обновить пароль"
if (isset($_POST["submit"]) && !empty($_POST["submit"])) {

	// Серверная валидация поля старого пароля
	if (isset($_POST["old_password"])) {

		$old_password = trim($_POST["old_password"]);

		if (!empty($old_password)) {
			$old_password = htmlspecialchars($old_password, ENT_QUOTES);
			//Шифруем пароль
			$old_password = md5($old_password . "fast");

			// Делаем выборку текущего пароля из базы данных
			$query_reconciliation = $mysqli->query("SELECT clientmail FROM `reg_clients` 
			WHERE clientpassword = '" . $old_password . "' AND clientmail = '" . $_SESSION['user']['mail'] . "'");

			// Проверяем найдена ли строка с паролем
			if ($query_reconciliation->num_rows > 0) {
				$verify_clientmail = mysqli_fetch_assoc($query_reconciliation);
				$verify_mail = $verify_clientmail['clientmail'];

				// Сравниваем пароли
				if ($verify_mail != $_SESSION['user']['mail']) {
					$_SESSION["password_error"] .= "Проверьте правильность ввода текущего пароля";
					echo $_SESSION["security"] = true;
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: " . $address_site . "/account/account.php");
					exit();
				}
			} else {
				$_SESSION["password_error"] .= "Проверьте правильность ввода текущего пароля";
				echo $_SESSION["security"] = true;
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: " . $address_site . "/account/account.php");
				exit();
			}
		} else {
			// Вывод ошибки
			$_SESSION["password_error"] .= "Введите текущий пароль";
			echo $_SESSION["security"] = true;
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: " . $address_site . "/account/account.php");
			exit();
		}
	} else {
		// Вывод ошибки
		$_SESSION["password_error"] .= "Отсутствует поле для ввода текущего пароля. Обратитесь в поддержку";
		echo $_SESSION["security"] = true;
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/account/account.php");
		exit();
	}

	// Серверная валидация полей нового пароля
	if (isset($_POST["password"]) && isset($_POST["reqpass"])) {

		$password = trim($_POST["password"]);
		$reqpass = trim($_POST["reqpass"]);

		if (!empty($password) && !empty($reqpass)) {
			if ($password === $reqpass) {
				$password = htmlspecialchars($password, ENT_QUOTES);
				//Шифруем пароль
				$password = md5($password . "fast");
			} else {
				// Вывод ошибки
				$_SESSION["password_error"] .= "Пароли не совпадают";
				echo $_SESSION["security"] = true;
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: " . $address_site . "/account/account.php");
				exit();
			}
		} else {
			// Вывод ошибки
			$_SESSION["password_error"] .= "Введите Ваш пароль";
			echo $_SESSION["security"] = true;
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: " . $address_site . "/account/account.php");
			exit();
		}
	} else {
		// Вывод ошибки
		$_SESSION["password_error"] .= "Отсутствует поле для ввода пароля. Обратитесь в поддержку";
		echo $_SESSION["security"] = true;
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/account/account.php");
		exit();
	}

	// Запрос на обновление данных пользователя в БД
	$result_query_insert = $mysqli->query("UPDATE `reg_clients` 
	SET clientpassword = '" . $password . "', clientdateupdate = NOW()
	WHERE clientmail = '" . $_SESSION['user']['mail'] . "'");

	if (!$result_query_insert) {
		// Вывод ошибки
		$_SESSION["password_error"] .= "Ошибка работы сервиса. Обратитесь в поддержку";
		echo $_SESSION["security"] = true;
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/account/account.php");
		exit();
	} else {
		// Делаем выборку данных
		$client_info = $mysqli->query("SELECT clientdateupdate FROM `reg_clients` WHERE clientmail = '" . $_SESSION['user']['mail'] . "'");
		// Пересоздаем сессию и перезаписываем данные в глобальный массив
		$user = mysqli_fetch_assoc($client_info);
		$_SESSION['user']['dateupdate'] = $user['clientdateupdate'];
		// Вывод успеха
		$_SESSION["password_success"] .= "Пароль успешно обновлен. Приятных покупок";
		echo $_SESSION["security"] = true;
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/account/account.php");
		exit();
	}
} else {
	//Отправляем пользователя на страницу ошибки при попытке входа напрямую
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: " . $address_site . "/account/error.php");
	exit();
}
