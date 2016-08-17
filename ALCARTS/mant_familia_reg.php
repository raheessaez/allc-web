<?php include("session.inc");?>
<?php

$ACTUALIZAR=$_POST["ACTUALIZAR"];

if ($ACTUALIZAR<>"") {
		$NM_MRHRC_GP=SINCOMILLAS($_POST["NM_MRHRC_GP"]);
		$ID_MRHRC_GP=$_POST["ID_MRHRC_GP"];
		
				$CONSULTA2="UPDATE CO_MRHRC_GP SET NM_MRHRC_GP='".$NM_MRHRC_GP."' WHERE ID_MRHRC_GP=".$ID_MRHRC_GP;
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				////oci_execute($RS2);

				//REGISTRO DE MODIFICACION
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."( 3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1158, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($maestra, $SQLOG);
						////oci_execute($RSL);																	

				header("Location: mant_familia.php?ACT=".$ID_MRHRC_GP."&MSJE=1");

		sqlsrv_close($conn);
		sqlsrv_close($maestra);
}
				
				
?>
