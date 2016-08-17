
<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1137;


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
	
		if (theForm.MIN_INGRESO.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.MIN_INGRESO.focus();
			return false;
	}

		if (theForm.MAX_INGRESO.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.MAX_INGRESO.focus();
			return false;
	}
    if(theForm.MIN_INGRESO.value > theForm.MAX_INGRESO.value)
    {
        alert("Valor Minimo debe ser mayor al Valor Maximo.");
            theForm.MAX_INGRESO.focus();
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
if ($MSJE==2) {$ELMSJ="Valores ya registrados, verifique";}
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
				
				$CONSULTA="SELECT COUNT(COD_INGRESO) AS CUENTA FROM MN_INGRESO";
				
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

				//$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM MN_INGRESO ORDER BY COD_INGRESO ASC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;

                $CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY COD_INGRESO DESC) ROWNUMBER FROM MN_INGRESO) AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";

				//$RS = sqlsrv_query($conn, $CONSULTA);
				////oci_execute($RS);
                $RS = sqlsrv_query($conn,$CONSULTA); 

               ?>
                <table id="Listado">
                <tr>
                    <th>Nivel</th>
                    <th>Registrado por</th>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){
                        $COD_INGRESO = $row['COD_INGRESO'];
                        $MIN_INGRESO = $row['MIN_INGRESO'];
						if(!empty($MIN_INGRESO)) {$FMIN_INGRESO=number_format($MIN_INGRESO, $CENTS, ',', '.');
						} else {$FMIN_INGRESO=0;}
                        $MAX_INGRESO = $row['MAX_INGRESO'];
						if(!empty($MAX_INGRESO)) {$FMAX_INGRESO=number_format($MAX_INGRESO, $CENTS, ',', '.');
						} else {$FMAX_INGRESO=0;}
                        $IDREG = $row['IDREG'];
                        $FECHA = $row['FECHA'];
						$CONSULTA2="SELECT NOMBRE FROM US_USUARIOS WHERE IDUSU=".$IDREG;
						
                        //$RS2 = sqlsrv_query($maestra, $CONSULTA2);
						////oci_execute($RS2);
                        $RS2 = sqlsrv_query($maestra,$CONSULTA2); 
						
                        if ($row = sqlsrv_fetch_array($RS2)) {
							$QUIENFUE = $row['NOMBRE'];
						}	
               ?>
                <tr>
                    <?php if($SESPUBLICA==1) { ?>
                    <td><a href="mant_nivingreso.php?ACT=<?php echo $COD_INGRESO?>"><?php echo $MONEDA.$FMIN_INGRESO." - ".$MONEDA.$FMAX_INGRESO?></a></td>
                    <?php } else {?>
                     <td><?php echo $MONEDA.$FMIN_INGRESO." - ".$MONEDA.$FMAX_INGRESO?></td>
                    <?php } ?>
                    <td><?php echo $QUIENFUE.", ".date_format($FECHA,"d-m-Y"); ?>
</td>
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
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('mant_nivingreso.php?LSUP=<?php echo $FILA_ANT?>&LINF=<?php echo $ATRAS?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('mant_nivingreso.php?LSUP=<?php echo $FILA_POS?>&LINF=<?php echo $ADELANTE?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina <?php echo $NUMPAG?> de <?php echo $NUMTPAG?></span>
                    </td>
                </tr>
                </table>
<?php
		sqlsrv_close( $conn );
        sqlsrv_close( $maestra );
}
?>
               
               
                <?php  if ($NEO==1) { ?>
                <table id="forma-registro">
                        <form action="mant_nivingreso_reg.php" method="post" name="forming" id="forming" onSubmit="return validaingreso(this)">
                        <tr>
                            <td><label for="MIN_INGRESO">Nivel M&iacute;nimo </label></td>
                            <td><input name="MIN_INGRESO" type="text" size="20" maxlength="200" onKeyPress="return acceptNum(event);"> </td>
                        </tr>
                        <tr>
                            <td><label for="MAX_INGRESO">Nivel M&aacute;ximo </label></td>
                            <td><input name="MAX_INGRESO" type="text" size="20" maxlength="200" onKeyPress="return acceptNum(event);"> </td>
                        </tr>
                        <tr>
                           <td></td>
                           <td><input name="INGRESAR" type="submit" value="Registrar">
                            <input name="LIMPIAR" type="reset" value="Limpiar">
                            <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_nivingreso.php')"></td>
                        </tr>
                        </form>
                </table>
                <script>
                document.forming.MIN_INGRESO.focus();
                </script>
<?php
		sqlsrv_close( $conn );
        sqlsrv_close( $maestra );
}
?>
               
               
			<?php  if ($ACT<>"") { 
				$CONSULTA="SELECT * FROM MN_INGRESO WHERE COD_INGRESO=".$ACT;
				
                //$RS = sqlsrv_query($conn, $CONSULTA);
				////oci_execute($RS);
                $RS = sqlsrv_query($conn,$CONSULTA);
				
                if ($row = sqlsrv_fetch_array($RS)) {
					$COD_INGRESO = $row['COD_INGRESO'];
					$MIN_INGRESO = $row['MIN_INGRESO'];
					$MAX_INGRESO = $row['MAX_INGRESO'];
						if(!empty($MIN_INGRESO)) {$FMIN_INGRESO=number_format($MIN_INGRESO, $CENTS, ',', '.');
						} else {$FMIN_INGRESO=0;}
                        $MAX_INGRESO = $row['MAX_INGRESO'];
						if(!empty($MAX_INGRESO)) {$FMAX_INGRESO=number_format($MAX_INGRESO, $CENTS, ',', '.');
						} else {$FMAX_INGRESO=0;}
                }
               ?>
                <h3>Actualizar: Nivel  <?php echo $MONEDA.$FMIN_INGRESO." - ".$MONEDA.$FMAX_INGRESO?></h3>
                <table id="forma-registro">
                    <form action="mant_nivingreso_reg.php" method="post" name="formact" onSubmit="return validaingreso(this)">
                    <tr>
                        <td> <label for="MIN_INGRESO">Nivel M&iacute;nimo </label> </td>
                        <td><input name="MIN_INGRESO" type="text" size="20" maxlength="200" value="<?php echo $MIN_INGRESO?>" onKeyPress="return acceptNum(event);"></td>
                    </tr>
                    <tr>
                        <td> <label for="MAX_INGRESO">Nivel M&aacute;ximo </label> </td>
                        <td><input name="MAX_INGRESO" type="text" size="20" maxlength="200" value="<?php echo $MAX_INGRESO?>" onKeyPress="return acceptNum(event);"></td>
                    </tr>
                    <tr>
                        <td><input name="COD_INGRESO" type="hidden" value="<?php echo $COD_INGRESO?>">
                        <td>
                        <input name="ACTUALIZAR" type="submit" value="Actualizar">
                        <?php
						$ELIMINAR=0;
						$CONSULTA="SELECT * FROM OP_DATACRM WHERE COD_INGRESO=".$ACT;
						
                        //$RS = sqlsrv_query($conn, $CONSULTA);
						////oci_execute($RS);
                        $RS = sqlsrv_query($conn,$CONSULTA);
						

                        if ($row = @sqlsrv_fetch_array($RS)) {
							$ELIMINAR=0;
						} else {
							$ELIMINAR=1;
						}
						if ($ELIMINAR==1) {
						?>
                        <input name="ELIMINAR" type="button" value="Eliminar" onClick="javascript:pagina('mant_nivingreso_reg.php?ELM=1&COD_INGRESO=<?php echo $COD_INGRESO ?>')">
                        <?php } ?>
                        <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_nivingreso.php')">
                        </td>
                    </tr>
                    </form>
                </table>
                <script>
                document.formact.MIN_INGRESO.focus();
                </script>
<?php
	sqlsrv_close( $conn );
    sqlsrv_close( $maestra );
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

