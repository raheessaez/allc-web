<?php include("session.inc");?>
<?php

$INGRESAR=$_POST["INGRESAR"];

if ($INGRESAR<>"") {
		$DES_GRPDSCTO=SINCOMILLAS($_POST["DES_GRPDSCTO"]);
		
			$S="SELECT * FROM OP_GRPDSCTO WHERE OR UPPER(DES_GRPDSCTO)='". strtoupper($DES_GRPDSCTO). "' ";
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S);
			
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_grpdscto.php?NEO=1&MSJE=2");
			} else {
				$S2="SELECT IDENT_CURRENT ('OP_GRPDSCTO') AS MCOD_GRPDSCTO";
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2);
				
				if ($row = sqlsrv_fetch_array($RS2)) {
						$COD_GRPDSCTO=$row['MCOD_GRPDSCTO']+1;
					} else {
						$COD_GRPDSCTO=1;
				}

				$S2="INSERT INTO OP_GRPDSCTO (DES_GRPDSCTO, IDREG) ";
				$S2=$S2." VALUES ('".$DES_GRPDSCTO."', ".$SESIDUSU.")";
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2);

				//REGISTRO DE ALTA
					
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1135, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($maestra,$SQLOG);																


				header("Location: mant_grpdscto.php?ACT=".$COD_GRPDSCTO."&MSJE=3");
		}

		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
}
				
				
$ACTUALIZAR=$_POST["ACTUALIZAR"];

if ($ACTUALIZAR<>"") {
		$COD_GRPDSCTO=$_POST["COD_GRPDSCTO"];
		$DES_GRPDSCTO=COMILLAS($_POST["DES_GRPDSCTO"]);
		
			$S="SELECT * FROM OP_GRPDSCTO WHERE UPPER(DES_GRPDSCTO)='". strtoupper($DES_GRPDSCTO). "') AND COD_GRPDSCTO<>".$COD_GRPDSCTO;
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S);

			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_grpdscto.php?ACT=".$COD_GRPDSCTO."&MSJE=2");
			} else {
				$S2="UPDATE OP_GRPDSCTO SET DES_GRPDSCTO='".$DES_GRPDSCTO."', FECHA=convert(datetime,GETDATE(), 121), IDREG=".$SESIDUSU." WHERE COD_GRPDSCTO=".$COD_GRPDSCTO;
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2);

				//REGISTRO DE MODIFICACION
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1135, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($maestra,$SQLOG);																

				header("Location: mant_grpdscto.php?ACT=".$COD_GRPDSCTO."&MSJE=1");
		}
		sqlsrv_close( $conn );
 		sqlsrv_close( $maestra );

}
				
				
$ELIMINAR=@$_GET["ELM"];

if ($ELIMINAR<>"") {
		$COD_GRPDSCTO=@$_GET["COD_GRPDSCTO"];
		
			$S="DELETE FROM OP_GRPDSCTO WHERE COD_GRPDSCTO=".$COD_GRPDSCTO;
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S);

				//REGISTRO DE BAJA
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1135, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($maestra,$SQLOG);																	

			header("Location: mant_grpdscto.php?MSJE=4");

		 sqlsrv_close( $conn );
 		 sqlsrv_close( $maestra );
}
?>
