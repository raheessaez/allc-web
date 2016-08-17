<?php include("session.inc");?>
<?php

$INGRESAR=$_POST["INGRESAR"];

if ($INGRESAR<>"") {
		$DES_DEMOGRAF=SINCOMILLAS($_POST["DES_DEMOGRAF"]);
		
			$S="SELECT * FROM MN_DEMOGRAF WHERE OR UPPER(DES_DEMOGRAF)='". strtoupper($DES_DEMOGRAF). "' ";
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S);
			
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_escolar.php?NEO=1&MSJE=2");
			} else {
				$S2="SELECT IDENT_CURRENT ('MN_DEMOGRAF') AS MCOD_DEMOGRAF";
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2);
				
				if ($row = sqlsrv_fetch_array($RS2)) {
						$COD_DEMOGRAF=$row['MCOD_DEMOGRAF']+1;
					} else {
						$COD_DEMOGRAF=1;
				}
				$S2="INSERT INTO MN_DEMOGRAF (DES_DEMOGRAF, IDREG) ";
				$S2=$S2." VALUES ('".$DES_DEMOGRAF."', ".$SESIDUSU.")";
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2);

				//REGISTRO DE ALTA
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1138, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);	
						$RSL = sqlsrv_query($maestra,$SQLOG);															


				header("Location: mant_escolar.php?ACT=".$COD_DEMOGRAF."&MSJE=3");
		}
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
}
				
				
$ACTUALIZAR=$_POST["ACTUALIZAR"];

if ($ACTUALIZAR<>"") {
		$COD_DEMOGRAF=$_POST["COD_DEMOGRAF"];
		$DES_DEMOGRAF=COMILLAS($_POST["DES_DEMOGRAF"]);
		
			$S="SELECT * FROM MN_DEMOGRAF WHERE UPPER(DES_DEMOGRAF)='". strtoupper($DES_DEMOGRAF). "') AND COD_DEMOGRAF<>".$COD_DEMOGRAF;
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S);

			
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_escolar.php?ACT=".$COD_DEMOGRAF."&MSJE=2");
			} else {
				$S2="UPDATE MN_DEMOGRAF SET DES_DEMOGRAF='".$DES_DEMOGRAF."', FECHA=convert(datetime,GETDATE(), 121), IDREG=".$SESIDUSU." WHERE COD_DEMOGRAF=".$COD_DEMOGRAF;
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2); 

				//REGISTRO DE MODIFICACION
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1138, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($maestra,$SQLOG);																

				header("Location: mant_escolar.php?ACT=".$COD_DEMOGRAF."&MSJE=1");
		}
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
}
				
				
$ELIMINAR=@$_GET["ELM"];

if ($ELIMINAR<>"") {
		$COD_DEMOGRAF=@$_GET["COD_DEMOGRAF"];
		
			$S="DELETE FROM MN_DEMOGRAF WHERE COD_DEMOGRAF=".$COD_DEMOGRAF;
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S);

				//REGISTRO DE BAJA

						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1138, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($maestra,$SQLOG);																

			header("Location: mant_escolar.php?MSJE=4");
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
}
?>
