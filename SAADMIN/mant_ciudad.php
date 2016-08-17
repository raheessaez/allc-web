<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1108;
	$NOMENU=1;	
	
	$IDR=@$_GET["IDR"];
	if (!empty($IDR)) {
		$FLT_CITY=" AND COD_REGION=".$IDR;
		}
?>
</head>
<body>
<?php include("encabezado.php");?>
<?php include("titulo_menu.php");?>
<table width="100%" height="100%">
<tr>
<td align="right"  width="200" bgcolor="#FFFFFF"><?php include("menugeneral.php");?></td> 
<td >
<?php
if ($MSJE==1) {$ELMSJ="Registro actualizado";} 
if ($MSJE==2) {$ELMSJ="Nombre no disponible, verifique";}
if ($MSJE==3) {$ELMSJ="Registro realizado";}
if ($MSJE==4) {$ELMSJ="Registro eliminado";}
if ($MSJE <> "") {
?>
<div id="GMessaje" onClick="QuitarGMessage();"><a href="#" onClick="QuitarGMessage();" style="color:#111111;"><?php echo $ELMSJ?></a></div>
<?php }?>
        
        
        <table width="100%">
        <tr><td>
        		<?php if($ACTSU==1){?>
                                <table width="100%" id="Filtro">
                                <tr>
                                <td>
									<script>
                                        function validaPais(theForm){
                                                if (theForm.MOD_PAIS.value == 0){
                                                    alert("POR FAVOR... SELECCIONE UN PAIS.");
                                                    theForm.MOD_PAIS.focus();
                                                    return false;
                                                } else {
                                                    var aceptaEntrar = window.confirm("Esta accion configura la Suite al Pais seleccionado...  \xbfest\xe1 seguro?\n El Sistema necesita reiniciarse");
                                                    if (aceptaEntrar) 
                                                    {
                                                        document.forms.theForm.submit();
                                                    }  else  {
                                                        return false;
                                                    }
                                                }
                        
                                        } //validaPais(theForm)
                                    </script>
                                <form action="mant_ciudad_reg.php" method="post" name="forming" id="forming" onSubmit="return validaPais(this)">
                                				<label>Cambiar la Configuraci&oacute;n Regional, Pa&iacute;s: </label>
                                                <select name="MOD_PAIS">
                                                            <?php 
															$SQL="SELECT * FROM PM_PAIS ORDER BY DES_PAIS ASC";
															
                                                            //$RS = sqlsrv_query($conn, $SQL);
															////oci_execute($RS);
                                                            $RS = sqlsrv_query($conn,$SQL);
															
                                                            while ($row = sqlsrv_fetch_array($RS)) {

																$COD_PAIS = $row['COD_PAIS'];
																$DES_PAIS = $row['DES_PAIS'];
																$EST_PAIS = $row['ESTADO'];

                                                             ?>
                                                            <option value="<?=$COD_PAIS ?>" <?php if($EST_PAIS==0){?>disabled="disabled"<?php } if($COD_PAIS==$GLBCODPAIS){echo "selected";} ?>><?=$DES_PAIS ?></option>
                                                            <?php 
                                                            }
                                                             ?>
                                            </select>
                                            <input type="submit" name="CAMBIAR" value="Cambiar Pa&iacute;s">
                                </form>
                                </td>
                                </tr>
                                </table>
				<?php }?>
                <h2><?=$GLBNOMPAIS?></h2>
                <table style="margin:10px 20px; ">
                <tr>
                <td>
                <table id="Listado">
                <tr>
                     <th>Moneda</th>
                     <th>Centavos</th>
                     <th>Id. Personas</th>
                     <th>Id. Empresas</th>
                 </tr>
                     <td><h5><?=$MONEDA?></h5></td>
                     <?php if($CENTS==0){$CONCENTS="No";} else {$CONCENTS="Si";}?>
                     <td><h5><?=$CONCENTS?></h5> </td>
                     <td><h5><?=$GLBCEDPERS?></h5> </td>
                     <td><h5><?=$GLBCEDEMPS?></h5> </td>
                 <tr>
                 </tr>
                 <tr><td colspan="4"></td></tr>
                </table>


                <?php
				if($GLBDPTREG==1){
				$S="SELECT * FROM PM_REGION WHERE COD_PAIS=".$GLBCODPAIS." ORDER BY COD_REGION ASC";

				//$RS = sqlsrv_query($conn, $S);
				////oci_execute($RS);
                $RS = sqlsrv_query($conn,$S);
				
                $cuenta=0;
               ?>
                <table id="Listado">
                <tr>
                    <th colspan="6"><?=$GLBDESCDPTREG."s "?></th>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){
					$columna=$cuenta%6;
					if($columna==0){ echo "<tr>"; $cuenta=0;}
					$COD_REGION = $row['COD_REGION'];
					$DES_REGION = $row['DES_REGION'];
					$ABR_REGION = $row['ABR_REGION'];
					if(!empty($ABR_REGION)){$DES_REGION=$DES_REGION." (".$ABR_REGION.")";}
               ?>
                     <td><a href="mant_ciudad.php?IDR=<?=$COD_REGION?>"><?=$DES_REGION?></a></td>
                <?php
				$cuenta=$cuenta+1;
				}
				?>
                <tr><td colspan="6"></td></tr>
                </table>
                <?php
				} //if($GLBDPTREG==1)
				?>
                
                
                <?php
				$S="SELECT * FROM PM_CIUDAD WHERE COD_PAIS=".$GLBCODPAIS." ".$FLT_CITY." ORDER BY COD_REGION ASC, DES_CIUDAD ASC";
				
                //$RS = sqlsrv_query($conn, $S);
				////oci_execute($RS);
                $RS = sqlsrv_query($conn,$S);
				
                $cuenta=0;
               ?>
                <table id="Listado">
                <tr>
                    <th colspan="6">Ciudades</th>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){
					$columna=$cuenta%6;
					if($columna==0){ echo "<tr>"; $cuenta=0;}
					$DES_CIUDAD = $row['DES_CIUDAD'];
					$COD_REGION = $row['COD_REGION'];
					if($GLBDPTREG==1){
							$SQL="SELECT * FROM PM_REGION WHERE COD_REGION=".$COD_REGION;
							
                            //$RS1 = sqlsrv_query($conn, $SQL);
							////oci_execute($RS1);
                            $RS1 = sqlsrv_query($conn,$SQL); 
							
                            if ($row1 = sqlsrv_fetch_array($RS1)){
									$DES_REGION = $row1['DES_REGION'];
									$ABR_REGION = $row1['ABR_REGION'];
									if(!empty($ABR_REGION)){$DES_REGION=" (".$ABR_REGION.")";} else {$DES_REGION="<br>(".$DES_REGION.")";}
							}
					}
               ?>
                     <td><?=$DES_CIUDAD.$DES_REGION?></td>
                <?php
				$cuenta=$cuenta+1;
				}
				?>
                <tr><td colspan="6"></td></tr>
                </table>

        </td>
        </tr>
        </table>
        </td>
        </tr>
        </table>
</td>
</tr>
</table>
</body>
</html>
<?php 
//sqlsrv_close($conn);
sqlsrv_close( $conn );
?>
