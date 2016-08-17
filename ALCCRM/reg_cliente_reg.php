<?php include("session.inc");?>
<?php

$INGRESAR=$_POST["INGRESAR"];
$NEO=$_POST["NEO"];

if ($INGRESAR<>"") {
		if ($NEO==1) { //INGRESA NUEVO CLIENTE

						$COD_TIPOCLIENTE=$_POST["COD_TIPOCLIENTE"];
						$COD_TIPOID=$_POST["COD_TIPOID"];
						$BUSCASTR = '|';
						$POSIC = stripos($COD_TIPOID, $BUSCASTR);
						$COD_TIPOID = substr($COD_TIPOID, 0, $POSIC);
						
						$S1="SELECT * FROM PM_TIPOID WHERE COD_TIPOID=".$COD_TIPOID;
						
						//$RS1 = sqlsrv_query($conn, $S1);
						////oci_execute($RS1);
						$RS1 = sqlsrv_query($conn,$S1); 
						
						while ($row = sqlsrv_fetch_array($RS1)) {
							$TIPO_PERSONA = $row['TIPO_PERSONA'];
						}
						
						$IDENTIFICACION=SINCOMILLAS($_POST["IDENTIFICACION"]);
						if(!empty($IDENTIFICACION)){$IDENTIFICACION=strtoupper($IDENTIFICACION);}
						if ($TIPO_PERSONA==0) { //PERSONA NATURAL
								$NOMBRE=SINCOMILLAS($_POST["NOMBRE_PN"]);
								$APELLIDO_P=SINCOMILLAS($_POST["APELLIDO_P"]);
								$APELLIDO_M=SINCOMILLAS($_POST["APELLIDO_M"]);
								$GENERO=$_POST["GENERO"];
								$DIA_NAC=$_POST["DIA_NAC"];
								$MES_NAC=$_POST["MES_NAC"];
								$ANO_NAC=$_POST["ANO_NAC"];
								$FEC_NACIMIENTO=$DIA_NAC."/".$MES_NAC."/".$ANO_NAC;
								$TEL_PARTICULAR=SINCOMILLAS($_POST["TEL_PARTICULAR"]);
								$TEL_CELULAR=SINCOMILLAS($_POST["TEL_CELULAR"]);
						} else { //PERSONA JURIDICA
								$NOMBRE=SINCOMILLAS($_POST["NOMBRE_PJ"]);
								$APELLIDO_P="";
								$APELLIDO_M="";
								$GENERO="E";
								$DIA_NAC=date("d");
								$MES_NAC=date("m");
								$ANO_NAC=date("Y");
								
								$FEC_NACIMIENTO=$ANO_NAC."-".$MES_NAC."-".$DIA_NAC;
								$TEL_PARTICULAR="";
								$TEL_CELULAR="";
						}
						$DIRECCION=SINCOMILLAS($_POST["DIRECCION"]);
						$COD_REGION=$_POST["COD_REGION"];
						$COD_CIUDAD=$_POST["COD_CIUDAD"];
												
						$COD_POSTAL=SINCOMILLAS($_POST["COD_POSTAL"]);
						$TEL_OFICINA=SINCOMILLAS($_POST["TEL_OFICINA"]);
						$EMAIL=$_POST["EMAIL"];
						
							$SQL="SELECT * FROM OP_CLIENTE WHERE COD_TIPOID=".$COD_TIPOID." AND UPPER(IDENTIFICACION)='". strtoupper($IDENTIFICACION). "' ";
							
							//$RSC = sqlsrv_query($conn, $SQL);
							////oci_execute($RSC);

							$RSC = sqlsrv_query($conn,$SQL);
							

							if ($ROW = sqlsrv_fetch_array($RSC)) {
								header("Location: reg_cliente.php?NEO=1&MSJE=2");
							} else {
								
								//COD_TIPOCLIENTE SQL SERVER AUTO INCREMENT

								//$SQLCLT="INSERT INTO OP_CLIENTE (COD_TIPOCLIENTE, IDENTIFICACION, COD_TIPOID, NOMBRE, APELLIDO_P, APELLIDO_M, GENERO, FEC_NACIMIENTO, DIRECCION, COD_REGION, COD_CIUDAD, COD_POSTAL, TEL_PARTICULAR, TEL_OFICINA, TEL_CELULAR, EMAIL, IDREG) ";
								//$SQLCLT=$SQLCLT." VALUES (".$COD_TIPOCLIENTE.",'".$IDENTIFICACION."',".$COD_TIPOID.",'".$NOMBRE."','".$APELLIDO_P."','".$APELLIDO_M."','".$GENERO."','".$FEC_NACIMIENTO."','".$DIRECCION."',".$COD_REGION.", ".$COD_CIUDAD.",'".$COD_POSTAL."','".$TEL_PARTICULAR."','".$TEL_OFICINA."','".$TEL_CELULAR."','".$EMAIL."',".$SESIDUSU." )";
								

								$SQLCLT="INSERT INTO OP_CLIENTE (COD_TIPOCLIENTE,IDENTIFICACION, COD_TIPOID, NOMBRE, APELLIDO_P, APELLIDO_M, GENERO, FEC_NACIMIENTO, DIRECCION, COD_REGION, COD_CIUDAD, COD_POSTAL, TEL_PARTICULAR, TEL_OFICINA, TEL_CELULAR, EMAIL, IDREG) ";
								$SQLCLT=$SQLCLT." VALUES (".$COD_TIPOCLIENTE.",'".$IDENTIFICACION."',".$COD_TIPOID.",'".$NOMBRE."','".$APELLIDO_P."','".$APELLIDO_M."','".$GENERO."',convert(datetime,'".$FEC_NACIMIENTO."', 121),'".$DIRECCION."',".$COD_REGION.", ".$COD_CIUDAD.",'".$COD_POSTAL."','".$TEL_PARTICULAR."','".$TEL_OFICINA."','".$TEL_CELULAR."','".$EMAIL."',".$SESIDUSU." )";
								

								//$RSCLT = sqlsrv_query($conn, $SQLCLT);
								////oci_execute($RSCLT);
								$RSCLT = sqlsrv_query($conn,$SQLCLT);
								
								$S2="SELECT MAX(COD_CLIENTE) AS MCOD_CLIENTE FROM OP_CLIENTE";
								
								//$RS2 = sqlsrv_query($conn, $S2);
								////oci_execute($RS2);

								$RS2 = sqlsrv_query($conn,$S2);
								
								if ($row = sqlsrv_fetch_array($RS2)) {
										$COD_CLIENTE=$row['MCOD_CLIENTE'];
								}
								
								//REGISTRO DE DATACRM
												$SQLACT="INSERT INTO OP_DATACRM (COD_CLIENTE) VALUES ";
												$SQLACT=$SQLACT."(".$COD_CLIENTE.")";
												
												//$RSL2= sqlsrv_query($conn, $SQLACT);
												////oci_execute($RSL2);
												$RSL2 = sqlsrv_query($conn,$SQLACT);																	

								//REGISTRO DE ACTIVIDAD
										$S2="SELECT COD_CAMPANIA FROM OP_CAMPANIA WHERE IND_ACTIVO=1";
										
										//$RS2 = sqlsrv_query($conn, $S2);
										////oci_execute($RS2);
										$RS2 = sqlsrv_query($conn,$S2);	

										while ($row2 = sqlsrv_fetch_array($RS2)) {
												$COD_CAMPANIA=$row2['COD_CAMPANIA'];
												$SQLACT="INSERT INTO OP_ACTIVIDAD (COD_CAMPANIA, COD_CLIENTE) VALUES ";
												$SQLACT=$SQLACT."(".$COD_CAMPANIA.", ".$COD_CLIENTE.")";
												
												//$RSL2= sqlsrv_query($conn, $SQLACT);
												////oci_execute($RSL2);
												$RSL2 = sqlsrv_query($conn,$SQLACT);																		
										}
								
								//REGISTRO DE MARCAS DE PROCESO
										$S2="SELECT COD_MARCAPRC FROM OP_MARCAPRC";
										
										//$RS2 = sqlsrv_query($conn, $S2);
										////oci_execute($RS2);
										$RS2 = sqlsrv_query($conn,$S2);

										while ($row2 = sqlsrv_fetch_array($RS2)) {
												$COD_MARCAPRC=$row2['COD_MARCAPRC'];
												$SQLACT="INSERT INTO OP_CLIENTEMPRC (COD_CLIENTE) VALUES ";
												$SQLACT=$SQLACT."(".$COD_CLIENTE.")";
												
												//$RSL2= sqlsrv_query($conn, $SQLACT);
												////oci_execute($RSL2);
												$RSL2 = sqlsrv_query($conn,$SQLACT);	

										}
								
								//REGISTRO DE ALTA
										//$S2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";
										//$RS2 = sqlsrv_query($maestra, $S2);
										////oci_execute($RS2);
										//if ($row2 = sqlsrv_fetch_array($RS2)) {
										//		$COD_EVENTO=$row2['MCOD_EVENTO']+1;
										//	} else {
										//		$COD_EVENTO=1;
										//}

										$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
										$SQLOG=$SQLOG."(1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1131, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
										
										//$RSL = sqlsrv_query($maestra, $SQLOG);
										////oci_execute($RSL);
										$RSL = sqlsrv_query($maestra,$SQLOG);																
				
								header("Location: reg_cliente.php?ACT=".$COD_CLIENTE."&MSJE=3");
						}

		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
		//sqlsrv_close($conn);
		//sqlsrv_close($maestra);
		}//FIN NEO=1
		//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		if ($NEO==0) { //ACTUALIZA DATA CLIENTE
						$COD_CLIENTE=$_POST["COD_CLIENTE"];
						$COD_TIPOCLIENTE=$_POST["COD_TIPOCLIENTE"];
						$COD_TIPOID=$_POST["COD_TIPOID"];
						$BUSCASTR = '|';
						$POSIC = stripos($COD_TIPOID, $BUSCASTR);
						$COD_TIPOID = substr($COD_TIPOID, 0, $POSIC);
						
						$S1="SELECT * FROM PM_TIPOID WHERE COD_TIPOID=".$COD_TIPOID;
						
						//$RS1 = sqlsrv_query($conn, $S1);
						////oci_execute($RS1);
						$RS1 = sqlsrv_query($conn,$S1);

						while ($row = sqlsrv_fetch_array($RS1)) {
							$TIPO_PERSONA = $row['TIPO_PERSONA'];
						}
						
						$IDENTIFICACION=SINCOMILLAS($_POST["IDENTIFICACION"]);
						if(!empty($IDENTIFICACION)){$IDENTIFICACION=strtoupper($IDENTIFICACION);}
						if ($TIPO_PERSONA==0) { //PERSONA NATURAL
								$NOMBRE=SINCOMILLAS($_POST["NOMBRE_PN"]);
								$APELLIDO_P=SINCOMILLAS($_POST["APELLIDO_P"]);
								$APELLIDO_M=SINCOMILLAS($_POST["APELLIDO_M"]);
								$GENERO=$_POST["GENERO"];
								$DIA_NAC=$_POST["DIA_NAC"];
								$MES_NAC=$_POST["MES_NAC"];
								$ANO_NAC=$_POST["ANO_NAC"];
								$FEC_NACIMIENTO=$MES_NAC."/".$DIA_NAC."/".$ANO_NAC;
								$TEL_PARTICULAR=SINCOMILLAS($_POST["TEL_PARTICULAR"]);
								$TEL_CELULAR=SINCOMILLAS($_POST["TEL_CELULAR"]);
						} else { //PERSONA JURIDICA
								$NOMBRE=SINCOMILLAS($_POST["NOMBRE_PJ"]);
								$APELLIDO_P="";
								$APELLIDO_M="";
								$GENERO="E";
								$DIA_NAC=date("d");
								$MES_NAC=date("m");
								$ANO_NAC=date("Y");
								$FEC_NACIMIENTO=$MES_NAC."/".$DIA_NAC."/".$ANO_NAC;
								$TEL_PARTICULAR="";
								$TEL_CELULAR="";
						}
						$DIRECCION=SINCOMILLAS($_POST["DIRECCION"]);
						$COD_REGION=$_POST["COD_REGION"];
						$COD_CIUDAD=$_POST["COD_CIUDAD"];
						$COD_POSTAL=SINCOMILLAS($_POST["COD_POSTAL"]);
						$TEL_OFICINA=SINCOMILLAS($_POST["TEL_OFICINA"]);
						$EMAIL=$_POST["EMAIL"];

						
						$SQLM="SELECT DES_CIUDAD FROM PM_CIUDAD WHERE COD_CIUDAD=".$COD_CIUDAD;
						
						//$RS2 = sqlsrv_query($maestra, $SQLM);
						////oci_execute($RS2);
						$RS2 = sqlsrv_query($maestra,$SQLM); 

						while ($row2 = sqlsrv_fetch_array($RS2)) {
							$DES_CIUDAD = $row2['DES_CIUDAD'];
						}
						$DES_DEPARTAMENTO = "";

						
						
						$SQLCLT="UPDATE OP_CLIENTE SET COD_TIPOCLIENTE= ".$COD_TIPOCLIENTE.", NOMBRE='".$NOMBRE."', APELLIDO_P='".$APELLIDO_P."', APELLIDO_M='".$APELLIDO_M."', GENERO='".$GENERO."', FEC_NACIMIENTO= convert(datetime,'".$FEC_NACIMIENTO."', 121), DIRECCION='".$DIRECCION."', ";
						$SQLCLT=$SQLCLT."COD_REGION=".$COD_REGION.", COD_CIUDAD=".$COD_CIUDAD.", COD_POSTAL='".$COD_POSTAL."', TEL_PARTICULAR='".$TEL_PARTICULAR."', TEL_OFICINA='".$TEL_OFICINA."', TEL_CELULAR='".$TEL_CELULAR."', EMAIL='".$EMAIL."', ";
						$SQLCLT=$SQLCLT." IDREG=".$SESIDUSU.", FECHA= convert(datetime,GETDATE(), 121) WHERE COD_CLIENTE=".$COD_CLIENTE;
						
						//$RSCLT = sqlsrv_query($conn, $SQLCLT);
						////oci_execute($RSCLT);

						$RSCLT = sqlsrv_query($conn,$SQLCLT); 

						//REGISTRO DE MODIFICACION
								//$CONSULTA2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";
								
								//$RS2 = sqlsrv_query($conn, $CONSULTA2);
								////oci_execute($RS2);
								//$RS2 = sqlsrv_query($conn,$CONSULTA2);

								//if ($row = sqlsrv_fetch_array($RS2)) {
								//		$COD_EVENTO=$row['MCOD_EVENTO']+1;
								//	} else {
								//		$COD_EVENTO=1;
								//}
										
										$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
										$SQLOG=$SQLOG."(3,convert(datetime,GETDATE(), 121) , '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1131, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
										
										//$RSL = sqlsrv_query($maestra, $SQLOG);
										////oci_execute($RSL);		
										$RSL = sqlsrv_query($maestra,$SQLOG);  															

						header("Location: reg_cliente.php?ACT=".$COD_CLIENTE."&MSJE=1");
		
		//sqlsrv_close($conn);
		//sqlsrv_close($maestra);
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );

		} //FIN ACTUA.IZA DATA CLIENTE
} //FIN INGRESAR
				
				

