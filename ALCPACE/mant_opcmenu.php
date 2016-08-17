
<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1176;
	$LINK=0;
	$LIST=@$_GET["LIST"];
	$NEO=@$_GET["NEO"];
	$ACT=@$_GET["ACT"];
	if ($NEO=="" and $ACT=="") {
		 $LIST=1;
	}
	$FILTRO="";
	$BSC_OPC=@$_POST["BSC_OPC"];
	if (empty($BSC_OPC)) {$BSC_OPC=@$_GET["BSC_OPC"];}
	if (!empty($BSC_OPC)) {
		$FILTRO=" AND (UPPER(TRIM(DES_ES)) Like '%".strtoupper($BSC_OPC)."%' OR UPPER(TRIM(DES_EN))  Like '%".strtoupper($BSC_OPC)."%')";
		}

	$FILTRO1="";
	$FLT_NVL1=@$_POST["FLT_NVL1"];
	if (empty($FLT_NVL1)) {$FLT_NVL1=@$_GET["FLT_NVL1"];}
	if (empty($FLT_NVL1)) {$FLT_NVL1=0;}
	if ($FLT_NVL1!=0) {
		$FILTRO1=" AND COD_NVL2=".$FLT_NVL1;
	}
	$FILTRO2="";
	$FLT_NVL2=@$_POST["FLT_NVL2"];
	if (empty($FLT_NVL2)) {$FLT_NVL2=@$_GET["FLT_NVL2"];}
	if (empty($FLT_NVL2)) {$FLT_NVL2=0;}
	$FILTRO2=" AND COD_NVL3=".$FLT_NVL2;

	if ($FLT_NVL1!=0 and $FLT_NVL2!=0) {
			$SQL="SELECT * FROM PA_OPCMENU WHERE COD_NVL2=".$FLT_NVL1." AND COD_NVL3=".$FLT_NVL2." ORDER BY COD_NVL1 ASC";
			$RS = sqlsrv_query($conn, $SQL);
			//oci_execute($RS);
			if($row = sqlsrv_fetch_array($RS)) {
				$FILTRO2=" AND COD_NVL3=".$FLT_NVL2;
			} else {
				$FLT_NVL2=0;
				$FILTRO2="";
				$MSJE=1;
			}
	}


	$ACTPOS=@$_POST["ACTPOS"];
	if ($ACTPOS!="") {
			$POSICION=@$_POST["POS".$ACTPOS];
			$SQL="UPDATE PA_OPCMENU SET POSICION=".$POSICION.", IDREG=".$SESIDUSU.", FECHA='".$FECSRV."' WHERE COD_NVL1=".$ACTPOS;
			$RS2 = sqlsrv_query($conn, $SQL);
			//oci_execute($RS2);
	}


?>
</head>
<body>

<?php include("encabezado.php");?>
<?php include("titulo_menu.php");?>

<table width="100%" height="100%">
<tr>
        <td align="right"  width="200" bgcolor="#FFFFFF"><?php include("menugeneral.php");?></td> 
