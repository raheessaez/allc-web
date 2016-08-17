<?php include("conecta.inc");?>
<?php
	$ID_COT=@$_GET["idcot"];
	$ID_COT_F = "000000000".$ID_COT;
	$ID_COT_F = substr($ID_COT_F, -9); 
?>
<html><head><meta http-equiv="X-UA-Compatible" content="IE=9">	      <!-- IE9 Standards -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="robots" content="noarchive"/>
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
<meta name="description" content="Alliances"/>
<meta name="author" content="Design: Alliances | Code: Claudio Arellano">
<title>Cotizaci&oacute;n <?=$ID_COT_F." al ".$FECSRV?></title>
<link rel="shortcut icon" href="../images/favicon.ico">
<link rel="stylesheet" href="../css/OpenSans.css" media="screen">
<link rel="stylesheet" href="../css/_mng_estilos.css" media="screen">
<script language=JavaScript src="../js/javascript.js"></script>
<link rel="stylesheet" href="css/_mng_estilos.css" media="screen">
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
                    $SQL="SELECT * FROM IMP_COT WHERE  ID_COT=".$ID_COT;
                    $RS = sqlsrv_query($conn, $SQL);
                    //oci_execute($RS);
                    if ($row = sqlsrv_fetch_array($RS)) {
                        $COD_TIENDA = $row['COD_TIENDA'];
                        $ID_WS = $row['ID_WS'];
                        $FECHA_ACT = $row['FECHA_ACT'];
                    }
                    $SQL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA=".$COD_TIENDA;
                    $RS = sqlsrv_query($maestra, $SQL);
                    //oci_execute($RS);
                    if ($row = sqlsrv_fetch_array($RS)) {
                        $DES_CLAVE = $row['DES_CLAVE'];
						$DES_CLAVE_F="0000".$DES_CLAVE;
						$DES_CLAVE_F=substr($DES_CLAVE_F, -4); 
                        $DES_TIENDA = $row['DES_TIENDA'];
						$LATIENDA = $DES_CLAVE_F." ".$DES_TIENDA;
					}

                    $SQL="SELECT * FROM PA_STR_RTL WHERE CD_STR_RT=".$DES_CLAVE;
                    $RS = sqlsrv_query($arts_conn, $SQL);
                    //oci_execute($RS);
                    if ($row = sqlsrv_fetch_array($RS)) {
                        $ID_BSN_UN = $row['ID_BSN_UN'];
                    }
					if($ID_WS!=0){
							$SQL="SELECT * FROM AS_WS WHERE ID_WS=".$ID_WS;
							$RS = sqlsrv_query($arts_conn, $SQL);
							//oci_execute($RS);
							if ($row = sqlsrv_fetch_array($RS)) {
								$EL_POS = $row['CD_WS'];
							} else {
								$EL_POS = "No seleccionado";
							}
					}
                    $SQL="SELECT COD_CLIENTE FROM CO_COTCLTE WHERE  ID_COT=".$ID_COT;
                    $RS = sqlsrv_query($conn, $SQL);
                    //oci_execute($RS);
                    if ($row = sqlsrv_fetch_array($RS)) {
                        $COD_CLIENTE = $row['COD_CLIENTE'];
                    }
                    $SQL="SELECT * FROM CO_CLIENTE WHERE  COD_CLIENTE=".$COD_CLIENTE;
                    $RS = sqlsrv_query($conn, $SQL);
                    //oci_execute($RS);
                    if ($row = sqlsrv_fetch_array($RS)) {
                        $IDENTIFICACION = $row['IDENTIFICACION'];
                        $NOMBRE = $row['NOMBRE'];
                        $APELLIDO_P = $row['APELLIDO_P'];
                        $APELLIDO_M = $row['APELLIDO_M'];
                        $CLIENTE = $NOMBRE." ".$APELLIDO_P." ".$APELLIDO_M;
                        $DIRECCION = $row['DIRECCION'];
                        $COD_REGION = $row['COD_REGION'];
                        $COD_CIUDAD = $row['COD_CIUDAD'];
                        $TELEFONO = $row['TELEFONO'];
                        $EMAIL = $row['EMAIL'];
                    }
                    $SQL="SELECT * FROM PM_CIUDAD WHERE  COD_CIUDAD=".$COD_CIUDAD;
                    $RS = sqlsrv_query($maestra, $SQL);
                    //oci_execute($RS);
                    if ($row = sqlsrv_fetch_array($RS)) {
                        $DES_CIUDAD = $row['DES_CIUDAD'];
                    }
					$SQL="SELECT DES_REGION, ABR_REGION FROM PM_REGION WHERE COD_REGION=".$COD_REGION;
					$RS = sqlsrv_query($maestra, $SQL);
					//oci_execute($RS);
					if ($row = sqlsrv_fetch_array($RS)) {
						$DES_REGION = $row['DES_REGION'];
						$ABR_REGION = $row['ABR_REGION'];
						if(!empty($ABR_REGION)){$DES_REGION = $DES_REGION." (".$ABR_REGION.")";}
					} else {
						$DES_REGION = "";
					}
                ?>

                <h3>Cotizaci&oacute;n <?=$ID_COT_F;?></h3>
                <p><?=$LATIENDA?></p>
                <p>V&aacute;lida a la fecha de emisi&oacute;n</p>

                <h3>Cliente: <?=$CLIENTE?> (<?=$IDENTIFICACION?>)</h3>
                <p>Direcci&oacute;n: <?=$DIRECCION?>, <?=$DES_CIUDAD?> <?=$DES_REGION?></p>
                <p>Tel&eacute;fono: <?=$TELEFONO?>, e-mail: <?=$EMAIL?></p>
                
                <h3>Art&iacute;culos en Cotizaci&oacute;n</h3>


                                    <table style="width:100%">
                                    <tr>
                                        <th style="text-align:left; padding:10px">Item</th>
                                        <th style="text-align:left; padding:10px">C&oacute;d.Art.</th>
                                        <th style="text-align:left; padding:10px">Art&iacute;culo</th>
                                        <th style="text-align:right; padding:10px">Precio</th>
                                        <th style="text-align:right; padding:10px">Cantidad</th>
                                        <th style="text-align:right; padding:10px">Total</th>
                                   </tr>
                                   <?php
									$SQLA="SELECT * FROM IMP_COTART WHERE ID_COT=".$ID_COT." ORDER BY ID_COTITM DESC";
									$RSA = sqlsrv_query($conn, $SQLA);
									//oci_execute($RSA);
									$CONTADOR=1;
									$TOT_COT=0;
									while ($rowA = sqlsrv_fetch_array($RSA)) {
											$CD_ITM=$rowA['CD_ITM'];
											$QN_ITM=$rowA['QN_ITM'];
											$ID_COTITM=$rowA['ID_COTITM'];
											$SQLI="SELECT * FROM AS_ITM WHERE CD_ITM=".$CD_ITM;
											$RSI = sqlsrv_query($arts_conn, $SQLI);
											//oci_execute($RSI);
											if ($rowI = sqlsrv_fetch_array($RSI)) {
												$ID_ITM=$rowI['ID_ITM'];
												$NM_ITM=$rowI['DE_ITM'];
												$NM_ITM = iconv("ISO-8859-1", "UTF-8", $NM_ITM);
											}
											$SQLI="SELECT * FROM AS_ITM_STR WHERE ID_ITM=".$ID_ITM." AND ID_BSN_UN=".$ID_BSN_UN;
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
											$CODE_EAN="";
											if ($rowI = sqlsrv_fetch_array($RSI)) {
												$CODE_EAN=$rowI['ID_ITM_PS'];
											}
											//TOTAL_ITM
											$TOT_ITM=$SLS_PRC*$QN_ITM;
											$TOT_COT=$TOT_COT+$TOT_ITM;
											$TOT_ITM_F=$TOT_ITM/$DIVCENTS;
											$TOT_ITM_F=number_format($TOT_ITM_F, $CENTS, $GLBSDEC, $GLBSMIL);
									?>
                                    <tr>
                                    	<td style="width:40px; max-width:40px; border-top:1px solid #000; padding:10px; "><?=$CONTADOR;?></td>
                                    	<td style="border-top:1px solid #000; padding:10px; "><?=$CODE_EAN;?></td>
                                    	<td style="border-top:1px solid #000; padding:10px 4px; "><?=$NM_ITM;?></td>
                                    	<td style="text-align:right; border-top:1px solid #000; padding:10px; "><?=$MONEDA.$PREC_ITM;?></td>
                                        <td style="text-align:right; border-top:1px solid #000; padding:10px; "><?=$QN_ITM;?></td>
                                    	<td style="text-align:right; border-top:1px solid #000; padding:10px; "><?=$MONEDA.$TOT_ITM_F;?></td>
                                    </tr>
                                    <?php
										$CONTADOR=$CONTADOR+1;
									} //LISTADO DE ARTICULOS
								   ?>
                                    <tr>
                                        <td colspan="4" style="text-align:right; font-weight:600; padding:10px; border-top:1px solid #000; ">Total Cotizaci&oacute;n</td>
                                        <td colspan="2" style="text-align:right; font-weight:600; padding:10px; border-top:1px solid #000; ">
                                            <?php
                                                $TOT_COT_F = $TOT_COT/$DIVCENTS;
                                                $TOT_COT_F = number_format($TOT_COT_F, $CENTS, $GLBSDEC, $GLBSMIL);
                                            ?>
                                            <?=$MONEDA.$TOT_COT_F?>
                                        </td>
                                    </tr>
                                   </table>

                            </td>
                       </tr>
                </table>



</body>
</html>
