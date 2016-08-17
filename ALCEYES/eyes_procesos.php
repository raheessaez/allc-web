
<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php

	$PAGINA=1160;
	$NOMENU=1;
	$LIST=@$_GET["LIST"];
	$NEO=@$_GET["NEO"];
	$ACT=@$_GET["ACT"];
        $LOG = 1;
?>

<style>
    #StoreContainerList, #StoreContainerSel {
		display:inline;
		float:left;
		clear:left;
		width:auto;
		padding:20px;
		margin:0;
	}	
    #MessageContainer,  #MessageStoreContainer {
		display:inline;
		float:left;
		padding:20px;
		margin:0;
		width:auto;
        height: 100%;
		min-height: 100%;
		border-left:1px solid #DFDFDF;
    }	
</style>



</head>
<body onLoad="EyesMensajes();">

<?php include("encabezado.php");?>
<?php include("titulo_menu.php");?>

<table width="100%">
<tr>
<td id="MenuGeneral" align="right"  width="200" bgcolor="#FFFFFF"><?php include("menugeneral.php");?></td> 
<td >

        <table width="100%" height="100%">
        <tr><td>
		<?php 
		$B_FECHA_E=@$_POST["B_FECHA_E"];
		if (empty($B_FECHA_E)) { $B_FECHA_E=@$_GET["B_FECHA_E"]; }
		
				function dameFecha($fecha,$dia)
				{   list($day,$mon,$year) = explode('/',$fecha);
					return date('d/m/Y',mktime(0,0,0,$mon,$day+$dia,$year));        
				}
		
				//CALCULAR MINIMO Y MÁXIMO FECHA EXECUTION_DATE
				$CONSULTA2="SELECT MAX(EXECUTION_DATE) AS MINFECHA FROM FP_EJECUCION";
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				//oci_execute($RS2);
				if ($row = sqlsrv_fetch_array($RS2)){
						$MIN_EVEN_DATE = $row['MINFECHA'];
						$MIN_EVEN_DATE = date_format($MIN_EVEN_DATE,"d/m/Y");
						$MIN_DIA=date_format($row['MINFECHA'],"d");
						$MIN_MES=date_format($row['MINFECHA'],"m");
						$MIN_ANO=date_format($row['MINFECHA'],"Y");
						$MIN_EVEN_DATE2=$MIN_DIA."/".$MIN_MES."/".$MIN_ANO;
						
						$MIN_EVEN_DATE = dameFecha($MIN_EVEN_DATE2,-1);
				}

				$CONSULTA2="SELECT MAX(EXECUTION_DATE) AS MAXFECHA FROM FP_EJECUCION";
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				//oci_execute($RS2);
				if ($row = sqlsrv_fetch_array($RS2)){
						$MAX_EVEN_DATE = $row['MAXFECHA'];
						$MAX_EVEN_DATE = date_format($MAX_EVEN_DATE,"d/m/Y");
				}

				if (empty($MIN_EVEN_DATE)) { $MIN_EVEN_DATE=date('d/m/Y'); }
				if (empty($MAX_EVEN_DATE)) { $MAX_EVEN_DATE=date('d/m/Y'); }
				

				//FECHA REGISTRO DESDE
				$dia_ed=@$_POST["dia_ed"];
				if (empty($dia_ed)) { $dia_ed=@$_GET["dia_ed"]; }
				if (empty($dia_ed)) { $dia_ed=substr($MIN_EVEN_DATE, 0, 2); }
				$mes_ed=@$_POST["mes_ed"];
				if (empty($mes_ed)) { $mes_ed=@$_GET["mes_ed"]; }
				if (empty($mes_ed)) { $mes_ed=substr($MIN_EVEN_DATE, 3, 2); }
				$ano_ed=@$_POST["ano_ed"];
				if (empty($ano_ed)) { $ano_ed=@$_GET["ano_ed"]; }
				if (empty($ano_ed)) { $ano_ed='20'.substr($MIN_EVEN_DATE, -2); }
				//FECHA REGISTRO HASTA
				$dia_eh=@$_POST["dia_eh"];
				if (empty($dia_eh)) { $dia_eh=@$_GET["dia_eh"]; }
				if (empty($dia_eh)) { $dia_eh=substr($MAX_EVEN_DATE, 0, 2); }
				$mes_eh=@$_POST["mes_eh"];
				if (empty($mes_eh)) { $mes_eh=@$_GET["mes_eh"]; }
				if (empty($mes_eh)) { $mes_eh=substr($MAX_EVEN_DATE, 3, 2); }
				$ano_eh=@$_POST["ano_eh"];
				if (empty($ano_eh)) { $ano_eh=@$_GET["ano_eh"]; }
				if (empty($ano_eh)) { $ano_eh='20'.substr($MAX_EVEN_DATE, -2); }
				//CONSTRUYE FECHAS REGISTRO
				//VALIDAR FECHA_ED
				if (checkdate($mes_ed, $dia_ed, $ano_ed)==false) { 
					$MSJE=2 ;
					$dia_ed=substr($MIN_EVEN_DATE, 0, 2);
					$mes_ed=substr($MIN_EVEN_DATE, 3, 2);
					$ano_ed='20'.substr($MIN_EVEN_DATE, -2);
					$dia_eh=substr($MAX_EVEN_DATE, 0, 2);
					$mes_eh=substr($MAX_EVEN_DATE, 3, 2);
					$ano_eh='20'.substr($MAX_EVEN_DATE, -2);
				}
				$dia_ed=substr('00'.$dia_ed, -2);
				$mes_ed=substr('00'.$mes_ed, -2);
				$FECHA_ED=$ano_ed.$mes_ed.$dia_ed;
				
				if (checkdate($mes_eh, $dia_eh, $ano_eh)==false) { 
					$MSJE=3 ;
					$dia_ed=substr($MIN_EVEN_DATE, 0, 2);
					$mes_ed=substr($MIN_EVEN_DATE, 3, 2);
					$ano_ed='20'.substr($MIN_EVEN_DATE, -2);
					$dia_eh=substr($MAX_EVEN_DATE, 0, 2);
					$mes_eh=substr($MAX_EVEN_DATE, 3, 2);
					$ano_eh='20'.substr($MAX_EVEN_DATE, -2);
				}
				$dia_eh=substr('00'.$dia_eh, -2);
				$mes_eh=substr('00'.$mes_eh, -2);
				
				$FECHA_EH=$ano_eh.'/'.$mes_eh.'/'.$dia_eh;
		//FILTRO FECHA MENSAJE
		
		$F_FECHA=" WHERE Convert(varchar(20), EXECUTION_DATE, 111) >=  Convert(varchar(20),'".$FECHA_ED."', 111) AND Convert(varchar(20), EXECUTION_DATE, 111) <= Convert(varchar(20),'".$FECHA_EH."', 111)"; 

		?>
		<script>
         function EyesMensajes(){ /*Ventana Principal*/
                var contenedor = document.getElementById("MessageContainer");
                contenedor.style.display = "block";
                document.getElementById('MessageContainer').innerHTML = "<object type='text/html' data='eyes_prcActivo.php?dia_ed=<?php echo $dia_ed?>&mes_ed=<?php echo $mes_ed?>&ano_ed=<?php echo $ano_ed?>&dia_eh=<?php echo $dia_eh?>&mes_eh=<?php echo $mes_eh?>&ano_eh=<?php echo $ano_eh?>' id='MonitorIframe' onload='setIframeHeight(this.id)'></object>";
                return true;
            }
        
         function EyesStoreMensajes(val){
                var IdLocal = val;
                var contenedor = document.getElementById("MessageStoreContainer");
                contenedor.style.display = "block";
                document.getElementById('MessageStoreContainer').innerHTML = "<object type='text/html' data='eyes_prcTienda.php?idl="+IdLocal+"&dia_ed=<?php echo $dia_ed?>&mes_ed=<?php echo $mes_ed?>&ano_ed=<?php echo $ano_ed?>&dia_eh=<?php echo $dia_eh?>&mes_eh=<?php echo $mes_eh?>&ano_eh=<?php echo $ano_eh?>' id='MonitorIframe' onload='setIframeHeight(this.id)'></object>";
                return true;
            }
        
         function EyesHardwareMensajes(val, ideq){
                var IdLocal = val;
                var IdEquipo = ideq;
                var contenedor = document.getElementById("MessageStoreContainer");
                contenedor.style.display = "block";
                document.getElementById('MessageStoreContainer').innerHTML = "<object type='text/html' data='eyes_prcTienda.php?idl="+IdLocal+"&ideq="+IdEquipo+"&dia_ed=<?php echo $dia_ed?>&mes_ed=<?php echo $mes_ed?>&ano_ed=<?php echo $ano_ed?>&dia_eh=<?php echo $dia_eh?>&mes_eh=<?php echo $mes_eh?>&ano_eh=<?php echo $ano_eh?>' id='MonitorIframe' onload='setIframeHeight(this.id)'></object>";
                return true;
            }
        </script>
        <table width="100%" id="Filtro">
          <tr>
            <td>
                <form action="eyes_procesos.php?B_FECHA_E=<?php echo $B_FECHA_E ?>&dia_ed=<?php echo $dia_ed ?>&mes_ed=<?php echo $mes_ed ?>&ano_ed=<?php echo $ano_ed ?>&dia_eh=<?php echo $dia_eh ?>&mes_eh=<?php echo $mes_eh ?>&ano_eh=<?php echo $ano_eh ?>" method="post" name="frmbuscar" id="frmbuscar">

                          				      <label for="FECHA_EM_D">Desde</label>
                                              <input name="dia_ed" type="text"  id="dia_ed" value="<?php echo $dia_ed ?>" size="1" maxlength="2" onKeyPress="return acceptNum(event);">
                                             <select name="mes_ed"  id="mes_ed">
                          				            <option value="01" <?php  if ($mes_ed==1) { echo "SELECTED";}?>>Enero</option>
                          				            <option value="02" <?php  if ($mes_ed==2) { echo "SELECTED";}?>>Febrero</option>
                          				            <option value="03" <?php  if ($mes_ed==3) { echo "SELECTED";}?>>Marzo</option>
                          				            <option value="04" <?php  if ($mes_ed==4) { echo "SELECTED";}?>>Abril</option>
                          				            <option value="05" <?php  if ($mes_ed==5) { echo "SELECTED";}?>>Mayo</option>
                          				            <option value="06" <?php  if ($mes_ed==6) { echo "SELECTED";}?>>Junio</option>
                          				            <option value="07" <?php  if ($mes_ed==7) { echo "SELECTED";}?>>Julio</option>
                          				            <option value="08" <?php  if ($mes_ed==8) { echo "SELECTED";}?>>Agosto</option>
                          				            <option value="09" <?php  if ($mes_ed==9) { echo "SELECTED";}?>>Septiembre</option>
                          				            <option value="10" <?php  if ($mes_ed==10) { echo "SELECTED";}?>>Octubre</option>
                          				            <option value="11" <?php  if ($mes_ed==11) { echo "SELECTED";}?>>Noviembre</option>
                          				            <option value="12" <?php  if ($mes_ed==12) { echo "SELECTED";}?>>Diciembre</option>
                        				       </select>
                                               <input name="ano_ed" type="text"  id="ano_ed" value="<?php echo $ano_ed ?>" size="2" maxlength="4">
                       				          
                                              <label for="FECHA_EM_H"> Hasta </label>
                          				      <input name="dia_eh" type="text"  id="dia_eh" value="<?php echo $dia_eh ?>" size="1" maxlength="2" onKeyPress="return acceptNum(event);">
                          				      <select name="mes_eh"  id="mes_eh">
                          				            <option value="01" <?php  if ($mes_eh==1) { echo "SELECTED";}?>>Enero</option>
                          				            <option value="02" <?php  if ($mes_eh==2) { echo "SELECTED";}?>>Febrero</option>
                          				            <option value="03" <?php  if ($mes_eh==3) { echo "SELECTED";}?>>Marzo</option>
                          				            <option value="04" <?php  if ($mes_eh==4) { echo "SELECTED";}?>>Abril</option>
                          				            <option value="05" <?php  if ($mes_eh==5) { echo "SELECTED";}?>>Mayo</option>
                          				            <option value="06" <?php  if ($mes_eh==6) { echo "SELECTED";}?>>Junio</option>
                          				            <option value="07" <?php  if ($mes_eh==7) { echo "SELECTED";}?>>Julio</option>
                          				            <option value="08" <?php  if ($mes_eh==8) { echo "SELECTED";}?>>Agosto</option>
                          				            <option value="09" <?php  if ($mes_eh==9) { echo "SELECTED";}?>>Septiembre</option>
                          				            <option value="10" <?php  if ($mes_eh==10) { echo "SELECTED";}?>>Octubre</option>
                          				            <option value="11" <?php  if ($mes_eh==11) { echo "SELECTED";}?>>Noviembre</option>
                          				            <option value="12" <?php  if ($mes_eh==12) { echo "SELECTED";}?>>Diciembre</option>
                        				            </select>
                          				        <input name="ano_eh" type="text"  id="ano_eh" value="<?php echo $ano_eh ?>" size="2" maxlength="4" onKeyPress="return acceptNum(event);">

                            <input name="B_FECHA_E" type="submit"  id="B_FECHA_E" value="Filtrar">
                           <input name="LIMPIAR" type="button" id="LIMPIAR" value="Limpiar" onClick="javascript:pagina('eyes_procesos.php')">

                </form>

              </td>
              </tr>
          </table>


        <table width="100%">
        <tr>
            <td width="20px">

                		<!-- LOCAL SELECCIONADO -->
                		<div id="StoreContainerSel" style="display:none;">
                        <?php
                                $SQL="SELECT ID_LOCAL FROM FP_EJECUCION ".$F_FECHA." GROUP BY ID_LOCAL ORDER BY ID_LOCAL";
                                $RS = sqlsrv_query($conn, $SQL);
                                //oci_execute($RS);
                                while ($row = sqlsrv_fetch_array($RS)){
                                        $ID_LOCAL = $row['ID_LOCAL'];
										$SQL1="SELECT * FROM MN_TIENDA WHERE DES_CLAVE=".$ID_LOCAL;
										$RS1 = sqlsrv_query($maestra, $SQL1);
										//oci_execute($RS1);
										if ($row1 = sqlsrv_fetch_array($RS1)){
											$NMB_Local = $row1['DES_TIENDA'];
											$DIP_Local = $row1['IP'];
										}
										if($ID_LOCAL == 0){
											$ICO_Local = "ICO_ServArmsB.png"; 
											$DSC_Local = $NMB_Local;
											$Width_Local = 45;
										} else { 
											$ICO_Local = "ICO_StoreB.png"; 
											$DSC_Local = "L".substr("0000".$ID_LOCAL, -4);
											$DIP_Local = $NMB_Local;
											$Width_Local = 34;
										}
										?>
                                        <style>
													#StoreSel<?=$ID_LOCAL;?> {position: relative; width:240px;height:60px;margin:0;padding:10px;cursor:pointer;border: 1px solid #7A2A9C; background:#7A2A9C; -webkit-border-radius: 6px 6px 0 0 ;-moz-border-radius: 6px 6px 0 0 ;border-radius: 6px 6px 0 0 ;}
													#StoreSelIcon<?=$ID_LOCAL;?>{display:inline-block;float:left;width:60px;background:#7A2A9C;margin:0;vertical-align:middle;text-align:center;
														<?php if($ID_LOCAL==0){echo "height:53px;";echo "padding:7px 0 0 0;";} else { echo "height:48px;";echo "padding:12px 0 0 0;";} ?>
													}
													#StoreSelDesc{display:inline-block;float:left;width:auto;max-width:150px;height:auto;max-height:60px;padding:0 0 0 10px; color:#FFF}
													#StoreSelDesc h5{padding:0;margin:0;}
													#CloseSel{position:absolute;width:36px;height:36px; padding:0; background:url(imgMon/ICO_CloseSel.png) no-repeat 10px 10px; top:0; right:0; background-color:#4D076B; -webkit-border-radius: 0 6px 0 6px;-moz-border-radius:  0 6px 0 6px;border-radius:  0 6px 0 6px;}
												</style>
                                                <div id="StoreSel<?=$ID_LOCAL;?>" style="display:none" onClick="EyesStoreMensajes(<?php echo $ID_LOCAL;?>);">
                                                        <div id="StoreSelIcon<?=$ID_LOCAL;?>">
                                                            <img src="imgMon/<?=$ICO_Local;?>" width="<?=$Width_Local;?>">
                                                        </div>
                                                        <div id="StoreSelDesc">
                                                            <h5><?php echo $DSC_Local;?></h5>
                                                            <?php echo $DIP_Local;?>
                                                        </div>
                                                        <div id="CloseSel" onClick="pagina('eyes_procesos.php?dia_ed=<?php echo $dia_ed?>&mes_ed=<?php echo $mes_ed?>&ano_ed=<?php echo $ano_ed?>&dia_eh=<?php echo $dia_eh?>&mes_eh=<?php echo $mes_eh?>&ano_eh=<?php echo $ano_eh?>');">
                                                        </div>
                                                </div>

                                                <style>
													#HardwareList<?php echo $ID_LOCAL;?> {
                                                    background-color:transparent;
                                                     -webkit-border-radius: 0 ;-moz-border-radius: 0 ;border-radius: 0 ;
                                                    padding:0;
                                                    width:260px; height:auto; 
													}	
												</style>
                                                <div id="HardwareList<?php echo $ID_LOCAL;?>" style="display:none">
                                                
                                    
                                                            <?php
                                                                    $SQL1="SELECT * FROM FM_EQUIPO  WHERE ID_LOCAL=".$ID_LOCAL." AND ID_EQUIPO IN(SELECT ID_EQUIPO FROM FP_EJECUCION ".$F_FECHA.") ORDER BY ID_TIPO ASC, DES_CLAVE ASC";
                                                                    $RS1 = sqlsrv_query($conn, $SQL1);
                                                                    //oci_execute($RS1);
                                                                    while ($row1 = sqlsrv_fetch_array($RS1)){
                                                                            $ID_EQUIPO = $row1['ID_EQUIPO'];
                                                                            $DES_EQUIPO = $row1['DES_EQUIPO'];
                                                                            $DES_CLAVE = $row1['DES_CLAVE'];
                                                                            $IP_EQUIPO = $row1['IP'];
                                                                            if(empty($DES_EQUIPO)){ $DES_EQUIPO=$DES_CLAVE;}
                                                                            $ID_TIPO = $row1['ID_TIPO'];
                                                                            if($ID_TIPO == 1){ $ICO_Equipo = "ICO_StrContrB.png";} 
                                                                            if($ID_TIPO == 2){ $ICO_Equipo = "ICO_POSTermB.png";} 
                                                                            if($ID_TIPO == 3){ $ICO_Equipo = "ICO_ServArmsB.png";} 
                                                                            ?>
                                                                            <style>
																			#HwSel<?=$ID_EQUIPO;?> {position: relative; width:240px;height:60px;margin:0;padding:10px;cursor:pointer;border: 1px solid #7A2A9C; border-top:none; -webkit-border-radius: 0 ;-moz-border-radius: 0 ;border-radius: 0 ;}
																			#HwSel<?=$ID_EQUIPO;?>:hover {background: #FFF;}
																			#HwSel<?=$ID_EQUIPO;?>:hover #HardwareIcon<?=$ID_EQUIPO;?> {background: #4D076B;}
																			#HwSel<?=$ID_EQUIPO;?>:hover #HardwareDesc<?=$ID_EQUIPO;?> {color: #4D076B;}
																			#HardwareIcon<?=$ID_EQUIPO;?>{display:inline-block;float:left;width:60px;background:#7A2A9C;margin:0;vertical-align:middle;text-align:center;
																				<?php if($ID_LOCAL==0){echo "height:53px;";echo "padding:7px 0 0 0;";} else { echo "height:48px;";echo "padding:12px 0 0 0;";} ?>
																			}
																			#HardwareDesc<?=$ID_EQUIPO;?>{display:inline-block;float:left;width:auto;max-width:150px;height:auto;max-height:60px;padding:0 0 0 10px; color:#7A2A9C}
																			#HardwareDesc<?=$ID_EQUIPO;?> h5{padding:0;margin:0;}
																			</style>
                                                                            <div id="HwSel<?=$ID_EQUIPO;?>" style="cursor:pointer; width:240px; height:60px; padding:10px"  onClick="EyesHardwareMensajes(<?php echo $ID_LOCAL;?>, <?php echo $ID_EQUIPO;?>);">
                                                                                    <div id="HardwareIcon<?=$ID_EQUIPO;?>">
                                                                                        <img src="imgMon/<?=$ICO_Equipo;?>" width="<?=$Width_Local;?>">
                                                                                    </div>
                                                                                    <div id="HardwareDesc<?=$ID_EQUIPO;?>">
                                                                                        <h5><?=$DES_EQUIPO;?></h5>
                                                                                        <p><?=$DES_CLAVE;?></p>
                                                                                        <p><?=$IP_EQUIPO;?></p>
                                                                                    </div>
                                                                             </div>
																			<?php
                                                                    }
                                                            ?>
                                                </div> <!-- HardwareList -->


                                        <?php
                                }
						?>
                        </div>
						<!-- FIN LOCAL SELECCIONADO -->

                		<!-- VENTANA PRINCIPAL -->
                        <?php
						$SQL="SELECT ID_LOCAL FROM FP_EJECUCION ".$F_FECHA." GROUP BY ID_LOCAL ORDER BY ID_LOCAL";
						$RS = sqlsrv_query($conn, $SQL);
						//oci_execute($RS);
						?>
                        <div id="StoreContainerList">
                        <?php
								$EVTREG=0;
                                while ($row = sqlsrv_fetch_array($RS)){
										$EVTREG=$EVTREG+1;
                                        $ID_LOCAL = $row['ID_LOCAL'];
										$SQL2="SELECT * FROM MN_TIENDA WHERE DES_CLAVE=".$ID_LOCAL;
										$RS2 = sqlsrv_query($maestra, $SQL2);
										//oci_execute($RS2);
										if ($row2 = sqlsrv_fetch_array($RS2)){
												$NMB_Local = $row2['DES_TIENDA'];
												$DIP_Local = $row2['IP'];
										}
										if($ID_LOCAL == 0){
											$ICO_Local = "ICO_ServArmsB.png"; 
											$DSC_Local = $NMB_Local;
											$Width_Local = 45;
										} else { 
											$ICO_Local = "ICO_StoreB.png"; 
											$DSC_Local = "L".substr("0000".$ID_LOCAL, -4);
											$DIP_Local = $NMB_Local;
											$Width_Local = 34;
										}
										?>
											<script>
                                             function SelTienda<?php echo $ID_LOCAL;?>(){
                                                    var MessageCont = document.getElementById("MessageContainer");
                                                    var MessageStoreCont = document.getElementById("MessageStoreContainer");
                                                    var StoreContainerSel = document.getElementById("StoreContainerSel");
                                                    var StoreSel = document.getElementById("StoreSel<?=$ID_LOCAL;?>");
                                                    var StoreList = document.getElementById("StoreList<?=$ID_LOCAL;?>");
                                                    var HardwareList = document.getElementById("HardwareList<?=$ID_LOCAL;?>");
													MessageCont.style.display = "none";
													MessageStoreCont.style.display = "block";
													StoreContainerSel.style.display = "block";
													StoreSel.style.display = "block";
													StoreList.style.display = "none";
													HardwareList.style.display = "block";
                                                    <?php
                                                    $SQL1="SELECT ID_LOCAL FROM FP_EJECUCION  ".$F_FECHA." AND ID_LOCAL<>".$ID_LOCAL." GROUP BY ID_LOCAL ORDER BY ID_LOCAL";
                                                    $RS1 = sqlsrv_query($conn, $SQL1);
                                                    //oci_execute($RS1);
                                                    while ($row1 = sqlsrv_fetch_array($RS1)){
                                                            $ID_LOCALNOSEL = $row1['ID_LOCAL'];
                                                            ?>
															var StoreSel = document.getElementById("StoreSel<?=$ID_LOCALNOSEL;?>");
															var StoreList = document.getElementById("StoreList<?=$ID_LOCALNOSEL;?>");
															var HardwareList = document.getElementById("HardwareList<?=$ID_LOCALNOSEL;?>");
															StoreSel.style.display = "none";
															StoreList.style.display = "block";
															HardwareList.style.display = "none";
                                                            <?php
                                                    }
                                                    ?>
                                                }
                                                </script>
                                        		<style>
													#StoreList<?=$ID_LOCAL;?>{display:block;width:240px;height:60px;margin:0 0 5px 0px;padding:10px;cursor:pointer;border: 1px solid #858585;-webkit-border-radius: 6px;-moz-border-radius: 6px;border-radius: 6px;}
													#StoreList<?=$ID_LOCAL;?>:hover{border:1px solid #7A2A9C;color:#7A2A9C;}
													#StoreList<?=$ID_LOCAL;?>:hover #StoreIcon<?=$ID_LOCAL;?> {background: #7A2A9C;}
													#StoreIcon<?=$ID_LOCAL;?>{display:inline-block;float:left;width:60px;background:#858585;margin:0;vertical-align:middle;text-align:center;
														<?php if($ID_LOCAL==0){echo "height:53px;";echo "padding:7px 0 0 0;";} else { echo "height:48px;";echo "padding:12px 0 0 0;";} ?>
													}
													#StoreDesc{display:inline-block;float:left;width:auto;max-width:150px;height:auto;max-height:60px;padding:0 0 0 10px;}
													#StoreDesc h5{padding:0;margin:0;}
												</style>
                                                <div id="StoreList<?=$ID_LOCAL;?>" onClick="EyesStoreMensajes(<?=$ID_LOCAL;?>); SelTienda<?=$ID_LOCAL;?>(); ">
                                                        <div id="StoreIcon<?=$ID_LOCAL;?>">
                                                            <img src="imgMon/<?=$ICO_Local;?>" width="<?=$Width_Local;?>">
                                                        </div>
                                                        <div id="StoreDesc">
                                                            <h5><?php echo $DSC_Local;?></h5>
                                                            <?php echo $DIP_Local;?>
                                                        </div>
                                                </div>
										<?php
                                }
						?>
                        </div> <!-- StoreContainerList -->
                		<!-- FIN VENTANA PRINCIPAL -->
                        
                </td>
                <td>
                        
                        <!-- LISTA DE COMPONENTES DE LOCAL -->
                            <div id="MessageStoreContainer" style="display:none">  </div>
                        <!-- FIN LISTA -->
                        
						<?php if($EVTREG>0){?>
                                <div id="MessageContainer" style="display:none"> </div>
                        <?php } else {?>
                                <div style="margin:10px 0"><p class="AlertDate">EL RANGO SELECCIONADO<BR>NO REGISTRA INFORMACI&Oacute;N</p></div>
                        <?php } ?>

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

