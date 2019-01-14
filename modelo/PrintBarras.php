<?php
/* 
 * Clase donde se realizaran procesos de compras u otros modulos.
 * Julian Alvaran
 * Techno Soluciones SAS
 */
include_once 'php_conexion.php';
class Barras extends ProcesoVenta{
    public function ImprimirCBZebraLP2814($Tabla,$idProducto,$Cantidad,$Puerto,$DatosCB){
        `mode $Puerto: BAUD=9600 PARITY=N data=8 stop=1 xon=off`;  //inicializamos el puerto
        if(($handle = @fopen("$Puerto", "a")) === FALSE){
            die("<script>alert( 'ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA')</script>");
        }
        sleep(4);
        if(!isset($DatosCB["CodigoBarras"])){
            $sql="SELECT CodigoBarras FROM prod_codbarras WHERE ProductosVenta_idProductosVenta='$idProducto' LIMIT 1";
            $Consulta =  $this->Query($sql);
            $DatosCodigo=  $this->FetchArray($Consulta);  
            $Codigo=$DatosCodigo["CodigoBarras"]; 
        }else{
            $Codigo=$DatosCB["CodigoBarras"]; 
        }
        
        
        $idEmpresaPro=$DatosCB["EmpresaPro"];
        $DatosEmpresa=$this->DevuelveValores("empresapro", "idEmpresaPro", $idEmpresaPro);
        $fecha=date("y-m-d");
        $DatosConfigCB = $this->DevuelveValores("config_codigo_barras", "ID", 1);
        $RazonSocial=substr($DatosConfigCB["TituloEtiqueta"],0,17);
        $DatosProducto=$this->DevuelveValores($Tabla, "idProductosVenta", $idProducto);
       
        $Descripcion=substr($DatosProducto["Nombre"],0,20);
        $PrecioVenta= number_format($DatosProducto["PrecioVenta"]);
        
        $ID= $DatosProducto["idProductosVenta"];
        if($ID<1000){
          $Codigo=str_pad($ID, 4, "0", STR_PAD_LEFT);; 
        }else{
          $Codigo=$ID;
        }
        $enter='\r\n';
        
        fwrite($handle,"^XA".$enter);
        fwrite($handle,'^PQ'.$Cantidad.',1,1,Y'.$enter);
		
        fwrite($handle,"^FO60,10".$enter);
        fwrite($handle,"^ADN,14,15".$enter);
        fwrite($handle,'^FD'.$RazonSocial.'^FS'.$enter);
		
		fwrite($handle,"^FO320,10".$enter);
        fwrite($handle,"^ADN,14,15".$enter);
        fwrite($handle,'^FD'.$RazonSocial.'^FS'.$enter);
		
		fwrite($handle,"^FO600,10".$enter);
        fwrite($handle,"^ADN,14,15".$enter);
        fwrite($handle,'^FD'.$RazonSocial.'^FS'.$enter);
		
        fwrite($handle,'^FO30,35'.$enter);
        fwrite($handle,'^ADN,10,10'.$enter);
        fwrite($handle,'^FD'.$ID.' '.$Descripcion.'^FS'.$enter);
		
		fwrite($handle,'^FO300,35'.$enter);
        fwrite($handle,'^ADN,10,10'.$enter);
        fwrite($handle,'^FD'.$ID.' '.$Descripcion.'^FS'.$enter);
		
		fwrite($handle,'^FO580,35'.$enter);
        fwrite($handle,'^ADN,10,10'.$enter);
        fwrite($handle,'^FD'.$ID.' '.$Descripcion.'^FS'.$enter);
		
        fwrite($handle,'^FO30,65^BY2'.$enter);
        fwrite($handle,'^BCN,30,Y,N,N'.$enter);
        fwrite($handle,'^FD'.$Codigo.'^FS'.$enter);
		
		fwrite($handle,'^FO300,65^BY2'.$enter);
        fwrite($handle,'^BCN,30,Y,N,N'.$enter);
        fwrite($handle,'^FD'.$Codigo.'^FS'.$enter);
		
		fwrite($handle,'^FO580,65^BY2'.$enter);
        fwrite($handle,'^BCN,30,Y,N,N'.$enter);
        fwrite($handle,'^FD'.$Codigo.'^FS'.$enter);
		
        fwrite($handle,'^FO40,120'.$enter);
        fwrite($handle,'^ADN,36,20'.$enter);
        fwrite($handle,'^FD'.$PrecioVenta.'^FS'.$enter);
		
		fwrite($handle,'^FO320,120'.$enter);
        fwrite($handle,'^ADN,36,20'.$enter);
        fwrite($handle,'^FD'.$PrecioVenta.'^FS'.$enter);
		
		fwrite($handle,'^FO600,120'.$enter);
        fwrite($handle,'^ADN,36,20'.$enter);
        fwrite($handle,'^FD'.$PrecioVenta.'^FS'.$enter);
		
        fwrite($handle,'^XZ'.$enter);
       
        $salida = shell_exec('lpr $Puerto');
     }
      
