<?php 

	$path = "files/";

	$files = $_FILES['uploaded_file'];

	if (isset($files)){
	    $fileCount = count($files["name"]);

		for( $i=0; $i<$fileCount; $i++) {
		    $fileName = basename( removeAcentos($files["name"][$i]) );
			
			$ext = pathinfo($fileName, PATHINFO_EXTENSION);

			$filePath = $path.$fileName; 

			if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'][$i], $filePath)) {

				echo "<br>El archivo ".$fileName." ha sido subido [{$ext}].<br>";

				switch ($ext) {
					case 'png':
					case 'jpg':
					case 'gif':
						# Visualizamos Imagen.
						echo "<img src='files/{$fileName}' style='max-width: 400px;'>";
						break;

					case 'mp3':
						# Visualizamos Video
						echo '<audio src="files/'.$fileName.'" controls autoplay >
								<p>Tu navegador no implementa el elemento audio.</p>
								</audio>';
						break;
					case 'mp4':
						# Visualizamos Video
						echo '<video width="320" height="240" controls>
							  <source src="files/'.$fileName.'" type="video/mp4">
							Your browser does not support the video tag.
							</video>';
						break;

					case 'pdf':
						# Visualizamos PDF
						echo '<iframe src="files/'.$fileName.'" 
								style="width:600px; height:500px;" frameborder="0"></iframe>';
						break;

					default: # Si es otro formato, solo mostramos el mensaje
						echo "[Formato Desconocido en el Programa]<br>";
						break;
				}
						//preview View
				
			}else
				echo "Ha ocurrido un error, trate de nuevo!";
			
		}

	}
?>
	