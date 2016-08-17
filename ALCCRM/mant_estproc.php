
<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1133;


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
	
		if (theForm.VAL_ESTADO.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.VAL_ESTADO.focus();
			return false;
	}

		if (theForm.DES_ESTADO.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.DES_ESTADO.focus();
			return false;
	}

		if (theForm.ABR_ESTADO.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.ABR_ESTADO.focus();
			return false;
	}

		if (theForm.COL_ESTADO.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.COL_ESTADO.focus();
			return false;
	}

		if (theForm.CSF_ESTADO.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.CSF_ESTADO.focus();
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
if ($MSJE==2) {$ELMSJ="Valor estado no disponible, verifique";}
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
				
				$S="SELECT COUNT(*) AS CUENTA FROM MN_ESTADO";
				
                //$RS = sqlsrv_query($conn, $S);
				////oci_execute($RS);
				$RS = sqlsrv_query($conn,$S);

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

				//$S="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM MN_ESTADO ORDER BY VAL_ESTADO ASC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;
				
                $S= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY VAL_ESTADO ASC) ROWNUMBER FROM MN_ESTADO) AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";

                //$RS = sqlsrv_query($conn, $S);
				////oci_execute($RS);
                $RS = sqlsrv_query($conn,$S); 

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
                        $COD_ESTADO = $row['COD_ESTADO'];
                        $VAL_ESTADO = $row['VAL_ESTADO'];
                        $DES_ESTADO = $row['DES_ESTADO'];
                        $ABR_ESTADO = $row['ABR_ESTADO'];
                        $COL_ESTADO = $row['COL_ESTADO'];
                        $CSF_ESTADO = $row['CSF_ESTADO'];
                        $IDREG = $row['IDREG'];
                        $FECHA = $row['FECHA'];
						$S2="SELECT NOMBRE FROM US_USUARIOS WHERE IDUSU=".$IDREG;
						
                        //$RS2 = sqlsrv_query($maestra, $S2);
						////oci_execute($RS2);
						$RS2 = sqlsrv_query($maestra,$S2);

                        if ($row = sqlsrv_fetch_array($RS2)) {
							$QUIENFUE = $row['NOMBRE'];
						}	
               ?>
                <tr>
                    <?php if($SESPUBLICA==1) { ?>
                    <td><a href="mant_estproc.php?ACT=<?php echo $COD_ESTADO?>"><?php echo $DES_ESTADO?></a></td>
                    <?php } else {?>
                     <td><?php echo $DES_ESTADO?></td>
                    <?php } ?>
                     <td><?php echo $ABR_ESTADO?></td>
                    <td><?php echo $VAL_ESTADO?></td>
                    <td style="background-color:#<?php echo $COL_ESTADO?>;<?php echo $CSF_ESTADO?>"><?php echo $COL_ESTADO?></td>
                    <td><?php echo $QUIENFUE.", ".date_format($FECHA,"d-m-Y")?>
