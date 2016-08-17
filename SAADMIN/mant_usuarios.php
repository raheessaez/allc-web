<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1103;
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
		$FLT_SIS=" AND IDUSU IN(SELECT IDUSU FROM US_USUPERF WHERE IDSISTEMA=".$BSC_SISTEMA.")";
		}

	$FLT_TUSU="";
	$BSC_TIPOUSU=@$_POST["BSC_TIPOUSU"];
	if (empty($BSC_TIPOUSU)) {$BSC_TIPOUSU=@$_GET["BSC_TIPOUSU"];}
	if (empty($BSC_TIPOUSU)) {$BSC_TIPOUSU=0;}
	if ($BSC_TIPOUSU==1) { $FLT_TUSU=" AND CC_OPERADOR=0";}
	if ($BSC_TIPOUSU==2) { $FLT_TUSU=" AND CC_OPERADOR<>0";}
	$FLT_USU="";
	$BSC_USU=@$_POST["BSC_USU"];
	if (empty($BSC_USU)) {$BSC_USU=@$_GET["BSC_USU"];}
	if (!empty($BSC_USU)) {
		$FLT_USU=" AND UPPER(NOMBRE) Like '%".strtoupper($BSC_USU)."%' ";
		}

?>

<?php
  if ($ACT<>"") { 
				$ENC=@$_GET["ENC"];
				$PERF=@$_GET["PERF"];
				$TND=@$_GET["TND"];
				if ($PERF=="" && $TND=="" ) {  $ENC=1; }
				$CONSULTA="SELECT * FROM US_USUARIOS WHERE IDUSU=".$ACT;
				$RS = sqlsrv_query($conn, $CONSULTA);
				//oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {
					$IDUSU = $row['IDUSU'];
					$NOMBRE = $row['NOMBRE'];
					$EMAIL = $row['EMAIL'];
					$ESTADO = $row['ESTADO'];
					$CUENTA = $row['CUENTA'];
					$CLAVE = $row['CLAVE'];
					$CC_OPERADOR = $row['CC_OPERADOR'];
                }
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
$ELMSJ="Cuenta no disponible, verifique";
} 
if ($MSJE == 3) {
$ELMSJ="Registro realizado";
}
if ($MSJE == 4) {
$ELMSJ="Perfil de usuario retirado";
}
if ($MSJE == 5) {
$ELMSJ="Nuevo Perfil asociado";
}
if ($MSJE == 6) {
$ELMSJ="Nueva Tienda asociada";
}
if ($MSJE == 7) {
$ELMSJ="Se ha retirado la Tienda Asociada";
}
if ($MSJE <> "") {
?>
<div id="GMessaje" onClick="QuitarGMessage();"><a href="#" onClick="QuitarGMessage();" style="color:#111111;"><?php echo $ELMSJ?></a></div>
<?php }?>
        <table width="100%">
        <tr><td>
        <h2><?php echo $LAPAGINA?></h2>
<?php if ($LIST==1) {?>
        <table width="100%" id="Filtro">
          <tr>
            <td>
                <form action="mant_usuarios.php" method="post" name="frmbuscar" id="frmbuscar">
                                <select name="BSC_SISTEMA" onChange="document.forms.frmbuscar.submit();">
                                            <option value="0">Sistema</option>
											<?php 
                                            $SQLFILTRO="SELECT * FROM US_SISTEMA WHERE IDSISTEMA IN(SELECT IDSISTEMA FROM US_PERFIL) ORDER BY NOMBRE ASC";
                                            $RS = sqlsrv_query($conn, $SQLFILTRO);
                                            //oci_execute($RS);
                                            while ($row = sqlsrv_fetch_array($RS)) {
                                                $FLTIDSIS = $row['IDSISTEMA'];
                                                $FLTNOMB_SIS = $row['NOMBRE'];
                                             ?>
                                            <option value="<?php echo $FLTIDSIS ?>" <?php  if ($FLTIDSIS==$BSC_SISTEMA) { echo "SELECTED";}?>><?php echo $FLTNOMB_SIS ?></option>
                                            <?php 
                                            }
                                             ?>
                            </select>
                            <select name="BSC_TIPOUSU" onChange="document.forms.frmbuscar.submit();">
                                            <option value="0">Tipo Usuario</option>
                                            <option value="1" <?php  if ($BSC_TIPOUSU==1) { echo "SELECTED";}?>>Usuario Suite</option>
                                            <option value="2" <?php  if ($BSC_TIPOUSU==2) { echo "SELECTED";}?>>Operador Tienda</option>
                            </select>
                			<input style="text-transform:uppercase" type="text" id="BSC_USU" name="BSC_USU" value="<?= $BSC_USU?>">
                            <input type="submit" id="BSC_USU" value="Buscar Usuario">
                            <input type="button" id="BSC_USU" value="Limpiar" onClick="pagina('mant_usuarios.php');">
                </form>
              </td>
              </tr>
              </table>
<?php } ?>
                <table style="margin:10px 20px; ">
                <tr>
                <td>
