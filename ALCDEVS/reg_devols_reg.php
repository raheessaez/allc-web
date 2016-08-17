<?php include("session.inc");?>
<?php
	$REGISTRANC=@$_POST["REGISTRANC"];
	if(!empty($REGISTRANC)){

		$D_GFC=@$_POST["D_GFC"];
		$ID_TRN=@$_POST["ID_TRN"];
		$ID_DEVS=@$_POST["ID_DEVS"];
		$TY_CPR=@$_POST["TY_CPRSEL"];
		$ID_CPR=@$_POST["ID_CPR"];

		$IDENTIFICACION=strtoUPPER(LTRIM(@$_POST["IDENTIFICACION"]));
		$NACIONALIDAD=strtoUPPER(LTRIM(SINCOMILLAS(@$_POST["NACIONALIDAD"])));
		$NOMBRE=SINCOMILLAS(@$_POST["NOMBRE"]);
		$DIRECCION=SINCOMILLAS(@$_POST["DIRECCION"]);
		$COD_REGION=@$_POST["COD_REGION"];
		$COD_CIUDAD=@$_POST["COD_CIUDAD"];
		$TELEFONO=SINCOMILLAS(@$_POST["TELEFONO"]);
		$CORREO=SINCOMILLAS(strtolower(@$_POST["CORREO"]));
		
		//VERIFICAR IDENTIFICACION CLIENTE EN ARTS
		if($TY_CPR!="P"){ //ES CEDULA O RUC
							$SQLCLTE="SELECT ID_CPR FROM CO_CPR_CER WHERE ID_CPR=".$ID_CPR; 
							
							//$RSC = sqlsrv_query($arts_conn, $SQLCLTE);
							////oci_execute($RSC);
							$RSC = sqlsrv_query($arts_conn,$SQLCLTE); 
							
							if ($rowCLT = sqlsrv_fetch_array($RSC)){
								//ACTUALIZAR CLIENTE
								$S2="UPDATE CO_CPR_CER SET NOMBRE='".$NOMBRE."', DIRECCION='".$DIRECCION."', TELEFONO='".$TELEFONO."', CORREO='".$CORREO."', COD_REGION=".$COD_REGION.", COD_CIUDAD=".$COD_CIUDAD."  WHERE ID_CPR=".$ID_CPR;
								//$RS2 = sqlsrv_query($arts_conn, $S2);
								////oci_execute($RS2);
								$RS2 = sqlsrv_query($arts_conn,$S2); 
							} else {
								//REGISTRAR CLIENTE RG_INT=1
								$ID_CPR=(int)$ID_CPR;
								//CONVERTIR CD_CPR EN ID_CPR
								$S2="INSERT INTO CO_CPR_CER (TY_CPR, RG_INT, CD_CPR, NOMBRE, DIRECCION, TELEFONO, CORREO, COD_CIUDAD, COD_REGION) ";
								$S2=$S2." VALUES ('".$TY_CPR."', 1, '".$IDENTIFICACION."', '".$NOMBRE."', '".$DIRECCION."', '".$TELEFONO."', '".$CORREO."', ".$COD_CIUDAD." , ".$COD_REGION." )";
								//$RS2 = sqlsrv_query($arts_conn, $S2);
								////oci_execute($RS2);
								$RS2 = sqlsrv_query($arts_conn,$S2); 
							}
		} else { //ES PASAPORTE
							$SQLCLTE="SELECT ID_CPR FROM CO_EXT_CER WHERE ID_CPR=".$ID_CPR; 
							
							//$RSC = sqlsrv_query($arts_conn, $SQLCLTE);
							////oci_execute($RSC);
							
							$RSC = sqlsrv_query($arts_conn,$SQLCLTE); 

							if ($rowCLT = sqlsrv_fetch_array($RSC)){
								//ACTUALIZAR CLIENTE
								$S2="UPDATE CO_EXT_CER SET NOMBRE='".$NOMBRE."', DIRECCION='".$DIRECCION."', TELEFONO='".$TELEFONO."', CORREO='".$CORREO."', NACIONALIDAD='".$NACIONALIDAD."'  WHERE ID_CPR=".$ID_CPR;
								//$RS2 = sqlsrv_query($arts_conn, $S2);
								////oci_execute($RS2);
								$RS2 = sqlsrv_query($arts_conn,$S2); 
							} else {
								$S2="SELECT MAX(ID_CPR) AS MID_CPR FROM CO_EXT_CER";
								
								//$RS2 = sqlsrv_query($arts_conn, $S2);
								////oci_execute($RS2);
								$RS2 = sqlsrv_query($arts_conn,$S2); 
								
								if ($row = sqlsrv_fetch_array($RS2)) { $ID_CPR=$row['MID_CPR']+1; } else { $ID_CPR=1; }
								//CONVERTIR CD_CPR EN ID_CPR
								$S2="INSERT INTO CO_EXT_CER (ID_CPR, CD_CPR, NOMBRE, DIRECCION, TELEFONO, CORREO, NACIONALIDAD) ";
								$S2=$S2." VALUES (".$ID_CPR.", '".$IDENTIFICACION."', '".$NOMBRE."', '".$DIRECCION."', '".$TELEFONO."', '".$CORREO."', '".$NACIONALIDAD."')";
								//$RS2 = sqlsrv_query($arts_conn, $S2);
								////oci_execute($RS2);
								$RS2 = sqlsrv_query($arts_conn,$S2); 
							}
		}
		
		//REGISTRO DE DV_TICKET (NOTA DE CREDITO)
				$S2="UPDATE DV_TICKET SET ID_ESTADO=1 WHERE ID_DEVS=".$ID_DEVS;
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2); 
				$S2="SELECT SUM(MO_DEV) AS TOT_DEV FROM DV_ARTS WHERE ID_DEVS=".$ID_DEVS;
				
				//$RS2 = sqlsrv_query($conn, $S2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$S2);

				if ($row2 = sqlsrv_fetch_array($RS2)){
					$TOTAL_DEV = $row2['TOT_DEV'];
				}

		//MEDIOS DE PAGO MEDIOS DE PAGO MEDIOS DE PAGO MEDIOS DE PAGO MEDIOS DE PAGO MEDIOS DE PAGO MEDIOS DE PAGO MEDIOS DE PAGO MEDIOS DE PAGO MEDIOS DE PAGO MEDIOS DE PAGO MEDIOS DE PAGO MEDIOS DE PAGO MEDIOS DE PAGO MEDIOS DE PAGO MEDIOS DE PAGO MEDIOS DE PAGO MEDIOS DE PAGO MEDIOS DE PAGO 
		$NUM_MP=@$_POST["NUM_MP"];
		$ID_TND_POST=@$_POST["ID_TND"];
		
		if($NUM_MP==1){
			//SUMAR MONTOS CUANDO SE REPITE MEDIO DE PAGO/ VERIFICAR QUE NO EXCEDA EL MONTO EN DEVOLUCIÓN
			$SQLMP="SELECT SUM(MO_ITM_LN_TND) AS MO_TOTMP  FROM TR_LTM_TND WHERE ID_TRN=".$ID_TRN." AND ID_TND=".$ID_TND_POST;
			
			//$RSMP = sqlsrv_query($arts_conn, $SQLMP);
			////oci_execute($RSMP);
			$RSMP = sqlsrv_query($arts_conn,$SQLMP);
			
			if ($rowMP = sqlsrv_fetch_array($RSMP)) {
				$MO_TOTMP = $rowMP['MO_TOTMP'];
			}
			$SQLMP="SELECT TY_TND FROM AS_TND WHERE ID_TND=".$ID_TND_POST;
			
			//$RSMP = sqlsrv_query($arts_conn, $SQLMP);
			////oci_execute($RSMP);
			$RSMP = sqlsrv_query($arts_conn,$SQLMP);

			if ($rowMP = sqlsrv_fetch_array($RSMP)) {
				$TY_TND = $rowMP['TY_TND'];
			}
			//VERIFICAR CON $TOTAL_DEV
			if($TOTAL_DEV<$MO_TOTMP) {$MO_TOTMP=$TOTAL_DEV;}
			$S2="INSERT INTO DV_MDPTCK (ID_DEVS, TY_TND, MONTO) ";
			$S2=$S2." VALUES (".$ID_DEVS.", '".$TY_TND."', ".$MO_TOTMP.")";
			//$RS2 = sqlsrv_query($conn, $S2);
			////oci_execute($RS2);
			$RS2 = sqlsrv_query($conn,$S2);
			
		} else {
			//AVERIGUAR CUANTOS MEDIOS DE PAGO
			//SUMAR MONTOS CUANDO SE REPITE MEDIO DE PAGO/ VERIFICAR QUE NO EXCEDA EL MONTO EN DEVOLUCIÓN
			$ARR_IDTND=array(); //DECLARO ARREGLO DE MEDIOS DE PAGO Y MONTOS PAGADOS
			$S2="SELECT ID_TND  FROM TR_LTM_TND WHERE ID_TRN=".$ID_TRN;
			
			//$RS2 = sqlsrv_query($arts_conn, $S2);
			////oci_execute($RS2);
			$RS2 = sqlsrv_query($arts_conn,$S2);

			

			while ($row2 = sqlsrv_fetch_array($RS2)) {
				$ID_TND = $row2['ID_TND'];
				//GENERAR ARREGLO CON MEDIOS DE PAGO
				array_push($ARR_IDTND, $ID_TND); //INCREMENTO EL ARREGLO CON CADA MEDIO DE PAGO
			}	
			foreach( $ARR_IDTND as $ID_TND){
				$SQLMP="SELECT SUM(MO_ITM_LN_TND) AS MO_TOTMP  FROM TR_LTM_TND WHERE ID_TRN=".$ID_TRN." AND ID_TND=".$ID_TND;
				
				//$RSMP = sqlsrv_query($arts_conn, $SQLMP);
				////oci_execute($RSMP);
				$RSMP = sqlsrv_query($arts_conn,$SQLMP);
				
				if ($rowMP = sqlsrv_fetch_array($RSMP)) {
					$MO_TOTMP = $rowMP['MO_TOTMP'];
				}
				$SQLMP="SELECT TY_TND FROM AS_TND WHERE ID_TND=".$ID_TND;
				
				//$RSMP = sqlsrv_query($arts_conn, $SQLMP);
				////oci_execute($RSMP);
				$RSMP = sqlsrv_query($arts_conn,$SQLMP);

				if ($rowMP = sqlsrv_fetch_array($RSMP)) {
					$TY_TND = $rowMP['TY_TND'];
				}
				//SI TIPOID=3 (CAMBIO CLIENTE)
				if($D_GFC==3){ //REGISTRAR TODOS
						$S2="INSERT INTO DV_MDPTCK (ID_DEVS, TY_TND, MONTO) ";
						$S2=$S2." VALUES (".$ID_DEVS.", '".$TY_TND."', ".$MO_TOTMP.")";
						
						//$RS2 = sqlsrv_query($conn, $S2);
						////oci_execute($RS2);

						$RS2 = sqlsrv_query($conn,$S2);

				} else { //REGISTRAR SELECCIONADO Y ASOCIAR EL TOTAL DE LA DEVOLUCIÓN
						if($ID_TND==$ID_TND_POST){
								$S2="INSERT INTO DV_MDPTCK (ID_DEVS, TY_TND, MONTO) ";
								$S2=$S2." VALUES (".$ID_DEVS.", '".$TY_TND."', ".$TOTAL_DEV.")";
								
								//$RS2 = sqlsrv_query($conn, $S2);
								////oci_execute($RS2);

								$RS2 = sqlsrv_query($conn,$S2);

						}
				}
			}
		}

		//REGISTRO DE CLIENTE ASOCIA ARTS.CO_CPR_CER CON DEVOLUCION
		$S2="INSERT INTO DV_DEVCLTE (ID_DEVS, ID_CPR, TY_CPR) ";
		$S2=$S2." VALUES (".$ID_DEVS.", ".$ID_CPR.", '".$TY_CPR."')";
		
		//$RS2 = sqlsrv_query($conn, $S2);
		////oci_execute($RS2);
		$RS2 = sqlsrv_query($conn,$S2);

		//FIN REGISTRO CLIENTE

		header("Location: reg_devols.php?D_GFC=".$D_GFC."&C_DEV=1&IDD=".$ID_DEVS);

}//FIN REGISTRANC