     /*
     * Impresoras TSC
     * 
     */
    
     
     public function ImprimirCodigoBarras($Tabla,$idProducto,$Cantidad,$Puerto,$DatosCB){
        `mode $Puerto: BAUD=9600 PARITY=N data=8 stop=1 xon=off`;  //inicializamos el puerto
        if(($handle = @fopen("$Puerto", "w")) === FALSE){
            die("<script>alert( 'ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA')</script>");
        }
        
        $DatosProducto=$this->DevuelveValores("productosventa", "idProductosVenta", $idProducto);
        $Codigo= $DatosProducto["idProductosVenta"];
        if($Codigo<1000){
          $Codigo=str_pad($Codigo, 4, "0", STR_PAD_LEFT);
        }
        $Cantidad=$Cantidad/3;
        $Numpages=ceil($Cantidad);
        $idEmpresaPro=$DatosCB["EmpresaPro"];
        $DatosEmpresa=$this->DevuelveValores("empresapro", "idEmpresaPro", $idEmpresaPro);
        $fecha=date("y-m-d");
        $DatosConfigCB = $this->DevuelveValores("config_codigo_barras", "ID", 1);
        $RazonSocial=substr($DatosConfigCB["TituloEtiqueta"],0,17);
        $DatosProducto=$this->DevuelveValores($Tabla, "idProductosVenta", $idProducto);
       
        $Descripcion=substr($DatosProducto["Nombre"],0,16);
        $PrecioVenta= number_format($DatosProducto["PrecioVenta"]);
        $Referencia= $DatosProducto["Referencia"];
        $ID= $DatosProducto["idProductosVenta"];
        $Costo2= substr($DatosProducto["CostoUnitario"], 1, -1);
        $Costo1= substr($DatosProducto["CostoUnitario"], 0, 1);
        $Costo=$Costo1."/".$Costo2;
        $enter="\r\n";
        
        $L1=$DatosConfigCB["DistaciaEtiqueta1"];
        $L2=$DatosConfigCB["DistaciaEtiqueta2"];
        $L3=$DatosConfigCB["DistaciaEtiqueta3"];
        $AL1=$DatosConfigCB["AlturaLinea1"];
        $AL2=$DatosConfigCB["AlturaLinea2"];
        $AL3=$DatosConfigCB["AlturaLinea3"];
        $AL4=$DatosConfigCB["AlturaLinea4"];
        $AL5=$DatosConfigCB["AlturaLinea5"];
        $AlturaCB=$DatosConfigCB["AlturaCodigoBarras"];
        if(strlen($PrecioVenta)>7){
            $TamPrecio=2;
        }else{
            $TamPrecio=4;
        }
        

        fwrite($handle,"SIZE 4,1.1".$enter);
        fwrite($handle,"GAP 4 mm,0".$enter);
        fwrite($handle,"DIRECTION 1".$enter);
        fwrite($handle,"CLS".$enter);
        fwrite($handle,'TEXT '.$L1.','.$AL1.',"2",0,1,1,"'.$RazonSocial.'"'.$enter);
        fwrite($handle,'TEXT '.$L1.','.$AL2.',"1",0,1,1,"'.$Referencia.' '.$fecha.' '.$Costo.'"'.$enter);
        fwrite($handle,'TEXT '.$L1.','.$AL3.',"1",0,1,1,"'.$ID.' '.$Descripcion.'"'.$enter);
        fwrite($handle,'BARCODE '.$L1.','.$AL4.',"128",'.$AlturaCB.',1,0,2,2,"'.$Codigo.'"'.$enter);
        fwrite($handle,'TEXT '.$L1.','.$AL5.',"'.$TamPrecio.'",0,1,1,"$ '.$PrecioVenta.'"'.$enter);

        fwrite($handle,'TEXT '.$L2.','.$AL1.',"2",0,1,1,"'.$RazonSocial.'"'.$enter);
        fwrite($handle,'TEXT '.$L2.','.$AL2.',"1",0,1,1,"'.$Referencia.' '.$fecha.' '.$Costo.'"'.$enter);
        fwrite($handle,'TEXT '.$L2.','.$AL3.',"1",0,1,1,"'.$ID.' '.$Descripcion.'"'.$enter);
        fwrite($handle,'BARCODE '.$L2.','.$AL4.',"128",'.$AlturaCB.',1,0,2,2,"'.$Codigo.'"'.$enter);
        fwrite($handle,'TEXT '.$L2.','.$AL5.',"'.$TamPrecio.'",0,1,1,"$ '.$PrecioVenta.'"'.$enter);

        fwrite($handle,'TEXT '.$L3.','.$AL1.',"2",0,1,1,"'.$RazonSocial.'"'.$enter);
        fwrite($handle,'TEXT '.$L3.','.$AL2.',"1",0,1,1,"'.$Referencia.' '.$fecha.' '.$Costo.'"'.$enter);
        fwrite($handle,'TEXT '.$L3.','.$AL3.',"1",0,1,1,"'.$ID.' '.$Descripcion.'"'.$enter);
        fwrite($handle,'BARCODE '.$L3.','.$AL4.',"128",'.$AlturaCB.',1,0,2,2,"'.$Codigo.'"'.$enter);
        fwrite($handle,'TEXT '.$L3.','.$AL5.',"'.$TamPrecio.'",0,1,1,"$ '.$PrecioVenta.'"'.$enter);
        fwrite($handle,"PRINT $Numpages".$enter);

        $salida = shell_exec('lpr $Puerto');
     }
     
     //imprime codigo barras monarch
    
