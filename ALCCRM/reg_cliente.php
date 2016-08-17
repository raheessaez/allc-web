
<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1142;


	$LIST=@$_GET["LIST"];
	$NEO=@$_GET["NEO"];
	$ACT=@$_GET["ACT"];
	
	if ($NEO=="" and $ACT=="") {
		 $LIST=1;
	}
	
	$ACT_ENC=@$_GET["ACT_ENC"];
	$ACT_CRM=@$_GET["ACT_CRM"];
	$ACT_TRJ=@$_GET["ACT_TRJ"];
	if(empty($ACT_CRM) and empty($ACT_TRJ)){ $ACT_ENC=1;}


	$FILTRO_CIUDAD="";
	$FCIUDAD=@$_POST["FCIUDAD"];
	if (empty($FCIUDAD)) { $FCIUDAD=@$_GET["FCIUDAD"] ;}
	if (empty($FCIUDAD)) { $FCIUDAD=0 ;}
	if ($FCIUDAD!=0) {
		$FILTRO_CIUDAD=" AND COD_CIUDAD=".$FCIUDAD ;
	}
	
	$FILTRO_ESTADO="";
	$FESTADO=@$_POST["FESTADO"];
	if (empty($FESTADO)) { $FESTADO=@$_GET["FESTADO"] ;}
	if (empty($FESTADO)) { $FESTADO=0 ;}
	if ($FESTADO!=0) {
		$FILTRO_ESTADO=" AND (COD_CLIENTE IN(SELECT COD_CLIENTE FROM OP_DATACRM WHERE COD_ESTADO=".$FESTADO.") OR COD_CLIENTE NOT IN(SELECT COD_CLIENTE FROM OP_DATACRM))" ;
	}

	$FILTRO_NOMB="";
	$BOPERA=trim(strtoupper(@$_POST["BOPERA"]));
	if (empty($BOPERA)) { $BOPERA=trim(strtoupper(@$_GET["BOPERA"])) ;}
	$BOPCION=@$_POST["BOPCION"];
	if (empty($BOPCION)) { $BOPCION=@$_GET["BOPCION"];}
	if (empty($BOPCION)) { $BOPCION=2;}
	if ($BOPCION==1) {
			if ($BOPERA<>"") {$FILTRO_NOMB=" AND (UPPER(LTRIM(NOMBRE)) Like '%".strtoupper($BOPERA)."%' OR UPPER(LTRIM(APELLIDO_P)) Like '%".strtoupper($BOPERA)."%' OR UPPER(LTRIM(APELLIDO_M)) Like '%".strtoupper($BOPERA)."%')"; }
	} 
	if ($BOPCION==2) {
			if ($BOPERA<>"") {$FILTRO_NOMB=" AND IDENTIFICACION Like '%".strtoupper($BOPERA)."%' "; }
	} 
	
?>

<?php if ($LIST<>1) {?>
<script language="JavaScript">
function validaingreso(theForm){
	
		if (theForm.COD_TIPOCLIENTE.value == 0){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.COD_TIPOCLIENTE.focus();
			return false;
		}
		if (theForm.COD_TIPOID.value == 0){
				alert("COMPLETE EL CAMPO REQUERIDO.");
				theForm.COD_TIPOID.focus();
				return false;
		} else {
				var TipoIDForm = theForm.COD_TIPOID.value;
				var Posic=TipoIDForm.indexOf("|");
				var TipoPersonaForm=TipoIDForm.substr(Posic+1);
		}
		if (theForm.IDENTIFICACION.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.IDENTIFICACION.focus();
			return false;
		}

		
		if(TipoPersonaForm==0){
						if (theForm.NOMBRE_PN.value == ""){
							alert("COMPLETE EL CAMPO REQUERIDO.");
							theForm.NOMBRE_PN.focus();
							return false;
						}
						if (theForm.APELLIDO_P.value == ""){
							alert("COMPLETE EL CAMPO REQUERIDO.");
							theForm.APELLIDO_P.focus();
							return false;
						}
						if (theForm.APELLIDO_M.value == ""){
							alert("COMPLETE EL CAMPO REQUERIDO.");
							theForm.APELLIDO_M.focus();
							return false;
						}
						if (theForm.GENERO.value == ""){
							alert("COMPLETE EL CAMPO REQUERIDO.");
							theForm.GENERO.focus();
							return false;
						}
						if (theForm.DIA_NAC.value == ""){
							alert("COMPLETE EL CAMPO REQUERIDO.");
							theForm.DIA_NAC.focus();
							return false;
						}
						
						if (theForm.ANO_NAC.value == ""){
							alert("COMPLETE EL CAMPO REQUERIDO.");
							theForm.ANO_NAC.focus();
							return false;
						}
						
						if (!ValidarFecha(theForm.DIA_NAC.value+"-"+theForm.MES_NAC.value+"-"+theForm.ANO_NAC.value)){
							alert("FECHA NO VALIDA.");
							theForm.DIA_NAC.focus();
							return false;
							}
					
						if (!calcular_edad(theForm.DIA_NAC.value, theForm.MES_NAC.value, theForm.ANO_NAC.value)){
							alert("CONFIRME LA FECHA DE NACIMIENTO, LA EDAD DEBE SER ENTRE LOS 18 Y LOS 99 A\xd1OS.");
							theForm.ANO_NAC.focus();
							return false;
							}
						
		} else {
						if (theForm.NOMBRE_PJ.value == ""){
							alert("COMPLETE EL CAMPO REQUERIDO.");
							theForm.NOMBRE_PJ.focus();
							return false;
						}
		}
		if (theForm.COD_CIUDAD.value == 1){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.COD_CIUDAD.focus();
			return false;
		}
		if (theForm.DIRECCION.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.DIRECCION.focus();
			return false;
		}

		if (theForm.INGRESAR.value != ""){

			var aceptaEntrar = window.confirm("Se ejecutar\xe1 el registro, \xbfest\xe1 seguro?");
				if (aceptaEntrar) 
				{
					document.forms.theForm.submit();
				}  else  
				{
					return false;
				}
	}

} //validaingreso(theForm)


function validaTarjeta(theForm){
	
		if (theForm.COD_TIPO_TARJETA.value == 0){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.COD_TIPO_TARJETA.focus();
			return false;
		}
		if (theForm.NUM_TARJETA.value == ""){
				alert("COMPLETE EL CAMPO REQUERIDO.");
				theForm.NUM_TARJETA.focus();
				return false;
		} 

		if (theForm.DIA_ENT.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.DIA_ENT.focus();
			return false;
		}
		
		if (theForm.ANO_ENT.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.ANO_ENT.focus();
			return false;
		}
		
		if (!ValidarFecha(theForm.DIA_ENT.value+"-"+theForm.MES_ENT.value+"-"+theForm.ANO_ENT.value)){
			alert("FECHA NO VALIDA.");
			theForm.DIA_ENT.focus();
			return false;
			}
	
		if (theForm.REG_TARJETA.value != ""){

			var aceptaEntrar = window.confirm("Se ejecutar\xe1 el registro, \xbfest\xe1 seguro?");
				if (aceptaEntrar) 
				{
					document.forms.theForm.submit();
				}  else  
				{
					return false;
				}
	}

} //validaTarjeta(theForm)



function validaActTarjeta(theForm){
	
		if (theForm.COD_TIPO_TARJETA.value == 0){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.COD_TIPO_TARJETA.focus();
			return false;
		}
		if (theForm.NUM_TARJETA.value == ""){
				alert("COMPLETE EL CAMPO REQUERIDO.");
				theForm.NUM_TARJETA.focus();
				return false;
		} 

		if (theForm.DIA_ENT.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.DIA_ENT.focus();
			return false;
		}
		
		if (theForm.ANO_ENT.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.ANO_ENT.focus();
			return false;
		}
		
		if (!ValidarFecha(theForm.DIA_ENT.value+"-"+theForm.MES_ENT.value+"-"+theForm.ANO_ENT.value)){
			alert("FECHA NO VALIDA.");
			theForm.DIA_ENT.focus();
			return false;
			}
	
		if (theForm.COD_EST_TARJETA.value == 0){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.COD_EST_TARJETA.focus();
			return false;
		}
		if (theForm.REG_TARJETA.value != ""){

			var aceptaEntrar = window.confirm("Se ejecutar\xe1 el registro, \xbfest\xe1 seguro?");
				if (aceptaEntrar) 
				{
					document.forms.theForm.submit();
				}  else  
				{
					return false;
				}
	}

} //validaActTarjeta(theForm)


</script>

<?php }?>
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
         <h2><?php echo $LAPAGINA?></h2>
        <?php if($LIST==1) {?>
        <table width="100%" id="Filtro">
          <tr>
            <td>
                <form action="reg_cliente.php" method="post" name="frmbuscar" id="frmbuscar">

                         <?php if($GLBDPTREG==1){?>
                                    <select name="COD_REGION"  onChange="CargaCiudad(this.value, this.form.name, 'FCIUDAD', <?=$GLBCODPAIS?>)">
                                                <option value="0"><?=$GLBDESCDPTREG?></option>
                                                <?php 
                                                $SQL="SELECT * FROM PM_REGION WHERE COD_PAIS=".$GLBCODPAIS." ORDER BY DES_REGION ASC";
                                                
                                                //$RS = sqlsrv_query($maestra, $SQL);
                                                ////oci_execute($RS);
                                                $RS = sqlsrv_query($maestra,$SQL);
                                                
                                                while ($row = sqlsrv_fetch_array($RS)) {
                                                    $COD_REGION = $row['COD_REGION'];
                                                    $DES_REGION = $row['DES_REGION'];
                                                 ?>
                                                <option value="<?php echo $COD_REGION;?>"><?php echo $DES_REGION ?></option>
                                                <?php 
                                                }
                                                 ?>
                                </select>
                         <?php } //$GLBDPTREG?>
                        <select name="FCIUDAD" onChange="document.forms.frmbuscar.submit();">
                                    <option value="0">Ciudad</option>
                                    <?php if($GLBDPTREG==0){?>
                                    <?php 
									$SQLFILTRO="SELECT * FROM PM_CIUDAD WHERE COD_PAIS=".$GLBCODPAIS." ORDER BY DES_CIUDAD ASC";
									
									//$RS = sqlsrv_query($maestra, $SQLFILTRO);
									////oci_execute($RS);
									$RS = sqlsrv_query($maestra,$SQLFILTRO);
									
									while ($row = sqlsrv_fetch_array($RS)) {
										$FLTCOD_CIUDAD = $row['COD_CIUDAD'];
										$FLTDES_CIUDAD = $row['DES_CIUDAD'];
                                     ?>
                                    <option value="<?php echo $FLTCOD_CIUDAD ?>" <?php  if ($FLTCOD_CIUDAD==$FCIUDAD) { echo "SELECTED";}?>><?php echo $FLTDES_CIUDAD ?></option>
                                    <?php 
									}
                                     ?>
                                     <?php }?>
                                    </select>

                        <select  name="FESTADO" onChange="document.forms.frmbuscar.submit();">
                                    <option value="0">Estado</option>
                                    <?php 
									$SQLFILTRO="SELECT * FROM MN_ESTADO WHERE COD_ESTADO IN(SELECT COD_ESTADO FROM OP_DATACRM) ORDER BY DES_ESTADO ASC";
									
									//$RS = sqlsrv_query($conn, $SQLFILTRO);
									////oci_execute($RS);
									$RS = sqlsrv_query($conn,$SQLFILTRO);
									
									while ($row = sqlsrv_fetch_array($RS)) {
										$FLTCOD_ESTADO = $row['COD_ESTADO'];
										$FLTDES_ESTADO = $row['DES_ESTADO'];
                                     ?>
                                    <option value="<?php echo $FLTCOD_ESTADO ?>" <?php  if ($FLTCOD_ESTADO==$FESTADO) { echo "SELECTED";}?>><?php echo $FLTDES_ESTADO ?></option>
                                    <?php 
									}
                                     ?>
                                    </select>

                           <input name="BOPERA" type="text" id="BOPERA" size="12" value="<?php echo $BOPERA ?>">
                           <input type="radio" name="BOPCION" value="2" <?php if($BOPCION==2) {?> checked <?php }?>>
                           <label for="BOPCION2"><?=$GLBCEDPERS."/".$GLBCEDEMPS?></label>
                           <input type="radio" name="BOPCION" value="1"  <?php if($BOPCION==1) {?> checked <?php }?>>
                           <label for="BOPCION1">Nombre</label>
                           <input name="BUSCAR" type="submit" id="BUSCAR" value="Buscar">
                           <input name="LIMPIAR" type="button" id="LIMPIAR" value="Limpiar" onClick="javascript:pagina('reg_cliente.php')">

                </form>
              </td>
              </tr>
              </table>
			<?php } ?>        
        
                <table style="margin:10px 20px; ">
                <tr>
                <td>                
                
