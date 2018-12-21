<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Graficas</title>
    <script src="js/jquery.min.js"></script>
    
    <script type="text/javascript" src="js/graficas.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['gauge']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Actividades', 0],
          ['Temperatura', 0],
          ['Marcelo', 0]
         
        ]);

        var options = {
          width: 400, height: 400,
          redFrom: 90, redTo: 100,
          yellowFrom:75, yellowTo: 90,
          minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('Medidores'));

        chart.draw(data, options);

        setInterval(function() {
            var JSON=$.ajax({
                url:"Consultas/DatosActividades.php?q=1",
                dataType: 'json',
                async: false}).responseText;
            var Respuesta=jQuery.parseJSON(JSON);
            
          data.setValue(0, 1,Respuesta[0].humedad);
          data.setValue(1, 1,Respuesta[0].temperatura);
          data.setValue(2, 1,Respuesta[0].humedad);
          chart.draw(data, options);
        }, 1300);
        
      }
    </script>
</head>
<body>
       <div id="Medidores" ></div>
   
</body>
</html>