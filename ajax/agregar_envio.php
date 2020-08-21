<?php
	require_once('../includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
 $products = find_all('products'); 
$categorias=find_all('categories'); 
$session_id=$_SESSION['user_id'];

if (isset($_POST['id']))
{$id=$_POST['id'];}

if (isset($_POST['cantidad']))
{
	$cantidad=$_POST['cantidad'];
	$f="f";
	$ver=strpos($cantidad,$f);
	if($ver!==false){
			
	     $cambiar="F";
	     $cantidad=str_replace($f,$cambiar,$cantidad);
     }


}

if (!empty($id) and !empty($cantidad) )
{
$insert_tmp=$db->query("INSERT INTO tmp_envio (id_producto,cantidad_producto,session_id) VALUES ('$id','$cantidad','$session_id')");

}
if (isset($_GET['id']))//codigo elimina un elemento del array
{
$id_tmp=intval($_GET['id']);	
$delete=$db->query("DELETE FROM tmp_envio WHERE id_tmp_envio='".$id_tmp."'");
}

?>
<table class="table">
<tr>
	<th class='text-center'>CODIGO</th>
	<th class='text-center'>CANT.</th>
	<th class='text-center'>DESCRIPCION</th>
	<th class='text-center'>SUCURSAL PROVENIENTE.</th>
	<th></th>
</tr>
<?php
	$sumador_total=0;
	$sql=$db->query("select * from products, tmp_envio where products.id=tmp_envio.id_producto and tmp_envio.session_id='".$session_id."'");
	while ($row=$db->fetch_array($sql))
	{
	$id_tmp=$row["id_tmp_envio"];
	$codigo_producto=$row['codigo_producto'];
	$cantidad=$row['cantidad_producto'];
	$nombre_producto=$row['name'];
	$id_sucursal=$row['id_sucursal'];
	$sql1=$db->query("select * from sucursales where id='".$id_sucursal."'");
	while($res=$db->fetch_array($sql1)){
		$nombre_sucursal=$res['nombre_sucursal'];
	}
	
		?>
		<tr>
			<td class='text-center'><?php echo $codigo_producto;?></td>
			<td class='text-center'><?php echo $cantidad;?></td>
			<td class='text-center'><?php echo $nombre_producto;?></td>
			<td class='text-center'><?php echo $nombre_sucursal;?></td>
			<td class='text-center'><a href="#" onclick="eliminar1('<?php echo $id_tmp ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
		</tr>		
		<?php
	}
	
	

?>

</table>
</form>
