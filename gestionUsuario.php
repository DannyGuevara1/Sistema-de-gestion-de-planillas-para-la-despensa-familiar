<?php include("database.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de usuarios</title>
    <link rel="stylesheet" href="./css/gestionUsuario.css">
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
        integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
</head>

<body>
    <?php
require('admin.php');
?>
    <div class="main-usuarios">
        <div class="main-usarios_nav">
            <h1>Gestion de Usuario</h1>
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
                $username = '';
                $password = '';
                $rol = '';
                if(isset($_POST['agregar'])){
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $rol = $_POST['rol'];
                    
                    
                    $sql = "INSERT INTO usuarios(username,password,rol_id)
                    VALUES(:username,:password,:rol_id)";
                    $sql = $connect->prepare($sql); 
                    $sql->bindParam(':username',$username,PDO::PARAM_STR,25);
                    $sql->bindParam(':password',$password,PDO::PARAM_STR,25);
                    $sql->bindParam(':rol_id',$rol,PDO::PARAM_INT,25);
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
                                $consulta = "DELETE FROM `usuarios` WHERE `id`=:id";
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
                <div class="FormAgregar">
                    <h2>Registro</h2>
                    <form action="gestionUsuario.php" method="post">
                        <p>
                            <input type="hidden" name="id">
                        </p>
                        <p>
                            <label for="username">Nombre de usuario</label>
                            <input class="inputAgregar" type="text" name="username" id="Username">
                        </p>
                        <p>
                            <label for="password">Contraseña</label>
                            <input class="inputAgregar" type="text" name="password" id="Password">
                        </p>

                        <select class="SelectAgregar" name="rol" id="Rol">
                            <option value="1">Administrador</option>
                            <option value="2">Empeado</option>
                        </select>

                        <input class="btnAgregar" type="submit" value="Agregar" name="agregar">
                        <input class="btnAgregar" type="button" value="Cerrar" id="close">
                    </form>
                </div>
            </div>
            <!-- inicia la funicon actualizar o editar -->
            <?php
                if(isset($_POST['actualizar'])){
                    $id = $_POST['id'];
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $rol = $_POST['rol'];

                    $consulta = "UPDATE usuarios SET username = :username , password = :password , rol_id = :rol WHERE id = :id";
                    $sql = $connect->prepare($consulta);

                    $sql->bindParam(':username',$username,PDO::PARAM_STR, 25);
                    $sql->bindParam(':password',$password,PDO::PARAM_STR, 25);
                    $sql->bindParam(':rol',$rol,PDO::PARAM_INT, 25);
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
                    $sql= "SELECT * FROM usuarios WHERE id = :id";
                    $stmt = $connect->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                    $obj = $stmt->fetchObject();
                
            ?>
            <!-- Inicia formulario agregar-->
            <div id="popup_ac">
                <div class="FormAgregar">
                    <h2>Actualizar</h2>
                    <form action="gestionUsuario.php" method="post">
                        <p>
                            <input type="hidden" name="id" value="<?php echo $obj->id;?>">
                        </p>

                        <p>
                            <label for="username">Nombre de usuario</label>
                            <input class="inputAgregar" type="text" name="username" id="Username"
                                value="<?php echo $obj->username;?>">
                        </p>
                        <p>
                            <label for="password">Contraseña</label>
                            <input class="inputAgregar" type="text" name="password" id="Password"
                                value="<?php echo $obj->password;?>">
                        </p>

                        <select class="SelectAgregar" required name="rol" id="Rol">
                            <option value="1" <?php if($obj->rol_id == "1") echo "selected"?>>Administrador</option>
                            <option value="2" <?php if($obj->rol_id == "2") echo "selected"?>>Empeado</option>
                        </select>

                        <input class="btnAgregar" type="submit" value="Actualizar" name="actualizar">
                        <input class="btnAgregar" type="button" value="Cerrar" id="close_ac">
                    </form>
                </div>
            </div>
            <?php }?>
            <!-- termina formulario de agregar -->

            <!-- inicia la tabla -->

            <div class="tabla">
                <div class="tabla_usuarios">
                    <form action="gestionUsuario.php" method="post">
                        <p>
                            <input type="text" name="search" placeholder="Busqueda">
                            <input type="submit" name="search_btn" value="Buscar">

                        </p>
                    </form>

                    <div class="tabla_usuarios-solo">
                        <div class="tabla_usuarios-encabezado">
                            <h2>Tabla Usuarios</h2>
                        </div>

                        <div class="tabla_usuarios-cuerpo">
                            <table>
                                <thead>
                                    <tr>
                                        <td>Id</td>
                                        <td>Usuario</td>
                                        <td>Password</td>
                                        <td>Rol</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                        if(isset($_POST['search_btn'])){
                                            $search = $_POST['search'];

                                            $consulta = ("SELECT * FROM usuarios WHERE username LIKE '%$search%'");
                                            
                                            $query = $connect -> prepare($consulta);
                                            $query -> execute();
                                            $results = $query -> fetchAll(PDO::FETCH_OBJ);

                                            if($query -> rowCount() > 0){
                                                foreach($results as $result) { 
                                                    echo "<tr>
                                                    <td>".$result -> id."</td>
                                                    <td>".$result -> username."</td>
                                                    <td>".$result -> password."</td>
                                                    <td>".$result -> rol_id."</td>
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
                                        $sql = "SELECT * FROM usuarios";
                                        $query = $connect -> prepare($sql);
                                        $query -> execute();
                                        $results = $query -> fetchAll(PDO::FETCH_OBJ);

                                        if($query -> rowCount() > 0){
                                            foreach($results as $result) { 
                                                echo "<tr>
                                                <td>".$result -> id."</td>
                                                <td>".$result -> username."</td>
                                                <td>".$result -> password."</td>
                                                <td>".$result -> rol_id."</td>
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