<<<<<<< HEAD
<?php
    foreach($alertas as $key => $mensajes):
        foreach($mensajes as $mensaje):
?>

    <div class="alerta <?php echo $key; ?>">
        <?php echo $mensaje; ?>
    </div>

<?php 
        endforeach;
    endforeach;
=======
<?php
    foreach($alertas as $key => $mensajes):
        foreach($mensajes as $mensaje):
?>

    <div class="alerta <?php echo $key; ?>">
        <?php echo $mensaje; ?>
    </div>

<?php 
        endforeach;
    endforeach;
>>>>>>> e73ab30300cfd69d1106b720a967b4488360ea44
?>