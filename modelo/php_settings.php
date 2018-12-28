<?php
/* 
 * Aqui se establecen los datos de conexion a la base de datos
 */

$host="localhost";
$user="root";
$pw="pirlo1985";
$db="ts5";
 
const HOST="localhost", USER="root",PW="pirlo1985",DB="ts5";//para uso 

/* Para un servidor la combinacion deberá ser $TipoPC="Server"; $TipoKardex="Caja";
 * Para una Caja la combinacion deberá ser $TipoPC="Caja"; $TipoKardex="Caja";
 * Para un ServidorCaja la combinacion deberá ser $TipoPC="Caja"; $TipoKardex="Automatico";
 */
$TipoPC="Caja";         // Server para que al abrir el menu un timer registre las facturas en el libro diario y en el kardex, Caja para la otra opcion
$TipoKardex="Automatico"; // Automatico Para que registre automaticamente las facturas en el kardex, NO para que sea caja
$PrintAutomatico="SI";    //IMPRIME LAS FACTURAS POS AUTOMATICAMENTE SI ES SI, SI ES NO NO IMPRIME FACTURA POR POR DEFECTO
?>