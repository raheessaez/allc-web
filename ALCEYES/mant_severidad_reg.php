<?php include("session.inc");?>
<?php

$INGRESAR=$_POST["INGRESAR"];

if ($INGRESAR<>"") {
		$VAL_TIP_SEVER=$_POST["VAL_TIP_SEVER"];
		$DES_TIP_SEVER=COMILLAS($_POST["DES_TIP_SEVER"]);
		$ABR_TIP_SEVER=COMILLAS($_POST["ABR_TIP_SEVER"]);
		$BGCOLOR_TIP_SEVER=COMILLAS($_POST["BGCOLOR_TIP_SEVER"]);
		$CSSFONT_TIP_SEVER=COMILLAS($_POST["CSSFONT_TIP_SEVER"]);
		
			$CONSULTA="SELECT VAL_TIP_SEVER FROM FM_TIP_SEVER WHERE VAL_TIP_SEVER='". $VAL_TIP_SEVER. "' OR UPPER(ABR_TIP_SEVER)='". strtoupper($ABR_TIP_SEVER). "' ";
			$RS = sqlsrv_query($conn, $CONSULTA);
			//oci_execute($RS);
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_severidad.php?NEO=1&MSJE=2");
			} else {
				$CONSULTA2="SELECT IDENT_CURRENT ('FM_TIP_SEVER') AS MID_TIP_SEVER";
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				//oci_execute($RS2);
				if ($row = sqlsrv_fetch_array($RS2)) {
						$ID_TIP_SEVER=$row['MID_TIP_SEVER']+1;
					} else {
						$ID_TIP_SEVER=1;
				}
				$CONSULTA2="INSERT INTO FM_TIP_SEVER (VAL_TIP_SEVER, DES_TIP_SEVER, ABR_TIP_SEVER, BGCOLOR_TIP_SEVER, CSSFONT_TIP_SEVER, COD_USUARIO) ";
				$CONSULTA2=$CONSULTA2." VALUES (".$VAL_TIP_SEVER.", '".$DES_TIP_SEVER."', '".$ABR_TIP_SEVER."', '".$BGCOLOR_TIP_SEVER."','".$CSSFONT_TIP_SEVER."', ".$SESIDUSU.")";
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				//oci_execute($RS2);
				
				//REGISTRO DE ALTA
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."( 1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1171, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($maestra, $SQLOG);
						//oci_execute($RSL);																	


				header("Location: mant_severidad.php?ACT=".$ID_TIP_SEVER."&MSJE=3");
		}
		sqlsrv_close($conn);
}
				
				
$ACTUALIZAR=$_POST["ACTUALIZAR"];

if ($ACTUALIZAR<>"") {
		$ID_TIP_SEVER=$_POST["ID_TIP_SEVER"];
		$VAL_TIP_SEVER=$_POST["VAL_TIP_SEVER"];
		$DES_TIP_SEVER=COMILLAS($_POST["DES_TIP_SEVER"]);
		$ABR_TIP_SEVER=COMILLAS($_POST["ABR_TIP_SEVER"]);
		$BGCOLOR_TIP_SEVER=COMILLAS($_POST["BGCOLOR_TIP_SEVER"]);
		$CSSFONT_TIP_SEVER=COMILLAS($_POST["CSSFONT_TIP_SEVER"]);
		
			$CONSULTA="SELECT VAL_TIP_SEVER FROM FM_TIP_SEVER WHERE (VAL_TIP_SEVER='". $VAL_TIP_SEVER. "' OR UPPER(ABR_TIP_SEVER)='".strtoupper($ABR_TIP_SEVER)."') AND ID_TIP_SEVER<>".$ID_TIP_SEVER;
			$RS = sqlsrv_query($conn, $CONSULTA);
			//oci_execute($RS);
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_severidad.php?ACT=".$ID_TIP_SEVER."&MSJE=2");
			} else {
				$CONSULTA2="UPDATE FM_TIP_SEVER SET VAL_TIP_SEVER=".$VAL_TIP_SEVER." , DES_TIP_SEVER='".$DES_TIP_SEVER."', ABR_TIP_SEVER='".$ABR_TIP_SEVER."', BGCOLOR_TIP_SEVER='".$BGCOLOR_TIP_SEVER."', CSSFONT_TIP_SEVER='".$CSSFONT_TIP_SEVER."', FEC_ACTUALIZACION=convert(datetime,GETDATE(), 121), COD_USUARIO=".$SESIDUSU." WHERE ID_TIP_SEVER=".$ID_TIP_SEVER;
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				//oci_execute($RS2);

				//REGISTRO DE MODIFICACION
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."( 3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1171, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($maestra, $SQLOG);
						//oci_execute($RSL);																	

				header("Location: mant_severidad.php?ACT=".$ID_TIP_SEVER."&MSJE=1");
		}
		sqlsrv_close($conn);
}
				
				
$ELIMINAR=@$_GET["ELM"];

if ($ELIMINAR<>"") {
		$ID_TIP_SEVER=@$_GET["ID_TIP_SEVER"];
		
			$CONSULTA="DELETE FROM FM_TIP_SEVER WHERE ID_TIP_SEVER=".$ID_TIP_SEVER;
			$RS = sqlsrv_query($conn, $CONSULTA);
			//oci_execute($RS);

				//REGISTRO DE BAJA
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."( 2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1171, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($maestra, $SQLOG);
						//oci_execute($RSL);																	

			header("Location: mant_severidad.php?MSJE=4");
		sqlsrv_close($conn);
}
?>
