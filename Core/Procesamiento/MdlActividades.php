<?php
require_once("Conexion.php");
//include 'Excel/SimpleXLSX.php';

  if( isset($_POST["AnularAct"]) ){
		AnularAct($mysqli);							
	}else if(isset($_POST["GenerarInicio"])){
    Listar($mysqli);
  }else if(isset($_POST["BuscaDetalle"])){
    BuscaDetalle($mysqli);
  }else if(isset($_POST["BuscaActividadCodigoAct"])){
    BuscaActividadCodigoAct($mysqli);
  }else if(isset($_POST["2GenerarInicio"])){
    ListarCLiente($mysqli);
  }else if(isset($_POST["EspecialEnelGenerarInicio"])){
    ListarEspecialEnel($mysqli);
  }else if(isset($_POST["BuscaDetalleEspecialEnel"])){
    BuscaDetalleEspecialEnel($mysqli);
  }else if(isset($_POST["Reasignarparametrobusqueda"])){
    Reasignarparametrobusqueda($mysqli);
  }else if(isset($_POST["DigitaVisitas"])){
    DigitaVisitas($mysqli);
  }else if(isset($_POST["BuscaDetalleEspecialEnelxGuia"])){
    BuscaDetalleEspecialEnelxGuia($mysqli); 
  }else if(isset($_POST["DigitaMasivo"])){
    ActualizarMasivo($mysqli);
  }else if(isset($_POST["CargaAgentesActividad"])){
    CargaAgentesActividad($mysqli);
  }



