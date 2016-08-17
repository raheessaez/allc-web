
<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1157;
	$NOMENU=1;


	$FILTRO_TIENDA="";
	$FTIENDA=@$_POST["FTIENDA"];
	if (empty($FTIENDA)) { $FTIENDA=@$_GET["FTIENDA"] ;}
	if (empty($FTIENDA)) { $FTIENDA=0 ;}
	if ($FTIENDA!=0) {
		$FILTRO_TIENDA=" AND ID_BSN_UN=".$FTIENDA ;
	}
		
	$FILTRO_TERM="";
	$FTERM=@$_POST["FTERM"];
	if (empty($FTERM)) { $FTERM=@$_GET["FTERM"] ;}
	if (empty($FTERM)) { $FTERM=0 ;}
	if ($FTERM!=0) {
		$FILTRO_TERM=" AND ID_WS=".$FTERM ;
	}
		
	$FILTRO_OPERA="";
	$FOPERA=@$_POST["FOPERA"];
	if (empty($FOPERA)) { $FOPERA=@$_GET["FOPERA"] ;}
	if (empty($FOPERA)) { $FOPERA=0 ;}
	if ($FOPERA!=0) {
		$FILTRO_OPERA=" AND ID_OPR=".$FOPERA ;
	}
		
			
					//CALCULAR MINIMO Y MÁXIMO FECHA REGISTRO
					$CONSULTA2="SELECT MIN(FECHA) AS MFECHA FROM BDVAL";
					
					//$RS2 = sqlsrv_query($conn, $CONSULTA2);
					////oci_execute($RS2);
					$RS2 = sqlsrv_query($conn,$CONSULTA2);
					
					if ($row = sqlsrv_fetch_array($RS2)){
							$MIN_FECHA_EMS = $row['MFECHA'];
							@$date = date_create($MIN_FECHA_EMS);
							$MIN_FECHA_EMS = @date_format($date, 'd/m/Y');
					}

					$CONSULTA2="SELECT MAX(FECHA) AS MFECHA FROM BDVAL";
					
					//$RS2 = sqlsrv_query($conn, $CONSULTA2);
					////oci_execute($RS2);
					$RS2 = sqlsrv_query($conn,$CONSULTA2);
					
					if ($row = sqlsrv_fetch_array($RS2)){
							$MAX_FECHA_EMS = $row['MFECHA'];
							@$date = date_create($MAX_FECHA_EMS);
							$MAX_FECHA_EMS = @date_format($date, 'd/m/Y');
					}

					if (empty($MIN_FECHA_EMS)) { $MIN_FECHA_EMS=date('d/m/Y'); }
					if (empty($MAX_FECHA_EMS)) { $MAX_FECHA_EMS=date('d/m/Y'); }
					

					//FECHA REGISTRO DESDE
					$DIA_ED=@$_POST["DIA_ED"];
					if (empty($DIA_ED)) { $DIA_ED=@$_GET["DIA_ED"]; }
					if (empty($DIA_ED)) { $DIA_ED=substr($MIN_FECHA_EMS, 0, 2); }
					$MES_ED=@$_POST["MES_ED"];
					if (empty($MES_ED)) { $MES_ED=@$_GET["MES_ED"]; }
					if (empty($MES_ED)) { $MES_ED=substr($MIN_FECHA_EMS, 3, 2); }
					$ANO_ED=@$_POST["ANO_ED"];
					if (empty($ANO_ED)) { $ANO_ED=@$_GET["ANO_ED"]; }
					if (empty($ANO_ED)) { $ANO_ED='20'.substr($MIN_FECHA_EMS, -2); }
					//FECHA REGISTRO HASTA
					$DIA_EH=@$_POST["DIA_EH"];
					if (empty($DIA_EH)) { $DIA_EH=@$_GET["DIA_EH"]; }
					if (empty($DIA_EH)) { $DIA_EH=substr($MAX_FECHA_EMS, 0, 2); }
					$MES_EH=@$_POST["MES_EH"];
					if (empty($MES_EH)) { $MES_EH=@$_GET["MES_EH"]; }
					if (empty($MES_EH)) { $MES_EH=substr($MAX_FECHA_EMS, 3, 2); }
					$ANO_EH=@$_POST["ANO_EH"];
					if (empty($ANO_EH)) { $ANO_EH=@$_GET["ANO_EH"]; }
					if (empty($ANO_EH)) { $ANO_EH='20'.substr($MAX_FECHA_EMS, -2); }
					//CONSTRUYE FECHAS REGISTRO
					//VALIDAR FECHA_ED
					if (checkdate($MES_ED, $DIA_ED, $ANO_ED)==false) { 
						$MSJE=2 ;
						$DIA_ED=substr($MIN_FECHA_EMS, 0, 2);
						$MES_ED=substr($MIN_FECHA_EMS, 3, 2);
						$ANO_ED='20'.substr($MIN_FECHA_EMS, -2);
						$DIA_EH=substr($MAX_FECHA_EMS, 0, 2);
						$MES_EH=substr($MAX_FECHA_EMS, 3, 2);
						$ANO_EH='20'.substr($MAX_FECHA_EMS, -2);
					}
					$DIA_ED=substr('00'.$DIA_ED, -2);
					$MES_ED=substr('00'.$MES_ED, -2);
					$FECHA_ED=$DIA_ED."/".$MES_ED."/".$ANO_ED;
					
					if (checkdate($MES_EH, $DIA_EH, $ANO_EH)==false) { 
						$MSJE=3 ;
						$DIA_ED=substr($MIN_FECHA_EMS, 0, 2);
						$MES_ED=substr($MIN_FECHA_EMS, 3, 2);
						$ANO_ED='20'.substr($MIN_FECHA_EMS, -2);
						$DIA_EH=substr($MAX_FECHA_EMS, 0, 2);
						$MES_EH=substr($MAX_FECHA_EMS, 3, 2);
						$ANO_EH='20'.substr($MAX_FECHA_EMS, -2);
					}
					$DIA_EH=substr('00'.$DIA_EH, -2);
					$MES_EH=substr('00'.$MES_EH, -2);
					$FECHA_EH=$DIA_EH."/".$MES_EH."/".$ANO_EH;
		//FILTRO FECHA REGISTRO
					if ($MES_ED."-".$DIA_ED."-".$ANO_ED==$MES_EH."-".$DIA_EH."-".$ANO_EH) {
							$UNDIA=1;
						} else {
							$UNDIA=0;
						}

					$F_FECHA=" WHERE (convert(varchar(20),FECHA, 111) >= convert(varchar(20),'".$ANO_ED."/".$MES_ED."/".$DIA_ED."', 111) AND convert(varchar(20),FECHA, 111) <= convert(varchar(20),'".$ANO_EH."/".$MES_EH."/".$DIA_EH."', 111))"; 
		
