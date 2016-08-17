<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1104;
	$NOMENU=1;

	$LSUP=@$_GET["LSUP"];
	if ($LSUP=="") {
		$LSUP=$CTP;
	}
	$LINF=@$_GET["LINF"];
	if ($LINF=="") {
		$LINF=1;
	}
	$MSJE=@$_GET["MSJE"];

				$FLT_SIS="";
				$BSC_SISTEMA=@$_POST["BSC_SISTEMA"];
				if (empty($BSC_SISTEMA)) {$BSC_SISTEMA=@$_GET["BSC_SISTEMA"];}
				if (empty($BSC_SISTEMA)) {$BSC_SISTEMA=0;}
				if ($BSC_SISTEMA!=0) {
					$FLT_SIS=" AND IDSISTEMA=".$BSC_SISTEMA;
					}
				$FLT_TIPO="";
				$BSC_TIPO=@$_POST["BSC_TIPO"];
				if (empty($BSC_TIPO)) {$BSC_TIPO=@$_GET["BSC_TIPO"];}
				if (empty($BSC_TIPO)) {$BSC_TIPO=0;}
				if ($BSC_TIPO!=0) {
					$FLT_TIPO=" AND COD_TIPO_EVENTO=".$BSC_TIPO;
					}
				$FLT_USUARIO="";
				$BSC_USUARIO=@$_POST["BSC_USUARIO"];
				if (empty($BSC_USUARIO)) {$BSC_USUARIO=@$_GET["BSC_USUARIO"];}
				if (empty($BSC_USUARIO)) {$BSC_USUARIO=0;}
				if ($BSC_USUARIO!=0) {
					$FLT_USUARIO=" AND COD_USUARIO=".$BSC_USUARIO;
					}
				$FLT_MODULO="";
				$BSC_MODULO=@$_POST["BSC_MODULO"];
				if (empty($BSC_MODULO)) {$BSC_MODULO=@$_GET["BSC_MODULO"];}
				if (empty($BSC_MODULO)) {$BSC_MODULO=0;}
				if ($BSC_MODULO!=0) {
					$FLT_MODULO=" AND IDACC=".$BSC_MODULO;
					}
			$B_FECHA_E=@$_POST["B_FECHA_E"];
			if (empty($B_FECHA_E)) { $B_FECHA_E=@$_GET["B_FECHA_E"]; }
					//CALCULAR MINIMO Y MÁXIMO FECHA REGISTRO
					$CONSULTA2="SELECT MIN(FECHA) AS MFECHA FROM LG_EVENTO";

					//$RS2 = sqlsrv_query($conn, $CONSULTA2);
					////oci_execute($RS2);
					$RS2 = sqlsrv_query($conn,$CONSULTA2);

					if ($row = sqlsrv_fetch_array($RS2)){

							$MIN_FECHA_EMS = $row['MFECHA'];
							$MIN_FECHA_EMS = @date_format($MIN_FECHA_EMS, 'd/m/Y');
					}

					$CONSULTA2="SELECT MAX(FECHA) AS MFECHA FROM LG_EVENTO";
					
					//$RS2 = sqlsrv_query($conn, $CONSULTA2);
					////oci_execute($RS2);

					$RS2 = sqlsrv_query($conn,$CONSULTA2);

					if ($row = sqlsrv_fetch_array($RS2)){
							$MAX_FECHA_EMS = $row['MFECHA'];
							$MAX_FECHA_EMS = @date_format($MAX_FECHA_EMS, 'd/m/Y');
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
							
							$F_FECHA=" AND Convert(varchar(20), FECHA, 111) >= '".$ANO_ED.'/'.$MES_ED.'/'.$DIA_ED."' AND Convert(varchar(20), FECHA, 111) <='".$ANO_EH.'/'.$MES_EH.'/'.$DIA_EH."'";
					}
		?>
<SCRIPT LANGUAGE="JavaScript">
		function autoRefresh() {
			parent.location.href="log_accesos.php?LSUP=<?=$LSUP?>&LINF=<?=$LINF?>&BSC_TIPO=<?=$BSC_TIPO ?>&BSC_SISTEMA=<?=$BSC_SISTEMA ?>&BSC_USUARIO=<?=$BSC_USUARIO ?>&BSC_MODULO=<?=$BSC_MODULO ?>&B_FECHA_E=<?=$B_FECHA_E ?>&DIA_ED=<?=$DIA_ED ?>&MES_ED=<?=$MES_ED ?>&ANO_ED=<?=$ANO_ED ?>&DIA_EH=<?=$DIA_EH ?>&MES_EH=<?=$MES_EH ?>&ANO_EH=<?=$ANO_EH ?>";
		}
		
		function refreshAdv(refreshTime,refreshColor) {
		   setTimeout('autoRefresh()',refreshTime)
		}
