

<?php include("session.inc");?>

<?php include("headerhtml.inc");?>

<?php

	$PAGINA=1150;

	$NOMENU=1;



	$FILTRO_FLAGS=" AND FL_TRG_TRN<>1 AND FL_CNCL<>1 AND FL_VD<>1 AND FL_SPN IS NULL";



	$BSC_NDC=@$_POST["BSC_NDC"];

	if (empty($BSC_NDC)) { $BSC_NDC=@$_GET["BSC_NDC"] ;}

		

				$VERTND_UNO = 0;

				//VERIFICAR TIENDAS ASOCIADAS A USUARIO

				$SQL="SELECT COUNT(COD_TIENDA) AS CTATND FROM US_USUTND WHERE IDUSU=".$SESIDUSU;

				$RS = sqlsrv_query($maestra, $SQL);

				//oci_execute($RS);

				if ($row = sqlsrv_fetch_array($RS)) {

					$CTATND = $row['CTATND'];

				}

				//SI CTATND==0 USUARIO CENTRAL, SELECCIONAR NEGOCIO Y LOCAL

				//SI CTATND==1 DESPLEGAR LOCAL

				//SI CTATND>1 DESPLEGAR LISTADO DE LOCALES

				if($CTATND==1){

					//OBTENER NEGOCIO

					$SQL="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO IN(SELECT COD_NEGOCIO FROM US_USUTND WHERE IDUSU=".$SESIDUSU.")";

					$RS = sqlsrv_query($maestra, $SQL);

					//oci_execute($RS);

					if ($row = sqlsrv_fetch_array($RS)) {

						$COD_NEGOCIO_SEL = $row['COD_NEGOCIO'];

						$DES_NEGOCIO = $row['DES_NEGOCIO'];

						$ELNEGOCIO = $DES_NEGOCIO;

					}

					//OBTENER TIENDA

					$SQL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA IN(SELECT COD_TIENDA FROM US_USUTND WHERE IDUSU=".$SESIDUSU.")";

					$RS = sqlsrv_query($maestra, $SQL);

					//oci_execute($RS);

					if ($row = sqlsrv_fetch_array($RS)) {

						$DES_CLAVE = $row['DES_CLAVE'];

						$DES_CLAVE_F="0000".$DES_CLAVE;

						$DES_CLAVE_F=substr($DES_CLAVE_F, -4); 

						$DES_TIENDA = $row['DES_TIENDA'];

						$LATIENDA = $DES_CLAVE_F." ".$DES_TIENDA;

						$COD_TIENDA_SEL = $row['COD_TIENDA'];

						//VERIFICAR QUE TIENDA SE ENCUENTRE REGISTRADA Y/O CON PRECIOS ARTS.AS_ITM_STR

						$SQL1="SELECT COUNT(ID_BSN_UN) AS VERTND FROM PA_STR_RTL WHERE CD_STR_RT=".$DES_CLAVE;

						$RS1 = sqlsrv_query($conn, $SQL1);

						//oci_execute($RS1);

						if ($row1 = sqlsrv_fetch_array($RS1)) {

							$VERTND_UNO = $row1['VERTND'];

						}

						$LATIENDA_SI = "Tienda: ".$DES_CLAVE_F." - ".$DES_TIENDA;

						//OBTENER ID_BSN_UN

						$SQL1="SELECT ID_BSN_UN FROM PA_STR_RTL WHERE CD_STR_RT=".$DES_CLAVE;

						$RS1 = sqlsrv_query($conn, $SQL1);

						//oci_execute($RS1);

						if ($row1 = sqlsrv_fetch_array($RS1)) {

							$ID_BSN_UN_SEL = $row1['ID_BSN_UN'];

						}

					}

				} else { //if($CTATND==1)



								$COD_NEGOCIO_SEL=@$_POST["COD_NEGOCIO"];

								if(empty($COD_NEGOCIO_SEL)) { $COD_NEGOCIO_SEL=@$_GET["COD_NEGOCIO"];}

								if(empty($COD_NEGOCIO_SEL)) { $COD_NEGOCIO_SEL=@$_POST["COD_NEGOCIO_SI"];}

								if(empty($COD_NEGOCIO_SEL)) { $COD_NEGOCIO_SEL=@$_GET["COD_NEGOCIO_SI"];}

								

								$COD_TIENDA_SEL=@$_POST["COD_TIENDA"];

								if(empty($COD_TIENDA_SEL)) { $COD_TIENDA_SEL=@$_GET["COD_TIENDA"];}

								if(empty($COD_TIENDA_SEL)) { $COD_TIENDA_SEL=@$_POST["COD_TIENDA_SI"];}

								if(empty($COD_TIENDA_SEL)) { $COD_TIENDA_SEL=@$_GET["COD_TIENDA_SI"];}

								

								if(!empty($COD_TIENDA_SEL)) {

									$SQL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA=".$COD_TIENDA_SEL;

									$RS = sqlsrv_query($maestra, $SQL);

									//oci_execute($RS);

									if ($row = sqlsrv_fetch_array($RS)) {

										$DES_CLAVE_SEL = $row['DES_CLAVE'];

										$DES_CLAVE_FSI="0000".$DES_CLAVE_SEL;

										$DES_CLAVE_FSI=substr($DES_CLAVE_FSI, -4); 

										$DES_TIENDA_FSI = $row['DES_TIENDA'];

										$LATIENDA_SI = "Tienda: ".$DES_CLAVE_FSI." - ".$DES_TIENDA_FSI;

				

									}

									$SQL="SELECT ID_BSN_UN FROM PA_STR_RTL WHERE CD_STR_RT=".$DES_CLAVE_SEL;

									$RS = sqlsrv_query($conn, $SQL);

									//oci_execute($RS);

									if ($row = sqlsrv_fetch_array($RS)) {

										$ID_BSN_UN_SEL = $row['ID_BSN_UN'];

									}

								}



				} //if($CTATND==1)

	if(!empty($ID_BSN_UN_SEL))

	{

		@$FILTRO_TIENDA=" AND ID_BSN_UN=". $ID_BSN_UN_SEL ;

	}

	else

	{

		@$FILTRO_TIENDA="";

	}

	$BUSCAR=@$_POST["BUSCAR"];

	if (empty($BUSCAR)) { $BUSCAR=@$_GET["BUSCAR"] ;}

	

	$FILTRO_TERM="";

	$FTERM=@$_POST["FTERM"];

	if (empty($FTERM)) { $FTERM=@$_GET["FTERM"] ;}

	if (empty($FTERM)) { $FTERM=0 ;}

	if ($FTERM!=0) {

		$FILTRO_TERM=" AND ID_WS=".$FTERM ;

	}

		

	$FILTRO_OPERA="";

	$FOPERA=@$_POST["FOPERA"];

	if (empty($FOPERA)) { $FOPERA=@$_GET["FOPERA"] ;}

	if (empty($FOPERA)) { $FOPERA=0 ;}

	if ($FOPERA!=0) {

		$FILTRO_OPERA=" AND ID_OPR=".$FOPERA ;

	}

		

	$FILTRO_TICKET="";

	$BOPCION=@$_POST["BOPCION"];

	if (empty($BOPCION)) { $BOPCION=@$_GET["BOPCION"];}

	if (empty($BOPCION)) { $BOPCION=2;}

				if ($BOPCION==1) {

						$FILTRO_DGFC=" AND ID_TRN IN(SELECT ID_TRN FROM TR_INVC) ";

				} 

	$B_TICKET=@$_POST["B_TICKET"];

	if (empty($B_TICKET)) { $B_TICKET=@$_GET["B_TICKET"] ;}

	if (!empty($B_TICKET)) {

			if($D_GFC==3){

				$FILTRO_TICKET="" ;

				$FILTRO_FACT=" AND ID_TRN IN(SELECT ID_TRN FROM TR_INVC WHERE INVC_NMB Like '%".$B_TICKET."%') ";

			} else {

				if ($BOPCION==1) {

						$FILTRO_TICKET="" ;

						$FILTRO_FACT=" AND ID_TRN IN(SELECT ID_TRN FROM TR_INVC WHERE INVC_NMB Like '%".$B_TICKET."%') ";

						$FILTRO_DGFC=" AND ID_TRN IN(SELECT ID_TRN FROM TR_INVC) ";

				} 

				if ($BOPCION==2) {

						$FILTRO_TICKET=" AND AI_TRN=".$B_TICKET;

						$FILTRO_FACT=" " ;

				} 

			}

	}





			

					//CALCULAR MINIMO Y MÁXIMO FECHA REGISTRO TICKET

					$CONSULTA2="SELECT MIN(TS_TRN_END) AS MFECHA FROM TR_TRN WHERE ID_TRN IN (SELECT ID_TRN FROM TR_RTL WHERE QU_UN_RTL_TRN>0) AND FL_VD<>1 AND FL_CNCL<>1";

					$RS2 = sqlsrv_query($conn, $CONSULTA2);

					//oci_execute($RS2);

					if ($row = sqlsrv_fetch_array($RS2)){

							$MIN_FECHA_EMS = $row['MFECHA'];

							$MIN_FECHA_EMS = date_format($MIN_FECHA_EMS,"d/m/Y");



					}

					$CONSULTA2="SELECT MAX(TS_TRN_END) AS MFECHA FROM TR_TRN WHERE ID_TRN IN (SELECT ID_TRN FROM TR_RTL WHERE QU_UN_RTL_TRN>0) AND FL_VD<>1 AND FL_CNCL<>1";

					$RS2 = sqlsrv_query($conn, $CONSULTA2);

					//oci_execute($RS2);

					if ($row = sqlsrv_fetch_array($RS2)){

							$MAX_FECHA_EMS = $row['MFECHA'];

							$MAX_FECHA_EMS = date_format($MAX_FECHA_EMS,"d/m/Y");

					}

					if (empty($MIN_FECHA_EMS)) { $MIN_FECHA_EMS=date('d/m/Y'); }

					if (empty($MAX_FECHA_EMS)) { $MAX_FECHA_EMS=date('d/m/Y'); }

					

					//FECHA REGISTRO TICKET DESDE

					$DIA_ED=@$_POST["DIA_ED"];

					if (empty($DIA_ED)) { $DIA_ED=@$_GET["DIA_ED"]; }

					if (empty($DIA_ED)) { $DIA_ED=substr($MIN_FECHA_EMS, 0, 2); }

					$MES_ED=@$_POST["MES_ED"];

					if (empty($MES_ED)) { $MES_ED=@$_GET["MES_ED"]; }

					if (empty($MES_ED)) { $MES_ED=substr($MIN_FECHA_EMS, 3, 2); }

					$ANO_ED=@$_POST["ANO_ED"];

					if (empty($ANO_ED)) { $ANO_ED=@$_GET["ANO_ED"]; }

					if (empty($ANO_ED)) { $ANO_ED='20'.substr($MIN_FECHA_EMS, -2); }

					//FECHA REGISTRO HASTA

					$DIA_EH=@$_POST["DIA_EH"];

					if (empty($DIA_EH)) { $DIA_EH=@$_GET["DIA_EH"]; }

					if (empty($DIA_EH)) { $DIA_EH=substr($MAX_FECHA_EMS, 0, 2); }

					$MES_EH=@$_POST["MES_EH"];

					if (empty($MES_EH)) { $MES_EH=@$_GET["MES_EH"]; }

					if (empty($MES_EH)) { $MES_EH=substr($MAX_FECHA_EMS, 3, 2); }

					$ANO_EH=@$_POST["ANO_EH"];

					if (empty($ANO_EH)) { $ANO_EH=@$_GET["ANO_EH"]; }

					if (empty($ANO_EH)) { $ANO_EH='20'.substr($MAX_FECHA_EMS, -2); }

					//CONSTRUYE FECHAS REGISTRO TICKET

					//VALIDAR FECHA_ED

					if (checkdate($MES_ED, $DIA_ED, $ANO_ED)==false) { 

						$MSJE=2 ;

						$DIA_ED=substr($MIN_FECHA_EMS, 0, 2);

						$MES_ED=substr($MIN_FECHA_EMS, 3, 2);

						$ANO_ED='20'.substr($MIN_FECHA_EMS, -2);

						$DIA_EH=substr($MAX_FECHA_EMS, 0, 2);

						$MES_EH=substr($MAX_FECHA_EMS, 3, 2);

						$ANO_EH='20'.substr($MAX_FECHA_EMS, -2);

					}

					$DIA_ED=substr('00'.$DIA_ED, -2);

					$MES_ED=substr('00'.$MES_ED, -2);

					$FECHA_ED=$DIA_ED."/".$MES_ED."/".$ANO_ED;

					

					if (checkdate($MES_EH, $DIA_EH, $ANO_EH)==false) { 

						$MSJE=3 ;

						$DIA_ED=substr($MIN_FECHA_EMS, 0, 2);

						$MES_ED=substr($MIN_FECHA_EMS, 3, 2);

						$ANO_ED='20'.substr($MIN_FECHA_EMS, -2);

						$DIA_EH=substr($MAX_FECHA_EMS, 0, 2);

						$MES_EH=substr($MAX_FECHA_EMS, 3, 2);

						$ANO_EH='20'.substr($MAX_FECHA_EMS, -2);

					}

					$DIA_EH=substr('00'.$DIA_EH, -2);

					$MES_EH=substr('00'.$MES_EH, -2);

					$FECHA_EH=$DIA_EH."/".$MES_EH."/".$ANO_EH;

					//FILTRO FECHA REGISTRO



					$F_FECHA=" WHERE Convert(varchar(20), TS_TRN_END, 111) >= Convert(varchar(20), '".$ANO_ED."/".$MES_ED."/".$DIA_ED."', 111) AND Convert(varchar(20), TS_TRN_END, 111) <= Convert(varchar(20),'".$ANO_EH."/".$MES_EH."/".$DIA_EH."', 111) AND FL_VD<>1  AND  FL_CNCL<>1 ";

					

