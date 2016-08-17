<?php include("session.inc");?>
<?php
			
			
$ELMCOTIZA=$_GET["ELMCOTIZA"];
if ($ELMCOTIZA<>"") {
		$SITM="DELETE FROM IMP_COT WHERE ID_COT=".$ELMCOTIZA;
		$RITM = sqlsrv_query($conn, $SITM);
		//oci_execute($RITM);
		$SITM="DELETE FROM IMP_COTART WHERE ID_COT=".$ELMCOTIZA;
		$RITM = sqlsrv_query($conn, $SITM);
		//oci_execute($RITM);
		$SITM="DELETE FROM IMP_COTARC WHERE ID_COT=".$ELMCOTIZA;
		$RITM = sqlsrv_query($conn, $SITM);
		//oci_execute($RITM);
		$SITM="DELETE FROM IMP_COTIMP WHERE ID_COT=".$ELMCOTIZA;
		$RITM = sqlsrv_query($conn, $SITM);
		//oci_execute($RITM);
		$SITM="DELETE FROM CO_COTCLTE WHERE ID_COT=".$ELMCOTIZA;
		$RITM = sqlsrv_query($conn, $SITM);
		//oci_execute($RITM);
		header("Location: reg_cotiza.php?NEO=1");
}






$REGCOTIZA=$_POST["REGCOTIZA"];
if ($REGCOTIZA<>"") {
		$ID_COT=$_POST["ID_COT"];
		//REGISTRO DE COTIZACION
				$S2="UPDATE IMP_COT SET ESTADO=1 WHERE ID_COT=".$ID_COT;
				$RS2 = sqlsrv_query($conn, $S2);
				//oci_execute($RS2);
			
		//REGISTRO DE CLIENTE
				$TIPOID=@$_POST["TIPOID"];
				$IDENTIFICACION=@$_POST["IDENTIFICACION"];
				$NOMBRE_P1=@$_POST["NOMBRE_P1"];
						$APELLIDO_P=@$_POST["APELLIDO_P"];
						$APELLIDO_M=@$_POST["APELLIDO_M"];
						$GENERO=@$_POST["GENERO"];
						$DIA_NAC=@$_POST["DIA_NAC"];
						$MES_NAC=@$_POST["MES_NAC"];
						$ANO_NAC=@$_POST["ANO_NAC"];
						$FEC_NACIMIENTO=$ANO_NAC."/".$MES_NAC."/".$DIA_NAC;

				$NOMBRE_P2=@$_POST["NOMBRE_P2"];
				$DIRECCION=@$_POST["DIRECCION"];
				$COD_REGION=@$_POST["COD_REGION"];
				$COD_CIUDAD=@$_POST["COD_CIUDAD"];
				$TELEFONO=@$_POST["TELEFONO"];
				$EMAIL=@$_POST["EMAIL"];
						//VERIFICAR IDENTIFICACION CLIENTE
						$CLIENTE_REG=0;
						$SQLCLTE="SELECT * FROM CO_CLIENTE WHERE IDENTIFICACION='".$IDENTIFICACION."'";
						$RSC = sqlsrv_query($conn, $SQLCLTE);
						//oci_execute($RSC);
						if ($rowCLT = sqlsrv_fetch_array($RSC)){
							$COD_CLIENTE = $rowCLT['COD_CLIENTE']; 
							$CLIENTE_REG=1;
						}
					if($CLIENTE_REG==0){
								$S2="SELECT IDENT_CURRENT ('CO_CLIENTE') AS MCOD_CLIENTE";
								$RS2 = sqlsrv_query($conn, $S2);
								//oci_execute($RS2);
								if ($row = sqlsrv_fetch_array($RS2)) {
										$COD_CLIENTE=$row['MCOD_CLIENTE']+1;
									} else {
										$COD_CLIENTE=1;
								}
								if ($TIPOID ==1) {
										$S2="INSERT INTO CO_CLIENTE (TIPOID, IDENTIFICACION, NOMBRE, APELLIDO_P, APELLIDO_M, GENERO, FEC_NACIMIENTO, DIRECCION, COD_REGION, COD_CIUDAD, TELEFONO, EMAIL, ID_REG) ";
										$S2=$S2." VALUES (".$TIPOID.", '".$IDENTIFICACION."', '".$NOMBRE_P1."', '".$APELLIDO_P."', '".$APELLIDO_M."',  '".$GENERO."',convert(datetime,'".$FEC_NACIMIENTO."', 121),  '".$DIRECCION."', ".$COD_REGION.",".$COD_CIUDAD.",  '".$TELEFONO."',  '".$EMAIL."', ".$SESIDUSU.")";
										$RS2 = sqlsrv_query($conn, $S2);
										//oci_execute($RS2);
								}
								if ($TIPOID ==2) {
										$S2="INSERT INTO CO_CLIENTE (TIPOID, IDENTIFICACION, NOMBRE, DIRECCION, COD_REGION, COD_CIUDAD, TELEFONO, EMAIL, ID_REG) ";
										$S2=$S2." VALUES (".$TIPOID.", '".$IDENTIFICACION."', '".$NOMBRE_P2."', '".$DIRECCION."', ".$COD_REGION.", ".$COD_CIUDAD.",  '".$TELEFONO."',  '".$EMAIL."', ".$SESIDUSU.")";
										$RS2 = sqlsrv_query($conn, $S2);
										//oci_execute($RS2);
								}
					}
					$S2="INSERT INTO CO_COTCLTE (ID_COT, COD_CLIENTE) ";
					$S2=$S2." VALUES (".$ID_COT.", ".$COD_CLIENTE.")";
					$RS2 = sqlsrv_query($conn, $S2);
					//oci_execute($RS2);
					//FIN REGISTRO CLIENTE
		header("Location: reg_cotiza.php?ACT=".$ID_COT);
}



