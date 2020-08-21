<?php 
if(isset($_POST['categoria'])){
	$categoria=$_POST['categoria'];
}else{
	$categoria="";
}
if($categoria=='16'){ 
	//formulario para generico
	?>
<h3>Precio de compra</h3>
              <div class="form-group">
               <div class="row">
				   
				   
                
                 <div class="col-md-4">
                   <div class="input-group">
					   
                     <span class="input-group-addon">
                       <i class="glyphicon glyphicon-usd"></i>
                     </span>
                     <input type="text" class="form-control" name="buying_price" placeholder="Precio de compra" required>
                     <span class="input-group-addon">.00</span>
                  </div>
                 </div>
                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-usd"></i>
                      </span>
                      <input type="text" class="form-control" name="sale_price" placeholder="Precio de venta" required>
                      <span class="input-group-addon">.00</span>
                   </div>
                  </div>
               </div>
              </div>
  <h3>Cantidad de blisters en una caja</h3>
			   <div class="form-group">
               <div class="row">
                 <div class="col-md-5">
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                     </span>
                     <input type="text" class="form-control" name="cantidad_blister" placeholder="Cantidad de blister" >
                  </div>
                 </div>
                 
                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-usd"></i>
                      </span>
                      <input type="text" class="form-control" name="precio_blister" placeholder="Precio de blister" >
                      <span class="input-group-addon">.00</span>
                   </div>
                  </div>
               </div>
              </div>
			  
			  <h3>Cantidad de pastillas en un blister</h3>
			   <div class="form-group">
               <div class="row">
                 <div class="col-md-5">
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                     </span>
                     <input type="text" class="form-control" name="cantidad_unidad" placeholder="Cantidad de una unidades en blister" >
                  </div>
                 </div>
                 
                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-usd"></i>
                      </span>
                      <input type="text" class="form-control" name="precio_unidad" placeholder="Precio por unidad" >
                      <span class="input-group-addon">.00</span>
                   </div>
                  </div>
               </div>	
</div>
<?php 
}elseif($categoria=='17'){
	//formulario para pastilas comerciales
	?> 
<h3>Precio de compra y venta</h3>
              <div class="form-group">
               <div class="row">
				   
				
				    <div class="col-md-4">
                   <div class="input-group">
					   
                     <span class="input-group-addon">
                       <i class="glyphicon glyphicon-usd"></i>
                     </span>
                     <input type="text" class="form-control" name="buying_price" id="buying_price" placeholder="Precio de compra"  required>
                     <span class="input-group-addon">.00</span>
                  </div>
                 </div>
                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-usd"></i>
                      </span>
                      <input type="text" class="form-control" name="sale_price" id="sale_price"  placeholder="Precio de venta" required>
                      <span class="input-group-addon">.00</span>
                   </div>
                  </div>
				   </div>
              </div>
			  <div class="form-group">
				  <h2>Porcentaje de utilidad</h2>
				  <div class="row">
					  
               <div class="col-md-3">
					  <div class="input-group">
				   <span class="input-group-addon">
						  <i class="glyphicon glyphicon-usd"></i>
						  </span>
						  <input type="text" class="form-control" name="utilidad" id="utilidad" >
						  <span class="input-group-addon">%</span>
				   </div>
					  </div>
				  </div>
			  </div>
			  
			  <h3>Cantidad de blisters en una caja</h3>
			   <div class="form-group">
               <div class="row">
                 <div class="col-md-5">
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                     </span>
                     <input type="text" class="form-control" name="cantidad_blister" id="cantidad_blister" placeholder="Cantidad de blister" >
                  </div>
                 </div>
                 
                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-usd"></i>
                      </span>
                      <input type="text" class="form-control" name="precio_blister" id="precio_blister" placeholder="Precio de blister" >
                      <span class="input-group-addon">.00</span>
                   </div>
                  </div>
               </div>
              </div>
			 <h3>Cantidad de pastillas en un blister</h3>
			   <div class="form-group">
               <div class="row">
                 <div class="col-md-5">
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                     </span>
                     <input type="number" class="form-control" name="cantidad_unidad" id="cantidad_unidad"  placeholder="Cantidad de una unidades en blister" >
                  </div>
                 </div>
                 
                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-usd"></i>
                      </span>
                      <input type="float" class="form-control" name="precio_unidad" id="precio_unidad" placeholder="Precio por unidad" >
                      <span class="input-group-addon">.00</span>
                   </div>
                  </div>
               </div>
              </div>

			  
<?php 
}
else{
	?> 

<h3>Precio de compra</h3>
              <div class="form-group">
               <div class="row">
				   
				   
                 
                 <div class="col-md-4">
                   <div class="input-group">
					   
                     <span class="input-group-addon">
                       <i class="glyphicon glyphicon-usd"></i>
                     </span>
                     <input type="text" class="form-control" name="buying_price" placeholder="Precio de compra" required>
                     <span class="input-group-addon">.00</span>
                  </div>
                 </div>
				   
                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-usd"></i>
                      </span>
                      <input type="text" class="form-control" name="sale_price" placeholder="Precio de Venta Unitario" required>
                      <span class="input-group-addon">.00</span>
                   </div>
                  </div>
               </div>
              </div>

<?php 
	
}
?>