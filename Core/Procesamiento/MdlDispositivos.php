<?php
//error_reporting(E_ERROR | E_PARSE);
require_once("Conexion.php");

  if( isset($_POST["Ingresar"]) ){
		Ingresar($mysqli);							
	}else if(isset($_POST["Listar"])){
    Listar($mysqli);
  }else if(isset($_POST["Buscar_Datos"])){
    buscar($mysqli);
  }else if(isset($_POST["Actualizar"])){
    Actualizar($mysqli);
  }else if(isset($_POST["cambioEmpresa"])){
    cambioEmpresa($mysqli);
  }
			
      function cambioEmpresa($mysqli){ 
// where codempresa='".mysqli_real_escape_string($mysqli,$_POST["cambioEmpresa"])."' 
$consulta="SELECT cons,nombre FROM agentes   
   ORDER BY nombre ";  
   $datos=mysqli_query($mysqli,$consulta);
    echo '<option  selected="selected" value="No">No Asignado</option> ';           
      while($row=mysqli_fetch_row($datos)){                           
          echo '<option   value="'.$row[0].'">'.$row[1].'</option>';  
      }



      }



function Ingresar($mysqli){

$consulta2=" SELECT  Estado FROM dispositivos WHERE 
Seriald='".mysqli_real_escape_string($mysqli,$_POST["Serial"])."' "; 
 $datos2=mysqli_query($mysqli,$consulta2);
  if(mysqli_num_rows($datos2)>0){
    echo 'Este Serial ya fue ingresado';          
  }else{
         $consulta=" INSERT INTO dispositivos (Agente,Seriald,Estado,Numero,Fecha,Observaciones,Departamento) VALUES (
    
          
         '".mysqli_real_escape_string($mysqli,($_POST["Agente"]))."',
         '".mysqli_real_escape_string($mysqli,strtoupper($_POST["Serial"]))."',
         '".mysqli_real_escape_string($mysqli,($_POST["Estado"]))."',
         '".mysqli_real_escape_string($mysqli,strtoupper($_POST["Numero"]))."',
         '".mysqli_real_escape_string($mysqli,($_POST["Fecha"]))."',
         '".mysqli_real_escape_string($mysqli,strtoupper($_POST["Observaciones"]))."',
         '".mysqli_real_escape_string($mysqli,strtoupper($_POST["Departamento"]))."')
     ";              
          if( $datos=mysqli_query($mysqli,$consulta) ){      
            echo 'OK';
          }else{
            echo 'No se ha podido Ingresar el Funcionario***';
          }
        }
}

function Actualizar($mysqli){


        
$consulta2=" SELECT  Estado FROM dispositivos WHERE 
Seriald='".mysqli_real_escape_string($mysqli,$_POST["Serial"])."' and
not cons='".mysqli_real_escape_string($mysqli,$_POST["codigoc"])."' "; 


//Empresa='".mysqli_real_escape_string($mysqli,$_POST["Empresa"])."' and
 $datos2=mysqli_query($mysqli,$consulta2);
  if(mysqli_num_rows($datos2)>0){
    echo 'Este Serial ya fue ingresado';          
  }else{
         $consulta=" UPDATE dispositivos SET   
        
         Agente='".mysqli_real_escape_string($mysqli,($_POST["Agente"]))."',
         Seriald='".mysqli_real_escape_string($mysqli,strtoupper($_POST["Serial"]))."',
         Estado= '".mysqli_real_escape_string($mysqli,($_POST["Estado"]))."',
         Numero='".mysqli_real_escape_string($mysqli,strtoupper($_POST["Numero"]))."',
         Fecha='".mysqli_real_escape_string($mysqli,($_POST["Fecha"]))."',
         Observaciones='".mysqli_real_escape_string($mysqli,strtoupper($_POST["Observaciones"]))."' ,
         Departamento='".mysqli_real_escape_string($mysqli,strtoupper($_POST["Departamento"]))."'
        WHERE CONS='".mysqli_real_escape_string($mysqli,($_POST["codigoc"]))."'  ";     

          if( $datos=mysqli_query($mysqli,$consulta) ){         
            echo 'OK';
          }else{
            echo 'No se ha podido Ingresar el Funcionario';
          }
        }
 
}

function buscar($mysqli){
  $consulta=" SELECT  Agente,Seriald,Departamento,Numero,Fecha,Estado,Observaciones,cons  FROM dispositivos WHERE 
 cons='".mysqli_real_escape_string($mysqli,$_POST["Buscar_Datos"])."' "; 

  $datos=mysqli_query($mysqli,$consulta); 
  if(mysqli_num_rows($datos)>0){ 
  $row=mysqli_fetch_row($datos); 

  echo 's§'.$row[0].'§'.$row[1].'§'.$row[2].'§'.$row[3].'§'.$row[4].'§'.$row[5].'§'.$row[6].'§'.$row[7]; 
            
  }else{
    echo 'No se encontro resultado'; 
  }

}

