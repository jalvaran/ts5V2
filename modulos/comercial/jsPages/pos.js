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
            alertify.error(data);
            DibujePreventa();
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
}
