
<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1143;


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
	
		if (theForm.DES_DATACRM.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.DES_DATACRM.focus();
			return false;
	}

		if (theForm.TIPO_DATACRM.value == 0){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.TIPO_DATACRM.focus();
			return false;
	}

		if (theForm.AMBITO.value == 99){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.AMBITO.focus();
			return false;
	}

} //validaingreso(theForm)

function validaopcion(theForm){
	
		if (theForm.DES_DATACRMOPC.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.DES_DATACRMOPC.focus();
			return false;
	}

} //validaopcion(theForm)

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
				
				$CONSULTA="SELECT COUNT(*) AS CUENTA FROM MN_DATACRM";
				
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

				//$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM MN_DATACRM ORDER BY DES_DATACRM ASC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;

                $CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY DES_DATACRM ASC) ROWNUMBER FROM MN_DATACRM) AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";

				//$RS = sqlsrv_query($conn, $CONSULTA);
				////oci_execute($RS);

                $RS = sqlsrv_query($conn,$CONSULTA);

               ?>
                <table id="Listado">
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>&Aacute;mbito</th>
                    <th>Estado</th>
                    <th>Registrado por</th>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){
                        $COD_DATACRM = $row['COD_DATACRM'];
                        $DES_DATACRM = $row['DES_DATACRM'];
                        $AMBITO = $row['AMBITO'];
						if($AMBITO==0){$ELAMBITO="PERS.NATURAL";}
						if($AMBITO==1){$ELAMBITO="PERS.JURIDICA";}
						if($AMBITO==2){$ELAMBITO="AMBOS";}
                        $TIPO_DATACRM = $row['TIPO_DATACRM'];
						if($TIPO_DATACRM==1){$ELTIPODATA="TEXTO";}
						if($TIPO_DATACRM==2){$ELTIPODATA="NUMERICO";}
						if($TIPO_DATACRM==3){$ELTIPODATA="OPCIONES:";}
						
						if($TIPO_DATACRM==3) {
								$LASOPCIONES="";
								$S2="SELECT DES_DATACRMOPC FROM MN_DATACRMOPC WHERE COD_DATACRM=".$COD_DATACRM;
								
                                //$RS2 = sqlsrv_query($conn, $S2);
								////oci_execute($RS2);

								$RS2 = sqlsrv_query($conn,$S2);
                                while ($row2 = sqlsrv_fetch_array($RS2)) {
									$LASOPCIONES = $LASOPCIONES.$row2['DES_DATACRMOPC']."<BR>";
								}	
						} else {
								$LASOPCIONES="";
						}
						
                        $IND_ACTIVO = $row['IND_ACTIVO'];
						if ($IND_ACTIVO==1) {
							$ELIND_ACTIVO="Activo"; 
							$COLORTD="#4CAF50";
							}
						if ($IND_ACTIVO==0) {
							$ELIND_ACTIVO="Bloqueado"; 
							$COLORTD="#F44336";
							}
                        $IDREG = $row['IDREG'];
                        $FECHA = $row['FECHA'];
						$S3="SELECT NOMBRE FROM US_USUARIOS WHERE IDUSU=".$IDREG;
						
                        //$RS3 = sqlsrv_query($maestra, $S3);
						////oci_execute($RS3);
                        $RS3 = sqlsrv_query($maestra,$S3);
						
                        if ($row3 = sqlsrv_fetch_array($RS3)) {
							$QUIENFUE = $row3['NOMBRE'];
						}	
               ?>
                <tr>
                    <?php if($SESPUBLICA==1) { ?>
                    <td><a href="mant_datacliente.php?ACT=<?php echo $COD_DATACRM?>"><?php echo $DES_DATACRM?></a></td>
                    <?php } else {?>
                     <td><?php echo $DES_DATACRM?></td>
                    <?php } ?>
                     <td><?php echo $ELTIPODATA."<BR>".$LASOPCIONES?></td>
                     <td><?php echo $ELAMBITO?></td>
                    <td align="center" style="background-color:<?php echo $COLORTD ?>; color:#FFF; text-shadow:none"><?php echo $ELIND_ACTIVO?></td>
                    <td><?php echo $QUIENFUE.", ".date_format($FECHA,"d-m-Y"); ?>
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
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('mant_datacliente.php?LSUP=<?php echo $FILA_ANT?>&LINF=<?php echo $ATRAS?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('mant_datacliente.php?LSUP=<?php echo $FILA_POS?>&LINF=<?php echo $ADELANTE?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina <?php echo $NUMPAG?> de <?php echo $NUMTPAG?></span>
                    </td>
                </tr>
                </table>
<?php
		//sqlsrv_close($conn);
		//sqlsrv_close($maestra);
        sqlsrv_close( $conn );
        sqlsrv_close( $maestra );
}
?>
               
               
<?php  if ($NEO==1) { ?>
                <table id="forma-registro">
                        <form action="mant_datacliente_reg.php" method="post" name="forming" id="forming" onSubmit="return validaingreso(this)">
                        <tr>
                            <td><label for="DES_DATACRM">Nombre </label></td>
                            <td><input name="DES_DATACRM" type="text" size="20" maxlength="200" > </td>
                        </tr>
                        <tr>
                            <td><label for="TIPO_DATACRM">Tipo </label> </td>
                            <td><select name="TIPO_DATACRM">
                                <option value="0">Seleccionar</option>
                                <option value="1">Texto</option>
                                <option value="2">Num&eacute;rico</option>
                                <option value="3">Opci&oacute;n</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td><label for="AMBITO">&Aacute;mbito </label> </td>
                            <td><select name="AMBITO">
                                <option value="99">Seleccionar</option>
                                <option value="0">Persona Natural</option>
                                <option value="1">Persona Jur&iacute;dica</option>
                                <option value="2">Ambos</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td><label for="IND_ACTIVO">Estado</label> </td>
                            <td><select name="IND_ACTIVO">
                                <option value="0">Bloqueado</option>
                                <option value="1">Activo</option>
                                </select></td>
                        </tr>
                        <tr>
                           <td></td>
                           <td><input name="INGRESAR" type="submit" value="Registrar">
                            <input name="LIMPIAR" type="reset" value="Limpiar">
                            <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_datacliente.php')"></td>
                        </tr>
                        </form>
                </table>
                <script>
                document.forming.DES_DATACRM.focus();
                </script>
<?php
		//sqlsrv_close($conn);
		//sqlsrv_close($maestra);
        sqlsrv_close( $conn );
        sqlsrv_close( $maestra );

}
?>
               
               
<?php  if ($ACT<>"") { 
				$S="SELECT * FROM MN_DATACRM WHERE COD_DATACRM=".$ACT;
				
                //$RS = sqlsrv_query($conn, $S);
				////oci_execute($RS);
				$RS = sqlsrv_query($conn,$S);

                if ($row = sqlsrv_fetch_array($RS)) {
					$COD_DATACRM = $row['COD_DATACRM'];
					$DES_DATACRM = $row['DES_DATACRM'];
					$TIPO_DATACRM = $row['TIPO_DATACRM'];
					$AMBITO = $row['AMBITO'];
					$IND_ACTIVO = $row['IND_ACTIVO'];
                }
               ?>
                <h3>Actualizar: <?php echo $DES_DATACRM?></h3>
                <table id="forma-registro">
                    <form action="mant_datacliente_reg.php" method="post" name="formact" onSubmit="return validaingreso(this)">
                    <tr>
                        <td> <label for="DES_DATACRM">Nombre </label> </td>
                        <td><input name="DES_DATACRM" type="text" size="20" maxlength="200" value="<?php echo $DES_DATACRM;?>"></td>
                    </tr>
                    <tr>
                        <td><label for="TIPO_DATACRM">Tipo </label></td>
                        <td >
                            <?php
                            //VERIFICAR SI DATA HA SIDO REGISTRADA, BLOQUEAR ACTUALIZACION DE TIPO
							$S2="SELECT COUNT(COD_DATACRM) AS CTADATA FROM OP_CLIENTEANT WHERE COD_DATACRM=".$COD_DATACRM;
							
                            //$RS2 = sqlsrv_query($conn, $S2);
							////oci_execute($RS2);
                            $RS2 = sqlsrv_query($conn,$S2);
							
                            if ($row2 = sqlsrv_fetch_array($RS2)) {
								$CTADATA = $row2['CTADATA'];
							}
                            
                            if (!empty($CTADATA)) {
                                    $REGDATA=$CTADATA;
                                    if($REGDATA<>0) {
                                        if($TIPO_DATACRM==1) {$ETIQUETA="Texto";}
                                        if($TIPO_DATACRM==2) {$ETIQUETA="Num&eacute;rico";}
                                        if($TIPO_DATACRM==3) {$ETIQUETA="Opci&oacute;n";}
									}
							} else {
                                    $REGDATA=0;
							}
                            ?>
                                    <?php if($REGDATA==0){ ?>
                                        <select name="TIPO_DATACRM">
                                            <option value="0">Seleccionar</option>
                                            <option value="1" <?php if($TIPO_DATACRM==1) { echo ("SELECTED");}?>>Texto</option>
                                            <option value="2" <?php if($TIPO_DATACRM==2) { echo ("SELECTED");}?>>Num&eacute;rico</option>
                                            <option value="3" <?php if($TIPO_DATACRM==3) { echo ("SELECTED");}?>>Opci&oacute;n</option>
                                        </select>
                                    <?php } else { ?>
                                        <label for="REGDATA1"><?php echo $ETIQUETA;?></label>
                                        <label for="REGDATA2" >Variable utilizada en Registro de Clientes,<br>actualizaci&oacute;n de tipo deshabilitada</label>
                                        <input type="hidden" name="TIPO_DATACRM" value="<?php echo $TIPO_DATACRM;?>">
                                    <?php }?>
                        </td>
                    </tr>
                        <tr>
                            <td><label for="AMBITO">&Aacute;mbito </label> </td>
                            <td><select name="AMBITO">
                                <option value="99">Seleccionar</option>
                                <option value="0" <?php if($AMBITO==0) { echo ("SELECTED");}?>>Persona Natural</option>
                                <option value="1" <?php if($AMBITO==1) { echo ("SELECTED");}?>>Persona Jur&iacute;dica</option>
                                <option value="2" <?php if($AMBITO==2) { echo ("SELECTED");}?>>Ambos</option>
                                </select></td>
                        </tr>
                    <tr>
                        <td><label for="IND_ACTIVO">Estado</label> </td>
                        <td><select name="IND_ACTIVO">
                            <option value="0" <?php if($IND_ACTIVO==0) { echo ("SELECTED");}?>>Bloqueado</option>
                            <option value="1" <?php if($IND_ACTIVO==1) { echo ("SELECTED");}?>>Activo</option>
                            </select></td>
                    </tr>
                    <tr>
                        <td><input name="COD_DATACRM" type="hidden" value="<?php echo $COD_DATACRM?>">
                        <td>
                        <input name="ACTUALIZAR" type="submit" value="Actualizar">
                        <?php
						$S3="SELECT * FROM OP_CLIENTEANT WHERE COD_DATACRM=".$ACT;
						
                        //$RS3 = sqlsrv_query($conn, $S3);
						////oci_execute($RS3);
                        $RS3 = sqlsrv_query($conn,$S3);
						
                        if ($row3 = sqlsrv_fetch_array($RS3)) {
							$ELIMINAR=0;
						} else {
							$ELIMINAR=1;
						}
						if ($ELIMINAR==1) {
						?>
                        <input name="ELIMINAR" type="button" value="Eliminar" onClick="javascript:pagina('mant_datacliente_reg.php?ELM=1&COD_DATACRM=<?php echo $COD_DATACRM ?>')">
                        <?php } ?>
                        <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_datacliente.php')">
                        </td>
                    </tr>
                    </form>
                <?php if($TIPO_DATACRM==3) { ?>
                    <tr>
                        <td colspan="2" style="padding:0"><h3>Opciones Variable</h3></td>
                   </tr>
                                
                               <?php 
                               $COD_DATACRMOPC=@$_GET["COD_DATACRMOPC"];
                               if($COD_DATACRMOPC=="") {
                                    $COD_DATACRMOPC=0;
                                    $LAOPCION="";
                               } else {
                                    $S3="SELECT DES_DATACRMOPC FROM MN_DATACRMOPC WHERE COD_DATACRMOPC=".$COD_DATACRMOPC;
                                    
                                    //$RS3 = sqlsrv_query($conn, $S3);
                                    ////oci_execute($RS3);
                                    $RS3 = sqlsrv_query($conn,$S3);
                                    
                                    if ($row3 = sqlsrv_fetch_array($RS3)) {
                                            $LAOPCION=$row3['DES_DATACRMOPC'];
                                    }
                               }
                                ?>
                                <form action="mant_datacliente_reg.php" method="post" name="formopc" id="formopc" onSubmit="return validaopcion(this)">
                               <tr>
                                    <td>
                                        <?php if($COD_DATACRMOPC==0){ ?>	
                                                <label for="COD_DATACRMOPC">Asociar Opci&oacute;n</label>
                                        <?php } else { ?>	
                                                <label for="COD_DATACRMOPC">Actualizar Opci&oacute;n</label>
                                        <?php } ?>	
                                    </td>
                                    <td>
                                        <input name="DES_DATACRMOPC" type="text" size="30" maxlength="200" value="<?php echo $LAOPCION; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input name="COD_DATACRMOPC" type="hidden" value="<?php echo $COD_DATACRMOPC; ?>">
                                        <input name="COD_DATACRM" type="hidden" value="<?php echo $ACT; ?>">
                                    </td>
                                    <td>
                                        <?php if($COD_DATACRMOPC==0){ ?>	
                                                <input name="REGOPCION" type="submit" value="Registrar Opci&oacute;n" style="margin-top:2px">
                                        <?php } else { ?>	
                                                <input name="ACTOPCION" type="submit" value="Actualizar Opci&oacute;n" style="margin-top:2px">
                                        <?php } ?>
                                    </td>
                                </tr>
                               </form>
                               
                               
                               
							<?php 
                            //OPCIONES REGISTRADAS
                            $S6="SELECT * FROM MN_DATACRMOPC WHERE COD_DATACRM=".$ACT;
                            
                            //$RS6 = sqlsrv_query($conn, $S6);
                            ////oci_execute($RS6);
                            $RS6 = sqlsrv_query($conn,$S6); 
                            
                            $NUMOPCIONVER=0;
                            while ($row6 = sqlsrv_fetch_array($RS6)) {
                               	$NUMOPCIONVER=$NUMOPCIONVER+1;
							}
							if($NUMOPCIONVER<>0){
							?>
                                <tr>
                                <td colspan="2" style="padding:0">
                                        <table id="Listado">
                                        <tr>
                                                <th colspan="3">Opci&oacute;n</th>
                                                <th>Registrado por</th>
                                        </tr>
                                        <?php 
                                        //OPCIONES REGISTRADAS
                                        $S4="SELECT * FROM MN_DATACRMOPC WHERE COD_DATACRM=".$ACT." ORDER BY COD_DATACRMOPC ASC";
                                        
                                        //$RS4 = sqlsrv_query($conn, $S4);
                                        ////oci_execute($RS4);
                                        $RS4 = sqlsrv_query($conn,$S4);
                                        
                                        $NUMOPCION=0;
                                        while ($row4 = sqlsrv_fetch_array($RS4)) {
                                                $NUMOPCION=$NUMOPCION+1;
                                                $COD_DATACRMOPC=$row4['COD_DATACRMOPC'];
                                                $LAOPCION=$row4['DES_DATACRMOPC'];
                                                $IDREG_OPC=$row4['IDREG'];
                                                $S5="SELECT NOMBRE FROM US_USUARIOS WHERE IDUSU=".$IDREG_OPC;
                                                
                                                //$RS5 = sqlsrv_query($maestra, $S5);
                                                ////oci_execute($RS5);
                                                $RS5 = sqlsrv_query($maestra,$S5);

                                                if ($row5 = sqlsrv_fetch_array($RS5)) {
                                                    $USUARIO = $row5['NOMBRE'];
                                                }	
                                                $FECHA_OPC=$row4['FECHA'];
                                         ?>
                                        <tr>
                                                <td><strong><?php echo $NUMOPCION ;?>.</strong></td>
                                                <td style="max-width:240px"><?php echo $LAOPCION ;?></td>
                                                <td>
                                                        <input name="ACTOPCION" type="button" value="Actualizar" style="margin-top:2px; padding-top:4px; padding-bottom:4px" onClick="pagina('mant_datacliente.php?ACT=<?php echo $ACT ?>&COD_DATACRMOPC=<?php echo $COD_DATACRMOPC?>');">
                                                        <?php 
                                                            $S5="SELECT DATA_CLIENTE FROM OP_CLIENTEANT WHERE TRIM(DATA_CLIENTE)=".$COD_DATACRMOPC;
                                                            
                                                            //$RS5 = sqlsrv_query($conn, $S5);
                                                            ////oci_execute($RS5);
                                                            $RS5 = sqlsrv_query($conn,$S5); 

                                                            
                                                            if ($row5 = @sqlsrv_fetch_array($RS5)) {
                                                                $ELIMINAR=0;
                                                            } else {
                                                                $ELIMINAR=1;
                                                            }
                                                            if ($ELIMINAR==1) {
                                                         ?>	
                                                        <input name="ELMOPCION" type="button" value="Quitar" style="margin-top:2px; padding-top:4px; padding-bottom:4px" onClick="pagina('mant_datacliente_reg.php?ELMOPCION=1&ACT=<?php echo $ACT; ?>&COD_DATACRMOPC=<?php echo $COD_DATACRMOPC; ?>&COD_DATACRM=<?php echo $ACT; ?>');">
                                                        <?php } ?>
                                               </td>
                                                <td><?php echo $USUARIO.", ".date_format($FECHA_OPC,"Y-m-d"); ?></td>
                                        </tr>
                                        <?php } ?>
                                        <tr><td colspan="4"></td></tr>
                                        </table>
                                </td>
                               </tr>
					<?php } ?>
				<?php } ?>
                       </table>
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

