<?php
include ("session.inc");

?>
<?php
include ("headerhtml.inc");

?>
<?php

function DOLARS($VAL)
{
	if (strlen($VAL) > 1)
	{
		$DEC_VAL = substr($VAL, -2);
		$INT_VAL = substr($VAL, 0, -2);
		return "US $" . $INT_VAL . "." . $DEC_VAL;
	}
	else
	{
		return $VAL;
	}
}

$PAGINA = 2183;
$NOMENU = 1;
$LOG = 1;
$LIST = @$_GET["LIST"];
?>

</head>

<body>

<?php
include ("encabezado.php");

?>
<?php
include ("titulo_menu.php");

?>
<table width="100%" height="100%">
<tr>
<td align="right"  width="200" bgcolor="#FFFFFF"><?php
include ("menugeneral.php");

?></td> 
<td >
<?php

if ($MSJE == 1)
{
	$ELMSJ = "Registro actualizado";
}

if ($MSJE == 2)
{
	$ELMSJ = "Registro no disponible, verifique";
}

if ($MSJE == 3)
{
	$ELMSJ = "Registro realizado";
}

if ($MSJE == 4)
{
	$ELMSJ = "Registro eliminado";
}

if ($MSJE <> "")
{
?>
 
<div id="GMessaje" onClick="QuitarGMessage();"><a href="#" onClick="QuitarGMessage();" style="color:#111111;"><?php
	echo $ELMSJ
?></a></div>
<?php
} ?>
<div id="mensaje"> </div>
        <table width="100%">
        <tr><td>
        
                <h2><?php
echo $LAPAGINA
?></h2>
                <table style="margin:10px 20px; ">
                <tr>
                <td>          
                <?php

if ($LIST != 1)
{
	$CONSULTA4 = "select * from  STR_STS";
	$RS4 = sqlsrv_query($EYES, $CONSULTA4);
?>
                 <table>
                <tr>
                <?php
	$contador = 0;
	$STYLE = "";
	while ($row4 = sqlsrv_fetch_array($RS4))
	{
			$ID_STR_STS=$row4["ID_STR_STS"];
			$STR_CD=$row4["STR_CD"];
			$SQL2 = "SELECT COD_TIENDA, DES_TIENDA, DES_CLAVE FROM MN_TIENDA WHERE COD_TIENDA=" . $STR_CD;
			$RS2 = sqlsrv_query($maestra, $SQL2);
			if ($row2 = sqlsrv_fetch_array($RS2))
			{
				$TIENDA = $row2["DES_TIENDA"];
			}
?>
                     <form action="estado.php?LIST=1" method="post" name="frmsel<?php
			echo $ID_STR_STS
?>" id="frmsel<?php
			echo $ID_STR_STS
?>">
                            <td onClick="document.forms.frmsel<?php
			echo $ID_STR_STS
?>.submit();">
                            	<div id="SelArticulos">
                                	<p style="font-weight:600; font-size:12pt"><?php
			echo $TIENDA ?></p>
                                	<input type="hidden" name="STR_CD" value="<?php
			echo $STR_CD ?>">
                               </div>
                            </td>
                            </form>
                         
                   
                <?php
		}

		if ($contador == 4)
		{
			echo "</tr><tr>";
			$contador = 0;
		}

		$contador++;
		echo " </tr>
                </table>";
	}

