<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia Session con tus datos</p>

<?php 
	if($alertas)
		include	__DIR__ . "/../templates/alertas.php";
?>

<form class="formulario" method='POST' action="/">
	<div class="campo">
		<label for ="email">Email</label>
		<input
			type		=	"email"
			id 			=	"email"
			placeholder	=	"Tu email"
			name		=	"email"

		/>
	</div>

	<div class="campo">
		<label for="password">Password</label>
		<input
			type		=	"password"
			id			=	"password"
			placeholder	=	"Tu password"
			name		=	"password"
		>
	</div>
	<input	type="submit" class="boton" value= "Iniciar Session">

	<div class="acciones">
		<a href="/crear-cuenta">¿Aún  no tienes cuenta? Crear Cuenta</a>
		<a href="/olvide">¿Olvidaste tu  cuenta? Recuperar Cuenta</a>

	</div>
</form>