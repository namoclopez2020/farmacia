
		$(document).ready(function(){
			load(1);
		});

		function load(page){
			
			var parametros=$('#datos_envio1').serialize();
			$("#loader1").fadeIn('slow');
			$.ajax({
				type:"POST",
				url:'./ajax/productos_envio.php?action=ajax&page='+page,
				data:parametros,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div1").html(data).fadeIn('slow');
					$('#loader1').html('');
					
				}
			})
		}

	function agregar1 (id)
		{  
			
			var cantidad=document.getElementById('cantidad_'+id).value;
			
			//Inicia validacion
			
			
			
			//Fin validacion
			
			$.ajax({
        type: "POST",
        url: "./ajax/agregar_envio.php",
        data: "id="+id+"&cantidad="+cantidad,
		 beforeSend: function(objeto){
			$("#resultados1").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados1").html(datos);
		}
			});
		}
		
			function eliminar1 (id)
		{
			
			$.ajax({
        type: "GET",
        url: "./ajax/agregar_envio.php",
        data: "id="+id,
		 beforeSend: function(objeto){
			$("#resultados1").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados1").html(datos);
		}
			});

		}

      //al presionar el boton aceptar (submit funcion)
		
		$("#datos_envio").submit(function(){
		  
		  var id_sucursal_ultimo = $("#sucursal_ultimo").val();
		  
		  var id_sucursal_inicio = $("#sucursal_emisor").val();
		  
		  
		  
		 VentanaCentrada('reporte_envio.php?id_sucursal_ultimo='+id_sucursal_ultimo+'&id_sucursal_inicio='+id_sucursal_inicio,'Reporte de Envio','','800','600','true');
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
