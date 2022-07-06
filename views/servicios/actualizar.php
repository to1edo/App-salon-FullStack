<h1 class="nombre-pagina">Actualizar servicios</h1>
<p class="descripcion-pagina">Verifica los campos del formulario</p>

<?php include __DIR__ . '/../templates/barra.php'; ?>



<p class="text-center">Formulario de actualizacion</p>

<?php include_once __DIR__ .'/../templates/alertas.php'; ?>

<form action="/servicios/actualizar" method="POST" class="formulario">
<?php include_once __DIR__ .'/formulario.php'; ?>

<input type="hidden"  value="<?php echo $servicio->id;?>" name="id">
<input type="submit" class="boton" value="Actualizar servicio">
</form>