<?php
include("session.inc");

$TIENDA = $_GET["COD_TIENDA"];
$OPPAGO_RUTA=$_GET["OPPAGO_RUTA"];


   $QUERY = "SELECT VAL_PARAM from PM_PARVAL WHERE ID_PARVAL = 147";
    $RSQ = sqlsrv_query($maestra, $QUERY);


    $RUTA = "C:/ALLC/WWW/allc_dat/in/update";
    
    $largo = strlen($RUTA);
    $pos = strpos($RUTA,'/');
    $DISCO = substr($RUTA,0,$pos);
    $RESTO = substr($RUTA,$pos+1,$largo);
   
    $largo2 = strlen($RESTO);
    $pos2 = strpos($RESTO,'/');
    $CARPETA2 = substr($RESTO,0,$pos2);
    $RESTO2 = substr($RESTO,$pos2+1,$largo2);
   
    $largo3 = strlen($RESTO2);
    $pos3 = strpos($RESTO2,'/');
    $CARPETA3 = substr($RESTO2,0,$pos3);
    $RESTO3 = substr($RESTO2,$pos3+1,$largo3);
    
    
    $largo4 = strlen($RESTO3);
    $pos4 = strpos($RESTO3,'/');
    $CARPETA4 = substr($RESTO3,0,$pos4);
    $RESTO4 = substr($RESTO3,$pos4+1,$largo4);
   
    $largo5 = strlen($RESTO4);
    $pos5 = strpos($RESTO4,'/');
    $CARPETA5 = substr($RESTO4,0,$pos5);
    $RESTO5 = substr($RESTO4,$pos5+1,$largo5);
    
    $largo6 = strlen($RESTO5);
    $pos6 = strpos($RESTO5,'/');
    $CARPETA6 = substr($RESTO5,0,$pos6);
    
    // RUTA BASE y CARPETA CONTENEDORA SIN TIENDA
    $CARPETA = substr($RESTO5,$pos6,$largo6);
    $RUTA =  $CARPETA4.'/'.$CARPETA5.'/'. $CARPETA6;
    


function Obtener_ip_()
{
	if (!empty($_SERVER['HTTP_CLIENT_IP']))
		return $_SERVER['HTTP_CLIENT_IP'];
	if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		return $_SERVER['HTTP_X_FORWARDED_FOR'];
	return $_SERVER['REMOTE_ADDR'];
}

function create_cmd($conn,$TIENDA,$OPPAGO_RUTA, $RUTA, $CARPETA){
        
        $TIENDA = "000" . $TIENDA;
        $TIENDA = substr($TIENDA, -3);
        $save = $OPPAGO_RUTA;
        if (file_exists('../../' . $RUTA . $TIENDA . '/' . $CARPETA . '/'))
	{
		$fps = fopen('../../' . $RUTA . $TIENDA . '/' . $CARPETA . '/OPCPAGO.CMD', 'w+');
		fwrite($fps, $save);
		fclose($fps);
		$fp_op = fopen('../../' . $RUTA . $TIENDA . '/' . $CARPETA . '/GSECYSUB.CMD', 'w+');
		fwrite($fp_op, $save);
		fclose($fp_op);
		return "Exportacion exitosa";
	}
	else
	{
		mkdir("../../" . $RUTA . $TIENDA . "/" . $CARPETA, 0777);
		$fps = fopen('../../' . $RUTA . $TIENDA . '/' . $CARPETA . '/OPCPAGO.CMD', 'w+');
		fwrite($fps, $save);
		fclose($fps);
		$fp_op = fopen('../../' . $RUTA . $TIENDA . '/' . $CARPETA . '/GSECYSUB.CMD', 'w+');
		fwrite($fp_op, $save);
		fclose($fp_op);
		return "Creacion de Carpetas y Exportacion exitosa";
	}   
}






