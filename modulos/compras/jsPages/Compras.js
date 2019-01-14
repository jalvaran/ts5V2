/**
 * Controlador para realizar las compras
 * JULIAN ALVARAN 2018-12-05
 * TECHNO SOLUCIONES SAS 
 * 317 774 0609
 */


/*
 * Abre el modal para registrar la nueva compra
 * @returns {undefined}
 */
function AbrirModalNuevaCompra(Proceso="Nuevo"){
    $("#ModalAccionesCompras").modal();
    var idCompra=document.getElementById('idCompra').value;
    
    var form_data = new FormData();
        if(Proceso=="Nuevo"){
            var Accion=1;
        }
        if(Proceso=="Editar"){
            var Accion=2;
            
        }
        form_data.append('Accion', Accion);
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
            document.getElementById('DivFormularioCrearCompra').innerHTML=data;
            $('#CmbTerceroCrearCompra').select2({
		  
                placeholder: 'Selecciona un Tercero',
                ajax: {
                  url: 'buscadores/proveedores.search.php',
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
function CrearCompra(event){
    event.preventDefault();
    var idCompraActiva=document.getElementById('idCompra').value;
    var Accion=document.getElementById('idAccion').value;
    
    var Fecha = document.getElementById('TxtFecha').value;
    var Tercero = document.getElementById('CmbTerceroCrearCompra').value;
    var ControCosto = document.getElementById('CmbCentroCosto').value;
    var Sucursal = document.getElementById('idSucursal').value;
    var TipoCompra = document.getElementById('TipoCompra').value;
    var Concepto = document.getElementById('TxtConcepto').value;
    var NumFactura = document.getElementById('TxtNumFactura').value;
    
    if(Tercero==""){
        alertify.alert("Debe seleccionar un tercero");
        document.getElementById('select2-CmbTerceroCrearCompra-container').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('select2-CmbTerceroCrearCompra-container').style.backgroundColor="white";
    }
    
    if(NumFactura==""){
        alertify.alert("Debe escribir el numero de comprobante");
        document.getElementById('TxtNumFactura').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('TxtNumFactura').style.backgroundColor="white";
    }
    
    if(Concepto==""){
        alertify.alert("Debe especificar un concepto");
        document.getElementById('TxtConcepto').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('TxtConcepto').style.backgroundColor="white";
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
        form_data.append('Soporte', $('#UpSoporte').prop('files')[0]);
        form_data.append('Fecha', Fecha);
        form_data.append('Tercero', Tercero);
        form_data.append('ControCosto', ControCosto);
        form_data.append('Sucursal', Sucursal);
        form_data.append('TipoCompra', TipoCompra);
        form_data.append('Concepto', Concepto);
        form_data.append('NumFactura', NumFactura);
        form_data.append('idCompraActiva', idCompraActiva);
    
        document.getElementById('CmbTerceroCrearCompra').value='';
        CierraModal('ModalAccionesCompras');
    
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
          if (respuestas[0] == "OK") { 
              if(Accion==1){
                var idCompra=respuestas[1];
                alertify.success("Compra "+idCompra+" creada");
                var x = document.getElementById("idCompra");
                  var option = document.createElement("option");
                  option.text = idCompra+" "+Concepto+" "+NumFactura;
                  option.value = idCompra;

                  x.add(option); 
                  $("#idCompra option:last").attr('selected','selected');
                  DibujeCompra();
              }  
              if(Accion==2){
                  var index = document.getElementById("idCompra").selectedIndex;
                  var TextoOpcion=idCompraActiva+" "+respuestas[1]+" "+respuestas[2]+" "+respuestas[3];
                  document.getElementById("idCompra").options[index].text=TextoOpcion;
                  alertify.success("Compra "+idCompraActiva+" Editada");
              }
          
          }else{
              alertify.error("Error al crear la compra");
              document.getElementById('DivDatosGeneralesCompra').innerHTML=data;
          }
          
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}

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
function DibujeCompra(idCompra=""){
    if(document.getElementById('idCompra').value==""){
        document.getElementById('BtnEditarCompra').disabled=true;
    }else{
        document.getElementById('BtnEditarCompra').disabled=false;
    }
    if(idCompra==""){
        var idCompra = document.getElementById('idCompra').value;
        
    }
    DibujeItemsCompra(idCompra);
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
        document.getElementById('CodigoBarras').value="";
        document.getElementById('TxtDescripcion').value="";
        document.getElementById('ValorUnitario').value="";
        document.getElementById('Cantidad').value=1;
        document.getElementById('Cantidad').disabled=false;
        document.getElementById('TxtDescripcion').disabled=true;
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
        document.getElementById('CodigoBarras').value="";
        document.getElementById('TxtDescripcion').value="";
        document.getElementById('ValorUnitario').value="";
        document.getElementById('Cantidad').value=1;
        document.getElementById('Cantidad').disabled=true;
        document.getElementById('TxtDescripcion').disabled=false;
        $('#CmbBusquedas').select2({
            
            placeholder: 'Selecciona una cuenta PUC para este servicio',
            ajax: {
              url: 'buscadores/CuentaPUC.search.php',
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
    
    if(Listado==3){ //Opcion para buscar un insumo
        document.getElementById('CmbBusquedas').value="";
        document.getElementById('CodigoBarras').value="";
        document.getElementById('TxtDescripcion').value="";
        document.getElementById('ValorUnitario').value="";
        document.getElementById('Cantidad').value=1;
        document.getElementById('Cantidad').disabled=false;
        document.getElementById('TxtDescripcion').disabled=true;
        $('#CmbBusquedas').select2({
            
            placeholder: 'Buscar insumo',
            ajax: {
              url: 'buscadores/insumos.search.php',
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

function AgregarItem(){
    
    var idCompra=document.getElementById('idCompra').value;
    var CmbListado=document.getElementById('CmbListado').value;
    var CmbBusquedas=document.getElementById('CmbBusquedas').value;    
    var CmbImpuestosIncluidos = document.getElementById('CmbImpuestosIncluidos').value;
    var CmbTipoImpuesto = document.getElementById('CmbTipoImpuesto').value;
    var CodigoBarras = document.getElementById('CodigoBarras').value;
    var TxtDescripcion = document.getElementById('TxtDescripcion').value;
    var Cantidad = (document.getElementById('Cantidad').value);
    var ValorUnitario = (document.getElementById('ValorUnitario').value);
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
    
    if(Cantidad == ""){
        alertify.alert("El campo Cantidad debe ser un número mayor a cero");
        document.getElementById('Cantidad').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('Cantidad').style.backgroundColor="white";
    }
    
    if(ValorUnitario == ""){
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
 * Imprime un codigo de barras
 * @param {type} idProducto
 * @param {type} Cantidad
 * @returns {undefined}
 */
function PrintEtiqueta(idProducto,Cantidad=''){
    if(Cantidad==""){
        var Cantidad = document.getElementById('CantidadTiquetes').value;
    }
    
    var form_data = new FormData();
        form_data.append('Accion', 4);
        form_data.append('idProducto', idProducto);
        form_data.append('Cantidad', Cantidad);
        $.ajax({
        url: './procesadores/Compras.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            alertify.success(data);
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
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

ConvertirSelectBusquedas();

$('#CmbBusquedas').bind('change', function() {
    
    document.getElementById('CodigoBarras').value = document.getElementById('CmbBusquedas').value;
    
});

$('#ValorUnitario').mask('1.999.999.##0,00', {reverse: true});
$('#Cantidad').mask('9.999.##0,00', {reverse: true});