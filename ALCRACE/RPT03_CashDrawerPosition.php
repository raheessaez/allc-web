

                <?php
				if($RPTN2==3 && empty($RPT)){
						$GENRPT3=@$_POST["GENRPT3"];
						if(empty($GENRPT3)){
				?>
							<script>
                            function validaRpt3(theForm){
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
                            } //validaRpt31(theForm)
                            </script>
                            <table id="Registro-RACE">
                                    <form action="repo4690.php?<?php echo $StringForm?>" method="post" name="forming" id="forming" onSubmit="return validaRpt3(this)">
                                    <tr>
                                        <td colspan="2">
                                            <label for="OperTermId">ID Operador /*Terminal</label>
                                            <input name="OperTermId" type="text" size="30" maxlength="200" >
                                        </td>
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
                                                    <td>Detalle</td>
                                                </tr>
                                                <tr>
                                                    <td class="TDOption"><input type="radio" name="Detail" value="2" ></td>
                                                    <td>Resumen</td>
                                                </tr>
                                                </table>
                                        </td>
                                    	<td>
                                                <table id="Listado-RACE">
                                                <tr>
                                                    <th colspan="2">Per&iacute;odo</th>
                                                </tr>
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
                                       <td colspan="2"><input name="GENRPT3" type="submit" value="Emitir Reporte">
                                        <input name="LIMPIAR" type="reset" value="Limpiar"></td>
                                    </tr>
                                    </form>
                            </table>
                <?php
						} else { //if(empty($GENRPT3))
								$VentanaConsulta="block";
								$OperTermId=@$_POST["OperTermId"];
								$Scope=@$_POST["Scope"];
								$Detail=@$_POST["Detail"];
								$Period=@$_POST["Period"];
								?>
                                        <div id="VentanaConsulta" style="display:<?php echo $VentanaConsulta;?>">
                                            <div id="VentanaConsulta-contenedor">
                            
													<?php include("MsjeCarga.php");?>

                                                    <div>
                                                    <!-- FRAME DE VERIFICACION -->
                                                            <iframe name="FrmVerifica" src="GeneraReporte.php?<?php echo $StringForm?>&OperTermId=<?php echo $OperTermId?>&Scope=<?php echo $Scope?>&Detail=<?php echo $Detail?>&Period=<?php echo $Period?>" width="0%" height="0" frameborder="0" framespacing="0" marginheight="0" marginwidth="0"></iframe>
                                                    </div>                   
                                            </div>
                                        </div>
                                <?php
						} //if(empty($GENRPT3))
				} else { //if($RPTN2==1 && empty($RPT)
				//DESPLIEGA REPORTE
							if(!empty($RPT)){
								include("PintaReporte.php");
							} //if(!empty($RPT))
				} //if($RPTN2==1 && empty($RPT))
				?>
