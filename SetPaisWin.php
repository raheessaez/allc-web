
<script>
	$(document).ready(function() {
			var posicion = $("#VentanaSPS").offset();
	});	
</script>
<?php include("hostsaadmin.php");?>
<div id="VentanaSPS" style="display:none">
    <div id="VentanaSPS-contenedor">
            <span style="position:absolute; top:0; right:20px;">
            <img src="images/ICO_Close.png" border="0" onClick="CerrarSPS();" title="Cerrar ventana">
            </span>
            <h3>Seleccione el Pa&iacute;s para ARMS</h3>
            <form action="SetIndexReg.php" method="post" name="forming" id="forming" onSubmit="return validaPais(this)">
            		<?php
							//$conn = oci_connect($bdu, $bdp, $db);
							//$SQL="ALTER SESSION SET nls_date_format='DD-MM-YYYY";
							//$RSV = sqlsrv_query($conn, $SQL);
							////oci_execute($RSV);
                            
                            $serverName = $HOSTSAADMIN;
                            $connectionInfo = array( "Database"=>$bdu, "UID"=>$INSTANCIA, "PWD"=>$PASSWORD);
                            $conecta = sqlsrv_connect( $serverName, $connectionInfo);

                            //$SQL = "ALTER SESSION SET nls_date_format= 'DD-MM-YYYY'";
                           
                           // $RSV = sqlsrv_query($conecta,$SQL);
					?>
                        <select name="PAISSEL">
                                    <option value="0">Seleccionar Pa&iacute;s</option>
                                    <?php 
                                    $SQL="SELECT * FROM PM_PAIS ORDER BY DES_PAIS ASC";
                                    //$RS = sqlsrv_query($conn, $SQL);
                                    ////oci_execute($RS);
                                    $RS = sqlsrv_query($conecta,$SQL);
                                    while ($row = sqlsrv_fetch_array($RS)) {
                                        $COD_PAIS = $row['COD_PAIS'];
                                        $DES_PAIS = $row['DES_PAIS'];
                                        $EST_PAIS = $row['ESTADO'];
                                     ?>
                                    <option value="<?=$COD_PAIS ?>" <?php if($EST_PAIS==0){?>disabled="disabled"<?php } ?>><?=$DES_PAIS ?></option>
                                    <?php 
                                    }
                                     ?>
                        </select>
                        <input type="hidden" name="db" value="<?=$db?>" />
                        <input type="hidden" name="bdu" value="<?=$bdu?>" />
                        <input type="hidden" name="bdp" value="<?=$bdp?>" />
                        <input type="submit" name="ASOCIAR" value="Registrar" />
          </form>
    </div>
</div>

            <script>
				function validaPais(theForm){
						if (theForm.PAISSEL.value == 0){
							alert("POR FAVOR... SELECCIONE UN PAIS.");
							theForm.PAISSEL.focus();
							return false;
						} else {
							var aceptaEntrar = window.confirm("Esta accion configura la Suite al Pais seleccionado...  \xbfest\xe1 seguro?");
							if (aceptaEntrar) 
							{
								document.forms.theForm.submit();
							}  else  {
								return false;
							}
						}

				} //validaPais(theForm)
			</script>
