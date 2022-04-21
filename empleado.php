<?php
    session_start();

    

    if(!isset($_SESSION['rol'])){
        header('location: login.php');
    }else{
        if($_SESSION['rol'] != 2){
            header('location: login.php');
        }
    }

    $cerrar_sesion="";
    if(isset($_POST['cerrar_sesion'])){
        $cerrar_sesion = $_POST['cerrar_sesion'];
        session_unset();
        session_destroy();
        header('location: login.php');
        
    };
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleado</title>
    <link rel="stylesheet" href="./css/sidebar.css">
    <link rel="stylesheet" href="./css/reset.css">
    <!-- Tipografia -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Krub:wght@400;700&family=Poppins&family=Staatliches&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/be80df5c7c.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="header">
        <div class="header_side-nav">
            <a href="#" class="header_side-nav__logo">
                <img src="./img/despensa_familiar_logo.png" alt="logo" class="header_side-nav__logo-img">
            </a>

            <ul class="header_nav-links">
                <!-- lista  -->
                <li><a href="#"><i class="fa-solid fa-calendar-days"></i><p>Registro de asistencia</p></a></li>
                <!-- boton  de cerrar sesion -->
                <div class="header_nav-links_active"></div>
                <form action="admin.php" method="POST">
                    <div class="box-1">
                        <button class="btn btn-one reset-button" name="cerrar_sesion" type="submit">
                        <li><i class="fa-solid fa-power-off"></i><span>cerrar sesion</span>
                            </button></li>
                    </div>
                </form>

            </ul>
        </div>
    </div>
</body>
</html>