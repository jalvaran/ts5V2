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
        
    $css->CModal("BntModalCompras", "onclick=CrearCompra()", "button", "Crear");
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
            $css->CrearBotonEvento("BtnNuevaCompra", "Crear Compra", 1, "onClick", "AbrirModalNuevaCompra()", "verde", "");
        $css->CerrarDiv();
        $css->CrearDiv("DivDatosCompras", "col-md-10", "left", 1, 1); 
            $css->select("CmbOrdenCompra", "form-control", "CmbOrdenCompra", "", "", "onchange=DibujeOrdenCompra()", "");
            $sql="SELECT ID,Fecha,(SELECT RazonSocial FROM proveedores WHERE idProveedores=oc.Tercero LIMIT 1) AS Proveedor FROM ordenesdecompra oc WHERE Estado='ABIERTA'";
            $consulta=$obCon->Query($sql);
            $css->option("", "", "", "", "", "", 0);
                print("Seleccione una Compra");
            $css->Coption();
            while($DatosOrdenes=$obCon->FetchAssoc($consulta)){
                $css->option("", "", "", $DatosOrdenes["ID"], "", "", 0);
                    print($DatosOrdenes["ID"]." ".$DatosOrdenes["Fecha"]." ".$DatosOrdenes["Proveedor"]);
                $css->Coption();
            }
            $css->Cselect();
            
           
        $css->CerrarDiv();
        
        $css->Cfieldset(); 
    $css->CerrarDiv();
    print("<br><br><br><br><br>");
    $css->CrearDiv("DivDatosCompras", "col-md-11", "left", 1, 1); //Datos para la creacion de la compra
        $css->fieldset("", "", "FieldDatosCompra", "DatosCompra", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Datos Generales de esta Compra</a>");
                    $css->Clegend();    
        $css->CrearDiv("", "col-md-6", "center", 1, 1);   
            
                $css->select("idTercero", "form-control", "idTercero", "", "", "", "");
                    $css->option("", "", "", "", "", "");
                        print("Seleccione un Tercero");
                    $css->Coption();      

                $css->Cselect();
            $css->Cfieldset();
        $css->CerrarDiv();
    $css->CerrarDiv();

    
    $css->CrearDiv("DivItemsOrden", "", "", 1, 1);
    
    $css->Cdiv();
    
    $css->Cdiv();    
$css->PageFin();

print('<script src="jsPages/Compras.js"></script>');  //script propio de la pagina

$css->Cbody();
$css->Chtml();

?>