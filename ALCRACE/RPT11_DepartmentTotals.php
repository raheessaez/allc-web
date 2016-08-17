

                <?php
				if($RPTN2==11 && empty($RPT)){
						$GENRPT11=@$_POST["GENRPT11"];
						if(empty($GENRPT11)){
				?>
                            <table id="Registro-RACE">
                                    <form action="repo4690.php?<?php echo $StringForm?>" method="post" name="forming" id="forming" >
                                    <tr>
                                        <td colspan="2">
                                                <table id="Listado-RACE">
                                                <tr>
                                                    <th colspan="2">Per&iacute;odo</th>
                                                <tr>
                                                <tr>
                                                    <td class="TDOption"><input type="radio" name="ExtendedPeriod" value="1" checked></td>
                                                    <td>Per&iacute;odo Actual D&iacute;ario</td>
                                                </tr>
                                                <tr>
                                                    <td class="TDOption"><input type="radio" name="ExtendedPeriod" value="2" ></td>
                                                    <td>Per&iacute;odo Anterior D&iacute;ario</td>
                                                </tr>
                                                <tr>
                                                    <td class="TDOption"><input type="radio" name="ExtendedPeriod" value="3" ></td>
                                                    <td>Per&iacute;odo Actual Acumulado</td>
                                                </tr>
                                                <tr>
                                                    <td class="TDOption"><input type="radio" name="ExtendedPeriod" value="4" ></td>
                                                    <td>Per&iacute;odo Anterior Acumulado</td>
                                                </tr>
                                                </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                                <table id="Listado-RACE">
                                                <tr>
                                                    <th colspan="2">Nivel de Detalle</th>
                                                <tr>
                                                <tr>
                                                    <td class="TDOption"><input type="radio" name="Detail" value="1" checked="checked"></td>
                                                    <td>Todos los departamentos</td>
                                                </tr>
                                                <tr>
                                                    <td class="TDOption"><input type="radio" name="Detail" value="2"></td>
                                                    <td>S&oacute;lo subtotales</td>
                                                </tr>
                                                </table>
                                        </td>
                                        <td>
                                                <table id="Listado-RACE">
                                                <tr>
                                                    <th colspan="2">Tipo Informe</th>
                                                <tr>
                                                <tr>
                                                    <td class="TDOption"><input type="radio" name="Report" value="1" checked="checked"></td>
                                                    <td>Informe b&aacute;sico</td>
                                                </tr>
                                                <tr>
                                                    <td class="TDOption"><input type="radio" name="Report" value="2"></td>
                                                    <td>Informe mejorado</td>
                                                </tr>
                                                </table>
                                        </td>
                                    </tr>
                                    <tr>
                                       <td colspan="2"><input name="GENRPT11" type="submit" value="Emitir Reporte">
                                        <input name="LIMPIAR" type="reset" value="Limpiar"></td>
                                    </tr>
                                    </form>
                            </table>
                <?php
						} else { //if(empty($GENRPT11))
								$VentanaConsulta="block";
								$ExtendedPeriod=@$_POST["ExtendedPeriod"];
								$Detail=@$_POST["Detail"];
								$Report=@$_POST["Report"];
								?>
                                        <div id="VentanaConsulta" style="display:<?php echo $VentanaConsulta;?>">
                                            <div id="VentanaConsulta-contenedor">
                            
													<?php include("MsjeCarga.php");?>

                                                    <div>
                                                    <!-- FRAME DE VERIFICACION -->
                                                            <iframe name="FrmVerifica" src="GeneraReporte.php?<?php echo $StringForm?>&ExtendedPeriod=<?php echo $ExtendedPeriod?>&Detail=<?php echo $Detail?>&Report=<?php echo $Report?>" width="0" height="0" frameborder="0" framespacing="0" marginheight="0" marginwidth="0"></iframe>
                                                    </div>                   
                                            </div>
                                        </div>
                                <?php
						} //if(empty($GENRPT11))
				} else { //if($RPTN2==10 && empty($RPT)
				//DESPLIEGA REPORTE
							if(!empty($RPT)){
								include("PintaReporte.php");
							} //if(!empty($RPT))
				} //if($RPTN2==1 && empty($RPT))
				?>