//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
$ELIMINAR=@$_GET["ELM34534435"];

if ($ELIMINAR<>"") {
		$COD_CLIENTE=@$_GET["COD_CLIENTE"];
		
			$S="DELETE FROM OP_CLIENTE WHERE COD_CLIENTE=".$COD_CLIENTE;
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S); 

			$S="DELETE FROM OP_DATACRM WHERE COD_CLIENTE=".$COD_CLIENTE;
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S); 

			$S="DELETE FROM OP_CLIENTEANT WHERE COD_CLIENTE=".$COD_CLIENTE;
			
			//$RS = sqlsrv_query($conn, $S);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$S);


				//REGISTRO DE BAJA
						//$S2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";
						//$RS2 = sqlsrv_query($conn, $S2);
						////oci_execute($RS2);
						//if ($row = sqlsrv_fetch_array($RS2)) {
						//		$COD_EVENTO=$row['MCOD_EVENTO']+1;
						//	} else {
						//		$COD_EVENTO=1;
						//}
										
										$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
										$SQLOG=$SQLOG."(2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1131, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
										
										//$RSL = sqlsrv_query($maestra, $SQLOG);
										////oci_execute($RSL);
										$RSL = sqlsrv_query($maestra,$SQLOG);																

			header("Location: reg_cliente.php?MSJE=4");
		//sqlsrv_close($conn);
		//sqlsrv_close($maestra);
		sqlsrv_close( $conn );
		sqlsrv_close( $maestra );
}