    public function ImprimirCodigoBarrasMonarch9416TM($Tabla,$idProducto,$Cantidad,$Puerto,$DatosCB){
        $Left1=45;
        $Left2=385;
        $Left3=720;
        $Config="{I,B,1,1,0,0 | }";  //Se configura para GAP
        `mode $Puerto: BAUD=9600 PARITY=N data=8 stop=1 xon=off`;  //inicializamos el puerto
        $enter="\r\n";
        if(($handle = @fopen("$Puerto", "w")) === FALSE){
            die("No se puedo Imprimir, Verifique la conexion de la IMPRESORA");
        }
        if(!isset($DatosCB["CodigoBarras"])){
            $sql="SELECT CodigoBarras FROM prod_codbarras WHERE ProductosVenta_idProductosVenta='$idProducto' LIMIT 1";
            $Consulta =  $this->Query($sql);
            $DatosCodigo=  $this->FetchArray($Consulta);  
            $Codigo=$DatosCodigo["CodigoBarras"]; 
        }else{
            $Codigo=$DatosCB["CodigoBarras"]; 
        }
        
        $Codigo=$idProducto;
        //$Cantidad=$Cantidad/3;
        //$Numpages=ceil($Cantidad);
        $Numpages=$Cantidad;
        $idEmpresaPro=$DatosCB["EmpresaPro"];
        $DatosEmpresa=$this->DevuelveValores("empresapro", "idEmpresaPro", $idEmpresaPro);
        $fecha=date("y-m-d");
        $DatosConfigCB = $this->DevuelveValores("config_codigo_barras", "ID", 1);
        $RazonSocial=substr($DatosConfigCB["TituloEtiqueta"],0,13);
        $DatosProducto=$this->DevuelveValores($Tabla, "idProductosVenta", $idProducto);
       
        $Descripcion=substr($DatosProducto["Nombre"],0,22);
        $PrecioVenta= number_format($DatosProducto["PrecioVenta"]);
        $Referencia= $DatosProducto["Referencia"];
        $ID= $DatosProducto["idProductosVenta"];
        $Costo2= substr($DatosProducto["CostoUnitario"], 1, -1);
        $Costo1= substr($DatosProducto["CostoUnitario"], 0, 1);
        $Costo=$Costo1."/".$Costo2;
        //fwrite($handle,$Config);
        fwrite($handle,'{F,25,A,R,M,508,1080,"Code-128" |
                        T,1,18,V,220,'.$Left1.',1,1,1,1,B,C,0,0,1 |
                        B,2,2710,V,165,'.$Left1.',8,0,50,0,L,0 |
                        T,3,30,V,145,'.$Left1.',1,2,1,1,B,C,0,0,1 |
                        T,4,30,V,123,'.$Left1.',1,2,1,1,B,C,0,0,1 |
                        T,5,23,V,100,'.$Left1.',1,2,1,1,B,C,0,0,1 |
                        T,6,18,V,45,'.$Left1.',1,3,1,1,B,L,0,0,1 |
                        T,7,18,V,220,'.$Left2.',1,1,1,1,B,C,0,0,1 |
                        B,8,2710,V,165,'.$Left2.',8,0,50,0,L,0 |
                        T,9,30,V,145,'.$Left2.',1,2,1,1,B,C,0,0,1 |
                        T,10,30,V,123,'.$Left2.',1,2,1,1,B,C,0,0,1 |
                        T,11,23,V,100,'.$Left2.',1,2,1,1,B,C,0,0,1 |
                        T,12,18,V,45,'.$Left2.',1,3,1,1,B,L,0,0,1 |
                        T,13,18,V,220,'.$Left3.',1,1,1,1,B,C,0,0,1 |    
                        B,14,2710,V,165,'.$Left3.',8,0,50,0,L,0 |
                        T,15,30,V,145,'.$Left3.',1,2,1,1,B,C,0,0,1 |
                        T,16,30,V,123,'.$Left3.',1,2,1,1,B,C,0,0,1 |
                        T,17,23,V,100,'.$Left3.',1,2,1,1,B,C,0,0,1 |
                        T,18,18,V,45,'.$Left3.',1,3,1,1,B,L,0,0,1 |}
                        {B,25,N,'.$Numpages.' |
                        1,"'.$RazonSocial.'" | 
                        2,"'.$Codigo.'" |
                        3,"'.$Codigo.' '.$Referencia.'" |
                        4,"'.$fecha.' '.$Costo.'" |
                        5,"'.$Descripcion.'" |
                        6,"'.$PrecioVenta.'"|
                        7,"'.$RazonSocial.'" |     
                        8,"'.$Codigo.'" |
                        9,"'.$Codigo.' '.$Referencia.'" |
                        10,"'.$fecha.' '.$Costo.'" |
                        11,"'.$Descripcion.'" |
                        12,"'.$PrecioVenta.'"|
                        13,"'.$RazonSocial.'" | 
                        14,"'.$Codigo.'" |
                        15,"'.$Codigo.' '.$Referencia.'" |
                        16,"'.$fecha.' '.$Costo.'" |
                        17,"'.$Descripcion.'" |
                        18,"'.$PrecioVenta.'"|}');
        

        $salida = shell_exec('lpr $Puerto');
        
     }
         
      //imprime tikete corto en monarch
    
