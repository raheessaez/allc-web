<?php include("session.inc");?>
<?php
	$ID_TRN=@$_GET["ID_TRN"];
	
			$SQLM="SELECT * FROM TR_LTM_MOTO_DT WHERE ID_TRN=".$ID_TRN;
			$RSM = sqlsrv_query($arts_conn, $SQLM);
			//oci_execute($RSM);
			if ($rowM1 = sqlsrv_fetch_array($RSM)) {
				$SRL_NBR = $rowM1['SRL_NBR'];
				$SRL_NBR = trim($SRL_NBR);
				$AI_LN_ITM = $rowM1['AI_LN_ITM'];
			}
			
			$SQLi="SELECT * FROM TR_LTM_SLS_RTN WHERE ID_TRN=".$ID_TRN." AND AI_LN_ITM=".$AI_LN_ITM;
			$RSi= sqlsrv_query($arts_conn, $SQLi);
			//oci_execute($RSi);
			if ($rowi = sqlsrv_fetch_array($RSi)) {
					$MNT_ITM = $rowi['MO_EXTND']; //MONTO TOTAL DE VENTA DEL ITEM
					$QNT_ITM = $rowi['QU_ITM_LM_RTN_SLS']; //CANTIDAD ITEM
					$TAX_ITM = $rowi['MO_TX']; //IMPUESTO APLICADO AL ITEM
					$MNT_NETO = $MNT_ITM - $TAX_ITM; //MONTO NETO
					$MNT_UNI=($MNT_NETO/$QNT_ITM)/$DIVCENTS;
					$MNT_UNI_F=number_format($MNT_UNI, $CENTS, $GLBSDEC, $GLBSMIL);
					$TAX_ITM_F=$TAX_ITM/$DIVCENTS;
					$TAX_ITM_F=number_format($TAX_ITM_F, $CENTS, $GLBSDEC, $GLBSMIL);
					$MNT_ITM_F=$MNT_ITM/$DIVCENTS;
					$MNT_ITM_F=number_format($MNT_ITM_F, $CENTS, $GLBSDEC, $GLBSMIL);
			}

			$SQLM="SELECT * FROM TR_TRN WHERE ID_TRN=".$ID_TRN;
			$RSM = sqlsrv_query($arts_conn, $SQLM);
			//oci_execute($RSM);
			if ($rowM1 = sqlsrv_fetch_array($RSM)) {
				$ID_WS = $rowM1['ID_WS'];
				$ID_BSN_UN = $rowM1['ID_BSN_UN'];
				$FECHA_TICKET = $rowM1['DC_DY_BSN'];
				$FECHA_TICKET = date_format($FECHA_TICKET,"d-m-Y");
							$DIA_TCK = date_format($FECHA_TICKET,"d");
							$ANIO_TCK = date_format($FECHA_TICKET,"Y");
							$elMES_TCK = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
							$elMES_TCK = $elMES_TCK[(date('m', strtotime($FECHA_TICKET))*1)-1];
							$LAFECHA_TICKET=$elMES_TCK." ".$DIA_TCK.", ".$ANIO_TCK;
				$RES_TICKET=explode(" ",$FECHA_TICKET);
				$TS_TICKET=$RES_TICKET[0];
			}
			
				$S2="SELECT * FROM PA_STR_RTL WHERE ID_BSN_UN=".$ID_BSN_UN;
				$RS2 = sqlsrv_query($arts_conn, $S2);
				//oci_execute($RS2);
				if ($row2 = sqlsrv_fetch_array($RS2)) {
					$TIENDA = $row2['CD_STR_RT'];
				}	
				$S2="SELECT * FROM MN_TNDSOC WHERE COD_TIENDA=".$TIENDA;
				$RS2 = sqlsrv_query($maestra, $S2);
				//oci_execute($RS2);
				if ($row2 = sqlsrv_fetch_array($RS2)) {
					$COD_SOC = $row2['COD_SOC'];
				}	
				$S2="SELECT * FROM MN_SOCIEDAD WHERE COD_SOC=".$COD_SOC;
				$RS2 = sqlsrv_query($maestra, $S2);
				//oci_execute($RS2);
				if ($row2 = sqlsrv_fetch_array($RS2)) {
					$NM_SOC = $row2['NM_SOC'];
					$RUC_SOC = $row2['RUC_SOC'];
				}	


				$S2="SELECT CD_WS FROM AS_WS WHERE ID_WS=".$ID_WS;
				$RS2 = sqlsrv_query($arts_conn, $S2);
				//oci_execute($RS2);
				if ($row2 = sqlsrv_fetch_array($RS2)) {
					$POS = $row2['CD_WS'];
				}	
			
					$REGISTRA=1;
					$SQLM="SELECT * FROM CM_CARTAS WHERE ID_TRN=".$ID_TRN." AND LTRIM(SRL_NBR)='".$SRL_NBR."'";
					$RSM = sqlsrv_query($conn, $SQLM);
					//oci_execute($RSM);
					if ($rowM1 = sqlsrv_fetch_array($RSM)) {
						$REGISTRA=0;
					} else {
						$REGISTRA=1;

						$SQLR="SELECT IDENT_CURRENT ('CM_CARTAS') AS MCARTA";
						$RS2 = sqlsrv_query($conn, $SQLR);
						//oci_execute($RS2);
						if ($row = sqlsrv_fetch_array($RS2)) {
								$ID_CARTA=$row['MCARTA']+1;
							} else {
								$ID_CARTA=1;
						}

						$SEQCARTA ="0000".$ID_CARTA;
						$SEQCARTA=substr($SEQCARTA, -4); 
						$ARCHIVO="mohn".$SEQCARTA;
						$SQLR="INSERT INTO CM_CARTAS (ID_TRN, ARCHIVO, ESTADO, SRL_NBR) ";
						$SQLR=$SQLR." VALUES (".$ID_TRN.", '".$ARCHIVO."', 1, '".$SRL_NBR."')";
						$RS2 = sqlsrv_query($conn, $SQLR);
						//oci_execute($RS2);
					}

			$SQL="SELECT * FROM TR_INVC WHERE ID_TRN=".$ID_TRN;
			$RS = sqlsrv_query($arts_conn, $SQL);
			//oci_execute($RS);
			if ($row = sqlsrv_fetch_array($RS)) {
				$INVC_NMB = $row['INVC_NMB'];
				$ID_CPR = $row['ID_CPR'];
				$FL_CP = $row['FL_CP'];
			}
			if($FL_CP==0){
						$SQL="SELECT * FROM CO_CPR_CER WHERE ID_CPR=".$ID_CPR;
						$RS = sqlsrv_query($arts_conn, $SQL);
						//oci_execute($RS);

						if ($row = sqlsrv_fetch_array($RS)) {
							$NM_CLIENTE = $row['NOMBRE'];
							$ID_CPR = $row['ID_CPR'];
							$TY_CPR = $row['TY_CPR'];
							$IDENTIFICACION = $row['CD_CPR'];
							$DIRECCION = $row['DIRECCION'];
							$COD_CIUDAD = $row['COD_CIUDAD'];
									$SQLC="SELECT DES_CIUDAD FROM PM_CIUDAD WHERE COD_CIUDAD=".$COD_CIUDAD;
									$RSC = sqlsrv_query($maestra, $SQLC);
									//oci_execute($RSC);
									if ($rowC = sqlsrv_fetch_array($RSC)) {
										$DIRECCION = $DIRECCION.", ".$rowC['DES_CIUDAD'];
									}
							$TELEFONO = $row['TELEFONO'];
							$NACIONALIDAD = "ECUATORIANO";
							$TipoID="C.I. No. ";
									$SQL1="SELECT * FROM CO_REL_CER WHERE ID_CPR=".$ID_CPR;
									$RS1 = sqlsrv_query($arts_conn, $SQL1);
									//oci_execute($RS1);
									if ($row1 = sqlsrv_fetch_array($RS1)) {
										$CANTON = $row1['CANTON'];
										$PROVINCIA = $row1['PROVINCIA'];
									}

						}
			} else {
						$SQL="SELECT * FROM CO_EXT_CER WHERE ID_CPR=".$ID_CPR;
						$RS = sqlsrv_query($arts_conn, $SQL);
						//oci_execute($RS);
						if ($row = sqlsrv_fetch_array($RS)) {
							$NM_CLIENTE = $row['NOMBRE'];
							$TY_CPR = "P";
							$IDENTIFICACION = $row['CD_CPR'];
							$DIRECCION = $row['DIRECCION'];
							$TELEFONO = $row['TELEFONO'];
							$NACIONALIDAD = $row['NACIONALIDAD'];
							$TipoID="Pasaporte: ";
							$CANTON="";
							$PROVINCIA="";
						}
			}
			if(empty($DIRECCION)){ $DIRECCION="No registrada";}

