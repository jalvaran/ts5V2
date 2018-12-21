<?php
/* 
 * Clase donde se realizaran procesos para documentos equivalente.
 * Julian Alvaran
 * Techno Soluciones SAS
 * 2018-04-17
 */
//include_once '../../php_conexion.php';
class DocumentoEquivalente extends ProcesoVenta{
    public function CrearDocumentoEquivalente($Fecha,$idTercero, $Vector) {
       
        $tab="documento_equivalente";
        
        $NumRegistros=2;

        $Columnas[0]="Fecha";           $Valores[0]=$Fecha;
        $Columnas[1]="Tercero";         $Valores[1]=$idTercero;
        
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        
        $idDocumento=$this->ObtenerMAX($tab,"ID", 1,"");
        return $idDocumento;
    }
    
    //Clase para agregar un item a un sistema
    public function AgregarItemADocumento($idDocumento,$Descripcion,$Cantidad,$ValorUnitario,$Vector) {
        $tab="documento_equivalente_items";
        $NumRegistros=5;

        $Columnas[0]="Descripcion";		$Valores[0]=$Descripcion;
        $Columnas[1]="Cantidad";		$Valores[1]=$Cantidad;
        $Columnas[2]="ValorUnitario";		$Valores[2]=$ValorUnitario;
        $Columnas[3]="Total";                   $Valores[3]=$Cantidad*$ValorUnitario;
        $Columnas[4]="idDocumento";             $Valores[4]=$idDocumento;
        

        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    }
    
    //Clase para guardar un documento
    public function GuardarDocumento($idDocumento,$Vector) {
        $this->ActualizaRegistro("documento_equivalente", "Estado", "CE", "ID", $idDocumento);
    }
    
    //Fin Clases
}