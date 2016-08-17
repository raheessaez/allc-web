<?php
$BDIP = "200.27.205.250";
$db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = ".$BDIP.")(PORT = 1521)))(CONNECT_DATA=(SID=xe)))" ;
		$conn = oci_connect( "PACE_EC" ,"PACE_EC", $db);
		$SQL="ALTER SESSION SET nls_date_format='DD-MM-YYYY'";
		$RS = oci_parse($conn, $SQL);
		oci_execute($RS);

function enco($str)
{
	$cadena=str_replace("|csimple|","'",$str);
	$cadena=str_replace("|cdoble|",'"',$cadena);
	$cadena=str_replace (  "|mnq|", "<",$cadena); 
	$cadena=str_replace (  "|myq|",">", $cadena);
	$cadena=str_replace ( "|plus|",  "+",$cadena);
	$cadena=str_replace (  "|apar|","(", $cadena);
	$cadena=str_replace (  "|cpar|", ")",$cadena);
	$cadena=str_replace (  "|igual|","=", $cadena);
	$cadena=str_replace (  "|menos|","-", $cadena);
	$cadena=str_replace ( "|coma|",",",  $cadena);
	$cadena=str_replace ( "|punto|", ".", $cadena);
	$cadena=str_replace ( "|pcoma|", ";", $cadena);
	$cadena=str_replace ( "|acorch|", "[", $cadena);
	$cadena=str_replace ( "|ccorch|", "]", $cadena);
	$cadena = str_replace( '|slash|', '/',$cadena);
	$cadena = str_replace('|bslash|', '\\', $cadena);
	$cadena=str_replace ("|apre|", "?",  $cadena);
	$cadena=str_replace ("|cpre|",  "¿", $cadena);
	$cadena=str_replace ( "|porc|", "%", $cadena);
	return $cadena;
}

$res="//****************************************************************************<br>";
$res.="// PERSONALIZATION PARAMETER VALUES<br>";
$res.="//<br>";
$res.="// FROM: <"."$"."AMOPTNS><br>";
$res.="// DATE: 04/28/16 01:31p<br>";
$res.="//****************************************************************************<br>";

$res.="[INIControl]<br>";
$res.="File = OPT, FileNames, File0<br>";
$res.="Menu = MainMenu<br>";
$res.="Validate = InputValidation<br>";
$res.="Link = LinkedINIandOptionFiles<br>";
$res.="RestoreMenus = True<br><br>";

$res.="[FileNames]<br>";
$res.="OptionsFile = eamoptns<br>";
$res.="StoreReadFile = "."<"."$"."AMOPTNS><br>";
$res.="StoreWriteFile = "."<"." EAMOPTNS ".">"."<br>";
$res.="TerminalReadFile = <"."$"."AMO:><br>";
$res.="TerminalWriteFile = "."<"." EAMO: ".">"."<br>";
$res.="GroupReadFile = <"."$"."AMOG:><br>";
$res.="GroupWriteFile = "."<"." EAMOG: ".">"."<br>";
$res.="hppFile = incoptns.hpp<br>";
$res.="dumpFileExtension = txt<br>";
$res.="terminalIndicator = **%TRM**<br>";
$res.="grantFile = optgrant.ini<br>";
$res.="saveINIFile = eamoptns.ini<br>";
$res.="authorizationFile = optlevel.ini<br>";
$res.="authorizations = "." <"." ACEAUTHZ ".">"."<br>";

$guardar="//****************************************************************************  \r\n";
$guardar.="// PERSONALIZATION PARAMETER VALUES  \r\n";
$guardar.="//  \r\n";
$guardar.="// FROM: <"."$"."AMOPTNS>  \r\n";
$guardar.="//DATE: 05/03/16 08:31p  \r\n";
$guardar.="//****************************************************************************  \r\n  \r\n";

$guardar.="[INIControl]  \r\n";
$guardar.="File = OPT, FileNames, File0  \r\n";
$guardar.="Menu = MainMenu  \r\n";
$guardar.="Validate = InputValidation  \r\n";
$guardar.="Link = LinkedINIandOptionFiles  \r\n";
$guardar.="RestoreMenus = True  \r\n  \r\n";

$guardar.="[FileNames]  \r\n";
$guardar.="OptionsFile = eamoptns  \r\n";
$guardar.="StoreReadFile = <"."$"."AMOPTNS>  \r\n";
$guardar.="StoreWriteFile = <EAMOPTNS>  \r\n";
$guardar.="TerminalReadFile = <"."$"."AMO:>  \r\n";
$guardar.="TerminalWriteFile = <EAMO:>  \r\n";
$guardar.="GroupReadFile = <"."$"."AMOG:>  \r\n";
$guardar.="GroupWriteFile = <EAMOG:>  \r\n";
$guardar.="hppFile = incoptns.hpp  \r\n";
$guardar.="dumpFileExtension = txt  \r\n";
$guardar.="terminalIndicator = **%TRM**  \r\n";
$guardar.="grantFile = optgrant.ini\n";
$guardar.="saveINIFile = eamoptns.ini  \r\n";
$guardar.="authorizationFile = optlevel.ini  \r\n";
$guardar.="authorizations = <ACEAUTHZ>  \r\n";


