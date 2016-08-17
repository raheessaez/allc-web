<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
$OPC=$_GET["OPC"];
$FOLDER="../../../ARTS/TSLRecords/errorTlogs/";
$FOLDER_DEST="../../../ARTS/TSLRecords/";
$TLOGS_FILES=scandir($FOLDER);
$COUNT_FILES=count($TLOGS_FILES);
$FLAG_DONE_RENAME=0;
$FLAG_ERROR_RENAME=0;
$FLAG_DONE_UNLINK=0;
$FLAG_ERROR_UNLINK=0;
foreach($TLOGS_FILES as $FILE)
{
	if(strpos($FILE,".xml")!=false)
	{
		if(rename($FOLDER.$FILE,$FOLDER_DEST.$FILE))
		{
			if(unlink($FOLDER.$FILE))
			{
				$FLAG_DONE_RENAME++;
				$FLAG_DONE_UNLINK++;
			}
			else
			{
				$FLAG_ERROR_RENAME++;
				$FLAG_ERROR_UNLINK++;
			}
		}
		else
		{
			$FLAG_ERROR_RENAME++;
		}
	}
}
if($FLAG_DONE_RENAME==$COUNT_FILES and $FLAG_DONE_UNLINK==$COUNT_FILES)
{
	echo "TLOGS Movidos correctamente, el reproceso de los archivos deber&iacute;a reflejarse en unos minutos. En caso de que la información continue siendo diferente en el controlador y en la Suite, contactar a soporte.";
}
elseif($FLAG_ERROR_RENAME!=0 or $FLAG_ERROR_UNLINK!=0)
{
	if($FLAG_ERROR_RENAME)
	$POS_FILE=$FLAG_ERROR_RENAME-1;
	
	if($FLAG_ERROR_UNLINK)
	$POS_FILE=$FLAG_ERROR_UNLINK-1;
	echo "Error en reproceso del archivo :".$TLOGS_FILES[$POS_FILE];
}
elseif($FLAG_ERROR_RENAME==0 or $FLAG_ERROR_UNLINK==0)
{
	echo "No existen archivos a reprocesar";
}
?>