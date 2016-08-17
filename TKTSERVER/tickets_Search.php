<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php include("funciones.php");?>
</head>
<body>
<table>
<tr>
<td style="padding:20px">
<?php

	$ELARCHIVO=@$_GET["dir"];

	$B_MSJE=@$_POST["B_MSJE"];
	$BUSCAR=@$_POST["BUSCAR"];
	$LIMPIAR=@$_POST["LIMPIAR"];
	if(!empty($LIMPIAR)) {
		$B_MSJE="";
		}
	
	$BUSCARCADENA=$ELARCHIVO;
	$LADATA=explode("/", $BUSCARCADENA)
	
			?>
            <table width="400px">
            <tr>
            <td>
			<h3>Buscar en Ticket<br><?php echo $LADATA[4];?> de <?php echo nombremes($LADATA[3]);?> de <?php echo $LADATA[2];?> [POS: <?php echo $LADATA[1];?> - Local: <?php echo $LADATA[0];?>]</h3>
            </td>
            </tr>
            </table>
            <table width="100%" id="Filtro">
            <tr>
            <td style="border-right:thin; border-right-color:#E5E5E5;border-right-style:solid;border-top:thin; border-top-color:#E5E5E5;border-top-style:solid;">
            <form action="tickets_Search.php?dir=<?php echo $ELARCHIVO;?>" method="post" name="frmSearch">
                       <input name="B_MSJE" type="text" id="B_MSJE" value="<?php echo $B_MSJE;?>" size="20">
                       <input name="BUSCAR" type="submit" id="BUSCAR" value="Buscar">
                       <input name="LIMPIAR" type="submit" id="LIMPIAR" value="Limpiar">
            </form>
            </td>
            </tr>
            </table>
            <?php
	
//			echo $INICIO." ".$FIN." ".$TIPO;
			
	$líneas = file($DIR_TCK."/".$ELARCHIVO, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	
	echo "<table class='TablaMensajes'>";
	$CONT_LINEA=0;
	$CUENTATD=0;	
	foreach ($líneas as $NUM_LINEA => $línea)
	{
		$NUM_LINEA=$NUM_LINEA+1;
		
				$CADENA_MSJE=  $línea;

		$laLineaDeMensaje = $CADENA_MSJE;

		if(!empty($BUSCAR) and !empty($B_MSJE)) {
			//BUSCAR EN LA CADENA
			//ARMAR CADENA DE BUSQUEDA
			$B_CADENA=$laLineaDeMensaje;
			if (stristr($B_CADENA, $B_MSJE)) {
						$CONT_LINEA=$CONT_LINEA+1;
						echo "<tr>";
							if($CUENTATD % 2==0){
								$TDCOLOR="#F1F1F1";
							} else {
								$TDCOLOR="#FBFBFB";
							}
									echo "<td style='width:30px; color:#999;background-color:".$TDCOLOR."' >";
									echo $CONT_LINEA;
									echo "</td>";
									echo "<td nowrap style='background-color:".$TDCOLOR."; border-left-width:1px; border-left-color:#CCC; border-left-style:dotted;' >";
									$laLineaDeMensaje = iconv("CP857", "ISO-8859-1", $laLineaDeMensaje);
									echo "<pre>".$laLineaDeMensaje."</pre>";
									echo "</td>";
						echo "</tr>";

					
					   $CUENTATD=$CUENTATD+1;
			}
		}
		
	}
	echo "</table>";
	if($CONT_LINEA==0 and !empty($B_MSJE)) { echo "<h4>No se encontraron coincidencias, por favor, intente nuevamente</h4>";}

?>
</td>
</tr>
</table>
</body>
</html>