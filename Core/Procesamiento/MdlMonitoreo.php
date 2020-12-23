<?php
session_start();    
require_once("Conexion.php");

  if( isset($_POST["MonitoreoFecha"]) ){
    Monitoreo($mysqli);             
  }elseif (isset($_POST["BusquedaTipo"]) ){
   Busqueda($mysqli);     
  }elseif (isset($_POST["TrazaDispositivo"]) ){
   TrazaDispositivo($mysqli);     
  }elseif (isset($_POST["DetallarAgentes"]) ){
   DetallarAgentes($mysqli);     
  }elseif (isset($_POST["GenerarSeguimientoFecha"]) ){
   ReporteSeguimiento($mysqli);     
  }elseif (isset($_POST["GenerarDesde"]) ){
   GenerarDetallado($mysqli);     
  }elseif (isset($_POST["GenerarParametro"]) ){
   GenerarParametro($mysqli);     
  }



function GenerarParametro($mysqli){      



	$consulta="SELECT p.cons,ag.nombre,p.producto,p.orden,p.guia,p.direccion,p.ciclo,p.cuenta,p.idventa,p.estado FROM ((proyectoespecialenel p 
      INNER JOIN actividad a ON a.cons=p.codactividad) LEFT JOIN agentes ag ON ag.usuario=p.codagente)WHERE 
      p.".$_POST["GenerarFiltro"]."='".mysqli_real_escape_string($mysqli,$_POST["GenerarParametro"])."'    order by p.cons  ";
$datos=mysqli_query($mysqli,$consulta);

         echo '
         <table id="example" class="display dataTable" cellspacing="0" width="100%" style="font-size: 12px; width: 100%;text-align:center;margin-top: 20px !important" role="grid" aria-describedby="example_info">
        <thead>
          <tr>
          <th  width="10">Codigo Visita</th>
          <th >Agente</th>
          <th >Producto</th>
          <th >Orden</th>
          <th >Consecutivo</th>
          <th >Direccion</th>
          <th >Ciclo</th>
          <th >Cuenta</th>
          <th >ID Venta</th>
          <th >Estado</th>
          <th width="20">Opciones</th>
          </tr>

          </tr>
        </thead><tfoot>
          <tr>
          <th  width="10">Codigo Visita</th>
          <th >Agente</th>
          <th >Producto</th>
          <th >Orden</th>
          <th >Consecutivo</th>
          <th >Direccion</th>
          <th >Ciclo</th>
          <th >Cuenta</th>
          <th >ID Venta</th>
          <th >Estado</th>
          <th width="20">Opciones</th>
          </tr>
        </tfoot>  <tbody> ';
$cont=1;
                 
			while($row=mysqli_fetch_row($datos)){ 



	            if($row[9]=='Pendiente'){
	                $st='style="background-color:#FF2C21; color:#fff;"';
	                $estado="Pendiente"; 
				}else{
	                $estado=$row[9];
					 if($row[9]=='EFECTIVO'){ 
		                $st='style="background-color:#00FF2C; color:#fff;"';
		             }else{ 
		                $st='style="background-color:#FF9500; color:#fff;"';
		             }
		        }
$CODD="'".$row[0]."'";

	           if ($row[1]==""){
              	$row[1]="NO ASIGNADO";
              }
		           echo '<tr >
		            <td  >'.$row[0].'</td>
		             <td  >'.$row[1].'</td>
		            <td  >'.$row[2].'</td>
		            <td  >'.$row[3].'</td>
		            <td  >'.$row[4].'</td>
		            <td  >'.$row[5].'</td>
		            <td  >'.$row[6].'</td>
		            <td  >'.$row[7].'</td>
		            <td  >'.$row[8].'</td>
		            <td  '.$st.'>'.$estado.'</td>
		            <td  >
 <button type="button" onclick="detalleRegistro('.$CODD.');" class="btn btn-info" style="background-color:blue;padding:7px !important">
 <i class="fa fa-search "></i></button>

		            </td>
		            </tr>';
					$cont++;
            }
 
       echo '</tbody></table>';

}


