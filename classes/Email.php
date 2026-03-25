<?php
namespace	Classes;

use	PHPMailer\PHPMailer\PHPMailer;

class	Email
{
	public	$email;
	public	$nombre;
	public	$token;

	public	function	__construct($email, $nombre, $token)
	{
		$this->email	=	$email;
		$this->nombre	=	$nombre;
		$this->token	=	$token;

	}

	public	function	enviarConfirmacion()
	{
		//	Crear el Email

		$mail = new PHPMailer();
		$mail->isSMTP();
		//$mail->Host = 'live.smtp.mailtrap.io';
		$mail->Host = $_ENV['EMAIL_HOST'];
		$mail->SMTPAuth = true;
		//$mail->Port = 587;
		$mail->Port =  $_ENV['EMAIL_HOST'];
		//$mail->Username = 'api';
		$mail->Username = $_ENV['EMAIL_USER'];
		//$mail->Password = 'fa2db3253e8b046d533257eca2dc2d80';
		$mail->Password = $_ENV['EMAIL_PASS'];


		$mail->setfrom('cuentas@appsalon.com');
		$mail->addAddress('fmac70@gmail.com', 'Appsalon.com');
		$mail->subject = 'Confirma tu cuenta';

		// Set HTML
         $mail->isHTML(TRUE);
         $mail->CharSet = 'UTF-8';

         $contenido = '<html>';
         $contenido .= "<p><strong>Hola " . $this->email .  "</strong> Has Creado tu cuenta en App Salón, solo debes confirmarla presionando el siguiente enlace</p>";
         //$contenido .= "<p>Presiona aquí: <a href='http://localhost:3000/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a>";        
		 $contenido .= "<p>Presiona aquí: <a href='" . $_ENV['APP_URL'] . "/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a>";        
         $contenido .= "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje</p>";
         $contenido .= '</html>';
         $mail->Body = $contenido;
		//debuguear($mail->Body);

         //Enviar el mail
         $mail->send();
		 //debuguear($mail->Body);
	}

	public	function	enviarInstrucciones()
	{
		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->Host = 'live.smtp.mailtrap.io';
		$mail->SMTPAuth = true;
		$mail->Port = 587;
		$mail->Username = 'api';
		$mail->Password = 'fa2db3253e8b046d533257eca2dc2d80';

		$mail->setfrom('cuentas@appsalon.com');
		$mail->addAddress('fmac70@gmail.com', 'Appsalon.com');
		$mail->subject = 'Recuperar tu password';

		// Set HTML
         $mail->isHTML(TRUE);
         $mail->CharSet = 'UTF-8';

         $contenido = '<html>';
         $contenido .= "<p><strong>Hola " . $this->nombre .  "</strong> Has Solicitado restablecer tu password en App Salón, solo debes confirmarla presionando el siguiente enlace</p>";
         //$contenido .= "<p>Presiona aquí: <a href='http://localhost:30h00/recuperar?token=" . $this->token . "'>Recuperar Password</a>";        
		 $contenido .= "<p>Presiona aquí: <a href='" . $_ENV['APP_URL'] . "/recuperar?token=" . $this->token . "'>Recuperar Password</a>";        
         $contenido .= "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje</p>";
         $contenido .= '</html>';
         $mail->Body = $contenido;
		//debuguear($mail->Body);

         //Enviar el mail
         $mail->send();
		 debuguear($mail->Body);
	}

	//	Con Gmail
	

}