function ActualizarMasivo($mysqli){


  $fullpath="";
  $swx=0;
  $ruta="gs://lumensarchivostemporales/";
              $nombre ="";
              foreach ($_FILES as $key) {
                if($key['error'] == UPLOAD_ERR_OK ){//Verificamos si se subio correctamente
                $nombre = "MasivoEnel".time();
                $temporal = $key['tmp_name']; //Obtenemos el nombre del archivo temporal
                move_uploaded_file($temporal, $ruta.$nombre); //Movemos el archivo temporal a la ruta especificada 
               //move file
                  if(file_exists($ruta.$nombre)){
                    $swx=1;

                  }
                }


              }
//SI EXISTE LA RUTA
if ($swx==1)
{
      
          include 'Excel/SimpleXLSX.php';
          $xlsx = SimpleXLSX::parse('gs://lumensarchivostemporales/'.$nombre);                                                                                                              
          list($num_cols, $num_rows) = $xlsx->dimension();     
          //list($cols,) = $xlsx->dimension();
          $cont=1;
          $reg_error = '';
          $cont_error = 0;
          $Ok=0;
          $guarda=0;
          $estado='0';
          $time = time();
          $ordenruta="";
          
          $swx=0;
          foreach( $xlsx->rows() as $row ) {
          
          if($cont!=1){//Encabezado       
          
                          
                              //verifica fila por fila en este caso la prima, guia, a saber
                              if($row[0]==""){
                                  $cont_error++;
                                  $reg_error .= '<span>* Error Fila Nº '.$cont.' No Cuenta con consecutivo.</span></br>';
                                  $guarda++;
                              }
                              

                              if($row[8]==""){
                                  $cont_error++;
                                  $reg_error .= '<span>* Error Fila Nº '.$cont.' No Cuenta con anomalía.</span></br>';
                                  $guarda++;
                              }

                              if (   $row[8]!=='EFECTIVA' and
                                    $row[8]!=='SIN NOMENCLATURA' and
                                    $row[8]!=='SIN NOMENCLATURA' and
                                    $row[8]!=='DIFICIL LOCALIZACION'and
                                    $row[8]!=='DOBLE FACTURACION' and
                                    $row[8]!=='ERROR EN DIRECCION' and
                                    $row[8]!=='PREDIO DEMOLIDO'  and
                                    $row[8]!=='PREDIO ABANDONADO' and
                                    $row[8]!=='ACCESO DENEGADO' and
                                    $row[8]!=='LOTE VACIO' and
                                    $row[8]!=='APARTADO AEREO' and
                                    $row[8]!=='FUERA DE CICLO O ZONA' and
                                    $row[8]!=='PERRO BRAVO' and
                                    $row[8]!=='ZONA PELIGROSA' and
                                    $row[8]!=='AISLAMIENTO PREVENTIVO' ) {
                                $cont_error++;
                                $reg_error .= '<span>* Error Fila Nº '.$cont.' La celda anomalía no coincide con el conjunto de estas.</span></br>';
                                $guarda++;    

                              }
                            

                              if($row[9]==""){
                                  $cont_error++;
                                  $reg_error .= '<span>* Error Fila Nº '.$cont.' No Cuenta con estado.</span></br>';
                                  $guarda++;
                              } 

                              if ( $row[9]!=='EFECTIVO' and
                                   $row[9]!=='NO EFECTIVO') {
                                $cont_error++;
                                $reg_error .= '<span>* Error Fila Nº '.$cont.' La celda estado no coincide con el conjunto de estos.</span></br>';
                                $guarda++;       

                              }
                               

                              if($row[10]==""){
                                  $cont_error++;
                                  $reg_error .= '<span>* Error Fila Nº '.$cont.' No Cuenta con fecha estado.</span></br>';
                                  $guarda++;
                              }
                              
                              
                       
          
          }//End encabezado
          $cont++;
          
          }//End foreach  
          
          
          //Si no hay ningun error procedemos a guardar
          if($guarda==0){
                          
                          
                          
                          $inseR=1;
                          
                               foreach( $xlsx->rows() as $row ) {
                                      
                                      
                                      if($inseR!=1){
                                       
                                         
                          
               
                  $b1="SELECT estado,codactividad,codagente FROM proyectoespecialenel  WHERE guia='".mysqli_real_escape_string($mysqli,$row[0])."'  ";
                  $s1=mysqli_query($mysqli,$b1);
                  if($r1=mysqli_fetch_row($s1)){


                               if(strtoupper($r1[0])!="PENDIENTE"){
                                                  
                                                  
                                                          $c1="UPDATE proyectoespecialenel SET 
                                                          telefono='".mysqli_real_escape_string($mysqli,$row[1])."',
                                                          medidor='".mysqli_real_escape_string($mysqli,$row[2])."', 
                                                          posicionmedidor='".mysqli_real_escape_string($mysqli,$row[3])."', 
                                                          lectura='".mysqli_real_escape_string($mysqli,$row[4])."',
                                                          quienrecibe='".mysqli_real_escape_string($mysqli, strtoupper($row[5]))."',
                                                          direccioncorrecta='".mysqli_real_escape_string($mysqli,strtoupper($row[6]))."',
                                                          observaciones='".mysqli_real_escape_string($mysqli,strtoupper($row[7]))."',
                                                          anomalia='".mysqli_real_escape_string($mysqli,strtoupper($row[8]))."',
                                                          estado = '".mysqli_real_escape_string($mysqli,strtoupper($row[9]))."',
                                                          fechahoraregistro= now(),
                                                          fechaestado= '".mysqli_real_escape_string($mysqli,$row[10])."',
                                                          fecharealizado=curdate(),
                                                          fechahorarealizado=now()
                                                          WHERE guia= '".mysqli_real_escape_string($mysqli,$row[0])."' ";  
                                                          
                                                          if($d1=mysqli_query($mysqli,$c1)){

                                                                            if(strtoupper($row[9])!="EFECTIVO"){
                                                                            $c3="UPDATE actividad SET noefectivos=noefectivos+1 WHERE 
                                                                            cons='".mysqli_real_escape_string($mysqli,$r1[1])."' "; 
                                                                            }else{
                                                                            $c3="UPDATE actividad SET efectivos=efectivos+1 WHERE 
                                                                            cons='".mysqli_real_escape_string($mysqli,$r1[1])."' "; 
                                                                            }
                                                                            $d3=mysqli_query($mysqli,$c3);

                                                                $Ok++;
                                                          }else{  
                                                                $cont_error++;
                                                                $reg_error.='<span>* Error Fila Nº '.$inseR.' No se pudo guardar el registro,verifique los datos.</span></br>';
                                                          } 


                                    }else{  
                                            $cont_error++;
                                            $reg_error.='<span>* Error Fila Nº '.$inseR.', No se pudo guardar el registro, estado: '.$r1[0].'.</span></br>';
                                    } 

                                                   
                }else{  
                        $cont_error++;
                        $reg_error.='<span>* Error Fila Nº '.$inseR.', Registro '.$row[0].' no encontrado .</span></br>';
                } 
                                                   

                                                   
                                           

                                      }//End encabezado
                                      
                                      $inseR++;
                                      
                                      }//End foreach
                                      
                                     
                       
                      } // end guarda==0
                      
                      $array=array(); 
                      
                      if(($cont-1)!=1){
                      
                      $Regis=$num_rows-1;
                      $array['validacion']='OK';
                      $array['icono']='success';  
                      
                      $mensaje="Se validaron ".($Ok)." Registros de ".$Regis." filas".PHP_EOL."Registros actualizados correctamente."; 
                      
                      
                      if($cont_error!=0){
                      
                          $mensaje="No se puede procesar,  errores encontrados ".$cont_error.".
                                          Revise detalles de validación.";
                          $detalleerror=$reg_error; 
                          $array['icono']='error';
                          $array['detalleerror']=$detalleerror;
                      }
                      
                      $array['Mensaje']=$mensaje;
                      
                      
                      }else{
                      $array['validacion']="Error";
                      $array['Mensaje']="No se encontró ningun registro, verifique el archivo";
                      }
                                   
                      header('Content-type: application/json');
                      mb_convert_encoding($array, 'UTF-8', 'UTF-8');         
                      echo json_encode($array);
                      //unlink('gs://lumensarchivostemporales/'.$nombre);
  
} else { echo "No existe la ruta del archivo";}

}
//---------------------------------------------------------------------------------------------------------------------------------------------







