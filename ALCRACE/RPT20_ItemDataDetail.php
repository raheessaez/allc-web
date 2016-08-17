

                <?php
				if($RPTN2==20 && empty($RPT)){
						$GENRPT20=@$_POST["GENRPT20"];
						if(empty($GENRPT20)){
				?>
							<script>
                            function validaRpt1(theForm){
									if (theForm.ItemCode.value == ""){
										alert("Es obligatorio indicar un Codigo de Articulo.");
										theForm.ItemCode.focus();
										return false;
									}
                            } //validaRpt11(theForm)
                            </script>
                            <table id="Registro-RACE">
                                    <form action="repo4690.php?<?php echo $StringForm?>" method="post" name="forming" id="forming" onSubmit="return validaRpt1(this)">
                                    <tr>
                                        <td><label for="ItemCode">C&oacute;digo de Art&iacute;culo</label>
                                        <input name="ItemCode" type="text" size="30" maxlength="200" > </td>
                                    </tr>
                                    <tr>
                                       <td><input name="GENRPT20" type="submit" value="Emitir Reporte">
                                        <input name="LIMPIAR" type="reset" value="Limpiar"></td>
                                    </tr>
                                    </form>
                            </table>
                <?php
						} else { //if(empty($GENRPT20))
								$VentanaConsulta="block";
								$ItemCode=@$_POST["ItemCode"];
								?>
                                        <div id="VentanaConsulta" style="display:<?php echo $VentanaConsulta;?>">
                                            <div id="VentanaConsulta-contenedor">
                            
													<?php include("MsjeCarga.php");?>

                                                    <div>
                                                    <!-- FRAME DE VERIFICACION -->
                                                            <iframe name="FrmVerifica" src="GeneraReporte.php?<?php echo $StringForm?>&ItemCode=<?php echo $ItemCode?>" width="0%" height="0" frameborder="0" framespacing="0" marginheight="0" marginwidth="0"></iframe>
                                                    </div>                   
                                            </div>
                                        </div>
                                <?php
						} //if(empty($GENRPT20))
				} else { //if($RPTN2==1 && empty($RPT)
				//DESPLIEGA REPORTE
							if(!empty($RPT)){
								include("PintaReporte.php");
							} //if(!empty($RPT))
				} //if($RPTN2==1 && empty($RPT))
				?>
