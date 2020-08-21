<?php
  $page_title = 'Ventas Diarias';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
  //$products = join_product_table();
$all_sucursales=find_all('sucursales');
$all_users=find_all('users');
$products=find_all('products');



?>
<?php include_once('layouts/header.php'); 
if($_SESSION['user_id']==1){?>
<h3>&nbsp; Buscar por sucursal</h3>
<form name="form1" method="post" action="daily_sales.php">
<div class="col-md-6">
                    <select class="form-control" name="sucursal" required>
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
<br>
<h3>&nbsp; Buscar por usuario</h3>
<form name="form2" method="post" action="daily_sales_usuario.php">
<div class="col-md-6">
                    <select class="form-control" name="user" required>
                      <option value="">Selecciona un usuario</option>
                    <?php  foreach ($all_users as $user): ?>
                      <option value="<?php echo $user['id'] ?>">
                        <?php echo $user['name'] ?></option>
                    <?php endforeach; ?>
                    </select>
					</div>

<br>
<br>
<br>
<div class="col-md-6">
<input type="submit" name="enviar" value="Aceptar"/></div>
</form>
<?php }
else{
date_default_timezone_set('America/Lima');
 $year  = date('Y');
 $month = date('m');
	$day=date('d');

 $sales = dailySalesByUser($year,$month,$day,$_SESSION['user_id']);
 $all_sucursales=find_all('sucursales');
 $all_vendedores=find_all('users');
 
$suma=0;
?>

<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Venta diaria</span>
          </strong>
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Descripción </th>
                <th class="text-center" style="width: 15%;"> Cantidad vendida</th>
				<th class="text-center" style="width: 15%;"> Vendedor</th>
				  <th class="text-center" style="width: 15%;"> Sucursal</th>
                <th class="text-center" style="width: 15%;"> Fecha </th>
                <th class="text-center" style="width: 15%;"> Total </th>
             </tr>
            </thead>
           <tbody>
             <?php foreach ($sales as $sale):
			  
				
			   ?>
             <tr>
               <td class="text-center"><?php echo count_id();?></td>
                <td><?php foreach($products as $product){if($sale['product_id']==$product['id']){echo remove_junk($product['name']);} }?></td>
               <td class="text-center"><?php echo $sale['qty']; ?></td>
				 <td class="text-center"><?php foreach($all_vendedores as $vendedor){if($sale['id_vendedor']==$vendedor['id']){echo $vendedor['name'];} }?></td>
				 <td class="text-center"><?php foreach($all_sucursales as $sucursal){if($sale['id_sucursal']==$sucursal['id']){echo $sucursal['nombre_sucursal'];} }?></td>
              
               <td class="text-center"><?php echo date("d/m/Y", strtotime ($sale['date'])); ?></td>
				  <td class="text-center"><?php echo remove_junk($sale['price']); ?></td>
             </tr>
             <?php 
					   $suma=$suma+$sale['price'];
				     endforeach;?>
			   <tr><td colspan="5" class="text-center"><h3>Total</h3></td><td colspan="2" class="text-center"><h3><?php echo "S/. ". $suma;?></h3></td></tr>
           </tbody>
         </table>
        </div>
      </div>
    </div>
  </div>



<?php
}



include_once('layouts/footer.php'); ?>