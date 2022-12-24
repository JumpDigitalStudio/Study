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


// Проверяем нажата ли кнопка "Зарегистрироваться"
if (isset($_POST["submit"]) && !empty($_POST["submit"])) {

	// Серверная валидация поля логина
	if (isset($_POST["login"])) {

		$login = trim($_POST["login"]);

		if (!empty($login)) {
			$login = htmlspecialchars($login, ENT_QUOTES);
		} else {
			$_SESSION["error_messages"] .= "Введите Ваш логин";
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: " . $address_site . "/account/registration.php");
			exit();
		}
	} else {
		// Вывод ошибки
		$_SESSION["error_messages"] .= "Отсутствует поле для ввода логина. Обратитесь в поддержку";
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/account/registration.php");
		exit();
	}

	// Серверная валидация поля эл почты
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
				header("Location: " . $address_site . "/account/registration.php");
				exit();
			}

			// Проверяем нет ли уже такого адреса в БД
			$result_query = $mysqli->query("SELECT `clientmail` FROM `reg_clients` WHERE `clientmail`='" . $email . "'");

			if ($result_query->num_rows == 1) {
				if (($row = $result_query->fetch_assoc()) != false) {
					// Вывод ошибки	
					$_SESSION["error_messages"] .= "Пользователь с указанной эл. почтой уже зарегистрирован";
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: " . $address_site . "/account/registration.php");
					exit();
				} else {
					// Вывод ошибки	
					$_SESSION["error_messages"] .= "Ошибка работы сервиса. Обратитесь в поддержку";
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: " . $address_site . "/account/registration.php");
					$result_query->close();
					exit();
				}
			}
		} else {
			// Вывод ошибки	
			$_SESSION["error_messages"] .= "Введите Вашу эл. почту";
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: " . $address_site . "/account/registration.php");
			exit();
		}
	} else {
		// Вывод ошибки	
		$_SESSION["error_messages"] .= "Отсутствует поле для ввода эл. почты. Обратитесь в поддержку";
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/account/registration.php");
		exit();
	}

	// Серверная валидация поля пароля и повторения пароля
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
				$_SESSION["error_messages"] .= "Пароли не совпадают";
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: " . $address_site . "/account/registration.php");
				exit();
			}
		} else {
			// Вывод ошибки
			$_SESSION["error_messages"] .= "Введите Ваш пароль";
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: " . $address_site . "/account/registration.php");
			exit();
		}
	} else {
		// Вывод ошибки
		$_SESSION["error_messages"] .= "Отсутствует поле для ввода пароля. Обратитесь в поддержку";
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/account/registration.php");
		exit();
	}

	//Запрос на добавления пользователя в БД
	$result_query_insert = $mysqli->query("INSERT INTO `reg_clients` (clientname, clientmail, clientpassword, clientdate) 
	VALUES ('" . $login . "', '" . $email . "', '" . $password . "', NOW())");

	if (!$result_query_insert) {
		// Вывод ошибки
		$_SESSION["error_messages"] .= "Ошибка работы сервиса. Обратитесь в поддержку";
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/account/registration.php");
		exit();
	} else {
		//Удаляем пользователей из таблицы users, которые не подтвердили свою почту в течении сутки
		$sel_empty_u = $mysqli->query("SELECT * FROM `reg_clients` WHERE `clientconfirm` = '0' AND `clientdate` < ( NOW() - INTERVAL 1 DAY )");
		if ($sel_empty_u->num_rows > 0) {
			$query_delete_users = $mysqli->query("DELETE FROM `reg_clients` WHERE `clientconfirm` = '0' AND `clientdate` < ( NOW() - INTERVAL 1 DAY )");

			if (!$query_delete_users) {
				$_SESSION["error_messages"] .= "Сбой при удалении просроченного аккаунта. Код ошибки: " . $mysqli->errno . ". Обратитесь в поддержку";
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: " . $address_site . "/account/registration.php");
				exit();
			}
		}

		//Составляем зашифрованный и уникальный token
		$token = md5($email . time());

		//Добавляем данные в таблицу confirm_users
		$query_insert_confirm = $mysqli->query("INSERT INTO `need_confirm_clients` (clientmail, clienttoken, clientdate) VALUES ('" . $email . "', '" . $token . "', NOW()) ");

		if (!$query_insert_confirm) {
			// Вывод ошибки
			$_SESSION["error_messages"] .= "Ошибка работы сервиса. Обратитесь в поддержку";
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: " . $address_site . "/account/registration.php");
			exit();
		} else {
			//Составляем заголовок письма
			$subject = "Подтверждение почты на сайте Free & Furious";
			//Составляем тело сообщения
			$message = '
			Здравствуйте! Сегодня ' . date("d.m.Y", time()) . ', неким пользователем была произведена регистрация 
			на сайте Free & Furious используя Ваш email. 
			Если это были Вы, то, пожалуйста, подтвердите адрес вашей электронной почты, 
			перейдя по этой ссылке: 
			' . $address_site . '/vendor/activation.php?token=' . $token . '&email=' . $email . '
			Если это были не Вы, просто игнорируйте это письмо. 
			Внимание пользователи! Ссылка действительна 24 часа. После чего Ваш аккаунт будет удален из базы.';

			//Составляем дополнительные заголовки для почтового сервиса mail.ru
			$headers = "FROM: $email_admin\r\nReply-to: $email_admin\r\nContent-type: text/html; charset=utf-8\r\n";
			//Отправляем сообщение с ссылкой для подтверждения регистрации на указанную почту и проверяем отправлена ли она успешно или нет. 
			if (mail($email, $subject, $message, $headers)) {
				// Вывод успешного сообщения
				$_SESSION["success_messages"] = "Письмо для активации аккаунта отправлено на Вашу эл. почту";
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: " . $address_site . "/account/authorization.php");
				exit();
			} else {
				// Вывод ошибки
				$_SESSION["error_messages"] .= "Ошибка работы сервиса. Обратитесь в поддержку";
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: " . $address_site . "/account/registration.php");
				exit();
			}
			$result_query_insert->close();
			$query_insert_confirm->close();
			$mysqli->close();
			exit();
		}
	}
} else {
	//Отправляем пользователя на страницу ошибки при попытке входа напрямую
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: " . $address_site . "/account/error.php");
	exit();
}
