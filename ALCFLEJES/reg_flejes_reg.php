<?php include("session.inc");?>
<?php

$GENARC=$_GET["GENARC"]; //GENERA ARCHIVOS PARA IMPRESION Y SUBE A ESTADO 5
if ($GENARC<>"") {
		$ID_ARCPRC=$_GET["ID_ARCPRC"];
		$LIMITE=$_GET["NUM_FLJ"]; //LIMITE DE IMPRESION
		
		//OBTENER ARCHIVO DE LOTE CAMBIO DE PRECIOS
		$SQLF="SELECT * FROM ARC_PRC WHERE ID_ARCPRC=".$ID_ARCPRC;
		$RSF = sqlsrv_query($conn, $SQLF);
		//oci_execute($RSF);
		if ($rowF = sqlsrv_fetch_array($RSF)) {
			$NMB_LOTE = $rowF['NOM_ARCLOTE'];
			$ID_ARCSAP = $rowF['ID_ARCSAP'];
			$COD_NEGOCIO = $rowF['COD_NEGOCIO'];
			$ID_ESTPRC = $rowF['ID_ESTPRC'];
		}
		//OBTENER DATA DIRECTORIO
		$SQLN="SELECT * FROM ARC_SAP WHERE ID_ARCSAP=".$ID_ARCSAP;
		$RSN = sqlsrv_query($conn, $SQLN);
		//oci_execute($RSN);
		if ($rowN = sqlsrv_fetch_array($RSN)) {
			$COD_TIENDA = $rowN['COD_TIENDA'];
			$NUM_LOTE= $rowN['NUM_LOTE'];
		}
		//CAPTURAR
		//$DIRARCNEG="_arc_tmp/".substr("000".$COD_TIENDA, -3)."_".substr("0000".$NUM_LOTE, -4)."/";
		if($ID_ESTPRC>7){$DIR_LOTE="/BKP/";}
		if($ID_ESTPRC==7){$DIR_LOTE="/PRC/";}
		if($ID_ESTPRC<7){$DIR_LOTE="/IN/";}
		if($ID_ESTPRC==3){$DIR_LOTE="/BKP/";}
		$DIRARCNEG=$DIR_SAP.$DIR_LOTE;
		$CapturaLote=file_get_contents($DIRARCNEG.$NMB_LOTE);
		//ARREGLO DE CAPTURA LOTE
		$aCaptLote = array_values(array_filter(explode("\n",$CapturaLote)));
		//GENERA ARCHIVO DE FLEJES
		$CANT_LINEAS_FILE = count($aCaptLote);

		$CTA_ARC = 1;
		$REGISTRA = 1;
		$AUX=1;
		$SQL="UPDATE ARC_PRC SET ID_ESTPRC=6 WHERE ID_ARCPRC=".$ID_ARCPRC; //DEJA LISTO PARA IMPRIMIR ARCHIVOS DE FLEJES
		$RS = sqlsrv_query($conn, $SQL);
		//oci_execute($RS);
		$SQLOG="INSERT INTO ARC_MOV (ID_ARCPRC, ID_ESTPRC, FEC_MOV, HOR_MOV, IDREG) VALUES ";
		$SQLOG=$SQLOG."(".$ID_ARCPRC.", 5, convert(datetime,GETDATE(), 121), '".$TIMESRV."', ".$SESIDUSU.")";
		$RSL = sqlsrv_query($conn, $SQLOG);
		//oci_execute($RSL);																	

		//VERIFICAR SI TODOS LOS LOTES ASOCIADOS A ID_ARCSAP ESTAN EN 4 Ó MAS (CAMBIAR ID_ESTPRC DE ID_ARCSAP)
		$MIN_IDEST = 0;
		$SQLME="SELECT MIN(ID_ESTPRC) AS MIN_IDEST FROM ARC_PRC WHERE ID_ARCSAP = ".$ID_ARCSAP." AND ID_ESTPRC <> 3";
		$RSME = sqlsrv_query($conn, $SQLME);
		//oci_execute($RSME);
		if ($rowME = sqlsrv_fetch_array($RSME)){
			$MIN_IDEST = $rowME['MIN_IDEST'];
		}
		if($MIN_IDEST >= 4){
				$SQLME="UPDATE ARC_SAP SET ID_ESTPRC=6 WHERE ID_ARCSAP=".$ID_ARCSAP;
				$RSME = sqlsrv_query($conn, $SQLME);
				//oci_execute($RSME);
		}
		
		header("Location: reg_precios.php?LOTE=".$ID_ARCSAP."&LDN=".$COD_NEGOCIO."&MSJE=5");

}//($GENARC<>"")






