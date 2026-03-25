<?php
namespace   Controllers;
use	MVC\Router;
use	Model\Usuario;
use	Classes\Email;

class	LoginController 
{
	public	static	function	login(Router $router)
	{
		$alertas	=	[];
		if($_SERVER['REQUEST_METHOD']	===	'POST')
		{
			$auth		= 	new	Usuario($_POST);
			$alertas	=	$auth->validarLogin();

			if(empty($alertas))
			{
				$usuario	=	Usuario::where('email', $auth->email);
				if($usuario)
				{
					//verificar el password
					if($usuario->comprobarPassword($auth->password))
					{
						session_start();

						$_SESSION['id']			=	$usuario->id;
						$_SESSION['nombre']		= 	$usuario->nombre . " " . $usuario->apellido;
						$_SESSION['email']		=	$usuario->email;
						$_SESSION['login']		=	true;

						//	Redireccionar
						if($usuario->admin	=== '1')
						{
							$_SESSION['admin']	= $usuario->admin ?? null;
							header('Location: /admin');
						}
						else{
							header('Location: /cita');
						}
						
					}
				}else{
					Usuario::setAlerta('error', 'Usuario no encontrado');
				}
					
			}



		}
		$alertas	= Usuario::getAlertas();
		$router->render('auth/login',
		[
			'alertas'	=>	$alertas
		]);
	}

	public	static	function	logout()
	{
		session_start();
		$_SESSION =	[];
		header('Location: /');

	}

	public	static	function	olvide(Router $router)
	{
		
		$alertas	=	[];

		if($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$auth		=	new	Usuario($_POST);
			$alertas	= 	$auth->validarEmail();

			if(empty($alertas))
			{
				$usuario	= Usuario::where('email', $auth->email);
				if($usuario && $usuario->confirmado === '1')
				{
					//	Crear un token unico
					$usuario->crearToken();
					$usuario->guardar();
					
					// Enviar email con insturcciones

					$email	=	new	Email($usuario->email, $usuario->nombre, $usuario->token);
					$email->enviarInstrucciones();
					//	Enviar alerta con exito
					Usuario::setAlerta('exito', 'Revisa tu email y sigue las intrucciones');
				}else {
					Usuario::setAlerta('error', 'El usuario no existe o no está confirmado');
					
				}
				
			}
		}
		$alertas	= Usuario::getAlertas();
		$router->render('auth/olvide-password', 
		[
			'alertas' =>	$alertas
		]);
	}
	
		public	static	function	recuperar(Router $router)
	{
		$error		=	false;
		$alertas	=	[];
		$token		= 	s($_GET['token']);
		
		//$auth		=	new	Usuario($_POST);
		//$alertas	= 	$auth->validarEmail();

		//Buscar el usuario por su token;
		$usuario	=	Usuario::where('token', $token);
		
		if(empty($usuario))
		{
			Usuario::setAlerta('error', 'Tolen no valido');
			$error	=	true;
		}


		if($_SERVER['REQUEST_METHOD']	=== 'POST')
		{
			//	Leer nuevo Password y Guardarlo
			$password	=	new Usuario($_POST);
			$alertas	=	$password->validarPassword();
			
			if(empty($alertas))
			{
				$usuario->password 	= 	null;
				$usuario->password 	=	$password->password;
				$usuario->hashPassword();
				$usuario->token 	=	null;
				$resultado	=	$usuario->guardar();
				if($resultado)
				{
					header('Location: /');
				}

			}

		}

	
		$alertas	= Usuario::getAlertas();		
		$router->render('auth/recuperar', 
		[
			'alertas' => $alertas,
			'error'	  => $error
		]);
	}

	public	static	function	crear(Router $router)
	{
		$usuario	=	new	Usuario;
		$alertas	=	[];
		if($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$usuario->sincronizar($_POST);

			//	Validar Datos
			$alertas	=	$usuario->validarNuevaCuenta();

			//	Comprobar si el correo exite
			if(empty($alertas)) //Si no hay errores
			{
				$resultado	=	$usuario->existeUsuario();
				if($resultado->num_rows)
				{
					$alertas	=	Usuario::getAlertas();
				}else{
					//	Hashear el password
					$usuario->hashPassword();
					//	Generar Token Unico
					$usuario->crearToken();
					//	Enviar el Email
					$email	=	new	Email($usuario->email, $usuario->nombre, $usuario->token);
					$email->enviarConfirmacion();
					//	Crear el Usuario
					$resultado	=	$usuario->guardar();
					if($resultado)
						header('Location: /mensaje');
					//debuguear($usuario);
				}
					
			}
			
		}
		$router->render('auth/crear-cuenta', 
		[
			'usuario' =>	$usuario,
			'alertas' =>	$alertas
		]);
	}

	public	static	function	mensaje(Router $router)
	{
		$router->render('auth/mensaje');
	}

	public	static	function	confirmar(Router $router)
	{
		$alertas	= 	[];
		$token		= 	s($_GET['token']);
		$usuario	=	Usuario::where('token', $token);
		
		if(empty($usuario))
		{
			//	Mostrar mensaje de error
			Usuario::setAlerta('error', 'Token no valido');
			
		}else {
			//	Cambiar el usuario a confirmado
			$usuario->confirmado	= "1";
			$usuario->token			= null;
			
			$usuario->guardar();
			Usuario::setAlerta('exito', 'Cuenta Creada y Validada Correctamente');

		}

		$alertas	=	Usuario::getAlertas();
		$router->render('auth/confirmar-cuenta',
		[
			'alertas'	=>	$alertas,
			'token'		=>	$token
		]);
		
	}
}