
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
            
/**
 * Agrega un item a un traslado desde un codigo de barras
 */
function AgregaItem(Opcion=1){
    
    //e.preventDefault();
    //se crea un objeto con los datos del formulario
    var form_data = new FormData();
        form_data.append('idTraslado', $('#TxtIdCC').val())
        if(Opcion==1){
            form_data.append('TxtCodigo', $('#TxtCodigo').val())
        }else{
            form_data.append('TxtCodigo', $('#idProducto').val()) 
        }
        
        form_data.append('TxtCantidad', $('#TxtCantidad').val())
        form_data.append('idAccion', 1)
        $.ajax({
        url: 'procesadores/CrearTraslado2.process.php',
        //dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
            //console.log(data);
            if(data=='OK'){
                alertify.success("Producto Agregado");    
                document.getElementById('TxtCodigo').value ='';
                document.getElementById('TxtCantidad').value =1;
                DibujeItemsTraslado($('#TxtIdCC').val());                
            }else if(data=='E1'){
                alertify.error("El producto no existe");                  
                DibujeItemsTraslado($('#TxtIdCC').val());  
            }else{
                alertify.error("No se recibió la respuesta esperada"); 
                document.getElementById('DivMensajes').innerHTML =data;
            }
           
            
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
}


function DibujeItemsTraslado(idTraslado){
    var form_data = new FormData();
        form_data.append('idTraslado', $('#TxtIdCC').val())        
        form_data.append('idAccion', 2)
        $.ajax({
        url: 'procesadores/CrearTraslado2.process.php',
        //dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
            document.getElementById('DivItemsTraslados').innerHTML =data;   
            
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
}

/**
 * Guardar traslado
 * @param {type} idTraslado
 * @returns {undefined}
 */
function GuardarTraslado(idTraslado){
    document.getElementById('DivItemsTraslados').innerHTML ='<br><img src="../images/cargando.gif" alt="Cargando" height="100" width="100">'; 
    var idTraslado = $('#TxtIdCC').val();
    var form_data = new FormData();
        form_data.append('idTraslado', $('#TxtIdCC').val())        
        form_data.append('idAccion', 3)
        $.ajax({
        url: 'procesadores/CrearTraslado2.process.php',
        //dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
            console.log(data);
            if(data == idTraslado){
                var ruta = '<strong>Comprobante'+idTraslado+' Creado correctamente <a href="../tcpdf/examples/imprimirTraslado.php?idTraslado='+idTraslado+'" target="_blank">Imprimir</strong>';
               document.getElementById('DivItemsTraslados').innerHTML =ruta; 
               document.getElementById('DivDatosItemTraslado').innerHTML ='';
            }else{
               document.getElementById('DivItemsTraslados').innerHTML =data;  
            }
              
            
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
}

/**
 * Borrar un item del traslado
 * @param {type} idItem
 * @returns {undefined}
 */
function BorrarItem(idItem){
    var idTraslado=$('#TxtIdCC').val();
    var form_data = new FormData();
        form_data.append('idItem', idItem)      
        form_data.append('idAccion', 4)
        $.ajax({
        url: 'procesadores/CrearTraslado2.process.php',
        //dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
            if(data=='OK'){
                alertify.success("Item Borrado");
                DibujeItemsTraslado(idTraslado);
            }else{
                document.getElementById('DivItemsTraslados').innerHTML =data;
            }
            
            
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
}
