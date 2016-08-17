<?php include("session.inc");?>
<?php

$INGRESAR=$_POST["INGRESAR"];

if ($INGRESAR<>"") {
		$DES_NEGOCIO=SINCOMILLAS($_POST["DES_NEGOCIO"]);
		
			$S="SELECT * FROM MN_NEGOCIO WHERE UPPER(DES_NEGOCIO)='". strtoupper($DES_NEGOCIO). "' ";
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);

			$RS = sqlsrv_query($conn,$S);

			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_tiponeg.php?NEO=1&MSJE=2");
			} else {
				$S2="SELECT MAX(COD_NEGOCIO) AS MCOD_NEGOCIO FROM MN_NEGOCIO";
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2);

				if ($row = sqlsrv_fetch_array($RS2)) {
						$COD_NEGOCIO=$row['MCOD_NEGOCIO']+1;
					} else {
						$COD_NEGOCIO=1;
				}
				// COD_NEGOCIO AUTO INCREMENT SQL SERVER
				//$S2="INSERT INTO MN_NEGOCIO (COD_NEGOCIO, DES_NEGOCIO, IDREG) ";
				//$S2=$S2." VALUES (".$COD_NEGOCIO.", '".$DES_NEGOCIO."', ".$SESIDUSU.")";
				$S2="INSERT INTO MN_NEGOCIO (DES_NEGOCIO, IDREG) ";
				$S2=$S2." VALUES ('".$DES_NEGOCIO."', ".$SESIDUSU.")";
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2);

				//REGISTRO DE ALTA
						$S2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";
						
						//$RS2 = sqlsrv_query($conn, $S2);
						////oci_execute($RS2);
						$RS2 = sqlsrv_query($conn,$S2);
						
						if ($row = sqlsrv_fetch_array($RS2)) {
								$COD_EVENTO=$row['MCOD_EVENTO']+1;
							} else {
								$COD_EVENTO=1;
						}
						// Cambio en Consulta COD_EVENTO Ahora auto_increment
						//$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";

						//$SQLOG=$SQLOG."( 1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1112, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$SQLOG=$SQLOG."(1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1112, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						//$RSL = sqlsrv_query($conn, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($conn,$SQLOG);																	


				header("Location: mant_tiponeg.php?ACT=".$COD_NEGOCIO."&MSJE=3");
		}
		//sqlsrv_close($conn);
		sqlsrv_close( $conn );
}
				
				
$ACTUALIZAR=$_POST["ACTUALIZAR"];

if ($ACTUALIZAR<>"") {
		$COD_NEGOCIO=$_POST["COD_NEGOCIO"];
		$DES_NEGOCIO=COMILLAS($_POST["DES_NEGOCIO"]);
		
			$S="SELECT * FROM MN_NEGOCIO WHERE UPPER(DES_NEGOCIO)='". strtoupper($DES_NEGOCIO). "') AND COD_NEGOCIO <> ".$COD_NEGOCIO;
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S);	
			
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_tiponeg.php?ACT=".$COD_NEGOCIO."&MSJE=2");
			} else {
				
				$S2="UPDATE MN_NEGOCIO SET DES_NEGOCIO='".$DES_NEGOCIO."', FECHA= convert(datetime, convert(datetime,GETDATE(), 121), 121), IDREG=".$SESIDUSU." WHERE COD_NEGOCIO=".$COD_NEGOCIO;
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2);

				//REGISTRO DE MODIFICACION
						$S2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";
						//$RS2 = sqlsrv_query($conn, $S2);
						////oci_execute($RS2);
						$RS2 = sqlsrv_query($conn,$S2);

						if ($row = sqlsrv_fetch_array($RS2)) {
								$COD_EVENTO=$row['MCOD_EVENTO']+1;
							} else {
								$COD_EVENTO=1;
						}
						// COD_EVENTO AUTO INCREMENT EN SQL SERVER
						//$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						//$SQLOG=$SQLOG."( 3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1112, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";

						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1112, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						//$RSL = sqlsrv_query($conn, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($conn,$SQLOG);																	

				header("Location: mant_tiponeg.php?ACT=".$COD_NEGOCIO."&MSJE=1");
		}
		//sqlsrv_close($conn);
		sqlsrv_close( $conn );
}
				
				
$ELIMINAR=@$_GET["ELM"];

if ($ELIMINAR<>"") {
	
		$COD_NEGOCIO=@$_GET["COD_NEGOCIO"];
		
			$S="DELETE FROM MN_NEGOCIO WHERE COD_NEGOCIO=".$COD_NEGOCIO;
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S);

				//REGISTRO DE BAJA
						$S2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";
						//$RS2 = sqlsrv_query($conn, $S2);
						////oci_execute($RS2);
						$RS2 = sqlsrv_query($conn,$S2);

						if ($row = sqlsrv_fetch_array($RS2)) { 
								$COD_EVENTO=$row['MCOD_EVENTO']+1;
							} else {
								$COD_EVENTO=1;
						}
						// COD_EVENTO AUTO INCREMENT EN SQL SERVER
						//$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						//$SQLOG=$SQLOG."( 2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1112, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1112, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						//$RSL = sqlsrv_query($conn, $SQLOG);
						////oci_execute($RSL);																
						$RSL = sqlsrv_query($conn,$SQLOG);

			header("Location: mant_tiponeg.php?MSJE=4");
		sqlsrv_close( $conn );
}
?>
