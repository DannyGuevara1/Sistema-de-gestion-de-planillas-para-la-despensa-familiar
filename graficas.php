<?php

$con = new mysqli("sql110.epizy.com","epiz_31941384","tnzw01Mx1FAKZx5","epiz_31941384_sistemasplanillas"); // Conectar a la BD
$sql = "SELECT departamento, COUNT(*) FROM `empleado` WHERE salario > 0 GROUP BY departamento "; // Consulta SQL
$query = $con->query($sql); // Ejecutar la consulta SQL
$data = array(); // Array donde vamos a guardar los datos
while($r = $query->fetch_object()){ // Recorrer los resultados de Ejecutar la consulta SQL
    $data[]=$r; // Guardar los resultados en la variable $data
}

//SELECT departamento, COUNT(*) FROM `empleado` WHERE salario > 0 GROUP BY departamento
$sqlCount = "SELECT departamento, COUNT(*) as departamento FROM empleado GROUP BY departamento"; // Consulta SQL
$queryCount = $con->query($sqlCount); // Ejecutar la consulta SQL
$dataCount = array(); // Array donde vamos a guardar los datos
while($rCount = $queryCount->fetch_object()){ // Recorrer los resultados de Ejecutar la consulta SQL
    $dataCount[]=$rCount; // Guardar los resultados en la variable $data
}

$con = new mysqli("sql110.epizy.com","epiz_31941384","tnzw01Mx1FAKZx5","epiz_31941384_sistemasplanillas"); // Conectar a la BD
$sqlGenero = "SELECT genero, COUNT(*) FROM `empleado` WHERE salario > 0 GROUP BY genero"; // Consulta SQL
$queryGenero = $con->query($sqlGenero); // Ejecutar la consulta SQL
$dataGenero = array(); // Array donde vamos a guardar los datos
while($rGenero = $queryGenero->fetch_object()){ // Recorrer los resultados de Ejecutar la consulta SQL
    $dataGenero[]=$rGenero; // Guardar los resultados en la variable $data
}


$sqlCountGenero = "SELECT genero, COUNT(*) as genero FROM empleado GROUP BY genero"; // Consulta SQL
$queryCountGenero = $con->query($sqlCountGenero); // Ejecutar la consulta SQL
$dataCountGenero = array(); // Array donde vamos a guardar los datos
while($rCountGenero = $queryCountGenero->fetch_object()){ // Recorrer los resultados de Ejecutar la consulta SQL
    $dataCountGenero[]=$rCountGenero; // Guardar los resultados en la variable $data
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafica de Barra y Lineas con PHP y MySQL</title>
    <script src="js/chart.min.js"></script>
</head>
<body>
<h1>Grafica de Barra de empleados por departamento</h1>
<canvas id="chart1" style="width: 500px;" height="100px;"></canvas>
<script>
var ctx = document.getElementById("chart1");
var data = {
        labels: [ 
        <?php foreach($data as $d):?>
        "<?php echo $d->departamento?>", 
        <?php endforeach; ?>
        ],
        datasets: [{
            label: '$ Empleados por departamento',
            data: [
        <?php foreach($dataCount as $c):?>
        <?php echo $c->departamento?>, 
        <?php endforeach; ?>
            ],
            backgroundColor: [
                "#C2DED1", "#ECE5C7", "#CDC2AE", "#354259", "#DF7861","#ECB390","#5F7161","#6D8B74","#D0C9C0","#F5DF99",
                "#6FB2D2","#F4BBBB","#BB9981","#65C18C"
            ],
            borderColor: "#9b59b6",
            borderWidth: 2
        }]
    };
var options = {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    };
var chart1 = new Chart(ctx, {
    type: 'bar', /* valores: line, bar,doughnut*/
    data: data,
    options: options
});
</script>
<!-- Inicia la grafica de genero -->
<?php


?>
<h1>Grafica de pastel de genero de los empleados</h1>
<canvas id="chart2" style="width: 500px;" height="100px;"></canvas>
<script>
var ctx = document.getElementById("chart2");
var data = {
        labels: [ 
        <?php foreach($dataGenero as $dGenero):?>
        "<?php echo $dGenero->genero?>", 
        <?php endforeach; ?>
        ],
        datasets: [{
            label: ' ',
            data: [
        <?php foreach($dataCountGenero as $cGenero):?>
        <?php echo $cGenero->genero?>, 
        <?php endforeach; ?>
            ],
            backgroundColor: [
                "#C2DED1", "#ECE5C7","#DF7861"
            ],
            borderColor: "#9b59b6",
            borderWidth: 2
        }]
    };
var options = {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    };
var chart1 = new Chart(ctx, {
    type: 'doughnut', /* valores: line, bar,doughnut*/
    data: data,
    options: options
});
</script>
</body>
</html>