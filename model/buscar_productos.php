	<?php
		require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
  //$products = join_product_table();
	?>	
			<!-- Modal -->
			<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Buscar productos</h4>
				  </div>
				  <div class="modal-body">
					<form class="form-horizontal" name="nueva_factura" id="nueva_factura">
					  <div class="form-group">
						<div class="col-sm-6">
						  <input type="text" class="form-control" id="q" name="q" placeholder="Buscar productos" onkeyup="load(1)">
							<input type="text" id="ajax" name="ajax"  value="ajax" hidden>
						</div>
						<button type="button" class="btn btn-default" onclick="load(1)"><span class='glyphicon glyphicon-search'></span> Buscar</button>
					<div class="col-sm-4">
						 <select class="form-control" name="sucursal" id="sucursal" onChange="load(1)">
                      <option value="">Selecciona una sucursal</option>
                    <?php  foreach ($all_sucursal as $suc): ?>
                      <option value="<?php echo $suc['id'] ?>">
                        <?php echo $suc['nombre_sucursal'] ?></option>
                    <?php endforeach; ?>
                    </select>
					</div>
					  </div>
						
					</form>
					<div id="loader" style="position: absolute;	text-align: center;	top: 55px;	width: 100%;display:none;"></div><!-- Carga gif animado -->
					<div class="outer_div" ></div><!-- Datos ajax Final -->
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					
				  </div>
				</div>
			  </div>
			</div>
	<?php
		
	?>