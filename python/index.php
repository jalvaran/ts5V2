<?php 
$output = array();
echo "hola ps ";
echo("C:\Python27\python.exe D:\xampp\htdocs\SCTV5\python\serie.py");
exec("C:\Python27\python.exe D:\xampp\htdocs\SCTV5\python\serie.py",$output);

print $output[0]; 
 ?>