<?php
include("session.inc");
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
function quitar_com($str)
{
	return str_replace('"',"",$str);
}
if(isset($_GET["load_forms"]))
{
	$query_="select * from pace_def_det where id_Padre =".$_GET["load_forms"]."";
		$result = sqlsrv_query($conn, $query_);
		//oci_execute($result);
		$resp="";
		while($row = sqlsrv_fetch_array($result)) 
		{
			if(trim(enco($row["DESC_DETALLE"]))!="DeleteFlag" and trim(enco($row["DESC_DETALLE"]))!="Id" and trim(enco($row["DESC_DETALLE"]))!="Description")
				{
						$resp.='<tr STYLE="DISPLAY:block"> <td><label for="'.$row["COD_DEF_DETALLE"].'">'.($row["DESC_DETALLE"]).'</label></td>';
						$resp.='<td><input id="'.$row["COD_DEF_DETALLE"].'" name="'.$row["COD_DEF_DETALLE"].'" type="text" value="'.quitar_com(enco($row["VALOR_DETALLE"])).'" maxlength="'.$row["LARGO_DETALLE"].'"></td></tr>';
				}
		}
		echo $resp."";
}


?>