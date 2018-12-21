<?php 
$myPage="DiasCompracion.php";
include_once("../sesiones/php_control.php");

$AnoActual=date("Y");
$DiaActual=date("d");

$obVenta = new ProcesoVenta($idUser);

$Fecha[0] = date('Y-m-d');

$Fecha[1] = strtotime ( '-1 day' , strtotime ( $Fecha[0] ) ) ;
$Fecha[1] = date ( 'Y-m-d' , $Fecha[1] );

$Fecha[2] = strtotime ( '-2 day' , strtotime ( $Fecha[0] ) ) ;
$Fecha[2] = date ( 'Y-m-d' , $Fecha[2] );

$Fecha[3] = strtotime ( '-1 year' , strtotime ( $Fecha[0] ) ) ;
$Fecha[3] = date ( 'Y-m-d' , $Fecha[3] );

$Fecha[4] = strtotime ( '-1 year' , strtotime ( $Fecha[1] ) ) ;
$Fecha[4] = date ( 'Y-m-d' , $Fecha[4] );

$Fecha[5] = strtotime ( '-1 year' , strtotime ( $Fecha[2] ) ) ;
$Fecha[5] = date ( 'Y-m-d' , $Fecha[5] );

$Fecha[6] = strtotime ( '-2 year' , strtotime ( $Fecha[0] ) ) ;
$Fecha[6] = date ( 'Y-m-d' , $Fecha[6] );

$Fecha[7] = strtotime ( '-2 year' , strtotime ( $Fecha[1] ) ) ;
$Fecha[7] = date ( 'Y-m-d' , $Fecha[7] );

$Fecha[8] = strtotime ( '-2 year' , strtotime ( $Fecha[2] ) ) ;
$Fecha[8] = date ( 'Y-m-d' , $Fecha[8] );


$sql="SELECT '$Fecha[0]' as Fecha,Sum(`Total`) as Total FROM `facturas` WHERE `FormaPago`<>'ANULADA' AND `Fecha`='$Fecha[0]'";

for($i=1;$i<=8;$i++){
    
    $sql.=" UNION ";
    $sql.="SELECT '$Fecha[$i]' as Fecha,Sum(`Total`) as Total FROM `facturas` WHERE `FormaPago`<>'ANULADA' AND `Fecha`='$Fecha[$i]'";
    
    
}
$i=0;
$consulta=$obVenta->Query($sql);
$TotalVentas=0;
while ($DatosVentas=$obVenta->FetchArray($consulta)){
    
   // print($i." ".$DatosVentas["Fecha"]." ".$DatosVentas["Total"]."<br>");
    $Totales[$i]=$DatosVentas["Total"];
    if($DatosVentas["Total"]==''){
        $Totales[$i]=0;
    }
    $TotalVentas=$TotalVentas+$Totales[$i];
    $i++;
}

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Comparacion Diaria</title>

		<script type="text/javascript" src="js/jquery.min.js"></script>
                <style type="text/css">

		</style>
		<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        title: {
            text: 'Comparacion de ventas diaria TS5'
        },
        xAxis: {
            categories: [<?php echo $DiaActual-2; ?>, <?php echo $DiaActual-1; ?>, <?php echo $DiaActual; ?>]
        },
        labels: {
            items: [{
                html: 'Ventas Totales <?php echo number_format($TotalVentas); ?>',
                style: {
                    left: '80px',
                    top: '1px',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
                }
            }]
        },
        series: [{
            type: 'column',
            name: <?php echo $AnoActual-2; ?>,
            data: [<?php echo $Totales[8]; ?>, <?php echo $Totales[7]; ?>, <?php echo $Totales[6]; ?> ]
        }, {
            type: 'column',
            name: <?php echo $AnoActual-1; ?>,
            data: [<?php echo $Totales[5]; ?>, <?php echo $Totales[4]; ?>, <?php echo $Totales[3]; ?> ]
        }, {
            type: 'column',
            name: <?php echo $AnoActual; ?>,
            data: [<?php echo $Totales[2]; ?>, <?php echo $Totales[1]; ?>, <?php echo $Totales[0]; ?> ]
        }, {
            type: 'spline',
            name: 'Promedio',
            data: [<?php echo round(($Totales[2]+$Totales[5]+$Totales[8])/3); ?>, 
                    <?php echo round(($Totales[1]+$Totales[4]+$Totales[7])/3); ?>, 
                    <?php echo round(($Totales[0]+$Totales[3]+$Totales[6])/3); ?> ],
            marker: {
                lineWidth: 2,
                lineColor: Highcharts.getOptions().colors[3],
                fillColor: 'white'
            }
        }, {
            type: 'pie',
            name: 'Total Ventas',
            data: [{
                name: <?php echo $AnoActual-2; ?>,
                y: <?php echo $Totales[6]+$Totales[7]+$Totales[8]; ?> ,
                color: Highcharts.getOptions().colors[0] 
            }, {
                name: <?php echo $AnoActual-1; ?>,
                y: <?php echo $Totales[3]+$Totales[4]+$Totales[5]; ?>,
                color: Highcharts.getOptions().colors[1]
            }, {
                name: <?php echo $AnoActual; ?>,
                y: <?php echo $Totales[0]+$Totales[1]+$Totales[2]; ?>,
                color: Highcharts.getOptions().colors[2] 
            }],
            center: [1, 1],
            size: 70,
            showInLegend: false,
            dataLabels: {
                enabled: false
            }
        }]
    });
});


		</script>
	</head>
	<body>
<script src="js/highcharts.js"></script>
<script src="js/modules/exporting.js"></script>
<a href="../VMenu/Menu.php"><img src="../images/homesmall.png" title='Volver'></a>
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

	</body>
</html>