    public function ImprimirTiketCortoMonarch($Tabla,$idProducto,$Cantidad,$Puerto,$DatosCB){
        $T=10;              $Factor=159;
        $L1=100;            $L2=125;            $L3=190;    
        $L4=$L1+$Factor;    $L5=$L2+$Factor;    $L6=$L3+$Factor;    
        $L7=$L4+$Factor;    $L8=$L5+$Factor;    $L9=$L6+$Factor;   //510  $L6+160
        $L10=$L7+$Factor;   $L11=$L8+$Factor;   $L12=$L9+$Factor;    
        $L13=$L10+$Factor;  $L14=$L11+$Factor;  $L15=$L12+$Factor;    
        $L16=$L13+$Factor;  $L17=$L14+$Factor;  $L18=$L15+$Factor;
        $Config="{I,B,1,1,0,0 | }";
        `mode $Puerto: BAUD=9600 PARITY=N data=8 stop=1 xon=off`;  //inicializamos el puerto
        $enter="\r\n";
        if(($handle = @fopen("$Puerto", "w")) === FALSE){
            die("<script>alert( 'ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA')</script>");
        }
        if(!isset($DatosCB["CodigoBarras"])){
            $sql="SELECT CodigoBarras FROM prod_codbarras WHERE ProductosVenta_idProductosVenta='$idProducto' LIMIT 1";
            $Consulta =  $this->Query($sql);
            $DatosCodigo=  $this->FetchArray($Consulta);  
            $Codigo=$DatosCodigo["CodigoBarras"]; 
        }else{
            $Codigo=$DatosCB["CodigoBarras"]; 
        }
        
        $Codigo=$idProducto;
        //$Cantidad=$Cantidad/3;
        //$Numpages=ceil($Cantidad);
        $Numpages=$Cantidad;
        $idEmpresaPro=$DatosCB["EmpresaPro"];
        $DatosEmpresa=$this->DevuelveValores("empresapro", "idEmpresaPro", $idEmpresaPro);
        $fecha=date("y-m-d");
        $DatosConfigCB = $this->DevuelveValores("config_codigo_barras", "ID", 1);
        $RazonSocial=substr($DatosConfigCB["TituloEtiqueta"],0,14);
        $DatosProducto=$this->DevuelveValores($Tabla, "idProductosVenta", $idProducto);
       
        $Descripcion=substr($DatosProducto["Nombre"],0,14);
        $Descripcion2=substr($DatosProducto["Nombre"],14,14);
        $PrecioVenta= number_format($DatosProducto["PrecioVenta"]);
        $Referencia= $DatosProducto["Referencia"];
        $ID= $DatosProducto["idProductosVenta"];
        $Costo2= substr($DatosProducto["CostoUnitario"], 1, -1);
        $Costo1= substr($DatosProducto["CostoUnitario"], 0, 1);
        $Costo=$Costo1."/".$Costo2;
        //fwrite($handle,$Config);
        //sleep(1);
        fwrite($handle,'{F,25,A,R,M,508,1080,"Code-128" |
                        T,1,18,V,'.$T.','.$L1.',1,2,1,1,B,C,0,1,1 |
                        T,2,30,V,'.$T.','.$L2.',1,2,1,1,B,C,0,1,1 |
                        T,3,23,V,'.$T.','.$L3.',1,1,2,1,B,C,0,1,1 |
                        T,4,18,V,'.$T.','.$L4.',1,2,1,1,B,C,0,1,1 |
                        T,5,30,V,'.$T.','.$L5.',1,2,1,1,B,C,0,1,1 |
                        T,6,23,V,'.$T.','.$L6.',1,1,2,1,B,C,0,1,1 |
                        T,7,18,V,'.$T.','.$L7.',1,2,1,1,B,C,0,1,1 |
                        T,8,30,V,'.$T.','.$L8.',1,2,1,1,B,C,0,1,1 |
                        T,9,23,V,'.$T.','.$L9.',1,1,2,1,B,C,0,1,1 |
                        T,10,18,V,'.$T.','.$L10.',1,2,1,1,B,C,0,1,1 |
                        T,11,30,V,'.$T.','.$L11.',1,2,1,1,B,C,0,1,1 |
                        T,12,23,V,'.$T.','.$L12.',1,1,2,1,B,C,0,1,1 |
                        T,13,18,V,'.$T.','.$L13.',1,2,1,1,B,C,0,1,1 |
                        T,14,30,V,'.$T.','.$L14.',1,2,1,1,B,C,0,1,1 |
                        T,15,23,V,'.$T.','.$L15.',1,1,2,1,B,C,0,1,1 |
                        T,16,18,V,'.$T.','.$L16.',1,2,1,1,B,C,0,1,1 |
                        T,17,30,V,'.$T.','.$L17.',1,2,1,1,B,C,0,1,1 |
                        T,18,23,V,'.$T.','.$L18.',1,1,2,1,B,C,0,1,1 |}
                        {B,25,N,'.$Cantidad.' |
                        1,"'.$Descripcion.'" | 
                        2,"'.$Descripcion2.'" |
                        3,"'.$PrecioVenta.'" |
                        4,"'.$Descripcion.'" | 
                        5,"'.$Descripcion2.'" |
                        6,"'.$PrecioVenta.'" |
                        7,"'.$Descripcion.'" | 
                        8,"'.$Descripcion2.'" |
                        9,"'.$PrecioVenta.'" |
                        10,"'.$Descripcion.'" | 
                        11,"'.$Descripcion2.'" |
                        12,"'.$PrecioVenta.'" |
                        13,"'.$Descripcion.'" | 
                        14,"'.$Descripcion2.'" |
                        15,"'.$PrecioVenta.'" |
                        16,"'.$Descripcion.'" | 
                        17,"'.$Descripcion2.'" |
                        18,"'.$PrecioVenta.'" |}');
        
        $salida = shell_exec('lpr $Puerto');
        
     }
     
     //imprime codigo barras monarch
    
    public function ImprimirLabelMonarch($Tabla,$idProducto,$Cantidad,$Puerto,$DatosCB){
        $Left1=180;
        $Left2=150;
        $Left3=550;
        $Config="{I,B,0,1,0,0 | }";
        `mode $Puerto: BAUD=9600 PARITY=N data=8 stop=1 xon=off`;  //inicializamos el puerto
        $enter="\r\n";
        if(($handle = @fopen("$Puerto", "w")) === FALSE){
            die("<script>alert( 'ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA')</script>");
        }
        if(!isset($DatosCB["CodigoBarras"])){
            $sql="SELECT CodigoBarras FROM prod_codbarras WHERE ProductosVenta_idProductosVenta='$idProducto' LIMIT 1";
            $Consulta =  $this->Query($sql);
            $DatosCodigo=  $this->FetchArray($Consulta);  
            $Codigo=$DatosCodigo["CodigoBarras"]; 
        }else{
            $Codigo=$DatosCB["CodigoBarras"]; 
        }
        
        $Codigo=$idProducto;
        $Numpages=$Cantidad;
        $idEmpresaPro=$DatosCB["EmpresaPro"];
        $DatosEmpresa=$this->DevuelveValores("empresapro", "idEmpresaPro", $idEmpresaPro);
        $fecha=date("y-m-d");
        $DatosConfigCB = $this->DevuelveValores("config_codigo_barras", "ID", 1);
        $RazonSocial=substr($DatosConfigCB["TituloEtiqueta"],0,13);
        $DatosProducto=$this->DevuelveValores($Tabla, "idProductosVenta", $idProducto);
       
        $Descripcion=substr($DatosProducto["Nombre"],0,22);
        $Descripcion2=substr($DatosProducto["Nombre"],22,40);
        $PrecioVenta= number_format($DatosProducto["PrecioVenta"]);
        $Referencia= $DatosProducto["Referencia"];
        $ID= $DatosProducto["idProductosVenta"];
        $Costo2= substr($DatosProducto["CostoUnitario"], 1, -1);
        $Costo1= substr($DatosProducto["CostoUnitario"], 0, 1);
        $Costo=$Costo1."/".$Costo2;
        //fwrite($handle,$Config);        
        fwrite($handle,'{F,26,A,R,M,508,1080,"" |
                        T,1,18,V,270,'.$Left1.',1,1,3,3,B,C,0,0,1 |
                        T,2,24,V,200,'.$Left2.',1,1,2,1,B,C,0,0,1 |
                        T,3,24,V,130,'.$Left2.',1,1,2,1,B,C,0,0,1 |    
                        T,4,24,V,50,'.$Left3.',1,1,4,4,B,C,0,0,1 |}
                        {B,26,N,'.$Numpages.' |
                        1,"'.$RazonSocial.'" |
                        2,"'.$Descripcion.'"|
                        3,"'.$Descripcion2.'"|    
                        4,"'.$PrecioVenta.'"| }');
        $salida = shell_exec('lpr $Puerto');
        
     }
     
     //imprime codigo barras monarch
    
