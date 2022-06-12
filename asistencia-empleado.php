<?php 

 require ("empleado.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/asistencia.css">
    <link rel="stylesheet" href="./css/asistenciaSalida.css">
    <link rel="stylesheet" href="./css/registroAsistencia.css">
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
        integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <title>toma de asistencia</title>
</head>

<body>

    <?php 


include("database.php");
date_default_timezone_set("America/El_Salvador");

$fechaHoy=date("Y-m-d h:i:s");



if(isset($_POST['botonGuardar-entrada'])){
    $nombre = $_POST['nombreUser_in'];
    $horaEntrada = $_POST['hora'];
    //$horaSalida = $_POST['hora'];
    $sql = "INSERT INTO asistenciaentrada (nombre,entrada) VALUES ('$nombre','$horaEntrada')";
    $query = $connect -> prepare($sql);
    $query -> execute();
    echo  "se registro la hora de entrada de ",$nombre, " a la hora de " , $horaEntrada;
    
}

if(isset($_POST['botonGuardar-salir'])){
    $nombre = $_POST['nombreUser_in'];
    $horaSalida = $_POST['hora'];
    //$horaSalida = $_POST['hora'];
    $sql = "INSERT INTO asistenciasalida (nombre,salida) VALUES ('$nombre','$horaSalida')";
    $query = $connect -> prepare($sql);
    $query -> execute();
    echo  "se registro la hora de salida de ",$nombre, " a la hora de " , $horaSalida;
    
}
//Eliminar entrada -->
if(isset($_POST['eliminar'])){
    
    $consulta = "DELETE FROM `asistenciaentrada` WHERE `id`=:id";
    $sql = $connect-> prepare($consulta);
    $sql -> bindParam(':id', $id, PDO::PARAM_INT);
    $id=trim($_POST['id']);

    $sql->execute();
                                
    if($sql->rowCount() > 0)
    {
    $count = $sql -> rowCount();
    echo "<div class='content alert alert-primary' > 
    Gracias: $count registro ha sido eliminado  </div>";
                                
    }else{
        echo "<div class='content alert alert-danger'> No se pudo eliminar el registro  </div>";
        print_r($sql->errorInfo()); 
    }
    //para la tabla salir
    $consultaSalida = "DELETE FROM `asistenciasalida` WHERE `id`=:id";
    $sqlSalida = $connect-> prepare($consultaSalida);
    $sqlSalida -> bindParam(':id', $id, PDO::PARAM_INT);
    $id=trim($_POST['id']);

    $sqlSalida->execute();
                                
    if($sqlSalida->rowCount() > 0)
    {
    $countSalida = $sqlSalida -> rowCount();
    echo "<div class='content alert alert-primary' > 
    Gracias: $countSalida registro ha sido eliminado  </div>";
                                
    }else{
        echo "<div class='content alert alert-danger'> No se pudo eliminar el registro  </div>";
        print_r($sql->errorInfo()); 
    }
                                
}// Cierra envio de guardado
                
?>
    <div class="asistencia-main">
        <div class="asistenciaContent">
            <div class="contenido">

                <form action="asistencia.php" method="post" class="formulario">
                    <div class="tiempo">
                        <label for="hora" class="texto">Fecha:</label>
                        <input type="datetime" class="fechaHora" name="hora" id="" value="<?=$fechaHoy?>">
                    </div>
                    <fieldset>
                        <h4>Asistencia - Entrada </h4>
                        <div class="datos">
                            <div class="nombre">
                                <input type="hidden" name="nombreUser_in" value="<?php echo $_SESSION['miNombre'] ?>">
                                <label class="username" name="nombreUser"><?php echo $_SESSION['miNombre'] ?></label>
                            </div>

                            <div class="opciones">

                                <input type="radio" name="presente" value="1" name="presente" id="presente">
                                <label for="presente" class="texto">Presente</label>
                            </div>

                        </div>

                        <div class="generalfrom">
                            <button type="submit" class="btn-asistencia" name="botonGuardar-entrada">Guardar</button>
                        </div>
                    </fieldset>

            </div>
            <!-- Para la salida -->
            <div class="contenido">

                <div class="tiempo">
                    <label for="hora" class="texto">Fecha:</label>
                    <input type="datetime" class="fechaHora" name="hora" id="" value="<?=$fechaHoy?>" disabled>
                </div>
                <fieldset>
                    <h4>Asistencia - Salida </h4>
                    <div class="datos">
                        <div class="nombre">
                            <input type="hidden" name="nombreUser_in" value="<?php echo $_SESSION['miNombre']?>">
                            <label class="username" name="nombreUser"><?php echo $_SESSION['miNombre'] ?></label>
                        </div>
                        <div class="opciones-salir">
                            <input type="radio" name="salida" value="2" id="salida">
                            <label for="salida" class="texto-salir">Marcar</label>
                        </div>
                    </div>
                    <div class="generalfrom-salir">
                        <button type="submit" class="btn-asistencia" name="botonGuardar-salir">Guardar</button>
                    </div>
                </fieldset>
                </form>
            </div>
        </div>
        <!-- Actualizar para la tabla de asistencia de entrada -->
       
    </div>
    
    <script src="js/noReenvio.js"></script>
    <script src="js/popudAsistencia.js"></script>
</body>

</html>