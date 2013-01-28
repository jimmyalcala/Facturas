<!DOCTYPE HTML>
<html lang="en-US">
<head>
  <meta charset="UTF-8">
  <title></title>
</head>
<body>
<h1>Listado de Facturas desde el <?= $_POST['fecha_desde']?> hasta el <?= $_POST['fecha_hasta']?></h1>
<?php

/******** CONECTAR CON BASE DE DATOS **************** */
/******** Recuerda cambiar por tus datos ***********/ 
   $con = mysql_connect("localhost","root","");
   if (!$con){die('ERROR DE CONEXION CON MYSQL: ' . mysql_error());}
/* ********************************************** */
/********* CONECTA CON LA BASE DE DATOS  **************** */
   $database = mysql_select_db("");
   if (!$database){die('ERROR CONEXION CON BD: '.mysql_error());}
/* ********************************************** */
/*ejecutamos la consulta, que solicita nombre, precio y existencia de la
tabla productos */
$sql = "SELECT v.num_ven,DATE_FORMAT(v.fec_emi, '%d/%m/%y'), c.nom_cli, c.direccion,v.tot_exe,v.bas_imp,v.tot_isv,v.bas_impr,v.tot_isvr,v.tot_ven FROM ventas v left join clientes c on v.cod_cli=c.cod_cli  WHERE fec_emi>='"
      .$_POST['fecha_desde']."' and fec_emi<='"
      .$_POST['fecha_hasta']."'";

     

$result = mysql_query ($sql);
// verificamos que no haya error
if (! $result){
   echo "La consulta SQL contiene errores.".mysql_error();
   exit();
}else {
    // echo "<table border='1'><tr><td>Nombre</td><td>Precio</td><td>Existencia</td>
    //      </tr><tr>";
//obtenemos los datos resultado de la consulta
    while ($row = mysql_fetch_row($result)){
              echo "<hr>";
              echo '<br>';
              echo '<br>';
                echo "<b>Numero Factura:</b>".$row[0].'&nbsp;&nbsp; <b>Fecha:</b>'.$row[1];
              echo "<br>";
              echo "<b>Nombre Cliente :</b>".$row[2];
              echo "<br>";
              echo "<b>Dirección Cliente :</b>".$row[3];
              
              $sql2="select l.cod_art,l.des_art,l.cantidad,pre_fin,l.total from lininv l where (ori_mov='PVE' or ori_mov='VEN') and num_doc='".$row[0]."'";
              $lineas = mysql_query ($sql2);
              if ($lineas){
                echo '<table border="1">';
                echo "<tr><th>Cantidad</th><th>Descripción</th><th>Precio</th><th>Total</th></tr>";
                while ($linea = mysql_fetch_row($lineas)){
                  echo '<tr>';
                  echo '<td>'.$linea[2]."</td>";
                  echo '<td>'.$linea[1].'</td>'; 
                  echo '<td>'.$linea[3].'</td>';
                  echo '<td>'.$linea[4].'</td>';

                  echo'</tr>';
                }
                echo "</table>";
              }
                else { echo "La consulta SQL contiene errores.".mysql_error();
              }
              if ($row[4]>0){
                echo '<b>Total Excento :</b>'.$row[4];
                echo '<br>';
              }
              if ($row[5]>0){
                echo '<b>Base imponible general :</b>'.$row[5];
                echo '<br>';
                echo '<b>Iva general :</b>'.$row[6];
                echo '<br>';
              }
              if ($row[7]>0){
                echo '<b>Base imponible reducido :</b>'.$row[7];
                echo '<br>';
                echo '<b>Iva reducido :</b>'.$row[8];
                echo '<br>';
              }
             echo '<b>Total Venta :</b>'.$row[9];
             echo '<br>';
             echo '<br>';
             echo '<br>';
            }

          

 }
?> 

  
</body>
</html>
