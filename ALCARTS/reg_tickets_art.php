                                    <!-- TABLA FACTURA -->
                                    <?php
                                    			
												$SQLF="SELECT * FROM TR_INVC WHERE ID_TRN=".$ID_TRN;
												$RSF = sqlsrv_query($conn, $SQLF);
												//oci_execute($RSF);
												if ($rowF = sqlsrv_fetch_array($RSF)) {
													$INVC_NMB = $rowF['INVC_NMB'];
													$ID_CPRF = $rowF['ID_CPR'];
													$FL_CP = $rowF['FL_CP'];
												}
												if(@$FL_CP==0){
															
															$SQLF1="SELECT * FROM CO_CPR_CER WHERE ID_CPR=".@$ID_CPRF;
															$RSF1 = sqlsrv_query($conn, $SQLF1);
															//oci_execute($RSF1);
															if ($rowF1 = @sqlsrv_fetch_array($RSF1)) {
																$NOMBRE_F = $rowF1['NOMBRE'];
																$TipoID="C.I. No. ";
																$IDENTIFICACION_F = $TipoID.$rowF1['CD_CPR'];
																$DIRECCION_F = $rowF1['DIRECCION'];
																$COD_CIUDAD = $rowF1['COD_CIUDAD'];
																		$SQLC="SELECT DES_CIUDAD FROM PM_CIUDAD WHERE COD_CIUDAD=".$COD_CIUDAD;
																		$RSC = sqlsrv_query($maestra, $SQLC);
																		//oci_execute($RSC);
																		if ($rowC = sqlsrv_fetch_array($RSC)) {
																			$DES_CIUDAD_F = $rowC['DES_CIUDAD'];
																		}
																$TELEFONO_F = $rowF1['TELEFONO'];
																$CORREO_F = $rowF1['CORREO'];
																$DIRECCION_F = $DIRECCION_F.", ".$DES_CIUDAD_F."<BR>Tel&eacute;fono: ".$TELEFONO_F.", e-mail: ".$CORREO_F;
															}
												} else {
															$SQLF1="SELECT * FROM CO_EXT_CER WHERE ID_CPR=".$ID_CPRF;
															$RSF1 = sqlsrv_query($conn, $SQLF1);
															//oci_execute($RSF1);
															if ($rowF1 = sqlsrv_fetch_array($RSF1)) {
																$NOMBRE_F = $rowF1['NOMBRE'];
																$TipoID="Pasaporte: ";
																$IDENTIFICACION_F = $TipoID.$rowF1['CD_CPR'];
																$DIRECCION_F = $rowF1['DIRECCION'];
																$TELEFONO_F = $rowF1['TELEFONO'];
																$CORREO_F = $rowF1['CORREO'];
																$DIRECCION_F = $DIRECCION_F.$DES_CIUDAD_F."<BR>Tel&eacute;fono: ".$TELEFONO_F.", e-mail: ".$CORREO_F;
															}
												}

											if(!empty($INVC_NMB)){
									?>
                                            <div style="display:block">
                                            	<h3>Factura N&deg; <?php echo $INVC_NMB;?></h3>
                                                <p>Cliente: <?php echo $NOMBRE_F." (".$IDENTIFICACION_F.")";?></p>
                                                <p><?php echo $DIRECCION_F;?></p>
                                            </div>
                                    <?php }?>

                                    <!-- TABLA ITEMS -->
                                    <?php
                                    $DEVS=1;
                                    $DEVS_U=0;
                                    $DEVS_A=0;
                                    $DEVS_W=0;
									?>
                                    <table id="Listado" style="width:100%">
                                            <tr>
                                                <th class="DataTH">It.</th>
                                                <th class="DataTH">C&oacute;digo</th>
                                                <th class="DataTH">Art&iacute;culo</th>
                                                <th class="DataTH" style="text-align:right">Precio Unitario</th>
                                                <th class="DataTH" style="text-align:right">Cantidad</th>
                                                <th class="DataTH" style="text-align:right">Total Item</th>
                                                <th class="DataTH" style="text-align:right">Impto.</th>
                                                <th class="DataTH" style="text-align:right">Total+Impto.</th>
                                            </tr>                        
                                    <?php
									//ARREGLOS
                                    // ARREGLO ITEMS UNITARIOS
                                    $CS_ITM="SELECT ID_ITM FROM TR_LTM_SLS_RTN WHERE ID_TRN=".$ID_TRN." AND ID_ITM IN(SELECT ID_ITM FROM AS_ITM WHERE FL_WM_RQ=0 OR FL_WM_RQ IS NULL) AND FL_PRC_ALT=0 GROUP BY ID_ITM";
                                    $RS_ITM = sqlsrv_query($conn, $CS_ITM);
                                    //oci_execute($RS_ITM);
                                    $ARR_ITM=array(); //DECLARO ARREGLO DE ITEMS UNITARIOS  A TOTALIZAR
                                    while ($R_ITM = sqlsrv_fetch_array($RS_ITM)) {
                                        $ID_ITM_G = $R_ITM['ID_ITM']; //ARTICULO
                                        //GENERAR ARREGLO CON ID_ITEM
                                        array_push($ARR_ITM, $ID_ITM_G); //INCREMENTO EL ARREGLO CON CADA ITEM
                                    }
									
                                    // ARREGLO ITEMS ALTERADOS POSITIVOS
                                    $CS_ITM_AP="SELECT* FROM TR_LTM_SLS_RTN WHERE ID_TRN=".$ID_TRN." AND ID_ITM IN(SELECT ID_ITM FROM AS_ITM WHERE FL_WM_RQ=0 OR FL_WM_RQ IS NULL) AND FL_PRC_ALT=1  AND MO_EXTND>1";
                                    $RS_ITM = sqlsrv_query($conn, $CS_ITM_AP);
                                    //oci_execute($RS_ITM);
                                    $ARR_ITM_ALTP=array(); //DECLARO ARREGLO DE ITEMS UNITARIOS  A TOTALIZAR
                                    while ($R_ITM_AP = sqlsrv_fetch_array($RS_ITM)) {
                                        $ID_ITM_GAP = $R_ITM_AP['ID_ITM']."|".$R_ITM_AP['MO_EXTND']."|".$R_ITM_AP['AI_LN_ITM']; //ARTICULO
                                        //GENERAR ARREGLO CON ID_ITEM POSITIVO
                                        array_push($ARR_ITM_ALTP, $ID_ITM_GAP); //INCREMENTO EL ARREGLO CON CADA ITEM POSITIVO
                                    }

									// ARREGLO ITEMS ALTERADOS NEGATIVOS
                                    $CS_ITM_AN="SELECT * FROM TR_LTM_SLS_RTN WHERE ID_TRN=".$ID_TRN." AND ID_ITM IN(SELECT ID_ITM FROM AS_ITM WHERE FL_WM_RQ=0 OR FL_WM_RQ IS NULL) AND FL_PRC_ALT=1  AND MO_EXTND<1";
									$RS_ITM_AN = sqlsrv_query($conn, $CS_ITM_AN);
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

                                    // ARREGLO ITEMS QUE REQUIEREN PESO Y SON POSITIVOS
                                    $CS_ITM_WP="SELECT ID_ITM, AI_LN_ITM, MO_EXTND FROM TR_LTM_SLS_RTN WHERE ID_TRN=".$ID_TRN." AND ID_ITM IN(SELECT ID_ITM FROM AS_ITM WHERE FL_WM_RQ=1) AND MO_EXTND>1";
                                    $RS_ITM_WP = sqlsrv_query($conn, $CS_ITM_WP);
                                    //oci_execute($RS_ITM_WP);
                                    $ARR_ITM_WP=array(); //DECLARO ARREGLO DE ITEMS POSITIVOS QUE REQUIEREN PESO
                                    while ($R_ITM_WP = sqlsrv_fetch_array($RS_ITM_WP)) {
                                        $ID_ITM_GWP = $R_ITM_WP['ID_ITM']."|".$R_ITM_WP['MO_EXTND']."|".$R_ITM_WP['AI_LN_ITM']; //ARTICULO
                                        //GENERAR ARREGLO CON ID_ITEM POSITIVO
                                        array_push($ARR_ITM_WP, $ID_ITM_GWP); //INCREMENTO EL ARREGLO CON CADA ITEM POSITIVO
                                    }

									// ARREGLO ITEMS QUE REQUIEREN PESO Y SON NEGATIVOS
									$CS_ITM_WN="SELECT ID_ITM, AI_LN_ITM, MO_EXTND FROM TR_LTM_SLS_RTN WHERE ID_TRN=".$ID_TRN." AND ID_ITM IN(SELECT ID_ITM FROM AS_ITM WHERE FL_WM_RQ=1) AND MO_EXTND<1";
									$RS_ITM_WN = sqlsrv_query($conn, $CS_ITM_WN);
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
																						
																								
									// ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS ITEMS UNITARIOS TOTALIZADOS
                                    $MNT_TOT=0;
                                    $MNT_UNI=0;
                                    $QNT_TOT=0;
                                    $QNT_TOT_U=0;
                                    $CANT_DEV_U=0;
                                    $TAX_TOT=0;
                                    $NUM_ITEM=0;
                                    foreach( $ARR_ITM as $ITEMID){
                                        // DATA ITEM
												// OBTENER CÓDIGO DEL ITEM
												$CS_ITM1="SELECT * FROM AS_ITM WHERE ID_ITM=".$ITEMID;
												$RS_ITM1 = sqlsrv_query($conn, $CS_ITM1);
												//oci_execute($RS_ITM1);
												if ($R_ITM1 = sqlsrv_fetch_array($RS_ITM1)) {
													$CD_ITM2 = $R_ITM1['CD_ITM'];
													$NM_ITM2 = $R_ITM1['NM_ITM'];
													$DE_ITM2 = $R_ITM1['DE_ITM'];
													if(trim($DE_ITM2)==""){$DE_ITM2=$NM_ITM2;}
												}
												$CS_ITM1="SELECT * FROM ID_PS WHERE ID_ITM=".$ITEMID;
												$RS_ITM1 = sqlsrv_query($conn, $CS_ITM1);
												//oci_execute($RS_ITM1);
												if ($R_ITM1 = sqlsrv_fetch_array($RS_ITM1)) {
													$ID_ITM_PS2 = $R_ITM1['ID_ITM_PS'];
												}

                                        $SQL_U="SELECT * FROM TR_LTM_SLS_RTN WHERE ID_TRN=".$ID_TRN."  AND ID_ITM=".$ITEMID." AND FL_PRC_ALT=0 ORDER BY AI_LN_ITM ASC";
                                        $RS_U= sqlsrv_query($conn, $SQL_U);
                                        //oci_execute($RS_U);
										$NUM_SERIES_MOTO="";
                                        while ($row_U = sqlsrv_fetch_array($RS_U)) {
                                                $AI_LN_ITM = $row_U['AI_LN_ITM']; //MONTO TOTAL DE VENTA DEL ITEM
                                                $MNT_ITM = $row_U['MO_EXTND']; //MONTO TOTAL DE VENTA DEL ITEM
                                                $QNT_ITM = $row_U['QU_ITM_LM_RTN_SLS']; //CANTIDAD ITEM
                                                $TAX_ITM = $row_U['MO_TX']; //IMPUESTO APLICADO AL ITEM

												//VERIFICAR SI LOCAL ESTÁ CONFIGURADO CON  TAX INCLUIDO EN PRECIO DE ITEM
												//$TAXINCL='S' INCLUIDO, 'N' NO INCLUIDO
												if($TAXINCL==1){ $MNT_ITM = $MNT_ITM - $TAX_ITM; }//MONTO NETO
												if($TAXINCL==0){ $MNT_ITM = $MNT_ITM; }//MONTO NETO
														

                                                if($MNT_ITM<0){ $QNT_ITM=$QNT_ITM*-1;}
													$MNT_TOT=$MNT_TOT+$MNT_ITM; //MONTO_TOTAL
													$TAX_TOT=$TAX_TOT+$TAX_ITM; //IMPUESTO_TOTAL
													$QNT_TOT=$QNT_TOT+$QNT_ITM; //CANTIDAD_TOTAL
													
												//MOTOS
												$SQLM="SELECT * FROM TR_LTM_MOTO_DT WHERE ID_TRN=".$ID_TRN." AND AI_LN_ITM=".$AI_LN_ITM;
												$RSM = sqlsrv_query($conn, $SQLM);
												//oci_execute($RSM);
												if ($rowm = sqlsrv_fetch_array($RSM)) {
													$SRL_NBR = $rowm['SRL_NBR'];
													$NUM_SERIES_MOTO=$NUM_SERIES_MOTO.$SRL_NBR." ";
												} 
										}
										if(!empty($NUM_SERIES_MOTO)){ $NUM_SERIES_MOTO="N&uacute;m.Serie: ".$NUM_SERIES_MOTO;}
	
										$MNT_UNI=($MNT_TOT/$QNT_TOT)/$DIVCENTS;
                                        $MNT_UNI_F=number_format($MNT_UNI, $CENTS, $GLBSDEC, $GLBSMIL);
										
                                        $MNT_TOT=$MNT_TOT/$DIVCENTS;
                                        $MNT_TOT_F=number_format($MNT_TOT, $CENTS, $GLBSDEC, $GLBSMIL);
										
                                        $TAX_TOT=$TAX_TOT/$DIVTAX;
                                        $TAX_TOT_F=number_format($TAX_TOT, $CENTS, $GLBSDEC, $GLBSMIL);

										$MNT_TOT_TAX=$MNT_TOT+$TAX_TOT;
                                        $MNT_TOT_TAX_F=number_format($MNT_TOT_TAX, $CENTS, $GLBSDEC, $GLBSMIL);
                                        if($QNT_TOT>=1){
											$NUM_ITEM=$NUM_ITEM+1
                                        ?>
                                                <tr>
                                                    <td ><?php echo $NUM_ITEM?></td>
                                                    <td style="text-align:right;"><?php echo $ID_ITM_PS2?></td>
                                                    <td ><?php echo $DE_ITM2.$NUM_SERIES_MOTO?></td>
                                                    <td style="text-align:right;"><?php echo $MONEDA.$MNT_UNI_F?></td>
                                                    <td style="text-align:right;"><?php echo $QNT_TOT?></td>
                                                    <td style="text-align:right;"> <?php echo $MONEDA.$MNT_TOT_F?></td>
                                                    <td style="text-align:right;"> <?php echo $MONEDA.$TAX_TOT_F?></td>
                                                    <td style="text-align:right;"> <?php echo $MONEDA.$MNT_TOT_TAX_F?></td>
                                                 </tr>
                                        <?php
										$CANT_DEV_U=$CANT_DEV_U+@$CANT_DEV;
										$CANT_DEV =0;
										$QNT_TOT_U=$QNT_TOT_U+$QNT_TOT;
										$QNT_TOT=0;
										$MNT_TOT=0;
										$TAX_TOT=0;
                                        }
                                    } // FIN FOREACH ITEMS UNITARIOS
									if($QNT_TOT_U>$CANT_DEV_U){
										$DEVS_U=1;
									} else {
										$DEVS_U=0;
									}

									// ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS ITEMS ALTERADOS
                                    $MNT_TOT=0;
                                    $MNT_UNI=0;
                                    $QNT_TOT=0;
                                    $TAX_TOT=0;
                                    $QNT_TOT_A=0;
                                    $CANT_DEV_A=0;
									$NUM_SERIES_MOTO="";
                                    foreach( $ARR_ITM_ALTP as $ITMPOS){
                                        $NUMITEM=$NUMITEM+1;
										//OBTENER ID_ITM
										$pos = strpos($ITMPOS, "|");
										$ITEMID_A = substr($ITMPOS, 0, $pos);
										//OBTENER LINE ITEM
										$PosLn=strrpos($ITMPOS, "|");
										$AI_LN_ITM=substr($ITMPOS, $PosLn+1);
										
                                        // DATA ITEM
												// OBTENER CÓDIGO DEL ITEM
												$CS_ITM1="SELECT * FROM AS_ITM WHERE ID_ITM=".$ITEMID_A;
												$RS_ITM1 = sqlsrv_query($conn, $CS_ITM1);
												//oci_execute($RS_ITM1);
												if ($R_ITM1 = sqlsrv_fetch_array($RS_ITM1)) {
													$CD_ITM2 = $R_ITM1['CD_ITM'];
													$NM_ITM2 = $R_ITM1['NM_ITM'];
													$DE_ITM2 = $R_ITM1['DE_ITM'];
													if(trim($DE_ITM2)==""){$DE_ITM2=$NM_ITM2;}
												}
												$CS_ITM1="SELECT * FROM ID_PS WHERE ID_ITM=".$ITEMID_A;
												$RS_ITM1 = sqlsrv_query($conn, $CS_ITM1);
												//oci_execute($RS_ITM1);
												if ($R_ITM1 = sqlsrv_fetch_array($RS_ITM1)) {
													$ID_ITM_PS2 = $R_ITM1['ID_ITM_PS'];
												}

                                        $SQL_U="SELECT * FROM TR_LTM_SLS_RTN WHERE ID_TRN=".$ID_TRN."  AND ID_ITM=".$ITEMID_A." AND FL_PRC_ALT=1 AND AI_LN_ITM=".$AI_LN_ITM." ORDER BY AI_LN_ITM ASC";
                                        $RS_U= sqlsrv_query($conn, $SQL_U);
                                        //oci_execute($RS_U);
										$NUM_SERIES_MOTO="";
                                        while ($row_U = sqlsrv_fetch_array($RS_U)) {
                                                $MNT_ITM = $row_U['MO_EXTND']; //MONTO TOTAL DE VENTA DEL ITEM
                                                $QNT_ITM = $row_U['QU_ITM_LM_RTN_SLS']; //CANTIDAD ITEM
                                                $TAX_ITM = $row_U['MO_TX']; //IMPUESTO APLICADO AL ITEM
												
												//VERIFICAR SI LOCAL ESTÁ CONFIGURADO CON  TAX INCLUIDO EN PRECIO DE ITEM
												//$TAXINCL='S' INCLUIDO, 'N' NO INCLUIDO
												if($TAXINCL==1){ $MNT_ITM = $MNT_ITM - $TAX_ITM; }//MONTO NETO
												if($TAXINCL==0){ $MNT_ITM = $MNT_ITM; }//MONTO NETO

                                                if($MNT_ITM<0){ $QNT_ITM=$QNT_ITM*-1;}
													$MNT_TOT=$MNT_TOT+$MNT_ITM; //MONTO_TOTAL
													$TAX_TOT=$TAX_TOT+$TAX_ITM; //IMPUESTO_TOTAL
													$QNT_TOT=$QNT_TOT+$QNT_ITM; //CANTIDAD_TOTAL
													
												//MOTOS
												$SQLM="SELECT * FROM TR_LTM_MOTO_DT WHERE ID_TRN=".$ID_TRN." AND AI_LN_ITM=".$AI_LN_ITM;
												$RSM = sqlsrv_query($conn, $SQLM);
												//oci_execute($RSM);
												if ($rowm = sqlsrv_fetch_array($RSM)) {
													$SRL_NBR = $rowm['SRL_NBR'];
													$NUM_SERIES_MOTO=$NUM_SERIES_MOTO.$SRL_NBR." ";
												}
										}
										if(!empty($NUM_SERIES_MOTO)){ $NUM_SERIES_MOTO="N&uacute;m.Serie: ".$NUM_SERIES_MOTO;}
	
										$MNT_UNI=($MNT_TOT/$QNT_TOT)/$DIVCENTS;
                                        $MNT_UNI_F=number_format($MNT_UNI, $CENTS, $GLBSDEC, $GLBSMIL);
										
                                        $MNT_TOT=$MNT_TOT/$DIVCENTS;
                                        $MNT_TOT_F=number_format($MNT_TOT, $CENTS, $GLBSDEC, $GLBSMIL);
										
                                        $TAX_TOT=$TAX_TOT/$DIVTAX;
                                        $TAX_TOT_F=number_format($TAX_TOT, $CENTS, $GLBSDEC, $GLBSMIL);
										
										$MNT_TOT_TAX=$MNT_TOT+$TAX_TOT;
                                        $MNT_TOT_TAX_F=number_format($MNT_TOT_TAX, $CENTS, $GLBSDEC, $GLBSMIL);
                                        if($QNT_TOT>=1){
											$NUM_ITEM=$NUM_ITEM+1
                                        ?>
                                                <tr>
                                                    <td ><?php echo $NUM_ITEM?></td>
                                                    <td style="text-align:right;"><?php echo $ID_ITM_PS2?></td>
                                                    <td ><?php echo $DE_ITM2.$NUM_SERIES_MOTO?></td>
                                                    <td style="text-align:right;"><?php echo $MONEDA.$MNT_UNI_F?></td>
                                                    <td style="text-align:right;"><?php echo $QNT_TOT?></td>
                                                    <td style="text-align:right;"> <?php echo $MONEDA.$MNT_TOT_F?></td>
                                                    <td style="text-align:right;"> <?php echo $MONEDA.$TAX_TOT_F?></td>
                                                    <td style="text-align:right;"> <?php echo $MONEDA.$MNT_TOT_TAX_F?></td>
                                                 </tr>
                                        <?php
										$CANT_DEV_A=$CANT_DEV_A+$CANT_DEV;
										$CANT_DEV =0;
										$QNT_TOT_A=$QNT_TOT_A+$QNT_TOT;
										$QNT_TOT=0;
										$MNT_TOT=0;
										$TAX_TOT=0;
                                        }

                                    } // FIN FOREACH ALTERADOS
									if($QNT_TOT_A==$CANT_DEV_A){
										$DEVS_A=0;
									} else {
										$DEVS_A=1;
									}


									// ITEMS MEDIBLES Y PESABLES ITEMS MEDIBLES Y PESABLES ITEMS MEDIBLES Y PESABLES ITEMS MEDIBLES Y PESABLES ITEMS MEDIBLES Y PESABLES ITEMS MEDIBLES Y PESABLES ITEMS MEDIBLES Y PESABLES ITEMS MEDIBLES Y PESABLES ITEMS MEDIBLES Y PESABLES ITEMS MEDIBLES Y PESABLES ITEMS MEDIBLES Y PESABLES ITEMS MEDIBLES Y PESABLES ITEMS MEDIBLES Y PESABLES ITEMS MEDIBLES Y PESABLES ITEMS MEDIBLES Y PESABLES
									foreach( $ARR_ITM_WP as $ITMPOS){
                                        $NUMITEM_W=$NUMITEM_W+1;
										//OBTENER ID_ITM
										$pos = strpos($ITMPOS, "|");
										$ITEMID_W = substr($ITMPOS, 0, $pos);
										//OBTENER LINE ITEM
										$PosLn=strrpos($ITMPOS, "|");
										$AI_LN_ITM_W=substr($ITMPOS, $PosLn+1);
										
                                        // DATA ITEM
												// OBTENER CÓDIGO DEL ITEM
												$CS_ITM1="SELECT * FROM AS_ITM WHERE ID_ITM=".$ITEMID_W;
												$RS_ITM1 = sqlsrv_query($conn, $CS_ITM1);
												//oci_execute($RS_ITM1);
												if ($R_ITM1 = sqlsrv_fetch_array($RS_ITM1)) {
													$CD_ITM2 = $R_ITM1['CD_ITM'];
													$NM_ITM2 = $R_ITM1['NM_ITM'];
													$DE_ITM2 = $R_ITM1['DE_ITM'];
													if(trim($DE_ITM2)==""){$DE_ITM2=$NM_ITM2;}
												}
												$CS_ITM1="SELECT * FROM ID_PS WHERE ID_ITM=".$ITEMID_W;
												$RS_ITM1 = sqlsrv_query($conn, $CS_ITM1);
												//oci_execute($RS_ITM1);
												if ($R_ITM1 = sqlsrv_fetch_array($RS_ITM1)) {
													$ID_ITM_PS2 = $R_ITM1['ID_ITM_PS'];
												}
												
                                        $SQL_W="SELECT * FROM TR_LTM_SLS_RTN WHERE ID_TRN=".$ID_TRN."  AND ID_ITM=".$ITEMID_W." AND AI_LN_ITM=".$AI_LN_ITM_W." ORDER BY AI_LN_ITM ASC";
                                        $RS_W= sqlsrv_query($conn, $SQL_W);
                                        //oci_execute($RS_W);
                                        while ($row_W = sqlsrv_fetch_array($RS_W)) {

                                                $MNT_ITM = $row_W['MO_EXTND'];
                                                $QTN_ITM = $row_W['QU_UN'];
												$TAX_ITM =  $row_W['MO_TX'];

												//VERIFICAR SI LOCAL ESTÁ CONFIGURADO CON  TAX INCLUIDO EN PRECIO DE ITEM
												//$TAXINCL='S' INCLUIDO, 'N' NO INCLUIDO
												if($TAXINCL==1){ $MNT_ITM = $MNT_ITM - $TAX_ITM; }//MONTO NETO
												if($TAXINCL==0){ $MNT_ITM = $MNT_ITM; }//MONTO NETO

												$QTN_ITM_F=$QTN_ITM/1000;
												$MNT_UNI = ($MNT_ITM*1000)/$QTN_ITM;
												
												$MNT_TOT_F=$MNT_ITM/$DIVCENTS;
												$MNT_TOT_F=number_format($MNT_TOT_F, $CENTS, $GLBSDEC, $GLBSMIL);
												
												$MNT_REG_F=$MNT_UNI/$DIVCENTS;
												$MNT_REG_F=number_format($MNT_REG_F, $CENTS, $GLBSDEC, $GLBSMIL);
		
												$TAX_TOT_F=$TAX_ITM/$DIVTAX;
												$TAX_TOT_F=number_format($TAX_TOT_F, $CENTS, $GLBSDEC, $GLBSMIL);

												$MNT_TOT_TAX=$MNT_ITM+$TAX_ITM;
												$MNT_TOT_TAX_F=number_format($MNT_TOT_TAX, $CENTS, $GLBSDEC, $GLBSMIL);
			
												$NUM_ITEM=$NUM_ITEM+1;

                                        ?>
                                                <tr>
                                                    <td><?php echo $NUM_ITEM?></td>
                                                    <td style="text-align:right"><?php echo $ID_ITM_PS2?></td>
                                                    <td><?php echo $DE_ITM2?></td>
                                                    <td style="text-align:right"><?php echo $MONEDA.$MNT_REG_F?></td>
                                                    <td style="text-align:right"><?php echo $QTN_ITM_F."Kg/Mt."?></td>
                                                    <td style="text-align:right;"> <?php echo $MONEDA.$MNT_TOT_F?></td>
                                                    <td style="text-align:right;"> <?php echo $MONEDA.$TAX_TOT_F?></td>
                                                    <td style="text-align:right;"> <?php echo $MONEDA.$MNT_TOT_TAX_F?></td>
                                                 </tr>
                                    <?php
										if($QTN_ITM==$CANT_DEV){
											$DEVS_W=0;
										} else {
											$DEVS_W=1;
										}
                                        }
                                    } // FIN FOREACH
									
                                    ?>
											<tr><td colspan="8"></td></tr>
                                    </table>
                                    <!-- FIN TABLA ITEMS -->
