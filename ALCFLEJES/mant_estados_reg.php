<?php include("session.inc");?>
<?php

$INGRESAR=$_POST["INGRESAR"];

if ($INGRESAR<>"") {
		$NOM_ESTPRC=SINCOMILLAS($_POST["NOM_ESTPRC"]);
		$COL_ESTPRC=COMILLAS($_POST["COL_ESTPRC"]);
		$CSF_ESTADO=COMILLAS($_POST["CSF_ESTADO"]);
		
			$S="SELECT * FROM EST_PRC WHERE UPPER(NOM_ESTPRC)='". strtoupper($NOM_ESTPRC). "' ";
			$RS = sqlsrv_query($conn, $S);
			//oci_execute($RS);
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_estados.php?NEO=1&MSJE=2");
			} else {
				$S2="SELECT IDENT_CURRENT ('EST_PRC') AS MID_ESTPRC";
				$RS2 = sqlsrv_query($conn, $S2);
				//oci_execute($RS2);
				if ($row = sqlsrv_fetch_array($RS2)) {
						$ID_ESTPRC=$row['MID_ESTPRC']+1;
					} else {
						$ID_ESTPRC=1;
				}

				$S2="INSERT INTO EST_PRC (NOM_ESTPRC, COL_ESTPRC, CSF_ESTADO) ";
				$S2=$S2." VALUES ('".$NOM_ESTPRC."',  '".$COL_ESTPRC."','".$CSF_ESTADO."')";
				$RS2 = sqlsrv_query($conn, $S2);
				//oci_execute($RS2);

				//REGISTRO DE ALTA
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."( 1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1172, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($maestra, $SQLOG);
						//oci_execute($RSL);																	


				header("Location: mant_estados.php?ACT=".$ID_ESTPRC."&MSJE=3");
		}
		sqlsrv_close($conn);
		sqlsrv_close($maestra);
}
				
				
$ACTUALIZAR=$_POST["ACTUALIZAR"];

if ($ACTUALIZAR<>"") {
		$ID_ESTPRC=$_POST["ID_ESTPRC"];
		$NOM_ESTPRC=COMILLAS($_POST["NOM_ESTPRC"]);
		$COL_ESTPRC=COMILLAS($_POST["COL_ESTPRC"]);
		$CSF_ESTADO=COMILLAS($_POST["CSF_ESTADO"]);
		
			$S="SELECT * FROM EST_PRC WHERE UPPER(NOM_ESTPRC)='". strtoupper($NOM_ESTPRC). "') AND ID_ESTPRC<>".$ID_ESTPRC;
			$RS = sqlsrv_query($conn, $S);
			//oci_execute($RS);
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_estados.php?ACT=".$ID_ESTPRC."&MSJE=2");
			} else {
				$S2="UPDATE EST_PRC SET NOM_ESTPRC='".$NOM_ESTPRC."', COL_ESTPRC='".$COL_ESTPRC."', CSF_ESTADO='".$CSF_ESTADO."' WHERE ID_ESTPRC=".$ID_ESTPRC;
				$RS2 = sqlsrv_query($conn, $S2);
				//oci_execute($RS2);

				//REGISTRO DE MODIFICACION
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."( 2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1172, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($maestra, $SQLOG);
						//oci_execute($RSL);																	

				header("Location: mant_estados.php?ACT=".$ID_ESTPRC."&MSJE=1");
		}
		sqlsrv_close($conn);
		sqlsrv_close($maestra);
}
				
				
?>
