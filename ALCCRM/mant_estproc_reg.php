<?php include("session.inc");?>
<?php

$INGRESAR=$_POST["INGRESAR"];

if ($INGRESAR<>"") {
		$VAL_ESTADO=$_POST["VAL_ESTADO"];
		$DES_ESTADO=COMILLAS($_POST["DES_ESTADO"]);
		$ABR_ESTADO=COMILLAS($_POST["ABR_ESTADO"]);
		$COL_ESTADO=COMILLAS($_POST["COL_ESTADO"]);
		$CSF_ESTADO=COMILLAS($_POST["CSF_ESTADO"]);
		
			$S="SELECT VAL_ESTADO FROM MN_ESTADO WHERE VAL_ESTADO='". $VAL_ESTADO. "' OR UPPER(ABR_ESTADO)='". strtoupper($ABR_ESTADO). "' ";
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S);

			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_estproc.php?NEO=1&MSJE=2");
			} else {
				
				$S2="SELECT IDENT_CURRENT ('MN_ESTADO') AS MCOD_ESTADO";
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2); 
				
				if ($row = sqlsrv_fetch_array($RS2)) {
						$COD_ESTADO=$row['MCOD_ESTADO']+1;
					} else {
						$COD_ESTADO=1;
				}

				$S2="INSERT INTO MN_ESTADO (VAL_ESTADO, DES_ESTADO, ABR_ESTADO, COL_ESTADO, CSF_ESTADO, IDREG) ";
				$S2=$S2." VALUES (".$VAL_ESTADO.", '".$DES_ESTADO."', '".$ABR_ESTADO."', '".$COL_ESTADO."','".$CSF_ESTADO."', ".$SESIDUSU.")";
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);

				$RS2 = sqlsrv_query($conn,$S2); 
				
//				echo $S2;
//				die();
				

				//REGISTRO DE ALTA
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."( 1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1133, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($maestra,$SQLOG);																	


				header("Location: mant_estproc.php?ACT=".$COD_ESTADO."&MSJE=3");
		}

		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
		//sqlsrv_close($conn);
		//sqlsrv_close($maestra);
}
				
				
$ACTUALIZAR=$_POST["ACTUALIZAR"];

if ($ACTUALIZAR<>"") {
		$COD_ESTADO=$_POST["COD_ESTADO"];
		$VAL_ESTADO=$_POST["VAL_ESTADO"];
		$DES_ESTADO=COMILLAS($_POST["DES_ESTADO"]);
		$ABR_ESTADO=COMILLAS($_POST["ABR_ESTADO"]);
		$COL_ESTADO=COMILLAS($_POST["COL_ESTADO"]);
		$CSF_ESTADO=COMILLAS($_POST["CSF_ESTADO"]);
		
			$S="SELECT VAL_ESTADO FROM MN_ESTADO WHERE (VAL_ESTADO='". $VAL_ESTADO. "' OR UPPER(ABR_ESTADO)='".strtoupper($ABR_ESTADO)."') AND COD_ESTADO<>".$COD_ESTADO;
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S);
			
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_estproc.php?ACT=".$COD_ESTADO."&MSJE=2");
			} else {
				$S2="UPDATE MN_ESTADO SET VAL_ESTADO=".$VAL_ESTADO." , DES_ESTADO='".$DES_ESTADO."', ABR_ESTADO='".$ABR_ESTADO."', COL_ESTADO='".$COL_ESTADO."', CSF_ESTADO='".$CSF_ESTADO."', FECHA=convert(datetime,GETDATE(), 121), IDREG=".$SESIDUSU." WHERE COD_ESTADO=".$COD_ESTADO;
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2);
				//REGISTRO DE MODIFICACION
						
						$SQLOG="INSERT INTO LG_EVENTO ( COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1133, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);

						$RSL = sqlsrv_query($maestra,$SQLOG);

				header("Location: mant_estproc.php?ACT=".$COD_ESTADO."&MSJE=1");
		}
		//sqlsrv_close($conn);
		//sqlsrv_close($maestra);
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
}
				
				
$ELIMINAR=@$_GET["ELM"];

if ($ELIMINAR<>"") {
		$COD_ESTADO=@$_GET["COD_ESTADO"];
		
			$S="DELETE FROM MN_ESTADO WHERE COD_ESTADO=".$COD_ESTADO;
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S);


				//REGISTRO DE BAJA
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1133, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						//$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($maestra,$SQLOG); 																

			header("Location: mant_estproc.php?MSJE=4");
		
		//sqlsrv_close($conn);
		//sqlsrv_close($maestra);
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
}
?>