function GenerarDetallado($mysqli){      



if ($_POST["GenerarTipoReporte"]=="Preoperacional") { 


       $consulta="SELECT a.nombre,a.usuario,fecha,apto,noapto,obs36,e.cons  FROM enelpreopperacionalmotos e INNER JOIN agentes a ON a.usuario= e.codagente WHERE 
      e.fecha>='".mysqli_real_escape_string($mysqli,$_POST["GenerarDesde"])."' 
      and  e.fecha<='".mysqli_real_escape_string($mysqli,$_POST["GenerarHasta"])."'    order by e.fecha desc,a.nombre asc ";
      $datos=mysqli_query($mysqli,$consulta);

         echo '
         <table id="example" class="display dataTable" cellspacing="0" width="100%" style="font-size: 12px; width: 100%;text-align:center;margin-top: 20px !important" role="grid" aria-describedby="example_info">
        <thead>
          <tr> 
          <th >cons </th>
          <th >Nombre </th>
          <th >Usuario</th>
          <th >Fecha </th>
          <th >Resultado Revision</th>
          <th >Observaciones</th> 
          <th width="20">Opciones</th>
          </tr>

          </tr>
        </thead><tfoot>
          <tr>
          <th >cons </th>
          <th >Nombre </th>
          <th >Usuario</th>
          <th >Fecha </th>
          <th >Resultado Revision</th>
          <th >Observaciones</th> 
          <th width="20">Opciones</th>
          </tr>
        </tfoot>  <tbody> ';
      $cont=1;
                 
      while($row=mysqli_fetch_row($datos)){ 



             
                  $estado="APTO";
                  if($row[3]=='si'){ 
                    $st='style="background-color:#00FF2C; color:#fff;"';
                 }else{ 
             
                  $estado="NO APTO";
                    $st='style="background-color:#FF2C21; color:#fff;"';
                  }
         
                    echo '<tr >
                    <td  >'.$cont.'</td>
                    <td  >'.$row[0].'</td>
                    <td  >'.$row[1].'</td>
                    <td  >'.$row[2].'</td>
                    <td '.$st.' >'.$estado .'</td> 
                    <td  >'.$row[5].'</td>
                <td  >
 <button type="button" onclick="ExportaFromatoEnel('.$row[6].');" class="btn btn-info" style="background-color:blue;padding:7px !important">
 <i class="fa fa-file "></i></button>

                </td>
                </tr>';
          $cont++;
            }
 
       echo '</tbody></table>';

}else{

      if ($_POST["GenerarTipoReporte"]=="Busquedadirecciones") {      

  

  $consulta="SELECT p.cons,ag.nombre,p.producto,p.orden,p.guia,p.direccion,p.ciclo,p.cuenta,p.idventa,p.estado FROM ((proyectoespecialenel p 
      INNER JOIN actividad a ON a.cons=p.codactividad) LEFT JOIN agentes ag ON ag.usuario=p.codagente)WHERE 
      a.fecha>='".mysqli_real_escape_string($mysqli,$_POST["GenerarDesde"])."' 
      and  a.fecha<='".mysqli_real_escape_string($mysqli,$_POST["GenerarHasta"])."' AND  (p.direccion!=p.direccioncorrecta AND p.direccioncorrecta  IS NOT NULL AND NOT p.direccioncorrecta='')  order by p.cons  ";  

      $datos=mysqli_query($mysqli,$consulta);     

         echo '
         <table id="example" class="display dataTable" cellspacing="0" width="100%" style="font-size: 12px; width: 100%;text-align:center;margin-top: 20px !important" role="grid" aria-describedby="example_info">
        <thead>
          <tr>  
          <th  width="10">Codigo Visita</th>
          <th >Agente</th>
          <th >Producto</th>
          <th >Orden</th>
          <th >Consecutivo</th>
          <th >Direccion</th>
          <th >Ciclo</th>
          <th >Cuenta</th>
          <th >ID Venta</th>
          <th >Estado</th>
          <th width="20">Opciones</th>
          </tr>

          </tr>
        </thead><tfoot>
          <tr>
          <th  width="10">Codigo Visita</th>
          <th >Agente</th>
          <th >Producto</th>
          <th >Orden</th>
          <th >Consecutivo</th>
          <th >Direccion</th>
          <th >Ciclo</th>
          <th >Cuenta</th>
          <th >ID Venta</th>
          <th >Estado</th>
          <th width="20">Opciones</th>
          </tr>
        </tfoot>  <tbody> ';
$cont=1;
                 
      while($row=mysqli_fetch_row($datos)){ 



              if($row[9]=='Pendiente'){
                  $st='style="background-color:#FF2C21; color:#fff;"';
                  $estado="Pendiente"; 
        }else{
                  $estado=$row[9];
           if($row[9]=='EFECTIVO'){ 
                    $st='style="background-color:#00FF2C; color:#fff;"';
                 }else{ 
                    $st='style="background-color:#FF9500; color:#fff;"';
                 }
            }
$CODD="'".$row[0]."'";

             if ($row[1]==""){
                $row[1]="NO ASIGNADO";
              }
               echo '<tr >
                <td  >'.$row[0].'</td>
                 <td  >'.$row[1].'</td>
                <td  >'.$row[2].'</td>
                <td  >'.$row[3].'</td>
                <td  >'.$row[4].'</td>
                <td  >'.$row[5].'</td>
                <td  >'.$row[6].'</td>
                <td  >'.$row[7].'</td>
                <td  >'.$row[8].'</td>
                <td  '.$st.'>'.$estado.'</td>
                <td  >
 <button type="button" onclick="detalleRegistro('.$CODD.');" class="btn btn-info" style="background-color:blue;padding:7px !important">
 <i class="fa fa-search "></i></button>

                </td>
                </tr>';
          $cont++;
            }
 
       echo '</tbody></table>';

      }else{


      if ($_POST["GenerarTipoReporte"]=="PreoperacionalPendientes") {      

  

  $consulta="SELECT nombre,usuario,sesioninicio FROM agentes WHERE (unidad_negocio='ENEL CODENSA' OR unidad_negocio='ENEL REPARTO ESPECIAL' ) AND usuario NOT IN (SELECT codagente FROM `enelpreopperacionalmotos` WHERE fecha='".mysqli_real_escape_string($mysqli,$_POST["GenerarDesde"])."') order by nombre  ";  

      $datos=mysqli_query($mysqli,$consulta);     

         echo '
         <table id="example" class="display dataTable" cellspacing="0" width="100%" style="font-size: 12px; width: 100%;text-align:center;margin-top: 20px !important" role="grid" aria-describedby="example_info">
        <thead>
          <tr>   
          <th >Agente</th>
          <th >Usuario</th>
          <th >Ultimo Login</th> 
          </tr>

          </tr>
        </thead><tfoot>
          <tr>
          <th >Agente</th>
          <th >Usuario</th>
          <th >Ultimo Login</th> 
          </tr>
        </tfoot>  <tbody> ';
$cont=1;
                 
      while($row=mysqli_fetch_row($datos)){ 


 
               echo '<tr >
                <td  >'.$row[0].'</td>
                 <td  >'.$row[1].'</td>
                <td  >'.$row[2].'</td> 
                </tr>';
          $cont++;
            }
 
       echo '</tbody></table>';

      }else{
             $consulta="SELECT p.cons,ag.nombre,p.producto,p.orden,p.guia,p.direccion,p.ciclo,p.cuenta,p.idventa,p.estado FROM ((proyectoespecialenel p 
            INNER JOIN actividad a ON a.cons=p.codactividad) LEFT JOIN agentes ag ON ag.usuario=p.codagente)WHERE 
            a.fecha>='".mysqli_real_escape_string($mysqli,$_POST["GenerarDesde"])."' 
            and  a.fecha<='".mysqli_real_escape_string($mysqli,$_POST["GenerarHasta"])."'    order by p.cons  ";
            $datos=mysqli_query($mysqli,$consulta);

               echo '
               <table id="example" class="display dataTable" cellspacing="0" width="100%" style="font-size: 12px; width: 100%;text-align:center;margin-top: 20px !important" role="grid" aria-describedby="example_info">
              <thead>
                <tr>
                <th  width="10">Codigo Visita</th>
                <th >Agente</th>
                <th >Producto</th>
                <th >Orden</th>
                <th >Consecutivo</th>
                <th >Direccion</th>
                <th >Ciclo</th>
                <th >Cuenta</th>
                <th >ID Venta</th>
                <th >Estado</th>
                <th width="20">Opciones</th>
                </tr>

                </tr>
              </thead><tfoot>
                <tr>
                <th  width="10">Codigo Visita</th>
                <th >Agente</th>
                <th >Producto</th>
                <th >Orden</th>
                <th >Consecutivo</th>
                <th >Direccion</th>
                <th >Ciclo</th>
                <th >Cuenta</th>
                <th >ID Venta</th>
                <th >Estado</th>
                <th width="20">Opciones</th>
                </tr>
              </tfoot>  <tbody> ';
            $cont=1;
                       
            while($row=mysqli_fetch_row($datos)){ 



                    if($row[9]=='Pendiente'){
                        $st='style="background-color:#FF2C21; color:#fff;"';
                        $estado="Pendiente"; 
              }else{
                        $estado=$row[9];
                 if($row[9]=='EFECTIVO'){ 
                          $st='style="background-color:#00FF2C; color:#fff;"';
                       }else{ 
                          $st='style="background-color:#FF9500; color:#fff;"';
                       }
                  }
                  $CODD="'".$row[0]."'";

                   if ($row[1]==""){
                      $row[1]="NO ASIGNADO";
                    }
                     echo '<tr >
                      <td  >'.$row[0].'</td>
                       <td  >'.$row[1].'</td>
                      <td  >'.$row[2].'</td>
                      <td  >'.$row[3].'</td>
                      <td  >'.$row[4].'</td>
                      <td  >'.$row[5].'</td>
                      <td  >'.$row[6].'</td>
                      <td  >'.$row[7].'</td>
                      <td  >'.$row[8].'</td>
                      <td  '.$st.'>'.$estado.'</td>
                      <td  >
       <button type="button" onclick="detalleRegistro('.$CODD.');" class="btn btn-info" style="background-color:blue;padding:7px !important">
       <i class="fa fa-search "></i></button>

                      </td>
                      </tr>';
                $cont++;
                  }
       
             echo '</tbody></table>';
        }
      }
  
}


}

