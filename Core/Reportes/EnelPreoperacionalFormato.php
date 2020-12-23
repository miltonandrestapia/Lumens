<?php

    require_once("../Procesamiento/Conexion.php");
	/*$filename = "Cepos-RelacionTotal.xls"; 
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
 */

 $consulta="SELECT a.nombre,fechaguardado,marca,placa,modelo,fechavencimientosoat,licencia,fechavencimientolicencia,licenciatrancito,fechavencimientotecnomecanica
FROM eneldatosvehiculo e INNER JOIN agentes a ON a.usuario=e.codagente WHERE e.codagente IN (SELECT codagente FROM enelpreopperacionalmotos 
where cons='".mysqli_real_escape_string($mysqli,$_GET["Codigo_Registroennel"])."' )  ";  


 



$datos=mysqli_query($mysqli,$consulta); 
 
while($row=mysqli_fetch_row($datos)){ 

             echo ' 

<html>
<head>
  <title>Plantilla Descargar</title>
  <meta charset="utf-8">
  <style>
    body{padding: 5px;} 
  </style>
</head>

<style>
.tabla ,th, td {
 
  border-style: solid;   
}

</style>
<body  onLoad="window.print()">

 
<table  class="tabla" cellspacing="0" cellpadding="2" border="1" align="center" style="width:100% !important">
            <tr style="text-align:center" >
                <td width="30%" rowspan="3">
                    <img src="../images/Lecta.jpg" width="200">
                </td>
                <td width="40%" rowspan="3"  >  INSPECCION PREOPERACIONAL MOTOCICLETAS
                </td>
                <td width="30%"  >
                CODIGO: PL-RG-54    
                </td>
            </tr> 
            <tr  style="text-align:center">
                <td valign="middle">FECHA: 06/10/2020  
                </td>
            </tr> 
            <tr  style="text-align:center">
                <td >
                 VERSION: 02 digital 
                </td>
            </tr> 
</table> 

<BR>
    
<table  class="tabla" cellspacing="0" cellpadding="2" border="1" align="center" style="text-align:center;font-size:12px;width:100% !important;border-style:none" >
            <tr>

                <td width="20%">
                NOMBRE DEL CONDUCTOR     
                 </td>
                <td> 
                 
                  '.$row[0].'
                 </td>

                <td>
              FECHA DILIGENCIAMIENTO  
                 </td>
                <td> 
                 
                  '.$row[1].'
                 </td>

            </tr> 
</table> 

    
<table  class="tabla" cellspacing="0" cellpadding="2" border="1" align="center" style="text-align:center;font-size:12px;width:100% !important;border-style:none" >
            <tr>

                <td width="20%">MARCA</td>
                <td> 
                  '.$row[2].'
                </td>

                <td>PLACA </td>
                <td>
                  '.$row[3].'
                </td>

                <td>MODELO</td>
                 
                <td> '.$row[4].'
                </td>


            </tr>  <tr>
                <td>FECHA VENCIMIENTO SOAT  </td>
                <td>'.$row[5].'
                </td>



                <td>LICENCIA DE CONDUCCIÓN</td>
                 <td>'.$row[6].'
                </td>

                <td>VIGENCIA</td>
                <td>'.$row[7].'
                </td>

            </tr>  <tr>
                <td>LICENCIA DE TRANSITO N°</td>
                <td>'.$row[8].'
                </td>

                <td colspan="3">FECHA DE VENCIMIENTO REVISION TEC. MECANICA </td>
                <td>'.$row[9].'
                </td> 


    


            </tr> 
</table> 
    ';

  }


         $consulta="SELECT e1,obs1, e2,obs2, e3,obs3, e4,obs4, e5,obs5, e6,obs6, e7,obs7, e8,obs8, e9,obs9, e10,obs10, e11,obs11, e12,obs12, e13,obs13, e14,obs14, e15,obs15, e16,obs16, e17,obs17, e18,obs18, e19,obs19, e20,obs20,e21,obs21, d1,obs22,d2,obs23,d3,obs24,d4,obs25,d5,obs26,d6,obs27,d7,obs28,s1,obs29,s2,obs30,s3,obs31,s4,obs32,s5,obs33,s6,n1,n2,n3,n4,n5,n6,apto,noapto,obs36,imagen
         from enelpreopperacionalmotos
         where  cons='".mysqli_real_escape_string($mysqli,$_GET["Codigo_Registroennel"])."'
     ";  


 



$datos=mysqli_query($mysqli,$consulta);	
 
