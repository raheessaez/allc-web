
<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1121;


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
	
		if (theForm.ID_TND.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.ID_TND.focus();
			return false;
	}

		if (theForm.TY_TND.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.TY_TND.focus();
			return false;
	}

		if (theForm.DE_TND.value == 0){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.DE_TND.focus();
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
        
                <h2><?=$LAPAGINA?></h2>
                <table style="margin:10px 20px; ">
                <tr>
                <td>
                
                
<?php
if ($LIST==1) {
?>
                
                
                <?php
				
				$CONSULTA="SELECT COUNT(*) AS CUENTA FROM AS_TND";
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

				//$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM AS_TND ORDER BY ID_TND ASC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;
				

                $CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY ID_TND ASC) ROWNUMBER FROM AS_TND) AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";

                $RS = sqlsrv_query($conn, $CONSULTA);
				////oci_execute($RS);
               ?>
                <table id="Listado">
                <tr>
                    <th>DE_TND</th>
                    <th>ID_TND</th>
                    <th>TY_TND</th>
                    <th>LU_CLS_TND</th>
                    <th>FL_TND_DSBL</th>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){
                        $ID_TND = $row['ID_TND'];
                        $TY_TND = $row['TY_TND'];
                        $DE_TND = $row['DE_TND'];
						if(is_null($DE_TND)){$DE_TND=" -- ";}
                        $LU_CLS_TND = $row['LU_CLS_TND'];
						if(is_null($LU_CLS_TND)){$LU_CLS_TND=" -- ";}
                        $FL_TND_DSBL = $row['FL_TND_DSBL'];
						if(is_null($FL_TND_DSBL)){$FL_TND_DSBL=" -- ";}
               ?>
                <tr>
                    <?php if($SESPUBLICA==1) { ?>
                    <td><a href="mant_mediospago.php?ACT=<?=$ID_TND?>"><?=$DE_TND?></a></td>
                    <?php } else {?>
                     <td><?=$DE_TND?></td>
                    <?php } ?>
                    <td><?=$ID_TND?></td>
                    <td><?=$TY_TND?></td>
                    <td><?=$LU_CLS_TND?></td>
                    <td><?=$FL_TND_DSBL?></td>
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
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('mant_mediospago.php?LSUP=<?=$FILA_ANT?>&LINF=<?=$ATRAS?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('mant_mediospago.php?LSUP=<?=$FILA_POS?>&LINF=<?=$ADELANTE?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina <?=$NUMPAG?> de <?=$NUMTPAG?></span>
                    </td>
                </tr>
                </table>
<?php
		sqlsrv_close($conn);
}
?>
               
               
                <?php  if ($NEO==1) { ?>
                <table id="forma-registro">
                        <form action="mant_mediospago_reg.php" method="post" name="forming" id="forming" onSubmit="return validaingreso(this)">
                    <tr>
                        <td> <label for="ID_TND">ID_TND</label> </td>
                        <td><input name="ID_TND" type="text" size="6" maxlength="4" onKeyPress="return acceptNum(event);"></td>
                    </tr>
                    <tr>
                        <td> <label for="TY_TND">TY_TND</label> </td>
                        <td><input name="TY_TND" type="text" size="6" maxlength="4" ></td>
                    </tr>
                    <tr>
                        <td><label for="DE_TND">DE_TND</label> </td>
                        <td><input name="DE_TND" type="text" size="20" maxlength="255" ></td>
                    </tr>
                    <tr>
                        <td> <label for="LU_CLS_TND">LU_CLS_TND (?)</label> </td>
                        <td><input name="LU_CLS_TND" type="text" size="6" maxlength="38" onKeyPress="return acceptNum(event);" ></td>
                    </tr>
                    <tr>
                        <td> <label for="FL_TND_DSBL">FL_TND_DSBL (?)</label> </td>
                        <td><input name="FL_TND_DSBL" type="text" size="2" maxlength="1" onKeyPress="return acceptNum(event);" ></td>
                    </tr>
                        <tr>
                           <td></td>
                           <td><input name="INGRESAR" type="submit" value="Registrar">
                            <input name="LIMPIAR" type="reset" value="Limpiar">
                            <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_mediospago.php')"></td>
                        </tr>
                        </form>
                </table>
                <script>
                document.forming.ID_TND.focus();
                </script>
<?php
		sqlsrv_close($conn);
}
?>
               
               
			<?php  if ($ACT<>"") { 
				$CONSULTA="SELECT * FROM AS_TND WHERE ID_TND=".$ACT;
				$RS = sqlsrv_query($conn, $CONSULTA);
				////oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {
					$TY_TND = $row['TY_TND'];
					$DE_TND = $row['DE_TND'];
					$LU_CLS_TND = $row['LU_CLS_TND'];
					$FL_TND_DSBL = $row['FL_TND_DSBL'];
                }
               ?>
                <h3>Actualizar Medio (<?=$ACT.") ".$DE_TND?></h3>
                <table id="forma-registro">
                    <form action="mant_mediospago_reg.php" method="post" name="formact" onSubmit="return validaingreso(this)">
                    <tr>
                        <td> <label for="TY_TND">TY_TND</label> <input name="ID_TND" type="hidden" value="<?=$ACT?>"></td>
                        <td><input name="TY_TND" type="text" size="6" maxlength="4" value="<?=$TY_TND?>" ></td>
                    </tr>
                    <tr>
                        <td><label for="DE_TND">DE_TND</label> </td>
                        <td><input name="DE_TND" type="text" size="20" maxlength="255" value="<?=$DE_TND?>" ></td>
                    </tr>
                    <tr>
                        <td> <label for="LU_CLS_TND">LU_CLS_TND (?)</label> </td>
                        <td><input name="LU_CLS_TND" type="text" size="6" maxlength="38" value="<?=$LU_CLS_TND?>"  onKeyPress="return acceptNum(event);" ></td>
                    </tr>
                    <tr>
                        <td> <label for="FL_TND_DSBL">FL_TND_DSBL (?)</label> </td>
                        <td><input name="FL_TND_DSBL" type="text" size="2" maxlength="1" value="<?=$FL_TND_DSBL?>" onKeyPress="return acceptNum(event);"  ></td>
                    </tr>
                    <tr>
                        <td>
                        <td>
                        <input name="ACTUALIZAR" type="submit" value="Actualizar">
                        <?php
						$CONSULTA="SELECT * FROM TR_LTM_TND WHERE ID_TND=".$ACT;
						$RS = sqlsrv_query($conn, $CONSULTA);
						////oci_execute($RS);
						if ($row = sqlsrv_fetch_array($RS)) {
							$ELIMINAR=0;
						} else {
							$ELIMINAR=1;
						}
						if ($ELIMINAR==1) {
						?>
                        <input name="ELIMINAR" type="button" value="Eliminar" onClick="javascript:pagina('mant_mediospago_reg.php?ELM=1&ID_TND=<?=$ACT ?>')">
                        <?php } ?>
                        <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_mediospago.php')">
                        </td>
                    </tr>
                    </form>
                </table>
                <script>
                document.formact.TY_TND.focus();
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