function ReporteSeguimiento($mysqli){ 

$completaconsulta=" 1=1";

if(isset($_SESSION['LMNS_dpto'])) {
    if ($_SESSION['LMNS_dpto']!="") {
      $completaconsulta.=" AND a.Departamento='".mysqli_real_escape_string($mysqli,$_SESSION['LMNS_dpto'])."'";
    }
}

if(isset($_SESSION['LMNS_unidad'])){
  if ($_SESSION['LMNS_unidad']!="") {
    $completaconsulta.=" AND a.unidad_negocio='".mysqli_real_escape_string($mysqli,$_SESSION["LMNS_unidad"])."' ";
  }
}



		if ($_POST["GenerarSeguimientoTipo"]=="velocidad") {
            $consulta="SELECT DISTINCT(a.usuario),a.nombre FROM tracking t INNER JOIN agentes a ON a.usuario=t.usuario 
            WHERE t.fecha='".$_POST["GenerarSeguimientoFecha"]."' AND ".$completaconsulta." GROUP BY a.nombre "; 

		           


        $d1=mysqli_query($mysqli,$consulta);

         echo '
         <table id="exampleDetalle" class="display dataTable" cellspacing="0" width="100%" style="font-size: 10px; width: 100%;margin-top: 20px !important">
        <thead>
          <tr>
            <th width="10">Cons</th>
            <th >Nombre Agente</th>
            <th >Cantidad Incidencias</th>
            <th width="50">Detallar</th>
          </tr>
        </thead><tfoot>
          <tr>
            <th width="10">Cons</th>
            <th >Nombre Agente</th>
            <th >Cantidad Incidencias</th>
            <th width="50">Detallar</th>
          </tr>
        </tfoot>  <tbody> ';

$cont=1;
while($r1=mysqli_fetch_row($d1)){ 
              
 

              echo '<tr >
            <td  >'.$cont.'</td>
            <td  >'. $r1[1].'</td>';


              $consulta="SELECT usuario,hora,lat,lon FROM tracking WHERE 
              fecha='".$_POST["GenerarSeguimientoFecha"]."' AND usuario='".$r1[0]."' ORDER BY hora DESC "; 


            $datos=mysqli_query($mysqli,$consulta); 
            $latanterior="";
            $lonanterior="";
            $horaold="";
            $horakm="";
            $strincidencias="";
            $cantincidencias=0;

            while($row=mysqli_fetch_row($datos)){ 

            $velocidad="";
            $diferencia="";
            $segundos="";
            $minutos="";
            $horas="";
            $tiempocalculo="";
            $kmh=0;
              
      

                            if($horaold==""){
                                $horaold=$row[1];
                                $latanterior=$row[2];
                                $lonanterior=$row[3];
                            }else{
                                $datetime1 = new DateTime($row[1]);
                                $datetime2 = new DateTime($horaold);
                                $interval = $datetime1->diff($datetime2);
                                $segundos = $interval->format('%s');
                                $minutos = $interval->format('%i');
                                $horas = $interval->format('%H');

                                $elapsed = ($minutos)+($horas*60);
                                $tiempocalculo = ($segundos)+($minutos*60)+($horas*360);
                                if($elapsed>20){
                                  $clase=' style="background-color:red " ';
                                }

                                $diferencia = distanceCalculation($latanterior, $lonanterior, $row[2], $row[3], "km", "");
                                 if (($diferencia."")!="NAN") {
                                    $kmh=round(((($diferencia/$tiempocalculo)*18)/5),0);
                                }
                            }
                            
                        if($kmh>50){
                            if($horaold==$horakm){
                                $cantincidencias++; 
                                $strincidencias= $strincidencias." | ".$row[1];
                            }
                                $horakm=$row[1];

                        }
            
                        
                        $horaold=$row[1];
                        $latanterior=$row[2];
                        $lonanterior=$row[3];
      }



                        $cont++;
             ECHO'<td>'.$cantincidencias.'</td><td>
            <a href="Reportes/rptSeguimientoDetallado.php?cod='.$r1[0].'&fecha='.$_POST["GenerarSeguimientoFecha"].'" target="_blank">
             <button type="button" style="background-color:green;padding:3px !important" class="btn btn-success btn-circle">
             <i class="fa fa-download"></i></button>
            </a>
         </td></tr>';
 }
       }else{
            $consulta="SELECT a.nombre,COUNT(*),a.usuario FROM registrofueradezona r INNER JOIN agentes a ON a.usuario=r.codagente 
            WHERE fecha='".$_POST["GenerarSeguimientoFecha"]."' AND ".$completaconsulta." GROUP BY a.usuario "; 


        $d1=mysqli_query($mysqli,$consulta);

         echo '
         <table id="exampleDetalle" class="display dataTable" cellspacing="0" width="100%" style="font-size: 10px; width: 100%;margin-top: 20px !important">
        <thead>
          <tr>
            <th width="10">Cons</th>
            <th >Nombre Agente</th>
            <th >Cantidad Incidencias</th>
            <th width="50">Detallar</th>
          </tr>
        </thead><tfoot>
          <tr>
            <th width="10">Cons</th>
            <th >Nombre Agente</th>
            <th >Cantidad Incidencias</th>
            <th width="50">Detallar</th>
          </tr>
        </tfoot>  <tbody> ';

		$cont=1;
		while($r1=mysqli_fetch_row($d1)){ 

              echo '<tr >
            <td  >'.$cont.'</td>
            <td  >'. $r1[0].'</td>
            <td  >'. $r1[1].'</td>
            <td>
            <a href="Reportes/rptSeguimientoDetallado.php?cod='.$r1[2].'&fecha='.$_POST["GenerarSeguimientoFecha"].'" target="_blank">
             <button type="button" style="background-color:green;padding:3px !important" class="btn btn-success btn-circle">
             <i class="fa fa-download"></i></button>
            </a>
         </td></tr>';
 $cont++;
		}



		}


          echo '</tbody></table>';
}

