

                <?php
				if($RPTN2==4 && empty($RPT)){
						$GENRPT4=@$_POST["GENRPT4"];
						if(empty($GENRPT4)){
				?>
							<script>
                            function validaRpt4(theForm){
                                    var radiosScope = document.getElementsByName('Scope');
                                    for (var i = 0, length = radiosScope.length; i < length; i++) {
                                        if (radiosScope[0].checked) {
                                                if (theForm.OperTermId.value == ""){
                                                    alert("Es obligatorio indicar ID de Operador o Terminal.");
                                                    theForm.OperTermId.focus();
                                                    return false;
                                                }
                                        }
                                    }
                            } //validaRpt41(theForm)
                            </script>
                            <table id="Registro-RACE">
                                    <form action="repo4690.php?<?php echo $StringForm?>" method="post" name="forming" id="forming" onSubmit="return validaRpt4(this)">
                                    <tr>
                                        <td colspan="2"><label for="OperTermId">ID Operador /*Terminal</label><input name="OperTermId" type="text" size="30" maxlength="200" > </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                                <table id="Listado-RACE">
                                                <tr>
                                                    <th colspan="2">&Aacute;mbito</th>
                                                </tr>
                                                <tr>
                                                    <td class="TDOption"><input type="radio" name="Scope" value="1" ></td>
                                                    <td>Terminales u Operadores Seleccionados</td>
                                                </tr>
                                                <tr>
                                                    <td class="TDOption"><input type="radio" name="Scope" value="2" checked></td>
                                                    <td>Todos los Terminales u Operadores</td>
                                                </tr>
                                                </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                                <table id="Listado-RACE">
                                                <tr>
                                                    <th colspan="2">Nivel de Detalle</th>
                                                </tr>
                                                <tr>
                                                    <td class="TDOption"><input type="radio" name="Detail" value="1" checked></td>
                                                    <td>Informes Seleccionados</td>
                                                </tr>
                                                <tr>
                                                    <td class="TDOption"><input type="radio" name="Detail" value="2" ></td>
                                                    <td>Todos los Informes</td>
                                                </tr>
                                                </table>
                                        </td>
                                        <td>
                                                <table id="Listado-RACE">
                                                <tr>
                                                    <th colspan="2">Per&iacute;odo</th>
                                                </tr>
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
                                       <td colspan="2"><input name="GENRPT4" type="submit" value="Emitir Reporte">
                                        <input name="LIMPIAR" type="reset" value="Limpiar"></td>
                                    </tr>
                                    </form>
                            </table>
                <?php
						} else { //if(empty($GENRPT4))
								$VentanaConsulta="block";
								$OperTermId=@$_POST["OperTermId"];
								$Scope=@$_POST["Scope"];
								$ExtendedPeriod=@$_POST["ExtendedPeriod"];
								$Detail=@$_POST["Detail"];
								?>
                                        <div id="VentanaConsulta" style="display:<?php echo $VentanaConsulta;?>">
                                            <div id="VentanaConsulta-contenedor">
                            
													<?php include("MsjeCarga.php");?>

                                                    <div>
                                                    <!-- FRAME DE VERIFICACION -->
                                                            <iframe name="FrmVerifica" src="GeneraReporte.php?<?php echo $StringForm?>&OperTermId=<?php echo $OperTermId?>&Scope=<?php echo $Scope?>&ExtendedPeriod=<?php echo $ExtendedPeriod?>&Detail=<?php echo $Detail?>" width="0%" height="0" frameborder="0" framespacing="0" marginheight="0" marginwidth="0"></iframe>
                                                    </div>                   
                                            </div>
                                        </div>
                                <?php
						} //if(empty($GENRPT4))
				} else { //if($RPTN2==1 && empty($RPT)
				//DESPLIEGA REPORTE
							if(!empty($RPT)){
								include("PintaReporte.php");
							} //if(!empty($RPT))
				} //if($RPTN2==1 && empty($RPT))
				?>
