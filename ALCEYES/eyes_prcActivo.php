<?php include("session.inc");?>
<?php
	$B_TIPESTADO=@$_GET["fls"];
	$B_PROCESO=@$_GET["flp"];
	$Filtrado="";
	if(!empty($B_TIPESTADO) && empty($B_PROCESO)){
		$Filtrado=" AND TIP_ESTADO=".$B_TIPESTADO;
	}
	if(empty($B_TIPESTADO) && !empty($B_PROCESO)){
		$Filtrado=" AND ID_PROCESO=".$B_PROCESO;
	}
	if(!empty($B_TIPESTADO) && !empty($B_PROCESO)){
		$Filtrado=" AND ID_PROCESO=".$B_PROCESO." AND TIP_ESTADO=".$B_TIPESTADO;
	}

				//FECHA REGISTRO DESDE
				$dia_ed=@$_GET["dia_ed"];
				$mes_ed=@$_GET["mes_ed"];
				$ano_ed=@$_GET["ano_ed"];
				//FECHA REGISTRO HASTA
				$dia_eh=@$_GET["dia_eh"];
				$mes_eh=@$_GET["mes_eh"];
				$ano_eh=@$_GET["ano_eh"];
				//CONSTRUYE FECHAS
				$FECHA_ED=$ano_ed.$mes_ed.$dia_ed;
				$FECHA_EH=$ano_eh.$mes_eh.$dia_eh;
					//FILTRO FECHA MENSAJE
					$F_FECHA=" WHERE ((CONVERT(VARCHAR(10), EXECUTION_DATE, 112) >= '".$FECHA_ED."') AND ((CONVERT(VARCHAR(10), EXECUTION_DATE, 112) <='".$FECHA_EH."')"; 

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
			self.location.href="eyes_prcActivo.php?fls=<?php echo $B_TIPESTADO?>&flp=<?php echo $B_PROCESO?>&dia_ed=<?php echo $dia_ed?>&mes_ed=<?php echo $mes_ed?>&ano_ed=<?php echo $ano_ed?>&dia_eh=<?php echo $dia_eh?>&mes_eh=<?php echo $mes_eh?>&ano_eh=<?php echo $ano_eh?>"
		}
		function RelVentana(TimeRefresh,refreshColor) {
		   setTimeout('autoRefresh()',TimeRefresh)
		}
		function FiltraEstado(val) {
		   var FltSever = val;
		   self.location.href="eyes_prcActivo.php?fls="+val+"&flp=<?php echo $B_PROCESO?>&dia_ed=<?php echo $dia_ed?>&mes_ed=<?php echo $mes_ed?>&ano_ed=<?php echo $ano_ed?>&dia_eh=<?php echo $dia_eh?>&mes_eh=<?php echo $mes_eh?>&ano_eh=<?php echo $ano_eh?>";
		}
		function FiltraProceso(val) {
		   var FltProc = val;
		   self.location.href="eyes_prcActivo.php?fls=<?php echo $B_TIPESTADO?>&flp="+val+"&dia_ed=<?php echo $dia_ed?>&mes_ed=<?php echo $mes_ed?>&ano_ed=<?php echo $ano_ed?>&dia_eh=<?php echo $dia_eh?>&mes_eh=<?php echo $mes_eh?>&ano_eh=<?php echo $ano_eh?>";
		}
