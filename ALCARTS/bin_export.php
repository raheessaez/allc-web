<?php
include ("session.inc");

$TIENDA = $_GET["COD_TIENDA"];
$CMD_BIN_STRING = $_GET["CMD_BIN"];
$BIN_RUTA = $_GET["BIN_RUTA"];
$CMD_BIN="";
$CMD_ARRAY=explode("|inter|",$CMD_BIN_STRING);
foreach($CMD_ARRAY as $ROW_CMD)
{
	$CMD_BIN.=$ROW_CMD."\r\n";
}
$QUERY = "SELECT VAL_PARAM from PM_PARVAL WHERE ID_PARVAL = 152";

$RSQ = sqlsrv_query($maestra, $QUERY);

if ($row = sqlsrv_fetch_array($RSQ))
{
	$RUTA = $row['VAL_PARAM'];
}
else
{
	$RUTA = "C:/ALLC/WWW/allc_dat/in/update";
}

$largo = strlen($RUTA);
$pos = strpos($RUTA, '/');
$DISCO = substr($RUTA, 0, $pos);
$RESTO = substr($RUTA, $pos + 1, $largo);
$largo2 = strlen($RESTO);
$pos2 = strpos($RESTO, '/');
$CARPETA2 = substr($RESTO, 0, $pos2);
$RESTO2 = substr($RESTO, $pos2 + 1, $largo2);
$largo3 = strlen($RESTO2);
$pos3 = strpos($RESTO2, '/');
$CARPETA3 = substr($RESTO2, 0, $pos3);
$RESTO3 = substr($RESTO2, $pos3 + 1, $largo3);
$largo4 = strlen($RESTO3);
$pos4 = strpos($RESTO3, '/');
$CARPETA4 = substr($RESTO3, 0, $pos4);
$RESTO4 = substr($RESTO3, $pos4 + 1, $largo4);
$largo5 = strlen($RESTO4);
$pos5 = strpos($RESTO4, '/');
$CARPETA5 = substr($RESTO4, 0, $pos5);
$RESTO5 = substr($RESTO4, $pos5 + 1, $largo5);
$largo6 = strlen($RESTO5);
$pos6 = strpos($RESTO5, '/');
$CARPETA6 = substr($RESTO5, 0, $pos6);

// RUTA BASE y CARPETA CONTENEDORA SIN TIENDA

$CARPETA = substr($RESTO5, $pos6, $largo6);
$RUTA = $CARPETA4 . '/' . $CARPETA5 . '/' . $CARPETA6;

function Obtener_ip_()
{
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];
	if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['HTTP_X_FORWARDED_FOR'];
	return $_SERVER['REMOTE_ADDR'];
}

function create_cmd($conn, $TIENDA, $CMD_BIN, $BIN_RUTA, $RUTA, $CARPETA)
{
	$TIENDA = "000" . $TIENDA;
	$TIENDA = substr($TIENDA, -3);
	$save = $BIN_RUTA . $CMD_BIN;
	if (file_exists('../../' . $RUTA . $TIENDA . '/' . $CARPETA . '/'))
	{
		$fps = fopen('../../' . $RUTA . $TIENDA . '/' . $CARPETA . '/ACEBNINP.CMD', 'w+');
		fwrite($fps, $save);
		fclose($fps);
		return "Exportacion exitosa";
	}
	else
	{
		mkdir("../../" . $RUTA . $TIENDA . "/" . $CARPETA, 0777);
		$fps = fopen('../../' . $RUTA . $TIENDA . '/' . $CARPETA . '/ACEBNINP.CMD', 'w+');
		fwrite($fps, $save);
		fclose($fps);
		return "Creacion de Carpetas y Exportacion exitosa";
	}
}

