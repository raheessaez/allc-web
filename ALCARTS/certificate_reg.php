<?php include("session.inc");?>

<?php




if(!empty($_POST["ID"])){
	$ID_STR=$_POST["ID"];
}

if(!empty($_POST["STR_CD"])){
	
	$STR_CD=$_POST["STR_CD"];
}
$TODAY = date("Y-m-d H:i:s");

          $CONSULTA3="SELECT MAX(ID) AS MAX_ID FROM CERT_STR";

						$RS3 = sqlsrv_query($conn, $CONSULTA3);

						//oci_execute($RS2);

						if ($row = sqlsrv_fetch_array($RS3)) {

								$IDM=$row['MAX_ID']+1;

							} else {

								$IDM=1;

						}
		

			$CONSULTA="INSERT INTO CERT_STR (ID,ID_STR_REC_TOT,ID_USU,ESTADO,ID_TND,FCH_CERT) VALUES(".$IDM.",".$ID_STR.",".$SESIDUSU.",1,".$STR_CD.",'".$TODAY."')";
			
			echo $CONSULTA;

			$RS = sqlsrv_query($conn, $CONSULTA);

			//oci_execute($RS);

	

			//oci_execute($RS);



				//REGISTRO DE BAJA

						$CONSULTA2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";

						$RS2 = sqlsrv_query($maestra, $CONSULTA2);

						//oci_execute($RS2);

						if ($row = sqlsrv_fetch_array($RS2)) {

								$COD_EVENTO=$row['MCOD_EVENTO']+1;

							} else {

								$COD_EVENTO=1;

						}

						$SQLOG="INSERT INTO LG_EVENTO ( COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";

						$SQLOG=$SQLOG."( 2,convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1181, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";

						$RSL = sqlsrv_query($maestra, $SQLOG);

						//oci_execute($RSL);																	



			header("Location: certificate.php?MSJE=1");

		sqlsrv_close($conn);

		sqlsrv_close($maestra);



?>