//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
$GENARC_LDN=$_GET["GENARC_LDN"]; //GENERA ARCHIVOS PARA IMPRESION Y SUBE A ESTADO 5
if ($GENARC_LDN<>"") {

		$ID_ARCSAP=$_GET["ID_ARCSAP"];
		$COD_NEGOCIO=$_GET["LDN"];
		$ND=$_GET["ND"];
		$LIMITE=$_GET["NUM_FLJ"]; //LIMITE DE IMPRESION
		//OBTENER DATA DIRECTORIO
		$SQLN="SELECT * FROM ARC_SAP WHERE ID_ARCSAP=".$ID_ARCSAP;
		$RSN = sqlsrv_query($conn, $SQLN);
		//oci_execute($RSN);
		if ($rowN = sqlsrv_fetch_array($RSN)) {
			$COD_TIENDA = $rowN['COD_TIENDA'];
			$NUM_LOTE= $rowN['NUM_LOTE'];
		}

		//OBTENER LOTES
		$SQLN="SELECT * FROM ARC_PRC WHERE ID_ARCSAP=".$ID_ARCSAP." AND COD_NEGOCIO=".$COD_NEGOCIO." ORDER BY CD_DPT_PS ASC";
		$RSN = sqlsrv_query($conn, $SQLN);
		//oci_execute($RSN);
		$aCaptLote = array();
		while ($rowN = sqlsrv_fetch_array($RSN)) {
					$ID_ARCPRC = $rowN['ID_ARCPRC'];
					$NMB_LOTE = $rowN['NOM_ARCLOTE'];
					$ID_ESTPRC = $rowN['ID_ESTPRC'];
					//VERIFICAR EL ESTADO DE LOS LOTES (NO PUEDE SER < 4)
					//GENERAR UN ARREGLO CON TODOS LOS ITEMS Y CONVERTIRLO EN ARCHIVO
					if($ID_ESTPRC>=4){
							//CAPTURAR
							//$DIRARCNEG="_arc_tmp/".substr("000".$COD_TIENDA, -3)."_".substr("0000".$NUM_LOTE, -4)."/";
							if($ID_ESTPRC>7){$DIR_LOTE="/BKP/";}
							if($ID_ESTPRC==7){$DIR_LOTE="/PRC/";}
							if($ID_ESTPRC<7){$DIR_LOTE="/IN/";}
							if($ID_ESTPRC==3){$DIR_LOTE="/BKP/";}
							$DIRARCNEG=$DIR_SAP.$DIR_LOTE;
							$CapturaLote=file_get_contents($DIRARCNEG.$NMB_LOTE);
							//ARREGLO DE CAPTURA LOTE
							$aCaptLote = array_values(array_filter(explode("\n",$CapturaLote)));
							//GENERA ARCHIVO DE FLEJES
							$CANT_LINEAS_FILE = count($aCaptLote);
							//LEER ARCHIVO LINEA POR LINEA
							$CTA_ARC = 1;
							$REGISTRA = 1;
							$AUX=1;
							$LN_PRINT="";
							
							
							$SQL="UPDATE ARC_PRC SET ID_ESTPRC=6 WHERE ID_ARCPRC=".$ID_ARCPRC; //DEJA LISTO PARA IMPRIMIR ARCHIVOS DE FLEJES
							$RS = sqlsrv_query($conn, $SQL);
							//oci_execute($RS);
							$SQLOG="INSERT INTO ARC_MOV (ID_ARCPRC, ID_ESTPRC, FEC_MOV, HOR_MOV, IDREG) VALUES ";
							$SQLOG=$SQLOG."(".$ID_ARCPRC.", 5, convert(datetime,GETDATE(), 121), '".$TIMESRV."', ".$SESIDUSU.")";
							$RSL = sqlsrv_query($conn, $SQLOG);
							//oci_execute($RSL);
							$LN_PRINT="";
					}//$ID_ESTPRC>=4
		}//while

		//VERIFICAR SI TODOS LOS LOTES ASOCIADOS A ID_ARCSAP ESTAN EN 4 Ó MAS (CAMBIAR ID_ESTPRC DE ID_ARCSAP)
		$MIN_IDEST = 0;
		$SQLME="SELECT MIN(ID_ESTPRC) AS MIN_IDEST FROM ARC_PRC WHERE ID_ARCSAP = ".$ID_ARCSAP." AND ID_ESTPRC <> 3";
		$RSME = sqlsrv_query($conn, $SQLME);
		//oci_execute($RSME);
		if ($rowME = sqlsrv_fetch_array($RSME)){
			$MIN_IDEST = $rowME['MIN_IDEST'];
		}
		if($MIN_IDEST >= 4){
				$SQLME="UPDATE ARC_SAP SET ID_ESTPRC=".$MIN_IDEST." WHERE ID_ARCSAP=".$ID_ARCSAP;
				$RSME = sqlsrv_query($conn, $SQLME);
				//oci_execute($RSME);
		}
				
		header("Location: reg_precios.php?VLTE=".$ID_ARCSAP."&ND=".$ND."&MSJE=5");

}//($GENARC_LDN<>"")






