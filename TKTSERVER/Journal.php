<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php include("funciones.php");?>
<?php
	$BUSCAR=@$_GET["buscar"];
	$LOCAL=@$_GET["local"];
	$ANIO=@$_GET["anio"];
	$MES=@$_GET["mes"];
	$CELDA=@$_GET["celda"];
	
	$DIA_SEL=@$_GET["diasel"];
?>

<script>
function getElements(){
	  var encontrados=document.getElementsByName("<?php echo $BUSCAR?>");
	  var GrupoDeElementos='';
	  for (x=0;x<encontrados.length;x++){
		  GrupoDeElementos=GrupoDeElementos+x+' ';
		  }
	alert(GrupoDeElementos);
  }
  
function setFocus(){
	document.getElementById('0').focus();
}
  
function Enfocar(val){
	document.getElementById(val).focus();
}
  
</script>
<style>
body {border:none;margin:0;padding:0;overflow:hidden;}
</style>
</head>
<body onLoad="setFocus();">
<table>
<tr>
<td style="padding:20px">
<?php
	$posP = stripos($CELDA, "P");
	//$ELDIA = substr($CELDA, 0, $posP);
	$ELDIA = $DIA_SEL;
	$LAFECHA= strtotime($MES."/".$ELDIA."/".$ANIO);
	setlocale(LC_ALL,"es_ES@euro","es_ES","esp"); 
	$NombreDia = strftime("%A", $LAFECHA);

	//REGISTRO DE VARIOS POS, ARMAR ARREGLO CON CADA POS IDENTIFICADO
	$REG_POS = substr($CELDA, $posP);
	$ARREGLO_POS = explode("P", $REG_POS);
	$i=0;
	$TICKET="";
	while ($i < count ($ARREGLO_POS) ) {
				if(!empty($ARREGLO_POS[$i])) {
					$POS=$ARREGLO_POS[$i];
					$JOURNAL = $DIR_TCK."/".$LOCAL."/".$POS."/".$ANIO."/".$MES."/".$ELDIA;
					$gestor = fopen($JOURNAL, "rb");
					$TICKET = $TICKET.fread($gestor, filesize($JOURNAL));
					fclose($gestor);
				}
				$i++;
	}
	$MARCA_BUSCAR="<input type='button' id='|' value='".$BUSCAR."' >";	
	$TICKET=str_ireplace ( $BUSCAR, $MARCA_BUSCAR,$TICKET, $REEMPLAZOS); 
	?>
            <style>
				.scrollArea {
						white-space:nowrap;
						width: 350px;
						height: 450px;
						padding:10px 0;
						padding-left:10px;
						border:none;
						float: left;
						overflow-y:scroll;
						background-color:#FFF;
						-khtml-border-radius: 6px;
						-moz-border-radius: 6px;
						-webkit-border-radius: 6px;
						border-radius: 6px;
						-webkit-box-shadow: inset 0px 4px 5px 0px rgba(50, 50, 50, 0.5);
						-moz-box-shadow:    inset 0px 4px 5px 0px rgba(50, 50, 50, 0.5);
						box-shadow:         inset 0px 4px 5px 0px rgba(50, 50, 50, 0.5);
				}
				.scrollArea input {
						width:auto;
						height: auto;
						padding:0;
						margin:0;
						border:none;
						background-color:#DD4B39;
						background-image:none;
						color:#FFF;
						text-shadow:none;
						font-weight:normal;
						font-size:10pt;
						text-transform:uppercase;
						-khtml-border-radius: 0;
						-moz-border-radius: 0;
						-webkit-border-radius: 0;
						border-radius: 0;
						-moz-box-shadow: inset 0 0 0 #F2F2F2;
						-webkit-box-shadow: inset 0 0 0 #F2F2F2;
						box-shadow: inset 0 0 0 #F2F2F2;
				}
				.scrollArea input:hover {
						color:#FFF;
				}
				#scrollArea input:focus {
						outline: none !important
				}
				.scrollArea::-webkit-scrollbar {
						width: 16px;
				} 
				.scrollArea::-webkit-scrollbar-track {
						background-color:#DD4B39;
						-webkit-box-shadow: inset 0px 4px 5px 0px rgba(50, 50, 50, 0.5);
						-moz-box-shadow:    inset 0px 4px 5px 0px rgba(50, 50, 50, 0.5);
						box-shadow:         inset 0px 4px 5px 0px rgba(50, 50, 50, 0.5);
				} 
				.scrollArea::-webkit-scrollbar-thumb {
						background: rgba(255,255,255,0.72);
				}
				.scrollArea::-webkit-scrollbar-thumb:window-inactive {
						background: rgba(255,255,255,0.4);
				}
			</style>
            <div id="Base" style="width:560px">
                    <div id="SubBase1" style="width:180px; float:left">
                    			 <style>
								 .info{
									 font-size:11pt;
									 font-weight:400;
									 border-top: 1px solid #CCC;
									 padding:6px;
								 }
								 </style>
                                 <p class="info">Local <?=substr("0000".$LOCAL,-4)?></p>
                                 <p class="info"><?php echo nombremes($MES)." ".$ANIO?></p>
                                 <p class="info"><?php echo $NombreDia." ".$ELDIA?></p>
                                 <p class="info" style="border-bottom: 1px solid #CCC; margin-bottom:10px">Resultados <?php echo $REEMPLAZOS?></p>
                                 <?php
                                   if($REEMPLAZOS>1) {
                                       $LIMITE=$REEMPLAZOS-1;
                                   ?>		
                                        <script>								
                                                function Anterior() {
                                                    var valor_ant=document.getElementById("ANTERIOR").value;
                                                    valor_ant=--valor_ant;
                                                    if(valor_ant<0) {valor_ant=<?php echo $LIMITE?>;}
                                                    document.getElementById("ANTERIOR").value=valor_ant;
                                                    document.getElementById(valor_ant).focus();
                                                    document.getElementById(valor_ant).style.color="#FFF";
                                                    document.getElementById(valor_ant).style.background="#7A2A9C";
                                                    document.getElementById(valor_ant+1).style.color="#FFF";
                                                    document.getElementById(valor_ant+1).style.background="#DD4B39";
                                                    var valor_sig=document.getElementById("SIGUIENTE").value;
                                                    valor_sig=--valor_sig;
                                                    if(valor_sig<0) {valor_sig=<?php echo $LIMITE?>;}
                                                    document.getElementById("SIGUIENTE").value=valor_sig;
                                                }
                                                function Siguiente() {
                                                    var valor_sig=document.getElementById("SIGUIENTE").value;
                                                    valor_sig=++valor_sig;
                                                    if(valor_sig><?php echo $LIMITE?>) {valor_sig=0;}
                                                    document.getElementById("SIGUIENTE").value=valor_sig;
													document.getElementById(valor_sig).focus();
                                                    document.getElementById(valor_sig).style.color="#FFF";
                                                    document.getElementById(valor_sig).style.background="#7A2A9C";
                                                    document.getElementById(valor_sig-1).style.color="#FFF";
                                                    document.getElementById(valor_sig-1).style.background="#DD4B39";
                                                    var valor_ant=document.getElementById("ANTERIOR").value;
                                                    valor_ant=++valor_ant;
                                                    if(valor_ant><?php echo $LIMITE?>) {valor_ant=0;}
                                                    document.getElementById("ANTERIOR").value=valor_ant;
                                                }
                                        </script>
                                        <input  id="ANTERIOR" name="ANTERIOR" type="hidden" value="0" style="clear:left" />
                                        <input id="BTANT" name="BTANT" type="button" value="Anterior" onClick="Anterior();" style="padding:6px; margin:0 2px 2px 0"/>
                                        <input id="BTSIG" name="BTSIG" type="button" value="Siguiente" onClick="Siguiente();" style="padding:6px; margin:0 2px 2px 0"/>
                                        <input id="SIGUIENTE" name="SIGUIENTE" type="hidden" value="0" />
                                   <?php
                                   }
                                   ?>		
                    </div>
                    <div class="scrollArea">
							<?php
									if($REEMPLAZOS>100) {set_time_limit(0);}
									$ElTicket="";
									$ARREGLO_TICKET = explode("|", $TICKET);
									$i=-1;
									foreach ($ARREGLO_TICKET as $key => $val) {


										$ElTicket=$ElTicket.$i++.$val;

									}
									$ElTicket = iconv("CP857", "ISO-8859-1", $ElTicket);
									echo nl2br("<pre>".$ElTicket);	
							?>
                    </div>
            </div>
            <?php
?>
</td>
</tr>
</table>
</body>
</html>