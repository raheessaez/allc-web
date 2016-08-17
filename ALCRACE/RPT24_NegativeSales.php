

                <?php
				if($RPTN2==24 && empty($RPT)){
						$GENRPT24=@$_POST["GENRPT24"];
						if(empty($GENRPT24)){
				?>
                            <table id="Registro-RACE">
                                    <form action="repo4690.php?<?php echo $StringForm?>" method="post" name="forming" id="forming">
                                    <tr>
                                        <td><label for="OperatorId">ID Operador</label>
                                        <input name="OperatorId" type="text" size="20" maxlength="200" > </td>
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
                                                    <td class="TDOption"><input type="radio" name="Period" value="2"></td>
                                                    <td>Anterior</td>
                                                </tr>
                                                </table>
                                        </td>
                                    </tr>
                                    <tr>
                                       <td><input name="GENRPT24" type="submit" value="Emitir Reporte">
                                        <input name="LIMPIAR" type="reset" value="Limpiar"></td>
                                    </tr>
                                    </form>
                            </table>
                <?php
						} else { //if(empty($GENRPT24))
								$VentanaConsulta="block";
								$OperatorId=@$_POST["OperatorId"];
								$Period=@$_POST["Period"];
								?>
                                        <div id="VentanaConsulta" style="display:<?php echo $VentanaConsulta;?>">
                                            <div id="VentanaConsulta-contenedor">
                            
													<?php include("MsjeCarga.php");?>

                                                    <div>
                                                    <!-- FRAME DE VERIFICACION -->
                                                            <iframe name="FrmVerifica" src="GeneraReporte.php?<?php echo $StringForm?>&OperatorId=<?php echo $OperatorId?>&Period=<?php echo $Period?>" width="0" height="0" frameborder="0" framespacing="0" marginheight="0" marginwidth="0"></iframe>
                                                    </div>                   
                                            </div>
                                        </div>
                                <?php
						} //if(empty($GENRPT24))
				} else { //if($RPTN2==10 && empty($RPT)
				//DESPLIEGA REPORTE
							if(!empty($RPT)){
								include("PintaReporte.php");
							} //if(!empty($RPT))
				} //if($RPTN2==1 && empty($RPT))
				?>