//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
$PRTFLJ=$_GET["PRTFLJ"];
if ($PRTFLJ<>"") {
		$ID_ARCITEM=$_GET["ID_ARCITEM"];
		$VLTE=$_GET["VLTE"];
		$ND=$_GET["ND"];
		$SQLA="SELECT * FROM ARC_ITEMS WHERE ID_ARCITEM=".$ID_ARCITEM;
		$RSA = sqlsrv_query($conn, $SQLA);
		//oci_execute($RSA);
		if ($rowA = sqlsrv_fetch_array($RSA)) {
				$ID_ARCPRC = $rowA['ID_ARCPRC'];
				$ARCHIVO = $rowA['ARCHIVO'];
		}
		$SQLA="SELECT * FROM ARC_PRC WHERE ID_ARCPRC=".$ID_ARCPRC;
		$RSA = sqlsrv_query($conn, $SQLA);
		//oci_execute($RSA);
		if ($rowA = sqlsrv_fetch_array($RSA)) {
				$ID_ARCSAP = $rowA['ID_ARCSAP'];
				$ID_ESTPRC = $rowA['ID_ESTPRC'];
				$COD_NEGOCIO = $rowA['COD_NEGOCIO'];
		}
		//DESPACHO ARCHIVO A CARPETA DE IMPRESION
				$local_file="_arc_prt/".$ARCHIVO;
				//$server_file = $APRTFLJ_IN.$ARCHIVO;
				copy($local_file, $DIR_FLJ."/IN/".$ARCHIVO);
				//ftp_put($conn_id, $server_file, $local_file, FTP_BINARY);			

		//ACTUALIZO ESTADO
		$SQL="UPDATE ARC_ITEMS SET ESTADO=1 WHERE ID_ARCITEM=".$ID_ARCITEM; //ACTUALIZO ESTADO
		$RS = sqlsrv_query($conn, $SQL);
		//oci_execute($RS);

		//VERIFICO SI HAY MAS IMPRESIONES PENDIENTES
		$SQLA="SELECT COUNT(ID_ARCITEM) AS CTA_PORPRINT FROM ARC_ITEMS WHERE ID_ARCPRC=".$ID_ARCPRC." AND ESTADO=0";
		$RSA = sqlsrv_query($conn, $SQLA);
		//oci_execute($RSA);
		if ($rowA = sqlsrv_fetch_array($RSA)) {
				$CTA_PORPRINT = $rowA['CTA_PORPRINT'];
		}
		if ($PRTFLJ<>2) {
				if($CTA_PORPRINT==0){
					//ACTUALIZO ESTADO ARCPRC SIEMPRE Y CUANDO YA NO SE ENCUENTRE PROCESADO
					if($ID_ESTPRC<6){
								$SQL="UPDATE ARC_PRC SET ID_ESTPRC=6 WHERE ID_ARCPRC=".$ID_ARCPRC; //DEJA LISTO PARA ACTIVACION DE PRECIOS
								$RS = sqlsrv_query($conn, $SQL);
								//oci_execute($RS);
								$SQLOG="INSERT INTO ARC_MOV (ID_ARCPRC, ID_ESTPRC, FEC_MOV, HOR_MOV, IDREG) VALUES ";
								$SQLOG=$SQLOG."(".$ID_ARCPRC.", 6, convert(datetime,GETDATE(), 121), '".$TIMESRV."', ".$SESIDUSU.")";
								$RSL = sqlsrv_query($conn, $SQLOG);
								//oci_execute($RSL);		
					}
					
				}
		}

		//VERIFICAR SI TODOS LOS LOTES ASOCIADOS A ID_ARCSAP ESTAN EN 4 Ó MAS (CAMBIAR ID_ESTPRC DE ID_ARCSAP)
		$MIN_IDEST = 0;
		$SQLME="SELECT MIN(ID_ESTPRC) AS MIN_IDEST FROM ARC_PRC WHERE ID_ARCSAP = ".$ID_ARCSAP." AND ID_ESTPRC <> 3";
		$RSME = sqlsrv_query($conn, $SQLME);
		//oci_execute($RSME);
		if ($rowME = sqlsrv_fetch_array($RSME)){
			$MIN_IDEST = $rowME['MIN_IDEST'];
		}
		if($MIN_IDEST >= 4){
				$SQLME="UPDATE ARC_SAP SET ID_ESTPRC=6 WHERE ID_ARCSAP=".$ID_ARCSAP;
				$RSME = sqlsrv_query($conn, $SQLME);
				//oci_execute($RSME);
		}
				
		if($VLTE<>""){
				header("Location: reg_precios.php?VLTE=".$VLTE."&ND=".$ND."&VNTPRT=".$COD_NEGOCIO);
		} else {
				header("Location: reg_precios.php?LOTE=".$ID_ARCSAP."&LDN=".$COD_NEGOCIO."&VNTPRT=".$ID_ARCPRC);
		}
		
}







