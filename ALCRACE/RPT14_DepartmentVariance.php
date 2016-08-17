

                <?php
				if($RPTN2==14 && empty($RPT)){
						$GENRPT14=@$_POST["GENRPT14"];
						if(empty($GENRPT14)){
				?>
                            <table id="Registro-RACE">
                                    <form action="repo4690.php?<?php echo $StringForm?>" method="post" name="forming" id="forming">
                                    <tr>
                                        <td>
                                                <table id="Listado-RACE">
                                                <tr>
                                                    <th colspan="2">Per&iacute;odo</th>
                                                <tr>
                                                <tr>
                                                    <td class="TDOption"><input type="radio" name="Period" value="1" checked></td>
                                                    <td>Actual</td>
                                                </tr>
                                                <tr>
                                                    <td class="TDOption"><input type="radio" name="Period" value="2" ></td>
                                                    <td>Anterior</td>
                                                </tr>
                                                <tr>
                                                    <td class="TDOption"><input type="radio" name="Period" value="3" ></td>
                                                    <td>Antiguo</td>
                                                </tr>
                                                </table>
                                        </td>
                                    </tr>
                                    <tr>
                                       <td><input name="GENRPT14" type="submit" value="Emitir Reporte">
                                        <input name="LIMPIAR" type="reset" value="Limpiar"></td>
                                    </tr>
                                    </form>
                            </table>
                <?php
						} else { //if(empty($GENRPT14))
								$VentanaConsulta="block";
								$Period=@$_POST["Period"];
								?>
                                        <div id="VentanaConsulta" style="display:<?php echo $VentanaConsulta;?>">
                                            <div id="VentanaConsulta-contenedor">
                            
													<?php include("MsjeCarga.php");?>

                                                    <div>
                                                    <!-- FRAME DE VERIFICACION -->
                                                            <iframe name="FrmVerifica" src="GeneraReporte.php?<?php echo $StringForm?>&Period=<?php echo $Period?>" width="0%" height="0" frameborder="0" framespacing="0" marginheight="0" marginwidth="0"></iframe>
                                                    </div>                   
                                            </div>
                                        </div>
                                <?php
						} //if(empty($GENRPT14))
				} else { //if($RPTN2==1 && empty($RPT)
				//DESPLIEGA REPORTE
							if(!empty($RPT)){
								include("PintaReporte.php");
							} //if(!empty($RPT))
				} //if($RPTN2==1 && empty($RPT))
				?>
