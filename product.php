<?php

$page_title = 'PROUCTOS VIGENTES';
  require_once('includes/load.php');

  // Checkin What level user has permission to view this page
   page_require_level(3);
	$cone= $db->con();
  	$products = join_product_table();
	$all_sucursales=find_all('sucursales');
  
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include_once('layouts/header.php'); ?>
	</head>
  <body> 
    <div class="col-md-15">
		<div  id="myModal" tabindex="-1"  aria-labelledby="myModalLabel">
			  <div  role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Agregar producto"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Buscar productos</h4>
				  </div>
				  <div class="modal-body">
					<div class="form-horizontal">
						<form id="productos" name="productos" method="post">
							<div class="form-group">
								<div class="col-sm-6 col-md-4 col-lg-4">
									<input type="text" name="ajax" id="ajax" value="ajax" hidden>
									<input type="text" class="form-control" id="q" name="q" placeholder="Buscar productos" onkeyup="load(1)">
								</div>
								<div class="col-sm-4 col-md-3 col-lg-3">
									<select class="form-control" name="sucursal" id="sucursal" onChange="load(1)">
										<option value="">Selecciona una sucursal</option>
										<?php  foreach ($all_sucursales as $suc): ?>
											<option value="<?php echo $suc['id'] ?>">
											<?php echo $suc['nombre_sucursal'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-sm-4 col-md-3 col-lg-3">
									<!-- <select class="form-control" name="laboratorio" id="laboratorio" onChange="load(1)">
										<option value="">Selecciona un laboratorio</option>
										<?php  foreach ($all_sucursales as $suc): ?>
											<option value="<?php echo $suc['id'] ?>">
											<?php echo $suc['nombre_sucursal'] ?></option>
										<?php endforeach; ?>
									</select> -->
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2 pull-right">
									<a href="javascript:void(0)" class="btn btn-success reporte"><span class="glyphicon glyphicon-print"></span> Reporte</a>
								</div>
								<!-- <div class="col-sm-4 col-md-2 col-lg-2">
									<button type="button" class="btn btn-default pull-right" onclick="load(1)">
										<span class='glyphicon glyphicon-search'></span> Buscar
									</button>
								</div> -->
								
								
							</div>
							<div class="form-group">
								<div class="col-sm-2 col-md-2 col-lg-2 pull-right">
									<a href="add_product.php" class="btn btn-primary">Agregar producto</a>
								</div>
							</div>
							<div id="loader2" style="position: absolute;	text-align: center;	top: 55px;	width: 100%;display:none;"></div><!-- Carga gif animado -->
							<div class="outer_div2" ></div><!-- Datos ajax Final -->
						</form>
				  	</div>
				</div>
			  </div>
			</div>	
	<hr>
	
	<?php include_once('layouts/footer.php'); ?>
	
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/buscar_productos.js"></script>
	<script type="text/javascript" src="js/impresion.js"></script> 
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  </body>
</html>