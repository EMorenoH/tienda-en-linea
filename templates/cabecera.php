<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Caompatible" content="ie=edge">
	<title>Tienda en Linea</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light fixed-top">
		<a class="navbar-brand" href="index.php"></a>
		<button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse">
			<span class="navbar-togler-icon"></span>
		</button>
		<div id="my-nav" class="collapse navbar-collapse">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active">
					<a class="btn btn-primary" href="index.php">Home</a>
				</li>
				<li class="nav-item active">
					<a class="btn btn-primary" href="mostrarCarrito.php">Carrito(<?php
						echo (empty($_SESSION['CARRITO']))?0:count($_SESSION['CARRITO']);
						?>)</a>


				</li>				
			</ul>


		</div>
	</nav>
	<br/><br/>


	<div class="container">