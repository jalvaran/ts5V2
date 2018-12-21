
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

$('#idInsumo').select2({

placeholder: 'Buscar Insumo',
ajax: {
  url: './buscadores/insumos.search.php',
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

$('#idProductoReceta').select2({

placeholder: 'Buscar Producto a agregar en esta receta',
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
function AgregaInsumo(){
    var idProducto = document.getElementById('idProducto').value;
    var idInsumo = document.getElementById('idInsumo').value;
    
    if(idProducto==''){
        alertify.alert("Debe seleccionar un producto a construir");
        
        document.getElementById('select2-idProducto-container').style.backgroundColor="pink";
        return;
    }else{
        
        document.getElementById('select2-idProducto-container').style.backgroundColor="";
    }
    
    if(idInsumo==''){
        alertify.alert("Debe seleccionar un insumo para agregar a la receta");
        
        document.getElementById('select2-idInsumo-container').style.backgroundColor="pink";
        return;
    }else{
        
        document.getElementById('select2-idInsumo-container').style.backgroundColor="";
    }
   
    var Cantidad = parseFloat(document.getElementById('TxtCantidadInsumo').value);
    if(isNaN(Cantidad) ){
        alertify.alert("La cantidad digitada No es un número, por favor digite un número válido");
        document.getElementById('TxtCantidadInsumo').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('TxtCantidadInsumo').style.backgroundColor="white";
    }
    
    
    
    var form_data = new FormData();
        form_data.append('idProducto', idProducto)  
        form_data.append('idInsumo', idInsumo)       
        form_data.append('Cantidad', Cantidad)
        form_data.append('idAccion', 1)
        $.ajax({
        url: 'procesadores/CrearReceta.process.php',
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
                DibujeItemsReceta();                
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
 * Agrega un item a un traslado desde un codigo de barras
 */
function AgregaServicio(){
    var idProducto = document.getElementById('idProducto').value;
    var idServicio = document.getElementById('idServicio').value;
    
    if(idProducto==''){
        alertify.alert("Debe seleccionar un producto a construir");
        
        document.getElementById('select2-idProducto-container').style.backgroundColor="pink";
        return;
    }else{
        
        document.getElementById('select2-idProducto-container').style.backgroundColor="";
    }
    
    if(idServicio==''){
        alertify.alert("Debe seleccionar un servicio para agregar a la receta");
        
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
        form_data.append('idProducto', idProducto)  
        form_data.append('idServicio', idServicio)       
        form_data.append('Cantidad', Cantidad)
        form_data.append('idAccion', 4)
        $.ajax({
        url: 'procesadores/CrearReceta.process.php',
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
                DibujeItemsReceta();                
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
 * Agrega un producto
 */
function AgregaProducto(){
    var idProducto = document.getElementById('idProducto').value;
    var idProductoReceta = document.getElementById('idProductoReceta').value;
    
    if(idProducto==''){
        alertify.alert("Debe seleccionar un producto a construir");
        
        document.getElementById('select2-idProducto-container').style.backgroundColor="pink";
        return;
    }else{
        
        document.getElementById('select2-idProducto-container').style.backgroundColor="";
    }
    
    if(idProductoReceta==''){
        alertify.alert("Debe seleccionar un servicio para agregar a la receta");
        
        document.getElementById('select2-idProductoReceta-container').style.backgroundColor="pink";
        return;
    }else{
        
        document.getElementById('select2-idProductoReceta-container').style.backgroundColor="";
    }
    
    if(idProductoReceta==idProducto){
        alertify.alert("Debe seleccionar un producto diferente al que está creando");
        return;
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
        form_data.append('idProducto', idProducto)  
        form_data.append('idProductoReceta', idProductoReceta)       
        form_data.append('Cantidad', Cantidad)
        form_data.append('idAccion', 5)
        $.ajax({
        url: 'procesadores/CrearReceta.process.php',
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
                DibujeItemsReceta();                
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


function DibujeItemsReceta(){
    
    var idProducto = document.getElementById('idProducto').value;
    if(idProducto==''){
        alertify.alert("Debe seleccionar un producto");        
        document.getElementById('select2-idProducto-container').style.backgroundColor="pink";
        return;
    }
    var form_data = new FormData();
        form_data.append('idProducto', idProducto)        
        form_data.append('idAccion', 2)
        $.ajax({
        url: 'procesadores/CrearReceta.process.php',
        //dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
            document.getElementById('DivItemsRecetas').innerHTML =data;   
            
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
}



/**
 * Editar un item
 * @param {type} idItem
 * @returns {undefined}
 */
function EditarItem(idItem){
    var idCajaCantidad="TxtCantidad_"+idItem;
    var Cantidad = parseFloat(document.getElementById(idCajaCantidad).value);
    if(isNaN(Cantidad) ){
        alertify.alert("La cantidad digitada No es un número, por favor digite un número válido");
        document.getElementById(idCajaCantidad).style.backgroundColor="pink";
        return;
    }else{
        document.getElementById(idCajaCantidad).style.backgroundColor="white";
    }
    var form_data = new FormData();
        form_data.append('idItem', idItem)   
        form_data.append('Cantidad', Cantidad)   
        form_data.append('idAccion', 3)
        $.ajax({
        url: 'procesadores/CrearReceta.process.php',
        //dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
            if(data=="OK"){
                alertify.success("Item Editado");
                DibujeItemsReceta();
            }else{
                document.getElementById('DivMensajes').innerHTML=data;
                alertify.error("El item no pudo ser editado");
                DibujeItemsReceta();
            }
            
            
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
}


/**
 * Crear un producto
 * @param {type} idItem
 * @returns {undefined}
 */
function CrearProductoDesdeReceta(idProducto){
    document.getElementById('BtnCrearProducto').value="Creando...";
    document.getElementById('BtnCrearProducto').disabled=true;
    var Cantidad = parseFloat(document.getElementById('TxtCantidadCrear').value);
    if(isNaN(Cantidad) ){
        alertify.alert("La cantidad digitada No es un número, por favor digite un número válido");
        document.getElementById('TxtCantidadCrear').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('TxtCantidadCrear').style.backgroundColor="white";
    }
    var form_data = new FormData();
        form_data.append('idProducto', idProducto)   
        form_data.append('Cantidad', Cantidad)   
        form_data.append('idAccion', 6)
        $.ajax({
        url: 'procesadores/CrearReceta.process.php',
        //dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
            if(data=="OK"){
                alertify.success("Producto Fabricado");
                DibujeItemsReceta();
                
            }else{
                document.getElementById('DivMensajes').innerHTML=data;
                alertify.error("El item no pudo ser fabricado");
                DibujeItemsReceta();
            }
            
            
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
}