//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
$REG_CRM=$_POST["REG_CRM"];

if ($REG_CRM<>"") {
		$COD_CLIENTE=$_POST["COD_CLIENTE"];
		$REG_CLIENTE=$_POST["REG_CLIENTE"];

		$COD_NEGOCIO=$_POST["COD_NEGOCIO"];		
		$COD_TIENDA=$_POST["COD_TIENDA"];
		$TIPO_PERSONA=$_POST["TIPO_PERSONA"];
		
		if($TIPO_PERSONA==0){
				$COD_INGRESO=$_POST["COD_INGRESO"];
				$COD_DEMOGRAF=$_POST["COD_DEMOGRAF"];
				$TAM_FAMILIA=$_POST["TAM_FAMILIA"];
				if(empty($TAM_FAMILIA) or $TAM_FAMILIA==0){$TAM_FAMILIA=1;}
				$NUM_HIJOS=$_POST["NUM_HIJOS"];
						$EDAD_HIJO1=$_POST["EDAD_HIJO1"];
						if(empty($EDAD_HIJO1) or $NUM_HIJOS==0){$EDAD_HIJO1=0;}
						$EDAD_HIJO2=$_POST["EDAD_HIJO2"];
						if(empty($EDAD_HIJO2) or $NUM_HIJOS<2){$EDAD_HIJO2=0;}
						$EDAD_HIJO3=$_POST["EDAD_HIJO3"];
						if(empty($EDAD_HIJO3) or $NUM_HIJOS<3){$EDAD_HIJO3=0;}
						$EDAD_HIJO4=$_POST["EDAD_HIJO4"];
						if(empty($EDAD_HIJO4) or $NUM_HIJOS<4){$EDAD_HIJO4=0;}
						$EDAD_HIJO5=$_POST["EDAD_HIJO5"];
						if(empty($EDAD_HIJO5) or $NUM_HIJOS<5){$EDAD_HIJO5=0;}
						$EDAD_HIJO6=$_POST["EDAD_HIJO6"];
						if(empty($EDAD_HIJO6) or $NUM_HIJOS<6){$EDAD_HIJO6=0;}
						$EDAD_HIJO7=$_POST["EDAD_HIJO7"];
						if(empty($EDAD_HIJO7) or $NUM_HIJOS<7){$EDAD_HIJO7=0;}
		} //$TIPO_PERSONA=0
		
		if($REG_CLIENTE==0){ //INSERTA REGISTRO EN OP_DATACRM
					if($TIPO_PERSONA==0){

								
								$SQLCLT="INSERT INTO OP_DATACRM (COD_CLIENTE, COD_TIENDA, COD_NEGOCIO, COD_INGRESO, COD_DEMOGRAF, TAM_FAMILIA, EDAD_HIJO1, EDAD_HIJO2, EDAD_HIJO3, EDAD_HIJO4, EDAD_HIJO5, EDAD_HIJO6, EDAD_HIJO7, FEC_REGISTRO, IDREG) ";
								$SQLCLT=$SQLCLT." VALUES (".$COD_CLIENTE.", ".$COD_TIENDA.", ".$COD_NEGOCIO.", ".$COD_INGRESO.", ".$COD_DEMOGRAF.", ".$TAM_FAMILIA.", ".$EDAD_HIJO1.", ".$EDAD_HIJO2.", ".$EDAD_HIJO3.", ".$EDAD_HIJO4.", ".$EDAD_HIJO5.", ".$EDAD_HIJO6.", ".$EDAD_HIJO7.", convert(datetime,GETDATE(), 121), ".$SESIDUSU." )";
								
								//$RSCLT = sqlsrv_query($conn, $SQLCLT);
								////oci_execute($RSCLT);
								$RSCLT = sqlsrv_query($conn,$SQLCLT);

					} else { //$TIPO_PERSONA=1
								
								$SQLCLT="INSERT INTO OP_DATACRM (COD_CLIENTE, COD_TIENDA, COD_NEGOCIO, FEC_REGISTRO,  IDREG) ";
								$SQLCLT=$SQLCLT." VALUES (".$COD_CLIENTE.", ".$COD_TIENDA.",".$COD_NEGOCIO.", convert(datetime,GETDATE(), 121), ".$SESIDUSU." )";
								
								//$RSCLT = sqlsrv_query($conn, $SQLCLT);
								////oci_execute($RSCLT);

								$RSCLT = sqlsrv_query($conn,$SQLCLT);
					} //$TIPO_PERSONA=0
					//REGISTRO DE ALTA

							//$S2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";
							//$RS2 = sqlsrv_query($conn, $S2);
							////oci_execute($RS2);
							//if ($row = sqlsrv_fetch_array($RS2)) {
							//		$COD_EVENTO=$row['MCOD_EVENTO']+1;
							//	} else {
							//		$COD_EVENTO=1;
							//}
							
							$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
							$SQLOG=$SQLOG."(1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1131, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
							
							//$RSL = sqlsrv_query($maestra, $SQLOG);
							////oci_execute($RSL);

							$RSL = sqlsrv_query($maestra,$SQLOG);																
		} else { //ACTUALIZA REGISTRO

					if($TIPO_PERSONA==0){

								
								$SQLCLT="UPDATE OP_DATACRM SET COD_TIENDA=".$COD_TIENDA.",  COD_NEGOCIO=".$COD_NEGOCIO.",  COD_INGRESO=".$COD_INGRESO.",  COD_DEMOGRAF=".$COD_DEMOGRAF.", ";
								$SQLCLT=$SQLCLT." TAM_FAMILIA=".$TAM_FAMILIA.", EDAD_HIJO1=".$EDAD_HIJO1.", EDAD_HIJO2=".$EDAD_HIJO2.", EDAD_HIJO3=".$EDAD_HIJO3.", EDAD_HIJO4=".$EDAD_HIJO4.", EDAD_HIJO5=".$EDAD_HIJO5.", EDAD_HIJO6=".$EDAD_HIJO6.", EDAD_HIJO7=".$EDAD_HIJO7.", ";
								$SQLCLT=$SQLCLT." IDREG=".$SESIDUSU.", FECHA=convert(datetime,GETDATE(), 121) WHERE COD_CLIENTE=".$COD_CLIENTE;
								
								//$RSCLT = sqlsrv_query($conn, $SQLCLT);
								////oci_execute($RSCLT);
								$RSCLT = sqlsrv_query($conn,$SQLCLT);


					} else { //$TIPO_PERSONA=1
								
								$SQLCLT="UPDATE OP_DATACRM SET COD_TIENDA=".$COD_TIENDA.", COD_NEGOCIO=".$COD_NEGOCIO.", ";
								$SQLCLT=$SQLCLT." IDREG=".$SESIDUSU.", FECHA=convert(datetime,GETDATE(), 121) WHERE COD_CLIENTE=".$COD_CLIENTE;
								
								//$RSCLT = sqlsrv_query($conn, $SQLCLT);
								////oci_execute($RSCLT);
								$RSCLT = sqlsrv_query($conn,$SQLCLT);

					} //$TIPO_PERSONA=0

						//REGISTRO DE MODIFICACION
								//$CONSULTA2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";
								//$RS2 = sqlsrv_query($conn, $CONSULTA2);
								////oci_execute($RS2);
								//if ($row = sqlsrv_fetch_array($RS2)) {
								//		$COD_EVENTO=$row['MCOD_EVENTO']+1;
								//	} else {
								//		$COD_EVENTO=1;
								//}
							
							$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
							$SQLOG=$SQLOG."(3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1131, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
							
							//$RSL = sqlsrv_query($maestra, $SQLOG);
							////oci_execute($RSL);

							$RSL = sqlsrv_query($maestra,$SQLOG); 																

		}//FIN REGISTRO EN OP_DATACRM
		
		//REGISTRAR DATACRM EN OP_DATACLIENTEANT
		$S1="SELECT * FROM MN_DATACRM WHERE (AMBITO=".$TIPO_PERSONA." OR AMBITO=2) AND IND_ACTIVO=1 ORDER BY DES_DATACRM ASC";
		
		//$RS1 = sqlsrv_query($conn, $S1);
		////oci_execute($RS1);
		$RS1 = sqlsrv_query($conn,$S1);
		
		while ($row1 = sqlsrv_fetch_array($RS1)) {
			$COD_DATACRM = $row1['COD_DATACRM'];
			$TIPO_DATACRM = $row1['TIPO_DATACRM'];
			//VERIFICAR SI DATA ESTÁ PRESENTE EN OP_CLIENTEANT
					$DATA_CLIENTE=$_POST["CDCRM".$COD_DATACRM];
					$S2="SELECT * FROM OP_CLIENTEANT WHERE COD_DATACRM=".$COD_DATACRM." AND COD_CLIENTE=".$COD_CLIENTE;
					
					//$RS2 = sqlsrv_query($conn, $S2);
					////oci_execute($RS2);
					$RS2 = sqlsrv_query($conn,$S2);
					
					if ($row2 = sqlsrv_fetch_array($RS2)) {
						//ACTUALIZAR DATA_CLIENTE

						
						$SQLCLT="UPDATE OP_CLIENTEANT SET DATA_CLIENTE='".$DATA_CLIENTE."', ";
						$SQLCLT=$SQLCLT." IDREG=".$SESIDUSU.", FECHA=convert(datetime,GETDATE(), 121) WHERE COD_DATACRM=".$COD_DATACRM." AND COD_CLIENTE=".$COD_CLIENTE;
						
						//$RSCLT = sqlsrv_query($conn, $SQLCLT);
						////oci_execute($RSCLT);
						$RSCLT = sqlsrv_query($conn,$SQLCLT);
					} else {
						
						$SQLCLT="INSERT INTO OP_CLIENTEANT (COD_CLIENTE, COD_DATACRM, DATA_CLIENTE, IDREG, FECHA) VALUES ";
						$SQLCLT=$SQLCLT."(".$COD_CLIENTE.", ".$COD_DATACRM.", '".$DATA_CLIENTE."', ".$SESIDUSU.", convert(datetime,GETDATE(), 121))";
						
						//$RSCLT = sqlsrv_query($conn, $SQLCLT);
						////oci_execute($RSCLT);
						$RSCLT = sqlsrv_query($conn,$SQLCLT);
					}
		}


		header("Location: reg_cliente.php?MSJE=1&ACT_CRM=1&ACT=".$COD_CLIENTE);
		
}//$REG_CRM