    public function ConfigPrintMonarch($TipoPapel,$Puerto,$DatosCB){
        $Left1=180;
        $Left2=150;
        $Left3=550;
        $Config="{I,B,".$TipoPapel.",1,0,0 | }"; //0 marca negra, 1 GAP, 2 Continuo //Es comando configura para marca negra
        `mode $Puerto: BAUD=9600 PARITY=N data=8 stop=1 xon=off`;  //inicializamos el puerto
        $enter="\r\n";
        if(($handle = @fopen("$Puerto", "w")) === FALSE){
            die("<script>alert( 'ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA')</script>");
        }
        
        fwrite($handle,$Config);
        $salida = shell_exec('lpr $Puerto');  
        
     }
     
     //imprime codigo barras para un sistema
    
    public function CodigoBarrasSistemaMonarch9416TM($Tabla,$idProducto,$Cantidad,$Puerto,$DatosCB){
        $Left1=45;
        $Left2=385;
        $Left3=720;
        $Config="{I,B,1,1,0,0 | }";  //Se configura para GAP
        `mode $Puerto: BAUD=9600 PARITY=N data=8 stop=1 xon=off`;  //inicializamos el puerto
        $enter="\r\n";
        if(($handle = @fopen("$Puerto", "w")) === FALSE){
            die("<script>alert( 'ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA')</script>");
        }
        if(!isset($DatosCB["CodigoBarras"])){
            $sql="SELECT CodigoBarras FROM prod_codbarras WHERE ProductosVenta_idProductosVenta='$idProducto' LIMIT 1";
            $Consulta =  $this->Query($sql);
            $DatosCodigo=  $this->FetchArray($Consulta);  
            $Codigo=$DatosCodigo["CodigoBarras"]; 
        }else{
            $Codigo=$DatosCB["CodigoBarras"]; 
        }
        
        $Codigo=$idProducto;
        //$Cantidad=$Cantidad/3;
        //$Numpages=ceil($Cantidad);
        $Numpages=$Cantidad;
        $idEmpresaPro=$DatosCB["EmpresaPro"];
        $DatosEmpresa=$this->DevuelveValores("empresapro", "idEmpresaPro", $idEmpresaPro);
        $fecha=date("y-m-d");
        $DatosConfigCB = $this->DevuelveValores("config_codigo_barras", "ID", 1);
        $RazonSocial=substr($DatosConfigCB["TituloEtiqueta"],0,13);
        $DatosSistema=$this->DevuelveValores($Tabla, "ID", $idProducto);
       
        $Descripcion=substr($DatosSistema["Nombre"],0,22);
        $sql="SELECT sum(`ValorUnitario`*`Cantidad`) as Total FROM `sistemas_relaciones` WHERE `idSistema`='$idProducto'";
        $consulta=$this->Query($sql);
        $TotalSistema=$this->FetchArray($consulta);
        $PrecioVenta= number_format($TotalSistema["Total"]);
        $Referencia= "REF$idProducto";
        $ID= $idProducto;
        //$Costo2= substr($DatosProducto["CostoUnitario"], 1, -1);
        //$Costo1= substr($DatosProducto["CostoUnitario"], 0, 1);
        $Costo="";
        //fwrite($handle,$Config);
        fwrite($handle,'{F,25,A,R,M,508,1080,"Code-128" |
                        T,1,18,V,220,'.$Left1.',1,1,1,1,B,C,0,0,1 |
                        B,2,2710,V,165,'.$Left1.',8,0,50,0,L,0 |
                        T,3,30,V,145,'.$Left1.',1,2,1,1,B,C,0,0,1 |
                        T,4,30,V,123,'.$Left1.',1,2,1,1,B,C,0,0,1 |
                        T,5,23,V,100,'.$Left1.',1,2,1,1,B,C,0,0,1 |
                        T,6,18,V,45,'.$Left1.',1,3,1,1,B,L,0,0,1 |
                        T,7,18,V,220,'.$Left2.',1,1,1,1,B,C,0,0,1 |
                        B,8,2710,V,165,'.$Left2.',8,0,50,0,L,0 |
                        T,9,30,V,145,'.$Left2.',1,2,1,1,B,C,0,0,1 |
                        T,10,30,V,123,'.$Left2.',1,2,1,1,B,C,0,0,1 |
                        T,11,23,V,100,'.$Left2.',1,2,1,1,B,C,0,0,1 |
                        T,12,18,V,45,'.$Left2.',1,3,1,1,B,L,0,0,1 |
                        T,13,18,V,220,'.$Left3.',1,1,1,1,B,C,0,0,1 |    
                        B,14,2710,V,165,'.$Left3.',8,0,50,0,L,0 |
                        T,15,30,V,145,'.$Left3.',1,2,1,1,B,C,0,0,1 |
                        T,16,30,V,123,'.$Left3.',1,2,1,1,B,C,0,0,1 |
                        T,17,23,V,100,'.$Left3.',1,2,1,1,B,C,0,0,1 |
                        T,18,18,V,45,'.$Left3.',1,3,1,1,B,L,0,0,1 |}
                        {B,25,N,'.$Numpages.' |
                        1,"'.$RazonSocial.'" | 
                        2,"'.$Codigo.'" |
                        3,"'.$Codigo.' '.$Referencia.'" |
                        4,"'.$fecha.' '.$Costo.'" |
                        5,"'.$Descripcion.'" |
                        6,"'.$PrecioVenta.'"|
                        7,"'.$RazonSocial.'" |     
                        8,"'.$Codigo.'" |
                        9,"'.$Codigo.' '.$Referencia.'" |
                        10,"'.$fecha.' '.$Costo.'" |
                        11,"'.$Descripcion.'" |
                        12,"'.$PrecioVenta.'"|
                        13,"'.$RazonSocial.'" | 
                        14,"'.$Codigo.'" |
                        15,"'.$Codigo.' '.$Referencia.'" |
                        16,"'.$fecha.' '.$Costo.'" |
                        17,"'.$Descripcion.'" |
                        18,"'.$PrecioVenta.'"|}');
        

        $salida = shell_exec('lpr $Puerto');
        
     }
     
       //Exclusivo Diana Carvajal
    
