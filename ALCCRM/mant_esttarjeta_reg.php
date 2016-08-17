<?php include("session.inc");?>
<?php

$INGRESAR=$_POST["INGRESAR"];

if ($INGRESAR<>"") {
		$DES_EST_TARJETA=SINCOMILLAS($_POST["DES_EST_TARJETA"]);
		$COL_ESTADO=COMILLAS($_POST["COL_ESTADO"]);
		$CSF_ESTADO=COMILLAS($_POST["CSF_ESTADO"]);
		
			$S="SELECT * FROM MN_EST_TARJETA WHERE OR UPPER(DES_EST_TARJETA)='". strtoupper($DES_EST_TARJETA). "' ";
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S);
			
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_esttarjeta.php?NEO=1&MSJE=2");
			} else {
				
				$S2="SELECT IDENT_CURRENT ('MN_EST_TARJETA') AS MCOD_EST_TARJETA";
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2);
				
				if ($row = sqlsrv_fetch_array($RS2)) {
						$COD_EST_TARJETA=$row['MCOD_EST_TARJETA']+1;
					} else {
						$COD_EST_TARJETA=1;
				}
				$S2="INSERT INTO MN_EST_TARJETA (DES_EST_TARJETA, COL_ESTADO, CSF_ESTADO, IDREG) ";
				$S2=$S2." VALUES ('".$DES_EST_TARJETA."',  '".$COL_ESTADO."','".$CSF_ESTADO."',".$SESIDUSU.")";
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2);

				//REGISTRO DE ALTA
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1134, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($maestra,$SQLOG);																	


				header("Location: mant_esttarjeta.php?ACT=".$COD_EST_TARJETA."&MSJE=3");
		}

		//sqlsrv_close($conn);
		//sqlsrv_close($maestra);
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
}
				
				
$ACTUALIZAR=$_POST["ACTUALIZAR"];

if ($ACTUALIZAR<>"") {
		$COD_EST_TARJETA=$_POST["COD_EST_TARJETA"];
		$DES_EST_TARJETA=COMILLAS($_POST["DES_EST_TARJETA"]);
		$COL_ESTADO=COMILLAS($_POST["COL_ESTADO"]);
		$CSF_ESTADO=COMILLAS($_POST["CSF_ESTADO"]);
		
			$S="SELECT * FROM MN_EST_TARJETA WHERE UPPER(DES_EST_TARJETA)='". strtoupper($DES_EST_TARJETA). "') AND COD_EST_TARJETA<>".$COD_EST_TARJETA;
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S);
			
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_esttarjeta.php?ACT=".$COD_EST_TARJETA."&MSJE=2");
			} else {
				$S2="UPDATE MN_EST_TARJETA SET DES_EST_TARJETA='".$DES_EST_TARJETA."', COL_ESTADO='".$COL_ESTADO."', CSF_ESTADO='".$CSF_ESTADO."', FECHA=convert(datetime,GETDATE(), 121), IDREG=".$SESIDUSU." WHERE COD_EST_TARJETA=".$COD_EST_TARJETA;
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2);

				//REGISTRO DE MODIFICACION
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1134, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);	
						$RSL = sqlsrv_query($maestra,$SQLOG);																

				header("Location: mant_esttarjeta.php?ACT=".$COD_EST_TARJETA."&MSJE=1");
		}

		//sqlsrv_close($conn);
		//sqlsrv_close($maestra);
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
}
				
				
$ELIMINAR=@$_GET["ELM"];

if ($ELIMINAR<>"") {
		$COD_EST_TARJETA=@$_GET["COD_EST_TARJETA"];
		
			$S="DELETE FROM MN_EST_TARJETA WHERE COD_EST_TARJETA=".$COD_EST_TARJETA;
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S);

				//REGISTRO DE BAJA
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1134, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($maestra,$SQLOG); 																

			header("Location: mant_esttarjeta.php?MSJE=4");
			sqlsrv_close( $conn );
			sqlsrv_close( $maestra );
		//sqlsrv_close($conn);
		//sqlsrv_close($maestra);
}
?>
