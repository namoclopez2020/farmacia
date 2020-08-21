		$(document).ready(function(){
			load(1);
			
		});

		function load(page){
			var start=$("#start").val();
			var end=$("#end").val();
			var mov=$('#mov').find(":selected").val();
			var prod=$('#producto').val();
			$("#loader4").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_movimientos.php?action=ajax&page='+page+'&start='+start+'&end='+end+'&mov='+mov+'&prod='+prod,
				 beforeSend: function(objeto){
				 $('#loader4').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div4").html(data).fadeIn('slow');
					$('#loader4').html('');
					$('[data-toggle="tooltip"]').tooltip({html:true}); 
					
				}
			})
		}

	
		
			