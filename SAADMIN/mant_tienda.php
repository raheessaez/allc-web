<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
//13/01/2015
$PAGINA=1113;
$LISTAR=1;
$LIST=@$_GET["LIST"];
$NEO=@$_GET["NEO"];
$ACT=@$_GET["ACT"];
if ($NEO=="" and $ACT=="") {
	$LIST=1;
}
$FILTRO_NEGOCIO="";
	$FNEGOCI=@$_POST["FNEGOCI"];
	if (empty($FNEGOCI)) { $FNEGOCI=@$_GET["FNEGOCI"] ;}
	if (empty($FNEGOCI)) { $FNEGOCI=999;}
	if ($FNEGOCI!=999) {
		$FILTRO_NEGOCIO=" AND COD_TIENDA IN(SELECT COD_TIENDA FROM MN_NEGTND WHERE COD_NEGOCIO=".$FNEGOCI.") " ;
	}
	$FILTRO_CIUDAD="";
	$FCIUDAD=@$_POST["FCIUDAD"];
	if (empty($FCIUDAD)) { $FCIUDAD=@$_GET["FCIUDAD"] ;}
	if (empty($FCIUDAD)) { $FCIUDAD=0 ;}
	if ($FCIUDAD!=0) {
		$FILTRO_CIUDAD=" AND COD_CIUDAD=".$FCIUDAD ;
	}
	$FILTRO_ESTADO="";
	$FESTADO=@$_POST["FESTADO"];
	if (empty($FESTADO)) { $FESTADO=@$_GET["FESTADO"] ;}
	if (empty($FESTADO)) { $FESTADO=0 ;}
	if ($FESTADO==1) {$FILTRO_ESTADO=" AND IND_ACTIVO=1 "; }
	if ($FESTADO==2) {$FILTRO_ESTADO=" AND IND_ACTIVO=0 "; }
	$FILTRO_NOMB="";
	$BLOCAL=trim(strtoupper(@$_POST["BLOCAL"]));
	if (empty($BLOCAL)) { $BLOCAL=trim(strtoupper(@$_GET["BLOCAL"])) ;}
	if ($BLOCAL<>"") {$FILTRO_NOMB=" AND (UPPER(LTRIM(DES_TIENDA)) Like '%".strtoupper($BLOCAL)."%' OR DES_CLAVE Like '%".strtoupper($BLOCAL)."%')"; }
?>

