<?php include("conecta.inc");?>
<?php
	$SRL_NBR=@$_GET["SN"];
	$ID_TRN=@$_GET["TR"];
	$AI_LN_ITM=@$_GET["AI"];
	$ID_CPR=@$_GET["CL"];
	$FL_CP=@$_GET["FC"];
	$INVC_NMB=$_GET["FAC"];
	$IDUSU=@$_GET["IU"];
	$GENCARTA=@$_GET["IDC"];
        $ESTADO = @$_GET["ACT"];
        $CCOPERA = @$_GET["CCO"];
        
        if($ESTADO == 1){
		
            $QUERY="UPDATE CM_CARTAS SET ESTADO= 0 WHERE ID_TRN =".$ID_TRN." AND CC_OPERADOR =".$CCOPERA;
            $RS = sqlsrv_query($conn, $QUERY);
            //$R = oci_execute($RS);
            
	}
	
	if($GENCARTA<>""){
				$SQLM="UPDATE CM_CARTAS SET ESTADO=1, FECHA_E= convert(datetime,GETDATE(), 121) WHERE ID_CARTA=".$GENCARTA;
				$RSM2 = sqlsrv_query($conn, $SQLM);
				//oci_execute($RSM2);
	}
	
                                //DATA GERENTE DE TIENDA
                                $SQLM="SELECT * FROM US_USUARIOS WHERE IDUSU=".$IDUSU;
                                $RSM = sqlsrv_query($maestra, $SQLM);
                                //oci_execute($RSM);
                                if ($rowM = sqlsrv_fetch_array($RSM)) {
                                        $CC_OPERADOR = $rowM['CC_OPERADOR'];
                                        $NOMB_GTE = $rowM['NOMBRE'];
                                }
			 
				// TIENDA ASOCIADA A GERENTE
				 $COD_TIENDA = "";
					$SQLT="SELECT * FROM US_USUTND WHERE IDUSU=".$IDUSU;
						$RST = sqlsrv_query($maestra, $SQLT);
						//oci_execute($RSM);
						if ($rowT = sqlsrv_fetch_array($RST)) {
							
							$COD_TIENDA = $rowT['COD_TIENDA'];
							
						}
						// DES_CLAVE TIENDA
						$DES_CLAVE = "";
					$SQLD="SELECT * FROM MN_TIENDA WHERE COD_TIENDA=".$COD_TIENDA;
						$RSDS = sqlsrv_query($maestra, $SQLD);
						//oci_execute($RSM);
						if ($rowD = sqlsrv_fetch_array($RSDS)) {
							
							$DES_CLAVE = $rowD['DES_CLAVE'];
							
						}
						
				
				
				//DATA TRANSACCION
						$SQLM="SELECT * FROM TR_TRN WHERE ID_TRN=".$ID_TRN;
						$RSM = sqlsrv_query($arts_conn, $SQLM);
						//oci_execute($RSM);
						if ($rowM = sqlsrv_fetch_array($RSM)) {
							$ID_BSN_UN = $rowM['ID_BSN_UN']; //TIENDA
							$ID_WS = $rowM['ID_WS']; //TERMINAL POS
							$DC_DY_BSN = $rowM['DC_DY_BSN']; //FECHA
							$DC_DY_BSN = date_format($DC_DY_BSN,"d-m-Y");
							$RES_TICKET=explode(" ",$DC_DY_BSN);
							$TS_TICKET=$RES_TICKET[0];
						}
						
						$SQLM="SELECT * FROM TR_RTL WHERE ID_TRN=".$ID_TRN;
						$RSM = sqlsrv_query($arts_conn, $SQLM);
						//oci_execute($RSM);
						if ($rowM = sqlsrv_fetch_array($RSM)) {
							$TX_INC = $rowM['TX_INC']; //TAX INCLUIDO EN PRECIO, 0=N, 1=S
						}
						$SQLi="SELECT * FROM AS_WS WHERE ID_WS=".$ID_WS;
						$RSi= sqlsrv_query($arts_conn, $SQLi);
						//oci_execute($RSi);
						if ($rowi = sqlsrv_fetch_array($RSi)) {
							$CD_WS = $rowi['CD_WS']; //TERMINAL POS
						}
						$SQLi="SELECT * FROM PA_STR_RTL WHERE ID_BSN_UN=".$ID_BSN_UN;
						$RSi= sqlsrv_query($arts_conn, $SQLi);
						//oci_execute($RSi);
						if ($rowi = sqlsrv_fetch_array($RSi)) {
							$CD_STR_RT = $rowi['CD_STR_RT']; //NUMERO TIENDA
						}
				//DATA TIENDA
						$SQLM="SELECT * FROM MN_TIENDA WHERE DES_CLAVE=".$CD_STR_RT;
						$RSM = sqlsrv_query($maestra, $SQLM);
						//oci_execute($RSM);
						if ($rowM = sqlsrv_fetch_array($RSM)) {
							$COD_CIUDAD = $rowM['COD_CIUDAD'];
							$COD_CANTON = $rowM['COD_CANTON'];
							$COD_PROVINCIA = $rowM['COD_PROVINCIA'];
						}
						
						$SQLM="SELECT * FROM MN_TNDSOC WHERE COD_TIENDA=".$COD_TIENDA;
						$RSM = sqlsrv_query($maestra, $SQLM);
						//oci_execute($RSM);
						if ($rowM = @sqlsrv_fetch_array($RSM)) {
							$COD_SOC = $rowM['COD_SOC'];
						}
						
						$SQLM="SELECT * FROM MN_SOCIEDAD WHERE COD_SOC=".$COD_SOC;
						$RSM = sqlsrv_query($maestra, $SQLM);
						//oci_execute($RSM);
						if ($rowM = @sqlsrv_fetch_array($RSM)) {
							$NM_SOC = $rowM['NM_SOC'];
							$RUC_SOC = $rowM['RUC_SOC'];
						}
						$SQLM="SELECT * FROM PM_CIUDAD WHERE COD_CIUDAD=".$COD_CIUDAD;
						$RSM = sqlsrv_query($maestra, $SQLM);
						//oci_execute($RSM);
						if ($rowM = sqlsrv_fetch_array($RSM)) {
							$DES_CIUDAD = $rowM['DES_CIUDAD'];
						}
	
	//DATA CLIENTE
			if($FL_CP==0){ //DATA CLIENTE FACTURA
						$SQLM="SELECT * FROM CO_CPR_CER WHERE ID_CPR=".$ID_CPR;
						$RSM = sqlsrv_query($arts_conn, $SQLM);
						//oci_execute($RSM);
						if ($rowM = sqlsrv_fetch_array($RSM)) {
							$NOM_CPR = $rowM['NOMBRE'];
							$CD_CPR = $rowM['CD_CPR'];
							$DIR_CPR = $rowM['DIRECCION'];
							$COD_CIUDAD = $rowM['COD_CIUDAD'];
							$PROVINCIA = $rowM['COD_REGION'];
							$TEL_CPR = $rowM['TELEFONO'];
							$COR_CPR = $rowM['CORREO'];
                                                        // FIJO O CELULAR 0:FIJO 1:CEL
                                                        $FL_TEL = $rowM['FL_TEL'];
							$TY_CPR = $rowM['TY_CPR'];
							if($TY_CPR=='C'){$TIPOID="C&eacute;dula";}
							if($TY_CPR=='R'){$TIPOID="RUC";}
							$NAC_CPR="ECUATORIANA";
									$SQLC="SELECT DES_CIUDAD FROM PM_CIUDAD WHERE COD_CIUDAD=".$COD_CIUDAD;
									$RSC = sqlsrv_query($maestra, $SQLC);
									//oci_execute($RSC);
									if ($rowC = sqlsrv_fetch_array($RSC)) {
										$DIRECCION = $DIR_CPR." (".$rowC['DES_CIUDAD'].")";
									}else{
												
												$DIRECCION = $DIR_CPR;
											
										}
						}
						
			} else {
						$SQLM="SELECT * FROM CO_EXT_CER WHERE ID_CPR=".$ID_CPR;
						$RSM = sqlsrv_query($arts_conn, $SQLM);
						//oci_execute($RSM);
						if ($rowM = sqlsrv_fetch_array($RSM)) {
							$NOM_CPR = $rowM['NOMBRE'];
							$CD_CPR = $rowM['CD_CPR'];
							$DIR_CPR = $rowM['DIRECCION'];
							$TEL_CPR = $rowM['TELEFONO'];
							$COR_CPR = $rowM['CORREO'];
							$NAC_CPR = $rowM['NACIONALIDAD'];
							$TIPOID="Pasaporte";
							$DIRECCION = $DIR_CPR;
                                                        // FIJO O CELULAR 0:FIJO 1:CEL
                                                        $FL_TEL = $rowM['FL_TEL'];
						}
			}

	//VALOR MOTOCICLETA		
			$SQLi="SELECT * FROM TR_LTM_SLS_RTN WHERE ID_TRN=".$ID_TRN." AND AI_LN_ITM=".$AI_LN_ITM;
			$RSi= sqlsrv_query($arts_conn, $SQLi);
			//oci_execute($RSi);
			if ($rowi = sqlsrv_fetch_array($RSi)) {
				
				$MONTO = $rowi['MO_EXTND']; //MONTO DE VENTA DEL ITEM
				$IMPUESTO = $rowi['MO_TX']; //IMPUESTO APLICADO AL ITEM
				
				if($TX_INC==0){
						$MONTO = $MONTO + $IMPUESTO;
				}

				$MNT_ITM_F=$MONTO/$DIVCENTS;
				$MNT_ITM_F=number_format($MNT_ITM_F, $CENTS, $GLBSDEC, "");
				
			}

	//DATA MOTOCICLETA
			$SQLM="SELECT * FROM CO_MOTO_CER WHERE RTRIM(upper(SRL_NBR))='".trim(strtoupper($SRL_NBR))."'";
		
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
					$EJES = $rowM['EJES'];
					$RUEDAS = $rowM['RUEDAS'];
					
					if($GRAVAMEN=="T"){
						$ARMADA=1;
					} else {
						$ARMADA=0;
					}
					$CPN = $rowM['CPN'];
							
							
							//CPN O RAMV
							if($CPN){
								$ESCPN=0;
							} else {
								$ESCPN=1;
							}
						
							$FECHA_CPN = $rowM['FECHA_CPN'];
							
							//FORMATEAR LA FECHA
							//PRIMEROS 4 ANIO
							$ANIO_CPN=substr($FECHA_CPN, 0, 4);
							//SIGUIENTES 2 MES
							$MES_CPN=substr($FECHA_CPN, 4, 2);
							//SIGUIENTES 2 DIA
							$DIA_CPN=substr($FECHA_CPN, 6, 2);
							
							$LAFECHA_CPN=$ANIO_CPN."/".$MES_CPN."/".$DIA_CPN;
					$SUBCATEGORIA = $rowM['SUBCATEGORIA'];
					$COMBUSTIBLE = $rowM['COMBUSTIBLE'];
					$CARROCERIA = $rowM['CARROCERIA'];
					$CKD = $rowM['CKD'];
					$NUM_SRI = $rowM['NUM_SRI'];
					
			}
	
	//REVISAR SERIE - OBTENER ESTADO
			$SQLM="SELECT * FROM CM_CARTAS WHERE ID_TRN=".$ID_TRN." AND SRL_NBR ='".$SRL_NBR."'";
			$RSM = sqlsrv_query($conn, $SQLM);
			//oci_execute($RSM);
			if ($rowM1 = sqlsrv_fetch_array($RSM)) {
				$ID_CARTA = $rowM1['ID_CARTA'];
				$ESTADO = $rowM1['ESTADO'];
				$CC_OPERADOR = $rowM1['CC_OPERADOR'];
				$DES_CLAVE = $rowM1['DES_CLAVE'];
				$FECHA_C = $rowM1['FECHA_C'];
				$FECHA_E = $rowM1['FECHA_E'];
				$FECHA_C = date_format($FECHA_C,"d-m-Y");
				$FECHA_E = date_format($FECHA_E,"d-m-Y");
	
			//DATA GERENTE DE TIENDA
								$SQLM="SELECT * FROM US_USUARIOS WHERE CC_OPERADOR=".$IDUSU;
								$RSM = sqlsrv_query($maestra, $SQLM);
								//oci_execute($RSM);
								if ($rowM = sqlsrv_fetch_array($RSM)) {
									$NOMB_GTE = $rowM['NOMBRE'];
								}
								$SQLM="SELECT * FROM MN_TIENDA WHERE DES_CLAVE=".$DES_CLAVE;
								$RSM = sqlsrv_query($maestra, $SQLM);
								//oci_execute($RSM);
								if ($rowM = sqlsrv_fetch_array($RSM)) {
									$COD_CIUDAD = $rowM['COD_CIUDAD'];
								}
								$SQLM="SELECT * FROM PM_CIUDAD WHERE COD_CIUDAD=".$COD_CIUDAD;
								$RSM = sqlsrv_query($maestra, $SQLM);
								//oci_execute($RSM);
								if ($rowM = sqlsrv_fetch_array($RSM)) {
									$DES_CIUDAD = $rowM['DES_CIUDAD'];
								}
			} else {
				//REGISTRAR CARTA
				$SQLM="SELECT MAX(ID_CARTA) AS MID_CARTA FROM CM_CARTAS";
				$RSM2 = sqlsrv_query($conn, $SQLM);
				//oci_execute($RSM2);
				if ($rowM2 = sqlsrv_fetch_array($RSM2)) {
						$ID_CARTA=$rowM2['MID_CARTA']+1;
					} else {
						$ID_CARTA=1;
				}
				
				$SQLM="INSERT INTO CM_CARTAS (ID_TRN, ESTADO, SRL_NBR, CC_OPERADOR, DES_CLAVE) ";
				$SQLM=$SQLM." VALUES (".$ID_TRN.", 0, '".$SRL_NBR."', ".$CC_OPERADOR.", ".$DES_CLAVE.")";
				$RSM2 = sqlsrv_query($conn, $SQLM);
				//oci_execute($RSM2);
				
				$SQLM="SELECT * FROM CM_CARTAS WHERE ID_CARTA=".$ID_CARTA;
				$RSM2 = sqlsrv_query($conn, $SQLM);
				//oci_execute($RSM2);
				if ($rowM2 = sqlsrv_fetch_array($RSM2)) {
						$FECHA_C=$rowM2['FECHA_C'];
						$FECHA_C = date_format($FECHA_C,"d-m-Y");
						$ESTADO=$rowM2['ESTADO'];
				}
				
			}
			
			$FormatoFecha = new DateTime($FECHA_C);
			$MES_EMI = date_format($FormatoFecha, 'm');
			if($MES_EMI==1){$ELMES="Enero";}
			if($MES_EMI==2){$ELMES="Febrero";}
			if($MES_EMI==3){$ELMES="Marzo";}
			if($MES_EMI==4){$ELMES="Abril";}
			if($MES_EMI==5){$ELMES="Mayo";}
			if($MES_EMI==6){$ELMES="Junio";}
			if($MES_EMI==7){$ELMES="Julio";}
			if($MES_EMI==8){$ELMES="Agosto";}
			if($MES_EMI==9){$ELMES="Septiembre";}
			if($MES_EMI==10){$ELMES="Octubre";}
			if($MES_EMI==11){$ELMES="Noviembre";}
			if($MES_EMI==12){$ELMES="Diciembre";}
			$FECHA_EMI = $ELMES." ".date_format($FormatoFecha, 'd \d\e\l Y');
			
			