function  DigitaVisitas($mysqli){

 
    $Busqueda="SELECT estado,codactividad,codagente FROM proyectoespecialenel  WHERE cons='".mysqli_real_escape_string($mysqli,$_POST["DigitaVisitas"])."'  ";
    $responseArray = array();
    $sql=mysqli_query($mysqli,$Busqueda);
    if($row=mysqli_fetch_row($sql)){

    if($row[0]=="Pendiente"){


      $consulta="UPDATE proyectoespecialenel SET 
      fechaestado='".mysqli_real_escape_string($mysqli,$_POST["Digitafecharealizado"])."',
      fecharealizado=curdate(),
      fechahorarealizado=now(),
      telefono='".mysqli_real_escape_string($mysqli,$_POST["Digitatelefono"])."',
      medidor='".mysqli_real_escape_string($mysqli,$_POST["Digitamedidor"])."',
      posicionmedidor='".mysqli_real_escape_string($mysqli,$_POST["DigitaPosicionmedidor"])."',
      lectura='".mysqli_real_escape_string($mysqli,$_POST["Digitalectura"])."',
      quienrecibe='".mysqli_real_escape_string($mysqli,$_POST["Digitaquienrecibe"])."',
      direccioncorrecta='".mysqli_real_escape_string($mysqli,$_POST["Digitadireccioncorrecta"])."',
      observaciones='".mysqli_real_escape_string($mysqli,$_POST["Digitadireccioncorrecta"])."',
      anomalia='".mysqli_real_escape_string($mysqli,$_POST["Digitaanomalia"])."', 
      fechahoraregistro=now(),
      estado='".mysqli_real_escape_string($mysqli,$_POST["Digitaestado"])."'
      WHERE cons='".mysqli_real_escape_string($mysqli,$_POST["DigitaVisitas"])."' "; 

      if( $datos=mysqli_query($mysqli,$consulta) ){ 

              $swx=0;
              $ruta="gs://lumensarchivostemporales/Soportes/";
              $nombre ="";
              foreach ($_FILES as $key) {
                if($key['error'] == UPLOAD_ERR_OK ){//Verificamos si se subio correctamente
                $nombre = $_POST["DigitaVisitas"]."-EspecialEnel-Guia.png";
                $temporal = $key['tmp_name']; //Obtenemos el nombre del archivo temporal
                move_uploaded_file($temporal, $ruta.$nombre); //Movemos el archivo temporal a la ruta especificada  
                  if(file_exists($ruta.$nombre)){
                    $swx=1;
                  }
                }
              }

              if($swx==1){

       $consulta="UPDATE proyectoespecialenel SET  
       fotoguiafecha=now(),
        fotoguia='".$nombre."'
      WHERE cons='".mysqli_real_escape_string($mysqli,$_POST["DigitaVisitas"])."' ";
              }

            if($_POST["estado"]!="EFECTIVO"){
              $consulta="UPDATE actividad SET noefectivos=noefectivos+1 WHERE 
              cons='".mysqli_real_escape_string($mysqli,$row[1])."' "; 
            }else{
              $consulta="UPDATE actividad SET efectivos=efectivos+1 WHERE 
              cons='".mysqli_real_escape_string($mysqli,$row[1])."' "; 
            }

            if( $datos=mysqli_query($mysqli,$consulta) ){ 
 
 
           echo "Registro Actualizado"; 





            }else{
                  echo "No Incrementado"; 
              }




      }else{ 
          echo "No Guardado"; 
        }

    }else{
        echo "Ya Gestionado"; 
      }
  }else{
       echo "No Existe"; 
    }
}






