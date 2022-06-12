<?php
    require("head.php");
    include("database.php");

    session_start();
    $arrayAlert = array();
    if(isset($_GET['cerrar_sesion'])){
        session_unset();
        session_destroy();
    }

    if (isset($_SESSION['rol'])) {
        switch($_SESSION['rol']){
            case 1:
                header('location: admin.php');
            break;

            case 2:
                header('location: empleado.php');
            break;
        }
    }
    

    if(isset($_POST['username']) && isset($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        
        $query = $connect->prepare('SELECT *FROM usuarios WHERE username = :username AND password = :password'); 
        $query->execute(['username'=> $username , 'password'=> $password]);

        $row = $query->fetch(PDO::FETCH_NUM);
        
        
        if($row == true){
            $rol = $row[3];
            
            $_SESSION['rol'] = $rol;
            
            switch($rol){
                case 1:
                    header('location: admin.php');
                break;

                case 2:
                    header('location: empleado.php');
                break;

                default:
            }
        }else{
            // no existe el usuario
            array_push($arrayAlert,"Nombre de usuario o contraseña incorrecto");
            
        }
        $_SESSION['miNombre'] = $username;
        
    }
?>
<body>
    <div class="login">
        <div class="onda-arriba">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
                preserveAspectRatio="none">
                <path
                    d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
                    opacity=".25" class="shape-fill"></path>
                <path
                    d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z"
                    opacity=".5" class="shape-fill"></path>
                <path
                    d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z"
                    class="shape-fill"></path>
            </svg>
        </div>
        <div class="Login-contenedor__formulario">
            <form class="Login-contenedor__formulario__contenedor" action="login.php" method="POST">
                
                <p>
                    <img class="Login-contenedor__formulario__contenedor__logo" src="img/despensa_familiar_logo.png"
                        alt="">
                </p>
                <?php
                    $nombre_usuario = "";
                    $password = "";

                    if (isset($_POST['username'])) {
                        $nombre_usuario = $_POST['username'];
                        $password = $_POST['password'];

                        if ($nombre_usuario == "") {
                            array_push($arrayAlert,"El campo username no debe estar vacio");
                        }
                        if ($password == "" || strlen($password) <= 6 ) {
                            array_push($arrayAlert,"El campo password no debe estar vacio o el  debe contener mas de 6 caracteres");
                        }

                        if (count($arrayAlert) > 0) {
                            echo "<div class='danger'>";
                            for ($i=0; $i < count($arrayAlert) ; $i++) { 
                                echo "<li>".$arrayAlert[$i]."</li>";
                            }
                        }else{
                            echo "<div class='success'>
                            Datos correctos";
                        }
                        echo "</div>";
                    }
                ?>
                <!-- Usuario -->
                <div class="Login-contenedor__formulario__item">
                    <img src="./img/user.png" alt="Username">
                    <input type="text" name="username" autocomplete="off" placeholder="Username">
                </div>
                <!-- Contraseña -->
                <div class="Login-contenedor__formulario__item">
                    <img src="./img/padlock.png" alt="contraseña">
                    <input type="password" name="password" placeholder="Password">
                </div>
                <div class="box-1">
                    <button class="btn btn-one reset-button" type="submit">
                        <span>LOG IN</span>
                    </button>
                </div>
            </form>
        </div>
        <div class="onda-abajo">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
                preserveAspectRatio="none">
                <path d="M600,112.77C268.63,112.77,0,65.52,0,7.23V120H1200V7.23C1200,65.52,931.37,112.77,600,112.77Z"
                    class="shape-fill"></path>
            </svg>
        </div>
    </div>
</body>
</html>