function log_export($DES_CLAVE, $TIPO_ARCHIVO, $NOMBRE_ARCH, $conn)
{
	$IP_CLIENTE = Obtener_ip_();
	$FECHA = date("d-m-Y");
	$HORA = date("H:i:s");
	$ID_ARCEXPT = 1;
	$QUERY = "SELECT MAX(ID_ARCEXPT) as MAXID FROM CO_BIN_ARCEXPT";
	$RS = sqlsrv_query($conn, $QUERY);
	while ($row = sqlsrv_fetch_array($RS))
	{
		$MAXID = $row['MAXID'];
		if (!isset($MAXID))
		{
			$ID_ARCEXPT = 1;
		}
		else
		{
			$ID_ARCEXPT = ++$MAXID;
		}
	}

	$SQLOG = "INSERT INTO CO_BIN_ARCEXPT (ID_ARCEXPT,IP_CLIENTE,DES_CLAVE,FECHA,HORA,TIPO_ARCHIVO,NOMBRE_ARCH,COD_USUARIO) VALUES ";
	$SQLOG = $SQLOG . "(" . $ID_ARCEXPT . ",'" . $IP_CLIENTE . "'," . $DES_CLAVE . ",'" . $FECHA . "','" . $HORA . "','" . $TIPO_ARCHIVO . "','" . $NOMBRE_ARCH . "'," . $_SESSION['ARMS_IDUSU'] . ")";
	$RSL = sqlsrv_query($conn, $SQLOG);

	// oci_execute($RSL);

	return true;
}

function create_file($TIENDA, $guardar, $conn, $RUTA, $CARPETA)
{
	$MAXID = $row['MAXID'];
	$FECSRV = date("Ymd");
	$TIMESRV = date("His");
	$TIENDA = "000" . $TIENDA;
	$TIENDA = substr($TIENDA, -3);
	if (file_exists('../../' . $RUTA . $TIENDA . '/' . $CARPETA . '/') && file_exists('../../' . $RUTA . $TIENDA . '/' . $CARPETA . '/bkp_bin/'))
	{

		// echo "directorio Existente";

		$fp = fopen('../../' . $RUTA . $TIENDA . '/' . $CARPETA . '/ACEBNINP.DAT', 'w+');
		fwrite($fp, $guardar);
		fclose($fp);
		$cp = fopen('../../' . $RUTA . $TIENDA . '/bkp_bin/ACEBNINP' . '_' . $FECSRV . '_' . $TIMESRV . '.DAT', 'w+');
		fwrite($cp, $guardar);
		fclose($cp);
		$TIPO_ARCHIVO = "ACEBNINP.DAT";
		$NOMBRE_ARCH = 'ACEBNINP' . '_' . $FECSRV . '_' . $TIMESRV . '.DAT';
		$ret = log_export($TIENDA, $TIPO_ARCHIVO, $NOMBRE_ARCH, $conn);
		return "Exportacion exitosa";
	}
	else
	{
		mkdir("../../" . $RUTA . $TIENDA . "/" . $CARPETA, 0777);
		$fp = fopen('../../' . $RUTA . $TIENDA . '/' . $CARPETA . '/ACEBNINP.DAT', 'w+');
		fwrite($fp, $guardar);
		fclose($fp);
		mkdir("../../" . $RUTA . $TIENDA . "/bkp_bin", 0777);
		$cp = fopen('../../' . $RUTA . $TIENDA . '/bkp_bin/ACEBNINP' . '_' . $FECSRV . '_' . $TIMESRV . '.DAT', 'w+');
		fwrite($cp, $guardar);
		fclose($cp);
		$TIPO_ARCHIVO = "ACEBNINP.DAT";
		$NOMBRE_ARCH = 'ACEBNINP' . '_' . $FECSRV . '_' . $TIMESRV . '.DAT';
		$ret = log_export($TIENDA, $TIPO_ARCHIVO, $NOMBRE_ARCH, $conn);
		return "Creacion de Carpetas y Exportacion exitosa";
	}
}

