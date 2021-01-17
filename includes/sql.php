<?php
  require_once(LIB_PATH_INC.'load.php');

/*--------------------------------------------------------------*/
/* Function for find all database table rows by table name
/*--------------------------------------------------------------*/
function find_all($table) {
   global $db;
   if(tableExists($table))
   {
     return find_by_sql("SELECT * FROM ".$db->escape($table));
   }
}


function find_all_user_name($table) {
   global $db;
   if(tableExists($table))
   {
     return find_by_sql("SELECT name FROM ".$db->escape($table)."ORDER BY name");
   }
}
/*--------------------------------------------------------------*/
/* Function for Perform queries
/*--------------------------------------------------------------*/
function find_by_sql($sql)
{
  global $db;
  $result = $db->query($sql);
  $result_set = $db->while_loop($result);
 return $result_set;
}
/*--------------------------------------------------------------*/
/*  Function for Find data from table by id
/*--------------------------------------------------------------*/
function find_by_id($table,$id)
{
  global $db;
  $id = (int)$id;
    if(tableExists($table)){
          $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE id='{$db->escape($id)}' LIMIT 1");
          if($result = $db->fetch_assoc($sql))
            return $result;
          else
            return null;
     }
}
function find_by_id1($table,$id)
{
  global $db;
  $id = (int)$id;
    if(tableExists($table)){
          $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE id_prov='{$db->escape($id)}' ");
          if($result = $db->fetch_assoc($sql))
            return $result;
          else
            return null;
     }
}
function find_by_id2($table,$id)
{
  global $db;
  $id = (int)$id;
    if(tableExists($table)){
          $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE id_cliente='{$db->escape($id)}' ");
          if($result = $db->fetch_assoc($sql))
            return $result;
          else
            return null;
     }
}
/*--------------------------------------------------------------*/
/* Function for Delete data from table by id
/*--------------------------------------------------------------*/
function delete_by_id($table,$id)
{
  global $db;
  if(tableExists($table))
   {
    $sql = "DELETE FROM ".$db->escape($table);
    $sql .= " WHERE id=". $db->escape($id);
    $sql .= " LIMIT 1";
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
   }
}


function delete_by_id1($table,$id)
{
  global $db;
  if(tableExists($table))
   {
    $sql = "DELETE FROM ".$db->escape($table);
    $sql .= " WHERE id_prov=". $db->escape($id);
    $sql .= " LIMIT 1";
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
   }
}
function delete_by_id2($table,$id)
{
  global $db;
  if(tableExists($table))
   {
    $sql = "DELETE FROM ".$db->escape($table);
    $sql .= " WHERE id_cliente=". $db->escape($id);
    $sql .= " LIMIT 1";
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
   }
}
/*--------------------------------------------------------------*/
/* Function for Count id  By table name
/*--------------------------------------------------------------*/

