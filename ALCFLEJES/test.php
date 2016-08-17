<?php include("conecta.inc"); ?>
<?php
					echo $_SERVER['DOCUMENT_ROOT']."<br><br><br>";	
					
					$directorio = opendir("..");
					while ($archivo = readdir($directorio))
					   {
					   $nombreArch = ucwords($archivo);
					   echo "&nbsp;$nombreArch<br>";
					   }
					closedir($directorio); 
					echo "<br><br>";
					$directorio = opendir(".");
					while ($archivo = readdir($directorio))
					   {
					   $nombreArch = ucwords($archivo);
					   echo "&nbsp;$nombreArch<br>";
					   }
					closedir($directorio); 
					
					echo "<br><br>";
					echo $DIR_SAP."IN/test.txt<br>";
					echo $SYNC_IN.$NUM_LOCAL."/insap/"."test.txt<br><br>";
					
					copy($DIR_SAP."IN/test.txt", $SYNC_IN.$NUM_LOCAL."/insap/"."test.txt");
					
	
?>


