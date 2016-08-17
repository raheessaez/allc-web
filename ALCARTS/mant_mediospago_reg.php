<?php include("session.inc");?>
<?php

$INGRESAR=$_POST["INGRESAR"];

if ($INGRESAR<>"") {
		$ID_TND=$_POST["ID_TND"];
		$TY_TND=SINCOMILLAS($_POST["TY_TND"]);
		$DE_TND=SINCOMILLAS($_POST["DE_TND"]);
		$LU_CLS_TND=$_POST["LU_CLS_TND"];
		if(empty($LU_CLS_TND)){$LU_CLS_TND=0;}
		$FL_TND_DSBL=$_POST["FL_TND_DSBL"];
		if(empty($FL_TND_DSBL)){$FL_TND_DSBL=0;}
		
			$CONSULTA="SELECT ID_TND FROM AS_TND WHERE ID_TND=".$ID_TND;
			$RS = sqlsrv_query($conn, $CONSULTA);
			////oci_execute($RS);
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_mediospago.php?NEO=1&MSJE=2");
			} else {
				$CONSULTA2="INSERT INTO AS_TND (ID_TND, TY_TND, DE_TND, LU_CLS_TND, FL_TND_DSBL) ";
				$CONSULTA2=$CONSULTA2." VALUES (".$ID_TND.", '".$TY_TND."', '".$DE_TND."', ".$LU_CLS_TND.", ".$FL_TND_DSBL.")";
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				////oci_execute($RS2);

				//REGISTRO DE ALTA
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1121, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);																	


				header("Location: mant_mediospago.php?ACT=".$ID_TND."&MSJE=3");
		}
		sqlsrv_close($conn);
		sqlsrv_close($maestra);
}
				
				
$ACTUALIZAR=$_POST["ACTUALIZAR"];

if ($ACTUALIZAR<>"") {
		$ID_TND=$_POST["ID_TND"];
		$TY_TND=SINCOMILLAS($_POST["TY_TND"]);
		$DE_TND=SINCOMILLAS($_POST["DE_TND"]);
		$LU_CLS_TND=$_POST["LU_CLS_TND"];
		if(empty($LU_CLS_TND)){$LU_CLS_TND=0;}
		$FL_TND_DSBL=$_POST["FL_TND_DSBL"];
		if(empty($FL_TND_DSBL)){$FL_TND_DSBL=0;}
		
				$CONSULTA2="UPDATE AS_TND SET TY_TND='".$TY_TND."', DE_TND='".$DE_TND."', LU_CLS_TND=".$LU_CLS_TND." , FL_TND_DSBL=".$FL_TND_DSBL." WHERE ID_TND=".$ID_TND;
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				////oci_execute($RS2);

				//REGISTRO DE MODIFICACION
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1121, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);																	

				header("Location: mant_mediospago.php?ACT=".$ID_TND."&MSJE=1");

		sqlsrv_close($conn);
		sqlsrv_close($maestra);
}
				
				
$ELIMINAR=@$_GET["ELM"];

if ($ELIMINAR<>"") {
		$ID_TND=@$_GET["ID_TND"];
		
			$CONSULTA="DELETE FROM AS_TND WHERE ID_TND=".$ID_TND;
			$RS = sqlsrv_query($conn, $CONSULTA);
			////oci_execute($RS);

				//REGISTRO DE BAJA
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1121, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);																	

			header("Location: mant_mediospago.php?MSJE=4");
		sqlsrv_close($conn);
		sqlsrv_close($maestra);
}
?>
