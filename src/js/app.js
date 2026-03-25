let		paso		=	1;
const 	pasoInicial	=	1;
const 	pasoFinal	=	3;
const	cita	= {
		id:		'',
		nombre: '',
		fecha:	'',
		hora:	'',
		servicios: []
}

document.addEventListener('DOMContentLoaded', function()
{
	iniciarApp();
});

function	iniciarApp()
{
	mostrarSeccion();	//	Muestra y oculta las sessiones
	tabs()				//	Cambiar la sessión de tap al paso siguiente
	botonesPaginador();	//	Agregar o quitar los botones del paginador
	paginaSiguiente();	
	paginaAnterior();
	consultarApi();
	idCliente();		//	Añade el id de usuario al campo id de cita
	nombreCliente();	//	Busca el nombre del usuario
	seleccionarFecha();	//	Añade la fecha a la cita
	seleccionarHora();	//	Añadir la hora a la cita
	mostrarResumen();	//	Muestra el resumen de los servicios contratado
}

function	mostrarSeccion()
{
	//	Ocultar la seccion que tenga la clase mostrar y este visible
	const	sessionAnterior	= document.querySelector(`.mostrar`);
	if(sessionAnterior)
		sessionAnterior.classList.remove('mostrar');

	//	Selecionar la session con el paso del click
	const	pasoSelector	= `#paso-${paso}`;
	const	seccion			=	document.querySelector(pasoSelector);
	seccion.classList.add('mostrar');

	//	Qutia la clase de actual (le quita el fondo azul al marco anterioremente)
	const	tabAnterior	= document.querySelector('.actual');
	if(tabAnterior)
		tabAnterior.classList.remove('actual');


	//	Resaltar la session actual (cambia el fondo del tab seleccionado)
	const	tab	=	document.querySelector(`[data-paso="${paso}"]`);
	tab.classList.add('actual');
}

function	tabs()
{
	const	botones=document.querySelectorAll('.tabs button');
	botones.forEach( boton => 
		{
			boton.addEventListener('click', function(e)
				{
					paso = parseInt(e.target.dataset.paso)
					mostrarSeccion();
					botonesPaginador();
					if(paso	= 3)
						mostrarResumen();
				})
		})
}

function	botonesPaginador()
{
	const	paginaSiguiente	=	document.querySelector('#siguiente');
	const	paginaAnterior	=	document.querySelector('#anterior');

	if(paso === 1)
	{
		paginaAnterior.classList.add('ocultar');
		paginaSiguiente.classList.remove('ocultar');
	}else if(paso === 3)
		{
			paginaAnterior.classList.remove('ocultar');
			paginaSiguiente.classList.add('ocultar');
			mostrarResumen();
		}

	if(paso	=== 2)
	{
		paginaAnterior.classList.remove('ocultar');
		paginaSiguiente.classList.remove('ocultar');
	}

	mostrarSeccion();
}	
	
function paginaSiguiente()
{
	const	paginaSiguiente	=	document.querySelector('#siguiente');
	paginaSiguiente.addEventListener('click', function(){
		if(paso >= pasoFinal) 
			return
		paso++;
		botonesPaginador();
	})
}

function paginaAnterior()
{
	const	paginaAnterior	=	document.querySelector('#anterior');
	paginaAnterior.addEventListener('click', function(){
		if(paso <= pasoInicial) 
			return
		paso--;
		botonesPaginador();
	})

}

async	function consultarApi()
{
	try {
		
		//const	url			=	'http://localhost:3000/api/servicios';
		const	url			=	`${location.origin}/api/servicios`;
		console.log (url);
		const	resultado	=	await	fetch(url);	
		const	servicios	=	await	resultado.json();
		mostrarServicios(servicios);
		
	} catch (error) {
		console.log(error);
		console.log("TENGO UN ERROR");
	}
}

function	mostrarServicios(servicios)
{
	servicios.forEach( servicio => {
		const	{ id, nombre, precio }	=	servicio;
		
		const	nombreServicio	=	document.createElement('P');
		nombreServicio.classList.add('nombre-servicio');
		nombreServicio.textContent	= nombre;
		
		const	precioServicio	=	document.createElement('P');
		precioServicio.classList.add('precio-servicio');
		precioServicio.textContent	=	precio + ' €';

		const	servicioDiv	=	document.createElement('DIV');
		servicioDiv.classList.add('servicio');
		servicioDiv.dataset.idServicio	=	id;
		servicioDiv.onclick	= function() {
			seleccionarServicio(servicio);
		};

		servicioDiv.appendChild(nombreServicio);
		servicioDiv.appendChild(precioServicio);

		document.querySelector('#servicios').appendChild(servicioDiv);
		
	});
}

function	seleccionarServicio(servicio)
{
	const	{id} = servicio;	
	const	{ servicios } = cita;

	//	identifica al elemento sobre el que hace click
	const	divServicio	=	document.querySelector(`[data-id-servicio="${id}"]`);

	//	Compruebo si un item ya fue selecionado
	if( servicios.some( agregado => agregado.id === servicio.id ) ){
		// Eliminarlo
		cita.servicios = servicios.filter (agregado => agregado.id != id);
		divServicio.classList.remove('seleccionado');

	}else {
		// Agregarlo
		cita.servicios = [...servicios, servicio];
		divServicio.classList.add('seleccionado');
	}
}

function	idCliente()
{
	cita.id	=	document.querySelector('#id').value;

}
function	nombreCliente()
{
	const	nombre	=	document.querySelector('#nombre').value;
	cita.nombre		=	nombre;
	
}

