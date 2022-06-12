<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de asistencia</title>
    <link rel="stylesheet" href="./css/registroAsistencia.css">
</head>
<body>
    <?php
    require('admin.php');
    ?>

    <!-- inicia contindo principal -->
    <div class="main-asistencia">
        <h1>Registro de asistencia</h1>
        <?php
        
        date_default_timezone_set("America/El_Salvador");

        $fechaHoy=date("Y-m-d h:i:s");
        $fecha_e = $fechaHoy;
        $nombre;
        if(isset($_POST['nombreUser_in'])){
            $nombre = $_POST['nombreUser_in'];
            //echo  "se registro la hora de salida de ",$nombre, " a la hora de " , $fechaHoy;
        }
        echo "la hora de entrada de ",$nombre , " fue a la hora de ",$fechaHoy;
        ?>
    </div>
</body>
</html>