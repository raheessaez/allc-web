<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1158;
	$NOMENU=1;
	$LIST=@$_GET["LIST"];
	$ACT=@$_GET["ACT"];
	if ($ACT=="") 
	{
		 $LIST=1;
	}

	$BDEPART=trim(strtoupper(@$_POST["BDEPART"]));
	if (empty($BDEPART)) { $BDEPART=trim(strtoupper(@$_GET["BDEPART"])) ;}
	if ($BDEPART<>"") {$FLT_DEP=" AND ID_DPT_PS=".$BDEPART.""; }

	$BFAMILIA=trim(strtoupper(@$_POST["BFAMILIA"]));
	if (empty($BFAMILIA)) { $BFAMILIA=trim(strtoupper(@$_GET["BFAMILIA"])) ;}
	if ($BFAMILIA<>"") {$FLT_FAM=" AND (UPPER(LTRIM(NM_MRHRC_GP)))  Like '%".strtoupper($BFAMILIA)."%' "; }
?>
<?php if ($LIST<>1) {?>
<script language="JavaScript">
function validaingreso(theForm){
	
		if (theForm.NM_MRHRC_GP.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.NM_MRHRC_GP.focus();
			return false;
	}
} //validaingreso(theForm)


</script>
<?php }?>
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
							$ELMSJ="Registro no disponible, verifique";
} 
if ($MSJE == 3) {
$ELMSJ="Registro realizado";
}
if ($MSJE == 4) {
$ELMSJ="Registro eliminado";
}
if ($MSJE <> "") {
?>
<div id="GMessaje" onClick="QuitarGMessage();"><a href="#" onClick="QuitarGMessage();" style="color:#111111;"><?=$ELMSJ?></a></div>
<?php }?>
        <table width="100%">
        <tr><td>
<?php
if ($LIST==1) {
?>
                <table width="100%" id="Filtro">
                <tr>
                <td>
                <form action="mant_familia.php" method="post" name="frmbuscar" id="frmbuscar">
                        <select name="BDEPART" onChange="document.forms.frmbuscar.submit();">
                                    <option value="0">Departamento</option>
                                    <?php 
                                    $SQLFILTRO="SELECT * FROM ID_DPT_PS ORDER BY NM_DPT_PS ASC";
                                    $RSF = sqlsrv_query($conn, $SQLFILTRO);
                                    ////oci_execute($RSF);
                                    while ($rowF = sqlsrv_fetch_array($RSF)) {
                                            $ID_DPT_PS = $rowF['ID_DPT_PS'];
                                            $NM_DPT_PS = $rowF['NM_DPT_PS'];
                                     ?>
                                    <option value="<?=$ID_DPT_PS ?>" <?php  if ($ID_DPT_PS==$BDEPART) { echo "SELECTED";}?>><?=$NM_DPT_PS ?></option>
                                    <?php 
                                    }
                                     ?>
                                    </select>
                        <label for="BFAMILIA" >Familia </label>
                        <input style="text-transform:uppercase" name="BFAMILIA" type="text"  id="BFAMILIA" value="<?=$BFAMILIA ?>" size="14" maxlength="40">
                        <input name="BUSCAR" type="submit" id="BUSCAR" value="Buscar Familia">
                        <input name="LIMPIAR" type="button" id="LIMPIAR" value="Limpiar" onClick="pagina('mant_familia.php');">
                </form>
              </td>
              </tr>
              </table>
<?php
}
?>
             <table style="margin:10px 20px; ">
                <tr>
                <td>
                
                
