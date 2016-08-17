
<?php include("session.inc");?>
<?php
	$ID_DEVS=@$_GET["IDD"];
	$CTA=@$_GET["CTA"];
	$CTA=$CTA+1;

	$SQL1="SELECT ESTADO FROM DV_GFCD WHERE ID_DEVS=".$ID_DEVS;
	$RS1= sqlsrv_query($conn, $SQL1);
	////oci_execute($RS1);
	if ($row1 = sqlsrv_fetch_array($RS1)) {
		$ESTADO =  $row1['ESTADO'];
		//0= EN CONSULTA
		//1= AUTORIZADA
		//2= RECHAZADA
		//3= VUELVA A INTENTAR
		
		//SI ES 1, ENTONCES REGISTRAR NOTA DE CRÉDITO Y ENVIAR A VENTANA DE IMPRESIÓN
	}
	if($ESTADO==1){
		//ACTUALIZAR DV_TICKET A 2= REGISTRADA
		$SQL="UPDATE DV_TICKET SET ID_ESTADO=2 WHERE ID_DEVS=".$ID_DEVS;
		$RS = sqlsrv_query($conn, $SQL);
		////oci_execute($RS);
		//ACTUALIZAR ESTADO TARJETA
		$SQL="UPDATE DV_GFCD SET ESTADO=".$ESTADO." WHERE ID_DEVS=".$ID_DEVS;
		$RS = sqlsrv_query($conn, $SQL);
		////oci_execute($RS);
		//ELIMINAR ARCHIVO GENERADO EN SITE
		$SQL="SELECT ARCHIVO FROM DV_GFCD WHERE ID_DEVS=".$ID_DEVS;
		$RS = sqlsrv_query($conn, $SQL);
		////oci_execute($RS);
		if ($row = sqlsrv_fetch_array($RS)) {
			$ARCHIVO = $row['ARCHIVO']; //NOMBRE DE ARCHIVO
			$DIRLOCAL = "_arc_tmp/";
					unlink($DIRLOCAL.$ARCHIVO);
		}
		//SERVICIO TRASLADA ARCHIVO DE IN A BKP
	}
	if($ESTADO==3 || $ESTADO==2){
		//2= RECHAZADA
		//3= VUELVA A INTENTAR
		//ELIMINAR ARCHIVOS GENERADOS
		$SQL="SELECT ARCHIVO FROM DV_GFCD WHERE ID_DEVS=".$ID_DEVS;
		$RS = sqlsrv_query($conn, $SQL);
		////oci_execute($RS);
		if ($row = sqlsrv_fetch_array($RS)) {
			$ARCHIVO = $row['ARCHIVO']; //NOMBRE DE ARCHIVO
			$DIRLOCAL = "_arc_tmp/";
					unlink($DIRLOCAL.$ARCHIVO);
			$DIREYES = $DIR_EX_GFC_IN;
					$conn_id = ftp_connect($FTP_SERVER); 
					$login_result = ftp_login($conn_id, $FTP_UNM, $FTP_UPW);
						ftp_delete($conn_id, $DIREYES.$ARCHIVO);
					ftp_close($conn_id);
		}
		$SQL="UPDATE DV_GFCD SET ARCHIVO='', ESTADO=".$ESTADO." WHERE ID_DEVS=".$ID_DEVS;
		$RS = sqlsrv_query($conn, $SQL);
		////oci_execute($RS);
	}
	
	
	
?>

<SCRIPT LANGUAGE="JavaScript">
function autoRefresh() {
	<?php if($CTA<=$TESY){?>
			<?php if($ESTADO==0){?> self.location.href="VerifSyscard.php?CTA=<?php echo $CTA;?>&IDD=<?php echo $ID_DEVS;?>"; <?php }?>
			<?php if($ESTADO==1){?> parent.location.href="reg_devols.php?VDNC=<?php echo $ID_DEVS?>&MSJE=7"; <?php }?>
			<?php if($ESTADO==2){?> parent.location.href="reg_devols.php?D_GFC=1&C_DEV=1&IDD=<?php echo $ID_DEVS?>&VRF=1&MSJE=5"; <?php }?>
			<?php if($ESTADO==3){?> parent.location.href="reg_devols.php?D_GFC=1&C_DEV=1&IDD=<?php echo $ID_DEVS?>&VRF=1&MSJE=6"; <?php }?>
	<?php } else {
		//ELIMINAR ARCHIVOS GENERADOS
		//VERIFICAR REGISTRO DE ARCHIVO
		$SQL="SELECT ARCHIVO FROM DV_GFCD WHERE ID_DEVS=".$ID_DEVS;
		$RS = sqlsrv_query($conn, $SQL);
		////oci_execute($RS);
		if ($row = sqlsrv_fetch_array($RS)) {
			$ARCHIVO = $row['ARCHIVO']; //NOMBRE DE ARCHIVO
			$DIRLOCAL = "_arc_tmp/";
					unlink($DIRLOCAL.$ARCHIVO);
			$DIREYES = $DIR_EX_GFC_IN;
					$conn_id = ftp_connect($FTP_SERVER); 
					$login_result = ftp_login($conn_id, $FTP_UNM, $FTP_UPW);
						ftp_delete($conn_id, $DIREYES.$ARCHIVO);
					ftp_close($conn_id);
		}
		$SQL="UPDATE DV_GFCD SET ARCHIVO='' WHERE ID_DEVS=".$ID_DEVS;
		$RS = sqlsrv_query($conn, $SQL);
		////oci_execute($RS);
	?>
			   parent.location.href="reg_devols.php?D_GFC=1&C_DEV=1&IDD=<?php echo $ID_DEVS?>&VRF=1&MSJE=4";
	<?php } ?>

}
function refreshAdv(refreshTime,refreshColor) {
   setTimeout('autoRefresh()',refreshTime)
}
</SCRIPT>
</head>
<body onLoad="refreshAdv(1000,'#FFFFFF');">

</body>
</html>
