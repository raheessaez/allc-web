<?php include("session.inc");?>
<?php
		//FECHA REGISTRO DESDE
		$dia_ed=@$_GET["dia_ed"];
		$mes_ed=@$_GET["mes_ed"];
		$ano_ed=@$_GET["ano_ed"];
		//FECHA REGISTRO HASTA
		$dia_eh=@$_GET["dia_eh"];
		$mes_eh=@$_GET["mes_eh"];
		$ano_eh=@$_GET["ano_eh"];
		//CONSTRUYE FECHAS
		$FECHA_ED=$ano_ed."/".$mes_ed."/".$dia_ed;
		$FECHA_EH=$ano_eh."/".$mes_eh."/".$dia_eh;
		//FILTRO FECHA MENSAJE
		$F_FECHA=" WHERE (Convert(varchar(20), EVENT_DATE, 112) >= '".$FECHA_ED."') AND (Convert(varchar(20), EVENT_DATE, 112) <='".$FECHA_EH."')"; 

		//PAGINACION
		$LSUP=@$_GET["LSUP"];
		if ($LSUP=="") {
			$LSUP=$CTP;
		}
		$LINF=@$_GET["LINF"];
		if ($LINF=="") {
			$LINF=1;
		}

	$ID_LOCAL=@$_GET["idl"];
	$ID_EQUIPO=@$_GET["ideq"];
	$B_SEVERITY=@$_GET["fls"];
	$FiltraSeveridad="";
	if(!empty($B_SEVERITY)){
		$FiltraSeveridad=" AND SEVERITY=".$B_SEVERITY;
	}

	$SQL1="SELECT * FROM MN_TIENDA WHERE DES_CLAVE=".$ID_LOCAL;
	$RS1 = sqlsrv_query($maestra, $SQL1);
	//oci_execute($RS1);
	if ($row1 = sqlsrv_fetch_array($RS1)){
		$NMB_Local = $row1['DES_TIENDA'];
	}
	if($ID_LOCAL == 0){
		$DSC_Local = $NMB_Local;
	} else { 
		$DSC_Local = "L".substr("0000".$ID_LOCAL, -4)." ".$NMB_Local;
	}


	$EQUIPO="";
	$FLT_EQUIPO="";
	if(!empty($ID_EQUIPO)){
		$FLT_EQUIPO=" AND ID_EQUIPO=".$ID_EQUIPO;
		$SQL1="SELECT * FROM FM_EQUIPO WHERE ID_EQUIPO=".$ID_EQUIPO;
		$RS1 = sqlsrv_query($conn, $SQL1);
		//oci_execute($RS1);
		if ($row1 = sqlsrv_fetch_array($RS1)){
			$DES_CLAVE = $row1['DES_CLAVE'];
			$DES_EQUIPO = $row1['DES_EQUIPO'];
			$ID_TIPO = $row1['ID_TIPO'];
			$DIP_EQUIPO = $row1['IP'];
		}
		$SQL1="SELECT * FROM FM_TIPO_EQUIPO WHERE ID_TIPO=".$ID_TIPO;
		$RS1 = sqlsrv_query($conn, $SQL1);
		//oci_execute($RS1);
		if ($row1 = sqlsrv_fetch_array($RS1)){
			$DES_TIPO = $row1['DES_TIPO'];
		}
		$EQUIPO=$DES_TIPO." ".$DES_EQUIPO." (".$DES_CLAVE .")";
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=9">	      <!-- IE9 Standards -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
<meta name="description" content="Alliances"/>
<meta name="author" content="Design: Alliances | Code: Claudio Arellano">
<title>EYES</title>
<link rel="stylesheet" href="../css/_mng_estilos.css" media="screen">
<script language=JavaScript src="../js/javascript.js"></script>
<script language=JavaScript src="funciones.js"></script>

<script language="JavaScript">
		function autoRefresh() {
			self.location.href="eyes_msjeTienda.php?idl=<?php echo $ID_LOCAL;?>&ideq=<?php echo $ID_EQUIPO;?>&dia_ed=<?php echo $dia_ed?>&mes_ed=<?php echo $mes_ed?>&ano_ed=<?php echo $ano_ed?>&dia_eh=<?php echo $dia_eh?>&mes_eh=<?php echo $mes_eh?>&ano_eh=<?php echo $ano_eh?>"
		}
		function refreshAdv(refreshTime,refreshColor) {
		   setTimeout('autoRefresh()',refreshTime)
		}

		function Recargar(val) {
			self.location.href=val;
		}

		function FiltraSeveridad(val) {
		   var FltSever = val;
		   self.location.href="eyes_msjeTienda.php?idl=<?php echo $ID_LOCAL;?>&ideq=<?php echo $ID_EQUIPO;?>&fls="+val+"&dia_ed=<?php echo $dia_ed?>&mes_ed=<?php echo $mes_ed?>&ano_ed=<?php echo $ano_ed?>&dia_eh=<?php echo $dia_eh?>&mes_eh=<?php echo $mes_eh?>&ano_eh=<?php echo $ano_eh?>";
		}

</script>
</head>
<body onLoad="refreshAdv(30000,'#FFFFFF');">

                        <?php
								$CONSULTA="SELECT COUNT(*) AS CUENTA  FROM FE_MESSAGE ".$F_FECHA." AND ID_LOCAL=".$ID_LOCAL.$FLT_EQUIPO.$FiltraSeveridad." ORDER BY ID_MESSAGE DESC";
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
								?>
								<?php
                                if ($LINF>=$CTP+1) {
                                    $ATRAS=$LINF-$CTP;
                                    $FILA_ANT=$LSUP-$CTP;
                               ?>
                                <input name="ANTERIOR" type="button" value="Anterior"  onClick="Recargar('eyes_msjeTienda.php?idl=<?php echo $ID_LOCAL;?>&ideq=<?php echo $ID_EQUIPO;?>&dia_ed=<?php echo $dia_ed?>&mes_ed=<?php echo $mes_ed?>&ano_ed=<?php echo $ano_ed?>&dia_eh=<?php echo $dia_eh?>&mes_eh=<?php echo $mes_eh?>&ano_eh=<?php echo $ano_eh?>&LSUP=<?php echo $FILA_ANT?>&LINF=<?php echo $ATRAS?>&fls=<?php echo $B_SEVERITY?>');">
                                <?php
                                }
                                if ($LSUP<=$TOTALREG) {
                                    $ADELANTE=$LSUP+1;
                                    $FILA_POS=$LSUP+$CTP;
                               ?>
                                <input name="SIGUIENTE" type="button" value="Siguiente" onClick="Recargar('eyes_msjeTienda.php?idl=<?php echo $ID_LOCAL;?>&ideq=<?php echo $ID_EQUIPO;?>&dia_ed=<?php echo $dia_ed?>&mes_ed=<?php echo $mes_ed?>&ano_ed=<?php echo $ano_ed?>&dia_eh=<?php echo $dia_eh?>&mes_eh=<?php echo $mes_eh?>&ano_eh=<?php echo $ano_eh?>&LSUP=<?php echo $FILA_POS?>&LINF=<?php echo $ADELANTE?>&fls=<?php echo $B_SEVERITY?>');">
                               <?php }?>
                                <select name="B_SEVERITY" id="B_SEVERITY" onchange="FiltraSeveridad(this.value);">
                                    <option value="0">Filtrar Severidad</option>
                                    <?php
                                    $SQL="SELECT SEVERITY FROM FE_MESSAGE ".$F_FECHA." AND ID_LOCAL=".$ID_LOCAL.$FLT_EQUIPO." GROUP BY SEVERITY ORDER BY SEVERITY ASC";
                                    $RS = sqlsrv_query($conn, $SQL);
                                    //oci_execute($RS);
                                    while ($row = sqlsrv_fetch_array($RS)){
                                            $SEL_SEVERITY=$row['SEVERITY'];
                                            $SQLE="SELECT * FROM FM_TIP_SEVER WHERE ID_TIP_SEVER=".$SEL_SEVERITY;
                                            $RSE = sqlsrv_query($conn, $SQLE);
                                            //oci_execute($RSE);
                                            if ($rowE = sqlsrv_fetch_array($RSE)){
                                                    $DES_TIP_SEVER=$rowE['DES_TIP_SEVER'];
                                            }
                                    ?>
                                                <option value="<?php echo $SEL_SEVERITY;?>" <?php if($SEL_SEVERITY==$B_SEVERITY) {echo "SELECTED";}?>><?=$DES_TIP_SEVER;?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <h3 style="clear:left">Ventana de Mensajes <?=$DSC_Local;?><br></span><?=$EQUIPO." ".$DIP_EQUIPO;?></h3>

                                <table id="Listado-Eyes" width="100%">
                                <?php
								$CUENTATD=1;
								$NUM_LINEA=1;
								$FACTOR=$NUMPAG-1;
								if($FACTOR>=1) { 
									$NUM_LINEA=$NUM_LINEA+($CTP*$FACTOR);
								}
							
								//$SQL="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM FE_MESSAGE ".$F_FECHA." AND ID_LOCAL=".$ID_LOCAL.$FLT_EQUIPO.$FiltraSeveridad." ORDER BY ID_MESSAGE DESC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;
                                
                                //oci_execute($RS);
								
					
								
                                 $SQL= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY ID_MESSAGE DESC) ROWNUMBER FROM FE_MESSAGE ) AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";
								//echo $SQL."<br>";
								$RS = sqlsrv_query($conn, $SQL);
                                while ($row = sqlsrv_fetch_array($RS)){
													$ID_MESSAGE=$row['ID_MESSAGE'];
													$SEVERITY=$row['SEVERITY'];
															$SQLE="SELECT * FROM FM_TIP_SEVER WHERE ID_TIP_SEVER=".$SEVERITY;
															$RSE = sqlsrv_query($conn, $SQLE);
															//oci_execute($RSE);
															if ($rowE = sqlsrv_fetch_array($RSE)){
																	$DES_TIP_SEVER=$rowE['DES_TIP_SEVER'];
																	$ABR_TIP_SEVER=$rowE['ABR_TIP_SEVER'];
																	$BGCOLOR_TIP_SEVER=$rowE['BGCOLOR_TIP_SEVER'];
																	$CSSFONT_TIP_SEVER=$rowE['CSSFONT_TIP_SEVER'];
															}
													echo "<tr>";
													$MESSAGE_GROUP=$row['MESSAGE_GROUP'];
													$MESSAGE_NUMBER=$row['MESSAGE_NUMBER'];
													$SOURCE_NUMBER=$row['SOURCE_NUMBER'];
														$lensubLaFuente= strlen($SOURCE_NUMBER);	
														$IDlaFuente = substr($SOURCE_NUMBER, 0, 1);
														if(empty($IDlaFuente)){$IDlaFuente="S";}
														$laFuente = substr($SOURCE_NUMBER, 1, $lensubLaFuente-1);
														if(empty($laFuente)){$laFuente="x";}
													$EVENT_NUMBER=$row['EVENT_NUMBER'];
														$lensubelEvento= strlen($EVENT_NUMBER);	
														$IDelEvento = substr($EVENT_NUMBER, 0, 1);
														if(empty($IDelEvento)){$IDelEvento="E";}
														$elEvento = substr($EVENT_NUMBER, 1, $lensubelEvento-1);
														if(empty($elEvento)){$elEvento="x";}
													$SQLD="SELECT (CONVERT(VARCHAR(10), EVENT_DATE, 103) + ' '  + convert(VARCHAR(8), EVENT_DATE, 14)) as FECHAHORA FROM FE_MESSAGE WHERE ID_MESSAGE=".$ID_MESSAGE;
													$RSD = sqlsrv_query($conn, $SQLD);
													//oci_execute($RSD);
													if ($rowD = sqlsrv_fetch_array($RSD)) {
															$EVENT_DATE=date($rowD['FECHAHORA']);
													}
													$DATA=$row['DATA'];
													$ID_EQUIPO=$row['ID_EQUIPO'];
															$SQL1="SELECT * FROM FM_EQUIPO WHERE ID_EQUIPO=".$ID_EQUIPO;
															$RS1 = sqlsrv_query($conn, $SQL1);
															//oci_execute($RS1);
															if ($row = sqlsrv_fetch_array($RS1)) {
																	$ELEQUIPO=$row['DES_CLAVE'];
																	$ID_TIPO=$row['ID_TIPO'];
																	$IP_EQUIPO=$row['IP'];
															}
															if($ID_TIPO==2){
																$SQL2="SELECT * FROM FM_EQUIPO WHERE IP='".$IP_EQUIPO."' AND ID_TIPO=1";
																$RS2 = sqlsrv_query($conn, $SQL2);
																//oci_execute($RS2);
																if ($row = sqlsrv_fetch_array($RS2)) {
																	$ELNODO=$row['DES_CLAVE'];
																	$ELEQUIPO=substr("000".$ELEQUIPO, -3);
																} 
															} else {
																$ELNODO=$ELEQUIPO;
																$ELEQUIPO="";
															}
												$ID_LOCAL = $row['ID_LOCAL'];
												if($ID_LOCAL == 0){ $NMB_Local = "ARMS";} else { $NMB_Local = "L".substr("0000".$ID_LOCAL, -4);}

															/*
															$LineaDeMensaje = "<span class='elLocal' style='margin-right:0'>".$NMB_Local."</span><span class='elNivel".$SEVERITY."'>".$SEVERITY."</span><span class='elMensaje'>".$ELNODO."  ".$ELEQUIPO."  <strong>".$MESSAGE_GROUP."</strong>".$MESSAGE_NUMBER." <strong>".$IDlaFuente."</strong>".$laFuente." <strong>".$IDelEvento."</strong>".$elEvento."</span> ".$EVENT_DATE."hrs. ".$DATA;
															echo "<td style='color:#999;background-color:".$TDCOLOR."' >";
															echo $NUM_LINEA;
															echo "</td>";
															echo "<td nowrap style='background-color:".$TDCOLOR."; border-left-width:1px; border-left-color:#CCC; border-left-style:dotted;' >";
															echo $LineaDeMensaje;
															echo "</td>";
															echo "</tr>";
															*/

												?>
															<td style="background:<?=$BGCOLOR_TIP_SEVER?>; opacity:0.9;<?=$CSSFONT_TIP_SEVER?>" nowrap="nowrap"><?=$NMB_Local?></td>
															<td style="background:<?=$BGCOLOR_TIP_SEVER?>; <?=$CSSFONT_TIP_SEVER?>; text-align:center; font-weight:600; font-size:12pt"><?=$ABR_TIP_SEVER?></td>
															<td style="background:<?=$BGCOLOR_TIP_SEVER?>; opacity:0.95; font-weight:600; font-size:12pt; <?=$CSSFONT_TIP_SEVER?>" nowrap="nowrap"><?=$ELNODO." ".$ELEQUIPO?></td>
															<td style="background:<?=$BGCOLOR_TIP_SEVER?>; font-size:12pt; opacity:0.90;<?=$CSSFONT_TIP_SEVER?>" nowrap="nowrap"><?=$MESSAGE_GROUP." ".$MESSAGE_NUMBER."  ".$IDlaFuente." ".$laFuente."  ".$IDelEvento." ".$elEvento?></td>
															<td style="background:<?=$BGCOLOR_TIP_SEVER?>; opacity:0.8; <?=$CSSFONT_TIP_SEVER?>" nowrap="nowrap"><?=$EVENT_DATE."hrs."?></td>
															<td style="padding:0; vertical-align:top" nowrap="nowrap">
																			<div style="position:relative; padding:10px; left:0; top:0">
																				  <span style="color:transparent"><?=$DATA?></span>
																				<div style="position:absolute; left:0; top:0; width:100%; padding:10px; z-index:100; background:<?=$BGCOLOR_TIP_SEVER?>; opacity:0.06; <?=$CSSFONT_TIP_SEVER?>">
																				  <span style="color:transparent"><?=$DATA?></span>
																				</div>
																				<div style="position:absolute; left:0; top:0; padding:10px; z-index:120; background:transparent; color:#333">
																					<?=$DATA?>
																				</div>
																		   </div>
															 </td>
															 </tr>
                                                <?php
												$NUM_LINEA=$NUM_LINEA+1;
                                }
						?>
                        </table>
</body>
</html>