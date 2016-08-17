<?php include("session.inc");?>
<?php

$INGRESAR=$_POST["INGRESAR"];

if ($INGRESAR<>"") {
		$DES_TIPO_TARJETA=SINCOMILLAS($_POST["DES_TIPO_TARJETA"]);
		
			$S="SELECT * FROM MN_TIPO_TARJETA WHERE OR UPPER(DES_TIPO_TARJETA)='". strtoupper($DES_TIPO_TARJETA). "' ";
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S);

			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_tipotarjeta.php?NEO=1&MSJE=2");
			} else {
				$S2="SELECT IDENT_CURRENT ('MN_TIPO_TARJETA') AS MCOD_TIPO_TARJETA";
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2);
				
				if ($row = sqlsrv_fetch_array($RS2)) {
						$COD_TIPO_TARJETA=$row['MCOD_TIPO_TARJETA']+1;
					} else {
						$COD_TIPO_TARJETA=1;
				}
				$S2="INSERT INTO MN_TIPO_TARJETA (DES_TIPO_TARJETA, IDREG) ";
				$S2=$S2." VALUES ('".$DES_TIPO_TARJETA."', ".$SESIDUSU.")";
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2);

				//REGISTRO DE ALTA
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1141, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);	
						$RSL = sqlsrv_query($maestra,$SQLOG);																


				header("Location: mant_tipotarjeta.php?ACT=".$COD_TIPO_TARJETA."&MSJE=3");
		}
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
}
				
				
$ACTUALIZAR=$_POST["ACTUALIZAR"];

if ($ACTUALIZAR<>"") {
		$COD_TIPO_TARJETA=$_POST["COD_TIPO_TARJETA"];
		$DES_TIPO_TARJETA=COMILLAS($_POST["DES_TIPO_TARJETA"]);
		
			$S="SELECT * FROM MN_TIPO_TARJETA WHERE UPPER(DES_TIPO_TARJETA)='". strtoupper($DES_TIPO_TARJETA). "') AND COD_TIPO_TARJETA<>".$COD_TIPO_TARJETA;
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S);

			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_tipotarjeta.php?ACT=".$COD_TIPO_TARJETA."&MSJE=2");
			} else {
				$S2="UPDATE MN_TIPO_TARJETA SET DES_TIPO_TARJETA='".$DES_TIPO_TARJETA."', FECHA=convert(datetime,GETDATE(), 121), IDREG=".$SESIDUSU." WHERE COD_TIPO_TARJETA=".$COD_TIPO_TARJETA;
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2);

				//REGISTRO DE MODIFICACION
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1141, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);
						$RS = sqlsrv_query($maestra,$SQLOG);															

				header("Location: mant_tipotarjeta.php?ACT=".$COD_TIPO_TARJETA."&MSJE=1");
		}
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
}
				
				
$ELIMINAR=@$_GET["ELM"];

if ($ELIMINAR<>"") {
		$COD_TIPO_TARJETA=@$_GET["COD_TIPO_TARJETA"];
		
			$S="DELETE FROM MN_TIPO_TARJETA WHERE COD_TIPO_TARJETA=".$COD_TIPO_TARJETA;
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S);

				//REGISTRO DE BAJA
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1141, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);		
						$RSL = sqlsrv_query($maestra,$SQLOG);															

			header("Location: mant_tipotarjeta.php?MSJE=4");
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
}
?>
