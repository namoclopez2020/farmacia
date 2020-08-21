	<?php
		require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
  
	?>	
			<!-- Modal -->
			<div class="modal fade bs-example-modal-lg" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Buscar productos para envio</h4>
				  </div>
				  <div class="modal-body">
					<form class="form-horizontal" name="datos_envio1" id="datos_envio1">
					  <div class="form-group">
						<div class="col-sm-6">
							<input type="text" name="sucursal_inicio" id="sucursal_inicio" value="<?php echo $sucursal_inicio; ?>" hidden>
						  <input type="text" class="form-control" id="q" name="q" placeholder="Buscar productos" onkeyup="load(1)">
						</div>
						<button type="button" class="btn btn-default" onclick="load(1)"><span class='glyphicon glyphicon-search'></span> Buscar</button>
					  </div>
					</form>
					<div id="loader1" style="position: absolute;	text-align: center;	top: 55px;	width: 100%;display:none;"></div><!-- Carga gif animado -->
					<div class="outer_div1" ></div><!-- Datos ajax Final -->
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					
				  </div>
				</div>
			  </div>
			</div>
	<?php
		
	?>