<?php
require_once("Conexion.php");

  if( isset($_POST["Descargar"]) ){
		Descargar($mysqli);							
	}else if(isset($_POST["Seguimiento"])){
    Seguimiento($mysqli);
  }
			


function Seguimiento($mysqli){

     $consulta=" SELECT u.nombre,c.hora,c.especial FROM (cepodetalle  c inner join usuarios u on u.usuario=c.usuario) where  
     c.cepo='".mysqli_real_escape_string($mysqli,$_POST["CepoSeguimiento"])."'  ORDER BY c.hora desc "; 


$datos=mysqli_query($mysqli,$consulta);

          $tabla='<table id="example" class="display dataTable" cellspacing="0" width="100%" style="font-size: 12px; width: 100%;" role="grid" aria-describedby="example_info">
        <thead>
          <tr>
          <th >Cons</th>
          <th >Usuario</th>
          <th >Fecha</th>
          <th >Poliza</th>
          </tr>
          </tr>
        </thead><tfoot>
          <tr>
          <th >Cons</th>
          <th >Usuario</th>
          <th >Fecha</th>
          <th >Poliza</th>
          </tr>
        </tfoot>  <tbody> ';

       $cont=1;
          if(mysqli_num_rows($datos)>0){           
              while($row=mysqli_fetch_row($datos)){ 


                $tabla.='<tr >
              <td >'.$cont.'</td>
              <td >'.$row[0].'</td>
              <td >'.$row[1].'</td>
              <td >'.$row[2].'</td>
            </tr>';
              $cont++;
            }
            
          }

          $tabla.='</tbody></table>';

          echo $tabla;
}
   
function Descargar($mysqli){
 

    $consulta="INSERT cepodetalle(usuario,hora,lat,lon,fecha,cepo,especial) 
    values ('".mysqli_real_escape_string($mysqli,$_POST["USR"])."', now(), '', '', curdate(), 
    '".mysqli_real_escape_string($mysqli,$_POST["CepoDescarga"])."','LECTA' )"; 

  if( $datos=mysqli_query($mysqli,$consulta) ){   
        $consulta="REPLACE cepos(codigo,estado,ubica,fechaestado) 
        values (
        '".mysqli_real_escape_string($mysqli,$_POST["CepoDescarga"])."', 
        'BODEGA', 
        'LECTA',NOW())"; 
        $datos=mysqli_query($mysqli,$consulta);  
        ECHO 'OK';
  }else{
    ECHO 'N';
  }

}
mysqli_close($mysqli);
?>