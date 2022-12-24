<?php
// Отключение вывода предупреждений
ini_set('display_errors', 'Off');


//Запускаем сессию
session_start();


// Удаляем данные глобального массива User
unset($_SESSION['user']);


// Возвращаем пользователя на начальную страницу
header("HTTP/1.1 301 Moved Permanently");
header("Location: " . $address_site . "/index.php");