//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
$ACTIVAR=$_GET["ACTIVAR_CP"];
if ($ACTIVAR<>"") {
		$ID_ARCPRC=$_GET["ID_ARCPRC"];
		$SQLA="SELECT * FROM ARC_PRC WHERE ID_ARCPRC=".$ID_ARCPRC;
		$RSA = sqlsrv_query($conn, $SQLA);
		//oci_execute($RSA);
		if ($rowA = sqlsrv_fetch_array($RSA)) {
				$NOM_ARCLOTE = $rowA['NOM_ARCLOTE'];
				$ID_ARCSAP = $rowA['ID_ARCSAP'];
				$COD_NEGOCIO = $rowA['COD_NEGOCIO'];
		}
		$SQLA="SELECT * FROM ARC_SAP WHERE ID_ARCSAP=".$ID_ARCSAP;
		$RSA = sqlsrv_query($conn, $SQLA);
		//oci_execute($RSA);
		if ($rowA = sqlsrv_fetch_array($RSA)) {
				$COD_TIENDA = $rowA['COD_TIENDA'];
				$NUM_LOTE = $rowA['NUM_LOTE'];
		}

		$CONSULTA2="UPDATE ARC_PRC SET ID_ESTPRC=7 WHERE ID_ARCPRC=".$ID_ARCPRC;
		$RS2 = sqlsrv_query($conn, $CONSULTA2);
		//oci_execute($RS2);
		$SQLOG="INSERT INTO ARC_MOV (ID_ARCPRC, ID_ESTPRC, FEC_MOV, HOR_MOV, IDREG) VALUES ";
		$SQLOG=$SQLOG."(".$ID_ARCPRC.", 7, convert(datetime,GETDATE(), 121), '".$TIMESRV."', ".$SESIDUSU.")";
		$RSL = sqlsrv_query($conn, $SQLOG);
		//oci_execute($RSL);		

		//DESPACHAR ARCHIVO DE LOxx Y PExx A OUT Y EXxx A BKP
		//$DIRLOCAL="_arc_tmp/".substr("000".$COD_TIENDA, -3)."_".substr("0000".$NUM_LOTE, -4)."/";
		$DIRLOCAL=$DIR_SAP."/IN/";
		$NUM_LOCAL = substr("000".$COD_TIENDA, -3);
				//OBTENER SUB-LOTE
				$SUBLOTE = substr($NOM_ARCLOTE, 2, 7);
				$ARCLO = "LO".$SUBLOTE.".".$NUM_LOCAL;
				$ARCPE = "PE".$SUBLOTE.".".$NUM_LOCAL;
				$ARCEX = "EX".$SUBLOTE.".".$NUM_LOCAL;

				//TRASLADA DE IN A PRC
				copy($DIR_SAP."/IN/".$ARCLO, $DIR_SAP."/PRC/".$ARCLO);
				copy($DIR_SAP."/IN/".$ARCPE, $DIR_SAP."/PRC/".$ARCPE);
				copy($DIR_SAP."/IN/".$ARCEX, $DIR_SAP."/PRC/".$ARCEX);
				//TRASLADA ARCHIVOS A 4690
				copy($DIR_SAP."/IN/".$ARCLO, $SYNC_IN.$NUM_LOCAL."/insap/".$ARCLO);
				copy($DIR_SAP."/IN/".$ARCPE, $SYNC_IN.$NUM_LOCAL."/insap/".$ARCPE);
				//QUITAR ARCHIVOS DE IN
				unlink($DIR_SAP."/IN/".$ARCLO);
				unlink($DIR_SAP."/IN/".$ARCPE);
				unlink($DIR_SAP."/IN/".$ARCEX);

		//VERIFICAR SI NO QUEDAN ARCHIVOS DE LOTE POR PROCESAR (TODOS ENVIADOS AL CONTROLADOR)
		//ESTADOS 7 (PROCESADO) Y 3 (RECHAZADO)
		$CTA_REC = 0;
		$SQLV="SELECT COUNT(ID_ARCPRC) AS CTA_REC FROM ARC_PRC WHERE ID_ARCSAP = ".$ID_ARCSAP." AND (ID_ESTPRC <> 7 AND ID_ESTPRC <> 3)";
		$RSV = sqlsrv_query($conn, $SQLV);
		//oci_execute($RSV);
		if ($rowV = sqlsrv_fetch_array($RSV)){
			$CTA_REC = $rowV['CTA_REC'];
		}
		//SI CTA_REC=0 ENTONCES HAN SIDO TODOS PROCESADOS(7) Y/O RECHAZADOS(3)!
		if($CTA_REC <= 0){
				//ENVIAR ITEM Y CIA A BKP
				$TND = substr("000".$COD_TIENDA, -3);
				$LOTE = substr("0000".$NUM_LOTE, -4);
				
							$ARCITEM="ITEM".$LOTE.".".$TND;
							$ARCEAN="EAN".$LOTE.".".$TND;
							$ARCERRI="ERRI".$LOTE.".".$TND;
							$ARCERRE="ERRE".$LOTE.".".$TND;
							//TRASLADA ARCHIVOS DE IN A BKP
							copy($DIR_SAP."/IN/".$ARCITEM, $DIR_SAP."/BKP/".$ARCITEM);

							copy($DIR_SAP."/IN/".$ARCEAN, $DIR_SAP."/BKP/".$ARCEAN);
							copy($DIR_SAP."/IN/".$ARCERRI, $DIR_SAP."/BKP/".$ARCERRI);
							copy($DIR_SAP."/IN/".$ARCERRE, $DIR_SAP."/BKP/".$ARCERRE);
							//QUITAR ARCHIVOS DE IN
							unlink($DIR_SAP."/IN/".$ARCITEM);
							unlink($DIR_SAP."/IN/".$ARCEAN);
							unlink($DIR_SAP."/IN/".$ARCERRI);
							unlink($DIR_SAP."/IN/".$ARCERRE);
							
							//CAMBIAR ESTADO = 7 EN ARC_SAP
							$SQL7="UPDATE ARC_SAP SET ID_ESTPRC=7 WHERE ID_ARCSAP=".$ID_ARCSAP;
							$RS7 = sqlsrv_query($conn, $SQL7);
							//oci_execute($RS7);
		}
		
		header("Location: reg_precios.php?LOTE=".$ID_ARCSAP."&LDN=".$COD_NEGOCIO."&MSJE=6");

		sqlsrv_close($conn);
}







