<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Documento sin título</title>

</head>

<body>
<form>
	
  <legend>Registro Archivos
    <br>

  <table>
   <tr>
     <td><strong>Nombre</strong></td>
     <td><strong>Enlace</strong></td>
   </tr>
 

 <?php 
				$directorio = "xml";
 

				$archivos = scandir($directorio);
					
				foreach ($archivos as $archivo) {
						if (strpos($archivo, ".xml") !== false) {
							
							 ?>
        <form action="prueba1.php" method="POST" name="form">
							<tr>
										 
									<td> <input type="text" name="FILE" value="<?php echo "$archivo"; ?>" /></td>
									
									<td> <input type="submit" value="Submit"></td>
								
							</tr>
          </form>
							
							<?php
								
						}
				}
					
   ?>

	

 
 </table>


        <br>
        <br>
      </legend>

	
</form>
</body>

</html>