function count_by_id($table){
  global $db;
  if(tableExists($table))
  {
    $sql    = "SELECT COUNT(id) AS total FROM ".$db->escape($table);
    $result = $db->query($sql);
     return($db->fetch_assoc($result));
  }
}
/*--------------------------------------------------------------*/
/* Determine if database table exists
/*--------------------------------------------------------------*/
function tableExists($table){
  global $db;
  $table_exit = $db->query('SHOW TABLES FROM '.DB_NAME.' LIKE "'.$db->escape($table).'"');
      if($table_exit) {
        if($db->num_rows($table_exit) > 0)
              return true;
         else
              return false;
      }
  }
 /*--------------------------------------------------------------*/
 /* Login with the data provided in $_POST,
 /* coming from the login form.
/*--------------------------------------------------------------*/
  function authenticate($username='', $password='') {
    global $db;
    $username = $db->escape($username);
    $password = $db->escape($password);
    $sql  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
    $result = $db->query($sql);
    if($db->num_rows($result)){
      $user = $db->fetch_assoc($result);
      $password_request = sha1($password);
      if($password_request === $user['password'] ){
        return $user['id'];
      }
    }
   return false;
  }
  /*--------------------------------------------------------------*/
  /* Login with the data provided in $_POST,
  /* coming from the login_v2.php form.
  /* If you used this method then remove authenticate function.
 /*--------------------------------------------------------------*/
   function authenticate_v2($username='', $password='') {
     global $db;
     $username = $db->escape($username);
     $password = $db->escape($password);
     $sql  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
     $result = $db->query($sql);
     if($db->num_rows($result)){
       $user = $db->fetch_assoc($result);
       $password_request = sha1($password);
       if($password_request === $user['password'] ){
         return $user;
       }
     }
    return false;
   }


  /*--------------------------------------------------------------*/
  /* Find current log in user by session id
  /*--------------------------------------------------------------*/
  function current_user(){
      static $current_user;
      global $db;
      if(!$current_user){
         if(isset($_SESSION['user_id'])):
             $user_id = intval($_SESSION['user_id']);
             $current_user = find_by_id('users',$user_id);
        endif;
      }
    return $current_user;
  }
  /*--------------------------------------------------------------*/
  /* Find all user by
  /* Joining users table and user gropus table
  /*--------------------------------------------------------------*/
  function find_all_user(){
      global $db;
      $results = array();
      $sql = "SELECT u.id,u.name,u.username,u.user_level,u.status,u.last_login,";
      $sql .="g.group_name ";
      $sql .="FROM users u ";
      $sql .="LEFT JOIN user_groups g ";
      $sql .="ON g.group_level=u.user_level ORDER BY u.name ASC";
      $result = find_by_sql($sql);
      return $result;
  }
  /*--------------------------------------------------------------*/
  /* Function to update the last log in of a user
  /*--------------------------------------------------------------*/

 function updateLastLogIn($user_id)
	{
		global $db;
    $date = make_date();
    $sql = "UPDATE users SET last_login='{$date}' WHERE id ='{$user_id}' LIMIT 1";
    $result = $db->query($sql);
    return ($result && $db->affected_rows() === 1 ? true : false);
	}

  /*--------------------------------------------------------------*/
  /* Find all Group name
  /*--------------------------------------------------------------*/
  function find_by_groupName($val)
  {
    global $db;
    $sql = "SELECT group_name FROM user_groups WHERE group_name = '{$db->escape($val)}' LIMIT 1 ";
    $result = $db->query($sql);
    return($db->num_rows($result) === 0 ? true : false);
  }
  /*--------------------------------------------------------------*/
  /* Find group level
  /*--------------------------------------------------------------*/
  function find_by_groupLevel($level)
  {
    global $db;
    $sql = "SELECT group_level FROM user_groups WHERE group_level = '{$db->escape($level)}' LIMIT 1 ";
    $result = $db->query($sql);
    return($db->num_rows($result) === 0 ? true : false);
  }
  function find_grouplevel_by_id($id)
  {
	global $db;
	  $sql="SELECT user_level FROM users WHERE id=$id LIMIT 1";
	  $resul=$db->query($sql);
	  $resu=$db->fetch_array($resul);
	  $result=$resu['user_level'];
	  return $result;
  }
  /*--------------------------------------------------------------*/
  /* Function for cheaking which user level has access to page
  /*--------------------------------------------------------------*/
   function page_require_level($require_level){
     global $session;
     $current_user = current_user();
     $login_level = find_by_groupLevel($current_user['user_level']);
     //if user not login
     if (!$session->isUserLoggedIn(true)):
            $session->msg('d','Por favor Iniciar sesión...');
            redirect('index.php', false);
      //if Group status Deactive
     elseif($login_level['group_status'] === '0'):
           $session->msg('d','Este nivel de usaurio esta inactivo!');
           redirect('home.php',false);
      //cheackin log in User level and Require level is Less than or equal to
     elseif($current_user['user_level'] <= (int)$require_level):
              return true;
      else:
            $session->msg("d", "¡Lo siento!  no tienes permiso para ver la página.");
            redirect('home.php', false);
        endif;

     }
   /*--------------------------------------------------------------*/
   /* Function for Finding all product name
   /* JOIN with categorie  and media database table
   /*--------------------------------------------------------------*/
  function join_product_table(){
		global $db;
		$sql  =" SELECT p.id,p.name,p.quantity,p.buy_price,p.sale_price,p.prov,p.media_id,p.date,p.id_sucursal,p.compuesto_prod,p.laboratorio,p.fecha_caducidad,visto,c.name";
		$sql  .=" AS categorie,m.file_name AS image";
		$sql  .=" FROM products p";
		$sql  .=" LEFT JOIN categories c ON c.id = p.categorie_id";
		$sql  .=" LEFT JOIN media m ON m.id = p.media_id";
		//$sql  .=" LEFT JOIN sucursales s ON s.id=p.id_sucursales";
		$sql  .=" ORDER BY p.id ASC";
		return find_by_sql($sql);

   }
   function join_product_table_reporte($sucursal = null, $laboratorio = null){
		global $db;
		$usuario = current_user();

    $sucursal_sql = find_by_id('sucursales',$sucursal);

    $sql = 'SELECT p.name , p.quantity, p.laboratorio FROM products AS p';
    if($sucursal != null){
      $sql .= ' WHERE p.id_sucursal = '.$sucursal.' GROUP BY p.laboratorio';
    }
    $sql .= ' ORDER BY p.laboratorio ASC';
    
    $productos = find_by_sql($sql);

    $data = [
      'productos' => $productos,
      'sucursal' => $sucursal_sql
    ];
		
		return $data;

  }
 function join_product_table_sucursal($sucursal){
     global $db;
     $sql  =" SELECT p.id,p.name,p.quantity,p.buy_price,p.sale_price,p.prov,p.media_id,p.date,p.id_sucursal,p.compuesto_prod,p.laboratorio,p.fecha_caducidad,visto,c.name";
    $sql  .=" AS categorie,m.file_name AS image";
    $sql  .=" FROM products p";
    $sql  .=" LEFT JOIN categories c ON c.id = p.categorie_id";
    $sql  .=" LEFT JOIN media m ON m.id = p.media_id";
	$sql  .=" LEFT JOIN sucursales s ON s.id=p.id_sucursal";
	$sql.=" WHERE id_sucursal='$sucursal'";
    $sql  .=" ORDER BY p.id ASC";
    return find_by_sql($sql);

   }
