<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php

	$PAGINA=1182;
	$LIST=@$_GET["LIST"];
	$NEO=@$_GET["NEO"];
	$ACT=@$_GET["ACT"];
	if ($NEO=="" and $ACT=="") {
		 $LIST=1;
	}
	
	$FLT_TIENDA="";
	$BSC_TIENDA=@$_POST["BSC_TIENDA"];
	if (empty($BSC_TIENDA)) {$BSC_TIENDA=@$_GET["BSC_TIENDA"];}
	if (empty($BSC_TIENDA)) {$BSC_TIENDA=0;}
	if ($BSC_TIENDA!=0) {
		$FLT_TIENDA=" WHERE DES_CLAVE=".$BSC_TIENDA;
		}
		
?>
<?php if ($LIST<>1) {?>
<script language="JavaScript">
function validaingreso(theForm){

		if (theForm.LOGIN_I.value == ""){

			alert("COMPLETE EL CAMPO REQUERIDO: Identificador.");
			theForm.LOGIN_I.focus();
			return false;
	}

		if (theForm.NOMBRE_USER.value == ""){

			alert("COMPLETE EL CAMPO REQUERIDO: Nombre Usuario.");
			theForm.NOMBRE_USER.focus();
			return false;
	}
	if (theForm.CLAVE.value == ""){

			alert("COMPLETE EL CAMPO REQUERIDO: Contraseña.");
			theForm.CLAVE.focus();
			return false;
	}
	if (theForm.TIENDA.value == 0){

			alert("COMPLETE EL CAMPO REQUERIDO: Tienda.");
			theForm.CLAVE.focus();
			return false;
	}

} //validaingreso(theForm)

</script>
<?php }?>
<style>
#overlay {
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	text-align: center;
	background-color: #000;
	filter: alpha(opacity=50);
	-moz-opacity: 0.5;
	opacity: 0.5;
}
#overlay span {
	padding: 50px;
	border-radius: 5px;
	color: #000;
	background-color: #fff;
	position: relative;
	top: 50%;
	font-size: 40px;
	padding-top: 80px;
}
</style>
</head>

<body>
<?php include("encabezado.php");?>
<?php include("titulo_menu.php");?>

<table width="100%" height="100%">
<tr>
  <td align="right"  width="200" bgcolor="#FFFFFF"><?php include("menugeneral.php");?></td>
  <td ><?php

if ($MSJE==1) {
$ELMSJ="Registro actualizado";

} 
if ($MSJE == 2) {
	$ELMSJ="Registro no disponible, verifique";
} 
if ($MSJE == 3) {

$ELMSJ="Registro realizado";
}

if ($MSJE == 4) {

$ELMSJ="Registro eliminado";
}
if ($MSJE <> "") {
?>
    <div id="GMessaje" onClick="QuitarGMessage();"><a href="javascript: void(0)" onClick="QuitarGMessage();" style="color:#111111;">
      <?=$ELMSJ?>
      </a></div>
    <?php }?>
    

    <table width="100%">
    <tr>
      <td><h2>
          <?= $LAPAGINA?>
        </h2>
        <?php

