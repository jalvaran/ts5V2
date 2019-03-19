/**
 * Controlador para realizar las ventas pos
 * JULIAN ALVARAN 2019-03-01
 * TECHNO SOLUCIONES SAS 
 * 317 774 0609
 */
/**
 * Posiciona un elemento indicando el id
 * @param {type} id
 * @returns {undefined}
 */
function posiciona(id){ 
   
   document.getElementById(id).focus();
   
}

posiciona('Codigo');
/**
 * Agrega una opcion de preventa
 * @returns {undefined}
 */
function AgregarPreventa(){
       
    var form_data = new FormData();
        
        form_data.append('Accion', 1);
        
        $.ajax({
        url: './procesadores/pos.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            if(respuestas[0]=="E1"){
                alertify.alert("No se pueden crear mas de 3 preventas");
            }else if(respuestas[0]=="OK"){
                var x = document.getElementById("idPreventa");
                var option = document.createElement("option");
                option.text = respuestas[1]+" "+respuestas[2];
                option.value = respuestas[1];
                x.add(option); 
                $("#idPreventa option:last").attr('selected','selected');
                alertify.success("La preventa "+respuestas[1]+" ha sido creada Satisfactoriamente");
                posiciona('Codigo');
                DibujePreventa();
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
 * Agregar un item a una preventa
 * @returns {undefined}
 */
function AgregarItem(){
    var Codigo=document.getElementById('Codigo').value; 
    var idPreventa=document.getElementById('idPreventa').value; 
    var CmbListado=document.getElementById('CmbListado').value;
    var Cantidad=parseFloat(document.getElementById('Cantidad').value);
    
       
    if(Codigo == ''){
        alertify.error("El campo Código no puede estar vacío");
        document.getElementById("Codigo").style.backgroundColor="pink";
        posiciona('Codigo');
        return;
    }else{
        document.getElementById("Codigo").style.backgroundColor="white";
    }
    
    if(idPreventa == ''){
        alertify.error("Debe seleccionar una preventa");
        document.getElementById("idPreventa").style.backgroundColor="pink";
        posiciona('idPreventa');
        return;
    }else{
        document.getElementById("idPreventa").style.backgroundColor="white";
    }
    
    if(!$.isNumeric(Cantidad) || Cantidad == ""){
        alertify.error("La Cantidad Digitada debe ser un número diferente a Cero");
        document.getElementById("Cantidad").style.backgroundColor="pink";
        posiciona('Cantidad');
        return;
    }else{
        document.getElementById("Cantidad").style.backgroundColor="white";
    }
    
    var form_data = new FormData();
        
        form_data.append('Accion', 2);
        form_data.append('idPreventa', idPreventa);
        form_data.append('Codigo', Codigo);
        form_data.append('CmbListado', CmbListado);
        form_data.append('Cantidad', Cantidad);
        document.getElementById('Codigo').value="";
        document.getElementById('Cantidad').value=1;
        $.ajax({
        url: './procesadores/pos.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            if(respuestas[0]=="E1"){
                var mensaje=respuestas[1];
                alertify.alert(mensaje);
            }else if(respuestas[0]=="OK"){
                
                var mensaje=respuestas[1];
                alertify.success(mensaje,1000);
                posiciona('Codigo');
                
                DibujePreventa();
                document.getElementById('CmbBusquedaItems').value='';
                
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
 * Dibuja los items y totales de la preventa
 * @param {type} idPreventa
 * @returns {undefined}
 */
function DibujePreventa(idPreventa=""){
    
    if(idPreventa==""){
        var idPreventa = document.getElementById('idPreventa').value;
        
    }
    
    DibujeItems(idPreventa);
    DibujeTotales(idPreventa);
}
/**
 * Dibuja los items de una preventa
 * @param {type} idPreventa
 * @returns {undefined}
 */
function DibujeItems(idPreventa=""){
    if(idPreventa==""){
        var idPreventa = document.getElementById('idPreventa').value;
    }
    
    var form_data = new FormData();
        form_data.append('Accion', 1);
        form_data.append('idPreventa', idPreventa);
        $.ajax({
        url: './Consultas/pos.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivItems').innerHTML=data;
            
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
function DibujeTotales(idPreventa=""){
    if(idPreventa==""){
        var idPreventa = document.getElementById('idPreventa').value;
    }
    
    var form_data = new FormData();
        form_data.append('Accion', 2);
        form_data.append('idPreventa', idPreventa);
        $.ajax({
        url: './Consultas/pos.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivTotales').innerHTML=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
      
      
}

/**
 * Elimina un item de la preventa
 * @param {type} idItem
 * @returns {undefined}
 */
function EliminarItem(idItem){
        
    var form_data = new FormData();
        form_data.append('Accion', 3);        
        form_data.append('idItem', idItem);
        $.ajax({
        url: './procesadores/pos.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            if(respuestas[0]=="OK"){
                alertify.error(respuestas[1]);
            }
            if(respuestas[0]=="E1"){
                alertify.alert(respuestas[1]);
            }
            DibujePreventa();
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

/**
 *Editar la cantidad en una preventa
 * @param {type} idItem
 * @returns {undefined}
 */
function EditarItemCantidad(idItem){
    var idCantidad='TxtCantidad_'+idItem
    var Cantidad=parseFloat(document.getElementById(idCantidad).value);
    
    if(!$.isNumeric(Cantidad) || Cantidad == ""){
        alertify.error("El Campo Cantidad debe ser un número, debe ser diferente a Cero y no puede estar en blanco");
        document.getElementById(idCantidad).style.backgroundColor="pink";
        posiciona(idCantidad);
        return;
    }else{
        document.getElementById(idCantidad).style.backgroundColor="white";
    }
    
    var form_data = new FormData();
        form_data.append('Accion', 4);        
        form_data.append('idItem', idItem);
        form_data.append('Cantidad', Cantidad);
        $.ajax({
        url: './procesadores/pos.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            
            if(respuestas[0]=="E1"){
                
                alertify.error(respuestas[1]);
            }else if(respuestas[0]=="OK"){
                alertify.success(respuestas[1]);
            }else{
                alertify.alert(data);
            }
            
            DibujePreventa();
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
}
/**
 * Editar precio de venta
 * @param {type} idItem
 * @param {type} Mayorista
 * @returns {undefined}
 */
function EditarPrecioVenta(idItem,Mayorista=0){
    var idPrecioVenta='TxtValorUnitario_'+idItem
    var PrecioVenta=parseFloat(document.getElementById(idPrecioVenta).value);
    
    if(!$.isNumeric(PrecioVenta) || PrecioVenta == ""){
        alertify.error("El Precio debe ser un número, debe ser diferente a Cero y no puede estar en blanco");
        document.getElementById(idPrecioVenta).style.backgroundColor="pink";
        posiciona(idPrecioVenta);
        return;
    }else{
        document.getElementById(idPrecioVenta).style.backgroundColor="white";
    }
    
    var form_data = new FormData();
        form_data.append('Accion', 5);        
        form_data.append('idItem', idItem);
        form_data.append('PrecioVenta', PrecioVenta);
        form_data.append('Mayorista', Mayorista);
        $.ajax({
        url: './procesadores/pos.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            
            if(respuestas[0]=="E1"){
                
                alertify.alert(respuestas[1]);
            }else if(respuestas[0]=="OK"){
                alertify.success(respuestas[1]);
            }else{
                alertify.alert(data);
            }
            
            DibujePreventa();
            
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
        document.getElementById('CmbBusquedaItems').value="";  
        document.getElementById('Cantidad').value=1;
        
        $('#CmbBusquedaItems').select2({
		  
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
        document.getElementById('CmbBusquedaItems').value="";        
        document.getElementById('Cantidad').value=1;
        
        $('#CmbBusquedaItems').select2({
            
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
        document.getElementById('CmbBusquedaItems').value="";        
        document.getElementById('Cantidad').value=1;
        
        $('#CmbBusquedaItems').select2({
            
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
    
    if(Listado==4){ //Opcion para buscar un sistema
        document.getElementById('CmbBusquedaItems').value="";        
        document.getElementById('Cantidad').value=1;
        
        $('#CmbBusquedaItems').select2({
            
            placeholder: 'Buscar un sistema',
            ajax: {
              url: 'buscadores/sistemas.search.php',
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

$('#idCliente').select2({
            
    placeholder: 'Clientes Varios',
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

/**
 * Establece el modo bascula donde consulta el valor de la bascula en un intervalo de tiempo
 * @returns {undefined}
 */
function ModoBacula(){
    
    var form_data = new FormData();        
        form_data.append('Accion', 6);
        
        
        $.ajax({
        url: './procesadores/pos.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            if(respuestas[0]=="E1"){
                alertify.alert(respuestas[1]);
                document.getElementById("SpEstadoCaja").innerHTML=respuestas[1];
            }else if(respuestas[0]=="OK"){
                document.getElementById("SpEstadoCaja").innerHTML="Modo Bascula Activo";
                document.getElementById("Cantidad").value=respuestas[1];
                if(document.getElementById("CmbListado").value==5){
                    setTimeout(ModoBacula, 400);
                }else{
                    document.getElementById("SpEstadoCaja").innerHTML="";
                    document.getElementById("Cantidad").value=1;
                }
                
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
 * Abre un modal con las opciones para realizar una factura POS
 * @returns {undefined}
 */
function AbrirModalFacturarPOS(){
    
    $("#ModalAccionesPOS").modal();
    var idPreventa=document.getElementById('idPreventa').value;
    var idCliente=document.getElementById('idCliente').value;
    var form_data = new FormData();
        
        form_data.append('Accion', 6);
        form_data.append('idPreventa', idPreventa);
        form_data.append('idCliente', idCliente);
        $.ajax({
        url: './Consultas/pos.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivFrmPOS').innerHTML=data;
            setTimeout(function(){document.getElementById("Efectivo").select();}, 100);
            
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}  
/**
 * Calcula la devuelta 
 * @returns {undefined}
 */
function CalculeDevuelta(){
    var TotalFactura = parseFloat(document.getElementById("TxtTotalFactura").value);
    var Efectivo = parseFloat(document.getElementById("Efectivo").value);
    var Tarjetas = parseFloat(document.getElementById("Tarjetas").value);
    var Cheque = parseFloat(document.getElementById("Cheque").value);
    var Otros = parseFloat(document.getElementById("Otros").value);
    if(document.getElementById("Tarjetas").value==''){
        Tarjetas=0;
    }
    if(document.getElementById("Cheque").value==''){
        Cheque=0;
    }
    if(document.getElementById("Otros").value==''){
        Otros=0;
    }
    if(!$.isNumeric(Efectivo) || Efectivo < 0){
        alertify.error("El Campo Efectivo debe ser un número mayor o igual a Cero y no puede estar en blanco");
        document.getElementById("Efectivo").style.backgroundColor="pink";
        
        return;
    }else{
        document.getElementById("Efectivo").style.backgroundColor="white";
    }
    
    if(!$.isNumeric(Tarjetas) || Tarjetas < 0){
        
        alertify.error("El Campo Tarjetas debe ser un número mayor o igual a Cero y no puede estar en blanco");
        document.getElementById("Tarjetas").style.backgroundColor="pink";
        
        return;
    }else{
        document.getElementById("Tarjetas").style.backgroundColor="white";
    }
    
    if(!$.isNumeric(Cheque) || Cheque < 0){
        alertify.error("El Campo Cheque debe ser un número mayor o igual a Cero y no puede estar en blanco");
        document.getElementById("Cheque").style.backgroundColor="pink";
        
        return;
    }else{
        document.getElementById("Cheque").style.backgroundColor="white";
    }
    
    if(!$.isNumeric(Otros) || Otros < 0){
        alertify.error("El Campo Otros debe ser un número mayor o igual a Cero y no puede estar en blanco");
        document.getElementById("Otros").style.backgroundColor="pink";
        
        return;
    }else{
        document.getElementById("Otros").style.backgroundColor="white";
    }
    var TotalRecibido = Efectivo+Tarjetas+Cheque+Otros;
    var Devuelta = TotalRecibido-TotalFactura;
    document.getElementById("Devuelta").value=Devuelta;
    
}

/**
 * Establece los atajos
 * @returns {undefined}
 */
function atajosPOS(){

    shortcut("Ctrl+E",function(){
    document.getElementById("Codigo").focus();
    });

    shortcut("Ctrl+S",function(){
    document.getElementById("BtnFacturar").click();
    });
    
    shortcut("Ctrl+D",function(){
    document.getElementById("Efectivo").select();
    });
    
    shortcut("Ctrl+A",function(){
    document.getElementById("BntModalPOS").click();
    });

}
/**
 * Determina la accion a seguir según el formulario dibujado
 * @returns {undefined}
 */
function AccionesPOS(){
    document.getElementById("BntModalPOS").disabled=true;
    document.getElementById("BntModalPOS").value="Guardando...";
    var idFormulario=document.getElementById('idFormulario').value; //determina el tipo de formulario que se va a guardar
    
    if(idFormulario==1){
        GuardarFactura();
    }
    
    if(idFormulario==2){
        CrearTercero();
    }
    
}
/**
 * Crear un tercero
 * @returns {undefined}
 */
function CrearTercero(){
    
    var TipoDocumento=document.getElementById('TipoDocumento').value;
    var Num_Identificacion=document.getElementById('Num_Identificacion').value;    
    var CodigoMunicipio=document.getElementById('CodigoMunicipio').value;
    var Telefono=document.getElementById('Telefono').value;
    var PrimerNombre=document.getElementById('PrimerNombre').value;
    var OtrosNombres=document.getElementById('OtrosNombres').value;
    var PrimerApellido=document.getElementById('PrimerApellido').value;
    var SegundoApellido=document.getElementById('SegundoApellido').value;
    var RazonSocial=document.getElementById('RazonSocial').value;
    var Direccion=document.getElementById('Direccion').value;
    var Email=document.getElementById('Email').value;
    var Cupo=document.getElementById('Cupo').value;
    var CodigoTarjeta=document.getElementById('CodigoTarjeta').value;
    
    if(!$.isNumeric(Num_Identificacion) || Num_Identificacion <= 0){
        alertify.error("El Campo Identificacion debe ser un número mayor a Cero y no puede estar en blanco");
        document.getElementById("Num_Identificacion").style.backgroundColor="pink";
        
        return;
    }else{
        document.getElementById("Num_Identificacion").style.backgroundColor="white";
    }
    
    if(Telefono==''){
        alertify.error("El Campo Teléfono no puede estar vacío");
        document.getElementById("Telefono").style.backgroundColor="pink";
        
        return;
    }else{
        document.getElementById("Telefono").style.backgroundColor="white";
    }
    
    if(RazonSocial==''){
        alertify.error("El Campo Razón Social no puede estar vacío");
        document.getElementById("RazonSocial").style.backgroundColor="pink";
        
        return;
    }else{
        document.getElementById("RazonSocial").style.backgroundColor="white";
    }
    
    
    if(Direccion==''){
        alertify.error("El Campo Dirección no puede estar vacío");
        document.getElementById("Direccion").style.backgroundColor="pink";
        
        return;
    }else{
        document.getElementById("Direccion").style.backgroundColor="white";
    }
    
    if(Email==''){
        alertify.error("El Campo Email no puede estar vacío");
        document.getElementById("Email").style.backgroundColor="pink";
        
        return;
    }else{
        document.getElementById("Email").style.backgroundColor="white";
    }
    
    if(!$.isNumeric(Cupo) || Cupo < 0){
        alertify.error("El Campo Cupo debe ser un número mayor o igual a Cero y no puede estar en blanco");
        document.getElementById("Cupo").style.backgroundColor="pink";
        
        return;
    }else{
        document.getElementById("Cupo").style.backgroundColor="white";
    }
    
    var form_data = new FormData();
        
        form_data.append('Accion', 16);
        form_data.append('TipoDocumento', TipoDocumento);
        form_data.append('Num_Identificacion', Num_Identificacion);
        form_data.append('CodigoMunicipio', CodigoMunicipio);
        form_data.append('Telefono', Telefono);
        form_data.append('TipoDocumento', TipoDocumento);
        form_data.append('PrimerNombre', PrimerNombre);
        form_data.append('OtrosNombres', OtrosNombres);
        form_data.append('PrimerApellido', PrimerApellido);
        form_data.append('SegundoApellido', SegundoApellido);
        form_data.append('RazonSocial', RazonSocial);
        form_data.append('Direccion', Direccion);
        form_data.append('Email', Email);
        form_data.append('Cupo', Cupo);
        form_data.append('CodigoTarjeta', CodigoTarjeta);
        
        document.getElementById("RazonSocial").value='';
        
        $.ajax({
        url: './procesadores/pos.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';');
            if(respuestas[0]=="E1"){
                alertify.alert(respuestas[1]);
                
            }else if(respuestas[0]=="OK"){
                alertify.success(respuestas[1]);
                CierraModal('ModalAccionesPOS');
            }else{
                alertify.alert(data);
            }
            document.getElementById("BntModalPOS").disabled=false;
            document.getElementById("BntModalPOS").value="Guardar";
            posiciona('Codigo');           
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
    
}
/**
 * Verifica si existe un nit
 * @returns {undefined}
 */
function VerificaNIT(){
    var Num_Identificacion=document.getElementById('Num_Identificacion').value;
    
    var form_data = new FormData();
        
        form_data.append('Accion', 17);
        form_data.append('Num_Identificacion', Num_Identificacion);
        
        $.ajax({
        url: './procesadores/pos.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';');
            if(respuestas[0]=="E1"){
                alertify.error(respuestas[1]);
                document.getElementById("Num_Identificacion").style.backgroundColor="pink";
                posiciona('Num_Identificacion');
                document.getElementById("BntModalPOS").disabled=true;
            }else if(respuestas[0]=="OK"){
                alertify.success(respuestas[1]);
                document.getElementById("Num_Identificacion").style.backgroundColor="white";
                document.getElementById("BntModalPOS").disabled=false;
            }else{
                alertify.alert(data);
                document.getElementById("BntModalPOS").disabled=false;
            }
            
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}
/**
 * Verifica si el codigo de una tarjeta ya existe
 * @returns {undefined}
 */
function VerificaCodigoTarjeta(){
    var CodigoTarjeta=document.getElementById('CodigoTarjeta').value;
    
    var form_data = new FormData();
        
        form_data.append('Accion', 18);
        form_data.append('CodigoTarjeta', CodigoTarjeta);
        
        $.ajax({
        url: './procesadores/pos.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';');
            if(respuestas[0]=="E1"){
                alertify.error(respuestas[1]);
                document.getElementById("CodigoTarjeta").style.backgroundColor="pink";
                posiciona('CodigoTarjeta');
                document.getElementById("BntModalPOS").disabled=true;
            }else if(respuestas[0]=="OK"){
                alertify.success(respuestas[1]);
                document.getElementById("CodigoTarjeta").style.backgroundColor="white";
                document.getElementById("BntModalPOS").disabled=false;
            }else{
                alertify.alert(data);
                document.getElementById("BntModalPOS").disabled=false;
            }
            
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}
/**
 * Crea la razon social
 * @returns {undefined}
 */
function CompletaRazonSocial() {

    var PrimerApellido=document.getElementById('PrimerApellido').value;
    var SegundoApellido=document.getElementById('SegundoApellido').value;
    var PrimerNombre=document.getElementById('PrimerNombre').value;
    var OtrosNombres=document.getElementById('OtrosNombres').value;
	

    var RazonSocial=PrimerNombre+" "+OtrosNombres+" "+PrimerApellido+" "+SegundoApellido;

    document.getElementById('RazonSocial').value=RazonSocial;


}

/**
 * Crea y guarda una factura a partir de una preventa
 * @returns {undefined}
 */
function GuardarFactura(){
       
    var idPreventa = document.getElementById('idPreventa').value;       
    var Efectivo = parseFloat(document.getElementById('Efectivo').value);
    var Tarjetas = parseFloat(document.getElementById('Tarjetas').value);
    var Cheque = parseFloat(document.getElementById('Cheque').value);
    var Otros = parseFloat(document.getElementById('Otros').value);
    var Devuelta = parseFloat(document.getElementById('Devuelta').value);
    var CmbFormaPago = document.getElementById('CmbFormaPago').value;
    var CmbColaboradores = document.getElementById('CmbColaboradores').value;
    var CmbPrint = document.getElementById('CmbPrint').value;
    var TxtObservacionesFactura = document.getElementById('TxtObservacionesFactura').value;
    var AnticiposCruzados = parseFloat(document.getElementById('AnticiposCruzados').value);
    var TxtTotalFactura = parseFloat(document.getElementById('TxtTotalFactura').value);
    var TxtTotalAnticipos = parseFloat(document.getElementById('TxtTotalAnticiposFactura').value);
    var idCliente = (document.getElementById('idCliente').value);
    
    if(!$.isNumeric(Devuelta) ||  Devuelta<0){
        
        alertify.alert("La suma de las formas de pago debe ser mayor o igual al total de la factura");
        document.getElementById("Efectivo").style.backgroundColor="pink";
        document.getElementById("BntModalPOS").disabled=false;
        return;
    }else{
        document.getElementById("Efectivo").style.backgroundColor="white";
    }
    
    if(!$.isNumeric(Efectivo) ||  Efectivo<0){
        
        alertify.alert("El campo Efectivo debe ser un número mayor o igual a cero");
        document.getElementById("Efectivo").style.backgroundColor="pink";
        document.getElementById("BntModalPOS").disabled=false;
        return;
    }else{
        document.getElementById("Efectivo").style.backgroundColor="white";
    }
    
    if(!$.isNumeric(Tarjetas) ||  Tarjetas<0){
        
        alertify.alert("El campo Tarjetas debe ser un número mayor o igual a cero");
        document.getElementById("Tarjetas").style.backgroundColor="pink";
        document.getElementById("BntModalPOS").disabled=false;
        return;
    }else{
        document.getElementById("Tarjetas").style.backgroundColor="white";
    }
    
    if(!$.isNumeric(Cheque) ||  Cheque<0){
        
        alertify.alert("El campo Cheques debe ser un número mayor o igual a cero");
        document.getElementById("Cheque").style.backgroundColor="pink";
        document.getElementById("BntModalPOS").disabled=false;
        return;
    }else{
        document.getElementById("Cheque").style.backgroundColor="white";
    }
    
    if(!$.isNumeric(Otros) ||  Otros<0){
        
        alertify.alert("El campo Otros debe ser un número mayor o igual a cero");
        document.getElementById("Otros").style.backgroundColor="pink";
        document.getElementById("BntModalPOS").disabled=false;
        return;
    }else{
        document.getElementById("Otros").style.backgroundColor="white";
    }
    
    
    if(!$.isNumeric(AnticiposCruzados) ||  AnticiposCruzados<0){
        
        alertify.alert("El Anticipo debe ser un número mayor o igual a cero");
        document.getElementById("AnticiposCruzados").style.backgroundColor="pink";
        document.getElementById("BntModalPOS").disabled=false;
        return;
    }else{
        document.getElementById("AnticiposCruzados").style.backgroundColor="white";
    }
    
    if(TxtTotalAnticipos < AnticiposCruzados){
        
        alertify.alert("El Anticipo no puede ser mayor al total de anticipos realizados por el Cliente");
        document.getElementById("AnticiposCruzados").style.backgroundColor="pink";
        document.getElementById("BntModalPOS").disabled=false;
        return;
    }else{
        document.getElementById("AnticiposCruzados").style.backgroundColor="white";
    }
    
    if( AnticiposCruzados > TxtTotalFactura){
        alertify.alert("El Anticipo no puede ser mayor al total de la Factura");
        document.getElementById("AnticiposCruzados").style.backgroundColor="pink";
        document.getElementById("BntModalPOS").disabled=false;
        return;
    }else{
        document.getElementById("AnticiposCruzados").style.backgroundColor="white";
    }
    
    
    var form_data = new FormData();
        form_data.append('Accion', '7'); 
        form_data.append('idPreventa', idPreventa);
        form_data.append('Efectivo', Efectivo );
        form_data.append('Tarjetas', Tarjetas );
        form_data.append('Cheque', Cheque );
        form_data.append('Otros', Otros );
        form_data.append('Devuelta', Devuelta);
        form_data.append('CmbFormaPago', CmbFormaPago);
        form_data.append('CmbColaboradores', CmbColaboradores);
        form_data.append('TxtObservacionesFactura', TxtObservacionesFactura);
        form_data.append('idCliente', idCliente);        
        form_data.append('AnticiposCruzados', AnticiposCruzados);
        form_data.append('CmbPrint', CmbPrint);
        AnticiposCruzados=0;
        $.ajax({
        url: './procesadores/pos.process.php',
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
                //alertify.alert(mensaje);
                document.getElementById("DivMensajesModulo").innerHTML=mensaje;
                CierraModal('ModalAccionesPOS');
                document.getElementById("BntModalPOS").disabled=false;
                document.getElementById("BntModalPOS").value="Guardar";
                document.getElementById("idCliente").value=1;
                document.getElementById("select2-idCliente-container").innerHTML="Clientes Varios";
                DibujePreventa();
                posiciona('Codigo');
                
            }else if(respuestas[0]=="E1"){
                alertify.error("Error: La Resolución seleccionada ya está Completada",0);
                document.getElementById("BntModalPOS").disabled=false;
                document.getElementById("BntModalPOS").value="Guardar";
            }else if(respuestas[0]=="E2"){
                alertify.error("Error: La Resolución seleccionada Está Ocupada, intentelo nuevamente",0);
                document.getElementById("BntModalPOS").disabled=false;  
                document.getElementById("BntModalPOS").value="Guardar";
            }else if(respuestas[0]=="E3"){
                alertify.error("Error: El Cliente ya no cuenta con el saldo en anticipos escrito",0);
                document.getElementById("BntModalPOS").disabled=false;  
                document.getElementById("BntModalPOS").value="Guardar";    
            }else{
                alertify.alert("Error: <br>"+data);
                document.getElementById("BntModalPOS").disabled=false;
                document.getElementById("BntModalPOS").value="Guardar";
            }
            
            
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            document.getElementById("BntModalPOS").disabled=false;
            document.getElementById("BntModalPOS").value="Guardar";
            alert(xhr.status);
            alert(thrownError);
          }
      });
    
    
}
/**
 * Crea y guarda una cotizacion a partir de una preventa
 * @returns {undefined}
 */
function CotizarPOS(){
    
    
    var idPreventa=document.getElementById('idPreventa').value;
    var idCliente=document.getElementById('idCliente').value;
    var form_data = new FormData();
        
        form_data.append('Accion', 8);
        form_data.append('idPreventa', idPreventa);
        form_data.append('idCliente', idCliente);
        $.ajax({
        url: './procesadores/pos.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivMensajesModulo').innerHTML=data;
            document.getElementById("idCliente").value=1;
            document.getElementById("select2-idCliente-container").innerHTML="Clientes Varios";
            DibujePreventa();
            posiciona('Codigo');           
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}  

/**
 * Autoriza una preventa
 * @returns {undefined}
 */
function AutorizarPreventa(){
    
    
    var idPreventa=document.getElementById('idPreventa').value;
    var TxtAutorizaciones=document.getElementById('TxtAutorizaciones').value;
    var form_data = new FormData();
        
        form_data.append('Accion', 9);
        form_data.append('idPreventa', idPreventa);
        form_data.append('TxtAutorizaciones', TxtAutorizaciones);
        document.getElementById("TxtAutorizaciones").value='';
        $.ajax({
        url: './procesadores/pos.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';');
            if(respuestas[0]=="E1"){
                alertify.alert(respuestas[1]);
                
            }else if(respuestas[0]=="OK"){
                alertify.success(respuestas[1]);
                
            }else{
                alertify.alert(data);
            }
            
            DibujePreventa();
            posiciona('Codigo');           
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}  
/**
 * Realiza un descuento a mayoristas
 * @returns {undefined}
 */
function PreciosMayoristas(){    
    
    var idPreventa=document.getElementById('idPreventa').value;
    var TxtAutorizaciones=document.getElementById('TxtAutorizaciones').value;
    var form_data = new FormData();
        
        form_data.append('Accion', 10);
        form_data.append('idPreventa', idPreventa);
        form_data.append('TxtAutorizaciones', TxtAutorizaciones);
        document.getElementById("TxtAutorizaciones").value='';
        $.ajax({
        url: './procesadores/pos.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';');
            if(respuestas[0]=="E1"){
                alertify.alert(respuestas[1]);
                
            }else if(respuestas[0]=="OK"){
                alertify.success(respuestas[1]);
                
            }else{
                alertify.alert(data);
            }
            
            DibujePreventa();
            posiciona('Codigo');           
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}  
/**
 * Abre un modal con las opciones para las autorizaciones de un POS
 * @returns {undefined}
 */
function AbrirModalAutorizacionesPOS(){
    
    $("#ModalAccionesPOSSmall").modal();
    
    document.getElementById("BntModalPOSSmall").disabled=true;
    
    var idPreventa=document.getElementById('idPreventa').value;
    var idCliente=document.getElementById('idCliente').value;
    var form_data = new FormData();
        
        form_data.append('Accion', 7);
        form_data.append('idPreventa', idPreventa);
        form_data.append('idCliente', idCliente);
        $.ajax({
        url: './Consultas/pos.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivFrmPOSSmall').innerHTML=data;
                    
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}  
/**
 * Realiza un descuento por porcentaje
 * @returns {undefined}
 */
function DescuentoPorcentaje(){    
    
    var idPreventa=document.getElementById('idPreventa').value;
    var TxtAutorizaciones=document.getElementById('TxtAutorizaciones').value;
    
    var TxtPorcentajeDescuento=document.getElementById('TxtPorcentajeDescuento').value;
    
    
    if(idPreventa==''){        
        alertify.alert("Debe seleccionar una preventa");
        document.getElementById("idPreventa").style.backgroundColor="pink";   
        CierraModal('ModalAccionesPOSSmall');
        return;
    }else{
        document.getElementById("idPreventa").style.backgroundColor="white";
    }
    
    if(TxtPorcentajeDescuento==''){        
        alertify.alert("Debe escribir un porcentaje");
        document.getElementById("TxtPorcentajeDescuento").style.backgroundColor="pink";   
        //CierraModal('ModalAccionesPOSSmall');
        return;
    }else{
        document.getElementById("TxtPorcentajeDescuento").style.backgroundColor="white";
    }
    
    if(TxtAutorizaciones==''){        
        alertify.alert("Debe escribir una Clave");
        document.getElementById("TxtAutorizaciones").style.backgroundColor="pink";   
        CierraModal('ModalAccionesPOSSmall');
        return;
    }else{
        document.getElementById("TxtAutorizaciones").style.backgroundColor="white";
    }
    
    
    var form_data = new FormData();
        
        form_data.append('Accion', 11);
        form_data.append('idPreventa', idPreventa);
        form_data.append('TxtAutorizaciones', TxtAutorizaciones);
        form_data.append('TxtPorcentajeDescuento', TxtPorcentajeDescuento);
        document.getElementById("TxtAutorizaciones").value='';
        $.ajax({
        url: './procesadores/pos.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';');
            if(respuestas[0]=="E1"){
                alertify.alert(respuestas[1]);
                
            }else if(respuestas[0]=="OK"){
                alertify.success(respuestas[1]);
                
            }else{
                alertify.alert(data);
            }
            
            CierraModal('ModalAccionesPOSSmall');
            DibujePreventa();
            posiciona('Codigo');           
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}  

/**
 * Realiza un descuento de acuerdo a lo que se haya escrito
 * @returns {undefined}
 */
function DescuentoListaPrecio(){    
    
    var idPreventa=document.getElementById('idPreventa').value;
    var TxtAutorizaciones=document.getElementById('TxtAutorizaciones').value;
    
    var CmbListaPrecio=document.getElementById('CmbListaPrecio').value;
    
    
    if(idPreventa==''){        
        alertify.alert("Debe seleccionar una preventa");
        document.getElementById("idPreventa").style.backgroundColor="pink";   
        CierraModal('ModalAccionesPOSSmall');
        return;
    }else{
        document.getElementById("idPreventa").style.backgroundColor="white";
    }
    
        
    if(TxtAutorizaciones==''){        
        alertify.alert("Debe escribir una Clave");
        document.getElementById("TxtAutorizaciones").style.backgroundColor="pink";   
        CierraModal('ModalAccionesPOSSmall');
        return;
    }else{
        document.getElementById("TxtAutorizaciones").style.backgroundColor="white";
    }
    
    
    var form_data = new FormData();
        
        form_data.append('Accion', 12);
        form_data.append('idPreventa', idPreventa);
        form_data.append('TxtAutorizaciones', TxtAutorizaciones);
        form_data.append('CmbListaPrecio', CmbListaPrecio);
        document.getElementById("TxtAutorizaciones").value='';
        $.ajax({
        url: './procesadores/pos.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';');
            if(respuestas[0]=="E1"){
                alertify.alert(respuestas[1]);
                
            }else if(respuestas[0]=="OK"){
                alertify.success(respuestas[1]);
                
            }else{
                alertify.alert(data);
            }
            
            CierraModal('ModalAccionesPOSSmall');
            DibujePreventa();
            posiciona('Codigo');           
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}  
/**
 * REaliza un descuento a precio de costo
 * @returns {undefined}
 */
function DescuentoCosto(){    
    
    var idPreventa=document.getElementById('idPreventa').value;
    var TxtAutorizaciones=document.getElementById('TxtAutorizaciones').value;
    
    if(idPreventa==''){        
        alertify.alert("Debe seleccionar una preventa");
        document.getElementById("idPreventa").style.backgroundColor="pink";   
        CierraModal('ModalAccionesPOSSmall');
        return;
    }else{
        document.getElementById("idPreventa").style.backgroundColor="white";
    }
    
        
    if(TxtAutorizaciones==''){        
        alertify.alert("Debe escribir una Clave");
        document.getElementById("TxtAutorizaciones").style.backgroundColor="pink";   
        CierraModal('ModalAccionesPOSSmall');
        return;
    }else{
        document.getElementById("TxtAutorizaciones").style.backgroundColor="white";
    }
    
    
    var form_data = new FormData();
        
        form_data.append('Accion', 13);
        form_data.append('idPreventa', idPreventa);
        form_data.append('TxtAutorizaciones', TxtAutorizaciones);
        
        document.getElementById("TxtAutorizaciones").value='';
        $.ajax({
        url: './procesadores/pos.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';');
            if(respuestas[0]=="E1"){
                alertify.alert(respuestas[1]);
                
            }else if(respuestas[0]=="OK"){
                alertify.success(respuestas[1]);
                
            }else{
                alertify.alert(data);
            }
            
            CierraModal('ModalAccionesPOSSmall');
            DibujePreventa();
            posiciona('Codigo');           
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}  

/**
 * Cierra el turno
 * @returns {undefined}
 */
function CerrarTurno(){    
    document.getElementById("BtnCerrarTurno").disabled=true;
    document.getElementById("BtnCerrarTurno").value="Cerrando Turno...";
    var form_data = new FormData();
        
        form_data.append('Accion', 14);
               
        $.ajax({
        url: './procesadores/pos.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';');
            if(respuestas[0]=="E1"){
                alertify.alert(respuestas[1]);
                
            }else if(respuestas[0]=="OK"){
                alertify.alert(respuestas[1]);
                document.getElementById("BtnCerrarTurno").disabled=false;
                document.getElementById("BtnCerrarTurno").value="Cerrar Turno";
            }else{
                alertify.alert(data);
            }
            
            posiciona('Codigo');           
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}  
/**
 * Cambia el precio de venta a mayorista si el codigo que se digite está asociado a un cliente
 * @returns {undefined}
 */
function CodigoTarjeta(){
    var idPreventa=document.getElementById('idPreventa').value;
    var CodigoTarjeta=document.getElementById('CodigoTarjeta').value;
    
    if(idPreventa==''){        
        alertify.alert("Debe seleccionar una preventa");
        document.getElementById("idPreventa").style.backgroundColor="pink";   
        document.getElementById("CodigoTarjeta").value='';
        return;
    }else{
        document.getElementById("idPreventa").style.backgroundColor="white";
    }
    
        
    if(CodigoTarjeta==''){        
        alertify.alert("Debe escribir una Clave");
        document.getElementById("CodigoTarjeta").style.backgroundColor="pink";   
        
        return;
    }else{
        document.getElementById("CodigoTarjeta").style.backgroundColor="white";
    }
    
    
    var form_data = new FormData();
        
        form_data.append('Accion', 15);
        form_data.append('idPreventa', idPreventa);
        form_data.append('CodigoTarjeta', CodigoTarjeta);
        
        document.getElementById("CodigoTarjeta").value='';
        $.ajax({
        url: './procesadores/pos.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';');
            console.log(data);
            if(respuestas[0]=="E1"){
                alertify.alert(respuestas[1]);
                
            }else if(respuestas[0]=="OK"){
                
                               
                var x = document.getElementById("idCliente");
                  var option = document.createElement("option");
                  option.text = respuestas[3];
                  option.value = respuestas[2];

                  x.add(option); 
                  $("#idCliente option:last").attr('selected','selected');
                
                alertify.success(respuestas[1]+" al Cliente "+respuestas[3]);
                
            }else{
                alertify.alert(data);
            }
            
            DibujePreventa();
            posiciona('Codigo');           
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}
/**
 * Abre el modal para crear un tercero
 * @returns {undefined}
 */
function ModalCrearTercero(){
    $("#ModalAccionesPOS").modal();
    
    var form_data = new FormData();
        
        form_data.append('Accion', 8);
        
        $.ajax({
        url: './Consultas/pos.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivFrmPOS').innerHTML=data;
            $('#CodigoMunicipio').select2();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}


atajosPOS();
ConvertirSelectBusquedas();
document.getElementById("BtnMuestraMenuLateral").click();
$('#CmbBusquedaItems').bind('change', function() {
    
    document.getElementById('Codigo').value = document.getElementById('CmbBusquedaItems').value;
    
    
});

$('#CmbListado').bind('change', function() {
    
    ConvertirSelectBusquedas();
    if(document.getElementById("CmbListado").value==5){
        ModoBacula();
    }
});

