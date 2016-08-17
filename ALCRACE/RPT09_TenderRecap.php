

                <?php
				if($RPTN2==9 && empty($RPT)){
						$GENRPT9=@$_POST["GENRPT9"];
						if(empty($GENRPT9)){
				?>
                            <table id="Registro-RACE">
                                    <form action="repo4690.php?<?php echo $StringForm?>" method="post" name="forming" id="forming">
                                    <tr>
                                        <td><label for="ExcludedTerminals">Excluir Terminales</label>
                                        <input name="ExcludedTerminals" type="text" size="20" maxlength="300" > </td>
                                    </tr>
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
                                                </table>
                                        </td>
                                    </tr>
                                    <tr>
                                       <td><input name="GENRPT9" type="submit" value="Emitir Reporte">
                                        <input name="LIMPIAR" type="reset" value="Limpiar"></td>
                                    </tr>
                                    </form>
                            </table>
                <?php
						} else { //if(empty($GENRPT9))
								$VentanaConsulta="block";
								$ExcludedTerminals=@$_POST["ExcludedTerminals"];
								$Period=@$_POST["Period"];
								?>
                                        <div id="VentanaConsulta" style="display:<?php echo $VentanaConsulta;?>">
                                            <div id="VentanaConsulta-contenedor">
                            
													<?php include("MsjeCarga.php");?>

                                                    <div>
                                                    <!-- FRAME DE VERIFICACION -->
                                                            <iframe name="FrmVerifica" src="GeneraReporte.php?<?php echo $StringForm?>&ExcludedTerminals=<?php echo $ExcludedTerminals?>&Period=<?php echo $Period?>" width="0%" height="0" frameborder="0" framespacing="0" marginheight="0" marginwidth="0"></iframe>
                                                    </div>                   
                                            </div>
                                        </div>
                                <?php
						} //if(empty($GENRPT9))
				} else { //if($RPTN2==1 && empty($RPT)
				//DESPLIEGA REPORTE
						if(!empty($RPT)){
							include("PintaReporte.php");
						} //if(!empty($RPT))
				} //if($RPTN2==1 && empty($RPT))
				?>