function 	seleccionarFecha()
{
	const	inputFecha	=	document.querySelector('#fecha');
	inputFecha.addEventListener('input', function(e){
		const	dia	= new	Date(e.target.value).getUTCDay();
		if([6, 0].includes(dia))
		{
			e.target.value	= '';
			mostarAlerta('Sabados y Domingo no permitido', 'error', ".formulario");
		}else {
			cita.fecha	=	e.target.value;
		}
	});

}

function	seleccionarHora()
{
	const	inputHora	=	document.querySelector('#hora');
	inputHora.addEventListener('input', function(e){
		
		const	horaCita	=	e.target.value;
		const	hora		=	horaCita.split(":")[0];
		const	minutos		=	horaCita.split(":")[1];

		if(hora < 10 || hora > 18)
		{
			e.target.value	=	'';
			mostarAlerta('hora no valida', 'error', '.formulario');
		}else {
			cita.hora	=	e.target.value;
		}
	})
}

function	mostarAlerta(mensaje, tipo, elemento, desaparece = true)
{
	//	Evita que se genere más de una alerta
	const	alertaPrevia=document.querySelector('.alerta');
	if(alertaPrevia) {
		alertaPrevia.remove();
	}

	//	Genera alerta si se ha selecionado un sabado o domigo
	const	alerta		=	document.createElement('DIV');
	alerta.textContent	= 	mensaje;
	alerta.classList.add('alerta');
	alerta.classList.add(tipo);

	const	referencia	=	document.querySelector(elemento);
	referencia.appendChild(alerta);

	//	Despues de 3sg. se elimina la alerta.
	if(desaparece){
		setTimeout(()=>{
		alerta.remove();
		},3000);
	}
}

function	mostrarResumen()
{
	const	resumen	=	document.querySelector('.contenido-resumen');
	
	//	Limpiar el contenido de resumen
	while(resumen.firstChild)
	{
		resumen.removeChild(resumen.firstChild);
	}

	if(Object.values(cita).includes('') || cita.servicios.length === 0){
		mostarAlerta('Falta Servicio o datos fecha y hora', 'error', '.contenido-resumen', false);
		return;
	}

	//	Formatear el Div de resumen
	const {nombre, fecha, hora, servicios}	=	cita;

	//	heading para los Servicios
	const	headingServicios	=	document.createElement('H3');
	headingServicios.textContent=	'Resumen de Servicios';
	resumen.appendChild(headingServicios);

	// Iterando y mostrando los servicios
	servicios.forEach (servicio => {
		const	{id, precio, nombre}	= 	servicio;
		const	contenedorServicio		=	document.createElement ('DIV');
		contenedorServicio.classList.add('contenedor-servicio');

		const	textoServicio		=	document.createElement('P');
		textoServicio.textContent	=	nombre;

		const	precioServicio		=	document.createElement('P');
		precioServicio.innerHTML	=	`<span>Precio:</span> ${precio}`;

		contenedorServicio.appendChild(textoServicio);
		contenedorServicio.appendChild(precioServicio);

		resumen.appendChild(contenedorServicio);
	})

	 // Heading para Cita en Resumen
	const	headingCita	=	document.createElement('H3');
	headingCita.textContent=	'Resumen de Servicios';
	resumen.appendChild(headingCita);


	const	nombreCliente	=	document.createElement('P');
	nombreCliente.innerHTML	=	`<span>Nonbre:</span> ${nombre}`;

	const	fechaCita	=	document.createElement('P');
	fechaCita.innerHTML	=	`<span>Fecha:</span> ${fecha}`;
	fechaCita.innerHTML	=	`<span>Fecha:</span> ${cambiarFormatoFecha(fecha)}`;
	
	const	horaCita	=	document.createElement('P');
	horaCita.innerHTML	=	`<span>Hora:</span> ${hora}`;

	//	Crear boton para reservar la cita
	const	botonReservar	=	document.createElement('BUTTON');
	botonReservar.classList.add('boton');
	botonReservar.textContent	=	'Confirmar Cita';
	botonReservar.onclick		=	reservarCita;

	resumen.appendChild(botonReservar);
	resumen.appendChild(nombreCliente);
	resumen.appendChild(fechaCita);
	resumen.appendChild(horaCita);
}

function cambiarFormatoFecha(cadena) {
  const [anio, mes, dia] = cadena.split('-');
  return `${dia}-${mes}-${anio}`;
}

async	function	reservarCita()
{
	const	{ nombre, fecha, hora, servicios, id }	=	cita;
	const	idServicios	=	servicios.map( servicio => servicio.id);
	const	datos	=	new FormData();

	
	datos.append('fecha', fecha);
	datos.append('hora', hora);
	datos.append('usuarioId', id);
	datos.append('servicios', idServicios);


	try {
		//	Peticion hacia la Api
		//const	url			=	'http://localhost:3000/api/citas';
		const	url			=	`${location.origin}/api/citas`;
		
		const	respuesta	=	await	fetch(url, {
			method: 'POST',
			body:	datos
		});

		const	resultado	=	await	respuesta.json();
		if(resultado.resultado)
		{
			Swal.fire({
				icon: "success",
				title: "Cita Creada",
				text: "Tu Cita se ha Creado Correctamente",
				button: 'OK',
				footer: ''
			}).then( ()=>{
				window.location.reload();
			});
		}	
	} catch (error) {
		Swal.fire({
			icon: "error",
			title: "Cita no Creada",
			text: "Hubo un error vuelva a intentarlo",
			footer: ''
			});
	}

}