//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
$REG_TARJETA=$_POST["REG_TARJETA"];

if ($REG_TARJETA<>"") {
		$COD_CLIENTE=$_POST["COD_CLIENTE"];
		$COD_TIPO_TARJETA=$_POST["COD_TIPO_TARJETA"];
		$NUM_TARJETA=$_POST["NUM_TARJETA"];
		$DIA_ENT=$_POST["DIA_ENT"];
		$MES_ENT=$_POST["MES_ENT"];
		$ANO_ENT=$_POST["ANO_ENT"];
		//$FEC_ENTREGA=$DIA_ENT."/".$MES_ENT."/".$ANO_ENT;
		$FEC_ENTREGA=$ANO_ENT."-".$MES_ENT."-".$DIA_ENT;
		
			$S2="SELECT MAX(COD_TARJETA) AS MCOD_TARJETA FROM OP_TARJETAS";
			
			//$RS2 = sqlsrv_query($conn, $S2);
			////oci_execute($RS2);
			$RS2 = sqlsrv_query($conn,$S2);
			if ($row = sqlsrv_fetch_array($RS2)) {
					$COD_TARJETA=$row['MCOD_TARJETA']+1;
				} else {
					$COD_TARJETA=1;
			}

			$SQLCLT="INSERT INTO OP_TARJETAS (COD_CLIENTE, COD_EST_TARJETA, COD_TIPO_TARJETA, NUM_TARJETA, FEC_ENTREGA,  IDREG) ";
			$SQLCLT=$SQLCLT." VALUES (".$COD_CLIENTE.", 1, ".$COD_TIPO_TARJETA.", '".$NUM_TARJETA."',convert(datetime,'".$FEC_ENTREGA."', 121), ".$SESIDUSU." )";
			//$RSCLT = sqlsrv_query($conn, $SQLCLT);
			////oci_execute($RSCLT);
			$RSCLT = sqlsrv_query($conn,$SQLCLT);

					//REGISTRO DE ALTA
							//$S2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";
							//$RS2 = sqlsrv_query($conn, $S2);
							////oci_execute($RS2);
							//if ($row = sqlsrv_fetch_array($RS2)) {
							//		$COD_EVENTO=$row['MCOD_EVENTO']+1;
							//	} else {
							//		$COD_EVENTO=1;
							//}
							
							$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
							$SQLOG=$SQLOG."(1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1131, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
							//$RSL = sqlsrv_query($maestra, $SQLOG);
							////oci_execute($RSL);
							$RSL = sqlsrv_query($conn,$SQLOG);															

		header("Location: reg_cliente.php?MSJE=3&ACT_TRJ=1&ACT=".$COD_CLIENTE);
}









