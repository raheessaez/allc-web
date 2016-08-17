<?php include("session.inc");?>
<?php

$INGRESAR=$_POST["INGRESAR"];

if ($INGRESAR<>"") {
		$DES_TIPOCLIENTE=SINCOMILLAS($_POST["DES_TIPOCLIENTE"]);
		
			$S="SELECT * FROM PM_TIPOCLIENTE WHERE OR UPPER(DES_TIPOCLIENTE)='". strtoupper($DES_TIPOCLIENTE). "' ";
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S);

			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_tipocliente.php?NEO=1&MSJE=2");
			} else {
				$S2="SELECT IDENT_CURRENT ('PM_TIPOCLIENTE') AS MCOD_TIPOCLIENTE";
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2); 
				
				if ($row = sqlsrv_fetch_array($RS2)) {
						$COD_TIPOCLIENTE=$row['MCOD_TIPOCLIENTE']+1;
					} else {
						$COD_TIPOCLIENTE=1;
				}

				$S2="INSERT INTO PM_TIPOCLIENTE (DES_TIPOCLIENTE, IDREG) ";
				$S2=$S2." VALUES ('".$DES_TIPOCLIENTE."', ".$SESIDUSU.")";
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				
				$RS2 = sqlsrv_query($conn,$S2); 

				//REGISTRO DE ALTA
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1139, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($maestra,$SQLOG); 																	


				header("Location: mant_tipocliente.php?ACT=".$COD_TIPOCLIENTE."&MSJE=3");
		}
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
}
				
				
$ACTUALIZAR=$_POST["ACTUALIZAR"];

if ($ACTUALIZAR<>"") {
		$COD_TIPOCLIENTE=$_POST["COD_TIPOCLIENTE"];
		$DES_TIPOCLIENTE=COMILLAS($_POST["DES_TIPOCLIENTE"]);
		
			$S="SELECT * FROM PM_TIPOCLIENTE WHERE UPPER(DES_TIPOCLIENTE)='". strtoupper($DES_TIPOCLIENTE). "') AND COD_TIPOCLIENTE<>".$COD_TIPOCLIENTE;
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S); 
			
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_tipocliente.php?ACT=".$COD_TIPOCLIENTE."&MSJE=2");
			} else {
				$S2="UPDATE PM_TIPOCLIENTE SET DES_TIPOCLIENTE='".$DES_TIPOCLIENTE."', FECHA=convert(datetime,GETDATE(), 121), IDREG=".$SESIDUSU." WHERE COD_TIPOCLIENTE=".$COD_TIPOCLIENTE;
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2); 

				//REGISTRO DE MODIFICACION
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1139, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($maestra,$SQLOG); 																	

				header("Location: mant_tipocliente.php?ACT=".$COD_TIPOCLIENTE."&MSJE=1");
		}
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
}
				
				
$ELIMINAR=@$_GET["ELM"];

if ($ELIMINAR<>"") {
		$COD_TIPOCLIENTE=@$_GET["COD_TIPOCLIENTE"];
		
			$S="DELETE FROM PM_TIPOCLIENTE WHERE COD_TIPOCLIENTE=".$COD_TIPOCLIENTE;
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S); 

				//REGISTRO DE BAJA
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1139, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($maestra,$SQLOG); 																

			header("Location: mant_tipocliente.php?MSJE=4");
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
}
?>
