<?php
//$BDIP = "200.27.205.250";
//$db   = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = " . $BDIP . ")(PORT = 1521)))(CONNECT_DATA=(SID=xe)))";
//$conn = oci_connect("PACE_EC", "PACE_EC", $db);
//$SQL  = "ALTER SESSION SET nls_date_format='DD-MM-YYYY'";
//$RS   = oci_parse($conn, $SQL);
//oci_execute($RS);
// Abrir Archivo
$file_eam          = file("IN/EAMOPTNS.INI");

//Funcion para eliminar caracteres
//$var => String donde se buscará
//$char => Caracter o caracteres a buscar, en caso de ser mas de 1 caracter, usar un arreglo. Ej: array("[","]")
//$replace => caracter para reemplazar, debe tener la misma cantidad y estructura que $char, por default el valor es vacio""
function del_char($var,$char,$replace="")
{
	$find=$char;
	$res=str_replace($find,$replace,$var);
	return $res;
}

//Codificar los caracteres que pueden causar problemas en la base de datos
function dec($str)
{
	$cadena = str_replace("'", "|csimple|", $str);
	$cadena = str_replace('"', "|cdoble|", $cadena);
	$cadena = str_replace('\\', '|bslash|', $cadena);
	$cadena = str_replace('/', '|slash|', $cadena);
	$cadena = str_replace("<", "|mnq|", $cadena);
	$cadena = str_replace(">", "|myq|", $cadena);
	$cadena = str_replace("+", "|plus|", $cadena);
	$cadena = str_replace("(", "|apar|", $cadena);
	$cadena = str_replace(")", "|cpar|", $cadena);
	$cadena = str_replace("=", "|igual|", $cadena);
	$cadena = str_replace("-", "|menos|", $cadena);
	$cadena = str_replace(",", "|coma|", $cadena);
	$cadena = str_replace(".", "|punto|", $cadena);
	$cadena = str_replace(";", "|pcoma|", $cadena);
	$cadena = str_replace("[", "|acorch|", $cadena);
	$cadena = str_replace("]", "|ccorch|", $cadena);
	$cadena = str_replace("?", "|apre|", $cadena);
	$cadena = str_replace("¿", "|cpre|", $cadena);
	$cadena = str_replace("%", "|porc|", $cadena);
	return $cadena;
}

//Quitar caracteres especiales
function limpiarString($cadena,$opc=1)
{
	$string = explode(" ", $cadena);
	$res    = "";
	for ($i = 0; $i < count($string); $i++) {
		$cadena = trim($string[$i]);
		$cadena = strtr($cadena, "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ", "aaaaaaaaaaaaoooioooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");
		$cadena=utf8_encode($cadena);
		if($opc==1)
		{
			$cadena = dec($cadena);
		}
		$res .= " " . $cadena;
	}
	return $res;
}

