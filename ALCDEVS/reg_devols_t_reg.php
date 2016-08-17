<?php include("session.inc");?>

<?php


	$D_GFC=@$_GET["D_GFC"];
	$TCKTSEL=@$_POST["TCKTSEL"];
	



					$NUM_ITM_DEVS=0;
					//OBTENER ID_BSN_UN
					$S2="SELECT ID_BSN_UN FROM TR_TRN WHERE ID_TRN=".$TCKTSEL;
					$RS2 = sqlsrv_query($arts_conn, $S2);
					//oci_execute($RS2);
					if ($row = sqlsrv_fetch_array($RS2)) {
							$ID_BSN_UN=$row['ID_BSN_UN'];
					}
					//VERIFICAR TAX APLICADO A ITEM
					$S2="SELECT TX_INC FROM TR_RTL WHERE ID_TRN=".$TCKTSEL;
					$RS2 = sqlsrv_query($arts_conn, $S2);
					//oci_execute($RS2);
					if ($row = sqlsrv_fetch_array($RS2)) {
							$TAXINCL=$row['TX_INC'];
					}

					$S3="SELECT MAX(ID_DEVS) AS MID_DEVS FROM DV_TICKET";
					$RS3 = sqlsrv_query($conn,$S3);
					//oci_execute($RS2);
					if ($row = sqlsrv_fetch_array($RS3)) {
							$ID_DEVS=$row['MID_DEVS']+1;
					}else{
						$ID_DEVS= 1;
					}



					//REGISTRA TICKET EN ESTADO 0
					$SQLREG="INSERT INTO DV_TICKET (ID_DEVS,ID_TRN, ID_TIPOD, IDREG, ID_BSN_UN) VALUES (".$ID_DEVS.",".$TCKTSEL.",".$D_GFC.", ".$SESIDUSU.", ".$ID_BSN_UN.") ";
					$REG = sqlsrv_query($conn, $SQLREG);
					//oci_execute($REG);
					//OBTENER ID_DEVS
					$S2="SELECT MAX(ID_DEVS) AS MID_DEVS FROM DV_TICKET WHERE ID_TRN=".$TCKTSEL." AND ID_TIPOD=".$D_GFC." AND ID_ESTADO=0 AND IDREG=".$SESIDUSU;
					$RS2 = sqlsrv_query($conn, $S2);
					//oci_execute($RS2);
					if ($row = sqlsrv_fetch_array($RS2)) {
							$ID_DEVS=$row['MID_DEVS'];
					}
								
					$ITEM_NUM=0;
					// ARREGLO ITEMS UNITARIOS
					$CS_ITM="SELECT ID_ITM FROM TR_LTM_SLS_RTN WHERE ID_TRN=".$TCKTSEL." AND ID_ITM IN(SELECT ID_ITM FROM AS_ITM WHERE FL_WM_RQ=0 OR FL_WM_RQ IS NULL)  AND FL_PRC_ALT=0 GROUP BY ID_ITM";
					$RS_ITM = sqlsrv_query($arts_conn, $CS_ITM);
					//oci_execute($RS_ITM);
					$ARR_ITM=array(); //DECLARO ARREGLO DE ITEMS UNITARIOS  A TOTALIZAR
					while ($R_ITM = sqlsrv_fetch_array($RS_ITM)) {
						$ID_ITM_G = $R_ITM['ID_ITM']; //ARTICULO
						//GENERAR ARREGLO CON ID_ITEM
						array_push($ARR_ITM, $ID_ITM_G); //INCREMENTO EL ARREGLO CON CADA ITEM
					}
									
					// ARREGLO ITEMS ALTERADOS
					$CS_ITM_AP="SELECT* FROM TR_LTM_SLS_RTN WHERE ID_TRN=".$TCKTSEL." AND ID_ITM IN(SELECT ID_ITM FROM AS_ITM WHERE FL_WM_RQ=0 OR FL_WM_RQ IS NULL) AND FL_PRC_ALT=1  AND MO_EXTND>1";
					$RS_ITM = sqlsrv_query($arts_conn, $CS_ITM_AP);
					//oci_execute($RS_ITM);
					$ARR_ITM_ALTP=array(); //DECLARO ARREGLO DE ITEMS UNITARIOS  A TOTALIZAR
					while ($R_ITM_AP = sqlsrv_fetch_array($RS_ITM)) {
						$ID_ITM_GAP = $R_ITM_AP['ID_ITM']."|".$R_ITM_AP['MO_EXTND']."|".$R_ITM_AP['AI_LN_ITM']; //ARTICULO
						//GENERAR ARREGLO CON ID_ITEM POSITIVO
						array_push($ARR_ITM_ALTP, $ID_ITM_GAP); //INCREMENTO EL ARREGLO CON CADA ITEM POSITIVO
					}

					// ARREGLO ITEMS ALTERADOS NEGATIVOS
					$CS_ITM_AN="SELECT * FROM TR_LTM_SLS_RTN WHERE ID_TRN=".$TCKTSEL." AND ID_ITM IN(SELECT ID_ITM FROM AS_ITM WHERE FL_WM_RQ=0 OR FL_WM_RQ IS NULL) AND FL_PRC_ALT=1  AND MO_EXTND<1";
					$RS_ITM_AN = sqlsrv_query($arts_conn, $CS_ITM_AN);
					//oci_execute($RS_ITM_AN);
					$ARR_ITM_ALTN=array(); //DECLARO ARREGLO DE ITEMS ALTERADOS NEGATIVOS
					while ($R_ITM_AN = sqlsrv_fetch_array($RS_ITM_AN)) {
						$MO_IN_ARRAY=$R_ITM_AN['MO_EXTND']*-1;
						$ID_ITM_GWN = $R_ITM_AN['ID_ITM']."|".$MO_IN_ARRAY; //ARTICULO
						//GENERAR ARREGLO CON ID_ITEM NEGATIVO
						array_push($ARR_ITM_ALTN, $ID_ITM_GAN); //INCREMENTO EL ARREGLO CON CADA ITEM NEGATIVO
					}
					//RECORRO ITEMS NEGATIVOS Y DENTRO ELIMINO POSITIVOS
					foreach( $ARR_ITM_ALTN as $ITMNEG){
							//echo $ITMNEG."<br>";
							$CuentaNeg=1;
							while ($CuentaNeg==1){
								//BUSCAR COINCIDENCIA EN $ARR_ITM_AP
								$CuentaPos=0;
								foreach( $ARR_ITM_ALTP as $ITMPOS){
										//OBTENER ID_ITM Y MONTO
										$PosLn=strrpos($ITMPOS, "|");
										$Compara=substr($ITMPOS, 0, $PosLn);
										//echo $Compara."...<br>";
										if($Compara==$ITMNEG){
											//echo "Eureka<br>";
											//echo $CuentaPos."<br><br>";
											unset($ARR_ITM_ALTP[$CuentaPos]);
											$CuentaNeg=$CuentaNeg+1;
										}
									$CuentaPos=$CuentaPos+1;
								}
							}
					}

					// ARREGLO ITEMS QUE REQUIEREN PESO
					$CS_ITM_WP="SELECT ID_ITM, AI_LN_ITM, MO_EXTND FROM TR_LTM_SLS_RTN WHERE ID_TRN=".$TCKTSEL." AND ID_ITM IN(SELECT ID_ITM FROM AS_ITM WHERE FL_WM_RQ=1) AND MO_EXTND>1";
					$RS_ITM_WP = sqlsrv_query($arts_conn, $CS_ITM_WP);
					//oci_execute($RS_ITM_WP);
					$ARR_ITM_WP=array(); //DECLARO ARREGLO DE ITEMS POSITIVOS QUE REQUIEREN PESO
					while ($R_ITM_WP = sqlsrv_fetch_array($RS_ITM_WP)) {
						$ID_ITM_GWP = $R_ITM_WP['ID_ITM']."|".$R_ITM_WP['MO_EXTND']."|".$R_ITM_WP['AI_LN_ITM']; //ARTICULO
						//GENERAR ARREGLO CON ID_ITEM POSITIVO
						array_push($ARR_ITM_WP, $ID_ITM_GWP); //INCREMENTO EL ARREGLO CON CADA ITEM POSITIVO
					}

					// ARREGLO ITEMS QUE REQUIEREN PESO Y SON NEGATIVOS
					$CS_ITM_WN="SELECT ID_ITM, AI_LN_ITM, MO_EXTND FROM TR_LTM_SLS_RTN WHERE ID_TRN=".$TCKTSEL." AND ID_ITM IN(SELECT ID_ITM FROM AS_ITM WHERE FL_WM_RQ=1) AND MO_EXTND<1";
					$RS_ITM_WN = sqlsrv_query($arts_conn, $CS_ITM_WN);
					//oci_execute($RS_ITM_WN);
					$ARR_ITM_WN=array(); //DECLARO ARREGLO DE ITEMS NEGATIVOS QUE REQUIEREN PESO
					while ($R_ITM_WN = sqlsrv_fetch_array($RS_ITM_WN)) {
						$MO_IN_ARRAY=$R_ITM_WN['MO_EXTND']*-1;
						$ID_ITM_GWN = $R_ITM_WN['ID_ITM']."|".$MO_IN_ARRAY; //ARTICULO
						//GENERAR ARREGLO CON ID_ITEM NEGATIVO
						array_push($ARR_ITM_WN, $ID_ITM_GWN); //INCREMENTO EL ARREGLO CON CADA ITEM NEGATIVO
					}
					//RECORRO ITEMS NEGATIVOS Y DENTRO ELIMINO POSITIVOS
					foreach( $ARR_ITM_WN as $ITMNEG){
							//echo $ITMNEG."<br>";
							$CuentaNeg=1;
							while ($CuentaNeg==1){
								//BUSCAR COINCIDENCIA EN $ARR_ITM_WP
								$CuentaPos=0;
								foreach( $ARR_ITM_WP as $ITMPOS){
										//OBTENER ID_ITM Y MONTO
										$PosLn=strrpos($ITMPOS, "|");
										$Compara=substr($ITMPOS, 0, $PosLn);
										//echo $Compara."...<br>";
										if($Compara==$ITMNEG){
											//echo "Eureka<br>";
											//echo $CuentaPos."<br><br>";
											unset($ARR_ITM_WP[$CuentaPos]);
											$CuentaNeg=$CuentaNeg+1;
										}
									$CuentaPos=$CuentaPos+1;
								}
							}
					}

					$MNT_TOT=0;
					$MNT_UNI=0;
					$QNT_TOT=0;
									
					// REGISTRO DE ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS
					foreach( $ARR_ITM as $ITEMID){
						$QTN_DEV_U=@$_POST['SELITM_U'.$TCKTSEL.$ITEMID];

						$SQL_U="SELECT * FROM TR_LTM_SLS_RTN WHERE ID_TRN=".$TCKTSEL."  AND ID_ITM=".$ITEMID."  AND FL_PRC_ALT=0 ORDER BY AI_LN_ITM ASC";
						$RS_U= sqlsrv_query($arts_conn, $SQL_U);
						//oci_execute($RS_U);
						while ($row_U = sqlsrv_fetch_array($RS_U)) {
								$MNT_ITM = $row_U['MO_EXTND']; //MONTO TOTAL DE VENTA DEL ITEM
								$TAX_ITM = $row_U['MO_TX']; //IMPUESTO APLICADO AL ITEM

												//VERIFICAR SI LOCAL ESTÁ CONFIGURADO CON  TAX INCLUIDO EN PRECIO DE ITEM
												//$TAXINCL='S' INCLUIDO, 'N' NO INCLUIDO
												if($TAXINCL==1){ $MNT_ITM = $MNT_ITM - $TAX_ITM; }//MONTO NETO
												if($TAXINCL==0){ $MNT_ITM = $MNT_ITM; }//MONTO NETO

								$QNT_ITM = $row_U['QU_ITM_LM_RTN_SLS']; //CANTIDAD ITEM
								if($MNT_ITM<0){ $QNT_ITM=$QNT_ITM*-1;}
								$MNT_TOT=$MNT_TOT+$MNT_ITM; //MONTO_TOTAL
								$TAX_TOT=$TAX_TOT+$TAX_ITM; //IMPUESTO_TOTAL
								$QNT_TOT=$QNT_TOT+$QNT_ITM; //CANTIDAD_TOTAL
						}
						$MNT_UNI=$MNT_TOT/$QNT_TOT;
						$MNT_DEVU=$MNT_UNI*$QTN_DEV_U;						
						$TAX_DEV=$TAX_ITM*$QTN_DEV_U;

						if($QTN_DEV_U<>0){
								
								//REGISTRA ARTICULO ASOC A DEVS EN ESTADO 0
								$SQLART="INSERT INTO DV_ARTS (ID_DEVS, ID_ITM, QN_DEV, QN_TRN, MO_DEV, TAX_DEV, TY_REGITM) VALUES (".$ID_DEVS.", ".$ITEMID.", ".$QTN_DEV_U.", ".$QNT_TOT.", ".$MNT_DEVU.",  ".$TAX_DEV.", 'U') ";
								$REG_A = sqlsrv_query($conn, $SQLART);
								//oci_execute($REG_A);
								$NUM_ITM_DEVS=$NUM_ITM_DEVS+1;

						}
						$MNT_TOT=0;
						$MNT_UNI=0;
						$QNT_TOT=0;
					} // FIN FOREACH UNITARIOS

									
					// REGISTRO DE ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS 
					foreach( $ARR_ITM_ALTP as $ITMPOS){
						$NUMITEM=$NUMITEM+1;
						//OBTENER ID_ITM
						$pos = strpos($ITMPOS, "|");
						$ITEMID_A = substr($ITMPOS, 0, $pos);
						//OBTENER LINE ITEM
						$PosLn=strrpos($ITMPOS, "|");
						$AI_LN_ITM=substr($ITMPOS, $PosLn+1);
						
						$QTN_DEV_A=@$_POST['SELITM_A'.$TCKTSEL.$ITEMID_A];

						$SQL_A="SELECT * FROM TR_LTM_SLS_RTN WHERE ID_TRN=".$TCKTSEL."  AND ID_ITM=".$ITEMID_A."  AND FL_PRC_ALT=1 AND AI_LN_ITM=".$AI_LN_ITM."  ORDER BY AI_LN_ITM ASC";
						$RS_A= sqlsrv_query($arts_conn, $SQL_A);
						//oci_execute($RS_A);
						while ($row_A = sqlsrv_fetch_array($RS_A)) {
								$MNT_ITM = $row_A['MO_EXTND']; //MONTO TOTAL DE VENTA DEL ITEM
								$TAX_ITM = $row_A['MO_TX']; //IMPUESTO APLICADO AL ITEM

												//VERIFICAR SI LOCAL ESTÁ CONFIGURADO CON  TAX INCLUIDO EN PRECIO DE ITEM
												//$TAXINCL='S' INCLUIDO, 'N' NO INCLUIDO
												if($TAXINCL==1){ $MNT_ITM = $MNT_ITM - $TAX_ITM; }//MONTO NETO
												if($TAXINCL==0){ $MNT_ITM = $MNT_ITM; }//MONTO NETO

								$QNT_ITM = $row_A['QU_ITM_LM_RTN_SLS']; //CANTIDAD ITEM
								if($MNT_ITM<0){ $QNT_ITM=$QNT_ITM*-1;}
								$MNT_TOT=$MNT_TOT+$MNT_ITM; //MONTO_TOTAL
								$TAX_TOT=$TAX_TOT+$TAX_ITM; //IMPUESTO_TOTAL
								$QNT_TOT=$QNT_TOT+$QNT_ITM; //CANTIDAD_TOTAL
						}
						$MNT_UNI=$MNT_TOT/$QNT_TOT;
						$MNT_DEVA=$MNT_UNI*$QTN_DEV_A;
						$TAX_DEVA=$TAX_ITM*$QTN_DEV_A;
						if($QTN_DEV_A<>0){
								
								//REGISTRA ARTICULO ASOC A DEVS EN ESTADO 0
								$SQLART="INSERT INTO DV_ARTS (ID_DEVS, ID_ITM, AI_LN_ITM, QN_DEV, QN_TRN, MO_DEV, TAX_DEV, TY_REGITM) VALUES (".$ID_DEVS.", ".$ITEMID_A.", ".$AI_LN_ITM.", ".$QTN_DEV_A.", ".$QNT_TOT.", ".$MNT_DEVA.",  ".$TAX_DEVA.", 'A') ";
								$REG_A = sqlsrv_query($conn, $SQLART);
								//oci_execute($REG_A);
								$NUM_ITM_DEVS=$NUM_ITM_DEVS+1;

						}
						$MNT_TOT=0;
						$MNT_UNI=0;
						$QNT_TOT=0;
					} // FIN FOREACH ALTERADOS

					// REGISTRO DE ITEMS ITEMS MEDIBLES Y PESABLES ITEMS MEDIBLES Y PESABLES ITEMS MEDIBLES Y PESABLES ITEMS MEDIBLES Y PESABLES ITEMS MEDIBLES Y PESABLES ITEMS MEDIBLES Y PESABLES ITEMS MEDIBLES Y PESABLES ITEMS MEDIBLES Y PESABLES ITEMS MEDIBLES Y PESABLES ITEMS MEDIBLES Y PESABLES ITEMS MEDIBLES Y PESABLES ITEMS MEDIBLES Y PESABLES ITEMS MEDIBLES Y PESABLES ITEMS MEDIBLES Y PESABLES ITEMS MEDIBLES Y PESABLES
					foreach( $ARR_ITM_WP as $ITMPOS){

						$NUMITEM_W=$NUMITEM_W+1;
						//OBTENER ID_ITM
						$pos = strpos($ITMPOS, "|");
						$ITEMID_W = substr($ITMPOS, 0, $pos);
						//OBTENER LINE ITEM
						$PosLn=strrpos($ITMPOS, "|");
						$AI_LN_ITM_W=substr($ITMPOS, $PosLn+1);

						$ITEM_DEV_WF=@$_POST['SELITM_W'.$ITEMID_W];
						$AI_LN_ITM_WF=@$_POST['AI_LN_ITM_W'.$ITEMID_W];

						if($ITEM_DEV_WF==1){

								$SQL_W="SELECT * FROM TR_LTM_SLS_RTN WHERE ID_TRN=".$TCKTSEL."  AND ID_ITM=".$ITEMID_W."  AND AI_LN_ITM=".$AI_LN_ITM_W."  ORDER BY AI_LN_ITM ASC";
								$RS_W= sqlsrv_query($arts_conn, $SQL_W);
								//oci_execute($RS_W);
								if ($row_W = sqlsrv_fetch_array($RS_W)) {
										$MNT_ITM = $row_W['MO_EXTND'];
										$QTN_ITM = $row_W['QU_UN'];
										$TAX_ITM =  $row_W['MO_TX'];
								}
								
												//VERIFICAR SI LOCAL ESTÁ CONFIGURADO CON  TAX INCLUIDO EN PRECIO DE ITEM
												//$TAXINCL='S' INCLUIDO, 'N' NO INCLUIDO
												if($TAXINCL==1){ $MNT_ITM = $MNT_ITM - $TAX_ITM; }//MONTO NETO
												if($TAXINCL==0){ $MNT_ITM = $MNT_ITM; }//MONTO NETO

								//REGISTRA ARTICULO ASOC A DEVS EN ESTADO 0
								$SQLART="INSERT INTO DV_ARTS (ID_DEVS, ID_ITM, AI_LN_ITM, QN_DEV, QN_TRN, MO_DEV, TAX_DEV, TY_REGITM) VALUES (".$ID_DEVS.", ".$ITEMID_W.", ".$AI_LN_ITM_W.", ".$QTN_ITM.", ".$QTN_ITM.", ".$MNT_ITM.",  ".$TAX_ITM.", 'P') ";
								$REG_A = sqlsrv_query($conn, $SQLART);
								//oci_execute($REG_A);
								$NUM_ITM_DEVS=$NUM_ITM_DEVS+1;

						} //$ITEM_DEV_WF==1
					} // FIN FOREACH

					
					if($D_GFC!=3 && $NUM_ITM_DEVS==0) { $REDIR=1;}
					if($D_GFC!=3 && $NUM_ITM_DEVS>0) { $REDIR=2;}
					if($D_GFC==3) { $REDIR=2;}
					
					if($REDIR==1){
							$SQLREG="DELETE FROM DV_TICKET WHERE ID_DEVS=".$ID_DEVS;
							$REG = sqlsrv_query($conn, $SQLREG);
							//oci_execute($REG);
							header("Location: reg_devols.php?D_GFC=".$D_GFC."&MSJE=1");
					} 
					
					if($REDIR==2) { header("Location: reg_devols.php?D_GFC=".$D_GFC."&TCKTSEL=".$TCKTSEL."&IDDV=".$ID_DEVS); }
					
					
?>