<?php include("session.inc");?>

<?php include("headerhtml.inc");?>

<?php

	$PAGINA=1178;

	$LIST=@$_GET["LIST"];

	$NEO=@$_GET["NEO"];

	$ACT=@$_GET["ACT"];

	if ($NEO=="" and $ACT=="") {

		 $LIST=1;

	}

?>

<?php if ($LIST<>1) {?>

<script language="JavaScript">

function validaingreso(theForm){

		if (theForm.TP_TARJ.value == ""){

			alert("COMPLETE EL CAMPO REQUERIDO: Identificador.");

			theForm.TP_TARJ.focus();

			return false;

	}

		if (theForm.DESC_TP_TARJ.value == ""){

			alert("COMPLETE EL CAMPO REQUERIDO: Descripcion.");

			theForm.DESC_TP_TARJ.focus();

			return false;

	}

	

} //validaingreso(theForm)

</script>

<?php }?>

<style>

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

</head>

<body>

<?php include("encabezado.php");?>

<?php include("titulo_menu.php");?>

<table width="100%" height="100%">

<tr>

<td align="right"  width="200" bgcolor="#FFFFFF"><?php include("menugeneral.php");?></td> 

<td >

<?php

if ($MSJE==1) {

$ELMSJ="Registro actualizado";

} 

if ($MSJE == 2) {

	$ELMSJ="Registro no disponible, verifique";

} 

if ($MSJE == 3) {

$ELMSJ="Registro realizado";

}

if ($MSJE == 4) {

$ELMSJ="Registro eliminado";

}

if ($MSJE <> "") {

?>

<div id="GMessaje" onClick="QuitarGMessage();"><a href="javascript: void(0)" onClick="QuitarGMessage();" style="color:#111111;"><?=$ELMSJ?></a></div>

<?php }?>

        <table width="100%">

        <tr><td>  

        <h2><?= $LAPAGINA?></h2>

                    

<?php

if ($LIST==1) {

?>

			<table style="margin:10px 20px; ">

                <tr>   

                <td>

    <?PHP

					$CONSULTA="SELECT COUNT(*) AS CUENTA FROM CO_TIPO_TARJETA";

				$RS = sqlsrv_query($conn, $CONSULTA);

				//oci_execute($RS);

				if ($row = sqlsrv_fetch_array($RS))

				{

					$TOTALREG = $row['CUENTA'];

					$NUMTPAG = round($TOTALREG/$CTP,0);

					$RESTO=$TOTALREG%$CTP;

					$CUANTORESTO=round($RESTO/$CTP, 0);

					if($RESTO>0 and $CUANTORESTO==0) 

					{

						$NUMTPAG=$NUMTPAG+1;

					}

					$NUMPAG = round($LSUP/$CTP,0);

					if ($NUMTPAG==0)

					{

						$NUMTPAG=1;

					}

					

					//$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM CO_TIPO_TARJETA ORDER BY TP_TARJ ASC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;

                    $CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY TP_TARJ ASC) ROWNUMBER FROM CO_TIPO_TARJETA) AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";

					$TIENDA=0;

				}

				$RS = sqlsrv_query($conn, $CONSULTA);

				//oci_execute($RS);

               ?>

                <table id="Listado">

                <tr>

                    <th>Identificador</th>

                    <th>Descripci&oacute;n</th>

                </tr>

                <?php

				while ($row = sqlsrv_fetch_array($RS)){

						$TP_TARJ=$row['TP_TARJ'];

                        $DESC_TP_TARJ = $row['DESC_TP_TARJ'];

               ?>

                <tr>

                    <?php if($SESPUBLICA==1) { ?>

                    <td><a href="mant_tarj.php?ACT=<?=$TP_TARJ?>"><?=$TP_TARJ?></a></td>

                    <?php } else {?>

                     <td><?=$TP_TARJ?></td>

                    <?php } ?>

                    <td><?=$DESC_TP_TARJ?></td>

                </tr>

                <?php

				}

				?>

                <tr>

                    <td colspan="11" nowrap style="background-color:transparent">

                    <?php

                    if ($LINF>=$CTP+1) {

						$ATRAS=$LINF-$CTP;

						$FILA_ANT=$LSUP-$CTP;

                   ?>

                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('mant_tarj.php?LSUP=<?=$FILA_ANT?>&LINF=<?=$ATRAS?>');">

                    <?php

                    }

                    if ($LSUP<=$TOTALREG) {

						$ADELANTE=$LSUP+1;

						$FILA_POS=$LSUP+$CTP;

                   ?>

                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('mant_tarj.php?LSUP=<?=$FILA_POS?>&LINF=<?=$ADELANTE?>');">

                    <?php }?>

                    <span style="vertical-align:baseline;">P&aacute;gina <?=$NUMPAG?> de <?=$NUMTPAG?></span>

                    </td>

                </tr>

                </table>

