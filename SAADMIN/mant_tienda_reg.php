<?php include("session.inc");?>
<?php
$REGISTRAR=@$_POST["REGISTRAR"];

if ($REGISTRAR<>"") {
		$DES_CLAVE=$_POST["DES_CLAVE"];
		$DES_TIENDA=SINCOMILLAS(strtoupper($_POST["DES_TIENDA"]));
		$DIRECCION=SINCOMILLAS($_POST["DIRECCION"]);
		$COD_REGION=$_POST["COD_REGION"];
		$COD_CIUDAD=$_POST["COD_CIUDAD"];
		$IP=$_POST["IP"];
		$IVA_TAX=$_POST["IVA_TAX"];
		$INC_PRC=$_POST["INC_PRC"];
		$IMP_1=$_POST["IMP_1"];
		$REC_NO_AFILIADO=$_POST["REC_NO_AFILIADO"];
		if(isset($_POST["NO_AFIL_FL"]))
		{
			$NO_AFIL_FL=0;
		}
		else
		{
			$NO_AFIL_FL=1;
		}
			if(empty($IMP_1)){ $IMP_1=0;} else {
			$IMP_1=str_replace ( ".", "", $IMP_1);}
		$IMP_2=$_POST["IMP_2"];
			if(empty($IMP_2)){ $IMP_2=0;} else {
			$IMP_2=str_replace ( ".", "", $IMP_2);}
		$IMP_3=$_POST["IMP_3"];
			if(empty($IMP_3)){ $IMP_3=0;} else {
			$IMP_3=str_replace ( ".", "", $IMP_3);}
		$IMP_4=$_POST["IMP_4"];
			if(empty($IMP_4)){ $IMP_4=0;} else {
			$IMP_4=str_replace ( ".", "", $IMP_4);}
		$IMP_5=$_POST["IMP_5"];
			if(empty($IMP_5)){ $IMP_5=0;} else {
			$IMP_5=str_replace ( ".", "", $IMP_5);}
		$IMP_6=$_POST["IMP_6"];
			if(empty($IMP_6)){ $IMP_6=0;} else {
			$IMP_6=str_replace ( ".", "", $IMP_6);}
		$IMP_7=$_POST["IMP_7"];
			if(empty($IMP_7)){ $IMP_7=0;} else {
			$IMP_7=str_replace ( ".", "", $IMP_7);}
		$IMP_8=$_POST["IMP_8"];
			if(empty($IMP_8)){ $IMP_8=0;} else {
			$IMP_8=str_replace ( ".", "", $IMP_8);}
		
			$CONSULTA="SELECT * FROM MN_TIENDA WHERE (UPPER(DES_TIENDA)='". strtoupper($DES_TIENDA). "'  ) OR DES_CLAVE=".$DES_CLAVE;
			$RS = sqlsrv_query($conn, $CONSULTA);
			//oci_execute($RS);
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_tienda.php?NEO=1&MSJE=4");
			} else {

				$CONSULTA2="INSERT INTO MN_TIENDA ( DES_CLAVE, DES_TIENDA, DIRECCION, COD_REGION, COD_CIUDAD, IP, IDREG) ";
				$CONSULTA2=$CONSULTA2." VALUES (".$DES_CLAVE.",'".$DES_TIENDA."', '".$DIRECCION."', ".$COD_REGION.", ".$COD_CIUDAD.", '".$IP."',".$SESIDUSU.")";
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				//oci_execute($RS2);

				$CONSULTA2="SELECT IDENT_CURRENT ('MN_TIENDA') AS COD_TIENDA";
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				//oci_execute($RS2);
				if ($row = sqlsrv_fetch_array($RS2)) {
						$COD_TIENDA=$row['COD_TIENDA'];
				}

				$S1="SELECT * FROM MN_SOCIEDAD ORDER BY DES_SOC ASC";
				$RS1 = sqlsrv_query($conn, $S1);
				//oci_execute($RS1);
				while ($row = sqlsrv_fetch_array($RS1)) {
					$COD_SOC = $row['COD_SOC'];
					if(!empty($_POST["CDSOC".$COD_SOC])){
							$S2="INSERT INTO MN_TNDSOC (COD_TIENDA, COD_SOC) VALUES (".$COD_TIENDA.", ".$COD_SOC.")";
							$RS2 = sqlsrv_query($conn, $S2);
							//oci_execute($RS2);			
					}
				}

				$S1="SELECT * FROM MN_NEGOCIO ORDER BY DES_NEGOCIO ASC";
				$RS1 = sqlsrv_query($conn, $S1);
				//oci_execute($RS1);
				while ($row = sqlsrv_fetch_array($RS1)) {
					$COD_NEGOCIO = $row['COD_NEGOCIO'];
					if(!empty($_POST["CDNEG".$COD_NEGOCIO])){
							$S2="INSERT INTO MN_NEGTND (COD_NEGOCIO, COD_TIENDA) VALUES (".$COD_NEGOCIO.", ".$COD_TIENDA.")";
							$RS2 = sqlsrv_query($conn, $S2);
							//oci_execute($RS2);			
					}
				}

							$S3="SELECT IDENT_CURRENT ('PA_STR_RTL') AS ID_BSN_UN";
							$RS3 = sqlsrv_query($arts_conn, $S3);
							//oci_execute($RS3);
							if ($row3 = sqlsrv_fetch_array($RS3)) {
									$ID_BSN_UN=$row3['ID_BSN_UN']+1;
								} else {
									$ID_BSN_UN=1;
							}
							$CONSULTA2="INSERT INTO PA_STR_RTL ( DE_STR_RT, CD_STR_RT, IMP_1, IMP_2, IMP_3, IMP_4, IMP_5, IMP_6, IMP_7, IMP_8, IVA_TAX, INC_PRC,NO_AFIL_FL,REC_NO_AFILIADO) ";
							$CONSULTA2=$CONSULTA2." VALUES ('".$DES_TIENDA."', ".$DES_CLAVE.", ".$IMP_1.", ".$IMP_2.", ".$IMP_3.", ".$IMP_4.", ".$IMP_5.", ".$IMP_6.", ".$IMP_7.", ".$IMP_8.",'".$IVA_TAX."','".$INC_PRC."',".$NO_AFIL_FL.",".$REC_NO_AFILIADO.")";
							$RS2 = sqlsrv_query($arts_conn, $CONSULTA2);
							//oci_execute($RS2);
			
				//REGISTRO DE MODIFICACION
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1113, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($conn, $SQLOG);
						//oci_execute($RSL);																	

																		
				header("Location: mant_tienda.php?ACT=".$COD_TIENDA."&MSJE=3");
		}
}
				
				
				
