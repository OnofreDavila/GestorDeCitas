<<<<<<< HEAD
<div class="barra">
    <p>Hola: <?php echo $nombre ?? ''; ?></p>
    <a href="/logout">Cerrar Sesión</a>
</div>

<?php if(isset($_SESSION['admin'])) { ?>
    <div class="barra-servicios">
        <a class="boton" href="/admin">Ver Citas</a>
        <a class="boton" href="/servicios">Ver Servicios</a>
        <a class="boton" href="/servicios/crear">Nuevo Servicio</a>
    </div>
=======
<div class="barra">
    <p>Hola: <?php echo $nombre ?? ''; ?></p>
    <a href="/logout">Cerrar Sesión</a>
</div>

<?php if(isset($_SESSION['admin'])) { ?>
    <div class="barra-servicios">
        <a class="boton" href="/admin">Ver Citas</a>
        <a class="boton" href="/servicios">Ver Servicios</a>
        <a class="boton" href="/servicios/crear">Nuevo Servicio</a>
    </div>
>>>>>>> e73ab30300cfd69d1106b720a967b4488360ea44
<?php } ?>