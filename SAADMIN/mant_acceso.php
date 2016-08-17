<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1101;
	$LIST=@$_GET["LIST"];
	$NEO=@$_GET["NEO"];
	$ACT=@$_GET["ACT"];
	if ($NEO=="" and $ACT=="") {
		 $LIST=1;
	}
	$FLT_SIS="";
	$BSC_SISTEMA=@$_POST["BSC_SISTEMA"];
	if (empty($BSC_SISTEMA)) {$BSC_SISTEMA=@$_GET["BSC_SISTEMA"];}
	if (empty($BSC_SISTEMA)) {$BSC_SISTEMA=0;}
	if ($BSC_SISTEMA!=0) {
		$FLT_SIS=" AND IDSISTEMA=".$BSC_SISTEMA;
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
if ($MSJE==1) {
$ELMSJ="Registro actualizado";
} 
if ($MSJE == 2) {
$ELMSJ="Nombre y/o Enlace no disponibles, verifique";
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
<?php if ($LIST==1) { ?>
        <table width="100%" id="Filtro">
          <tr>
            <td>
                <form action="mant_acceso.php" method="post" name="frmbuscar" id="frmbuscar">
                                <select name="BSC_SISTEMA" onChange="document.forms.frmbuscar.submit();">
                                            <option value="0">Sistema</option>
											<?php 
                                            $SQLFILTRO="SELECT * FROM US_SISTEMA WHERE IDSISTEMA IN(SELECT IDSISTEMA FROM US_ACCESO) ORDER BY NOMBRE ASC";
                                            
                                            //$RS = sqlsrv_query($conn, $SQLFILTRO);
                                            ////oci_execute($RS);
                                            $RS = sqlsrv_query($conn,$SQLFILTRO); 
                                            
                                            while ($row = sqlsrv_fetch_array($RS)) {
                                                $FLTIDSIS = $row['IDSISTEMA'];
                                                $FLTNOMB_SIS = $row['NOMBRE'];
                                             ?>
                                            <option value="<?php echo $FLTIDSIS ?>" <?php  if ($FLTIDSIS==$BSC_SISTEMA) { echo "SELECTED";}?>><?php echo $FLTNOMB_SIS ?></option>
                                            <?php 
                                            }
                                             ?>
                            </select>
                </form>

              </td>
              </tr>
              </table>
<?php }?>
                <table style="margin:10px 20px; ">
                <tr>
                <td>
<?php if ($LIST==1) { ?>

                <?php
				$CONSULTA="SELECT COUNT(*) AS CUENTA FROM US_ACCESO WHERE IDACC<>0 ".$FLT_SIS;
				
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

				//$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM US_ACCESO WHERE IDACC<>0 ".$FLT_SIS." ORDER BY TIPO ASC, NOMBRE ASC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;

                $CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY TIPO DESC) ROWNUMBER FROM US_ACCESO WHERE IDACC <> 0 ".$FLT_SIS.") AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";
				
                //$RS = sqlsrv_query($conn, $CONSULTA);
				////oci_execute($RS);
                $RS = sqlsrv_query($conn,$CONSULTA);

               ?>
                <table id="Listado">
                <tr>
                    <th>M&oacute;dulo</th>
                    <th>Sistema</th>
                    <th>Enlace</th>
                    <th>Tipo</th>
                    <th>Registrado por</th>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){
                        $IDACC = $row['IDACC'];
                        $NOMBRE = $row['NOMBRE'];
                        $TIPO = $row['TIPO'];
                        $ENLACE = $row['ENLACE'];
						if ($TIPO==1) {
							$ELTIPO="Gesti&oacute;n"; }
						if ($TIPO==2) {
							$ELTIPO="Operaci&oacute;n"; }
						if ($TIPO==3) {
							$ELTIPO="Par&aacute;metros"; }
						if ($TIPO==4) {
							$ELTIPO="Mantenci&oacute;n"; }
						if ($TIPO==5) {
							$ELTIPO="Webmaster"; }
                        $IDSISTEMA = $row['IDSISTEMA'];
						$CONSULTA2="SELECT NOMBRE FROM US_SISTEMA WHERE IDSISTEMA=".$IDSISTEMA;
						
                        //$RS2 = sqlsrv_query($conn, $CONSULTA2);
						////oci_execute($RS2);

						$RS2 = sqlsrv_query($conn,$CONSULTA2); 

                        if ($row2 = sqlsrv_fetch_array($RS2)) {
							$SISTEMA = $row2['NOMBRE'];
						}	

                        $IDREG = $row['IDREG'];
                        $FECHA = $row['FECHA'];
						$CONSULTA3="SELECT NOMBRE FROM US_USUARIOS WHERE IDUSU=".$IDREG;

						//$RS3 = sqlsrv_query($conn, $CONSULTA3);
						////oci_execute($RS3);
                        $RS3 = sqlsrv_query($conn,$CONSULTA3);

						if ($row3 = sqlsrv_fetch_array($RS3)) {
							$QUIENFUE = $row3['NOMBRE'];
						}	
               ?>
                <tr>
                    <?php if($SESPUBLICA==1) { ?>
                    <td><a href="mant_acceso.php?ACT=<?php echo $IDACC?>"><?php echo $NOMBRE." (".$IDACC.")"?></a></td>
                    <?php } else {?>
                     <td><?php echo $NOMBRE?></td>
                    <?php } ?>
                    <td><?php echo $SISTEMA?></td>
                    <td><?php echo $ENLACE?></td>
                    <td><?php echo $ELTIPO?></td>
                    <td><?php echo $QUIENFUE.", ".date_format($FECHA,"d/m/Y"); ?></td>
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
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('mant_acceso.php?LSUP=<?php echo $FILA_ANT?>&LINF=<?php echo $ATRAS?>&BSC_SISTEMA=<?php echo $BSC_SISTEMA?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('mant_acceso.php?LSUP=<?php echo $FILA_POS?>&LINF=<?php echo $ADELANTE?>&BSC_SISTEMA=<?php echo $BSC_SISTEMA?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina <?php echo $NUMPAG?> de <?php echo $NUMTPAG?></span>
                    </td>
                </tr>
                </table>
<?php }?>
<?php  if ($NEO==1) { ?>
                <table id="forma-registro">
                        <form action="mant_acceso_reg.php" method="post" name="forming" id="forming" onSubmit="return validaModulo(this)">
                        <tr>
                       <td><label for="IDSISTEMA">Sistema *</label></td>
                       <td><select name="IDSISTEMA">
                        <option value="0">Seleccionar</option>
						<?php 
                        $SQL="SELECT * FROM US_SISTEMA  ORDER BY NOMBRE ASC";

                        //$RS = sqlsrv_query($conn, $SQL);
                        ////oci_execute($RS);
                        $RS = sqlsrv_query($conn,$SQL); 

                        while ($row = sqlsrv_fetch_array($RS)) {
                            $IDSISTEMA = $row['IDSISTEMA'];
                            $NOMBSISTEMA = $row['NOMBRE'];
                         ?>
                        <option value="<?php echo $IDSISTEMA ?>"><?php echo $NOMBSISTEMA ?></option>
                        <?php 
                        }
                         ?>
                        </select></td>
                        </tr>
                        <tr>
                            <td><label for="NOMBRE">Nombre M&oacute;dulo*</label></td>
                            <td><input name="NOMBRE" type="text" size="40" maxlength="200" > </td>
                        </tr>
                        <tr>
                            <td><label for="ENLACE">Enlace *</label></td>
                            <td><input name="ENLACE" type="text" size="40" maxlength="200" > </td>
                        </tr>
                        <tr>
                       <td><label for="TIPO">Tipo *</label></td>
                       <td><select name="TIPO">
                        <option value="0">Seleccionar</option>
                        <option value="1">Gesti&oacute;n</option>
                        <option value="2">Operaci&oacute;n</option>
                        <option value="3">Par&aacute;metros</option>
                        <option value="4">Mantenci&oacute;n</option>
                        <option value="5">Webmaster</option>
                        </select></td>
                        </tr>
                        <tr>
                           <td></td>
                           <td><input name="INGRESAR" type="submit" value="Registrar">
                            <input name="LIMPIAR" type="reset" value="Limpiar">
                            <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_acceso.php')"></td>
                        </tr>
                        </form>
                </table>
<?php }?>
<?php  if ($ACT<>"") { 
				$CONSULTA="SELECT * FROM US_ACCESO WHERE IDACC=".$ACT;

				//$RS = sqlsrv_query($conn, $CONSULTA);
				////oci_execute($RS);
                $RS = sqlsrv_query($conn,$CONSULTA); 

				if ($row = sqlsrv_fetch_array($RS)) {
					$IDSISTEMA = $row['IDSISTEMA'];
					$IDACC = $row['IDACC'];
					$NOMBRE = $row['NOMBRE'];
					$ENLACE = $row['ENLACE'];
					$TIPO = $row['TIPO'];
                }
                        $SQL="SELECT * FROM US_SISTEMA WHERE IDSISTEMA=".$IDSISTEMA;

                        //$RS = sqlsrv_query($conn, $SQL);
                        ////oci_execute($RS);
                        $RS = sqlsrv_query($conn,$SQL);
                        
                        if ($row = sqlsrv_fetch_array($RS)) {
                            $NOMBSISTEMA = $row['NOMBRE'];
						}
               ?>
                <h3>Actualizar: <?php echo $NOMBRE?></h3>
                <table id="forma-registro">
                    <form action="mant_acceso_reg.php" method="post" name="formact" onSubmit="return validaModulo(this)">
                        <tr>
                       <td></td><td><h5>Sistema <?php echo $NOMBSISTEMA?></h5><input name="IDSISTEMA" type="hidden" value="<?php echo $IDSISTEMA?>"></td>
                        </tr>
                    <tr>
                        <td> <label for="NOMBRE">Nombre M&oacute;dulo *</label> </td>
                        <td><input name="NOMBRE" type="text" size="40" maxlength="200" value="<?php echo $NOMBRE?>"></td>
                    </tr>
                    <tr>
                        <td> <label for="ENLACE">Enlace *</label> </td>
                        <td><input name="ENLACE" type="text" size="40" maxlength="200" value="<?php echo $ENLACE?>"></td>
                    </tr>
                    <tr>
                        <td><label for="TIPO">Tipo *</label> </td>
                       <td><select name="TIPO">
                        <option value="0">Seleccionar</option>
                        <option value="1" <?php if ($TIPO==1) { echo "SELECTED";}?>>Gesti&oacute;n</option>
                        <option value="2" <?php if ($TIPO==2) { echo "SELECTED";}?>>Operaci&oacute;n</option>
                        <option value="3" <?php if ($TIPO==3) { echo "SELECTED";}?>>Par&aacute;metros</option>
                        <option value="4" <?php if ($TIPO==4) { echo "SELECTED";}?>>Mantenci&oacute;n</option>
                        <option value="5" <?php if ($TIPO==5) { echo "SELECTED";}?>>Webmaster</option>
                        </select></td>
                    </tr>
                    <tr>
                        <td><input name="IDACC" type="hidden" value="<?php echo $IDACC?>">
                        <td>
                        <input name="ACTUALIZAR" type="submit" value="Actualizar">
                        <?php
						$CONSULTA="SELECT * FROM US_PERFACC WHERE IDACC=".$ACT;
						
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
                        <input name="ELIMINAR" type="button" value="Eliminar" onClick="javascript:pagina('mant_acceso_reg.php?ELM=1&IDACC=<?php echo $IDACC ?>')">
                        <?php } ?>
                        <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_acceso.php')">
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
