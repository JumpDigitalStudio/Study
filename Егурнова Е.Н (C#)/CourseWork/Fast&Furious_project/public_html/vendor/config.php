<?php
// Отключение вывода предупреждений
ini_set('display_errors', 'Off');

$server = 'localhost'; // Имя хоста
$username = "root"; // Имя пользователя БД
$password = ""; // Пароль пользователя
$database = "fastfurious"; // Имя базы данных
$address_site = "http://localhost:3000"; // Имя сайта
$email_admin = "furious.free@mail.ru";

$mysqli = new mysqli($server, $username, $password, $database);

if ($mysqli->connect_errno) {
	die("<p>Состояние серверов: <strong style='color: red'>проблемы работы</strong></p>
	<p>Код ошибки: <strong>" . $mysqli->connect_errno . "</strong></p>
	<p>Описание ошибки: <strong>" . $mysqli->connect_error . "</strong></p>
	<p>Обратитесь в поддержку по адресу 
	<strong><a href='mailto:jumpdigital.studio@gmail.com'>электронной почты</a></strong></p>");
}
