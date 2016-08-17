<?php
$BDIP = "200.27.205.250";
$db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = ".$BDIP.")(PORT = 1521)))(CONNECT_DATA=(SID=xe)))" ;
		$conn = oci_connect( "PACE_EC" ,"PACE_EC", $db);
		$SQL="ALTER SESSION SET nls_date_format='DD-MM-YYYY'";
		$RS = oci_parse($conn, $SQL);
		oci_execute($RS);
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
$res="";
$CONSULTA0="SELECT max(id_dcampo) as maxid,max(posicion) as maxpos from pace_dcampo";
		$RS0 = oci_parse($conn, $CONSULTA0);
		oci_execute($RS0);
		while ($row0 = oci_fetch_assoc($RS0)){
			$id_h=$row0["MAXID"];
			$pos_=$row0["MAXPOS"];
		}
		$CONSULTA0="SELECT max(cod_unico) as maxid,max(pos_) as maxpos from detalle_";
		$RS0 = oci_parse($conn, $CONSULTA0);
		oci_execute($RS0);
		while ($row0 = oci_fetch_assoc($RS0)){
			$cod_unico=$row0["MAXID"];
			$posicion_=$row0["MAXPOS"];
		}
$QUERY="select cod_def, DESC_DEF from pace_def_campo order by cod_def asc";
$ReS = oci_parse($conn, $QUERY);
oci_execute($ReS);
while ($r = oci_fetch_assoc($ReS)){
	$def_campo=0;
	$COD_DEF=$r["COD_DEF"];
	$DESC_DEF=enco($r["DESC_DEF"]);
	if(strpos($DESC_DEF,"List]")!=false)
	{
		//echo $DESC_DEF." def_campo<br>";
		$def_campo=1;
	}
	else
	{
		$def_campo=0;
		//echo $DESC_DEF." <br>";
	}
	$CONSULTA="Select * from campo where ID_PADRE=".$COD_DEF."  order by ide asc";
	$RS = oci_parse($conn, $CONSULTA);
	oci_execute($RS);
	while ($row = oci_fetch_assoc($RS)){
		
		if($def_campo==1)
		{
			$sql_array=array();
			$IDEN = $row['IDE'];
			$DESCRIPCION = enco($row['DESCRIP']);
			//$res.=$iden."-".$DESCRIPCION."<br>";
			
			$posicion=strpos($DESCRIPCION,"=");
			$largo_t=strlen($DESCRIPCION);
			$nombre=substr($DESCRIPCION,0,$posicion);
			
			$desc_campo=substr($DESCRIPCION,$posicion,$largo_t);
						
			$pos_primera_coma=strpos($desc_campo,",");
			$pos_primera=$pos_primera_coma-2;
			$id_campo=substr($desc_campo,2,$pos_primera);
			$desc_campo=substr($desc_campo,$pos_primera_coma+1,$largo_t);
			
			$pos_segunda_coma=strpos($desc_campo,",");
			if($pos_segunda_coma!=false)
			{
				$tipo=substr($desc_campo,0,$pos_segunda_coma);
				$desc_campo=substr($desc_campo,$pos_segunda_coma+1,$largo_t);
				if(trim($tipo)=="Array"  ||trim($tipo)=="SECTIONS" )
				{
					$pos_tercera_coma=strpos($desc_campo,",");
					$tipo_campo_array=substr($desc_campo,0,$pos_tercera_coma);
					$desc_campo=substr($desc_campo,$pos_tercera_coma+1,$largo_t);
					//echo $tipo_campo_array."-";
					$pos_cuarta_coma=strpos($desc_campo,",");
					$largo=substr($desc_campo,0,$pos_cuarta_coma);
					$desc_campo=substr($desc_campo,$pos_cuarta_coma+1,$largo_t);
					//$cuarto_campo=", Tipo Campo Arreglo =>".$tipo_campo_array.", Largo Arreglo=>".$largo_campo_array.", Valores =>".$desc_campo;
					//$texto="";
					
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
							 $sql_def.="(".$id_h.",".$pos_.",'".dec($v)."',".$IDEN.",'".$tipo_campo_array."');";
							 $sql_array[]=$sql_def;
						 }
						 else
						 {
							 $sql_def="insert into pace_dcampo(id_dcampo,posicion,valor,id_padre,tipo,delimitador) values";
							 $sql_def.="(".$id_h.",".$pos_.",'".dec($v)."',".$IDEN.",'".$tipo_campo_array."','\');";
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
			}
			else
			{
				if(strtoupper(trim($desc_campo))=="UINT")
				{
					$tipo="UInt";
					$largo=0;
				}
			}
			
			$sql_campo="insert into PACE_DEF_DET(COD_DEF_DETALLE,DESC_DETALLE,ID_DETALLE,TIPO_DETALLE,LARGO_DETALLE,VALOR_DETALLE,ES_DEF,id_padre) values";
			$sql_campo.="(".$IDEN.",'".dec($nombre)."',".$id_campo.",'".$tipo."',".$largo.",'".dec($valor)."',1,".$COD_DEF.");";
			echo $sql_campo."<br>";
			//$RSL = oci_parse($conn, $sql_campo);
			//oci_execute($RSL);
			if(count($sql_array)>1)
			{
				foreach($sql_array as $fila)
				{
					//echo $fila."<br>";
					//$RSfila = oci_parse($conn, $fila);
					//oci_execute($RSfila);
				}
			}
			
		}
		else
		{
			$sql_array=array();
			$IDEN = $row['IDE'];
			$DESCRIPCION = enco($row['DESCRIP']);
			//$res.=$iden."-".$DESCRIPCION."<br>";
			
			$posicion=strpos($DESCRIPCION,"=");
			$largo_t=strlen($DESCRIPCION);
			$nombre=substr($DESCRIPCION,0,$posicion);
			
			$resto=substr($DESCRIPCION,$posicion+1,$largo_t);
			if(substr_count($resto,",")>1)
			{
				$array_desc=explode(",",$resto);
				for($i=0;$i<count($array_desc);$i++)
				{
					
					 //echo "<br>";
					 $cod_unico++;
					 $posicion_=$posicion_+2;
					 $v=$array_desc[$i];
					 $posi=strpos($v,"\\");
					 $v = str_replace( '\\','', $v);
					 if($posi==false)
					 {
						 //echo $nombre.$i."-".$tipo_campo_array."-".$id_campo."-".$v;
						 $sql_def="insert into detalle_(cod_unico,valor,pos_,id_def_padre) values";
						 $sql_def.="(".$cod_unico.",'".dec($v)."',".$posicion_.",".$IDEN.");";
						 $sql_array[]=$sql_def;
					 }
					 else
					 {
						 $sql_def="insert into detalle_(cod_unico,valor,pos_,id_def_padre,delimit) values";
						 $sql_def.="(".$cod_unico.",'".dec($v)."',".$posicion_.",".$IDEN.",'\');";
						 $sql_array[]=$sql_def;
					 }
				}
				$valor="|Arreglo|";
			}
			else
			{
				$valor=$resto;
			}
			$sql_campo="insert into PACE_DEF_DET(COD_DEF_DETALLE,DESC_DETALLE,VALOR_DETALLE,ES_DEF,id_padre) values";
			$sql_campo.="(".$IDEN.",'".dec($nombre)."','".dec($valor)."',0,".$COD_DEF.");";
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
		
		
	}
	
}




?>