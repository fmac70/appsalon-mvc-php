<?php
	namespace Controllers;

use	MVC\Router;
use	Model\Servicio;
use	Model\Cita;
use	Model\CitaServicio;

class	APIController
{

	public	static	function	index(Router	$router)
	{
		
		$servicios	= Servicio::all();
		echo json_encode($servicios);		
	}

	public	static	function	guardar()
	{
		//	Almacena la Cita y devuelve el id para la tabla citaservicio
		$cita		=	new	Cita($_POST);
		$resultado	=	$cita->guardar();

		$id			=	$resultado['id'];

		//	Almacena la cita el servicio en la tabla citaservicio
		$idServicios	=	explode(",", $_POST['servicios']);
		foreach($idServicios as $idServicio)
		{
			$args	=	[
				'citaId' 		=>	$id,
				'servicioId'	=>	$idServicio
			];
			$citaServicio	=	new CitaServicio($args);
			$citaServicio -> guardar();
		}
		//	Retornamos la respuesta
		$respuesta	=	[
			'resultado'	=>	$resultado
		];
		echo	json_encode($respuesta);
	}

	public	static	function	eliminar()
	{
		if($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			//$citaId	= $_POST['id'];
			$cita	= Cita::find($_POST['id']);
			$cita->eliminar();
			/*
			if ($cita->eliminar())
			{
				$sql = "delete from citasservicios where citaId = $citaId";
				$debuguear($sql);
				$resultado = $cita->sql($sql);
			}
			*/
			header('Location:' . $_SERVER['HTTP_REFERER']);
		}
			
		
	}
}	