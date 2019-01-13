<?php
/**
 * Pagina para la creacion de compras 
 * 2018-11-27, Julian Alvaran Techno Soluciones SAS
 */
$myPage="Compras.php";
$myTitulo="Plataforma TS5";
include_once("../../sesiones/php_control_usuarios.php");
include_once("../../constructores/paginas_constructor.php");
$css =  new PageConstruct($myTitulo, ""); //objeto con las funciones del html
$obCon = new conexion($idUser); //Conexion a la base de datos

$css->PageInit($myTitulo);
    $css->Modal("ModalAccionesCompras", "Compras", "", 1);
        $css->div("DivFormularioCrearCompra", "", "", "", "", "", "");
        $css->Cdiv();
        
    $css->CModal("BntModalCompras", "onclick=CrearCompra(event)", "button", "Guardar");
    $css->div("", "container", "", "", "", "", "");
    $css->h3("", "", "", "");
                print("<strong>Registro de Compras</strong>");
    $css->Ch3();
    $css->CrearDiv("DivOpcionesCrearCompras", "col-md-11", "left", 1, 1); 
        $css->fieldset("", "", "FieldDatosCompra", "DatosCompra", "", "");
            $css->legend("", "");
                print("<a href='#'>Cree o Seleccione una Compra</a>");
            $css->Clegend();   
        $css->CrearDiv("DivBtnCrear", "col-md-2", "left", 1, 1); 
            $css->CrearBotonEvento("BtnNuevaCompra", "Crear Compra", 1, "onClick", "AbrirModalNuevaCompra()", "azul", "");
        $css->CerrarDiv();
        $css->CrearDiv("DivDatosCompras", "col-md-8", "left", 1, 1); 
            $css->select("idCompra", "form-control", "idCompra", "", "", "onchange=DibujeCompra()", "");
            $css->option("", "", "","", "", "");
                print("Seleccione una Compra");
            $css->Coption();
            $consulta = $obCon->ConsultarTabla("factura_compra","WHERE Estado='ABIERTA'");
            while($DatosComprobante=$obCon->FetchArray($consulta)){
                
                $DatosTercero=$obCon->DevuelveValores("proveedores", "Num_Identificacion", $DatosComprobante['Tercero']);
                $css->option("", "", "", $DatosComprobante['ID'], "", "");
                    print($DatosComprobante['ID']." ".$DatosTercero["RazonSocial"]." ".$DatosComprobante['Concepto']." ".$DatosComprobante['NumeroFactura']);
                $css->Coption();
            }
            $css->Cselect();
           
        $css->CerrarDiv();
        $css->CrearDiv("DivBtnEditar", "col-md-2", "left", 1, 1); 
            $css->CrearBotonEvento("BtnEditarCompra", "Editar Datos", 0, "onClick", "AbrirModalNuevaCompra('Editar')", "verde", "");
        $css->CerrarDiv();
        $css->Cfieldset(); 
    $css->CerrarDiv();
    print("<br><br><br><br><br>");
    $css->CrearDiv("DivDatosCompras", "col-md-11", "left", 1, 1); //Datos para la creacion de la compra
        $css->fieldset("", "", "FieldDatosCompra", "DatosCompra", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Agregar items a esta compra</a>");
                    $css->Clegend();    
        $css->CrearDiv("DivDatosGeneralesCompra", "", "center", 1, 1);   
            
        $css->CerrarDiv();       
            $css->Cfieldset();
    $css->CerrarDiv();
    //$css->CerrarDiv();

    print("<br>");
    $css->CrearDiv("DivDatosCompras", "col-md-11", "left", 1, 1); //Datos para la creacion de la compra
        $css->fieldset("", "", "FieldDatosCompra", "DatosCompra", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Items Agregados a esta Compra</a>");
                    $css->Clegend();    
        $css->CrearDiv("DivItemsCompra", "", "center", 1, 1);   
            
        $css->CerrarDiv();       
            $css->Cfieldset();
        $css->CerrarDiv();
    //$css->CerrarDiv();
    
    $css->Cdiv();    
$css->PageFin();

print('<script src="jsPages/Compras.js"></script>');  //script propio de la pagina

$css->Cbody();
$css->Chtml();

?>