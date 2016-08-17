
<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1163;
	$NONEO=1;
	$LISTAR=1;
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
	
		if (theForm.ABR_PROCESO.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.ABR_PROCESO.focus();
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
							$ELMSJ="Nombre no disponible, verifique";
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
                <table style="margin:20px; ">
                <tr>
                <td>
                
                
<?php
if ($LIST==1) {
?>
                
                
                <?php
				
				$CONSULTA="SELECT COUNT(ID_PROCESO) AS CUENTA FROM FP_PROCESO";
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

				//$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM FP_PROCESO ORDER BY DES_PROCESO ASC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;
				
				//oci_execute($RS);

                $CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY DES_PROCESO ASC) ROWNUMBER FROM FP_PROCESO) AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";

                $RS = sqlsrv_query($conn, $CONSULTA);

               ?>
               
                <table id="Listado">
                <tr>
                    <th>Nombre<br>Descripci&oacute;n</th>
                    <th>Nombre<br>Abreviado</th>
                    <th>Registrado por</th>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){
                        $ID_PROCESO = $row['ID_PROCESO'];
                        $DES_PROCESO = $row['DES_PROCESO'];
                        $DES_CLAVE = $row['DES_CLAVE'];
                        $ABR_PROCESO = $row['ABR_PROCESO'];
						if($ABR_PROCESO=="") { $ABR_PROCESO="No registrado";}
                        $COD_USUARIO = $row['COD_USUARIO'];
                        $FEC_ACTUALIZACION = $row['FEC_ACTUALIZACION'];
						
                        $CONSULTA2="SELECT NOMBRE FROM US_USUARIOS WHERE IDUSU=".$COD_USUARIO;
						$RS2 = sqlsrv_query($maestra, $CONSULTA2);
						//oci_execute($RS2);
						if ($row = @sqlsrv_fetch_array($RS2)) {
							$QUIENFUE = $row['NOMBRE'];
						} else {
							$QUIENFUE = "Sistema";
						}
               ?>
                <tr>
                    <?php if($SESPUBLICA==1) { ?>
                    <td><a href="mant_procesos.php?ACT=<?php echo $ID_PROCESO?>"><?php echo $DES_CLAVE?></a><br><?php echo $DES_PROCESO?></td>
                    <?php } else {?>
                     <td><?php echo $DES_CLAVE?><br><?php echo $DES_PROCESO?></td>
                    <?php } ?>
                    <td><?php echo $ABR_PROCESO?></td>
                    <td><?php echo $QUIENFUE.", ".date_format($FEC_ACTUALIZACION,'d/m/Y')?></td>
                </tr>
                <?php
				}
				?>
                <tr>
                    <td colspan="4" nowrap>
                    <?php
                    if ($LINF>=$CTP+1) {
						$ATRAS=$LINF-$CTP;
						$FILA_ANT=$LSUP-$CTP;
                   ?>
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('mant_procesos.php?LSUP=<?php echo $FILA_ANT?>&LINF=<?php echo $ATRAS?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('mant_procesos.php?LSUP=<?php echo $FILA_POS?>&LINF=<?php echo $ADELANTE?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina <?php echo $NUMPAG?> de <?php echo $NUMTPAG?></span>
                    </td>
                </tr>
                </table>
<?php
		sqlsrv_close($conn);
}
?>
               
               
               
			<?php  if ($ACT<>"") { 
				$CONSULTA="SELECT * FROM FP_PROCESO WHERE ID_PROCESO=".$ACT;
				$RS = sqlsrv_query($conn, $CONSULTA);
				//oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {
					$ID_PROCESO = $row['ID_PROCESO'];
					$DES_CLAVE = $row['DES_CLAVE'];
					$DES_PROCESO = $row['DES_PROCESO'];
					$ABR_PROCESO = $row['ABR_PROCESO'];
                }
               ?>
                <h3>Actualizar: <?php echo $DES_CLAVE?></h3>
                <table id="forma-registro">
                    <form action="mant_procesos_reg.php" method="post" name="formact" onSubmit="return validaingreso(this)">
                    <tr>
                        <td> <label for="DES_PROCESO1">Descripci&oacute;n Proceso</label> </td>
                        <td><h5><?php echo $DES_PROCESO?></h5></td>
                    </tr>
                    <tr>
                        <td> <label for="ABR_PROCESO">Nombre Abreviado </label> </td>
                        <td><input name="ABR_PROCESO" type="text" size="20" maxlength="18" value="<?php echo $ABR_PROCESO?>"></td>
                    </tr>
                    <tr>
                        <td><input name="ID_PROCESO" type="hidden" value="<?php echo $ID_PROCESO?>">
                        <td>
                        <input name="ACTUALIZAR" type="submit" value="Actualizar">
                        <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_procesos.php')">
                        </td>
                    </tr>
                    </form>
                </table>
                <script>
                document.formact.ABR_PROCESO.focus();
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

