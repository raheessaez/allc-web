<?php include("session.inc");?>
<?php

$RETEXC=$_GET["RETEXC"];
$ACTVEX=$_GET["ACTVEX"];

if (!empty($RETEXC)) {//QUITAR EXCEPCION
		$ID_ARCPRC=$_GET["ID_ARCPRC"]; //NOMBRE DEL ARCHIVO
		$LINEAEX=$_GET["LINEAEX"]; //LINEA EN ARCHIVO EX
		$LINEALO=$_GET["LINEALO"]; //LINEA EN ARCHIVO LO
		$ACCI_ART=$_GET["ACCI_ART"]; //ACCION... EN QUITAR SIEMPRE REEMPLAZAR CON X
		$PAGINA=$_GET["p"]; //CONSERVA PAGINACION
		$NEGDPT=$_GET["NEGDPT"]; //<>"" VIENE DE NEGOCIO
		
		//OBTENER ARCHIVO LO
		$SQL="SELECT * FROM ARC_PRC WHERE ID_ARCPRC=".$ID_ARCPRC;
		$RS = sqlsrv_query($conn, $SQL);
		//oci_execute($RS);
		if ($row = sqlsrv_fetch_array($RS)) {
			$ARC_LOTE = $row['NOM_ARCLOTE'];
			$ID_ARCSAP = $row['ID_ARCSAP'];
			$ID_ESTPRC = $row['ID_ESTPRC'];
			$COD_NEGOCIO = $row['COD_NEGOCIO'];
		}
		/*
		$SQL="SELECT * FROM ARC_SAP WHERE ID_ARCSAP=".$ID_ARCSAP;
		$RS = sqlsrv_query($conn, $SQL);
		//oci_execute($RS);
		if ($row = sqlsrv_fetch_array($RS)) {
			$LOTE = $row['NUM_LOTE'];
			$TND = $row['COD_TIENDA'];
		}
		$DIRLOCAL="_arc_tmp/".substr("000".$TND, -3)."_".substr("0000".$LOTE, -4)."/";
		*/
		if($ID_ESTPRC>7){$DIR_LOTE="/BKP/";}
		if($ID_ESTPRC==7){$DIR_LOTE="/PRC/";}
		if($ID_ESTPRC<7){$DIR_LOTE="/IN/";}
		if($ID_ESTPRC==3){$DIR_LOTE="/BKP/";}
		$DIRLOCAL=$DIR_SAP.$DIR_LOTE;

		//OBTENER ARCHIVO EX
			$SQL="SELECT * FROM ARC_PRCEX WHERE ID_ARCPRC=".$ID_ARCPRC;
			$RS = sqlsrv_query($conn, $SQL);
			//oci_execute($RS);
			if ($row = sqlsrv_fetch_array($RS)) {
				$ARC_EXCEP = $row['NOM_ARCEX'];
			}
		
		//OBTENER ARCHIVOS
		$ARCHIVO_EX=$DIRLOCAL.$ARC_EXCEP;
		$ARCHIVO_LO=$DIRLOCAL.$ARC_LOTE;
		
		//MODIFICAR LINEA ARCHIVO EX
						$aExcep = fopen($ARCHIVO_EX,'r+');
						$LinExcep = fread($aExcep,filesize($ARCHIVO_EX));
						fclose($aExcep);
						//SEPARAR LINEAS
						$LinExcep = explode("\n",$LinExcep);
						//POSICION
						$PosExcep = $LINEAEX-1;
						//OBTENER y MODIFICAR LINEA
						$LinExcep[$PosExcep] =  trim($LinExcep[$PosExcep])."N";
						//UNIR LINEAS
						$LinExcep = implode("\n",$LinExcep);
						//GUARDAR
						$aExcep = fopen($ARCHIVO_EX,'w');
						fwrite($aExcep,$LinExcep);
						fclose($aExcep);					

		//MODIFICAR LINEA ARCHIVO LO
						$aArcLote = fopen($ARCHIVO_LO,'r+');
						$LinArcLote = fread($aArcLote,filesize($ARCHIVO_LO));
						fclose($aArcLote);
						//SEPARAR LINEAS
						$LinArcLote = explode("\n",$LinArcLote);
						//POSICION
						$PosArcLote = $LINEALO-1;
						//OBTENER y MODIFICAR LINEA, REEMPLAZAR PRIMER CARACTER CON X
						$NewLine = "X".substr(trim($LinArcLote[$PosArcLote]), 1, 262);
						$LineaEnRegistro = trim($LinArcLote[$PosArcLote]);
						$LinArcLote[$PosArcLote] = $NewLine;
						//UNIR LINEAS
						$LinArcLote = implode("\n",$LinArcLote);
						//GUARDAR
						$aArcLote = fopen($ARCHIVO_LO,'w');
						fwrite($aArcLote,$LinArcLote);
						fclose($aArcLote);
		
		//REGISTRAR DECISION		
		$SQL="INSERT INTO ARC_EXPRC (ID_ARCPRC, NUM_LINLO, NUM_LINEX, EXCEPCION, DECIDE, IDREG) VALUES ";
		$SQL=$SQL." (".$ID_ARCPRC.", '".$LINEALO."', ".$LINEAEX.", '".$ACCI_ART."', 'N', ".$SESIDUSU.")";
		$RS = sqlsrv_query($conn, $SQL);
		//oci_execute($RS);
		
		//VERIFICAR SI SE HAN PROCESADO EL 100% DE LAS LINEAS
		//DE SER EL 100% -> ENTONCES CAMBIAR ID_ESTPRC=2
		$SQL1="SELECT NUM_ITEMS FROM ARC_PRCEX WHERE ID_ARCPRC=".$ID_ARCPRC;
		$RS1 = sqlsrv_query($conn, $SQL1);
		//oci_execute($RS1);
		if ($row1 = sqlsrv_fetch_array($RS1)) {
			$NUM_ITEMS = $row1['NUM_ITEMS'];
		}
		$SQL2="SELECT COUNT(ID_ARCPRC) AS NUM_PROCS FROM ARC_EXPRC WHERE ID_ARCPRC=".$ID_ARCPRC;
		$RS2 = sqlsrv_query($conn, $SQL2);
		//oci_execute($RS2);
		if ($row2 = sqlsrv_fetch_array($RS2)) {
			$NUM_PROCS = $row2['NUM_PROCS'];
		}
		if((int)($NUM_ITEMS)==(int)($NUM_PROCS)){
			//CAMBIAR ESTADO
			$SQL="UPDATE ARC_PRC SET ID_ESTPRC=2 WHERE ID_ARCPRC=".$ID_ARCPRC;
			$RS = sqlsrv_query($conn, $SQL);
			//oci_execute($RS);
			$SQLOG="INSERT INTO ARC_MOV (ID_ARCPRC, ID_ESTPRC, FEC_MOV, HOR_MOV, IDREG) VALUES ";
			$SQLOG=$SQLOG."(".$ID_ARCPRC.", 2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', ".$SESIDUSU.")";
			$RSL = sqlsrv_query($conn, $SQLOG);
			//oci_execute($RSL);																	
		}
		
		if(empty($NEGDPT)){
				header("Location: reg_precios.php?EXCEP=".$ID_ARCPRC."&LOTART=".$ID_ARCSAP."&LDN=".$COD_NEGOCIO."&MSJE=1&p=".$PAGINA);
		} else {
				header("Location: reg_precios.php?EXCEPNEG=".$ID_ARCSAP."&LDN=".$COD_NEGOCIO."&MSJE=1&p=".$PAGINA);
		}
		sqlsrv_close($conn);
}







