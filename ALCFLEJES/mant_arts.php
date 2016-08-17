<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php

	$PAGINA=1185;
	$LIST=@$_GET["LIST"];
	$NONEO=1;
	$ACT=@$_GET["ACT"];
	if ($NEO=="" and $ACT=="") {
		 $LIST=1;
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
          <?= $LAPAGINA?>&nbsp;&nbsp; &nbsp;   
          <?php
		  if($LIST==1)
		  {
          	echo '<input type="button" value="EXPORTAR" onClick="location='."'mant_arts.php?EXP=1'".'">';
		  }
		  ?>
        </h2>
        <?php

if ($LIST==1) {
?>
							<table width="100%" id="Filtro">
          <tr>
            <td>
                <form action="mant_arts.php" method="post" name="frmbuscar" id="frmbuscar">
                	<select name="BSC_EXPORTAR" onChange="document.forms.frmbuscar.submit();">
                    	<option value="0">Para Exportar</option>
                        <option value="si">SI</option>
                        <option value="no">NO</option>
                     </select>
                     <input type="text" name="BSC_NOMBRE" id="BSC_NOMBRE" placeholder="Buscar por nombre">
                     <input type="text" name="BSC_COD_SAP" id="BSC_COD_SAP" placeholder="Buscar por COD SAP">
                     <input name="BUSCAR" type="submit" id="BUSCAR" value="Buscar Art&iacute;culo">
                        <input name="LIMPIAR" type="button" id="LIMPIAR" value="Limpiar" onClick="pagina('mant_arts.php');">
                     
                </form>

              </td>
              </tr>
        </table>
        
        <table style="margin:10px 20px; ">
          <tr>
            <td><?php

				$CONSULTA="SELECT COUNT(*) AS CUENTA FROM AS_ITM";
				$RS = sqlsrv_query($arts_conn, $CONSULTA);
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
					
					$CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY ID_ITM ASC) ROWNUMBER FROM AS_ITM  ".$FLT_ITM.") AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";
					$TIENDA=0;

				}
				$RS = sqlsrv_query($arts_conn, $CONSULTA);
				//oci_execute($RS);
               ?>
              <table id="Listado">
                <tr>
                  <th>ID Art&iacute;culo</th>
                  <th>Nombre Art&iacute;culo</th>
                  <th>C&oacute;digo SAP</th>
                  <th>Para Exportar</th>
                </tr>
                <?php

				while ($row = sqlsrv_fetch_array($RS)){

						$ID_ITM=$row['ID_ITM'];
      					$NM_ITM = $row['NM_ITM'];
						$CD_SAP=$row['CD_SAP'];
						$EXPORT="NO";
						$Q="SELECT ID_PASO_ITM FROM AS_UPD_ITM WHERE ID_PASO_ITMID_ITM=".$ID_ITM."";
						if(sqlsrv_query($arts_conn, $Q)!=false)
						{
							$EXPORT="SI";
						}
						
               ?>
                <tr>
                  <?php if($SESPUBLICA==1) { ?>
                  <td><a href="mant_arts.php?ACT=<?=$ID_ITM?>">
                    <?=$ID_ITM?>
                    </a></td>
                  <?php } else {?>
                  <td><?=$ID_ITM?></td>
                  <?php } ?>
                  <td><?=$NM_ITM?></td>
                  <td><?=$CD_SAP?></td>
                  <td><?=$EXPORT?></td>
                  
                  
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
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('mant_arts.php?LSUP=<?=$FILA_ANT?>&LINF=<?=$ATRAS?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {

																						$ADELANTE=$LSUP+1;
																						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('mant_arts.php?LSUP=<?=$FILA_POS?>&LINF=<?=$ADELANTE?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina
                    <?=$NUMPAG?>
                    de
                    <?=$NUMTPAG?>
                    </span></td>
                </tr>
              </table>
              <?php

		sqlsrv_close($arts_conn);

}
?>
              <?php  if ($ACT!="") { ?>
              <table style="margin:10px 20px; ">
                <tr>
                  <td><table id="forma-registro">
                      <form action="mant_arts_reg.php" method="post" name="forming" id="forming" onSubmit="return validaingreso(this)">
                        <tr>
                          <td><label for="LOGIN_I">ID Art&iacute;culo</label></td>
                          <td><input name="LOGIN_I" type="text" size="14" maxlength="10" disabled></td>
                        </tr>
                        <tr>
                          <td><label for="NOMBRE_USER">Descripci&oacute;n</label></td>
                          <td><input name="NOMBRE_USER" type="text" size="22" maxlength="30"></td>
                        </tr>
                        <tr>
                          <td><label for="CLAVE">Departamento</label></td>
                          <td>
                          	<select  id="TIENDA" name="TIENDA">
                                 <option value="no_sel">Sel. Depto</option>
                                  <?php
                                  $SQL="SELECT * FROM ID_DPT_PS";
                                  $RS = sqlsrv_query($conn, $SQL);
                                  //oci_execute($RS);
                           
                                  while ($row = sqlsrv_fetch_array($RS)) {
									  if($CD_DPT_CER == $CD_DPT_CER)
									  { 	?>
										<option value="<?=$row["CD_DPT_CER"]?>"><?=$row["NM_DPT_PS"]?></option>
											<?php 
											} 
											else
											{ 
											?>
									   <option value="<?=$row["CD_DPT_CER"]?>"><?=$row["NM_DPT_PS"]?></option>
																	
									   <?php  
									   }
                                   }
                                    ?>
                            </select>
                          </td>
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
                            <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_arts.php')"></td>
                        </tr>
                      </form>
                    </table>
                    <script>
                document.forming.ID_TND.focus();
                </script>
                    <?php
		sqlsrv_close($arts_conn);
}?>
// Actualizar 
</td>
                      </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
        </table>
        </table>
        </table>
</body>
