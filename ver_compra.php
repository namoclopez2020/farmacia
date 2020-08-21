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
$id_factura=$_GET["id_factura"];
$fact=$db->query("SELECT * FROM compras WHERE id_compra='".$id_factura."'");
$datos_factura=$db->fetch_array($fact);
$numero_factura=$datos_factura['numero_compra'];
$id_vendedor=$datos_factura['id_proveedor'];
$condiciones=$datos_factura['metodo_pago'];

$fecha_factura=$datos_factura['fecha_compra'];

?>
<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial" >
        <page_footer>
        <table class="page_footer">
            <tr>

                <td style="width: 50%; text-align: left">
                    
                </td>
                <td style="width: 50%; text-align: right">
                    &copy; <?php echo "Mr. Robot "; echo  $anio=date('Y'); ?>
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
                <span style="color: #34495e;font-size:14px;font-weight:bold">OASISFARMA</span>
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
           <td style="width:30%;" class='midnight-blue'>PROVEEDOR</td>
			<td style="width:30%;" class='midnight-blue'>RUC</td>
			<td style="width:30%;" class='midnight-blue'>TELEFONO</td>
        </tr>
		<tr>
           <td style="width:30%;" >
			<?php 
				$sql_cliente=$db->query("select * from proveedores where id_prov='$id_vendedor'");
				$rw_cliente=$db->fetch_array($sql_cliente);
				echo $rw_cliente['nom_empresa'];
				
				
				
			?>
			
		   </td>
			<td style="width:30%;">
			<?php 
				echo $rw_cliente['telef_prov'];?></td>
			<td style="width:30%;"> <?php 
				
				echo $rw_cliente['ruc_proveedor'];
				?></td>
        </tr>
        
   
    </table>
	<table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           <td style="width:50%;" class='midnight-blue'>SUCURSAL</td>
        </tr>
		<tr>
           <td style="width:50%;" >
			<?php 
			   $sql_sucursal=$db->query("select * from products, detalle_compra, compras where products.id=detalle_compra.id_producto_compra and detalle_compra.num_compra=compras.numero_compra and compras.id_compra='".$id_factura."'");
			   
				$rw_sucursal=$db->fetch_array($sql_sucursal);
			    $id_sucursal=$rw_sucursal['id_sucursal'];
			    $sucursal=$db->query("select * from sucursales where id='$id_sucursal'");
				$nombre_sucursal=$db->fetch_array($sucursal);
			   echo $nombre_sucursal['nombre_sucursal'];
				
			?>
			
		   </td>
        </tr>
        
   
    </table>
    
       <br>
		<table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           
		  <td style="width:25%;" class='midnight-blue'>FECHA</td>
		   <td style="width:40%;" class='midnight-blue'>FORMA DE PAGO</td>
        </tr>
		<tr>
           
		  <td style="width:25%;"><?php 
			  ini_set('date.timezone','America/Lima');
			  echo date("d/m/Y", strtotime($fecha_factura));?></td>
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
            <th style="width: 15%;text-align: right" class='midnight-blue'>PRECIO UNIT.</th>
            <th style="width: 15%;text-align: right" class='midnight-blue'>PRECIO TOTAL</th>
            
        </tr>

<?php
$nums=1;
$sumador_total=0;
$sql=$db->query("select * from products, detalle_compra, compras where products.id=detalle_compra.id_producto_compra and detalle_compra.num_compra=compras.numero_compra and compras.id_compra='".$id_factura."'");

while ($row=$db->fetch_array($sql))
	{
	$id_producto=$row["id_producto_compra"];
	$codigo_producto=$row['codigo_producto'];
	$cantidad=$row['cantidad_compra'];
	$nombre_producto=$row['name'];
	
	$precio_venta=$row['costo_compra'];
	$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	$precio_total=$precio_venta_r;
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	$sumador_total+=$precio_total_r;//Sumador
	if ($nums%2==0){
		$clase="clouds";
	} else {
		$clase="silver";
	}
	?>

        <tr>
            <td class='<?php echo $clase;?>' style="width: 10%; text-align: center"><?php echo $cantidad; ?></td>
            <td class='<?php echo $clase;?>' style="width: 60%; text-align: left"><?php echo $nombre_producto;?></td>
            <td class='<?php echo $clase;?>' style="width: 15%; text-align: right"><?php echo $precio_venta_f;?></td>
            <td class='<?php echo $clase;?>' style="width: 15%; text-align: right"><?php echo $precio_total_f;?></td>
            
        </tr>

	<?php 

	
	$nums++;
	}
	
	$total_factura= number_format($sumador_total,2,'.','');
	$total_iva=($total_factura * 18 )/100;
	$total_iva=number_format($total_iva,2,'.','');
	$subtotal=$total_factura-$total_iva;
?>
	  
        <tr>
            <td colspan="3" style="widtd: 85%; text-align: right;">SUBTOTAL &#36; </td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($subtotal,2);?></td>
        </tr>
		<tr>
            <td colspan="3" style="widtd: 85%; text-align: right;">IGV (<?php echo "18" ?>)% &#36; </td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($total_iva,2);?></td>
        </tr><tr>
            <td colspan="3" style="widtd: 85%; text-align: right;">TOTAL &#36; </td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($total_factura,2);?></td>
        </tr>
    </table>
	
	
	
	<br>
	<div style="font-size:11pt;text-align:center;font-weight:bold">Gracias por su compra!</div>
	
	
	  

</page>
