<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php

	$PAGINA=1175;
	$NOMENU=1;
	$LINK=1;
    $MSJE=@$_GET["MSJE"];

    //VERIFICA SELECCION DE LOCAL
	$TIENDA=$_POST["TIENDA"];
	if(empty($TIENDA)){ $TIENDA=@$_GET["tnd"] ;}
	if(empty($TIENDA)){ $TIENDA=0 ;}
	//$TIENDA=100;
	if ($TIENDA<>0) {

		$_SESSION['TIENDA_SEL'] = $TIENDA;	
	} else {

		$_SESSION['TIENDA_SEL'] = 0;	
	}

	//IDIOMA TITULOS INDICAT
    $IDIOMA=$_POST["IDIOMA"];
        if ($IDIOMA=="ESP") {
            $_SESSION['LAN_INDICAT'] = "DES_ES";    
        }
        if ($IDIOMA=="ENG") {

            $_SESSION['LAN_INDICAT'] = "DES_EN";    
        }           
        if (!isset($_SESSION['LAN_INDICAT'])) {

            $_SESSION['LAN_INDICAT'] = "DES_EN";   
        }	

        $LAN = $_SESSION['LAN_INDICAT'];
?>

<script>

		function getDocHeight(doc) {
		doc = doc || document;
		var body = doc.body, html = doc.documentElement;
		var height = Math.max( body.scrollHeight, body.offsetHeight, 
			html.clientHeight, html.scrollHeight, html.offsetHeight );
		return height;
		}

		function setIframeAlto(id) {

			var ifrm = document.getElementById(id);
			var doc = ifrm.contentDocument? ifrm.contentDocument: 
				ifrm.contentWindow.document;
			ifrm.style.visibility = 'hidden';
			ifrm.style.height = "10px"; 
			ifrm.style.height = getDocHeight( doc ) + 20 + "px";
			ifrm.style.visibility = 'visible';
		}

</script>
<style>
#MMNV {

	width: 100%;
	display: block;
	text-align: left;
	border-bottom: 1px solid #DFDFDF;
	background-color: #FBFBFB;
	height: 50px
}



#MMNV h1 {

	font-size: 18pt;
	letter-spacing: -0.025em;
	float: left;
	display: inline;
	margin-top: 12px;
	margin-bottom: 0;
}

#MMNV ul {

	margin: 0;
	padding: 0;
	float: left;
}

#MMNV li {
	font-weight: 600;
	list-style: none;
	float: left;
	padding: 8px 6px;
	margin: 6px 0 6px 4px;
	text-decoration: none;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
	cursor: pointer;
}

#MMNV ul li {

	border: 1px solid #DFDFDF;
	background-color: #FBFBFB;
}



#MMNV ul li:hover {

	border: 1px solid #B2B2B2;
}



#MMNV .activo {

	background-color: #6A6B6A;
	border: 1px solid #6A6B6A;
	color: #FFF
}

.OpcActivo {

	color: #7A2A9C;
	background-image: url(../images/BackMenuAct.png);
	background-repeat: no-repeat;
	background-position: left center;
	text-align: left;
}

.OpcInActivo {

	color: #333333;
	background-image: none;
}

#FormaPers, #FormaPersInner {

	display: inline;
	width: 100%;
	max-width: 600px;
	margin: 0 0 0 10px;
	padding: 0;
}

</style>
</head>
<body>