if ($LIST == 1)
{
	if (isset($_POST["STR_CD"]) or isset($_GET["STR_CD"]))
	{
		if (isset($_POST["STR_CD"]))
		$STR_CD = $_POST["STR_CD"];
		
		if (isset($_GET["STR_CD"]))
		$STR_CD = $_GET["STR_CD"];
		
		
		
	   $CONSULTA_ART = "SELECT TOP 1 * FROM LE_STR_REC_TOT WHERE STR_CD=".$STR_CD."ORDER BY ID_STR_REC_TOT DESC ";
	   $RS_ART = sqlsrv_query($ARTS_EC, $CONSULTA_ART);
	   
		if ($ROW_ART = sqlsrv_fetch_array($RS_ART))
		{
			$FECHA_LE_STR = $ROW_ART["TM_STP"];
			$FECHA_LE_STR_INI = date_format($FECHA_LE_STR, "m/d/Y H:i");
			
			
			$FECHA_LE_STR_I = date_format($FECHA_LE_STR, "i");
			$FECHA_LE_STR_I = $FECHA_LE_STR_I+5;
			
			
			$FECHA_LE_STR_TER=date_format($FECHA_LE_STR, "m/d/Y H:".$FECHA_LE_STR_I);
			
			

		
		$CONSULTA_STS = "SELECT EVENT_DATE,ID_LOCAL FROM FE_MESSAGE WHERE MESSAGE_NUMBER = 223 AND EVENT_DATE BETWEEN '".$FECHA_LE_STR_INI."' AND '".$FECHA_LE_STR_TER."'";
		$RS_STS = sqlsrv_query($EYES, $CONSULTA_STS);
?>
        <h3>Detalle Estado Tienda</h3>
          <table id="Listado">
                <tr>
                 <th>Nombre Tienda</th>
                  <th>Estado tienda</th>
                  <th>Fecha</th>
                </tr>
        <?php
		$cont=0;
		while($ROW_STS = sqlsrv_fetch_array($RS_STS))
		{
			
		$EVENT_DATE = $ROW_STS['EVENT_DATE'];
		   $ID_LOCAL = $ROW_STS['ID_LOCAL'];
		   	
			$EVENT_DATE = date_format($EVENT_DATE, "d/m/Y H:i:s");	
			
			
			$TR = "SELECT COUNT(ID_TRN) AS CUENTA FROM TR_TRN WHERE TS_TRN_BGN > '".$EVENT_DATE. "' " ;
			$RS2 = sqlsrv_query($ARTS_EC, $TR);
			
			if($ROW_TR = sqlsrv_fetch_array($RS2))
		    {
				$CUENTA = $ROW_TR['CUENTA'];
				
				
				if($CUENTA > 0 )
				{
					$ESTADO_TERMINAL="Abierto";
					
				}else{
					
					$ESTADO_TERMINAL="Cerrado";
					
			    }
				
				

		 
			$CONSULTA_STORE = "SELECT COD_TIENDA, DES_TIENDA, DES_CLAVE FROM MN_TIENDA WHERE COD_TIENDA=".$ID_LOCAL;
			$RS_STORE = sqlsrv_query($maestra, $CONSULTA_STORE);
			
			if ($ROW_STORE = sqlsrv_fetch_array($RS_STORE))
			{
				$TIENDA = $ROW_STORE["DES_TIENDA"];
			}
			
			
			

			echo "<tr>";
			echo '<td>' . $TIENDA . '</td>';
			echo '<td>' . $ESTADO_TERMINAL . '</td>';
			echo '<td>' . $EVENT_DATE . '</td>';
			echo "</tr>";
			
	
				
			}
			
		}
			

		
		  
		}

		echo "</table>";
?>
	 <h3>Detalle Terminales</h3>
          <table id="Listado">
                <tr>
                  <th>Terminal</th>
                  <th>Operador</th>
                  <th>Cant. y Monto de Dotaciones</th>
                  <th>Cant. y Monto de Retiros</th>
                  <th>Cant Transacciones</th>
                  <th>Monto Bruto</th>
                  <th>Monto Varios</th>
                  <th>Monto Total</th>
                  <th>Transaccion en Proceso</th>
                </tr>
        <?php
		$CONSULTA_DET_TERM = "SELECT * FROM  WS_STS order by OPR";
		$RS_DET_TERM = sqlsrv_query($EYES, $CONSULTA_DET_TERM);
		while ($ROW_DET_TERM = sqlsrv_fetch_array($RS_DET_TERM))
		{
			if ($ROW_DET_TERM["OPR"] == 0)
			{
				$ACNT_ID = "Oficina";
			}
			else
			{
				$ACNT_ID = "Operador: " . $ROW_DET_TERM["OPR"];
			}
			echo "<tr>";
			echo "<td>".$ROW_DET_TERM["TML"]."</td>";
			echo "<td>".$ACNT_ID."</td>";
			echo "<td>".$ROW_DET_TERM["NMB_LO"]." - ".DOLARS($ROW_DET_TERM["AMT_LO"])."</td>";
			echo "<td>".$ROW_DET_TERM["NMB_PKP"]." - ".DOLARS($ROW_DET_TERM["AMT_PKP"])."</td>";
			echo "<td>".$ROW_DET_TERM["TRN_NMB"]."</td>";
			echo "<td>".DOLARS($ROW_DET_TERM["GS_PSTV"]-$ROW_DET_TERM["GS_NV"])."</td>";
			echo "<td>".$ROW_DET_TERM["AMT_MSC"]."</td>";
			echo "<td>".DOLARS($ROW_DET_TERM["TL_AMT_CSH"])."</td>";
			
			switch($ROW_DET_TERM["TRN_TY"])
			{
				case "0":
				case "00":
					echo "<td>Transaccion en Pago</td>";
				break;
				case "1":
				case "01":
					echo "<td>Cajero en Cobro</td>";
				break;
				case "2":
				case "02":
					echo "<td>Cajero en cambio</td>";
				break;
				case "3":
				case "03":
					echo "<td>Dotaci&oacute;n a Cajero</td>";
				break;
				case "4":
				case "04":
					echo "<td>Retiro a Cajero</td>";
				break;
				case "5":
				case "05":
					echo "<td>Cajero Listando</td>";
				break;
				case "6":
				case "06":
					echo "<td>Precio en cambio/verificaci{on</td>";
				break;
				case "7":
				case "07":
					echo "<td>Sesi&oacute;n de Entreno</td>";
				break;
				case "8":
				case "08":
					echo "<td>Terminal de transferencia</td>";
				break;
				case "9":
				case "09":
					echo "<td>Terminal Monitor</td>";
				break;
				case "10":
					echo "<td>Cajero contando</td>";
				break;
				case "12":
					echo "<td>No EBT WIC</td>";
				break;
				case "13":
					echo "<td>Trans. de devoluci&oacute;n de art.</td>";
				break;
				case "16":
					echo "<td>Reimpresi&oacute;n recibo cajero</td>";
				break;
				case "20":
					echo "<td>EBT balance</td>";
				break;
				case "21":
					echo "<td>Value Card balance</td>";
				break;
				case "22":
					echo "<td>WIC EBT balance</td>";
				break;
				case "80":
					echo "<td>Reporte total por Depto.</td>";
				break;
				case "99":
					echo "<td>Sin transacciones</td>";
				break;
			}
			echo "</tr>";
		}

		echo "</table>";
?>

	<h3>Detalle Transacciones en Suite</h3>
          <table id="Listado">
                <tr>
                  <th>Transaccion</th>
                   <th>Terminal</th>
                   <th>Operador</th>
                  <th>Medio de Pago</th>
                  <th>Monto</th>
                  <th>Fecha</th>
                </tr>
        <?php
		$CONSULTA = "SELECT * FROM  le_Str_rec_tot where str_cd in(select STR_CD from LE_STR_REC_TOT where STR_CD=" . $STR_CD . ") order by TM_STP desc;";
		$RS = sqlsrv_query($ARTS_EC, $CONSULTA);
		if ($row = sqlsrv_fetch_array($RS))
		{
			$TM_STP_DB = $row['TM_STP'];
			$TM_END = date_format($TM_STP_DB, "m/d/Y");
			$TODAY = date("m/d/Y");
			$ELTICKET = "";
			$S2 = "SELECT * FROM TR_TRN WHERE TS_TRN_END BETWEEN '" . $TM_END . " 00:00:00' AND '" . $TODAY . " 23:59:59'";
			$RS2 = sqlsrv_query($ARTS_EC, $S2);
			while ($row2 = sqlsrv_fetch_array($RS2))
			{
				$AI_TRN = $row2["AI_TRN"];
				$ID_TRN = $row2["ID_TRN"];
				$ELTICKET = $AI_TRN;
				$S_INVC = "SELECT * FROM TR_INVC WHERE ID_TRN=" . $ID_TRN;
				$RS_INVC = sqlsrv_query($ARTS_EC, $S_INVC);
				if ($row_INVC = sqlsrv_fetch_array($RS_INVC))
				{
					$INVC_NMB = $row_INVC['INVC_NMB'];
				}

				if (!empty($INVC_NMB))
				{
					$ESFACT = 1;
				}

				if ($ESFACT == 1)
				{
					$ELTICKET = $AI_TRN . " / " . $INVC_NMB; //CAMBIA TICKET POR NÚMERO DE FACTURA
				}

				$ID_WS = $row2['ID_WS'];
				$TERMINAL = "NR";
				$S_TERMINAL = "SELECT CD_WS FROM AS_WS WHERE ID_WS=" . $ID_WS;
				$RS_TERMINAL = sqlsrv_query($ARTS_EC, $S_TERMINAL);

				// oci_execute($RS2);

				if ($row_TERMINAL = sqlsrv_fetch_array($RS_TERMINAL))
				{
					$TERMINAL = $row_TERMINAL['CD_WS'];
				}

				$TERMINAL_F = "0000" . $TERMINAL;
				$TERMINAL_F = substr($TERMINAL_F, -4);
				$TIPO_MEDPAGO = "NR";
				$S_MPAGO = "SELECT ID_TND  FROM TR_LTM_TND WHERE ID_TRN=" . $ID_TRN . " GROUP BY ID_TND ";
				$RS_MPAGO = sqlsrv_query($ARTS_EC, $S_MPAGO);

				// oci_execute($RS2);

				$MEDIODEPAGO = "";
				while ($row_MPAGO = sqlsrv_fetch_array($RS_MPAGO))
				{
					$ID_TND = $row_MPAGO['ID_TND'];
					$S_MPAGO_ = "SELECT DE_TND FROM AS_TND WHERE ID_TND=" . $ID_TND;
					$RS_MPAGO_ = sqlsrv_query($ARTS_EC, $S_MPAGO_);

					// oci_execute($RS3);

					if ($row_MPAGO_ = sqlsrv_fetch_array($RS_MPAGO_))
					{
						$MEDIODEPAGO = $MEDIODEPAGO . " " . $row_MPAGO_['DE_TND'] . "/ ";
					}

					if (empty($MEDIODEPAGO))
					{
						$MEDIODEPAGO = "NO DEFINIDO:";
					}
				}

				$TIPO_MEDPAGO = $MEDIODEPAGO;
				$IMPORTE = 0;
				$S_IMPORTE = "SELECT SUM((CASE FL_IS_CHNG  WHEN 1 THEN (-1) ELSE (1) END)* MO_ITM_LN_TND) AS SUMAIMPORTE  FROM TR_LTM_TND WHERE ID_TRN=" . $ID_TRN;
				$RS_IMPORTE = sqlsrv_query($ARTS_EC, $S_IMPORTE);

				// oci_execute($RS2);

				if ($row_IMPORTE = sqlsrv_fetch_array($RS_IMPORTE))
				{
					$IMPORTE = $row_IMPORTE['SUMAIMPORTE'];
				}

				$IMPORTE = $IMPORTE / $DIVCENTS;
				$FECHA_TICKET = $row2['TS_TRN_END'];
				$TS_TICKET = date_format($FECHA_TICKET, "d/m/Y");
				$ID_OPR = $row2['ID_OPR'];
				$OPERADOR = "NR";
				$S_OPERADOR = "SELECT CD_OPR FROM PA_OPR WHERE ID_OPR=" . $ID_OPR;
				$RS_OPERADOR = sqlsrv_query($ARTS_EC, $S_OPERADOR);

				// oci_execute($RS2);

				if ($row_OPERADOR = sqlsrv_fetch_array($RS_OPERADOR))
				{
					$OPERADOR = $row_OPERADOR['CD_OPR'];
				}

				$OPERADOR_F = "00000000" . $OPERADOR;
				$OPERADOR_F = substr($OPERADOR_F, -8);
				$S3 = "SELECT * FROM TR_LTM_TND WHERE ID_TRN=" . $row2["ID_TRN"];
				$RS3 = sqlsrv_query($ARTS_EC, $S3);
				while ($row3 = sqlsrv_fetch_array($RS3))
				{
					echo "<tr>";
					echo '<td>' . $ELTICKET . '</td>';
					echo '<td>' . $TERMINAL_F . '</td>';
					echo '<td>' . $OPERADOR_F . '</td>';
					echo '<td>' . $TIPO_MEDPAGO . '</td>';
					echo '<td>US$ ' . $IMPORTE . '</td>';
					echo '<td> ' . $TS_TICKET . '</td></tr>';
					break;

					if (isset($row3['MO_ITM_LN_TND']))
					{
						$IMPORTE = $IMPORTE + $row3['MO_ITM_LN_TND'];
					}
				}
			}
		}

		echo "</table>";
?>
<?php
	}
}

