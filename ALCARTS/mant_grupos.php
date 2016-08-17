<?php include("session.inc");?>

<?php include("headerhtml.inc");?>

<?php

	$PAGINA=1181;

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

		if (theForm.ID_GRUPO.value == ""){

			alert("COMPLETE EL CAMPO REQUERIDO: Identificador.");

			theForm.ID_GRUPO.focus();

			return false;

	}

		if (theForm.DESCRIPCION.value == ""){

			alert("COMPLETE EL CAMPO REQUERIDO: Descripcion.");

			theForm.DESCRIPCION.focus();

			return false;

	}

	if (theForm.ULT_COR_GRP.value == ""){

			alert("COMPLETE EL CAMPO REQUERIDO: Correlativo.");

			theForm.ULT_COR_GRP.focus();

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
input.switch:empty
{margin-left: -999px;}
input.switch:empty ~ label
{
position: relative;
float: left;
line-height: 1.6em;
text-indent: 4em;
margin: 0.2em 0;
cursor: pointer;
 -webkit-user-select: none;
 -moz-user-select: none;
 -ms-user-select: none;
 user-select: none;
}
input.switch:empty ~ label:before, 
input.switch:empty ~ label:after
{
position: absolute;
display: block;
top: 0;
bottom: 0;
left: 0;
content: ' ';
width: 3.6em;
background-color: #c33;
border-radius: 0.3em;
box-shadow: inset 0 0.2em 0 rgba(0,0,0,0.3);
-webkit-transition: all 100ms ease-in;
 transition: all 100ms ease-in;
}
input.switch:empty ~ label:after
{
width: 1.4em;
top: 0.1em;
bottom: 0.1em;
margin-left: 0.1em;
background-color: #fff;
border-radius: 0.15em;
box-shadow: inset 0 -0.2em 0 rgba(0,0,0,0.2);
}
input.switch:checked ~ label:before
{
background-color: #393;
}
input.switch:checked ~ label:after
{
margin-left: 2.1em;
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

<div id="GMessaje" onClick="QuitarGMessage();"><a href="#" onClick="QuitarGMessage();" style="color:#111111;"><?=$ELMSJ?></a></div>

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

				$CONSULTA="SELECT COUNT(*) AS CUENTA FROM CO_GRUPO";

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

					//$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM CO_GRUPO ORDER BY ID_GRUPO ASC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;

					$CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY ID_GRUPO ASC) ROWNUMBER FROM CO_GRUPO ) AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";

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

						$ID_GRUPO=$row['ID_GRUPO'];

                        $DESCRIPCION = $row['DESCRIPCION'];

               ?>

                <tr>

                    <?php if($SESPUBLICA==1) { ?>

                    <td><a href="mant_grupos.php?ACT=<?=$ID_GRUPO?>"><?=$ID_GRUPO?></a></td>

                    <?php } else {?>

                     <td><?=$ID_GRUPO?></td>

                    <?php } ?>

                    <td><?=$DESCRIPCION?></td>

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

                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('mant_grupos.php?LSUP=<?=$FILA_ANT?>&LINF=<?=$ATRAS?>');">

                    <?php

                    }

                    if ($LSUP<=$TOTALREG) {

						$ADELANTE=$LSUP+1;

						$FILA_POS=$LSUP+$CTP;

                   ?>

                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('mant_grupos.php?LSUP=<?=$FILA_POS?>&LINF=<?=$ADELANTE?>');">

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

                <form action="mant_grupos_reg.php" method="post" name="forming" id="forming" onSubmit="return validaingreso(this)">

                <table id="forma-registro">

                    <tr>

                        <td> <label for="ID_GRUPO">Identificador</label></td>

                        <td><input name="ID_GRUPO" type="text" size="4" maxlength="2" onKeyPress="return acceptNum(event);"></td>

                    </tr>

                    <tr>

                        <td> <label for="DESCRIPCION">Descripci&oacute;n</label> </td>

                        <td><input name="DESCRIPCION" type="text" size="26" maxlength="200"></td>

                    </tr>

                    <tr>

                        <td> <label for="ULT_COR_GRP">Ultimo Correlativo</label> </td>

                        <td><input id="ULT_COR_GRP" name="ULT_COR_GRP" type="text" size="4" maxlength="2" onKeyPress="return acceptNum(event);" onChange="crear_n(this.value)"></td>

                    </tr>

                    <tr>

                        <td> <label for="IN_EX">Incluye</label> </td>

                        <td><div style="clear: both; margin: 0 10px 0 0;">
                        <input name="IN_EX" id="IN_EX" type="checkbox" value="1" class="switch">
                            <label style="text-align:left; color:#f1f1f1" for="IN_EX">.</label>
                        </div></td>

                    </tr>

                    <tr>

                        <td > <label>Departamento / Familia</label></td>

                       

                    </tr>

                    <tr >

                    <td colspan="2" id="cargar"></td>

                    </tr>

                        <tr>

                           <td></td>

                           <td><input name="INGRESAR" type="submit" value="Registrar">

                            <input name="LIMPIAR" type="reset" value="Limpiar">

                            <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_grupos.php')"></td>

                        </tr>

                </table>

                </form>

                <script>

                document.forming.ID_TND.focus();

                </script>

                <script>

				function crear_n(valor)

				{

					var cantidad=valor;

					$("#cargar").empty();

					for(i=0;i<cantidad;i++)

					{

						cargar_linea(i);

					}

				}

				function cargar_linea(iden)

				{

					var texto="";

					iden=iden+1;

					

					if(iden>$("#ULT_COR_GRP").val())

					{

					}

					else

					{

						texto=texto;	

						var dataString='DEPT=1';

						$.ajax({

						type: "GET",

						url: "cargar_dept.php",

						data: dataString,

						cache: false,

						success: function(response)

						{

							texto=texto+'<tr id="dept'+iden+'"><td><select name="dept'+iden+'" onchange="cargar_familia(this, '+iden+')">';

							texto=texto+response;

							texto=texto+'</select></td><td id="familia'+iden+'"></td></tr>';

							t=texto;

							$("#cargar").append(t);

							var id=iden;

							var v="cargar_linea("+id+")";

							$("#btn_mas").attr("onclick",v);

							var id=iden;

							var val="quitar_linea("+id+")";

							$("#btn_menos").attr("onclick",val);

							$("#CANT_DEPTOS").val(iden);

							

						}

					})

					}

				}

				function cargar_familia(dept,pos)

				{

					var texto="";

					var t;

					var dataString='FAM='+dept.value;

					$.ajax({

						type: "GET",

						url: "cargar_dept.php",

						data: dataString,

						cache: false,

						success: function(response)

						{

							texto=texto+'<select name="FAM'+pos+'">';

							texto=texto+response;

							texto=texto+'</select>';

							t=texto;

							$("#familia"+pos).html(t);

						}

					})			

				}

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

				$CONSULTA="SELECT * FROM CO_GRUPO WHERE ID_GRUPO='".$ACT."'";

				$RS = sqlsrv_query($conn, $CONSULTA);

				//oci_execute($RS);

				if ($row = sqlsrv_fetch_array($RS)) {

					$ID_GRUPO=$row["ID_GRUPO"];

					$ULT_COR_GRP=$row["ULT_COR_GRP"];

					$IN_EX=$row["IN_EX"];

					$DESCRIPCION=$row["DESCRIPCION"];

                }

               ?>
 				<p class="speech">Grupo: <?=$DESCRIPCION?></p>
                <h3>Actualizar GRUPO </h3>

                <form action="mant_grupos_reg.php" method="post" name="formact" onSubmit="return validaingreso(this)" >

                <table id="forma-registro">

                    

                    <tr>

                        <td> <label for="ID_GRUPO">Identificador</label><input type="hidden" value="<?=$ID_GRUPO?>" name="ID_ANTERIOR"></td>

                        <td><input name="ID_GRUPO" type="text" size="4" maxlength="2" value="<?=$ID_GRUPO?>" disabled onKeyPress="return acceptNum(event);"></td>

                    </tr>
					<tr>

                        <td> <label for="DESCRIPCION">Descripci&oacute;n</label> </td>

                        <td><input name="DESCRIPCION" type="text" size="26" maxlength="200" value="<?=$DESCRIPCION?>"></td>

                    </tr>
                    <tr>

                        <td> <label for="ULT_COR_GRP">Ultimo Correlativo</label> </td>

                        <td><input name="ULT_COR_GRP" type="text" size="4" maxlength="2" value="<?=substr($ULT_COR_GRP,1)?>" onChange="crear(this.value);"></td>

                    </tr>

                    <tr>

                        <td> <label for="ULT_COR_GRP">Incluye</label> </td>

                        <td><div style="clear: both; margin: 0 10px 0 0;">
                        <input name="IN_EX" id="IN_EX" type="checkbox" value="1" class="switch" <?php if($IN_EX==1){ECHO "checked";} ?>>
                            <label style="text-align:left; color:#f1f1f1" for="IN_EX">.</label>
                        </div></td>

                    </tr>

                    

                    <tr>

                         <td > <label>Departamento / Familia</label></td>

                    </tr>

                    

                    	<?php

							$CONSULTA2="SELECT * FROM DET_CO_GRUPO WHERE ID_GRUPO='".$ID_GRUPO."'";

							$RES= sqlsrv_query($conn, $CONSULTA2);

							//oci_execute($RES);

							$id=0;

							$html="<table>";

							while ($row_gr = sqlsrv_fetch_array($RES)) 

							{

								$id++;

								$ID_DET_GRP=$row_gr["ID_DET_GRP"];

								$SEC_SUBSEC=$row_gr["SEC_SUBSEC"];

								$DEPTO=substr($SEC_SUBSEC,0,4);

								$FAM=substr($SEC_SUBSEC,4);

								$RES_DEPTO='<option value="nada">Seleccione</option>';

								$CONSULTA="SELECT * FROM ID_DPT_PS";

								$RS = sqlsrv_query($conn, $CONSULTA);

								//oci_execute($RS);

								while ($row = sqlsrv_fetch_array($RS))

								{

									if($row["CD_DPT_CER"]==$DEPTO)

									{

										$RES_DEPTO.='<option value="'.$row["CD_DPT_CER"].'" selected>'.$row["NM_DPT_PS"].'</option>';

									}

									else

									{

										$RES_DEPTO.='<option value="'.$row["CD_DPT_CER"].'">'.$row["NM_DPT_PS"].'</option>';

									}

								}

								

								$RES_FAM='<option value="nada">Seleccione</option>';

								$CONSULTA="SELECT * FROM CO_MRHRC_GP WHERE CD_DPT_CER='".$DEPTO."'";

								$RS = sqlsrv_query($conn, $CONSULTA);

								//oci_execute($RS);

								while ($row = sqlsrv_fetch_array($RS))

								{

									if($row["CD_MRHRC_CER"]==$FAM)

									{

										if($row["NM_MRHRC_GP"]!=null)

										$RES_FAM.='<option value="'.$row["CD_MRHRC_CER"].'" selected>'.$row["NM_MRHRC_GP"].'</option>';

									}

									else

									{

										if($row["NM_MRHRC_GP"]!=null)

										$RES_FAM.='<option value="'.$row["CD_MRHRC_CER"].'">'.$row["NM_MRHRC_GP"].'</option>';

									}

								}

								$RES_DEPTO='<select name="dept'.$id.'" onchange="cargar_familia_act(this,'.$id.')">'.$RES_DEPTO."</select>";

								$RES_FAM='<select name="FAM'.$id.'"  >'.$RES_FAM."</select>";

								$html.= '<tr><td>'.$RES_DEPTO.'</td><td id="fami'.$id.'">'.$RES_FAM."</td></tr>";							

							}

							$html.="</table>";

						?>

                     <tr >

                    <td colspan="2" id="cargar_act">

                    <?=$html ?>

                    </td>

                    </tr>

                  <tr>

                        <td></td>

                        <td>

                        <input name="ACTUALIZAR" type="submit" value="Actualizar">

                        <?php

						$CONSULTA="SELECT * FROM CO_GRUPO WHERE ID_GRUPO='".$ACT."'";

						$RS = sqlsrv_query($conn, $CONSULTA);

						//oci_execute($RS);

						if ($row = sqlsrv_fetch_array($RS)) {

							$ELIMINAR=1;

						} else {

							$ELIMINAR=0;

						}

						if ($ELIMINAR==1) {

						?>

                        <input name="ELIMINAR" type="button" value="Eliminar" onClick="javascript:pagina('mant_grupos_reg.php?ELM=1&ID_GRUPO=<?=$ACT ?>')">

                        <?php } ?>

                        <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_grupos.php')">

                        </td>

                    </tr>

                    

                </table>

                </form>

                <script>

				function crear(valor)

				{

					var cantidad=valor;

					$("#cargar_act").empty();

					for(i=0;i<cantidad;i++)

					{

						cargar_linea_act(i);

					}

				}

				function cargar_linea_act(iden)

				{

					var texto="";

					iden=iden+1;

					

					if(iden>$("#ULT_COR_GRP").val())

					{

					}

					else

					{

						texto=texto;	

						var dataString='DEPT=1';

						$.ajax({

						type: "GET",

						url: "cargar_dept.php",

						data: dataString,

						cache: false,

						success: function(response)

						{

							texto=texto+'<tr id="dept'+iden+'"><td><select name="dept'+iden+'" onchange="cargar_familia_act(this, '+iden+')">';

							texto=texto+response;

							texto=texto+'</select></td><td id="fami'+iden+'"></td></tr>';

							t=texto;

							$("#cargar_act").append(t);

							

						}

					})

					}

				}

				function cargar_familia_act(dept,pos)

				{

					var texto="";

					var t;

					var dataString='FAM='+dept.value;

					$.ajax({

						type: "GET",

						url: "cargar_dept.php",

						data: dataString,

						cache: false,

						success: function(response)

						{

							texto=texto+'<select name="FAM'+pos+'">';

							texto=texto+response;

							texto=texto+'</select>';

							t=texto;

							$("#fami"+pos).empty();

							$("#fami"+pos).html(t);

						}

					})			

				}

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

</td>

</tr>

</table>

</body>