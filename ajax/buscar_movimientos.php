<?php
	require_once('../includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);

  $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
		 
		$inicio= $_REQUEST['start'];
		$id_producto=$_REQUEST['prod'];
		$fin=$_REQUEST['end'];
		$id_movimiento=$_REQUEST['mov'];
		$usuario = $_REQUEST['user'];
		
		$sTable="movimientos as m LEFT JOIN detalle_movimiento as d ON m.id_tipo_movimiento=d.id_detalle_mov LEFT JOIN users as u ON m.id_vendedor_mov=u.id LEFT JOIN products as p ON m.id_producto_mov=p.id where m.id_producto_mov='$id_producto'";
		
		if(($_GET['start']!="" && $_GET['end']!="") || $_GET['mov']!="" || $_GET['user'] != ''){
			$sWhere="AND";
		}else{$sWhere = "";}
		
		if($_GET['start'] !="" && $_GET['end']!=''){
			$sWhere.=" m.fecha_movimiento between '$inicio' and '$fin' AND";
		}
		if($_GET['mov']!=""){
			$sWhere.=" m.id_tipo_movimiento='$id_movimiento' AND";
		}
		if($_GET['user']!=""){
			$sWhere.=" m.id_vendedor_mov='$usuario' AND";
		}
		
		$sWhere = substr_replace( $sWhere, "", -3 );
		
		$sWhere.=" order by m.id_movimiento desc";
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
		$reload = './movimientos.php?id='.$id_producto;
		//main query to fetch the data
		$sql="SELECT m.id_movimiento,m.cantidad_mov,m.fecha_movimiento,p.name as pname,u.name as uname,d.nombre_tipo_movimiento FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = $db->query($sql);
		//loop through fetched data
		if ($numrows>0){
			echo $db->error();
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr class="info">
					<th>#</th>
					<th>Fecha</th>
					<th>Vendedor</th>
					<th>Movimiento</th>
					<th>Producto</th>
					<th>Cantidad</th>				
				</tr>
				<?php
				$contador = 0;
				while ($row=$db->fetch_array($query)){
						$contador++;
						$nombre_producto=$row['pname'];
						$fecha=date("d/m/Y G:i:s", strtotime($row['fecha_movimiento']));
						$nombre_usuario=$row['uname'];
						$cantidad=$row['cantidad_mov'];
					    $nombre_movimiento=$row['nombre_tipo_movimiento'];
					?>
					<tr>
						<td><?php echo $contador; ?></td>
						<td><?php echo $fecha; ?></td>
						<td><?php echo $nombre_usuario; ?></td>
						<td ><?php echo $nombre_movimiento;?></td>	
						<td><?php echo $nombre_producto;?></td>
						<td><?php echo $cantidad;?></td>
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=7>
						<span class="pull-right">
							<?php echo paginate($reload, $page, $total_pages, $adjacents); ?>
						</span>
					</td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>