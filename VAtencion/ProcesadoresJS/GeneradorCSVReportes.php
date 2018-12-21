<?php 
if(isset($_REQUEST["Opcion"])){
    $myPage="GeneradorCSVReportesCartera.php";
    include_once("../../modelo/php_conexion.php");
    
    session_start();    
    $idUser=$_SESSION['idUser'];
    $obCon = new ProcesoVenta($idUser);
    $DatosRuta=$obCon->DevuelveValores("configuracion_general", "ID", 1);
    $OuputFile=$DatosRuta["Valor"];
    $Link1=substr($OuputFile, -17);
    $Link="../../".$Link1;
    //print($Link);
    $a='"';
    $Enclosed=" ENCLOSED BY '$a' ";
    $Opcion=$_REQUEST["Opcion"];
    
    switch ($Opcion){
        case 1: //Exportar Turnos
            if(file_exists($Link)){
                unlink($Link);
            }
            
            
            $statement=$obCon->normalizar(urldecode($_REQUEST["st"]));
            $Separador=$obCon->normalizar($_REQUEST["sp"]);
            if($Separador==1){
                $Separador=';';
            }else{
                $Separador=',';
            }
            $sqlColumnas="SELECT 'Fecha','Sede','Identificacion Tercero','Nombre del Tercero','Valor','Estado'";
            $CamposShow=" Fecha,NombreSucursal,Tercero,NombreTercero,Valor,Estado ";
            $sqlColumnas.=" UNION ALL ";
            
            //print($Indice);
            $sql=$sqlColumnas."SELECT $CamposShow FROM $statement INTO OUTFILE '$OuputFile' FIELDS TERMINATED BY '$Separador' $Enclosed LINES TERMINATED BY '\r\n';";
            $obCon->Query($sql);
            print("<a href='$Link' target='_top'><img src='../../images/download.gif'>Download</img></a>");
            break;
        case 2: //Exportar relacion de turnos de un documento
            if(file_exists($Link)){
                unlink($Link);
            }
                        
            $idDoc=$obCon->normalizar(($_REQUEST["idDocumentoEquivalente"]));
            $Separador=$obCon->normalizar($_REQUEST["sp"]);
            if($Separador==1){
                $Separador=';';
            }else{
                $Separador=',';
            }
            $sqlColumnas="SELECT 'Fecha','Tercero','Sucursal','Valor','Documento Equivalente'";
            
            $sqlColumnas.=" UNION ALL ";
            
            //print($Indice);
            $sql=$sqlColumnas." SELECT Fecha,Tercero,Sucursal,Valor,idDocumentoEquivalente FROM nomina_servicios_turnos WHERE idDocumentoEquivalente='$idDoc' INTO OUTFILE '$OuputFile' FIELDS TERMINATED BY '$Separador' $Enclosed LINES TERMINATED BY '\r\n';";
            $obCon->Query($sql);
            print("<a href='$Link' target='_top'><img src='../../images/download.gif'>Download</img></a>");
            break;
        
        }
}else{
    print("No se recibió parametro de opcion");
}

?>