function  BuscaDetalleEspecialEnelxGuia($mysqli){
    $arreglo= array();
    $consulta="SELECT  a.nombre,p.producto,p.orden,p.guia,p.cuenta,p.idventa,p.direccion,p.cuadratula ,p.ciclo,p.suscriptor,p.grupo,p.sucursal,p.supervisor,p.telefono,p.medidor,p.lectura,p.quienrecibe,p.direccioncorrecta,p.observaciones,p.anomalia,p.estado,p.fecharealizado,p.latitud,p.longitud,p.fotomedidor,p.fotoguia,p.fotopredio,p.cons,p.fecha_llegada_fisico,p.fecha_max_entrega,p.documento,p.especial1,p.posicionmedidor FROM ((proyectoespecialenel p INNER JOIN actividad ac ON ac.cons=p.codactividad) LEFT JOIN agentes a ON a.usuario=p.codagente)
WHERE  p.guia='".mysqli_real_escape_string($mysqli,$_POST["BuscaDetalleEspecialEnelxGuia"])."'  ";
      $datos=mysqli_query($mysqli,$consulta);
      if($row=mysqli_fetch_array($datos)){
        $arreglo[]=$row;
        echo json_encode($arreglo);
      }else{
        echo "n";
      }
}


function  CargaAgentesActividad($mysqli){
    $arreglo= array();
    $consulta="SELECT DISTINCT a.usuario,a.nombre FROM proyectoespecialenel p INNER JOIN agentes a ON a.usuario=p.codagente  
WHERE  p.codactividad='".mysqli_real_escape_string($mysqli,$_POST["CargaAgentesActividad"])."'  ";
      $datos=mysqli_query($mysqli,$consulta);
      echo '<select id="AgenteListado" name="AgenteListado" class="form-control">
      <option  selected="selected" value=""> Seleccionar... </option>  ';
      while($row=mysqli_fetch_array($datos)){
            echo '<option   value="'.$row[0].'">'.$row[1].'</option>';   
      } 
      echo    '    </select> '; 
}


