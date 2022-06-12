<?php 
require('admin.php');
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
        <?php
                if(isset($_POST['actualizar'])){
                    $id = $_POST['id'];
                    $entrada = $_POST['hora'];
                    

                    $consulta = "UPDATE asistenciaentrada SET entrada = :entrada WHERE id = :id";
                    $sql = $connect->prepare($consulta);

                    $sql->bindParam(':entrada',$entrada,PDO::PARAM_STR, 25);
                    $sql->bindParam(':id',$id,PDO::PARAM_INT, 25);

                    $sql->execute();

                    if($sql->rowCount() > 0){
                        $count = $sql -> rowCount();
                        echo "<div class='content alert alert-primary' > 
                        Gracias: $count registro ha sido actualizado  </div>";
                        
                    }else{
                        echo "<div class='content alert alert-danger'> No se pudo actulizar el registro  </div>";
                        print_r($sql->errorInfo()); 
                    }            
                }
                
            ?>
        <!-- final de la funicon actualizar o editar -->
        <!-- Inicia evento editar -->
        <?php
                if(isset($_POST['editarEntrada'])){
                    $id = $_POST['id'];
                    $sql= "SELECT * FROM asistenciaentrada WHERE id = :id";
                    $stmt = $connect->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                    $obj = $stmt->fetchObject();
                
            ?>
        <!-- Inicia formulario agregar-->
        <div id="popup_ac">
            
                <div class="asistenciaContent">
                    <div class="contenido">
                        <div class="titulo">Datos Del Usuario</div>
                        <div class="contenidoDF">
                            <form action="asistencia.php" method="post" class="formulario">
                                <div class="detalles">
                                    <input type="hidden" name="id" value="<?php echo $obj->id;?>">
                                    <div class="tiempo">
                                        <label for="hora" class="texto">Fecha:</label>
                                        <input type="datetime" class="fechaHora" name="hora" id=""
                                            value="<?=$fechaHoy?>">
                                    </div>
                                    <fieldset>
                                        <h4>Asistencia - Entrada </h4>
                                        <div class="datos">
                                            <div class="nombre">
                                                <input type="hidden" name="nombreUser_in"
                                                    value="<?php echo $obj->nombre ?>">
                                                <label class="username"
                                                    name="nombreUser"><?php echo $obj->nombre  ?></label>
                                            </div>
                                            <div class="opciones">
                                                <input type="radio" name="presente" value="1" name="presente"
                                                    id="presente">
                                                <label for="presente" class="texto">Presente</label>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="button">
                                    <input class="btnAgregar" type="submit" value="Actualizar" name="actualizar">
                                    <input class="btnAgregar" type="button" value="Cerrar" id="close_ac">
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            
        </div>
        <?php }?>
        <!-- Actualizar para la tabla de asistencia de salida -->
        <form class="tablaF" action="asistencia.php" method="post">
                        <p >
                            <input type="text" name="search" placeholder="Busqueda">
                            <input type="submit" name="search_btn" value="Buscar">
                        </p>
        <div class="grid-tabla">
            <div class="tabla tbl">
                <div class="tabla_usuarios">
                    
                    </form>

                    <div class="tabla_usuarios-solo">
                        <div class="tabla_usuarios-encabezado">
                            <h2>Tabla Entradas</h2>
                        </div>

                        <div class="tabla_usuarios-cuerpo">
                            <table>
                                <thead>
                                    <tr>
                                        <td>Id</td>
                                        <td>nombre</td>
                                        <td>entrada</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                        if(isset($_POST['search_btn'])){
                                            $search = $_POST['search'];

                                            $consulta = ("SELECT * FROM asistenciaentrada WHERE nombre LIKE '%$search%'");
                                            
                                            $query = $connect -> prepare($consulta);
                                            $query -> execute();
                                            $results = $query -> fetchAll(PDO::FETCH_OBJ);

                                            if($query -> rowCount() > 0){
                                                foreach($results as $result) { 
                                                    echo "<tr>
                                                    <td>".$result -> id."</td>
                                                    <td>".$result -> nombre."</td>
                                                    <td>".$result -> entrada."</td>
                                                    
                                                    <td>
                                                    <form  method='POST' action='".$_SERVER['PHP_SELF']."'>
                                                    <input type='hidden' name='id' value='".$result -> id."'>
                                                    <button name='editarEntrada' class='btnModificar' >Modificar</button>
                                                    </form>
                                                    </td>
                                                    
                                                    <td>
                                                    <form  onsubmit=\"return confirm('Realmente desea eliminar el registro?');\" method='POST' action='".$_SERVER['PHP_SELF']."'>
                                                    <input type='hidden' name='id' value='".$result -> id."'>
                                                    <button name='eliminar' class='btnEliminar'>Eliminar</button>
                                                    </form>
                                                    </td>
                                                    </tr>";
                                                    }
                                                    
                                            } 
                                        }else{
                                        $sql = "SELECT * FROM asistenciaentrada";
                                        $query = $connect -> prepare($sql);
                                        $query -> execute();
                                        $results = $query -> fetchAll(PDO::FETCH_OBJ);

                                        $sqlSalida = "SELECT * FROM asistenciasalida";
                                        $querySalida = $connect -> prepare($sqlSalida);
                                        $querySalida -> execute();
                                        $resultsSalida = $querySalida -> fetchAll(PDO::FETCH_OBJ);

                                        if($query -> rowCount() > 0){
                                            
                                                foreach($results as $result) { 
                                                    
                                                    echo "<tr>
                                                    <td>".$result -> id."</td>
                                                    <td>".$result -> nombre."</td>
                                                    <td>".$result -> entrada."</td>
                                                    <td></td>
                                                
                                                    
                                                    <td>
                                                    <form method='POST' action='".$_SERVER['PHP_SELF']."'>
                                                    <input type='hidden' name='id' value='".$result -> id."'>
                                                    <button name='editarEntrada' class='btnModificar'>Modificar</button>
                                                    </form>
                                                    </td>
                                                    
                                                    <td>
                                                    <form  onsubmit=\"return confirm('Realmente desea eliminar el registro?');\" method='POST' action='".$_SERVER['PHP_SELF']."'>
                                                    <input type='hidden' name='id' value='".$result -> id."'>
                                                    <button name='eliminar' class='btnEliminar'>Eliminar</button>
                                                    </form>
                                                    </td>
                                                    </tr>";
                                                    
                                                    
                                                    }
                                                    
                                            }
                                            

                                        
                                        
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- para la tabla de salida -->
            <?php
                if(isset($_POST['actualizarSalida'])){
                    $id = $_POST['id'];
                    $salida = $_POST['hora'];
                    

                    $consulta = "UPDATE asistenciasalida SET salida = :salida WHERE id = :id";
                    $sql = $connect->prepare($consulta);

                    $sql->bindParam(':salida',$salida,PDO::PARAM_STR, 25);
                    $sql->bindParam(':id',$id,PDO::PARAM_INT, 25);

                    $sql->execute();

                    if($sql->rowCount() > 0){
                        $count = $sql -> rowCount();
                        echo "<div class='content alert alert-primary' > 
                        Gracias: $count registro ha sido actualizado  </div>";
                        
                    }else{
                        echo "<div class='content alert alert-danger'> No se pudo actulizar el registro  </div>";
                        print_r($sql->errorInfo()); 
                    }            
                }
                
            ?>
            <!-- final de la funicon actualizar o editar -->
            <!-- Inicia evento editar -->
            <?php
                if(isset($_POST['editarSalida'])){
                    $id = $_POST['idSalida'];
                    $sqlSalida= "SELECT * FROM asistenciasalida WHERE id = :id";
                    $stmtSalida = $connect->prepare($sqlSalida);
                    $stmtSalida->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmtSalida->execute();
                    $objSalida = $stmtSalida->fetchObject();
                
            ?>
            <!-- Inicia formulario de asistencia salida-->
            <div id="popup_ac">
                <!-- <div class="asistenciaContent"> -->
                <div class="asistenciaContent">


                    <div class="contenido">

                        <form action="asistencia.php" method="post" class="formulario">
                        <input type="hidden" name="id" value="<?php echo $objSalida->id;?>">
                            <div class="tiempo">
                                <label for="hora" class="texto">Fecha:</label>
                                <input type="datetime" class="fechaHora" name="hora" id="" value="<?=$fechaHoy?>"
                                    >
                            </div>
                            <fieldset>
                                <h4>Asistencia - Salida </h4>
                                <div class="datos">

                                    <div class="nombre">
                                        <input type="hidden" name="nombreUser_in"
                                            value="<?php echo $objSalida->nombre ?>">
                                        <label class="username"
                                            name="nombreUser"><?php echo $objSalida->nombre?></label>
                                    </div>

                                    <div class="opciones">
                                        <input type="radio" name="presente" value="1" id="presente">
                                        <label for="presente" class="texto">Marcar</label>
                                    </div>
                                </div>
                                <div class="button">
                                    <input class="btnAgregar" type="submit" value="Actualizar" name="actualizarSalida">
                                    <input class="btnAgregar" type="button" value="Cerrar" id="close_ac">
                                </div>
                            </fieldset>
                        </form>
                    </div>



                </div>
            </div>
            <?php }?>
            <div class="tabla tbl">
                <div class="tabla_usuarios">
                    <form action="asistencia.php" method="post">
                    
                    </form>

                    <div class="tabla_usuarios-solo">
                        <div class="tabla_usuarios-encabezado">
                            <h2>Tabla Salida</h2>
                        </div>

                        <div class="tabla_usuarios-cuerpo">
                            <table>
                                <thead>
                                    <tr>
                                        <td>Id</td>
                                        <td>nombre</td>
                                        <td>salida</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                        if(isset($_POST['search_btn'])){
                                            $search = $_POST['search'];

                                            $consulta = ("SELECT * FROM asistenciasalida WHERE nombre LIKE '%$search%'");
                                            $querySalida = $connect -> prepare($consulta);
                                            $querySalida -> execute();
                                            $resultsSalida = $querySalida -> fetchAll(PDO::FETCH_OBJ);

                                            if($querySalida -> rowCount() > 0){
                                                foreach($resultsSalida as $resultSalida) { 
                                                    echo "<tr>
                                                    <td>".$resultSalida -> id."</td>
                                                    <td>".$resultSalida -> nombre."</td>
                                                    <td>".$resultSalida -> salida."</td>
                                                    
                                                    <td>
                                                    <form  method='POST' action='".$_SERVER['PHP_SELF']."'>
                                                    <input type='hidden' name='idSalida' value='".$resultSalida -> id."'>
                                                    <button name='editarSalida' class='btnModificar' >Modificar</button>
                                                    </form>
                                                    </td>
                                                    
                                                    <td>
                                                    <form  onsubmit=\"return confirm('Realmente desea eliminar el registro?');\" method='POST' action='".$_SERVER['PHP_SELF']."'>
                                                    <input type='hidden' name='id' value='".$resultSalida -> id."'>
                                                    <button name='eliminar' class='btnEliminar'>Eliminar</button>
                                                    </form>
                                                    </td>
                                                    </tr>";
                                                    }
                                            } 
                                        }else{
                                        $sqlSalida = "SELECT * FROM asistenciasalida";
                                        $querySalida = $connect -> prepare($sqlSalida);
                                        $querySalida -> execute();
                                        $resultsSalida = $querySalida -> fetchAll(PDO::FETCH_OBJ);

                                        if($querySalida -> rowCount() > 0){
                                            
                                                foreach($resultsSalida as $resultSalida) { 
                                                    
                                                    echo "<tr>
                                                    <td>".$resultSalida -> id."</td>
                                                    <td>".$resultSalida -> nombre."</td>
                                                    <td>".$resultSalida -> salida."</td>
                                                    <td></td>
                                                
                                                    
                                                    <td>
                                                    <form method='POST' action='".$_SERVER['PHP_SELF']."'>
                                                    <input type='hidden' name='idSalida' value='".$resultSalida -> id."'>
                                                    <button name='editarSalida' class='btnModificar'>Modificar</button>
                                                    </form>
                                                    </td>
                                                    
                                                    <td>
                                                    <form  onsubmit=\"return confirm('Realmente desea eliminar el registro?');\" method='POST' action='".$_SERVER['PHP_SELF']."'>
                                                    <input type='hidden' name='id' value='".$resultSalida -> id."'>
                                                    <button name='eliminar' class='btnEliminar'>Eliminar</button>
                                                    </form>
                                                    </td>
                                                    </tr>";
                                                    }
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="js/noReenvio.js"></script>
    <script src="js/popudAsistencia.js"></script>
</body>

</html>