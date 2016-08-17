
<?php if(!empty($ARTSNEG)){
				//ID_ARCSAP=ARTSNEG
				//OBTENER TODOS LOS ARCHIVOS DE LOTE POR NEGOCIO (LDN)
				$SQLN="SELECT * FROM ARC_SAP WHERE ID_ARCSAP=".$ARTSNEG;
				$RSN = sqlsrv_query($conn, $SQLN);
				//oci_execute($RSN);
				if ($rowN = sqlsrv_fetch_array($RSN)) {
					$COD_TIENDA = $rowN['COD_TIENDA'];
					$NUM_LOTE= $rowN['NUM_LOTE'];
				}
				$SQLN="SELECT * FROM ARC_PRC WHERE ID_ARCSAP=".$ARTSNEG." AND COD_NEGOCIO=".$LDN." AND ID_ESTPRC<>3 ORDER BY CD_DPT_PS ASC";
				$RSN = sqlsrv_query($conn, $SQLN);
				//oci_execute($RSN);
				//DEFINE ARREGLO LOTES
				$aLotes=array();
				$aExcepciones=array();
				$NUM_ARTICULOS=0;
				$REG_EXCEP=0;
				while ($rowN = sqlsrv_fetch_array($RSN)) {
					$ID_ARCPRC = $rowN['ID_ARCPRC'];
					$EST_LOTE = $rowN['ID_ESTPRC'];
					$NMB_LOTE = $rowN['NOM_ARCLOTE'];
					$COD_LDN = $rowN['COD_NEGOCIO'];
					$NUM_ITLOTE = $rowN['NUM_ITEMS'];
					$NUM_ARTICULOS=$NUM_ARTICULOS+$NUM_ITLOTE;
					//ARCHIVO DE EXCEPCIONES
							$SQLE="SELECT * FROM ARC_PRCEX WHERE ID_ARCPRC=".$ID_ARCPRC;
							$RSE = sqlsrv_query($conn, $SQLE);
							//oci_execute($RSE);
							if ($rowE = sqlsrv_fetch_array($RSE)) {
								$NMB_EXCEP = $rowE['NOM_ARCEX'];
								$REG_EXCEP=1;
							}
					//$DIRARCNEG="_arc_tmp/".substr("000".$COD_TIENDA, -3)."_".substr("0000".$NUM_LOTE, -4)."/";
					
					
					
					if($EST_LOTE>7){$DIR_LOTE="/BKP/";}
					if($EST_LOTE==7){$DIR_LOTE="/PRC/";}
					if($EST_LOTE<7){$DIR_LOTE="/IN/";}
					if($EST_LOTE==3){$DIR_LOTE="/BKP/";}
					//CAPTURAR
					$CapturaLote=file_get_contents($DIR_SAP.$DIR_LOTE.$NMB_LOTE);
					$CapturaExcep=file_get_contents($DIR_SAP.$DIR_LOTE.$NMB_EXCEP);

					//$CapturaLote=file_get_contents($DIRARCNEG.$NMB_LOTE);
					//$CapturaExcep=file_get_contents($DIRARCNEG.$NMB_EXCEP);
					//ARREGLO DE CAPTURA
					$aCaptLote = array_values(array_filter(explode("\n",$CapturaLote)));
					$aCaptExcep = array_values(array_filter(explode("\n",$CapturaExcep)));
					//LLENAR ARREGLO LOTE
						$LineaCapLote=0;				
						foreach ($aCaptLote as &$LineCLote) {
							$LineaCapLote=$LineaCapLote+1;
							array_push($aLotes, $ID_ARCPRC."|".$LineaCapLote."|".$LineCLote);
						}				
						$LineaCapExcep=0;				
						foreach ($aCaptExcep as &$LineCExcep) {
							array_push($aExcepciones, $ID_ARCPRC."|".$LineCExcep);
						}				
				}
				$NUM_ARTICULOS_F=number_format($NUM_ARTICULOS, 0, ',', '.');
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

								<?php if($REG_EXCEP==1) {?>
                                        <input type="button"value="Excepciones" name="LISTADO" onClick="pagina('reg_precios.php?EXCEPNEG=<?php echo $ARTSNEG;?>&LDN=<?php echo $LDN;?>&ND=1');">
                                <?php }?>
                                <input type="button" name="LISTADO" value="Volver" onClick="pagina('reg_precios.php?VLTE=<?php echo $ARTSNEG;?>&ND=1');">
                                <h3>Lista de Art&iacute;culos en Lote <?php echo $NUM_LOTE?> / <?php echo $NUM_ARTICULOS_F?> Art&iacute;culos </h3>
                                <h3><?php echo $DES_NEGOCIO?> - L<?php echo substr("0000".$COD_TIENDA, -4).", ".$DES_TIENDA?></h3>
								<table id="Listado">
								<tr>
									<th colspan="2">Acc.</th>
									<th>Art&iacute;culo</th>
									<th style="text-align:right">C&oacute;digo CER</th>
									<th style="text-align:right">C&oacute;digo EAN</th>
									<th style="text-align:right">Precio</th>
								</tr>
								<?php 
								$iTotalResultados = count($aLotes); 
								$iResultadosPorPagina = 50; 
								$iPaginasTotales = ceil($iTotalResultados / $iResultadosPorPagina);  
								$iPagina =(!isset($_GET['p']))?1:$_GET['p']; 
								$iPosicion = ($iPagina - 1) * $iResultadosPorPagina; 
								for($i=0;$i< $iResultadosPorPagina ;$i++){ 
												if(isset($aLotes[$iPosicion])) 
												
												$PosInicio=strrpos($aLotes[$iPosicion], '|', 0)+1;
												
												$COLORELM="";
												@$ACCI_ART=substr($aLotes[$iPosicion], $PosInicio, 1);
												if($ACCI_ART=="A"){$ACCION="Agregar";}
												if($ACCI_ART=="U"){$ACCION="Actualizar";}
												if($ACCI_ART=="D"){$ACCION="Retirar";}
												if($ACCI_ART=="X"){
													$ACCION="Eliminado";
													$COLORELM="; background-color:#F44336; color: #FFF";
												}
														//EXCEPCIONES
														//IDENTIFICAR ID_ARCPRC Y NUMERO DE LINEA
														@$PosPalUno = strpos($aLotes[$iPosicion], '|');
														@$IDArcprc = substr($aLotes[$iPosicion], 0, $PosPalUno);
														@$PosPalDos = strrpos($aLotes[$iPosicion], '|');
														@$LenNumLin = $PosPalDos-$PosPalUno;
														@$NumLinPrc = substr($aLotes[$iPosicion], $PosPalUno+1, $LenNumLin-1);

														//OBTIENE ARCHIVO DE EXCEPCIONES
																$TD_STYLE="";
																$SQLF="SELECT * FROM ARC_PRCEX WHERE ID_ARCPRC=".$IDArcprc;

																$RSF = sqlsrv_query($conn, $SQLF);
																//oci_execute($RSF);
																if ($rowF = @sqlsrv_fetch_array($RSF)) {
																	@$ARC_EXCEP = $rowF['NOM_ARCEX'];
																	//ARCHIVO DE EXCEPCIONES --> STRING
																	@$ArcExcep = file_get_contents($DIRARCNEG.$ARC_EXCEP);
																	@$bExcepcion="000000".$NumLinPrc;
																	@$iExcepcion=substr($bExcepcion, -6); 
																	@$Buscar = $ACCI_ART.$iExcepcion;
																	@$Encuentra= strstr($ArcExcep, $ACCI_ART.$iExcepcion);
																	if (!empty($Encuentra)) {
																		$TD_STYLE="background-color:#FFB300; color:#FFF; font-weight:600;";
																		if($ACCI_ART=="A"){$ACCION="Agregar (Art. Registrado)";}
																		if($ACCI_ART=="U"){$ACCION="Actualizar (Art. No Existe)";}
																		if($ACCI_ART=="D"){$ACCION="Retirar (Art. No Existe)";}
																	}
																}

												@$PREC_ART=substr($aLotes[$iPosicion], $PosInicio+38, 8);
												@$PREC_ART=(int)$PREC_ART;
												@$PREC_ART_F=$PREC_ART/$DIVCENTS;
												@$PREC_ART_F=number_format($PREC_ART_F, $CENTS, $GLBSDEC, $GLBSMIL);

												@$CODIGO_CER = (int)(substr($aLotes[$iPosicion], $PosInicio+1, 12));
												@$CODIGO_EAN = (int)(substr($aLotes[$iPosicion], $PosInicio+248, 12));
												if($CODIGO_EAN==0){$CODIGO_EAN="No registra EAN";}
												
												if($iPosicion<$iTotalResultados){
														?>
														<tr>
															<td style="text-align:right; <?php echo $TD_STYLE;?><?php echo $COLORELM;?>"><?php echo $iPosicion+1;?></td>
															<td style="text-align:left<?php echo $COLORELM;?>"><?php echo $ACCION;?></td>
															<td style="text-align:left<?php echo $COLORELM;?>"><?php echo substr($aLotes[$iPosicion], $PosInicio+86, 40);?></td>
															<td style="text-align:right<?php echo $COLORELM;?>"><?php echo $CODIGO_CER;?></td>
															<td style="text-align:right<?php echo $COLORELM;?>"><?php echo $CODIGO_EAN;?></td>
															<td style="text-align:right<?php echo $COLORELM;?>"><?php echo $MONEDA.$PREC_ART_F;?></td>
														</tr>
														<?php
												}
												$iPosicion++; 
												$Buscar="";
												$Encuentra="";
								} 
								?> 
												<tr>
													<td colspan="6" id="PaginaItem">
												<?php 
														if (($iPagina - 1)>0) {
														?>
														 <input type="button" name="ANTE" value="Anterior" onClick="pagina('reg_precios.php?p=<?php echo $iPagina - 1 ?>&ARTSNEG=<?php echo $ARTSNEG?>&LDN=<?php echo $LDN?>');">
														 <?php
														}
														if (($iPagina)<$iPaginasTotales) {
														?>
														 <input type="button" name="SIGE" value="Siguiente" onClick="pagina('reg_precios.php?p=<?php echo $iPagina + 1 ?>&ARTSNEG=<?php echo $ARTSNEG?>&LDN=<?php echo $LDN?>');">
														 <?php
														}
												?> 
													</td>
												</tr>
								</table>



<?php
}///$ARTSNEG
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
?>