</head>
<body onLoad="aplica_recargo()">
<?php include("encabezado.php");?>
<?php include("titulo_menu.php");?>
<table width="100%" height="100%">
	<tr>
		<td align="right"  width="200" bgcolor="#FFFFFF"><?php include("menugeneral.php");?></td>
		<td >
			<?php
			if ($MSJE==1) {
				$ELMSJ="Registro actualizado";
			}
			if ($MSJE == 2) {
				$ELMSJ="Nombre no disponible, verifique";
			}
			if ($MSJE == 3) {
				$ELMSJ="Registro realizado";
			}
			if ($MSJE==7) {
				$ELMSJ="No se han encontrado coincidencias, por favor, intente nuevamente";
			}
			if ($MSJE <> "") {
				?>
				<div id="GMessaje" onClick="QuitarGMessage();"><a href="#" onClick="QuitarGMessage();" style="color:#111111;"><?php echo $ELMSJ?></a></div>
			<?php }?>
			<table width="100%">
				<tr><td>
						<h2><?php echo $LAPAGINA?></h2>
						<?php if ($LIST==1) { ?>
							<table width="100%" id="Filtro">
								<tr>
									<td>
										<form action="mant_tienda.php" method="post" name="frmbuscar" id="frmbuscar">
											<select name="FNEGOCI" onChange="document.forms.frmbuscar.submit();">
												<option value="999">Negocio</option>
												<?php
												$SQLFILTRO="SELECT * FROM MN_NEGOCIO ORDER BY DES_NEGOCIO ASC";
												$RS = sqlsrv_query($conn, $SQLFILTRO);
												//oci_execute($RS);
												while ($row = sqlsrv_fetch_array($RS)) {
													$FLTCOD_NEGOCIO = $row['COD_NEGOCIO'];
													$FLTDES_NEGOCIO = $row['DES_NEGOCIO'];
													?>
													<option value="<?php echo $FLTCOD_NEGOCIO ?>" <?php  if ($FLTCOD_NEGOCIO==$FNEGOCI) { echo "SELECTED";}?>><?php echo $FLTDES_NEGOCIO ?></option>
													<?php
												}
												?>
											</select>
											
											<?php if($GLBDPTREG==1){?>
												<select name="COD_REGION"  onChange="CargaCiudad(this.value, this.form.name, 'FCIUDAD', <?=$GLBCODPAIS?>)">
													<option value="0"><?=$GLBDESCDPTREG?></option>
													<?php
													$SQL="SELECT * FROM PM_REGION WHERE COD_PAIS=".$GLBCODPAIS." ORDER BY DES_REGION ASC";
					
													$RS = sqlsrv_query($conn, $SQL);
													//oci_execute($RS);
													while ($row = sqlsrv_fetch_array($RS)) {
														$COD_REGION = $row['COD_REGION'];
														$DES_REGION = $row['DES_REGION'];
														?>
														<option value="<?php echo $COD_REGION;?>"><?php echo $DES_REGION ?></option>
														<?php
													}
													?>
												</select>
											<?php } //$GLBDPTREG?>
											<select name="FCIUDAD" onChange="document.forms.frmbuscar.submit();">
												<option value="0">Ciudad</option>
												<?php if($GLBDPTREG==0){?>
													<?php
													$SQLFILTRO="SELECT * FROM PM_CIUDAD WHERE COD_PAIS=".$GLBCODPAIS." ORDER BY DES_CIUDAD ASC";
													$RS = sqlsrv_query($conn, $SQLFILTRO);
													//oci_execute($RS);
													while ($row = sqlsrv_fetch_array($RS)) {
														$FLTCOD_CIUDAD = $row['COD_CIUDAD'];
														$FLTDES_CIUDAD = $row['DES_CIUDAD'];
														?>
														<option value="<?php echo $FLTCOD_CIUDAD ?>" <?php  if ($FLTCOD_CIUDAD==$FCIUDAD) { echo "SELECTED";}?>><?php echo $FLTDES_CIUDAD ?></option>
														<?php
													}
													?>
												<?php }?>
											</select>
											<select name="FESTADO" onChange="document.forms.frmbuscar.submit();">
												<option value="0">Estado</option>
												<option value="1" <?php  if ($FESTADO==1) { echo "SELECTED";}?>>Activo</option>
												<option value="2" <?php  if ($FESTADO==2) { echo "SELECTED";}?>>Bloqueado</option>
											</select>
											<input style="clear:left" name="BLOCAL" type="text" id="BLOCAL" size="20" value="<?php echo $BLOCAL ?>">
											<input name="BUSCAR" type="submit" id="BUSCAR" value="Buscar Tienda">
											<input name="LIMPIAR" type="button" id="LIMPIAR" value="Limpiar" onClick="javascript:pagina('mant_tienda.php')">
										</form>
									</td>
								</tr>
							</table>
						<?php } //LIST=1 ?>
						<table style="margin:10px 20px; ">
							<tr>
								<td>
									<?php
									if ($LIST==1) {
										$S="SELECT COUNT(*) AS CUENTA FROM MN_TIENDA WHERE COD_TIENDA<>0 ".$FILTRO_NEGOCIO.$FILTRO_CIUDAD.$FILTRO_ESTADO.$FILTRO_NOMB." ";
										
									
										$RS = sqlsrv_query($conn, $S);
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
										if ($TOTALREG==0) {
											if($FNEGOCI==0 && $FESTADO==0 && empty($BLOCAL)) {
												//NO HAY REGISTROS
												$LISTAR=0;

											} else {
												echo "<script language='javascript'>window.location='mant_tienda.php?MSJE=7'</script>;";
											}

										}
										?>
										<?php if($LISTAR==1) { ?>
											<?php
											//$S="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM MN_TIENDA WHERE COD_TIENDA<>0  ".$FILTRO_NEGOCIO.$FILTRO_CIUDAD.$FILTRO_ESTADO.$FILTRO_NOMB." ORDER BY  											DES_CLAVE ASC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;

											$S= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY DES_CLAVE ASC) ROWNUMBER FROM MN_TIENDA WHERE COD_TIENDA<>0  ".$FILTRO_NEGOCIO.$FILTRO_CIUDAD.$FILTRO_ESTADO.$FILTRO_NOMB.") AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";


											$RS = sqlsrv_query($conn, $S);
											//oci_execute($RS);
											?>
											<table id="Listado">
												<tr>
													<th>C&oacute;d. Tienda<br>Nombre Tienda</th>
													<th>L&iacute;nea de Negocio</th>
													<th>Direcci&oacute;n</th>
													<th>Banco<BR>Cuenta</th>
													<th>Estado</th>
													<th>Registrado por</th>
												</tr>
												<?php
												$LOSPROCESOS="";
												$LOSDOCS="";
												while ($row = sqlsrv_fetch_array($RS)){
													$COD_TIENDA = $row['COD_TIENDA'];
													$DIRECCION = $row['DIRECCION'];
													$COD_REGION = $row['COD_REGION'];
													$COD_CIUDAD = $row['COD_CIUDAD'];
													$IP = $row['IP'];
													$DES_CLAVE = $row['DES_CLAVE'];
													$DES_TIENDA = $row['DES_TIENDA'];
													if(empty($DES_TIENDA)){ $DES_TIENDA="Tienda ".$DES_CLAVE_LST;}
													$IND_ACTIVO = $row['IND_ACTIVO'];
													$IDREG = $row['IDREG'];
													$FECHA = $row['FECHA'];
													$DES_CLAVE_F="0000".$DES_CLAVE;
													$DES_CLAVE_F=substr($DES_CLAVE_F, -4);
													if ($BLOCAL<>"") {
														$DES_TIENDA=str_replace($BLOCAL,'<span style="background-color:#FDE807; font-weight:bold; ">'.$BLOCAL.'</span>', $DES_TIENDA);
														$DES_CLAVE_F=str_replace($BLOCAL,'<span style="background-color:#FDE807; font-weight:bold; ">'.$BLOCAL.'</span>', $DES_CLAVE_F);
													}

													$DES_NEGOCIO_NEG ="";
													$S1="SELECT * FROM MN_NEGTND WHERE COD_TIENDA=".$COD_TIENDA." ORDER BY COD_NEGOCIO ASC";
													$RS1 = sqlsrv_query($conn, $S1);
													//oci_execute($RS1);
													while ($row = sqlsrv_fetch_array($RS1)) {
														$COD_NEGOCIO = $row['COD_NEGOCIO'];
														$S2="SELECT DES_NEGOCIO FROM MN_NEGOCIO WHERE COD_NEGOCIO=".$COD_NEGOCIO;
														$RS2 = sqlsrv_query($conn, $S2);
														//oci_execute($RS2);
														if ($row2 = sqlsrv_fetch_array($RS2)) {
															$DES_NEGOCIO_NEG = $DES_NEGOCIO_NEG.$row2['DES_NEGOCIO'].", ";
														}
													}

													$S1="SELECT DES_CIUDAD FROM PM_CIUDAD WHERE COD_CIUDAD=".$COD_CIUDAD;
													$RS1 = sqlsrv_query($conn, $S1);
													//oci_execute($RS1);
													if ($row = sqlsrv_fetch_array($RS1)) {
														$DES_CIUDAD = $row['DES_CIUDAD'];
													} else {
														$DES_CIUDAD = "";
													}
													$S1="SELECT DES_REGION FROM PM_REGION WHERE COD_REGION=".$COD_REGION;
													$RS1 = sqlsrv_query($conn, $S1);
													//oci_execute($RS1);
													if ($row = sqlsrv_fetch_array($RS1)) {
														$DES_REGION = $row['DES_REGION'];
													} else {
														$DES_REGION = "";
													}
													if ($IND_ACTIVO==1) {
														$ELIND_ACTIVO="Activo";
														$COLORTD="#4CAF50";
													}
													if ($IND_ACTIVO==0) {
														$ELIND_ACTIVO="Bloqueado";
														$COLORTD="#F44336";
													}
													$S2="SELECT NOMBRE FROM US_USUARIOS WHERE IDUSU=".$IDREG;
													$RS2 = sqlsrv_query($conn, $S2);
													//oci_execute($RS2);
													if ($row = sqlsrv_fetch_array($RS2)) {
														$QUIENFUE = $row['NOMBRE'];
													} else {
														$QUIENFUE = "Sistema";
													}
													$S2="SELECT * FROM MN_TNDBNC WHERE COD_TIENDA=".$COD_TIENDA;
													$RS2 = sqlsrv_query($conn, $S2);
													//oci_execute($RS2);
													if ($row = sqlsrv_fetch_array($RS2)) {
														$NM_BANCO = $row['NM_BANCO'];
														$NU_CTA_BNC = $row['NU_CTA_BNC'];
														$BANCO=$NM_BANCO."<BR>".$NU_CTA_BNC;
													} else {
														$BANCO="NO REGISTRADO";
													}


													?>
													<tr>
														<?php if($SESPUBLICA==1) { ?>
															<td><a href="mant_tienda.php?ACT=<?php echo $COD_TIENDA?>"><?php echo $DES_CLAVE_F?><br><?php echo $DES_TIENDA?></a><br><?php echo $IP;?></td>
														<?php } else {?>
															<td><?php echo $DES_CLAVE_F?><br><?php echo $DES_TIENDA?></td>
														<?php } ?>
														<td style="max-width:300px"><?php echo $DES_NEGOCIO_NEG?></td>
														<td><?php echo $DIRECCION."<BR>".$DES_CIUDAD."<BR>".$DES_REGION?></td>
														<td><?php echo $BANCO?></td>
														<td align="center" style="background-color:<?php echo $COLORTD ?>; color:#FFF; text-shadow:none"><?php echo $ELIND_ACTIVO?></td>
														<td><?php echo $QUIENFUE.", ".date_format($FECHA,"d-m-Y")?></td>
													</tr>

													<?php
												}
												?>
												<tr>
													<td colspan="6" nowrap style="background-color:transparent">
														<?php
														if ($LINF>=$CTP+1) {
															$ATRAS=$LINF-$CTP;
															$FILA_ANT=$LSUP-$CTP;
															?>
															<input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('mant_tienda.php?LSUP=<?php echo $FILA_ANT?>&LINF=<?php echo $ATRAS?>&FNEGOCI=<?php echo $FNEGOCI?>&FCIUDAD=<?php echo $FCIUDAD?>&FESTADO=<?php echo $FESTADO?>&BLOCAL=<?php echo $BLOCAL?>');">
															<?php
														}
														if ($LSUP<=$TOTALREG) {
															$ADELANTE=$LSUP+1;
															$FILA_POS=$LSUP+$CTP;
															?>
															<input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('mant_tienda.php?LSUP=<?php echo $FILA_POS?>&LINF=<?php echo $ADELANTE?>&FNEGOCI=<?php echo $FNEGOCI?>&FCIUDAD=<?php echo $FCIUDAD?>&FESTADO=<?php echo $FESTADO?>&BLOCAL=<?php echo $BLOCAL?>');">
														<?php }?>
														<span style="vertical-align:baseline;">P&aacute;gina <?php echo $NUMPAG?> de <?php echo $NUMTPAG?></span>
													</td>
												</tr>
											</table>
										<?php } else /*LISTAR=1*/ { ?>
											<h4>No se registran Tiendas</h4>
										<?php } ?>
										<?php
									} /*LISTAR=1*/
									?>






									<?php  if ($NEO==1) {  //NUEVO ?>

										<h3>Registro de Tienda</h3>
										<table id="forma-registro">
											<form action="mant_tienda_reg.php" method="post" name="forming" id="forming" onSubmit="return validaTienda(this)">
												<tr>
													<td><label for="COD_SOC">Sociedad</label></td>
													<td>
														<table>
															<?php
															$S1="SELECT * FROM MN_SOCIEDAD ORDER BY NM_SOC ASC";
															$RS1 = sqlsrv_query($conn, $S1);
															//oci_execute($RS1);
															while ($row = sqlsrv_fetch_array($RS1)) {
																$COD_SOC = $row['COD_SOC'];
																$NM_SOC = $row['NM_SOC'];
																?>
																<tr>
																	<td style="border:none">
																		<input name="CDSOC<?php echo $COD_SOC;?>" style="font-size:22pt" type="checkbox" value="1">
																	</td>
																	<td style="border:none">
																		<label for="COD_SOC" style="text-align:left; padding:0; margin:0"><?php echo $NM_SOC;?></label>
																	</td>
																</tr>
																<?php
															}
															?>
														</table>
													</td>
												</tr>
												<tr>
													<td style="vertical-align:top"><label for="COD_NEGOCIO">L&iacute;nea de Negocio</label></td>
													<td>
														<table>
															<?php
															$S1="SELECT * FROM MN_NEGOCIO ORDER BY DES_NEGOCIO ASC";
															$RS1 = sqlsrv_query($conn, $S1);
															//oci_execute($RS1);
															$CUENTA_TR=1;
															while ($row = sqlsrv_fetch_array($RS1)) {
																if($CUENTA_TR==3){
																	echo "<tr>";
																	$CUENTA_TR=1;
																}
																$COD_NEGOCIO2 = $row['COD_NEGOCIO'];
																$DES_NEGOCIO = $row['DES_NEGOCIO'];
																$S2="SELECT * FROM MN_NEGTND WHERE COD_NEGOCIO=".$COD_NEGOCIO2;
																$RS2 = sqlsrv_query($conn, $S2);
																//oci_execute($RS2);
																if ($row2 = sqlsrv_fetch_array($RS2)) {
																	$MARCALINEA=1;
																} else {
																	$MARCALINEA=0;
																}
																?>
																<td>
																	<input name="CDNEG<?php echo $COD_NEGOCIO2;?>" style="font-size:22pt" type="checkbox" value="1" <?php if($MARCALINEA==1){ echo "checked";} ?>>
																</td>
																<td>
																	<label for="COD_NEGOCIO" style="text-align:left; padding:0; margin:0"><?php echo $DES_NEGOCIO;?></label>
																</td>
																<?php
																$CUENTA_TR=$CUENTA_TR+1;
															}
															?>
														</table>


													</td>
												</tr>
												<tr>
													<td><label for="DES_CLAVE"> N&uacute;mero Tienda </label></td>
													<td><input name="DES_CLAVE" type="text" size="5" maxlength="4" onKeyPress="return acceptNum(event)"> </td>
												</tr>
												<tr>
													<td><label for="DES_TIENDA"> Nombre Tienda </label></td>
													<td><input name="DES_TIENDA" type="text" size="40" maxlength="50"> </td>
												</tr>
												<?php if($GLBDPTREG==1){?>
													<tr>
														<td><label for="COD_REGION"><?=$GLBDESCDPTREG?></label></td>
														<td><select name="COD_REGION"  onChange="CargaCiudad(this.value, this.form.name, 'COD_CIUDAD', <?=$GLBCODPAIS?>)">
																<option value="0"><?=$GLBDESCDPTREG?></option>
																<?php
																$SQL="SELECT * FROM PM_REGION WHERE COD_PAIS=".$GLBCODPAIS." ORDER BY DES_REGION ASC";
																$RS = sqlsrv_query($conn, $SQL);
																//oci_execute($RS);
																while ($row = sqlsrv_fetch_array($RS)) {
																	$COD_REGION = $row['COD_REGION'];
																	$DES_REGION = $row['DES_REGION'];
																	?>
																	<option value="<?php echo $COD_REGION;?>"><?php echo $DES_REGION ?></option>
																	<?php
																}
																?>
															</select></td>
													</tr>
												<?php } else {?><input type="hidden" name="COD_REGION" value="0"><?php }//$GLBDPTREG?>
												<tr>
													<td><label for="COD_CIUDAD">Ciudad</label></td>
													<td><select id="COD_CIUDAD" name="COD_CIUDAD">
															<option value="0">Ciudad</option>
															<?php if($GLBDPTREG==0){?>
																<?php
																$S1="SELECT * FROM PM_CIUDAD WHERE COD_PAIS=".$GLBCODPAIS." ORDER BY DES_CIUDAD ASC";
																$RS1 = sqlsrv_query($conn, $S1);
																//oci_execute($RS1);
																while ($row = sqlsrv_fetch_array($RS1)) {
																	$COD_CIUDAD = $row['COD_CIUDAD'];
																	$DES_CIUDAD = $row['DES_CIUDAD'];
																	?>
																	<option value="<?php echo $COD_CIUDAD?>"><?php echo $DES_CIUDAD?></option>
																	<?php
																}
																?>
															<?php } //$GLBDPTREG?>
														</select></td>
												</tr>
												<tr>
													<td><label for="DIRECCION">Direcci&oacute;n</label> </td>
													<td><input name="DIRECCION" type="text" size="40" maxlength="200"></td>
												</tr>
												<tr>
													<td><label for="IP">IP</label> </td>
													<td><input name="IP" type="text" size="12" maxlength="15" onKeyPress="return acceptNumpunto(event)"></td>
												</tr>

												<tr>
													<td><label for="IVA_TAX">Modo Impuesto</label> </td>
													<td><select id="IVA_TAX" name="IVA_TAX">
															<option value="0">SELECCIONAR</option>
															<option value="I">IVA</option>
															<option value="T">TAX</option>
														</select>
													</td>
												</tr>

												<tr>
													<td><label for="INC_PRC">Impuesto Incluido en Precio Art&iacute;culo</label> </td>
													<td><select id="INC_PRC" name="INC_PRC">
															<option value="0">SELECCIONAR</option>
															<option value="S">SI</option>
															<option value="N">NO</option>
														</select>
													</td>
												</tr>

												<tr>
													<td style="vertical-align:top"><label for="IMPUESTOS">Valores de Impuestos</label></td>
													<td>
														<table>
															<tr>
																<td>
																	<label for="IMP_1" >IMP 1</label></td><td>
																	<input name="IMP_1" type="text" value="0.00" size="6" maxlength="12"  onKeyPress="return acceptNumpunto(event);">%
																</td>
																<td style="border-left:1px solid #DFDFDF">
																	<label for="IMP_2" >IMP 2</label></td><td>
																	<input name="IMP_2" type="text" value="0.00" size="6" maxlength="12"  onKeyPress="return acceptNumpunto(event);">%
																</td>
															</tr>
															<tr>
																<td>
																	<label for="IMP_3" >IVA 3</label></td><td>
																	<input name="IMP_3" type="text" value="0.00" size="6" maxlength="12"  onKeyPress="return acceptNumpunto(event);">%
																</td>
																<td style="border-left:1px solid #DFDFDF">
																	<label for="IMP_4" >IMP 4</label></td><td>
																	<input name="IMP_4" type="text" value="0.00" size="6" maxlength="12"  onKeyPress="return acceptNumpunto(event);">%
																</td>
															</tr>
															<tr>
																<td>
																	<label for="IMP_5" >IVA 5</label></td><td>
																	<input name="IMP_5" type="text" value="0.00" size="6" maxlength="12"  onKeyPress="return acceptNumpunto(event);">%
																</td>
																<td style="border-left:1px solid #DFDFDF">
																	<label for="IMP_6" >IMP 6</label></td><td>
																	<input name="IMP_6" type="text" value="0.00" size="6" maxlength="12"  onKeyPress="return acceptNumpunto(event);">%
																</td>
															</tr>
															<tr>
																<td>
																	<label for="IMP_7" >IVA 7</label></td><td>
																	<input name="IMP_7" type="text" value="0.00" size="6" maxlength="12"  onKeyPress="return acceptNumpunto(event);">%
																</td>
																<td style="border-left:1px solid #DFDFDF">
																	<label for="IMP_8" >IMP 8</label></td><td>
																	<input name="IMP_8" type="text" value="0.00" size="6" maxlength="12"  onKeyPress="return acceptNumpunto(event);">%
																</td>
															</tr>
														</table>


                                                </td>
												</tr>
												   <tr>
											<td><label for="NO_AFIL_FL">Afiliado</label></td>
											<td >
                                                    <div style="clear: both; margin: 0 10px 0 0;">
                                                        <input id="NO_AFIL_FL"  name="NO_AFIL_FL" type="checkbox"  class="switch" value="1" >
                                                        <label style="text-align:left; color:#f1f1f1" for="NO_AFIL_FL">.</label>
                                                    </div>
                                            </td>
										</tr>
                                         <tr>
											<td><label for="IND_APLC_REC">Aplica Recargo</label></td>
											<td >
                                                    <div style="clear: both; margin: 0 10px 0 0;">
                                                        <input id="IND_APLC_REC"  name="IND_APLC_REC" type="checkbox"  class="switch" value="1" onChange="aplica_recargo()">
                                                        <label style="text-align:left; color:#f1f1f1" for="IND_APLC_REC">.</label>
                                                    </div>
                                            </td>
										</tr>
                                        <tr id="TR_REC_NO_AFILIADO" style="display:table-row">
											<td><label for="REC_NO_AFILIADO">Recargo</label></td>
											<td >
												<input name="REC_NO_AFILIADO" id="REC_NO_AFILIADO" type="text" size="8" maxlength="6"  onKeyPress="return acceptNumpunto(event);">
                                            </td>
										</tr>
												<tr>
													<td>
													<td>
														<input name="REGISTRAR" type="submit" value="Registrar Tienda">
														<input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_tienda.php')">
													</td>
												</tr>
											</form>
										</table>


										<?php
										sqlsrv_close($conn);
									} // FIN NEO
									?>

									<?php  if ($ACT<>"") {  //ACTUALIZAR
										$S="SELECT * FROM MN_TIENDA WHERE COD_TIENDA=".$ACT;
										$RS = sqlsrv_query($conn, $S);
										//oci_execute($RS);
										if ($row = sqlsrv_fetch_array($RS)) {
											$COD_TIENDA = $row['COD_TIENDA'];
											$DES_TIENDA = $row['DES_TIENDA'];
											$DES_CLAVE = $row['DES_CLAVE'];
											$DES_CLAVE_LST="0000".$DES_CLAVE;
											$DES_CLAVE_LST=substr($DES_CLAVE_LST, -4);
											$COD_CIUDAD = $row['COD_CIUDAD'];
											$COD_REGION = $row['COD_REGION'];
											$IP = $row['IP'];
											$DIRECCION = $row['DIRECCION'];
											$IND_ACTIVO = $row['IND_ACTIVO'];

										}

										$S1="SELECT * FROM PA_STR_RTL WHERE CD_STR_RT=".$DES_CLAVE;
										$RS1 = sqlsrv_query($arts_conn, $S1);
										//oci_execute($RS1);
										if ($row1 = sqlsrv_fetch_array($RS1)) {
											$IVA_TAX = $row1['IVA_TAX'];
											$INC_PRC = $row1['INC_PRC'];
											$IMP_1 = $row1['IMP_1'];
											$IMP_1_F = $IMP_1/$DIVCENTS;
											$IMP_1_F = number_format($IMP_1_F, $CENTS, '.', ',');
											$IMP_2 = $row1['IMP_2'];
											$IMP_2_F = $IMP_2/$DIVCENTS;
											$IMP_2_F = number_format($IMP_2_F, $CENTS, '.', ',');
											$IMP_3 = $row1['IMP_3'];
											$IMP_3_F = $IMP_3/$DIVCENTS;
											$IMP_3_F = number_format($IMP_3_F, $CENTS, '.', ',');
											$IMP_4 = $row1['IMP_4'];
											$IMP_4_F = $IMP_4/$DIVCENTS;
											$IMP_4_F = number_format($IMP_4_F, $CENTS, '.', ',');
											$IMP_5 = $row1['IMP_5'];
											$IMP_5_F = $IMP_5/$DIVCENTS;
											$IMP_5_F = number_format($IMP_5_F, $CENTS, '.', ',');
											$IMP_6 = $row1['IMP_6'];
											$IMP_6_F = $IMP_6/$DIVCENTS;
											$IMP_6_F = number_format($IMP_6_F, $CENTS, '.', ',');
											$IMP_7 = $row1['IMP_7'];
											$IMP_7_F = $IMP_7/$DIVCENTS;
											$IMP_7_F = number_format($IMP_7_F, $CENTS, '.', ',');
											$IMP_8 = $row1['IMP_8'];
											$IMP_8_F = $IMP_8/$DIVCENTS;
											$IMP_8_F = number_format($IMP_8_F, $CENTS, '.', ',');
											$NO_AFIL_FL = $row1['NO_AFIL_FL'];
											$REC_NO_AFILIADO = $row1['REC_NO_AFILIADO'];
											?>
											<h3>Actualizar Data Tienda <?php echo $DES_CLAVE_LST?></h3>
                                            <form action="mant_tienda_reg.php" method="post" name="forming" id="forming" onSubmit="return validaTienda(this)">
											<table id="forma-registro">											
											<tr>
												<td><label for="COD_SOC">Sociedad</label></td>
												<td>
													<table>
														<?php
														$S1="SELECT * FROM MN_SOCIEDAD ORDER BY NM_SOC ASC";
														$RS1 = sqlsrv_query($conn, $S1);
														//oci_execute($RS1);
														while ($row = sqlsrv_fetch_array($RS1)) {
															$COD_SOC = $row['COD_SOC'];
															$NM_SOC = $row['NM_SOC'];
															$S2="SELECT * FROM MN_TNDSOC WHERE COD_SOC=".$COD_SOC." AND COD_TIENDA=".$COD_TIENDA;
															$RS2 = sqlsrv_query($conn, $S2);
															//oci_execute($RS2);
															if ($row2 = sqlsrv_fetch_array($RS2)) {
																$MARCASOC=1;
															} else {
																$MARCASOC=0;
															}
															?>
															<tr>
																<td style="border:none">
																	<input name="CDSOC<?php echo $COD_SOC;?>" style="font-size:22pt" type="checkbox" value="1" <?php if($MARCASOC==1){ echo "checked";} ?>>
																</td>
																<td style="border:none">
																	<label for="COD_SOC" style="text-align:left; padding:0; margin:0"><?php echo $NM_SOC;?></label>
																</td>
															</tr>
															<?php
														}
														?>
													</table>
												</td>
											</tr>
											<tr>
												<td><label for="COD_NEGOCIO">L&iacute;nea de Negocio</label></td>
												<td>
													<table>
														<?php
														$S1="SELECT * FROM MN_NEGOCIO ORDER BY DES_NEGOCIO ASC";
														$RS1 = sqlsrv_query($conn, $S1);
														//oci_execute($RS1);
														$CUENTA_TR=1;
														while ($row = sqlsrv_fetch_array($RS1)) {
															if($CUENTA_TR==3){
																echo "<tr>";
																$CUENTA_TR=1;
															}
															$COD_NEGOCIO2 = $row['COD_NEGOCIO'];
															$DES_NEGOCIO = $row['DES_NEGOCIO'];
															$S2="SELECT * FROM MN_NEGTND WHERE COD_NEGOCIO=".$COD_NEGOCIO2." AND COD_TIENDA=".$COD_TIENDA;
															$RS2 = sqlsrv_query($conn, $S2);
															//oci_execute($RS2);
															if ($row2 = sqlsrv_fetch_array($RS2)) {
																$MARCALINEA=1;
															} else {
																$MARCALINEA=0;
															}
															?>
															<td>
																<input name="CDNEG<?php echo $COD_NEGOCIO2;?>" style="font-size:22pt" type="checkbox" value="1" <?php if($MARCALINEA==1){ echo "checked";} ?>>
															</td>
															<td>
																<label for="COD_NEGOCIO" style="text-align:left; padding:0; margin:0"><?php echo $DES_NEGOCIO;?></label>
															</td>
															<?php
															$CUENTA_TR=$CUENTA_TR+1;
														}
														?>
													</table>


												</td>
											</tr>
											<tr>
												<td><label for="DES_CLAVE"> N&uacute;mero Tienda </label></td>
												<td><input name="DES_CLAVE" type="text" size="5" maxlength="4"  value="<?php echo $DES_CLAVE ?>" onKeyPress="return acceptNum(event)"> </td>
											</tr>
											<tr>
												<td><label for="DES_TIENDA"> Nombre Tienda </label></td>
												<td><input name="DES_TIENDA" type="text" size="40" maxlength="50" value="<?php echo $DES_TIENDA ?>"> </td>
											</tr>
											<?php if($GLBDPTREG==1){?>
												<tr>
													<td><label for="COD_REGION"><?=$GLBDESCDPTREG?></label></td>
													<td><select name="COD_REGION"  onChange="CargaCiudad(this.value, this.form.name, 'COD_CIUDAD', <?=$GLBCODPAIS?>)">
															<option value="0"><?=$GLBDESCDPTREG?></option>
															<?php
															$SQL="SELECT * FROM PM_REGION WHERE COD_PAIS=".$GLBCODPAIS." ORDER BY DES_REGION ASC";
															$RS = sqlsrv_query($conn, $SQL);
															//oci_execute($RS);
															while ($row = sqlsrv_fetch_array($RS)) {
																$COD_REGION2 = $row['COD_REGION'];
																$DES_REGION = $row['DES_REGION'];
																?>
																<option value="<?php echo $COD_REGION2;?>" <?php if($COD_REGION2==$COD_REGION){echo "SELECTED";}?>><?php echo $DES_REGION ?></option>
																<?php
															}
															?>
														</select></td>
												</tr>
											<?php } else {?><input type="hidden" name="COD_REGION" value="0"><?php }//$GLBDPTREG?>
											<tr>
												<td><label for="COD_CIUDAD">Ciudad</label></td>
												<td><select id="COD_CIUDAD" name="COD_CIUDAD">
														<option value="0">Ciudad</option>
														<?php
														if($GLBDPTREG==1){
															$S1="SELECT * FROM PM_CIUDAD WHERE COD_PAIS=".$GLBCODPAIS." AND COD_REGION=".$COD_REGION." ORDER BY DES_CIUDAD ASC";
														} else {
															$S1="SELECT * FROM PM_CIUDAD WHERE COD_PAIS=".$GLBCODPAIS." ORDER BY DES_CIUDAD ASC";
														}
														$RS1 = sqlsrv_query($conn, $S1);
														//oci_execute($RS1);
														while ($row = sqlsrv_fetch_array($RS1)) {
															$COD_CIUDAD2 = $row['COD_CIUDAD'];
															$DES_CIUDAD = $row['DES_CIUDAD'];
															?>
															<option value="<?php echo $COD_CIUDAD2?>" <?php if($COD_CIUDAD2==$COD_CIUDAD){echo "SELECTED";}?>><?php echo $DES_CIUDAD?></option>
															<?php
														}
														?>
													</select></td>
											</tr>
											<tr>
												<td><label for="DIRECCION">Direcci&oacute;n</label> </td>
												<td><input name="DIRECCION" type="text" size="40" maxlength="200" value="<?php echo $DIRECCION?>"></td>
											</tr>
											<tr>
												<td><label for="IP">IP</label> </td>
												<td><input name="IP" type="text" size="12" maxlength="15" value="<?php echo $IP?>" onKeyPress="return acceptNumpunto(event)"></td>
											</tr>

											<tr>
												<td><label for="IVA_TAX">Modo Impuesto</label> </td>
												<td><select id="IVA_TAX" name="IVA_TAX">
														<option value="0">SELECCIONAR</option>
														<option value="I" <?php if($IVA_TAX=="I"){ echo "Selected";}?>>IVA</option>
														<option value="T" <?php if($IVA_TAX=="T"){ echo "Selected";}?>>TAX</option>
													</select>
												</td>
											</tr>

											<tr>
												<td><label for="INC_PRC">Impuesto Incluido en Precio Art&iacute;culo</label> </td>
												<td><select id="INC_PRC" name="INC_PRC">
														<option value="0">SELECCIONAR</option>
														<option value="S" <?php if($INC_PRC=="S"){ echo "Selected";}?>>SI</option>
														<option value="N" <?php if($INC_PRC=="N"){ echo "Selected";}?>>NO</option>
													</select>
												</td>
											</tr>

											<tr>
											<td><label for="IMPUESTOS">Valores de Impuestos</label></td>
											<td>
											<table>
											<tr>
												<td>
													<label for="IMP_1" >IMP 1</label></td><td>
													<input name="IMP_1" type="text" value="<?php echo $IMP_1_F?>" size="6" maxlength="12"  onKeyPress="return acceptNumpunto(event);">%
												</td>
												<td style="border-left:1px solid #DFDFDF">
													<label for="IMP_2" >IMP 2</label></td><td>
													<input name="IMP_2" type="text" value="<?php echo $IMP_2_F?>" size="6" maxlength="12"  onKeyPress="return acceptNumpunto(event);">%
												</td>
											</tr>
											<tr>
												<td>
													<label for="IMP_3" >IMP 3</label></td><td>
													<input name="IMP_3" type="text" value="<?php echo $IMP_3_F?>" size="6" maxlength="12"  onKeyPress="return acceptNumpunto(event);">%
												</td>
												<td style="border-left:1px solid #DFDFDF">
													<label for="IMP_4" >IMP 4</label></td><td>
													<input name="IMP_4" type="text" value="<?php echo $IMP_4_F?>" size="6" maxlength="12"  onKeyPress="return acceptNumpunto(event);">%
												</td>
											</tr>
											<tr>
												<td>
													<label for="IMP_5" >IMP 5</label></td><td>
													<input name="IMP_5" type="text" value="<?php echo $IMP_5_F?>" size="6" maxlength="12"  onKeyPress="return acceptNumpunto(event);">%
												</td>
												<td style="border-left:1px solid #DFDFDF">
													<label for="IMP_6" >IMP 6</label></td><td>
													<input name="IMP_6" type="text" value="<?php echo $IMP_6_F?>" size="6" maxlength="12"  onKeyPress="return acceptNumpunto(event);">%
												</td>
											</tr>
											<tr>
												<td>
													<label for="IMP_7" >IMP 7</label></td><td>
													<input name="IMP_7" type="text" value="<?php echo $IMP_7_F?>" size="6" maxlength="12"  onKeyPress="return acceptNumpunto(event);">%
												</td>
												<td style="border-left:1px solid #DFDFDF">
													<label for="IMP_8" >IMP 8</label></td><td>
													<input name="IMP_8" type="text" value="<?php echo $IMP_8_F?>" size="6" maxlength="12"  onKeyPress="return acceptNumpunto(event);">%
												</td>
											</tr>
											<?php
										}
										?>
										</table>


										</td>
										</tr>

										<tr>
											<td><label for="IND_ACTIVO">Local Activo</label></td>
											<td ><select name="IND_ACTIVO">
													<option value="0" <?php if ($IND_ACTIVO==0) { echo "SELECTED";}?>>NO </option>
													<option value="1" <?php if ($IND_ACTIVO==1) { echo "SELECTED";}?>>SI  </option>
												</select></td>
										</tr>
                                        <tr>
											<td><label for="NO_AFIL_FL">Afiliado</label></td>
											<td >
                                                    <div style="clear: both; margin: 0 10px 0 0;">
                                                        <input id="NO_AFIL_FL"  name="NO_AFIL_FL" type="checkbox"  class="switch" value="1" <?php if($NO_AFIL_FL==0){echo "checked";} ?> >
                                                        <label style="text-align:left; color:#f1f1f1" for="NO_AFIL_FL">.</label>
                                                    </div>
                                            </td>
										</tr>
                                         <tr>
											<td><label for="IND_APLC_REC">Aplica Recargo</label></td>
											<td >
                                                    <div style="clear: both; margin: 0 10px 0 0;">
                                                        <input id="IND_APLC_REC"  name="IND_APLC_REC" type="checkbox"  class="switch" value="1" onChange="aplica_recargo()"  <?php if($REC_NO_AFILIADO!=""){echo "checked";} ?>>
                                                        <label style="text-align:left; color:#f1f1f1" for="IND_APLC_REC">.</label>
                                                    </div>
                                            </td>
										</tr>
                                        <tr id="TR_REC_NO_AFILIADO" style="display:table-row">
											<td><label for="REC_NO_AFILIADO">Recargo</label></td>
											<td >
												<input name="REC_NO_AFILIADO" id="REC_NO_AFILIADO" type="text" value="<?php echo $REC_NO_AFILIADO?>" size="8" maxlength="6"  onKeyPress="return acceptNumpunto(event);">
                                            </td>
										</tr>
										<tr>
											<td><input name="COD_TIENDA" type="hidden" value="<?php echo $COD_TIENDA?>">
											<td>
												<input name="ACTUALIZAR" type="submit" value="Actualizar Data">
												<input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_tienda.php')">
											</td>
										</tr>
										
										</table>
                                        </form>
										<?php
									} // FIN ACTUALIZAR
									?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<script>
function aplica_recargo()
{
	var val = $("#IND_APLC_REC").prop('checked');	 
	 if(val==1)
	 {
		 $("#TR_REC_NO_AFILIADO").css("display","table-row");
	 }
	 else
	 {
		 $("#TR_REC_NO_AFILIADO").css("display","none");
	 }
}
</script>
<iframe name="frmHIDEN" width="0" height="0" frameborder="0" align="top" src="" framespacing="0" marginheight="0" marginwidth="0">
</iframe>
</body>
</html>
<?php sqlsrv_close($conn); ?>

