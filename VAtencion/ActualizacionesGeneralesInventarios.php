<?php 
$myPage="ActualizacionesGeneralesInventarios.php";
include_once("../sesiones/php_control.php");

$obVenta = new ProcesoVenta($idUser);
$obTabla = new Tabla($db);

include_once("css_construct.php");

print("<html>");
print("<head>");
$css =  new CssIni("Actualizacion General de Inventarios");

print("</head>");




print("<body>");
    
    $css->CabeceraIni("Actualizacion General de Inventarios"); //Inicia la cabecera de la pagina
    
    
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    print("<br>");
    if(isset($_REQUEST["BtnActualizar"])){
        $Tabla=$obVenta->normalizar($_REQUEST["CmbListaPrecios"]);
        $Departamento=$obVenta->normalizar($_REQUEST["CmbDepartamentos"]);
        $IVA=$obVenta->normalizar($_REQUEST["CmbIVA"]);
        $Condicion=" WHERE Departamento='$Departamento'";
        
        $i=0;
        $TablasActualizar[0]=$Tabla;
        if($Departamento=="ALL"){
            $Condicion="";
        }
                     
        if($Tabla=="ALL"){
            $Datos=$obVenta->ConsultarTabla("tablas_ventas", "");
            $i=0;
            while($Listas=$obVenta->FetchArray($Datos)){
                $TablasActualizar[$i]=$Listas["NombreTabla"];
                $i++;
            }
        }
        foreach($TablasActualizar as $tbl){
            $obVenta->update($tbl, "IVA", $IVA, $Condicion);
        }
        
        $css->CrearNotificacionRoja("IVA Actualizado", 16);
    }
    ///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
    $css->CrearImageLink("../VMenu/MnuInformes.php", "../images/actualizar.png", "_self",200,200);
    
    
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
    
    $css->CrearNotificacionNaranja("ACTUALIZAR IVA", 16);
    $css->CrearForm2("FrmActualizarIVA", $myPage, "post", "_self");
    $css->CrearTabla();
    $css->FilaTabla(16);
    $css->ColTabla("<strong>lista de Precios</strong>", 1);
    $css->ColTabla("<strong>Departamento</strong>", 1);
    $css->ColTabla("<strong>Valor de IVA</strong>", 1);
    $css->ColTabla("<strong>Actualizar</strong>", 1);
    $css->CierraFilaTabla();
    $css->FilaTabla(16);
    print("<td>");
    $css->CrearSelect("CmbListaPrecios", "");
        $css->CrearOptionSelect("", "Seleccione una lista de precios", 0);
        $css->CrearOptionSelect("ALL", "Todas las listas", 0);
        $Datos=$obVenta->ConsultarTabla("tablas_ventas", "");
        while($Listas=$obVenta->FetchArray($Datos)){
            $css->CrearOptionSelect($Listas["NombreTabla"], $Listas["TipoVenta"], 0);
        }
    $css->CerrarSelect();
    print("</td>");
    print("<td>");
    $css->CrearSelect("CmbDepartamentos", "");
        $css->CrearOptionSelect("", "Seleccione un departamento", 0);
        $css->CrearOptionSelect("ALL", "Todos los Departamentos", 0);
        $Datos=$obVenta->ConsultarTabla("prod_departamentos", "");
        while($Listas=$obVenta->FetchArray($Datos)){
            $css->CrearOptionSelect($Listas["idDepartamentos"], $Listas["Nombre"], 0);
        }
    $css->CerrarSelect();
    print("</td>");
    print("<td>");
    $css->CrearSelect("CmbIVA", "");
        $css->CrearOptionSelect("", "Seleccione el Valor del IVA a Aplicar", 0);
        
        $Datos=$obVenta->ConsultarTabla("porcentajes_iva", "");
        while($Listas=$obVenta->FetchArray($Datos)){
            $css->CrearOptionSelect($Listas["Valor"], $Listas["Nombre"], 0);
        }
    $css->CerrarSelect();
    print("</td>");
    print("<td>");
    $css->CrearBotonConfirmado("BtnActualizar", "Actualizar");
    print("</td>");
    
    $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarForm();
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
?>