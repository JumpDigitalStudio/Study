<?php
$name = $_POST['name'];
$email = $_POST['email'];
$text = $_POST['text'];
$title = $_POST['title'];

$to = "free.furious@yandex.ru";
$date = date("d.m.Y");
$time = date("h:i");
$from = "free.furious@yandex.ru";
$subject = "Обращение в поддержку Free & Furious";

$msg = "
	 Имя: $name
	 Почта: $email
------------------------
	 Тема: $title
	 Сообщение: $text
------------------------
	 Дата: $date
	 Время: $time";
mail($to, $subject, $msg, "From: $from");
