<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
?>
<?php
  $sucursal = find_by_id('sucursales',(int)$_GET['id']);
  if(!$sucursal){
    $session->msg("d","ID vacío");
    redirect('sucursal.php');
  }
?>
<?php
  $delete_id = delete_by_id('sucursales',(int)$sucursal['id']);
  if($delete_id){
      $session->msg("s","Sucursal eliminada");
      redirect('sucursal.php');
  } else {
      $session->msg("d","Eliminación falló");
      redirect('sucursal.php');
  }
?>