</SCRIPT>

</head>
<body onLoad="refreshAdv(30000,'#FFFFFF');">
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
<div id="GMessaje" onClick="QuitarGMessage();"><a href="#" onClick="QuitarGMessage();" style="color:#111111;"><?=$ELMSJ?></a></div>
<?php }?>
        <table width="100%">
        <tr><td>
        <table width="100%" id="Filtro">
          <tr>
            <td>
                <form action="log_accesos.php?B_FECHA_E=<?=$B_FECHA_E; ?>&DIA_ED=<?=$DIA_ED; ?>&MES_ED=<?=$MES_ED; ?>&ANO_ED=<?=$ANO_ED; ?>&DIA_EH=<?=$DIA_EH; ?>&MES_EH=<?=$MES_EH; ?>&ANO_EH=<?=$ANO_EH; ?>" method="post" name="frmbuscar" id="frmbuscar">
                                <select name="BSC_SISTEMA" onChange="document.forms.frmbuscar.submit();">
                                            <option value="0">Sistema</option>
											<?php 
                                            $SQLFILTRO="SELECT * FROM US_SISTEMA WHERE IDSISTEMA IN(SELECT IDSISTEMA FROM LG_EVENTO) ORDER BY NOMBRE ASC";
                                            
                                            //$RS = sqlsrv_query($conn, $SQLFILTRO);
                                            ////oci_execute($RS);

                                            $RS = sqlsrv_query($conn,$SQLFILTRO);
                                            
                                            while ($row = sqlsrv_fetch_array($RS)) {
                                                $FLTIDSIS = $row['IDSISTEMA'];
                                                $FLTNOMB_SIS = $row['NOMBRE'];
                                             ?>
                                            <option value="<?=$FLTIDSIS ?>" <?php  if ($FLTIDSIS==$BSC_SISTEMA) { echo "SELECTED";}?>><?=$FLTNOMB_SIS ?></option>
                                            <?php 
                                            }
                                             ?>
                            </select>
                                <select name="BSC_TIPO" onChange="document.forms.frmbuscar.submit();">
                                            <option value="0">Acci&oacute;n</option>
											<?php 
                                            $SQLFILTRO="SELECT * FROM LG_TIPO_EVENTO WHERE COD_TIPO_EVENTO IN(SELECT COD_TIPO_EVENTO AS COD_TIPO_EVENTO FROM LG_EVENTO) ORDER BY DES_TIPO_EVENTO ASC";
                                            
                                            //$RS = sqlsrv_query($conn, $SQLFILTRO);
                                            ////oci_execute($RS);
                                            $RS = sqlsrv_query($conn,$SQLFILTRO);

                                            while ($row = sqlsrv_fetch_array($RS)) {
                                                $FLTIDTIPO = $row['COD_TIPO_EVENTO'];
                                                $FLTDES_TIPO = $row['DES_TIPO_EVENTO'];
                                             ?>
                                            <option value="<?=$FLTIDTIPO ?>" <?php  if ($FLTIDTIPO==$BSC_TIPO) { echo "SELECTED";}?>><?=$FLTDES_TIPO ?></option>
                                            <?php 
                                            }
                                             ?>
                            </select>
                                <select name="BSC_MODULO" onChange="document.forms.frmbuscar.submit();">
                                            <option value="0">M&oacute;dulo</option>
											<?php 
											if($BSC_SISTEMA==0){
													$SQLFILTRO="SELECT * FROM US_ACCESO WHERE IDACC IN(SELECT IDACC FROM LG_EVENTO) ORDER BY NOMBRE ASC";
											} else {
													$SQLFILTRO="SELECT * FROM US_ACCESO WHERE IDSISTEMA=".$BSC_SISTEMA." AND IDACC IN(SELECT IDACC FROM LG_EVENTO) ORDER BY NOMBRE ASC";
											}

                                            //$RS = sqlsrv_query($conn, $SQLFILTRO);
                                            ////oci_execute($RS);
                                            $RS = sqlsrv_query($conn,$SQLFILTRO);

                                            while ($row = sqlsrv_fetch_array($RS)) {
                                                $FLTIDACC = $row['IDACC'];
                                                $FLTDES_MODULO = $row['NOMBRE'];
                                             ?>
                                            <option value="<?=$FLTIDACC ?>" <?php  if ($FLTIDACC==$BSC_MODULO) { echo "SELECTED";}?>><?=$FLTDES_MODULO ?></option>
                                            <?php 
                                            }
                                             ?>
                            </select>
                                <select name="BSC_USUARIO" onChange="document.forms.frmbuscar.submit();">
                                            <option value="0">Usuario</option>
											<?php 
                                            $SQLFILTRO="SELECT * FROM US_USUARIOS WHERE IDUSU IN(SELECT COD_USUARIO AS IDUSU FROM LG_EVENTO) ORDER BY NOMBRE ASC";
                                            
                                            //$RS = sqlsrv_query($conn, $SQLFILTRO);
                                            ////oci_execute($RS);
                                             $RS = sqlsrv_query($conn,$SQLFILTRO);
                                            
                                            while ($row = sqlsrv_fetch_array($RS)) {
                                                $FLTIDUSU = $row['IDUSU'];
                                                $FLTNOMB_USUARIO = $row['NOMBRE'];
                                             ?>
                                            <option value="<?=$FLTIDUSU ?>" <?php  if ($FLTIDUSU==$BSC_USUARIO) { echo "SELECTED";}?>><?=$FLTNOMB_USUARIO ?>
                                            </option>
                                            <?php 
                                            }
                                             ?>
                            </select>
                           <input name="LIMPIAR" type="button" id="LIMPIAR" value="Limpiar" onClick="javascript:pagina('log_accesos.php')">
                          				      <label for="FECHA_EM_D" style="clear:left">Fecha desde: </label>
                                              <input name="DIA_ED" type="text" class="texto08" id="DIA_ED" value="<?=$DIA_ED ?>" size="2" maxlength="2" onKeyPress="return acceptNum(event);">
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
                                               <input name="ANO_ED" type="text" class="texto08" id="ANO_ED" value="<?=$ANO_ED ?>" size="4" maxlength="4">
                                              <label for="FECHA_EM_H">hasta</label>
                          				      <input name="DIA_EH" type="text" class="texto08" id="DIA_EH" value="<?=$DIA_EH ?>" size="2" maxlength="2" onKeyPress="return acceptNum(event);">
                          				      <select name="MES_EH" class="texto08" id="MES_EH">
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
                          				        <input name="ANO_EH" type="text" class="texto08" id="ANO_EH" value="<?=$ANO_EH ?>" size="4" maxlength="4" onKeyPress="return acceptNum(event);">
                       				            <input name="B_FECHA_E" type="submit" class="texto08" id="B_FECHA_E" value="Filtrar">
                </form>
              </td>
              </tr>
              </table>
                <table style="margin:10px 20px; ">
                <tr>
                <td>
                <?php
				$CONSULTA="SELECT COUNT(*) AS CUENTA FROM LG_EVENTO  WHERE COD_EVENTO<>0 ".$FLT_USUARIO.$FLT_TIPO.$FLT_SIS.$FLT_MODULO.$F_FECHA."";
				
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
					
				
				if ($TOTALREG==0) { 
					if(empty($BSC_TIPO) and empty($BSC_USUARIO) and empty($BFOLIO)) {
							//NO HAY REGISTROS
						} else {
							echo "<script language='javascript'>window.location='log_accesos.php?MSJE=1'</script>;";
						}
				}

				$CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY COD_EVENTO DESC) ROWNUMBER FROM LG_EVENTO WHERE COD_EVENTO <> 0 ".$FLT_USUARIO.$FLT_TIPO.$FLT_SIS.$FLT_MODULO.$F_FECHA.") AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";
				
				//$RS = sqlsrv_query($conn, $CONSULTA);
				////oci_execute($RS);
				$RS = sqlsrv_query($conn,$CONSULTA);

               ?>
                <table id="Listado">
                <tr>
                    <th>Sistema</th>
                    <th>Perfil</th>
                    <th>Tipo de Evento</th>
                    <th>M&oacute;dulo</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>IP Usuario</th>
                    <th>Usuario</th>
                    
                </tr>
                <?php
				while (@$row = sqlsrv_fetch_array($RS)){
                        $COD_EVENTO = $row['COD_EVENTO'];
                        $COD_TIPO_EVENTO = $row['COD_TIPO_EVENTO'];
						$COD_USUARIO = $row['COD_USUARIO'];
						$IDACC = $row['IDACC'];
                        $IDSISTEMA = $row['IDSISTEMA'];
                        $IDPERFIL = $row['IDPERFIL'];
                        $FECHA = $row['FECHA'];
                        $HORA = $row['HORA'];
                        $IP_CLIENTE = $row['IP_CLIENTE'];
						//$PAIS = geoip_country_name_by_name($_SERVER['REMOTE_ADDR']);
						
						$CONSULTA2="SELECT NOMBRE FROM US_SISTEMA WHERE IDSISTEMA=".$IDSISTEMA;
						
						//$RS2 = sqlsrv_query($conn, $CONSULTA2);
						////oci_execute($RS2);

						$RS2 = sqlsrv_query($conn,$CONSULTA2);

						if ($row = sqlsrv_fetch_array($RS2)){
							$NOMBSISTEMA=$row['NOMBRE'];
						}
						$CONSULTA2="SELECT NOMBRE FROM US_PERFIL WHERE IDPERFIL=".$IDPERFIL;
						
						//$RS2 = sqlsrv_query($conn, $CONSULTA2);
						////oci_execute($RS2);

						$RS2 = sqlsrv_query($conn,$CONSULTA2);
						
						if ($row = sqlsrv_fetch_array($RS2)){
							$NOMBPERFIL=$row['NOMBRE'];
						}
						$CONSULTA2="SELECT DES_TIPO_EVENTO FROM LG_TIPO_EVENTO WHERE COD_TIPO_EVENTO=".$COD_TIPO_EVENTO;
						
						//$RS2 = sqlsrv_query($conn, $CONSULTA2);
						////oci_execute($RS2);
						$RS2 = sqlsrv_query($conn,$CONSULTA2);
						
						if ($row = sqlsrv_fetch_array($RS2)){
							$DES_TIPO_EVENTO=$row['DES_TIPO_EVENTO'];
						}
						if ($IDACC==0) {
							$NOMB_MODULO = "Salida de Sistema";
						} else {
							$CONSULTA2="SELECT NOMBRE FROM US_ACCESO WHERE IDACC=".$IDACC;
							
							//$RS2 = sqlsrv_query($conn, $CONSULTA2);
							////oci_execute($RS2);
							$RS2 = sqlsrv_query($conn,$CONSULTA2);

							if ($row = sqlsrv_fetch_array($RS2)){
								$NOMB_MODULO=$row['NOMBRE'];
							}
						}
						if ($COD_USUARIO==0) {
							$NOMB_USUARIO = "Proceso de Sistema";
						} else {

							$CONSULTA2="SELECT NOMBRE FROM US_USUARIOS WHERE IDUSU=".$COD_USUARIO;
							
							//$RS2 = sqlsrv_query($conn, $CONSULTA2);
							////oci_execute($RS2);
							$RS2 = sqlsrv_query($conn,$CONSULTA2);

							if ($row = sqlsrv_fetch_array($RS2)){
									$NOMB_USUARIO = $row['NOMBRE'];
							}
						}
               ?>
                <tr>
                    <td><?=$NOMBSISTEMA; ?></td>
                    <td><?=$NOMBPERFIL; ?></td>
                    <td><h6><?=$DES_TIPO_EVENTO; ?></h6></td>
                    <td><?=$NOMB_MODULO; ?></td>
                    <!-- Se dio Formato a $FECHA, paso de DATETIME a String-->
                    <td><?=date_format($FECHA,"d/m/Y"); ?></td>
                    <td><?=$HORA; ?></td>
                    <td><?=$IP_CLIENTE; ?></td>
                    <td><?=$NOMB_USUARIO; ?></td>
                    
                </tr>
                <?php
				}
				?>
                <tr>
                    <td colspan="8" nowrap style="background-color:transparent">
                    <?php
                    if ($LINF>=$CTP+1) {
						$ATRAS=$LINF-$CTP;
						$FILA_ANT=$LSUP-$CTP;
                   ?>
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('log_accesos.php?LSUP=<?=$FILA_ANT?>&LINF=<?=$ATRAS?>&BSC_TIPO=<?=$BSC_TIPO ?>&BSC_SISTEMA=<?=$BSC_SISTEMA ?>&BSC_USUARIO=<?=$BSC_USUARIO ?>&BSC_MODULO=<?=$BSC_MODULO ?>&B_FECHA_E=<?=$B_FECHA_E ?>&DIA_ED=<?=$DIA_ED ?>&MES_ED=<?=$MES_ED ?>&ANO_ED=<?=$ANO_ED ?>&DIA_EH=<?=$DIA_EH ?>&MES_EH=<?=$MES_EH ?>&ANO_EH=<?=$ANO_EH ?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('log_accesos.php?LSUP=<?=$FILA_POS?>&LINF=<?=$ADELANTE?>&BSC_TIPO=<?=$BSC_TIPO ?>&BSC_SISTEMA=<?=$BSC_SISTEMA ?>&BSC_USUARIO=<?=$BSC_USUARIO ?>&BSC_MODULO=<?=$BSC_MODULO ?>&B_FECHA_E=<?=$B_FECHA_E ?>&DIA_ED=<?=$DIA_ED ?>&MES_ED=<?=$MES_ED ?>&ANO_ED=<?=$ANO_ED ?>&DIA_EH=<?=$DIA_EH ?>&MES_EH=<?=$MES_EH ?>&ANO_EH=<?=$ANO_EH ?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina <?=$NUMPAG?> de <?=$NUMTPAG?></span>
                    </td>
                </tr>
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