$ACTQTNITM=$_POST["ACTQTNITM"];
if ($ACTQTNITM<>"") {
		$ID_COT=$_POST["ID_COT"];
		$ID_COTITM=$_POST["ID_COTITM"];
		$QN_ITM=$_POST["QTN".$ID_COTITM];
		
		$SITM="UPDATE IMP_COTART SET QN_ITM=".$QN_ITM." WHERE ID_COT=".$ID_COT." AND ID_COTITM=".$ID_COTITM;
		$RITM = sqlsrv_query($conn, $SITM);
		//oci_execute($RITM);

		header("Location: reg_cotiza.php?ACT=".$ID_COT);
}


$ELMIDCOTITM=$_POST["ELMIDCOTITM"];
if ($ELMIDCOTITM<>"") {
		$ID_COT=$_POST["ID_COT"];
		$ID_COTITM=$_POST["ID_COTITM"];
		
		$SITM="DELETE FROM IMP_COTART WHERE ID_COT=".$ID_COT." AND ID_COTITM=".$ID_COTITM;
		$RITM = sqlsrv_query($conn, $SITM);
		//oci_execute($RITM);
		
		//VERIFICAR SI HAY RETIRO TOTAL DE ITEMS
		$S2="SELECT COUNT(ID_COTITM) AS CTAITM FROM IMP_COTART WHERE ID_COT=".$ID_COT;
		$RS2 = sqlsrv_query($conn, $S2);
		//oci_execute($RS2);
		if ($row = sqlsrv_fetch_array($RS2)) {
				$CTAITM=$row['CTAITM'];
		}
		
		if($CTAITM<1) {
				$SITM="DELETE FROM IMP_COT WHERE ID_COT=".$ID_COT;
				$RITM = sqlsrv_query($conn, $SITM);
				//oci_execute($RITM);
				$SITM="DELETE FROM IMP_COTART WHERE ID_COT=".$ID_COT;
				$RITM = sqlsrv_query($conn, $SITM);
				//oci_execute($RITM);
				$SITM="DELETE FROM IMP_COTARC WHERE ID_COT=".$ID_COT;
				$RITM = sqlsrv_query($conn, $SITM);
				//oci_execute($RITM);
				$SITM="DELETE FROM IMP_COTIMP WHERE ID_COT=".$ID_COT;
				$RITM = sqlsrv_query($conn, $SITM);
				//oci_execute($RITM);
				$SITM="DELETE FROM CO_COTCLTE WHERE ID_COT=".$ID_COT;
				$RITM = sqlsrv_query($conn, $SITM);
				//oci_execute($RITM);
			
				header("Location: reg_cotiza.php?NEO=1");
		} else {
		
				header("Location: reg_cotiza.php?ACT=".$ID_COT);
		}
}

















































