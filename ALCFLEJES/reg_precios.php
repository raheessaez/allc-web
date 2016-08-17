
<?php include("session.inc");?>

<?php include("reg_procesa.php");?>

<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1151;
	$NOMENU=1;
	$LIST=@$_GET["LIST"];
	$LOTE=@$_GET["LOTE"];
	$VLTE=@$_GET["VLTE"];
		$ND=@$_GET["ND"];
		if(empty($ND)){$ND=0;}
	$LDN=@$_GET["LDN"];
	$LOTART=@$_GET["LOTART"];

	$VNTPRT=@$_GET["VNTPRT"];


	$ARTS=@$_GET["ARTS"];
	$ARTSNEG=@$_GET["ARTSNEG"];
	$EXCEP=@$_GET["EXCEP"];
	$EXCEPNEG=@$_GET["EXCEPNEG"];
	if(empty($ARTS) && empty($EXCEP) && empty($LOTE) && empty($ARTSNEG) && empty($EXCEPNEG)) { $LIST=1;}

	$onLoad="";
	 if($LIST==1 && $VLTE<>"" && $ND==0){ $onLoad="ShowVLTE".$VLTE."();";}
	 if($LIST==1 && $VLTE<>"" && $ND==0 && $VNTPRT<>""){ $onLoad="ShowVLTE".$VLTE."(); ActivarVentFlejes".$VLTE.$VNTPRT."();";}
	 if($LIST==1 && $VLTE<>"" && $ND==1){ $onLoad="ShowVLTE".$VLTE."(); ShowNegocio".$VLTE."();";}
	 if($LIST==1 && $VLTE<>"" && $ND==1 && $VNTPRT<>""){ $onLoad="ShowVLTE".$VLTE."(); ShowNegocio".$VLTE."(); ActivarVentFlejes".$VLTE.$VNTPRT."();";}
	 if($LOTE<>"" && $VNTPRT<>""){ $onLoad="ActivarVentFlejes".$VNTPRT."();";}
	 	 
	 
?>


</head>
<body onLoad="<?php echo $onLoad;?>">

<?php include("encabezado.php");?>
<?php include("titulo_menu.php");?>

