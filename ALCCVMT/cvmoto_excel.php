<?php include("conecta.inc"); ?>
<?php

	$FECSRVARCH=date("dmY");
	$TIMESRVARCH=date("His");
	$IDUSU=@$_GET["IDUSU"];
	$ID_BSN_UN=@$_GET["ID_BSN_UN"];
	if(empty($ID_BSN_UN)){$ID_BSN_UN=0;}
	$B_FACTURA=@$_GET["B_FACTURA"] ;

	
					//OBTENER CC_OPERADOR
					$SQL="SELECT CC_OPERADOR FROM US_USUARIOS WHERE IDUSU=".$IDUSU;
					$RS = sqlsrv_query($maestra, $SQL);
					//oci_execute($RS);
					if ($row = sqlsrv_fetch_array($RS)) {
						$CC_OPERADOR = $row['CC_OPERADOR'];
					}
					//SI CC_OPERADOR = 0 ENTONCES ES USUARIO CENTRAL
					if($CC_OPERADOR==0){
							$FLT_GERENTE="";
					} else {
							$FLT_GERENTE=" AND CC_OPERADOR=".$CC_OPERADOR;
					}

					
					if($ID_BSN_UN!=0){
							$FILTRO_TIENDACVM=" AND ID_TRN IN(SELECT ID_TRN FROM TR_TRN WHERE ID_BSN_UN=".$ID_BSN_UN.") " ;
					} else {
							$FILTRO_TIENDACVM="" ;
					}

					$FILTRO_FACTURA="";
					if (!empty($B_FACTURA)) {
						$FILTRO_FACT=" AND ID_TRN IN(SELECT ID_TRN FROM TR_INVC WHERE INVC_NMB  Like '%".$B_FACTURA."%' ) ";
					}

					$FILTRO_NSERIE="";
					$B_SERIE=@$_GET["B_SERIE"] ;
					if (!empty($B_SERIE)) {
						$FILTRO_NSERIE=" AND SRL_NBR Like '%".strtoupper($B_SERIE)."%' " ;
					}

					$DIA_ED=@$_GET["DIA_ED"];
					$MES_ED=@$_GET["MES_ED"];
					$ANO_ED=@$_GET["ANO_ED"];
					$DIA_EH=@$_GET["DIA_EH"];
					$MES_EH=@$_GET["MES_EH"];
					$ANO_EH=@$_GET["ANO_EH"];

					$DIA_ED=substr('00'.$DIA_ED, -2);
					$MES_ED=substr('00'.$MES_ED, -2);
					$FECHA_ED=$DIA_ED."/".$MES_ED."/".$ANO_ED;
					
					$DIA_EH=substr('00'.$DIA_EH, -2);
					$MES_EH=substr('00'.$MES_EH, -2);
					$FECHA_EH=$DIA_EH."/".$MES_EH."/".$ANO_EH;

					//$F_FECHA=" WHERE ID_TRN IN(SELECT ID_TRN FROM TR_TRN WHERE TO_CHAR(TS_TRN_END,'yyyy-mm-dd hh24:mi:ss') >= '".$ANO_ED."-".$MES_ED."-".$DIA_ED." 00:00:00' AND TO_CHAR(TS_TRN_END,'yyyy-mm-dd hh24:mi:ss') <='".$ANO_EH."-".$MES_EH."-".$DIA_EH." 23:59:59'  AND FL_VD<>1 AND FL_CNCL<>1)"; 


					$F_FECHA=" WHERE ID_TRN IN(SELECT ID_TRN FROM TR_TRN WHERE convert(varchar(20),TS_TRN_END, 111) >= convert(varchar(20),'".$ANO_ED."/".$MES_ED."/".$DIA_ED."', 111) AND convert(varchar(20),TS_TRN_END, 111) <= convert(datetime,'".$ANO_EH."/".$MES_EH."/".$DIA_EH."', 111)  AND FL_VD<>1 AND FL_CNCL<>1)"; 
					
					$RANGO_FECHA = "Filtrado desde el ".$DIA_ED."/".$MES_ED."/".$ANO_ED." al ".$DIA_EH."/".$MES_EH."/".$ANO_EH;


   require_once '../Classes/PHPExcel.php';
   $objPHPExcel = new PHPExcel();
    
   //PROPIEDADES DEL ARCHIVO
   $objPHPExcel->
    getProperties()
        ->setCreator("ARMS")
        ->setLastModifiedBy("Carta Venta Motos")
        ->setTitle("Reporte de Ventas Clase Motos")
        ->setSubject("Reportes Carta Venta Motos")
        ->setDescription("")
        ->setKeywords("")
        ->setCategory("Reportes");    
 

		$styleArrayTitle = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '333333'),
				'size'  => 13,
			));
		$styleArray = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => 'FFFFFF'),
				'size'  => 11,
			));

	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:Z1');
      $objPHPExcel->getActiveSheet()->getStyle('A1:Z1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	  $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(62);
	  $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArrayTitle);
	  $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setIndent(2);
	  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	  $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
	  $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
	  $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
	  $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
	  $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
	  $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
	  $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
	  
      $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', "Reporte de transacciones Carta Venta Motos\n".$RANGO_FECHA."\nReporte emitido al ".$FECSRV." ".$TIMESRV);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true);


		$objPHPExcel->getActiveSheet()->getStyle('B4:M4')->getFill()->applyFromArray(
			array(
				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
				'startcolor' => array('rgb' => '333333'),
			)
		);
	
	  $objPHPExcel->getActiveSheet()->getStyle('B4:M4')->applyFromArray($styleArray);
      $objPHPExcel->getActiveSheet()->getStyle('B4:M4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	  $objPHPExcel->getActiveSheet()->getStyle('B4:M4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	  $objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(24);
      $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B4', 'SERIE');

      $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C4', 'CODIGO ART');
      $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('D4', 'ARTICULO');
      $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('E4', 'FACTURA');
      $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('F4', 'FECHA');

      $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('G4', 'CLIENTE');
      $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('H4', 'IDENTIFICACION');
      $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('I4', 'TIPO ID');
      $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('J4', 'TIENDA');
      $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('K4', 'TERMINAL');
      $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('L4', 'GERENTE');
      $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('M4', 'ESTADO');


	$SQLCLTE="SELECT * FROM TR_LTM_MOTO_DT ".$F_FECHA.$FILTRO_TIENDACVM.$FILTRO_NSERIE.$FILTRO_FACT.$FLT_GERENTE." ORDER BY ID_TRN  DESC, AI_LN_ITM ASC";
	$RS = sqlsrv_query($arts_conn, $SQLCLTE);
	//oci_execute($RS);
	$NUMCELDA=5;
	while ($row = sqlsrv_fetch_array($RS)){

			$SRL_NBR = $row['SRL_NBR'];
			$ID_TRN = $row['ID_TRN'];
			$AI_LN_ITM = $row['AI_LN_ITM'];
			$GERENTE = $row['CC_OPERADOR'];

					$S2="SELECT * FROM TR_TRN WHERE ID_TRN=".$ID_TRN;
					$RS2 = sqlsrv_query($arts_conn, $S2);
					//oci_execute($RS2);
					if ($row2 = sqlsrv_fetch_array($RS2)) {
						$ID_BSN_UN = $row2['ID_BSN_UN'];
						$ID_WS = $row2['ID_WS'];
						$FECHA_TICKET = $row2['DC_DY_BSN'];
					}	
					$S2="SELECT * FROM AS_WS WHERE ID_WS=".$ID_WS;
					$RS2 = sqlsrv_query($arts_conn, $S2);
					//oci_execute($RS2);
					if ($row2 = sqlsrv_fetch_array($RS2)) {
						$CD_WS = $row2['CD_WS'];
					}	

					$S2="SELECT * FROM US_USUARIOS WHERE CC_OPERADOR=".$GERENTE;
					$RS2 = sqlsrv_query($maestra, $S2);
					//oci_execute($RS2);
					if ($row2 = sqlsrv_fetch_array($RS2)) {
						$NOMBGERENTE = $row2['NOMBRE'];
					}	

					$S2="SELECT * FROM PA_STR_RTL WHERE ID_BSN_UN=".$ID_BSN_UN;
					$RS2 = sqlsrv_query($arts_conn, $S2);
					//oci_execute($RS2);
					if ($row2 = sqlsrv_fetch_array($RS2)) {
						$CODTIENDA = $row2['CD_STR_RT'];
						$DESTIENDA = $CODTIENDA." - ".$row2['DE_STR_RT'];
					}	
					$S2="SELECT * FROM TR_LTM_SLS_RTN WHERE ID_TRN=".$ID_TRN." AND AI_LN_ITM=".$AI_LN_ITM;
					$RS2 = sqlsrv_query($arts_conn, $S2);
					//oci_execute($RS2);
					if ($row2 = sqlsrv_fetch_array($RS2)) {
						$ID_ITM = $row2['ID_ITM'];
					}

					$S2="SELECT * FROM AS_ITM WHERE ID_ITM=".$ID_ITM;
					$RS2= sqlsrv_query($arts_conn, $S2);
					//oci_execute($RS2);
					if ($row2 = sqlsrv_fetch_array($RS2)) {
						$NM_ITM =  $row2['NM_ITM'];
						$CD_ITM = $row2['CD_ITM'];
						$DE_ITM = $row2['DE_ITM'];
						if(empty($DE_ITM)){$DE_ITM=$NM_ITM;}
					}
					
				$SQLF="SELECT * FROM TR_INVC WHERE ID_TRN=".$ID_TRN;
				$RSF = sqlsrv_query($arts_conn, $SQLF);
				//oci_execute($RSF);
				if ($rowf = sqlsrv_fetch_array($RSF)) {
					$INVC_NMB = $rowf['INVC_NMB'];
					$ID_CPR = $rowf['ID_CPR'];
					$FL_CP = $rowf['FL_CP'];
				}
						if($FL_CP==0){
									$SQLM="SELECT * FROM CO_CPR_CER WHERE ID_CPR=".$ID_CPR;
									$RSM = sqlsrv_query($arts_conn, $SQLM);
									//oci_execute($RSM);
									if ($rowM = sqlsrv_fetch_array($RSM)) {
										$NOM_CPR = $rowM['NOMBRE'];
										$CD_CPR = $rowM['CD_CPR'];
										$TY_CPR = $rowM['TY_CPR'];
									}
						
						} else {
									$SQLE="SELECT * FROM CO_EXT_CER WHERE ID_CPR=".$ID_CPR;
									$RSE = sqlsrv_query($arts_conn, $SQLE);
									//oci_execute($RSE);
									if ($rowE = sqlsrv_fetch_array($RSE)) {
										$NOM_CPR = $rowE['NOMBRE'];
										$CD_CPR = $rowE['CD_CPR'];
										$TY_CPR = "P";
									}
						}

					$SQLF="SELECT COUNT(ID_CARTA) AS CTAMOTO FROM CM_CARTAS WHERE ID_TRN=".$ID_TRN;
					$RSF = sqlsrv_query($conn, $SQLF);
					//oci_execute($RSF);
					if ($rowf = sqlsrv_fetch_array($RSF)) {
						$CTAMOTO = $rowf['CTAMOTO'];
					}
							if($CTAMOTO == 0) {$ELESTADO="PENDIENTE CARTA";}
							if($CTAMOTO != 0) {
									$SQLF="SELECT * FROM CM_CARTAS WHERE ID_TRN=".$ID_TRN;
									$RSF = sqlsrv_query($conn, $SQLF);
									//oci_execute($RSF);
									if ($rowf = sqlsrv_fetch_array($RSF)) {
										$ESTADO = $rowf['ESTADO'];
										if($ESTADO==0){$ELESTADO="PENDIENTE EMISION"; }
										if($ESTADO==1){$ELESTADO="CARTA ACEPTADA"; }
										if($ESTADO==2){$ELESTADO="CARTA IMPRESA Y ENVIADA"; }
										if($ESTADO==3){$ELESTADO="CARTA RE-IMPRESA"; }
										if($ESTADO==4){$ELESTADO="CARTA RECHAZADA"; }
									}
							}
					$RES_TICKET=explode(" ",$FECHA_TICKET);
					$TS_TICKET=$RES_TICKET[0];
					
					
								

			  $objPHPExcel->getActiveSheet()->getRowDimension($NUMCELDA)->setRowHeight(24);
		      $objPHPExcel->getActiveSheet()->getStyle('B'.$NUMCELDA.':M'.$NUMCELDA)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			  $objPHPExcel->getActiveSheet()->getStyle('B'.$NUMCELDA.':M'.$NUMCELDA)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			  $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('B'.$NUMCELDA, $SRL_NBR);

//			  $objPHPExcel->getActiveSheet()->getStyle('C'.$CD_ITM)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//			  $objPHPExcel->getActiveSheet()->getStyle('C'.$CD_ITM)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
			  $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('C'.$NUMCELDA, $CD_ITM);
					
//			  $objPHPExcel->getActiveSheet()->getStyle('D'.$DE_ITM)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			  $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('D'.$NUMCELDA, $DE_ITM);
					
//			  $objPHPExcel->getActiveSheet()->getStyle('E'.$INVC_NMB)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//			  $objPHPExcel->getActiveSheet()->getStyle('E'.$INVC_NMB)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
			  $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('E'.$NUMCELDA, $INVC_NMB);

//			  $objPHPExcel->getActiveSheet()->getStyle('F'.$TS_TICKET)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//			  $objPHPExcel->getActiveSheet()->getStyle('F'.$TS_TICKET)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
			  $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('F'.$NUMCELDA, $TS_TICKET);


//			  $objPHPExcel->getActiveSheet()->getStyle('G'.$NOM_CPR)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			  $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('G'.$NUMCELDA, $NOM_CPR);

//			  $objPHPExcel->getActiveSheet()->getStyle('H'.$CD_CPR)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			  $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('H'.$NUMCELDA, $CD_CPR);
	
			  $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('I'.$NUMCELDA, $TY_CPR);

			  $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('J'.$NUMCELDA, $DESTIENDA);
	
//			  $objPHPExcel->getActiveSheet()->getStyle('K'.$CD_WS)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//			  $objPHPExcel->getActiveSheet()->getStyle('K'.$CD_WS)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
			  $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('K'.$NUMCELDA, $CD_WS);

			  $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('L'.$NUMCELDA, $NOMBGERENTE);
	
			  $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('M'.$NUMCELDA, $ELESTADO);

		$NUMCELDA=$NUMCELDA+1;
	}

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="RptCartaVentaMotos_'.$FECSRVARCH.'_'.$TIMESRVARCH.'.xlsx"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;



?>
