<!DOCTYPE html>
<html lang="ru">

<head>
	<!-- Meta options -->
	<title>Модели &mdash; Free & Furious</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Meta & connection -->
	<? require($_SERVER["DOCUMENT_ROOT"] . "/modules/meta.php"); ?>
</head>

<body>
	<!-- Header -->
	<? require($_SERVER["DOCUMENT_ROOT"] . "/modules/header.php"); ?>


	<!-- Banner -->
	<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('/resources/images/bg_6.jpg');" data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		<div class="container">
			<div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
				<div class="col-md-9 ftco-animate pb-5">
					<p class="breadcrumbs"><span class="mr-2"><a href="/index.php">Главная <i class="ion-ios-arrow-forward"></i></a></span> <span>Модели <i class="ion-ios-arrow-forward"></i></span></p>
					<h1 class="mb-3 bread">Наш модельный ряд</h1>
				</div>
			</div>
		</div>
	</section>
	<!-- Cars -->
	<section class="ftco-section bg-light">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<div class="car-wrap rounded ftco-animate">
						<div class="img rounded d-flex align-items-end" style="background-image: url(/resources/images/car-1.jpg);">
						</div>
						<div class="text">
							<h2 class="mb-0"><a href="#">Mercedes Grand Sedan</a></h2>
							<div class="d-flex mb-3">
								<span class="cat">Mercedes</span>
								<p class="price ml-auto">&#8381; 10</p>
							</div>
							<p class="d-flex mb-0 d-block"><a href="/pages/car-single-1.php" class="btn btn-primary py-2 mr-1">Подробнее</a> <a href="#" class="btn btn-secondary py-2 ml-1">Купить</a></p>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="car-wrap rounded ftco-animate">
						<div class="img rounded d-flex align-items-end" style="background-image: url(/resources/images/car-2.jpg);">
						</div>
						<div class="text">
							<h2 class="mb-0"><a href="#">Range Rover</a></h2>
							<div class="d-flex mb-3">
								<span class="cat">Land Rover</span>
								<p class="price ml-auto">&#8381; 15</p>
							</div>
							<p class="d-flex mb-0 d-block"><a href="/pages/car-single-2.php" class="btn btn-primary py-2 mr-1">Подробнее</a> <a href="#" class="btn btn-secondary py-2 ml-1">Купить</a></p>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="car-wrap rounded ftco-animate">
						<div class="img rounded d-flex align-items-end" style="background-image: url(/resources/images/car-3.jpg);">
						</div>
						<div class="text">
							<h2 class="mb-0"><a href="#">McLaren 720s</a></h2>
							<div class="d-flex mb-3">
								<span class="cat">McLaren</span>
								<p class="price ml-auto">&#8381; 20</p>
							</div>
							<p class="d-flex mb-0 d-block"><a href="/pages/car-single-3.php" class="btn btn-primary py-2 mr-1">Подробнее</a> <a href="#" class="btn btn-secondary py-2 ml-1">Купить</a></p>
						</div>
					</div>
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