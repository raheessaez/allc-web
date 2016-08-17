<?php include("session.inc");?>
<?php

$ACTUALIZAR=$_POST["ACTUALIZAR"];

if ($ACTUALIZAR<>"") {
		$ID_PROCESO=$_POST["ID_PROCESO"];
		$ABR_PROCESO=COMILLAS($_POST["ABR_PROCESO"]);
		
			$CONSULTA="SELECT ID_PROCESO FROM FP_PROCESO WHERE UPPER(ABR_PROCESO)='". strtoupper($ABR_PROCESO). "'  AND ID_PROCESO<>".$ID_PROCESO;
			$RS = sqlsrv_query($conn, $CONSULTA);
			//oci_execute($RS);
			if ($row = sqlsrv_fetch_array($RS)) {
				
				header("Location: mant_procesos.php?ACT=".$ID_PROCESO."&MSJE=2");

			} else {
				$CONSULTA2="UPDATE FP_PROCESO SET ABR_PROCESO='".$ABR_PROCESO."', FEC_ACTUALIZACION=convert(datetime,GETDATE(), 121), COD_USUARIO=".$SESIDUSU." WHERE ID_PROCESO=".$ID_PROCESO;
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				//oci_execute($RS2);

				//REGISTRO DE MODIFICACION
						$CONSULTA2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";
						$RS2 = sqlsrv_query($conn, $CONSULTA2);
						//oci_execute($RS2);
						if ($row = sqlsrv_fetch_array($RS2)) {
								$COD_EVENTO=$row['MCOD_EVENTO']+1;
							} else {
								$COD_EVENTO=1;
						}
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."( 3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1163, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($maestra, $SQLOG);
						//oci_execute($RSL);																	

				header("Location: mant_procesos.php?ACT=".$ID_PROCESO."&MSJE=1");
		}
		sqlsrv_close($conn);
}
				
				
?>
