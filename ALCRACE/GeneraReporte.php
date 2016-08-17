
<?php include("session.inc");?>
<?php
	$LOCAL=$_SESSION['TIENDA_SEL'];
	
	$RPTN1=@$_GET["r1"];
	$RPTN2=@$_GET["r2"];
	$StringForm = "r1=".$RPTN1."&r2=".$RPTN2."&tnd=".$_SESSION['TIENDA_SEL'];

	$CTA=@$_GET["CTA"];
	$CTA=$CTA+1;
	$Orden=@$_GET["Orden"];
	if(empty($Orden)){$Orden=0;}
	$GenReport=@$_GET["GenReport"];
	if(empty($GenReport)){$GenReport=0;}
	
		function recurse_copy($src,$dst) { 
			$dir = opendir($src); 
			@mkdir($dst); 
			while(false !== ( $file = readdir($dir)) ) { 
				if (( $file != '.' ) && ( $file != '..' )) { 
					if ( is_dir($src . '/' . $file) ) { 
						recurse_copy($src . '/' . $file,$dst . '/' . $file); 
					} 
					else { 
						copy($src . '/' . $file,$dst . '/' . $file); 
					} 
				} 
			} 
			closedir($dir); 
		} 				

	function Quitar_Archivos($str){
		if(is_file($str)){
			return @unlink($str);
		}
		elseif(is_dir($str)){
			$scan = glob(rtrim($str,'/').'/*');
			foreach($scan as $index=>$path){
				Quitar_Archivos($path);
			}
			return @rmdir($str);
		}
	}

	//GENERAR ARCHIVO .AR POR REPORTE
	
	if($RPTN2 == 1){ //REPORTE 1 CAJA OPERADOR/TERMINAL
			$OperTermId=@$_GET["OperTermId"];
			$ExtendedPeriod=@$_GET["ExtendedPeriod"];
			$Scope=@$_GET["Scope"];
			if($Orden==0){
								//CONSTRUIR ARCHIVO .AR
								$SQL="SELECT * FROM RA_NVL2 WHERE COD_NVL2=".$RPTN2;
								$RS = sqlsrv_query($conn, $SQL);
								//oci_execute($RS);
								if ($row = sqlsrv_fetch_array($RS)){
										$DES_ES_NVL2 =$row['DES_ES'];
								}
								$L1="[RACE ".$DES_ES_NVL2."]"."\r\n"; 
								$L2="ReportName = Operator/Terminal Cash"."\r\n"; 
								if(!empty($OperTermId)){
									$L3="OperTermId = ".$OperTermId."\r\n"; 
								} else {
									$L3="";
								}
								//$L4="FileName = ArmsRaceRpt".$RPTN2." \r\n"; 
								$L4="FileName = ArmsRaceRpt".$RPTN2." \r\n"; 
								$L5="OverwriteFile = 1"." \r\n"; 
								$L6="ExtendedPeriod = ".$ExtendedPeriod." \r\n"; 
								$L7="Scope = ".$Scope."\r\n"; 
								$LN_PRINT=$L1.$L2.$L3.$L4.$L5.$L6.$L7." \r\n";
							
								//ELIMINAR ARCHIVOS EN HASTA
								Quitar_Archivos($SYNC_OUT."adx_idt4");
								Quitar_Archivos($SYNC_OUT."adx_idt1");
								Quitar_Archivos($SYNC_OUT."adx_ipgm");
								
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt4";
								$HASTA = $SYNC_OUT."adx_idt4";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt1";
								$HASTA = $SYNC_OUT."adx_idt1";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_ipgm";
								$HASTA = $SYNC_OUT."adx_ipgm";
								recurse_copy($DESDE,$HASTA);
							
								 //CREA ARCHIVO
								$DelFile = "ArmsRaceRpt".$RPTN2.".rpt";				
								 unlink($SYNC_OUT.$LOCAL.'/adx_idt4/'.$DelFile);
								 unlink($SYNC_OUT.'adx_idt4/'.$DelFile);
								 $open = fopen($SYNC_OUT."ADX_IDT1/"."ARMS.AR", "w+");
									 fwrite($open, $LN_PRINT);
								 fclose($open);
				 
			}	
	}
	
	if($RPTN2 == 2){ //REPORTE 2 CAJA OFICINA
			$ExtendedPeriod=@$_GET["ExtendedPeriod"];
			if($Orden==0){
								//CONSTRUIR ARCHIVO .AR
								$SQL="SELECT * FROM RA_NVL2 WHERE COD_NVL2=".$RPTN2;
								$RS = sqlsrv_query($conn, $SQL);
								//oci_execute($RS);
								if ($row = sqlsrv_fetch_array($RS)){
										$DES_ES_NVL2 =$row['DES_ES'];
								}
								$L1="[RACE ".$DES_ES_NVL2."]"."\r\n"; 
								$L2="ReportName = Office Cash"."\r\n"; 
								$L3="FileName = ArmsRaceRpt".$RPTN2." \r\n"; 
								$L4="OverwriteFile = 1"." \r\n"; 
								$L5="ExtendedPeriod = ".$ExtendedPeriod." \r\n"; 
								$LN_PRINT=$L1.$L2.$L3.$L4.$L5." \r\n";

								//ELIMINAR ARCHIVOS EN HASTA
								Quitar_Archivos($SYNC_OUT."adx_idt4");
								Quitar_Archivos($SYNC_OUT."adx_idt1");
								Quitar_Archivos($SYNC_OUT."adx_ipgm");
								
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt4";
								$HASTA = $SYNC_OUT."adx_idt4";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt1";
								$HASTA = $SYNC_OUT."adx_idt1";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_ipgm";
								$HASTA = $SYNC_OUT."adx_ipgm";
								recurse_copy($DESDE,$HASTA);
							
								 //CREA ARCHIVO
								$DelFile = "ArmsRaceRpt".$RPTN2.".rpt";				
								 unlink($SYNC_OUT.$LOCAL.'/adx_idt4/'.$DelFile);
								 unlink($SYNC_OUT.'adx_idt4/'.$DelFile);
								 $open = fopen($SYNC_OUT."ADX_IDT1/"."ARMS.AR", "w+");
									 fwrite($open, $LN_PRINT);
								 fclose($open);
				 
			}
	}
	
	if($RPTN2 == 3){ //REPORTE 3 ARQUEO DEL CAJON
			$OperTermId=@$_GET["OperTermId"];
			$Scope=@$_GET["Scope"];
			$Detail=@$_GET["Detail"];
			$Period=@$_GET["Period"];
			if($Orden==0){
								//CONSTRUIR ARCHIVO .AR
								$SQL="SELECT * FROM RA_NVL2 WHERE COD_NVL2=".$RPTN2;
								$RS = sqlsrv_query($conn, $SQL);
								//oci_execute($RS);
								if ($row = sqlsrv_fetch_array($RS)){
										$DES_ES_NVL2 =$row['DES_ES'];
								}
								$L1="[RACE ".$DES_ES_NVL2."]"."\r\n"; 
								$L2="ReportName = Cash Drawer Position"."\r\n"; 
								if(!empty($OperTermId)){
									$L3="OperTermId = ".$OperTermId."\r\n"; 
								} else {
									$L3="";
								}
								$L4="FileName = ArmsRaceRpt".$RPTN2." \r\n"; 
								$L5="OverwriteFile = 1"." \r\n"; 
								$L6="Scope = ".$Scope."\r\n"; 
								$L7="Detail = ".$Detail."\r\n"; 
								$L8="Period = ".$Period."\r\n"; 
								$LN_PRINT=$L1.$L2.$L3.$L4.$L5.$L6.$L7.$L8." \r\n";

								//ELIMINAR ARCHIVOS EN HASTA
								Quitar_Archivos($SYNC_OUT."adx_idt4");
								Quitar_Archivos($SYNC_OUT."adx_idt1");
								Quitar_Archivos($SYNC_OUT."adx_ipgm");
								
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt4";
								$HASTA = $SYNC_OUT."adx_idt4";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt1";
								$HASTA = $SYNC_OUT."adx_idt1";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_ipgm";
								$HASTA = $SYNC_OUT."adx_ipgm";
								recurse_copy($DESDE,$HASTA);
							
								 //CREA ARCHIVO
								$DelFile = "ArmsRaceRpt".$RPTN2.".rpt";				
								 unlink($SYNC_OUT.$LOCAL.'/adx_idt4/'.$DelFile);
								 unlink($SYNC_OUT.'adx_idt4/'.$DelFile);
								 $open = fopen($SYNC_OUT."ADX_IDT1/"."ARMS.AR", "w+");
									 fwrite($open, $LN_PRINT);
								 fclose($open);
				 
			}
	}

	if($RPTN2 == 4){ //REPORTE 4 DIFERENCIAS DE ARQUEO
			$OperTermId=@$_GET["OperTermId"];
			$Scope=@$_GET["Scope"];
			$ExtendedPeriod=@$_GET["ExtendedPeriod"];
			$Detail=@$_GET["Detail"];
			if($Orden==0){
								//CONSTRUIR ARCHIVO .AR
								$SQL="SELECT * FROM RA_NVL2 WHERE COD_NVL2=".$RPTN2;
								$RS = sqlsrv_query($conn, $SQL);
								//oci_execute($RS);
								if ($row = sqlsrv_fetch_array($RS)){
										$DES_ES_NVL2 =$row['DES_ES'];
								}
								$L1="[RACE ".$DES_ES_NVL2."]"."\r\n"; 
								$L2="ReportName = Over/Short"."\r\n"; 
								if(!empty($OperTermId)){
									$L3="OperTermId = ".$OperTermId."\r\n"; 
								} else {
									$L3="";
								}
								$L4="FileName = ArmsRaceRpt".$RPTN2." \r\n"; 
								$L5="OverwriteFile = 1"." \r\n"; 
								$L6="Scope = ".$Scope."\r\n"; 
								$L7="Detail = ".$Detail."\r\n"; 
								$L8="ExtendedPeriod = ".$ExtendedPeriod." \r\n"; 
								$LN_PRINT=$L1.$L2.$L3.$L4.$L5.$L6.$L7.$L8." \r\n";

								//ELIMINAR ARCHIVOS EN HASTA
								Quitar_Archivos($SYNC_OUT."adx_idt4");
								Quitar_Archivos($SYNC_OUT."adx_idt1");
								Quitar_Archivos($SYNC_OUT."adx_ipgm");
								
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt4";
								$HASTA = $SYNC_OUT."adx_idt4";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt1";
								$HASTA = $SYNC_OUT."adx_idt1";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_ipgm";
								$HASTA = $SYNC_OUT."adx_ipgm";
								recurse_copy($DESDE,$HASTA);
							
								 //CREA ARCHIVO
								$DelFile = "ArmsRaceRpt".$RPTN2.".rpt";				
								 unlink($SYNC_OUT.$LOCAL.'/adx_idt4/'.$DelFile);
								 unlink($SYNC_OUT.'adx_idt4/'.$DelFile);
								 $open = fopen($SYNC_OUT."ADX_IDT1/"."ARMS.AR", "w+");
									 fwrite($open, $LN_PRINT);
								 fclose($open);
				 
			}
	}
	
	if($RPTN2 == 5){ //REPORTE 2 RESUMENES  TOTALES DE TIENDA
			$ExtendedPeriod=@$_GET["ExtendedPeriod"];
			if($Orden==0){
								//CONSTRUIR ARCHIVO .AR
								$SQL="SELECT * FROM RA_NVL2 WHERE COD_NVL2=".$RPTN2;
								$RS = sqlsrv_query($conn, $SQL);
								//oci_execute($RS);
								if ($row = sqlsrv_fetch_array($RS)){
										$DES_ES_NVL2 =$row['DES_ES'];
								}
								$L1="[RACE ".$DES_ES_NVL2."]"."\r\n"; 
								$L2="ReportName = Store Totals Recap"."\r\n"; 
								$L3="FileName = ArmsRaceRpt".$RPTN2." \r\n"; 
								$L4="OverwriteFile = 1"." \r\n"; 
								$L5="ExtendedPeriod = ".$ExtendedPeriod." \r\n"; 
								$LN_PRINT=$L1.$L2.$L3.$L4.$L5." \r\n";

								//ELIMINAR ARCHIVOS EN HASTA
								Quitar_Archivos($SYNC_OUT."adx_idt4");
								Quitar_Archivos($SYNC_OUT."adx_idt1");
								Quitar_Archivos($SYNC_OUT."adx_ipgm");
								
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt4";
								$HASTA = $SYNC_OUT."adx_idt4";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt1";
								$HASTA = $SYNC_OUT."adx_idt1";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_ipgm";
								$HASTA = $SYNC_OUT."adx_ipgm";
								recurse_copy($DESDE,$HASTA);
							
								 //CREA ARCHIVO
								$DelFile = "ArmsRaceRpt".$RPTN2.".rpt";				
								 unlink($SYNC_OUT.$LOCAL.'/adx_idt4/'.$DelFile);
								 unlink($SYNC_OUT.'adx_idt4/'.$DelFile);
								 $open = fopen($SYNC_OUT."ADX_IDT1/"."ARMS.AR", "w+");
									 fwrite($open, $LN_PRINT);
								 fclose($open);
				 
			}
	}
	
	if($RPTN2 == 6){ //REPORTE 6 ESTADO F LIN TERMINAL
			$Scope=@$_GET["Scope"];
			$SortBy=@$_GET["SortBy"];
			$SingleTerminal=@$_GET["SingleTerminal"];
			if($Orden==0){
								//CONSTRUIR ARCHIVO .AR
								$SQL="SELECT * FROM RA_NVL2 WHERE COD_NVL2=".$RPTN2;
								$RS = sqlsrv_query($conn, $SQL);
								//oci_execute($RS);
								if ($row = sqlsrv_fetch_array($RS)){
										$DES_ES_NVL2 =$row['DES_ES'];
								}
								$L1="[RACE ".$DES_ES_NVL2."]"."\r\n"; 
								$L2="ReportName = TOF Status"."\r\n"; 
								$L4="FileName = ArmsRaceRpt".$RPTN2." \r\n"; 
								$L5="OverwriteFile = 1"." \r\n"; 
								$L6="Scope = ".$Scope."\r\n"; 
								if(!empty($SingleTerminal)){
									$L3="Single Terminal = ".$SingleTerminal."\r\n"; 
								} else {
									$L3="";
								}
								$L7="SortBy = ".$SortBy."\r\n"; 
								$LN_PRINT=$L1.$L2.$L4.$L5.$L6.$L3.$L7." \r\n";

								//ELIMINAR ARCHIVOS EN HASTA
								Quitar_Archivos($SYNC_OUT."adx_idt4");
								Quitar_Archivos($SYNC_OUT."adx_idt1");
								Quitar_Archivos($SYNC_OUT."adx_ipgm");
								
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt4";
								$HASTA = $SYNC_OUT."adx_idt4";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt1";
								$HASTA = $SYNC_OUT."adx_idt1";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_ipgm";
								$HASTA = $SYNC_OUT."adx_ipgm";
								recurse_copy($DESDE,$HASTA);
							
								 //CREA ARCHIVO
								$DelFile = "ArmsRaceRpt".$RPTN2.".rpt";				
								 unlink($SYNC_OUT.$LOCAL.'/adx_idt4/'.$DelFile);
								 unlink($SYNC_OUT.'adx_idt4/'.$DelFile);
								 $open = fopen($SYNC_OUT."ADX_IDT1/"."ARMS.AR", "w+");
									 fwrite($open, $LN_PRINT);
								 fclose($open);
				 
			}
	}

	if($RPTN2 == 7){ //REPORTE 7 LIMITE MULTIPLICACION VALE
			$ExtendedPeriod=@$_GET["ExtendedPeriod"];
			if($Orden==0){
								//CONSTRUIR ARCHIVO .AR
								$SQL="SELECT * FROM RA_NVL2 WHERE COD_NVL2=".$RPTN2;
								$RS = sqlsrv_query($conn, $SQL);
								//oci_execute($RS);
								if ($row = sqlsrv_fetch_array($RS)){
										$DES_ES_NVL2 =$row['DES_ES'];
								}
								$L1="[RACE ".$DES_ES_NVL2."]"."\r\n"; 
								$L2="ReportName = Coupon Multiplication Limit"."\r\n"; 
								$L3="FileName = ArmsRaceRpt".$RPTN2." \r\n"; 
								$L4="OverwriteFile = 1"." \r\n"; 
								$L5="ExtendedPeriod = ".$ExtendedPeriod." \r\n"; 
								$LN_PRINT=$L1.$L2.$L3.$L4.$L5." \r\n";

								//ELIMINAR ARCHIVOS EN HASTA
								Quitar_Archivos($SYNC_OUT."adx_idt4");
								Quitar_Archivos($SYNC_OUT."adx_idt1");
								Quitar_Archivos($SYNC_OUT."adx_ipgm");
								
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt4";
								$HASTA = $SYNC_OUT."adx_idt4";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt1";
								$HASTA = $SYNC_OUT."adx_idt1";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_ipgm";
								$HASTA = $SYNC_OUT."adx_ipgm";
								recurse_copy($DESDE,$HASTA);
							
								 //CREA ARCHIVO
								$DelFile = "ArmsRaceRpt".$RPTN2.".rpt";				
								 unlink($SYNC_OUT.$LOCAL.'/adx_idt4/'.$DelFile);
								 unlink($SYNC_OUT.'adx_idt4/'.$DelFile);
								 $open = fopen($SYNC_OUT."ADX_IDT1/"."ARMS.AR", "w+");
									 fwrite($open, $LN_PRINT);
								 fclose($open);
				 
			}
	}
	
	if($RPTN2 == 8){ //REPORTE 8 RESUMEN TRANSACCIONES VARIAS
			$ExtendedPeriod=@$_GET["ExtendedPeriod"];
			if($Orden==0){
								//CONSTRUIR ARCHIVO .AR
								$SQL="SELECT * FROM RA_NVL2 WHERE COD_NVL2=".$RPTN2;
								$RS = sqlsrv_query($conn, $SQL);
								//oci_execute($RS);
								if ($row = sqlsrv_fetch_array($RS)){
										$DES_ES_NVL2 =$row['DES_ES'];
								}
								$L1="[RACE ".$DES_ES_NVL2."]"."\r\n"; 
								$L2="ReportName = Miscellaneous Transaction Recap"."\r\n"; 
								$L3="FileName = ArmsRaceRpt".$RPTN2." \r\n"; 
								$L4="OverwriteFile = 1"." \r\n"; 
								$L5="ExtendedPeriod = ".$ExtendedPeriod." \r\n"; 
								$LN_PRINT=$L1.$L2.$L3.$L4.$L5." \r\n";

								//ELIMINAR ARCHIVOS EN HASTA
								Quitar_Archivos($SYNC_OUT."adx_idt4");
								Quitar_Archivos($SYNC_OUT."adx_idt1");
								Quitar_Archivos($SYNC_OUT."adx_ipgm");
								
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt4";
								$HASTA = $SYNC_OUT."adx_idt4";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt1";
								$HASTA = $SYNC_OUT."adx_idt1";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_ipgm";
								$HASTA = $SYNC_OUT."adx_ipgm";
								recurse_copy($DESDE,$HASTA);
							
								 //CREA ARCHIVO
								$DelFile = "ArmsRaceRpt".$RPTN2.".rpt";				
								 unlink($SYNC_OUT.$LOCAL.'/adx_idt4/'.$DelFile);
								 unlink($SYNC_OUT.'adx_idt4/'.$DelFile);
								 $open = fopen($SYNC_OUT."ADX_IDT1/"."ARMS.AR", "w+");
									 fwrite($open, $LN_PRINT);
								 fclose($open);
				 
			}
	}
	
	if($RPTN2 == 9){ //REPORTE 9 PAGO CHQ/VAR INFORME RESUMEN TDA 
			$ExcludedTerminals=@$_GET["ExcludedTerminals"];
			$Period=@$_GET["Period"];
			$LN_PRINT="";
			if($Orden==0){
								//CONSTRUIR ARCHIVO .AR
								$SQL="SELECT * FROM RA_NVL2 WHERE COD_NVL2=".$RPTN2;
								$RS = sqlsrv_query($conn, $SQL);
								//oci_execute($RS);
								if ($row = sqlsrv_fetch_array($RS)){
										$DES_ES_NVL2 =$row['DES_ES'];
								}
								$L1="[RACE ".$DES_ES_NVL2."]"."\r\n"; 
								$L2="ReportName = Tender Recap"."\r\n"; 
								if(!empty($OperTermId)){
									$L3="ExcludedTerminals = ".$ExcludedTerminals."\r\n"; 
								} else {
									$L3="";
								}
								//$L4="FileName = ArmsRaceRpt".$RPTN2." \r\n"; 
								$L4="FileName = ArmsRaceRpt".$RPTN2." \r\n"; 
								$L5="OverwriteFile = 1"." \r\n"; 
								$L6="Period = ".$Period." \r\n"; 
								$LN_PRINT=$L1.$L2.$L3.$L4.$L5.$L6." \r\n";

								//ELIMINAR ARCHIVOS EN HASTA
								Quitar_Archivos($SYNC_OUT."adx_idt4");
								Quitar_Archivos($SYNC_OUT."adx_idt1");
								Quitar_Archivos($SYNC_OUT."adx_ipgm");
								
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt4";
								$HASTA = $SYNC_OUT."adx_idt4";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt1";
								$HASTA = $SYNC_OUT."adx_idt1";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_ipgm";
								$HASTA = $SYNC_OUT."adx_ipgm";
								recurse_copy($DESDE,$HASTA);
							
								 //CREA ARCHIVO
								$DelFile = "ArmsRaceRpt".$RPTN2.".rpt";				
								 unlink($SYNC_OUT.$LOCAL.'/adx_idt4/'.$DelFile);
								 unlink($SYNC_OUT.'adx_idt4/'.$DelFile);

								 $open = fopen($SYNC_OUT."ADX_IDT1/"."ARMS.AR", "w+");
									 fwrite($open, $LN_PRINT);
								 fclose($open);
				 
			}
	}
	
	if($RPTN2 == 10){ //REPORTE 10 VENTAS OPERADOR
			$OperatorId=@$_GET["OperatorId"];
			$Scope=@$_GET["Scope"];
			$ExtendedPeriod=@$_GET["ExtendedPeriod"];
			if($Orden==0){
								//CONSTRUIR ARCHIVO .AR
								$SQL="SELECT * FROM RA_NVL2 WHERE COD_NVL2=".$RPTN2;
								$RS = sqlsrv_query($conn, $SQL);
								//oci_execute($RS);
								if ($row = sqlsrv_fetch_array($RS)){
										$DES_ES_NVL2 =$row['DES_ES'];
								}
								$L1="[RACE ".$DES_ES_NVL2."]"."\r\n"; 
								$L2="ReportName = Operator Sales"."\r\n"; 
								$L3="FileName = ArmsRaceRpt".$RPTN2." \r\n"; 
								$L4="OverwriteFile = 1"." \r\n"; 
								if(!empty($OperatorId)){
									$L5="OperatorId = ".$OperatorId."\r\n"; 
								} else {
									$L5="";
								}
								$L6="Scope = ".$Scope."\r\n"; 
								$L7="ExtendedPeriod = ".$ExtendedPeriod." \r\n"; 
								$LN_PRINT=$L1.$L2.$L3.$L4.$L5.$L6.$L7." \r\n";

								//ELIMINAR ARCHIVOS EN HASTA
								Quitar_Archivos($SYNC_OUT."adx_idt4");
								Quitar_Archivos($SYNC_OUT."adx_idt1");
								Quitar_Archivos($SYNC_OUT."adx_ipgm");
								
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt4";
								$HASTA = $SYNC_OUT."adx_idt4";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt1";
								$HASTA = $SYNC_OUT."adx_idt1";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_ipgm";
								$HASTA = $SYNC_OUT."adx_ipgm";
								recurse_copy($DESDE,$HASTA);
							
								 //CREA ARCHIVO
								$DelFile = "ArmsRaceRpt".$RPTN2.".rpt";				
								 unlink($SYNC_OUT.$LOCAL.'/adx_idt4/'.$DelFile);
								 unlink($SYNC_OUT.'adx_idt4/'.$DelFile);
								 $open = fopen($SYNC_OUT."ADX_IDT1/"."ARMS.AR", "w+");
									 fwrite($open, $LN_PRINT);
								 fclose($open);
				 
			}
	}
	
	if($RPTN2 == 11){ //REPORTE 11 TOTALES DEPARTAMENTO
			$ExtendedPeriod=@$_GET["ExtendedPeriod"];
			$Detail=@$_GET["Detail"];
			$Report=@$_GET["Report"];
			if($Orden==0){
								//CONSTRUIR ARCHIVO .AR
								$SQL="SELECT * FROM RA_NVL2 WHERE COD_NVL2=".$RPTN2;
								$RS = sqlsrv_query($conn, $SQL);
								//oci_execute($RS);
								if ($row = sqlsrv_fetch_array($RS)){
										$DES_ES_NVL2 =$row['DES_ES'];
								}
								$L1="[RACE ".$DES_ES_NVL2."]"."\r\n"; 
								$L2="ReportName = Department Totals"."\r\n"; 
								$L3="FileName = ArmsRaceRpt".$RPTN2." \r\n"; 
								$L4="OverwriteFile = 1"." \r\n"; 
								$L5="ExtendedPeriod = ".$ExtendedPeriod." \r\n"; 
								$L6="Detail = ".$Detail."\r\n"; 
								$L7="Report = ".$Report."\r\n"; 
								$LN_PRINT=$L1.$L2.$L3.$L4.$L5.$L6.$L7." \r\n";

								//ELIMINAR ARCHIVOS EN HASTA
								Quitar_Archivos($SYNC_OUT."adx_idt4");
								Quitar_Archivos($SYNC_OUT."adx_idt1");
								Quitar_Archivos($SYNC_OUT."adx_ipgm");
								
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt4";
								$HASTA = $SYNC_OUT."adx_idt4";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt1";
								$HASTA = $SYNC_OUT."adx_idt1";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_ipgm";
								$HASTA = $SYNC_OUT."adx_ipgm";
								recurse_copy($DESDE,$HASTA);
							
								 //CREA ARCHIVO
								$DelFile = "ArmsRaceRpt".$RPTN2.".rpt";				
								 unlink($SYNC_OUT.$LOCAL.'/adx_idt4/'.$DelFile);
								 unlink($SYNC_OUT.'adx_idt4/'.$DelFile);
								 $open = fopen($SYNC_OUT."ADX_IDT1/"."ARMS.AR", "w+");
									 fwrite($open, $LN_PRINT);
								 fclose($open);
				 
			}
	}
	
	if($RPTN2 == 12){ //REPORTE 12 TOTALES HORARIO DEPARTAMENTO
			$DepartmentNo=@$_GET["DepartmentNo"];
			$Scope=@$_GET["Scope"];
			$Period=@$_GET["Period"];
			if($Orden==0){
								//CONSTRUIR ARCHIVO .AR
								$SQL="SELECT * FROM RA_NVL2 WHERE COD_NVL2=".$RPTN2;
								$RS = sqlsrv_query($conn, $SQL);
								//oci_execute($RS);
								if ($row = sqlsrv_fetch_array($RS)){
										$DES_ES_NVL2 =$row['DES_ES'];
								}
								$L1="[RACE ".$DES_ES_NVL2."]"."\r\n"; 
								$L2="ReportName = Hourly Department Totals"."\r\n"; 
								$L3="FileName = ArmsRaceRpt".$RPTN2." \r\n"; 
								$L4="OverwriteFile = 1"." \r\n"; 
								$L5="DepartmentNo = ".$DepartmentNo." \r\n"; 
								$L6="Scope = ".$Scope."\r\n"; 
								$L7="Period = ".$Period."\r\n"; 
								$LN_PRINT=$L1.$L2.$L3.$L4.$L5.$L6.$L7." \r\n";

								//ELIMINAR ARCHIVOS EN HASTA
								Quitar_Archivos($SYNC_OUT."adx_idt4");
								Quitar_Archivos($SYNC_OUT."adx_idt1");
								Quitar_Archivos($SYNC_OUT."adx_ipgm");
								
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt4";
								$HASTA = $SYNC_OUT."adx_idt4";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt1";
								$HASTA = $SYNC_OUT."adx_idt1";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_ipgm";
								$HASTA = $SYNC_OUT."adx_ipgm";
								recurse_copy($DESDE,$HASTA);
							
								 //CREA ARCHIVO
								$DelFile = "ArmsRaceRpt".$RPTN2.".rpt";				
								 unlink($SYNC_OUT.$LOCAL.'/adx_idt4/'.$DelFile);
								 unlink($SYNC_OUT.'adx_idt4/'.$DelFile);
								 $open = fopen($SYNC_OUT."ADX_IDT1/"."ARMS.AR", "w+");
									 fwrite($open, $LN_PRINT);
								 fclose($open);
				 
			}
	}
	



	if($RPTN2 == 14){ //REPORTE 14 VARIACION DEPARTAMENTO
			$Period=@$_GET["Period"];
			if($Orden==0){
								//CONSTRUIR ARCHIVO .AR
								$SQL="SELECT * FROM RA_NVL2 WHERE COD_NVL2=".$RPTN2;
								$RS = sqlsrv_query($conn, $SQL);
								//oci_execute($RS);
								if ($row = sqlsrv_fetch_array($RS)){
										$DES_ES_NVL2 =$row['DES_ES'];
								}
								$L1="[RACE ".$DES_ES_NVL2."]"."\r\n"; 
								$L2="ReportName = Department Variance"."\r\n"; 
								$L3="FileName = ArmsRaceRpt".$RPTN2." \r\n"; 
								$L4="OverwriteFile = 1"." \r\n"; 
								$L5="Period = ".$Period." \r\n"; 
								$LN_PRINT=$L1.$L2.$L3.$L4.$L5." \r\n";

								//ELIMINAR ARCHIVOS EN HASTA
								Quitar_Archivos($SYNC_OUT."adx_idt4");
								Quitar_Archivos($SYNC_OUT."adx_idt1");
								Quitar_Archivos($SYNC_OUT."adx_ipgm");
								
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt4";
								$HASTA = $SYNC_OUT."adx_idt4";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt1";
								$HASTA = $SYNC_OUT."adx_idt1";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_ipgm";
								$HASTA = $SYNC_OUT."adx_ipgm";
								recurse_copy($DESDE,$HASTA);
//CREA ARCHIVO
								$DelFile = "ArmsRaceRpt".$RPTN2.".rpt";				
								 unlink($SYNC_OUT.$LOCAL.'/adx_idt4/'.$DelFile);
								 unlink($SYNC_OUT.'adx_idt4/'.$DelFile);
								 $open = fopen($SYNC_OUT."ADX_IDT1/"."ARMS.AR", "w+");
									 fwrite($open, $LN_PRINT);
								 fclose($open);
				 
			}
	}
	



	



	



	if($RPTN2 == 18){ //REPORTE 18 RENDIMIENTO OPERADOR
			$OperatorId=@$_GET["OperatorId"];
			$ExtendedPeriod=@$_GET["ExtendedPeriod"];
			$Scope=@$_GET["Scope"];
			if($Orden==0){
								//CONSTRUIR ARCHIVO .AR
								$SQL="SELECT * FROM RA_NVL2 WHERE COD_NVL2=".$RPTN2;
								$RS = sqlsrv_query($conn, $SQL);
								//oci_execute($RS);
								if ($row = sqlsrv_fetch_array($RS)){
										$DES_ES_NVL2 =$row['DES_ES'];
								}
								$L1="[RACE ".$DES_ES_NVL2."]"."\r\n"; 
								$L2="ReportName = Operator Performance"."\r\n"; 
								if(!empty($OperatorId)){
									$L3="OperatorId = ".$OperatorId."\r\n"; 
								} else {
									$L3="";
								}
								//$L4="FileName = ArmsRaceRpt".$RPTN2." \r\n"; 
								$L4="FileName = ArmsRaceRpt".$RPTN2." \r\n"; 
								$L5="OverwriteFile = 1"." \r\n"; 
								$L6="ExtendedPeriod = ".$ExtendedPeriod." \r\n"; 
								$L7="Scope = ".$Scope."\r\n"; 
								$LN_PRINT=$L1.$L2.$L3.$L4.$L5.$L6.$L7." \r\n";

								//ELIMINAR ARCHIVOS EN HASTA
								Quitar_Archivos($SYNC_OUT."adx_idt4");
								Quitar_Archivos($SYNC_OUT."adx_idt1");
								Quitar_Archivos($SYNC_OUT."adx_ipgm");
								
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt4";
								$HASTA = $SYNC_OUT."adx_idt4";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt1";
								$HASTA = $SYNC_OUT."adx_idt1";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_ipgm";
								$HASTA = $SYNC_OUT."adx_ipgm";
								recurse_copy($DESDE,$HASTA);
//CREA ARCHIVO
								$DelFile = "ArmsRaceRpt".$RPTN2.".rpt";				
								 unlink($SYNC_OUT.$LOCAL.'/adx_idt4/'.$DelFile);
								 unlink($SYNC_OUT.'adx_idt4/'.$DelFile);
								 $open = fopen($SYNC_OUT."ADX_IDT1/"."ARMS.AR", "w+");
									 fwrite($open, $LN_PRINT);
								 fclose($open);
				 
			}	
	}
	



	if($RPTN2 == 20){ //REPORTE 20 DETALLE DATOS DE ARTICULO
			$ItemCode=@$_GET["ItemCode"];
			if($Orden==0){
								//CONSTRUIR ARCHIVO .AR
								$SQL="SELECT * FROM RA_NVL2 WHERE COD_NVL2=".$RPTN2;
								$RS = sqlsrv_query($conn, $SQL);
								//oci_execute($RS);
								if ($row = sqlsrv_fetch_array($RS)){
										$DES_ES_NVL2 =$row['DES_ES'];
								}
								$L1="[RACE ".$DES_ES_NVL2."]"."\r\n"; 
								$L2="ReportName = Item Data Detail"."\r\n"; 
								$L3="FileName = ArmsRaceRpt".$RPTN2." \r\n"; 
								$L4="OverwriteFile = 1"." \r\n"; 
								$L5="ItemCode = ".$ItemCode." \r\n"; 
								$LN_PRINT=$L1.$L2.$L3.$L4.$L5." \r\n";

								//ELIMINAR ARCHIVOS EN HASTA
								Quitar_Archivos($SYNC_OUT."adx_idt4");
								Quitar_Archivos($SYNC_OUT."adx_idt1");
								Quitar_Archivos($SYNC_OUT."adx_ipgm");
								
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt4";
								$HASTA = $SYNC_OUT."adx_idt4";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt1";
								$HASTA = $SYNC_OUT."adx_idt1";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_ipgm";
								$HASTA = $SYNC_OUT."adx_ipgm";
								recurse_copy($DESDE,$HASTA);
//CREA ARCHIVO
								$DelFile = "ArmsRaceRpt".$RPTN2.".rpt";				
								 unlink($SYNC_OUT.$LOCAL.'/adx_idt4/'.$DelFile);
								 unlink($SYNC_OUT.'adx_idt4/'.$DelFile);
								 $open = fopen($SYNC_OUT."ADX_IDT1/"."ARMS.AR", "w+");
									 fwrite($open, $LN_PRINT);
								 fclose($open);
				 
			}	
	}

	if($RPTN2 == 21){ //REPORTE 20 RESUMEN DATOS DE ARTICULO
			$StartItemCode=@$_GET["StartItemCode"];
			$StopItemCode=@$_GET["StopItemCode"];
			$StartDeptID=@$_GET["StartDeptID"];
			$StopDeptID=@$_GET["StopDeptID"];
			$ItemDescription=@$_GET["ItemDescription"];
			$ItemTypes=@$_GET["ItemTypes"];
			$StartUserExit1=@$_GET["StartUserExit1"];
			$StopUserExit1=@$_GET["StopUserExit1"];
			$StartUserExit2=@$_GET["StartUserExit2"];
			$StopUserExit2=@$_GET["StopUserExit2"];
			$SortBy=@$_GET["SortBy"];
			if($Orden==0){
								//CONSTRUIR ARCHIVO .AR
								$SQL="SELECT * FROM RA_NVL2 WHERE COD_NVL2=".$RPTN2;
								$RS = sqlsrv_query($conn, $SQL);
								//oci_execute($RS);
								if ($row = sqlsrv_fetch_array($RS)){
										$DES_ES_NVL2 =$row['DES_ES'];
								}
								$L1="[RACE ".$DES_ES_NVL2."]"."\r\n"; 
								$L2="ReportName = Item Data Summary"."\r\n"; 
								$L3="FileName = ArmsRaceRpt".$RPTN2." \r\n"; 
								$L4="OverwriteFile = 1"." \r\n"; 
								$L5="StartItemCode = ".$StartItemCode." \r\n"; 
								$L5=$L5."StopItemCode = ".$StopItemCode." \r\n"; 
								$L5=$L5."StartDeptID = ".$StartDeptID." \r\n"; 
								$L5=$L5."StopDeptID = ".$StopDeptID." \r\n"; 
								$L5=$L5."ItemDescription = ".$ItemDescription." \r\n"; 
								$L5=$L5."ItemTypes = ".$ItemTypes." \r\n"; 
								$L5=$L5."StartUserExit1 = ".$StartUserExit1." \r\n"; 
								$L5=$L5."StopUserExit1 = ".$StopUserExit1." \r\n"; 
								$L5=$L5."StartUserExit2 = ".$StartUserExit2." \r\n"; 
								$L5=$L5."StopUserExit2 = ".$StopUserExit2." \r\n"; 
								$L5=$L5."SortBy = ".$SortBy." \r\n"; 
								$LN_PRINT=$L1.$L2.$L3.$L4.$L5." \r\n";

								//ELIMINAR ARCHIVOS EN HASTA
								Quitar_Archivos($SYNC_OUT."adx_idt4");
								Quitar_Archivos($SYNC_OUT."adx_idt1");
								Quitar_Archivos($SYNC_OUT."adx_ipgm");
								
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt4";
								$HASTA = $SYNC_OUT."adx_idt4";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt1";
								$HASTA = $SYNC_OUT."adx_idt1";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_ipgm";
								$HASTA = $SYNC_OUT."adx_ipgm";
								recurse_copy($DESDE,$HASTA);
//CREA ARCHIVO
								$DelFile = "ArmsRaceRpt".$RPTN2.".rpt";				
								 unlink($SYNC_OUT.$LOCAL.'/adx_idt4/'.$DelFile);
								 unlink($SYNC_OUT.'adx_idt4/'.$DelFile);
								 $open = fopen($SYNC_OUT."ADX_IDT1/"."ARMS.AR", "w+");
									 fwrite($open, $LN_PRINT);
								 fclose($open);
								
								sleep(30);

			}	
	}



	if($RPTN2 == 24){ //REPORTE 24 VENTAS NEGATIVAS OPERADOR
			$OperatorId=@$_GET["OperatorId"];
			$Period=@$_GET["Period"];
			if($Orden==0){
								//CONSTRUIR ARCHIVO .AR
								$SQL="SELECT * FROM RA_NVL2 WHERE COD_NVL2=".$RPTN2;
								$RS = sqlsrv_query($conn, $SQL);
								//oci_execute($RS);
								if ($row = sqlsrv_fetch_array($RS)){
										$DES_ES_NVL2 =$row['DES_ES'];
								}
								$L1="[RACE ".$DES_ES_NVL2."]"."\r\n"; 
								$L2="ReportName = Negative Sales"."\r\n"; 
								$L3="FileName = ArmsRaceRpt".$RPTN2." \r\n"; 
								$L4="OverwriteFile = 1"." \r\n"; 
								$L5="OperatorId = ".$OperatorId."\r\n"; 
								$L6="Period = ".$Period."\r\n"; 
								$LN_PRINT=$L1.$L2.$L3.$L4.$L5.$L6." \r\n";

								//ELIMINAR ARCHIVOS EN HASTA
								Quitar_Archivos($SYNC_OUT."adx_idt4");
								Quitar_Archivos($SYNC_OUT."adx_idt1");
								Quitar_Archivos($SYNC_OUT."adx_ipgm");
								
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt4";
								$HASTA = $SYNC_OUT."adx_idt4";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt1";
								$HASTA = $SYNC_OUT."adx_idt1";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_ipgm";
								$HASTA = $SYNC_OUT."adx_ipgm";
								recurse_copy($DESDE,$HASTA);
//CREA ARCHIVO
								$DelFile = "ArmsRaceRpt".$RPTN2.".rpt";				
								 unlink($SYNC_OUT.$LOCAL.'/adx_idt4/'.$DelFile);
								 unlink($SYNC_OUT.'adx_idt4/'.$DelFile);
								 $open = fopen($SYNC_OUT."ADX_IDT1/"."ARMS.AR", "w+");
									 fwrite($open, $LN_PRINT);
								 fclose($open);
				 
			}
	}



	if($RPTN2 == 26){ //REPORTE 26 INFORME ANULACION
			$OperTermId=@$_GET["OperTermId"];
			$Scope=@$_GET["Scope"];
			$Period=@$_GET["Period"];
			if($Orden==0){
								//CONSTRUIR ARCHIVO .AR
								$SQL="SELECT * FROM RA_NVL2 WHERE COD_NVL2=".$RPTN2;
								$RS = sqlsrv_query($conn, $SQL);
								//oci_execute($RS);
								if ($row = sqlsrv_fetch_array($RS)){
										$DES_ES_NVL2 =$row['DES_ES'];
								}
								$L1="[RACE ".$DES_ES_NVL2."]"."\r\n"; 
								$L2="ReportName = Void"."\r\n"; 
								$L3="FileName = ArmsRaceRpt".$RPTN2." \r\n"; 
								$L4="OverwriteFile = 1"." \r\n"; 
								if(!empty($OperTermId)){
									$L5="OperTermId = ".$OperTermId."\r\n"; 
								} else {
									$L5="";
								}
								$L6="Scope = ".$Scope."\r\n"; 
								$L7="Period = ".$Period."\r\n"; 
								$LN_PRINT=$L1.$L2.$L3.$L4.$L5.$L6.$L7." \r\n";

								//ELIMINAR ARCHIVOS EN HASTA
								Quitar_Archivos($SYNC_OUT."adx_idt4");
								Quitar_Archivos($SYNC_OUT."adx_idt1");
								Quitar_Archivos($SYNC_OUT."adx_ipgm");
								
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt4";
								$HASTA = $SYNC_OUT."adx_idt4";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt1";
								$HASTA = $SYNC_OUT."adx_idt1";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_ipgm";
								$HASTA = $SYNC_OUT."adx_ipgm";
								recurse_copy($DESDE,$HASTA);
//CREA ARCHIVO
								$DelFile = "ArmsRaceRpt".$RPTN2.".rpt";				
								 unlink($SYNC_OUT.$LOCAL.'/adx_idt4/'.$DelFile);
								 unlink($SYNC_OUT.'adx_idt4/'.$DelFile);
								 $open = fopen($SYNC_OUT."ADX_IDT1/"."ARMS.AR", "w+");
									 fwrite($open, $LN_PRINT);
								 fclose($open);
				 
			}
	}
	
	if($RPTN2 == 27){ //REPORTE 27 INFORME DEVOLUCIONES
			$OperTermId=@$_GET["OperTermId"];
			$Scope=@$_GET["Scope"];
			$Period=@$_GET["Period"];
			if($Orden==0){
								//CONSTRUIR ARCHIVO .AR
								$SQL="SELECT * FROM RA_NVL2 WHERE COD_NVL2=".$RPTN2;
								$RS = sqlsrv_query($conn, $SQL);
								//oci_execute($RS);
								if ($row = sqlsrv_fetch_array($RS)){
										$DES_ES_NVL2 =$row['DES_ES'];
								}
								$L1="[RACE ".$DES_ES_NVL2."]"."\r\n"; 
								$L2="ReportName = Refund"."\r\n"; 
								$L3="FileName = ArmsRaceRpt".$RPTN2." \r\n"; 
								$L4="OverwriteFile = 1"." \r\n"; 
								if(!empty($OperTermId)){
									$L5="OperTermId = ".$OperTermId."\r\n"; 
								} else {
									$L5="";
								}
								$L6="Scope = ".$Scope."\r\n"; 
								$L7="Period = ".$Period."\r\n"; 
								$LN_PRINT=$L1.$L2.$L3.$L4.$L5.$L6.$L7." \r\n";

								//ELIMINAR ARCHIVOS EN HASTA
								Quitar_Archivos($SYNC_OUT."adx_idt4");
								Quitar_Archivos($SYNC_OUT."adx_idt1");
								Quitar_Archivos($SYNC_OUT."adx_ipgm");
								
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt4";
								$HASTA = $SYNC_OUT."adx_idt4";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_idt1";
								$HASTA = $SYNC_OUT."adx_idt1";
								recurse_copy($DESDE,$HASTA);
							
								$DESDE = $SYNC_OUT.$LOCAL."/adx_ipgm";
								$HASTA = $SYNC_OUT."adx_ipgm";
								recurse_copy($DESDE,$HASTA);
//CREA ARCHIVO
								$DelFile = "ArmsRaceRpt".$RPTN2.".rpt";				
								 unlink($SYNC_OUT.$LOCAL.'/adx_idt4/'.$DelFile);
								 unlink($SYNC_OUT.'adx_idt4/'.$DelFile);
								 $open = fopen($SYNC_OUT."ADX_IDT1/"."ARMS.AR", "w+");
									 fwrite($open, $LN_PRINT);
								 fclose($open);
				 
			}
	}
	



				$GenReport=0;
				$FileName="ArmsRaceRpt".$RPTN2.".rpt";				
				
				$Tam_Arc = filesize($SYNC_OUT.'adx_idt4/'.$FileName);
				$Tam_Ref = filesize($SYNC_OUT.'adx_idt4/'.$FileName);
				
					if (file_exists($SYNC_OUT.'adx_idt4/'.$FileName) && $Tam_Arc>0) {
						if($Tam_Arc==$Tam_Ref){
							if (is_writable($SYNC_OUT.'adx_idt4/'.$FileName)) {
								 rename($SYNC_OUT.'adx_idt4/'.$FileName, $SYNC_OUT.$LOCAL.'/adx_idt4/'.$FileName);
								$GenReport=1;
							}
						}
					}
	


?>

<SCRIPT LANGUAGE="JavaScript">
		function autoRefresh() {
			<?php if($CTA<=$TERA){?>
					<?php if($GenReport==0){?> self.location.href="GeneraReporte.php?<?php echo $StringForm;?>&CTA=<?php echo $CTA?>&Orden=1"; <?php }?>
					<?php if($GenReport==1){?> parent.location.href="repo4690.php?<?php echo $StringForm?>&rpt=<?php echo $FileName?>&MSJE=2"; <?php }?>
			<?php } else {?>
						parent.location.href="repo4690.php?<?php echo $StringForm?>&MSJE=1";
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
