<?php
require_once('../includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if(isset($_POST['ajax'])){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = $db->escape((strip_tags($_POST['q'], ENT_QUOTES)));
		 $sucu= $_POST['sucursal'];
		
		 $aColumns = array('name','compuesto_prod');//Columnas de busqueda
		 $sTable = "products";
		 $sWhere = "";
		if ( $_POST['q'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
	     
			
			$sWhere .= ')';
			if($sucu!=""){
			 $sWhere.= " AND id_sucursal=".$sucu." ";
		 }
		}
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 5; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   =$db->query("SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= $db->fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './index.php';
		//main query to fetch the data
		
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";}
		
		$query = $db->query($sql);
		//loop through fetched data
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="warning">
					<th>Código</th>
					<th>Producto</th>
					<th>Composición</th>
					<th>Laboratorio</th>
					<th>Sucursal</th>
					<th>Stock</th>
					<th><span class="pull-right">Cant.</span></th>
					<th><span class="pull-right">Precio</span></th>
					<th class='text-center' style="width: 36px;">Agregar</th>
				</tr>
				<?php
		if ($numrows>0 && $sWhere!=""){
			$fecha_hoy=date('Y-m-d');
			
			
				while ($row=$db->fetch_array($query)){
					$id_producto=$row['id'];
					$codigo_producto=$row['codigo_producto'];
					$nombre_producto=$row['name'];
					$precio_venta=$row["sale_price"];
					$precio_unitario=$row['precio_unidad'];
					$compuesto=$row['compuesto_prod'];
					$precio_por_blister=$row['precio_blister'];
					$laboratorio=$row['laboratorio'];
					$id_categoria=$row['categorie_id'];
					$id_sucursal=$row['id_sucursal'];
					$fecha_caducidad=$row['fecha_caducidad'];
					$query1=$db->query("SELECT * FROM categories WHERE id='$id_categoria'");
					while ($cat=$db->fetch_array($query1)){
						$categoria=$cat['name'];
					}
					$query2=$db->query("SELECT * FROM sucursales WHERE id='$id_sucursal'");
					while ($suc=$db->fetch_array($query2)){
						$sucursal=$suc['nombre_sucursal'];
					}
					//$precio_unitario=number_format($precio_unitario,2);
					//$precio_venta=number_format($precio_venta,2);
					//$precio_por_blister=number_format($precio_por_blister,2);
					$stock=$row["quantity"];
					
					if($stock!="0F0" || $stock!="0f0"){
					?>
					<tr>
						<td><?php echo $codigo_producto; ?></td>
						<td><?php echo $nombre_producto; ?></td>
						<td><?php echo $compuesto; ?></td>
						<td><?php echo $laboratorio; ?></td>
						<td bgcolor="<?php if($id_sucursal==4){echo "red";}else{echo "blue";}?>"><font color="white"><?php echo $sucursal;?></font></td>
						<td class="text-center"><?php echo $stock;?></td>
						<td class='col-xs-1'>
						<div class="pull-right">
						<input type="text" class="form-control" style="text-align:right" id="cantidad_<?php echo $id_producto; ?>"  value="1F0" >
						</div></td>
						<td class='col-xs-2'><div class="pull-right">
						<input type="hidden"  id="stock_<?php echo $stock; ?>"  value="<?php echo $stock;?>" >	
						<input type="text"  id="precio_venta_<?php echo $id_producto; ?>"  value="<?php echo $precio_venta;?>"  hidden>
							<label><?php if($id_categoria=='16' || $id_categoria=='17'){
						echo " UNIDAD  S/. ".$precio_unitario."<br>
								BLISTER  S/. ".$precio_por_blister."<br>
								CAJA  S/. ".$precio_venta."<br>" ;
						
						
						}else{ echo "UNIDAD S/. ".$precio_unitario;}?></label>
						</div></td>
						<td class='text-center'><a class='btn btn-info'href="#" onclick="agregar('<?php echo $id_producto ?>')"><i class="glyphicon glyphicon-plus"></i></a></td>
					</tr>
					<?php
				}
				}
			
				?>
				<tr>
					<td colspan=5><span class="pull-right"><?
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  
			<?php
		}else{
			?> 
				  <tr><td>No se encontraron resultados</td></tr>
				  <?php
		}
	
?>
				  </table>
			</div>