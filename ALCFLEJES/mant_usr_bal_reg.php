<?php
include("session.inc");
?>

<?php
$INGRESAR = $_POST["INGRESAR"];
if ($INGRESAR <> "") {
	
	$LOGIN_I      = $_POST["LOGIN_I"];
	$NOMBRE_USER = strtoupper($_POST["NOMBRE_USER"]);
	$CLAVE = $_POST["CLAVE"];
	$TIENDA = $_POST["TIENDA"];
	
	
	$CONSULTA     = "SELECT LOGIN_I FROM T_USERBALANZA WHERE LOGIN_I=" . $LOGIN_I;
	$RS           = sqlsrv_query($conn, $CONSULTA);
	//oci_execute($RS);
	if ($row = sqlsrv_fetch_array($RS)) {
		header("Location: mant_ usr_bal.php?NEO=1&MSJE=2");
	} else {
		$CONSULTA2 = "INSERT INTO T_USERBALANZA (LOGIN_I,NOMBRE_USER,CLAVE,FCH_ULT_CAMBIO,DES_CLAVE) ";
		$CONSULTA2 = $CONSULTA2 . " VALUES ('" . $LOGIN_I . "','" . $NOMBRE_USER . "','".$CLAVE."',convert(datetime,GETDATE(), 121),".$TIENDA.")";
		$RS2       = sqlsrv_query($conn, $CONSULTA2);
		//oci_execute($RS2);
		//REGISTRO DE ALTA
		
		$SQLOG = "INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
		$SQLOG = $SQLOG . "(1, convert(datetime,GETDATE(), 121) , '" . $TIMESRV . "', '" . $IP_CLIENTE . "', " . $SESIDUSU . ", 1182, " . $SESIDSISTEMA . ", " . $SESIDPERFIL . ")";
		$RSL   = sqlsrv_query($maestra, $SQLOG);
		//oci_execute($RSL);
		header("Location: mant_usr_bal.php?ACT=" . $LOGIN_I . "&MSJE=3");
	}
	sqlsrv_close($conn);
	sqlsrv_close($maestra);
}

$ACTUALIZAR = $_POST["ACTUALIZAR"];
if ($ACTUALIZAR <> "") {
	$LOGIN_I      = $_POST["LOGIN_I"];
	$LOGIN_I_ANTERIOR      = $_POST["LOGIN_I_ANTERIOR"];
	$NOMBRE_USER = strtoupper($_POST["NOMBRE_USER"]);
	$CLAVE = $_POST["CLAVE"];
	$TIENDA = $_POST["TIENDA"];
	
	
	$C2               = "UPDATE T_USERBALANZA SET LOGIN_I='" . $LOGIN_I . "',NOMBRE_USER='" . $NOMBRE_USER . "',CLAVE='" . $CLAVE . "',FCH_ULT_CAMBIO= convert(datetime,GETDATE(), 121), DES_CLAVE = ".$TIENDA." WHERE LOGIN_I='" . $LOGIN_I_ANTERIOR . "'";
	$RS2              = sqlsrv_query($conn, $C2);
	//oci_execute($RS2);
	//REGISTRO DE MODIFICACION
	
	$SQLOG = "INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
	$SQLOG = $SQLOG . "(3,convert(datetime,GETDATE(), 121), '" . $TIMESRV . "', '" . $IP_CLIENTE . "', " . $SESIDUSU . ", 1182, " . $SESIDSISTEMA . ", " . $SESIDPERFIL . ")";
	$RSL   = sqlsrv_query($maestra, $SQLOG);
	//oci_execute($RSL);
	header("Location: mant_usr_bal.php?ACT=" . $LOGIN_I . "&MSJE=1");
	sqlsrv_close($conn);
	sqlsrv_close($maestra);
}

$ELIMINAR = @$_GET["ELM"];
if ($ELIMINAR <> "") {
	
	$LOGIN_I  = @$_GET["LOGIN_I"];
	$CONSULTA = "DELETE FROM T_USERBALANZA WHERE LOGIN_I='" . $LOGIN_I."'";
	$RS       = sqlsrv_query($conn, $CONSULTA);
	//oci_execute($RS);
	
	//REGISTRO DE BAJA
	
	$SQLOG = "INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
	$SQLOG = $SQLOG . "(2,convert(datetime,GETDATE(), 121), '" . $TIMESRV . "', '" . $IP_CLIENTE . "', " . $SESIDUSU . ", 1182, " . $SESIDSISTEMA . ", " . $SESIDPERFIL . ")";
	$RSL   = sqlsrv_query($maestra, $SQLOG);
	//oci_execute($RSL);
	header("Location: mant_usr_bal.php?MSJE=4");
	sqlsrv_close($conn);
	sqlsrv_close($maestra);
	
}
?>