//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
if (!empty($ACTVEX))  {//MANTENER EXCEPCION
		$ID_ARCPRC=$_GET["ID_ARCPRC"]; //NOMBRE DEL ARCHIVO
		$LINEAEX=$_GET["LINEAEX"]; //LINEA EN ARCHIVO EX
		$LINEALO=$_GET["LINEALO"]; //LINEA EN ARCHIVO LO
		$ACCI_ART=$_GET["ACCI_ART"]; //ACCION... EN ACTIVAR SIEMPRE REEMPLAZAR SI ES A: REEMPLAZAR CON U, SI ES U: REEMPLAZAR CON A
		$PAGINA=$_GET["p"]; //CONSERVA PAGINACION
		$NEGDPT=$_GET["NEGDPT"]; //<>"" VIENE DE NEGOCIO

		//OBTENER ARCHIVO LO
		$SQL="SELECT * FROM ARC_PRC WHERE ID_ARCPRC=".$ID_ARCPRC;
		$RS = sqlsrv_query($conn, $SQL);
		//oci_execute($RS);
		if ($row = sqlsrv_fetch_array($RS)) {
			$ARC_LOTE = $row['NOM_ARCLOTE'];
			$ID_ARCSAP = $row['ID_ARCSAP'];
			$ID_ESTPRC = $row['ID_ESTPRC'];
			$COD_NEGOCIO = $row['COD_NEGOCIO'];
		}
		/*
		$SQL="SELECT * FROM ARC_SAP WHERE ID_ARCSAP=".$ID_ARCSAP;
		$RS = sqlsrv_query($conn, $SQL);
		//oci_execute($RS);
		if ($row = sqlsrv_fetch_array($RS)) {
			$LOTE = $row['NUM_LOTE'];
			$TND = $row['COD_TIENDA'];
		}
		
		$DIRLOCAL="_arc_tmp/".substr("000".$TND, -3)."_".substr("0000".$LOTE, -4)."/";
		*/
		if($ID_ESTPRC>7){$DIR_LOTE="/BKP/";}
		if($ID_ESTPRC==7){$DIR_LOTE="/PRC/";}
		if($ID_ESTPRC<7){$DIR_LOTE="/IN/";}
		if($ID_ESTPRC==3){$DIR_LOTE="/BKP/";}
		$DIRLOCAL=$DIR_SAP.$DIR_LOTE;

		//OBTENER ARCHIVO EX
			$SQL="SELECT * FROM ARC_PRCEX WHERE ID_ARCPRC=".$ID_ARCPRC;
			$RS = sqlsrv_query($conn, $SQL);
			//oci_execute($RS);
			if ($row = sqlsrv_fetch_array($RS)) {
				$ARC_EXCEP = $row['NOM_ARCEX'];
			}

		//OBTENER ARCHIVOS
		$ARCHIVO_EX=$DIRLOCAL.$ARC_EXCEP;
		$ARCHIVO_LO=$DIRLOCAL.$ARC_LOTE;
		
		//MODIFICAR LINEA ARCHIVO EX
				$aArcExcep = fopen($ARCHIVO_EX,'r+');
				$LinExcep = fread($aArcExcep,filesize($ARCHIVO_EX));
				fclose($aArcExcep);
				//SEPARAR LINEAS
				$LinExcep = explode("\n",$LinExcep);
				//POSICION
				$PosExcep = $LINEAEX-1;
				//OBTENER y MODIFICAR LINEA
				$LinExcep[$PosExcep] =  trim($LinExcep[$PosExcep])."S";
				//UNIR LINEAS
				$LinExcep = implode("\n",$LinExcep);
				//GUARDAR
				$aExcep = fopen($ARCHIVO_EX,'w');
				fwrite($aExcep,$LinExcep);
				fclose($aExcep);					
		
		//MODIFICAR LINEA ARCHIVO LO
				$aArcLote = fopen($ARCHIVO_LO,'r+');
				$LinArcLote = fread($aArcLote,filesize($ARCHIVO_LO));
				fclose($aArcLote);
				//SEPARAR LINEAS
				$LinArcLote = explode("\n",$LinArcLote);
				//POSICION
				$PosArcLote = $LINEALO-1;
				//OBTENER y MODIFICAR LINEA
				//REEMPLAZAR SI ES A: REEMPLAZAR CON U, SI ES U: REEMPLAZAR CON A
				if($ACCI_ART=="A"){$LAACCION="U";}
				if($ACCI_ART=="U"){$LAACCION="A";}
				$NewLine = $LAACCION.substr(trim($LinArcLote[$PosArcLote]), 1, 262);
				$LineaEnRegistro = trim($LinArcLote[$PosArcLote]);
				$LinArcLote[$PosArcLote] = $NewLine;
				//UNIR LINEAS
				$LinArcLote = implode("\n",$LinArcLote);
				//GUARDAR
				$aArcLote = fopen($ARCHIVO_LO,'w');
				fwrite($aArcLote,$LinArcLote);
				fclose($aArcLote);
		
		//REGISTRAR DECISION		
		$SQL="INSERT INTO ARC_EXPRC (ID_ARCPRC, NUM_LINLO, NUM_LINEX, EXCEPCION, DECIDE, IDREG) VALUES ";
		$SQL=$SQL." (".$ID_ARCPRC.", '".$LINEALO."', ".$LINEAEX.", '".$LAACCION."', 'S', ".$SESIDUSU.")";
		$RS = sqlsrv_query($conn, $SQL);
		//oci_execute($RS);

		//VERIFICAR SI SE HAN PROCESADO EL 100% DE LAS LINEAS
		//DE SER EL 100% -> ENTONCES CAMBIAR ID_ESTPRC=2
		$SQL1="SELECT NUM_ITEMS FROM ARC_PRCEX WHERE ID_ARCPRC=".$ID_ARCPRC;
		$RS1 = sqlsrv_query($conn, $SQL1);
		//oci_execute($RS1);
		if ($row1 = sqlsrv_fetch_array($RS1)) {
			$NUM_ITEMS = $row1['NUM_ITEMS'];
		}
		$SQL2="SELECT COUNT(ID_ARCPRC) AS NUM_PROCS FROM ARC_EXPRC WHERE ID_ARCPRC=".$ID_ARCPRC;
		$RS2 = sqlsrv_query($conn, $SQL2);
		//oci_execute($RS2);
		if ($row2 = sqlsrv_fetch_array($RS2)) {
			$NUM_PROCS = $row2['NUM_PROCS'];
		}
		if((int)($NUM_ITEMS)==(int)($NUM_PROCS)){
			//CAMBIAR ESTADO
			$SQL="UPDATE ARC_PRC SET ID_ESTPRC=2 WHERE ID_ARCPRC=".$ID_ARCPRC;
			$RS = sqlsrv_query($conn, $SQL);
			//oci_execute($RS);
			$SQLOG="INSERT INTO ARC_MOV (ID_ARCPRC, ID_ESTPRC, FEC_MOV, HOR_MOV, IDREG) VALUES ";
			$SQLOG=$SQLOG."(".$ID_ARCPRC.", 2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', ".$SESIDUSU.")";
			$RSL = sqlsrv_query($conn, $SQLOG);
			//oci_execute($RSL);																	
		}

		if(empty($NEGDPT)){
				header("Location: reg_precios.php?EXCEP=".$ID_ARCPRC."&LOTART=".$ID_ARCSAP."&LDN=".$COD_NEGOCIO."&MSJE=2&p=".$PAGINA);
		} else {
				header("Location: reg_precios.php?EXCEPNEG=".$ID_ARCSAP."&LDN=".$COD_NEGOCIO."&MSJE=2&p=".$PAGINA);
		}
		sqlsrv_close($conn);
}







