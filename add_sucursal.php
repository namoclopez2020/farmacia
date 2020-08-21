<?php
  $page_title = 'Agregar sucursal';
  require_once('includes/load.php');
  // Checkear nivel de permiso para esta pagina
  page_require_level(2);
$cone= $db->con();
?>
<?php
 if(isset($_POST['add_sucursal'])){
    
	 $nombre=$_POST['sucursal-name'];
	 $direccion=$_POST['sucursal-direccion'];
	 
     $date    = make_date();
     $query  = "INSERT INTO sucursales (";
     $query .=" direccion_sucursal,nombre_sucursal";
     $query .=") VALUES (";
     $query .=" '{$direccion}','{$nombre}'";
     $query .=")";
	  
	  
  // si se ejecuta correctamente la insercion
     if($db->query($query)){
		 
		 
		
       $session->msg('s',"Nueva sucursal agregada exitosamente. ");
       redirect('sucursal.php', false);
		
     } else {
       $session->msg('d',' Lo siento, registro falló.');
       redirect('add_sucursal.php', false);
     }

   }
 

 include_once('layouts/header.php'); 
?>
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
            <span>Agregar nueva sucursal</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
          <form method="post" action="add_sucursal.php" class="clearfix">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="sucursal-name" placeholder="Nombre" required>
               </div>
              </div>
			  <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="sucursal-direccion" placeholder="Direccion" required>
               </div>
              </div>
              
			  
              <button type="submit" name="add_sucursal" class="btn btn-danger">Guardar Datos</button>
          </form>
         </div>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
