<?php
include ("session.inc");

?>

<?php
$INGRESAR = $_POST["INGRESAR"];

if ($INGRESAR <> "")
{
	$CARD_ID = strtoupper($_POST["CARD_ID"]);
	$DESC_SUB = strtoupper($_POST["DESC_SUB"]);
	// //oci_execute($RS);
	$MAX_ID=0;
	$Q = "SELECT ID FROM SUB_CARD_PLAN_ID WHERE CARD_ID='".$CARD_ID."' AND DESC_SUB='".$DESC_SUB."'";
	$RQ = sqlsrv_query($conn, $Q);
	// oci_execute($RESC);
	if ($RWQ = sqlsrv_fetch_array($RQ))
	{
		header("Location: mant_sub_card.php?NEO=1&MSJE=2");
	}
	else
	{
		$CRD = "SELECT MAX(ID) as MAX_ID FROM SUB_CARD_PLAN_ID";
		$RESC = sqlsrv_query($conn, $CRD);
		// oci_execute($RESC);
		if ($RW1 = sqlsrv_fetch_array($RESC))
		{
			$MAX_ID=$RW1["MAX_ID"];
		}
		$MAX_ID++;
		$CONSULTA2 = "INSERT INTO SUB_CARD_PLAN_ID (ID, CARD_ID,DESC_SUB) ";
		$CONSULTA2 = $CONSULTA2 . " VALUES (" . $MAX_ID . ", '" . $CARD_ID . "', '" . $DESC_SUB . "')";
		$RS2 = sqlsrv_query($conn, $CONSULTA2);
	
		// oci_execute($RS2);
		// REGISTRO DE ALTA
	
		$SQLOG = "INSERT INTO LG_EVENTO (COD_EVENTO, COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
		$SQLOG = $SQLOG . "(" . $COD_EVENTO . ", 1, convert(datetime,GETDATE(), 121), '" . $TIMESRV . "', '" . $IP_CLIENTE . "', " . $SESIDUSU . ", 3184, " . $SESIDSISTEMA . ", " . $SESIDPERFIL . ")";
		$RSL = sqlsrv_query($maestra, $SQLOG);
	
		// oci_execute($RSL);
	
		header("Location: mant_sub_card.php?ACT=" . $MAX_ID . "&MSJE=3");
		}
	sqlsrv_close($conn);
	sqlsrv_close($maestra);
}

$ACTUALIZAR = $_POST["ACTUALIZAR"];

if ($ACTUALIZAR <> "")
{
	$ID = strtoupper($_POST["ID"]);
	$CARD_ID = strtoupper($_POST["CARD_ID"]);
	$DESC_SUB = strtoupper($_POST["DESC_SUB"]);
	$CONSULTA2 = "UPDATE SUB_CARD_PLAN_ID SET DESC_SUB='" . $DESC_SUB . "' , CARD_ID='" . $CARD_ID . "' WHERE ID='" . $ID . "'";
	$RS2 = sqlsrv_query($conn, $CONSULTA2);

	// oci_execute($RS2);
	// REGISTRO DE MODIFICACION

	$SQLOG = "INSERT INTO LG_EVENTO (COD_EVENTO, COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
	$SQLOG = $SQLOG . "(" . $COD_EVENTO . ", 3, convert(datetime,GETDATE(), 121), '" . $TIMESRV . "', '" . $IP_CLIENTE . "', " . $SESIDUSU . ", 3184, " . $SESIDSISTEMA . ", " . $SESIDPERFIL . ")";
	$RSL = sqlsrv_query($maestra, $SQLOG);

	// oci_execute($RSL);

	header("Location: mant_sub_card.php?ACT=" . $ID . "&MSJE=1");
	sqlsrv_close($conn);
	sqlsrv_close($maestra);
}

$ELIMINAR = @$_GET["ELM"];

if ($ELIMINAR <> "")
{
	$ID = @$_GET["ID"];
	$CONSULTA = "DELETE FROM SUB_CARD_PLAN_ID WHERE ID='" . $ID . "'";
	$RS = sqlsrv_query($conn, $CONSULTA);

	// oci_execute($RS);
	// REGISTRO DE BAJA

	$SQLOG = "INSERT INTO LG_EVENTO (COD_EVENTO, COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
	$SQLOG = $SQLOG . "(" . $COD_EVENTO . ", 2, convert(datetime,GETDATE(), 121), '" . $TIMESRV . "', '" . $IP_CLIENTE . "', " . $SESIDUSU . ", 3184, " . $SESIDSISTEMA . ", " . $SESIDPERFIL . ")";
	$RSL = sqlsrv_query($maestra, $SQLOG);

	// oci_execute($RSL);

	header("Location: mant_sub_card.php?MSJE=4");
	sqlsrv_close($conn);
	sqlsrv_close($maestra);
}

?>