<table width="100%" height="100%">
<tr>
<td align="right"  width="200" bgcolor="#FFFFFF"><?php include("menugeneral.php");?></td> 
<td >
<?php
if ($MSJE==1) { $ELMSJ="Se ha retirado del proceso la Excepci&oacute;n"; } 
if ($MSJE==2) { $ELMSJ="Se ha activado la Excepci&oacute;n para su procesamiento"; } 
if ($MSJE==3) { $ELMSJ="Se ha procesado el rechazo del lote de actualizaci&oacute;n"; } 
if ($MSJE==4) { $ELMSJ="Se ha aceptado el lote de actualizaci&oacute;n de precios"; } 
if ($MSJE==5) { $ELMSJ="Se ha generado comanda de impresi&oacute;n de flejes, verifique su impresora previo a ejecutar la comanda"; } 
if ($MSJE==6) { $ELMSJ="Se ha activado el Proceso de Actualizaci&oacute;n de Precios en el Controlador de Tienda"; } 
if ($MSJE <> "") {
?>
<div id="GMessaje" onClick="QuitarGMessage();"><a href="#" onClick="QuitarGMessage();" style="color:#111111;"><?php echo $ELMSJ?></a></div>
<?php }?>
        <table width="100%">
        <tr><td>

        <table style="margin:10px 20px; ">
        <tr>
        <td>
        <?php if($LIST==1){ //ARCHIVOS SAP Y NEGOCIOS?>
                <?php
				//VERIFICAR TIENDAS ASOCIADAS A USUARIO
				$SQL="SELECT COUNT(COD_TIENDA) AS CTATND FROM US_USUTND WHERE IDUSU=".$SESIDUSU;
				$RS = sqlsrv_query($maestra, $SQL);
				//oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {
					$CTATND = $row['CTATND'];
				}
				//SI CTATND==0 USUARIO CENTRAL, SELECCIONAR NEGOCIO Y LOCAL
				//SI CTATND>=1 DESPLEGAR LISTADO DE LOCALES
				if($CTATND==0){
						$FLT_TND="";
						$FLT_NEG="";
				} else {
						//SELECCIONA TIENDAS DEL USUARIO
						$SQL="SELECT COD_TIENDA FROM US_USUTND WHERE IDUSU=".$SESIDUSU." GROUP BY COD_TIENDA";
						$RS = sqlsrv_query($maestra, $SQL);
						//oci_execute($RS);
						$FLT_TND="";
						$CTA_TND=0;
						$FILTRO_TND="";
						while ($row = sqlsrv_fetch_array($RS)) {
							$CTA_TND=$CTA_TND+1;
							$COD_TNDUSU = $row['COD_TIENDA'];
							$SQL1="SELECT * FROM MN_TIENDA WHERE COD_TIENDA=".$COD_TNDUSU;
							$RS1 = sqlsrv_query($maestra, $SQL1);
							//oci_execute($RS1);
							if ($row1 = sqlsrv_fetch_array($RS1)) {
								$COD_TNDUSU = $row1['DES_CLAVE'];
							}
							if($CTA_TND==1){$FILTRO_TND=" (COD_TIENDA=".$COD_TNDUSU.")"; }
							else { $FILTRO_TND=$FILTRO_TND." OR ( COD_TIENDA=".$COD_TNDUSU.")";  }							
						}
						if($CTA_TND!=0){ $FLT_TND="AND (".$FILTRO_TND.")"; }
						//SELECCIONA NEGOCIOS DEL USUARIO
						$SQL="SELECT COD_NEGOCIO FROM US_USUTND WHERE IDUSU=".$SESIDUSU." GROUP BY COD_NEGOCIO";
						$RS = sqlsrv_query($maestra, $SQL);
						//oci_execute($RS);
						$FLT_NEG="";
						$CTA_NEG=0;
						$FILTRO_NEG="";
						while ($row = sqlsrv_fetch_array($RS)) {
							$CTA_NEG=$CTA_NEG+1;
							$COD_NEGUSU = $row['COD_NEGOCIO'];
						if($CTA_NEG==1){$FILTRO_NEG=" (COD_NEGOCIO=".$COD_NEGUSU.")"; }
							else { $FILTRO_NEG=$FILTRO_NEG." OR ( COD_NEGOCIO=".$COD_NEGUSU.")";  }							
						}
						if($CTA_NEG!=0){ $FLT_NEG="AND (".$FILTRO_NEG.")"; }
				}
				
				
				$SQL="SELECT COUNT(ID_ARCSAP) AS CUENTA FROM ARC_SAP WHERE  ID_ESTPRC>0 ".$FLT_TND."  ";
				

				$RS = sqlsrv_query($conn, $SQL);
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
				//$SQL="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM ARC_SAP WHERE  ID_ESTPRC>0 ".$FLT_TND."  ORDER BY ID_ARCSAP DESC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;
				//
				//oci_execute($RS);

				$SQL= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY ID_ARCSAP DESC) ROWNUMBER FROM ARC_SAP WHERE  ID_ESTPRC>0 ".$FLT_TND.") AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";

				$RS = sqlsrv_query($conn, $SQL);
               ?>
                <table id="Listado">
                <tr>
                    <th colspan="2" style="border-left:solid 6px #FFF">Tienda</th>
                    <th style="text-align:right">Lote</th>
                    <th style="text-align:right">Art&iacute;culos</th>
                    <th style="text-align:right">Errores</th>
                    <th style="text-align:right">C&oacute;digos EAN</th>
                    <th style="text-align:center">Estado</th>
                    <th style="text-align:center">Fecha</th>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){
                        $ID_ARCSAP = $row['ID_ARCSAP'];
                        $COD_TIENDA = $row['COD_TIENDA'];
								$SQL2="SELECT * FROM MN_TIENDA WHERE DES_CLAVE=".$COD_TIENDA;
								$RS2 = sqlsrv_query($maestra, $SQL2);
								//oci_execute($RS2);
								if ($row2 = sqlsrv_fetch_array($RS2)) {
									$DES_TIENDA = $row2['DES_TIENDA'];
								}
                        $NUM_LOTE = $row['NUM_LOTE'];
                        $NUM_ITEM = $row['NUM_ITEM'];
                        $NUM_ERRI = $row['NUM_ERRI'];
						$NUM_ERRI_F=number_format($NUM_ERRI, 0, ',', '.');
						$PORC_ERRI=($NUM_ERRI*100)/$NUM_ITEM;
						$PORC_ERRI_F=number_format($PORC_ERRI, 3, ',', '.');

                        $NUM_ITEM_F = $NUM_ITEM-$NUM_ERRI;
						$NUM_ITEM_F=number_format($NUM_ITEM_F, 0, ',', '.');

                        $NUM_EAN= $row['NUM_EAN'];
						$NUM_EAN_F=number_format($NUM_EAN, 0, ',', '.');
						$PORC_EAN=($NUM_EAN*100)/$NUM_ITEM;
						$PORC_EAN_F=number_format($PORC_EAN, 2, ',', '.');
						
                        $ID_ESTSAP= $row['ID_ESTPRC'];
						$SQL2="SELECT * FROM EST_PRC WHERE ID_ESTPRC=".$ID_ESTSAP;
						$RS2 = sqlsrv_query($conn, $SQL2);
						//oci_execute($RS2);
						if ($row2 = sqlsrv_fetch_array($RS2)) {
							$ESTADO_SAP = $row2['NOM_ESTPRC'];
							$COLOR_EST = $row2['COL_ESTPRC'];
							$CSS_EST = $row2['CSF_ESTADO'];
						}
						
                        $FECHA = $row['FECHA'];
                        $FECHA = date_format($FECHA,"d/m/Y");

						//VERIFICAR PRC_ND=NULL
						//$SQLT="SELECT PRC_ND FROM ARC_SAP WHERE ID_ARCSAP=".$ID_ARCSAP;
						
						//$RST = sqlsrv_query($conn, $SQLT);
						//oci_execute($RST);
						//if ($rowT = sqlsrv_fetch_array($RST)) {
						//	$PRC_ND = $rowT['PRC_ND'];
						//}

               ?>
					<script>
                    function Ocultar<?php echo $ID_ARCSAP?>(){
						var IdArcSap = <?php echo $ID_ARCSAP?>;
                        var mostrar = document.getElementById("mostrar"+IdArcSap);
                        var ocultar = document.getElementById("ocultar"+IdArcSap);
                        var SelecLote = document.getElementById("SelecLote"+IdArcSap);
                            mostrar.style.display = "table-cell";
                            ocultar.style.display = "none";
                            SelecLote.style.display = "none";
							for(j=1; j <= 6; j = j+1) {
								var TDL = document.getElementById("TDL"+j+"<?php echo $ID_ARCSAP?>");
									TDL.style.background = "";
									TDL.style.color = "";
							}
                    }
                    function Mostrar<?php echo $ID_ARCSAP?>(){
						var IdArcSap = <?php echo $ID_ARCSAP?>;
                        var mostrar = document.getElementById("mostrar"+IdArcSap);
                        var ocultar = document.getElementById("ocultar"+IdArcSap);
                        var SelecLote = document.getElementById("SelecLote"+IdArcSap);
                            mostrar.style.display = "none";
                            ocultar.style.display = "table-cell";
                            SelecLote.style.display = "table-row";
							for(j=1; j <= 6; j = j+1) {
								var TDL = document.getElementById("TDL"+j+"<?php echo $ID_ARCSAP?>");
									TDL.style.background = "#FFF";
							}
						<?php
						//SELECCIONAR TODO LO DISTINTO AL ID_ARCSAP
							$SQLJ="SELECT ID_ARCSAP FROM ARC_SAP WHERE ID_ARCSAP<>".$ID_ARCSAP;
							$RSJ = sqlsrv_query($conn, $SQLJ);
							//oci_execute($RSJ);
							while ($rowJ = sqlsrv_fetch_array($RSJ)) {
								$NO_ARCSAP = $rowJ['ID_ARCSAP'];
								?>
									var NoArcSap = <?php echo $NO_ARCSAP?>;
									var mostrar = document.getElementById("mostrar"+NoArcSap);
									var ocultar = document.getElementById("ocultar"+NoArcSap);
									var SelecLote = document.getElementById("SelecLote"+NoArcSap);
										mostrar.style.display = "table-cell";
										ocultar.style.display = "none";
										SelecLote.style.display = "none";
										for(j=1; j <= 6; j = j+1) {
											var TDL = document.getElementById("TDL"+j+"<?php echo $NO_ARCSAP?>");
												TDL.style.background = "";
												TDL.style.color = "";
										}
								<?php
							}
						?>
					}

                    function ToggleDepNeg<?php echo $ID_ARCSAP?>(){
						var IdArcSap = <?php echo $ID_ARCSAP?>;
                        var toggleDep = document.getElementById("toggleDep"+IdArcSap);
                        var toggleNeg = document.getElementById("toggleNeg"+IdArcSap);
                            toggleDep.style.display = "none";
                            toggleNeg.style.display = "table-row";
							<?php
							$SQLJ="SELECT COD_NEGOCIO FROM ARC_PRC WHERE ID_ARCSAP=".$ID_ARCSAP." GROUP BY COD_NEGOCIO";
							$RSJ = sqlsrv_query($conn, $SQLJ);
							//oci_execute($RSJ);
							while ($rowJ = sqlsrv_fetch_array($RSJ)) {
								$COD_NEGJ = $rowJ['COD_NEGOCIO'];
							?>
								var IdCodNegj = <?php echo $COD_NEGJ?>;
								var AccDepart = document.getElementById("AccDepart"+IdArcSap+IdCodNegj);
								var AccNegoc = document.getElementById("AccNegoc"+IdArcSap+IdCodNegj);
									AccDepart.style.display = "none";
									AccNegoc.style.display = "table-cell";
							<?php
							}
							?>
                    }
                    function ToggleNegDep<?php echo $ID_ARCSAP?>(){
						var IdArcSap = <?php echo $ID_ARCSAP?>;
                        var toggleDep = document.getElementById("toggleDep"+IdArcSap);
                        var toggleNeg = document.getElementById("toggleNeg"+IdArcSap);
                            toggleDep.style.display = "table-row";
                            toggleNeg.style.display = "none";
							<?php
							$SQLJ="SELECT COD_NEGOCIO FROM ARC_PRC WHERE ID_ARCSAP=".$ID_ARCSAP." GROUP BY COD_NEGOCIO";
							$RSJ = sqlsrv_query($conn, $SQLJ);
							//oci_execute($RSJ);
							while ($rowJ = sqlsrv_fetch_array($RSJ)) {
								$COD_NEGJ = $rowJ['COD_NEGOCIO'];
							?>
								var IdCodNegj = <?php echo $COD_NEGJ?>;
								var AccDepart = document.getElementById("AccDepart"+IdArcSap+IdCodNegj);
								var AccNegoc = document.getElementById("AccNegoc"+IdArcSap+IdCodNegj);
									AccDepart.style.display = "table-cell";
									AccNegoc.style.display = "none";
							<?php
							}
							?>
                    }
                    </script>
				<?php if($VLTE<>""){?>
								<script>
									function ShowVLTE<?php echo $VLTE?>(){
											var Vlte = <?php echo $VLTE?>;
											var mostrar = document.getElementById("mostrar"+Vlte);
											var ocultar = document.getElementById("ocultar"+Vlte);
											var SelecLote = document.getElementById("SelecLote"+Vlte);
                                                mostrar.style.display = "none";
                                                ocultar.style.display = "table-cell";
												SelecLote.style.display = "table-row";
                                                for(j=1; j <= 6; j = j+1) {
                                                    var TDL = document.getElementById("TDL"+j+"<?php echo $VLTE?>");
                                                        TDL.style.background = "#FFF";
                                                }
									}
                                </script>
                <?php }?>
				<?php if($ND==1){?>
								<script>
									function ShowNegocio<?php echo $VLTE?>(){
											var IdArcSap = <?php echo $VLTE?>;
											var toggleDep = document.getElementById("toggleDep"+IdArcSap);
											var toggleNeg = document.getElementById("toggleNeg"+IdArcSap);
												toggleDep.style.display = "none";
												toggleNeg.style.display = "table-row";
												<?php
												$SQLJ="SELECT COD_NEGOCIO FROM ARC_PRC WHERE ID_ARCSAP=".$VLTE." GROUP BY COD_NEGOCIO";
												$RSJ = sqlsrv_query($conn, $SQLJ);
												//oci_execute($RSJ);
												while ($rowJ = sqlsrv_fetch_array($RSJ)) {
													$COD_NEGJ = $rowJ['COD_NEGOCIO'];
												?>
													var IdCodNegj = <?php echo $COD_NEGJ?>;
													var AccDepart = document.getElementById("AccDepart"+IdArcSap+IdCodNegj);
													var AccNegoc = document.getElementById("AccNegoc"+IdArcSap+IdCodNegj);
														AccDepart.style.display = "none";
														AccNegoc.style.display = "table-cell";
												<?php
												}
												?>
									}
                                </script>
                <?php }?>

                <tr>
                     <td id="mostrar<?php echo $ID_ARCSAP?>" onClick="Mostrar<?php echo $ID_ARCSAP?>();" style="cursor:pointer;border: none; border-left:solid 6px <?php echo $COLOR_EST?>; max-width:20px "><img src="../images/ICO_ShowM.png"></td>
                     <td id="ocultar<?php echo $ID_ARCSAP?>" onClick="Ocultar<?php echo $ID_ARCSAP?>();" style="display:none; background:<?php echo $COLOR_EST?>; cursor:pointer;border: none;border-left:solid 6px <?php echo $COLOR_EST?>; max-width:20px  "><img src="../images/ICO_ShowB.png"></td>
                     <td id="TDL1<?php echo $ID_ARCSAP?>"><span style="font-weight:600; font-size:12pt"><?php echo " L".substr("0000".$COD_TIENDA, -4)?></span><br><span style="font-size:10pt"><?php echo $DES_TIENDA?></span></td>
                     <td id="TDL2<?php echo $ID_ARCSAP?>" style="text-align:right; vertical-align:middle; font-size:12pt"><?php echo $NUM_LOTE?></td>
                     <td id="TDL3<?php echo $ID_ARCSAP?>" style="text-align:right; vertical-align:middle; font-size:12pt"><?php echo $NUM_ITEM_F?></td>
                     <td id="TDL4<?php echo $ID_ARCSAP?>" style="text-align:right; vertical-align:middle; font-weight:700"><?php echo $NUM_ERRI_F?><br><span style="font-weight:400"><?php echo $PORC_ERRI_F."%"?></span></td>
                     <td id="TDL5<?php echo $ID_ARCSAP?>" style="text-align:right; vertical-align:middle; font-weight:700"><?php echo $NUM_EAN_F?><br><span style="font-weight:400"><?php echo $PORC_EAN_F."%"?></span></td>
                     <td id="ESTADO_PRECIO" style="text-align:center; vertical-align:middle; background-color:<?php echo $COLOR_EST?>; <?php echo $CSS_EST?>; font-weight:600;"><?php echo $ESTADO_SAP?></td>
                     <td id="TDL6<?php echo $ID_ARCSAP?>" style="text-align:center; vertical-align:middle"><?php echo $FECHA?></td>
                </tr>
                <!-- FILA DE SELECCION DE LOTES -->
                <tr id="SelecLote<?php echo $ID_ARCSAP?>" style="display:none">
                	<td colspan="8" style="padding:0; border-left:solid 6px <?php echo $COLOR_EST?>; border-top:none">
                			<table id="Listado" style="width:100%">
								<?php
								//if(is_null($PRC_ND)){
								?>
                                
								<!-- FILA DE SELECCION DE NEGOCIO/DEPTO -->
                                <tr id="toggleDep<?php echo $ID_ARCSAP?>">
                                    <td colspan="13" style="text-align:left; vertical-align:middle; background-color:#FFF; font-weight:600; border-left:solid 6px <?php echo $COLOR_EST?>">
                                            <style>
                                            #NDToggle<?php echo $ID_ARCSAP?> {
                                                width:128px; height:43px;
                                                background-image: url(images/ToggleNegDpt.png);
                                                background-position:bottom;
                                                display:inline;
                                                float:left;
												cursor:pointer;
                                            }
                                            </style>
                                            <div id="NDToggle<?php echo $ID_ARCSAP?>"><img src="images/Transpa.png" width="128" height="43" onClick="ToggleDepNeg<?php echo $ID_ARCSAP?>();"></div>
                                            <p style="display:inline; float:left; vertical-align:middle; font-weight:600; color:#777; margin:2px 0 0 10px">
                                                Depart.: Modo de proceso de Lotes por Departamento<br>Negocio: Modo de proceso de Lote por L&iacute;nea de Negocio
                                            </p>
                                    </td>
                                </tr>
                                <tr id="toggleNeg<?php echo $ID_ARCSAP?>" style="display:none">
                                    <td colspan="13" style="text-align:left; vertical-align:middle; background-color:#FFF; font-weight:600; border-left:solid 6px <?php echo $COLOR_EST?>">
                                            <style>
                                            #DNToggle<?php echo $ID_ARCSAP?> {
                                                width:128px; height:43px;
                                                background-image: url(images/ToggleNegDpt.png);
                                                background-position:top;
                                                display:inline;
                                                float:left;
												cursor:pointer;
                                            }
                                            </style>
                                            <div id="DNToggle<?php echo $ID_ARCSAP?>"><img src="images/Transpa.png" width="128" height="43" onClick="ToggleNegDep<?php echo $ID_ARCSAP?>();"></div>
                                            <p style="display:inline; float:left; vertical-align:middle; font-weight:600; color:#777; margin:2px 0 0 10px">
                                                Depart.: Modo de proceso de Lotes por Departamento<br>Negocio: Modo de proceso de Lote por L&iacute;nea de Negocio
                                            </p>
                                    </td>
                                </tr>
								<!-- FIN FILA DE SELECCION DE NEGOCIO/DEPTO -->
                                <?php
								//}
								?>



                                <tr>
                                    <th colspan="2" style="border-left:solid 6px <?php echo $COLOR_EST?>">L&iacute;nea de Negocio</th>
                                    <th style="text-align:right; ">Depts.</th>
                                    <th style="text-align:right; ">Art&iacute;culos</th>
                                    <th style="text-align:center; ">Neo</th>
                                    <th style="text-align:center; ">Act</th>
                                    <th style="text-align:center; ">Ret</th>
                                    <th style="text-align:center; ">Elm</th>
                                    <th style="text-align:right; ">Excepciones</th>
                                    <th style="text-align:right; ">Excs.Procs.</th>
                                    <th style="text-align:right; ">Rechazos</th>
                                    <th style="text-align:center; ">Estado</th>
                                    <th style="text-align:center; ">Acci&oacute;n</th>
                                </tr>
                                <?php
                                //OBTENER LOS NEGOCIOS ASOCIADOS AL ITEM
                                        $SQL2="SELECT COD_NEGOCIO FROM ARC_PRC WHERE ID_ARCSAP=".$ID_ARCSAP.$FLT_NEG." GROUP BY COD_NEGOCIO";
                                        $RS2 = sqlsrv_query($conn, $SQL2);
                                        //oci_execute($RS2);
                                        while ($row2 = sqlsrv_fetch_array($RS2)) {
                                            $COD_NEGOCIO = $row2['COD_NEGOCIO'];
                                            $SQL3="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO=".$COD_NEGOCIO;
                                            $RS3 = sqlsrv_query($maestra, $SQL3);
                                            //oci_execute($RS3);
                                            if ($row3 = sqlsrv_fetch_array($RS3)) {
                                                $DES_NEGOCIO= $row3['DES_NEGOCIO'];
                                            }
                                            $SQL3="SELECT COUNT(ID_ARCSAP) AS CTA_DEPTS FROM ARC_PRC WHERE ID_ARCSAP=".$ID_ARCSAP." AND COD_NEGOCIO=".$COD_NEGOCIO;
                                            $RS3 = sqlsrv_query($conn, $SQL3);
                                            //oci_execute($RS3);
                                            if ($row3 = sqlsrv_fetch_array($RS3)) {
                                                $CTA_DEPTS= $row3['CTA_DEPTS'];
                                            }
                                            $CTA_DEPTS_F=number_format($CTA_DEPTS, 0, ',', '.');
                                            $SQL3="SELECT SUM(NUM_ITEMS) AS SUM_ITEMS FROM ARC_PRC WHERE ID_ARCSAP=".$ID_ARCSAP." AND COD_NEGOCIO=".$COD_NEGOCIO;
                                            $RS3 = sqlsrv_query($conn, $SQL3);
                                            //oci_execute($RS3);
                                            if ($row3 = sqlsrv_fetch_array($RS3)) {
                                                $SUM_ITEMS= $row3['SUM_ITEMS'];
                                            }
                                            $SUM_ITEMS_F=number_format($SUM_ITEMS, 0, ',', '.');
                                            $SQL3="SELECT ID_ARCPRC FROM ARC_PRC WHERE ID_ARCSAP=".$ID_ARCSAP." AND COD_NEGOCIO=".$COD_NEGOCIO;
                                            $RS3 = sqlsrv_query($conn, $SQL3);
                                            //oci_execute($RS3);
                                            $SUM_ITEMSEX=0;
											$ID_ARCNEG="";
                                            while ($row3 = sqlsrv_fetch_array($RS3)) {
                                                $ID_ARCNEG= $row3['ID_ARCPRC'];
                                                $SQL4="SELECT NUM_ITEMS AS SUM_ITEMSEX FROM ARC_PRCEX WHERE ID_ARCPRC=".$ID_ARCNEG;
                                                $RS4 = sqlsrv_query($conn, $SQL4);
                                                //oci_execute($RS4);
                                                if ($row4 = sqlsrv_fetch_array($RS4)) {
                                                    $SUM_ITEMSEX= $SUM_ITEMSEX+$row4['SUM_ITEMSEX'];
                                                }
                                            }
                                            
                                            $SUM_ITEMSEX_F=number_format($SUM_ITEMSEX, 0, ',', '.');
                                            $PORC_ITEMSEX=($SUM_ITEMSEX*100)/$SUM_ITEMS;
                                            $PORC_ITEMSEX_F=number_format($PORC_ITEMSEX, 2, ',', '.');
											
											//CALCULO A-U-D
											$SQLN="SELECT * FROM ARC_PRC WHERE ID_ARCSAP=".$ID_ARCSAP." AND COD_NEGOCIO=".$COD_NEGOCIO;
											$RSN = sqlsrv_query($conn, $SQLN);
											//oci_execute($RSN);
											//DEFINE ARREGLO LOTES
											$aLoteCalc=array();
											$CANT_ADD=0;
											$CANT_UPD=0;
											$CANT_DEL=0;
											$CANT_ELM=0;
											while ($rowN = sqlsrv_fetch_array($RSN)) {
												$NMB_LOTE = $rowN['NOM_ARCLOTE'];
												$EST_LOTE = $rowN['ID_ESTPRC'];
												//$DIRLOCALCTA="_arc_tmp/".substr("000".$COD_TIENDA, -3)."_".substr("0000".$NUM_LOTE, -4)."/";
												//CAPTURAR
												if($EST_LOTE>7){$DIR_LOTE="/BKP/";}
												if($EST_LOTE==7){$DIR_LOTE="/PRC/";}
												if($EST_LOTE<7){$DIR_LOTE="/IN/";}
												if($EST_LOTE==3){$DIR_LOTE="/BKP/";}
												
												@$CapturaLinea=file_get_contents($DIR_SAP.$DIR_LOTE.$NMB_LOTE);
												//ARREGLO DE CAPTURA
												$aCaptLinea = array_values(array_filter(explode("\n",$CapturaLinea)));
												//INCREMENTAR
													foreach ($aCaptLinea as &$LineaCaptura) {
														array_push($aLoteCalc, $LineaCaptura);
													}				
											}

											//OBTENER CUENTAS DESDE ARREGLO
											foreach ($aLoteCalc as &$LineaDeCuenta) {
												$Accion=substr($LineaDeCuenta, 0, 1);
												if($Accion=="A"){$CANT_ADD=$CANT_ADD+1;}
												if($Accion=="U"){$CANT_UPD=$CANT_UPD+1;}
												if($Accion=="D"){$CANT_DEL=$CANT_DEL+1;}
												if($Accion=="X"){$CANT_ELM=$CANT_ELM+1;}
											}				
											$CANT_ADD_F=number_format($CANT_ADD, 0, ',', '.');
											$CANT_UPD_F=number_format($CANT_UPD, 0, ',', '.');
											$CANT_DEL_F=number_format($CANT_DEL, 0, ',', '.');
											$CANT_ELM_F=number_format($CANT_ELM, 0, ',', '.');								

                                            //ESTO FUNCIONA HASTA EL RECHAZO, LUEGO SOBRE 4 YA NO SIRVE
											$SQL3="SELECT MIN(ID_ESTPRC) AS MIN_ESTADO FROM ARC_PRC WHERE ID_ARCSAP=".$ID_ARCSAP." AND COD_NEGOCIO=".$COD_NEGOCIO;
                                            $RS3 = sqlsrv_query($conn, $SQL3);
                                            //oci_execute($RS3);
                                            if ($row3 = sqlsrv_fetch_array($RS3)) {
                                                $MIN_ESTADO= $row3['MIN_ESTADO'];
                                            }
											$SQL3="SELECT MAX(ID_ESTPRC) AS MAX_ESTADO FROM ARC_PRC WHERE ID_ARCSAP=".$ID_ARCSAP." AND COD_NEGOCIO=".$COD_NEGOCIO;
                                            $RS3 = sqlsrv_query($conn, $SQL3);
                                            //oci_execute($RS3);
                                            if ($row3 = sqlsrv_fetch_array($RS3)) {
                                                $MAX_ESTADO= $row3['MAX_ESTADO'];
                                            }
											//PREGUNTAR SI PASÓ EL RECHAZO, para obtener un nuevo MIN_ESTADO
											if($MAX_ESTADO>3){
													$SQL3="SELECT MIN(ID_ESTPRC) AS MIN_ESTADO FROM ARC_PRC WHERE ID_ESTPRC>3 AND ID_ARCSAP=".$ID_ARCSAP." AND COD_NEGOCIO=".$COD_NEGOCIO;
													$RS3 = sqlsrv_query($conn, $SQL3);
													//oci_execute($RS3);
													if ($row3 = sqlsrv_fetch_array($RS3)) {
														$MIN_ESTADO= $row3['MIN_ESTADO'];
													}
											}
											
                                            $SQL3="SELECT * FROM EST_PRC WHERE ID_ESTPRC=".$MIN_ESTADO;
                                            $RS3 = sqlsrv_query($conn, $SQL3);
                                            //oci_execute($RS3);
                                            if ($row3 = sqlsrv_fetch_array($RS3)) {
                                                $NOM_ESTPRC = $row3['NOM_ESTPRC'];
                                                $COL_ESTPRC = $row3['COL_ESTPRC'];
                                                $CSS_ESTPRC = $row3['CSF_ESTADO'];
                                            }
											if($CANT_ADD==0 and $CANT_DEL==0 and $CANT_ELM==0 and $CANT_UPD==0 and ($MIN_ESTADO==5 or $MIN_ESTADO==6))
											{
												$SQL_PROCESS="UPDATE ARC_PRC SET ID_ESTPRC=8 WHERE ID_ARCSAP=".$ID_ARCSAP." AND COD_NEGOCIO=".$COD_NEGOCIO;
												$RS_PROCESS = sqlsrv_query($conn, $SQL_PROCESS);
												$SQL_PROCESS="UPDATE ARC_SAP SET ID_ESTPRC=8 WHERE ID_ARCSAP=".$ID_ARCSAP;
												$RS_PROCESS = sqlsrv_query($conn, $SQL_PROCESS);
												?> <script>javascript:location.reload()</script><?php
												
											}
											//EXCEPCIONES PROCESADAS
											$EXCEPROCS = 0;
											$CONSULTA3="SELECT COUNT(ID_ARCPRC) AS EXCEPROCS FROM ARC_EXPRC WHERE ID_ARCPRC IN(SELECT ID_ARCPRC FROM ARC_PRC WHERE ID_ARCSAP=".$ID_ARCSAP." AND COD_NEGOCIO=".$COD_NEGOCIO.") ";
											$RS3 = sqlsrv_query($conn, $CONSULTA3);
											//oci_execute($RS3);
											if ($row3 = sqlsrv_fetch_array($RS3)) {
												$EXCEPROCS = $row3['EXCEPROCS'];
											}
					
											@$PORC_PROCS=($EXCEPROCS*100)/$SUM_ITEMSEX;
											$PORC_PROCS_F=number_format($PORC_PROCS, 1, ',', '.');
					
											$EXCEPROCS_F=number_format($EXCEPROCS, 0, ',', '.');
											
											//ARTICULOS RECHAZADOS
											$NUM_RECS=0;
                                            $SQL3="SELECT NUM_ITEMS FROM ARC_PRC WHERE ID_ESTPRC=3 AND ID_ARCSAP=".$ID_ARCSAP." AND COD_NEGOCIO=".$COD_NEGOCIO;
                                            $RS3 = sqlsrv_query($conn, $SQL3);
                                            //oci_execute($RS3);
                                            $SUM_ITEMSEX=0;
                                            while ($row3 = sqlsrv_fetch_array($RS3)) {
                                                $NUM_ITEMS_RECS= $row3['NUM_ITEMS'];
												$NUM_RECS=$NUM_RECS+$NUM_ITEMS_RECS;
                                            }
                                            
											$PORC_RECS=($NUM_RECS*100)/$SUM_ITEMS;
											$PORC_RECS_F=number_format($PORC_RECS, 1, ',', '.');
					
											$NUM_RECS_F=number_format($NUM_RECS, 0, ',', '.');
                                        ?>
										<script language="JavaScript">
                                        function EjecutaRechazo<?php echo $ID_ARCSAP.$COD_NEGOCIO?>(valAS, valNG, valND){
                                                        var aceptaEntrar = window.confirm("ESTA ACCION RETIRA EN FORMA DEFINITIVA EL LOTE DEL PROCESAMIENTO DE PRECIOS, ESTA SEGURO?");
                                                        if (aceptaEntrar) 
                                                        {
															 parent.location.href="reg_precios_reg.php?RECHAZA_LDN=1&ID_ARCSAP="+valAS+"&COD_NEGOCIO="+valNG+"&ND="+valND+" " ;
                                                        }  else  {
                                                            return false;
                                                        }
                                        } //EjecutaRechazo(theForm)
                                        function EjecutaProceso<?php echo $ID_ARCSAP.$COD_NEGOCIO?>(valAS, valNG){
                                                        var aceptaEntrar = window.confirm("ESTA ACCION INICIA EL PROCESO DE CAMBIO DE PRECIOS,  EN ADELANTE SOLO PODRA PROCESAR PRECIOS POR NEGOCIO... PRESIONE ACEPTAR PARA CONTINUAR");
                                                        if (aceptaEntrar) 
                                                        {
															 parent.location.href="reg_precios_reg.php?ACEPTAR_LDN=1&ID_ARCSAP="+valAS+"&COD_NEGOCIO="+valNG+" " ;
                                                        }  else  {
                                                            return false;
                                                        }
                                        } //EjecutaProceso(theForm)
                                        </script>
                                        <tr>
                                                <td colspan="2" style="border-left:solid 6px <?php echo $COL_ESTPRC?>; font-size:12pt; background-color:#FFF; vertical-align:middle"><?php echo $DES_NEGOCIO?></td>
                                                <td style="text-align:right; vertical-align:middle; font-size:12pt; background-color:#FFF"><?php echo $CTA_DEPTS_F?></td>
                                                <td style="text-align:right; vertical-align:middle; font-size:12pt; background-color:#FFF"><?php echo $SUM_ITEMS_F?></td>
                                                <td style="text-align:right; vertical-align:middle; font-size:12pt; background-color:#FFF"><?php echo $CANT_ADD_F?></td>
                                                <td style="text-align:right; vertical-align:middle; font-size:12pt; background-color:#FFF"><?php echo $CANT_UPD_F?></td>
                                                <td style="text-align:right; vertical-align:middle; font-size:12pt; background-color:#FFF"><?php echo $CANT_DEL_F?></td>
                                                <td style="text-align:right; vertical-align:middle; font-size:12pt; background-color:#FFF"><?php echo $CANT_ELM_F?></td>
                                                <td style="text-align:right; vertical-align:middle; background-color:#FFF"><strong><?php echo $SUM_ITEMSEX_F?></strong><BR><?php echo $PORC_ITEMSEX_F."%"?></td>
                                                <td style="text-align:right; vertical-align:middle; background-color:#FFF"><strong><?php echo $EXCEPROCS_F?></strong><BR><?php echo $PORC_PROCS_F."%"?></td>
                                                <td style="text-align:right; vertical-align:middle; background-color:#FFF"><strong><?php echo $NUM_RECS_F?></strong><BR><?php echo $PORC_RECS_F."%"?></td>
                                                <td style="text-align:center; vertical-align:middle; background-color:<?php echo $COL_ESTPRC;?>; <?php echo $CSS_ESTPRC?>; font-weight:600;"><?php echo $NOM_ESTPRC?></td>
                                                

												<?php
												//if(is_null($PRC_ND) || $PRC_ND=="D"){
												?>
                                                 <!-- TABLA ACCIONES DEPARTAMENTOS -->
                                                 <td id="AccDepart<?php echo $ID_ARCSAP.$COD_NEGOCIO?>" style="background-color:#555; border-bottom:solid 1px #999">
                                                         <style>
                                                            #AccionD<?php echo $ID_ARCSAP.$COD_NEGOCIO;?> {
                                                                width: 100%;
                                                            }
                                                            #AccionD<?php echo $ID_ARCSAP.$COD_NEGOCIO;?> tr {
                                                                background:transparent !important;
                                                            }
                                                            #AccionD<?php echo $ID_ARCSAP.$COD_NEGOCIO;?> td {
                                                                padding:0 2px 0 0;
                                                                background:transparent !important;
                                                                border:none;
                                                                width:33%;
                                                            }
                                                         </style>
                                                         <table id="AccionD<?php echo $ID_ARCSAP.$COD_NEGOCIO;?>">
                                                                <tr>
                                                                    <td>
                                                                            <input style="width:100%" type="button"value="Ver Lotes" name="LOTES" onClick="pagina('reg_precios.php?LOTE=<?php echo $ID_ARCSAP;?>&LDN=<?php echo $COD_NEGOCIO;?>');">
                                                                    </td>
																	<?php if($MIN_ESTADO<=2){ ?>
                                                                    <td>
                                                                            <input style="width:100%" id="BotonRojoProc" type="button"value="Rechazar" name="RECHAZA_LDN"  onClick="return EjecutaRechazo<?php echo $ID_ARCSAP.$COD_NEGOCIO;?>('<?php echo $ID_ARCSAP;?>','<?php echo $COD_NEGOCIO;?>','0')">
                                                                    </td>
                                                                    <?php } ?>
																	<?php if($MIN_ESTADO==4){ ?>
                                                                    <td>
                                                                            <input type="button" style="width:100%" id="BotonVerdeProc" value="Generar Flejes" name="SELECCIONAR"  onClick="paginaPrintGI('reg_flejes_reg.php?GENARC_LDN=1&ID_ARCSAP=<?php echo $ID_ARCSAP;?>&LDN=<?php echo $COD_NEGOCIO;?>','<?php echo $SUM_ITEMS?>');" >
                                                                    </td>
                                                                    <?php } ?>
																	<?php if($MIN_ESTADO==5 || $MIN_ESTADO==6){ ?>
                                                                    <td>
                                                                    <?php
																	$ALL_PRT=1;
																	$SQLV="SELECT * FROM ARC_ITEMS WHERE ID_ARCPRC IN(SELECT ID_ARCPRC FROM ARC_PRC WHERE ID_ARCSAP=".$ID_ARCSAP." AND COD_NEGOCIO=".$COD_NEGOCIO.") ORDER BY ID_ARCITEM ASC";
																	$RSV = sqlsrv_query($conn, $SQLV);
																	//oci_execute($RSV);
																	while ($rowV = sqlsrv_fetch_array($RSV)) {
																			$PRT_EST = $rowV['ESTADO'];
																			if($PRT_EST==0){$ALL_PRT=0;}
																	}
																	if($ALL_PRT==1){ 
																	?>
																	 <input type="button" style="width:100%" id="BotonVerdeProc"  value="Activar Cambio de Precios" name="ACTIVAR"  onClick="paginaActCP('reg_flejes_reg.php?ACTIVAR_CPNEG=1&ID_ARCSAP=<?php echo $ID_ARCSAP;?>&LDN=<?php echo $COD_NEGOCIO;?>');">
																	<?php
																	
																	}	?>
                                                                           
                                                                    </td>
                                                                    <?php } ?>
																	<?php if($MIN_ESTADO>=5){ ?>
																			<?php
                                                                            //VERIFICAR SI HAY FLEJES PARA IMPRESION
                                                                            $PrintFlejes=$CANT_ADD+$CANT_UPD;
                                                                            if($PrintFlejes<>0){
                                                                            ?>
                                                                                         <td>
                                                                                        <style>
                                                                                            #RegImpFlejes<?php echo $ID_ARCSAP.$COD_NEGOCIO?> {position:absolute; width:100%;height:300%;margin: 0 auto;left: 0;top:0;background-image: url(images/TranspaBlack72.png);background-repeat: repeat;background-position: left top;z-index:10000;}
                                                                                            #RegImpFlejes-contenedor<?php echo $ID_ARCSAP.$COD_NEGOCIO?>{position:absolute;width:auto;height:auto; max-width:890px; min-width:400px; overflow:visible;left: 100px;top:50px;padding-top:16px;padding-bottom:20px;padding-left:20px;padding-right:20px;background-color:#444;color:#F1F1F1; text-shadow:none; border:1px solid #FFCC00; -khtml-border-radius: 6px;-moz-border-radius: 6px;-webkit-border-radius: 6px;border-radius: 6px;}
                                                                                        </style>
                                                                                        <script>
                                                                                             function ActivarVentFlejes<?php echo $ID_ARCSAP.$COD_NEGOCIO?>(){
                                                                                                    var contenedor = document.getElementById("RegImpFlejes<?php echo $ID_ARCSAP.$COD_NEGOCIO?>");
                                                                                                    contenedor.style.display = "block";
                                                                                                    return true;
                                                                                                }
                                                                                                
                                                                                             function CerrarVentFlejes<?php echo $ID_ARCSAP.$COD_NEGOCIO?>(){
                                                                                                    var contenedor = document.getElementById("RegImpFlejes<?php echo $ID_ARCSAP.$COD_NEGOCIO?>");
                                                                                                    contenedor.style.display = "none";
                                                                                                    return true;
                                                                                                }
                                                                                        </script>
                                                                                        <?php
                                                                                        //VERIFICA SI RESTAN ARCHIVOS DE IMPRESION (POR ESTADO)
                                                                                        $ALL_PRT=1;
                                                                                        $SQLV="SELECT * FROM ARC_ITEMS WHERE ID_ARCPRC IN(SELECT ID_ARCPRC FROM ARC_PRC WHERE ID_ARCSAP=".$ID_ARCSAP." AND COD_NEGOCIO=".$COD_NEGOCIO.") ORDER BY ID_ARCITEM ASC";
                                                                                        $RSV = sqlsrv_query($conn, $SQLV);
                                                                                        //oci_execute($RSV);
                                                                                        while ($rowV = sqlsrv_fetch_array($RSV)) {
                                                                                                $PRT_EST = $rowV['ESTADO'];
                                                                                                if($PRT_EST==0){$ALL_PRT=0;}
                                                                                        }
                                                                                        if($ALL_PRT==0){ $StyleBT="ComandaBot";}
                                                                                        if($ALL_PRT==1){ $StyleBT="ReComandaBot";}
                                    
                                                                                        ?>
                                                                                        <input type="button" id="<?php echo $StyleBT?>" value="Flejes" name="SELECCIONAR" onClick="ActivarVentFlejes<?php echo $ID_ARCSAP.$COD_NEGOCIO?>();">
                                                                                        </td>
                                                                            <?php
                                                                            }//$PrintFlejes<>0
                                                                    } ?>
                                                                </tr>
                                                        </table>
                                                        <div id="RegImpFlejes<?php echo $ID_ARCSAP.$COD_NEGOCIO?>" style="display:none">
                                                            <div id="RegImpFlejes-contenedor<?php echo $ID_ARCSAP.$COD_NEGOCIO?>">
                                                                    <span style="position:absolute; top:0; right:10px;"><a href="#" onClick="javascript: CerrarVentFlejes<?php echo $ID_ARCSAP.$COD_NEGOCIO?>();" title="Cerrar ventana"><img src="../images/ICO_CloseYL.png" border="0"></a></span>
                                                                    <h3>Imprime Flejes de Actualizaci&oacute;n de Precios</h3>
                                                                    <p style="margin-bottom:20px; margin-top:0; font-size:12pt">Lote <?php echo $NUM_LOTE?>: <?php echo $DES_NEGOCIO?> - <?php echo " L".substr("0000".$COD_TIENDA, -4)?><br><?php echo $DES_TIENDA?></p>
                                                                    <?php
                                                                    //SELECCIONA EL O LOS ARCHIVOS ASOCIADOS PARA IMPRESION
                                                                    $NUM_ARCHIVO=1;
                                                                    $SQLA="SELECT * FROM ARC_ITEMS WHERE ID_ARCPRC IN(SELECT ID_ARCPRC FROM ARC_PRC WHERE ID_ARCSAP=".$ID_ARCSAP." AND COD_NEGOCIO=".$COD_NEGOCIO.") ORDER BY ID_ARCITEM ASC";
                                                                    $RSA = sqlsrv_query($conn, $SQLA);
                                                                    //oci_execute($RSA);
                                                                    while ($rowA = sqlsrv_fetch_array($RSA)) {
                                                                            $ID_ARCITEM = $rowA['ID_ARCITEM'];
                                                                            $ID_ARCPRC = $rowA['ID_ARCPRC'];
																			$SQLA1="SELECT * FROM ARC_PRC WHERE ID_ARCPRC=".$ID_ARCPRC;
																			$RSA1 = sqlsrv_query($conn, $SQLA1);
																			//oci_execute($RSA1);
																			if ($rowA1 = sqlsrv_fetch_array($RSA1)) {
																				$CD_DPT_PS = $rowA1['CD_DPT_PS'];
																			}
																			$RSA1="SELECT * FROM ID_DPT_PS WHERE CD_DPT_PS=".$CD_DPT_PS;
																			$RSA1 = sqlsrv_query($arts_conn, $RSA1);
																			//oci_execute($RSA1);
																			if ($rowA1 = sqlsrv_fetch_array($RSA1)) {
																				$NM_DPT_PS = $rowA1['NM_DPT_PS'];
																			}
                                                                            $ARCHIVO = $rowA['ARCHIVO'];
                                                                            $ESTADO = $rowA['ESTADO'];
                                                                            @$ELARCHIVO = "_arc_prt/".$ARCHIVO;
                                                                            @$lines = file($ELARCHIVO);
                                                                            $NUM_FLEJES = count($lines);
                                                                            if($ESTADO==0){
                                                                            ?>
                                                                                    <input type="button" id="PrintBot" value="<?php echo substr($NM_DPT_PS, 0, 16)."\nFlejes: ".substr("0000".$NUM_FLEJES, -4);?>" name="SELECCIONAR"  onClick="paginaPrintCP('reg_flejes_reg.php?PRTFLJ=1&ID_ARCITEM=<?php echo $ID_ARCITEM;?>&VLTE=<?php echo $ID_ARCSAP;?>');">
                                                                            <?php
                                                                            }
                                                                            if($ESTADO==1){
                                                                            ?>
                                                                                    <input type="button" id="RePrintBot" value="<?php echo substr($NM_DPT_PS, 0, 16)."\nFlejes: ".substr("0000".$NUM_FLEJES, -4);?>" name="SELECCIONAR"  onClick="paginaPrintCP('reg_flejes_reg.php?PRTFLJ=2&ID_ARCITEM=<?php echo $ID_ARCITEM;?>&VLTE=<?php echo $ID_ARCSAP;?>');">
                                                                            <?php
                                                                            }
                                                                        $NUM_ARCHIVO=$NUM_ARCHIVO+1;
                                                                    }
                                                                ?>
                                                            </div>
                                                        </div>
                                                 </td>
                                                 <!-- FIN TABLA ACCIONES DEPARTAMENTOS -->
												<?php
												//}
												$DisplayTDN="none";
												//if(is_null($PRC_ND) || $PRC_ND=="N"){
												//	if($PRC_ND=="N"){$DisplayTDN="table-cell";}
												?>
                                                 <!-- TABLA ACCIONES NEGOCIO -->
                                                 <td id="AccNegoc<?php echo $ID_ARCSAP.$COD_NEGOCIO?>" style="display:<?php echo $DisplayTDN;?>; background-color:#555; border-bottom:solid 1px #999">
                                                         <style>
                                                            #AccionN<?php echo $ID_ARCSAP.$COD_NEGOCIO;?> {
                                                                width: 100%;
                                                            }
                                                            #AccionN<?php echo $ID_ARCSAP.$COD_NEGOCIO;?> tr {
                                                                background:transparent !important;
                                                            }
                                                            #AccionN<?php echo $ID_ARCSAP.$COD_NEGOCIO;?> td {
                                                                padding:0 2px 0 0;
                                                                background:transparent !important;
                                                                border:none;
                                                                width:33%;
                                                            }
                                                         </style>
                                                         <table id="AccionN<?php echo $ID_ARCSAP.$COD_NEGOCIO;?>">
                                                                <tr>
																	<?php if($MIN_ESTADO<>3){ ?>
                                                                    <td>
                                                                            <input style="width:100%" type="button" value="Lista de Art&iacute;culos" name="LISTADO" onClick="pagina('reg_precios.php?ARTSNEG=<?php echo $ID_ARCSAP;?>&LDN=<?php echo $COD_NEGOCIO;?>');">
                                                                    </td>
                                                                    <?php } ?>
																	<?php if($MIN_ESTADO==3){ ?>
                                                                    <td>
                                                                            <input style="width:100%" type="button" value="Ver Art&iacute;culos por Departamento" name="LOTES" onClick="pagina('reg_precios.php?LOTE=<?php echo $ID_ARCSAP;?>&LDN=<?php echo $COD_NEGOCIO;?>');">
                                                                    </td>
                                                                    <?php } ?>
																	<?php if($MIN_ESTADO==1){ ?>
                                                                     <td>
                                                                            <input style="width:100%" type="button" value="Excepciones" name="LISTADO" onClick="pagina('reg_precios.php?EXCEPNEG=<?php echo $ID_ARCSAP;?>&LDN=<?php echo $COD_NEGOCIO;?>');">
                                                                    </td>
                                                                    <?php } ?>
																	<?php if($MIN_ESTADO==2){ ?>
                                                                     <td>
                                                                            <input style="width:100%" type="button" id="BotonVerdeProc" value="Procesar" name="ACEPTAR" onClick="return EjecutaProceso<?php echo $ID_ARCSAP.$COD_NEGOCIO;?>('<?php echo $ID_ARCSAP;?>','<?php echo $COD_NEGOCIO;?>')">
                                                                    </td>
                                                                    <?php } ?>
																	<?php if($MIN_ESTADO<=2){ ?>
                                                                     <td>
                                                                            <input style="width:100%" type="button" id="BotonRojoProc" value="Rechazar" name="RECHAZA_LDN"  onClick="return EjecutaRechazo<?php echo $ID_ARCSAP.$COD_NEGOCIO;?>('<?php echo $ID_ARCSAP;?>','<?php echo $COD_NEGOCIO;?>','1')">
                                                                    </td>
                                                                    <?php } ?>
																	<?php if($MIN_ESTADO==4){ ?>
                                                                    <td>
                                                                            <input type="button" style="width:100%" id="BotonVerdeProc" value="Generar Flejes" name="SELECCIONAR"  onClick="paginaPrintGI('reg_flejes_reg.php?GENARC_LDN=1&ID_ARCSAP=<?php echo $ID_ARCSAP;?>&LDN=<?php echo $COD_NEGOCIO;?>&ND=1','<?php echo $SUM_ITEMS?>');" >
                                                                    </td>
                                                                    <?php } ?>
																	<?php if($MIN_ESTADO==5 || $MIN_ESTADO==6){ ?>
                                                                    <td>
                                                                     <?php
																	$ALL_PRT=1;
																	$SQLV="SELECT * FROM ARC_ITEMS WHERE ID_ARCPRC IN(SELECT ID_ARCPRC FROM ARC_PRC WHERE ID_ARCSAP=".$ID_ARCSAP." AND COD_NEGOCIO=".$COD_NEGOCIO.") ORDER BY ID_ARCITEM ASC";
																	$RSV = sqlsrv_query($conn, $SQLV);
																	//oci_execute($RSV);
																	while ($rowV = sqlsrv_fetch_array($RSV)) {
																			$PRT_EST = $rowV['ESTADO'];
																			if($PRT_EST==0){$ALL_PRT=0;}
																	}
																	if($ALL_PRT==1){ 
																	?>
																	 <input type="button" style="width:100%" id="BotonVerdeProc"  value="Activar Cambio de Precios" name="ACTIVAR"  onClick="paginaActCP('reg_flejes_reg.php?ACTIVAR_CPNEG=1&ID_ARCSAP=<?php echo $ID_ARCSAP;?>&LDN=<?php echo $COD_NEGOCIO;?>');">
																	<?php
																	
																	}	?>
                                                                    </td>
                                                                    <?php } ?>
																	<?php if($MIN_ESTADO>=5){ ?>
																			<?php
                                                                            //VERIFICAR SI HAY FLEJES PARA IMPRESION
                                                                            $PrintFlejes=$CANT_ADD+$CANT_UPD;
                                                                            if($PrintFlejes<>0){
                                                                            ?>
                                                                                         <td>
                                                                                        <style>
                                                                                            #RegImpFlejesNeg<?php echo $ID_ARCSAP.$COD_NEGOCIO?> {position:absolute; width:100%;height:300%;margin: 0 auto;left: 0;top:0;background-image: url(images/TranspaBlack72.png);background-repeat: repeat;background-position: left top;z-index:10000;}
                                                                                            #RegImpFlejesNeg-contenedor<?php echo $ID_ARCSAP.$COD_NEGOCIO?>{position:absolute;width:auto;height:auto; max-width:890px; min-width:400px; overflow:visible;left: 100px;top:50px;padding-top:16px;padding-bottom:20px;padding-left:20px;padding-right:20px;background-color:#444;color:#F1F1F1; text-shadow:none; border:1px solid #FFCC00; -khtml-border-radius: 6px;-moz-border-radius: 6px;-webkit-border-radius: 6px;border-radius: 6px;}
                                                                                        </style>
                                                                                        <script>
                                                                                             function ActivarVentFlejesNeg<?php echo $ID_ARCSAP.$COD_NEGOCIO?>(){
                                                                                                    var contenedor = document.getElementById("RegImpFlejesNeg<?php echo $ID_ARCSAP.$COD_NEGOCIO?>");
                                                                                                    contenedor.style.display = "block";
                                                                                                    return true;
                                                                                                }
                                                                                                
                                                                                             function CerrarVentFlejesNeg<?php echo $ID_ARCSAP.$COD_NEGOCIO?>(){
                                                                                                    var contenedor = document.getElementById("RegImpFlejesNeg<?php echo $ID_ARCSAP.$COD_NEGOCIO?>");
                                                                                                    contenedor.style.display = "none";
                                                                                                    return true;
                                                                                                }
                                                                                        </script>
                                                                                        <?php
                                                                                        //VERIFICA SI RESTAN ARCHIVOS DE IMPRESION (POR ESTADO)
                                                                                        $ALL_PRT=1;
                                                                                        $SQLV="SELECT * FROM ARC_ITEMS WHERE ID_ARCPRC IN(SELECT ID_ARCPRC FROM ARC_PRC WHERE ID_ARCSAP=".$ID_ARCSAP." AND COD_NEGOCIO=".$COD_NEGOCIO.") ORDER BY ID_ARCITEM ASC";
                                                                                        $RSV = sqlsrv_query($conn, $SQLV);
                                                                                        //oci_execute($RSV);
                                                                                        while ($rowV = sqlsrv_fetch_array($RSV)) {
                                                                                                $PRT_EST = $rowV['ESTADO'];
                                                                                                if($PRT_EST==0){$ALL_PRT=0;}
                                                                                        }
                                                                                        if($ALL_PRT==0){ $StyleBT="ComandaBot";}
                                                                                        if($ALL_PRT==1){ $StyleBT="ReComandaBot";}
                                    
                                                                                        ?>
                                                                                        <input type="button" id="<?php echo $StyleBT?>" value="Flejes" name="SELECCIONAR" onClick="ActivarVentFlejesNeg<?php echo $ID_ARCSAP.$COD_NEGOCIO?>();">
                                                                                        </td>
                                                                            <?php
                                                                            }//$PrintFlejes<>0
                                                                    } ?>
                                                                </tr>
                                                        </table>
                                                        <div id="RegImpFlejesNeg<?php echo $ID_ARCSAP.$COD_NEGOCIO?>" style="display:none">
                                                            <div id="RegImpFlejesNeg-contenedor<?php echo $ID_ARCSAP.$COD_NEGOCIO?>">
                                                                    <span style="position:absolute; top:0; right:10px;"><a href="#" onClick="javascript: CerrarVentFlejesNeg<?php echo $ID_ARCSAP.$COD_NEGOCIO?>();" title="Cerrar ventana"><img src="../images/ICO_CloseYL.png" border="0"></a></span>
                                                                    <h3>Imprime Flejes de Actualizaci&oacute;n de Precios</h3>
                                                                    <p style="margin-bottom:20px; margin-top:0; font-size:12pt">Lote <?php echo $NUM_LOTE?>: <?php echo $DES_NEGOCIO?> - <?php echo " L".substr("0000".$COD_TIENDA, -4)?><br><?php echo $DES_TIENDA?></p>
                                                                    <?php
                                                                    //SELECCIONA EL O LOS ARCHIVOS ASOCIADOS PARA IMPRESION
                                                                    $NUM_ARCHIVO=1;
                                                                    $SQLA="SELECT * FROM ARC_ITEMS WHERE ID_ARCPRC IN(SELECT ID_ARCPRC FROM ARC_PRC WHERE ID_ARCSAP=".$ID_ARCSAP." AND COD_NEGOCIO=".$COD_NEGOCIO.") ORDER BY ID_ARCITEM ASC";
                                                                    $RSA = sqlsrv_query($conn, $SQLA);
                                                                    //oci_execute($RSA);
                                                                    while ($rowA = sqlsrv_fetch_array($RSA)) {
                                                                            $ID_ARCITEM = $rowA['ID_ARCITEM'];
                                                                            $ID_ARCPRC = $rowA['ID_ARCPRC'];
																			$SQLA1="SELECT * FROM ARC_PRC WHERE ID_ARCPRC=".$ID_ARCPRC;
																			$RSA1 = sqlsrv_query($conn, $SQLA1);
																			//oci_execute($RSA1);
																			if ($rowA1 = sqlsrv_fetch_array($RSA1)) {
																				$CD_DPT_PS = $rowA1['CD_DPT_PS'];
																			}
																			$RSA1="SELECT * FROM ID_DPT_PS WHERE CD_DPT_PS=".$CD_DPT_PS;
																			$RSA1 = sqlsrv_query($arts_conn, $RSA1);
																			//oci_execute($RSA1);
																			if ($rowA1 = sqlsrv_fetch_array($RSA1)) {
																				$NM_DPT_PS = $rowA1['NM_DPT_PS'];
																			}
                                                                            $ARCHIVO = $rowA['ARCHIVO'];
                                                                            $ESTADO = $rowA['ESTADO'];
                                                                            $ELARCHIVO = "_arc_prt/".$ARCHIVO;
                                                                            $lines = file($ELARCHIVO);
                                                                            $NUM_FLEJES = count($lines);
                                                                            if($ESTADO==0){
                                                                            ?>
                                                                                    <input type="button" id="PrintBot" value="<?php echo $NM_DPT_PS."\nFlejes: ".substr("0000".$NUM_FLEJES, -4);?>" name="SELECCIONAR"  onClick="paginaPrintCP('reg_flejes_reg.php?PRTFLJ=1&ID_ARCITEM=<?php echo $ID_ARCITEM;?>&VLTE=<?php echo $ID_ARCSAP;?>&ND=1');">
                                                                            <?php
                                                                            }
                                                                            if($ESTADO==1){
                                                                            ?>
                                                                                    <input type="button" id="RePrintBot" value="<?php echo $NM_DPT_PS."\nFlejes: ".substr("0000".$NUM_FLEJES, -4);?>" name="SELECCIONAR"  onClick="paginaPrintCP('reg_flejes_reg.php?PRTFLJ=2&ID_ARCITEM=<?php echo $ID_ARCITEM;?>&VLTE=<?php echo $ID_ARCSAP;?>&ND=1');">
                                                                            <?php
                                                                            }
                                                                        $NUM_ARCHIVO=$NUM_ARCHIVO+1;
                                                                    }
                                                                ?>
                                                            </div>
                                                        </div>
                                               </td>
                                             <!-- FIN TABLA ACCIONES NEGOCIO -->
												<?php
												//} //if($PRC_ND=="N")
												?>


                                        </tr>
                                        <?php
                                        }//FIN WHILE NEGOCIOS
                                        ?>
                			</table>
                    </td>
                </tr>
                <!-- FIN FILA DE SELECCION DE LOTES -->
                <?php
                }//FIN WHILE ITEM
				?>
                <tr>
                    <td colspan="13" nowrap style="background-color:transparent">
                    <?php
                    if ($LINF>=$CTP+1) {
						$ATRAS=$LINF-$CTP;
						$FILA_ANT=$LSUP-$CTP;
                   ?>
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('reg_precios.php?LSUP=<?php echo $FILA_ANT?>&LINF=<?php echo $ATRAS?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('reg_precios.php?LSUP=<?php echo $FILA_POS?>&LINF=<?php echo $ADELANTE?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina <?php echo $NUMPAG?> de <?php echo $NUMTPAG?></span>
                </td>
                </tr>
                </table>
        <?php }//if($LIST==1){?>


		<?php include("reg_precios_lote.php");?>
        <?php include("reg_precios_arts.php");?>

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
