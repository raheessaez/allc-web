

        <?php if($LOTE!=""){
				
				$CONSULTA="SELECT * FROM ARC_SAP WHERE ID_ARCSAP=".$LOTE;
				$RS = sqlsrv_query($conn, $CONSULTA);
				//oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {
					$NUM_LOTE = $row['NUM_LOTE'];
					$COD_TIENDA = $row['COD_TIENDA'];
				}
				$CONSULTA="SELECT * FROM MN_TIENDA WHERE DES_CLAVE=".$COD_TIENDA;
				$RS = sqlsrv_query($maestra, $CONSULTA);
				//oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {
					$DES_TIENDA = $row['DES_TIENDA'];
				}
				$CONSULTA="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO=".$LDN;
				$RS = sqlsrv_query($maestra, $CONSULTA);
				//oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {
					$DES_NEGOCIO = $row['DES_NEGOCIO'];
				}
		?>
                 <input  type="button" name="LISTADO" value="Volver" onClick="pagina('reg_precios.php?VLTE=<?php echo $LOTE;?>');">
                 <h3><?php echo $LAPAGINA?></h3>
                 <h3><?php echo $DES_NEGOCIO?> - <?php echo " L".substr("0000".$COD_TIENDA, -4)?>, <?php echo $DES_TIENDA?> : Lote <?php echo $NUM_LOTE?></h3>
                <?php
				
				$CONSULTA="SELECT COUNT(ID_ARCPRC) AS CUENTA FROM ARC_PRC WHERE ID_ARCSAP=".$LOTE." AND COD_NEGOCIO=".$LDN;
				$RS = sqlsrv_query($conn, $CONSULTA);
				//oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {
					$TOTALREG = $row['CUENTA'];
					$NUMTPAG = round($TOTALREG/$CTP,0);
					$RESTO=$TOTALREG%$CTP;
					$CUANTORESTO=round($RESTO/$CTP, 0);
					if($RESTO>0 and $CUANTORESTO==0) {$NUMTPAG=$NUMTPAG+1;}
					$NUMPAG = round($LSUP/$CTP,0);
					if ($NUMTPAG==0) {
						$NUMTPAG=1;
						}
				}
				//$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM ARC_PRC WHERE ID_ARCSAP=".$LOTE." AND COD_NEGOCIO=".$LDN." ORDER BY ID_ARCPRC DESC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;
				//$RS = sqlsrv_query($conn, $CONSULTA);
				//oci_execute($RS);
				
                $CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY ID_ARCPRC DESC) ROWNUMBER FROM ARC_PRC WHERE ID_ARCSAP=".$LOTE." AND COD_NEGOCIO=".$LDN.") AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";

                $RS = sqlsrv_query($conn, $CONSULTA);

               ?>
                <table id="Listado">
                <tr>
                    <th style="border-left:solid 6px #FFF">Departamento</th>
                    <th style="text-align:right">Art&iacute;culos</th>
                    <th style="text-align:right">Neo</th>
                    <th style="text-align:right">Act</th>
                    <th style="text-align:right">Ret</th>
                    <th style="text-align:right">Elm</th>
                    <th style="text-align:right">Excepciones</th>
                    <th>Excs.Procs.</th>
                    <th style="text-align:center">Estado</th>
                    <th style="text-align:center">Acci&oacute;n</th>
                    <th style="text-align:center">Fecha</th>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){
                        $ID_ARCPRC = $row['ID_ARCPRC'];
                        $NOM_ARCPRC = $row['NOM_ARCPRC'];
                        $NOM_ARCLOTE = $row['NOM_ARCLOTE'];
                        $CD_DPT_PS = $row['CD_DPT_PS'];
						
                        $ID_ESTPRC = $row['ID_ESTPRC'];
                        $NUM_ITEMS = $row['NUM_ITEMS'];
                        $FEC_PROC = $row['FEC_PROC'];
						
						$CONSULTA2="SELECT * FROM ID_DPT_PS WHERE CD_DPT_PS=".$CD_DPT_PS;
						$RS2 = sqlsrv_query($arts_conn, $CONSULTA2);
						//oci_execute($RS2);
						if ($row2 = sqlsrv_fetch_array($RS2)) {
							$NM_DPT_PS = $row2['NM_DPT_PS'];
						}
						
						$CONSULTA2="SELECT * FROM EST_PRC WHERE ID_ESTPRC=".$ID_ESTPRC;
						$RS2 = sqlsrv_query($conn, $CONSULTA2);
						//oci_execute($RS2);
						if ($row2 = sqlsrv_fetch_array($RS2)) {
							$NOM_ESTPRC = $row2['NOM_ESTPRC'];
							$COL_ESTPRC = $row2['COL_ESTPRC'];
							$CSS_ESTPRC = $row2['CSF_ESTADO'];
						}
						$NUM_ITEMS_F=number_format($NUM_ITEMS, 0, ',', '.');

											//CALCULO A-U-D
											$CANT_ADD=0;
											$CANT_UPD=0;
											$CANT_DEL=0;
											$CANT_ELM=0;
											
											//$DIRLOCALCTA="_arc_tmp/".substr("000".$COD_TIENDA, -3)."_".substr("0000".$NUM_LOTE, -4)."/";
											if($ID_ESTPRC>7){$DIR_LOTE="/BKP/";}
											if($ID_ESTPRC==7){$DIR_LOTE="/PRC/";}
											if($ID_ESTPRC<7){$DIR_LOTE="/IN/";}
											if($ID_ESTPRC==3){$DIR_LOTE="/BKP/";}
											//CAPTURAR
											//$CapturaLinea=file_get_contents($DIRLOCALCTA.$NOM_ARCLOTE);
											@$CapturaLinea=file_get_contents($DIR_SAP.$DIR_LOTE.$NOM_ARCLOTE);
											//ARREGLO DE CAPTURA
											$aCaptLinea = array_values(array_filter(explode("\n",$CapturaLinea)));
											//OBTENER CUENTAS DESDE ARREGLO
											foreach ($aCaptLinea as &$LineaDeCuenta) {
												$Accion=substr($LineaDeCuenta, 0, 1);
												if($Accion=="A"){$CANT_ADD=$CANT_ADD+1;}
												if($Accion=="U"){$CANT_UPD=$CANT_UPD+1;}
												if($Accion=="D"){$CANT_DEL=$CANT_DEL+1;}
												if($Accion=="X"){$CANT_ELM=$CANT_ELM+1;}
											}				
											$CANT_ADD_F=number_format($CANT_ADD, 0, ',', '.');
											$CANT_UPD_F=number_format($CANT_UPD, 0, ',', '.');
											$CANT_DEL_F=number_format($CANT_DEL, 0, ',', '.');
											$CANT_ELM_F=number_format($CANT_ELM, 0, ',', '.');



						$NUM_EXCEP = 0;
						$CONSULTA3="SELECT * FROM ARC_PRCEX WHERE ID_ARCPRC=".$ID_ARCPRC;
						$RS3 = sqlsrv_query($conn, $CONSULTA3);
						//oci_execute($RS3);
						if ($row3 = sqlsrv_fetch_array($RS3)) {
							$NUM_EXCEP = $row3['NUM_ITEMS'];
						}
						
						$PORC_EXCEP=($NUM_EXCEP*100)/$NUM_ITEMS;
						$PORC_EXCEP_F=number_format($PORC_EXCEP, 1, ',', '.');
						
						$NUM_EXCEP_F=number_format($NUM_EXCEP, 0, ',', '.');

						$EXCEPROCS = 0;
						$CONSULTA3="SELECT COUNT(ID_ARCPRC) AS EXCEPROCS FROM ARC_EXPRC WHERE ID_ARCPRC=".$ID_ARCPRC;
						$RS3 = sqlsrv_query($conn, $CONSULTA3);
						//oci_execute($RS3);
						if ($row3 = sqlsrv_fetch_array($RS3)) {
							$EXCEPROCS = $row3['EXCEPROCS'];
						}

						@$PORC_PROCS=($EXCEPROCS*100)/$NUM_EXCEP;
						$PORC_PROCS_F=number_format($PORC_PROCS, 1, ',', '.');

						$EXCEPROCS_F=number_format($EXCEPROCS, 0, ',', '.');
               ?>
				<script language="JavaScript">
                function AdvierteRechazo<?php echo $ID_ARCPRC;?>(theForm){
								var aceptaEntrar = window.confirm("ESTA ACCION RETIRA EN FORMA DEFINITIVA EL LOTE DEL PROCESAMIENTO DE PRECIOS, ESTA SEGURO?");
								if (aceptaEntrar) 
								{
												document.forms.theForm.submit();
								}  else  {
									return false;
								}
                } //AdvierteRechazo(theForm)
                function AdvierteProceso<?php echo $ID_ARCPRC;?>(theForm){
								var aceptaEntrar = window.confirm("ESTA ACCION INICIA EL PROCESO DE CAMBIO DE PRECIOS, EN ADELANTE SOLO PODRA PROCESAR PRECIOS POR DEPARTAMENTO... PRESIONE ACEPTAR PARA CONTINUAR");
								if (aceptaEntrar) 
								{
												document.forms.theForm.submit();
								}  else  {
									return false;
								}
                } //AdvierteProceso(theForm)
                </script>

               <form action="reg_precios_reg.php" method="post" name="frmreg<?php echo $ID_ARCPRC;?>" id="frmreg<?php echo $ID_ARCPRC;?>">
                <tr>
                     <td style="border-left:solid 6px <?php echo $COL_ESTPRC;?>"><span style="font-weight:600; font-size:12pt"><?php echo $NM_DPT_PS?></span></td>
                     <td style="text-align:right; vertical-align:middle; font-size:12pt"><?php echo $NUM_ITEMS_F?></td>
                     <td style="text-align:right; vertical-align:middle; font-size:12pt"><?php echo $CANT_ADD_F?></td>
                     <td style="text-align:right; vertical-align:middle; font-size:12pt"><?php echo $CANT_UPD_F?></td>
                     <td style="text-align:right; vertical-align:middle; font-size:12pt"><?php echo $CANT_DEL_F?></td>
                     <td style="text-align:right; vertical-align:middle; font-size:12pt"><?php echo $CANT_ELM_F?></td>
                     <td style="text-align:right; vertical-align:middle"><span style="font-weight:600; font-size:12pt"><?php echo $NUM_EXCEP_F?></span><BR><?php echo $PORC_EXCEP_F?>%</td>
                     <td style="text-align:right; vertical-align:middle;"><span style="font-weight:600; font-size:12pt"><?php echo $EXCEPROCS?></span><BR><?php echo $PORC_PROCS_F?>%</td>
                     <td style="text-align:center; vertical-align:middle; background-color:<?php echo $COL_ESTPRC;?>; <?=$CSS_ESTPRC ?>; font-weight:600;">
					 		<?php echo $NOM_ESTPRC?>
                            <input type="hidden" value="<?php echo $ID_ARCPRC?>" name="ID_ARCPRC">
                     </td>
                     <td style="background-color:#555; border-bottom:solid 1px #999">
                     <!-- TABLA ACCIONES -->
                     <style>
					 	#Accion<?php echo $ID_ARCPRC;?> {
							width: 100%;
						}
					 	#Accion<?php echo $ID_ARCPRC;?> tr {
							background:transparent !important;
						}
					 	#Accion<?php echo $ID_ARCPRC;?> td {
							padding:0 2px 0 0;
							background:transparent !important;
							border:none;
							width:33%;
						}
					 </style>
                     <table id="Accion<?php echo $ID_ARCPRC;?>">
                     		<tr>
                            
                                                     <td>
                                                            <input style="width:100%" type="button"value="Lista de Art&iacute;culos" name="LISTADO" onClick="pagina('reg_precios.php?ARTS=<?php echo $ID_ARCPRC;?>&LOTART=<?php echo $LOTE;?>&LDN=<?php echo $LDN;?>');">
                                                     </td>
                                                    <?php if($ID_ESTPRC==1){ ?>
                                                     <td>
                                                            <input style="width:100%" type="button"value="Excepciones" name="LISTADO" onClick="pagina('reg_precios.php?EXCEP=<?php echo $ID_ARCPRC;?>&LOTART=<?php echo $LOTE;?>&LDN=<?php echo $LDN;?>');">
                                                    </td>
                                                    <?php } ?>
                                                    <?php if($ID_ESTPRC==2){ ?>
                                                     <td>
                                                            <input style="width:100%" type="submit" id="BotonVerdeProc" value="Procesar" name="ACEPTAR" onClick="return AdvierteProceso<?php echo $ID_ARCPRC;?>('frmreg<?php echo $ID_ARCPRC;?>')">
                                                    </td>
                                                    <?php } ?>
                                                    <?php if($ID_ESTPRC<=2){ ?>
                                                     <td>
                                                            <input style="width:100%" type="submit" id="BotonRojoProc" value="Rechazar" name="RECHAZAR" onClick="return AdvierteRechazo<?php echo $ID_ARCPRC;?>('frmreg<?php echo $ID_ARCPRC;?>')">
                                                    </td>
                                                    <?php } 
                                                    //VERIFICAR ESTADO = 4 PARA GENERACIÓN DE ARCHIVOS DE IMPRESIÓN
                                                    if($ID_ESTPRC==4){
                                                    ?>
                                                     <td>
                                                    <input type="button" style="width:100%" id="BotonVerdeProc" value="Generar Flejes" name="SELECCIONAR"  onClick="paginaPrintGI('reg_flejes_reg.php?GENARC=1&ID_ARCPRC=<?php echo $ID_ARCPRC;?>','<?php echo $NUM_ITEMS?>');">
                                                    </td>
                                                    <?php
                                                    }
                                                    //VERIFICAR ESTADO = 5 PARA CONFIRMAR IMPRESIÓN, 6 PARA ACTIVAR PRECIOS
                                                    if( $ID_ESTPRC==6){
                                                    ?>
                                                     <td>
                                                     <?php
																	$ALL_PRT=1;
																	$SQLV="SELECT * FROM ARC_ITEMS WHERE ID_ARCPRC IN(SELECT ID_ARCPRC FROM ARC_PRC WHERE ID_ARCSAP=".$ID_ARCSAP." AND COD_NEGOCIO=".$COD_NEGOCIO.") ORDER BY ID_ARCITEM ASC";
																	$RSV = sqlsrv_query($conn, $SQLV);
																	//oci_execute($RSV);
																	while ($rowV = sqlsrv_fetch_array($RSV)) {
																			$PRT_EST = $rowV['ESTADO'];
																			if($PRT_EST==0){$ALL_PRT=0;}
																	}
																	if($ALL_PRT==1){ 
																	?>
																	 <input type="button" style="width:100%" id="BotonVerdeProc"  value="Activar Cambio de Precios" name="ACTIVAR"  onClick="paginaActCP('reg_flejes_reg.php?ACTIVAR_CPNEG=1&ID_ARCSAP=<?php echo $ID_ARCSAP;?>&LDN=<?php echo $COD_NEGOCIO;?>');">
																	<?php
																	
																	}	?>
                                                    </td>
													<?php } ?>
                                                    <?php if($ID_ESTPRC>=5){ ?>
															<?php
                                                            //VERIFICAR SI HAY FLEJES PARA IMPRESION
                                                            $PrintFlejes=$CANT_ADD+$CANT_UPD;
                                                            if($PrintFlejes<>0){
                                                            ?>
                                                                         <td>
                                                                        <style>
																		#RegImpFlejes<?php echo $ID_ARCPRC?> {position:absolute; width:100%;height:300%;margin: 0 auto;left: 0;top:0;background-image: url(images/TranspaBlack72.png);background-repeat: repeat;background-position: left top;z-index:10000;}
																		#RegImpFlejes-contenedor<?php echo $ID_ARCPRC?> {position:absolute;width:auto;height:auto; max-width:890px; min-width:400px; overflow:visible;left: 100px;top:50px;padding-top:16px;padding-bottom:20px;padding-left:20px;padding-right:20px;background-color:#444;color:#F1F1F1; text-shadow:none; border:1px solid #FFCC00; -khtml-border-radius: 6px;-moz-border-radius: 6px;-webkit-border-radius: 6px;border-radius: 6px;}
                                                                        </style>
                                                                        <script>
                                                                             function ActivarVentFlejes<?php echo $ID_ARCPRC?>(){
                                                                                    var contenedor = document.getElementById("RegImpFlejes<?php echo $ID_ARCPRC?>");
                                                                                    contenedor.style.display = "block";
                                                                                    return true;
                                                                                }
                                                                                
                                                                             function CerrarVentFlejes<?php echo $ID_ARCPRC?>(){
                                                                                    var contenedor = document.getElementById("RegImpFlejes<?php echo $ID_ARCPRC?>");
                                                                                    contenedor.style.display = "none";
                                                                                    return true;
                                                                                }
                                                                        </script>
                                                                        <?php
                                                                        //VERIFICA SI RESTAN ARCHIVOS DE IMPRESION (POR ESTADO)
                                                                        $ALL_PRT=1;
                                                                        $SQLV="SELECT * FROM ARC_ITEMS WHERE ID_ARCPRC=".$ID_ARCPRC." ORDER BY ID_ARCITEM ASC";
                                                                        $RSV = sqlsrv_query($conn, $SQLV);
                                                                        //oci_execute($RSV);
                                                                        while ($rowV = sqlsrv_fetch_array($RSV)) {
                                                                                $PRT_EST = $rowV['ESTADO'];
                                                                                if($PRT_EST==0){$ALL_PRT=0;}
                                                                        }
                                                                        if($ALL_PRT==0){ $StyleBT="ComandaBot";}
                                                                        if($ALL_PRT==1){ $StyleBT="ReComandaBot";}
                    
                                                                        ?>
                                                                        <input type="button" id="<?php echo $StyleBT?>" value="Flejes" name="SELECCIONAR" onClick="ActivarVentFlejes<?php echo $ID_ARCPRC?>();">
                                                                        </td>
                                                            <?php
                                                            }//$PrintFlejes<>0
                                                    }//$ID_ESTPRC>=5
                                                    ?>
                                                    <?php
                                                    if($ID_ESTPRC==3){
                                                    ?>
                                                     <td></td>
                                                    <?php
                                                    }
                                                    ?>
                     		</tr>
                     </table>
                    <div id="RegImpFlejes<?php echo $ID_ARCPRC?>" style="display:none">
                        <div id="RegImpFlejes-contenedor<?php echo $ID_ARCPRC?>">
                                <span style="position:absolute; top:0; right:10px;"><a href="#" onClick="javascript: CerrarVentFlejes<?php echo $ID_ARCPRC?>();" title="Cerrar ventana"><img src="../images/ICO_CloseYL.png" border="0"></a></span>
                                <h3>Imprime Flejes de Actualizaci&oacute;n de Precios</h3>
                                <p style="margin-bottom:20px; margin-top:0; font-size:12pt">Lote <?php echo $NUM_LOTE?>: <?php echo $DES_NEGOCIO?> - <?php echo " L".substr("0000".$COD_TIENDA, -4)?><br><?php echo $DES_TIENDA?><br>Departamento: <?php echo $NM_DPT_PS?></p>
                                <?php
								//SELECCIONA EL O LOS ARCHIVOS ASOCIADOS PARA IMPRESION
								$NUM_ARCHIVO=1;
								$SQLA="SELECT * FROM ARC_ITEMS WHERE ID_ARCPRC=".$ID_ARCPRC." ORDER BY ID_ARCITEM ASC";
								$RSA = sqlsrv_query($conn, $SQLA);
								//oci_execute($RSA);
								while ($rowA = sqlsrv_fetch_array($RSA)) {
										$ID_ARCITEM = $rowA['ID_ARCITEM'];
										$ARCHIVO = $rowA['ARCHIVO'];
										$ESTADO = $rowA['ESTADO'];
										$ELARCHIVO = "_arc_prt/".$ARCHIVO;
										@$lines = file($ELARCHIVO);
										$NUM_FLEJES = count($lines);
										if($ESTADO==0){
										?>
                                                <input type="button" id="PrintBot" value="Imprime Flejes <?php echo "\nCant.: ".substr("0000".$NUM_FLEJES, -4);?>" name="SELECCIONAR"  onClick="paginaPrintCP('reg_flejes_reg.php?PRTFLJ=1&ID_ARCITEM=<?php echo $ID_ARCITEM;?>');">
										<?php
										}
										if($ESTADO==1){
										?>
                                                <input type="button" id="RePrintBot" value="Re-Imprime Flejes <?php echo "\nCant.: ".substr("0000".$NUM_FLEJES, -4);?>" name="SELECCIONAR"  onClick="paginaPrintCP('reg_flejes_reg.php?PRTFLJ=2&ID_ARCITEM=<?php echo $ID_ARCITEM;?>');">
										<?php
										}
									$NUM_ARCHIVO=$NUM_ARCHIVO+1;
								}
							?>
                        </div>
                    </div>
                     <!-- FIN TABLA ACCIONES -->
                     </td>
                     <td style="vertical-align:middle; text-align:center"><?php echo date_format($FEC_PROC,"d-m-Y")?></td>
                </tr>
                </form>
                <?php }?>
                <tr>
                    <td colspan="15" nowrap style="background-color:transparent">
                    <?php
                    if ($LINF>=$CTP+1) {
						$ATRAS=$LINF-$CTP;
						$FILA_ANT=$LSUP-$CTP;
                   ?>
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('reg_precios.php?LSUP=<?php echo $FILA_ANT?>&LINF=<?php echo $ATRAS?>&LOTE=<?php echo $LOTE?>&LDN=<?php echo $LDN?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('reg_precios.php?LSUP=<?php echo $FILA_POS?>&LINF=<?php echo $ADELANTE?>&LOTE=<?php echo $LOTE?>&LDN=<?php echo $LDN?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina <?php echo $NUMPAG?> de <?php echo $NUMTPAG?></span>
                </td>
                </tr>
                </table>
        <?php }//if($LOTE!=""){?>

