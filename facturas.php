<?php

	$page_title = 'Lista de boletas';
	require_once('includes/load.php');
  	// Checkin What level user has permission to view this page
   	page_require_level(3);
	$all_sucursal=find_all('sucursales');
	$all_vendedores=find_all('users');
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
		    <div class="btn-group pull-right">
				<a  href="nueva_factura.php" class="btn btn-info"><span class="glyphicon glyphicon-plus" ></span> Nueva Venta</a>
			</div>
			<h4><i class='glyphicon glyphicon-search'></i> Buscar Ventas</h4>
		</div>
			<div class="panel-body">
				<form class="form-horizontal" role="form" id="datos_cotizacion">
				
<div class="form-group row">
			<label for="q" class="col-md-1 control-label">Nombre</label>
				<div class="col-md-3">
				<input type="text" class="form-control" id="q" name="q" placeholder="nombre del producto" onkeyup='load(1);'>
					<input type="text" name="ajax" id="ajax" value="ajax" hidden>
				</div>			
	<div class="col-md-7">
           <label class="col-md-4 control-label">Rango de fechas</label>
	    <div class="col-md-8">
                <div class="input-group">
                  <input type="text" class="datepicker form-control" name="start" id="start" placeholder="Desde" onChange="load(1)" autocomplete="off">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                  <input type="text" class="datepicker form-control" name="end" id="end" placeholder="Hasta" onChange="load(1)" autocomplete="off">
                </div>
		</div>
				
	</div>
	
</div>
<div class="form-group row" >
	<label class="col-md-1 control-label">Sucursal</label>
	<div class="col-md-3">
				 <select class="form-control" name="suc" id="suc" onChange="load(1)">
                      <option value="">Selecciona una sucursal</option>
                   	 <?php  foreach ($all_sucursal as $suc): ?>
                      <option value="<?php echo $suc['id'] ?>">
                        <?php echo $suc['nombre_sucursal'] ?></option>
                   		 <?php endforeach; ?>
                  </select>
	</div>
	<label class="col-md-2 control-label">Vendedor</label>
	<div class="col-md-3">
				 <select class="form-control" name="ven" id="ven" onChange="load(1)">
                      <option value="">Selecciona un vendedor</option>
                   	 <?php  foreach ($all_vendedores as $ven): ?>
                      <option value="<?php echo $ven['id'] ?>">
                        <?php echo $ven['name'] ?></option>
                   		 <?php endforeach; ?>
                  </select>
	</div>
  	<div class="col-md-3">
				<button type="button" class="btn btn-default" onclick='load(1);'>
				<span class="glyphicon glyphicon-search" ></span> Buscar</button>
				<span id="loader"></span>
	</div>	
	
</div>
				
				
				
			</form>
				<div id="resultados"></div><!-- Carga los datos ajax -->
				<div class='outer_div'></div><!-- Carga los datos ajax -->
			</div>
		</div>	
		
	</div>
	<hr>
	  <?php include_once('layouts/footer.php'); ?>
	  
	
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/facturas.js"></script>
	  
  </body>
</html>
