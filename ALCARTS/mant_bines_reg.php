<?php
include("session.inc");
?>

<?php
$INGRESAR = $_POST["INGRESAR"];
if ($INGRESAR <> "") {
	$BIN_TARJETA        = $_POST["BIN_TARJETA"];
	$LON_PAN            = $_POST["LON_PAN"];
	$COD_OPERACION      = strtoupper($_POST["COD_OPERACION"]);
	$FLAG_PROCESAMIENTO = $_POST["FLAG_PROCESAMIENTO"];
	$FLAG_USUARIO       = strtoupper($_POST["FLAG_USUARIO"]);
	$CARD_PLAN_ID       = strtoupper($_POST["CARD_PLAN_ID"]);
	$NETWORK_ID         = strtoupper($_POST["NETWORK_ID"]);
	$TIPO_HOST          = strtoupper($_POST["TIPO_HOST"]);
	$TARJ_PERMITIDA     = $_POST["TARJ_PERMITIDA"];
	$PR_MED_PAGO      = $_POST["PR_MED_PAGO"];
	$AUT_MANUAL         = $_POST["AUT_MANUAL"];
	$FACT_REQ           = $_POST["FACT_REQ"];
	$DEPARTAMENTO       = $_POST["DEPARTAMENTO"];
	$ID_FRANQUEO        = strtoupper($_POST["ID_FRANQUEO"]);
	$FLAG_BONO_SOL      = $_POST["FLAG_BONO_SOL"];
	$TP_TARJ            = $_POST["TP_TARJ"];
	$P_PAG_RET          = $_POST["P_PAG_RET"];
	$DESCRIPCION        = strtoupper($_POST["DESCRIPCION"]);
	$AC_PUNTOS          = $_POST["AC_PUNTOS"];
	$TY_TND             = $_POST["TY_TND"];
	$RECORD_ID          = strtoupper($_POST["RECORD_ID"]);
	$SEL_SUBV          = $_POST["SEL_SUBV"];
	
	$PIN          	   = $_POST["PIN"];
	$CVC   		       = $_POST["CVC"];
	$MONTO_MAYOR          = $_POST["MONTO_MAYOR"];
	if (empty($PIN)) {
		$PIN = 0;
	}
	if (empty($CVC)) {
		$CVC = 0;
	}
	if (empty($MONTO_MAYOR)) {
		$MONTO_MAYOR = 0;
	}
	
	
	if (empty($TARJ_PERMITIDA)) {
		$TARJ_PERMITIDA = 0;
	}
	if (empty($PR_MED_PAGO)) {
		$PR_MED_PAGO = 0;
	}
	if (empty($AUT_MANUAL)) {
		$AUT_MANUAL = 0;
	}
	if (empty($FACT_REQ)) {
		$FACT_REQ = 0;
	}
	if (empty($FLAG_BONO_SOL)) {
		$FLAG_BONO_SOL = 0;
	}
	if (empty($P_PAG_RET)) {
		$P_PAG_RET = 0;
	}
	if (empty($AC_PUNTOS)) {
		$AC_PUNTOS = 0;
	}
	$CONSULTA = "SELECT BIN_TARJETA FROM CO_BINES WHERE BIN_TARJETA=" . $BIN_TARJETA;
	$RS       = sqlsrv_query($conn, $CONSULTA);
	//oci_execute($RS);
	if ($row = sqlsrv_fetch_array($RS)) {
		header("Location: mant_bines.php?NEO=1&MSJE=2");
	} else {
		$MAX_ID   = 0;
		$CONSULTA = "SELECT MAX(ID_BINES) AS MAX_ID FROM CO_BINES";
		$RS       = sqlsrv_query($conn, $CONSULTA);
		//oci_execute($RS);
		while ($r = sqlsrv_fetch_array($RS)) {
			$MAX_ID = $r["MAX_ID"];
		}
		$MAX_ID++;
		$CONSULTA2 = "INSERT INTO CO_BINES (ID_BINES,BIN_TARJETA,LON_PAN,COD_OPERACION,FLAG_PROCESAMIENTO, FLAG_USUARIO,CARD_PLAN_ID,NETWORK_ID,TIPO_HOST,TARJ_PERMITIDA,PR_MED_PAGO,AUT_MANUAL,FACT_REQ,DEPARTAMENTO,ID_FRANQUEO,FLAG_BONO_SOL,TP_TARJ,P_PAG_RET,DESCRIPCION,AC_PUNTOS,TY_TND,RECORD_ID,SUB_CARD_PLAN_ID,PIN,CVC,MONTO_MAYOR) ";
		$CONSULTA2 = $CONSULTA2 . " VALUES (" . $MAX_ID . "," . $BIN_TARJETA . "," . $LON_PAN . ",'" . $COD_OPERACION . "','" . $FLAG_PROCESAMIENTO . "','" . $FLAG_USUARIO . "','" . $CARD_PLAN_ID . "','" . $NETWORK_ID . "','" . $TIPO_HOST . "'," . $TARJ_PERMITIDA . "," . $PR_MED_PAGO . "," . $AUT_MANUAL . "," . $FACT_REQ . ",'" . $DEPARTAMENTO . "','" . $ID_FRANQUEO . "'," . $FLAG_BONO_SOL . ",'" . $TP_TARJ . "'," . $P_PAG_RET . ",'" . $DESCRIPCION . "'," . $AC_PUNTOS . ",'" . $TY_TND . "','" . $RECORD_ID . "',".$SEL_SUBV.",".$PIN.",".$CVC.",".$MONTO_MAYOR.")";
		$RS2       = sqlsrv_query($conn, $CONSULTA2);
		//oci_execute($RS2);
		//REGISTRO DE ALTA
	
		$SQLOG = "INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
		$SQLOG = $SQLOG . "(1, convert(datetime,GETDATE(), 121), '" . $TIMESRV . "', '" . $IP_CLIENTE . "', " . $SESIDUSU . ", 1177, " . $SESIDSISTEMA . ", " . $SESIDPERFIL . ")";
		$RSL   = sqlsrv_query($maestra, $SQLOG);
		//oci_execute($RSL);
		header("Location: mant_bines.php?ACT=" . $MAX_ID . "&MSJE=3");
	}
	sqlsrv_close($conn);
	sqlsrv_close($maestra);
}
$ACTUALIZAR = $_POST["ACTUALIZAR"];
if ($ACTUALIZAR <> "") {
	$ID_BINES           = $_POST["ID_BINES"];
	$BIN_TARJETA        = $_POST["BIN_TARJETA"];
	$LON_PAN            = $_POST["LON_PAN"];
	$COD_OPERACION      = strtoupper($_POST["COD_OPERACION"]);
	$FLAG_PROCESAMIENTO = $_POST["FLAG_PROCESAMIENTO"];
	$FLAG_USUARIO       = strtoupper($_POST["FLAG_USUARIO"]);
	$CARD_PLAN_ID       = strtoupper($_POST["CARD_PLAN_ID"]);
	$NETWORK_ID         = strtoupper($_POST["NETWORK_ID"]);
	$TIPO_HOST          = strtoupper($_POST["TIPO_HOST"]);
	$TARJ_PERMITIDA     = $_POST["TARJ_PERMITIDA"];
	$PR_MED_PAGO      = $_POST["PR_MED_PAGO"];
	$AUT_MANUAL         = $_POST["AUT_MANUAL"];
	$FACT_REQ           = $_POST["FACT_REQ"];
	$DEPARTAMENTO       = $_POST["DEPARTAMENTO"];
	$ID_FRANQUEO        = strtoupper($_POST["ID_FRANQUEO"]);
	$FLAG_BONO_SOL      = $_POST["FLAG_BONO_SOL"];
	$TP_TARJ            = $_POST["TP_TARJ"];
	$P_PAG_RET          = $_POST["P_PAG_RET"];
	$DESCRIPCION        = strtoupper($_POST["DESCRIPCION"]);
	$AC_PUNTOS          = $_POST["AC_PUNTOS"];
	$TY_TND             = $_POST["TY_TND"];
	$RECORD_ID          = strtoupper($_POST["RECORD_ID"]);
	$SEL_SUBV          = $_POST["SEL_SUBV"];
	
	$PIN          	   = $_POST["PIN"];
	$CVC   		       = $_POST["CVC"];
	$MONTO_MAYOR          = $_POST["MONTO_MAYOR"];
	
	if (empty($PIN)) {
		$PIN = 0;
	}
	if (empty($CVC)) {
		$CVC = 0;
	}
	if (empty($MONTO_MAYOR)) {
		$MONTO_MAYOR = 0;
	}
	
	
	if (empty($TARJ_PERMITIDA)) {
		$TARJ_PERMITIDA = 0;
	}
	if (empty($PR_MED_PAGO)) {
		$PR_MED_PAGO = 0;
	}
	if (empty($AUT_MANUAL)) {
		$AUT_MANUAL = 0;
	}
	if (empty($FACT_REQ)) {
		$FACT_REQ = 0;
	}
	if (empty($FLAG_BONO_SOL)) {
		$FLAG_BONO_SOL = 0;
	}
	if (empty($P_PAG_RET)) {
		$P_PAG_RET = 0;
	}
	if (empty($AC_PUNTOS)) {
		$AC_PUNTOS = 0;
	}
	$CONSULTA2 = "UPDATE CO_BINES SET BIN_TARJETA=" . $BIN_TARJETA . ",LON_PAN=" . $LON_PAN . ",COD_OPERACION='" . $COD_OPERACION . "',FLAG_PROCESAMIENTO='" . $FLAG_PROCESAMIENTO . "', FLAG_USUARIO='" . $FLAG_USUARIO . "',CARD_PLAN_ID='" . $CARD_PLAN_ID . "',NETWORK_ID='" . $NETWORK_ID . "',TIPO_HOST='" . $TIPO_HOST . "',TARJ_PERMITIDA=" . $TARJ_PERMITIDA . ",PR_MED_PAGO=" . $PR_MED_PAGO . ",AUT_MANUAL=" . $AUT_MANUAL . ",FACT_REQ=" . $FACT_REQ . ",DEPARTAMENTO='" . $DEPARTAMENTO . "',ID_FRANQUEO='" . $ID_FRANQUEO . "',FLAG_BONO_SOL=" . $FLAG_BONO_SOL . ",TP_TARJ='" . $TP_TARJ . "',P_PAG_RET=" . $P_PAG_RET . ",DESCRIPCION='" . $DESCRIPCION . "',AC_PUNTOS=" . $AC_PUNTOS . ",TY_TND='" . $TY_TND . "', RECORD_ID='" . $RECORD_ID . "', SUB_CARD_PLAN_ID=".$SEL_SUBV." , PIN=".$PIN.", CVC=".$CVC.", MONTO_MAYOR=".$MONTO_MAYOR." WHERE ID_BINES=" . $ID_BINES;
	$RS2       = sqlsrv_query($conn, $CONSULTA2);
	//oci_execute($RS2);
	//REGISTRO DE MODIFICACION
	
	$SQLOG = "INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
	$SQLOG = $SQLOG . "(3, convert(datetime,GETDATE(), 121), '" . $TIMESRV . "', '" . $IP_CLIENTE . "', " . $SESIDUSU . ", 1177, " . $SESIDSISTEMA . ", " . $SESIDPERFIL . ")";
	$RSL   = sqlsrv_query($maestra, $SQLOG);
	//oci_execute($RSL);
	header("Location: mant_bines.php?ACT=" . $ID_BINES . "&MSJE=1");
	sqlsrv_close($conn);
	sqlsrv_close($maestra);
}
$ELIMINAR = @$_GET["ELM"];
if ($ELIMINAR <> "") {
	$ID_BINES = @$_GET["ID_BINES"];
	$CONSULTA = "DELETE FROM CO_BINES WHERE ID_BINES=" . $ID_BINES;
	$RS       = sqlsrv_query($conn, $CONSULTA);
	//oci_execute($RS);
	//REGISTRO DE BAJA
	
	$SQLOG = "INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
	$SQLOG = $SQLOG . "(2, convert(datetime,GETDATE(), 121), '" . $TIMESRV . "', '" . $IP_CLIENTE . "', " . $SESIDUSU . ", 1177, " . $SESIDSISTEMA . ", " . $SESIDPERFIL . ")";
	$RSL   = sqlsrv_query($maestra, $SQLOG);
	//oci_execute($RSL);
	header("Location: mant_bines.php?MSJE=4");
	sqlsrv_close($conn);
	sqlsrv_close($maestra);
}
?>

