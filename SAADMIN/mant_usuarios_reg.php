<?php include("session.inc");?>
<?php

$INGRESAR=$_POST["INGRESAR"];

if ($INGRESAR<>"") {
		$NOMBRE=COMILLAS($_POST["NOMBRE"]);
		$EMAIL=COMILLAS(strtolower ($_POST["EMAIL"]));	
		$CUENTA=COMILLAS($_POST["CUENTA"]);
		$CLAVE=COMILLAS($_POST["CLAVE"]);
		
			$CONSULTA="SELECT CUENTA FROM US_USUARIOS WHERE UPPER(CUENTA)='". strtoupper($CUENTA). "' ";
			$RS = sqlsrv_query($conn, $CONSULTA);
			//oci_execute($RS);
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_usuarios.php?NEO=1&MSJE=2");
			} else {
				$CONSULTA2="SELECT IDENT_CURRENT ('US_USUARIOS') AS MIDUSU";
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				//oci_execute($RS2);
				if ($row = sqlsrv_fetch_array($RS2)) {
						$IDUSU=$row['MIDUSU']+1;
					} else {
						$IDUSU=1;
				}
				$CONSULTA2="INSERT INTO US_USUARIOS (NOMBRE, EMAIL, CUENTA, CLAVE,  IDREG, FECHA) ";
				$CONSULTA2=$CONSULTA2." VALUES ('".$NOMBRE."', '".$EMAIL."', '".$CUENTA."', '".$CLAVE."',  ".$SESIDUSU.",convert(datetime,GETDATE(), 121))";
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				//oci_execute($RS2);
				//REGISTRO DE ALTA
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1103, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($conn, $SQLOG);
						//oci_execute($RSL);																	
				header("Location: mant_usuarios.php?ACT=".$IDUSU."&MSJE=3");
		}
		sqlsrv_close($conn);
}
				
				
$ACTUALIZAR=$_POST["ACTUALIZAR"];

if ($ACTUALIZAR<>"") {
		$IDUSU=$_POST["IDUSU"];
		$NOMBRE=COMILLAS($_POST["NOMBRE"]);
		$EMAIL=COMILLAS(strtolower ($_POST["EMAIL"]));	
		$ESTADO=$_POST["ESTADO"];
		$CUENTA=COMILLAS($_POST["CUENTA"]);
		$CLAVE=COMILLAS($_POST["CLAVE"]);
		
			$CONSULTA="SELECT CUENTA FROM US_USUARIOS WHERE UPPER(CUENTA)='". strtoupper($CUENTA). "' AND IDUSU<>".$IDUSU;
			$RS = sqlsrv_query($conn, $CONSULTA);
			//oci_execute($RS);
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_usuarios.php?ACT=".$IDUSU."&MSJE=2");
			} else {

				$CONSULTA2="UPDATE US_USUARIOS SET NOMBRE='".$NOMBRE."', EMAIL='".$EMAIL."', CUENTA='".$CUENTA."', CLAVE='".$CLAVE."',  ESTADO=".$ESTADO.", IDREG=".$SESIDUSU.", FECHA=convert(datetime,GETDATE(), 121) WHERE IDUSU=".$IDUSU;
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				//oci_execute($RS2);
				//REGISTRO DE MODIFICACION
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1103, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($conn, $SQLOG);
						//oci_execute($RSL);																	
				header("Location: mant_usuarios.php?ACT=".$IDUSU."&MSJE=1");
			}

		sqlsrv_close($conn);
}




$REGPERFIL=$_POST["REGPERFIL"];

if ($REGPERFIL<>"") {
		$IDPERFIL=$_POST["IDPERFIL"];
		$IDSISTEMA=$_POST["IDSISTEMA"];
		$IDUSU=$_POST["IDUSU"];
		
				$CONSULTA2="INSERT INTO US_USUPERF (IDPERFIL, IDSISTEMA, IDUSU) ";
				$CONSULTA2=$CONSULTA2." VALUES (".$IDPERFIL.",".$IDSISTEMA.",".$IDUSU.")";
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				//oci_execute($RS2);
				//REGISTRO DE ALTA
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1103, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($conn, $SQLOG);
						//oci_execute($RSL);																	
				header("Location: mant_usuarios.php?ACT=".$IDUSU."&PERF=1&MSJE=5");

		sqlsrv_close($conn);
}
				
				
$CAMBIAPERFIL=$_POST["CAMBIAPERFIL"];