<?php

		sqlsrv_close($conn);

}

?>



                <?php  if ($NEO==1) { ?>

                <table style="margin:10px 20px; ">

                <tr>   

                <td>

                <table id="forma-registro">

                        <form action="mant_tarj_reg.php" method="post" name="forming" id="forming" onSubmit="return validaingreso(this)">

                    <tr>

                        <td> <label for="TP_TARJ">Identificador</label></td>

                        <td><input name="TP_TARJ" type="text" size="4" maxlength="2" onKeyPress="return acceptNum(event);"></td>

                    </tr>

                    <tr>

                        <td> <label for="DESC_TP_TARJ">Descripci&oacute;n</label> </td>

                        <td><input name="DESC_TP_TARJ" type="text" size="22" maxlength="20"></td>

                    </tr>

                        <tr>

                           <td></td>

                           <td><input name="INGRESAR" type="submit" value="Registrar">

                            <input name="LIMPIAR" type="reset" value="Limpiar">

                            <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_tarj.php')"></td>

                        </tr>

                        </form>

                </table>

                <script>

                document.forming.ID_TND.focus();

                </script>

<?php

		sqlsrv_close($conn);

}

if ($ACT<>"") { 

?>

                <table style="margin:10px 20px; ">

                <tr>   

                <td>

			<?php  

				$CONSULTA="SELECT * FROM CO_TIPO_TARJETA WHERE TP_TARJ=".$ACT;

				$RS = sqlsrv_query($conn, $CONSULTA);

				//oci_execute($RS);

				if ($row = sqlsrv_fetch_array($RS)) {

					$TP_TARJ=$row["TP_TARJ"];

					$DESC_TP_TARJ=$row["DESC_TP_TARJ"];

                }

               ?>
				<p class="speech">Tarjeta: <?=$DESC_TP_TARJ?></p>
                <h3>Actualizar Tipo Tarjeta</h3>

                <table id="forma-registro">

                    <form action="mant_tarj_reg.php" method="post" name="formact" onSubmit="return validaingreso(this)" >

                    <tr>

                        <td> <label for="TP_TARJ">Identificador</label><input type="hidden" value="<?=$TP_TARJ?>" name="TP_TARJ_ANTERIOR"></td>

                        <td><input name="TP_TARJ" type="text" size="4" maxlength="2" value="<?=$TP_TARJ?>"  onKeyPress="return acceptNum(event);"></td>

                    </tr>

                    <tr>

                        <td> <label for="DESC_TP_TARJ">Descripci&oacute;n</label> </td>

                        <td><input name="DESC_TP_TARJ" type="text" size="26" maxlength="20" value="<?=$DESC_TP_TARJ?>"></td>

                    </tr>

                  <tr>

                        <td>

                        <td>

                        <input name="ACTUALIZAR" type="submit" value="Actualizar">

                        <?php

						$CONSULTA2="SELECT * FROM CO_TIPO_TARJETA WHERE TP_TARJ=".$ACT;

						$RS2 = sqlsrv_query($conn, $CONSULTA2);

						//oci_execute($RS);
						if ($row2 = sqlsrv_fetch_array($RS2)) {

							$ELIMINAR=1;

						} else {

							$ELIMINAR=0;

						}

						if ($ELIMINAR==1) {

						?>

                        <input name="ELIMINAR" type="button" value="Eliminar" onClick="javascript:pagina('mant_tarj_reg.php?ELM=1&TP_TARJ=<?=$ACT ?>')">

                        <?php } ?>

                        <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_tarj.php')">

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

</td>

</tr>

</table>

</body>