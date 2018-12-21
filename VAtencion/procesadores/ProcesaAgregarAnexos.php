<?php 
$obVenta=new ProcesoVenta($idUser);
// si se requiere guardar y cerrar
if(isset($_REQUEST["BtnAgregarAnexo"])){
    
    $idCotizacion=$obVenta->normalizar($_REQUEST["idCotizacion"]);
    $Texto=$obVenta->normalizar($_REQUEST["TxtAnexo"]);
    $Titulo=$obVenta->normalizar($_REQUEST["TxtTitulo"]);
    $tab="cotizaciones_anexos";
    $NumRegistros=5; 

    $Columnas[0]="FechaCreacion";      $Valores[0]=date("Y-m-d H:i:s");
    $Columnas[1]="Titulo";             $Valores[1]=$Titulo;
    $Columnas[2]="NumCotizacion";      $Valores[2]=$idCotizacion;
    $Columnas[3]="Anexo";              $Valores[3]=$Texto;
    $Columnas[4]="idUsuario";          $Valores[4]=$idUser;
    

    $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);       
    header("location:$myPage?idCotizacion=$idCotizacion");
    
}
///////////////fin
?>