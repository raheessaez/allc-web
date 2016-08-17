<?php include("session.inc");?>
<?php

$INGRESAR=$_POST["INGRESAR"];

if ($INGRESAR<>"") {
		$DES_MARCAPRC=SINCOMILLAS($_POST["DES_MARCAPRC"]);
		
			$S="SELECT * FROM OP_MARCAPRC WHERE OR UPPER(DES_MARCAPRC)='". strtoupper($DES_MARCAPRC). "' ";
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S); 
			
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_marcaprc.php?NEO=1&MSJE=2");
			} else {
				
				$S2="SELECT IDENT_CURRENT ('OP_MARCAPRC') AS MCOD_MARCAPRC";
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2); 
				
				if ($row = sqlsrv_fetch_array($RS2)) {
						$COD_MARCAPRC=$row['MCOD_MARCAPRC']+1;
					} else {
						$COD_MARCAPRC=1;
				}

				$S2="INSERT INTO OP_MARCAPRC (DES_MARCAPRC, IDREG) ";
				$S2=$S2." VALUES ('".$DES_MARCAPRC."', ".$SESIDUSU.")";
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2); 

				//REGISTRO DE ALTA
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1136, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($maestra,$SQLOG);															


				header("Location: mant_marcaprc.php?ACT=".$COD_MARCAPRC."&MSJE=3");
		}
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
}
				
				
$ACTUALIZAR=$_POST["ACTUALIZAR"];

if ($ACTUALIZAR<>"") {
		$COD_MARCAPRC=$_POST["COD_MARCAPRC"];
		$DES_MARCAPRC=COMILLAS($_POST["DES_MARCAPRC"]);
		
			$S="SELECT * FROM OP_MARCAPRC WHERE UPPER(DES_MARCAPRC)='". strtoupper($DES_MARCAPRC). "') AND COD_MARCAPRC<>".$COD_MARCAPRC;
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S); 
			
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_marcaprc.php?ACT=".$COD_MARCAPRC."&MSJE=2");
			} else {
				$S2="UPDATE OP_MARCAPRC SET DES_MARCAPRC='".$DES_MARCAPRC."', FECHA=convert(datetime,GETDATE(), 121), IDREG=".$SESIDUSU." WHERE COD_MARCAPRC=".$COD_MARCAPRC;
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2); 
				//REGISTRO DE MODIFICACION
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1136, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);																	
						$RS = sqlsrv_query($maestra,$SQLOG);

				header("Location: mant_marcaprc.php?ACT=".$COD_MARCAPRC."&MSJE=1");
		}
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
}
				
				
$ELIMINAR=@$_GET["ELM"];

if ($ELIMINAR<>"") {
		$COD_MARCAPRC=@$_GET["COD_MARCAPRC"];
		
			$S="DELETE FROM OP_MARCAPRC WHERE COD_MARCAPRC=".$COD_MARCAPRC;
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S);

				//REGISTRO DE BAJA
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1136, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($maestra,$SQLOG);																

			header("Location: mant_marcaprc.php?MSJE=4");
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
}
?>