//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
$RECHAZAR=$_POST["RECHAZAR"];
$ACEPTAR=$_POST["ACEPTAR"];

if ($RECHAZAR<>"") { //RECHAZAR LOTE
		$ID_ARCPRC=$_POST["ID_ARCPRC"];
		//OBTENER NOMBRE DE ARCHIVO DE LOTE, ARCHIVO DE EXCEPCION E ID_ARCSAP
		$SQL="SELECT * FROM ARC_PRC WHERE ID_ARCPRC=".$ID_ARCPRC;
		$RS = sqlsrv_query($conn, $SQL);
		//oci_execute($RS);
		if ($row = sqlsrv_fetch_array($RS)){
			$NOM_ARCLOTE = $row['NOM_ARCLOTE'];
			$ID_ARCSAP = $row['ID_ARCSAP'];
			$COD_NEGOCIO = $row['COD_NEGOCIO'];
		}
		$SQL="SELECT * FROM ARC_SAP WHERE ID_ARCSAP=".$ID_ARCSAP;
		$RS = sqlsrv_query($conn, $SQL);
		//oci_execute($RS);
		if ($row = sqlsrv_fetch_array($RS)){
			$LOTE = $row['NUM_LOTE'];
			$TND = $row['COD_TIENDA'];
		}
		$LOTE = substr("0000".$LOTE, -4);
		$TND =substr("000".$TND, -3) ;

		
		//ACTUALIZAR ID_ESTPRC=3 DEL LOTE
		$SQL="UPDATE ARC_PRC SET ID_ESTPRC=3 WHERE ID_ARCPRC=".$ID_ARCPRC;
		$RS = sqlsrv_query($conn, $SQL);
		//oci_execute($RS);
		$SQLOG="INSERT INTO ARC_MOV (ID_ARCPRC, ID_ESTPRC, FEC_MOV, HOR_MOV, IDREG) VALUES ";
		$SQLOG=$SQLOG."(".$ID_ARCPRC.", 3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', ".$SESIDUSU.")";
		$RSL = sqlsrv_query($conn, $SQLOG);
		//oci_execute($RSL);																	

		//RETIRAR ARCHIVOS LO, PE, EX
				//OBTENER SUB-LOTE
				$SUBLOTE = substr($NOM_ARCLOTE, 2, 7);
				$ARCLO = "LO".$SUBLOTE.".".$TND;
				$ARCPE = "PE".$SUBLOTE.".".$TND;
				$ARCEX = "EX".$SUBLOTE.".".$TND;
				//$DIRLOCAL="_arc_tmp/".$TND."_".$LOTE."/";
				$DIRLOCAL=$DIR_SAP."/IN/";
				
				//TRASLADA DE IN A BKP
				copy($DIR_SAP."/IN/".$ARCLO, $DIR_SAP."/BKP/".$ARCLO);
				copy($DIR_SAP."/IN/".$ARCPE, $DIR_SAP."/BKP/".$ARCPE);
				copy($DIR_SAP."/IN/".$ARCEX, $DIR_SAP."/BKP/".$ARCEX);
				//QUITAR ARCHIVOS DE IN
				unlink($DIR_SAP."/IN/".$ARCLO);
				unlink($DIR_SAP."/IN/".$ARCPE);
				unlink($DIR_SAP."/IN/".$ARCEX);
				/*
					ftp_put($conn_id, $APSAP_BKP.$ARCLO, $DIRLOCAL.$ARCLO, FTP_BINARY); //LO
					ftp_put($conn_id, $APSAP_BKP.$ARCPE, $DIRLOCAL.$ARCPE, FTP_BINARY); //PE
					ftp_put($conn_id, $APSAP_BKP.$ARCEX, $DIRLOCAL.$ARCEX, FTP_BINARY); //EX
					//QUITAR ARCHIVOS DE DIR_IN
					ftp_delete($conn_id, $APSAP_IN.$ARCLO);
					ftp_delete($conn_id, $APSAP_IN.$ARCPE);
					ftp_delete($conn_id, $APSAP_IN.$ARCEX);
				*/
		
		//VERIFICAR SI TODOS LOS LOTES ASOCIADOS A ID_ARCSAP ESTAN RECHAZADOS (CAMBIAR ID_ESTPRC DE ID_ARCSAP)
		$CTA_MINEST = 0;
		$SQLME="SELECT COUNT(ID_ARCPRC) AS CTA_MINEST FROM ARC_PRC WHERE ID_ARCSAP = ".$ID_ARCSAP." AND ID_ESTPRC != 3";
		$RSME = sqlsrv_query($conn, $SQLME);
		//oci_execute($RSME);
		if ($rowME = sqlsrv_fetch_array($RSME)){
			$CTA_MINEST = $rowME['CTA_MINEST'];
		}
		//SI $CTA_MINEST = 0, ENTONCES EL ARCHIVO SAP ESTÁ RECHAZADO
		if($CTA_MINEST==0){
				$SQLME="UPDATE ARC_SAP SET ID_ESTPRC=3 WHERE ID_ARCSAP=".$ID_ARCSAP;
				$RSME = sqlsrv_query($conn, $SQLME);
				//oci_execute($RSME);
				//TRASLADAR ARCHIVOS ITEM A BKP
							//ENVIAR ITEM Y CIA A BKP							
							$ARCITEM="ITEM".$LOTE.".".$TND;
							$ARCEAN="EAN".$LOTE.".".$TND;
							$ARCERRI="ERRI".$LOTE.".".$TND;
							$ARCERRE="ERRE".$LOTE.".".$TND;
							//TRASLADA DE IN A BKP
							copy($DIR_SAP."/IN/".$ARCITEM, $DIR_SAP."/BKP/".$ARCITEM);
							copy($DIR_SAP."/IN/".$ARCEAN, $DIR_SAP."/BKP/".$ARCEAN);
							copy($DIR_SAP."/IN/".$ARCERRI, $DIR_SAP."/BKP/".$ARCERRI);
							copy($DIR_SAP."/IN/".$ARCERRE, $DIR_SAP."/BKP/".$ARCERRE);
							//QUITAR ARCHIVOS DE IN
							unlink($DIR_SAP."/IN/".$ARCITEM);
							unlink($DIR_SAP."/IN/".$ARCEAN);
							unlink($DIR_SAP."/IN/".$ARCERRI);
							unlink($DIR_SAP."/IN/".$ARCERRE);
							/*
								//TRASLADA ARCHIVOS DE LOCAL A BKP
								ftp_put($conn_id, $APSAP_BKP.$ARCITEM, $DIRLOCAL.$ARCITEM, FTP_BINARY); //ITEM
								ftp_put($conn_id, $APSAP_BKP.$ARCEAN, $DIRLOCAL.$ARCEAN, FTP_BINARY); //EAN
								ftp_put($conn_id, $APSAP_BKP.$ARCERRI, $DIRLOCAL.$ARCERRI, FTP_BINARY); //ERRI
								ftp_put($conn_id, $APSAP_BKP.$ARCERRE, $DIRLOCAL.$ARCERRE, FTP_BINARY); //ERRE
								//QUITAR ARCHIVOS DE IN 
								ftp_delete($conn_id, $APSAP_IN.$ARCITEM);
								ftp_delete($conn_id, $APSAP_IN.$ARCEAN);
								ftp_delete($conn_id, $APSAP_IN.$ARCERRI);
								ftp_delete($conn_id, $APSAP_IN.$ARCERRE);
								//QUITAR ARCHIVOS DE LOCAL
								unlink($DIRLOCAL.$ARCITEM);
								unlink($DIRLOCAL.$ARCEAN);
								unlink($DIRLOCAL.$ARCERRI);
								unlink($DIRLOCAL.$ARCERRE);
							*/
		
		}//$CTA_MINEST==0
		
		header("Location: reg_precios.php?LOTE=".$ID_ARCSAP."&LDN=".$COD_NEGOCIO."&MSJE=3");
		sqlsrv_close($conn);

}







