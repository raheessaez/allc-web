<?php 
include("session.inc");

$CONSULTA2="SELECT COD_NVL1,DES_ES from PA_OPCMENU ";

				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				
				while ($row = sqlsrv_fetch_array($RS2)) {

						$DES_ES=$row['DES_ES'];
						$COD_NVL1=$row['COD_NVL1'];
					
						$QUERY = "SELECT  [dbo].[RemoverTildes] ('".$DES_ES."') as RES";
						$RS1 = sqlsrv_query($conn, $QUERY);
					 	
					 	while ($row = sqlsrv_fetch_array($RS1)) {

						$RES=$row['RES'];
						ECHO $RES.'<br>';

						$QY = "UPDATE PA_OPCMENU set DES_ES = '".$RES."' WHERE COD_NVL1 = ".$COD_NVL1." ";
						$R = sqlsrv_query($conn, $QY);
						
						}


				}





 ?>