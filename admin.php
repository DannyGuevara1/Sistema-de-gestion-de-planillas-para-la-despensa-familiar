<?php
    session_start();

    if(!isset($_SESSION['rol'])){
        header('location: login.php');
    }else{
        if($_SESSION['rol'] != 1){
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
    <title>Admin</title>
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
    <!-- Sidebar inicio -->
    <div class="header">
        <div class="header_side-nav">
            <a href="admin.php" class="header_side-nav__logo">
                <img src="./img/despensa_familiar_logo.png" alt="logo" class="header_side-nav__logo-img">
            </a>

            <ul class="header_nav-links">
                <li><a href="#"><i class="fa-solid fa-house-user"></i><p>Dashboard</p></a></li>
                <li><a href="gestionUsuario.php"><i class="fa-solid fa-user"></i><p>Gestion de usuario</p></a></li>
                <li><a href="gestionEmpleados.php"><i class="fa-solid fa-address-card"></i><p>Gestion de empleados</p></a></li>
                <li><a href="registroAsistencia.php"><i class="fa-solid fa-calendar-days"></i><p>Registro de asistencia</p></a></li>
                <li><a href="gestionPlanillas.php"><i class="fa-solid fa-file-excel"></i><p>Gestion de planillas</p></a></li>
                <li><a href="gestionBoletasPago.php"><i class="fa-solid fa-file-invoice-dollar"></i><p>Gestion de boletas de pago</p></a></li>
                <div class="header_nav-links_active"></div>
                <div class="header_nav-links_active_page"></div>
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
    <!-- Sidebar Final -->
</body>
</html>