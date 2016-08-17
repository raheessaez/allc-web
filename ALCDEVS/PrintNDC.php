<?php include("conecta.inc");?>
<?php
	$ID_DEVS=@$_GET["ddv"];
	$SQL="UPDATE DV_TICKET SET ID_ESTADO=3 WHERE ID_DEVS=".$ID_DEVS;
	//$RS = sqlsrv_query($conn, $SQL);
	////oci_execute($RS);
	$RS = sqlsrv_query($conn,$SQL);

?>
<html><head><meta http-equiv="X-UA-Compatible" content="IE=9">	      <!-- IE9 Standards -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="robots" content="noarchive"/>
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
<meta name="description" content="Alliances"/>
<meta name="author" content="Design: Alliances | Code: Claudio Arellano">
<title>Nota de Cr&eacute;dito <?php echo $ID_DEVS?></title>
<link rel="shortcut icon" href="../images/favicon.ico">
<link rel="stylesheet" href="../css/OpenSans.css" media="screen">
<link rel="stylesheet" href="../css/_mng_estilos.css" media="screen">
<script language=JavaScript src="../js/javascript.js"></script>
<script language=JavaScript src="funciones.js"></script>

</head>

<body style="background-color:#FFF">


        <table style="width:100%">
        <tr>
                <td style="background-color:#F1F1F1; background-image:url(../images/ARMS.png); background-repeat:no-repeat; background-position: 20px 10px; height:65px; min-height:65px; border:none">
                    <div id="BtnVentana" style="background-image:url(../images/ICO_CloseVN.png); margin-right:16px"  title="Cerrar Ventana"><img src="images/Transpa.png" width="45" height="45" onClick="javascript: window.close();"  /></div>
                    <div id="BtnVentana" style="background-image:url(../images/ICO_PrintVN.png);" title="Imprime Cotizaci&oacute;n"><img src="images/Transpa.png" width="45" height="45" onClick="javascript: window.print();" /></div>
                </td>
        </tr>
        </table>

        <table style="width:100%">
        <tr>
        <td style="padding:20px">

				<?php
                //DATA CLIENTE
                    $SQL="SELECT * FROM DV_TICKET WHERE  ID_DEVS=".$ID_DEVS;
                    
                    //$RS = sqlsrv_query($conn, $SQL);
                    ////oci_execute($RS);
                    $RS = sqlsrv_query($conn,$SQL);

                    if ($row = sqlsrv_fetch_array($RS)) {
                        $ID_BSN_UN = $row['COD_TIENDA'];
                        $ID_TRN = $row['ID_TRN'];
                        $ID_TIPOD = $row['ID_TIPOD'];
                    }
				 if($ID_TIPOD==3){
							$SQLF="SELECT * FROM TR_INVC WHERE ID_TRN=".$ID_TRN;
							
							//$RSF = sqlsrv_query($arts_conn, $SQLF);
							////oci_execute($RSF);
							$RSF = sqlsrv_query($arts_conn,$SQLF);

							if ($rowf = sqlsrv_fetch_array($RSF)) {
								$INVC_NMB = $rowf['INVC_NMB'];
								$ID_CPRF = $rowf['ID_CPR'];
								$FL_CPF = $rowf['FL_CP'];
							}
				 } else {
							$SQL="SELECT * FROM DV_DEVCLTE WHERE ID_DEVS=".$VER_DNC;
							
							//$RS= sqlsrv_query($conn, $SQL);
							////oci_execute($RS);
							$RS = sqlsrv_query($conn,$SQL);

							if ($row = sqlsrv_fetch_array($RS)) {
								$ID_CPRF = $row['ID_CPR'];
								$TY_CPRF = $row['TY_CPR'];
								if($TY_CPRF!="P"){ $FL_CPF=0; } else { $FL_CPF=1; }
							}
				 }
				 if($FL_CPF==0){
						$SQL="SELECT * FROM CO_CPR_CER WHERE ID_CPR=".$ID_CPRF;
						//$RS= sqlsrv_query($arts_conn, $SQL);
						////oci_execute($RS);
						$RS = sqlsrv_query($arts_conn,$SQL);

						if ($row1 = sqlsrv_fetch_array($RS)) {
							$IDENTIFICACION_F = $row1['CD_CPR'];
							$NOMBRE_F = $row1['NOMBRE'];
							$DIRECCION_F = $row1['DIRECCION'];
							$COD_REGION = $row1['COD_REGION'];
							$COD_CIUDAD = $row1['COD_CIUDAD'];
									$SQL2="SELECT DES_CIUDAD FROM PM_CIUDAD WHERE COD_CIUDAD=".$COD_CIUDAD;
									
									//$RS2 = sqlsrv_query($maestra, $SQL2);
									////oci_execute($RS2);
									$RS2 = sqlsrv_query($maestra,$SQL2);
									
									if ($row2 = sqlsrv_fetch_array($RS2)) {
										$DES_CIUDAD_F = ", ".strtoupper($row2['DES_CIUDAD']);
									}
									$SQL2="SELECT DES_REGION, ABR_REGION FROM PM_REGION WHERE COD_REGION=".$COD_REGION;
									
									//$RS2 = sqlsrv_query($maestra, $SQL2);
									////oci_execute($RS2);
									$RS2 = sqlsrv_query($maestra,$SQL2);

									if ($row2 = sqlsrv_fetch_array($RS2)) {
										$DES_REGION = $row2['DES_REGION'];
										$ABR_REGION = $row2['ABR_REGION'];
										if(!empty($ABR_REGION)){$DES_REGION = $DES_REGION." (".$ABR_REGION.")";}
									} else {
										$DES_REGION = "";
									}
							$TELEFONO_F = $row1['TELEFONO'];
							$CORREO_F = strtolower($row1['CORREO']);
							if($TY_CPR_F=="C"){$CPR_TY_F = "C.I. No. ";}
							if($TY_CPR_F=="R"){$CPR_TY_F = "R.U.C. ";}
						}
				} else {
						$SQL="SELECT * FROM CO_EXT_CER WHERE ID_CPR=".$ID_CPRF;
						
						//$RS= sqlsrv_query($arts_conn, $SQL);
						////oci_execute($RS);
						$RS = sqlsrv_query($arts_conn,$SQL);
						
						if ($row2 = sqlsrv_fetch_array($RS)) {
							$IDENTIFICACION_F = $row2['CD_CPR'];
							$NOMBRE_F = $row2['NOMBRE'];
							$DIRECCION_F = $row2['DIRECCION'];
							$NACIONALIDAD_F = $row2['NACIONALIDAD'];
							$TELEFONO_F = $row2['TELEFONO'];
							$CORREO_F = strtolower($row2['CORREO']);
							$CPR_TY_F = "Pasaporte: ";
						}
				}

                    $SQL="SELECT * FROM PA_STR_RTL WHERE ID_BSN_UN=".$ID_BSN_UN;
                    
                    //$RS = sqlsrv_query($arts_conn, $SQL);
                    ////oci_execute($RS);
                    $RS = sqlsrv_query($arts_conn,$SQL);

                    if ($row = sqlsrv_fetch_array($RS)) {
                        $CD_STR_RT = $row['CD_STR_RT'];
                    }

					$SQL="SELECT * FROM DV_DEVCLTE WHERE ID_DEVS=".$ID_DEVS;
					
					//$RS= sqlsrv_query($conn, $SQL);
					////oci_execute($RS);
					$RS = sqlsrv_query($conn,$SQL);
					
					if ($row = sqlsrv_fetch_array($RS)) {
						$ID_CPR = $row['ID_CPR'];
						$TY_CPR = $row['TY_CPR'];
						if($TY_CPR!="P"){ $FL_CP=0; } else { $FL_CP=1; }
					}
				 
				 if($FL_CP==0){
						$SQL="SELECT * FROM CO_CPR_CER WHERE ID_CPR=".$ID_CPR;
						
						//$RS= sqlsrv_query($arts_conn, $SQL);
						////oci_execute($RS);
						$RS = sqlsrv_query($arts_conn,$SQL);

						if ($row1 = sqlsrv_fetch_array($RS)) {
							$IDENTIFICACION = $row1['CD_CPR'];
							$NOMBRE = $row1['NOMBRE'];
							$DIRECCION = $row1['DIRECCION'];
							$COD_REGION = $row1['COD_REGION'];
							$COD_CIUDAD = $row1['COD_CIUDAD'];
									$SQL2="SELECT DES_CIUDAD FROM PM_CIUDAD WHERE COD_CIUDAD=".$COD_CIUDAD;
									
									//$RS2 = sqlsrv_query($maestra, $SQL2);
									////oci_execute($RS2);
									$RS2 = sqlsrv_query($maestra,$SQL2);

									if ($row2 = sqlsrv_fetch_array($RS2)) {
										$DES_CIUDAD = ", ".strtoupper($row2['DES_CIUDAD']);
									}
									$SQL2="SELECT DES_REGION, ABR_REGION FROM PM_REGION WHERE COD_REGION=".$COD_REGION;
									
									//$RS2 = sqlsrv_query($maestra, $SQL2);
									////oci_execute($RS2);
									$RS2 = sqlsrv_query($maestra,$SQL2);
									
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
						
						//$RS= sqlsrv_query($arts_conn, $SQL);
						////oci_execute($RS);
						$RS = sqlsrv_query($arts_conn,$SQL);

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
                <h3>Nota de Cr&eacute;dito <?php echo $ID_DEVS?></h3>

				<?php if($ID_TIPOD==3){ ?>
                <h3>Factura Afecta N&deg; <?php echo $INVC_NMB;?></h3>
                <p>Nombre: <?php echo $NOMBRE_F;?>, <?php echo $CPR_TY_F;?> <?php echo $IDENTIFICACION_F;?></p>
						<?php if($TY_CPR_F!="P"){ ?>
                            <p>Direcci&oacute;n: <?php echo $DIRECCION_F.$DES_CIUDAD_F." ".$DES_REGION;?></p>
						<?php } else { ?>
                            <p>Nacionalidad: <?php echo $NACIONALIDAD_F;?></p>
                            <p>Direcci&oacute;n: <?php echo $DIRECCION_F;?></p>
                        <?php } ?>
                        <p>Tel&eacute;fono: <?php echo $TELEFONO_F;?>, e-mail: <?php echo $CORREO_F;?></p>
				<?php } else { ?>
                		<p>Cliente: <?php echo $NOMBRE;?>, <?php echo $CPR_TY;?> <?php echo $IDENTIFICACION;?></p>
						<?php if($TY_CPR!="P"){ ?>
                            <p>Direcci&oacute;n: <?php echo $DIRECCION.$DES_CIUDAD." ".$DES_REGION;?></p>
						<?php } else { ?>
                            <p>Nacionalidad: <?php echo $NACIONALIDAD;?></p>
                            <p>Direcci&oacute;n: <?php echo $DIRECCION;?></p>
                        <?php } ?>
                        <p>Tel&eacute;fono: <?php echo $TELEFONO;?>, e-mail: <?php echo $CORREO;?></p>
				<?php } ?>

                <h3>Art&iacute;culos</h3>
                
                                    <table style="width:100%">
                                            <tr>
                                                <th style="text-align:right; padding:10px">It.</th>
                                                <th style="text-align:left; padding:10px">C&oacute;digo</th>
                                                <th style="text-align:left; padding:10px">Art&iacute;culo</th>
                                                <th style="text-align:right; padding:10px">Prec.Unit.</th>
                                                <th style="text-align:right; padding:10px">Cantidad</th>
                                                <th style="text-align:right; padding:10px">Total</th>
                                            </tr>
                                            <?php
                                            $SQL="SELECT * FROM DV_ARTS WHERE ID_DEVS=".$ID_DEVS." ORDER BY ID_ART ASC";
                                            
                                            //$RS= sqlsrv_query($conn, $SQL);
                                            ////oci_execute($RS);
                                            $RS = sqlsrv_query($conn,$SQL);
                                            
                                            $ITEM_NUM=1;
                                            $MONTO_TOT_DEV=0;
                                            while ($row = sqlsrv_fetch_array($RS)) {
												$ID_ITM = $row['ID_ITM'];
												$TY_REGITM = $row['TY_REGITM'];
												
															//CODIGO ITEM
															$SQL1="SELECT * FROM ID_PS WHERE ID_ITM=".$ID_ITM;
															
															//$RS1= sqlsrv_query($arts_conn, $SQL1);
															////oci_execute($RS1);
															$RS1 = sqlsrv_query($arts_conn,$SQL1);

															if ($row1 = sqlsrv_fetch_array($RS1)) {
																$ID_ITM_PS =  $row1['ID_ITM_PS'];
															}
															//DATA ITEM
															$SQL1="SELECT * FROM AS_ITM WHERE ID_ITM=".$ID_ITM;
															
															//$RS1= sqlsrv_query($arts_conn, $SQL1);
															////oci_execute($RS1);
															$RS1 = sqlsrv_query($arts_conn,$SQL1);
															
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
                                                <td style="width:40px; max-width:40px; border-top:1px solid #000; padding:10px;"><?php echo $ITEM_NUM;?></th>
                                                <td style="border-top:1px solid #000; padding:10px;"><?php echo $ID_ITM_PS;?></td>
                                                <td style="border-top:1px solid #000; padding:10px 4px; "><?php echo $NM_ITM;?></td>
                                                <td style="text-align:right; border-top:1px solid #000; padding:10px; "><?php echo $MONEDA.$PREC_UNIT_F;?></td>
                                                <td style="text-align:right; border-top:1px solid #000; padding:10px; "><?php echo $CANTIDAD_F;?></td>
                                                <td style="text-align:right; border-top:1px solid #000; padding:10px; "><?php echo $MONEDA.$MONTO_DEV_F;?></td>
                                            </tr>
                                            <?php
                                            $ITEM_NUM=$ITEM_NUM+1;
                                            }
											$MONTO_TOT_DEV_F=$MONTO_TOT_DEV/$DIVCENTS;
											$MONTO_TOT_DEV_F=number_format($MONTO_TOT_DEV_F, $CENTS, $GLBSDEC, $GLBSMIL);
            
                                            ?>
                                            <tr>
                                                <td colspan="5"  style="text-align:right; font-weight:600; padding:10px; border-top:1px solid #000; ">Total</td>
                                                <td style="text-align:right; font-weight:600; padding:10px; border-top:1px solid #000; "><?php echo $MONEDA.$MONTO_TOT_DEV_F;?></td>
                                            </tr>
                                    </table>

                </td>
           </tr>
    </table>

</body>
</html>