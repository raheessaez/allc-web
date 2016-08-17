<?php
// Cargar Archivo
$file = file("EAMOPTNS.INI");
$flag=0;
$flag_as=0;
$flag_nvl2=0;
$id_=0;
$antes_="";
$despues_store="";
function dec($str)
{
	$cadena=str_replace("'","|csimple|",$str);
	$cadena=str_replace('"',"|cdoble|",$cadena);
	$cadena = str_replace('\\', '/', $cadena);
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
	return $cadena;
}
function limpiarString($cadena) {
	$string=split(" ",$cadena);
	$res="";
	for($i=0;$i<=count($string);$i++)
	{
		$cadena = trim($string[$i]);
		$cadena = strtr($cadena,
	"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ",
	"aaaaaaaaaaaaoooIoooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");
			$cadena = preg_replace('#-{2,}#','-',$cadena);
			$cadena = preg_replace('#-$#','',$cadena);
			$cadena = preg_replace('#^-#','',$cadena);
			//$cadena=dec($cadena);
			$res.=" ".$cadena;
			
	}
	return $res;
	
}
// Recorrer cada línea del archivo e imprimirla a pantalla
foreach ($file as $RowRept) 
{
	// Quitar primeras 5 lineas de comentarios
	if($flag_as>=0)
	{
		// Para eliminar líneas vacias
		if(trim($RowRept)!="")
		{
					
				if($flag==1)
				{
					 $RowRept=$anterior.$RowRept;
					 $flag=0;
				}
				if(substr(trim($RowRept),-1)=='/')
				{
					 $anterior=$RowRept;
					 $flag=1;
				}
				else
				{
						$id_++;
						echo limpiarString($RowRept)."<br>";
							 //Separando nombre de la descripción del campo
							 //$pos=strpos($RowRept,"=");
//							 $largo=strlen($RowRept);
//							 $nombre_campo=substr($RowRept,0,$pos);
//							 $primer_campo="Nombre Campo =>".$nombre_campo;
//							 // Descripcion del campo
//							 $desc_campo=substr($RowRept,$pos,$largo);
//							 
//							 // Separando el ID dentro del menu nivel 2
//							 $pos_primera_coma=strpos($desc_campo,",");
//							 $pos_primera=$pos_primera_coma-2;
//							 $id_campo=substr($desc_campo,2,$pos_primera);
//							 $desc_campo=substr($desc_campo,$pos_primera_coma+1,$largo);
//							 $segundo_campo=", ID Campo=>".$id_campo;
//							 // Separando el tipo de campo
//							 $pos_segunda_coma=strpos($desc_campo,",");
//							 $tipo_campo=substr($desc_campo,0,$pos_segunda_coma);
//							 $desc_campo=substr($desc_campo,$pos_segunda_coma+1,$largo);
//							 $tercer_campo=", Tipo Campo =>".$tipo_campo;
//							 
//							 
//							 
//							 $pos_cuarta_coma=strpos($desc_campo,",");
//							 $largo_campo_array=substr($desc_campo,0,$pos_cuarta_coma);
//							 $desc_campo=substr($desc_campo,$pos_cuarta_coma+1,$largo);
							 // Identificando a los tipos de campo que son arreglos
							 //$cuarto_campo="";
							 //if(trim($tipo_campo)=="Array")
//							 {
//								 $pos_tercera_coma=strpos($desc_campo,",");
//								 $tipo_campo_array=substr($desc_campo,0,$pos_tercera_coma);
//								 $desc_campo=substr($desc_campo,$pos_tercera_coma+1,$largo);
//								 
//								 $pos_cuarta_coma=strpos($desc_campo,",");
//								 $largo_campo_array=substr($desc_campo,0,$pos_cuarta_coma);
//								 $desc_campo=substr($desc_campo,$pos_cuarta_coma+1,$largo);
//								 $cuarto_campo=", Tipo Campo Arreglo =>".$tipo_campo_array.", Largo Arreglo=>".$largo_campo_array.", Valores =>".$desc_campo;
//								 $id_padre=$id_;
//								 $texto="";
//								 for($i=0;$i<=$largo_campo_array;$i++)
//								 {
//									 $id_++;
//									 $texto.="&nbsp;-&nbsp;".$id_.$primer_campo.$i.", Tipo Campo =>".$tipo_campo_array.", Id campo padre=>".$id_padre."<br>";
//							     }
//								 $cuarto_campo.="<br>".$texto;
//							 }
//							 else
//							 {
//								 $pos_tercera_coma=strpos($desc_campo,",");
//								 if($pos_tercera_coma==false)
//								 {
//									 $cuarto_campo=", Largo Campo =>".$desc_campo;
//									 $desc_campo="";
//								 }
//								 else
//								 {
//									 $largo_campo=substr($desc_campo,0,$pos_tercera_coma);
//									 $desc_campo=substr($desc_campo,$pos_tercera_coma+1,$largo);
//									 $cuarto_campo=", Largo Campo =>".$largo_campo.", Valor Campo =>".limpiarString($desc_campo);
//								 }
//							 }
							 //$primer_campo=$id_."-".$primer_campo;
							 //echo $primer_campo.$segundo_campo.$tercer_campo.$cuarto_campo."<br>";
					 
				}
		}
	}
	$flag_as++;
}
//echo $antes_store;
//echo $despues_store;
?>