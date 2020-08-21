<?php
	require_once('../includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);

  $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
   
	if (isset($_GET['id'])  ){
		if(page_require_level(1)){
		$numero_factura=intval($_GET['id']);
		$del1="delete from facturas where numero_factura='".$numero_factura."'";
		$del2="delete from detalle_factura where numero_factura='".$numero_factura."'";
	   $del3="delete from sales where numero_factura='".$numero_factura."'";
		if ($delete1=$db->query($del1) and $delete2=$db->query($del2) and $delete3=$db->query($del3)){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se puedo eliminar los datos
			</div>
			<?php
			
		}
		}else{
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No tienes permiso para eliminar boletas
			</div>
			<?php
			
		}
	}

	
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = $db->escape((strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $suc=$_REQUEST['suc'];
		 $inicio= $_REQUEST['start'];
		 $fin=$_REQUEST['end'];
		 $vendedor=$_REQUEST['ven'];
		  $sTable = "facturas, users,products, detalle_factura,sales";
		 $sWhere = "";
		 $sWhere.=" WHERE facturas.id_vendedor=users.id AND facturas.numero_factura=detalle_factura.numero_factura and
		 detalle_factura.id_producto=products.id and facturas.numero_factura=sales.numero_factura AND";
		if ( $_GET['q'] != "" )
		{
		$sWhere.= "(products.name like '%$q%') and";
			
		} 
		if($_GET['suc'] !=""){
			$sWhere.=" (sales.id_sucursal='$suc') AND";
		}
		if($_GET['start'] !="" && $_GET['end']!=''){
			$sWhere.=" (facturas.fecha_factura between '$inicio' and '$fin') AND";
		}
		if($_GET['ven']!=""){
			$sWhere.=" (facturas.id_vendedor='$vendedor') AND";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		
		$sWhere.=" order by facturas.id_factura desc";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = $db->query("SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= $db->fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './facturas.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = $db->query($sql);
		//loop through fetched data
		if ($numrows>0){
			echo $db->error();
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>#</th>
					<th>Fecha</th>
					
					<th>Vendedor</th>
					<th>Estado</th>
					<th class='text-right'>Total</th>
					<th class='text-right'>Acciones</th>
					
				</tr>
				<?php
				while ($row=$db->fetch_array($query)){
						$id_factura=$row['id_factura'];
						$numero_factura=$row['numero_factura'];
						$fecha=date("d/m/Y G:i:s", strtotime($row['fecha_factura']));
						$id_vendedor=$row['id_vendedor'];
					    $nombre_vendedor_sql=$db->query("select name from users where id='$id_vendedor'");
					    $nombre_vende=$db->fetch_array($nombre_vendedor_sql);
					    $nombre_vendedor=$nombre_vende['name'];
						$estado_factura=$row['estado_factura'];
						if ($estado_factura==1){$text_estado="Pagada";$label_class='label-success';}
						else{$text_estado="Pendiente";$label_class='label-warning';}
						$total_venta=$row['total_venta'];
					?>
					<tr>
						<td><?php echo $numero_factura; ?></td>
						<td><?php echo $fecha; ?></td>
						
						<td><?php echo $nombre_vendedor; ?></td>
						<td><span class="label <?php echo $label_class;?>"><?php echo $text_estado; ?></span></td>
						<td class='text-right'><?php echo number_format ($total_venta,2); ?></td>					
					<td class="text-right">
						<a href="editar_factura.php?id_factura=<?php echo $id_factura;?>" class='btn btn-default' title='Editar boleta' ><i class="glyphicon glyphicon-edit"></i></a> 
						<a href="#" class='btn btn-default' title='Ver Boleta' onclick="imprimir_factura('<?php echo $id_factura;?>');"><i class="glyphicon glyphicon-download"></i></a> 
						<a href="#" class='btn btn-default' title='Borrar boleta' onclick="eliminar('<?php echo $numero_factura; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>
					</td>
						
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=7><span class="pull-right"><?
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>