<?php if(!empty($EXCEPNEG)){
				//ID_ARCSAP=EXCEPNEG
				//OBTENER TODOS LOS ARCHIVOS DE EXCEPCION POR NEGOCIO (LDN)
				$SQLN="SELECT * FROM ARC_SAP WHERE ID_ARCSAP=".$EXCEPNEG;
				$RSN = sqlsrv_query($conn, $SQLN);
				//oci_execute($RSN);
				if ($rowN = sqlsrv_fetch_array($RSN)) {
					$COD_TIENDA = $rowN['COD_TIENDA'];
					$NUM_LOTE= $rowN['NUM_LOTE'];
				}
				$SQLN="SELECT * FROM ARC_PRC WHERE ID_ARCSAP=".$EXCEPNEG." AND COD_NEGOCIO=".$LDN." AND ID_ESTPRC<>3 AND ID_ARCPRC IN(SELECT ID_ARCPRC FROM ARC_PRCEX) ORDER BY CD_DPT_PS ASC";
				$RSN = sqlsrv_query($conn, $SQLN);
				//oci_execute($RSN);
				//DEFINE ARREGLO LOTES
				$aExcepciones=array();
				$NUM_EXCEPCIONES=0;
				while ($rowN = sqlsrv_fetch_array($RSN)) {
					$ID_ARCPRC = $rowN['ID_ARCPRC'];
					$EST_LOTE = $rowN['ID_ESTPRC'];
					$NMB_LOTE = $rowN['NOM_ARCLOTE'];
					$COD_LDN = $rowN['COD_NEGOCIO'];
					//ARCHIVO DE EXCEPCIONES
							$SQLE="SELECT * FROM ARC_PRCEX WHERE ID_ARCPRC=".$ID_ARCPRC;
							$RSE = sqlsrv_query($conn, $SQLE);
							//oci_execute($RSE);
							if ($rowE = sqlsrv_fetch_array($RSE)) {
								$NMB_EXCEP = $rowE['NOM_ARCEX'];
								$NUM_ITEXCE = $rowE['NUM_ITEMS'];
								$NUM_EXCEPCIONES=$NUM_EXCEPCIONES+$NUM_ITEXCE;
							}
					//CAPTURAR
					if($EST_LOTE>7){$DIR_LOTE="/BKP/";}
					if($EST_LOTE==7){$DIR_LOTE="/PRC/";}
					if($EST_LOTE<7){$DIR_LOTE="/IN/";}
					if($EST_LOTE==3){$DIR_LOTE="/BKP/";}
					$CapturaExcep=file_get_contents($DIR_SAP.$DIR_LOTE.$NMB_EXCEP);
					//ARREGLO DE CAPTURA
					$aCaptExcep = array_values(array_filter(explode("\n",$CapturaExcep)));
					//LLENAR ARREGLO EXCEPCIONES
						$LineaCapExcep=0;
						$AuxArcprc=0;
						foreach ($aCaptExcep as &$LineCExcep) {
							if($AuxArcprc<>$ID_ARCPRC){$LineaCapExcep=1;}
							array_push($aExcepciones, $LineaCapExcep."|".$ID_ARCPRC."|".$LineCExcep);
							$AuxArcprc=$ID_ARCPRC;
							$LineaCapExcep=$LineaCapExcep+1;
						}				
				}
				$NUM_EXCEPCIONES_F=number_format($NUM_EXCEPCIONES, 0, ',', '.');
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
                <input type="button"value="Lista de Art&iacute;culos" name="LISTADO" onClick="pagina('reg_precios.php?ARTSNEG=<?php echo $EXCEPNEG;?>&LDN=<?php echo $LDN;?>');">
                <input type="button" name="LISTADO" value="Volver" onClick="pagina('reg_precios.php?VLTE=<?php echo $EXCEPNEG;?>&ND=1');">
                <h3>Procesar Excepciones en Lote <?php echo $NUM_LOTE?> / <?php echo $NUM_EXCEPCIONES_F?> Excepciones  </h3>
				<h3><?php echo $DES_NEGOCIO?> - L<?php echo substr("0000".$COD_TIENDA, -4).", ".$DES_TIENDA?></h3>
                                <table id="Listado">
                                <tr>
                                    <th colspan="2">Acc.</th>
                                    <th>Procesar Excepci&oacute;n</th>
                                    <th>Art&iacute;culo</th>
                                    <th style="text-align:right">C&oacute;digo CER</th>
                                    <th style="text-align:right">C&oacute;digo EAN</th>
                                    <th style="text-align:right">Precio</th>
                                </tr>
								<?php 
								$iTotalResultados = count($aExcepciones); 
								$iResultadosPorPagina = 50; 
								$iPaginasTotales = ceil($iTotalResultados / $iResultadosPorPagina);  
								$iPagina =(!isset($_GET['p']))?1:$_GET['p']; 
								$iPosicion = ($iPagina - 1) * $iResultadosPorPagina; 
                                for($i=0;$i< $iResultadosPorPagina ;$i++){ 
												if(isset($aExcepciones[$iPosicion])) 

												//IDENTIFICAR ID_ARCPRC Y NUMERO DE LINEA
												@$PosPal01=strpos($aExcepciones[$iPosicion], '|')+1;
												@$PosPal02=strrpos($aExcepciones[$iPosicion], '|');
												
												@$IDArcprc = substr($aExcepciones[$iPosicion], $PosPal01, $PosPal02-($PosPal01));
												@$PosPal = $PosPal+1;

												@$NumLineaLote=(int)(substr($aExcepciones[$iPosicion], $PosPal02+2, 6));
												$NumLineaLote=$NumLineaLote-1; 
												$LineaNEG=$iPosicion+1;

												@$LineaEX=substr($aExcepciones[$iPosicion], 0, $PosPal01-1);
												$LineaLO=$NumLineaLote+1; //ES LA LINEA EN EL ARCHIVO DE LOTES CORRESPONDIENTE
		
												@$ACCI_ART=substr($aExcepciones[$iPosicion], $PosPal02+1, 1); //ACCION DESDE ARCHIVO DE EXCEPCION
												if($ACCI_ART=="A"){$ACCION="Agregar (Art. Registrado)";}
												if($ACCI_ART=="U"){$ACCION="Actualizar (Art. No Existe)";}
												if($ACCI_ART=="D"){$ACCION="Retirar (Art. No Existe)";}
												
												//ARCHIVO DE LOTE
												$SQLL="SELECT NOM_ARCLOTE FROM ARC_PRC WHERE ID_ARCPRC=".$IDArcprc;
												$RSL = sqlsrv_query($conn, $SQLL);
												//oci_execute($RSL);
												if ($rowL = @sqlsrv_fetch_array($RSL)) {
													$ARC_LOTE = $rowL['NOM_ARCLOTE'];
												}
												$ArcLote = file($DIR_SAP.$DIR_LOTE.$ARC_LOTE);
	
												@$PREC_ART=substr($ArcLote[$NumLineaLote], 38, 8);
												$PREC_ART=(int)$PREC_ART;
												$PREC_ART_F=$PREC_ART/$DIVCENTS;
												$PREC_ART_F=number_format($PREC_ART_F, $CENTS, $GLBSDEC, $GLBSMIL);
												
												@$CODIGO_CER = (int)(substr($ArcLote[$NumLineaLote], 1, 12));
												@$CODIGO_EAN = (int)(substr($ArcLote[$NumLineaLote], 248, 12));
												if($CODIGO_EAN==0){$CODIGO_EAN="No registra EAN";}
												
												
												//VERIFICAR SI FUE PROCESADO
												$PROCESADO =0;
												$SQLEX="SELECT * FROM ARC_EXPRC WHERE ID_ARCPRC=".$IDArcprc." AND NUM_LINEX=".$LineaLO;
												$RSEX = sqlsrv_query($conn, $SQLEX);
												//oci_execute($RSEX);
												if ($rowEX = @sqlsrv_fetch_array($RSEX)) {
															$PROCESADO=1;
															$DECIDE = $rowEX['DECIDE'];
															$EXCEPCION = $rowEX['EXCEPCION'];
															if($DECIDE=="N"){
																$ELPROCESO="Retirado";
																$COLOR_TD="#F44336";
															}
															if($DECIDE=="S"){
																$COLOR_TD="#0BA526";
																if($EXCEPCION=="A"){ $ELPROCESO="Activado: Agregar"; }
																if($EXCEPCION=="U"){ $ELPROCESO="Activado: Actualizar"; }
															}
															$IDREG = $rowEX['IDREG'];
															$S2="SELECT NOMBRE FROM US_USUARIOS WHERE IDUSU=".$IDREG;
															$RS2 = sqlsrv_query($maestra, $S2);
															//oci_execute($RS2);
															if ($row2 = sqlsrv_fetch_array($RS2)) {
																$QUIENFUE = $row2['NOMBRE'];
															}	
															$FECHA = $rowEX['FECHA'];
												}

												if($iPosicion<$iTotalResultados){
														?>
														<tr>
															<td style="text-align:right;"><?php echo $LineaNEG;?></td>
                                                            <td><?php echo $ACCION;?></td>
                                                            <?php if($PROCESADO==0){?>
                                                                    <td>
                                                                    <?php if($ACCI_ART!="D"){?>
																	<script>
																		paginaProcesaExcep('reg_precios_reg.php?ACTVEX=1&ID_ARCPRC=<?php echo $IDArcprc;?>&LINEAEX=<?php echo $LineaEX;?>&LINEALO=<?php echo $LineaLO;?>&ACCI_ART=<?php echo $ACCI_ART;?>&p=<?php echo $iPagina?>&NEGDPT=1');
                                                                        
                                                                    </script>
																	
																	<?php }?></td>
															<?php } ?>
                                                            <td><?php echo substr($ArcLote[$NumLineaLote], 86, 40);?></td>
															<td style="text-align:right"><?php echo $CODIGO_CER;?></td>
															<td style="text-align:right"><?php echo $CODIGO_EAN;?></td>
															<td style="text-align:right"><?php echo $MONEDA.$PREC_ART_F;?></td>
														</tr>
														<?php
												}
												$iPosicion++; 
												$Buscar="";
												$Encuentra="";
												$ACCION="";
                                } 
                                ?> 
												<tr>
                                                	<td colspan="9" id="PaginaItem">
												<?php 
														if (($iPagina - 1)>0) {
														?>
                                                         <input type="button" name="ANTE" value="Anterior" onClick="pagina('reg_precios.php?EXCEPNEG=<?php echo $EXCEPNEG?>&p=<?php echo $iPagina - 1 ?>&LDN=<?php echo $LDN?>');">
                                                         <?php
														}
                                                        if (($iPagina)<$iPaginasTotales) {
														?>
														 <input type="button" name="SIGE" value="Siguiente" onClick="pagina('reg_precios.php?EXCEPNEG=<?php echo $EXCEPNEG?>&p=<?php echo $iPagina + 1 ?>&LDN=<?php echo $LDN?>');">
														 <?php
														}
                                                ?> 
                                                    </td>
                                                </tr>
                                </table>
<?php
}//$EXCEPNEG
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
?>







