
<?php include("session.inc");?>
<?php include("headerhtml.inc");?>


<script language="JavaScript">

$(document).ready(function() {
    $('input[type=radio][name=FL_TEL]').change(function() {
        if (this.value == 0) {
                $('#TEL_CPR').attr("placeholder", "Ej: 2567890");
        }
        else{
            $('#TEL_CPR').attr("placeholder", "Ej: 0989422000");
        }
    });
    
    var FL1=$("#FL_TEL1").prop('checked');
    if (FL1 === true)
    {
         $('#TEL_CPR').attr("placeholder", "Ej: 2567890");
    }
    var FL2=$("#FL_TEL2").prop('checked');
    if (FL2 === true)
    {
        $('#TEL_CPR').attr("placeholder", "Ej: 0989422000");
    }
    
});
    
    
    
function valida(theForm){
     
	if (theForm.DIR_CPR.value === ""){
            alert("COMPLETE EL CAMPO REQUERIDO.");
            theForm.DIR_CPR.focus();
            return false;
	}
        
	if (theForm.TEL_CPR.value === ""){
                alert("COMPLETE EL CAMPO REQUERIDO.");
                theForm.TEL_CPR.focus();
                return false;
	}
        
        var FLTEL1=$("#FL_TEL1").prop('checked');
        var lg1 = theForm.TEL_CPR.value;
        if (FLTEL1 === true && lg1.length !== 9){
               
            alert("TELÉFONO FIJO REQUIERE CODIGO DE AREA MAS 7 DIGITOS DEL NUMERO EJ:042567890");
            theForm.TEL_CPR.focus();
            return false;
                
        }
        var FLTEL2=$("#FL_TEL2").prop('checked');
        if (FLTEL2 === true && lg1.length !== 10){
               
            alert("CELULAR REQUIERE DE 10 DIGITOS EJ: 0989422000");
            theForm.TEL_CPR.focus();
            return false;
                
        }
        
             
 }		




</script>



