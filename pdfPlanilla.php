<?php
include "Conexion.php";
$db =  connect();
$query=$db->query("select * from planillas");
$clientes = array();
$n=0;
while($r=$query->fetch_object()){ 
  $clientes[]=$r; $n++;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="bootstrap/js/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="jspdf/dist/jspdf.min.js"></script>
    <script src="js/jspdf.plugin.autotable.min.js"></script>

</head>
<body>
<div class="col-md-4">
<p><strong>Creando PDF para las planillas de empleados.</strong></p>
<button id="GenerarMysql" class="btn btn-default">Crear PDF</button>
<br>
</div>
<script>
$("#GenerarMysql").click(function(){
  var pdf = new jsPDF();
  pdf.text(20,20,"Planilla de empleados");

  var columns = ["id","Nombre", "Numero isss", "Ocupacion", "Sueldo", "Dias trabajado","Horas EX","isss","AFP","otros","Recibo"];
  var data = [
<?php foreach($clientes as $c):?>
 [<?php echo $c->id; ?>, "<?php echo $c->Nombre; ?>", "<?php echo $c->Numeroisss; ?>", "<?php echo $c->Ocupacion; ?>", "<?php echo $c->Sueldo; ?>", "<?php echo $c->DiasTrabajo; ?>", "<?php echo $c->HorasEx; ?>"
 , "<?php echo $c->Isss; ?>", "<?php echo $c->AFP; ?>", "<?php echo $c->Otros; ?>", "<?php echo $c->Recibo; ?>"],
<?php endforeach; ?>  
  ];

  pdf.autoTable(columns,data,
    { 
      startX: false,
      columnWidth: 'wrap',
      showHeader: 'everyPage',
      tableWidth: 'auto',
      theme: 'grid',
      styles: {overflow: 'linebreak', font: 'arial', fontSize: 10, overflowColumns: 'linebreak'},
      margin:{ top: 25  }}
  );

  pdf.save('planilla de empleados.pdf');

});
</script>
</body>
</html>