//PRIMER PASO PARA LA LECTURA DEL ARCHIVO EAMOPTNS.INI. CARGAR LOS ENCABEZADOS DESDE EL NODO [FILE0], ESTE NODO CONTIENE TODOS LOS ENCABEZADOS DEL ARCHIVO, A EXCEPCIÓN DE LOS NODOS .LIST
$paso=1;
$file0="";
$array_file0=array();
$array_f=array();
$counter=0;
$res_txt="";
//Obtener todos los encabezados del archivo, a excepcion de los .List
foreach ($file_eam as $RowRept) 
{
	if(strtoupper(trim(str_replace('"','',$RowRept)))=="[FILE0]" or strtoupper(trim(str_replace('"','',$RowRept)))=="[INICONTROL]" or strtoupper(trim(str_replace('"','',$RowRept)))=="[FILENAMES]" or substr(trim($RowRept), 0, 1) == "\\")
	{
		$paso=1;
	}
	if(strtoupper(trim(str_replace('"','',$RowRept)))=="[CONTROL]")
	{
		$paso=0;
	}
	if($paso==1)
	{
		$res_txt.=$RowRept;
	}
	if(substr(trim($RowRept), 0, 1) == "[" and substr(trim($RowRept), -1) == "]" and $paso==0)
	{
		$value=del_char($RowRept,array("[","]"));
		$record=array("NAME"=>trim($value));
		$array_f[]=trim($value);
		$array_file0[]=$record;
	}
}
// Crear objeto para guardar los datos de los encabezados en un archivo JSON
$obj = new stdClass();
$obj->HEADERS = array($array_file0);
//Validación de transformación a JSON, crear Archivo y guardar Archivo.
if(json_encode($obj)!=false)
{
	$json_file=json_encode($obj);
	if(fopen('IN/FILE0.JSON', 'w+')!=false)
	{
		$fp = fopen('IN/FILE0.JSON', 'w+');
		if(fwrite($fp, $json_file)!=false)
		{
			fclose($fp);
			$file_ = fopen('IN/EAMOPTNS_PASO.INI', 'w+');
			fwrite($file_, $res_txt);
			fclose($file_);
			
			//FILE0.JSON CONTIENE TODOS LOS ENCABEZADOS DE NODOS DEL ARCHIVO 
			//EL ARCHIVO EAMOPTNS_PASO.INI CONTIENE LA PARTE DEL ARCHIVO QUE NO ES RELEVANTE PARA LA BASE DE DATOS, ESTA PARTE SERÁ UTILIZADA EN LA EXPORTACIÓN FUTURA
			
			echo 'Proceso Exitoso <a href="IN/FILE0.JSON" target="_blank">FILE0.JSON</a> con '.filesize("IN/FILE0.JSON").' bytes<br>';
			echo 'Proceso Exitoso <a href="IN/EAMOPTNS_PASO.INI" target="_blank">EAMOPTNS_PASO.INI</a> con '.filesize("IN/EAMOPTNS_PASO.INI").' bytes<br>';
		}
		else
		{
			echo "Error-Header-01 - Error al guardar el archivo";
		}
	}
	else
	{
		echo "Error-Header-02 - Error al abrir el archivo";
	}
}
else
{
	switch(json_last_error()) {
		case JSON_ERROR_NONE:
			echo 'Error-Header-03 - Sin errores';
		break;
		case JSON_ERROR_DEPTH:
			echo 'Error-Header-04 - Excedido tamaño máximo de la pila';
		break;
		case JSON_ERROR_STATE_MISMATCH:
			echo 'Error-Header-05 - Desbordamiento de buffer o los modos no coinciden';
		break;
		case JSON_ERROR_CTRL_CHAR:
			echo 'Error-Header-06 - Encontrado carácter de control no esperado';
		break;
		case JSON_ERROR_SYNTAX:
			echo 'Error-Header-07 - Error de sintaxis, JSON mal formado';
		break;
		case JSON_ERROR_UTF8:
			echo 'Error-Header-08 - Caracteres UTF-8 malformados, posiblemente están mal codificados';
		break;
		case JSON_ERROR_RECURSION:
			echo 'Error-Header-09 - Una o más referencias recursivas en el valor a codificar';
		break;
		case JSON_ERROR_INF_OR_NAN:
			echo 'Error-Header-10 - Uno o más valores NAN (Not A Number) o INF (Infinite) en el valor a codificar';
		break;
		case JSON_ERROR_UNSUPPORTED_TYPE:
			echo 'Error-Header-11 - Se proporcionó un valor de un tipo que no se puede codificar';
		break;
		default:
			echo 'Error-Header-12 - Error desconocido';
		break;
	}
}	
//FIN PRIMER PASO

//INICIO SEGUNDO PASO PARA LA LECTURA DEL ARCHIVO EAMOPTNS.INI, OBTENER TODOS LOS CAMPOS ASOCIADOS A LOS NODOS QUE SE OBTUVIERON EN EL PASO ANTERIOR.

$flag_campo=0;
$file_campos="";
$echo="";
$arr_headers=array();
$obj = new stdClass();
$json_file="";
$FATHER="";
$anterior="";
$flag_delimiter=0;
$corch=array("[","]");

