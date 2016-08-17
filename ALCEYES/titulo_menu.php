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
    <?php if ($LOG==1){ ?>
    <h1 style="margin-bottom:9px"><?php echo $GLBELCLIENTE.": ".$LAPAGINA?></h1>
            <?php if($PAGINA==1159 || $PAGINA==1160 || $PAGINA==1161 || $PAGINA==1162){?>
                        <ul id="BTN-OcultarMenuGeneral" style="display:block">
                            <li class="activo"><a href="#" onClick="OcultarMenuGeneral();">Ocultar Men&uacute;</a></li>
                        </ul>
                        <ul id="BTN-VerMenuGeneral" style="display:none">
                            <li class="activo"><a href="#" onClick="MostrarMenuGeneral();">Ver Men&uacute;</a></li>
                         </ul>
            <?php }?>
    <?php }}if ($LOG==0){ ?>
    <h1><?php echo $GLBELCLIENTE ?></h1>
     <ul>
             <li <?php if ($LOG2==1) { ?>class="activo"<?php } ?>>
                 <a href="<?php echo $PAGASP?>">
                     Transacciones
                 </a>
             </li>
	     <?php if ($SESPUBLICA==1) { ?> <?php if($LOG==0) { ?>
             <li <?php if ($LOG2==2) { ?>class="activo"<?php } ?>>
                 <a href="<?php echo $PAGASP?>?LOG2=2">
                     EPS
                 </a>
             </li>
	    <?php } ?><?php } ?>
            

     </ul>


<?php } ?>


</div>
</td></tr></table>
</td></tr></table>