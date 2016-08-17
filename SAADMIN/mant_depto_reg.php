<?php include("session.inc");?>
<?php

$INGRESAR=$_POST["INGRESAR"];

if ($INGRESAR<>"") {
		$DES_DEPARTAMENTO=SINCOMILLAS($_POST["DES_DEPARTAMENTO"]);
		
			$S="SELECT * FROM PM_DEPARTAMENTO WHERE OR UPPER(DES_DEPARTAMENTO)='". strtoupper($DES_DEPARTAMENTO). "' ";
			$RS = sqlsrv_query($conn, $S);
			//oci_execute($RS);
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_depto.php?NEO=1&MSJE=2");
			} else {
				$S2="SELECT MAX(COD_DEPARTAMENTO) AS MCOD_DEPARTAMENTO FROM PM_DEPARTAMENTO";
				$RS2 = sqlsrv_query($conn, $S2);
				//oci_execute($RS2);
				if ($row = sqlsrv_fetch_array($RS2)) {
						$COD_DEPARTAMENTO=$row['MCOD_DEPARTAMENTO']+1;
					} else {
						$COD_DEPARTAMENTO=1;
				}
				$S2="INSERT INTO PM_DEPARTAMENTO (COD_DEPARTAMENTO, DES_DEPARTAMENTO, IDREG) ";
				$S2=$S2." VALUES (".$COD_DEPARTAMENTO.", '".$DES_DEPARTAMENTO."', ".$SESIDUSU.")";
				$RS2 = sqlsrv_query($conn, $S2);
				//oci_execute($RS2);

				//REGISTRO DE ALTA
						$S2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";
						$RS2 = sqlsrv_query($conn, $S2);
						//oci_execute($RS2);
						if ($row = sqlsrv_fetch_array($RS2)) {
								$COD_EVENTO=$row['MCOD_EVENTO']+1;
							} else {
								$COD_EVENTO=1;
						}
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."( 1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1116, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($conn, $SQLOG);
						//oci_execute($RSL);																	


				header("Location: mant_depto.php?ACT=".$COD_DEPARTAMENTO."&MSJE=3");
		}
		sqlsrv_close($conn);
}
				
				
$ACTUALIZAR=$_POST["ACTUALIZAR"];

if ($ACTUALIZAR<>"") {
		$COD_DEPARTAMENTO=$_POST["COD_DEPARTAMENTO"];
		$DES_DEPARTAMENTO=COMILLAS($_POST["DES_DEPARTAMENTO"]);
		
			$S="SELECT * FROM PM_DEPARTAMENTO WHERE UPPER(DES_DEPARTAMENTO)='". strtoupper($DES_DEPARTAMENTO). "') AND COD_DEPARTAMENTO<>".$COD_DEPARTAMENTO;
			$RS = sqlsrv_query($conn, $S);
			//oci_execute($RS);
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_depto.php?ACT=".$COD_DEPARTAMENTO."&MSJE=2");
			} else {
				$S2="UPDATE PM_DEPARTAMENTO SET DES_DEPARTAMENTO='".$DES_DEPARTAMENTO."', FECHA=convert(datetime,GETDATE(), 121), IDREG=".$SESIDUSU." WHERE COD_DEPARTAMENTO=".$COD_DEPARTAMENTO;
				$RS2 = sqlsrv_query($conn, $S2);
				//oci_execute($RS2);

				//REGISTRO DE MODIFICACION
						$S2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";
						$RS2 = sqlsrv_query($conn, $S2);
						//oci_execute($RS2);
						if ($row = sqlsrv_fetch_array($RS2)) {
								$COD_EVENTO=$row['MCOD_EVENTO']+1;
							} else {
								$COD_EVENTO=1;
						}
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."( 3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1116, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($conn, $SQLOG);
						//oci_execute($RSL);																	

				header("Location: mant_depto.php?ACT=".$COD_DEPARTAMENTO."&MSJE=1");
		}
		sqlsrv_close($conn);
}
?>
