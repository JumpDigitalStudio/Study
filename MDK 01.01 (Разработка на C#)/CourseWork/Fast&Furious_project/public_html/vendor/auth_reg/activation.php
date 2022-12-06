<?php
session_start();
//Добавляем файл подключения к БД
require_once("dbconnect.php");
//Проверяем, если существует переменная token в глобальном массиве GET
$_SESSION["error_messages"] = '';
$_SESSION["success_messages"] = '';

if (isset($_GET['token']) && !empty($_GET['token'])) {
	$token = $_GET['token'];
} else {
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: " . $address_site . "/ru/profile/sign-in/");
	$_SESSION["error_messages"] .= "<div class='error_message'>Отсутствует проверочный код.</div>";
	exit();
}
//Проверяем, если существует переменная email в глобальном массиве GET
if (isset($_GET['email']) && !empty($_GET['email'])) {
	$email = $_GET['email'];
} else {
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: " . $address_site . "/ru/profile/sign-in/");
	$_SESSION["error_messages"] .= "<div class='error_message'>Отсутствует e-mail адрес.</div>";
	exit();
}
$sel_empty_u = $mysqli->query("SELECT * FROM `reg_users_main` WHERE `email_status` = '0' AND `date_reg` < ( NOW() - INTERVAL 1 DAY )");
if ($sel_empty_u->num_rows > 0) {
	$query_delete_users = $mysqli->query("DELETE FROM `reg_users_main` WHERE `email_status` = 0 AND `date_reg` < ( NOW() - INTERVAL 1 DAY )");
	if (!$query_delete_users) {
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/ru/profile/sign-in/");
		$_SESSION["error_messages"] .= "<div class='error_message'>Сбой при удалении просроченного аккаунта. Код ошибки: " . $mysqli->errno . "</div>";
		exit();
	}
}
$sel_empty_cu = $mysqli->query("SELECT * FROM `confirm_users_main` WHERE `date_reg` < ( NOW() - INTERVAL 1 DAY)");
if ($sel_empty_cu->num_rows > 0) {
	$query_delete_confirm_users = $mysqli->query("DELETE FROM `confirm_users_main` WHERE `date_reg` < ( NOW() - INTERVAL 1 DAY)");
	if (!$query_delete_confirm_users) {
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/ru/profile/sign-in/");
		$_SESSION["error_messages"] .= "<div class='error_message'>Сбой при удалении просроченного аккаунта(confirm). Код ошибки: " . $mysqli->errno . "</div>";
		exit();
	}
}
//Делаем запрос на выборке токена из таблицы confirm_users
$query_select_user = $mysqli->query("SELECT `token` FROM `confirm_users_main` WHERE `email` = '" . $email . "'");
//Если ошибок в запросе нет
if (($row = $query_select_user->fetch_assoc()) != false) {
	//Если такой пользователь существует
	if ($query_select_user->num_rows == 1) {
		//Проверяем совпадает ли token
		if ($token == $row['token']) {
			//Обновляем статус почтового адреса 
			$query_update_user = $mysqli->query("UPDATE `reg_users_main` SET `email_status` = 1 WHERE `email` = '" . $email . "'");
			if (!$query_update_user) {
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: " . $address_site . "/ru/profile/sign-in/");
				$_SESSION["error_messages"] .= "<div class='error_message'>Сбой при обновлении статуса пользователя. Код ошибки: " . $mysqli->errno . "</div>";
				exit();
			} else {
				//Удаляем данные пользователя из временной таблицы confirm_users
				$query_delete = $mysqli->query("DELETE FROM `confirm_users_main` WHERE `email` = '" . $email . "'");
				if (!$query_delete) {
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: " . $address_site . "/ru/profile/sign-in/");
					$_SESSION["error_messages"] .= "<div class='error_message'>Сбой при удалении данных пользователя из временной таблицы. Код ошибки: " . $mysqli->errno . "</div>";
					exit();
				} else {
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: " . $address_site . "/ru/profile/sign-in/");
					$_SESSION["success_messages"] = "<div class='succ_message'>E-mail адрес успешно подтверждён! Теперь Вы можете войти.</div>";
					exit();
				}
			}
		} else {
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: " . $address_site . "/ru/profile/sign-in/");
			$_SESSION["error_messages"] .= "<div class='error_message'>Неправильный проверочный код.</div>";
			exit();
		}
	} else {
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/ru/profile/sign-in/");
		$_SESSION["error_messages"] .= "<div class='error_message'>Пользователь с данным e-mail адресом не зарегистрирован.</div>";
		exit();
	}
} else {
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: " . $address_site . "/ru/profile/sign-in/");
	$_SESSION["error_messages"] .= "<div class='error_message'>Ошибка работы сервиса. Обратитесь в поддержку.</div>";
	exit();
}
// Завершение запроса выбора пользователя из таблицы users
$query_select_user->close();
//Закрываем подключение к БД
$mysqli->close();
