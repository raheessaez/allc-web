	<?php
	$CONSULTA="SELECT NOMBRE FROM US_ACCESO WHERE IDACC=".$PAGINA;
	//$RS = sqlsrv_query($maestra, $CONSULTA);
	////oci_execute($RS);
	$RS = sqlsrv_query($maestra,$CONSULTA); 

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
                    
					<?php if ($SESPUBLICA==1) {  //PERFIL PUBLICACION?>
						<?php
                        if($NONEO==0) {  //DEVOLUCIONES
								if($PAGINA!=1169){
									$SQL="SELECT * FROM DV_TIPOD WHERE AC_TIPOD=1 ORDER BY ID_TIPOD ASC";
								} else {
									$SQL="SELECT * FROM DV_TIPOD WHERE AC_TIPOD=99 ORDER BY ID_TIPOD ASC";
								}
								//$RS = sqlsrv_query($conn, $SQL);
								////oci_execute($RS);
								$RS = sqlsrv_query($conn,$SQL); 

								while ($row = sqlsrv_fetch_array($RS)) {
									$ID_TIPOD = $row['ID_TIPOD'];
									$NM_TIPOD = $row['NM_TIPOD'];
								?>
                                        <li <?php if ($D_GFC==$ID_TIPOD) { ?>class="activo"<?php } ?>><a href="<?php echo $PAGASP?>?D_GFC=<?php echo $ID_TIPOD;?>"><?php echo $NM_TIPOD;?></a></li>
                        		<?php
								}
                        }
						?>
					<?php } ?>
            </ul>
<?php } else {  //$NOMENU==1?>
    <h1 style="margin-bottom:9px"><?php echo $GLBELCLIENTE.": ".$LAPAGINA?></h1>
<?php } //$NOMENU==0?>



</div>
</td></tr></table>
</td></tr></table>