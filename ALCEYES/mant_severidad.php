
<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1171;
        $LOG = 1;

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
	
		if (theForm.VAL_TIP_SEVER.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.VAL_TIP_SEVER.focus();
			return false;
	}

		if (theForm.DES_TIP_SEVER.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.DES_TIP_SEVER.focus();
			return false;
	}

		if (theForm.ABR_TIP_SEVER.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.ABR_TIP_SEVER.focus();
			return false;
	}

		if (theForm.BGCOLOR_TIP_SEVER.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.BGCOLOR_TIP_SEVER.focus();
			return false;
	}

		if (theForm.CSSFONT_TIP_SEVER.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.CSSFONT_TIP_SEVER.focus();
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
							$ELMSJ="Valor Estado no disponible, verifique";
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
                <h2>Listado de  <?php echo $LAPAGINA?></h2>
        
                <table style="margin:20px; ">
                <tr>
                <td>
                
                
<?php
if ($LIST==1) {
?>
                
                
                <?php
				
				$CONSULTA="SELECT COUNT(ID_TIP_SEVER) AS CUENTA FROM FM_TIP_SEVER";
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

				//$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM FM_TIP_SEVER ORDER BY DES_TIP_SEVER ASC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;
			
				//oci_execute($RS);

                $CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY DES_TIP_SEVER ASC) ROWNUMBER FROM FM_TIP_SEVER) AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";

                    $RS = sqlsrv_query($conn, $CONSULTA);

               ?>
                <table id="Listado">
                <tr>
                    <th>Estado</th>
                    <th>Abrev.</th>
                    <th>Valor</th>
                    <th>Color</th>
                    <th>Registrado por</th>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){
                        $ID_TIP_SEVER = $row['ID_TIP_SEVER'];
                        $VAL_TIP_SEVER = $row['VAL_TIP_SEVER'];
                        $DES_TIP_SEVER = $row['DES_TIP_SEVER'];
                        $ABR_TIP_SEVER = $row['ABR_TIP_SEVER'];
                        $BGCOLOR_TIP_SEVER = $row['BGCOLOR_TIP_SEVER'];
                        $CSSFONT_TIP_SEVER = $row['CSSFONT_TIP_SEVER'];
                        $COD_USUARIO = $row['COD_USUARIO'];
                        $FEC_ACTUALIZACION = $row['FEC_ACTUALIZACION'];
						$CONSULTA2="SELECT NOMBRE FROM US_USUARIOS WHERE IDUSU=".$COD_USUARIO;
						$RS2 = sqlsrv_query($maestra, $CONSULTA2);
						//oci_execute($RS2);
						if ($row = @sqlsrv_fetch_array($RS2)) {
							$QUIENFUE = $row['NOMBRE'];
						}
						if ($QUIENFUE==""){$QUIENFUE="Sistema";}
               ?>
                <tr>
                    <?php if($SESPUBLICA==1) { ?>
                    <td><a href="mant_severidad.php?ACT=<?php echo $ID_TIP_SEVER?>"><?php echo $DES_TIP_SEVER?></a></td>
                    <?php } else {?>
                     <td><?php echo $DES_TIP_SEVER?></td>
                    <?php } ?>
                    <td><?php echo $ABR_TIP_SEVER?></td>
                    <td><?php echo $VAL_TIP_SEVER?></td>
                    <td style="background-color:<?php echo $BGCOLOR_TIP_SEVER?>;<?php echo $CSSFONT_TIP_SEVER?>"><?php echo $BGCOLOR_TIP_SEVER?></td>
                    <td><?php echo $QUIENFUE.", ".date_format($FEC_ACTUALIZACION,"d/m/Y")?></td>
                </tr>
                <?php
				}
				?>
                <tr>
                    <td colspan="5" nowrap style="background-color:transparent">
                    <?php
                    if ($LINF>=$CTP+1) {
						$ATRAS=$LINF-$CTP;
						$FILA_ANT=$LSUP-$CTP;
                   ?>
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('mant_severidad.php?LSUP=<?php echo $FILA_ANT?>&LINF=<?php echo $ATRAS?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('mant_severidad.php?LSUP=<?php echo $FILA_POS?>&LINF=<?php echo $ADELANTE?>');">
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
                        <form action="mant_severidad_reg.php" method="post" name="forming" id="forming" onSubmit="return validaingreso(this)">
                        <tr>
                            <td><label for="VAL_TIP_SEVER">Valor Estado </label></td>
                            <td><input name="VAL_TIP_SEVER" type="text" size="2" maxlength="2" > </td>
                        </tr>
                        <tr>
                            <td><label for="DES_TIP_SEVER">Descripci&oacute;n </label></td>
                            <td><input name="DES_TIP_SEVER" type="text" size="40" maxlength="75" > </td>
                        </tr>
                        <tr>
                            <td><label for="ABR_TIP_SEVER">Abreviatura </label></td>
                            <td><input name="ABR_TIP_SEVER" type="text" size="10" maxlength="10" > </td>
                        </tr>
                        <tr>
                            <td><label for="BGCOLOR_TIP_SEVER">Color </label></td>
                            <td><input name="BGCOLOR_TIP_SEVER" type="text" size="10" maxlength="7" > </td>
                        </tr>
                        <tr>
                            <td><label for="CSSFONT_TIP_SEVER">Texto </label></td>
                            <td><input name="CSSFONT_TIP_SEVER" type="text" size="60" maxlength="250" > </td>
                        </tr>
                        <tr>
                           <td></td>
                           <td><input name="INGRESAR" type="submit" value="Registrar">
                            <input name="LIMPIAR" type="reset" value="Limpiar">
                            <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_severidad.php')"></td>
                        </tr>
                        </form>
                </table>
                <script>
                document.forming.VAL_TIP_SEVER.focus();
                </script>
<?php
		sqlsrv_close($conn);
}
?>
               
               
			<?php  if ($ACT<>"") { 
				$CONSULTA="SELECT * FROM FM_TIP_SEVER WHERE ID_TIP_SEVER=".$ACT;
				$RS = sqlsrv_query($conn, $CONSULTA);
				//oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {
					$ID_TIP_SEVER = $row['ID_TIP_SEVER'];
					$VAL_TIP_SEVER = $row['VAL_TIP_SEVER'];
					$DES_TIP_SEVER = $row['DES_TIP_SEVER'];
					$ABR_TIP_SEVER = $row['ABR_TIP_SEVER'];
					$BGCOLOR_TIP_SEVER = $row['BGCOLOR_TIP_SEVER'];
					$CSSFONT_TIP_SEVER = $row['CSSFONT_TIP_SEVER'];
                }
               ?>
                <h3>Actualizar: <?php echo $DES_TIP_SEVER?></h3>
                <table id="forma-registro">
                    <form action="mant_severidad_reg.php" method="post" name="formact" onSubmit="return validaingreso(this)">
                        <tr>
                            <td><label for="VAL_TIP_SEVER">Valor Estado </label></td>
                            <td><input name="VAL_TIP_SEVER" type="text" size="2" maxlength="2" value="<?php echo $VAL_TIP_SEVER?>" > </td>
                        </tr>
                        <tr>
                            <td><label for="DES_TIP_SEVER">Descripci&oacute;n </label></td>
                            <td><input name="DES_TIP_SEVER" type="text" size="40" maxlength="75" value="<?php echo $DES_TIP_SEVER?>"  > </td>
                        </tr>
                        <tr>
                            <td><label for="ABR_TIP_SEVER">Abreviatura </label></td>
                            <td><input name="ABR_TIP_SEVER" type="text" size="10" maxlength="10" value="<?php echo $ABR_TIP_SEVER?>"  > </td>
                        </tr>
                        <tr>
                            <td><label for="BGCOLOR_TIP_SEVER">Color </label></td>
                            <td><input name="BGCOLOR_TIP_SEVER" type="text" size="10" maxlength="7" value="<?php echo $BGCOLOR_TIP_SEVER?>"  > </td>
                        </tr>
                        <tr>
                            <td><label for="CSSFONT_TIP_SEVER">Texto </label></td>
                            <td><input name="CSSFONT_TIP_SEVER" type="text" size="60" maxlength="250" value="<?php echo $CSSFONT_TIP_SEVER?>"  > </td>
                        </tr>
                    <tr>
                        <td><input name="ID_TIP_SEVER" type="hidden" value="<?php echo $ID_TIP_SEVER?>">
                        <td>
                        <input name="ACTUALIZAR" type="submit" value="Actualizar">
                        <?php
						$CONSULTA="SELECT * FROM FP_EJECUCION WHERE TIP_SEVER=".$VAL_TIP_SEVER;
						$RS = sqlsrv_query($conn, $CONSULTA);
						//oci_execute($RS);
						if ($row = sqlsrv_fetch_array($RS)) {
							$ELIMINAR=0;
						} else {
							$ELIMINAR=1;
						}
						if ($ELIMINAR==1) {
						?>
                        <input name="ELIMINAR" type="button" value="Eliminar" onClick="javascript:pagina('mant_severidad_reg.php?ELM=1&ID_TIP_SEVER=<?php echo $ID_TIP_SEVER ?>')">
                        <?php } ?>
                        <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_severidad.php')">
                        </td>
                    </tr>
                    </form>
                </table>
                <script>
                document.formact.DES_TIP_SEVER.focus();
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

