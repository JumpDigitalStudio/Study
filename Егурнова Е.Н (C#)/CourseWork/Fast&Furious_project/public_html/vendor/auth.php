<?php
// Отключение вывода предупреждений
ini_set('display_errors', 'Off');


//Запускаем сессию
session_start();
//Добавляем файл подключения к БД
require_once("config.php");


//Объявляем ячейку для добавления ошибок
$_SESSION["error_messages"] = '';
//Объявляем ячейку для добавления успешных сообщений
$_SESSION["success_messages"] = '';


// Проверяем нажата ли кнопка "Войти"
if (isset($_POST["submit"]) && !empty($_POST["submit"])) {

	// Серверная валидация поля эл. почты
	if (isset($_POST["email"])) {

		$email = trim($_POST["email"]);

		if (!empty($email)) {
			$email = htmlspecialchars($email, ENT_QUOTES);

			// Проверяем формат полученного почтового адреса с помощью регулярного выражения
			$reg_email = "/^[a-z0-9][a-z0-9\._-]*[a-z0-9]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+/i";

			if (!preg_match($reg_email, $email)) {
				// Вывод ошибки	
				$_SESSION["error_messages"] .= "Введена некорректная эл. почта";
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: " . $address_site . "/account/authorization.php");
				exit();
			}
		} else {
			// Вывод ошибки	
			$_SESSION["error_messages"] .= "Введите Вашу эл. почту";
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: " . $address_site . "/account/authorization.php");
			exit();
		}
	} else {
		// Вывод ошибки	
		$_SESSION["error_messages"] .= "Отсутствует поле для ввода эл. почты. Обратитесь в поддержку";
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/account/authorization.php");
		exit();
	}

	// Серверная валидация поля пароля
	if (isset($_POST["password"])) {

		$password = trim($_POST["password"]);

		if (!empty($password)) {
			$password = htmlspecialchars($password, ENT_QUOTES);
			//Шифруем пароль
			$password = md5($password . "fast");
		} else {
			// Вывод ошибки
			$_SESSION["error_messages"] .= "Введите Ваш пароль";
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: " . $address_site . "/account/authorization.php");
			exit();
		}
	} else {
		// Вывод ошибки
		$_SESSION["error_messages"] .= "Отсутствует поле для ввода пароля. Обратитесь в поддержку";
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/account/authorization.php");
		exit();
	}

	//  Ищем в базе аккаунт с введенными данными
	$result_query_select = $mysqli->query("SELECT * FROM `reg_clients` WHERE clientmail = '" . $email . "' AND clientpassword = '" . $password . "'");

	if (!$result_query_select) {
		// Вывод ошибки
		$_SESSION["error_messages"] .= "Ошибка работы сервиса. Обратитесь в поддержку";
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/account/authorization.php");
		exit();
	} else {
		//Проверяем, если в базе нет пользователя с такими данными, то выводим сообщение об ошибке
		if ($result_query_select->num_rows == 1) {

			//Проверяем, подтвержден ли указанный email
			while (($row = $result_query_select->fetch_assoc()) != false) {
				//Если email не подтверждён
				if ((int)$row["clientconfirm"] == 0) {
					// Вывод ошибки
					$_SESSION["error_messages"] .= "Для входа в личный кабинет активируйте аккаунт через эл. почту";
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: " . $address_site . "/account/authorization.php");
					exit();
				} else {
					// Делаем выборку данных
					$client_info = $mysqli->query("SELECT * FROM `reg_clients` WHERE clientmail = '" . $email . "' AND clientpassword = '" . $password . "'");
					// Создаем сессию и записываем данные в глобальный массив
					$user = mysqli_fetch_assoc($client_info);
					$_SESSION['user'] = [
						"login" => $user['clientname'],
						"mail" => $user['clientmail']
					];
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: " . $address_site . "/account/account.php");
					exit();
				}
			}
		} else {
			// Вывод ошибки
			$_SESSION["error_messages"] .= "Введен некорректный пароль или адрес эл. почты";
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: " . $address_site . "/account/authorization.php");
			exit();
		}
	}
} else {
	//Отправляем пользователя на страницу ошибки при попытке входа напрямую
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: " . $address_site . "/account/error.php");
	exit();
}