function tiempo($tiempo) {
  $valor="";
  if ($tiempo > 0) {
    if ($tiempo < 60) {
        $tiempo = $tiempo;
        $valor = " minutos";
    } elseif ($tiempo > 60 && $tiempo < 1440) {
        $tiempo = $tiempo / 60;
        $tiempo = number_format($tiempo);
        $valor = " horas";
    } elseif ($tiempo > 1440) {
        $tiempo = $tiempo / 1440;
        $tiempo = number_format($tiempo);
        $valor = " días";
    }
    return "Hace ".$tiempo . $valor;
  }else{
    return "Ahora Mismo";
  }
    
  
}  
function DetallarAgentes($mysqli){ 

      $consulta="SELECT a.nombre,a.telefono,z.nombre,TIMESTAMPDIFF(MINUTE ,a.fechageo,NOW()),sesioninicio,sesionfin FROM agentes a inner join zonas z on z.codigo=a.sector WHERE 
     a.cons in (".$_POST["DetallarAgentes"].") ORDER BY a.fechageo asc "; 


        $datos=mysqli_query($mysqli,$consulta);

         echo '
         <table id="exampleDetalle" class="display dataTable" cellspacing="0" width="100%" style="font-size: 10px; width: 100%;text-align:center;margin-top: 20px !important">
        <thead>
          <tr>
            <th width="10">Cons</th>
            <th >Nombre</th>
            <th >Telefono</th>
            <th >Sector</th>
            <th >Ultima Transmision</th>
            <th >Inició Sesion</th>
            <th >Finalizó Sesion</th>
          </tr>
        </thead><tfoot>
          <tr>
             <th width="10">Cons</th>
            <th >Nombre</th>
            <th >Telefono</th>
            <th >Sector</th>
            <th >Ultima Transmision</th>
            <th >Inició Sesion</th>
            <th >Finalizó Sesion</th>
          </tr>
        </tfoot>  <tbody> ';
$cont=1;
       
          if(mysqli_num_rows($datos)>0){           
while($row=mysqli_fetch_row($datos)){ 
              
             echo '<tr >
            <td  >'.$cont.'</td>
            <td  >'.$row[0].'</td>
            <td  >'.$row[1].'</td>
            <td  >'.$row[2].'</td>
            <td  > '.tiempo($row[3]).' </td>
            <td  >'.$row[4].'</td>
            <td  >'.$row[5].'</td>
            </tr>';
      $cont++;
            }
            
          }

          echo '</tbody></table>';
}

   function distanceCalculation($point1_lat, $point1_long, $point2_lat, $point2_long, $unit, $decimals) {
      $degrees = rad2degs(acos( (sin(deg2rads($point1_lat)) * sin(deg2rads($point2_lat))) + (cos(deg2rads($point1_lat))*cos(deg2rads($point2_lat)) * cos(deg2rads($point1_long-$point2_long)) ) ));
      switch($unit) {
        case 'km':
          $distance = $degrees * 111.13384; // 1 grado = 111.13384 km, basándose en el diametro promedio de la Tierra (12.735 km)
          $distance = $distance * 1000; // 1 grado = 111.13384 km, basándose en el diametro promedio de la Tierra (12.735 km)
          break;
        case 'mi':
          $distance = $degrees * 69.05482; // 1 grado = 69.05482 millas, basándose en el diametro promedio de la Tierra (7.913,1 millas)
          break;
        case 'nmi':
          $distance =  $degrees * 59.97662; // 1 grado = 59.97662 millas naúticas, basándose en el diametro promedio de la Tierra (6,876.3 millas naúticas)
      }
      return round($distance,0);
    }


    function rad2degs($angle) {
      return $angle * 57.29577951308232 ;// angle / Math.PI * 180
    }

    function deg2rads($angle) {
      return $angle * 0.017453292519943295 ;// (angle / 180) * Math.PI;
    }    