</td>
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
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('mant_estproc.php?LSUP=<?php echo $FILA_ANT?>&LINF=<?php echo $ATRAS?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('mant_estproc.php?LSUP=<?php echo $FILA_POS?>&LINF=<?php echo $ADELANTE?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina <?php echo $NUMPAG?> de <?php echo $NUMTPAG?></span>
                    </td>
                </tr>
                </table>
<?php
        sqlsrv_close( $conn );
        sqlsrv_close( $maestra );
		//sqlsrv_close($conn);
		//sqlsrv_close($maestra);
}
?>
               
               
                <?php  if ($NEO==1) { ?>
                <table id="forma-registro">
                        <form action="mant_estproc_reg.php" method="post" name="forming" id="forming" onSubmit="return validaingreso(this)">
                        <tr>
                            <td><label for="VAL_ESTADO">Valor Estado </label></td>
                            <td><input name="VAL_ESTADO" type="text" size="2" maxlength="2" > </td>
                        </tr>
                        <tr>
                            <td><label for="DES_ESTADO">Descripci&oacute;n </label></td>
                            <td><input name="DES_ESTADO" type="text" size="40" maxlength="75" > </td>
                        </tr>
                        <tr>
                            <td><label for="ABR_ESTADO">Abreviatura </label></td>
                            <td><input name="ABR_ESTADO" type="text" size="10" maxlength="10" > </td>
                        </tr>
                        <tr>
                            <td><label for="COL_ESTADO">Color </label></td>
                            <td><input name="COL_ESTADO" type="text" size="10" maxlength="7" > </td>
                        </tr>
                        <tr>
                            <td><label for="CSF_ESTADO">Formato Texto </label></td>
                            <td><input name="CSF_ESTADO" type="text" size="60" maxlength="250" > </td>
                        </tr>
                        <tr>
                           <td></td>
                           <td><input name="INGRESAR" type="submit" value="Registrar">
                            <input name="LIMPIAR" type="reset" value="Limpiar">
                            <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_estproc.php')"></td>
                        </tr>
                        </form>
                </table>
                <script>
                document.forming.VAL_ESTADO.focus();
                </script>
<?php
		//sqlsrv_close($conn);
		//sqlsrv_close($maestra);
        sqlsrv_close( $conn );
        sqlsrv_close( $maestra );
}
?>
               
               
			<?php  if ($ACT<>"") { 
				$S="SELECT * FROM MN_ESTADO WHERE COD_ESTADO=".$ACT;
				
                //$RS = sqlsrv_query($conn, $S);
				////oci_execute($RS);
                $RS = sqlsrv_query($conn,$S);  

				
                if ($row = sqlsrv_fetch_array($RS)) {
					$COD_ESTADO = $row['COD_ESTADO'];
					$VAL_ESTADO = $row['VAL_ESTADO'];
					$DES_ESTADO = $row['DES_ESTADO'];
					$ABR_ESTADO = $row['ABR_ESTADO'];
					$COL_ESTADO = $row['COL_ESTADO'];
					$CSF_ESTADO = $row['CSF_ESTADO'];
                }
               ?>
                <h3>Actualizar: <?php echo $DES_ESTADO?></h3>
                <table id="forma-registro">
                    <form action="mant_estproc_reg.php" method="post" name="formact" onSubmit="return validaingreso(this)">
                        <tr>
                            <td><label for="VAL_ESTADO">Valor Estado </label></td>
                            <td><input name="VAL_ESTADO" type="text" size="2" maxlength="2" value="<?php echo $VAL_ESTADO?>" > </td>
                        </tr>
                        <tr>
                            <td><label for="DES_ESTADO">Descripci&oacute;n </label></td>
                            <td><input name="DES_ESTADO" type="text" size="40" maxlength="75" value="<?php echo $DES_ESTADO?>"  > </td>
                        </tr>
                        <tr>
                            <td><label for="ABR_ESTADO">Abreviatura </label></td>
                            <td><input name="ABR_ESTADO" type="text" size="10" maxlength="10" value="<?php echo $ABR_ESTADO?>"  > </td>
                        </tr>
                        <tr>
                            <td><label for="COL_ESTADO">Color </label></td>
                            <td><input name="COL_ESTADO" type="text" size="10" maxlength="7" value="<?php echo $COL_ESTADO?>"  > </td>
                        </tr>
                        <tr>
                            <td><label for="CSF_ESTADO">Formato Texto </label></td>
                            <td><input name="CSF_ESTADO" type="text" size="60" maxlength="250" value="<?php echo $CSF_ESTADO?>"  > </td>
                        </tr>
                    <tr>
                        <td><input name="COD_ESTADO" type="hidden" value="<?php echo $COD_ESTADO?>">
                        <td>
                        <input name="ACTUALIZAR" type="submit" value="Actualizar">
                        <?php
						$ELIMINAR=0;
						/*
						$S="SELECT * FROM OP_DATACRM WHERE COD_ESTADO=".$COD_ESTADO;
						$RS = sqlsrv_query($conn, $S);
						//oci_execute($RS);
						if ($row = sqlsrv_fetch_array($RS)) {
							$ELIMINAR=0;
						} else {
							$ELIMINAR=1;
						}
						*/
						if ($ELIMINAR==1) {
						?>
                        <input name="ELIMINAR" type="button" value="Eliminar" onClick="javascript:pagina('mant_estproc_reg.php?ELM=1&COD_ESTADO=<?php echo $COD_ESTADO ?>')">
                        <?php } ?>
                        <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_estproc.php')">
                        </td>
                    </tr>
                    </form>
                </table>
                <script>
                document.formact.DES_ESTADO.focus();
                </script>
<?php
	   	//sqlsrv_close($conn);
		//sqlsrv_close($maestra);
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

