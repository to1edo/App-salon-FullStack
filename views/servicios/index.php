<h1 class="nombre-pagina">Servicios</h1>
<p class="descripcion-pagina">Administracion de servicios</p>

<?php include __DIR__ . '/../templates/barra.php'; ?>

<h3>Lista de servicios</h3>

<ul class="lista-servicios">
<?php foreach( $servicios as $servicio) { ?>
    <li>
    <p> <span>ID: </span>  <?php echo $servicio->id; ?></p>
    <p><span>Nombre: </span></p>
    <p> <?php echo $servicio->nombre; ?></p>
    <p> <span>Precio:  </span></p>
    <p> $<?php echo $servicio->precio; ?></p>

    <form action="/servicios/eliminar" method="POST">
        <input type="hidden" name="id" value="<?php echo $servicio->id?>">
        <input id="eliminar" class="boton-rojo" type="submit" value="Eliminar servicio">
    </form>

    <a class="boton-verde" href="/servicios/actualizar?id=<?php echo $servicio->id?>">Actualizar servicio</a>

<?php  } ?>
    </li>
</ul>