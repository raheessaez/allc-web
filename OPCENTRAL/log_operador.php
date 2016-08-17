<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1168;
	$NOMENU=1;
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
if ($MSJE==1) {
$ELMSJ="No se han encontrado coincidencias, por favor, intente nuevamente";
} 
if ($MSJE==2) {
$ELMSJ="Fecha desde no v&aacute;lida, se retorna a fecha predeterminada";
} 
if ($MSJE==3) {
$ELMSJ="Fecha hasta no v&aacute;lida, se retorna a fecha predeterminada";
} 
if ($MSJE==4) {
$ELMSJ="Fecha hasta superior a fecha desde, verifique";
} 
if ($MSJE <> "") {
?>
<div id="GMessaje" onClick="QuitarGMessage();"><a href="#" onClick="QuitarGMessage();" style="color:#111111;"><?php echo $ELMSJ?></a></div>
<?php }?>
        <table width="100%">
        <tr><td>
		<?php 

				$BSC=@$_GET["BSC"];
				$VERTND_UNO = 0;
				$COD_NEGOCIO_SEL=@$_POST["COD_NEGOCIO"];
				if(empty($COD_NEGOCIO_SEL)) { $COD_NEGOCIO_SEL=@$_GET["COD_NEGOCIO"];}
				$COD_TIENDA_SEL=@$_POST["COD_TIENDA"];
				if(empty($COD_TIENDA_SEL)) { $COD_TIENDA_SEL=@$_GET["COD_TIENDA"];}
				//VERIFICAR TIENDAS ASOCIADAS A USUARIO
				$SQL="SELECT COUNT(COD_TIENDA) AS CTATND FROM US_USUTND WHERE IDUSU=".$SESIDUSU;
				$RS = sqlsrv_query($maestra, $SQL);
				//oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {
					$CTATND = $row['CTATND'];
				}
				//SI CTATND==0 USUARIO CENTRAL, SELECCIONAR NEGOCIO Y LOCAL
				//SI CTATND==1 DESPLEGAR LOCAL
				//SI CTATND>1 DESPLEGAR LISTADO DE LOCALES
				if($CTATND==1){
						//OBTENER NEGOCIO
						$SQL="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO IN(SELECT COD_NEGOCIO FROM US_USUTND WHERE IDUSU=".$SESIDUSU.")";
						$RS = sqlsrv_query($maestra, $SQL);
						//oci_execute($RS);
						if ($row = sqlsrv_fetch_array($RS)) {
							$COD_NEGOCIO_SEL = $row['COD_NEGOCIO'];
						}
						//OBTENER TIENDA
						$SQL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA IN(SELECT COD_TIENDA FROM US_USUTND WHERE IDUSU=".$SESIDUSU.")";
						$RS = sqlsrv_query($maestra, $SQL);
						//oci_execute($RS);
						if ($row = sqlsrv_fetch_array($RS)) {
							$COD_TIENDA_SEL = $row['COD_TIENDA'];
						}
				} else { //MAS DE UNA TIENDA, MAS DE UN NEGOCIO
						//VERIFICAR MÁS DE UN NEGOCIO
						//CUENTA NEGOCIOS
							$SQL="SELECT COUNT(*) AS CTANEG FROM US_USUTND where COD_NEGOCIO IN(SELECT COD_NEGOCIO FROM US_USUTND WHERE IDUSU=".$SESIDUSU." GROUP BY COD_NEGOCIO) ";
							$RS = sqlsrv_query($maestra, $SQL);
							//oci_execute($RS);
							if ($row = sqlsrv_fetch_array($RS)) {
								$CTANEG = $row['CTANEG'];
							}
							if($CTANEG==1){ //UN UNICO NEGOCIO
									//OBTENER NEGOCIO
									$SQL1="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO IN(SELECT COD_NEGOCIO FROM US_USUTND WHERE IDUSU=".$SESIDUSU.") ";
									$RS1 = sqlsrv_query($maestra, $SQL1);
									//oci_execute($RS1);
									if ($row1 = sqlsrv_fetch_array($RS1)) {
										$COD_NEGOCIO_SEL = $row1['COD_NEGOCIO'];
									}
							}
						
				}
				
				
				
				
				
				
				if(empty($COD_NEGOCIO_SEL)){ $COD_NEGOCIO_SEL=0; }
				if(empty($COD_TIENDA_SEL)){ $COD_TIENDA_SEL=0; }
				
				if(empty($BSC)){
						//SI CTATND==0 USUARIO CENTRAL, SELECCIONAR NEGOCIO Y LOCAL
						if($CTATND==0){
								$FILTRO_NEG=" ";
								$FILTRO_TND=" ";
						}
						//SI CTATND==1 DESPLEGAR LOCAL
						if($CTATND==1){
								$FILTRO_NEG=" AND COD_NEGOCIO=".$COD_NEGOCIO_SEL." ";
								$FILTRO_TND=" AND COD_TIENDA=".$COD_TIENDA_SEL." ";
						}
						//SI CTANEG==1 DESPLEGAR NEGOCIO
						if($CTANEG==1){
								$FILTRO_NEG=" AND COD_NEGOCIO=".$COD_NEGOCIO_SEL." ";
								$FILTRO_TND=" ";
						}
				}
		
				if(!empty($BSC)){
					if($COD_NEGOCIO_SEL<>0){
							$FILTRO_NEG=" AND COD_NEGOCIO=".$COD_NEGOCIO_SEL." ";
					} else {
							$FILTRO_NEG="";
					}
					if($COD_TIENDA_SEL<>0){
							$FILTRO_TND=" AND COD_TIENDA=".$COD_TIENDA_SEL." ";
					} else {
							$FILTRO_TND="";
					}
				}
				
				
	$FILTRO_NOMB="";
	$BOPERA=trim(strtoupper(@$_POST["BOPERA"]));
	if (empty($BOPERA)) { $BOPERA=trim(strtoupper(@$_GET["BOPERA"])) ;}
	$BOPCION=@$_POST["BOPCION"];
	if (empty($BOPCION)) { $BOPCION=@$_GET["BOPCION"];}
	if (empty($BOPCION)) { $BOPCION=2;}
	if ($BOPCION==1) {
			if ($BOPERA<>"") {$FILTRO_NOMB=" AND ID_OPERADOR IN(SELECT ID_OPERADOR FROM OP_OPERADOR WHERE (UPPER(dbo.TRIM(NOMBRE)) Like '%".strtoupper($BOPERA)."%' OR UPPER(dbo.TRIM(APELLIDO_P)) Like '%".strtoupper($BOPERA)."%' OR UPPER(dbo.TRIM(APELLIDO_M)) Like '%".strtoupper($BOPERA)."%') )"; }
	} 
	if ($BOPCION==2) {
			if ($BOPERA<>"") {$FILTRO_NOMB=" AND CC_OPERADOR Like '%".strtoupper($BOPERA)."%' "; }
	} 

		$B_FECHA_E=@$_POST["B_FECHA_E"];
			if (empty($B_FECHA_E)) { $B_FECHA_E=@$_GET["B_FECHA_E"]; }
					//CALCULAR MINIMO Y MÁXIMO FECHA REGISTRO
					$CONSULTA2="SELECT MIN(FECHA) AS MFECHA FROM OP_OPERAMOV";
					$RS2 = sqlsrv_query($conn, $CONSULTA2);
					//oci_execute($RS2);
					if ($row = sqlsrv_fetch_array($RS2)){
							$MIN_FECHA_EMS = $row['MFECHA'];
							@$date = date_create($MIN_FECHA_EMS);
							$MIN_FECHA_EMS = @date_format($date, 'd/m/Y');

					}
					$CONSULTA2="SELECT MAX(FECHA) AS MFECHA FROM OP_OPERAMOV";
					$RS2 = sqlsrv_query($conn, $CONSULTA2);
					//oci_execute($RS2);
					if ($row = sqlsrv_fetch_array($RS2)){
							$MAX_FECHA_EMS = $row['MFECHA'];
							@$date = date_create($MAX_FECHA_EMS);
							$MAX_FECHA_EMS = @date_format($date, 'd/m/Y');

					}
					if (empty($MIN_FECHA_EMS)) { $MIN_FECHA_EMS=date('d/m/Y'); }
					if (empty($MAX_FECHA_EMS)) { $MAX_FECHA_EMS=date('d/m/Y'); }
					//FECHA REGISTRO DESDE
					$DIA_ED=@$_POST["DIA_ED"];
					if (empty($DIA_ED)) { $DIA_ED=@$_GET["DIA_ED"]; }
					if (empty($DIA_ED)) { $DIA_ED=substr($MIN_FECHA_EMS, 0, 2); }
					$MES_ED=@$_POST["MES_ED"];
					if (empty($MES_ED)) { $MES_ED=@$_GET["MES_ED"]; }
					if (empty($MES_ED)) { $MES_ED=substr($MIN_FECHA_EMS, 3, 2); }
					$ANO_ED=@$_POST["ANO_ED"];
					if (empty($ANO_ED)) { $ANO_ED=@$_GET["ANO_ED"]; }
					if (empty($ANO_ED)) { $ANO_ED='20'.substr($MIN_FECHA_EMS, -2); }
					//FECHA REGISTRO HASTA
					$DIA_EH=@$_POST["DIA_EH"];
					if (empty($DIA_EH)) { $DIA_EH=@$_GET["DIA_EH"]; }
					if (empty($DIA_EH)) { $DIA_EH=substr($MAX_FECHA_EMS, 0, 2); }
					$MES_EH=@$_POST["MES_EH"];
					if (empty($MES_EH)) { $MES_EH=@$_GET["MES_EH"]; }
					if (empty($MES_EH)) { $MES_EH=substr($MAX_FECHA_EMS, 3, 2); }
					$ANO_EH=@$_POST["ANO_EH"];
					if (empty($ANO_EH)) { $ANO_EH=@$_GET["ANO_EH"]; }
					if (empty($ANO_EH)) { $ANO_EH='20'.substr($MAX_FECHA_EMS, -2); }
					//CONSTRUYE FECHAS REGISTRO
					//VALIDAR FECHA_ED
					if (checkdate($MES_ED, $DIA_ED, $ANO_ED)==false) { 
						$MSJE=2 ;
						$DIA_ED=substr($MIN_FECHA_EMS, 0, 2);
						$MES_ED=substr($MIN_FECHA_EMS, 3, 2);
						$ANO_ED='20'.substr($MIN_FECHA_EMS, -2);
						$DIA_EH=substr($MAX_FECHA_EMS, 0, 2);
						$MES_EH=substr($MAX_FECHA_EMS, 3, 2);
						$ANO_EH='20'.substr($MAX_FECHA_EMS, -2);
					}
					$DIA_ED=substr('00'.$DIA_ED, -2);
					$MES_ED=substr('00'.$MES_ED, -2);
					$FECHA_ED=$DIA_ED."/".$MES_ED."/".$ANO_ED;
					if (checkdate($MES_EH, $DIA_EH, $ANO_EH)==false) { 
						$MSJE=3 ;
						$DIA_ED=substr($MIN_FECHA_EMS, 0, 2);
						$MES_ED=substr($MIN_FECHA_EMS, 3, 2);
						$ANO_ED='20'.substr($MIN_FECHA_EMS, -2);
						$DIA_EH=substr($MAX_FECHA_EMS, 0, 2);
						$MES_EH=substr($MAX_FECHA_EMS, 3, 2);
						$ANO_EH='20'.substr($MAX_FECHA_EMS, -2);
					}
					$DIA_EH=substr('00'.$DIA_EH, -2);
					$MES_EH=substr('00'.$MES_EH, -2);
					$FECHA_EH=$DIA_EH."/".$MES_EH."/".$ANO_EH;
		//FILTRO FECHA REGISTRO
					if (empty($B_FECHA_E)) {
							$F_FECHA=" ";
					} else {
							$F_FECHA=" AND (convert(datetime,FECHA, 111) >= '".$ANO_ED.'/'.$MES_ED.'/'.$DIA_ED."') AND (convert(datetime,FECHA, 111) <='".$ANO_EH.'/'.$MES_EH.'/'.$DIA_EH."')"; 
					}
		?>
        <table width="100%" id="Filtro">
        <form action="log_operador.php?BSC=1&B_FECHA_E=<?php echo $B_FECHA_E ?>&DIA_ED=<?php echo $DIA_ED ?>&MES_ED=<?php echo $MES_ED ?>&ANO_ED=<?php echo $ANO_ED ?>&DIA_EH=<?php echo $DIA_EH ?>&MES_EH=<?php echo $MES_EH ?>&ANO_EH=<?php echo $ANO_EH ?>&COD_NEGOCIO=<?php echo $COD_NEGOCIO_SEL ?>&COD_TIENDA=<?php echo $COD_TIENDA_SEL ?>" method="post" name="forming" id="forming">
            <tr>
            <td>
                      <label for="FECHA_EM_D" >Fecha desde: </label>
                      <input name="DIA_ED" type="text"  id="DIA_ED" value="<?php echo $DIA_ED ?>" size="2" maxlength="2" onKeyPress="return acceptNum(event);">
                     <select name="MES_ED" class="texto08" id="MES_ED">
                            <option value="01" <?php  if ($MES_ED==1) { echo "SELECTED";}?>>Enero</option>
                            <option value="02" <?php  if ($MES_ED==2) { echo "SELECTED";}?>>Febrero</option>
                            <option value="03" <?php  if ($MES_ED==3) { echo "SELECTED";}?>>Marzo</option>
                            <option value="04" <?php  if ($MES_ED==4) { echo "SELECTED";}?>>Abril</option>
                            <option value="05" <?php  if ($MES_ED==5) { echo "SELECTED";}?>>Mayo</option>
                            <option value="06" <?php  if ($MES_ED==6) { echo "SELECTED";}?>>Junio</option>
                            <option value="07" <?php  if ($MES_ED==7) { echo "SELECTED";}?>>Julio</option>
                            <option value="08" <?php  if ($MES_ED==8) { echo "SELECTED";}?>>Agosto</option>
                            <option value="09" <?php  if ($MES_ED==9) { echo "SELECTED";}?>>Septiembre</option>
                            <option value="10" <?php  if ($MES_ED==10) { echo "SELECTED";}?>>Octubre</option>
                            <option value="11" <?php  if ($MES_ED==11) { echo "SELECTED";}?>>Noviembre</option>
                            <option value="12" <?php  if ($MES_ED==12) { echo "SELECTED";}?>>Diciembre</option>
                       </select>
                       <input name="ANO_ED" type="text" id="ANO_ED" value="<?php echo $ANO_ED ?>" size="4" maxlength="4">
                      <label for="FECHA_EM_H">hasta</label>
                      <input name="DIA_EH" type="text"  id="DIA_EH" value="<?php echo $DIA_EH ?>" size="2" maxlength="2" onKeyPress="return acceptNum(event);">
                      <select name="MES_EH" id="MES_EH">
                            <option value="01" <?php  if ($MES_EH==1) { echo "SELECTED";}?>>Enero</option>
                            <option value="02" <?php  if ($MES_EH==2) { echo "SELECTED";}?>>Febrero</option>
                            <option value="03" <?php  if ($MES_EH==3) { echo "SELECTED";}?>>Marzo</option>
                            <option value="04" <?php  if ($MES_EH==4) { echo "SELECTED";}?>>Abril</option>
                            <option value="05" <?php  if ($MES_EH==5) { echo "SELECTED";}?>>Mayo</option>
                            <option value="06" <?php  if ($MES_EH==6) { echo "SELECTED";}?>>Junio</option>
                            <option value="07" <?php  if ($MES_EH==7) { echo "SELECTED";}?>>Julio</option>
                            <option value="08" <?php  if ($MES_EH==8) { echo "SELECTED";}?>>Agosto</option>
                            <option value="09" <?php  if ($MES_EH==9) { echo "SELECTED";}?>>Septiembre</option>
                            <option value="10" <?php  if ($MES_EH==10) { echo "SELECTED";}?>>Octubre</option>
                            <option value="11" <?php  if ($MES_EH==11) { echo "SELECTED";}?>>Noviembre</option>
                            <option value="12" <?php  if ($MES_EH==12) { echo "SELECTED";}?>>Diciembre</option>
                            </select>
                    <input name="ANO_EH" type="text" id="ANO_EH" value="<?php echo $ANO_EH ?>" size="4" maxlength="4" onKeyPress="return acceptNum(event);">
                    <input name="B_FECHA_E" type="submit" id="B_FECHA_E" value="Filtrar">
                                                <select  style="clear:left" name="COD_NEGOCIO" onChange="CargaTienda(this.value, this.form.name, 'COD_TIENDA')">
                                                                <option value="0">SELECCIONAR NEGOCIO</option>
                                                                <?php 
                                                                $SQL="SELECT * FROM MN_NEGOCIO ORDER BY DES_NEGOCIO ASC";
                                                                $RS = sqlsrv_query($maestra, $SQL);
                                                                //oci_execute($RS);
                                                                while ($row = sqlsrv_fetch_array($RS)) {
                                                                    $COD_NEGOCIO = $row['COD_NEGOCIO'];
                                                                    $DES_NEGOCIO = $row['DES_NEGOCIO'];
                                                                 ?>
                                                                <option value="<?php echo $COD_NEGOCIO ?>" <?php if($COD_NEGOCIO==$COD_NEGOCIO_SEL) {echo "Selected";} ?>><?php echo $DES_NEGOCIO ?></option>
                                                                <?php 
                                                                }
                                                                 ?>
                                                </select>
                                                <select  id="COD_TIENDA" name="COD_TIENDA" onChange="document.forms.forming.submit();">
                                                    <option value="0">SELECCIONAR TIENDA</option>
                                                    <?php
                                                    if(!empty($COD_TIENDA_SEL)){
                                                                $SQL="SELECT COD_TIENDA, DES_TIENDA, DES_CLAVE FROM MN_TIENDA WHERE COD_TIENDA IN(SELECT COD_TIENDA FROM MN_NEGTND WHERE COD_NEGOCIO=".$COD_NEGOCIO_SEL.")   ORDER BY DES_CLAVE ASC";
                                                                $RS = sqlsrv_query($maestra, $SQL);
                                                                //oci_execute($RS);
                                                                $VERTND=0;
                                                                while ($row = sqlsrv_fetch_array($RS)) {
                                                                    $NUM_TIENDA = $row['DES_CLAVE'];
                                                                    $NUM_TIENDA_F="0000".$NUM_TIENDA;
                                                                    $NUM_TIENDA_F=substr($NUM_TIENDA_F, -4); 
                                                                    $STRDES = $row['DES_TIENDA'];
                                                                    $STRCOD =$row['COD_TIENDA'];
                                                                 ?>
                                                                        <option value="<?php echo $STRCOD ?>" <?php if($STRCOD==$COD_TIENDA_SEL) {echo "Selected";} ?> ><?php echo $NUM_TIENDA_F." - ".$STRDES ?></option>
                                                                <?php 
                                                                }
                                                    }
                                                    ?>
                                                </select>
                                        <?php
                        ?>

                           <input style="clear:left" name="BOPERA" type="text" id="BOPERA" size="12" value="<?php echo $BOPERA ?>">
                           <input type="radio" name="BOPCION" value="2" <?php if($BOPCION==2) {?> checked <?php }?>>
                           <label for="BOPCION2">C&oacute;digo</label>
                           <input type="radio" name="BOPCION" value="1"  <?php if($BOPCION==1) {?> checked <?php }?>>
                           <label for="BOPCION1">Nombre</label>
                           <input name="BUSCAR" type="submit" id="BUSCAR" value="Buscar Operador">
                           <input name="LIMPIAR" type="button" id="LIMPIAR" value="Limpiar" onClick="javascript:pagina('log_operador.php')">
              </td>
              </tr>
            </form>
              </table>
                <table style="margin:10px 20px; ">
                <tr>
                <td>
                <?php
				$CONSULTA="SELECT COUNT(*) AS CUENTA FROM OP_OPERAMOV  WHERE IDMOV<>0 ".$F_FECHA.$FILTRO_NEG.$FILTRO_TND.$FILTRO_NOMB." ";
				$RS = sqlsrv_query($conn, $CONSULTA);
				//oci_execute($RS);
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
				if ($TOTALREG>=1) { 
				//$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM OP_OPERAMOV WHERE IDMOV<>0 ".$F_FECHA.$FILTRO_NEG.$FILTRO_TND.$FILTRO_NOMB." ORDER BY IDMOV DESC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;
				
				//oci_execute($RS);

					$CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY IDMOV DESC) ROWNUMBER FROM OP_OPERAMOV WHERE IDMOV<>0 ".$F_FECHA.$FILTRO_NEG.$FILTRO_TND.$FILTRO_NOMB.") AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";

				  $RS = sqlsrv_query($conn, $CONSULTA);
               ?>
                <table id="Listado">
                <tr>
                    <th>Operador</th>
                    <th>Negocio/ Tienda</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>IP Usuario</th>
                    <th>Usuario</th>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){
                        $IDMOV = $row['IDMOV'];
                        $ID_OPERADOR = $row['ID_OPERADOR'];
						$STR_ESTADO = $row['STR_ESTADO'];
						$REG_ESTADO = $row['REG_ESTADO'];
						if ($REG_ESTADO==0) {
							$ELESTADO="Bloqueado"; 
							$TDESTADO="#F44336";
							}
						if ($REG_ESTADO==1) {
							$ELESTADO="Activo"; 
							$TDESTADO="#4CAF50";
							}


                        $CC_OPERADOR = $row['CC_OPERADOR'];
                        $COD_NEGOCIO = $row['COD_NEGOCIO'];
                        $COD_TIENDA = $row['COD_TIENDA'];
                        @$ID_MODAUTORIZA = $row['ID_MODAUTORIZA'];
                        $IDREG = $row['IDREG'];
                        $FECHA = $row['FECHA'];
                        $HORA = $row['HORA'];
                        $IP_CLIENTE = $row['IP_CLIENTE'];
						
						$CONSULTA2="SELECT * FROM OP_OPERADOR WHERE ID_OPERADOR=".$ID_OPERADOR;
						$RS2 = sqlsrv_query($conn, $CONSULTA2);
						//oci_execute($RS2);
						if ($row = sqlsrv_fetch_array($RS2)){
							$NOMBOPERA=$row['APELLIDO_P']." ".$row['APELLIDO_M'].", ".$row['NOMBRE'];
						}


						if($BOPCION==1) {
								$NOMBOPERA=str_replace(strtoupper($BOPERA),'<span style="background-color:#FFF9C4;">'.strtoupper($BOPERA).'</span>', strtoupper($NOMBOPERA)); 
						}

						if($BOPCION==2) {
								$CC_OPERADOR=str_replace($BOPERA,'<span style="background-color:#FFF9C4;">'.$BOPERA.'</span>', $CC_OPERADOR); 
						}


						$CONSULTA2="SELECT DES_NEGOCIO FROM MN_NEGOCIO WHERE COD_NEGOCIO=".$COD_NEGOCIO;
						$RS2 = sqlsrv_query($maestra, $CONSULTA2);
						//oci_execute($RS2);
						if ($row = sqlsrv_fetch_array($RS2)){
							$DES_NEGOCIO=$row['DES_NEGOCIO'];
						}
						$CONSULTA2="SELECT * FROM MN_TIENDA WHERE DES_CLAVE=".$COD_TIENDA;
						$RS2 = sqlsrv_query($maestra, $CONSULTA2);
						//oci_execute($RS2);
						if ($row = sqlsrv_fetch_array($RS2)){
							$TIENDA=$row['DES_CLAVE']." - ".$row['DES_TIENDA'];
						}
						$CONSULTA2="SELECT DESCRIPCION FROM OP_MODAUTORIZA WHERE ID_MODAUTORIZA=".$ID_MODAUTORIZA;
						$RS2 = sqlsrv_query($conn, $CONSULTA2);
						//oci_execute($RS2);
						if ($row = @sqlsrv_fetch_array($RS2)){
							@$PERFIL=$row['DESCRIPCION'];
						}
						if ($IDREG==0) {
							$NOMB_USUARIO = "Proceso de Sistema";
						} else {
							$CONSULTA2="SELECT NOMBRE FROM US_USUARIOS WHERE IDUSU=".$IDREG;
							$RS2 = sqlsrv_query($maestra, $CONSULTA2);
							//oci_execute($RS2);
							if ($row = sqlsrv_fetch_array($RS2)){
									$NOMB_USUARIO = $row['NOMBRE'];
							}
						}
               ?>
                <tr>
                    <td><?php echo $NOMBOPERA."<BR>C&oacute;digo: ".$CC_OPERADOR ?></td>
                    <td><?php echo $DES_NEGOCIO."<BR>".$TIENDA ?></td>
                    <td style="background:<?php echo $TDESTADO?>; color:#FFF"><?php echo $ELESTADO?></td>
                    <td><?php echo date_format($FECHA,"Y-m-d"); ?></td>
                    <td><?php echo $HORA ?></td>
                    <td><?php echo $IP_CLIENTE ?></td>
                    <td><?php echo $NOMB_USUARIO ?></td>
                </tr>
                <?php
				}
				?>
                <tr>
                    <td colspan="7" nowrap style="background-color:transparent">
                    <?php
                    if ($LINF>=$CTP+1) {
						$ATRAS=$LINF-$CTP;
						$FILA_ANT=$LSUP-$CTP;
                   ?>
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('log_operador.php?LSUP=<?php echo $FILA_ANT?>&LINF=<?php echo $ATRAS?>&B_FECHA_E=<?php echo $B_FECHA_E ?>&DIA_ED=<?php echo $DIA_ED ?>&MES_ED=<?php echo $MES_ED ?>&ANO_ED=<?php echo $ANO_ED ?>&DIA_EH=<?php echo $DIA_EH ?>&MES_EH=<?php echo $MES_EH ?>&ANO_EH=<?php echo $ANO_EH ?>&COD_NEGOCIO=<?php echo $COD_NEGOCIO_SEL ?>&COD_TIENDA=<?php echo $COD_TIENDA_SEL ?>&BSC=<?php echo $BSC ?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('log_operador.php?LSUP=<?php echo $FILA_POS?>&LINF=<?php echo $ADELANTE?>&B_FECHA_E=<?php echo $B_FECHA_E ?>&DIA_ED=<?php echo $DIA_ED ?>&MES_ED=<?php echo $MES_ED ?>&ANO_ED=<?php echo $ANO_ED ?>&DIA_EH=<?php echo $DIA_EH ?>&MES_EH=<?php echo $MES_EH ?>&ANO_EH=<?php echo $ANO_EH ?>&COD_NEGOCIO=<?php echo $COD_NEGOCIO_SEL ?>&COD_TIENDA=<?php echo $COD_TIENDA_SEL ?>&BSC=<?php echo $BSC ?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina <?php echo $NUMPAG?> de <?php echo $NUMTPAG?></span>
                    </td>
                </tr>
                </table>
                <?php
				}//if ($TOTALREG>=1) 
				?>
                </td>
                </tr>
                </table>
        </td>
        </tr>
        <tr>
        <td>
        <iframe name="frmHIDEN" width="0%" height="0" frameborder="0" align="top" src="" framespacing="0" marginheight="0" marginwidth="0">
        </iframe>
        </td>
        </tr>  
        </table>
</td>
</tr>
</table>
</body>
</html>