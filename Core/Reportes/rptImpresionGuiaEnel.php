<?php  
	require_once('../Procesamiento/Conexion.php');
	
  //*************************************************IMPRESORA 4020 ****************************
  if(isset($_GET["CodActividad"]))  {  
  
    $cons=$_GET["CodActividad"];
  
   $i=1;
  
  
   /***********************************************/
        
        // Include the main TCPDF library (search for installation path).
        require_once('tcpdf/examples/tcpdf_include.php');
        require_once('tcpdf/tcpdf.php');

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        /*// set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('TCPDF Example 048');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        
        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 048', PDF_HEADER_STRING);*/
        
        
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        
        // set default monospaced font 
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        
        // set margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        //$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        
        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
          require_once(dirname(__FILE__).'/lang/eng.php');
          $pdf->setLanguageArray($l);
        }
        
        
        // ---------------------------------------------------------
        
        
        // add a page
        $pdf->AddPage();
        
              /**********************************************/

 	$tbl="";
 	$Y1="";
 	$Y="";
 	$parte ="";


//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    $consulta="SELECT  a.nombre,p.producto,p.orden,p.guia,p.cuenta,p.idventa,
    p.direccion,p.cuadratula ,p.ciclo,p.suscriptor,
    p.grupo,p.sucursal,DATE_FORMAT( p.fecha_llegada_fisico,'%d/%m/%Y')  ,
    DATE_FORMAT( p.fecha_max_entrega,'%d/%m/%Y')  ,p.documento,p.especial1,p.lote,p.ciudad FROM 
    ((proyectoespecialenel p INNER JOIN actividad ac ON ac.cons=p.codactividad) LEFT JOIN agentes a ON a.usuario=p.codagente)
    WHERE  ac.cons=".mysqli_real_escape_string($mysqli,$cons)."  ORDER BY ac.cons   ";
    $datos=mysqli_query($mysqli,$consulta); 
    $row_CantidadRegistro=mysqli_num_rows($datos);

    if($row_CantidadRegistro!=0){ 

        if($row_CantidadRegistro>=9){  
        	$CantidadHoja=ceil($row_CantidadRegistro/8);
        }else{
        	$CantidadHoja=1;
        }   

        $parte1=array();
        $parte2=array();   
        $parte3=array();
        $parte4=array();
        $parte5=array();
        $parte6=array();
        $parte7=array();
        $parte8=array();
        $cons=1;
        $pos=1;
        $cot=0; 

	   //WHILE ****  
	   
    while($row=mysqli_fetch_array($datos)){   
       
		  

        $Datos=array(
        'agente'=>$row[0],
        'producto'=>$row[1],
        'orden'=>$row[2],
        'consecutivo'=>$row[3], 
        'cuenta'=>$row[4], 
        'idventa'=>$row[5],
        'direccion'=>$row[6],
        'cuadralatura'=>$row[7], 
        'ciclo'=>$row[8], 
        'suscriptor'=>$row[9],   
        'grupo'=>$row[10],
        'sucursal'=>$row[11], 
        'fechallegada'=>$row[12],
        'fechaentrega'=>$row[13],
        'cedula'=>$row[14],
        'especial'=>$row[15],
        'lote'=>$row[16]  ,
        'ciudad'=>$row[17]  
        );


        if($pos==1){
             $cot++;  
            if($cot<=$CantidadHoja){
             array_push($parte1, $Datos);  

                if($cot==$CantidadHoja){
                    $cot=0;
                     $pos++; 
                }
            }
        }else if($pos==2){
             $cot++;
            if($cot<=$CantidadHoja){
                array_push($parte2, $Datos);  

                if($cot==$CantidadHoja){
                    $cot=0;
                     $pos++; 
                }
            }
        }else if($pos==3){
             $cot++;
            if($cot<=$CantidadHoja){
                array_push($parte3, $Datos);  

                if($cot==$CantidadHoja){
                    $cot=0;
                     $pos++; 
                }
            }
        }else if($pos==4){
             $cot++;
            if($cot<=$CantidadHoja){
               array_push($parte4, $Datos);  

                if($cot==$CantidadHoja){
                    $cot=0;
                     $pos++; 
                }   
            } 
		}

		else if($pos==5){
			$cot++;
		   if($cot<=$CantidadHoja){
			  array_push($parte5, $Datos);  

			   if($cot==$CantidadHoja){
				   $cot=0;
					$pos++; 
			   }   
		   }
	   }

     else if($pos==6){
    $cot++;
     if($cot<=$CantidadHoja){
      array_push($parte6, $Datos);  

       if($cot==$CantidadHoja){
         $cot=0;
        $pos++; 
       }   
     }
   }

     else if($pos==7){
    $cot++;
     if($cot<=$CantidadHoja){
      array_push($parte7, $Datos);  

       if($cot==$CantidadHoja){
         $cot=0;
        $pos++; 
       }   
     }
   }

     else if($pos==8){
    $cot++;
     if($cot<=$CantidadHoja){
      array_push($parte8, $Datos);  

       if($cot==$CantidadHoja){
         $cot=0;
        $pos++; 
       }   
     }
   }
		
		

        $cons++;
  
    }//END WHILE
	//echo $Datos;*/

	$tbl .='

	<html xmlns="http://www.w3.org/1999/xhtml">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	
	
	<head>

	</head>

	<style>

				@font-face{
						font-family: LetraBarras; 
						src: url(./LetraBarras.TTF);            
				} 


.codbarra{
	
				
					font-size: 33px;
					font-family: LetraBarras;
					font-weight: 50;
					margin: 0;
					padding: 0;
				}

	</style>

				

	<body   onLoad="window.print()" >'; 
	// -----------------------------------------------------------------------------
	
	// NON-BREAKING ROWS (nobr="true")
	

		

	//++++++++++ TABLA

$cons1=0;
$cons2=0;
$cons3=0;
$cons4=0;
$cons5=0;
$cons6=0;
$cons7=0;
$cons8=0;
	

    for($b=0;$b<$row_CantidadRegistro;$b++){
 
   		if(($i%8)==1){ 
    
				$agente=$parte1[$cons1]['agente'];
				$producto=$parte1[$cons1]['producto'];
				$orden=$parte1[$cons1]['orden'];
				$consecutivo=$parte1[$cons1]['consecutivo']; 
				$cuenta= $parte1[$cons1]['cuenta'];
				$idventa=$parte1[$cons1]['idventa'];
				$direccion=$parte1[$cons1]['direccion'];
				$cuadratula=$parte1[$cons1]['cuadralatura'];
				$ciclo=$parte1[$cons1]['ciclo'];
				$suscriptor=$parte1[$cons1]['suscriptor'];
				$grupo=$parte1[$cons1]['grupo'];
				$sucursal=$parte1[$cons1]['sucursal'];
				$f_llegada=$parte1[$cons1]['fechallegada'];
				$f_entrega=$parte1[$cons1]['fechaentrega'];
				$cedula=$parte1[$cons1]['cedula'];
				$especial1=$parte1[$cons1]['especial'];
				$lote= $parte1[$cons1]['lote'];     
				$ciudad= $parte1[$cons1]['ciudad'];      
      
   

  
      $tbl.='<div style="page-break-after: always; width:100%; height:auto; "> 
      <table cellpadding="2" cellspacing="2" align="center" style="width:98%;margin:auto;">
     <tr >  


       <td style="width:50% !important"> 



        <table    align="center" style="margin:auto;">
          <tr >      
            <td style="width:100% !important" colspan="2"> 
                  <div class="codbarra"  style="text-align:center;width:100%;margin-bottom:5px;margin-top:5px;" >*'.$consecutivo.'*</div>
                       

            </td>
          </tr>  




        <tr >     
           <td   valign="top" style="width:75% !important">  
 
          <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">
                    <table   cellpadding="4" cellspacing="2" align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td>
                             <B>ORDEN:</B> '.$orden.'
                      </td>
                      <td>
                             <B>FEC. LLEGADA:</B> '.$f_llegada.'
                      </td>
                      <td>
                          <B>FEC. MAX ENT:</B> '.$f_entrega.'
                      </td>
                    </tr>  
                    </table>  

          </div>  


          <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">
          <div style="text-align:center"><B>DATOS DE CONTACTO</B></div>


                    <table   cellpadding="1"  align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >

                    
                    <tr >      
                      <td style="width:80% !important">
                          <B>PROD:</B> '.$producto.'
                      </td> 
                      <td  rowspan="2">
                           <div   style=" border:solid 1px #000;border-collapse: collapse;text-align:center "> 
                            <B>ID VENTA:</B> <br>
                            '.$idventa.'
                          </div>

                      </td> 
                    </tr>  
                    <tr >      
                      <td style="width:80% !important">
                          <B>SUSC:</B> '.$suscriptor.'
                      </td>  
                    </tr> 
                    
                    <tr >      
                      <td style="width:80% !important">
                          <B>DIR:</B> '.$direccion.'
                      </td> 
                      <td  rowspan="2">
                           <div   style=" border:solid 1px #000;border-collapse: collapse;text-align:center "> 
                            <B>CUENTA:</B> <br>
                            '.$cuenta.'
                          </div>

                      </td> 
                    </tr>  
                    <tr >      
                      <td style="width:80% !important">
                          <B>CIUD:</B> '.$ciudad.'
                      </td>  
                    </tr> 
                    <tr >      
                      <td colspan="2"> 
                      <table   cellpadding="0" cellspacing="0"  align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td><B>CONSE:</B> '.$consecutivo.'
                      </td>
                      <td>
                             <B>RUTA:</B> '.$sucursal.''.$cuadratula.''.$ciclo.''.$grupo.'
                      </td> 
                    </tr>  
                    </table>  
                      </td>  
                    </tr> 



                    </table>  

             



          </div>  
  <div style="text-align:center;font-size:8px;"><B>RESULTADO DE VISITA</B></div>

   <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">
                    <table   cellpadding="2" cellspacing="2" align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td>
                            EFECTIVO  
                                 <span class="" style="padding: 2px 10px; border:solid 1px #000;margin-left:5px"> </span>
                      </td>
                      <td>
                            NO EFECTIVO         
                                 <span class="" style="padding: 2px 10px; border:solid 1px #000;margin-left:5px"> </span>              </td>
                      <td style="width:40%">
                         INTENTO 

                         <span class="" style="padding: 4px 7.8px; border:solid 1px #000;font-size:5PX">1</span>
                         <span class="" style="padding: 4px 7.8px; border:solid 1px #000;font-size:5PX">2</span>
                         <span class="" style="padding: 4px 7.8px; border:solid 1px #000;font-size:5PX">3</span>
                      </td>
                    </tr>  
                    </table>  

          </div>    


   <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">

   <table   style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td valign="top">
   <div    style=";font-size:6px; " >FIRMA O SELLO DE RECIBO</div> 
   <br><br><br><br>
   <div    style=" color:#CCC; " >Agente:</div> 


          </div>       
                      </td>   
                      <td align="right" style="color:#CCC;">
                      Medidor <br><br>
                      Lectura <br><br>
                      Telefono <br><br>
                      </td>

                    </tr >   
      </table>  




       </td> 
       <td valign="top">


        <table cellpadding="3" style="font-size:8px;text-align:center;margin:auto">
                <tbody>
                <tr>  
     
                      <td colspan="2" class="">
                      <div style="font-size:10px;text-align:center"><b>ANOMALIA</b>
                      </div></td>
     
                   </tr>
                                           
                   
     
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">0</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">1</span>
                         </td>  
                   </tr>  
     
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">2</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">3</span>
                         </td>  
                   </tr>  
      
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">4</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">5</span>
                         </td>  
                   </tr>  
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">6</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">7</span>
                         </td>  
                   </tr>  
      
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">8</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">9</span>
                         </td>  
                   </tr>  
      
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000">10</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000">11</span>
                         </td>  
                   </tr>  
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000; ">12</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000">13</span>
                         </td>  
                   </tr>  
      
      
      
     
                    <tr> 
                       <td class="td-left" colspan="2">
                         <div style="padding: 2px 6px; border:solid 1px #000;text-align:center ">
                            FECHA GESTION <BR>
                             <P   style="color:#CCC;">
                             DD - MM - AAAA
                             </P>


                         </div>
                         </td>   
                   </tr>  
      
      

     
              </tbody></table>



            </td> </tr> 
             </tbody></table>
       
       </td> ';








	
		
		$Y1 = $Y1+390;//1
         	$cons1++;
			
        }else if(($i%8)==2){  
		
          $agente=$parte2[$cons2]['agente'];
          $producto=$parte2[$cons2]['producto'];
            $orden=$parte2[$cons2]['orden'];
          $consecutivo=$parte2[$cons2]['consecutivo']; 
          $cuenta= $parte2[$cons2]['cuenta'];
          $idventa=$parte2[$cons2]['idventa'];
          $direccion=$parte2[$cons2]['direccion'];
          $cuadratula=$parte2[$cons2]['cuadralatura'];
          $ciclo=$parte2[$cons2]['ciclo'];
          $suscriptor=$parte2[$cons2]['suscriptor'];
          $grupo=$parte2[$cons2]['grupo'];
          $sucursal=$parte2[$cons2]['sucursal'];
          $f_llegada=$parte2[$cons2]['fechallegada'];
          $f_entrega=$parte2[$cons2]['fechaentrega'];
          $cedula=$parte2[$cons2]['cedula'];
          $especial1=$parte2[$cons2]['especial'];
          $lote= $parte2[$cons2]['lote'];
    
          
  
      $tbl.='     


       <td style="width:50% !important"> 



        <table    align="center" style="margin:auto;">
          <tr >      
            <td style="width:100% !important" colspan="2"> 
                  <div class="codbarra"  style="text-align:center;width:100%;margin-bottom:5px;margin-top:5px;" >*'.$consecutivo.'*</div>
                       

            </td>
          </tr>  




        <tr >     
           <td   valign="top" style="width:75% !important">  
 
          <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">
                    <table   cellpadding="4" cellspacing="2" align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td>
                             <B>ORDEN:</B> '.$orden.'
                      </td>
                      <td>
                             <B>FEC. LLEGADA:</B> '.$f_llegada.'
                      </td>
                      <td>
                          <B>FEC. MAX ENT:</B> '.$f_entrega.'
                      </td>
                    </tr>  
                    </table>  

          </div>  


          <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">
          <div style="text-align:center"><B>DATOS DE CONTACTO</B></div>


                    <table   cellpadding="1"  align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >

                    
                    <tr >      
                      <td style="width:80% !important">
                          <B>PROD:</B> '.$producto.'
                      </td> 
                      <td  rowspan="2">
                           <div   style=" border:solid 1px #000;border-collapse: collapse;text-align:center "> 
                            <B>ID VENTA:</B> <br>
                            '.$idventa.'
                          </div>

                      </td> 
                    </tr>  
                    <tr >      
                      <td style="width:80% !important">
                          <B>SUSC:</B> '.$suscriptor.'
                      </td>  
                    </tr> 
                    
                    <tr >      
                      <td style="width:80% !important">
                          <B>DIR:</B> '.$direccion.'
                      </td> 
                      <td  rowspan="2">
                           <div   style=" border:solid 1px #000;border-collapse: collapse;text-align:center "> 
                            <B>CUENTA:</B> <br>
                            '.$cuenta.'
                          </div>

                      </td> 
                    </tr>  
                    <tr >      
                      <td style="width:80% !important">
                          <B>CIUD:</B> '.$ciudad.'
                      </td>  
                    </tr> 
                    <tr >      
                      <td colspan="2"> 
                      <table   cellpadding="0" cellspacing="0"  align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td><B>CONSE:</B> '.$consecutivo.'
                      </td>
                      <td>
                             <B>RUTA:</B> '.$sucursal.''.$cuadratula.''.$ciclo.''.$grupo.'
                      </td> 
                    </tr>  
                    </table>  
                      </td>  
                    </tr> 



                    </table>  

             



          </div>  
  <div style="text-align:center;font-size:8px;"><B>RESULTADO DE VISITA</B></div>

   <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">
                    <table   cellpadding="2" cellspacing="2" align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td>
                            EFECTIVO  
                                 <span class="" style="padding: 2px 10px; border:solid 1px #000;margin-left:5px"> </span>
                      </td>
                      <td>
                            NO EFECTIVO         
                                 <span class="" style="padding: 2px 10px; border:solid 1px #000;margin-left:5px"> </span>              </td>
                      <td style="width:40%">
                          
                         INTENTO 

                         <span class="" style="padding: 4px 7.8px; border:solid 1px #000;font-size:5PX">1</span>
                         <span class="" style="padding: 4px 7.8px; border:solid 1px #000;font-size:5PX">2</span>
                         <span class="" style="padding: 4px 7.8px; border:solid 1px #000;font-size:5PX">3</span>
                      </td>
                    </tr>  
                    </table>  

          </div>    


   <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">

   <table   style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td valign="top">
   <div    style=";font-size:6px; " >FIRMA O SELLO DE RECIBO</div> 
   <br><br><br><br>
   <div    style=" color:#CCC; " >Agente:</div> 

          </div>       
                      </td>   
                      <td align="right" style="color:#CCC;">
                      Medidor <br><br>
                      Lectura <br><br>
                      Telefono <br><br>
                      </td>

                    </tr >   
      </table>  




       </td> 
       <td valign="top">


        <table cellpadding="3" style="font-size:8px;text-align:center;margin:auto">
                <tbody>
                <tr>  
     
                      <td colspan="2" class="">
                      <div style="font-size:10px;text-align:center"><b>ANOMALIA</b>
                      </div></td>
     
                   </tr>
                                           
                   
     
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">0</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">1</span>
                         </td>  
                   </tr>  
     
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">2</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">3</span>
                         </td>  
                   </tr>  
      
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">4</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">5</span>
                         </td>  
                   </tr>  
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">6</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">7</span>
                         </td>  
                   </tr>  
      
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">8</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">9</span>
                         </td>  
                   </tr>  
      
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000">10</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000">11</span>
                         </td>  
                   </tr>  
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000; ">12</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000">13</span>
                         </td>  
                   </tr>  
      
      
      
     
                    <tr> 
                       <td class="td-left" colspan="2">
                         <div style="padding: 2px 6px; border:solid 1px #000;text-align:center ">
                            FECHA GESTION <BR>
                             <P   style="color:#CCC;">
                             DD - MM - AAAA
                             </P>


                         </div>
                         </td>   
                   </tr>  
      
      

     
              </tbody></table>



            </td> </tr> 
             </tbody></table>
       
       </td> ';
      



         $tbl.='</tr>';
          
        $Y1 = $Y1+350;//2
    $cons2++;
          
        }
       // $tbl.='<tr nobr="true"> ';
        
   else if(($i%8)==3){ 
          
           if(count($parte3)!=$cons3){
    
          $agente=$parte3[$cons3]['agente'];
          $producto=$parte3[$cons3]['producto'];
          $orden=$parte3[$cons3]['orden'];
          $consecutivo=$parte3[$cons3]['consecutivo']; 
          $cuenta= $parte3[$cons3]['cuenta'];
          $idventa=$parte3[$cons3]['idventa'];
          $direccion=$parte3[$cons3]['direccion'];
          $cuadratula=$parte3[$cons3]['cuadralatura'];
          $ciclo=$parte3[$cons3]['ciclo'];
          $suscriptor=$parte3[$cons3]['suscriptor'];
          $grupo=$parte3[$cons3]['grupo'];
          $sucursal=$parte3[$cons3]['sucursal'];
          $f_llegada=$parte3[$cons3]['fechallegada'];
          $f_entrega=$parte3[$cons3]['fechaentrega'];
          $cedula=$parte3[$cons3]['cedula'];
          $especial1=$parte3[$cons3]['especial'];
          $lote= $parte3[$cons3]['lote'];
    
          
  $tbl.='
     <tr >  

       <td style="width:50% !important"> 



        <table    align="center" style="margin:auto;">
          <tr >      
            <td style="width:100% !important" colspan="2"> 
                  <div class="codbarra"  style="text-align:center;width:100%;margin-bottom:5px;margin-top:5px;" >*'.$consecutivo.'*</div>
                       

            </td>
          </tr>  




        <tr >     
           <td   valign="top" style="width:75% !important">  
 
          <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">
                    <table   cellpadding="4" cellspacing="2" align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td>
                             <B>ORDEN:</B> '.$orden.'
                      </td>
                      <td>
                             <B>FEC. LLEGADA:</B> '.$f_llegada.'
                      </td>
                      <td>
                          <B>FEC. MAX ENT:</B> '.$f_entrega.'
                      </td>
                    </tr>  
                    </table>  

          </div>  


          <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">
          <div style="text-align:center"><B>DATOS DE CONTACTO</B></div>


                    <table   cellpadding="1"  align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >

                    
                    <tr >      
                      <td style="width:80% !important">
                          <B>PROD:</B> '.$producto.'
                      </td> 
                      <td  rowspan="2">
                           <div   style=" border:solid 1px #000;border-collapse: collapse;text-align:center "> 
                            <B>ID VENTA:</B> <br>
                            '.$idventa.'
                          </div>

                      </td> 
                    </tr>  
                    <tr >      
                      <td style="width:80% !important">
                          <B>SUSC:</B> '.$suscriptor.'
                      </td>  
                    </tr> 
                    
                    <tr >      
                      <td style="width:80% !important">
                          <B>DIR:</B> '.$direccion.'
                      </td> 
                      <td  rowspan="2">
                           <div   style=" border:solid 1px #000;border-collapse: collapse;text-align:center "> 
                            <B>CUENTA:</B> <br>
                            '.$cuenta.'
                          </div>

                      </td> 
                    </tr>  
                    <tr >      
                      <td style="width:80% !important">
                          <B>CIUD:</B> '.$ciudad.'
                      </td>  
                    </tr> 
                    <tr >      
                      <td colspan="2"> 
                      <table   cellpadding="0" cellspacing="0"  align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td><B>CONSE:</B> '.$consecutivo.'
                      </td>
                      <td>
                             <B>RUTA:</B> '.$sucursal.''.$cuadratula.''.$ciclo.''.$grupo.'
                      </td> 
                    </tr>  
                    </table>  
                      </td>  
                    </tr> 



                    </table>  

             



          </div>  
  <div style="text-align:center;font-size:8px;"><B>RESULTADO DE VISITA</B></div>

   <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">
                    <table   cellpadding="2" cellspacing="2" align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td>
                            EFECTIVO  
                                 <span class="" style="padding: 2px 10px; border:solid 1px #000;margin-left:5px"> </span>
                      </td>
                      <td>
                            NO EFECTIVO         
                                 <span class="" style="padding: 2px 10px; border:solid 1px #000;margin-left:5px"> </span>              </td>
                      <td style="width:40%">
                          
                         INTENTO 

                         <span class="" style="padding: 4px 7.8px; border:solid 1px #000;font-size:5PX">1</span>
                         <span class="" style="padding: 4px 7.8px; border:solid 1px #000;font-size:5PX">2</span>
                         <span class="" style="padding: 4px 7.8px; border:solid 1px #000;font-size:5PX">3</span>
                      </td>
                    </tr>  
                    </table>  

          </div>    


   <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">

   <table   style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td valign="top">
   <div    style=";font-size:6px; " >FIRMA O SELLO DE RECIBO</div> 
   <br><br><br><br>
   <div    style=" color:#CCC; " >Agente:</div> 

          </div>       
                      </td>   
                      <td align="right" style="color:#CCC;">
                      Medidor <br><br>
                      Lectura <br><br>
                      Telefono <br><br>
                      </td>

                    </tr >   
      </table>  




       </td> 
       <td valign="top">


        <table cellpadding="3" style="font-size:8px;text-align:center;margin:auto">
                <tbody>
                <tr>  
     
                      <td colspan="2" class="">
                      <div style="font-size:10px;text-align:center"><b>ANOMALIA</b>
                      </div></td>
     
                   </tr>
                                           
                   
     
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">0</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">1</span>
                         </td>  
                   </tr>  
     
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">2</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">3</span>
                         </td>  
                   </tr>  
      
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">4</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">5</span>
                         </td>  
                   </tr>  
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">6</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">7</span>
                         </td>  
                   </tr>  
      
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">8</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">9</span>
                         </td>  
                   </tr>  
      
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000">10</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000">11</span>
                         </td>  
                   </tr>  
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000; ">12</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000">13</span>
                         </td>  
                   </tr>  
      
      
      
     
                    <tr> 
                       <td class="td-left" colspan="2">
                         <div style="padding: 2px 6px; border:solid 1px #000;text-align:center ">
                            FECHA GESTION <BR>
                             <P   style="color:#CCC;">
                             DD - MM - AAAA
                             </P>


                         </div>
                         </td>   
                   </tr>  
      
      

     
              </tbody></table>



            </td> </tr> 
             </tbody></table>
       
       </td> ';
           $cons3++;
           
          }
          else{
            $b--;
          }
          $Y1 = $Y1+350;//3
          
        }
        
        //************************************************************************************************* */
        else if(($i%8)==4){ 
          
          if(count($parte4)!=$cons4){
  
         $agente=$parte4[$cons4]['agente'];
         $producto=$parte4[$cons4]['producto'];
           $orden=$parte4[$cons4]['orden'];
         $consecutivo=$parte4[$cons4]['consecutivo']; 
         $cuenta= $parte4[$cons4]['cuenta'];
         $idventa=$parte4[$cons4]['idventa'];
         $direccion=$parte4[$cons4]['direccion'];
         $cuadratula=$parte4[$cons4]['cuadralatura'];
         $ciclo=$parte4[$cons4]['ciclo'];
         $suscriptor=$parte4[$cons4]['suscriptor'];
         $grupo=$parte4[$cons4]['grupo'];
         $sucursal=$parte4[$cons4]['sucursal'];
         $f_llegada=$parte4[$cons4]['fechallegada'];
         $f_entrega=$parte4[$cons4]['fechaentrega'];
         $cedula=$parte4[$cons4]['cedula'];
         $especial1=$parte4[$cons4]['especial'];
         $lote= $parte4[$cons4]['lote'];
   
         
       
     

  $tbl.='

       <td style="width:50% !important"> 



        <table    align="center" style="margin:auto;">
          <tr >      
            <td style="width:100% !important" colspan="2"> 
                  <div class="codbarra"  style="text-align:center;width:100%;margin-bottom:5px;margin-top:5px;" >*'.$consecutivo.'*</div>
                       

            </td>
          </tr>  




        <tr >     
           <td   valign="top" style="width:75% !important">  
 
          <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">
                    <table   cellpadding="4" cellspacing="2" align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td>
                             <B>ORDEN:</B> '.$orden.'
                      </td>
                      <td>
                             <B>FEC. LLEGADA:</B> '.$f_llegada.'
                      </td>
                      <td>
                          <B>FEC. MAX ENT:</B> '.$f_entrega.'
                      </td>
                    </tr>  
                    </table>  

          </div>  


          <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">
          <div style="text-align:center"><B>DATOS DE CONTACTO</B></div>


                    <table   cellpadding="1"  align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >

                    
                    <tr >      
                      <td style="width:80% !important">
                          <B>PROD:</B> '.$producto.'
                      </td> 
                      <td  rowspan="2">
                           <div   style=" border:solid 1px #000;border-collapse: collapse;text-align:center "> 
                            <B>ID VENTA:</B> <br>
                            '.$idventa.'
                          </div>

                      </td> 
                    </tr>  
                    <tr >      
                      <td style="width:80% !important">
                          <B>SUSC:</B> '.$suscriptor.'
                      </td>  
                    </tr> 
                    
                    <tr >      
                      <td style="width:80% !important">
                          <B>DIR:</B> '.$direccion.'
                      </td> 
                      <td  rowspan="2">
                           <div   style=" border:solid 1px #000;border-collapse: collapse;text-align:center "> 
                            <B>CUENTA:</B> <br>
                            '.$cuenta.'
                          </div>

                      </td> 
                    </tr>  
                    <tr >      
                      <td style="width:80% !important">
                          <B>CIUD:</B> '.$ciudad.'
                      </td>  
                    </tr> 
                    <tr >      
                      <td colspan="2"> 
                      <table   cellpadding="0" cellspacing="0"  align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td><B>CONSE:</B> '.$consecutivo.'
                      </td>
                      <td>
                             <B>RUTA:</B> '.$sucursal.''.$cuadratula.''.$ciclo.''.$grupo.'
                      </td> 
                    </tr>  
                    </table>  
                      </td>  
                    </tr> 



                    </table>  

             



          </div>  
  <div style="text-align:center;font-size:8px;"><B>RESULTADO DE VISITA</B></div>

   <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">
                    <table   cellpadding="2" cellspacing="2" align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td>
                            EFECTIVO  
                                 <span class="" style="padding: 2px 10px; border:solid 1px #000;margin-left:5px"> </span>
                      </td>
                      <td>
                            NO EFECTIVO         
                                 <span class="" style="padding: 2px 10px; border:solid 1px #000;margin-left:5px"> </span>              </td>
                      <td style="width:40%">
                          
                         INTENTO 

                         <span class="" style="padding: 4px 7.8px; border:solid 1px #000;font-size:5PX">1</span>
                         <span class="" style="padding: 4px 7.8px; border:solid 1px #000;font-size:5PX">2</span>
                         <span class="" style="padding: 4px 7.8px; border:solid 1px #000;font-size:5PX">3</span>
                      </td>
                    </tr>  
                    </table>  

          </div>    


   <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">

   <table   style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td valign="top">
   <div    style=";font-size:6px; " >FIRMA O SELLO DE RECIBO</div> 
   <br><br><br><br>
   <div    style=" color:#CCC; " >Agente:</div> 

          </div>       
                      </td>   
                      <td align="right" style="color:#CCC;">
                      Medidor <br><br>
                      Lectura <br><br>
                      Telefono <br><br>
                      </td>

                    </tr >   
      </table>  




       </td> 
       <td valign="top">


        <table cellpadding="3" style="font-size:8px;text-align:center;margin:auto">
                <tbody>
                <tr>  
     
                      <td colspan="2" class="">
                      <div style="font-size:10px;text-align:center"><b>ANOMALIA</b>
                      </div></td>
     
                   </tr>
                                           
                   
     
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">0</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">1</span>
                         </td>  
                   </tr>  
     
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">2</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">3</span>
                         </td>  
                   </tr>  
      
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">4</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">5</span>
                         </td>  
                   </tr>  
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">6</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">7</span>
                         </td>  
                   </tr>  
      
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">8</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">9</span>
                         </td>  
                   </tr>  
      
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000">10</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000">11</span>
                         </td>  
                   </tr>  
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000; ">12</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000">13</span>
                         </td>  
                   </tr>  
      
      
      
     
                    <tr> 
                       <td class="td-left" colspan="2">
                         <div style="padding: 2px 6px; border:solid 1px #000;text-align:center ">
                            FECHA GESTION <BR>
                             <P   style="color:#CCC;">
                             DD - MM - AAAA
                             </P>


                         </div>
                         </td>   
                   </tr>  
      
      

     
              </tbody></table>



            </td> </tr> 
             </tbody></table>
       
       </td>  ';

        $tbl.='</tr>';

          $cons4++;
          
         }
         else{
           $b--;
         }
         $Y1 = $Y1+350;//3
         
       }

        //****************************************************************************************************** */
        
    // $tbl.='   <tr nobr="true"> ';
           //************************************************************************************************* */
           else if(($i%8)==5){ 
          
            if(count($parte5)!=$cons5){
    
           $agente=$parte5[$cons5]['agente'];
           $producto=$parte5[$cons5]['producto'];
             $orden=$parte5[$cons5]['orden'];
           $consecutivo=$parte5[$cons5]['consecutivo']; 
           $cuenta= $parte5[$cons5]['cuenta'];
           $idventa=$parte5[$cons5]['idventa'];
           $direccion=$parte5[$cons5]['direccion'];
           $cuadratula=$parte5[$cons5]['cuadralatura'];
           $ciclo=$parte5[$cons5]['ciclo'];
           $suscriptor=$parte5[$cons5]['suscriptor'];
           $grupo=$parte5[$cons5]['grupo'];
           $sucursal=$parte5[$cons5]['sucursal'];
           $f_llegada=$parte5[$cons5]['fechallegada'];
           $f_entrega=$parte5[$cons5]['fechaentrega'];
           $cedula=$parte5[$cons5]['cedula'];
           $especial1=$parte5[$cons5]['especial'];
           $lote= $parte5[$cons5]['lote'];
     
           
         
           $tbl.=' <tr nobr="true"> 


       <td style="width:50% !important"> 



        <table    align="center" style="margin:auto;">
          <tr >      
            <td style="width:100% !important" colspan="2"> 
                  <div class="codbarra"  style="text-align:center;width:100%;margin-bottom:5px;margin-top:5px;" >*'.$consecutivo.'*</div>
                       

            </td>
          </tr>  




        <tr >     
           <td   valign="top" style="width:75% !important">  
 
          <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">
                    <table   cellpadding="4" cellspacing="2" align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td>
                             <B>ORDEN:</B> '.$orden.'
                      </td>
                      <td>
                             <B>FEC. LLEGADA:</B> '.$f_llegada.'
                      </td>
                      <td>
                          <B>FEC. MAX ENT:</B> '.$f_entrega.'
                      </td>
                    </tr>  
                    </table>  

          </div>  


          <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">
          <div style="text-align:center"><B>DATOS DE CONTACTO</B></div>


                    <table   cellpadding="1"  align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >

                    
                    <tr >      
                      <td style="width:80% !important">
                          <B>PROD:</B> '.$producto.'
                      </td> 
                      <td  rowspan="2">
                           <div   style=" border:solid 1px #000;border-collapse: collapse;text-align:center "> 
                            <B>ID VENTA:</B> <br>
                            '.$idventa.'
                          </div>

                      </td> 
                    </tr>  
                    <tr >      
                      <td style="width:80% !important">
                          <B>SUSC:</B> '.$suscriptor.'
                      </td>  
                    </tr> 
                    
                    <tr >      
                      <td style="width:80% !important">
                          <B>DIR:</B> '.$direccion.'
                      </td> 
                      <td  rowspan="2">
                           <div   style=" border:solid 1px #000;border-collapse: collapse;text-align:center "> 
                            <B>CUENTA:</B> <br>
                            '.$cuenta.'
                          </div>

                      </td> 
                    </tr>  
                    <tr >      
                      <td style="width:80% !important">
                          <B>CIUD:</B> '.$ciudad.'
                      </td>  
                    </tr> 
                    <tr >      
                      <td colspan="2"> 
                      <table   cellpadding="0" cellspacing="0"  align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td><B>CONSE:</B> '.$consecutivo.'
                      </td>
                      <td>
                             <B>RUTA:</B> '.$sucursal.''.$cuadratula.''.$ciclo.''.$grupo.'
                      </td> 
                    </tr>  
                    </table>  
                      </td>  
                    </tr> 



                    </table>  

             



          </div>  
  <div style="text-align:center;font-size:8px;"><B>RESULTADO DE VISITA</B></div>

   <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">
                    <table   cellpadding="2" cellspacing="2" align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td>
                            EFECTIVO  
                                 <span class="" style="padding: 2px 10px; border:solid 1px #000;margin-left:5px"> </span>
                      </td>
                      <td>
                            NO EFECTIVO         
                                 <span class="" style="padding: 2px 10px; border:solid 1px #000;margin-left:5px"> </span>              </td>
                      <td style="width:40%">
                         
                         INTENTO 

                         <span class="" style="padding: 4px 7.8px; border:solid 1px #000;font-size:5PX">1</span>
                         <span class="" style="padding: 4px 7.8px; border:solid 1px #000;font-size:5PX">2</span>
                         <span class="" style="padding: 4px 7.8px; border:solid 1px #000;font-size:5PX">3</span>
                      </td>
                    </tr>  
                    </table>  

          </div>    


   <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">

   <table   style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td valign="top">
   <div    style=";font-size:6px; " >FIRMA O SELLO DE RECIBO</div> 
   <br><br><br><br>
   <div    style=" color:#CCC; " >Agente:</div> 

          </div>       
                      </td>   
                      <td align="right" style="color:#CCC;">
                      Medidor <br><br>
                      Lectura <br><br>
                      Telefono <br><br>
                      </td>

                    </tr >   
      </table>  




       </td> 
       <td valign="top">


        <table cellpadding="3" style="font-size:8px;text-align:center;margin:auto">
                <tbody>
                <tr>  
     
                      <td colspan="2" class="">
                      <div style="font-size:10px;text-align:center"><b>ANOMALIA</b>
                      </div></td>
     
                   </tr>
                                           
                   
     
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">0</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">1</span>
                         </td>  
                   </tr>  
     
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">2</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">3</span>
                         </td>  
                   </tr>  
      
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">4</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">5</span>
                         </td>  
                   </tr>  
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">6</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">7</span>
                         </td>  
                   </tr>  
      
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">8</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">9</span>
                         </td>  
                   </tr>  
      
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000">10</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000">11</span>
                         </td>  
                   </tr>  
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000; ">12</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000">13</span>
                         </td>  
                   </tr>  
      
      
      
     
                    <tr> 
                       <td class="td-left" colspan="2">
                         <div style="padding: 2px 6px; border:solid 1px #000;text-align:center ">
                            FECHA GESTION <BR>
                             <P   style="color:#CCC;">
                             DD - MM - AAAA
                             </P>


                         </div>
                         </td>   
                   </tr>  
      
      

     
              </tbody></table>



            </td> </tr> 
             </tbody></table>
       
       </td> ';
        

            $cons5++;
            
           }
           else{
             $b--;
           }
           $Y1 = $Y1+350;//3
           
         }
  
          //****************************************************************************************************** */
        
        
        else if(($i%8)==6){   
        
        if(count($parte6)!=$cons6){
    
            $agente=$parte6[$cons6]['agente'];
            $producto=$parte6[$cons6]['producto'];
            $orden=$parte6[$cons6]['orden'];
            $consecutivo=$parte6[$cons6]['consecutivo']; 
            $cuenta= $parte6[$cons6]['cuenta'];  
            $idventa=$parte6[$cons6]['idventa'];
            $direccion=$parte6[$cons6]['direccion'];
            $cuadratula=$parte6[$cons6]['cuadralatura'];
            $ciclo=$parte6[$cons6]['ciclo'];
            $suscriptor=$parte6[$cons6]['suscriptor'];
            $grupo=$parte6[$cons6]['grupo'];
            $sucursal=$parte6[$cons6]['sucursal'];
            $f_llegada=$parte6[$cons6]['fechallegada'];
            $f_entrega=$parte6[$cons6]['fechaentrega'];
            $cedula=$parte6[$cons6]['cedula'];
            $especial1=$parte6[$cons6]['especial'];
            $lote= $parte6[$cons6]['lote']; 
    
          
      
        
  $tbl.='

       <td style="width:50% !important"> 



        <table    align="center" style="margin:auto;">
          <tr >      
            <td style="width:100% !important" colspan="2"> 
                  <div class="codbarra"  style="text-align:center;width:100%;margin-bottom:5px;margin-top:5px;" >*'.$consecutivo.'*</div>
                       

            </td>
          </tr>  




        <tr >     
           <td   valign="top" style="width:75% !important">  
 
          <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">
                    <table   cellpadding="4" cellspacing="2" align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td>
                             <B>ORDEN:</B> '.$orden.'
                      </td>
                      <td>
                             <B>FEC. LLEGADA:</B> '.$f_llegada.'
                      </td>
                      <td>
                          <B>FEC. MAX ENT:</B> '.$f_entrega.'
                      </td>
                    </tr>  
                    </table>  

          </div>  


          <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">
          <div style="text-align:center"><B>DATOS DE CONTACTO</B></div>


                    <table   cellpadding="1"  align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >

                    
                    <tr >      
                      <td style="width:80% !important">
                          <B>PROD:</B> '.$producto.'
                      </td> 
                      <td  rowspan="2">
                           <div   style=" border:solid 1px #000;border-collapse: collapse;text-align:center "> 
                            <B>ID VENTA:</B> <br>
                            '.$idventa.'
                          </div>

                      </td> 
                    </tr>  
                    <tr >      
                      <td style="width:80% !important">
                          <B>SUSC:</B> '.$suscriptor.'
                      </td>  
                    </tr> 
                    
                    <tr >      
                      <td style="width:80% !important">
                          <B>DIR:</B> '.$direccion.'
                      </td> 
                      <td  rowspan="2">
                           <div   style=" border:solid 1px #000;border-collapse: collapse;text-align:center "> 
                            <B>CUENTA:</B> <br>
                            '.$cuenta.'
                          </div>

                      </td> 
                    </tr>  
                    <tr >      
                      <td style="width:80% !important">
                          <B>CIUD:</B> '.$ciudad.'
                      </td>  
                    </tr> 
                    <tr >      
                      <td colspan="2"> 
                      <table   cellpadding="0" cellspacing="0"  align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td><B>CONSE:</B> '.$consecutivo.'
                      </td>
                      <td>
                             <B>RUTA:</B> '.$sucursal.''.$cuadratula.''.$ciclo.''.$grupo.'
                      </td> 
                    </tr>  
                    </table>  
                      </td>  
                    </tr> 



                    </table>  

             



          </div>  
  <div style="text-align:center;font-size:8px;"><B>RESULTADO DE VISITA</B></div>

   <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">
                    <table   cellpadding="2" cellspacing="2" align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td>
                            EFECTIVO  
                                 <span class="" style="padding: 2px 10px; border:solid 1px #000;margin-left:5px"> </span>
                      </td>
                      <td>
                            NO EFECTIVO         
                                 <span class="" style="padding: 2px 10px; border:solid 1px #000;margin-left:5px"> </span>              </td>
                      <td style="width:40%">
                      
                         INTENTO 

                         <span class="" style="padding: 4px 7.8px; border:solid 1px #000;font-size:5PX">1</span>
                         <span class="" style="padding: 4px 7.8px; border:solid 1px #000;font-size:5PX">2</span>
                         <span class="" style="padding: 4px 7.8px; border:solid 1px #000;font-size:5PX">3</span>
                      </td>
                    </tr>  
                    </table>  

          </div>    


   <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">

   <table   style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td valign="top">
   <div    style=";font-size:6px; " >FIRMA O SELLO DE RECIBO</div> 
   <br><br><br><br>
   <div    style=" color:#CCC; " >Agente:</div> 

          </div>       
                      </td>   
                      <td align="right" style="color:#CCC;">
                      Medidor <br><br>
                      Lectura <br><br>
                      Telefono <br><br>
                      </td>

                    </tr >   
      </table>  




       </td> 
       <td valign="top">


        <table cellpadding="3" style="font-size:8px;text-align:center;margin:auto">
                <tbody>
                <tr>  
     
                      <td colspan="2" class="">
                      <div style="font-size:10px;text-align:center"><b>ANOMALIA</b>
                      </div></td>
     
                   </tr>
                                           
                   
     
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">0</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">1</span>
                         </td>  
                   </tr>  
     
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">2</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">3</span>
                         </td>  
                   </tr>  
      
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">4</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">5</span>
                         </td>  
                   </tr>  
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">6</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">7</span>
                         </td>  
                   </tr>  
      
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">8</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">9</span>
                         </td>  
                   </tr>  
      
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000">10</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000">11</span>
                         </td>  
                   </tr>  
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000; ">12</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000">13</span>
                         </td>  
                   </tr>  
      
      
      
     
                    <tr> 
                       <td class="td-left" colspan="2">
                         <div style="padding: 2px 6px; border:solid 1px #000;text-align:center ">
                            FECHA GESTION <BR>
                             <P   style="color:#CCC;">
                             DD - MM - AAAA
                             </P>


                         </div>
                         </td>   
                   </tr>  
      
      

     
              </tbody></table>



            </td> </tr> 
             </tbody></table>
       
       </td> ';

  
     $tbl.='</tr>';
 
          
          $cons6++;
        }else{
            $b--;
          }
          $Y =  $Y + 1410; 
          $Y1 = $Y + 25;
           
        }

        //****************************************************************************************************** */
        
    // $tbl.='   <tr nobr="true"> ';
           //************************************************************************************************* */
           else if(($i%8)==7){ 
          
            if(count($parte7)!=$cons7){
    
         $agente=$parte7[$cons7]['agente'];
           $producto=$parte7[$cons7]['producto'];
             $orden=$parte7[$cons7]['orden'];
           $consecutivo=$parte7[$cons7]['consecutivo']; 
           $cuenta= $parte7[$cons7]['cuenta'];
           $idventa=$parte7[$cons7]['idventa'];
           $direccion=$parte7[$cons7]['direccion'];
           $cuadratula=$parte7[$cons7]['cuadralatura'];
           $ciclo=$parte7[$cons7]['ciclo'];
           $suscriptor=$parte7[$cons7]['suscriptor'];
           $grupo=$parte7[$cons7]['grupo'];
           $sucursal=$parte7[$cons7]['sucursal'];
           $f_llegada=$parte7[$cons7]['fechallegada'];
           $f_entrega=$parte7[$cons7]['fechaentrega'];
           $cedula=$parte7[$cons7]['cedula'];
           $especial1=$parte7[$cons7]['especial'];
           $lote= $parte7[$cons7]['lote'];
     
           
         
           $tbl.=' <tr nobr="true"> 


       <td style="width:50% !important"> 



        <table    align="center" style="margin:auto;">
          <tr >      
            <td style="width:100% !important" colspan="2"> 
                  <div class="codbarra"  style="text-align:center;width:100%;margin-bottom:5px;margin-top:5px;" >*'.$consecutivo.'*</div>
                       

            </td>
          </tr>  




        <tr >     
           <td   valign="top" style="width:75% !important">  
 
          <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">
                    <table   cellpadding="4" cellspacing="2" align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td>
                             <B>ORDEN:</B> '.$orden.'
                      </td>
                      <td>
                             <B>FEC. LLEGADA:</B> '.$f_llegada.'
                      </td>
                      <td>
                          <B>FEC. MAX ENT:</B> '.$f_entrega.'
                      </td>
                    </tr>  
                    </table>  

          </div>  


          <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">
          <div style="text-align:center"><B>DATOS DE CONTACTO</B></div>


                    <table   cellpadding="1"  align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >

                    
                    <tr >      
                      <td style="width:80% !important">
                          <B>PROD:</B> '.$producto.'
                      </td> 
                      <td  rowspan="2">
                           <div   style=" border:solid 1px #000;border-collapse: collapse;text-align:center "> 
                            <B>ID VENTA:</B> <br>
                            '.$idventa.'
                          </div>

                      </td> 
                    </tr>  
                    <tr >      
                      <td style="width:80% !important">
                          <B>SUSC:</B> '.$suscriptor.'
                      </td>  
                    </tr> 
                    
                    <tr >      
                      <td style="width:80% !important">
                          <B>DIR:</B> '.$direccion.'
                      </td> 
                      <td  rowspan="2">
                           <div   style=" border:solid 1px #000;border-collapse: collapse;text-align:center "> 
                            <B>CUENTA:</B> <br>
                            '.$cuenta.'
                          </div>

                      </td> 
                    </tr>  
                    <tr >      
                      <td style="width:80% !important">
                          <B>CIUD:</B> '.$ciudad.'
                      </td>  
                    </tr> 
                    <tr >      
                      <td colspan="2"> 
                      <table   cellpadding="0" cellspacing="0"  align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td><B>CONSE:</B> '.$consecutivo.'
                      </td>
                      <td>
                             <B>RUTA:</B> '.$sucursal.''.$cuadratula.''.$ciclo.''.$grupo.'
                      </td> 
                    </tr>  
                    </table>  
                      </td>  
                    </tr> 



                    </table>  

             



          </div>  
  <div style="text-align:center;font-size:8px;"><B>RESULTADO DE VISITA</B></div>

   <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">
                    <table   cellpadding="2" cellspacing="2" align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td>
                            EFECTIVO  
                                 <span class="" style="padding: 2px 10px; border:solid 1px #000;margin-left:5px"> </span>
                      </td>
                      <td>
                            NO EFECTIVO         
                                 <span class="" style="padding: 2px 10px; border:solid 1px #000;margin-left:5px"> </span>              </td>
                      <td style="width:40%">
                          
                         INTENTO 

                         <span class="" style="padding: 4px 7.8px; border:solid 1px #000;font-size:5PX">1</span>
                         <span class="" style="padding: 4px 7.8px; border:solid 1px #000;font-size:5PX">2</span>
                         <span class="" style="padding: 4px 7.8px; border:solid 1px #000;font-size:5PX">3</span>
                      </td>
                    </tr>  
                    </table>  

          </div>    


   <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">

   <table   style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td valign="top">
   <div    style=";font-size:6px; " >FIRMA O SELLO DE RECIBO</div> 
   <br><br><br><br>
   <div    style=" color:#CCC; " >Agente:</div> 

          </div>       
                      </td>   
                      <td align="right" style="color:#CCC;">
                      Medidor <br><br>
                      Lectura <br><br>
                      Telefono <br><br>
                      </td>

                    </tr >   
      </table>  




       </td> 
       <td valign="top">


        <table cellpadding="3" style="font-size:8px;text-align:center;margin:auto">
                <tbody>
                <tr>  
     
                      <td colspan="2" class="">
                      <div style="font-size:10px;text-align:center"><b>ANOMALIA</b>
                      </div></td>
     
                   </tr>
                                           
                   
     
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">0</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">1</span>
                         </td>  
                   </tr>  
     
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">2</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">3</span>
                         </td>  
                   </tr>  
      
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">4</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">5</span>
                         </td>  
                   </tr>  
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">6</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">7</span>
                         </td>  
                   </tr>  
      
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">8</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">9</span>
                         </td>  
                   </tr>  
      
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000">10</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000">11</span>
                         </td>  
                   </tr>  
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000; ">12</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000">13</span>
                         </td>  
                   </tr>  
      
      
      
     
                    <tr> 
                       <td class="td-left" colspan="2">
                         <div style="padding: 2px 6px; border:solid 1px #000;text-align:center ">
                            FECHA GESTION <BR>
                             <P   style="color:#CCC;">
                             DD - MM - AAAA
                             </P>


                         </div>
                         </td>   
                   </tr>  
      
      

     
              </tbody></table>



            </td> </tr> 
             </tbody></table>
       
       </td> ';
        

            $cons7++;
            
           }
           else{
             $b--;
           }
           $Y1 = $Y1+350;//3
           
         }
  
          //****************************************************************************************************** */
        
        
        else if(($i%8)==0){   
        
        if(count($parte8)!=$cons8){
    
            $agente=$parte8[$cons8]['agente'];
            $producto=$parte8[$cons8]['producto'];
            $orden=$parte8[$cons8]['orden'];
            $consecutivo=$parte8[$cons8]['consecutivo']; 
            $cuenta= $parte8[$cons8]['cuenta'];  
            $idventa=$parte8[$cons8]['idventa'];
            $direccion=$parte8[$cons8]['direccion'];
            $cuadratula=$parte8[$cons8]['cuadralatura'];
            $ciclo=$parte8[$cons8]['ciclo'];
            $suscriptor=$parte8[$cons8]['suscriptor'];
            $grupo=$parte8[$cons8]['grupo'];
            $sucursal=$parte8[$cons8]['sucursal'];
            $f_llegada=$parte8[$cons8]['fechallegada'];
            $f_entrega=$parte8[$cons8]['fechaentrega'];
            $cedula=$parte8[$cons8]['cedula'];
            $especial1=$parte8[$cons8]['especial'];
            $lote= $parte8[$cons8]['lote']; 
    
          
      
        
  $tbl.='

       <td style="width:50% !important"> 



        <table    align="center" style="margin:auto;">
          <tr >      
            <td style="width:100% !important" colspan="2"> 
                  <div class="codbarra"  style="text-align:center;width:100%;margin-bottom:5px;margin-top:5px;" >*'.$consecutivo.'*</div>
                       

            </td>
          </tr>  




        <tr >     
           <td   valign="top" style="width:75% !important">  
 
          <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">
                    <table   cellpadding="4" cellspacing="2" align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td>
                             <B>ORDEN:</B> '.$orden.'
                      </td>
                      <td>
                             <B>FEC. LLEGADA:</B> '.$f_llegada.'
                      </td>
                      <td>
                          <B>FEC. MAX ENT:</B> '.$f_entrega.'
                      </td>
                    </tr>  
                    </table>  

          </div>  


          <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">
          <div style="text-align:center"><B>DATOS DE CONTACTO</B></div>


                    <table   cellpadding="1"  align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >

                    
                    <tr >      
                      <td style="width:80% !important">
                          <B>PROD:</B> '.$producto.'
                      </td> 
                      <td  rowspan="2">
                           <div   style=" border:solid 1px #000;border-collapse: collapse;text-align:center "> 
                            <B>ID VENTA:</B> <br>
                            '.$idventa.'
                          </div>

                      </td> 
                    </tr>  
                    <tr >      
                      <td style="width:80% !important">
                          <B>SUSC:</B> '.$suscriptor.'
                      </td>  
                    </tr> 
                    
                    <tr >      
                      <td style="width:80% !important">
                          <B>DIR:</B> '.$direccion.'
                      </td> 
                      <td  rowspan="2">
                           <div   style=" border:solid 1px #000;border-collapse: collapse;text-align:center "> 
                            <B>CUENTA:</B> <br>
                            '.$cuenta.'
                          </div>

                      </td> 
                    </tr>  
                    <tr >      
                      <td style="width:80% !important">
                          <B>CIUD:</B> '.$ciudad.'
                      </td>  
                    </tr> 
                    <tr >      
                      <td colspan="2"> 
                      <table   cellpadding="0" cellspacing="0"  align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td><B>CONSE:</B> '.$consecutivo.'
                      </td>
                      <td>
                             <B>RUTA:</B> '.$sucursal.''.$cuadratula.''.$ciclo.''.$grupo.'
                      </td> 
                    </tr>  
                    </table>  
                      </td>  
                    </tr> 



                    </table>  

             



          </div>  
  <div style="text-align:center;font-size:8px;"><B>RESULTADO DE VISITA</B></div>

   <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">
                    <table   cellpadding="2" cellspacing="2" align="center" 
                    style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td>
                            EFECTIVO  
                                 <span class="" style="padding: 2px 10px; border:solid 1px #000;margin-left:5px"> </span>
                      </td>
                      <td>
                            NO EFECTIVO         
                                 <span class="" style="padding: 2px 10px; border:solid 1px #000;margin-left:5px"> </span>              </td>
                      <td style="width:40%">
                        
                         INTENTO 

                         <span class="" style="padding: 4px 7.8px; border:solid 1px #000;font-size:5PX">1</span>
                         <span class="" style="padding: 4px 7.8px; border:solid 1px #000;font-size:5PX">2</span>
                         <span class="" style="padding: 4px 7.8px; border:solid 1px #000;font-size:5PX">3</span>
                      </td>
                    </tr>  
                    </table>  

          </div>    


   <div   style="margin:auto;font-size:8px;border:solid 1px #000;border-collapse: collapse;width:100%">

   <table   style="margin:auto;font-size:8px;width:100%"  >
                    
                    <tr >      
                      <td valign="top">
   <div    style=";font-size:6px; " >FIRMA O SELLO DE RECIBO</div> 
   <br><br><br><br>
   <div    style=" color:#CCC; " >Agente:</div> 

          </div>       
                      </td>   
                      <td align="right" style="color:#CCC;">
                      Medidor <br><br>
                      Lectura <br><br>
                      Telefono <br><br>
                      </td>

                    </tr >   
      </table>  




       </td> 
       <td valign="top">


        <table cellpadding="3" style="font-size:8px;text-align:center;margin:auto">
                <tbody>
                <tr>  
     
                      <td colspan="2" class="">
                      <div style="font-size:10px;text-align:center"><b>ANOMALIA</b>
                      </div></td>
     
                   </tr>
                                           
                   
     
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">0</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">1</span>
                         </td>  
                   </tr>  
     
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">2</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">3</span>
                         </td>  
                   </tr>  
      
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">4</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">5</span>
                         </td>  
                   </tr>  
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">6</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">7</span>
                         </td>  
                   </tr>  
      
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">8</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 7.8px; border:solid 1px #000">9</span>
                         </td>  
                   </tr>  
      
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000">10</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000">11</span>
                         </td>  
                   </tr>  
                    <tr> 
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000; ">12</span>
                         </td>  
                       <td class="td-left">
                         <span class="" style="padding: 2px 6px; border:solid 1px #000">13</span>
                         </td>  
                   </tr>  
      
      
      
     
                    <tr> 
                       <td class="td-left" colspan="2">
                         <div style="padding: 2px 6px; border:solid 1px #000;text-align:center ">
                            FECHA GESTION <BR>
                             <P   style="color:#CCC;">
                             DD - MM - AAAA
                             </P>


                         </div>
                         </td>   
                   </tr>  
      
      

     
              </tbody></table>



            </td> </tr> 
             </tbody></table>
       
       </td>  ';

  
     $tbl.='</tr>';

     $tbl.='</table></div>' ;
          
          $cons8++;
        }else{  
            $b--;
          }
          $Y =  $Y + 1410; 
          $Y1 = $Y + 25;
           
        }else{
             break;
            }
         $i++;
      }//End For  
	  

	
	   
	}//row_Cantidad!=0
	else
	
	{
		echo 'No encontro resultado';
	}  
	


}else{  
       echo 'Accesso denegado';
        
	 }
  

	 

  $tbl .='</body></html>'; 
   

  //$pdf->writeHTML($tbl, true, false, false, false, '');

 // $pdf->Output('guia.pdf', 'I');
 

   echo $tbl;
  
?>
</body>
</html>


