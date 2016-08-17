<?php include("session.inc");?>
<?php

$INGRESAR=$_POST["INGRESAR"];

if ($INGRESAR<>"") {
		$IDSISTEMA=$_POST["IDSISTEMA"];
		$NOMBRE=COMILLAS($_POST["NOMBRE"]);
		$EDITAR=$_POST["EDITAR"];
		$WM=$_POST["WM"];
		$INGRESO=@$_POST["INGRESO"];
		
			$CONSULTA="SELECT NOMBRE FROM US_PERFIL WHERE UPPER(NOMBRE)='". strtoupper($NOMBRE). "' AND IDSISTEMA=".$IDSISTEMA;
			
			//$RS = sqlsrv_query($conn, $CONSULTA);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$CONSULTA);  

			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_perfil.php?NEO=1&MSJE=1");
			} else {

				$CONSULTA2="SELECT MAX(IDPERFIL) AS MIDPERFIL FROM US_PERFIL";
				
				//$RS2 = sqlsrv_query($conn, $CONSULTA2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$CONSULTA2);

				if ($row = sqlsrv_fetch_array($RS2)) {
						$IDPERFIL=$row['MIDPERFIL']+1;
					} else {
						$IDPERFIL=1;
				}
				$CONSULTA3="INSERT INTO US_PERFIL (IDPERFIL, NOMBRE, EDITAR, WM, IDREG, IDSISTEMA)  ";
				$CONSULTA3=$CONSULTA3." VALUES (".$IDPERFIL.", '".$NOMBRE."', ".$EDITAR.", ".$WM.", ".$SESIDUSU.", ".$IDSISTEMA.")";
				
				//$RS3 = sqlsrv_query($conn, $CONSULTA3);
				////oci_execute($RS3);
				$RS3 = sqlsrv_query($conn,$CONSULTA3); 

						//REGISTRO DE ALTA
						//$CONSULTA2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";
						
						//$RS2 = sqlsrv_query($conn, $CONSULTA2);
						////oci_execute($RS2);

						//if ($row = sqlsrv_fetch_array($RS2)) {
						//		$COD_EVENTO=$row['MCOD_EVENTO']+1;
						//	} else {
						//		$COD_EVENTO=1;
						//}
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1102, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						//$RSL = sqlsrv_query($conn, $SQLOG);
						////oci_execute($RSL);

						$RSL = sqlsrv_query($conn,$SQLOG);														
						
						header("Location: mant_perfil.php?ACT=".$IDPERFIL."&MSJE=7");

		}
}
				
				
$ACTUALIZAR=$_POST["ACTUALIZAR"];

