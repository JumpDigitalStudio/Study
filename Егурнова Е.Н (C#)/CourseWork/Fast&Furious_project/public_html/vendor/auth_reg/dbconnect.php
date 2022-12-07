<?php

$server = 'localhost'; // Имя хоста
$username = "root"; // Имя пользователя БД
$password = ""; // Пароль пользователя
$database = "free_furious"; // Имя базы данных
$address_site = "http://localhost:3000"; // Имя сайта
$email_admin = "free.furious@yandex.ru";

$mysqli = new mysqli($server, $username, $password, $database);

if ($mysqli->connect_errno) {
	die("<p><strong>Ошибка работы сервиса. Обратитесь в поддержку.</strong></p><p><strong>Код ошибки: </strong> " . $mysqli->connect_errno . " </p><p><strong>Описание ошибки:</strong> " . $mysqli->connect_error . "</p>");
}
