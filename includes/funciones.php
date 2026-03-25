<?php

function debuguear($variable) : string {
	echo "<pre>";
	var_dump($variable);
	echo "</pre>";
	exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
	$s = htmlspecialchars($html);
	return $s;
}

//	Funcion que comprueba que el usurio está autenticado y evita acceder a api
function	isAuth():void
{
	if(!isset($_SESSION['login']))
		header('Location: /');
}

function	isLast(string	$actual, string	$proximo): bool
{
	if($actual !== $proximo)
		return true;

	return	false;
}

function	isAdmin():void
{
	if(!isset($_SESSION['admin']))
		header('Location: /');
}

//	Bola Extra
function formatearMoneda($numero) {
    // Convertir coma decimal a punto para poder tratarlo como número
    $numero = str_replace(',', '.', $numero);

    // Convertir a float
    $numero = floatval($numero);

    // Formatear número: 2 decimales, coma decimal, punto miles
    $formateado = number_format($numero, 2, ',', '.');

    // Añadir símbolo €
    return $formateado . ' €';
}