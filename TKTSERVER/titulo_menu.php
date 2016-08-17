	<?php
	$CONSULTA="SELECT NOMBRE FROM US_ACCESO WHERE IDACC=".$PAGINA;
	$RS = sqlsrv_query($maestra, $CONSULTA);
	//oci_execute($RS);
	if ($row = sqlsrv_fetch_array($RS)) {
		$LAPAGINA = $row['NOMBRE'];
	}	
	$URLPAG=basename( $_SERVER['PHP_SELF'] );
	$PAGASP=$URLPAG;
	if ($SESPUBLICA==0 and ($NEO<>"" or $ACT<>"")) {
		header("Location: ".$PAGASP);
	}
	if(empty($NOMENU)) { $NOMENU=0; }
	if(empty($NONEO)) { $NONEO=0; }
	?>
<table width="100%"><tr><td bgcolor="#FFFFFF" style="border-bottom:thin; border-bottom-color:#E5E5E5; border-bottom-style:solid;">
<table><tr><td>
<div id="MenuModulo">
<?php if ($NOMENU==0) {?>
    <h1><?php echo $GLBELCLIENTE ?></h1>
            <ul>
                    <li <?php if ($LIST==1) { ?>class="activo"<?php } ?>><a href="<?php echo $PAGASP?>">Listado</a></li>
					<?php if ($SESPUBLICA==1) {  //PERFIL PUBLICACION?> <?php if($NONEO==0) {  //NUEVO?>
                    <li <?php if ($NEO==1) { ?>class="activo"<?php } ?>><a href="<?php echo $PAGASP?>?NEO=1">Nuevo</a></li>
					<?php } ?><?php } ?>
            </ul>
<?php } else {  //$NOMENU==1?>
    <h1 style="margin-bottom:9px"><?php echo $GLBELCLIENTE.": ".$LAPAGINA?></h1>
<?php } //$NOMENU==0?>

<?php if($PAGINA==1115){
		function listaDirectorios( $path){
			$dir = opendir($path);
			$res="";
			while ($elemento = readdir($dir)){
				if( $elemento != "." && $elemento != ".."){
					if( is_dir($path.$elemento) ){
						$res=$res.$elemento."|"; 
					} else {
						echo "<br />". $elemento;
					}
				}
			}
		return $res;
		}
		$LOCAL_SEL=@$_POST[ 'LOCAL' ];
		if($LOCAL_SEL==""){$LOCAL_SEL=0;}

		$POS_SEL=@$_POST[ 'POS' ];
		if($POS_SEL==""){$POS_SEL=0;}

		$ANIO_SEL=@$_POST[ 'ANIO' ];
		if($ANIO_SEL==""){$ANIO_SEL=0;}

		$MES_SEL=@$_POST[ 'MES' ];
		if($MES_SEL==""){$MES_SEL=0;}
	?>
                <div id="FiltroTicket">
                            <form action="<?php echo $PAGASP?>" method="post" name="frmSearch">
                                                              <label for="LOCAL" >Local: </label>
                                                                <select name="LOCAL" onChange="document.forms.frmSearch.submit();">
                                                                        <option value="0">Seleccionar</option> 
																			<?php
                                                                            //PRIMERO: CONOCER CUANTOS LOCALES HAY REGISTRADOS PARA SELECCIONAR
																			$locales=listaDirectorios($DIR_TCK."/");
																			$locales = substr($locales, 0, -1);
																			$LOCALES=explode("|", $locales);
																			foreach ($LOCALES as $DIR_LOCAL) {
																				if(is_numeric($DIR_LOCAL)) {
																			 ?>
                                                                                <option value="<?php echo $DIR_LOCAL?>" <?php if($DIR_LOCAL==$LOCAL_SEL){echo "SELECTED";}?>><?=substr("0000".$DIR_LOCAL,-4)?></option> 
																			<?php
																				}
                                                                            }
																			?>
                                                                  </select>
                                                                   
                                                                    <?php
                                                                     if($LOCAL_SEL<>0){       
																			//SEGUNDO: EL AÑO
																			//OBTENER LOS POS Y AGRUPAR LOS AÑOS
																					$pos=listaDirectorios($DIR_TCK."/".$LOCAL_SEL."/");
																					$pos = substr($pos, 0, -1);
																					$POS=explode("|", $pos);
																					$RESANIO=array();
																					foreach ($POS as $DIR_POS) {
																							$elanio=listaDirectorios($DIR_TCK."/".$LOCAL_SEL."/".$DIR_POS."/");
																							$elanio = substr($elanio, 0, -1);
																							$ELANIO=explode("|", $elanio);
																							foreach ($ELANIO as $DIR_ANIO) {
																								if(!empty($DIR_ANIO)) { array_push($RESANIO, $DIR_ANIO); }
																							}
																					}
																					$RESANIO = array_unique($RESANIO); //ELIMINO DUPLICADOS
																					arsort($RESANIO); //ORDENO DE MAYOR A MENOR
                                                                            ?>
                                                                            <label for="ANIO">A&ntilde;o: </label>
                                                                            <select name="ANIO" onChange="document.forms.frmSearch.submit();">
                                                                                    <option value="0">Seleccionar</option> 
																					<?php
																						foreach ($RESANIO as $DIR_ANIO) {
                                                                                     ?>
                                                                                        <option value="<?php echo $DIR_ANIO?>" <?php if($DIR_ANIO==$ANIO_SEL){echo "SELECTED";}?>><?php  echo $DIR_ANIO?></option> 
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                            </select>
                                                                            <?php
																			if($ANIO_SEL<>0){       
																						//TERCERO: EL MES
																						//OBTENER LOS POS, AGRUPAR LOS AÑOS Y OBTENER LOS MESES
																								$pos=listaDirectorios($DIR_TCK."/".$LOCAL_SEL."/");
																								$pos = substr($pos, 0, -1);

																								$POS=explode("|", $pos);
																								$RESMES=array();
																								foreach ($POS as $DIR_POS) {
																											$elmes=listaDirectorios($DIR_TCK."/".$LOCAL_SEL."/".$DIR_POS."/".$ANIO_SEL."/");
																											$elmes = substr($elmes, 0, -1);
																											$ELMES=explode("|", $elmes);
																											foreach ($ELMES as $DIR_MES) {
																												if(!empty($DIR_MES)) { array_push($RESMES, $DIR_MES); }
																											}
																								}
																								$RESMES = array_unique($RESMES); //ELIMINO DUPLICADOS
																								arsort($RESMES); //ORDENO DE MAYOR A MENOR
																						?>
																						<label for="MES">Mes: </label>
																						  <select name="MES"  id="MES">
																								<option value="0">Seleccionar</option>
																								<?php
                                                                                                    foreach ($RESMES as $DIR_MES) {
                                                                                                 ?>
                                                                                                    <option value="<?php echo $DIR_MES?>" <?php if($DIR_MES==$MES_SEL){echo "SELECTED";}?>><?php  echo strtoupper(nombremes($DIR_MES));?></option> 
                                                                                                <?php
                                                                                                }
                                                                                                ?>
                                                                                        </select>
																								
																						  
																				<input style="text-transform:uppercase;" type="text" name="BUSCAR" value="<?php echo $BUSCAR;?>">
																				<input type="submit" value="Buscar Ticket(s)" name="BTBUSCAR">
                                                                    <?php
																			} //if($ANIO_SEL<>0)      
																	 } //if($LOCAL_SEL<>0)
																	?>
                            </form>
                </div>
<?php } ?>


</div>
</td></tr></table>
</td></tr></table>