
<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1172;


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
	
		if (theForm.NOM_ESTPRC.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.NOM_ESTPRC.focus();
			return false;
	}

		if (theForm.COL_ESTPRC.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.COL_ESTPRC.focus();
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
if ($MSJE==1) {$ELMSJ="Registro actualizado";} 
if ($MSJE==2) {$ELMSJ="Nombre no disponible, verifique";}
if ($MSJE==3) {$ELMSJ="Registro realizado";}
if ($MSJE==4) {$ELMSJ="Registro eliminado";}
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
				
				$CONSULTA="SELECT COUNT(ID_ESTPRC) AS CUENTA FROM EST_PRC";
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

				//$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM EST_PRC ORDER BY ID_ESTPRC ASC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;
				//
				//oci_execute($RS);

                $CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY ID_ESTPRC ASC) ROWNUMBER FROM EST_PRC) AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";
                $RS = sqlsrv_query($conn, $CONSULTA);
               ?>
                <table id="Listado">
                <tr>
                    <th>Estado</th>
                    <th>Color</th>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){
                        $ID_ESTPRC = $row['ID_ESTPRC'];
                        $NOM_ESTPRC = $row['NOM_ESTPRC'];
                        $COL_ESTPRC = $row['COL_ESTPRC'];
                        $CSF_ESTADO = $row['CSF_ESTADO'];
               ?>
                <tr>
                    <?php if($SESPUBLICA==1) { ?>
                    <td><a href="mant_estados.php?ACT=<?php echo $ID_ESTPRC?>"><?php echo $NOM_ESTPRC?></a></td>
                    <?php } else {?>
                     <td><?php echo $NOM_ESTPRC?></td>
                    <?php } ?>
                    <td style="background-color:<?php echo $COL_ESTPRC?>;<?php echo $CSF_ESTADO?>"><?php echo $COL_ESTPRC?></td>
                </tr>
                <?php
				}
				?>
                <tr>
                    <td colspan="2" nowrap style="background-color:transparent">
                    <?php
                    if ($LINF>=$CTP+1) {
						$ATRAS=$LINF-$CTP;
						$FILA_ANT=$LSUP-$CTP;
                   ?>
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('mant_estados.php?LSUP=<?php echo $FILA_ANT?>&LINF=<?php echo $ATRAS?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('mant_estados.php?LSUP=<?php echo $FILA_POS?>&LINF=<?php echo $ADELANTE?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina <?php echo $NUMPAG?> de <?php echo $NUMTPAG?></span>
                    </td>
                </tr>
                </table>
<?php
		sqlsrv_close($conn);
		sqlsrv_close($maestra);
}
?>
               
               
                <?php  if ($NEO==1) { ?>
                <table id="forma-registro">
                        <form action="mant_estados_reg.php" method="post" name="forming" id="forming" onSubmit="return validaingreso(this)">
                        <tr>
                            <td><label for="NOM_ESTPRC">Nombre</label></td>
                            <td><input name="NOM_ESTPRC" type="text" size="20" maxlength="200" > </td>
                        </tr>
                        <tr>
                            <td><label for="COL_ESTPRC">Color</label></td>
                            <td><input name="COL_ESTPRC" type="text" size="10" maxlength="7" > </td>
                        </tr>
                        <tr>
                            <td><label for="CSF_ESTADO">Formato Texto </label></td>
                            <td><input name="CSF_ESTADO" type="text" size="60" maxlength="250" > </td>
                        </tr>
                        <tr>
                           <td></td>
                           <td><input name="INGRESAR" type="submit" value="Registrar">
                            <input name="LIMPIAR" type="reset" value="Limpiar">
                            <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_estados.php')"></td>
                        </tr>
                        </form>
                </table>
                <script>
                document.forming.NOM_ESTPRC.focus();
                </script>
<?php
		sqlsrv_close($conn);
		sqlsrv_close($maestra);
}
?>
               
               
			<?php  if ($ACT<>"") { 
				$CONSULTA="SELECT * FROM EST_PRC WHERE ID_ESTPRC=".$ACT;
				$RS = sqlsrv_query($conn, $CONSULTA);
				//oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {
					$ID_ESTPRC = $row['ID_ESTPRC'];
					$NOM_ESTPRC = $row['NOM_ESTPRC'];
					$COL_ESTPRC = $row['COL_ESTPRC'];
					$CSF_ESTADO = $row['CSF_ESTADO'];
                }
               ?>
                <h3>Actualizar: <?php echo $NOM_ESTPRC?></h3>
                <table id="forma-registro">
                    <form action="mant_estados_reg.php" method="post" name="formact" onSubmit="return validaingreso(this)">
                    <tr>
                        <td> <label for="NOM_ESTPRC">Nombre</label> </td>
                        <td><input name="NOM_ESTPRC" type="text" size="20" maxlength="200" value="<?php echo $NOM_ESTPRC?>"></td>
                    </tr>
                        <tr>
                            <td><label for="COL_ESTPRC">Color</label></td>
                            <td><input name="COL_ESTPRC" type="text" size="10" maxlength="7" value="<?php echo $COL_ESTPRC?>"  > </td>
                        </tr>
                        <tr>
                            <td><label for="CSF_ESTADO">Formato Texto</label></td>
                            <td><input name="CSF_ESTADO" type="text" size="60" maxlength="250" value="<?php echo $CSF_ESTADO?>"  > </td>
                        </tr>
                    <tr>
                        <td><input name="ID_ESTPRC" type="hidden" value="<?php echo $ID_ESTPRC?>">
                        <td>
                        <input name="ACTUALIZAR" type="submit" value="Actualizar">
                        <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_estados.php')">
                        </td>
                    </tr>
                    </form>
                </table>
                <script>
                document.formact.NOM_ESTPRC.focus();
                </script>
<?php
		sqlsrv_close($conn);
		sqlsrv_close($maestra);
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

