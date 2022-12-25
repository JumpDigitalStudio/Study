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


// Проверяем нажата ли кнопка "Сохранить изменения"
if (isset($_POST["submit"]) && !empty($_POST["submit"])) {

	// Серверная валидация поля логина
	if (isset($_POST["fio"])) {

		$fio = trim($_POST["fio"]);

		if (!empty($fio) && $fio != 'Не указано') {
			$fio = htmlspecialchars($fio, ENT_QUOTES);
		} else {
			$_SESSION["error_messages"] .= "Введите Ваше ФИО перед сохранением";
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: " . $address_site . "/account/account.php");
			exit();
		}
	} else {
		// Вывод ошибки
		$_SESSION["error_messages"] .= "Отсутствует поле для ввода ФИО. Обратитесь в поддержку";
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/account/account.php");
		exit();
	}

	// Серверная валидация поля половой принадлежности
	if (isset($_POST["pol"])) {

		$pol = trim($_POST["pol"]);
		$pol = mb_strtolower($pol);

		if (!empty($pol) && $pol != 'Не указано' && ($pol == 'мужской' || $pol == 'женский')) {
			if ($pol == 'мужской') {
				$pol = 'Мужской';
				$pol = htmlspecialchars($pol, ENT_QUOTES);
			} else if ($pol == 'женский') {
				$pol = 'Женский';
				$pol = htmlspecialchars($pol, ENT_QUOTES);
			}
		} else {
			$_SESSION["error_messages"] .= "Введите Ваш пол перед сохранением";
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: " . $address_site . "/account/account.php");
			exit();
		}
	} else {
		// Вывод ошибки
		$_SESSION["error_messages"] .= "Отсутствует поле для ввода пола. Обратитесь в поддержку";
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/account/account.php");
		exit();
	}

	// Запрос на обновление данных пользователя в БД
	$result_query_insert = $mysqli->query("UPDATE `reg_clients` 
			SET clientfio = '" . $fio . "', clientpol = '" . $pol . "'
			WHERE clientmail = '" . $_SESSION['user']['mail'] . "'");

	if (!$result_query_insert) {
		// Вывод ошибки
		$_SESSION["error_messages"] .= "Ошибка работы сервиса. Обратитесь в поддержку";
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $address_site . "/account/account.php");
		exit();
	} else {
		// Делаем выборку данных
		$client_info = $mysqli->query("SELECT clientfio, clientpol FROM `reg_clients` WHERE clientmail = '" . $_SESSION['user']['mail'] . "'");
		// Пересоздаем сессию и перезаписываем данные в глобальный массив
		$user = mysqli_fetch_assoc($client_info);
		$_SESSION['user']['fio'] = $user['clientfio'];
		$_SESSION['user']['pol'] = $user['clientpol'];
		// Вывод успеха
		$_SESSION["success_messages"] .= "Данные успешно обновлены. Приятных покупок";
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
