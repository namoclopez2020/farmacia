<?php
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>

<?php
 // Auto completado
    $html = '';
   if(isset($_POST['product_name']) && strlen($_POST['product_name']))
   {
     $products = find_product_by_anything($_POST['product_name'],$_POST['sucursal']);
     if($products){
        foreach ($products as $product):
           $html .= "<li class=\"list-group-item\">";
           $html .= $product['name'];
           $html .= "</li>";
         endforeach;
      } else {

        $html .= '<li onClick=\"fill(\''.addslashes().'\')\" class=\"list-group-item\">';
        $html .= 'No encontrado';
        $html .= "</li>";

      }

      echo json_encode($html);
   }
 ?>
 <?php
 // encontrar todos los productos
  if(isset($_POST['p_name']) && strlen($_POST['p_name']))
  {
    $product_title = remove_junk($db->escape($_POST['p_name']));
	  $sucursal=remove_junk($db->escape($_POST['sucursal']));
    if($results = find_product_info_by_anything($product_title,$sucursal)){
		$all_categories=find_all('categories');
		$all_sucursales=find_all('sucursales');
        foreach ($results as $result) {
     	foreach($all_categories as $cat){
			if($cat['id']==$result['categorie_id']){
				$categoria=$cat['name'];
			}
		}
			foreach($all_sucursales as $suc){
			if($suc['id']==$result['id_sucursal']){
				$sucursal=$suc['nombre_sucursal'];
			}
		}
          $html .= "<tr>";

          $html .= "<td id=\"s_name\" class='text-center'>".$result['name']."</td>";
          $html .= "<input type=\"hidden\" name=\"s_id\" value=\"{$result['id']}\">";
          $html  .= "<td class='text-center'>";
          $html  .= "{$categoria}";
          $html  .= "</td>";
          $html .= "<td id=\"s_qty\" class='text-center'>";
          $html .= "{$result['quantity']}";
          $html  .= "</td>";
          $html  .= "<td class='text-center'>";
          $html  .= "{$result['buy_price']}";
          $html  .= "</td>";
          $html  .= "<td class='text-center'>";
          $html  .= "{$result['sale_price']}";
          $html  .= "</td>";
          $html  .= "<td class='text-center'>";
          $html  .= "{$result['prov']}";
          $html  .= "</td>";
		  $html  .= "<td class='text-center'>";
          $html  .= "{$sucursal}";
          $html  .= "</td>";
		  $html  .= "<td class='text-center'>";
          $html  .= "{$result['date']}";
          $html  .= "</td>";
		  $html  .="<td class='text-center'>";
		  $html  .="<div class='btn-group'>";
		  $html  .="<a href='edit_product.php?id={$result['id']} class='btn btn-info btn-xs'  title='Editar' data-toggle='tooltip'>";
          $html  .=" <span class='glyphicon glyphicon-edit'></span>
                    </a>";       
          $html  .="<a href='delete_product.php?id={$result['id']} class='btn btn-danger btn-xs'  title='Eliminar' data-toggle='tooltip'>";          
          $html  .="<span class='glyphicon glyphicon-trash'></span>
		  </a>
                  </div>
                </td>
		  ";           
                     
                      
                    
			
          $html  .= "</tr>";

        }
    } else {
        $html ='<tr><td>El producto no se encuentra registrado en la base de datos</td></tr>';
    }

    echo json_encode($html);
  }
 ?>
