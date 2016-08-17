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
		return "US $".$INT_VAL . "." . $DEC_VAL;
	}
	else
	{
		return $VAL;
	}
}

$PAGINA = 2182;
$NOMENU = 1;
$LIST = @$_GET["LIST"];
$NEO = @$_GET["NEO"];
$ACT = @$_GET["ACT"];

if ($NEO == "" and $ACT == "")
{
	$LIST = 1;
}

?>

<?php

if ($LIST <> 1)
{ ?>
<script language="JavaScript">
function validaingreso(theForm){
	
		if (theForm.ID_TND.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.ID_TND.focus();
			return false;
	}

		if (theForm.TY_TND.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.TY_TND.focus();
			return false;
	}

		if (theForm.DE_TND.value == 0){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.DE_TND.focus();
			return false;
	}



} //validaingreso(theForm)


</script>
<?php
} ?>
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
 
<div id="GMessaje" onClick="QuitarGMessage();"><a href="#" onClick="QuitarGMessage();" style="color:#111111;"><?php echo $ELMSJ
?></a></div>
<?php
} ?>
<div id="mensaje"> </div>
        <table width="100%">
        <tr><td>
        
                <h2><?php echo $LAPAGINA
?></h2>
                <table style="margin:10px 20px; ">
                <tr>
                <td>          
                <?php
$CONSULTA4 = "select distinct STR_CD from LE_STR_REC_TOT";
$RS4 = sqlsrv_query($conn, $CONSULTA4);
?>
                 <table>
                <tr>
                <?php
$contador = 0;
$STYLE = "";