<?php
if ($LIST==1) {
?>
                
                <?php
				
				$CONSULTA="SELECT COUNT(*) AS CUENTA FROM CO_MRHRC_GP WHERE ID_MRHRC_GP<>0 ".@$FLT_FAM.@$FLT_DEP." ";
				$RS = sqlsrv_query($conn, $CONSULTA);
				////oci_execute($RS);
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

				//$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM CO_MRHRC_GP WHERE ID_MRHRC_GP<>0 ".$FLT_FAM.$FLT_DEP." ORDER BY NM_MRHRC_GP ASC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;

                $CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY NM_MRHRC_GP ASC) ROWNUMBER FROM CO_MRHRC_GP WHERE ID_MRHRC_GP<>0 ".@$FLT_FAM.@$FLT_DEP.") AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";

				//echo $CONSULTA;
				$RS = sqlsrv_query($conn, $CONSULTA);
				////oci_execute($RS);
               ?>
                <table id="Listado">
                <tr>
                	<th>ID ARMS</th>
                    <th>Nombre</th>
                    <th>C&oacute;d. ARMS</th>
                    <th>Departamento</th>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){
                        $ID_MRHRC_GP = $row['ID_MRHRC_GP'];
                        $CD_MRHRC_GP = $row['CD_MRHRC_GP'];
                        $CD_MRHRC_CER = $row['CD_MRHRC_CER'];
                        
                        $ID_DPT_PS = $row['ID_DPT_PS'];
                        $CD_DPT_CER = $row['CD_DPT_CER'];
						if(!isset($row['NM_MRHRC_GP']))
						{
							$NM_MRHRC_GP="Nombre No Asignado";
						}
						else
						{
							$NM_MRHRC_GP = $row['NM_MRHRC_GP'];
						}
						$SQL="SELECT * FROM ID_DPT_PS WHERE ID_DPT_PS=".$ID_DPT_PS;
						$RS2 = sqlsrv_query($conn, $SQL);
						////oci_execute($RS2);
						if ($row2 = sqlsrv_fetch_array($RS2)){
							$NM_DPT_PS = $row2['NM_DPT_PS'];
							$CD_DPT_PS = $row2['CD_DPT_PS'];
						}
              ?>
                <tr>
                    <?php if($SESPUBLICA==1) { ?>
                    <td align="right"><a href="mant_familia.php?ACT=<?=$ID_MRHRC_GP?>"><?=$ID_MRHRC_GP?></a></td>
                    <?php } else {?>
                     <td style="background:#F5F9FC; text-align:right" ><?=$ID_MRHRC_GP?></td>
                    <?php } ?>
                    <td><?=$NM_MRHRC_GP?></td>
                    <td style="text-align:right" ><?=$CD_MRHRC_GP?></td>
                    <td><?="(".$CD_DPT_PS.") ".$NM_DPT_PS?></td>
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
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('mant_familia.php?LSUP=<?=$FILA_ANT?>&LINF=<?=$ATRAS?>&BFAMILIA=<?=$BFAMILIA?>&BDEPART=<?=$BDEPART?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('mant_familia.php?LSUP=<?=$FILA_POS?>&LINF=<?=$ADELANTE?>&BFAMILIA=<?=$BFAMILIA?>&BDEPART=<?=$BDEPART?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina <?=$NUMPAG?> de <?=$NUMTPAG?></span>
                    </td>
                </tr>
                </table>
<?php
		sqlsrv_close($conn);
}
?>
               
                             
			<?php  if ($ACT<>"") { 
				$CONSULTA="SELECT * FROM CO_MRHRC_GP WHERE ID_MRHRC_GP=".$ACT;
				$RS = sqlsrv_query($conn, $CONSULTA);
				////oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {
					$CD_MRHRC_GP = $row['CD_MRHRC_GP'];
					$NM_MRHRC_GP = $row['NM_MRHRC_GP'];
					$CD_MRHRC_CER = $row['CD_MRHRC_CER'];
					$ID_DPT_PS = $row['ID_DPT_PS'];
					$CD_DPT_CER = $row['CD_DPT_CER'];
					$SQL="SELECT NM_DPT_PS FROM ID_DPT_PS WHERE ID_DPT_PS=".$ID_DPT_PS;
					$RS2 = sqlsrv_query($conn, $SQL);
					////oci_execute($RS2);
					if ($row2 = sqlsrv_fetch_array($RS2)){
						$NM_DPT_PS = $row2['NM_DPT_PS'];
					}
                }
               ?>
                <h3>Actualizar Familia <?=$CD_MRHRC_CER?></h3>
                <table id="forma-registro">
                    <form action="mant_familia_reg.php" method="post" name="formact" onSubmit="return validaingreso(this)">
                    <tr>
                        <td><label for="NM_DPT_PS">Departamento</label> </td>
                        <td><h5><?="(".$CD_DPT_CER.") ".$NM_DPT_PS?></h5></td>
                    </tr>
                    <tr>
                        <td> <label for="CD_MRHRC_GP">C&oacute;digos</label><input name="ID_MRHRC_GP" type="hidden" value="<?=$ACT?>"></td>
                        <td><h5><?="CER: ".$CD_MRHRC_CER." | ARMS: ".$CD_MRHRC_GP." | ID: ".$ACT?></h5></td>
                    </tr>
                    <tr>
                        <td><label for="NM_MRHRC_GP">Nombre</label> </td>
                        <td><input name="NM_MRHRC_GP" type="text" size="30" maxlength="200" value="<?=$NM_MRHRC_GP?>"  ></td>
                    </tr>
                    <tr>
                        <td>
                        <td>
                        <input name="ACTUALIZAR" type="submit" value="Actualizar">
                        <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_familia.php')">
                        </td>
                    </tr>
                    </form>
                </table>
                <script>
                document.formact.CD_MRHRC_GP.focus();
                </script>
<?php
		sqlsrv_close($conn);
}
?>
                </td>
                </tr>
                </table>
        
</td>
</tr>
</table>
</body>
</html>