function  Reasignarparametrobusqueda($mysqli){
    $array= array();
      $consulta="SELECT codagente,cons,estado FROM proyectoespecialenel WHERE guia='".mysqli_real_escape_string($mysqli,$_POST["Reasignarparametrobusqueda"])."' ORDER BY cons DESC LIMIT 1 ";
      $datos=mysqli_query($mysqli,$consulta);
      if($row=mysqli_fetch_array($datos)){



	      	if($row[2]=="Pendiente"){ 

			      	if($_POST["ReasignarAgente"]!=$row[0]){  

							 $consulta="UPDATE proyectoespecialenel SET  
							 codagente='".mysqli_real_escape_string($mysqli,$_POST["ReasignarAgente"])."',
								reasignadofecha=now(),
							 reasignadousuario='".mysqli_real_escape_string($mysqli,$_POST["ReasignarUsuario"])."'

							  WHERE cons='".$row[1]."'  ";
							if( $datos=mysqli_query($mysqli,$consulta)){ 
							echo "OK";
							}else{
echo "Guia ".$_POST["Reasignarparametrobusqueda"]." no se pudo reasignar";
							}
				      	}else{
						echo"Guia ".$_POST["Reasignarparametrobusqueda"]." ya estaba asignado a este agente";
			      		} 
  			}else{
				echo "Guia ".$_POST["Reasignarparametrobusqueda"]." esta en estado ".$row[2];
	      	} 



	      	
      }else{
				echo"Numero de guia ".$_POST["Reasignarparametrobusqueda"]." no encontrado";
      }
 
}



function  BuscaDetalleEspecialEnel($mysqli){
    $arreglo= array();
    $consulta="SELECT  a.nombre,p.producto,p.orden,p.guia,p.cuenta,p.idventa,p.direccion,p.cuadratula ,p.ciclo,p.suscriptor,p.grupo,p.sucursal,p.supervisor,p.telefono,p.medidor,p.lectura,p.quienrecibe,p.direccioncorrecta,p.observaciones,p.anomalia,p.estado,p.fecharealizado,p.latitud,p.longitud,p.fotomedidor,p.fotoguia,p.fotopredio,p.fecha_llegada_fisico,p.fecha_max_entrega,p.documento,p.especial1,p.lote,p.posicionmedidor FROM 
((proyectoespecialenel p INNER JOIN actividad ac ON ac.cons=p.codactividad) LEFT JOIN agentes a ON a.usuario=p.codagente)
WHERE  p.cons='".mysqli_real_escape_string($mysqli,$_POST["BuscaDetalleEspecialEnel"])."'  ";
      $datos=mysqli_query($mysqli,$consulta);
      if($row=mysqli_fetch_array($datos)){
        $arreglo[]=$row;
        echo json_encode($arreglo);
      }else{
        echo "n";
      }
}



