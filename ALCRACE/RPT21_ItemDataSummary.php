

                <?php
				if($RPTN2==21 && empty($RPT)){
						$GENRPT21=@$_POST["GENRPT21"];
						if(empty($GENRPT21)){
				?>
							<script>
                            function validaRpt1(theForm){
									if (theForm.OperTermId.value == ""){
										alert("Es obligatorio indicar ID de Operador o Terminal.");
										theForm.OperTermId.focus();
										return false;
									}
                            } //validaRpt11(theForm)
                            </script>
                            <table id="Registro-RACE">
                                    <form action="repo4690.php?<?php echo $StringForm?>" method="post" name="forming" id="forming" onSubmit="return validaRpt1(this)">
                                    <tr>
                                        <td><label for="ItemCode">C&oacute;digo de Art&iacute;culo</label></td>
                                        <td>
                                        		<label style="float:left; clear:none; display:inline; text-align:left; width:40px" for="StartItemCode">Desde</label>
                                                <input style="text-align:right" name="StartItemCode" type="text" size="20" maxlength="200" value="000000000001">
                                        		<label  style="float:left; clear:left; display:inline; text-align:left; width:40px" for="StopItemCode">Hasta</label>
                                                <input  style="text-align:right" name="StopItemCode" type="text" size="20" maxlength="200" value="999999999999">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="DeptID">ID de Departamento</label></td>
                                        <td>
                                        		<label style="clear:none; float:left; display:inline; text-align:left; width:20px" for="StartDeptID">De</label>
                                                <input style="text-align:right; float:left; display:inline" name="StartDeptID" type="text" size="6" maxlength="10" value="0">
                                        		<label  style="clear:none; float:left; display:inline; text-align:left; width:20px; margin-left:20px" for="StopDeptID">A</label>
                                                <input  style="text-align:right; float:left; display:inline" name="StopDeptID" type="text" size="6" maxlength="10" value="9999">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="ItemDescription">Descripci&oacute;n</label></td>
                                        <td style="text-align:right">
                                                <input style="margin-right:6px" name="ItemDescription" type="text" size="23" maxlength="200" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="ItemTypes">Tipos</label></td>
                                        <td style="text-align:right">
                                                <input style="margin-right:6px" name="ItemTypes" type="text" size="23" maxlength="200" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="UserExit1">Campo Salida Usu 1</label></td>
                                        <td>
                                        		<label style="clear:none; float:left; display:inline; text-align:left; width:20px" for="StartUserExit1">De</label>
                                                <input style="text-align:right; float:left; display:inline" name="StartUserExit1" type="text" size="6" maxlength="10" value="0">
                                        		<label  style="clear:none; float:left; display:inline; text-align:left; width:20px; margin-left:20px" for="StopUserExit1">A</label>
                                                <input  style="text-align:right; float:left; display:inline" name="StopUserExit1" type="text" size="6" maxlength="10" value="32767">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="UserExit2">Campo Salida Usu 2</label></td>
                                        <td>
                                        		<label style="clear:none; float:left; display:inline; text-align:left; width:20px" for="StartUserExit2">De</label>
                                                <input style="text-align:right; float:left; display:inline" name="StartUserExit2" type="text" size="6" maxlength="10" value="0">
                                        		<label  style="clear:none; float:left; display:inline; text-align:left; width:20px; margin-left:20px" for="StopUserExit2">A</label>
                                                <input  style="text-align:right; float:left; display:inline" name="StopUserExit2" type="text" size="6" maxlength="10" value="32767">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                                <table id="Listado-RACE">
                                                <tr>
                                                    <th colspan="2">Clasificaci&oacute;n</th>
                                                <tr>
                                                <tr>
                                                    <td class="TDOption"><input type="radio" name="SortBy" value="1" checked></td>
                                                    <td>Sin Clasificaci&oacute;n</td>
                                                </tr>
                                                <tr>
                                                    <td class="TDOption"><input type="radio" name="SortBy" value="2" ></td>
                                                    <td>C&oacute;digo de Art&iacute;culo</td>
                                                </tr>
                                                <tr>
                                                    <td class="TDOption"><input type="radio" name="SortBy" value="3" ></td>
                                                    <td>Departamento</td>
                                                </tr>
                                                <tr>
                                                    <td class="TDOption"><input type="radio" name="SortBy" value="4" ></td>
                                                    <td>Descripci&oacute;n</td>
                                                </tr>
                                                </table>
                                        </td>
                                    </tr>
                                    <tr>
                                       <td colspan="2"><input name="GENRPT21" type="submit" value="Emitir Reporte">
                                        <input name="LIMPIAR" type="reset" value="Limpiar"></td>
                                    </tr>
                                    </form>
                            </table>
                <?php
						} else { //if(empty($GENRPT21))
								$VentanaConsulta="block";
								$StartItemCode=@$_POST["StartItemCode"];
								$StopItemCode=@$_POST["StopItemCode"];
								$StartDeptID=@$_POST["StartDeptID"];
								$StopDeptID=@$_POST["StopDeptID"];
								$ItemDescription=@$_POST["ItemDescription"];
								$ItemTypes=@$_POST["ItemTypes"];
								$StartUserExit1=@$_POST["StartUserExit1"];
								$StopUserExit1=@$_POST["StopUserExit1"];
								$StartUserExit2=@$_POST["StartUserExit2"];
								$StopUserExit2=@$_POST["StopUserExit2"];
								$SortBy=@$_POST["SortBy"];
								?>

                                        <div id="VentanaConsulta" style="display:<?php echo $VentanaConsulta;?>">
                                            <div id="VentanaConsulta-contenedor">
                            
													<?php include("MsjeCarga.php");?>

                                                    <div>
                                                    <!-- FRAME DE VERIFICACION -->
                                                            <iframe name="FrmVerifica" src="GeneraReporte.php?<?php echo $StringForm?>&StartItemCode=<?php echo $StartItemCode?>&StopItemCode=<?php echo $StopItemCode?>&StartDeptID=<?php echo $StartDeptID?>&StopDeptID=<?php echo $StopDeptID?>&ItemDescription=<?php echo $ItemDescription?>&ItemTypes=<?php echo $ItemTypes?>&StartUserExit1=<?php echo $StartUserExit1?>&StartUserExit2=<?php echo $StartUserExit2?>&StartUserExit2=<?php echo $StartUserExit2?>&StopUserExit2=<?php echo $StopUserExit2?>&SortBy=<?php echo $SortBy?>" width="0%" height="0" frameborder="0" framespacing="0" marginheight="0" marginwidth="0"></iframe>
                                                    </div>                   
                                            </div>
                                        </div>
                                <?php
						} //if(empty($GENRPT21))
				} else { //if($RPTN2==1 && empty($RPT)
				//DESPLIEGA REPORTE
							if(!empty($RPT)){
								include("PintaReporte.php");
							} //if(!empty($RPT))
				} //if($RPTN2==1 && empty($RPT))
				?>
