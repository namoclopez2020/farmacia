<?php
  $page_title = 'Agregar proveedor';
  require_once('includes/load.php');

  // Checkin What level user has permission to view this page
  page_require_level(2);
  $all_providers = find_all('proveedores');

?>
<?php
//si se pulsa el boton agregar proveedor
 if(isset($_POST['add_provider'])){
 
	 $rep=0;
	 foreach($all_providers as $provider){
		 
	 if($_POST['empresa_title']==$provider['nom_empresa']){ 
		 $rep++;
		}
	 }
   if(empty($errors)){
     $p_name  = remove_junk($db->escape($_POST['empresa_title']));
     $p_telef  = remove_junk($db->escape($_POST['telefono_title']));
     $p_contact   = remove_junk($db->escape($_POST['contacto_title']));
     $p_tipo  = remove_junk($db->escape($_POST['tipo_producto']));
	  $RUC=remove_junk($db->escape($_POST['RUC']));

     $date    = make_date();
     $query  = "INSERT INTO proveedores (";
     $query .=" nom_empresa,telef_prov,nom_contacto,tipo_producto,date,ruc_proveedor";
     $query .=") VALUES (";
     $query .=" '{$p_name}', '{$p_telef}', '{$p_contact}', '{$p_tipo}',  '{$date}','{$RUC}'";
     $query .=")";
    
	   if($rep==0){
     if($db->query($query)){
       $session->msg('s',"Producto agregado exitosamente. ");
       redirect('proveedores.php', false);
     } else {
       $session->msg('d',' Lo siento, registro falló.');
       redirect('add_provider.php', false);
     }
	   }
	   else{
		   $session->msg('d',' Lo siento, este proveedor ya existe');
       redirect('add_provider.php', false);
	   }
	   

   } else{
     $session->msg("d", $errors);
     redirect('add_provider.php',false);
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
            <span>Agregar proveedor</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
          <form method="post" action="add_provider.php" class="clearfix">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="empresa_title" placeholder="Empresa proveniente" required>
               </div>
              </div>
			  <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="telefono_title" placeholder="Teléfono" required>
               </div>
              </div>
			  <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="contacto_title" placeholder="Nombre del contacto" required>
               </div>
              </div>
			  <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="tipo_producto" placeholder="Tipo de Producto" required>
               </div>
              </div>
			  <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="RUC" placeholder="RUC" required>
               </div>
              </div>
              

              <button type="submit" name="add_provider" class="btn btn-danger">Agregar proveedor</button>
          </form>
         </div>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