<?php if(!empty($ARTS)){
				$CONSULTA="SELECT * FROM ARC_SAP WHERE ID_ARCSAP=".$LOTART;
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
				<?php
						$SQLF="SELECT * FROM ARC_PRC WHERE ID_ARCPRC=".$ARTS;
						$RSF = sqlsrv_query($conn, $SQLF);
						//oci_execute($RSF);
						if ($rowF = sqlsrv_fetch_array($RSF)) {
							$ARC_LOTE = $rowF['NOM_ARCLOTE'];
							$ID_ESTPRC = $rowF['ID_ESTPRC'];
							$NUM_ITEMS = $rowF['NUM_ITEMS'];
							$CD_DPT_PS = $rowF['CD_DPT_PS'];
						}
						$SQLF="SELECT * FROM ID_DPT_PS WHERE CD_DPT_PS=".$CD_DPT_PS;
						$RSF = sqlsrv_query($arts_conn, $SQLF);
						//oci_execute($RSF);
						if ($rowF = sqlsrv_fetch_array($RSF)) {
							$NM_DPT_PS = $rowF['NM_DPT_PS'];
						}
						//VERIFICAR EXCEPCIONES
						$REG_EXCEP=0;
						$SQLF="SELECT * FROM ARC_PRCEX WHERE ID_ARCPRC=".$ARTS;
						$RSF = sqlsrv_query($conn, $SQLF);
						//oci_execute($RSF);
						if ($rowF = sqlsrv_fetch_array($RSF)) {
							$ARC_EXCEP = $rowF['NOM_ARCEX'];
							$NUM_EXCEP = $rowF['NUM_ITEMS'];
							$REG_EXCEP=1;
						}
						//$DIRLOCAL="_arc_tmp/".substr("000".$COD_TIENDA, -3)."_".substr("0000".$NUM_LOTE, -4)."/";
						if($ID_ESTPRC>7){$DIR_LOTE="/BKP/";}
						if($ID_ESTPRC==7){$DIR_LOTE="/PRC/";}
						if($ID_ESTPRC<7){$DIR_LOTE="/IN/";}
						if($ID_ESTPRC==3){$DIR_LOTE="/BKP/";}
						$DIRLOCAL=$DIR_SAP.$DIR_LOTE;
						$NUM_ITEMS_F=number_format($NUM_ITEMS, 0, ',', '.');
				?>		
                <?php if($REG_EXCEP==1 and $ID_ESTPRC<>3) {?>
                		<input type="button"value="Excepciones" name="LISTADO" onClick="pagina('reg_precios.php?EXCEP=<?php echo $ARTS;?>&LOTART=<?php echo $LOTART;?>&LDN=<?php echo $LDN;?>');">
                <?php }?>
                <input type="button" name="LISTADO" value="Volver" onClick="pagina('reg_precios.php?LOTE=<?php echo $LOTART;?>&LDN=<?php echo $LDN;?>');">
                <h3>Lista de Art&iacute;culos en Lote <?php echo $NUM_LOTE?> / <?php echo $NUM_ITEMS_F?> Art&iacute;culos
                </h3>
				<h3><?php echo $DES_NEGOCIO?> - L<?php echo substr("0000".$COD_TIENDA, -4).", ".$DES_TIENDA?>: <?php echo $NM_DPT_PS?> </h3>
                                <?php
									//ARCHIVO DE EXCEPCIONES --> STRING
									@$ArcExcep = file_get_contents($DIRLOCAL.$ARC_EXCEP);
																			
								?>
                                <table id="Listado">
                                <tr>
                                    <th colspan="2">Acc.</th>
                                    <th>Art&iacute;culo</th>
                                    <th style="text-align:right">C&oacute;digo CER</th>
                                    <th style="text-align:right">C&oacute;digo EAN</th>
                                    <th style="text-align:right">Precio</th>
                                </tr>
								<?php 
								
                                @$f = file_get_contents($DIRLOCAL.$ARC_LOTE); 
                                $aTexto =array_values(array_filter(explode("\n",$f))); 
                                $iTotalResultados = count($aTexto); 
                                $iResultadosPorPagina = 50; 
                                $iPaginasTotales = ceil($iTotalResultados / $iResultadosPorPagina);  
                                $iPagina =(!isset($_GET['p']))?1:$_GET['p']; 
                                $iPosicion = ($iPagina - 1) * $iResultadosPorPagina; 
                                for($i=0;$i< $iResultadosPorPagina ;$i++){ 
												if(isset($aTexto[$iPosicion])) 
												
												$COLORELM="";
												@$ACCI_ART=substr($aTexto[$iPosicion], 0, 1);
												if($ACCI_ART=="A"){$ACCION="Agregar";}
												if($ACCI_ART=="U"){$ACCION="Actualizar";}
												if($ACCI_ART=="D"){$ACCION="Retirar";}
												if($ACCI_ART=="X"){
													$ACCION="Eliminado";
													$COLORELM="; background-color:#F44336; color: #FFF";
												}

														$NumLinea=$iPosicion+1;
														$bExcepcion="000000".$NumLinea;
														$iExcepcion=substr($bExcepcion, -6); 
														$Buscar = $ACCI_ART.$iExcepcion;
														$Encuentra= strstr($ArcExcep, $ACCI_ART.$iExcepcion);
														if (!empty($Encuentra)) {
															$TD_STYLE="background-color:#FFB300; color:#FFF; font-weight:600;";
															if($ACCI_ART=="A"){$ACCION="Agregar (Art. Registrado)";}
															if($ACCI_ART=="U"){$ACCION="Actualizar (Art. No Existe)";}
															if($ACCI_ART=="D"){$ACCION="Retirar (Art. No Existe)";}
														} else {
															$TD_STYLE="";
														}

												@$PREC_ART=substr($aTexto[$iPosicion], 38, 8);
												$PREC_ART=(int)$PREC_ART;
												$PREC_ART_F=$PREC_ART/$DIVCENTS;
												$PREC_ART_F=number_format($PREC_ART_F, $CENTS, $GLBSDEC, $GLBSMIL);

												@$CODIGO_CER = (int)(substr($aTexto[$iPosicion], 1, 12));
												@$CODIGO_EAN = (int)(substr($aTexto[$iPosicion], 248, 12));
												if($CODIGO_EAN==0){$CODIGO_EAN="No registra EAN";}
												
												if($iPosicion<$iTotalResultados){
														?>
														<tr>
															<td style="text-align:right; <?php echo $TD_STYLE;?><?php echo $COLORELM;?>"><?php echo $iPosicion+1;?></td>
															<td style="text-align:left<?php echo $COLORELM;?>"><?php echo $ACCION;?></td>
															<td style="text-align:left<?php echo $COLORELM;?>"><?php echo substr($aTexto[$iPosicion], 86, 40);?></td>
															<td style="text-align:right<?php echo $COLORELM;?>"><?php echo $CODIGO_CER;?></td>
															<td style="text-align:right<?php echo $COLORELM;?>"><?php echo $CODIGO_EAN;?></td>
															<td style="text-align:right<?php echo $COLORELM;?>"><?php echo $MONEDA.$PREC_ART_F;?></td>
														</tr>
														<?php
												}
												$iPosicion++; 
												$Buscar="";
												$Encuentra="";
                                } 
                                ?> 
												<tr>
                                                	<td colspan="6" id="PaginaItem">
												<?php 
														if (($iPagina - 1)>0) {
														?>
                                                         <input type="button" name="ANTE" value="Anterior" onClick="pagina('reg_precios.php?ARTS=<?php echo $ARTS?>&p=<?php echo $iPagina - 1 ?>&LOTART=<?php echo $LOTART?>&LDN=<?php echo $LDN?>');">
                                                         <?php
														}
                                                        if (($iPagina)<$iPaginasTotales) {
														?>
														 <input type="button" name="SIGE" value="Siguiente" onClick="pagina('reg_precios.php?ARTS=<?php echo $ARTS?>&p=<?php echo $iPagina + 1 ?>&LOTART=<?php echo $LOTART?>&LDN=<?php echo $LDN?>');">
														 <?php
														}
                                                ?> 
                                                    </td>
                                                </tr>
                                </table>
<?php
}//$ARTS
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
?>