// Obtener Campos en base a encabezados obtenidos en el paso anterior, a excepcion de los .List
foreach ($file_eam as $RowRept) 
{
	unset($record);
	if(trim($RowRept)=="")
	{
		$flag_campo=0;
	}
	if (substr(trim($RowRept), 0, 1) == "[" and substr(trim($RowRept), -1) == "]" and in_array(del_char(trim($RowRept),$corch),$array_f)==true and strpos(del_char(trim($RowRept),$corch),".List")==false) 
	{
		$flag_campo=1;
		$FATHER=del_char(trim($RowRept),$corch);
	}
	
	if($flag_campo==1)
	{
		$record=array();
		if(substr(trim($RowRept), 0, 1) != "[" and substr(trim($RowRept), -1) != "]")
		{
			if(substr(trim($RowRept), -1) != "\\")
			{
				if($flag_delimiter==1)
				{
					$RowRept=$anterior.$RowRept;
					$flag_delimiter=0;
				}
				$record["FATHER"]=$FATHER;
				$posicion=strpos($RowRept,"=");
				$largo_t=strlen($RowRept);
				$nombre=substr($RowRept,0,$posicion);
				$record["NAME"]=limpiarString($nombre);
		
				$desc_campo=substr($RowRept,$posicion,$largo_t);
							
				$pos_primera_coma=strpos($desc_campo,",");
				$pos_primera=$pos_primera_coma-2;
				$id_campo=substr($desc_campo,2,$pos_primera);
				$record["ID"]=limpiarString($id_campo);
				
				$desc_campo=substr($desc_campo,$pos_primera_coma+1,$largo_t);
				
				$pos_segunda_coma=strpos($desc_campo,",");
				$tipo=substr($desc_campo,0,$pos_segunda_coma);
				$record["TYPE"]=limpiarString($tipo);			
				$desc_campo=substr($desc_campo,$pos_segunda_coma+1,$largo_t);
		
		
				if(trim($tipo)=="Array")
				{
					$pos_tercera_coma=strpos($desc_campo,",");
					$tipo_campo_array=substr($desc_campo,0,$pos_tercera_coma);
					$desc_campo=substr($desc_campo,$pos_tercera_coma+1,$largo_t);
					$pos_cuarta_coma=strpos($desc_campo,",");
					$largo=substr($desc_campo,0,$pos_cuarta_coma);
					$desc_campo=substr($desc_campo,$pos_cuarta_coma+1,$largo_t);
					$cuarto_campo=", Tipo Campo Arreglo =>".$tipo_campo_array.", Largo Arreglo=>".$largo.", Valores =>".$desc_campo;
					$texto="";
					$record["TYPE_FIELDS"]=limpiarString($tipo_campo_array);
					$record["LENGTH"]=limpiarString($largo);
					
					$array_desc=explode(",",$desc_campo);
					$rec_arr_=array();
					for($i=0;$i<count($array_desc);$i++)
					{
						
						 $v=$array_desc[$i];
						 $posi=strpos($v,"\\");
						 $v = str_replace( '\\','', $v);
						 if($posi==false)
						 {
							 $rec_array=array("NAME"=>limpiarString(trim($nombre)).$i,"VALUE"=>limpiarString($v),"DELIMITER"=>"0");
						 }
						 else
						 {
							 $rec_array=array("NAME"=>limpiarString(trim($nombre)).$i,"VALUE"=>limpiarString($v),"DELIMITER"=>"1");
						 }
						 $rec_arr_[]=$rec_array;
					}
					$record["VALUES"]=$rec_arr_;
				}
				else
				{
					$pos_tercera_coma=strpos($desc_campo,",");
					if($pos_tercera_coma==false)
					{
						 $valor=$desc_campo;
						 $desc_campo="";
						 $record["VALUE"]=limpiarString($valor);
					}
					else
					{
						$largo=substr($desc_campo,0,$pos_tercera_coma);
						$desc_campo=substr($desc_campo,$pos_tercera_coma+1,$largo_t);
						$valor=$desc_campo;
						$record["LENGTH"]=limpiarString($largo);
						$record["VALUE"]=limpiarString($valor);
					}
				}
				$arr_headers[]=$record;
			}
			else
			{
				$anterior=$RowRept;
				$flag_delimiter=1;
			}
		}
	}
	if(trim($RowRept)=="" and !empty($arr_headers))
	{
		$obj->data = array($arr_headers);
		//Validación de transformación a JSON, crear Archivo y guardar Archivo.
		if(json_encode($obj)!=false)
		{
			$json_file=json_encode($obj);
			if(fopen('IN/'.$FATHER.'.JSON', 'w+')!=false)
			{
				$fp = fopen('IN/'.$FATHER.'.JSON', 'w+');
				if(fwrite($fp, $json_file)!=false)
				{
					fclose($fp);
					$arr_headers=array();
					echo 'Proceso Exitoso <a href="IN/'.$FATHER.'.JSON" target="_blank">'.$FATHER.'.JSON</a> con '.filesize("IN/".$FATHER.".JSON").' bytes<br>';
				}
				else
				{
					echo "Error-Campo-01 - Error al guardar el archivo";
				}
			}
			else
			{
				echo "Error-Campo-02 - Error al abrir el archivo";
			}
		}
		else
		{
			switch(json_last_error()) {
				case JSON_ERROR_NONE:
					echo 'Error-Campo-03 - Sin errores';
				break;
				case JSON_ERROR_DEPTH:
					echo 'Error-Campo-04 - Excedido tamaño máximo de la pila';
				break;
				case JSON_ERROR_STATE_MISMATCH:
					echo 'Error-Campo-05 - Desbordamiento de buffer o los modos no coinciden';
				break;
				case JSON_ERROR_CTRL_CHAR:
					echo 'Error-Campo-06 - Encontrado carácter de control no esperado';
				break;
				case JSON_ERROR_SYNTAX:
					echo 'Error-Campo-07 - Error de sintaxis, JSON mal formado';
				break;
				case JSON_ERROR_UTF8:
					echo 'Error-Campo-08 - Caracteres UTF-8 malformados, posiblemente están mal codificados';
				break;
				case JSON_ERROR_RECURSION:
					echo 'Error-Campo-09 - Una o más referencias recursivas en el valor a codificar';
				break;
				case JSON_ERROR_INF_OR_NAN:
					echo 'Error-Campo-10 - Uno o más valores NAN (Not A Number) o INF (Infinite) en el valor a codificar';
				break;
				case JSON_ERROR_UNSUPPORTED_TYPE:
					echo 'Error-Campo-11 - Se proporcionó un valor de un tipo que no se puede codificar';
				break;
				default:
					echo 'Error-Campo-12 - Error desconocido';
				break;
			}
		}
	}
	$anterior=del_char(trim($RowRept),$corch);
}


