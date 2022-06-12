<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/asistenciaSalida.css">
    <title>toma de asistencia</title>
</head>

<body>

    <?php 

date_default_timezone_set("America/El_Salvador");

$fechaHoy=date("Y-m-d h:i:s");



$hora = $_POST['hora'];
echo $hora;
session_start();
if(isset($_POST['botonGuardar'])){
    $nombre = $_POST['nombreUser_in'];
    

    echo  "se registro la hora de entrada de ",$nombre, " a la hora de " , $hora;
}

?>

    <div class="asistenciaContent">


        <div class="contenido">

            <form action="registroAsistencia.php" method="post" class="formulario">
                <div class="tiempo">
                    <label for="hora" class="texto">Fecha:</label>
                    <input type="datetime" class="fechaHora" name="hora" id="hora" value="<?=$fechaHoy?>" disabled>
                </div>
                <fieldset>
                    <h4>Asistencia - Salida </h4>
                    <div class="datos">

                        <div class="nombre">
                            <input type="hidden" name="nombreUser_in" value="<?php echo $_SESSION['miNombre']?>">
                            <label class="username" name="nombreUser"><?php echo $_SESSION['miNombre'] ?></label>
                        </div>

                        <div class="opciones">
                            <input type="radio" name="presente" value="1" id="presente">
                            <label for="presente" class="texto">Marcar</label>
                        </div>
                    </div>
                    <div class="generalfrom">
                        <button type="submit" class="btn" name="botonGuardar">Guardar</button>
                    </div>
                </fieldset>
            </form>
        </div>



    </div>


</body>

</html>