?>
<html><head><meta http-equiv="X-UA-Compatible" content="IE=9">	      <!-- IE9 Standards -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="robots" content="noarchive"/>
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
<meta name="description" content="Alliances"/>
<meta name="author" content="Design: Alliances | Code: Claudio Arellano">
<title>Carta de Venta Moto - Serial <?php echo $SRL_NBR?></title>
<link rel="shortcut icon" href="../images/favicon.ico">
<link rel="stylesheet" href="../css/OpenSans.css" media="screen">
<link rel="stylesheet" href="../css/_mng_estilos.css" media="screen">
<script language=JavaScript src="../js/javascript.js"></script>

<script language=JavaScript src="funciones.js"></script>

</head>

<body>

        <table style="margin:10px 50px;">
        <tr>
            <td>
                <a href="javascript: window.close();" style="border:none; display:inline; float:right; margin: 6px; width:26px; height:26px; background-image:url(images/ICO_CLOSE24.png); background-repeat:no-repeat" title="Cerrar Ventana"><img src="images/Transpa.png" width="32" /></a>
                <a href="javascript: window.print();" style="border:none; display:inline; float:right; margin: 6px; width:26px; height:26px; background-image:url(images/ICO_PRINT24.png); background-repeat:no-repeat" title="Imprime Carta de Venta"><img src="images/Transpa.png" width="32"  /></a>
            </td>
        </tr>
        <tr>
        <td>

				<?php
				$SQLM="SELECT * FROM CO_MOTO_CER WHERE trim(upper(SRL_NBR))='".trim(strtoupper($SRL_NBR))."'";
				$RSM = sqlsrv_query($arts_conn, $SQLM);
				//oci_execute($RSM);
				if ($rowM = sqlsrv_fetch_array($RSM)) {
					$CLASE = $rowM['CLASE'];
					$MARCA = $rowM['MARCA'];
					$MODELO = $rowM['MODELO'];
					$MOTOR = $rowM['MOTOR'];
					$CHASIS = $rowM['CHASIS'];
					$CAPACIDAD = $rowM['CAPACIDAD'];
					$TONELAJE = $rowM['TONELAJE'];
					$CILINDRAJE = $rowM['CILINDRAJE'];
					$COLOR = $rowM['COLOR'];
					$ANO_MOD = $rowM['ANO_MOD'];
					$PAIS_ORIG = $rowM['PAIS_ORIG'];
					$GRAVAMEN = $rowM['GRAVAMEN'];
						if($GRAVAMEN=="T"){
							$ARMADA=1;
						} else {
							$ARMADA=0;
						}
					$CPN = $rowM['CPN'];
					$FECHA_CPN = $rowM['FECHA_CPN'];
					$FECHA_CPN=date_format($FECHA_CPN,"d-m-Y");
												//FORMATEAR LA FECHA
												//PRIMEROS 4 ANIO
												$ANIO_CPN=date_format($FECHA_CPN,"Y");
												//SIGUIENTES 2 MES
												$MES_CPN=date_format($FECHA_CPN,"m");
												switch ($MES_CPN) {
													case "01": $elMES_CPN="ENERO";break;
													case "02": $elMES_CPN="FEBRERO";break;
													case "03": $elMES_CPN="MARZO";break;
													case "04": $elMES_CPN="ABRIL";break;
													case "05": $elMES_CPN="MAYO";break;
													case "06": $elMES_CPN="JUNIO";break;
													case "07": $elMES_CPN="JULIO";break;
													case "08": $elMES_CPN="AGOSTO";break;
													case "09": $elMES_CPN="SEPTIEMBRE";break;
													case "10": $elMES_CPN="OCTUBRE";break;
													case "11": $elMES_CPN="NOVIEMBRE";break;
													case "12": $elMES_CPN="DICIEMBRE";break;
												}
												//SIGUIENTES 2 DIA
												$DIA_CPN=date_format($FECHA_CPN,"d");
												$LAFECHA_CPN=$elMES_CPN." ".$DIA_CPN.", ".$ANIO_CPN;
					$SUBCATEGORIA = $rowM['SUBCATEGORIA'];
					$COMBUSTIBLE = $rowM['COMBUSTIBLE'];
					$CARROCERIA = $rowM['CARROCERIA'];
					$CKD = $rowM['CKD'];
					$NUM_SRI = $rowM['NUM_SRI'];
				}
                ?>
                                <table id="Calendario">
                                <tr>
                                    <td style="text-align:center">
                                        <span style="font-weight:bold; font-size:12pt">CARTA DE VENTA</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:left; font-size:9pt; padding-bottom:20px">
                                        Por medio de la presente dejo constancia de que hemos vendido a <?php echo $NM_CLIENTE;?> de nacionalidad <?php echo $NACIONALIDAD?> identificado con <?php echo $TipoID.$IDENTIFICACION;?> Direccion <?php echo $DIRECCION;?>, Tel&eacute;fono <?php echo $TELEFONO;?> el veh&iacute;culo cuyas caracter&iacute;sticas son las siguientes:
                                    </td>
                                </tr>
                                <tr>

                                    <td>
                                    <style>
                                    #Listado td {
                                    vertical-align:middle;
                                    border:none;
                                    }
                                    #Listado th {
                                    font-size: 9pt;
                                    }
                                    </style>
                                        <table id="Listado">
                                        <tr>
                                        	<td>
                                            		<style>
													#ListaMoto td {
														padding:2px;
													}
													</style>
                                            		<table id="ListaMoto">
                                                        <tr><td>CLASE</td><td>: <?php echo $CLASE;?></td> </tr>
                                                        <tr><td>MARCA</td><td>: <?php echo $MARCA;?></td> </tr>
                                                        <tr><td>MODELO</td><td>: <?php echo $MODELO;?></td> </tr>
                                                        <tr><td>MOTOR No</td><td>: <?php echo $MOTOR;?></td> </tr>
                                                        <tr><td>SERIE</td><td>: <?php echo $SRL_NBR;?></td> </tr>
                                                        <tr><td>CAPACIDAD</td><td>: <?php echo $CAPACIDAD;?></td> </tr>
                                                        <tr><td>TONELAJE</td><td>: <?php echo $TONELAJE;?></td> </tr>
                                                        <tr><td>COLOR</td><td>: <?php echo $COLOR;?></td> </tr>
                                                        <tr><td>A&Ntilde;O MODELO</td><td>: <?php echo $ANO_MOD;?></td> </tr>
                                                        <?php if($ARMADA==0){?>
                                                                <tr><td>RAMV</td><td>: <?php echo $CHASIS;?></td> </tr>
                                                        <?php }?>
                                                        <tr><td>VALOR</td><td>: <?php echo $MONEDA.$MNT_ITM_F;?></td> </tr>
                                                        <tr><td>PAIS ORIGEN</td><td>: <?php echo $PAIS_ORIG;?></td> </tr>
                                                        <tr><td>FACTURA No.</td><td>: <?php echo $INVC_NMB;?></td> </tr>
                                                        <?php if($ARMADA==1){?>
                                                        <tr><td>NUMERO CPN</td><td>: <?php echo $CPN;?></td> </tr>
                                                        <tr><td>FECHA CPN</td><td>: <?php echo $LAFECHA_CPN;?></td> </tr>
                                                        <tr><td>CATEGOR.VEHICULO</td><td>: <?php echo $SUBCATEGORIA;?></td> </tr>
                                                        <tr><td>TIPO COMBUSTIBLE</td><td>: <?php echo $COMBUSTIBLE;?></td> </tr>
                                                        <tr><td>TIPO CARROCERIA</td><td>: <?php echo $CARROCERIA;?></td> </tr>
                                                        <tr><td>NUMERO CKD</td><td>: <?php echo $CKD;?></td> </tr>
                                                        <?php }?>
                                                    </table>
                                               </td>
                                         </tr>
                                        <tr>
                                            <td style="padding-top:20px">
                                                El vendedor declara que el veh&iacute;culo fue vendido de contado y est&aacute; libre de gravamenes, y el comprador declara haber recibido el veh&iacute;culo arriba descrito a su entera satisfacci&oacute;n.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                GUAYAQUIL, <?php echo $LAFECHA_TICKET?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top:60px">
                                                <span style="border-top:1px solid #666">Sr(a) <?php echo $GLBENSESION;?></span><br>
                                                Por: <?php echo $NM_SOC;?><br>
                                                R.U.C. <?php echo $RUC_SOC;?>
                                            </td>
                                        </tr>
                                        </table>
                                    </td>
                                </tr>
                                </table>
        </td>
        </tr>
        </table>

