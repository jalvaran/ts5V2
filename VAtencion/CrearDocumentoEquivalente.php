<?php
$myPage="CrearDocumentoEquivalente.php";
include_once("../sesiones/php_control.php");
include_once("clases/DocumentoEquivalente.class.php");
$myTitulo="Documento Equivalente";
include_once("css_construct.php");
print("<html>");
print("<head>");

$css =  new CssIni($myTitulo);
$obDocumento= new DocumentoEquivalente($idUser);
print("</head>");
print("<body>");
//Cabecera
$css->CabeceraIni($myTitulo); //Inicia la cabecera de la pagina
    $css->CreaBotonDesplegable("DialNuevo", "Nuevo");
    
$css->CabeceraFin(); 


$css->CrearCuadroDeDialogo("DialNuevo", "Nuevo Documento Equivalente");
    $css->CrearForm2("FrmDocumentoEquivalente", $myPage, "post", "_self");
        $css->CrearInputText("TxtFecha", "date", "Fecha:<br>", date("Y-m-d"), "Fecha", "", "", "", 150, 30, 0, 1);
        print("<br>");
        $VarSelect["Ancho"]="200";
        $VarSelect["PlaceHolder"]="Seleccione un Proveedor";
        $VarSelect["Required"]=1;
        $VarSelect["Title"]="Proveedor: ";
        $css->CrearSelectChosen("CmbProveedor", $VarSelect);

        $sql="SELECT * FROM proveedores";
        $Consulta=$obVenta->Query($sql);
        $css->CrearOptionSelect("", "Seleccione Un Proveedor" , 0);
           while($DatosCliente=$obVenta->FetchArray($Consulta)){
               
               $css->CrearOptionSelect($DatosCliente["Num_Identificacion"], "$DatosCliente[Num_Identificacion] - $DatosCliente[RazonSocial]" , 0);
           }
        $css->CerrarSelect();
        print("<br><br><br><br><br><br>");
        $css->CrearBotonConfirmado("BtnCrear", "Crear");
        print("<br><br><br><br>");
    $css->CerrarForm();
$css->CerrarCuadroDeDialogo();
$css->CrearDiv("principal", "container", "center",1,1);
    $idDocumento=0;
    //Si se recibe el selector para el documento abierto
    if(isset($_REQUEST["CmbDocumento"])){
        $idDocumento=$obDocumento->normalizar($_REQUEST["CmbDocumento"]); 
    }
    include_once 'procesadores/DocumentoEquivalente.process.php';
    //Formulario para seleccionar el documento
    $css->CrearForm2("FrmDoc", $myPage, "post", "_self");
        $css->CrearSelect("CmbDocumento", "EnviaForm('FrmDoc')",300);
        $css->CrearOptionSelect("", "Seleccione un Documento",0);
        
        $consulta=$obDocumento->ConsultarTabla("documento_equivalente", "WHERE Estado='AB'");
        while($DatosDocumento=$obDocumento->FetchArray($consulta)){
            $Tercero=$DatosDocumento["Tercero"];
            $DatosProveedor=$obDocumento->ValorActual("proveedores", "RazonSocial", " Num_Identificacion='$Tercero' LIMIT 1");
            $sel=0;
            if($idDocumento==$DatosDocumento["ID"]){
                $sel=1;
            }
            $css->CrearOptionSelect($DatosDocumento["ID"], "$DatosDocumento[ID], $DatosProveedor[RazonSocial] $DatosDocumento[Tercero]",$sel);
        }
        $css->CerrarSelect();
    $css->CerrarForm();
    if($idDocumento>0){
        $css->CrearForm2("FrmAgregarItem", $myPage, "post", "_self");
        $css->CrearInputText("CmbDocumento", "hidden", "", $idDocumento, "", "", "", "", "", "", 0, 0);
        $css->CrearTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Documento Equivalente No.</strong>", 4);
                $css->ColTabla("<strong>$idDocumento</strong>", 1);
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                $css->ColTabla("Cantidad", 1);
                $css->ColTabla("Descripcion", 2);
                $css->ColTabla("Valor Unitario", 1);
                $css->ColTabla("Agregar", 1);
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                print("<td>");
                    $css->CrearInputNumber("TxtCantidad", "number", "", 1, "Cantidad", "", "", "", 50, 30, 0, 1, 1, "", 1);
                print("</td>");
                print("<td colspan='2'>");
                    $css->CrearInputText("TxtDescripcion", "text", "", "", "Descripcion", "", "", "", 550, 30, 0, 1);
                print("</td>");
                print("<td>");
                    $css->CrearInputNumber("TxtValorUnitario", "number", "", "", "Valor Unitario", "", "", "", 100, 30, 0, 1, 1, "", 1);
                print("</td>");
                print("<td>");
                    $css->CrearBoton("BtnAgregar", "Agregar");
                print("</td>");
            $css->CierraFilaTabla();
        $css->CerrarTabla();
        $css->CerrarForm();
        
        $css->CrearNotificacionVerde("Items en este Documento Equivalente", 16);
        $css->CrearForm2("FormGuardar", $myPage, "post", "_self");
        $css->CrearTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Cantidad</strong>", 1);
                $css->ColTabla("<strong>Descripcion</strong>", 1);
                $css->ColTabla("<strong>Valor Unitario</strong>", 1);
                $css->ColTabla("<strong>Total</strong>", 1);
                $css->ColTabla("<strong>Eliminar</strong>", 1);
            $css->CierraFilaTabla();    
            $Datos=$obDocumento->ConsultarTabla("documento_equivalente_items", "WHERE idDocumento='$idDocumento'");
            $Total=0;
            while($DatosItem=$obDocumento->FetchArray($Datos)){
                $Total=$Total+$DatosItem["Total"];
                $css->FilaTabla(16);
                    $css->ColTabla($DatosItem["Cantidad"], 1);
                    $css->ColTabla($DatosItem["Descripcion"], 1);
                    $css->ColTabla($DatosItem["ValorUnitario"], 1);
                    $css->ColTabla($DatosItem["Total"], 1);
                    $css->ColTablaDel($myPage, "", "", $DatosItem["ID"],$idDocumento);
                $css->CierraFilaTabla();   
            }
            $css->FilaTabla(16);
                print("<td colspan='3' style=text-align:right>");
                    print("<strong>TOTAL</strong>");
                print("</td>");
                
                $css->ColTabla(number_format($Total), 1);
                $css->ColTabla("", 1);
            $css->CierraFilaTabla();
            if($Total>0){
                $css->FilaTabla(16);
                    print("<td colspan='5' style=text-align:center>");
                        $css->CrearInputText("CmbDocumento", "hidden", "", $idDocumento, "", "", "", "", "", "", 0, 0);
                        $css->CrearBotonConfirmado("BtnGuardar", "Guardar");
                    print("</td>");
                $css->CierraFilaTabla();
            }
        $css->CerrarTabla();
        $css->CerrarForm();
    }
    
$css->CerrarDiv();//Cerramos contenedor Principal
$css->Footer();
$css->AgregaJS(); //Agregamos javascripts
$css->AnchoElemento("CmbProveedor_chosen", 300);
//$css->AgregaSubir();    
////Fin HTML  
print("</body></html>");


?>