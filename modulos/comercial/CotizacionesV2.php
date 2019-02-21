<?php
/**
 * Pagina para la creacion de compras 
 * 2018-11-27, Julian Alvaran Techno Soluciones SAS
 */
$myPage="CotizacionesV2.php";
$myTitulo="Cotizaciones TS5";
include_once("../../sesiones/php_control_usuarios.php");
include_once("../../constructores/paginas_constructor.php");
$css =  new PageConstruct($myTitulo, ""); //objeto con las funciones del html
$obCon = new conexion($idUser); //Conexion a la base de datos

$css->PageInit($myTitulo);
    $css->Modal("ModalAccionesCotizaciones", "Cotizaciones", "", 1);
        $css->div("DivFrmCrearCotizacion", "", "", "", "", "", "");
        $css->Cdiv();
        
    $css->CModal("BntModalCotizaciones", "onclick=CrearCotizacion(event)", "button", "Guardar");
    //$css->div("", "container", "", "", "", "", "");
    
    $css->CrearDiv("DivOpcionesCrearCotizaciones", "col-md-12", "left", 1, 1); 
    $css->CrearDiv("DivMensajesModulo", "", "center", 1, 1); 
    $css->CerrarDiv();  
    $css->h3("", "", "", "");
                print("<strong>Cotizaciones</strong>");
    $css->Ch3();
        $css->fieldset("", "", "FieldDatosCotizacion", "DatosCotizacion", "", "");
            $css->legend("", "");
                print("<a href='#'>Cree, Seleccione o imprima una Cotización</a>");
            $css->Clegend();   
            
        $css->CrearDiv("DivBtnCrear", "col-md-2", "left", 1, 1); 
            $css->CrearBotonEvento("BtnNuevaCotizacion", "Crear Cotizacion", 1, "onClick", "AbrirModalNuevaCotizacion()", "azul", "");
        $css->CerrarDiv();
        $css->CrearDiv("DivDatosCotizacion", "col-md-8", "left", 1, 1); 
            $css->select("idCotizacion", "form-control", "idCotizacion", "", "", "onchange=DibujeCotizacion()", "");
            $css->option("", "", "","", "", "");
                print("Seleccione una Cotización");
            $css->Coption();
            $consulta = $obCon->ConsultarTabla("cotizacionesv5","WHERE Estado='ABIERTA'");
            while($DatosCotizacion=$obCon->FetchArray($consulta)){
                
                $DatosTercero=$obCon->DevuelveValores("clientes", "idClientes", $DatosCotizacion['Clientes_idClientes']);
                $css->option("", "", "", $DatosCotizacion['ID'], "", "");
                    print($DatosCotizacion['ID']." ".$DatosTercero["RazonSocial"]);
                $css->Coption();
            }
            $css->Cselect();
           
        $css->CerrarDiv();
        $css->CrearDiv("DivBtnEditar", "col-md-2", "left", 1, 1); 
            $css->CrearBotonEvento("BtnEditar", "Editar Datos", 0, "onClick", "AbrirModalNuevaCotizacion('Editar')", "azul", "");
        $css->CerrarDiv();
        
        $css->Cfieldset(); 
    $css->CerrarDiv();
    print("<br><br><br><br><br><br><br><br><br>");
    $css->CrearDiv("DivDatos", "col-md-12", "left", 1, 1); //Datos para la creacion de la compra
        $css->fieldset("", "", "FieldDatos", "Datos", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Agregar items a esta cotizacíón</a>");
                    $css->Clegend();    
        $css->CrearDiv("DivAgregarItems", "", "center", 1, 1);   
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
                $css->select("CmbListado", "form-control", "CmbListado", "Listado", "", "", "onchange=ConvertirSelectBusquedas()");
                    $css->option("", "", "", 1, "", "");
                        print("Productos para la venta");
                    $css->Coption();
                    $css->option("", "", "", 2, "", "");
                        print("Servicios");
                    $css->Coption();
                    $css->option("", "", "", 3, "", "");
                        print("Productos para alquilar");
                    $css->Coption();
                    //$css->option("", "", "", 4, "", "");
                      //  print("Otros");
                    //$css->Coption();
                $css->Cselect();
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-5", "center", 1, 1);
                $css->select("CmbBusquedas", "form-control", "CmbBusquedas", "Búsquedas<br>", "", "", "style=width:100%");
                   
                    $css->option("", "", "", "", "", "");
                        print("Buscar");
                    $css->Coption();
                    
                    
                $css->Cselect();
            $css->CerrarDiv();            
            
                        
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
               print("<strong>Cantidad</strong>");
               $css->input("number", "Cantidad", "form-control", "Cantidad", "Cantidad", "", "Cantidad", "off", "", "");
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
               print("<strong>Valor Unitario</strong>");
               $css->input("text", "ValorUnitario", "form-control", "ValorUnitario", "Valor Unitario", "", "Valor Unitario", "off", "", "");
            $css->CerrarDiv();
            //print("<br><br><br><br>");
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
            $css->CerrarDiv();
            $css->CrearDiv("DivBtnAregar", "col-md-5", "left", 1, 1); 
                $css->CrearBotonEvento("BtnAgregarItem", "Agregar Item", 1, "onClick", "AgregarItem(event)", "verde", "");
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-4", "center", 1, 1);
            $css->CerrarDiv();
        
        $css->CerrarDiv();       
            $css->Cfieldset();
    $css->CerrarDiv();
    //$css->CerrarDiv();

    print("<br>");
    $css->CrearDiv("DivDatosCompras", "col-md-12", "left", 1, 1); //Datos para la creacion de la compra
        $css->fieldset("", "", "FieldDatosCompra", "items en esta compra", "", "");
            $css->legend("", "");
                print("<a href='#'>Items Agregados a esta Compra</a>");
            $css->Clegend();    
            $css->CrearDiv("DivItems", "", "center", 1, 1);   

            $css->CerrarDiv();       
        $css->Cfieldset();
            
        $css->fieldset("", "", "FieldDatosCompra", "Totales, Retenciones y opciones del documento", "", "");
            $css->legend("", "");
                print("<a href='#'>Totales, Retenciones y opciones del documento</a>");
            $css->Clegend();    
           
            $css->CrearDiv("DivTotalesCompra", "", "center", 1, 1);   
                
            $css->CerrarDiv(); 
        $css->Cfieldset();    
    $css->CerrarDiv();
    //$css->CerrarDiv();
    
    $css->Cdiv();

$css->PageFin();

print('<script src="jsPages/Cotizaciones.js"></script>');  //script propio de la pagina

$css->Cbody();
$css->Chtml();

?>