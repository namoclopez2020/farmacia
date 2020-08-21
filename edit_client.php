<?php
  $page_title = 'Editar datos del cliente';
  require_once('includes/load.php');

  // Checkin What level user has permission to view this page
  page_require_level(2);
 // $all_providers = find_all('proveedores');
  //$all_photo = find_all('media');
$client = find_by_id2('clientes',(int)$_GET['id']);
//if(!$provider){
 // $session->msg("d","Missing provider id.");
//  redirect('proveedores.php');	 

?>
<?php

?>
<?php
 if(isset($_POST['edit_client'])){
  // $req_fields = array('empresa_title','telefono_title','contacto_title','tipo_producto' );
  // validate_fields($req_fields);


   if(empty($errors)){
     $p_name  = remove_junk($db->escape($_POST['cliente_title']));
     $p_telef  = remove_junk($db->escape($_POST['telefono_title']));
     $p_email   = remove_junk($db->escape($_POST['email_title']));
     $p_dir  = remove_junk($db->escape($_POST['dir_cliente']));
	 $p_id  = remove_junk($db->escape($_POST['id_cliente']));
	   $query   = "UPDATE clientes SET";
       $query  .=" nombre_cliente ='{$p_name}', telefono_cliente ='{$p_telef}',";
       $query  .=" email_cliente ='{$p_email}', direccion_cliente ='{$p_dir}'";
       $query  .=" WHERE id_cliente ='{$p_id}'";
	   
     //$query .=" ON DUPLICATE KEY UPDATE name='{$p_name}'";
	  
     $result = $db->query($query);
               if($result && $db->affected_rows() === 1){
                 $session->msg('s',"CLiente ha sido actualizado. ");
                 redirect('cliente.php', false);
               } else {
                 $session->msg('d',' Lo siento, actualización falló.');
                 redirect('edit_client.php?id='.$product['id'], false);
               }

   } else{
       $session->msg("d", $errors);
       redirect('edit_client.php?id='.$product['id'], false);
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
            <span>Actualizar datos del cliente</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
          <form method="post" action="edit_client.php" class="clearfix">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="cliente_title" placeholder="Nombre del Cliente" value="<?php echo remove_junk($client['nombre_cliente']);?>" required>
               </div>
              </div>
			  <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="telefono_title" placeholder="Teléfono" value="<?php echo remove_junk($client['telefono_cliente']);?>" required>
               </div>
              </div>
			  <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="email_title" placeholder="Correo electrónico" value="<?php echo remove_junk($client['email_cliente']);?>" required>
               </div>
              </div>
			  <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="dir_cliente" placeholder="Dirección" value="<?php echo remove_junk($client['direccion_cliente']);?>" required>
               </div>
              </div>
              <input type="hidden" class="form-control" name="id_cliente" placeholder="id del cliente" value="<?php echo remove_junk($client['id_cliente']);?>" required>

              <button type="submit" name="edit_client" class="btn btn-danger">Actualizar Cliente</button>
          </form>
         </div>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