//CONFIRMA REGISTRO
	$TRXSUSPCOT=@$_GET["TRXSUSPCOT"];
	if(!empty($TRXSUSPCOT)){
		$ID_COT=@$_GET["ID_COT"];
		$TOT_COT=@$_GET["TOT_COT"];
		$SQL="UPDATE IMP_COT SET ESTADO=2, FECHA_ACT=convert(datetime,GETDATE(), 121) WHERE ID_COT=".$ID_COT;
		$RS = sqlsrv_query($conn, $SQL);
		//oci_execute($RS);
		$SQL="SELECT * FROM IMP_COT WHERE ID_COT=".$ID_COT;
		$RS = sqlsrv_query($conn, $SQL);
		//oci_execute($RS);
		if ($row = sqlsrv_fetch_array($RS)) {
			$COD_TIENDA = $row['COD_TIENDA'];
			$ID_WS = $row['ID_WS'];
		}
		$SQL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA=".$COD_TIENDA;
		$RS = sqlsrv_query($maestra, $SQL);
		//oci_execute($RS);
		if ($row = sqlsrv_fetch_array($RS)) {
			$DES_CLAVE = $row['DES_CLAVE'];
		}
		$SQL="SELECT * FROM PA_STR_RTL WHERE CD_STR_RT=".$DES_CLAVE;
		$RS = sqlsrv_query($arts_conn, $SQL);
		//oci_execute($RS);
		if ($row = sqlsrv_fetch_array($RS)) {
			$ID_BSN_UN = $row['ID_BSN_UN'];
		}

		
//REGISTRO DE ARCHIVOS: OBTENER DATA REGISTRO DE ARCHIVOS: OBTENER DATA REGISTRO DE ARCHIVOS: OBTENER DATA REGISTRO DE ARCHIVOS: OBTENER DATA REGISTRO DE ARCHIVOS: OBTENER DATA REGISTRO DE ARCHIVOS: OBTENER DATA REGISTRO DE ARCHIVOS: OBTENER DATA REGISTRO DE ARCHIVOS: OBTENER DATA REGISTRO DE ARCHIVOS: OBTENER DATA REGISTRO DE ARCHIVOS: OBTENER DATA REGISTRO DE ARCHIVOS: OBTENER DATA REGISTRO DE ARCHIVOS: OBTENER DATA REGISTRO DE ARCHIVOS: OBTENER DATA 
		$SQL="ALTER SESSION SET nls_date_format='DD-MM-YYYY HH24:MI:SS'";
		$RS = sqlsrv_query($arts_conn, $SQL);
		//oci_execute($RS);

		
//PL:: PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA PRIMERA LÍNEA 
//PL:: ID DE LÍNEA(2.1)
		$ID_LN0="00";
//PL1:: TIPOTRX(1.1)    1= COTIZACION(NAA) | 2= GIFTCARD/EFECTIVO TIPOID=1,2 | 3= NC+CAMBIOCLIENTE TIPOID=3 | 4= RESERVADO(NAA)
		$ID_TIPOD = 1;
		$ARC_TIPOTRX=1;
//PL2:: CANT LINEAS DETALLE(4.2) 
		$ARC_NUMLNS = 0;
//PL3:: FECHA(8.6) YYYYMMDD
		$ARC_FECHA=date("Ymd");
//PL4:: HORA(4.14) HHMM
		$ARC_HORA=date("Hi");
//PL5:: COD OPERADOR ARMS(4.18)
		$SQL="SELECT NOMBRE FROM US_USUARIOS WHERE IDUSU=".$SESIDUSU;
		$RS = sqlsrv_query($maestra, $SQL);
		//oci_execute($RS);
		if ($row = sqlsrv_fetch_array($RS)) {
			$ARC_NOMOPERA = strtoupper($row['NOMBRE']);
		}
		$ARC_CD_OPR="0000".$SESIDUSU;
		$ARC_CD_OPR=substr($ARC_CD_OPR, -4); 
//PL6:: NOM OPERADOR(20.22)
		$ARC_NM_OPR = $ARC_NOMOPERA."                                                            ";
		$ARC_NM_OPR=substr($ARC_NM_OPR, 0, 20); 
//PL7:: IMPORTE TOTAL(6,2.42), OBTENER MONTO COTIZACION
		$ARC_MNTCOT="00000000".$TOT_COT;
		$ARC_MNTCOT=substr($ARC_MNTCOT, -8); 
//PL8:: NUM TRX(4.50) sólo ceros
		$ARC_NUMTRX = "0000";
//PL9:: NUM TRX ORIGEN(4.54) ID del Ticket
		$ARC_NUMTRXORG="0000";
//PL10:: NUM DEVOL(8.58) número Cotizacion
		$ARC_NUMNC="00000000".$ID_COT;
		$ARC_NUMNC=substr($ARC_NUMNC, -8); 
//PL11:: FECHA TRX ORIGEN(8.66) YYYYMMDD
		$ARC_FECORG = date("Ymd") ; 
//PL12:: HORA TRX ORIGEN(4.74) HHMM
		$ARC_HORORG = date("Hi"); 
//PL13:: TIENDA TRX ORIGEN(4.78)
		$ARC_NUMTIENDA="0000".$DES_CLAVE;
		$ARC_NUMTIENDA=substr($ARC_NUMTIENDA, -4);
		$EXT_ARC="000".$DES_CLAVE;
		$EXT_ARC=substr($EXT_ARC, -3);
//PL14:: TERMINAL POS (4.82)
		$SQL="SELECT CD_WS FROM AS_WS WHERE ID_WS=".$ID_WS;
		$RS = sqlsrv_query($arts_conn, $SQL);
		//oci_execute($RS);
		if ($row = sqlsrv_fetch_array($RS)) {
			$ARC_TPOS = $row['CD_WS'];
		}
		$ARC_TPOS="0000".$ARC_TPOS;
		$ARC_TPOS=substr($ARC_TPOS, -4); 



//SL:: SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA SEGUNDA LÍNEA 
		//OBTENER ARTÍCULOS DESDE DV_ARTS
		$SITM="SELECT * FROM IMP_COTART WHERE ID_COT=".$ID_COT." ORDER BY ID_COTITM DESC";
		$RITM = sqlsrv_query($conn, $SITM);
		//oci_execute($RITM);
		$CONTADOR=1;
		$SL="";
		$ID_LN1="01";
		while ($rowITM = sqlsrv_fetch_array($RITM)) {
				$CD_ITM = $rowITM['CD_ITM'];
				$QN_ITM = $rowITM['QN_ITM'];
				//SL:: TIPO ART(1) unitario=U, pesable=P
				$TY_ITM = $rowITM['TY_ITM'];
					//SL:: COD ARTICULO ACE(12)
					$SQL="SELECT * FROM AS_ITM WHERE CD_ITM=".$CD_ITM;
					$RS = sqlsrv_query($arts_conn, $SQL);
					//oci_execute($RS);
					if ($row = sqlsrv_fetch_array($RS)) {
						$ID_ITM = $row['ID_ITM'];
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
					$SQLI="SELECT * FROM AS_ITM_STR WHERE ID_ITM=".$ID_ITM." AND ID_BSN_UN=".$ID_BSN_UN;
					$RSI = sqlsrv_query($arts_conn, $SQLI);
					//oci_execute($RSI);
					if ($rowI = sqlsrv_fetch_array($RSI)) {
						$MN_ITM=$rowI['SLS_PRC'];
					}
					$ARC_PRUITM=$MN_ITM;
					$ARC_PRUITM="00000000".$ARC_PRUITM;
					$ARC_PRUITM=substr($ARC_PRUITM, -8); 
					//SL:: ENVASE(1)
					$ARC_ENVITM="0";
					//SL:: DEPARTAMENTO(4)
					$SQL="SELECT * FROM ID_DPT_PS WHERE ID_DPT_PS=".$ID_DPT_PS;
					$RS = sqlsrv_query($arts_conn, $SQL);
					//oci_execute($RS);
					if ($row = sqlsrv_fetch_array($RS)) {
						$CD_DPT_PS = $row['CD_DPT_PS'];
					}
					$ARC_DPTITM="0000".$CD_DPT_PS;
					$ARC_DPTITM=substr($ARC_DPTITM, -4); 
					//SL:: FAMILIA(6)
					$SQL="SELECT * FROM CO_MRHRC_GP WHERE ID_MRHRC_GP=".$ID_MRHRC_GP;
					$RS = sqlsrv_query($arts_conn, $SQL);
					//oci_execute($RS);
					if ($row = sqlsrv_fetch_array($RS)) {
						$CD_MRHRC_GP = $row['CD_MRHRC_GP'];
					}
					$ARC_FAMITM="000000".$CD_MRHRC_GP;
					$ARC_FAMITM=substr($ARC_FAMITM, -6); 
						//CALCULAR IMPUESTOS AL ITEM DESDE AS_ITM_STR (8 TAX + 8 IVA)
						//VERIFICAR FLAG DE TIENDA PARA IMPUESTO INCLUIDO 
						//CORREGIR LO QUE SIGUE RESPECTO DE LOS IMPUESTOS

					$ARC_TAXITM="0";
					$SQL="SELECT * FROM AS_ITM_STR WHERE ID_ITM=".$ID_ITM." AND ID_BSN_UN=".$ID_BSN_UN;
					$RS = sqlsrv_query($arts_conn, $SQL);
					//oci_execute($RS);
					if ($row = sqlsrv_fetch_array($RS)) {
						$TX_A = $row['TX_A']; //NUMERO DE TAX/IVA DEL 1 AL 8
						$ARC_TAXITM=$TX_A;
					}
					
					
					$IMP_1 = 0;
					$SQL="SELECT * FROM PA_STR_RTL WHERE ID_BSN_UN=".$ID_BSN_UN;
					$RS = sqlsrv_query($arts_conn, $SQL);
					//oci_execute($RS);
					if ($row = sqlsrv_fetch_array($RS)) {
						$MO_TAX=$row['IMP_'.$ARC_TAXITM];
						$INC_PRC=$row['INC_PRC'];
					}
					
					$MO_TAX_DEC=($MO_TAX/100);
					if($INC_PRC == "S") {
								  //PRECIO INCLUYE IMPUESTO
								 $TAX_COTZ= (($MN_ITM*$MO_TAX_DEC)/(100+$MO_TAX_DEC))*$MO_TAX_DEC ;
					} else {
								  //PRECIO NO INCLUYE IMPUESTO
								 $TAX_COTZ= ($MN_ITM*$MO_TAX_DEC)/100 ;
					}

						
				$ARC_MNTTAX="00000000".$TAX_COTZ;
				$ARC_MNTTAX=substr($ARC_MNTTAX, -8); //VALOR DEL IMPUESTO, CALCULAR COMO SE CALCULA EN TRIGGER
	
				$ARC_FILLER="0000000000000000";//16
				
				$SL=$SL.$ID_LN1.$ARC_CODEAN.$ARC_TIPOITM.$ARC_QNTITM.$ARC_NOMITM.$ARC_PRUITM.$ARC_ENVITM.$ARC_DPTITM.$ARC_FAMITM.$ARC_TAXITM.$ARC_MNTTAX.$ARC_FILLER."\r\n";
				$CONTADOR=$CONTADOR+1;
				
				$ARC_NUMLNS = $ARC_NUMLNS+1;
		}

//TL:: TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA TERCERA LÍNEA 
		//OBTENER IMPUESTOS APLICADOS A LA TRX
		$TL="";
		$ID_LN7="07";
		$ARC_TYTX = $TY_TX;
		$ARC_MO_TX ="00000000"; 
		$ARC_MO_TXBL ="00000000"; 
		$ARC_FILLER="000000000000000000000000000000000000000000000000000000000000000000000";//68
		$TL=$TL.$ID_LN7.$ARC_TYTX.$ARC_MO_TX.$ARC_MO_TXBL.$ARC_FILLER."\r\n";
		$ARC_NUMLNS = $ARC_NUMLNS+1;
		
//CL:: CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA CUARTA LÍNEA 
		//MEDIOS DE PAGO
		$CL="";
		$ID_LN5="05";
		$ARC_TY_TND ="0000"; 
		$ARC_MO_TND ="00000000"; 
		$ARC_COSTUMER="000000000000"; //12
		$ARC_FILLER="0000000000000000000000000000000000000000000000000000000000000";//61
		$TL=$TL.$ID_LN5.$ARC_TY_TND.$ARC_MO_TND.$ARC_COSTUMER.$ARC_FILLER."\r\n";
		$ARC_NUMLNS = $ARC_NUMLNS+1;

		$ARC_NUMLNS="0000".$ARC_NUMLNS;
		$ARC_NUMLNS=substr($ARC_NUMLNS, -4); 
		$PL=$ID_LN0.$ARC_TIPOTRX.$ARC_NUMLNS.$ARC_FECHA.$ARC_HORA.$ARC_CD_OPR.$ARC_NM_OPR.$ARC_MNTCOT.$ARC_NUMTRX.$ARC_NUMTRXORG.$ARC_NUMNC.$ARC_FECORG.$ARC_HORORG.$ARC_NUMTIENDA.$ARC_TPOS."\r\n";


		
		//GENERA ARCHIVO FÍSICO	
		 $NOM_ARCHIVO=$ARC_NUMNC.".".$EXT_ARC;
		 		 
		 $open = fopen($SYNC_IN.$EXT_ARC."/trxs/".$NOM_ARCHIVO, "w+");
		 fwrite($open, $PL);
		 fwrite($open, $SL);
		 fwrite($open, $TL);
		 fwrite($open, $CL);
		 fclose($open);

				/*
				$local_file="_arc_tmp/".$NOM_ARCHIVO;
				$server_file = $DIR_EX_FLS_IN.$NOM_ARCHIVO;

				$conn_id = ftp_connect($FTP_SERVER); 
				$login_result = ftp_login($conn_id, $FTP_UNM, $FTP_UPW);
				
				ftp_put($conn_id, $server_file, $local_file, FTP_BINARY);
				ftp_close($conn_id);		
				
				unlink($local_file);		
				*/
		
		
		header("Location: reg_cotiza.php");
	}
//FIN CONFIRMA REGISTRO






?>
