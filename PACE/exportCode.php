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
$guardar="//****************************************************************************\r\n";
$guardar.="// PERSONALIZATION PARAMETER VALUES\r\n";
$guardar.="//\r\n";
$guardar.="// FROM: <"."$"."AMOPTNS>\r\n";
$guardar.="//DATE: 05/03/16 08:31p\r\n";
$guardar.="//****************************************************************************\r\n\r\n";


$CONSULTA="SELECT * FROM PACE_EN order by IDEN ASC";
$RS = oci_parse($conn, $CONSULTA);
oci_execute($RS);

while ($row = oci_fetch_assoc($RS)){

	$IDEN = $row['IDEN'];
	$DESCRIPCION = enco($row['DESCRIPCION']);
	$CONSULTA2="SELECT * FROM CAMPO WHERE ID_PADRE = ".$IDEN." order by IDE ASC";
	$RS2 = oci_parse($conn, $CONSULTA2);
	oci_execute($RS2);
	$res.=$DESCRIPCION."<br>";
	$guardar.="\r\n".trim($DESCRIPCION)."\r\n";
	while ($row2 = oci_fetch_assoc($RS2)){

			$IDE = $row2['IDE'];
			$DESCRIP = enco($row2['DESCRIP']);
			$ID_PADRE = $row2['ID_PADRE'];
			$res.=$DESCRIP."<br>";
			$guardar.=trim($DESCRIP)."\r\n";
	}
}
echo $res;
$fp = fopen('OUT/EAMOPTNS.INI', 'w+');
fwrite($fp, $guardar);
fclose($fp);



?>