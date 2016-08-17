<?php

//IDENTIFICAR @ARC_SAP CON ID_ESTPRC=0
			$SQL="SELECT * FROM ARC_SAP WHERE ID_ESTPRC=0";
			$RS = sqlsrv_query($conn, $SQL);
			//oci_execute($RS);
			while ($row = sqlsrv_fetch_array($RS)) {
				$ID_ARCSAP = $row['ID_ARCSAP'];
			/*
				$LOTE = substr("0000".$row['NUM_LOTE'], -4);
				$TND = substr("000".$row['COD_TIENDA'], -3);
				//GENERAR DIRECTORIO @_arc_tmp/TND_LOTE
				mkdir("_arc_tmp/".$TND."_".$LOTE, 0777);
				//TRASLADAR ARCHIVOS ITEM Y EAN LOTE.TND A _arc_tmp/TND_LOTE
					$ARCHIVOITEM="ITEM".$LOTE.".".$TND;
					$ARCHIVOEAN="EAN".$LOTE.".".$TND;
					$ARCHIVOERRI="ERRI".$LOTE.".".$TND;
					$ARCHIVOERRE="ERRE".$LOTE.".".$TND;
					//DEFINE DESTINO (local)\sa
					$DIRLOCAL="_arc_tmp/".$TND."_".$LOTE."/";
					//TRASLADA ARCHIVOS A DIRECTORIO LOCAL
					$conn_id = ftp_connect($FTP_SERVER); 
					$login_result = ftp_login($conn_id, $FTP_UNM, $FTP_UPW);
						ftp_get($conn_id, $DIRLOCAL.$ARCHIVOITEM, $APSAP_IN.$ARCHIVOITEM, FTP_BINARY); //ITEM
						ftp_get($conn_id, $DIRLOCAL.$ARCHIVOEAN, $APSAP_IN.$ARCHIVOEAN, FTP_BINARY); //EAN
						ftp_get($conn_id, $DIRLOCAL.$ARCHIVOERRI, $APSAP_IN.$ARCHIVOERRI, FTP_BINARY); //ERRI
						ftp_get($conn_id, $DIRLOCAL.$ARCHIVOERRE, $APSAP_IN.$ARCHIVOERRE, FTP_BINARY); //ERRE
						//NO ELIMINAR ARCHIVOS HASTA QUE CAMBIE EL ESTADO, IDEALMENTE CUANDO SE TRASLADEN A BKP/APSAP
					ftp_close($conn_id);
					//OBTENER ARCHIVOS DE LOTE DESDE IN/APSAP Y REGISTRARLOS @_arc_tmp/TND_LOTE
							$SQL3="SELECT * FROM ARC_PRC WHERE ID_ARCSAP=".$ID_ARCSAP;
							$RS3 = sqlsrv_query($conn, $SQL3);
							//oci_execute($RS3);
							while ($row3 = sqlsrv_fetch_array($RS3)) {
								$ID_ARCPRC = $row3['ID_ARCPRC'];
								$NOM_ARCLOTE = $row3['NOM_ARCLOTE'];
								//OBTENER SUB-LOTE
								$SUBLOTE = substr($NOM_ARCLOTE, 2, 7);
								$ARCLO = "LO".$SUBLOTE.".".$TND;
								$ARCPE = "PE".$SUBLOTE.".".$TND;
								$ARCEX = "EX".$SUBLOTE.".".$TND;
								//TRASLADA ARCHIVOS A DIRECTORIO LOCAL
								$conn_id = ftp_connect($FTP_SERVER); 
								$login_result = ftp_login($conn_id, $FTP_UNM, $FTP_UPW);
									ftp_get($conn_id, $DIRLOCAL.$ARCLO, $APSAP_IN.$ARCLO, FTP_BINARY); //LO
									ftp_get($conn_id, $DIRLOCAL.$ARCPE, $APSAP_IN.$ARCPE, FTP_BINARY); //PE
									ftp_get($conn_id, $DIRLOCAL.$ARCEX, $APSAP_IN.$ARCEX, FTP_BINARY); //EX
									//NO ELIMINAR ARCHIVOS HASTA QUE CAMBIE EL ESTADO, IDEALMENTE CUANDO SE TRASLADEN A BKP/APSAP
								ftp_close($conn_id);
								}


			*/
				$SQLAS="SELECT MIN(ID_ESTPRC) AS MID_ESTPRC FROM ARC_PRC WHERE ID_ARCSAP=".$ID_ARCSAP;
				$RSAS = sqlsrv_query($conn, $SQLAS);
				//oci_execute($RSAS);
				if ($rowAS = sqlsrv_fetch_array($RSAS)) {
					$MID_ESTPRC = $rowAS['MID_ESTPRC'];
				}
				$SQLAS="UPDATE ARC_SAP SET ID_ESTPRC=".$MID_ESTPRC." WHERE ID_ARCSAP=".$ID_ARCSAP;
				$RSAS = sqlsrv_query($conn, $SQLAS);
				//oci_execute($RSAS);
				
			}//FIN @ARC_SAP
			


?>
