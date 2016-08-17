<?php include("hostsaadmin.php");?>
<?php
				session_start();
				date_default_timezone_set('America/Santiago');

				$IDSUITEACE=1101;
				//$db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521)))(CONNECT_DATA=(SID=xe)))" ;
				//$conecta = oci_connect('SAADMIN', 'SAADMIN', $db);
				$serverName = $HOSTSAADMIN; //serverName\instanceNam
				$connectionInfo = array( "Database"=>"SAADMIN", "UID"=>$INSTANCIA, "PWD"=>$PASSWORD);
				$conecta = sqlsrv_connect( $serverName, $connectionInfo);

				
				//$SQL="ALTER SESSION SET nls_date_format='DD-MM-YYYY";
				//$RSV = sqlsrv_query($conecta, $SQL);
				////oci_execute($RSV);

				//$SQL = "ALTER SESSION SET nls_date_format= 'DD-MM-YYYY' ";
				
				//$RSV = sqlsrv_query($conecta,$SQL);

				$CIERRE=$_GET["cierre"];
				if ($CIERRE<>"") {
					session_unset();
					session_destroy();
					header("Location: index.php");
					exit();
				}
				
				$ENTRAR=$_POST["ENTRAR"];
				if ($ENTRAR<>"") {

						$SALIR=1;
						$CUENTA=$_POST["CUENTA"];
						$CLAVE=$_POST["CLAVE"];
						$CONSULTA="SELECT * FROM US_USUARIOS WHERE CUENTA='".$CUENTA."' AND CLAVE='".$CLAVE."' AND ESTADO=1 AND SU=1";
						//$RSV = sqlsrv_query($conecta, $CONSULTA);
						////oci_execute($RSV);
						$RSV = sqlsrv_query($conecta,$CONSULTA);

						while ($row = sqlsrv_fetch_array($RSV)){
								$IDUSU=$row['IDUSU'];
								$SALIR=2;
						}
						
						if ($SALIR==1) { header("Location: index.php?msj=2"); exit(); }
						if ($SALIR==2) {
							$_SESSION['ARMS_SETP'] = 1;
							$_SESSION['ARMS_SPSDB'] = $db;
							$_SESSION['ARMS_SPSBDU'] = "SAADMIN";
							$_SESSION['ARMS_SPSBDP'] = "SAADMIN";
							header("Location: index.php");
							exit();
						}
				
				
				} //ENTRAR

		//sqlsrv_close($conecta);
		sqlsrv_close( $conecta );

?>


