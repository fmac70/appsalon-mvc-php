<h1 class="nombre-pagina">Servicios</h1>
<p class="descripcion-pagina">Administración de Servicios</p>

<div class="barra">
	<p>Hola: <?php echo $nombre ?? ''; ?></p>
	<a class="boton" href="/logout">Cerrar Sesión</a>
</div>

<?php if(isset($_SESSION['admin'])) {?>
	<div class="barra-servicios">
		<a class="boton" href="/admin">Ver Citas</a>
		<a class="boton" href="/servicios">Ver Servicios</a>
		<a class="boton" href="/servicios/crear">Nuevo Servicio</a>
	</div>
<?php }?>

<ul class="servicios">
	<?php
		foreach($servicios as $servicio) {
	?> 	
	<li>
		<p>Nombre: <span><?php echo $servicio->nombre; ?></span></p>
		<p>Precio: <span><?php echo $servicio->precio; ?></span></p>
		<div class="acciones">
			<a class="boton" href="/servicios/actualizar?id=<?php echo $servicio->id;?>">Actualizar</a>

			<form action="/servicios/eliminar" method="POST">
				<input type="hidden" name="id" value="<?php echo $servicio->id;?>">
				<input type="submit" value="Borrar" class="boton-eliminar">
			</form>
			
		</div>
	</li>
	<?php }?>
</ul>