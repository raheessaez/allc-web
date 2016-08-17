

                <?php
				if($RPTN2==6 && empty($RPT)){
						$GENRPT6=@$_POST["GENRPT6"];
						if(empty($GENRPT6)){
				?>
							<script>
                            function validaRpt1(theForm){
                                    var radiosScope = document.getElementsByName('Scope');
                                    for (var i = 0, length = radiosScope.length; i < length; i++) {
                                        if (radiosScope[5].checked) {
                                                if (theForm.SingleTerminal.value == ""){
                                                    alert("Es obligatorio indicar el Terminal.");
                                                    theForm.SingleTerminal.focus();
                                                    return false;
                                                }
                                        }
                                    }
                            } //validaRpt11(theForm)
                            </script>
                            <table id="Registro-RACE">
                                    <form action="repo4690.php?<?php echo $StringForm?>" method="post" name="forming" id="forming" onSubmit="return validaRpt1(this)">
                                    <tr>
                                        <td>
                                                <table id="Listado-RACE">
                                                <tr>
                                                    <th colspan="2">Informe Estado</th>
                                                    <th>Orden</th>
                                                <tr>
                                                    <td class="TDOption"><input type="radio" name="Scope" value="1" checked></td>
                                                    <td>Todos los terminales</td>
                                                    <td class="TDOption"><input type="radio" name="SortBy" value="1" checked></td>
                                                </tr>
                                                <tr>
                                                    <td class="TDOption"><input type="radio" name="Scope" value="2" ></td>
                                                    <td>Discrep. nivel arch art TOF</td>
                                                    <td class="TDOption"><input type="radio" name="SortBy" value="2"></td>
                                                </tr>
                                                <tr>
                                                    <td class="TDOption"><input type="radio" name="Scope" value="3" ></td>
                                                    <td>Transacc. o datos diario en spool</td>
                                                    <td class="TDOption"><input type="radio" name="SortBy" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td class="TDOption"><input type="radio" name="Scope" value="4" ></td>
                                                    <td>Transacc. en spool</td>
                                                    <td class="TDOption"><input type="radio" name="SortBy" value="4"></td>
                                                </tr>
                                                <tr>
                                                    <td class="TDOption"><input type="radio" name="Scope" value="5" ></td>
                                                    <td>Datos diario spool</td>
                                                    <td class="TDOption"><input type="radio" name="SortBy" value="5"></td>
                                                </tr>
                                                <tr>
                                                    <td class="TDOption"><input type="radio" name="Scope" value="6" ></td>
                                                    <td colspan="2">Terminal &uacute;nico</td>
                                                </tr>
                                                </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="SingleTerminal">Terminal</label>
                                        <input name="SingleTerminal" type="text" size="5" maxlength="4" > </td>
                                    </tr>
                                    <tr>
                                       <td><input name="GENRPT6" type="submit" value="Emitir Reporte">
                                        <input name="LIMPIAR" type="reset" value="Limpiar"></td>
                                    </tr>
                                    </form>
                            </table>
                <?php
						} else { //if(empty($GENRPT6))
								$VentanaConsulta="block";
								$SingleTerminal=@$_POST["SingleTerminal"];
								$SortBy=@$_POST["SortBy"];
								$Scope=@$_POST["Scope"];
								?>
                                        <div id="VentanaConsulta" style="display:<?php echo $VentanaConsulta;?>">
                                            <div id="VentanaConsulta-contenedor">
                            
													<?php include("MsjeCarga.php");?>

                                                    <div>
                                                    <!-- FRAME DE VERIFICACION -->
                                                            <iframe name="FrmVerifica" src="GeneraReporte.php?<?php echo $StringForm?>&Scope=<?php echo $Scope?>&SortBy=<?php echo $SortBy?>&SingleTerminal=<?php echo $SingleTerminal?>" width="0%" height="0" frameborder="0" framespacing="0" marginheight="0" marginwidth="0"></iframe>
                                                    </div>                   
                                            </div>
                                        </div>
                                <?php
						} //if(empty($GENRPT6))
				} else { //if($RPTN2==1 && empty($RPT)
				//DESPLIEGA REPORTE
							if(!empty($RPT)){
								include("PintaReporte.php");
							} //if(!empty($RPT))
				} //if($RPTN2==1 && empty($RPT))
				?>
