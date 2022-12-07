<?php
//Запускаем сессию
session_start();
//Добавляем файл подключения к БД
require_once("dbconnect.php");
$_SESSION["error_messages"] = '';
$_SESSION["success_messages"] = '';

if (isset($_POST["sub_but_auth"]) && !empty($_POST["sub_but_auth"])) {
	$email = trim($_POST["email"]);
	if (isset($_POST["email"])) {
		if (!empty($email)) {
			$email = htmlspecialchars($email, ENT_QUOTES);
			//Проверяем формат полученного почтового адреса с помощью регулярного выражения
			$reg_email = "/^[a-z0-9][a-z0-9\._-]*[a-z0-9]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+/i";
			//Если формат полученного почтового адреса не соответствует регулярному выражению
			if (!preg_match($reg_email, $email)) {
				// Сохраняем в сессию сообщение об ошибке. 
				$_SESSION["error_messages"] .= "<div class='error_message'>E-mail введён некорректно.</div>";
				//Возвращаем пользователя на страницу авторизации
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: " . $address_site . "/ru/profile/sign-in/");
				//Останавливаем скрипт
				exit();
			}
		} else {
			// Сохраняем в сессию сообщение об ошибке. 
			$_SESSION["error_messages"] .= "<div class='error_message'>Введите Ваш E-mail.</div>";
			//Возвращаем пользователя на страницу регистрации
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: " . $address_site . "/ru/profile/sign-in/");
			//Останавливаем скрипт
			exit();
		}
	} else {
		// Сохраняем в сессию сообщение об ошибке. 
		$_SESSION["error_messages"] .= "<div class='error_message'>Ошибка работы сервиса. Обратитесь в поддержку.</div>";
		//Возвращаем пользователя на страницу регистрации
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/ru/profile/sign-in/");
		exit();
	}
	if (isset($_POST["password"])) {
		//Обрезаем пробелы с начала и с конца строки
		$password = trim($_POST["password"]);
		if (!empty($password)) {
			$password = htmlspecialchars($password, ENT_QUOTES);
			//Шифруем пароль
			$password = md5($password . "uptube");
		} else {
			// Сохраняем в сессию сообщение об ошибке. 
			$_SESSION["error_messages"] .= "<div class='error_message'>Укажите Ваш пароль.</div>";
			//Возвращаем пользователя на страницу регистрации
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: " . $address_site . "/ru/profile/sign-in/");
			//Останавливаем скрипт
			exit();
		}
	} else {
		// Сохраняем в сессию сообщение об ошибке. 
		$_SESSION["error_messages"] .= "<div class='error_message'>Ошибка работы сервиса. Обратитесь в поддержку.</div>";
		//Возвращаем пользователя на страницу регистрации
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/ru/profile/sign-in/");
		//Останавливаем скрипт
		exit();
	}
	$sel_empty_u = $mysqli->query("SELECT * FROM `reg_users_main` WHERE `email_status` = '0' AND `date_reg` < ( NOW() - INTERVAL 1 DAY )");
	if ($sel_empty_u->num_rows > 0) {
		$query_delete_users = $mysqli->query("DELETE FROM `reg_users_main` WHERE `email_status` = 0 AND `date_reg` < ( NOW() - INTERVAL 1 DAY )");
		if (!$query_delete_users) {
			exit("<p><strong>Ошибка!</strong> Сбой при удалении просроченного аккаунта. Код ошибки: " . $mysqli->errno . "</p>");
		}
	}
	$sel_empty_cu = $mysqli->query("SELECT * FROM `confirm_users_main` WHERE `date_reg` < ( NOW() - INTERVAL 1 DAY)");
	if ($sel_empty_cu->num_rows > 0) {
		$query_delete_confirm_users = $mysqli->query("DELETE FROM `confirm_users_main` WHERE `date_reg` < ( NOW() - INTERVAL 1 DAY)");
		if (!$query_delete_confirm_users) {
			exit("<p><strong>Ошибка!</strong> Сбой при удалении просроченного аккаунта(confirm). Код ошибки: " . $mysqli->errno . "</p>");
		}
	}
	$result_query_select = $mysqli->query("SELECT * FROM `reg_users_main` WHERE email = '" . $email . "' AND password = '" . $password . "'");

	if (!$result_query_select) {
		// Сохраняем в сессию сообщение об ошибке. 
		$_SESSION["error_messages"] .= "<div class='error_message'>Ошибка работы сервиса. Обратитесь в поддержку.</div>";
		//Возвращаем пользователя на страницу регистрации
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/ru/profile/sign-in/");
		//Останавливаем скрипт
		exit();
	} else {
		//Проверяем, если в базе нет пользователя с такими данными, то выводим сообщение об ошибке
		if ($result_query_select->num_rows == 1) {
			//Проверяем, подтвержден ли указанный email
			while (($row = $result_query_select->fetch_assoc()) != false) {
				//Если email не подтверждён
				if ((int)$row["email_status"] == 0) {
					// Сохраняем в сессию сообщение об ошибке. 
					$_SESSION["error_messages"] = "<div class='error_message'>Необходимо подтвердить Ваш E-mail адрес в течении 24 часов.</div>";
					//Возвращаем пользователя на страницу авторизации
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: " . $address_site . "/ru/profile/sign-in/");
					//Останавливаем скрипт
					exit();
				} else {
					$result_query_select_info = $mysqli->query("SELECT * FROM `reg_users_main` WHERE email = '" . $email . "' AND password = '" . $password . "'");
					$user = mysqli_fetch_assoc($result_query_select_info);
					$_SESSION['user'] = [
						"login" => $user['username'],
						"email" => $user['email']
					];
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: " . $address_site . "/ru/account/");
					//Останавливаем скрипт
					exit();
				}
			}
		} else {

			// Сохраняем в сессию сообщение об ошибке. 
			$_SESSION["error_messages"] .= "<div class='error_message'>Неверный логин или пароль.</div>";

			//Возвращаем пользователя на страницу авторизации
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: " . $address_site . "/ru/profile/sign-in/");

			//Останавливаем скрипт
			exit();
		}
	}
} else {
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: " . $address_site . "/ru/error/directly_error/");
	exit();
}
