<?php include("session.inc");?>
<?php

$INGRESAR=$_POST["INGRESAR"];

if ($INGRESAR<>"") {
		$ID_RSN=$_POST["ID_RSN"];
		$DES_RSN_EN=SINCOMILLAS($_POST["DES_RSN_EN"]);
		$DES_RSN_ES=SINCOMILLAS($_POST["DES_RSN_ES"]);
		
			$CONSULTA="SELECT ID_RSN FROM MGR_OVRD_RSN WHERE ID_RSN='".$ID_RSN."'";
			$RS = sqlsrv_query($conn, $CONSULTA);
			////oci_execute($RS);
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_override.php?NEO=1&MSJE=2");
			} else {

				$CONSULTA2="INSERT INTO MGR_OVRD_RSN (ID_RSN, DES_RSN_EN, DES_RSN_ES) ";
				$CONSULTA2=$CONSULTA2." VALUES ('".$ID_RSN."', '".$DES_RSN_EN."', '".$DES_RSN_ES."')";
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				////oci_execute($RS2);

				//REGISTRO DE ALTA
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."( 1,convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1122, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);																	


				header("Location: mant_override.php?ACT=".$ID_RSN."&MSJE=3");
		}
		sqlsrv_close($conn);
		sqlsrv_close($maestra);
}
				
				
$ACTUALIZAR=$_POST["ACTUALIZAR"];

if ($ACTUALIZAR<>"") {
		$ID_RSN=$_POST["ID_RSN"];
		$DES_RSN_EN=SINCOMILLAS($_POST["DES_RSN_EN"]);
		$DES_RSN_ES=SINCOMILLAS($_POST["DES_RSN_ES"]);
		
				$CONSULTA2="UPDATE MGR_OVRD_RSN SET DES_RSN_EN='".$DES_RSN_EN."', DES_RSN_ES='".$DES_RSN_ES."' WHERE ID_RSN=".$ID_RSN;
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				////oci_execute($RS2);

				//REGISTRO DE MODIFICACION
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."( 1,convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1122, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);																	

				header("Location: mant_override.php?ACT=".$ID_RSN."&MSJE=1");

		sqlsrv_close($conn);
		sqlsrv_close($maestra);
}
				
				
?>
