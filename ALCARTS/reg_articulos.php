
<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1145;
	$NOMENU=1;
	
	$B_ART=@$_POST["B_ART"] ;
	if(empty($B_ART)){$B_ART=@$_GET["B_ART"];}

	$BUSCAR=@$_POST["BUSCAR"] ;
	if(empty($BUSCAR)){$BUSCAR=@$_GET["BUSCAR"];}
	
	$BARTICULO=trim(strtoupper(@$_POST["BARTICULO"]));
	if (empty($BARTICULO)) { $BARTICULO=trim(strtoupper(@$_GET["BARTICULO"])) ;}
	
	$BOPCION=@$_POST["BOPCION"];
	if (empty($BOPCION)) { $BOPCION=@$_GET["BOPCION"];}
	if (empty($BOPCION)) { $BOPCION=3;}
	
	
	$FLT_ART="";
	if ($BOPCION==1) { //POR C�DIGO DE BARRA
			if ($BARTICULO<>"") {$FLT_ART=" WHERE ID_ITM IN(SELECT ID_ITM FROM ID_PS WHERE ID_ITM_PS Like '%".strtoupper($BARTICULO)."%')" ;}
	} 
	if ($BOPCION==2) { //POR CODIGO SAP
			if ($BARTICULO<>"") {$FLT_ART=" WHERE CD_ITM Like '%".strtoupper($BARTICULO)."%' "; }
	} 
	if ($BOPCION==3) { //POR NOMBRE ARTICULO
			if ($BARTICULO<>"") {$FLT_ART=" WHERE (UPPER(LTRIM(NM_ITM)))  Like '%".strtoupper($BARTICULO)."%' "; }
	} 

	$LIST=@$_POST["LIST"] ;
	if(empty($LIST)){$LIST=@$_GET["LIST"];}
	if(empty($LIST)){$B_ART=1;}

	if($LIST==1){
		
			$ARTICULO=@$_POST["ARTICULO"];
			if (empty($ARTICULO)) { $ARTICULO=@$_GET["ARTICULO"] ;}
			$FLT_ARTICULO="";
			if(!empty($ARTICULO)){
				$FLT_ARTICULO=" AND ID_TRN IN(SELECT ID_TRN FROM TR_LTM_SLS_RTN WHERE ID_ITM=".$ARTICULO.")";
			}
			
			$FILTRO_FLAGS=" AND FL_TRG_TRN<>1 AND FL_CNCL<>1 AND FL_VD<>1 AND FL_SPN IS NULL";
			$FILTRO_MP="";
			$FPAGO="";
			$FMEDIO=@$_POST["FMEDIO"];
			if (empty($FMEDIO)) { $FMEDIO=@$_GET["FMEDIO"] ;}
			if (empty($FMEDIO)) { $FMEDIO=0 ;}
			if ($FMEDIO!=0) {
				$FILTRO_MP=" AND ID_TRN IN(SELECT ID_TRN FROM TR_LTM_TND WHERE ID_TND=".$FMEDIO.") ";
				$FPAGO=" AND ID_TND=".$FMEDIO;
			}
			if($FMEDIO==488){
					$FMEDIOTEF=@$_POST["FMEDIOTEF"];
					if (empty($FMEDIOTEF)) { $FMEDIOTEF=@$_GET["FMEDIOTEF"] ;}
					if (empty($FMEDIOTEF)) { $FMEDIOTEF=0 ;}
					if ($FMEDIOTEF!=0) {
						$CONSULTATEF="SELECT ACNT_TEF_TND, FCS_TEF_TND, BIN_TEF_TND FROM CO_TEF_TND_DT WHERE ID_TEF_TND=".$FMEDIOTEF;
							$RSTEF = sqlsrv_query($conn, $CONSULTATEF);
							//oci_execute($RSTEF);
							if ($rowTEF = sqlsrv_fetch_array($RSTEF)){
									$ACNT = $rowTEF['ACNT_TEF_TND'];
									$FCS = $rowTEF['FCS_TEF_TND'];
									$BIN = $rowTEF['BIN_TEF_TND'];
							}
						$FILTRO_MPTEF=" AND ID_TRN IN(SELECT ID_TRN FROM CO_TEF_TND_LN_ITM WHERE TRIM(ACNT)='".$ACNT."' AND TRIM(FCS)='".$FCS."' AND TRIM(BIN)='".$BIN."' )";
						$FPAGOTEF=" AND ID_TND=".$FMEDIOTEF;
					}
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
							//CALCULAR MINIMO Y M�XIMO FECHA REGISTRO
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
							$F_FECHA=" WHERE  ( Convert(varchar(20), TS_TRN_END, 111) >= Convert(varchar(20), '".$ANO_ED."/".$MES_ED."/".$DIA_ED."' , 111)  AND Convert(varchar(20), TS_TRN_END, 111) <= Convert(varchar(20), '".$ANO_EH."/".$MES_EH."/".$DIA_EH."', 111))  AND FL_VD<>1 AND FL_CNCL<>1"; 
	}
		
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
<?php	if($B_ART==1){ ?>
                <table width="100%" id="Filtro">
                <tr>
                <td>
                <form action="reg_articulos.php?B_ART=1" method="post" name="frmbuscar" id="frmbuscar">
                        <label for="BARTICULO">Art&iacute;culo </label>
                        <input name="BARTICULO" type="text"  id="BARTICULO" value="<?php echo $BARTICULO ?>" size="9" maxlength="40">
                        <input type="radio" name="BOPCION" value="3" <?php if($BOPCION==3) {?> checked <?php }?>>
                        <label for="BOPCION3" >Nombre</label>
                        <input type="radio" name="BOPCION" value="2" <?php if($BOPCION==2) {?> checked <?php }?>>
                        <label for="BOPCION2" >C.Tienda</label>
                        <input type="radio" name="BOPCION" value="1"  <?php if($BOPCION==1) {?> checked <?php }?>>
                        <label for="BOPCION1" >C.Barra</label>
                        <input name="BUSCAR" type="submit" id="BUSCAR" value="Buscar Art&iacute;culo">
                        <input name="LIMPIAR" type="button" id="LIMPIAR" value="Limpiar" onClick="pagina('reg_articulos.php');">
                </form>
              </td>
              </tr>
              </table>
              <?php if(!empty($BUSCAR)) { ?>
                <table style="margin:20px; width:95%">
                <tr>
                <td>
                	<table>
                		<?php
						//BUSCAR ART�CULOS
						$SQLA="SELECT * FROM AS_ITM ".$FLT_ART;
						

						$RSA = sqlsrv_query($conn, $SQLA);
						//oci_execute($RSA);
						$CTAARTS=0;
						while ($Row_A = sqlsrv_fetch_array($RSA)) {
							$NUMCOL=$CTAARTS%5;
							if($NUMCOL==0){$CTAARTS=0;}
							if($CTAARTS==0){echo "<tr>";}
							$B_ID_ITM=$Row_A['ID_ITM'];
							$B_CD_ITM=$Row_A['CD_ITM'];
							$B_NM_ITM=$Row_A['NM_ITM'];
							if(empty($B_NM_ITM)){$B_NM_ITM="SIN DESCRIPCION";}
							$SQLCB="SELECT * FROM ID_PS WHERE ID_ITM=".$B_ID_ITM;
							$RSCB = sqlsrv_query($conn, $SQLCB);
							//oci_execute($RSCB);
							$BARCODES="";
							while ($Row_CB = sqlsrv_fetch_array($RSCB)) {
								$BARCODES=$BARCODES.$Row_CB['ID_ITM_PS']." ";
							}
							if(empty($BARCODES)){$BARCODES="S/COD.BARRA";}
							?>
                            <form action="reg_articulos.php?LIST=1" method="post" name="frmsel<?=$B_ID_ITM?>" id="frmsel<?=$B_ID_ITM?>">
                            <td onClick="document.forms.frmsel<?=$B_ID_ITM?>.submit();">
                            	<div id="SelArticulos">
                                	<p <?php if ($BOPCION==2){?>style="font-weight:600; font-size:12pt"<?php }?> ><?=$B_CD_ITM?></p>
									<p <?php if ($BOPCION==3){?>style="font-weight:600; font-size:12pt"<?php }?>><?=$B_NM_ITM?></p>
									<p <?php if ($BOPCION==1){?>style="font-weight:600; font-size:12pt"<?php }?>><?=$BARCODES?></p>
                                	<input type="hidden" name="ARTICULO" value="<?=$B_ID_ITM?>">
                               </div>
                            </td>
                            </form>
                            <?php
							$CTAARTS=$CTAARTS+1;
						}
						?>
                        </table>
                </td>
                </tr>
                </table>
              <?php }?>
              
<?php } //$B_ART=1 ?>        

<!-- LISTA DE TRANSACCIONES LISTA DE TRANSACCIONES LISTA DE TRANSACCIONES LISTA DE TRANSACCIONES LISTA DE TRANSACCIONES LISTA DE TRANSACCIONES LISTA DE TRANSACCIONES LISTA DE TRANSACCIONES LISTA DE TRANSACCIONES LISTA DE TRANSACCIONES LISTA DE TRANSACCIONES LISTA DE TRANSACCIONES LISTA DE TRANSACCIONES LISTA DE TRANSACCIONES LISTA DE TRANSACCIONES LISTA DE TRANSACCIONES LISTA DE TRANSACCIONES -->

<?php	if($LIST==1){ ?>
        <table width="100%" id="Filtro">
          <tr>
            <td>
                <form action="reg_articulos.php?LIST=1&ARTICULO=<?php echo $ARTICULO;?>" method="post" name="frmbuscar" id="frmbuscar">


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
                                               <input name="LIMPIAR" type="button"  id="LIMPIAR" value="Limpiar" onClick="pagina('reg_articulos.php');">

                        <select style="clear:left; " name="FMEDIO" onChange="document.forms.frmbuscar.submit();">
                                    <option value="0">Medio Pago</option>
                                    <?php 
									$SQLFILTRO="SELECT ID_TND, DE_TND FROM AS_TND  WHERE ID_TND IN(SELECT ID_TND FROM TR_LTM_TND WHERE ID_TRN IN(SELECT ID_TRN FROM TR_TRN  ".$F_FECHA." AND  ID_TRN IN(SELECT ID_TRN FROM TR_RTL) )) ";
									$RSF = sqlsrv_query($conn, $SQLFILTRO);
									//oci_execute($RSF);
									while ($rowF = sqlsrv_fetch_array($RSF)) {
											$FLTID_TND = $rowF['ID_TND'];
											$FLTDE_TND = $rowF['DE_TND'];
                                     ?>
                                    <option value="<?php echo $FLTID_TND ?>" <?php  if ($FLTID_TND==$FMEDIO) { echo "SELECTED";}?>><?php echo $FLTDE_TND ?></option>
                                    <?php 
									}
                                     ?>
                                    </select>
                                    <?php
                                    if($FMEDIO==488){
									?>
                                    <select name="FMEDIOTEF" onChange="document.forms.frmbuscar.submit();">
                                                <option value="0">Medio TEF</option>
                                                <?php 
                                                $SQLFILTRO="SELECT ID_TEF_TND, DE_TEF_TND FROM CO_TEF_TND";
                                                $RSF = sqlsrv_query($conn, $SQLFILTRO);
                                                //oci_execute($RSF);
                                                while ($rowF = sqlsrv_fetch_array($RSF)) {
                                                        $FLTID_TEF_TND = $rowF['ID_TEF_TND'];
                                                        $FLTDE_TEF_TND = $rowF['DE_TEF_TND'];
                                                 ?>
                                                <option value="<?php echo $FLTID_TEF_TND ?>" <?php  if ($FLTID_TEF_TND==$FMEDIOTEF) { echo "SELECTED";}?>><?php echo $FLTDE_TEF_TND ?></option>
                                                <?php 
                                                }
                                                 ?>
                                                </select>
                                    <?php } //$FMEDIO=46 ?>
                                    
                        <select name="FTIENDA" onChange="document.forms.frmbuscar.submit();">
                                    <option value="0">Local</option>
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
                                    
                                    <?php if($FTIENDA<>0){?>

                                        <select name="FTERM" onChange="document.forms.frmbuscar.submit();">
                                                    <option value="0">Terminal</option>
                                                    <?php 
                                                     $SQLFILTRO="SELECT ID_WS FROM TR_TRN ".$F_FECHA." AND  ID_TRN IN(SELECT ID_TRN FROM TR_RTL ) AND  ID_BSN_UN=".$FTIENDA." GROUP BY ID_WS ORDER BY ID_WS ASC";
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
                                                    $SQLFILTRO="SELECT * FROM PA_OPR WHERE ID_OPR IN(SELECT ID_OPR FROM TR_TRN ".$F_FECHA." AND  ID_TRN IN(SELECT ID_TRN FROM TR_RTL) AND  ID_BSN_UN=".$FTIENDA.") ORDER BY CD_OPR ASC";
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
				
				$SQL="ALTER SESSION SET nls_date_format='DD-MM-YYYY HH24:MI:SS'";
				$RS = sqlsrv_query($conn, $SQL);
				//oci_execute($RS);


				$SQLA="SELECT * FROM AS_ITM WHERE ID_ITM=".$ARTICULO;
				$RSA = sqlsrv_query($conn, $SQLA);
				//oci_execute($RSA);
				if ($Row_A = sqlsrv_fetch_array($RSA)) {
					$B_CD_ITM=$Row_A['CD_ITM'];
					$B_NM_ITM=$Row_A['NM_ITM'];
					if(empty($B_NM_ITM)){$B_NM_ITM="SIN DESCRIPCION";}
					$SQLCB="SELECT * FROM ID_PS WHERE ID_ITM=".$ARTICULO;
					$RSCB = sqlsrv_query($conn, $SQLCB);
					//oci_execute($RSCB);
					$BARCODES="";
					while ($Row_CB = sqlsrv_fetch_array($RSCB)) {
						$BARCODES=$BARCODES.$Row_CB['ID_ITM_PS']." ";
					}
					if(empty($BARCODES)){$BARCODES="S/COD.BARRA";}
				}
				$ELARTICULO=$B_CD_ITM." | ".$B_NM_ITM." | ".$BARCODES;

				$CONSULTA="SELECT ID_TRN FROM TR_LTM_SLS_RTN WHERE ID_ITM=".$ARTICULO." AND ID_TRN IN(SELECT ID_TRN FROM TR_TRN ".$F_FECHA.$FILTRO_FLAGS.$FILTRO_TIENDA.$FILTRO_TERM.$FILTRO_OPERA.$FILTRO_MP.$FLT_ARTICULO.@$FILTRO_MPTEF." ) AND ID_TRN IN(SELECT ID_TRN FROM TR_RTL WHERE QU_UN_RTL_TRN>0) GROUP BY ID_TRN ";

				$RS = sqlsrv_query($conn, $CONSULTA);
				//oci_execute($RS);
				$TRX="";
				$TOTALREG=0;
				$TOTALVTA=0;
				while ($row_C = sqlsrv_fetch_array($RS)) {
					$TRX = $row_C['ID_TRN'];
					$TOTALREG=$TOTALREG+1;
					$S="SELECT * FROM TR_LTM_SLS_RTN WHERE ID_ITM=".$ARTICULO." AND ID_TRN=".$TRX;
					$RS2 = sqlsrv_query($conn, $S);
					//oci_execute($RS2);
					while ($row_TRX = sqlsrv_fetch_array($RS2)) {
						$TOTALVTA=$TOTALVTA+$row_TRX['MO_EXTND'];
					}
					$S="SELECT SUM(MO_EXTND) SUMATRX FROM TR_LTM_SLS_RTN WHERE ID_ITM=".$ARTICULO." AND ID_TRN=".$TRX;
					$RS2 = sqlsrv_query($conn, $S);
					//oci_execute($RS2);
					if ($row_TRX = sqlsrv_fetch_array($RS2)) {
						$SUMATRX=$row_TRX['SUMATRX'];
					}
					if($SUMATRX==0){$TOTALREG=$TOTALREG-1;}
				}
				$NUMTPAG = round($TOTALREG/$CTP,0);
				$RESTO=$TOTALREG%$CTP;
				$CUANTORESTO=round($RESTO/$CTP, 0);
				if($RESTO>0 and $CUANTORESTO==0) {$NUMTPAG=$NUMTPAG+1;}
				$NUMPAG = round($LSUP/$CTP,0);
				if ($NUMTPAG==0) {
					$NUMTPAG=1;
					}
				$VAL_TOTALVTA=$TOTALVTA;
				$TOTALVTA=$TOTALVTA/$DIVCENTS;
				$TOTALVTA=number_format($TOTALVTA, $CENTS, $GLBSDEC, $GLBSMIL);

								
				//$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM TR_TRN ".$F_FECHA." ".$FILTRO_FLAGS." AND  ID_TRN IN(SELECT ID_TRN FROM TR_RTL WHERE QU_UN_RTL_TRN>0) ".$FILTRO_TIENDA.$FILTRO_TERM.$FILTRO_OPERA.$FILTRO_MP.$FLT_ARTICULO.$FILTRO_MPTEF." ORDER BY ID_TRN  DESC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;
				$RS = sqlsrv_query($conn, $CONSULTA);
				//oci_execute($RS);

				$CONSULTA= "SELECT * FROM (SELECT ,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY ID_TRN DESC) ROWNUMBER FROM TR_TRN WHERE ROWNUM <= ".$LSUP."  AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";//REVISAR
               ?>
               
               <h3>Art&iacute;culo: <?php echo $ELARTICULO;?></h3>
               <?php if($VAL_TOTALVTA>=1){?>
               <p class="ArtsBubble">N&deg; TRX: <?php echo $TOTALREG;?> / <?php echo $MONEDA.$TOTALVTA;?></p>
                <table id="Listado">
                <tr>
                    <th>Local</th>
                    <th>Terminal</th>
                    <th>Operador</th>
                    <th>TRX</th>
                    <th>Pago</th>
                    <th>Cantidad</th>
                    <th>Monto</th>
                    <th>Fecha Venta</th>
                    <th style="border-left-width:3px; border-left-style:solid; border-left-color:#DFDFDF">Fecha TRX</th>
                    <th>Inicio TRX</th>
                    <th>T&eacute;rmino TRX</th>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){
                        $ID_TRN = $row['ID_TRN'];
                        $AI_TRN = $row['AI_TRN'];
								$S2="SELECT * FROM TR_RTL WHERE ID_TRN=".$ID_TRN;
								$RS2 = sqlsrv_query($conn, $S2);
								//oci_execute($RS2);
								if ($row2 = sqlsrv_fetch_array($RS2)) {
									$ID_CNY = $row2['ID_CNY'];
								}
								$FECHA_TICKET = $row['DC_DY_BSN'];
										$RES_TICKET=explode(" ",$FECHA_TICKET);
										$TS_TICKET=$RES_TICKET[0];


								if(empty($CANT_ITEMS)){$CANT_ITEMS="NR";}
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
								$S2="SELECT ID_TND  FROM TR_LTM_TND WHERE ID_TRN=".$ID_TRN." ".$FPAGO." GROUP BY ID_TND ";
								$RS2 = sqlsrv_query($conn, $S2);
								//oci_execute($RS2);
								$MEDIODEPAGO="";
								while ($row2 = sqlsrv_fetch_array($RS2)) {
									$ID_TND = $row2['ID_TND'];
										$S3="SELECT DE_TND FROM AS_TND WHERE ID_TND=".$ID_TND;
										$RS3 = sqlsrv_query($conn, $S3);
										//oci_execute($RS3);
										if ($row3 = sqlsrv_fetch_array($RS3)) {
											$MEDIODEPAGO = $MEDIODEPAGO." ".$row3['DE_TND']."/ ";
										}
										if(empty($MEDIODEPAGO)) {$MEDIODEPAGO="NO DEFINIDO:";}
								}	
								$TIPO_MEDPAGO = $MEDIODEPAGO;
									
								$IMPORTE=0;
								$CANT_ITEMS=0;
								$S2="SELECT MO_EXTND, QU_ITM_LM_RTN_SLS  FROM TR_LTM_SLS_RTN WHERE ID_TRN=".$ID_TRN." AND ID_ITM=".$ARTICULO." ";
								$RS2 = sqlsrv_query($conn, $S2);
								//oci_execute($RS2);
								while ($row2 = sqlsrv_fetch_array($RS2)) {
									$MNT_ITM=$row2['MO_EXTND'];
									$QTN_ITM=$row2['QU_ITM_LM_RTN_SLS'];
									if($MNT_ITM<0){ $QTN_ITM=$QTN_ITM*-1;}
									$IMPORTE = $IMPORTE+$MNT_ITM;
									$CANT_ITEMS = $CANT_ITEMS+$QTN_ITM;
								}	
								$IMPORTE=$IMPORTE/$DIVCENTS;
								$IMPORTE=number_format($IMPORTE, $CENTS, $GLBSDEC, $GLBSMIL);

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
									$CODTIENDA = $row2['CD_STR_RT'];
									$NUMLOCAL = substr("0000".$FLTCOD_TIENDA, -4);
								}	
                        $DC_DY_BSN = $row['DC_DY_BSN'];
								$RES_BSN=explode(" ",$DC_DY_BSN);
								$DC_DY_BSN=$RES_BSN[0];

                        $TS_TRN_BGN = $row['TS_TRN_BGN'];
								$RES_BGN=explode(" ",$TS_TRN_BGN);
								$TS_TRN_BGN=$RES_BGN[1];
                        $TS_TRN_END =  $row['TS_TRN_END'];
								$RES_END=explode(" ",$TS_TRN_END);
								$TS_TRN_END=$RES_END[1];
					if($CANT_ITEMS>=1){
				   ?>
					<tr>
						<td><?php echo $NUMLOCAL?></td>
						<td style="text-align:right"><?php echo $TERMINAL?></td>
						<td><?php echo $OPERADOR?></td>
						<td style="text-align:right"><?php echo $AI_TRN?></td>
						<td><?php echo $TIPO_MEDPAGO?></td>
						<td style="text-align:right"><?php echo $CANT_ITEMS?></td>
						<td style="text-align:right"><?php echo $MONEDA.$IMPORTE?></td>
						<td style="text-align:right"><?php echo $TS_TICKET?></td>
						<td style="border-left-width:3px; border-left-style:solid; border-left-color:#DFDFDF"><?php echo $DC_DY_BSN?></td>
						<td style="text-align:right"><?php echo $TS_TRN_BGN?></td>
						<td style="text-align:right"><?php echo $TS_TRN_END?></td>
					</tr>
					<?php
					}
				}
				?>
                <tr>
                    <td colspan="11" nowrap style="background-color:transparent">
                    <?php
                    if ($LINF>=$CTP+1) {
						$ATRAS=$LINF-$CTP;
						$FILA_ANT=$LSUP-$CTP;
                   ?>
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('reg_articulos.php?LSUP=<?php echo $FILA_ANT?>&LINF=<?php echo $ATRAS?>&FTIENDA=<?php echo $FTIENDA?>&FTERM=<?php echo $FTERM?>&FOPERA=<?php echo $FOPERA?>&DIA_ED=<?php echo $DIA_ED ?>&MES_ED=<?php echo $MES_ED ?>&ANO_ED=<?php echo $ANO_ED ?>&DIA_EH=<?php echo $DIA_EH ?>&MES_EH=<?php echo $MES_EH ?>&ANO_EH=<?php echo $ANO_EH ?>&LIST=1&ARTICULO=<?php echo $ARTICULO;?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('reg_articulos.php?LSUP=<?php echo $FILA_POS?>&LINF=<?php echo $ADELANTE?>&FTIENDA=<?php echo $FTIENDA?>&FTERM=<?php echo $FTERM?>&FOPERA=<?php echo $FOPERA?>&DIA_ED=<?php echo $DIA_ED ?>&MES_ED=<?php echo $MES_ED ?>&ANO_ED=<?php echo $ANO_ED ?>&DIA_EH=<?php echo $DIA_EH ?>&MES_EH=<?php echo $MES_EH ?>&ANO_EH=<?php echo $ANO_EH ?>&LIST=1&ARTICULO=<?php echo $ARTICULO;?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina <?php echo $NUMPAG?> de <?php echo $NUMTPAG?></span>
                    </td>
                </tr>
                </table>
			   <?php } else {//if($VAL_TOTALVTA>=1){?>
               <h4>Art&iacute;culo no registra transacciones de venta</h4>
               <?php }?>

<?php } //$LIST=1 ?>                
                
                
                
                
                
<?php sqlsrv_close($conn);?>
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