?>    
                </td>
                </tr>
                </table>     
        </td>
        </tr>
        </table>
</td>
</tr>
</table>
 <div id="exportar" style="display:none">
<div id="overlay" style="display:none; z-index:9999"> <span><img src="../images/Preload.GIF" title="loading" width="80px"></span> </div>
</div>
<style>
#exportar {position:absolute;width:100%;height:300%;margin: 0 auto;left: 0;top:0;background-image: url(../images/TranspaBlack72.png);background-repeat: repeat;background-position: left top;z-index:10000;}
#exportar-contenedor{
	position:absolute;
	left: 340px;
	top:40px;
	width:auto;
	min-width:300px;
	height:auto;
	overflow:visible;
	padding:20px;
	background-color:#F1F1F1;
	-khtml-border-radius: 6px;
	-moz-border-radius: 6px;
	-webkit-border-radius: 6px;
	border-radius: 6px;
	background-image: url(../images/ARMS.png); 
	background-repeat: no-repeat; 
	background-position: 20px 10px; 
	}
#exportar-contenedor h3{
	margin-top:50px;
}

#exportar-contenedor td{
	padding:4px 6px;
}
#overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        text-align: center;
        background-color: #000;

        filter: alpha(opacity=50);
        -moz-opacity: 0.5;
        opacity: 0.5;
    }
    #overlay span {
        padding: 50px;
        border-radius: 5px;
        color: #000;
        background-color: #fff;
        position: relative;
        top: 50%;
        font-size: 40px;
        padding-top: 80px;
    }
</style>
<script>
function reprocesar()
{
	var contenedor = document.getElementById("exportar");
	contenedor.style.display = "block";
	window.scrollTo(0,0);
	$("#overlay").css("display","block");
	var dataString ='OPC=1';
	$.ajax({
		type: "GET",
		url: "process_tlog.php",
		data: dataString,
		cache: false,
		success: function(response)
		{
			var contenedor = document.getElementById("exportar");
			contenedor.style.display = "none";
			$("#overlay").css("display","none");
			$("#mensaje").html('<div id="GMessaje" onClick="QuitarGMessage();"><a id="mens" href="javascript: void(0)" onClick="QuitarGMessage();" style="color:#111111;">'+response+'</a></div>');
		}
	})
}
</script>
</body>

</html>
<?php
sqlsrv_close($ARTS_EC); ?>