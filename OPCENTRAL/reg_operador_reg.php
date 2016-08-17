<?php include("session.inc");?>
<?php

$INGRESAR=$_POST["INGRESAR"];
$NEO=$_POST["NEO"];

if ($INGRESAR<>"") {
		if ($NEO==1) { //INGRESA NUEVO OPERADOR
				$CC_OPERADOR=$_POST["CC_OPERADOR"];
				$NOMBRE=SINCOMILLAS($_POST["NOMBRE"]);
				$APELLIDO_P=SINCOMILLAS($_POST["APELLIDO_P"]);
				$APELLIDO_M=SINCOMILLAS($_POST["APELLIDO_M"]);
				$DIA_NAC=$_POST["DIA_NAC"];
				$MES_NAC=$_POST["MES_NAC"];
				$ANO_NAC=$_POST["ANO_NAC"];
						$NOMB_ACE=strtoupper($_POST["NOMB_ACE"]);
						$NOMB_ACE=substr($NOMB_ACE, 0, 19);
						$NOMB_ACE=str_replace( "_", " ", $NOMB_ACE); 
				$COD_NEGOCIO=$_POST["COD_NEGOCIO"];
				$DES_CLAVE=$_POST["COD_TIENDA"];
				$ID_MODOPERA=$_POST["ID_MODOPERA"];
				$INICIALES_OP=$_POST["INI_ACE"];
		
				$CONSULTA="SELECT * FROM OP_OPERADOR WHERE CC_OPERADOR=".$CC_OPERADOR;
				$RS = sqlsrv_query($conn, $CONSULTA);
				//oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {
							header("Location: reg_operador.php?NEO=1&MSJE=2&CC=".$CC_OPERADOR."&C1=".$NOMBRE."&C2=".$APELLIDO_P."&C3=".$APELLIDO_M."&C4=".$DIA_NAC."&C5=".$MES_NAC."&C6=".$ANO_NAC."&C7=".$NOMB_ACE."&C8=".$COD_NEGOCIO."&C9=".$COD_TIENDA);
				} else {
							
							$FECHA_NAC=$ANO_NAC."/".$MES_NAC."/".$DIA_NAC;

							$CONSULTA2="SELECT IP, COD_TIENDA FROM MN_TIENDA WHERE DES_CLAVE=".$DES_CLAVE;
							$RS2 = sqlsrv_query($maestra, $CONSULTA2);
							//oci_execute($RS2);
							if ($row = sqlsrv_fetch_array($RS2)) {
									$IP_TIENDA=$row['IP'];
									$COD_TIENDA=$row['COD_TIENDA'];
							}
							$CONSULTA2="SELECT IDENT_CURRENT ('OP_OPERADOR') AS MIDOPERA";
							$RS2 = sqlsrv_query($conn, $CONSULTA2);
							//oci_execute($RS2);
							if ($row = sqlsrv_fetch_array($RS2)) {
									$ID_OPERADOR=$row['MIDOPERA']+1;
								} else {
									$ID_OPERADOR=1;
							}
							
							$CONSULTA2="INSERT INTO OP_OPERADOR (CC_OPERADOR, NOMBRE, APELLIDO_P, APELLIDO_M, FECHA_NAC, NOMB_ACE, COD_NEGOCIO,COD_TIENDA, IP_TIENDA, IDREG,INICIALES_OP) ";
							$CONSULTA2=$CONSULTA2." VALUES (".$CC_OPERADOR.", '".$NOMBRE."', '".$APELLIDO_P."', '".$APELLIDO_M."', convert(datetime,'".$FECHA_NAC."', 111), '".$NOMB_ACE."', ".$COD_NEGOCIO.", ".$DES_CLAVE.", '".$IP_TIENDA."', ".$SESIDUSU.",'".$INICIALES_OP."')";
							$RS2 = sqlsrv_query($conn, $CONSULTA2);
							//oci_execute($RS2);
							
							$CONSULTA2="INSERT INTO OP_OPERAMOV (STR_ESTADO, REG_ESTADO, CC_OPERADOR, COD_NEGOCIO, COD_TIENDA, IDREG, HORA, IP_CLIENTE) ";
							$CONSULTA2=$CONSULTA2." VALUES (0, 0, ".$CC_OPERADOR.", ".$COD_NEGOCIO.", ".$DES_CLAVE.", ".$SESIDUSU.", '".$TIMESRV."', '".$IP_CLIENTE."')";
							$RS2 = sqlsrv_query($conn, $CONSULTA2);
							//oci_execute($RS2);
							
							//REGISTRA GERENTES DE TIENDA (ID_MODOPERA=10) EN SUITE (SAADMIN.US_USUARIOS)
							//if($ID_MODOPERA==10){  //PASAN TODOS
										$CONSULTA2="SELECT IDENT_CURRENT ('US_USUARIOS') AS MIDUSU";
										$RS2 = sqlsrv_query($maestra, $CONSULTA2);
										//oci_execute($RS2);
										if ($row = sqlsrv_fetch_array($RS2)) {
												$IDUSU=$row['MIDUSU']+1;
											} else {
												$IDUSU=1;
										}
										$NOMBUSU=$NOMBRE." ".$APELLIDO_P." ".$APELLIDO_M;
										$CTAACE=str_replace(" ", "", $NOMB_ACE);
										$CONSULTA2="INSERT INTO US_USUARIOS (NOMBRE, CUENTA, CC_OPERADOR, IDREG, FECHA) ";
										$CONSULTA2=$CONSULTA2." VALUES ('".$NOMBUSU."', '".$CTAACE."', ".$CC_OPERADOR.",  ".$SESIDUSU.",convert(datetime,GETDATE(), 121))";
										$RS2 = sqlsrv_query($maestra, $CONSULTA2);
										//oci_execute($RS2);
										
										//ASOCIA TIENDA
										$SQL="INSERT INTO US_USUTND (IDUSU, COD_TIENDA, COD_NEGOCIO, IDREG) ";
										$SQL=$SQL." VALUES (".$IDUSU.", ".$COD_TIENDA.", ".$COD_NEGOCIO.", ".$SESIDUSU.")";
										$RS = sqlsrv_query($maestra, $SQL);
										//oci_execute($RS);
							// }  //PASAN TODOS


							//SI ID_MODOPERA<>0 ENTONCES PRE REGISTRO MODELO DEL OPERADOR
							//if($ID_MODOPERA!=0){ //PASAN TODOS
											//PRIMERO NIVELES DE AUTORIZACIÓN
											$SQL="SELECT * FROM OP_MODOPERA WHERE ID_MODOPERA=".$ID_MODOPERA;
											$RS1 = sqlsrv_query($conn, $SQL);
											//oci_execute($RS1);
											while ($row1 = sqlsrv_fetch_array($RS1)) {
												$NVA_GRUPO = $row1['NVA_GRUPO'];
												$NVA_USUARIO = $row1['NVA_USUARIO'];
												$NIVEL_AUT = $row1['NIVEL_AUT'];
												$SQL2="UPDATE OP_OPERADOR SET NVA_GRUPO=".$NVA_GRUPO.", NVA_USUARIO=".$NVA_USUARIO.", NIVEL_AUT=".$NIVEL_AUT.", ID_MODOPERA=".$ID_MODOPERA." WHERE ID_OPERADOR=".$ID_OPERADOR;
												$RS2 = sqlsrv_query($conn, $SQL2);
												//oci_execute($RS2);
											}
											$SQL="SELECT * FROM OP_MODNVA WHERE ID_MODOPERA=".$ID_MODOPERA." ORDER BY ID_NVLAUTO ASC";
											$RS1 = sqlsrv_query($conn, $SQL);
											//oci_execute($RS1);
											while ($row1 = sqlsrv_fetch_array($RS1)) {
												$ID_NVLAUTO = $row1['ID_NVLAUTO'];
												$VALUENVA = $row1['VALUE'];
												$SQL2="INSERT INTO OP_OPERANVA (ID_OPERADOR, ID_NVLAUTO, VALUE, IDREG) ";
												$SQL2=$SQL2." VALUES (".$ID_OPERADOR.", ".$ID_NVLAUTO.", '".$VALUENVA."', ".$SESIDUSU.")";
												$RS2 = sqlsrv_query($conn, $SQL2);
												//oci_execute($RS2);
											}
											$SQL="SELECT * FROM OP_MODUDF WHERE ID_MODOPERA=".$ID_MODOPERA." ORDER BY ID_NVLAUTO ASC";
											$RS1 = sqlsrv_query($conn, $SQL);
											//oci_execute($RS1);
											while ($row1 = sqlsrv_fetch_array($RS1)) {
												$ID_NVLAUTO = $row1['ID_NVLAUTO'];
												$VALUEUDF = $row1['VALUE'];
												$SQL2="INSERT INTO OP_OPERAUDF (ID_OPERADOR, ID_NVLAUTO, VALUE, IDREG) ";
												$SQL2=$SQL2." VALUES (".$ID_OPERADOR.", ".$ID_NVLAUTO.", '".$VALUEUDF."', ".$SESIDUSU.")";
												$RS2 = sqlsrv_query($conn, $SQL2);
												//oci_execute($RS2);
											}
											//SEGUNDO EL REGISTRO DE AUTORIZACIÓN
											$SQL="SELECT * FROM OP_MODMDA WHERE ID_MODOPERA=".$ID_MODOPERA." ORDER BY ID_INDICAT ASC, ID_INDICATOPC ASC";
											$RS1 = sqlsrv_query($conn, $SQL);
											//oci_execute($RS1);
											while ($row1 = sqlsrv_fetch_array($RS1)) {
												$ID_INDICAT = $row1['ID_INDICAT'];
												$ID_INDICATOPC = $row1['ID_INDICATOPC'];
												$VALUEMDA = $row1['VALUE'];
												$SQL2="INSERT INTO OP_OPERAMDA (ID_OPERADOR, ID_INDICAT, ID_INDICATOPC, VALUE, IDREG) ";
												$SQL2=$SQL2." VALUES (".$ID_OPERADOR.", ".$ID_INDICAT.", ".$ID_INDICATOPC.", '".$VALUEMDA."', ".$SESIDUSU.")";
												$RS2 = sqlsrv_query($conn, $SQL2);
												//oci_execute($RS2);
											}
								
							//} //$ID_MODOPERA!=0  //PASAN TODOS
							
							//REGISTRO DE ALTA
									
								$SQLOG="INSERT INTO LG_EVENTO ( COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
								$SQLOG=$SQLOG."( 1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1127, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
								$RSL = sqlsrv_query($maestra, $SQLOG);
								//oci_execute($RSL);																	
					
								header("Location: reg_operador.php?ACT=".$ID_OPERADOR."&MSJE=3");
				}
		

		sqlsrv_close($conn);
		sqlsrv_close($maestra);
		}//FIN NEO=1
		//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		if ($NEO==2) { //ACTUALIZA DATA OPERADOR
				$ID_OPERADOR=$_POST["ID_OPERADOR"];
				$CC_OPERADOR=$_POST["CC_OPERADOR"];
				$NOMBRE=SINCOMILLAS($_POST["NOMBRE"]);
				$APELLIDO_P=SINCOMILLAS($_POST["APELLIDO_P"]);
				$APELLIDO_M=SINCOMILLAS($_POST["APELLIDO_M"]);
				$DIA_NAC=$_POST["DIA_NAC"];
				$MES_NAC=$_POST["MES_NAC"];
				$ANO_NAC=$_POST["ANO_NAC"];
						$NOMB_ACE=strtoupper($_POST["NOMB_ACE"]);
						$NOMB_ACE=substr($NOMB_ACE, 0, 19);
						$NOMB_ACE=str_replace( "_", " ", $NOMB_ACE); 
				$COD_NEGOCIO=$_POST["COD_NEGOCIO"];
				$DES_CLAVE=$_POST["COD_TIENDA"];
				$INICIALES_OP=$_POST["INI_ACE"];
				
							$CONSULTA2="SELECT IP, COD_TIENDA FROM MN_TIENDA WHERE DES_CLAVE=".$DES_CLAVE;
							$RS2 = sqlsrv_query($maestra, $CONSULTA2);
							//oci_execute($RS2);
							if ($row = sqlsrv_fetch_array($RS2)) {
									$IP_TIENDA=$row['IP'];
									$COD_TIENDA=$row['COD_TIENDA'];
							}
				
				$REG_ESTADO=$_POST["REG_ESTADO"];
				if(empty($REG_ESTADO)){ $REG_ESTADO=0;}

				$ID_MODOPERA=$_POST["ID_MODOPERA"]; //OJO CUANDO ES 10 GERENTE DE TIENDA
		
				$CONSULTA="SELECT * FROM OP_OPERADOR WHERE CC_OPERADOR=".$CC_OPERADOR." AND ID_OPERADOR<>".$ID_OPERADOR;
				$RS = sqlsrv_query($conn, $CONSULTA);
				//oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {
							header("Location: reg_operador.php?NEO=0&MSJE=2&ACT=".$ID_OPERADOR);
				} else {
							$FECHA_NAC=$ANO_NAC."/".$MES_NAC."/".$DIA_NAC;
							//VALIDAR PROCESAMIENTO DE OPERADOR --- STR_ESTADO=1
							$CONSULTA2="SELECT * FROM OP_OPERADOR WHERE ID_OPERADOR=".$ID_OPERADOR;
							$RS2 = sqlsrv_query($conn, $CONSULTA2);
							//oci_execute($RS2);
							if ($row2 = sqlsrv_fetch_array($RS2)) {
									$CC_OPERADOR_OLD=$row2['CC_OPERADOR'];
									//$ID_MODOPERAREG=$row2['ID_MODOPERA'];
									$STR_ESTADO=$row2['STR_ESTADO'];
									$REG_ESTADO_REG=$row2['REG_ESTADO'];
									if(empty($STR_ESTADO)){ $STR_ESTADO=0; }
							}
							if($REG_ESTADO==$REG_ESTADO_REG){
									$STR_ESTADO=4; //ACTUALIZO SÓLO DATA OPERADOR
							}
							//ACTUALIZA OPERADOR
							$CONSULTA2="UPDATE OP_OPERADOR SET CC_OPERADOR=".$CC_OPERADOR.", NOMBRE='".$NOMBRE."', APELLIDO_P='".$APELLIDO_P."', APELLIDO_M='".$APELLIDO_M."', FECHA_NAC=convert(datetime,'".$FECHA_NAC."', 111), NOMB_ACE='".$NOMB_ACE."' ";
							$CONSULTA2=$CONSULTA2.", STR_ESTADO=".$STR_ESTADO.", REG_ESTADO=".$REG_ESTADO.", IDREG=".$SESIDUSU.", FECHA=convert(datetime,GETDATE(), 121),INICIALES_OP='".$INICIALES_OP."' WHERE ID_OPERADOR=".$ID_OPERADOR;
							$RS2 = sqlsrv_query($conn, $CONSULTA2);
							//oci_execute($RS2);
							
							//ACTUALIZA STR_ESTADO SI REG_ESTADO ES DIFERENTE
							if($REG_ESTADO <> $REG_ESTADO_REG){
									$CONSULTA2="UPDATE OP_OPERADOR SET STR_ESTADO=1 WHERE ID_OPERADOR=".$ID_OPERADOR;
									$RS2 = sqlsrv_query($conn, $CONSULTA2);
									//oci_execute($RS2);
							}
							//VERIFICAR CAMBIO DE LOCAL
							$CONSULTA2="SELECT COD_TIENDA, COD_NEGOCIO, COD_TIENDA_ANT FROM OP_OPERADOR WHERE ID_OPERADOR=".$ID_OPERADOR;
							$RS2 = sqlsrv_query($conn, $CONSULTA2);
							//oci_execute($RS2);
							if ($row2 = sqlsrv_fetch_array($RS2)) {
                                    $TIENDA_REG = $row2['COD_TIENDA'];
									$SQL="SELECT IP FROM MN_TIENDA WHERE DES_CLAVE=".$TIENDA_REG;
									$RS3 = sqlsrv_query($maestra, $SQL);
									//oci_execute($RS3);
									if ($row3 = sqlsrv_fetch_array($RS3)) {
											$IP_TIENDA_REG=$row3['IP'];
									}
                                    $NEGOCIO_REG = $row2['COD_NEGOCIO'];
                                    $COD_TIENDA_ANT = $row2['COD_TIENDA_ANT'];
									$SQL="SELECT IP FROM MN_TIENDA WHERE DES_CLAVE=".$COD_TIENDA_ANT;
									$RS3 = sqlsrv_query($maestra, $SQL);
									//oci_execute($RS3);
									if ($row3 = sqlsrv_fetch_array($RS3)) {
											$IP_TIENDA_ANT=$row3['IP'];
									}
							}
							if($TIENDA_REG<>$COD_TIENDA){
									//ACTUALIZAR LOCAL
									$CONSULTA2="UPDATE OP_OPERADOR SET STR_ESTADO=1, COD_TIENDA=".$DES_CLAVE.", IP_TIENDA='".$IP_TIENDA."', COD_NEGOCIO=".$COD_NEGOCIO.", COD_TIENDA_ANT=".$TIENDA_REG." , IP_TIENDA_ANT='".$IP_TIENDA_REG."' , COD_NEGOCIO_ANT=".$NEGOCIO_REG.", INICIALES_OP='".$INICIALES_OP."' WHERE ID_OPERADOR=".$ID_OPERADOR;
									$RS2 = sqlsrv_query($conn, $CONSULTA2);
									//oci_execute($RS2);
							} else {
									//ACTUALIZAR DATA TIENDA (IP)
									$CONSULTA2="UPDATE OP_OPERADOR SET  IP_TIENDA='".$IP_TIENDA."', IP_TIENDA_ANT='".$IP_TIENDA_ANT."'  WHERE ID_OPERADOR=".$ID_OPERADOR;
									$RS2 = sqlsrv_query($conn, $CONSULTA2);
									//oci_execute($RS2);
							}
							
							//ACTUALIZA O REGISTRA SAADMIN.US_USUARIOS, BUSCA POR CC_OPERADOR (CAPTURAR CC_OPERADOR PREVIO A ACTUALIZACION)
							//if($ID_MODOPERAREG==10){  //PASAN TODOS
									$SQLG="SELECT * FROM US_USUARIOS WHERE CC_OPERADOR=".$CC_OPERADOR_OLD;
									$RSG = sqlsrv_query($maestra, $SQLG);
									//oci_execute($RSG);
									if ($rowG = sqlsrv_fetch_array($RSG)) {
											$IDUSU=$rowG['IDUSU'];
											//ACTUALIZA USUARIO
											$NOMBUSU=$NOMBRE." ".$APELLIDO_P." ".$APELLIDO_M;
											$CTAACE=str_replace(" ", "", $NOMB_ACE);
											$SQL="UPDATE US_USUARIOS SET CC_OPERADOR=".$CC_OPERADOR.", NOMBRE='".$NOMBUSU."', CUENTA='".$CTAACE."' ";
											$SQL=$SQL.", IDREG=".$SESIDUSU.", FECHA=convert(datetime,GETDATE(), 121) WHERE IDUSU=".$IDUSU;
											$RS2 = sqlsrv_query($maestra, $SQL);
											//oci_execute($RS2);
											//ASOCIA TIENDA
											//VERIFICA SI TIENE TIENDA ASOCIADA
											$SQL="SELECT COUNT(COD_TIENDA) AS TIENDAS FROM US_USUTND WHERE IDUSU=".$IDUSU;
											$RS2 = sqlsrv_query($maestra, $SQL);
											//oci_execute($RS2);
											if ($row3 = sqlsrv_fetch_array($RS2)) {
													$TIENDAREG=$row3['TIENDAS'];
											}
											if($TIENDAREG>=1){
													$SQL="UPDATE US_USUTND SET COD_TIENDA=".$COD_TIENDA.", COD_NEGOCIO=".$COD_NEGOCIO.", IDREG=".$SESIDUSU.", FECHA=convert(datetime,GETDATE(), 121)  WHERE IDUSU=".$IDUSU;
													$RS = sqlsrv_query($maestra, $SQL);
													//oci_execute($RS);
											} else {
													$SQL="INSERT INTO US_USUTND (IDUSU, COD_TIENDA, COD_NEGOCIO, IDREG) ";
													$SQL=$SQL." VALUES (".$IDUSU.", ".$COD_TIENDA.", ".$COD_NEGOCIO.", ".$SESIDUSU.")";
													$RS = sqlsrv_query($maestra, $SQL);
													//oci_execute($RS);
											}
									} else {
											//NO EXISTE USUARIO... REGISTRAR USUARIO Y TIENDA
												$CONSULTA2="SELECT MAX(IDUSU) AS MIDUSU FROM US_USUARIOS";
												$RS2 = sqlsrv_query($maestra, $CONSULTA2);
												//oci_execute($RS2);
												if ($row = sqlsrv_fetch_array($RS2)) {
														$IDUSU=$row['MIDUSU']+1;
													} else {
														$IDUSU=1;
												}
												$NOMBUSU=$NOMBRE." ".$APELLIDO_P." ".$APELLIDO_M;
												$CTAACE=str_replace(" ", "", $NOMB_ACE);
												$CONSULTA2="INSERT INTO US_USUARIOS (IDUSU, NOMBRE, CUENTA, CC_OPERADOR, IDREG, FECHA) ";
												$CONSULTA2=$CONSULTA2." VALUES (".$IDUSU.", '".$NOMBUSU."', '".$CTAACE."', ".$CC_OPERADOR.",  ".$SESIDUSU.",convert(datetime,GETDATE(), 121))";
												$RS2 = sqlsrv_query($maestra, $CONSULTA2);
												//oci_execute($RS2);
												
												//ASOCIA TIENDA
												$SQL="INSERT INTO US_USUTND (IDUSU, COD_TIENDA, COD_NEGOCIO, IDREG) ";
												$SQL=$SQL." VALUES (".$IDUSU.", ".$COD_TIENDA.", ".$COD_NEGOCIO.", ".$SESIDUSU.")";
												$RS = sqlsrv_query($maestra, $SQL);
												//oci_execute($RS);
											}
							// }  //PASAN TODOS
							
							






							if(!empty($ID_MODOPERA)){
								if($ID_MODOPERA!=0){
									//REASIGNAR MODELOS DE AUTORIZACION
											//PRIMERO NIVELES DE AUTORIZACIÓN
											$SQL="SELECT * FROM OP_MODOPERA WHERE ID_MODOPERA=".$ID_MODOPERA;
											$RS1 = sqlsrv_query($conn, $SQL);
											//oci_execute($RS1);
											while ($row1 = sqlsrv_fetch_array($RS1)) {
												$NVA_GRUPO = $row1['NVA_GRUPO'];
												$NVA_USUARIO = $row1['NVA_USUARIO'];
												$NIVEL_AUT = $row1['NIVEL_AUT'];
												$SQL2="UPDATE OP_OPERADOR SET STR_ESTADO=1, NVA_GRUPO=".$NVA_GRUPO.", NVA_USUARIO=".$NVA_USUARIO.", NIVEL_AUT=".$NIVEL_AUT.", ID_MODOPERA=".$ID_MODOPERA." WHERE ID_OPERADOR=".$ID_OPERADOR;
												$RS2 = sqlsrv_query($conn, $SQL2);
												//oci_execute($RS2);
											}
											$SQL2="DELETE FROM OP_OPERANVA WHERE ID_OPERADOR=".$ID_OPERADOR;
											$RS2 = sqlsrv_query($conn, $SQL2);
											//oci_execute($RS2);
											$SQL="SELECT * FROM OP_MODNVA WHERE ID_MODOPERA=".$ID_MODOPERA." ORDER BY ID_NVLAUTO ASC";
											$RS1 = sqlsrv_query($conn, $SQL);
											//oci_execute($RS1);
											while ($row1 = sqlsrv_fetch_array($RS1)) {
												$ID_NVLAUTO = $row1['ID_NVLAUTO'];
												$VALUENVA = $row1['VALUE'];
												$SQL2="INSERT INTO OP_OPERANVA (ID_OPERADOR, ID_NVLAUTO, VALUE, IDREG) ";
												$SQL2=$SQL2." VALUES (".$ID_OPERADOR.", ".$ID_NVLAUTO.", '".$VALUENVA."', ".$SESIDUSU.")";
												$RS2 = sqlsrv_query($conn, $SQL2);
												//oci_execute($RS2);
											}
											$SQL2="DELETE FROM OP_OPERAUDF WHERE ID_OPERADOR=".$ID_OPERADOR;
											$RS2 = sqlsrv_query($conn, $SQL2);
											//oci_execute($RS2);
											$SQL="SELECT * FROM OP_MODUDF WHERE ID_MODOPERA=".$ID_MODOPERA." ORDER BY ID_NVLAUTO ASC";
											$RS1 = sqlsrv_query($conn, $SQL);
											//oci_execute($RS1);
											while ($row1 = sqlsrv_fetch_array($RS1)) {
												$ID_NVLAUTO = $row1['ID_NVLAUTO'];
												$VALUEUDF = $row1['VALUE'];
												$SQL2="INSERT INTO OP_OPERAUDF (ID_OPERADOR, ID_NVLAUTO, VALUE, IDREG) ";
												$SQL2=$SQL2." VALUES (".$ID_OPERADOR.", ".$ID_NVLAUTO.", '".$VALUEUDF."', ".$SESIDUSU.")";
												$RS2 = sqlsrv_query($conn, $SQL2);
												//oci_execute($RS2);
											}
											//SEGUNDO EL REGISTRO DE AUTORIZACIÓN
											$SQL2="DELETE FROM OP_OPERAMDA WHERE ID_OPERADOR=".$ID_OPERADOR;
											$RS2 = sqlsrv_query($conn, $SQL2);
											//oci_execute($RS2);
											$SQL="SELECT * FROM OP_MODMDA WHERE ID_MODOPERA=".$ID_MODOPERA." ORDER BY ID_INDICAT ASC, ID_INDICATOPC ASC";
											$RS1 = sqlsrv_query($conn, $SQL);
											//oci_execute($RS1);
											while ($row1 = sqlsrv_fetch_array($RS1)) {
												$ID_INDICAT = $row1['ID_INDICAT'];
												$ID_INDICATOPC = $row1['ID_INDICATOPC'];
												$VALUEMDA = $row1['VALUE'];
												$SQL2="INSERT INTO OP_OPERAMDA (ID_OPERADOR, ID_INDICAT, ID_INDICATOPC, VALUE, IDREG) ";
												$SQL2=$SQL2." VALUES (".$ID_OPERADOR.", ".$ID_INDICAT.", ".$ID_INDICATOPC.", '".$VALUEMDA."', ".$SESIDUSU.")";
												$RS2 = sqlsrv_query($conn, $SQL2);
												//oci_execute($RS2);
											}
								}
							}
							
							$CONSULTA2="INSERT INTO OP_OPERAMOV (ID_OPERADOR, STR_ESTADO, REG_ESTADO, CC_OPERADOR, COD_NEGOCIO, COD_TIENDA, IDREG, HORA, IP_CLIENTE) ";
							$CONSULTA2=$CONSULTA2." VALUES (".$ID_OPERADOR.", ".$STR_ESTADO.", ".$REG_ESTADO.", ".$CC_OPERADOR.", ".$COD_NEGOCIO.", ".$DES_CLAVE.", ".$SESIDUSU.", '".$TIMESRV."', '".$IP_CLIENTE."')";
							$RS2 = sqlsrv_query($conn, $CONSULTA2);

							//oci_execute($RS2);

							//REGISTRO DE MODIFICACION
									
									$SQLOG="INSERT INTO LG_EVENTO ( COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
									$SQLOG=$SQLOG."( 3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1127, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
									$RSL = sqlsrv_query($maestra, $SQLOG);
									//oci_execute($RSL);																	
			

									header("Location: reg_operador.php?ACT=".$ID_OPERADOR."&MSJE=1");
				}
		

		sqlsrv_close($conn);
		sqlsrv_close($maestra);
		} //FIN ACTUALIZA DATA OPERADOR
} //FIN INGRESAR
?>