//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
if ($ACEPTAR<>"") { //ACEPTAR LOTE
		$ID_ARCPRC=$_POST["ID_ARCPRC"];
				$SQL="SELECT * FROM ARC_PRC WHERE ID_ARCPRC=".$ID_ARCPRC;
				$RS = sqlsrv_query($conn, $SQL);
				//oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)){
					$ID_ARCSAP = $row['ID_ARCSAP'];
					$COD_TIENDA = $row['COD_TIENDA'];
					$COD_NEGOCIO = $row['COD_NEGOCIO'];
					$NOM_ARCLOTE = $row['NOM_ARCLOTE'];
					$ID_ESTPRC = $row['ID_ESTPRC'];
				}
				$SQL="SELECT * FROM ARC_SAP WHERE ID_ARCSAP=".$ID_ARCSAP;
				$RS = sqlsrv_query($conn, $SQL);
				//oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)){
					$NUM_LOTE = $row['NUM_LOTE'];
				}
				//VERIFICAR SI GENERA FLEJES				
				//CALCULO A-U-D
				$CANT_ADD=0;
				$CANT_UPD=0;
				$CANT_DEL=0;
				//$DIRLOCALCTA="_arc_tmp/".substr("000".$COD_TIENDA, -3)."_".substr("0000".$NUM_LOTE, -4)."/";
				if($ID_ESTPRC>7){$DIR_LOTE="/BKP/";}
				if($ID_ESTPRC==7){$DIR_LOTE="/PRC/";}
				if($ID_ESTPRC<7){$DIR_LOTE="/IN/";}
				if($ID_ESTPRC==3){$DIR_LOTE="/BKP/";}
				$DIRLOCALCTA=$DIR_SAP.$DIR_LOTE;
				//CAPTURAR
				$CapturaLinea=file_get_contents($DIRLOCALCTA.$NOM_ARCLOTE);
				//ARREGLO DE CAPTURA
				$aCaptLinea = array_values(array_filter(explode("\n",$CapturaLinea)));
				//OBTENER CUENTAS DESDE ARREGLO
				foreach ($aCaptLinea as &$LineaDeCuenta) {
					$Accion=substr($LineaDeCuenta, 0, 1);
					if($Accion=="A"){$CANT_ADD=$CANT_ADD+1;}
					if($Accion=="U"){$CANT_UPD=$CANT_UPD+1;}
					if($Accion=="D"){$CANT_DEL=$CANT_DEL+1;}
				}				

				//PROCESAR SEGUN A+U
				$VERIFICA=$CANT_ADD+$CANT_UPD;
				//SI ADD+UPD=0 ENTONCES ACTIVA PRECIOS (6) NO IMPRIME FLEJES SÓLO RETIRA ARTÍCULOS DESDE MAESTRO
				if($VERIFICA==0){
						$SQL="UPDATE ARC_PRC SET ID_ESTPRC=5 WHERE ID_ARCPRC=".$ID_ARCPRC;
						$RS = sqlsrv_query($conn, $SQL);
						//oci_execute($RS);
						$SQLOG="INSERT INTO ARC_MOV (ID_ARCPRC, ID_ESTPRC, FEC_MOV, HOR_MOV, IDREG) VALUES ";
						$SQLOG=$SQLOG."(".$ID_ARCPRC.", 6, convert(datetime,GETDATE(), 121), '".$TIMESRV."', ".$SESIDUSU.")";
						$RSL = sqlsrv_query($conn, $SQLOG);
						//oci_execute($RSL);																	
				} else {
				//SI NO GENERA COMANDA (4)
						$SQL="UPDATE ARC_PRC SET ID_ESTPRC=4 WHERE ID_ARCPRC=".$ID_ARCPRC;
						$RS = sqlsrv_query($conn, $SQL);
						//oci_execute($RS);
						$SQLOG="INSERT INTO ARC_MOV (ID_ARCPRC, ID_ESTPRC, FEC_MOV, HOR_MOV, IDREG) VALUES ";
						$SQLOG=$SQLOG."(".$ID_ARCPRC.", 4, convert(datetime,GETDATE(), 121), '".$TIMESRV."', ".$SESIDUSU.")";
						$RSL = sqlsrv_query($conn, $SQLOG);
						//oci_execute($RSL);																	
				}

				//VERIFICAR SI TODOS LOS LOTES ASOCIADOS A ID_ARCSAP ESTAN EN 4 Ó MAS (CAMBIAR ID_ESTPRC DE ID_ARCSAP) Y QUE NO EXISTAN EXCEPCIONES
				$MIN_IDEST = 0;
				$SQLME="SELECT MIN(ID_ESTPRC) AS MIN_IDEST FROM ARC_PRC WHERE ID_ARCSAP = ".$ID_ARCSAP." AND ID_ESTPRC != 3";
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
				$SQLME="UPDATE ARC_SAP SET PRC_ND='D' WHERE ID_ARCSAP=".$ID_ARCSAP;
				$RSME = sqlsrv_query($conn, $SQLME);
				//oci_execute($RSME);
		header("Location: reg_precios.php?LOTE=".$ID_ARCSAP."&LDN=".$COD_NEGOCIO."&MSJE=4");
		sqlsrv_close($conn);
}







