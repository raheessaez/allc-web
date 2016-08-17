<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1112;
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
        <h2><?php echo $LAPAGINA?></h2>
                <table style="margin:10px 20px; ">
                <tr>
                <td>
<?php if ($LIST==1) { ?>
                <?php
				$CONSULTA="SELECT COUNT(*) AS CUENTA FROM MN_NEGOCIO WHERE COD_NEGOCIO<>0";
				
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
				//$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM MN_NEGOCIO  WHERE COD_NEGOCIO<>0 ORDER BY DES_NEGOCIO ASC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;

                $CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY DES_NEGOCIO ASC) ROWNUMBER FROM MN_NEGOCIO ) AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";
				//$RS = sqlsrv_query($conn, $CONSULTA);
				////oci_execute($RS);
                $RS = sqlsrv_query($conn,$CONSULTA);
               ?>
                <table id="Listado">
                <tr>
                    <th>Nombre</th>
                    <th>Registrado por</th>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){
                        $COD_NEGOCIO = $row['COD_NEGOCIO'];
                        $DES_NEGOCIO = $row['DES_NEGOCIO'];
                        $IDREG = $row['IDREG'];
                        $FECHA = $row['FECHA'];
						$CONSULTA2="SELECT NOMBRE FROM US_USUARIOS WHERE IDUSU=".$IDREG;
						//$RS2 = sqlsrv_query($conn, $CONSULTA2);
						////oci_execute($RS2);
                        $RS2 = sqlsrv_query($conn,$CONSULTA2);

						if ($row = sqlsrv_fetch_array($RS2)) {
							$QUIENFUE = $row['NOMBRE'];
						}	
               ?>
                <tr>
                    <?php if($SESPUBLICA==1) { ?>
                    <td><a href="mant_tiponeg.php?ACT=<?php echo $COD_NEGOCIO?>"><?php echo $DES_NEGOCIO?></a></td>
                    <?php } else {?>
                     <td><?php echo $DES_NEGOCIO?></td>
                    <?php } ?>
                    <td><?php echo $QUIENFUE." el ".date_format($FECHA,"d/m/Y") ?></td>
                </tr>
                <?php }?>
                <tr>
                    <td colspan="2" nowrap style="background-color:transparent">
                    <?php
                    if ($LINF>=$CTP+1) {
						$ATRAS=$LINF-$CTP;
						$FILA_ANT=$LSUP-$CTP;
                   ?>
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('mant_tiponeg.php?LSUP=<?php echo $FILA_ANT?>&LINF=<?php echo $ATRAS?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('mant_tiponeg.php?LSUP=<?php echo $FILA_POS?>&LINF=<?php echo $ADELANTE?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina <?php echo $NUMPAG?> de <?php echo $NUMTPAG?></span>
                    </td>
                </tr>
                </table>
<?php }?>
<?php  if ($NEO==1) { ?>
                <table id="forma-registro">
                        <form action="mant_tiponeg_reg.php" method="post" name="forming" id="forming" onSubmit="return validaNegocio(this)">
                        <tr>
                            <td><label for="DES_NEGOCIO">Nombre *</label></td>
                            <td><input name="DES_NEGOCIO" type="text" size="20" maxlength="200" > </td>
                        </tr>
                        <tr>
                           <td></td>
                           <td><input name="INGRESAR" type="submit" value="Registrar">
                            <input name="LIMPIAR" type="reset" value="Limpiar">
                            <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_tiponeg.php')"></td>
                        </tr>
                        </form>
                </table>
<?php }?>
<?php  if ($ACT<>"") { 
				$CONSULTA="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO=".$ACT;
				//$RS = sqlsrv_query($conn, $CONSULTA);
				////oci_execute($RS);
                $RS = sqlsrv_query($conn,$CONSULTA);

				if ($row = sqlsrv_fetch_array($RS)) {
					$COD_NEGOCIO = $row['COD_NEGOCIO'];
					$DES_NEGOCIO = $row['DES_NEGOCIO'];
                }
               ?>

                <h3>Actualizar: <?php echo @$DES_NEGOCIO?></h3>
                <table id="forma-registro">
                    <form action="mant_tiponeg_reg.php" method="post" name="formact" onSubmit="return validaNegocio(this)">
                    <tr>
                        <td> <label for="DES_NEGOCIO">Nombre *</label> </td>
                        <td><input name="DES_NEGOCIO" type="text" size="20" maxlength="200" value="<?php echo @$DES_NEGOCIO?>"></td>
                    </tr>
                    <tr>
                        <td><input name="COD_NEGOCIO" type="hidden" value="<?php echo $COD_NEGOCIO?>">
                        <td>
                        <input name="ACTUALIZAR" type="submit" value="Actualizar">
                        <?php
						$ELIMINAR=0;
						$CONSULTA="SELECT * FROM MN_NEGTND WHERE COD_NEGOCIO=".$ACT;

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
                        <input name="ELIMINAR" type="button" value="Eliminar" onClick="javascript:pagina('mant_tiponeg_reg.php?ELM=1&COD_NEGOCIO=<?php echo $COD_NEGOCIO ?>')">
                        <?php } ?>
                        <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_tiponeg.php')">
                        </td>
                    </tr>
                    </form>
                </table>
<?php }?>
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
<?php 
//sqlsrv_close($conn);
sqlsrv_close( $conn );
?>
