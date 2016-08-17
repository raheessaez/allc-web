<?php
		session_start();
		
		//OBTENGO DATA MODULO
		$BDUSER = $_SESSION['ARMS_BDUSER'];
		$BDPASSWORD = $_SESSION['ARMS_BDPASS'];
		$BDIP=$_SESSION['ARMS_BDIP'];
		$SESIDSUITEACE=$_SESSION['ARMS_IDSUITE'];
		$BDINS = $_SESSION['ARMS_BDINS'];
		//CONEXION BD MODULO
		//$db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = ".$BDIP.")(PORT = 1521)))(CONNECT_DATA=(SID=xe)))" ;
		//$conn = oci_connect( $BDUSER , $BDPASSWORD , $db);
		//$SQL="ALTER SESSION SET nls_date_format='DD-MM-YYYY'";
		//$RS = sqlsrv_query($conn, $SQL);
		//oci_execute($RS);
		$serverName = $BDIP;
        $connectionInfo = array( "Database"=>$BDUSER, "UID"=>$BDINS, "PWD"=>$BDPASSWORD);
        $conn = sqlsrv_connect( $serverName, $connectionInfo);

		
		//OBTENGO DATA MAESTRA
		$M_BDUSER = $_SESSION['ARMS_MA_BDUSER'];
		$M_BDPASSWORD = $_SESSION['ARMS_MA_BDPASS'];
		$M_BDIP=$_SESSION['ARMS_MA_BDIP'];
		$M_BDINS=$_SESSION['ARMS_MA_BDINS'];
		//CONEXION MAESTRA
		//$M_DB = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = ".$M_BDIP.")(PORT = 1521)))(CONNECT_DATA=(SID=xe)))" ;
		//$maestra = oci_connect( $M_BDUSER , $M_BDPASSWORD , $M_DB);
		//$M_SQL="ALTER SESSION SET nls_date_format='DD-MM-YYYY'";
		//$M_RS = sqlsrv_query($maestra, $M_SQL);
		//oci_execute($M_RS);
		$serverName = $BDIP;
        $connectionMaster = array( "Database"=>$M_BDUSER, "UID"=>$BDINS, "PWD"=>$BDPASSWORD);
        $maestra = sqlsrv_connect( $serverName, $connectionMaster);
		
		//OBTENGO DATA EYES
		$ARMS_EYES_BDIP = $_SESSION['ARMS_EYES_BDIP'];
		$ARMS_EYES_BDUSER = $_SESSION['ARMS_EYES_BDUSER'];
		$ARMS_EYES_BDPASS=$_SESSION['ARMS_EYES_BDPASS'];
		$ARMS_EYES_BDINS=$_SESSION['ARMS_EYES_BDINS'];
		//CONEXION EYES

		$serverName = $ARMS_EYES_BDIP;
        $connectionEyes = array( "Database"=>$ARMS_EYES_BDUSER, "UID"=>$ARMS_EYES_BDINS, "PWD"=>$ARMS_EYES_BDPASS);
        $EYES = sqlsrv_connect( $serverName, $connectionEyes);
		
		//OBTENGO DATA ARTS_EC
		$ARMS_ARTS_EC_BDIP = $_SESSION['ARMS_ARTS_EC_BDIP'];
		$ARMS_ARTS_EC_BDUSER = $_SESSION['ARMS_ARTS_EC_BDUSER'];
		$ARMS_ARTS_EC_BDPASS=$_SESSION['ARMS_ARTS_EC_BDPASS'];
		$ARMS_ARTS_EC_BDINS=$_SESSION['ARMS_ARTS_EC_BDINS'];
		//CONEXION ARTS_EC

		$serverName = $ARMS_ARTS_EC_BDIP;
        $connectionArts = array( "Database"=>$ARMS_ARTS_EC_BDUSER, "UID"=>$ARMS_ARTS_EC_BDINS, "PWD"=>$ARMS_ARTS_EC_BDPASS);
        $ARTS_EC = sqlsrv_connect( $serverName, $connectionArts);
		
?>
<?php include("../paramts.php"); ?>
