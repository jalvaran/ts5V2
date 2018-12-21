<?php 
$myPage="GraficosVentasXDepartamentos.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");
$obVenta = new ProcesoVenta($idUser);

$FechaInicial=date("Y-m-d");
$FechaFinal=date("Y-m-d");
if(isset($_REQUEST["TxtFechaFin"])){
    $FechaInicial=$obVenta->normalizar($_REQUEST["TxtFechaIni"]);
    $FechaFinal=$obVenta->normalizar($_REQUEST["TxtFechaFin"]);
}

//print("$FechaInicial $FechaFinal");
$sql="SELECT `Departamento`,SUM(`Total`) AS Total FROM `vista_resumen_ventas_departamentos` "
        . "WHERE `FechaFactura`>='$FechaInicial' AND `FechaFactura`<='$FechaFinal' GROUP BY `Departamento`";
$consulta=$obVenta->Query($sql);
$i=0;
while($DatosVentas=$obVenta->FetchArray($consulta)){
    $Departamento=$DatosVentas["Departamento"];
    $DatosDepartamento=$obVenta->DevuelveValores("prod_departamentos", "idDepartamentos", $Departamento);
    
    $NombresColumnas[$i]=$DatosDepartamento["Nombre"];
    $ValoresColumnas[$i]=$DatosVentas["Total"];
    $i++;
}
//Armo consulta detallada
$ConsultaDetallada=0;
$CondSub5="";
if(!empty($_REQUEST["CmbSub5"])){
    $idDepartamento=$obVenta->normalizar($_REQUEST["CmbSub5"]);
    $CondSub5=" AND SubGrupo5='$idDepartamento' ";
}
if(!empty($_REQUEST["CmbDepartamentos"])){
    
    $idDepartamento=$obVenta->normalizar($_REQUEST["CmbDepartamentos"]);
    $TituloSub="Subgrupos del departamento $idDepartamento";
    $SubtituloSub="TS5";
    $PieSub="Subgrupos 1";
    $sql="SELECT 'NombreSub1' as Display,'prod_sub1' as Tabla,'idSub1' as idTabla,`SubGrupo1` as Subgrupo,SUM(`Total`) AS Total FROM `vista_resumen_ventas_departamentos` "
        . "WHERE `FechaFactura`>='$FechaInicial' AND `FechaFactura`<='$FechaFinal' AND Departamento='$idDepartamento' $CondSub5 GROUP BY `SubGrupo1`";
    //print($sql);
    $ConsultaDetallada=1;
}
 
//Si es por subgrupo 2
if(!empty($_REQUEST["CmbSub1"])){
    
    $idDepartamento=$obVenta->normalizar($_REQUEST["CmbSub1"]);
    $TituloSub=" Segundo Orden de Subgrupos";
    $SubtituloSub="TS5";
    $PieSub="Subgrupos 2";
    $sql="SELECT 'NombreSub2' as Display,'prod_sub2' as Tabla,'idSub2' as idTabla,`SubGrupo2` as Subgrupo,SUM(`Total`) AS Total FROM `vista_resumen_ventas_departamentos` "
        . "WHERE `FechaFactura`>='$FechaInicial' AND `FechaFactura`<='$FechaFinal' AND SubGrupo1='$idDepartamento' $CondSub5 GROUP BY `SubGrupo2`";
    //print($sql);
    $ConsultaDetallada=1;
}

//Si es por subgrupo 3
if(!empty($_REQUEST["CmbSub2"])){
    
    $idDepartamento=$obVenta->normalizar($_REQUEST["CmbSub2"]);
    $TituloSub=" Tercer Orden de Subgrupos";
    $SubtituloSub="TS5";
    $PieSub="Subgrupos 3";
    $sql="SELECT 'NombreSub3' as Display,'prod_sub3' as Tabla,'idSub3' as idTabla,`SubGrupo3` as Subgrupo,SUM(`Total`) AS Total FROM `vista_resumen_ventas_departamentos` "
        . "WHERE `FechaFactura`>='$FechaInicial' AND `FechaFactura`<='$FechaFinal' AND SubGrupo2='$idDepartamento' $CondSub5 GROUP BY `SubGrupo3`";
    //print($sql);
    $ConsultaDetallada=1;
}

//Si es por subgrupo 4
if(!empty($_REQUEST["CmbSub3"])){
    
    $idDepartamento=$obVenta->normalizar($_REQUEST["CmbSub2"]);
    $TituloSub=" Cuarto Orden de Subgrupos";
    $SubtituloSub="TS5";
    $PieSub="Subgrupos 4";
    $sql="SELECT 'NombreSub4' as Display,'prod_sub4' as Tabla,'idSub4' as idTabla,`SubGrupo4` as Subgrupo,SUM(`Total`) AS Total FROM `vista_resumen_ventas_departamentos` "
        . "WHERE `FechaFactura`>='$FechaInicial' AND `FechaFactura`<='$FechaFinal' AND SubGrupo3='$idDepartamento' $CondSub5 GROUP BY `SubGrupo4`";
    //print($sql);
    $ConsultaDetallada=1;
}

