<?php include("hostsaadmin.php");?>
<?php
		session_start();
		if (!isset($_SESSION['ARMS_IDUSU'])) {
			header("Location: finsesion.php");
			}		

		$SESIDUSU=$_SESSION['ARMS_IDUSU'];
		@$SESIDSISTEMA=$_SESSION['ARMS_SA_IDSISTEMA'];
		$BDUSER = $_SESSION['ARMS_SA_BDUSER'];
		$BDPASSWORD = $_SESSION['ARMS_SA_BDPASS'];
		@$BDIP=$_SESSION['ARMS_BDIP'];
		//$db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = ".$BDIP.")(PORT = 1521)))(CONNECT_DATA=(SID=xe)))";
		//$MS_CONN = oci_connect( $BDUSER , $BDPASSWORD , $db);
		//$SQL="ALTER SESSION SET nls_date_format='DD-MM-YYYY'";
		//$RS = sqlsrv_query($MS_CONN, $SQL);
		////oci_execute($RS);
		
		$serverName = $HOSTSAADMIN;
        $connectionInfo = array( "Database"=>$BDUSER, "UID"=>$INSTANCIA, "PWD"=>$PASSWORD);
        $MS_CONN = sqlsrv_connect( $serverName, $connectionInfo);
                 
        //$SQL = "ALTER SESSION SET nls_date_format= 'DD-MM-YYYY'";
        //$RS = sqlsrv_query($MS_CONN,$SQL);

		include("headerhtml.inc"); 
?>
</head>

<body>
<div id="msistema">
    <div id="msistema-top">
            <img src="images/acceso_top2.png">
    </div>
    <div id="msistema-central">
<?php


							$C1="SELECT US_SISTEMA.NOMBRE, US_SISTEMA.IDSISTEMA FROM US_SISTEMA INNER JOIN US_USUPERF ON US_USUPERF.IDUSU=".$SESIDUSU." AND US_SISTEMA.IDSISTEMA=US_USUPERF.IDSISTEMA ORDER BY US_SISTEMA.NOMBRE ASC";
							//$RS1 = sqlsrv_query($MS_CONN, $C1);
							////oci_execute($RS1);
							$RS1 = sqlsrv_query($MS_CONN,$C1);
							while ($RW1 = sqlsrv_fetch_array($RS1)){
									$IDSISTEMA=$RW1['IDSISTEMA'];
									$NOMB_SIS=$RW1['NOMBRE'];
							?>
                            <input type="button" value="<?php echo $NOMB_SIS;?>" onClick="javascript:pagina('valida.php?DIS=1&IDU=<?php echo $SESIDUSU;?>&IDS=<?php echo $IDSISTEMA;?>');">
                            <?php
							}
							

?>
    </div>
    <div id="msistema-bottom">
    		<img src="images/logoTGCSALLC.png">
            <a href="hastaluego.php" class="CerrarSesion">Cerrar Sesi&oacute;n</a>
    </div>
</div>
</div>
</body>
</html>