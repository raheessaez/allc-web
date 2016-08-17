
<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1118;
	$NOMENU=1;


	$FLT_LONPKP="WHERE ID_TRN IN(SELECT ID_TRN FROM TR_LON_TND) OR ID_TRN IN(SELECT ID_TRN FROM TR_PKP_TND)";

	$FILTRO_FLAGS=" AND FL_TRG_TRN<>1 AND FL_CNCL<>1 AND FL_VD<>1 AND FL_SPN IS NULL";
	$FILTRO_MP="";
//	$FPAGO="";
	$FMEDIO=@$_POST["FMEDIO"];
	if (empty($FMEDIO)) { $FMEDIO=@$_GET["FMEDIO"] ;}
	if (empty($FMEDIO)) { $FMEDIO=0 ;}
	if ($FMEDIO!=0) {
			if($FMEDIO==1){ $FILTRO_MP=" AND ID_TRN IN(SELECT ID_TRN FROM TR_CTL_TND WHERE TY_TND_CTL=1) ";}
			if($FMEDIO==2){ $FILTRO_MP=" AND ID_TRN IN(SELECT ID_TRN FROM TR_CTL_TND WHERE (TY_TND_CTL=0) OR (TY_TND_CTL IS NULL)) ";}
//		$FPAGO=" AND ID_TND=".$FMEDIO;
	}

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
					$CONSULTA2="SELECT MIN(TS_TRN_END) AS MFECHA FROM TR_TRN WHERE ID_TRN IN (SELECT ID_TRN FROM TR_CTL_TND ".$FLT_LONPKP.") AND FL_VD<>1 AND FL_CNCL<>1";
					$RS2 = sqlsrv_query($conn, $CONSULTA2);
					//oci_execute($RS2);
					if ($row = sqlsrv_fetch_array($RS2)){
							$MIN_FECHA_EMS = $row['MFECHA'];
							$MIN_FECHA_EMS = date_format($MIN_FECHA_EMS,"d-m-Y");
					}

					$CONSULTA2="SELECT MAX(TS_TRN_END) AS MFECHA FROM TR_TRN WHERE ID_TRN IN (SELECT ID_TRN FROM TR_CTL_TND ".$FLT_LONPKP.") AND FL_VD<>1 AND FL_CNCL<>1";
					$RS2 = sqlsrv_query($conn, $CONSULTA2);
					//oci_execute($RS2);
					if ($row = sqlsrv_fetch_array($RS2)){
							$MAX_FECHA_EMS = $row['MFECHA'];
							$MAX_FECHA_EMS = date_format($MAX_FECHA_EMS,"d-m-Y");
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

					$F_FECHA=" WHERE (  Convert(varchar(20), TS_TRN_END, 111) >= Convert(varchar(20), '".$ANO_ED."-".$MES_ED."-".$DIA_ED."', 111)  AND  Convert(varchar(20), TS_TRN_END, 111) <= Convert(varchar(20),'".$ANO_EH."-".$MES_EH."-".$DIA_EH."', 111))  AND FL_VD<>1 AND FL_CNCL<>1"; 
		
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
                <form action="reg_dotret.php" method="post" name="frmbuscar" id="frmbuscar">

                          				      <label for="FECHA_EM_D" >Desde </label>
                                              <input name="DIA_ED" type="text" id="DIA_ED" value="<?php echo $DIA_ED ?>" size="2" maxlength="2" onKeyPress="return acceptNum(event);">
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
                          				        <input name="ANO_EH" type="text"  value="<?php echo $ANO_EH ?>" size="4" maxlength="4" onKeyPress="return acceptNum(event);">
                       				           
                                               <input name="B_FECHA_E" type="submit" id="B_FECHA_E" value="Filtrar">
                                               <input name="LIMPIAR" type="button"  id="LIMPIAR" value="Limpiar" onClick="pagina('reg_dotret.php');">





                        <select style="clear:left; " name="FMEDIO" onChange="document.forms.frmbuscar.submit();">
                                    <option value="0">Tipo Control</option>
                                    <option value="2"  <?php  if ($FMEDIO==2) { echo "SELECTED";}?>>DOTACION</option>
                                    <option value="1"  <?php  if ($FMEDIO==1) { echo "SELECTED";}?>>RETIRO</option>
                         </select>
                                    
                        <select name="FTIENDA" onChange="document.forms.frmbuscar.submit();">
                                    <option value="0">Local</option>
                                    <?php 
									$SQLFILTRO="SELECT ID_BSN_UN FROM TR_TRN  ".$F_FECHA." AND ID_TRN IN(SELECT ID_TRN FROM TR_CTL_TND ".$FLT_LONPKP.") GROUP BY ID_BSN_UN ORDER BY ID_BSN_UN ASC";
									$RSF = sqlsrv_query($conn, $SQLFILTRO);
									//oci_execute($RSF);
									while ($rowF = sqlsrv_fetch_array($RSF)) {
										$FLT_ID_BSN_UN = $rowF['ID_BSN_UN'];
										$S2="SELECT DE_STR_RT, CD_STR_RT FROM PA_STR_RTL WHERE ID_BSN_UN=".$FLT_ID_BSN_UN;
										$RS2 = sqlsrv_query($conn, $S2);
										//oci_execute($RS2);
										if ($row2 = sqlsrv_fetch_array($RS2)) {
											$FLTDES_TIENDA = $row2['DE_STR_RT'];
											$FLTCOD_TIENDA = $row2['CD_STR_RT'];
											$NUMLOCAL = substr("0000".$FLTCOD_TIENDA, -4);
										}
										if (!empty($FLTDES_TIENDA)){$NUMLOCAL=$NUMLOCAL." ".$FLTDES_TIENDA;}
                                     ?>
                                    <option value="<?php echo $FLT_ID_BSN_UN ?>" <?php  if ($FLT_ID_BSN_UN==$FTIENDA) { echo "SELECTED";}?>><?php echo $NUMLOCAL ?></option>
                                    <?php 
									}
                                     ?>
                                    </select>
                                    
                                    <?php if($FTIENDA<>0){?>

                                        <select name="FTERM" onChange="document.forms.frmbuscar.submit();">
                                                    <option value="0">Terminal</option>
                                                    <?php 
                                                     $SQLFILTRO="SELECT ID_WS FROM TR_TRN ".$F_FECHA." AND  ID_TRN IN(SELECT ID_TRN FROM TR_CTL_TND  ".$FLT_LONPKP.") AND  ID_BSN_UN=".$FTIENDA." GROUP BY ID_WS ORDER BY ID_WS ASC";
                                                    $RSF = sqlsrv_query($conn, $SQLFILTRO);
                                                    //oci_execute($RSF);
                                                    while ($rowF = sqlsrv_fetch_array($RSF)) {
                                                        $FLT_ID_WS = $rowF['ID_WS'];
                                                        $S2="SELECT CD_WS FROM AS_WS WHERE ID_WS=".$FLT_ID_WS;
                                                        $RS2 = sqlsrv_query($conn, $S2);
                                                        //oci_execute($RS2);
                                                        if ($row2 = sqlsrv_fetch_array($RS2)) {
                                                            $FLTDES_WS = $row2['CD_WS'];
                                                        }	
                                                     ?>
                                                    <option value="<?php echo $FLT_ID_WS ?>" <?php  if ($FLT_ID_WS==$FTERM) { echo "SELECTED";}?>><?php echo $FLTDES_WS ?></option>
                                                    <?php 
                                                    }
                                                     ?>
                                                    </select>

                                        <select name="FOPERA" onChange="document.forms.frmbuscar.submit();">
                                                    <option value="0">Operador</option>
                                                    <?php 
                                                    $SQLFILTRO="SELECT * FROM PA_OPR WHERE ID_OPR IN(SELECT ID_OPR FROM TR_TRN ".$F_FECHA." AND  ID_TRN IN(SELECT ID_TRN FROM TR_CTL_TND ".$FLT_LONPKP.") AND  ID_BSN_UN=".$FTIENDA.") ORDER BY CD_OPR ASC";
                                                    $RSF = sqlsrv_query($conn, $SQLFILTRO);
                                                    //oci_execute($RSF);
                                                    while ($rowF = sqlsrv_fetch_array($RSF)) {
                                                        $FLT_ID_OPR = $rowF['ID_OPR'];
														$FLTCD_OPR = $rowF['CD_OPR'];
                                                     ?>
                                                    <option value="<?php echo $FLT_ID_OPR ?>" <?php  if ($FLT_ID_OPR==$FOPERA) { echo "SELECTED";}?>><?php echo $FLTCD_OPR ?></option>
                                                    <?php 
                                                    }
                                                     ?>
                                                    </select>

                                    <?php } //if($FTIENDA<>0){?>


                </form>
              </td>
              </tr>
              </table>
             
             
              
                <table style="margin:10px 20px; ">
                <tr>
                <td>
                <?php
					if ($MSJE==1) {
							$ELMSJ="Registro actualizado";
						} 
					if ($MSJE <> "") {
               ?>
                    <div id="Mensaje">
                            <p><?php echo $ELMSJ?></p>
                    </div>
                <?php }?>
                
                
                <?php
				
		$SQL="ALTER SESSION SET nls_date_format='DD-MM-YYYY HH24:MI:SS'";
		$RS = sqlsrv_query($conn, $SQL);
		//oci_execute($RS);


				$CONSULTA="SELECT COUNT(*) AS CUENTA FROM TR_TRN ".$F_FECHA." ".$FILTRO_FLAGS." AND ID_TRN IN(SELECT ID_TRN FROM TR_CTL_TND ".$FLT_LONPKP.") ".$FILTRO_TIENDA.$FILTRO_TERM.$FILTRO_OPERA.$FILTRO_MP;
				
				$RS = sqlsrv_query($conn, $CONSULTA);
				//oci_execute($RS);
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
				
				
				$CONSULTA="SELECT SUM(MO_TND_FN_TRN) AS VENTA FROM TR_LTM_TND_CTL_TND WHERE ID_TRN IN(SELECT ID_TRN FROM TR_CTL_TND ".$FLT_LONPKP.") AND ID_TRN IN(SELECT ID_TRN FROM TR_TRN ".$F_FECHA.$FILTRO_TIENDA.$FILTRO_TERM.$FILTRO_OPERA.$FILTRO_MP.")";
				$RS = sqlsrv_query($conn, $CONSULTA);
				//oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {
					$TOTALVTA = $row['VENTA'];
				}
				$TOTALVTA=$TOTALVTA/$DIVCENTS;
				$TOTALVTA=number_format($TOTALVTA, $CENTS, $GLBSDEC, $GLBSMIL);
				
				
				//$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM TR_TRN ".$F_FECHA." ".$FILTRO_FLAGS." AND  ID_TRN IN(SELECT ID_TRN FROM TR_CTL_TND ".$FLT_LONPKP.") ".$FILTRO_TIENDA.$FILTRO_TERM.$FILTRO_OPERA.$FILTRO_MP." ORDER BY ID_TRN  DESC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;
				
				//oci_execute($RS);

				$CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY ID_TRN DESC) ROWNUMBER FROM TR_TRN ".$F_FECHA." ".$FILTRO_FLAGS." AND  ID_TRN IN(SELECT ID_TRN FROM TR_CTL_TND ".$FLT_LONPKP.") ".$FILTRO_TIENDA.$FILTRO_TERM.$FILTRO_OPERA.$FILTRO_MP.") AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";

				$RS = sqlsrv_query($conn, $CONSULTA);

               ?>
               
               <p class="ArtsBubble">N&deg; TRX: <?php echo $TOTALREG;?> / <?php echo $MONEDA.$TOTALVTA;?></p>
               
               <?php if($TOTALREG>0 && $UNDIA==1 && $FMEDIO==1 && $FTIENDA!=0) {?>
               	<input type="button" id="DESC_ARCHIVO" name="DESC_ARCHIVO" value="Descargar Archivo de Retiros" onClick="pagina('descarga_RETIROS.php?FTIENDA=<?php echo $FTIENDA?>&TOTALRECAUDO=<?php echo $TOTALRECAUDO?>&NUMREGS=<?php echo $NUMREGS?>&DIA_ED=<?php echo $DIA_ED ?>&MES_ED=<?php echo $MES_ED ?>&ANO_ED=<?php echo $ANO_ED ?>&DIA_EH=<?php echo $DIA_EH ?>&MES_EH=<?php echo $MES_EH ?>&ANO_EH=<?php echo $ANO_EH ?>');">
				<?php } ?>
               
                <table id="Listado">
                <tr>
                    <th>Local</th>
                    <th>Terminal</th>
                    <th>Operador</th>
                    <th>TRX</th>
                    <th>Medio</th>
                    <th>Monto</th>
                    <th>TIPO</th>
                    <th>Fecha TRX</th>
                    <th style="border-left-width:3px; border-left-style:solid; border-left-color:#DFDFDF">Fecha TRX</th>
                    <th>Inicio TRX</th>
                    <th>T&eacute;rmino TRX</th>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){
                        $ID_TRN = $row['ID_TRN'];
                        $AI_TRN = $row['AI_TRN'];
								$S2="SELECT * FROM TR_CTL_TND WHERE ID_TRN=".$ID_TRN;
								$RS2 = sqlsrv_query($conn, $S2);
								//oci_execute($RS2);
								if ($row2 = sqlsrv_fetch_array($RS2)) {
									$TY_TND_CTL = $row2['TY_TND_CTL']; //TIPO, 0:DOTACION, 1:RETIRO
								}
								if($TY_TND_CTL==1){
									$DOTARET="RETIRO";
								}else{
									$DOTARET="DOTACION";
								}

								$S2="SELECT * FROM TR_LTM_TND_CTL_TND WHERE ID_TRN=".$ID_TRN;
								$RS2 = sqlsrv_query($conn, $S2);
								//oci_execute($RS2);
								if ($row2 = sqlsrv_fetch_array($RS2)) {
									$ID_TND = $row2['ID_TND'];
									$ID_CNY = $row2['ID_CNY'];
									$MO_TND_FN_TRN = $row2['MO_TND_FN_TRN']; //IMPORTE
								}

								$FECHA_TICKET = $row['DC_DY_BSN'];
										$TS_TICKET = date_format($FECHA_TICKET,"d/m/Y");
										//$RES_TICKET=explode(" ",$FECHA_TICKET);
										//$TS_TICKET=$RES_TICKET[0];

								if(!empty($ID_CNY)){
									//PAGO EN MONEDA EXTRANJERA
										$S3="SELECT CD_CY_ISO FROM CO_CNY WHERE ID_CNY=".$ID_CNY;
										$RS3 = sqlsrv_query($conn, $S3);
										//oci_execute($RS3);
										if ($row3 = sqlsrv_fetch_array($RS3)) {
											$MONEDA = $row3['CD_CY_ISO'];
										}	
								}
									
								$TIPO_MEDPAGO="NR";
										$S3="SELECT DE_TND FROM AS_TND WHERE ID_TND=".$ID_TND;
										$RS3 = sqlsrv_query($conn, $S3);
										//oci_execute($RS3);
										if ($row3 = sqlsrv_fetch_array($RS3)) {
											$MEDIODEPAGO = $row3['DE_TND'];
										}
										if(empty($MEDIODEPAGO)) {$MEDIODEPAGO="NO DEFINIDO:";}
								$TIPO_MEDPAGO = $MEDIODEPAGO;
									
								$IMPORTE=number_format($MO_TND_FN_TRN/100, $CENTS, $GLBSDEC, $GLBSMIL);

                        $ID_OPR = $row['ID_OPR'];
								$OPERADOR="NR";
								$S2="SELECT CD_OPR FROM PA_OPR WHERE ID_OPR=".$ID_OPR;
								$RS2 = sqlsrv_query($conn, $S2);
								//oci_execute($RS2);
								if ($row2 = sqlsrv_fetch_array($RS2)) {
									$OPERADOR = $row2['CD_OPR'];
								}	
                        $ID_WS = $row['ID_WS'];
								$TERMINAL="NR";
								$S2="SELECT CD_WS FROM AS_WS WHERE ID_WS=".$ID_WS;
								$RS2 = sqlsrv_query($conn, $S2);
								//oci_execute($RS2);
								if ($row2 = sqlsrv_fetch_array($RS2)) {
									$TERMINAL = $row2['CD_WS'];
								}	
                        $ID_BSN_UN = $row['ID_BSN_UN'];
								$TIENDA="NR";
								$S2="SELECT DE_STR_RT, CD_STR_RT FROM PA_STR_RTL WHERE ID_BSN_UN=".$ID_BSN_UN;
								$RS2 = sqlsrv_query($conn, $S2);
								//oci_execute($RS2);
								if ($row2 = sqlsrv_fetch_array($RS2)) {
									$FLTCOD_TIENDA = $row2['CD_STR_RT'];
									$NUMLOCAL = substr("0000".$FLTCOD_TIENDA, -4);
								}	
								if (empty($TIENDA)){$TIENDA=$CODTIENDA;}
                        $DC_DY_BSN = $row['DC_DY_BSN'];
                        		$DC_DY_BSN = date_format($DC_DY_BSN,"d/m/Y");
								//$RES_BSN=explode(" ",$DC_DY_BSN);
								//$DC_DY_BSN=$RES_BSN[0];

                        $TS_TRN_BGN = $row['TS_TRN_BGN'];
                        $TS_TRN_BGN = date_format($TS_TRN_BGN,"H:i:s");
								//$RES_BGN=explode(" ",$TS_TRN_BGN);
								//$TS_TRN_BGN=$RES_BGN[1];
                        $TS_TRN_END =  $row['TS_TRN_END'];
                        $TS_TRN_END = date_format($TS_TRN_END,"H:i:s");
								//$RES_END=explode(" ",$TS_TRN_END);
								//$TS_TRN_END=$RES_END[1];
               ?>
                <tr>
                    <td><?php echo $NUMLOCAL?></td>
                    <td><?php echo $TERMINAL?></td>
                    <td><?php echo $OPERADOR?></td>
                    <td><?php echo $AI_TRN?></td>
                    <td><?php echo $TIPO_MEDPAGO?></td>
                    <td style="text-align:right"><?php echo $MONEDA.$IMPORTE?></td>
                    <td style="text-align:right"><?php echo $DOTARET?></td>
                    <td style="text-align:right"><?php echo $TS_TICKET?></td>
                    <td style="border-left-width:3px; border-left-style:solid; border-left-color:#DFDFDF"><?php echo $DC_DY_BSN?></td>
                    <td style="text-align:right"><?php echo $TS_TRN_BGN?></td>
                    <td style="text-align:right"><?php echo $TS_TRN_END?></td>
                </tr>
                <?php
				}
				?>
                <tr>
                    <td colspan="11" nowrap style="background-color:transparent">
                    <?php
                    if ($LINF>=$CTP+1) {
						$ATRAS=$LINF-$CTP;
						$FILA_ANT=$LSUP-$CTP;
                   ?>
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('reg_dotret.php?LSUP=<?php echo $FILA_ANT?>&LINF=<?php echo $ATRAS?>&FTIENDA=<?php echo $FTIENDA?>&FTERM=<?php echo $FTERM?>&FOPERA=<?php echo $FOPERA?>&DIA_ED=<?php echo $DIA_ED ?>&MES_ED=<?php echo $MES_ED ?>&ANO_ED=<?php echo $ANO_ED ?>&DIA_EH=<?php echo $DIA_EH ?>&MES_EH=<?php echo $MES_EH ?>&ANO_EH=<?php echo $ANO_EH ?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('reg_dotret.php?LSUP=<?php echo $FILA_POS?>&LINF=<?php echo $ADELANTE?>&FTIENDA=<?php echo $FTIENDA?>&FTERM=<?php echo $FTERM?>&FOPERA=<?php echo $FOPERA?>&DIA_ED=<?php echo $DIA_ED ?>&MES_ED=<?php echo $MES_ED ?>&ANO_ED=<?php echo $ANO_ED ?>&DIA_EH=<?php echo $DIA_EH ?>&MES_EH=<?php echo $MES_EH ?>&ANO_EH=<?php echo $ANO_EH ?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina <?php echo $NUMPAG?> de <?php echo $NUMTPAG?></span>
                    </td>
                </tr>
                </table>
<?php
		sqlsrv_close($conn);
?>
               
               
                </td>
                </tr>
                </table>
        
</td>
</tr>
</table>
</body>
</html>

