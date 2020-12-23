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
p.grupo,p.sucursal,p.fecha_llegada_fisico,
p.fecha_max_entrega,p.documento,p.especial1,p.lote,p.ciudad FROM 
((proyectoespecialenel p INNER JOIN actividad ac ON ac.cons=p.codactividad) LEFT JOIN agentes a ON a.usuario=p.codagente)
WHERE  ac.cons=".mysqli_real_escape_string($mysqli,$cons)."  ORDER BY ac.cons  ";
	  $datos=mysqli_query($mysqli,$consulta); 

	
	
	/*$datos=mysqli_query($mysqli,$consulta,array(), 
	array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));*/





	 $row_CantidadRegistro=mysqli_num_rows($datos);

    if($row_CantidadRegistro!=0){
		 
	

	if($row_CantidadRegistro>=7){  
			$CantidadHoja=ceil($row_CantidadRegistro/6);
		}else{
			$CantidadHoja=1;
		}  
		

		
        $parte1=array();
        $parte2=array();   
        $parte3=array();
        $parte4=array();
        $parte5=array();
        $parte6=array();
        $cons=1;
        $pos=1;
        $cot=0; 

	   //WHILE ****  
	   
    while($row=mysqli_fetch_array($datos)){   
       
		  

	$Datos=array('agente'=>$row[0],
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
		
		

        $cons++;
  
    }//END WHILE
	//echo $Datos;*/

	$tbl .='

	<html xmlns="http://www.w3.org/1999/xhtml">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	
	
	<head>
	
	<style type="text/css">
	
				.Rotate
				{
				font-size: 7.4px;
				-webkit-transform: rotate(-270deg);
				-moz-transform: rotate(-270deg);
				-ms-transform: rotate(-270deg);
				-o-transform: rotate(-270deg);
				transform: rotate(-270deg); 
				overflow: hidden;
				clear: both;
				cursor: pointer;
				padding: 1px;
				position: absolute;
				text-align: left;
				}
	
				.Normal
				{
				font-size: 7.4px;
	
				overflow: hidden !important;
					clear: both;
					cursor: pointer;
					padding: 1px;
					position: absolute;
					text-align: left; 
					z-index: 150;
					height: 9px;
				}
	
				.Centrar{
					font-size: 7.4px;
					overflow: hidden;
					clear: both;
					cursor: pointer;
					padding: 1px;
					position: absolute;
					text-align: left;
				}
	
				@font-face{
						font-family: LetraBarras;
						src: url(LetraBarras.ttf);            
				} 
	
				@font-face{
					font-family:"Yrsa-SemiBold";
					src:url(../fonts/Yrsa-Regular.ttf)
				}
	
				.table{
					width: 100%;
					border-collapse: collapse;
					margin:auto
				}
	
				.td-img{
					min-width: 6px;
					vertical-align: -webkit-baseline-middle;
					border-right: none;
					border-top: none;  
					padding-bottom: 6px;
	
	
				}
	
				.td-img>img{
					
					max-width: 95%;
					display: block;
					width: 106px;
					margin-left: 10px; 
				}
	
				.td-container{
					/*text-align: center;*/
					line-height: 1;
					font-size: 8px;
					min-width: 198px;
					vertical-align: middle;
				}
	
				.td-container>h4{
					margin: 0;
					margin-top: 4px;
					font-size: 23px;
					font-family: Yrsa-SemiBold;
					font-weight: 200;
				}
	
				.td-container>p{
					margin: 0;
					margin-top: 3px;
				}
	
				.td-origines{
					min-width: 78px;
					vertical-align: middle;
					border: 1px solid;
					font-size: 9px;
				}
	
				.datos{
					font-size: 9px;
					font-weight: 600;
					text-transform: uppercase;
				}
	
				.td-guia{
					min-width: 122px;
					vertical-align: middle;
					border: 1px solid;
					font-size: 9px;
				}
	
				.td-texto{
					padding: 2px;
					border: 1px solid;
				}
	
				.td-texto>p{
					margin: 0;
					font-size: 7px;
				}
	
				.p-center{
					margin-top: 6px;
					text-align: -webkit-center;
				}
	
				.td-orden{
					vertical-align: -webkit-baseline-middle;
					padding: 3px;
					border: 1px solid;
				}
	
				.td-orden>div{
					font-size: 9px;
					margin-bottom: 7px;
				}
	
				.td-orden>p{
					font-size: 11px;
					font-weight: 600;
					text-align: -webkit-right;
					margin: 0;
				}
	
				.top{margin-top: -1px;}
				.paddin{padding: 0px;}
				.table-td{border-collapse: collapse;}
	
				.table-td-zonaguia
				{
					border-collapse: collapse;
					margin-right: 77px;
					height: 100px;  
					width: 350px;
					margin-left: 10px;  
					
				}
	
				.td-left{
					border: 1px solid;
					font-size: 10px;
					font-weight: 600;
				}
	
				.td-left>p{
					font-weight: bold;
					text-transform: uppercase;
					padding: 2px;
					margin:0;
				}
	
				.p-especial{
					font-size: 7px;
					padding: 0px !important;
					width: 82px;
					height: 17px;
				}
	
				.td1{width: 226px;}
				.td2{width: 67px;}
				.td3{width: 103px;}
	
				.td-head{
					border: 1px solid;
					font-size: 8px;
					width: 112px;
					vertical-align: inherit;
					text-align: -webkit-center;
					padding: 0;
				}
	
				.td-head>h5{
					margin: 0;
					text-align: -webkit-center;
					background: rgba(0, 0, 0, 0.51);
					color: white;
					padding: 2px 0px;
					margin-bottom: 9px;
				}
	
				.td-head>div{
					font-size: 12px;
				}
	
				.td-barra{
					border: 1px solid;
					font-size: 10px;
					font-weight: 600;
					min-width: 193px;
					text-align: -webkit-center;
				}
	
	
				.codbarra{
	
				
					font-size: 48px;
					font-family: LetraBarras;
					font-weight: 100;
					margin: 0;
					padding: 0;
				}
	
				.tr-borde{
					border: 1px solid;
				}
				.td-colspan{
					padding: 11px 4px;
					font-size: 8px;
				}
	
				.td-colspan>div{
					min-width: 80px;
					display: inline-block;
				}
	
				.td-colspan>div>span{
					padding: 4px 11px;
					margin-left: 4px;
					border: 1px solid;
				}
	
				.td-inferior{
					padding: 4px 4px;
					font-size: 8px;
					padding-top: 7px;
				}
	
				.td-inferior>div{
					display: inline-block;
				}
	
				.td-w1{width: 108px;}
				.td-w2{width: 138px;}
				.td-w3{width: 156px;}
				.td-w4{width: 174px;}
				.td-w5{width: 100px;}
				.td-w6{width: 51px;}
	
				.td-inferior>div>span{
					padding: 2px 7px;
					margin-left: 4px;
					border: 1px solid;
				}
	
				.div_span{
					padding: 0px 7px;
					margin-left: 4px;
					border: 1px solid;
				}
	
				.brd-left{border-left: none !important;}
				.brd-top{border-top:none !important;}
				.brd-right{border-right:none !important;}
				.brd-bottom{border-bottom:none !important;}
	
				.td-colspan-datos{
					border: 1px solid;
					font-size: 8px;
				}
	
				.campo-bottom{margin-bottom: 5px;}
				.td-recibi{    
					border: 1px solid;
					font-size: 8px;
					min-width: 149px;
					vertical-align: -webkit-baseline-middle;
				}
	
				.td-hora{
					border: 1px solid;
					font-size: 8px;
					vertical-align: -webkit-baseline-middle;
				}
	
				.td-nombre{
					border: 1px solid;
					font-size: 8px;
					vertical-align: bottom;
					text-align: -webkit-center;
				}
	
				.td-blanco{
					border: 1px solid; 
					font-size: 8px;
					min-width: 99px;
				}
	
				.td-dias{
					border: 1px solid;
					font-size: 8px;
					vertical-align: -webkit-baseline-middle;
					text-align: -webkit-center;
				}
	
				.tabla-top{
					padding: 5px 0px;
					border: 1px solid rgba(62, 60, 60, 0.26);
					position: absolute;
					margin: 0px 20px;
				}
	
	</style>
	
	';
	 
	
	$tbl.='</head><body   onLoad="window.prifnt()" >'; 
	// -----------------------------------------------------------------------------
	
	// NON-BREAKING ROWS (nobr="true")
	

		

	//++++++++++ TABLA
	
	$cons1=0;
  $cons2=0;
  $cons3=0;
	$cons4=0;
	$cons5=0;
	$cons6=0;
	

    for($b=0;$b<$row_CantidadRegistro;$b++){
 
   		if(($i%6)==1){ 
    
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
      
   

  
      $tbl.='<div style="page-break-after: always; width:100%; height:auto; ">  ';
      $tbl.='<table border="0" cellpadding="2" cellspacing="2" align="center" style="width:98%;margin:auto;">
      ';


		

      $tbl.=' 
      <tr > 
     
       <td style="width:45% !important"> 
        
       <table class="table" style="margin-bottom:50px">
       <tr>
           <!--<td rowspan="2" class="td-container">-->
           <td colspan="2" style="text-align:center" ><div class="codbarra"  style="text-align:center;width:100%" >*'.$consecutivo.'*</div></td>
           
           
           
       </tr>
     
     </table> 
     
     <table class="table top" >
       <tr>
           <td valign="top" > 
               <table class="table-td">

                <tr>
                    
               <td colspan="3" class=""><div style="font-size:10px;text-align:center"><b>DATOS DE CONTACTO</b></div></td>
                </tr>
                       
                 <tr>
                 <td colspan="2" class="td-left"><div>DIRECCION</div><p>'.$direccion.'</p></td>
                 <td  class="td-left"><div>CIUDAD</div><p>'.$ciudad.'</p></td>  
                 </tr>    
               
                 <tr>
                 <td colspan="2" class="td-left"><div>AGENTE</div><p>'.$agente.'</p></td>
                 <td  class="td-left"><div>PRODUCTO</div><p>'.$producto.'</p></td>  
                 </tr>    
               
                 <tr><td colspan="2" class="td-left"><div>ORDEN</div><p>'.$orden.'</p></td>
                   <td  class="td-left"><div>CONSECUTIVO</div><p>'.$consecutivo.'</p></td>
                 </tr>
     
                 <tr><td colspan="2" class="td-left"><div>CUENTA</div><p>'.$cuenta.'</p></td>
                   <td  class="td-left"><div>ID VENTA</div><p>'.$idventa.'</p></td>
                 </tr> 
     
                 <tr><td colspan="2"  class="td-left"><div>CUADRALATURA</div><p>'.$cuadratula.'</p></td>
                   <td   class="td-left"><div>CICLO</div><p>'.$ciclo.'</p></td>
                 </tr>
     
     
     
     
                 <tr><td colspan="2" class="td-left"><div>SUSCRIPTOR</div><p>'.$suscriptor.'</p></td>
                   <td  class="td-left"><div>GRUPO</div><p>'.$grupo.'</p></td>
                 </tr>
     
                 <tr><td colspan="2" class="td-left"><div>SUCURSAL</div><p>'.$sucursal.'</p></td>
                   <td  class="td-left"><div>CEDULA</div><p>'.$cedula.'</p></td>
                 </tr>
     
                 <tr><td colspan="2" class="td-left"><div>LLEGADA FISICO</div><p>'.$f_llegada.'</p></td>
                   <td  class="td-left"><div>FECHA MAX ENTREGA</div><p>'.$f_entrega.'</p></td>
                 </tr>
     
                 <tr><td colspan="2" class="td-left"><div>ESPECIAL1</div><p>'.$especial1.'</p></td>
                 <td  class="td-left"><div>LOTE</div><p>'.$lote.'</p></td>
               </tr>
     
           
     
     
                
               </table>
           </td>
           
           <td class="paddin" valign="top"> 
     
           
     
               <table>
                <tbody>
                
                <tr>
                    
               <td colspan="2" class=""><div style="font-size:10px;text-align:center"><b>RESULTADO DE LA VISITA</b></div></td>
                </tr>
                       
     
                <tr>
     
                <td class="td-inferior">EFECTIVO</td>
                <td class="td-left"><span class="" style="
                    padding: 0px 8px;
                    "></span></td>  
               </tr>  
     
               <tr>
     
                <td class="td-inferior">NO EFECTIVO</td>
                <td class="td-left"><span class="" style="
                    padding: 0px 8px;
                    "></span></td>  
               </tr>  
     
             
                   <tr> 
                        <td class="td-inferior">FIRMA RECIBIDO</td>
                   </tr>
     
     
                   <tr>
     
               
                   <td colspan="3">

                   <div class="" style="margin-left: 0px;
                   border: 1px solid;width:100%;height:70px"></div>


                       </td>  
                  </tr> 
     
                  <tr> 
                  <td class="td-inferior" >FECHA GESTION</td>
                </tr>
                
                <tr>
                <td colspan="3">

                   <div class="" style="margin-left: 0px;
                   border: 1px solid;width:100%;height:40px"></div></td>  
               </tr> 
                              
     
              </tbody></table>


           </td> 



           <td valign="top"  style=";border:solid 1px #000"> 

               <table class="paddin">
                <tbody>
                <tr>  
     
                      <td colspan="2" class=""><div style="font-size:8px;padding-left: 15px;padding-top: 7px;"><b>ANOMALIA</b></div></td>
     
                   </tr>
                                           
                   
     
                    <tr>
                           <td class="td-inferior">EFECTIVA</td>
                           <td class="td-left"><span class="" style="
                               padding: 0px 8px;
                               "></span></td>  
                   </tr>  
     
     
                   <tr>
     
                   <td class="td-inferior">SIN NOMENCLATURA</td>
                   <td class="td-left"><span class="" style="
                       padding: 0px 8px;
                       "></span></td>  
                  </tr>  
                  
                  <tr>
     
                   <td class="td-inferior">DIFICIL LOCALIZACION</td>
                   <td class="td-left"><span class="" style="
                       padding: 0px 8px;
                       "></span></td>  
                  </tr>  
                  
                  <tr>
     
                  <td class="td-inferior">DOBLE FACTURACION</td>
                  <td class="td-left"><span class="" style="
                      padding: 0px 8px;
                      "></span></td>  
                 </tr>  
     
                 <tr>
     
                  <td class="td-inferior">ERROR EN DIRECCION</td>
                  <td class="td-left"><span class="" style="
                      padding: 0px 8px;
                      "></span></td>  
                 </tr>  
     
                 <tr>
     
                 <td class="td-inferior">PREDIO DEMOLIDO</td>
                 <td class="td-left"><span class="" style="
                     padding: 0px 8px;
                     "></span></td>  
                </tr>  
     
     
                <tr>
     
                <td class="td-inferior">PREDIO ABANDONADO</td>
                <td class="td-left"><span class="" style="
                    padding: 0px 8px;
                    "></span></td>  
               </tr>  
     
     
                <tr>
     
                <td class="td-inferior">ACCESO DENEGADO</td>
                <td class="td-left"><span class="" style="
                    padding: 0px 8px;
                    "></span></td>  
               </tr>  
     
     
                <tr>
     
                <td class="td-inferior">LOTE VACIO</td>
                <td class="td-left"><span class="" style="
                    padding: 0px 8px;
                    "></span></td>  
               </tr>  
     
     
                <tr>
     
                <td class="td-inferior">APARTADO AEREO</td>
                <td class="td-left"><span class="" style="
                    padding: 0px 8px;
                    "></span></td>  
               </tr>  
     
     
                <tr>
     
                <td class="td-inferior">FUERA DE CICLO O ZONA</td>
                <td class="td-left"><span class="" style="
                    padding: 0px 8px;
                    "></span></td>  
               </tr>
     
                <tr>
     
                <td class="td-inferior">PERRO BRAVO</td>
                <td class="td-left"><span class="" style="
                    padding: 0px 8px;
                    "></span></td>  
               </tr>
     
                <tr>
     
                <td class="td-inferior">ZONA PELIGROSA</td>
                <td class="td-left"><span class="" style="
                    padding: 0px 8px;
                    "></span></td>  
               </tr>
     
                <tr>
     
                <td class="td-inferior">AISLAMIENTO PREVENTIVO</td>
                <td class="td-left"><span class="" style="
                    padding: 0px 8px;
                    "></span></td>  
               </tr>  
     

     
              </tbody></table>
           </td> 


       </tr>
     </table>
     
     
     
       
       </td><!--final primera cela-->
     
     
       
      ';




	
		
		$Y1 = $Y1+390;//1
         	$cons1++;
			
        }else if(($i%6)==2){  
		
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
   
     
          <td>
           
          <table class="table">
          <tr>
              <td rowspan="2" class="td-img"><img  src="LECTA.jpg"/></td>  
              <!--<td rowspan="2" class="td-container">-->
              <td colspan="2"  ><div class="codbarra">*'.$consecutivo.'*</div></td>
              
              
              
          </tr>
        
        </table> 
        
        <table class="table top">
          <tr>
              <td class="paddin" STYLE="
              padding-bottom: 100px;
          "> 
                  <table class="table-td">
                    <tr>
                    <td colspan="2" class="td-left"><div>AGENTE</div><p>'.$agente.'</p></td>
                    <td  class="td-left"><div>PRODUCTO</div><p>'.$producto.'</p></td>  
                    </tr>    
                  
                    <tr><td colspan="2" class="td-left"><div>ORDEN</div><p>'.$orden.'</p></td>
                      <td  class="td-left"><div>CONSECUTIVO</div><p>'.$consecutivo.'</p></td>
                    </tr>
        
                    <tr><td colspan="2" class="td-left"><div>CUENTA</div><p>'.$cuenta.'</p></td>
                      <td  class="td-left"><div>ID VENTA</div><p>'.$idventa.'</p></td>
                    </tr> 
        
                    <tr><td colspan="2"  class="td-left"><div>CUADRALATURA</div><p>'.$cuadratula.'</p></td>
                      <td   class="td-left"><div>CICLO</div><p>'.$ciclo.'</p></td>
                    </tr>
        
        
        
        
                    <tr><td colspan="2" class="td-left"><div>SUSCRIPTOR</div><p>'.$suscriptor.'</p></td>
                      <td  class="td-left"><div>GRUPO</div><p>'.$grupo.'</p></td>
                    </tr>
        
                    <tr><td colspan="2" class="td-left"><div>SUCURSAL</div><p>'.$sucursal.'</p></td>
                      <td  class="td-left"><div>CEDULA</div><p>'.$cedula.'</p></td>
                    </tr>
        
                    <tr><td colspan="2" class="td-left"><div>LLEGADA FISICO</div><p>'.$f_llegada.'</p></td>
                      <td  class="td-left"><div>FECHA MAX ENTREGA</div><p>'.$f_entrega.'</p></td>
                    </tr>
        
                    <tr><td colspan="2" class="td-left"><div>ESPECIAL1</div><p>'.$especial1.'</p></td>
                    <td  class="td-left"><div>LOTE</div><p>'.$lote.'</p></td>
                  </tr>
        
              
        
        
                   
                  </table>
              </td>
              
              <td class="paddin" > 
        
              
        

                  <table class="paddin">
                   <tbody>
                   
                   <tr>
                       
                  <td colspan="2" class=""><div style="font-size:8px;padding-left: 15px;"><b>RESULTADO DE LA VISITA</b></div></td>
                   </tr>
                          
        
                   <tr>
        
                   <td class="td-inferior">EFECTIVO</td>
                   <td class="td-left"><span class="" style="
                       padding: 0px 8px;
                       "></span></td>  
                  </tr>  
        
                  <tr>
        
                   <td class="td-inferior">NO EFECTIVO</td>
                   <td class="td-left"><span class="" style="
                       padding: 0px 8px;
                       "></span></td>  
                  </tr>  
        
                
                      <tr> 
                           <td class="td-inferior">FIRMA RECIBIDO</td>
                      </tr>
        
        
                      <tr>
        
                  
                      <td class="td-inferior"><span class="" style="margin-left: 0px;
                      padding: 10px 70px; 
                      border: 1px solid;
                          "></span></td>  
                     </tr> 
        
                     <tr> 
                     <td class="td-inferior">FECHA GESTION</td>
                   </tr>
                   
                   <tr>
                   <td class="td-inferior"><span class="" style="margin-left: 0px;
                   padding: 10px 70px;
                   border: 1px solid;
                       "></span></td>  
                  </tr> 
                                 
                    
                      <tr>  
        
                         <td colspan="2" class=""><div style="font-size:8px;padding-left: 15px;padding-top: 7px;"><b>ANOMALIA</b></div></td>
        
                      </tr>
                                              
                      
        
                       <tr>
                              <td class="td-inferior">DIRECCION ERRADA </td>
                              <td class="td-left"><span class="" style="
                                  padding: 0px 8px;
                                  "></span></td>  
                      </tr>  
        
        
                      <tr>
        
                      <td class="td-inferior"> DIRECCION IMCOMPLETA </td>
                      <td class="td-left"><span class="" style="
                          padding: 0px 8px;
                          "></span></td>  
                     </tr>  
                     
                     <tr>
        
                      <td class="td-inferior">DESTINATARIO DESCONOCIDO</td>
                      <td class="td-left"><span class="" style="
                          padding: 0px 8px;
                          "></span></td>  
                     </tr>  
                     
                     <tr>
        
                     <td class="td-inferior">REHUSADO</td>
                     <td class="td-left"><span class="" style="
                         padding: 0px 8px;
                         "></span></td>  
                    </tr>  
        
                    <tr>
        
                     <td class="td-inferior">NO REHUSADO</td>
                     <td class="td-left"><span class="" style="
                         padding: 0px 8px;
                         "></span></td>  
                    </tr>  
        
                    <tr>
        
                    <td class="td-inferior">NO RESIDE</td>
                    <td class="td-left"><span class="" style="
                        padding: 0px 8px;
                        "></span></td>  
                   </tr>  
        
        
                   <tr>
        
                   <td class="td-inferior">NHQR</td>
                   <td class="td-left"><span class="" style="
                       padding: 0px 8px;
                       "></span></td>  
                  </tr>  
        
        
                 </tbody></table>
        
              </td> 
          </tr>
        </table>
        
        
        
          
          </td><!--final primera cela-->
        
        
          
         ';

         $tbl.='</tr>';
          
        $Y1 = $Y1+350;//2
    $cons2++;
          
        }
       // $tbl.='<tr nobr="true"> ';
        
   else if(($i%6)==3){ 
          
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
    
          
        
         $tbl.=' <tr nobr="true"> ';

          $tbl.=' 
   
     
          <td>
           
          <table class="table">
          <tr>
              <td rowspan="2" class="td-img"><img  src="LECTA.jpg"/></td>  
              <!--<td rowspan="2" class="td-container">-->
              <td colspan="2" style="padding-right: 100px;" ><div class="codbarra">*'.$consecutivo.'*</div></td>
              
              
              
          </tr>
        
        </table> 
        
        <table class="table top">
          <tr>
              <td class="paddin" STYLE="
              padding-bottom: 100px;
          "> 
                  <table class="table-td">
                    <tr>
                    <td colspan="2" class="td-left"><div>AGENTE</div><p>'.$agente.'</p></td>
                    <td  class="td-left"><div>PRODUCTO</div><p>'.$producto.'</p></td>  
                    </tr>    
                  
                    <tr><td colspan="2" class="td-left"><div>ORDEN</div><p>'.$orden.'</p></td>
                      <td  class="td-left"><div>CONSECUTIVO</div><p>'.$consecutivo.'</p></td>
                    </tr>
        
                    <tr><td colspan="2" class="td-left"><div>CUENTA</div><p>'.$cuenta.'</p></td>
                      <td  class="td-left"><div>ID VENTA</div><p>'.$idventa.'</p></td>
                    </tr> 
        
                    <tr><td colspan="2"  class="td-left"><div>CUADRALATURA</div><p>'.$cuadratula.'</p></td>
                      <td   class="td-left"><div>CICLO</div><p>'.$ciclo.'</p></td>
                    </tr>
        
        
        
        
                    <tr><td colspan="2" class="td-left"><div>SUSCRIPTOR</div><p>'.$suscriptor.'</p></td>
                      <td  class="td-left"><div>GRUPO</div><p>'.$grupo.'</p></td>
                    </tr>
        
                    <tr><td colspan="2" class="td-left"><div>SUCURSAL</div><p>'.$sucursal.'</p></td>
                      <td  class="td-left"><div>CEDULA</div><p>'.$cedula.'</p></td>
                    </tr>
        
                    <tr><td colspan="2" class="td-left"><div>LLEGADA FISICO</div><p>'.$f_llegada.'</p></td>
                      <td  class="td-left"><div>FECHA MAX ENTREGA</div><p>'.$f_entrega.'</p></td>
                    </tr>
        
                    <tr><td colspan="2" class="td-left"><div>ESPECIAL1</div><p>'.$especial1.'</p></td>
                    <td  class="td-left"><div>LOTE</div><p>'.$lote.'</p></td>
                  </tr>
        
              
        
        
                   
                  </table>
              </td>
              
              <td class="paddin" style="padding-right: 400;"> 
        
              
        
                  <table class="paddin">
                   <tbody>
                   
                   <tr>
                       
                  <td colspan="2" class=""><div style="font-size:8px;padding-left: 15px;"><b>RESULTADO DE LA VISITA</b></div></td>
                   </tr>
                          
        
                   <tr>
        
                   <td class="td-inferior">EFECTIVO</td>
                   <td class="td-left"><span class="" style="
                       padding: 0px 8px;
                       "></span></td>  
                  </tr>  
        
                  <tr>
        
                   <td class="td-inferior">NO EFECTIVO</td>
                   <td class="td-left"><span class="" style="
                       padding: 0px 8px;
                       "></span></td>  
                  </tr>  
        
                
                      <tr> 
                           <td class="td-inferior">FIRMA RECIBIDO</td>
                      </tr>
        
        
                      <tr>
        
                  
                      <td class="td-inferior"><span class="" style="margin-left: 0px;
                      padding: 10px 70px; 
                      border: 1px solid;
                          "></span></td>  
                     </tr> 
        
                     <tr> 
                     <td class="td-inferior">FECHA GESTION</td>
                   </tr>
                   
                   <tr>
                   <td class="td-inferior"><span class="" style="margin-left: 0px;
                   padding: 10px 70px;
                   border: 1px solid;
                       "></span></td>  
                  </tr> 
                                 
                    
                      <tr>  
        
                         <td colspan="2" class=""><div style="font-size:8px;padding-left: 15px;padding-top: 7px;"><b>ANOMALIA </b></div></td>
        
                      </tr>
                                              
                      
        
                       <tr>
                              <td class="td-inferior">DIRECCION ERRADA </td>
                              <td class="td-left"><span class="" style="
                                  padding: 0px 8px;
                                  "></span></td>  
                      </tr>  
        
        
                      <tr>
        
                      <td class="td-inferior"> DIRECCION IMCOMPLETA </td>
                      <td class="td-left"><span class="" style="
                          padding: 0px 8px;
                          "></span></td>  
                     </tr>  
                     
                     <tr>
        
                      <td class="td-inferior">DESTINATARIO DESCONOCIDO</td>
                      <td class="td-left"><span class="" style="
                          padding: 0px 8px;
                          "></span></td>  
                     </tr>  
                     
                     <tr>
        
                     <td class="td-inferior">REHUSADO</td>
                     <td class="td-left"><span class="" style="
                         padding: 0px 8px;
                         "></span></td>  
                    </tr>  
        
                    <tr>
        
                     <td class="td-inferior">NO REHUSADO</td>
                     <td class="td-left"><span class="" style="
                         padding: 0px 8px;
                         "></span></td>  
                    </tr>  
        
                    <tr>
        
                    <td class="td-inferior">NO RESIDE</td>
                    <td class="td-left"><span class="" style="
                        padding: 0px 8px;
                        "></span></td>  
                   </tr>  
        
        
                   <tr>
        
                   <td class="td-inferior">NHQR</td>
                   <td class="td-left"><span class="" style="
                       padding: 0px 8px;
                       "></span></td>  
                  </tr>  
        
        
                 </tbody></table>
        
              </td> 
          </tr>
        </table>
        
        
        
          
          </td><!--final primera cela-->
        
        
          
         ';
           $cons3++;
           
          }
          else{
            $b--;
          }
          $Y1 = $Y1+350;//3
          
        }
        
        //************************************************************************************************* */
        else if(($i%6)==4){ 
          
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
  
    
         <td>
          
         <table class="table">
         <tr>
             <td rowspan="2" class="td-img"><img  src="LECTA.jpg"/></td>  
             <!--<td rowspan="2" class="td-container">-->
             <td colspan="2" style="padding-right: 100px;" ><div class="codbarra">*'.$consecutivo.'*</div></td>
             
             
             
         </tr>
       
       </table> 
       
       <table class="table top">
         <tr>
             <td class="paddin" STYLE="
             padding-bottom: 100px;
         "> 
                 <table class="table-td">
                   <tr>
                   <td colspan="2" class="td-left"><div>AGENTE</div><p>'.$agente.'</p></td>
                   <td  class="td-left"><div>PRODUCTO</div><p>'.$producto.'</p></td>  
                   </tr>    
                 
                   <tr><td colspan="2" class="td-left"><div>ORDEN</div><p>'.$orden.'</p></td>
                     <td  class="td-left"><div>CONSECUTIVO</div><p>'.$consecutivo.'</p></td>
                   </tr>
       
                   <tr><td colspan="2" class="td-left"><div>CUENTA</div><p>'.$cuenta.'</p></td>
                     <td  class="td-left"><div>ID VENTA</div><p>'.$idventa.'</p></td>
                   </tr> 
       
                   <tr><td colspan="2"  class="td-left"><div>CUADRALATURA</div><p>'.$cuadratula.'</p></td>
                     <td   class="td-left"><div>CICLO</div><p>'.$ciclo.'</p></td>
                   </tr>
       
       
       
       
                   <tr><td colspan="2" class="td-left"><div>SUSCRIPTOR</div><p>'.$suscriptor.'</p></td>
                     <td  class="td-left"><div>GRUPO</div><p>'.$grupo.'</p></td>
                   </tr>
       
                   <tr><td colspan="2" class="td-left"><div>SUCURSAL</div><p>'.$sucursal.'</p></td>
                     <td  class="td-left"><div>CEDULA</div><p>'.$cedula.'</p></td>
                   </tr>
       
                   <tr><td colspan="2" class="td-left"><div>LLEGADA FISICO</div><p>'.$f_llegada.'</p></td>
                     <td  class="td-left"><div>FECHA MAX ENTREGA</div><p>'.$f_entrega.'</p></td>
                   </tr>
       
                   <tr><td colspan="2" class="td-left"><div>ESPECIAL1</div><p>'.$especial1.'</p></td>
                   <td  class="td-left"><div>LOTE</div><p>'.$lote.'</p></td>
                 </tr>
       
             
       
       
                  
                 </table>
             </td>
             
             <td class="paddin" style="padding-right: 400;"> 
       
             
       
                 <table class="paddin">
                  <tbody>
                  
                  <tr>
                      
                 <td colspan="2" class=""><div style="font-size:8px;padding-left: 15px;"><b>RESULTADO DE LA VISITA</b></div></td>
                  </tr>
                         
       
                  <tr>
       
                  <td class="td-inferior">EFECTIVO</td>
                  <td class="td-left"><span class="" style="
                      padding: 0px 8px;
                      "></span></td>  
                 </tr>  
       
                 <tr>
       
                  <td class="td-inferior">NO EFECTIVO</td>
                  <td class="td-left"><span class="" style="
                      padding: 0px 8px;
                      "></span></td>  
                 </tr>  
       
               
                     <tr> 
                          <td class="td-inferior">FIRMA RECIBIDO</td>
                     </tr>
       
       
                     <tr>
       
                 
                     <td class="td-inferior"><span class="" style="margin-left: 0px;
                     padding: 10px 70px; 
                     border: 1px solid;
                         "></span></td>  
                    </tr> 
       
                    <tr> 
                    <td class="td-inferior">FECHA GESTION</td>
                  </tr>
                  
                  <tr>
                  <td class="td-inferior"><span class="" style="margin-left: 0px;
                  padding: 10px 70px;
                  border: 1px solid;
                      "></span></td>  
                 </tr> 
                                
                   
                     <tr>  
       
                        <td colspan="2" class=""><div style="font-size:8px;padding-left: 15px;padding-top: 7px;"><b>ANOMALIA</b></div></td>
       
                     </tr>
                                             
                     
       
                      <tr>
                             <td class="td-inferior">DIRECCION ERRADA </td>
                             <td class="td-left"><span class="" style="
                                 padding: 0px 8px;
                                 "></span></td>  
                     </tr>  
       
       
                     <tr>
       
                     <td class="td-inferior"> DIRECCION IMCOMPLETA </td>
                     <td class="td-left"><span class="" style="
                         padding: 0px 8px;
                         "></span></td>  
                    </tr>  
                    
                    <tr>
       
                     <td class="td-inferior">DESTINATARIO DESCONOCIDO</td>
                     <td class="td-left"><span class="" style="
                         padding: 0px 8px;
                         "></span></td>  
                    </tr>  
                    
                    <tr>
       
                    <td class="td-inferior">REHUSADO</td>
                    <td class="td-left"><span class="" style="
                        padding: 0px 8px;
                        "></span></td>  
                   </tr>  
       
                   <tr>
       
                    <td class="td-inferior">NO REHUSADO</td>
                    <td class="td-left"><span class="" style="
                        padding: 0px 8px;
                        "></span></td>  
                   </tr>  
       
                   <tr>
       
                   <td class="td-inferior">NO RESIDE</td>
                   <td class="td-left"><span class="" style="
                       padding: 0px 8px;
                       "></span></td>  
                  </tr>  
       
       
                  <tr>
       
                  <td class="td-inferior">NHQR</td>
                  <td class="td-left"><span class="" style="
                      padding: 0px 8px;
                      "></span></td>  
                 </tr>  
       
       
                </tbody></table>
       
             </td> 
         </tr>
       </table>
       
       
       
         
         </td><!--final primera cela-->
       
       
         
        ';


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
           else if(($i%6)==5){ 
          
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
     
           
         
           $tbl.=' <tr nobr="true"> ';
  
           $tbl.=' 
    
      
           <td>
            
           <table class="table">
           <tr>
               <td rowspan="2" class="td-img"><img  src="LECTA.jpg"/></td>  
               <!--<td rowspan="2" class="td-container">-->
               <td colspan="2" style="padding-right: 100px;" ><div class="codbarra">*'.$consecutivo.'*</div></td>
               
               
               
           </tr>
         
         </table> 
         
         <table class="table top">
           <tr>
               <td class="paddin" STYLE="
               padding-bottom: 100px;
           "> 
                   <table class="table-td">
                     <tr>
                     <td colspan="2" class="td-left"><div>AGENTE</div><p>'.$agente.'</p></td>
                     <td  class="td-left"><div>PRODUCTO</div><p>'.$producto.'</p></td>  
                     </tr>    
                   
                     <tr><td colspan="2" class="td-left"><div>ORDEN</div><p>'.$orden.'</p></td>
                       <td  class="td-left"><div>CONSECUTIVO</div><p>'.$consecutivo.'</p></td>
                     </tr>
         
                     <tr><td colspan="2" class="td-left"><div>CUENTA</div><p>'.$cuenta.'</p></td>
                       <td  class="td-left"><div>ID VENTA</div><p>'.$idventa.'</p></td>
                     </tr> 
         
                     <tr><td colspan="2"  class="td-left"><div>CUADRALATURA</div><p>'.$cuadratula.'</p></td>
                       <td   class="td-left"><div>CICLO</div><p>'.$ciclo.'</p></td>
                     </tr>
         
         
         
         
                     <tr><td colspan="2" class="td-left"><div>SUSCRIPTOR</div><p>'.$suscriptor.'</p></td>
                       <td  class="td-left"><div>GRUPO</div><p>'.$grupo.'</p></td>
                     </tr>
         
                     <tr><td colspan="2" class="td-left"><div>SUCURSAL</div><p>'.$sucursal.'</p></td>
                       <td  class="td-left"><div>CEDULA</div><p>'.$cedula.'</p></td>
                     </tr>
         
                     <tr><td colspan="2" class="td-left"><div>LLEGADA FISICO</div><p>'.$f_llegada.'</p></td>
                       <td  class="td-left"><div>FECHA MAX ENTREGA</div><p>'.$f_entrega.'</p></td>
                     </tr>
         
                     <tr><td colspan="2" class="td-left"><div>ESPECIAL1</div><p>'.$especial1.'</p></td>
                     <td  class="td-left"><div>LOTE</div><p>'.$lote.'</p></td>
                   </tr>
         
               
         
         
                    
                   </table>
               </td>
               
               <td class="paddin" style="padding-right: 400;"> 
         
               
         
                   <table class="paddin">
                    <tbody>
                    
                    <tr>
                        
                   <td colspan="2" class=""><div style="font-size:8px;padding-left: 15px;"><b>RESULTADO DE LA VISITA</b></div></td>
                    </tr>
                           
         
                    <tr>
         
                    <td class="td-inferior">EFECTIVO</td>
                    <td class="td-left"><span class="" style="
                        padding: 0px 8px;
                        "></span></td>  
                   </tr>  
         
                   <tr>
         
                    <td class="td-inferior">NO EFECTIVO</td>
                    <td class="td-left"><span class="" style="
                        padding: 0px 8px;
                        "></span></td>  
                   </tr>  
         
                 
                       <tr> 
                            <td class="td-inferior">FIRMA RECIBIDO</td>
                       </tr>
         
         
                       <tr>
         
                   
                       <td class="td-inferior"><span class="" style="margin-left: 0px;
                       padding: 10px 70px; 
                       border: 1px solid;
                           "></span></td>  
                      </tr> 
         
                      <tr> 
                      <td class="td-inferior">FECHA GESTION</td>
                    </tr>
                    
                    <tr>
                    <td class="td-inferior"><span class="" style="margin-left: 0px;
                    padding: 10px 70px;
                    border: 1px solid;
                        "></span></td>  
                   </tr> 
                                  
                     
                       <tr>  
         
                          <td colspan="2" class=""><div style="font-size:8px;padding-left: 15px;padding-top: 7px;"><b>ANOMALIA</b></div></td>
         
                       </tr>
                                               
                       
         
                        <tr>
                               <td class="td-inferior">DIRECCION ERRADA </td>
                               <td class="td-left"><span class="" style="
                                   padding: 0px 8px;
                                   "></span></td>  
                       </tr>  
         
         
                       <tr>
         
                       <td class="td-inferior"> DIRECCION IMCOMPLETA </td>
                       <td class="td-left"><span class="" style="
                           padding: 0px 8px;
                           "></span></td>  
                      </tr>  
                      
                      <tr>
         
                       <td class="td-inferior">DESTINATARIO DESCONOCIDO</td>
                       <td class="td-left"><span class="" style="
                           padding: 0px 8px;
                           "></span></td>  
                      </tr>  
                      
                      <tr>
         
                      <td class="td-inferior">REHUSADO</td>
                      <td class="td-left"><span class="" style="
                          padding: 0px 8px;
                          "></span></td>  
                     </tr>  
         
                     <tr>
         
                      <td class="td-inferior">NO REHUSADO</td>
                      <td class="td-left"><span class="" style="
                          padding: 0px 8px;
                          "></span></td>  
                     </tr>  
         
                     <tr>
         
                     <td class="td-inferior">NO RESIDE</td>
                     <td class="td-left"><span class="" style="
                         padding: 0px 8px;
                         "></span></td>  
                    </tr>  
         
         
                    <tr>
         
                    <td class="td-inferior">NHQR</td>
                    <td class="td-left"><span class="" style="
                        padding: 0px 8px;
                        "></span></td>  
                   </tr>  
         
         
                  </tbody></table>
         
               </td> 
           </tr>
         </table>
         
         
         
           
           </td><!--final primera cela-->
         
         
           
          ';
            $cons5++;
            
           }
           else{
             $b--;
           }
           $Y1 = $Y1+350;//3
           
         }
  
          //****************************************************************************************************** */
        
        
        else if(($i%6)==0){   
        
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
   
     
      <td>
       
      <table class="table">
      <tr>
          <td rowspan="2" class="td-img"><img  src="LECTA.jpg"/></td>  
          <!--<td rowspan="2" class="td-container">-->
          <td colspan="2" style="padding-right: 100px;" ><div class="codbarra">*'.$consecutivo.'*</div></td>
          
          
          
      </tr>
    
    </table> 
    
    <table class="table top">
      <tr>
          <td class="paddin" STYLE="
          padding-bottom: 100px;
      "> 
              <table class="table-td">
                <tr>
                <td colspan="2" class="td-left"><div>AGENTE</div><p>'.$agente.'</p></td>
                <td  class="td-left"><div>PRODUCTO</div><p>'.$producto.'</p></td>  
                </tr>    
              
                <tr><td colspan="2" class="td-left"><div>ORDEN</div><p>'.$orden.'</p></td>
                  <td  class="td-left"><div>CONSECUTIVO</div><p>'.$consecutivo.'</p></td>
                </tr>
    
                <tr><td colspan="2" class="td-left"><div>CUENTA</div><p>'.$cuenta.'</p></td>
                  <td  class="td-left"><div>ID VENTA</div><p>'.$idventa.'</p></td>
                </tr> 
    
                <tr><td colspan="2"  class="td-left"><div>CUADRALATURA</div><p>'.$cuadratula.'</p></td>
                  <td   class="td-left"><div>CICLO</div><p>'.$ciclo.'</p></td>
                </tr>
    
    
    
    
                <tr><td colspan="2" class="td-left"><div>SUSCRIPTOR</div><p>'.$suscriptor.'</p></td>
                  <td  class="td-left"><div>GRUPO</div><p>'.$grupo.'</p></td>
                </tr>
    
                <tr><td colspan="2" class="td-left"><div>SUCURSAL</div><p>'.$sucursal.'</p></td>
                  <td  class="td-left"><div>CEDULA</div><p>'.$cedula.'</p></td>
                </tr>
    
                <tr><td colspan="2" class="td-left"><div>LLEGADA FISICO</div><p>'.$f_llegada.'</p></td>
                  <td  class="td-left"><div>FECHA MAX ENTREGA</div><p>'.$f_entrega.'</p></td>
                </tr>
    
                <tr><td colspan="2" class="td-left"><div>ESPECIAL1</div><p>'.$especial1.'</p></td>
                <td  class="td-left"><div>LOTE</div><p>'.$lote.'</p></td>
              </tr>
    
          
    
    
               
              </table>
          </td>
          
          <td class="paddin" style="padding-right: 400;"> 
    
          
    
              <table class="paddin">
               <tbody>
               
               <tr>
                   
              <td colspan="2" class=""><div style="font-size:8px;padding-left: 15px;"><b>RESULTADO DE LA VISITA</b></div></td>
               </tr>
                      
    
               <tr>
    
               <td class="td-inferior">EFECTIVO</td>
               <td class="td-left"><span class="" style="
                   padding: 0px 8px;
                   "></span></td>  
              </tr>  
    
              <tr>
    
               <td class="td-inferior">NO EFECTIVO</td>
               <td class="td-left"><span class="" style="
                   padding: 0px 8px;
                   "></span></td>  
              </tr>  
    
            
                  <tr> 
                       <td class="td-inferior">FIRMA RECIBIDO</td>
                  </tr>
    
    
                  <tr>
    
              
                  <td class="td-inferior"><span class="" style="margin-left: 0px;
                  padding: 10px 70px; 
                  border: 1px solid;
                      "></span></td>  
                 </tr> 
    
                 <tr> 
                 <td class="td-inferior">FECHA GESTION</td>
               </tr>
               
               <tr>
               <td class="td-inferior"><span class="" style="margin-left: 0px;
               padding: 10px 70px;
               border: 1px solid;
                   "></span></td>  
              </tr> 
                             
                
                  <tr>  
    
                     <td colspan="2" class=""><div style="font-size:8px;padding-left: 15px;padding-top: 7px;"><b>ANOMALIA</b></div></td>
    
                  </tr>
                                          
                  
    
                   <tr>
                          <td class="td-inferior">DIRECCION ERRADA </td>
                          <td class="td-left"><span class="" style="
                              padding: 0px 8px;
                              "></span></td>  
                  </tr>  
    
    
                  <tr>
    
                  <td class="td-inferior"> DIRECCION IMCOMPLETA </td>
                  <td class="td-left"><span class="" style="
                      padding: 0px 8px;
                      "></span></td>  
                 </tr>  
                 
                 <tr>
    
                  <td class="td-inferior">DESTINATARIO DESCONOCIDO</td>
                  <td class="td-left"><span class="" style="
                      padding: 0px 8px;
                      "></span></td>  
                 </tr>  
                 
                 <tr>
    
                 <td class="td-inferior">REHUSADO</td>
                 <td class="td-left"><span class="" style="
                     padding: 0px 8px;
                     "></span></td>  
                </tr>  
    
                <tr>
    
                 <td class="td-inferior">NO REHUSADO</td>
                 <td class="td-left"><span class="" style="
                     padding: 0px 8px;
                     "></span></td>  
                </tr>  
    
                <tr>
    
                <td class="td-inferior">NO RESIDE</td>
                <td class="td-left"><span class="" style="
                    padding: 0px 8px;
                    "></span></td>  
               </tr>  
    
    
               <tr>
    
               <td class="td-inferior">NHQR</td>
               <td class="td-left"><span class="" style="
                   padding: 0px 8px;
                   "></span></td>  
              </tr>  
    
    
             </tbody></table>
    
          </td> 
      </tr>
    </table>
    
    
    
      
      </td><!--final primera cela-->
    
    
      
     ';
  
     $tbl.='</tr>';

     $tbl.='</table></div>' ;
          
          $cons6++;
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


