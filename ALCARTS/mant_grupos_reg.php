<?php include("session.inc");?>

<?php

$INGRESAR=$_POST["INGRESAR"];



if ($INGRESAR<>"") {

		$ID_GRUPO=$_POST["ID_GRUPO"];

		$DESCRIPCION = strtoupper($_POST["DESCRIPCION"]);

		$ULT_COR_GRP=$_POST["ULT_COR_GRP"];
		if(substr($ULT_COR_GRP,0,1)=='0')
		{
			$ULT_COR_GRP=substr($ULT_COR_GRP,1,1);
		}
		if(isset($_POST["IN_EX"]))

		{

			$IN_EX=$_POST["IN_EX"];

		}

		else

		{

			$IN_EX=0;

		}

		

				

			$CONSULTA="SELECT ID_GRUPO FROM CO_GRUPO WHERE ID_GRUPO='".$ID_GRUPO."'";

			$RS = sqlsrv_query($conn, $CONSULTA);

			//oci_execute($RS);

			if ($row = sqlsrv_fetch_array($RS)) {

				header("Location: mant_grupos.php?NEO=1&MSJE=2");

			} else {

				$C2="INSERT INTO CO_GRUPO (ID_GRUPO,CORRELATIVO,ULT_COR_GRP,IN_EX,FILLER,DESCRIPCION) ";

				$C2=$C2." VALUES ('".$ID_GRUPO."','00','0".$ULT_COR_GRP."',".$IN_EX.",'00000','".$DESCRIPCION."')";

				$RES2 = sqlsrv_query($conn, $C2);

				//oci_execute($RES2);

				for($i=1;$i<=$ULT_COR_GRP;$i++)

				{

					$C3="SELECT MAX(ID_DET_GRP) AS MAX FROM DET_CO_GRUPO";

					$RES3 = sqlsrv_query($conn, $C3);

					//oci_execute($RES3);

					if ($row3 = sqlsrv_fetch_array($RES3)) {

							$MAX=$row3['MAX']+1;

						} else {

							$MAX=1;

					}

					$DEPTO=$_POST["dept".$i];

					$FAM=$_POST["FAM".$i];

					$conca=$DEPTO.$FAM;

					$C4="INSERT INTO DET_CO_GRUPO (ID_DET_GRP,ID_GRUPO,CORRELATIVO,SEC_SUBSEC) ";

					$C4=$C4." VALUES ('".$MAX."','".$ID_GRUPO."','0".$i."','".$conca."')";

					$RES4 = sqlsrv_query($conn, $C4);

					//oci_execute($RES4);

				}



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

						$SQLOG=$SQLOG."( 1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1181, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";

						$RSL = sqlsrv_query($maestra, $SQLOG);

						//oci_execute($RSL);																	





				header("Location: mant_grupos.php?ACT=".$ID_GRUPO."&MSJE=3");

		}

		sqlsrv_close($conn);

		sqlsrv_close($maestra);

}

				

				

$ACTUALIZAR=$_POST["ACTUALIZAR"];



if ($ACTUALIZAR<>"") {

		$ID_GRUPO=$_POST["ID_GRUPO"];

		$ID_ANTERIOR=$_POST["ID_ANTERIOR"];

		$DESCRIPCION = strtoupper($_POST["DESCRIPCION"]);

		$ULT_COR_GRP=$_POST["ULT_COR_GRP"];

		if(isset($_POST["IN_EX"]))

		{

			$IN_EX=$_POST["IN_EX"];

		}

		else

		{

			$IN_EX=0;

		}

		

				$C2="UPDATE CO_GRUPO SET ID_GRUPO='".$ID_ANTERIOR."',DESCRIPCION='".$DESCRIPCION."', ULT_COR_GRP='0".$ULT_COR_GRP."', IN_EX=".$IN_EX." WHERE ID_GRUPO='".$ID_ANTERIOR."'";

				$RS2 = sqlsrv_query($conn, $C2);

				//oci_execute($RS2);

				

				$C2="DELETE FROM DET_CO_GRUPO WHERE ID_GRUPO='".$ID_ANTERIOR."'";

				$RS2 = sqlsrv_query($conn, $C2);

				//oci_execute($RS2);

				

				for($i=1;$i<=$ULT_COR_GRP;$i++)

				{

					$C3="SELECT MAX(ID_DET_GRP) AS MAX FROM DET_CO_GRUPO";

					$RES3 = sqlsrv_query($conn, $C3);

					//oci_execute($RES3);

					if ($row3 = sqlsrv_fetch_array($RES3)) {

							$MAX=$row3['MAX']+1;

						} else {

							$MAX=1;

					}

					$DEPTO=$_POST["dept".$i];

					$FAM=$_POST["FAM".$i];

					$conca=$DEPTO.$FAM;

					$C4="INSERT INTO DET_CO_GRUPO (ID_DET_GRP,ID_GRUPO,CORRELATIVO,SEC_SUBSEC) ";

					$C4=$C4." VALUES ('".$MAX."','".$ID_ANTERIOR."','0".$i."','".$conca."')";

					$RES4 = sqlsrv_query($conn, $C4);

					//oci_execute($RES4);

				}

				

				

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

						$SQLOG=$SQLOG."( 3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1181, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";

						$RSL = sqlsrv_query($maestra, $SQLOG);

						//oci_execute($RSL);																	



				header("Location: mant_grupos.php?ACT=".$ID_ANTERIOR."&MSJE=1");



		sqlsrv_close($conn);

		sqlsrv_close($maestra);

}

				

				

$ELIMINAR=@$_GET["ELM"];



if ($ELIMINAR<>"") {

		$ID_GRUPO=@$_GET["ID_GRUPO"];

		

			$CONSULTA="DELETE FROM CO_GRUPO WHERE ID_GRUPO='".$ID_GRUPO."'";

			$RS = sqlsrv_query($conn, $CONSULTA);

			//oci_execute($RS);

			$CONSULTA="DELETE FROM DET_CO_GRUPO WHERE ID_GRUPO='".$ID_GRUPO."'";

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

						$SQLOG=$SQLOG."( 2,convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1181, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";

						$RSL = sqlsrv_query($maestra, $SQLOG);

						//oci_execute($RSL);																	



			header("Location: mant_grupos.php?MSJE=4");

		sqlsrv_close($conn);

		sqlsrv_close($maestra);

}

?>