//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
$RECHAZA_LDN=$_GET["RECHAZA_LDN"];

if ($RECHAZA_LDN<>"") { //RECHAZAR LINEA DE NEGOCIO
		$ID_ARCSAP=$_GET["ID_ARCSAP"];
		$COD_NEGOCIO=$_GET["COD_NEGOCIO"];
		$ND=$_GET["ND"];
		
		//OBTENER ARCHIVOS DE LOTE VIA ID_ARCSAP
		$SQLR="SELECT * FROM ARC_PRC WHERE ID_ARCSAP=".$ID_ARCSAP." AND COD_NEGOCIO=".$COD_NEGOCIO;
		$RSR = sqlsrv_query($conn, $SQLR);
		//oci_execute($RSR);
		while ($rowR = sqlsrv_fetch_array($RSR)){
			$ID_ARCPRC = $rowR['ID_ARCPRC'];
							//OBTENER NOMBRE DE ARCHIVO DE LOTE, ARCHIVO DE EXCEPCION E ID_ARCSAP
							$SQL="SELECT * FROM ARC_PRC WHERE ID_ARCPRC=".$ID_ARCPRC;
							$RS = sqlsrv_query($conn, $SQL);
							//oci_execute($RS);
							if ($row = sqlsrv_fetch_array($RS)){
								$NOM_ARCLOTE = $row['NOM_ARCLOTE'];
							}
							$SQL="SELECT * FROM ARC_SAP WHERE ID_ARCSAP=".$ID_ARCSAP;
							$RS = sqlsrv_query($conn, $SQL);
							//oci_execute($RS);
							if ($row = sqlsrv_fetch_array($RS)){
								$LOTE = $row['NUM_LOTE'];
								$TND = $row['COD_TIENDA'];
							}
							$LOTE = substr("0000".$LOTE, -4);
							$TND =substr("000".$TND, -3) ;
							
							//ACTUALIZAR ID_ESTPRC=3 DEL LOTE
							$SQL="UPDATE ARC_PRC SET ID_ESTPRC=3 WHERE ID_ARCPRC=".$ID_ARCPRC;
							$RS = sqlsrv_query($conn, $SQL);
							//oci_execute($RS);
							$SQLOG="INSERT INTO ARC_MOV (ID_ARCPRC, ID_ESTPRC, FEC_MOV, HOR_MOV, IDREG) VALUES ";
							$SQLOG=$SQLOG."(".$ID_ARCPRC.", 3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', ".$SESIDUSU.")";
							$RSL = sqlsrv_query($conn, $SQLOG);
							//oci_execute($RSL);																	
					
							//RETIRAR ARCHIVOS LO, PE, EX
									//OBTENER SUB-LOTE
									$SUBLOTE = substr($NOM_ARCLOTE, 2, 7);
									$ARCLO = "LO".$SUBLOTE.".".$TND;
									$ARCPE = "PE".$SUBLOTE.".".$TND;
									$ARCEX = "EX".$SUBLOTE.".".$TND;
									//$DIRLOCAL="_arc_tmp/".$TND."_".$LOTE."/";
									//TRASLADA DE IN A BKP
									copy($DIR_SAP."/IN/".$ARCLO, $DIR_SAP."/BKP/".$ARCLO);
									copy($DIR_SAP."/IN/".$ARCPE, $DIR_SAP."/BKP/".$ARCPE);
									copy($DIR_SAP."/IN/".$ARCEX, $DIR_SAP."/BKP/".$ARCEX);
									//QUITAR ARCHIVOS DE IN
									unlink($DIR_SAP."/IN/".$ARCLO);
									unlink($DIR_SAP."/IN/".$ARCPE);
									unlink($DIR_SAP."/IN/".$ARCEX);
									/*
										//TRASLADA DE LOCAL A BKP
										ftp_put($conn_id, $APSAP_BKP.$ARCLO, $DIRLOCAL.$ARCLO, FTP_BINARY); //LO
										ftp_put($conn_id, $APSAP_BKP.$ARCPE, $DIRLOCAL.$ARCPE, FTP_BINARY); //PE
										ftp_put($conn_id, $APSAP_BKP.$ARCEX, $DIRLOCAL.$ARCEX, FTP_BINARY); //EX
										//QUITAR ARCHIVOS DE DIR_IN
										ftp_delete($conn_id, $APSAP_IN.$ARCLO);
										ftp_delete($conn_id, $APSAP_IN.$ARCPE);
										ftp_delete($conn_id, $APSAP_IN.$ARCEX);
								*/

		}
		
		//VERIFICAR SI TODOS LOS LOTES ASOCIADOS A ID_ARCSAP ESTAN RECHAZADOS (CAMBIAR ID_ESTPRC DE ID_ARCSAP)
		$CTA_MINEST = 0;
		$SQLME="SELECT COUNT(ID_ARCPRC) AS CTA_MINEST FROM ARC_PRC WHERE ID_ARCSAP = ".$ID_ARCSAP." AND ID_ESTPRC != 3";
		$RSME = sqlsrv_query($conn, $SQLME);
		//oci_execute($RSME);
		if ($rowME = sqlsrv_fetch_array($RSME)){
			$CTA_MINEST = $rowME['CTA_MINEST'];
		}
		//SI $CTA_MINEST = 0, ENTONCES EL ARCHIVO SAP ESTÁ RECHAZADO
		if($CTA_MINEST==0){
				$SQLME="UPDATE ARC_SAP SET ID_ESTPRC=3 WHERE ID_ARCSAP=".$ID_ARCSAP;
				$RSME = sqlsrv_query($conn, $SQLME);
				//oci_execute($RSME);
				//TRASLADAR ARCHIVOS ITEM A BKP
							//ENVIAR ITEM Y CIA A BKP							
							$ARCITEM="ITEM".$LOTE.".".$TND;
							$ARCEAN="EAN".$LOTE.".".$TND;
							$ARCERRI="ERRI".$LOTE.".".$TND;
							$ARCERRE="ERRE".$LOTE.".".$TND;
							//TRASLADA DE IN A BKP
							copy($DIR_SAP."/IN/".$ARCITEM, $DIR_SAP."/BKP/".$ARCITEM);
							copy($DIR_SAP."/IN/".$ARCEAN, $DIR_SAP."/BKP/".$ARCEAN);
							copy($DIR_SAP."/IN/".$ARCERRI, $DIR_SAP."/BKP/".$ARCERRI);
							copy($DIR_SAP."/IN/".$ARCERRE, $DIR_SAP."/BKP/".$ARCERRE);
							//QUITAR ARCHIVOS DE IN
							unlink($DIR_SAP."/IN/".$ARCITEM);
							unlink($DIR_SAP."/IN/".$ARCEAN);
							unlink($DIR_SAP."/IN/".$ARCERRI);
							unlink($DIR_SAP."/IN/".$ARCERRE);
							/*
								ftp_put($conn_id, $APSAP_BKP.$ARCITEM, $DIRLOCAL.$ARCITEM, FTP_BINARY); //ITEM
								ftp_put($conn_id, $APSAP_BKP.$ARCEAN, $DIRLOCAL.$ARCEAN, FTP_BINARY); //EAN
								ftp_put($conn_id, $APSAP_BKP.$ARCERRI, $DIRLOCAL.$ARCERRI, FTP_BINARY); //ERRI
								ftp_put($conn_id, $APSAP_BKP.$ARCERRE, $DIRLOCAL.$ARCERRE, FTP_BINARY); //ERRE
								//QUITAR ARCHIVOS DE IN 
								ftp_delete($conn_id, $APSAP_IN.$ARCITEM);
								ftp_delete($conn_id, $APSAP_IN.$ARCEAN);
								ftp_delete($conn_id, $APSAP_IN.$ARCERRI);
								ftp_delete($conn_id, $APSAP_IN.$ARCERRE);
								//QUITAR ARCHIVOS DE LOCAL
								unlink($DIRLOCAL.$ARCITEM);
								unlink($DIRLOCAL.$ARCEAN);
								unlink($DIRLOCAL.$ARCERRI);
								unlink($DIRLOCAL.$ARCERRE);
						*/
		
		}
		
		if($ND==0){
			header("Location: reg_precios.php?VLTE=".$ID_ARCSAP."&MSJE=3");			
		} else {
			header("Location: reg_precios.php?VLTE=".$ID_ARCSAP."&ND=1&MSJE=3");			
		}

}