function log_export($DES_CLAVE, $TIPO_ARCHIVO, $NOMBRE_ARCH, $conn)
{
	$IP_CLIENTE = Obtener_ip_();
	$FECHA      = date("d-m-Y");
	$HORA       = date("H:i:s");
	$ID_ARCEXPT = 1;
	$QUERY      = "SELECT MAX(ID_ARCEXPT) as MAXID FROM CO_BIN_ARCEXPT";
	$RS         = sqlsrv_query($conn, $QUERY);
	//oci_execute($RS);
	while ($row = sqlsrv_fetch_array($RS)) {
		$MAXID = $row['MAXID'];
		if (!isset($MAXID)) {
			$ID_ARCEXPT = 1;
		} else {
			$ID_ARCEXPT = ++$MAXID;
		}
	}
	$SQLOG = "INSERT INTO CO_BIN_ARCEXPT (ID_ARCEXPT,IP_CLIENTE,DES_CLAVE,FECHA,HORA,TIPO_ARCHIVO,NOMBRE_ARCH,COD_USUARIO) VALUES ";
	$SQLOG = $SQLOG . "(" . $ID_ARCEXPT . ",'" . $IP_CLIENTE . "'," . $DES_CLAVE . ",convert(datetime,GETDATE(), 121),'" . $HORA . "','" . $TIPO_ARCHIVO . "','" . $NOMBRE_ARCH . "'," . $_SESSION['ARMS_IDUSU'] . ")";
	$RSL   = sqlsrv_query($conn, $SQLOG);
	//oci_execute($RSL);
	return true;
}

function create_op($TIENDA, $guardar, $conn,$RUTA,$CARPETA)
{
	$FECSRV  = date("Ymd");
	$TIMESRV = date("His");
        
        $TIENDA = "000" . $TIENDA;
        $TIENDA = substr($TIENDA, -3);
        
	
        if (file_exists('../../'.$RUTA.$TIENDA.'/'.$CARPETA.'/') && file_exists('../../'.$RUTA.$TIENDA.'/bkp_op/')) {
              
                $fp = fopen('../../'.$RUTA.$TIENDA.'/'. $CARPETA . '/OPCPAGO.DAT', 'w+');
                fwrite($fp, $guardar);
                fclose($fp);
                $cp = fopen('../../'.$RUTA.$TIENDA.'/bkp_op/OPCPAGO' . '_' . $FECSRV . '_' . $TIMESRV . '.DAT', 'w+');
                fwrite($cp, $guardar);
                fclose($cp);
                
                $TIPO_ARCHIVO = "OPCPAGO.DAT";
                $NOMBRE_ARCH  = 'OPCPAGO' . '_' . $FECSRV . '_' . $TIMESRV . '.DAT';
                $ret          = log_export($TIENDA, $TIPO_ARCHIVO, $NOMBRE_ARCH, $conn);
                return "Exportacion exitosa Op. Pago";
                
        } else {
               
                mkdir('../../'.$RUTA.$TIENDA.'/'. $CARPETA . "", 0777);
                $fp = fopen('../../'.$RUTA.$TIENDA.'/'. $CARPETA . '/OPCPAGO.DAT', 'w+');
                fwrite($fp, $guardar);
                fclose($fp);
                mkdir('../../'.$RUTA.$TIENDA."/bkp_op", 0777);
                $cp = fopen('../../'.$RUTA.$TIENDA.'/bkp_op/OPCPAGO' . $FECSRV . $TIMESRV . '.DAT', 'w+');
                fwrite($cp, $guardar);
                fclose($cp);
                $TIPO_ARCHIVO = "OPCPAGO.DAT";
                $NOMBRE_ARCH  = 'OPCPAGO' . '_' . $FECSRV . '_' . $TIMESRV . '.DAT';
                $ret          = log_export($TIENDA, $TIPO_ARCHIVO, $NOMBRE_ARCH, $conn);
                return "Exportacion exitosa Op. Pago";
                
        }
	
}

