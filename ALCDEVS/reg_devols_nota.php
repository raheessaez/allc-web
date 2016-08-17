


<table style="margin:10px 20px; ">
<tr><td>

                <p class="speech">NC.N&deg; <?=$VER_DNC;?></p>
                <input type="button"  style="float:right; margin-left:4px"  name="IMPNOTADE" value="Imprimir" onClick="VentanaImprime('PrintNDC.php?ddv=<?=$VER_DNC;?>');">
                <input type="button" style="float:right" value="Salir" onClick="pagina('reg_devols.php');">


        		<?php
				$SQL="SELECT * FROM DV_TICKET WHERE ID_DEVS=".$VER_DNC;
				$RS= sqlsrv_query($conn, $SQL);
				//oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {
					$ID_TIPOD = $row['ID_TIPOD'];
							$SQL2="SELECT * FROM DV_TIPOD WHERE ID_TIPOD=".$ID_TIPOD;
							$RS2 = sqlsrv_query($conn, $SQL2);
							//oci_execute($RS2);
							if ($row2 = sqlsrv_fetch_array($RS2)) {
								$NM_TIPOD = $row2['NM_TIPOD'];
							}
							if($ID_TIPOD==1){ //GIFTCARD
								$SQL3="SELECT * FROM DV_GFCD WHERE ID_DEVS=".$VER_DNC;
								$RS3 = sqlsrv_query($conn, $SQL3);
								//oci_execute($RS3);
								if ($row3 = sqlsrv_fetch_array($RS3)) {
									$NUM_GFCD = strtoupper($row3['NUM_GFCD']);
								}
							}
							if($ID_TIPOD==2){ //EFECTIVO
								$SQL3="SELECT * FROM DV_EFEC WHERE ID_DEVS=".$VER_DNC;
								$RS3 = sqlsrv_query($conn, $SQL3);
								//oci_execute($RS3);
								if ($row3 = sqlsrv_fetch_array($RS3)) {
									$ID_WS_SEL = strtoupper($row3['ID_WS']);
								}
							}
							if($ID_TIPOD==3){ //FACTURA
								$SQL3="SELECT * FROM DV_FACT WHERE ID_DEVS=".$VER_DNC;
								$RS3 = sqlsrv_query($conn, $SQL3);
								//oci_execute($RS3);
								if ($row3 = sqlsrv_fetch_array($RS3)) {
									$ID_WS_SEL = strtoupper($row3['ID_WS']);
								}
							}

					$ID_TRN = $row['ID_TRN'];
							$SQLTRX="SELECT * FROM TR_TRN WHERE ID_TRN=".$ID_TRN;
							$RST = sqlsrv_query($arts_conn, $SQLTRX);
							//oci_execute($RST);
							if ($rowTCKT = sqlsrv_fetch_array($RST)){
								$AI_TRN = $rowTCKT['AI_TRN']; //NUMERO DE TICKET
								$ID_WS = $rowTCKT['ID_WS']; //NUMERO DE TERMINAL
								$ID_BSN_UN = $rowTCKT['ID_BSN_UN']; //NUMERO DE TIENDA
							}
							$SQL3="SELECT * FROM AS_WS WHERE ID_WS=".@$ID_WS;
							$RS3 = sqlsrv_query($arts_conn, $SQL3);
							//oci_execute($RS3);
							if ($row3 = @sqlsrv_fetch_array($RS3)) {
								$CD_WS = strtoupper($row3['CD_WS']);
							}
							$SQL3="SELECT * FROM PA_STR_RTL WHERE ID_BSN_UN=".@$ID_BSN_UN;
							$RS3 = sqlsrv_query($arts_conn, $SQL3);
							//oci_execute($RS3);
							if ($row3 = @sqlsrv_fetch_array($RS3)) {
								$CD_STR = strtoupper($row3['CD_STR_RT']);
							}
				}
				 if($ID_TIPOD==3){
							$SQLF="SELECT * FROM TR_INVC WHERE ID_TRN=".$ID_TRN;
							$RSF = sqlsrv_query($arts_conn, $SQLF);
							//oci_execute($RSF);
							if ($rowf = sqlsrv_fetch_array($RSF)) {
								$INVC_NMB = $rowf['INVC_NMB'];
								$ID_CPR = $rowf['ID_CPR'];
								$FL_CP = $rowf['FL_CP'];
							}
				 } else {
							$SQL="SELECT * FROM DV_DEVCLTE WHERE ID_DEVS=".$VER_DNC;
							$RS= sqlsrv_query($conn, $SQL);
							//oci_execute($RS);
							if ($row = sqlsrv_fetch_array($RS)) {
								$ID_CPR = $row['ID_CPR'];
								$TY_CPR = $row['TY_CPR'];
								if($TY_CPR!="P"){ $FL_CP=0; } else { $FL_CP=1; }
							}
				 }
				 
				 if($FL_CP==0){
						$SQL="SELECT * FROM CO_CPR_CER WHERE ID_CPR=".$ID_CPR;
						$RS= sqlsrv_query($arts_conn, $SQL);
						//oci_execute($RS);
						if ($row1 = sqlsrv_fetch_array($RS)) {
							$IDENTIFICACION = $row1['CD_CPR'];
							$NOMBRE = $row1['NOMBRE'];
							$DIRECCION = $row1['DIRECCION'];
							$COD_REGION = $row1['COD_REGION'];
							$COD_CIUDAD = $row1['COD_CIUDAD'];
									$SQL2="SELECT DES_CIUDAD FROM PM_CIUDAD WHERE COD_CIUDAD=".$COD_CIUDAD;
									$RS2 = sqlsrv_query($maestra, $SQL2);
									//oci_execute($RS2);
									if ($row2 = sqlsrv_fetch_array($RS2)) {
										$DES_CIUDAD = ", ".strtoupper($row2['DES_CIUDAD']);
									}
									$SQL2="SELECT DES_REGION, ABR_REGION FROM PM_REGION WHERE COD_REGION=".$COD_REGION;
									$RS2 = sqlsrv_query($maestra, $SQL2);
									//oci_execute($RS2);
									if ($row2 = sqlsrv_fetch_array($RS2)) {
										$DES_REGION = $row2['DES_REGION'];
										$ABR_REGION = $row2['ABR_REGION'];
										if(!empty($ABR_REGION)){$DES_REGION = $DES_REGION." (".$ABR_REGION.")";}
									} else {
										$DES_REGION = "";
									}
							$TELEFONO = $row1['TELEFONO'];
							$CORREO = strtolower($row1['CORREO']);
							if($TY_CPR=="C"){$CPR_TY = "C.I. No. ";}
							if($TY_CPR=="R"){$CPR_TY = "R.U.C. ";}
						}
				} else {
						$SQL="SELECT * FROM CO_EXT_CER WHERE ID_CPR=".$ID_CPR;
						$RS= sqlsrv_query($arts_conn, $SQL);
						//oci_execute($RS);
						if ($row2 = sqlsrv_fetch_array($RS)) {
							$IDENTIFICACION = $row2['CD_CPR'];
							$NOMBRE = $row2['NOMBRE'];
							$DIRECCION = $row2['DIRECCION'];
							$NACIONALIDAD = $row2['NACIONALIDAD'];
							$TELEFONO = $row2['TELEFONO'];
							$CORREO = strtolower($row2['CORREO']);
							$CPR_TY = "Pasaporte: ";
						}
				}
				?>
					
					<?php if($ID_TIPOD==3){?> 
                                <h3>Informaci&oacute;n Cliente Factura N&deg; <?=$INVC_NMB;?></h3>
					<?php } else {?>
                                <h3>Informaci&oacute;n del Cliente</h3>
					<?php } ?>
                                <p>Nombre: <?=@$NOMBRE;?>, <?=@$CPR_TY;?> <?=@$IDENTIFICACION;?></p>
                                <p>
                                <?php if($TY_CPR!="P"){ ?>
                                    <p>Direcci&oacute;n: <?=@$DIRECCION.@$DES_CIUDAD." ".@$DES_REGION;?></p>
                                <?php } else { ?>
                                    <p>Nacionalidad: <?=@$NACIONALIDAD;?></p>
                                    <p>Direcci&oacute;n: <?=@$DIRECCION;?></p>
                                <?php } ?>
                                    <p>Tel&eacute;fono: <?=@$TELEFONO;?>, e-mail: <?=@$CORREO;?> </p>

                    <h3>Art&iacute;culos</h3>
                    
                        <table id="Listado">
                                <tr>
                                    <th style="text-align:right">It.</th>
                                    <th>C&oacute;digo</th>
                                    <th>Art&iacute;culo</th>
                                    <th style="text-align:right">Prec.Unit.</th>
                                    <th style="text-align:right">Cantidad</th>
                                    <th style="text-align:right">Total</th>
                                </tr>
                                <?php
								$SQL="SELECT * FROM DV_ARTS WHERE ID_DEVS=".$VER_DNC." ORDER BY ID_ART ASC";
								$RS= sqlsrv_query($conn, $SQL);
								//oci_execute($RS);
								$ITEM_NUM=1;
								$MONTO_TOT_DEV=0;
								while ($row = sqlsrv_fetch_array($RS)) {
									$ID_ITM = $row['ID_ITM'];
									$TY_REGITM = $row['TY_REGITM'];
									
												//CODIGO ITEM
												$SQL1="SELECT * FROM ID_PS WHERE ID_ITM=".$ID_ITM;
												$RS1= sqlsrv_query($arts_conn, $SQL1);
												//oci_execute($RS1);
												if ($row1 = sqlsrv_fetch_array($RS1)) {
													$ID_ITM_PS =  $row1['ID_ITM_PS'];
												}
												//DATA ITEM
												$SQL1="SELECT * FROM AS_ITM WHERE ID_ITM=".$ID_ITM;
												$RS1= sqlsrv_query($arts_conn, $SQL1);
												//oci_execute($RS1);
												if ($row1 = sqlsrv_fetch_array($RS1)) {
													$NM_ITM =  $row1['NM_ITM'];
												}

									if($TY_REGITM!="P"){
											$CANTIDAD=$row['QN_DEV'];
											$CANTIDAD_F =$CANTIDAD ." c/u";
											$MONTO_DEV = $row['MO_DEV'];
											$TAX_DEV = $row['TAX_DEV'];
											$MONTO_DEV = $MONTO_DEV + $TAX_DEV;
											$MONTO_TOT_DEV=$MONTO_TOT_DEV+$MONTO_DEV;
											$PREC_UNIT = $MONTO_DEV/$CANTIDAD;
											$MONTO_DEV=$MONTO_DEV/$DIVCENTS;
											$PREC_UNIT=$PREC_UNIT/$DIVCENTS;
											$MONTO_DEV_F=number_format($MONTO_DEV, $CENTS, $GLBSDEC, $GLBSMIL);
											$PREC_UNIT_F=number_format($PREC_UNIT, $CENTS, $GLBSDEC, $GLBSMIL);
									} else {
											$CANTIDAD = $row['QN_DEV'];
											$CANTIDAD_F=$CANTIDAD/1000;
											$CANTIDAD_F=number_format($CANTIDAD_F, 3, '.', ',');
											$CANTIDAD_F=$CANTIDAD_F." Kg/Mt.";
											$MONTO_DEV = $row['MO_DEV'];
											$TAX_DEV = $row['TAX_DEV'];
											$MONTO_DEV = $MONTO_DEV + $TAX_DEV;
											$MONTO_TOT_DEV=$MONTO_TOT_DEV+$MONTO_DEV;
											$PREC_UNIT = ($MONTO_DEV*1000)/$CANTIDAD;
											$MONTO_DEV=$MONTO_DEV/$DIVCENTS;
											$PREC_UNIT=$PREC_UNIT/$DIVCENTS;
											$MONTO_DEV_F=number_format($MONTO_DEV, $CENTS, $GLBSDEC, $GLBSMIL);
											$PREC_UNIT_F=number_format($PREC_UNIT, $CENTS, $GLBSDEC, $GLBSMIL);
								}
								?>
                                <tr>
                                    <td style="text-align:right;width:20px;max-width:26px"><?=$ITEM_NUM;?></th>
                                    <td style="text-align:right"><?=$ID_ITM_PS;?></td>
                                    <td><?=$NM_ITM;?></td>
                                    <td style="text-align:right"><?=$MONEDA.$PREC_UNIT_F;?></td>
                                    <td style="text-align:right"><?=$CANTIDAD_F;?></td>
                                    <td style="text-align:right"><?=$MONEDA.$MONTO_DEV_F;?></td>
                                </tr>
                                <?php
								$ITEM_NUM=$ITEM_NUM+1;
								} //FIN WHILE
								$MONTO_TOT_DEV_F=$MONTO_TOT_DEV/$DIVCENTS;
								$MONTO_TOT_DEV_F=number_format($MONTO_TOT_DEV_F, $CENTS, $GLBSDEC, $GLBSMIL);
								?>
                                <tr style="background-color:#7A2A9C ">
                                    <td colspan="5" style="text-align:right; color:#FFF; font-size:12pt; font-weight:300">
                                     Total Devoluci&oacute;n
                                    </td>
                                    <td style="text-align:right; color:#FFF; font-size:12pt; font-weight:300"><?=$MONEDA.$MONTO_TOT_DEV_F;?></td>
                                </tr>
                                    <!-- VENTANILLA -->
									<?php
                                    if($ID_TIPOD==2){
									?>	
                                <tr style="background:#FDFDFD">
                                	<td colspan="6">
									<?php
                                            $SQL1="SELECT * FROM DV_EFEC WHERE ID_DEVS=".$VER_DNC;
                                            $RS1= sqlsrv_query($conn, $SQL1);
                                            //oci_execute($RS1);
                                            if ($row1 = sqlsrv_fetch_array($RS1)) {
                                                $ESTADO =  $row1['ESTADO'];
                                                $ID_WS =  $row1['ID_WS'];
                                            }
                                            if($ESTADO==1){
                                    ?>
                                                    <script language="JavaScript">
                                                    function ValidaCobroVen(theForm){
                                                            if (theForm.REGCOBROVEN.value != ""){
                                                    
                                                                    var aceptaEntrar = window.confirm("Esta accion permite el cobro de la Nota de Credito solo por Ventanilla de Pago...  \xbfest\xe1 seguro?");
                                                                    if (aceptaEntrar) 
                                                                    {
                                                                            var aceptaEntrar2 = window.confirm("El registro del Pago de la Devolucion ser\xe1 ejecutado...  \xbfest\xe1 seguro?");
                                                                            if (aceptaEntrar2) 
                                                                            {
                                                                                            document.forms.theForm.submit();
                                                                            }  else  {
                                                                                return false;
                                                                            }
                                                                    }  else  {
                                                                        return false;
                                                                    }
                                                        }
                                                    } //ValidaCobroVen(theForm)
                                                    </script>
                                                    <form action="reg_devols_reg.php" method="post" name="frmpos" id="frmpos" onSubmit="return ValidaCobroVen(this)">
                                                                <p style="display:block; float:none; text-align:left; font-weight:200; font-size:12pt; padding:0 10px 0 120px; margin:10px 0 0 20px; height:100px; background-image:url(images/ICO_COBRO.png); background-repeat:no-repeat; background-position:left top">
                                                                    Presione Bot&oacute;n Cobrar por Ventanilla<br />para cobrar la Nota de Cr&eacute;dito<br />
                                                                    <input type="submit" name="REGCOBROVEN"  value="Cobrar por Ventanilla">
                                                                </p>
                                                                <input type="hidden" name="ID_DEVS" value="<?=$VER_DNC;?>" />
                                                    </form>
                                    <!-- FIN VENTANILLA -->
                                    </td>
                                </tr>
                                <tr style="background:#FDFDFD">
                                	<td colspan="6">
                                    <!-- TERMINAL POS -->
                                                    <script language="JavaScript">
                                                    function ValidaCobro(theForm){
                                                            if (theForm.TERMPOS.value == 0){
                                                                alert("SELECCIONE UN TERMINAL POS DONDE EJECUTAR EL COBRO DE LA NOTA DE CREDITO.");
                                                                theForm.TERMPOS.focus();
                                                                return false;
                                                            }
                                                            if (theForm.REGCOBROPOS.value != ""){
                                                    
                                                                    var aceptaEntrar = window.confirm("Esta accion permite el cobro de la Nota de Credito solo en el Terminal POS seleccionado...  \xbfest\xe1 seguro?");
                                                                    if (aceptaEntrar) 
                                                                    {
                                                                            var aceptaEntrar2 = window.confirm("Verifique que el Terminal POS seleccionado se encuentre habilitado para la operacion.");
                                                                            if (aceptaEntrar2) 
                                                                            {
                                                                                            document.forms.theForm.submit();
                                                                            }  else  {
                                                                                return false;
                                                                            }
                                                                    }  else  {
                                                                        return false;
                                                                    }
                                                        }
                                                    } //ValidaCobro(theForm)
                                                    </script>
                                                    <form action="reg_devols_reg.php" method="post" name="frmpos" id="frmpos" onSubmit="return ValidaCobro(this)">
                                                                <p style="display:block; float:none; text-align:left; font-weight:200; font-size:12pt; padding:0 10px 0 120px; margin:10px 0 0 20px; height:auto; background-image:url(images/ICO_POS.png); background-repeat:no-repeat; background-position:left top">
                                                                    Seleccione el Punto de Venta<br>donde cobrar la Nota de Cr&eacute;dito<br />
                                                                    <select name="TERMPOS">
                                                                        <option value="0">Terminal POS</option>
                                                                        <?php 
                                                                        $SQLPOS="SELECT ID_WS, CD_WS FROM AS_WS WHERE ID_BSN_UN=".$ID_BSN_UN." ORDER BY CD_WS ASC";
                                                                        $RSF = sqlsrv_query($arts_conn, $SQLPOS);
                                                                        //oci_execute($RSF);
                                                                        while ($rowF = sqlsrv_fetch_array($RSF)) {
                                                                            $ID_WS_SEL = $rowF['ID_WS'];
                                                                            $CD_WS_SEL = $rowF['CD_WS'];
                                                                            ?>
                                                                            <option value="<?=@$ID_WS_SEL ?>" <?php if($ID_WS_SEL==$TERMPOS_SEL){ echo "Selected";}?>><?=@$CD_WS_SEL ?></option>
                                                                            <?php 
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <input type="submit" name="REGCOBROPOS"  value="Cobrar">
                                                                    <span style="font-size:9pt; font-weight:400; display:block; clear:both; margin:10px 0 0 0; padding:0;">
                                                                    Verifique que el Terminal POS seleccionado<br />se encuentre habilitado para la operaci&oacute;n.
                                                                    </span>
                                                                </p>
                                                                <input type="hidden" name="ID_DEVS" value="<?=$VER_DNC;?>" />
                                                    </form>
                                    <?php
                                            } //ESTADO==1
                                            if($ESTADO==2){
                                                $SQLPOS="SELECT CD_WS FROM AS_WS WHERE ID_WS=".$ID_WS;
                                                $RSF = sqlsrv_query($arts_conn, $SQLPOS);
                                                //oci_execute($RSF);
                                                if ($rowF = sqlsrv_fetch_array($RSF)) {
                                                    $CD_WS = $rowF['CD_WS'];
                                                }
                                    ?>
                                                <p style="display:block; float:none; text-align:left; font-weight:200; font-size:12pt; padding:0 10px 0 120px; margin:10px 0 0 20px; height:90px; background-image:url(images/ICO_POS.png); background-repeat:no-repeat; background-position:left top">
                                                    Nota de Cr&eacute;dito en Cobro<br /><span style="font-weight:600">Terminal POS <?=$CD_WS;?></span> a la espera<br />
                                                    de confirmaci&oacute;n de la Devoluci&oacute;n
                                                </p>
                                    <?php
                                            } //ESTADO==2
									?>
                                    <!-- FIN TERMINAL POS -->
                                    </td>
                                </tr>
                                    <?php	
                                    } //ID_TIPOD==2
                                    ?>
									<?php
                                    if($ID_TIPOD==3){
									?>
                                <tr style="background:#FDFDFD">
                                	<td colspan="6">
                                    <!-- ESTADOS EJECUTADO -->
                                    <?php
                                            $SQL1="SELECT * FROM DV_FACT WHERE ID_DEVS=".$VER_DNC;
                                            $RS1= sqlsrv_query($conn, $SQL1);
                                            //oci_execute($RS1);
                                            if ($row1 = sqlsrv_fetch_array($RS1)) {
                                                $ESTADO =  $row1['ESTADO'];
                                                $ID_WS =  $row1['ID_WS'];
                                            }
                                            if($ESTADO==2){
                                                $SQLPOS="SELECT CD_WS FROM AS_WS WHERE ID_WS=".$ID_WS;
                                                $RSF = sqlsrv_query($arts_conn, $SQLPOS);
                                                //oci_execute($RSF);
                                                if ($rowF = sqlsrv_fetch_array($RSF)) {
                                                    $CD_WS = $rowF['CD_WS'];
                                                }
                                    ?>
                                                <p style="display:block; float:none; text-align:left; font-weight:200; font-size:12pt; padding:0 10px 0 120px; margin:10px 0 0 20px; height:90px; background-image:url(images/ICO_POS.png); background-repeat:no-repeat; background-position:left top">
                                                    Cambio de Cliente Factura Ejecutado<br /><span style="font-weight:600">Terminal POS <?=$CD_WS;?></span> a la espera de<br /> Recuperaci&oacute;n de Transacci&oacute;n
                                                </p>
                                    <?php
                                            } //ID_TIPOD==3
									?>
                                    <!-- FIN ESTADOS EJECUTADO -->
                                    </td>
                                </tr>
                                    <?php
                                    }
                                    ?>
                        </table>
                        

</td></tr>
</table>