function join_sucursal_table(){
     global $db;
     $sql  =" SELECT * FROM sucursales";
    return find_by_sql($sql);

   }
  /*--------------------------------------------------------------*/	
  /* Function for Finding all product name
  /* Request coming from ajax.php for auto suggest
  /*--------------------------------------------------------------*/

   function find_product_by_title($product_name){
     global $db;
     $p_name = remove_junk($db->escape($product_name));
     $sql = "SELECT name FROM products WHERE name like '%$p_name%' LIMIT 1";
     $result = find_by_sql($sql);
     return $result;
   }
//encontrar el nombre del producto por cualquier palabra
  function find_product_by_anything($palabra,$sucursal){
	  global $db;
	  $sql="SELECT * FROM categories WHERE name='".$palabra."'";
	  $id_cat=find_by_sql($sql);
	  
	  foreach($id_cat as $categ){
		  $id_categoria=$categ['id'];
	  }
	  $aColumns = array('name','categorie_id','laboratorio');//Columnas de busqueda
		 $sTable = "products";
		 $sWhere = "";
			
	  		$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if(isset($id_categoria) && $i==1){
					$sWhere .= $aColumns[$i]." LIKE '%".$id_categoria."%' OR ";
				}else{
				$sWhere .= $aColumns[$i]." LIKE '%".$palabra."%' OR ";
				}
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ') AND id_sucursal='.$sucursal.'';
	  $consulta="SELECT name FROM products $sWhere LIMIT 1" ;
	  $resultado=find_by_sql($consulta);
	  return $resultado;
	  
		
  }
//encontrar toda la info del producto por cualquier palabra
 function find_product_info_by_anything($palabra,$sucursal){
	  global $db;
	  $sql="SELECT * FROM categories WHERE name='".$palabra."'";
	  $id_cat=find_by_sql($sql);
	  foreach($id_cat as $categ){
		  $id_categoria=$categ['id'];
	  }
	  $aColumns = array('name','categorie_id','laboratorio');//Columnas de busqueda
		// $sTable = "products";
		 $sWhere = "";
			
	  		$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if(isset($id_categoria) && $i==1){
					$sWhere .= $aColumns[$i]." LIKE '%".$id_categoria."%' OR ";
				}else{
					$sWhere .= $aColumns[$i]." LIKE '%".$palabra."%' OR ";
				}
				
				
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ') AND id_sucursal='.$sucursal.'';
	  $consulta="SELECT * FROM products $sWhere " ;
	  $resultado=find_by_sql($consulta);
	  return $resultado;
	  
		
  }

  /*--------------------------------------------------------------*/
  /* Function for Finding all product info by product title
  /* Request coming from ajax.php
  /*--------------------------------------------------------------*/
  function find_all_product_info_by_title($title){
    global $db;
    $sql  = "SELECT * FROM products ";
    $sql .= " WHERE name ='{$title}'";
    $sql .=" LIMIT 1";
    return find_by_sql($sql);
  }