while($row=mysqli_fetch_row($datos)){ 

$estado="NO APTO";
if($row[73]=="si"){
$estado="APTO";

}
$conimagen="";
if($row[76]!=""){ 
$conimagen='
            <tr>
                <td colspan="3" style="background-color:#ddd" >
                    <p align="center">
                        <strong>
                       REGISTRO FOTOGRAFICO
                        </strong>
                    </p>
                </td>
            </tr><tr><td colspan="3"  valign="bottom" nowrap=""><center>
                   <img src="https://storage.googleapis.com/lumensarchivostemporales/Soportes/'.$row[76].'" style="max-width:500px;max-height:500px">
                </td> </tr>';
}
             echo ' 
<BR>

    <table  class="tabla" cellspacing="0" cellpadding="2" border="1" align="left" style="font-size:12px;width:100% !important">
        <tbody>
            <tr>
                <td>
                    <p align="center">
                        <strong> </strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                    <p align="center">
                        <strong>RESPUESTA</strong>
                    </p>
                </td> 
                <td  nowrap="">
                    <p align="center">
                        <strong>OBSERVACIONES</strong>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="background-color:#ddd" >
                    <p align="center">  
                        <strong>ESTADO VEHÍCULO</strong>
                    </p>
                </td>
            </tr>
            <tr>
                <td valign="bottom">
                    <p>
                        <strong>Estado de las llantas.</strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[0].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[1].'
                </td>
            </tr>
            <tr>
                <td valign="bottom">
                    <p>
                        <strong>Estado de los rines</strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[2].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[3].'
                </td>
            </tr>
            <tr>
                <td valign="bottom">
                    <p>
                        <strong>Luz delantera</strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[4].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[5].'
                </td>
            </tr>
            <tr>
                <td valign="bottom">
                    <p>
                        <strong>Luz del stop</strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[6].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[7].'
                </td>
            </tr>
            <tr>
                <td valign="bottom">
                    <p>
                        <strong>Luces direccionales delantera y trasera</strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[8].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[9].'
                </td>
            </tr>
            <tr>
                <td valign="bottom">
                    <p>
                        <strong>Pito opera normalmente.</strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[10].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[11].'
                </td>
            </tr>
            <tr>
                <td valign="bottom">
                    <p>
                        <strong>Manubrios en buen estado.</strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[12].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[13].'
                </td>
            </tr>
            <tr>
                <td valign="bottom">
                    <p>
                        <strong>Verificar el estado del kit de arrastre</strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[14].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[15].'
                </td>
            </tr>
            <tr>
                <td valign="bottom">
                    <p>
                        <strong>Verificar aceite</strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[16].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[17].'
                </td>
            </tr>
            <tr>
                <td valign="bottom">
                    <p>
                        <strong>
                            Funcionamiento de frenos. (Delantero y trasero)
                        </strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[18].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[19].'
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <p>
                        <strong>
                            La carrera o movimiento de los pedales (palanca) de
                            accionamiento del sistema de freno son adecuados.
                        </strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[20].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[21].'
                </td>
            </tr>
            <tr>
                <td valign="bottom">
                    <p>
                        <strong>Estado de los espejos retrovisores</strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[22].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[23].'
                </td>
            </tr>
            <tr>
                <td valign="bottom">
                    <p>
                        <strong>
                            Cuenta con el mínimo nivel requerido de líquido para
                            frenos
                        </strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[24].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[25].'
                </td>
            </tr>
            <tr>
                <td valign="bottom">
                    <p>
                        <strong>
                            Hay retorno adecuado de pedal/palanca de freno trasero
                            y/o delantero
                        </strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[26].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[27].'
                </td>
            </tr>
            <tr>
                <td valign="bottom">
                    <p>
                        <strong>
                            Se encuentra la tapa del depósito de líquido de frenos
                        </strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[28].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[29].'
                </td>
            </tr>
            <tr>
                <td valign="bottom">
                    <p>
                        <strong>Estado de los escala pies (posapiés)</strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[30].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[31].'
                </td>
            </tr>
            <tr>
                <td valign="bottom">
                    <p>
                        <strong>Testigos del tablero</strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[32].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[33].'
                </td>
            </tr>
            <tr>
                <td valign="bottom">
                    <p>
                        <strong>Velocímetro funcionando correctamente</strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[34].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[35].'
                </td>
            </tr>
            <tr>
                <td valign="bottom">
                    <p>
                        <strong>Prueba en marcha (ruido, otros)</strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[36].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[37].'
                </td>
            </tr>
            <tr>
                <td valign="bottom">
                    <p>
                        <strong>Estado de amortiguador delantero</strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[38].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[39].'
                </td>
            </tr>
            <tr>
                <td valign="bottom">
                    <p>
                        <strong>Estado de amortiguador trasero</strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[40].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[41].'
                </td>
            </tr>
            <tr>
                <td colspan="3" style="background-color:#ddd" >
                    <p align="center">
                        <strong>DOCUMENTOS</strong>
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>
                        <strong>Carnet ARL</strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[42].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[43].'
                </td>
            </tr>
            <tr>
                <td>
                    <p>
                        <strong>Carnet Lecta</strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[44].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[45].'
                </td>
            </tr>
            <tr>
                <td>
                    <p>
                        <strong>Carnet Enel</strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[46].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[47].'
                </td>
            </tr>
            <tr>
                <td>
                    <p>
                        <strong>Cédula cuidadanía</strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[48].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[49].'
                </td>
            </tr>
            <tr>
                <td>
                    <p>
                        <strong>Licencia tránsito</strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[50].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[51].'
                </td>
            </tr>
            <tr>
                <td>
                    <p>
                        <strong>Licencia conducción</strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[52].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[53].'
                </td>
            </tr>
            <tr>
                <td>
                    <p>
                        <strong>SOAT</strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[54].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[55].'
                </td>
            </tr>
            <tr>
                <td colspan="3" style="background-color:#ddd" >
                    <p align="center">
                        <strong>
                        ESTADO DE LOS ELEMENTOS DE SEGURIDAD PERSONAL
                        </strong>
                    </p>
                </td>
            </tr>
            <tr>
                <td valign="bottom">
                    <p>
                        <strong>Casco incluir visor</strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[56].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[57].'
                </td>
            </tr>
            <tr>
                <td valign="bottom">
                    <p>
                        <strong>Guantes</strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[58].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[59].'
                </td>
            </tr>
            <tr>
                <td valign="bottom">
                    <p>
                        <strong>
                            Chaleco airbag (incluir botella de activación, correa
                            de activación, correa de sujeción al chasis, protector
                            de espalda).
                        </strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[60].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[61].'
                </td>
            </tr>
            <tr>
                <td valign="bottom">
                    <p>
                        <strong>Coderas y rodilleras</strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[62].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[63].'
                </td>
            </tr>
            <tr>
                <td valign="bottom">
                    <p>
                        <strong>Botas</strong>
                    </p>
                </td>
                <td valign="bottom" nowrap="">
                  '.$row[64].'
                </td> 
                <td  valign="bottom" nowrap="">
                  '.$row[65].'
                </td>
            </tr>
            <tr>
                <td valign="bottom">
                    <p>
                        <strong>Kilometraje inicial</strong>
                    </p>
                </td>
                <td valign="bottom" nowrap=""  colspan="2">
                  '.$row[66].'
                </td>  
            </tr> 
            <tr>
                <td colspan="3"  style="background-color:#ddd" >
                    <p align="center">
                        <strong>
                            Nota. En el caso de encontrar en mal estado debe anexar
                            registro fotografico y diligenciar información en el
                            cuadro siguiente
                        </strong>
                    </p>
                </td>
            </tr>
            <tr>
                <td valign="bottom" nowrap="">
                    <p>
                        <strong>Fecha</strong>
                    </p>
                </td>
                <td colspan="2"  valign="bottom" nowrap="">
                  '.$row[67].'
                </td>
            </tr>
            <tr>
                <td valign="bottom" nowrap="">
                    <p>
                        <strong>Hallazgo</strong>
                    </p>
                </td>
                <td colspan="2"  valign="bottom" nowrap="">
                  '.$row[68].'
                </td>
            </tr>
            <tr>
                <td valign="bottom" nowrap="">
                    <p>
                        <strong>Accion correctiva</strong>
                    </p>
                </td>
                <td colspan="2"  valign="bottom" nowrap="">
                  '.$row[69].'
                </td>
            </tr>
            <tr>
                <td valign="bottom" nowrap="">
                    <p>
                        <strong>Seguimiento</strong>
                    </p>
                </td>
                <td colspan="2"  valign="bottom" nowrap="">
                  '.$row[70].'
                </td>
            </tr>
            <tr>
                <td valign="bottom" nowrap="">
                    <p>
                        <strong>Conforme</strong>
                    </p>
                </td>
                <td colspan="2"  valign="bottom" nowrap="">
                  '.$row[71].'
                </td>
            </tr>
            <tr>
                <td valign="bottom" nowrap="">
                    <p>
                        <strong>No conforme</strong>
                    </p>
                </td>
                <td colspan="2"  valign="bottom" nowrap="">
                  '.$row[72].'
                </td>
            </tr>'.$conimagen.'
            <tr>
                <td valign="bottom" nowrap="">
                    <p>
                        <strong> </strong>
                    </p>
                </td>
                <td valign="bottom" nowrap=""  style="background-color:#ddd">
                    <p>
                        <strong>RESULTADO</strong>
                    </p>
                </td> 
                <td colspan="2"  valign="bottom" nowrap=""  style="background-color:#ddd">
                    <p align="center">
                        <strong>OBSERVACIONES</strong>
                    </p>
                </td>
            </tr>
            <tr>
                <td valign="bottom" nowrap="">
                    <p>
                        <strong>Resultado de la inspección</strong>
                    </p>
                </td> 
                <td valign="bottom" nowrap="">
                    <p>
                        <strong>
                  '.$estado.'</strong>
                    </p>
                </td>
                <td   valign="bottom" nowrap="">
                    <p align="center">
                        <strong>
                  '.$row[75].'</strong>
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
<BR>
<BR>

    '; 
			} 







?>


