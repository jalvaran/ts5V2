
$('#idCliente').select2({

placeholder: 'Buscar Cliente',
ajax: {
  url: './buscadores/clientes.php',
  dataType: 'json',
  delay: 250,
  processResults: function (data) {
    return {
      results: data
    };
  },
  cache: true
}
});



$('#idServicio').select2({

placeholder: 'Buscar Servicio',
ajax: {
  url: './buscadores/servicios.search.php',
  dataType: 'json',
  delay: 250,
  processResults: function (data) {
    return {
      results: data
    };
  },
  cache: true
}
});

$('#idProducto').select2({

placeholder: 'Buscar Producto ',
ajax: {
  url: './buscadores/productosventa.php',
  dataType: 'json',
  delay: 250,
  processResults: function (data) {
    return {
      results: data
    };
  },
  cache: true
}
});
            
/**
 * Agrega un item a un traslado desde un codigo de barras
 */
function AgregaServicio(){
    
    var idServicio = document.getElementById('idServicio').value;
    var idFacturaActiva = document.getElementById('idFacturaActiva').value;
    if(idFacturaActiva==''){
        alertify.alert("Debe seleccionar una factura para agregar este item");
        return;
    }
    if(idServicio==''){
        alertify.alert("Debe seleccionar un servicio para agregar");
        
        document.getElementById('select2-idServicio-container').style.backgroundColor="pink";
        return;
    }else{
        
        document.getElementById('select2-idServicio-container').style.backgroundColor="";
    }
   
    var Cantidad = parseFloat(document.getElementById('TxtCantidadServicio').value);
    if(isNaN(Cantidad) ){
        alertify.alert("La cantidad digitada No es un número, por favor digite un número válido");
        document.getElementById('TxtCantidadServicio').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('TxtCantidadServicio').style.backgroundColor="white";
    }
    
    
    
    var form_data = new FormData();
        form_data.append('idFacturaFrecuente', idFacturaActiva)  
        form_data.append('idServicio', idServicio)       
        form_data.append('Cantidad', Cantidad)
        
        form_data.append('idAccion', 1)
        $.ajax({
        url: 'procesadores/FacturaFrecuente.process.php',
        //dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
            //console.log(data);
            if(data=='OK'){
                alertify.success("Item Agregado");    
                document.getElementById('DivMensajes').innerHTML='';                
                DibujeItemsFactura();                
            }else{
                alertify.error("Error al tratar de agregar el item");
                document.getElementById('DivMensajes').innerHTML=data;
            }
           
            
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
}


/**
 * Agrega un producto a una factura
 */
function AgregaProducto(){
    
    var idProducto = document.getElementById('idProducto').value;
    var idFacturaActiva = document.getElementById('idFacturaActiva').value;
    if(idFacturaActiva==''){
        alertify.alert("Debe seleccionar una factura para agregar este item");
        return;
    }
    if(idProducto==''){
        alertify.alert("Debe seleccionar un producto para agregar");
        
        document.getElementById('select2-idProducto-container').style.backgroundColor="pink";
        return;
    }else{
        
        document.getElementById('select2-idProducto-container').style.backgroundColor="";
    }
   
    var Cantidad = parseFloat(document.getElementById('TxtCantidadProducto').value);
    if(isNaN(Cantidad) ){
        alertify.alert("La cantidad digitada No es un número, por favor digite un número válido");
        document.getElementById('TxtCantidadProducto').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('TxtCantidadProducto').style.backgroundColor="white";
    }
    
    
    
    var form_data = new FormData();
        form_data.append('idFacturaFrecuente', idFacturaActiva)  
        form_data.append('idProducto', idProducto)       
        form_data.append('Cantidad', Cantidad)
        
        form_data.append('idAccion', 4)
        $.ajax({
        url: 'procesadores/FacturaFrecuente.process.php',
        //dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
            //console.log(data);
            if(data=='OK'){
                alertify.success("Item Agregado");    
                document.getElementById('DivMensajes').innerHTML='';                
                DibujeItemsFactura();                
            }else{
                alertify.error("Error al tratar de agregar el item");
                document.getElementById('DivMensajes').innerHTML=data;
            }
           
            
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
}

/**
 * Editar un item de una factura
 */
function EditarItem(idItem){
    var idCantidad = "TxtCantidad_"+idItem;
    var idValorUnitario = "TxtValorUnitario_"+idItem;
    
    
    var Cantidad = parseFloat(document.getElementById(idCantidad).value);
    var ValorUnitario = parseFloat(document.getElementById(idValorUnitario).value);
    if(isNaN(Cantidad) ){
        alertify.alert("La cantidad digitada No es un número, por favor digite un número válido");
        document.getElementById(idCantidad).style.backgroundColor="pink";
        return;
    }else{
        document.getElementById(idCantidad).style.backgroundColor="white";
    }
    
    if(isNaN(ValorUnitario) ){
        alertify.alert("El Valor digitado No es un número, por favor digite un número válido");
        document.getElementById(idValorUnitario).style.backgroundColor="pink";
        return;
    }else{
        document.getElementById(idValorUnitario).style.backgroundColor="white";
    }
    
    var form_data = new FormData();
        form_data.append('idItem', idItem)  
        form_data.append('ValorUnitario', ValorUnitario)       
        form_data.append('Cantidad', Cantidad)
        
        form_data.append('idAccion', 5)
        $.ajax({
        url: 'procesadores/FacturaFrecuente.process.php',
        //dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
            //console.log(data);
            if(data=='OK'){
                alertify.success("Valores Editados");    
                document.getElementById('DivMensajes').innerHTML='';                
                DibujeItemsFactura();                
            }else{
                alertify.error("Error al tratar de editar el item");
                document.getElementById('DivMensajes').innerHTML=data;
            }
           
            
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
}

function DibujeFacturasFrecuentes(Opciones=0){
    if(Opciones==1){
        var idCliente ='';
    }else{
        var idCliente = document.getElementById('idCliente').value;
    }
    var Fecha = document.getElementById('TxtFecha').value;
    var form_data = new FormData();
        form_data.append('Page', 1)
        form_data.append('Fecha', Fecha)
        form_data.append('idCliente', idCliente)
        $.ajax({
        url: 'Consultas/vista_facturacion_frecuente.php',
        //dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
            document.getElementById('DivListFacturas').innerHTML =data;   
            
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
}



/**
 * Seleccionar a factura y dibujar los items agregados a ella
 * @param {type} idItem
 * @returns {undefined}
 */
function SeleccionaFactura(idFacturaFrecuente,idBoton){
    CambiarColorBtnFacturas(idBoton);
    document.getElementById('idFacturaActiva').value=idFacturaFrecuente;
    DibujeItemsFactura();
}


/**
 * Seleccionar a factura y dibujar los items agregados a ella
 * @param {type} idItem
 * @returns {undefined}
 */
function DibujeItemsFactura(){
    var idFacturaFrecuente=document.getElementById('idFacturaActiva').value;
    var form_data = new FormData();
        form_data.append('idFacturaFrecuente', idFacturaFrecuente)
        form_data.append('idAccion', 2)
        $.ajax({
        url: 'procesadores/FacturaFrecuente.process.php',
        //dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
            
            document.getElementById('DivItemsFacturas').innerHTML=data;
             
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
}


function CambiarColorBtnFacturas(id){
      
    $(".btn-info").each(function(index) {
      console.log($(this));
      var idBoton=$(this).attr('id');
      document.getElementById(idBoton).className="btn btn-warning";
      document.getElementById(idBoton).value="Seleccionar";
      
    });
    
    document.getElementById(id).className="btn btn-info";
    document.getElementById(id).value="Áctiva";
    
}


/**Generar Facturacion Frecuente
 * Seleccionar a factura y dibujar los items agregados a ella
 * @param {type} idItem
 * @returns {undefined}
 */
function GenereFacturasFrecuentes(){
    document.getElementById("BtnGenerar").disabled=true;
    document.getElementById("BtnGenerar").value="Generando";
    document.getElementById("DivProcesando").innerHTML='<div id="GifProcess">Procesando...<br><img   src="../images/cargando.gif" alt="Cargando" height="100" width="100"></div>';
    var Fecha = document.getElementById('TxtFecha').value;
    var form_data = new FormData();        
        form_data.append('idAccion', 6)
        form_data.append('Fecha', Fecha)
        $.ajax({
        url: 'procesadores/FacturaFrecuente.process.php',
        //dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
            console.log(data);
            var respuestas = data.split(';');
            if(respuestas[0]=='SD'){
                document.getElementById("BtnGenerar").disabled=false;
                document.getElementById("BtnGenerar").value="Generar Facturas";
                document.getElementById("DivProcesando").innerHTML="";
                alertify.alert("No existen facturas frecuentes por realizar");  
                return;
            }
            if(respuestas[0]=="OK"){
                DibujeFacturasFrecuentes();
                var Porcentaje = respuestas[1];
                var msg = respuestas[2];
                $('.progress-bar').css('width',Porcentaje+'%').attr('aria-valuenow', Porcentaje);  
                document.getElementById('LyProgresoCMG').innerHTML=Porcentaje+"%";
                
                document.getElementById('DivMensajes').innerHTML=msg+"<br>"+document.getElementById('DivMensajes').innerHTML;
                if(Porcentaje==100){
                    document.getElementById("BtnGenerar").disabled=false;
                    document.getElementById("BtnGenerar").value="Generar Facturas";
                    document.getElementById("DivProcesando").innerHTML="";
                    alertify.success("Proceso Terminado Exitósamente");  
                    return;
                }
                if(Porcentaje<100){
                    GenereFacturasFrecuentes();
                }
             
            }else{
                document.getElementById("BtnGenerar").disabled=false;
                document.getElementById("BtnGenerar").value="Generar Facturas";
                document.getElementById('DivMensajes').innerHTML=data+"<br>"+document.getElementById('DivMensajes').innerHTML;
            }
             
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
}
