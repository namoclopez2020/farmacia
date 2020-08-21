<?php
  $page_title = 'Agregar proveedor';
  require_once('includes/load.php');

  // Checkin What level user has permission to view this page
  page_require_level(3);
  $all_clients = find_all('clientes');
  
?>
<?php
//si se pulsa el boton agregar cliente
 if(isset($_POST['add_client'])){
  
	 $rep=0;
	 foreach($all_clients as $client){
		 
	 if($_POST['cliente_title']==$client['nombre_cliente']){ 
		 $rep++;
		}
	 }
   if(empty($errors)){
     $p_name  = remove_junk($db->escape($_POST['cliente_title']));
     $p_telef  = remove_junk($db->escape($_POST['telefono_title']));
     $p_email   = remove_junk($db->escape($_POST['email_title']));
     $p_cliente  = remove_junk($db->escape($_POST['dir_cliente']));

     $date    = make_date();
     $query  = "INSERT INTO clientes (";
     $query .=" nombre_cliente,telefono_cliente,email_cliente,direccion_cliente,date_added";
     $query .=") VALUES (";
     $query .=" '{$p_name}', '{$p_telef}', '{$p_email}', '{$p_cliente}',  '{$date}'";
     $query .=")";
     
	   if($rep==0){
     if($db->query($query)){
       $session->msg('s',"Datos del Cliente agregados exitosamente. ");
       redirect('cliente.php', false);
     } else {
       $session->msg('d',' Lo siento, registro falló.');
       redirect('add_client.php', false);
     }
	   }
	   else{
		   $session->msg('d',' Lo siento, este cliente ya existe');
       redirect('add_client.php', false);
	   }
	   

   } else{
     $session->msg("d", $errors);
     redirect('add_client.php',false);
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
            <span>Agregar Cliente</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
          <form method="post" action="add_client.php" class="clearfix">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="cliente_title" placeholder="Nombre del Cliente" required>
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
                  <input type="text" class="form-control" name="email_title" placeholder="Correo electrónico" required>
               </div>
              </div>
			  <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="dir_cliente" placeholder="Dirección" required>
               </div>
              </div>
              

              <button type="submit" name="add_client" class="btn btn-danger">Agregar Cliente</button>
          </form>
         </div>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