$ACTUALIZAR=@$_POST["ACTUALIZAR"];

if ($ACTUALIZAR<>"") {
		$DES_CLAVE=$_POST["DES_CLAVE"];
		$COD_TIENDA=$_POST["COD_TIENDA"];
		$DES_TIENDA=SINCOMILLAS(strtoupper($_POST["DES_TIENDA"]));
		$DIRECCION=SINCOMILLAS($_POST["DIRECCION"]);
		$COD_REGION=$_POST["COD_REGION"];
		$COD_CIUDAD=$_POST["COD_CIUDAD"];
		$IP=$_POST["IP"];
		$IND_ACTIVO=$_POST["IND_ACTIVO"];
		$REC_NO_AFILIADO=$_POST["REC_NO_AFILIADO"];
		if(isset($_POST["NO_AFIL_FL"]))
		{
			$NO_AFIL_FL=0;
		}
		else
		{
			$NO_AFIL_FL=1;
		}
					//en ARTS
					$IVA_TAX=$_POST["IVA_TAX"];
					$INC_PRC=$_POST["INC_PRC"];
					$IMP_1=$_POST["IMP_1"];
						if(empty($IMP_1)){ $IMP_1=0;} else {
						$IMP_1=str_replace ( ".", "", $IMP_1);}
					$IMP_2=$_POST["IMP_2"];
						if(empty($IMP_2)){ $IMP_2=0;} else {
						$IMP_2=str_replace ( ".", "", $IMP_2);}
					$IMP_3=$_POST["IMP_3"];
						if(empty($IMP_3)){ $IMP_3=0;} else {
						$IMP_3=str_replace ( ".", "", $IMP_3);}
					$IMP_4=$_POST["IMP_4"];
						if(empty($IMP_4)){ $IMP_4=0;} else {
						$IMP_4=str_replace ( ".", "", $IMP_4);}
					$IMP_5=$_POST["IMP_5"];
						if(empty($IMP_5)){ $IMP_5=0;} else {
						$IMP_5=str_replace ( ".", "", $IMP_5);}
					$IMP_6=$_POST["IMP_6"];
						if(empty($IMP_6)){ $IMP_6=0;} else {
						$IMP_6=str_replace ( ".", "", $IMP_6);}
					$IMP_7=$_POST["IMP_7"];
						if(empty($IMP_7)){ $IMP_7=0;} else {
						$IMP_7=str_replace ( ".", "", $IMP_7);}
					$IMP_8=$_POST["IMP_8"];
						if(empty($IMP_8)){ $IMP_8=0;} else {
						$IMP_8=str_replace ( ".", "", $IMP_8);}
		
			$CONSULTA="SELECT * FROM MN_TIENDA WHERE (UPPER(DES_TIENDA)='". strtoupper($DES_TIENDA). "'  ) AND COD_TIENDA<>".$COD_TIENDA;
			$RS = sqlsrv_query($conn, $CONSULTA);
			//oci_execute($RS);
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_tienda.php?ACT=".$COD_TIENDA."&MSJE=2");
			} else {
				$CONSULTA2="UPDATE MN_TIENDA SET DES_TIENDA='".$DES_TIENDA."', DES_CLAVE=".$DES_CLAVE.", IP='".$IP."', DIRECCION='".$DIRECCION."', COD_REGION=".$COD_REGION.", COD_CIUDAD=".$COD_CIUDAD." ";
				$CONSULTA2=$CONSULTA2.", IND_ACTIVO=".$IND_ACTIVO.", IDREG=".$SESIDUSU.", FECHA=convert(datetime,GETDATE(), 121) ";
				$CONSULTA2=$CONSULTA2." WHERE COD_TIENDA=".$COD_TIENDA;
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				//oci_execute($RS2);
				
							//en ARTS
							$CONSULTA2="UPDATE PA_STR_RTL SET DE_STR_RT='".$DES_TIENDA."', IMP_1=".$IMP_1.", IMP_2=".$IMP_2.", IMP_3=".$IMP_3.", IMP_4=".$IMP_4.", IMP_5=".$IMP_5.", IMP_6=".$IMP_6.", IMP_7=".$IMP_7.", IMP_8=".$IMP_8. ", REC_NO_AFILIADO=".$REC_NO_AFILIADO. ", NO_AFIL_FL=".$NO_AFIL_FL. " ";
							$CONSULTA2=$CONSULTA2.", IVA_TAX='".$IVA_TAX."', INC_PRC='".$INC_PRC."' ";
							$CONSULTA2=$CONSULTA2." WHERE CD_STR_RT=".$DES_CLAVE;
							$RS2 = sqlsrv_query($arts_conn, $CONSULTA2);
							//oci_execute($RS2);
				
				$S1="DELETE FROM MN_TNDSOC WHERE COD_TIENDA= ".$COD_TIENDA;
				$RS1 = sqlsrv_query($conn, $S1);
				//oci_execute($RS1);			
				$S1="SELECT * FROM MN_SOCIEDAD ORDER BY DES_SOC ASC";
				$RS1 = sqlsrv_query($conn, $S1);
				//oci_execute($RS1);
				while ($row = sqlsrv_fetch_array($RS1)) {
					$COD_SOC = $row['COD_SOC'];
					if(!empty($_POST["CDSOC".$COD_SOC])){
							$S2="INSERT INTO MN_TNDSOC (COD_SOC, COD_TIENDA) VALUES (".$COD_SOC.", ".$COD_TIENDA.")";
							$RS2 = sqlsrv_query($conn, $S2);
							//oci_execute($RS2);			
					}
				}
				 
				$S1="DELETE FROM MN_NEGTND WHERE COD_TIENDA= ".$COD_TIENDA;
				$RS1 = sqlsrv_query($conn, $S1);
				//oci_execute($RS1);			
				$S1="SELECT * FROM MN_NEGOCIO ORDER BY DES_NEGOCIO ASC";
				$RS1 = sqlsrv_query($conn, $S1);
				//oci_execute($RS1);
				while ($row = sqlsrv_fetch_array($RS1)) {
					$COD_NEGOCIO = $row['COD_NEGOCIO'];
					if(!empty($_POST["CDNEG".$COD_NEGOCIO])){
							$S2="INSERT INTO MN_NEGTND (COD_NEGOCIO, COD_TIENDA) VALUES (".$COD_NEGOCIO.", ".$COD_TIENDA.")";
							$RS2 = sqlsrv_query($conn, $S2);
							//oci_execute($RS2);			
					}
				}
				 
				//REGISTRO DE MODIFICACION
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1113, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($conn, $SQLOG);
						//oci_execute($RSL);			
						
																				
				header("Location: mant_tienda.php?ACT=".$COD_TIENDA."&MSJE=1");
		}
}
				
				
?>
