<?php include("session.inc");?>

<?php include("headerhtml.inc");?>

<?php

    $COD_NIVEL=@$_GET["COD_NIVEL"];

	$TituloNv2=@$_GET["TituloNv2"];

	$COD_TIENDA=@$_SESSION['TIENDA_SEL'];


    if ($MSJE==1) {$ELMSJ="Registro realizado.";} 

    if ($MSJE==2) {$ELMSJ="Registro no realizado";} 

    function enco($str)

{

	$cadena=str_replace("|csimple|","'",$str);

	$cadena=str_replace("|cdoble|",'"',$cadena);

	$cadena=str_replace (  "|mnq|", "<",$cadena); 

	$cadena=str_replace (  "|myq|",">", $cadena);

	$cadena=str_replace ( "|plus|",  "+",$cadena);

	$cadena=str_replace (  "|apar|","(", $cadena);

	$cadena=str_replace (  "|cpar|", ")",$cadena);

	$cadena=str_replace (  "|igual|","=", $cadena);

	$cadena=str_replace (  "|menos|","-", $cadena);

	$cadena=str_replace ( "|coma|",",",  $cadena);

	$cadena=str_replace ( "|punto|", ".", $cadena);

	$cadena=str_replace ( "|pcoma|", ";", $cadena);

	$cadena=str_replace ( "|acorch|", "[", $cadena);

	$cadena=str_replace ( "|ccorch|", "]", $cadena);

	$cadena = str_replace( '|slash|', '/',$cadena);

	$cadena = str_replace('|bslash|', '\\', $cadena);

	$cadena=str_replace ("|apre|", "?",  $cadena);

	$cadena=str_replace ("|cpre|",  "¿", $cadena);

	$cadena=str_replace ( "|porc|", "%", $cadena);

	return $cadena;

}

function separar($cadena)

{

	$needle=array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");

	$cad_s=str_split($cadena);

	$res="";

	foreach($cad_s as $rec)

	{

		if(in_array($rec,$needle))

		{

			$res.=" ".$rec;

		}

		else

		{

			$res.=$rec;

		}

	}

	return $res;

}

?>

<style>

input

{

	min-width:100px;

}

.FormaPACE

{

	width:100%;

}
.td_label
{
	width:150px;
	text-align:left;
}
.td_field
{
	text-align:right;
}
tr
{
	border-top: 1px rgba(202,202,202,0.56) solid;
}
td
{
    border-top: none !important;

}
</style>



</head>

<body>

<h2>

  <?=$TituloNv2?>

</h2>

