<?php
  $page_title = 'Lista de productos';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
  $user_level=find_grouplevel_by_id($_SESSION['user_id']);
 if($user_level==1){
	 $products = join_product_table();
 }else{
	 $all_user=find_all('users');
	 foreach($all_user as $user_res)
	 {
		if($user_res['id']==$_SESSION['user_id']){
			$sucursal_usuario=$user_res['id_sucursal'];
		} 
	 }
	 
	 
	 $products = join_product_table_sucursal($sucursal_usuario);
 }
  
$all_sucursales=find_all('sucursales');
if (isset($_POST['marcar'])){
	$dato=$_POST['id_producto'];
	$query="UPDATE products set visto='si' where id='".$dato."'";
	$db->query($query);
}

	

?>
<?php include_once('layouts/header.php'); ?>
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
         <div class="pull-right">
           <a href="add_product.php" class="btn btn-primary">Agregar producto</a>
         </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Imagen</th>
                <th> Descripción </th>
                <th class="text-center" style="width: 10%;"> Categoría </th>
                <th class="text-center" style="width: 10%;"> Stock </th>
                <th class="text-center" style="width: 10%;"> Precio de compra </th>
                <th class="text-center" style="width: 10%;"> Precio de venta </th>
				  <th class="text-center" style="width: 10%;"> Proveedor </th>
				   <th class="text-center" style="width: 10%;"> Sucursal </th>
                <th class="text-center" style="width: 10%;"> Agregado </th>
				  <th class="text-center" style="width: 10%;"> Fecha de Caducidad </th>
                <th class="text-center" style="width: 100px;"> Acciones </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $product):
				
				
				if (($product['quantity']=='0F0' || $product['quantity']=='0f0') && $product['visto']=='no'){
				?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td>
                  <?php if($product['media_id'] === '0'): ?>
                    <img class="img-avatar img-circle" src="uploads/products/no_image.jpg" alt="">
                  <?php else: ?>
                  <img class="img-avatar img-circle" src="uploads/products/<?php echo $product['image']; ?>" alt="">
                <?php endif; ?>
                </td>
                <td> <?php echo remove_junk($product['name']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['categorie']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['quantity']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['buy_price']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['sale_price']); ?></td>
				<td class="text-center"> <?php echo remove_junk($product['prov']); ?></td>
				  <?php foreach ($all_sucursales as $sucursales) :
				  if($sucursales['id']==$product['id_sucursal']){
				  
				  ?>
				  
				<td class="text-center"> <?php echo remove_junk($sucursales['nombre_sucursal']); ?></td>
				  <?php } 
				  endforeach;?>
                <td class="text-center"> <?php echo read_date($product['date']); ?></td>
				<td class="text-center"> <?php echo read_date($product['fecha_caducidad']); ?></td>
                <td class="text-center">
                  <div class="btn-group">
					  <form action="product_agotado.php" method="post" name="form1" >
					<input type="text" name="id_producto" value="<?php echo (int)$product['id'];?>" hidden> 
					  <input type="submit" value ="Marcar" name="marcar" class="btn btn-success btn-xs" title="Marcar" data-toggle="tooltip">
					  </form>
                    <a href="edit_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-info btn-xs"  title="Editar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                     <a href="delete_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-danger btn-xs"  title="Eliminar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
                </td>
              </tr>
             <?php
				}
					endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
