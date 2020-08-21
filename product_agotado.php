<?php

$page_title = 'PROUCTOS AGOTADOS';
  require_once('includes/load.php');

  // Checkin What level user has permission to view this page
page_require_level(3);

$products=find_all('products');
$products = join_product_table();
$all_sucursales=find_all('sucursales');
//colocar el visto al producto
if (isset($_POST['marcar'])){
	$dato=$_POST['id_producto'];
	$query="UPDATE products set visto='si' where id='".$dato."'";
	$db->query($query);
}
if (isset($_POST['desmarcar'])){
	$dato=$_POST['id_producto'];
	$query="UPDATE products set visto='no' where id='".$dato."'";
	$db->query($query);
}
  
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
					<h4 class="modal-title" id="myModalLabel">Lista de productos agotados</h4>
				  </div>
				  <div class="modal-body">
					<form class="form-horizontal">
					  <div class="form-group">
						
						  <div class="col-sm-4">
						 <select class="form-control" name="a" id="a" onChange="load(1)">
                      <option value="">Selecciona una sucursal</option>
                    <?php  foreach ($all_sucursales as $suc): ?>
                      <option value="<?php echo $suc['id'] ?>">
                        <?php echo $suc['nombre_sucursal'] ?></option>
                    <?php endforeach; ?>
                    </select>
					</div>
					  </div>
						
					</form>
					<div id="loader3" style="position: absolute;	text-align: center;	top: 55px;	width: 100%;display:none;"></div><!-- Carga gif animado -->
					<div class="outer_div3" ></div><!-- Datos ajax Final -->
				  </div>
				  
				</div>
			  </div>
			</div>	
	<hr>
	
	<?php include_once('layouts/footer.php'); ?>
	
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	
	<script type="text/javascript" src="js/buscar_productos_agotados.js"></script>
	  
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  </body>
</html>