if ($TIENDA != "TODOS")
{
	$print = "";
	$guardar = "";
	$CONSULTA2 = "SELECT COUNT(ID_BINES) as TOTAL FROM CO_BINES";
	$RS2 = sqlsrv_query($conn, $CONSULTA2);

	// oci_execute($RS2);

	while ($row2 = sqlsrv_fetch_array($RS2))
	{
		$TOTAL = $row2['TOTAL'] + 2;
		$TOTAL2 = $row2['TOTAL'];
	}

	$print.= "H1000001BIN FILE20150219142800R04000000" . $TOTAL2 . "<br />";
	$print.= "<br />";
	$guardar.= "H1000001BIN FILE20150219142800R04000000" . $TOTAL2 . "\r\n";
	$CONSULTA = "SELECT * FROM CO_BINES  ORDER BY ID_BINES";
	$RS = sqlsrv_query($conn, $CONSULTA);

	// oci_execute($RS);

	while ($row = sqlsrv_fetch_array($RS))
	{
		$BIN_TARJETA = "00000000000000000000";
		$LON_PAN = "00";
		$COD_OPERACION = "A";
		$FLAG_PROCESAMIENTO = "0000";
		$FLAG_USUARIO = "0000";
		$CARD_PLAN_ID = "VI";
		$NETWORK_ID = "CC";
		$TIPO_HOST = "SYS";
		$TARJ_PERMITIDA = "0";
		$PR_MED_PAGO = "0";
		$AUT_MANUAL = "0";
		$FACT_REQ = "0";
		$DEPARTAMENTO = "000000";
		$ID_FRANQUEO = "00";
		$FLAG_BONO_SOL = "0";
		$TP_TARJ = "00";
		$P_PAG_RET = "0";
		$DESCRIPCION = "DESC PRUEBA";
		$AC_PUNTOS = "0";
		$TY_TND = "00";
		$PIN = "0";
		$CVC = "0";
		$MONTO_MAYOR = "0";
		
		if($row['ID_BINES']!=null or isset($row['ID_BINES']))
		$ID_BINES = $row['ID_BINES'];
		if($row['BIN_TARJETA']!=null or isset($row['BIN_TARJETA']))
		$BIN_TARJETA = $row['BIN_TARJETA'];
		if($row['LON_PAN']!=null or isset($row['LON_PAN']))
		$LON_PAN = $row['LON_PAN'];
		if($row['COD_OPERACION']!=null or isset($row['COD_OPERACION']))
		$COD_OPERACION = $row['COD_OPERACION'];
		if($row['FLAG_PROCESAMIENTO']!=null or isset($row['FLAG_PROCESAMIENTO']))
		$FLAG_PROCESAMIENTO = $row['FLAG_PROCESAMIENTO'];
		if($row['FLAG_USUARIO']!=null or isset($row['FLAG_USUARIO']))
		$FLAG_USUARIO = $row['FLAG_USUARIO'];
		if($row['CARD_PLAN_ID']!=null or isset($row['CARD_PLAN_ID']))
		$CARD_PLAN_ID = $row['CARD_PLAN_ID'];
		if($row['NETWORK_ID']!=null or isset($row['NETWORK_ID']))
		$NETWORK_ID = $row['NETWORK_ID'];
		if($row['TIPO_HOST']!=null or isset($row['TIPO_HOST']))
		$TIPO_HOST = $row['TIPO_HOST'];
		if($row['TARJ_PERMITIDA']!=null or isset($row['TARJ_PERMITIDA']))
		$TARJ_PERMITIDA = $row['TARJ_PERMITIDA'];
		if($row['PR_MED_PAGO']!=null or isset($row['PR_MED_PAGO']))
		$PR_MED_PAGO = $row['PR_MED_PAGO'];
		if($row['AUT_MANUAL']!=null or isset($row['AUT_MANUAL']))
		$AUT_MANUAL = $row['AUT_MANUAL'];
		if($row['FACT_REQ']!=null or isset($row['FACT_REQ']))
		$FACT_REQ = $row['FACT_REQ'];
		if($row['DEPARTAMENTO']!=null or isset($row['DEPARTAMENTO']))
		$DEPARTAMENTO = $row['DEPARTAMENTO'];
		if($row['ID_FRANQUEO']!=null or isset($row['ID_FRANQUEO']))
		$ID_FRANQUEO = $row['ID_FRANQUEO'];
		if($row['FLAG_BONO_SOL']!=null or isset($row['FLAG_BONO_SOL']))
		$FLAG_BONO_SOL = $row['FLAG_BONO_SOL'];
		if($row['TP_TARJ']!=null or isset($row['TP_TARJ']))
		$TP_TARJ = $row['TP_TARJ'];
		if($row['P_PAG_RET']!=null or isset($row['P_PAG_RET']))
		$P_PAG_RET = $row['P_PAG_RET'];
		if($row['DESCRIPCION']!=null or isset($row['DESCRIPCION']))
		$DESCRIPCION = $row['DESCRIPCION'];
		if($row['AC_PUNTOS']!=null or isset($row['AC_PUNTOS']))
		$AC_PUNTOS = $row['AC_PUNTOS'];
		if($row['TY_TND']!=null or isset($row['TY_TND']))
		$TY_TND = $row['TY_TND'];
		
		if($row['SUB_CARD_PLAN_ID']!=null or isset($row['SUB_CARD_PLAN_ID']))
		$SUB_CARD_PLAN_ID = $row['SUB_CARD_PLAN_ID'];
		if($row['PIN']!=null or isset($row['PIN']))
		$PIN = $row['PIN'];
		if($row['CVC']!=null or isset($row['CVC']))
		$CVC = $row['CVC'];
		if($row['MONTO_MAYOR']!=null or isset($row['MONTO_MAYOR']))
		$MONTO_MAYOR = $row['MONTO_MAYOR'];
		
		$DESC_SUB="00";
		$CONSULTA_SUB="SELECT DESC_SUB FROM SUB_CARD_PLAN_ID WHERE ID=".$SUB_CARD_PLAN_ID;
		$RS_SUB = sqlsrv_query($conn, $CONSULTA_SUB);
		
		if ($ROW_SUB = sqlsrv_fetch_array($RS_SUB))
		{
			$DESC_SUB=$ROW_SUB["DESC_SUB"];
		}
		$cuenta_id = strlen($ID_BINES);
		$cuenta_bin = strlen($BIN_TARJETA);
		$cuenta_desc = strlen(trim($DESCRIPCION));
		if ($cuenta_id == 1)
		{
			$ID_BINES = "00000" . $ID_BINES;
		}

		if ($cuenta_id == 2)
		{
			$ID_BINES = "0000" . $ID_BINES;
		}

		if ($cuenta_id == 3)
		{
			$ID_BINES = "000" . $ID_BINES;
		}

		if ($cuenta_id == 4)
		{
			$ID_BINES = "00" . $ID_BINES;
		}

		if ($cuenta_id == 5)
		{
			$ID_BINES = "0" . $ID_BINES;
		}

		if ($cuenta_bin == 1)
		{
			$BIN_TARJETA = $BIN_TARJETA . "                   ";
		}

		if ($cuenta_bin == 2)
		{
			$BIN_TARJETA = $BIN_TARJETA . "                  ";
		}

		if ($cuenta_bin == 3)
		{
			$BIN_TARJETA = $BIN_TARJETA . "                 ";
		}

		if ($cuenta_bin == 4)
		{
			$BIN_TARJETA = $BIN_TARJETA . "                ";
		}

		if ($cuenta_bin == 5)
		{
			$BIN_TARJETA = $BIN_TARJETA . "               ";
		}

		if ($cuenta_bin == 6)
		{
			$BIN_TARJETA = $BIN_TARJETA . "              ";
		}

		if ($cuenta_bin == 7)
		{
			$BIN_TARJETA = $BIN_TARJETA . "             ";
		}

		if ($cuenta_bin == 8)
		{
			$BIN_TARJETA = $BIN_TARJETA . "            ";
		}

		if ($cuenta_bin == 9)
		{
			$BIN_TARJETA = $BIN_TARJETA . "           ";
		}

		if ($cuenta_bin == 10)
		{
			$BIN_TARJETA = $BIN_TARJETA . "          ";
		}

		if ($cuenta_bin == 11)
		{
			$BIN_TARJETA = $BIN_TARJETA . "         ";
		}

		if ($cuenta_bin == 12)
		{
			$BIN_TARJETA = $BIN_TARJETA . "        ";
		}

		if ($cuenta_bin == 13)
		{
			$BIN_TARJETA = $BIN_TARJETA . "       ";
		}

		if ($cuenta_bin == 14)
		{
			$BIN_TARJETA = $BIN_TARJETA . "      ";
		}

		if ($cuenta_bin == 15)
		{
			$BIN_TARJETA = $BIN_TARJETA . "     ";
		}

		if ($cuenta_bin == 16)
		{
			$BIN_TARJETA = $BIN_TARJETA . "    ";
		}

		if ($cuenta_bin == 17)
		{
			$BIN_TARJETA = $BIN_TARJETA . "   ";
		}

		if ($cuenta_bin == 18)
		{
			$BIN_TARJETA = $BIN_TARJETA . "  ";
		}

		if ($cuenta_bin == 19)
		{
			$BIN_TARJETA = $BIN_TARJETA . " ";
		}

		if ($cuenta_desc == 1)
		{
			$DESCRIPCION = $DESCRIPCION . "              ";
		}

		if ($cuenta_desc == 2)
		{
			$DESCRIPCION = $DESCRIPCION . "             ";
		}

		if ($cuenta_desc == 3)
		{
			$DESCRIPCION = $DESCRIPCION . "            ";
		}

		if ($cuenta_desc == 4)
		{
			$DESCRIPCION = $DESCRIPCION . "           ";
		}

		if ($cuenta_desc == 5)
		{
			$DESCRIPCION = $DESCRIPCION . "          ";
		}

		if ($cuenta_desc == 6)
		{
			$DESCRIPCION = $DESCRIPCION . "         ";
		}

		if ($cuenta_desc == 7)
		{
			$DESCRIPCION = $DESCRIPCION . "        ";
		}

		if ($cuenta_desc == 8)
		{
			$DESCRIPCION = $DESCRIPCION . "       ";
		}

		if ($cuenta_desc == 9)
		{
			$DESCRIPCION = $DESCRIPCION . "      ";
		}

		if ($cuenta_desc == 10)
		{
			$DESCRIPCION = $DESCRIPCION . "     ";
		}

		if ($cuenta_desc == 11)
		{
			$DESCRIPCION = $DESCRIPCION . "    ";
		}

		if ($cuenta_desc == 12)
		{
			$DESCRIPCION = $DESCRIPCION . "   ";
		}

		if ($cuenta_desc == 13)
		{
			$DESCRIPCION = $DESCRIPCION . "  ";
		}

		if ($cuenta_desc == 14)
		{
			$DESCRIPCION = $DESCRIPCION . " ";
		}

		$res = "D1" . $ID_BINES . $BIN_TARJETA . $LON_PAN . $COD_OPERACION . $FLAG_PROCESAMIENTO . $FLAG_USUARIO . $CARD_PLAN_ID . $NETWORK_ID . $TIPO_HOST . $TARJ_PERMITIDA. $PR_MED_PAGO . $AUT_MANUAL . $FACT_REQ . $AC_PUNTOS . $DEPARTAMENTO . $DESCRIPCION . $ID_FRANQUEO .$FLAG_BONO_SOL . $TY_TND .$P_PAG_RET .$DESC_SUB.$PIN.$CVC.$MONTO_MAYOR;
		$print.= $res . "<br />";
		$flag = "D1" . $ID_BINES . $BIN_TARJETA . $LON_PAN . $COD_OPERACION . $FLAG_PROCESAMIENTO . $FLAG_USUARIO . $CARD_PLAN_ID . $NETWORK_ID . $TIPO_HOST . $TARJ_PERMITIDA . $PR_MED_PAGO . $AUT_MANUAL . $FACT_REQ . $AC_PUNTOS . $DEPARTAMENTO  . $DESCRIPCION . $ID_FRANQUEO . $FLAG_BONO_SOL  . $TY_TND  . $P_PAG_RET.$DESC_SUB.$PIN.$CVC.$MONTO_MAYOR;
		$guardar.= $flag . "\r\n";
	}

	$cmd = $CMD_BIN . "\r\n";
	$ruta = $BIN_RUTA . "\r\n";
	$print.= "T1000" . $TOTAL;
	$guardar.= "T1000" . $TOTAL;
	if ($TIENDA != 'NADA')
	{
		$msg = create_file($TIENDA, $guardar, $conn, $RUTA, $CARPETA);
		create_cmd($conn, $TIENDA, $cmd, $ruta, $RUTA, $CARPETA);
		echo $msg;
	}
	else
	{
		echo "Favor de seleccionar una tienda";
	}

	// Fin con tienda fija

}
else
{

	// TODOS

	$QUERY = "SELECT * from MN_TIENDA where IND_ACTIVO = 1 and COD_TIENDA<>0";
	$R = sqlsrv_query($maestra, $QUERY);

	// oci_execute($R);

	while ($row3 = sqlsrv_fetch_array($R))
	{
		$guardar = "";
		$TIENDA = $row3['DES_CLAVE'];
		$TOTAL = "";
		$TOTAL2 = "";
		$CONSULTA2 = "SELECT COUNT(ID_BINES) as TOTAL FROM CO_BINES";
		$RS2 = sqlsrv_query($conn, $CONSULTA2);

		// oci_execute($RS2);

		while ($row2 = sqlsrv_fetch_array($RS2))
		{
			$TOTAL = $row2['TOTAL'] + 2;
			$TOTAL2 = $row2['TOTAL'];
		}

		$guardar.= "H1000001BIN FILE20150219142800R04000000" . $TOTAL2 . "\r\n";
		$CONSULTA = "SELECT * FROM CO_BINES ORDER BY ID_BINES";
		$RS = sqlsrv_query($conn, $CONSULTA);

		// oci_execute($RS);

		while ($row = sqlsrv_fetch_array($RS))
		{
			$BIN_TARJETA = "00000000000000000000";
			$LON_PAN = "00";
			$COD_OPERACION = "A";
			$FLAG_PROCESAMIENTO = "0000";
			$FLAG_USUARIO = "0000";
			$CARD_PLAN_ID = "VI";
			$NETWORK_ID = "CC";
			$TIPO_HOST = "SYS";
			$TARJ_PERMITIDA = "0";
			$PR_MED_PAGO = "0";
			$AUT_MANUAL = "0";
			$FACT_REQ = "0";
			$DEPARTAMENTO = "000000";
			$ID_FRANQUEO = "00";
			$FLAG_BONO_SOL = "0";
			$TP_TARJ = "00";
			$P_PAG_RET = "0";
			$DESCRIPCION = "DESC PRUEBA";
			$AC_PUNTOS = "0";
			$TY_TND = "00";
			$PIN = "0";
			$CVC = "0";
			$MONTO_MAYOR = "0";
			
			if($row['ID_BINES']!=null or isset($row['ID_BINES']))
			$ID_BINES = $row['ID_BINES'];
			if($row['BIN_TARJETA']!=null or isset($row['BIN_TARJETA']))
			$BIN_TARJETA = $row['BIN_TARJETA'];
			if($row['LON_PAN']!=null or isset($row['LON_PAN']))
			$LON_PAN = $row['LON_PAN'];
			if($row['COD_OPERACION']!=null or isset($row['COD_OPERACION']))
			$COD_OPERACION = $row['COD_OPERACION'];
			if($row['FLAG_PROCESAMIENTO']!=null or isset($row['FLAG_PROCESAMIENTO']))
			$FLAG_PROCESAMIENTO = $row['FLAG_PROCESAMIENTO'];
			if($row['FLAG_USUARIO']!=null or isset($row['FLAG_USUARIO']))
			$FLAG_USUARIO = $row['FLAG_USUARIO'];
			if($row['CARD_PLAN_ID']!=null or isset($row['CARD_PLAN_ID']))
			$CARD_PLAN_ID = $row['CARD_PLAN_ID'];
			if($row['NETWORK_ID']!=null or isset($row['NETWORK_ID']))
			$NETWORK_ID = $row['NETWORK_ID'];
			if($row['TIPO_HOST']!=null or isset($row['TIPO_HOST']))
			$TIPO_HOST = $row['TIPO_HOST'];
			if($row['TARJ_PERMITIDA']!=null or isset($row['TARJ_PERMITIDA']))
			$TARJ_PERMITIDA = $row['TARJ_PERMITIDA'];
			if($row['PR_MED_PAGO']!=null or isset($row['PR_MED_PAGO']))
			$PR_MED_PAGO = $row['PR_MED_PAGO'];
			if($row['AUT_MANUAL']!=null or isset($row['AUT_MANUAL']))
			$AUT_MANUAL = $row['AUT_MANUAL'];
			if($row['FACT_REQ']!=null or isset($row['FACT_REQ']))
			$FACT_REQ = $row['FACT_REQ'];
			if($row['DEPARTAMENTO']!=null or isset($row['DEPARTAMENTO']))
			$DEPARTAMENTO = $row['DEPARTAMENTO'];
			if($row['ID_FRANQUEO']!=null or isset($row['ID_FRANQUEO']))
			$ID_FRANQUEO = $row['ID_FRANQUEO'];
			if($row['FLAG_BONO_SOL']!=null or isset($row['FLAG_BONO_SOL']))
			$FLAG_BONO_SOL = $row['FLAG_BONO_SOL'];
			if($row['TP_TARJ']!=null or isset($row['TP_TARJ']))
			$TP_TARJ = $row['TP_TARJ'];
			if($row['P_PAG_RET']!=null or isset($row['P_PAG_RET']))
			$P_PAG_RET = $row['P_PAG_RET'];
			if($row['DESCRIPCION']!=null or isset($row['DESCRIPCION']))
			$DESCRIPCION = $row['DESCRIPCION'];
			if($row['AC_PUNTOS']!=null or isset($row['AC_PUNTOS']))
			$AC_PUNTOS = $row['AC_PUNTOS'];
			if($row['TY_TND']!=null or isset($row['TY_TND']))
			$TY_TND = $row['TY_TND'];
			if(strlen($TY_TND)==1)
			$TY_TND="0".$TY_TND;
			if($row['SUB_CARD_PLAN_ID']!=null or isset($row['SUB_CARD_PLAN_ID']))
			$SUB_CARD_PLAN_ID = $row['SUB_CARD_PLAN_ID'];
			if($row['PIN']!=null or isset($row['PIN']))
			$PIN = $row['PIN'];
			if($row['CVC']!=null or isset($row['CVC']))
			$CVC = $row['CVC'];
			if($row['MONTO_MAYOR']!=null or isset($row['MONTO_MAYOR']))
			$MONTO_MAYOR = $row['MONTO_MAYOR'];
			
			
			$DESC_SUB="00";
			$CONSULTA_SUB="SELECT DESC_SUB FROM SUB_CARD_PLAN_ID WHERE ID=".$SUB_CARD_PLAN_ID;
			$RS_SUB = sqlsrv_query($conn, $CONSULTA_SUB);
			
			if ($ROW_SUB = sqlsrv_fetch_array($RS_SUB))
			{
				$DESC_SUB=$ROW_SUB["DESC_SUB"];
			}
			$cuenta_id = strlen($ID_BINES);
			$cuenta_bin = strlen($BIN_TARJETA);
			$cuenta_desc = strlen(trim($DESCRIPCION));
			if ($cuenta_id == 1)
			{
				$ID_BINES = "00000" . $ID_BINES;
			}

			if ($cuenta_id == 2)
			{
				$ID_BINES = "0000" . $ID_BINES;
			}

			if ($cuenta_id == 3)
			{
				$ID_BINES = "000" . $ID_BINES;
			}

			if ($cuenta_id == 4)
			{
				$ID_BINES = "00" . $ID_BINES;
			}

			if ($cuenta_id == 5)
			{
				$ID_BINES = "0" . $ID_BINES;
			}

			if ($cuenta_bin == 1)
			{
				$BIN_TARJETA = $BIN_TARJETA . "                   ";
			}

			if ($cuenta_bin == 2)
			{
				$BIN_TARJETA = $BIN_TARJETA . "                  ";
			}

			if ($cuenta_bin == 3)
			{
				$BIN_TARJETA = $BIN_TARJETA . "                 ";
			}

			if ($cuenta_bin == 4)
			{
				$BIN_TARJETA = $BIN_TARJETA . "                ";
			}

			if ($cuenta_bin == 5)
			{
				$BIN_TARJETA = $BIN_TARJETA . "               ";
			}

			if ($cuenta_bin == 6)
			{
				$BIN_TARJETA = $BIN_TARJETA . "              ";
			}

			if ($cuenta_bin == 7)
			{
				$BIN_TARJETA = $BIN_TARJETA . "             ";
			}

			if ($cuenta_bin == 8)
			{
				$BIN_TARJETA = $BIN_TARJETA . "            ";
			}

			if ($cuenta_bin == 9)
			{
				$BIN_TARJETA = $BIN_TARJETA . "           ";
			}

			if ($cuenta_bin == 10)
			{
				$BIN_TARJETA = $BIN_TARJETA . "          ";
			}

			if ($cuenta_bin == 11)
			{
				$BIN_TARJETA = $BIN_TARJETA . "         ";
			}

			if ($cuenta_bin == 12)
			{
				$BIN_TARJETA = $BIN_TARJETA . "        ";
			}

			if ($cuenta_bin == 13)
			{
				$BIN_TARJETA = $BIN_TARJETA . "       ";
			}

			if ($cuenta_bin == 14)
			{
				$BIN_TARJETA = $BIN_TARJETA . "      ";
			}

			if ($cuenta_bin == 15)
			{
				$BIN_TARJETA = $BIN_TARJETA . "     ";
			}

			if ($cuenta_bin == 16)
			{
				$BIN_TARJETA = $BIN_TARJETA . "    ";
			}

			if ($cuenta_bin == 17)
			{
				$BIN_TARJETA = $BIN_TARJETA . "   ";
			}

			if ($cuenta_bin == 18)
			{
				$BIN_TARJETA = $BIN_TARJETA . "  ";
			}

			if ($cuenta_bin == 19)
			{
				$BIN_TARJETA = $BIN_TARJETA . " ";
			}

			if ($cuenta_desc == 1)
			{
				$DESCRIPCION = $DESCRIPCION . "              ";
			}

			if ($cuenta_desc == 2)
			{
				$DESCRIPCION = $DESCRIPCION . "             ";
			}

			if ($cuenta_desc == 3)
			{
				$DESCRIPCION = $DESCRIPCION . "            ";
			}

			if ($cuenta_desc == 4)
			{
				$DESCRIPCION = $DESCRIPCION . "           ";
			}

			if ($cuenta_desc == 5)
			{
				$DESCRIPCION = $DESCRIPCION . "          ";
			}

			if ($cuenta_desc == 6)
			{
				$DESCRIPCION = $DESCRIPCION . "         ";
			}

			if ($cuenta_desc == 7)
			{
				$DESCRIPCION = $DESCRIPCION . "        ";
			}

			if ($cuenta_desc == 8)
			{
				$DESCRIPCION = $DESCRIPCION . "       ";
			}

			if ($cuenta_desc == 9)
			{
				$DESCRIPCION = $DESCRIPCION . "      ";
			}

			if ($cuenta_desc == 10)
			{
				$DESCRIPCION = $DESCRIPCION . "     ";
			}

			if ($cuenta_desc == 11)
			{
				$DESCRIPCION = $DESCRIPCION . "    ";
			}

			if ($cuenta_desc == 12)
			{
				$DESCRIPCION = $DESCRIPCION . "   ";
			}

			if ($cuenta_desc == 13)
			{
				$DESCRIPCION = $DESCRIPCION . "  ";
			}

			if ($cuenta_desc == 14)
			{
				$DESCRIPCION = $DESCRIPCION . " ";
			}

			$res = "D1" . $ID_BINES . $BIN_TARJETA . $LON_PAN . $COD_OPERACION . $FLAG_PROCESAMIENTO . $FLAG_USUARIO . $CARD_PLAN_ID . $NETWORK_ID . $TIPO_HOST . $TARJ_PERMITIDA . $PR_MED_PAGO . $AUT_MANUAL . $FACT_REQ . $AC_PUNTOS . $DEPARTAMENTO . $DESCRIPCION . $ID_FRANQUEO . $FLAG_BONO_SOL . $TY_TND . $P_PAG_RET.$DESC_SUB.$PIN.$CVC.$MONTO_MAYOR;
			$print.= $res . "<br />";
			$flag = "D1" . $ID_BINES . $BIN_TARJETA . $LON_PAN . $COD_OPERACION . $FLAG_PROCESAMIENTO . $FLAG_USUARIO . $CARD_PLAN_ID . $NETWORK_ID . $TIPO_HOST . $TARJ_PERMITIDA . $PR_MED_PAGO . $AUT_MANUAL . $FACT_REQ . $AC_PUNTOS .$DEPARTAMENTO  . $DESCRIPCION . $ID_FRANQUEO . $FLAG_BONO_SOL. $TY_TND . $P_PAG_RET.$DESC_SUB.$PIN.$CVC.$MONTO_MAYOR;
			$guardar.= $flag . "\r\n";
		}

		$cmd = $CMD_BIN . "\r\n";
		$ruta = $BIN_RUTA . "\r\n";
		$print.= "T1000" . $TOTAL;
		$guardar.= "T1000" . $TOTAL;

		// echo $print;

		if ($TIENDA != 'NADA')
		{
			$msg = create_file($TIENDA, $guardar, $conn, $RUTA, $CARPETA);
			create_cmd($conn, $TIENDA, $cmd, $ruta, $RUTA, $CARPETA);
			echo $msg;
		}
		else
		{
			echo "Favor de seleccionar una tienda";
		}
	}
}

?>