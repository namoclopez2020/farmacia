<style type="text/css">
<!--
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }
.midnight-blue{
	background:#2c3e50;
	padding: 4px 4px 4px;
	color:white;
	font-weight:bold;
	font-size:12px;
}
.silver{
	background:white;
	padding: 3px 4px 3px;
}
.clouds{
	background:#ecf0f1;
	padding: 3px 4px 3px;
}
.border-top{
	border-top: solid 1px #bdc3c7;
	
}
.border-left{
	border-left: solid 1px #bdc3c7;
}
.border-right{
	border-right: solid 1px #bdc3c7;
}
.border-bottom{
	border-bottom: solid 1px #bdc3c7;
}
table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}
}
-->
</style>
<?php 
include("includes/load.php");

$id_cliente=$_GET["id_cliente"];
$sql_cliente=$db->query("select * from clientes where id_cliente='$id_cliente'");

$sql=$db->query("select LAST_INSERT_ID(numero_factura) as last from facturas order by id_factura desc limit 0,1 ");
$rw=$db->fetch_array($sql);
$numero_factura=$rw['last']+1;

$id_vendedor=$_GET["id_vendedor"];
$condiciones=$_GET["condiciones"];

?>
<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial" >
        <page_footer>
        <table class="page_footer">
            <tr>

                <td style="width: 50%; text-align: left">
                    
                </td>
                <td style="width: 50%; text-align: right">
                    &copy; <?php echo "Mr Robot "; echo  $anio=date('Y'); ?>
                </td>
            </tr>
        </table>
    </page_footer>
    <table cellspacing="0" style="width: 100%;">
        <tr>

            <td style="width: 25%; color: #444444;">
                <img style="width: 50%;" src="libs/images/mr robot logo.png" alt="Logo"><br>
                
            </td>
			<td style="width: 50%; color: #34495e;font-size:12px;text-align:center">
                <span style="color: #34495e;font-size:14px;font-weight:bold"> FARMAOASIS</span>
				<br>Asoc. Oasis Dorado Mz A Lt 16 Carabayllo _Lima-Perú<br> 
				
				
				RUC: 1040983593
                
            </td>
			<td style="width: 25%;text-align:right">
			COMPROBANTE Nº <?php echo $numero_factura;?>
			</td>
			
        </tr>
    </table>
    <br>
    

	
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           <td style="width:50%;" class='midnight-blue'>CLIENTE</td>
        </tr>
		<tr>
           <td style="width:50%;" >
			<?php 
				
				$rw_cliente=$db->fetch_array($sql_cliente);
				echo $rw_cliente['nombre_cliente'];
				echo "<br>";
				echo $rw_cliente['direccion_cliente'];
				echo "<br> Teléfono: ";
				echo $rw_cliente['telefono_cliente'];
				echo "<br> Email: ";
				echo $rw_cliente['email_cliente'];
			?>
			
		   </td>
        </tr>
        
   
    </table>
    
       <br>
		<table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           <td style="width:35%;" class='midnight-blue'>VENDEDOR</td>
		  <td style="width:25%;" class='midnight-blue'>FECHA</td>
		   <td style="width:40%;" class='midnight-blue'>FORMA DE PAGO</td>
        </tr>
		<tr>
           <td style="width:35%;">
			<?php 
				$sql_user=$db->query("select * from users where id='$id_vendedor'");
				$rw_user=$db->fetch_array($sql_user);
				echo $rw_user['name'];
			?>
		   </td>
		  <td style="width:25%;"><?php echo date("d/m/Y");?></td>
		   <td style="width:40%;" >
				<?php 
				if ($condiciones==1){echo "Efectivo";}
				elseif ($condiciones==2){echo "Cheque";}
				elseif ($condiciones==3){echo "Transferencia bancaria";}
				elseif ($condiciones==4){echo "Crédito";}
				?>
		   </td>
        </tr>
		
        
   
    </table>
	<br>
  
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
        <tr>
            <th style="width: 10%;text-align:center" class='midnight-blue'>CANT.</th>
            <th style="width: 60%" class='midnight-blue'>DESCRIPCION</th>
            <th style="width: 15%;text-align: right" class='midnight-blue'></th>
            <th style="width: 15%;text-align: right" class='midnight-blue'>PRECIO TOTAL</th>
            
        </tr>

