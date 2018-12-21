<?php 
$myPage="YearsComparison.php";
include_once("../sesiones/php_control.php");

$obVenta = new ProcesoVenta($idUser);
$AnoActual=date("Y");
$AnoIni=$AnoActual-3;
$sql="SELECT SUBSTRING(`Fecha`,1,7) AS Fecha,sum(`Total`) AS Total FROM `facturas` WHERE FormaPago<>'ANULADA' AND SUBSTRING(`Fecha`,1,4)>=$AnoIni GROUP BY SUBSTRING(`Fecha`,1,7);";
$consulta=$obVenta->Query($sql);
while($DatosVentas=$obVenta->FetchArray($consulta)){
    $year= substr($DatosVentas["Fecha"], 0,4);
    $mes=substr($DatosVentas["Fecha"], 5,2);
    if($mes<10){
        $mes= str_replace('0', '', $mes);
    }
    
    $Totales[$year][$mes]=$DatosVentas["Total"];
   
}


?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Comparacion Anual</title>

		<script type="text/javascript" src="js/jquery.min.js"></script>
		<style type="text/css">
                
		</style>
		<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Comparación de ventas Anual'
        },
        subtitle: {
            text: 'TS5'
        },
        xAxis: {
            categories: [
                'Ene',
                'Feb',
                'Mar',
                'Abr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dic'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Pesos ($)'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>$ {point.y:.1f} </b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: <?php echo $AnoIni; ?> ,
            data: [<?php for($i=1;$i<=12;$i++){
                            if(isset($Totales[$AnoIni][$i])){
                                echo $Totales[$AnoIni][$i];
                            }else{
                                echo "0";
                            } 
                            echo ",";
                         } 
                         ?> 
            ]

        }, {
            name: <?php echo ++$AnoIni; ?> ,
            data: [<?php for($i=1;$i<=12;$i++){
                            if(isset($Totales[$AnoIni][$i])){
                                echo $Totales[$AnoIni][$i];
                            }else{
                                echo "0";
                            } 
                            echo ",";
                         } 
                         ?> 
            ]
        }, {
            name: <?php echo ++$AnoIni; ?> ,
            data: [<?php for($i=1;$i<=12;$i++){
                            if(isset($Totales[$AnoIni][$i])){
                                echo $Totales[$AnoIni][$i];
                            }else{
                                echo "0";
                            } 
                            echo ",";
                         } 
                         ?> 
            ]
        }, {
            name: <?php echo ++$AnoIni; ?> ,
            data: [<?php for($i=1;$i<=12;$i++){
                            if(isset($Totales[$AnoIni][$i])){
                                echo $Totales[$AnoIni][$i];
                            }else{
                                echo "0";
                            } 
                            echo ",";
                         } 
                         ?> 
            ]
        }]
    });
});
		</script>
	</head>
	<body>
            <a href="../VMenu/Menu.php"><img src="../images/homesmall.png" title='Volver'></a>
<script src="js/highcharts.js"></script>
<script src="js/modules/exporting.js"></script>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

	</body>
</html>