<?php
if ($LIST==1) {
?>
              
              
                
                
                <?php
				
				$CONSULTA="SELECT COUNT(COD_CLIENTE) AS CUENTA FROM OP_CLIENTE WHERE COD_CLIENTE<>0 ".$FILTRO_CIUDAD.$FILTRO_ESTADO.$FILTRO_NOMB ;
				
				//$RS = sqlsrv_query($conn, $CONSULTA);
				////oci_execute($RS);
				$RS = sqlsrv_query($conn,$CONSULTA); 
				
				if ($row = sqlsrv_fetch_array($RS)) {
					$TOTALREG = $row['CUENTA'];
					$NUMTPAG = round($TOTALREG/$CTP,0);
					$RESTO=$TOTALREG%$CTP;
					$CUANTORESTO=round($RESTO/$CTP, 0);
					if($RESTO>0 and $CUANTORESTO==0) {$NUMTPAG=$NUMTPAG+1;}
					$NUMPAG = round($LSUP/$CTP,0);
					if ($NUMTPAG==0) {
						$NUMTPAG=1;
						}
				}

				//$SQLCLTE="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM OP_CLIENTE WHERE COD_CLIENTE<>0 ".$FILTRO_CIUDAD.$FILTRO_ESTADO.$FILTRO_NOMB." ORDER BY NOMBRE ASC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;

				$SQLCLTE= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY NOMBRE ASC) ROWNUMBER FROM OP_CLIENTE WHERE COD_CLIENTE <> 0  ".$FILTRO_CIUDAD.$FILTRO_ESTADO.$FILTRO_NOMB.") AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";
				

				//$RS = sqlsrv_query($conn, $SQLCLTE);
				////oci_execute($RS);
				$RS = sqlsrv_query($conn,$SQLCLTE);
               
               ?>
                <table id="Listado">
                <tr>
                    <th>Nombre Cliente<br>Num. Identificaci&oacute;n</th>
                    <th>Puntos</th>
                    <th>Direcci&oacute;n</th>
                    <th>Contacto</th>
                    <th>Tipo de Cliente<br>Estado</th>
                    <th>Registrado por</th>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){
                        $COD_CLIENTE = $row['COD_CLIENTE'];
                        $COD_TIPOCLIENTE = $row['COD_TIPOCLIENTE'];
						$S2="SELECT DES_TIPOCLIENTE FROM PM_TIPOCLIENTE WHERE COD_TIPOCLIENTE=".$COD_TIPOCLIENTE;
						
						//$RS2 = sqlsrv_query($conn, $S2);
						////oci_execute($RS2);
						$RS2 = sqlsrv_query($conn,$S2);

						if ($row2 = sqlsrv_fetch_array($RS2)) {
							$DES_TIPOCLIENTE = $row2['DES_TIPOCLIENTE'];
						}	
                        $COD_TIPOID = $row['COD_TIPOID'];
						$S2="SELECT * FROM PM_TIPOID WHERE COD_TIPOID=".$COD_TIPOID;
						
						//$RS2 = sqlsrv_query($conn, $S2);
						////oci_execute($RS2);
						$RS2 = sqlsrv_query($conn,$S2);
						
						if ($row2 = sqlsrv_fetch_array($RS2)) {
							$DES_TIPOID = $row2['DES_TIPOID'];
							$TIPO_PERSONA = $row2['TIPO_PERSONA'];
						}
						
                        $IDENTIFICACION = $row['IDENTIFICACION'];

                        $NOMBRE = $row['NOMBRE'];
						if($TIPO_PERSONA==0){
								$APELLIDO_P = $row['APELLIDO_P'];
								$APELLIDO_M = $row['APELLIDO_M'];
								$NOMBRE=$NOMBRE." ".$APELLIDO_P." ".$APELLIDO_M;
								$LAIDENTIFICACION=$DES_TIPOID.": ".$IDENTIFICACION;
						} else {
								$LARGOID = strlen($IDENTIFICACION);
								$IDENTIFICA = substr($IDENTIFICACION, 0, $LARGOID-1);
								$DIGITOV = substr($IDENTIFICACION, -1);
								$LAIDENTIFICACION=$DES_TIPOID.": ".$IDENTIFICA.$DIGITOV;
						}
						
                        $DIRECCION = $row['DIRECCION'];
                        $COD_CIUDAD = $row['COD_CIUDAD'];
						$S2="SELECT DES_CIUDAD FROM PM_CIUDAD WHERE COD_CIUDAD=".$COD_CIUDAD;
						
						//$RS2 = sqlsrv_query($maestra, $S2);
						////oci_execute($RS2);

						$RS2 = sqlsrv_query($maestra,$S2);

						if ($row2 = sqlsrv_fetch_array($RS2)) {
							$DES_CIUDAD = $row2['DES_CIUDAD'];
						}	
                        $COD_REGION = $row['COD_REGION'];
						$S2="SELECT DES_REGION FROM PM_REGION WHERE COD_REGION=".$COD_REGION;
						
						//$RS2 = sqlsrv_query($maestra, $S2);
						////oci_execute($RS2);
						$RS2 = sqlsrv_query($maestra,$S2);
						
						if ($row2 = sqlsrv_fetch_array($RS2)) {
							$DES_REGION = $row2['DES_REGION'];
						} else {
							$DES_REGION = "";
						}
                        $COD_POSTAL = $row['COD_POSTAL'];
						if(empty($COD_POSTAL)) {$COD_POSTAL="";}
						$LADIRECCION=$DIRECCION."<BR>".$DES_CIUDAD." ".$COD_POSTAL."<BR>".$DES_REGION;
						
						$TEL_OFICINA = $row['TEL_OFICINA'];
						if(empty($TEL_OFICINA)) {$TEL_OFICINA="No disponible";}
						$EMAIL = $row['EMAIL'];
						if(empty($EMAIL)) {$EMAIL="No disponible";}
						if($TIPO_PERSONA==0){
								$TEL_PARTICULAR = $row['TEL_PARTICULAR'];
								if(empty($TEL_PARTICULAR)) {$TEL_PARTICULAR="No disponible";}
								$TEL_CELULAR = $row['TEL_CELULAR'];
								if(empty($TEL_CELULAR)) {$TEL_CELULAR="No disponible";}
								$CONTACTO="<strong>Tel&eacute;fono Particular:</strong> ".$TEL_PARTICULAR."<BR><strong>Tel&eacute;fono Celular: </strong>".$TEL_CELULAR."<BR><strong>Tel&eacute;fono Oficina:</strong> ".$TEL_OFICINA."<BR><strong>e-mail</strong>: ".$EMAIL;
						} else {
								$CONTACTO="Tel&eacute;fono: ".$TEL_OFICINA."<BR>e-mail: ".$EMAIL;
						}

						$S2="SELECT * FROM OP_DATACRM WHERE COD_CLIENTE=".$COD_CLIENTE;
						
						//$RS2 = sqlsrv_query($conn, $S2);
						////oci_execute($RS2);
						$RS2 = sqlsrv_query($conn,$S2); 
						
						if ($row2 = sqlsrv_fetch_array($RS2)) {
							$COD_ESTADO = $row2['COD_ESTADO'];
						} else {
							$COD_ESTADO = 1;
						}
						$S2="SELECT * FROM MN_ESTADO WHERE COD_ESTADO=".$COD_ESTADO;
						
						//$RS2 = sqlsrv_query($conn, $S2);
						////oci_execute($RS2);
						$RS2 = sqlsrv_query($conn,$S2);
						
						if ($row2 = sqlsrv_fetch_array($RS2)) {
							$DES_ESTADO = $row2['DES_ESTADO'];
							$COL_ESTADO = $row2['COL_ESTADO'];
							$CSF_ESTADO = $row2['CSF_ESTADO'];
						} 
						$STYLE_ESTADO=" style='background-color:#".$COL_ESTADO.";".$CSF_ESTADO."' ";

                        $IDREG = $row['IDREG'];
                        $FECHA = $row['FECHA'];
						$S2="SELECT NOMBRE FROM US_USUARIOS WHERE IDUSU=".$IDREG;
						
						//$RS2 = sqlsrv_query($maestra, $S2);
						////oci_execute($RS2);
						$RS2 = sqlsrv_query($maestra,$S2);
						
						if ($row2 = sqlsrv_fetch_array($RS2)) {
							$QUIENFUE = $row2['NOMBRE'];
						}	

						if($BOPCION==1) {
								$NOMBRE=str_replace(strtoupper($BOPERA),'<span style="background-color:#FDE807; font-weight:600; ">'.strtoupper($BOPERA).'</span>', strtoupper($NOMBRE)); 
						}

						if($BOPCION==2) {
								$LAIDENTIFICACION=str_replace($BOPERA,'<span style="background-color:#FDE807; font-weight:600; ">'.$BOPERA.'</span>', $LAIDENTIFICACION); 
						}
						
						//PUNTOS
						$S2="SELECT * FROM OP_ACTIVIDAD WHERE COD_CLIENTE=".$COD_CLIENTE;
						
						//$RS2 = sqlsrv_query($conn, $S2);
						////oci_execute($RS2);
						$RS2 = sqlsrv_query($conn,$S2);
						
						if ($row2 = sqlsrv_fetch_array($RS2)) {
							$TOT_PUNTOS = $row2['TOT_PUNTOS'];
									$TOT_PUNTOS=number_format($TOT_PUNTOS, 0, ',', '.');
							$TOT_TRANS = $row2['TOT_TRANS'];
									$TOT_TRANS=number_format($TOT_TRANS, 0, ',', '.');
							$PTOS_REEMBOLSO = $row2['PTOS_REEMBOLSO'];
									$PTOS_REEMBOLSO=number_format($PTOS_REEMBOLSO, 0, ',', '.');
							$ULT_ASIGNA_PUNTO = $row2['ULT_ASIGNA_PUNTO'];
									$ULT_ASIGNA_PUNTO=number_format($ULT_ASIGNA_PUNTO, 0, ',', '.');
							$ULT_FECHA_COMPRA = $row2['ULT_FECHA_COMPRA'];
						} 

               ?>
                <tr>
                    <?php if($SESPUBLICA==1) { ?>
                    <td><a href="reg_cliente.php?ACT=<?php echo $COD_CLIENTE?>">
					<?php echo $NOMBRE?></a><br><?php echo $LAIDENTIFICACION?><br><?php echo $COD_CLIENTE?></td>
                    <?php } else {?>
                     <td><?php echo $NOMBRE?><br><?php echo $LAIDENTIFICACION?></td>
                    <?php } ?>
                    <td>
                    		<strong>Puntos:</strong><?php if(@$TOT_PUNTOS != NULL){ echo @$TOT_PUNTOS."  ptos."; } else {echo "SIN REGISTRO"; } ?><br>
                    		<strong>Reembolsos:</strong> <?php if(@$PTOS_REEMBOLSO != NULL){ echo @$PTOS_REEMBOLSO."  ptos."; } else {echo "SIN REGISTRO"; } ?><br>
                    		<strong>&Uacute;lt. Asignaci&oacute;n:</strong><?php if(@$ULT_ASIGNA_PUNTO != NULL){ echo @$ULT_ASIGNA_PUNTO. "  ptos."; } else { echo "SIN REGISTRO"; } ?><br>
                    		<strong>Total TRX.:</strong> <?php if(@$TOT_TRANS != NULL){ echo @$TOT_TRANS; } else { echo "SIN REGISTRO"; } ?><br>
                    		<strong>&Uacute;lt. Compra:</strong><?php if(@$ULT_FECHA_COMPRA != NULL){  echo date_format(@$ULT_FECHA_COMPRA,"d-m-Y"); }else{ echo "SIN REGISTRO"; } ?><br>
                    </td>
                    <td><?php echo $LADIRECCION?></td>
                    <td><?php echo $CONTACTO?></td>
                    <td <?php echo $STYLE_ESTADO?>><?php echo $DES_TIPOCLIENTE?><br><?php echo $DES_ESTADO?></td>
                    <td><?php echo $QUIENFUE.", ".date_format($FECHA,"d-m-Y")?></td>
                </tr>
                <?php
				}
				?>
                <tr>
                    <td colspan="6" nowrap style="background-color:transparent">
                    <?php
                    if ($LINF>=$CTP+1) {
						$ATRAS=$LINF-$CTP;
						$FILA_ANT=$LSUP-$CTP;
                   ?>
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('reg_cliente.php?LSUP=<?php echo $FILA_ANT?>&LINF=<?php echo $ATRAS?>&FDEPTO=<?php echo $FDEPTO?>&FCIUDAD=<?php echo $FCIUDAD?>&FESTADO=<?php echo $FESTADO?>&BOPCION=<?php echo $BOPCION?>&BOPERA=<?php echo $BOPERA?>&FPERFIL=<?php echo $FPERFIL?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('reg_cliente.php?LSUP=<?php echo $FILA_POS?>&LINF=<?php echo $ADELANTE?>&FDEPTO=<?php echo $FDEPTO?>&FCIUDAD=<?php echo $FCIUDAD?>&FESTADO=<?php echo $FESTADO?>&BOPCION=<?php echo $BOPCION?>&BOPERA=<?php echo $BOPERA?>&FPERFIL=<?php echo $FPERFIL?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina <?php echo $NUMPAG?> de <?php echo $NUMTPAG?></span>
                    </td>
                </tr>
                </table>
<?php
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
		//sqlsrv_close($conn);
		//sqlsrv_close($maestra);
}
?>
               
               
                <?php  if ($NEO==1) { ?>
                <table id="forma-registro">
                        <form action="reg_cliente_reg.php" method="post" name="forming" id="forming" onSubmit="return validaingreso(this)">
                        <tr>
                           <td><label for="COD_TIPOCLIENTE">Tipo de Cliente </label></td>
                           <td><select name="COD_TIPOCLIENTE">
                            <option value="0">SELECCIONAR</option>
                            <?php
                                $S1="SELECT * FROM PM_TIPOCLIENTE ORDER BY DES_TIPOCLIENTE ASC";
                                
                                //$RS1 = sqlsrv_query($conn, $S1);
                                ////oci_execute($RS1);
                                $RS1 = sqlsrv_query($conn,$S1);

                                while ($row = sqlsrv_fetch_array($RS1)) {
                                    $COD_TIPOCLIENTE = $row['COD_TIPOCLIENTE'];
                                    $DES_TIPOCLIENTE = $row['DES_TIPOCLIENTE'];
                            ?>
                            <option value="<?php echo $COD_TIPOCLIENTE?>" ><?php echo $DES_TIPOCLIENTE?></option>
                            <?php
                                }
                            ?>
                            </select></td>
                        </tr>
                        <tr>
                           <td><label for="COD_TIPOID">Tipo de Identificaci&oacute;n </label></td>
                           <td><select name="COD_TIPOID" onChange="ActivarNombre(this.value);">
                            <option value="0">SELECCIONAR</option>
                            <?php
                                $S1="SELECT * FROM PM_TIPOID ORDER BY TIPO_PERSONA ASC";
                                
                                //$RS1 = sqlsrv_query($conn, $S1);
                                ////oci_execute($RS1);
                                $RS1 = sqlsrv_query($conn,$S1);

                                while ($row = sqlsrv_fetch_array($RS1)) {
                                    $COD_TIPOID = $row['COD_TIPOID'];
                                    $TIPO_PERSONA = $row['TIPO_PERSONA'];
                                    $DES_TIPOID = $row['DES_TIPOID'];
                            ?>
                            <option value="<?php echo $COD_TIPOID."|".$TIPO_PERSONA?>" ><?php echo $DES_TIPOID?></option>
                            <?php
                                }
                            ?>
                            </select>
                        </td>
                        </tr>
                        <tr>
                            <td><label for="IDENTIFICACION">N&uacute;mero Identificaci&oacute;n </label></td>
                            <td><input name="IDENTIFICACION" type="text" size="20" maxlength="50"  onKeyPress="return acceptNumK(event);"> </td>
                        </tr>
                        <tr id="NOMB_TIPOID_0" style="display:none">
                            <td ><label for="NOMBRE_PN">Nombres </label></td>
                            <td ><input name="NOMBRE_PN" type="text" size="20" maxlength="75" > </td>
                        </tr>
                        <tr id="APPP_TIPOID_0" style="display:none">
                            <td ><label for="APELLIDO_P">Apellido Paterno </label></td>
                            <td ><input name="APELLIDO_P" type="text" size="20" maxlength="50" > </td>
                        </tr>
                        <tr id="APPM_TIPOID_0" style="display:none">
                            <td ><label for="APELLIDO_M">Apellido Materno </label></td>
                            <td ><input name="APELLIDO_M" type="text" size="20" maxlength="50" > </td>
                        </tr>
                        <tr id="NOMB_TIPOID_1" style="display:none">
                            <td ><label for="NOMBRE_PJ">Raz&oacute;n Social </label></td>
                            <td ><input name="NOMBRE_PJ" type="text" size="20" maxlength="75" > </td>
                        </tr>
                        <tr id="GENDER_TIPOID_0" style="display:none">
                           <td ><label for="GENERO">G&eacute;nero </label></td>
                           <td ><select name="GENERO">
                            <option value="">SELECCIONAR</option>
                            <option value="M" >MASCULINO</option>
                            <option value="F" >FEMENINO</option>
                            </select>
                        </td>
                        </tr>
                        <tr id="FECNAC_TIPOID_0" style="display:none">
                        	<td ><label for="FEC_NACIMIENTO">Fecha Nacimiento <BR>(d&iacute;a-mes-a&ntilde;o)</label></td>
                            <td >
                                    <input style="float:left; display:inline; margin:6px 0 0 6px" name="DIA_NAC" type="text"  id="DIA_NAC" size="1" maxlength="2" onKeyPress="return acceptNum(event);">
                                    <select style="float:left; display:inline; margin:6px 0 0 0"  name="MES_NAC"  id="MES_NAC">
                                            <option value="1">Enero</option>
                                            <option value="2">Febrero</option>
                                            <option value="3">Marzo</option>
                                            <option value="4">Abril</option>
                                            <option value="5">Mayo</option>
                                            <option value="6">Junio</option>
                                            <option value="7">Julio</option>
                                            <option value="8">Agosto</option>
                                            <option value="9">Septiembre</option>
                                            <option value="10">Octubre</option>
                                            <option value="11">Noviembre</option>
                                            <option value="12">Diciembre</option>
                                    </select>
                                    <input style="float:left; display:inline; margin:6px 0 0 0"  name="ANO_NAC" type="text"  id="ANO_NAC"  size="2" maxlength="4"  onKeyPress="return acceptNum(event);">
                            </td>
                        </tr>
                         <?php if($GLBDPTREG==1){?>
                        <tr>
                            <td><label for="COD_REGION"><?=$GLBDESCDPTREG?></label></td>
                            <td><select name="COD_REGION"  onChange="CargaCiudad(this.value, this.form.name, 'COD_CIUDAD', <?=$GLBCODPAIS?>)">
                                                <option value="0"><?=$GLBDESCDPTREG?></option>
                                                <?php 
                                                $SQL="SELECT * FROM PM_REGION WHERE COD_PAIS=".$GLBCODPAIS." ORDER BY DES_REGION ASC";
                                                
                                                //$RS = sqlsrv_query($maestra, $SQL);
                                                ////oci_execute($RS);
                                                $RS = sqlsrv_query($maestra,$SQL);
                                                
                                                while ($row = sqlsrv_fetch_array($RS)) {
                                                    $COD_REGION = $row['COD_REGION'];
                                                    $DES_REGION = $row['DES_REGION'];
                                                 ?>
                                                <option value="<?php echo $COD_REGION;?>"><?php echo $DES_REGION ?></option>
                                                <?php 
                                                }
                                                 ?>
                                </select></td>
                        </tr>
                         <?php } else {?><input type="hidden" name="COD_REGION" value="0"><?php }//$GLBDPTREG?>
                        <tr>
                           <td><label for="COD_CIUDAD">Ciudad</label></td>
                           <td><select id="COD_CIUDAD" name="COD_CIUDAD">
                            <option value="0">Ciudad</option>
                            <?php if($GLBDPTREG==0){?>
									<?php
                                        $S1="SELECT * FROM PM_CIUDAD WHERE COD_PAIS=".$GLBCODPAIS." ORDER BY DES_CIUDAD ASC";
                                        
                                        //$RS1 = sqlsrv_query($maestra, $S1);
                                        ////oci_execute($RS1);
                                        $RS1 = sqlsrv_query($maestra,$S1); 
                                        
                                        while ($row = sqlsrv_fetch_array($RS1)) {
                                            $COD_CIUDAD = $row['COD_CIUDAD'];
                                            $DES_CIUDAD = $row['DES_CIUDAD'];
                                    ?>
                                    <option value="<?php echo $COD_CIUDAD?>"><?php echo $DES_CIUDAD?></option>
                                    <?php
                                        }
                                    ?>
                         <?php } //$GLBDPTREG?>
                            </select></td>
                        </tr>
                        <tr>
                            <td><label for="DIRECCION">Direcci&oacute;n </label></td>
                            <td><input name="DIRECCION" type="text" size="20" maxlength="200" > </td>
                        </tr>
                        <tr>
                            <td><label for="COD_POSTAL">C&oacute;digo Postal</label></td>
                            <td><input name="COD_POSTAL" type="text" size="10" maxlength="10" > </td>
                        </tr>
                        <tr id="TELPAR_TIPOID_0" style="display:none">
                            <td><label for="TEL_PARTICULAR">Tel&eacute;fono Hogar</label></td>
                            <td><input name="TEL_PARTICULAR" type="text" size="20" maxlength="50" > </td>
                        </tr>
                        <tr>
                            <td><label for="TEL_OFICINA">Tel&eacute;fono Oficina</label></td>
                            <td><input name="TEL_OFICINA" type="text" size="20" maxlength="50" > </td>
                        </tr>
                        <tr id="TELCEL_TIPOID_0" style="display:none">
                            <td><label for="TEL_CELULAR">Celular</label></td>
                            <td><input name="TEL_CELULAR" type="text" size="20" maxlength="50" > </td>
                        </tr>
                        <tr>
                            <td><label for="EMAIL">Correo Electr&oacute;nico</label></td>
                            <td><input name="EMAIL" type="text" size="20" maxlength="200" style=" text-transform:lowercase"> </td>
                        </tr>

                        <tr>
                           <td></td>
                           <td><input name="INGRESAR" type="submit" value="Registrar">
                            <input name="NEO" type="hidden" value="1">
                            <input name="LIMPIAR" type="reset" value="Limpiar">
                            <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('reg_cliente.php')"></td>
                        </tr>
                        </form>
                </table>
                <script>
                document.forming.COD_TIPOCLIENTE.focus();
                </script>
<?php
		//sqlsrv_close($conn);
		//sqlsrv_close($maestra);
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
}
?>
               
               
			<?php  if ($ACT<>"") {
				$S="SELECT * FROM OP_CLIENTE WHERE COD_CLIENTE=".$ACT;
				
				//$RS = sqlsrv_query($conn, $S);
				////oci_execute($RS);
				$RS = sqlsrv_query($conn,$S);
				
				if ($row = sqlsrv_fetch_array($RS)) {
					$COD_CLIENTE = $row['COD_CLIENTE'];
					$COD_TIPOCLIENTE = $row['COD_TIPOCLIENTE'];
					$COD_TIPOID = $row['COD_TIPOID'];
							$S1="SELECT * FROM PM_TIPOID WHERE COD_TIPOID=".$COD_TIPOID;
							
							//$RS1 = sqlsrv_query($conn, $S1);
							////oci_execute($RS1);
							$RS1 = sqlsrv_query($conn,$S1);

							if ($row1 = sqlsrv_fetch_array($RS1)) {
								$DES_TIPOID = $row1['DES_TIPOID'];
								$TIPO_PERSONA = $row1['TIPO_PERSONA'];
							}

					$IDENTIFICACION = $row['IDENTIFICACION'];
					if($TIPO_PERSONA==0)	{
							$LAIDENTIFICACION=number_format($IDENTIFICACION, 0, ',', '.');
					} else {
							$LARGOID = strlen($IDENTIFICACION);
							$IDENTIFICA = substr($IDENTIFICACION, 0, $LARGOID-1);
							$DIGITOV = substr($IDENTIFICACION, -1);
							$LAIDENTIFICACION=number_format($IDENTIFICA, 0, ',', '.')."-".$DIGITOV;
					}
					
					$NOMBRE = $row['NOMBRE'];
					$APELLIDO_P = $row['APELLIDO_P'];
					$APELLIDO_M = $row['APELLIDO_M'];
					$GENERO = $row['GENERO'];
					$FEC_NACIMIENTO = $row['FEC_NACIMIENTO'];
							$FEC_NACIMIENTO = date_format($FEC_NACIMIENTO,"d-m-Y");
							$FEC_NACIMIENTO = strtotime($FEC_NACIMIENTO);
							$ANO_NAC = date("Y", $FEC_NACIMIENTO); 
							$MES_NAC = date("m", $FEC_NACIMIENTO); 
							$DIA_NAC = date("d", $FEC_NACIMIENTO); 
					
					$DIRECCION = $row['DIRECCION'];
					$COD_REGION = $row['COD_REGION'];
					$COD_CIUDAD = $row['COD_CIUDAD'];
					$COD_POSTAL = $row['COD_POSTAL'];
					$TEL_PARTICULAR = $row['TEL_PARTICULAR'];
					$TEL_OFICINA = $row['TEL_OFICINA'];
					$TEL_CELULAR = $row['TEL_CELULAR'];
					$EMAIL = $row['EMAIL'];

					$S2="SELECT * FROM OP_DATACRM WHERE COD_CLIENTE=".$COD_CLIENTE;
					
					//$RS2 = sqlsrv_query($conn, $S2);
					////oci_execute($RS2);
					$RS2 = sqlsrv_query($conn,$S2);
					
					if ($row2 = sqlsrv_fetch_array($RS2)) {
						$COD_ESTADO = $row2['COD_ESTADO'];
					} else {
						$COD_ESTADO = 1;
					}
					$S2="SELECT * FROM MN_ESTADO WHERE COD_ESTADO=".$COD_ESTADO;
					
					//$RS2 = sqlsrv_query($conn, $S2);
					////oci_execute($RS2);
					$RS2 = sqlsrv_query($conn,$S2);

					if ($row2 = sqlsrv_fetch_array($RS2)) {
						$VAL_ESTADO = $row2['VAL_ESTADO'];
						$DES_ESTADO = $row2['DES_ESTADO'];
						$COL_ESTADO = $row2['COL_ESTADO'];
						$CSF_ESTADO = $row2['CSF_ESTADO'];
					} 
                }
               ?>
               
               
               
               
               
               <?php if($ACT_ENC==1) {?>
                <h3>
                		Ficha Cliente: <?php echo $NOMBRE." ".$APELLIDO_P." ".$APELLIDO_M?><br>
                </h3>
                <table id="forma-registro">
                		<tr style="background-color:#<?php echo $COL_ESTADO?>">
                        <td colspan="2" style=" font-size:12pt;  <?php echo $CSF_ESTADO?>">
                        <?php echo $DES_ESTADO?>
                        </td>
                        </tr>
                        <form action="reg_cliente_reg.php" method="post" name="forming" id="forming" onSubmit="return validaingreso(this)">
                        <tr>
                           <td><label for="COD_TIPOCLIENTE">Tipo de Cliente </label></td>
                           <td><select name="COD_TIPOCLIENTE">
                            <option value="0">SELECCIONAR</option>
                            <?php
                                $S1="SELECT * FROM PM_TIPOCLIENTE ORDER BY DES_TIPOCLIENTE ASC";
                                
                                //$RS1 = sqlsrv_query($conn, $S1);
                                ////oci_execute($RS1);
                                $RS1 = sqlsrv_query($conn,$S1);
                                
                                while ($row = sqlsrv_fetch_array($RS1)) {
                                    $COD_TIPOCLIENTE2 = $row['COD_TIPOCLIENTE'];
                                    $DES_TIPOCLIENTE = $row['DES_TIPOCLIENTE'];
                            ?>
                            <option value="<?php echo $COD_TIPOCLIENTE2?>" <?php if($COD_TIPOCLIENTE2==$COD_TIPOCLIENTE){echo "SELECTED";}?>><?php echo $DES_TIPOCLIENTE?></option>
                            <?php
                                }
                            ?>
                            </select></td>
                        </tr>
                        <tr>
                           <td><label for="COD_TIPOID">Tipo de Identificaci&oacute;n</label></td>
                           <td>
                            <h5><?php echo $DES_TIPOID?></h5>
                            <input type="hidden" name="COD_TIPOID" value="<?php echo $COD_TIPOID."|".$TIPO_PERSONA?>">
                        </td>
                        </tr>
                        <tr>
                            <td><label for="IDENTIFICACION">N&uacute;mero Identificaci&oacute;n</label></td>
                            <td>
                            <h5><?php echo $LAIDENTIFICACION?></h5>
                            <input type="hidden" name="IDENTIFICACION" value="<?php echo $IDENTIFICACION?>">
                            </td>
                        </tr>
                        <tr id="NOMB_TIPOID_0" style="display:<?php if($TIPO_PERSONA==1){?>none<?php } else {?>table-row<?php }?>">
                            <td ><label for="NOMBRE_PN">Nombres </label></td>
                            <td ><input name="NOMBRE_PN" type="text" size="20" maxlength="75" value="<?php echo $NOMBRE?>"> </td>
                        </tr>
                        <tr id="APPP_TIPOID_0" style="display:<?php if($TIPO_PERSONA==1){?>none<?php } else {?>table-row<?php }?>">
                            <td ><label for="APELLIDO_P">Apellido Paterno </label></td>
                            <td ><input name="APELLIDO_P" type="text" size="20" maxlength="50" value="<?php echo $APELLIDO_P?>"> </td>
                        </tr>
                        <tr id="APPM_TIPOID_0" style="display:<?php if($TIPO_PERSONA==1){?>none<?php } else {?>table-row<?php }?>">
                            <td ><label for="APELLIDO_M">Apellido Materno </label></td>
                            <td ><input name="APELLIDO_M" type="text" size="20" maxlength="50" value="<?php echo $APELLIDO_M?>"> </td>
                        </tr>
                        <tr id="NOMB_TIPOID_1" style="display:<?php if($TIPO_PERSONA==0){?>none<?php } else {?>table-row<?php }?>">
                            <td ><label for="NOMBRE_PJ">Raz&oacute;n Social </label></td>
                            <td ><input name="NOMBRE_PJ" type="text" size="20" maxlength="75" value="<?php echo $NOMBRE?>"> </td>
                        </tr>
                        <tr id="GENDER_TIPOID_0" style="display:<?php if($TIPO_PERSONA==1){?>none<?php } else {?>table-row<?php }?>">
                           <td ><label for="GENERO">G&eacute;nero </label></td>
                           <td ><select name="GENERO">
                            <option value="">SELECCIONAR</option>
                            <option value="M" <?php if($GENERO=="M"){echo "SELECTED";}?>>MASCULINO</option>
                            <option value="F" <?php if($GENERO=="F"){echo "SELECTED";}?>>FEMENINO</option>
                            </select>
                        </td>
                        </tr>
                        <tr id="FECNAC_TIPOID_0" style="display:<?php if($TIPO_PERSONA==1){?>none<?php } else {?>table-row<?php }?>">
                        	<td ><label for="FEC_NACIMIENTO">Fecha Nacimiento <BR>(d&iacute;a-mes-a&ntilde;o)</label></td>
                            <td >
                                    <input style="float:left; display:inline; margin:6px 0 0 6px" name="DIA_NAC" type="text"  id="DIA_NAC" size="1" maxlength="2" onKeyPress="return acceptNum(event);" value="<?php echo $DIA_NAC?>">
                                    <select style="float:left; display:inline; margin:6px 0 0 0"  name="MES_NAC"  id="MES_NAC">
                                            <option value="1" <?php if($MES_NAC==1){echo "SELECTED";}?>>Enero</option>
                                            <option value="2" <?php if($MES_NAC==2){echo "SELECTED";}?>>Febrero</option>
                                            <option value="3" <?php if($MES_NAC==3){echo "SELECTED";}?>>Marzo</option>
                                            <option value="4" <?php if($MES_NAC==4){echo "SELECTED";}?>>Abril</option>
                                            <option value="5" <?php if($MES_NAC==5){echo "SELECTED";}?>>Mayo</option>
                                            <option value="6" <?php if($MES_NAC==6){echo "SELECTED";}?>>Junio</option>
                                            <option value="7" <?php if($MES_NAC==7){echo "SELECTED";}?>>Julio</option>
                                            <option value="8" <?php if($MES_NAC==8){echo "SELECTED";}?>>Agosto</option>
                                            <option value="9" <?php if($MES_NAC==9){echo "SELECTED";}?>>Septiembre</option>
                                            <option value="10" <?php if($MES_NAC==10){echo "SELECTED";}?>>Octubre</option>
                                            <option value="11" <?php if($MES_NAC==11){echo "SELECTED";}?>>Noviembre</option>
                                            <option value="12" <?php if($MES_NAC==12){echo "SELECTED";}?>>Diciembre</option>
                                    </select>
                                    <input style="float:left; display:inline; margin:6px 0 0 0"  name="ANO_NAC" type="text"  id="ANO_NAC"  size="2" maxlength="4"  onKeyPress="return acceptNum(event);" value="<?php echo $ANO_NAC?>">
                            </td>
                        </tr>
                         <?php if($GLBDPTREG==1){?>
                        <tr>
                            <td><label for="COD_REGION"><?=$GLBDESCDPTREG?></label></td>
                            <td><select name="COD_REGION"  onChange="CargaCiudad(this.value, this.form.name, 'COD_CIUDAD', <?=$GLBCODPAIS?>)">
                                                <option value="0"><?=$GLBDESCDPTREG?></option>
                                                <?php 
                                                $SQL="SELECT * FROM PM_REGION WHERE COD_PAIS=".$GLBCODPAIS." ORDER BY DES_REGION ASC";
                                                
                                                //$RS = sqlsrv_query($maestra, $SQL);
                                                ////oci_execute($RS);
                                                $RS = sqlsrv_query($maestra,$SQL);

                                                while ($row = sqlsrv_fetch_array($RS)) {
                                                    $COD_REGION2 = $row['COD_REGION'];
                                                    $DES_REGION = $row['DES_REGION'];
                                                 ?>
                                                <option value="<?php echo $COD_REGION2;?>" <?php if($COD_REGION2==$COD_REGION){echo "SELECTED";}?>><?php echo $DES_REGION ?></option>
                                                <?php 
                                                }
                                                 ?>
                                </select></td>
                        </tr>
                         <?php } else {?><input type="hidden" name="COD_REGION" value="0"><?php }//$GLBDPTREG?>
                        <tr>
                           <td><label for="COD_CIUDAD">Ciudad</label></td>
                           <td><select id="COD_CIUDAD" name="COD_CIUDAD">
                            <option value="0">Ciudad</option>
									<?php
										if($GLBDPTREG==1){
												$S1="SELECT * FROM PM_CIUDAD WHERE COD_PAIS=".$GLBCODPAIS." AND COD_REGION=".$COD_REGION." ORDER BY DES_CIUDAD ASC";
										} else {
												$S1="SELECT * FROM PM_CIUDAD WHERE COD_PAIS=".$GLBCODPAIS." ORDER BY DES_CIUDAD ASC";
										}
                                        
                                        //$RS1 = sqlsrv_query($maestra, $S1);
                                        ////oci_execute($RS1);
                                        $RS1 = sqlsrv_query($maestra,$S1);

                                        while ($row = sqlsrv_fetch_array($RS1)) {
											$COD_CIUDAD2 = $row['COD_CIUDAD'];
                                            $DES_CIUDAD = $row['DES_CIUDAD'];
                                    ?>
                                    <option value="<?php echo $COD_CIUDAD2?>" <?php if($COD_CIUDAD2==$COD_CIUDAD){echo "SELECTED";}?>><?php echo $DES_CIUDAD?></option>
                                    <?php
                                        }
                                    ?>
                            </select></td>
                        </tr>
                        <tr>
                            <td><label for="DIRECCION">Direcci&oacute;n </label></td>
                            <td><input name="DIRECCION" type="text" size="20" maxlength="200" value="<?php echo $DIRECCION?>"> </td>
                        </tr>
                        <tr>
                            <td><label for="COD_POSTAL">C&oacute;digo Postal</label></td>
                            <td><input name="COD_POSTAL" type="text" size="10" maxlength="10" value="<?php echo $COD_POSTAL?>"> </td>
                        </tr>
                        <tr id="TELPAR_TIPOID_0" style="display:<?php if($TIPO_PERSONA==1){?>none<?php } else {?>table-row<?php }?>">
                            <td><label for="TEL_PARTICULAR">Tel&eacute;fono Hogar</label></td>
                            <td><input name="TEL_PARTICULAR" type="text" size="20" maxlength="50" value="<?php echo $TEL_PARTICULAR?>"> </td>
                        </tr>
                        <tr>
                            <td><label for="TEL_OFICINA">Tel&eacute;fono Oficina</label></td>
                            <td><input name="TEL_OFICINA" type="text" size="20" maxlength="50" value="<?php echo $TEL_OFICINA?>"> </td>
                        </tr>
                        <tr id="TELCEL_TIPOID_0" style="display:<?php if($TIPO_PERSONA==1){?>none<?php } else {?>table-row<?php }?>">
                            <td><label for="TEL_CELULAR">Celular</label></td>
                            <td><input name="TEL_CELULAR" type="text" size="20" maxlength="50" value="<?php echo $TEL_CELULAR?>"> </td>
                        </tr>
                        <tr>
                            <td><label for="EMAIL">Correo Electr&oacute;nico</label></td>
                            <td><input name="EMAIL" type="text" size="20" maxlength="200" style=" text-transform:lowercase" value="<?php echo $EMAIL?>"> </td>
                        </tr>

                        <tr>
                           <td></td>
                           <td><input name="INGRESAR" type="submit" value="Actualizar">
                                    <input name="NEO" type="hidden" value="0">
                                    <input name="COD_CLIENTE" type="hidden" value="<?php echo $COD_CLIENTE?>">
                                    <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('reg_cliente.php')"></td>
                        </tr>
                        </form>
                </table>
                <script>
                document.forming.COD_TIPOCLIENTE.focus();
                </script>
                <?php } //FIN ACT_ENC?>
                
                
                <?php
				 if($ACT_CRM==1) {
				
						$S="SELECT * FROM OP_DATACRM WHERE COD_CLIENTE=".$ACT;
						
						//$RS = sqlsrv_query($conn, $S);
						////oci_execute($RS);
						$RS = sqlsrv_query($conn,$S);
						
						if ($row = sqlsrv_fetch_array($RS)) {
								$REG_CLIENTE=1;
								
								$COD_TIENDA = $row['COD_TIENDA'];
								$COD_NEGOCIO = $row['COD_NEGOCIO'];
								$COD_INGRESO = $row['COD_INGRESO'];
								$COD_DEMOGRAF = $row['COD_DEMOGRAF'];
								$NUM_HIJOS=0;
								$TAM_FAMILIA = $row['TAM_FAMILIA'];
								$EDAD_HIJO1 = $row['EDAD_HIJO1'];
								if($EDAD_HIJO1>0){$NUM_HIJOS=$NUM_HIJOS+1;};
								$EDAD_HIJO2 = $row['EDAD_HIJO2'];
								if($EDAD_HIJO2>0){$NUM_HIJOS=$NUM_HIJOS+1;};
								$EDAD_HIJO3 = $row['EDAD_HIJO3'];
								if($EDAD_HIJO3>0){$NUM_HIJOS=$NUM_HIJOS+1;};
								$EDAD_HIJO4 = $row['EDAD_HIJO4'];
								if($EDAD_HIJO4>0){$NUM_HIJOS=$NUM_HIJOS+1;};
								$EDAD_HIJO5 = $row['EDAD_HIJO5'];
								if($EDAD_HIJO5>0){$NUM_HIJOS=$NUM_HIJOS+1;};
								$EDAD_HIJO6 = $row['EDAD_HIJO6'];
								if($EDAD_HIJO6>0){$NUM_HIJOS=$NUM_HIJOS+1;};
								$EDAD_HIJO7 = $row['EDAD_HIJO7'];
								if($EDAD_HIJO7>0){$NUM_HIJOS=$NUM_HIJOS+1;};
						} else {
								$REG_CLIENTE=0;
						}
				
				?>
                
                <h3>
                		Ficha Cliente: <?php echo $NOMBRE." ".$APELLIDO_P." ".$APELLIDO_M?><br>
                </h3>
                <table id="forma-registro">
                		<tr style="background-color:#<?php echo $COL_ESTADO?>">
                        <td colspan="2" style=" font-size:12pt;  <?php echo $CSF_ESTADO?>">
                        <?php echo $DES_ESTADO?>
                        </td>
                        </tr>
                        <form action="reg_cliente_reg.php" method="post" name="forming" id="forming" onSubmit="return validaFidelidad(this)">

                        <tr>
                           <td><label for="COD_NEGOCIO">Negocio</label></td>
                           <td><select name="COD_NEGOCIO"  onChange="CargaTienda(this.value, this.form.name, 'COD_TIENDA')">
                            <option value="0">SELECCIONAR</option>
                            <?php
                                $S1="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO<>0 ORDER BY DES_NEGOCIO ASC";
                                
                                //$RS1 = sqlsrv_query($maestra, $S1);
                                ////oci_execute($RS1);
                                $RS1 = sqlsrv_query($maestra,$S1); 

                                while ($row2 = sqlsrv_fetch_array($RS1)) {
                                    $COD_NEGOCIO2 = $row2['COD_NEGOCIO'];
                                    $DES_NEGOCIO = $row2['DES_NEGOCIO'];
                            ?>
                            <option value="<?php echo $COD_NEGOCIO2?>" <?php if($REG_CLIENTE==1 and $COD_NEGOCIO2==$COD_NEGOCIO){echo "SELECTED";}?>><?php echo $DES_NEGOCIO?></option>
                            <?php
                                }
                            ?>
                            </select></td>
                        </tr>
                        <tr>
                           <td><label for="COD_TIENDA">Local de Registro</label></td>
                           <td><select id="COD_TIENDA" name="COD_TIENDA">
                           <option value="0">SELECCIONAR</option>
                            <?php
                                $S1="SELECT * FROM MN_TIENDA WHERE COD_TIENDA IN(SELECT COD_TIENDA FROM MN_NEGTND WHERE COD_NEGOCIO=".$COD_NEGOCIO.")";
                                
                                //$RS1 = sqlsrv_query($maestra, $S1);
                                ////oci_execute($RS1);
                                $RS1 = sqlsrv_query($maestra,$S1);

                                while ($row2 = sqlsrv_fetch_array($RS1)) {
                                    $COD_TIENDA2 = $row2['DES_CLAVE'];
                                    $DES_TIENDA = $row2['DES_TIENDA'];
                            ?>
                            <option value="<?php echo $COD_TIENDA2?>" <?php if($REG_CLIENTE==1 and $COD_TIENDA2==$COD_TIENDA){echo "SELECTED";}?>><?php echo $DES_TIENDA?></option>
                            <?php
                                }
                            ?>
                            </select></td>
                        </tr>
                        <?php if($TIPO_PERSONA==0){ ?>
                                    <tr >
                                       <td><label for="COD_INGRESO">Nivel de Ingresos</label></td>
                                       <td><select id="COD_INGRESO" name="COD_INGRESO">
                                       <option value="0">SELECCIONAR</option>
                                        <?php
                                            $S1="SELECT * FROM MN_INGRESO ORDER BY MIN_INGRESO ASC";
                                            
                                            //$RS1 = sqlsrv_query($conn, $S1);
                                            ////oci_execute($RS1);
                                            $RS1 = sqlsrv_query($conn,$S1);
                                            
                                            while ($row1 = sqlsrv_fetch_array($RS1)) {
                                                $COD_INGRESO2 = $row1['COD_INGRESO'];
                                                $MIN_INGRESO = $row1['MIN_INGRESO'];
                                                $FMIN_INGRESO=$MONEDA.number_format($MIN_INGRESO, 0, ',', '.');
                                                $MAX_INGRESO = $row1['MAX_INGRESO'];
                                                $FMAX_INGRESO=$MONEDA.number_format($MAX_INGRESO, 0, ',', '.');
                                        ?>
                                        <option value="<?php echo $COD_INGRESO2?>" <?php if($REG_CLIENTE==1 and $COD_INGRESO2==$COD_INGRESO){echo "SELECTED";}?>><?php echo $FMIN_INGRESO." - ".$FMAX_INGRESO?></option>
                                        <?php
                                            }
                                        ?>
                                        </select></td>
                                    </tr>
                                    <tr >
                                       <td><label for="COD_DEMOGRAF">Nivel de Estudios</label></td>
                                       <td>
                                       <select id="COD_DEMOGRAF" name="COD_DEMOGRAF">
                                       <option value="0">SELECCIONAR</option>
                                        <?php
                                            $S1="SELECT * FROM MN_DEMOGRAF ORDER BY COD_DEMOGRAF ASC";
                                            
                                            //$RS1 = sqlsrv_query($conn, $S1);
                                            ////oci_execute($RS1);
                                            $RS1 = sqlsrv_query($conn,$S1);
                                            
                                            while ($row1 = sqlsrv_fetch_array($RS1)) {
                                                $COD_DEMOGRAF2 = $row1['COD_DEMOGRAF'];
                                                $DES_DEMOGRAF = $row1['DES_DEMOGRAF'];
                                        ?>
                                        <option value="<?php echo $COD_DEMOGRAF2?>" <?php if($REG_CLIENTE==1 and $COD_DEMOGRAF2==$COD_DEMOGRAF){echo "SELECTED";}?>><?php echo $DES_DEMOGRAF?></option>
                                        <?php
                                            }
                                        ?>
                                        </select></td>
                                    </tr>
                                    <tr >
                                        <td><label for="TAM_FAMILIA">Tama&ntilde;o Familia</label></td>
                                        <td>
                                        		<input style="display:inline" name="TAM_FAMILIA" type="text" size="2" maxlength="2" value="<?php if($REG_CLIENTE==1) {echo $TAM_FAMILIA;}?>"  onKeyPress="return acceptNum(event);">
                                                <label for="NUM_HIJOS" style="text-align:left; clear:none; display:inline; margin:0 0 0 4px">N&uacute;mero de Hijos</label>
                                               <select style="display:inline; clear:none; margin:0 1px 0 4px; float:inherit"  id="NUM_HIJOS" name="NUM_HIJOS" onChange="Activa_Hijo(this.value);">
                                                   <option value="0">SEL.</option>
                                                   <option value="1" <?php if($REG_CLIENTE==1) { if($NUM_HIJOS==1){ echo "SELECTED";};}?>>1</option>
                                                   <option value="2" <?php if($REG_CLIENTE==1) { if($NUM_HIJOS==2){ echo "SELECTED";};}?>>2</option>
                                                   <option value="3" <?php if($REG_CLIENTE==1) { if($NUM_HIJOS==3){ echo "SELECTED";};}?>>3</option>
                                                   <option value="4" <?php if($REG_CLIENTE==1) { if($NUM_HIJOS==4){ echo "SELECTED";};}?>>4</option>
                                                   <option value="5" <?php if($REG_CLIENTE==1) { if($NUM_HIJOS==5){ echo "SELECTED";};}?>>5</option>
                                                   <option value="6" <?php if($REG_CLIENTE==1) { if($NUM_HIJOS==6){ echo "SELECTED";};}?>>6</option>
                                                   <option value="7" <?php if($REG_CLIENTE==1) { if($NUM_HIJOS==7){ echo "SELECTED";};}?>>7</option>
                                                </select>
                                        </td>
                                    </tr>
                                     <?php if($NUM_HIJOS>0){?>
                                        <tr id="EH" >
									<?php } else { ?>
                                        <tr id="EH" style="display:none">
									<?php } ?>
                                        <td ><label for="EDAD_HIJOS">Edad Hijos</label></td>
                                        <td >
                                        		<table>
                                                	<tr>
                                                    <?php if($EDAD_HIJO1>0){?> 
                                                    	<td id="EH1" style="border:none; padding:0">
                                                            <label for="EDAD_HIJO1" style="text-align:left; clear:none; display:inline; margin:0 0 0 2px">H1</label>
                                                            <input style="display:inline; margin:0 2px 0 1px" name="EDAD_HIJO1" type="text" size="2" maxlength="2" value="<?php if($REG_CLIENTE==1) {echo $EDAD_HIJO1;}?>"  onKeyPress="return acceptNum(event);">
                                                    	</td>
                                                    <?php } else { ?>
                                                    	<td id="EH1" style="display:none; border:none; padding:0">
                                                            <label for="EDAD_HIJO1" style="text-align:left; clear:none; display:inline; margin:0 0 0 2px">H1</label>
                                                            <input style="display:inline; margin:0 2px 0 1px" name="EDAD_HIJO1" type="text" size="2" maxlength="2" value="<?php if($REG_CLIENTE==1) {echo $EDAD_HIJO1;}?>"  onKeyPress="return acceptNum(event);">
                                                    	</td>
                                                    <?php } ?>
                                                    <?php if($EDAD_HIJO2>0){?> 
                                                    	<td id="EH2" style="border:none; padding:0">
                                                            <label for="EDAD_HIJO2" style="text-align:left; clear:none; display:inline; margin:0 0 0 2px">H2</label>
                                                            <input style="display:inline; margin:0 2px 0 1px" name="EDAD_HIJO2" type="text" size="2" maxlength="2" value="<?php if($REG_CLIENTE==1) {echo $EDAD_HIJO2;}?>"  onKeyPress="return acceptNum(event);">
                                                    	</td>
                                                    <?php } else { ?>
                                                    	<td id="EH2" style="display:none; border:none; padding:0">
                                                            <label for="EDAD_HIJO2" style="text-align:left; clear:none; display:inline; margin:0 0 0 2px">H2</label>
                                                            <input style="display:inline; margin:0 2px 0 1px" name="EDAD_HIJO2" type="text" size="2" maxlength="2" value="<?php if($REG_CLIENTE==1) {echo $EDAD_HIJO2;}?>"  onKeyPress="return acceptNum(event);">
                                                    	</td>
                                                    <?php } ?>
                                                    <?php if($EDAD_HIJO3>0){?> 
                                                    	<td id="EH3" style="border:none; padding:0">
                                                            <label for="EDAD_HIJO3" style="text-align:left; clear:none; display:inline; margin:0 0 0 2px">H3</label>
                                                            <input style="display:inline; margin:0 2px 0 1px" name="EDAD_HIJO3" type="text" size="2" maxlength="2" value="<?php if($REG_CLIENTE==1) {echo $EDAD_HIJO3;}?>"  onKeyPress="return acceptNum(event);">
                                                    	</td>
                                                    <?php } else { ?>
                                                    	<td id="EH3" style="display:none; border:none; padding:0">
                                                            <label for="EDAD_HIJO3" style="text-align:left; clear:none; display:inline; margin:0 0 0 2px">H3</label>
                                                            <input style="display:inline; margin:0 2px 0 1px" name="EDAD_HIJO3" type="text" size="2" maxlength="2" value="<?php if($REG_CLIENTE==1) {echo $EDAD_HIJO3;}?>"  onKeyPress="return acceptNum(event);">
                                                    	</td>
                                                    <?php } ?>
                                                    <?php if($EDAD_HIJO4>0){?> 
                                                    	<td id="EH4" style=" border:none; padding:0">
                                                            <label for="EDAD_HIJO4" style="text-align:left; clear:none; display:inline; margin:0 0 0 2px">H4</label>
                                                            <input style="display:inline; margin:0 2px 0 1px" name="EDAD_HIJO4" type="text" size="2" maxlength="2" value="<?php if($REG_CLIENTE==1) {echo $EDAD_HIJO4;}?>"  onKeyPress="return acceptNum(event);">
                                                    	</td>
                                                    <?php } else { ?>
                                                    	<td id="EH4" style="display:none;border:none; padding:0">
                                                            <label for="EDAD_HIJO4" style="text-align:left; clear:none; display:inline; margin:0 0 0 2px">H4</label>
                                                            <input style="display:inline; margin:0 2px 0 1px" name="EDAD_HIJO4" type="text" size="2" maxlength="2" value="<?php if($REG_CLIENTE==1) {echo $EDAD_HIJO4;}?>"  onKeyPress="return acceptNum(event);">
                                                    	</td>
                                                    <?php } ?>
                                                    <?php if($EDAD_HIJO5>0){?> 
                                                    	<td id="EH5" style="border:none; padding:0">
                                                            <label for="EDAD_HIJO5" style="text-align:left; clear:none; display:inline; margin:0 0 0 2px">H5</label>
                                                            <input style="display:inline; margin:0 2px 0 1px" name="EDAD_HIJO5" type="text" size="2" maxlength="2" value="<?php if($REG_CLIENTE==1) {echo $EDAD_HIJO5;}?>"  onKeyPress="return acceptNum(event);">
                                                    	</td>
                                                    <?php } else { ?>
                                                    	<td id="EH5" style="display:none; border:none; padding:0">
                                                            <label for="EDAD_HIJO5" style="text-align:left; clear:none; display:inline; margin:0 0 0 2px">H5</label>
                                                            <input style="display:inline; margin:0 2px 0 1px" name="EDAD_HIJO5" type="text" size="2" maxlength="2" value="<?php if($REG_CLIENTE==1) {echo $EDAD_HIJO5;}?>"  onKeyPress="return acceptNum(event);">
                                                    	</td>
                                                    <?php } ?>
                                                    <?php if($EDAD_HIJO6>0){?> 
                                                    	<td id="EH6" style="padding:0">
                                                            <label for="EDAD_HIJO6" style="text-align:left; clear:none; display:inline; margin:0 0 0 2px">H6</label>
                                                            <input style="display:inline; margin:0 2px 0 1px" name="EDAD_HIJO6" type="text" size="2" maxlength="2" value="<?php if($REG_CLIENTE==1) {echo $EDAD_HIJO6;}?>"  onKeyPress="return acceptNum(event);">
                                                    	</td>
                                                    <?php } else { ?>
                                                    	<td id="EH6" style="border:none; display:none; border:none; padding:0">
                                                            <label for="EDAD_HIJO6" style="text-align:left; clear:none; display:inline; margin:0 0 0 2px">H6</label>
                                                            <input style="display:inline; margin:0 2px 0 1px" name="EDAD_HIJO6" type="text" size="2" maxlength="2" value="<?php if($REG_CLIENTE==1) {echo $EDAD_HIJO6;}?>"  onKeyPress="return acceptNum(event);">
                                                    	</td>
                                                    <?php } ?>
                                                    <?php if($EDAD_HIJO7>0){?> 
                                                    	<td id="EH7" style="border:none; padding:0">
                                                            <label for="EDAD_HIJO7" style="text-align:left; clear:none; display:inline; margin:0 0 0 2px">H7</label>
                                                            <input style="display:inline; margin:0 2px 0 1px" name="EDAD_HIJO7" type="text" size="2" maxlength="2" value="<?php if($REG_CLIENTE==1) {echo $EDAD_HIJO7;}?>"  onKeyPress="return acceptNum(event);">
                                                    	</td>
                                                    <?php } else { ?>
                                                    	<td id="EH7" style="display:none; border:none; padding:0">
                                                            <label for="EDAD_HIJO7" style="text-align:left; clear:none; display:inline; margin:0 0 0 2px">H7</label>
                                                            <input style="display:inline; margin:0 2px 0 1px" name="EDAD_HIJO7" type="text" size="2" maxlength="2" value="<?php if($REG_CLIENTE==1) {echo $EDAD_HIJO7;}?>"  onKeyPress="return acceptNum(event);">
                                                    	</td>
                                                    <?php } ?>
                                                	</tr>
                                        		</table>
                                        </td>
                                    </tr>

                        <?php } //$TIPO_PERSONA==0?>
                        
						<?php
                            $S1="SELECT * FROM MN_DATACRM WHERE (AMBITO=".$TIPO_PERSONA." OR AMBITO=2) AND IND_ACTIVO=1 ORDER BY DES_DATACRM ASC";
                            
                            //$RS1 = sqlsrv_query($conn, $S1);
                            ////oci_execute($RS1);
                            $RS1 = sqlsrv_query($conn,$S1);
                            
                            while ($row1 = sqlsrv_fetch_array($RS1)) {
                                $COD_DATACRM = $row1['COD_DATACRM'];
                                $DES_DATACRM = $row1['DES_DATACRM'];
                                $TIPO_DATACRM = $row1['TIPO_DATACRM'];
								//VERIFICAR SI DATA ESTÁ PRESENTE EN OP_CLIENTEANT
										$DATA_CLIENTE="";
										$S2="SELECT * FROM OP_CLIENTEANT WHERE COD_DATACRM=".$COD_DATACRM." AND COD_CLIENTE=".$ACT;
										
										//$RS2 = sqlsrv_query($conn, $S2);
										////oci_execute($RS2);
										$RS2 = sqlsrv_query($conn,$S2);
										

										if ($row2 = sqlsrv_fetch_array($RS2)) {
											$DATA_CLIENTE = trim($row2['DATA_CLIENTE']);
										}
								//VERIFICAR TIPO DE DATA:  1:TEXTO, 2:NUMERICO, 3:OPCIONES
								?>
                                <tr>
                                        <td><label for="COD_DATACRM"><?php echo $DES_DATACRM;?></label></td>
                                        <td>
                                        <?php if($TIPO_DATACRM==1){ ?>
                                        <input name="CDCRM<?php echo $COD_DATACRM;?>" type="text" size="20" maxlength="500" value="<?php if(!empty($DATA_CLIENTE)) { echo $DATA_CLIENTE;}?>">
                                        <?php }//$TIPO_DATACRM=1?>
                                        <?php if($TIPO_DATACRM==2){ ?>
                                        <input name="CDCRM<?php echo $COD_DATACRM;?>" type="text" size="20" maxlength="500" value="<?php if(!empty($DATA_CLIENTE)) { echo $DATA_CLIENTE;}?>" onKeyPress="return acceptNum(event);">
                                        <?php }//$TIPO_DATACRM=2?>
                                        
                                        <?php
                                        if($TIPO_DATACRM==3){
										?>
                                        
                                        <select id="CDCRM<?php echo $COD_DATACRM;?>" name="CDCRM<?php echo $COD_DATACRM;?>">
                                        		<option value="">SELECCIONAR</option>
												 <?php
													$S3="SELECT * FROM MN_DATACRMOPC WHERE COD_DATACRM=".$COD_DATACRM." ORDER BY COD_DATACRMOPC ASC";
													
													//$RS3 = sqlsrv_query($conn, $S3);
													////oci_execute($RS3);
													$RS3 = sqlsrv_query($conn,$S3);
													
													while ($row3 = sqlsrv_fetch_array($RS3)) {
														$COD_DATACRMOPC2 = $row3['COD_DATACRMOPC'];
														$DES_DATACRMOPC2 = $row3['DES_DATACRMOPC'];
												?>
                                        		<option value="<?php echo $COD_DATACRMOPC2;?>"  <?php if($COD_DATACRMOPC2==$DATA_CLIENTE){ echo "SELECTED";}?>><?php echo $DES_DATACRMOPC2;?></option>
												<?php
													}
												?>
                                        </select>
                                        <?php }//$TIPO_DATACRM=3?>
                                        
                                        </td>
                                </tr>
                         <?php
                            }
                        ?>
                        
                        
                        
                        <tr>
                           <td></td>
                           <td>
                           			<input name="REG_CRM" type="submit" value="Registrar Data">
                                    <input name="COD_CLIENTE" type="hidden" value="<?php echo $COD_CLIENTE?>">
                                    <input name="REG_CLIENTE" type="hidden" value="<?php echo $REG_CLIENTE?>">
                                    <input name="TIPO_PERSONA" type="hidden" value="<?php echo $TIPO_PERSONA?>">
                                    <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('reg_cliente.php')"></td>
                        </tr>
                        </form>
                </table>
                <script>
                document.forming.COD_NEGOCIO.focus();
                </script>
                <?php } //FIN ACT_CRM?>
                
                
                
                <?php if($ACT_TRJ==1) { ?>
                <h3>
                		Ficha Cliente: <?php echo $NOMBRE." ".$APELLIDO_P." ".$APELLIDO_M?><br>
                </h3>
                <table id="Listado">
                		<tr style="background-color:#<?php echo $COL_ESTADO?>">
                        <td colspan="6" style=" font-size:12pt;  <?php echo $CSF_ESTADO?>">
                        <?php echo $DES_ESTADO?>
                        </td>
                        </tr>
                        <tr>
                            <th>Tipo de Tarjeta</span></th>
                            <th>N&uacute;mero de Tarjeta</span></th>
                            <th colspan="4">Fecha de Entrega</span></th>
                        </tr>
                        <form action="reg_cliente_reg.php" method="post" name="forming" id="forming" onSubmit="return validaTarjeta(this)">
                        <tr>
                            <td style="background-color:#DFDFDF; border-bottom-width:3px">
                                        <select id="COD_TIPO_TARJETA" name="COD_TIPO_TARJETA">
                                        		<option value="0">SELECCIONAR</option>
												 <?php
													$S3="SELECT * FROM MN_TIPO_TARJETA ORDER BY DES_TIPO_TARJETA ASC";
													
													//$RS3 = sqlsrv_query($conn, $S3);
													////oci_execute($RS3);
													$RS3 = sqlsrv_query($conn,$S3);

													while ($row3 = sqlsrv_fetch_array($RS3)) {
														$COD_TIPO_TARJETA = $row3['COD_TIPO_TARJETA'];
														$DES_TIPO_TARJETA = $row3['DES_TIPO_TARJETA'];
												?>
                                        		<option value="<?php echo $COD_TIPO_TARJETA;?>"><?php echo $DES_TIPO_TARJETA;?></option>
												<?php
													}
												?>
                                        </select>
                            </td>
                            <td style="background-color:#DFDFDF; border-bottom-width:3px">
                            		<input style="margin:6px 0 0 0" name="NUM_TARJETA" type="text" size="16" maxlength="25" value=""></td>
                            <td style="background-color:#DFDFDF; border-bottom-width:3px">
                                    <input style="float:left; display:inline; margin:6px 0 0 0" name="DIA_ENT" type="text"  id="DIA_ENT" size="1" maxlength="2" onKeyPress="return acceptNum(event);" value="<?php echo date("d")?>">
                                    <select style="float:left; display:inline; margin:6px 0 0 0"  name="MES_ENT"  id="MES_ENT">
                                            <option value="1" <?php if(date("m")==1){echo "SELECTED";}?>>Enero</option>
                                            <option value="2" <?php if(date("m")==2){echo "SELECTED";}?>>Febrero</option>
                                            <option value="3" <?php if(date("m")==3){echo "SELECTED";}?>>Marzo</option>
                                            <option value="4" <?php if(date("m")==4){echo "SELECTED";}?>>Abril</option>
                                            <option value="5" <?php if(date("m")==5){echo "SELECTED";}?>>Mayo</option>
                                            <option value="6" <?php if(date("m")==6){echo "SELECTED";}?>>Junio</option>
                                            <option value="7" <?php if(date("m")==7){echo "SELECTED";}?>>Julio</option>
                                            <option value="8" <?php if(date("m")==8){echo "SELECTED";}?>>Agosto</option>
                                            <option value="9" <?php if(date("m")==9){echo "SELECTED";}?>>Septiembre</option>
                                            <option value="10" <?php if(date("m")==10){echo "SELECTED";}?>>Octubre</option>
                                            <option value="11" <?php if(date("m")==11){echo "SELECTED";}?>>Noviembre</option>
                                            <option value="12" <?php if(date("m")==12){echo "SELECTED";}?>>Diciembre</option>
                                    </select>
                                    <input style="float:left; display:inline; margin:6px 0 0 0"  name="ANO_ENT" type="text"  id="ANO_ENT"  size="2" maxlength="4"  onKeyPress="return acceptNum(event);" value="<?php echo date("Y")?>">
                            </td>
                            <td colspan="3" style="background-color:#DFDFDF; border-bottom-width:3px">
                           			<input style="margin:0" name="REG_TARJETA" type="submit" value="Registrar Tarjeta">
                                    <input name="COD_CLIENTE" type="hidden" value="<?php echo $COD_CLIENTE?>">
                            </td>
                        </tr>
                        </form>
                        
                        <?php
						$S1="SELECT * FROM OP_TARJETAS WHERE COD_CLIENTE=".$COD_CLIENTE." ORDER BY FEC_ENTREGA DESC";
						
						//$RS1 = sqlsrv_query($conn, $S1);
						////oci_execute($RS1);
						$RS1 = sqlsrv_query($conn,$S1); 
						

						while ($row1 = sqlsrv_fetch_array($RS1)) {
							$COD_TARJETA = $row1['COD_TARJETA'];
							$COD_TIPO_TARJETA = $row1['COD_TIPO_TARJETA'];
							$NUM_TARJETA = $row1['NUM_TARJETA'];
							$COD_EST_TARJETA = $row1['COD_EST_TARJETA'];
							$S2="SELECT * FROM MN_EST_TARJETA WHERE COD_EST_TARJETA=".$COD_EST_TARJETA;
							
							//$RS2 = sqlsrv_query($conn, $S2);
							////oci_execute($RS2);
							$RS2 = sqlsrv_query($conn,$S2);

							if ($row2 = sqlsrv_fetch_array($RS2)) {
								$DES_EST_TARJETA = $row2['DES_EST_TARJETA'];
								$COL_ESTADO = $row2['COL_ESTADO'];
								$CSF_ESTADO = $row2['CSF_ESTADO'];
							} 
							$STYLE_EST_TARJETA=" style='background-color:#".$COL_ESTADO.";".$CSF_ESTADO."' ";
							$FEC_ENTREGA = $row1['FEC_ENTREGA'];
							$FEC_ENTREGA = date_format($FEC_ENTREGA,"d-m-Y");
									$FEC_ENTREGA = strtotime($FEC_ENTREGA);
									$ANO_ENT = date("Y", $FEC_ENTREGA); 
									$MES_ENT = date("m", $FEC_ENTREGA); 
									$DIA_ENT = date("d", $FEC_ENTREGA); 
							$IDREG = $row1['IDREG'];
							$S2="SELECT NOMBRE FROM US_USUARIOS WHERE IDUSU=".$IDREG;
							
							//$RS2 = sqlsrv_query($maestra, $S2);
							////oci_execute($RS2);
							$RS2 = sqlsrv_query($maestra,$S2);

							if ($row2 = sqlsrv_fetch_array($RS2)) {
								$QUIENFUE = $row2['NOMBRE'];
							}	
							$FECHA = $row1['FECHA'];
						?>
                        <form action="reg_cliente_reg.php" method="post" name="formact" id="formact" onSubmit="return validaActTarjeta(this)">
                        <tr>
                            <td>
                                        <select id="COD_TIPO_TARJETA" name="COD_TIPO_TARJETA">
                                        		<option value="0">SELECCIONAR</option>
												 <?php
													$S3="SELECT * FROM MN_TIPO_TARJETA ORDER BY DES_TIPO_TARJETA ASC";
													
													//$RS3 = sqlsrv_query($conn, $S3);
													////oci_execute($RS3);
													$RS3 = sqlsrv_query($conn,$S3);
													
													while ($row3 = sqlsrv_fetch_array($RS3)) {
														$COD_TIPO_TARJETA2 = $row3['COD_TIPO_TARJETA'];
														$DES_TIPO_TARJETA = $row3['DES_TIPO_TARJETA'];
												?>
                                        		<option value="<?php echo $COD_TIPO_TARJETA2;?>" <?php if($COD_TIPO_TARJETA2==$COD_TIPO_TARJETA){ echo "SELECTED";}?>><?php echo $DES_TIPO_TARJETA;?></option>
												<?php
													}
												?>
                                        </select>
                            </td>
                            <td>
                            		<input style="margin:6px 0 0 0" name="NUM_TARJETA" type="text" size="16" maxlength="25" value="<?php echo $NUM_TARJETA;?>"></td>
                            <td>
                                    <input style="float:left; display:inline; margin:6px 0 0 0" name="DIA_ENT" type="text"  id="DIA_ENT" size="1" maxlength="2" onKeyPress="return acceptNum(event);" value="<?php echo $DIA_ENT;?>">
                                    <select style="float:left; display:inline; margin:6px 0 0 0"  name="MES_ENT"  id="MES_ENT">
                                            <option value="1" <?php if($MES_ENT==1){echo "SELECTED";}?>>Enero</option>
                                            <option value="2" <?php if($MES_ENT==2){echo "SELECTED";}?>>Febrero</option>
                                            <option value="3" <?php if($MES_ENT==3){echo "SELECTED";}?>>Marzo</option>
                                            <option value="4" <?php if($MES_ENT==4){echo "SELECTED";}?>>Abril</option>
                                            <option value="5" <?php if($MES_ENT==5){echo "SELECTED";}?>>Mayo</option>
                                            <option value="6" <?php if($MES_ENT==6){echo "SELECTED";}?>>Junio</option>
                                            <option value="7" <?php if($MES_ENT==7){echo "SELECTED";}?>>Julio</option>
                                            <option value="8" <?php if($MES_ENT==8){echo "SELECTED";}?>>Agosto</option>
                                            <option value="9" <?php if($MES_ENT==9){echo "SELECTED";}?>>Septiembre</option>
                                            <option value="10" <?php if($MES_ENT==10){echo "SELECTED";}?>>Octubre</option>
                                            <option value="11" <?php if($MES_ENT==11){echo "SELECTED";}?>>Noviembre</option>
                                            <option value="12" <?php if($MES_ENT==12){echo "SELECTED";}?>>Diciembre</option>
                                    </select>
                                    <input style="float:left; display:inline; margin:6px 0 0 0"  name="ANO_ENT" type="text"  id="ANO_ENT"  size="2" maxlength="4"  onKeyPress="return acceptNum(event);" value="<?php echo $ANO_ENT;?>">
                            </td>
                            <td <?php echo $STYLE_EST_TARJETA?>>
                                    <select id="COD_EST_TARJETA" name="COD_EST_TARJETA">
                                            <option value="0">SELECCIONAR</option>
                                             <?php
                                                $S3="SELECT * FROM MN_EST_TARJETA ORDER BY DES_EST_TARJETA ASC";
                                                
                                                //$RS3 = sqlsrv_query($conn, $S3);
                                                ////oci_execute($RS3);
                                                $RS3 = sqlsrv_query($conn,$S3);
                                                
                                                while ($row3 = sqlsrv_fetch_array($RS3)) {
                                                    $COD_EST_TARJETA2 = $row3['COD_EST_TARJETA'];
                                                    $DES_EST_TARJETA = $row3['DES_EST_TARJETA'];
                                            ?>
                                            <option value="<?php echo $COD_EST_TARJETA2;?>" <?php if($COD_EST_TARJETA2==$COD_EST_TARJETA){ echo "SELECTED";}?>><?php echo $DES_EST_TARJETA;?></option>
                                            <?php
                                                }
                                            ?>
                                    </select>
                            </td>
                            <td>
                           			<input style="margin:0" name="ACT_TARJETA" type="submit" value="Actualizar">
                                    <input name="COD_CLIENTE" type="hidden" value="<?php echo $COD_CLIENTE?>">
                                    <input name="COD_TARJETA" type="hidden" value="<?php echo $COD_TARJETA?>">
                            </td>
                            <td>
                            	<?php echo $QUIENFUE.", ".date_format($FECHA,"d-m-Y")?>
                            </td>
                        </tr>
                        </form>
                        <?php } ?>
                        <tr><td colspan="6"></td></tr>
                        </table>
                
                <?php } //FIN ACT_TRJ?>
                
<?php

		//sqlsrv_close($conn);
		//sqlsrv_close($maestra);
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );

}
?>
                </td>
                </tr>
                </table>
        </td>
        </tr>
        </table>
</td>
</tr>
</table>
<iframe name="frmHIDEN" width="0" height="0" frameborder="0" align="top" src="" framespacing="0" marginheight="0" marginwidth="0">
</iframe>
</body>
</html>

