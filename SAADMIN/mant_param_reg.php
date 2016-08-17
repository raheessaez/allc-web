<?php include("session.inc");?>
<?php


//AGREGA PARAMETRO GENERICO 
$INGRESAR=$_POST["INGRESAR"];

if ($INGRESAR<>"") {
		$DES_PARAM=COMILLAS($_POST["DES_PARAM"]);
		$VAR_PARAM=COMILLAS($_POST["VAR_PARAM"]);
		$VAL_PARAM=COMILLAS($_POST["VAL_PARAM"]);
		$TIP_PARAM=$_POST["TIP_PARAM"];
		$AMBITO=$_POST["AMBITO"];
		$DES_CLAVE=$_POST["DES_CLAVE"];
		$ESTADO=$_POST["ESTADO"];
		
			$CONSULTA="SELECT VAR_PARAM FROM PM_PARAM WHERE (UPPER(VAR_PARAM)='". strtoupper($VAR_PARAM). "' OR UPPER(DES_PARAM)='". strtoupper($DES_PARAM). "') AND AMBITO=".$AMBITO;
			$RS = sqlsrv_query($conn, $CONSULTA);
			//oci_execute($RS);
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_param.php?NEO=1&MSJE=2");
			} else {

				
				
				$CONSULTA2="INSERT INTO PM_PARAM (DES_PARAM, VAR_PARAM, TIP_PARAM, AMBITO) ";
				$CONSULTA2=$CONSULTA2." VALUES ('".$DES_PARAM."', '".$VAR_PARAM."', ".$TIP_PARAM.", ".$AMBITO.")";
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				//oci_execute($RS2);
				//PM_PARVAL
				

				$CONSULTA2="SELECT IDENT_CURRENT ('PM_PARAM') AS MCOD_PARAM";
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				//oci_execute($RS2);
				if ($row = sqlsrv_fetch_array($RS2)) {
						$COD_PARAM=$row['MCOD_PARAM'];
					}


				$CONSULTA2="INSERT INTO PM_PARVAL (COD_PARAM, VAL_PARAM, ESTADO, IDREG) ";
				$CONSULTA2=$CONSULTA2." VALUES (".$COD_PARAM.",'".$VAL_PARAM."',".$ESTADO.", ".$SESIDUSU.")";
				$RS2 = sqlsrv_query($conn, $CONSULTA2);


				$CONSULTA2="SELECT IDENT_CURRENT ('PM_PARVAL')  AS MID_PARVAL";
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				//oci_execute($RS2);
				if ($row = sqlsrv_fetch_array($RS2)) {
						$ID_PARVAL=$row['MID_PARVAL'];
					} 
				//oci_execute($RS2);
				if(!empty($DES_CLAVE)){
				$SQLD="UPDATE PM_PARVAL SET DES_CLAVE=".$DES_CLAVE." WHERE ID_PARVAL=".$ID_PARVAL;
				$RS2 = sqlsrv_query($conn, $SQLD);
				//oci_execute($RS2);
				}


				//REGISTRO DE ALTA
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1173, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($conn, $SQLOG);
						//oci_execute($RSL);																	


				header("Location: mant_param.php?ACT=".$ID_PARVAL."&MSJE=3");
		}
		sqlsrv_close($conn);
}
				
//ACTUALIZA PARAMETRO GENERICO				
$ACTUALIZAR=$_POST["ACTUALIZAR"];