?>
<html><head><meta http-equiv="X-UA-Compatible" content="IE=9">	      <!-- IE9 Standards -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php header('Content-Type: text/html; charset=ISO-8859-1'); ?>
<meta name="robots" content="noarchive"/>
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
<meta name="description" content="Alliances"/>
<meta name="author" content="Design: Alliances | Code: Claudio Arellano">
<title>ARMS Carta Venta Motos</title>
<link rel="shortcut icon" href="../images/favicon.ico">
<link rel="stylesheet" href="../css/OpenSans.css" media="screen">
<link rel="stylesheet" href="../css/_mng_estilos.css" media="screen">
<script language=JavaScript src="../js/javascript.js"></script>
<link rel="stylesheet" href="css/_mng_estilos.css" media="screen">
<script language=JavaScript src="funciones.js"></script>


<script>
function ValidaImpresion(pagina) {
		var aceptaEntrar = window.confirm("ESTA ACCION IMPRIME CARTA DE VENTA PARA ACEPTACION DEL CLIENTE, ADEMAS GENERA EL DESPACHO DE LA INFORMACION AL SRI. POR FAVOR, VERIFIQUE LA IMPRESORA, PRESIONE ACEPTAR PARA CONTINUAR E IMPRIMIR");
		if (aceptaEntrar) {
			VentanaImprime('PrintCVMT.php?SN=<?=$SRL_NBR?>&TR=<?=$ID_TRN?>&CL=<?=$ID_CPR?>&FC=<?php echo $FL_CP?>&AI=<?php echo $AI_LN_ITM?>&FAC=<?php echo $INVC_NMB?>&IU=<?php echo $IDUSU?>&IDC=<?php echo $ID_CARTA?>');
			window.close();
		}  else  {
			return false;
		}
}
</script>

