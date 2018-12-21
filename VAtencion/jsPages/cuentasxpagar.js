//funcion para verificar si se puede cruzar el valor de la nota
function VerificarDatos(total){
    var idTarget='DivAgenda';
    document.getElementById(idTarget).innerHTML ='Procesando...<br><img src="../images/process.gif" alt="Cargando" height="100" width="100">';
    
    var Page = "Consultas/modelos_admin.querys.php?Modelo=0";
   
        if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                httpEdicion = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                httpEdicion = new ActiveXObject("Microsoft.XMLHTTP");
            }
            httpEdicion.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById(idTarget).innerHTML = this.responseText;
                    
                }
            };
        
        httpEdicion.open("GET",Page,true);
        httpEdicion.send();
    
        
}

CargarDatos();

startTime();