if ($ACTUALIZAR<>"") {
		$COD_PARAM=$_POST["COD_PARAM"];
		$DES_PARAM=COMILLAS($_POST["DES_PARAM"]);
		$VAR_PARAM=COMILLAS($_POST["VAR_PARAM"]);
		$VAL_PARAM=COMILLAS($_POST["VAL_PARAM"]);
		$TIP_PARAM=$_POST["TIP_PARAM"];
		$AMBITO=$_POST["AMBITO"];
		$ID_PARVAL=$_POST["ID_PARVAL"];
		$ESTADO=$_POST["ESTADO"];
		
			$CONSULTA="SELECT VAR_PARAM FROM PM_PARAM WHERE ((UPPER(VAR_PARAM)='". strtoupper($VAR_PARAM). "' OR UPPER(DES_PARAM)='". strtoupper($DES_PARAM). "') AND AMBITO=".$AMBITO.") AND COD_PARAM<>".$COD_PARAM;
			$RS = sqlsrv_query($conn, $CONSULTA);
			//oci_execute($RS);
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_param.php?ACT=".$COD_PARAM."&MSJE=2");
			} else {
				$CONSULTA2="UPDATE PM_PARAM SET DES_PARAM='".$DES_PARAM."', VAR_PARAM='".$VAR_PARAM."',TIP_PARAM=".$TIP_PARAM.", AMBITO=".$AMBITO." WHERE COD_PARAM=".$COD_PARAM;
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				//oci_execute($RS2);

				$CONSULTA2="UPDATE PM_PARVAL SET VAL_PARAM='".$VAL_PARAM."', ESTADO=".$ESTADO." , FECHA= convert(datetime,GETDATE(), 121) , IDREG=".$SESIDUSU." WHERE ID_PARVAL=".$ID_PARVAL;
				$RS2 = sqlsrv_query($conn, $CONSULTA2);

				//oci_execute($RS2);
				
				//REGISTRO DE MODIFICACION
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(3,convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1173, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";


						$RSL = sqlsrv_query($conn, $SQLOG);
						//oci_execute($RSL);																	
						
				header("Location: mant_param.php?ACT=".$COD_PARAM."&MSJE=1");
		}
		sqlsrv_close($conn);
}
				
				
//AGREGA PARAMETRO TIENDA				
$AGREGAVAL=$_POST["AGREGAVAL"];

if ($AGREGAVAL<>"") {
		$COD_PARAM=$_POST["COD_PARAM"];
		$VAL_PARAM=COMILLAS($_POST["NEOVAL_PARAM"]);
		$DES_CLAVE=$_POST["DES_CLAVE"];
		$ESTADO=$_POST["ESTADO"];
		
			$CONSULTA="SELECT * FROM PM_PARVAL WHERE DES_CLAVE=".$DES_CLAVE." AND COD_PARAM=".$COD_PARAM;
			$RS = sqlsrv_query($conn, $CONSULTA);
			//oci_execute($RS);
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_param.php?MSJE=5");
			} else {
				//PM_PARVAL
				$CONSULTA2="SELECT IDENT_CURRENT ('PM_PARVAL') AS MID_PARVAL";
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				//oci_execute($RS2);
				if ($row = sqlsrv_fetch_array($RS2)) {
						$ID_PARVAL=$row['MID_PARVAL']+1;
					} else {
						$ID_PARVAL=1;
				}
				$CONSULTA2="INSERT INTO PM_PARVAL (COD_PARAM, VAL_PARAM, DES_CLAVE, ESTADO, IDREG) ";
				$CONSULTA2=$CONSULTA2." VALUES (".$COD_PARAM.",'".$VAL_PARAM."',".$DES_CLAVE.",".$ESTADO.", ".$SESIDUSU.")";
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				//oci_execute($RS2);
				
				//REGISTRO DE MODIFICACION
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(1,convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1173, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($conn, $SQLOG);
						//oci_execute($RSL);																	

				header("Location: mant_param.php?ACT=".$ID_PARVAL."&MSJE=3");
		}
		sqlsrv_close($conn);
}
				
//ACTUALIZA PARAMETRO TIENDA				
$ACTVAL_PARAM=$_POST["ACTVAL_PARAM"];

if ($ACTVAL_PARAM<>"") {
		$ID_PARVAL=$_POST["ID_PARVAL"];
		$VAL_PARAM=COMILLAS($_POST["ACTVAL_PARAM"]);
		$ESTADO=$_POST["ESTADO"];
		
				$CONSULTA2="UPDATE PM_PARVAL SET VAL_PARAM=".$VAL_PARAM.", ESTADO=".$ESTADO." , FECHA=convert(datetime,GETDATE(), 121), IDREG=".$SESIDUSU." WHERE ID_PARVAL=".$ID_PARVAL;
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				//oci_execute($RS2);
				
				//REGISTRO DE MODIFICACION
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1173, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($conn, $SQLOG);
						//oci_execute($RSL);																	

				header("Location: mant_param.php?ACT=".$ID_PARVAL."&MSJE=1");
		sqlsrv_close($conn);
}
				
				
?>
