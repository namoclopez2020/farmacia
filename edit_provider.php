<?php
  $page_title = 'Editar proveedor';
  require_once('includes/load.php');

  // Checkin What level user has permission to view this page
  page_require_level(2);
 // $all_providers = find_all('proveedores');
  //$all_photo = find_all('media');
$provider = find_by_id1('proveedores',(int)$_GET['id']);
//if(!$provider){
 // $session->msg("d","Missing provider id.");
//  redirect('proveedores.php');	 

?>
<?php

?>
<?php
 if(isset($_POST['edit_provider'])){
  // $req_fields = array('empresa_title','telefono_title','contacto_title','tipo_producto' );
  // validate_fields($req_fields);


   if(empty($errors)){
     $p_name  = remove_junk($db->escape($_POST['empresa_title']));
     $p_telef  = remove_junk($db->escape($_POST['telefono_title']));
     $p_contact   = remove_junk($db->escape($_POST['contacto_title']));
     $p_tipo  = remove_junk($db->escape($_POST['tipo_producto']));
	 $p_id  = remove_junk($db->escape($_POST['id_producto']));
	   $query   = "UPDATE proveedores SET";
       $query  .=" nom_empresa ='{$p_name}', telef_prov ='{$p_telef}',";
       $query  .=" nom_contacto ='{$p_contact}', tipo_producto ='{$p_tipo}'";
       $query  .=" WHERE id_prov ='{$p_id}'";
	   
     //$query .=" ON DUPLICATE KEY UPDATE name='{$p_name}'";
	  
     $result = $db->query($query);
               if($result && $db->affected_rows() === 1){
                 $session->msg('s',"Producto ha sido actualizado. ");
                 redirect('proveedores.php', false);
               } else {
                 $session->msg('d',' Lo siento, actualización falló.');
                 redirect('edit_provider.php?id='.$product['id'], false);
               }

   } else{
       $session->msg("d", $errors);
       redirect('edit_provider.php?id='.$product['id'], false);
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
  <div class="col-md-9">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Actualizar datos del proveedor</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
          <form method="post" action="edit_provider.php" class="clearfix">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="empresa_title" placeholder="Empresa proveniente" value="<?php echo remove_junk($provider['nom_empresa']);?>" required>
               </div>
              </div>
			  <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="telefono_title" placeholder="Teléfono" value="<?php echo remove_junk($provider['telef_prov']);?>" required>
               </div>
              </div>
			  <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="contacto_title" placeholder="Nombre del contacto" value="<?php echo remove_junk($provider['nom_contacto']);?>" required>
               </div>
              </div>
			  <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="tipo_producto" placeholder="Tipo de Producto" value="<?php echo remove_junk($provider['tipo_producto']);?>" required>
               </div>
              </div>
              <input type="hidden" class="form-control" name="id_producto" placeholder="Tipo de Producto" value="<?php echo remove_junk($provider['id_prov']);?>" required>

              <button type="submit" name="edit_provider" class="btn btn-danger">Actualizar proveedor</button>
          </form>
         </div>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
