<?php
function dec($str)
{
	$cadena=str_replace("'","|csimple|",$str);
	$cadena=str_replace('"',"|cdoble|",$cadena);
	$cadena = str_replace('\\', '|bslash|', $cadena);
	$cadena = str_replace('/', '|slash|', $cadena);
	$cadena=str_replace ( "<", "|mnq|", $cadena); 
	$cadena=str_replace ( ">", "|myq|", $cadena);
	$cadena=str_replace ( "+", "|plus|", $cadena);
	$cadena=str_replace ( "(", "|apar|", $cadena);
	$cadena=str_replace ( ")", "|cpar|", $cadena);
	$cadena=str_replace ( "=", "|igual|", $cadena);
	$cadena=str_replace ( "-", "|menos|", $cadena);
	$cadena=str_replace ( ",", "|coma|", $cadena);
	$cadena=str_replace ( ".", "|punto|", $cadena);
	$cadena=str_replace ( ";", "|pcoma|", $cadena);
	$cadena=str_replace ( "[", "|acorch|", $cadena);
	$cadena=str_replace ( "]", "|ccorch|", $cadena);
	$cadena=str_replace ( "?", "|apre|", $cadena);
	$cadena=str_replace ( "¿", "|cpre|", $cadena);
	$cadena=str_replace ( "%", "|porc|", $cadena);
	return $cadena;
}
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
		$BDIP = "200.27.205.250";
		$db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = ".$BDIP.")(PORT = 1521)))(CONNECT_DATA=(SID=xe)))" ;
		$conn = oci_connect( "PACE_EC" ,"PACE_EC", $db);
		$SQL="ALTER SESSION SET nls_date_format='DD-MM-YYYY'";
		$RS = oci_parse($conn, $SQL);
		oci_execute($RS);
		$res="";
		$pos=0;
		$pos_=0;
		
		$CONSULTA1="SELECT max(UBICACION) as pos from PACE_CAMPO";
		$RS1 = oci_parse($conn, $CONSULTA1);
		oci_execute($RS1);
		while ($row1 = oci_fetch_assoc($RS1)){
			$pos=$row1["POS"];
		}
		$CONSULTA0="SELECT max(id_dcampo) as maxid,max(posicion) as maxpos from pace_dcampo";
		$RS0 = oci_parse($conn, $CONSULTA0);
		oci_execute($RS0);
		while ($row0 = oci_fetch_assoc($RS0)){
			$id_h=$row0["MAXID"];
			$pos_=$row0["MAXPOS"];
		}

		$CONSULTA2="SELECT * FROM CAMPO WHERE id_padre < 4 and IDE not in(select COD_CAMPO from pace_campo) order by COD_NVL1,ide";
		$RS2 = oci_parse($conn, $CONSULTA2);
		oci_execute($RS2);
		while ($row2 = oci_fetch_assoc($RS2)){
			$sql_array=array();
			$cod_campo="";
			$pos=$pos+2;
			$nombre="";
			$id_campo="";
			$tipo="";
			$largo="0";
			$valor="";
			$ubicacion=$pos;
			$cod_nvl1="";
			$cod_campo = $row2['IDE'];
			$DESCRIP = enco($row2['DESCRIP']);
			$ID_PADRE = $row2['ID_PADRE'];
			$cod_nvl1 = $row2['COD_NVL1'];
			if($cod_nvl1=="")
			{
				$cod_nvl1=0;
			}

			$posicion=strpos($DESCRIP,"=");
			$largo_t=strlen($DESCRIP);
			$nombre=substr($DESCRIP,0,$posicion);
			//echo $cod_campo."-".$nombre."-";

			$desc_campo=substr($DESCRIP,$posicion,$largo_t);
						
			$pos_primera_coma=strpos($desc_campo,",");
			$pos_primera=$pos_primera_coma-2;
			$id_campo=substr($desc_campo,2,$pos_primera);
			//echo $id_campo."-";
			
			$cadena=substr($desc_campo,$pos_primera_coma+1,$largo_t);
			$tipo = trim($cadena);
			//echo $cadena;
			//echo "<br>";

			if(strcmp($tipo,"RECORD") == 0){
			
			$sql_campo="insert into pace_campo(cod_campo,nombre_campo,id_campo,tipo_campo,largo_campo,valor,ubicacion,cod_nvl1,ID_PADRE) values";
			$sql_campo.="(".$cod_campo.",'".$nombre."',".$id_campo.",'".$tipo."',".$largo.",'".dec($valor)."',".$ubicacion.",".$cod_nvl1.",".$ID_PADRE.")";
			echo $sql_campo."<br>";
			
			//$RSL = oci_parse($conn, $sql_campo);
			//oci_execute($RSL);
			

				if(count($sql_array)>1){

					foreach($sql_array as $fila)
					{
						echo $fila."<br>";
						//$RSfila = oci_parse($conn, $fila);
						//oci_execute($RSfila);
					}

				}
			}
			
	}
		
		// [Control] Hacia adelante
	
		$CONSULTA2="SELECT * FROM CAMPO WHERE id_padre >= 4 and IDE not in(select COD_CAMPO from pace_campo) order by COD_NVL1,ide";
		$RS2 = oci_parse($conn, $CONSULTA2);
		oci_execute($RS2);
		while ($row2 = oci_fetch_assoc($RS2)){
			$sql_array=array();
			$cod_campo="";
			$pos=$pos+2;
			$nombre="";
			$id_campo="";
			$tipo="";
			$largo="0";
			$valor="";
			$ubicacion=$pos;
			$cod_nvl1="";
			$cod_campo = $row2['IDE'];
			$DESCRIP = enco($row2['DESCRIP']);
			$ID_PADRE = $row2['ID_PADRE'];
			$cod_nvl1 = $row2['COD_NVL1'];
			if($cod_nvl1=="")
			{
				$cod_nvl1=0;
			}

			$posicion=strpos($DESCRIP,"=");
			$largo_t=strlen($DESCRIP);
			$nombre=substr($DESCRIP,0,$posicion);
			//echo $cod_campo."-".$nombre."-";

			$desc_campo=substr($DESCRIP,$posicion,$largo_t);
						
			$pos_primera_coma=strpos($desc_campo,",");
			$pos_primera=$pos_primera_coma-2;
			$id_campo=substr($desc_campo,2,$pos_primera);
			//echo $id_campo."-";
			
			$desc_campo=substr($desc_campo,$pos_primera_coma+1,$largo_t);
			
			$pos_segunda_coma=strpos($desc_campo,",");
			$tipo=substr($desc_campo,0,$pos_segunda_coma);
			//echo $tipo."-";
						
			$desc_campo=substr($desc_campo,$pos_segunda_coma+1,$largo_t);


			if(trim($tipo)=="Array")
			{
				$pos_tercera_coma=strpos($desc_campo,",");
				$tipo_campo_array=substr($desc_campo,0,$pos_tercera_coma);
				$desc_campo=substr($desc_campo,$pos_tercera_coma+1,$largo_t);
				//echo $tipo_campo_array."-";
				$pos_cuarta_coma=strpos($desc_campo,",");
				$largo=substr($desc_campo,0,$pos_cuarta_coma);
				$desc_campo=substr($desc_campo,$pos_cuarta_coma+1,$largo_t);
				$cuarto_campo=", Tipo Campo Arreglo =>".$tipo_campo_array.", Largo Arreglo=>".$largo_campo_array.", Valores =>".$desc_campo;
				$texto="";
				
				$array_desc=explode(",",$desc_campo);
				for($i=0;$i<count($array_desc);$i++)
				{
					
					 //echo "<br>";
					 $id_h++;
					 $pos_=$pos_+2;
					 $v=$array_desc[$i];
					 $posi=strpos($v,"\\");
					 $v = str_replace( '\\','', $v);
					 if($posi==false)
					 {
						 //echo $nombre.$i."-".$tipo_campo_array."-".$id_campo."-".$v;
						 $sql_def="insert into pace_dcampo(id_dcampo,posicion,valor,id_padre,TIPO) values";
						 $sql_def.="(".$id_h.",".$pos_.",'".$v."',".$cod_campo.",'".$tipo_campo_array."')";
						 $sql_array[]=$sql_def;
					 }
					 else
					 {
						 $sql_def="insert into pace_dcampo(id_dcampo,posicion,valor,id_padre,tipo,delimitador) values";
						 $sql_def.="(".$id_h.",".$pos_.",'".dec($v)."',".$cod_campo.",'".$tipo_campo_array."','\')";
						 $sql_array[]=$sql_def;
					 }
				}
			}
			else
			{
				$pos_tercera_coma=strpos($desc_campo,",");
				if($pos_tercera_coma==false)
				{
					 $valor=$desc_campo;
					 //echo $valor;
					 $desc_campo="";
				}
				else
				{
					$largo=substr($desc_campo,0,$pos_tercera_coma);
					$desc_campo=substr($desc_campo,$pos_tercera_coma+1,$largo_t);
					//echo $largo."-";
					$valor=$desc_campo;
				}
			}
			//echo "<br>";
			$sql_campo="insert into pace_campo(cod_campo,nombre_campo,id_campo,tipo_campo,largo_campo,valor,ubicacion,cod_nvl1,ID_PADRE) values";
			$sql_campo.="(".$cod_campo.",'".$nombre."',".$id_campo.",'".$tipo."',".$largo.",'".dec($valor)."',".$ubicacion.",".$cod_nvl1.",".$ID_PADRE.")";
			echo $sql_campo."<br>";
			
			//$RSL = oci_parse($conn, $sql_campo);
			//oci_execute($RSL);
			
			if(count($sql_array)>1)
			{
				foreach($sql_array as $fila)
				{
					echo $fila."<br>";
					
					//$RSfila = oci_parse($conn, $fila);
					//oci_execute($RSfila);
				}
			}
			
		}
			
?>










































