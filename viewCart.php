<?php

include 'Cart.php';
$cart = new Cart;
?>

<!-- Powered by Alexei Escorcia Macías 2024-->
<?php include_once "header.php"; ?>
<?php
// Mandamos llamar nuestra BD
include 'dbConfig.php';
?>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">


<script>
	function updateCartItem(obj, id) {
		$.get("cartAction.php", {
			action: "updateCartItem",
			id: id,
			qty: obj.value
		}, function(data) {
			if (data == 'ok') {
				location.reload();
			} else {
				location.reload();
			}
		});
	}
</script>

<!DOCTYPE html>
<html lang="es">


<head>
	<title>Sneakersun - Carrito</title>
	<link rel="shortcut icon" href="img\sneackersun-logo-no-background.png" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Enlace a la hoja de estilos de Bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<!-- Enlace a la hoja de estilos personalizada -->
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
	<!-- Barra de navegación -->
	<header>
		<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="margin-bottom: 20px; background-color: rgba(0, 0, 0, 0.5); backdrop-filter: blur(5px);">
			<a class="navbar-brand" href="index.php">
				<img src="img\sneackersun-logo-no-background.png" alt="Sneakersun Logo" width="50" height="50">
				Sneakersun SA de CV
			</a>
			<p class="sneakersun-paragraph" style="color: #9b9b9b;">¡Pisa con estilo, camina con confianza,<br> descubre tu paso perfecto con Sneackersun!</p>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<!-- Formulario de búsqueda -->
						<form class="form-inline my-2 my-lg-0" action="resultados_busqueda.php" method="GET">
							<div class="input-group">
								<!-- buscador -->
								<input class="form-control mr-sm-2" type="search" placeholder="Buscar calzado" aria-label="Buscar" name="search" style="color: #ffffffce; width: 50%; background-color: transparent; border-color: rgba(129, 129, 129, 0.5)">
								<div class="input-group-append">
									<button class="btn btn-outline-success" type="submit" id="button-addon2">
										<i class="bi bi-search"></i> <!-- Icono de lupa de Bootstrap Icons -->
									</button>
								</div>
							</div>
						</form>
						<!-- Script para enviar el formulario al hacer clic en el icono de lupa -->
						<script>
							// Agregar un evento de clic al icono de lupa para enviar el formulario
							document.getElementById('button-addon2').addEventListener('click', function(event) {
								event.preventDefault(); // Evitar que el formulario se envíe automáticamente
								document.querySelector('form').submit(); // Enviar el formulario
							});
						</script>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="index.php">Inicio</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="productos.php">Productos</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="acerca.php">Acerca de</a>
					</li>
					<li>
						<?php
						// Comprueba si la sesión está iniciada
						session_start();

						if (isset($_SESSION['loggedin'])) {
							// Si la sesión está iniciada, muestra el enlace "iniciado"
							echo '<a class="nav-link" href="viewCart.php">Mi Carrito</a>';
						} else {
							// Si la sesión no está iniciada, muestra el enlace "noiniciado"
							echo '<a class="nav-link" style="color: #9b9b9b;" href="login.php">Iniciar sesión<br></a>';
						}
						?>
					</li>

					<!-- Menú desplegable -->
					<?php
					// Comprueba si la sesión está iniciada
					session_start();

					if (isset($_SESSION['loggedin'])) {
						// Si la sesión está iniciada, muestra el enlace "iniciado"

						echo '
								<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Cuenta
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="background-color: rgba(0, 0, 0, 0.25); backdrop-filter: blur(5px);">
								<a class="nav-link" style="color: #9b9b9b;" href="orders.php">Mis<br>compras</a>
		<a class="nav-link" style="color: #9b9b9b;" href="reset-password.php">Cambiar<br>Contraseña</a>
		<a class="nav-link" style="color: #9b9b9b;" href="logout.php">Cerrar<br>Sesión</a>';
					} else {
						// Si la sesión no está iniciada, muestra el enlace "noiniciado"
						echo '';
					}
					?>


			</div>
			</li>
			</ul>
			</div>
		</nav>
	</header>


	<div class="container" style="background-color: rgba(255, 255, 255, 0.05); margin-top: 100px; margin-bottom: 20px;">
		<h1 class="mb-4" style="color: #ffffffce; text-align: center;">Carrito de Compra</h1>
		<div class="table-responsive">
			<table class="table" style="border: 1px solid gray;">
				<thead class="thead">
					<tr style="background-color: rgba(0, 0, 0, 0.3);">
						<!-- <th>Imagen</th> -->
						<th style="color: #ffffffce;">Producto</th>
						<th style="color: #ffffffce;">Precio</th>
						<th style="color: #ffffffce;">Cantidad</th>
						<th style="color: #ffffffce;">Subtotal</th>
						<th style="color: #ffffffce;">Acción</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if ($cart->total_items() > 0) {
						$cartItems = $cart->contents();
						foreach ($cartItems as $item) {
					?>
							<tr style="background-color: rgba(0, 0, 0, 0.1);">
								<!-- <td><img src="<?php echo $item["URLimg"]; ?>" alt="Product Image" style="height: 100px;width: auto;"></td> -->
								<td style="color: #ffffffce;"><?php echo $item["name"]; ?></td>
								<td style="color: #ffffffce;"><?php echo '$' . $item["price"] . ' MXN'; ?></td>
								<td><input style="background-color: #ffffffce; border-color: rgba(129, 129, 129, 0.5)" type="number" class="form-control text-center" value="<?php echo $item["qty"]; ?>" onchange="updateCartItem(this, '<?php echo $item["rowid"]; ?>')"></td>
								<td style="color: #ffffffce;"><?php echo '$' . $item["subtotal"] . ' MXN'; ?></td>
								<td>
									<a href="cartAction.php?action=removeCartItem&id=<?php echo $item["rowid"]; ?>" class="btn btn-danger" onclick="return confirm('¿Deseas eliminar el producto?')"><i class="fas fa-trash-alt"></i> Eliminar</a>
								</td>
							</tr>
						<?php }
					} else { ?>
						<tr>
							<td colspan="6">
								<p style="color: #ffffffce;">Tu Carrito está vacío</p>
							</td>
						</tr>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<p style="color: #ffffffce; text-align: center;">
							NOTA: <br>
							SI TU CARRITO ES MENOR A $2000.00 MXN, SE TE COBRARÁ $180 MXN DE ENVÍO, GRACIAS POR SU COMPRESIÓN:D
							<br>NUESTROS PRECIOS INCLUYEN IVA

						</p>
						<td style="color: #ffffffce;" colspan="4" class="text-right"><strong>Total con envío: </strong></td>
						<td style="color: #ffffffce;" colspan="2"><?php echo '$' . $cart->total() . ' MXN'; ?></td>
					</tr>
					<tr>
						<td colspan="6">
							<a href="productos.php" class="btn btn-warning" style="background-color: purple; color: #ffffffce; border: none;"><i class="fas fa-arrow-left"></i> Continuar Comprando</a>
							<?php if ($cart->total_items() > 0) { ?>
								<a href="checkout.php" class="btn btn-success float-right"><i class="fas fa-check"></i> Revisar</a>
							<?php } ?>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>



	<!-- contacto -->
	<footer>
		<span class="half-br"></span>
		<div class="container fade-in" style="margin-bottom: 20px; background-color: rgba(0, 0, 0, 0.5); backdrop-filter: blur(20px);">
			<div class="row">
				<div class="col-md-6">
					<h4 style="color: #ffffffce;">Sneakersun SA de CV</h4>
					<p>Sneakersun SA de CV es una empresa dedicada a la venta de calzado.</p>
				</div>
				<div class="col-md-6">
					<h4 style="color: #ffffffce;">Contacto</h4>
					<ul class="list-unstyled" style="color: gray">
						<li><i class="fas fa-map-marker-alt"></i> Av. Tecnológico #123, Col. Centro, Ciudad de México</li>
						<li><i class="fas fa-phone"></i> +52 55 2411 1229</li>
						<li><i class="fas fa-envelope"></i> info@sneakersun.com.mx</li>
					</ul>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-6">
					<h5 style="color: #ffffffce;">Políticas de privacidad</h5>
					<p>Respetamos la privacidad de nuestros clientes y nos comprometemos a proteger sus datos personales. Utilizamos la información que nos proporciona solo para procesar su pedido y mejorar su experiencia de compra. Nunca compartiremos su información con terceros sin su consentimiento previo.</p>
				</div>
				<div class="col-md-6">
					<h5 style="color: #ffffffce;">Redes sociales</h5>
					<ul class="list-unstyled">
						<li><a href="#"><i class="fab fa-facebook-f"></i> Facebook</a></li>
						<li><a href="#"><i class="fab fa-twitter"></i> Twitter</a></li>
						<li><a href="#"><i class="fab fa-instagram"></i> Instagram</a></li>
						<li><a href="#"><i class="fab fa-youtube"></i> YouTube</a></li>
					</ul>
				</div>
			</div>
		</div>
	</footer>
</body>

</html>