function TrazaDispositivo($mysqli){ 



      $consulta="SELECT hora,red,bateria,carga,bluet,equipo,lat,lon FROM tracking WHERE 
      fecha='".mysqli_real_escape_string($mysqli,$_POST["TrazaDispositivoFecha"])."' AND 
      usuario='".mysqli_real_escape_string($mysqli,$_POST["TrazaDispositivo"])."' ORDER BY hora DESC "; 
$latanterior="";
$lonanterior="";
$horaold="";



        $datos=mysqli_query($mysqli,$consulta);



         echo '
         <table id="example" class="display dataTable" cellspacing="0" width="100%" style="font-size: 10px; width: 100%;text-align:center;margin-top: 20px !important">
        <thead>
          <tr>
            <th  width="10">Cons</th>
            <th >Hora</th>
            <th >Red</th>
            <th >Bateria</th>
            <th >Carga</th>
            <th >Bluetooth</th>
            <th >Velocidad</th>
            <th >Equipo</th>
          </tr>
        </thead><tfoot>
          <tr>
            <th  width="10">Cons</th>
            <th >Hora</th>
            <th >Red</th>
            <th >Bateria</th>
            <th >Carga</th>
            <th >Bluetooth</th>
            <th >Velocidad</th>
            <th >Equipo</th>
          </tr>
        </tfoot>  <tbody> ';
$cont=1;
          if(mysqli_num_rows($datos)>0){           
                while($row=mysqli_fetch_row($datos)){ 
$clase="";
$velocidad="";
$diferencia="";
$segundos="";
$minutos="";
$horas="";
$tiempocalculo="";
$kmh=0;
                            if($horaold==""){
                                $horaold=$row[0];
                                $latanterior=$row[6];
                                $lonanterior=$row[7];
                            }else{
                                $datetime1 = new DateTime($row[0]);
                                $datetime2 = new DateTime($horaold);
                                $interval = $datetime1->diff($datetime2);
                                $segundos = $interval->format('%s');
                                $minutos = $interval->format('%i');
                                $horas = $interval->format('%H');

                                $elapsed = ($minutos)+($horas*60);
                                $tiempocalculo = ($segundos)+($minutos*60)+($horas*360);
                                if($elapsed>20){
                                  $clase=' style="background-color:red " ';
                                }

    							$diferencia = distanceCalculation($latanterior, $lonanterior, $row[6], $row[7], "km", "");
	   							 if (($diferencia."")!="NAN") {
	                           	 	$kmh=round(((($diferencia/$tiempocalculo)*18)/5),0);
	                            }
                            } 

                        

                            echo '<tr '.$clase.'>
                            <td  >'.$cont.'</td>
                            <td  >'.$row[0].'</td>
                            <td  >'.$row[1].'</td>
                            <td  >'.$row[2].'</td>
                            <td  >'.$row[3].'</td>
                            <td  >'.$row[4].'</td>
                            <td  >'.$kmh.'Km/h </td>
                            <td  >'.$row[5].'</td>
                            </tr>'
                        ;$horaold=$row[0];
                    	$cont++;
                    	$latanterior=$row[6];
						$lonanterior=$row[7];
                  }
            
          }

          echo '</tbody></table>';
}

