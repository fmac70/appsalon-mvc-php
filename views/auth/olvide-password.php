<h1 class="nombre-pagina">Olvide Password</h1>
<p class="descripcion-pagina">Completa el Formulario para Recuperar Password</p>

<?php 
	if($alertas)
		include	__DIR__ . "/../templates/alertas.php";
?>

<form class="formulario" method='POST' action="/olvide">
	<div class="campo">
		<label for ="email">Email</label>
		<input
			type		=	"email"
			id 			=	"email"
			placeholder	=	"Tu email"
			name		=	"email"
		/>
	</div>


	<input	type="submit" class="boton" value= "Enviar">

	<div class="acciones">
		<a href="/crear-cuenta">¿Aún  no tienes cuenta? Crear Cuenta</a>
		<a href="/olvide">¿Olvidaste tu  cuenta? Recuperar Cuenta</a>

	</div>
</form>