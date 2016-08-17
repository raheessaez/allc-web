

                <?php
				if($RPTN2==12 && empty($RPT)){
						$GENRPT12=@$_POST["GENRPT12"];
						if(empty($GENRPT12)){
				?>
							<script>
                            function validaRpt12(theForm){
                                    var radiosScope = document.getElementsByName('Scope');
                                    for (var i = 0, length = radiosScope.length; i < length; i++) {
                                        if (radiosScope[2].checked) {
                                                if (theForm.DepartmentNo.value == ""){
                                                    alert("Es obligatorio indicar el departamento.");
                                                    theForm.DepartmentNo.focus();
                                                    return false;
                                                }
                                        }
                                    }
                            } //validaRpt11(theForm)
                            </script>
                            <table id="Registro-RACE">
                                    <form action="repo4690.php?<?php echo $StringForm?>" method="post" name="forming" id="forming" onSubmit="return validaRpt12(this)">
                                    <tr>
                                        <td colspan="2"><label for="DepartmentNo">N&uacute;mero de Departamento</label>
                                        <input name="DepartmentNo" type="text" size="30" maxlength="200" > </td>
                                    </tr>
                                    <tr>
                                        <td>
                                                <table id="Listado-RACE">
                                                <tr>
                                                    <th colspan="2">&Aacute;mbito</th>
                                                <tr>
                                                <tr>
                                                    <td class="TDOption"><input type="radio" name="Scope" value="1" checked></td>
                                                    <td>Todos los departamentos</td>
                                                </tr>
                                                <tr>
                                                    <td class="TDOption"><input type="radio" name="Scope" value="2" ></td>
                                                    <td>S&oacute;lo subtotales</td>
                                                </tr>
                                                <tr>
                                                    <td class="TDOption"><input type="radio" name="Scope" value="3" ></td>
                                                    <td>Un departamento</td>
                                                </tr>
                                                </table>
                                        </td>
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
                                       <td colspan="2"><input name="GENRPT12" type="submit" value="Emitir Reporte">
                                        <input name="LIMPIAR" type="reset" value="Limpiar"></td>
                                    </tr>
                                    </form>
                            </table>
                <?php
						} else { //if(empty($GENRPT12))
								$VentanaConsulta="block";
								$DepartmentNo=@$_POST["DepartmentNo"];
								$Scope=@$_POST["Scope"];
								$Period=@$_POST["Period"];
								?>
                                        <div id="VentanaConsulta" style="display:<?php echo $VentanaConsulta;?>">
                                            <div id="VentanaConsulta-contenedor">
                            
													<?php include("MsjeCarga.php");?>

                                                    <div>
                                                    <!-- FRAME DE VERIFICACION -->
                                                            <iframe name="FrmVerifica" src="GeneraReporte.php?<?php echo $StringForm?>&DepartmentNo=<?php echo $DepartmentNo?>&Scope=<?php echo $Scope?>&Period=<?php echo $Period?>" width="0%" height="0" frameborder="0" framespacing="0" marginheight="0" marginwidth="0"></iframe>
                                                    </div>                   
                                            </div>
                                        </div>
                                <?php
						} //if(empty($GENRPT12))
				} else { //if($RPTN2==1 && empty($RPT)
				//DESPLIEGA REPORTE
							if(!empty($RPT)){
								include("PintaReporte.php");
							} //if(!empty($RPT))
				} //if($RPTN2==1 && empty($RPT))
				?>