if ($LIST==1) {
?>
							<table width="100%" id="Filtro">
          <tr>
            <td>
                <form action="mant_usr_bal.php" method="post" name="frmbuscar" id="frmbuscar">
                                <select name="BSC_TIENDA" onChange="document.forms.frmbuscar.submit();">
                                            <option value="0">Seleccione Tienda</option>
											<?php 
                                            $SQLFILTRO="SELECT * FROM MN_TIENDA WHERE COD_TIENDA<>0 AND IND_ACTIVO = 1 ORDER BY DES_CLAVE ASC";
                                            $RS = sqlsrv_query($maestra, $SQLFILTRO);
                                            //oci_execute($RS);
                                            while ($row = sqlsrv_fetch_array($RS)) {
                                                 $NUM_TIENDA = $row['DES_CLAVE'];
																																																	$DES_TIENDA = $row['DES_TIENDA'];
																																																	$NUM_TIENDA_F="0000".$NUM_TIENDA;
																																																	$NUM_TIENDA_F=substr($NUM_TIENDA_F, -4); 
                                             ?>
                                            <option value="<?php echo $NUM_TIENDA ?>" <?php  if ($NUM_TIENDA==$BSC_TIENDA) { echo "SELECTED";}?>><?=$NUM_TIENDA_F." - ".$DES_TIENDA;?></option>
                                            <?php 
                                            }
                                             ?>
                            </select>
                </form>

              </td>
              </tr>
        </table>
        
        <table style="margin:10px 20px; ">
          <tr>
            <td><?php

				$CONSULTA="SELECT COUNT(*) AS CUENTA FROM T_USERBALANZA";
				$RS = sqlsrv_query($conn, $CONSULTA);
				////oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS))
				{

					$TOTALREG = $row['CUENTA'];
					$NUMTPAG = round($TOTALREG/$CTP,0);
					$RESTO=$TOTALREG%$CTP;
					$CUANTORESTO=round($RESTO/$CTP, 0);
					if($RESTO>0 and $CUANTORESTO==0) 
					{
						$NUMTPAG=$NUMTPAG+1;
					}
					$NUMPAG = round($LSUP/$CTP,0);
					if ($NUMTPAG==0)
					{
						$NUMTPAG=1;
					}
					//$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM T_USERBALANZA ".$FLT_TIENDA." ORDER BY LOGIN_I ASC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;
					
					$CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY LOGIN_I ASC) ROWNUMBER FROM T_USERBALANZA  ".$FLT_TIENDA.") AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";
					
					$TIENDA=0;

				}
				$RS = sqlsrv_query($conn, $CONSULTA);
				//oci_execute($RS);
               ?>
              <table id="Listado">
                <tr>
                  <th>Cuenta Usuario</th>
                  <th>Nombre Usuario</th>
                  <th>Fecha Ultimo Cambio</th>
                  <th>Procesado</th>
                  <th>Tienda</th>
                </tr>
                <?php

				while ($row = sqlsrv_fetch_array($RS)){

						$LOGIN_I=$row['LOGIN_I'];
      $NOMBRE_USER = $row['NOMBRE_USER'];
						$FCH_ULT_CAMBIO=$row['FCH_ULT_CAMBIO'];
						$FCH_ULT_CAMBIO = date_format($FCH_ULT_CAMBIO,"d-m-Y");
      $PROCESADO = $row['PROCESADO'];
						$TIENDA = $row['DES_CLAVE'];
						
						if($PROCESADO=='N')
						{
									$PROCESADO='NO';
						}
						else
						{
									$PROCESADO='SI';
						}
               ?>
                <tr>
                  <?php if($SESPUBLICA==1) { ?>
                  <td><a href="mant_usr_bal.php?ACT=<?=$LOGIN_I?>">
                    <?=$LOGIN_I?>
                    </a></td>
                  <?php } else {?>
                  <td><?=$LOGIN_I?></td>
                  <?php } ?>
                  <td><?=$NOMBRE_USER?></td>
                  <td><?=$FCH_ULT_CAMBIO?></td>
                  <td><?=$PROCESADO?></td>
                  
                  <?php $QUERY = "SELECT DES_TIENDA FROM MN_TIENDA WHERE DES_CLAVE = ".$TIENDA.""; 
																								$SQ = sqlsrv_query($maestra, $QUERY);
																								//oci_execute($SQ);
																								if ($rowsub = sqlsrv_fetch_array($SQ)){
																												$DES_TIENDA = $rowsub['DES_TIENDA'];
																												
																								}
																		
																		?>
                  <td><?=$DES_TIENDA?></td>
                  
                  
                </tr>
                <?php
				}
				?>
                <tr>
                  <td colspan="11" nowrap style="background-color:transparent"><?php
                    if ($LINF>=$CTP+1) {
																					$ATRAS=$LINF-$CTP;
																					$FILA_ANT=$LSUP-$CTP;
                   ?>
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('mant_usr_bal.php?LSUP=<?=$FILA_ANT?>&LINF=<?=$ATRAS?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {

																						$ADELANTE=$LSUP+1;
																						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('mant_usr_bal.php?LSUP=<?=$FILA_POS?>&LINF=<?=$ADELANTE?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina
                    <?=$NUMPAG?>
                    de
                    <?=$NUMTPAG?>
                    </span></td>
                </tr>
              </table>
              <?php

		sqlsrv_close($conn);

}
?>
              <?php  if ($NEO==1) { ?>
              <table style="margin:10px 20px; ">
                <tr>
                  <td><table id="forma-registro">
                      <form action="mant_usr_bal_reg.php" method="post" name="forming" id="forming" onSubmit="return validaingreso(this)">
                        <tr>
                          <td><label for="LOGIN_I">Cuenta Usuario</label></td>
                          <td><input name="LOGIN_I" type="text" size="14" maxlength="10"></td>
                        </tr>
                        <tr>
                          <td><label for="NOMBRE_USER">Nombre Usuario</label></td>
                          <td><input name="NOMBRE_USER" type="text" size="22" maxlength="30"></td>
                        </tr>
                        <tr>
                          <td><label for="CLAVE">Password Usuario</label></td>
                          <td><input name="CLAVE" type="password" size="17" maxlength="15"></td>
                        </tr>
                        <tr>
                          <td><label for="TIENDA">Tienda</label></td>
                          <td>
                          <select  id="TIENDA" name="TIENDA">
                        							<option value="0">Sel. Local</option>
																																<?php
   
                                $SQL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA<>0 AND IND_ACTIVO = 1 ORDER BY DES_CLAVE ASC";
                                $RS = sqlsrv_query($maestra, $SQL);
                                //oci_execute($RS);
                         
                                while ($row = sqlsrv_fetch_array($RS)) {
                         
                                 $NUM_TIENDA = $row['DES_CLAVE'];
                                 $DES_TIENDA = $row['DES_TIENDA'];
                                 $NUM_TIENDA_F="0000".$NUM_TIENDA;
                                 $NUM_TIENDA_F=substr($NUM_TIENDA_F, -4); 
                                 ?>
                         
                                 <option value="<?php echo $NUM_TIENDA?>"><?=$NUM_TIENDA_F." - ".$DES_TIENDA;?></option>
                         
                                 <?php 
                         
                                				}

                        										?>
                    						</select>
                          </td>
                        
                        </tr>
                        <tr>
                          <td></td>
                          <td><input name="INGRESAR" type="submit" value="Registrar">
                            <input name="LIMPIAR" type="reset" value="Limpiar">
                            <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_usr_bal.php')"></td>
                        </tr>
                      </form>
                    </table>
                    <script>
                document.forming.ID_TND.focus();
                </script>
                    <?php
		sqlsrv_close($conn);
}
// Actualizar 
if ($ACT<>"") { 
?>
                    <table style="margin:10px 20px; ">
                      <tr>
                        <td><?php  
						$CONSULTA="SELECT * FROM T_USERBALANZA WHERE LOGIN_I='".$ACT."'";
						$RS = sqlsrv_query($conn, $CONSULTA);
						//oci_execute($RS);
						if ($row = sqlsrv_fetch_array($RS)) {
							
							$LOGIN_I=$row['LOGIN_I'];
							$NOMBRE_USER = $row['NOMBRE_USER'];
							$CLAVE = $row['CLAVE'];
							$TIENDA = $row['DES_CLAVE'];
							
						}
					?>
                    <p class="speech">Usuario <?=$NOMBRE_USER?></p>
                          <h3>Actualizar Usuario Balanza</h3>
                          <table id="forma-registro">
                            <form action="mant_usr_bal_reg.php" method="post" name="formact" onSubmit="return validaingreso(this)" >
                              <tr>
                                  <td><label for="LOGIN_I">Cuenta Usuario</label></td>
                                  <td><input name="LOGIN_I_ANTERIOR" type="hidden" value="<?=$LOGIN_I?>"><input name="LOGIN_I" type="text" size="14" maxlength="10" value="<?=$LOGIN_I?>"></td>
                                </tr>
                                <tr>
                                  <td><label for="NOMBRE_USER">Nombre Usuario</label></td>
                                  <td><input name="NOMBRE_USER" type="text" size="22" maxlength="30" value="<?=$NOMBRE_USER?>"></td>
                                </tr>
                                <tr>
                                  <td><label for="CLAVE">Password Usuario</label></td>
                                  <td><input name="CLAVE" type="password" size="17" maxlength="15" value="<?=$CLAVE?>"></td>
                                </tr>
                                 		<td><label for="TIENDA">Tienda</label></td>
                                     <td>
                                    	<select  id="TIENDA" name="TIENDA">
                                         <option value="0">Sel. Local</option>
                                          <?php
             
                                          $SQL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA<>0 AND IND_ACTIVO = 1 ORDER BY DES_CLAVE ASC";
                                          $RS = sqlsrv_query($maestra, $SQL);
                                          //oci_execute($RS);
                                   
                                          while ($row = sqlsrv_fetch_array($RS)) {
                                   
                                           $NUM_TIENDA = $row['DES_CLAVE'];
                                           $DES_TIENDA = $row['DES_TIENDA'];
                                           $NUM_TIENDA_F="0000".$NUM_TIENDA;
                                           $NUM_TIENDA_F=substr($NUM_TIENDA_F, -4); 
                                           ?>
                                   									<?php if($TIENDA == $NUM_TIENDA){ 	?>
                                            <option value="<?php echo $NUM_TIENDA?>" selected><?=$NUM_TIENDA_F." - ".$DES_TIENDA;?></option>
                                            <?php } else{ ?>
                                           <option value="<?php echo $NUM_TIENDA?>"><?=$NUM_TIENDA_F." - ".$DES_TIENDA;?></option>
                                   										
                                           <?php  
                                  													 					}
                                            }
          
                                            ?>
                                    </select>
                                    </td>
                              <tr>
                                <td>
                                <td>
                                 		<input name="ACTUALIZAR" type="submit" value="Actualizar">
                                  <input name="ELIMINAR" type="button" value="Eliminar" onClick="javascript:pagina('mant_usr_bal_reg.php?ELM=1&LOGIN_I=<?=$LOGIN_I ?>')">
                                  <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_usr_bal.php')"></td>
                              </tr>
                            </form>
                          </table>
                          <?php
		sqlsrv_close($conn);
}
?></td>
                      </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
        </table>
        </table>
        </table>
</body>