function create_gp($TIENDA, $save, $conn,$RUTA)
{
	$FECSRV  = date("Ymd");
	$TIMESRV = date("His");
        
        $TIENDA = "000" . $TIENDA;
        $TIENDA = substr($TIENDA, -3);
        
        if (file_exists('../../'.$RUTA.$TIENDA.'/update/') && file_exists('../../'.$RUTA.$TIENDA.'/bkp_gp/')) {
                //echo "directorio Existente";
                $fp = fopen('../../'.$RUTA.$TIENDA.'/update/GSECYSUB.DAT', 'w+');
                fwrite($fp, $save);
                fclose($fp);
                $cp = fopen('../../'.$RUTA.$TIENDA.'/bkp_gp/GSECYSUB' . '_' . $FECSRV . '_' . $TIMESRV . '.DAT', 'w+');
                fwrite($cp, $save);
                fclose($cp);
                $TIPO_ARCHIVO = "GSECYSUB.DAT";
                $NOMBRE_ARCH  = 'GSECYSUB' . '_' . $FECSRV . '_' . $TIMESRV . '.DAT';
                $ret          = log_export($TIENDA, $TIPO_ARCHIVO, $NOMBRE_ARCH, $conn);
                return "<br> Exportacion exitosa grupo";
        } else {
                //echo "no existe y se crea la carpeta";
                mkdir('../../'.$RUTA.$TIENDA.'/update/' , 0777);
                $fp = fopen('../../'.$RUTA.$TIENDA.'/update/GSECYSUB.DAT', 'w+');
                fwrite($fp, $save);
                fclose($fp);
                mkdir('../../'.$RUTA.$TIENDA.'/bkp_gp', 0777);
                $cp = fopen('../../'.$RUTA.$TIENDA. '/bkp_gp/GSECYSUB' . '_' . $FECSRV . '_' . $TIMESRV . '.DAT', 'w+');
                fwrite($cp, $save);
                fclose($cp);
                $TIPO_ARCHIVO = "GSECYSUB.DAT";
                $NOMBRE_ARCH  = 'GSECYSUB' . '_' . $FECSRV . '_' . $TIMESRV . '.DAT';
                $ret          = log_export($TIENDA, $TIPO_ARCHIVO, $NOMBRE_ARCH, $conn);
        }
	
}



