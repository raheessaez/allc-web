<?php include("session.inc");?>
<?php

$REGISTRAR=$_POST["REGISTRAR"];

if ($REGISTRAR<>"") {
		//$SQL="ALTER SESSION SET nls_date_format='DD-MM-YYYY HH24:MI:SS'";
		//$RS = sqlsrv_query($arts_conn, $SQL);
		//oci_execute($RS);
		//$SQL="ALTER SESSION SET nls_date_format='DD-MM-YYYY HH24:MI:SS'";
		//$RS = sqlsrv_query($conn, $SQL);
		//oci_execute($RS);

		//CREAR BOLSA
		$SQLBOLSA="INSERT INTO BDVAL (IDREG) VALUES ";
		$SQLBOLSA=$SQLBOLSA."(".$SESIDUSU.")";
		$RSB = sqlsrv_query($conn, $SQLBOLSA);
		//oci_execute($RSB);																	
		$SQL="SELECT MAX(ID_BDVAL) AS MAXID FROM BDVAL";
		$RS = sqlsrv_query($conn, $SQL);
		//oci_execute($RS);
		if ($row = sqlsrv_fetch_array($RS)) {
			$ID_BDVAL = $row['MAXID'];
		}

		$ARRTRXS = array();
		foreach($_POST as $nombre_campo => $valor){ 
		   if($valor==1){ array_push($ARRTRXS, $nombre_campo); }
		}
		foreach( $ARRTRXS as $ID_TRN){
					
				$SQL="SELECT * FROM TR_TRN WHERE ID_TRN=".$ID_TRN;
				$RS = sqlsrv_query($arts_conn, $SQL);
				//oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {
					//2.TIENDA
					$ID_BSN_UN = $row['ID_BSN_UN'];
					$SQL2="SELECT CD_STR_RT FROM PA_STR_RTL WHERE ID_BSN_UN=".$ID_BSN_UN;
					$RS2 = sqlsrv_query($arts_conn, $SQL2);
					//oci_execute($RS2);
					if ($row2 = sqlsrv_fetch_array($RS2)) {
						$CD_STR_RT = $row2['CD_STR_RT'];
					}
					//3.TERMINAL
					$ID_WS = $row['ID_WS'];
					$SQL2="SELECT CD_WS FROM AS_WS WHERE ID_WS=".$ID_WS;
					$RS2 = sqlsrv_query($arts_conn, $SQL2);
					//oci_execute($RS2);
					if ($row2 = sqlsrv_fetch_array($RS2)) {
						$CD_WS = $row2['CD_WS'];
					}
					//4.OPERADOR	
					$ID_OPR = $row['ID_OPR'];
					$SQL2="SELECT CD_OPR FROM PA_OPR WHERE ID_OPR=".$ID_OPR;
					$RS2 = sqlsrv_query($arts_conn, $SQL2);
					//oci_execute($RS2);
					if ($row2 = sqlsrv_fetch_array($RS2)) {
						$CD_OPR = $row2['CD_OPR'];
					}
					//5. NUM.TICKET
					$AI_TRN = $row['AI_TRN'];
					//6-7. MEDIO DE PAGO E IMPORTE
					$SQL2="SELECT * FROM TR_LTM_TND_CTL_TND WHERE ID_TRN=".$ID_TRN;
					$RS2 = sqlsrv_query($arts_conn, $SQL2);
					//oci_execute($RS2);
					if ($row2 = sqlsrv_fetch_array($RS2)) {
						$ID_TND = $row2['ID_TND']; //MEDIO DE PAGO
						$MO_TND_FN_TRN = $row2['MO_TND_FN_TRN']; //IMPORTE (7)
					}
					$SQL2="SELECT DE_TND FROM AS_TND WHERE ID_TND=".$ID_TND;
					$RS2 = sqlsrv_query($arts_conn, $SQL2);
					//oci_execute($RS2);
					if ($row2 = sqlsrv_fetch_array($RS2)) {
						$DE_TND = $row2['DE_TND']; //DEF.MEDIO DE PAGO (6)
					}
					//8. FECHA TICKET
					$DC_DY_BSN = $row['DC_DY_BSN'];
					$DC_DY_BSN = date_format($DC_DY_BSN,'Y-m-d H:i:s');

					//$RES_TICKET=explode(" ",$DC_DY_BSN);
				    //$DC_DY_BSN=$RES_TICKET[0];
					//9. INICIO TRX
					$TS_TRN_BGN = $row['TS_TRN_BGN'];
					$TS_TRN_BGN = date_format($TS_TRN_BGN,'Y-m-d H:i:s');
					//	$RES_BGN=explode(" ",$TS_TRN_BGN);
					//	$TS_TRN_BGN=$RES_BGN[1];
					//10. FIN TRX
					$TS_TRN_END = $row['TS_TRN_END'];
					$TS_TRN_END = date_format($TS_TRN_END,'Y-m-d H:i:s');
					//	$RES_END=explode(" ",$TS_TRN_END);
					//	$TS_TRN_END=$RES_END[1];
				}	
				$SQLBRETS="INSERT INTO BDV_RET (ID_BDVAL, ID_TRN, CD_STR_RT, CD_WS, CD_OPR, AI_TRN, DE_TND, MO_TND_FN_TRN, TS_TICKET, TS_TRN_BGN, TS_TRN_END  ) VALUES ";
				$SQLBRETS=$SQLBRETS."(".$ID_BDVAL.", ".$ID_TRN.", '".$CD_STR_RT."', '".$CD_WS."', '".$CD_OPR."', ".$AI_TRN.", '".$DE_TND."', ".$MO_TND_FN_TRN.",convert(datetime,'".$DC_DY_BSN."', 121), convert(datetime,'".$TS_TRN_BGN."', 121),convert(datetime,'".$TS_TRN_END."', 121))";
				$RSRB = sqlsrv_query($conn, $SQLBRETS);
				//oci_execute($RSRB);																	
				
				header("Location: reg_retiros.php?FTIENDA=".$ID_BSN_UN);

		}


}