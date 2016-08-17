<?php include("session.inc");?>
<?php

$INGRESAR=$_POST["INGRESAR"];

if ($INGRESAR<>"") {
		$DES_DATACRM=SINCOMILLAS($_POST["DES_DATACRM"]);
		$TIPO_DATACRM=$_POST["TIPO_DATACRM"];
		$AMBITO=$_POST["AMBITO"];
		$IND_ACTIVO=$_POST["IND_ACTIVO"];
		
			$S="SELECT * FROM MN_DATACRM WHERE OR UPPER(DES_DATACRM)='". strtoupper($DES_DATACRM). "' ";
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S);
			

			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_datacliente.php?NEO=1&MSJE=2");
			} else {

				$S2="SELECT IDENT_CURRENT ('MN_DATACRM') AS MCOD_DATACRM";
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2); 

				if ($row = sqlsrv_fetch_array($RS2)) {
						$COD_DATACRM=$row['MCOD_DATACRM']+1;
					} else {
						$COD_DATACRM=1;
				}

				$S2="INSERT INTO MN_DATACRM (DES_DATACRM, TIPO_DATACRM, AMBITO, IND_ACTIVO, IDREG) ";
				$S2=$S2." VALUES ('".$DES_DATACRM."', ".$TIPO_DATACRM.", ".$AMBITO.", ".$IND_ACTIVO.", ".$SESIDUSU.")";
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2); 

				//REGISTRO DE ALTA
						//$S2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";
						//$RS2 = sqlsrv_query($conn, $S2);
						////oci_execute($RS2);
						//if ($row = sqlsrv_fetch_array($RS2)) {
						//		$COD_EVENTO=$row['MCOD_EVENTO']+1;
						//	} else {
						//		$COD_EVENTO=1;
						//}

						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1132, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);	
						$RSL = sqlsrv_query($maestra,$SQLOG);																


				header("Location: mant_datacliente.php?ACT=".$COD_DATACRM."&MSJE=3");
		}
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
		//sqlsrv_close($conn);
		//sqlsrv_close($maestra);
}
				
				
$ACTUALIZAR=$_POST["ACTUALIZAR"];

if ($ACTUALIZAR<>"") {
		$COD_DATACRM=$_POST["COD_DATACRM"];
		$DES_DATACRM=COMILLAS($_POST["DES_DATACRM"]);
		$TIPO_DATACRM=$_POST["TIPO_DATACRM"];
		$AMBITO=$_POST["AMBITO"];
		$IND_ACTIVO=$_POST["IND_ACTIVO"];
		
			$S="SELECT * FROM MN_DATACRM WHERE UPPER(DES_DATACRM)='". strtoupper($DES_DATACRM). "') AND COD_DATACRM<>".$COD_DATACRM;
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S);

			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_datacliente.php?ACT=".$COD_DATACRM."&MSJE=2");
			} else {
				$S2="UPDATE MN_DATACRM SET DES_DATACRM='".$DES_DATACRM."', TIPO_DATACRM=".$TIPO_DATACRM.", AMBITO=".$AMBITO.", IND_ACTIVO=".$IND_ACTIVO.", FECHA=convert(datetime,GETDATE(), 121), IDREG=".$SESIDUSU." WHERE COD_DATACRM=".$COD_DATACRM;
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2);


				//REGISTRO DE MODIFICACION
						//$S2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";
						//$RS2 = sqlsrv_query($conn, $S2);
						////oci_execute($RS2);
						//if ($row = sqlsrv_fetch_array($RS2)) {
						//		$COD_EVENTO=$row['MCOD_EVENTO']+1;
						//	} else {
						//		$COD_EVENTO=1;
						//}
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1132, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($maestra,$SQLOG); 																

				header("Location: mant_datacliente.php?ACT=".$COD_DATACRM."&MSJE=1");
		}
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
		//sqlsrv_close($conn);
		//sqlsrv_close($maestra);
}
				
				
$ELIMINAR=@$_GET["ELM"];

if ($ELIMINAR<>"") {
		$COD_DATACRM=@$_GET["COD_DATACRM"];
		
			$S="DELETE FROM MN_DATACRM WHERE COD_DATACRM=".$COD_DATACRM;
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S);

				//REGISTRO DE BAJA
						//$S2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";
						//$RS2 = sqlsrv_query($conn, $S2);
						////oci_execute($RS2);
						//if ($row = sqlsrv_fetch_array($RS2)) {
						//		$COD_EVENTO=$row['MCOD_EVENTO']+1;
						//	} else {
						//		$COD_EVENTO=1;
						//}
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1132, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($maestra,$SQLOG);																	

			header("Location: mant_datacliente.php?MSJE=4");
		
		//sqlsrv_close($conn);
		//sqlsrv_close($maestra);
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
}