   public function LabelImport($Cantidad,$Puerto,$DatosCB){
        $Left1=300;
        
        $Config="{I,B,1,1,0,0 | }";  //Se configura para GAP
        `mode $Puerto: BAUD=9600 PARITY=N data=8 stop=1 xon=off`;  //inicializamos el puerto
        $enter="\r\n";
        if(($handle = @fopen("$Puerto", "w")) === FALSE){
            die("<script>alert( 'ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA')</script>");
        }
        
        $Numpages=$Cantidad;
        $Linea1="Traduccion de Material";
        $Linea2="Polyuretane(Poliuretano)";
        $Linea3="Rayon(Viscosa)";
        $Linea4="Linen(Lino)";
        $Linea5="Slik(Seda)";
        $Linea6="Polyester(Poliester)";
        $Linea7="Nylon(Nailon)";
        $Linea8="Acrylic(Acrilico)";
        $Linea9="Spandex(Elastico)";
        $Linea10="Cotton(Algodon)";
        $Linea11="Style(Traduccion de Origen)";
        $Linea12="Made in (Hecho en)";
        $Linea13="Traduccion de Tallas";
        $Linea14="S-M-L-XL CH-M-G-EXG";
        $Linea15="  One Size (Talla Unica)";
        $Linea16="________________________";
        $Linea17="IMPORTADO POR";
        $Linea18="DIANA ISABEL";
        $Linea19="CARVAJAL MURILLO";
        $Linea20="NIT: 65709480-3";
        //fwrite($handle,$Config);
        fwrite($handle,'{F,25,A,R,M,508,1080,"Code-128" |
                        T,1,30,V,10,'.$Left1.',1,2,1,1,B,L,0,1,1 |
			T,2,30,V,10,'.($Left1=$Left1+27).',1,2,1,1,B,L,0,1,1 |
			T,3,30,V,10,'.($Left1=$Left1+27).',1,2,1,1,B,L,0,1,1 |
			T,4,30,V,10,'.($Left1=$Left1+27).',1,2,1,1,B,L,0,1,1 |
			T,5,30,V,10,'.($Left1=$Left1+27).',1,2,1,1,B,L,0,1,1 |
			T,6,30,V,10,'.($Left1=$Left1+27).',1,2,1,1,B,L,0,1,1 |
			T,7,30,V,10,'.($Left1=$Left1+27).',1,2,1,1,B,L,0,1,1 |
			T,8,30,V,10,'.($Left1=$Left1+27).',1,2,1,1,B,L,0,1,1 |
			T,9,30,V,10,'.($Left1=$Left1+27).',1,2,1,1,B,L,0,1,1 |
			T,10,30,V,10,'.($Left1=$Left1+27).',1,2,1,1,B,L,0,1,1 |
			T,11,30,V,10,'.($Left1=$Left1+27).',1,2,1,1,B,L,0,1,1 |
			T,12,30,V,10,'.($Left1=$Left1+27).',1,2,1,1,B,L,0,1,1 |
			T,13,30,V,10,'.($Left1=$Left1+27).',1,2,1,1,B,L,0,1,1 |
			T,14,30,V,10,'.($Left1=$Left1+27).',1,2,1,1,B,L,0,1,1 |
			T,15,30,V,10,'.($Left1=$Left1+27).',1,2,1,1,B,L,0,1,1 |
			T,16,30,V,10,'.($Left1=$Left1+27).',1,2,1,1,B,L,0,1,1 |
			T,17,30,V,10,'.($Left1=$Left1+27).',1,2,1,1,B,L,0,1,1 |
			T,18,30,V,10,'.($Left1=$Left1+27).',1,2,1,1,B,L,0,1,1 |
			T,19,30,V,10,'.($Left1=$Left1+27).',1,2,1,1,B,L,0,1,1 |
			T,20,30,V,10,'.($Left1=$Left1+27).',1,2,1,1,B,L,0,1,1 |}
                        {B,25,N,'.$Numpages.' |
			1,"'.$Linea1.'" | 
			2,"'.$Linea2.'" | 
			3,"'.$Linea3.'" | 
			4,"'.$Linea4.'" | 
			5,"'.$Linea5.'" | 
			6,"'.$Linea6.'" | 
			7,"'.$Linea7.'" | 
			8,"'.$Linea8.'" | 
			9,"'.$Linea9.'" | 
			10,"'.$Linea10.'" |
			11,"'.$Linea11.'" | 
			12,"'.$Linea12.'" | 
			13,"'.$Linea13.'" | 
			14,"'.$Linea14.'" | 
			15,"'.$Linea15.'" |
			16,"'.$Linea16.'" | 
			17,"'.$Linea17.'" | 
			18,"'.$Linea18.'" | 
			19,"'.$Linea19.'" | 
                        20,"'.$Linea20.'" |}');
        

        $salida = shell_exec('lpr $Puerto');
        
     }
     
     //imprime etiqueta zapatos
    
