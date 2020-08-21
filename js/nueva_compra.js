
		$(document).ready(function(){
			load(1);
		});

		function load(page){
			 var parametros = $('#comprar').serialize(); 
			
			$("#loader").fadeIn('slow');
			$.ajax({
				type:"POST",
				url:'./ajax/productos_compra.php?action=ajax&page='+page,
				data: parametros,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div3").html(data).fadeIn('slow');
					$('#loader3').html('');
					
				}
			})
		}

	function agregar (id)
		{
			var costo_prod=document.getElementById('costo_prod_'+id).value;
			var cantidad=document.getElementById('cantidad_'+id).value;
			
			//Inicia validacion
			
			
			if (isNaN(costo_prod))
			{
			alert('el campo costo esta vacio');
			document.getElementById('costo_prod_'+id).focus();
			return false;
			}
			//Fin validacion
			
			$.ajax({
        type: "POST",
        url: "./ajax/agregar_compra.php",
        data: "id="+id+"&costo_prod="+costo_prod+"&cantidad="+cantidad,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		}
			});
		}
		
			function eliminar (id)
		{
			
			$.ajax({
        type: "GET",
        url: "./ajax/agregar_compra.php",
        data: "id="+id,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		}
			});

		}
		
		$("#datos_factura").submit(function(){
		  var id_proveedor = $("#id_proveedor").val();
		  var id_vendedor = $("#id_vendedor").val();
		  var condiciones = $("#condiciones").val();
		  var fecha=$("#fecha").val();
		  
		  if (id_proveedor==""){
			 alert("Debes seleccionar un proveedor");
			  $("#nombre_proveedor").focus();
			 return false;
		  }
			if(fecha==""){
				alert("seleccione una fecha válida");
				$("#fecha").focus();
				return false;
			}
			
		 VentanaCentrada('comprobante_compra_interno.php?id_prov='+id_proveedor+'&id_vendedor='+id_vendedor+'&condiciones='+condiciones+'&fecha='+fecha,'Factura','','800','600','true');
		
	 	});
		
		$( "#guardar_cliente" ).submit(function( event ) {
		  $('#guardar_datos').attr("disabled", true);
		  
		 var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "ajax/nuevo_cliente.php",
					data: parametros,
					 beforeSend: function(objeto){
						$("#resultados_ajax").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$("#resultados_ajax").html(datos);
					$('#guardar_datos').attr("disabled", false);
					load(1);
				  }
			});
		  event.preventDefault();
		})
		
		$( "#guardar_producto" ).submit(function( event ) {
		  $('#guardar_datos').attr("disabled", true);
		  
		 var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "ajax/nuevo_producto.php",
					data: parametros,
					 beforeSend: function(objeto){
						$("#resultados_ajax_productos").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$("#resultados_ajax_productos").html(datos);
					$('#guardar_datos').attr("disabled", false);
					load(1);
				  }
			});
		  event.preventDefault();
		})