</head>
<body style="background-color:#FFF" <?php if($GENCARTA != ""){?> onLoad="window.print();"<?php } ?>>
        <table style="width:100%">
        <tr>
                <td style="background-color:#F1F1F1; background-image:url(../images/ARMS.png); background-repeat:no-repeat; background-position: 20px 10px; height:65px; min-height:65px; border:none">
                    <div id="BtnVentana" style="background-image:url(../images/ICO_CloseVN.png); margin-right:16px"  title="Cerrar Ventana"><img src="images/Transpa.png" width="45" height="45" onClick="javascript: window.close();"  /></div>
                    <div id="BtnVentana" style="background-image:url(../images/ICO_PrintVN.png);" title="Imprime Carta"><img src="images/Transpa.png" width="45" height="45" onClick="javascript: <?php if($ESTADO==0){?>ValidaImpresion()<?php } else {?>window.print()<?php }?>;" /></div>
	
                </td>
        </tr>
        </table>
        
        <table style="width:100%">
        <tr>
        <td style="padding:20px">

								<style>
								#CartaVenta {
									display:block;
									width:80%;
									max-width:800px;
									min-width:600px;
									background-color:#FFF;
									padding: 0 20px;
									}
								#CartaVentaHoja h1 {
									display:block;
									text-align:center;
									width:100%;
									}
								#CartaVentaHoja td {
									padding: 10px 2px;
									font-size:8pt;
									}
								#CartaVentaMoto td {
									padding: 0 20px 0 0;
									}
								</style>
                                <div id="CartaVenta">
                                <table id="CartaVentaHoja">
                                <tr>
                                			<td><h1>CARTA DE VENTA</h1></td>
                               </tr>
                                <tr>
                                			<td><p>
                                            Por medio de la presente dejo constancia de que hemos vendido a <?=$NOM_CPR?>
                                            de nacionalidad <?=$NAC_CPR?> identificado con <?=$TIPOID?> N&ordm; <?=$CD_CPR?>
                                            Direcci&oacute;n <?=$DIRECCION?> Tel&eacute;fono <?=$TEL_CPR?>, el veh&iacute;culo cuyas caracter&iacute;sticas son las siguientes:
                                            </p></td>
                               </tr>
                                <tr>
                                			<td>
                                            		<table id="CartaVentaMoto">
                                              <?php echo "EJES::".$EJES;
																																																				echo "RUEDAS::".$RUEDAS;
																																																				?>
                                                            <tr><td>CLASE</td><td>:</td><td><?=$CLASE?></td></tr>
                                                            <tr><td>MARCA</td><td>:</td><td><?=$MARCA?></td> </tr>
                                                            <tr><td>MODELO</td><td>:</td><td><?=$MODELO?></td></tr>
                                                            <tr><td>MOTOR No.</td><td>:</td><td><?=$MOTOR?></td></tr>
                                                            <?php if($ESCPN==1){?><tr><td>CHASIS</td><td>:</td><td><?=$CHASIS?></td></tr><?php } else {?><tr><td>SERIE</td><td>:</td><td><?=$CHASIS?></td></tr><?php }?>
                                                            <tr><td>CAPACIDAD</td><td>:</td><td><?=$CAPACIDAD?></td></tr>
                                                            <tr><td>TONELAJE</td><td>:</td><td><?=$TONELAJE?></td></tr>
                                                            <?php if($ESCPN==1){?><tr><td>CILINDRAJE</td><td>:</td><td><?=$CILINDRAJE?></td></tr><?php }?>
                                                            <tr><td>COLOR</td><td>:</td><td><?=$COLOR?></td></tr>
                                                            <tr><td>A&Ntilde;O MODELO</td><td>:</td><td><?=$ANO_MOD?></td></tr>
                                                            <?php if($ESCPN==0){?><tr><td>RAMV</td><td>:</td><td><?=$NUM_SRI?></td></tr><?php }?>
                                                            <tr><td>VALOR</td><td>:</td><td><?=$MNT_ITM_F?></td></tr>
                                                            <tr><td>PAIS ORIGEN</td><td>:</td><td><?=$PAIS_ORIG?></td></tr>
                                                            <tr><td>FACTURA No.</td><td>:</td><td><?=$INVC_NMB?></td></tr>
                                                            <?php if($ESCPN==1){?><tr><td>NUMERO CPN</td><td>:</td><td><?=$CPN?></td></tr><?php }?>
                                                            <?php if($ESCPN==1){?><tr><td>FECHA CPN</td><td>:</td><td><?=$LAFECHA_CPN?></td></tr><?php }?>
                                                            <?php if($ESCPN==1){?><tr><td>SUBCLASE</td><td>:</td><td><?=$SUBCATEGORIA?></td></tr><?php }?>
                                                            <?php if($ESCPN==1){?><tr><td>TIPO COMBUSTIBLE</td><td>:</td><td><?=$COMBUSTIBLE?></td></tr><?php }?>
                                                            <?php if($ESCPN==1){?><tr><td>TIPO CARROCERIA</td><td>:</td><td><?=$CARROCERIA?></td></tr><?php }?>
                                                            <?php if($ESCPN==1){?><tr><td>NUMERO CKD</td><td>:</td><td><?=$CKD?></td></tr><?php }?>
                                                            <tr><td>EJES</td><td>:</td><td><?= $EJES ?></td></tr>
                                                            <tr><td>RUEDAS</td><td>:</td><td><?= $RUEDAS ?></td></tr>
                                                    </table>
                                            </td>
                               </tr>
                                <tr>
                                			<td><p>
                                            El vendedor declara que el veh&iacute;culo fue vendido de contado y est&aacute; libre de gravamenes, y
                                            el comprador declara haber recibido el veh&iacute;culo arriba descrito a su entera satisfacci&oacute;n.
                                            </p></td>
                               </tr>
                                <tr>
                                			<td><p>
                                            <?=$DES_CIUDAD.", ".$FECHA_EMI; ?>
                                            </p></td>
                               </tr>
                                <tr>
                                			<td><p style="display:compact; width:50%; min-width:400px;border-top:1px solid #666; margin-top:40px;">
                                            Sr(a).<?=$NOMB_GTE?><br>
                                            Por: <span style="letter-spacing:2px"><?=$NM_SOC?></span><BR>
                                            R.U.C. <?=$RUC_SOC?>
                                            </p></td>
                               </tr>
							   </table>
                               </div>
        </td>
        </tr>
        </table>