while ($row4 = sqlsrv_fetch_array($RS4))
{
	$CONSULTA = "SELECT top 1 * FROM  le_Str_rec_tot where str_cd in(select STR_CD from LE_STR_REC_TOT where STR_CD=" . $row4["STR_CD"] . ") order by TM_STP desc;";
	$RS = sqlsrv_query($conn, $CONSULTA);

	// //oci_execute($RS);

?>
               
                <?php
		$FLAG_REPROCESO=0;
	if ($row = sqlsrv_fetch_array($RS))
	{
		$ID_STR_REC_TOT = $row['ID_STR_REC_TOT'];
		$STR_CD = $row['STR_CD'];
		$TM_STP_DB = $row['TM_STP'];
		$TM_STP = date_format($TM_STP_DB, "d/m/Y");
		$PRD_TM_STP_DB = $row['PRD_TM_STP'];
		$PRD_TM_STP = date_format($PRD_TM_STP_DB, "d/m/Y");
		$LON_TND_AMT_CSH = $row['LON_TND_AMT_CSH'];
		$LON_TND_AMT_CHK = $row['LON_TND_AMT_CHK'];
		$LON_TND_AMT_FDS = $row['LON_TND_AMT_FDS'];
		$LON_TND_AMT_MSC1 = $row['LON_TND_AMT_MSC1'];
		$LON_TND_AMT_MSC2 = $row['LON_TND_AMT_MSC2'];
		$LON_TND_AMT_MSC3 = $row['LON_TND_AMT_MSC3'];
		$LON_TND_AMT_MF_CPN = $row['LON_TND_AMT_MF_CPN'];
		$LON_TND_AMT_STR_CPN = $row['LON_TND_AMT_STR_CPN'];
		$PKP_TND_AMT_CSH = $row['PKP_TND_AMT_CSH'];
		$PKP_TND_AMT_CHK = $row['PKP_TND_AMT_CHK'];
		$PKP_TND_AMT_FDS = $row['PKP_TND_AMT_FDS'];
		$PKP_TND_AMT_MSC1 = $row['PKP_TND_AMT_MSC1'];
		$PKP_TND_AMT_MSC2 = $row['PKP_TND_AMT_MSC2'];
		$PKP_TND_AMT_MSC3 = $row['PKP_TND_AMT_MSC3'];
		$PKP_TND_AMT_MF_CPN = $row['PKP_TND_AMT_MF_CPN'];
		$PKP_TND_AMT_STR_CPN = $row['PKP_TND_AMT_STR_CPN'];
		$CNTD_TND_AMT_CSH = $row['CNTD_TND_AMT_CSH'];
		$CNTD_TND_AMT_CHK = $row['CNTD_TND_AMT_CHK'];
		$CNTD_TND_AMT_FDS = $row['CNTD_TND_AMT_FDS'];
		$CNTD_TND_AMT_MSC1 = $row['CNTD_TND_AMT_MSC1'];
		$CNTD_TND_AMT_MSC2 = $row['CNTD_TND_AMT_MSC2'];
		$CNTD_TND_AMT_MSC3 = $row['CNTD_TND_AMT_MSC3'];
		$CNTD_TND_AMT_MF_CPN = $row['CNTD_TND_AMT_MF_CPN'];
		$CNTD_TND_AMT_STR_CPN = $row['CNTD_TND_AMT_STR_CPN'];
		$NT_TND_AMT_CSH = $row['NT_TND_AMT_CSH'];
		$NT_TND_AMT_CHK = $row['NT_TND_AMT_CHK'];
		$NT_TND_AMT_FDS = $row['NT_TND_AMT_FDS'];
		$NT_TND_AMT_MSC1 = $row['NT_TND_AMT_MSC1'];
		$NT_TND_AMT_MSC2 = $row['NT_TND_AMT_MSC2'];
		$NT_TND_AMT_MSC3 = $row['NT_TND_AMT_MSC3'];
		$NT_TND_AMT_MF_CPN = $row['NT_TND_AMT_MF_CPN'];
		$NT_TND_AMT_STR_CPN = $row['NT_TND_AMT_STR_CPN'];
		$OPN_TND_AMT_CSH = $row['OPN_TND_AMT_CSH'];
		$OPN_TND_AMT_CHK = $row['OPN_TND_AMT_CHK'];
		$OPN_TND_AMT_FDS = $row['OPN_TND_AMT_FDS'];
		$OPN_TND_AMT_MSC1 = $row['OPN_TND_AMT_MSC1'];
		$OPN_TND_AMT_MSC2 = $row['OPN_TND_AMT_MSC2'];
		$OPN_TND_AMT_MSC3 = $row['OPN_TND_AMT_MSC3'];
		$OPN_TND_AMT_MF_CPN = $row['OPN_TND_AMT_MF_CPN'];
		$OPN_TND_AMT_STR_CPN = $row['OPN_TND_AMT_STR_CPN'];
		$TOT_CSH = $LON_TND_AMT_CSH + $PKP_TND_AMT_CSH + $CNTD_TND_AMT_CSH + $NT_TND_AMT_CSH + $OPN_TND_AMT_CSH;
		$TOT_CHK = $LON_TND_AMT_CHK + $PKP_TND_AMT_CHK + $CNTD_TND_AMT_CHK + $NT_TND_AMT_CHK + $OPN_TND_AMT_CHK;
		$TOT_FDS = $LON_TND_AMT_FDS + $PKP_TND_AMT_FDS + $CNTD_TND_AMT_FDS + $NT_TND_AMT_FDS + $OPN_TND_AMT_FDS;
		$TOT_MSC1 = $LON_TND_AMT_MSC1 + $PKP_TND_AMT_MSC1 + $CNTD_TND_AMT_MSC1 + $NT_TND_AMT_MSC1 + $OPN_TND_AMT_MSC1;
		$TOT_MSC2 = $LON_TND_AMT_MSC2 + $PKP_TND_AMT_MSC2 + $CNTD_TND_AMT_MSC2 + $NT_TND_AMT_MSC2 + $OPN_TND_AMT_MSC2;
		$TOT_MSC3 = $LON_TND_AMT_MSC3 + $PKP_TND_AMT_MSC3 + $CNTD_TND_AMT_MSC3 + $NT_TND_AMT_MSC3 + $OPN_TND_AMT_MSC3;
		$TOT_MF_CPN = $LON_TND_AMT_MF_CPN + $PKP_TND_AMT_MF_CPN + $CNTD_TND_AMT_MF_CPN + $NT_TND_AMT_MF_CPN + $OPN_TND_AMT_MF_CPN;
		$TOT_STR_CPN = $LON_TND_AMT_STR_CPN + $PKP_TND_AMT_STR_CPN + $CNTD_TND_AMT_STR_CPN + $NT_TND_AMT_STR_CPN + $OPN_TND_AMT_STR_CPN; 
		$TOTAL = $TOT_CSH + $TOT_CHK + $TOT_FDS + $TOT_MSC1 + $TOT_MSC2 + $TOT_MSC3 + $TOT_MF_CPN + $TOT_STR_CPN;
		$TM_END = date_format($TM_STP_DB, "m/d/Y");
		$TODAY = date("m/d/Y");		
		
		$SQL2 = "SELECT COD_TIENDA, DES_TIENDA, DES_CLAVE FROM MN_TIENDA WHERE COD_TIENDA=" . $STR_CD;
		$RS2 = sqlsrv_query($maestra, $SQL2);
		if ($row2 = sqlsrv_fetch_array($RS2))
		{
			$TIENDA = $row2["DES_TIENDA"];
		}

		$IMPORTE = 0;
		$S2 = "SELECT * FROM TR_TRN WHERE TS_TRN_END BETWEEN '" . $TM_END . " 00:00:00' AND '" . $TODAY . " 23:59:59'";
		$RS2 = sqlsrv_query($conn, $S2);
		while ($row2 = sqlsrv_fetch_array($RS2))
		{
			$S3 = "SELECT * FROM TR_LTM_TND WHERE ID_TRN=" . $row2["ID_TRN"];
			$RS3 = sqlsrv_query($conn, $S3);

			// oci_execute($RS2);

			if ($row3 = sqlsrv_fetch_array($RS3))
			{
				if (isset($row3['MO_ITM_LN_TND']))
				{
					$IMPORTE = $IMPORTE + $row3['MO_ITM_LN_TND'];
				}
			}

			if ($IMPORTE < 0)
			{
				$COLORTRX = "; color: #ED686E";
				$NO_DEVS = 1;
			}
		}

		$SQL_SUMA = "SELECT SUM(GS_PLS) AS SUM_GS FROM LE_IND_REC_TOT WHERE STR_CD=" . $STR_CD . " AND REC_TYP=2";
		$RS_SUMA = sqlsrv_query($conn, $SQL_SUMA);
		if ($ROW_SUMA = sqlsrv_fetch_array($RS_SUMA))
		{
			$SUM_GS = $ROW_SUMA["SUM_GS"];
		}

		$SQL_RESTA = "SELECT GS_MNS FROM LE_IND_REC_TOT WHERE STR_CD=" . $STR_CD . " AND REC_TYP=2";
		$RS_RESTA = sqlsrv_query($conn, $SQL_RESTA);
		if ($ROW_RESTA = sqlsrv_fetch_array($RS_RESTA))
		{
			$GS_MNS = $ROW_RESTA["GS_MNS"];
		}
		
		$FECHA_LE_STR_INI = date_format($TM_STP_DB, "m/d/Y H:i");
		//SUMA  5 MINUTO
		$FECHA_LE_STR_I = date_format($TM_STP_DB, "i");
		$FECHA_LE_STR_I = $FECHA_LE_STR_I+5;
		$FECHA_LE_STR_TER=date_format($TM_STP_DB, "m/d/Y H:".$FECHA_LE_STR_I);
		$ESTADO_TIENDA=1;
		$CONSULTA_STS = "SELECT * FROM FE_MESSAGE WHERE MESSAGE_NUMBER = 223 AND EVENT_DATE BETWEEN '".$FECHA_LE_STR_INI."' AND '".$FECHA_LE_STR_TER."'";
		$RS_STS = sqlsrv_query($EYES, $CONSULTA_STS);
		if ($ROW_STS = sqlsrv_fetch_array($RS_STS))
		{
			$ESTADO_TIENDA=0;
		}
		$TOTAL_VENTAS = $SUM_GS - $GS_MNS;
		if ($IMPORTE != $TOTAL_VENTAS and $ESTADO_TIENDA==1)
		{
			$FLAG_REPROCESO=1;
			$STYLE = 'style="background-color:rgba(225, 29, 29, 0.58);color:#fff"';
		}
		if($ESTADO_TIENDA==1)
		{
			$ESTADO_TIENDA="Abierta";
		}
		else
		{
			$ESTADO_TIENDA="Cerrada";
		}

?>
                     <form action="cuadratura.php?LIST=1" method="post" name="frmsel<?php echo $ID_STR_REC_TOT
?>" id="frmsel<?php echo $ID_STR_REC_TOT
?>">Okas
                            <td onClick="document.forms.frmsel<?php echo $ID_STR_REC_TOT
?>.submit();">
                            	<div id="SelArticulos" <?php echo $STYLE ?>>
                                	<p style="font-weight:600; font-size:12pt"><?php echo $TIENDA ?></p>
                                    <?php if($ESTADO_TIENDA==1)
									{ 
									?>
									<p>Registro en Controlador: <?php echo DOLARS($TOTAL_VENTAS) ?></p>
									<p>Registro en SUITE: <?php echo DOLARS($IMPORTE) ?></p>
                                    <?php 
									}
									else
									{ 
									?>
									<p>Periodo Cerrado</p>
                                    <?php 
									}
									?>
                                	<input type="hidden" name="STR_CD" value="<?php echo $STR_CD ?>">
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
	if (isset($_POST["STR_CD"]))
	{
		$STR_CD = $_POST["STR_CD"];
		$CONSULTA_LIST = "SELECT * FROM  le_Str_rec_tot where str_cd in(select STR_CD from LE_STR_REC_TOT where STR_CD=" . $STR_CD . " ) order by TM_STP desc;";
		$RS_LIST = sqlsrv_query($conn, $CONSULTA_LIST);
?>
	<?php if($FLAG_REPROCESO==1)
	{?>
 <input type="button" value="Reprocesar Transacciones Fallidas" style="margin-left:5px" onClick="reprocesar()">
 <?php }?>
        <h3>Detalle Oficina</h3>
          <table id="Listado">
                <tr>
                  <th>Fecha Apertura Periodo</th>
                  <th>Bruto a favor</th>
                  <th>Bruto en Contra</th>
                  <th>Dotaciones</th>
                  <th>Monto neto (Monto neto en negativo por dotaciones a operadores)</th>
                </tr>
        <?php
		while ($ROW_LIST = sqlsrv_fetch_array($RS_LIST))
		{
			$TM_STP_DB = $row['TM_STP'];
			$TM_STP = date_format($TM_STP_DB, "d/m/Y");
			echo "<tr>";
			echo '<td>' . $TM_STP . '</td>';
			echo '<td>' . DOLARS($ROW_LIST["GS_PLS"]) . '</td>';
			echo '<td>' . DOLARS($ROW_LIST["GS_MNS"]) . '</td>';
			echo '<td>' . DOLARS($ROW_LIST["LON_TND_AMT_CSH"]) . '</td>';
			echo '<td>' . DOLARS($ROW_LIST["NT_TND_AMT_CSH"]) . '</td></tr>';
		}

		echo "</table>";
?>
	 <h3>Detalle Movimientos</h3>
          <table id="Listado">
                <tr>
                  <th>Tipo Movimiento</th>
                  <th>Cuenta</th>
                  <th>Monto</th>
                </tr>
        <?php
		$CONSULTA_OPERADOR = "SELECT * FROM  le_tnd_rec_tot where str_cd in(select STR_CD from LE_STR_REC_TOT where STR_CD=" . $STR_CD . " ) order by ACNT_ID,REC_TYP asc;";
		$RS_OPERADOR = sqlsrv_query($conn, $CONSULTA_OPERADOR);
		while ($ROW_OPERADOR = sqlsrv_fetch_array($RS_OPERADOR))
		{
			$TM_STP_DB = $row['TM_STP'];
			$TM_STP = date_format($TM_STP_DB, "d/m/Y");
			if ($ROW_OPERADOR["ACNT_ID"] == 0)
			{
				$ACNT_ID = "TIENDA";
			}
			else
			{
				$ACNT_ID = "Operador: " . $ROW_OPERADOR["ACNT_ID"];
			}

			switch ($ROW_OPERADOR["REC_TYP"])
			{
			case 4:
				echo "<tr>";
				echo '<td>Dotaci&oacute;n</td>';
				echo '<td>' . $ACNT_ID . '</td>';
				echo '<td>' . DOLARS($ROW_OPERADOR["TND_AMT_CSH_1"]) . '</td></tr>';
				break;

			case 5:
				echo "<tr>";
				echo '<td>Retiros</td>';
				echo '<td>' . $ACNT_ID . '</td>';
				echo '<td>' . DOLARS($ROW_OPERADOR["TND_AMT_CSH_1"]) . '</td></tr>';
				break;

			case 7:
				echo "<tr>";
				echo '<td>Monto Neto</td>';
				echo '<td>' . $ACNT_ID . '</td>';
				echo '<td>' . DOLARS($ROW_OPERADOR["TND_AMT_CSH_1"]) . '</td></tr>';
				break;
			}
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
		$RS = sqlsrv_query($conn, $CONSULTA);
		if ($row = sqlsrv_fetch_array($RS))
		{
			$TM_STP_DB = $row['TM_STP'];
			$TM_END = date_format($TM_STP_DB, "m/d/Y");
			$TODAY = date("m/d/Y");
			$ELTICKET="";
			$S2 = "SELECT * FROM TR_TRN WHERE TS_TRN_END BETWEEN '" . $TM_END . " 00:00:00' AND '" . $TODAY . " 23:59:59'";
			
			$RS2 = sqlsrv_query($conn, $S2);
			while ($row2 = sqlsrv_fetch_array($RS2))
			{
				$AI_TRN=$row2["AI_TRN"];
				$ID_TRN=$row2["ID_TRN"];
				$ELTICKET=$AI_TRN;
				$S_INVC="SELECT * FROM TR_INVC WHERE ID_TRN=".$ID_TRN;
				$RS_INVC = sqlsrv_query($conn, $S_INVC);
				if ($row_INVC = sqlsrv_fetch_array($RS_INVC)) {
					$INVC_NMB = $row_INVC['INVC_NMB'];
				}
				if(!empty($INVC_NMB)){ $ESFACT=1;}
				if($ESFACT==1){
					$ELTICKET=$AI_TRN." / ".$INVC_NMB; //CAMBIA TICKET POR NÚMERO DE FACTURA
				}
				$ID_WS = $row2['ID_WS'];
				$TERMINAL="NR";
				$S_TERMINAL="SELECT CD_WS FROM AS_WS WHERE ID_WS=".$ID_WS;
				$RS_TERMINAL = sqlsrv_query($conn, $S_TERMINAL);
				//oci_execute($RS2);
				if ($row_TERMINAL = sqlsrv_fetch_array($RS_TERMINAL)) {
					$TERMINAL = $row_TERMINAL['CD_WS'];
				}
				$TERMINAL_F="0000".$TERMINAL;
				$TERMINAL_F=substr($TERMINAL_F, -4);
				
				$TIPO_MEDPAGO="NR";
				$S_MPAGO="SELECT ID_TND  FROM TR_LTM_TND WHERE ID_TRN=".$ID_TRN." GROUP BY ID_TND ";
				$RS_MPAGO = sqlsrv_query($conn, $S_MPAGO);
				//oci_execute($RS2);
				$MEDIODEPAGO="";
				while ($row_MPAGO = sqlsrv_fetch_array($RS_MPAGO)) {
					$ID_TND = $row_MPAGO['ID_TND'];
					$S_MPAGO_="SELECT DE_TND FROM AS_TND WHERE ID_TND=".$ID_TND;
					$RS_MPAGO_ = sqlsrv_query($conn, $S_MPAGO_);
					//oci_execute($RS3);
					if ($row_MPAGO_ = sqlsrv_fetch_array($RS_MPAGO_)) { $MEDIODEPAGO = $MEDIODEPAGO." ".$row_MPAGO_['DE_TND']."/ "; }
					if(empty($MEDIODEPAGO)) {$MEDIODEPAGO="NO DEFINIDO:";}
				}	
				$TIPO_MEDPAGO = $MEDIODEPAGO;
				
				$IMPORTE=0;
				$S_IMPORTE="SELECT SUM((CASE FL_IS_CHNG  WHEN 1 THEN (-1) ELSE (1) END)* MO_ITM_LN_TND) AS SUMAIMPORTE  FROM TR_LTM_TND WHERE ID_TRN=".$ID_TRN;
				$RS_IMPORTE = sqlsrv_query($conn, $S_IMPORTE);
				//oci_execute($RS2);
				if ($row_IMPORTE = sqlsrv_fetch_array($RS_IMPORTE)) { $IMPORTE = $row_IMPORTE['SUMAIMPORTE']; }
				
				$IMPORTE=$IMPORTE/$DIVCENTS;
				
				$FECHA_TICKET = $row2['TS_TRN_END'];
				$TS_TICKET = date_format($FECHA_TICKET,"d/m/Y");
				
				
				$ID_OPR = $row2['ID_OPR'];
				$OPERADOR="NR";
				$S_OPERADOR="SELECT CD_OPR FROM PA_OPR WHERE ID_OPR=".$ID_OPR;
				$RS_OPERADOR = sqlsrv_query($conn, $S_OPERADOR);
				//oci_execute($RS2);
				if ($row_OPERADOR = sqlsrv_fetch_array($RS_OPERADOR)) {
					$OPERADOR = $row_OPERADOR['CD_OPR'];
				}
				$OPERADOR_F="00000000".$OPERADOR;
				$OPERADOR_F=substr($OPERADOR_F, -8); 
				
				
				$S3 = "SELECT * FROM TR_LTM_TND WHERE ID_TRN=" . $row2["ID_TRN"];
				$RS3 = sqlsrv_query($conn, $S3);
				while ($row3 = sqlsrv_fetch_array($RS3))
				{
					echo "<tr>";
					echo '<td>'.$ELTICKET.'</td>';
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
sqlsrv_close($conn); ?>
