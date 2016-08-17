<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1109;
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
<?php
if ($MSJE==1) {
$ELMSJ="Registro actualizado";
} 
if ($MSJE == 2) {
$ELMSJ="Nombre o Carpeta no disponible, verifique";
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
<td >
        <table width="100%">
        <tr><td>
                <h2><?php echo $LAPAGINA?></h2>
                <table style="margin:10px 20px; ">
                <tr>
                <td>
<?php
if ($LIST==1) {
				$S="SELECT COUNT(*) AS CUENTA FROM US_SISTEMA WHERE IDSISTEMA<>0  ORDER BY  NOMBRE ASC";
				$RS = sqlsrv_query($conn, $S);
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
				?>
<?php if($LIST==1) { ?>                
                <?php 
				//$S="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM US_SISTEMA WHERE IDSISTEMA<>0   ORDER BY  NOMBRE ASC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;
				//$RS = sqlsrv_query($conn, $S);
				//oci_execute($RS);

                $S= "SELECT * FROM (SELECT a*,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY NOMBRE ASC) ROWNUMBER FROM US_SISTEMA WHERE ROWNUM <= ".$LSUP.") AS TABLEWITHROWNUM WHERE ROWNUM BETWEEN ".$LINF." AND ".$LSUP."";
               ?>
                <table id="Listado">
                <tr>
                    <th>Sistema</th>
                    <th>Carpeta</th>
                    <th>BD IP</th>
                    <th>BD User</th>
                    <th>BD Password</th>
                    <th>Registrado por</th>
                </tr>
                <?php
				$LOSPROCESOS="";
				$LOSDOCS="";
				while ($row = sqlsrv_fetch_array($RS)){
                        $IDSISTEMA = $row['IDSISTEMA'];
                        $NOMBRE = $row['NOMBRE'];
                        $CARPETA = $row['CARPETA'];
                        $BDIP = $row['BDIP'];
                        $BDUS = $row['BDUS'];
                        $BDPS = $row['BDPS'];
                        $IDREG = $row['IDREG'];
                        $FECHA = $row['FECHA'];
						$S2="SELECT NOMBRE FROM US_USUARIOS WHERE IDUSU=".$IDREG;
						$RS2 = sqlsrv_query($conn, $S2);
						//oci_execute($RS2);
						if ($row = sqlsrv_fetch_array($RS2)) {
							$QUIENFUE = $row['NOMBRE'];
						} else {
							$QUIENFUE = "Sistema";
						}
               ?>
                <tr>
                    <?php if($SESPUBLICA==1) { ?>
                    <td><a href="mant_sistemas.php?ACT=<?php echo $IDSISTEMA?>"><span style="font-weight:600;"><?php echo $NOMBRE?></span></a></td>
                    <?php } else {?>
                     <td><span style="font-size:14pt; font-weight:bold"><?php echo $NOMBRE?></span></td>
                    <?php } ?>
                    <td><?php echo $CARPETA;?></td>
                    <td><?php echo $BDIP;?></td>
                    <td><?php echo $BDUS;?></td>
                    <td><?php echo $BDPS;?></td>
                    <td><?php echo $QUIENFUE."<BR>".$FECHA?></td>
                </tr>
                <?php
				}
				?>
                <tr>
                    <td colspan="6" nowrap style="background-color:transparent">
                    <?php
                    if ($LINF>=$CTP+1) {
						$ATRAS=$LINF-$CTP;
						$FILA_ANT=$LSUP-$CTP;
                   ?>
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('mant_sistemas.php?LSUP=<?php echo $FILA_ANT?>&LINF=<?php echo $ATRAS?>&FNEGOCI=<?php echo $FNEGOCI?>&FDEPARTAMENTO=<?php echo $FDEPARTAMENTO?>&FCIUDAD=<?php echo $FCIUDAD?>&FESTADO=<?php echo $FESTADO?>&BLOCAL=<?php echo $BLOCAL?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('mant_sistemas.php?LSUP=<?php echo $FILA_POS?>&LINF=<?php echo $ADELANTE?>&FNEGOCI=<?php echo $FNEGOCI?>&FDEPARTAMENTO=<?php echo $FDEPARTAMENTO?>&FCIUDAD=<?php echo $FCIUDAD?>&FESTADO=<?php echo $FESTADO?>&BLOCAL=<?php echo $BLOCAL?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina <?php echo $NUMPAG?> de <?php echo $NUMTPAG?></span>
                    </td>
                </tr>
                </table>
<?php } else /*LIST=1*/ { ?>               
               <h1>No se registran Locales</h1>
<?php } ?>
<?php } ?>
<?php  if ($NEO==1) { ?>
                <table id="forma-registro">
                        <form action="mant_sistemas_reg.php" method="post" name="forming" id="forming" onSubmit="return validaSistema(this)">
                        <tr>
                            <td><label for="NOMBRE">Nombre </label></td>
                            <td><input name="NOMBRE" type="text" size="40" maxlength="200" > </td>
                        </tr>
                        <tr>
                            <td><label for="CARPETA">Carpeta </label></td>
                            <td><input name="CARPETA" type="text" size="40" maxlength="200" > </td>
                        </tr>
                        <tr>
                            <td><label for="BDIP">IP Base de Datos </label></td>
                            <td> <input name="BDIP" type="text" size="20" maxlength="15" > </td>
                        </tr>
                        <tr>
                            <td><label for="BDUS">Usuario Base de  Datos </label></td>
                            <td><input name="BDUS" type="text" size="40" maxlength="200" > </td>
                        </tr>
                        <tr>
                            <td><label for="BDPS">Password Base de  Datos </label></td>
                            <td><input name="BDPS" type="text" size="40" maxlength="200" > </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                           <input name="INGRESAR" type="submit" value="Registrar">
                            <input name="LIMPIAR" type="reset" value="Limpiar">
                            <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_sistemas.php')"></td>
                        </tr>
                        </form>
                </table>
<?php } ?>
<?php  if ($ACT<>"") { 
				$CONSULTA="SELECT * FROM US_SISTEMA WHERE IDSISTEMA=".$ACT;
				$RS = sqlsrv_query($conn, $CONSULTA);
				//oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {
					$IDSISTEMA = $row['IDSISTEMA'];
					$NOMBRE = $row['NOMBRE'];
					$CARPETA = $row['CARPETA'];
					$BDIP = $row['BDIP'];
					$BDUS = $row['BDUS'];
					$BDPS = $row['BDPS'];
                }
               ?>
                <h3>Actualizar: <?php echo $NOMBRE?></h3>
                <table id="forma-registro">
                    <form action="mant_sistemas_reg.php" method="post" name="formact" onSubmit="return validaSistema(this)">
                        <tr>
                            <td><label for="NOMBRE">Nombre </label></td>
                            <td><input name="NOMBRE" type="text" size="40" maxlength="200" value="<?php echo $NOMBRE;?>"> </td>
                        </tr>
                        <tr>
                            <td><label for="CARPETA">Carpeta </label></td>
                            <td><input name="CARPETA" type="text" size="40" maxlength="200"  value="<?php echo $CARPETA;?>"> </td>
                        </tr>
                        <tr>
                            <td><label for="BDIP">IP Base de Datos </label></td>
                            <td><input name="BDIP" type="text" size="20" maxlength="15"  value="<?php echo $BDIP;?>"> </td>
                        </tr>
                        <tr>
                            <td><label for="BDUS">Usuario Base de  Datos </label></td>
                            <td><input name="BDUS" type="text" size="40" maxlength="200"  value="<?php echo $BDUS;?>"> </td>
                        </tr>
                        <tr>
                            <td><label for="BDPS">Password Base de  Datos </label></td>
                            <td><input name="BDPS" type="text" size="40" maxlength="200"  value="<?php echo $BDPS;?>"> </td>
                        </tr>
                    <tr>
                        <td><input name="IDSISTEMA" type="hidden" value="<?php echo $IDSISTEMA?>">
                        <td>
                        <input name="ACTUALIZAR" type="submit" value="Actualizar">
                        <?php
						$CONSULTA="SELECT * FROM US_PERFIL WHERE IDSISTEMA=".$IDSISTEMA;
						$RS = sqlsrv_query($conn, $CONSULTA);
						//oci_execute($RS);
						if ($row = sqlsrv_fetch_array($RS)) {
							$ELIMINAR=0;
						} else {
							$ELIMINAR=1;
						}
						if ($ELIMINAR==1) {
						?>
                        <input name="ELIMINAR" type="button" value="Eliminar" onClick="javascript:pagina('mant_sistemas_reg.php?ELM=1&IDS=<?php echo $IDSISTEMA ?>')">
                        <?php } ?>
                        <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_sistemas.php')">
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
<?php sqlsrv_close($conn); ?>
