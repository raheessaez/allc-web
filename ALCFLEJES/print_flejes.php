
<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php

	$PAGINA=1165;
	$NOMENU=1;
	$LIST=@$_GET["LIST"];
	$NEO=@$_GET["NEO"];
	if(empty($LIST)) { $NEO=1;}

	$VENTANA=@$_GET["V"];
	if(empty($VENTANA)){$VENTANA=0;}
	$SEARCH=@$_GET["S"];


?>

</head>

<body <?php if($VENTANA==1){?> onLoad="ActivarSearchItem()"<?php }?>>

<?php include("encabezado.php");?>
<?php include("titulo_menu.php");?>
<table width="100%" height="100%">
<tr>
<td align="right"  width="200" bgcolor="#FFFFFF"><?php include("menugeneral.php");?></td> 
<td >
<?php
if ($MSJE==1) {
$ELMSJ="Registro realizado";
} 
if ($MSJE <> "") {
?>
<div id="GMessaje" onClick="QuitarGMessage();"><a href="#" onClick="QuitarGMessage();" style="color:#111111;"><?php echo $ELMSJ?></a></div>
<?php }?>
        <table width="100%">
        <tr><td>

        <?php if($LIST==1){?>
        
        
        <?php }//if($LIST==1){?>
        
        <?php
		if($NEO==1){
				$ID_ITM=@$_GET["ID_ITM"];
				$ID_ITM_PS=@$_GET["ID_ITM_PS"];
	
				$ID_BSN_UN=@$_GET["ID_BSN_UN"];
				$CD_STR_RT_F=@$_GET["CD_STR_RT_F"];
				$CD_ITM_SI=@$_GET["CD_ITM_SEL"];
				if(empty($CD_ITM_SI)) { $CD_ITM_SI=@$_POST["CD_ITM"];}
				if(!empty($ID_ITM_PS)) { $CD_ITM_SI=$ID_ITM_PS;}

				$REGFLJTMP=@$_POST["REGFLJTMP"];
				$ES_EAN=@$_POST["ES_EAN"];

				$SLS_PRC=@$_GET["SLS_PRC"];
				
				$COD_NEGOCIO_SEL=@$_POST["COD_NEGOCIO"];
				if(empty($COD_NEGOCIO_SEL)) { $COD_NEGOCIO_SEL=@$_GET["COD_NEGOCIO"];}
				if(empty($COD_NEGOCIO_SEL)) { $COD_NEGOCIO_SEL=@$_POST["COD_NEGOCIO_SI"];}
				if(empty($COD_NEGOCIO_SEL)) { $COD_NEGOCIO_SEL=@$_GET["COD_NEGOCIO_SI"];}
				
				$COD_TIENDA_SEL=@$_POST["COD_TIENDA"];
				if(empty($COD_TIENDA_SEL)) { $COD_TIENDA_SEL=@$_GET["COD_TIENDA"];}
				if(empty($COD_TIENDA_SEL)) { $COD_TIENDA_SEL=@$_POST["COD_TIENDA_SI"];}
				if(empty($COD_TIENDA_SEL)) { $COD_TIENDA_SEL=@$_GET["COD_TIENDA_SI"];}
				
				$COD_FTIPO_SEL=@$_POST["COD_FTIPO"];
				if(empty($COD_FTIPO_SEL)) { $COD_FTIPO_SEL=@$_GET["COD_FTIPO"];}
				if(empty($COD_FTIPO_SEL)) { $COD_FTIPO_SEL=@$_POST["COD_FTIPO_SI"];}
				if(empty($COD_FTIPO_SEL)) { $COD_FTIPO_SEL=@$_GET["COD_FTIPO_SI"];}

				//VERIFICA SI USUARIO YA TIENE REGISTRO EN IMP_FLJ CON ESTADO=0
				$SQL="SELECT * FROM IMP_FLJ WHERE IDREG=".$SESIDUSU." AND ESTADO=0";
				$RS = sqlsrv_query($conn, $SQL);
				//oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {

					$ID_FLEJE = $row['ID_FLEJE'];
					$COD_FTIPO_SEL = $row['COD_FTIPO'];
					$COD_TIENDA_SEL = $row['COD_TIENDA'];
					$COD_NEGOCIO_SEL = $row['COD_NEGOCIO']; //NUEVO
					$REGISTRAR = 0;
					$NOCAMBIARTIPO = 1;

				} else {
					$NOCAMBIARTIPO = 0;
					$REGISTRAR = 1;
				}

				if(!empty($COD_TIENDA_SEL)) {
					$SQL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA=".$COD_TIENDA_SEL;
					$RS = sqlsrv_query($maestra, $SQL);
					//oci_execute($RS);
					if ($row = sqlsrv_fetch_array($RS)) {
						$DES_CLAVE_SEL = $row['DES_CLAVE'];
						$DES_CLAVE_FSI="0000".$DES_CLAVE_SEL;
						$DES_CLAVE_FSI=substr($DES_CLAVE_FSI, -4); 
						$DES_TIENDA_FSI = $row['DES_TIENDA'];
						$LATIENDA_SI = "Tienda: ".$DES_CLAVE_FSI." - ".$DES_TIENDA_FSI;

					}
					$SQL="SELECT ID_BSN_UN FROM PA_STR_RTL WHERE CD_STR_RT=".$DES_CLAVE_SEL;
					$RS = sqlsrv_query($arts_conn, $SQL);
					//oci_execute($RS);
					if ($row = sqlsrv_fetch_array($RS)) {
						$ID_BSN_UN_SEL = $row['ID_BSN_UN'];
					}
				}

				$ELMART=@$_GET["ELMART"];
				if(!empty($ELMART)){
					$SQL="DELETE FROM IMP_FLJART WHERE ID_FLJART=".$ELMART;
					$RS = sqlsrv_query($conn, $SQL);
					//oci_execute($RS);
				}
		?>
                <h2>Seleccionar Art&iacute;culo(s) e Imprimir Flejes</h2>
                <table style="margin:10px 20px; ">
                <tr><td>
                <form action="print_flejes.php?NEO=1" method="post" name="forming">
                <table id="forma-registro">
                
                <tr>
                		<td style="vertical-align:top">
                            <label for="COD_TIENDA"> Tienda</label>
                        </td>
                        <td>
                        <?php
							$VERTND_UNO = 0;
							//VERIFICAR TIENDAS ASOCIADAS A USUARIO
							$SQL="SELECT COUNT(COD_TIENDA) AS CTATND FROM US_USUTND WHERE IDUSU=".$SESIDUSU;
							$RS = sqlsrv_query($maestra, $SQL);
							//oci_execute($RS);
							if ($row = sqlsrv_fetch_array($RS)) {
								$CTATND = $row['CTATND'];
							}
							//SI CTATND==0 USUARIO CENTRAL, SELECCIONAR NEGOCIO Y LOCAL
							//SI CTATND==1 DESPLEGAR LOCAL
							//SI CTATND>1 DESPLEGAR LISTADO DE LOCALES
							if($CTATND==1){
								//OBTENER NEGOCIO
								$SQL="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO IN(SELECT COD_NEGOCIO FROM US_USUTND WHERE IDUSU=".$SESIDUSU.")";
								$RS = sqlsrv_query($maestra, $SQL);
								//oci_execute($RS);
								if ($row = sqlsrv_fetch_array($RS)) {
									$COD_NEGOCIO_SEL = $row['COD_NEGOCIO'];
									$DES_NEGOCIO = $row['DES_NEGOCIO'];
									$ELNEGOCIO = $DES_NEGOCIO;
								}
								//OBTENER TIENDA
								$SQL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA IN(SELECT COD_TIENDA FROM US_USUTND WHERE IDUSU=".$SESIDUSU.")";
								$RS = sqlsrv_query($maestra, $SQL);
								//oci_execute($RS);
								if ($row = sqlsrv_fetch_array($RS)) {
									$DES_CLAVE = $row['DES_CLAVE'];
									$DES_CLAVE_F="0000".$DES_CLAVE;
									$DES_CLAVE_F=substr($DES_CLAVE_F, -4); 
									$DES_TIENDA = $row['DES_TIENDA'];
									$LATIENDA = $DES_CLAVE_F." ".$DES_TIENDA;
									$COD_TIENDA_SEL = $row['COD_TIENDA'];
									//VERIFICAR QUE TIENDA SE ENCUENTRE REGISTRADA Y/O CON PRECIOS ARTS.AS_ITM_STR
									$SQL1="SELECT COUNT(ID_BSN_UN) AS VERTND FROM PA_STR_RTL WHERE CD_STR_RT=".$DES_CLAVE;
									$RS1 = sqlsrv_query($arts_conn, $SQL1);
									//oci_execute($RS1);
									if ($row1 = sqlsrv_fetch_array($RS1)) {
										$VERTND_UNO = $row1['VERTND'];
									}
									$LATIENDA_SI = "Tienda: ".$DES_CLAVE_F." - ".$DES_TIENDA;
									//OBTENER ID_BSN_UN
									$SQL1="SELECT ID_BSN_UN FROM PA_STR_RTL WHERE CD_STR_RT=".$DES_CLAVE;
									$RS1 = sqlsrv_query($arts_conn, $SQL1);
									//oci_execute($RS1);
									if ($row1 = sqlsrv_fetch_array($RS1)) {
										$ID_BSN_UN_SEL = $row1['ID_BSN_UN'];
									}
								}
								?>
                                	<h8><?php echo $ELNEGOCIO."<BR>".$LATIENDA ?></h8>
                                <?php
							}//if($CTATND==1)

							if($CTATND>1){//SELECCIONAR NEGOCIO (si es que hay más de uno) Y TIENDA
							$VERTND_UNO = 1;
							//CUENTA NEGOCIOS
								$SQL="SELECT COUNT(*) AS CTANEG FROM (SELECT COD_NEGOCIO FROM US_USUTND WHERE IDUSU=".$SESIDUSU." GROUP BY COD_NEGOCIO)";
								$RS = sqlsrv_query($maestra, $SQL);
								//oci_execute($RS);
								if ($row = sqlsrv_fetch_array($RS)) {
									$CTANEG = $row['CTANEG'];
								}
							//SI CTANEG==1 DESPLEGAR SOLO LOCALES ASOCIADOS
									//SI CTANEG>1 DESPLEGAR LISTADO NEGOCIOS Y LOCALES ASOCIADOS
									if($CTANEG>1){//SELECCIONAR NEGOCIO Y TIENDAS ASOCIADAS
											if(!empty($CD_ITM_SI) && !empty($COD_TIENDA_SEL) && !empty($COD_NEGOCIO_SEL)){
												//OBTENER NEGOCIO
												$SQL="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO =".$COD_NEGOCIO_SEL;
												$RS = sqlsrv_query($maestra, $SQL);
												//oci_execute($RS);
												if ($row = sqlsrv_fetch_array($RS)) {
													$COD_NEGOCIO_SEL = $row['COD_NEGOCIO'];
													$DES_NEGOCIO = $row['DES_NEGOCIO'];
													$ELNEGOCIO = $DES_NEGOCIO;
												}
												//OBTENER NEGOCIO
												$SQL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA =".$COD_TIENDA_SEL;
												$RS = sqlsrv_query($maestra, $SQL);
												//oci_execute($RS);
												if ($row = sqlsrv_fetch_array($RS)) {
													$DES_CLAVE = $row['DES_CLAVE'];
													$DES_CLAVE_F="0000".$DES_CLAVE;
													$DES_CLAVE_F=substr($DES_CLAVE_F, -4); 
													$DES_TIENDA = $row['DES_TIENDA'];
													$LATIENDA = $DES_CLAVE_F." ".$DES_TIENDA;
													$COD_TIENDA_SEL = $row['COD_TIENDA'];
												}
												?>
													<h8><?php echo $ELNEGOCIO."<BR>".$LATIENDA ?></h8>
													<input type="hidden" name="COD_NEGOCIO" value="<?php echo $COD_NEGOCIO_SEL?>">
													<input type="hidden" name="COD_TIENDA" value="<?php echo $COD_TIENDA_SEL?>">
												<?php
											} else {
												?>
													<select name="COD_NEGOCIO" onChange="CargaTiendaSelect(this.value, this.form.name, 'COD_TIENDA', <?=$SESIDUSU?>)">
																<option value="0">SELECCIONAR NEGOCIO</option>
																<?php 
																$SQL="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO IN(SELECT COD_NEGOCIO FROM US_USUTND WHERE IDUSU=".$SESIDUSU.") ORDER BY DES_NEGOCIO ASC";
																$RS = sqlsrv_query($maestra, $SQL);
																//oci_execute($RS);
																while ($row = sqlsrv_fetch_array($RS)) {
																	$COD_NEGOCIO = $row['COD_NEGOCIO'];
																	$DES_NEGOCIO = $row['DES_NEGOCIO'];
																 ?>
																<option value="<?php echo $COD_NEGOCIO ?>" <?php if($COD_NEGOCIO==$COD_NEGOCIO_SEL) {echo "Selected";} ?>><?php echo $DES_NEGOCIO ?></option>
																<?php 
																}
																 ?>
												</select>
												<select style="clear:left"  id="COD_TIENDA" name="COD_TIENDA" onChange="document.forms.forming.submit();">
													<option value="0">SELECCIONAR TIENDA</option>
													<?php
													if(!empty($COD_TIENDA_SEL)){
																$SQL="SELECT COD_TIENDA, DES_TIENDA, DES_CLAVE FROM MN_TIENDA WHERE COD_TIENDA IN(SELECT COD_TIENDA FROM US_USUTND WHERE IDUSU=".$SESIDUSU.") ORDER BY DES_CLAVE ASC";
																$RS = sqlsrv_query($maestra, $SQL);
																//oci_execute($RS);
																while ($row = sqlsrv_fetch_array($RS)) {
																	$NUM_TIENDA = $row['DES_CLAVE'];
																	$NUM_TIENDA_F="0000".$NUM_TIENDA;
																	$NUM_TIENDA_F=substr($NUM_TIENDA_F, -4); 
																	$STRDES = $row['DES_TIENDA'];
																	$STRCOD =$row['COD_TIENDA'];		
																	//VERIFICAR QUE TIENDA SE ENCUENTRE REGISTRADA Y/O CON PRECIOS ARTS.AS_ITM_STR
																	$SQL1="SELECT COUNT(ID_BSN_UN) AS VERTND FROM PA_STR_RTL WHERE CD_STR_RT=".$NUM_TIENDA;
																	$RS1 = sqlsrv_query($arts_conn, $SQL1);
																	//oci_execute($RS1);
																	if ($row1 = sqlsrv_fetch_array($RS1)) {
																		$VERTND = $row1['VERTND'];
																	}
																	if($VERTND != 0){
																	 ?>
                                                                    <option value="<?php echo $STRCOD ?>" <?php if($STRCOD==$COD_TIENDA_SEL) {echo "Selected";} ?>><?php echo $NUM_TIENDA_F." - ".$STRDES ?></option>
                                                                    <?php 
																	}
																}
													}
													?>
												</select>
												<?php
											}//!empty($CD_ITM_SI) && !empty($COD_TIENDA_SEL)
									}//$CTANEG>1
									if($CTANEG==1){//SELECCIONAR TIENDAS ASOCIADAS
											if(!empty($CD_ITM_SI) && !empty($COD_TIENDA_SEL) && !empty($COD_NEGOCIO_SEL)){
												$SQL="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO =".$COD_NEGOCIO_SEL;
												$RS = sqlsrv_query($maestra, $SQL);
												//oci_execute($RS);
												if ($row = sqlsrv_fetch_array($RS)) {
													$COD_NEGOCIO_SEL = $row['COD_NEGOCIO'];
													$DES_NEGOCIO = $row['DES_NEGOCIO'];
													$ELNEGOCIO = $DES_NEGOCIO;
												}
												$SQL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA =".$COD_TIENDA_SEL;
												$RS = sqlsrv_query($maestra, $SQL);
												//oci_execute($RS);
												if ($row = sqlsrv_fetch_array($RS)) {
													$DES_CLAVE = $row['DES_CLAVE'];
													$DES_CLAVE_F="0000".$DES_CLAVE;
													$DES_CLAVE_F=substr($DES_CLAVE_F, -4); 
													$DES_TIENDA = $row['DES_TIENDA'];
													$LATIENDA = $DES_CLAVE_F." ".$DES_TIENDA;
													$COD_TIENDA_SEL = $row['COD_TIENDA'];
												}
												?>
													<h8><?php echo $ELNEGOCIO."<BR>".$LATIENDA ?></h8>
													<input type="hidden" name="COD_NEGOCIO" value="<?php echo $COD_NEGOCIO_SEL?>">
													<input type="hidden" name="COD_TIENDA" value="<?php echo $COD_TIENDA_SEL?>">
												<?php
											} else {
											 ?>
													<select name="COD_TIENDA" onChange="document.forms.forming.submit();">
																<option value="0">SELECCIONAR TIENDA</option>
																<?php 
																$SQL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA IN(SELECT COD_TIENDA FROM US_USUTND WHERE IDUSU=".$SESIDUSU.") ORDER BY DES_CLAVE ASC";
																$RS = sqlsrv_query($maestra, $SQL);
																//oci_execute($RS);
																while ($row = sqlsrv_fetch_array($RS)) {
																		$COD_TIENDA = $row['COD_TIENDA'];
																		$DES_CLAVE = $row['DES_CLAVE'];
																		$DES_CLAVE_F="0000".$DES_CLAVE;
																		$DES_CLAVE_F=substr($DES_CLAVE_F, -4); 
																		$DES_TIENDA = $row['DES_TIENDA'];
																		$LATIENDA = $DES_CLAVE_F." ".$DES_TIENDA;
																			//VERIFICAR QUE TIENDA SE ENCUENTRE REGISTRADA Y/O CON PRECIOS ARTS.AS_ITM_STR
																			$SQL1="SELECT COUNT(ID_BSN_UN) AS VERTND FROM PA_STR_RTL WHERE CD_STR_RT=".$DES_CLAVE;
																			$RS1 = sqlsrv_query($arts_conn, $SQL1);
																			//oci_execute($RS1);
																			if ($row1 = sqlsrv_fetch_array($RS1)) {
																				$VERTND = $row1['VERTND'];
																			}
																		if($VERTND != 0){
																			 ?>
                                                                            <option value="<?php echo $COD_TIENDA ?>"  <?php if($COD_TIENDA==$COD_TIENDA_SEL) {echo "Selected";} ?>><?php echo $LATIENDA ?></option>
                                                                            <?php 
																		}
																}
																 ?>
												</select>
										<?php
												//OBTENER NEGOCIO
												$SQL1="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO IN(SELECT COD_NEGOCIO FROM US_USUTND WHERE IDUSU=".$SESIDUSU.") ";
												$RS1 = sqlsrv_query($maestra, $SQL1);
												//oci_execute($RS1);
												if ($row1 = sqlsrv_fetch_array($RS1)) {
													$COD_NEGOCIO_TND = $row1['COD_NEGOCIO'];
												}
										?>
                                        	<input type="hidden" name="COD_NEGOCIO" value="<?php echo $COD_NEGOCIO_TND?>">
                                        <?php
										}//!empty($CD_ITM_SI) && !empty($COD_TIENDA_SEL)
									}//$CTANEG==1
							}//$CTATND==0)


							if($CTATND==0){//SELECCIONAR NEGOCIO Y TIENDA
									if(!empty($CD_ITM_SI) && !empty($COD_TIENDA_SEL) && !empty($COD_NEGOCIO_SEL)){
												$SQL="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO =".$COD_NEGOCIO_SEL;
												$RS = sqlsrv_query($maestra, $SQL);
												//oci_execute($RS);
												if ($row = sqlsrv_fetch_array($RS)) {
													$COD_NEGOCIO_SEL = $row['COD_NEGOCIO'];
													$DES_NEGOCIO = $row['DES_NEGOCIO'];
													$ELNEGOCIO = $DES_NEGOCIO;
												}
												$SQL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA =".$COD_TIENDA_SEL;
												$RS = sqlsrv_query($maestra, $SQL);
												//oci_execute($RS);
												if ($row = sqlsrv_fetch_array($RS)) {
													$DES_CLAVE = $row['DES_CLAVE'];
													$DES_CLAVE_F="0000".$DES_CLAVE;
													$DES_CLAVE_F=substr($DES_CLAVE_F, -4); 
													$DES_TIENDA = $row['DES_TIENDA'];
													$LATIENDA = $DES_CLAVE_F." ".$DES_TIENDA;
													$COD_TIENDA_SEL = $row['COD_TIENDA'];
												}
												?>
													<h8><?php echo $ELNEGOCIO."<BR>".$LATIENDA ?></h8>
													<input type="hidden" name="COD_NEGOCIO" value="<?php echo $COD_NEGOCIO_SEL?>">
													<input type="hidden" name="COD_TIENDA" value="<?php echo $COD_TIENDA_SEL?>">
										<?php
									} else {
										?>
													<select name="COD_NEGOCIO" onChange="CargaTiendaSelectE(this.value, this.form.name, 'COD_TIENDA')">
																<option value="0">SELECCIONAR NEGOCIO</option>
																<?php 
																$SQL="SELECT * FROM MN_NEGOCIO ORDER BY DES_NEGOCIO ASC";
																$RS = sqlsrv_query($maestra, $SQL);
																//oci_execute($RS);
																while ($row = sqlsrv_fetch_array($RS)) {
																	$COD_NEGOCIO = $row['COD_NEGOCIO'];
																	$DES_NEGOCIO = $row['DES_NEGOCIO'];
																 ?>
																<option value="<?php echo $COD_NEGOCIO ?>" <?php if($COD_NEGOCIO==$COD_NEGOCIO_SEL) {echo "Selected";} ?>><?php echo $DES_NEGOCIO ?></option>
																<?php 
																}
																 ?>
												</select>
												<select style="clear:left" id="COD_TIENDA" name="COD_TIENDA" onChange="document.forms.forming.submit();">
													<option value="0">SELECCIONAR TIENDA</option>
													<?php
													if(!empty($COD_TIENDA_SEL)){
																$SQL="SELECT COD_TIENDA, DES_TIENDA, DES_CLAVE FROM MN_TIENDA WHERE COD_TIENDA IN(SELECT COD_TIENDA FROM MN_NEGTND WHERE COD_NEGOCIO=".$COD_NEGOCIO_SEL.")   ORDER BY DES_CLAVE ASC";
																$RS = sqlsrv_query($maestra, $SQL);
																//oci_execute($RS);
																$VERTND=0;
																while ($row = sqlsrv_fetch_array($RS)) {
																	$NUM_TIENDA = $row['DES_CLAVE'];
																	$NUM_TIENDA_F="0000".$NUM_TIENDA;
																	$NUM_TIENDA_F=substr($NUM_TIENDA_F, -4); 
																	$STRDES = $row['DES_TIENDA'];
																	$STRCOD =$row['COD_TIENDA'];
																	//VERIFICAR QUE TIENDA SE ENCUENTRE REGISTRADA Y/O CON PRECIOS ARTS.AS_ITM_STR
																	$SQL1="SELECT COUNT(ID_BSN_UN) AS VERTND FROM PA_STR_RTL WHERE CD_STR_RT=".$NUM_TIENDA;
																	$RS1 = sqlsrv_query($arts_conn, $SQL1);
																	//oci_execute($RS1);
																	if ($row1 = sqlsrv_fetch_array($RS1)) {
																		$VERTND = $row1['VERTND'];
																	}
																if($VERTND != 0){
																 ?>
                                                                        <option value="<?php echo $STRCOD ?>" <?php if($STRCOD==$COD_TIENDA_SEL) {echo "Selected";} ?> ><?php echo $NUM_TIENDA_F." - ".$STRDES ?></option>
																<?php 
																}
																}
													}
													?>
												</select>
										<?php
									}//!empty($CD_ITM_SI) && !empty($COD_TIENDA_SEL)
							}//if($CTATND==0)



						?>
                        </td>
                </tr>
                <tr>
                   <td>
                            <label for="COD_FTIPO">Tipo de Fleje</label>
                   </td>
                   <td>
                   <?php
				   if($NOCAMBIARTIPO==0){
				   ?>
                            <select name="COD_FTIPO" onChange="document.forms.forming.submit();">
                            <option value="0">Seleccionar</option>
                            <?php 
                            $SQLFILTRO="SELECT * FROM FLJ_TIPO WHERE EST_FTIPO=1 ORDER BY NOM_FTIPO";
                            $RSF = sqlsrv_query($conn, $SQLFILTRO);
                            //oci_execute($RSF);
                            while ($rowF = sqlsrv_fetch_array($RSF)) {
                                $ID_FTIPO = $rowF['ID_FTIPO'];
                                $NOM_FTIPO = $rowF['NOM_FTIPO'];
                                $COD_FTIPO = $rowF['COD_FTIPO'];
                             ?>
                            <option value="<?php echo $COD_FTIPO ?>" <?php if($COD_FTIPO==$COD_FTIPO_SEL) {echo "Selected";} ?>><?php echo $NOM_FTIPO ?></option>
                            <?php 
                            }
                             ?>
                            </select>
                   <?php
				   } else {//if($NOCAMBIARTIPO==0)
						$SQLT="SELECT * FROM FLJ_TIPO WHERE COD_FTIPO='".$COD_FTIPO_SEL."'";
						$RST = sqlsrv_query($conn, $SQLT);
						//oci_execute($RST);
						if ($rowT = sqlsrv_fetch_array($RST)) {
							$NOM_FTIPO = $rowT['NOM_FTIPO'];
						}
				   ?>
                   		<label style="text-align:left" for="TIPOF"><?php echo $NOM_FTIPO ?></label>
                        <input type="hidden" name="COD_FTIPO" value="<?php echo $COD_FTIPO_SEL?>">
                   <?php
				   }//if($NOCAMBIARTIPO==0)
				   ?>
                   </td>
                </tr>
                <?php
				if($VERTND_UNO==0 && $CTATND==1){
				?>
                <tr>
                   <td style="background-color:#FFC"></td>
                   <td style="background-color:#FFC">
                            <label style="color:#C00" for="ITEM">Atenci&oacute;n: Tienda no Asociada a Sistema, verifique</label>
                   </td>
                </tr>
                <?php
				} else { //$VERTND_UNO
				?>
                <tr>
                   <td>
                            <label for="CD_ITM">C&oacute;digo Art&iacute;culo</label>
                   </td>
                   <td>
                   			<input style="text-align:right" name="CD_ITM" type="text"  id="CD_ITM" size="15" maxlength="15" value="<?php if(empty($REGFLJTMP)){ echo $CD_ITM_SI;}?>" onKeyPress="return acceptNum(event);"  onChange="document.forms.forming.submit();">
                            <input name="BUSCARARTICULO" type="button" value="Buscar" onClick="ActivarSearchItem()">
                   </td>
                </tr>
                <?php
                $NOENCONTRADO=0;
				if(!empty($CD_ITM_SI) && empty($REGFLJTMP)){
						//COMPROBAR Y DESPLEGAR NOMBRE DE ARTÍCULO
						
						
									//CODIGO EAN
										$SQLIT="SELECT ID_ITM FROM ID_PS WHERE ID_ITM_PS=".$CD_ITM_SI;
										$RSI = sqlsrv_query($arts_conn, $SQLIT);
										//oci_execute($RSI);
										if ($rowi = sqlsrv_fetch_array($RSI)) {
											$ID_ITM_EAN = $rowi['ID_ITM'];
											$CODIGO_EAN = $CD_ITM_SI;
											$ES_EAN = 1;
										} else {
											$NOENCONTRADO=1;
											$ES_EAN = 0;
										}
										if($NOENCONTRADO==0){
													//ENCONTRÓ EL CODIGO EAN
													//VERIFICA TIENDA
													$SQLIT="SELECT * FROM AS_ITM WHERE ID_ITM=".$ID_ITM_EAN;
													$RSI = sqlsrv_query($arts_conn, $SQLIT);
													//oci_execute($RSI);
													if ($rowi = sqlsrv_fetch_array($RSI)) {
														$NM_ITM = $rowi['NM_ITM'];
													} 
													$SQLIT="SELECT * FROM AS_ITM_STR WHERE ID_ITM=".$ID_ITM_EAN." AND ID_BSN_UN=".$ID_BSN_UN_SEL;
													$RSI = sqlsrv_query($arts_conn, $SQLIT);
													//oci_execute($RSI);
													if ($rowi = sqlsrv_fetch_array($RSI)) {
														$SLS_PRC = $rowi['SLS_PRC'];
														$PREC_ITM=$SLS_PRC/$DIVCENTS;
														$PREC_ITM=number_format($PREC_ITM, $CENTS, $GLBSDEC, $GLBSMIL);
													} else {
														$NOENCONTRADO=1;
													}
										}
										if($NOENCONTRADO==1){
												$NOENCONTRADO=0;
												//NO ENCONTRÓ EL CÓDIGO EAN, BUSCA EL CODIGO ACE
												//CODIGO TIENDA
													$SQLIT="SELECT * FROM AS_ITM WHERE CD_ITM=".$CD_ITM_SI;
													$RSI = sqlsrv_query($arts_conn, $SQLIT);
													//oci_execute($RSI);
													if ($rowi = sqlsrv_fetch_array($RSI)) {
														$ID_ITM = $rowi['ID_ITM'];
														$NM_ITM = $rowi['NM_ITM'];
													} else {
														$NOENCONTRADO=1;
													}
													if($NOENCONTRADO==0){
														$SQLIT="SELECT * FROM AS_ITM_STR WHERE ID_ITM=".$ID_ITM." AND ID_BSN_UN=".$ID_BSN_UN_SEL;
														$RSI = sqlsrv_query($arts_conn, $SQLIT);
														//oci_execute($RSI);
														if ($rowi = sqlsrv_fetch_array($RSI)) {
															$SLS_PRC = $rowi['SLS_PRC'];
															$PREC_ITM=$SLS_PRC/$DIVCENTS;
															$PREC_ITM=number_format($PREC_ITM, $CENTS, $GLBSDEC, $GLBSMIL);
														} else {
															$NOENCONTRADO=1;
														}
													}
												//BUSCA EL CÓDIGO EAN
												if($NOENCONTRADO==0){
														$SQLIT="SELECT ID_ITM_PS FROM ID_PS WHERE ID_ITM=".$ID_ITM;
														$RSI = sqlsrv_query($arts_conn, $SQLIT);
														//oci_execute($RSI);
														if ($rowi = sqlsrv_fetch_array($RSI)) {
															$CODIGO_EAN = $rowi['ID_ITM_PS'];
														} else {
															$CODIGO_EAN = $CD_ITM_SI;
														}
												}
										}
						if($NOENCONTRADO==0){
							//MOSTRAR ITEM
							?>
                            <tr>
                               <td></td>
                               <td>
                                      <label style="text-align:left; font-weight:300; font-size:12pt; margin:0; padding:0" for="ITEM"><?php echo $NM_ITM?></label>
                                      <label style="text-align:left; font-weight:400; font-size:16pt; margin:0; padding:0" for="ITEM"><?php echo $MONEDA.$PREC_ITM?></label>
                                      <label style="text-align:left; font-weight:600; font-size:9pt; margin:0; padding:0" for="ITEM"><?php echo "C&oacute;digo EAN ".$CODIGO_EAN?></label>
                               </td>
                            </tr>
                            <?php
						} else {
							//ITEM NO EXISTE
							?>
                            <tr>
                               <td></td>
                               <td>
                                      <label style="text-align:left; color:#C00" for="ITEM">Atenci&oacute;n: C&oacute;digo de Art&iacute;culo no disponible, verifique</label>
                               </td>
                            </tr>
                            <?php
						}
				}  //$VERTND_UNO
				?>
                <?php
				}
				?>
                </form>
                </table>
                <table>
                <?php if($NOENCONTRADO==0 && !empty($CD_ITM_SI)){ ?>

					<script language="JavaScript">
                    function validaFleje(theForm){
                        
                            if (theForm.QN_ITM.value == ""){
                                    alert("COMPLETE LA DATA REQUERIDA - CANTIDAD.");
                                    theForm.QN_ITM.focus();
									return false;
                            }
                            if (theForm.CD_ITM.value == ""){
                                    alert("COMPLETE LA DATA REQUERIDA - CODIGO ITEM.");
                                    theForm.CD_ITM.focus();
									return false;
                            }
                            if (theForm.COD_TIENDA.value == 0){
                                    alert("COMPLETE LA DATA REQUERIDA.");
                                    theForm.COD_TIENDA.focus();
                                    return false;
                            }
                            if (theForm.COD_FTIPO.value == 0){
                                    alert("COMPLETE LA DATA REQUERIDA - TIPO FLEJE.");
                                    theForm.COD_FTIPO.focus();
									return false;
                            }
                    
                    } //validaFleje(theForm)
                    </script>

                <form action="print_flejes.php?NEO=1" method="post" name="formflj" onSubmit="return validaFleje(this)">
                <tr>
                   <td>
                            <label for="QN_ITM">Cantidad Flejes</label>
                   </td>
                   <td>
                   			<input style="text-align:right" name="QN_ITM" type="text"  id="QN_ITM" size="4" maxlength="4"  onKeyPress="return acceptNum(event);">
                   			<input type="submit" name="REG_ITM" value="Agregar">
                   			<input type="hidden" name="ES_EAN" value="<?php echo $ES_EAN?>">
                   			<input type="hidden" name="CD_ITM" value="<?php echo $CD_ITM_SI?>">
                   			<input type="hidden" name="COD_NEGOCIO" value="<?php echo $COD_NEGOCIO_SEL?>">
                   			<input type="hidden" name="COD_TIENDA" value="<?php echo $COD_TIENDA_SEL?>">
                   			<input type="hidden" name="COD_FTIPO" value="<?php echo $COD_FTIPO_SEL?>">
                   			<input type="hidden" name="REGFLJTMP" value="1">
                   </td>
                </tr>
                </form>
                <?php }// if($NOENCONTRADO==0){ ?>
                
                
                <?php
				//PRE-REGISTRO DE ITEMS...
				$QN_ITM=@$_POST["QN_ITM"];
				if($REGFLJTMP==1){
					if($REGISTRAR == 1){
						$SQL2="SELECT IDENT_CURRENT ('IMP_FLJ') AS MID_FLEJE";
						$RS2 = sqlsrv_query($conn, $SQL2);
						//oci_execute($RS2);
						if ($row2 = sqlsrv_fetch_array($RS2)) {
								$ID_FLEJE=$row2['MID_FLEJE']+1;
						} else {
								$ID_FLEJE=1;
						}
							$SQL="INSERT INTO IMP_FLJ (COD_TIENDA, COD_NEGOCIO, COD_FTIPO, IDREG) ";
							$SQL=$SQL." VALUES (".$COD_TIENDA_SEL.", ".$COD_NEGOCIO_SEL.", '".$COD_FTIPO_SEL."', ".$SESIDUSU.")";
							$RS = sqlsrv_query($conn, $SQL);
							//oci_execute($RS);
					}
					//DETECTAR QUE VIENE EN $CD_ITM_SI (EAN OR CODE)
					if($ES_EAN == 1){
						//$CD_ITM_SI ES EAN, CONSEGUIR EL CD_ITM
								$SQLIT="SELECT ID_ITM FROM ID_PS WHERE ID_ITM_PS=".$CD_ITM_SI;
								$RSI = sqlsrv_query($arts_conn, $SQLIT);
								//oci_execute($RSI);
								if ($rowi = sqlsrv_fetch_array($RSI)) {
									$ID_ITM_TR = $rowi['ID_ITM'];
								}
								$SQLIT="SELECT CD_ITM FROM AS_ITM WHERE ID_ITM=".$ID_ITM_TR;
								$RSI = sqlsrv_query($arts_conn, $SQLIT);
								//oci_execute($RSI);
								if ($rowi = sqlsrv_fetch_array($RSI)) {
									$CD_ITM_SI = $rowi['CD_ITM'];
								}
						}
					//VERIFICAR SI ITEM YA ESTABA INGRESADO
							$SQL2="SELECT * FROM IMP_FLJART WHERE ID_FLEJE=".$ID_FLEJE." AND CD_ITM=".$CD_ITM_SI;
							$RS2 = sqlsrv_query($conn, $SQL2);
							//oci_execute($RS2);
							if ($row2 = sqlsrv_fetch_array($RS2)) {
								$QN_ITM_PR=$row2['QN_ITM']+$QN_ITM;
								$SQL="UPDATE IMP_FLJART SET QN_ITM=".$QN_ITM_PR." WHERE ID_FLEJE=".$ID_FLEJE." AND CD_ITM=".$CD_ITM_SI;
								$RS = sqlsrv_query($conn, $SQL);
								//oci_execute($RS);
							} else {
								$SQL="INSERT INTO IMP_FLJART (ID_FLEJE, CD_ITM, QN_ITM) ";
								$SQL=$SQL." VALUES (".$ID_FLEJE.", ".$CD_ITM_SI.", ".$QN_ITM.")";
								$RS = sqlsrv_query($conn, $SQL);
								//oci_execute($RS);
							}
					
					
				}
				//LISTADO DE ITEMS SELECCIONADOS
				$SQLF="SELECT * FROM IMP_FLJ WHERE ID_FLEJE=".@$ID_FLEJE." AND ID_FLEJE IN(SELECT ID_FLEJE FROM IMP_FLJART)";
				$RSF = sqlsrv_query($conn, $SQLF);
				//oci_execute($RSF);
				if ($rowF = @sqlsrv_fetch_array($RSF)) {
				?>
                	<tr>
                    	<td colspan="2">
                        <h3>Art&iacute;culos Seleccionados para Impresi&oacute;n</h3>
                        		<table id="Listado" width="100%">
                                    <tr>
                                        <th>Item</th>
                                        <th>C&oacute;d.Art.</th>
                                        <th>Art&iacute;culo</th>
                                        <th>Precio</th>
                                        <th>N&uacute;m.Flejes</th>
                                        <th></th>
                                   </tr>
                                   <?php
									$SQLA="SELECT * FROM IMP_FLJART WHERE ID_FLEJE=".$ID_FLEJE." ORDER BY ID_FLJART DESC";
									$RSA = sqlsrv_query($conn, $SQLA);
									//oci_execute($RSA);
									$CONTADOR=1;
									while ($rowA = sqlsrv_fetch_array($RSA)) {
											$CD_ITM=$rowA['CD_ITM'];
											$QN_ITM=$rowA['QN_ITM'];
											$ID_FLJART=$rowA['ID_FLJART'];
											$SQLI="SELECT * FROM AS_ITM WHERE CD_ITM=".$CD_ITM;
											$RSI = sqlsrv_query($arts_conn, $SQLI);
											//oci_execute($RSI);
											if ($rowI = sqlsrv_fetch_array($RSI)) {
												$ID_ITM=$rowI['ID_ITM'];
												$NM_ITM=$rowI['NM_ITM'];
											}
											$SQLI="SELECT * FROM AS_ITM_STR WHERE ID_ITM=".$ID_ITM." AND ID_BSN_UN=".$ID_BSN_UN_SEL;
											$RSI = sqlsrv_query($arts_conn, $SQLI);
											//oci_execute($RSI);
											if ($rowI = sqlsrv_fetch_array($RSI)) {
												$SLS_PRC=$rowI['SLS_PRC'];
												$PREC_ITM=$SLS_PRC/$DIVCENTS;
												$PREC_ITM=number_format($PREC_ITM, $CENTS, $GLBSDEC, $GLBSMIL);
											}
											//DESPLEGAR CODIGO EAN
											$SQLI="SELECT * FROM ID_PS WHERE ID_ITM=".$ID_ITM;
											$RSI = sqlsrv_query($arts_conn, $SQLI);
											//oci_execute($RSI);
											if ($rowI = sqlsrv_fetch_array($RSI)) {
												$CODE_EAN=$rowI['ID_ITM_PS'];
											}
									?>
                                    <tr>
                                    	<td style="text-align:right"><?php echo $CONTADOR;?></td>
                                    	<td style="text-align:right"><?php echo $CODE_EAN;?></td>
                                    	<td><?php echo $NM_ITM;?></td>
                                    	<td style="text-align:right"><?php echo $MONEDA.$PREC_ITM;?></td>
                                    	<td style="text-align:right"><?php echo $QN_ITM;?></td>
                                    	<td class="FormCelda"><input class="BotonCelda"  type="button" value="Quitar" onClick="pagina('print_flejes.php?NEO=1&ELMART=<?php echo $ID_FLJART?>&COD_NEGOCIO=<?php echo $COD_NEGOCIO_SEL?>&COD_TIENDA=<?php echo $COD_TIENDA_SEL?>&COD_FTIPO=<?php echo $COD_FTIPO_SEL?>');"></td>
                                    </tr>
                                    <?php
										$CONTADOR=$CONTADOR+1;
									} //LISTADO DE ARTICULOS
								   ?>
                                </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:left"><input type="button" name="ELMARCHIVO" value="Salir sin registrar" onClick="paginaSalir('print_flejes_reg.php?ELMFLEJE=<?php echo $ID_FLEJE;?>');"> </td>
                        <td style="text-align:right"><input type="button" name="REGARCHIVO" value="Imprime Fleje(s)" onClick="paginaPrint('print_flejes_reg.php?REGFLEJE=<?php echo $ID_FLEJE;?>&COD_FTIPO=<?=$COD_FTIPO_SEL?>');"></td>
                    </tr>
				<?php
				}//$REGISTRAR==1
				?>
                </table>
                
                </td></tr>
                </table>
				<?php include("SearchItem.php");?>

        <?php } //NEO=1?>
        
                        <script>
							if (document.forming.CD_ITM.value == ""){
								document.forming.CD_ITM.focus();
							} else {
								document.formflj.QN_ITM.focus();
							}
                        </script>
        
        
        </table>
</td>
</tr>
</table>
        <iframe name="frmHIDEN" width="0%" height="0" frameborder="0" align="top" src="" framespacing="0" marginheight="0" marginwidth="0">
        </iframe>
</body>
</html>

