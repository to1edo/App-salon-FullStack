<h1 class="nombre-pagina">Restablecer tu password</h1>
<p class="descripcion-pagina">Escribe tu nuevo password a continuacion.</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php"
?>

<?php if(!$error):?>
<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Tu nuevo password" name="password">
    </div>

    <input class="boton" type="submit" value="Restablecer password">
</form>
<?php endif; ?>

<div class="acciones">
    <a href="/crear-cuenta"> No tienes cuenta? Crear Una</a>
    <a href="/">Si ya tienes cuenta, Inicia sesion</a>
</div>