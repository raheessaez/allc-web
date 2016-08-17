<?php

//$str = 'ShortDesc = "CA/DB"';

//echo $str."<hr>";

//$str= str_replace( '/', '|slash|', $str); 

//echo $str."<br>";

//$str= str_replace( '\\', '|bslash|', $str); 

//echo $str."<hr>";

//

//$str= str_replace( '|slash|', '/', $str); 

//echo $str."<br>";

//$str= str_replace(  '|bslash|','\\', $str); 

//echo $str;

//$BDIP = "200.27.205.250";

//$db   = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = " . $BDIP . ")(PORT = 1521)))(CONNECT_DATA=(SID=xe)))";

//$conn = oci_connect("PACE_EC", "PACE_EC", $db);

//$SQL  = "ALTER SESSION SET nls_date_format='DD-MM-YYYY'";

//$RS   = oci_parse($conn, $SQL);

//oci_execute($RS);

// Cargar Archivo

$file          = file("IN/EAMOPTNS.INI");

$flag          = 0;

$flag_as       = 0;

$flag_nvl2     = 0;

$id_           = 0;

$antes_        = "";

$despues_store = "";

function dec($str)

{

	$cadena = str_replace("'", "|csimple|", $str);

	$cadena = str_replace('"', "|cdoble|", $cadena);

	$cadena = str_replace('\\', '|bslash|', $cadena);

	$cadena = str_replace('/', '|slash|', $cadena);

	$cadena = str_replace("<", "|mnq|", $cadena);

	$cadena = str_replace(">", "|myq|", $cadena);

	$cadena = str_replace("+", "|plus|", $cadena);

	$cadena = str_replace("(", "|apar|", $cadena);

	$cadena = str_replace(")", "|cpar|", $cadena);

	$cadena = str_replace("=", "|igual|", $cadena);

	$cadena = str_replace("-", "|menos|", $cadena);

	$cadena = str_replace(",", "|coma|", $cadena);

	$cadena = str_replace(".", "|punto|", $cadena);

	$cadena = str_replace(";", "|pcoma|", $cadena);

	$cadena = str_replace("[", "|acorch|", $cadena);

	$cadena = str_replace("]", "|ccorch|", $cadena);

	$cadena = str_replace("?", "|apre|", $cadena);

	$cadena = str_replace("¿", "|cpre|", $cadena);

	$cadena = str_replace("%", "|porc|", $cadena);

	return $cadena;

}

function limpiarString($cadena)

{

	$string = split(" ", $cadena);

	$res    = "";

	for ($i = 0; $i <= count($string); $i++) {

		$cadena = trim($string[$i]);

		$cadena = strtr($cadena, "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ", "aaaaaaaaaaaaoooioooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");

		$cadena = dec($cadena);

		$res .= " " . $cadena;

	}

	return $res;

}

// Recorrer cada línea del archivo e imprimirla a pantalla

$encabezado = 0;

$campo      = 1;

$anterior   = "";

foreach ($file as $RowRept) {

	// Quitar primeras 5 lineas de comentarios

	if ($flag_as > 5) {

		// Para eliminar líneas vacias

		if (trim($RowRept) != "") {

			// Quitar lineas de comentarios

			if (substr($RowRept, 0, 1) != ";") {

				if ($flag == 1) {

					$RowRept = $anterior . $RowRept;

					$flag    = 0;

				}

				if (substr(trim($RowRept), -1) == '\\') {

					$anterior = $RowRept;

					$flag     = 1;

				} else {

					$despues_store = $despues_store . "<br>" . utf8_encode($RowRept);

					if (substr(trim($RowRept), 0, 1) != "[" and substr(trim($RowRept), -1) != "]") {

						$RowRept = limpiarString($RowRept);

						//echo $campo.$RowRept."<br>";

						$SQLOG   = "INSERT INTO campo(ide,descrip,id_padre) VALUES ";

						$SQLOG   = $SQLOG . "(" . $campo++ . ",'" . $RowRept . "'," . $encabezado . ")";

						echo $SQLOG;

						//$RSL = oci_parse($conn, $SQLOG);

						//oci_execute($RSL);

						//echo "paso <br>";

					} else {

						//ECHO $RowRept."<br>";

						//$mystring = $RowRept;

						//$findme   = '.List';

						$encabezado++;

						$pos = strpos($mystring, $findme);

						//$SQLOG="INSERT INTO PACE_EN(iden,descripcion) VALUES";

						//$SQLOG=$SQLOG."(".$encabezado.",'".limpiarString($RowRept)."')";

						//$RSL = oci_parse($conn, $SQLOG);

						//oci_execute($RSL);	

						// Nótese el uso de ===. Puesto que == simple no funcionará como se espera

						// porque la posición de 'a' está en el 1° (primer) caracter.

						if ($pos === false) {

							//echo $encabezado++.$RowRept."<br>";

							//$SQLOG="INSERT INTO encabezado(iden,descripcion) VALUES ";

							//$SQLOG=$SQLOG."(".$encabezado.",'".$RowRept."')";

							//$RSL = oci_parse($conn, $SQLOG);

							//oci_execute($RSL);	

							//$encabezado++;

						} else {

							//echo "ESTO ES ANIDADO:::".$encabezado++.$RowRept."<br>";

							//$encabezado++;

							//$SQLOG="INSERT INTO encabezado(iden,descripcion) VALUES ";

							//$SQLOG=$SQLOG."(".$encabezado.",'".$RowRept."');";

							//$RSL = oci_parse($conn, $SQLOG);

							//oci_execute($RSL);

						}

					}

				}

			}

		}

	}

	$flag_as++;

}

//echo $antes_store;

//echo $despues_store;

?>