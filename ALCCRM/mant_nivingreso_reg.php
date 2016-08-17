<?php include("session.inc");?>
<?php

$INGRESAR=$_POST["INGRESAR"];

if ($INGRESAR<>"") {
		$MIN_INGRESO=$_POST["MIN_INGRESO"];
		$MAX_INGRESO=$_POST["MAX_INGRESO"];
		if($MIN_INGRESO>$MAX_INGRESO){
				$PASOINGRESO=$MAX_INGRESO;
				$MAX_INGRESO=$MIN_INGRESO;
				$MIN_INGRESO=$PASOINGRESO;
		}
		
			$S="SELECT * FROM MN_INGRESO WHERE MIN_INGRESO=".$MIN_INGRESO." AND MAX_INGRESO=".$MAX_INGRESO;
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S);
			
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_nivingreso.php?NEO=1&MSJE=2");
			} else {
				$S2="SELECT IDENT_CURRENT ('MN_INGRESO') AS MCOD_INGRESO";
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2);
				
				if ($row = sqlsrv_fetch_array($RS2)) {
						$COD_INGRESO=$row['MCOD_INGRESO']+1;
					} else {
						$COD_INGRESO=1;
				}

				$S2="INSERT INTO MN_INGRESO (MIN_INGRESO, MAX_INGRESO, IDREG) ";
				$S2=$S2." VALUES (".$MIN_INGRESO.", ".$MAX_INGRESO.", ".$SESIDUSU.")";
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2);

				//REGISTRO DE ALTA
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1137, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($maestra,$SQLOG);																	


				header("Location: mant_nivingreso.php?ACT=".$COD_INGRESO."&MSJE=3");
		}
		 sqlsrv_close( $conn );
		 sqlsrv_close( $maestra );
}
				
				
$ACTUALIZAR=$_POST["ACTUALIZAR"];

if ($ACTUALIZAR<>"") {
		$COD_INGRESO=$_POST["COD_INGRESO"];
		$MIN_INGRESO=$_POST["MIN_INGRESO"];
		$MAX_INGRESO=$_POST["MAX_INGRESO"];
			$S="SELECT * FROM MN_INGRESO WHERE (MIN_INGRESO=".$MIN_INGRESO." AND MAX_INGRESO=".$MAX_INGRESO. "') AND COD_INGRESO<>".$COD_INGRESO;
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S);

			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_nivingreso.php?ACT=".$COD_INGRESO."&MSJE=2");
			} else {
				$S2="UPDATE MN_INGRESO SET MIN_INGRESO=".$MIN_INGRESO.", MAX_INGRESO=".$MAX_INGRESO.", FECHA=convert(datetime,GETDATE(), 121), IDREG=".$SESIDUSU." WHERE COD_INGRESO=".$COD_INGRESO;
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2);

				//REGISTRO DE MODIFICACION
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1137, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);	
						$RSL = sqlsrv_query($maestra,$SQLOG); 																

				header("Location: mant_nivingreso.php?ACT=".$COD_INGRESO."&MSJE=1");
		}
		 sqlsrv_close( $conn );
		 sqlsrv_close( $maestra );
}
				
				
$ELIMINAR=@$_GET["ELM"];

if ($ELIMINAR<>"") {
		$COD_INGRESO=@$_GET["COD_INGRESO"];
		
			$S="DELETE FROM MN_INGRESO WHERE COD_INGRESO=".$COD_INGRESO;
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S); 

				//REGISTRO DE BAJA
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1137, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($maestra,$SQLOG); 																

			header("Location: mant_nivingreso.php?MSJE=4");
		 sqlsrv_close( $conn );
		 sqlsrv_close( $maestra );
}
?>
