<h1 class="nombre-pagina">Nuevo servicio</h1>
<p class="descripcion-pagina">Llena los campos del formulario</p>

<?php include_once __DIR__ . '/../templates/barra.php'; ?>

<p class="text-center">Formulario de registro</p>

<?php include_once __DIR__ .'/../templates/alertas.php'; ?>

<form action="/servicios/crear" method="POST" class="formulario">
<?php include_once __DIR__ .'/formulario.php'; ?>

<input type="submit" class="boton" value="Guardar servicio">
</form>