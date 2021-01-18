     </div>
    </div>
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="libs/js/functions.js"></script>
    <script language="javascript">
      
      function porcentaje() { 

        var compra = parseFloat(document.formcalcular.buying_price.value); 
        var venta =parseFloat(document.formcalcular.sale_price.value); 
        var porcentaje=((venta-compra)/compra)*100;

        document.formcalcular.utilidad.value=(porcentaje).toFixed(0); 


      }
        
      function blister(){
        
        var sale_price=parseFloat(document.formcalcular.sale_price.value);
        var cantidad_blister=parseFloat(document.formcalcular.cantidad_blister.value);
        var blister=sale_price/cantidad_blister;

        document.formcalcular.precio_blister.value=(blister).toFixed(2);
      }
        
      function unidad(){
        var precio_blister=parseFloat(document.formcalcular.precio_blister.value);
        var cantidad_unidad=parseFloat(document.formcalcular.cantidad_unidad.value);
        var unidad=precio_blister/cantidad_unidad;
          
        document.formcalcular.precio_unidad.value=(unidad).toFixed(2);
      }
      $('#table').DataTable();
    </script>
  </body>
</html>

<?php if(isset($db)) { $db->db_disconnect(); } ?>
