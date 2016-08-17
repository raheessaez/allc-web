<?php include("session.inc");?>
<?php

$INGRESAR=$_POST["INGRESAR"];

if ($INGRESAR<>"") {
		$DES_TIPOID=SINCOMILLAS($_POST["DES_TIPOID"]);
		$TIPO_PERSONA=$_POST["TIPO_PERSONA"];
		
			$S="SELECT * FROM PM_TIPOID WHERE OR UPPER(DES_TIPOID)='". strtoupper($DES_TIPOID). "' ";
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S); 
			
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_tipoident.php?NEO=1&MSJE=2");
			} else {
				$S2="SELECT IDENT_CURRENT ('PM_TIPOID') AS MCOD_TIPOID";
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2);
				
				if ($row = sqlsrv_fetch_array($RS2)) {
						$COD_TIPOID=$row['MCOD_TIPOID']+1;
					} else {
						$COD_TIPOID=1;
				}
				$S2="INSERT INTO PM_TIPOID (DES_TIPOID, TIPO_PERSONA, IDREG) ";
				$S2=$S2." VALUES ('".$DES_TIPOID."', ".$TIPO_PERSONA.", ".$SESIDUSU.")";
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2);
				//REGISTRO DE ALTA
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1140, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($maestra,$SQLOG);															


				header("Location: mant_tipoident.php?ACT=".$COD_TIPOID."&MSJE=3");
		}
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
}
				
				
$ACTUALIZAR=$_POST["ACTUALIZAR"];

if ($ACTUALIZAR<>"") {
		$COD_TIPOID=$_POST["COD_TIPOID"];
		$DES_TIPOID=COMILLAS($_POST["DES_TIPOID"]);
		$TIPO_PERSONA=$_POST["TIPO_PERSONA"];
		
			$S="SELECT * FROM PM_TIPOID WHERE UPPER(DES_TIPOID)='". strtoupper($DES_TIPOID). "') AND COD_TIPOID<>".$COD_TIPOID;
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S);
			
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_tipoident.php?ACT=".$COD_TIPOID."&MSJE=2");
			} else {
				$S2="UPDATE PM_TIPOID SET DES_TIPOID='".$DES_TIPOID."', TIPO_PERSONA=".$TIPO_PERSONA." , FECHA=convert(datetime,GETDATE(), 121), IDREG=".$SESIDUSU." WHERE COD_TIPOID=".$COD_TIPOID;
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2);

				//REGISTRO DE MODIFICACION
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1140, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);	
						$RSL = sqlsrv_query($maestra,$SQLOG);														

				header("Location: mant_tipoident.php?ACT=".$COD_TIPOID."&MSJE=1");
		}
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
}
				
				
$ELIMINAR=@$_GET["ELM"];

if ($ELIMINAR<>"") {
		$COD_TIPOID=@$_GET["COD_TIPOID"];
		
			$S="DELETE FROM PM_TIPOID WHERE COD_TIPOID=".$COD_TIPOID;
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S);

				//REGISTRO DE BAJA
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1140, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($maestra,$SQLOG);																

			header("Location: mant_tipoident.php?MSJE=4");
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
}
?>
