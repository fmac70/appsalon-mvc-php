<h1 class="nombre-pagina">Olvide Password</h1>
<p class="descripcion-pagina">Completa el Formulario para Recuperar Password</p>

<?php 
	if($alertas)
		include	__DIR__ . "/../templates/alertas.php";
?>

<?php
	if($error)	return;
?>


<form class="formulario" method='POST'>
    <div class="campo">
		<label for ="password">Password</label>
		<input
			type		=	"password"
			id 			=	"password"
			placeholder	=	"Tu password"
			name		=	"password"
		/>
	</div>
    <input type="submit" class="boton" value="Guardar Nuevo Password">
</form>
<div class="acciones">
		<a href="/">Iniciar Session</a>
        <a href="/crear-cuenta">¿Aún  no tienes cuenta? Crear Cuenta</a>
</div>