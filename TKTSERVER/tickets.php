<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php include("funciones.php");?>
</head>
<body>
<?php

	$ELARCHIVO=@$_GET["dir"];
	$PAGINA=@$_GET["paginar"];
	$TIPO=@$_GET["tipo"];
	
		$INICIO=1;
		$FIN=$CTP;
		$FACTORPAG=$CTP*$PAGINA;
		
		if (!empty($PAGINA)) { 
			$INICIO=($INICIO+$FACTORPAG);
			$FIN=($FIN+$FACTORPAG);
		}
		
	$BUSCARCADENA=$ELARCHIVO;

	$líneas = file($DIR_TCK."/".$ELARCHIVO, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	$max_lineas = count($líneas);
	
	echo "<table class='TablaMensajes' stye='width:380px; max-width:380px'>";
	$CUENTATD=1;
	$CONT_LINEA=0;
	foreach ($líneas as $NUM_LINEA => $línea)
	{
		$NUM_LINEA=$NUM_LINEA+1;
		
		if ($NUM_LINEA>=$INICIO and $NUM_LINEA<=$FIN) {
			if($CUENTATD % 2==0){
				$TDCOLOR="#F1F1F1";
			} else {
				$TDCOLOR="#FBFBFB";
			}
				$CADENA_MSJE=  $línea;
				
							$laLineaDeMensaje = $CADENA_MSJE;
							$laLineaDeMensaje = iconv("CP857", "ISO-8859-1", $laLineaDeMensaje);
							$CONT_LINEA=$CONT_LINEA+1;

					?>
				<tr>			
						<td style="color:#999; background-color:<?php echo $TDCOLOR?>"><?php echo $NUM_LINEA; ?></td>
                                <td nowrap="nowrap" style="background-color:<?php echo $TDCOLOR; ?>; border-left-width:1px; border-left-color:#CCC; border-left-style:dotted">
                                        <?php echo "<pre>".$laLineaDeMensaje."</pre>"?>
                                </td>
                </tr>
                
		<?php
		} //FIN PAGINADO CON $NUM_LINEA
		
		$CUENTATD=$CUENTATD+1;
	}
	echo "</table>";
?>



</body>
</html>