<?php
include ("session.inc");
 ?>

<?php
include ("headerhtml.inc");
 ?>

<?php
$PAGINA = 1184;
$LIST = @$_GET["LIST"];
$NEO = @$_GET["NEO"];
$ACT = @$_GET["ACT"];

if ($NEO == "" and $ACT == "")
{
	$LIST = 1;
}

$BDTARJ = trim(strtoupper(@$_POST["BDTARJ"]));

if (empty($BDTARJ))
{
	$BDTARJ = trim(strtoupper(@$_GET["BDTARJ"]));
}

if ($BDTARJ <> "")
{
	$FLT_TARJ = " AND CARD_DESC Like '%" . strtoupper($BDTARJ) . "%' ";
}

?>



<?php

if ($LIST <> 1)
{ ?>

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

<div id="GMessaje" onClick="QuitarGMessage();"><a href="#" onClick="QuitarGMessage();" style="color:#111111;"><?php
	echo $ELMSJ ?></a></div>

<?php
} ?>

        <table width="100%">

        <tr>
        	<td>

         <h2><?php echo $LAPAGINA
?></h2>

                

                

<?php

if ($LIST == 1)
{
?>

                <table width="100%" id="Filtro">

                <tr>

                <td>

                <form action="mant_cardplan.php" method="post" name="frmbuscar" id="frmbuscar">

                        <label for="BDTARJ" style="margin:8px 4px; font-weight:600; clear:left">Tarjeta </label>

                        <input style="text-transform:uppercase" name="BDTARJ" type="text"  id="BDTARJ" value="<?php
	echo $BDTARJ ?>" size="14" maxlength="40">

                        <input name="BUSCAR" type="submit" id="BUSCAR" value="Buscar Tarjeta">

                        <input name="RECARGAR" type="button" id="RECARGAR" value="recargar" onClick="pagina('mant_cardplan.php');">

                </form>

              </td>

              </tr>

              </table>

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
	$CONSULTA = "SELECT COUNT(*) AS CUENTA FROM CO_CARD_PLAN WHERE CARD_ID <> '0' " . $FLT_TARJ . " ";

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

	$CONSULTA = "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY " . $CTP . " ORDER BY CARD_ID ASC) ROWNUMBER FROM CO_CARD_PLAN WHERE CARD_ID <> '0'  " . $FLT_TARJ . ") AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN " . $LINF . " AND " . $LSUP . "";
	$RS = sqlsrv_query($conn, $CONSULTA);

	// oci_execute($RS);

?>

                <table id="Listado">

                <tr>

                    <th>Card Plan ID</th>

                    <th>Tarjeta</th>

                   

                </tr>

                <?php
	while ($row = sqlsrv_fetch_array($RS))
	{
		$CARD_ID = $row['CARD_ID'];
		$CARD_DESC = $row['CARD_DESC'];
?>

                <tr>

                <?php
		if ($SESPUBLICA == 1)
		{ ?>

                    <td ><a href="mant_cardplan.php?ACT=<?php
			echo $CARD_ID ?>"><?php
			echo $CARD_ID ?></a></td>

                    <?php
		}
		else
		{ ?>

                     <td><?php
			echo $CARD_ID ?>%</td>

                    <?php
		} ?>

                    <td><?php
		echo $CARD_DESC ?></td>

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

                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('mant_cardplan.php?LSUP=<?php
		echo $FILA_ANT ?>&LINF=<?php
		echo $ATRAS ?>&BDTARJ=<?php
		echo $BDTARJ ?>');">

                    <?php
	}

	if ($LSUP <= $TOTALREG)
	{
		$ADELANTE = $LSUP + 1;
		$FILA_POS = $LSUP + $CTP;
?>

                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('mant_cardplan.php?LSUP=<?php
		echo $FILA_POS ?>&LINF=<?php
		echo $ADELANTE ?>&BDTARJ=<?php
		echo $BDTARJ ?>');">

                    <?php
	} ?>

                    <span style="vertical-align:baseline;">P&aacute;gina <?php
	echo $NUMPAG ?> de <?php
	echo $NUMTPAG ?></span>

                    </td>

                </tr>

                </table>

<?php
	sqlsrv_close($conn);
}

?>



         <?php

if ($NEO == 1)
{ ?>

                <table id="forma-registro">

                        <form action="mant_cardplan_reg.php" method="post" name="forming" id="forming" onSubmit="return validaingreso(this)">

                    <tr>

                        <td> <label for="CARD_ID">Card Plan ID</label> </td>

                        <td><input name="CARD_ID" type="text" size="2" maxlength="2"></td>

                    </tr>



                    <tr>

                        <td> <label for="CARD_DESC">Descripci&oacuten Tarjeta</label> </td>

                        <td><input name="CARD_DESC" type="text" size="30" maxlength="30"></td>

                    </tr>



                        <tr>

                           <td></td>

                           <td><input name="INGRESAR" type="submit" value="Registrar">

                            <input name="LIMPIAR" type="reset" value="Limpiar">

                            <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_cardplan.php')"></td>

                        </tr>



                        </form>

                </table>

                <script>

                document.forming.CARD_ID.focus();

                </script>

<?php
	sqlsrv_close($conn);
}

?>



    <?php

if ($ACT <> "")
{
	$CONSULTA = "SELECT * FROM CO_CARD_PLAN WHERE CARD_ID='" . $ACT . "'";
	$RS = sqlsrv_query($conn, $CONSULTA);

	// oci_execute($RS);

	if ($row = sqlsrv_fetch_array($RS))
	{
		$CARD_ID = $row['CARD_ID'];
		$CARD_DESC = $row['CARD_DESC'];
	}

?>

                <h3>Actualizar Card Plan ID (<?php echo $ACT
?>")</h3>

                <table id="forma-registro">

                    <form action="mant_cardplan_reg.php" method="post" name="formact" onSubmit="return validaingreso(this)">
                    <input name="CARDID" type="hidden" value="<?php
	echo $ACT ?>">
                    
                     <tr>

                        <td> <label for="CARD_ID">Card Plan ID</label> </td>

                        <td><input name="CARD_ID" type="text" size="2" maxlength="2" value="<?php
	echo $CARD_ID ?>"></td>

                    </tr>

                    <tr>

                        <td> <label for="CARD_DESC">Descripci&oacuten Tarjeta</label> </td>

                        <td><input name="CARD_DESC" type="text" size="30" maxlength="30" value="<?php
	echo $CARD_DESC ?>"></td>

                    </tr>

                    <tr>

                        <td>

                        <td>

                        <input name="ACTUALIZAR" type="submit" value="Actualizar">

                        <input name="ELIMINAR" type="button" value="Eliminar" onClick="javascript:pagina('mant_cardplan_reg.php?ELM=1&CARD_ID=<?php echo $ACT ?>')">

                        <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_cardplan.php')">

                        </td>

                    </tr>

                    </form>

                </table>

                <script>

                document.formact.CARD_ID.focus();

                </script>

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


