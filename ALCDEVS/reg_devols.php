
<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php

	$PAGINA=1144;
	$NOMENU=0;
	$MSJE=@$_GET["MSJE"];

	$SALSINREG=@$_GET["ssr"];
	if(!empty($SALSINREG)){
			//VERIFICAR USUARIO
			$SQLELMV="SELECT IDREG FROM DV_TICKET WHERE ID_DEVS=".$SALSINREG;
			$REGV = sqlsrv_query($conn, $SQLELMV);
			//oci_execute($REGV);
			if ($row_V = sqlsrv_fetch_array($REGV)) {
					$IDREG_SSR = $row_V['IDREG'];
			}
			if($SESIDUSU==$IDREG_SSR){
					$SQLELMA="DELETE FROM DV_ARTS WHERE ID_DEVS=".$SALSINREG;
					$REGA = sqlsrv_query($conn, $SQLELMA);
					//oci_execute($REGA);
					$SQLREGT="DELETE FROM DV_TICKET WHERE ID_DEVS=".$SALSINREG;
					$REGT = sqlsrv_query($conn, $SQLREGT);
					//oci_execute($REGT);
					header("Location: reg_devols.php?MSJE=2");
			}
	}
	
	$LIST=@$_GET["LIST"];
	$VER_DNC=@$_GET["VDNC"];
	$D_GFC=@$_GET["D_GFC"];
		if($D_GFC==1) {$MOD_DEV="Giftcard";}
		if($D_GFC==2) {$MOD_DEV="Efectivo";}
		if($D_GFC==3) {$MOD_DEV="Cambio Cliente Factura";}
	$C_DEV=@$_GET["C_DEV"];
	if(!empty($C_DEV)) { $NOMENU=1;}
	$ID_DEVS=@$_GET["IDDV"];
	if(!empty($ID_DEVS)) { $NOMENU=1;}
	$TCKTSEL=@$_POST["TCKTSEL"];
	if (empty($TCKTSEL)) { $TCKTSEL=@$_GET["TCKTSEL"] ;}
	$VRF=@$_POST["VRF"];
	if (empty($VRF)) { $VRF=@$_GET["VRF"] ;}
	if (empty($VRF)) { $VRF=0 ;}
	
	
	if($VRF==0){
	//VERIFICAR ID_DEVS Y ESTADO 0 PARA USUARIO
	
			$SV="SELECT * FROM DV_TICKET WHERE ID_ESTADO<=1 AND IDREG=".$SESIDUSU;
			$RSV = sqlsrv_query($conn, $SV);
			//oci_execute($RSV);
			if ($rowV = sqlsrv_fetch_array($RSV)) {
				$ID_TIPOD_VER = $rowV['ID_TIPOD'];
				$ID_DEVS_VER = $rowV['ID_DEVS'];
				$ID_TRN_VER = $rowV['ID_TRN'];
				$ID_ESTADO_VER = $rowV['ID_ESTADO'];
				if($ID_ESTADO_VER==0){ header("Location: reg_devols.php?D_GFC=".$ID_TIPOD_VER."&TCKTSEL=".$ID_TRN_VER."&IDDV=".$ID_DEVS_VER."&VRF=1"); }
				if($ID_ESTADO_VER==1){ header("Location: reg_devols.php?D_GFC=".$ID_TIPOD_VER."&C_DEV=1&IDD=".$ID_DEVS_VER."&VRF=1"); }
			}
	}
								
	
	if ($D_GFC=="" and $C_DEV=="" and $VER_DNC=="") {
		 $LIST=1;
	}
	

	if($D_GFC==3){
		$FILTRO_DGFC=" AND ID_TRN IN(SELECT ID_TRN FROM TR_INVC) ";
		$TICKET_FACT=" Factura ";
	} else {
		$FILTRO_DGFC="";
		$TICKET_FACT="";
	}

	$FILTRO_FLAGS=" AND FL_TRG_TRN<>1 AND FL_CNCL<>1 AND FL_VD<>1 AND FL_SPN IS NULL";

	$BSC_NDC=@$_POST["BSC_NDC"];
	if (empty($BSC_NDC)) { $BSC_NDC=@$_GET["BSC_NDC"] ;}
		
				$VERTND_UNO = 0;
				//VERIFICAR TIENDAS ASOCIADAS A USUARIO
				$SQL="SELECT COUNT(COD_TIENDA) AS CTATND FROM US_USUTND WHERE IDUSU=".$SESIDUSU;
				$RS = sqlsrv_query($maestra, $SQL);
				//oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {
					$CTATND = $row['CTATND'];
				}
				//SI CTATND==0 USUARIO CENTRAL, SELECCIONAR NEGOCIO Y LOCAL
				//SI CTATND==1 DESPLEGAR LOCAL
				//SI CTATND>1 DESPLEGAR LISTADO DE LOCALES
				if($CTATND==1){
					//OBTENER NEGOCIO
					$SQL="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO IN(SELECT COD_NEGOCIO FROM US_USUTND WHERE IDUSU=".$SESIDUSU.")";
					$RS = sqlsrv_query($maestra, $SQL);
					//oci_execute($RS);
					if ($row = sqlsrv_fetch_array($RS)) {
						$COD_NEGOCIO_SEL = $row['COD_NEGOCIO'];
						$DES_NEGOCIO = $row['DES_NEGOCIO'];
						$ELNEGOCIO = $DES_NEGOCIO;
					}
					//OBTENER TIENDA
					$SQL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA IN(SELECT COD_TIENDA FROM US_USUTND WHERE IDUSU=".$SESIDUSU.")";
					$RS = sqlsrv_query($maestra, $SQL);
					//oci_execute($RS);
					if ($row = sqlsrv_fetch_array($RS)) {
						$DES_CLAVE = $row['DES_CLAVE'];
						$DES_CLAVE_F="0000".$DES_CLAVE;
						$DES_CLAVE_F=substr($DES_CLAVE_F, -4); 
						$DES_TIENDA = $row['DES_TIENDA'];
						$LATIENDA = $DES_CLAVE_F." ".$DES_TIENDA;
						$COD_TIENDA_SEL = $row['COD_TIENDA'];
						//VERIFICAR QUE TIENDA SE ENCUENTRE REGISTRADA Y/O CON PRECIOS ARTS.AS_ITM_STR
						$SQL1="SELECT COUNT(ID_BSN_UN) AS VERTND FROM PA_STR_RTL WHERE CD_STR_RT=".$DES_CLAVE;
						$RS1 = sqlsrv_query($arts_conn, $SQL1);
						//oci_execute($RS1);
						if ($row1 = sqlsrv_fetch_array($RS1)) {
							$VERTND_UNO = $row1['VERTND'];
						}
						$LATIENDA_SI = "Tienda: ".$DES_CLAVE_F." - ".$DES_TIENDA;
						//OBTENER ID_BSN_UN
						$SQL1="SELECT ID_BSN_UN FROM PA_STR_RTL WHERE CD_STR_RT=".$DES_CLAVE;
						$RS1 = sqlsrv_query($arts_conn, $SQL1);
						//oci_execute($RS1);
						if ($row1 = sqlsrv_fetch_array($RS1)) {
							$ID_BSN_UN_SEL = $row1['ID_BSN_UN'];
						}
					}
				} else { //if($CTATND==1)

								$COD_NEGOCIO_SEL=@$_POST["COD_NEGOCIO"];
								if(empty($COD_NEGOCIO_SEL)) { $COD_NEGOCIO_SEL=@$_GET["COD_NEGOCIO"];}
								if(empty($COD_NEGOCIO_SEL)) { $COD_NEGOCIO_SEL=@$_POST["COD_NEGOCIO_SI"];}
								if(empty($COD_NEGOCIO_SEL)) { $COD_NEGOCIO_SEL=@$_GET["COD_NEGOCIO_SI"];}
								
								$COD_TIENDA_SEL=@$_POST["COD_TIENDA"];
								if(empty($COD_TIENDA_SEL)) { $COD_TIENDA_SEL=@$_GET["COD_TIENDA"];}
								if(empty($COD_TIENDA_SEL)) { $COD_TIENDA_SEL=@$_POST["COD_TIENDA_SI"];}
								if(empty($COD_TIENDA_SEL)) { $COD_TIENDA_SEL=@$_GET["COD_TIENDA_SI"];}
								
								if(!empty($COD_TIENDA_SEL)) {
									$SQL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA=".$COD_TIENDA_SEL;
									$RS = sqlsrv_query($maestra, $SQL);
									//oci_execute($RS);
									if ($row = sqlsrv_fetch_array($RS)) {
										$DES_CLAVE_SEL = $row['DES_CLAVE'];
										$DES_CLAVE_FSI="0000".$DES_CLAVE_SEL;
										$DES_CLAVE_FSI=substr($DES_CLAVE_FSI, -4); 
										$DES_TIENDA_FSI = $row['DES_TIENDA'];
										$LATIENDA_SI = "Tienda: ".$DES_CLAVE_FSI." - ".$DES_TIENDA_FSI;
				
									}
									$SQL="SELECT ID_BSN_UN FROM PA_STR_RTL WHERE CD_STR_RT=".$DES_CLAVE_SEL;
									$RS = sqlsrv_query($arts_conn, $SQL);
									//oci_execute($RS);
									if ($row = sqlsrv_fetch_array($RS)) {
										$ID_BSN_UN_SEL = $row['ID_BSN_UN'];
									}
								}

				} //if($CTATND==1)

	
	$FILTRO_TIENDANC=" AND ID_BSN_UN=".$ID_BSN_UN_SEL;
	$FILTRO_TIENDA=" AND ID_BSN_UN=".$ID_BSN_UN_SEL;

	$FILTRO_TIPONC="";
	$B_TIPOD=@$_POST["B_TIPOD"];
	if (empty($B_TIPOD)) { $B_TIPOD=@$_GET["B_TIPOD"] ;}
	if (empty($B_TIPOD)) { $B_TIPOD=0 ;}
	if ($B_TIPOD!=0) {
		$FILTRO_TIPONC=" AND ID_TIPOD=".$B_TIPOD ;
	}

	$FILTRO_NC="";
	$B_NNDC=@$_POST["B_NNDC"];
	if (empty($B_NNDC)) { $B_NNDC=@$_GET["B_NNDC"] ;}
	if (!empty($B_NNDC)) {
		$FILTRO_NC=" AND ID_DEVS=".$B_NNDC ;
	}

	$FILTRO_CLTE="";
	/*
	$B_CLTE=@$_POST["B_CLTE"];
	if (empty($B_CLTE)) { $B_CLTE=@$_GET["B_CLTE"] ;}
	if (!empty($B_CLTE)) {
		$FILTRO_CLTE=" AND ID_DEVS IN(SELECT ID_DEVS FROM DV_DEVCLTE WHERE COD_CLIENTE IN(SELECT COD_CLIENTE FROM DV_CLIENTE WHERE (UPPER(TRIM(IDENTIFICACION)) Like '%".strtoupper($B_CLTE)."%') OR (UPPER(TRIM(NOMBRE)) Like '%".strtoupper($B_CLTE)."%')  OR (UPPER(TRIM(APELLIDO_P)) Like '%".strtoupper($B_CLTE)."%')  OR (UPPER(TRIM(APELLIDO_M)) Like '%".strtoupper($B_CLTE)."%')  ))" ;
	}
	*/

	$BUSCAR=@$_POST["BUSCAR"];
	if (empty($BUSCAR)) { $BUSCAR=@$_GET["BUSCAR"] ;}
	
	$FILTRO_TERM="";
	$FTERM=@$_POST["FTERM"];
	if (empty($FTERM)) { $FTERM=@$_GET["FTERM"] ;}
	if (empty($FTERM)) { $FTERM=0 ;}
	if ($FTERM!=0) {
		$FILTRO_TERM=" AND ID_WS=".$FTERM ;
	}
		
	$FILTRO_OPERA="";
	$FOPERA=@$_POST["FOPERA"];
	if (empty($FOPERA)) { $FOPERA=@$_GET["FOPERA"] ;}
	if (empty($FOPERA)) { $FOPERA=0 ;}
	if ($FOPERA!=0) {
		$FILTRO_OPERA=" AND ID_OPR=".$FOPERA ;
	}
		
	$FILTRO_TICKET="";
	$BOPCION=@$_POST["BOPCION"];
	if (empty($BOPCION)) { $BOPCION=@$_GET["BOPCION"];}
	if (empty($BOPCION)) { $BOPCION=2;}
				if ($BOPCION==1) {
						$FILTRO_DGFC=" AND ID_TRN IN(SELECT ID_TRN FROM TR_INVC) ";
				} 
	$B_TICKET=@$_POST["B_TICKET"];
	if (empty($B_TICKET)) { $B_TICKET=@$_GET["B_TICKET"] ;}
	if (!empty($B_TICKET)) {
			if($D_GFC==3){
				$FILTRO_TICKET="" ;
				$FILTRO_FACT=" AND ID_TRN IN(SELECT ID_TRN FROM TR_INVC WHERE INVC_NMB Like '%".$B_TICKET."%') ";
			} else {
				if ($BOPCION==1) {
						$FILTRO_TICKET="" ;
						$FILTRO_FACT=" AND ID_TRN IN(SELECT ID_TRN FROM TR_INVC WHERE INVC_NMB Like '%".$B_TICKET."%') ";
						$FILTRO_DGFC=" AND ID_TRN IN(SELECT ID_TRN FROM TR_INVC) ";
				} 
				if ($BOPCION==2) {
						$FILTRO_TICKET=" AND AI_TRN=".$B_TICKET;
						$FILTRO_FACT=" " ;
				} 
			}
	}


			
					//CALCULAR MINIMO Y MÁXIMO FECHA REGISTRO TICKET
					$CONSULTA2="SELECT MIN(TS_TRN_END) AS MFECHA FROM TR_TRN WHERE ID_TRN IN (SELECT ID_TRN FROM TR_RTL WHERE QU_UN_RTL_TRN>0) AND FL_VD<>1 AND FL_CNCL<>1";
					$RS2 = sqlsrv_query($arts_conn, $CONSULTA2);
					//oci_execute($RS2);
					if ($row = sqlsrv_fetch_array($RS2)){
							$MIN_FECHA_EMS = $row['MFECHA'];
							
							$MIN_FECHA_EMS = @date_format($MIN_FECHA_EMS, 'd/m/Y');
					}
					$CONSULTA2="SELECT MAX(TS_TRN_END) AS MFECHA FROM TR_TRN WHERE ID_TRN IN (SELECT ID_TRN FROM TR_RTL WHERE QU_UN_RTL_TRN>0) AND FL_VD<>1 AND FL_CNCL<>1";
					$RS2 = sqlsrv_query($arts_conn, $CONSULTA2);
					//oci_execute($RS2);
					if ($row = sqlsrv_fetch_array($RS2)){
							$MAX_FECHA_EMS = $row['MFECHA'];
							
							$MAX_FECHA_EMS = @date_format($MAX_FECHA_EMS, 'd/m/Y');
					}
					if (empty($MIN_FECHA_EMS)) { $MIN_FECHA_EMS=date('d/m/Y'); }
					if (empty($MAX_FECHA_EMS)) { $MAX_FECHA_EMS=date('d/m/Y'); }
					
					//FECHA REGISTRO TICKET DESDE
					$DIA_ED=@$_POST["DIA_ED"];
					if (empty($DIA_ED)) { $DIA_ED=@$_GET["DIA_ED"]; }
					if (empty($DIA_ED)) { $DIA_ED=substr($MIN_FECHA_EMS, 0, 2); }
					$MES_ED=@$_POST["MES_ED"];
					if (empty($MES_ED)) { $MES_ED=@$_GET["MES_ED"]; }
					if (empty($MES_ED)) { $MES_ED=substr($MIN_FECHA_EMS, 3, 2); }
					$ANO_ED=@$_POST["ANO_ED"];
					if (empty($ANO_ED)) { $ANO_ED=@$_GET["ANO_ED"]; }
					if (empty($ANO_ED)) { $ANO_ED='20'.substr($MIN_FECHA_EMS, -2); }
					//FECHA REGISTRO HASTA
					$DIA_EH=@$_POST["DIA_EH"];
					if (empty($DIA_EH)) { $DIA_EH=@$_GET["DIA_EH"]; }
					if (empty($DIA_EH)) { $DIA_EH=substr($MAX_FECHA_EMS, 0, 2); }
					$MES_EH=@$_POST["MES_EH"];
					if (empty($MES_EH)) { $MES_EH=@$_GET["MES_EH"]; }
					if (empty($MES_EH)) { $MES_EH=substr($MAX_FECHA_EMS, 3, 2); }
					$ANO_EH=@$_POST["ANO_EH"];
					if (empty($ANO_EH)) { $ANO_EH=@$_GET["ANO_EH"]; }
					if (empty($ANO_EH)) { $ANO_EH='20'.substr($MAX_FECHA_EMS, -2); }
					//CONSTRUYE FECHAS REGISTRO TICKET
					//VALIDAR FECHA_ED
					if (checkdate($MES_ED, $DIA_ED, $ANO_ED)==false) { 
						$MSJE=2 ;
						$DIA_ED=substr($MIN_FECHA_EMS, 0, 2);
						$MES_ED=substr($MIN_FECHA_EMS, 3, 2);
						$ANO_ED='20'.substr($MIN_FECHA_EMS, -2);
						$DIA_EH=substr($MAX_FECHA_EMS, 0, 2);
						$MES_EH=substr($MAX_FECHA_EMS, 3, 2);
						$ANO_EH='20'.substr($MAX_FECHA_EMS, -2);
					}
					$DIA_ED=substr('00'.$DIA_ED, -2);
					$MES_ED=substr('00'.$MES_ED, -2);
					$FECHA_ED=$DIA_ED."/".$MES_ED."/".$ANO_ED;
					
					if (checkdate($MES_EH, $DIA_EH, $ANO_EH)==false) { 
						$MSJE=3 ;
						$DIA_ED=substr($MIN_FECHA_EMS, 0, 2);
						$MES_ED=substr($MIN_FECHA_EMS, 3, 2);
						$ANO_ED='20'.substr($MIN_FECHA_EMS, -2);
						$DIA_EH=substr($MAX_FECHA_EMS, 0, 2);
						$MES_EH=substr($MAX_FECHA_EMS, 3, 2);
						$ANO_EH='20'.substr($MAX_FECHA_EMS, -2);
					}
					$DIA_EH=substr('00'.$DIA_EH, -2);
					$MES_EH=substr('00'.$MES_EH, -2);
					$FECHA_EH=$DIA_EH."/".$MES_EH."/".$ANO_EH;
					//FILTRO FECHA REGISTRO

					//$F_FECHA=" WHERE (TO_CHAR(TS_TRN_END,'yyyy-mm-dd hh24:mi:ss') >= '".$ANO_ED."-".$MES_ED."-".$DIA_ED." 00:00:00' AND TO_CHAR(TS_TRN_END,'yyyy-mm-dd hh24:mi:ss') <='".$ANO_EH."-".$MES_EH."-".$DIA_EH." 23:59:59' )  AND FL_VD<>1 AND FL_CNCL<>1"; 

					$F_FECHA=" WHERE  Convert(varchar(20),TS_TRN_END, 111) >= Convert(varchar(20),'".$ANO_ED."/".$MES_ED."/".$DIA_ED."', 111) AND Convert(varchar(20), TS_TRN_END, 111) <= Convert(varchar(20),'".$ANO_EH."/".$MES_EH."/".$DIA_EH."', 111) AND FL_VD<>1 AND FL_CNCL<>1"; 


					//CALCULAR MINIMO Y MÁXIMO FECHA REGISTRO NOTA DE CREDITO
					$CONSULTA2="SELECT MIN(FECHA_REG) AS MFECHA FROM DV_TICKET";
					$RS2 = sqlsrv_query($conn, $CONSULTA2);
					//oci_execute($RS2);
					if ($row = sqlsrv_fetch_array($RS2)){
							$MIN_FECHA_NCEMS = $row['MFECHA'];
							
							$MIN_FECHA_NCEMS = @date_format($MIN_FECHA_NCEMS, 'd/m/Y');

					}
					$CONSULTA2="SELECT MAX(FECHA_REG) AS MFECHA FROM DV_TICKET";
					$RS2 = sqlsrv_query($conn, $CONSULTA2);
					//oci_execute($RS2);
					if ($row = sqlsrv_fetch_array($RS2)){
							$MAX_FECHA_NCEMS = $row['MFECHA'];
							
							$MAX_FECHA_NCEMS = @date_format($MAX_FECHA_NCEMS, 'd/m/Y');
					}
					if (empty($MIN_FECHA_NCEMS)) { $MIN_FECHA_NCEMS=date('d/m/Y'); }
					if (empty($MAX_FECHA_NCEMS)) { $MAX_FECHA_NCEMS=date('d/m/Y'); }
					
					//FECHA REGISTRO NOTA DE CREDITO DESDE
					$DIA_NCED=@$_POST["DIA_NCED"];
					if (empty($DIA_NCED)) { $DIA_NCED=@$_GET["DIA_NCED"]; }
					if (empty($DIA_NCED)) { $DIA_NCED=substr($MIN_FECHA_NCEMS, 0, 2); }
					$MES_NCED=@$_POST["MES_NCED"];
					if (empty($MES_NCED)) { $MES_NCED=@$_GET["MES_NCED"]; }
					if (empty($MES_NCED)) { $MES_NCED=substr($MIN_FECHA_NCEMS, 3, 2); }
					$ANO_NCED=@$_POST["ANO_NCED"];
					if (empty($ANO_NCED)) { $ANO_NCED=@$_GET["ANO_NCED"]; }
					if (empty($ANO_NCED)) { $ANO_NCED='20'.substr($MIN_FECHA_NCEMS, -2); }
					//FECHA REGISTRO HASTA
					$DIA_NCEH=@$_POST["DIA_NCEH"];
					if (empty($DIA_NCEH)) { $DIA_NCEH=@$_GET["DIA_NCEH"]; }
					if (empty($DIA_NCEH)) { $DIA_NCEH=substr($MAX_FECHA_NCEMS, 0, 2); }
					$MES_NCEH=@$_POST["MES_NCEH"];
					if (empty($MES_NCEH)) { $MES_NCEH=@$_GET["MES_NCEH"]; }
					if (empty($MES_NCEH)) { $MES_NCEH=substr($MAX_FECHA_NCEMS, 3, 2); }
					$ANO_NCEH=@$_POST["ANO_NCEH"];
					if (empty($ANO_NCEH)) { $ANO_NCEH=@$_GET["ANO_NCEH"]; }
					if (empty($ANO_NCEH)) { $ANO_NCEH='20'.substr($MAX_FECHA_NCEMS, -2); }
					//CONSTRUYE FECHAS REGISTRO TICKET
					//VALIDAR FECHA_ED
					if (checkdate($MES_NCED, $DIA_NCED, $ANO_NCED)==false) { 
						$MSJE=2 ;
						$DIA_NCED=substr($MIN_FECHA_NCEMS, 0, 2);
						$MES_NCED=substr($MIN_FECHA_NCEMS, 3, 2);
						$ANO_NCED='20'.substr($MIN_FECHA_NCEMS, -2);
						$DIA_NCEH=substr($MAX_FECHA_NCEMS, 0, 2);
						$MES_NCEH=substr($MAX_FECHA_NCEMS, 3, 2);
						$ANO_NCEH='20'.substr($MAX_FECHA_NCEMS, -2);
					}
					$DIA_NCED=substr('00'.$DIA_NCED, -2);
					$MES_NCED=substr('00'.$MES_NCED, -2);
					$FECHA_NCED=$DIA_NCED."/".$MES_NCED."/".$ANO_NCED;
					
					if (checkdate($MES_NCEH, $DIA_NCEH, $ANO_NCEH)==false) { 
						$MSJE=3 ;
						$DIA_NCED=substr($MIN_FECHA_NCEMS, 0, 2);
						$MES_NCED=substr($MIN_FECHA_NCEMS, 3, 2);
						$ANO_NCED='20'.substr($MIN_FECHA_NCEMS, -2);
						$DIA_NCEH=substr($MAX_FECHA_NCEMS, 0, 2);
						$MES_NCEH=substr($MAX_FECHA_NCEMS, 3, 2);
						$ANO_NCEH='20'.substr($MAX_FECHA_NCEMS, -2);
					}
					$DIA_NCEH=substr('00'.$DIA_NCEH, -2);
					$MES_NCEH=substr('00'.$MES_NCEH, -2);
					$FECHA_NCEH=$DIA_NCEH."/".$MES_NCEH."/".$ANO_NCEH;
					//FILTRO FECHA REGISTRO

					$FNC_FECHA=" WHERE Convert(varchar(20),FECHA_REG, 111) >=  Convert(varchar(20),'".$ANO_NCED."/".$MES_NCED."/".$DIA_NCED."', 111) AND Convert(varchar(20), FECHA_REG, 111) <= Convert(varchar(20),'".$ANO_NCEH."/".$MES_NCEH."/".$DIA_NCEH."', 111) ";


