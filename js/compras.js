		$(document).ready(function(){
			load(1);
			
		});

		function load(page){
			
			 var parametros = $('#datos_cotizacion').serialize();
			
			$("#loader").fadeIn('slow');
			$.ajax({
				type:"POST",
				url:'./ajax/buscar_compras.php?page='+page,
				data: parametros,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					$('[data-toggle="tooltip"]').tooltip({html:true}); 
					
				}
			})
		}

	
		
			function eliminar (id)
		{
			var q= $("#q").val();
		if (confirm("Realmente deseas eliminar la factura")){	
		$.ajax({
        type: "GET",
        url: "./ajax/buscar_compras.php",
        data: "id="+id,"q":q,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		load(1);
		}
			});
		}
		}
		
		function imprimir_factura(id_factura){
			VentanaCentrada('ver_compra.php?id_factura='+id_factura,'Factura','','1024','768','true');
		}
