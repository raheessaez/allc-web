<?php include("session.inc");?>
<?php

$INGRESAR=$_POST["INGRESAR"];

if ($INGRESAR<>"") {
		$IDSISTEMA=$_POST["IDSISTEMA"];
		$NOMBRE=COMILLAS($_POST["NOMBRE"]);
		$ENLACE=COMILLAS($_POST["ENLACE"]);
		$TIPO=$_POST["TIPO"];
		
			$CONSULTA="SELECT ENLACE FROM US_ACCESO WHERE (UPPER(ENLACE)='". strtoupper($ENLACE). "' OR UPPER(NOMBRE)='". strtoupper($NOMBRE). "') AND IDSISTEMA=".$IDSISTEMA;

			//$RS = sqlsrv_query($conn, $CONSULTA);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$CONSULTA); 

			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_acceso.php?NEO=1&MSJE=2");
			} else {
				
				//$CONSULTA2="SELECT MAX(IDACC) AS MIDACC FROM US_ACCESO";
				//$RS2 = sqlsrv_query($conn, $CONSULTA2);
				////oci_execute($RS2);
				//if ($row = sqlsrv_fetch_array($RS2)) {
				//		$IDACC=$row['MIDACC']+1;
				//	} else {
				//		$IDACC=1;
				//}
				// IDACC Auto Increment SQL SERVER
				//$CONSULTA2="INSERT INTO US_ACCESO (IDACC, NOMBRE, ENLACE, TIPO, IDREG, IDSISTEMA) ";
				//$CONSULTA2=$CONSULTA2." VALUES (".$IDACC.", '".$NOMBRE."', '".$ENLACE."', ".$TIPO.", ".$SESIDUSU.", ".$IDSISTEMA.")";
				$CONSULTA2="INSERT INTO US_ACCESO (NOMBRE, ENLACE, TIPO, IDREG, IDSISTEMA) ";
				$CONSULTA2=$CONSULTA2." VALUES ('".$NOMBRE."', '".$ENLACE."', ".$TIPO.", ".$SESIDUSU.", ".$IDSISTEMA.")";
				
				//$RS2 = sqlsrv_query($conn, $CONSULTA2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$CONSULTA2);

				//REGISTRO DE ALTA
						//$CONSULTA2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";
						//$RS2 = sqlsrv_query($conn, $CONSULTA2);
						////oci_execute($RS2);
						//if ($row = sqlsrv_fetch_array($RS2)) {
						//		$COD_EVENTO=$row['MCOD_EVENTO']+1;
						//	} else {
						//		$COD_EVENTO=1;
						//}
						// COD_EVENTO AUTO INCREMENT SQL SERVER
						//$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						//$SQLOG=$SQLOG."( 1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1101, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1101, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						//$RSL = sqlsrv_query($conn, $SQLOG);
						////oci_execute($RSL);																	
						$RSL = sqlsrv_query($conn,$SQLOG); 

				header("Location: mant_acceso.php?ACT=".$IDACC."&MSJE=3");
		}

		//sqlsrv_close($conn);
		sqlsrv_close( $conn );
}
				
				
$ACTUALIZAR=$_POST["ACTUALIZAR"];

if ($ACTUALIZAR<>"") {
		$IDACC=$_POST["IDACC"];
		$NOMBRE=COMILLAS($_POST["NOMBRE"]);
		$ENLACE=COMILLAS($_POST["ENLACE"]);
		$TIPO=$_POST["TIPO"];
		
			$CONSULTA="SELECT ENLACE FROM US_ACCESO WHERE ((UPPER(ENLACE)='". strtoupper($ENLACE). "' OR UPPER(NOMBRE)='". strtoupper($NOMBRE). "') AND IDSISTEMA=".$IDSISTEMA.") AND IDACC<>".$IDACC;

			//$RS = sqlsrv_query($conn, $CONSULTA);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$CONSULTA); 

			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_acceso.php?ACT=".$IDACC."&MSJE=2");
			} else {
				
				$CONSULTA2="UPDATE US_ACCESO SET NOMBRE='".$NOMBRE."', ENLACE='".$ENLACE."', TIPO=".$TIPO." , FECHA=convert(datetime,GETDATE(), 121), IDREG=".$SESIDUSU." WHERE IDACC=".$IDACC;
				
				//$RS2 = sqlsrv_query($conn, $CONSULTA2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$CONSULTA2);

				//REGISTRO DE MODIFICACION
						//$CONSULTA2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";
						//$RS2 = sqlsrv_query($conn, $CONSULTA2);
						////oci_execute($RS2);
						//if ($row = sqlsrv_fetch_array($RS2)) {
						//		$COD_EVENTO=$row['MCOD_EVENTO']+1;
						//	} else {
						//		$COD_EVENTO=1;
						//}
						// COD_EVENTO SQL SERVER AUTO INCREMENT
						//$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						//$SQLOG=$SQLOG."( 3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1101, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1101, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						//$RSL = sqlsrv_query($conn, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($conn,$SQLOG);																

				header("Location: mant_acceso.php?ACT=".$IDACC."&MSJE=1");
		}

		sqlsrv_close( $conn );
		//sqlsrv_close($conn);
}
				
				
$ELIMINAR=@$_GET["ELM"];

if ($ELIMINAR<>"") {

		$IDACC=@$_GET["IDACC"];
		
			$CONSULTA="DELETE FROM US_ACCESO WHERE IDACC=".$IDACC;

			//$RS = sqlsrv_query($conn, $CONSULTA);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$CONSULTA);

				//REGISTRO DE BAJA
						//$CONSULTA2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";
						//$RS2 = sqlsrv_query($conn, $CONSULTA2);
						////oci_execute($RS2);
						//if ($row = sqlsrv_fetch_array($RS2)) {
						//		$COD_EVENTO=$row['MCOD_EVENTO']+1;
						//	} else {
						//		$COD_EVENTO=1;
						//}
						// COD_EVENTO AUTO INCREMENT SQL SERVER
						//$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC) VALUES ";
						//$SQLOG=$SQLOG."( 2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1101)";
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1101,".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						//$RSL = sqlsrv_query($conn, $SQLOG);
						////oci_execute($RSL);

						$RSL = sqlsrv_query($conn,$SQLOG); 																	

			header("Location: mant_acceso.php?MSJE=4");

		//sqlsrv_close($conn);
		sqlsrv_close( $conn );
}
?>
