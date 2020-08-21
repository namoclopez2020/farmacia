<?php
  $page_title = 'Busqueda de Productos';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
if(isset($_POST['sucursal'])){
	$sucursal=$_POST['sucursal'];
	
	$query="SELECT *FROM sucursales WHERE id=".$sucursal;
	$sucursales=find_by_sql($query);
	foreach($sucursales as $suc){
		$nombre_sucursal=$suc['nombre_sucursal'];
	}
}
?>
<?php


?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
    <form method="post" action="ajax1.php" autocomplete="off" id="sug-form">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-btn">
				
              <button type="submit" class="btn btn-primary">Búsqueda</button>
            </span>
            <input type="text" id="sug_input" class="form-control" name="title"  placeholder="Buscar por el nombre del producto">
			  <input type="text " name="sucursal" value="<?php echo $sucursal;?>" hidden>
         </div>
         <div id="result" class="list-group"></div>
        </div>
    </form>
  </div>
</div>
<div class="row">

  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Lista de Productos de <?php echo $nombre_sucursal?></span>
       </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="add_sa.php">
         <table class="table table-bordered">
           <thead>
            <th> Descripcion </th>
            <th> Categoria </th>
            <th> Stock </th>
            <th> Precio de Compra </th>
            <th> Precio de Venta</th>
            <th> Proveedor</th>
			<th>Sucursal</th>
			<th>Agregado</th>
			<th>Acciones</th>
           </thead>
             <tbody  id="product_info"> </tbody>
         </table>
       </form>
      </div>
    </div>
  </div>

</div>

<?php include_once('layouts/footer.php'); ?>