function ListarEspecialEnel($mysqli){

$completa="";

 


     $consulta="SELECT cons,fecha,tipo,soporte,usuariocarga,estado,cantidad,efectivos,noefectivos,usuariocarga FROM actividad WHERE 
     fecha>='".mysqli_real_escape_string($mysqli,$_POST["EspecialEnelGenerarInicio"])."' AND 
     fecha<='".mysqli_real_escape_string($mysqli,$_POST["EspecialEnelGenerarFinal"])."'   and proyecto='Especial Enel'  ORDER BY fecha desc,cons desc  "; 


$datos=mysqli_query($mysqli,$consulta);

         echo '
         <h3 class="title1" >Resultados</h3>
         <table id="example" class="display dataTable" cellspacing="0" width="100%" style="font-size: 12px; width: 100%;text-align:center;margin-top: 20px !important" role="grid" aria-describedby="example_info">
        <thead>
          <tr>
          <th  width="10">Cons</th>
          <th  width="10">Codigo</th>
          <th  >Jornada</th> 
          <th width="10">Usuario</th>
          <th width="10">Estado</th>
          <th width="10">Cantidad</th>
          <th  width="10">Efectivos</th>
          <th  width="10">No Efectivos</th>          
          <th  width="10">Realizados</th>       
          <th  width="10">Pendientes</th>   
          <th width="">Opciones</th></tr></tr>
        </thead><tfoot>
          <tr>
          <th >Cons</th>
          <th >Codigo</th>
          <th >Jornada</th> 
          <th >Usuario</th>
          <th >Estado</th>
          <th >Cantidad</th>
          <th >Efectivos</th>
          <th >No Efectivos</th>          
          <th >Realizados</th>       
          <th >Pendientes</th>   
          <th width="">Opciones</th></tr>
        </tfoot>  <tbody> ';
$cont=1;
       
          if(mysqli_num_rows($datos)>0){           
while($row=mysqli_fetch_row($datos)){ 

$st='style="background-color:#19FF5A; color:#fff;"';
$btn='';
              if($row[5]=='Anulado'){
                $st='style="background-color:#FF9500; color:#fff;"';
              }else{

                if($_POST["EspecialEnelGenerarUsr"]==$row[9]){
$btn='<button type="button" class="btn btn-warning btn-circle" style="background-color:orange;padding:7px !important" onclick="AnularAct('.$row[0].');"><i class="fa fa-minus"></i></button>';
                }
              }


              
             echo '<tr role="row" class="odd">
            <td  >'.$cont.'</td>
            <td  >'.$row[0].'</td>
            <td  >'.$row[1].'</td> 
            <td  >'.$row[4].'</td>
            <td  '.$st.' >'.$row[5].'</td>
            <td  >'.$row[6].'</td>
            <td  >'.$row[7].'</td>
            <td  >'.$row[8].'</td>
            <td  >'.($row[8]+$row[7]).'</td>
            <td  >'.($row[6]-($row[8]+$row[7])).'</td>
            <td  align="left">
            <button type="button" class="btn btn-info btn-circle" style="background-color:blue;padding:7px !important" onclick="DetallarActividad('.$row[0].');"><i class="fa fa-search "></i></button>
            <button type="button" class="btn btn-info btn-circle" style="background-color:#E64A19;padding:7px !important" onclick="AbrirPlanillas('.$row[0].');"><i class="fa fa-file-text-o"></i></button>
            <button type="button" style="background-color:green;padding:7px !important" class="btn btn-success btn-circle" onclick="DescargarDetallado('.$row[0].');"><i class="fa fa-download"></i></button>
            <button type="button" class="btn btn-info btn-circle" style="background-color:blueviolet;padding:7px !important" onclick="Impresion('.$row[0].');"><i class="fa fa-envelope-o "></i></button>
            '.$btn.'
            </td>
          </tr>';

$cont++;
            }
            
          }

          echo '</tbody></table>';

}


function ListarCLiente($mysqli){

$completa="";


if($_POST["2GenerarTipoB"]!=""){
$completa="  AND tipo='".mysqli_real_escape_string($mysqli,$_POST["2GenerarTipoB"])."' ";
}


if($_POST["2GenerarSoporteB"]!=""){
$completa.="  AND soporte='".mysqli_real_escape_string($mysqli,$_POST["2GenerarSoporteB"])."' ";
}


     $consulta="SELECT codactividad,fecha,tipo,soporte,usuariocarga,estado,cantidad,efectivos,noefectivos,usuariocarga FROM actividadclientes WHERE 
     fecha>='".mysqli_real_escape_string($mysqli,$_POST["2GenerarInicio"])."' AND 
     fecha<='".mysqli_real_escape_string($mysqli,$_POST["2GenerarFinal"])."' AND 
     codempresa='".mysqli_real_escape_string($mysqli,$_POST["2GenerarCode"])."' AND 
     codcliente='".mysqli_real_escape_string($mysqli,$_POST["2GenerarCodCl"])."' ".$completa." ORDER BY fecha desc,codactividad desc  "; 


$datos=mysqli_query($mysqli,$consulta);

         echo '
         <h3 class="title1" >Resultados</h3>
         <table id="example" class="display dataTable" cellspacing="0" width="100%" style="font-size: 12px; width: 100%;text-align:center;margin-top: 20px !important" role="grid" aria-describedby="example_info">
        <thead>
          <tr>
          <th  width="10">Cons</th>
          <th  width="10">Codigo</th>
          <th  >Jornada</th>
          <th >Tipo</th>
          <th >Soporte</th>
          <th width="10">Usuario</th>
          <th width="10">Estado</th>
          <th width="10">Cantidad</th>
          <th  width="10">Efectivos</th>
          <th  width="10">No Efectivos</th>          
          <th  width="10">Realizados</th>       
          <th  width="10">Pendientes</th>   
          <th width="">Opciones</th></tr></tr>
        </thead><tfoot>
          <tr>
          <th >Cons</th>
          <th >Codigo</th>
          <th >Jornada</th>
          <th >Tipo</th>
          <th >Soporte</th>
          <th >Usuario</th>
          <th >Estado</th>
          <th >Cantidad</th>
          <th >Efectivos</th>
          <th >No Efectivos</th>          
          <th >Realizados</th>       
          <th >Pendientes</th>   
          <th width="">Opciones</th></tr>
        </tfoot>  <tbody> ';
$cont=1;
       
          if(mysqli_num_rows($datos)>0){           
while($row=mysqli_fetch_row($datos)){ 

$st='style="background-color:#19FF5A; color:#fff;"';
$btn='';
              if($row[5]=='Anulado'){
                $st='style="background-color:#FF9500; color:#fff;"';
              }else{

              }


              
             echo '<tr role="row" class="odd">
            <td  >'.$cont.'</td>
            <td  >'.$row[0].'</td>
            <td  >'.$row[1].'</td>
            <td  >'.$row[2].'</td>
            <td  >'.$row[3].'</td>
            <td  >'.$row[4].'</td>
            <td  '.$st.' >'.$row[5].'</td>
            <td  >'.$row[6].'</td>
            <td  >'.$row[7].'</td>
            <td  >'.$row[8].'</td>
            <td  >'.($row[8]+$row[7]).'</td>
            <td  >'.($row[6]-($row[8]+$row[7])).'</td>
            <td  width="90" align="left">
            <button type="button" class="btn btn-info btn-circle" style="background-color:blue;padding:7px !important" onclick="DetallarActividad('.$row[0].');"><i class="fa fa-search "></i></button>
            <button type="button" style="background-color:green;padding:7px !important" class="btn btn-success btn-circle" onclick="DescargarDetallado('.$row[0].');"><i class="fa fa-download"></i></button>
            '.$btn.'
            </td>
          </tr>';

$cont++;
            }
            
          }

          echo '</tbody></table>';

}




