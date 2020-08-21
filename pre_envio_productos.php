<?php
  $page_title = 'Envio de Productos';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
  //$products = join_product_table();
$all_sucursales=find_all('sucursales');
?>
<?php include_once('layouts/header.php'); 
?>
<h3>&nbsp; Seleccione Sucursal emisor</h3>
<form name="form1" method="post" action="enviar_productos.php">
<div class="col-md-6">
                    <select class="form-control" name="sucursal_desde" required>
                      <option value="">Selecciona una sucursal</option>
                    <?php  foreach ($all_sucursales as $suc): ?>
                      <option value="<?php echo $suc['id'] ?>">
                        <?php echo $suc['nombre_sucursal'] ?></option>
                    <?php endforeach; ?>
                    </select>
					</div><br>
	<br>
	<h3>&nbsp; Seleccione Sucursal de Recepción</h3>
	<div class="col-md-6">
                    <select class="form-control" name="sucursal_hacia" required>
                      <option value="">Selecciona una sucursal</option>
                    <?php  foreach ($all_sucursales as $suc): ?>
                      <option value="<?php echo $suc['id'] ?>">
                        <?php echo $suc['nombre_sucursal'] ?></option>
                    <?php endforeach; ?>
                    </select>
					</div>

<br>
<br>
<br>
<div class="col-md-6">
<input type="submit" name="enviar" value="Aceptar"/></div>
</form>
<?php 
include_once('layouts/footer.php');
?>