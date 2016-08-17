<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php include("funciones.php");?>
<?php
	$PAGINA=1115;
	$NOMENU=1;

			//BUSCAR TICKETS
			$LOCAL=@$_POST["LOCAL"];
			if (empty($LOCAL)) { $LOCAL=@$_GET["LOCAL"]; }
			$ANIO=@$_POST["ANIO"];
			if (empty($ANIO)) { $ANIO=@$_GET["ANIO"]; }
			if (empty($ANIO)) { $ANIO=date('Y'); }
			$MES=@$_POST["MES"];
			if (empty($MES)) { $MES=@$_GET["MES"]; }	
			if (empty($MES)) { $MES=date('m'); }
			
			$PARACAL=$ANIO."-".$MES;
				
			$BTBUSCAR=@$_POST["BTBUSCAR"];
			if (!empty($BTBUSCAR)) {
					$BUSCAR=@$_POST["BUSCAR"];
					if (empty($BUSCAR)) { $BUSCAR=@$_GET["BUSCAR"]; }
					if (!empty($BUSCAR) and strlen($BUSCAR)==1) {
						$BUSCAR="";
						$AVISO=1;
					} 
			} else {
				$BUSCAR="";
			}

			setlocale( LC_TIME, 'spanish' );
			$month = isset( $PARACAL ) ? $PARACAL : date( 'Y-n' );
			$week = 1;
			for ( $i=1;$i<=date( 't', strtotime( $month ) );$i++ ) {
				$day_week = date( 'N', strtotime( $month.'-'.$i )  );
				$calendar[ $week ][ $day_week ] = $i;
				if ( $day_week == 7 )
				$week++;
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
            <table style="margin:20px; ">
            <tr>
            <td>
			<?php
			//VERIFICAR EN DIRECTORIO LOCAL POSxPOS QUE TENGA EL AÑO Y EL MES
			function BuscaTicketDIA($local, $anio, $mes, $dia, $dir_dat, $buscar)
			{ //1
				
				$DIR_LOCAL=$dir_dat."/".$local;
				if ($GPOS = opendir($DIR_LOCAL)) { //2
					$Tickets="";
					$POSSEL="";
					while (false !== ($POS = readdir($GPOS))) { //3
						if ($POS != "." && $POS != "..") { //4
								if ($GANO = opendir($DIR_LOCAL."/".$POS)) { //5
									while (false !== ($ANIO = readdir($GANO))) { //6
										if ($ANIO != "." && $ANIO != ".." && $ANIO == $anio) { //7
												if ($GMES = opendir($DIR_LOCAL."/".$POS."/".$anio)) { //8
													while (false !== ($MES = readdir($GMES))) { //9
														if ($MES != "." && $MES != ".." && $MES == $mes) { //10
																$DIRARCH  = $DIR_LOCAL."/".$POS."/".$anio."/".$mes;
																$directorio=dir($DIRARCH);
																while ($JOURNAL = $directorio->read()) { //11
																		if($JOURNAL != "." && $JOURNAL != "..") { //12
																				//$ELARCHIVO=$DIRARCH."/".$JOURNAL;
																				$ELARCHIVO=$DIRARCH."/".$dia;
																				$gestor = fopen($ELARCHIVO, "r");
																				$contenido = fread($gestor, filesize($ELARCHIVO));
																				fclose($gestor);
																				if(!empty($buscar)) { //13
																					if (stripos($contenido, $buscar)) {
																							//$Tickets=$Tickets."|D".$JOURNAL."P".$POS;
																							if($POSSEL<>$POS){$Tickets=$Tickets."|P".$POS;}
																							$POSSEL=$POS;
																					}
																				} //13
																		 } //12
																 } //11
														} //10
													} //9
												} //8
										} //7
									} //6
								} //5
						} //4
					} //3
				} //2
									$ARREGLO_TICKET = explode("|", $Tickets);
									asort($ARREGLO_TICKET);
									$ArregloTickets="";
									foreach ($ARREGLO_TICKET as $key => $val) {
										$ArregloTickets=$ArregloTickets."|".$val;
									}				
									$ARREGLO_ORDENADO = explode("|", $ArregloTickets);
									$i=0;
									$NUEVACELDA="";
									while ($i < count ($ARREGLO_ORDENADO) ) {
												if(!empty($ARREGLO_ORDENADO[$i])) {
													$CELDA=$ARREGLO_ORDENADO[$i];
															$posP = stripos($CELDA, "P");
															$ELPOS = substr($CELDA, $posP);
															$NUEVACELDA=$NUEVACELDA.$ELPOS;
												}
												$i++;
									}
									$ARREGLO_DEPOS = explode("|", $NUEVACELDA);
									
									return $ARREGLO_DEPOS;
									
			} //1
			?>
						<div id="Calendario">
                            <table>
                                    <thead>
                                            <tr>
                                                    <th colspan="7"><?php echo nombremes($MES)." ".$ANIO; ?></th>                        
                                            </tr>
                                            <tr>
                                                    <td class="NombDia">LUN</td>
                                                    <td class="NombDia">MAR</td>                        
                                                    <td class="NombDia">MIE</td>                        
                                                    <td class="NombDia">JUE</td>                        
                                                    <td class="NombDia">VIE</td>                        
                                                    <td class="NombDia">SAB</td>                        
                                                    <td class="NombDia">DOM</td>                        
                                            </tr>
                                    </thead>
                                    <tbody>
                                            <?php foreach ( $calendar as $days ) : ?>
                                                    <tr>
                                                            <?php
                                                            for ( $j=1;$j<=7;$j++ ) : 
															
                                                                    $DIA_SEL= isset( $days[ $j ] ) ? $days[ $j ] : '';
																	$DIA_CAL=substr('00'.$DIA_SEL, -2);
																			if (!empty($DIA_SEL)){ $LACLASETD="ElDia"; } else {$LACLASETD="ElNoDia";}

																			if(!empty($BUSCAR)) {
																							$FUNC = 'BuscaTicketDIA';
																							 $ELARREGLO = $FUNC($LOCAL, $ANIO, $MES, $DIA_SEL, $DIR_TCK, $BUSCAR);
																							foreach ($ELARREGLO as $key => $val) 
																							 if(!empty($val)){
																										?>
						                                                                                <td class="ElDiaSel" >
																										<a href="#" title="Ver Tickets" onClick="javascript:ActivarSearchJournal('<?php echo $val?>', '<?php echo $DIA_SEL?>', '<?php echo $LOCAL?>', '<?php echo $ANIO?>', '<?php echo $MES?>', '<?php echo $BUSCAR?>');">
																										<?php echo $DIA_SEL;?>
																										</a>
                                                                                                        </td>
																										<?php
																							 } else {
																							  ?>
                                                                                                        <td class="<?php echo $LACLASETD;?>" >
																										 <?php echo $DIA_SEL; ?>
                                                                                                         </td>
                                                                                              <?php
																							 }
																			} else { //!empty($BUSCAR)) 
																			?>
																					<td class="<?php echo $LACLASETD;?>" ><?php echo $DIA_SEL;?></td>
																			<?php
																			} //!empty($BUSCAR)) 

                                                            endfor;
															?>
                                                    </tr>
                                            <?php endforeach; ?>
                                    </tbody>
                            </table>
                            </div>
                                            
            </td>
            </tr>
            </table>
        </td></tr>
        </table>
</td>
</tr>
</table>







</body>
</html>

			<script>
                $(document).ready(function() {
                        var posicion = $("#SearchJournal").offset();
                });	
            </script>
            <div id="SearchJournal" style="display:none" onClick="CerrarSearchJournal();">
                <div id="SearchJournal-contenedor"  style="background-image: url(../images/ARMS.png); background-repeat: no-repeat; background-position: 50px 10px;">
                       
                        <span style="position:absolute; top:0; right:20px;">
                        <img src="../images/ICO_Close.png" border="0" onClick="CerrarSearchJournal();" title="Cerrar ventana">
                        </span>

                        <div id="Journal" class="VentanaJournal" style="display:block"></div>
                </div>
            </div>

<?php if($AVISO==1) {?>
	<script>
            alert('Se necesita m\xe1s de un caracter en el campo de b\xfasqueda');
    </script>
<?php }?>

