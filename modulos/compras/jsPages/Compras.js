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
            document.getElementById('DivDatosGeneralesCompra').innerHTML=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
      
      
}

function ConvertirSelectBusquedas(){
    var Listado=document.getElementById('CmbListado').value;
    if(Listado==1){ //Opcion para buscar un producto
        document.getElementById('CmbBusquedas').value="";
        document.getElementById('CodigoBarras').value="";
        document.getElementById('TxtDescripcion').value="";
        document.getElementById('ValorUnitario').value="";
        document.getElementById('Cantidad').value="1";
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
        document.getElementById('Cantidad').value="1";
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
        document.getElementById('Cantidad').value="1";
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

ConvertirSelectBusquedas();

$('#CmbBusquedas').bind('change', function() {
    
    document.getElementById('CodigoBarras').value = document.getElementById('CmbBusquedas').value;
    
});

$('#ValorUnitario').mask('#.##0,00', {reverse: true});
$('#Cantidad').mask('#.##0,00', {reverse: true});