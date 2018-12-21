
if ($('#Departamento').length) {
    
    document.getElementById("Departamento").addEventListener("change", BuscaSub1);
    document.getElementById("Sub1").addEventListener("change", BuscaSub2);
    document.getElementById("Sub2").addEventListener("change", BuscaSub3);
    document.getElementById("Sub3").addEventListener("change", BuscaSub4);
    document.getElementById("Sub4").addEventListener("change", BuscaSub6);
    
    
}

function BuscaSub1(){
    var form_data = new FormData();
        form_data.append('idAccion', 1); //1 para validar si existe un codigo eps
        form_data.append('idDepartamento', $('#Departamento').val());
      
    $.ajax({
        
        url: 'buscadores/ClasificacionInventarios.search.php',
        dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
             console.log(data);
             
            if(data[0].ID){
                  $("#Sub1").empty();
                  $("#Sub2").empty();
                  $("#Sub3").empty();
                  $("#Sub4").empty();
                  $("#Sub6").empty();
                  $("#Sub1").append('<option value="">Seleccione una opcion</option>');
                for(i=0;i < data.length; i++){
                    
                    $("#Sub1").append('<option value='+data[i].ID+'>'+data[i].Nombre+'</option>');
                 
                }
                             
            }
            
            
            
            
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
}


function BuscaSub2(){
    var form_data = new FormData();
        form_data.append('idAccion', 2); //1 para validar si existe un codigo eps
        form_data.append('Sub1', $('#Sub1').val());
      
    $.ajax({
        
        url: 'buscadores/ClasificacionInventarios.search.php',
        dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
             console.log(data);
             
            if(data[0].ID){
                  
                  $("#Sub2").empty();
                  $("#Sub3").empty();
                  $("#Sub4").empty();
                  $("#Sub6").empty();
                  $("#Sub2").append('<option value="">Seleccione una opcion</option>');
                for(i=0;i < data.length; i++){
                    
                    $("#Sub2").append('<option value='+data[i].ID+'>'+data[i].Nombre+'</option>');
                 
                }
                             
            }
            
            
            
            
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
}


function BuscaSub3(){
    var form_data = new FormData();
        form_data.append('idAccion', 3); //1 para validar si existe un codigo eps
        form_data.append('Sub2', $('#Sub2').val());
      
    $.ajax({
        
        url: 'buscadores/ClasificacionInventarios.search.php',
        dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
             console.log(data);
             
            if(data[0].ID){
                  
                  $("#Sub3").empty();
                  $("#Sub4").empty();
                  $("#Sub6").empty();
                  $("#Sub3").append('<option value="">Seleccione una opcion</option>');
                for(i=0;i < data.length; i++){
                    
                    $("#Sub3").append('<option value='+data[i].ID+'>'+data[i].Nombre+'</option>');
                 
                }
                             
            }
            
            
            
            
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
}


function BuscaSub4(){
    var form_data = new FormData();
        form_data.append('idAccion', 4); //1 para validar si existe un codigo eps
        form_data.append('Sub3', $('#Sub3').val());
      
    $.ajax({
        
        url: 'buscadores/ClasificacionInventarios.search.php',
        dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
             console.log(data);
             
            if(data[0].ID){
                  
                  $("#Sub4").empty();
                  $("#Sub6").empty();
                  $("#Sub4").append('<option value="">Seleccione una opcion</option>');
                for(i=0;i < data.length; i++){
                    
                    $("#Sub4").append('<option value='+data[i].ID+'>'+data[i].Nombre+'</option>');
                 
                }
                             
            }
            
            
            
            
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
}



function BuscaSub6(){
    var form_data = new FormData();
        form_data.append('idAccion', 5); //1 para validar si existe un codigo eps
        form_data.append('Sub4', $('#Sub4').val());
      
    $.ajax({
        
        url: 'buscadores/ClasificacionInventarios.search.php',
        dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
             console.log(data);
             
            if(data[0].ID){
                  
                  
                  $("#Sub6").empty();
                  $("#Sub6").append('<option value="">Seleccione una opcion</option>');
                for(i=0;i < data.length; i++){
                    
                    $("#Sub6").append('<option value='+data[i].ID+'>'+data[i].Nombre+'</option>');
                 
                }
                             
            }
            
            
            
            
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
}


