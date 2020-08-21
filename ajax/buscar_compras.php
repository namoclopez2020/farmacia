<?php
	require_once('../includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);

  $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
   
	if (isset($_GET['id'])  ){
		if(page_require_level(1)){
		$numero_factura=intval($_GET['id']);
		$del1="delete from compras where numero_compra='".$numero_factura."'";
		$del2="delete from detalle_compra where num_compra='".$numero_factura."'";
	   
		if ($delete1=$db->query($del1) and $delete2=$db->query($del2) ){
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

	
	if(isset($_POST['ajax']) ){
		// escaping, additionally removing everything that could be (html/javascript-) code
		
         $q =$db->escape((strip_tags($_POST['q'], ENT_QUOTES)));
		
		 $suc=$_POST['suc'];
		 $inicio= $_POST['start'];
		 $fin=$_POST['end'];
		 $vendedor=$_POST['ven'];
		$sTable=" compras as c LEFT JOIN proveedores as prov ON prov.id_prov=c.id_proveedor LEFT JOIN detalle_compra as d ON d.num_compra=c.numero_compra LEFT JOIN products as p ON p.id=d.id_producto_compra ";
		if($_POST['q']!="" || $_POST['suc']!="" || ($_POST['start']!="" && $_POST['end']!="") || $_POST['ven']!=""){
			$sWhere="where ";
		}else{$sWhere = "";}
		 
		
		if ( $_POST['q'] != "" )
		{
		$sWhere.= "p.name like '%$q%' and";
			
		} 
		if($_POST['suc'] !=""){
			$sWhere.=" p.id_sucursal='$suc'  AND";
		}
		if($_POST['start'] !="" && $_POST['end']!=''){
			$sWhere.=" c.fecha_compra between '$inicio' and '$fin' AND";
		}
		if($_POST['ven']!=""){
			$sWhere.=" c.id_proveedor='$vendedor' AND";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		
		$sWhere.=" GROUP BY c.id_compra,p.id_sucursal order by c.id_compra desc";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_GET['page']) && !empty($_GET['page']))?$_GET['page']:1;
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
		$sql="SELECT c.id_compra,c.numero_compra,c.fecha_compra,c.id_proveedor,c.metodo_pago,c.costo_total_compra,p.id_sucursal FROM  $sTable $sWhere LIMIT $offset,$per_page";
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
						$id_factura=$row['id_compra'];
						$numero_factura=$row['numero_compra'];
						$fecha=date("d/m/Y G:i:s", strtotime($row['fecha_compra']));
						$id_proveedor=$row['id_proveedor'];
					    $nombre_proveedor_sql=$db->query("select nom_empresa from proveedores where id_prov='$id_proveedor'");
					    $nombre_prov=$db->fetch_array($nombre_proveedor_sql);
					    $nombre_proveedor=$nombre_prov['nom_empresa'];
						$metodo_pago=$row['metodo_pago'];
						if ($metodo_pago==1){$text_estado="Efectivo";$label_class='label-success';}
						else{$text_estado="Tarjeta";$label_class='label-warning';}
						$total_venta=$row['costo_total_compra'];
					?>
					<tr>
						<td><?php echo $numero_factura; ?></td>
						<td><?php echo $fecha; ?></td>
						
						<td><?php echo $nombre_proveedor; ?></td>
						<td><span class="label <?php echo $label_class;?>"><?php echo $text_estado; ?></span></td>
						<td class='text-right'><?php echo number_format ($total_venta,2); ?></td>					
					<td class="text-right">
						<a href="editar_factura.php?id_factura=<?php echo $id_factura;?>" class='btn btn-default' title='Editar boleta' ><i class="glyphicon glyphicon-edit"></i></a> 
						<a href="#" class='btn btn-default' title='Ver compra' onclick="imprimir_factura('<?php echo $id_factura;?>');"><i class="glyphicon glyphicon-download"></i></a> 
						<a href="#" class='btn btn-default' title='Borrar compra' onclick="eliminar('<?php echo $numero_factura; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>
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