<h1 class="nombre-pagina">Panel de Administración</h1>


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


	



<h2>Buscar Cita</h2>
<form class="formulario">

			<div class="campo">
				<label	for="fecha">Fecha</label>
				<input
					id		=	"fecha"
					type	=	"date"
					min		=	<?php echo date('Y-m-d', strtotime('+1 day')); ?>
					value	=	<?php echo $fecha; ?>
					
				/>
			</div>
</form>

<?php
	if(count($citas)	=== 0)
	{
		echo "<h2> No hay Citas en esta fecha </h2>";
	}
?>


<div id="citas-admin">

	<ul class="citas">
		<?php
		$idCita	= 0;
		foreach($citas as  $key=>$cita)
		{
			if($idCita !== $cita->id)
			{
				$total	= 0;
				$idCita = $cita->id;
				?>
			
				<li>
					<p>ID:<span><?php 			echo $cita->id ?></p>
					<p>Hora: <span><span><?php 	echo $cita->hora ?></span></p>
					<p>Cliente: <span><?php 	echo $cita->cliente ?></span></p>
					<p>Email: <span><?php 		echo $cita->email ?></span></p>
					<p>Telefono: <span><?php 	echo $cita->telefono ?></span></p>
					<h3>Servicios</h3>
					<?php 
			} //Fin de IF 
				$total +=	$cita->precio;
			?>
					
			<p class="servicios"><?php echo $cita->servicio . " " . 
			$cita->precio; ?> </p>
			
			<?php
				$actual		=	$cita->id;
				$proximo	=	$citas[$key + 1]->id ?? 0;
				if(isLast($actual, $proximo))
				{ ?>
					<p class="total">Total: <span> <?php echo formatearMoneda($total); ?></span></p>

					<form action="api/eliminar" method="POST">
						<input type="hidden" name="id" value="<?php echo $cita->id; ?>" >
						<input type="submit"  class="boton-eliminar" value="Elimiar"></input>
					</form>
				<?php
				}
			?>

		<?php } // Fin de Foreach ?>
	</ul>
</div>

<?php	
	$script	= "<script src='build/js/buscador.js'></script>";
?>