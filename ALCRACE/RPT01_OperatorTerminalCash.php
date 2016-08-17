

                <?php
				if($RPTN2==1 && empty($RPT)){
						$GENRPT1=@$_POST["GENRPT1"];
						if(empty($GENRPT1)){
				?>
							<script>
                            function validaRpt1(theForm){
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
                            } //validaRpt11(theForm)
                            </script>
                            <table id="Registro-RACE">
                                    <form action="repo4690.php?<?php echo $StringForm?>" method="post" name="forming" id="forming" onSubmit="return validaRpt1(this)">
                                    <tr>
                                        <td colspan="2">
                                        <label for="OperTermId">ID Operador /*Terminal</label>
                                        <input name="OperTermId" type="text" size="30" maxlength="200" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                                <table id="Listado-RACE">
                                                <tr>
                                                    <th colspan="2">Per&iacute;odo</th>
                                                </tr>
                                                <tr>
                                                    <td><input type="radio" name="ExtendedPeriod" value="1" checked></td>
                                                    <td>Per&iacute;odo Actual D&iacute;ario</td>
                                                </tr>
                                                <tr>
                                                    <td><input type="radio" name="ExtendedPeriod" value="2" ></td>
                                                    <td>Per&iacute;odo Anterior D&iacute;ario</td>
                                                </tr>
                                                <tr>
                                                    <td><input type="radio" name="ExtendedPeriod" value="3" ></td>
                                                    <td>Per&iacute;odo Actual Acumulado</td>
                                                </tr>
                                                <tr>
                                                    <td><input type="radio" name="ExtendedPeriod" value="4" ></td>
                                                    <td>Per&iacute;odo Anterior Acumulado</td>
                                                </tr>
                                                </table>
                                        </td>
                                        <td>
                                                <table id="Listado-RACE">
                                                <tr>
                                                    <th colspan="2">&Aacute;mbito</th>
                                                </tr>
                                                <tr>
                                                    <td><input type="radio" name="Scope" value="1" checked></td>
                                                    <td>Informes Seleccionados</td>
                                                </tr>
                                                <tr>
                                                    <td><input type="radio" name="Scope" value="2" ></td>
                                                    <td>Todos los Informes</td>
                                                </tr>
                                                <tr>
                                                    <td><input type="radio" name="Scope" value="3" ></td>
                                                    <td>Todos los Informes no Impresos</td>
                                                </tr>
                                                <tr>
                                                    <td><input type="radio" name="Scope" value="4" ></td>
                                                    <td>Informe de Resumen</td>
                                                </tr>
                                                </table>
                                        </td>
                                    </tr>
                                    <tr>
                                       <td colspan="2">
                                        <input name="LIMPIAR" type="reset" value="Limpiar">
                                         <input name="GENRPT1" type="submit" value="Emitir Reporte">
                                      </td>
                                    </tr>
                                    </form>
                            </table>
                <?php
						} else { //if(empty($GENRPT1))
								$VentanaConsulta="block";
								$OperTermId=@$_POST["OperTermId"];
								$ExtendedPeriod=@$_POST["ExtendedPeriod"];
								$Scope=@$_POST["Scope"];
								?>
                                        <div id="VentanaConsulta" style="display:<?php echo $VentanaConsulta;?>">
                                            <div id="VentanaConsulta-contenedor">
                            
													<?php include("MsjeCarga.php");?>

                                                    <div>
                                                    <!-- FRAME DE VERIFICACION -->
                                                            <iframe name="FrmVerifica" src="GeneraReporte.php?<?php echo $StringForm?>&OperTermId=<?php echo $OperTermId?>&ExtendedPeriod=<?php echo $ExtendedPeriod?>&Scope=<?php echo $Scope?>" width="0%" height="0" frameborder="0" framespacing="0" marginheight="0" marginwidth="0"></iframe>
                                                    </div>                   
                                            </div>
                                        </div>
                                <?php
						} //if(empty($GENRPT1))
				} else { //if($RPTN2==1 && empty($RPT)
				//DESPLIEGA REPORTE
							if(!empty($RPT)){
								include("PintaReporte.php");
							} //if(!empty($RPT))
				} //if($RPTN2==1 && empty($RPT))
				?>