//ELIMINA REGISTRO
	$ELMNC=@$_GET["ELMNC"];
	if(!empty($ELMNC)){
		$ID_DEVS=@$_GET["ID_DEVS"];
		$ID_TIPOD=@$_GET["ID_TIPOD"];
		$ID_CPR=@$_GET["ID_CPR"];
		$SQL="SELECT COUNT(ID_DEVS) AS CID_DEVS FROM DV_DEVCLTE WHERE ID_CPR=".$ID_CPR;
		
		//$RS = sqlsrv_query($conn, $SQL);
		////oci_execute($RS);
		$RS = sqlsrv_query($conn,$SQL);

		if ($ROW = sqlsrv_fetch_array($RS)) {
				$CID_DEVS=$ROW['CID_DEVS'];
		}
		if($CID_DEVS<=1){
				$SQL2="DELETE FROM DV_DEVCLTE WHERE ID_CPR=".$ID_CPR;
				
				//$RS2 = sqlsrv_query($conn, $SQL2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$SQL2);

		} else {
				$SQL2="DELETE FROM DV_DEVCLTE WHERE ID_CPR=".$ID_CPR." AND ID_DEVS=".$ID_DEVS;
				//$RS2 = sqlsrv_query($conn, $SQL2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$SQL2);
		}
		if($ID_TIPOD==1){ 
				//VERIFICAR REGISTRO DE ARCHIVO
				$SQL="SELECT ARCHIVO FROM DV_GFCD WHERE ID_DEVS=".$ID_DEVS;
				
				//$RS = sqlsrv_query($conn, $SQL);
				////oci_execute($RS);
				$RS = sqlsrv_query($conn,$SQL);

				if ($row = sqlsrv_fetch_array($RS)) {
					$ARCHIVO = $row['ARCHIVO']; //NOMBRE DE ARCHIVO
					unlink("_arc_tmp/".$ARCHIVO);
					unlink($DIR_GFT."/IN/".$ARCHIVO);
					unlink($DIR_GFT."/BKP/".$ARCHIVO);
					/*
					$DIRLOCAL = "_arc_tmp/";
					$DIREYES = $DIR_EX_GFC_IN;
							$conn_id = ftp_connect($FTP_SERVER); 
							$login_result = ftp_login($conn_id, $FTP_UNM, $FTP_UPW);
								ftp_delete($conn_id, $DIREYES.$ARCHIVO);
							ftp_close($conn_id);
					*/
				}
				$SQL2="DELETE FROM DV_GFCD WHERE ID_DEVS=".$ID_DEVS;
				//$RS2 = sqlsrv_query($conn, $SQL2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$SQL2);
		}
		if($ID_TIPOD==2){ 
				$SQL2="DELETE FROM DV_EFEC WHERE ID_DEVS=".$ID_DEVS;
				//$RS2 = sqlsrv_query($conn, $SQL2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$SQL2);
		}
		if($ID_TIPOD==3){ 
				$SQL2="DELETE FROM DV_FACT WHERE ID_DEVS=".$ID_DEVS;
				//$RS2 = sqlsrv_query($conn, $SQL2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$SQL2);
		}
		$SQL2="DELETE FROM DV_ARTS WHERE ID_DEVS=".$ID_DEVS;
		//$RS2 = sqlsrv_query($conn, $SQL2);
		////oci_execute($RS2);
		$RS2 = sqlsrv_query($conn,$SQL2);

		$SQL2="DELETE FROM DV_MDPTCK WHERE ID_DEVS=".$ID_DEVS;
		//$RS2 = sqlsrv_query($conn, $SQL2);
		////oci_execute($RS2);
		
		$RS2 = sqlsrv_query($conn,$SQL2);
		
		$SQL2="DELETE FROM DV_TICKET WHERE ID_DEVS=".$ID_DEVS;
		//$RS2 = sqlsrv_query($conn, $SQL2);
		////oci_execute($RS2);
		$RS2 = sqlsrv_query($conn,$SQL2);
		
		header("Location: reg_devols.php?D_GFC=".$ID_TIPOD."&MSJE=2");
	}