// Fin Funciones
//GENERAR ARCHIVO PARA 1 TIENDA
if (strcmp($TIENDA, "TODOS") !== 0) {
    
	$CONSULTA = "SELECT * FROM CO_OP_PAGO  ORDER BY ID_OP";
	$RS       = sqlsrv_query($conn, $CONSULTA);
	//oci_execute($RS);
	while ($row = sqlsrv_fetch_array($RS)) {
		$MS           = "";
		$ID_OP        = $row['ID_OP']; // PK
		$ID_TARJ      = $row['ID_TARJ'];
		$PRT_DIF_INT  = $row['PRT_DIF_INT'];
		$DIF_PLUS     = $row['DIF_PLUS'];
		$PRT_MES_GRC  = $row['PRT_MES_GRC'];
		$ID_GRUPO     = $row['ID_GRUPO'];
		$CTS_POSIBLES = $row['CTS_POSIBLES'];
		if ($PRT_MES_GRC <= 9) {
			$PRT_MES_GRC = "0" . $PRT_MES_GRC;
		}
		$res = $ID_TARJ . $PRT_DIF_INT . $DIF_PLUS . $PRT_MES_GRC . $ID_GRUPO . $CTS_POSIBLES;
		$print .= $res . "<br>";
		//$flag = $ID_TARJ . $PRT_DIF_INT . $DIF_PLUS . $PRT_MES_GRC . $ID_GRUPO . $CTS_POSIBLES;
                $flag = $ID_TARJ . $PRT_DIF_INT . $DIF_PLUS . $PRT_MES_GRC . '00' . $CTS_POSIBLES;
		$guardar .= $flag . "\r\n";
		$CONSULTA2 = "SELECT * FROM DET_OP_PAGO WHERE ID_OP = " . $ID_OP;
		$RS2       = sqlsrv_query($conn, $CONSULTA2);
		//oci_execute($RS2);
		while ($row2 = sqlsrv_fetch_array($RS2)) {
			$FILLER      = "";
			$ID_TARJ_N   = $row2['ID_TARJ_N'];
			$MS_GRACIA   = $row2['MS_GRACIA'];
			$MNT_MIN_CMP = $row2['MNT_MIN_CMP'];
			$FILLER      = $row2['FILLER'];
			$ID_OP       = $row2['ID_OP'];
			$CNT_CTS     = $row2['CNT_CTS'];
			if ($MS_GRACIA <= 9) {
				$MS_GRACIA = "0" . $MS_GRACIA;
			}
			if ($CNT_CTS <= 9) {
				$CNT_CTS = "0" . $CNT_CTS;
			}
			if (strlen($MNT_MIN_CMP) <= 6) {
				$flag = strlen($MNT_MIN_CMP);
				if ($flag == 1) {
					$MNT_MIN_CMP = "00000" . $MNT_MIN_CMP;
				}
				if ($flag == 2) {
					$MNT_MIN_CMP = "0000" . $MNT_MIN_CMP;
				}
				if ($flag == 3) {
					$MNT_MIN_CMP = "000" . $MNT_MIN_CMP;
				}
				if ($flag == 4) {
					$MNT_MIN_CMP = "00" . $MNT_MIN_CMP;
				}
				if ($flag == 5) {
					$MNT_MIN_CMP = "0" . $MNT_MIN_CMP;
				}
			}
			// CASO: SI NO ES DIFERIDO PLUS // ELSE::: ES DIFERIDO PLUS
			if (!isset($CNT_CTS)) {
				$res = $ID_TARJ_N . $MS_GRACIA . $MNT_MIN_CMP . $FILLER;
				$print .= $res . "<br>";
				$flag = $ID_TARJ_N . $MS_GRACIA . $MNT_MIN_CMP . $FILLER;
				$guardar .= $flag . "\r\n";
			} else {
				$res = $ID_TARJ_N . $MS_GRACIA . $MNT_MIN_CMP . $CNT_CTS . $FILLER;
				$print .= $res . "<br>";
				$flag = $ID_TARJ_N . $MS_GRACIA . $MNT_MIN_CMP . $CNT_CTS . $FILLER;
				$guardar .= $flag . "\r\n";
			}
		}
		// GRUPOS DEPARTAMENTOS Y FAMILIAS // SECCIONES SUB SECCIONES 
		$QUERY = "SELECT * FROM CO_GRUPO WHERE ID_GRUPO = " . $ID_GRUPO . " ORDER BY ID_GRUPO ";
		$GP    = sqlsrv_query($conn, $QUERY);
		//oci_execute($GP);
		while ($row3 = sqlsrv_fetch_array($GP)) {
			$FILLER      = "";
			$ID_GRUPO    = $row3['ID_GRUPO'];
			$CORRELATIVO = $row3['CORRELATIVO'];
			$ULT_COR_GRP = $row3['ULT_COR_GRP'];
			$IN_EX       = $row3['IN_EX'];
			$FILLER      = $row3['FILLER'];
			$gp          = $ID_GRUPO . $CORRELATIVO . $ULT_COR_GRP . $IN_EX . $FILLER;
			$save .= $gp . "\r\n";
			$QUERY2 = "SELECT * FROM DET_CO_GRUPO WHERE ID_GRUPO = " . $ID_GRUPO . " ORDER BY ID_GRUPO ";
			$GP2    = sqlsrv_query($conn, $QUERY2);
			//oci_execute($GP2);
			while ($row4 = sqlsrv_fetch_array($GP2)) {
				$ID_DET_GRP  = $row4['ID_DET_GRP'];
				$ID_GRUPO    = $row4['ID_GRUPO'];
				$CORRELATIVO = $row4['CORRELATIVO'];
				$SEC_SUBSEC  = $row4['SEC_SUBSEC'];
				$gp          = $ID_GRUPO . $CORRELATIVO . $SEC_SUBSEC;
				$save .= $gp . "\r\n";
			}
		}
	}
	if ($TIENDA != '0000') {
		// EXPORT OPCIONES DE PAGO
                $ruta = $OPPAGO_RUTA."\r\n";
		$msg = create_op($TIENDA, $guardar, $conn,$RUTA,$CARPETA);
		create_cmd($conn, $TIENDA, $ruta, $RUTA, $CARPETA);
		$msg = create_gp($TIENDA, $save, $conn,$RUTA);
		echo $msg;
	} else {
		echo "Favor de seleccionar una tienda";
	}
        /*
	if ($TIENDA != 'NADA') {
		// Export Grupos
		$msg = create_gp($TIENDA, $save, $conn);
		echo $msg;
	} else {
		echo "Favor de seleccionar una tienda";
	}
         * 
         */
} else {
	// TODAS LAS TIENDAS 
	$P_QUERY = "SELECT * from MN_TIENDA where IND_ACTIVO = 1 AND COD_TIENDA<>0 ";
	$P_RES   = sqlsrv_query($maestra, $P_QUERY);
	//oci_execute($RS2);
	while ($P_ROW = sqlsrv_fetch_array($P_RES)) {
		$TIENDA   = $P_ROW['DES_CLAVE'];
		$guardar  = "";
		$save     = "";
		$print     = "";
		$CONSULTA = "SELECT * FROM CO_OP_PAGO  ORDER BY ID_OP";
	$RS       = sqlsrv_query($conn, $CONSULTA);
	//oci_execute($RS);
	while ($row = sqlsrv_fetch_array($RS)) {
		$MS           = "";
		$ID_OP        = $row['ID_OP']; // PK
		$ID_TARJ      = $row['ID_TARJ'];
		$PRT_DIF_INT  = $row['PRT_DIF_INT'];
		$DIF_PLUS     = $row['DIF_PLUS'];
		$PRT_MES_GRC  = $row['PRT_MES_GRC'];
		$ID_GRUPO     = $row['ID_GRUPO'];
		$CTS_POSIBLES = $row['CTS_POSIBLES'];
		if ($PRT_MES_GRC <= 9) {
			$PRT_MES_GRC = "0" . $PRT_MES_GRC;
		}
		$res = $ID_TARJ . $PRT_DIF_INT . $DIF_PLUS . $PRT_MES_GRC . $ID_GRUPO . $CTS_POSIBLES;
		$print .= $res . "<br>";
		//$flag = $ID_TARJ . $PRT_DIF_INT . $DIF_PLUS . $PRT_MES_GRC . $ID_GRUPO . $CTS_POSIBLES;
                $flag = $ID_TARJ . $PRT_DIF_INT . $DIF_PLUS . $PRT_MES_GRC . '00' . $CTS_POSIBLES;
		$guardar .= $flag . "\r\n";
		$CONSULTA2 = "SELECT * FROM DET_OP_PAGO WHERE ID_OP = " . $ID_OP;
		$RS2       = sqlsrv_query($conn, $CONSULTA2);
		//oci_execute($RS2);
		while ($row2 = sqlsrv_fetch_array($RS2)) {
			$FILLER      = "";
			$ID_TARJ_N   = $row2['ID_TARJ_N'];
			$MS_GRACIA   = $row2['MS_GRACIA'];
			$MNT_MIN_CMP = $row2['MNT_MIN_CMP'];
			$FILLER      = $row2['FILLER'];
			$ID_OP       = $row2['ID_OP'];
			$CNT_CTS     = $row2['CNT_CTS'];
			if ($MS_GRACIA <= 9) {
				$MS_GRACIA = "0" . $MS_GRACIA;
			}
			if ($CNT_CTS <= 9) {
				$CNT_CTS = "0" . $CNT_CTS;
			}
			if (strlen($MNT_MIN_CMP) <= 6) {
				$flag = strlen($MNT_MIN_CMP);
				if ($flag == 1) {
					$MNT_MIN_CMP = "00000" . $MNT_MIN_CMP;
				}
				if ($flag == 2) {
					$MNT_MIN_CMP = "0000" . $MNT_MIN_CMP;
				}
				if ($flag == 3) {
					$MNT_MIN_CMP = "000" . $MNT_MIN_CMP;
				}
				if ($flag == 4) {
					$MNT_MIN_CMP = "00" . $MNT_MIN_CMP;
				}
				if ($flag == 5) {
					$MNT_MIN_CMP = "0" . $MNT_MIN_CMP;
				}
			}
			// CASO: SI NO ES DIFERIDO PLUS // ELSE::: ES DIFERIDO PLUS
			if (!isset($CNT_CTS)) {
				$res = $ID_TARJ_N . $MS_GRACIA . $MNT_MIN_CMP . $FILLER;
				$print .= $res . "<br>";
				$flag = $ID_TARJ_N . $MS_GRACIA . $MNT_MIN_CMP . $FILLER;
				$guardar .= $flag . "\r\n";
			} else {
				$res = $ID_TARJ_N . $MS_GRACIA . $MNT_MIN_CMP . $CNT_CTS . $FILLER;
				$print .= $res . "<br>";
				$flag = $ID_TARJ_N . $MS_GRACIA . $MNT_MIN_CMP . $CNT_CTS . $FILLER;
				$guardar .= $flag . "\r\n";
			}
		}
	}
			// GRUPOS DEPARTAMENTOS Y FAMILIAS // SECCIONES SUB SECCIONES
                        
			$QUERY = "SELECT * FROM CO_GRUPO ORDER BY ID_GRUPO ";
			$GP    = sqlsrv_query($conn, $QUERY);
			//oci_execute($GP);
			while ($row3 = sqlsrv_fetch_array($GP)) {
				$ID_GRUPO    = $row3['ID_GRUPO'];
				$CORRELATIVO = $row3['CORRELATIVO'];
				$ULT_COR_GRP = $row3['ULT_COR_GRP'];
				$IN_EX       = $row3['IN_EX'];
				$FILLER      = $row3['FILLER'];
				$gp          = $ID_GRUPO . $CORRELATIVO . $ULT_COR_GRP . $IN_EX . $FILLER;
				$save .= $gp . "\r\n";
				$QUERY2 = "SELECT * FROM DET_CO_GRUPO WHERE ID_GRUPO = " . $ID_GRUPO . " ORDER BY ID_GRUPO ";
				$GP2    = sqlsrv_query($conn, $QUERY2);
				//oci_execute($GP2);
				while ($row4 = sqlsrv_fetch_array($GP2)) {
					$ID_DET_GRP  = $row4['ID_DET_GRP'];
					$ID_GRUPO    = $row4['ID_GRUPO'];
					$CORRELATIVO = $row4['CORRELATIVO'];
					$SEC_SUBSEC  = $row4['SEC_SUBSEC'];
					$gp          = $ID_GRUPO . $CORRELATIVO . $SEC_SUBSEC;
					$save .= $gp . "\r\n";
				}
			}
		if ($TIENDA != '0000') {
		// EXPORT OPCIONES DE PAGO
                $ruta = $OPPAGO_RUTA."\r\n";
		$msg = create_op($TIENDA, $guardar, $conn,$RUTA,$CARPETA);
		create_cmd($conn, $TIENDA, $ruta, $RUTA, $CARPETA);
		$msg = create_gp($TIENDA, $save, $conn,$RUTA);
		echo $msg;
	} else {
		echo "Favor de seleccionar una tienda";
	}
                /*
		if ($TIENDA != 'NADA') {
			// Export Grupos
			$msg = create_gp($TIENDA, $save, $conn);
			echo $msg;
		} else {
			echo "Favor de seleccionar una tienda";
		}
                 * 
                 */
                 
	}
}
?>