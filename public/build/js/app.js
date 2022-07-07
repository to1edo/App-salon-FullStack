let paso = 1;

const paginadorIncial = 1;
const paginadorFinal = 3;

const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();

});


function iniciarApp(){

    mostrarSeccion();
    tabs(); //cambia entre secciones
    botonesPaginador();
    paginaSiguiente(); 
    paginaAnterior();

    //API para servicios
    consultarAPI();
    idCliente();
    nombreCliente(); //anade el nombre del cliente en el objeto cita
    seleccionarFecha(); //anade la fecha de la cita en el objeto
    seleccionarHora();//anade la hora de la cita en el objeto

    mostrarResumen();
    
}

function mostrarSeccion(){

    //seleccionar la seccion visible actual
    const seccionAnterior = document.querySelector('.mostrar');
    if(seccionAnterior){
        seccionAnterior.classList.remove('mostrar');
    }

    //seleccionar la seccion con el paso al que se dio click
    const seccion = document.querySelector(`#paso-${paso}`);
    seccion.classList.add('mostrar');


    //cambiar color de tab actual
    const tabAnterior = document.querySelector('.actual');
    if(tabAnterior){
        tabAnterior.classList.remove('actual');
    }

    const tabActual = document.querySelector(`[data-paso="${paso}"]`);
    tabActual.classList.add('actual');
}

function tabs(){
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach(function(boton){
        boton.addEventListener('click',function(e){
            paso = parseInt(e.target.dataset.paso);

            mostrarSeccion();
            botonesPaginador();
        })
    });
}

function botonesPaginador(){
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    if(paso === 1){
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }else if(paso === 3){
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');
        
        mostrarResumen();
    }else{
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }

    mostrarSeccion();
}

function paginaAnterior(){
    const paginaAnterior = document.querySelector('#anterior');

    paginaAnterior.addEventListener('click', function(){

        if(paso <= paginadorIncial) return;
        paso--;
        botonesPaginador();
    });
}

function paginaSiguiente(){

    const paginaSiguiente = document.querySelector('#siguiente');

    paginaSiguiente.addEventListener('click', function(){

        if(paso >= paginadorFinal) return;
        paso++;
        botonesPaginador();
    });
}


