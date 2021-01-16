$('.reporte').on('click', function(){
    const sucursal = $('#sucursal').val();
    const laboratorio = $('#laboratorio').val();

    let url = "prueba_pdf.php";
        url +='?suc='+sucursal;
        url +='&lab='+laboratorio;
    
        document.location.href=url;
});