<?php
require_once("Conexion.php");

  if( isset($_POST["Ingresar"]) ){
		Ingresar($mysqli);							
	}else if(isset($_POST["Listar"])){
    Listar($mysqli);
  }else if(isset($_POST["Buscar_Datos"])){
    buscar($mysqli);
  }else if(isset($_POST["Actualizar"])){
    Actualizar($mysqli);
  }else if(isset($_POST["marcadores"])){
    marcadores($mysqli);
  }else if(isset($_POST["cambioTipoBTipo"])){
    cambioTipo($mysqli);
  }else if(isset($_POST["cambioFechaFecha"])){
    cambioFecha($mysqli);
  } else if(isset($_POST["ListarEnel"])){
    ListarEnel($mysqli);
  }




function ListarEnel($mysqli){ 
if($_POST["Listado_dpto"] =="" && $_POST["Listado_UniNeg"] == "")
{ 
         $consulta= " SELECT a.nombre,a.usuario,e.fechaguardado,e.placa, e.marca, e.modelo, e.fechavencimientosoat, e.licencia, e.fechavencimientolicencia, e.licenciatrancito, e.fechavencimientotecnomecanica FROM eneldatosvehiculo e INNER JOIN agentes a ON a.usuario= e.codagente  ORDER BY a.nombre  ";
   
}

else if ( !empty($_POST["Listado_dpto"]) && $_POST["Listado_UniNeg"] == "") 
{ 
         $consulta="SELECT a.nombre,a.usuario,e.fechaguardado,e.placa, e.marca, e.modelo, e.fechavencimientosoat, e.licencia, e.fechavencimientolicencia, e.licenciatrancito, e.fechavencimientotecnomecanica FROM eneldatosvehiculo e INNER JOIN agentes a ON a.usuario= e.codagente
         where  a.Departamento='".mysqli_real_escape_string($mysqli,$_POST["Listado_dpto"])."'
         ORDER BY a.nombre  ";  
}

else if ( $_POST["Listado_dpto"] == "" &&  !empty($_POST["Listado_UniNeg"]) ) 
{ 
         $consulta="SELECT a.nombre,a.usuario,e.fechaguardado,e.placa, e.marca, e.modelo, e.fechavencimientosoat, e.licencia, e.fechavencimientolicencia, e.licenciatrancito, e.fechavencimientotecnomecanica FROM eneldatosvehiculo e INNER JOIN agentes a ON a.usuario= e.codagente
         where  a.unidad_negocio='".mysqli_real_escape_string($mysqli,$_POST["Listado_UniNeg"])."'
         ORDER BY a.nombre  ";  
}




else if ( !empty($_POST["Listado_dpto"]) && !empty($_POST["Listado_UniNeg"])  ) 
{ 
         $consulta=" SELECT a.nombre,a.usuario,e.fechaguardado,e.placa, e.marca, e.modelo, e.fechavencimientosoat, e.licencia, e.fechavencimientolicencia, e.licenciatrancito, e.fechavencimientotecnomecanica FROM eneldatosvehiculo e INNER JOIN agentes a ON a.usuario= e.codagente
         where  a.Departamento='".mysqli_real_escape_string($mysqli,$_POST["Listado_dpto"])."'
        AND a.unidad_negocio='".mysqli_real_escape_string($mysqli,$_POST["Listado_UniNeg"])."'  ORDER BY a.nombre  ";  
} 

$datos=mysqli_query($mysqli,$consulta);
//   <th >Empresa</th>
          $tabla='<table id="exampleEnel" class="display dataTable" cellspacing="0" width="100%" style="font-size: 12px; width: 100%;" role="grid" aria-describedby="example_info">
        <thead>
          <tr>
       
          <th >Nombre</th>
          <th >Usuario</th>
          <th >Fecha Guardado</th>
          <th >Placa</th> 
          <th >Marca</th> 
          <th >Modelo</th> 
          <th >Vencimienot Soat</th> 
          <th >Licencia Conduccion</th> 
          <th >Vencimiento Licencia</th> 
          <th >Licencia Trancito</th> 
          <th >Vencimiento Tecnomecanica</th>   </tr></tr>
        </thead><tfoot>
          <tr> 
          <th >Nombre</th>
          <th >Usuario</th>
          <th >Fecha Guardado</th>
          <th >Placa</th> 
          <th >Marca</th> 
          <th >Modelo</th> 
          <th >Vencimienot Soat</th> 
          <th >Licencia Conduccion</th> 
          <th >Vencimiento Licencia</th> 
          <th >Licencia Trancito</th> 
          <th >Vencimiento Tecnomecanica</th>   </tr>
        </tfoot>  <tbody> ';          

       
          if(mysqli_num_rows($datos)>0){           
            while($row=mysqli_fetch_row($datos)){ 


                  $tabla.='<tr  >   
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
            }             
          }                          

          $tabla.='</tbody></table>';             

          echo $tabla;
}


