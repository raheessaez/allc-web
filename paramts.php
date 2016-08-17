<?php
							
		//PM_PARAM: INTERFACES
		//CONEXION MAESTRA VERSUS SISTEMA 1101
//					$SQLPARAM="SELECT * FROM PM_PARAM WHERE AMBITO=2 AND ESTADO=1 ORDER BY COD_PARAM ASC";
					$SQLPARAM="SELECT PM_PARAM.VAR_PARAM, PM_PARVAL.VAL_PARAM FROM PM_PARAM, PM_PARVAL WHERE PM_PARAM.COD_PARAM=PM_PARVAL.COD_PARAM AND PM_PARVAL.ESTADO=1 AND PM_PARAM.AMBITO=2 ORDER BY PM_PARAM.COD_PARAM ASC";
					if($_SESSION['ARMS_SIST']==1101){
						//$RS = sqlsrv_query($conn, $SQLPARAM);
						$RS = sqlsrv_query($conn,$SQLPARAM);
					} else {
						//$RS = sqlsrv_query($maestra, $SQLPARAM);
						$RS = sqlsrv_query($maestra,$SQLPARAM);

					}
					////oci_execute($RS);
					while ($row = sqlsrv_fetch_array($RS)) {
						$VAR_PMT=$row['VAR_PARAM'];
						${$VAR_PMT} = $_SERVER['DOCUMENT_ROOT'].$row['VAL_PARAM']; //VARIABLES DINAMICAS
					}
		
		//PM_PARAM: GLOBALES
		//CONEXION MAESTRA VERSUS SISTEMA 1101
//					$SQLINTER="SELECT * FROM PM_PARAM WHERE AMBITO=1 AND ESTADO=1 ORDER BY COD_PARAM ASC";
					$SQLINTER="SELECT PM_PARAM.VAR_PARAM, PM_PARVAL.VAL_PARAM FROM PM_PARAM, PM_PARVAL WHERE PM_PARAM.COD_PARAM=PM_PARVAL.COD_PARAM AND PM_PARVAL.ESTADO=1 AND PM_PARAM.AMBITO=1 ORDER BY PM_PARAM.COD_PARAM ASC";
					if($_SESSION['ARMS_SIST']==1101){
						//$RS = sqlsrv_query($conn, $SQLINTER);
						$RS = sqlsrv_query($conn,$SQLINTER);
					} else {
						//$RS = sqlsrv_query($maestra, $SQLINTER);
						$RS = sqlsrv_query($maestra,$SQLINTER);
					}
					////oci_execute($RS);
					while ($row = sqlsrv_fetch_array($RS)) {
						$VAR_PMT=$row['VAR_PARAM'];
						${$VAR_PMT} = $row['VAL_PARAM']; //VARIABLES DINAMICAS
					}

		
		//FECHA SERVIDOR
		date_default_timezone_set('America/Santiago');
		$FECSRV=date("d/m/Y");
		$TIMESRV=date("H:i:s");

		//COMILLAS
		function COMILLAS($cadena) {
			if (!empty($cadena)) {
				$RETORNA=str_replace ( "'", "''", $cadena); 
				return $RETORNA;
			}
		}
		function SINCOMILLAS($cadena) {
			if (!empty($cadena)) {
				$RETORNA=str_replace ( "'", "", $cadena); 
				return $RETORNA;
			}
		}
		function DOBLECOMILLAS($cadena) {
			if (!empty($cadena)) {
				$RETORNA=str_replace('"','',$cadena); 
				return $RETORNA;
			}
		}

		function Obtener_IP() {
			if (!empty($_SERVER['HTTP_CLIENT_IP']))
				return $_SERVER['HTTP_CLIENT_IP'];
			if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
				return $_SERVER['HTTP_X_FORWARDED_FOR'];
			return $_SERVER['REMOTE_ADDR'];
		}

		$IP_CLIENTE=Obtener_IP();
		
		//SESIONES GLOBALES
		$GLBELCLIENTE=$_SESSION['ARMS_NOMBSIS'];
		$GLBCODPAIS=$_SESSION['PAIS_CODE'];
		$GLBNOMPAIS=$_SESSION['PAIS_NOMBRE'];
		$MONEDA=$_SESSION['PAIS_MONEDA'];
		$CENTS=$_SESSION['PAIS_CENT'];
		$DIVCENTS=1;
		$DIVTAX=100;
		if($CENTS==1){ $DIVCENTS=10;$DIVTAX=1000;}
		if($CENTS==2){ $DIVCENTS=100;$DIVTAX=10000;}
		if($CENTS==3){ $DIVCENTS=1000;$DIVTAX=100000;}
		if($CENTS==4){ $DIVCENTS=10000;$DIVTAX=1000000;}
		$GLBDPTREG=$_SESSION['PAIS_DPEST'];
		$GLBDESCDPTREG=$_SESSION['PAIS_DREG'];
		$GLBCEDPERS=$_SESSION['PAIS_CEDP'];
		$GLBCEDEMPS=$_SESSION['PAIS_CEDE'];
		$GLBSMIL=$_SESSION['PAIS_SEPMIL'];
		$GLBSDEC=$_SESSION['PAIS_SEPDEC'];
		$ACTSU=$_SESSION['ARMS_ACTSU'];

?>