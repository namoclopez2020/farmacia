<?php

  $page_title = 'Historial de productos';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
$id_producto=$_GET['id'];
$query="Select name from products where id='$id_producto'";
$data=$db->query($query);
$nombre_prod=$db->fetch_array($data);
$nombre_producto=$nombre_prod['name'];
$all_tipo_movimiento=find_all('detalle_movimiento');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
	<?php include_once('layouts/header.php'); ?>

  </head>
  <body>
	
    <div class="col-md-12">
		<div class="panel panel-default">
		<div class="panel-heading">
		    
			<h4><i class='glyphicon glyphicon-search'></i> Historial de : <?php echo $nombre_producto;?></h4>
		</div>
			<div class="panel-body">
				<form class="form-horizontal" role="form" id="datos_movimientos">
				
<div class="form-group row">
						
	<div class="col-md-7">
           <label class="col-md-4 control-label">Rango de fechas</label>
	    <div class="col-md-8">
                <div class="input-group">
					<input type="text" id="producto" name="producto" value="<?php  echo $id_producto; ?>" hidden>
                  <input type="text" class="datepicker form-control" name="start" id="start" placeholder="Desde" onChange="load(1)" autocomplete="off">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                  <input type="text" class="datepicker form-control" name="end" id="end" placeholder="Hasta" onChange="load(1)" autocomplete="off">
                </div>
		</div>
				
	</div>
	
</div>
<div class="form-group row" >
	
	<label class="col-md-2 control-label">Tipo de movimiento</label>
	<div class="col-md-3">
				 <select class="form-control" name="mov" id="mov" onChange="load(1)">
                      <option value="">Selecciona un movimiento</option>
                   	 <?php  foreach ($all_tipo_movimiento as $mov): ?>
                      <option value="<?php echo $mov['id_detalle_mov'] ?>">
                        <?php echo $mov['nombre_tipo_movimiento'] ?></option>
                   		 <?php endforeach; ?>
                  </select>
	</div>
  	<div class="col-md-3">
				<button type="button" class="btn btn-default" onclick='load(1);'>
				<span class="glyphicon glyphicon-search" ></span> Buscar</button>
				<span id="loader4"></span>
	</div>	
	
</div>
				
				
				
			</form>
				<div id="resultados4"></div><!-- Carga los datos ajax -->
				<div class='outer_div4'></div><!-- Carga los datos ajax -->
			</div>
		</div>	
		
	</div>
	<hr>
	  <?php include_once('layouts/footer.php'); ?>
	  
	
	
	<script type="text/javascript" src="js/movimientos.js"></script>
	  
  </body>
</html>