function Listar($mysqli){

  if ($_POST["Listado_UniNeg"] == "" && !empty($_POST["Listado_dpto"]) ) 
  {
      $consulta = " SELECT d.cons,a.nombre,d.Seriald,d.Numero,d.Fecha,d.Estado,d.Observaciones, d.Departamento FROM 
          dispositivos d  LEFT JOIN agentes a ON d.Agente=a.cons 
          WHERE d.Departamento ='".mysqli_real_escape_string($mysqli, $_POST["Listado_dpto"])."'
          ORDER BY a.nombre,d.Seriald  ";        

  }

 else if ( !empty($_POST["Listado_dpto"]) && !empty($_POST["Listado_UniNeg"])  ) 

 {

    $consulta = " SELECT d.cons,a.nombre,d.Seriald,d.Numero,d.Fecha,d.Estado,d.Observaciones, d.Departamento FROM 
    dispositivos d  LEFT JOIN agentes a ON d.Agente=a.cons 
    WHERE d.Departamento ='".mysqli_real_escape_string($mysqli, $_POST["Listado_dpto"])."'
    ORDER BY a.nombre,d.Seriald  ";            

 }

else 
{
/*
            $consulta="SELECT d.cons,e.nombre,a.nombre,d.Seriald,d.Numero,d.Fecha,d.Estado,d.Observaciones, d.Departamento FROM 
((dispositivos d INNER JOIN empresas e ON e.cons=d.Empresa) LEFT JOIN agentes a ON a.cons=d.Agente) ORDER BY e.nombre,a.nombre,d.Seriald  "; 
*/
        /*$consulta = " SELECT d.cons,a.nombre,d.Seriald,d.Numero,d.Fecha,d.Estado,d.Observaciones, d.Departamento FROM 
                      dispositivos d  LEFT JOIN agentes a ON a.cons=d.Agente ORDER BY a.nombre,d.Seriald"; */
//}else{  
/*
       $consulta="SELECT d.cons,e.nombre,a.nombre,d.Seriald,d.Numero,d.Fecha,d.Estado,d.Observaciones, d.Departamento FROM 
((dispositivos d INNER JOIN empresas e ON e.cons=d.Empresa) LEFT JOIN agentes a ON a.cons=d.Agente) WHERE  
     e.cons='".mysqli_real_escape_string($mysqli,$_POST["Listar"])."'  ORDER BY e.nombre,a.nombre,d.Seriald  "; 
*/
        $consulta = " SELECT d.cons,a.nombre,d.Seriald,d.Numero,d.Fecha,d.Estado,d.Observaciones, d.Departamento FROM 
        dispositivos d  LEFT JOIN agentes a ON d.Agente=a.cons  ORDER BY a.nombre,d.Seriald  ";          
   
}      

 

 
    $datos=mysqli_query($mysqli,$consulta);
//<th >Empresa</th>
          $tabla='<table id="example" class="display dataTable" cellspacing="0" width="100%" style="font-size: 12px; width: 100%;" role="grid" aria-describedby="example_info">
        <thead>
          <tr>
            
          <th >Agente</th>
          <th >Serial</th>
          <th >Numero</th>
          <th >Fecha</th>
          <th >Estado</th>
          <th >Departamento</th>
          <th ></th></tr></tr>
        </thead><tfoot>
          <tr>
      
          <th >Agente</th>  
          <th >Serial</th>
          <th >Numero</th>
          <th >Fecha</th> 
          <th >Estado</th>
          <th >Departamento</th>
          <th ></th></tr>
        </tfoot>  <tbody> ';

       // echo $datos;
          if(mysqli_num_rows($datos)>0){            
while($row=mysqli_fetch_row($datos)){   

              if($row[5]=='Inactivo'){
                $st='style="background-color:#FFBABA; color:#D8000C;"';
              }else{           
                $st='style="background-color:#B3FFBA; color:#33D100;"';
              }        
                      
            if($row[2]=='' || $row[2]=='No'){    
                $row[2]='No Asignado';                
              }              
    
              $tabla.='<tr role="row" class="odd">
                  
            <td class="sobretd" id="'.$row[0].'" >'.$row[1].'</td>     
            <td class="sobretd" id="'.$row[0].'" >'.$row[2].'</td>  
            <td class="sobretd" id="'.$row[0].'" >'.$row[3].'</td>   
            <td class="sobretd" id="'.$row[0].'" >'.$row[4].'</td>  
            <td class="sobretd" id="'.$row[0].'" >'.$row[5].'</td>
            <td class="sobretd" id="'.$row[0].'" >'.$row[7].'</td>        
            <td class="sobretd" id="'.$row[0].'" ><button type="button" class="btn btn-success btn-circle" onclick="Buscar_Datos('.$row[0].');"><i class="fa fa-edit"></i></button></td>
          </tr>';
            }
            
          }
//  <td class="sobretd" id="'.$row[0].'" >'.$row[1].'</td> position 1
          $tabla.='</tbody></table>';
 
          echo $tabla;
}

mysqli_close($mysqli);    
?>