<table id="forma-registro" class="FormaPACE" width="100%" style="margin:0">

  <form action="load_form.php?COD_NIVEL=<?=$COD_NIVEL?>&TituloNv2=<?=$TituloNv2?>" method="post" name="forming" id="forming" onSubmit="#">

    <?php

	include("reg_forms.php");

	$campos=""; 

    $SQL="SELECT * FROM PACE_CAMPO WHERE COD_NVL1=".$COD_NIVEL." AND COD_TIENDA = ".$COD_TIENDA." ORDER BY UBICACION ASC";


        $RS = sqlsrv_query($conn, $SQL);

        //oci_execute($RS);

        while($row = sqlsrv_fetch_array($RS)) 

        {

			

            $COD_CAMPO=$row["COD_CAMPO"];

			$campos.=$COD_CAMPO."-";

            $NOMBRE_CAMPO=$row["NOMBRE_CAMPO"];

            $LARGO_CAMPO=$row["LARGO_CAMPO"];

            $TIPO_CAMPO=$row["TIPO_CAMPO"];

			$VALOR=trim($row["VALOR"]);

			$VALOR=str_replace('"',"",$VALOR);

			$SIZE=($LARGO_CAMPO*10)+10;

            switch (strtoupper(trim($TIPO_CAMPO))) 

			{

				case "STRING":

					echo '<tr STYLE="DISPLAY:block;">

                            <td class="td_label"><label for="'.$COD_CAMPO.'">'.separar($NOMBRE_CAMPO).'</label></td>

                            <td class="td_field"><input id="'.$COD_CAMPO.'" name="'.$COD_CAMPO.'" type="text" maxlength="'.$LARGO_CAMPO.'" style="width:'.$SIZE.'px;" value="'.$VALOR.'" ></td>                    </tr>';

					break;

				case "ULONG":

					echo '<tr STYLE="DISPLAY:block">

                            <td class="td_label"><label for="'.$COD_CAMPO.'">'.separar($NOMBRE_CAMPO).'</label></td>

                            <td class="td_field"><input id="'.$COD_CAMPO.'" name="'.$COD_CAMPO.'" type="text" maxlength="30" value="'.$VALOR.'" onKeyPress="return acceptNum(event)"></td>                    </tr>';

					break;

				case "UINT":

					echo '<tr STYLE="DISPLAY:block">

                            <td class="td_label"><label for="'.$COD_CAMPO.'">'.separar($NOMBRE_CAMPO).'</label></td>

                            <td class="td_field"><input id="'.$COD_CAMPO.'" name="'.$COD_CAMPO.'" type="text" maxlength="20" value="'.$VALOR.'" onKeyPress="return acceptNum(event)"></td>                    </tr>';

					break;

				case "INT":

					echo '<tr STYLE="DISPLAY:block">

                            <td class="td_label"><label for="'.$COD_CAMPO.'">'.separar($NOMBRE_CAMPO).'</label></td>

                            <td class="td_field"><input id="'.$COD_CAMPO.'" name="'.$COD_CAMPO.'" type="text" maxlength="10" value="'.$VALOR.'" onKeyPress="return acceptNum(event)"></td>                    </tr>';

					break;

				case "BOOLEAN":

					switch(trim($VALOR))

					{

						case "1":

						echo '<tr STYLE="DISPLAY:block">

                            <td class="td_label"><label for="'.$COD_CAMPO.'">'.separar($NOMBRE_CAMPO).'</label></td>

                            <td class="td_field"><input id="'.$COD_CAMPO.'" name="'.$COD_CAMPO.'" type="checkbox" value="'.$VALOR.'" checked style="min-width:30px;"></td></tr>';

						break;

						case "0":

						echo '<tr STYLE="DISPLAY:block">

                            <td class="td_label"><label for="'.$COD_CAMPO.'">'.separar($NOMBRE_CAMPO).'</label></td>

                            <td class="td_field"><input id="'.$COD_CAMPO.'" name="'.$COD_CAMPO.'" type="checkbox" value="'.$VALOR.'"  style="min-width:30px;"></td></tr>';

						break;

						

					}

					break;

				case "ARRAY":

					$res='<tr STYLE="DISPLAY:block"><td colspan="2" class="td_label"><label for="'.$COD_CAMPO.'">'.separar($NOMBRE_CAMPO).'</label></td></tr><tr style="border:none"><td >';

					

					$q="SELECT * FROM PACE_DCAMPO WHERE ID_PADRE =".$COD_CAMPO." order by POSICION ASC";

					$r = sqlsrv_query($conn, $q);

					//oci_execute($r);

					
					$pos=1;
					while($rw = sqlsrv_fetch_array($r)) 

					{

						$TIPO=$rw["TIPO"];

						$ID_DCAMPO=$rw["ID_DCAMPO"];

						$VALOR_DCAMPO=$rw["VALOR"];

						switch(strtoupper(trim($TIPO)))

						{

							case "UINT":

							$res.= '<input id="'.$COD_CAMPO.'" name="'.$ID_DCAMPO.'" type="text" value="'.$VALOR_DCAMPO.'" onKeyPress="return acceptNum(event)">';

							break;

							case "ULONG":

							$res.= '<input id="'.$COD_CAMPO.'" name="'.$ID_DCAMPO.'" type="text" value="'.$VALOR_DCAMPO.'" onKeyPress="return acceptNum(event)">';

							break;

							

							case "BOOLEAN":

							switch(trim($VALOR_DCAMPO))

							{

								case "1":

								$res.= $pos.'<input id="'.$COD_CAMPO.'" name="'.$ID_DCAMPO.'" type="checkbox" value="'.$VALOR_DCAMPO.'" checked style="min-width:30px;">';

								break;

								

								case "0":

								$res.= $pos.'<input id="'.$COD_CAMPO.'" name="'.$ID_DCAMPO.'" type="checkbox" value="'.$VALOR_DCAMPO.'" style="min-width:30px;">';

								break;

								

							}

							break;

							

						}
						$pos++;

					}

					$res.= '</td></tr>';

					echo $res;

					

					break;

			} 

		

		//echo '<tr STYLE="DISPLAY:'.$DISPLAY.'">

//                            <td><label for="'.$NOMB_CAMPO.'">'.$LAB_ES.'</label></td>

//                            <td><input id="'.$NOMB_CAMPO.'" name="'.$NOMB_CAMPO.'" type="text" maxlength="'.$LARGO_M.'" style="width:'.$SIZE.'px;"></td>                    </tr>';

		}

		//if($COD_NIVEL==96)