function find_all_product_info_by_title_1($title){
    global $db;
    $sql  = "SELECT * FROM products ";
    $sql .= " WHERE name LIKE '%".$title."%' ";
   // $sql .=" LIMIT 1";
    return find_by_sql($sql);
  }

function find_all_provider(){
    global $db;
    $sql  = "SELECT * FROM proveedores ";
    return find_by_sql($sql);
  }

  /*--------------------------------------------------------------*/
  /* Function for Update product quantity
  /*--------------------------------------------------------------*/
  function update_product_qty($qty,$p_id){
    global $db;
    $qty = (int) $qty;
    $id  = (int)$p_id;
    $sql = "UPDATE products SET quantity=quantity -'{$qty}' WHERE id = '{$id}'";
    $result = $db->query($sql);
    return($db->affected_rows() === 1 ? true : false);

  }
  /*--------------------------------------------------------------*/
  /* Function for Display Recent product Added
  /*--------------------------------------------------------------*/
 function find_recent_product_added($limit){
   global $db;
   $sql   = " SELECT p.id,p.name,p.sale_price,p.media_id,c.name AS categorie,";
   $sql  .= "m.file_name AS image FROM products p";
   $sql  .= " LEFT JOIN categories c ON c.id = p.categorie_id";
   $sql  .= " LEFT JOIN media m ON m.id = p.media_id";
   $sql  .= " ORDER BY p.id DESC LIMIT ".$db->escape((int)$limit);
   return find_by_sql($sql);
 }
 /*--------------------------------------------------------------*/
 /* Function for Find Highest saleing Product
 /*--------------------------------------------------------------*/
 function find_higest_saleing_product($limit){
   global $db;
   $sql  = "SELECT p.name, COUNT(s.product_id) AS totalSold, SUM(s.qty) AS totalQty";
   $sql .= " FROM sales s";
   $sql .= " LEFT JOIN products p ON p.id = s.product_id ";
   $sql .= " GROUP BY s.product_id";
   $sql .= " ORDER BY SUM(s.qty) DESC LIMIT ".$db->escape((int)$limit);
   return $db->query($sql);
 }
 /*--------------------------------------------------------------*/
 /* Function for find all sales
 /*--------------------------------------------------------------*/
 function find_all_sale(){
   global $db;
   $sql  = "SELECT s.id,s.qty,s.price,s.date,p.name";
   $sql .= " FROM sales s";
   $sql .= " LEFT JOIN products p ON s.product_id = p.id";
   $sql .= " ORDER BY s.date DESC";
   return find_by_sql($sql);
 }
 /*--------------------------------------------------------------*/
 /* Function for Display Recent sale
 /*--------------------------------------------------------------*/
function find_recent_sale_added($limit){
  global $db;
  $sql  = "SELECT s.id,s.qty,s.price,s.date,p.name";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " ORDER BY s.date DESC LIMIT ".$db->escape((int)$limit);
  return find_by_sql($sql);
}
//funcion para calcular en la venta cuantas unidades, blister, y cajas se venderan
function convertir_cantidad_numerico($cantidad,$id_producto){
	global $db;
	$sql="SELECT quantity,cantidad_blister,cantidad_unidad FROM products WHERE id='".$id_producto."'";
	$result=find_by_sql($sql);
	
	$blister=0;
	
	foreach($result as $results){
		$stock=$results['quantity'];
		$blisters_en_caja=$results['cantidad_blister'];
		$unidades_en_blister=$results['cantidad_unidad'];
		
	}
	list($cantidad_cajas,$cantidad_unidades)=explode("F",$cantidad);
	while($cantidad_unidades>=$unidades_en_blister){
		$blister++;
		$cantidad_unidades=$cantidad_unidades-$unidades_en_blister;
	}
	$total=$cantidad_cajas.",".$blister.",".$cantidad_unidades;
    return $total;
}
//funcion para validar stock
function convertir_cantidad_numerico1($cantidad,$id_producto){
	global $db;
	$sql="SELECT quantity,cantidad_blister,cantidad_unidad FROM products WHERE id='".$id_producto."'";
	$result=find_by_sql($sql);
	
	$blister=0;
	
	foreach($result as $results){
		$stock=$results['quantity'];
		$blisters_en_caja=$results['cantidad_blister'];
		$unidades_en_blister=$results['cantidad_unidad'];
		
	}
	list($cantidad_cajas,$cantidad_unidades)=explode("F",$cantidad);
	
	$total=$cantidad_cajas.",".$cantidad_unidades;
    return $total;
}