if ($ACTUALIZAR<>"") {
		$OKINGRESO=0;
		$IDPERFIL=$_POST["IDPERFIL"];
		$IDSISTEMA=$_POST["IDSISTEMA"];
		$NOMBRE=COMILLAS($_POST["NOMBRE"]);
		$EDITAR=$_POST["EDITAR"];
		$WM=$_POST["WM"];
		$INGRESO=@$_POST["INGRESO"];
		
		
			$CONSULTA="SELECT NOMBRE FROM US_PERFIL WHERE UPPER(NOMBRE)='". strtoupper($NOMBRE). "' AND IDPERFIL<>".$IDPERFIL." AND IDSISTEMA=".$IDSISTEMA;
			
			//$RS = sqlsrv_query($conn, $CONSULTA);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$CONSULTA); 

			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_perfil.php?ACT=".$IDPERFIL."&MSJE=1");
			} else {
				
				$CONSULTA2="SELECT MAX(IDPERFIL) AS MIDPERFIL FROM US_PERFIL";
				
				//$RS2 = sqlsrv_query($conn, $CONSULTA2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$CONSULTA2);
				
				if ($row = sqlsrv_fetch_array($RS2)) {
						$NEWID=$row['MIDPERFIL']+1;
					} else {
						$NEWID=1;
				}
				$CONSULTA3="INSERT INTO US_PERFIL (IDPERFIL, NOMBRE, EDITAR, WM, IDSISTEMA)  ";
				$CONSULTA3=$CONSULTA3." VALUES (".$NEWID.", 'PERFTEMP', 0, 0, 0)";
				
				//$RS3 = sqlsrv_query($conn, $CONSULTA3);
				////oci_execute($RS3);
				$RS3 = sqlsrv_query($conn,$CONSULTA3);
				
				$CUENTA=0;
				$OKINGRESO=0;
				$CONSULTA2="SELECT IDACC FROM US_ACCESO WHERE IDSISTEMA=".$IDSISTEMA." ORDER BY IDACC ASC";
				
				//$RS2 = sqlsrv_query($conn, $CONSULTA2);
				////oci_execute($RS2);
				$RS2 = sqlsrv_query($conn,$CONSULTA2);
				
				while ($row = sqlsrv_fetch_array($RS2)){
                        $IDACC = $row['IDACC'];
                        $IDACCFRM = @$_POST["IDACC".$IDACC];
						if ($IDACC==$IDACCFRM) {
									if ($INGRESO==$IDACCFRM) {
										$OKINGRESO=1;
										$ELINGRESO=1;
									} else { $ELINGRESO=0; }
									$CONSULTA3="INSERT INTO US_PERFACC (IDPERFIL, IDACC, INGRESO)  ";
									$CONSULTA3=$CONSULTA3." VALUES (".$NEWID.", ".$IDACCFRM.", ".$ELINGRESO.")";
									
									//$RS3 = sqlsrv_query($conn, $CONSULTA3);
									////oci_execute($RS3);
									$RS3 = sqlsrv_query($conn,$CONSULTA3); 
									
									$CUENTA=$CUENTA+1;
						}
				}					

				if ($CUENTA!=0) { 
								if ($OKINGRESO==0) {
										$CONSULTA3="DELETE FROM US_PERFACC WHERE IDPERFIL=".$NEWID;
										
										//$RS3 = sqlsrv_query($conn, $CONSULTA3);
										////oci_execute($RS3);
										$RS3 = sqlsrv_query($conn,$CONSULTA3); 
										
										$CONSULTA3="DELETE FROM US_PERFIL WHERE IDPERFIL=".$NEWID;
										
										//$RS3 = sqlsrv_query($conn, $CONSULTA3);
										////oci_execute($RS3);
										$RS3 = sqlsrv_query($conn,$CONSULTA3); 

										header("Location: mant_perfil.php?ACT=".$IDPERFIL."&MSJE=2");
								} else {
										$CONSULTA3="DELETE FROM US_PERFACC WHERE IDPERFIL=".$IDPERFIL;
										
										//$RS3 = sqlsrv_query($conn, $CONSULTA3);
										////oci_execute($RS3);
										$RS3 = sqlsrv_query($conn,$CONSULTA3); 

										$CONSULTA="SELECT * FROM US_PERFACC WHERE IDPERFIL=".$NEWID;
										
										//$RS = sqlsrv_query($conn, $CONSULTA);
										////oci_execute($RS);
										$RS = sqlsrv_query($conn,$CONSULTA); 

										$CUENTA=0;
										while ($row = sqlsrv_fetch_array($RS)){
												$IDACC2 = $row['IDACC'];
												$INGRESO2 = $row['INGRESO'];
												$CONSULTA3="INSERT INTO US_PERFACC (IDPERFIL, IDACC, INGRESO)  ";
												$CONSULTA3=$CONSULTA3." VALUES (".$IDPERFIL.", '".$IDACC2."', ".$INGRESO2.")";

												//$RS3 = sqlsrv_query($conn, $CONSULTA3);
												////oci_execute($RS3);
												$RS3 = sqlsrv_query($conn,$CONSULTA3); 

										}
										
										$CONSULTA3="DELETE FROM US_PERFACC WHERE IDPERFIL=".$NEWID;
										
										//$RS3 = sqlsrv_query($conn, $CONSULTA3);
										////oci_execute($RS3);
										$RS3 = sqlsrv_query($conn,$CONSULTA3);
										
										$CONSULTA3="DELETE FROM US_PERFIL WHERE IDPERFIL=".$NEWID;
										
										//$RS3 = sqlsrv_query($conn, $CONSULTA3);
										////oci_execute($RS3);

										$RS3 = sqlsrv_query($conn,$CONSULTA3);
										
										$CONSULTA2="UPDATE US_PERFIL SET NOMBRE='".$NOMBRE."', EDITAR=".$EDITAR.", WM=".$WM." , FECHA= convert(datetime,GETDATE(), 121), IDREG=".$SESIDUSU." WHERE IDPERFIL=".$IDPERFIL;
										
										//$RS2 = sqlsrv_query($conn, $CONSULTA2);
										////oci_execute($RS2);
										$RS2 = sqlsrv_query($conn,$CONSULTA2);
				
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
										$SQLOG=$SQLOG."(3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1102, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
										
										//$RSL = sqlsrv_query($conn, $SQLOG);
										////oci_execute($RSL);
										$RSL = sqlsrv_query($conn,$SQLOG);																	
												
										header("Location: mant_perfil.php?ACT=".$IDPERFIL."&MSJE=5");
								}
				} else {
								$CONSULTA3="DELETE FROM US_PERFIL WHERE IDPERFIL=".$NEWID;
								
								//$RS3 = sqlsrv_query($conn, $CONSULTA3);
								////oci_execute($RS3);
								$RS3 = sqlsrv_query($conn,$CONSULTA3); 

								header("Location: mant_perfil.php?ACT=".$IDPERFIL."&MSJE=3");}
		}
}




				
				
$ELIMINAR=@$_GET["ELM"];

if ($ELIMINAR<>"") {
		$IDPERFIL=@$_GET["IDPERFIL"];
		
			$CONSULTA="DELETE FROM US_PERFACC WHERE IDPERFIL=".$IDPERFIL;
			
			//$RS = sqlsrv_query($conn, $CONSULTA);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$CONSULTA);
			
			$CONSULTA="DELETE FROM US_PERFIL WHERE IDPERFIL=".$IDPERFIL;
			
			//$RS = sqlsrv_query($conn, $CONSULTA);
			////oci_execute($RS);
			$RS = sqlsrv_query($conn,$CONSULTA); 
			
			//REGISTRO DE BAJA
					$CONSULTA2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";
					
					//$RS2 = sqlsrv_query($conn, $CONSULTA2);
					////oci_execute($RS2);
					$RS2 = sqlsrv_query($conn,$CONSULTA2);

					if ($row = sqlsrv_fetch_array($RS2)) {
							$COD_EVENTO=$row['MCOD_EVENTO']+1;
						} else {
							$COD_EVENTO=1;
					}
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1102, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						
						//$RSL = sqlsrv_query($conn, $SQLOG);
						////oci_execute($RSL);
						$RSL = sqlsrv_query($conn,$SQLOG); 

			header("Location: mant_perfil.php?MSJE=6");
		
		//sqlsrv_close($conn);
		sqlsrv_close( $conn );
}

?>
