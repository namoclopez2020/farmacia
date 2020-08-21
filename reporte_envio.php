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

$sucursal_destino=$_GET['id_sucursal_ultimo'];
$sucursal_inicial=$_GET['id_sucursal_inicio'];
$query=$db->query("SELECT * FROM sucursales WHERE id='$sucursal_inicial'");
$query1=$db->query("SELECT * FROM sucursales WHERE id='$sucursal_destino'");
while($res=$db->fetch_array($query)){
	$nombre_sucursal_inicio=$res['nombre_sucursal'];
}
while($res1=$db->fetch_array($query1)){
	$nombre_sucursal_destino=$res1['nombre_sucursal'];
}

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
			
			<br><br><br>
			<td style="width: 50%; color: #34495e;font-size:12px;text-align:center">
                <span style="color: #34495e;font-size:14px;font-weight:bold"> Farmacia </span>
				<br>Envio de Productos desde: <?php echo $nombre_sucursal_inicio."<br>";?>
				Hacia: <?php echo $nombre_sucursal_destino;?>
                
            </td>
			
			
        </tr>
    </table>
    <br>
    
       <br>
	<br>
  
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
        <tr>
            <th style="width: 10%;text-align:center" class='midnight-blue'>CANT.</th>
            <th style="width: 60%" class='midnight-blue'>DESCRIPCION</th>
            <th style="width: 15%;text-align: right" class='midnight-blue'>SUCURSAL PROVENIENTE</th>
            
            
        </tr>

<?php
$s_date    = make_date();
$nums=1;
$session_id=$_SESSION['user_id'];
$sql=$db->query("select * from products, tmp_envio where products.id=tmp_envio.id_producto and tmp_envio.session_id='".$session_id."'");
		
while ($row=$db->fetch_array($sql))
	{
	$id_producto=$row['id'];
	$codigo_producto=$row['id']+1;
	$codigo_producto="P0".$codigo_producto;
	$nombre_producto=$row['name'];
	$cantidad=$row['cantidad_producto'];
	$buy_price=$row['buy_price'];
	$sale_price=$row['sale_price'];
	$categorie_id=$row['categorie_id'];
	$media_id=$row['media_id'];
	$date=$row['date'];
	$prov=$row['prov'];
	$compuesto_prod=$row['compuesto_prod'];
	$id_sucursal=$row['id_sucursal'];
	$visto=$row['visto'];
	$cantidad_blister=$row['cantidad_blister'];
	$precio_blister=$row['precio_blister'];
	$cantidad_unidad=$row['cantidad_unidad'];
	$precio_unidad=$row['precio_unidad'];
	$fecha_caducidad=$row['fecha_caducidad'];
	$laboratorio=$row['laboratorio'];
	//consulta para encontrar algun repetido en la sucursal de destino
	$validar="SELECT * FROM products where name='$nombre_producto' and categorie_id=$categorie_id  and compuesto_prod='$compuesto_prod' and id_sucursal=$sucursal_destino and cantidad_blister=$cantidad_blister  and cantidad_unidad=$cantidad_unidad  and laboratorio='$laboratorio' LIMIT 1";
	$ver=$db->query($validar);

	if($db->num_rows($ver)>0){
		foreach($ver as $datos){
			$id_prod=$datos['id'];
			
		}
		//$cantidad = cantidad enviada de un local a otro
		//$id_prod=  id del producto repetido
		$stock_sumar=sumar_stock($cantidad,$id_prod);
		$query_sumar="UPDATE products SET quantity='$stock_sumar' WHERE id='$id_prod'";
		$sumar=$db->query($query_sumar);
		$tipo_movimiento=4;
		insertar_movimiento_producto($id_prod,$tipo_movimiento,$cantidad,$_SESSION['user_id'],$s_date);
	}
	else{
	
    $query  = "INSERT INTO products (";
     $query .=" quantity,name,codigo_producto,buy_price,sale_price,categorie_id,media_id,prov,date,compuesto_prod,id_sucursal,visto,cantidad_blister,precio_blister,cantidad_unidad,precio_unidad,fecha_caducidad,laboratorio";
     $query .=") VALUES (";
     $query .=" '{$cantidad}','{$nombre_producto}','{$codigo_producto}', '{$buy_price}', '{$sale_price}', '{$categorie_id}', '{$media_id}', '{$prov}', '{$date}','{$compuesto_prod}','{$sucursal_destino}','{$visto}','{$cantidad_blister}','{$precio_blister}','{$cantidad_unidad}','{$precio_unidad}','{$fecha_caducidad}','{$laboratorio}'";
     $query .=")";
	$db->query($query);
		//capturar el id del producto recien creado
		 $consulta="select LAST_INSERT_ID(id) as last from products order by id desc limit 0,1 ";
		 $id=$db->query($consulta);
		 $id=$db->fetch_array($id);
		 $id_produ=$id['last'];
		 $tipo_movimiento=7;
	 insertar_movimiento_producto($id_produ,$tipo_movimiento,$cantidad,$_SESSION['user_id'],$s_date);
		
	}
	//actualizar el stock del producto remitente 
   	stock_final_producto_venta($cantidad,$id_producto);
	$tipo_movimiento=3;
	 insertar_movimiento_producto($id_producto,$tipo_movimiento,$cantidad,$_SESSION['user_id'],$s_date);

				
	
	if ($nums%2==0){
		$clase="clouds";
	} else {
		$clase="silver";
	}
	$nums++;
	?>

        <tr>
            <td class='<?php echo $clase;?>' style="width: 10%; text-align: center"><?php echo $cantidad; ?></td>
            <td class='<?php echo $clase;?>' style="width: 60%; text-align: left"><?php echo $nombre_producto;?></td>
            <td class='<?php echo $clase;?>' style="width: 15%; text-align: right"><?php echo $nombre_sucursal_inicio?></td>
            
            
		</tr>
		<?php }?>
    </table>
	
	
	
	<br>
	<div style="font-size:11pt;text-align:center;font-weight:bold">Conforme <?php echo	date("Y-m-d H:i:s");?></div>
	
	
	  

</page>




<?php
$delete=$db->query("DELETE FROM tmp_envio WHERE session_id='".$session_id."'");
?>