    public function ImprimirLabelZapatos($Cantidad,$Puerto,$DatosCB){
        $Left1=45;
        $Left2=385;
        $Left3=733;
        $Config="{I,B,1,1,0,0 | }";  //Se configura para GAP
        `mode $Puerto: BAUD=9600 PARITY=N data=8 stop=1 xon=off`;  //inicializamos el puerto
        $enter="\r\n";
        if(($handle = @fopen("$Puerto", "w")) === FALSE){
            die("<script>alert( 'ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA')</script>");
        }
        
        
        
        $Numpages=$Cantidad;
        $Linea1="IMPORTADO POR:";
        $Linea2="DIANA ISABEL";
	$Linea3="CARVAJAL";
	$Linea4="MURILLO";
	$Linea5="NIT: 65709480-3";
        
        fwrite($handle,'{F,25,A,R,M,508,1080,"Code-128" |
                        T,1,18,V,165,'.$Left1.',1,1,1,1,B,C,0,0,1 |
                        T,2,18,V,130,'.$Left1.',1,1,1,1,B,C,0,0,1 |
                        T,3,18,V,95,'.$Left1.',1,1,1,1,B,C,0,0,1 |
                        T,4,18,V,60,'.$Left1.',1,1,1,1,B,C,0,0,1 |
                        T,5,18,V,25,'.$Left1.',1,1,1,1,B,C,0,0,1 | 
			T,6,18,V,165,'.$Left2.',1,1,1,1,B,C,0,0,1 |
                        T,7,18,V,130,'.$Left2.',1,1,1,1,B,C,0,0,1 |
                        T,8,18,V,95,'.$Left2.',1,1,1,1,B,C,0,0,1 |
                        T,9,18,V,60,'.$Left2.',1,1,1,1,B,C,0,0,1 |
                        T,10,18,V,25,'.$Left2.',1,1,1,1,B,C,0,0,1 | 
			T,11,18,V,165,'.$Left3.',1,1,1,1,B,C,0,0,1 |
                        T,12,18,V,130,'.$Left3.',1,1,1,1,B,C,0,0,1 |
                        T,13,18,V,95,'.$Left3.',1,1,1,1,B,C,0,0,1 |
                        T,14,18,V,60,'.$Left3.',1,1,1,1,B,C,0,0,1 |
                        T,15,18,V,25,'.$Left3.',1,1,1,1,B,C,0,0,1 | }
                        {B,25,N,'.$Numpages.' |
                        1,"'.$Linea1.'" | 
                        2,"'.$Linea2.'" |
                        3,"'.$Linea3.'" |
                        4,"'.$Linea4.'"|
                        5,"'.$Linea5.'" | 
			6,"'.$Linea1.'" | 
                        7,"'.$Linea2.'" |
                        8,"'.$Linea3.'" |
                        9,"'.$Linea4.'"|
                        10,"'.$Linea5.'" |
			11,"'.$Linea1.'" | 
                        12,"'.$Linea2.'" |
                        13,"'.$Linea3.'" |
                        14,"'.$Linea4.'"|
                        15,"'.$Linea5.'" | }');
        

        $salida = shell_exec('lpr $Puerto');
        
     }
     
     //imprime codigo barras con diferencia de mas 10000 y menos 10000 solicitud diana carvajal
    
    public function ImprimirCodigoBarrasMonarch2($Tabla,$idProducto,$Cantidad,$Puerto,$DatosCB){
        $Left1=65;
        $Left2=415;
        $Left3=750;
        $Config="{I,B,1,1,0,0 | }";  //Se configura para GAP
        `mode $Puerto: BAUD=9600 PARITY=N data=8 stop=1 xon=off`;  //inicializamos el puerto
        $enter="\r\n";
        if(($handle = @fopen("$Puerto", "w")) === FALSE){
            die("<script>alert( 'ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA')</script>");
        }
        if(!isset($DatosCB["CodigoBarras"])){
            $sql="SELECT CodigoBarras FROM prod_codbarras WHERE ProductosVenta_idProductosVenta='$idProducto' LIMIT 1";
            $Consulta =  $this->Query($sql);
            $DatosCodigo=  $this->FetchArray($Consulta);  
            $Codigo=$DatosCodigo["CodigoBarras"]; 
        }else{
            $Codigo=$DatosCB["CodigoBarras"]; 
        }
        
        $Codigo=$idProducto;
        //$Cantidad=$Cantidad/3;
        //$Numpages=ceil($Cantidad);
        $Numpages=$Cantidad;
        $idEmpresaPro=$DatosCB["EmpresaPro"];
        $DatosEmpresa=$this->DevuelveValores("empresapro", "idEmpresaPro", $idEmpresaPro);
        $fecha=date("y-m-d");
        $DatosConfigCB = $this->DevuelveValores("config_codigo_barras", "ID", 1);
        $RazonSocial=substr($DatosConfigCB["TituloEtiqueta"],0,13);
        $DatosProducto=$this->DevuelveValores($Tabla, "idProductosVenta", $idProducto);
       
        $Descripcion=substr($DatosProducto["Nombre"],0,22);
	$PrecioVentaMiles=substr($DatosProducto["PrecioVenta"],0,-3);
	$PrecioVenta=($PrecioVentaMiles+10)."/".$PrecioVentaMiles."/".(date("y"));
        //$PrecioVenta= number_format($PrecioVenta);
	
        $Referencia= $DatosProducto["Referencia"];
        $ID= $DatosProducto["idProductosVenta"];
        $Costo2= substr($DatosProducto["CostoUnitario"], 1, -1);
        $Costo1= substr($DatosProducto["CostoUnitario"], 0, 1);
        $Costo=$Costo1."/".$Costo2;
        //fwrite($handle,$Config);
        fwrite($handle,'{F,25,A,R,M,508,1080,"Code-128" |
                        T,1,18,V,250,'.$Left1.',1,1,1,1,B,C,0,0,1 |
                        B,2,2710,V,125,'.$Left1.',8,0,50,0,L,0 |
                        T,3,30,V,105,'.$Left1.',1,2,1,1,B,C,0,0,1 |
                        T,4,30,V,83,'.$Left1.',1,2,1,1,B,C,0,0,1 |
                        T,5,23,V,60,'.$Left1.',1,2,1,1,B,C,0,0,1 |
                        T,6,18,V,2,'.$Left1.',1,1,2,1,B,L,0,0,1 |
                        T,7,18,V,180,'.$Left2.',1,1,1,1,B,C,0,0,1 |
                        B,8,2710,V,125,'.$Left2.',8,0,50,0,L,0 |
                        T,9,30,V,105,'.$Left2.',1,2,1,1,B,C,0,0,1 |
                        T,10,30,V,83,'.$Left2.',1,2,1,1,B,C,0,0,1 |
                        T,11,23,V,60,'.$Left2.',1,2,1,1,B,C,0,0,1 |
                        T,12,18,V,2,'.$Left2.',1,1,2,1,B,L,0,0,1 |
                        T,13,18,V,180,'.$Left3.',1,1,1,1,B,C,0,0,1 |    
                        B,14,2710,V,125,'.$Left3.',8,0,50,0,L,0 |
                        T,15,30,V,105,'.$Left3.',1,2,1,1,B,C,0,0,1 |
                        T,16,30,V,83,'.$Left3.',1,2,1,1,B,C,0,0,1 |
                        T,17,23,V,60,'.$Left3.',1,2,1,1,B,C,0,0,1 |
                        T,18,18,V,2,'.$Left3.',1,1,2,1,B,L,0,0,1 |}
                        {B,25,N,'.$Numpages.' |
                        1,"'.$RazonSocial.'" | 
                        2,"'.$Codigo.'" |
                        3,"'.$Codigo.' '.$Referencia.'" |
                        4,"'.$fecha.' '.$Costo.'" |
                        5,"'.$Descripcion.'" |
                        6,"'.$PrecioVenta.'"|
                        7,"'.$RazonSocial.'" |     
                        8,"'.$Codigo.'" |
                        9,"'.$Codigo.' '.$Referencia.'" |
                        10,"'.$fecha.' '.$Costo.'" |
                        11,"'.$Descripcion.'" |
                        12,"'.$PrecioVenta.'"|
                        13,"'.$RazonSocial.'" | 
                        14,"'.$Codigo.'" |
                        15,"'.$Codigo.' '.$Referencia.'" |
                        16,"'.$fecha.' '.$Costo.'" |
                        17,"'.$Descripcion.'" |
                        18,"'.$PrecioVenta.'"|}');
        

        $salida = shell_exec('lpr $Puerto');
        
     }
     
