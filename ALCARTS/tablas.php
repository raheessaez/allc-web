<?php include("session.inc");?>

<?php
				$SQL="SELECT * FROM ALLC_DPT_LIN";
				$RS = sqlsrv_query($conn, $SQL);
				//oci_execute($RS);
				while ($row = sqlsrv_fetch_array($RS)) {
					$COD_SEC = trim($row['COD_SEC']); //DEPARTAMENTO
					$COD_LIN = trim($row['COD_LIN']); //LINEA
					echo $COD_SEC."<br>";
					//OBTENER COD_NEGOCIO
					$SQL2="SELECT COD_NEGOCIO FROM MN_NEGOCIO WHERE COD_LINEA='".$COD_LIN."' ";
					echo $SQL2."<br>";
					$RS2 = sqlsrv_query($maestra, $SQL2);
					//oci_execute($RS2);
					if ($row2 = sqlsrv_fetch_array($RS2)) {
						$COD_NEGOCIO = $row2['COD_NEGOCIO'];
					}
					$SQL3="SELECT * FROM ID_DPT_PS";
					$RS3 = sqlsrv_query($conn, $SQL3);
					//oci_execute($RS3);
					while ($row3 = sqlsrv_fetch_array($RS3)) {
						$ID_DPT_PS = $row3['ID_DPT_PS'];
						$CD_DPT_CER = trim($row3['CD_DPT_CER']);
						if($COD_SEC==$CD_DPT_CER){
							$CONSULTA2="UPDATE ID_DPT_PS SET COD_NEGOCIO=".$COD_NEGOCIO." WHERE ID_DPT_PS=".$ID_DPT_PS;
							echo $CONSULTA2."<br>";
							$RS2 = sqlsrv_query($conn, $CONSULTA2);
							//oci_execute($RS2);
						}
					}
				}
	
?>