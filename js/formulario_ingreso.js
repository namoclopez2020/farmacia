$(document).ready(function(){
  $("#buying_price").change(function(){
    alert("The text has been changed.");
  });
});
	$('#resultados').on('change', '.form-control', function(){
		$("#utilidad").val('');
		var costo= $('#buying_price').val();
		var precio=$('#sale_price').val();
		var porcentaje=((parseFloat(precio)-parseFloat(costo))/parseFloat(costo))*100;
		
	 $("#utilidad").val(porcentaje);
		var blister=$('#cantidad_blister').val();
		var precio_blister=parseFloat(precio)/parseFloat(blister);
		$('#precio_blister').val(precio_blister);
		
		var unidad=$('#cantidad_unidad').val();
		var precio_unidad=parseFloat(precio_blister)/parseFloat(unidad);
        $('#precio_unidad').val(precio_unidad);
});


		function load(){
			var categoria=$('#categoria').find(":selected").val();
			$("#loader2").fadeIn('slow');
			$.ajax({
				type:"POST",
				url:'./ajax/formulario_ingreso.php',
				data:"categoria="+categoria,
				 beforeSend: function(objeto){
			$(".resultados").html("Mensaje: Cargando...");
			  },
				success:function(data){
					$(".resultados").html(data);
					
					
					
				}
			})
		}

	
	function agregar (id)
		{
			var precio_venta=document.getElementById('precio_venta_'+id).value;
			var cantidad=document.getElementById('cantidad_'+id).value;
			
			//Inicia validacion
			
			
			if (isNaN(precio_venta))
			{
			alert('Esto no es un numero');
			document.getElementById('precio_venta_'+id).focus();
			return false;
			}
			//Fin validacion
			
			$.ajax({
        type: "POST",
        url: "./ajax/agregar_facturacion.php",
        data: "id="+id+"&precio_venta="+precio_venta+"&cantidad="+cantidad,
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
        url: "./ajax/agregar_facturacion.php",
        data: "id="+id,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		}
			});

		}
		$( "#agregar_productos" ).submit(function( event ) {
		
		  
		 var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "ajax/agregar_nuevo_producto.php",
					data: parametros,
					 beforeSend: function(objeto){
					//	$("#resultados_ajax_productos").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					//location.reload();
				  }
			});
		//  event.preventDefault();
		})
	
		
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
