<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Subir Archivo</title>
	<script src="js/jquery-1.9.1.js"></script>
</head>
<body>
	<center>
		<h3>Upload File Ajax Multiple Mysql</h3>
		<a href="archivos_registrados.php">Ver archivos Registrados</a>
		<br><br>
	    <input id="upload_file" type="file" multiple onchange="readSize(this)"/>
		<br>
		Progress: <progress value="0"></progress>		
	    <br><br>
	    <button onclick="uploadExecute()">Registrar y Subir Archivos</button>
		<br>
		<ul id='filesAdj' style="list-style:none;"></ul>

		<hr>

		<div id="resultsList"></div>
	</center>
	<script>
		var file, formData;
		function readSize(){
			$("#filesAdj").html("");
			file = document.getElementById("upload_file").files;

			for( var i=0;i<=file.length-1;i++ ){
				$("#filesAdj").append("<li>FileName: "+file[i].name +", Size:"+file[i].size+"</li>");
			}

		}
		function uploadExecute(){
			formData = new FormData();
			for( var i=0;i<=file.length-1;i++ ){
				formData.append("action", "registerFile");
				formData.append("referencia[]", "referencia de prueba "+ (parseInt(i)+1) );
				formData.append("uploaded_file[]", file[i]);
			}
            formData.append("enctype",'multipart/form-data');

		    $.ajax({
		        // Dirección del archivo a ejecutar en el servidor
		        url: 'consultas.php',
		        type: 'POST',
		        data: formData, //adjuntamos el paquete
		        cache: false,
		        contentType: false,
		        processData: false,

		        // Configuración Personalizada XMLHttpRequest
		        xhr: function() {
		            var myXhr = $.ajaxSettings.xhr();
		            if (myXhr.upload) {
		                // Obtenemos Progresivamente el nivel de carga del archivo
		                myXhr.upload.addEventListener('progress', function(e) {
		                    if (e.lengthComputable) {
		                    	console.log(e.loaded);
		                    	//Actualizamos la etiqueta PROGRESS segun su nivel de carga del archivo
		                        $('progress').attr({
		                            value: e.loaded,
		                            max: e.total,
		                        });
		                    }
		                } , false);
		            }
		            return myXhr;
		        },success: function(data, status, xhr) {
		        	//Imprimimos Resultados del archivo "upload_file.php" desde el servidor
				    $("#resultsList").html(data);
				}
		    }).done(function() {
		    	//Mensaje que indica que se a finalizado
			    console.log("Upload finished.");
			});
		}
	</script>
</body>
</html>