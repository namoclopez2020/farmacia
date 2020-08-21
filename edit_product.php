<?php
  $page_title = 'Editar producto';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);

$product = find_by_id('products',(int)$_GET['id']);
$all_categories = find_all('categories');
$all_photo = find_all('media');
$all_providers= find_all('proveedores');
$all_sucursal=find_all('sucursales');

if(!$product){
  $session->msg("d","Missing product id.");
  redirect('product.php');
}
?>
<?php
 if(isset($_POST['product'])){
    $req_fields = array('product-title','product-categorie','product-quantity','buying-price', 'saleing-price' );
    validate_fields($req_fields);

   if(empty($errors)){
	   $laboratorio=$_POST['laboratorio'];
	   $cantidad_blister = remove_junk($db->escape($_POST['cantidad_blister']));
	   $fecha_caducidad=$_POST['fecha_caducidad'];
	   $precio_blister  = remove_junk($db->escape($_POST['precio_blister']));
	   $cantidad_unidad  = remove_junk($db->escape($_POST['cantidad_unidad']));
	   $precio_unidad  = remove_junk($db->escape($_POST['precio_unidad']));
       $p_name  = remove_junk($db->escape($_POST['product-title']));
       $p_cat   = (int)$_POST['product-categorie'];
       $p_qty   = remove_junk($db->escape($_POST['product-quantity']));
	   $p_compuesto   = remove_junk($db->escape($_POST['product-compuesto']));
       $p_buy   = remove_junk($db->escape($_POST['buying-price']));
       $p_sale  = remove_junk($db->escape($_POST['saleing-price']));
	   $p_provi  = remove_junk($db->escape($_POST['product-provider']));
	   $p_sucursal  = $_POST['product-sucursal'];
       if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
         $media_id = '0';
       } else {
         $media_id = remove_junk($db->escape($_POST['product-photo']));
       }
       $query   = "UPDATE products SET";
       $query  .=" name ='{$p_name}', quantity ='{$p_qty}',";
       $query  .=" buy_price ='{$p_buy}', sale_price ='{$p_sale}', categorie_id ='{$p_cat}',media_id='{$media_id}',prov='{$p_provi}',compuesto_prod='{$p_compuesto}',id_sucursal='{$p_sucursal}',cantidad_blister='{$cantidad_blister}',precio_blister='{$precio_blister}',cantidad_unidad='{$cantidad_unidad}',precio_unidad='{$precio_unidad}',fecha_caducidad='{$fecha_caducidad}',laboratorio='{$laboratorio}'";
       $query  .=" WHERE id ='{$product['id']}'";
       $result = $db->query($query);
	   $fecha= make_date();
	   $tipo_movimiento=5;
               if($result && $db->affected_rows() === 1){
				   
				 insertar_movimiento_producto($product['id'],$tipo_movimiento,$p_qty,$_SESSION['user_id'],$fecha);
                 $session->msg('s',"Producto ha sido actualizado. ");
                 redirect('product.php', false);
               } else {
                 $session->msg('d',' Lo siento, actualización falló.');
                 redirect('edit_product.php?id='.$product['id'], false);
               }

   } else{
       $session->msg("d", $errors);
       redirect('edit_product.php?id='.$product['id'], false);
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
            <span>Editar producto</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-7">
           <form method="post" action="edit_product.php?id=<?php echo (int)$product['id'] ?>">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-title" value="<?php echo remove_junk($product['name']);?>" placeholder="nombre del producto">
               </div>
              </div>
			   <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-compuesto" value="<?php echo remove_junk($product['compuesto_prod']);?>" placeholder="compuesto">
               </div>
              </div>
			   <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="laboratorio" value="<?php echo remove_junk($product['laboratorio']);?>" placeholder="laboratorio">
               </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <select class="form-control" name="product-categorie">
                    <option value="">Selecciona una categoría</option>
                   <?php  foreach ($all_categories as $cat): ?>
                     <option value="<?php echo (int)$cat['id']; ?>" <?php if($product['categorie_id'] === $cat['id']): echo "selected"; endif; ?> >
                       <?php echo remove_junk($cat['name']); ?></option>
                   <?php endforeach; ?>
                 </select>
                  </div>
                  <div class="col-md-6">
                    <select class="form-control" name="product-photo">
                      <option value=""> Sin imagen</option>
                      <?php  foreach ($all_photo as $photo): ?>
                        <option value="<?php echo (int)$photo['id'];?>" <?php if($product['media_id'] === $photo['id']): echo "selected"; endif; ?> >
                          <?php echo $photo['file_name'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
		      <div class="form-group">
                <div class="row">
					
                  <div class="col-md-6">
                    <select class="form-control" name="product-provider" required>
                      <option value="">Selecciona un proveedor</option>
                    <?php  foreach ($all_providers as $pro): ?>
                      <option value="<?php echo $pro['nom_empresa'];?>" <?php if ($product['prov']==$pro['nom_empresa']){echo "selected";}?>>
                        <?php echo $pro['nom_empresa'] ?></option>
                    <?php endforeach; ?>
                    </select>
					</div>
					
					<div class="col-md-6">
                    <select class="form-control" name="product-sucursal" required>
                      <option value="">Selecciona un sucursal</option>
                    <?php  foreach ($all_sucursal as $suc): ?>
                      <option value="<?php echo $suc['id'] ?>" <?php if ($product['id_sucursal']==$suc['id']){echo "selected";}?>>
                        <?php echo $suc['nombre_sucursal'] ?></option>
                    <?php endforeach; ?>
                    </select>
					</div>
					
                </div>
				  
              </div>
              <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="qty">Cantidad</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                       <i class="glyphicon glyphicon-shopping-cart"></i>
                      </span>
                      <input type="text" class="form-control" name="product-quantity" value="<?php echo remove_junk($product['quantity']); ?>">
                   </div>
                  </div>
                 </div>
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="qty">Precio de compra</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-usd"></i>
                      </span>
                      <input type="float" class="form-control" name="buying-price" value="<?php echo remove_junk($product['buy_price']);?>">
                      <span class="input-group-addon">.00</span>
                   </div>
                  </div>
                 </div>
                  <div class="col-md-4">
                   <div class="form-group">
                     <label for="qty">Precio de venta</label>
                     <div class="input-group">
                       <span class="input-group-addon">
                         <i class="glyphicon glyphicon-usd"></i>
                       </span>
                       <input type="float" class="form-control" name="saleing-price" value="<?php echo remove_junk($product['sale_price']);?>">
                       <span class="input-group-addon">.00</span>
                    </div>
                   </div>
                  </div>
               </div>
              </div>
			    <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="qty">Cantidad de blisters</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                       <i class="glyphicon glyphicon-shopping-cart"></i>
                      </span>
                      <input type="text" class="form-control" name="cantidad_blister" value="<?php echo remove_junk($product['cantidad_blister']); ?>">
                   </div>
                  </div>
                 </div>
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="qty">Precio de blister</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-usd"></i>
                      </span>
                      <input type="float" class="form-control" name="precio_blister" value="<?php echo remove_junk($product['precio_blister']);?>">
                      <span class="input-group-addon">.00</span>
                   </div>
                  </div>
                 </div>
                 
               </div>
              </div>
			    <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="qty">Unidades en blister</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                       <i class="glyphicon glyphicon-shopping-cart"></i>
                      </span>
                      <input type="text" class="form-control" name="cantidad_unidad" value="<?php echo remove_junk($product['cantidad_unidad']); ?>">
                   </div>
                  </div>
                 </div>
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="qty">Precio de unidad</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-usd"></i>
                      </span>
                      <input type="float" class="form-control" name="precio_unidad" value="<?php echo remove_junk($product['precio_unidad']);?>">
                      <span class="input-group-addon">.00</span>
                   </div>
                  </div>
                 </div>
                 
               </div>
              </div>
			   <h3>Fecha de Caducidad</h3>
			  <input type="text" class="datepicker form-control" name="fecha_caducidad" value="<?php echo $product['fecha_caducidad']?>" placeholder="Fecha de caducidad">
			 
              <button type="submit" name="product" class="btn btn-danger">Actualizar</button>
          </form>
         </div>
        </div>
      </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
