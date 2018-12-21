function reset () {
    $("#toggleCSS").attr("href", "alertify/themes/alertify.default.css");
    alertify.set({
            labels : {
                    ok     : "OK",
                    cancel : "Cancel"
            },
            delay : 5000,
            buttonReverse : false,
            buttonFocus   : "ok"
    });
}

var TimerPedidos;
var TimerDomicilios;
var TimerItems;
var TimerLlevar;
function AutocompleteDatos(){
    //se crea un objeto con los datos del formulario
    var form_data = new FormData();
        form_data.append('Telefono', $('#Telefono').val())
                
        $.ajax({
        url: 'Consultas/BuscarDatosPedidos.php',
        dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
            console.log(data)
            
            if(data.TelefonoConfirmacion){
                document.getElementById('Nombre').value=data.NombreCliente;
                document.getElementById('Direccion').value=data.DireccionEnvio;
                //document.getElementById('Observaciones').value=data.Observaciones;
                
            }
            
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
}

//Funcion para cargar los productos al select de los productos 
function CargarProductos(){
    
    var form_data = new FormData();
        form_data.append('idDepartamento', $('#idDepartamento').val())
                
        $.ajax({
        url: 'Consultas/BuscarDatosPedidos.php',
        dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
             console.log(data);
             
             if(data.msg=="Todos"){
                $('#idProducto').select2({
		  
                placeholder: 'Buscar Producto',
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
            }
             
            if(data[0].ID){
                  $("#idProducto").empty();
                for(i=0;i < data.length; i++){
                    
                    $("#idProducto").append('<option value='+data[i].ID+'>'+data[i].Nombre+'</option>');
                 
                }
                             
            }
            
            
            
            
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
}

//funcion para Crear un Pedido
function AgregarItemPedido(idPedido=''){
    if($('#idMesa').val()<1){
        alertify.alert("Debe seleccionar una mesa");
        return;
    }
    //e.preventDefault();
    //se crea un objeto con los datos del formulario
    var form_data = new FormData();
        form_data.append('idMesa', $('#idMesa').val())
        form_data.append('idPedido', idPedido)
        form_data.append('idDepartamento', $('#idDepartamento').val()) 
        form_data.append('Cantidad', $('#Cantidad').val())
        form_data.append('idProducto', $('#idProducto').val())
        form_data.append('Observaciones', $('#Observaciones').val())
        $.ajax({
        url: 'Consultas/Restaurante.process.php',
        dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
            //console.log(data);
            
            if(data.msg==='OK'){
                alertify.success("Se agregó un producto");   
                document.getElementById("Observaciones").value="";
                if(idPedido==""){
                    DibujeItemsPedido(data.idPedido,1);
                    
                }
                
            }
            
            if(data.msg==='SD'){
                alertify.alert("Debes completar todos los campos");   
                //alert("Debes completar todos los campos");
                //DibujePedidos();
            }
            
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
}

//Crear un domicilio

function CrearDomicilio(){
    
    //e.preventDefault();
    if($('#Telefono').val()=='' || $('#Nombre').val()=='' || $('#Direccion').val()==''){
        alertify.alert("Debes completar todos los campos");        
        return;
    }
    //se crea un objeto con los datos del formulario
    var form_data = new FormData();
        form_data.append('Accion', "ADD_DOM")
        form_data.append('Telefono', $('#Telefono').val())
        form_data.append('Nombre', $('#Nombre').val())
        form_data.append('Direccion', $('#Direccion').val()) 
        form_data.append('Observaciones', $('#TxtObservaciones').val())
        
        $.ajax({
        url: 'Consultas/Restaurante.process.php',
        dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
            //console.log(data);
            
            if(data.msg==='OK'){
                console.log("Domicilio creado");
                DibujeItemsPedido(data.idPedido,1);
                
                
            }
            
            if(data.msg==='SD'){
                alertify.alert("Debes completar todos los campos");
                //DibujePedidos();
            }
            
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
}

//Crear un domicilio

function CrearParaLlevar(){
    
    //e.preventDefault();
    if($('#Telefono').val()=='' || $('#Nombre').val()=='' || $('#Direccion').val()==''){
        alertify.alert("Debes completar todos los campos");
        return;
    }
    //se crea un objeto con los datos del formulario
    var form_data = new FormData();
        form_data.append('Accion', "ADD_LLE")
        form_data.append('Telefono', $('#Telefono').val())
        form_data.append('Nombre', $('#Nombre').val())
        form_data.append('Direccion', $('#Direccion').val()) 
        form_data.append('Observaciones', $('#TxtObservaciones').val())
        
        $.ajax({
        url: 'Consultas/Restaurante.process.php',
        dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
            //console.log(data);
            
            if(data.msg==='OK'){
                console.log("Servicio Para llevar creado");
                DibujeItemsPedido(data.idPedido,1);
                
                
            }
            
            if(data.msg==='SD'){
                alertify.alert("Debes completar todos los campos");
                //DibujePedidos();
            }
            
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
}


//Funcion para dibujar los items de los pedidos en el div correspondiente
function DibujeItemsPedido(idPedido,Opciones=1,Div='DivPedidos'){
    if(Opciones==1){
        document.getElementById('DivPedidos').innerHTML ='<br><img src="../images/cargando.gif" alt="Cargando" height="100" width="100">';
    
    }
    clearInterval(TimerItems);
   // Page="Consultas/Restaurante_pedidos_items.query.php?idPedido="+idPedido+"&Opciones="+Opciones+"&Carry=";
   // EnvieObjetoConsulta(Page,`BtnPedidos`,Div,`99`);
    
    function TimerItemsPedido(){
        
        var form_data = new FormData();
            form_data.append('idPedido', idPedido);
            form_data.append('Opciones', Opciones);
           
        $.ajax({
        url: 'Consultas/Restaurante_pedidos_items.query.php',
        async:false,
        //dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{            
            document.getElementById(Div).innerHTML =data;
           
                if(Opciones==1){
                    Div="DivItemsConsultas";
                    $('#idProducto').select2();
                    //$('#idDepartamento').select2(); 
                }
                
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
      
      Opciones=0;
        
    }
    
    TimerItems =  setInterval(TimerItemsPedido, 1000);
    
    clearInterval(TimerPedidos);
    clearInterval(TimerDomicilios);
    clearInterval(TimerLlevar);
}

//Funcion para dibujar los pedidos en el div correspondiente
function DibujePedidos(){
       
    var Div=VerifiqueObjeto('DivPedDom');
    
    if(Div === 1){
        var DivDestino =  'DivPedDom';
        Page="Consultas/Restaurante_pedidos.query.php?TipoPedido=AB&Carry=";
    }
    if(Div === 0){
        
        var DivDestino =  'DivPedidos';
        Page="Consultas/Restaurante_pedidos.query.php?TipoPedido=AB&CuadroAdd=1&Carry=";
    }
    //Page="Consultas/Restaurante_pedidos.query.php?TipoPedido=AB&Carry=";
    EnvieObjetoConsulta(Page,`BtnPedidos`,DivDestino,`99`);return false;
    
}



//Funcion para dibujar los domicilios en el div correspondiente
function DibujeDomicilios(){
    var Div=VerifiqueObjeto('DivPedDom');
    
    if(Div === 1){
        var DivDestino =  'DivPedDom';
        Page="Consultas/Restaurante_pedidos.query.php?TipoPedido=DO&Carry=";
    }
    if(Div === 0){
        var DivDestino =  'DivPedidos';
        Page="Consultas/Restaurante_pedidos.query.php?TipoPedido=DO&CuadroAdd=1&Carry=";
    }
    
    EnvieObjetoConsulta(Page,`BtnPedidos`,DivDestino,`99`);return false;
}

//Funcion para dibujar los pedidos para llevar en el div correspondiente
function DibujeLlevar(){
    var Div=VerifiqueObjeto('DivPedDom');
    
    if(Div === 1){
        var DivDestino =  'DivPedDom';
        Page="Consultas/Restaurante_pedidos.query.php?TipoPedido=LL&Carry=";
    }
    if(Div === 0){
        var DivDestino =  'DivPedidos';
        Page="Consultas/Restaurante_pedidos.query.php?TipoPedido=LL&CuadroAdd=1&Carry=";
    }
    
    EnvieObjetoConsulta(Page,`BtnPedidos`,DivDestino,`99`);return false;
}

//Funcion para dibujar el area de facturacion en el div correspondiente
function DibujeAreaFacturar(idPedido){
    var Div=VerifiqueObjeto('DivFacturacion');
    document.getElementById('BtnAbreModalFact').click();
    if(Div === 1){
        /*
        var DivDestino =  'DivFacturacion';
        Page="Consultas/Restaurante_facturar.query.php?idPedido="+idPedido+"&Carry=";
        EnvieObjetoConsulta(Page,`BtnPedidos`,DivDestino,`99`);return false;
        */
        
        var form_data = new FormData();
        form_data.append('idPedido', idPedido);
        
        $.ajax({
        url: './Consultas/Restaurante_facturar.query.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            console.log(data)
          if (data != "") { 
              document.getElementById('DivFacturacion').innerHTML=data;
              $('#idCliente').select2({
		  
                placeholder: 'Selecciona un Cliente',
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
    
    
}

function TimersPedidos(idTimer,idPedido=0){
    //Timer para dibujar Pedidos
    if(idTimer===1){
        clearInterval(TimerPedidos);
        clearInterval(TimerDomicilios);
        clearInterval(TimerItems);
        clearInterval(TimerLlevar);
        TimerPedidos = setInterval(DibujePedidos, 1000);
    }
    //Timer para dibujar Domicilios
    if(idTimer===2){
        clearInterval(TimerPedidos);
        clearInterval(TimerDomicilios);
        clearInterval(TimerItems);
        clearInterval(TimerLlevar);
        TimerDomicilios = setInterval(DibujeDomicilios, 1000);
    }
    
    //Timer para dibujar para llevar
    if(idTimer===3){
        clearInterval(TimerPedidos);
        clearInterval(TimerDomicilios);
        clearInterval(TimerItems);
        clearInterval(TimerLlevar);
        TimerLlevar = setInterval(DibujeLlevar, 1000);
    }
    
    //Apago todos los timers
    if(idTimer===99){
        clearInterval(TimerPedidos);
        clearInterval(TimerDomicilios);
        clearInterval(TimerItems);
        clearInterval(TimerLlevar);
    }
}

//Verifica la existencia de un objeto
function VerifiqueObjeto(id){
    var Existe=1;
    if(document.getElementById(id)== undefined){
        Existe=0;
    }
    return (Existe);
}
function ObservacionesEliminarItemPedido(idItem,idPedido){
    alertify.prompt("Escriba el por qué eliminará este item", function (e, str) {
            if (e) {
                    if (str != '') {
                    EliminarItemPedido(idItem,idPedido,str)
                    }else{
                       alertify.alert("Debes Escribir una observacion"); 
                    }
                    //alertify.success("You've clicked OK and typed: " + str);
            } else {
                    alertify.error("haz cancelado la accion");
            }
    }, "");
    return false;
}
//Eliminar un item de un pedido
function EliminarItemPedido(idItem,idPedido,Observaciones){
    //var Observaciones = prompt("por favor indicar el por qué se eliminará el item", "");
    if (Observaciones != '') {
    var form_data = new FormData();
        form_data.append('Accion', "DEL")
        form_data.append('idItem', idItem)
        form_data.append('Observaciones', Observaciones)
        form_data.append('idPedido', idPedido)
        $.ajax({
        url: 'Consultas/Restaurante.process.php',
        dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
            //console.log(data);
            
            if(data.msg==='OK'){
                alertify.success("Se ha eliminado el item "+data.idItem+", del pedido "+data.idPedido+", por: "+data.Observaciones)
            }
                       
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
  }else{
      alertify.alert("Debes Escribir una observacion");
  }
}

function DescartarPedido(idAccion,idPedido){
    alertify.prompt("Escriba por qué descartará el pedido", function (e, str) {
            if (e) {
                     AccionesPedidos(idAccion,idPedido,'',str);
            } else {
                    alertify.error("You've clicked Cancel");
            }
    }, "");
    return false;
}
///Realice acciones como descartar un pedido, imprimir la precuenta, el domicilio y el pedido

function AccionesPedidos(idAccion,idPedido,idFactura='',Observaciones=''){ 
    
    if(idAccion === 1 || idAccion === 2 || idAccion === 3){
        //Observaciones=CapturarObservaciones("Por favor escriba por qué eliminará el pedido");
        //Observaciones = prompt("por favor indicar el por qué se eliminará el item", "");
        if(Observaciones === '' || Observaciones === null || Observaciones === undefined){
            alertify.alert("Debe escribir el por que se descarta el pedido");
            return;
        }
            
    }
    var form_data = new FormData();
        form_data.append('Accion', idAccion);
        form_data.append('Observaciones', Observaciones);
        form_data.append('idPedido', idPedido);
        if(idFactura != ""){
            form_data.append('idFactura', idFactura);
        }
        $.ajax({
        url: 'Consultas/Restaurante.process.php',
        dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
            //console.log(data);
            
            if(data.msg==='OK'){
                if(idAccion===1){
                    alertify.success("Se ha descartado el pedido "+idPedido+", por: "+Observaciones);                    
                    TimersPedidos(1);
                }
                if(idAccion===2){
                    alertify.success("Se ha descartado el Domicilio "+idPedido+", por: "+Observaciones);                    
                    TimersPedidos(2);
                }
                if(idAccion===3){
                    alertify.success("Se ha descartado el servicio para llevar "+idPedido+", por: "+Observaciones);                    
                    TimersPedidos(3);
                }
                if(idAccion===4){
                    alertify.success("Se ha impreso el pedido "+idPedido);                    
                    
                }
                if(idAccion===5){
                    alertify.success("Se ha impreso el domicilio "+idPedido);                   
                    
                }
                if(idAccion===6){
                    alertify.success("Se ha impreso el servicio para llevar "+idPedido);                   
                    
                }
                if(idAccion===7){
                    alertify.success("Precuenta del pedido "+idPedido+" impresa");                    
                    
                }
                if(idAccion===8){
                   alertify.success("Factura Impresa");                   
                    
                }
                if(idAccion===9){
                    alertify.alert("Turno Cerrado");            
                    TimersPedidos(99);
                    document.getElementById('DivPedDom').innerHTML ='Turno Cerrado';
                }
            }
            
            if(data.msg==="SD"){
                alertify.alert("No se recibiron todos los datos");
            }
            
                       
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
  
}
//Facturar pedido
function FacturarPedido(idPedido,Options=0){
    //document.getElementById('BtnAbreModalFact').click();
//event.preventDefault();
    //console.log($('#CmbTipoPago').val());   
    //se crea un objeto con los datos del formulario
    if(Options==0){
    var form_data = new FormData();
        form_data.append('Accion', 8)
        form_data.append('idPedido', idPedido)
        form_data.append('idCliente', $('#idCliente').val())
        form_data.append('TxtTarjetas', $('#TxtTarjetas').val())
        form_data.append('TxtCheques', $('#TxtCheques').val()) 
        form_data.append('TxtBonos', $('#TxtBonos').val())
        form_data.append('CmbTipoPago', $('#CmbTipoPago').val())
        form_data.append('CmbColaboradores', $('#CmbColaboradores').val()) 
        form_data.append('TxtObservaciones', $('#TxtObservacionesFactura').val())
        form_data.append('TxtEfectivo', $('#TxtEfectivo').val()) 
        form_data.append('TxtDevuelta', $('#TxtDevuelta').val())
        form_data.append('TxtPropinaEfectivo', $('#TxtPropinaEfectivo').val()) 
        form_data.append('TxtPropinaTarjetas', $('#TxtPropinaTarjetas').val())
        document.getElementById('DivFacturacion').innerHTML ='Procesando...<br><img src="../images/process.gif" alt="Cargando" height="100" width="100">';
    }
    if(Options==1){
    var form_data = new FormData();
        form_data.append('Accion', 8)
        form_data.append('idPedido', idPedido)
        form_data.append('idCliente', 1)
        form_data.append('TxtTarjetas', 0)
        form_data.append('TxtCheques', 0) 
        form_data.append('TxtBonos', 0)
        form_data.append('CmbTipoPago', 'Contado')
        form_data.append('CmbColaboradores', '') 
        form_data.append('TxtObservaciones', '')
        form_data.append('TxtEfectivo', 'NA') 
        form_data.append('TxtDevuelta', '0')
        form_data.append('TxtPropinaEfectivo', 0) 
        form_data.append('TxtPropinaTarjetas', 0)
        document.getElementById('DivPedidos').innerHTML ='Procesando...<br><img src="../images/process.gif" alt="Cargando" height="100" width="100">';
    }
        $.ajax({
        url: 'Consultas/Restaurante.process.php',
        dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
            //console.log(data);
            
            if(data.msg==='OK'){
                alertify.success("Factura creada");
                //document.getElementById('DivFacturacion').innerHTML ='Factura Creada';
                document.getElementById('BtnCierreModal').click();
                //var DivDestino =  'DivPedDom';
                //Page="Consultas/Restaurante_pedidos.query.php?TipoPedido="+data.TipoPedido+"&CuadroAdd=1&Carry=";
                //EnvieObjetoConsulta(Page,`BtnPedidos`,DivDestino,`99`);
                if(data.TipoPedido=="AB"){
                    document.getElementById('BtnPedidos').click();
                }
                if(data.TipoPedido=="DO"){
                    document.getElementById('BtnDomicilios').click();
                }
                if(data.TipoPedido=="LL"){
                    document.getElementById('BtnLlevar').click();
                }
            }
            
            if(data.msg==='SD'){
                alertify.alert("Debes completar todos los campos");
                //DibujePedidos();
            }
            
            if(data.msg==='E'){
                alertify.alert(data.Error);
                //DibujePedidos();
            }
            
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
}

//calcular la devuelta
function CalculeDevueltaRestaurante(Total){
    var Efectivo=$('#TxtEfectivo').val();
    var Tarjetas=$('#TxtTarjetas').val();
    var Cheques=$('#TxtCheques').val();
    var Bonos=$('#TxtBonos').val();
    var PropinaEfectivo=$('#TxtPropinaEfectivo').val();
    var PropinaTarjetas=$('#TxtPropinaTarjetas').val();
    var TotalPagos=parseInt(Efectivo)+parseInt(Tarjetas)+parseInt(Cheques)+parseInt(Bonos);
    var TotalPropinas=parseInt(PropinaEfectivo)+parseInt(PropinaTarjetas);
    document.getElementById("GranTotalPropinas").value = TotalPropinas;
    document.getElementById("TxtDevuelta").value = TotalPagos-(parseInt(Total)+parseInt(TotalPropinas));
}

//Cerrar Turno

function CerrarTurnoRestaurante(){
    
    AccionesPedidos(9,"",'');
    
}

//Buscar un item

function BuscarItemsRestaurante(){
    
    var Busqueda=document.getElementById('TxtBusquedaItems').value;
    Page="Consultas/Restaurante_buscar_items.query.php?Busqueda="+Busqueda+"&Carry=";
    EnvieObjetoConsulta(Page,`BtnPedidos`,'DivBusquedaItems',`99`);
    document.getElementById("DivBusquedaItems").style.display="block";
    
}
var workerAlertas;

function AlertasTS5(){
    
    
    if(typeof(Worker) !== "undefined") {
        if(typeof(workerAlertas) == "undefined") {
            
            workerAlertas = new Worker("./js/workers/alertasTS51.js");
            //console.log(workerAlertas);
        }
        workerAlertas.onmessage = function(event) {
            var DatosAlertas = JSON.parse(event.data);
            
            console.log(DatosAlertas);
            if(DatosAlertas["msg"]=="OK"){
                var NumAlertas=parseInt(DatosAlertas.NumItems)+parseInt(1);
                var html="";
                for(i=0;i<=DatosAlertas.NumItems;i++){
                    html=html+DatosAlertas[i].ID+"/";
                }
               
                document.getElementById("TS5_Alertas").innerHTML = NumAlertas;
                if(NumAlertas>0){
                    alertify.error("Tienes notificaciones sin leer");
                    var audio = document.getElementById("audio");                    
                    audio.play();
                }
            }else{
                document.getElementById("TS5_Alertas").innerHTML = "0";
            }
        };
    }else{
        document.getElementById("DivAlertasTS5").innerHTML = "Su navegador no soporta Web Workers...";
    }
    
}

function MostrarNotificaciones(){
    console.log(document.getElementById('spanAlertasTS5').attributes.data.count.notificacion);
    
}


function ModalCliente(){
    document.getElementById('BtnAbreModalFact').click();
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
              document.getElementById('DivFacturacion').innerHTML=data;
              var config = {
              '.chosen-select'           : {},
              '.chosen-select-deselect'  : {allow_single_deselect:true},
              '.chosen-select-no-single' : {disable_search_threshold:10},
              '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
              '.chosen-select-width'     : {width:"200px"}
            }
            for (var selector in config) {
              $(selector).chosen(config[selector]);
            }
            document.getElementById("CmbCodMunicipio_chosen").style.width = "200px"; 
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
              
              //document.getElementById('DivFacturacion').innerHTML="";
              //document.getElementById('BtnAbreModalFact').click();
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

function MostrarPedidos(){
    var Page='Consultas/Restaurante_pedidos.query.php?TipoPedido=AB&CuadroAdd=1&Carry=';
    var form_data = new FormData();       
        
        form_data.append('TipoPedido', 'AB');
        form_data.append('CuadroAdd', 1);
        $.ajax({
        async:false,
        url: 'Consultas/Restaurante_pedidos.query.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
            if (data != "") { 
            document.getElementById("DivPedidos").innerHTML=data;
            $('#idProducto').select2(); 
            //$('#idDepartamento').select2(); 
        }
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alertify.error("Error al tratar de recuperar los datos de los pedidos",0);
            alert(xhr.status);
            alert(thrownError);
          }
      })
      
    //EnvieObjetoConsulta(Page,`BtnPedidos`,`DivPedidos`,`99`);
    TimersPedidos(1);
    
}
//AlertasTS5();
