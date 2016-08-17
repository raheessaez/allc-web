<?php include("session.inc");?>
<?php

		//LOS PARAMETROS
					$FTIENDA=@$_GET["FTIENDA"];
					$TOTALRECAUDO=@$_GET["TOTALRECAUDO"];
					$DIA_ED=@$_GET["DIA_ED"];
					$MES_ED=@$_GET["MES_ED"];
					$ANO_ED=@$_GET["ANO_ED"];
					$DIA_EH=@$_GET["DIA_EH"];
					$MES_EH=@$_GET["MES_EH"];
					$ANO_EH=@$_GET["ANO_EH"];
					$NUM_REGS=@$_GET[ 'NUMREGS' ];
					

		//GENERAR ARCHIVO SAP MEDIOS DE PAGO
					
					//NOMBRE ARCHIVO
								$DES_SAPFILES=$FTIENDA.$ANO_EH.$MES_EH.$DIA_EH.".SBW";
					
					//CONTROL (PRIMERA LÍNEA)
								$CONTROL="0|".$FTIENDA."|".$FTIENDA."|".$NUM_REGS."|".$ANO_EH.$MES_EH.$DIA_EH."|".$TOTALRECAUDO;
					//GENERA ARCHIVO FÍSICO	
								 $open = fopen($DIR_DAT.$DES_SAPFILES, "w+");
								 fwrite($open, $CONTROL . PHP_EOL);
					//LOS FILTROS
								$F_FECHA=" WHERE ( Convert(varchar(20), TS_TRN_END, 120) >= '".$ANO_ED."-".$MES_ED."-".$DIA_ED." 00:00:00' AND Convert(varchar(20), TS_TRN_END, 120) <='".$ANO_EH."-".$MES_EH."-".$DIA_EH." 23:59:59' )  AND FL_VD<>1 AND FL_CNCL<>1"; 
								$FILTRO_FLAGS=" AND FL_TRG_TRN<>1 AND FL_CNCL<>1 AND FL_VD<>1 AND FL_SPN IS NULL";
								$FLT_LONPKP="WHERE ID_TRN IN(SELECT ID_TRN FROM TR_LON_TND) OR ID_TRN IN(SELECT ID_TRN FROM TR_PKP_TND)";
								$FILTRO_TIENDA=" AND ID_BSN_UN=".$FTIENDA ;
								$FILTRO_MP=" AND ID_TRN IN(SELECT ID_TRN FROM TR_CTL_TND WHERE TY_TND_CTL=1) ";
					//LOS REGISTROS
								$CONSULTA="SELECT * FROM  TR_TRN ".$F_FECHA." ".$FILTRO_FLAGS." AND  ID_TRN IN(SELECT ID_TRN FROM TR_CTL_TND ".$FLT_LONPKP.") ".$FILTRO_TIENDA.$FILTRO_MP." ORDER BY ID_TRN  DESC";
								$RS = sqlsrv_query($conn, $CONSULTA);
								////oci_execute($RS);
								while ($row = sqlsrv_fetch_array($RS)){
										$ID_OPR = $row['ID_OPR'];
												$OPERADOR="NR";
												$S2="SELECT CD_OPR FROM PA_OPR WHERE ID_OPR=".$ID_OPR;
												$RS2 = sqlsrv_query($conn, $S2);
												////oci_execute($RS2);
												if ($row2 = sqlsrv_fetch_array($RS2)) {
													$OPERADOR = $row2['CD_OPR'];
												}
												$OPERADOR=substr("00000000".$OPERADOR, -8);

										$ID_TRN = $row['ID_TRN'];

										//OBTENER CADA MEDIO DE PAGO, ESTO PARA TRX QUE TIENEN MÁS DE UN MEDIO DE PAGO, REGISTRO DE VENTAS
										$S2="SELECT * FROM TR_LTM_TND_CTL_TND WHERE ID_TRN=".$ID_TRN;
										$RS2 = sqlsrv_query($conn, $S2);
										////oci_execute($RS2);
										if ($row2 = sqlsrv_fetch_array($RS2)) {
												$ID_TND = $row2['ID_TND'];
												$ID_CNY = $row2['ID_CNY'];
												$MO_TND_FN_TRN = $row2['MO_TND_FN_TRN']; //IMPORTE
		
												$CONMPSAP="SELECT MDP_SAP FROM AS_TND WHERE ID_TND=".$ID_TND;
												$RSMP = sqlsrv_query($conn, $CONMPSAP);
												////oci_execute($RSMP);
												if ($row = sqlsrv_fetch_array($RSMP)) {
														$MDP_SAP=$row['MDP_SAP'];
												}
											
												$IMPORTE=$MO_TND_FN_TRN;

											//REGISTRA LINEA POR MEDIO DE PAGO
											$LINEA_TRX="1|".$OPERADOR."|".$ID_TND."|".$MDP_SAP."|+|".$IMPORTE;
											 fwrite($open, $LINEA_TRX . PHP_EOL);
										}
								}

								 fclose($open);

								$root = $DIR_DAT;
								$file = $DES_SAPFILES;
								$path = $root.$file;
								$type = '';
								 
								if (is_file($path)) {
								 $size = filesize($path);
								 if (function_exists('mime_content_type')) {
								 $type = mime_content_type($path);
								 } else if (function_exists('finfo_file')) {
								 $info = finfo_open(FILEINFO_MIME);
								 $type = finfo_file($info, $path);
								 finfo_close($info);
								 }
								 if ($type == '') {
								 $type = "application/force-download";
								 }
								 // Definir headers
								 header("Content-Type: $type");
								 header("Content-Disposition: attachment; filename=$file");
								 header("Content-Transfer-Encoding: binary");
								 header("Content-Length: " . $size);
								 // Descargar archivo
								 readfile($path);
								} else {
								 die("El archivo no existe.");
								}


?>