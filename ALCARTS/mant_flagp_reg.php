<?php include("session.inc");?>

<?php

function Mayus($variable) {
$variable=strtoupper($variable);
return $variable;
}

$INGRESAR=$_POST["INGRESAR"];



if ($INGRESAR<>"") {

		$FLAG_PROCESAMIENTO=$_POST["FLAG_PROCESAMIENTO"];

		$var=$_POST["DES_PROCES"];
		$DES_PROCES=Mayus($var);

				

			$CONSULTA="SELECT FLAG_PROCESAMIENTO FROM CO_FLAG_PROCES WHERE FLAG_PROCESAMIENTO='".$FLAG_PROCESAMIENTO."'";

			$RS = sqlsrv_query($conn, $CONSULTA);

			//oci_execute($RS);

			if ($row = sqlsrv_fetch_array($RS)) {

				header("Location: mant_flagp.php?NEO=1&MSJE=2");

			} else {

				$CONSULTA2="INSERT INTO CO_FLAG_PROCES (FLAG_PROCESAMIENTO,DES_PROCES) ";

				$CONSULTA2=$CONSULTA2." VALUES ('".$FLAG_PROCESAMIENTO."','".$DES_PROCES."')";

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

						$SQLOG="INSERT INTO LG_EVENTO ( COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";

						$SQLOG=$SQLOG."( 1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1179, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";

						$RSL = sqlsrv_query($maestra, $SQLOG);

						//oci_execute($RSL);																	





				header("Location: mant_flagp.php?ACT=".$FLAG_PROCESAMIENTO."&MSJE=3");

		}

		sqlsrv_close($conn);

		sqlsrv_close($maestra);

}

				

				

$ACTUALIZAR=$_POST["ACTUALIZAR"];



if ($ACTUALIZAR<>"") {

		$FLAG_PROCESAMIENTO=$_POST["FLAG_PROCESAMIENTO"];

		$var=$_POST["DES_PROCES"];
		$DES_PROCES=Mayus($var);

		$FLAG_ANTERIOR=$_POST["FLAG_ANTERIOR"];

		

				$C2="UPDATE CO_FLAG_PROCES SET FLAG_PROCESAMIENTO='".$FLAG_PROCESAMIENTO."',DES_PROCES='".$DES_PROCES."' WHERE FLAG_PROCESAMIENTO='".$FLAG_ANTERIOR."'";

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

						$SQLOG="INSERT INTO LG_EVENTO ( COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";

						$SQLOG=$SQLOG."( 3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1179, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";

						$RSL = sqlsrv_query($maestra, $SQLOG);

						//oci_execute($RSL);																	



				header("Location: mant_flagp.php?ACT=".$FLAG_PROCESAMIENTO."&MSJE=1");



		sqlsrv_close($conn);

		sqlsrv_close($maestra);

}

				

				

$ELIMINAR=@$_GET["ELM"];



if ($ELIMINAR<>"") {

		$FLAG_PROCESAMIENTO=@$_GET["FLAG_PROCESAMIENTO"];

		

			$CONSULTA="DELETE FROM CO_FLAG_PROCES WHERE FLAG_PROCESAMIENTO='".$FLAG_PROCESAMIENTO."'";

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

						$SQLOG="INSERT INTO LG_EVENTO ( COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";

						$SQLOG=$SQLOG."( 2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1179, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";

						$RSL = sqlsrv_query($maestra, $SQLOG);

						//oci_execute($RSL);																	



			header("Location: mant_flagp.php?MSJE=4");

		sqlsrv_close($conn);

		sqlsrv_close($maestra);

}

?>

