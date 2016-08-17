
<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1170;
	$NOMENU=1;
	$MSJE=@$_GET["MSJE"];

	$RPTN1=@$_GET["r1"];
	$RPTN2=@$_GET["r2"];
	$RPT=@$_GET["rpt"];

	//VERIFICA SELECCION DE LOCAL
	@$TIENDA=$_POST["TIENDA"];
	if(empty($TIENDA)){ $TIENDA=@$_GET["tnd"] ;}
	if(empty($TIENDA)){ $TIENDA=0 ;}
	//$TIENDA=100;
	if ($TIENDA<>0) {
		$_SESSION['TIENDA_SEL'] = $TIENDA;	
	} else {
		$_SESSION['TIENDA_SEL'] = 0;	
	}
		
	$onLoad="";
	 if($RPTN1<>"" && $RPTN2<>""){ $onLoad="Mostrar".$RPTN1."(); ActivarSNV2".$RPTN2."(); ";}
	 if($RPTN2<>"" && $MSJE==2){
			$SQL="SELECT * FROM RA_NVL2 WHERE COD_NVL2=".$RPTN2;
			$RS = sqlsrv_query($conn, $SQL);
			//oci_execute($RS);
			if ($row = sqlsrv_fetch_array($RS)){
					$DES_ES_NVL2_MSJE =$row['DES_ES'];
			}
	 }


?>
</head>

<body onLoad="<?php echo $onLoad;?>">

<?php include("encabezado.php");?>
<?php include("titulo_menu.php");?>
<?php
if ($MSJE==1) {$ELMSJ="Reporte Vac&iacute;o, verifique las opciones y vuelva a intentar";} 
if ($MSJE==2) {$ELMSJ=$DES_ES_NVL2_MSJE." generado";} 
if ($MSJE <> "") {
?>
<div id="GMessaje" onClick="QuitarGMessage();"><a href="#" onClick="QuitarGMessage();" style="color:#111111;"><?php echo $ELMSJ?></a></div>
<?php }?>
<table width="100%" height="100%">
<tr>
<?php if(!empty($_SESSION['TIENDA_SEL'])){ ?>
    <td align="right"  width="300" bgcolor="#FFFFFF"><?php include("menuRepo.php");?></td> 
<?php } ?>
<td>
        <table width="100%">
        <tr><td>
        
						<?php
                            if(!empty($RPTN2)){
                                    $SQL="SELECT * FROM RA_NVL2 WHERE COD_NVL2=".$RPTN2;
                                    $RS = sqlsrv_query($conn, $SQL);
                                    //oci_execute($RS);
                                    if ($row = sqlsrv_fetch_array($RS)){
                                            $DES_ES_NVL2 =$row['DES_ES'];
                                    }
                                    echo "<h2>".$DES_ES_NVL2."</h2>";
                            }
                            $VentanaConsulta="none";
                        ?>
                        <table style="margin:10px 20px; ">
                        <tr>
                        <td>
                        <?php
                        //FORMULARIOS INFORMES (27 FORMULARIOS)
                        $StringForm = "r1=".$RPTN1."&r2=".$RPTN2."&tnd=".$_SESSION['TIENDA_SEL'];
                        ?>
        
                        <?php if($RPTN2==1){ include("RPT01_OperatorTerminalCash.php");}?>
                        <?php if($RPTN2==2){  include("RPT02_OfficeCash.php");}?>
                        <?php if($RPTN2==3){  include("RPT03_CashDrawerPosition.php");}?>
                        <?php if($RPTN2==4){  include("RPT04_OverShort.php");}?>
                        <?php if($RPTN2==5){  include("RPT05_StoreTotalsRecap.php");}?>
                        <?php if($RPTN2==6){  include("RPT06_TOFStatus.php");}?>
                        <?php if($RPTN2==7){  include("RPT07_CouponMultiplicationLimit.php");}?>
                        <?php if($RPTN2==8){  include("RPT08_MiscellaneousTransactionRecap.php");}?>
                        <?php if($RPTN2==9){  include("RPT09_TenderRecap.php");}?>
                        <?php if($RPTN2==10){  include("RPT10_OperatorSales.php");}?>
                        <?php if($RPTN2==11){  include("RPT11_DepartmentTotals.php");}?>
                        <?php if($RPTN2==12){  include("RPT12_HourlyDepartmentTotals.php");}?>
                        <?php if($RPTN2==13){  include("RPT13_ItemMovement.php");}?>
                        <?php if($RPTN2==14){  include("RPT14_DepartmentVariance.php");}?>
                        <?php if($RPTN2==15){  include("RPT15_TenderListing.php");}?>
                        <?php if($RPTN2==16){  include("RPT16_TransactionLog.php");}?>
                        <?php if($RPTN2==17){  include("RPT17_ExceptionLog.php");}?>
                        <?php if($RPTN2==18){  include("RPT18_OperatorPerformance.php");}?>
                        <?php if($RPTN2==19){  include("RPT19_TerminalProductivity.php");}?>
                        <?php if($RPTN2==20){  include("RPT20_ItemDataDetail.php");}?>
                        <?php if($RPTN2==21){  include("RPT21_ItemDataSummary.php");}?>
                        <?php if($RPTN2==22){  include("RPT22_OperatorAuthorization.php");}?>
                        <?php if($RPTN2==23){  include("RPT23_TenderVerification.php");}?>
                        <?php if($RPTN2==24){  include("RPT24_NegativeSales.php");}?>
                        <?php if($RPTN2==25){  include("RPT25_ItemSalesException.php");}?>
                        <?php if($RPTN2==26){  include("RPT26_Void.php");}?>
                        <?php if($RPTN2==27){  include("RPT27_Refund.php");}?>
        
                        </td>
                        </tr>
                        </table>
                
        </td>
        </tr>
        </table>
</td>
</tr>
</table>
</body>
</html>
<?php
		sqlsrv_close($conn);
?>