//FIN ELIMINA REGISTRO



//CONFIRMA REGISTRO... SOLO EFECTIVO Y FACTURA
	$REGNC=@$_GET["REGNC"];
	if(!empty($REGNC)){
		$ID_DEVS=@$_GET["ID_DEVS"];
		$ID_TIPOD=@$_GET["ID_TIPOD"];

		$SQL="UPDATE DV_TICKET SET ID_ESTADO=2 WHERE ID_DEVS=".$ID_DEVS;

		//$RS = sqlsrv_query($conn, $SQL);
		////oci_execute($RS);
		$RS = sqlsrv_query($conn,$SQL);

		$SQL="SELECT * FROM DV_TICKET WHERE ID_DEVS=".$ID_DEVS;

		//$RS = sqlsrv_query($conn, $SQL);
		////oci_execute($RS);
		$RS = sqlsrv_query($conn,$SQL);

		if ($row = sqlsrv_fetch_array($RS)) {
			$ID_TRN = $row['ID_TRN']; //ID TRX EN ARTS
		}
		
		$SQL="SELECT SUM(MO_DEV) AS MO_DEV FROM DV_ARTS WHERE ID_DEVS=".$ID_DEVS;
		//$RS = sqlsrv_query($conn, $SQL);
		////oci_execute($RS);
		$RS = sqlsrv_query($conn,$SQL);

		if ($row = sqlsrv_fetch_array($RS)) {
			$MO_DEV = $row['MO_DEV']; //MONTO TOTAL TRX DEV
		}
		if($ID_TIPOD==2){
				$SQL="INSERT INTO DV_EFEC (ID_DEVS, ID_TRN, MONTO, ESTADO) VALUES (".$ID_DEVS.", ".$ID_TRN.", ".$MO_DEV.", 1)";
				
				//$RS = sqlsrv_query($conn, $SQL);
				////oci_execute($RS);
				$RS = sqlsrv_query($conn,$SQL);

				header("Location: reg_devols.php?VDNC=".$ID_DEVS."&MSJE=8");
		}
	}

