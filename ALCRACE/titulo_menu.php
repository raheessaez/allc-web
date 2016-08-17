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

            <form action="repo4690.php" method="post" name="formSel" id="formSel">
            <h1 style="margin-bottom:9px"><?php echo $GLBELCLIENTE.": ".$LAPAGINA?></h1>
            		<?php
					//SELECCIONAR TIENDA
					?>
                    <select  style="display:inline; float:left; font-size:10pt; font-weight:400; margin:14px 20px; padding:6px 20px 6px 6px; height:32px;"  id="TIENDA" name="TIENDA" onChange="document.forms.formSel.submit();">
                        <option value="0">Sel. Local</option>
                        <?php
							$SQL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA<>0 ORDER BY DES_CLAVE ASC";
							$RS = sqlsrv_query($maestra, $SQL);
							//oci_execute($RS);
							while ($row = sqlsrv_fetch_array($RS)) {
								$NUM_TIENDA = $row['DES_CLAVE'];
								$DES_TIENDA = $row['DES_TIENDA'];
								$NUM_TIENDA_F="0000".$NUM_TIENDA;
								$NUM_TIENDA_F=substr($NUM_TIENDA_F, -4); 
								//VERIFICAR QUE TIENDA SE ENCUENTRE REGISTRADA CON ARCHIVOS EN ADX_IPGM
								
								$carpeta = scandir($SYNC_OUT.$NUM_TIENDA."/adx_ipgm");
								if (count($carpeta) > 2){
									$VERTND = 1;
								} else {
									$VERTND = 0;
								}								
								
								if($VERTND != 0){
								 ?>
								<option value="<?php echo $NUM_TIENDA?>" <?php if($NUM_TIENDA==$_SESSION['TIENDA_SEL']) {echo "Selected";} ?>><?=$NUM_TIENDA_F." - ".$DES_TIENDA;?></option>
								<?php 
								}
							}
                        ?>
                    </select>
            </form>
<?php } //$NOMENU==0?>



</div>
</td></tr></table>
</td></tr></table>