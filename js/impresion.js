$('.reporte').on('click', function(){
    const sucursal = $('#sucursal').val();
    const laboratorio = $('#laboratorio').val();

    if(sucursal == ''){
        alert('Debe elegir una sucursal');
        return false;
    }

    let url = "prueba_pdf.php";
        url +='?suc='+sucursal;
        url +='&lab='+laboratorio;
    
        document.location.href=url;
});