$CONSULTA="SELECT * FROM PACE_EN where IDEN > 2 order by IDEN ASC";
$RS = oci_parse($conn, $CONSULTA);
oci_execute($RS);

while ($row = oci_fetch_assoc($RS)){

	$IDEN = $row['IDEN'];
	$DESCRIPCION = enco($row['DESCRIPCION']);
	$CONSULTA2="SELECT * FROM PACE_CAMPO WHERE ID_PADRE = ".$IDEN." order by COD_CAMPO ASC";
	$RS2 = oci_parse($conn, $CONSULTA2);
	oci_execute($RS2);

	$res.="<br>".$DESCRIPCION."<br>";
	$guardar.="  \r\n".trim($DESCRIPCION)."  \r\n";



	while ($row2 = oci_fetch_assoc($RS2)){

			$COD_CAMPO = $row2['COD_CAMPO'];
			$NOMBRE_CAMPO = enco($row2['NOMBRE_CAMPO']);
			$ID_CAMPO = $row2['ID_CAMPO'];
			
			$TIPO_CAMPO = $row2['TIPO_CAMPO'];
			$TIPO_CAMPO = trim($TIPO_CAMPO);

			$LARGO_CAMPO = $row2['LARGO_CAMPO'];
			$VALOR = $row2['VALOR'];
			$VALOR = trim($VALOR);

			if(strcmp($TIPO_CAMPO,"RECORD") == 0){
				$res.=$NOMBRE_CAMPO." = ".$ID_CAMPO.", ".$TIPO_CAMPO."<br>";
				$flag=$NOMBRE_CAMPO." = ".$ID_CAMPO.", ".$TIPO_CAMPO;
				$guardar.=trim($flag)."  \r\n";
			}
		
			if(strcmp($TIPO_CAMPO,"STRING") == 0){
				$res.=$NOMBRE_CAMPO." = ".$ID_CAMPO.", ".$TIPO_CAMPO.", ".$LARGO_CAMPO.", ".$VALOR."<br>";
				$flag=$NOMBRE_CAMPO." = ".$ID_CAMPO.", ".$TIPO_CAMPO.", ".$LARGO_CAMPO.", ".$VALOR;
				$guardar.=trim($flag)."  \r\n";
			}
			
			if(strcmp($TIPO_CAMPO,"ULONG") == 0 || strcmp($TIPO_CAMPO,"INT") == 0 || strcmp($TIPO_CAMPO,"BOOLEAN") == 0  || strcmp($TIPO_CAMPO,"UINT") == 0){
				$res.=$NOMBRE_CAMPO." = ".$ID_CAMPO.", ".$TIPO_CAMPO.", ".$VALOR."<br>";
				$flag=$NOMBRE_CAMPO." = ".$ID_CAMPO.", ".$TIPO_CAMPO.", ".$VALOR;
				$guardar.=trim($flag)."  \r\n";
			}

			if(strcmp($TIPO_CAMPO,"Array") == 0){

			

				$CONSULTA3="SELECT * FROM PACE_DCAMPO WHERE ID_PADRE = ".$COD_CAMPO." order by POSICION ASC";

				$RS3 = oci_parse($conn,$CONSULTA3);
				oci_execute($RS3);

				$Contenido = "";
				$INICIO = 1;
				$SALTO = 0;
				while ($row3 = oci_fetch_assoc($RS3)){

					$TIPO = $row3['TIPO'];
					$VALOR_ARRAY = $row3['VALOR'];
					
					$TIPO = trim($TIPO);
					$DELIMITADOR = $row3['DELIMITADOR'];

					if($INICIO == 1)
					{
						$Contenido .= $VALOR_ARRAY;
						$INICIO ++;

					}else{

						if($DELIMITADOR == NULL)
						{
							
							if($SALTO == 0)
							{
								$Contenido .= ",".$VALOR_ARRAY;
							}else{

								$Contenido .= $VALOR_ARRAY;
								$SALTO = 0;
							}

						}else
						{
							$Contenido .= ", \ ".$VALOR_ARRAY.",";
							$SALTO = 1;
						}
						
					}

					

			}		
			$res.=$NOMBRE_CAMPO." = ".$ID_CAMPO.", ".$TIPO_CAMPO.", ".$TIPO.", ".$LARGO_CAMPO.", ".$Contenido."<br>";
					$flag=$NOMBRE_CAMPO."= ".$ID_CAMPO.", ".$TIPO_CAMPO.", ".$TIPO.", ".$LARGO_CAMPO.",".$Contenido;
					$guardar.=trim($flag)."  \r\n";
			
	}
			
			
	}


}
echo $res;
$fp = fopen('OUT/EAMOPTNS.INI', 'w+');
fwrite($fp, $guardar);
fclose($fp);



?>