function Busqueda($mysqli){ 

$completa="";


if($_POST["BusquedaTipo"]==""){
  $completa="  (p.resultado1='".mysqli_real_escape_string($mysqli,$_POST["BusquedaParametro"])."' 
  or p.resultado2='".mysqli_real_escape_string($mysqli,$_POST["BusquedaParametro"])."') ";
}else{
 $completa=" p.".$_POST["BusquedaTipo"]."='".mysqli_real_escape_string($mysqli,$_POST["BusquedaParametro"])."'";
}



if($_POST["BusquedaCodcl"]!="N/A"){
  $completa.=" and p.codcliente='".mysqli_real_escape_string($mysqli,$_POST["BusquedaCodcl"])."' ";
}



      $consulta="SELECT   ac.fecha, ac.cons,p.destinatario,p.direccion,c.nombre,p.cliente,p.referencia1,a.nombre,p.estado,p.respuesta,p.soporte as pcons
       FROM ((((principal p INNER JOIN actividad ac ON ac.cons=p.codactividad) 
       INNER JOIN ciudades c ON c.cons=p.codciudad)
       INNER JOIN departamentos d ON d.cons=p.coddepartamento) 
       INNER JOIN agentes a ON a.usuario=p.codagente)
      WHERE ". $completa." AND ac.fecha>='".mysqli_real_escape_string($mysqli,$_POST["BusquedaDesde"])."' 
      and ac.fecha<='".mysqli_real_escape_string($mysqli,$_POST["BusquedaHasta"])."' AND 
     p.codempresa='".mysqli_real_escape_string($mysqli,$_POST["BusquedaCode"])."' ORDER BY ac.fecha DESC,p.cons DESC  "; 


        $datos=mysqli_query($mysqli,$consulta);

         echo '
         <table id="example" class="display dataTable" cellspacing="0" width="100%" style="font-size: 10px; width: 100%;text-align:center;margin-top: 20px !important">
        <thead>
          <tr>
            <th  width="10">Cons</th>
            <th >Fecha</th>
            <th  width="10">Actividad</th>
            <th  >Destinatario</th>
            <th >Direccion</th>
            <th >Ciudad</th>
            <th >Cliente</th>
            <th >Referencia 1</th>
            <th >Agente</th>
            <th >Estado</th>
            <th >Respuesta</th>
            <th >Soporte</th>
          </tr>
        </thead><tfoot>
          <tr>
            <th  width="10">Cons</th>
            <th  >Fecha</th>
            <th  width="10">Actividad</th>
            <th  >Destinatario</th>
            <th >Direccion</th>
            <th >Ciudad</th>
            <th >Cliente</th>
            <th >Referencia 1</th>
            <th >Agente</th>
            <th >Estado</th>            
            <th >Respuesta</th>
            <th >Soporte</th>
          </tr>
        </tfoot>  <tbody> ';
