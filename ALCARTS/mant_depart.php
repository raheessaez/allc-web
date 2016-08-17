<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1123;
	$NOMENU=1;
	$LIST=@$_GET["LIST"];
	$ACT=@$_GET["ACT"];
	if ($ACT=="") {
		 $LIST=1;
	}
	

	$BDEPART=trim(strtoupper(@$_POST["BDEPART"]));
	if (empty($BDEPART)) { $BDEPART=trim(strtoupper(@$_GET["BDEPART"])) ;}
	if ($BDEPART<>"") {$FLT_DEP=" WHERE (UPPER(LTRIM(NM_DPT_PS)))  Like '%".strtoupper($BDEPART)."%' "; }

?>
<?php if ($LIST<>1) {?>
<script language="JavaScript">
function validaingreso(theForm){
	
		if (theForm.NM_DPT_PS.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.NM_DPT_PS.focus();
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
<div id="GMessaje" onClick="QuitarGMessage();"><a href="#" onClick="QuitarGMessage();" style="color:#111111;"><?php echo $ELMSJ?></a></div>
<?php }?>
        <table width="100%">
        <tr><td>
<?php
if ($LIST==1) {
?>
                <table width="100%" id="Filtro">
                <tr>
                <td>
                <form action="mant_depart.php" method="post" name="frmbuscar" id="frmbuscar">
                        <label for="BDEPART" style="margin:8px 4px; font-weight:600; clear:left">Departamento </label>
                        <input style="text-transform:uppercase" name="BDEPART" type="text"  id="BDEPART" value="<?php echo $BDEPART ?>" size="14" maxlength="40">
                        <input name="BUSCAR" type="submit" id="BUSCAR" value="Buscar Departamento">
                        <input name="LIMPIAR" type="button" id="LIMPIAR" value="Limpiar" onClick="pagina('mant_depart.php');">
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
				
				$CONSULTA="SELECT COUNT(*) AS CUENTA FROM ID_DPT_PS ".@$FLT_DEP." ";
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

				//$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM ID_DPT_PS ".$FLT_DEP." ORDER BY NM_DPT_PS ASC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;

                $CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY NM_DPT_PS ASC) ROWNUMBER FROM ID_DPT_PS ".@$FLT_DEP.") AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";


				$RS = sqlsrv_query($conn, $CONSULTA);


				////oci_execute($RS);
               ?>
                <table id="Listado">
                <tr>
                    <th>Nombre</th>
                    <th>C&oacute;d. CER</th>
                    <th>L&iacute;nea</th>
                    <th>Familias</th>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){
                        $ID_DPT_PS = $row['ID_DPT_PS'];
                        $COD_NEGOCIO = $row['COD_NEGOCIO'];
                        $CD_DPT_CER = $row['CD_DPT_CER'];
                        $NM_DPT_PS = $row['NM_DPT_PS'];
						$SQL2="SELECT DES_NEGOCIO FROM MN_NEGOCIO WHERE COD_NEGOCIO=".$COD_NEGOCIO;
						$RS2 = sqlsrv_query($maestra, $SQL2);
						////oci_execute($RS2);
						if ($row2 = sqlsrv_fetch_array($RS2)) {
							$DES_NEGOCIO = $row2['DES_NEGOCIO'];
						}
						$SQL2="SELECT COUNT(*) AS CTAFAM FROM CO_MRHRC_GP WHERE ID_DPT_PS=".$ID_DPT_PS;
						$RS2 = sqlsrv_query($conn, $SQL2);
						////oci_execute($RS2);
						if ($row2 = sqlsrv_fetch_array($RS2)) {
							$CTAFAM = $row2['CTAFAM'];
						}
              ?>
                <tr>
                    <td><?php echo $NM_DPT_PS?></td>
                    <td><?php echo $CD_DPT_CER?></td>
                    <td><?php echo $DES_NEGOCIO?></td>
                    <td><?php echo $CTAFAM?></td>
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
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('mant_depart.php?LSUP=<?php echo $FILA_ANT?>&LINF=<?php echo $ATRAS?>&BDEPART=<?php echo $BDEPART?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('mant_depart.php?LSUP=<?php echo $FILA_POS?>&LINF=<?php echo $ADELANTE?>&BDEPART=<?php echo $BDEPART?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina <?php echo $NUMPAG?> de <?php echo $NUMTPAG?></span>
                    </td>
                </tr>
                </table>
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

