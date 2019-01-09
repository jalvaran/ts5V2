/**
 * Controlador para generar los reportes contables
 * JULIAN ALVARAN 2019-01-08
 * TECHNO SOLUCIONES SAS 
 * 317 774 0609
 */


/*
 * Envía una solicitud
 * @returns {undefined}
 */
function GenereReporte(){
    var Reporte = document.getElementById('CmbReporteContable').value;
    var CmbTipo = document.getElementById('CmbTipo').value;
    var TxtFechaInicial = document.getElementById('TxtFechaInicial').value;
    var TxtFechaFinal = document.getElementById('TxtFechaFinal').value;
    var CmbCentroCosto = document.getElementById('CmbCentroCosto').value;
    var CmbEmpresa = document.getElementById('CmbEmpresa').value;
    
    if(Reporte==""){
        alertify.alert("Debe seleccionar un Reporte");
        document.getElementById('CmbReporteContable').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('CmbReporteContable').style.backgroundColor="white";
    }
    
        
    if(TxtFechaInicial==""){
        alertify.alert("Debe seleccionar una fecha inicial");
        document.getElementById('TxtFechaInicial').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('TxtFechaInicial').style.backgroundColor="white";
    }
    
    if(TxtFechaFinal==""){
        alertify.alert("Debe seleccionar una fecha final");
        document.getElementById('TxtFechaFinal').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('TxtFechaFinal').style.backgroundColor="white";
    }
    
    if(CmbCentroCosto==""){
        alertify.alert("Debe seleccionar un Centro de costos");
        document.getElementById('CmbCentroCosto').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('CmbCentroCosto').style.backgroundColor="white";
    }
    
    if(CmbEmpresa==""){
        alertify.alert("Debe seleccionar una  Empresa");
        document.getElementById('CmbEmpresa').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('CmbEmpresa').style.backgroundColor="white";
    }
    
    
    var form_data = new FormData();
        form_data.append('Accion', 1);
        form_data.append('Reporte', Reporte);
        form_data.append('CmbTipo', CmbTipo);
        form_data.append('TxtFechaInicial', TxtFechaInicial);
        form_data.append('TxtFechaFinal', TxtFechaFinal);
        form_data.append('CmbCentroCosto', CmbCentroCosto);
        form_data.append('CmbEmpresa', CmbEmpresa);
        
        $.ajax({
        url: './Consultas/ReportesContables.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
           
          if (data == "OKBXT") { 
              SeleccioneTablaDB("vista_balancextercero2","DivReportesContables","DivOpcionesReportes");              
          }else{
              document.getElementById("DivOpcionesReportes").innerHTML="";
              document.getElementById("DivReportesContables").innerHTML=data;
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })        
}  