//		{

//			$q="SELECT * FROM pace_en WHERE cod_nvl1 =".$COD_NIVEL."";

//			$r = sqlsrv_query($conn, $q);

//			//oci_execute($r);

//			

//			while($rw = sqlsrv_fetch_array($r)) 

//			{

//				//echo $rw["IDEN"]."-".enco($rw["DESCRIPCION"])."<br>";

//				$desc=enco($rw["DESCRIPCION"]);

//				$desc=str_replace("[","",$desc);

//				$desc=str_replace("]","",$desc);

//				$html='<tr STYLE="DISPLAY:block"> <td><label for="'.$rw["IDEN"].'">'.$desc.'</label></td>';

//				$query="select * from pace_def_campo where Cod_Padre =".$rw["IDEN"]."";

//				$result_ = sqlsrv_query($conn, $query);

//				//oci_execute($result_);

//				$flag=0;

//				$html.='<td><select id="sel_" name="sel_" onchange="cargarform();"><option value="0">Select</option>';

//				$array_controls=array();

//				$array_values=array();

//				$record=0;

//				$resp="";

//				while($row_ = sqlsrv_fetch_array($result_)) 

//				{

//					//echo $row_["COD_DEF"]."-".enco($row_["DESC_DEF"])."<br>";

//					

//					$query_="select * from pace_def_det where id_Padre =".$row_["COD_DEF"]."";

//					$result = sqlsrv_query($conn, $query_);

//					//oci_execute($result);

//					

//					while($row = sqlsrv_fetch_array($result)) 

//					{

//						if($flag==1)

//						{

//							if(trim(enco($row["DESC_DETALLE"]))=="Id")

//							{

//								//echo $row["COD_DEF_DETALLE"]."-".enco($row["DESC_DETALLE"])."-".enco($row["VALOR_DETALLE"])."<br>";

//								$html.='<option value="'.enco($row_["COD_DEF"]).'">';

//							}

//							elseif(trim(enco($row["DESC_DETALLE"]))=="Description")

//							{

//								$val=str_replace('"',"",enco($row["VALOR_DETALLE"]));

//								$html.=$val.'</option>';

//							}

//						}

//						$record++;

//					}

//					$flag=1;

//				}

//				$html.="</select></td></tr>";

//			}

//		}

//		echo "<br>";

//		echo $html;

?>
    <tr style="display:block">

      <td class="td_label">&nbsp;</td><td align="left"><input name="REGISTRAR" type="submit" value="Registrar">

        <input type="reset" value="Limpiar"></td>

    </tr>

  </form>

</table>



</body>

<!--<script>

function cargarform()

{

	var seleccion=$("#sel_").val();

	var dataString = 'load_forms='+seleccion;

	$.ajax({

			type: "GET",

			url: "functions.php",

			data: dataString,

			cache: false,

			success: function(response)

			{

				$("#load_controls").html(response);

			}

	})

	

}



</script>-->

</html>