$REGOPCION=$_POST["REGOPCION"];

if ($REGOPCION<>"") {
		$COD_DATACRM=$_POST["COD_DATACRM"];
		$DES_DATACRMOPC=COMILLAS($_POST["DES_DATACRMOPC"]);
		
			$S="SELECT * FROM MN_DATACRMOPC WHERE UPPER(DES_DATACRMOPC)='". strtoupper($DES_DATACRMOPC). "') AND COD_DATACRM<>".$COD_DATACRM;
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S); 

			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_datacliente.php?ACT=".$COD_DATACRM."&MSJE=2");
			} else {
				
				//$S2="SELECT MAX(COD_DATACRMOPC) AS MCOD_DATACRMOPC FROM MN_DATACRMOPC";
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				//$RS2 = sqlsrv_query($conn,$S2);

				//if ($row = sqlsrv_fetch_array($RS2)) {
				//		$COD_DATACRMOPC=$row['MCOD_DATACRMOPC']+1;
				//	} else {
				//		$COD_DATACRMOPC=1;
				//}

				$S2="INSERT INTO MN_DATACRMOPC (COD_DATACRM, DES_DATACRMOPC, IDREG) ";
				$S2=$S2." VALUES (".$COD_DATACRM.", '".$DES_DATACRMOPC."',".$SESIDUSU.")";
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2);


				//REGISTRO DE ALTA
						//$S2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";
						
						//$RS2 = sqlsrv_query($conn, $S2);
						////oci_execute($RS2);
						
						//if ($row = sqlsrv_fetch_array($RS2)) {
						//		$COD_EVENTO=$row['MCOD_EVENTO']+1;
						//	} else {
						//		$COD_EVENTO=1;
						//}
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1132, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($maestra,$SQLOG);															

				header("Location: mant_datacliente.php?ACT=".$COD_DATACRM."&MSJE=3");
		}

		//sqlsrv_close($conn);
		//sqlsrv_close($maestra);
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
}





$ACTOPCION=$_POST["ACTOPCION"];

if ($ACTOPCION<>"") {
		$COD_DATACRMOPC=$_POST["COD_DATACRMOPC"];
		$COD_DATACRM=$_POST["COD_DATACRM"];
		$DES_DATACRMOPC=COMILLAS($_POST["DES_DATACRMOPC"]);
		
			$S="SELECT * FROM MN_DATACRMOPC WHERE UPPER(DES_DATACRMOPC)='". strtoupper($DES_DATACRMOPC). "') AND COD_DATACRM=".$COD_DATACRM." AND COD_DATACRMOPC<>".$COD_DATACRMOPC;
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S);

			
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_datacliente.php?ACT=".$COD_DATACRM."&MSJE=2");
			} else {
				$S2="UPDATE MN_DATACRMOPC SET DES_DATACRMOPC='".$DES_DATACRMOPC."', FECHA=convert(datetime,GETDATE(), 121), IDREG=".$SESIDUSU." WHERE COD_DATACRMOPC=".$COD_DATACRMOPC;
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2);

				//REGISTRO DE MODIFICACION
						//$S2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";
						//$RS2 = sqlsrv_query($conn, $S2);
						////oci_execute($RS2);
						//if ($row = sqlsrv_fetch_array($RS2)) {
						//		$COD_EVENTO=$row['MCOD_EVENTO']+1;
						//	} else {
						//		$COD_EVENTO=1;
						//}
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1132, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($maestra,$SQLOG);																

				header("Location: mant_datacliente.php?ACT=".$COD_DATACRM."&MSJE=3");
		}

		//sqlsrv_close($conn);
		//sqlsrv_close($maestra);
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
}



$ELMOPCION=@$_GET["ELMOPCION"];

if ($ELMOPCION<>"") {
		$COD_DATACRMOPC=@$_GET["COD_DATACRMOPC"];
		$COD_DATACRM=@$_GET["COD_DATACRM"];
		
			$S="DELETE FROM MN_DATACRMOPC WHERE COD_DATACRMOPC=".$COD_DATACRMOPC;
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S); 

				//REGISTRO DE BAJA
						//$S2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";
						//$RS2 = sqlsrv_query($conn, $S2);
						////oci_execute($RS2);
						//if ($row = sqlsrv_fetch_array($RS2)) {
						//		$COD_EVENTO=$row['MCOD_EVENTO']+1;
						//	} else {
						//		$COD_EVENTO=1;
						//}
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1132, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($maestra,$SQLOG); 																

			header("Location: mant_datacliente.php?ACT=".$COD_DATACRM."&MSJE=4");

		//sqlsrv_close($conn);
		//sqlsrv_close($maestra);
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );

}





?>
