<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Completa el Formulario para Crear una Cuenta</p>

<?php 
	if($alertas)
		include	__DIR__ . "/../templates/alertas.php";
?>

<form class="formulario" method="POST" action="/crear-cuenta">
	<div class="campo">
		<label for ="nombre">Nombre</label>
		<input
			type		=	"text"
			id 			=	"nombre"
			name		=	"nombre"
			placeholder	=	"Tu nombre"
			value		=	"<?php echo s($usuario->nombre); ?>"
		/>
	</div>

	<div class="campo">
		<label for ="apellido">Apellidos</label>
		<input
			type		=	"text"
			id 			=	"apellido"
			placeholder	=	"Tus apellidos"
			name		=	"apellido"
			value		=	"<?php echo s($usuario->apellido); ?>"
		/>
	</div>

		<div class="campo">
		<label for ="telefono">Telefono</label>
		<input
			type		=	"tel"
			id 			=	"telefono"
			placeholder	=	"Tu telefono"
			name		=	"telefono"
			value		=	"<?php echo s($usuario->telefono); ?>"
		/>
	</div>

	<div class="campo">
		<label for ="email">Email</label>
		<input
			type		=	"email"
			id 			=	"email"
			placeholder	=	"Tu email"
			name		=	"email"
			value		=	"<?php echo s($usuario->email); ?>"
		/>
	</div>

	<div class="campo">
		<label for="password">Password</label>
		<input
			type		=	"password"
			idate		=	"password"
			placeholder	=	"Tu password"
			name		=	"password"
			value		=	"<?php echo s($usuario->password); ?>"
		>
	</div>

	<input	type="submit" class="boton" value= "Crear Cuenta">

	<div class="acciones">
		<a href="/">Iniciar Session</a>
		<a href="/olvide">¿Olvidaste tu  cuenta? Recuperar Cuenta</a>

	</div>
</form>
