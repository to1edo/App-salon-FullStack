<h1 class="nombre-pagina">Panel de administracion</h1>

<?php
    include_once __DIR__ . '/../templates/barra.php';
?>

<h2>Buscar citas</h2>
<div class="busqueda">
    <form method="POST" class="formulario" enctype="multipart/form-data">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha;?>" />
        </div>
        <input id="buscador-admin" class="boton" type="submit" value="Buscar">
    </form>
</div>

<p class="text-center"><?php echo $mensaje; ?></p>

<div id="citas-admin">
    <ul class="citas">
        <?php $citaId = 0; ?>
        <?php foreach($citas as $key => $cita){ ?>

            <?php if($citaId != $cita->id) { ?>
                <li>
                    <?php $total=0; ?>
                    <p><span>ID: </span><?php echo $cita->id?></p>
                    <p><span>Hora: </span><?php echo $cita->hora?></p>
                    <p><span>Cliente: </span><?php echo $cita->cliente?></p>
                    <p><span>Email: </span><?php echo $cita->email?></p>
                    <p><span>Telefono: </span><?php echo $cita->telefono?></p>
                    <h3>Servicios</h3>
            
            <?php $citaId = $cita->id; };  //endif ?>
                    <div class="servicios">
                        <p ><?php echo $cita->servicio?></p>
                        <p >$<?php echo $cita->precio?></p>
                        <?php $total+=$cita->precio; ?>
                    </div>
                    <?php 
                        $idActual = $cita->id;
                        $idProximo = $citas[$key+1]->id ?? 0;
                        if($idActual !== $idProximo){ ?>
                            <p class="total"><span>Total: </span>$<?php echo $total?></p>
                            <form action="/api/eliminar" method="POST">
                                <input type="hidden" name="id" value="<?php echo $cita->id?>">
                                <input id="eliminar" class="boton-rojo" type="submit" value="Eliminar cita">
                            </form>
                    <?php }; ?>
                
                
        <?php }; //endforeach ?>
                </li>
    </ul>
</div>


<?php 
    $script = "
        <script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/admin.js'></script>
    ";
?>