<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Prueba</title>
    <style>
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #5D6975;
            text-decoration: underline;
        }

        body {
            position: relative;
            width: 19cm;  
            height: 31cm; 
            margin: 0 auto; 
            color: #001028;
            background: #FFFFFF; 
            font-family: Arial, sans-serif; 
            font-size: 12px; 
            font-family: Arial;
        }

        header {
            padding: 10px 0;
            margin-bottom: 30px;
        }

        #logo {
            text-align: center;
            margin-bottom: 10px;
        }

        #logo img {
            width: 90px;
        }

        h1 {
            border-top: 1px solid  #5D6975;
            border-bottom: 1px solid  #5D6975;
            color: #5D6975;
            font-size: 2.4em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: center;
            margin: 0 0 20px 0;
            background: url(img/pdf/dimension.png);
        }

        #project {
            float: left;
        }

        #project span {
            color: #5D6975;
            text-align: right;
            width: 80px;
            margin-right: 0px;
            display: inline-block;
            font-size: 0.8em;
        }

        #company {
            float: right;
            text-align: right;
        }

        #project div,
        #company div {
            white-space: nowrap;        
        }

        table {
            /* width: 80%; */
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
            
        }

        table tr:nth-child(2n-1) td {
            background: #F5F5F5;
        }

        table th {
            padding: 5px 20px;
            color: #5D6975;
            border-bottom: 1px solid #C1CED9;
            white-space: nowrap;        
            font-weight: normal;
        }

        table td {
            padding: 5px;
            text-align: right;
        }

        table td.numero {
            text-align: center;
            /*vertical-align: center;*/
        }

        table td.insumo {
            text-align: left;
            /*vertical-align: top;*/
        }

        table th.qty td.qty {
            font-size: 1.2em;
            width: 3cm;
        }

        table td.unit {
            font-size: 1.2em;
        }

        #notices .notice {
            color: #5D6975;
            font-size: 1.2em;
        }

        footer {
            color: #5D6975;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #C1CED9;
            padding: 8px 0;
            text-align: center;
        }
    </style>
</head>
<body> 
 <?php  
 ?> 
  <div style="font-family: Arial, Agency FB, verdana, helvetica, sans-serif;">
    <h1>Reporte de Inventario</h1>
    <table class="clearfix" id="project" style="width:50%">
      <tr>
          <td><span>Local:</span> Alifarma </td>
      </tr>
    </table>
    <br>
    <br>
      <p style="text-align: center;align-content: center;font-weight: normal;" class="h3">*** Lista de productos ***</p>
      <table style="width:100%;border-top: 1px solid black;border-collapse: collapse;">
        <thead style="font-size: 14px;">
          <tr>
            <th style="text-align:center;align-content:center;width:50%">Cant</th>
            <th style="text-align:center;align-content:center;width:50%">Descripción</th>
          </tr>
        </thead>
        <tbody style="font-size: 12px;">
            
            <?php foreach($products as $value) { ?>   
                <tr>
                    <td style="text-align:center;align-content:center;"> <?php echo $value['quantity'];?></td>
                    <td style="text-align:center;align-content:center;"><?php echo $value['name'];?></td>
                </tr>
            <?php } ?>
            
        </tbody>
      </table>
    <p style="text-align: center;align-content: center;font-weight: normal;">Tecnek Box Reportes</p></div>
</body>
</html>