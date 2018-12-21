<?php
session_start();
$idUser=$_SESSION['idUser'];
include_once("../../modelo/php_conexion.php");
$obCon = new ProcesoVenta($idUser);

if(isset($_REQUEST["idAccion"])){
    switch ($_REQUEST["idAccion"]) {
        case 1:
           $idDepartamento=$obCon->normalizar($_REQUEST["idDepartamento"]);
            $sql="SELECT NombreSub1,idSub1,idDepartamento FROM prod_sub1 WHERE idDepartamento='$idDepartamento' ";
            //print($sql);
            $Datos=$obCon->Query($sql);
            $i=0;
            //$Mensaje[]="";

            while($DatosDepartamento=$obCon->FetchAssoc($Datos)){
                $Mensaje[$i]["ID"]=$DatosDepartamento["idSub1"];
                $Mensaje[$i]["Nombre"]= utf8_encode($DatosDepartamento["NombreSub1"]);
                $Mensaje[$i]["Dependencia"]=$DatosDepartamento["idDepartamento"];
                $i++;        
            }
            echo json_encode($Mensaje,JSON_UNESCAPED_UNICODE);
            break;
        
        case 2:
           $Sub1=$obCon->normalizar($_REQUEST["Sub1"]);
            $sql="SELECT NombreSub2,idSub2 FROM prod_sub2 WHERE idSub1='$Sub1' ";
            //print($sql);
            $Datos=$obCon->Query($sql);
            $i=0;
            //$Mensaje[]="";

            while($DatosDepartamento=$obCon->FetchAssoc($Datos)){
                $Mensaje[$i]["ID"]=$DatosDepartamento["idSub2"];
                $Mensaje[$i]["Nombre"]= utf8_encode($DatosDepartamento["NombreSub2"]);
                //$Mensaje[$i]["Dependencia"]=$DatosDepartamento["idDepartamento"];
                $i++;        
            }
            echo json_encode($Mensaje,JSON_UNESCAPED_UNICODE);
            break;
            
        case 3:
           $Sub=$obCon->normalizar($_REQUEST["Sub2"]);
            $sql="SELECT NombreSub3,idSub3 FROM prod_sub3 WHERE idSub2='$Sub' ";
            //print($sql);
            $Datos=$obCon->Query($sql);
            $i=0;
            //$Mensaje[]="";

            while($DatosDepartamento=$obCon->FetchAssoc($Datos)){
                $Mensaje[$i]["ID"]=$DatosDepartamento["idSub3"];
                $Mensaje[$i]["Nombre"]= utf8_encode($DatosDepartamento["NombreSub3"]);
                //$Mensaje[$i]["Dependencia"]=$DatosDepartamento["idDepartamento"];
                $i++;        
            }
            echo json_encode($Mensaje,JSON_UNESCAPED_UNICODE);
            break;
            
        case 4:
           $Sub=$obCon->normalizar($_REQUEST["Sub3"]);
            $sql="SELECT NombreSub4,idSub4 FROM prod_sub4 WHERE idSub3='$Sub' ";
            //print($sql);
            $Datos=$obCon->Query($sql);
            $i=0;
            //$Mensaje[]="";

            while($DatosDepartamento=$obCon->FetchAssoc($Datos)){
                $Mensaje[$i]["ID"]=$DatosDepartamento["idSub4"];
                $Mensaje[$i]["Nombre"]= utf8_encode($DatosDepartamento["NombreSub4"]);
                //$Mensaje[$i]["Dependencia"]=$DatosDepartamento["idDepartamento"];
                $i++;        
            }
            echo json_encode($Mensaje,JSON_UNESCAPED_UNICODE);
            break;
        
        case 5:
           $Sub=$obCon->normalizar($_REQUEST["Sub4"]);
            $sql="SELECT NombreSub6,idSub6 FROM prod_sub6 WHERE idSub5='$Sub' ";
            //print($sql);
            $Datos=$obCon->Query($sql);
            $i=0;
            //$Mensaje[]="";

            while($DatosDepartamento=$obCon->FetchAssoc($Datos)){
                $Mensaje[$i]["ID"]=$DatosDepartamento["idSub6"];
                $Mensaje[$i]["Nombre"]= utf8_encode($DatosDepartamento["NombreSub6"]);
                //$Mensaje[$i]["Dependencia"]=$DatosDepartamento["idDepartamento"];
                $i++;        
            }
            echo json_encode($Mensaje,JSON_UNESCAPED_UNICODE);
            break;

    }
    
    //print_r($Mensaje);
    //print(json_encode($Mensaje));
}
    
