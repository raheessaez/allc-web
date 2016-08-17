<?php include("hostsaadmin.php");?>
<?php
		$db=$_POST["db"];
		$bdu=$_POST["bdu"];
		$bdp=$_POST["bdp"];

		$ASOCIAR=$_POST["ASOCIAR"];

		if (!empty($ASOCIAR)) {
				$PAISSEL=$_POST["PAISSEL"];

				//$conn = oci_connect($bdu, $bdp, $db);
				//$SQL="ALTER SESSION SET nls_date_format='DD-MM-YYYY";
				//$RSV = sqlsrv_query($conn, $SQL);
				////oci_execute($RSV);

				 $serverName = $HOSTSAADMIN;
                 $connectionInfo = array( "Database"=>$bdu, "UID"=>$INSTANCIA, "PWD"=>$PASSWORD);
                 $conn = sqlsrv_connect( $serverName, $connectionInfo);
                 
                 //$SQL = "ALTER SESSION SET nls_date_format= 'DD-MM-YYYY'";
                 //$RSV = sqlsrv_query($conn,$SQL);


				$SQLP="UPDATE PM_PAIS SET PACTIV=1 WHERE COD_PAIS=".$PAISSEL;
				//$RSP = sqlsrv_query($conn, $SQLP);
				////oci_execute($RSP);
				$RSP = sqlsrv_query($conn,$SQLP);
				
				header("Location:index.php?msj=4");
				exit();

		}

?>