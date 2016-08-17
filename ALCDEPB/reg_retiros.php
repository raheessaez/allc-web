
<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1156;
	$NOMENU=1;


	$FLT_LONPKP=" WHERE ID_TRN IN(SELECT ID_TRN FROM TR_LON_TND) OR ID_TRN IN(SELECT ID_TRN FROM TR_PKP_TND) ";

	$FILTRO_FLAGS=" AND FL_TRG_TRN<>1 AND FL_CNCL<>1 AND FL_VD<>1 AND FL_SPN IS NULL";
	$FILTRO_MP=" AND ID_TRN IN(SELECT ID_TRN FROM TR_CTL_TND WHERE TY_TND_CTL=1) ";

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
					
					//$RS2 = sqlsrv_query($arts_conn, $CONSULTA2);
					////oci_execute($RS2);
					$RS2 = sqlsrv_query($arts_conn,$CONSULTA2); 
					
					if ($row = sqlsrv_fetch_array($RS2)){

							$MIN_FECHA_EMS = $row['MFECHA'];
							@$date = date_create($MIN_FECHA_EMS);
							$MIN_FECHA_EMS = @date_format($date, 'd/m/Y');

					}

					$CONSULTA2="SELECT MAX(TS_TRN_END) AS MFECHA FROM TR_TRN WHERE ID_TRN IN (SELECT ID_TRN FROM TR_CTL_TND ".$FLT_LONPKP.") AND FL_VD<>1 AND FL_CNCL<>1";
					
					//$RS2 = sqlsrv_query($arts_conn, $CONSULTA2);
					////oci_execute($RS2);
					$RS2 = sqlsrv_query($arts_conn,$CONSULTA2); 
					
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

					$F_FECHA=" WHERE convert(varchar(20),TS_TRN_END, 111) >= convert(varchar(20),'".$ANO_ED."/".$MES_ED."/".$DIA_ED."', 111) AND convert(varchar(20),TS_TRN_END, 111) <= convert(varchar(20),'".$ANO_EH."/".$MES_EH."/".$DIA_EH."', 111)  AND FL_VD<>1 AND FL_CNCL<>1 "; 
		
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
                <form action="reg_retiros.php" method="post" name="frmbuscar" id="frmbuscar">


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
                       				          
                                              <label for="FECHA_EM_H">Hasta</label>
                          				      <input name="DIA_EH" type="text" id="DIA_EH" value="<?php echo $DIA_EH ?>" size="2" maxlength="2" onKeyPress="return acceptNum(event);">
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
                          				        <input name="ANO_EH" type="text" id="ANO_EH" value="<?php echo $ANO_EH ?>" size="4" maxlength="4" onKeyPress="return acceptNum(event);">
                       				           
                                               <input name="B_FECHA_E" type="submit"  id="B_FECHA_E" value="Filtrar">
                                               <input name="LIMPIAR" type="button"  id="LIMPIAR" value="Limpiar" onClick="pagina('reg_retiros.php');">


                        <select style="clear:left;" name="FTIENDA" onChange="document.forms.frmbuscar.submit();">
                                    <option value="0">Tienda</option>
                                    <?php 
                                    // ACA
                                    

									$SQLFILTRO="SELECT ID_BSN_UN FROM TR_TRN  ".$F_FECHA." AND ID_TRN IN(SELECT ID_TRN FROM TR_CTL_TND ".$FLT_LONPKP." ) ".$FILTRO_MP." GROUP BY ID_BSN_UN ORDER BY ID_BSN_UN ASC";

									
									//$RSF = sqlsrv_query($arts_conn, $SQLFILTRO);
									////oci_execute($RSF);
									
									$RSF = sqlsrv_query($arts_conn,$SQLFILTRO); 
									
									while ($rowF = sqlsrv_fetch_array($RSF)) {
										
										$FLT_ID_BSN_UN = $rowF['ID_BSN_UN'];
										ECHO 'FLT_ID_BSN_UN:::'.$FLT_ID_BSN_UN;
										$S2="SELECT DE_STR_RT, CD_STR_RT FROM PA_STR_RTL WHERE ID_BSN_UN=".$FLT_ID_BSN_UN;
										
										//$RS2 = sqlsrv_query($arts_conn, $S2);
										////oci_execute($RS2);

										$RS2 = sqlsrv_query($arts_conn,$S2); 
										if ($row2 = sqlsrv_fetch_array($RS2)) {
											$FLTDES_TIENDA = $row2['DE_STR_RT'];
											$FLTCOD_TIENDA = $row2['CD_STR_RT'];
										}
										if (empty($FLTDES_TIENDA)){$FLTDES_TIENDA=$FLTCOD_TIENDA;}
                                     ?>
                                    <option value="<?php echo $FLT_ID_BSN_UN ?>" <?php  if ($FLT_ID_BSN_UN==$FTIENDA) { echo "SELECTED";}?>>L.<?php echo $FLTDES_TIENDA ?></option>
                                    <?php 
									}
                                     ?>
                                    </select>
                                    <?php if($FTIENDA==0){?>
                                    
                                    <label>Seleccione una Tienda para obtener Transacciones de Retiro </label>
                                    
                                    <?php } else {?>

                                        <select name="FTERM" onChange="document.forms.frmbuscar.submit();">
                                                    <option value="0">Terminal</option>
                                                    <?php 
                                                     $SQLFILTRO="SELECT ID_WS FROM TR_TRN ".$F_FECHA." AND  ID_TRN IN(SELECT ID_TRN FROM TR_CTL_TND  ".$FLT_LONPKP.") AND  ID_BSN_UN=".$FTIENDA." ".$FILTRO_MP." GROUP BY ID_WS ORDER BY ID_WS ASC";
                                                    
                                                    //$RSF = sqlsrv_query($arts_conn, $SQLFILTRO);
                                                    ////oci_execute($RSF);
                                                     $RSF = sqlsrv_query($arts_conn,$SQLFILTRO);  
                                                    
                                                    while ($rowF = sqlsrv_fetch_array($RSF)) {
                                                        $FLT_ID_WS = $rowF['ID_WS'];
                                                        $S2="SELECT CD_WS FROM AS_WS WHERE ID_WS=".$FLT_ID_WS;

                                                        //$RS2 = sqlsrv_query($arts_conn, $S2);
                                                        ////oci_execute($RS2);
                                                        $RS2 = sqlsrv_query($arts_conn,$S2);

                                                        if ($row2 = sqlsrv_fetch_array($RS2)) {
                                                            $FLTDES_WS = $row2['CD_WS'];
                                                        }	
                                                     ?>
                                                    <option value="<?php echo $FLT_ID_WS ?>" <?php  if ($FLT_ID_WS==$FTERM) { echo "SELECTED";}?>>POS.<?php echo $FLTDES_WS ?></option>
                                                    <?php 
                                                    }
                                                     ?>
                                                    </select>

                                        <select name="FOPERA" onChange="document.forms.frmbuscar.submit();">
                                                    <option value="0">Operador</option>
                                                    <?php 
                                                    $SQLFILTRO="SELECT * FROM PA_OPR WHERE ID_OPR IN(SELECT ID_OPR FROM TR_TRN ".$F_FECHA." AND  ID_TRN IN(SELECT ID_TRN FROM TR_CTL_TND ".$FLT_LONPKP.") AND  ID_BSN_UN=".$FTIENDA." ".$FILTRO_MP.") ORDER BY CD_OPR ASC";
                                                    
                                                    //$RSF = sqlsrv_query($arts_conn, $SQLFILTRO);
                                                    ////oci_execute($RSF);

                                                    $RSF = sqlsrv_query($arts_conn,$SQLFILTRO); 
                                                    while ($rowF = sqlsrv_fetch_array($RSF)) {
                                                        $FLT_ID_OPR = $rowF['ID_OPR'];
														$FLTCD_OPR = $rowF['CD_OPR'];
                                                     ?>
                                                    <option value="<?php echo $FLT_ID_OPR ?>" <?php  if ($FLT_ID_OPR==$FOPERA) { echo "SELECTED";}?>>OPR.<?php echo $FLTCD_OPR ?></option>
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
                if($FTIENDA!=0){
				?>
                
                
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
				//$RS = sqlsrv_query($arts_conn, $SQL);
				////oci_execute($RS);

				$CONSULTA="SELECT COUNT(ID_TRN) AS CUENTA FROM TR_TRN ".$F_FECHA." ".$FILTRO_FLAGS." AND ID_TRN IN(SELECT ID_TRN FROM TR_CTL_TND ".$FLT_LONPKP.") ".$FILTRO_TIENDA.$FILTRO_TERM.$FILTRO_OPERA.$FILTRO_MP;

				//$RS = sqlsrv_query($arts_conn, $CONSULTA);
				////oci_execute($RS);
				$RS = sqlsrv_query($arts_conn,$CONSULTA); 

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

				//$RS = sqlsrv_query($arts_conn, $CONSULTA);
				////oci_execute($RS);
				$RS = sqlsrv_query($arts_conn,$CONSULTA); 

				if ($row = sqlsrv_fetch_array($RS)) {
					$TOTALVTA = $row['VENTA'];
				}
				$TOTALRECAUDO=$TOTALVTA;
				$TOTALVTA_F=$TOTALVTA/$DIVCENTS;
				$TOTALVTA_F=number_format($TOTALVTA_F, $CENTS, $GLBSDEC, $GLBSMIL);
				
				
				//$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM TR_TRN ".$F_FECHA." ".$FILTRO_FLAGS." AND  ID_TRN IN(SELECT ID_TRN FROM TR_CTL_TND ".$FLT_LONPKP.") ".$FILTRO_TIENDA.$FILTRO_TERM.$FILTRO_OPERA.$FILTRO_MP." ORDER BY ID_TRN  DESC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;

				$CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY ID_TRN DESC) ROWNUMBER FROM TR_TRN ".$F_FECHA." ".$FILTRO_FLAGS." AND  ID_TRN IN(SELECT ID_TRN FROM TR_CTL_TND ".$FLT_LONPKP.") ".$FILTRO_TIENDA.$FILTRO_TERM.$FILTRO_OPERA.$FILTRO_MP.") AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";

				//$RS = sqlsrv_query($arts_conn, $CONSULTA);
				////oci_execute($RS);
				$RS = sqlsrv_query($arts_conn,$CONSULTA);

               ?>
               
                <table id="Listado">
                <tr>
                	<th class="DataTH" colspan="10" style="padding:20px 6px 10px 36px">
                    	<h7>NTRX: <?php echo $TOTALREG;?> / MTRX: <?php echo $MONEDA.$TOTALVTA_F;?></h7>
                    </th>
                </tr>
                <form action="reg_retiros_reg.php" method="post" name="formret">
                <tr>
                    <th class="DataTH" colspan="2" style="padding-left: 36px">TRX</th>
                    <th class="DataTH">Terminal</th>
                    <th class="DataTH">Operador</th>
                    <th class="DataTH">Medio</th>
                    <th class="DataTH">Monto</th>
                    <th class="DataTH">TIPO</th>
                    <th class="DataTH" style="border-left-width:3px; border-left-style:solid; border-left-color:#DFDFDF">Fecha TRX</th>
                    <th class="DataTH">Inicio TRX</th>
                    <th class="DataTH">T&eacute;rmino TRX</th>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){
                        $ID_TRN = $row['ID_TRN'];
								$VAL_TRN=0;
								$SVAL="SELECT * FROM BDV_RET WHERE ID_TRN=".$ID_TRN;
								
								//$RSVAL = sqlsrv_query($conn, $SVAL);
								////oci_execute($RSVAL);
								$RSVAL = sqlsrv_query($conn,$SVAL); 
								
								if ($RWVAL = sqlsrv_fetch_array($RSVAL)) {
									$VAL_TRN=1;
								}
                        $AI_TRN = $row['AI_TRN'];
								$S2="SELECT * FROM TR_CTL_TND WHERE ID_TRN=".$ID_TRN;
								
								//$RS2 = sqlsrv_query($arts_conn, $S2);
								////oci_execute($RS2);

								$RS2 = sqlsrv_query($arts_conn,$S2);
								
								if ($row2 = sqlsrv_fetch_array($RS2)) {
									$TY_TND_CTL = $row2['TY_TND_CTL']; //TIPO, 0:DOTACION, 1:RETIRO
								}
								if($TY_TND_CTL==1){
									$DOTARET="RETIRO";
								}else{
									$DOTARET="DOTACION";
								}

								$S2="SELECT * FROM TR_LTM_TND_CTL_TND WHERE ID_TRN=".$ID_TRN;
								
								//$RS2 = sqlsrv_query($arts_conn, $S2);
								////oci_execute($RS2);
								$RS2 = sqlsrv_query($arts_conn,$S2);
								
								if ($row2 = sqlsrv_fetch_array($RS2)) {
									$ID_TND = $row2['ID_TND'];
									$ID_CNY = $row2['ID_CNY'];
									$MO_TND_FN_TRN = $row2['MO_TND_FN_TRN']; //IMPORTE
								}

								$FECHA_TICKET = $row['DC_DY_BSN'];
								$TS_TICKET = date_format($FECHA_TICKET,"d-m-Y");
										//$RES_TICKET=explode(" ",$FECHA_TICKET);
										//$TS_TICKET=$RES_TICKET[0];

								if(!empty($ID_CNY)){
									//PAGO EN MONEDA EXTRANJERA
										$S3="SELECT CD_CY_ISO FROM CO_CNY WHERE ID_CNY=".$ID_CNY;
										
										//$RS3 = sqlsrv_query($arts_conn, $S3);
										////oci_execute($RS3);
										$RS3 = sqlsrv_query($arts_conn,$S3);
										
										if ($row3 = sqlsrv_fetch_array($RS3)) {
											$MONEDA = $row3['CD_CY_ISO'];
										}	
								}
									
								$TIPO_MEDPAGO="NR";
										$S3="SELECT DE_TND FROM AS_TND WHERE ID_TND=".$ID_TND;

										//$RS3 = sqlsrv_query($arts_conn, $S3);
										////oci_execute($RS3);
										$RS3 = sqlsrv_query($arts_conn,$S3);
										
										if ($row3 = sqlsrv_fetch_array($RS3)) {
											$MEDIODEPAGO = $row3['DE_TND'];
										}
										if(empty($MEDIODEPAGO)) {$MEDIODEPAGO="NO DEFINIDO:";}
								$TIPO_MEDPAGO = $MEDIODEPAGO;
									
								$IMPORTE_F=$MO_TND_FN_TRN/$DIVCENTS;
								$IMPORTE_F=number_format($IMPORTE_F, $CENTS, $GLBSDEC, $GLBSMIL);

                        $ID_OPR = $row['ID_OPR'];
								$OPERADOR="NR";
								$S2="SELECT CD_OPR FROM PA_OPR WHERE ID_OPR=".$ID_OPR;
								
								//$RS2 = sqlsrv_query($arts_conn, $S2);
								////oci_execute($RS2);
								$RS2 = sqlsrv_query($arts_conn,$S2); 

								if ($row2 = sqlsrv_fetch_array($RS2)) {
									$OPERADOR = $row2['CD_OPR'];
								}	
                        $ID_WS = $row['ID_WS'];
								$TERMINAL="NR";
								$S2="SELECT CD_WS FROM AS_WS WHERE ID_WS=".$ID_WS;
								
								//$RS2 = sqlsrv_query($arts_conn, $S2);
								////oci_execute($RS2);
								$RS2 = sqlsrv_query($arts_conn,$S2); 

								if ($row2 = sqlsrv_fetch_array($RS2)) {
									$TERMINAL = $row2['CD_WS'];
								}	
                        $DC_DY_BSN = $row['DC_DY_BSN'];
                        $DC_DY_BSN = date_format($DC_DY_BSN,"d-m-Y");
								//$RES_BSN=explode(" ",$DC_DY_BSN);
								//$DC_DY_BSN=$RES_BSN[0];
                        $TS_TRN_BGN = $row['TS_TRN_BGN'];
                        $TS_TRN_BGN = date_format($TS_TRN_BGN,"d-m-Y");
								//$RES_BGN=explode(" ",$TS_TRN_BGN);
								//$TS_TRN_BGN=$RES_BGN[1];
                        $TS_TRN_END =  $row['TS_TRN_END'];
                        $TS_TRN_END = date_format($TS_TRN_END,"d-m-Y");
								//$RES_END=explode(" ",$TS_TRN_END);
								//$TS_TRN_END=$RES_END[1];
               ?>
				   <script>
							 function Activar<?php echo $ID_TRN?>(){
							      var Activar = document.getElementById("0<?php echo $ID_TRN?>");
							      var Desactivar = document.getElementById("99<?php echo $ID_TRN?>");
							      var Celda1 = document.getElementById("1<?php echo $ID_TRN?>");
							      var Celda2 = document.getElementById("2<?php echo $ID_TRN?>");
							      var Celda3 = document.getElementById("3<?php echo $ID_TRN?>");
							      var Celda4 = document.getElementById("4<?php echo $ID_TRN?>");
							      var Celda5 = document.getElementById("5<?php echo $ID_TRN?>");
							      var Celda6 = document.getElementById("6<?php echo $ID_TRN?>");
							      var Celda7 = document.getElementById("7<?php echo $ID_TRN?>");
							      var Celda8 = document.getElementById("8<?php echo $ID_TRN?>");
							      var Celda9 = document.getElementById("9<?php echo $ID_TRN?>");
								  var NUMTRN = document.getElementById("TRN<?php echo $ID_TRN?>");
											Activar.style.display = "none";
											Desactivar.style.display = "table-cell";
											Celda1.style.background = "#FBF3FE";
											Celda2.style.background = "#FBF3FE";
											Celda3.style.background = "#FBF3FE";
											Celda4.style.background = "#FBF3FE";
											Celda5.style.background = "#FBF3FE";
											Celda6.style.background = "#FBF3FE";
											Celda7.style.background = "#FBF3FE";
											Celda8.style.background = "#FBF3FE";
											Celda9.style.background = "#FBF3FE";
											NUMTRN.value = 1;
								}
							 function Desactivar<?php echo $ID_TRN?>(){
							      var Activar = document.getElementById("0<?php echo $ID_TRN?>");
							      var Desactivar = document.getElementById("99<?php echo $ID_TRN?>");
							      var Celda1 = document.getElementById("1<?php echo $ID_TRN?>");
							      var Celda2 = document.getElementById("2<?php echo $ID_TRN?>");
							      var Celda3 = document.getElementById("3<?php echo $ID_TRN?>");
							      var Celda4 = document.getElementById("4<?php echo $ID_TRN?>");
							      var Celda5 = document.getElementById("5<?php echo $ID_TRN?>");
							      var Celda6 = document.getElementById("6<?php echo $ID_TRN?>");
							      var Celda7 = document.getElementById("7<?php echo $ID_TRN?>");
							      var Celda8 = document.getElementById("8<?php echo $ID_TRN?>");
							      var Celda9 = document.getElementById("9<?php echo $ID_TRN?>");
								  var NUMTRN = document.getElementById("TRN<?php echo $ID_TRN?>");
											Activar.style.display = "table-cell";
											Desactivar.style.display = "none";
											Celda1.style.background = "#F7F7F7";
											Celda2.style.background = "#F7F7F7";
											Celda3.style.background = "#F7F7F7";
											Celda4.style.background = "#F7F7F7";
											Celda5.style.background = "#F7F7F7";
											Celda6.style.background = "#F7F7F7";
											Celda7.style.background = "#F7F7F7";
											Celda8.style.background = "#F7F7F7";
											Celda9.style.background = "#F7F7F7";
											NUMTRN.value = 0;
								}
                </script>
                <?php if($VAL_TRN==0){ ?>
                <tr>
                    <td id="0<?php echo $ID_TRN?>"  onClick="Activar<?php echo $ID_TRN?>();"><img src="../images/ICO_CheckNC.png"></td>
                    <td id="99<?php echo $ID_TRN?>" style="display:none" onClick="Desactivar<?php echo $ID_TRN?>();">
                            <img src="../images/ICO_CheckAC.png">
                            <input type="hidden" name="<?php echo $ID_TRN?>"  id="TRN<?php echo $ID_TRN?>" value="0">
                     </td>
                    <td id="1<?php echo $ID_TRN?>" style="border-left:none"><?php echo $AI_TRN?></td>
                    <td id="2<?php echo $ID_TRN?>" ><?php echo $TERMINAL?></td>
                    <td id="3<?php echo $ID_TRN?>" ><?php echo $OPERADOR?></td>
                    <td id="4<?php echo $ID_TRN?>" ><?php echo $TIPO_MEDPAGO?></td>
                    <td id="5<?php echo $ID_TRN?>"  style="text-align:right"><?php echo $MONEDA.$IMPORTE_F?></td>
                    <td id="6<?php echo $ID_TRN?>"  style="text-align:right"><?php echo $DOTARET?></td>
                    <td id="7<?php echo $ID_TRN?>"  style="border-left-width:3px; border-left-style:solid; border-left-color:#DFDFDF"><?php echo @$TS_TICKET?></td>
                    <td id="8<?php echo $ID_TRN?>"  style="text-align:right"><?php echo $TS_TRN_BGN?></td>
                    <td id="9<?php echo $ID_TRN?>"  style="text-align:right"><?php echo $TS_TRN_END?></td>
                </tr>
                <?php } else { ?>
                <tr>
                    <td><img src="../images/ICO_Nop.png"></td>
                    <td style="border-left:none"><?php echo $AI_TRN?></td>
                    <td><?php echo $TERMINAL?></td>
                    <td id="3<?php echo $ID_TRN?>" ><?php echo $OPERADOR?></td>
                    <td id="4<?php echo $ID_TRN?>" ><?php echo $TIPO_MEDPAGO?></td>
                    <td id="5<?php echo $ID_TRN?>"  style="text-align:right"><?php echo $MONEDA.$IMPORTE_F?></td>
                    <td id="6<?php echo $ID_TRN?>"  style="text-align:right"><?php echo $DOTARET?></td>
                    <td id="7<?php echo $ID_TRN?>"  style="border-left-width:3px; border-left-style:solid; border-left-color:#DFDFDF"><?php echo @$TS_TICKET?></td>
                    <td id="8<?php echo $ID_TRN?>"  style="text-align:right"><?php echo $TS_TRN_BGN?></td>
                    <td id="9<?php echo $ID_TRN?>"  style="text-align:right"><?php echo $TS_TRN_END?></td>
                </tr>
                <?php } ?>
                <?php
				}
				?>
                <tr>
                    <td colspan="12" nowrap style="background-color:transparent">
                      <?php if(@$VAL_TRN==0){ ?>
                        <input name="REGISTRAR" type="submit" value="Registrar">
					<?php } ?>
                    <?php
                    if ($LINF>=$CTP+1) {
						$ATRAS=$LINF-$CTP;
						$FILA_ANT=$LSUP-$CTP;
                   ?>
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('reg_retiros.php?LSUP=<?php echo $FILA_ANT?>&LINF=<?php echo $ATRAS?>&FTIENDA=<?php echo $FTIENDA?>&FTERM=<?php echo $FTERM?>&FOPERA=<?php echo $FOPERA?>&DIA_ED=<?php echo $DIA_ED ?>&MES_ED=<?php echo $MES_ED ?>&ANO_ED=<?php echo $ANO_ED ?>&DIA_EH=<?php echo $DIA_EH ?>&MES_EH=<?php echo $MES_EH ?>&ANO_EH=<?php echo $ANO_EH ?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('reg_retiros.php?LSUP=<?php echo $FILA_POS?>&LINF=<?php echo $ADELANTE?>&FTIENDA=<?php echo $FTIENDA?>&FTERM=<?php echo $FTERM?>&FOPERA=<?php echo $FOPERA?>&DIA_ED=<?php echo $DIA_ED ?>&MES_ED=<?php echo $MES_ED ?>&ANO_ED=<?php echo $ANO_ED ?>&DIA_EH=<?php echo $DIA_EH ?>&MES_EH=<?php echo $MES_EH ?>&ANO_EH=<?php echo $ANO_EH ?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina <?php echo $NUMPAG?> de <?php echo $NUMTPAG?></span>
                    </td>
                </form>
                </tr>
                </table>
               
               <?php
				} //$FTIENDA!=0
			   ?>
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

