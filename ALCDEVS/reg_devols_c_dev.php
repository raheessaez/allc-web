<table style="margin:10px 20px; ">
<tr><td>
        		<?php
				$ID_DEVS=@$_GET["IDD"];
				$SQL="SELECT * FROM DV_TICKET WHERE ID_DEVS=".$ID_DEVS;
				$RS= sqlsrv_query($conn, $SQL);
				////oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {
					$ID_TIPOD = $row['ID_TIPOD'];
							$SQL2="SELECT * FROM DV_TIPOD WHERE ID_TIPOD=".$ID_TIPOD;
							$RS2 = sqlsrv_query($conn, $SQL2);
							////oci_execute($RS2);
							if ($row2 = sqlsrv_fetch_array($RS2)) {
								$NM_TIPOD = $row2['NM_TIPOD'];
							}
							if($ID_TIPOD==1){ //GIFTCARD
								$SQL3="SELECT * FROM DV_GFCD WHERE ID_DEVS=".$ID_DEVS;
								$RS3 = sqlsrv_query($conn, $SQL3);
								////oci_execute($RS3);
								if ($row3 = sqlsrv_fetch_array($RS3)) {
									$NUM_GFCD = strtoupper($row3['NUM_GFCD']);
								}
							}
							if($ID_TIPOD==2){ //EFECTIVO
								$SQL3="SELECT * FROM DV_EFEC WHERE ID_DEVS=".$ID_DEVS;
								$RS3 = sqlsrv_query($conn, $SQL3);
								////oci_execute($RS3);
								if ($row3 = sqlsrv_fetch_array($RS3)) {
									$ID_WS_SEL = strtoupper($row3['ID_WS']);
								}
							}
							if($ID_TIPOD==3){ //FACTURA
								$SQL3="SELECT * FROM DV_FACT WHERE ID_DEVS=".$ID_DEVS;
								$RS3 = sqlsrv_query($conn, $SQL3);
								////oci_execute($RS3);
								if ($row3 = sqlsrv_fetch_array($RS3)) {
									$ID_WS_SEL = strtoupper($row3['ID_WS']);
								}
							}
							
					$ID_TRN = $row['ID_TRN'];
							$SQLTRX="SELECT * FROM TR_TRN WHERE ID_TRN=".$ID_TRN;
							$RST = sqlsrv_query($arts_conn, $SQLTRX);
							////oci_execute($RST);
							if ($rowTCKT = sqlsrv_fetch_array($RST)){
								$AI_TRN = $rowTCKT['AI_TRN']; //NUMERO DE TICKET
								$ID_WS = $rowTCKT['ID_WS']; //NUMERO DE TERMINAL
								$ID_BSN_UN = $rowTCKT['ID_BSN_UN']; //NUMERO DE TIENDA
							}
							$SQL3="SELECT * FROM AS_WS WHERE ID_WS=".$ID_WS;
							$RS3 = sqlsrv_query($arts_conn, $SQL3);
							////oci_execute($RS3);
							if ($row3 = sqlsrv_fetch_array($RS3)) {
								$CD_WS = strtoupper($row3['CD_WS']);
							}
							$SQL3="SELECT * FROM PA_STR_RTL WHERE ID_BSN_UN=".$ID_BSN_UN;
							$RS3 = sqlsrv_query($arts_conn, $SQL3);
							////oci_execute($RS3);
							if ($row3 = sqlsrv_fetch_array($RS3)) {
								$CD_STR = strtoupper($row3['CD_STR_RT']);
							}
				}
				//SELECCIONAR CLIENTE DESDE DV_DEVCLTE
				$SQL="SELECT * FROM DV_DEVCLTE WHERE ID_DEVS=".$ID_DEVS;
				$RS= sqlsrv_query($conn, $SQL);
				////oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {
					$ID_CPR = $row['ID_CPR'];
					$TY_CPR = $row['TY_CPR'];
				}
				if($TY_CPR!="P"){
						$SQL="SELECT * FROM CO_CPR_CER WHERE ID_CPR=".$ID_CPR;
						$RS= sqlsrv_query($arts_conn, $SQL);
						////oci_execute($RS);
						if ($row1 = sqlsrv_fetch_array($RS)) {
							$IDENTIFICACION = $row1['CD_CPR'];
							$NOMBRE = $row1['NOMBRE'];
							$DIRECCION = $row1['DIRECCION'];
							$COD_REGION = $row1['COD_REGION'];
							$COD_CIUDAD = $row1['COD_CIUDAD'];
									$SQL2="SELECT DES_CIUDAD FROM PM_CIUDAD WHERE COD_CIUDAD=".$COD_CIUDAD;
									$RS2 = sqlsrv_query($maestra, $SQL2);
									////oci_execute($RS2);
									if ($row2 = sqlsrv_fetch_array($RS2)) {
										$DES_CIUDAD = ", ".strtoupper($row2['DES_CIUDAD']);
									}
									$SQL2="SELECT DES_REGION, ABR_REGION FROM PM_REGION WHERE COD_REGION=".$COD_REGION;
									$RS2 = sqlsrv_query($maestra, $SQL2);
									////oci_execute($RS2);
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
						////oci_execute($RS);
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
					<h3>Registro de Emisi&oacute;n de Nota de Cr&eacute;dito N&deg;<?=$ID_DEVS;?></h3>
                    <?php
					 if($D_GFC == 3){ //FACTURA
							$SQLF="SELECT * FROM TR_INVC WHERE ID_TRN=".$ID_TRN;
							$RSF = sqlsrv_query($arts_conn, $SQLF);
							////oci_execute($RSF);
							if ($rowf = sqlsrv_fetch_array($RSF)) {
								$INVC_NMB = $rowf['INVC_NMB'];
								$ID_CPRF = $rowf['ID_CPR'];
								$FL_CP = $rowf['FL_CP'];
							}
							if($FL_CP==0){
										$SQLF="SELECT * FROM CO_CPR_CER WHERE ID_CPR=".$ID_CPRF;
										$RSF = sqlsrv_query($arts_conn, $SQLF);
										////oci_execute($RSF);
										if ($rowf = sqlsrv_fetch_array($RSF)) {
											$NOMBRE_F = $rowf['NOMBRE'];
											$TY_CPR_F = $rowf['TY_CPR'];
											if($TY_CPR_F=="C"){$IDENTIFICACION_F = "C.I. No. ".$rowf['CD_CPR'];}
											if($TY_CPR_F=="r"){$IDENTIFICACION_F = "R.U.C. ".$rowf['CD_CPR'];}
											$COD_REGION = $rowf['COD_REGION'];
											$COD_CIUDAD_F = $rowf['COD_CIUDAD'];
													$S3="SELECT DES_CIUDAD FROM PM_CIUDAD WHERE COD_CIUDAD=".$COD_CIUDAD_F;
													$RS3 = sqlsrv_query($maestra, $S3);
													////oci_execute($RS3);
													if ($row3 = sqlsrv_fetch_array($RS3)) {
														$DES_CIUDAD_F = ", ".strtoupper($row3['DES_CIUDAD']);
													}
													$S3="SELECT DES_REGION, ABR_REGION FROM PM_REGION WHERE COD_REGION=".$COD_REGION;
													$RS3 = sqlsrv_query($maestra, $S3);
													////oci_execute($RS3);
													if ($row3 = sqlsrv_fetch_array($RS3)) {
														$DES_REGION_F = $row3['DES_REGION'];
														$ABR_REGION_F = $row3['ABR_REGION'];
														if(!empty($ABR_REGION_F)){$DES_REGION_F = $DES_REGION_F." (".$ABR_REGION_F.")";}
													} else {
														$DES_REGION_F = "";
													}
											$DIRECCION_F = $rowf['DIRECCION'].$DES_CIUDAD_F." ".$DES_REGION_F."<BR>Tel&eacute;fono: ".$rowf['TELEFONO'].", e-mail: ".$rowf['CORREO'];
										}
							} else {
										$SQLF="SELECT * FROM CO_EXT_CER WHERE ID_CPR=".$ID_CPRF;
										$RSF = sqlsrv_query($arts_conn, $SQLF);
										////oci_execute($RSF);
										if ($rowf = sqlsrv_fetch_array($RSF)) {
											$NOMBRE_F = $rowf['NOMBRE'];
											$IDENTIFICACION_F = "Pasaporte: ".$rowf['CD_CPR'];
											$NACIONALIDAD = ", ".$rowf['NACIONALIDAD'];
											$IDENTIFICACION_F = $IDENTIFICACION_F.$NACIONALIDAD;
											$DIRECCION_F = $rowf['DIRECCION']."<BR>Tel&eacute;fono: ".$rowf['TELEFONO'].", e-mail: ".$rowf['CORREO'];
										}
							}
					//FACTURA
					?>
                    <h3>Factura N&deg; <?=$INVC_NMB;?></h3>
                    <p>Cliente: <?=$NOMBRE_F." (".$IDENTIFICACION_F.")";?></p>
                    <p><?=$DIRECCION_F;?></p>
                     <?php } ?>

					<?php if($D_GFC != 3){?> 
                                <h3>Informaci&oacute;n del Cliente</h3>
                                <p>Nombre: <?=$NOMBRE;?>, <?=$CPR_TY;?> <?=$IDENTIFICACION;?></p>
                                <p>
                                <?php if($TY_CPR!="P"){ ?>
                                    <p>Direcci&oacute;n: <?=$DIRECCION.$DES_CIUDAD." ".$DES_REGION;?></p>
                                <?php } else { ?>
                                    <p>Nacionalidad: <?=$NACIONALIDAD;?></p>
                                    <p>Direcci&oacute;n: <?=$DIRECCION;?></p>
                                <?php } ?>
                                    <p>Tel&eacute;fono: <?=$TELEFONO;?>, e-mail: <?=$CORREO;?> </p>
					<?php } ?>
                  
                   <h3>Art&iacute;culos en Devoluci&oacute;n</h3>
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
										$SQL="SELECT * FROM DV_ARTS WHERE ID_DEVS=".$ID_DEVS." ORDER BY ID_ART ASC";
										$RS= sqlsrv_query($conn, $SQL);
										////oci_execute($RS);
										$ITEM_NUM=0;
										$TOTAL_DEV=0;
										while ($row = sqlsrv_fetch_array($RS)) {
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
												$RS1= sqlsrv_query($arts_conn, $SQL1);
												////oci_execute($RS1);
												if ($row1 = sqlsrv_fetch_array($RS1)) {
													$ID_ITM_PS =  $row1['ID_ITM_PS'];
												}
												//DATA ITEM
												$SQL1="SELECT * FROM AS_ITM WHERE ID_ITM=".$ID_ITM;
												$RS1= sqlsrv_query($arts_conn, $SQL1);
												////oci_execute($RS1);
												if ($row1 = sqlsrv_fetch_array($RS1)) {
													$NM_ITM =  $row1['NM_ITM'];
												}
								?>
                                <tr>
                                    <td style="text-align:right;width:20px;max-width:26px"><?=$ITEM_NUM;?></th>
                                    <td style="text-align:right"><?=$ID_ITM_PS;?></td>
                                    <td><?=$NM_ITM;?></td>
                                    <td style="text-align:right"><?=$MONEDA.$MO_UNI_F;?></td>
                                    <td style="text-align:right"><?=$QN_DEV_F;?></td>
                                    <td style="text-align:right"><?=$MONEDA.$MO_DEV_F;?></td>
                                </tr>
                                <?php
								}
								$MONTO_TOT_DEV=$TOTAL_DEV;
								?>
                                <tr style="background-color:#7A2A9C ">
                                    <td colspan="5" style="text-align:right; color:#FFF; font-size:12pt; font-weight:300">
										<?php if($D_GFC!=3){?> 
                                                Total Devoluci&oacute;n
                                        <?php } else { ?>
                                                Total Factura
                                        <?php } ?>
                                    </th>
                                    <td style="text-align:right; color:#FFF; font-size:12pt; font-weight:300"><?=$MONEDA.$TOTAL_DEV_F;?></td>
                                </tr>
                                <tr>
                                	<td colspan="6"></td>
                                </tr>
                        </table>

                        		<input type="button"  value="Salir SIN Registrar" onClick="RetiraRegistro('<?=$ID_DEVS;?>','<?=$ID_TIPOD;?>','<?=$ID_CPR;?>');">
                                
								<?php
								if($ID_TIPOD==1){
											$PASAGFC=@$_POST["PASAGFC"];
											$GIFTCARD=@$_POST["Captar"];
											$VentanaConsulta="none";
											if($GIFTCARD=="" and $PASAGFC==1){ echo "<script language='javascript'>window.location='reg_devols.php?D_GFC=".$D_GFC."&C_DEV=1&IDD=".$ID_DEVS."&VRF=1&MSJE=3'</script>";}
                                ?>
                                    <style>#CARDREADER { display:inline; float:right; width:auto; height:auto; margin:0;padding:0;top:0;right:0;z-index:9999;background-color:#FFF;-khtml-border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;-moz-box-shadow: 0 1px 2px #999;-webkit-box-shadow: 0 1px 2px #999;box-shadow: 0 1px 2px #999;}</style>
                                        <div id="CARDREADER">
                                        	<p style="display:inline; float:left; font-size:12pt; font-weight:300; color:#666; padding:10px">
                                            		Deslice la Tarjeta de Regalo<br />(Giftcard) por el Lector<br />para su Activaci&oacute;n
                                            </p>
                                            <div style="display:inline; float:right; width:0; height:0">
                                                <style>  
													#INVISIBLE, #Captar { display:block;  width:0; height:0; margin:0; padding:0; bottom:0;  right:0; z-index:1;  background-color:transparent !important; resize: none  }
													#INVISIBLE:focus { border: 1px solid #F1F1F1 }
                                                </style>
                                                <script> function RecFoco() { document.frmdev.GIFTCARD.focus();  } </script>
                                                <script>
														function validateEnter(e) {
															var key=e.keyCode || e.which;
															if (key==13){
																return true; 
															} else { 
																return false;
															}
														}
														function Carga(val) {
																document.getElementById("Captar").value=val;
																if(document.getElementById("Captar").value.length>=1){
																	var CaptarValue = document.getElementById("Captar").value;
																	document.forms.frmdev.submit();
																}
														}														
												</script>
                                                <form action="reg_devols.php?D_GFC=<?=$D_GFC?>&C_DEV=1&IDD=<?=$ID_DEVS?>&VRF=1" method="post" name="frmdev" id="frmdev">
                                                    <textarea name="GIFTCARD" id="INVISIBLE" onblur="RecFoco();" onkeyup="if(validateEnter(event) == true) { Carga(this.value); }"></textarea> 
                                                    <input type="text" name="Captar" id="Captar" />
                                                    <input type="hidden" name="PASAGFC" value="1" />
                                                </form>
                                                <script> document.frmdev.GIFTCARD.focus();  </script>
                                            </div>
                                        	<img style="display:inline; float:right" src="images/ICO_CARDREAD.png" width="90" height="90" />
                                      </div>
                                      
								<?php 
									if($GIFTCARD!="" and $PASAGFC==1){
										//CAPTURA EN ARREGLO GIFTCARD
										$aGiftCard = str_split($GIFTCARD);
										$Tarjeta="";
										foreach ($aGiftCard as &$Letra) {
											if(ord($Letra)==38){$Letra="^";}
											if(ord($Letra)==161){$Letra="D";}
											$Tarjeta=$Tarjeta.$Letra;
										}
										$aTarjeta = explode("_", $Tarjeta);
										$Tram1=$aTarjeta[0];
										$LenTram1=strlen($Tram1);
										$BINGFC1=substr($Tram1,1,$LenTram1)."|";
										$Tram2=$aTarjeta[1];
										$LenTram2=strlen($Tram2);
										$BINGFC2=substr($Tram2,1,$LenTram2)."|";
										
										//GENERAR ARCHIVO
										$MO_TOT_TRX="000000000000".$MONTO_TOT_DEV;
										$MO_TOT_TRX=substr($MO_TOT_TRX, -12); //MONTO TRX
										$SEQ="000000".$ID_DEVS;
										$SEQ=substr($SEQ, -6); //SECUENCIAL
										$FEC=date("dm"); //FECHA
										$TPOS="        ".$CD_WS;
										$TPOS=substr($TPOS, -8); //TERMINAL POS
										$CODCOM="000000000000000"."000000000006";
										$CODCOM=substr($CODCOM, -15); //CODIGO COMERCIO
										$VERIFGFC=$BINGFC1.$BINGFC2.$MO_TOT_TRX.$SEQ.$FEC.$TPOS.$CODCOM;
										$NOMB_ARC="000000".$ID_DEVS;
										$NOMB_ARC="GFC".substr($NOMB_ARC, -6); //NOMBRE ARCHIVO
										$EXT_ARC="000".$CD_STR;
										$EXT_ARC=substr($EXT_ARC, -3); //EXTENSION TIENDA
										
										//GENERA ARCHIVO FÍSICO	
										 $NOM_ARCHIVO=$NOMB_ARC.".".$EXT_ARC;
										 $open = fopen("_arc_tmp/".$NOM_ARCHIVO, "w+");
										 fwrite($open, $VERIFGFC);
										 fclose($open);
								
												$local_file="_arc_tmp/".$NOM_ARCHIVO;
												$server_file = $DIR_EX_GFC_IN.$NOM_ARCHIVO;
								
												$conn_id = ftp_connect($FTP_SERVER); 
												$login_result = ftp_login($conn_id, $FTP_UNM, $FTP_UPW);
												
												ftp_put($conn_id, $server_file, $local_file, FTP_BINARY);
												ftp_close($conn_id);				

									//REGISTRAR EN DV_GFCD
												$SQL1="SELECT * FROM DV_GFCD WHERE ID_DEVS=".$ID_DEVS;
												$RS1= sqlsrv_query($conn, $SQL1);
												////oci_execute($RS1);
												if ($row1 = sqlsrv_fetch_array($RS1)) {
													$NUM_GFCD =  $row1['NUM_GFCD'];
												}
												if(empty($NUM_GFCD)){
													//REGISTRA
													$SQL2="INSERT INTO DV_GFCD (ID_DEVS, NUM_GFCD, MONTO, ARCHIVO) VALUES (".$ID_DEVS.", '".$BINGFC1.$BINGFC2."', ".$MONTO_TOT_DEV.", '".$NOM_ARCHIVO."')";
													$RS2= sqlsrv_query($conn, $SQL2);
													////oci_execute($RS2);
												} else {
													//ACTUALIZA
													$SQL2="UPDATE DV_GFCD SET NUM_GFCD='".$BINGFC1.$BINGFC2."', ARCHIVO='".$NOM_ARCHIVO."' WHERE ID_DEVS=".$ID_DEVS;
													$RS2= sqlsrv_query($conn, $SQL2);
													////oci_execute($RS2);
												}
												
										$VentanaConsulta="block";
								 ?>
                                        <div id="VentanaConsulta" style="display:<?=$VentanaConsulta;?>">
                                            <div id="VentanaConsulta-contenedor">
                            
                                                            <h3>Un momento por favor...<br>Estamos en consulta por activaci&oacute;n de Tarjeta Giftcard</h3>
                                                            <div style="display:block; margin:26px 0; width:100%; text-align:center">
                                                    			<img src="../images/Preload.GIF" />
                                                           </div>

                                                            <div>
                                                            <!-- FRAME DE VERIFICACION -->
                                                                    <iframe name="FrmVerifica" src="VerifSyscard.php?IDD=<?=$ID_DEVS?>" width="0%" height="0" frameborder="0" framespacing="0" marginheight="0" marginwidth="0"></iframe>
                                                            </div> 
                                                                  
                                            </div>
                                        </div>
								<?php 
									}
								} 
								?>
                                <?php if($ID_TIPOD==2){ ?>
                                		<input style="float:right" type="button" value="Confirmar Devoluci&oacute;n" onClick="ConfirmaRegistro('<?=$ID_DEVS?>', '<?=$ID_TIPOD?>');">
                                <?php } ?>

                                <?php if($ID_TIPOD==3){ ?>
									<script language="JavaScript">
                                    function ValidaCambioFact(theForm){
                                            if (theForm.TERMPOSFACT.value == 0){
                                                alert("SELECCIONE UN TERMINAL POS DONDE EJECUTAR EL CAMBIO DE FACTURA.");
                                                theForm.TERMPOSFACT.focus();
                                                return false;
                                            }
                                            if (theForm.REGCAMBFACT.value != ""){
                                    
                                                    var aceptaEntrar = window.confirm("Esta accion permite el cambio de Factura solo en el Terminal POS seleccionado...  \xbfest\xe1 seguro?");
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
                                    } //ValidaCambioFact(theForm)
                                    </script>
                                    <form action="reg_devols_reg.php" method="post" name="frmfact" id="frmfact" onSubmit="return ValidaCambioFact(this)">
                                                <p style="display:block; float:none; text-align:left; font-weight:200; font-size:12pt; padding:0 10px 0 120px; margin:10px 0 0 20px; height:auto; background-image:url(images/ICO_POS.png); background-repeat:no-repeat; background-position:left top">
                                                    Seleccione el Punto de Venta<br>donde recuperar la Transacci&oacute;n<br />
                                                    <select name="TERMPOSFACT" style=" display:inline-block; float:left; margin:6px 6px 10px 0; text-align:right; padding:2px; background-color:#CFF; font-size:12pt">
                                                        <option value="0">Terminal POS</option>
                                                        <?php 
                                                        $SQLPOS="SELECT ID_WS, CD_WS FROM AS_WS WHERE ID_BSN_UN=".$ID_BSN_UN." ORDER BY CD_WS ASC";
                                                        $RSF = sqlsrv_query($arts_conn, $SQLPOS);
                                                        ////oci_execute($RSF);
                                                        while ($rowF = sqlsrv_fetch_array($RSF)) {
                                                            $ID_WS_SEL = $rowF['ID_WS'];
                                                            $CD_WS_SEL = $rowF['CD_WS'];
                                                            ?>
                                                            <option value="<?=$ID_WS_SEL ?>" <?php if($ID_WS_SEL==$TERMPOS_SEL){ echo "Selected";}?>><?=$CD_WS_SEL ?></option>
                                                            <?php 
                                                        }
                                                        ?>
                                                    </select>
                                                    <input type="submit" name="REGCAMBFACT" style="display:inline-block; float:left; padding: 4px 10px; margin:6px 6px 10px 0"  value="Enviar Transacci&oacute;n">
                                                    <span style="font-size:9pt; font-weight:400; display:block; clear:both; margin:10px 0 0 0; padding:0;">
                                                    Verifique que el Terminal POS seleccionado<br />se encuentre habilitado para la operaci&oacute;n.
                                                    </span>
                                                </p>
                                                <input type="hidden" name="ID_DEVS" value="<?=$ID_DEVS;?>" />
                                    </form>
                                <?php } ?>


</td></tr>
</table>