
<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1134;


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
	
		if (theForm.DES_EST_TARJETA.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.DES_EST_TARJETA.focus();
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
				
				$CONSULTA="SELECT COUNT(*) AS CUENTA FROM MN_EST_TARJETA";
				
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

				//$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM MN_EST_TARJETA ORDER BY COD_EST_TARJETA ASC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;
				
                $CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY COD_EST_TARJETA ASC) ROWNUMBER FROM MN_EST_TARJETA ) AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";
                //$RS = sqlsrv_query($conn, $CONSULTA);
				////oci_execute($RS);
                $RS = sqlsrv_query($conn,$CONSULTA);
               ?>
                <table id="Listado">
                <tr>
                    <th>Estado</th>
                    <th>Color</th>
                    <th>Registrado por</th>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){
                        $COD_EST_TARJETA = $row['COD_EST_TARJETA'];
                        $DES_EST_TARJETA = $row['DES_EST_TARJETA'];
                        $COL_ESTADO = $row['COL_ESTADO'];
                        $CSF_ESTADO = $row['CSF_ESTADO'];
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
                    <td><a href="mant_esttarjeta.php?ACT=<?php echo $COD_EST_TARJETA?>"><?php echo $DES_EST_TARJETA?></a></td>
                    <?php } else {?>
                     <td><?php echo $DES_EST_TARJETA?></td>
                    <?php } ?>
                    <td style="background-color:#<?php echo $COL_ESTADO?>;<?php echo $CSF_ESTADO?>"><?php echo $COL_ESTADO?></td>
                    <td><?php echo $QUIENFUE.", ".date_format($FECHA,"d-m-Y"); ?>
</td>
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
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('mant_esttarjeta.php?LSUP=<?php echo $FILA_ANT?>&LINF=<?php echo $ATRAS?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('mant_esttarjeta.php?LSUP=<?php echo $FILA_POS?>&LINF=<?php echo $ADELANTE?>');">
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
                        <form action="mant_esttarjeta_reg.php" method="post" name="forming" id="forming" onSubmit="return validaingreso(this)">
                        <tr>
                            <td><label for="DES_EST_TARJETA">Nombre Tipo </label></td>
                            <td><input name="DES_EST_TARJETA" type="text" size="20" maxlength="200" > </td>
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
                            <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_esttarjeta.php')"></td>
                        </tr>
                        </form>
                </table>
                <script>
                document.forming.DES_EST_TARJETA.focus();
                </script>
<?php
		sqlsrv_close( $conn );
        sqlsrv_close( $maestra );
}
?>
               
               
			<?php  if ($ACT<>"") { 
				$CONSULTA="SELECT * FROM MN_EST_TARJETA WHERE COD_EST_TARJETA=".$ACT;
				
                //$RS = sqlsrv_query($conn, $CONSULTA);
				////oci_execute($RS);
                $RS = sqlsrv_query($conn,$CONSULTA); 
				
                if ($row = sqlsrv_fetch_array($RS)) {
					$COD_EST_TARJETA = $row['COD_EST_TARJETA'];
					$DES_EST_TARJETA = $row['DES_EST_TARJETA'];
					$COL_ESTADO = $row['COL_ESTADO'];
					$CSF_ESTADO = $row['CSF_ESTADO'];
                }
               ?>
                <h3>Actualizar: <?php echo $DES_EST_TARJETA?></h3>
                <table id="forma-registro">
                    <form action="mant_esttarjeta_reg.php" method="post" name="formact" onSubmit="return validaingreso(this)">
                    <tr>
                        <td> <label for="DES_EST_TARJETA">Nombre Tipo </label> </td>
                        <td><input name="DES_EST_TARJETA" type="text" size="20" maxlength="200" value="<?php echo $DES_EST_TARJETA?>"></td>
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
                        <td><input name="COD_EST_TARJETA" type="hidden" value="<?php echo $COD_EST_TARJETA?>">
                        <td>
                        <input name="ACTUALIZAR" type="submit" value="Actualizar">
                        <?php
						$CONSULTA="SELECT * FROM OP_TARJETAS WHERE COD_EST_TARJETA=".$ACT;
						//$RS = sqlsrv_query($conn, $CONSULTA);
						////oci_execute($RS);
                        $RS = sqlsrv_query($conn,$CONSULTA);
						if ($row = sqlsrv_fetch_array($RS)) {
							$ELIMINAR=0;
						} else {
							$ELIMINAR=1;
						}
						if ($ELIMINAR==1) {
						?>
                        <input name="ELIMINAR" type="button" value="Eliminar" onClick="javascript:pagina('mant_esttarjeta_reg.php?ELM=1&COD_EST_TARJETA=<?php echo $COD_EST_TARJETA ?>')">
                        <?php } ?>
                        <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_esttarjeta.php')">
                        </td>
                    </tr>
                    </form>
                </table>
                <script>
                document.formact.DES_EST_TARJETA.focus();
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