function sendGCM ( $m, $t, $r){
    // API access key from Google API's Console
        if (!defined('API_ACCESS_KEY')) define( 'API_ACCESS_KEY', 'AAAAaSpvWag:APA91bE2KRx8TXR-zhtWscfqoHxnvGxwYfPZhxbSY4K4jTPqHbXVrk_loogVVLBlmi4IqcAtbqPubToC3Jnq6t6_5Nx8jeW8KEzgHys8iE4DLeK-jcLKEfYAF77LXR1_LQKVZF0lICD4' );
        $tokenarray = array($r);
        // prep the bundle
        $msg = array
        (
            'title'     => $t,
            'body'     => $m 

        );
        $fields = array
        (
            'registration_ids'     => $tokenarray,
            'notification'            => $msg
        );

        $headers = array
        (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        return $result;
    }  




function cambioFecha($mysqli){ 


$completa="";
if($_POST["cambioFechaTipo"]!=""){
  $completa=" AND a.tipo='".mysqli_real_escape_string($mysqli,$_POST["cambioFechaTipo"])."' ";
}

if($_POST["cambioFechaCl"]==""){
     $consulta="SELECT a.cons,a.observaciones,u.nombre,a.cantidad FROM actividad a 
                INNER JOIN usuarios u ON a.usuariocarga=u.usuario
                WHERE a.fecha='".mysqli_real_escape_string($mysqli,$_POST["cambioFechaFecha"])."' 
                ".$completa;
                //AND a.codempresa='".mysqli_real_escape_string($mysqli,$_POST["cambioFechaUser"])."'
 }else{
     $consulta="SELECT a.codactividad,a.observaciones,u.nombre,a.cantidad FROM actividadclientes a 
                INNER JOIN usuarios u ON a.usuariocarga=u.usuario
                WHERE a.fecha='".mysqli_real_escape_string($mysqli,$_POST["cambioFechaFecha"])."' 
                AND a.codcliente='".mysqli_real_escape_string($mysqli,$_POST["cambioFechaCl"])."' 
                ".$completa;
 
 }

 //  AND a.codempresa='".mysqli_real_escape_string($mysqli,$_POST["cambioFechaUser"])."'
    
      $datos=mysqli_query($mysqli,$consulta);
      echo ' <select id="Actividad" name="Actividad" class="form-control">
      <option  selected="selected" value="">Todas</option> ';              
      while($row=mysqli_fetch_row($datos)){      
          echo '<option   value="'.$row[0].'">'.$row[0].' - '.$row[2].' ('.$row[3].') '.$row[1].'</option>';  
      }
      echo ' </select>';
 
}


function cambioTipo($mysqli){

  $consulta="";
$completaconsulta="";

    if ($_POST['cambioTipoBDepaDrop']!="") {
      $completaconsulta.=" AND Departamento='".mysqli_real_escape_string($mysqli,$_POST['cambioTipoBDepaDrop'])."'";
    }

  if ($_POST['cambioTipoBuniDrop']!="") {
    $completaconsulta.=" AND unidad_negocio='".mysqli_real_escape_string($mysqli,$_POST["cambioTipoBuniDrop"])."' ";
  }


if($_POST["cambioTipoBUserCl"]==""){



    if($_POST["cambioTipoBTipo"]=="Publicidad"){
       $consulta="  SELECT usuario,nombre FROM agentes WHERE 
      fechapublicidad='".mysqli_real_escape_string($mysqli,$_POST["cambioTipoBFecha"])."' ".$completaconsulta."
       ORDER BY nombre  "; 
       // and  codempresa='".mysqli_real_escape_string($mysqli,$_POST["cambioTipoBUser"])."'
    }else{
      if($_POST["cambioTipoBTipo"]=="Asignaciones"){
          $consulta="  SELECT usuario,nombre FROM agentes WHERE 
        fechavisitas='".mysqli_real_escape_string($mysqli,$_POST["cambioTipoBFecha"])."'  ".$completaconsulta."
        ORDER BY nombre  ";
        //and  codempresa='".mysqli_real_escape_string($mysqli,$_POST["cambioTipoBUser"])."' 
       }else{
        $consulta="SELECT usuario,nombre FROM agentes WHERE 
        usuario in (SELECT DISTINCT usuario FROM tracking WHERE fecha='".mysqli_real_escape_string($mysqli,$_POST["cambioTipoBFecha"])."' )  ".$completaconsulta."
        ORDER BY nombre  ";
        //and  codempresa='".mysqli_real_escape_string($mysqli,$_POST["cambioTipoBUser"])."'   
       }
    }

}else{ 

   if($_POST["cambioTipoBTipo"]=="Asignaciones"){
         $consulta="SELECT DISTINCT u.usuario,u.nombre FROM 
        (principal p inner join agentes u on u.usuario=p.codagente) WHERE 
        codcliente='".mysqli_real_escape_string($mysqli,$_POST["cambioTipoBUserCl"])."'
        and  p.fechaestado='".mysqli_real_escape_string($mysqli,$_POST["cambioTipoBFecha"])."' 
        ORDER BY u.nombre   "; 
       }else{
     
         $consulta="SELECT usuario,nombre FROM agentes WHERE 
        usuario in (SELECT DISTINCT usuario FROM tracking WHERE fecha='".mysqli_real_escape_string($mysqli,$_POST["cambioTipoBFecha"])."' )  ".$completaconsulta."
        ORDER BY nombre  ";
       }

}


  $datos=mysqli_query($mysqli,$consulta);
    echo ' <select id="Agentes" name="Agentes" class="form-control">
         <option  selected="selected" value="">Seleccionar...</option> ';              
while($row=mysqli_fetch_row($datos)){      
          echo '<option   value="'.$row[0].'">'.$row[1].'</option>';  
      }
      echo ' </select>';

}

function marcadores($mysqli){


     $consulta="SELECT lat,lon,nombre,fechageo,cons FROM agentes WHERE DATE(fechageo)=CURDATE() "; 
     $datos=mysqli_query($mysqli,$consulta);       

$cont=0; 
  while($row=mysqli_fetch_row($datos)){ 

  echo " var latlng = new google.maps.LatLng(".$row[0].",".$row[1].");
  marker2.setPosition(latlng);";
  }

}



function Ingresar($mysqli){

$consulta2=" SELECT  nombre FROM agentes WHERE 
usuario='".mysqli_real_escape_string($mysqli,$_POST["Usuario"])."' "; 
 $datos2=mysqli_query($mysqli,$consulta2);
  if(mysqli_num_rows($datos2)>0){
    echo 'Este Usuario ya fue ingresado';          
  }else{


 $consulta=" INSERT agentes (nombre,usuario,telefono,correo,observaciones,unidad,desplazamiento,sector,Departamento,tipoagente,unidad_negocio,estadoagente) VALUE ('".
mysqli_real_escape_string($mysqli,strtoupper($_POST["Nombre"]))."','".
mysqli_real_escape_string($mysqli,$_POST["Usuario"])."','".
mysqli_real_escape_string($mysqli,strtoupper($_POST["Telefono"]))."','".
mysqli_real_escape_string($mysqli,strtoupper($_POST["Correo"]))."','".
//mysqli_real_escape_string($mysqli,$_POST["Empresa"])."','".
mysqli_real_escape_string($mysqli,$_POST["Observaciones"])."' ,'". 
mysqli_real_escape_string($mysqli,$_POST["Unidad"])."' ,'".
mysqli_real_escape_string($mysqli,$_POST["Desplazamiento"])."' ,'".
mysqli_real_escape_string($mysqli,$_POST["Sector"])."' ,'".
mysqli_real_escape_string($mysqli,$_POST["Departamento"])."','".
mysqli_real_escape_string($mysqli,$_POST["TipoAgente"])."', '".
mysqli_real_escape_string($mysqli,$_POST["unidadNeg"])."' , '".
mysqli_real_escape_string($mysqli,$_POST["Estado"])."' ) ";       

          if( $datos=mysqli_query($mysqli,$consulta) ){
//codempresa
     $consulta=" INSERT usuarios (usuario,nombre,pass,estado,tipo,imei) VALUE 
    ('".mysqli_real_escape_string($mysqli,$_POST["Usuario"])."',  
    '".mysqli_real_escape_string($mysqli,strtoupper($_POST["Nombre"]))."',
    '".mysqli_real_escape_string($mysqli,$_POST["Pass"])."',
    '".mysqli_real_escape_string($mysqli,$_POST["Estado"])."','Agente',   
    '".mysqli_real_escape_string($mysqli,$_POST["Imei"])."')";          
    $datos=mysqli_query($mysqli,$consulta);
    
//'".mysqli_real_escape_string($mysqli,$_POST["Empresa"])."',

            echo 'OK';
          }else{
            echo 'No se ha podido Ingresar el Agente';
          }
 }
     
}

function Actualizar($mysqli){


          $consulta=" UPDATE agentes SET 
          nombre='".mysqli_real_escape_string($mysqli,strtoupper($_POST["Nombre"]))."',
          usuario='".mysqli_real_escape_string($mysqli,$_POST["Usuario"])."',
          telefono='".mysqli_real_escape_string($mysqli,strtoupper($_POST["Telefono"]))."',
          correo='".mysqli_real_escape_string($mysqli,strtoupper($_POST["Correo"]))."',
          observaciones='".mysqli_real_escape_string($mysqli,$_POST["Observaciones"])."' ,
          desplazamiento='".mysqli_real_escape_string($mysqli,$_POST["Desplazamiento"])."'  ,
          unidad='".mysqli_real_escape_string($mysqli,$_POST["Unidad"])."',
          sector='".mysqli_real_escape_string($mysqli,$_POST["Sector"])."' ,
          Departamento='".mysqli_real_escape_string($mysqli,$_POST["Departamento"])."' ,
          tipoagente='".mysqli_real_escape_string($mysqli,$_POST["TipoAgente"])."',
          estadoagente='".mysqli_real_escape_string($mysqli,$_POST["Estado"])."' ,
          unidad_negocio= '".mysqli_real_escape_string($mysqli,$_POST["unidadNeg"])."'
          WHERE cons='".mysqli_real_escape_string($mysqli,$_POST["codigoc"])."' "; 

// -- codempresa='".mysqli_real_escape_string($mysqli,$_POST["Empresa"])."'  ,
  if( $datos=mysqli_query($mysqli,$consulta)){  
  
  $consultax=" UPDATE usuarios SET 
  pass='".mysqli_real_escape_string($mysqli,$_POST["Pass"])."' ,
  estado='".mysqli_real_escape_string($mysqli,$_POST["Estado"])."' ,
  nombre='".mysqli_real_escape_string($mysqli,strtoupper($_POST["Nombre"]))."'  ,
  imei='".mysqli_real_escape_string($mysqli,strtoupper($_POST["Imei"]))."' 
  WHERE usuario='".mysqli_real_escape_string($mysqli,$_POST["Usuario"])."' ";  
  $datosx=mysqli_query($mysqli,$consultax);

            echo 'OK';
          }else{
            echo 'No se ha podido actualizar el Agente';
          }
 
}

function buscar($mysqli){
  $consulta=" SELECT   f.nombre,f.usuario,pass,telefono,correo,u.estado,f.codempresa,observaciones, f.cons,f.desplazamiento,f.unidad,f.sector,f.Departamento,u.imei,f.tipoagente, f.unidad_negocio FROM agentes f 
 INNER JOIN usuarios u ON f.usuario=u.usuario WHERE 
  f.cons='".mysqli_real_escape_string($mysqli,$_POST["Buscar_Datos"])."' "; 

  $datos=mysqli_query($mysqli,$consulta);
  if(mysqli_num_rows($datos)>0){   
  $row=mysqli_fetch_row($datos);      

  echo 's§'.$row[0].'§'.$row[1].'§'.$row[2].'§'.$row[3].'§'.$row[4].'§'.$row[5].'§'.$row[6].'§'.$row[7].'§'.$row[8].'§'.$row[9].'§'.$row[10].'§'.$row[11].'§'.$row[12].'§'.$row[13].'§'.$row[14].'§'.$row[15];
            
  }else{
    echo 'No se encontro resultado';
  }

}

function Listar($mysqli){
//e.nombre, position:6
//if($_POST["Listar"]=="OK")

if($_POST["Listado_dpto"] =="" && $_POST["Listado_UniNeg"] == "")
{
       //   $consulta=" SELECT  f.cons,f.nombre,u.usuario,f.telefono,f.Departamento,u.estado,z.nombre FROM (((agentes f inner join empresas e on f.codempresa=e.cons)inner join usuarios u on u.usuario=f.usuario)inner join zonas z on z.codigo=f.sector)  ORDER BY e.nombre,f.nombre  "; 
         $consulta= " SELECT  f.cons,f.nombre,u.usuario,f.telefono,f.Departamento,f.unidad_negocio,u.estado,f.sector,z.nombre
         FROM ((agentes f INNER JOIN usuarios u ON u.usuario=f.usuario) 
         INNER JOIN zonas z ON z.codigo=f.sector) ORDER BY f.nombre ";
   
}

else if ( !empty($_POST["Listado_dpto"]) && $_POST["Listado_UniNeg"] == "") 
{
         // $consulta=" SELECT  f.cons,f.nombre,u.usuario,f.telefono,f.Departamento,u.estado,e.nombre,z.nombre FROM (((agentes f inner join empresas e on f.codempresa=e.cons)inner join usuarios u on u.usuario=f.usuario)inner join zonas z on z.codigo=f.sector) where  e.cons='".mysqli_real_escape_string($mysqli,$_POST["Listar"])."'  ORDER BY e.nombre,f.nombre  ";
         $consulta=" SELECT  f.cons,f.nombre,u.usuario,f.telefono,f.Departamento,f.unidad_negocio,u.estado,f.sector,z.nombre
         FROM ((agentes f INNER JOIN usuarios u ON f.usuario = u.usuario)
         INNER JOIN zonas z ON z.codigo=f.sector) 
         where  f.Departamento='".mysqli_real_escape_string($mysqli,$_POST["Listado_dpto"])."'
         ORDER BY f.nombre  ";  
}

else if ( $_POST["Listado_dpto"] == "" &&  !empty($_POST["Listado_UniNeg"]) ) 
{
         // $consulta=" SELECT  f.cons,f.nombre,u.usuario,f.telefono,f.Departamento,u.estado,e.nombre,z.nombre FROM (((agentes f inner join empresas e on f.codempresa=e.cons)inner join usuarios u on u.usuario=f.usuario)inner join zonas z on z.codigo=f.sector) where  e.cons='".mysqli_real_escape_string($mysqli,$_POST["Listar"])."'  ORDER BY e.nombre,f.nombre  ";
         $consulta=" SELECT  f.cons,f.nombre,u.usuario,f.telefono,f.Departamento,f.unidad_negocio,u.estado,f.sector,z.nombre
         FROM ((agentes f INNER JOIN usuarios u ON f.usuario = u.usuario)
         INNER JOIN zonas z ON z.codigo=f.sector) 
         where  f.unidad_negocio='".mysqli_real_escape_string($mysqli,$_POST["Listado_UniNeg"])."'
         ORDER BY f.nombre  ";  
}




else if ( !empty($_POST["Listado_dpto"]) && !empty($_POST["Listado_UniNeg"])  ) 
{
         // $consulta=" SELECT  f.cons,f.nombre,u.usuario,f.telefono,f.Departamento,u.estado,e.nombre,z.nombre FROM (((agentes f inner join empresas e on f.codempresa=e.cons)inner join usuarios u on u.usuario=f.usuario)inner join zonas z on z.codigo=f.sector) where  e.cons='".mysqli_real_escape_string($mysqli,$_POST["Listar"])."'  ORDER BY e.nombre,f.nombre  ";
         $consulta=" SELECT  f.cons,f.nombre,u.usuario,f.telefono,f.Departamento,f.unidad_negocio,u.estado,f.sector,z.nombre
         FROM ((agentes f INNER JOIN usuarios u ON f.usuario = u.usuario)
         INNER JOIN zonas z ON z.codigo=f.sector) 
         where  f.Departamento='".mysqli_real_escape_string($mysqli,$_POST["Listado_dpto"])."'
        AND f.unidad_negocio='".mysqli_real_escape_string($mysqli,$_POST["Listado_UniNeg"])."'  ORDER BY f.nombre  ";  
} 

$datos=mysqli_query($mysqli,$consulta);
//   <th >Empresa</th>
          $tabla='<table id="example" class="display dataTable" cellspacing="0" width="100%" style="font-size: 12px; width: 100%;" role="grid" aria-describedby="example_info">
        <thead>
          <tr>
       
          <th >Nombre</th>
          <th >Usuario</th>
          <th >Telefono</th>
          <th >Departamento</th>
          <th >Unidad Negocio</th>
          <th >Sector</th>
          <th >Estado</th> 
          <th ></th></tr></tr>
        </thead><tfoot>
          <tr>
     
          <th >Nombre</th>        
          <th >Usuario</th>
          <th >Telefono</th>
          <th >Departamento</th>
          <th >Unidad Negocio</th>
          <th >Sector</th>
          <th >Estado</th>
          <th ></th></tr>
        </tfoot>  <tbody> ';          

       
          if(mysqli_num_rows($datos)>0){           
while($row=mysqli_fetch_row($datos)){ 

              if($row[5]=='Inactivo'){
                $st='style="background-color:#FFBABA; color:#D8000C;"';
              }else{
                $st='style="background-color:#B3FFBA; color:#33D100;"';
              }

              $tabla.='<tr role="row" class="odd">    
             
            <td class="sobretd" id="'.$row[0].'" >'.$row[1].'</td>
            <td class="sobretd" id="'.$row[0].'" >'.$row[2].'</td>
            <td class="sobretd" id="'.$row[0].'" >'.$row[3].'</td>
            <td style="padding-left: 20px;" class="sobretd" id="'.$row[0].'" >'.$row[4].'</td>
            <td style="padding-left: 20px;" class="sobretd" id="'.$row[0].'" >'.$row[5].'</td> 
            <td class="sobretd" id="'.$row[0].'" >'.$row[7].'</td> 
            <td class="sobretd" id="'.$row[0].'"  '.$st.' >'.$row[6].'</td>
            <td class="sobretd" id="'.$row[0].'" ><button type="button" class="btn btn-success btn-circle" onclick="Buscar_Datos('.$row[0].');"><i class="fa fa-edit"></i></button></td>
          </tr>';
            }
            //<td class="sobretd sorting_1" id="'.$row[0].'" >'.$row[6].'</td>             
          }                          

          $tabla.='</tbody></table>';             

          echo $tabla;
}

mysqli_close($mysqli);
?>