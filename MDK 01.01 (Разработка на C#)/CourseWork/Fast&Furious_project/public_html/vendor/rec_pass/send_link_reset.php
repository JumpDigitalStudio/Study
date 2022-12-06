<?php
//Запускаем сессию
session_start();
//Добавляем файл подключения к БД
require_once __DIR__ . ("/../auth_reg/dbconnect.php");
$_SESSION["error_messages"] = '';
//Объявляем ячейку для добавления успешных сообщений
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
				header("Location: " . $address_site . "/ru/profile/recovery/");
				//Останавливаем скрипт
				exit();
			}
		} else {
			// Сохраняем в сессию сообщение об ошибке. 
			$_SESSION["error_messages"] .= "<div class='error_message'>Введите Ваш E-mail.</div>";
			//Возвращаем пользователя на страницу регистрации
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: " . $address_site . "/ru/profile/recovery/");
			//Останавливаем скрипт
			exit();
		}
	} else {
		// Сохраняем в сессию сообщение об ошибке. 
		$_SESSION["error_messages"] .= "<div class='error_message'>Ошибка работы сервиса. Обратитесь в поддержку.</div>";
		//Возвращаем пользователя на страницу регистрации
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/ru/profile/recovery/");
		exit();
	}

	$result_query_select = $mysqli->query("SELECT email_status FROM `reg_users_main` WHERE email = '" . $email . "'");
	if (!$result_query_select) {
		// Сохраняем в сессию сообщение об ошибке. 
		$_SESSION["error_messages"] = "<div class='error_message'>Ошибка работы сервиса. Обратитесь в поддержку.</div>";
		//Возвращаем пользователя на страницу восстановления пароля
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/ru/profile/recovery/");
		//Останавливаем скрипт
		exit();
	} else {
		//Проверяем, если в базе нет пользователя с такими данными, то выводим сообщение об ошибке
		if ($result_query_select->num_rows == 1) {
			//Проверяем, подтвержден ли указанный email
			while (($row = $result_query_select->fetch_assoc()) != false) {
				if ((int)$row["email_status"] === 0) {
					// Сохраняем в сессию сообщение об ошибке. 
					$_SESSION["error_messages"] = "<div class='error_message'>Вы не можете восстановить доступ, так как E-mail не подтвержден.</div>";
					//Возвращаем пользователя на страницу восстановления пароля
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: " . $address_site . "/ru/profile/recovery/");
					//Останавливаем скрипт
					exit();
				} else {
					//Составляем зашифрованный и уникальный token
					$token = md5($email . time());
					//Сохраняем токен в БД
					$query_update_token = $mysqli->query("UPDATE reg_users_main SET reset_pass_token='$token' WHERE email='$email'");
					if (!$query_update_token) {
						// Сохраняем в сессию сообщение об ошибке. 
						$_SESSION["error_messages"] = "<div class='error_message'>Ошибка работы сервиса. Обратитесь в поддержку.</div>";
						//Возвращаем пользователя на страницу восстановления пароля
						header("HTTP/1.1 301 Moved Permanently");
						header("Location: " . $address_site . "/ru/profile/recovery/");
						//Останавливаем скрипт
						exit();
					} else {
						//Составляем ссылку на страницу установки нового пароля.
						$link_reset_password = $address_site . "/vendor/rec_pass/set_new_pass.php?email=$email&token=$token";
						//Составляем заголовок письма
						$subject = "Восстановление пароля UPTUBE.";
						//Составляем тело сообщения
						$message = 'Здравствуйте! <br/> <br/> Для восстановления пароля от сайта
						<a href="http://' . $_SERVER['HTTP_HOST'] . '">  UPTUBE  </a>, перейдите по этой <a href="' . $link_reset_password . '">ссылке</a>.';
						//Составляем дополнительные заголовки для почтового сервиса mail.ru
						//Переменная $email_admin, объявлена в файле dbconnect.php
						$headers = "FROM: $email_admin\r\nReply-to: $email_admin\r\nContent-type: text/html; charset=utf-8\r\n";
						//Отправляем сообщение с ссылкой на страницу установки нового пароля и проверяем отправлена ли она успешно или нет. 
						if (mail($email, $subject, $message, $headers)) {
							$_SESSION["success_messages"] = "<div class='succ_message'>Ссылка для восстановления доступа отправлена на " . $email . ".</div>";
							header("HTTP/1.1 301 Moved Permanently");
							header("Location: " . $address_site . "/ru/profile/sign-in/");
							exit();
						} else {
							$_SESSION["error_messages"] = "<div class='error_message'>Ошибка работы сервиса. Обратитесь в поддержку.</div>";
							//Возвращаем пользователя на страницу восстановления пароля
							header("HTTP/1.1 301 Moved Permanently");
							header("Location: " . $address_site . "/ru/profile/recovery/");
							//Останавливаем скрипт
							exit();
						}
					}
				} // if($row["email_status"] === 0)
			} // End while
		} else {
			// Сохраняем в сессию сообщение об ошибке. 
			$_SESSION["error_messages"] = "<div class='error_message'>Пользователь с указанным E-mail не зарегистрирован.</div>";
			//Возвращаем пользователя на страницу восстановления пароля
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: " . $address_site . "/ru/profile/recovery/");
			//Останавливаем скрипт
			exit();
		}
	}
} else {
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: " . $address_site . "/ru/error/directly_error/");
	exit();
}
// Завершение запроса выбора пользователя из таблицы users
$query_select_user->close();

//Закрываем подключение к БД
$mysqli->close();
