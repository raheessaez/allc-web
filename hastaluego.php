<?php include("SAADMIN/session.inc"); ?>
<?php include("headerhtml.inc"); ?>
<?php

		//REGISTRO DE CIERRE DE SESION

				//**COD_EVENTO AHORA ES AUTO INCREMENT, ESTA CONSULTA NO ES REQUERIDA

				//$CONSULTA2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";
				//$RS2 = sqlsrv_query($conn, $CONSULTA2);
				////oci_execute($RS2);
				//$RS2 = sqlsrv_query($conn,$CONSULTA2);

				//if ($row = sqlsrv_fetch_array($RS2)) {
				//		$COD_EVENTO=$row['MCOD_EVENTO']+1;
				//		} else {
				//		$COD_EVENTO=1;
				//}

				$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
				$SQLOG=$SQLOG."(5, '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 0, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";

				//$RSL = sqlsrv_query($conn, $SQLOG);
				////oci_execute($RSL);	

				$RSL = sqlsrv_query($conn,$SQLOG);													

		session_unset();
		session_destroy();
?>
<SCRIPT LANGUAGE="JavaScript">
function autoRefresh() {
   parent.location.href="index.php";
}
function refreshAdv(refreshTime,refreshColor) {
   setTimeout('autoRefresh()',refreshTime)
}
</SCRIPT>

</head>
<body onLoad="refreshAdv(3000,'#FFFFFF');">
<div class="contenedor">
	<img src="images/bye.png"></td>
</div>
</body>
</html>

