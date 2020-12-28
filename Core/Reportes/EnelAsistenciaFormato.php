<?php

    require_once("../Procesamiento/Conexion.php");
	/*$filename = "Cepos-RelacionTotal.xls"; 
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
 */

       /*  $consulta="SELECT e1,obs1, e2,obs2, e3,obs3, e4,obs4, e5,obs5, e6,obs6, e7,obs7, e8,obs8, e9,obs9, e10,obs10, e11,obs11, e12,obs12, e13,obs13, e14,obs14, e15,obs15, e16,obs16, e17,obs17, e18,obs18, e19,obs19, e20,obs20,e21,obs21, d1,obs22,d2,obs23,d3,obs24,d4,obs25,d5,obs26,d6,obs27,d7,obs28,s1,obs29,s2,obs30,s3,obs31,s4,obs32,s5,obs33,s6,n1,n2,n3,n4,n5,n6,apto,noapto,obs36,imagen
         from enelpreopperacionalmotos
         where  cons='".mysqli_real_escape_string($mysqli,$_GET["Codigo_Registroennel"])."' ";    */
 


  $consulta="       SELECT 
                    
                    cedula,   
                    carnecodensa,
                    carnearp,  	
                    preoperacional, 
                    procedimiento, 
                    ropa, 
                    canguro, 
                    casco, 
                    bloqueador, 
                    guantes, 
                    imprermeables, 
                    gorra, 
                    botas, 
                    cartuchera, 
                    binoculares, 
                    linterna, 
                    planillero, 
                    detector, 
                    polainas, 
                    atomizador, 
                    celular, 
                    mapa, 
                    salud, 
                    bateria, 
                    teclado, 
                    encendido, 
                    impresion, 
                    certificaciones, 
                    constancias, 
                    hojas,  
                    observaciones,fecha FROM enelasistencia 
                    where  cons='".mysqli_real_escape_string($mysqli,$_GET["Codigo_Registroennel"])."' ";  


 
 

//echo $consulta;

$datos=mysqli_query($mysqli,$consulta);	
 
