<?php
if(file_exists("../../../modelo/php_conexion.php")){
    include_once("../../../modelo/php_conexion.php");
}

class Contabilidad extends conexion{
    /**
     * Crea la vista para el balance x terceros
     * @param type $Tipo
     * @param type $FechaInicial
     * @param type $FechaFinal
     * @param type $Empresa
     * @param type $CentroCostos
     * @param type $vector
     * @return type
     */
    public function ConstruirVistaBalanceTercero($Tipo,$FechaInicial,$FechaFinal,$Empresa,$CentroCostos,$vector){
        
        $sql="DROP VIEW IF EXISTS `vista_balancextercero2`;";
        $this->Query($sql);
        $CondicionEmpresa="";
        if($Empresa<>"ALL"){
            $CondicionEmpresa=" AND idEmpresa = '$Empresa'";
        }
        
        $CondicionCentroCostos="";
        if($CentroCostos<>"ALL"){
            $CondicionCentroCostos=" AND idCentroCosto = '$CentroCostos'";
        }
        $sql="CREATE VIEW vista_balancextercero2 AS
            SELECT '' as ID,`Tercero_Identificacion` as Identificacion,`Tercero_Razon_Social` AS Razon_Social,
            `CuentaPUC` as Cuenta, `NombreCuenta` as Nombre_Cuenta,
            (SELECT (SUM(`Debito`)-SUM(`Credito`)) 
            FROM librodiario 
            WHERE librodiario.`CuentaPUC`=(SELECT Cuenta) 
            AND librodiario.`Tercero_Identificacion`=(SELECT Identificacion) 
            AND librodiario.`Fecha`<'$FechaInicial') AS Saldo_Anterior,
            SUM(`Debito`) AS Debitos,SUM(`Credito`) AS Creditos,(SUM(`Debito`)-SUM(`Credito`)) AS Neto,
            idEmpresa,idCentroCosto
            FROM `librodiario`
            WHERE Fecha>='$FechaInicial' AND Fecha <='$FechaFinal' $CondicionEmpresa $CondicionCentroCostos
            GROUP BY `Tercero_Identificacion` ORDER BY SUBSTRING(`CuentaPUC`,1,8) ;";         
        $this->Query($sql);
        
    }
    
    
    /**
     * Fin Clase
     */
}