//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
$ACT_TARJETA=$_POST["ACT_TARJETA"];

if ($ACT_TARJETA<>"") {
		$COD_CLIENTE=$_POST["COD_CLIENTE"];
		$COD_TARJETA=$_POST["COD_TARJETA"];
		$COD_TIPO_TARJETA=$_POST["COD_TIPO_TARJETA"];
		$COD_EST_TARJETA=$_POST["COD_EST_TARJETA"];
		$NUM_TARJETA=$_POST["NUM_TARJETA"];
		$DIA_ENT=$_POST["DIA_ENT"];
		$MES_ENT=$_POST["MES_ENT"];
		$ANO_ENT=$_POST["ANO_ENT"];
		//$FEC_ENTREGA=$DIA_ENT."/".$MES_ENT."/".$ANO_ENT;
		$FEC_ENTREGA=$ANO_ENT."-".$MES_ENT."-".$DIA_ENT;
		
			$SQLCLT="UPDATE OP_TARJETAS SET COD_EST_TARJETA=".$COD_EST_TARJETA.", COD_TIPO_TARJETA=".$COD_TIPO_TARJETA.", NUM_TARJETA='".$NUM_TARJETA."', FEC_ENTREGA=convert(datetime,'".$FEC_ENTREGA."', 121),  ";
			$SQLCLT=$SQLCLT." IDREG=".$SESIDUSU.", FECHA= convert(datetime,GETDATE(), 121) WHERE COD_TARJETA=".$COD_TARJETA;
			
			//$RSCLT = sqlsrv_query($conn, $SQLCLT);
			////oci_execute($RSCLT);
			$RSCLT = sqlsrv_query($conn,$SQLCLT);
						//REGISTRO DE MODIFICACION
								//$CONSULTA2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";
								//$RS2 = sqlsrv_query($conn, $CONSULTA2);
								////oci_execute($RS2);
								//if ($row = sqlsrv_fetch_array($RS2)) {
								//		$COD_EVENTO=$row['MCOD_EVENTO']+1;
								//	} else {
								//		$COD_EVENTO=1;
								//}
							$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
							$SQLOG=$SQLOG."(3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1131, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
							//$RSL = sqlsrv_query($maestra, $SQLOG);
							////oci_execute($RSL);
							$RSL = sqlsrv_query($maestra,$SQLOG);																

		header("Location: reg_cliente.php?MSJE=3&ACT_TRJ=1&ACT=".$COD_CLIENTE);
}
?>