function stock_final_producto_venta($cantidad,$id_producto){
	global $db;
	$sql="SELECT quantity,cantidad_blister,cantidad_unidad FROM products WHERE id='".$id_producto."'";
		$result=find_by_sql($sql);
		foreach($result as $results){
			$stock=$results['quantity'];
			$blisters_en_caja=$results['cantidad_blister'];
			$unidades_en_blister=$results['cantidad_unidad'];
		}
	
		//cantidad de pastillas en una caja
		$cantidad_pastillas=$unidades_en_blister*$blisters_en_caja;
		//cantidad de la base de datos
		list($stock_cajas,$stock_unidades)=explode("F",$stock);
		//cantidad recibida por la funcion
		list($cantidad_cajas,$cantidad_unidades)=explode("F",$cantidad);
	    
		
	 //cuando pido mas unidades de las que hay en una caja y hay caja sellada aun
	
		if($cantidad_unidades>=$stock_unidades && $cantidad_unidades>0 && $stock_cajas!=$cantidad_cajas ){
			$stock_cajas--;
			$stock_unidades=$cantidad_pastillas+$stock_unidades-$cantidad_unidades;
			if($cantidad_cajas!=0)
			{
				$stock_cajas=$stock_cajas-$cantidad_cajas;
			}			//cuando solo pido cajas con 0 unidades
		}
		
		elseif($cantidad_unidades==0 && $cantidad_cajas>0){
			$stock_cajas=$stock_cajas-$cantidad_cajas;
	        
		//cuando pido cajas y unidades y ambos son diferentes de cero	
		}elseif($cantidad_unidades>0 && $cantidad_unidades<=$stock_unidades && $cantidad_cajas>0 && $cantidad_cajas<=$stock_cajas ){
			$stock_cajas=$stock_cajas-$cantidad_cajas;
			$stock_unidades=$stock_unidades-$cantidad_unidades;
		//cuando pido todo el stock
		}elseif($cantidad_cajas==$stock_cajas && $cantidad_unidades==$stock_unidades){
			$stock_cajas=0;
			$stock_unidades=0;
	 //cuando solo pido unidades y esta cantidad es menor o igual al stock
		}elseif($stock_cajas==0 && $cantidad_cajas==0 && $stock_unidades>=$cantidad_unidades && $cantidad_unidades!=0){
			$stock_unidades=$stock_unidades-$cantidad_unidades;
		}
	 //cuando solo pido unidades y el stock tiene por lo menos una caja
		elseif($stock_cajas!=0 && $cantidad_cajas==0 && $stock_unidades>=$cantidad_unidades && $cantidad_unidades!=0)
		{
			$stock_unidades=$stock_unidades-$cantidad_unidades;
		}
		
		$stock_final=$stock_cajas."F".$stock_unidades;
	
	$sql = "UPDATE products SET quantity='{$stock_final}' WHERE id = '{$id_producto}'";
    $result = $db->query($sql);
    return($db->affected_rows() === 1 ? true : false);
}


function sumar_stock($cantidad,$id_producto){
	global $db;
	$sql="SELECT quantity,cantidad_blister,cantidad_unidad FROM products WHERE id='".$id_producto."'";
		$result=find_by_sql($sql);
		foreach($result as $results){
			$stock=$results['quantity'];
			$blisters_en_caja=$results['cantidad_blister'];
			$unidades_en_blister=$results['cantidad_unidad'];
		}
	
		//cantidad de pastillas en una caja
		$cantidad_pastillas=$unidades_en_blister*$blisters_en_caja;
		//cantidad de la base de datos
		list($stock_cajas,$stock_unidades)=explode("F",$stock);
		//cantidad recibida por la funcion
		list($cantidad_cajas,$cantidad_unidades)=explode("F",$cantidad);
	 //cuando pido mas unidades de las que hay en una caja y hay caja sellada aun
	 $cajas=0;
	 $unidades=$stock_unidades+$cantidad_unidades;
		while($unidades>=$cantidad_pastillas){
			$cajas++;
			$unidades=$unidades-$cantidad_pastillas;
		}
	$cajas=$cantidad_cajas+$stock_cajas+$cajas;
	
	$stock_final=$cajas."F".$unidades;
	return $stock_final;
}
/*--------------------------------------------------------------*/
/* Function for Generate sales report by two dates
/*--------------------------------------------------------------*/

