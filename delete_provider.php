<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
?>
<?php
  $provider= find_by_id1('proveedores',(int)$_GET['id']);
  if(!$provider){
    $session->msg("d","ID vacío");
    redirect('proveedores.php');
  }
?>
<?php
  $delete_id = delete_by_id1('proveedores',(int)$provider['id_prov']);
  if($delete_id){
      $session->msg("s","Proveedor eliminado");
      redirect('proveedores.php');
  } else {
      $session->msg("d","Eliminación falló");
      redirect('proveedores.php');
  }
?>
