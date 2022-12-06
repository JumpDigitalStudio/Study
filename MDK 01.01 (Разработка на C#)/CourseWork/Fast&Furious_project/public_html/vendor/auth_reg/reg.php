<?php
//Запускаем сессию
session_start();
//Добавляем файл подключения к БД
require_once("dbconnect.php");
//Объявляем ячейку для добавления ошибок, которые могут возникнуть при обработке формы.
$_SESSION["error_messages"] = '';
//Объявляем ячейку для добавления успешных сообщений
$_SESSION["success_messages"] = '';

if (isset($_POST["sub_but_reg"]) && !empty($_POST["sub_but_reg"])) {

	if (isset($_POST["login"])) {
		//Обрезаем пробелы с начала и с конца строки
		$login = trim($_POST["login"]);
		//Проверяем переменную на пустоту
		if (!empty($login)) {
			// Для безопасности, преобразуем специальные символы в HTML-сущности
			$login = htmlspecialchars($login, ENT_QUOTES);
		} else {
			$_SESSION["error_messages"] .= "<div class='error_message'>Укажите Ваше имя или логин.</div>";
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: " . $address_site . "/ru/profile/sign-up/");
			exit();
		}
	} else {
		// Сохраняем в сессию сообщение об ошибке. 
		$_SESSION["error_messages"] .= "<div class='error_message'>Отсутствует поле для ввода логина. Обратитесь в поддержку.</div>";
		//Возвращаем пользователя на страницу регистрации
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/ru/profile/sign-up/");
		//Останавливаем скрипт
		exit();
	}
	if (isset($_POST["email"])) {
		//Обрезаем пробелы с начала и с конца строки
		$email = trim($_POST["email"]);
		if (!empty($email)) {
			// Для безопасности, преобразуем специальные символы в HTML-сущности
			$email = htmlspecialchars($email, ENT_QUOTES);
			//Проверяем формат полученного почтового адреса с помощью регулярного выражения
			$reg_email = "/^[a-z0-9][a-z0-9\._-]*[a-z0-9]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+/i";
			//Если формат полученного почтового адреса не соответствует регулярному выражению
			if (!preg_match($reg_email, $email)) {
				// Сохраняем в сессию сообщение об ошибке. 
				$_SESSION["error_messages"] .= "<div class='error_message'>E-mail введён некорректно.</div>";
				//Возвращаем пользователя на страницу регистрации
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: " . $address_site . "/ru/profile/sign-up/");
				//Останавливаем  скрипт
				exit();
			}
			//Проверяем нет ли уже такого адреса в БД.
			$result_query = $mysqli->query("SELECT `email` FROM `reg_users_main` WHERE `email`='" . $email . "'");
			//Если кол-во полученных строк ровно единице, значит пользователь с таким почтовым адресом уже зарегистрирован
			if ($result_query->num_rows == 1) {
				//Если полученный результат не равен false
				if (($row = $result_query->fetch_assoc()) != false) {
					// Сохраняем в сессию сообщение об ошибке. 
					$_SESSION["error_messages"] .= "<div class='error_message'>Пользователь с указанным E-mail уже зарегистрирован.</div>";
					//Возвращаем пользователя на страницу регистрации
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: " . $address_site . "/ru/profile/sign-up/");
				} else {
					// Сохраняем в сессию сообщение об ошибке. 
					$_SESSION["error_messages"] .= "<div class='error_message'>Ошибка работы сервиса. Обратитесь в поддержку.</div>";
					//Возвращаем пользователя на страницу регистрации
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: " . $address_site . "/ru/profile/sign-up/");
				}
				/* закрытие выборки */
				$result_query->close();
				//Останавливаем  скрипт
				exit();
			}
			/* закрытие выборки */
			$result_query->close();
		} else {
			// Сохраняем в сессию сообщение об ошибке. 
			$_SESSION["error_messages"] .= "<div class='error_message'>Укажите Ваш E-mail.</div>";
			//Возвращаем пользователя на страницу регистрации
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: " . $address_site . "/ru/profile/sign-up/");
			//Останавливаем  скрипт
			exit();
		}
	} else {
		// Сохраняем в сессию сообщение об ошибке. 
		$_SESSION["error_messages"] .= "<div class='error_message'>Отсутствует поле для ввода E-mail. Обратитесь в поддержку.</div>";
		//Возвращаем пользователя на страницу регистрации
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/ru/profile/sign-up/");
		//Останавливаем  скрипт
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
				// Сохраняем в сессию сообщение об ошибке. 
				$_SESSION["error_messages"] .= "<div class='error_message'>Пароли не совпадают.</div>";
				//Возвращаем пользователя на страницу регистрации
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: " . $address_site . "/ru/profile/sign-up/");
				//Останавливаем  скрипт
				exit();
			}
		} else {
			// Сохраняем в сессию сообщение об ошибке. 
			$_SESSION["error_messages"] .= "<div class='error_message'>Укажите Ваш пароль.</div>";
			//Возвращаем пользователя на страницу регистрации
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: " . $address_site . "/ru/profile/sign-up/");
			//Останавливаем  скрипт
			exit();
		}
	} else {
		// Сохраняем в сессию сообщение об ошибке. 
		$_SESSION["error_messages"] .= "<div class='error_message'>Отсутствует поле для ввода пароля. Обратитесь в поддержку.</div>";
		//Возвращаем пользователя на страницу регистрации
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/ru/profile/sign-up/");
		//Останавливаем  скрипт
		exit();
	}

	//Удаляем пользователей из таблицы users, которые не подтвердили свою почту в течении сутки
	$sel_empty_u = $mysqli->query("SELECT * FROM `reg_users_main` WHERE `email_status` = '0' AND `date_reg` < ( NOW() - INTERVAL 1 DAY )");
	if ($sel_empty_u->num_rows > 0) {
		$query_delete_users = $mysqli->query("DELETE FROM `reg_users_main` WHERE `email_status` = 0 AND `date_reg` < ( NOW() - INTERVAL 1 DAY )");
		if (!$query_delete_users) {
			$_SESSION["error_messages"] .= "<div class='error_message'>Сбой при удалении просроченного аккаунта. Код ошибки: " . $mysqli->errno . "</div>";
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: " . $address_site . "/ru/profile/sign-up/");
			exit();
		}
	}

	//Запрос на добавления пользователя в БД
	$result_query_insert = $mysqli->query("INSERT INTO `reg_users_main` (username, email, password, date_reg) VALUES ('" . $login . "', '" . $email . "', '" . $password . "', NOW())");
	if (!$result_query_insert) {
		// Сохраняем в сессию сообщение об ошибке. 
		$_SESSION["error_messages"] .= "<div class='error_message'>Ошибка работы сервиса. Обратитесь в поддержку.</div>";
		//Возвращаем пользователя на страницу регистрации
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/ru/profile/sign-up/");
		//Останавливаем  скрипт
		exit();
	} else {
		//Удаляем пользователей из таблицы confirm_users, которые не подтвердили свою почту в течении сутки
		$sel_empty_cu = $mysqli->query("SELECT * FROM `confirm_users_main` WHERE `date_reg` < ( NOW() - INTERVAL 1 DAY)");
		if ($sel_empty_cu->num_rows > 0) {
			$query_delete_confirm_users = $mysqli->query("DELETE FROM `confirm_users_main` WHERE `date_reg` < ( NOW() - INTERVAL 1 DAY)");
			if (!$query_delete_confirm_users) {
				$_SESSION["error_messages"] .= "<div class='error_message'>Сбой при удалении просроченного аккаунта(confirm). Код ошибки: " . $mysqli->errno . "</div>";
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: " . $address_site . "/ru/profile/sign-in/");
				exit();
			}
		}
		//Составляем зашифрованный и уникальный token
		$token = md5($email . time());
		//Добавляем данные в таблицу confirm_users
		$query_insert_confirm = $mysqli->query("INSERT INTO `confirm_users_main` (email, token, date_reg) VALUES ('" . $email . "', '" . $token . "', NOW()) ");
		if (!$query_insert_confirm) {
			// Сохраняем в сессию сообщение об ошибке. 
			$_SESSION["error_messages"] .= "<div class='error_message'>Ошибка работы сервиса. Обратитесь в поддержку.</div>";
			//Возвращаем пользователя на страницу регистрации
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: " . $address_site . "/ru/profile/sign-up/");
			//Останавливаем  скрипт
			exit();
		} else {
			//Составляем заголовок письма
			$subject = "Подтверждение почты на сайте UPTUBE";
			//Составляем тело сообщения
			$message = 'Здравствуйте! <br/> <br/> Сегодня ' . date("d.m.Y", time()) . ', 
			неким пользователем была произведена регистрация на сайте <a href="' . $address_site . '/">' . $_SERVER['HTTP_HOST'] . '</a> используя Ваш email. 
			Если это были Вы, то, пожалуйста, подтвердите адрес вашей электронной почты, 
			перейдя по этой ссылке: <a href="' . $address_site . '/vendor/auth_reg/activation.php?token=' . $token . '&email=' . $email . '">' . $address_site . '/vendor/activation/' . $token . '</a> 
			<br/> <br/> В противном случае, если это были не Вы, то, просто игнорируйте это письмо. 
			<br/> <br/> <strong>Внимание!</strong> Ссылка действительна 24 часа. После чего Ваш аккаунт будет удален из базы.';
			//Составляем дополнительные заголовки для почтового сервиса mail.ru
			$headers = "FROM: $email_admin\r\nReply-to: $email_admin\r\nContent-type: text/html; charset=utf-8\r\n";
			//Отправляем сообщение с ссылкой для подтверждения регистрации на указанную почту и проверяем отправлена ли она успешно или нет. 
			if (mail($email, $subject, $message, $headers)) {
				$_SESSION["success_messages"] = "<div class='succ_message'>Круто, ты почти с нами! Теперь необходимо подтвердить указанную почту " . $email . ".</div>";
				//Отправляем пользователя на страницу регистрации и убираем форму регистрации
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: " . $address_site . "/ru/profile/sign-in/");
				exit();
			} else {
				$_SESSION["error_messages"] .= "<div class='error_message'>Ошибка отправки письма. Обратитесь в поддержку." . $email . " .</div>";
			}
			// Завершение запроса добавления пользователя в таблицу users
			$result_query_insert->close();
			// Завершение запроса добавления пользователя в таблицу confirm_users
			$query_insert_confirm->close();
		}
	}
	//Закрываем подключение к БД
	$mysqli->close();

	//Отправляем пользователя на страницу регистрации
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: " . $address_site . "/ru/profile/sign-up/");

	exit();
} else {
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: " . $address_site . "/ru/error/directly_error/");
	exit();
}