//print($sql);
if($ConsultaDetallada==1){
    $consulta=$obVenta->Query($sql);
    $i=0;
    $TotalSub=0;
    while($DatosVentas=$obVenta->FetchArray($consulta)){
        $TablaSub=$DatosVentas["Tabla"];
        $idTablaSub=$DatosVentas["idTabla"];
        $NombreSub=$DatosVentas["Display"];
        $TotalSub=$TotalSub+$DatosVentas["Total"];
        $Departamento=$DatosVentas["Subgrupo"];
        $DatosDepartamento=$obVenta->DevuelveValores($TablaSub, $idTablaSub, $Departamento);

        $NombresColumnasSub[$i]=$DatosDepartamento[$NombreSub];
        $ValoresColumnasSub[$i]=$DatosVentas["Total"];
        $i++;
        
    }
}

print("<html>");
print("<head>");

?>

		
		
<?php        
    $css =  new CssIni("Ventas x Departamentos");  
    print("</head>");
    print("<body>");
    
    //Cabecera
    $css->CabeceraIni("Ventas x Departamentos"); //Inicia la cabecera de la pagina
    $css->CabeceraFin(); 
    
        $css->CrearDiv("DivFormulario", "container", "center", 1, 1);
            $css->CrearForm2("FrmVentas", $myPage, "post", "_self");
                $css->CrearTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Ventas X Departamentos</strong>", 3);
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Fecha Inicial</strong>", 1);
                        $css->ColTabla("<strong>Fecha Final</strong>", 1);
                        $css->ColTabla("<strong>Consulta detallada</strong>", 1);
                        $css->ColTabla("<strong>Ejecutar</strong>", 1);
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        print("<td>");
                            $css->CrearInputFecha("", "TxtFechaIni", $FechaInicial, 150, 30, "");
                        print("</td>");
                        print("<td>");
                            $css->CrearInputFecha("", "TxtFechaFin", $FechaFinal, 150, 30, "");
                        print("</td>");
                        print("<td>");
                            $Page="Consultas/DatosSubgrupos.php?Valida=1&idSel=";
                            $Page2="Consultas/DatosSubgrupos.php?Valida=5&idSel=";
                            $FuncionJS="EnvieObjetoConsulta(`$Page`,`CmbDepartamentos`,`DivSub1`,`99`);"
                                    . "EnvieObjetoConsulta(`$Page2`,`CmbDepartamentos`,`DivSub5`,`99`)";
                            print("Departamento: <br>");
                            $css->CrearSelectTable("CmbDepartamentos", "prod_departamentos", "", "idDepartamentos", "idDepartamentos", "Nombre", "onChange", $FuncionJS, "", 1);
                            $css->CrearDiv("DivSub1", "", "left", 1, 1);
                            $css->CerrarDiv();
                            $css->CrearDiv("DivSub2", "", "left", 1, 1);
                            $css->CerrarDiv();
                            $css->CrearDiv("DivSub3", "", "left", 1, 1);
                            $css->CerrarDiv();
                            $css->CrearDiv("DivSub4", "", "left", 1, 1);
                            $css->CerrarDiv();
                            $css->CrearDiv("DivSub5", "", "left", 1, 1);
                            $css->CerrarDiv();
                        print("</td>");
                        print("<td>");
                        //$Page="GraficosVentasXDepartamentos.query.php";
                        //$funcion="EnvieObjetoConsulta2(`$Page`,`TxtFechaFin`,`DivGraficos`,`4`);";
                        //$css->CrearBotonEvento("BtnEnviar", "Mostrar", 1, "onclick", $funcion, "naranja", "");
                        $css->CrearBotonNaranja("BtnEnviar", "Mostrar");
                        print("</td>");
                    $css->CierraFilaTabla();
                $css->CerrarTabla();
            $css->CerrarForm();
        $css->CerrarDiv();
   
    //Div para los graficos
    $css->CrearDiv("DivGraficos", "container", "center",1,1);
        
    $css->CerrarDiv();
    $css->CrearDiv("DivGraficos2", "container", "center",1,1);
        
    $css->CerrarDiv();
    
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaJSGraficos();
    $css->AgregaSubir(); 
    
    $Titulo="Ventas X Departamentos desde $FechaInicial hasta $FechaFinal";
    $Subtitulo="TS5";
    if(isset($NombresColumnas)){
        $css->CreeGraficoBarrasSimple($Titulo, $Subtitulo, "Departamentos","Pesos ($)",$NombresColumnas, $ValoresColumnas, "DivGraficos", "");
    
    }else{
       $css->CrearDiv("DivNotificaciones", "container", "left", 1, 1);
            $css->CrearNotificacionRoja("No hay datos en este rango de tiempo", 16);
       $css->CerrarDiv();
    }
    //Si se selecciona algun subgrupo
    if(isset($NombresColumnasSub)){
        $Subtitulo="Ventas Totales: ".number_format($TotalSub);
        $css->CreeGraficoBarrasSimple($TituloSub, $Subtitulo, $PieSub,"Pesos ($)",$NombresColumnasSub, $ValoresColumnasSub, "DivGraficos2", "");
    
    }else{
       $css->CrearDiv("DivNotificaciones", "container", "left", 1, 1);
            $css->CrearNotificacionRoja("No hay datos para consulta detallada", 16);
       $css->CerrarDiv();
    }    
   
    $css->Footer();
    //unset($NombresColumnasSub,$ValoresColumnasSub,$ValoresColumnas,$ValoresColumnas);
    ////Fin HTML  
    print("</body></html>");
?> 
      