<?php
$s_date    = make_date();
$nums=1;
$sumador_total=0;
$session_id=$_SESSION['user_id'];
$sql_cliente=$db->query("select * from clientes where id_cliente='$id_cliente'");
$rw_cliente=$db->fetch_array($sql_cliente);
$nombre_cliente=$rw_cliente['nombre_cliente'];	
$sql=$db->query("select * from products, tmp where products.id=tmp.id_producto and tmp.session_id='".$session_id."'");
$tipo_movimiento=2;
		
while ($row=$db->fetch_array($sql))
	{
	$id_tmp=$row["id_tmp"];
	$id_producto=$row["id"];
	$codigo_producto=$row['codigo_producto'];
	$cantidad=$row['cantidad_tmp'];
	$nombre_producto=$row['name'];
	$id_sucursal=$row['id_sucursal'];
	
	$precio_venta=$row['precio_tmp'];
	$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	$precio_total=$precio_venta_r;
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	$sumador_total+=$precio_total_r;//Sumador
    $insertar=$db->query("insert into sales (product_id,qty,price,date,nom_cliente,id_vendedor,id_sucursal,numero_factura) values ('".$id_producto."','".$cantidad."', '".$precio_total_r."','".$s_date."','".$nombre_cliente."','".$id_vendedor."','".$id_sucursal."','".$numero_factura."')");
	//actualizar el stock en el producto
    stock_final_producto_venta($cantidad,$id_producto);
	 insertar_movimiento_producto($id_producto,$tipo_movimiento,$cantidad,$_SESSION['user_id'],$s_date);
				
	
	if ($nums%2==0){
		$clase="clouds";
	} else {
		$clase="silver";
	}
	?>

        <tr>
            <td class='<?php echo $clase;?>' style="width: 10%; text-align: center"><?php echo $cantidad; ?></td>
            <td class='<?php echo $clase;?>' style="width: 60%; text-align: left"><?php echo $nombre_producto;?></td>
            <td class='<?php echo $clase;?>' style="width: 15%; text-align: right">&nbsp;</td>
            <td class='<?php echo $clase;?>' style="width: 15%; text-align: right"><?php echo $precio_total_f;?></td>
            
        </tr>

	<?php 
	//Insert en la tabla detalle_cotizacion
	$insert_detail=$db->query("INSERT INTO detalle_factura (numero_factura,id_producto,cantidad,precio_venta) VALUES ('$numero_factura','$id_producto','$cantidad','$precio_venta_r')");
	
	$nums++;
	}
	
	$total_factura= number_format($sumador_total,2,'.','');
	$total_iva=($total_factura * 18 )/100;
	$total_iva=number_format($total_iva,2,'.','');
	$subtotal=$total_factura-$total_iva;
?>
	  
        <tr>
            <td colspan="3" style="widtd: 85%; text-align: right;">SUBTOTAL $/. </td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($subtotal,2);?></td>
        </tr>
		<tr>
            <td colspan="3" style="widtd: 85%; text-align: right;">IGV (<?php echo "18" ?>)%  </td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($total_iva,2);?></td>
        </tr><tr>
            <td colspan="3" style="widtd: 85%; text-align: right;">TOTAL $/. </td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($total_factura,2);?></td>
        </tr>
    </table>
	
	
	
	<br>
	<div style="font-size:11pt;text-align:center;font-weight:bold">Gracias por su compra!</div>
	
	
	  

</page>




<?php
$date=	make_date();
$insert=$db->query( "INSERT INTO facturas (numero_factura,fecha_factura,id_vendedor,condiciones,total_venta,estado_factura) VALUES ('$numero_factura','$date','$id_vendedor','$condiciones','$total_factura',1)");
$delete=$db->query("DELETE FROM tmp WHERE session_id='".$session_id."'");
?>