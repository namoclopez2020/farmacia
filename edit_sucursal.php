<?php
  $page_title = 'Editar producto';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php
$sucursal = find_by_id('sucursales',(int)$_GET['id']);

if(!$sucursal){
  $session->msg("d","No se pudo encontrar la sucursal");
  redirect('sucursal.php');
}
?>
<?php
 if(isset($_POST['sucursal'])){
	 $id=$sucursal['id'];
   	$nombre=$_POST['sucursal-nombre'];
	$direccion=$_POST['sucursal-direccion']; 
       $query   = "UPDATE sucursales SET";
       $query  .=" direccion_sucursal ='{$direccion}', nombre_sucursal ='{$nombre}' where id='{$id}'";
       $result = $db->query($query);
               if($result && $db->affected_rows() === 1){
                 $session->msg('s',"Los datos han sido actualizados. ");
                 redirect('sucursal.php', false);
               } else {
                 $session->msg('d',' Lo siento, actualización falló.');
                 redirect('edit_sucursal.php?id='.$sucursal['id'], false);
               }

   }


?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Editar datos de la sucursal</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-7">
           <form method="post" action="edit_sucursal.php?id=<?php echo (int)$sucursal['id'] ?>">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="sucursal-nombre" value="<?php echo remove_junk($sucursal['nombre_sucursal']);?>">
               </div>
              </div>
			   <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="sucursal-direccion" value="<?php echo remove_junk($sucursal['direccion_sucursal']);?>">
               </div>
              </div>
		    
              <button type="submit" name="sucursal" class="btn btn-danger">Actualizar</button>
          </form>
         </div>
        </div>
      </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
