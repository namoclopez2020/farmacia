<?php
  $page_title = 'Agregar producto';
  require_once('includes/load.php');
  // Checkear nivel de permiso para esta pagina
  page_require_level(2);
  $all_categories = find_all('categories');
  $all_sucursales=find_all('sucursales');
  $all_providers= find_all('proveedores');
  $all_photo = find_all('media');
 $products = join_product_table();
$cone= $db->con();
if(isset($_POST['categoria'])){
$categoria=$_POST['categoria'];
}

foreach($all_categories as $catego){
	if($categoria==$catego['id']){
		$nombre_categoria=$catego['name'];
		
	}
}
?>
<?php
//si se pulsa el boton grabar producto
 if(isset($_POST['add_product'])){
   // si no hay errores
   if(empty($errors)){
	   //captura de datos por medio POST
	   //si se trata de un generico:
	   if($_POST['categoria-title']=='16'){
	   $p_cat   = remove_junk($db->escape($_POST['categoria-title']));
	   $laboratorio=$_POST['laboratorio-title'];
	   $fecha_caducidad=$_POST['fecha_caducidad'];
	   if(isset($_POST['cantidad_blister'])){
		   $cantidad_blister  = remove_junk($db->escape($_POST['cantidad_blister']));}
	   else{
		   $cantidad_blister=0;
	   }
     
	   
	   if(isset($_POST['precio_blister'])){
		$precio_blister  = remove_junk($db->escape($_POST['precio_blister']));   
	   }
	   else
	   {
	   $precio_blister=0;
	   }
	     
		 $cantidad_unidad = remove_junk($db->escape($_POST['cantidad_unidad']));
	     $precio_unidad = remove_junk($db->escape($_POST['precio_unidad']));
		 
		 $p_compuesto  = remove_junk($db->escape($_POST['compuesto-title']));

		 $p_qty   = $_POST['product-quantity'];
		 $p_buy   = remove_junk($db->escape($_POST['buying-price']));
		 $p_sale  = remove_junk($db->escape($_POST['saleing-price']));
		 
		 
	   }
	   //si se trata de uno de marca
	   elseif($_POST['categoria-title']=='17'){
		   $p_compuesto  = remove_junk($db->escape($_POST['compuesto-title']));
		  $p_cat   = remove_junk($db->escape($_POST['categoria-title'])); 
		  $laboratorio=$_POST['laboratorio-title'];
		  $fecha_caducidad=$_POST['fecha_caducidad'];
		  $p_qty   = $_POST['product-quantity'];
		   $cantidad_blister  = remove_junk($db->escape($_POST['cantidad_blister']));
		  $p_buy   = remove_junk($db->escape($_POST['buying_price']));
		  $p_sale  = remove_junk($db->escape($_POST['sale_price']));
		  $precio_blister=remove_junk($db->escape($_POST['precio_blister']));
		  $cantidad_unidad = remove_junk($db->escape($_POST['cantidad_unidad']));
		   $precio_unidad=remove_junk($db->escape($_POST['precio_unidad']));
		   
		   
	   }
	   //si se trata de un perfume
	   elseif($_POST['categoria-title']!='17' || $_POST['categoria-title']!='16'){
		   $p_qty=$_POST['product-quantity'];
		   $fecha_caducidad="2090-11-19";
		   $p_buy=remove_junk($db->escape($_POST['buying-price']));
		   $precio_unidad=remove_junk($db->escape($_POST['sale_price']));
		   $cantidad_unidad=1000;
		   $p_cat=remove_junk($db->escape($_POST['categoria-title']));
		   $p_compuesto=$_POST['compuesto-title'];
		   $cantidad_blister=1000;
		   $precio_blister=2000;
		   $p_sale=remove_junk($db->escape($_POST['sale_price']));;
		   $fecha_caducidad="2090-12-25";
		   $laboratorio=$_POST['laboratorio-title'];
	   }
	   
	   
	   $cont=1;
	   $p_name  = remove_junk($db->escape($_POST['product-title']));
	   $id_sucursal=remove_junk($db->escape($_POST['product-sucursal']));
	   $p_provid  = remove_junk($db->escape($_POST['product-provider']));
	   foreach($products as $product){
			 $cont++;
			
		 }
	 $code="P0".$cont;
     if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
       $media_id = '0';
     } else {
       $media_id = remove_junk($db->escape($_POST['product-photo']));
     }
     $date    = make_date();
	 $tipo_movimiento=1;
     $query  = "INSERT INTO products (";
     $query .=" quantity,name,codigo_producto,buy_price,sale_price,categorie_id,media_id,prov,date,compuesto_prod,id_sucursal,visto,cantidad_blister,precio_blister,cantidad_unidad,precio_unidad,fecha_caducidad,laboratorio";
     $query .=") VALUES (";
     $query .=" '{$p_qty}','{$p_name}','{$code}', '{$p_buy}', '{$p_sale}', '{$p_cat}', '{$media_id}', '{$p_provid}', '{$date}','{$p_compuesto}','{$id_sucursal}','no','{$cantidad_blister}','{$precio_blister}','{$cantidad_unidad}','{$precio_unidad}','{$fecha_caducidad}','{$laboratorio}'";
     $query .=")";
	  
	  
     //si la insercion se ejecuta correctamente
     if($db->query($query)){
		 $consulta="select LAST_INSERT_ID(id) as last from products order by id desc limit 0,1 ";
		 $id=$db->query($consulta);
		 $id=$db->fetch_array($id);
		 $id_producto=$id['last'];
		 
	 insertar_movimiento_producto($id_producto,$tipo_movimiento,$p_qty,$_SESSION['user_id'],$date);
		
       $session->msg('s',"Producto agregado exitosamente. ");
       redirect('product.php', false);
		
     } else {
       $session->msg('d',' Lo siento, registro falló.');
       redirect('add_product.php', false);
     }

   } else{
     $session->msg("d", $errors);
     redirect('add_product.php',false);
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
            <span>Agregar producto de <?php echo $nombre_categoria;?></span>
         </strong>
        </div>
		  <!-- formulario para generico -->
		  <?php if ($categoria=='16'){?>
        <div class="panel-body">
         <div class="col-md-12">
          <form method="post" action="add_product.php" class="clearfix">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-title" placeholder="Descripcion" required>
               </div>
              </div>
			  <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="compuesto-title" placeholder="Compuesto" required>
					<input type="text"  name="categoria-title"  value="<?php echo $categoria;?>"hidden>
               </div>
              </div>
			  <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="laboratorio-title" placeholder="Laboratorio" required>
               </div>
              </div>
              <div class="form-group">
                <div class="row">
					<div class="col-md-6">
                    <select class="form-control" name="product-provider" required>
                      <option value="">Selecciona un proveedor</option>
                    <?php  foreach ($all_providers as $pro): ?>
                      <option value="<?php echo $pro['nom_empresa'] ?>">
                        <?php echo $pro['nom_empresa'] ?></option>
                    <?php endforeach; ?>
                    </select>
					</div>
                  
                  <div class="col-md-6">
                    <select class="form-control" name="product-photo" >
                      <option value="">Selecciona una imagen</option>
                    <?php  foreach ($all_photo as $photo): ?>
                      <option value="<?php echo (int)$photo['id'] ?>">
                        <?php echo $photo['file_name'] ?></option>
                    <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
			  <div class="form-group">
                <div class="row">
					
                  
					<div class="col-md-6">
                    <select class="form-control" name="product-sucursal" required>
                      <option value="">Selecciona una sucursal</option>
                    <?php  foreach ($all_sucursales as $suc): ?>
                      <option value="<?php echo $suc['id'] ?>">
                        <?php echo $suc['nombre_sucursal'] ?></option>
                    <?php endforeach; ?>
                    </select>
					</div>
                </div>
              </div>
<h3>Cantidad</h3>
              <div class="form-group">
               <div class="row">
				   
				   
                 <div class="col-md-4">
					 
                   <div class="input-group">
					   	
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                     </span>
					   
                     <input type="text" class="form-control" name="product-quantity" placeholder="Cantidad" required>
                  </div>
                 </div>
                 <div class="col-md-4">
                   <div class="input-group">
					   
                     <span class="input-group-addon">
                       <i class="glyphicon glyphicon-usd"></i>
                     </span>
                     <input type="float" class="form-control" name="buying-price" placeholder="Precio de compra" required>
                     <span class="input-group-addon">.00</span>
                  </div>
                 </div>
                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-usd"></i>
                      </span>
                      <input type="float" class="form-control" name="saleing-price" placeholder="Precio de venta" required>
                      <span class="input-group-addon">.00</span>
                   </div>
                  </div>
               </div>
              </div>
			  
			  <h3>Cantidad de blisters en una caja</h3>
			   <div class="form-group">
               <div class="row">
                 <div class="col-md-5">
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                     </span>
                     <input type="number" class="form-control" name="cantidad_blister" placeholder="Cantidad de blister" >
                  </div>
                 </div>
                 
                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-usd"></i>
                      </span>
                      <input type="float" class="form-control" name="precio_blister" placeholder="Precio de blister" >
                      <span class="input-group-addon">.00</span>
                   </div>
                  </div>
               </div>
              </div>
			  
			  <h3>Cantidad de pastillas en un blister</h3>
			   <div class="form-group">
               <div class="row">
                 <div class="col-md-5">
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                     </span>
                     <input type="number" class="form-control" name="cantidad_unidad" placeholder="Cantidad de una unidades en blister" >
                  </div>
                 </div>
                 
                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-usd"></i>
                      </span>
                      <input type="float" class="form-control" name="precio_unidad" placeholder="Precio por unidad" >
                      <span class="input-group-addon">.00</span>
                   </div>
                  </div>
               </div>
              </div>
			  <h3>Fecha de Caducidad</h3>
			  <input type="text" class="datepicker form-control" name="fecha_caducidad" placeholder="Fecha de caducidad" autocomplete="off"><br>
			  
              <button type="submit" name="add_product" class="btn btn-danger">Agregar producto</button>
          </form>
         </div>
        </div>
		  <!-- formulario para comerciales -->
		<?php } elseif($categoria=='17'){ ?>
		  <div class="panel-body">
         <div class="col-md-12">
          <form method="post" action="add_product.php" class="clearfix" id="formcalcular" name="formcalcular">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-title" placeholder="Descripcion" required>
					<input type="text"  name="categoria-title"  value="<?php echo $categoria;?>" hidden>
               </div>
              </div>
			  <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="compuesto-title" placeholder="Compuesto" required>
					
               </div>
              </div>
			  <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="laboratorio-title" placeholder="Laboratorio" required>
               </div>
              </div>
              <div class="form-group">
                <div class="row">
					<div class="col-md-6">
                    <select class="form-control" name="product-provider" required>
                      <option value="">Selecciona un proveedor</option>
                    <?php  foreach ($all_providers as $pro): ?>
                      <option value="<?php echo $pro['nom_empresa'] ?>">
                        <?php echo $pro['nom_empresa'] ?></option>
                    <?php endforeach; ?>
                    </select>
					</div>
                  
                  <div class="col-md-6">
                    <select class="form-control" name="product-photo" >
                      <option value="">Selecciona una imagen</option>
                    <?php  foreach ($all_photo as $photo): ?>
                      <option value="<?php echo (int)$photo['id'] ?>">
                        <?php echo $photo['file_name'] ?></option>
                    <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
			  <div class="form-group">
                <div class="row">
					
                  
					<div class="col-md-6">
                    <select class="form-control" name="product-sucursal" required>
                      <option value="">Selecciona una sucursal</option>
                    <?php  foreach ($all_sucursales as $suc): ?>
                      <option value="<?php echo $suc['id'] ?>">
                        <?php echo $suc['nombre_sucursal'] ?></option>
                    <?php endforeach; ?>
                    </select>
					</div>
                </div>
              </div>
<h3>Cantidad</h3>
              <div class="form-group">
               <div class="row">
				   
				   
                 <div class="col-md-3">
					 
                   <div class="input-group">
					   	
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                     </span>
					   
                     <input type="text" class="form-control" name="product-quantity" placeholder="Cantidad" required>
                  </div>
                 </div>
				    <div class="col-md-4">
                   <div class="input-group">
					   
                     <span class="input-group-addon">
                       <i class="glyphicon glyphicon-usd"></i>
                     </span>
                     <input type="float" class="form-control" name="buying_price" id="buying_price" placeholder="Precio de compra" onChange="porcentaje()" required>
                     <span class="input-group-addon">.00</span>
                  </div>
                 </div>
                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-usd"></i>
                      </span>
                      <input type="text" class="form-control" name="sale_price" id="sale_price" onChange="porcentaje()" placeholder="Precio de venta" required>
                      <span class="input-group-addon">.00</span>
                   </div>
                  </div>
				   </div>
              </div>
			  <div class="form-group">
				  <h2>Porcentaje de utilidad</h2>
				  <div class="row">
					  
               <div class="col-md-3">
					  <div class="input-group">
				   <span class="input-group-addon">
						  <i class="glyphicon glyphicon-usd"></i>
						  </span>
						  <input type="text" class="form-control" name="utilidad" id="utilidad" >
						  <span class="input-group-addon">%</span>
				   </div>
					  </div>
				  </div>
			  </div>
			  
			  <h3>Cantidad de blisters en una caja</h3>
			   <div class="form-group">
               <div class="row">
                 <div class="col-md-5">
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                     </span>
                     <input type="text" class="form-control" name="cantidad_blister" id="cantidad_blister" onChange="blister()" placeholder="Cantidad de blister" >
                  </div>
                 </div>
                 
                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-usd"></i>
                      </span>
                      <input type="text" class="form-control" name="precio_blister" id="precio_blister" placeholder="Precio de blister" >
                      <span class="input-group-addon">.00</span>
                   </div>
                  </div>
               </div>
              </div>
			 <h3>Cantidad de pastillas en un blister</h3>
			   <div class="form-group">
               <div class="row">
                 <div class="col-md-5">
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                     </span>
                     <input type="number" class="form-control" name="cantidad_unidad" id="cantidad_unidad" onChange="unidad()" placeholder="Cantidad de una unidades en blister" >
                  </div>
                 </div>
                 
                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-usd"></i>
                      </span>
                      <input type="float" class="form-control" name="precio_unidad" id="precio_unidad" placeholder="Precio por unidad" >
                      <span class="input-group-addon">.00</span>
                   </div>
                  </div>
               </div>
              </div>
			  
			  
			  <h3>Fecha de Caducidad</h3>
			  <input type="text" class="datepicker form-control" name="fecha_caducidad" placeholder="Fecha de caducidad" autocomplete="off"><br>
              <button type="submit" name="add_product" class="btn btn-danger">Agregar producto</button>
          </form>
         </div>
        </div> <?php 
				
		}
		elseif($categoria!='16' || $categoria!='17'){ ?> 
		  <div class="panel-body">
         <div class="col-md-12">
          <form method="post" action="add_product.php" class="clearfix">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-title" placeholder="Descripcion" required>
					<input type="text"  name="categoria-title"  value="<?php echo $categoria;?>" hidden>
					
               </div>
              </div>
			  
			  <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="laboratorio-title" placeholder="Laboratorio" required>
					
					
               </div>
              </div>
			   <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="compuesto-title" placeholder="Compuesto" required>
					
					
               </div>
              </div>
			  
			 
              <div class="form-group">
                <div class="row">
					<div class="col-md-6">
                    <select class="form-control" name="product-provider" required>
                      <option value="">Selecciona un proveedor</option>
                    <?php  foreach ($all_providers as $pro): ?>
                      <option value="<?php echo $pro['nom_empresa'] ?>">
                        <?php echo $pro['nom_empresa'] ?></option>
                    <?php endforeach; ?>
                    </select>
					</div>
                  
                  <div class="col-md-6">
                    <select class="form-control" name="product-photo" >
                      <option value="">Selecciona una imagen</option>
                    <?php  foreach ($all_photo as $photo): ?>
                      <option value="<?php echo (int)$photo['id'] ?>">
                        <?php echo $photo['file_name'] ?></option>
                    <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
			  <div class="form-group">
                <div class="row">
					
                  
					<div class="col-md-6">
                    <select class="form-control" name="product-sucursal" required>
                      <option value="">Selecciona una sucursal</option>
                    <?php  foreach ($all_sucursales as $suc): ?>
                      <option value="<?php echo $suc['id'] ?>">
                        <?php echo $suc['nombre_sucursal'] ?></option>
                    <?php endforeach; ?>
                    </select>
					</div>
                </div>
              </div>
<h3>Cantidad</h3>
              <div class="form-group">
               <div class="row">
				   
				   
                 <div class="col-md-4">
					 
                   <div class="input-group">
					   	
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                     </span>
					   
                     <input type="text" class="form-control" name="product-quantity" placeholder="Cantidad" required>
                  </div>
                 </div>
                 <div class="col-md-4">
                   <div class="input-group">
					   
                     <span class="input-group-addon">
                       <i class="glyphicon glyphicon-usd"></i>
                     </span>
                     <input type="text" class="form-control" name="buying-price" placeholder="Precio de compra" required>
                     <span class="input-group-addon">.00</span>
                  </div>
                 </div>
                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-usd"></i>
                      </span>
                      <input type="text" class="form-control" name="sale_price" placeholder="Precio de Venta Unitario" required>
                      <span class="input-group-addon">.00</span>
                   </div>
                  </div>
               </div>
              </div>
			 
              <button type="submit" name="add_product" class="btn btn-danger">Agregar producto</button>
          </form>
         </div>
        </div> 
		  <?php }?>
		  
		  
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>