<?php include("session.inc");?>

<?php

$POS = array
 					(
 					array("100|200","1"),
 					array("100|400","3"),
 					);
 
$NEG = array
 					(
 					array("100|400","2"),
 					);
 
 foreach($POS as $VTA)
 	{
 	foreach($VTA as $ART)
 		{
 		echo $ART ." ";
 		}
		echo "<br>";
 	}
		
 foreach($NEG as $VTA)
 	{
 	foreach($VTA as $ART)
 		{
 		echo $ART ." ";
 		}
		echo "<br><br><br>";
 	}


//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	
								/*
								$S2="SELECT * FROM MN_TIENDA WHERE DES_CLAVE<>100 ORDER BY COD_TIENDA ASC";
								$RS2 = sqlsrv_query($maestra, $S2);
								//oci_execute($RS2);
								while ($row2 = sqlsrv_fetch_array($RS2)) {
									$COD_TIENDA = $row2['COD_TIENDA'];
									$DES_TIENDA = $row2['DES_TIENDA'];
									$DES_CLAVE = $row2['DES_CLAVE'];
										$S3="SELECT MAX(ID_BSN_UN) AS ID_BSN_UN FROM PA_STR_RTL";
										$RS3 = sqlsrv_query($arts_conn, $S3);
										//oci_execute($RS3);
										if ($row3 = sqlsrv_fetch_array($RS3)) {
												$ID_BSN_UN=$row3['ID_BSN_UN']+1;
											} else {
												$ID_BSN_UN=1;
										}
										$S3="INSERT INTO PA_STR_RTL (ID_BSN_UN, DE_STR_RT, CD_STR_RT) VALUES (".$ID_BSN_UN.", '".$DES_TIENDA."', ".$DES_CLAVE.")";
										$RS3 = sqlsrv_query($arts_conn, $S3);
										//oci_execute($RS3);
										echo $S3."<br>";
								}
								*/
			/*^
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10701,'MACHALA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10702,'ARENILLAS')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10703,'ATAHUALPA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10704,'BALSAS')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10705,'CHILLA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10706,'EL GUABO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10707,'HUAQUILLAS')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10708,'MARCABELI')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10709,'PASAJE')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10710,'PINAS')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10711,'PORTOVELO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10712,'SANTA ROSA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10713,'ZARUMA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10714,'LAS LAJAS')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10801,'ESMERALDAS')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10802,'ELOY ALFARO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10803,'MUISNE')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10804,'QUININDE')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10805,'SAN LORENZO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10806,'ATACAMES')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10807,'RIO VERDE')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10901,'GUAYAQUIL')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10902,'ALFREDO BAQUERIZO MORENO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10903,'BALAO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10904,'BALZAR')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10905,'COLIMES')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10906,'DAULE')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10907,'DURAN')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10908,'EL EMPALME')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10909,'EL TRIUNFO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10910,'MILAGRO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10911,'NARANJAL')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10912,'NARANJITO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10913,'PALESTINA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10914,'PEDRO CARBO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10916,'SAMBORONDON')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10918,'SANTA LUCIA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10919,'SALITRE')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10920,'SAN JACINTO DE YAGUACHI')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10921,'PLAYAS (GENERAL VILLAMIL)')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10922,'SIMON BOLIVAR')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10923,'CORONEL MARCELINO MARIDUENA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10924,'LOMAS DE SARGENTILLO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10925,'NOBOL (VICENTE PIEDRAHITA)')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10927,'GENERAL ANTONIO ELIZALDE')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (10928,'ISIDRO AYORA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11201,'BABAHOYO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11202,'BABA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11203,'MONTALVO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11204,'PUEBLO VIEJO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11205,'QUEVEDO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11206,'URDANETA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11207,'VENTANAS')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11208,'VINCES')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11209,'PALENQUE')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11210,'BUENA FE')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11211,'VALENCIA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11212,'MOCACHE')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11301,'PORTOVIEJO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11302,'BOLIVAR')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11303,'CHONE')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11304,'EL CARMEN')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11305,'FLAVIO ALFARO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11306,'JIPIJAPA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11307,'JUNIN')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11308,'MANTA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11309,'MONTECRISTI')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11310,'PAJAN')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11311,'PICHINCHA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11312,'ROCAFUERTE')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11313,'SANTA ANA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11314,'SUCRE')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11315,'TOSAGUA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11316,'24 DE MAYO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11317,'PEDERNALES')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11318,'OLMEDO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11319,'PUERTO LOPEZ')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11320,'JAMA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11321,'JARAMIJO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (11322,'SAN VICENTE')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (12401,'SANTA ELENA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (12402,'LA LIBERTAD')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (12403,'SALINAS')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20101,'CUENCA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20102,'GIRON')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20103,'GUALACEO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20104,'NABON')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20105,'PAUTE')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20106,'PUCARA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20107,'SAN FERNANDO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20108,'SANTA ISABEL')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20109,'SIGSIG')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20110,'ONA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20111,'CHORDELEG')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20112,'EL PAN')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20113,'SEVILLA DE ORO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20114,'GUACHAPALA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20115,'CAMILO PONCE ENRIQUEZ')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20201,'GUARANDA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20202,'CHILLANES')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20203,'CHIMBO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20204,'ECHEANDIA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20205,'SAN MIGUEL')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20206,'CALUMA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20207,'LAS NAVES')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20301,'AZOGUES')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20302,'BIBLIAN')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20303,'CANAR')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20304,'LA TRONCAL')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20305,'EL TAMBO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20306,'DELEG')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20307,'SUSCAL')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20401,'TULCAN')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20402,'BOLIVAR')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20403,'ESPEJO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20404,'MIRA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20405,'MONTUFAR')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20406,'SAN PEDRO DE HUACA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20501,'LATACUNGA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20502,'LA MANA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20503,'PANGUA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20504,'PUJILI')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20505,'SALCEDO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20506,'SAQUISILI')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20507,'SIGCHOS')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20601,'RIOBAMBA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20602,'ALAUSI')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20603,'COLTA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20604,'CHAMBO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20605,'CHUNCHI')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20606,'GUAMOTE')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20607,'GUANO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20608,'PALLATANGA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20609,'PENIPE')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (20610,'CUMANDA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21001,'IBARRA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21002,'ANTONIO ANTE')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21003,'COTACACHI')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21004,'OTAVALO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21005,'PIMAMPIRO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21006,'SAN MIGUEL DE URCUQUI')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21101,'LOJA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21102,'CALVAS')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21103,'CATAMAYO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21104,'CELICA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21105,'CHAHUARPAMBA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21106,'ESPINDOLA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21107,'GONZANAMA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21108,'MACARA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21109,'PALTAS')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21110,'PUYANGO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21111,'SARAGURO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21112,'SOZORANGA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21113,'ZAPOTILLO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21114,'PINDAL')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21115,'QUILANGA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21116,'OLMEDO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21701,'QUITO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21702,'CAYAMBE')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21703,'MEJIA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21704,'PEDRO MONCAYO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21705,'RUMINAHUI')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21707,'SAN MIGUEL DE LOS BANCOS')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21708,'PEDRO VICENTE MALDONADO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21709,'PUERTO QUITO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21801,'AMBATO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21802,'BANOS DE AGUA SANTA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21803,'CEVALLOS')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21804,'MOCHA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21805,'PATATE')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21806,'QUERO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21807,'SAN PEDRO DE PELILEO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21808,'SANTIAGO DE PILLARO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (21809,'TISALEO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (22301,'SANTO DOMINGO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31401,'MORONA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31402,'GUALAQUIZA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31403,'LIMON - INDANZA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31404,'PALORA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31405,'SANTIAGO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31406,'SUCUA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31407,'HUAMBOYA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31408,'SAN JUAN BOSCO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31409,'TAISHA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31410,'LOGRONO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31411,'PABLO SEXTO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31412,'TIWINTZA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31501,'TENA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31503,'ARCHIDONA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31504,'EL CHACO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31507,'QUIJOS')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31509,'CARLOS JULIO AROSEMENA T.')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31601,'PASTAZA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31602,'MERA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31603,'SANTA CLARA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31604,'ARAJUNO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31901,'ZAMORA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31902,'CHINCHIPE')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31903,'NANGARITZA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31904,'YACUAMBI')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31905,'YANTZAZA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31906,'EL PANGUI')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31907,'CENTINELA DEL CONDOR')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31908,'PALANDA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (31909,'PAQUISHA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (32101,'LAGO AGRIO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (32102,'GONZALO PIZARRO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (32103,'PUTUMAYO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (32104,'SHUSHUFINDI')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (32105,'SUCUMBIOS')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (32106,'CASCALES')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (32107,'CUYABENO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (32201,'ORELLANA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (32202,'AGUARICO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (32203,'LA JOYA DE LOS SACHAS')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (32204,'LORETO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (42001,'SAN CRISTOBAL')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (42002,'ISABELA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_CANTON (COD_CANTON, NM_CANTON) VALUES (42003,'SANTA CRUZ')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);


			$S2="INSERT INTO MN_PROVINCIA (COD_PROVINCIA, NM_PROVINCIA) VALUES (107,'EL ORO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_PROVINCIA (COD_PROVINCIA, NM_PROVINCIA) VALUES (108,'ESMERALDA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_PROVINCIA (COD_PROVINCIA, NM_PROVINCIA) VALUES (109,'GUAYAS')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_PROVINCIA (COD_PROVINCIA, NM_PROVINCIA) VALUES (112,'LOS RIOS')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_PROVINCIA (COD_PROVINCIA, NM_PROVINCIA) VALUES (113,'MANABI')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_PROVINCIA (COD_PROVINCIA, NM_PROVINCIA) VALUES (124,'SANTA ELENA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_PROVINCIA (COD_PROVINCIA, NM_PROVINCIA) VALUES (201,'AZUAY')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_PROVINCIA (COD_PROVINCIA, NM_PROVINCIA) VALUES (202,'BOLIVAR')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_PROVINCIA (COD_PROVINCIA, NM_PROVINCIA) VALUES (203,'CAÑAR')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_PROVINCIA (COD_PROVINCIA, NM_PROVINCIA) VALUES (204,'CARCHI')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_PROVINCIA (COD_PROVINCIA, NM_PROVINCIA) VALUES (205,'COTOPAXI')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_PROVINCIA (COD_PROVINCIA, NM_PROVINCIA) VALUES (206,'CHIMBORAZO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_PROVINCIA (COD_PROVINCIA, NM_PROVINCIA) VALUES (210,'IMBABURA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_PROVINCIA (COD_PROVINCIA, NM_PROVINCIA) VALUES (211,'LOJA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_PROVINCIA (COD_PROVINCIA, NM_PROVINCIA) VALUES (217,'PICHINCHA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_PROVINCIA (COD_PROVINCIA, NM_PROVINCIA) VALUES (218,'TUNGURAHUA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_PROVINCIA (COD_PROVINCIA, NM_PROVINCIA) VALUES (223,'SANTO DOMINGO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_PROVINCIA (COD_PROVINCIA, NM_PROVINCIA) VALUES (314,'MORONA SANTIAGO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_PROVINCIA (COD_PROVINCIA, NM_PROVINCIA) VALUES (315,'NAPO')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_PROVINCIA (COD_PROVINCIA, NM_PROVINCIA) VALUES (316,'PASTAZA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_PROVINCIA (COD_PROVINCIA, NM_PROVINCIA) VALUES (319,'ZAMORA CHINCHIPE')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_PROVINCIA (COD_PROVINCIA, NM_PROVINCIA) VALUES (321,'SUCUMBIOS')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_PROVINCIA (COD_PROVINCIA, NM_PROVINCIA) VALUES (322,'ORELLANA')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			$S2="INSERT INTO MN_PROVINCIA (COD_PROVINCIA, NM_PROVINCIA) VALUES (420,'GALAPAGOS')";
			$RS2 = sqlsrv_query($maestra, $S2);
			//oci_execute($RS2);
			*/






		
?>