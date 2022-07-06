<div class="barra">
    
    <div class="user">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
        </svg>
        <p><?php echo $_SESSION['nombre'];?></p>
    </div>

    <div class="logout">
        <a href="/logout">Cerrar sesion
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
        </svg>
        </a>
    </div>
</div>

<?php if(isset($_SESSION['admin'])){  ?>
        <div class="barra-servicios">
            <a href="/admin" class="boton">Citas</a>
            <a href="/servicios" class="boton">Servicios</a>
            <a href="/servicios/crear" class="boton">Nuevo servicio</a>
        </div>    
<?php } ?>