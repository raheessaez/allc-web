<?php include("session.inc");?>
<?php

$INGRESAR=$_POST["INGRESAR"];

if ($INGRESAR<>"") {
		$VAL_TIP_ESTADO=$_POST["VAL_TIP_ESTADO"];
		$DES_TIP_ESTADO=COMILLAS($_POST["DES_TIP_ESTADO"]);
		$ABR_TIP_ESTADO=COMILLAS($_POST["ABR_TIP_ESTADO"]);
		$BGCOLOR_TIP_ESTADO=COMILLAS($_POST["BGCOLOR_TIP_ESTADO"]);
		$CSSFONT_TIP_ESTADO=COMILLAS($_POST["CSSFONT_TIP_ESTADO"]);
		
			$CONSULTA="SELECT VAL_TIP_ESTADO FROM FM_TIP_ESTADO WHERE VAL_TIP_ESTADO='". $VAL_TIP_ESTADO. "' OR UPPER(ABR_TIP_ESTADO)='". strtoupper($ABR_TIP_ESTADO). "' ";
			$RS = sqlsrv_query($conn, $CONSULTA);
			//oci_execute($RS);
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_estproc.php?NEO=1&MSJE=2");
			} else {
				$CONSULTA2="SELECT IDENT_CURRENT ('FM_TIP_ESTADO') AS MID_TIP_ESTADO";
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				//oci_execute($RS2);
				if ($row = sqlsrv_fetch_array($RS2)) {
						$ID_TIP_ESTADO=$row['MID_TIP_ESTADO']+1;
					} else {
						$ID_TIP_ESTADO=1;
				}
				$CONSULTA2="INSERT INTO FM_TIP_ESTADO (VAL_TIP_ESTADO, DES_TIP_ESTADO, ABR_TIP_ESTADO, BGCOLOR_TIP_ESTADO, CSSFONT_TIP_ESTADO, COD_USUARIO) ";
				$CONSULTA2=$CONSULTA2." VALUES (".$VAL_TIP_ESTADO.", '".$DES_TIP_ESTADO."', '".$ABR_TIP_ESTADO."', '".$BGCOLOR_TIP_ESTADO."','".$CSSFONT_TIP_ESTADO."', ".$SESIDUSU.")";
				$RS2 = sqlsrv_query($conn, $CONSULTA2);

				//oci_execute($RS2);
				
				//REGISTRO DE ALTA
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, ID_TIP_ESTADO) VALUES ";
						$SQLOG=$SQLOG."( 1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1111)";
						$RSL = sqlsrv_query($conn, $SQLOG);
						//oci_execute($RSL);																	


				header("Location: mant_estproc.php?ACT=".$ID_TIP_ESTADO."&MSJE=3");
		}
		sqlsrv_close($conn);
}
				
				
$ACTUALIZAR=$_POST["ACTUALIZAR"];

if ($ACTUALIZAR<>"") {
		$ID_TIP_ESTADO=$_POST["ID_TIP_ESTADO"];
		$VAL_TIP_ESTADO=$_POST["VAL_TIP_ESTADO"];
		$DES_TIP_ESTADO=COMILLAS($_POST["DES_TIP_ESTADO"]);
		$ABR_TIP_ESTADO=COMILLAS($_POST["ABR_TIP_ESTADO"]);
		$BGCOLOR_TIP_ESTADO=COMILLAS($_POST["BGCOLOR_TIP_ESTADO"]);
		$CSSFONT_TIP_ESTADO=COMILLAS($_POST["CSSFONT_TIP_ESTADO"]);
		
			$CONSULTA="SELECT VAL_TIP_ESTADO FROM FM_TIP_ESTADO WHERE (VAL_TIP_ESTADO='". $VAL_TIP_ESTADO. "' OR UPPER(ABR_TIP_ESTADO)='".strtoupper($ABR_TIP_ESTADO)."') AND ID_TIP_ESTADO<>".$ID_TIP_ESTADO;
			$RS = sqlsrv_query($conn, $CONSULTA);
			//oci_execute($RS);
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_estproc.php?ACT=".$ID_TIP_ESTADO."&MSJE=2");
			} else {
				$CONSULTA2="UPDATE FM_TIP_ESTADO SET VAL_TIP_ESTADO=".$VAL_TIP_ESTADO." , DES_TIP_ESTADO='".$DES_TIP_ESTADO."', ABR_TIP_ESTADO='".$ABR_TIP_ESTADO."', BGCOLOR_TIP_ESTADO='".$BGCOLOR_TIP_ESTADO."', CSSFONT_TIP_ESTADO='".$CSSFONT_TIP_ESTADO."', FEC_ACTUALIZACION=convert(datetime,GETDATE(), 121), COD_USUARIO=".$SESIDUSU." WHERE ID_TIP_ESTADO=".$ID_TIP_ESTADO;
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				//oci_execute($RS2);

				//REGISTRO DE MODIFICACION
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, ID_TIP_ESTADO) VALUES ";
						$SQLOG=$SQLOG."( 3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1111)";
						$RSL = sqlsrv_query($conn, $SQLOG);
						//oci_execute($RSL);																	

				header("Location: mant_estproc.php?ACT=".$ID_TIP_ESTADO."&MSJE=1");
		}
		sqlsrv_close($conn);
}
				
				
$ELIMINAR=@$_GET["ELM"];

if ($ELIMINAR<>"") {
		$ID_TIP_ESTADO=@$_GET["ID_TIP_ESTADO"];
		
			$CONSULTA="DELETE FROM FM_TIP_ESTADO WHERE ID_TIP_ESTADO=".$ID_TIP_ESTADO;
			$RS = sqlsrv_query($conn, $CONSULTA);
			//oci_execute($RS);

				//REGISTRO DE BAJA
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, ID_TIP_ESTADO) VALUES ";
						$SQLOG=$SQLOG."( 2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1111)";
						$RSL = sqlsrv_query($conn, $SQLOG);
						//oci_execute($RSL);																	

			header("Location: mant_estproc.php?MSJE=4");
		sqlsrv_close($conn);
}
?>
