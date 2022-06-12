<?php include("database.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Empleados</title>
    <link rel="stylesheet" href="./css/gestionEmpleados.css">
    <link rel="stylesheet" href="./css/form.css">
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
        integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
</head>

<body>
    <?php
require('admin.php');
?>
    <div class="main-usuarios">
        <div class="main-usarios_nav">
            <h1>Gestion de Empleados</h1>
        </div>
        <div class="main-usuarios_container">
            <div class="main-usarios-card">
                <div class="cards">
                    <div class="cards_sola">
                        <div>
                            <h2></h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- conexion a la base de datos -->
            <?php
                $grupo = 1;
                $nombre = '';
                $apellido = '';
                $direccion = '';
                $depar = '';
                $dui = '';
                $tel = '';
                $empl = '';
                $salario = '';
                $cargo = '';
                $genero = '';
                if(isset($_POST['agregar'])){
                    $nombre = $_POST['nombre'];
                    $apellido = $_POST['apellido'];
                    $direccion = $_POST['direccion'];
                    $depar = $_POST['departamento'];
                    $dui = $_POST['dui'];
                    $tel = $_POST['telefono'];
                    $empl = $_POST['empl'];
                    $salario = $_POST['salario'];
                    $cargo = $_POST['cargo'];
                    $genero = $_POST['genero'];
                    
                    $sql = "INSERT INTO empleado(nombre,apellido,direccion,departamento,dui,tel,empl,salario,cargo,genero)
                    VALUES(:nombre,:apellido,:direccion,:departamento,:dui,:telefono,:empl,:salario,:cargo,:genero)";
                    $sql = $connect->prepare($sql); 
                    $sql->bindParam(':nombre',$nombre,PDO::PARAM_STR,25);
                    $sql->bindParam(':apellido',$apellido,PDO::PARAM_STR,25);
                    $sql->bindParam(':direccion',$direccion,PDO::PARAM_STR,25);
                    $sql->bindParam(':departamento',$depar,PDO::PARAM_STR,25);
                    $sql->bindParam(':dui',$dui,PDO::PARAM_STR,25);
                    $sql->bindParam(':telefono',$tel,PDO::PARAM_INT,25);
                    $sql->bindParam(':empl',$empl,PDO::PARAM_INT,25);
                    $sql->bindParam(':salario',$salario,PDO::PARAM_INT,25);
                    $sql->bindParam(':cargo',$cargo,PDO::PARAM_STR,25);
                    $sql->bindParam(':genero',$genero,PDO::PARAM_STR,25);
                    $sql->execute();

                    $lastInsertId = $connect->lastInsertId();
                    if($lastInsertId>0){

                        echo "<div id='resultado' class='modalAgregar'>
                                <p>se agredo correctamente</p> 
                            </div>";
                    }else{
                        echo "Error";
                    }
                }
            ?>


            <!-- Final de actualizar -->
            <!-- Eliminar -->
            <?php  
                                if(isset($_POST['eliminar'])){
                                ////////////// Actualizar la tabla /////////
                                $consulta = "DELETE FROM `empleado` WHERE `id`=:id";
                                $sql = $connect-> prepare($consulta);
                                $sql -> bindParam(':id', $id, PDO::PARAM_INT);
                                $id=trim($_POST['id']);

                                $sql->execute();
                                
                                if($sql->rowCount() > 0)
                                {
                                $count = $sql -> rowCount();
                                echo "<div class='content alert alert-primary' > 
                                Gracias: $count registro ha sido eliminado  </div>";
                                
                                }
                                else{
                                    echo "<div class='content alert alert-danger'> No se pudo eliminar el registro  </div>";

                                print_r($sql->errorInfo()); 
                                }
                                
                                }// Cierra envio de guardado
                ?>
            <!-- final de eliminar -->



            <button name="srfe" id="open" value="Agregar" class="open">
                <p>Agregar</p>
                <!--<i class="fa-solid fa-user"></i>  -->
            </button>

            <div id="popup">
                <div class="containerForm">
                    <div class="contenidoF">
                        <div class="titulo">Datos Del Empleado</div>

                        <div class="contenidoDF">
                            <form action="gestionEmpleados.php" method="post">

                                <div class="detalles">

                                    <div class="inputclass">
                                        <span class="dato"> Nombres: </span>
                                        <input class="inputAgregar" type="text" required name="nombre" id="Nombre" pattern="[A-Za-z]+"/>
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato"> Apellidos: </span>
                                        <input type="text" required name="apellido" id="Apellido" pattern="[A-Za-z]+"/>
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato">Direccion</span>
                                        <input type="text" required name="direccion" id="Direccion">
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato">Dui:</span>
                                        <input type="text" required name="dui" id="Dui" maxlength="10" pattern="[0-9]+"/>
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato">Telefono:</span>
                                        <input type="number" required name="telefono" id="Telefono" maxlength="8" pattern="[0-9]+"/>
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato">Salario:</span>
                                        <input type="number" required name="salario" id="Salario" >
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato">Empl:</span>
                                        <input type="number" required name="empl" id="Empl" maxlength="8" minlength="1">
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato">Cargo del Empleado:</span>
                                        <select name="cargo" id="Cargo">
                                            <option value="Cajero">
                                                Cajero
                                            </option>
                                            <option value="Vigilante">
                                                Vigilante
                                            </option>
                                            <option value="Vendedor de piso">
                                                Vendedor de piso
                                            </option>
                                            <option value="Encargado de frutas y verduras">
                                                Encargado de frutas y verduras
                                            </option>
                                            <option value="Encargado de panaderia">
                                                Encargado de panaderia
                                            </option>
                                            <option value="Encargado de lacteos">
                                                Encargado de lacteos
                                            </option>
                                            <option value="Encargado de alimentos perecederos">
                                                Encargado de alimentos perecederos
                                            </option>
                                            <option value="Jefe de departamento">
                                                Jefe de departamento
                                            </option>
                                            <option value="Sub jefe de departamento">
                                                Sub jefe de departamento
                                            </option>
                                            <option value="Gerente">
                                                Gerente
                                            </option>
                                            <option value="Sub Gerente">
                                                Sub Gerente
                                            </option>
                                        </select>
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato">Departamento:</span>
                                        <select name="departamento" id="Departamento">
                                            <option value="San salvador">San Salvador</option>
                                            <option value="Chalatenango">Chalatenango</option>
                                            <option value="La paz">La paz</option>
                                            <option value="San Miguel">San Miguel</option>
                                            <option value="Ahuachapan">Ahuachapan</option>
                                            <option value="Cuscatlan">Cuscatlan</option>
                                            <option value="La Union">La Union</option>
                                            <option value="San Vicente">San Vicente</option>
                                            <option value="Sonsonate">Sonsonate</option>
                                            <option value="Usulutan">Usulutan</option>
                                            <option value="Cabañas">Cabañas</option>
                                            <option value="La libertad">La libertad</option>
                                            <option value="Morazan">Morazan</option>
                                            <option value="Santa Ana">Santa Ana</option>
                                        </select>
                                    </div>


                                </div>

                                <div class="generodiv " name="genero" id="Genero">
                                    <input type="radio" name="genero" value="Hombre" id="pt-1" class="r1">
                                    <input type="radio" name="genero" value="Mujer" id="pt-2" class="r1">
                                    <input type="radio" name="genero" value="No definido" id="pt-3" class="r1">

                                    <span class="tituloGen">Genero</span>

                                    <div class="tipoG">

                                        <label for="pt-1">
                                            <span class="seleccion select1"></span>
                                            <span class="genero">Hombre</span>
                                        </label>
                                        <label for="pt-2">
                                            <span class="seleccion select2"></span>
                                            <span class="genero">Mujer</span>
                                        </label>
                                        <label for="pt-3">
                                            <span class="seleccion select3"></span>
                                            <span class="genero">No definido</span>
                                        </label>

                                    </div>
                                </div>


                                <div class="button">
                                    <input class="icono" type="submit" value="Registrar" name="agregar">
                                    <input class="icono" type="button" value="Cerrar" id="close">
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <!-- inicia la funicon actualizar o editar -->
            <?php
                if(isset($_POST['actualizar'])){
                    $id = $_POST['id'];
                    $nombre = $_POST['nombre'];
                    $apellido = $_POST['apellido'];
                    $direccion = $_POST['direccion'];
                    $depar = $_POST['departamento'];
                    $dui = $_POST['dui'];
                    $tel = $_POST['telefono'];
                    $empl = $_POST['empl'];
                    $salario = $_POST['salario'];
                    $cargo = $_POST['cargo'];
                    $genero = $_POST['genero'];

                    $consulta = "UPDATE empleado SET nombre = :nombre , apellido = :apellido , direccion = :direccion , 
                    departamento = :departamento , dui = :dui , tel = :telefono , empl = :empl , salario = :salario ,
                    cargo = :cargo , genero = :genero WHERE id = :id";
                    $sql = $connect->prepare($consulta);

                    $sql->bindParam(':nombre',$nombre,PDO::PARAM_STR,25);
                    $sql->bindParam(':apellido',$apellido,PDO::PARAM_STR,25);
                    $sql->bindParam(':direccion',$direccion,PDO::PARAM_STR,25);
                    $sql->bindParam(':departamento',$depar,PDO::PARAM_STR,25);
                    $sql->bindParam(':dui',$dui,PDO::PARAM_STR,25);
                    $sql->bindParam(':telefono',$tel,PDO::PARAM_INT,25);
                    $sql->bindParam(':empl',$empl,PDO::PARAM_INT,25);
                    $sql->bindParam(':salario',$salario,PDO::PARAM_INT,25);
                    $sql->bindParam(':cargo',$cargo,PDO::PARAM_STR,25);
                    $sql->bindParam(':genero',$genero,PDO::PARAM_STR,25);
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
                if(isset($_POST['editar'])){
                    $id = $_POST['id'];
                    $sql= "SELECT * FROM empleado WHERE id = :id";
                    $stmt = $connect->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                    $obj = $stmt->fetchObject();
                
            ?>
            <!-- Inicia formulario agregar-->
            <div id="popup_ac">
            <div class="containerForm">
                    <div class="contenidoF">
                        <div class="titulo">Datos Del Empleado</div>

                        <div class="contenidoDF">
                            <form action="gestionEmpleados.php" method="post">

                                <div class="detalles">
                                
                                    <input type="hidden" name="id" value="<?php echo $obj->id;?>">
                                
                                    <div class="inputclass">
                                        <span class="dato"> Nombres: </span>
                                        <input class="inputAgregar" type="text" required name="nombre" id="Nombre"  value="<?php echo $obj->nombre;?>" pattern="[A-Za-z]+"/>
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato"> Apellidos: </span>
                                        <input type="text" required name="apellido" id="Apellido"  value="<?php echo $obj->apellido;?>" pattern="[A-Za-z]+"/>
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato">Direccion</span>
                                        <input type="text" required name="direccion" id="Direccion"  value="<?php echo $obj->direccion;?>">
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato">Dui:</span>
                                        <input type="text" required name="dui" id="Dui"  value="<?php echo $obj->dui;?>" pattern="[0-9]+"/>
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato">Telefono:</span>
                                        <input type="text" required name="telefono" id="Telefono"  value="<?php echo $obj->tel;?>" maxlength="8" pattern="[0-9]+"/>
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato">Salario:</span>
                                        <input type="text" required name="salario" id="Salario"  value="<?php echo $obj->salario;?>" maxlength="10" pattern="[0-9]+"/>
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato">Empl:</span>
                                        <input type="number" required name="empl" id="Empl"  value="<?php echo $obj->empl;?>" maxlength="8" minlength="1">
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato">Cargo del Empleado:</span>
                                        <select name="cargo" id="Cargo">
                                        <option value="Cajero" <?php if($obj->cargo == "Cajero") echo "selected"?>>
                                                Cajero</option>
                                            <option value="Vigilante"
                                                <?php if($obj->cargo == "Vigilante") echo "selected"?>>Vigilante
                                            </option>
                                            <option value="Vendedor de piso"
                                                <?php if($obj->cargo == "Vendedor de piso") echo "selected"?>>Vendedor de piso
                                            </option>
                                            <option value="Encargado de frutas y verduras"
                                                <?php if($obj->cargo == "Encargado de frutas y verduras") echo "selected"?>>Encargado de frutas y verduras
                                            </option>
                                            <option value="Encargado de panaderia"
                                                <?php if($obj->cargo == "Encargado de panaderia") echo "selected"?>>
                                                Encargado de panaderia
                                            </option>
                                            <option value="Encargado de lacteos"
                                                <?php if($obj->cargo == "Encargado de lacteos") echo "selected"?>>
                                                Encargado de lacteos
                                            </option>
                                            <option value="Encargado de alimentos perecederos"
                                                <?php if($obj->cargo == "Encargado de alimentos perecederos") echo "selected"?>>
                                                Encargado de alimentos perecederos
                                            </option>
                                            <option value="Jefe de departamento"
                                                <?php if($obj->cargo == "Jefe de departamento") echo "selected"?>>
                                                Jefe de departamento
                                            </option>
                                            <option value="Sub jefe de departamento"
                                                <?php if($obj->cargo == "Sub jefe de departamento") echo "selected"?>>
                                                Sub jefe de departamento
                                            </option>
                                            <option value="Gerente"
                                                <?php if($obj->cargo == "Gerente") echo "selected"?>>Gerente
                                            </option>
                                            <option value="Sub Gerente"
                                                <?php if($obj->cargo == "Sub Gerente") echo "selected"?>>Sub Gerente
                                            </option>
                                        </select>
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato">Departamento:</span>
                                        <select name="departamento" id="Departamento">
                                            <option value="San salvador" <?php if($obj->departamento == "San salvador") echo "selected"?>>San Salvador</option>
                                            <option value="Chalatenango" <?php if($obj->departamento == "Chalatenango") echo "selected"?>>Chalatenango</option>
                                            <option value="La paz" <?php if($obj->departamento == "La paz") echo "selected"?>>La paz</option>
                                            <option value="San Miguel" <?php if($obj->departamento == "San Miguel") echo "selected"?>>San Miguel</option>
                                            <option value="Ahuachapan" <?php if($obj->departamento == "Ahuachapan") echo "selected"?>>Ahuachapan</option>
                                            <option value="Cuscatlan" <?php if($obj->departamento == "Cuscatlan") echo "selected"?>>Cuscatlan</option>
                                            <option value="La Union" <?php if($obj->departamento == "La Union") echo "selected"?>>La Union</option>
                                            <option value="San Vicente" <?php if($obj->departamento == "San Vicente") echo "selected"?>>San Vicente</option>
                                            <option value="Sonsonate" <?php if($obj->departamento == "Sonsonate") echo "selected"?>>Sonsonate</option>
                                            <option value="Usulutan" <?php if($obj->departamento == "Usulutan") echo "selected"?>>Usulutan</option>
                                            <option value="Cabañas" <?php if($obj->departamento == "Cabañas") echo "selected"?>>Cabañas</option>
                                            <option value="La libertad" <?php if($obj->departamento == "La Libertad") echo "selected"?>>La libertad</option>
                                            <option value="Morazan" <?php if($obj->departamento == "Morazan") echo "selected"?>>Morazan</option>
                                            <option value="Santa Ana" <?php if($obj->departamento == "Santa Ana") echo "selected"?>>Santa Ana</option>
                                        </select>
                                    </div>


                                </div>

                                <div class="generodiv " name="genero" id="Genero">
                                    
                                    <span class="tituloGen">Genero</span>

                                    <div class="tipoG">

                                        <label for="pt-1">
                                            <input class="seleccion select1" type="radio" name="genero" value="Hombre" id="pt-1" <?php if($obj->genero == "Hombre") echo "checked"?>>
                                            <span class="genero">Hombre</span>
                                        </label>
                                        <label for="pt-2">
                                            <input class="seleccion select2" type="radio" name="genero" value="Mujer" id="pt-2" <?php if($obj->genero == "Mujer") echo "checked"?>>
                                            <span class="genero">Mujer</span>
                                            
                                        </label>
                                        <label for="pt-3">
                                            <input class="seleccion select3" type="radio" name="genero" value="No definido" id="pt-3" <?php if($obj->genero == "No definido") echo "checked"?>>
                                            <span class="genero">No definido</span>
                                        </label>

                                    </div>
                                </div>


                                <div class="button">
                                    <input class="icono" type="submit" value="Actualizar" name="actualizar">
                                    <input class="icono" type="button" value="Cerrar" id="close_ac">
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <?php }?>
            <!-- termina formulario de agregar -->

            <!-- inicia la tabla -->

            <div class="tabla">
                <div class="tabla_usuarios">
                    <form action="gestionEmpleados.php" method="post">
                        <p>
                            <input type="text" name="search" placeholder="Busqueda">
                            <input type="submit" name="search_btn" value="Buscar">

                        </p>
                    </form>

                    <div class="tabla_usuarios-solo">
                        <div class="tabla_usuarios-encabezado">
                            <h2>Tabla Empleados</h2>
                        </div>

                        <div class="tabla_usuarios-cuerpo">
                            <table>
                                <thead>
                                    <tr>
                                        <td>Id</td>
                                        <td>Nombre</td>
                                        <td>Apellido</td>
                                        <td>Direccion</td>
                                        <td>Departamento</td>
                                        <td>Dui</td>
                                        <td>Tel</td>
                                        <td>Empl</td>
                                        
                                        
                                        <td></td>
                                        <td></td>
                                        <td></td>

                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                        if(isset($_POST['search_btn'])){
                                            $search = $_POST['search'];

                                            $consulta = ("SELECT * FROM empleado WHERE nombre LIKE '%$search%'");
                                            
                                            $query = $connect -> prepare($consulta);
                                            $query -> execute();
                                            $results = $query -> fetchAll(PDO::FETCH_OBJ);

                                            if($query -> rowCount() > 0){
                                                foreach($results as $result) { 
                                                    echo "<tr>
                                                    <td>".$result -> id."</td>
                                                    <td>".$result -> nombre."</td>
                                                    <td>".$result -> apellido."</td>
                                                    <td>".$result -> direccion."</td>
                                                    <td>".$result -> departamento."</td>
                                                    <td>".$result -> dui."</td>
                                                    <td>".$result -> tel."</td>
                                                    <td>".$result -> empl."</td>
                                                    <td>
                                                    <form  method='POST' action='".$_SERVER['PHP_SELF']."'>
                                                    <input type='hidden' name='id' value='".$result -> id."'>
                                                    <button name='editar' class='btnModificar' >Modificar</button>
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
                                        $sql = "SELECT * FROM empleado";
                                        $query = $connect -> prepare($sql);
                                        $query -> execute();
                                        $results = $query -> fetchAll(PDO::FETCH_OBJ);

                                        if($query -> rowCount() > 0){
                                            foreach($results as $result) { 
                                                echo "<tr>
                                                <td>".$result -> id."</td>
                                                <td>".$result -> nombre."</td>
                                                <td>".$result -> apellido."</td>
                                                <td>".$result -> direccion."</td>
                                                <td>".$result -> departamento."</td>
                                                <td>".$result -> dui."</td>
                                                <td>".$result -> tel."</td>
                                                <td>".$result -> empl."</td>
                                                <td>
                                                <form method='POST' action='".$_SERVER['PHP_SELF']."'>
                                                <input type='hidden' name='id' value='".$result -> id."'>
                                                <button name='editar' class='btnModificar'>Modificar</button>
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
        </div>

    </div>
    <script src="js/noReenvio.js"></script>
    <script src="js/popubAgregarUsuario.js"></script>
</body>

</html>