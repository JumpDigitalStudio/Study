<!DOCTYPE html>
<html lang="ru">

<head>
	<!-- Meta options -->
	<title>Контакты &mdash; Free & Furious</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Meta & connection -->
	<? require($_SERVER["DOCUMENT_ROOT"] . "/modules/meta.php"); ?>
</head>

<body>
	<!-- Header -->
	<? require($_SERVER["DOCUMENT_ROOT"] . "/modules/header.php"); ?>

	<!-- Banner -->
	<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('/resources/images/bg_3.jpg');" data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		<div class="container">
			<div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
				<div class="col-md-9 ftco-animate pb-5">
					<p class="breadcrumbs"><span class="mr-2"><a href="/index.php">Главная <i class="ion-ios-arrow-forward"></i></a></span> <span>Контакты <i class="ion-ios-arrow-forward"></i></span></p>
					<h1 class="mb-3 bread">Свяжитесь с нами</h1>
				</div>
			</div>
		</div>
	</section>
	<!-- Contacts -->
	<section class="ftco-section contact-section">
		<div class="container">
			<div class="row d-flex mb-5 contact-info">
				<div class="col-md-4">
					<div class="row mb-5">
						<div class="col-md-12">
							<div class="border w-100 p-4 rounded mb-2 d-flex">
								<div class="icon mr-3">
									<span class="icon-map-o"></span>
								</div>
								<p><span>Адрес:</span> Россия, Оренбург, 460040, 7 линия, офис 8</p>
							</div>
						</div>
						<div class="col-md-12">
							<div class="border w-100 p-4 rounded mb-2 d-flex">
								<div class="icon mr-3">
									<span class="icon-mobile-phone"></span>
								</div>
								<p><span>Телефон:</span> <a href="tel://1234567920">+7 (953) 831-84-34</a></p>
							</div>
						</div>
						<div class="col-md-12">
							<div class="border w-100 p-4 rounded mb-2 d-flex">
								<div class="icon mr-3">
									<span class="icon-envelope-o"></span>
								</div>
								<p><span>Почта:</span> <a href="mailto:info@yoursite.com">jumpdigital@gmail.com</a></p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-8 block-9 mb-md-5">
					<form action="#" class="bg-light p-5 contact-form">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Ваше имя">
						</div>
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Ваш Email">
						</div>
						<div class="form-group">
							<textarea name="" id="" cols="30" rows="7" class="form-control" placeholder="Вопрос / сообщение"></textarea>
						</div>
						<div class="form-group">
							<input type="submit" value="Отправить заявку" class="btn btn-primary py-3 px-5">
						</div>
					</form>

				</div>
			</div>
		</div>
	</section>


	<!-- Footer -->
	<? require($_SERVER["DOCUMENT_ROOT"] . "/modules/footer.php"); ?>


	<!-- Preloader -->
	<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
			<circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
			<circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#01d28e" />
	</div>


	<!-- Connection -->
	<? require($_SERVER["DOCUMENT_ROOT"] . "/modules/scripts.php"); ?>
</body>

</html>