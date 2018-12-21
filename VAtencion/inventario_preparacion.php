<?php 
$myPage="inventario_preparacion.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");
$obVenta = new ProcesoVenta($idUser);
$idDepartamento=0;
$Sub1=0;
$Sub2=0;
$Sub3=0;
$Sub4=0;
$Sub5=0;
if(isset($_REQUEST["idDepartamento"])){
    $idDepartamento=$obVenta->normalizar($_REQUEST["idDepartamento"]);
}
if(isset($_REQUEST["Sub1"])){
    $Sub1=$obVenta->normalizar($_REQUEST["Sub1"]);
}
if(isset($_REQUEST["Sub2"])){
    $Sub2=$obVenta->normalizar($_REQUEST["Sub2"]);
}
if(isset($_REQUEST["Sub3"])){
    $Sub3=$obVenta->normalizar($_REQUEST["Sub3"]);
}
if(isset($_REQUEST["Sub4"])){
    $Sub4=$obVenta->normalizar($_REQUEST["Sub4"]);
}
if(isset($_REQUEST["Sub5"])){
    $Sub5=$obVenta->normalizar($_REQUEST["Sub5"]);
}

print("<html>");
print("<head>");
$css =  new CssIni("Preparar inventario Fisico");

print("</head>");
print("<body>");
    
    include_once("procesadores/inventario_preparacion.process.php");
    
    $css->CabeceraIni("Cortar productos a la tabla temporal para inventario Fisico"); //Inicia la cabecera de la pagina
       
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    print("<br>");
    
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
    
    $css->CrearNotificacionAzul("Cortar productos a la tabla temporal para inventario Fisico", 16);
    $css->CrearNotificacionRoja("Tenga especial cuidado al realizar esta accion, pues ocasionará que los productos "
            . "de la clasificacion que se seleccionen se retiraran del inventario principal y pasaran a la tabla temporal para su conteo fisico", 16);
    
    $css->CrearNotificacionNaranja("Paso 1: Copiar Inventarios por clasificacion, (Esto le permitira realizar el inventario fisico por partes)", 16);
    $css->CrearForm2("FrmSelDepartamentos", $myPage, "post", "_self");
    $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Departamento</strong>", 1);
            $css->ColTabla("<strong>SubGrupo1</strong>", 1);
            $css->ColTabla("<strong>SubGrupo2</strong>", 1);
            
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            print("<td style='text-align:center'>");
            $css->CrearSelectTable("idDepartamento", "prod_departamentos", "", "idDepartamentos", "idDepartamentos", "Nombre", "onChange", "EnviaForm(`FrmSelDepartamentos`)", $idDepartamento,1);
            print("</td>");
            print("<td style='text-align:center'>");
                if($idDepartamento>0){
                    $Consulta=" WHERE idDepartamento='$idDepartamento'";
                    $css->CrearSelectTable("Sub1", "prod_sub1", "$Consulta", "idSub1", "NombreSub1", "idDepartamento", "onChange", "EnviaForm(`FrmSelDepartamentos`)", $Sub1,0);
                }
            print("</td>");
            print("<td style='text-align:center'>");
                if($Sub1>0){
                    $Consulta=" WHERE idSub1='$Sub1'";
                    $css->CrearSelectTable("Sub2", "prod_sub2", "$Consulta", "idSub2", "NombreSub2", "idSub1", "onChange", "EnviaForm(`FrmSelDepartamentos`)", $Sub2,0);
                }
            print("</td>");
            
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>SubGrupo3</strong>", 1);
            $css->ColTabla("<strong>SubGrupo4</strong>", 1);
            $css->ColTabla("<strong>SubGrupo5</strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            print("<td style='text-align:center'>");
                if($Sub2>0){
                    $Consulta=" WHERE idSub2='$Sub2'";
                    $css->CrearSelectTable("Sub3", "prod_sub3", "$Consulta", "idSub3", "NombreSub3", "idSub2", "onChange", "EnviaForm(`FrmSelDepartamentos`)", $Sub3,0);
                }
            print("</td>");
            print("<td style='text-align:center'>");
                if($Sub3>0){
                    $Consulta=" WHERE idSub3='$Sub3'";
                    $css->CrearSelectTable("Sub4", "prod_sub4", "$Consulta", "idSub4", "NombreSub4", "idSub3", "onChange", "EnviaForm(`FrmSelDepartamentos`)", $Sub4,0);
                }
            print("</td>");
            print("<td style='text-align:center'>");
                $css->CrearSelectTable("Sub5", "prod_sub5", "", "idSub5", "NombreSub5", "", "onChange", "EnviaForm(`FrmSelDepartamentos`)", $Sub5,0);
            print("</td>");
        $css->CierraFilaTabla();
        $css->CerrarTabla();
    $css->CerrarForm();
    
    if($idDepartamento>0){
    $css->CrearForm2("FrmCortarProductos", $myPage, "post", "_self");
    $css->CrearInputText("idDepartamento", "hidden","" , $idDepartamento, "", "", "", "", "", "", "", "");
    $css->CrearInputText("Sub1", "hidden","" , $Sub1, "", "", "", "", "", "", "", "");
    $css->CrearInputText("Sub2", "hidden","" , $Sub2, "", "", "", "", "", "", "", "");
    $css->CrearInputText("Sub3", "hidden","" , $Sub3, "", "", "", "", "", "", "", "");
    $css->CrearInputText("Sub4", "hidden","" , $Sub4, "", "", "", "", "", "", "", "");
    $css->CrearInputText("Sub5", "hidden","" , $Sub5, "", "", "", "", "", "", "", "");
    
    $css->CrearTabla();
        $css->FilaTabla(16);
            
        $css->ColTabla("<strong>Guardar</strong>", 2);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        
        print("<td colspan='2' style='text-align:center'>");
        $css->CrearBotonConfirmado("BtnCortarPV", "Cortar Productos");
        //$css->CrearBotonImagen("", "BtnGuardar", "_self", "../images/save.png", "onclick='Confirmar()'", 50, 100, "", "", "");
        print("</td>");
        $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarForm();
}
    $css->CrearNotificacionNaranja("Paso 2: Cortar Kardex a Kardex Temporal", 16);
    $css->CrearForm2("FrmCortarKardex", $myPage, "post", "_self");
    $css->CrearTabla();
    $css->FilaTabla(16);
    print("<td style='text-align:center'>");
    $css->CrearBotonConfirmado("BtnCortarKardex", "Cortar Kardex");
    print("</td>");
    $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarForm();
    $css->CrearNotificacionNaranja("Paso 3: Cortar productos venta a productos venta Temporal (No haga esto si va a realizar el inventario por clasificaciones, si lo desea realizar por clasificacion omita este paso)", 16);
    $css->CrearForm2("FrmCortarProductosTotal", $myPage, "post", "_self");
    $css->CrearTabla();
    $css->FilaTabla(16);
    print("<td style='text-align:center'>");
    print("<strong>Esta opcion pondrá todos los productos en cero, ideal si se desea guardar un historial de las ventas</strong><br>");
    $css->CrearBotonConfirmado("BtnInicializarProductosVenta", "Inicializar Toda la tabla de productos Venta");
    print("<br><br>");
    print("<strong>Esta opcion cortará todos los productos, ideal si es un inventario inicial, para depurar codigos</strong><br>");
    $css->CrearBotonConfirmado("BtnCortarTodosProductos", "Cortar Toda la tabla de productos Venta");
    print("</td>");
    $css->CierraFilaTabla();
    $css->CerrarTabla();
    
    $css->CerrarForm();
    
    $css->CrearNotificacionVerde("Restaurar: esta acción copiará nuevamente los productos de la tabla temporal a la real así como tambien el kardex", 16);
    $css->CrearForm2("FrmRestaurar", $myPage, "post", "_self");
    $css->CrearTabla();
    $css->FilaTabla(16);
    print("<td style='text-align:center'>");
    $css->CrearBotonConfirmado("BtnRestarurar", "Restaurar");
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
    ob_end_flush();
?>