<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1116;
	$LIST=@$_GET["LIST"];
	$NEO=@$_GET["NEO"];
	$ACT=@$_GET["ACT"];
	if ($NEO=="" and $ACT=="") {
		 $LIST=1;
	}
?>
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
                <table style="margin:10px 20px; ">
                <tr>
                <td>
<?php
if ($LIST==1) {
?>
                <h2><?php echo $LAPAGINA?></h2>
                <?php
				$CONSULTA="SELECT COUNT(*) AS CUENTA FROM PM_DEPARTAMENTO WHERE COD_DEPARTAMENTO<>0";
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
				//$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM PM_DEPARTAMENTO WHERE COD_DEPARTAMENTO<>0 ORDER BY DES_DEPARTAMENTO ASC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;
                $CONSULTA= "SELECT * FROM (SELECT a*,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY DES_DEPARTAMENTO ASC) ROWNUMBER FROM PM_DEPARTAMENTO WHERE COD_DEPARTAMENTO <> 0) AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";



				$RS = sqlsrv_query($conn, $CONSULTA);
				//oci_execute($RS);
               ?>
                <table id="Listado">
                <tr>
                    <td style="background-color:transparent; vertical-align:bottom"><span class="txtBold">Nombre</span></td>
                    <td style="background-color:transparent; vertical-align:bottom"><span class="txtBold">Registrado por</span></td>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){
                        $COD_DEPARTAMENTO = $row['COD_DEPARTAMENTO'];
                        $DES_DEPARTAMENTO = $row['DES_DEPARTAMENTO'];
                        $IDREG = $row['IDREG'];
                        $FECHA = $row['FECHA'];
						$CONSULTA2="SELECT NOMBRE FROM US_USUARIOS WHERE IDUSU=".$IDREG;
						$RS2 = sqlsrv_query($conn, $CONSULTA2);
						//oci_execute($RS2);
						if ($row = sqlsrv_fetch_array($RS2)) {
							$QUIENFUE = $row['NOMBRE'];
						}	
               ?>
                <tr>
                    <?php if($SESPUBLICA==1) { ?>
                    <td><a href="mant_depto.php?ACT=<?php echo $COD_DEPARTAMENTO?>"><?php echo $DES_DEPARTAMENTO?></a></td>
                    <?php } else {?>
                     <td><?php echo $DES_DEPARTAMENTO?></td>
                    <?php } ?>
                    <td><?php echo $QUIENFUE." el ".$FECHA?></td>
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
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('mant_depto.php?LSUP=<?php echo $FILA_ANT?>&LINF=<?php echo $ATRAS?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('mant_depto.php?LSUP=<?php echo $FILA_POS?>&LINF=<?php echo $ADELANTE?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina <?php echo $NUMPAG?> de <?php echo $NUMTPAG?></span>
                    </td>
                </tr>
                </table>
<?php } ?>
<?php  if ($NEO==1) { ?>
                <h2>Nuevo Registro</h2>
                <table id="forma-registro">
                        <form action="mant_depto_reg.php" method="post" name="forming" id="forming" onSubmit="return validaDepartamento(this)">
                        <tr>
                            <td><label for="DES_DEPARTAMENTO">Nombre </label></td>
                            <td><input name="DES_DEPARTAMENTO" type="text" size="20" maxlength="200" > </td>
                        </tr>
                        <tr>
                           <td></td>
                           <td><input name="INGRESAR" type="submit" value="Registrar">
                            <input name="LIMPIAR" type="reset" value="Limpiar">
                            <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_depto.php')"></td>
                        </tr>
                        </form>
                </table>
<?php }?>
<?php  if ($ACT<>"") { 
				$CONSULTA="SELECT * FROM PM_DEPARTAMENTO WHERE COD_DEPARTAMENTO=".$ACT;
				$RS = sqlsrv_query($conn, $CONSULTA);
				//oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {
					$COD_DEPARTAMENTO = $row['COD_DEPARTAMENTO'];
					$DES_DEPARTAMENTO = $row['DES_DEPARTAMENTO'];
                }
               ?>
                <h2>Actualizar: <?php echo $DES_DEPARTAMENTO?></h2>
                <table id="forma-registro">
                    <form action="mant_depto_reg.php" method="post" name="formact" onSubmit="return validaDepartamento(this)">
                    <tr>
                        <td> <label for="DES_DEPARTAMENTO">Nombre </label> </td>
                        <td><input name="DES_DEPARTAMENTO" type="text" size="20" maxlength="200" value="<?php echo $DES_DEPARTAMENTO?>"></td>
                    </tr>
                    <tr>
                        <td><input name="COD_DEPARTAMENTO" type="hidden" value="<?php echo $COD_DEPARTAMENTO?>">
                        <td>
                        <input name="ACTUALIZAR" type="submit" value="Actualizar">
                        <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_depto.php')">
                        </td>
                    </tr>
                    </form>
                </table>
<?php } ?>
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
<?php sqlsrv_close($conn); ?>
