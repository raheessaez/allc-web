<?php include("session.inc");?>
<?php

				
$CAMBIAR=$_POST["CAMBIAR"];

if ($CAMBIAR<>"") {
		$MOD_PAIS=$_POST["MOD_PAIS"];
		
				$S2="UPDATE PM_PAIS SET PACTIV=0";
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2);

				$S2="UPDATE PM_PAIS SET PACTIV=1 WHERE COD_PAIS=".$MOD_PAIS;

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
						$SQLOG=$SQLOG."(3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1108, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						//$RSL = sqlsrv_query($conn, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($conn,$SQLOG);						

				header("Location: ../index.php?msj=4");

		//sqlsrv_close($conn);
		sqlsrv_close( $conn );
}
?>
