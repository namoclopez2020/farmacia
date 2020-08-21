<?php
require_once('../includes/load.php');

  // Checkear nivel de permiso para esta pagina
  page_require_level(2);
$products = join_product_table();
if(isset($_POST['categoria'])){
   // si no hay errores
   
	   //captura de datos por medio POST
	   //si se trata de un generico o de marca:
	   if($_POST['categoria']=='16' || $_POST['categoria']=='17'){
		   
	   
	   
	   $fecha_caducidad=$_POST['fecha_caducidad'];
	 $cantidad_blister  = remove_junk($db->escape($_POST['cantidad_blister']));
		$precio_blister  = remove_junk($db->escape($_POST['precio_blister']));  
		 $cantidad_unidad = remove_junk($db->escape($_POST['cantidad_unidad']));
	     $precio_unidad = remove_junk($db->escape($_POST['precio_unidad']));
		 $p_sale  = remove_junk($db->escape($_POST['sale_price']));
		 
		 
	   }
	  
	   //si se trata de un perfume o algun otro producto no fraccionado
	   else{
		   
		   $fecha_caducidad="2090-11-19";
		   $precio_unidad=remove_junk($db->escape($_POST['sale_price']));
		   $cantidad_unidad=1000;
		   $cantidad_blister=1000;
		   $precio_blister=2000;
		   $p_sale=remove_junk($db->escape($_POST['sale_price']));
		   
	   }
	   
	   
	   $cont=1;
	   $p_buy   = remove_junk($db->escape($_POST['buying_price']));
	    $p_compuesto=remove_junk($db->escape($_POST['compuesto-title']));
	    
	   $laboratorio= remove_junk($db->escape($_POST['laboratorio-title'])); 
	   $p_cat   = remove_junk($db->escape($_POST['categoria']));
	   $p_name  = remove_junk($db->escape($_POST['product-title']));
	   $id_sucursal=remove_junk($db->escape($_POST['product-sucursal']));
	   $p_provid  = remove_junk($db->escape($_POST['product-provider']));
	 $p_qty="0F0";
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
     //  redirect('./product.php', false);
		
     } else {
       $session->msg('d',' Lo siento, registro falló.');
      // redirect('./add_product.php', false);
     }
echo display_msg($msg);
   

 }

?>