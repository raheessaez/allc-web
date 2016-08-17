<?php include("conecta.inc");?>

<?php 

$VALOR = @$_GET["valor"];

$SELECT= @$_GET["select"];

$NUMERO= @$_GET["numero"];

//AUXILIARES

$PAIS = @$_GET["pais"];

$IDUSU = @$_GET["idusu"];

 ?>



<HTML>

<HEAD>

<script language="javascript">



		<?php 

			if ($NUMERO==100) {

						?>

						parent.<?=$SELECT ?>.length = 0;

						parent.<?=$SELECT ?>.options[parent.<?=$SELECT ?>.options.length++] = new Option('SELECCIONAR');

						parent.<?=$SELECT ?>.options[parent.<?=$SELECT ?>.options.length - 1].value = "0";

						<?php

						$CONSQL="SELECT COD_TIENDA, DES_TIENDA, DES_CLAVE FROM MN_TIENDA WHERE COD_TIENDA IN(SELECT COD_TIENDA FROM MN_NEGTND WHERE COD_NEGOCIO=".$VALOR.") AND COD_TIENDA IN(SELECT COD_TIENDA FROM US_USUTND WHERE IDUSU=".$IDUSU.") ORDER BY DES_CLAVE ASC";

						$RSC = sqlsrv_query($maestra, $CONSQL);

						//oci_execute($RSC);

						while ($rowC = sqlsrv_fetch_array($RSC)) {

							$NUM_TIENDA = $rowC['DES_CLAVE'];

							$NUM_TIENDA_F="0000".$NUM_TIENDA;

							$NUM_TIENDA_F=substr($NUM_TIENDA_F, -4); 

							$DES_TIENDA = $rowC['DES_TIENDA'];

							$COD_TIENDA =$rowC['COD_TIENDA'];		

							//VERIFICAR QUE TIENDA SE ENCUENTRE REGISTRADA Y/O CON PRECIOS ARTS.AS_ITM_STR

							$SQL1="SELECT COUNT(ID_BSN_UN) AS VERTND FROM PA_STR_RTL WHERE CD_STR_RT=".$NUM_TIENDA;

							$RS1 = sqlsrv_query($conn, $SQL1);

							//oci_execute($RS1);

							if ($row1 = sqlsrv_fetch_array($RS1)) {

								$VERTND = $row1['VERTND'];

							}

						if($VERTND != 0){

		 ?>

						parent.<?=$SELECT ?>.options[parent.<?=$SELECT ?>.options.length++] = new Option('<?=$NUM_TIENDA_F." - ".$DES_TIENDA ?>');

						parent.<?=$SELECT ?>.options[parent.<?=$SELECT ?>.options.length - 1].value = '<?=$COD_TIENDA ?>';

		<?php 

						}

						}

			}//$NUMERO==100

			if ($NUMERO==200) {

						?>

						parent.<?=$SELECT ?>.length = 0;

						parent.<?=$SELECT ?>.options[parent.<?=$SELECT ?>.options.length++] = new Option('SELECCIONAR');

						parent.<?=$SELECT ?>.options[parent.<?=$SELECT ?>.options.length - 1].value = "0";

						<?php

						$CONSQL="SELECT COD_TIENDA, DES_TIENDA, DES_CLAVE FROM MN_TIENDA WHERE COD_TIENDA IN(SELECT COD_TIENDA FROM MN_NEGTND WHERE COD_NEGOCIO=".$VALOR.")  ORDER BY DES_CLAVE ASC";

						$RSC = sqlsrv_query($maestra, $CONSQL);

						//oci_execute($RSC);

						while ($rowC = sqlsrv_fetch_array($RSC)) {

							$NUM_TIENDA = $rowC['DES_CLAVE'];

							$NUM_TIENDA_F="0000".$NUM_TIENDA;

							$NUM_TIENDA_F=substr($NUM_TIENDA_F, -4); 

							$DES_TIENDA = $rowC['DES_TIENDA'];

							$COD_TIENDA =$rowC['COD_TIENDA'];		

							//VERIFICAR QUE TIENDA SE ENCUENTRE REGISTRADA Y/O CON PRECIOS ARTS.AS_ITM_STR

							$SQL1="SELECT COUNT(ID_BSN_UN) AS VERTND FROM PA_STR_RTL WHERE CD_STR_RT=".$NUM_TIENDA;

							$RS1 = sqlsrv_query($conn, $SQL1);

							//oci_execute($RS1);

							if ($row1 = sqlsrv_fetch_array($RS1)) {

								$VERTND = $row1['VERTND'];

							}

						if($VERTND != 0){

		 ?>

						parent.<?=$SELECT ?>.options[parent.<?=$SELECT ?>.options.length++] = new Option('<?=$NUM_TIENDA_F." - ".$DES_TIENDA ?>');

						parent.<?=$SELECT ?>.options[parent.<?=$SELECT ?>.options.length - 1].value = '<?=$COD_TIENDA ?>';

		<?php 

						}

						}

			}//$NUMERO==200

			

			if ($NUMERO==300) {

						?>

						parent.<?=$SELECT ?>.length = 0;

						parent.<?=$SELECT ?>.options[parent.<?=$SELECT ?>.options.length++] = new Option('SELECCIONAR');

						parent.<?=$SELECT ?>.options[parent.<?=$SELECT ?>.options.length - 1].value = "0";

						<?php

						$CONSQL="SELECT COD_TIENDA, DES_TIENDA, DES_CLAVE FROM MN_TIENDA WHERE COD_TIENDA IN(SELECT COD_TIENDA FROM MN_NEGTND WHERE COD_NEGOCIO=".$VALOR.")  ORDER BY DES_CLAVE ASC";

						$RSC = sqlsrv_query($maestra, $CONSQL);

						//oci_execute($RSC);

						while ($rowC = sqlsrv_fetch_array($RSC)) {

							$NUM_TIENDA = $rowC['DES_CLAVE'];

							$DES_CLAVE = $rowC['DES_CLAVE'];

							$NUM_TIENDA_F="0000".$NUM_TIENDA;

							$NUM_TIENDA_F=substr($NUM_TIENDA_F, -4); 

							$DES_TIENDA = $rowC['DES_TIENDA'];

							$COD_TIENDA =$rowC['COD_TIENDA'];		

							//VERIFICAR QUE TIENDA SE ENCUENTRE REGISTRADA Y/O CON PRECIOS ARTS.AS_ITM_STR

							$SQL1="SELECT COUNT(ID_BSN_UN) AS VERTND FROM PA_STR_RTL WHERE CD_STR_RT=".$NUM_TIENDA;

							$RS1 = sqlsrv_query($conn, $SQL1);

							//oci_execute($RS1);

							if ($row1 = sqlsrv_fetch_array($RS1)) {

								$VERTND = $row1['VERTND'];

							}

						if($VERTND != 0){

		 ?>

						parent.<?=$SELECT ?>.options[parent.<?=$SELECT ?>.options.length++] = new Option('<?=$DES_CLAVE." - ".$DES_TIENDA ?>');

						parent.<?=$SELECT ?>.options[parent.<?=$SELECT ?>.options.length - 1].value = '<?=$DES_CLAVE ?>';

		<?php 

						}

						}

			}//$NUMERO==200

		 ?>

</script>

<TITLE></TITLE>

</HEAD>

<BODY>

</BODY>

</HTML>

