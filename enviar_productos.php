<?php

$page_title = 'Nuevo envio';
  require_once('includes/load.php');

  // Checkin What level user has permission to view this page
 page_require_level(3);
$cone= $db->con();
if(isset($_POST['sucursal_desde'])){
	$sucursal_inicio=$_POST['sucursal_desde'];
}
if(isset($_POST['sucursal_hacia'])){
	$sucursal_final=$_POST['sucursal_hacia'];
}
 
	?>
<!DOCTYPE html>
<html lang="en">
  <head>
   <?php include_once('layouts/header.php'); ?>

  </head>
  <body> 
    <div class="col-md-12">
	<div class="panel panel-info">
		<div class="panel-heading">
			<h4><i class='glyphicon glyphicon-edit'></i> Nuevo envio</h4>
		</div>
		<div class="panel-body">
		<?php 
			include("model/buscar_productos1.php");
		?>
			<form class="form-horizontal" role="form" id="datos_envio">
			<div class="col-md-12">
					<div class="pull-right">
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal1">
						 <span class="glyphicon glyphicon-search"></span> Agregar productos
						</button>
						<input type="text" name="sucursal_emisor" id="sucursal_emisor" value="<?php echo $sucursal_inicio?>" hidden>
						<input type="text" name="sucursal_ultimo" id="sucursal_ultimo" value="<?php echo $sucursal_final;?>" hidden>
						<button type="submit" class="btn btn-default">
						  <span class="glyphicon glyphicon-print"></span> Aceptar
						</button>
					</div>	
				</div>
			</form>
			
		<div id="resultados1" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->			
		</div>
	</div>		
		  <div class="row-fluid">
			<div class="col-md-12">
			
	

			
			</div>	
		 </div>
	</div>
	<hr>
	
	<?php include_once('layouts/footer.php'); ?>
	
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	
	<script type="text/javascript" src="js/nuevo_envio.js"></script>
		
	  
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	
	</body>
</html>