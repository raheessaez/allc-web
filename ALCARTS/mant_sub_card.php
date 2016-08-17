<?php
include ("session.inc");

?>

<?php
include ("headerhtml.inc");

?>

<?php
$PAGINA = 3184;
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
{
?>

<script language="JavaScript">

function validaingreso(theForm){

	

		if (theForm.CARD_ID.value == ""){

			alert("COMPLETE EL CAMPO REQUERIDO.");

			theForm.CARD_ID.focus();

			return false;

	    }

        if (theForm.CARD_DESC.value == ""){

            alert("COMPLETE EL CAMPO REQUERIDO.");

            theForm.CARD_DESC.focus();

            return false;

        }



} //validaingreso(theForm)





</script>

<?php
}
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
	echo $ELMSJ;
?></a></div>

<?php
}
?>

        <table width="100%">

        <tr>
        	<td>

         <h2><?php
echo $LAPAGINA;
?></h2>

                

                

<?php
if ($LIST == 1)
{
?>

<?php
}
?>

             <table style="margin:10px 20px; ">

                <tr>

                <td>
<?php
if ($LIST == 1)
{
?>

                <?php
	$CONSULTA = "SELECT COUNT(*) AS CUENTA FROM SUB_CARD_PLAN_ID";
	// echo $CONSULTA;
	$RS = sqlsrv_query($conn, $CONSULTA);
	// oci_execute($RS);
	if ($row = sqlsrv_fetch_array($RS))
	{
		$TOTALREG = $row['CUENTA'];
		$NUMTPAG = round($TOTALREG / $CTP, 0);
		$RESTO = $TOTALREG % $CTP;
		$CUANTORESTO = round($RESTO / $CTP, 0);
		if ($RESTO > 0 and $CUANTORESTO == 0)
		{
			$NUMTPAG = $NUMTPAG + 1;
		}
		$NUMPAG = round($LSUP / $CTP, 0);
		if ($NUMTPAG == 0)
		{
			$NUMTPAG = 1;
		}
	}
	$CONSULTA = "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY " . $CTP . " ORDER BY CARD_ID ASC) ROWNUMBER FROM SUB_CARD_PLAN_ID ) AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN " . $LINF . " AND " . $LSUP . "";
	$RS = sqlsrv_query($conn, $CONSULTA);
	// oci_execute($RS);
?>

                <table id="Listado">

                <tr>

                    <th>ID Subvariedad</th>

                    <th>Card Plan Asociado</th>

                   

                </tr>

                <?php
	while ($row = sqlsrv_fetch_array($RS))
	{
		$ID = $row["ID"];
		$CARD_ID = $row["CARD_ID"];
		$DESC_SUB = $row["DESC_SUB"];
?>

                <tr>

                <?php
		if ($SESPUBLICA == 1)
		{
?>

                    <td ><a href="mant_sub_card.php?ACT=<?php
			echo $ID;
?>"><?php
			echo $DESC_SUB;
?></a></td>

                    <?php
		}
		else
		{
?>

                     <td><?php
			echo $DESC_SUB;
?>%</td>

                    <?php
		}
?>

                    <td><?php
		echo $CARD_ID;
?></td>

                </tr>



                <?php
	}
?>

                <tr>

                    <td colspan="4" nowrap style="background-color:transparent">

                    <?php
	if ($LINF >= $CTP + 1)
	{
		$ATRAS = $LINF - $CTP;
		$FILA_ANT = $LSUP - $CTP;
?>

                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('mant_sub_card.php?LSUP=<?php
		echo $FILA_ANT;
?>&LINF=<?php
		echo $ATRAS;
?>&BDTARJ=<?php
		echo $BDTARJ;
?>');">

                    <?php
	}
	if ($LSUP <= $TOTALREG)
	{
		$ADELANTE = $LSUP + 1;
		$FILA_POS = $LSUP + $CTP;
?>

                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('mant_sub_card.php?LSUP=<?php
		echo $FILA_POS;
?>&LINF=<?php
		echo $ADELANTE;
?>&BDTARJ=<?php
		echo $BDTARJ;
?>');">

                    <?php
	}
?>

                    <span style="vertical-align:baseline;">P&aacute;gina <?php
	echo $NUMPAG;
?> de <?php
	echo $NUMTPAG;
?></span>

                    </td>

                </tr>

                </table>

<?php
	sqlsrv_close($conn);
}
?>



         <?php
if ($NEO == 1)
{
?>

                <table id="forma-registro">

                        <form action="mant_sub_card_reg.php" method="post" name="forming" id="forming" onSubmit="return validaingreso(this)">

                    <tr>

                        <td> <label for="DESC_SUB">C&oacute;digo Subvariedad</label> </td>

                        <td><input name="DESC_SUB" type="text" size="4" maxlength="2"></td>

                    </tr>



                    <tr>

                        <td> <label for="CARD_ID">Plan de Tarjeta</label> </td>

                        <td>
                        <select name="CARD_ID">
                            <option value="no_sel">Seleccione</option>
                            <?php
	$r = "";
	$CRD = "SELECT * FROM CO_CARD_PLAN";
	$RESC = sqlsrv_query($conn, $CRD);
	// oci_execute($RESC);
	while ($RW1 = sqlsrv_fetch_array($RESC))
	{
		$r.= '<option value="' . $RW1["CARD_ID"] . '">' . $RW1["CARD_ID"] . ' - ' . $RW1["CARD_DESC"] . '</option>';
	}
	echo $r;
?>

                        </select>
                        </td>

                    </tr>



                        <tr>

                           <td></td>

                           <td><input name="INGRESAR" type="submit" value="Registrar">

                            <input name="LIMPIAR" type="reset" value="Limpiar">

                            <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_sub_card.php')"></td>

                        </tr>



                        </form>

                </table>

<?php
	sqlsrv_close($conn);
}
?>



    <?php
if ($ACT <> "")
{
	$CONSULTA = "SELECT * FROM SUB_CARD_PLAN_ID WHERE ID='" . $ACT . "'";
	$RS = sqlsrv_query($conn, $CONSULTA);
	// oci_execute($RS);
	if ($row = sqlsrv_fetch_array($RS))
	{
		$ID = $row['ID'];
		$CARD_ID = $row['CARD_ID'];
		$DESC_SUB = $row['DESC_SUB'];
	}
?>

                <p class="speech">Subvariedad <?php echo $ID ?></p>
               	<h3>Actualizar Subvariedad Card Plan</h3>

                <table id="forma-registro">

                    <form action="mant_sub_card_reg.php" method="post" name="formact" onSubmit="return validaingreso(this)">
                    <input name="ID" type="hidden" value="<?php
	echo $ACT;
?>">
                    
                     <tr>

                        <td> <label for="DESC_SUB">C&oacute;digo Subvariedad</label> </td>

                        <td><input name="DESC_SUB" type="text" size="4" maxlength="2" value="<?php
	echo $DESC_SUB;
?>"></td>

                    </tr>

                     <tr>

                        <td> <label for="CARD_ID">Plan de Tarjeta</label> </td>

                        <td>
                        <select name="CARD_ID">
                            <option value="no_sel">Seleccione</option>
                            <?php
	$r = "";
	$CRD = "SELECT * FROM CO_CARD_PLAN";
	$RESC = sqlsrv_query($conn, $CRD);
	// oci_execute($RESC);
	while ($RW1 = sqlsrv_fetch_array($RESC))
	{
		if ($RW1["CARD_ID"] == $CARD_ID)
		{
			$r.= '<option value="' . $RW1["CARD_ID"] . '" selected>' . $RW1["CARD_ID"] . ' - ' . $RW1["CARD_DESC"] . '</option>';
		}
		else
		{
			$r.= '<option value="' . $RW1["CARD_ID"] . '">' . $RW1["CARD_ID"] . ' - ' . $RW1["CARD_DESC"] . '</option>';
		}
	}
	echo $r;
?>

                        </select>
                        </td>

                    </tr>

                    <tr>

                        <td>

                        <td>

                        <input name="ACTUALIZAR" type="submit" value="Actualizar">

                        <input name="ELIMINAR" type="button" value="Eliminar" onClick="javascript:pagina('mant_sub_card_reg.php?ELM=1&ID=<?php
	echo $ACT;
?>')">

                        <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_sub_card.php')">

                        </td>

                    </tr>

                    </form>

                </table>
<?php
	sqlsrv_close($conn);
}
?> 
                </td>

                </tr>

                </table>

</td>
</tr>
</table>
</table>
</body>

</html>

