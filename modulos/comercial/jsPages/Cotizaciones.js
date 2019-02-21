/**
 * Controlador para realizar las cotizaciones
 * JULIAN ALVARAN 2019-02-21
 * TECHNO SOLUCIONES SAS 
 * 317 774 0609
 */


/*
 * Abre el modal para registrar la nueva cotizacion
 * @returns {undefined}
 */
function AbrirModalNuevaCotizacion(Proceso="Nuevo"){
    $("#ModalAccionesCotizaciones").modal();
    var idCotizacion=document.getElementById('idCotizacion').value;
    
    var form_data = new FormData();
        if(Proceso=="Nuevo"){
            var Accion=1;
        }
        if(Proceso=="Editar"){
            var Accion=2;
            
        }
        form_data.append('Accion', Accion);
        form_data.append('idCotizacion', idCotizacion);
        $.ajax({
        url: './Consultas/Cotizaciones.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivFrmCrearCotizacion').innerHTML=data;
            $('#CmbTercero').select2({
		  
                placeholder: 'Selecciona un Tercero',
                ajax: {
                  url: 'buscadores/clientes.search.php',
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
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}  
/**
 * Crear una compra
 * @returns {undefined}
 */
function CrearCotizacion(event){
    event.preventDefault();
    var idCotizacionActiva=document.getElementById('idCotizacion').value;
    var Accion=document.getElementById('idAccion').value;
    
    var Fecha = document.getElementById('TxtFecha').value;
    var Tercero = document.getElementById('CmbTercero').value;
    
    var Observaciones = document.getElementById('TxtObservaciones').value;
    
    
    if(Tercero==""){
        alertify.alert("Debe seleccionar un tercero");
        document.getElementById('select2-CmbTercero-container').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('select2-CmbTercero-container').style.backgroundColor="white";
    }
    
    if(Fecha==""){
        alertify.alert("Debe seleccionar una fecha");
        document.getElementById('TxtFecha').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('TxtFecha').style.backgroundColor="white";
    }
    
    var form_data = new FormData();
        form_data.append('Accion', Accion);
        
        form_data.append('Fecha', Fecha);
        form_data.append('Tercero', Tercero);
        form_data.append('idCotizacionActiva', idCotizacionActiva);
        form_data.append('Observaciones', Observaciones);
            
        document.getElementById('CmbTercero').value='';
        CierraModal('ModalAccionesCotizaciones');
    
        $.ajax({
        url: './procesadores/Cotizaciones.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
          var respuestas = data.split(';'); 
          if (respuestas[0] == "OK") { 
              if(Accion==1){
                var idCotizacion=respuestas[1];
                alertify.success("Cotizacion "+idCotizacion+" creada");
                var x = document.getElementById("idCotizacion");
                  var option = document.createElement("option");
                  option.text = idCotizacion;
                  option.value = idCotizacion;

                  x.add(option); 
                  $("#idCotizacion option:last").attr('selected','selected');
                  DibujeCotizacion();
              }  
              if(Accion==2){
                  var index = document.getElementById("idCotizacion").selectedIndex;
                  var TextoOpcion=idCotizacionActiva+" "+respuestas[1];
                  document.getElementById("idCotizacion").options[index].text=TextoOpcion;
                  alertify.success("Cotizacion "+idCotizacionActiva+" Editada");
              }
              
          }else{
              alertify.error("Error al crear o editar la cotizacion");
              document.getElementById('DivMensajesModulo').innerHTML=data;
          }
          
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}
/**
 * Cierra una ventana modal
 * @param {type} idModal
 * @returns {undefined}
 */
function CierraModal(idModal) {
    $("#"+idModal).modal('hide');//ocultamos el modal
    $('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
    $('.modal-backdrop').remove();//eliminamos el backdrop del modal
}
/**
 * Funcion para dibujar todos los componentes de una compra
 * @param {type} idCompra
 * @returns {undefined}
 */
function DibujeCotizacion(idCotizacion=""){
    if(document.getElementById('idCotizacion').value==""){
        document.getElementById('BtnEditar').disabled=true;
    }else{
        document.getElementById('BtnEditar').disabled=false;
    }
    if(idCotizacion==""){
        var idCotizacion = document.getElementById('idCotizacion').value;
        
    }
    
    DibujeItems(idCotizacion);
    DibujeTotales(idCotizacion);
}


/**
 * Se dibujan los datos generales de una compra 
 * @param {type} idCompra
 * @returns {undefined}
 */
function DibujeItemsCompra(idCompra=""){
    if(idCompra==""){
        var idCompra = document.getElementById('idCompra').value;
    }
    
    var form_data = new FormData();
        form_data.append('Accion', 3);
        form_data.append('idCompra', idCompra);
        $.ajax({
        url: './Consultas/Compras.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivItemsCompra').innerHTML=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
      
      
}


/**
 * cambia el select para realizar busquedas según el listado seleccionado
 * @returns {undefined}
 */
function ConvertirSelectBusquedas(){
    var Listado=document.getElementById('CmbListado').value;
    if(Listado==1){ //Opcion para buscar un producto
        document.getElementById('CmbBusquedas').value="";
        
        document.getElementById('ValorUnitario').value="";
        document.getElementById('Cantidad').value=1;
        
        $('#CmbBusquedas').select2({
		  
            placeholder: 'Selecciona un producto',
            ajax: {
              url: 'buscadores/productosventa.search.php',
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
    }
    
    
    if(Listado==2){ //Opcion para buscar un servicio
        document.getElementById('CmbBusquedas').value="";
        
        document.getElementById('ValorUnitario').value="";
        document.getElementById('Cantidad').value=1;
        
        $('#CmbBusquedas').select2({
            
            placeholder: 'Selecciona un servicio',
            ajax: {
              url: 'buscadores/servicios.search.php',
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
    }
    
    if(Listado==3){ //Opcion para buscar un producto en alquiler
        document.getElementById('CmbBusquedas').value="";        
        document.getElementById('ValorUnitario').value="";
        document.getElementById('Cantidad').value=1;
        
        $('#CmbBusquedas').select2({
            
            placeholder: 'Buscar producto para alquilar',
            ajax: {
              url: 'buscadores/productosalquiler.search.php',
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
    }
}
/**
 * Agrega un item a una FC
 * @returns {undefined}
 */
function AgregarItem(){
    
    var idCompra=document.getElementById('idCompra').value;
    var CmbListado=document.getElementById('CmbListado').value;
    var CmbBusquedas=document.getElementById('CmbBusquedas').value;    
    var CmbImpuestosIncluidos = document.getElementById('CmbImpuestosIncluidos').value;
    var CmbTipoImpuesto = document.getElementById('CmbTipoImpuesto').value;
    var CodigoBarras = document.getElementById('CodigoBarras').value;
    var TxtDescripcion = document.getElementById('TxtDescripcion').value;
    var Cantidad = parseFloat(document.getElementById('Cantidad').value);
    var ValorUnitario = parseFloat(document.getElementById('ValorUnitario').value);
    
    /*
    Cantidad=Cantidad.replace(".","");
    Cantidad=Cantidad.replace(".","");
    Cantidad=Cantidad.replace(".","");
    Cantidad=Cantidad.replace(".","");
    Cantidad=Cantidad.replace(",",".");
    ValorUnitario=ValorUnitario.replace(".","");
    ValorUnitario=ValorUnitario.replace(".","");
    ValorUnitario=ValorUnitario.replace(".","");
    ValorUnitario=ValorUnitario.replace(".","");
    ValorUnitario=ValorUnitario.replace(".","");
    ValorUnitario=ValorUnitario.replace(",",".");
    
    */
   console.log("varlor unitario:"+ ValorUnitario); 
    if(idCompra==""){
        alertify.alert("Debe Seleccionar una compra");
        document.getElementById('idCompra').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('idCompra').style.backgroundColor="white";
    }
    
    if(TxtDescripcion=="" && CmbListado==2){
        alertify.alert("El campo descripción no puede estar vacío");
        document.getElementById('TxtDescripcion').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('TxtDescripcion').style.backgroundColor="white";
    }
    
    if(CmbListado==2 && CodigoBarras.length<6){
        alertify.alert("No puedes seleccionar una Cuenta Padre");
        document.getElementById('select2-CmbBusquedas-container').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('select2-CmbBusquedas-container').style.backgroundColor="white";
    }
    
    if(CodigoBarras==""){
        alertify.alert("El campo código no puede estar vacío");
        document.getElementById('CodigoBarras').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('CodigoBarras').style.backgroundColor="white";
    }
    
    if(isNaN(Cantidad) || Cantidad == ""){
        alertify.alert("El campo Cantidad debe ser un número mayor a cero");
        document.getElementById('Cantidad').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('Cantidad').style.backgroundColor="white";
    }
    
    if(isNaN(ValorUnitario) || ValorUnitario == ""){
        alertify.alert("El campo Valor Unitario debe ser un número mayor a cero");
        document.getElementById('ValorUnitario').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('ValorUnitario').style.backgroundColor="white";
    }
       
    var form_data = new FormData();
        form_data.append('Accion', 3);
        form_data.append('idCompra', idCompra);
        form_data.append('CmbListado', CmbListado);
        form_data.append('CmbBusquedas', CmbBusquedas);
        form_data.append('CmbImpuestosIncluidos', CmbImpuestosIncluidos);
        form_data.append('CmbTipoImpuesto', CmbTipoImpuesto);
        form_data.append('CodigoBarras', CodigoBarras);
        form_data.append('TxtDescripcion', TxtDescripcion);
        form_data.append('Cantidad', Cantidad);
        form_data.append('ValorUnitario', ValorUnitario);
         document.getElementById('ValorUnitario').value="";   
        $.ajax({
        url: './procesadores/Compras.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
          
          if (data == "OK") { 
              
                alertify.success("Item "+CodigoBarras+" Agregado");
                DibujeCompra(idCompra);
          
          }else{
              alertify.alert(data);
          }
          
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}

/**
 * Elimina un item de una factura de compra
 * @param {type} Tabla
 * @param {type} idItem
 * @returns {undefined}
 */
function EliminarItem(Tabla,idItem){
        
    var form_data = new FormData();
        form_data.append('Accion', 5);
        form_data.append('Tabla', Tabla);
        form_data.append('idItem', idItem);
        $.ajax({
        url: './procesadores/Compras.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            alertify.error(data);
            DibujeCompra();
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
}


/**
 * Se dibujan los totales generales de una compra 
 * @param {type} idCompra
 * @returns {undefined}
 */
function DibujeTotalesCompra(idCompra=""){
    if(idCompra==""){
        var idCompra = document.getElementById('idCompra').value;
    }
    
    var form_data = new FormData();
        form_data.append('Accion', 4);
        form_data.append('idCompra', idCompra);
        $.ajax({
        url: './Consultas/Compras.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivTotalesCompra').innerHTML=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
      
      
}


/**
 * Muestra u oculta un elemento por su id
 * @param {type} id
 * @returns {undefined}
 */

function MuestraOcultaXIDCompras(id){
    
    var estado=document.getElementById(id).style.display;
    if(estado=="none" | estado==""){
        document.getElementById(id).style.display="block";
    }
    if(estado=="block"){
        document.getElementById(id).style.display="none";
    }
    
}

/**
 * Agrega los cargos al subtotal de los insumos
 * @param {type} event
 * @returns {undefined}
 */
function GuardarCompra(idCompra=''){
    document.getElementById('BtnGuardarCompra').disabled=true;
    if(idCompra==''){
        var idCompra = document.getElementById('idCompra').value;
    }
        
    var CmbTipoPago = document.getElementById("CmbTipoPago").value;
    var CmbCuentaOrigen = document.getElementById("CmbCuentaOrigen").value;
    var CmbCuentaPUCCXP = document.getElementById("CmbCuentaPUCCXP").value;
    var TxtFechaProgramada = document.getElementById("TxtFechaProgramada").value;
    var CmbTraslado = document.getElementById("CmbTraslado").value;
    
    
    if(TxtFechaProgramada==''){
        alertify.alert("El campo fecha programada no puede estar vacío");
        document.getElementById("TxtFechaProgramada").style.backgroundColor="pink";
        return;
    }else{
        document.getElementById("TxtFechaProgramada").style.backgroundColor="white";
    }
    
    
    document.getElementById("TxtFechaProgramada").value='';
    var form_data = new FormData();
        form_data.append('Accion', '9'); 
        form_data.append('idCompra', idCompra);
        form_data.append('CmbTipoPago', CmbTipoPago);
        form_data.append('CmbCuentaOrigen', CmbCuentaOrigen);
        form_data.append('CmbCuentaPUCCXP', CmbCuentaPUCCXP);
        form_data.append('TxtFechaProgramada', TxtFechaProgramada);
        form_data.append('CmbTraslado', CmbTraslado);
        $.ajax({
        url: './procesadores/Compras.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            if(respuestas[0]=="OK"){
                var mensaje=respuestas[1];
                LimpiarDivs();
                var x = document.getElementById("idCompra");
                x.remove(x.selectedIndex);
                document.getElementById('BtnEditarCompra').disabled=true;
                alertify.alert(mensaje);
                
            }else{
                alertify.error(data,10000);
                document.getElementById('BtnGuardarCompra').disabled=false;
            }
            
            //DibujeTotalesCompra(idCompra);
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
    
    
}
/**
 * Limpia los divs de la compra despues de guardar
 * @returns {undefined}
 */
function LimpiarDivs(){
    document.getElementById('DivItemsCompra').innerHTML='';
    document.getElementById('DivTotalesCompra').innerHTML='';
}

function BusquePrecioVenta(){
   
    var listado = document.getElementById('CmbListado').value;
    var CmbBusquedas = document.getElementById('CmbBusquedas').value;
    
    var form_data = new FormData();
        form_data.append('Accion', 5);
        form_data.append('listado', listado);
        form_data.append('CmbBusquedas', CmbBusquedas);
        $.ajax({
        url: './Consultas/Cotizaciones.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
            document.getElementById('ValorUnitario').value=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
      
}

ConvertirSelectBusquedas();

$('#CmbBusquedas').bind('change', function() {
    
    BusquePrecioVenta();
    
});

//$('#ValorUnitario').mask('1.999.999.##0,00', {reverse: true});
//$('#Cantidad').mask('9.999.##0,00', {reverse: true});