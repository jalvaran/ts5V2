/**
 * Controlador para realizar los reportes dde facturas electronicas, contabilizacion y descarga de inventarios de facturas
 * JULIAN ALVARAN 2019-01-10
 * TECHNO SOLUCIONES SAS 
 * 317 774 0609
 */

/**
 * Se encarga de crear las tablas en el servidor externo
 * @returns {undefined}
 */
function ContabilizarFacturas(){
       
    var form_data = new FormData();
        form_data.append('idAccion', 1);
        
        $.ajax({
        url: '../../general/procesadores/ProcesosConFacturas.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
           // console.log(data);
          var respuestas = data.split(';'); 
          if (respuestas[0] == "OK") { 
              
                var Mensaje=respuestas[1];
                if(Mensaje!=''){
                    document.getElementById('DivMensajesContabilizacionFacturas').innerHTML=Mensaje;                
                }
                setTimeout('ContabilizarFacturas()',30*1000);
          }else {
                document.getElementById('DivErroresContabilizacionFacturas').innerHTML=data; 
                setTimeout('ContabilizarFacturas()',30*1000);
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })        
}  
/**
 * 
 * @returns {undefined}
 */
function VerificaRegistrosXRespaldar(){
     
    document.getElementById('hTituloBackCreacionTablas').innerHTML="Buscando Registros por respaldar";
    $('#prBackCreacionTablas').css('width','0%');
    document.getElementById('prBackCreacionTablas').innerHTML="0%";
    var form_data = new FormData();
        form_data.append('idAccion', 3);        
        $.ajax({
        url: '../../general/procesadores/backup.process.php',
        async: true,
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
          var respuestas = data.split(';'); 
          if (respuestas[0] == "OK") { 
                
                var TotalRegistros=respuestas[1];
                var Tablas=JSON.parse(respuestas[2]);        
                var TotalTablas=Object.keys(Tablas).length;
                if(TotalRegistros>0){
                    BackupTabla(Tablas,0,TotalTablas,TotalRegistros);                    
                }else{
                    document.getElementById('hTituloBackCreacionTablas').innerHTML="No hay registros por respaldar";
                    setTimeout('VerificaRegistrosXRespaldar()',60*1000);
                }          
          }else {
                document.getElementById('hTituloBackCreacionTablas').innerHTML=data;
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alertify.alert("Error al tratar de buscar los datos a respaldar "+xhr.status+" "+thrownError);
            
          }
      })        
}  
/**
 * inicia el respaldo de las tablas
 * @param {type} Tablas
 * @param {type} TotalRegistros
 * @returns {undefined}
 */
function BackupTabla(Tablas,IndiceTabla,TotalTablas,TotalRegistros){
    if(IndiceTabla>=TotalTablas){
      VerificaRegistrosXRespaldar();
      return;
    }
    var tabla=Tablas[IndiceTabla]["Nombre"];
    
    var TotalRegistrosTabla=Tablas[IndiceTabla]["Registros"];
    //console.log(tabla+" "+TotalRegistrosTabla);
    document.getElementById('hTituloBackCreacionTablas').innerHTML="Backup a tabla "+tabla;
          
    var form_data = new FormData();
        form_data.append('idAccion', 4); 
        form_data.append('tabla', tabla); 
        $.ajax({
        url: '../../general/procesadores/backup.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
          var respuestas = data.split(';'); 
          //console.log(data);
          if (respuestas[0] == "OK") { 
                var RegistrosFaltantes=respuestas[1];
                var RegistrosCreados=TotalRegistrosTabla-RegistrosFaltantes;                
                var porcentaje=Math.round((100/TotalRegistrosTabla)*RegistrosCreados);
                $('#prBackCreacionTablas').css('width',porcentaje+'%');
                document.getElementById('prBackCreacionTablas').innerHTML=porcentaje+"%";  
                if(RegistrosCreados>=TotalRegistrosTabla){
                    IndiceTabla++;
                    BackupTabla(Tablas,IndiceTabla,TotalTablas,TotalRegistros);
                    
                }else if(RegistrosFaltantes > 0){
                    BackupTabla(Tablas,IndiceTabla,TotalTablas,TotalRegistros);
                }
          }else {
                IndiceTabla++;
                BackupTabla(Tablas,IndiceTabla,TotalTablas,TotalRegistros);
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alertify.alert("Error al tratar de buscar los datos a respaldar "+xhr.status+" "+thrownError);
          }
      })   
    
}


ContabilizarFacturas();
//VerificaRegistrosXRespaldar();