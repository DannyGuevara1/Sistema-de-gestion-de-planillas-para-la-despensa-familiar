<?php include("database.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de planillas</title>
    
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
        integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/form.css">
    <link rel="stylesheet" href="./css/gestionPlanillas.css">
</head>
<body>
    <?php
    require('admin.php');
    ?>
    <div class="main-planillas">
        <div class="main-planillas_nav">
            <h1>Gestion de planillas</h1>
        </div>
        <div class="main-planillas_container">
            <div class="main-planillas-card">
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
                $numeroisss = '';
                $ocupacion = '';
                $sueldo = '';
                $diasTrabajo = '';
                $horasEx = '';
                $isss = '';
                $afp = '';
                $otros = '';
                $recibo = 0;
                $horasValor = 16.66;
                if(isset($_POST['agregar'])){
                    $nombre = $_POST['nombre'];
                    $numeroisss = $_POST['numeroisss'];
                    $ocupacion = $_POST['cargo'];
                    $sueldo = $_POST['sueldo'];
                    $diasTrabajo = $_POST['diasTrabajo'];
                    $horasEx = $_POST['horasEx'];
                    $isss = $_POST['isss'];
                    $afp = $_POST['afp'];
                    $otros = $_POST['otros'];
                    $recibo = $_POST['sueldo'] - $_POST['isss'] - $_POST['afp'] - $_POST['otros'] + $_POST['horasEx']*$horasValor;
                    $sql = "INSERT INTO planillas(Nombre,Numeroisss,Ocupacion,Sueldo,DiasTrabajo,HorasEx,Isss,AFP,Otros,Recibo)
                    VALUES(:nombre,:numeroisss,:ocupacion,:sueldo,:diasTrabajo,:horasEx,:isss,:afp,:otros,:recibo)";
                    $sql = $connect->prepare($sql); 
                    $sql->bindParam(':nombre',$nombre,PDO::PARAM_STR,25);
                    $sql->bindParam(':numeroisss',$numeroisss,PDO::PARAM_INT,25);
                    $sql->bindParam(':ocupacion',$ocupacion,PDO::PARAM_STR,25);
                    $sql->bindParam(':sueldo',$sueldo,PDO::PARAM_INT,25);
                    $sql->bindParam(':diasTrabajo',$diasTrabajo,PDO::PARAM_INT,25);
                    $sql->bindParam(':horasEx',$horasEx,PDO::PARAM_INT,25);
                    $sql->bindParam(':isss',$isss,PDO::PARAM_INT,25);
                    $sql->bindParam(':afp',$afp,PDO::PARAM_INT,25);
                    $sql->bindParam(':otros',$otros,PDO::PARAM_INT,25);
                    $sql->bindParam(':recibo',$recibo,PDO::PARAM_INT,25);
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
                                $consulta = "DELETE FROM `planillas` WHERE `id`=:id";
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
                        <div class="titulo">Datos de la planilla</div>

                        <div class="contenidoDF">
                            <form action="gestionPlanillas.php" method="post">

                                <div class="detalles">

                                    <div class="inputclass">
                                        <span class="dato"> Nombre: </span>
                                        <input class="inputAgregar" type="text" required name="nombre" id="Nombre">
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato"> Numero isss: </span>
                                        <input type="number" required name="numeroisss" id="numeroisss">
                                    </div>

                                    
                                    <div class="inputclass">
                                        <span class="dato">Sueldo:</span>
                                        <input type="number" required name="sueldo" id="sueldo">
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato">Dias trabajados:</span>
                                        <input type="number" required name="diasTrabajo" id="diasTrabajo">
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato">Horas Extra:</span>
                                        <input type="number" required name="horasEx" id="horasEx">
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato">isss:</span>
                                        <input type="number" required name="isss" id="isss">
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato">Afp:</span>
                                        <input type="number" required name="afp" id="afp">
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato">Otros:</span>
                                        <input type="number" required name="otros" id="otros">
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato">Recibo:</span>
                                        <input  type="hidden" required name="Recibo" id="Recibo">
                                    </div>


                                    <div class="inputclass">
                                        <span class="dato">Ocupacion:</span>
                                        <select name="cargo" id="Cargo">
                                        <option value="Cajero">
                                                Cajero</option>
                                            <option value="Vigilante"
                                                >Vigilante
                                            </option>
                                            <option value="Vendedor de piso"
                                                >Vendedor de piso
                                            </option>
                                            <option value="Encargado de frutas y verduras"
                                                >Encargado de frutas y verduras
                                            </option>
                                            <option value="Encargado de panaderia"
                                                >
                                                Encargado de panaderia
                                            </option>
                                            <option value="Encargado de lacteos"
                                                >
                                                Encargado de lacteos
                                            </option>
                                            <option value="Encargado de alimentos perecederos"
                                                >
                                                Encargado de alimentos perecederos
                                            </option>
                                            <option value="Jefe de departamento"
                                                >
                                                Jefe de departamento
                                            </option>
                                            <option value="Sub jefe de departamento"
                                                >
                                                Sub jefe de departamento
                                            </option>
                                            <option value="Gerente"
                                                >Gerente
                                            </option>
                                            <option value="Sub Gerente"
                                                >Sub Gerente
                                            </option>
                                        </select>
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
                    $numeroisss = $_POST['numeroisss'];
                    $ocupacion = $_POST['cargo'];
                    $sueldo = $_POST['sueldo'];
                    $diasTrabajo = $_POST['diasTrabajo'];
                    $horasEx = $_POST['horasEx'];
                    $isss = $_POST['isss'];
                    $afp = $_POST['afp'];
                    $otros = $_POST['otros'];
                    $recibo = $_POST['sueldo'] - $_POST['isss'] - $_POST['afp'] - $_POST['otros'] + $_POST['horasEx']*$horasValor;

                    $consulta = "UPDATE planillas SET Nombre = :nombre , Numeroisss = :numeroisss , Ocupacion = :ocupacion , 
                    Sueldo = :sueldo , DiasTrabajo = :diasTrabajo , HorasEx = :horasEx , Isss = :isss , AFP = :afp ,
                    Otros = :otros , Recibo = :recibo WHERE id = :id";
                    $sql = $connect->prepare($consulta);

                    $sql->bindParam(':nombre',$nombre,PDO::PARAM_STR,25);
                    $sql->bindParam(':numeroisss',$numeroisss,PDO::PARAM_INT,25);
                    $sql->bindParam(':ocupacion',$ocupacion,PDO::PARAM_STR,25);
                    $sql->bindParam(':sueldo',$sueldo,PDO::PARAM_INT,25);
                    $sql->bindParam(':diasTrabajo',$diasTrabajo,PDO::PARAM_INT,25);
                    $sql->bindParam(':horasEx',$horasEx,PDO::PARAM_INT,25);
                    $sql->bindParam(':isss',$isss,PDO::PARAM_INT,25);
                    $sql->bindParam(':afp',$afp,PDO::PARAM_INT,25);
                    $sql->bindParam(':otros',$otros,PDO::PARAM_INT,25);
                    $sql->bindParam(':recibo',$recibo,PDO::PARAM_INT,25);
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
                    $sql= "SELECT * FROM planillas WHERE id = :id";
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
                            <form action="gestionPlanillas.php" method="post">

                                <div class="detalles">
                                
                                    <input type="hidden" name="id" value="<?php echo $obj->id;?>">
                                
                                    <div class="inputclass">
                                        <span class="dato"> Nombre: </span>
                                        <input class="inputAgregar" type="text" required name="nombre" id="Nombre" value="<?php echo $obj->Nombre;?>">
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato"> Numero isss: </span>
                                        <input type="number" required name="numeroisss" id="numeroisss" value="<?php echo $obj->Numeroisss;?>">
                                    </div>

                                    
                                    <div class="inputclass">
                                        <span class="dato">Sueldo:</span>
                                        <input type="number" required name="sueldo" id="sueldo" value="<?php echo $obj->Sueldo;?>">
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato">Dias trabajados:</span>
                                        <input type="number" required name="diasTrabajo" id="diasTrabajo" value="<?php echo $obj->DiasTrabajo;?>">
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato">Horas Extra:</span>
                                        <input type="number" required name="horasEx" id="horasEx" value="<?php echo $obj->HorasEx;?>">
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato">isss:</span>
                                        <input type="number" required name="isss" id="isss" value="<?php echo $obj->Isss;?>">
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato">Afp:</span>
                                        <input type="number" required name="afp" id="afp" value="<?php echo $obj->AFP;?>">
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato">Otros:</span>
                                        <input type="number" required name="otros" id="otros" value="<?php echo $obj->Otros;?>">
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato">Recibo:</span>
                                        <input  type="Number" required name="Recibo" id="Recibo" value="<?php echo $obj->Recibo;?>">
                                    </div>

                                    <div class="inputclass">
                                        <span class="dato">Cargo del Empleado:</span>
                                        <select name="cargo" id="Cargo">
                                            <option value="Cajero" <?php if($obj->Ocupacion == "Cajero") echo "selected"?>>
                                                Cajero</option>
                                            <option value="Vigilante"
                                                <?php if($obj->Ocupacion == "Vigilante") echo "selected"?>>Vigilante
                                            </option>
                                            <option value="Vendedor de piso"
                                                <?php if($obj->Ocupacion == "Vendedor de piso") echo "selected"?>>Vendedor de piso
                                            </option>
                                            <option value="Encargado de frutas y verduras"
                                                <?php if($obj->Ocupacion == "Encargado de frutas y verduras") echo "selected"?>>Encargado de frutas y verduras
                                            </option>
                                            <option value="Encargado de panaderia"
                                                <?php if($obj->Ocupacion == "Encargado de panaderia") echo "selected"?>>
                                                Encargado de panaderia
                                            </option>
                                            <option value="Encargado de lacteos"
                                                <?php if($obj->Ocupacion == "Encargado de lacteos") echo "selected"?>>
                                                Encargado de lacteos
                                            </option>
                                            <option value="Encargado de alimentos perecederos"
                                                <?php if($obj->Ocupacion == "Encargado de alimentos perecederos") echo "selected"?>>
                                                Encargado de alimentos perecederos
                                            </option>
                                            <option value="Jefe de departamento"
                                                <?php if($obj->Ocupacion == "Jefe de departamento") echo "selected"?>>
                                                Jefe de departamento
                                            </option>
                                            <option value="Sub jefe de departamento"
                                                <?php if($obj->Ocupacion == "Sub jefe de departamento") echo "selected"?>>
                                                Sub jefe de departamento
                                            </option>
                                            <option value="Gerente"
                                                <?php if($obj->Ocupacion == "Gerente") echo "selected"?>>Gerente
                                            </option>
                                            <option value="Sub Gerente"
                                                <?php if($obj->Ocupacion == "Sub Gerente") echo "selected"?>>Sub Gerente
                                            </option>
                                        </select>
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
                    <form action="gestionPlanillas.php" method="post">
                        <p>
                            <input type="text" name="search" placeholder="Busqueda">
                            <input type="submit" name="search_btn" value="Buscar">

                        </p>
                    </form>

                    <div class="tabla_usuarios-solo">
                        <div class="tabla_usuarios-encabezado">
                            <h2>Tabla Planillas de empleados</h2>
                        </div>

                        <div class="tabla_usuarios-cuerpo">
                            <table>
                                <thead>
                                    <tr>
                                        <td>Id</td>
                                        <td>Nombre</td>
                                        <td>Numero isss</td>
                                        <td>Ocupacion</td>
                                        <td>Sueldo</td>
                                        <td>Dias trabajados</td>
                                        <td>Horas Extras</td>
                                        <td>Isss</td>
                                        <td>AFP</td>
                                        <td>Otros</td>
                                        <td>Recibo</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>

                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                        if(isset($_POST['search_btn'])){
                                            $search = $_POST['search'];

                                            $consulta = ("SELECT * FROM planillas WHERE nombre LIKE '%$search%'");
                                            
                                            $query = $connect -> prepare($consulta);
                                            $query -> execute();
                                            $results = $query -> fetchAll(PDO::FETCH_OBJ);

                                            if($query -> rowCount() > 0){
                                                foreach($results as $result) { 
                                                    echo "<tr>
                                                    <td>".$result -> id."</td>
                                                    <td>".$result -> Nombre."</td>
                                                    <td>".$result -> Numeroisss."</td>
                                                    <td>".$result -> Ocupacion."</td>
                                                    <td>".$result -> Sueldo."</td>
                                                    <td>".$result -> DiasTrabajo."</td>
                                                    <td>".$result -> HorasEx."</td>
                                                    <td>".$result -> Isss."</td>
                                                    <td>".$result -> AFP."</td>
                                                    <td>".$result -> Otros."</td> 
                                                    <td>".$result -> Recibo."</td>
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
                                        $sql = "SELECT * FROM planillas";
                                        $query = $connect -> prepare($sql);
                                        $query -> execute();
                                        $results = $query -> fetchAll(PDO::FETCH_OBJ);

                                        if($query -> rowCount() > 0){
                                            foreach($results as $result) { 
                                                echo "<tr>
                                                <td>".$result -> id."</td>
                                                    <td>".$result -> Nombre."</td>
                                                    <td>".$result -> Numeroisss."</td>
                                                    <td>".$result -> Ocupacion."</td>
                                                    <td>".$result -> Sueldo."</td>
                                                    <td>".$result -> DiasTrabajo."</td>
                                                    <td>".$result -> HorasEx."</td>
                                                    <td>".$result -> Isss."</td>
                                                    <td>".$result -> AFP."</td>
                                                    <td>".$result -> Otros."</td> 
                                                    <td>".$result -> Recibo."</td>
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
            <?php
            include ("pdfPlanilla.php");
            ?>
        </div>
    <script src="js/noReenvio.js"></script>
    <script src="js/popubAgregarUsuario.js"></script>
</body>
</html>