<td>
<?php
if ($MSJE==1) {$ELMSJ="Registro realizado";} 
if ($MSJE==2) {$ELMSJ="Registro actualizado";} 
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
                <form action="mant_opcmenu.php" method="post" name="frmbuscar" id="frmbuscar">
							<label for="FLT_NVL1">FN1</label>
                            <select name="FLT_NVL1" onChange="document.forms.frmbuscar.submit(); CargaFN2(this.value, this.form.name, 'FLT_NVL2');">
                                            <option value="0">Seleccionar</option>
                                            <?php
											$SQL="SELECT * FROM PA_OPCMENU WHERE COD_NVL2=0 AND COD_NVL3=0 ORDER BY COD_NVL1 ASC";
											$RS = sqlsrv_query($conn, $SQL);
											//oci_execute($RS);
											while($row = sqlsrv_fetch_array($RS)) {
												$COD_NVL1 = $row['COD_NVL1'];
												$DES_ES1 = $row['DES_ES'];
											?>
                                            <option value="<?=$COD_NVL1?>" <?php if($COD_NVL1==$FLT_NVL1){echo "Selected";}?>><?=$DES_ES1?></option>
                                            <?php
											}	
											?>
                            </select>
							<label for="FLT_NVL2">FN2</label>
                            <select name="FLT_NVL2" onChange="document.forms.frmbuscar.submit(); ">
                                            <option value="0">Seleccionar</option>
                                            <?php
											if($FLT_NVL1!=0){
											$SQL="SELECT * FROM PA_OPCMENU WHERE COD_NVL2=".$FLT_NVL1." AND COD_NVL3=0 ORDER BY COD_NVL1 ASC";
											$RS = sqlsrv_query($conn, $SQL);
											//oci_execute($RS);
											while($row = sqlsrv_fetch_array($RS)) {
												$COD_NVL1 = $row['COD_NVL1'];
												$DES_ES2 = $row['DES_ES'];
											?>
                                            <option value="<?=$COD_NVL1?>" <?php if($COD_NVL1==$FLT_NVL2){echo "Selected";}?>><?=$DES_ES2?></option>
                                            <?php
											}
											}
											?>
                            </select>
							<label for="BSC_OPC">Opci&oacute;n</label>
                            <input type="text" name="BSC_OPC" style="text-transform:uppercase">
                            <input type="submit" name="BTN_BSC" value="Buscar">
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
				$CONSULTA="SELECT COUNT(COD_NVL1) AS CUENTA FROM PA_OPCMENU WHERE COD_NVL1<>0 ".$FILTRO.$FILTRO1.$FILTRO2;
				//echo $CONSULTA;
				$RS = sqlsrv_query($conn,$CONSULTA);
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

				//$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM PA_OPCMENU WHERE COD_NVL1<>0 ".$FILTRO.$FILTRO1.$FILTRO2." ORDER BY COD_NVL1 ASC, POSICION ASC, COD_NVL2 ASC, COD_NVL3 ASC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;

				$CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY COD_NVL1 ASC) ROWNUMBER FROM PA_OPCMENU WHERE COD_NVL1<>0 ".$FILTRO.$FILTRO1.$FILTRO2.") AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";

				$RS = sqlsrv_query($conn, $CONSULTA);
				//oci_execute($RS);
               ?>
                <table id="Listado">
                <tr>
                    <th>Nivel</th>
                    <th>Nivel 1</th>
                    <th>Nivel 2</th>
                    <th>ES</th>
                    <th>EN</th>
                    <th>Publicaci&oacute;n </th>
                    <th>Posici&oacute;n</th>
                    <th>Forma</th>
                    <th>Registrado por</th>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){

                        $POSICION = $row['POSICION'];
                        $COD_NVL1 = $row['COD_NVL1'];
                        $COD_NVL2 = $row['COD_NVL2'];
                        $COD_NVL3 = $row['COD_NVL3'];
						$ELNIVEL1 = "";
						$ELNIVEL2 = "";
					
						if($COD_NVL3==0 and $COD_NVL2==0){$NIVEL=1;$ELNIVEL1="--"; $ELNIVEL2="--";}
						if($COD_NVL3==0 and $COD_NVL2<>0){
					
							$NIVEL=2;
							 $ELNIVEL2="--";
									$SQL="SELECT * FROM PA_OPCMENU WHERE COD_NVL1=".$COD_NVL2;
									$RS1 = sqlsrv_query($conn, $SQL);
									//oci_execute($RS1);
									if ($row1 = sqlsrv_fetch_array($RS1)) {
										$ELNIVEL1 = $row1['DES_ES'];
									}	
							}
						if($COD_NVL3<>0 and $COD_NVL2<>0){
							$NIVEL=3;
									$SQL="SELECT * FROM PA_OPCMENU WHERE COD_NVL1=".$COD_NVL2;
									$RS1 = sqlsrv_query($conn, $SQL);
									//oci_execute($RS1);
									if ($row1 = sqlsrv_fetch_array($RS1)) {
										$ELNIVEL1 = $row1['DES_ES'];
									}	
									$SQL="SELECT * FROM PA_OPCMENU WHERE COD_NVL1=".$COD_NVL3;
									$RS1 = sqlsrv_query($conn, $SQL);
									//oci_execute($RS1);
									if ($row1 = sqlsrv_fetch_array($RS1)) {
										$ELNIVEL2 = $row1['DES_ES'];
									}	
							}

                        $DES_ES = $row['DES_ES'];
                        $DES_EN = $row['DES_EN'];
                        //$DES_ES = utf8_encode($DES_ES);

						if($BSC_OPC!="") {
								$DES_ES=str_replace(strtoupper($BSC_OPC),'<span style="background-color:#FFF9C4;">'.strtoupper($BSC_OPC).'</span>', strtoupper($DES_ES)); 
								$DES_EN=str_replace(strtoupper($BSC_OPC),'<span style="background-color:#FFF9C4;">'.strtoupper($BSC_OPC).'</span>', strtoupper($DES_EN)); 
						}

                        $PUBLICA = $row['PUBLICA'];
						if ($PUBLICA==0) {
							$PUBLICADO="Deshabilitada"; }
						if ($PUBLICA==1) {
							$PUBLICADO="Activa"; }
                        $FORMA = $row['ARCHIVO'];
						if (empty($FORMA) or is_null($FORMA)) {$FORMA="No registra"; }
                        $IDREG = $row['IDREG'];
                        $FECHA = $row['FECHA'];
						$SQL="SELECT NOMBRE FROM US_USUARIOS WHERE IDUSU=".$IDREG;
						$RS1 = sqlsrv_query($maestra, $SQL);
						//oci_execute($RS1);
						if ($row1 = sqlsrv_fetch_array($RS1)) {
							$QUIENFUE = $row1['NOMBRE'];
						}	
               ?>
               <form action="mant_opcmenu.php?LSUP=<?=$LSUP?>&LINF=<?=$LINF?>&FLT_NVL1=<?=$FLT_NVL1?>&FLT_NVL2=<?=$FLT_NVL2?>&BSC_OPC=<?=$BSC_OPC?>" method="post" name="formpos<?=$COD_NVL1?>" id="formpos">
                    <tr>
                        <td style="font-size:16pt; font-weight:600; text-align:center; vertical-align:middle"><?=$NIVEL?></td>
                        <td><?=$ELNIVEL1?></td>
                        <td><?=$ELNIVEL2?></td>
                        <?php if($SESPUBLICA==1) { ?>
                        <td><a href="mant_opcmenu.php?ACT=<?=$COD_NVL1?>&NVL=<?=$NIVEL?>"><?=$DES_ES?></a></td>
                        <?php } else {?>
                         <td><?=$DES_ES?></td>
                        <?php } ?>
                        <td><?=$DES_EN?></td>
                        <td><?=$PUBLICADO?></td>
                        <td>
                        		<input style="width:50px; text-align:right; margin:0" type="text" name="POS<?=$COD_NVL1?>" maxlength="4" value="<?=$POSICION?>">
                                <input style="padding:6px 8px; margin:0" type="submit" name="ACTPOS" value="Cambiar">
                                <input type="hidden" name="ACTPOS" value="<?=$COD_NVL1?>">
                        </td>
                        <td><?=$FORMA?></td>

                        <td><?=$QUIENFUE.", ".date_format($FECHA,"d-m-Y")?></td>
                    </tr>
                </form>
                <?php
				}
				?>
                <tr>
                    <td colspan="9" nowrap style="background-color:transparent">
                    <?php
                    if ($LINF>=$CTP+1) {
						$ATRAS=$LINF-$CTP;
						$FILA_ANT=$LSUP-$CTP;
                   ?>
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('mant_opcmenu.php?LSUP=<?=$FILA_ANT?>&LINF=<?=$ATRAS?>&FLT_NVL1=<?=$FLT_NVL1?>&FLT_NVL2=<?=$FLT_NVL2?>&BSC_OPC=<?=$BSC_OPC?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('mant_opcmenu.php?LSUP=<?=$FILA_POS?>&LINF=<?=$ADELANTE?>&FLT_NVL1=<?=$FLT_NVL1?>&FLT_NVL2=<?=$FLT_NVL2?>&BSC_OPC=<?=$BSC_OPC?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina <?=$NUMPAG?> de <?=$NUMTPAG?></span>
                    </td>
                </tr>
                </table>
<?php }?>


<script>
function validaOpcion(theForm){
			if (theForm.NIVEL.value == 2){
					if (theForm.COD_NVL2.value == 0){
						alert("COMPLETE EL CAMPO REQUERIDO.");
						theForm.COD_NVL2.focus();
						return false;
					}
			}
			if (theForm.NIVEL.value == 3){
					if (theForm.COD_NVL2.value == 0){
						alert("COMPLETE EL CAMPO REQUERIDO.");
						theForm.COD_NVL2.focus();
						return false;
					}
					if (theForm.SELCOD_NVL3.value == 0){
						alert("COMPLETE EL CAMPO REQUERIDO.");
						theForm.SELCOD_NVL3.focus();
						return false;
					}
			}
		if (theForm.DES_ES.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.DES_ES.focus();
			return false;
		}
		if (theForm.DES_EN.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.DES_EN.focus();
			return false;
		}
} //validaOpcion(theForm)

function CargaElNivel(val){
			var CodNvl2 = document.getElementById("COD_NVL2");
			var CodNvl3 = document.getElementById("COD_NVL3");
			if(val==1){
				CodNvl2.style.display = "none";
				CodNvl3.style.display = "none";
			}
			if(val==2){
				CodNvl2.style.display = "table-row";
				CodNvl3.style.display = "none";
			}
			if(val==3){
				CodNvl2.style.display = "table-row";
				CodNvl3.style.display = "table-row";
			}
}
</script>
<?php  if ($NEO==1) { ?>
                <table id="forma-registro">
                        <form action="mant_opcmenu_reg.php" method="post" name="forming" id="forming" onSubmit="return validaOpcion(this)">
                        <tr>
                                       <td><label for="NIVEL">Nivel de Opci&oacute;n</label></td>
                                       <td><select id="NIVEL" name="NIVEL" onChange="CargaElNivel(this.value);">
                                        <option value="1">Nivel 1</option>
                                        <option value="2">Nivel 2</option>
                                        <option value="3">Nivel 3</option>
                                        </select></td>
                        </tr>
                        <tr id="COD_NVL2" style="display:none">
                                       <td><label for="COD_NVL2">Opci&oacute;n Nivel 1</label></td>
                                       <td><select id="COD_NVL2"  name="COD_NVL2" onChange="CargaNivel2(this.value, this.form.name, 'SELCOD_NVL3');">
                                        <option value="0">Seleccionar</option>
                                        <?php 
                                        $SQL="SELECT * FROM PA_OPCMENU WHERE COD_NVL2=0 AND COD_NVL3=0 ORDER BY COD_NVL1 ASC";
                                        $RS = sqlsrv_query($conn, $SQL);
                                        //oci_execute($RS);
                                        while ($row = sqlsrv_fetch_array($RS)) {
                                            $COD_NVL1 = $row['COD_NVL1'];
                                            $DES_ES1 = $row['DES_ES'];
                                         ?>
                                        <option value="<?=$COD_NVL1 ?>"><?=$DES_ES1 ?></option>
                                        <?php 
                                        }
                                         ?>
                                        </select></td>
                        </tr>
                        <tr id="COD_NVL3" style="display:none">
                                       <td><label for="SELCOD_NVL3">Opci&oacute;n Nivel 2</label></td>
                                       <td><select id="SELCOD_NVL3" name="SELCOD_NVL3">
                                        <option value="0">Seleccionar</option>
                                        </select></td>
                        </tr>
                        <tr>
                                    <td><label for="DES_ES">Descripci&oacute;n Espa&ntilde;ol </label></td>
                                    <td><input id="DES_ES" name="DES_ES" type="text" size="40" maxlength="200" > </td>
                        </tr>
                        <tr>
                                    <td><label for="DES_EN">Descripci&oacute;n Ingl&eacute;s </label></td>
                                    <td><input id="DES_EN" name="DES_EN" type="text" size="40" maxlength="200" > </td>
                        </tr>
                        <tr>
                                   <td><label for="PUBLICA">Publicar</label></td>
                                   <td><select name="PUBLICA">
                                    <option value="0">NO</option>
                                    <option value="1">SI</option>
                                    </select></td>
                        </tr>
                        <tr>
                                <td><label for="ARCHIVO">Forma PHP</label></td>
                                <td><input name="ARCHIVO" type="text" size="40" maxlength="200" > </td>
                        </tr>
                        <tr>
                               <td></td>
                               <td><input name="INGRESAR" type="submit" value="Registrar">
                                <input name="LIMPIAR" type="reset" value="Limpiar">
                                <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_opcmenu.php')"></td>
                        </tr>
                        </form>
                </table>
<?php }?>
<?php  if ($ACT<>"") {
	 
				$NIVEL=@$_GET["NVL"];
				$SQL="SELECT * FROM PA_OPCMENU WHERE COD_NVL1=".$ACT;
				$RS = sqlsrv_query($conn, $SQL);
				//oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {
					$COD_NVL2 = $row['COD_NVL2'];
					$COD_NVL3 = $row['COD_NVL3'];
					$DES_ES = $row['DES_ES'];
					$DES_EN = $row['DES_EN'];
					$PUBLICA = $row['PUBLICA'];
					$ARCHIVO = $row['ARCHIVO'];
				}

               ?>
                <h3>Actualizar: <?=$DES_ES."/ ".$DES_EN?></h3>
                <table id="forma-registro">
                        <form action="mant_opcmenu_reg.php" method="post" name="formact" id="formact" onSubmit="return validaOpcion(this)">
                        <tr>
                                       <td></td>
                                       <td>
                                       		<label for="NIVEL" style="font-size:12pt; font-weight:600">Nivel de Opci&oacute;n <?=$NIVEL?></label>
                                       		<input type="hidden" name="NIVEL" value="<?=$NIVEL?>">
                                        </td>
                        </tr>
                        <tr id="COD_NVL2" <?php if($NIVEL==1){?>style="display:none"<?php }?>>
                                       <td><label for="COD_NVL2">Opci&oacute;n Nivel 1</label></td>
                                       <td>
                                       <select id="COD_NVL2"  name="COD_NVL2" onChange="CargaNivel2(this.value, this.form.name, 'SELCOD_NVL3');">
                                        <option value="0">Seleccionar</option>
                                        <?php 
                                        $SQL="SELECT * FROM PA_OPCMENU WHERE COD_NVL2=0 AND COD_NVL3=0 ORDER BY COD_NVL1 ASC";
                                        $RS = sqlsrv_query($conn, $SQL);
                                        //oci_execute($RS);
                                        while ($row = sqlsrv_fetch_array($RS)) {
                                            $SELCOD_NVL1 = $row['COD_NVL1'];
                                            $DES_ESNVL1 = $row['DES_ES'];
                                         ?>
                                        <option value="<?=$SELCOD_NVL1?>" <?php if($SELCOD_NVL1==$COD_NVL2){ echo "Selected";}?>><?=$DES_ESNVL1 ?></option>
                                        <?php 
                                        }
                                         ?>
                                        </select>
                                        </td>
                        </tr>
                        <tr id="COD_NVL3" <?php if($NIVEL==1 or $NIVEL==2){?>style="display:none"<?php }?>>
                                       <td><label for="SELCOD_NVL3">Opci&oacute;n Nivel 2</label></td>
                                       <td><select id="SELCOD_NVL3" name="SELCOD_NVL3">
                                        <option value="0">Seleccionar</option>
                                        <?php 
                                        $SQL="SELECT * FROM PA_OPCMENU WHERE COD_NVL2<>0 AND COD_NVL3=0 ORDER BY COD_NVL1 ASC";
                                        $RS = sqlsrv_query($conn, $SQL);
                                        //oci_execute($RS);
                                        while ($row = sqlsrv_fetch_array($RS)) {
                                            $SELCOD_NVL2 = $row['COD_NVL1'];
                                            $DES_ES1 = $row['DES_ES'];
                                         ?>
                                        <option value="<?=$SELCOD_NVL2?>" <?php if($SELCOD_NVL2==$COD_NVL3){ echo "Selected";}?>><?=$DES_ES1 ?></option>
                                        <?php 
                                        }
                                         ?>
                                        </select></td>
                        </tr>
                        <tr>
                                    <td><label for="DES_ES">Descripci&oacute;n Espa&ntilde;ol </label></td>
                                    <td><input id="DES_ES" name="DES_ES" type="text" size="40" maxlength="200" value="<?=$DES_ES?>"> </td>
                        </tr>
                        <tr>
                                    <td><label for="DES_EN">Descripci&oacute;n Ingl&eacute;s </label></td>
                                    <td><input id="DES_EN" name="DES_EN" type="text" size="40" maxlength="200" value="<?=$DES_EN?>"> </td>
                        </tr>
                        <tr>
                                   <td><label for="PUBLICA">Publicar</label></td>
                                   <td><select name="PUBLICA">
                                    <option value="0" <?php if($PUBLICA==0){ echo "Selected";}?>>NO</option>
                                    <option value="1" <?php if($PUBLICA==1){ echo "Selected";}?>>SI</option>
                                    </select></td>
                        </tr>
                        <tr>
                                <td><label for="ARCHIVO">Forma PHP</label></td>
                                <td><input name="ARCHIVO" type="text" size="40" maxlength="200"  value="<?=$ARCHIVO?>"> </td>
                        </tr>
                        <tr>
                           <td></td>
                           <td>
                            <input type="hidden" name="COD_NVL1" value="<?=$ACT?>">
                            <input name="ACTUALIZAR" type="submit" value="Actualizar">
                            <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_opcmenu.php')"></td>
                        </tr>
                        </form>
                </table>
<?php }?>
                </td>
                </tr>
                </table>
        </td>
        </tr>
        </table></td>
</tr>
</table>
        <iframe name="frmHIDEN" width="0%" height="0" frameborder="0" align="top" src="" framespacing="0" marginheight="0" marginwidth="0">
        </iframe>
</body>
</html>
<?php
        sqlsrv_close($conn);
?>