//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
$ACEPTAR_LDN=$_GET["ACEPTAR_LDN"];

if ($ACEPTAR_LDN<>"") { //ACEPTAR LINEA DE NEGOCIO
		$ID_ARCSAP=$_GET["ID_ARCSAP"];
		$COD_NEGOCIO=$_GET["COD_NEGOCIO"];
		$SQL="SELECT * FROM ARC_SAP WHERE ID_ARCSAP=".$ID_ARCSAP;
		$RS = sqlsrv_query($conn, $SQL);
		//oci_execute($RS);
		if ($row = sqlsrv_fetch_array($RS)){
			$NUM_LOTE = $row['NUM_LOTE'];
			$COD_TIENDA = $row['COD_TIENDA'];
		}
		//CALCULO A-U-D
		$SQLN="SELECT * FROM ARC_PRC WHERE ID_ARCSAP=".$ID_ARCSAP." AND COD_NEGOCIO=".$COD_NEGOCIO;
		$RSN = sqlsrv_query($conn, $SQLN);
		//oci_execute($RSN);
		//DEFINE ARREGLO LOTES
		$aLoteCalc=array();
		$CANT_ADD=0;
		$CANT_UPD=0;
		$CANT_DEL=0;
		while ($rowN = sqlsrv_fetch_array($RSN)) {
			$NMB_LOTE = $rowN['NOM_ARCLOTE'];
			$ID_ESTPRC = $rowN['ID_ESTPRC'];
			//$DIRLOCALCTA="_arc_tmp/".substr("000".$COD_TIENDA, -3)."_".substr("0000".$NUM_LOTE, -4)."/";
			if($ID_ESTPRC>7){$DIR_LOTE="/BKP/";}
			if($ID_ESTPRC==7){$DIR_LOTE="/PRC/";}
			if($ID_ESTPRC<7){$DIR_LOTE="/IN/";}
			if($ID_ESTPRC==3){$DIR_LOTE="/BKP/";}
			$DIRLOCALCTA=$DIR_SAP.$DIR_LOTE;

			//CAPTURAR
			$CapturaLinea=file_get_contents($DIRLOCALCTA.$NMB_LOTE);
			//ARREGLO DE CAPTURA
			$aCaptLinea = array_values(array_filter(explode("\n",$CapturaLinea)));
			//INCREMENTAR
				foreach ($aCaptLinea as &$LineaCaptura) {
					array_push($aLoteCalc, $LineaCaptura);
				}				
		}
		//OBTENER CUENTAS DESDE ARREGLO
		foreach ($aLoteCalc as &$LineaDeCuenta) {
			$Accion=substr($LineaDeCuenta, 0, 1);
			if($Accion=="A"){$CANT_ADD=$CANT_ADD+1;}
			if($Accion=="U"){$CANT_UPD=$CANT_UPD+1;}
			if($Accion=="D"){$CANT_DEL=$CANT_DEL+1;}
		}		
		
		//PROCESAR SEGUN A+U
		$VERIFICA=$CANT_ADD+$CANT_UPD;
		//SI ADD+UPD=0 ENTONCES ACTIVA PRECIOS (6) NO IMPRIME FLEJES SÓLO RETIRA ARTÍCULOS DESDE MAESTRO
		if($VERIFICA==0){
						//OBTENER ARCHIVOS DE LOTE VIA ID_ARCSAP
						$SQLR="SELECT * FROM ARC_PRC WHERE ID_ARCSAP=".$ID_ARCSAP." AND COD_NEGOCIO=".$COD_NEGOCIO;
						$RSR = sqlsrv_query($conn, $SQLR);
						//oci_execute($RSR);
						while ($rowR = sqlsrv_fetch_array($RSR)){
							$ID_ARCPRC = $rowR['ID_ARCPRC'];
								$SQL="UPDATE ARC_PRC SET ID_ESTPRC=6 WHERE ID_ARCPRC=".$ID_ARCPRC;
								$RS = sqlsrv_query($conn, $SQL);
								//oci_execute($RS);
								$SQLOG="INSERT INTO ARC_MOV (ID_ARCPRC, ID_ESTPRC, FEC_MOV, HOR_MOV, IDREG) VALUES ";
								$SQLOG=$SQLOG."(".$ID_ARCPRC.", 6, convert(datetime,GETDATE(), 121), '".$TIMESRV."', ".$SESIDUSU.")";
								$RSL = sqlsrv_query($conn, $SQLOG);
								//oci_execute($RSL);		
						}
		} else {
		//SI NO GENERA COMANDA (4)
						//OBTENER ARCHIVOS DE LOTE VIA ID_ARCSAP
						$SQLR="SELECT * FROM ARC_PRC WHERE ID_ARCSAP=".$ID_ARCSAP." AND COD_NEGOCIO=".$COD_NEGOCIO;
						$RSR = sqlsrv_query($conn, $SQLR);
						//oci_execute($RSR);
						while ($rowR = sqlsrv_fetch_array($RSR)){
							$ID_ARCPRC = $rowR['ID_ARCPRC'];
								$SQL="UPDATE ARC_PRC SET ID_ESTPRC=4 WHERE ID_ARCPRC=".$ID_ARCPRC;
								$RS = sqlsrv_query($conn, $SQL);
								//oci_execute($RS);
								$SQLOG="INSERT INTO ARC_MOV (ID_ARCPRC, ID_ESTPRC, FEC_MOV, HOR_MOV, IDREG) VALUES ";
								$SQLOG=$SQLOG."(".$ID_ARCPRC.", 4, convert(datetime,GETDATE(), 121), '".$TIMESRV."', ".$SESIDUSU.")";
								$RSL = sqlsrv_query($conn, $SQLOG);
								//oci_execute($RSL);		
						}
		}

		//VERIFICAR SI TODOS LOS LOTES ASOCIADOS A ID_ARCSAP ESTAN EN 4 Ó MAS (CAMBIAR ID_ESTPRC DE ID_ARCSAP) Y QUE NO EXISTAN EXCEPCIONES
		$MIN_IDEST = 0;
		$SQLME="SELECT MIN(ID_ESTPRC) AS MIN_IDEST FROM ARC_PRC WHERE ID_ARCSAP = ".$ID_ARCSAP." AND ID_ESTPRC != 3";
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

		$SQLME="UPDATE ARC_SAP SET PRC_ND='N' WHERE ID_ARCSAP=".$ID_ARCSAP;
		$RSME = sqlsrv_query($conn, $SQLME);
		//oci_execute($RSME);

		
		header("Location: reg_precios.php?VLTE=".$ID_ARCSAP."&ND=1&MSJE=4");			
		sqlsrv_close($conn);
}
?>