if ($CAMBIAPERFIL<>"") {
		$IDUSU=$_POST["IDUSU"];
		$NEOIDPERFIL=$_POST["NEOIDPERFIL"];
		$IDSISTEMA=$_POST["IDSISTEMA"];
		
				$CONSULTA2="UPDATE US_USUPERF SET IDPERFIL=".$NEOIDPERFIL." WHERE IDUSU=".$IDUSU." AND IDSISTEMA=".$IDSISTEMA;
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				//oci_execute($RS2);
				//REGISTRO DE MODIFICACION
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1103, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($conn, $SQLOG);
						//oci_execute($RSL);																	
				header("Location: mant_usuarios.php?ACT=".$IDUSU."&PERF=1&MSJE=1");

		sqlsrv_close($conn);
}

				
				
$ELIMINAR=@$_GET["ELM"];

if ($ELIMINAR<>"") {
		$IDPERFIL=@$_GET["IDPERFIL"];
		$IDSISTEMA=@$_GET["IDSISTEMA"];
		$IDUSU=@$_GET["IDUSU"];
		
			$CONSULTA="DELETE FROM US_USUPERF WHERE IDPERFIL=".$IDPERFIL." AND IDSISTEMA=".$IDSISTEMA." AND IDUSU=".$IDUSU;
			$RS = sqlsrv_query($conn, $CONSULTA);
			//oci_execute($RS);

			$CONSULTA="DELETE FROM US_USUTND WHERE IDUSU=".$IDUSU;
			$RS = sqlsrv_query($conn, $CONSULTA);
			//oci_execute($RS);

			//REGISTRO DE BAJA
					
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1103, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($conn, $SQLOG);
						//oci_execute($RSL);			
																				
				header("Location: mant_usuarios.php?ACT=".$IDUSU."&PERF=1&MSJE=4");
		sqlsrv_close($conn);
}

$REG_TIENDA=$_POST["REG_TIENDA"];

if ($REG_TIENDA<>"") {
		$COD_NEGOCIO_RT=$_POST["COD_NEGOCIO"];
		$COD_TIENDA_RT=$_POST["COD_TIENDA"];
		$IDUSU_RT=$_POST["IDUSU"];
		
				$SQL="INSERT INTO US_USUTND (IDUSU, COD_TIENDA, COD_NEGOCIO, IDREG) ";
				$SQL=$SQL." VALUES (".$IDUSU_RT.", ".$COD_TIENDA_RT.", ".$COD_NEGOCIO_RT.", ".$SESIDUSU.")";
				$RS = sqlsrv_query($conn, $SQL);
				//oci_execute($RS);
				
				//REGISTRO DE ALTA
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1103, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($conn, $SQLOG);

						//oci_execute($RSL);																	


				header("Location: mant_usuarios.php?ACT=".$IDUSU_RT."&TND=1&MSJE=6");

		sqlsrv_close($conn);
}
				

$RETTND=@$_GET["RETTND"];

if ($RETTND<>"") {
		$COD_TIENDA=@$_GET["COD_TIENDA"];
		$COD_NEGOCIO=@$_GET["COD_NEGOCIO"];
		$IDUSU=@$_GET["IDUSU"];
		
			$CONSULTA="DELETE FROM US_USUTND WHERE COD_TIENDA=".$COD_TIENDA." AND COD_NEGOCIO=".$COD_NEGOCIO." AND IDUSU=".$IDUSU;
			$RS = sqlsrv_query($conn, $CONSULTA);
			//oci_execute($RS);

			//REGISTRO DE BAJA
					
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1103, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($conn, $SQLOG);
						//oci_execute($RSL);			
																				
				header("Location: mant_usuarios.php?ACT=".$IDUSU."&TND=1&MSJE=7");
		sqlsrv_close($conn);
}

?>
