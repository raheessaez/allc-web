	<?php
	$COD_TIENDA = @$_SESSION['TIENDA_SEL'];
			//IDIOMA TITULOS INDICAT
			$IDIOMA=$_POST["IDIOMA"];

			if ($IDIOMA=="ESP") {

					$_SESSION['LAN_INDICAT'] = "DES_ES";	

			}

			if ($IDIOMA=="ENG") {

					$_SESSION['LAN_INDICAT'] = "DES_EN";	

			}

			if (!isset($_SESSION['LAN_INDICAT'])) {

					$_SESSION['LAN_INDICAT'] = "DES_EN";	

				}

			$LAN = $_SESSION['LAN_INDICAT'];

	$CONSULTA="SELECT * FROM US_ACCESO WHERE IDACC=".$PAGINA;
	$RS = sqlsrv_query($maestra, $CONSULTA);
	//oci_execute($RS);

	if ($row = sqlsrv_fetch_array($RS)) {

		if(strcmp($LAN,"DES_EN") !== 0){ 

			$LAPAGINA = $row['NOMBRE'];

		}else{

			$LAPAGINA = $row['NAME'];

		}

	}	

	$URLPAG=basename( $_SERVER['PHP_SELF'] );
	$PAGASP=$URLPAG;

	if ($SESPUBLICA==0 and ($NEO<>"" or $ACT<>"")) {

		header("Location: ".$PAGASP);

	}

	if(empty($NOMENU)) { $NOMENU=0; }
	if(empty($LINK)) { $LINK=0; }
	if(empty($NONEO)) { $NONEO=0; }

	?>

<style>

#overlay {

  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  text-align: center;
  background-color: #000;
  filter: alpha(opacity=50);
  -moz-opacity: 0.5;
  opacity: 0.5;

}

#overlay span {

        padding: 50px;
    border-radius: 5px;
    color: #000;
    background-color: #fff;
    position: relative;
    top: 50%;
    font-size: 40px;
	    padding-top: 80px;

}

</style>

<div id="mensaje">
</div>

<div id="overlay" style="display:none; z-index:9999">

<span><img src="../images/Preload.GIF" title="loading" width="80px"></span>

</div>

<table width="100%"><tr><td bgcolor="#FFFFFF" style="border-bottom:thin; border-bottom-color:#E5E5E5; border-bottom-style:solid;">

<table><tr><td>

<div id="MenuModulo" style="width:auto;">

<?php if ($NOMENU==0) {?>

    <h1><?php echo $GLBELCLIENTE ?></h1>
            <ul>
                    <li <?php if ($LIST==1) { ?>class="activo"<?php } ?>><a href="<?php echo $PAGASP?>">Listado</a></li>
					<?php if ($SESPUBLICA==1) {  //PERFIL PUBLICACION?> <?php if($NONEO==0) {  //NUEVO?>

                    <li <?php if ($NEO==1) { ?>class="activo"<?php } ?>><a href="<?php echo $PAGASP?>?NEO=1">Nuevo</a></li>

					<?php } ?><?php } ?>

            </ul>
<?php } else {  //$NOMENU==1?>

            <form action="mod_pace.php" method="post" name="formSel" id="formSel">

            <h1 style="margin-bottom:9px"><?php echo $GLBELCLIENTE.": ".$LAPAGINA?></h1>

            		<?php

					//SELECCIONAR TIENDA
					?>
                    <select  style="display:inline; float:left; font-size:10pt; font-weight:400; margin:14px 20px; padding:6px 20px 6px 6px; height:32px;"  id="TIENDA" name="TIENDA" onChange="document.forms.formSel.submit();">

                        <option value="0">Sel. Local</option>
                        <?php

							$SQL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA<>0 AND IND_ACTIVO = 1 ORDER BY DES_CLAVE ASC";
							$RS = sqlsrv_query($maestra, $SQL);
							//oci_execute($RS);

							while ($row = sqlsrv_fetch_array($RS)) {

								$NUM_TIENDA = $row['DES_CLAVE'];
								$DES_TIENDA = $row['DES_TIENDA'];
								$NUM_TIENDA_F="0000".$NUM_TIENDA;
								$NUM_TIENDA_F=substr($NUM_TIENDA_F, -4); 
								?>

								<option value="<?php echo $NUM_TIENDA?>" <?php if($NUM_TIENDA==$_SESSION['TIENDA_SEL']) {echo "Selected";} ?>><?=$NUM_TIENDA_F." - ".$DES_TIENDA;?></option>

								<?php 

							}

                        ?>

                    </select>

            </form>

<?php } //$NOMENU==0?>

</div>
</td>

<?php if($LINK == 1){ ?>

<td style="padding-top:15px;margin-right:10px;">

                        		<form action="mod_pace.php" method="post">

                                        <input style="padding:4px 8px; margin:1px;  border-color:#666" name="IDIOMA" type="submit" value="ESP" title="espa&ntilde;ol">
                                        <input style="padding:4px 8px; margin:1px;  border-color:#666" name="IDIOMA" type="submit" value="ENG" title="english">

                                </form>
	</td>
  <td style="padding-top:15px;"> 

<?php if($COD_TIENDA <> 0){ ?>

	<?php if(strcmp($LAN,"DES_EN") !== 0){ ?>

		<input style="padding:4px 8px; margin:1px;  border-color:#666;" name="Exportar" type="button" id="Exportar" value="Cargar Tienda" onclick="exportar(<?=$COD_TIENDA; ?>)" >

	<?php }else{ ?>

		<input style="padding:4px 8px; margin:1px;  border-color:#666;" name="Exportar" type="button" id="Exportar" value="Load Store" onclick="exportar(<?=$COD_TIENDA; ?>)" >

	<?php } ?>

<?php } ?>

<script type="text/javascript">

function exportar(tienda)
{

	var cod_tienda=tienda;
	var dataString = 'cod_tienda='+cod_tienda+'&lan=<?=$LAN;?>';
	$("#overlay").css("display","block");

		$.ajax({

			type: "GET",
			url: "pa_export.php",
			data: dataString,
			cache: false,
			success: function(response)
			{

				$("#overlay").css("display","none");
				$("#mensaje").html('<div id="GMessaje" onClick="QuitarGMessage();"><a id="mens" href="#" onClick="QuitarGMessage();" style="color:#111111;">'+response+'</a></div>');

			}
	})

}

</script>
</td>

<?php } ?>

</tr></table>
</td></tr></table>