function  BuscaActividadCodigoAct ($mysqli){
      $arreglo= array();
         $consulta="SELECT fecha,tipo,soporte,Observaciones FROM actividad
        where  cons='".mysqli_real_escape_string($mysqli,$_POST["BuscaActividadCodigoAct"])."' and  
        codempresa='".mysqli_real_escape_string($mysqli,$_POST["BuscaActividadCode"])."' ";
      $datos=mysqli_query($mysqli,$consulta);
      if($row=mysqli_fetch_array($datos)){
        $arreglo[]=$row;
        echo json_encode($arreglo);
      }else{
        echo "n";
      }
}

function  BuscaDetalle($mysqli){
     $arreglo= array();
        $consulta="SELECT ac.tipo,ac.soporte,a.observaciones,p.destinatario,p.direccion,c.nombre,d.nombre,p.cliente,p.referencia1,p.referencia2,p.referencia3,p.referencia4,p.referencia5,p.ruta,p.ordenamiento,a.nombre,p.estado,p.fecharealizado,p.respuesta,p.detallerespuesta,p.resultado1,p.resultado2,p.platitud,p.plongitud,p.soporte,p.observaciones  FROM 
((((principal p INNER JOIN actividad ac ON ac.cons=p.codactividad) INNER JOIN ciudades c ON c.cons=p.codciudad)INNER JOIN departamentos d ON d.cons=p.coddepartamento)INNER JOIN agentes a ON a.usuario=p.codagente)
where  p.cons='".mysqli_real_escape_string($mysqli,$_POST["BuscaDetalle"])."'  ";
      $datos=mysqli_query($mysqli,$consulta);
      if($row=mysqli_fetch_array($datos)){
        $arreglo[]=$row;
        echo json_encode($arreglo);
      }else{
        echo "n";
      }
}


function  AnularAct($mysqli){
      $consulta=" UPDATE actividad SET 
      estado='Anulado',fechaanulado=now()
      WHERE cons='".mysqli_real_escape_string($mysqli,strtoupper($_POST["AnularAct"]))."' ";            
          if( $datos=mysqli_query($mysqli,$consulta) ){ 
            echo 'OK';
          }else{
            echo 'No';
          }
}

