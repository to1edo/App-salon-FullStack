<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesion con tus datos</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php"
?>

<form class="formulario" method="POST" action="/">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Tu email" name="email">
    </div>

    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Tu password" name="password">
    </div>

    <input class="boton" type="submit" value="Iniciar sesion">
</form>

<div class="acciones">
    <a href="/crear-cuenta"> No tienes cuenta? Crear Una</a>
    <a href="/olvide">Olvidaste tu password?</a>
</div>