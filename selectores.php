<?php include("hostsaadmin.php");?>
<?php 
$VALOR = @$_GET["valor"];
$SELECT= @$_GET["select"];
$NUMERO= @$_GET["numero"];
//AUXILIARES
$PAIS = @$_GET["pais"];
$IDUSU = @$_GET["idusu"];

//$db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521)))(CONNECT_DATA=(SID=xe)))" ;
//$conn = oci_connect('SAADMIN', 'SAADMIN', $db);
				$serverName = $HOSTSAADMIN; //serverName\instanceNam
				$connectionInfo = array( "Database"=>"SAADMIN", "UID"=>$INSTANCIA, "PWD"=>$PASSWORD);
				$conn = sqlsrv_connect( $serverName, $connectionInfo);

?>

<HTML>
<HEAD>
<script language="javascript">
		<?php 
			if ($NUMERO==1) {
						?>
						parent.<?=$SELECT ?>.length = 0;
						parent.<?=$SELECT ?>.options[parent.<?=$SELECT ?>.options.length++] = new Option('Ciudad');
						parent.<?=$SELECT ?>.options[parent.<?=$SELECT ?>.options.length - 1].value = "0";
						<?php
						$SQLSEL="SELECT COD_CIUDAD, DES_CIUDAD FROM PM_CIUDAD WHERE COD_REGION=".$VALOR." AND COD_PAIS=".$PAIS;

						//$RSSEL = sqlsrv_query($conn, $SQLSEL);
						////oci_execute($RSSEL);
						$RSSEL = sqlsrv_query($conn,$SQLSEL);


						while ($rowSel = sqlsrv_fetch_array($RSSEL)) {
							$DESCRIBE = $rowSel['DES_CIUDAD'];
							$CODIGO =$rowSel['COD_CIUDAD'];		
		 ?>
						parent.<?=$SELECT ?>.options[parent.<?=$SELECT ?>.options.length++] = new Option('<?=$DESCRIBE ?>');
						parent.<?=$SELECT ?>.options[parent.<?=$SELECT ?>.options.length - 1].value = '<?=$CODIGO ?>';
		<?php 
						}
			}//$NUMERO==1
			if ($NUMERO==2) {
						?>
						parent.<?=$SELECT ?>.length = 0;
						parent.<?=$SELECT ?>.options[parent.<?=$SELECT ?>.options.length++] = new Option('SELECCIONAR');
						parent.<?=$SELECT ?>.options[parent.<?=$SELECT ?>.options.length - 1].value = "0";
						<?php
						$SQLSEL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA IN(SELECT COD_TIENDA FROM MN_NEGTND WHERE COD_NEGOCIO=".$VALOR.")";

						//$RSSEL = sqlsrv_query($conn, $SQLSEL);
						////oci_execute($RSSEL);
						$RSSEL = sqlsrv_query($conn,$SQLSEL);

						while ($rowSel = sqlsrv_fetch_array($RSSEL)) {
							$DESCRIBE = $rowSel['DES_TIENDA'];
							$CODIGO =$rowSel['DES_CLAVE'];		
		 ?>
						parent.<?=$SELECT ?>.options[parent.<?=$SELECT ?>.options.length++] = new Option('<?=$DESCRIBE ?>');
						parent.<?=$SELECT ?>.options[parent.<?=$SELECT ?>.options.length - 1].value = '<?=$CODIGO ?>';
		<?php 
						}
			}//$NUMERO==2
			if ($NUMERO==3) {
						?>
						parent.<?=$SELECT ?>.length = 0;
						parent.<?=$SELECT ?>.options[parent.<?=$SELECT ?>.options.length++] = new Option('SELECCIONAR');
						parent.<?=$SELECT ?>.options[parent.<?=$SELECT ?>.options.length - 1].value = "0";
						<?php
						$SQLSEL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA IN(SELECT COD_TIENDA FROM MN_NEGTND WHERE COD_NEGOCIO=".$VALOR.")";

						//$RSSEL = sqlsrv_query($conn, $SQLSEL);
						////oci_execute($RSSEL);
						$RSSEL = sqlsrv_query($conn,$SQLSEL);

						while ($rowSel = sqlsrv_fetch_array($RSSEL)) {
							$DESCRIBE = $rowSel['DES_TIENDA'];
							$CODIGO =$rowSel['COD_TIENDA'];		
		 ?>
						parent.<?=$SELECT ?>.options[parent.<?=$SELECT ?>.options.length++] = new Option('<?=$DESCRIBE ?>');
						parent.<?=$SELECT ?>.options[parent.<?=$SELECT ?>.options.length - 1].value = '<?=$CODIGO ?>';
		<?php 
						}
			}//$NUMERO==3
			if ($NUMERO==4) {
						?>
						parent.<?=$SELECT ?>.length = 0;
						parent.<?=$SELECT ?>.options[parent.<?=$SELECT ?>.options.length++] = new Option('SELECCIONAR');
						parent.<?=$SELECT ?>.options[parent.<?=$SELECT ?>.options.length - 1].value = "0";
						<?php
						$SQLSEL="SELECT * FROM US_PERFIL WHERE IDSISTEMA=".$VALOR;
						
						//$RSSEL = sqlsrv_query($conn, $SQLSEL);
						////oci_execute($RSSEL);
						$RSSEL = sqlsrv_query($conn,$SQLSEL);

						while ($rowSel = sqlsrv_fetch_array($RSSEL)) {
							$DESCRIBE = $rowSel['NOMBRE'];
							$CODIGO =$rowSel['IDPERFIL'];		
		 ?>
						parent.<?=$SELECT ?>.options[parent.<?=$SELECT ?>.options.length++] = new Option('<?=$DESCRIBE ?>');
						parent.<?=$SELECT ?>.options[parent.<?=$SELECT ?>.options.length - 1].value = '<?=$CODIGO ?>';
		<?php 
						}
			}//$NUMERO==4
		?>
</script>
</HEAD>
<BODY style="background-color:#333; color:#3FF; padding:40px">
	<?=$SQLSEL?>
</BODY>
</HTML>
