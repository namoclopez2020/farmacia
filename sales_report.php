<?php
$page_title = 'Reporte de ventas';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
$all_vendedores=find_all('users');
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="panel">
      <div class="panel-heading">

      </div>
      <div class="panel-body">
          <form class="clearfix" method="post" action="sale_report_process.php">
            <div class="form-group">
              <label class="form-label">Rango de fechas</label>
                <div class="input-group">
                  <input type="text" class="datepicker form-control" name="start-date" placeholder="Desde" autocomplete="off">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                  <input type="text" class="datepicker form-control" name="end-date" placeholder="Hasta" autocomplete="off">
                </div>
            </div>
			  <label class="col-md-2 control-label">Vendedor</label>
	<div class="form-group">
				 <select class="form-control" name="ven" >
                      <option value="">Selecciona un vendedor</option>
                   	 <?php  foreach ($all_vendedores as $ven): ?>
                      <option value="<?php echo $ven['id'] ?>">
                        <?php echo $ven['name'] ?></option>
                   		 <?php endforeach; ?>
                  </select>
	</div>
            <div class="form-group">
                 <button type="submit" name="submit" class="btn btn-primary">Generar Reporte</button>
            </div>
          </form>
      </div>

    </div>
  </div>

</div>
<?php include_once('layouts/footer.php'); ?>