<?php include("encabezado.php");?>
<?php include("titulo_menu.php");?>
<table width="100%" height="100%">

  <?php
	// Inicio Seleccion de Tienda
	if(!empty($_SESSION['TIENDA_SEL'])){ 

?>
  <tr>
    <td align="right"  width="200" bgcolor="#FFFFFF"><?php include("menugeneral.php");?></td>
    <td><?php
if ($MSJE==1) {$ELMSJ="Mejoras";} 
if ($MSJE <> "") {

?>

      <div id="GMessaje" onClick="QuitarGMessage();"><a href="#" onClick="QuitarGMessage();" style="color:#111111;"><?php echo $ELMSJ?></a></div>
      <?php }?>
      <table width="100%" height:"100%">

        <tr>
          <td><!--Menu nivel 1-->
            <div id="MMNV">
              <ul>
                <?php

                                $SQL="SELECT * FROM PA_OPCMENU WHERE PUBLICA=1 AND COD_NVL2=0 AND COD_NVL3=0 ORDER BY POSICION ASC, COD_NVL1 ASC";
                                $RS = sqlsrv_query($conn, $SQL);
                                
                                //oci_execute($RS);
                                while ($row = sqlsrv_fetch_array($RS)){
                                		if(strcmp($LAN,"DES_EN") !== 0){
                                        	$DES_NVL =$row['DES_ES'];
                                        	$DES_NVL = utf8_encode($DES_NVL);
                                    	}else{
                                    		$DES_NVL =$row['DES_EN'];
                                    	}
                                        $COD_NVL = $row['COD_NVL1'];
                                        $ARC_NVL = $row['ARCHIVO'];
										if(empty($ARC_NVL) or is_null($ARC_NVL)){ $FRM_NVL=0; } else { $FRM_NVL=1; }
                                ?>
                			<style>

                                    #MMSB<?=$COD_NVL?> {width:200px; float:left; text-align:left; position:inherit;}
                                    #MMSB<?=$COD_NVL?> ul {margin:0;padding:0;}
                                    #MMSB<?=$COD_NVL?> li {font-weight:600;list-style:none; width:180px;padding: 8px 10px 8px 30px;margin: 0;text-decoration: none;cursor:pointer}
                                    #MMSB<?=$COD_NVL?> ul li {border-bottom:1px solid #DFDFDF;background-color: #FBFBFB;}
                                    #MMSB<?=$COD_NVL?> ul li:hover {border-right:none; color:#DD4B39;background-image:url(../images/BackMenu.png);background-repeat:no-repeat;background-position:left center;text-align:left;}
                                    </style>

                			<script>


										function ActivaMenu<?=$COD_NVL?>(){

												ActivaNv1 = document.getElementById("MMNV<?=$COD_NVL?>")
												if (ActivaNv1 != null) { ActivaNv1.className = "activo"; ActivaNv1.onclick=null;}
												MenuNv2 = document.getElementById("MMSB<?=$COD_NVL?>")
												if (MenuNv2 != null) { MenuNv2.style.display = "inline"}
												OcultaFrm = document.getElementById("FormaPers")
												if (OcultaFrm != null) { OcultaFrm.style.display = "none";}
												<?php

												//DESACTIVA MENU
												$SQL="SELECT COD_NVL1 FROM PA_OPCMENU WHERE PUBLICA=1 AND COD_NVL1<>".$COD_NVL." AND COD_NVL2=0 AND COD_NVL3=0 ";
												$RS1 = sqlsrv_query($conn, $SQL);
												//oci_execute($RS1);
												while ($row1 = sqlsrv_fetch_array($RS1)){
														$COD_NVL1 = $row1['COD_NVL1'];


												?>


														InactivaNv1 = document.getElementById("MMNV<?=$COD_NVL1?>")
														if (InactivaNv1 != null) { InactivaNv1.className = "inactivo"; InactivaNv1.onclick=ActivaMenu<?=$COD_NVL1?>;}
														OcultaNv2 = document.getElementById("MMSB<?=$COD_NVL1?>")
														if (OcultaNv2 != null) { OcultaNv2.style.display = "none"; }

												<?php
												}

												//OCULTA MENU 2

												$SQL="SELECT COD_NVL1 FROM PA_OPCMENU WHERE PUBLICA=1 AND COD_NVL2<>".$COD_NVL." AND COD_NVL2<>0 AND COD_NVL3=0 ORDER BY COD_NVL1 ASC";
												$RS1 = sqlsrv_query($conn, $SQL);
												//oci_execute($RS1);
												while ($row1 = sqlsrv_fetch_array($RS1)){

														$COD_NVL1 = $row1['COD_NVL1'];

												?>
														OcultaNv3 = document.getElementById("MMOP<?=$COD_NVL1?>")
														if (OcultaNv3 != null) { OcultaNv3.style.display = "none"; }
												<?php
												}
												?>
										}

										function CargaForma<?=$COD_NVL?>(){

											var FRMPACE = document.getElementById("FormaPers");
											FRMPACE.style.display = "inline-block";
											document.getElementById('FormaPers').innerHTML = "<object type='text/html' data='<?=$ARC_NVL?>?Titulo=<?=$DES_NVL?>' id='FormaPersInner' onload='setIframeAlto(this.id)'></object>";
											return true;
										}

									</script>
                <li id="MMNV<?=$COD_NVL?>" onClick="ActivaMenu<?=$COD_NVL?>(); <?php if($FRM_NVL==1){?>CargaForma<?=$COD_NVL?>();<?php } ?>" class="li_nvl1">
                  <?=utf8_decode($DES_NVL)?>
                </li>
                <?php

                            }
                            ?>

              </ul>
            </div>
            <!--Menu nivel 2-->       
            <?php
                                $SQL="SELECT COD_NVL2 FROM PA_OPCMENU WHERE PUBLICA=1 AND COD_NVL2<>0 AND COD_NVL3=0 GROUP BY COD_NVL2 ORDER BY  COD_NVL2 ASC";
                                $RS = sqlsrv_query($conn, $SQL);
                                //oci_execute($RS);
                                while ($row = sqlsrv_fetch_array($RS)){
									$COD_NVL2 = $row['COD_NVL2'];
                                ?>

            <div id="MMSB<?=$COD_NVL2?>" style="display:none">
              <ul>
                <?php
                                                $SQL="SELECT * FROM PA_OPCMENU WHERE PUBLICA=1 AND COD_NVL2=".$COD_NVL2." AND COD_NVL3=0 ORDER BY  POSICION ASC, COD_NVL1 ASC";
                                                $RS1 = sqlsrv_query($conn, $SQL);
                                                //oci_execute($RS1);
                                                while ($row1 = sqlsrv_fetch_array($RS1)){

				                                        if(strcmp($LAN,"DES_EN") !== 0){
				                                        	$DES_NVL =$row1['DES_ES'];
				                                        	
				                                    	}else{

				                                    		$DES_NVL =$row1['DES_EN'];

				                                    	}
														$COD_NVL = $row1['COD_NVL1'];
														$ARC_NVL = $row1['ARCHIVO'];

														if(empty($ARC_NVL) or is_null($ARC_NVL)){ $FRM_NVL=0; } else { $FRM_NVL=1; }

                                                ?>

                										<style>
	                                                        #MMOP<?=$COD_NVL?>{width:200px; float:left; text-align:left; position:inherit;}
	                                                        #MMOP<?=$COD_NVL?> ul {margin:0;padding:0;}
	                                                        #MMOP<?=$COD_NVL?> li {font-weight:600;list-style:none; width:180px;padding: 8px 10px 8px 30px;margin: 0;text-decoration: none;cursor:pointer}
	                                                        #MMOP<?=$COD_NVL?> ul li {border-bottom:1px solid #DFDFDF;background-color: #FBFBFB;}
	                                                        #MMOP<?=$COD_NVL?> ul li:hover {border-right:none; color:#DD4B39;background-image:url(../images/BackMenu.png);background-repeat:no-repeat;background-position:left center;text-align:left;}
                                                        </style>

             										   <script>

                                                            function ActivaSubMenu<?=$COD_NVL?>(){

																OcultaNv2 = document.getElementById("MMSB<?=$COD_NVL2?>")
																if (OcultaNv2 != null) { OcultaNv2.style.display = "none"; }
																MenuNv3 = document.getElementById("MMOP<?=$COD_NVL?>")
																if (MenuNv3 != null) { MenuNv3.style.display = "inline"; }
																<?php

																$SQL="SELECT * FROM PA_OPCMENU WHERE PUBLICA=1 AND COD_NVL3=".$COD_NVL." ORDER BY COD_NVL1 ASC";
																$RS11 = sqlsrv_query($conn, $SQL);
																//oci_execute($RS11);
																while ($row11 = sqlsrv_fetch_array($RS11)){

																	$COD_NVL1 =$row11['COD_NVL1'];
																?>

																	OpcionNv3 = document.getElementById("OpcNV3<?=$COD_NVL1?>")
																	if (OpcionNv3 != null) { OpcionNv3.className = "OpcInActivo"; }
																<?php
																}
																?>
                                                            }


															function CargaForma<?=$COD_NVL?>(){
																var FRMPACE = document.getElementById("FormaPers");
																FRMPACE.style.display = "inline-block";
																document.getElementById('FormaPers').innerHTML = "<object type='text/html' data='<?=$ARC_NVL?>?Titulo=<?=$DES_NVL?>' id='FormaPersInner' onload='setIframeAlto(this.id)'></object>";
																return true;
															}
                                                       </script>

               										<?php

													   if($row1["ARCHIVO"]=="si")
													   {
													   ?>
                                                    <li id="MMSBA<?=$COD_NVL?>" onClick="ActivaSubMenu<?=$COD_NVL?>(); <?php if($FRM_NVL==1){?>CargaForma<?=$COD_NVL?>();<?php } ?>">
                                                      <?php echo utf8_encode($DES_NVL);?>
                                                    </li>
                                                    <?php
												   }
													   else
													   {
													 ?>

                									<style>

                                                     .li2:hover {border-right:none; color:#999;background-image:url(../images/BackMenuDis.png) !important;background-repeat:no-repeat;background-position:left center;text-align:left; }
													 </style>

                <li id="MMSBA<?=$COD_NVL?>" class="li2" style="color:#999;cursor: not-allowed;">
                  <?=$DES_NVL?>
                </li>
                <?php
													   }
                                                }
                                                ?>
              </ul>
            </div>
            <?php
                                }
                               ?>          
            <!--Menu nivel 3-->          
            <?php
							//VER OPCIONES DE MENU DE NIVEL 3 AGRUPADAS POR NIVEL 2
                                $SQL="SELECT COD_NVL3 FROM PA_OPCMENU WHERE PUBLICA=1 AND COD_NVL3<>0 GROUP BY COD_NVL3 ORDER BY  COD_NVL3 ASC";
                                $RS = sqlsrv_query($conn, $SQL);
                                //oci_execute($RS);
                                while ($row = sqlsrv_fetch_array($RS)){
                                        $COD_NVL = $row['COD_NVL3'];
										$SQL="SELECT * FROM PA_OPCMENU WHERE COD_NVL1=".$COD_NVL;
										$RS1 = sqlsrv_query($conn, $SQL);
										//oci_execute($RS1);
										if ($row1 = sqlsrv_fetch_array($RS1)){
												if(strcmp($LAN,"DES_EN") !== 0){

		                                        	$DES_NVL =$row1['DES_ES'];
		                                        	
		                                    	}else{
		                                    		$DES_NVL =$row1['DES_EN'];
		                                    	}
												$ARC_NVL = $row1['ARCHIVO'];
												$COD_NVL2 = $row1['COD_NVL2'];
										}
                                ?>
           							<script>
									function RetiraOpcion<?=$COD_NVL?>(){
												MenuNv2 = document.getElementById("MMSB<?=$COD_NVL2?>")
												if (MenuNv2 != null) { MenuNv2.style.display = "inline"}
												OcultaNv3 = document.getElementById("MMOP<?=$COD_NVL?>")
												if (OcultaNv3 != null) { OcultaNv3.style.display = "none"}
												OcultaFrm = document.getElementById("FormaPers")
												if (OcultaFrm != null) { OcultaFrm.style.display = "none";}
											}
									</script>
            <div id="MMOP<?=$COD_NVL?>" style="display:none">
              <ul>
                <li onClick="RetiraOpcion<?=$COD_NVL?>();" style="background-color:#6A6B6A; color:#FFF; background-image:url(../images/BackMenu.png);background-repeat:no-repeat;background-position:left center;">
                  <?=$DES_NVL?>
                </li>
                <?php

												$SQL="SELECT * FROM PA_OPCMENU WHERE PUBLICA=1 AND COD_NVL3=".$COD_NVL." ORDER BY  POSICION ASC, COD_NVL1 ASC";
                                                $RS11 = sqlsrv_query($conn, $SQL);
                                                //oci_execute($RS11);
                                                while ($row11 = sqlsrv_fetch_array($RS11)){

                                                        $COD_NVL1 =$row11['COD_NVL1'];
                                                        if(strcmp($LAN,"DES_EN") !== 0){
			                                        	$DES_NVL =$row11['DES_ES'];
			                                        	
				                                    	}else{
				                                    		$DES_NVL =$row11['DES_EN'];
				                                    	}
                                                        $ARC_NVL = $row11['ARCHIVO'];
														if(empty($ARC_NVL) or is_null($ARC_NVL)){ $FRM_NVL=0; } else { $FRM_NVL=1; }
                                                ?>

                								<script>

														function CargaForma<?=$COD_NVL1?>(){

															document.getElementById("OpcNV3<?=$COD_NVL1?>").className = "OpcActivo";

															<?php

													$SQL="SELECT COD_NVL1 FROM PA_OPCMENU WHERE PUBLICA=1 AND COD_NVL3=".$COD_NVL." AND COD_NVL1<>".$COD_NVL1;

															$RS12 = sqlsrv_query($conn, $SQL);
															//oci_execute($RS12);
															while ($row12 = sqlsrv_fetch_array($RS12)){

																	$O_COD_NVL1 = $row12['COD_NVL1'];

															?>

																	OpcionNv3 = document.getElementById("OpcNV3<?=$O_COD_NVL1?>")
																	if (OpcionNv3 != null) { OpcionNv3.className = "OpcInActivo"; }
															<?php
															}
															?>
															var FRMPACE = document.getElementById("FormaPers");
															FRMPACE.style.display = "inline-block";
															document.getElementById('FormaPers').innerHTML = "<object type='text/html' data='load_form.php?Titulo=<?=$DES_NVL?>&TituloNv2=<?=$DES_NVL?>&COD_NIVEL=<?=$COD_NVL1?>&COD_TIENDA=<?=$TIENDA?>' id='FormaPersInner' onload='setIframeAlto(this.id)' width='100%'></object>";

															return true;

														}
												</script>
                <?php

													   if($row11["ARCHIVO"]=="si")
													   {
													   ?>

											                <li id="OpcNV3<?=$COD_NVL1?>" <?php if($FRM_NVL==1){?>onClick="CargaForma<?=$COD_NVL1?>();"<?php } ?>>
											                  <?=utf8_decode($DES_NVL)?>
											                </li>
											                <?php
												   		}
													   else
													   {
													 ?>
                									 <style>
                                                     	.li3:hover {border-right:none; color:#999;background-image:url(../images/BackMenuDis.png) !important;background-repeat:no-repeat;background-position:left center;text-align:left;}
													 </style>
                <li id="OpcNV3<?=$COD_NVL?>" class="li3" style="color:#999;cursor:not-allowed">

                  <?=$DES_NVL?>
                </li>
                <?php
													   }
												}
												?>

              </ul>
            </div>
            <?php

                               }
                                ?>          
            <!-- FORMULARIOS FORMULARIOS FORMULARIOS FORMULARIOS FORMULARIOS FORMULARIOS FORMULARIOS FORMULARIOS FORMULARIOS FORMULARIOS FORMULARIOS FORMULARIOS --> 
                        		<script>
                                    $(document).ready(function() {
                                            var posicion = $("#FormaPers").offset();
                                    });	
                                </script>
            <div id="FormaPers" style="width: 80%;    margin-left: 20px;"></div>            
            <!-- FORMULARIOS FORMULARIOS FORMULARIOS FORMULARIOS FORMULARIOS FORMULARIOS FORMULARIOS FORMULARIOS FORMULARIOS FORMULARIOS FORMULARIOS FORMULARIOS --></td>
        </tr>
      </table></td>
  </tr>
  <?php
// Fin Selección de tienda
	 } 
 ?>
</table>
</body>
</html>
<?php

//sqlsrv_close($conn);

?>



