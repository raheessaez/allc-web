
<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1122;


	$LIST=@$_GET["LIST"];
	$NEO=@$_GET["NEO"];
	$ACT=@$_GET["ACT"];
	
	if ($NEO=="" and $ACT=="") {
		 $LIST=1;
	}
?>

<?php if ($LIST<>1) {?>
<script language="JavaScript">
function validaingreso(theForm){
	
		if (theForm.ID_RSN.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.ID_RSN.focus();
			return false;
	}

		if (theForm.DES_RSN_EN.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.DES_RSN_EN.focus();
			return false;
	}

		if (theForm.DES_RSN_ES.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.DES_RSN_ES.focus();
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
        
                <h2><?php echo $LAPAGINA?></h2>
                <table style="margin:10px 20px; ">
                <tr>
                <td>
                
                
<?php
if ($LIST==1) {
?>
                
                
                <?php
				
				$CONSULTA="SELECT COUNT(*) AS CUENTA FROM MGR_OVRD_RSN";
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

				$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM MGR_OVRD_RSN ORDER BY ID_RSN ASC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;
				
                $CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY ID_RSN ASC) ROWNUMBER FROM MGR_OVRD_RSN) AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";

                $RS = sqlsrv_query($conn, $CONSULTA);
				////oci_execute($RS);
               ?>
                <table id="Listado">
                <tr>
                    <th><span class="txtBold">C&oacute;digo</th>
                    <th><span class="txtBold">Name (EN)</th>
                    <th><span class="txtBold">Nombre (ES)</th>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){
                        $ID_RSN = $row['ID_RSN'];
                        $DES_RSN_EN = $row['DES_RSN_EN'];
                        $DES_RSN_ES = $row['DES_RSN_ES'];
              ?>
                <tr>
                    <?php if($SESPUBLICA==1) { ?>
                    <td ><a href="mant_override.php?ACT=<?php echo $ID_RSN?>"><?php echo $ID_RSN?></a></td>
                    <?php } else {?>
                     <td><?php echo $ID_RSN?>%</td>
                    <?php } ?>
                    <td><?php echo $DES_RSN_EN?></td>
                    <td><?php echo $DES_RSN_ES?></td>
                </tr>
                <?php
				}
				?>
                <tr>
                    <td colspan="3" nowrap style="background-color:transparent">
                    <?php
                    if ($LINF>=$CTP+1) {
						$ATRAS=$LINF-$CTP;
						$FILA_ANT=$LSUP-$CTP;
                   ?>
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('mant_override.php?LSUP=<?php echo $FILA_ANT?>&LINF=<?php echo $ATRAS?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('mant_override.php?LSUP=<?php echo $FILA_POS?>&LINF=<?php echo $ADELANTE?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina <?php echo $NUMPAG?> de <?php echo $NUMTPAG?></span>
                    </td>
                </tr>
                </table>
<?php
		sqlsrv_close($conn);
}
?>
               
               
                <?php  if ($NEO==1) { ?>
                <table id="forma-registro">
                        <form action="mant_override_reg.php" method="post" name="forming" id="forming" onSubmit="return validaingreso(this)">
                    <tr>
                        <td> <label for="ID_RSN">C&oacute;digo</label> </td>
                        <td><input name="ID_RSN" type="text" size="4" maxlength="2"   onKeyPress="return acceptNum(event);" ></td>
                    </tr>
                    <tr>
                        <td><label for="DES_RSN_EN">Name (EN)</label> </td>
                        <td><input name="DES_RSN_EN" type="text" size="30" maxlength="200"></td>
                    </tr>
                    <tr>
                        <td><label for="DES_RSN_ES">Nombre (ES)</label> </td>
                        <td><input name="DES_RSN_ES" type="text" size="30" maxlength="200"></td>
                    </tr>
                        <tr>
                           <td></td>
                           <td><input name="INGRESAR" type="submit" value="Registrar">
                            <input name="LIMPIAR" type="reset" value="Limpiar">
                            <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_override.php')"></td>
                        </tr>
                        </form>
                </table>
                <script>
                document.forming.ID_RSN.focus();
                </script>
<?php
		sqlsrv_close($conn);
}
?>
               
               
			<?php  if ($ACT<>"") { 
				$CONSULTA="SELECT * FROM MGR_OVRD_RSN WHERE ID_RSN=".$ACT;
				$RS = sqlsrv_query($conn, $CONSULTA);
				////oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {
					$DES_RSN_EN = $row['DES_RSN_EN'];
					$DES_RSN_ES = $row['DES_RSN_ES'];
                }
               ?>
                <h3>Actualizar Plan (<?=$ACT?>")</h3>
                <table id="forma-registro">
                    <form action="mant_override_reg.php" method="post" name="formact" onSubmit="return validaingreso(this)">
                    <tr>
                        <td> <label for="ID_RSN">C&oacute;digo</label> <input name="ID_RSN" type="hidden" value="<?php echo $ACT?>"></td>
                        <td><label for="ID_RSN_DES" style="text-align:left; font-size:14pt;"><?php echo $ACT?></label></td>
                    </tr>
                    <tr>
                        <td><label for="DES_RSN_EN">Name (EN)</label> </td>
                        <td><input name="DES_RSN_EN" type="text" size="30" maxlength="200" value="<?php echo $DES_RSN_EN?>"  ></td>
                    </tr>
                    <tr>
                        <td><label for="DES_RSN_ES">Nombre (ES)</label> </td>
                        <td><input name="DES_RSN_ES" type="text" size="30" maxlength="200" value="<?php echo $DES_RSN_ES?>"  ></td>
                    </tr>
                    <tr>
                        <td>
                        <td>
                        <input name="ACTUALIZAR" type="submit" value="Actualizar">
                        <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_override.php')">
                        </td>
                    </tr>
                    </form>
                </table>
                <script>
                document.formact.DES_RSN_EN.focus();
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
</td>
</tr>
</table>
</body>
</html>