async function consultarAPI(){

    try {
        const url = 'http://agile-wave-82507.herokuapp.com/api/servicios';
        const resultado = await fetch(url);
        const servicios = await resultado.json();

        console.log(servicios)
        mostrarServicios(servicios);

    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios(servicios){

    servicios.forEach(function(servicio){
        const {id,nombre,precio} = servicio;
        
        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent =`$${precio}`;

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick = function(){
            seleccionarServicio(servicio);
        }

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        const listadoServicios  = document.querySelector('.listado-servicios');
        listadoServicios.appendChild(servicioDiv);
    });
}


function seleccionarServicio(servicio){
    
    const {id} = servicio;
    const {servicios} = cita;
    
    const servicioDiv = document.querySelector(`[data-id-servicio="${id}"]`);
    
    // comprobar si el servicio ya fue agregado
    if( servicios.some(agregado => agregado.id === id) ){
        cita.servicios = servicios.filter(agregado => agregado.id != id);
    }else{
       cita.servicios = [...servicios, servicio];
    }

    servicioDiv.classList.toggle('seleccionado');
}

function idCliente(){
    cita.id = document.querySelector('#id').value;

}

function nombreCliente(){
    cita.nombre = document.querySelector('#nombre').value;

}

function seleccionarFecha(){
    const inputFecha = document.querySelector('#fecha');

    inputFecha.addEventListener('input', function(e){
        
        const dia = new Date(e.target.value).getUTCDay();

        if([6,0].includes(dia)){
            e.target.value = '';
            mostrarAlerta('Fines de semana no permitidos','error','.formulario');
        }else{
            cita.fecha = e.target.value;

            const alerta = document.querySelector('.alerta.error');
            if(alerta){
                alerta.remove();
            }
        }
    });
}

function seleccionarHora(){
    const inputHora = document.querySelector('#hora');

    inputHora.addEventListener('input',function(e){

        const horaCita = e.target.value;

        const hora = horaCita.split(':')[0]; //obtiene solo el valor de la hora y seprara los minutos

        if(hora <10 || hora >18){
            mostrarAlerta('Hora no valida, nuestro horario es de 10:00 a 18:00','error','.formulario');
            e.target.value = ''; 
        }else{
           cita.hora = horaCita;
        }
    });
}


function mostrarAlerta(mensaje, tipo, elemento, desaparece = true){

    const alertaPrevia = document.querySelector('.alerta');
    if(alertaPrevia){
        alertaPrevia.remove();
    }

    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);
    
    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    if(desaparece){
        setTimeout(()=>{
            alerta.remove();
        },3000);
    }
}


function mostrarResumen(){

    //verificar si hay datos faltantes
    if(Object.values(cita).includes("") || cita.servicios.length == 0){

        if(Object.values(cita).includes("")){
            mostrarAlerta('Falta el horario de la cita','error','.contenido-resumen',false);
        }

        if(cita.servicios.length == 0){
            mostrarAlerta('Falta seleccionar al menos un servicio','error','.contenido-resumen',false);
        } 

    }else{

        //mostrar resumen

        const resumen = document.querySelector('.contenido-resumen');
        const citaPrevia = document.querySelector('.cita-container');

        if(citaPrevia){
            citaPrevia.remove();
        }

        const citaContainer = document.createElement('DIV');
        citaContainer.classList.add('cita-container');
        resumen.appendChild(citaContainer);


        //titulo para la cita
        const tituloCita = document.createElement('P');
        tituloCita.innerHTML ='<p class="text-center bold">Datos de la cita</P>';
        citaContainer.appendChild(tituloCita);

        const {nombre, fecha,hora, servicios} = cita;

        const nombreCliente = document.createElement('P');
        nombreCliente.innerHTML = `<span class="resaltado">Nombre:  </span>${nombre}`;
        citaContainer.appendChild(nombreCliente);


        // Formatear la fecha en español
        const fechaObj = new Date(fecha);
        const mes = fechaObj.getMonth();
        const dia = fechaObj.getDate() + 2;
        const year = fechaObj.getFullYear();

        const fechaUTC = new Date( Date.UTC(year, mes, dia));
        
        const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'}
        const fechaFormateada = fechaUTC.toLocaleDateString('es-MX', opciones);

        const fechaCita = document.createElement('P');
        fechaCita.innerHTML = `<span class="resaltado">Fecha:  </span>${fechaFormateada}`;
        citaContainer.appendChild(fechaCita);

        const horaCita = document.createElement('P');
        horaCita.innerHTML = `<span class="resaltado">Hora:  </span>${hora} horas`;
        citaContainer.appendChild(horaCita);

        //titulo para los servicios
        const tituloServicios = document.createElement('P');
        tituloServicios.innerHTML ='<p class="text-center bold">Servicios seleccionados</P>';
        citaContainer.appendChild(tituloServicios);

        let total = 0;

        servicios.forEach(function(servicio){
            const {nombre,precio} = servicio;
            
            const nombreServicio = document.createElement('P');
            nombreServicio.classList.add('nombre-servicio');
            nombreServicio.textContent = nombre;
    
            const precioServicio = document.createElement('P');
            precioServicio.classList.add('precio-servicio');
            precioServicio.textContent =`$${precio}`;
            total = total + parseInt(precio);

            const servicioDiv = document.createElement('DIV');
            servicioDiv.classList.add('servicio');
            servicioDiv.classList.add('resumen');
            
    
            servicioDiv.appendChild(nombreServicio);
            servicioDiv.appendChild(precioServicio);
            citaContainer.appendChild(servicioDiv);
        });

        const precioTotal = document.createElement('P');
        precioTotal.innerHTML = `<p class="monto-total">Monto total: <span class="precio-servicio">$${total}</span></p>`;
        citaContainer.appendChild(precioTotal);

        const botonReservar = document.createElement('BUTTON');
        botonReservar.classList.add('boton');
        botonReservar.textContent = 'Reservar cita';
        citaContainer.appendChild(botonReservar);

        botonReservar.onclick = reservaCita;
    }
}

async function reservaCita(){

    const {nombre,fecha,hora,servicios,id} = cita;
    const idServicios = servicios.map( servicio => servicio.id );

    const datos = new FormData();
    datos.append('fecha',fecha);
    datos.append('hora',hora);
    datos.append('servicios',idServicios);
    datos.append('usuarioId',id);
    
    try {
        const url = 'https://agile-wave-82507.herokuapp.com/api/citas';
        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });

        const resultado = await respuesta.json();
        
        if(resultado.resultado){
            Swal.fire(
                'Tu cita fue reservada con exito!',
                'Te esperamos pronto',
                'success'
            ).then( ()=>{
                window.location.reload();
            })
        }
    } catch (error) {

        Swal.fire(
            'Ocurrio un error en la reserva de la cita',
            'Intenta mas tarde',
            'error'
        ).then( ()=>{
            window.location.reload();
        })
    }

}