<?php
			if($REGISTRA==1){
						//GENERA ARCHIVO XML	
						 $NOM_ARCHIVO=$ARCHIVO.".xml";
						 $open = fopen("_arc_tmp/".$NOM_ARCHIVO, "w+");
						 
						$XML="<?xml version='1.0' encoding='windows-1252' ?>"."\r\n";
						$XML=$XML."<ventas>"."\r\n";
						$XML=$XML."<datosRegistrador>"."\r\n";
						$XML=$XML."<numeroRUC>".$RUC_SOC."</numeroRUC>"."\r\n";
						$XML=$XML."</datosRegistrador>"."\r\n";
						$XML=$XML."<datosVentas>"."\r\n";
						$XML=$XML."<venta>"."\r\n";
						$XML=$XML."<rucComercializador>".$RUC_SOC."</rucComercializador>"."\r\n";
						$XML=$XML."<CAMVCpn>".$CPN."</CAMVCpn>"."\r\n";
						$XML=$XML."<serialVin>".$CHASIS."</serialVin>"."\r\n";
						$XML=$XML."<nombrePropietario>".$NM_CLIENTE."</nombrePropietario>"."\r\n";
						$XML=$XML."<tipoIdentificacionPropietario>".$TY_CPR."</tipoIdentificacionPropietario>"."\r\n";
						$XML=$XML."<numeroDocumentoPropietario>".$CD_CPR."</numeroDocumentoPropietario>"."\r\n";
						$XML=$XML."<tipoComprobante>1</tipoComprobante>"."\r\n";
						$XML=$XML."<establecimientoComprobante>".$TIENDA."</establecimientoComprobante>"."\r\n";
						$XML=$XML."<puntoEmisionComprobante>".$POS."</puntoEmisionComprobante>"."\r\n";
						$XML=$XML."<numeroComprobante>".$INVC_NMB."</numeroComprobante>"."\r\n";
						$XML=$XML."<numeroAutorizacion>ELECTRONIC</numeroAutorizacion>"."\r\n";
						$XML=$XML."<fechaVenta>".$TS_TICKET."</fechaVenta>"."\r\n";
						$XML=$XML."<precioVenta>".$MO_PRC_REG."</precioVenta>"."\r\n";
						$XML=$XML."<codigoCantonMatriculacion>".$CANTON."</codigoCantonMatriculacion>"."\r\n";
						$XML=$XML."<datosDireccion>"."\r\n";
						$XML=$XML."<tipo>RESIDENCIA</tipo>"."\r\n";
						$XML=$XML."<calle>".$DIRECCION."</calle>"."\r\n";
						$XML=$XML."<numero></numero>"."\r\n";
						$XML=$XML."<interseccion></interseccion>"."\r\n";
						$XML=$XML."</datosDireccion>"."\r\n";
						$XML=$XML."<datosTelefono>"."\r\n";
						$XML=$XML."<provincia>".$PROVINCIA."</provincia>"."\r\n";
						$XML=$XML."<numero>".$TELEFONO."</numero>"."\r\n";
						$XML=$XML."</datosTelefono>"."\r\n";
						$XML=$XML."</venta>"."\r\n";
						$XML=$XML."</datosVentas>"."\r\n";
						$XML=$XML."</ventas>"."\r\n";

						 
						 
						 fwrite($open, $XML);
						 fclose($open);
				
								$local_file="_arc_tmp/".$NOM_ARCHIVO;
								$server_file = $DIR_EX_FLS_OUT.$NOM_ARCHIVO;
				
								$conn_id = ftp_connect($FTP_SERVER); 
								$login_result = ftp_login($conn_id, $FTP_UNM, $FTP_UPW);
								
								ftp_put($conn_id, $server_file, $local_file, FTP_BINARY);
								ftp_close($conn_id);		
			}//FIN REGISTRA==1
?>


</body>
</html>

