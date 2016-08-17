<?php include("session.inc");?>
<?php

$ACTUALIZAR=$_POST["ACTUALIZAR"];

if ($ACTUALIZAR<>"") {
		$NM_DPT_PS=SINCOMILLAS($_POST["NM_DPT_PS"]);
		$ID_DPT_PS=$_POST["ID_DPT_PS"];
		
				$CONSULTA2="UPDATE ID_DPT_PS SET NM_DPT_PS='".$NM_DPT_PS."' WHERE ID_DPT_PS=".$ID_DPT_PS;
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				////oci_execute($RS2);

				//REGISTRO DE MODIFICACION
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."( 3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1123, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);																	

				header("Location: mant_depart.php?ACT=".$ID_DPT_PS."&MSJE=1");

		//sqlsrv_close($conn);
		//sqlsrv_close($maestra);
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
}
				
				
?>