function find_sale_by_dates_v2($start_date,$end_date){
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = "SELECT s.date, p.name,p.sale_price,p.buy_price,";
  $sql .= "COUNT(s.product_id) AS total_records,";
  $sql .= "SUM(s.qty) AS total_sales,";
  $sql .= "SUM(s.price) AS total_saleing_price,";
  $sql .= "SUM(p.buy_price * s.qty) AS total_buying_price ";
  $sql .= "FROM sales s ";
  $sql .= "LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " WHERE s.date BETWEEN '{$start_date}' AND '{$end_date}'";
  $sql .= " GROUP BY DATE(s.date),p.name";
  $sql .= " ORDER BY DATE(s.date) DESC";
  return $db->query($sql);
}
function  find_sale_by_dates_user($start,$end,$vendedor){
  global $db;
  $start_date  = date("Y-m-d", strtotime($start));
  $end_date    = date("Y-m-d", strtotime($end));
  $sql  = "SELECT * FROM sales where";
  $sql .= " DATE_FORMAT(date, '%Y-%m-%d') between '{$start_date}' and '{$end_date}' and id_vendedor='$vendedor'";
  //$sql .= " GROUP BY date,id_vendedor,product_id,qty";
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Function for Generate Daily sales report
/*--------------------------------------------------------------*/
function  dailySales($year,$month,$day){
  global $db;
  $sql  = "SELECT * FROM sales where";
  $sql .= " date = '{$year}-{$month}-{$day}'";
  //$sql .= " GROUP BY date,id_vendedor,product_id,qty";
  return find_by_sql($sql);
}
function  dailySalesByUser($year,$month,$day,$vendedor){
  global $db;
  $sql  = "SELECT * FROM sales where";
  $sql .= " DATE_FORMAT(date, '%Y-%m-%d') = '{$year}-{$month}-{$day}' and id_vendedor='$vendedor'";
  //$sql .= " GROUP BY date,id_vendedor,product_id,qty";
  return find_by_sql($sql);
}
function  dailySalesBySucursal($year,$month,$day,$sucursal){
  global $db;
  $sql  = "SELECT * FROM sales where";
  $sql .= " DATE_FORMAT(date, '%Y-%m-%d') = '{$year}-{$month}-{$day}' and id_sucursal='$sucursal'";
  //$sql .= " GROUP BY date,id_vendedor,product_id,qty";
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Function for Generate Monthly sales report
/*--------------------------------------------------------------*/
function  monthlySales($year,$month){
  global $db;
  $sql  = "SELECT * ";
  $sql .= " FROM sales";
  $sql .= " WHERE DATE_FORMAT(date, '%Y-%m' ) = '{$year}-{$month}'";
 
  return find_by_sql($sql);
}

function  monthlySalesBySucursal($year,$month,$sucursal){
  global $db;
  $sql  = "SELECT * ";
  $sql .= " FROM sales";
  $sql .= " WHERE DATE_FORMAT(date, '%Y-%m' ) = '{$year}-{$month}' and id_sucursal='$sucursal'";
 
  return find_by_sql($sql);
}

function  monthlySalesByUser($year,$month,$usuario){
  global $db;
  $sql  = "SELECT * ";
  $sql .= " FROM sales";
  $sql .= " WHERE DATE_FORMAT(date, '%Y-%m' ) = '{$year}-{$month}' and id_vendedor='$usuario'";
 
  return find_by_sql($sql);
}

function insertar_movimiento_producto($id_producto,$tipo_movimiento,$cantidad,$id_usuario,$fecha){
	global $db;
$sql= "INSERT INTO movimientos (id_tipo_movimiento,id_vendedor_mov,id_producto_mov,cantidad_mov,fecha_movimiento) VALUES ('$tipo_movimiento','$id_usuario','$id_producto','$cantidad','$fecha')";
	 $insertar = $db->query($sql);
    return($db->affected_rows() === 1 ? true : false);
}
?>
