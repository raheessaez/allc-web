<?php
include ("session.inc");

?>

<?php
$INGRESAR = $_POST["INGRESAR"];

if ($INGRESAR <> "")
{
	$CARD_ID = strtoupper($_POST["CARD_ID"]);
	$CARD_DESC = strtoupper($_POST["CARD_DESC"]);
	$CONSULTA = "SELECT CARD_ID FROM CO_CARD_PLAN WHERE CARD_ID=" . $CARD_ID;
	$RS = sqlsrv_query($conn, $CONSULTA);

	// //oci_execute($RS);

	if ($row = sqlsrv_fetch_array($RS))
	{
		header("Location: mant_cardplan.php?NEO=1&MSJE=2");
	}
	else
	{
		$CONSULTA2 = "INSERT INTO CO_CARD_PLAN (CARD_ID, CARD_DESC,CARD_IDEN) ";
		$CONSULTA2 = $CONSULTA2 . " VALUES ('" . $CARD_ID . "', '" . $CARD_DESC . "', '" . $CARD_ID . "00')";
		$RS2 = sqlsrv_query($conn, $CONSULTA2);

		// oci_execute($RS2);
		// REGISTRO DE ALTA

		$SQLOG = "INSERT INTO LG_EVENTO (COD_EVENTO, COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
		$SQLOG = $SQLOG . "(" . $COD_EVENTO . ", 1, convert(datetime,GETDATE(), 121), '" . $TIMESRV . "', '" . $IP_CLIENTE . "', " . $SESIDUSU . ", 1184, " . $SESIDSISTEMA . ", " . $SESIDPERFIL . ")";
		$RSL = sqlsrv_query($maestra, $SQLOG);

		// oci_execute($RSL);

		header("Location: mant_cardplan.php?ACT=" . $ID_TND . "&MSJE=3");
	}

	sqlsrv_close($conn);
	sqlsrv_close($maestra);
}

$ACTUALIZAR = $_POST["ACTUALIZAR"];

if ($ACTUALIZAR <> "")
{
	$CARDID = strtoupper($_POST["CARDID"]);
	$CARD_ID = strtoupper($_POST["CARD_ID"]);
	$CARD_DESC = strtoupper($_POST["CARD_DESC"]);
	$CONSULTA2 = "UPDATE CO_CARD_PLAN SET CARD_ID='" . $CARD_ID . "', CARD_DESC='" . $CARD_DESC . "' , CARD_IDEN='" . $CARD_ID . "00' WHERE CARD_ID='" . $CARDID . "'";
	$RS2 = sqlsrv_query($conn, $CONSULTA2);

	// oci_execute($RS2);
	// REGISTRO DE MODIFICACION

	$SQLOG = "INSERT INTO LG_EVENTO (COD_EVENTO, COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
	$SQLOG = $SQLOG . "(" . $COD_EVENTO . ", 3, convert(datetime,GETDATE(), 121), '" . $TIMESRV . "', '" . $IP_CLIENTE . "', " . $SESIDUSU . ", 1184, " . $SESIDSISTEMA . ", " . $SESIDPERFIL . ")";
	$RSL = sqlsrv_query($maestra, $SQLOG);

	// oci_execute($RSL);

	header("Location: mant_cardplan.php?ACT=" . $ID_TND . "&MSJE=1");
	sqlsrv_close($conn);
	sqlsrv_close($maestra);
}

$ELIMINAR = @$_GET["ELM"];

if ($ELIMINAR <> "")
{
	$CARD_ID = @$_GET["CARD_ID"];
	$CONSULTA = "DELETE FROM CO_CARD_PLAN WHERE CARD_ID='" . $CARD_ID . "'";
	$RS = sqlsrv_query($conn, $CONSULTA);

	// oci_execute($RS);
	// REGISTRO DE BAJA

	$SQLOG = "INSERT INTO LG_EVENTO (COD_EVENTO, COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
	$SQLOG = $SQLOG . "(" . $COD_EVENTO . ", 2, convert(datetime,GETDATE(), 121), '" . $TIMESRV . "', '" . $IP_CLIENTE . "', " . $SESIDUSU . ", 1184, " . $SESIDSISTEMA . ", " . $SESIDPERFIL . ")";
	$RSL = sqlsrv_query($maestra, $SQLOG);

	// oci_execute($RSL);

	header("Location: mant_cardplan.php?MSJE=4");
	sqlsrv_close($conn);
	sqlsrv_close($maestra);
}

?>
