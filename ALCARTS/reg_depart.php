
<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1119;
	$NOMENU=1;

	$FILTRO_FLAGS=" AND FL_TRG_TRN<>1 AND FL_CNCL<>1 AND FL_VD<>1 AND FL_SPN IS NULL";

	$FILTRO_TIENDA="";
	$FTIENDA=@$_POST["FTIENDA"];
	if (empty($FTIENDA)) { $FTIENDA=@$_GET["FTIENDA"] ;}
	if (empty($FTIENDA)) { $FTIENDA=0 ;}
	if ($FTIENDA!=0) {
		$FILTRO_TIENDA=" AND ID_BSN_UN=".$FTIENDA ;
	}
		
					//CALCULAR MINIMO Y MÁXIMO FECHA REGISTRO
					$CONSULTA2="SELECT MIN(TS_TRN_END) AS MFECHA FROM TR_TRN WHERE ID_TRN IN (SELECT ID_TRN FROM TR_RTL) AND FL_VD<>1 AND FL_CNCL<>1";
					$RS2 = sqlsrv_query($conn, $CONSULTA2);
					//oci_execute($RS2);
					if ($row = sqlsrv_fetch_array($RS2)){
							$MIN_FECHA_EMS = $row['MFECHA'];
							$MIN_FECHA_EMS = date_format($MIN_FECHA_EMS,"d/m/Y");
					}

					$CONSULTA2="SELECT MAX(TS_TRN_END) AS MFECHA FROM TR_TRN WHERE ID_TRN IN (SELECT ID_TRN FROM TR_RTL) AND FL_VD<>1 AND FL_CNCL<>1";
					$RS2 = sqlsrv_query($conn, $CONSULTA2);
					//oci_execute($RS2);
					if ($row = sqlsrv_fetch_array($RS2)){
							$MAX_FECHA_EMS = $row['MFECHA'];
							$MAX_FECHA_EMS = date_format($MAX_FECHA_EMS,"d/m/Y");

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

					$F_FECHA=" WHERE ( Convert(varchar(20), TS_TRN_END, 111) >= Convert(varchar(20),'".$ANO_ED."/".$MES_ED."/".$DIA_ED."', 111)  AND Convert(varchar(20), TS_TRN_END, 111) <= Convert(varchar(20),'".$ANO_EH."/".$MES_EH."/".$DIA_EH."', 111))  AND FL_VD<>1 AND FL_CNCL<>1 "; 
		
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
                <form action="reg_depart.php" method="post" name="frmbuscar" id="frmbuscar">


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
                                               <input name="ANO_ED" type="text"  id="ANO_ED" value="<?php echo $ANO_ED ?>" size="4" maxlength="4">
                       				          
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
                                               <input name="LIMPIAR" type="button" id="LIMPIAR" value="Limpiar" onClick="pagina('reg_depart.php');">

                                   
                        <select  style="clear:left; " name="FTIENDA" onChange="document.forms.frmbuscar.submit();">
                                    <option value="0">Cadena</option>
                                    <?php 
									$SQLFILTRO="SELECT ID_BSN_UN FROM TR_TRN  ".$F_FECHA." AND ID_TRN IN(SELECT ID_TRN FROM TR_RTL) GROUP BY ID_BSN_UN ORDER BY ID_BSN_UN ASC";
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

                </form>
              </td>
              </tr>
              </table>
             
             
              
                <table style="margin:10px 20px; ">
                <tr>
                <td>
                
                
                <?php
				
				//$SQL="ALTER SESSION SET nls_date_format='DD-MM-YYYY HH24:MI:SS'";
				//$RS = sqlsrv_query($conn, $SQL);
				//oci_execute($RS);
				
				$CONSULTA="SELECT CD_DPT_PS FROM TR_LTM_SLS_RTN WHERE ID_TRN IN(SELECT ID_TRN FROM TR_TRN ".$F_FECHA.$FILTRO_FLAGS.$FILTRO_TIENDA.") GROUP BY CD_DPT_PS ORDER BY CD_DPT_PS  ASC";
				$RS = sqlsrv_query($conn, $CONSULTA);
				//oci_execute($RS);
               ?>
                            
                <table id="Listado">
                <tr>
                    <th>Departamento</th>
                    <th>Cod.</th>
                    <th>&Iacute;tems</th>
                    <?php
					//PLAN DE IMPUESTOS EN CO_TY_TX
						$CONSULTA_TX="SELECT * FROM CO_TY_TX ORDER BY TY_TX  ASC";
						$RS2 = sqlsrv_query($conn, $CONSULTA_TX);
						//oci_execute($RS2);
						while ($row_TX = sqlsrv_fetch_array($RS2)){
								$TY_TX = $row_TX['TY_TX'];
								$PE_TX = $row_TX['PE_TX']/$DIVCENTS;
								$PE_TX = round($PE_TX,2);
					?>
                    <th><?php echo $PE_TX."%(".$TY_TX.")";?></th>
                    <?php
						}
					?>
                    <th>Total Impuestos</th>
                    <th>Total Ventas</th>
                </tr>
                <?php

				while ($row = sqlsrv_fetch_array($RS)){
                        $CD_DPT_PS = $row['CD_DPT_PS'];

                       

						$CONSULTA_TRN="SELECT COUNT(ID_ITM) AS NUM_ITEMS FROM TR_LTM_SLS_RTN  WHERE CD_DPT_PS=".$CD_DPT_PS." AND  ID_TRN IN(SELECT ID_TRN FROM TR_TRN ".$F_FECHA.$FILTRO_FLAGS.$FILTRO_TIENDA.") GROUP BY ID_ITM";
						$RS1 = sqlsrv_query($conn, $CONSULTA_TRN);
						//oci_execute($RS1);
						if ($row_TRN = sqlsrv_fetch_array($RS1)){
								$NUM_ITEMS = $row_TRN['NUM_ITEMS'];
						}
						$DEPARTAMENTO =  "NO DEFINIDO";
						$CONSULTA_DPT="SELECT * FROM ID_DPT_PS  WHERE CD_DPT_PS=".$CD_DPT_PS;
						$RS1 = sqlsrv_query($conn, $CONSULTA_DPT);
						//oci_execute($RS1);
						if ($row_TRN = sqlsrv_fetch_array($RS1)){
								$DEPARTAMENTO = $row_TRN['NM_DPT_PS'];
								$COD_DEPTO = $row_TRN['CD_DPT_PS'];
						}
						$CONSULTA_TRN="SELECT SUM(MO_EXTND) AS IMPORTE FROM TR_LTM_SLS_RTN  WHERE CD_DPT_PS=".$CD_DPT_PS." AND  ID_TRN IN(SELECT ID_TRN FROM TR_TRN ".$F_FECHA.$FILTRO_FLAGS.$FILTRO_TIENDA.") GROUP BY ID_ITM";
						$RS1 = sqlsrv_query($conn, $CONSULTA_TRN);
						//oci_execute($RS1);
						if ($row_TRN = @sqlsrv_fetch_array($RS1)){
								$IMPORTE = $row_TRN['IMPORTE'];
						}
								$IMPORTE=$IMPORTE/$DIVCENTS;
								$IMPORTE=number_format($IMPORTE, $CENTS, $GLBSDEC, $GLBSMIL);
               ?>
                <tr>
                    <td><?php echo $DEPARTAMENTO?></td>
                    <td style="text-align:right"><?php echo $COD_DEPTO?></td>
                    <td style="text-align:right"><?php echo $NUM_ITEMS?></td>
                    <?php
					//PLAN DE IMPUESTOS EN CO_TY_TX
						$CONSULTA_TX="SELECT * FROM CO_TY_TX ORDER BY TY_TX  ASC";
						$RS2 = sqlsrv_query($conn, $CONSULTA_TX);
						//oci_execute($RS2);
						$IMPXDEPTO=0;
						$IMPUESTOS=0;
						while ($row_TX = sqlsrv_fetch_array($RS2)){
								$TY_TX = $row_TX['TY_TX'];
								$PE_TX = $row_TX['PE_TX']/$DIVCENTS;
								$PE_TX = round($PE_TX,2);
								$CONSULTA_TXI="SELECT SUM(MO_EXTND) AS IMPUESTOS FROM TR_LTM_SLS_RTN  WHERE ID_DPT_PS=".$ID_DPT_PS." AND TY_TX='".$TY_TX."' AND  ID_TRN IN(SELECT ID_TRN FROM TR_TRN ".$F_FECHA.$FILTRO_FLAGS.$FILTRO_TIENDA.")";
								$RS3 = sqlsrv_query($conn, $CONSULTA_TXI);
								//oci_execute($RS3);
								if ($row_TXI = sqlsrv_fetch_array($RS3)){
										$IMPXDEPTO = ($row_TXI['IMPUESTOS']*$PE_TX)/$DIVCENTS;
										$IMPUESTOS=$IMPUESTOS+$IMPXDEPTO;
								} else {
										$IMPXDEPTO =0;
								}
								$IMPXDEPTO=$IMPXDEPTO/$DIVCENTS;
								$IMPXDEPTO=number_format($IMPXDEPTO, $CENTS, $GLBSDEC, $GLBSMIL);
					?>
                        <td  style="text-align:right"><?php echo $MONEDA.$IMPXDEPTO;?></td>
                    <?php
						}
						$IMPUESTOS=$IMPUESTOS/$DIVCENTS;
						$IMPUESTOS=number_format($IMPUESTOS, $CENTS, $GLBSDEC, $GLBSMIL);
					?>
                    <td style="text-align:right"><?php echo $MONEDA.$IMPUESTOS?></td>
                    <td style="text-align:right"><?php echo $MONEDA.$IMPORTE?></td>
                </tr>
                <?php
				}
				?>
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