//CONFIRMA COBRO EN POS... SOLO EFECTIVO
	$REGCOBROPOS=@$_POST["REGCOBROPOS"];
	if(!empty($REGCOBROPOS)){
		$ID_DEVS=@$_POST["ID_DEVS"];
		$ID_WS=@$_POST["TERMPOS"];
		$SQL="UPDATE DV_EFEC SET ESTADO=2, ID_WS=".$ID_WS." WHERE ID_DEVS=".$ID_DEVS;
		
		//$RS = sqlsrv_query($conn, $SQL);
		////oci_execute($RS);
		$RS = sqlsrv_query($conn,$SQL);
		
		$SQL="UPDATE DV_TICKET SET ID_ESTADO=5 WHERE ID_DEVS=".$ID_DEVS;
		
		//$RS = sqlsrv_query($conn, $SQL);
		////oci_execute($RS);
		$RS = sqlsrv_query($conn,$SQL);

		header("Location: reg_devols.php?VDNC=".$ID_DEVS."&MSJE=9");
	}

//CONFIRMA COBRO Y PAGO POR VENTANILLA... SOLO EFECTIVO
	$REGCOBROVEN=@$_POST["REGCOBROVEN"];
	if(!empty($REGCOBROVEN)){
		$ID_DEVS=@$_POST["ID_DEVS"];
		$SQL="UPDATE DV_EFEC SET ESTADO=3 WHERE ID_DEVS=".$ID_DEVS;
		
		//$RS = sqlsrv_query($conn, $SQL);
		////oci_execute($RS);
		$RS = sqlsrv_query($conn,$SQL);

		$SQL="UPDATE DV_TICKET SET ID_ESTADO=5 WHERE ID_DEVS=".$ID_DEVS;
		
		//$RS = sqlsrv_query($conn, $SQL);
		////oci_execute($RS);
		$RS = sqlsrv_query($conn,$SQL);

		header("Location: reg_devols.php?VDNC=".$ID_DEVS."&MSJE=10");
	}


