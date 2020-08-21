<?php
require_once('../../includes/load.php');
if (isset($_GET['term'])){

//include("../../config/conexion.php");
$return_arr = array();
/* If connection to database, run sql statement. */
	
if ($db->con())
{
	
	$fetch = $db->query("SELECT * FROM proveedores where nom_empresa like '%" . $db->escape(($_GET['term'])) . "%' LIMIT 0 ,50"); 
	
	/* Retrieve and store in array the results of the query.*/
	while ($row =$db->fetch_array($fetch)) {
		$id_proveedor=$row['id_prov'];
		$row_array['value'] = $row['nom_empresa'];
		$row_array['id_proveedor']=$id_proveedor;
		$row_array['nombre_empresa']=$row['nom_empresa'];
		$row_array['telefono_proveedor']=$row['telef_prov'];
		$row_array['ruc']=$row['ruc_proveedor'];
		array_push($return_arr,$row_array);
    }
	
}

/* Free connection resources. */
$db->db_disconnect();

/* Toss back results as json encoded array. */
echo json_encode($return_arr);

}
?>