<?php include("session.inc");?>

<?php

$INGRESAR=$_POST["INGRESAR"];

if ($INGRESAR<>"") {

		$TP_TARJ=$_POST["TP_TARJ"];

		$DESC_TP_TARJ = strtoupper($_POST["DESC_TP_TARJ"]);

				

			$CONSULTA="SELECT TP_TARJ FROM CO_TIPO_TARJETA WHERE TP_TARJ=".$TP_TARJ;

			$RS = sqlsrv_query($conn, $CONSULTA);

			//oci_execute($RS);

			if ($row = sqlsrv_fetch_array($RS)) {

				header("Location: mant_tarj.php?NEO=1&MSJE=2");

			} else {

				$CONSULTA2="INSERT INTO CO_TIPO_TARJETA (TP_TARJ,DESC_TP_TARJ) ";

				$CONSULTA2=$CONSULTA2." VALUES ('".$TP_TARJ."','".$DESC_TP_TARJ."')";

				$RS2 = sqlsrv_query($conn, $CONSULTA2);

				//oci_execute($RS2);



				//REGISTRO DE ALTA

						$CONSULTA3="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";

						$RS2 = sqlsrv_query($maestra, $CONSULTA3);

						//oci_execute($RS2);

						if ($row = sqlsrv_fetch_array($RS2)) {

								$COD_EVENTO=$row['MCOD_EVENTO']+1;

							} else {

								$COD_EVENTO=1;

						}

						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";

						$SQLOG=$SQLOG."( 1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1178, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";

						$RSL = sqlsrv_query($maestra, $SQLOG);

						//oci_execute($RSL);																	





				header("Location: mant_tarj.php?ACT=".$TP_TARJ."&MSJE=3");

		}

		sqlsrv_close($conn);

		sqlsrv_close($maestra);

}

				

				

$ACTUALIZAR=$_POST["ACTUALIZAR"];



if ($ACTUALIZAR<>"") {

		$TP_TARJ=$_POST["TP_TARJ"];

		$DESC_TP_TARJ = strtoupper($_POST["DESC_TP_TARJ"]);

		$TP_TARJ_ANTERIOR=$_POST["TP_TARJ_ANTERIOR"];

		

				$C2="UPDATE CO_TIPO_TARJETA SET TP_TARJ='".$TP_TARJ."',DESC_TP_TARJ='".$DESC_TP_TARJ."' WHERE TP_TARJ='".$TP_TARJ_ANTERIOR."'";

				$RS2 = sqlsrv_query($conn, $C2);

				//oci_execute($RS2);



				//REGISTRO DE MODIFICACION

						$CONSULTA2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";

						$RS2 = sqlsrv_query($maestra, $CONSULTA2);

						//oci_execute($RS2);

						if ($row = sqlsrv_fetch_array($RS2)) {

								$COD_EVENTO=$row['MCOD_EVENTO']+1;

							} else {

								$COD_EVENTO=1;

						}

						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";

						$SQLOG=$SQLOG."( 3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1178, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";

						$RSL = sqlsrv_query($maestra, $SQLOG);

						//oci_execute($RSL);																	



				header("Location: mant_tarj.php?ACT=".$TP_TARJ."&MSJE=1");



		sqlsrv_close($conn);

		sqlsrv_close($maestra);

}

				

				

$ELIMINAR=@$_GET["ELM"];



if ($ELIMINAR<>"") {

		$TP_TARJ=@$_GET["TP_TARJ"];

		

			$CONSULTA="DELETE FROM CO_TIPO_TARJETA WHERE TP_TARJ=".$TP_TARJ;

			$RS = sqlsrv_query($conn, $CONSULTA);

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

						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";

						$SQLOG=$SQLOG."( 2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1178, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";

						$RSL = sqlsrv_query($maestra, $SQLOG);

						//oci_execute($RSL);																	



			header("Location: mant_tarj.php?MSJE=4");

		sqlsrv_close($conn);

		sqlsrv_close($maestra);

}

?>

