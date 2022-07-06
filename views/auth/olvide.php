<h1 class="nombre-pagina">Olvide mi password</h1>
<p class="descripcion-pagina">Recupera tu password escribiendo tu email aqui:</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php"
?>

<form class="formulario" method="POST" action="/olvide">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Tu email" name="email">
    </div>

    <input class="boton" type="submit" value="Recuperar password">
</form>


<div class="acciones">
    <a href="/crear-cuenta"> No tienes cuenta? Crear Una</a>
    <a href="/">Si ya tienes cuenta, Inicia sesion</a>
</div>