<?php 
require("db_controller/mysql_script.php");

include("tools.php"); //funciones adicionales

$obj = (object)$_REQUEST;

switch ($obj->action) {
	case 'registerFile':

		$files = $_FILES['uploaded_file'];

		if (isset($files)){ //Verificamos que exista almenos un archivo a registrar
		    $fileCount = count($files["name"]);
		    for( $i=0; $i<$fileCount; $i++ ){
				$referencia = $obj->referencia[$i];
			    $nameFile = basename( removeAcentos($files["name"][$i]) ); //Tomamos el nombre de cada archivo
				$fech_registro = date("Y-m-d H:i:s");
				
				$r = query("INSERT INTO fichero (referencia,filename,fech_registro)
							VALUES('{$referencia}','{$nameFile}','{$fech_registro}')");

				if($r>0){
					echo $nameFile." <i style='color:blue;'>Registrado con exito en Mysql</i>";
				}else{
					echo $nameFile." <i style='color:red;'>Error al registrar</i>";
				}
				echo "<br>"; //salto de linea
		    }
		}
		
		//Ejcutamos el archivo de "upload_file.php"
		require("upload_file.php");
		break;
	
	default:
		echo "Lo sentimos, consulta incorrecta";
		break;
}

?>