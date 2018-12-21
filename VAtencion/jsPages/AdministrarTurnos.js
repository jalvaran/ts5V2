$('#TxtValor').keypress(function(e) {
    var keycode = (e.keyCode ? e.keyCode : e.which);
    if (keycode == '13') {
        RegistrarTurno();
        e.preventDefault();
        return false;
    }
});
$('#idTercero').select2({		  
    placeholder: 'Selecciona un Tercero',
    ajax: {
      url: './buscadores/proveedores.php',
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
          console.log(data)
        return {
          results: data
        };
      },
      cache: true
    }
});
function ModalCliente(){
    document.getElementById('BtnAbreModal').click();
    var form_data = new FormData();
        form_data.append('idAccion', 1);
        
        $.ajax({
        url: './Consultas/CuadroDialogoCrearCliente.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
          if (data != "") { 
                document.getElementById('DivModalTurnos').innerHTML=data;              
                $('#CmbCodMunicipio').select2(); 
          }else {
            alert("No hay resultados para la consulta");
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })     
}

function CrearTercero(){
    
    var form_data = new FormData();
        form_data.append('CmbTipoDocumento', $('#CmbTipoDocumento').val())
        form_data.append('TxtNIT', $('#TxtNIT').val())
        form_data.append('TxtPA', $('#TxtPA').val()) 
        form_data.append('TxtSA', $('#TxtSA').val())
        form_data.append('TxtPN', $('#TxtPN').val())
        form_data.append('TxtON', $('#TxtON').val())
        form_data.append('TxtRazonSocial', $('#TxtRazonSocial').val()) 
        form_data.append('TxtDireccion', $('#TxtDireccion').val())
        form_data.append('TxtTelefono', $('#TxtTelefono').val()) 
        form_data.append('TxtEmail', $('#TxtEmail').val())
        form_data.append('TxtCupo', $('#TxtCupo').val()) 
        form_data.append('CmbCodMunicipio', $('#CmbCodMunicipio').val())
        TxtPN
        $.ajax({
        url: './Consultas/CrearTercero.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
          if (data !== "") { 
              
              alertify.alert(data);
          }else {
              alertify.error("No hay resultados para la consulta");
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })     
}


function CrearNombreCompleto() {
   
    var campo1=document.getElementById('TxtPA').value;
    var campo2=document.getElementById('TxtSA').value;
    var campo3=document.getElementById('TxtPN').value;
    var campo4=document.getElementById('TxtON').value;
	

    var Razon=campo3+" "+campo4+" "+campo1+" "+campo2;

    document.getElementById('TxtRazonSocial').value=Razon;


}

function RegistrarTurno(){
    var Fecha = document.getElementById('Fecha').value;
    var idSede = document.getElementById('idSede').value;
    var idTercero = document.getElementById('idTercero').value;
    var TxtValor = document.getElementById('TxtValor').value;
    
    if(Fecha==''){
        alertify.alert("Debe seleccionar Fecha");        
        document.getElementById('Fecha').style.backgroundColor="pink";
        return;
    }else{        
        document.getElementById('Fecha').style.backgroundColor="";
    }
    
    
    if(idSede==''){
        alertify.alert("Debe seleccionar una sede");        
        document.getElementById('idSede').style.backgroundColor="pink";
        return;
    }else{        
        document.getElementById('idSede').style.backgroundColor="";
    }
    
    if(idTercero==''){
        alertify.alert("Debe seleccionar un tercero");        
        document.getElementById('select2-idTercero-container').style.backgroundColor="pink";
        return;
    }else{        
        document.getElementById('select2-idTercero-container').style.backgroundColor="";
    }
    
    
    if(isNaN(TxtValor) || TxtValor==0){
        alertify.alert("El valor del turno digitado No es un número o es Cero, por favor digite un número válido");
        document.getElementById('TxtValor').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('TxtValor').style.backgroundColor="white";
    }
    document.getElementById('idTercero').value=''; 
    document.getElementById('select2-idTercero-container').innerHTML="Seleccionar Tercero";
    var form_data = new FormData();
        form_data.append('Fecha', Fecha)  
        form_data.append('idSede', idSede)       
        form_data.append('idTercero', idTercero)
        form_data.append('TxtValor', TxtValor)
        form_data.append('idAccion', 1)
        $.ajax({
        url: 'procesadores/AdministrarTurnos.process.php',
        //dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
            //console.log(data);
            if(data=='OK'){
                alertify.success("Turno Agregado");    
                document.getElementById('DivMensajes').innerHTML="";                
                DibujeTurnos();                
            }else{
                alertify.error("Error al tratar de agregar el turno");
                document.getElementById('DivMensajes').innerHTML=data;
            }
           
            
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
}

function DibujeTurnos(Filtros=0){
    var FechaInicial="";
    var FechaFinal="";
    var Sucursal="";
    var Tercero="";
    var Separador = document.getElementById('Separador').value;
    if (Filtros==1) {
         FechaInicial = document.getElementById('FiltroFechaInicial').value;
         FechaFinal = document.getElementById('FiltroFechaFinal').value;
         Tercero = document.getElementById('FiltroTercero').value;
         Sucursal = document.getElementById('FiltroidSede').value;
    }
    var form_data = new FormData();             
        form_data.append('FechaInicial', FechaInicial)
        form_data.append('FechaFinal', FechaFinal)
        form_data.append('Tercero', Tercero)
        form_data.append('Sucursal', Sucursal)
        form_data.append('Separador', Separador)
        form_data.append('idAccion', 2)
        $.ajax({
        url: 'procesadores/AdministrarTurnos.process.php',
        //dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
            document.getElementById('DivHistorialTurnos').innerHTML =data;   
            $('#FiltroTercero').select2({		  
            placeholder: 'Buscar X Tercero',
            ajax: {
              url: './buscadores/proveedores.php',
              dataType: 'json',
              delay: 250,
              processResults: function (data) {
                  console.log(data)
                return {
                  results: data
                };
              },
              cache: true
            }
        });
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
}

function EditarValor(idItem){
    
    var idCajaValor = "TxtValor"+idItem;
    var Valor = document.getElementById(idCajaValor).value;
    if(isNaN(Valor) || Valor<=0){
        alertify.alert("El valor del turno digitado No es un número o es Cero, por favor digite un número válido");
        document.getElementById(idCajaValor).style.backgroundColor="pink";
        return;
    }else{
        document.getElementById(idCajaValor).style.backgroundColor="white";
    }
    var form_data = new FormData();             
        form_data.append('Valor', Valor)
        form_data.append('idItem', idItem)
        form_data.append('idAccion', 3)
        $.ajax({
        url: 'procesadores/AdministrarTurnos.process.php',
        //dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
            if(data=='OK'){
                alertify.success("Valor editado");    
                document.getElementById('DivMensajes').innerHTML="";                
                document.getElementById('BtnActualizarTurnos').click();           
            }else{
                alertify.error("Error al tratar de editar el turno");
                document.getElementById('DivMensajes').innerHTML=data;
            }
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
}

function EliminarItem(idItem){
    
    
    var form_data = new FormData();             
        form_data.append('idItem', idItem)
        form_data.append('idAccion', 4)
        $.ajax({
        url: 'procesadores/AdministrarTurnos.process.php',
        //dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
            if(data=='OK'){
                alertify.error("Registro eliminado");    
                document.getElementById('DivMensajes').innerHTML="";                
                document.getElementById('BtnActualizarTurnos').click();                   
            }else{
                alertify.error("Error al tratar de eliminar el turno");
                document.getElementById('DivMensajes').innerHTML=data;
            }
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
}

function LimpiarFiltros() {
   
    document.getElementById('FiltroFechaInicial').value='';
    document.getElementById('FiltroFechaFinal').value='';
    document.getElementById('FiltroidSede').value='';
    document.getElementById('select2-FiltroTercero-container').innerHTML='Buscar X Tercero';
    document.getElementById('FiltroTercero').value='';
    document.getElementById('BtnFiltrar').click();
    
}

function ModalLiquidarTurnos(){
    
    document.getElementById('BtnAbreModal').click();
    var form_data = new FormData();             
        
        form_data.append('idAccion', 5)
        $.ajax({
        url: 'procesadores/AdministrarTurnos.process.php',
        //dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
            if(data!=''){
                document.getElementById('DivModalTurnos').innerHTML=data;                  
            }else{
                alertify.error("Error al tratar de abrir las opciones de liquidacion");
                document.getElementById('DivMensajes').innerHTML=data;
            }
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
}

function LiquidarTurnos(Limpiar=1){
    var FechaLiquidacion = document.getElementById('TxtFechaLiquidacion').value;    
    var ReteICA = document.getElementById('CmbReteICA').value;
    var ReteFuente = document.getElementById('CmbReteFuente').value;
    var Concepto = document.getElementById('TxtConceptoLiquidacion').value;
    
    var FechaInicial = document.getElementById('FiltroFechaInicial').value;
    var FechaFinal = document.getElementById('FiltroFechaFinal').value;
    var Tercero = document.getElementById('FiltroTercero').value;
    var Sucursal = document.getElementById('FiltroidSede').value;
    var CuentaOrigen = document.getElementById('CmbCuentaOrigen').value;
    
    if(FechaLiquidacion==''){
        alertify.alert("Debe seleccionar Fecha para la liquidación");        
        document.getElementById('TxtFechaLiquidacion').style.backgroundColor="pink";
        return;
    }else{        
        document.getElementById('TxtFechaLiquidacion').style.backgroundColor="";
    }
    
    if(Concepto==''){
        alertify.alert("Debe escribir un concepto para la liquidación");        
        document.getElementById('TxtConceptoLiquidacion').style.backgroundColor="pink";
        return;
    }else{        
        document.getElementById('TxtConceptoLiquidacion').style.backgroundColor="";
    }
    
    document.getElementById("BtnAgregar").disabled=true;
    document.getElementById("BtnFiltrar").disabled=true;
    document.getElementById("TxtValor").disabled=true;
    document.getElementById('BtnCierreModal').click();
    document.getElementById("DivMensajes").innerHTML='<div id="DivProcesando">Liquidando Turnos...<br>por favor espere<br><img   src="../images/process.gif" alt="Cargando" height="100" width="100"></div>';
    if(Limpiar==1){
        document.getElementById('DivHistorialTurnos').innerHTML="";   
    }
    
    var form_data = new FormData();        
        form_data.append('idAccion', 6)
        form_data.append('FechaLiquidacion', FechaLiquidacion)
        form_data.append('ReteICA', ReteICA)
        form_data.append('ReteFuente', ReteFuente)
        form_data.append('Concepto', Concepto)
        form_data.append('FechaInicial', FechaInicial)
        form_data.append('FechaFinal', FechaFinal)
        form_data.append('Tercero', Tercero)
        form_data.append('Sucursal', Sucursal)
        form_data.append('CuentaOrigen', CuentaOrigen)
        
        $.ajax({
        url: 'procesadores/AdministrarTurnos.process.php',
        //dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
            //console.log(data);
            var respuestas = data.split(';');
            
            if(respuestas[0]=="OK"){
                
                var Porcentaje = respuestas[1];
                var msg = respuestas[2];
                $('.progress-bar').css('width',Porcentaje+'%').attr('aria-valuenow', Porcentaje);  
                document.getElementById('LyProgresoCMG').innerHTML=Porcentaje+"%";
                
                document.getElementById('DivHistorialTurnos').innerHTML=msg+"<br>"+document.getElementById('DivHistorialTurnos').innerHTML;
                 
                if(Porcentaje==100){
                    document.getElementById("BtnAgregar").disabled=false;
                    document.getElementById("BtnFiltrar").disabled=false;
                    document.getElementById("TxtValor").disabled=false;
                    document.getElementById("DivProcesando").innerHTML="Proceso terminado exitósamente";
                    alertify.success("Proceso Terminado Exitósamente");  
                    return;
                }
                if(Porcentaje<100){
                    LiquidarTurnos(0);
                }
             
            }else{
                $('.progress-bar').css('width','0%').attr('aria-valuenow', 0);  
                document.getElementById('LyProgresoCMG').innerHTML="0%";
                
                document.getElementById("BtnAgregar").disabled=false;
                document.getElementById("BtnFiltrar").disabled=false;
                document.getElementById("TxtValor").disabled=false;
                alertify.error("Error al tratar de realizar la liquidacion");
                document.getElementById("DivProcesando").innerHTML="Error: ";
                document.getElementById('DivMensajes').innerHTML=data;
            }
             
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
      
}