<?php if(!empty($EXCEP)){
				$CONSULTA="SELECT * FROM ARC_SAP WHERE ID_ARCSAP=".$LOTART;
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
				<?php
						$SQLF="SELECT * FROM ARC_PRC WHERE ID_ARCPRC=".$EXCEP;
						$RSF = sqlsrv_query($conn, $SQLF);
						//oci_execute($RSF);
						if ($rowF = sqlsrv_fetch_array($RSF)) {
							$ARC_LOTE = $rowF['NOM_ARCLOTE'];
							$ID_ESTPRC = $rowF['ID_ESTPRC'];
							$NUM_ITEMS = $rowF['NUM_ITEMS'];
							$CD_DPT_PS = $rowF['CD_DPT_PS'];
						}
						$SQLF="SELECT * FROM ID_DPT_PS WHERE CD_DPT_PS=".$CD_DPT_PS;
						$RSF = sqlsrv_query($arts_conn, $SQLF);
						//oci_execute($RSF);
						if ($rowF = sqlsrv_fetch_array($RSF)) {
							$NM_DPT_PS = $rowF['NM_DPT_PS'];
						}
						//VERIFICAR EXCEPCIONES
						$SQLF="SELECT * FROM ARC_PRCEX WHERE ID_ARCPRC=".$EXCEP;
						$RSF = sqlsrv_query($conn, $SQLF);
						//oci_execute($RSF);
						if ($rowF = sqlsrv_fetch_array($RSF)) {
							$ARC_EXCEP = $rowF['NOM_ARCEX'];
							$NUM_EXCEP = $rowF['NUM_ITEMS'];
						}
						
						//$DIRLOCAL="_arc_tmp/".substr("000".$COD_TIENDA, -3)."_".substr("0000".$NUM_LOTE, -4)."/";
						if($ID_ESTPRC>7){$DIR_LOTE="/BKP/";}
						if($ID_ESTPRC==7){$DIR_LOTE="/PRC/";}
						if($ID_ESTPRC<7){$DIR_LOTE="/IN/";}
						if($ID_ESTPRC==3){$DIR_LOTE="/BKP/";}
						$DIRLOCAL=$DIR_SAP.$DIR_LOTE;
						
						$NUM_ITEMS_F=number_format($NUM_ITEMS, 0, ',', '.');
						$NUM_EXCEP_F=number_format($NUM_EXCEP, 0, ',', '.');
						

				?>		
                <input type="button"value="Lista de Art&iacute;culos" name="LISTADO" onClick="pagina('reg_precios.php?ARTS=<?php echo $EXCEP;?>&LOTART=<?php echo $LOTART;?>&LDN=<?php echo $LDN;?>');">
                <input type="button" name="LISTADO" value="Volver" onClick="pagina('reg_precios.php?LOTE=<?php echo $LOTART;?>&LDN=<?php echo $LDN;?>');">
                <h3>Procesar Excepciones en Lote <?php echo $LOTE?> / <?php echo $NUM_EXCEP_F?> Excepciones 
                </h3>
				<h3><?php echo $DES_NEGOCIO?> - L<?php echo substr("0000".$COD_TIENDA, -4).", ".$DES_TIENDA?>: <?php echo $NM_DPT_PS?> </h3>
                                <?php
									//ARCHIVO DE EXCEPCIONES --> STRING
									$ArcExcep = file_get_contents($DIRLOCAL.$ARC_EXCEP);
									//ARCHIVO DE LOTE --> ARREGLO
									$ArcLote = file($DIRLOCAL.$ARC_LOTE);
																			
								?>
                                <table id="Listado">
                                <tr>
                                    <th colspan="2">Acc.</th>
                                    <th>Procesar Excepci&oacute;n</th>
                                    <th>Art&iacute;culo</th>
                                    <th style="text-align:right">C&oacute;digo CER</th>
                                    <th style="text-align:right">C&oacute;digo EAN</th>
                                    <th style="text-align:right">Precio</th>
                                </tr>
								<?php 
								
                                $f = file_get_contents($DIRLOCAL.$ARC_EXCEP); 
                                $aTexto =array_values(array_filter(explode("\n",$f))); 
                                $iTotalResultados = count($aTexto); 
                                $iResultadosPorPagina = 50; 
                                $iPaginasTotales = ceil($iTotalResultados / $iResultadosPorPagina);  
                                $iPagina =(!isset($_GET['p']))?1:$_GET['p']; 
                                $iPosicion = ($iPagina - 1) * $iResultadosPorPagina; 
                                for($i=0;$i< $iResultadosPorPagina ;$i++){ 
												if(isset($aTexto[$iPosicion])) 
												$NumLineaLote=(int)(substr($aTexto[$iPosicion], 1, 6));
												$NumLineaLote=$NumLineaLote-1;
		
												@$ACCI_ART=substr($aTexto[$iPosicion], 0, 1);
												if($ACCI_ART=="A"){$ACCION="Agregar";}
												if($ACCI_ART=="U"){$ACCION="Actualizar";}
												if($ACCI_ART=="D"){$ACCION="Retirar";}

														@$NumLinea=(int)(substr($aTexto[$iPosicion], 1, 6));
														$bExcepcion="000000".$NumLinea;
														$iExcepcion=substr($bExcepcion, -6); 
														$Buscar = $ACCI_ART.$iExcepcion;
														$Encuentra= strstr($ArcExcep, $ACCI_ART.$iExcepcion);
														if (!empty($Encuentra)) {
															$TD_STYLE="background-color:#FFB300; color:#FFF; font-weight:600;";
															if($ACCI_ART=="A"){$ACCION="Agregar (Art. Registrado)";}
															if($ACCI_ART=="U"){$ACCION="Actualizar (Art. No Existe)";}
															if($ACCI_ART=="D"){$ACCION="Retirar (Art. No Existe)";}
														} else {
															$TD_STYLE="";
														}

	
												@$PREC_ART=substr($ArcLote[$NumLineaLote], 38, 8);
												$PREC_ART=(int)$PREC_ART;
												$PREC_ART_F=$PREC_ART/$DIVCENTS;
												$PREC_ART_F=number_format($PREC_ART_F, $CENTS, $GLBSDEC, $GLBSMIL);
												
												@$CODIGO_CER = (int)(substr($ArcLote[$NumLineaLote], 1, 12));
												@$CODIGO_EAN = (int)(substr($ArcLote[$NumLineaLote], 248, 12));
												if($CODIGO_EAN==0){$CODIGO_EAN="No registra EAN";}
												
												$LineaEX=$iPosicion+1;
												$LineaLO=$NumLineaLote+1;
												
												//VERIFICAR SI FUE PROCESADO
												$PROCESADO =0;
												$SQLEX="SELECT * FROM ARC_EXPRC WHERE ID_ARCPRC=".$EXCEP." AND NUM_LINEX=".$LineaEX;
												$RSEX = sqlsrv_query($conn, $SQLEX);
												//oci_execute($RSEX);
												if ($rowEX = sqlsrv_fetch_array($RSEX)) {
															$PROCESADO=1;
															$DECIDE = $rowEX['DECIDE'];
															$EXCEPCION = $rowEX['EXCEPCION'];
															if($DECIDE=="N"){
																$ELPROCESO="Retirado";
																$COLOR_TD="#F44336";
															}
															if($DECIDE=="S"){
																$COLOR_TD="#0BA526";
																if($EXCEPCION=="A"){ $ELPROCESO="Activado: Agregar"; }
																if($EXCEPCION=="U"){ $ELPROCESO="Activado: Actualizar"; }
															}
															$IDREG = $rowEX['IDREG'];
															$S2="SELECT NOMBRE FROM US_USUARIOS WHERE IDUSU=".$IDREG;
															$RS2 = sqlsrv_query($maestra, $S2);
															//oci_execute($RS2);
															if ($row2 = sqlsrv_fetch_array($RS2)) {
																$QUIENFUE = $row2['NOMBRE'];
															}	
															$FECHA = $rowEX['FECHA'];
												}

												if($iPosicion<$iTotalResultados){
														?>
														<tr>
															<td style="text-align:right; <?php echo $TD_STYLE;?>"><?php echo $LineaLO;?></td>
                                                            <td><?php echo $ACCION;?></td>
                                                            <?php if($PROCESADO==0){?>
                                                                    <td>
                                                                    <?php if($ACCI_ART!="D"){?><script>paginaProcesaExcep('reg_precios_reg.php?ACTVEX=1&ID_ARCPRC=<?php echo $EXCEP;?>&LINEAEX=<?php echo $LineaEX;?>&LINEALO=<?php echo $LineaLO;?>&ACCI_ART=<?php echo $ACCI_ART;?>&p=<?php echo $iPagina?>'); </script><?php }?></td>
															<?php } ?>
                                                            <td><?php echo substr($ArcLote[$NumLineaLote], 86, 40);?></td>
															<td style="text-align:right"><?php echo $CODIGO_CER;?></td>
															<td style="text-align:right"><?php echo $CODIGO_EAN;?></td>
															<td style="text-align:right"><?php echo $MONEDA.$PREC_ART_F;?></td>
														</tr>
														<?php
												}
												$iPosicion++; 
												$Buscar="";
												$Encuentra="";
												$ACCION="";
                                } 
                                ?> 
												<tr>
                                                	<td colspan="9" id="PaginaItem">
												<?php 
														if (($iPagina - 1)>0) {
														?>
                                                         <input type="button" name="ANTE" value="Anterior" onClick="pagina('reg_precios.php?EXCEP=<?php echo $EXCEP?>&p=<?php echo $iPagina - 1 ?>&LOTART=<?php echo $LOTART?>&LDN=<?php echo $LDN?>');">
                                                         <?php
														}
                                                        if (($iPagina)<$iPaginasTotales) {
														?>
														 <input type="button" name="SIGE" value="Siguiente" onClick="pagina('reg_precios.php?EXCEP=<?php echo $EXCEP?>&p=<?php echo $iPagina + 1 ?>&LOTART=<?php echo $LOTART?>&LDN=<?php echo $LDN?>');">
														 <?php
														}
                                                ?> 
                                                    </td>
                                                </tr>
                                </table>
<?php
}//$EXCEP
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
?>