$cont=1;
       
          if(mysqli_num_rows($datos)>0){           
while($row=mysqli_fetch_row($datos)){ 
              
             echo '<tr >
            <td  >'.$cont.'</td>
            <td  >'.$row[0].'</td>
            <td  >'.$row[1].'</td>
            <td  >'.$row[2].'</td>
            <td  >'.$row[3].'</td>
            <td  >'.$row[4].'</td>
            <td  >'.$row[5].'</td>
            <td  >'.$row[6].'</td>
            <td  >'.$row[7].'</td>
            <td  >'.$row[8].'</td>
            <td  >'.$row[9].'</td>
            <td  >'.$row[10].'</td>
          </tr>';
$cont++;
            }
            
          }

          echo '</tbody></table>';
}


function Monitoreo($mysqli){ 

$contcliente=0;
$completa="";
if($_POST["MonitoreoActividad"]!=""){
  $completa=" AND p.codactividad='".mysqli_real_escape_string($mysqli,$_POST["MonitoreoActividad"])."' ";
}else{

        $completaint="";
        if($_POST["MonitoreoTipo"]!=""){
          $completaint=" AND tipo='".mysqli_real_escape_string($mysqli,$_POST["MonitoreoTipo"])."' ";  
        }


  if($_POST["MonitoreoCl"]==""){

        $consulta="SELECT cons FROM actividad WHERE  
        fecha='".mysqli_real_escape_string($mysqli,$_POST["MonitoreoFecha"])."' 
        ".$completaint;
        $codigos="0";
        $datos=mysqli_query($mysqli,$consulta);                 
        while($row=mysqli_fetch_row($datos)){ 
           $contcliente++;
            $codigos= $codigos.",".$row[0];
        }

  }else{
        $consulta="SELECT distinct codactividad FROM actividadclientes WHERE  
        fecha='".mysqli_real_escape_string($mysqli,$_POST["MonitoreoFecha"])."' 
        ".$completaint;
        $codigos="0";
        $datos=mysqli_query($mysqli,$consulta);                 
        while($row=mysqli_fetch_row($datos)){ 
           $contcliente++;
            $codigos= $codigos.",".$row[0];
        }
  }


      $completa=" AND p.codactividad in (".$codigos.") ";
}


  if($_POST["MonitoreoCl"]!=""){
   $completa=" AND p.codcliente='".mysqli_real_escape_string($mysqli,$_POST["MonitoreoCl"])."'";
  }


          $listaagentes="";
        $codigosmensj="'0'";
        $consulta="SELECT a.nombre,SUM(CASE WHEN estado !='Pendiente' THEN 1 ELSE 0 END),
        SUM(CASE WHEN estado !='Pendiente' THEN 0 ELSE 1 END),a.usuario 
        FROM principal p inner join agentes a on a.usuario=p.codagente WHERE    
        p.fechaactividad='".mysqli_real_escape_string($mysqli,$_POST["MonitoreoFecha"])."' 
        AND p.codempresa='".mysqli_real_escape_string($mysqli,$_POST["MonitoreoUser"])."' 
        ".$completa."  group by a.nombre,a.usuario ";
        $contagente=0;
        $datos=mysqli_query($mysqli,$consulta);                 
        while($row=mysqli_fetch_row($datos)){ 
            $codigosmensj= $codigosmensj.",'".$row[3]."'";
           $contagente++;
          $ctotal=$row[1]+$row[2];
          $porcentajeagentes= round((($row[1]/$ctotal)*100),0);
          $color="green";
          if($porcentajeagentes>=30 && $porcentajeagentes<=60 ){
              $color="yellow";
          }else{

            if($porcentajeagentes<=30 ){
                $color="red";
            }
          }
          $row[3]="'".$row[3]."'";
          $listaagentes.= '<li><button onclick="TrazaAgente('.$row[3].');" type="button" class="btn btn-info" style="background-color:#0B60FF;padding:3px !important;margin-top:-5px"><i class="fa fa-map-marker"></i></button>
          <button onclick="TrazaDispositivo('.$row[3].');" type="button" class="btn btn-info" style="background-color: #E8120C;padding:3px !important;margin-top:-5px;color:#fff"><i class="fa fa-server"></i></button>  '.$row[0].' ('.$row[1].'/'.$ctotal.')<span class="pull-right">'.$porcentajeagentes.'%</span>  
            <div class="progress progress-striped active progress-right">
            <div class="bar '.$color.'" style="width:'.$porcentajeagentes.'%;"></div></div></li>';
        }


$totalregistros=0;
$listaclientes="";
        $consulta="SELECT cliente,SUM(CASE WHEN estado !='Pendiente' THEN 1 ELSE 0 END),
        SUM(CASE WHEN estado !='Pendiente' THEN 0 ELSE 1 END) 
        FROM principal p  WHERE    
        p.fechaactividad='".mysqli_real_escape_string($mysqli,$_POST["MonitoreoFecha"])."' 
        AND p.codempresa='".mysqli_real_escape_string($mysqli,$_POST["MonitoreoUser"])."' 
        ".$completa."  group by cliente ";
       
        $datos=mysqli_query($mysqli,$consulta);                 
        while($row=mysqli_fetch_row($datos)){  
          $ctotal=$row[1]+$row[2];
          $porcentajecliente= round((($row[1]/$ctotal)*100),0);
          $color="green";
          if($porcentajecliente>=30 && $porcentajecliente<=60 ){
              $color="yellow";
          }else{

            if($porcentajecliente<=30 ){
                $color="red";
            }
          }
$totalregistros=$totalregistros+$ctotal;
          $listaclientes.= '<li>'.$row[0].' ('.$row[1].'/'.$ctotal.') <span class="pull-right">'.$porcentajecliente.'%</span>  
            <div class="progress progress-striped active progress-right">
            <div class="bar '.$color.'" style="width:'.$porcentajecliente.'%;"></div></div></li>';
        }


        $listaestados="";
        $consulta="SELECT estado,count(cons) 
        FROM principal p  WHERE    
        p.fechaactividad='".mysqli_real_escape_string($mysqli,$_POST["MonitoreoFecha"])."' 
        AND p.codempresa='".mysqli_real_escape_string($mysqli,$_POST["MonitoreoUser"])."' 
        ".$completa."  group by estado";

        $datos=mysqli_query($mysqli,$consulta);                 
        while($row=mysqli_fetch_row($datos)){ 
          $porcentajeestados= round((($row[1]/$totalregistros)*100),0);
          $color="green";
          if($porcentajeestados>=30 && $porcentajeestados<=60 ){
              $color="yellow";
          }else{

            if($porcentajeestados<=30 ){
                $color="red";
            }
          }

          $listaestados.= '<li>'.$row[0].' ('.$row[1].'/'.$totalregistros.') <span class="pull-right">'.$porcentajeestados.'%</span>  
            <div class="progress progress-striped active progress-right">
            <div class="bar '.$color.'" style="width:'.$porcentajeestados.'%;"></div></div></li>';
        }





echo ' 
      <div class="main-page">


          <div class="col-md-4" style="border:solid 1px #ccc;box-shadow: 0px 0px 5px -2px rgba(0,0,0,0.75); background-color:#fff">
            <div class="r3_counter_box">
                    <i class="pull-left fa fa-users dollar2  icon-rounded"></i>
                    <div class="stats">
                      <h5><strong>'.$contagente.'</strong></h5>
                      <span>Agentes Activos</span>
                    </div>
                </div>
          </div>

          <div class=" col-md-5" style="border:solid 1px #ccc;box-shadow: 0px 0px 5px -2px rgba(0,0,0,0.75); background-color:#fff;">
            <div class="r3_counter_box">
                    <i class="pull-left fa fa-pie-chart dollar1  icon-rounded"></i>
                    <div class="stats">
                      <h5><strong>'.$totalregistros.'</strong></h5>
                      <span>Visitas Asignadas</span>
                    </div>
                </div>
          </div>
          <div class="col-md-3 " style="border:solid 1px #ccc;box-shadow: 0px 0px 5px -2px rgba(0,0,0,0.75); background-color:#fff">
            <div class="r3_counter_box">
                    <i class="pull-left fa fa-laptop user1  icon-rounded"></i>
                    <div class="stats">
                      <h5><strong>'.$contcliente.'</strong></h5>
                      <span>Actividades</span>
                    </div>
                </div>
          </div>




          <div class="col-md-12"><br></div>
          <div class="clearfix"></div>
</div>

<div class="col-md-4  stats-info" style="border:solid 1px #ccc;box-shadow: 0px 0px 5px -2px rgba(0,0,0,0.75); background-color:#fff">
            <div class="stats-info-agileits" >
              <header class="widget-header" >
                <h4 class="widget-title" ><b>Resumen Agentes </b></h4> </header>
                <hr class="widget-separator" style="border-top: 1px solid red;" >
                <div class="stats-body">
                <ul class="list-unstyled">
               '.$listaagentes.'</ul></div></div></div>

          <div class="col-md-5  stats-info" style="border:solid 1px #ccc;box-shadow: 0px 0px 5px -2px rgba(0,0,0,0.75); background-color:#fff">
             <header class="widget-header"><h4 class="widget-title"><b>Resumen Clientes</b></h4>
             </header><hr class="widget-separator" style="border-top: 1px solid yellow;">
              <div class="stats-body">
                <ul class="list-unstyled">
                  '.$listaclientes.'
                </ul></div></div></div>



          <div class="col-md-3  stats-info" style="border:solid 1px #ccc;box-shadow: 0px 0px 5px -2px rgba(0,0,0,0.75); background-color:#fff">
            <div class="stats-info-agileits">
             <header class="widget-header"><h4 class="widget-title"><b>Resumen Gestiones</b></h4>
             </header><hr class="widget-separator" style="border-top: 1px solid yellow;">
              <div class="stats-body">
                <ul class="list-unstyled">
                  '.$listaestados.'
                </ul></div></div></div>§'.$codigosmensj;
}




mysqli_close($mysqli);
?>