<?php include("reg_operador_reg_nva.php");?>




<?php
$REGIND=$_POST["REGIND"];
$ID_OPERADOR=$_POST["ID_OPERADOR"];
$ID_INDICAT=$_POST["ID_INDICAT"];

if ($REGIND<>"" ) {
	//VERIFICAR SI OPERADOR ESTA REGISTRADO PREVIAMENTE
	$CONSULTA="SELECT * FROM OP_OPERAMDA WHERE ID_OPERADOR=".$ID_OPERADOR;
	$RS = sqlsrv_query($conn, $CONSULTA);
	//oci_execute($RS);
	if ($row = sqlsrv_fetch_array($RS)) {
				//ACTUALIZA REGISTROS PARA LA ID_INDICAT
				$CONSULTA1="SELECT * FROM OP_INDICATOPC WHERE ID_INDICAT=".$ID_INDICAT." ORDER BY POSICION ASC";
				$RS1 = sqlsrv_query($conn, $CONSULTA1);
				//oci_execute($RS1);
				while ($row = sqlsrv_fetch_array($RS1)) {
						$ID_INDICATOPC=$row['ID_INDICATOPC'];
						$VERIFICA=$_POST["IND".$ID_INDICATOPC];
						if($VERIFICA==1){
								$CONSULTA2="UPDATE OP_OPERAMDA SET  VALUE=1, IDREG=".$SESIDUSU.", FECHA=convert(datetime,GETDATE(), 121) WHERE ID_INDICATOPC=".$ID_INDICATOPC." AND ID_OPERADOR=".$ID_OPERADOR;
								$RS2 = sqlsrv_query($conn, $CONSULTA2);
								//oci_execute($RS2);
						} else {
								$CONSULTA2="UPDATE OP_OPERAMDA SET  VALUE=0, IDREG=".$SESIDUSU.", FECHA=convert(datetime,GETDATE(), 121)  WHERE ID_INDICATOPC=".$ID_INDICATOPC." AND ID_OPERADOR=".$ID_OPERADOR;
								$RS2 = sqlsrv_query($conn, $CONSULTA2);
								//oci_execute($RS2);
						}
				}
	} else {
				//REGISTRA ID_INDICAT POR DEFAULT
				
				$CONSULTA1="SELECT * FROM OP_INDICATOPC ORDER BY POSICION ASC";
				$RS1 = sqlsrv_query($conn, $CONSULTA1);
				//oci_execute($RS1);
				while ($row = sqlsrv_fetch_array($RS1)) {
					$ID_INDICATREG=$row['ID_INDICAT'];
					$ID_INDICATOPC=$row['ID_INDICATOPC'];
					$CONSULTA2="INSERT INTO OP_OPERAMDA (ID_OPERADOR, ID_INDICAT, ID_INDICATOPC, IDREG) VALUES (".$ID_OPERADOR.", ".$ID_INDICATREG.",  ".$ID_INDICATOPC.", ".$SESIDUSU.")";
					$RS2 = sqlsrv_query($conn, $CONSULTA2);
					//oci_execute($RS2);
				}
				
				$CONSULTA1="SELECT * FROM OP_INDICATOPC WHERE ID_INDICAT=".$ID_INDICAT." ORDER BY POSICION ASC";
				$RS1 = sqlsrv_query($conn, $CONSULTA1);
				//oci_execute($RS1);
				while ($row = sqlsrv_fetch_array($RS1)) {
						$ID_INDICATOPC=$row['ID_INDICATOPC'];
						$VERIFICA=$_POST["IND".$ID_INDICATOPC];
						if($VERIFICA==1){
								$CONSULTA2="UPDATE OP_OPERAMDA SET  VALUE=1, IDREG=".$SESIDUSU.", FECHA=convert(datetime,GETDATE(), 121) WHERE ID_INDICATOPC=".$ID_INDICATOPC." AND ID_OPERADOR=".$ID_OPERADOR;
								$RS2 = sqlsrv_query($conn, $CONSULTA2);
								//oci_execute($RS2);
						}
				}
	}
	header("Location: reg_operador.php?ACT=".$ID_OPERADOR."&MSJE=5&ACT_MDA=1");
}// FIN REGIND

?>
