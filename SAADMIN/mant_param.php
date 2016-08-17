<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1173;
	$LIST=@$_GET["LIST"];
	$NEO=@$_GET["NEO"];
	$ACT=@$_GET["ACT"];
	if ($NEO=="" and $ACT=="") {
		 $LIST=1;
	}
	$FLT_DES="";
	$DES_PARAM=@$_POST["DES_PARAM"];
	if (empty($DES_PARAM)) {$DES_PARAM=@$_GET["DES_PARAM"];}
	if (!empty($DES_PARAM)) {
		$FLT_DES=" AND COD_PARAM IN(SELECT COD_PARAM FROM PM_PARAM WHERE DES_PARAM Like '%".strtoupper($DES_PARAM)."%' )";
		}

	$FLT_AMB="";
	$BSC_PARAM=@$_POST["BSC_PARAM"];
	if (empty($BSC_PARAM)) {$BSC_PARAM=@$_GET["BSC_PARAM"];}
	if (empty($BSC_PARAM)) {$BSC_PARAM=0;}
	if ($BSC_PARAM!=0) {
		$FLT_AMB=" AND COD_PARAM IN(SELECT COD_PARAM FROM PM_PARAM WHERE AMBITO=".$BSC_PARAM.")";
		}
	$FLT_STR="";
	$BSC_STORE=@$_POST["BSC_STORE"];
	if (empty($BSC_STORE)) {$BSC_STORE=@$_GET["BSC_STORE"];}
	if (empty($BSC_STORE)) {$BSC_STORE=9999;}
	if ($BSC_STORE!=9999) {
			$FLT_STR=" AND DES_CLAVE=".$BSC_STORE;
		} else {
			$FLT_STR=" AND DES_CLAVE IS NULL";
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
<?php
if ($MSJE==1) {
$ELMSJ="Registro actualizado";
} 
if ($MSJE == 2) {
$ELMSJ="Nombre y/o Enlace no disponibles, verifique";
} 
if ($MSJE == 3) {
$ELMSJ="Registro realizado";
}
if ($MSJE == 4) {
$ELMSJ="Registro eliminado";
}
if ($MSJE == 5) {
$ELMSJ="Par&aacute;metro previamente registrado, verifique";
}
if ($MSJE <> "") {
?>
<div id="GMessaje" onClick="QuitarGMessage();"><a href="#" onClick="QuitarGMessage();" style="color:#111111;"><?=$ELMSJ?></a></div>
<?php }?>
        <table width="100%">
        <tr><td>
        <h2><?=$LAPAGINA?></h2>
<?php if ($LIST==1) { ?>
        <table width="100%" id="Filtro">
          <tr>
            <td>
                <form action="mant_param.php" method="post" name="frmbuscar" id="frmbuscar">
                			<input style="text-transform:uppercase" type="text" id="DES_PARAM" name="DES_PARAM" value="<?= $DES_PARAM?>">
                            <input type="submit" id="BSC_DES" value="Buscar Par&aacute;metro">
                            <select name="BSC_PARAM" onChange="document.forms.frmbuscar.submit();">
                                            <option value="0">&Aacute;mbito</option>
                                            <option value="1" <?php  if ($BSC_PARAM==1) { echo "SELECTED";}?>>Suite ARMS</option>
                                            <option value="2" <?php  if ($BSC_PARAM==2) { echo "SELECTED";}?>>Directorio Interfases</option>
                                            <option value="3" <?php  if ($BSC_PARAM==3) { echo "SELECTED";}?>>Properties ARMS Agent</option>
                                            <option value="4" <?php  if ($BSC_PARAM==4) { echo "SELECTED";}?>>Properties ARMS Server</option>
                            </select>
                                <select name="BSC_STORE" onChange="document.forms.frmbuscar.submit();">
                                            <option value="9999">Gen&eacute;rico</option>
                                            <?php
											$SQL="SELECT DES_CLAVE FROM PM_PARVAL WHERE DES_CLAVE IS NOT NULL GROUP BY DES_CLAVE ORDER BY DES_CLAVE ASC";
											
                                            //$RS2 = sqlsrv_query($conn, $SQL);
											////oci_execute($RS2);
                                            $RS2 = sqlsrv_query($conn,$SQL);
											
                                            while ($row = sqlsrv_fetch_array($RS2)) {
													$DES_CLAVE=$row['DES_CLAVE'];
											?>
                                                <option value="<?= $DES_CLAVE?>" <?php  if ($BSC_STORE==$DES_CLAVE) { echo "SELECTED";}?>><?= $DES_CLAVE?></option>
                                            <?php
											}
											?>
                            </select>
                </form>

              </td>
              </tr>
              </table>
<?php }?>
                <table style="margin:10px 20px; ">
                <tr>
                <td>
<?php if ($LIST==1) { ?>
                <?php
				$CONSULTA="SELECT COUNT(*) AS CUENTA FROM PM_PARVAL WHERE ID_PARVAL<>0 ".$FLT_AMB.$FLT_STR.$FLT_DES." ";
				
                //$RS = sqlsrv_query($conn, $CONSULTA);
				////oci_execute($RS);
				$RS = sqlsrv_query($conn,$CONSULTA);

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



                 $CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY ID_PARVAL DESC) ROWNUMBER FROM PM_PARVAL WHERE ID_PARVAL <> 0 ".$FLT_AMB.$FLT_STR.$FLT_DES.") AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";
                
				
                //$RS = sqlsrv_query($conn, $CONSULTA);
				////oci_execute($RS);
                $RS = sqlsrv_query($conn,$CONSULTA);
               ?>
                <table id="Listado">
                <tr>
                    <th>Par&aacute;metro<br>&Aacute;mbito [Local]</th>
                    <th>Variable/Key [Tipo]<br>Valor</th>
                    <th>Estado</th>
                    <th>Registrado por</th>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){
						$ID_PARVAL = $row['ID_PARVAL'];
						$COD_PARAM = $row['COD_PARAM'];
						$VAL_PARAM = $row['VAL_PARAM'];
						$DES_CLAVE = $row['DES_CLAVE'];
						if(is_null($DES_CLAVE)){ $LATIENDA="Gen&eacute;rico";} else { $LATIENDA=$DES_CLAVE;}
						$ESTADO = $row['ESTADO'];
						if ($ESTADO==0) {
							$ELIND_ACTIVO="Bloqueado"; 
							$COLORTD="#F44336";}
						if ($ESTADO==1) {
							$ELIND_ACTIVO="Activo"; 
							$COLORTD="#4CAF50";}
						$IDREG = $row['IDREG'];
						$CONSULTA3="SELECT NOMBRE FROM US_USUARIOS WHERE IDUSU=".$IDREG;
						
                        //$RS3 = sqlsrv_query($conn, $CONSULTA3);
						////oci_execute($RS3);
                        $RS3 = sqlsrv_query($conn,$CONSULTA3);
						
                        if ($row3 = sqlsrv_fetch_array($RS3)) {
							$QUIENFUE = $row3['NOMBRE'];
						}	
						
                        @$date = date_create($row2['FECHA']);
                        $FECHA = @date_format($date, 'd/m/Y');
                        


						$SQLVAL="SELECT * FROM PM_PARAM WHERE COD_PARAM=".$COD_PARAM;

						//$RS2 = sqlsrv_query($conn, $SQLVAL);
						////oci_execute($RS2);
                        $RS2 = sqlsrv_query($conn,$SQLVAL);
						
                        if ($row2 = sqlsrv_fetch_array($RS2)) {
								$COD_PARAM = $row2['COD_PARAM'];
								$DES_PARAM = $row2['DES_PARAM'];
								$VAR_PARAM = $row2['VAR_PARAM'];
								$TIP_PARAM = $row2['TIP_PARAM'];
								if ($TIP_PARAM==0) {
									$ELTIPO="VARCHAR2"; }
								if ($TIP_PARAM==1) {
									$ELTIPO="NUMBER"; }
								$AMBITO = $row2['AMBITO'];
								if ($AMBITO==1) {
									$ELAMBITO="Suite ARMS"; }
								if ($AMBITO==2) {
									$ELAMBITO="Directorio Interfases"; }
								if ($AMBITO==3) {
									$ELAMBITO="Properties ARMS Agent"; }
								if ($AMBITO==4) {
									$ELAMBITO="Properties ARMS Server"; }
						}


               ?>
                <tr>
                    <?php if($SESPUBLICA==1) { ?>
                    <td style="max-width:600px; min-width:400px"><a href="mant_param.php?ACT=<?=$ID_PARVAL?>"><?=$DES_PARAM?></a><br><?=$ELAMBITO?> [<?=$LATIENDA?>]</td>
                    <?php } else {?>
                     <td style="max-width:600px; min-width:400px"><?=$DES_PARAM?><br><?=$ELAMBITO?> [<?=$LATIENDA?>]</td>
                    <?php } ?>
                    <td style="max-width:600px;"><span style="font-weight:600;"><?=$VAR_PARAM?></span> <span style="font-size:9pt">[<?=$ELTIPO?>]</span><br><p style="word-wrap: break-word;"><?=$VAL_PARAM?></p></td>
                    <td style="background:<?=$COLORTD?>; color:#FFF"><?=$ELIND_ACTIVO?></td>
                    <td><?=$QUIENFUE.", ".$FECHA?></td>
                </tr>
                <?php
				}
				?>
                <tr>
                    <td colspan="4" nowrap style="background-color:transparent">
                    <?php
                    if ($LINF>=$CTP+1) {
						$ATRAS=$LINF-$CTP;
						$FILA_ANT=$LSUP-$CTP;
                   ?>
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('mant_param.php?LSUP=<?=$FILA_ANT?>&LINF=<?=$ATRAS?>&BSC_PARAM=<?=$BSC_PARAM?>&BSC_STORE=<?=$BSC_STORE?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('mant_param.php?LSUP=<?=$FILA_POS?>&LINF=<?=$ADELANTE?>&BSC_PARAM=<?=$BSC_PARAM?>&BSC_STORE=<?=$BSC_STORE?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina <?=$NUMPAG?> de <?=$NUMTPAG?></span>
                    </td>
                </tr>
                </table>
<?php }?>
<?php  if ($NEO==1) { ?>
                <table id="forma-registro">
                    <form action="mant_param_reg.php" method="post" name="formact" onSubmit="return validaParametros(this)">
                    <tr>
                        <td> <label for="DES_PARAM">Descripci&oacute;n</label> </td>
                        <td><input name="DES_PARAM" type="text" size="40" maxlength="200"></td>
                    </tr>
                    <tr>
                        <td> <label for="VAR_PARAM">Variable <span style="font-weight:400">(SuiteARMS)</span><br>Key <span style="font-weight:400">(Properties ARMS)</span></label> </td>
                        <td><input name="VAR_PARAM" type="text" size="40" maxlength="200"></td>
                    </tr>
                    <tr>
                        <td> <label for="VAL_PARAM">Valor</label> </td>
                        <td><input name="VAL_PARAM" type="text" size="60" maxlength="600"></td>
                    </tr>
                    <tr>
                        <td><label for="TIP_PARAM">Tipo</label> </td>
                       <td><select name="TIP_PARAM">
                        <option value="0">VARCHAR2(600)</option>
                        <option value="1">NUMBER</option>
                        </select></td>
                    </tr>
                    <tr>
                        <td><label for="AMBITO">&Aacute;mbito</label> </td>
                       <td><select name="AMBITO">
                        <option value="0">Seleccionar</option>
                        <option value="1">Suite ARMS</option>
                        <option value="2">Directorio Interfases</option>
                        <option value="3">Properties ARMS Agent</option>
                        <option value="4">Properties ARMS Server</option>
                        </select></td>
                    </tr>
                    <tr>
                        <td><label for="ESTADO">Estado</label> </td>
                       <td><select name="ESTADO">
                        <option value="0">Bloqueado</option>
                        <option value="1">Activo</option>
                        </select></td>
                    </tr>
                    <tr>
                        <td>
                        <td>
                        <input name="INGRESAR" type="submit" value="Registrar">
                        <input type="reset" value="Limpiar">
                        <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_param.php')">
                        </td>
                    </tr>
                    </form>
                </table>
<?php }?>


<?php  if ($ACT<>"") { 


				$CONSULTA="SELECT * FROM PM_PARVAL WHERE ID_PARVAL=".$ACT;
				
                //$RS = sqlsrv_query($conn, $CONSULTA);
				////oci_execute($RS);
                $RS = sqlsrv_query($conn,$CONSULTA);
				
                if ($row = sqlsrv_fetch_array($RS)) {
					$ID_PARVAL = $row['ID_PARVAL'];
					$COD_PARAM = $row['COD_PARAM'];
					$DES_CLAVE = $row['DES_CLAVE'];
					$VAL_PARAM = $row['VAL_PARAM'];
					$ESTADO = $row['ESTADO'];
					$SQLV="SELECT * FROM PM_PARAM WHERE COD_PARAM=".$COD_PARAM;
					
                    //$RSV = sqlsrv_query($conn, $SQLV);
					////oci_execute($RSV);
                    $RSV = sqlsrv_query($conn,$SQLV);
					
                    if ($rowV = sqlsrv_fetch_array($RSV)) {
							$COD_PARAM = $rowV['COD_PARAM'];
							$DES_PARAM = $rowV['DES_PARAM'];
							$VAR_PARAM = $rowV['VAR_PARAM'];
							$TIP_PARAM = $rowV['TIP_PARAM'];
							$AMBITO = $rowV['AMBITO'];
								if ($TIP_PARAM==0) {
									$ELTIPO="VARCHAR2"; }
								if ($TIP_PARAM==1) {
									$ELTIPO="NUMBER"; }
								if ($AMBITO==1) {
									$ELAMBITO="Suite ARMS"; }
								if ($AMBITO==2) {
									$ELAMBITO="Directorio Interfases"; }
								if ($AMBITO==3) {
									$ELAMBITO="Properties ARMS Agent"; }
								if ($AMBITO==4) {
									$ELAMBITO="Properties ARMS Server"; }
					}
                }
				
				
				
				//VERIFICAR DES_CLAVE
				//SI DES_CLAVE ES NULL: GENERICO, SI NO: VARIABLE LOCAL
				if(is_null($DES_CLAVE)){
					$ES_GENERICO=1;
				} else {
					$ES_GENERICO=0;
				}
				
				
               ?>
                <h3>Actualizar: <?=$DES_PARAM?></h3>
                <table id="forma-registro">
                <?php if($ES_GENERICO==1){?>
                    <form action="mant_param_reg.php" method="post" name="formact" onSubmit="return validaParametros(this)">
                    <tr>
                        <td> <label for="DES_PARAM">Descripci&oacute;n</label> </td>
                        <td><input name="DES_PARAM" type="text" size="40" maxlength="200" value="<?=$DES_PARAM?>"></td>
                    </tr>
                    <tr>
                        <td> <label for="VAR_PARAM">Variable <span style="font-weight:400">(SuiteARMS)</span><br>Key <span style="font-weight:400">(Properties ARMS)</span></label> </td>
                        <td><input name="VAR_PARAM" type="text" size="40" maxlength="200" value="<?=$VAR_PARAM?>"></td>
                    </tr>
                    <tr>
                        <td> <label for="VAL_PARAM">Valor</label> </td>
                        <td><input name="VAL_PARAM" type="text" size="60" maxlength="600" value="<?=$VAL_PARAM?>"></td>
                    </tr>
                    <tr>
                        <td><label for="TIP_PARAM">Tipo</label> </td>
                       <td><input type="hidden" name="TIP_PARAM" value="<?= $TIP_PARAM?>"> <?= $ELTIPO?></td>
                    </tr>
                    <tr>
                        <td><label for="AMBITO">&Aacute;mbito</label> </td>
                       <td><input type="hidden" name="AMBITO" value="<?= $AMBITO?>"> <?= $ELAMBITO?></td>
                    </tr>
                    <tr>
                        <td><label for="ESTADO">Estado</label> </td>
                       <td><select name="ESTADO">
                        <option value="0" <?php if ($ESTADO==0) { echo "SELECTED";}?>>Bloqueado</option>
                        <option value="1" <?php if ($ESTADO==1) { echo "SELECTED";}?>>Activo</option>
                        </select></td>
                    </tr>
                    <tr>
                        <td><input name="COD_PARAM" type="hidden" value="<?=$COD_PARAM?>">
                        <input name="ID_PARVAL" type="hidden" value="<?=$ID_PARVAL?>">
                        <td>
                        <input name="ACTUALIZAR" type="submit" value="Actualizar">
                        <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_param.php')">
                        </td>
                    </tr>
                    </form>
                    <tr>
                    <td colspan="2"><h3>Registrar Par&aacute;metro de Tienda</h3></td>
                    </tr>
                    <form action="mant_param_reg.php" method="post" name="formact" onSubmit="return validaValParam(this)">
                    <tr>
                        <td><label for="DES_CLAVE">Local</label> </td>
                       	<td>
                            <select id="DES_CLAVE" name="DES_CLAVE">
                                <option value="9999">Seleccionar</option>
                                <?php
                                    $SQL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA<>0 ORDER BY DES_CLAVE ASC";
                                    
                                    //$RS = sqlsrv_query($conn, $SQL);
                                    ////oci_execute($RS);
                                    $RS = sqlsrv_query($conn,$SQL);

                                    while ($row = sqlsrv_fetch_array($RS)) {
                                        $NUM_TIENDA = $row['DES_CLAVE'];
                                        $DES_TIENDA = $row['DES_TIENDA'];
                                         ?>
                                        <option value="<?php echo $NUM_TIENDA?>"  <?php if ($NUM_TIENDA==$DES_CLAVE) { echo "SELECTED";}?>><?=$NUM_TIENDA." - ".$DES_TIENDA;?></option>
                                        <?php 
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td> <label for="NEOVAL_PARAM">Valor</label> </td>
                        <td><input name="NEOVAL_PARAM" type="text" size="60" maxlength="600" ></td>
                    </tr>
                    <tr>
                        <td><label for="ESTADO">Estado</label> </td>
                       <td><select name="ESTADO">
                        <option value="0" <?php if ($ESTADO==0) { echo "SELECTED";}?>>Bloqueado</option>
                        <option value="1" <?php if ($ESTADO==1) { echo "SELECTED";}?>>Activo</option>
                        </select></td>
                    </tr>
                    <tr>
                        <td>
                        <input name="COD_PARAM" type="hidden" value="<?=$COD_PARAM?>">
                        <td>
                        <input name="AGREGAVAL" type="submit" value="Agregar Valor Local">
                        </td>
                    </tr>
                    </form>
                <?php } else {?>
                    <tr>
                        <td> <label for="DES_PARAM">Descripci&oacute;n</label> </td>
                        <td><?=$DES_PARAM?>"</td>
                    </tr>
                    <tr>
                        <td> <label for="VAR_PARAM">Variable <span style="font-weight:400">(SuiteARMS)</span><br>Key <span style="font-weight:400">(Properties ARMS)</span></label> </td>
                        <td><?=$VAR_PARAM?></td>
                    </tr>
                    <tr>
                        <td><label for="TIP_PARAM">Tipo</label> </td>
                       <td><?= $ELTIPO?></td>
                    </tr>
                    <tr>
                        <td><label for="AMBITO">&Aacute;mbito</label> </td>
                       <td><?= $ELAMBITO?></td>
                    </tr>
                    <form action="mant_param_reg.php" method="post" name="formact" onSubmit="return validaValParam(this)">
                    <tr>
                        <td><label for="DES_CLAVE">Local</label> </td>
                       	<td><?= $DES_CLAVE?> </td>
                    </tr>
                    <tr>
                        <td> <label for="ACTVAL_PARAM">Valor</label> </td>
                        <td><input name="ACTVAL_PARAM" type="text" size="60" maxlength="600"  value="<?= $VAL_PARAM?>"></td>
                    </tr>
                    <tr>
                        <td><label for="ESTADO">Estado</label> </td>
                       <td><select name="ESTADO">
                        <option value="0" <?php if ($ESTADO==0) { echo "SELECTED";}?>>Bloqueado</option>
                        <option value="1" <?php if ($ESTADO==1) { echo "SELECTED";}?>>Activo</option>
                        </select></td>
                    </tr>
                    <tr>
                        <td>
                        <input name="ID_PARVAL" type="hidden" value="<?=$ID_PARVAL?>">
                        <td>
                        <input name="UPDATEVAL" type="submit" value="Actualizar Valor Local">
                        </td>
                    </tr>
                    </form>
                <?php }?>
                </table>
<?php }?>
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
//sqlsrv_close($conn); 
sqlsrv_close( $conn );
?>