function Listar($mysqli){

$completa="";


if($_POST["GenerarTipoB"]!=""){
$completa="  AND tipo='".mysqli_real_escape_string($mysqli,$_POST["GenerarTipoB"])."' ";
}


if($_POST["GenerarSoporteB"]!=""){
$completa.="  AND soporte='".mysqli_real_escape_string($mysqli,$_POST["GenerarSoporteB"])."' ";
}


     $consulta="SELECT cons,fecha,tipo,soporte,usuariocarga,estado,cantidad,efectivos,noefectivos,usuariocarga FROM actividad WHERE 
     fecha>='".mysqli_real_escape_string($mysqli,$_POST["GenerarInicio"])."' AND 
     fecha<='".mysqli_real_escape_string($mysqli,$_POST["GenerarFinal"])."' and proyecto='Generico' ".$completa." ORDER BY fecha desc,cons desc  "; 


$datos=mysqli_query($mysqli,$consulta);

         echo '
         <h3 class="title1" >Resultados</h3>
         <table id="example" class="display dataTable" cellspacing="0" width="100%" style="font-size: 12px; width: 100%;text-align:center;margin-top: 20px !important" role="grid" aria-describedby="example_info">
        <thead>
          <tr>
          <th  width="10">Cons</th>
          <th  width="10">Codigo</th>
          <th  >Jornada</th>
          <th >Tipo</th>
          <th >Soporte</th>
          <th width="10">Usuario</th>
          <th width="10">Estado</th>
          <th width="10">Cantidad</th>
          <th  width="10">Efectivos</th>
          <th  width="10">No Efectivos</th>          
          <th  width="10">Realizados</th>       
          <th  width="10">Pendientes</th>   
          <th width="">Opciones</th></tr></tr>
        </thead><tfoot>
          <tr>
          <th >Cons</th>
          <th >Codigo</th>
          <th >Jornada</th>
          <th >Tipo</th>
          <th >Soporte</th>
          <th >Usuario</th>
          <th >Estado</th>
          <th >Cantidad</th>
          <th >Efectivos</th>
          <th >No Efectivos</th>          
          <th >Realizados</th>       
          <th >Pendientes</th>   
          <th width="">Opciones</th></tr>
        </tfoot>  <tbody> ';
$cont=1;
       
          if(mysqli_num_rows($datos)>0){           
while($row=mysqli_fetch_row($datos)){ 

$st='style="background-color:#19FF5A; color:#fff;"';
$btn='';
              if($row[5]=='Anulado'){
                $st='style="background-color:#FF9500; color:#fff;"';
              }else{

                if($_POST["GenerarUsr"]==$row[9]){
$btn='<button type="button" class="btn btn-warning btn-circle" style="background-color:orange;padding:7px !important" onclick="AnularAct('.$row[0].');"><i class="fa fa-minus"></i></button>';
                }
              }


              
             echo '<tr role="row" class="odd">
            <td  >'.$cont.'</td>
            <td  >'.$row[0].'</td>
            <td  >'.$row[1].'</td>
            <td  >'.$row[2].'</td>
            <td  >'.$row[3].'</td>
            <td  >'.$row[4].'</td>
            <td  '.$st.' >'.$row[5].'</td>
            <td  >'.$row[6].'</td>
            <td  >'.$row[7].'</td>
            <td  >'.$row[8].'</td>
            <td  >'.($row[8]+$row[7]).'</td>
            <td  >'.($row[6]-($row[8]+$row[7])).'</td>
            <td  align="left">
            <button type="button" class="btn btn-info btn-circle" style="background-color:blue;padding:7px !important" onclick="DetallarActividad('.$row[0].');"><i class="fa fa-search "></i></button>
            <button type="button" style="background-color:green;padding:7px !important" class="btn btn-success btn-circle" onclick="DescargarDetallado('.$row[0].');"><i class="fa fa-download"></i></button>
            '.$btn.'
            </td>
          </tr>';

$cont++;
            }
            
          }

          echo '</tbody></table>';

}

mysqli_close($mysqli);
?>