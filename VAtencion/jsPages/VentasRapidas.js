// Solo permite ingresar numeros.

function CampoNumerico(e){
    //var no_digito = /\D/g;
    //this.value = this.value.replace(no_digito , '');
    
    var key = window.Event ? e.which : e.keyCode
    //console.log(key)
    return ((key >= 48 && key <= 57) || (key >= 0 && key <= 31) || key == 127)

}

function FacturarItemSeparado(idItemSeparado,TotalAbonos,CantidadMaxima,ValorUnitario){
    var idCuadroCantidad='TxtCantidadItemSeparado_'+idItemSeparado
    var Cantidad = parseFloat(document.getElementById(idCuadroCantidad).value);
    var Total=Cantidad*ValorUnitario;
    
    if(isNaN(Cantidad) ){
        alertify.alert("La cantidad digitada No es un número");
        return;
    }
    if(Cantidad<=0){
        alertify.alert("La cantidad digitada debe ser mayor a Cero");
        return;
    }
    if(Cantidad>CantidadMaxima){
        alertify.alert("La cantidad digitada es mayor a la disponible en el separado");
        return;
    }
     if(TotalAbonos<Total){
        alertify.alert("El total de los abonos ("+TotalAbonos+"), de este separado debe superar el valor del item ("+Total+")");
        return;
    }   
    alertify.confirm("Está seguro que desea Facturar este item?",
    function (e) {
        if (e) {
            document.getElementById("DivBusquedas").innerHTML='<div id="GifProcess">Procesando...<br><img   src="../images/cargando.gif" alt="Cargando" height="100" width="100"></div>';
  
            var form_data = new FormData();       
                form_data.append('idAccion', 1);//facturar un item
                form_data.append('idItemSeparado', idItemSeparado);
                form_data.append('Cantidad', Cantidad);
                $.ajax({
                //async:false,
                url: 'Consultas/Separados.process.php',
                //dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(data){
                    document.getElementById("DivBusquedas").innerHTML='';
                    console.log(data);
                    if (data == "OK") { 
                        alertify.success("Factura Creada");
                    }else{
                        alertify.alert("Error ".data);
                    }

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert("Error ",0);
                    alert(xhr.status);
                    alert(thrownError);
                  }
              });
            
        }else{
            
            alertify.error("Acción cancelada");

        }
    });
    
    /*
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
      
    */
    
}
