		$(document).ready(function(){
			load(1);
			
		});

		function load(page){
			let start=$("#start").val();
			let end=$("#end").val();
			let mov=$('#mov').find(":selected").val();
			let prod=$('#producto').val();
			let user = $('#user').val();
			$("#loader4").fadeIn('slow');

			let datos = {
				page : page,
				start : start,
				end : end,
				mov : mov,
				prod: prod,
				action : 'ajax',
				user : user
			};
			
			$.ajax({
				url : './ajax/buscar_movimientos.php',
				data : datos,
				// url:'./ajax/buscar_movimientos.php?action=ajax&page='+page+'&start='+start+'&end='+end+'&mov='+mov+'&prod='+prod,
				beforeSend: function(objeto){
					$('#loader4').html('<img src="./libs/images/loader.gif"> Cargando...');
				},
				success:function(data){
					$(".outer_div4").html(data).fadeIn('slow');
					$('#loader4').html('');
					$('[data-toggle="tooltip"]').tooltip({html:true});
					
				}
			})
		}

	
		
			