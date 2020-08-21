<?php

$page_title = 'Nueva factura';
  require_once('includes/load.php');

  // Chequear el nivel del usuario
   page_require_level(3);
  $all_sucursal= find_all('sucursales');
 
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
			<a href="nueva_compra.php">	<h4><i class='glyphicon glyphicon-edit'></i> Nueva Compra</h4></a>
		</div>
		<div class="panel-body">
		<?php 
			include("model/buscar_productos_compra.php");
		?>
			<form class="form-horizontal" role="form" id="datos_factura" method="post">
				<div class="form-group row">
				  <label for="nombre_proveedor" class="col-md-1 control-label">Proveedor</label>
				  <div class="col-md-3">
					  <input type="text" class="form-control input-sm" id="nombre_proveedor" placeholder="Selecciona un proveedor" >
					  <input id="id_proveedor" type='hidden'>	
				  </div>
				  <label for="RUC" class="col-md-1 control-label">RUC</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" id="RUC" placeholder="RUC" readonly>
							</div>
					<label for="tel" class="col-md-1 control-label">Telefono</label>
							<div class="col-md-3">
								<input type="text" class="form-control input-sm" id="tel" placeholder="tel" readonly>
							</div>
				 </div>
						<div class="form-group row">
							<label for="empresa" class="col-md-1 control-label">Usuario</label>
							<div class="col-md-3">
								<select class="form-control input-sm" id="id_vendedor">
									<?php
										$sql_vendedor=$db->query("select * from users where id='".$_SESSION['user_id']."'");
										while ($rw=$db->fetch_array($sql_vendedor)){
											$id_vendedor=$rw["id"];
											$nombre_vendedor=$rw["name"];
											
											?>
											<option value="<?php echo $id_vendedor?>"><?php echo $nombre_vendedor?></option>
											<?php
										}
									?>
								</select>
							</div>
							<label for="fecha" class="col-md-1 control-label">Fecha</label>
							<div class="col-md-2">
								 <input type="text" class="datepicker form-control" name="fecha" id="fecha"  autocomplete="off">
								
							</div>
							<label for="email" class="col-md-1 control-label">Pago</label>
							<div class="col-md-3">
								<select class='form-control input-sm' id="condiciones">
									<option value="1">Efectivo</option>
									<option value="2">Cheque</option>
									<option value="3">Transferencia bancaria</option>
									<option value="4">Crédito</option>
								</select>
							</div>
						</div>
				
				
				<div class="col-md-12">
					<div class="pull-right">
						
						<a href="add_provider.php" class="btn btn-default" >
						 <span class="glyphicon glyphicon-user"></span> Nuevo proveedor
						</a>
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal2">
						 <span class="glyphicon glyphicon-search"></span> Agregar productos
						</button>
						<button type="submit" class="btn btn-default">
						  <span class="glyphicon glyphicon-print"></span> Imprimir
						</button>
					</div>	
				</div>
			
			
		<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->			
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
	<script type="text/javascript" src="js/nueva_compra.js"></script>
	  
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script>
		$(function() {
						$("#nombre_proveedor").autocomplete({
							source: "./ajax/autocomplete/proveedores.php",
							minLength: 2,
							select: function(event, ui) {
								event.preventDefault();
								$('#id_proveedor').val(ui.item.id_proveedor);
								$('#nombre_proveedor').val(ui.item.nombre_empresa);
								$('#tel').val(ui.item.telefono_proveedor);
								$('#RUC').val(ui.item.ruc);
																
								
							 }
						});
						 
						
					});
					
	$("#nombre_proveedor" ).on( "keydown", function( event ) {
						if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
						{
							$("#id_proveedor" ).val("");
							$("#tel" ).val("");
							$("#RUC" ).val("");
											
						}
						if (event.keyCode==$.ui.keyCode.DELETE){
							$("#nombre_proveedor" ).val("");
							$("#id_proveedor" ).val("");
							$("#tel" ).val("");
							$("#RUC" ).val("");
						}
			});	
	</script>

  </body>
</html>