//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
$ACTIVAR_CPNEG=$_GET["ACTIVAR_CPNEG"];
if ($ACTIVAR_CPNEG<>"") {
			$ID_ARCSAP=$_GET["ID_ARCSAP"];
			$COD_NEGOCIO=$_GET["LDN"];
			$ND=$_GET["ND"];

			$SQLA="SELECT * FROM ARC_SAP WHERE ID_ARCSAP=".$ID_ARCSAP;
			$RSA = sqlsrv_query($conn, $SQLA);
			//oci_execute($RSA);
			if ($rowA = sqlsrv_fetch_array($RSA)) {
					$COD_TIENDA = $rowA['COD_TIENDA'];
					$NUM_LOTE = $rowA['NUM_LOTE'];
			}
			//$DIRLOCAL="_arc_tmp/".substr("000".$COD_TIENDA, -3)."_".substr("0000".$NUM_LOTE, -4)."/";
			$NUM_LOCAL = substr("000".$COD_TIENDA, -3);

			$SQLS="SELECT * FROM ARC_PRC WHERE ID_ARCSAP=".$ID_ARCSAP." AND COD_NEGOCIO=".$COD_NEGOCIO." AND ID_ESTPRC <> 3"; //NO TOMA RECHAZADOS
			$RSS = sqlsrv_query($conn, $SQLS);
			//oci_execute($RSS);
			while ($rowS= sqlsrv_fetch_array($RSS)) {
					$ID_ARCPRC = $rowS['ID_ARCPRC'];
					$NOM_ARCLOTE = $rowS['NOM_ARCLOTE'];
	
							//CAMBIA ESTADO DE REGISTROS
							$SQLA="UPDATE ARC_PRC SET ID_ESTPRC=7 WHERE ID_ARCPRC=".$ID_ARCPRC;
							$RSA = sqlsrv_query($conn, $SQLA);
							//oci_execute($RSA);
							$SQLOG="INSERT INTO ARC_MOV (ID_ARCPRC, ID_ESTPRC, FEC_MOV, HOR_MOV, IDREG) VALUES ";
							$SQLOG=$SQLOG."(".$ID_ARCPRC.", 7, convert(datetime,GETDATE(), 121), '".$TIMESRV."', ".$SESIDUSU.")";
							$RSL = sqlsrv_query($conn, $SQLOG);
							//oci_execute($RSL);		
					
							//DESPACHAR ARCHIVO DE LOxx Y PExx A OUT Y EXxx A BKP
									//OBTENER SUB-LOTE
									$SUBLOTE = substr($NOM_ARCLOTE, 2, 7);
									$ARCLO = "LO".$SUBLOTE.".".$NUM_LOCAL;
									$ARCPE = "PE".$SUBLOTE.".".$NUM_LOCAL;
									$ARCEX = "EX".$SUBLOTE.".".$NUM_LOCAL;

									//TRASLADA DE IN A PRC
									copy($DIR_SAP."/IN/".$ARCLO, $DIR_SAP."/PRC/".$ARCLO);
									copy($DIR_SAP."/IN/".$ARCPE, $DIR_SAP."/PRC/".$ARCPE);
									copy($DIR_SAP."/IN/".$ARCEX, $DIR_SAP."/PRC/".$ARCEX);
									//TRASLADA ARCHIVOS A 4690
									copy($DIR_SAP."/IN/".$ARCLO, $SYNC_IN.$NUM_LOCAL."/insap/".$ARCLO);
									copy($DIR_SAP."/IN/".$ARCPE, $SYNC_IN.$NUM_LOCAL."/insap/".$ARCPE);
									//QUITAR ARCHIVOS DE IN
									unlink($DIR_SAP."/IN/".$ARCLO);
									unlink($DIR_SAP."/IN/".$ARCPE);
									unlink($DIR_SAP."/IN/".$ARCEX);
									
		}//while 

		//VERIFICAR SI NO QUEDAN ARCHIVOS POR PROCESAR (TODOS ENVIADOS AL CONTROLADOR)
		//ESTADOS 7 (PROCESADO) Y 3 (RECHAZADO)
		$CTA_REC = 0;
		$SQLV="SELECT COUNT(ID_ARCPRC) AS CTA_REC FROM ARC_PRC WHERE ID_ARCSAP = ".$ID_ARCSAP." AND (ID_ESTPRC <> 7 AND ID_ESTPRC <> 3)";
		$RSV = sqlsrv_query($conn, $SQLV);
		//oci_execute($RSV);
		if ($rowV = sqlsrv_fetch_array($RSV)){
			$CTA_REC = $rowV['CTA_REC'];
		}
		//SI CTA_REC=0 ENTONCES HAN SIDO TODOS PROCESADOS(7) Y/O RECHAZADOS(3)!
		if($CTA_REC == 0){
					//ENVIAR ITEM Y CIA A BKP
					$TND = substr("000".$COD_TIENDA, -3);
					$LOTE = substr("0000".$NUM_LOTE, -4);
					
					$ARCITEM="ITEM".$LOTE.".".$TND;
					$ARCEAN="EAN".$LOTE.".".$TND;
					$ARCERRI="ERRI".$LOTE.".".$TND;
					$ARCERRE="ERRE".$LOTE.".".$TND;
					//TRASLADA ARCHIVOS DE IN A BKP
					copy($DIR_SAP."/IN/".$ARCITEM, $DIR_SAP."/BKP/".$ARCITEM);
					copy($DIR_SAP."/IN/".$ARCEAN, $DIR_SAP."/BKP/".$ARCEAN);
					copy($DIR_SAP."/IN/".$ARCERRI, $DIR_SAP."/BKP/".$ARCERRI);
					copy($DIR_SAP."/IN/".$ARCERRE, $DIR_SAP."/BKP/".$ARCERRE);
					//QUITAR ARCHIVOS DE LOCAL
					unlink($DIR_SAP."/IN/".$ARCITEM);
					unlink($DIR_SAP."/IN/".$ARCEAN);
					unlink($DIR_SAP."/IN/".$ARCERRI);
					unlink($DIR_SAP."/IN/".$ARCERRE);
			
					//CAMBIAR ESTADO = 7 EN ARC_SAP
					$SQL7="UPDATE ARC_SAP SET ID_ESTPRC=7 WHERE ID_ARCSAP=".$ID_ARCSAP;
					$RS7 = sqlsrv_query($conn, $SQL7);
					//oci_execute($RS7);
		}
		
		header("Location: reg_precios.php?VLTE=".$ID_ARCSAP."&ND=".$ND."&MSJE=6");

		sqlsrv_close($conn);
}
				

?>
