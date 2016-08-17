<?php include("session.inc");?>
<?php

$ELMFLEJE=$_GET["ELMFLEJE"];

if ($ELMFLEJE<>"") {
		$SQL="DELETE FROM IMP_FLJART WHERE ID_FLEJE=".$ELMFLEJE;
		$RS = sqlsrv_query($conn, $SQL);
		//oci_execute($RS);
		$SQL="DELETE FROM IMP_FLJ WHERE ID_FLEJE=".$ELMFLEJE;
		$RS = sqlsrv_query($conn, $SQL);
		//oci_execute($RS);
		header("Location: print_flejes.php");
}

$REGFLEJE=$_GET["REGFLEJE"];

if ($REGFLEJE<>"") {
		$SQL="UPDATE IMP_FLJ SET ESTADO=1 WHERE ID_FLEJE=".$REGFLEJE;
		$RS = sqlsrv_query($conn, $SQL);
		//oci_execute($RS);
		
		//GENERAR ARCHIVO
		$SQL="SELECT * FROM IMP_FLJ WHERE ID_FLEJE=".$REGFLEJE;
		$RS = sqlsrv_query($conn, $SQL);
		//oci_execute($RS);
		if ($row = sqlsrv_fetch_array($RS)) {
				$COD_TIENDA=$row['COD_TIENDA'];
				$COD_FTIPO=$row['COD_FTIPO'];
		}
		$SQL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA=".$COD_TIENDA;
		$RS = sqlsrv_query($maestra, $SQL);
		//oci_execute($RS);
		if ($row = sqlsrv_fetch_array($RS)) {
				$DES_CLAVE=$row['DES_CLAVE'];
				$EXTEN="000".$DES_CLAVE;
				$EXTEN=substr($EXTEN, -3); 
		}
		$SQL="SELECT * FROM PA_STR_RTL WHERE CD_STR_RT=".$DES_CLAVE;
		$RS = sqlsrv_query($arts_conn, $SQL);
		//oci_execute($RS);
		if ($row = sqlsrv_fetch_array($RS)) {
				$ID_BSN_UN=$row['ID_BSN_UN'];
		}
		
		$NOM_ARCHIVO="AF".date("YmdHis").".".$EXTEN;
		
		$SQL="SELECT * FROM IMP_FLJART WHERE ID_FLEJE=".$REGFLEJE." ORDER BY ID_FLJART ASC";
		$RS = sqlsrv_query($conn, $SQL);
		//oci_execute($RS);
		$LN_PRINT="";
		while ($row = sqlsrv_fetch_array($RS)) {
			$REF_SAP="";
				$CD_ITM=$row['CD_ITM'];
				$DEPARTAMENTO="";
				//CODIGO
				$CD_ITM_F="000000000000".$CD_ITM;
				$CD_ITM_F=substr($CD_ITM_F, -12); 
				$SQL2="SELECT * FROM AS_ITM WHERE CD_ITM=".$CD_ITM;
				$RS2 = sqlsrv_query($arts_conn, $SQL2);
				//oci_execute($RS2);
				if ($row2 = sqlsrv_fetch_array($RS2)) {
						$ID_ITM=$row2['ID_ITM'];
						$NM_ITM=$row2['NM_ITM'];
						$REF_SAP=$row2['REF_SAP'];
						$DEPARTAMENTO=$row2['ID_DPT_PS'];
						//DESCRIPCION
						$NM_ITM_F=$NM_ITM."                  ";
						$NM_ITM_F=substr($NM_ITM_F, 0, 18); 
				}
				$SQL2="SELECT * FROM ID_PS WHERE ID_ITM=".$ID_ITM;
				$RS2 = sqlsrv_query($arts_conn, $SQL2);
				//oci_execute($RS2);
				if ($row2 = sqlsrv_fetch_array($RS2)) {
						$ID_ITM_PS=$row2['ID_ITM_PS'];
						//CODIGO EAN
						$EAN_ITM="000000000000000000".$ID_ITM_PS;
						$EAN_ITM=substr($EAN_ITM, -18); 
				}
				//PRECIO
				$SQL2="SELECT * FROM AS_ITM_STR WHERE ID_BSN_UN=".$ID_BSN_UN." AND ID_ITM=".$ID_ITM;
				$RS2 = sqlsrv_query($arts_conn, $SQL2);
				//oci_execute($RS2);
				if ($row2 = sqlsrv_fetch_array($RS2)) {
						$SLS_PRC=$row2['SLS_PRC'];
						$PREC_ITM=$SLS_PRC/$DIVCENTS;
						$PREC_ITM=number_format($PREC_ITM, $CENTS, $GLBSDEC, $GLBSMIL);
						$SLS_PRC_F=$PREC_ITM."          ";
						$SLS_PRC_F=substr($SLS_PRC_F, 0, 10); 
				}
				$SQL_IMPUESTO="SELECT * FROM PA_STR_RTL WHERE CD_STR_RT=".$DES_CLAVE;
				$RS_IMPUESTO = sqlsrv_query($ARTS_EC, $SQL_IMPUESTO);
				//oci_execute($RS1)
				if ($ROW_IMPUESTO = sqlsrv_fetch_array($RS_IMPUESTO)) 
				{
					$IMP_1 = $ROW_IMPUESTO['IMP_1'];
					$IMP_1_F = $IMP_1/$DIVCENTS;
					$IMP_1_F = number_format($IMP_1_F, $CENTS, '.', ',');
				}
				$COD_FTIPO=$_GET["COD_FTIPO"];
				$PRE_PROVEEDOR="";
				$PRE_REFERENCIA="";
				if(trim(strtoupper($COD_FTIPO))=="R")
				{
					$PRE_PROVEEDOR=$DEPARTAMENTO;
				}
				elseif(trim(strtoupper($COD_FTIPO))=="Z")
				{
					$PRE_REFERENCIA=$DEPARTAMENTO;
					$PRE_PROVEEDOR="MC";
					$F_TIPO="M";
				}
				elseif(trim(strtoupper($COD_FTIPO))=="U")
				{
					$PRE_REFERENCIA=$DEPARTAMENTO;
					$PRE_PROVEEDOR="MU";
					$F_TIPO="M";
				}
				elseif(trim(strtoupper($COD_FTIPO))=="C")
				{
					$PRE_REFERENCIA=$DEPARTAMENTO;
					$PRE_PROVEEDOR="CS";
					$F_TIPO="C";
				}
				//TAMAÑO
				$TAM_ITM="                    ";
				//MARCA
				$MRC_ITM="                    ";
				//REFERENCIA
				$PRV_ITM="                ";
				$REF_ITM="                ";
				if($REF_SAP!="")
				{
					$CONCAT="";
					$LARGO_REF=strlen($REF_SAP);
					$DIF=20-$LARGO_REF;
					for($i=0;$i<$DIF;$i++)
					{
						$CONCAT.=" ";
					}
					$REF_ITM=$CONCAT.$REF_SAP;
				}
				if($PRE_REFERENCIA!="")
				{
					$CONCAT="";
					$LARGO_REF=strlen($PRE_REFERENCIA);
					$DIF=20-$LARGO_REF;
					for($i=0;$i<$DIF;$i++)
					{
						$CONCAT.=" ";
					}
					$REF_ITM=$CONCAT.$PRE_REFERENCIA;
				}
				if($PRE_PROVEEDOR!="")
				{
					$CONCAT="";
					$LARGO_REF=strlen($PRE_PROVEEDOR);
					$DIF=20-$LARGO_REF;
					for($i=0;$i<$DIF;$i++)
					{
						$CONCAT.=" ";
					}
					$PRV_ITM=$CONCAT.$PRE_PROVEEDOR;
					
				}
				//INDICADOR IMPUESTO
				$TAX_IND = 1;
				//PROVEEDOR
				//UDS.POR CAJA
				$UND_BOX="00000000";
				//CANTIDAD DE FLEJES
				$QN_ITM=$row['QN_ITM'];
				$QN_ITM_F="00000000".$QN_ITM;
				$QN_ITM_F=substr($QN_ITM_F, -8); 
				//PORCENTAJE DE RECARGO
				$POR_REC="000.00";
				//PORCENTAJE DE IVA
				if(isset($IMP_1_F))
				{
					$POR_IVA=$IMP_1_F;
				}
				else
				{
					$POR_IVA="111.00";
				}
				//MODELO DE BARRA
				$MOD_BAR="      ";
				//INDICADOR DE NO AFILIADO
				$IND_NOA=1;
				
					$LN_PRINT=$LN_PRINT.$CD_ITM_F.$EAN_ITM.$NM_ITM_F.$FILLER.$TAM_ITM.$MRC_ITM.$REF_ITM.$TAX_IND.$PRV_ITM.$UND_BOX.$SLS_PRC_F.$QN_ITM_F.$F_TIPO.$POR_REC.$POR_IVA.$MOD_BAR.$IND_NOA."\r\n";
					 $open = fopen("_arc_prt/".$NOM_ARCHIVO, "w+");
					 fwrite($open, $LN_PRINT);
					 fclose($open);
		}//FIN WHILE

		$local_file="_arc_prt/".$NOM_ARCHIVO;
		copy($local_file, $DIR_FLJ."IN/".$NOM_ARCHIVO);
		
		header("Location: print_flejes.php");
}
/*
CODIGO DE ARTÍCULO	12	1	NUMÉRICO
CÓDIGO EAN DE ARTÍCULO	18	13	NUMÉRICO
DESCRIPCIÓN DE ARTÍCULO	18	31	ALFA
TAMAÑO	20	49	ALFA
MARCA	20	69	ALFA
REFERENCIA	20	89	ALFA
INDICADOR DE IMPUESTO	1	109	NUMÉRICO
PROVEEDOR	20	110	NUMÉRICO
UNIDADES POR CAJA	8	130	NUMÉRICO
PRECIO UNITARIO DEL ARTÍCULO	10	138	ALFA - PRECIO CON FORMATO DECIMAL
CANTIDAD DE ETIQUETAS	8	148	NUMÉRICO
TIPO DE ETIQUETA	1	156	ALFA
PORCENTAJE DE RECARGO	6	157	ALFA - CON FORMATO DECIMAL
PORCENTAJE IVA	6	163	ALFA - CON FORMATO DECIMAL
MODELO DE BARRA	6	169	ALFA
INDICADOR DE NO AFILIADO	1	175	NUMÉRICO
*/
?>