</body>
</html>

<?php
		//GENERAR Y ALMACENAR XML PARA SRI
		if($GENCARTA != ""){
                                                $QUERY ="SELECT * FROM MN_TIENDA WHERE DES_CLAVE=".$DES_CLAVE;
                                                $QT = sqlsrv_query($maestra, $QUERY);
                                                //oci_execute($RSM);
                                                if ($rowQT = sqlsrv_fetch_array($QT)) {
                                                    
                                                    $SRI = $rowQT['ESTABLCMTO_SRI'];
                                                    $CD_CIUDAD = $rowQT['COD_CIUDAD'];
                                                    

                                                }
                                                
                                                $QUERY4 ="SELECT * FROM PM_CIUDAD WHERE COD_CIUDAD=".$CD_CIUDAD;
                                                $QT4 = sqlsrv_query($maestra, $QUERY4);
                                                //oci_execute($RSM);
                                                if ($rowQT4 = sqlsrv_fetch_array($QT4)) {
                                                    
                                                    $CD_PROVINCIA = $rowQT4['COD_PROVINCIA'];
                                                }
                                                
                                                
                                                
                                                $QUERY2 ="SELECT COD_CANTON FROM MN_CANTON WHERE COD_CIUDAD=".$CD_CIUDAD;
                                                $QT2 = sqlsrv_query($maestra, $QUERY2);
                                                //oci_execute($RSM);
                                                if ($rowQT2 = sqlsrv_fetch_array($QT2)) {
                                                    
                                                    $CD_CANTON = $rowQT2['COD_CANTON'];
                                                   

                                                }
                                                
                                                $QUERY3 ="SELECT * FROM MN_PROVINCIA WHERE COD_PROVINCIA=".$CD_PROVINCIA;
                                                $QT3 = sqlsrv_query($maestra, $QUERY3);
                                                //oci_execute($RSM);
                                                if ($rowQT3 = sqlsrv_fetch_array($QT3)) {
                                                    
                                                
                                                    $COD_AREA = $rowQT3['COD_AREA'];

                                                }
                                                

						$NOM_ARCHIVO="CVM".$GENCARTA.date("YmdHis").".xml";
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
						$XML=$XML."<nombrePropietario>".$NOM_CPR."</nombrePropietario>"."\r\n";
						$XML=$XML."<tipoIdentificacionPropietario>".$TY_CPR."</tipoIdentificacionPropietario>"."\r\n";
						$XML=$XML."<numeroDocumentoPropietario>".$CD_CPR."</numeroDocumentoPropietario>"."\r\n";
						$XML=$XML."<tipoComprobante>1</tipoComprobante>"."\r\n";
						$XML=$XML."<establecimientoComprobante>".$SRI."</establecimientoComprobante>"."\r\n";
						$XML=$XML."<puntoEmisionComprobante>".substr($INVC_NMB,4,3)."</puntoEmisionComprobante>"."\r\n";
						$XML=$XML."<numeroComprobante>".substr($INVC_NMB,8,9)."</numeroComprobante>"."\r\n";
						$XML=$XML."<numeroAutorizacion>ELECTRONIC</numeroAutorizacion>"."\r\n";
						$XML=$XML."<fechaVenta>".$TS_TICKET."</fechaVenta>"."\r\n";
						$XML=$XML."<precioVenta>".$MNT_ITM_F."</precioVenta>"."\r\n";
						$XML=$XML."<codigoCantonMatriculacion>".$CD_CANTON."</codigoCantonMatriculacion>"."\r\n";
						$XML=$XML."<datosDireccion>"."\r\n";
						$XML=$XML."<tipo>RESIDENCIA</tipo>"."\r\n";
						$XML=$XML."<calle>".$DIRECCION."</calle>"."\r\n";
						$XML=$XML."<numero>N/A</numero>"."\r\n";
						$XML=$XML."<interseccion>N/A</interseccion>"."\r\n";
						$XML=$XML."</datosDireccion>"."\r\n";
						$XML=$XML."<datosTelefono>"."\r\n";
						$XML=$XML."<provincia>".$COD_PROVINCIA."</provincia>"."\r\n";
                                                $XML=$XML."<numero>".$TEL_CPR."</numero>"."\r\n"; 
						$XML=$XML."</datosTelefono>"."\r\n";
						$XML=$XML."</venta>"."\r\n";
						$XML=$XML."</datosVentas>"."\r\n";
						$XML=$XML."</ventas>"."\r\n";

						 
						 fwrite($open, $XML);
						 fclose($open);
				
								$local_file="_arc_tmp/".$NOM_ARCHIVO;
								$server_file = $DIR_EX_FLS_OUT.$NOM_ARCHIVO;
				
								$local_file="_arc_tmp/".$NOM_ARCHIVO;
								copy($local_file, $DIR_CVM."OUT/".$NOM_ARCHIVO);

						$SQLM="UPDATE CM_CARTAS SET NOMBXML='".$NOM_ARCHIVO."' WHERE ID_CARTA=".$GENCARTA;
						$RSM2 = sqlsrv_query($conn, $SQLM);
						//oci_execute($RSM2);

		}
?>