//FIN SEGUNDO PASO




//INICIO TERCER PASO, SE OBTIENE LOS SUBNODOS .LIST EN BASE A LA INFORMACIÓN DEL PASO ANTERIOR, ESTO YA QUE SI UN NODO CONTIENE UN SUBNODO .LIST, AL FINAL DE LA DEFINICIÓN DE LOS CAMPOS EN EL NODO, EXISTE UN CAMPO DE NOMBRE "LIST", QUE INDICA EL ID Y LA CANTIDAD DE SUBNODOS QUE CONTIENE...

$flag_campo=0;
$file_campos="";
$echo="";
$array_list=array();
$array_list_fields=array();
$obj = new stdClass();
$json_file="";
$FATHER="";
$anterior="";
$flag_delimiter=0;
$corch=array("[","]");
$cantidad_list=0;
$flag_delimiter=0;
$flag_list_father=0;

// Obtener Campos en base a encabezados, a excepcion de los .List
foreach ($file_eam as $RowRept) 
{
	
	unset($record);
	unset($array_def);
	$array_def=array();
	$array_def_json=array();
	$array_field_json=array();
	if(trim($RowRept)=="")
	{
		$flag_campo=0;
	}
	if (substr(trim($RowRept), 0, 1) == "[" and substr(trim($RowRept), -1) == "]" and in_array(del_char(trim($RowRept),$corch),$array_f)==true) 
	{
		$flag_campo=1;
		$FATHER=del_char(trim($RowRept),$corch);
	}
	
	if($flag_campo==1)
	{
		$record=array();
		if(substr(trim($RowRept), 0, 1) != "[" and substr(trim($RowRept), -1) != "]")
		{
			$record["FATHER"]=$FATHER;
			$posicion=strpos($RowRept,"=");
			$largo_t=strlen($RowRept);
			$nombre=substr($RowRept,0,$posicion);
			if(strtoupper(trim($nombre))=="LIST" || $flag_delimiter==1)
			{
				if($flag_delimiter==0 and substr(trim($RowRept),-1)!="\\")
				{
					$pos_coma=strrpos(trim($RowRept),',');
					$length=strlen(trim($RowRept));
					if($pos_coma==$length-5)
					{
						$cantidad_list=substr(trim($RowRept),-3);
					}
					if($pos_coma==$length-4)
					{
						$cantidad_list=substr(trim($RowRept),-2);
					}
					if($pos_coma==$length-3)
					{
						$cantidad_list=substr(trim($RowRept),-1);
					}
					if($pos_coma==$length-2)
					{
						$cantidad_list=substr(trim($RowRept),-1);
					}
					$flag_list=1;
				}
				if($flag_delimiter==1 and substr(trim($RowRept),-1)!="\\")
				{
					$pos_coma=strrpos(trim($RowRept),',');
					$length=strlen(trim($RowRept));
					if($pos_coma==$length-5)
					{
						$cantidad_list=substr(trim($RowRept),-3);
					}
					if($pos_coma==$length-4)
					{
						$cantidad_list=substr(trim($RowRept),-2);
					}
					if($pos_coma==$length-3)
					{
						$cantidad_list=substr(trim($RowRept),-1);
					}
					if($pos_coma==$length-2)
					{
						$cantidad_list=substr(trim($RowRept),-1);
					}
					$flag_list=1;
					$flag_delimiter=0;
				}
				if(substr(trim($RowRept),-1)=="\\")
				{
					$flag_delimiter=1;
				}
			}
			else
			{
				$flag_list=0;
			}
			
			if($flag_list==1 and $flag_delimiter==0)
			{
				foreach ($file_eam as $RowFile) 
				{
					if(trim($RowFile)!="" and substr(trim($RowFile), 0, 1) != "[")
					{
						if(substr(trim($RowFile), -1) == "\\")
						{
							$anterior=$RowFile;
						}
						else
						{
							$RowFile=$anterior.$RowFile;
							$anterior="";
							if($flag_list_father==1)
							{
								if($flag_def==1)
								{
									$array_def_json=array();
									$text=$RowFile;
									$posicion=strpos($text,"=");
									$largo_t=strlen($text);
									$nombre=substr($text,0,$posicion);
									$text=substr($text,$posicion+1,$largo_t);
									
									$posicion=strpos($text,",");
									$largo_t=strlen($text);
									$id=substr($text,0,$posicion);
									$text=substr($text,$posicion+1,$largo_t);
									
									$posicion=strpos($text,",");
									if($posicion!=false)
									{
										$largo_t=strlen($text);
										$tipo=substr($text,0,$posicion);
										$text=substr($text,$posicion+1,$largo_t);
										$array_def[$nombre]=$tipo;
										switch (trim(strtoupper($tipo))) 
										{
											case "STRING":
												$posicion=strpos($text,",");
												$largo_t=strlen($text);
												$largo_campo=substr($text,0,$posicion);
												$text=substr($text,$posicion+1,$largo_t);
												
												$posicion=strpos($text,",");
												$largo_t=strlen($text);
												$valor_defecto=substr($text,0,$posicion);
												break;
											case "UINT":
												$valor_defecto=$text;
												break;
											case "ULONG":
												$valor_defecto=$text;
												break;
											case "LONG":
												$valor_defecto=$text;
												break;
											case "BOOLEAN":
												$valor_defecto=$text;
												break;
											case "ARRAY":
												$posicion=strpos($text,",");
												$largo_t=strlen($text);
												$tipo_arreglo=substr($text,0,$posicion);
												$text=substr($text,$posicion+1,$largo_t);
												
												$posicion=strpos($text,",");
												$largo_t=strlen($text);
												$largo_arreglo=substr($text,0,$posicion);
												$text=substr($text,$posicion+1,$largo_t);
												
												$array_values=explode(",",$text);
												$rec_arr_=array();
												for($i=0;$i<count($array_values);$i++)
												{
													
													 $v=$array_values[$i];
													 $posi=strpos($v,"\\");
													 if($posi==false)
													 {
														 $value_array=$v;
														 $rec_array=array("NAME"=>limpiarString(trim($nombre))."_".$i,"VALUE"=>limpiarString($value_array),"DELIMITER"=>"0");
													 }
													 else
													 {
														 $value_array=$v;
														 $rec_array=array("NAME"=>limpiarString(trim($nombre))."_".$i,"VALUE"=>limpiarString($value_array),"DELIMITER"=>"1");
													 }
													 $rec_arr_[]=$rec_array;
												}
												break;
										}
									}
									else
									{
										$tipo=trim($text);
										$array_def[trim($nombre)]=$tipo;
									}
									
									if(trim(strtoupper($tipo))!="ARRAY" and trim(strtoupper($tipo))!="STRING")
									{
										$array_def_json["FATHER"]=$list_father_def;
										$array_def_json["NAME_DEF"]=limpiarString(trim($nombre));
										$array_def_json["ID"]=trim($id);
										$array_def_json["TYPE"]=limpiarString(trim($tipo));
										$array_def_json["VALUE"]=limpiarString(trim($valor_defecto));
									}
									elseif(trim(strtoupper($tipo))=="STRING")
									{
										$array_def_json["FATHER"]=$list_father_def;
										$array_def_json["NAME_DEF"]=limpiarString(trim($nombre));
										$array_def_json["ID"]=trim($id);
										$array_def_json["TYPE"]=limpiarString($tipo);
										$array_def_json["LENGTH_DEF"]=trim($largo_campo);
										$array_def_json["VALUE"]=limpiarString(trim($valor_defecto));
									}
									elseif(trim(strtoupper($tipo))=="ARRAY")
									{
										$array_def_json["FATHER"]=$list_father_def;
										$array_def_json["NAME_DEF"]=limpiarString(trim($nombre));
										$array_def_json["ID"]=trim($id);
										$array_def_json["TYPE"]=limpiarString(trim($tipo));
										$array_def_json["TYPE_FIELDS"]=trim($tipo_arreglo);
										$array_def_json["LENGTH"]=trim($largo_arreglo);
										$array_def_json["VALUES"]=$rec_arr_;
									}
									$array_list[]=$array_def_json;
								}
								elseif($flag_fields==1)
								{
									$array_field_json=array();
									$text=$RowFile;
									$posicion=strpos($text,"=");
									$largo_t=strlen($text);
									$nombre=substr($text,0,$posicion);
									if(array_key_exists($nombre,$array_def))
									{
										$text=substr($text,$posicion+1,$largo_t);
										$type_of_field=$array_def[$nombre];
										switch (trim(strtoupper($type_of_field))) 
										{
											case "STRING":
												$value_of_field=trim($text);
												break;
											case "UINT":
												$value_of_field=trim($text);
												break;
											case "ULONG":
												$value_of_field=trim($text);
												break;
											case "LONG":
												$value_of_field=trim($text);
												break;
											case "BOOLEAN":
												$value_of_field=trim($text);
												break;
											case "ARRAY":
												$array_values=explode(",",$text);
												$rec_arr_=array();
												for($i=0;$i<count($array_values);$i++)
												{
													 $v=$array_values[$i];
													 $posi=strpos($v,"\\");
													 if($posi==false)
													 {
														 $value_array=$v;
														 $rec_array=array("NAME"=>limpiarString(trim($nombre))."_".$i,"VALUE"=>limpiarString($value_array),"DELIMITER"=>"0");
													 }
													 else
													 {
														 $value_array=$v;
														 $rec_array=array("NAME"=>limpiarString(trim($nombre))."_".$i,"VALUE"=>limpiarString($value_array),"DELIMITER"=>"1");
													 }
													 $rec_arr_[]=$rec_array;
												}
												break;
										}
										if(trim(strtoupper($type_of_field))!="ARRAY")
										{
											$array_field_json["FATHER"]=$list_father_fields;
											$array_field_json["NAME_FIELD"]=limpiarString($nombre);
											$array_field_json["VALUE"]=limpiarString($value_of_field);
										}
										elseif(trim(strtoupper($type_of_field))=="ARRAY")
										{
											$array_field_json["FATHER"]=$list_father_fields;
											$array_field_json["NAME_FIELD"]=limpiarString($nombre);
											$array_field_json["VALUES"]=$rec_arr_;
										}
										$array_list_fields[]=$array_field_json;
									}
								}
								
								if(trim($RowFile)=="")
								$flag_list_father=0;
							}
						}
						
					}
					if (substr(trim($RowFile), 0, 1) == "[" and substr(trim($RowFile), -1) == "]")
					{
						$father_list=$FATHER.".List";
						if(del_char(trim($RowFile),$corch)==$father_list)
						{
							$flag_list_father=1;
							$flag_def=1;
							$list_father_def=del_char(trim($RowFile),$corch);
						}
						else
						{
							for($i=0;$i<=$cantidad_list;$i++)
							{
								if(del_char(trim($RowFile),$corch)==$FATHER.".List.".$i)
								{
									$flag_list_father=1;
									$flag_fields=1;
									$flag_def=0;
									$list_father_fields=del_char(trim($RowFile),$corch);
									break;	
								}
								else
								{
									$flag_def=0;
									$flag_fields=0;
									$flag_list_father=0;
								}
							}
						}
					}
				}
				
			}
			
		}
	}
	if(trim($RowRept)=="" and !empty($array_list) and !empty($array_list_fields))
	{
		$obj->def = array($array_list);
		$obj->fields = array($array_list_fields);
		$array_list=array();
		$array_list_fields=array();
		//Validación de transformación a JSON, crear Archivo y almacenaje de Archivo.
		if(json_encode($obj)!=false)
		{
			$json_file=json_encode($obj);
			if(fopen('IN/LIST_'.$FATHER.'.JSON', 'w+')!=false)
			{
				$fp = fopen('IN/LIST_'.$FATHER.'.JSON', 'w+');
				if(fwrite($fp, $json_file)!=false)
				{
					fclose($fp);
					echo 'Proceso Exitoso <a href="IN/LIST_'.$FATHER.'.JSON" target="_blank">LIST_'.$FATHER.'.JSON</a> con '.filesize("IN/LIST_".$FATHER.".JSON").' bytes<br>';
				}
				else
				{
					echo "Error-List-01 - Error al guardar el archivo";
				}
			}
			else
			{
				echo "Error-List-02 - Error al abrir el archivo";
			}
		}
		else
		{
			switch(json_last_error()) {
				case JSON_ERROR_NONE:
					echo 'Error-List-03 - Sin errores';
				break;
				case JSON_ERROR_DEPTH:
					echo 'Error-List-04 - Excedido tamaño máximo de la pila';
				break;
				case JSON_ERROR_STATE_MISMATCH:
					echo 'Error-List-05 - JSON con formato incorrecto';
				break;
				case JSON_ERROR_CTRL_CHAR:
					echo 'Error-List-06 - Error del carácter de control, posiblemente se ha codificado de forma incorrecta';
				break;
				case JSON_ERROR_SYNTAX:
					echo 'Error-List-07 - Error de sintaxis, JSON mal formado';
				break;
				case JSON_ERROR_UTF8:
					echo 'Error-List-08 - Caracteres UTF-8 malformados, posiblemente están mal codificados';
				break;
				case JSON_ERROR_RECURSION:
					echo 'Error-List-09 - Una o más referencias recursivas en el valor a codificar';
				break;
				case JSON_ERROR_INF_OR_NAN:
					echo 'Error-List-10 - Uno o más valores NAN (Not A Number) o INF (Infinite) en el valor a codificar';
				break;
				case JSON_ERROR_UNSUPPORTED_TYPE:
					echo 'Error-List-11 - Se proporcionó un valor de un tipo que no se puede codificar';
				break;
				default:
					echo 'Error-List-12 - Error desconocido';
				break;
			}
		}

		
		$flag_campo=0;
	}
	
	$anterior=del_char(trim($RowRept),$corch);
}



?>