<?php 
$myPage="AgregueParametros.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");

$obTabla = new Tabla($db);
$sql="";



print("<html>");
print("<head>");
$css =  new CssIni("Parametros");

print("</head>");
print("<body>");
$idLink=0;  
    if(isset($_REQUEST["LkSubir"])){
        $idLink=$_REQUEST["LkSubir"];
    }	
    
    $css->CabeceraIni("Verificar y reparar parametros necesarios para un Backup"); //Inicia la cabecera de la pagina
   
    $css->CabeceraFin(); 
    
    
    ///////////////Creamos el contenedor
    /////
    /////
     
     
    $css->CrearDiv("principal", "container", "center",1,1);
    
    print("<strong>Click para Modificar</strong><br>");
    $css->CrearImageLink($myPage."?LkSubir=1", "../images/reparar.png", "_self", 200, 200);
    $css->CrearForm2("FormFunciones", $myPage, "post", "_self");
    $css->CrearBotonConfirmado("BtnVaciarTablas", "Inicializar las Tablas para crearlas en el servidor Externo");
    print("<br><br>");
    $css->CrearBotonConfirmado("BtnIniciaSync", "Actualizar Sincronizacion de Todas las tablas");
    $css->CerrarForm();
    $css->CrearDiv("Secundario", "container", "center",1,1);
    $css->Creartabla();
    $css->CrearNotificacionVerde("TABLAS QUE DEBEN SER MODIFICADAS", 16);
    $VectorT["F"]="";
    $consulta=$obVenta->MostrarTablas($db, $VectorT);
    if(isset($_REQUEST["BtnVaciarTablas"])){
        $obVenta->VaciarTabla("plataforma_tablas");
    }
    if($obVenta->NumRows($consulta)){
        
        $css->FilaTabla(16);
        $css->ColTabla("<strong>Num</strong>", 1);
        $css->ColTabla("<strong>Tabla</strong>", 1);
        $css->ColTabla("<strong>Update</strong>", 1);
        $css->ColTabla("<strong>Sincronizado</strong>", 1);
        $css->CierraFilaTabla();
        
        $i=0;
        $TodoOk=0;
        while($DatosTablas=$obVenta->FetchArray($consulta)){
            if(isset($_REQUEST["BtnIniciaSync"])){
                $obVenta->update($DatosTablas[0], "Sync", "0000-00-00 00:00:00", "");
            }
            $i++;
            
            $ColumnaCol=$obVenta->MostrarColumnas($DatosTablas[0], $db);
            //$sql="ALTER TABLE `$DatosTablas[0]` CHANGE `Sync` `Sync` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00';";
            //$obVenta->Query($sql);
            $FlagUpdate=0;
            $FlagSincronizado=0;
            
            foreach($ColumnaCol as $NombreCol){
                
                if($NombreCol=='Updated'){
                    $FlagUpdate=1;
                }
                
                if($NombreCol=='Sync'){
                    $FlagSincronizado=1;
                }
                
                
            }
            if($FlagSincronizado==0 or $FlagUpdate==0){
                $TodoOk=1;
                $css->FilaTabla(16);
                $css->ColTabla($i, 1);
                $css->ColTabla($DatosTablas[0], 1);
                $css->ColTabla($FlagUpdate, 1);
                $css->ColTabla($FlagSincronizado, 1);
                $css->CierraFilaTabla();
                if($idLink==1 AND $FlagUpdate==0){
                    $VectorAC["F"]=0;
                    $obVenta->AgregarColumnaTabla($DatosTablas[0], 'Updated', 'TIMESTAMP', ' DEFAULT CURRENT_TIMESTAMP', 'on update CURRENT_TIMESTAMP', $VectorAC);
                }
                
                if($idLink==1 AND $FlagSincronizado==0){
                    $VectorAC["F"]=0;
                    $obVenta->AgregarColumnaTabla($DatosTablas[0], 'Sync', 'DATETIME', "DEFAULT '0000-00-00 00:00:00'", '', $VectorAC);
                }
                    
            }
            
        }
        if($TodoOk==0){
            $css->CrearFilaNotificacion("No es necesario modificar las tablas para realizar un backup", 16);
        }
    }else{
        $css->CrearFilaNotificacion("No hay tablas", 16);
    }   
    
    $css->CerrarTabla();
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->AnchoElemento("CmbDestino_chosen", 200);
    $css->AnchoElemento("CmbCuentaDestino_chosen", 200);
    print("</body></html>");
    ob_end_flush();
?>