     /**
      * Imprime solo el precio de venta
      * @param type $Tabla
      * @param type $idProducto
      * @param type $Cantidad
      * @param type $Puerto
      * @param type $DatosCB
      */
     
    public function ImprimirPrecioVentaTSC($Tabla,$idProducto,$Cantidad,$Puerto,$DatosCB){
        `mode $Puerto: BAUD=9600 PARITY=N data=8 stop=1 xon=off`;  //inicializamos el puerto
        if(($handle = @fopen("$Puerto", "w")) === FALSE){
            die("<script>alert( 'ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA')</script>");
        }
        
        $DatosProducto=$this->DevuelveValores("productosventa", "idProductosVenta", $idProducto);
        $Codigo= $DatosProducto["idProductosVenta"];
        if($Codigo<1000){
          $Codigo=str_pad($Codigo, 4, "0", STR_PAD_LEFT);
        }
        $Codigo='';
        $Cantidad=$Cantidad/3;
        $Numpages=ceil($Cantidad);
        $idEmpresaPro=$DatosCB["EmpresaPro"];
        $DatosEmpresa=$this->DevuelveValores("empresapro", "idEmpresaPro", $idEmpresaPro);
        $fecha='';
        $DatosConfigCB = $this->DevuelveValores("config_codigo_barras", "ID", 1);
        $RazonSocial='';
        $DatosProducto=$this->DevuelveValores($Tabla, "idProductosVenta", $idProducto);
       
        $Descripcion='';
        $PrecioVenta= number_format($DatosProducto["PrecioVenta"]);
        $Referencia= '';
        $ID= '';
        $Costo2= substr($DatosProducto["CostoUnitario"], 1, -1);
        $Costo1= substr($DatosProducto["CostoUnitario"], 0, 1);
        $Costo='';
        $enter="\r\n";
        
        $L1=$DatosConfigCB["DistaciaEtiqueta1"];
        $L2=$DatosConfigCB["DistaciaEtiqueta2"];
        $L3=$DatosConfigCB["DistaciaEtiqueta3"];
        $AL1=$DatosConfigCB["AlturaLinea1"];
        $AL2=$DatosConfigCB["AlturaLinea2"];
        $AL3=$DatosConfigCB["AlturaLinea3"];
        $AL4=$DatosConfigCB["AlturaLinea4"];
        $AL5=90;
        $AlturaCB=$DatosConfigCB["AlturaCodigoBarras"];
        if(strlen($PrecioVenta)>7){
            $TamPrecio=2;
        }else{
            $TamPrecio=5;
        }
        

        fwrite($handle,"SIZE 4,1.1".$enter);
        fwrite($handle,"GAP 4 mm,0".$enter);
        fwrite($handle,"DIRECTION 1".$enter);
        fwrite($handle,"CLS".$enter);
        fwrite($handle,'TEXT '.$L1.','.$AL1.',"2",0,1,1,"'.$RazonSocial.'"'.$enter);
        fwrite($handle,'TEXT '.$L1.','.$AL2.',"1",0,1,1,"'.$Referencia.' '.$fecha.' '.$Costo.'"'.$enter);
        fwrite($handle,'TEXT '.$L1.','.$AL3.',"1",0,1,1,"'.$ID.' '.$Descripcion.'"'.$enter);
        fwrite($handle,'BARCODE '.$L1.','.$AL4.',"128",'.$AlturaCB.',1,0,2,2,"'.$Codigo.'"'.$enter);
        fwrite($handle,'TEXT '.$L1.','.$AL5.',"'.$TamPrecio.'",0,1,1,"$'.$PrecioVenta.'"'.$enter);

        fwrite($handle,'TEXT '.$L2.','.$AL1.',"2",0,1,1,"'.$RazonSocial.'"'.$enter);
        fwrite($handle,'TEXT '.$L2.','.$AL2.',"1",0,1,1,"'.$Referencia.' '.$fecha.' '.$Costo.'"'.$enter);
        fwrite($handle,'TEXT '.$L2.','.$AL3.',"1",0,1,1,"'.$ID.' '.$Descripcion.'"'.$enter);
        fwrite($handle,'BARCODE '.$L2.','.$AL4.',"128",'.$AlturaCB.',1,0,2,2,"'.$Codigo.'"'.$enter);
        fwrite($handle,'TEXT '.$L2.','.$AL5.',"'.$TamPrecio.'",0,1,1,"$'.$PrecioVenta.'"'.$enter);

        fwrite($handle,'TEXT '.$L3.','.$AL1.',"2",0,1,1,"'.$RazonSocial.'"'.$enter);
        fwrite($handle,'TEXT '.$L3.','.$AL2.',"1",0,1,1,"'.$Referencia.' '.$fecha.' '.$Costo.'"'.$enter);
        fwrite($handle,'TEXT '.$L3.','.$AL3.',"1",0,1,1,"'.$ID.' '.$Descripcion.'"'.$enter);
        fwrite($handle,'BARCODE '.$L3.','.$AL4.',"128",'.$AlturaCB.',1,0,2,2,"'.$Codigo.'"'.$enter);
        fwrite($handle,'TEXT '.$L3.','.$AL5.',"'.$TamPrecio.'",0,1,1,"$'.$PrecioVenta.'"'.$enter);
        fwrite($handle,"PRINT $Numpages".$enter);

        $salida = shell_exec('lpr $Puerto');
        
     }
    //Fin Clases
}