?>

</head>
<body>

<?php include("encabezado.php");?>
<?php include("titulo_menu.php");?>
<table width="100%" height="100%">
<tr>
<?php if($NOMENU!=1){ ?>
        <td align="right"  width="200" bgcolor="#FFFFFF"><?php include("menugeneral.php");?></td> 
<?php } ?>        
<td <?php if($NOMENU==1){ ?> style="padding-left:10px"<?php } ?> >
<?php
if ($MSJE==1) {$ELMSJ="Debe seleccionar al menos un Art&iacute;culo en Devoluci&oacute;n";} 
if ($MSJE==2) {$ELMSJ="Se ha eliminado el registro de Devoluci&oacute;n";} 
if ($MSJE==3) {$ELMSJ="No se ha le&iacute;do la Tarjeta<br>Por favor, vuelva a intentar";} 
if ($MSJE==4) {$ELMSJ="El Sistema no ha recibido respuesta<br>Por favor, vuelva a intentar m&aacute;s tarde<br>- - -<br>Si el problema persiste, favor de<br>Informar al Administrador";} 
if ($MSJE==5) {$ELMSJ="Tarjeta Rechazada<BR>Por favor intente con una Nueva Tarjeta";} 
if ($MSJE==6) {$ELMSJ="El Sistema no ha recibido respuesta<br>Por favor, vuelva a intentar nuevamente";} 
if ($MSJE==7) {$ELMSJ="Tarjeta Activada<br>Imprima la Nota de Cr&eacute;dito<br>y adjunte la Tarjeta Giftcard";} 
if ($MSJE==8) {$ELMSJ="Nota de Cr&eacute;dito registrada";} 
if ($MSJE==9) {$ELMSJ="El Cobro de la Nota de Cr&eacute;dito est&aacute; habilitado<br>en el Terminal POS seleccionado";} 
if ($MSJE==10) {$ELMSJ="El Cobro de la Nota de Cr&eacute;dito est&aacute; habilitado y ejecutado";} 
if ($MSJE==11) {$ELMSJ="Se ha registrado la Nota de Cr&eacute;dito para el Cambio de Cliente Factura<br>Registro habilitado en el Terminal POS seleccionado";} 
if ($MSJE <> "") {
?>
<div id="GMessaje" onClick="QuitarGMessage();"><a href="#" onClick="QuitarGMessage();" style="color:#111111;"><?=$ELMSJ?></a></div>
<?php }?>
        <table width="100%">
        <tr><td>
        <h2><?=$LAPAGINA?><?php if($D_GFC!=""){ echo " :: ".$MOD_DEV;}?></h2>
        
		<?php if($LIST==1){ ?>
                <table width="100%" id="Filtro">
                <form action="reg_devols.php?BSC_NDC=1" method="post" name="forming" id="forming">
                <tr>
                <td>
										<?php
                                            $VERTND_UNO = 0;
                                            //VERIFICAR TIENDAS ASOCIADAS A USUARIO
                                            $SQL="SELECT COUNT(COD_TIENDA) AS CTATND FROM US_USUTND WHERE IDUSU=".$SESIDUSU;
                                            $RS = sqlsrv_query($maestra, $SQL);
                                            //oci_execute($RS);
                                            if ($row = sqlsrv_fetch_array($RS)) {
                                                $CTATND = $row['CTATND'];
                                            }
                                            //SI CTATND==0 USUARIO CENTRAL, SELECCIONAR NEGOCIO Y LOCAL
                                            //SI CTATND==1 DESPLEGAR LOCAL
                                            //SI CTATND>1 DESPLEGAR LISTADO DE LOCALES
                                            if($CTATND==1){
                                                //OBTENER NEGOCIO
                                                $SQL="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO IN(SELECT COD_NEGOCIO FROM US_USUTND WHERE IDUSU=".$SESIDUSU.")";
                                                $RS = sqlsrv_query($maestra, $SQL);
                                                //oci_execute($RS);
                                                if ($row = sqlsrv_fetch_array($RS)) {
                                                    $COD_NEGOCIO_SEL = $row['COD_NEGOCIO'];
                                                    $DES_NEGOCIO = $row['DES_NEGOCIO'];
                                                    $ELNEGOCIO = $DES_NEGOCIO;
                                                }
                                                //OBTENER TIENDA
                                                $SQL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA IN(SELECT COD_TIENDA FROM US_USUTND WHERE IDUSU=".$SESIDUSU.")";
                                                $RS = sqlsrv_query($maestra, $SQL);
                                                //oci_execute($RS);
                                                if ($row = sqlsrv_fetch_array($RS)) {
                                                    $DES_CLAVE = $row['DES_CLAVE'];
                                                    $DES_CLAVE_F="0000".$DES_CLAVE;
                                                    $DES_CLAVE_F=substr($DES_CLAVE_F, -4); 
                                                    $DES_TIENDA = $row['DES_TIENDA'];
                                                    $LATIENDA = $DES_CLAVE_F." ".$DES_TIENDA;
                                                    $COD_TIENDA_SEL = $row['COD_TIENDA'];
                                                    //VERIFICAR QUE TIENDA SE ENCUENTRE REGISTRADA Y/O CON PRECIOS ARTS.AS_ITM_STR
                                                    $SQL1="SELECT COUNT(ID_BSN_UN) AS VERTND FROM PA_STR_RTL WHERE CD_STR_RT=".$DES_CLAVE;
                                                    $RS1 = sqlsrv_query($arts_conn, $SQL1);
                                                    //oci_execute($RS1);
                                                    if ($row1 = sqlsrv_fetch_array($RS1)) {
                                                        $VERTND_UNO = $row1['VERTND'];
                                                    }
                                                    $LATIENDA_SI = "Tienda: ".$DES_CLAVE_F." - ".$DES_TIENDA;
                                                    //OBTENER ID_BSN_UN
                                                    $SQL1="SELECT ID_BSN_UN FROM PA_STR_RTL WHERE CD_STR_RT=".$DES_CLAVE;
                                                    $RS1 = sqlsrv_query($arts_conn, $SQL1);
                                                    //oci_execute($RS1);
                                                    if ($row1 = sqlsrv_fetch_array($RS1)) {
                                                        $ID_BSN_UN_SEL = $row1['ID_BSN_UN'];
                                                    }
                                                }
                                                ?>
                                                    <h5><?=$ELNEGOCIO." ".$LATIENDA ?></h5>
                                                <?php
                                            }//if($CTATND==1)
                
                                            if($CTATND>1){//SELECCIONAR NEGOCIO (si es que hay más de uno) Y TIENDA
                                            $VERTND_UNO = 1;
                                            //CUENTA NEGOCIOS
                                                $SQL="SELECT COUNT(*) AS CTANEG FROM (SELECT COD_NEGOCIO FROM US_USUTND WHERE IDUSU=".$SESIDUSU." GROUP BY COD_NEGOCIO)";
                                                $RS = sqlsrv_query($maestra, $SQL);
                                                //oci_execute($RS);
                                                if ($row = sqlsrv_fetch_array($RS)) {
                                                    $CTANEG = $row['CTANEG'];
                                                }
                                            //SI CTANEG==1 DESPLEGAR SOLO LOCALES ASOCIADOS
                                                    //SI CTANEG>1 DESPLEGAR LISTADO NEGOCIOS Y LOCALES ASOCIADOS
                                                    if($CTANEG>1){//SELECCIONAR NEGOCIO Y TIENDAS ASOCIADAS
                                                            if(!empty($CD_ITM_SI) && !empty($COD_TIENDA_SEL) && !empty($COD_NEGOCIO_SEL)){
                                                                //OBTENER NEGOCIO
                                                                $SQL="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO =".$COD_NEGOCIO_SEL;
                                                                $RS = sqlsrv_query($maestra, $SQL);
                                                                //oci_execute($RS);
                                                                if ($row = sqlsrv_fetch_array($RS)) {
                                                                    $COD_NEGOCIO_SEL = $row['COD_NEGOCIO'];
                                                                    $DES_NEGOCIO = $row['DES_NEGOCIO'];
                                                                    $ELNEGOCIO = $DES_NEGOCIO;
                                                                }
                                                                //OBTENER NEGOCIO
                                                                $SQL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA =".$COD_TIENDA_SEL;
                                                                $RS = sqlsrv_query($maestra, $SQL);
                                                                //oci_execute($RS);
                                                                if ($row = sqlsrv_fetch_array($RS)) {
                                                                    $DES_CLAVE = $row['DES_CLAVE'];
                                                                    $DES_CLAVE_F="0000".$DES_CLAVE;
                                                                    $DES_CLAVE_F=substr($DES_CLAVE_F, -4); 
                                                                    $DES_TIENDA = $row['DES_TIENDA'];
                                                                    $LATIENDA = $DES_CLAVE_F." ".$DES_TIENDA;
                                                                    $COD_TIENDA_SEL = $row['COD_TIENDA'];
                                                                }
                                                                ?>
                                                                    <h5><?=$ELNEGOCIO." ".$LATIENDA ?></h5>
                                                                    <input type="hidden" name="COD_NEGOCIO" value="<?=$COD_NEGOCIO_SEL?>">
                                                                    <input type="hidden" name="COD_TIENDA" value="<?=$COD_TIENDA_SEL?>">
                                                                <?php
                                                            } else {
                                                                ?>
                                                                    <select name="COD_NEGOCIO" onChange="CargaTiendaSelect(this.value, this.form.name, 'COD_TIENDA', <?=$SESIDUSU?>);">
                                                                                <option value="0">SELECCIONAR NEGOCIO</option>
                                                                                <?php 
                                                                                $SQL="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO IN(SELECT COD_NEGOCIO FROM US_USUTND WHERE IDUSU=".$SESIDUSU.") ORDER BY DES_NEGOCIO ASC";
                                                                                $RS = sqlsrv_query($maestra, $SQL);
                                                                                //oci_execute($RS);
                                                                                while ($row = sqlsrv_fetch_array($RS)) {
                                                                                    $COD_NEGOCIO = $row['COD_NEGOCIO'];
                                                                                    $DES_NEGOCIO = $row['DES_NEGOCIO'];
                                                                                 ?>
                                                                                <option value="<?=$COD_NEGOCIO ?>" <?php if($COD_NEGOCIO==$COD_NEGOCIO_SEL) {echo "Selected";} ?>><?=$DES_NEGOCIO ?></option>
                                                                                <?php 
                                                                                }
                                                                                 ?>
                                                                </select>
                                                                <select  id="COD_TIENDA" name="COD_TIENDA" onChange="document.forms.forming.submit();">
                                                                    <option value="0">SELECCIONAR TIENDA</option>
                                                                    <?php
                                                                    if(!empty($COD_TIENDA_SEL)){
                                                                                $SQL="SELECT COD_TIENDA, DES_TIENDA, DES_CLAVE FROM MN_TIENDA WHERE COD_TIENDA IN(SELECT COD_TIENDA FROM US_USUTND WHERE IDUSU=".$SESIDUSU." AND COD_NEGOCIO=".$COD_NEGOCIO_SEL.") ORDER BY DES_CLAVE ASC";
                                                                                $RS = sqlsrv_query($maestra, $SQL);
                                                                                //oci_execute($RS);
                                                                                while ($row = sqlsrv_fetch_array($RS)) {
                                                                                    $NUM_TIENDA = $row['DES_CLAVE'];
                                                                                    $NUM_TIENDA_F="0000".$NUM_TIENDA;
                                                                                    $NUM_TIENDA_F=substr($NUM_TIENDA_F, -4); 
                                                                                    $STRDES = $row['DES_TIENDA'];
                                                                                    $STRCOD =$row['COD_TIENDA'];		
                                                                                    //VERIFICAR QUE TIENDA SE ENCUENTRE REGISTRADA Y/O CON PRECIOS ARTS.AS_ITM_STR
                                                                                    $SQL1="SELECT COUNT(ID_BSN_UN) AS VERTND FROM PA_STR_RTL WHERE CD_STR_RT=".$NUM_TIENDA;
                                                                                    $RS1 = sqlsrv_query($arts_conn, $SQL1);
                                                                                    //oci_execute($RS1);
                                                                                    if ($row1 = sqlsrv_fetch_array($RS1)) {
                                                                                        $VERTND = $row1['VERTND'];
                                                                                    }
                                                                                    if($VERTND != 0){
                                                                                     ?>
                                                                                    <option value="<?=$STRCOD ?>" <?php if($STRCOD==$COD_TIENDA_SEL) {echo "Selected";} ?>><?=$NUM_TIENDA_F." - ".$STRDES ?></option>
                                                                                    <?php 
                                                                                    }
                                                                                }
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <?php
                                                            }//!empty($CD_ITM_SI) && !empty($COD_TIENDA_SEL)
                                                    }//$CTANEG>1
                                                    if($CTANEG==1){//SELECCIONAR TIENDAS ASOCIADAS
                                                            if(!empty($CD_ITM_SI) && !empty($COD_TIENDA_SEL) && !empty($COD_NEGOCIO_SEL)){
                                                                $SQL="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO =".$COD_NEGOCIO_SEL;
                                                                $RS = sqlsrv_query($maestra, $SQL);
                                                                //oci_execute($RS);
                                                                if ($row = sqlsrv_fetch_array($RS)) {
                                                                    $COD_NEGOCIO_SEL = $row['COD_NEGOCIO'];
                                                                    $DES_NEGOCIO = $row['DES_NEGOCIO'];
                                                                    $ELNEGOCIO = $DES_NEGOCIO;
                                                                }
                                                                $SQL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA =".$COD_TIENDA_SEL;
                                                                $RS = sqlsrv_query($maestra, $SQL);
                                                                //oci_execute($RS);
                                                                if ($row = sqlsrv_fetch_array($RS)) {
                                                                    $DES_CLAVE = $row['DES_CLAVE'];
                                                                    $DES_CLAVE_F="0000".$DES_CLAVE;
                                                                    $DES_CLAVE_F=substr($DES_CLAVE_F, -4); 
                                                                    $DES_TIENDA = $row['DES_TIENDA'];
                                                                    $LATIENDA = $DES_CLAVE_F." ".$DES_TIENDA;
                                                                    $COD_TIENDA_SEL = $row['COD_TIENDA'];
                                                                }
                                                                ?>
                                                                    <h5><?=$ELNEGOCIO." ".$LATIENDA ?></h5>
                                                                    <input type="hidden" name="COD_NEGOCIO" value="<?=$COD_NEGOCIO_SEL?>">
                                                                    <input type="hidden" name="COD_TIENDA" value="<?=$COD_TIENDA_SEL?>">
                                                                <?php
                                                            } else {

                                                                //OBTENER NEGOCIO
                                                                $SQL1="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO IN(SELECT COD_NEGOCIO FROM US_USUTND WHERE IDUSU=".$SESIDUSU.") ";
                                                                $RS1 = sqlsrv_query($maestra, $SQL1);
                                                                //oci_execute($RS1);
                                                                if ($row1 = sqlsrv_fetch_array($RS1)) {
                                                                    $COD_NEGOCIO_TND = $row1['COD_NEGOCIO'];
                                                                }
                                                        ?>
                                                                    <input type="hidden" name="COD_NEGOCIO" value="<?=$COD_NEGOCIO_TND?>">
                                                                    <select name="COD_TIENDA" onChange="document.forms.forming.submit();">
                                                                                <option value="0">SELECCIONAR TIENDA</option>
                                                                                <?php 
                                                                                $SQL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA IN(SELECT COD_TIENDA FROM US_USUTND WHERE IDUSU=".$SESIDUSU." AND COD_NEGOCIO=".$COD_NEGOCIO_TND.") ORDER BY DES_CLAVE ASC";
                                                                                $RS = sqlsrv_query($maestra, $SQL);
                                                                                //oci_execute($RS);
                                                                                while ($row = sqlsrv_fetch_array($RS)) {
                                                                                        $COD_TIENDA = $row['COD_TIENDA'];
                                                                                        $DES_CLAVE = $row['DES_CLAVE'];
                                                                                        $DES_CLAVE_F="0000".$DES_CLAVE;
                                                                                        $DES_CLAVE_F=substr($DES_CLAVE_F, -4); 
                                                                                        $DES_TIENDA = $row['DES_TIENDA'];
                                                                                        $LATIENDA = $DES_CLAVE_F." ".$DES_TIENDA;
                                                                                            //VERIFICAR QUE TIENDA SE ENCUENTRE REGISTRADA Y/O CON PRECIOS ARTS.AS_ITM_STR
                                                                                            $SQL1="SELECT COUNT(ID_BSN_UN) AS VERTND FROM PA_STR_RTL WHERE CD_STR_RT=".$DES_CLAVE;
                                                                                            $RS1 = sqlsrv_query($arts_conn, $SQL1);
                                                                                            //oci_execute($RS1);
                                                                                            if ($row1 = sqlsrv_fetch_array($RS1)) {
                                                                                                $VERTND = $row1['VERTND'];
                                                                                            }
                                                                                        if($VERTND != 0){
                                                                                             ?>
                                                                                            <option value="<?=$COD_TIENDA ?>"  <?php if($COD_TIENDA==$COD_TIENDA_SEL) {echo "Selected";} ?>><?=$LATIENDA ?></option>
                                                                                            <?php 
                                                                                        }
                                                                                }
                                                                                 ?>
                                                                </select>
                                                        <?php
                                                        }//!empty($CD_ITM_SI) && !empty($COD_TIENDA_SEL)
                                                    }//$CTANEG==1
                                            }//$CTATND==0)
                
                
                                            if($CTATND==0){//SELECCIONAR NEGOCIO Y TIENDA
                                                    if(!empty($CD_ITM_SI) && !empty($COD_TIENDA_SEL) && !empty($COD_NEGOCIO_SEL)){
                                                                $SQL="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO =".$COD_NEGOCIO_SEL;
                                                                $RS = sqlsrv_query($maestra, $SQL);
                                                                //oci_execute($RS);
                                                                if ($row = sqlsrv_fetch_array($RS)) {
                                                                    $COD_NEGOCIO_SEL = $row['COD_NEGOCIO'];
                                                                    $DES_NEGOCIO = $row['DES_NEGOCIO'];
                                                                    $ELNEGOCIO = $DES_NEGOCIO;
                                                                }
                                                                $SQL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA =".$COD_TIENDA_SEL;
                                                                $RS = sqlsrv_query($maestra, $SQL);
                                                                //oci_execute($RS);
                                                                if ($row = sqlsrv_fetch_array($RS)) {
                                                                    $DES_CLAVE = $row['DES_CLAVE'];
                                                                    $DES_CLAVE_F="0000".$DES_CLAVE;
                                                                    $DES_CLAVE_F=substr($DES_CLAVE_F, -4); 
                                                                    $DES_TIENDA = $row['DES_TIENDA'];
                                                                    $LATIENDA = $DES_CLAVE_F." ".$DES_TIENDA;
                                                                    $COD_TIENDA_SEL = $row['COD_TIENDA'];
                                                                }
                                                                ?>
                                                                    <h5><?=$ELNEGOCIO." ".$LATIENDA ?></h5>
                                                                    <input type="hidden" name="COD_NEGOCIO" value="<?=$COD_NEGOCIO_SEL?>">
                                                                    <input type="hidden" name="COD_TIENDA" value="<?=$COD_TIENDA_SEL?>">
                                                        <?php
                                                    } else {
                                                        ?>
                                                                    <select name="COD_NEGOCIO" onChange="CargaTiendaSelectE(this.value, this.form.name, 'COD_TIENDA');">
                                                                                <option value="0">SELECCIONAR NEGOCIO</option>
                                                                                <?php 
                                                                                $SQL="SELECT * FROM MN_NEGOCIO ORDER BY DES_NEGOCIO ASC";
                                                                                $RS = sqlsrv_query($maestra, $SQL);
                                                                                //oci_execute($RS);
                                                                                while ($row = sqlsrv_fetch_array($RS)) {
                                                                                    $COD_NEGOCIO = $row['COD_NEGOCIO'];
                                                                                    $DES_NEGOCIO = $row['DES_NEGOCIO'];
                                                                                 ?>
                                                                                <option value="<?=$COD_NEGOCIO ?>" <?php if($COD_NEGOCIO==$COD_NEGOCIO_SEL) {echo "Selected";} ?>><?=$DES_NEGOCIO ?></option>
                                                                                <?php 
                                                                                }
                                                                                 ?>
                                                                </select>
                                                                <select id="COD_TIENDA" name="COD_TIENDA" onChange="document.forms.forming.submit();">
                                                                    <option value="0">SELECCIONAR TIENDA</option>
                                                                    <?php
                                                                    if(!empty($COD_TIENDA_SEL)){
                                                                                $SQL="SELECT COD_TIENDA, DES_TIENDA, DES_CLAVE FROM MN_TIENDA WHERE COD_TIENDA IN(SELECT COD_TIENDA FROM MN_NEGTND WHERE COD_NEGOCIO=".$COD_NEGOCIO_SEL.")   ORDER BY DES_CLAVE ASC";
                                                                                $RS = sqlsrv_query($maestra, $SQL);
                                                                                //oci_execute($RS);
                                                                                $VERTND=0;
                                                                                while ($row = sqlsrv_fetch_array($RS)) {
                                                                                    $NUM_TIENDA = $row['DES_CLAVE'];
                                                                                    $NUM_TIENDA_F="0000".$NUM_TIENDA;
                                                                                    $NUM_TIENDA_F=substr($NUM_TIENDA_F, -4); 
                                                                                    $STRDES = $row['DES_TIENDA'];
                                                                                    $STRCOD =$row['COD_TIENDA'];
                                                                                    //VERIFICAR QUE TIENDA SE ENCUENTRE REGISTRADA Y/O CON PRECIOS ARTS.AS_ITM_STR
                                                                                    $SQL1="SELECT COUNT(ID_BSN_UN) AS VERTND FROM PA_STR_RTL WHERE CD_STR_RT=".$NUM_TIENDA;
                                                                                    $RS1 = sqlsrv_query($arts_conn, $SQL1);
                                                                                    //oci_execute($RS1);
                                                                                    if ($row1 = sqlsrv_fetch_array($RS1)) {
                                                                                        $VERTND = $row1['VERTND'];
                                                                                    }
                                                                                if($VERTND != 0){
                                                                                 ?>
                                                                                        <option value="<?=$STRCOD ?>" <?php if($STRCOD==$COD_TIENDA_SEL) {echo "Selected";} ?> ><?=$NUM_TIENDA_F." - ".$STRDES ?></option>
                                                                                <?php 
                                                                                }
                                                                                }
                                                                    }
                                                                    ?>
                                                                </select>
                                                        <?php
                                                    }//!empty($CD_ITM_SI) && !empty($COD_TIENDA_SEL)
                                            }//if($CTATND==0)
                
                
                
                                        ?>

                      <label style="clear:left" for="FECHA_EM_D">Desde </label>
                      <input name="DIA_NCED" type="text" id="DIA_NCED" value="<?=$DIA_NCED ?>" size="2" maxlength="2" onKeyPress="return acceptNum(event);">
                     <select name="MES_NCED"  id="MES_NCED">
                            <option value="01" <?php  if ($MES_NCED==1) { echo "SELECTED";}?>>Enero</option>
                            <option value="02" <?php  if ($MES_NCED==2) { echo "SELECTED";}?>>Febrero</option>
                            <option value="03" <?php  if ($MES_NCED==3) { echo "SELECTED";}?>>Marzo</option>
                            <option value="04" <?php  if ($MES_NCED==4) { echo "SELECTED";}?>>Abril</option>
                            <option value="05" <?php  if ($MES_NCED==5) { echo "SELECTED";}?>>Mayo</option>
                            <option value="06" <?php  if ($MES_NCED==6) { echo "SELECTED";}?>>Junio</option>
                            <option value="07" <?php  if ($MES_NCED==7) { echo "SELECTED";}?>>Julio</option>
                            <option value="08" <?php  if ($MES_NCED==8) { echo "SELECTED";}?>>Agosto</option>
                            <option value="09" <?php  if ($MES_NCED==9) { echo "SELECTED";}?>>Septiembre</option>
                            <option value="10" <?php  if ($MES_NCED==10) { echo "SELECTED";}?>>Octubre</option>
                            <option value="11" <?php  if ($MES_NCED==11) { echo "SELECTED";}?>>Noviembre</option>
                            <option value="12" <?php  if ($MES_NCED==12) { echo "SELECTED";}?>>Diciembre</option>
                       </select>
                       <input name="ANO_NCED" type="text"  id="ANO_NCED" value="<?=$ANO_NCED ?>" size="4" maxlength="4">
                      <label for="FECHA_EM_H" >Hasta</label>
                      <input name="DIA_NCEH" type="text" id="DIA_NCEH" value="<?=$DIA_NCEH ?>" size="2" maxlength="2" onKeyPress="return acceptNum(event);">
                      <select name="MES_NCEH"  id="MES_NCEH">
                            <option value="01" <?php  if ($MES_NCEH==1) { echo "SELECTED";}?>>Enero</option>
                            <option value="02" <?php  if ($MES_NCEH==2) { echo "SELECTED";}?>>Febrero</option>
                            <option value="03" <?php  if ($MES_NCEH==3) { echo "SELECTED";}?>>Marzo</option>
                            <option value="04" <?php  if ($MES_NCEH==4) { echo "SELECTED";}?>>Abril</option>
                            <option value="05" <?php  if ($MES_NCEH==5) { echo "SELECTED";}?>>Mayo</option>
                            <option value="06" <?php  if ($MES_NCEH==6) { echo "SELECTED";}?>>Junio</option>
                            <option value="07" <?php  if ($MES_NCEH==7) { echo "SELECTED";}?>>Julio</option>
                            <option value="08" <?php  if ($MES_NCEH==8) { echo "SELECTED";}?>>Agosto</option>
                            <option value="09" <?php  if ($MES_NCEH==9) { echo "SELECTED";}?>>Septiembre</option>
                            <option value="10" <?php  if ($MES_NCEH==10) { echo "SELECTED";}?>>Octubre</option>
                            <option value="11" <?php  if ($MES_NCEH==11) { echo "SELECTED";}?>>Noviembre</option>
                            <option value="12" <?php  if ($MES_NCEH==12) { echo "SELECTED";}?>>Diciembre</option>
                        </select>
                        <input name="ANO_NCEH" type="text"  id="ANO_NCEH" value="<?=$ANO_NCEH ?>" size="4" maxlength="4" onKeyPress="return acceptNum(event);">
					
                        <select style="clear:left" name="B_TIPOD" onChange="document.forms.forming.submit();">
                            <option value="0">Tipo Devoluci&oacute;n</option>
                            <?php 
                            $SQLFILTRO="SELECT * FROM DV_TIPOD WHERE ID_TIPOD IN(SELECT ID_TIPOD FROM DV_TICKET) ORDER BY ID_TIPOD ASC";
                            $RSF = sqlsrv_query($conn, $SQLFILTRO);
                            //oci_execute($RSF);
                            while ($rowF = sqlsrv_fetch_array($RSF)) {
                                $FLTID_TIPOD = $rowF['ID_TIPOD'];
                                $FLTNM_TIPOD = $rowF['NM_TIPOD'];
                             ?>
                            <option value="<?=$FLTID_TIPOD ?>" <?php  if ($FLTID_TIPOD==$B_TIPOD) { echo "SELECTED";}?>><?=$FLTNM_TIPOD ?></option>
                            <?php 
                            }
                             ?>
                        </select>

                        <input style="clear:none; text-align:right" name="B_NNDC" type="text"  id="B_NNDC" value="<?=$B_NNDC ?>" size="9" maxlength="9" onKeyPress="return acceptNum(event);">
                       <input name="BSC_NDC" type="submit" id="BSC_NDC" value="Buscar Nota de Cr&eacute;dito">
                       <input name="LIMPIAR" type="button" id="LIMPIAR" value="Limpiar" onClick="pagina('reg_devols.php');">
              </td>
              </tr>
            </form>
              </table>
              <!-- FIN FILTRO, INICIO LISTADO -->
              
                <table style="margin:10px 20px; ">
                <tr>
                <td>
                    <?php if(!empty($BSC_NDC)) { //INICIO RESULTADO BUSCAR ?>
					<?php
                     //FORMATO DE FECHA               
					//$SQL="ALTER SESSION SET nls_date_format='DD-MM-YYYY HH24:MI:SS'";
					//$RS = sqlsrv_query($conn, $SQL);
					//oci_execute($RS);
					//CUENTA REGISTROS
					$CONSULTA="SELECT COUNT(*) AS CUENTA FROM DV_TICKET ".$FNC_FECHA.$FILTRO_TIENDANC.$FILTRO_TIPONC.$FILTRO_NC;
					

					$RS = sqlsrv_query($conn, $CONSULTA);
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
					if($TOTALREG>=1){ //ENCONTRO AL MENOS UNO
					//CONSULTA RESULTADO BÚSQUEDA
					//$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM DV_TICKET ".$FNC_FECHA.$FILTRO_TIENDANC.$FILTRO_TIPONC.$FILTRO_NC." ORDER BY ID_DEVS  DESC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;

					$CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY ID_DEVS DESC) ROWNUMBER FROM DV_TICKET  ".$FNC_FECHA.$FILTRO_TIENDANC.$FILTRO_TIPONC.$FILTRO_NC.") AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP." ";

					

					$RS = sqlsrv_query($conn, $CONSULTA);
					//oci_execute($RS);
				   ?>
                    <table id="Listado">
                    <tr>
                        <th colspan="2" style="padding-left: 36px">NDC</th>
                        <th>Local</th>
                        <th style="text-align:right">Ticket/Factura</th>
                        <th style="text-align:right">Monto</th>
                        <th style="text-align:right">&Iacute;tems</th>
                        <th>Tipo</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                    </tr>
                    <?php
					$NUM_ARTS=0;
                    while ($row = sqlsrv_fetch_array($RS)){
						$ID_DEVS = $row['ID_DEVS'];
						$ID_TRN = $row['ID_TRN'];
						$FECHA_REG = $row['FECHA_REG'];
						$FECHA_ACT = $row['FECHA_ACT'];
						$ID_BSN_UN = $row['ID_BSN_UN'];
						$ID_TIPOD = $row['ID_TIPOD'];
						
	
								$TIENDA="NR";
								$S2="SELECT DE_STR_RT, CD_STR_RT FROM PA_STR_RTL WHERE ID_BSN_UN=".$ID_BSN_UN;
								$RS2 = sqlsrv_query($arts_conn, $S2);
								//oci_execute($RS2);
								if ($row2 = sqlsrv_fetch_array($RS2)) {
									$CODTIENDA = $row2['CD_STR_RT'];
									$CODTIENDA="0000".$CODTIENDA;
									$CODTIENDA=substr($CODTIENDA, -4); //BIN 
								}	

								$S2="SELECT AI_TRN FROM TR_TRN WHERE ID_TRN=".$ID_TRN;

								$RS2 = sqlsrv_query($arts_conn, $S2);
								//oci_execute($RS2);
								if ($row2 = sqlsrv_fetch_array($RS2)) {
									$NUM_TICKET = $row2['AI_TRN'];
								}	

							 if($ID_TIPOD==3){
										$SQLF="SELECT * FROM TR_INVC WHERE ID_TRN=".$ID_TRN;
										$RSF = sqlsrv_query($arts_conn, $SQLF);
										//oci_execute($RSF);
										if ($rowf = sqlsrv_fetch_array($RSF)) {
											$INVC_NMB = $rowf['INVC_NMB'];
											$ID_CPR = $rowf['ID_CPR'];
											$FL_CP = $rowf['FL_CP'];
										}
							 } else {
										$SQLC="SELECT * FROM DV_DEVCLTE WHERE ID_DEVS=".$ID_DEVS;
										$RSC= sqlsrv_query($conn, $SQLC);
										//oci_execute($RSC);
										if ($rowC = sqlsrv_fetch_array($RSC)) {
											$ID_CPR = $rowC['ID_CPR'];
											$TY_CPR = $rowC['TY_CPR'];
											if($TY_CPR!="P"){ $FL_CP=0; } else { $FL_CP=1; }
										}
							 }
							 
							 if($FL_CP==0){
									$SQLC="SELECT * FROM CO_CPR_CER WHERE ID_CPR=".$ID_CPR;
									$RSC= sqlsrv_query($arts_conn, $SQLC);
									//oci_execute($RSC);
									if ($row1 = sqlsrv_fetch_array($RSC)) {
										$IDENTIFICACION = $row1['CD_CPR'];
										$NOMBRE = $row1['NOMBRE'];
										$DIRECCION = $row1['DIRECCION'];
										$COD_REGION = $row1['COD_REGION'];
										$COD_CIUDAD = $row1['COD_CIUDAD'];
												$SQL2="SELECT DES_CIUDAD FROM PM_CIUDAD WHERE COD_CIUDAD=".$COD_CIUDAD;
												$RS2 = sqlsrv_query($maestra, $SQL2);
												//oci_execute($RS2);
												if ($row2 = sqlsrv_fetch_array($RS2)) {
													$DES_CIUDAD = ", ".strtoupper($row2['DES_CIUDAD']);
												}
												$SQL2="SELECT DES_REGION, ABR_REGION FROM PM_REGION WHERE COD_REGION=".$COD_REGION;
												$RS2 = sqlsrv_query($maestra, $SQL2);
												//oci_execute($RS2);
												if ($row2 = sqlsrv_fetch_array($RS2)) {
													$DES_REGION = $row2['DES_REGION'];
													$ABR_REGION = $row2['ABR_REGION'];
													if(!empty($ABR_REGION)){$DES_REGION = $DES_REGION." (".$ABR_REGION.")";}
												} else {
													$DES_REGION = "";
												}
										$TELEFONO = $row1['TELEFONO'];
										$CORREO = strtolower($row1['CORREO']);
										if($TY_CPR=="C"){$CPR_TY = "C.I. No. ";}
										if($TY_CPR=="R"){$CPR_TY = "R.U.C. ";}
									}
							} else {
									$SQLC="SELECT * FROM CO_EXT_CER WHERE ID_CPR=".$ID_CPR;
									$RSC= sqlsrv_query($arts_conn, $SQLC);
									//oci_execute($RSC);
									if ($row2 = sqlsrv_fetch_array($RSC)) {
										$IDENTIFICACION = $row2['CD_CPR'];
										$NOMBRE = $row2['NOMBRE'];
										$DIRECCION = $row2['DIRECCION'];
										$NACIONALIDAD = $row2['NACIONALIDAD'];
										$TELEFONO = $row2['TELEFONO'];
										$CORREO = strtolower($row2['CORREO']);
										$CPR_TY = "Pasaporte: ";
									}
							}
	
								$SITM="SELECT COUNT(ID_ITM) AS CTAITMS FROM DV_ARTS WHERE ID_DEVS=".$ID_DEVS;
								$RSITM = sqlsrv_query($conn, $SITM);
								//oci_execute($RSITM);
								if ($rowITM = sqlsrv_fetch_array($RSITM)) {
									$CTAITMS = $rowITM['CTAITMS'];
								}

								$S2="SELECT * FROM DV_TIPOD WHERE ID_TIPOD=".$ID_TIPOD;
								$RS2 = sqlsrv_query($conn, $S2);
								//oci_execute($RS2);
								if ($row2 = sqlsrv_fetch_array($RS2)) {
									$NM_TIPOD = $row2['NM_TIPOD'];
								}
								if($ID_TIPOD==1){ //GIFTCARD
									$S2="SELECT * FROM DV_GFCD WHERE ID_DEVS=".$ID_DEVS;
									$RS2 = sqlsrv_query($conn, $S2);
									//oci_execute($RS2);
									if ($row2 = sqlsrv_fetch_array($RS2)) {
										$MONTO_NC = $row2['MONTO'];
										$ESTADO_NC = $row2['ESTADO'];
										$NM_TIPOD = $NM_TIPOD;
										if($ESTADO_NC==1){
											$EL_ESTADONC="ACTIVADA";
											$COLOR_ENC="#4CAF50";
										} else {
											$EL_ESTADONC="NO ACTIVADA";
											$COLOR_ENC="#F44336";
										}
									}
								}
								if($ID_TIPOD==2){ //EFECTIVO
									$S2="SELECT * FROM DV_EFEC WHERE ID_DEVS=".$ID_DEVS;
									$RS2 = sqlsrv_query($conn, $S2);
									//oci_execute($RS2);
									if ($row2 = sqlsrv_fetch_array($RS2)) {
										$MONTO_NC = $row2['MONTO'];
										$ID_WS = $row2['ID_WS'];
												$S3="SELECT CD_WS FROM AS_WS WHERE ID_WS=".$ID_WS;
												$RS3 = sqlsrv_query($arts_conn, $S3);
												//oci_execute($RS3);
												if ($row3 = sqlsrv_fetch_array($RS3)) {
													$ASOC_NC = $row3['CD_WS'];
												}	
										$ESTADO_NC = $row2['ESTADO'];
										$NM_TIPOD = $NM_TIPOD;
										if($ESTADO_NC==0){
											$EL_ESTADONC="POR CONFIRMAR";
											$COLOR_ENC="#FF9800";
										}
										if($ESTADO_NC==1){
											$EL_ESTADONC="SIN PROCESAR";
											$COLOR_ENC="#9E9E9E";
										}
										if($ESTADO_NC==2){
											$EL_ESTADONC="EN COBRO POS ".$ASOC_NC;
											$COLOR_ENC="#F44336";
										}
										if($ESTADO_NC==3){
											$EL_ESTADONC="PAGADO";
											$COLOR_ENC="#4CAF50";
										}
									}
								}
								if($ID_TIPOD==3){ //FACTURA
									$S2="SELECT * FROM DV_FACT WHERE ID_DEVS=".$ID_DEVS;
									$RS2 = sqlsrv_query($conn, $S2);
									//oci_execute($RS2);
									if ($row2 = sqlsrv_fetch_array($RS2)) {
										$MONTO_NC = $row2['MONTO'];
										$ID_WS = $row2['ID_WS'];
												$S3="SELECT CD_WS FROM AS_WS WHERE ID_WS=".$ID_WS;
												$RS3 = sqlsrv_query($arts_conn, $S3);
												//oci_execute($RS3);
												if ($row3 = sqlsrv_fetch_array($RS3)) {
													$ASOC_NC = $row3['CD_WS'];
												}	
										$ESTADO_NC = $row2['ESTADO'];
										$NM_TIPOD = $NM_TIPOD;
										if($ESTADO_NC==2){
											$EL_ESTADONC="ESPERA EN POS ".$ASOC_NC;
											$COLOR_ENC="#F44336";
										}
										if($ESTADO_NC==3){
											$EL_ESTADONC="EJECUTADO";
											$COLOR_ENC="#4CAF50";
										}
									}
								}
						$MONTO_NC=$MONTO_NC/$DIVCENTS;
						$MONTO_NC=number_format($MONTO_NC, $CENTS, $GLBSDEC, $GLBSMIL);
                   ?>
					<script>
                    function Ocultar<?=$ID_DEVS?>(){
                        var mostrar = document.getElementById("mostrar<?=$ID_DEVS?>");
                        var ocultar = document.getElementById("ocultar<?=$ID_DEVS?>");
                        var ver = document.getElementById("ver<?=$ID_DEVS?>");
                        var TcktO = document.getElementById("TcktO<?=$ID_DEVS?>");
                        var TcktM = document.getElementById("TcktM<?=$ID_DEVS?>");
                            mostrar.style.display = "table-cell";
                            ocultar.style.display = "none";
                            ver.style.display = "none";
                            TcktO.style.display = "none";
                            TcktM.style.display = "table-cell";
							for(j=1; j <= 7; j = j+1) {
								var TRN = document.getElementById("TRN"+j+"<?=$ID_DEVS?>");
										TRN.className = "tdShow";
										TRN.style.color = "#333";
										TRN.style.background = "#F1F1F1";
							}
                    }
					
                    function Mostrar<?=$ID_DEVS?>(){
                        var mostrar = document.getElementById("mostrar<?=$ID_DEVS?>");
                        var ocultar = document.getElementById("ocultar<?=$ID_DEVS?>");
                        var ver = document.getElementById("ver<?=$ID_DEVS?>");
                        var TcktO = document.getElementById("TcktO<?=$ID_DEVS?>");
                        var TcktM = document.getElementById("TcktM<?=$ID_DEVS?>");
                            mostrar.style.display = "none";
                            ocultar.style.display = "table-cell";
                            TcktO.style.display = "table-cell";
                            TcktM.style.display = "none";
                            ver.style.display = "table-row";
							for(j=1; j <= 7; j = j+1) {
								var TRN = document.getElementById("TRN"+j+"<?=$ID_DEVS?>");
									TRN.className = "tdHide";
									TRN.style.color = "#FFFFFF";
									TRN.style.background = "#8B44AA";
							}
					}
                    </script>
                    <tr>


                        <td class="tdShow" id="mostrar<?=$ID_DEVS?>" onClick="Mostrar<?=$ID_DEVS?>();"><img src="../images/ICO_ShowM.png"></td>
                        <td style="display:none" class="tdHide" id="ocultar<?=$ID_DEVS?>" onClick="Ocultar<?=$ID_DEVS?>();"><img src="../images/ICO_ShowB.png"></td>

                        <td id="TcktM<?=$ID_DEVS ?>" class="tdShow" style="text-align:right; font-size:14pt; cursor:pointer" onClick="pagina('reg_devols.php?VDNC=<?=$ID_DEVS?>');"><?=$ID_DEVS?></td>
                        <td id="TcktO<?=$ID_DEVS ?>" class="tdHide" style="display:none; text-align:right; font-size:14pt; cursor:pointer" onClick="pagina('reg_devols.php?VDNC=<?=$ID_DEVS?>');"><?=$ID_DEVS?></td>

                        <td id="TRN1<?=$ID_DEVS ?>" style="text-align:left; vertical-align:middle"><?=$CODTIENDA?></td>
                        <td id="TRN2<?=$ID_DEVS ?>"  style="text-align:right; vertical-align:middle"><?=@$NUM_TICKET?></td>
                        <td id="TRN3<?=$ID_DEVS ?>"  style="text-align:right; vertical-align:middle"><?=$MONEDA.$MONTO_NC?></td>
                        <td id="TRN4<?=$ID_DEVS ?>"  style="text-align:right; vertical-align:middle"><?=$CTAITMS?></td>
                        <td id="TRN5<?=$ID_DEVS ?>"  style="text-align:left; vertical-align:middle"><?=strtoupper($NM_TIPOD);?></td>
                        <td id="TRN6<?=$ID_DEVS ?>"  style="text-align:left; vertical-align:middle"><?=date_format($FECHA_REG,"d/m/Y")?></td>
                        <td style="background-color:<?=$COLOR_ENC?>; color:#FFF;vertical-align:middle"><?=$EL_ESTADONC?></td>
                    </tr>
							<?php if(!empty($B_NNDC)){?>
                            <tr id="ver<?=$ID_DEVS?>" style="display:table-row">
                            <?php } else {?>
                            <tr id="ver<?=$ID_DEVS?>" style="display:none">
                            <?php }?>
                                <td colspan="9" style="background-color:#FFF">
                                                <table id="Listado" style="width:100%">
													<?php if($ID_TIPOD==3){ ?>
                                                        <tr>
                                                            <th colspan="6">
                                                                <p style="font-size:12pt;">Factura N&deg; <?=$INVC_NMB;?></p>
                                                                <p>Nombre: <?=$NOMBRE;?>, <?=$CPR_TY;?> <?=$IDENTIFICACION;?></p>
                                                                <?php if($TY_CPR!="P"){ ?>
                                                                    <p>Direcci&oacute;n: <?=$DIRECCION.$DES_CIUDAD." ".$DES_REGION;?></p>
                                                                <?php } else { ?>
                                                                    <p>Nacionalidad: <?=$NACIONALIDAD;?></p>
                                                                    <p>Direcci&oacute;n: <?=$DIRECCION;?></p>
                                                                <?php } ?>
                                                                    <p>Tel&eacute;fono: <?=$TELEFONO;?>, e-mail: <?=$CORREO;?> </p>
                                                            </th>
                                                        </tr>
                                                    <?php } else {?>
                                                        <tr>
                                                            <th colspan="6">
                                                                <p>Nombre: <?=$NOMBRE;?>, <?=$CPR_TY;?> <?=$IDENTIFICACION;?></p>
                                                                <?php if($TY_CPR!="P"){ ?>
                                                                    <p>Direcci&oacute;n: <?=$DIRECCION.$DES_CIUDAD." ".$DES_REGION;?></p>
                                                                <?php } else { ?>
                                                                    <p>Nacionalidad: <?=$NACIONALIDAD;?></p>
                                                                    <p>Direcci&oacute;n: <?=$DIRECCION;?></p>
                                                                <?php } ?>
                                                                    <p>Tel&eacute;fono: <?=$TELEFONO;?>, e-mail: <?=$CORREO;?> </p>
                                                            </th>
                                                        </tr>
                                                    <?php } ?>
                                                        <tr>
                                                            <th style="text-align:right">It.</th>
                                                            <th>C&oacute;digo</th>
                                                            <th>Art&iacute;culo</th>
                                                            <th style="text-align:right">Prec. Unit.</th>
                                                            <th style="text-align:right">Cantidad</th>
                                                            <th style="text-align:right">Prec. Total</th>
                                                        </tr>
                                                        <?php
														$SQLi="SELECT * FROM DV_ARTS WHERE ID_DEVS=".$ID_DEVS." ORDER BY ID_ART ASC";
														$RSi= sqlsrv_query($conn, $SQLi);
														//oci_execute($RSi);
														$ITEM_NUM=1;
														$MONTO_TOT_DEV=0;
														while ($rowi = sqlsrv_fetch_array($RSi)) {
															$ID_ITM = $rowi['ID_ITM'];
															$TY_REGITM = $rowi['TY_REGITM'];
															
																		//CODIGO ITEM
																		$SQL1="SELECT * FROM ID_PS WHERE ID_ITM=".$ID_ITM;
																		$RS1= sqlsrv_query($arts_conn, $SQL1);
																		//oci_execute($RS1);
																		if ($row1 = sqlsrv_fetch_array($RS1)) {
																			$ID_ITM_PS =  $row1['ID_ITM_PS'];
																		}
																		//DATA ITEM
																		$SQL1="SELECT * FROM AS_ITM WHERE ID_ITM=".$ID_ITM;
																		$RS1= sqlsrv_query($arts_conn, $SQL1);
																		//oci_execute($RS1);
																		if ($row1 = sqlsrv_fetch_array($RS1)) {
																			$NM_ITM =  $row1['NM_ITM'];
																		}
						
															if($TY_REGITM!="P"){
																	$CANTIDAD=$rowi['QN_DEV'];
																	$CANTIDAD_F =$CANTIDAD ." c/u";
																	$TAX_DEV = $row['TAX_DEV'];
																	$MONTO_DEV = $rowi['MO_DEV']+$TAX_DEV;
																	$MONTO_TOT_DEV=$MONTO_TOT_DEV+$MONTO_DEV;
																	$PREC_UNIT = $MONTO_DEV/$CANTIDAD;
																	$MONTO_DEV=$MONTO_DEV/$DIVCENTS;
																	$PREC_UNIT=$PREC_UNIT/$DIVCENTS;
																	$MONTO_DEV_F=number_format($MONTO_DEV, $CENTS, $GLBSDEC, $GLBSMIL);
																	$PREC_UNIT_F=number_format($PREC_UNIT, $CENTS, $GLBSDEC, $GLBSMIL);
															} else {
																	$CANTIDAD = $rowi['QN_DEV'];
																	$CANTIDAD_F=$CANTIDAD/1000;
																	$CANTIDAD_F=number_format($CANTIDAD_F, 3, '.', ',');
																	$CANTIDAD_F=$CANTIDAD_F." Kg/Mt.";
																	$MONTO_DEV = $rowi['MO_DEV'];
																	$MONTO_TOT_DEV=$MONTO_TOT_DEV+$MONTO_DEV;
																	$PREC_UNIT = ($MONTO_DEV*1000)/$CANTIDAD;
																	$MONTO_DEV=$MONTO_DEV/$DIVCENTS;
																	$PREC_UNIT=$PREC_UNIT/$DIVCENTS;
																	$MONTO_DEV_F=number_format($MONTO_DEV, $CENTS, $GLBSDEC, $GLBSMIL);
																	$PREC_UNIT_F=number_format($PREC_UNIT, $CENTS, $GLBSDEC, $GLBSMIL);
														}
                                                        ?>
                                                        <tr>
                                                            <td style="text-align:right"><?=$ITEM_NUM;?></td>
                                                            <td><?=$ID_ITM_PS;?></td>
                                                            <td><?=$NM_ITM;?></td>
                                                            <td style="text-align:right"><?=$MONEDA.$PREC_UNIT_F;?></td>
                                                            <td style="text-align:right"><?=$CANTIDAD_F;?></td>
                                                            <td style="text-align:right"><?=$MONEDA.$MONTO_DEV_F;?></td>
                                                        </tr>
                                                        <?php
                                                        $ITEM_NUM=$ITEM_NUM+1;
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td colspan="5" style="font-weight:600; text-align:right">Total Devoluci&oacute;n</td>
                                                            <td style="font-weight:600; text-align:right">
                                                            <?php
                                                            $MONTO_TOT_DEV=$MONTO_TOT_DEV/$DIVCENTS;
															$MONTO_TOT_DEV=$MONTO_TOT_DEV+$TAX_TOT;
                                                            $MONTO_TOT_DEV_F=number_format($MONTO_TOT_DEV, $CENTS, $GLBSDEC, $GLBSMIL);
                                                            echo $MONEDA.$MONTO_TOT_DEV_F;
                                                            ?></td>
                                                        </tr>
                                                </table>               
                                </td>
                            </tr>
                    <?php
					$NUM_ARTS=0;
                    }
                    ?>
                    <?php if(empty($B_NNDC)){?>
                    <tr>
                        <td colspan="9" nowrap style="background-color:transparent">
                        <?php
                        if ($LINF>=$CTP+1) {
                            $ATRAS=$LINF-$CTP;
                            $FILA_ANT=$LSUP-$CTP;
                       ?>
                        <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('reg_devols.php?BSC_NDC=<?=$BSC_NDC ?>&LSUP=<?=$FILA_ANT?>&LINF=<?=$ATRAS?>&FTIENDA=<?=$FTIENDA?>&DIA_NCED=<?=$DIA_NCED ?>&MES_NCED=<?=$MES_NCED ?>&ANO_NCED=<?=$ANO_NCED ?>&DIA_NCEH=<?=$DIA_NCEH ?>&MES_NCEH=<?=$MES_NCEH ?>&ANO_NCEH=<?=$ANO_NCEH ?>&B_TICKET=<?=$B_TICKET ?>&B_TIPOD=<?=$B_TIPOD ?>&B_NNDC=<?=$B_NNDC ?>&B_CLTE=<?=$B_CLTE ?>');">
                        <?php
                        }
                        if ($LSUP<=$TOTALREG) {
                            $ADELANTE=$LSUP+1;
                            $FILA_POS=$LSUP+$CTP;
                       ?>
                        <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('reg_devols.php?BSC_NDC=<?=$BSC_NDC ?>&LSUP=<?=$FILA_POS?>&LINF=<?=$ADELANTE?>&FTIENDA=<?=$FTIENDA?>&DIA_NCED=<?=$DIA_NCED ?>&MES_NCED=<?=$MES_NCED ?>&ANO_NCED=<?=$ANO_NCED ?>&DIA_NCEH=<?=$DIA_NCEH ?>&MES_NCEH=<?=$MES_NCEH ?>&ANO_NCEH=<?=$ANO_NCEH ?>&B_TICKET=<?=$B_TICKET ?>&B_TIPOD=<?=$B_TIPOD ?>&B_NNDC=<?=$B_NNDC ?>&B_CLTE=<?=$B_CLTE ?>');">
                        <?php }?>
                        <span style="vertical-align:baseline;">P&aacute;gina <?=$NUMPAG?> de <?=$NUMTPAG?></span>
                        </td>
                    </tr>
                    <?php } //if(empty($B_NNDC))?>
                    </table>
                    <?php
					} else {
					?>
                    	<h4>No se registran coincidencias, por favor, intente nuevamente</h4>
                    <?php
					}//FIN ENCONTRO AL MENOS UNO
					sqlsrv_close($conn);
                    ?>
                    <?php } //FIN RESULTADO BUSCAR ?>
                    <!-- FIN RESULTADO BÚSQUEDA -->
                    
                   
                </td>
                </tr>
                </table>
		<?php } //FIN LISTADO ?>    
            
		<?php if($D_GFC<>"") { include("reg_devols_d_gfc.php"); }//FIN D_GFC ?> 
		<?php if($C_DEV<>"") { include("reg_devols_c_dev.php"); }//FIN C_DEV?>        
		<?php if($VER_DNC<>"") { include("reg_devols_nota.php"); }//FIN VER_DNC?>        
        
        </td>
        </tr>
        </table>
</td>
</tr>
</table>
        <iframe name="frmHIDEN" width="0" height="0" frameborder="0" align="top" src="" framespacing="0" marginheight="0" marginwidth="0">
        </iframe>
</body>
</html>