<?php if ($LIST==1) { ?>
                <?php
				$CONSULTA="SELECT COUNT(IDUSU) AS CUENTA FROM US_USUARIOS WHERE IDUSU<>0".$FLT_SIS.$FLT_TUSU.$FLT_USU;
              
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
                if ($SESPWM==1) {
					//$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM US_USUARIOS WHERE IDUSU<>0 ".$FLT_SIS.$FLT_TUSU.$FLT_USU." ORDER BY NOMBRE ASC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;
                     $CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY NOMBRE ASC) ROWNUMBER FROM US_USUARIOS WHERE IDUSU<>0 ".$FLT_SIS.$FLT_TUSU.$FLT_USU.") AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";

				} else {
					//$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM US_USUARIOS WHERE IDUSU<>0 ".$FLT_SIS.$FLT_TUSU.$FLT_USU.") ";
					//$CONSULTA=$CONSULTA."  ORDER BY NOMBRE ASC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;
                     $CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY NOMBRE ASC) ROWNUMBER FROM US_USUARIOS WHERE IDUSU<>0 ".$FLT_SIS.$FLT_TUSU.$FLT_USU.") AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";
                     
                }
				$RS = sqlsrv_query($conn, $CONSULTA);
				//oci_execute($RS);
               ?>
                <table id="Listado">
                <tr>
                    <th>Nombre/ e-mail</th>
                    <th>Perfil(es) ARMS</th>
                    <th>Tipo Usuario</th>
                    <th>Estado</th>
                    <th>Registrado por</th>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){
                        $IDUSU = $row['IDUSU'];
                        $NOMBRE = $row['NOMBRE'];
						if($BSC_USU!="") {
								$NOMBRE=str_replace(strtoupper($BSC_USU),'<span style="background-color:#FFF9C4;">'.strtoupper($BSC_USU).'</span>', strtoupper($NOMBRE)); 
						}
                        $EMAIL = $row['EMAIL'];
                        $CC_OPERADOR = $row['CC_OPERADOR'];
						if($CC_OPERADOR==0){
							$TIPOUS="Usuario Suite";
						} else {
							$TIPOUS="Operador Tienda";
						}
                        $ESTADO = $row['ESTADO'];
                        $IDREG = $row['IDREG'];
                        $FECHA = $row['FECHA'];
						if(empty($EMAIL)) {$EMAIL="No registrado"; }
						$PERFILES="";
						$REG_PERFIL=0;
						//VERIFICA SI TIENE PERFIL ASOCIADO
						$SQL_NPF="SELECT COUNT(IDPERFIL) AS CPERFIL  FROM US_USUPERF WHERE IDUSU=".$IDUSU;
						$RS_NPF = sqlsrv_query($conn, $SQL_NPF);
						//oci_execute($RS_NPF);
						if ($ROW_NPF = sqlsrv_fetch_array($RS_NPF)) {
								$REG_PERFIL = $ROW_NPF['CPERFIL'];
						}
						if ($REG_PERFIL!=0 or !empty($REG_PERFIL)) {
								$SQL_UP="SELECT * FROM US_USUPERF WHERE IDUSU=".$IDUSU." ORDER BY IDSISTEMA ASC";
								$RS_UP = sqlsrv_query($conn, $SQL_UP);
								//oci_execute($RS_UP);
								while ($ROW_UP = sqlsrv_fetch_array($RS_UP)) {
									$IDPERFIL_US = $ROW_UP['IDPERFIL'];
									$IDSISTEMA_US = $ROW_UP['IDSISTEMA'];
									$SQL_NP="SELECT NOMBRE FROM US_PERFIL WHERE IDPERFIL=".$IDPERFIL_US;
									$RS_NP = sqlsrv_query($conn, $SQL_NP);
									//oci_execute($RS_NP);
									if ($ROW_NP = sqlsrv_fetch_array($RS_NP)) {
										$PERFUSU = $ROW_NP['NOMBRE'];
									}	
									$SQL_NS="SELECT NOMBRE FROM US_SISTEMA WHERE IDSISTEMA=".$IDSISTEMA_US;
									$RS_NS = sqlsrv_query($conn, $SQL_NS);
									//oci_execute($RS_NS);
									if ($ROW_NS = sqlsrv_fetch_array($RS_NS)) {
										$SISUSU = $ROW_NS['NOMBRE'];
									}
									$PERFILES=$PERFILES.$SISUSU.": ".$PERFUSU."<BR>";
								}
						} else {
							$PERFILES="NO ASOCIADO";
						}
						$SQL_NU="SELECT NOMBRE FROM US_USUARIOS WHERE IDUSU=".$IDREG;
						$RS_NU = sqlsrv_query($conn, $SQL_NU);
						//oci_execute($RS_NU);
						if ($ROW_NU = sqlsrv_fetch_array($RS_NU)) {
							$QUIENFUE = $ROW_NU['NOMBRE'];
						}	
						if ($ESTADO==0) {
							$ELESTADO="Bloqueado"; 
							$COLORTD="#F44336";
							}
						if ($ESTADO==1) {
							$ELESTADO="Activo"; 
							$COLORTD="#4CAF50";
							}
               ?>
                <tr>
				<?php if ($SESPUBLICA==1) {?>
                    <td><a href="mant_usuarios.php?ACT=<?php echo $IDUSU?>"><span class="txtBold"><?php echo $NOMBRE?></span></a><br><?php echo $EMAIL?></td>
                <?php } else {?>

                <td><?php echo $NOMBRE?><br><?php echo $EMAIL?></td>
                <?php }?>
                    <td><?php echo $PERFILES?></td>
                    <td><?php echo $TIPOUS?></td>
                    <td align="center" style="background-color:<?php echo $COLORTD ?>; color:#FFF; text-shadow:none"><?php echo $ELESTADO?></td>
                    <td><?php echo $QUIENFUE.", ".date_format($FECHA,"d-m-Y")?></td>
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
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('mant_usuarios.php?LSUP=<?php echo $FILA_ANT?>&LINF=<?php echo $ATRAS?>&BSC_SISTEMA=<?php echo $BSC_SISTEMA?>&BSC_TIPOUSU=<?php echo $BSC_TIPOUSU?>&BSC_USU=<?php echo $BSC_USU?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('mant_usuarios.php?LSUP=<?php echo $FILA_POS?>&LINF=<?php echo $ADELANTE?>&BSC_SISTEMA=<?php echo $BSC_SISTEMA?>&BSC_TIPOUSU=<?php echo $BSC_TIPOUSU?>&BSC_USU=<?php echo $BSC_USU?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina <?php echo $NUMPAG?> de <?php echo $NUMTPAG?></span>
                    </td>
                </tr>
                </table>
<?php } //LIST?>
<?php  if ($NEO==1) { ?>
                <table id="forma-registro">
                        <form action="mant_usuarios_reg.php" method="post" name="forming" id="forming" onSubmit="return validaUsuario(this)">
                        <tr>
                            <td><label for="NOMBRE">Nombre *</label></td>
                            <td><input name="NOMBRE" type="text" size="30" maxlength="200" > </td>
                        </tr>
                        <tr>
                            <td><label for="EMAIL">e-mail *</label></td>
                            <td><input name="EMAIL" type="text" size="30" maxlength="200" > </td>
                        </tr>
                        <tr>
                            <td> <label for="CUENTA">Cuenta *</label> </td>
                            <td><input name="CUENTA" type="text" size="30" maxlength="200" > </td>
                        </tr>
                        <tr>
                            <td> <label for="CLAVE">Clave *</label> </td>
                            <td><input name="CLAVE" type="password" size="30" maxlength="20" ></td>
                        </tr>
                    <tr>
                        <td><label for="CLAVE_VER">Confirmar Clave *</label></td>
                        <td><input name="CLAVE_VER"  type="password" size="30" maxlength="20"> </td>
                    </tr>
                        <tr>
                           <td></td>
                           <td><input name="INGRESAR" type="submit" value="Registrar">
                            <input name="LIMPIAR" type="reset" value="Limpiar">
                            <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_usuarios.php')"></td>
                        </tr>
                        </form>
                </table>
                <script>
                document.forming.NOMBRE.focus();
                </script>
<?php } //NEO?>
<?php  if ($ACT<>"") { ?> 
	<?php  if ($ENC==1) { ?> 
                <h3>Actualizar: <?php echo $NOMBRE?></h3>
                <?php if($CC_OPERADOR!=0){ ?>
                	<p style="margin-bottom:20px">Usuario registrado como Operador de Tienda<br>(Operador Central) data sensible no editable</p>
                <?php } ?>
                
                <table id="forma-registro">
                    <form action="mant_usuarios_reg.php" method="post" name="formact" onSubmit="return validaUsuario(this)">
                    <tr>
                        <td> <label for="NOMBRE">Nombre *</label> </td>
                        <td>
                        <?php
						//VERIFICA SI FUE REGISTRADO DESDE OPERADOR CENTRAL
						if($CC_OPERADOR==0){ //REGISTRADO POR SUITE: EDITABLE
						?>
                        		<input name="NOMBRE" type="text" size="30" maxlength="200" value="<?php echo $NOMBRE?>">
                       <?php } else {?>
                       			<label for="NOMBRE"><?= $NOMBRE?></label>
                                <input name="NOMBRE" type="hidden" value="<?=$NOMBRE?>">
                       <?php } ?>
                      </td>
                    </tr>
                        <tr>
                            <td><label for="EMAIL">e-mail *</label></td>
                            <td><input name="EMAIL" type="text" size="30" maxlength="200"  value="<?php echo $EMAIL?>" > </td>
                        </tr>
                    <tr>
                        <td><label for="CUENTA">Cuenta *</label></td>
                         <td>
						 <?php
						//VERIFICA SI FUE REGISTRADO DESDE OPERADOR CENTRAL
						if($CC_OPERADOR==0){ //REGISTRADO POR SUITE: EDITABLE
						?>
                       <input name="CUENTA" type="text" size="30" maxlength="200" value="<?php echo $CUENTA?>">
                       <?php } else {?>
                       			<label for="CUENTA"><?= $CUENTA?></label>
                                <input name="CUENTA" type="hidden" value="<?=$CUENTA?>">
                       <?php } ?>
                       </td>
                    </tr>
                    <tr>
                        <td><label for="CLAVE">Clave *</label></td>
                        <td><input name="CLAVE" type="password" size="30" maxlength="20" value="<?php echo $CLAVE?>"> </td>
                    </tr>
                    <tr>
                        <td><label for="CLAVE_VER">Confirmar Clave *</label></td>
                        <td><input name="CLAVE_VER"  type="password" size="30" maxlength="20" value="<?php echo $CLAVE?>"> </td>
                    </tr>
                    <tr>
                        <td><label for="ESTADO">Estado</label> </td>
                        <td>
                        <select name="ESTADO">
                        <option value="0" <?php if ($ESTADO==0) { echo "SELECTED";}?>>Bloqueado</option>
                        <option value="1" <?php if ($ESTADO==1) { echo "SELECTED";}?>>Activo</option>
                        </select></td>
                    </tr>
                    <tr>
                        <td><input name="IDUSU" type="hidden" value="<?php echo $IDUSU?>">
                        </td>
                        <td>
                        <input name="ACTUALIZAR" type="submit" value="Actualizar">
                        <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_usuarios.php')">
                        </td>
                    </tr>
                    </form>
                </table>
	<?php } //ENC?>
	<?php  if ($PERF==1) { ?> 
                <h3>Perfiles ARMS: <?php echo $NOMBRE?></h3>
                <table id="forma-registro">
                    <form action="mant_usuarios_reg.php" method="post" name="forming" onSubmit="return validaPerfilUsuario(this)">
                    <tr>
                        <td> <label for="IDSISTEMA">Sistema *</label> </td>
                        <td>
                                <select name="IDSISTEMA"  onChange="CargaPerfil(this.value, this.form.name, 'IDPERFIL')">
                                            <option value="0">SELECCIONAR</option>
											<?php 
                                            $SQL="SELECT * FROM US_SISTEMA WHERE IDSISTEMA NOT IN(SELECT IDSISTEMA FROM US_USUPERF WHERE IDUSU=".$ACT.") ORDER BY NOMBRE ASC";
                                            $RS = sqlsrv_query($conn, $SQL);
                                            //oci_execute($RS);
                                            while ($row = sqlsrv_fetch_array($RS)) {
                                                $IDSISTEMA = $row['IDSISTEMA'];
                                                $NOMB_SIS = $row['NOMBRE'];
                                             ?>
                                            <option value="<?php echo $IDSISTEMA ?>"><?php echo $NOMB_SIS ?></option>
                                            <?php 
                                            }
                                             ?>
                            </select>
                        </td>
                    </tr>
                        <tr>
                            <td><label for="IDPERFIL">Perfil *</label></td>
                            <td>
                                <select id="IDPERFIL" name="IDPERFIL">
                                    <option value="0">SELECCIONAR</option>
                                </select>
                            </td>
                        </tr>
                    <tr>
                        <td><input name="IDUSU" type="hidden" value="<?php echo $IDUSU?>">
                        </td>
                        <td>
                        <input name="REGPERFIL" type="submit" value="Registrar">
                        <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_usuarios.php')">
                        </td>
                    </tr>
                    </form>
                </table>


                <h3>Perfiles ARMS Asociados</h3>
                <?php
				$CONSULTA="SELECT COUNT(IDPERFIL) AS CPERFIL FROM US_USUPERF WHERE IDUSU=".$ACT;
				$RS = sqlsrv_query($conn, $CONSULTA);
				//oci_execute($RS);
				$CUENTA_P=0;
				if ($row = sqlsrv_fetch_array($RS)){
					$CUENTA_P= $row['CPERFIL'];
				}
				//$CONSULTA="SELECT * FROM US_USUPERF WHERE IDUSU=".$ACT;
				$CONSULTA="SELECT * FROM US_SISTEMA WHERE IDSISTEMA IN(SELECT IDSISTEMA FROM US_USUPERF WHERE IDUSU=".$ACT.") ORDER BY NOMBRE ASC";
				$RS = sqlsrv_query($conn, $CONSULTA);
				//oci_execute($RS);
               ?>
                <table id="Listado">
                <tr>
                    <th>Sistema</th>
                    <th colspan="2">Perfil</th>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){
                        $SELIDSISTEMA = $row['IDSISTEMA'];
						$SISTEMA = $row['NOMBRE'];

                        //$SELIDPERFIL = $row['IDPERFIL'];
						
						$CONSULTA2="SELECT IDPERFIL FROM US_USUPERF WHERE IDSISTEMA=".$SELIDSISTEMA." AND IDUSU=".$ACT;
						$RS2 = sqlsrv_query($conn, $CONSULTA2);
						//oci_execute($RS2);
						if ($row2 = sqlsrv_fetch_array($RS2)) {
							$SELIDPERFIL = $row2['IDPERFIL'];
						}	
               ?>
                <tr>
                <form action="mant_usuarios_reg.php" method="post" name="form<?php echo $SELIDSISTEMA.$SELIDPERFIL.$ACT?>">
                    <td><?php echo $SISTEMA?></td>
                    <td class="FormCelda">
                                <select name="NEOIDPERFIL">
											<?php 
                                            $SQL3="SELECT * FROM US_PERFIL WHERE IDSISTEMA=".$SELIDSISTEMA." ORDER BY NOMBRE ASC";
                                            $RS3 = sqlsrv_query($conn, $SQL3);
                                            //oci_execute($RS3);
                                            while ($row3 = sqlsrv_fetch_array($RS3)) {
                                                $NEOIDPERFIL = $row3['IDPERFIL'];
                                                $NOMB_PERF = $row3['NOMBRE'];
                                             ?>
                                            <option value="<?php echo $NEOIDPERFIL?>" <?php if ($NEOIDPERFIL==$SELIDPERFIL) { echo "SELECTED";}?>><?php echo $NOMB_PERF ?></option>
                                            <?php 
                                            }
                                             ?>
                                </select>
                    </td>
                    <td class="FormCelda">
                        <input class="BotonCelda" type="submit" name="CAMBIAPERFIL" value="Cambiar">
                        <?php if($CUENTA_P>1) { ?><input class="BotonCelda" type="button" value="Retirar" onClick="javascript:pagina('mant_usuarios_reg.php?ELM=1&IDPERFIL=<?php echo $SELIDPERFIL ?>&IDSISTEMA=<?php echo $SELIDSISTEMA ?>&IDUSU=<?php echo $ACT ?>')"><?php } ?>
                        <input name="IDUSU" type="hidden" value="<?php echo $ACT?>">
                        <input name="IDSISTEMA" type="hidden" value="<?php echo $SELIDSISTEMA?>">
                   </td>
                </form>
                </tr>
                <?php
				}
				?>
                <tr><td colspan="3"></td></tr>
                </table>



	<?php } //PERF?>
	<?php  if ($TND==1) { ?> 
                <h3>Tienda(s) Asociada(s): <?php echo $NOMBRE?></h3>
                <?php if($CC_OPERADOR!=0){ ?>
                	<p style="margin-bottom:20px">Usuario registrado como Operador de Tienda<br>Tienda asociada s&oacute;lo desde Sistema Operador Central</p>
                <?php } else { ?>
                <table id="forma-registro">
                    <form action="mant_usuarios_reg.php?TND=1" method="post" name="forming" onSubmit="return validaTiendaUsuario(this)">
                    <tr>
                        <td> <label for="COD_NEGOCIO">L&iacute;nea de Negocio</label> </td>
                        <td>
                                <select name="COD_NEGOCIO"  onChange="CargaTiendaUsu(this.value, this.form.name, 'COD_TIENDA')">
                                            <option value="0">SELECCIONAR</option>
											<?php 
                                            $SQL="SELECT * FROM MN_NEGOCIO ORDER BY DES_NEGOCIO ASC";
                                            $RS = sqlsrv_query($conn, $SQL);
                                            //oci_execute($RS);
                                            while ($row = sqlsrv_fetch_array($RS)) {
                                                $COD_NEGOCIO = $row['COD_NEGOCIO'];
                                                $DES_NEGOCIO = $row['DES_NEGOCIO'];
                                             ?>
                                            <option value="<?php echo $COD_NEGOCIO;?>"><?php echo $DES_NEGOCIO ?></option>
                                            <?php 
                                            }
                                             ?>
                                </select>
                        </td>
                    </tr>
                        <tr>
                            <td><label for="COD_TIENDA">Tienda Asociada</label></td>
                            <td>
                                <select id="COD_TIENDA" name="COD_TIENDA">
                                    <option value="0">SELECCIONAR</option>
                                </select>
                            </td>
                        </tr>
                    <tr>
                        <td><input name="IDUSU" type="hidden" value="<?php echo $IDUSU?>">
                        </td>
                        <td>
                        <input name="REG_TIENDA" type="submit" value="Asociar Tienda">
                        <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_usuarios.php')">
                        </td>
                    </tr>
                    </form>
                </table>
                <?php } ?>

                <h3>Tienda(s) Asociada(s)</h3>
                <?php
				$CTA_TND = 0;
				$CONSULTA="SELECT COUNT(COD_TIENDA) AS CTA_TND FROM US_USUTND WHERE IDUSU=".$ACT;
				$RS = sqlsrv_query($conn, $CONSULTA);
				//oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)){
					$CTA_TND = $row['CTA_TND'];
				}
				
				if($CTA_TND>=1){
				
						$CONSULTA="SELECT * FROM US_USUTND WHERE IDUSU=".$ACT." ORDER BY COD_NEGOCIO ASC, COD_TIENDA ASC";
						$RS = sqlsrv_query($conn, $CONSULTA);
						//oci_execute($RS);
					   ?>
                    <table id="Listado">
						<tr>
							<th>L&iacute;nea de Negocio</th>
							<th colspan="3">Tienda Asociada</th>
						</tr>
						<?php
						while ($row = sqlsrv_fetch_array($RS)){
								$SELCOD_TIENDA = $row['COD_TIENDA'];
								$SELCOD_NEGOCIO = $row['COD_NEGOCIO'];
								$CONSULTA2="SELECT * FROM MN_TIENDA WHERE COD_TIENDA=".$SELCOD_TIENDA;
								$RS2 = sqlsrv_query($conn, $CONSULTA2);
								//oci_execute($RS2);
								if ($row2 = sqlsrv_fetch_array($RS2)) {
									$NUM_TIENDA = $row2['DES_CLAVE'];
									$NUM_TIENDA="0000".$NUM_TIENDA;
									$NUM_TIENDA=substr($NUM_TIENDA, -4); 
									$TIENDA = $row2['DES_TIENDA'];
								}	
								$CONSULTA2="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO=".$SELCOD_NEGOCIO;
								$RS2 = sqlsrv_query($conn, $CONSULTA2);
								//oci_execute($RS2);
								if ($row2 = sqlsrv_fetch_array($RS2)) {
									$DES_NEGOCIO = $row2['DES_NEGOCIO'];
								}	
					   ?>
						<tr>
						<form action="mant_usuarios_reg.php" method="post" name="form<?php echo $SELCOD_TIENDA.$ACT?>">
							<td><?php echo $DES_NEGOCIO?></td>
							<td><?php echo $NUM_TIENDA." - ".$TIENDA?></td>
                            <?php if($CC_OPERADOR==0){ ?>
                            <td class="FormCelda"> <input name="IDUSU" type="hidden" value="<?php echo $ACT?>">
                            <input class="BotonCelda" type="button" value="Retirar" onClick="javascript:pagina('mant_usuarios_reg.php?RETTND=1&COD_TIENDA=<?php echo $SELCOD_TIENDA ?>&COD_NEGOCIO=<?php echo $SELCOD_NEGOCIO ?>&IDUSU=<?php echo $ACT ?>')">
                            </td>
                            <?php } ?>
						</form>
						</tr>
						<?php
						}
						?>
                        <tr><td colspan="3"></td></tr>
						</table>
				<?php 
				} else {//if($CTA_TND>=1
				?>
					<h4>Usuario Central, acceso a todas las Tiendas</h4>
				<?php
                }
				} //TND?>
<?php } //ACT?>
                </td>
                </tr>
                </table>
        </td>
        </tr>
        </table>
</td>
</tr>
</table>
        <iframe name="frmHIDEN" width="0%" height="0" frameborder="0" align="top" src="" framespacing="0" marginheight="0" marginwidth="0">
        </iframe>
</body>
</html>
<?php sqlsrv_close($conn); ?>