?>

</head>

<body>

<?php include("encabezado.php");?>
<?php include("titulo_menu.php");?>

<table width="100%" height="100%">
<tr>
<td align="right"  width="200" bgcolor="#FFFFFF"><?php include("menugeneral.php");?></td> 
<td >

        <table width="100%">
        <tr><td>
        <table width="100%" id="Filtro">
          <tr>
            <td>
                <form action="reg_bolsas.php" method="post" name="frmbuscar" id="frmbuscar">


                          				      <label for="FECHA_EM_D" >Desde </label>
                                              <input name="DIA_ED" type="text"  id="DIA_ED" value="<?php echo $DIA_ED ?>" size="2" maxlength="2" onKeyPress="return acceptNum(event);">
                                             <select name="MES_ED" id="MES_ED">
                          				            <option value="01" <?php  if ($MES_ED==1) { echo "SELECTED";}?>>Enero</option>
                          				            <option value="02" <?php  if ($MES_ED==2) { echo "SELECTED";}?>>Febrero</option>
                          				            <option value="03" <?php  if ($MES_ED==3) { echo "SELECTED";}?>>Marzo</option>
                          				            <option value="04" <?php  if ($MES_ED==4) { echo "SELECTED";}?>>Abril</option>
                          				            <option value="05" <?php  if ($MES_ED==5) { echo "SELECTED";}?>>Mayo</option>
                          				            <option value="06" <?php  if ($MES_ED==6) { echo "SELECTED";}?>>Junio</option>
                          				            <option value="07" <?php  if ($MES_ED==7) { echo "SELECTED";}?>>Julio</option>
                          				            <option value="08" <?php  if ($MES_ED==8) { echo "SELECTED";}?>>Agosto</option>
                          				            <option value="09" <?php  if ($MES_ED==9) { echo "SELECTED";}?>>Septiembre</option>
                          				            <option value="10" <?php  if ($MES_ED==10) { echo "SELECTED";}?>>Octubre</option>
                          				            <option value="11" <?php  if ($MES_ED==11) { echo "SELECTED";}?>>Noviembre</option>
                          				            <option value="12" <?php  if ($MES_ED==12) { echo "SELECTED";}?>>Diciembre</option>
                        				       </select>
                                               <input name="ANO_ED" type="text" id="ANO_ED" value="<?php echo $ANO_ED ?>" size="4" maxlength="4">
                       				          
                                              <label for="FECHA_EM_H" >Hasta</label>
                          				      <input name="DIA_EH" type="text"  id="DIA_EH" value="<?php echo $DIA_EH ?>" size="2" maxlength="2" onKeyPress="return acceptNum(event);">
                          				      <select name="MES_EH"  id="MES_EH">
                          				            <option value="01" <?php  if ($MES_EH==1) { echo "SELECTED";}?>>Enero</option>
                          				            <option value="02" <?php  if ($MES_EH==2) { echo "SELECTED";}?>>Febrero</option>
                          				            <option value="03" <?php  if ($MES_EH==3) { echo "SELECTED";}?>>Marzo</option>
                          				            <option value="04" <?php  if ($MES_EH==4) { echo "SELECTED";}?>>Abril</option>
                          				            <option value="05" <?php  if ($MES_EH==5) { echo "SELECTED";}?>>Mayo</option>
                          				            <option value="06" <?php  if ($MES_EH==6) { echo "SELECTED";}?>>Junio</option>
                          				            <option value="07" <?php  if ($MES_EH==7) { echo "SELECTED";}?>>Julio</option>
                          				            <option value="08" <?php  if ($MES_EH==8) { echo "SELECTED";}?>>Agosto</option>
                          				            <option value="09" <?php  if ($MES_EH==9) { echo "SELECTED";}?>>Septiembre</option>
                          				            <option value="10" <?php  if ($MES_EH==10) { echo "SELECTED";}?>>Octubre</option>
                          				            <option value="11" <?php  if ($MES_EH==11) { echo "SELECTED";}?>>Noviembre</option>
                          				            <option value="12" <?php  if ($MES_EH==12) { echo "SELECTED";}?>>Diciembre</option>
                        				            </select>
                          				        <input name="ANO_EH" type="text"  id="ANO_EH" value="<?php echo $ANO_EH ?>" size="4" maxlength="4" onKeyPress="return acceptNum(event);">
                       				           
                                               <input name="B_FECHA_E" type="submit"  id="B_FECHA_E" value="Filtrar">
                                               <input name="LIMPIAR" type="button"  id="LIMPIAR" value="Limpiar" onClick="pagina('reg_bolsas.php');">



                                    


                </form>
              </td>
              </tr>
              </table>
                <table style="margin:10px 20px; ">
                <tr>
                <td>
                <?php
					if ($MSJE==1) {
							$ELMSJ="Registro ejecutado";
						} 
					if ($MSJE <> "") {
               ?>
                    <div id="Mensaje">
                            <p><?php echo $ELMSJ?></p>
                    </div>
                <?php }?>
                
                
                <?php
				
				//$SQL="ALTER SESSION SET nls_date_format='DD-MM-YYYY HH24:MI:SS'";
				//$RS = sqlsrv_query($conn, $SQL);
				////oci_execute($RS);

				$CONSULTA="SELECT COUNT(ID_BDVAL) AS CUENTA FROM BDVAL ".$F_FECHA." ";		
				
				//$RS = sqlsrv_query($conn, $CONSULTA);
				////oci_execute($RS);
				$RS = sqlsrv_query($conn,$CONSULTA); 
				
				if ($row = sqlsrv_fetch_array($RS)) {
					$TOTALREG = $row['CUENTA'];
					$NUMREGS = $TOTALREG;
					$NUMTPAG = round($TOTALREG/$CTP,0);
					$RESTO=$TOTALREG%$CTP;
					$CUANTORESTO=round($RESTO/$CTP, 0);
					if($RESTO>0 and $CUANTORESTO==0) {$NUMTPAG=$NUMTPAG+1;}
					$NUMPAG = round($LSUP/$CTP,0);
					if ($NUMTPAG==0) {
						$NUMTPAG=1;
						}
				}
				
				$CONSULTA="SELECT SUM(MO_TND_FN_TRN) AS RETIRO FROM BDV_RET  WHERE ID_BDVAL IN(SELECT ID_BDVAL FROM BDVAL ".$F_FECHA.")";
				
				//$RS = sqlsrv_query($conn, $CONSULTA);
				////oci_execute($RS);
				$RS = sqlsrv_query($conn,$CONSULTA);

				if ($row = sqlsrv_fetch_array($RS)) {
					$TOTALRET = $row['RETIRO'];
				}
				$TOTALRECAUDO=$TOTALRET/$DIVCENTS;
				$TOTALRECAUDO=number_format($TOTALRECAUDO, $CENTS, $GLBSDEC, $GLBSMIL);
				
				
				//$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM BDVAL ".$F_FECHA." ORDER BY ID_BDVAL DESC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;
				$CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY ID_BDVAL DESC) ROWNUMBER FROM BDVAL ".$F_FECHA.") AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";

				//$RS = sqlsrv_query($conn, $CONSULTA);
				////oci_execute($RS);

				$RS = sqlsrv_query($conn,$CONSULTA);

               ?>
               
               
                <table id="Listado">
                <tr>
                	<th class="DataTH" colspan="8" style="padding:20px 6px 10px 36px">
                    	<h7>DPS: <?php echo $TOTALREG;?> / MNT: <?php echo $MONEDA.$TOTALRECAUDO;?></h7>
                    </th>
                </tr>
                <tr>
                    <th class="DataTH" colspan="2" style="padding-left: 36px">Bolsa</th>
                    <th class="DataTH">Tienda</th>
                    <th class="DataTH">Retiros</th>
                    <th class="DataTH">Monto</th>
                    <th class="DataTH">Estado</th>
                    <th class="DataTH" style="border-left-width:3px; border-left-style:solid; border-left-color:#DFDFDF">Fecha</th>
                    <th class="DataTH">Usuario</th>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){
                        $ID_BDVAL = $row['ID_BDVAL'];
                        $ESTADO = $row['ESTADO'];
						if($ESTADO==0){ $ELESTADO="EN REGISTRO";}
                        $FECHA = $row['FECHA'];
                        $LAFECHA = date_format($FECHA,"d-m-Y");

								//$RES_FEC=explode(" ",$FECHA);
								//$RDATE=$RES_FEC[0];
								//$RTIME=$RES_FEC[1];
								//$LAFECHA=$RDATE." ".$RTIME;
                        $IDREG =  $row['IDREG'];
						$S2="SELECT CD_STR_RT FROM BDV_RET WHERE ID_BDVAL=".$ID_BDVAL;
						
						//$RS2 = sqlsrv_query($conn, $S2);
						////oci_execute($RS2);
						$RS2 = sqlsrv_query($conn,$S2);
						
						if ($row2 = sqlsrv_fetch_array($RS2)) {
							$TIENDA = $row2['CD_STR_RT'];
						}	
						$S2="SELECT COUNT(ID_TRN) AS CUENTA FROM BDV_RET WHERE ID_BDVAL=".$ID_BDVAL;
						
						//$RS2 = sqlsrv_query($conn, $S2);
						////oci_execute($RS2);
						$RS2 = sqlsrv_query($conn,$S2);
						
						if ($row2 = sqlsrv_fetch_array($RS2)) {
							$NUMRETS = $row2['CUENTA'];
						}	
						$S2="SELECT SUM(MO_TND_FN_TRN) AS MONTO FROM BDV_RET WHERE ID_BDVAL=".$ID_BDVAL;
						
						//$RS2 = sqlsrv_query($conn, $S2);
						////oci_execute($RS2);
						$RS2 = sqlsrv_query($conn,$S2);
						
						if ($row2 = sqlsrv_fetch_array($RS2)) {
							$MONTOBLS = $row2['MONTO'];
						}
						$MONTOBLS_F=$MONTOBLS/$DIVCENTS;
						$MONTOBLS_F=number_format($MONTOBLS_F, $CENTS, $GLBSDEC, $GLBSMIL);
						$S2="SELECT NOMBRE FROM US_USUARIOS WHERE IDUSU=".$IDREG;

						//$RS2 = sqlsrv_query($maestra, $S2);
						////oci_execute($RS2);
						$RS2 = sqlsrv_query($maestra,$S2);
						
						if ($row2 = sqlsrv_fetch_array($RS2)) {
							$QUIENFUE = $row2['NOMBRE'];
						}	
               ?>
				   <script>
							 function Mostrar<?php echo $ID_BDVAL?>(){
							      var mostrar = document.getElementById("mostrar<?php echo $ID_BDVAL?>");
							      var ocultar = document.getElementById("ocultar<?php echo $ID_BDVAL?>");
							      var ver = document.getElementById("ver<?php echo $ID_BDVAL?>");
							      var Dp = document.getElementById("Dp<?php echo $ID_BDVAL?>");
											mostrar.style.display = "none";
											ocultar.style.display = "table-cell";
											ver.style.display = "table-row";
											Dp.className = "tdHide";
								}
							 function Ocultar<?php echo $ID_BDVAL?>(){
							      var mostrar = document.getElementById("mostrar<?php echo $ID_BDVAL?>");
							      var ocultar = document.getElementById("ocultar<?php echo $ID_BDVAL?>");
							      var ver = document.getElementById("ver<?php echo $ID_BDVAL?>");
							      var Dp = document.getElementById("Dp<?php echo $ID_BDVAL?>");
											mostrar.style.display = "table-cell";
											ocultar.style.display = "none";
											ver.style.display = "none";
											Dp.className = "tdShow";
								}
                </script>
                <tr>
                    <td class="tdShow" id="mostrar<?php echo $ID_BDVAL?>" onClick="Mostrar<?php echo $ID_BDVAL?>();"><img src="../images/ICO_ShowM.png"></td>
                    <td style="display:none" class="tdHide" id="ocultar<?php echo $ID_BDVAL?>" onClick="Ocultar<?php echo $ID_BDVAL?>();"><img src="../images/ICO_ShowB.png"></td>
                    <td class="tdShow" style="text-align:right; font-size:14pt" id="Dp<?php echo $ID_BDVAL?>"><?php echo $ID_BDVAL?></td>
                    <td style="text-align:right"><?php echo @$TIENDA?></td>
                    <td style="text-align:right"><?php echo $NUMRETS?></td>
                    <td style="text-align:right"><?php echo $MONEDA.$MONTOBLS_F?></td>
                    <td><?php echo $ELESTADO?></td>
                    <td style="border-left-width:3px; border-left-style:solid; border-left-color:#DFDFDF"><?php echo $LAFECHA?></td>
                    <td><?php echo $QUIENFUE?></td>
                </tr>
                <tr id="ver<?php echo $ID_BDVAL?>" style="display:none">
                	<td style="background-color:#FBF3FE"></td>
                    <td colspan="7">
                    	<table id="Listado">
                        		<tr>
                                	<th class="DataTH">TRX</th>
                                	<th class="DataTH">Terminal</th>
                                	<th class="DataTH">Operador</th>
                                	<th class="DataTH">Medio</th>
                                	<th class="DataTH">Monto</th>
                                	<th class="DataTH">Fecha TRX</th>
                                	<th class="DataTH">Inicio</th>
                                	<th class="DataTH">T&eacute;rmino</th>
                                </tr>
                                <?php
									$SQLTRX="SELECT * FROM BDV_RET WHERE ID_BDVAL=".$ID_BDVAL." ORDER BY AI_TRN ASC";
									
									//$RSTRX = sqlsrv_query($conn, $SQLTRX);
									////oci_execute($RSTRX);
									$RSTRX = sqlsrv_query($conn,$SQLTRX); 
									
									while ($RTRX = sqlsrv_fetch_array($RSTRX)) {
										$AI_TRN = $RTRX['AI_TRN'];
										$CD_WS = $RTRX['CD_WS'];
										$CD_OPR = $RTRX['CD_OPR'];
										$DE_TND = $RTRX['DE_TND'];
										$MO_TND_FN_TRN = $RTRX['MO_TND_FN_TRN'];
										$MO_TND_FN_TRN_F=$MO_TND_FN_TRN/$DIVCENTS;
										$MO_TND_FN_TRN_F=number_format($MO_TND_FN_TRN_F, $CENTS, $GLBSDEC, $GLBSMIL);
										$TS_TICKET = $RTRX['TS_TICKET'];
										$TS_TICKET = date_format($TS_TICKET,"d-m-Y");
											//$RES_BSN=explode(" ",$TS_TICKET);
											//$TS_TICKET=$RES_BSN[0];
										$TS_TRN_BGN = $RTRX['TS_TRN_BGN'];
										$TS_TRN_BGN = date_format($TS_TRN_BGN,"H:i:s");
											//$RES_BGN=explode(" ",$TS_TRN_BGN);
											//$TS_TRN_BGN=$RES_BGN[1];
										$TS_TRN_END = $RTRX['TS_TRN_END'];
										$TS_TRN_END = date_format($TS_TRN_END,"H:i:s");
											//$RES_END=explode(" ",$TS_TRN_END);
											//$TS_TRN_END=$RES_END[1];
										?>
                                        <tr>
                                            <td><?php echo $AI_TRN?></td>
                                            <td><?php echo $CD_WS?></td>
                                            <td><?php echo $CD_OPR?></td>
                                            <td><?php echo $DE_TND?></td>
                                            <td style="text-align:right"><?php echo $MONEDA.$MO_TND_FN_TRN_F?></td>
                                            <td  style="border-left-width:3px; border-left-style:solid; border-left-color:#DFDFDF"><?php echo $TS_TICKET?></td>
                                            <td style="text-align:right"><?php echo $TS_TRN_BGN?></td>
                                            <td style="text-align:right"><?php echo $TS_TRN_END?></td>
                                         </tr>
                                     <?php
									}	
                                
								?>
                        </table>
                    </td>
                </tr>
                <?php
				}
				?>
                <tr>
                    <td colspan="12" nowrap style="background-color:transparent">
                    <?php
                    if ($LINF>=$CTP+1) {
						$ATRAS=$LINF-$CTP;
						$FILA_ANT=$LSUP-$CTP;
                   ?>
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('reg_bolsas.php?LSUP=<?php echo $FILA_ANT?>&LINF=<?php echo $ATRAS?>&FTIENDA=<?php echo $FTIENDA?>&FTERM=<?php echo $FTERM?>&FOPERA=<?php echo $FOPERA?>&DIA_ED=<?php echo $DIA_ED ?>&MES_ED=<?php echo $MES_ED ?>&ANO_ED=<?php echo $ANO_ED ?>&DIA_EH=<?php echo $DIA_EH ?>&MES_EH=<?php echo $MES_EH ?>&ANO_EH=<?php echo $ANO_EH ?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('reg_bolsas.php?LSUP=<?php echo $FILA_POS?>&LINF=<?php echo $ADELANTE?>&FTIENDA=<?php echo $FTIENDA?>&FTERM=<?php echo $FTERM?>&FOPERA=<?php echo $FOPERA?>&DIA_ED=<?php echo $DIA_ED ?>&MES_ED=<?php echo $MES_ED ?>&ANO_ED=<?php echo $ANO_ED ?>&DIA_EH=<?php echo $DIA_EH ?>&MES_EH=<?php echo $MES_EH ?>&ANO_EH=<?php echo $ANO_EH ?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina <?php echo $NUMPAG?> de <?php echo $NUMTPAG?></span>
                    </td>
                </tr>
                </table>

                </td>
                </tr>
                </table>
        
        
        
        </td>
        </tr>
        </table>
</td>
</tr>
</table>
</body>
</html>
<?php
		//sqlsrv_close($arts_conn);
		sqlsrv_close( $arts_conn );
?>