//CAMBIO DE FACTURA Y GENERACION DE ARCHIVO DE TRANSACCION SUSPENDIDA
	$REGCAMBFACT=@$_POST["REGCAMBFACT"];
	if(!empty($REGCAMBFACT)){
		
		$SQL="ALTER SESSION SET nls_date_format='DD-MM-YYYY HH24:MI:SS'";
		//$RS = sqlsrv_query($arts_conn, $SQL);
		////oci_execute($RS);
		$RS = sqlsrv_query($arts_conn,$SQL);
		
		$ID_DEVS=@$_POST["ID_DEVS"];		
		$ID_WS=@$_POST["TERMPOSFACT"];
		
		$SQL="UPDATE DV_TICKET SET ID_ESTADO=4 WHERE ID_DEVS=".$ID_DEVS;
		//$RS = sqlsrv_query($conn, $SQL);
		////oci_execute($RS);
		$RS = sqlsrv_query($conn,$SQL);
		
		$SQL="SELECT * FROM DV_TICKET WHERE ID_DEVS=".$ID_DEVS;
		
		//$RS = sqlsrv_query($conn, $SQL);
		////oci_execute($RS);
		$RS = sqlsrv_query($conn,$SQL);

		if ($row = sqlsrv_fetch_array($RS)) {
			$ID_TRN = $row['ID_TRN']; //ID TRX EN ARTS
			$ID_TIPOD = $row['ID_TIPOD']; //TIPO DEV
		}
		
		$SQL="SELECT SUM(MO_DEV) AS MO_DEV FROM DV_ARTS WHERE ID_DEVS=".$ID_DEVS;
		
		//$RS = sqlsrv_query($conn, $SQL);
		////oci_execute($RS);
		$RS = sqlsrv_query($conn,$SQL);

		if ($row = sqlsrv_fetch_array($RS)) {
			$MO_DEV = $row['MO_DEV']; //MONTO TOTAL TRX DEV
		}
		
		$SQL="INSERT INTO DV_FACT (ID_DEVS, ID_WS, ID_TRN, MONTO, ESTADO) VALUES (".$ID_DEVS.", ".$ID_WS.", ".$ID_TRN.", ".$MO_DEV.", 2)";
		
		//$RS = sqlsrv_query($conn, $SQL);
		////oci_execute($RS);
		$RS = sqlsrv_query($conn,$SQL);
		
				//PL:: PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA 
				//PL:: ID DE LÍNEA(2.1)
						$ID_LN0="00";
				//PL1:: TIPOTRX(1.1)    1= COTIZACION(NAA) | 2= GIFTCARD/EFECTIVO TIPOID=1,2 | 3= NC+CAMBIOCLIENTE TIPOID=3 | 4= RESERVADO(NAA)
						if($ID_TIPOD==1 || $ID_TIPOD==2){ $ARC_TIPOTRX=2;}
						if($ID_TIPOD==3){ $ARC_TIPOTRX=3;}
				//PL2:: CANT LINEAS DETALLE(4.2) 
						$ARC_NUMLNS = 0;
				//PL3:: FECHA(8.6) YYYYMMDD
						$ARC_FECHA=date("Ymd");
				//PL4:: HORA(4.14) HHMM
						$ARC_HORA=date("Hi");
				//PL5:: COD OPERADOR ARMS(4.18)
						$SQL="SELECT NOMBRE FROM US_USUARIOS WHERE IDUSU=".$ID_REG;
						//$RS = sqlsrv_query($maestra, $SQL);
						////oci_execute($RS);
						$RS = sqlsrv_query($maestra,$SQL);

						if ($row = sqlsrv_fetch_array($RS)) {
							$ARC_NOMOPERA = strtoupper($row['NOMBRE']);
						}
						$ARC_CD_OPR="0000".$ID_REG;
						$ARC_CD_OPR=substr($ARC_CD_OPR, -4); 
				//PL6:: NOM OPERADOR(20.22)
						$ARC_NM_OPR = $ARC_NOMOPERA."                                                            ";
						$ARC_NM_OPR=substr($ARC_NM_OPR, 0, 20); 
				//PL7:: IMPORTE TOTAL(6,2.42)
						$ARC_MNTDEV="00000000".$MO_DEV;
						$ARC_MNTDEV=substr($ARC_MNTDEV, -8); 
				//PL8:: NUM TRX(4.50) sólo ceros
						$ARC_NUMTRX = "0000";
				//PL9:: NUM TRX ORIGEN(4.54) ID del Ticket
							$SQL="SELECT * FROM TR_TRN WHERE ID_TRN=".$ID_TRN;
							
							//$RS = sqlsrv_query($arts_conn, $SQL);
							////oci_execute($RS);
							$RS = sqlsrv_query($arts_conn,$SQL);

							if ($row = sqlsrv_fetch_array($RS)) {
								$FECHA_TRX = $row['DC_DY_BSN'];
								$HORA_TRX = $row['TS_TRN_END'];
								$TIENDA_TRX = $row['ID_BSN_UN'];
								$AI_TRN = $row['AI_TRN'];
							}
						$ARC_NUMTRXORG="0000".$AI_TRN;
						$ARC_NUMTRXORG=substr($ARC_NUMTRXORG, -4); 
				//PL10:: NUM DEVOL(8.58) número Nota de Crédito
						$ARC_NUMNC="00000000".$ID_DEVS;
						$ARC_NUMNC=substr($ARC_NUMNC, -8); 
				//PL11:: FECHA TRX ORIGEN(8.66) YYYYMMDD
						$FEC_TRX = strtotime ($FECHA_TRX); 
						$ARC_FECORG = date( 'Ymd', $FEC_TRX ) ; 
				//PL12:: HORA TRX ORIGEN(4.74) HHMM
						$HOR_TRX = strtotime ($HORA_TRX); 
						$ARC_HORORG = date( 'Hi', $HOR_TRX ) ; 
				//PL13:: TIENDA TRX ORIGEN(4.78)
						$SQL="SELECT CD_STR_RT FROM PA_STR_RTL WHERE ID_BSN_UN=".$TIENDA_TRX;
						
						//$RS = sqlsrv_query($arts_conn, $SQL);
						////oci_execute($RS);
						$RS = sqlsrv_query($arts_conn,$SQL);

						if ($row = sqlsrv_fetch_array($RS)) {
							$TIENDA = $row['CD_STR_RT'];
						}
						$ARC_NUMTIENDA="0000".$TIENDA;
						$ARC_NUMTIENDA=substr($ARC_NUMTIENDA, -4);
						$EXT_ARC="000".$TIENDA;
						$EXT_ARC=substr($EXT_ARC, -3);
				//PL14:: TERMINAL POS (4.82)
						$SQL="SELECT CD_WS FROM AS_WS WHERE ID_WS=".$ID_WS;
						//$RS = sqlsrv_query($arts_conn, $SQL);
						////oci_execute($RS);
						$RS = sqlsrv_query($arts_conn,$SQL);
						if ($row = sqlsrv_fetch_array($RS)) {
							$ARC_TPOS = $row['CD_WS'];
						}
						$ARC_TPOS="0000".$ARC_TPOS;
						$ARC_TPOS=substr($ARC_TPOS, -4); 
				
				//SL:: SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA 
						//OBTENER ARTÍCULOS DESDE DV_ARTS
						$SITM="SELECT * FROM DV_ARTS WHERE ID_DEVS=".$ID_DEVS;
						//$RITM = sqlsrv_query($conn, $SITM);
						////oci_execute($RITM);
						$RITM = sqlsrv_query($conn,$SITM);

						$CONTADOR=1;
						$SL="";
						$ID_LN1="01";
						while ($rowITM = sqlsrv_fetch_array($RITM)) {
							$ID_ITM = $rowITM['ID_ITM'];
							$QN_ITM = $rowITM['QN_DEV'];
							$MN_ITM = $rowITM['MO_DEV'];
							$AI_LN_ITM = $rowITM['AI_LN_ITM'];
							$TAX_DEV = $rowITM['TAX_DEV'];
							$TY_TX = $rowITM['TY_TAX'];
							//SL:: COD ARTICULO ACE(12)
							$SQL="SELECT * FROM AS_ITM WHERE ID_ITM=".$ID_ITM;
							
							//$RS = sqlsrv_query($arts_conn, $SQL);
							////oci_execute($RS);
							$RS = sqlsrv_query($arts_conn,$SQL);

							if ($row = sqlsrv_fetch_array($RS)) {
								$CD_ITM = $row['CD_ITM'];
								$NM_ITM = $row['NM_ITM'];
								//SL:: TIPO ART(1) unitario=U, pesable=P
								$FL_WM_RQ = $row['FL_WM_RQ'];
								$ID_DPT_PS = $row['ID_DPT_PS'];
								$ID_MRHRC_GP = $row['ID_MRHRC_GP'];
							}
							$ARC_CODEAN="000000000000".$CD_ITM;
							$ARC_CODEAN=substr($ARC_CODEAN, -12); 
							if(!empty($FL_WM_RQ)){ $ARC_TIPOITM="P"; } else { $ARC_TIPOITM="U";}
							//SL:: CANT/PESO(7,3) unitario=0000000001, pesable=0000001000
							$ARC_QNTITM="0000000000".$QN_ITM;
							$ARC_QNTITM=substr($ARC_QNTITM, -10); 
							//SL:: DESCRIPCION(18) nombre del artículo
							$ARC_NOMITM=$NM_ITM."                                        ";
							$ARC_NOMITM=substr($ARC_NOMITM, 0, 18); 
							//SL:: PRECIO UNIT(6,2)
							if(!empty($FL_WM_RQ)){ 
								$ARC_PRUITM = ($MN_ITM*1000)/$QN_ITM;
							} else { 
								$ARC_PRUITM = $MN_ITM/$QN_ITM;
							}
							$MNT_DEVART=$ARC_PRUITM;
							$ARC_PRUITM="00000000".$ARC_PRUITM;
							$ARC_PRUITM=substr($ARC_PRUITM, -8); 
							//SL:: ENVASE(1)
							$ARC_ENVITM="0";
							//SL:: DEPARTAMENTO(4)
							$SQL="SELECT * FROM ID_DPT_PS WHERE ID_DPT_PS=".$ID_DPT_PS;
							
							//$RS = sqlsrv_query($arts_conn, $SQL);
							////oci_execute($RS);
							$RS = sqlsrv_query($arts_conn,$SQL);

							if ($row = sqlsrv_fetch_array($RS)) {
								$CD_DPT_PS = $row['CD_DPT_PS'];
							}
							$ARC_DPTITM="0000".$CD_DPT_PS;
							$ARC_DPTITM=substr($ARC_DPTITM, -4); 
							//SL:: FAMILIA(6)
							$SQL="SELECT * FROM CO_MRHRC_GP WHERE ID_MRHRC_GP=".$ID_MRHRC_GP;
							
							//$RS = sqlsrv_query($arts_conn, $SQL);
							////oci_execute($RS);
							$RS = sqlsrv_query($arts_conn,$SQL);

							if ($row = sqlsrv_fetch_array($RS)) {
								$CD_MRHRC_GP = $row['CD_MRHRC_GP'];
							}
							$ARC_FAMITM="000000".$CD_MRHRC_GP;
							$ARC_FAMITM=substr($ARC_FAMITM, -6); 
							//SL:: CODIGO TAX APLICADO(1)
							if(empty($TY_TX)){ $ARC_TAXITM="0";} else {$ARC_TAXITM=$TY_TX;}
							//SL:: MONTO TAX APLICADO(1)
							$ARC_MNTTAX="00000000".$TAX_DEV;
							$ARC_MNTTAX=substr($ARC_MNTTAX, -8); 
				
							$ARC_FILLER="0000000000000000";//16
							
							$SL=$SL.$ID_LN1.$ARC_CODEAN.$ARC_TIPOITM.$ARC_QNTITM.$ARC_NOMITM.$ARC_PRUITM.$ARC_ENVITM.$ARC_DPTITM.$ARC_FAMITM.$ARC_TAXITM.$ARC_MNTTAX.$ARC_FILLER."\r\n";
							$CONTADOR=$CONTADOR+1;
							
							$ARC_NUMLNS = $ARC_NUMLNS+1;
						}
				
				//TL:: TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA 
						//OBTENER IMPUESTOS APLICADOS A LA TRX
						$TL="";
						$ID_LN7="07";
						$SQL="SELECT * FROM TR_LTM_TX WHERE ID_TRN=".$ID_TRN;
						//$RS = sqlsrv_query($arts_conn, $SQL);
						////oci_execute($RS);
						$RS = sqlsrv_query($arts_conn,$SQL);
						while ($row = sqlsrv_fetch_array($RS)) {
							$TY_TX = $row['TY_TX'];
							$MO_TX = $row['MO_TX'];
							$MO_TXBL = $row['MO_TXBL'];
							
							$ARC_TYTX = $TY_TX;
							$ARC_MO_TX ="00000000".$MO_TX;
							$ARC_MO_TX=substr($ARC_MO_TX, -8); 
							$ARC_MO_TXBL ="00000000".$MO_TXBL;
							$ARC_MO_TXBL=substr($ARC_MO_TXBL, -8); 
							$ARC_FILLER="00000000000000000000000000000000000000000000000000000000000000000000";//68
				
							$TL=$TL.$ID_LN7.$ARC_TYTX.$ARC_MO_TX.$ARC_MO_TXBL.$ARC_FILLER."\r\n";
				
							$ARC_NUMLNS = $ARC_NUMLNS+1;
						}
						
				//CL:: CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA 
						//MEDIOS DE PAGO
						$CL="";
						$ID_LN5="05";
						$SQL="SELECT * FROM DV_MDPTCK WHERE ID_DEVS=".$ID_DEVS;
						//$RS = sqlsrv_query($conn, $SQL);
						////oci_execute($RS);
						$RS = sqlsrv_query($conn,$SQL);
						
						while ($row = sqlsrv_fetch_array($RS)) {
							$TY_TND = $row['TY_TND'];
							$MO_TND = $row['MONTO'];
							
							$ARC_TY_TND ="0000".$TY_TND;
							$ARC_TY_TND=substr($ARC_TY_TND, -4); 
							$ARC_MO_TND ="00000000".$MO_TND;
							$ARC_MO_TND=substr($ARC_MO_TND, -8); 
							$ARC_COSTUMER="000000000000"; //12
							$ARC_FILLER="0000000000000000000000000000000000000000000000000000000000000";//61
				
							$TL=$TL.$ID_LN5.$ARC_TY_TND.$ARC_MO_TND.$ARC_COSTUMER.$ARC_FILLER."\r\n";
				
							$ARC_NUMLNS = $ARC_NUMLNS+1;
						}
						
				
						$ARC_NUMLNS="0000".$ARC_NUMLNS;
						$ARC_NUMLNS=substr($ARC_NUMLNS, -4); 
						$PL=$ID_LN0.$ARC_TIPOTRX.$ARC_NUMLNS.$ARC_FECHA.$ARC_HORA.$ARC_CD_OPR.$ARC_NM_OPR.$ARC_MNTDEV.$ARC_NUMTRX.$ARC_NUMTRXORG.$ARC_NUMNC.$ARC_FECORG.$ARC_HORORG.$ARC_NUMTIENDA.$ARC_TPOS."\r\n";
						
						//GENERA ARCHIVO FÍSICO	
						 $NOM_ARCHIVO=$ARC_NUMNC.".".$EXT_ARC;
						 $open = fopen("_arc_tmp/".$NOM_ARCHIVO, "w+");
						 fwrite($open, $PL);
						 fwrite($open, $SL);
						 fwrite($open, $TL);
						 fwrite($open, $CL);
						 fclose($open);
				
								$local_file="_arc_tmp/".$NOM_ARCHIVO;
								$NUM_LOCAL="/".$EXT_ARC;
								copy($local_file, $SYNC_IN.$NUM_LOCAL."/trxs/".$NOM_ARCHIVO);
								//ftp_put($conn_id, $server_file, $local_file, FTP_BINARY);
		
		header("Location: reg_devols.php?VDNC=".$ID_DEVS."&MSJE=11");
	}
//FIN CONFIRMA REGISTRO