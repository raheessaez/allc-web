<?php include("session.inc");?>
<?php

$INGRESAR=$_POST["INGRESAR"];

if ($INGRESAR<>"") {
		$NOMBRE=COMILLAS($_POST["NOMBRE"]);
		$CARPETA=COMILLAS($_POST["CARPETA"]);
		$BDIP=COMILLAS($_POST["BDIP"]);
		$BDUS=COMILLAS($_POST["BDUS"]);
		$BDPS=COMILLAS($_POST["BDPS"]);
		
			$CONSULTA="SELECT ENLACE FROM US_SISTEMA WHERE UPPER(CARPETA)='". strtoupper($CARPETA). "' OR UPPER(NOMBRE)='". strtoupper($NOMBRE). "' ";
			
			//$RS = sqlsrv_query($conn, $CONSULTA);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$CONSULTA);


			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_sistemas.php?NEO=1&MSJE=2");
			} else {
				//$CONSULTA2="SELECT MAX(IDSISTEMA) AS MIDSISTEMA FROM US_SISTEMA";
				//$RS2 = sqlsrv_query($conn, $CONSULTA2);
				////oci_execute($RS2);
				//if ($row = sqlsrv_fetch_array($RS2)) {
				//		$IDSISTEMA=$row['MIDSISTEMA']+1;
				//	} else {
				//		$IDSISTEMA=1;
				//}
				// IDSISTEMA AUTO INCREMENT SQL SERVER
				//$CONSULTA2="INSERT INTO US_SISTEMA (IDSISTEMA, NOMBRE, CARPETA, BDIP, BDUS, BDPS, IDREG) ";
				//$CONSULTA2=$CONSULTA2." VALUES (".$IDSISTEMA.", '".$NOMBRE."', '".$CARPETA."',  '".$BDIP."',  '".$BDUS."',  '".$BDPS."', ".$SESIDUSU.")";
				$CONSULTA2="INSERT INTO US_SISTEMA (NOMBRE, CARPETA, BDIP, BDUS, BDPS, IDREG) ";
				$CONSULTA2=$CONSULTA2." VALUES ('".$NOMBRE."', '".$CARPETA."',  '".$BDIP."',  '".$BDUS."',  '".$BDPS."', ".$SESIDUSU.")";
				
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

						//COD_EVENTO AUTO INCREMENT SQL SERVER
						//$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						//$SQLOG=$SQLOG."( 1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1109, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1109, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";

						//$RSL = sqlsrv_query($conn, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($conn,$SQLOG); 																	


				header("Location: mant_sistemas.php?ACT=".$IDSISTEMA."&MSJE=3");
		}

		//sqlsrv_close($conn);
		sqlsrv_close( $conn );
}
				
				
$ACTUALIZAR=$_POST["ACTUALIZAR"];

if ($ACTUALIZAR<>"") {
		$IDSISTEMA=$_POST["IDSISTEMA"];
		$NOMBRE=COMILLAS($_POST["NOMBRE"]);
		$CARPETA=COMILLAS($_POST["CARPETA"]);
		$BDIP=COMILLAS($_POST["BDIP"]);
		$BDUS=COMILLAS($_POST["BDUS"]);
		$BDPS=COMILLAS($_POST["BDPS"]);
		
			$CONSULTA="SELECT ENLACE FROM US_SISTEMA WHERE (UPPER(NOMBRE)='". strtoupper($NOMBRE). "' OR UPPER(CARPETA)='". strtoupper($CARPETA). "') AND IDSISTEMA<>".$IDSISTEMA;
			
			//$RS = sqlsrv_query($conn, $CONSULTA);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$CONSULTA);

			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_sistemas.php?ACT=".$IDSISTEMA."&MSJE=2");
			} else {

				
				$CONSULTA2="UPDATE US_SISTEMA SET NOMBRE='".$NOMBRE."', CARPETA='".$CARPETA."', BDIP='".$BDIP."', BDUS='".$BDUS."', BDPS='".$BDPS."',  FECHA=convert(datetime,GETDATE(), 121), IDREG=".$SESIDUSU." WHERE IDSISTEMA=".$IDSISTEMA;
				
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
						//$SQLOG=$SQLOG."( 3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1109, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1109, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						//$RSL = sqlsrv_query($conn, $SQLOG);
						////oci_execute($RSL);

						$RSL = sqlsrv_query($conn,$SQLOG);																	

				header("Location: mant_sistemas.php?ACT=".$IDSISTEMA."&MSJE=1");
		}
		sqlsrv_close($conn);
}
				
				
$ELIMINAR=@$_GET["ELM"];

if ($ELIMINAR<>"") {
		$IDSISTEMA=@$_GET["IDS"];
			
			$CONSULTA="DELETE FROM US_SISTEMA WHERE IDSISTEMA=".$IDSISTEMA;
			
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
						//$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						//$SQLOG=$SQLOG."( 2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1109, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1109, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						//$RSL = sqlsrv_query($conn, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($conn,$SQLOG);																

			header("Location: mant_sistemas.php?MSJE=4");

		//sqlsrv_close($conn);
		sqlsrv_close( $conn );
}
?>