?>



</head>



<body>



<?php include("encabezado.php");?>

<?php include("titulo_menu.php");?>

<table width="100%" height="100%">

<tr>

<td align="right"  width="200" bgcolor="#FFFFFF"><?php include("menugeneral.php");?></td> 

<td >



        <table width="100%">

        <tr><td>

        <table width="100%" id="Filtro">

                    <form action="reg_tickets.php?D_GFC=<?php echo $D_GFC ?>&BUSCAR=1" method="post" name="forming" id="forming">

                    <tr>

                    <td>

										<?php

                                            if($CTATND==1){

										?>

                                            <h5><?php echo $ELNEGOCIO." ".$LATIENDA ?></h5>

										<?php

                                            }//if($CTATND==1)

                

                                            if($CTATND>1){//SELECCIONAR NEGOCIO (si es que hay más de uno) Y TIENDA

                                            $VERTND_UNO = 1;

                                            //CUENTA NEGOCIOS

                                                $SQL="SELECT COUNT(*) AS CTANEG FROM (SELECT COD_NEGOCIO FROM US_USUTND WHERE IDUSU=".$SESIDUSU." GROUP BY COD_NEGOCIO)";

                                                $RS = sqlsrv_query($maestra, $SQL);

                                                //oci_execute($RS);

                                                if ($row = sqlsrv_fetch_array($RS)) {

                                                    $CTANEG = $row['CTANEG'];

                                                }

                                            //SI CTANEG==1 DESPLEGAR SOLO LOCALES ASOCIADOS

                                                    //SI CTANEG>1 DESPLEGAR LISTADO NEGOCIOS Y LOCALES ASOCIADOS

                                                    if($CTANEG>1){//SELECCIONAR NEGOCIO Y TIENDAS ASOCIADAS

                                                            if(!empty($CD_ITM_SI) && !empty($COD_TIENDA_SEL) && !empty($COD_NEGOCIO_SEL)){

                                                                //OBTENER NEGOCIO

                                                                $SQL="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO =".$COD_NEGOCIO_SEL;

                                                                $RS = sqlsrv_query($maestra, $SQL);

                                                                //oci_execute($RS);

                                                                if ($row = sqlsrv_fetch_array($RS)) {

                                                                    $COD_NEGOCIO_SEL = $row['COD_NEGOCIO'];

                                                                    $DES_NEGOCIO = $row['DES_NEGOCIO'];

                                                                    $ELNEGOCIO = $DES_NEGOCIO;

                                                                }

                                                                //OBTENER NEGOCIO

                                                                $SQL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA =".$COD_TIENDA_SEL;

                                                                $RS = sqlsrv_query($maestra, $SQL);

                                                                //oci_execute($RS);

                                                                if ($row = sqlsrv_fetch_array($RS)) {

                                                                    $DES_CLAVE = $row['DES_CLAVE'];

                                                                    $DES_CLAVE_F="0000".$DES_CLAVE;

                                                                    $DES_CLAVE_F=substr($DES_CLAVE_F, -4); 

                                                                    $DES_TIENDA = $row['DES_TIENDA'];

                                                                    $LATIENDA = $DES_CLAVE_F." ".$DES_TIENDA;

                                                                    $COD_TIENDA_SEL = $row['COD_TIENDA'];

                                                                }

                                                                ?>

                                                                    <h5><?php echo $ELNEGOCIO." ".$LATIENDA ?></h5>

                                                                    <input type="hidden" name="COD_NEGOCIO" value="<?php echo $COD_NEGOCIO_SEL?>">

                                                                    <input type="hidden" name="COD_TIENDA" value="<?php echo $COD_TIENDA_SEL?>">

                                                                <?php

                                                            } else {

                                                                ?>

                                                                    <select name="COD_NEGOCIO" onChange="CargaTiendaSelect(this.value, this.form.name, 'COD_TIENDA', <?=$SESIDUSU?>)">

                                                                                <option value="0">SELECCIONAR NEGOCIO</option>

                                                                                <?php 

                                                                                $SQL="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO IN(SELECT COD_NEGOCIO FROM US_USUTND WHERE IDUSU=".$SESIDUSU.") ORDER BY DES_NEGOCIO ASC";

                                                                                $RS = sqlsrv_query($maestra, $SQL);

                                                                                //oci_execute($RS);

                                                                                while ($row = sqlsrv_fetch_array($RS)) {

                                                                                    $COD_NEGOCIO = $row['COD_NEGOCIO'];

                                                                                    $DES_NEGOCIO = $row['DES_NEGOCIO'];

                                                                                 ?>

                                                                                <option value="<?php echo $COD_NEGOCIO ?>" <?php if($COD_NEGOCIO==$COD_NEGOCIO_SEL) {echo "Selected";} ?>><?php echo $DES_NEGOCIO ?></option>

                                                                                <?php 

                                                                                }

                                                                                 ?>

                                                                </select>

                                                                <select id="COD_TIENDA" name="COD_TIENDA" onChange="document.forms.forming.submit();">

                                                                    <option value="0">SELECCIONAR TIENDA</option>

                                                                    <?php

                                                                    if(!empty($COD_TIENDA_SEL)){

                                                                                $SQL="SELECT COD_TIENDA, DES_TIENDA, DES_CLAVE FROM MN_TIENDA WHERE COD_TIENDA IN(SELECT COD_TIENDA FROM US_USUTND WHERE IDUSU=".$SESIDUSU.") ORDER BY DES_CLAVE ASC";

                                                                                $RS = sqlsrv_query($maestra, $SQL);

                                                                                //oci_execute($RS);

                                                                                while ($row = sqlsrv_fetch_array($RS)) {

                                                                                    $NUM_TIENDA = $row['DES_CLAVE'];

                                                                                    $NUM_TIENDA_F="0000".$NUM_TIENDA;

                                                                                    $NUM_TIENDA_F=substr($NUM_TIENDA_F, -4); 

                                                                                    $STRDES = $row['DES_TIENDA'];

                                                                                    $STRCOD =$row['COD_TIENDA'];		

                                                                                    //VERIFICAR QUE TIENDA SE ENCUENTRE REGISTRADA Y/O CON PRECIOS ARTS.AS_ITM_STR

                                                                                    $SQL1="SELECT COUNT(ID_BSN_UN) AS VERTND FROM PA_STR_RTL WHERE CD_STR_RT=".$NUM_TIENDA;

                                                                                    $RS1 = sqlsrv_query($conn, $SQL1);

                                                                                    //oci_execute($RS1);

                                                                                    if ($row1 = sqlsrv_fetch_array($RS1)) {

                                                                                        $VERTND = $row1['VERTND'];

                                                                                    }

                                                                                    if($VERTND != 0){

                                                                                     ?>

                                                                                    <option value="<?php echo $STRCOD ?>" <?php if($STRCOD==$COD_TIENDA_SEL) {echo "Selected";} ?>><?php echo $NUM_TIENDA_F." - ".$STRDES ?></option>

                                                                                    <?php 

                                                                                    }

                                                                                }

                                                                    }

                                                                    ?>

                                                                </select>

                                                                <?php

                                                            }//!empty($CD_ITM_SI) && !empty($COD_TIENDA_SEL)

                                                    }//$CTANEG>1

                                                    if($CTANEG==1){//SELECCIONAR TIENDAS ASOCIADAS

                                                            if(!empty($CD_ITM_SI) && !empty($COD_TIENDA_SEL) && !empty($COD_NEGOCIO_SEL)){

                                                                $SQL="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO =".$COD_NEGOCIO_SEL;

                                                                $RS = sqlsrv_query($maestra, $SQL);

                                                                //oci_execute($RS);

                                                                if ($row = sqlsrv_fetch_array($RS)) {

                                                                    $COD_NEGOCIO_SEL = $row['COD_NEGOCIO'];

                                                                    $DES_NEGOCIO = $row['DES_NEGOCIO'];

                                                                    $ELNEGOCIO = $DES_NEGOCIO;

                                                                }

                                                                $SQL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA =".$COD_TIENDA_SEL;

                                                                $RS = sqlsrv_query($maestra, $SQL);

                                                                //oci_execute($RS);

                                                                if ($row = sqlsrv_fetch_array($RS)) {

                                                                    $DES_CLAVE = $row['DES_CLAVE'];

                                                                    $DES_CLAVE_F="0000".$DES_CLAVE;

                                                                    $DES_CLAVE_F=substr($DES_CLAVE_F, -4); 

                                                                    $DES_TIENDA = $row['DES_TIENDA'];

                                                                    $LATIENDA = $DES_CLAVE_F." ".$DES_TIENDA;

                                                                    $COD_TIENDA_SEL = $row['COD_TIENDA'];

                                                                }

                                                                ?>

                                                                    <h5><?php echo $ELNEGOCIO." ".$LATIENDA ?></h5>

                                                                    <input type="hidden" name="COD_NEGOCIO" value="<?php echo $COD_NEGOCIO_SEL?>">

                                                                    <input type="hidden" name="COD_TIENDA" value="<?php echo $COD_TIENDA_SEL?>">

                                                                <?php

                                                            } else {

                                                             ?>

                                                                    <select name="COD_TIENDA" onChange="document.forms.forming.submit();">

                                                                                <option value="0">SELECCIONAR TIENDA</option>

                                                                                <?php 

                                                                                $SQL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA IN(SELECT COD_TIENDA FROM US_USUTND WHERE IDUSU=".$SESIDUSU.") ORDER BY DES_CLAVE ASC";

                                                                                $RS = sqlsrv_query($maestra, $SQL);

                                                                                //oci_execute($RS);

                                                                                while ($row = sqlsrv_fetch_array($RS)) {

                                                                                        $COD_TIENDA = $row['COD_TIENDA'];

                                                                                        $DES_CLAVE = $row['DES_CLAVE'];

                                                                                        $DES_CLAVE_F="0000".$DES_CLAVE;

                                                                                        $DES_CLAVE_F=substr($DES_CLAVE_F, -4); 

                                                                                        $DES_TIENDA = $row['DES_TIENDA'];

                                                                                        $LATIENDA = $DES_CLAVE_F." ".$DES_TIENDA;

                                                                                            //VERIFICAR QUE TIENDA SE ENCUENTRE REGISTRADA Y/O CON PRECIOS ARTS.AS_ITM_STR

                                                                                            $SQL1="SELECT COUNT(ID_BSN_UN) AS VERTND FROM PA_STR_RTL WHERE CD_STR_RT=".$DES_CLAVE;

                                                                                            $RS1 = sqlsrv_query($conn, $SQL1);

                                                                                            //oci_execute($RS1);

                                                                                            if ($row1 = sqlsrv_fetch_array($RS1)) {

                                                                                                $VERTND = $row1['VERTND'];

                                                                                            }

                                                                                        if($VERTND != 0){

                                                                                             ?>

                                                                                            <option value="<?php echo $COD_TIENDA ?>"  <?php if($COD_TIENDA==$COD_TIENDA_SEL) {echo "Selected";} ?>><?php echo $LATIENDA ?></option>

                                                                                            <?php 

                                                                                        }

                                                                                }

                                                                                 ?>

                                                                </select>

                                                        <?php

                                                                //OBTENER NEGOCIO

                                                                $SQL1="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO IN(SELECT COD_NEGOCIO FROM US_USUTND WHERE IDUSU=".$SESIDUSU.") ";

                                                                $RS1 = sqlsrv_query($maestra, $SQL1);

                                                                //oci_execute($RS1);

                                                                if ($row1 = sqlsrv_fetch_array($RS1)) {

                                                                    $COD_NEGOCIO_TND = $row1['COD_NEGOCIO'];

                                                                }

                                                        ?>

                                                            <input type="hidden" name="COD_NEGOCIO" value="<?php echo $COD_NEGOCIO_TND?>">

                                                        <?php

                                                        }//!empty($CD_ITM_SI) && !empty($COD_TIENDA_SEL)

                                                    }//$CTANEG==1

                                            }//$CTATND==0)

                

                

                                            if($CTATND==0){//SELECCIONAR NEGOCIO Y TIENDA

                                                    if(!empty($CD_ITM_SI) && !empty($COD_TIENDA_SEL) && !empty($COD_NEGOCIO_SEL)){

                                                                $SQL="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO =".$COD_NEGOCIO_SEL;

                                                                $RS = sqlsrv_query($maestra, $SQL);

                                                                //oci_execute($RS);

                                                                if ($row = sqlsrv_fetch_array($RS)) {

                                                                    $COD_NEGOCIO_SEL = $row['COD_NEGOCIO'];

                                                                    $DES_NEGOCIO = $row['DES_NEGOCIO'];

                                                                    $ELNEGOCIO = $DES_NEGOCIO;

                                                                }

                                                                $SQL="SELECT * FROM MN_TIENDA WHERE COD_TIENDA =".$COD_TIENDA_SEL;

                                                                $RS = sqlsrv_query($maestra, $SQL);

                                                                //oci_execute($RS);

                                                                if ($row = sqlsrv_fetch_array($RS)) {

                                                                    $DES_CLAVE = $row['DES_CLAVE'];

                                                                    $DES_CLAVE_F="0000".$DES_CLAVE;

                                                                    $DES_CLAVE_F=substr($DES_CLAVE_F, -4); 

                                                                    $DES_TIENDA = $row['DES_TIENDA'];

                                                                    $LATIENDA = $DES_CLAVE_F." ".$DES_TIENDA;

                                                                    $COD_TIENDA_SEL = $row['COD_TIENDA'];

                                                                }

                                                                ?>

                                                                    <h5><?php echo $ELNEGOCIO." ".$LATIENDA ?></h5>

                                                                    <input type="hidden" name="COD_NEGOCIO" value="<?php echo $COD_NEGOCIO_SEL?>">

                                                                    <input type="hidden" name="COD_TIENDA" value="<?php echo $COD_TIENDA_SEL?>">

                                                        <?php

                                                    } else {

                                                        ?>

                                                                    <select name="COD_NEGOCIO" onChange="CargaTiendaSelectE(this.value, this.form.name, 'COD_TIENDA')">

                                                                                <option value="0">SELECCIONAR NEGOCIO</option>

                                                                                <?php 

                                                                                $SQL="SELECT * FROM MN_NEGOCIO ORDER BY DES_NEGOCIO ASC";

                                                                                $RS = sqlsrv_query($maestra, $SQL);

                                                                                //oci_execute($RS);

                                                                                while ($row = sqlsrv_fetch_array($RS)) {

                                                                                    $COD_NEGOCIO = $row['COD_NEGOCIO'];

                                                                                    $DES_NEGOCIO = $row['DES_NEGOCIO'];

                                                                                 ?>

                                                                                <option value="<?php echo $COD_NEGOCIO ?>" <?php if($COD_NEGOCIO==$COD_NEGOCIO_SEL) {echo "Selected";} ?>><?php echo $DES_NEGOCIO ?></option>

                                                                                <?php 

                                                                                }

                                                                                 ?>

                                                                </select>

                                                                <select  id="COD_TIENDA" name="COD_TIENDA" onChange="document.forms.forming.submit();">

                                                                    <option value="0">SELECCIONAR TIENDA</option>

                                                                    <?php

                                                                    if(!empty($COD_TIENDA_SEL)){

                                                                                $SQL="SELECT COD_TIENDA, DES_TIENDA, DES_CLAVE FROM MN_TIENDA WHERE COD_TIENDA IN(SELECT COD_TIENDA FROM MN_NEGTND WHERE COD_NEGOCIO=".$COD_NEGOCIO_SEL.")   ORDER BY DES_CLAVE ASC";

                                                                                $RS = sqlsrv_query($maestra, $SQL);

                                                                                //oci_execute($RS);

                                                                                $VERTND=0;

                                                                                while ($row = sqlsrv_fetch_array($RS)) {

                                                                                    $NUM_TIENDA = $row['DES_CLAVE'];

                                                                                    $NUM_TIENDA_F="0000".$NUM_TIENDA;

                                                                                    $NUM_TIENDA_F=substr($NUM_TIENDA_F, -4); 

                                                                                    $STRDES = $row['DES_TIENDA'];

                                                                                    $STRCOD =$row['COD_TIENDA'];

                                                                                    //VERIFICAR QUE TIENDA SE ENCUENTRE REGISTRADA Y/O CON PRECIOS ARTS.AS_ITM_STR

                                                                                    $SQL1="SELECT COUNT(ID_BSN_UN) AS VERTND FROM PA_STR_RTL WHERE CD_STR_RT=".$NUM_TIENDA;

                                                                                    $RS1 = sqlsrv_query($conn, $SQL1);

                                                                                    //oci_execute($RS1);

                                                                                    if ($row1 = sqlsrv_fetch_array($RS1)) {

                                                                                        $VERTND = $row1['VERTND'];

                                                                                    }

                                                                                if($VERTND != 0){

                                                                                 ?>

                                                                                        <option value="<?php echo $STRCOD ?>" <?php if($STRCOD==$COD_TIENDA_SEL) {echo "Selected";} ?> ><?php echo $NUM_TIENDA_F." - ".$STRDES ?></option>

                                                                                <?php 

                                                                                }

                                                                                }

                                                                    }

                                                                    ?>

                                                                </select>

                                                        <?php

                                                    }//!empty($CD_ITM_SI) && !empty($COD_TIENDA_SEL)

                                            }//if($CTATND==0)

                                        ?>

                                        

                                        <?php if(!empty($COD_TIENDA_SEL)){?>

                                                <select name="FTERM" onChange="document.forms.forming.submit();">

                                                    <option value="0">Terminal</option>

                                                    <?php 

                                                    $SQLFILTRO="SELECT ID_WS FROM TR_TRN ".$F_FECHA." AND  ID_TRN IN(SELECT ID_TRN FROM TR_RTL ) AND  ID_BSN_UN=".$ID_BSN_UN_SEL." GROUP BY ID_WS ORDER BY ID_WS ASC";

                                                    $RSF = sqlsrv_query($conn, $SQLFILTRO);

                                                    //oci_execute($RSF);

                                                    while ($rowF = sqlsrv_fetch_array($RSF)) {

                                                        $FLT_ID_WS = $rowF['ID_WS'];

                                                        $S2="SELECT CD_WS FROM AS_WS WHERE ID_WS=".$FLT_ID_WS;

                                                        $RS2 = sqlsrv_query($conn, $S2);

                                                        //oci_execute($RS2);

                                                        if ($row2 = sqlsrv_fetch_array($RS2)) {

                                                            $FLTDES_WS = $row2['CD_WS'];

                                                        }	

                                                        ?>

                                                        <option value="<?php echo $FLT_ID_WS ?>" <?php  if ($FLT_ID_WS==$FTERM) { echo "SELECTED";}?>><?php echo $FLTDES_WS ?></option>

                                                        <?php 

                                                    }

                                                    ?>

                                                </select>

                                                <select name="FOPERA" onChange="document.forms.forming.submit();">

                                                    <option value="0">Operador</option>

                                                    <?php 

                                                    $SQLFILTRO="SELECT * FROM PA_OPR WHERE ID_OPR IN(SELECT ID_OPR FROM TR_TRN ".$F_FECHA." AND  ID_TRN IN(SELECT ID_TRN FROM TR_RTL) AND  ID_BSN_UN=".$ID_BSN_UN_SEL.") ORDER BY CD_OPR ASC";

                                                    $RSF = sqlsrv_query($conn, $SQLFILTRO);

                                                    //oci_execute($RSF);

                                                    while ($rowF = sqlsrv_fetch_array($RSF)) {

                                                        $FLT_ID_OPR = $rowF['ID_OPR'];

                                                        $FLTCD_OPR = $rowF['CD_OPR'];

                                                        ?>

                                                        <option value="<?php echo $FLT_ID_OPR ?>" <?php  if ($FLT_ID_OPR==$FOPERA) { echo "SELECTED";}?>><?php echo $FLTCD_OPR ?></option>

                                                        <?php 

                                                    }

                                                    ?>

                                                </select>

                                        <?php } //if($FTIENDA<>0){?>



                                     <label style="clear:left" for="FECHA_EM_D">Desde </label>

                                    <input name="DIA_ED" type="text" id="DIA_ED" value="<?php echo $DIA_ED ?>" size="2" maxlength="2" onKeyPress="return acceptNum(event);">

                                   <select name="MES_ED" id="MES_ED">

                                                <option value="01" <?php  if ($MES_ED==1) { echo "SELECTED";}?>>Enero</option>

                                                <option value="02" <?php  if ($MES_ED==2) { echo "SELECTED";}?>>Febrero</option>

                                                <option value="03" <?php  if ($MES_ED==3) { echo "SELECTED";}?>>Marzo</option>

                                                <option value="04" <?php  if ($MES_ED==4) { echo "SELECTED";}?>>Abril</option>

                                                <option value="05" <?php  if ($MES_ED==5) { echo "SELECTED";}?>>Mayo</option>

                                                <option value="06" <?php  if ($MES_ED==6) { echo "SELECTED";}?>>Junio</option>

                                                <option value="07" <?php  if ($MES_ED==7) { echo "SELECTED";}?>>Julio</option>

                                                <option value="08" <?php  if ($MES_ED==8) { echo "SELECTED";}?>>Agosto</option>

                                                <option value="09" <?php  if ($MES_ED==9) { echo "SELECTED";}?>>Septiembre</option>

                                                <option value="10" <?php  if ($MES_ED==10) { echo "SELECTED";}?>>Octubre</option>

                                                <option value="11" <?php  if ($MES_ED==11) { echo "SELECTED";}?>>Noviembre</option>

                                                <option value="12" <?php  if ($MES_ED==12) { echo "SELECTED";}?>>Diciembre</option>

                                        </select>

                                        <input name="ANO_ED" type="text" id="ANO_ED" value="<?php echo $ANO_ED ?>" size="4" maxlength="4">

                                    <label for="FECHA_EM_H">Hasta </label>

                                    <input name="DIA_EH" type="text" id="DIA_EH" value="<?php echo $DIA_EH ?>" size="2" maxlength="2" onKeyPress="return acceptNum(event);">

                                        <select name="MES_EH" id="MES_EH">

                                                <option value="01" <?php  if ($MES_EH==1) { echo "SELECTED";}?>>Enero</option>

                                                <option value="02" <?php  if ($MES_EH==2) { echo "SELECTED";}?>>Febrero</option>

                                                <option value="03" <?php  if ($MES_EH==3) { echo "SELECTED";}?>>Marzo</option>

                                                <option value="04" <?php  if ($MES_EH==4) { echo "SELECTED";}?>>Abril</option>

                                                <option value="05" <?php  if ($MES_EH==5) { echo "SELECTED";}?>>Mayo</option>

                                                <option value="06" <?php  if ($MES_EH==6) { echo "SELECTED";}?>>Junio</option>

                                                <option value="07" <?php  if ($MES_EH==7) { echo "SELECTED";}?>>Julio</option>

                                                <option value="08" <?php  if ($MES_EH==8) { echo "SELECTED";}?>>Agosto</option>

                                                <option value="09" <?php  if ($MES_EH==9) { echo "SELECTED";}?>>Septiembre</option>

                                                <option value="10" <?php  if ($MES_EH==10) { echo "SELECTED";}?>>Octubre</option>

                                                <option value="11" <?php  if ($MES_EH==11) { echo "SELECTED";}?>>Noviembre</option>

                                                <option value="12" <?php  if ($MES_EH==12) { echo "SELECTED";}?>>Diciembre</option>

                                        </select>

                                        <input name="ANO_EH" type="text" id="ANO_EH" value="<?php echo $ANO_EH ?>" size="4" maxlength="4" onKeyPress="return acceptNum(event);">

                                		<label style="clear:left" for="B_TICKET"><?php echo @$TICKET_FACT?> </label>

                                  		<input name="B_TICKET" type="text"  id="B_TICKET" value="<?php echo $B_TICKET ?>" size="9" maxlength="9" onKeyPress="return acceptNum(event);">

                                        <?php if(@$D_GFC!=3){?>

                                               <input type="radio" name="BOPCION" value="2" <?php if($BOPCION==2) {?> checked <?php }?>>

                                               <label for="BOPCION2">Ticket</label>

                                               <input type="radio" name="BOPCION" value="1"  <?php if($BOPCION==1) {?> checked <?php }?>>

                                               <label for="BOPCION1">Factura</label>

                                        <?php }?>

                                        <input name="BUSCAR" type="submit" id="BUSCAR" value="Buscar <?php echo @$TICKET_FACT?>">

                                        <input name="LIMPIAR" type="button" id="LIMPIAR" value="Limpiar" onClick="pagina('reg_tickets.php');">



                    </td>

                    </tr>

                    </form>

                    </table>

             

             

              

                <table style="margin:10px 20px; ">

                <tr>

                <td>

					<?php

                     //FORMATO DE FECHA               

					//$SQL="ALTER SESSION SET nls_date_format='DD-MM-YYYY HH24:MI:SS'";

					//$RS = sqlsrv_query($conn, $SQL);

					//oci_execute($RS);

					//CUENTA REGISTROS

					$CONSULTA="SELECT COUNT(*) AS CUENTA FROM TR_TRN ".$F_FECHA." ".$FILTRO_FLAGS." AND ID_TRN IN(SELECT ID_TRN FROM TR_RTL WHERE QU_UN_RTL_TRN>0 ".@$FILTRO_FACT.@$FILTRO_DGFC.") ".@$FILTRO_TIENDA.$FILTRO_TERM.$FILTRO_OPERA.$FILTRO_TICKET;



					$RS = sqlsrv_query($conn, $CONSULTA);

					//oci_execute($RS);

					if ($row = sqlsrv_fetch_array($RS)) {

						$TOTALREG = $row['CUENTA'];

						$NUMTPAG = round($TOTALREG/$CTP,0);

						$RESTO=$TOTALREG%$CTP;

						$CUANTORESTO=round($RESTO/$CTP, 0);

						if($RESTO>0 and $CUANTORESTO==0) {$NUMTPAG=$NUMTPAG+1;}

						$NUMPAG = round($LSUP/$CTP,0);

						if ($NUMTPAG==0) {

							$NUMTPAG=1;

							}

					}

					if($TOTALREG>=1){ //ENCONTRO AL MENOS UNO

					//CONSULTA RESULTADO BÚSQUEDA

					//$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM TR_TRN ".$F_FECHA." ".$FILTRO_FLAGS." AND  ID_TRN IN(SELECT ID_TRN FROM TR_RTL WHERE QU_UN_RTL_TRN>0 ".$FILTRO_FACT.$FILTRO_DGFC.") ".$FILTRO_TIENDA.$FILTRO_TERM.$FILTRO_OPERA.$FILTRO_TICKET." ORDER BY TS_TRN_END  DESC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;

				

					//oci_execute($RS);



					$CONSULTA= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY TS_TRN_END DESC) ROWNUMBER FROM TR_TRN ".$F_FECHA." ".$FILTRO_FLAGS." AND  ID_TRN IN(SELECT ID_TRN FROM TR_RTL WHERE QU_UN_RTL_TRN>0 ".@$FILTRO_FACT.@$FILTRO_DGFC." ) ".@$FILTRO_TIENDA.$FILTRO_TERM.$FILTRO_OPERA.$FILTRO_TICKET." ) AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";



					$RS = sqlsrv_query($conn, $CONSULTA);

				   ?>

                    <table id="Listado">

                    <tr>

                        <th colspan="2" style="padding-left: 36px">Ticket / Factura</th>

                        <th>Local</th>

                        <th>Terminal</th>

                        <th>Operador</th>

                        <th>Pago</th>

                        <th>Monto</th>

                        <th>Fecha Venta</th>

                        <th style="border-left-width:3px; border-left-style:solid; border-left-color:#DFDFDF; text-align:right">Inicio TRX</th>

                        <th style="text-align:right">T&eacute;rmino TRX</th>

                    </tr>

                    <?php

                    $VER_IMPORTE=0;

					$CUENTAFILAS=1;

                    while ($row = sqlsrv_fetch_array($RS)){

						$NO_DEVS=0;

						$ID_TRN = $row['ID_TRN'];

						$AI_TRN = $row['AI_TRN'];

						$S2="SELECT * FROM TR_RTL WHERE ID_TRN=".$ID_TRN; //OBTENER MONEDA, CANTIDAD DE ARTÍCULOS Y TX_INC

						$RS2 = sqlsrv_query($conn, $S2);

						//oci_execute($RS2);

						if ($row2 = sqlsrv_fetch_array($RS2)) {

							$ID_CNY = $row2['ID_CNY'];

							$CANT_ITEMS = $row2['QU_UN_RTL_TRN'];

							$TAXINCL = $row2['TX_INC'];

						}

						$FECHA_TICKET = $row['TS_TRN_END'];

						$TS_TICKET = date_format($FECHA_TICKET,"d/m/Y");

						//$RES_TICKET=explode(" ",$FECHA_TICKET);

						//$TS_TICKET=$RES_TICKET[0];

						

						if(empty($CANT_ITEMS)){$CANT_ITEMS="NR";}

						if(!empty($ID_CNY)){ //PAGO EN MONEDA EXTRANJERA

							$S3="SELECT CD_CY_ISO FROM CO_CNY WHERE ID_CNY=".$ID_CNY;

							$RS3 = sqlsrv_query($conn, $S3);

							//oci_execute($RS3);

							if ($row3 = sqlsrv_fetch_array($RS3)) { $MONEDA = $row3['CD_CY_ISO']; }	

						}

						$TIPO_MEDPAGO="NR";

						$S2="SELECT ID_TND  FROM TR_LTM_TND WHERE ID_TRN=".$ID_TRN." ".@$FPAGO." GROUP BY ID_TND ";

						$RS2 = sqlsrv_query($conn, $S2);

						//oci_execute($RS2);

						$MEDIODEPAGO="";

						while ($row2 = sqlsrv_fetch_array($RS2)) {

							$ID_TND = $row2['ID_TND'];

							$S3="SELECT DE_TND FROM AS_TND WHERE ID_TND=".$ID_TND;

							$RS3 = sqlsrv_query($conn, $S3);

							//oci_execute($RS3);

							if ($row3 = sqlsrv_fetch_array($RS3)) { $MEDIODEPAGO = $MEDIODEPAGO." ".$row3['DE_TND']."/ "; }

							if(empty($MEDIODEPAGO)) {$MEDIODEPAGO="NO DEFINIDO:";}

						}	

						$TIPO_MEDPAGO = $MEDIODEPAGO;

						$IMPORTE=0;

						$S2="SELECT SUM((CASE FL_IS_CHNG  WHEN 1 THEN (-1) ELSE (1) END)* MO_ITM_LN_TND) AS SUMAIMPORTE  FROM TR_LTM_TND WHERE ID_TRN=".$ID_TRN;

						$RS2 = sqlsrv_query($conn, $S2);

						//oci_execute($RS2);

						if ($row2 = sqlsrv_fetch_array($RS2)) { $IMPORTE = $row2['SUMAIMPORTE']; }

						if($IMPORTE<0) {

							$COLORTRX="; color: #ED686E"; 

							$NO_DEVS=1;

						}

						$VER_IMPORTE=$IMPORTE;

						$IMPORTE=$IMPORTE/$DIVCENTS;

						$IMPORTE=number_format($IMPORTE, $CENTS, $GLBSDEC, $GLBSMIL);

						//VERIFICAR GROSSPOS-GROSSNEG EN TR_TOT_RTL

						$GROSS_POS=0;

						$S2="SELECT *  FROM TR_TOT_RTL WHERE ID_TRN=".$ID_TRN." AND ID_TR_TOT_TYP=1";

						$RS2 = sqlsrv_query($conn, $S2);

						//oci_execute($RS2);

						if ($row2 = sqlsrv_fetch_array($RS2)) { $GROSS_POS = $row2['MO_TOT_RTL_TRN']; }

						$GROSS_NEG=1;

						$S2="SELECT *  FROM TR_TOT_RTL WHERE ID_TRN=".$ID_TRN." AND ID_TR_TOT_TYP=2";

						$RS2 = sqlsrv_query($conn, $S2);

						//oci_execute($RS2);

						if ($row2 = sqlsrv_fetch_array($RS2)) { $GROSS_NEG = $row2['MO_TOT_RTL_TRN'];  }

						$TOT_GROSS=$GROSS_POS-$GROSS_NEG;

						if($TOT_GROSS<>$VER_IMPORTE){ $DESCUADRE=1;  } else {  $DESCUADRE=0; }

						

						

						//VERIFICAR SI HAY REGISTRO DE DEVOLUCION

						$REG_DEVOL=0;

						//$S2="SELECT COUNT(ID_DEVS) AS CID_DEVS FROM DV_TICKET WHERE ID_TRN=".$ID_TRN;

						//$RS2 = sqlsrv_query($conn, $S2);

						//oci_execute($RS2);

						//if ($row2 = sqlsrv_fetch_array($RS2)) {

						//	$REG_DEVOL = $row2['CID_DEVS'];

						//}



    					//OPERADOR



						$ID_OPR = $row['ID_OPR'];

								$OPERADOR="NR";

								$S2="SELECT CD_OPR FROM PA_OPR WHERE ID_OPR=".$ID_OPR;

								$RS2 = sqlsrv_query($conn, $S2);

								//oci_execute($RS2);

								if ($row2 = sqlsrv_fetch_array($RS2)) {

									$OPERADOR = $row2['CD_OPR'];

								}

								$OPERADOR_F="00000000".$OPERADOR;

								$OPERADOR_F=substr($OPERADOR_F, -8); 

						//TERMINAL POS

						$ID_WS = $row['ID_WS'];

								$TERMINAL="NR";

								$S2="SELECT CD_WS FROM AS_WS WHERE ID_WS=".$ID_WS;

								$RS2 = sqlsrv_query($conn, $S2);

								//oci_execute($RS2);

								if ($row2 = sqlsrv_fetch_array($RS2)) {

									$TERMINAL = $row2['CD_WS'];

								}

								$TERMINAL_F="0000".$TERMINAL;

								$TERMINAL_F=substr($TERMINAL_F, -4);

						//TIENDA	

						$ID_BSN_UN = $row['ID_BSN_UN'];

								$TIENDA="NR";

								$S2="SELECT CD_STR_RT, INC_PRC FROM PA_STR_RTL WHERE ID_BSN_UN=".$ID_BSN_UN;

								$RS2 = sqlsrv_query($conn, $S2);

								//oci_execute($RS2);

								if ($row2 = sqlsrv_fetch_array($RS2)) {

									$CODTIENDA = $row2['CD_STR_RT'];

								}	

								$COD_TIENDA_F="0000".$CODTIENDA;

								$COD_TIENDA_F=substr($COD_TIENDA_F, -4);



						$TS_TRN_BGN = $row['TS_TRN_BGN'];

								$TS_TRN_BGN = date_format($TS_TRN_BGN,'H:i:s');

								//$RES_BGN=explode(" ",$TS_TRN_BGN);

								//$TS_TRN_BGN=$RES_BGN[1];

						$TS_TRN_END =  $row['TS_TRN_END'];

								$TS_TRN_END = date_format($TS_TRN_END,'H:i:s');

								//$RES_END=explode(" ",$TS_TRN_END);

								//$TS_TRN_END=$RES_END[1];



						//FACTURA

								$ESFACT=0;

								$S2="SELECT * FROM TR_INVC WHERE ID_TRN=".$ID_TRN;

								$RS2 = sqlsrv_query($conn, $S2);

								//oci_execute($RS2);

								if ($row2 = sqlsrv_fetch_array($RS2)) {

									$INVC_NMB = $row2['INVC_NMB'];

								}

						

						$ELTICKET=$AI_TRN;

						if(!empty($INVC_NMB)){ $ESFACT=1;}



						if($ESFACT==1){

							$ELTICKET=$AI_TRN." / ".$INVC_NMB; //CAMBIA TICKET POR NÚMERO DE FACTURA

						}



                   ?>

					<script>

                    function Ocultar<?php echo $ID_TRN?>(){

                        var mostrar = document.getElementById("mostrar<?php echo $ID_TRN?>");

                        var ocultar = document.getElementById("ocultar<?php echo $ID_TRN?>");

                        var ver = document.getElementById("ver<?php echo $ID_TRN?>");

                        var TcktO = document.getElementById("TcktO<?php echo $ID_TRN?>");

                        var TcktM = document.getElementById("TcktM<?php echo $ID_TRN?>");

                            mostrar.style.display = "table-cell";

                            ocultar.style.display = "none";

                            TcktO.style.display = "none";

                            TcktM.style.display = "table-cell";

                            ver.style.display = "none";

							for(j=1; j <= 11; j = j+1) {

								var TRN = document.getElementById("TRN"+j+"<?php echo $ID_TRN?>");

										TRN.className = "tdShow";

										TRN.style.color = "#333";

										<?php if($CUENTAFILAS%2==0){?>

											TRN.style.background = "#F1F1F1";

										<?php } else { ?>

											TRN.style.background = "#F7F7F7";

										<?php } ?>

							}

                    }



                    function Mostrar<?php echo $ID_TRN?>(){

                        var mostrar = document.getElementById("mostrar<?php echo $ID_TRN?>");

                        var ocultar = document.getElementById("ocultar<?php echo $ID_TRN?>");

                        var ver = document.getElementById("ver<?php echo $ID_TRN?>");

                        var TcktO = document.getElementById("TcktO<?php echo $ID_TRN?>");

                        var TcktM = document.getElementById("TcktM<?php echo $ID_TRN?>");

                            mostrar.style.display = "none";

                            ocultar.style.display = "table-cell";

                            TcktO.style.display = "table-cell";

                            TcktM.style.display = "none";

                            ver.style.display = "table-row";

							for(j=1; j <= 11; j = j+1) {

								var TRN = document.getElementById("TRN"+j+"<?php echo $ID_TRN?>");

									TRN.className = "tdHide";

									TRN.style.color = "#FFFFFF";

									TRN.style.background = "#8B44AA";

							}

					}

                    </script>

                    <tr>

                        <?php if(!empty($B_TICKET)){?>

                                            <td style="background:#FFF"><img src="images/Transpa.png" width="24"></td>

                        <?php } else { ?>

                                <?php if($NO_DEVS==0 && $CANT_ITEMS!="NR"){?>

									<?php if($REG_DEVOL!=0 && $D_GFC==3) {?>

                                            <td style="background:#FFF"><img src="images/Transpa.png" width="24"></td>

									<?php } else {?>

                                            <td class="tdShow" id="mostrar<?php echo $ID_TRN?>" onClick="Mostrar<?php echo $ID_TRN?>();"><img src="../images/ICO_ShowM.png"></td>

                                            <td style="display:none" class="tdHide" id="ocultar<?php echo $ID_TRN?>" onClick="Ocultar<?php echo $ID_TRN?>();"><img src="../images/ICO_ShowB.png"></td>

									<?php }?>

                                <?php } else {?>

                                        <td style="background:transparent"><img src="images/Transpa.png" width="24"></td>

                                <?php } ?>

                        <?php }?>

                                <td id="TcktM<?php echo $ID_TRN ?>" class="tdShow" style="text-align:right; font-size:14pt" onClick="Mostrar<?php echo $ID_TRN?>();"><?php echo $ELTICKET?></td>

                                <td id="TcktO<?php echo $ID_TRN ?>" class="tdHide" style="display:none; text-align:right; font-size:14pt" onClick="Ocultar<?php echo $ID_TRN?>();"><?php echo $ELTICKET?></td>

                        <td id="TRN1<?php echo $ID_TRN ?>"><?php echo $COD_TIENDA_F?></td>

                        <td id="TRN2<?php echo $ID_TRN ?>"><?php echo $TERMINAL_F?></td>

                        <td id="TRN3<?php echo $ID_TRN ?>"><?php echo $OPERADOR_F?></td>

                        <td id="TRN4<?php echo $ID_TRN ?>"><?php echo $TIPO_MEDPAGO?></td>

                        <td id="TRN5<?php echo $ID_TRN ?>"  style="text-align:right"><?php echo $MONEDA.$IMPORTE?></td>

                        <td id="TRN6<?php echo $ID_TRN ?>"  style="text-align:right"><?php echo $TS_TICKET?></td>

                        <td id="TRN7<?php echo $ID_TRN ?>"  style="border-left-width:3px; border-left-style:solid; border-left-color:#DFDFDF;text-align:right"><?php echo $TS_TRN_BGN?></td>

                        <td id="TRN8<?php echo $ID_TRN ?>"  style="text-align:right"><?php echo $TS_TRN_END?></td>

                        

                        

                        

						<?php if($DESCUADRE!=0){?>

                                <td style=" background-color:#DD4B39; font-size:14pt; font-weight:600; color:#FFF"><img src="../images/ICO_NopB.png"></td>

                        <?php } ?>

						<?php if($REG_DEVOL!=0){?>

                                <td style=" background-color:#FBF3FE; font-size:14pt; font-weight:600; text-align:center">D</td>

                        <?php } ?>

                        

                    </tr>

							<?php if(!empty($B_TICKET)){?>

                                <?php if($NO_DEVS==0){?>

                                    <tr id="ver<?php echo $ID_TRN?>" style="display:table-row">

                                <?php } else {?>

                                    <tr id="ver<?php echo $ID_TRN?>" style="display:none">

                                <?php }?>

                            <?php } else {?>

                            <tr id="ver<?php echo $ID_TRN?>" style="display:none">

                            <?php }?>

                                <td colspan="10" style="background-color:#FFF">

                                			

                                            <!-- DETALLE DE ITEMS EN TRX -->

                                           <?php include("reg_tickets_art.php");?>

                                            <!-- DETALLE DE ITEMS EN TRX -->



                                </td>

                            </tr>

                    <?php

                    $COLORTRX="";

					$INVC_NMB="";

					$ELTICKET="";

					$CUENTAFILAS=$CUENTAFILAS+1;

                    }

                    ?>

                    <?php if(empty($B_TICKET)){?>

                    <tr>

                        <td colspan="10" nowrap style="background-color:transparent">

                        <?php

                        if ($LINF>=$CTP+1) {

                            $ATRAS=$LINF-$CTP;

                            $FILA_ANT=$LSUP-$CTP;

                       ?>

                        <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('reg_tickets.php?&BUSCAR=<?php echo $BUSCAR?>&LSUP=<?php echo $FILA_ANT?>&LINF=<?php echo $ATRAS?>&FTIENDA=<?php echo $FTIENDA?>&FTERM=<?php echo $FTERM?>&FOPERA=<?php echo $FOPERA?>&DIA_ED=<?php echo $DIA_ED ?>&MES_ED=<?php echo $MES_ED ?>&ANO_ED=<?php echo $ANO_ED ?>&DIA_EH=<?php echo $DIA_EH ?>&MES_EH=<?php echo $MES_EH ?>&ANO_EH=<?php echo $ANO_EH ?>&B_TICKET=<?php echo $B_TICKET ?>&BOPCION=<?php echo $BOPCION ?>&COD_TIENDA=<?php echo $COD_TIENDA_SEL ?>&COD_NEGOCIO=<?php echo $COD_NEGOCIO_SEL ?>');">

                        <?php

                        }

                        if ($LSUP<=$TOTALREG) {

                            $ADELANTE=$LSUP+1;

                            $FILA_POS=$LSUP+$CTP;

                       ?>

                        <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('reg_tickets.php?&BUSCAR=<?php echo $BUSCAR?>&LSUP=<?php echo $FILA_POS?>&LINF=<?php echo $ADELANTE?>&FTIENDA=<?php echo $FTIENDA?>&FTERM=<?php echo $FTERM?>&FOPERA=<?php echo $FOPERA?>&DIA_ED=<?php echo $DIA_ED ?>&MES_ED=<?php echo $MES_ED ?>&ANO_ED=<?php echo $ANO_ED ?>&DIA_EH=<?php echo $DIA_EH ?>&MES_EH=<?php echo $MES_EH ?>&ANO_EH=<?php echo $ANO_EH ?>&B_TICKET=<?php echo $B_TICKET ?>&BOPCION=<?php echo $BOPCION ?>&COD_TIENDA=<?php echo $COD_TIENDA_SEL ?>&COD_NEGOCIO=<?php echo $COD_NEGOCIO_SEL ?>');">

                        <?php }?>

                        <span style="vertical-align:baseline;">P&aacute;gina <?php echo $NUMPAG?> de <?php echo $NUMTPAG?></span>

                        </td>

                    </tr>

                    <?php } //if(empty($B_TICKET))?>

                    </table>

                    <?php

					} else {

					?>

                    	<h4>No se registran coincidencias, por favor, intente nuevamente</h4>

                    <?php

					}//FIN ENCONTRO AL MENOS UNO

					

                    ?>

<?php

		sqlsrv_close($conn);

?>

               

               

        </td>

        </tr>

        </table>

</td>

</tr>

</table>

        <iframe name="frmHIDEN" width="0%" height="0" frameborder="0" align="top" src="" framespacing="0" marginheight="0" marginwidth="0">

        </iframe>

</body>

</html>



