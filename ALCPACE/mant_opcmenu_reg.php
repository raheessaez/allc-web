<?php include("session.inc");?>
<?php

$INGRESAR=$_POST["INGRESAR"];

if ($INGRESAR<>"") {
		$NIVEL=$_POST["NIVEL"];
		$COD_NVL2=$_POST["COD_NVL2"];
		$COD_NVL3=$_POST["SELCOD_NVL3"];
		$DES_ES=COMILLAS($_POST["DES_ES"]);
		$DES_EN=COMILLAS($_POST["DES_EN"]);
		$PUBLICA=$_POST["PUBLICA"];
		$ARCHIVO=COMILLAS($_POST["ARCHIVO"]);
		if($NIVEL==1){$COD_NVL2=0; $COD_NVL3=0;}
		if($NIVEL==2){$COD_NVL3=0;}

		
				$CONSULTA2="SELECT MAX(COD_NVL1) AS M_CODNVL FROM PA_OPCMENU";
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				//oci_execute($RS2);
				if ($row = sqlsrv_fetch_array($RS2)) {
						$COD_NVL1=$row['M_CODNVL']+1;
					} else {
						$COD_NVL1=1;
				}
				$CONSULTA2="INSERT INTO PA_OPCMENU (COD_NVL1, COD_NVL2, COD_NVL3, DES_ES, DES_EN, ARCHIVO, PUBLICA, IDREG) ";
				$CONSULTA2=$CONSULTA2." VALUES (".$COD_NVL1.", ".$COD_NVL2.", ".$COD_NVL3.", '".$DES_ES."', '".$DES_EN."', '".$ARCHIVO."', ".$PUBLICA.", ".$SESIDUSU.")";
				$RS2 = sqlsrv_query($conn, $CONSULTA2);
				//oci_execute($RS2);

				//REGISTRO DE ALTA
						
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1176, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($conn, $SQLOG);
						//oci_execute($RSL);																	


				header("Location: mant_opcmenu.php?ACT=".$COD_NVL1."&MSJE=1");

		oci_close($conn);
}
				
				
$ACTUALIZAR=$_POST["ACTUALIZAR"];

if ($ACTUALIZAR<>"") {
		$COD_NVL1=$_POST["COD_NVL1"];
		$NIVEL=$_POST["NIVEL"];
		/*
		if($NIVEL==""){
			$CONSULTA2="SELECT COD_NVL2, COD_NVL3 FROM PA_OPCMENU WHERE COD_NVL1=".$COD_NVL1;
			$RS2 = sqlsrv_query($conn, $CONSULTA2);
			//oci_execute($RS2);
			if ($row = sqlsrv_fetch_array($RS2)) {
					$VER_NVL2=$row['COD_NVL2'];
					$VER_NVL3=$row['COD_NVL3'];
			}
			if($VER_NVL2==0 and $VER_NVL3==0){$NIVEL=1;}
			if($VER_NVL2<>0 and $VER_NVL3==0){$NIVEL=2;}
			if($VER_NVL3<>0){$NIVEL=3;}
		}
		*/
		
		$COD_NVL2=$_POST["COD_NVL2"];
		$COD_NVL3=$_POST["SELCOD_NVL3"];
		$DES_ES=COMILLAS($_POST["DES_ES"]);
		$DES_EN=COMILLAS($_POST["DES_EN"]);
		$PUBLICA=$_POST["PUBLICA"];
		$ARCHIVO=COMILLAS($_POST["ARCHIVO"]);
		if($NIVEL==1){$COD_NVL2=0; $COD_NVL3=0;}
		if($NIVEL==2){$COD_NVL3=0;}
		
		$CONSULTA2="UPDATE PA_OPCMENU SET COD_NVL2=".$COD_NVL2.", COD_NVL3=".$COD_NVL3.", PUBLICA=".$PUBLICA.", DES_ES='".$DES_ES."', DES_EN='".$DES_EN."' ";
		$CONSULTA2=$CONSULTA2.", ARCHIVO='".$ARCHIVO."', IDREG=".$SESIDUSU.", FECHA= convert(datetime,GETDATE(), 121) WHERE COD_NVL1=".$COD_NVL1;
		$RS2 = sqlsrv_query($conn, $CONSULTA2);
		//oci_execute($RS2);

				//REGISTRO DE MODIFICACION
					
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(3,convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1176, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($conn, $SQLOG);
						//oci_execute($RSL);																	

				header("Location: mant_opcmenu.php?ACT=".$COD_NVL1."&NVL=".$NIVEL."&MSJE=2");

		sqlsrv_close($conn);
}
				
?>
