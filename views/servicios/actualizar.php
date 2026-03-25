<h1 class="nombre-pagina">Actualizar Servicio</h1>
<p class="descripcion-pagina">Administración de Servicios</p>

<div class="barra">
	<p>Hola: <?php echo $nombre ?? ''; ?></p>
	<a class="boton" href="/logout">Cerrar Sesión</a>
</div>
<?php	include_once __DIR__ . '/../templates/alertas.php'; ?>

<?php if(isset($_SESSION['admin'])) {?>
	<div class="barra-servicios">
		<a class="boton" href="/admin">Ver Citas</a>
		<a class="boton" href="/servicios">Ver Servicios</a>
		<a class="boton" href="/servicios/crear">Nuevo Servicio</a>
	</div>
<?php }?>

<form method = "POST" class="formulario">

	<?php include_once __DIR__ . '/formulario.php'; ?>

	<input type="submit" class="boton" value="Actualizar">

</form>
