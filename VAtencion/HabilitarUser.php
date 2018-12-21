<?php 
$myPage="HabilitarUser.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");

$css =  new CssIni("Habilitar User");
$css->CabeceraIni("Asignacion de Usuarios a Cajas"); 
$css->CabeceraFin();

$css->CrearDiv("principal", "container", "Center", 1, 1);

if(!empty($_REQUEST['ImgCerrarCajas'])){
            
    $obVenta->VaciarTabla("vestasactivas");// vaciar ventas activas
    $obVenta->VaciarTabla("preventa");// Crea otra preventa
    $css->CrearNotificacionRoja("Se han borrado todas las preventas", 16);
            
}

if(!empty($_REQUEST['BtnAsignar'])){
    
    $idUsuario=$_REQUEST['CmbUser'];
    $idCaja=$_REQUEST['TxtIdCaja'];
    $Estado=$_REQUEST['CmbEstado'];
    
    $obVenta->update("cajas", "idUsuario", $idUsuario, "WHERE ID='$idCaja'");
    $obVenta->update("cajas", "Estado", $Estado, "WHERE ID='$idCaja'");
             
}
$css->CrearNotificacionAzul("Asignar Usuarios y Habilitar Cajas: ", 20); 
$css->CrearTabla();
    $Consulta=$obVenta->ConsultarTabla("cajas", "");
    if($obVenta->NumRows($Consulta)){
        $css->FilaTabla(16);
        $css->ColTabla("<strong>ID</strong>", 1);
        $css->ColTabla("<strong>Nombre</strong>", 1);
        $css->ColTabla("<strong>Base</strong>", 1);
        $css->ColTabla("<strong>Asignar y Abrir o Cerrar Cajas</strong>", 1);
        
        $css->CierraFilaTabla();
        while ($DatosCajas=$obVenta->FetchArray($Consulta)){
            $css->FilaTabla(14);
                $css->ColTabla($DatosCajas["ID"], 1);
                $css->ColTabla($DatosCajas["Nombre"], 1);
                $css->ColTabla($DatosCajas["Base"], 1);
                print("<td>");
                $css->CrearForm2("FormAsign$DatosCajas[ID]", $myPage, "post", "_self");
                $css->CrearInputText("TxtIdCaja", "hidden", "", $DatosCajas["ID"], "", "", "", "", "", "", "", "");
                $VarSelect["Ancho"]="100";
                $VarSelect["PlaceHolder"]="Usuarios";
                $VarSelect["Title"]="";
                $css->CrearSelectChosen("CmbUser", $VarSelect);
    
                $sql="SELECT idUsuarios, Nombre, Apellido, Identificacion FROM usuarios";
                $ConsultaUsuarios=$obVenta->Query($sql);
                $css->CrearOptionSelect("0", "Seleccione un usuario" , 0);
                while($DatosUsuarios=$obVenta->FetchArray($ConsultaUsuarios)){
                    $sel=0;
                    if($DatosUsuarios["idUsuarios"]==$DatosCajas["idUsuario"]){
                        $sel=1;
                    }
                    $css->CrearOptionSelect("$DatosUsuarios[idUsuarios]", "$DatosUsuarios[Nombre] / $DatosUsuarios[Apellido] / $DatosUsuarios[Identificacion]" , $sel);
                   }
           
            $css->CerrarSelect();
            print(" < / / > ");
            $Sel1=0;
            $Sel2=0;
            $css->CrearSelect("CmbEstado", "");
                if($DatosCajas["Estado"]=="ABIERTA"){
                    $Sel1=1;
                    $Sel2=0;
                }else{
                    $Sel1=0;
                    $Sel2=1;
                }
                
                $css->CrearOptionSelect("ABIERTA", "Abierta", $Sel1);
                $css->CrearOptionSelect("CERRADA", "Cerrada", $Sel2);
            $css->CerrarSelect(); 
            print(" < / / > ");
            $VectorBoton["Fut"]=0;
            $css->CrearBotonEvento("BtnAsignar", "Editar", 1, "", "", "naranja", $VectorBoton);
            $css->CerrarForm();            
            print("</td>");
                
            
            $css->CierraFilaTabla();
        }
        
    }else{
        $css->CrearFilaNotificacion("No hay Cajas Creadas", 16);
    }
$css->CerrarTabla();

$css->CrearTabla();
print("<td>");
$css->CrearDiv("vaciar", "", "Center", 1, 1);
$css->CrearNotificacionRoja("Click para Borrar Todas las preventas: ", 18);
$css->CrearImageLink("$myPage?ImgCerrarCajas=1", "../images/CerrarCajas.png", "_self", 200, 200);
$css->CerrarDiv();
print("</td>");
$css->CerrarTabla();
$css->CerrarDiv();

$css->AgregaJS();
$css->AgregaSubir();
$css->AgregaJSVentaRapida();
$css->Footer();

ob_end_flush();
?>