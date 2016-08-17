<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1102;
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
        <table width="100%">
        <tr><td>
        <h2><?php echo $LAPAGINA?></h2>
<?php if ($LIST==1) { ?>
        <table width="100%" id="Filtro">
          <tr>
            <td>
                <form action="mant_perfil.php" method="post" name="frmbuscar" id="frmbuscar">
                                <select name="BSC_SISTEMA" onChange="document.forms.frmbuscar.submit();">
                                            <option value="0">Sistema</option>
											<?php 
                                            $SQLFILTRO="SELECT * FROM US_SISTEMA WHERE IDSISTEMA IN(SELECT IDSISTEMA FROM US_PERFIL) ORDER BY NOMBRE ASC";
                                            
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
                <?php
					if ($MSJE==1) {
							$ELMSJ="Nombre no disponible, verifique";
						} 
					if ($MSJE == 2) {
							$ELMSJ="Debe seleccionar el acceso predeterminado (ACC)";
						} 
					if ($MSJE == 3) {
							$ELMSJ="Debe seleccionar al menos un acceso (ACC)";
					}
					if ($MSJE == 4) {
							$ELMSJ="Registro Perfil/Acceso no disponible, verifique)";
					}
					if ($MSJE == 5) {
							$ELMSJ="Registro actualizado";
					}
					if ($MSJE == 6) {
							$ELMSJ="Registro eliminado";
					}
					if ($MSJE == 7) {
							$ELMSJ="Registro realizado";
					}
					if ($MSJE <> "") {
               ?>
                <div id="GMessaje" onClick="QuitarGMessage();"><a href="#" onClick="QuitarGMessage();" style="color:#111111;"><?php echo $ELMSJ?></a></div>
                <?php }?>
<?php if ($LIST==1) { ?>
                <?php
				$CONSULTA="SELECT COUNT(*) AS CUENTA FROM US_PERFIL WHERE IDPERFIL<>0 ".$FLT_SIS;
				
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
                if ($SESPWM==1) {
						//$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM US_PERFIL WHERE IDPERFIL<>0 ".$FLT_SIS." ORDER BY NOMBRE ASC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;
                        $CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY NOMBRE ASC) ROWNUMBER FROM US_PERFIL WHERE IDPERFIL <> 0  ".$FLT_SIS.") AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";
				} else {
						//$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM US_PERFIL WHERE WM=0 ".$FLT_SIS." ORDER BY NOMBRE ASC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;
                        $CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY NOMBRE ASC) ROWNUMBER FROM US_PERFIL WHERE WM=0  ".$FLT_SIS.") AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";
				}
				
                //$RS = sqlsrv_query($conn, $CONSULTA);
				////oci_execute($RS);

                $RS = sqlsrv_query($conn,$CONSULTA);  

               ?>
                <table id="Listado">
                <tr>
                <th>Sistema</th>
                <th>Nombre</th>
				<?php if($SESPWM==1) { ?>
                <th>Webmaster</th>
                <?php } ?>
                <th>Edici&oacute;n</th>
                <th>Registrado por</th>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){
                        $IDSISTEMA = $row['IDSISTEMA'];
                        $IDPERFIL = $row['IDPERFIL'];
                        $NOMBRE = $row['NOMBRE'];
                        $EDITAR = $row['EDITAR'];
                        $WM = $row['WM'];
						if ($EDITAR==1) {
							$ELEDITAR="SI"; }
						if ($EDITAR==0) {
							$ELEDITAR="NO"; }
						if ($WM==1) {
							$ESWEBMASTER="SI"; }
						if ($WM==0) {
							$ESWEBMASTER="NO"; }
                        $IDREG = $row['IDREG'];
                        $FECHA = $row['FECHA'];
						$CONSULTA2="SELECT NOMBRE FROM US_USUARIOS WHERE IDUSU=".$IDREG;
						
                        //$RS2 = sqlsrv_query($conn, $CONSULTA2);
						////oci_execute($RS2);
                        $RS2 = sqlsrv_query($conn,$CONSULTA2);  
						
                        if ($row2 = sqlsrv_fetch_array($RS2)) {
							$QUIENFUE = $row2['NOMBRE'];
						}	
						$CONSULTA2="SELECT NOMBRE FROM US_SISTEMA WHERE IDSISTEMA=".$IDSISTEMA;
						
                        //$RS2 = sqlsrv_query($conn, $CONSULTA2);
						////oci_execute($RS2);
						$RS2 = sqlsrv_query($conn,$CONSULTA2);  

                        if ($row2 = sqlsrv_fetch_array($RS2)) {
							$SISTEMA = $row2['NOMBRE'];
						}	
               ?>
                <tr>
                     <td ><?php echo $SISTEMA?></td>
                    <?php if($SESPUBLICA==1) { ?>
                    <td><a href="mant_perfil.php?ACT=<?php echo $IDPERFIL?>"><?php echo $NOMBRE?></a></td>
                    <?php } else {?>
                     <td><?php echo $NOMBRE?></td>
                    <?php } ?>
					<?php if($SESPWM==1) { ?>
                    <td align="center"><?php echo $ESWEBMASTER?></td>
                    <?php } ?>
                    <td align="center"><?php echo $ELEDITAR?></td>
                    <td><?php echo $QUIENFUE.", ".date_format($FECHA,"d-m-Y"); ?></td>
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
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('mant_perfil.php?LSUP=<?php echo $FILA_ANT?>&LINF=<?php echo $ATRAS?>&BSC_SISTEMA=<?php echo $BSC_SISTEMA?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('mant_perfil.php?LSUP=<?php echo $FILA_POS?>&LINF=<?php echo $ADELANTE?>&BSC_SISTEMA=<?php echo $BSC_SISTEMA?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina <?php echo $NUMPAG?> de <?php echo $NUMTPAG?></span>
                    </td>
                </tr>
                </table>
<?php }?>
<?php  if ($NEO==1) { ?>
                <table id="forma-registro">
                        <form action="mant_perfil_reg.php" method="post" name="forming" id="forming" onSubmit="return validaPerfil(this)">
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
                            <td><label for="NOMBRE">Nombre *</label></td>
                            <td><input name="NOMBRE" type="text" size="40" maxlength="200" > </td>
                        </tr>
                        <tr>
                            <td><label for="EDITAR">Edici&oacute;n</label></td>
                            <td ><select name="EDITAR">
                            <option value="0">NO</option>
                            <option value="1">SI</option>
                            </select></td>
                        </tr>
						<?php if ($SESPWM==1) {?>
                        <tr>
                            <td><label for="WM">WM</label></td>
                            <td ><select name="WM">
                            <option value="0">NO</option>
                            <option value="1">SI</option>
                            </select></td>
                        </tr>
                        <?php } ?>
                        <tr>
                           <td></td>
                           <td><input name="INGRESAR" type="submit" value="Registrar">
                            <input name="LIMPIAR" type="reset" value="Limpiar">
                            <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_perfil.php')"></td>
                        </tr>
                        </form>
                </table>
<?php }?>
<?php  if ($ACT<>"") { 
				$CONSULTA="SELECT * FROM US_PERFIL WHERE IDPERFIL=".$ACT;
				
                //$RS = sqlsrv_query($conn, $CONSULTA);
				////oci_execute($RS);
                $RS = sqlsrv_query($conn,$CONSULTA); 
				
                if ($row = sqlsrv_fetch_array($RS)) {
					$IDSISTEMA = $row['IDSISTEMA'];
					$IDPERFIL = $row['IDPERFIL'];
					$NOMBRE = $row['NOMBRE'];
					$EDITAR = $row['EDITAR'];
					$WM = $row['WM'];
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
                    <form action="mant_perfil_reg.php" method="post" name="formact" onSubmit="return validaPerfil(this)">
                    <tr>
                   <td><label for="IDSISTEMA">Sistema</label></td>
                   <td><h5><?php echo $NOMBSISTEMA?></h5><input name="IDSISTEMA" type="hidden" value="<?php echo $IDSISTEMA?>"></td>
                    </tr>
                    <tr>
                        <td> <label for="NOMBRE">Nombre</label> </td>
                        <td><input name="NOMBRE" type="text" size="40" maxlength="200" value="<?php echo $NOMBRE?>"></td>
                    </tr>
                        <tr>
                            <td><label for="EDITAR">Edici&oacute;n</label></td>
                            <td ><select name="EDITAR">
                            <option value="0" <?php if ($EDITAR==0) { echo "SELECTED";}?>>NO</option>
                            <option value="1" <?php if ($EDITAR==1) { echo "SELECTED";}?>>SI</option>
                            </select></td>
                        </tr>
						<?php if ($SESPWM==1) {?>
                        <tr>
                            <td><label for="WM">WM</label></td>
                            <td ><select name="WM">
                            <option value="0" <?php if ($WM==0) { echo "SELECTED";}?>>NO</option>
                            <option value="1" <?php if ($WM==1) { echo "SELECTED";}?>>SI</option>
                            </select></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td style="vertical-align:top"><label for="ACCESO">Acceso(s)</label></td>
                            <td><table id="Listado">
                            <?php 
							$ACCESOACTIVO=0;
                            $INGRESO=0;
							if ($SESPWM==1) { 
									$CONSULTA="SELECT IDACC, NOMBRE, TIPO  FROM US_ACCESO WHERE IDSISTEMA=".$IDSISTEMA." ORDER BY TIPO ASC, NOMBRE ASC";
							} else {
									$CONSULTA="SELECT IDACC, NOMBRE, TIPO  FROM US_ACCESO  WHERE IDSISTEMA=".$IDSISTEMA."  AND TIPO<>5 ORDER BY TIPO ASC, NOMBRE ASC";
							}

							//$RS = sqlsrv_query($conn, $CONSULTA);
							////oci_execute($RS);
                            $RS = sqlsrv_query($conn,$CONSULTA);
							
                            $CUENTA=0;
							while ($row = sqlsrv_fetch_array($RS)){
								 $IDACC = $row['IDACC'];
								 $NOMBRE = $row['NOMBRE'];
								 $ACCTIPO = $row['TIPO'];
								if ($ACCTIPO==1) {
									$ESACCTIPO="Gesti&oacute;n"; }
								if ($ACCTIPO==2) {
									$ESACCTIPO="Operaci&oacute;n"; }
								if ($ACCTIPO==3) {
									$ESACCTIPO="Par&aacute;metros"; }
								if ($ACCTIPO==4) {
									$ESACCTIPO="Mantenci&oacute;n"; }
								if ($ACCTIPO==5) {
									$ESACCTIPO="Webmaster"; }
								$CONSULTA2="SELECT * FROM US_PERFACC WHERE IDPERFIL=".$ACT." AND IDACC=".$IDACC;
								
                                //$RS2 = sqlsrv_query($conn, $CONSULTA2);
								////oci_execute($RS2);
								$RS2 = sqlsrv_query($conn,$CONSULTA2);

                                if ($row = sqlsrv_fetch_array($RS2)) {
									$INGRESO = $row['INGRESO'];
									$ACCESOACTIVO=1;
								}	else {
									$INGRESO=0;
									$ACCESOACTIVO=0;
								}
                             ?>
                            <tr>
                            <td>ACC</td>
                            <td><input name="IDACC<?php echo $IDACC ?>" type="checkbox" value="<?php echo $IDACC ?>"  <?php if($ACCESOACTIVO==1) { ?> checked <?php } ?>></td>
                            <td>ING</td>
                            <td><input type="radio" name="INGRESO" value="<?php echo $IDACC ?>" <?php if($INGRESO==1) { ?> checked <?php } ?>></td>
                            <td><?php echo $NOMBRE." (".$ESACCTIPO.")" ?></td>
                            </tr>
                            <?php 
							}
                             ?>
                             <tr><td colspan="5"></td></tr>
                            </table></td>
                        </tr>
                    <tr>
                        <td><input name="IDPERFIL" type="hidden" value="<?php echo $IDPERFIL?>">
                        <?php if($SESPWM==0) { ?><input name="WM" type="hidden" value="<?php echo $WM ?>"><?php } ?>
                        <td>
                        <input name="ACTUALIZAR" type="submit" value="Actualizar">
                        <?php
						$CONSULTA="SELECT * FROM US_USUPERF WHERE IDPERFIL=".$ACT;

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
                        <input name="ELIMINAR" type="button" value="Eliminar" onClick="javascript:pagina('mant_perfil_reg.php?ELM=1&IDPERFIL=<?php echo $IDPERFIL ?>')">
                        <?php } ?>
                        <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_perfil.php')">
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
