<?php

include ("hostsaadmin.php");

 ?>



<?php

session_start();

date_default_timezone_set('America/Santiago');

$IDSUITEACE = 1101;

$serverName = $HOSTSAADMIN; //serverName\instanceNam

$connectionInfo = array(

	"Database" => "SAADMIN",

	"UID" => $INSTANCIA,

	"PWD" => $PASSWORD

);

$conecta = sqlsrv_connect($serverName, $connectionInfo);



// $db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521)))(CONNECT_DATA=(SID=xe)))" ;

// $conecta = oci_connect('SAADMIN', 'SAADMIN', $db);

// $SQL = "ALTER SESSION SET nls_date_format='DD-MM-YYYY'";

// $RSV = sqlsrv_query($conecta,$SQL);

// $SQL="ALTER SESSION SET nls_date_format='DD-MM-YYYY";

// $RSV = sqlsrv_query($conecta, $SQL);

// //oci_execute($RSV);



$ENTRAR = $_POST["ENTRAR"];



if ($ENTRAR <> "")

{

	$SALIR = 1;

	$CUENTA = $_POST["CUENTA"];

	$CLAVE = $_POST["CLAVE"];

	$CONSULTA = "SELECT * FROM US_USUARIOS WHERE CUENTA='" . $CUENTA . "' AND CLAVE='" . $CLAVE . "' AND ESTADO=1";

	$RSV = sqlsrv_query($conecta, $CONSULTA);



	// $RSV = sqlsrv_query($conecta, $CONSULTA);

	// //oci_execute($RSV);



	while ($row = sqlsrv_fetch_array($RSV))

	{

		$IDUSU = $row['IDUSU'];

		$ACTSU = $row['SU'];

		$SALIR = 2;

	}



	if ($SALIR == 1)

	{

		header("Location: index.php?msj=2");

		exit();

	}



	// RECONOCER PAIS ACTIVO - ACTIVAR PAIS



	$CONSULTA = "SELECT * FROM PM_PAIS WHERE PACTIV=1";



	// $RSV = sqlsrv_query($conecta, $CONSULTA);



	$RSV = sqlsrv_query($conecta, $CONSULTA);



	// //oci_execute($RSV);



	$SETPAIS = 0;

	if ($row = sqlsrv_fetch_array($RSV))

	{

		$SETPAIS = 1;

		$_SESSION['PAIS_CODE'] = $row['COD_PAIS'];

		$_SESSION['PAIS_NOMBRE'] = $row['DES_PAIS'];

		$_SESSION['PAIS_MONEDA'] = $row['MONEDA'];

		$_SESSION['PAIS_CENT'] = $row['CENTAVOS'];

		$_SESSION['PAIS_DPEST'] = $row['DPEST'];

		$_SESSION['PAIS_DREG'] = $row['DES_REGION'];

		$_SESSION['PAIS_CEDP'] = $row['CEDPERS'];

		$_SESSION['PAIS_CEDE'] = $row['CEDEMP'];

		$_SESSION['PAIS_SEPMIL'] = $row['SEPMIL'];

		$_SESSION['PAIS_SEPDEC'] = $row['SEPDEC'];

	}



	if ($SETPAIS == 0)

	{

		header("Location: index.php?msj=3");

		exit();

	}



	if ($SALIR == 2)

	{



		// FECHA SERVIDOR



		$FECSRV = date("Y-m-d");

		$TIMESRV = date("H:i:s");



		// IP CLIENTE



		function Obtener_IP()

		{

			if (!empty($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];

			if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['HTTP_X_FORWARDED_FOR'];

			return $_SERVER['REMOTE_ADDR'];

		}



		$IP_CLIENTE = Obtener_IP();



		// AVERIGUO EN CUANTOS SISTEMAS ESTA REGISTRADO



		$CUENTASIS = 0;

		$CONSULTA = "SELECT COUNT(IDUSU) AS CIDUSU FROM US_USUPERF WHERE IDUSU=" . $IDUSU;

		$RSV = sqlsrv_query($conecta, $CONSULTA);



		// $RSV = sqlsrv_query($conecta, $CONSULTA);

		// //oci_execute($RSV);



		if ($row = sqlsrv_fetch_array($RSV))

		{

			$CUENTASIS = $row['CIDUSU'];

		}



		// SI NO ESTA EN NINGUN SISTEMA... CUENTA SIN PERFIL



		if ($CUENTASIS == 0)

		{

			header("Location:index.php?msj=1");

			exit();

		}



		// SI ESTA EN SÃ“LO UN SISTEMA



		if ($CUENTASIS == 1)

		{



			// DIRECTO AL SISTEMA (INGRESO)



			$CONSULTA = "SELECT * FROM US_USUPERF WHERE IDUSU=" . $IDUSU;

			$RSV = sqlsrv_query($conecta, $CONSULTA);



			// $RSV = sqlsrv_query($conecta, $CONSULTA);

			// //oci_execute($RSV);



			if ($row = sqlsrv_fetch_array($RSV))

			{

				$IDSISTEMA = $row['IDSISTEMA'];

				$IDPERFIL = $row['IDPERFIL'];

			}



			// OBTENGO EL DIRECTORIO



			$CONSULTA = "SELECT * FROM US_SISTEMA WHERE IDSISTEMA=" . $IDSISTEMA;

			$RSV = sqlsrv_query($conecta, $CONSULTA);



			// $RSV = sqlsrv_query($conecta, $CONSULTA);

			// //oci_execute($RSV);



			if ($row = sqlsrv_fetch_array($RSV))

			{

				$CARPETA = $row['CARPETA'];

				$NOMB_SIS = $row['NOMBRE'];

				$BDIP = trim($row['BDIP']); //IP BASE DE DATOS

				$BDUSER = trim($row['BDUS']); //USUARIO SCHEMA BD

				$BDPASS = trim($row['BDPS']); //PASSWORD SCHEMA BD

			}



			// AHORA EL ACCESO



			$CONSULTA = "SELECT * FROM US_PERFACC WHERE IDPERFIL=" . $IDPERFIL . " AND INGRESO=1";

			$RSV = sqlsrv_query($conecta, $CONSULTA);



			// $RSV = sqlsrv_query($conecta, $CONSULTA);

			// //oci_execute($RSV);



			if ($row = sqlsrv_fetch_array($RSV))

			{

				$IDACC = $row['IDACC'];

			}



			$CONSULTA = "SELECT * FROM US_ACCESO WHERE IDACC=" . $IDACC;

			$RSV = sqlsrv_query($conecta, $CONSULTA);



			// $RSV = sqlsrv_query($conecta, $CONSULTA);

			// //oci_execute($RSV);



			if ($row = sqlsrv_fetch_array($RSV))

			{

				$ENLACE = $row['ENLACE'];

			}



			// GENERO LAS SESIONES



			$CONSULTA = "SELECT WM, EDITAR FROM US_PERFIL WHERE IDPERFIL=" . $IDPERFIL;

			$RSV = sqlsrv_query($conecta, $CONSULTA);



			// $RSV = sqlsrv_query($conecta, $CONSULTA);

			// //oci_execute($RSV);



			while ($row = sqlsrv_fetch_array($RSV))

			{

				$PWM = $row['WM'];

				$EDITAR = $row['EDITAR'];

			}



			$_SESSION['ARMS_MSIS'] = 0;

			$_SESSION['ARMS_SIST'] = $IDSISTEMA;

			$_SESSION['ARMS_IDSUITE'] = $IDSUITEACE;

			$_SESSION['ARMS_NOMBSIS'] = $NOMB_SIS;

			$_SESSION['ARMS_BDIP'] = $BDIP;

			$_SESSION['ARMS_BDUSER'] = $BDUSER;

			$_SESSION['ARMS_BDPASS'] = $BDPASS;

			$_SESSION['ARMS_BDINS'] = $INSTANCIA; // SESSION SQL SERVER ESQUEMA

			$_SESSION['ARMS_IDUSU'] = $IDUSU;

			$_SESSION['ARMS_ACTSU'] = $ACTSU;

			$_SESSION['ARMS_IDPERFIL'] = $IDPERFIL;

			$_SESSION['ARMS_PWM'] = $PWM;

			$_SESSION['ARMS_PUB'] = $EDITAR;

			$_SESSION['ARMS_HORA'] = time();



			// SESIONES BD MAESTRA - CUANDO SISTEMA NO ES ADMIN



			if ($IDSISTEMA != $IDSUITEACE)

			{

				$CONSULTA = "SELECT * FROM US_SISTEMA WHERE IDSISTEMA=" . $IDSUITEACE;

				$RSV = sqlsrv_query($conecta, $CONSULTA);



				// $RSV = sqlsrv_query($conecta, $CONSULTA);

				// //oci_execute($RSV);



				if ($row = sqlsrv_fetch_array($RSV))

				{

					$M_BDIP = trim($row['BDIP']); //IP BASE DE DATOS

					$M_BDUSER = trim($row['BDUS']); //USUARIO SCHEMA BD

					$M_BDPASS = trim($row['BDPS']); //PASSWORD SCHEMA BD

				}



				$_SESSION['ARMS_MA_BDIP'] = $M_BDIP;

				$_SESSION['ARMS_MA_BDUSER'] = $M_BDUSER;

				$_SESSION['ARMS_MA_BDPASS'] = $M_BDPASS;

				$_SESSION['ARMS_MA_BDINS'] = $INSTANCIA;

			}



			// CREANDO SESION DE BD PARA EYES, USADO EN MONITOR DE ESTADO EN EL ENCABEZADO



			$CONSULTA_EYES = "SELECT * FROM US_SISTEMA WHERE IDSISTEMA=1109";

			$RSV_EYES = sqlsrv_query($conecta, $CONSULTA_EYES);



			// $RSV = sqlsrv_query($conecta, $CONSULTA);

			// //oci_execute($RSV);



			if ($ROW_EYES = sqlsrv_fetch_array($RSV_EYES))

			{

				$EYES_IP = trim($ROW_EYES['BDIP']); //IP BASE DE DATOS

				$EYES_BDUS = trim($ROW_EYES['BDUS']); //USUARIO SCHEMA BD

				$EYES_BDPS = trim($ROW_EYES['BDPS']); //PASSWORD SCHEMA BD

			}



			$_SESSION['ARMS_EYES_BDIP'] = $EYES_IP;

			$_SESSION['ARMS_EYES_BDUSER'] = $EYES_BDUS;

			$_SESSION['ARMS_EYES_BDPASS'] = $EYES_BDPS;

			$_SESSION['ARMS_EYES_BDINS'] = $INSTANCIA;

			

			// CREANDO SESION DE BD PARA ARTS_EC, USADO EN MONITOR DE ESTADO EN EL ENCABEZADO



			$CONSULTA_ARTS_EC = "SELECT * FROM US_SISTEMA WHERE IDSISTEMA=1103";

			$RSV_ARTS_EC = sqlsrv_query($conecta, $CONSULTA_ARTS_EC);



			// $RSV = sqlsrv_query($conecta, $CONSULTA);

			// //oci_execute($RSV);



			if ($ROW_ARTS_EC = sqlsrv_fetch_array($RSV_ARTS_EC))

			{

				$ARTS_EC_IP = trim($ROW_ARTS_EC['BDIP']); //IP BASE DE DATOS

				$ARTS_EC_BDUS = trim($ROW_ARTS_EC['BDUS']); //USUARIO SCHEMA BD

				$ARTS_EC_BDPS = trim($ROW_ARTS_EC['BDPS']); //PASSWORD SCHEMA BD

			}



			$_SESSION['ARMS_ARTS_EC_BDIP'] = $ARTS_EC_IP;

			$_SESSION['ARMS_ARTS_EC_BDUSER'] = $ARTS_EC_BDUS;

			$_SESSION['ARMS_ARTS_EC_BDPASS'] = $ARTS_EC_BDPS;

			$_SESSION['ARMS_ARTS_EC_BDINS'] = $INSTANCIA;



			// REGISTRO DE INICIO DE SESION

			// $CONSULTA2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";

			// $RS2 = sqlsrv_query($conecta,$CONSULTA2);

			// $RS2 = sqlsrv_query($conecta, $CONSULTA2);

			// //oci_execute($RS2);

			// if ($row = sqlsrv_fetch_array($RS2)) {

			// $COD_EVENTO=$row['MCOD_EVENTO']+1;

			// } else {

			//	$COD_EVENTO=1;

			// }

			// Cambio en Consulta al ser auto incrementable por bd COD_EVENTO



			$SQLOG = "INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";

			$SQLOG = $SQLOG . "(4, convert(datetime,GETDATE(), 121), '" . $TIMESRV . "', '" . $IP_CLIENTE . "', " . $IDUSU . ", " . $IDACC . ", " . $IDSISTEMA . ", " . $IDPERFIL . ")";



			// $RSL = sqlsrv_query($conecta, $SQLOG);

			// //oci_execute($RSL);



			$RSL = sqlsrv_query($conecta, $SQLOG);



			// REDIRECCIONA A SISTEMA Y MODULO



			header("Location:" . $CARPETA . "/" . $ENLACE);

		}

		else

		{



			// OBTENER DATA CONEXION



			$CONSULTA = "SELECT * FROM US_SISTEMA WHERE IDSISTEMA=" . $IDSUITEACE;



			// $RSV = sqlsrv_query($conecta, $CONSULTA);

			// //oci_execute($RSV);



			$RSV = sqlsrv_query($conecta, $CONSULTA);



			if ($row = sqlsrv_fetch_array($RSV))

			{

				$BDIP = trim($row['BDIP']); //IP BASE DE DATOS

				$BDUSER = trim($row['BDUS']); //USUARIO SCHEMA BD

				$BDPASS = trim($row['BDPS']); //PASSWORD SCHEMA BD

			}



			// SESIONES BASE



			$_SESSION['ARMS_IDUSU'] = $IDUSU;

			$_SESSION['ARMS_ACTSU'] = $ACTSU;

			$_SESSION['ARMS_SIST'] = $IDSUITEACE;

			$_SESSION['ARMS_SA_BDIP'] = $BDIP;

			$_SESSION['ARMS_SA_BDUSER'] = $BDUSER;

			$_SESSION['ARMS_SA_BDPASS'] = $BDPASS;

			$_SESSION['ARMS_SA_BDINS'] = $INSTANCIA;



			// AL MENU DE SISTEMAS



			header("Location: msistemas.php");

			// CREANDO SESION DE BD PARA EYES, USADO EN MONITOR DE ESTADO EN EL ENCABEZADO



			$CONSULTA_EYES = "SELECT * FROM US_SISTEMA WHERE IDSISTEMA=1109";

			$RSV_EYES = sqlsrv_query($conecta, $CONSULTA_EYES);



			// $RSV = sqlsrv_query($conecta, $CONSULTA);

			// //oci_execute($RSV);



			if ($ROW_EYES = sqlsrv_fetch_array($RSV_EYES))

			{

				$EYES_IP = trim($ROW_EYES['BDIP']); //IP BASE DE DATOS

				$EYES_BDUS = trim($ROW_EYES['BDUS']); //USUARIO SCHEMA BD

				$EYES_BDPS = trim($ROW_EYES['BDPS']); //PASSWORD SCHEMA BD

			}



			$_SESSION['ARMS_EYES_BDIP'] = $EYES_IP;

			$_SESSION['ARMS_EYES_BDUSER'] = $EYES_BDUS;

			$_SESSION['ARMS_EYES_BDPASS'] = $EYES_BDPS;

			$_SESSION['ARMS_EYES_BDINS'] = $INSTANCIA;

			

			$CONSULTA_ARTS_EC = "SELECT * FROM US_SISTEMA WHERE IDSISTEMA=1103";

			$RSV_ARTS_EC = sqlsrv_query($conecta, $CONSULTA_ARTS_EC);

		

			// $RSV = sqlsrv_query($conecta, $CONSULTA);

			// //oci_execute($RSV);

		

			if ($ROW_ARTS_EC = sqlsrv_fetch_array($RSV_ARTS_EC))

			{

				$ARTS_EC_IP = trim($ROW_ARTS_EC['BDIP']); //IP BASE DE DATOS

				$ARTS_EC_BDUS = trim($ROW_ARTS_EC['BDUS']); //USUARIO SCHEMA BD

				$ARTS_EC_BDPS = trim($ROW_ARTS_EC['BDPS']); //PASSWORD SCHEMA BD

			}

		

			$_SESSION['ARMS_ARTS_EC_BDIP'] = $ARTS_EC_IP;

			$_SESSION['ARMS_ARTS_EC_BDUSER'] = $ARTS_EC_BDUS;

			$_SESSION['ARMS_ARTS_EC_BDPASS'] = $ARTS_EC_BDPS;

			$_SESSION['ARMS_ARTS_EC_BDINS'] = $INSTANCIA;

		}

	}

} //ENTRAR



// DESDE EL MENU DE SISTEMAS



$MENSIS = @$_GET["DIS"];



if ($MENSIS == 1)

{

	$IDUSU = @$_GET["IDU"];

	$IDSISTEMA = @$_GET["IDS"];



	// FECHA SERVIDOR



	$FECSRV = date("Y-m-d");

	$TIMESRV = date("H:i:s");



	// IP CLIENTE



	function Obtener_IP()

	{

		if (!empty($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];

		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['HTTP_X_FORWARDED_FOR'];

		return $_SERVER['REMOTE_ADDR'];

	}



	$IP_CLIENTE = Obtener_IP();



	// DIRECTO AL SISTEMA



	$CONSULTA = "SELECT SU FROM US_USUARIOS WHERE IDUSU=" . $IDUSU;



	// $RSV = sqlsrv_query($conecta, $CONSULTA);

	// //oci_execute($RSV);



	$RSV = sqlsrv_query($conecta, $CONSULTA);

	if ($row = sqlsrv_fetch_array($RSV))

	{

		$ACTSU = $row['SU'];

	}



	$CONSULTA = "SELECT * FROM US_USUPERF WHERE IDUSU=" . $IDUSU . " AND IDSISTEMA=" . $IDSISTEMA;



	// $RSV = sqlsrv_query($conecta, $CONSULTA);

	// //oci_execute($RSV);



	$RSV = sqlsrv_query($conecta, $CONSULTA);

	if ($row = sqlsrv_fetch_array($RSV))

	{

		$IDPERFIL = $row['IDPERFIL'];

	}



	// OBTENGO EL DIRECTORIO



	$CONSULTA = "SELECT * FROM US_SISTEMA WHERE IDSISTEMA=" . $IDSISTEMA;



	// $RSV = sqlsrv_query($conecta, $CONSULTA);

	// //oci_execute($RSV);



	$RSV = sqlsrv_query($conecta, $CONSULTA);

	if ($row = sqlsrv_fetch_array($RSV))

	{

		$CARPETA = $row['CARPETA'];

		$NOMB_SIS = $row['NOMBRE'];

		$BDIP = trim($row['BDIP']); //IP BASE DE DATOS

		$BDUSER = trim($row['BDUS']); //USUARIO SCHEMA BD

		$BDPASS = trim($row['BDPS']); //PASSWORD SCHEMA BD

	}



	// AHORA EL ACCESO



	$CONSULTA = "SELECT * FROM US_PERFACC WHERE IDPERFIL=" . $IDPERFIL . " AND INGRESO=1";



	// $RSV = sqlsrv_query($conecta, $CONSULTA);

	// //oci_execute($RSV);



	$RSV = sqlsrv_query($conecta, $CONSULTA);

	if ($row = sqlsrv_fetch_array($RSV))

	{

		$IDACC = $row['IDACC'];

	}



	$CONSULTA = "SELECT * FROM US_ACCESO WHERE IDACC=" . $IDACC;



	// $RSV = sqlsrv_query($conecta, $CONSULTA);

	// //oci_execute($RSV);



	$RSV = sqlsrv_query($conecta, $CONSULTA);

	if ($row = sqlsrv_fetch_array($RSV))

	{

		$ENLACE = $row['ENLACE'];

	}



	// GENERO LAS SESIONES



	$CONSULTA = "SELECT WM, EDITAR FROM US_PERFIL WHERE IDPERFIL=" . $IDPERFIL;



	// $RSV = sqlsrv_query($conecta, $CONSULTA);

	// //oci_execute($RSV);



	$RSV = sqlsrv_query($conecta, $CONSULTA);

	while ($row = sqlsrv_fetch_array($RSV))

	{

		$PWM = $row['WM'];

		$EDITAR = $row['EDITAR'];

	}



	$_SESSION['ARMS_MSIS'] = 1;

	$_SESSION['ARMS_SIST'] = $IDSISTEMA;

	$_SESSION['ARMS_IDSUITE'] = $IDSUITEACE;

	$_SESSION['ARMS_NOMBSIS'] = $NOMB_SIS;

	$_SESSION['ARMS_BDIP'] = $BDIP;

	$_SESSION['ARMS_BDUSER'] = $BDUSER;

	$_SESSION['ARMS_BDPASS'] = $BDPASS;

	$_SESSION['ARMS_IDUSU'] = $IDUSU;

	$_SESSION['ARMS_BDINS'] = $INSTANCIA; // INSTANCIA SQL SERVER

	$_SESSION['ARMS_ACTSU'] = $ACTSU;

	$_SESSION['ARMS_IDPERFIL'] = $IDPERFIL;

	$_SESSION['ARMS_PWM'] = $PWM;

	$_SESSION['ARMS_PUB'] = $EDITAR;

	$_SESSION['ARMS_HORA'] = time();



	// SESIONES BD MAESTRA - CUANDO SISTEMA NO ES ADMIN



	if ($IDSISTEMA != $IDSUITEACE)

	{

		$CONSULTA = "SELECT * FROM US_SISTEMA WHERE IDSISTEMA=" . $IDSUITEACE;



		// $RSV = sqlsrv_query($conecta, $CONSULTA);

		// //oci_execute($RSV);



		$RSV = sqlsrv_query($conecta, $CONSULTA);

		if ($row = sqlsrv_fetch_array($RSV))

		{

			$M_BDIP = trim($row['BDIP']); //IP BASE DE DATOS

			$M_BDUSER = trim($row['BDUS']); //USUARIO SCHEMA BD

			$M_BDPASS = trim($row['BDPS']); //PASSWORD SCHEMA BD

		}



		$_SESSION['ARMS_MA_BDIP'] = $M_BDIP;

		$_SESSION['ARMS_MA_BDUSER'] = $M_BDUSER;

		$_SESSION['ARMS_MA_BDPASS'] = $M_BDPASS;

		$_SESSION['ARMS_MA_BDINS'] = $INSTANCIA;

	}

	// CREANDO SESION DE BD PARA EYES, USADO EN MONITOR DE ESTADO EN EL ENCABEZADO



	$CONSULTA_EYES = "SELECT * FROM US_SISTEMA WHERE IDSISTEMA=1109";

	$RSV_EYES = sqlsrv_query($conecta, $CONSULTA_EYES);



	// $RSV = sqlsrv_query($conecta, $CONSULTA);

	// //oci_execute($RSV);



	if ($ROW_EYES = sqlsrv_fetch_array($RSV_EYES))

	{

		$EYES_IP = trim($ROW_EYES['BDIP']); //IP BASE DE DATOS

		$EYES_BDUS = trim($ROW_EYES['BDUS']); //USUARIO SCHEMA BD

		$EYES_BDPS = trim($ROW_EYES['BDPS']); //PASSWORD SCHEMA BD

	}



	$_SESSION['ARMS_EYES_BDIP'] = $EYES_IP;

	$_SESSION['ARMS_EYES_BDUSER'] = $EYES_BDUS;

	$_SESSION['ARMS_EYES_BDPASS'] = $EYES_BDPS;

	$_SESSION['ARMS_EYES_BDINS'] = $INSTANCIA;





	// CREANDO SESION DE BD PARA ARTS_EC, USADO EN MONITOR DE ESTADO EN EL ENCABEZADO



	$CONSULTA_ARTS_EC = "SELECT * FROM US_SISTEMA WHERE IDSISTEMA=1103";

	$RSV_ARTS_EC = sqlsrv_query($conecta, $CONSULTA_ARTS_EC);



	// $RSV = sqlsrv_query($conecta, $CONSULTA);

	// //oci_execute($RSV);



	if ($ROW_ARTS_EC = sqlsrv_fetch_array($RSV_ARTS_EC))

	{

		$ARTS_EC_IP = trim($ROW_ARTS_EC['BDIP']); //IP BASE DE DATOS

		$ARTS_EC_BDUS = trim($ROW_ARTS_EC['BDUS']); //USUARIO SCHEMA BD

		$ARTS_EC_BDPS = trim($ROW_ARTS_EC['BDPS']); //PASSWORD SCHEMA BD

	}



	$_SESSION['ARMS_ARTS_EC_BDIP'] = $ARTS_EC_IP;

	$_SESSION['ARMS_ARTS_EC_BDUSER'] = $ARTS_EC_BDUS;

	$_SESSION['ARMS_ARTS_EC_BDPASS'] = $ARTS_EC_BDPS;

	$_SESSION['ARMS_ARTS_EC_BDINS'] = $INSTANCIA;

	// REGISTRO DE INICIO DE SESION

	// $CONSULTA2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";

	// $RS2 = sqlsrv_query($conecta, $CONSULTA2);

	// //oci_execute($RS2);

	// $RS2 = sqlsrv_query($conecta,$CONSULTA2);

	// if ($row = sqlsrv_fetch_array($RS2)) {

	//		$COD_EVENTO=$row['MCOD_EVENTO']+1;

	//	} else {

	//		$COD_EVENTO=1;

	// }



	$SQLOG = "INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";

	$SQLOG = $SQLOG . "(4, convert(datetime,GETDATE(), 121), '" . $TIMESRV . "', '" . $IP_CLIENTE . "', " . $IDUSU . ", " . $IDACC . ", " . $IDSISTEMA . ", " . $IDPERFIL . ")";



	// $RSL = sqlsrv_query($conecta, $SQLOG);

	// //oci_execute($RSL);



	$RSL = sqlsrv_query($conecta, $SQLOG);



	// REDIRECCIONA A SISTEMA Y MODULO



	header("Location:" . $CARPETA . "/" . $ENLACE);

}









$STATUS_EYES = @$_GET["STATUS_EYES"];



if ($STATUS_EYES == 1)

{

	$IDUSU = "1103";

	$IDSISTEMA = "1109";



	// FECHA SERVIDOR



	$FECSRV = date("Y-m-d");

	$TIMESRV = date("H:i:s");



	// IP CLIENTE



	function Obtener_IP()

	{

		if (!empty($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];

		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['HTTP_X_FORWARDED_FOR'];

		return $_SERVER['REMOTE_ADDR'];

	}



	$IP_CLIENTE = Obtener_IP();



	// DIRECTO AL SISTEMA



	$CONSULTA = "SELECT SU FROM US_USUARIOS WHERE IDUSU=" . $IDUSU;



	// $RSV = sqlsrv_query($conecta, $CONSULTA);

	// //oci_execute($RSV);



	$RSV = sqlsrv_query($conecta, $CONSULTA);

	if ($row = sqlsrv_fetch_array($RSV))

	{

		$ACTSU = $row['SU'];

	}



	$CONSULTA = "SELECT * FROM US_USUPERF WHERE IDUSU=" . $IDUSU . " AND IDSISTEMA=" . $IDSISTEMA;



	// $RSV = sqlsrv_query($conecta, $CONSULTA);

	// //oci_execute($RSV);



	$RSV = sqlsrv_query($conecta, $CONSULTA);

	if ($row = sqlsrv_fetch_array($RSV))

	{

		$IDPERFIL = $row['IDPERFIL'];

	}



	// OBTENGO EL DIRECTORIO



	$CONSULTA = "SELECT * FROM US_SISTEMA WHERE IDSISTEMA=" . $IDSISTEMA;



	// $RSV = sqlsrv_query($conecta, $CONSULTA);

	// //oci_execute($RSV);



	$RSV = sqlsrv_query($conecta, $CONSULTA);

	if ($row = sqlsrv_fetch_array($RSV))

	{

		$CARPETA = $row['CARPETA'];

		$NOMB_SIS = $row['NOMBRE'];

		$BDIP = trim($row['BDIP']); //IP BASE DE DATOS

		$BDUSER = trim($row['BDUS']); //USUARIO SCHEMA BD

		$BDPASS = trim($row['BDPS']); //PASSWORD SCHEMA BD

	}



	// AHORA EL ACCESO



	$CONSULTA = "SELECT * FROM US_PERFACC WHERE IDPERFIL=" . $IDPERFIL . " AND INGRESO=1";



	// $RSV = sqlsrv_query($conecta, $CONSULTA);

	// //oci_execute($RSV);



	$RSV = sqlsrv_query($conecta, $CONSULTA);

	if ($row = sqlsrv_fetch_array($RSV))

	{

		$IDACC = $row['IDACC'];

	}



	$CONSULTA = "SELECT * FROM US_ACCESO WHERE IDACC=" . $IDACC;



	// $RSV = sqlsrv_query($conecta, $CONSULTA);

	// //oci_execute($RSV);



	$RSV = sqlsrv_query($conecta, $CONSULTA);

	if ($row = sqlsrv_fetch_array($RSV))

	{

		$ENLACE = $row['ENLACE'];

	}



	// GENERO LAS SESIONES



	$CONSULTA = "SELECT WM, EDITAR FROM US_PERFIL WHERE IDPERFIL=" . $IDPERFIL;



	// $RSV = sqlsrv_query($conecta, $CONSULTA);

	// //oci_execute($RSV);



	$RSV = sqlsrv_query($conecta, $CONSULTA);

	while ($row = sqlsrv_fetch_array($RSV))

	{

		$PWM = $row['WM'];

		$EDITAR = $row['EDITAR'];

	}



	$_SESSION['ARMS_MSIS'] = 1;

	$_SESSION['ARMS_SIST'] = $IDSISTEMA;

	$_SESSION['ARMS_IDSUITE'] = $IDSUITEACE;

	$_SESSION['ARMS_NOMBSIS'] = $NOMB_SIS;

	$_SESSION['ARMS_BDIP'] = $BDIP;

	$_SESSION['ARMS_BDUSER'] = $BDUSER;

	$_SESSION['ARMS_BDPASS'] = $BDPASS;

	$_SESSION['ARMS_IDUSU'] = $IDUSU;

	$_SESSION['ARMS_BDINS'] = $INSTANCIA; // INSTANCIA SQL SERVER

	$_SESSION['ARMS_ACTSU'] = $ACTSU;

	$_SESSION['ARMS_IDPERFIL'] = $IDPERFIL;

	$_SESSION['ARMS_PWM'] = $PWM;

	$_SESSION['ARMS_PUB'] = $EDITAR;

	$_SESSION['ARMS_HORA'] = time();



	// SESIONES BD MAESTRA - CUANDO SISTEMA NO ES ADMIN



	if ($IDSISTEMA != $IDSUITEACE)

	{

		$CONSULTA = "SELECT * FROM US_SISTEMA WHERE IDSISTEMA=" . $IDSUITEACE;



		// $RSV = sqlsrv_query($conecta, $CONSULTA);

		// //oci_execute($RSV);



		$RSV = sqlsrv_query($conecta, $CONSULTA);

		if ($row = sqlsrv_fetch_array($RSV))

		{

			$M_BDIP = trim($row['BDIP']); //IP BASE DE DATOS

			$M_BDUSER = trim($row['BDUS']); //USUARIO SCHEMA BD

			$M_BDPASS = trim($row['BDPS']); //PASSWORD SCHEMA BD

		}



		$_SESSION['ARMS_MA_BDIP'] = $M_BDIP;

		$_SESSION['ARMS_MA_BDUSER'] = $M_BDUSER;

		$_SESSION['ARMS_MA_BDPASS'] = $M_BDPASS;

		$_SESSION['ARMS_MA_BDINS'] = $INSTANCIA;

	}

	// CREANDO SESION DE BD PARA EYES, USADO EN MONITOR DE ESTADO EN EL ENCABEZADO



	$CONSULTA_EYES = "SELECT * FROM US_SISTEMA WHERE IDSISTEMA=1109";

	$RSV_EYES = sqlsrv_query($conecta, $CONSULTA_EYES);



	// $RSV = sqlsrv_query($conecta, $CONSULTA);

	// //oci_execute($RSV);



	if ($ROW_EYES = sqlsrv_fetch_array($RSV_EYES))

	{

		$EYES_IP = trim($ROW_EYES['BDIP']); //IP BASE DE DATOS

		$EYES_BDUS = trim($ROW_EYES['BDUS']); //USUARIO SCHEMA BD

		$EYES_BDPS = trim($ROW_EYES['BDPS']); //PASSWORD SCHEMA BD

	}



	$_SESSION['ARMS_EYES_BDIP'] = $EYES_IP;

	$_SESSION['ARMS_EYES_BDUSER'] = $EYES_BDUS;

	$_SESSION['ARMS_EYES_BDPASS'] = $EYES_BDPS;

	$_SESSION['ARMS_EYES_BDINS'] = $INSTANCIA;





	// CREANDO SESION DE BD PARA ARTS_EC, USADO EN MONITOR DE ESTADO EN EL ENCABEZADO



	$CONSULTA_ARTS_EC = "SELECT * FROM US_SISTEMA WHERE IDSISTEMA=1103";

	$RSV_ARTS_EC = sqlsrv_query($conecta, $CONSULTA_ARTS_EC);



	// $RSV = sqlsrv_query($conecta, $CONSULTA);

	// //oci_execute($RSV);



	if ($ROW_ARTS_EC = sqlsrv_fetch_array($RSV_ARTS_EC))

	{

		$ARTS_EC_IP = trim($ROW_ARTS_EC['BDIP']); //IP BASE DE DATOS

		$ARTS_EC_BDUS = trim($ROW_ARTS_EC['BDUS']); //USUARIO SCHEMA BD

		$ARTS_EC_BDPS = trim($ROW_ARTS_EC['BDPS']); //PASSWORD SCHEMA BD

	}



	$_SESSION['ARMS_ARTS_EC_BDIP'] = $ARTS_EC_IP;

	$_SESSION['ARMS_ARTS_EC_BDUSER'] = $ARTS_EC_BDUS;

	$_SESSION['ARMS_ARTS_EC_BDPASS'] = $ARTS_EC_BDPS;

	$_SESSION['ARMS_ARTS_EC_BDINS'] = $INSTANCIA;

	// REGISTRO DE INICIO DE SESION

	// $CONSULTA2="SELECT MAX(COD_EVENTO) AS MCOD_EVENTO FROM LG_EVENTO";

	// $RS2 = sqlsrv_query($conecta, $CONSULTA2);

	// //oci_execute($RS2);

	// $RS2 = sqlsrv_query($conecta,$CONSULTA2);

	// if ($row = sqlsrv_fetch_array($RS2)) {

	//		$COD_EVENTO=$row['MCOD_EVENTO']+1;

	//	} else {

	//		$COD_EVENTO=1;

	// }



	$SQLOG = "INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";

	$SQLOG = $SQLOG . "(4, convert(datetime,GETDATE(), 121), '" . $TIMESRV . "', '" . $IP_CLIENTE . "', " . $IDUSU . ", " . $IDACC . ", " . $IDSISTEMA . ", " . $IDPERFIL . ")";



	// $RSL = sqlsrv_query($conecta, $SQLOG);

	// //oci_execute($RSL);



	$RSL = sqlsrv_query($conecta, $SQLOG);



	// REDIRECCIONA A SISTEMA Y MODULO

	$STR_CD = @$_GET["STR_CD"];

	header("Location:ALCEYES/estado.php?LIST=1&STR_CD=".$STR_CD);

}















// sqlsrv_close($conecta);

// Cerrar la conexiÃ³n.



sqlsrv_close($conecta);

?>



