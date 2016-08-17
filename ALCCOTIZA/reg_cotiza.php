
<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1166;


	$LIST=@$_GET["LIST"];
	$NEO=@$_GET["NEO"];
	$ACT=@$_GET["ACT"];
	
	if ($NEO=="" and $ACT=="") {
		 $LIST=1;
	}

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
if ($MSJE==1) {$ELMSJ="Registro actualizado";} 
if ($MSJE <> "") {
?>
<div id="GMessaje" onClick="QuitarGMessage();"><a href="#" onClick="QuitarGMessage();" style="color:#111111;"><?=$ELMSJ?></a></div>
<?php }?>

    <table width="100%">
    <tr><td>
         <h2><?=$LAPAGINA?></h2>
        <?php if($LIST==1){ ?>
        <?php
			$BSC_COT=@$_POST["BSC_COT"];
			if (empty($BSC_COT)) { $BSC_COT=@$_GET["BSC_COT"] ;}
		
			$FILTRO_TIENDACOT="";
			$FTIENDACOT=@$_POST["FTIENDACOT"];
			if (empty($FTIENDACOT)) { $FTIENDACOT=@$_GET["FTIENDACOT"] ;}
			if (empty($FTIENDACOT)) { $FTIENDACOT=0 ;}
			if ($FTIENDACOT!=0) {
				$FILTRO_TIENDACOT=" AND COD_TIENDA=".$FTIENDACOT ;
			}

			$FILTRO_COT="";
			$B_NCOT=@$_POST["B_NCOT"];
			if (empty($B_NCOT)) { $B_NCOT=@$_GET["B_NCOT"] ;}
			if (!empty($B_NCOT)) {
				$FILTRO_COT=" AND ID_COT=".$B_NCOT ;
			}

			$FILTRO_CLTE="";
			$B_CLTE=@$_POST["B_CLTE"];
			if (empty($B_CLTE)) { $B_CLTE=@$_GET["B_CLTE"] ;}
			if (!empty($B_CLTE)) {
				$FILTRO_CLTE=" AND ID_COT IN(SELECT ID_COT FROM CO_COTCLTE WHERE COD_CLIENTE IN(SELECT COD_CLIENTE FROM CO_CLIENTE WHERE (UPPER(LTRIM(IDENTIFICACION)) Like '%".strtoupper($B_CLTE)."%') OR (UPPER(LTRIM(NOMBRE)) Like '%".strtoupper($B_CLTE)."%')  OR (UPPER(LTRIM(APELLIDO_P)) Like '%".strtoupper($B_CLTE)."%')  OR (UPPER(LTRIM(APELLIDO_M)) Like '%".strtoupper($B_CLTE)."%')  ))" ;
			}


			//CALCULAR MINIMO Y MÁXIMO FECHA REGISTRO COTIZACION
			$CONSULTA2="SELECT MIN(FECHA) AS MFECHA FROM IMP_COT";
			$RS2 = sqlsrv_query($conn, $CONSULTA2);
			//oci_execute($RS2);
			if ($row = sqlsrv_fetch_array($RS2)){
					$MIN_FECHA_EMS = $row['MFECHA'];
					$MIN_FECHA_EMS = date_format($MIN_FECHA_EMS,"d/m/Y");
			}
			$CONSULTA2="SELECT MAX(FECHA) AS MFECHA FROM IMP_COT";
			$RS2 = sqlsrv_query($conn, $CONSULTA2);
			//oci_execute($RS2);
			if ($row = sqlsrv_fetch_array($RS2)){
					$MAX_FECHA_EMS = $row['MFECHA'];
					$MAX_FECHA_EMS = date_format($MAX_FECHA_EMS,"d/m/Y");
			}
			if (empty($MIN_FECHA_EMS)) { $MIN_FECHA_EMS=date('d/m/Y'); }
			if (empty($MAX_FECHA_EMS)) { $MAX_FECHA_EMS=date('d/m/Y'); }
					
			//FECHA REGISTRO COTIZACION DESDE
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
			//CONSTRUYE FECHAS REGISTRO COTIZACION
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

			$F_FECHA=" WHERE Convert(varchar(20), FECHA, 111) >= Convert(varchar(20),'".$ANO_ED."/".$MES_ED."/".$DIA_ED."', 111) AND Convert(varchar(20), FECHA, 111) <= Convert(varchar(20),'".$ANO_EH."/".$MES_EH."/".$DIA_EH."', 111)"; 

		?>
                <table width="100%" id="Filtro">
                <tr>
                <td>
                <form action="reg_cotiza.php" method="post" name="frmbuscar" id="frmbuscar">
                      <label for="FECHA_EM_D">Desde </label>
                      <input name="DIA_ED" type="text" id="DIA_ED" value="<?=$DIA_ED ?>" size="2" maxlength="2" onKeyPress="return acceptNum(event);">
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
                       <input name="ANO_ED" type="text" id="ANO_ED" value="<?=$ANO_ED ?>" size="4" maxlength="4">
                      <label for="FECHA_EM_H">Hasta</label>
                      <input name="DIA_EH" type="text"  id="DIA_EH" value="<?=$DIA_EH ?>" size="2" maxlength="2" onKeyPress="return acceptNum(event);">
                      <select name="MES_EH" id="MES_EH">
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
                        <input name="ANO_EH" type="text" id="ANO_EH" value="<?=$ANO_EH ?>" size="4" maxlength="4" onKeyPress="return acceptNum(event);">
                        <select style="clear:left; "  name="FTIENDACOT" onChange="document.forms.frmbuscar.submit();">
                            <option value="0">Tienda</option>
                            <?php 
                            $SQLFILTRO="SELECT COD_TIENDA FROM IMP_COT  ".$F_FECHA." GROUP BY COD_TIENDA ORDER BY COD_TIENDA ASC";
                            $RSF = sqlsrv_query($conn, $SQLFILTRO);
                            //oci_execute($RSF);
                            while ($rowF = sqlsrv_fetch_array($RSF)) {
                                $FLTCOD_TIENDA = $rowF['COD_TIENDA'];
                                $S2="SELECT DES_CLAVE, DES_TIENDA FROM MN_TIENDA WHERE COD_TIENDA=".$FLTCOD_TIENDA;
                                $RS2 = sqlsrv_query($maestra, $S2);
                                //oci_execute($RS2);
                                if ($row2 = sqlsrv_fetch_array($RS2)) {
                                    $FLTDES_TIENDA = $row2['DES_TIENDA'];
                                    $FLTDES_CLAVE = $row2['DES_CLAVE'];
                                }
                                if (empty($FLTDES_TIENDA)){$FLTDES_TIENDA=$FLTCOD_TIENDA;}
                             ?>
                            <option value="<?=$FLTCOD_TIENDA ?>" <?php  if ($FLTCOD_TIENDA==$FTIENDACOT) { echo "SELECTED";}?>>L.<?=$FLTDES_CLAVE." - ".$FLTDES_TIENDA ?></option>
                            <?php 
                            }
                             ?>
                        </select>
                        <input style="text-align:right" name="B_CLTE" type="text"  id="B_CLTE" value="<?=$B_CLTE ?>" size="9" maxlength="18">
                       <input name="BSC_CLT" type="submit" id="BSC_CLT" value="Buscar Cliente">
                        <input style=" clear:left; text-align:right" name="B_NCOT" type="text"  id="B_NCOT" value="<?=$B_NCOT ?>" size="9" maxlength="9" onKeyPress="return acceptNum(event);">
                       <input name="BSC_COT" type="submit" id="BSC_COT" value="Buscar Cotizaci&oacute;n">
                       <input name="LIMPIAR" type="button" id="LIMPIAR" value="Limpiar" onClick="pagina('reg_cotiza.php');">
                </form>
              </td>
              </tr>
              </table>

            <table style="margin:10px 20px; ">
            <tr><td>
                <?php
				$CONSULTA="SELECT COUNT(ID_COT) AS CUENTA FROM IMP_COT ".$F_FECHA.$FILTRO_TIENDACOT.$FILTRO_COT.$FILTRO_CLTE."  AND ESTADO<>0 " ;

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
				//$SQLCLTE="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM IMP_COT ".$F_FECHA.$FILTRO_TIENDACOT.$FILTRO_COT.$FILTRO_CLTE." AND ESTADO<>0 ORDER BY ID_COT DESC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;
				
				//oci_execute($RS);
				  $SQLCLTE= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY ID_COT DESC) ROWNUMBER FROM IMP_COT ".$F_FECHA.$FILTRO_TIENDACOT.$FILTRO_COT.$FILTRO_CLTE." AND ESTADO<>0 ) AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";
				 

				  $RS = sqlsrv_query($conn, $SQLCLTE);
               ?>
                <table id="Listado">
                <tr>
                    <th>Cotizaci&oacute;n<br>Local</th>
                    <th>Nombre Cliente<br>Num. Identificaci&oacute;n</th>
                    <th>N&uacute;m.Items<br>Monto</th>
                    <th>Estado</th>
                    <th>Registrada por</th>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){
                        $ID_COT = $row['ID_COT'];
						$ID_COT_F = "000000000".$ID_COT;
						$ID_COT_F = substr($ID_COT_F, -9); 
                        $COD_TIENDA = $row['COD_TIENDA'];
                        $ID_WS = $row['ID_WS'];

							$SQL1="SELECT * FROM MN_TIENDA WHERE COD_TIENDA=".$COD_TIENDA;
							$RS1 = sqlsrv_query($maestra, $SQL1);
							//oci_execute($RS1);
							if ($row1 = sqlsrv_fetch_array($RS1)) {
								$DES_CLAVE = $row1['DES_CLAVE'];
								$DES_CLAVE_FSI="0000".$DES_CLAVE;
								$DES_CLAVE_FSI=substr($DES_CLAVE_FSI, -4); 
								$DES_TIENDA_FSI = $row1['DES_TIENDA'];
								$EL_LOCAL = "Tienda: ".$DES_CLAVE_FSI." - ".$DES_TIENDA_FSI;
							}
							//OBTENER ID_BSN_UN
							$SQL1="SELECT ID_BSN_UN FROM PA_STR_RTL WHERE CD_STR_RT=".$DES_CLAVE;
							$RS1 = sqlsrv_query($arts_conn, $SQL1);
							//oci_execute($RS1);
							if ($row1 = sqlsrv_fetch_array($RS1)) {
								$ID_BSN_UN = $row1['ID_BSN_UN'];
							}
						$SQL1="SELECT * FROM AS_WS WHERE ID_WS=".$ID_WS;
						
						$RS1 = sqlsrv_query($arts_conn, $SQL1);
						//oci_execute($RS1);
						if ($row1 = @sqlsrv_fetch_array($RS1)) {
							$EL_POS = $row1['CD_WS'];
						}
						$SQL1="SELECT * FROM IMP_COTART WHERE ID_COT=".$ID_COT;
						$RS1 = sqlsrv_query($conn, $SQL1);
						//oci_execute($RS1);
						$MO_COT=0;
						$NUM_ITEMS=0;
						while ($row1 = sqlsrv_fetch_array($RS1)) {
							$QT_ITM = $row1['QN_ITM'];
							$CD_ITM = $row1['CD_ITM'];
							$SQL2="SELECT ID_ITM FROM AS_ITM WHERE CD_ITM=".$CD_ITM;
							$RS2 = sqlsrv_query($arts_conn, $SQL2);
							//oci_execute($RS2);
							if ($row2 = sqlsrv_fetch_array($RS2)) {
								$ID_ITM = $row2['ID_ITM'];
							}
							$SQL2="SELECT SLS_PRC FROM AS_ITM_STR WHERE ID_BSN_UN=".$ID_BSN_UN." AND ID_ITM=".$ID_ITM;
							$RS2 = sqlsrv_query($arts_conn, $SQL2);
							//oci_execute($RS2);
							if ($row2 = sqlsrv_fetch_array($RS2)) {
								$SLS_PRC = $row2['SLS_PRC'];
							}
							$TOT_ITM = $SLS_PRC*$QT_ITM;
							$MO_COT=$MO_COT+$TOT_ITM;
							$NUM_ITEMS=$NUM_ITEMS+1;
						}
						$MO_COT_F = $MO_COT/$DIVCENTS;
						$MO_COT_F = number_format($MO_COT_F, $CENTS, $GLBSDEC, $GLBSMIL);
						$NUM_ITEMS = number_format($NUM_ITEMS, 0, $GLBSDEC, $GLBSMIL);
						$S2="SELECT COD_CLIENTE FROM CO_COTCLTE WHERE ID_COT=".$ID_COT;
						$RS2 = sqlsrv_query($conn, $S2);
					  //oci_execute($RS2);
						if ($row2 = sqlsrv_fetch_array($RS2)) {
							$COD_CLIENTE = $row2['COD_CLIENTE'];
						}	
						$S2="SELECT * FROM CO_CLIENTE WHERE COD_CLIENTE=".$COD_CLIENTE;
						$RS2 = sqlsrv_query($conn, $S2);
						//oci_execute($RS2);
						$TIPOID="";
						if ($row2 = sqlsrv_fetch_array($RS2)) {
							$TIPOID = $row2['TIPOID'];
							$IDENTIFICACION = $row2['IDENTIFICACION'];
							$NOMBRE = $row2['NOMBRE'];
							$APELLIDO_P = $row2['APELLIDO_P'];
							$APELLIDO_M = $row2['APELLIDO_M'];
						}	
						if($TIPOID==1){
								$NOMBRE=$NOMBRE." ".$APELLIDO_P." ".$APELLIDO_M;
						}
						
                        $ESTADO = $row['ESTADO'];
						if($ESTADO==1){
							$ELESTADO="Cotizaci&oacute;n<br>Registrada";
						}
						if($ESTADO==2){
							$ELESTADO="Registra<br>Transacci&oacute;n<br>en POS ".@$EL_POS;
						}

                        $IDREG = $row['IDREG'];
                        $FECHA = $row['FECHA'];
                        $FECHA_ACT = $row['FECHA_ACT'];
						$S2="SELECT NOMBRE FROM US_USUARIOS WHERE IDUSU=".$IDREG;
						$RS2 = sqlsrv_query($maestra, $S2);
						//oci_execute($RS2);
						if ($row2 = sqlsrv_fetch_array($RS2)) {
							$QUIENFUE = $row2['NOMBRE'];
						}	

               ?>
                <tr>
                    <?php if($SESPUBLICA==1) { ?>
                    <td><a href="reg_cotiza.php?ACT=<?=$ID_COT?>">
					<?=$ID_COT_F?></a><BR><?=$EL_LOCAL?></td>
                    <?php } else {?>
                     <td><?=$ID_COT_F?><br><?=$EL_LOCAL?> - <?=$EL_POS?></td>
                    <?php } ?>
                    <td><?=$NOMBRE?><br><?=$IDENTIFICACION?></td>
                    <td><?=$NUM_ITEMS." Items<br>".$MONEDA.$MO_COT_F?></td>
                    <td style="text-align:left"><?=$ELESTADO?></td>
                    <td><?=$QUIENFUE."<BR>Registrado el:".date_format($FECHA,"d/m/Y")."<BR>Actualizado al:".date_format($FECHA_ACT,"d/m/Y")?></td>
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
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('reg_cotiza.php?LSUP=<?=$FILA_ANT?>&LINF=<?=$ATRAS?>&DIA_ED=<?php echo $DIA_ED ?>&MES_ED=<?php echo $MES_ED ?>&ANO_ED=<?php echo $ANO_ED ?>&DIA_EH=<?php echo $DIA_EH ?>&MES_EH=<?php echo $MES_EH ?>&ANO_EH=<?php echo $ANO_EH ?>&B_NCOT=<?php echo $B_NCOT ?>&FTIENDACOT=<?php echo $FTIENDACOT ?>&B_CLTE=<?php echo $B_CLTE ?>&BSC_COT=<?php echo $BSC_COT ?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('reg_cotiza.php?LSUP=<?=$FILA_POS?>&LINF=<?=$ADELANTE?>&DIA_ED=<?php echo $DIA_ED ?>&MES_ED=<?php echo $MES_ED ?>&ANO_ED=<?php echo $ANO_ED ?>&DIA_EH=<?php echo $DIA_EH ?>&MES_EH=<?php echo $MES_EH ?>&ANO_EH=<?php echo $ANO_EH ?>&B_NCOT=<?php echo $B_NCOT ?>&FTIENDACOT=<?php echo $FTIENDACOT ?>&B_CLTE=<?php echo $B_CLTE ?>&BSC_COT=<?php echo $BSC_COT ?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina <?=$NUMPAG?> de <?=$NUMTPAG?></span>
                    </td>
                </tr>
                </table>
<?php
		sqlsrv_close($conn);
		sqlsrv_close($maestra);
		sqlsrv_close($arts_conn);
?>
            
            </td></tr>
            </table>



        <?php } //if($LIST==1){ ?>




        <?php
		if($NEO==1){
				$ID_ITM=@$_GET["ID_ITM"];
				$ID_ITM_PS=@$_GET["ID_ITM_PS"];
	
				$ID_BSN_UN=@$_GET["ID_BSN_UN"];
				$CD_STR_RT_F=@$_GET["CD_STR_RT_F"];
				$CD_ITM_SI=@$_GET["CD_ITM_SEL"];
				if(empty($CD_ITM_SI)) { $CD_ITM_SI=@$_POST["CD_ITM"];}
				if(!empty($ID_ITM_PS)) { $CD_ITM_SI=$ID_ITM_PS;}

				$REGCOTTMP=@$_POST["REGCOTTMP"];
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
				
				//VERIFICA SI USUARIO YA TIENE REGISTRO EN IMP_COT CON ESTADO=0
				$SQL="SELECT * FROM IMP_COT WHERE IDREG=".$SESIDUSU." AND ESTADO=0";
				$RS = sqlsrv_query($conn, $SQL);
				//oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {
					$ID_COT = $row['ID_COT'];
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
					$SQL="DELETE FROM IMP_COTART WHERE ID_COTITM=".$ELMART;
					$RS = sqlsrv_query($conn, $SQL);
					//oci_execute($RS);
				}


		?>
                <table style="margin:10px 20px; ">
                <tr><td>
                
                <h3>Seleccionar Art&iacute;culo(s) para Cotizaci&oacute;n</h3>
                <table id="forma-registro">
                <form action="reg_cotiza.php?NEO=1" method="post" name="forming">
                <tr>
                		<td style="vertical-align:top">
                            <label for="COD_TIENDA">Tienda</label>
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
                                	<h5><?=$ELNEGOCIO."<BR>".$LATIENDA ?></h5>
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
													<h5><?=$ELNEGOCIO."<BR>".$LATIENDA ?></h5>
													<input type="hidden" name="COD_NEGOCIO" value="<?=$COD_NEGOCIO_SEL?>">
													<input type="hidden" name="COD_TIENDA" value="<?=$COD_TIENDA_SEL?>">
												<?php
											} else {
												?>
													<select style="display:block; clear:both" name="COD_NEGOCIO" onChange="CargaTiendaSelect(this.value, this.form.name, 'COD_TIENDA', <?=$SESIDUSU?>)">
																<option value="0">SELECCIONAR NEGOCIO</option>
																<?php 
																$SQL="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO IN(SELECT COD_NEGOCIO FROM US_USUTND WHERE IDUSU=".$SESIDUSU.") ORDER BY DES_NEGOCIO ASC";
																$RS = sqlsrv_query($maestra, $SQL);
																//oci_execute($RS);
																while ($row = sqlsrv_fetch_array($RS)) {
																	$COD_NEGOCIO = $row['COD_NEGOCIO'];
																	$DES_NEGOCIO = $row['DES_NEGOCIO'];
																 ?>
																<option value="<?=$COD_NEGOCIO ?>" <?php if($COD_NEGOCIO==$COD_NEGOCIO_SEL) {echo "Selected";} ?>><?=$DES_NEGOCIO ?></option>
																<?php 
																}
																 ?>
												</select>
												<select style="display:block; clear:both"  id="COD_TIENDA" name="COD_TIENDA" onChange="document.forms.forming.submit();">
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
                                                                    <option value="<?=$STRCOD ?>" <?php if($STRCOD==$COD_TIENDA_SEL) {echo "Selected";} ?>><?=$NUM_TIENDA_F." - ".$STRDES ?></option>
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
													<h5><?=$ELNEGOCIO."<BR>".$LATIENDA ?></h5>
													<input type="hidden" name="COD_NEGOCIO" value="<?=$COD_NEGOCIO_SEL?>">
													<input type="hidden" name="COD_TIENDA" value="<?=$COD_TIENDA_SEL?>">
												<?php
											} else {
											 ?>
													<select style="display:block; clear:both" name="COD_TIENDA" onChange="document.forms.forming.submit();">
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
                                                                            <option value="<?=$COD_TIENDA ?>"  <?php if($COD_TIENDA==$COD_TIENDA_SEL) {echo "Selected";} ?>><?=$LATIENDA ?></option>
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
                                        	<input type="hidden" name="COD_NEGOCIO" value="<?=$COD_NEGOCIO_TND?>">
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
													<h5><?=$ELNEGOCIO."<BR>".$LATIENDA ?></h5>
													<input type="hidden" name="COD_NEGOCIO" value="<?=$COD_NEGOCIO_SEL?>">
													<input type="hidden" name="COD_TIENDA" value="<?=$COD_TIENDA_SEL?>">
										<?php
									} else {
										?>
													<select style="display:block; clear:both" name="COD_NEGOCIO" onChange="CargaTiendaSelectE(this.value, this.form.name, 'COD_TIENDA')">
																<option value="0">SELECCIONAR NEGOCIO</option>
																<?php 
																$SQL="SELECT * FROM MN_NEGOCIO ORDER BY DES_NEGOCIO ASC";
																$RS = sqlsrv_query($maestra, $SQL);
																//oci_execute($RS);
																while ($row = sqlsrv_fetch_array($RS)) {
																	$COD_NEGOCIO = $row['COD_NEGOCIO'];
																	$DES_NEGOCIO = $row['DES_NEGOCIO'];
																 ?>
																<option value="<?=$COD_NEGOCIO ?>" <?php if($COD_NEGOCIO==$COD_NEGOCIO_SEL) {echo "Selected";} ?>><?=$DES_NEGOCIO ?></option>
																<?php 
																}
																 ?>
												</select>
												<select style="display:block; clear:both"  id="COD_TIENDA" name="COD_TIENDA" onChange="document.forms.forming.submit();">
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
                                                                        <option value="<?=$STRCOD ?>" <?php if($STRCOD==$COD_TIENDA_SEL) {echo "Selected";} ?> ><?=$NUM_TIENDA_F." - ".$STRDES ?></option>
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
						if(!empty($COD_TIENDA_SEL)){
				?>
                <tr>
                   <td>
                            <label for="CD_ITM">C&oacute;digo Art&iacute;culo</label>
                   </td>
                   <td>
                   			<input name="CD_ITM" type="text"  id="CD_ITM" size="15" maxlength="15" value="<?php if(empty($REGCOTTMP)){ echo $CD_ITM_SI;}?>" onKeyPress="return acceptNum(event);"  onChange="document.forms.forming.submit();">
                            <input name="BUSCARARTICULO" type="button" value="Buscar" onClick="ActivarSearchItem()">
                   </td>
                </tr>
                <?php
						}
				if(!empty($CD_ITM_SI) && empty($REGCOTTMP)){
						//COMPROBAR Y DESPLEGAR NOMBRE DE ARTÍCULO
						$NOENCONTRADO=0;
						
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
                                      <label style="text-align:left; font-weight:300; font-size:12pt; margin:0; padding:0" for="ITEM"><?=$NM_ITM?></label>
                                      <label style="text-align:left; font-weight:400; font-size:16pt; margin:0; padding:0" for="ITEM"><?=$MONEDA.$PREC_ITM?></label>
                                      <label style="text-align:left; font-weight:600; font-size:9pt; margin:0; padding:0" for="ITEM"><?="C&oacute;digo EAN ".$CODIGO_EAN?></label>
                               </td>
                            </tr>
                            <?php
						} else {
							//ITEM NO EXISTE
							?>
                            <tr>
                               <td style="background-color:#FFC"></td>
                               <td style="background-color:#FFC">
                                      <label style="color:#C00" for="ITEM">Atenci&oacute;n: C&oacute;digo de Art&iacute;culo no disponible, verifique</label>
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
                <?php if(@$NOENCONTRADO==0 && !empty($CD_ITM_SI)){ ?>

					<script language="JavaScript">
                    function validaItem(theForm){
                        
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
                    
                    } //validaItem(theForm)
                    </script>

                <form action="reg_cotiza.php?NEO=1" method="post" name="formflj" onSubmit="return validaItem(this)">
                <tr>
                   <td>
                            <label for="QN_ITM">Cantidad Items</label>
                   </td>
                   <td>
                   			<input style="text-align:right" name="QN_ITM" type="text"  id="QN_ITM" size="4" maxlength="4"  onKeyPress="return acceptNum(event);">
                   			<input type="submit" name="REG_ITM" value="Agregar">
                   			<input type="hidden" name="ES_EAN" value="<?=$ES_EAN?>">
                   			<input type="hidden" name="CD_ITM" value="<?=$CD_ITM_SI?>">
                   			<input type="hidden" name="COD_NEGOCIO" value="<?=$COD_NEGOCIO_SEL?>">
                   			<input type="hidden" name="COD_TIENDA" value="<?=$COD_TIENDA_SEL?>">
                   			<input type="hidden" name="REGCOTTMP" value="1">
                   </td>
                </tr>
                </form>
                <?php }// if($NOENCONTRADO==0){ ?>
                
                
                <?php
				//PRE-REGISTRO DE ITEMS...
				$QN_ITM=@$_POST["QN_ITM"];
				if($REGCOTTMP==1){
					if($REGISTRAR == 1){

						$SQL2="SELECT IDENT_CURRENT('IMP_COT') AS MID_COT";
						$RS2 = sqlsrv_query($conn, $SQL2);
						//oci_execute($RS2);
						if ($row2 = sqlsrv_fetch_array($RS2)) {
								$ID_COT=$row2['MID_COT']+1;
						} else {
								$ID_COT=1;
						}
							$SQL="INSERT INTO IMP_COT (COD_TIENDA, COD_NEGOCIO, IDREG) ";
							$SQL=$SQL." VALUES (".$COD_TIENDA_SEL.", ".$COD_NEGOCIO_SEL.", ".$SESIDUSU.")";
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
								$SQLIT="SELECT * FROM AS_ITM WHERE ID_ITM=".$ID_ITM_TR;
								$RSI = sqlsrv_query($arts_conn, $SQLIT);
								//oci_execute($RSI);
								if ($rowi = sqlsrv_fetch_array($RSI)) {
									$CD_ITM_SI = $rowi['CD_ITM'];
									$FL_WM_RQ = $rowi['FL_WM_RQ'];
								}
						} else {
								$SQLIT="SELECT * FROM AS_ITM WHERE CD_ITM=".$CD_ITM_SI;
								$RSI = sqlsrv_query($arts_conn, $SQLIT);
								//oci_execute($RSI);
								if ($rowi = sqlsrv_fetch_array($RSI)) {
									$FL_WM_RQ = $rowi['FL_WM_RQ'];
								}
						}
						//IDENTIFICAR PESABLES
						if($FL_WM_RQ==1){
							$TY_ITM="P";
						} else {
							$TY_ITM="U";
						}
					//VERIFICAR SI ITEM YA ESTABA INGRESADO
							$SQL2="SELECT * FROM IMP_COTART WHERE ID_COT=".$ID_COT." AND CD_ITM=".$CD_ITM_SI;
							$RS2 = sqlsrv_query($conn, $SQL2);
							//oci_execute($RS2);
							if ($row2 = sqlsrv_fetch_array($RS2)) {
								$QN_ITM_PR=$row2['QN_ITM']+$QN_ITM;
								$SQL="UPDATE IMP_COTART SET QN_ITM=".$QN_ITM_PR." WHERE ID_COT=".$ID_COT." AND CD_ITM=".$CD_ITM_SI;
								$RS = sqlsrv_query($conn, $SQL);
								//oci_execute($RS);
							} else {
								$SQL="INSERT INTO IMP_COTART (ID_COT, CD_ITM, QN_ITM, TY_ITM) ";
								$SQL=$SQL." VALUES (".$ID_COT.", ".$CD_ITM_SI.", ".$QN_ITM.", '".$TY_ITM."')";
								$RS = sqlsrv_query($conn, $SQL);
								//oci_execute($RS);
							}
					
					
				}
				//LISTADO DE ITEMS SELECCIONADOS
				$SQLF="SELECT * FROM IMP_COT WHERE ID_COT=".@$ID_COT." AND ID_COT IN(SELECT ID_COT FROM IMP_COTART)";
				$RSF = sqlsrv_query($conn, $SQLF);
				//oci_execute($RSF);
				if ($rowF = @sqlsrv_fetch_array($RSF)) {
				?>
                	<tr>
                    	<td colspan="2">
                        <h3>Art&iacute;culos Seleccionados para Cotizaci&oacute;n</h3>
                        		<table id="Listado">
                                    <tr>
                                        <th>Item</th>
                                        <th>C&oacute;d.Art.</th>
                                        <th>Art&iacute;culo</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Total</th>
                                        <th></th>
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
                                    	<td style="text-align:right"><?=$CONTADOR;?></td>
                                    	<td style="text-align:right"><?=$CODE_EAN;?></td>
                                    	<td><?=$NM_ITM;?></td>
                                    	<td style="text-align:right"><?=$MONEDA.$PREC_ITM;?></td>
                                    	<td style="text-align:right"><?=$QN_ITM;?></td>
                                    	<td style="text-align:right"><?=$MONEDA.$TOT_ITM_F;?></td>
                                    	<td class="FormCelda"><input class="BotonCelda" type="button" value="Quitar" onClick="pagina('reg_cotiza.php?NEO=1&ELMART=<?=$ID_COTITM?>&COD_NEGOCIO=<?=$COD_NEGOCIO_SEL?>&COD_TIENDA=<?=$COD_TIENDA_SEL?>&COD_FTIPO=<?=$COD_FTIPO_SEL?>');"></td>
                                    </tr>
                                    <?php
										$CONTADOR=$CONTADOR+1;
									} //LISTADO DE ARTICULOS
								   ?>
                                    <tr style="background-color:#7A2A9C ">
                                        <td colspan="5" style="text-align:right; color:#FFF; font-size:12pt; font-weight:300">Total Cotizaci&oacute;n</td>
                                        <td colspan="2" style="text-align:right; color:#FFF; font-size:12pt; font-weight:300">
                                            <?php
                                                $TOT_COT_F = $TOT_COT/$DIVCENTS;
                                                $TOT_COT_F = number_format($TOT_COT_F, $CENTS, $GLBSDEC, $GLBSMIL);
                                            ?>
                                            <?=$MONEDA.$TOT_COT_F?>
                                        </td>
                                    </tr>
                                    <!-- DATA CLIENTE -->
									<script language="JavaScript">
                                    function ValidaCotizacion(theForm){
                                        
                                            if (theForm.IDENTIFICACION.value == ""){
                                                alert("COMPLETE EL CAMPO REQUERIDO.");
                                                theForm.IDENTIFICACION.focus();
                                                return false;
                                            }
											
                                            if (theForm.TIPOID.value == 0){
                                                    alert("COMPLETE EL CAMPO REQUERIDO.");
                                                    theForm.TIPOID.focus();
                                                    return false;
                                            } else {
                                                    var TipoIDForm = theForm.TIPOID.value;
                                            }
											
                                            if(TipoIDForm==1){
                                                            if (theForm.NOMBRE_P1.value == ""){
                                                                alert("COMPLETE EL CAMPO REQUERIDO.");
                                                                theForm.NOMBRE_P1.focus();
                                                                return false;
                                                            }
                                                            if (theForm.APELLIDO_P.value == ""){
                                                                alert("COMPLETE EL CAMPO REQUERIDO.");
                                                                theForm.APELLIDO_P.focus();
                                                                return false;
                                                            }
                                                            if (theForm.APELLIDO_M.value == ""){
                                                                alert("COMPLETE EL CAMPO REQUERIDO.");
                                                                theForm.APELLIDO_M.focus();
                                                                return false;
                                                            }
                                                            if (theForm.GENERO.value == ""){
                                                                alert("COMPLETE EL CAMPO REQUERIDO.");
                                                                theForm.GENERO.focus();
                                                                return false;
                                                            }
                                                            if (theForm.DIA_NAC.value == ""){
                                                                alert("COMPLETE EL CAMPO REQUERIDO.");
                                                                theForm.DIA_NAC.focus();
                                                                return false;
                                                            }
                                                            
                                                            if (theForm.ANO_NAC.value == ""){
                                                                alert("COMPLETE EL CAMPO REQUERIDO.");
                                                                theForm.ANO_NAC.focus();
                                                                return false;
                                                            }
                                                            
                                                            if (!ValidarFecha(theForm.DIA_NAC.value+"-"+theForm.MES_NAC.value+"-"+theForm.ANO_NAC.value)){
                                                                alert("FECHA NO VALIDA.");
                                                                theForm.DIA_NAC.focus();
                                                                return false;
                                                                }
                                                        
                                                            if (!CalcularEdad(theForm.DIA_NAC.value, theForm.MES_NAC.value, theForm.ANO_NAC.value)){
                                                                alert("CONFIRME LA FECHA DE NACIMIENTO, LA EDAD DEBE SER ENTRE LOS 18 Y LOS 99 A\xd1OS.");
                                                                theForm.ANO_NAC.focus();
                                                                return false;
                                                                }
                                                            
                                            } else {
                                                            if (theForm.NOMBRE_P2.value == ""){
                                                                alert("COMPLETE EL CAMPO REQUERIDO.");
                                                                theForm.NOMBRE_P2.focus();
                                                                return false;
                                                            }
                                            }
                                            if (theForm.DIRECCION.value == ""){
                                                alert("COMPLETE EL CAMPO REQUERIDO.");
                                                theForm.DIRECCION.focus();
                                                return false;
                                            }
                                            if (theForm.COD_CIUDAD.value == 1){
                                                alert("COMPLETE EL CAMPO REQUERIDO.");
                                                theForm.COD_CIUDAD.focus();
                                                return false;
                                            }
                                
                                    
                                            if (theForm.REGCOTIZA.value != ""){
                                    
                                                var aceptaEntrar = window.confirm("Se ejecutar\xe1 el registro, \xbfest\xe1 seguro?");
                                                    if (aceptaEntrar) 
                                                    {
                                                        document.forms.theForm.submit();
                                                    }  else  
                                                    {
                                                        return false;
                                                    }
                                        }
                                    } //ValidaCotizacion(theForm)
                                    </script>
                                    <?php
											$IDENCLTE=@$_POST["IDENCLTE"];
                                    ?>
                                    <form action="reg_cotiza.php?NEO=1" method="post" name="frmclte" id="frmclte">                        
                                    <tr style="background: #F7F7F7;">
                                        <td colspan="4" style="text-align:right">N&uacute;mero Identificaci&oacute;n Cliente</td>
                                        <td colspan="3">
                                                <!-- VERIFICAR SI HAY REGISTRO PREVIO -->
                                                <input name="IDENCLTE" type="text" size="20" maxlength="50"  onKeyPress="return acceptNumK(event);" onChange="document.forms.frmclte.submit();" value="<?=$IDENCLTE;?>">
                                        </td>
                                    </tr>
                                    </form>
                                    <?php
										if(!empty($IDENCLTE)){
												$SQL="SELECT * FROM CO_CLIENTE WHERE IDENTIFICACION='".$IDENCLTE."' ";
												$RS = sqlsrv_query($conn, $SQL);
												//oci_execute($RS);
												if ($row = sqlsrv_fetch_array($RS)) {
													$COD_CLIENTE = $row['COD_CLIENTE'];
													$NOMBRE = $row['NOMBRE'];
													$APELLIDO_P = $row['APELLIDO_P'];
													$APELLIDO_M = $row['APELLIDO_M'];
													$GENERO = $row['GENERO'];
													$FEC_NACIMIENTO = $row['FEC_NACIMIENTO'];
													$FEC_NACIMIENTO = strtotime($FEC_NACIMIENTO);
															$ANO_NAC = date("Y", $FEC_NACIMIENTO); 
															$MES_NAC = date("m", $FEC_NACIMIENTO); 
															$DIA_NAC = date("d", $FEC_NACIMIENTO); 

													$DIRECCION = $row['DIRECCION'];
													$COD_REGION = $row['COD_REGION'];
													$COD_CIUDAD = $row['COD_CIUDAD'];
													$TELEFONO = $row['TELEFONO'];
													$EMAIL = $row['EMAIL'];
													$TIPOID = $row['TIPOID'];
												}
										}
                                    ?>
                                    
                                    <form action="reg_cotiza_reg.php" method="post" name="frmreg" id="frmreg" onSubmit="return ValidaCotizacion(this)">                        
                                    <tr style="background: #F7F7F7;">
                                        <td colspan="4" style="text-align:right">Tipo de Identificaci&oacute;n Cliente
                                       <input name="ID_COT" type="hidden" value="<?=$ID_COT?>">
                                       <input name="IDENTIFICACION" type="hidden" value="<?=$IDENCLTE?>">
                                       </td>
                                       <td colspan="3">
                                       <select name="TIPOID" onChange="<?php if($GLBDPTREG==1){?>ActivarClienteRegionSi(this.value);<?php } else {?>ActivarClienteRegionNo(this.value);<?php }?>">
                                        <option value="0">SELECCIONAR</option>
                                                <option value="1" >Persona Natural</option>
                                                <option value="2" >Persona Jur&iacute;dica</option>
                                        </select>
                                    </td>
                                    </tr>
                                    <tr id="NOMB_TIPOID1" style="background: #F7F7F7;display:none">
                                        <td colspan="4" style="text-align:right">Nombres</td>
                                        <td colspan="3" style="background-color:#F4F4F4"><input name="NOMBRE_P1" type="text" size="20" maxlength="75"  value="<?= @$NOMBRE?>"> </td>
                                    </tr>
                                    <tr id="APPP_TIPOID1" style="background: #F7F7F7;display:none">
                                        <td colspan="4" style="text-align:right">Apellido Paterno</td>
                                        <td colspan="3" style="background-color:#F4F4F4"><input name="APELLIDO_P" type="text" size="20" maxlength="50"  value="<?= @$APELLIDO_P?>"> </td>
                                    </tr>
                                    <tr id="APPM_TIPOID1" style="background: #F7F7F7;display:none">
                                        <td colspan="4" style="text-align:right">Apellido Materno</td>
                                        <td colspan="3" style="background-color:#F4F4F4"><input name="APELLIDO_M" type="text" size="20" maxlength="50" value="<?= @$APELLIDO_M?>"> </td>
                                    </tr>
                                    <tr id="NOMB_TIPOID2" style="background: #F7F7F7;display:none">
                                        <td colspan="4" style="text-align:right">Raz&oacute;n Social</td>
                                        <td colspan="3" style="background-color:#F4F4F4"><input name="NOMBRE_P2" type="text" size="20" maxlength="75" value="<?= @$NOMBRE?>"> </td>
                                    </tr>
                                    <tr id="GENDER_TIPOID1" style="background: #F7F7F7;display:none">
                                       <td colspan="4" style="text-align:right">G&eacute;nero </td>
                                       <td colspan="3"><select name="GENERO">
                                        <option value="">SELECCIONAR</option>
                                        <option value="M" <?php if(@$GENERO=="M"){ echo "Selected";}?>>MASCULINO</option>
                                        <option value="F"  <?php if(@$GENERO=="F"){ echo "Selected";}?>>FEMENINO</option>
                                        </select>
                                    </td>
                                    </tr>
                                    <tr id="FECNAC_TIPOID1" style="background: #F7F7F7;display:none">
                                        <td colspan="4" style="text-align:right">Fecha Nacimiento<BR>(d&iacute;a-mes-a&ntilde;o)</td>
                                        <td colspan="3">
                                                <input style="float:left; display:inline; margin:6px 0 0 6px" name="DIA_NAC" type="text"  id="DIA_NAC" size="1" maxlength="2" onKeyPress="return acceptNum(event);" value="<?php if(isset($DIA_NAC)){echo $DIA_NAC;}?>">
                                                <select style="float:left; display:inline; margin:6px 2px 0 2px"  name="MES_NAC"  id="MES_NAC">
                                                        <option value="1" <?php if(isset($MES_NAC) and $MES_NAC==1){echo "Selected";}?>>Enero</option>
                                                        <option value="2" <?php if(isset($MES_NAC) and $MES_NAC==2){echo "Selected";}?>>Febrero</option>
                                                        <option value="3" <?php if(isset($MES_NAC) and $MES_NAC==3){echo "Selected";}?>>Marzo</option>
                                                        <option value="4" <?php if(isset($MES_NAC) and $MES_NAC==4){echo "Selected";}?>>Abril</option>
                                                        <option value="5" <?php if(isset($MES_NAC) and $MES_NAC==5){echo "Selected";}?>>Mayo</option>
                                                        <option value="6" <?php if(isset($MES_NAC) and $MES_NAC==6){echo "Selected";}?>>Junio</option>
                                                        <option value="7" <?php if(isset($MES_NAC) and $MES_NAC==7){echo "Selected";}?>>Julio</option>
                                                        <option value="8" <?php if(isset($MES_NAC) and $MES_NAC==8){echo "Selected";}?>>Agosto</option>
                                                        <option value="9" <?php if(isset($MES_NAC) and $MES_NAC==9){echo "Selected";}?>>Septiembre</option>
                                                        <option value="10" <?php if(isset($MES_NAC) and $MES_NAC==10){echo "Selected";}?>>Octubre</option>
                                                        <option value="11" <?php if(isset($MES_NAC) and $MES_NAC==11){echo "Selected";}?>>Noviembre</option>
                                                        <option value="12" <?php if(isset($MES_NAC) and $MES_NAC==12){echo "Selected";}?>>Diciembre</option>
                                                </select>
                                                <input style="float:left; display:inline; margin:6px 0 0 0"  name="ANO_NAC" type="text"  id="ANO_NAC"  size="2" maxlength="4"  onKeyPress="return acceptNum(event);"  value="<?=@$ANO_NAC?>">
                                        </td>
                                    </tr>
                                    <tr id="DIRECC" style="background: #F7F7F7;display:none">
                                        <td colspan="4" style="text-align:right">Direcci&oacute;n</td>
                                        <td colspan="3"><input name="DIRECCION" type="text" size="20" maxlength="200"  value="<?= @$DIRECCION?>"> </td>
                                    </tr>
                                    

								 <?php if($GLBDPTREG==1){?>
                                <tr id="REGION" style="background: #F7F7F7;display:none">
                                    <td colspan="4" style="text-align:right"><?=$GLBDESCDPTREG?></td>
                                    <td colspan="3"><select name="COD_REGION"  onChange="CargaCiudad(this.value, this.form.name, 'COD_CIUDAD', <?=@$GLBCODPAIS?>)">
                                                        <option value="0"><?=$GLBDESCDPTREG?></option>
                                                        <?php 
                                                        $SQL="SELECT * FROM PM_REGION WHERE COD_PAIS=".$GLBCODPAIS." ORDER BY DES_REGION ASC";
                                                        $RS = sqlsrv_query($maestra, $SQL);
                                                        //oci_execute($RS);
                                                        while ($row = sqlsrv_fetch_array($RS)) {
                                                            $COD_REGION2 = $row['COD_REGION'];
                                                            $DES_REGION = $row['DES_REGION'];
                                                         ?>
                                                        <option value="<?=@$COD_REGION2;?>" <?php if(isset($COD_REGION) and $COD_REGION2==$COD_REGION){echo "SELECTED";}?>><?=$DES_REGION ?></option>
                                                        <?php 
                                                        }
                                                         ?>
                                        </select></td>
                                </tr>
                                 <?php } else {?><input type="hidden" name="COD_REGION" value="0"><?php }//$GLBDPTREG?>
                                <tr id="CIUDAD" style="background: #F7F7F7;display:none">
                                  <td colspan="4" style="text-align:right">Ciudad</td>
                                   <td colspan="3"><select id="COD_CIUDAD" name="COD_CIUDAD">
                                    <option value="0">Ciudad</option>
                                            <?php
                                                if($GLBDPTREG==1){
                                                        $S1="SELECT * FROM PM_CIUDAD WHERE COD_PAIS=".$GLBCODPAIS." AND COD_REGION=".$COD_REGION." ORDER BY DES_CIUDAD ASC";
                                                } else {
                                                        $S1="SELECT * FROM PM_CIUDAD WHERE COD_PAIS=".$GLBCODPAIS." ORDER BY DES_CIUDAD ASC";
                                                }
                                                $RS1 = sqlsrv_query($maestra, $S1);
                                                //oci_execute($RS1);
                                                while ($row = sqlsrv_fetch_array($RS1)) {
                                                    $COD_CIUDAD2 = $row['COD_CIUDAD'];
                                                    $DES_CIUDAD = $row['DES_CIUDAD'];
                                            ?>
                                            <option value="<?=@$COD_CIUDAD2?>" <?php if($COD_CIUDAD2==$COD_CIUDAD){echo "SELECTED";}?>><?=$DES_CIUDAD?></option>
                                            <?php
                                                }
                                            ?>
                                    </select></td>
                                </tr>

                                    
                                    <tr id="TELEFONO" style="background: #F7F7F7;display:none">
                                        <td colspan="4" style="text-align:right">Tel&eacute;fono</td>
                                        <td colspan="3"><input name="TELEFONO" type="text" size="20" maxlength="50" value="<?=@$TELEFONO?>"> </td>
                                    </tr>
                                    <tr id="CORREO" style="background: #F7F7F7;display:none">
                                        <td colspan="4" style="text-align:right">Correo Electr&oacute;nico</td>
                                        <td colspan="3">
                                            <input name="EMAIL" type="text" size="20" maxlength="200" style=" text-transform:lowercase; " value="<?=@$EMAIL?>">
                                        </td>
                                    </tr>
                                    <!-- FIN DATA CLIENTE -->
                                    <tr>
                                        <td colspan="3" style="text-align:left"><input type="button" name="ELMARCHIVO" value="Salir sin registrar" onClick="PaginaSalir('reg_cotiza_reg.php?ELMCOTIZA=<?=$ID_COT;?>');"> </td>
                                        <td colspan="4" style="text-align:right"><input type="submit" name="REGCOTIZA" value="Registrar Cotizaci&oacute;n" ></td>
                                    </tr>
                                    </form>
                                </table>
                        </td>
                    </tr>
				<?php
				}//$REGISTRAR==1
				?>
                </table>
                
                </td></tr>
                </table>
				<?php include("SearchItem.php");?>
				
                <?php if($VENTANA!=1){ ?>
							<script>
                                if (document.forming.CD_ITM.value == ""){
                                    document.forming.CD_ITM.focus();
                                } else {
                                    document.formflj.QN_ITM.focus();
                                }
                            </script>
                <?php } else { ?>
                            <script>
                                    document.frmbuscar.BITEM.focus();
                            </script>
                <?php } ?>

        
        <?php } //NEO=1?>



        <?php
		if($ACT!=""){
				$ID_COT = $ACT;
				$ID_COT_F = "000000000".$ID_COT;
				$ID_COT_F = substr($ID_COT_F, -9); 
				$SQL="UPDATE IMP_COT SET FECHA_ACT=convert(datetime,GETDATE(), 121) WHERE ID_COT=".$ID_COT;
				$RS = sqlsrv_query($conn, $SQL);
				//oci_execute($RS);

			//REGISTRA POS
				$TERMPOS_SEL=@$_POST["TERMPOS"];
				if(!empty($TERMPOS_SEL)){
						$SQL="UPDATE IMP_COT SET ID_WS=".$TERMPOS_SEL." WHERE ID_COT=".$ID_COT;
						$RS = sqlsrv_query($conn, $SQL);
						//oci_execute($RS);
				}
				if($TERMPOS_SEL==0){
						$SQL="UPDATE IMP_COT SET ID_WS='' WHERE ID_COT=".$ID_COT;
						$RS = sqlsrv_query($conn, $SQL);
						//oci_execute($RS);
				}
	?>
        <table style="margin:10px 20px; ">
        <tr>
        <td>

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
                
                <h3>Art&iacute;culos Seleccionados para Cotizaci&oacute;n</h3>
                <table id="Listado">
                <tr>
                    <th>Item</th>
                    <th>C&oacute;d.Art.</th>
                    <th>Art&iacute;culo</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th></th>
               </tr>
               <?php
                $SQLA="SELECT * FROM IMP_COTART WHERE ID_COT=".$ID_COT." ORDER BY ID_COTITM DESC";
                $RSA = sqlsrv_query($conn, $SQLA);
                //oci_execute($RSA);
                $CONTADOR=1;
                $TOT_COT=0;
                $CUENTA=1;
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
                        $RSI = sqlsrv_query($ARTS_EC, $SQLI);
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
                        if($CUENTA%2==0){
                            $TD_COLOR="#F9F9F9";
                        } else {
                            $TD_COLOR="#F7F7F7";
                        }
                        $CUENTA=$CUENTA+1;
                ?>
                <script language="JavaScript">
                function ValidaCambio(theForm){
                    
                        if (theForm.ELMIDCOTITM.value != ""){
                
                                var aceptaEntrar = window.confirm("El cambio de cantidad es reversible, mientras que el RETIRO no lo es, si Retira todos los items, la Cotizacion sera eliminada...  \xbfest\xe1 seguro?");
                                if (aceptaEntrar) 
                                {
                                    document.forms.theForm.submit();
                                }  else  
                                {
                                    return false;
                                }
                    }
                } //ValidaCambio(theForm)
                </script>
                <form action="reg_cotiza_reg.php" method="post" name="frmreg" id="frmreg" onSubmit="return ValidaCambio(this)">
                <tr>
                    <td style="text-align:right; width:40px; max-width:40px;"><?=$CONTADOR;?></td>
                    <td style="text-align:right;"><?=$CODE_EAN;?></td>
                    <td><?=$NM_ITM;?></td>
                    <td style="text-align:right;"><?=$MONEDA.$PREC_ITM;?></td>
                    <td style="text-align:right;"><input type="text" name="QTN<?=$ID_COTITM?>" value="<?=$QN_ITM?>" size="4" maxlength="6" style="text-align:right"  onKeyPress="return acceptNum(event);"></td>
                    <td style="text-align:right;"><?=$MONEDA.$TOT_ITM_F;?></td>
                    <td>
                        <input type="submit" value="Modificar" name="ACTQTNITM">
                        <input type="submit" value="Retirar" name="ELMIDCOTITM">
                        <input type="hidden" name="ID_COT" value="<?=$ID_COT?>">
                        <input type="hidden" name="ID_COTITM" value="<?=$ID_COTITM?>">
                    </td>
                </tr>
                </form>
                <?php
                    $CONTADOR=$CONTADOR+1;
                } //LISTADO DE ARTICULOS
               ?>
                <tr style="background-color:#7A2A9C">
                    <td colspan="4" style="text-align:right; color:#FFFFFF; font-size:12pt; font-weight:300">Total Cotizaci&oacute;n</td>
                    <td colspan="2" style="text-align:right; color:#FFFFFF; font-size:12pt; font-weight:300">
                        <?php
                            $TOT_COT_F = $TOT_COT/$DIVCENTS;
                            $TOT_COT_F = number_format($TOT_COT_F, $CENTS, $GLBSDEC, $GLBSMIL);
                        ?>
                        <?=$MONEDA.$TOT_COT_F?>
                    </td>
                    <td style="text-align:right; border-left:none; border-right:none">
                   </td>
                </tr>
                <form action="reg_cotiza.php?ACT=<?=$ID_COT?>" method="post" name="frmpos" id="frmpos">
                <tr style="background-color:#FFF8D2">
                    <td colspan="4" style="text-align:right; font-weight:600; padding-top:8px">Seleccione Punto de Venta <br> en donde ejecutar la Compra</td>
                    <td colspan="2" style="vertical-align:middle">
                        <!-- LISTAR POS DE TIENDA -->
                        <select name="TERMPOS" onChange="document.forms.frmpos.submit();">
                            <option value="0">Terminal</option>
                            <?php 
                            $SQLPOS="SELECT ID_WS, CD_WS FROM AS_WS WHERE ID_BSN_UN=".$ID_BSN_UN." ORDER BY CD_WS ASC";
                            $RSF = sqlsrv_query($arts_conn, $SQLPOS);
                            //oci_execute($RSF);
                            while ($rowF = sqlsrv_fetch_array($RSF)) {
                                $ID_WS_SEL = $rowF['ID_WS'];
                                $CD_WS_SEL = $rowF['CD_WS'];
                                ?>
                                <option value="<?=$ID_WS_SEL ?>" <?php if($ID_WS_SEL==$TERMPOS_SEL){ echo "Selected";}?>><?=$CD_WS_SEL ?></option>
                                <?php 
                            }
                            ?>
                        </select>
                    </td>
                    <td style="vertical-align:middle">
                    <?php if(!empty($ID_WS)){ ?>
                            <input type="button" style="display:inline; float:right; width:154px" name="TRXSUSPCOT" value="Enviar a POS<?=$EL_POS;?>" onClick="pagina('reg_cotiza_reg.php?TRXSUSPCOT=1&ID_COT=<?=$ID_COT?>&TOT_COT=<?=$TOT_COT;?>');">
                    <?php   }  ?>
                    </td>
                </tr>
                </form>

           </table>

        </td>
        </tr>
        </table>
        <?php }//if($ACT==1){?>






    </td>
    </tr>  
    </table>

</td>
</tr>
</table>
    <iframe name="frmHIDEN" width="0%" height="0" frameborder="0" align="top" src="" framespacing="0" marginheight="0" marginwidth="0">
    </iframe>
</body>
</html>

