<?php
require_once("Conexion.php");
session_start(); 


	if(!empty($_POST["Guardar"])){
		Guardar($mysqli);
	}else if(!empty($_POST["Listar"])){
		ListaEnviadas($mysqli);
	}else if(!empty($_POST["Editar"])){
		Editar($mysqli);
	}else if(!empty($_POST["Actulizar"])){
		Actualizar($mysqli);
	}else if(!empty($_POST["Eliminar"])){
		Eliminar($mysqli);
	}else if(!empty($_POST["ListaRecibidas"])){
		ListaRecibidas($mysqli);
	}else{
		echo "Archivo Erroneo";	
	}		

	//*** Funcion listar todas las noticias
	function ListaRecibidas($mysqli){

		 $consulta="SELECT n.cons,n.encabezado,n.rango,n.fechacarga,n.usuariocarga,a.nombre FROM 
		notificaciones n left join agentes a on a.usuario=n.usuariocarga
		where rango='".mysqli_real_escape_string($mysqli,$_POST["Listaruser"])."' ORDER BY cons ASC ";
		$datos=mysqli_query($mysqli,$consulta);
		$tabla='<table id="exampleEntrantes" class="display" cellspacing="0" width="100%" style="font-size:12px; text-align:left;">
				<thead>
					<tr>
					<th width="1%">Cons</th>
						<th >Encabezado</th>
					    <th  width="80">Fecha</th>
						<th  width="80">Remitente</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th width="1%">Cons</th>
						<th >Encabezado</th>
					    <th  width="80">Fecha</th>
						<th  width="80">Remitente</th>
					</tr>
				</tfoot>	
				<tbody>';	
		
				$count=1;    
				while($row=mysqli_fetch_row($datos)){ 

			   	$tabla .='<tr>
			            <td class="sobretd text-left" tittle="'.$row[0].'">'.$count.'</td>
			            <td class="sobretd text-left" tittle="'.$row[0].'">'.$row[1].'</td>';
						
						if($row[2]==''){
							$archivo='Todos';
						}else{
							$archivo=$row[5];
						}
	


				$tabla.='
						<td class="sobretd text-left" tittle="'.$row[0].'">'.$row[3].'</td><td class="sobretd text-left" tittle="'.$row[0].'">'.$archivo.'</td>
						
					</tr>';
								
					$count++;
				}

			$tabla.="</tbody></table>";

			echo $tabla;

	}





	//*** Guardar Noticias
	function Guardar($mysqli){



  			$consulta="INSERT notificaciones (encabezado,rango,descripcion,usuariocarga,codempresa,fechacarga,tipo) VALUES(
  			'".mysqli_real_escape_string($mysqli,strtoupper($_POST["titulo"]))."',
  			'".mysqli_real_escape_string($mysqli,($_POST["rango"]))."',
  			'".mysqli_real_escape_string($mysqli,strtoupper($_POST["descripcion"]))."',
  			'".mysqli_real_escape_string($mysqli,($_POST["codusuario"]))."',
  			'".mysqli_real_escape_string($mysqli,($_POST["codcode"]))."',now(),'Entrada')";            
          if( $datos=mysqli_query($mysqli,$consulta) ){ 
            echo 'OK';
			if($_POST["rango"]!=""){
				 $consulta="SELECT token_notif FROM agentes where 
			usuario='".mysqli_real_escape_string($mysqli,$_POST["rango"])."' ";
			}else{
				 $consulta="SELECT token_notif FROM agentes where 
			codempresa='".mysqli_real_escape_string($mysqli,$_POST["codcode"])."'";
			}


$datos=mysqli_query($mysqli,$consulta);		
while($row=mysqli_fetch_row($datos)){ 
	 sendGCM(strtoupper($_POST["descripcion"]), strtoupper($_POST["titulo"]), $row[0]);
}

          }else{
            echo 'Error';
          }			
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




	//*** Funcion listar todas las noticias
	function ListaEnviadas($mysqli){

		 $consulta="SELECT n.cons,n.encabezado,n.rango,n.fechacarga,n.usuariocarga,a.nombre FROM 
		notificaciones n left join agentes a on a.usuario=n.rango
		where usuariocarga='".mysqli_real_escape_string($mysqli,$_POST["Listaruser"])."' ORDER BY cons ASC ";
		$datos=mysqli_query($mysqli,$consulta);
		$tabla='<table id="example" class="display" cellspacing="0" width="100%" style="font-size:12px; text-align:left;">
				<thead>
					<tr>
					<th width="1%">Cons</th>
						<th >Encabezado</th>
					    <th  width="80">Fecha</th>
						<th  width="80">Remitente</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th width="1%">Cons</th>
						<th >Encabezado</th>
					    <th  width="80">Fecha</th>
						<th  width="80">Remitente</th>
					</tr>
				</tfoot>	
				<tbody>';	
		
				$count=1;    
				while($row=mysqli_fetch_row($datos)){ 

			   	$tabla .='<tr>
			            <td class="sobretd text-left" tittle="'.$row[0].'">'.$count.'</td>
			            <td class="sobretd text-left" tittle="'.$row[0].'">'.$row[1].'</td>';
						
						if($row[2]==''){
							$archivo='Todos';
						}else{
							$archivo=$row[5];
						}
	


				$tabla.='
						<td class="sobretd text-left" tittle="'.$row[0].'">'.$row[3].'</td><td class="sobretd text-left" tittle="'.$row[0].'">'.$archivo.'</td>
						
					</tr>';
								
					$count++;
				}

			$tabla.="</tbody></table>";

			echo $tabla;

	}




?>