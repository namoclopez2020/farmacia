<?php
require_once('../includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
  
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         
		 $sucu=$_REQUEST['sucursal'];
		 $aColumns = array('name');//Columnas de busqueda
		 $sTable = "products";
		 $sWhere = "";
		$sWhere = "WHERE ";
		$sWhere.="(quantity='0f0' or quantity='0F0') ";
		if($sucu!=""){
			
			 $sWhere.= " and id_sucursal=".$sucu." ";
		 }
		
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 30; //cuantos registros se quieren mostrar en una pagina
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//cuenta la cantidad de filas*/
		$count_query   = $db->query( "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row=$db->fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './index.php';
		//main query to fetch the data
		
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";}
		
		$query = $db->query($sql);
		//loop through fetched data
		if ($numrows>0 ){
			$fecha_hoy=date('Y-m-d');
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr class="warning">
                <th class="text-center" style="width: 50px;">#</th>
                <th> Imagen</th>
                <th> Descripción </th>
                <th class="text-center" style="width: 10%;"> Categoría </th>
                <th class="text-center" style="width: 10%;"> Stock </th>
                <th class="text-center" style="width: 10%;"> Precio de compra </th>
                <th class="text-center" style="width: 10%;"> Precio de venta </th>
				  <th class="text-center" style="width: 10%;"> Laboratorio </th>
				   <th class="text-center" style="width: 10%;"> Sucursal </th>
                <th class="text-center" style="width: 10%;"> Agregado </th>
				<th class="text-center" style="width: 10%;"> Fecha de Caducidad </th>  
                <th class="text-center" style="width: 100px;"> Acciones </th>
              </tr>
				<?php
			
				while ($row=$db->fetch_array($query)){
					$id_producto=$row['id'];
					$fecha_agregado=$row['date'];
					$codigo_producto=$row['codigo_producto'];
					$nombre_producto=$row['name'];
					$costo=$row['buy_price'];
					$precio_venta=$row["sale_price"];
					$precio_unitario=$row['precio_unidad'];
					$compuesto=$row['compuesto_prod'];
					$precio_por_blister=$row['precio_blister'];
					$imagen=$row['media_id'];
					$id_categoria=$row['categorie_id'];
					$id_sucursal=$row['id_sucursal'];
					$fecha_caducidad=$row['fecha_caducidad'];
					$laboratorio=$row['laboratorio'];
					$query1=$db->query("SELECT * FROM categories WHERE id='$id_categoria'");
					while ($cat=$db->fetch_array($query1)){
						$categoria=$cat['name'];
					}
					$query2=$db->query("SELECT * FROM sucursales WHERE id='$id_sucursal'");
					while ($suc=$db->fetch_array($query2)){
						$sucursal=$suc['nombre_sucursal'];
					}
					$precio_unitario=number_format($precio_unitario,2);
					$precio_venta=number_format($precio_venta,2);
					$precio_por_blister=number_format($precio_por_blister,2);
					$stock=$row["quantity"];
					$visto=$row["visto"];
					//define el color de la fila
					if($visto=="si"){
						$style="#F8FFA5";
					}else{
					$style="";	
					}
					
					?>
					<tr bgcolor="<?php echo $style;?>">
                <td class="text-center"><?php echo count_id();?></td>
                <td>
                  <?php if($imagen === '0'): ?>
                    <img class="img-avatar img-circle" src="uploads/products/no_image.jpg" alt="">
                  <?php else: ?>
                  <img class="img-avatar img-circle" src="uploads/products/<?php echo $imagen; ?>" alt="">
                <?php endif; ?>
                </td>
                <td> <?php echo remove_junk($nombre_producto); ?></td>
                <td class="text-center"> <?php echo remove_junk($categoria); ?></td>
                <td class="text-center"> <?php echo remove_junk($stock); ?></td>
                <td class="text-center"> <?php echo remove_junk($costo); ?></td>
                <td class="text-center"> <?php echo remove_junk($precio_venta); ?></td>
				<td class="text-center"> <?php echo remove_junk($laboratorio); ?></td>
				  
				  
				<td bgcolor="<?php if($id_sucursal==4){echo "red";}else{echo "blue";}?>"><font color="white"> <?php echo remove_junk($sucursal); ?></td>
				 
                <td class="text-center"> <?php echo read_date($fecha_agregado); ?></td>
				<td class="text-center"> <?php echo read_date($fecha_caducidad); ?></td>
                <td class="text-center">
                  <div class="btn-group">
					  <form action="product_agotado.php" method="post" name="form1" >
					<input type="text" name="id_producto" value="<?php echo (int)$id_producto;?>" hidden> 
					<?php if($visto=="si"){
						?><input type="submit" value ="Desmarcar" name="desmarcar" class="btn btn-warning btn-xs" title="Desmarcar" data-toggle="tooltip"> <?php
					}else{
						
						?><input type="submit" value ="Marcar" name="marcar" class="btn btn-success btn-xs" title="Marcar" data-toggle="tooltip"> <?php
					}
						  ?>
					  
					  </form>
                    <a href="edit_product.php?id=<?php echo (int)$id_producto;?>" class="btn btn-info btn-xs"  title="Editar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                     <a href="delete_product.php?id=<?php echo (int)$id_producto;?>" class="btn btn-danger btn-xs"  title="Eliminar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
                </td>
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
			  </table>
			</div>
