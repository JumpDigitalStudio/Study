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


// Проверяем наличие уникального токена пользователя
if (isset($_GET['token']) && !empty($_GET['token'])) {
	$token = $_GET['token'];
} else {
	// Вывод ошибки
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: " . $address_site . "/account/authorization.php");
	$_SESSION["error_messages"] .= "Отсутствует проверочный код. Повторите попытку через 24 часа";
	exit();
}

//Проверяем наличие email пользователя
if (isset($_GET['email']) && !empty($_GET['email'])) {
	$email = $_GET['email'];
} else {
	// Вывод ошибки
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: " . $address_site . "/account/authorization.php");
	$_SESSION["error_messages"] .= "Отсутствует эл. почта. Повторите попытку через 24 часа";
	exit();
}

//Делаем запрос по выборке токена из таблицы need_confirm_clients
$query_select_user = $mysqli->query("SELECT `clienttoken` FROM `need_confirm_clients` WHERE `clientmail` = '" . $email . "'");

//Если ошибок в запросе нет
if (($row = $query_select_user->fetch_assoc()) != false) {
	//Если такой пользователь существует
	if ($query_select_user->num_rows == 1) {
		//Проверяем совпадает ли token
		if ($token == $row['clienttoken']) {
			//Обновляем статус почтового адреса 
			$query_update_user = $mysqli->query("UPDATE `reg_clients` SET `clientconfirm` = '1' WHERE `clientmail` = '" . $email . "'");

			if (!$query_update_user) {
				// Вывод ошибки
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: " . $address_site . "/account/authorization.php");
				$_SESSION["error_messages"] .= "Сбой первой стадии активации аккаунта. Обратитесь в поддержку";
				exit();
			} else {
				//Удаляем данные пользователя из временной таблицы need_confirm_clients
				$query_delete = $mysqli->query("DELETE FROM `need_confirm_clients` WHERE `clientmail` = '" . $email . "'");

				if (!$query_delete) {
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: " . $address_site . "/account/authorization.php");
					$_SESSION["error_messages"] .= "Сбой второй стадии активации аккаунта. Обратитесь в поддержку";
					exit();
				} else {
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: " . $address_site . "/account/authorization.php");
					$_SESSION["success_messages"] = "Ваш аккаунт успешно активирован. Приятных покупок";
					exit();
				}
			}
		} else {
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: " . $address_site . "/account/authorization.php");
			$_SESSION["error_messages"] .= "Некорректный проверочный код. Обратитесь в поддержку";
			exit();
		}
	} else {
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/account/authorization.php");
		$_SESSION["error_messages"] .= "Акканут с указанной эл. почтой не зарегистрирован";
		exit();
	}
} else {
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: " . $address_site . "/account/authorization.php");
	$_SESSION["error_messages"] .= "Ошибка работы сервиса. Обратитесь в поддержку";
	exit();
}
// Завершение запроса выбора пользователя из таблицы users
$query_select_user->close();
//Закрываем подключение к БД
$mysqli->close();