while($row=mysqli_fetch_row($datos)){ 
/*
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
}*/
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

<BR>

    <table  class="tabla" cellspacing="0" cellpadding="2" border="1" align="left" style="font-size:12px;width:100% !important">
        <tbody>
            <tr>
                <td>
                    <p align="left">
                        <strong>ITEM</strong>
                    </p>
                </td>
                <td colspan="6" valign="bottom" nowrap="">
                    <p align="center">
                        <strong>RESPUESTAS</strong>
                    </p>
                </td> 
              
            </tr>
            

            <!--

            <tr> 
                <td colspan="1" style="/*background-color:#ddd*/" >
                    <p align="center">  
                        <strong></strong> 
                    </p>
                </td>  

                <td valign="bottom" nowrap="">
                BUENO
                </td> 

                <td valign="bottom" nowrap="">
                REGULAR
                </td> 

                <td valign="bottom" nowrap="">
                MALO
                </td> 

                <td valign="bottom" nowrap="">
                NO TIENE
                </td> 
                
                <td valign="bottom" nowrap="">
                NO APLICA
                </td> 

                <td valign="bottom" nowrap="">
                MANTENIMIENTO
                </td> 

            </tr>

            -->


            <tr>
                <td valign="bottom">
                    <p>
                        <strong>FECHA</strong>
                    </p>
                </td>

                <td colspan="2" valign="bottom" nowrap="">
                   '.$row[31].'
                </td> 
                
               

            </tr>


            <tr>
                <td valign="bottom">
                    <p>
                        <strong>CÉDULA</strong>
                    </p>
                </td>

                <td colspan="2" valign="bottom" nowrap="">
                   '.$row[0].'
                </td> 
                
               

            </tr>

            <tr>
                <td valign="bottom">
                    <p>
                        <strong>CARNET CODENSA Y CIA</strong>
                    </p>
                </td>

                <td valign="bottom" nowrap="">
                '.$row[1].'
                </td> 
               
            </tr>

            <tr>
                <td valign="bottom">
                    <p>
                        <strong>CARNET ARP</strong>
                    </p>
                </td>

                <td valign="bottom" nowrap="">
                '.$row[2].'
                </td> 
                

            </tr>
            <tr>
                <td valign="bottom">
                    <p>
                        <strong>PREOPERACIONAL DEL VEHÍCULO</strong>
                    </p>
                </td>

                <td valign="bottom" nowrap="">
                '.$row[3].'
                </td> 
                

                
            </tr>
            <tr>
                <td valign="bottom">
                    <p>
                        <strong>PROCEDIMIENTO DE TRABAJO</strong>
                    </p>
                </td>

                <td valign="bottom" nowrap="">
                '.$row[4].'
                </td> 

                

               
            </tr>
            <tr>
                <td valign="bottom">
                    <p>
                        <strong>ROPA DE TRABAJO</strong>
                    </p>
                </td>

                <td valign="bottom" nowrap="">
                '.$row[5].'
                </td> 

                
            </tr>


            <tr>
                <td valign="bottom">
                    <p>
                        <strong>CANGURO O MALETA</strong>
                    </p>
                </td>

                <td valign="bottom" nowrap="">
                '.$row[6].'
                </td> 

                

            </tr>

            <tr>
                <td valign="bottom">
                    <p>
                        <strong>CASCO, GUANTES, VISOR</strong>
                    </p>
                </td>

                <td valign="bottom" nowrap="">
                '.$row[7].'
                </td> 


            </tr>

            <tr>
                <td valign="bottom">
                    <p>
                        <strong>BLOQUEADOR SOLAR</strong>
                    </p>
                </td>
                
                <td valign="bottom" nowrap="">
                '.$row[8].'
                </td> 

            </tr>

            <tr>
                <td valign="bottom">
                    <p>
                        <strong>
                            GUANTES DE VAQUETA
                        </strong>
                    </p>
                </td>
                
                <td valign="bottom" nowrap="">
                '.$row[9].'
                </td> 

            </tr>

            <tr>
                <td valign="top">
                    <p>
                        <strong>
                           IMPERMEABLE
                        </strong>
                    </p>
                </td>

                <td valign="bottom" nowrap="">
                '.$row[10].'
                </td> 


            </tr>

            <tr>
                <td valign="bottom">
                    <p>
                        <strong>GORRA O CACHUCHA</strong>
                    </p>
                </td>

                <td valign="bottom" nowrap="">
                '.$row[11].'
                </td> 


            </tr>

            <tr>
                <td valign="bottom">
                    <p>
                        <strong>
                        BOTAS DIELÉCTRICAS
                        </strong>
                    </p>
                </td>

                <td valign="bottom" nowrap="">
                '.$row[12].'
                </td> 

            </tr>

            <tr>
                <td valign="bottom">
                    <p>
                        <strong>
                           CARTUCHERA TPL E IMPRESORA
                        </strong>
                    </p>
                </td>

                <td valign="bottom" nowrap="">
                '.$row[13].'
                </td> 

            </tr>

            <tr>
                <td valign="bottom">
                    <p>
                        <strong>
                            BINOCULARES 
                        </strong>
                    </p>
                </td>

                <td valign="bottom" nowrap="">
                '.$row[14].'
                </td> 


            </tr>

            <tr>
                <td valign="bottom">
                    <p>
                        <strong>LINTERNA</strong>
                    </p>
                </td>

                <td valign="bottom" nowrap="">
                '.$row[15].'
                </td> 


            </tr>


            <tr>
                <td valign="bottom">
                    <p>
                        <strong>PLANILLERO</strong>
                    </p>
                </td>
                
                <td valign="bottom" nowrap="">
                '.$row[16].'
                </td> 


            </tr>

            <tr>
                <td valign="bottom">
                    <p>
                        <strong>DETECTOR DE TENSIÓN</strong>
                    </p>
                </td>

               <td valign="bottom" nowrap="">
               '.$row[17].'
                </td> 


            </tr>

            <tr>
                <td valign="bottom">
                    <p>
                        <strong>POLAINAS</strong>
                    </p>
                </td>
            
                <td valign="bottom" nowrap="">
                '.$row[18].'
                </td> 



            </tr>

            <tr>
                <td valign="bottom">
                    <p>
                        <strong>ATOMIZADOR</strong>
                    </p>
                </td>

                <td valign="bottom" nowrap="">
                '.$row[19].'
                </td> 


            </tr>

            <tr>
                <td valign="bottom">
                    <p>
                        <strong>EQUIPO DE COMUNICACIÓN CELULAR</strong>
                    </p>
                </td>
                
                <td valign="bottom" nowrap="">
                '.$row[20].'
                </td> 


            </tr>

            <tr>

            <td valign="bottom">
                <p>
                    <strong>MAPA DE RUTA</strong>
                </p>
            </td>

            <td valign="bottom" nowrap="">
            '.$row[21].'
                </td> 


        </tr>

        <tr>

        <td valign="bottom">
            <p>
                <strong>EL TRABAJADOR MANIFIESTA ENCONTRARSE EN ESTADO DE SALUD OPTIMO PARA DESARROLLAR LA LABOR (SI O NO)</strong>
            </p>
        </td> 

        <td valign="bottom" nowrap="">
        '.$row[22].'
        </td> 


    </tr>



            <tr>
                <td colspan="2" style="background-color:#ddd" >
                    <p align="center">
                        <strong>ESTADO TERMINAL, IMPRESORA Y/O DOCUMENTOS DE CALIDAD RECIBIDOS</strong>
                    </p>
                </td>
            </tr>

            <tr>
                <td>
                    <p>
                        <strong>BATERIA PDA E IMPRESORA AL 100%</strong>
                    </p>
                </td>

                <td valign="bottom" nowrap="">
                '.$row[23].' 
                </td> 


            </tr>

            <tr>
                <td>
                    <p>
                        <strong>TECLADO, PANTALLA, CARCAZA</strong>
                    </p>
                </td>

                <td valign="bottom" nowrap="">
                '.$row[24].'
                </td> 


            </tr>

            <tr>
                <td>
                    <p>
                        <strong>ENCENDIDO</strong>
                    </p>
                </td>

                <td valign="bottom" nowrap=""> 
                '.$row[25].'
                </td> 


            </tr>

            <tr>
                <td>
                    <p>
                        <strong>IMPRESIÓN HOJA DE PRUEBA</strong>
                    </p>
                </td>

                <td valign="bottom" nowrap="">
                '.$row[26].'
                </td> 


            </tr>

            <tr>
                <td>
                    <p>
                        <strong>CERTIFICACIONES DE LECTURA</strong>
                    </p>
                </td>

                <td valign="bottom" nowrap="">
                '.$row[27].'
                </td> 

            </tr>

            <tr>
                <td>
                    <p>
                        <strong>CONSTANCIAS DE NO LECTURA</strong>
                    </p>
                </td>


                <td valign="bottom" nowrap="">
                '.$row[28].'
                  
                </td> 


            </tr>


            <tr>

                <td>
                    <p>
                        <strong>HOJAS DE CERTIFICAR</strong>
                    </p>
                </td>
                

                <td valign="bottom" nowrap="">
                '.$row[29].'
                </td> 


            </tr>
 

            <tr>
                <td  style="background-color:" >
                    <p>
                        <strong>
                       OBSERVACIONES
                        </strong>
                    </p>
                </td>

                <td valign="bottom" nowrap="">
                '.$row[30].'
                </td> 


            </tr>


        </tbody>
    </table>
<BR>
<BR>

<body>

</html>

    '; 
			} 







?>


