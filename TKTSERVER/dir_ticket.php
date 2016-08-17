
<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php include("funciones.php");?>
<?php
	$PAGINA=1114;
	$NOMENU=1;


?>
<style>

.css-treeview ul, .css-treeview li{padding: 0;margin-top: -8px;margin-bottom: -8px;margin-left: 0;margin-right: 0;list-style: none;color: #555;}
.css-treeview input{position: absolute;opacity: 0;}
.css-treeview{-moz-user-select: none;-webkit-user-select: none;user-select: none;}
.css-treeview a{color: #00f;text-decoration: none;}
.css-treeview a:hover{text-decoration: underline;}
.css-treeview input + label + ul{margin: 0 0 0 42px;}
.css-treeview input + label + ul{display: none;}
.css-treeview label,
.css-treeview label::before{cursor: pointer;}
.css-treeview input:disabled + label{cursor: default;opacity: .6;}
.css-treeview input:checked:not(:disabled) + label + ul{display: block;}
.css-treeview label,
.css-treeview label::before{background: url("images/folder-documents-icon.png") no-repeat;}
.css-treeview label,
.css-treeview a,
.css-treeview label::before{display: inline-block;height: 60px;line-height:0;vertical-align: middle;}
.css-treeview input:checked:not(:disabled) + label{background: url("images/folder-documents-open-icon.png") no-repeat;background-position: 18px 0;color: #000;}
.css-treeview input:checked + label::before{background-position: 0 -66px;}
.css-treeview input:checked:not(:disabled):hover + label{background: url("images/folder-documents-open-hover-icon.png") no-repeat;background-position: 18px 0;color: #000;}
.css-treeview input[type='radio'] + label {background: url("images/Transpa.png") no-repeat;background-position: 0 0;margin-top:0;margin-bottom:0;margin-left:4px;margin-right:0;height: 10px;}
.css-treeview input[type='radio']:hover + label {background: url("images/Document-hover-icon.png") no-repeat;background-position: 0 0;margin-top:4px;margin-bottom:0;margin-left:4px;margin-right:10px;height: 34px;}
.css-treeview  input[type='radio'] + label::before{content: "";width: 38px;margin-top: -10px;margin-bottom: 0;margin-left: 6px;margin-right: 0;vertical-align: middle;}
.css-treeview input[type='radio']:hover + label {background: url("images/Document-icon-checked.png") no-repeat;color:#000;}
.css-treeview input[type='radio']:checked:not(:disabled) + label {background: url("images/Document-icon-hover.png") no-repeat;color:#000;}
.css-treeview label{background-position: 18px 0;}
.css-treeview label::before{content: "";width: 66px;margin: 0 26px 0 0;vertical-align: middle;background-position: 0 -66px;}
.css-treeview input:checked + label::before{background-position: 0 -66px;}
.css-treeview input:hover + label{background: url("images/folder-documents-hover-icon.png") no-repeat;background-position: 18px 0;color: #000;}

.ArchivoJ {padding:4px 10px; margin:0; border:1px solid #7A29AC; color:#7A29AC ; background:#FFF;-webkit-border-radius: 3px;-moz-border-radius: 3px; border-radius: 3px;}
.ArchivoJ:hover {color:#FFF ; background:#7A29AC;}


/* webkit adjacent element selector bugfix */
@media screen and (-webkit-min-device-pixel-ratio:0){
.css-treeview {-webkit-animation: webkit-adjacent-element-selector-bugfix infinite 1s;}
	@-webkit-keyframes webkit-adjacent-element-selector-bugfix 
	{
		from 
		{ padding: 0;
		} 
		to 
		{ padding: 0;
		}
	}
}


</style>
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
        
                <table style="margin:20px; ">
                <tr>
                <td>
                
<table style="margin:10px 10px 10px 6px; ">
                <tr>
                <td>
                
					<table width="100%">
                    <tr>
                    	<td nowrap>
                            <div class="css-treeview" style="float:left">
                            <?php
                            //DIRECTORIO LOCAL
                            $ITEM_LOC=-1;
                            if ($GLOC = opendir($DIR_TCK)) {
                                echo "<ul>";
                                while (false !== ($LOCAL = readdir($GLOC))) {
                                    if ($LOCAL != "." && $LOCAL != "..") {
									if(is_numeric($LOCAL)) {	
										$ITEM_LOC=$ITEM_LOC+1;
                            ?>
                                    <li><input type="checkbox" id="<?php echo "item-".$ITEM_LOC;?>" /><label for="<?php echo "item-".$ITEM_LOC;?>" onClick="javascript:CerrarMensajes();"><?php echo "L.".$LOCAL;?></label>
                                    <?php
                                    //DIRECTORIO POS
                                    $ITEM_POS=-1;
                                    if ($GPOS = opendir($DIR_TCK."/".$LOCAL)) {
                                    echo "<ul>";
                                        while (false !== ($POS = readdir($GPOS))) {
                                            if ($POS != "." && $POS != "..") {
                                            $ITEM_POS=$ITEM_POS+1;
                                    ?>
                                                <li><input type="checkbox" id="<?php echo "item-".$ITEM_LOC."-".$ITEM_POS;?>" /><label for="<?php echo "item-".$ITEM_LOC."-".$ITEM_POS;?>" onClick="javascript:CerrarMensajes();"><?php echo "POS.".$POS;?></label>
                                                <?php
                                                //DIRECTORIO AÑO
                                                $ITEM_ANO=-1;
                                                if ($GANO = opendir($DIR_TCK."/".$LOCAL."/".$POS)) {
                                                echo "<ul>";
                                                    while (false !== ($ANO = readdir($GANO))) {
                                                        if ($ANO != "." && $ANO != "..") {
                                                        $ITEM_ANO=$ITEM_ANO+1;
                                                ?>
                                                        <li><input type="checkbox" id="<?php echo "item-".$ITEM_LOC."-".$ITEM_POS."-".$ITEM_ANO;?>" /><label for="<?php echo "item-".$ITEM_LOC."-".$ITEM_POS."-".$ITEM_ANO;?>" onClick="javascript:CerrarMensajes()"><?php echo $ANO;?></label>
                                                        <?php
                                                        //DIRECTORIO MES
                                                        $ITEM_MES=-1;
                                                        if ($GMES = opendir($DIR_TCK."/".$LOCAL."/".$POS."/".$ANO)) {
														echo "<ul>";
                                                            while (false !== ($MES = readdir($GMES))) {
                                                                if ($MES != "." && $MES != "..") {
                                                                $ITEM_MES=$ITEM_MES+1;
                                                        ?>
                                                                <li><input type="checkbox" id="<?php echo "item-".$ITEM_LOC."-".$ITEM_POS."-".$ITEM_ANO."-".$ITEM_MES;?>" /><label for="<?php echo "item-".$ITEM_LOC."-".$ITEM_POS."-".$ITEM_ANO."-".$ITEM_MES;?>" onClick="javascript:CerrarMensajes();"><?php echo nombremes($MES);?></label>
                                                                <?php
                                                                $DIRARCH  = $LOCAL."/".$POS."/".$ANO."/".$MES;
                                                                $directorio=dir($DIR_TCK."/".$DIRARCH);
																$NUM_LINEA=0;
                                                                echo "<ul>";
                                                                while ($archivo = $directorio->read()) {
                                                                        if($archivo != "." && $archivo != "..") {
                                                                                $DIA=$archivo;
                                                                                $LAFECHA= strtotime($MES."/".$DIA."/".$ANO);
                                                                                setlocale(LC_ALL,"es_ES@euro","es_ES","esp"); 

																				$ActivaBusqueda = 0;
																				$ElArchivo = file($DIR_TCK."/".$DIRARCH."/".$archivo);
																				$NUM_LINEA = count($ElArchivo);
																				if($NUM_LINEA >= $CTP){$ActivaBusqueda = 1;}


                                                                ?>
                                                                                <li style="height:38px; margin-left:-44px"><input type="radio" id="<?php echo $LOCAL.$POS.$ANO.$MES.$DIA;?>" onClick="javascript:ActivarMensajes('<?php echo $DIRARCH."/".$archivo?>','<?php echo $NUM_LINEA;?>','<?php echo $ActivaBusqueda;?>');" name="<?php echo $LOCAL.$POS.$ANO.$MES.$DIA;?>" /><label for="<?php echo strftime("%A", $LAFECHA)."  ".$DIA;?>" onClick="javascript:ActivarMensajes('<?php echo $DIRARCH."/".$archivo?>','<?php echo $NUM_LINEA;?>','<?php echo $ActivaBusqueda;?>');">
                                                                                <span class="ArchivoJ"><?php echo strftime("%A", $LAFECHA)."  ".$DIA;?></span></label>
                                                                <?php
                                                                         }
                                                                 }
                                                                echo "</ul>";
                                                                ?>
                                                                </li>
                                                        <?php
                                                                }
                                                            }
                                                        echo "</ul>";
                                                        closedir($GMES);
                                                        }
                                                        ?>
                                                        </li>
                                                <?php
                                                        }
                                                    }
                                                echo "</ul>";
                                                closedir($GANO);
                                                }
                                                ?>
                                                </li>
                                    <?php
                                            }
                                        }
                                    echo "</ul>";
                                    closedir($GPOS);
                                    }
                                    ?>
                                    </li>
                            <?php
									}
									}
                                }
                                echo "</ul>";
                                closedir($GLOC);
                            }
                            ?>
                            </div>
                        </td>
                        <td> 

                           <div id="Paginado" class="VentanaMensajes" style="display:none; border-bottom:none; background-color:#FFF; width:400px; max-width:400px; margin-left:40px">
                                       <input name="ARCHIVO_SEL" type="hidden" id="ARCHIVO_SEL">
                                       <input name="MAXPAG" type="hidden" id="MAXPAG">
                                       <input name="CTP" type="hidden" id="CTP" value="<?php echo $CTP;?>">
                                       
                                       <input name="NUM_RE_PAG" type="hidden" id="NUM_RE_PAG" value="-1">
                                       <input name="NUM_AV_PAG" type="hidden" id="NUM_AV_PAG" value="1">
                                                 
                                       <input name="REPAG" type="button" id="REPAG" value="Anterior" onClick="Pagina(0);">           
                                       <input name="AVPAG" type="button" id="AVPAG" value="Siguiente" onClick="Pagina(1);"> 
                                       <input name="BUSCAR" type="button" id="BUSCAR" value="Filtro y B&uacute;squeda" onClick="ActivarSearchDAT();"> 
									             
                          </div>
                                                                               
                            <script>
                                $(document).ready(function() {
                                        var posicion = $("#DatMensajes").offset();
                                });	
                            </script>
                            <div id="DatMensajes" class="VentanaMensajes" style="border-top:none; background-color:#FFF; width:400px; max-width:400px; margin-left:40px">
                            </div>
                        </td>
                        </tr>
                     </table>
                </td>
                </tr>
                </table>               
                </td>
                </tr>
                </table>
        </td>
        </tr>
        </table>
</td>
</tr>
</table>
			<script>
                $(document).ready(function() {
                        var posicion = $("#SearchDAT").offset();
                });	
            </script>
            <div id="SearchDAT" style="display:none">
                <div id="SearchDAT-contenedor"  style="background-image: url(../images/ARMS.png); background-repeat: no-repeat; background-position: 40px 0;">

                        <span style="position:absolute; top:0; right:20px;">
                        <img src="../images/ICO_Close.png" border="0" onClick="CerrarSearchDAT();" title="Cerrar ventana">
                        </span>

                        <div id="SearchMensajes" class="VentanaSearch" style="display:block;"></div>
                </div>
            </div>
</body>
</html>