</script>
</head>
<body onLoad="RelVentana(15000,'#FFFFFF');">

                    <select name="B_PROCESO" id="B_PROCESO" onchange="FiltraProceso(this.value);">
                        <option value="0">Filtrar Proceso</option>
                        <?php
                        if(!empty($B_TIPESTADO)){
                                $SQL="SELECT ID_PROCESO FROM FP_EJECUCION ".$F_FECHA." AND TIP_ESTADO=".$B_TIPESTADO." GROUP BY ID_PROCESO ORDER BY ID_PROCESO ASC";
                        } else {
                                $SQL="SELECT ID_PROCESO FROM FP_EJECUCION ".$F_FECHA." GROUP BY ID_PROCESO ORDER BY ID_PROCESO ASC";
                        }
                        $RS = sqlsrv_query($conn, $SQL);
                        //oci_execute($RS);
                        while ($row = sqlsrv_fetch_array($RS)){
                                $SEL_ID_PROCESO=$row['ID_PROCESO'];
                                $SQLE="SELECT * FROM FP_PROCESO WHERE ID_PROCESO=".$SEL_ID_PROCESO;
                                $RSE = sqlsrv_query($conn, $SQLE);
                                //oci_execute($RSE);
                                if ($rowE = sqlsrv_fetch_array($RSE)){
                                        $ABR_PROCESO=$rowE['ABR_PROCESO'];
                                }
                        ?>
                                    <option value="<?php echo $SEL_ID_PROCESO;?>" <?php if($SEL_ID_PROCESO==$B_PROCESO) {echo "SELECTED";}?>><?php echo $ABR_PROCESO;?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <select name="B_TIPESTADO" id="B_TIPESTADO" onchange="FiltraEstado(this.value);">
                        <option value="0">Filtrar Estado</option>
                        <?php
                        if(!empty($B_PROCESO)){
                                $SQL="SELECT TIP_ESTADO FROM FP_EJECUCION ".$F_FECHA." AND ID_PROCESO=".$B_PROCESO." GROUP BY TIP_ESTADO ORDER BY TIP_ESTADO ASC";
                        } else {
                                $SQL="SELECT TIP_ESTADO FROM FP_EJECUCION ".$F_FECHA." GROUP BY TIP_ESTADO ORDER BY TIP_ESTADO ASC";
                        }
                        $RS = sqlsrv_query($conn, $SQL);
                        //oci_execute($RS);
                        while ($row = sqlsrv_fetch_array($RS)){
                                $SEL_TIP_ESTADO=$row['TIP_ESTADO'];
                                $SQLE="SELECT * FROM FM_TIP_ESTADO WHERE ID_TIP_ESTADO=".$SEL_TIP_ESTADO;
                                $RSE = sqlsrv_query($conn, $SQLE);
                                //oci_execute($RSE);
                                if ($rowE = sqlsrv_fetch_array($RSE)){
                                        $DES_TIP_ESTADO=$rowE['DES_TIP_ESTADO'];
                                        $ABR_TIP_ESTADO=$rowE['ABR_TIP_ESTADO'];
                                }
                        ?>
                                    <option value="<?php echo $SEL_TIP_ESTADO;?>" <?php if($SEL_TIP_ESTADO==$B_TIPESTADO) {echo "SELECTED";}?>><?php echo $DES_TIP_ESTADO." [".$ABR_TIP_ESTADO."]";?></option>
                        <?php
                        }
                        ?>
                        </select>

                        <h3 style="clear:left">&Uacute;ltimos <?=$MNCE?> Procesos de la Cadena</h3>

                        <table id="Listado-Eyes" width="100%">
						<?php
                                $SQL="SELECT * FROM FP_EJECUCION ".$F_FECHA.$Filtrado." ORDER BY ID_EJECUCION DESC";
                                $RS = sqlsrv_query($conn, $SQL);
                                //oci_execute($RS);
                                while ($row = sqlsrv_fetch_array($RS)){
										if($NUM_LINEA<=$MNCE){
													$ID_EJECUCION=$row['ID_EJECUCION'];
													$TIP_ESTADO=$row['TIP_ESTADO'];
													$SQLE="SELECT * FROM FM_TIP_ESTADO WHERE ID_TIP_ESTADO=".$TIP_ESTADO;
													$RSE = sqlsrv_query($conn, $SQLE);
													//oci_execute($RSE);
													if ($rowE = sqlsrv_fetch_array($RSE)){
															$DES_TIP_ESTADO=$rowE['DES_TIP_ESTADO'];
															$ABR_TIP_ESTADO=$rowE['ABR_TIP_ESTADO'];
															$BGCOLOR_TIP_ESTADO=$rowE['BGCOLOR_TIP_ESTADO'];
															$CSSFONT_TIP_ESTADO=$rowE['CSSFONT_TIP_ESTADO'];
													}
													echo "<tr>";



													$SQLD="SELECT (CONVERT(VARCHAR(10), EXECUTION_DATE, 103) + ' '  + convert(VARCHAR(8), EXECUTION_DATE, 14)) AS FECHAHORA FROM FP_EJECUCION WHERE ID_EJECUCION=".$ID_EJECUCION;
													$RSD = sqlsrv_query($conn, $SQLD);
													//oci_execute($RSD);
													if ($rowD = sqlsrv_fetch_array($RSD)) {
															$EXECUTION_DATE=date($rowD['FECHAHORA']);
													}
													$DATA=$row['DATA'];
													
													$ID_EQUIPO=$row['ID_EQUIPO'];
															$SQL1="SELECT * FROM FM_EQUIPO WHERE ID_EQUIPO=".$ID_EQUIPO;
															$RS1 = sqlsrv_query($conn, $SQL1);
															//oci_execute($RS1);
															if ($row1 = sqlsrv_fetch_array($RS1)) {
																	$ELEQUIPO=$row1['DES_CLAVE'];
															}

													$ID_PROCESO=$row['ID_PROCESO'];
															$SQL1="SELECT * FROM FP_PROCESO WHERE ID_PROCESO=".$ID_PROCESO;
															$RS1 = sqlsrv_query($conn, $SQL1);
															//oci_execute($RS1);
															if ($row1 = sqlsrv_fetch_array($RS1)) {
																	$ELPROCESO=$row1['DES_PROCESO'];
																	$ABR_PROCESO=$row1['ABR_PROCESO'];
															}

												$ID_LOCAL = $row['ID_LOCAL'];
												$SQL1="SELECT DES_TIENDA FROM MN_TIENDA WHERE DES_CLAVE=".$ID_LOCAL;
												$RS1 = sqlsrv_query($maestra, $SQL1);
												//oci_execute($RS1);
												if ($row1 = sqlsrv_fetch_array($RS1)){
													$DES_TIENDA = $row1['DES_TIENDA'];
												}
												$ID_LOCAL = $row['ID_LOCAL'];
												if($ID_LOCAL == 0){
													$NMB_Local = $DES_TIENDA;
												} else {
													$NMB_Local = "L".substr("0000".$ID_LOCAL, -4);
												}
												?>
												<td style="background:<?=$BGCOLOR_TIP_ESTADO?>; opacity:0.9;<?=$CSSFONT_TIP_ESTADO?>" nowrap="nowrap"><?=$NMB_Local?></td>
												<td style="background:<?=$BGCOLOR_TIP_ESTADO?>; <?=$CSSFONT_TIP_ESTADO?>; text-align:center; font-weight:600; font-size:12pt"><?=$ABR_TIP_ESTADO?></td>
												<td style="background:<?=$BGCOLOR_TIP_ESTADO?>; opacity:0.9; <?=$CSSFONT_TIP_ESTADO?>" nowrap="nowrap"><?=$ELEQUIPO." ".$ABR_PROCESO?></td>
												<td style="background:<?=$BGCOLOR_TIP_ESTADO?>; opacity:0.8; <?=$CSSFONT_TIP_ESTADO?>" nowrap="nowrap"><?=$EXECUTION_DATE."hrs."?></td>
												<td style="padding:0; vertical-align:top" nowrap="nowrap">
																<div style="position:relative; padding:10px; left:0; top:0">
																	  <span style="color:transparent"><?=$ELPROCESO."/ ".$DES_TIP_ESTADO.": ".$DATA?></span>
																	<div style="position:absolute; left:0; top:0; width:100%; padding:10px; z-index:100; background:<?=$BGCOLOR_TIP_ESTADO?>; opacity:0.06; <?=$CSSFONT_TIP_ESTADO?>">
																	  <span style="color:transparent"><?=$ELPROCESO."/ ".$DES_TIP_ESTADO.": ".$DATA?></span>
																	</div>
																	<div style="position:absolute; left:0; top:0; padding:10px; z-index:120; background:transparent; color:#333">
																		<?=$ELPROCESO."/ ".$DES_TIP_ESTADO.": ".$DATA?>
																	</div>
															   </div>
												 </td>
												 </tr>
												<?php		
										}
										$NUM_LINEA=$NUM_LINEA+1;
                                }
						?>
                        </table>
</body>
</html>