                    <?php if(!empty($TCKTSEL)) {

						$SQLTCKT="SELECT * FROM TR_TRN WHERE ID_TRN=".$TCKTSEL;
						$RST = sqlsrv_query($arts_conn,$SQLTCKT); 
						////oci_execute($RST);
						if ($rowTCKT = sqlsrv_fetch_array($RST)){
							$NO_DEVS=0;
							$ID_TRN = $rowTCKT['ID_TRN'];
							$AI_TRN = $rowTCKT['AI_TRN']; //NUMERO DE TICKET
							$FECHA_TICKET = $rowTCKT['DC_DY_BSN'];
									//$RES_TICKET=explode(" ",$FECHA_TICKET);
									//$TS_TICKET=$RES_TICKET[0];
									$FECHA_TICKET = date_format($FECHA_TICKET,"d-m-Y");

							$ID_OPR = $rowTCKT['ID_OPR'];
									$OPERADOR="NR";
									$S2="SELECT CD_OPR FROM PA_OPR WHERE ID_OPR=".$ID_OPR;
									$RS2 = sqlsrv_query($arts_conn,$S2); 
									////oci_execute($RS2);
									if ($row2 = sqlsrv_fetch_array($RS2)) {
										$OPERADOR = $row2['CD_OPR'];
									}	
							$ID_WS = $rowTCKT['ID_WS'];
									$TERMINAL="NR";
									$S2="SELECT CD_WS FROM AS_WS WHERE ID_WS=".$ID_WS;
									$RS2 = sqlsrv_query($arts_conn,$S2); 
									////oci_execute($RS2);
									if ($row2 = sqlsrv_fetch_array($RS2)) {
										$TERMINAL = $row2['CD_WS'];
									}	
							$ID_BSN_UN = $rowTCKT['ID_BSN_UN'];
									$S2="SELECT DE_STR_RT, CD_STR_RT, INC_PRC FROM PA_STR_RTL WHERE ID_BSN_UN=".$ID_BSN_UN;
									$RS2 = sqlsrv_query($arts_conn,$S2); 
									////oci_execute($RS2);
									if ($row2 = sqlsrv_fetch_array($RS2)) {
										$TIENDA = $row2['DE_STR_RT'];
										$CODTIENDA = $row2['CD_STR_RT'];
									}	
									$NUM_TIENDA_F="0000".$CODTIENDA;
									$NUM_TIENDA_F=substr($NUM_TIENDA_F, -4); 
									$S2="SELECT DES_TIENDA FROM MN_TIENDA WHERE DES_CLAVE=".$CODTIENDA;
									$RS2 = sqlsrv_query($maestra,$S2);
									////oci_execute($RS2);
									if ($row2 = sqlsrv_fetch_array($RS2)) {
										$LATIENDA = $NUM_TIENDA_F." - ".$row2['DES_TIENDA'];
									}	
									if (empty($TIENDA)){$TIENDA=$CODTIENDA;}

                                    $ARR_IDTND=array(); //DECLARO ARREGLO DE MEDIOS DE PAGO Y MONTOS PAGADOS
									$S2="SELECT ID_TND  FROM TR_LTM_TND WHERE ID_TRN=".$ID_TRN." GROUP BY ID_TND";
									$RS2 = sqlsrv_query($arts_conn,$S2); 
									////oci_execute($RS2);
									while ($row2 = sqlsrv_fetch_array($RS2)) {
										$ID_TND = $row2['ID_TND'];
										//GENERAR ARREGLO CON MEDIOS DE PAGO
										array_push($ARR_IDTND, $ID_TND); //INCREMENTO EL ARREGLO CON CADA MEDIO DE PAGO
									}	

						}


					?>
					<script language="JavaScript">
                    function ValidaCliente(theForm){
                            if (theForm.TY_CPRSEL.value == 0){
                                    alert("COMPLETE EL CAMPO REQUERIDO.");
                                    theForm.TY_CPRSEL.focus();
                                    return false;
                            }
                            if (theForm.IDENTIFICACION.value == ""){
                                alert("INGRESE EL NUMERO DE IDENTIFICACION DEL CLIENTE.");
                                theForm.IDENTIFICACION.focus();
                                return false;
                            }
							if (theForm.NOMBRE.value == ""){
								alert("COMPLETE EL CAMPO REQUERIDO.");
								theForm.NOMBRE.focus();
								return false;
							}
                            if (theForm.DIRECCION.value == ""){
                                alert("COMPLETE EL CAMPO REQUERIDO.");
                                theForm.DIRECCION.focus();
                                return false;
                            }
							if (theForm.TY_CPRSEL.value != "P"){
										if (theForm.COD_CIUDAD.value == 1){
											alert("COMPLETE EL CAMPO REQUERIDO.");
											theForm.COD_CIUDAD.focus();
											return false;
										}
										if (isNaN(theForm.IDENTIFICACION.value)){
											alert("INGRESE UN NUMERO DE IDENTIFICACION VALIDO DE CLIENTE.");
											theForm.IDENTIFICACION.focus();
											return false;
										}
							}
                    
                            if (theForm.REGISTRANC.value != ""){
                    
                                var aceptaEntrar = window.confirm("Se ejecutar\xe1 el registro, \xbfest\xe1 seguro?");
                                    if (aceptaEntrar) 
                                    {
                                        document.forms.theForm.submit();
                                    }  else  
                                    {
                                        return false;
                                    }
                        }
                    } //ValidaCliente(theForm)
                    </script>
                    
                    <?php
						 //AVERIGUAR SI ES FACTURA
						 	$DATAFACT=0;
							$SQLF="SELECT * FROM TR_INVC WHERE ID_TRN=".$ID_TRN;
							$RSF = sqlsrv_query($arts_conn,$SQLF);
							////oci_execute($RSF);
							if ($rowF = sqlsrv_fetch_array($RSF)) {
								$INVC_NMB = $rowF['INVC_NMB'];
								$ID_CPRF = $rowF['ID_CPR'];
								$FL_CP = $rowF['FL_CP'];
							}
							if(@$FL_CP==0){
										$SQLF1="SELECT * FROM CO_CPR_CER WHERE ID_CPR=".@$ID_CPRF;
										$RSF1 = sqlsrv_query($arts_conn,$SQLF1);
										////oci_execute($RSF1);
										if ($rowF1 = @sqlsrv_fetch_array($RSF1)) {
											$NOMBRE_F = $rowF1['NOMBRE'];
											$TipoID="C.I. No. ";
											$CD_CPR = $rowF1['CD_CPR'];
											$IDENTIFICACION_F = $TipoID.$CD_CPR;
											$DIRECCION_F = $rowF1['DIRECCION'];
											$COD_CIUDAD = $rowF1['COD_CIUDAD'];
											$COD_REGION = $rowF1['COD_REGION'];
													$SQLC="SELECT DES_REGION, ABR_REGION FROM PM_REGION WHERE COD_REGION=".$COD_REGION;
													$RSC = sqlsrv_query($maestra,$SQLC);
													////oci_execute($RSC);
													if ($rowC = sqlsrv_fetch_array($RSC)) {
														$DES_REGION = $rowC['DES_REGION'];
														$ABR_REGION = $rowC['ABR_REGION'];
														if(!empty($ABR_REGION)){$DES_REGION = $DES_REGION." (".$ABR_REGION.")";}
													} else {
														$DES_REGION = "";
													}
													$SQLC="SELECT DES_CIUDAD FROM PM_CIUDAD WHERE COD_CIUDAD=".$COD_CIUDAD;
													$RSC = sqlsrv_query($maestra,$SQLC);
													////oci_execute($RSC);
													if ($rowC = sqlsrv_fetch_array($RSC)) {
														$DES_CIUDAD_F = ", ".$rowC['DES_CIUDAD'];
													}
											$TELEFONO_F = "Tel&eacute;fono: ".$rowF1['TELEFONO'];
											$CORREO_F = " e-mail: ".$rowF1['CORREO'];
											$TY_CPR= $rowF1['TY_CPR'];
										}
							} else {
										$SQLF1="SELECT * FROM CO_EXT_CER WHERE ID_CPR=".$ID_CPRF;
										$RSF1 = sqlsrv_query($arts_conn,$SQLF1);
										////oci_execute($RSF1);
										if ($rowF1 = sqlsrv_fetch_array($RSF1)) {
											$NOMBRE_F = $rowF1['NOMBRE'];
											$TipoID="Pasaporte: ";
											$CD_CPR = $rowF1['CD_CPR'];
											$IDENTIFICACION_F = $TipoID.$CD_CPR;
											$DIRECCION_F = $rowF1['DIRECCION'];
											$TELEFONO_F = "Tel&eacute;fono: ".$rowF1['TELEFONO'];
											$CORREO_F = " e-mail: ".$rowF1['CORREO'];
											$TY_CPR= "P";
										}
							}

							if(!empty($INVC_NMB)){
								$AI_TRN = $AI_TRN." - Factura N&deg; ".$INVC_NMB;
								$DATAFACT=1;
							}
					// }
					?>
                    
                    <h3>Devoluci&oacute;n en Ticket <?=$AI_TRN?></h3>

                    <p><?=$LATIENDA?></p>
                    <p>Operador: <?=$OPERADOR?>, Terminal: <?=$TERMINAL?></p>
                    <p>Fecha Venta: <?=@$TS_TICKET?></p>
                            
					<?php if($D_GFC==3 || $DATAFACT==1){ ?>
                           <h3 style="display:block; float:none"> Cliente: <?=$NOMBRE_F;?>, (<?=$IDENTIFICACION_F;?>)</h3>
                           <p>Direcci&oacute;n: <?=$DIRECCION_F;?><?=$DES_CIUDAD_F?> <?=$DES_REGION?></p>
                           <p><?=$TELEFONO_F?><?=$CORREO_F?></p>
                    <?php } ?>

                    <h3 style="display:block; float:none; clear:both">Art&iacute;culos en Devoluci&oacute;n <?=$MOD_DEV?></h3>
                                    <table id="Listado">
                                            <tr>
                                                <th>It.</th>
                                                <th>C&oacute;digo</th>
                                                <th>Art&iacute;culo</th>
                                                <th style="text-align:right">Precio Unitario</th>
                                                <th style="text-align:right">Cant.Dev.</th>
                                                <th style="text-align:right">Total Dev.</th>
                                            </tr>
                                    <?php
										$SQL="SELECT * FROM DV_ARTS WHERE ID_DEVS=".$ID_DEVS." ORDER BY ID_ART ASC";
										$RS = sqlsrv_query($conn,$SQL);
										////oci_execute($RS);
										$ITEM_NUM=0;
										$TOTAL_DEV=0;
										while ($row = @sqlsrv_fetch_array($RS)) {
												$ITEM_NUM=$ITEM_NUM+1;
												$ID_ITM = $row['ID_ITM'];
												$QN_DEV = $row['QN_DEV'];
												$QN_TRN =  $row['QN_TRN'];
												$MO_DEV =  $row['MO_DEV'];
												$TAX_DEV =  $row['TAX_DEV'];
												$MO_DEV = $MO_DEV + $TAX_DEV;
													$MO_DEV_F= $MO_DEV/$DIVCENTS;
													$MO_DEV_F=number_format($MO_DEV_F, $CENTS, $GLBSDEC, $GLBSMIL);
												$TY_REGITM =  $row['TY_REGITM'];
												if($TY_REGITM=="P"){
													$QN_DEV_F=($QN_DEV/1000)."Kg/Mt.";
													$MO_UNI= ($MO_DEV*1000)/$QN_DEV;
													$MO_UNI_F= $MO_UNI/$DIVCENTS;
													$MO_UNI_F=number_format($MO_UNI_F, $CENTS, $GLBSDEC, $GLBSMIL);
												} else {
													$QN_DEV_F=$QN_DEV;
													$MO_UNI= $MO_DEV/$QN_DEV;
													$MO_UNI_F= $MO_UNI/$DIVCENTS;
													$MO_UNI_F=number_format($MO_UNI_F, $CENTS, $GLBSDEC, $GLBSMIL);
												}
												$TOTAL_DEV=$TOTAL_DEV+$MO_DEV;
													$TOTAL_DEV_F= $TOTAL_DEV/$DIVCENTS;
													$TOTAL_DEV_F=number_format($TOTAL_DEV_F, $CENTS, $GLBSDEC, $GLBSMIL);
												//CODIGO ITEM
												$SQL1="SELECT * FROM ID_PS WHERE ID_ITM=".$ID_ITM;
												$RS1 = sqlsrv_query($arts_conn,$SQL1);
												////oci_execute($RS1);
												if ($row1 = sqlsrv_fetch_array($RS1)) {
													$ID_ITM_PS =  $row1['ID_ITM_PS'];
												}
												//DATA ITEM
												$SQL1="SELECT * FROM AS_ITM WHERE ID_ITM=".$ID_ITM;
												$RS1 = sqlsrv_query($arts_conn,$SQL1);
												////oci_execute($RS1);
												if ($row1 = sqlsrv_fetch_array($RS1)) {
													$NM_ITM =  $row1['NM_ITM'];
												}
									?>
                                            <tr>
                                                <td><?=$ITEM_NUM?></td>
                                                <td style="text-align:right"><?=$ID_ITM_PS?></td>
                                                <td><?=$NM_ITM?></td>
                                                <td style="text-align:right"><?=$MONEDA.$MO_UNI_F?></td>
                                                <td style="text-align:right"><?=$QN_DEV_F?></td>
                                                <td style="text-align:right"><?=$MONEDA.$MO_DEV_F?></td>
                                                </td>
                                             </tr>
                                    <?php
										}
									?>
                                                <tr style="background-color:#7A2A9C ">
                                                	<td colspan="4" style="text-align:right; color:#FFF; font-size:12pt; font-weight:300">Total Devoluci&oacute;n</td>
                                                    <td colspan="2" style="text-align:right; color:#FFF; font-size:12pt; font-weight:300"><?=$MONEDA.@$TOTAL_DEV_F?></td>
                                                </tr>

                                    <?php
											$IDENCLTE=@$_POST["IDENCLTE"];
											if(empty($IDENCLTE)){ $IDENCLTE=@$CD_CPR;}
											$TY_CPRSEL=@$_POST["TY_CPRSEL"];
											$ID_TNDCL=@$_POST["ID_TND"];
                                    ?>
				<?php if($D_GFC!=3){ 
							//PRECARGAR CLIENTE - EXISTE CUANDO ES FACTURA
							 if(empty($IDENCLTE)){
											if(!empty($ID_CPRF)){
													//BUSCAR EN ARTS.CO_CPR_CER
													$RG_INT=0;
													if($TY_CPR!="P"){
																$SQL="SELECT * FROM CO_CPR_CER WHERE ID_CPR=".$ID_CPRF; 
																$RS = sqlsrv_query($arts_conn,$SQL);
																////oci_execute($RS);

																if ($row = sqlsrv_fetch_array($RS)) {
																	$NOMBRE = $row['NOMBRE'];
																	$DIRECCION = $row['DIRECCION'];
																	$COD_REGION = $row['COD_REGION'];
																	$COD_CIUDAD = $row['COD_CIUDAD'];
																	$TELEFONO = $row['TELEFONO'];
																	$CORREO = $row['CORREO'];
																}
													} else {
																$SQL="SELECT * FROM CO_EXT_CER WHERE ID_CPR=".$ID_CPRF;
																$RS = sqlsrv_query($arts_conn,$SQL);
																////oci_execute($RS);
																if ($row = sqlsrv_fetch_array($RS)) {
																	$NOMBRE = $row['NOMBRE'];
																	$DIRECCION = $row['DIRECCION'];
																	$NACIONALIDAD = $row['NACIONALIDAD'];
																	$TELEFONO = $row['TELEFONO'];
																	$CORREO = $row['CORREO'];
																}
													}
											}
							 }
				?>
                                    <form action="reg_devols.php?D_GFC=<?=$D_GFC?>&TCKTSEL=<?=$TCKTSEL?>&IDDV=<?=$ID_DEVS?>&VRF=1" method="post" name="frmclte" id="frmclte">                        
                                                <!-- MEDIOS DE PAGO UTILIZADOS / SELECCIONAR MEDIO DE PAGO DEVOLUCIÓN-->
                                                <!-- VERIFICAR SI HAY MÁS DE UN MEDIO DE PAGO -->
                                                <?php
												$NUM_MEDPAGO = count($ARR_IDTND);
												if($NUM_MEDPAGO>1){
												?>
                                                <tr style="background: #F7F7F7;">
                                                	<td colspan="4" style="text-align:right">Seleccione Medio de Pago Devoluci&oacute;n</td>
                                                    <td colspan="2">
                                                           <select name="ID_TND">
															<?php
                                                            	foreach( $ARR_IDTND as $ID_TND){
																	$SQLMP="SELECT DE_TND FROM AS_TND WHERE ID_TND=".$ID_TND;
																	$RSMP = sqlsrv_query($arts_conn,$SQLMP);
																	////oci_execute($RSMP);
																	if ($rowMP = sqlsrv_fetch_array($RSMP)) {
																		$DE_TND = $rowMP['DE_TND'];
																	}
															?>
                                                                    <option value="<?=$ID_TND?>" <?php if($ID_TNDCL==$ID_TND){ echo "Selected";}?>><?=$DE_TND?></option>
                                                            <?php
																}
																$NUM_MP=0;
															?>
                                                            </select>
                                                    </td>
                                                </tr>
												<?php
												} else { //FIN VARIOS MEDIOS DE PAGO :: INICIO SOLO UN MEDIO DE PAGO
												?>
                                                <tr style="background: #F7F7F7;">
                                                	<td colspan="4" style="text-align:right; vertical-align:middle">Medios de Pago Registrado Ticket</td>
                                                    <td colspan="2">
															<?php
                                                            	foreach( $ARR_IDTND as $ID_TND){
																	$SQLMP="SELECT DE_TND FROM AS_TND WHERE ID_TND=".$ID_TND;
																	$RSMP = sqlsrv_query($arts_conn,$SQLMP);
																	////oci_execute($RSMP);
																	if ($rowMP = sqlsrv_fetch_array($RSMP)) {
																		$DE_TND = $rowMP['DE_TND'];
																	}
																	echo $DE_TND;
																}
															$NUM_MP=1;
															?>
                                                            <input type="hidden" name="ID_TND" value="<?=$ID_TND?>">
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                
												<?php
													//BUSCAR CLIENTE
                                                    if(!empty($IDENCLTE)){
                                                            //BUSCAR EN ARTS.CO_CPR_CER
                                                            $REG_INTER=1;
                                                            $IDENCLTE=strtoupper($IDENCLTE);
															if($TY_CPRSEL!="P"){
                                                                        $SQL="SELECT * FROM CO_CPR_CER WHERE CD_CPR='".$IDENCLTE."' "; 
                                                                        $RS = sqlsrv_query($arts_conn,$SQL);
                                                                        ////oci_execute($RS);
                                                                        if ($row = sqlsrv_fetch_array($RS)) {
                                                                            $ID_CPR = $row['ID_CPR'];
                                                                            $NOMBRE = $row['NOMBRE'];
                                                                            $DIRECCION = $row['DIRECCION'];
                                                                            $COD_REGION = $row['COD_REGION'];
                                                                            $COD_CIUDAD = $row['COD_CIUDAD'];
                                                                            $TELEFONO = $row['TELEFONO'];
                                                                            $CORREO = $row['CORREO'];
                                                                            $TY_CPRSEL = $row['TY_CPR'];
                                                                        }
															} else {
                                                                        $SQL="SELECT * FROM CO_EXT_CER WHERE CD_CPR='".$IDENCLTE."' "; 
                                                                        $RS = sqlsrv_query($arts_conn,$SQL);
                                                                        ////oci_execute($RS);
                                                                        if ($row = sqlsrv_fetch_array($RS)) {
                                                                            $ID_CPR = $row['ID_CPR'];
                                                                            $NOMBRE = $row['NOMBRE'];
                                                                            $DIRECCION = $row['DIRECCION'];
                                                                            $NACIONALIDAD = $row['NACIONALIDAD'];
                                                                            $TELEFONO = $row['TELEFONO'];
                                                                            $CORREO = $row['CORREO'];
                                                                            $TY_CPRSEL = "P";
                                                                        }
															}
													}
                                                ?>
                                                <!-- DATA CLIENTE -->
                                                <tr style="background: #F7F7F7;">
                                                    <td colspan="4" style="text-align:right; vertical-align:middle">N&uacute;mero Identificaci&oacute;n Cliente</td>
                                                    <td colspan="2">
                                                            <!-- VERIFICAR SI HAY REGISTRO PREVIO -->
                                                            <input name="IDENCLTE" type="text" size="26" maxlength="50" onChange="document.forms.frmclte.submit();" value="<?=$IDENCLTE;?>">
                                                            <input type="hidden" name="TCKTSEL" value="<?=$TCKTSEL ?>" />
                                                    </td>
                                                </tr>
                                                <tr style="background: #F7F7F7;">
                                                   <td colspan="4"  style="text-align:right; vertical-align:middle">Tipo de Identificaci&oacute;n Cliente</td>
                                                    <td colspan="2">
                                                   <select name="TY_CPRSEL" onChange="document.forms.frmclte.submit();">
                                                        <option value="0">SELECCIONAR</option>
                                                        <option value="C" <?php if($TY_CPRSEL=="C"){echo "selected";}?>>Persona</option>
                                                        <option value="R" <?php if($TY_CPRSEL=="R"){echo "selected";}?> >Empresa</option>
                                                        <option value="P" <?php if($TY_CPRSEL=="P"){echo "selected";}?> >Pasaporte</option>
                                                    </select>
                                                </td>
                                                </tr>
                                                </form>
                                            <form action="reg_devols_reg.php" method="post" name="frmreg" id="frmreg" onSubmit="return ValidaCliente(this)">                        
                                                <tr id="NOMBRE" style="background: #F7F7F7;">
                                                    <td colspan="4"  style="text-align:right; vertical-align:middle">Nombre</td>
                                                    <td colspan="2"  >
                                                    <input type="hidden" name="TY_CPRSEL" value="<?=$TY_CPRSEL?>">
                                                    <input type="hidden" name="IDENTIFICACION" value="<?=@$IDENCLTE?>">
                                                    <input name="NOMBRE" type="text" size="26" maxlength="255"  value="<?=@$NOMBRE?>">
                                                    </td>
                                                </tr>
                                                <tr id="DIRECC" style="background: #F7F7F7;">
                                                    <td colspan="4"  style="text-align:right; vertical-align:middle">Direcci&oacute;n</td>
                                                    <td colspan="2"><input name="DIRECCION" type="text" size="26" maxlength="100" value="<?=@$DIRECCION?>"> </td>
                                                </tr>
                                                <?php if($TY_CPRSEL!="P"){?>


																	 <?php if($GLBDPTREG==1){?>
                                                                    <tr id="REGION" style="background: #F7F7F7">
                                                                        <td colspan="4" style="text-align:right; vertical-align:middle"><?=$GLBDESCDPTREG?></td>
                                                                        <td colspan="2"><select name="COD_REGION"  onChange="CargaCiudad(this.value, this.form.name, 'COD_CIUDAD', <?=$GLBCODPAIS?>)">
                                                                                            <option value="0"><?=$GLBDESCDPTREG?></option>
                                                                                            <?php 
                                                                                            $SQLRC="SELECT * FROM PM_REGION WHERE COD_PAIS=".$GLBCODPAIS." ORDER BY DES_REGION ASC";
                                                                                            $RSRC = sqlsrv_query($maestra,$SQLRC);
                                                                                            ////oci_execute($RSRC);
                                                                                            while ($rowRC = sqlsrv_fetch_array($RSRC)) {
                                                                                                $COD_REGION2 = $rowRC['COD_REGION'];
                                                                                                $DES_REGION = $rowRC['DES_REGION'];
                                                                                             ?>
                                                                                            <option value="<?=$COD_REGION2;?>" <?php if($COD_REGION2==$COD_REGION){echo "SELECTED";}?>><?=$DES_REGION ?></option>
                                                                                            <?php 
                                                                                            }
                                                                                             ?>
                                                                            </select></td>
                                                                    </tr>
                                                                     <?php } else {?><input type="hidden" name="COD_REGION" value="0"><?php }//$GLBDPTREG?>
                                                                    <tr id="CIUDAD" style="background: #F7F7F7">
                                                                      <td colspan="4" style="text-align:right; vertical-align:middle">Ciudad</td>
                                                                       <td colspan="2"><select id="COD_CIUDAD" name="COD_CIUDAD">
                                                                        <option value="0">Ciudad</option>
                                                                                <?php
                                                                                    if($GLBDPTREG==1){
                                                                                            $S1RC="SELECT * FROM PM_CIUDAD WHERE COD_PAIS=".$GLBCODPAIS." AND COD_REGION=".$COD_REGION." ORDER BY DES_CIUDAD ASC";
                                                                                    } else {
                                                                                            $S1RC="SELECT * FROM PM_CIUDAD WHERE COD_PAIS=".$GLBCODPAIS." ORDER BY DES_CIUDAD ASC";
                                                                                    }
                                                                                    $RS1RC = sqlsrv_query($maestra,$S1RC);
                                                                                    ////oci_execute($RS1RC);
                                                                                    while ($rowRC = sqlsrv_fetch_array($RS1RC)) {
                                                                                        $COD_CIUDAD2 = $rowRC['COD_CIUDAD'];
                                                                                        $DES_CIUDAD = $rowRC['DES_CIUDAD'];
                                                                                ?>
                                                                                <option value="<?=$COD_CIUDAD2?>" <?php if($COD_CIUDAD2==@$COD_CIUDAD){echo "SELECTED";}?>><?=$DES_CIUDAD?></option>
                                                                                <?php
                                                                                    }
                                                                                ?>
                                                                        </select></td>
                                                                    </tr>

                                                <?php } ?>
                                                <?php if($TY_CPRSEL=="P"){?>
                                                <tr id="NACIONALIDAD" style="background: #F7F7F7;">
                                                    <td colspan="4"  style="text-align:right; vertical-align:middle">Nacionalidad</td>
                                                    <td colspan="2"><input name="NACIONALIDAD" type="text" size="20" maxlength="20" value="<?=$NACIONALIDAD?>"> </td>
                                                </tr>
                                                <?php } ?>
                                                <tr id="TELEFONO" style="background: #F7F7F7;">
                                                    <td colspan="4"  style="text-align:right; vertical-align:middle">Tel&eacute;fono</td>
                                                    <td colspan="2"><input name="TELEFONO" type="text" size="20" maxlength="20" value="<?=@$TELEFONO?>"> </td>
                                                </tr>
                                                <tr id="CORREO" style="background: #F7F7F7;">
                                                    <td colspan="4"  style="text-align:right; vertical-align:middle">Correo Electr&oacute;nico</td>
                                                    <td colspan="2"><input name="CORREO" type="text" size="26" maxlength="100"  style="text-transform:lowercase" value="<?=@$CORREO?>"> </td>
                                                </tr>
                                                <!-- FIN DATA CLIENTE -->
                                                
                                                <tr id="REGISTRA">
                                                	<td colspan="4" align="left">
                                                    		<input type="button" name="SALIR" value="Salir SIN Registrar" onClick="pagina('reg_devols.php?ssr=<?=$ID_DEVS;?>');">
                                                    </td>
                                                    <td colspan="2">
                                                            <input type="submit" name="REGISTRANC" value="Continuar Registro de Devoluci&oacute;n" style="width:100%">
                                                            <input type="hidden" name="ID_CPR" value="<?=$ID_CPR?>">
                                                            <input type="hidden" name="ID_TRN" value="<?=$TCKTSEL?>">
                                                            <input type="hidden" name="ID_DEVS" value="<?=$ID_DEVS?>">
                                                            <input type="hidden" name="NUM_MP" value="<?=$NUM_MP?>">
                                                            <input type="hidden" name="ID_TND" value="<?=$ID_TNDCL?>">
                                                            <input type="hidden" name="D_GFC" value="<?=$D_GFC?>">
                                                    </td>
                                                </tr>
                                        </form>
				<?php } //if($D_GFC!=3){ ?>
                <?php if($D_GFC==3){ ?>
                                    <form action="reg_devols_reg.php" method="post" name="frmreg" id="frmreg">                        
                                        <tr id="REGISTRA">
                                            <td colspan="4" align="left">
                                            		<input type="button" name="SALIR" value="Salir SIN Registrar" onClick="pagina('reg_devols.php?ssr=<?=$ID_DEVS;?>');">
                                             </td>
                                            <td colspan="2">
                                                    <input type="submit" name="REGISTRANC" value="Continuar Registro de Devoluci&oacute;n" style="width:100%">
                                                    <input type="hidden" name="ID_CPR" value="<?=$ID_CPR?>">
                                                    <input type="hidden" name="ID_TRN" value="<?=$TCKTSEL?>">
                                                    <input type="hidden" name="ID_DEVS" value="<?=$ID_DEVS?>">
                                                    <input type="hidden" name="ID_TND" value="<?=$ID_TNDCL?>">
                                                    <input type="hidden" name="D_GFC" value="<?=$D_GFC?>">
                                            </td>
                                        </tr>
                                  </form>
                <?php } ?>
                                    </table>
					<?php


					} //FIN TICKET SELECCIONADO ?>
