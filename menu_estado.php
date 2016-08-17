<ul id="Estado" style="margin-right:170px; width:auto;">
        <li><a href="#">Ver Estado</a>
          <ul>
            <li>
             <table id="Listado">
             <tr>
                 <th>Tienda</th>
                 <th>Estado</th>
                 <th>Estado Ventas</th>
             </tr>
             <?php
			 
	    $CONSULTA_ART = "SELECT TOP 1 * FROM LE_STR_REC_TOT  ORDER BY ID_STR_REC_TOT DESC ";
	    $RS_ART = sqlsrv_query($ARTS_EC, $CONSULTA_ART);
	   
		if ($ROW_ART = sqlsrv_fetch_array($RS_ART))
		{
			$STR_CD= $ROW_ART["STR_CD"];
			$FECHA_LE_STR = $ROW_ART["TM_STP"];
		    $FECHA_LE_STR_INI = date_format($FECHA_LE_STR, "m/d/Y H:i");
			
			//SUMA  5 MINUTO
			$FECHA_LE_STR_I = date_format($FECHA_LE_STR, "i");
			$FECHA_LE_STR_I = $FECHA_LE_STR_I+5;
			$FECHA_LE_STR_TER=date_format($FECHA_LE_STR, "m/d/Y H:".$FECHA_LE_STR_I);
		    
			
		
		   $CONSULTA_STS = "SELECT * FROM FE_MESSAGE WHERE MESSAGE_NUMBER = 223 AND EVENT_DATE BETWEEN '".$FECHA_LE_STR_INI."' AND '".$FECHA_LE_STR_TER."'";
		   $RS_STS = sqlsrv_query($EYES, $CONSULTA_STS);
		   
	    	while ($ROW_STS = sqlsrv_fetch_array($RS_STS))
		   {
			$STR_CD = $ROW_STS['ID_LOCAL'];	
		    $EVENT_DATE = $ROW_STS['EVENT_DATE'];
			$EVENT_DATE = date_format($EVENT_DATE, "d/m/Y H:i:s");	
			
			
		    $TR = "SELECT COUNT(ID_TRN) AS CUENTA FROM TR_TRN WHERE TS_TRN_BGN > '".$EVENT_DATE. "' " ;
			$RS2 = sqlsrv_query($ARTS_EC, $TR);
			
			if($ROW_TR = sqlsrv_fetch_array($RS2))
		      {
				$CUENTA = $ROW_TR['CUENTA'];
				if($CUENTA > 0 )
				{
					$ESTADO_TERMINAL="Cerrado";
					
				}else{
					
					$ESTADO_TERMINAL="Abierto";
					
			    }
				
			  
				
				$QUERY_STORE = "SELECT COD_TIENDA, DES_TIENDA, DES_CLAVE FROM MN_TIENDA WHERE COD_TIENDA=" . $STR_CD;
				$RS_STORE = sqlsrv_query($maestra, $QUERY_STORE);
				if ($ROW_STORE = sqlsrv_fetch_array($RS_STORE))
				{
					$TIENDA = $ROW_STORE["DES_TIENDA"];
				}
				
			  
				
				if($ESTADO_TERMINAL=="Abierto")
				{
					$QUERY_CTC = "SELECT top 1 * FROM  le_Str_rec_tot where str_cd =" . $STR_CD . " order by TM_STP desc;";
					$RS_CTC = sqlsrv_query($ARTS_EC, $QUERY_CTC);
					if ($ROW_CTC = sqlsrv_fetch_array($RS_CTC))
					{
						$TM_STP_DB = $ROW_CTC['TM_STP'];
						$TM_END = date_format($TM_STP_DB, "m/d/Y");
						$TODAY = date("m/d/Y");
						
						$IMPORTE_VENTAS = 0;
						$QUERY_VENTAS = "SELECT * FROM TR_TRN WHERE TS_TRN_END BETWEEN '" . $TM_END . " 00:00:00' AND '" . $TODAY . " 23:59:59'";
						$RS_VENTAS = sqlsrv_query($ARTS_EC, $QUERY_VENTAS);
						while ($ROW_VENTAS = sqlsrv_fetch_array($RS_VENTAS))
						{
							$QUERY_IMPORTE = "SELECT * FROM TR_LTM_TND WHERE ID_TRN=" . $ROW_VENTAS["ID_TRN"];
							$RS_IMPORTE = sqlsrv_query($ARTS_EC, $QUERY_IMPORTE);
							if ($ROW_IMPORTE = sqlsrv_fetch_array($RS_IMPORTE))
							{
								if (isset($ROW_IMPORTE['MO_ITM_LN_TND']))
								{
									$IMPORTE_VENTAS = $IMPORTE_VENTAS + $ROW_IMPORTE['MO_ITM_LN_TND'];
								}
							}
							if ($IMPORTE_VENTAS < 0)
							{
								$NO_DEVS = 1;
							}
						}
						$SQL_SUMA = "SELECT SUM(GS_PLS) AS SUM_GS FROM LE_IND_REC_TOT WHERE STR_CD=" . $STR_CD . " AND REC_TYP=2";
						$RS_SUMA = sqlsrv_query($ARTS_EC, $SQL_SUMA);
						if ($ROW_SUMA = sqlsrv_fetch_array($RS_SUMA))
						{
							$SUM_GS = $ROW_SUMA["SUM_GS"];
						}
				
						$SQL_RESTA = "SELECT GS_MNS FROM LE_IND_REC_TOT WHERE STR_CD=" . $STR_CD . " AND REC_TYP=2";
						$RS_RESTA = sqlsrv_query($ARTS_EC, $SQL_RESTA);
						
						if ($ROW_RESTA = sqlsrv_fetch_array($RS_RESTA))
						{
							$GS_MNS = $ROW_RESTA["GS_MNS"];
						}
				
						$TOTAL_VENTAS = $SUM_GS - $GS_MNS;
						
						if ($IMPORTE_VENTAS != $TOTAL_VENTAS)
						{
							$ESTADO_VENTAS="No correcto";
							$STYLE = 'style="background-color:rgba(225, 29, 29, 0.58);color:#fff;cursor:pointer;"';
						}
						else
						{
							$ESTADO_VENTAS="Correcto";
							$STYLE='style="cursor:pointer;"';
						}
					  
					}
					

				}
				else
				{
					
					
						
							$ESTADO_VENTAS="Correcto";
							$STYLE='style="cursor:pointer;"';
						
					  
					
					
				}
			?>
             <tr <?=$STYLE;?> onClick="SHOW_STATUS('<?=$STR_CD?>');">
                 <td style="color:#898989;"><?= $TIENDA ?></td>
                 <td style="color:#898989;"><?=$ESTADO_TERMINAL?></td>
                 <td style="color:#898989;"><?=$ESTADO_VENTAS?></td>
             </tr>
              <?php
			         }
			  		
				}
		    }
				 ?>
             </table>
            </li>
          </ul>
        </li>
      </ul>
  <script>
  function SHOW_STATUS(STR_CD)
  {
	  window.location="../valida.php?STATUS_EYES=1&STR_CD="+STR_CD;
  }
  </script>