<?php
	$PAGINA=1167;
	$NOMENU=1;
	$MSJE=@$_GET["MSJE"];

	$LIST=@$_GET["LIST"];
	$CVM=@$_GET["CVM"];
	$SRL_NBR_CV=@$_GET["SN"];
	$ID_TRN_CV=@$_GET["TR"];
	$AI_LN_ITM_CV=@$_GET["AI"];
	$INVC_NMB_CV=@$_GET["FAC"];
	
	if ($CVM=="") {
		 $LIST=1;
	}
        
	$BSC_CVM=@$_POST["BSC_CVM"];
	if (empty($BSC_CVM)) { $BSC_CVM=@$_GET["BSC_CVM"] ;}
		
				$VERTND_UNO = 0;
				//VERIFICAR TIENDAS ASOCIADAS A USUARIO
				$SQL="SELECT COUNT(COD_TIENDA) AS CTATND FROM US_USUTND WHERE IDUSU=".$SESIDUSU;
				$RS = sqlsrv_query($maestra, $SQL);
				//oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {
					$CTATND = $row['CTATND'];
				}
				//OBTENER CC_OPERADOR
				$SQL="SELECT CC_OPERADOR FROM US_USUARIOS WHERE IDUSU=".$SESIDUSU;
				$RS = sqlsrv_query($maestra, $SQL);
				//oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {
					$CC_OPERADOR = $row['CC_OPERADOR'];
				}
				//SI CC_OPERADOR = 0 ENTONCES ES USUARIO CENTRAL, SÓLO REPORTES, NO GENERA CARTAS DE VENTA
				if($CC_OPERADOR==0){
						$FLT_GERENTE="";
				} else {
						//$FLT_GERENTE=" AND CC_OPERADOR=".$CC_OPERADOR;
						$FLT_GERENTE="";
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

	$FILTRO_TIENDACVM=" AND ID_TRN IN(SELECT ID_TRN FROM TR_TRN WHERE ID_BSN_UN=".$ID_BSN_UN_SEL.") " ;

	$BUSCAR=@$_POST["BUSCAR"];
	if (empty($BUSCAR)) { $BUSCAR=@$_GET["BUSCAR"] ;}
	
	$FILTRO_FACTURA="";
	$B_FACTURA=@$_POST["B_FACTURA"];
	if (empty($B_FACTURA)) { $B_FACTURA=@$_GET["B_FACTURA"] ;}
	if (!empty($B_FACTURA)) {
		$FILTRO_FACT=" AND ID_TRN IN(SELECT ID_TRN FROM TR_INVC WHERE INVC_NMB  Like '%".$B_FACTURA."%' ) ";
	}

	$FILTRO_NSERIE="";
	$B_SERIE=@$_POST["B_SERIE"];
	if (empty($B_SERIE)) { $B_SERIE=@$_GET["B_SERIE"] ;}
	if (!empty($B_SERIE)) {
		$FILTRO_NSERIE=" AND SRL_NBR Like '%".strtoupper($B_SERIE)."%' " ;
	}


			
					//CALCULAR MINIMO Y MÁXIMO FECHA REGISTRO TICKET
					$CONSULTA2="SELECT MIN(TS_TRN_END) AS MFECHA FROM TR_TRN WHERE ID_TRN IN (SELECT ID_TRN FROM TR_LTM_MOTO_DT) AND FL_VD<>1 AND FL_CNCL<>1";
					$RS2 = sqlsrv_query($arts_conn, $CONSULTA2);
					//oci_execute($RS2);
					if ($row = sqlsrv_fetch_array($RS2)){
							$MIN_FECHA_EMS = $row['MFECHA'];
							$MIN_FECHA_EMS = date_format($MIN_FECHA_EMS,'d/m/Y');
					}
					$CONSULTA2="SELECT MAX(TS_TRN_END) AS MFECHA FROM TR_TRN WHERE ID_TRN IN (SELECT ID_TRN FROM TR_LTM_MOTO_DT) AND FL_VD<>1 AND FL_CNCL<>1";
					$RS2 = sqlsrv_query($arts_conn, $CONSULTA2);
					//oci_execute($RS2);
					if ($row = sqlsrv_fetch_array($RS2)){
							$MAX_FECHA_EMS = $row['MFECHA'];
							$MAX_FECHA_EMS = date_format($MAX_FECHA_EMS,'d/m/Y');
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

					//$F_FECHA=" WHERE ID_TRN IN(SELECT ID_TRN FROM TR_TRN WHERE TO_CHAR(TS_TRN_END,'yyyy-mm-dd hh24:mi:ss') >= '".$ANO_ED."-".$MES_ED."-".$DIA_ED." 00:00:00' AND TO_CHAR(TS_TRN_END,'yyyy-mm-dd hh24:mi:ss') <='".$ANO_EH."-".$MES_EH."-".$DIA_EH." 23:59:59'  AND FL_VD<>1 AND FL_CNCL<>1)"; 

					$F_FECHA=" WHERE ID_TRN IN(SELECT ID_TRN FROM TR_TRN WHERE Convert(varchar(20), TS_TRN_END, 111) >= Convert(varchar(20),'".$ANO_ED."/".$MES_ED."/".$DIA_ED."', 111) AND Convert(varchar(20), TS_TRN_END, 111) <= Convert(varchar(20),'".$ANO_EH."/".$MES_EH."/".$DIA_EH."', 111)  AND FL_VD<>1 AND FL_CNCL<>1)";

?>

</head>
<body>

<?php include("encabezado.php");?>
<?php include("titulo_menu.php");?>
<table width="100%" height="100%">
<tr>
        <td align="right"  width="200" bgcolor="#FFFFFF"><?php include("menugeneral.php");?></td> 
<td>
<?php
if ($MSJE==1) {$ELMSJ="Actualizada Data del Cliente";} 
if ($MSJE <> "") {
?>
<div id="GMessaje" onClick="QuitarGMessage();"><a href="#" onClick="QuitarGMessage();" style="color:#111111;"><?= $ELMSJ?></a></div>
<?php }?>
        <table width="100%">
        <tr><td>
        
		<?php if($LIST==1){ 
					//CUENTA REGISTROS
					$CONSULTA="SELECT COUNT(*) AS CUENTA FROM TR_LTM_MOTO_DT ".$F_FECHA.$FILTRO_TIENDACVM.$FILTRO_NSERIE.$FILTRO_FACT.$FLT_GERENTE;
					
					$RS = sqlsrv_query($arts_conn, $CONSULTA);
					//oci_execute($RS);
					if ($row = @sqlsrv_fetch_array($RS)) {
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
		?>
                <table width="100%" id="Filtro">
                <form action="reg_cvmoto.php?BSC_CVM=1" method="post" name="forming" id="forming">
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
                                                    <h5><?= $ELNEGOCIO." ".$LATIENDA ?></h5>
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
                                                                    <h5><?= $ELNEGOCIO." ".$LATIENDA ?></h5>
                                                                    <input type="hidden" name="COD_NEGOCIO" value="<?= $COD_NEGOCIO_SEL?>">
                                                                    <input type="hidden" name="COD_TIENDA" value="<?= $COD_TIENDA_SEL?>">
                                                                <?php
                                                            } else {
                                                                ?>
                                                                    <select name="COD_NEGOCIO" onChange="CargaTiendaSelect(this.value, this.form.name, 'COD_TIENDA', <?=$SESIDUSU?>)">
                                                                                <option value="0">SELECCIONAR NEGOCIO</option>
                                                                                <?php 
                                                                                $SQL="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO IN(SELECT COD_NEGOCIO FROM US_USUTND WHERE IDUSU=".$SESIDUSU.") ORDER BY DES_NEGOCIO ASC";
                                                                                $RS = sqlsrv_query($maestra, $SQL);
                                                                                //oci_execute($RS);
                                                                                while ($row = sqlsrv_fetch_array($RS)) {
                                                                                    $COD_NEGOCIO = $row['COD_NEGOCIO'];
                                                                                    $DES_NEGOCIO = $row['DES_NEGOCIO'];
                                                                                 ?>
                                                                                <option value="<?= $COD_NEGOCIO ?>" <?php if($COD_NEGOCIO==$COD_NEGOCIO_SEL) {echo "Selected";} ?>><?= $DES_NEGOCIO ?></option>
                                                                                <?php 
                                                                                }
                                                                                 ?>
                                                                </select>
                                                                <select id="COD_TIENDA" name="COD_TIENDA" onChange="document.forms.forming.submit();">
                                                                    <option value="0">SELECCIONAR TIENDA</option>
                                                                    <?php
                                                                    if(!empty($COD_TIENDA_SEL)){
                                                                                $SQL="SELECT COD_TIENDA, DES_TIENDA, DES_CLAVE FROM MN_TIENDA WHERE COD_TIENDA IN(SELECT COD_TIENDA FROM US_USUTND WHERE IDUSU=".$SESIDUSU.") ORDER BY DES_CLAVE ASC";
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
                                                                                    <option value="<?= $STRCOD ?>" <?php if($STRCOD==$COD_TIENDA_SEL) {echo "Selected";} ?>><?= $NUM_TIENDA_F." - ".$STRDES ?></option>
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
                                                                    <h5><?= $ELNEGOCIO." ".$LATIENDA ?></h5>
                                                                    <input type="hidden" name="COD_NEGOCIO" value="<?= $COD_NEGOCIO_SEL?>">
                                                                    <input type="hidden" name="COD_TIENDA" value="<?= $COD_TIENDA_SEL?>">
                                                                <?php
                                                            } else {
                                                             ?>
                                                                    <select  name="COD_TIENDA" onChange="document.forms.forming.submit();">
                                                                                <option value="0">SELECCIONAR TIENDA</option>
                                                                                <?php 
                                                                                $SQL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA IN(SELECT COD_TIENDA FROM US_USUTND WHERE IDUSU=".$SESIDUSU.") ORDER BY DES_CLAVE ASC";
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
                                                                                            <option value="<?= $COD_TIENDA ?>"  <?php if($COD_TIENDA==$COD_TIENDA_SEL) {echo "Selected";} ?>><?= $LATIENDA ?></option>
                                                                                            <?php 
                                                                                        }
                                                                                }
                                                                                 ?>
                                                                </select>
                                                        <?php
                                                                //OBTENER NEGOCIO
                                                                $SQL1="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO IN(SELECT COD_NEGOCIO FROM US_USUTND WHERE IDUSU=".$SESIDUSU.") ";
                                                                $RS1 = sqlsrv_query($maestra, $SQL1);
                                                                //oci_execute($RS1);
                                                                if ($row1 = sqlsrv_fetch_array($RS1)) {
                                                                    $COD_NEGOCIO_TND = $row1['COD_NEGOCIO'];
                                                                }
                                                        ?>
                                                            <input type="hidden" name="COD_NEGOCIO" value="<?= $COD_NEGOCIO_TND?>">
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
                                                                    <h5><?= $ELNEGOCIO." ".$LATIENDA ?></h5>
                                                                    <input type="hidden" name="COD_NEGOCIO" value="<?= $COD_NEGOCIO_SEL?>">
                                                                    <input type="hidden" name="COD_TIENDA" value="<?= $COD_TIENDA_SEL?>">
                                                        <?php
                                                    } else {
                                                        ?>
                                                                    <select name="COD_NEGOCIO" onChange="CargaTiendaSelectE(this.value, this.form.name, 'COD_TIENDA')">
                                                                                <option value="0">SELECCIONAR NEGOCIO</option>
                                                                                <?php 
                                                                                $SQL="SELECT * FROM MN_NEGOCIO ORDER BY DES_NEGOCIO ASC";
                                                                                $RS = sqlsrv_query($maestra, $SQL);
                                                                                //oci_execute($RS);
                                                                                while ($row = sqlsrv_fetch_array($RS)) {
                                                                                    $COD_NEGOCIO = $row['COD_NEGOCIO'];
                                                                                    $DES_NEGOCIO = $row['DES_NEGOCIO'];
                                                                                 ?>
                                                                                <option value="<?= $COD_NEGOCIO ?>" <?php if($COD_NEGOCIO==$COD_NEGOCIO_SEL) {echo "Selected";} ?>><?= $DES_NEGOCIO ?></option>
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
                                                                                        <option value="<?= $STRCOD ?>" <?php if($STRCOD==$COD_TIENDA_SEL) {echo "Selected";} ?> ><?= $NUM_TIENDA_F." - ".$STRDES ?></option>
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
                      <input name="DIA_ED" type="text"  id="DIA_ED" value="<?= $DIA_ED ?>" size="2" maxlength="2" onKeyPress="return acceptNum(event);">
                     <select name="MES_ED" id="MES_ED">
                            <option value="01" <?php  if ($MES_ED==1) { echo "SELECTED";}?>>Enero</option>
                            <option value="02" <?php  if ($MES_ED==2) { echo "SELECTED";}?>>Febrero</option>
                            <option value="03" <?php  if ($MES_ED==3) { echo "SELECTED";}?>>Marzo</option>
                            <option value="04" <?php  if ($MES_ED==4) { echo "SELECTED";}?>>Abril</option>
                            <option value="05" <?php  if ($MES_ED==5) { echo "SELECTED";}?>>Mayo</option>
                            <option value="06" <?php  if ($MES_ED==6) { echo "SELECTED";}?>>Junio</option>
                            <option value="07" <?php  if ($MES_ED==7) { echo "SELECTED";}?>>Julio</option>
                            <option value="08" <?php  if ($MES_ED==8) { echo "SELECTED";}?>>Agosto</option>
                            <option value="09" <?php  if ($MES_ED==9) { echo "SELECTED";}?>>Septiembre</option>
                            <option value="10" <?php  if ($MES_ED==10) { echo "SELECTED";}?>>Octubre</option>
                            <option value="11" <?php  if ($MES_ED==11) { echo "SELECTED";}?>>Noviembre</option>
                            <option value="12" <?php  if ($MES_ED==12) { echo "SELECTED";}?>>Diciembre</option>
                       </select>
                       <input name="ANO_ED" type="text"  id="ANO_ED" value="<?= $ANO_ED ?>" size="4" maxlength="4">
                      <label for="FECHA_EM_H">Hasta</label>
                      <input name="DIA_EH" type="text"  id="DIA_EH" value="<?= $DIA_EH ?>" size="2" maxlength="2" onKeyPress="return acceptNum(event);">
                      <select name="MES_EH" id="MES_EH">
                            <option value="01" <?php  if ($MES_EH==1) { echo "SELECTED";}?>>Enero</option>
                            <option value="02" <?php  if ($MES_EH==2) { echo "SELECTED";}?>>Febrero</option>
                            <option value="03" <?php  if ($MES_EH==3) { echo "SELECTED";}?>>Marzo</option>
                            <option value="04" <?php  if ($MES_EH==4) { echo "SELECTED";}?>>Abril</option>
                            <option value="05" <?php  if ($MES_EH==5) { echo "SELECTED";}?>>Mayo</option>
                            <option value="06" <?php  if ($MES_EH==6) { echo "SELECTED";}?>>Junio</option>
                            <option value="07" <?php  if ($MES_EH==7) { echo "SELECTED";}?>>Julio</option>
                            <option value="08" <?php  if ($MES_EH==8) { echo "SELECTED";}?>>Agosto</option>
                            <option value="09" <?php  if ($MES_EH==9) { echo "SELECTED";}?>>Septiembre</option>
                            <option value="10" <?php  if ($MES_EH==10) { echo "SELECTED";}?>>Octubre</option>
                            <option value="11" <?php  if ($MES_EH==11) { echo "SELECTED";}?>>Noviembre</option>
                            <option value="12" <?php  if ($MES_EH==12) { echo "SELECTED";}?>>Diciembre</option>
                        </select>
                        <input name="ANO_EH" type="text"  id="ANO_EH" value="<?= $ANO_EH ?>" size="4" maxlength="4" onKeyPress="return acceptNum(event);">
					
                        <input style="text-align:right; clear:left" name="B_SERIE" type="text"  id="B_SERIE" value="<?= $B_SERIE ?>" size="9" maxlength="18">
                       <input name="BSC_NSR" type="submit" id="BSC_NSR" value="Buscar N&uacute;m. Serie">
                        <input style=" text-align:right" name="B_FACTURA" type="text"  id="B_FACTURA" value="<?= $B_FACTURA ?>" size="9" maxlength="9" onKeyPress="return acceptNum(event);">
                       <input name="BSC_FAC" type="submit" id="BSC_FAC" value="Buscar Factura">
                       <?php if($TOTALREG>=1){?>
                       <input  name="EXCEL" type="button" id="EXCEL" value="Excel" onClick="javascript:pagina('cvmoto_excel.php?ID_BSN_UN=<?= $ID_BSN_UN_SEL?>&DIA_ED=<?= $DIA_ED ?>&MES_ED=<?= $MES_ED ?>&ANO_ED=<?= $ANO_ED ?>&DIA_EH=<?= $DIA_EH ?>&MES_EH=<?= $MES_EH ?>&ANO_EH=<?= $ANO_EH ?>&B_FACTURA=<?= $B_FACTURA ?>&B_SERIE=<?= $B_SERIE ?>&IDUSU=<?= $SESIDUSU ?>');" title="Descargar Lista en planilla Excel">
                       <?php } ?>
                       <input name="LIMPIAR" type="button" id="LIMPIAR" value="Limpiar" onClick="pagina('reg_cvmoto.php');">
              </td>
              </tr>
                </form>
               </table>
              <!-- FIN FILTRO, INICIO LISTADO -->
              
                <table style="margin:10px 20px; ">
                <tr>
                <td>
					<?php
                     //FORMATO DE FECHA               
					$SQL="ALTER SESSION SET nls_date_format='DD-MM-YYYY HH24:MI:SS'";
					$RS = sqlsrv_query($conn, $SQL);
					//oci_execute($RS);
		
					if($TOTALREG>=1){ //ENCONTRO AL MENOS UNO
					//CONSULTA RESULTADO BÚSQUEDA
					//$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM TR_LTM_MOTO_DT ".$F_FECHA.$FILTRO_TIENDACVM.$FILTRO_NSERIE.$FILTRO_FACT.$FLT_GERENTE." ORDER BY ID_TRN  DESC, AI_LN_ITM ASC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;

					$CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY ID_TRN  DESC, AI_LN_ITM ASC) ROWNUMBER FROM TR_LTM_MOTO_DT ".$F_FECHA.$FILTRO_TIENDACVM.$FILTRO_NSERIE.$FILTRO_FACT.$FLT_GERENTE.") AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";

					$RS = sqlsrv_query($arts_conn, $CONSULTA);



					//oci_execute($RS);
				   ?>
                    <table id="Listado">
                    <tr>
                        <th>N&uacute;mero de Serie</th>
                        <th>Factura</th>
                        <th>Art&iacute;culo</th>
                        <th>Cliente</th>
						<?php if($CC_OPERADOR==0){?>
                        <th>Gerente</th>
						<?php }?>
                        <th>Estado</th>
                    </tr>
                    <?php
					$NUM_ARTS=0;
                    while ($row = sqlsrv_fetch_array($RS)){
						$ID_TRN = $row['ID_TRN'];
						$AI_LN_ITM = $row['AI_LN_ITM'];
						$SRL_NBR = $row['SRL_NBR'];
						$GERENTE = $row['CC_OPERADOR'];
						$S2="SELECT * FROM US_USUARIOS WHERE CC_OPERADOR=".$GERENTE;
						$RS2 = sqlsrv_query($maestra, $S2);
						//oci_execute($RS2);
						if ($row2 = sqlsrv_fetch_array($RS2)) {
							$NOMBGERENTE = $row2['NOMBRE'];
						}	
						//TICKET
						$S2="SELECT * FROM TR_TRN WHERE ID_TRN=".$ID_TRN;
						$RS2 = sqlsrv_query($arts_conn, $S2);
						//oci_execute($RS2);
						if ($row2 = sqlsrv_fetch_array($RS2)) {
							$ID_BSN_UN = $row2['ID_BSN_UN'];
							$FECHA_TICKET = $row2['DC_DY_BSN'];
							$FECHA_TICKET = date_format($FECHA_TICKET,"d-m-Y");
							$RES_TICKET=explode(" ",$FECHA_TICKET);
							$TS_TICKET=$RES_TICKET[0];
							$NUM_TICKET = $row2['AI_TRN'];
						}	
						
								$TIENDA="NR";
								$S2="SELECT DE_STR_RT, CD_STR_RT FROM PA_STR_RTL WHERE ID_BSN_UN=".$ID_BSN_UN;
								$RS2 = sqlsrv_query($arts_conn, $S2);
								//oci_execute($RS2);
								if ($row2 = sqlsrv_fetch_array($RS2)) {
									$CODTIENDA = $row2['CD_STR_RT'];
									$CODTIENDA="0000".$CODTIENDA;
									$CODTIENDA=substr($CODTIENDA, -4); //BIN 
								}	
								
								$SQLF="SELECT * FROM TR_LTM_SLS_RTN WHERE ID_TRN=".$ID_TRN." AND AI_LN_ITM=".$AI_LN_ITM;
								$RSF = sqlsrv_query($arts_conn, $SQLF);
								//oci_execute($RSF);
								if ($rowf = sqlsrv_fetch_array($RSF)) {
									$ID_ITM = $rowf['ID_ITM'];
								}
								
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
									$DE_ITM = $row1['DE_ITM'];
									if(trim($DE_ITM)==""){$DE_ITM=$NM_ITM;}
								}

								$SQLF="SELECT * FROM TR_INVC WHERE ID_TRN=".$ID_TRN;
								$RSF = sqlsrv_query($arts_conn, $SQLF);
								//oci_execute($RSF);
								if ($rowf = sqlsrv_fetch_array($RSF)) {
									$INVC_NMB = $rowf['INVC_NMB'];
									$ID_CPR = $rowf['ID_CPR'];
									$FL_CP = $rowf['FL_CP'];
								}
								
								if($FL_CP==0){
											$SQLM="SELECT * FROM CO_CPR_CER WHERE ID_CPR=".$ID_CPR;
											$RSM = sqlsrv_query($arts_conn, $SQLM);
											//oci_execute($RSM);
											if ($rowM = sqlsrv_fetch_array($RSM)) {
												$NOM_CPR = $rowM['NOMBRE'];
												$CD_CPR = $rowM['CD_CPR'];
												$DIR_CPR = $rowM['DIRECCION'];
												$COD_CIUDAD = $rowM['COD_CIUDAD'];
														$SQLC="SELECT DES_CIUDAD FROM PM_CIUDAD WHERE COD_CIUDAD=".$COD_CIUDAD;
														$RSC = sqlsrv_query($maestra, $SQLC);
														//oci_execute($RSC);
														if ($rowC = sqlsrv_fetch_array($RSC)) {
															$DIR_CPR = $DIR_CPR.", ".$rowC['DES_CIUDAD'];
														}
											}
								
								} else {
											$SQLE="SELECT * FROM CO_EXT_CER WHERE ID_CPR=".$ID_CPR;
											$RSE = sqlsrv_query($arts_conn, $SQLE);
											//oci_execute($RSE);
											if ($rowE = sqlsrv_fetch_array($RSE)) {
												$NOM_CPR = $rowE['NOMBRE'];
												$CD_CPR = "Pasaporte: ".$rowE['CD_CPR'];
												$DIR_CPR = $rowE['DIRECCION'];
												$NACIONALIDAD = $rowE['NACIONALIDAD'];
											}
								}
								if(trim($DIR_CPR)==""){ $DIR_CPR="No registrado";}

								$SQLF="SELECT COUNT(ID_CARTA) AS CTAMOTO FROM CM_CARTAS WHERE ID_TRN=".$ID_TRN;
								$RSF = sqlsrv_query($conn, $SQLF);
								//oci_execute($RSF);
								if ($rowf = sqlsrv_fetch_array($RSF)) {
									$CTAMOTO = $rowf['CTAMOTO'];
								}
								
								if($CTAMOTO == 0) {$ELESTADO="PENDIENTE CARTA"; $TDCOLOR="#7A2A9C";}
								if($CTAMOTO != 0) {
										$SQLF="SELECT * FROM CM_CARTAS WHERE ID_TRN=".$ID_TRN;
										$RSF = sqlsrv_query($conn, $SQLF);
										//oci_execute($RSF);
										if ($rowf = sqlsrv_fetch_array($RSF)) {
											$ESTADO = $rowf['ESTADO'];
											if($ESTADO==0){$ELESTADO="PENDIENTE EMISI&Oacute;N"; $TDCOLOR="#EC407A";}
											if($ESTADO==1){$ELESTADO="CARTA ACEPTADA"; $TDCOLOR="#8BC34A";}
											if($ESTADO==2){$ELESTADO="CARTA IMPRESA Y ENVIADA"; $TDCOLOR="#689F38";}
											if($ESTADO==3){$ELESTADO="CARTA RE-IMPRESA"; $TDCOLOR="#689F38";}
											if($ESTADO==4){$ELESTADO="CARTA RECHAZADA"; $TDCOLOR="#F44336";}
										}
								}
								
                   ?>
                    <tr>
                    	<?php if($CC_OPERADOR!=0){?>
                        <td><a href="reg_cvmoto.php?CVM=1&SN=<?= $SRL_NBR?>&TR=<?= $ID_TRN?>&AI=<?= $AI_LN_ITM?>&FAC=<?=$INVC_NMB?>"><?= $SRL_NBR?></a></td>
                        <?php } else {?>
                        <td style="font-weight:600; font-size:11pt"><?= $SRL_NBR?></td>
                        <?php } ?>
                        <td style="text-align:right"><span style="font-size:12pt"><?= $INVC_NMB?></span> <BR> <?= $TS_TICKET?></td>
                        <td><?= $DE_ITM."<br>C&oacute;digo: ".$ID_ITM_PS;?></td>
                        <td>Cliente: <?= $NOM_CPR." (".$CD_CPR.")";?><br><span style="font-weight:300">Direcci&oacute;n: <?= $DIR_CPR;?></span></td>
						<?php if($CC_OPERADOR==0){?>
                        <td><?= $NOMBGERENTE;?></td>
						<?php }?>
                        <td style="text-align:center; vertical-align:middle; background-color:<?= $TDCOLOR;?>; color:#FFF; text-shadow:none"><?= $ELESTADO?></td>
                    </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td colspan="7" nowrap>
                        <?php
                        if ($LINF>=$CTP+1) {
                            $ATRAS=$LINF-$CTP;
                            $FILA_ANT=$LSUP-$CTP;
                       ?>
                        <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('reg_cvmoto.php?BSC_CVM=<?= $BSC_CVM ?>&LSUP=<?= $FILA_ANT?>&LINF=<?= $ATRAS?>&COD_TIENDA=<?= $ID_BSN_UN_SEL?>&DIA_ED=<?= $DIA_ED ?>&MES_ED=<?= $MES_ED ?>&ANO_ED=<?= $ANO_ED ?>&DIA_EH=<?= $DIA_EH ?>&MES_EH=<?= $MES_EH ?>&ANO_EH=<?= $ANO_EH ?>&B_FACTURA=<?= $B_FACTURA ?>&B_SERIE=<?= $B_SERIE ?>');">
                        <?php
                        }
                        if ($LSUP<=$TOTALREG) {
                            $ADELANTE=$LSUP+1;
                            $FILA_POS=$LSUP+$CTP;
                       ?>
                        <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('reg_cvmoto.php?BSC_CVM=<?= $BSC_CVM ?>&LSUP=<?= $FILA_POS?>&LINF=<?= $ADELANTE?>&COD_TIENDA=<?= $ID_BSN_UN_SEL?>&DIA_ED=<?= $DIA_ED ?>&MES_ED=<?= $MES_ED ?>&ANO_ED=<?= $ANO_ED ?>&DIA_EH=<?= $DIA_EH ?>&MES_EH=<?= $MES_EH ?>&ANO_EH=<?= $ANO_EH ?>&B_FACTURA=<?= $B_FACTURA ?>&B_SERIE=<?= $B_SERIE ?>');">
                        <?php }?>
                        <span style="vertical-align:baseline;">P&aacute;gina <?= $NUMPAG?> de <?= $NUMTPAG?></span>
                        </td>
                    </tr>
                    </table>
                    <?php
					} else {
					?>
                    	<h4>No se registran coincidencias</h4>
                    <?php
					}//FIN ENCONTRO AL MENOS UNO
					sqlsrv_close($conn);
                    ?>
                    <!-- FIN RESULTADO BÚSQUEDA -->
                </td>
                </tr>
                </table>
		<?php } //FIN LISTADO ?>    
                    


		<?php
		if($CVM==1){
		?>
        <h2>Carta de Venta Veh&iacute;culo Serie <?= $SRL_NBR_CV;?></h2>
					<?php
                        $ID_TRN=$ID_TRN_CV;
                        $SQLF="SELECT * FROM TR_INVC WHERE ID_TRN=".$ID_TRN;
                        $RSF = sqlsrv_query($arts_conn, $SQLF);
                        //oci_execute($RSF);
                        if ($rowf = sqlsrv_fetch_array($RSF)) {
                            $INVC_NMB = $rowf['INVC_NMB'];
                            $ID_CPR = $rowf['ID_CPR'];
                            $FL_CP = $rowf['FL_CP'];
                        }
                        if($FL_CP==0){ //DATA CLIENTE FACTURA
                                    $SQLM="SELECT * FROM CO_CPR_CER WHERE ID_CPR=".$ID_CPR;
                                    $RSM = sqlsrv_query($arts_conn, $SQLM);
                                    //oci_execute($RSM);
                                    if ($rowM = sqlsrv_fetch_array($RSM)) {
                                        $NOM_CPR = $rowM['NOMBRE'];
                                        $CD_CPR = $rowM['CD_CPR'];
                                        $DIR_CPR = $rowM['DIRECCION'];
                                        $COD_CIUDAD = $rowM['COD_CIUDAD'];
                                        $TEL_CPR = $rowM['TELEFONO'];
                                        $COR_CPR = $rowM['CORREO'];
                                        $TY_CPR = $rowM['TY_CPR'];
                                        // FIJO O CELULAR 0:FIJO 1:CEL
                                        $FL_TEL = $rowM['FL_TEL'];
                                        if($TY_CPR=='C'){$TIPOID="C&eacute;dula";}
                                        if($TY_CPR=='R'){$TIPOID="RUC";}
                                    }
                        } else {
                                    $SQLM="SELECT * FROM CO_EXT_CER WHERE ID_CPR=".$ID_CPR;
                                    $RSM = sqlsrv_query($arts_conn, $SQLM);
                                    //oci_execute($RSM);
                                    if ($rowM = sqlsrv_fetch_array($RSM)) {
                                        $NOM_CPR = $rowM['NOMBRE'];
                                        $CD_CPR = $rowM['CD_CPR'];
                                        $DIR_CPR = $rowM['DIRECCION'];
                                        $TEL_CPR = $rowM['TELEFONO'];
                                        $COR_CPR = $rowM['CORREO'];
                                        $NAC_CPR = $rowM['NACIONALIDAD'];
                                        // FIJO O CELULAR 0:FIJO 1:CEL
                                        $FL_TEL = $rowM['FL_TEL'];
                                        
                                        $TIPOID="Pasaporte";
                                    }
                        }
                    ?>
                <table style="margin:10px 20px; ">
                <tr><td>
                                <h3>Informaci&oacute;n del Cliente</h3>
                                <form name="frmactcliente" method="post" action="reg_cvmoto_reg.php" onSubmit="return valida(this)" >
                                <table id="forma-registro">
                               
                                <tr>
                                    <td colspan="2">
                                    <p style="font-size:11pt; font-weight:600">Nombre: <?php echo $NOM_CPR;?></p>
                                    <p style="font-size:11pt; font-weight:600"><?= $TIPOID.": ".$CD_CPR;?></p>
                                    </td>
                                </tr>
                                
                                <tr id="DIRECC">
                                    <td><label for="DIR_CPR">Direcci&oacute;n</label></td>
                                    <td><input name="DIR_CPR" type="text" size="26" maxlength="100"  value="<?= $DIR_CPR?>"> </td>
                                </tr>
                                <?php if($FL_CP==0){ ?>
                                            <tr id="CIUDAD">
                                               <td><label for="COD_CIUDAD">Ciudad</label></td>
                                               <td><select id="COD_CIUDAD" name="COD_CIUDAD">
                                                        <option value="0">Ciudad</option>
                                                                <?php
                                                                    if($GLBDPTREG==1){
                                                                            $S1="SELECT * FROM PM_CIUDAD WHERE COD_PAIS=".$GLBCODPAIS." AND COD_REGION=".$COD_REGION." ORDER BY DES_CIUDAD ASC";
                                                                    } else {
                                                                            $S1="SELECT * FROM PM_CIUDAD WHERE COD_PAIS=".$GLBCODPAIS." ORDER BY DES_CIUDAD ASC";
                                                                    }
                                                                    $RS1 = sqlsrv_query($maestra, $S1);
                                                                    //oci_execute($RS1);
                                                                    while ($row = sqlsrv_fetch_array($RS1)) {
                                                                        $COD_CIUDAD2 = $row['COD_CIUDAD'];
                                                                        $DES_CIUDAD = $row['DES_CIUDAD'];
                                                                ?>
                                                                <option value="<?=$COD_CIUDAD2?>" <?php if($COD_CIUDAD2==$COD_CIUDAD){echo "SELECTED";}?>><?=$DES_CIUDAD?></option>
                                                                <?php
                                                                    }
                                                                ?>
                                                        </select>
                                            </td>
                                            </tr>
                                <?php } else { ?>
                                <tr id="NACIONALIDAD">
                                    <td><label for="NAC_CPR">Nacionalidad</label></td>
                                    <td><input name="NAC_CPR" type="text" size="20" maxlength="50" value="<?= $NAC_CPR?>"> </td>
                                </tr>
                                <?php } ?>
                                <tr id="TELEFONO">
                                   
                                    <td style="border-top:none;">
                                         <tr>
                                             <?php if($FL_TEL == 0){?>
                                             <td>
                                                 <strong style="font-weight:600;">Tel&eacute;fono Fijo:</strong> <input type="radio" id="FL_TEL1" name="FL_TEL" value="0"  checked>
                                             </td>
                                             <td>
                                                 <strong style="font-weight:600;">Celular:</strong> <input type="radio" id="FL_TEL2" name="FL_TEL"  value="1">
                                             </td>
                                             <?php }else{ ?>
                                             <td>
                                                   <strong style="font-weight:600;">Tel&eacute;fono Fijo:</strong> <input type="radio" id="FL_TEL1" onc name="FL_TEL" value="0">
                                             </td>
                                             <td>
                                                     <strong style="font-weight:600;">Celular:</strong> <input type="radio" name="FL_TEL" id="FL_TEL12" value="1" checked>
                                             </td>
                                              <?php }?>
                                        </tr>
                                    </td>
                                    
                                    <td><label for="TEL_CPR">Tel&eacute;fono</label></td>
                                    <td ><input name="TEL_CPR" id="TEL_CPR" type="text" size="20" maxlength="10"  value="<?= $TEL_CPR?>"></td>
                                    
                                </tr>
                                <tr id="CORREO">
                                    <td><label for="COR_CPR">Correo Electr&oacute;nico</label></td>
                                    <td ><input name="COR_CPR" type="text" size="26" maxlength="100"  style="text-transform:lowercase" value="<?= $COR_CPR?>"> </td>
                                </tr>
                               <tr>
                                    <td>
                                    <input type="hidden" name="SN" value="<?php echo $SRL_NBR_CV?>">
                                    <input type="hidden" name="TR" value="<?php echo $ID_TRN?>">
                                    <input type="hidden" name="ID_CPR" value="<?php echo $ID_CPR?>">
                                    <input type="hidden" name="FL_CP" value="<?php echo $FL_CP?>">
                                    </td>
                                    <td>
                                    <input type="submit" name="ACTDATACLT" value="Actualizar Data Cliente">
                                    <input type="button" name="SALIR" value="Salir" onClick="pagina('reg_cvmoto.php');">
                                    
                                     <?php 
                                    $QUERY="SELECT * FROM CM_CARTAS WHERE ID_TRN =".$ID_TRN." AND CC_OPERADOR =". $CC_OPERADOR;
                                    
                                    
                                    $QS1 = sqlsrv_query($conn, $QUERY);
                                    //oci_execute($QS1);
                                    if($row = sqlsrv_fetch_array($QS1)){
                                    $ESTADO = $row['ESTADO'];

                                    if($ESTADO == 1){
                                    ?>
                                         <input style="display:block; width:100%; margin-top:10px" type="button" name="GENERA" value="Actualizar Carta de Venta" onClick="VentanaImprime('PrintCVMT.php?SN=<?=$SRL_NBR_CV?>&TR=<?=$ID_TRN?>&CL=<?=$ID_CPR?>&FC=<?=$FL_CP?>&AI=<?=$AI_LN_ITM_CV?>&FAC=<?=$INVC_NMB_CV?>&IU=<?=$SESIDUSU?>&ACT=<?=$ESTADO?>&CCO=<?=$CC_OPERADOR?>');">
                                    <?php }else{ ?>
                                         <input style="display:block; width:100%; margin-top:10px" type="button" name="GENERA" value="Generar Carta de Venta" onClick="VentanaImprime('PrintCVMT.php?SN=<?=$SRL_NBR_CV?>&TR=<?=$ID_TRN?>&CL=<?=$ID_CPR?>&FC=<?=$FL_CP?>&AI=<?=$AI_LN_ITM_CV?>&FAC=<?=$INVC_NMB_CV?>&IU=<?=$SESIDUSU?>&ACT=<?=$ESTADO?>&CCO=<?=$CC_OPERADOR?>');">
                                    <?php  } 
                                    
                                    } ?>
                                     </td>
                                </tr>
                                
                               
                        </table>
                      </form>

                </td></tr>
                </table>
        <?php
		} //CVM==1
		?>




        </td>
        </tr>
        </table>
</td>
</tr>
</table>
        <iframe name="frmHIDEN" width="0%" height="0" frameborder="0" align="top" src="" framespacing="0" marginheight="0" marginwidth="0">
        </iframe>
</body>
</html>

