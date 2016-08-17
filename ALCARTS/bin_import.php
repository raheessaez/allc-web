<?php

		$BDIP = "10.0.2.27:1433";

		//$db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = ".$BDIP.")(PORT = 1521)))(CONNECT_DATA=(SID=xe)))" ;

		//$conn = oci_connect( "ARTS_EC" ,"ARTS_EC", $db);

		//$SQL="ALTER SESSION SET nls_date_format='DD-MM-YYYY'";

		//$RS = oci_parse($conn, $SQL);

		//oci_execute($RS);

		$serverName = $BDIP;
        $connectionInfo = array( "Database"=>"ARTS_EC", "UID"=>"sa", "PWD"=>"sa");
        $conn = sqlsrv_connect( $serverName, $connectionInfo);



if (file_exists('bines/ACEBNINP_LUPE.DAT')) 

{

	$file = file("bines/ACEBNINP_LUPE.DAT");

}
else
{

	echo "Archivo no Existente =>"."bines/ACEBNINP_LUPE.DAT";

}

$count = 0;
foreach ($file as $RowRept) 
{

	if($count >= 1){

		$A = substr($RowRept,0,2);
		$B = substr($RowRept,2,6);
		$C = substr($RowRept,8,19);
		$D = substr($RowRept,28,2);
		$E = substr($RowRept,30,1);
		$F = substr($RowRept,31,4);
		$G = substr($RowRept,35,4);
		$H = substr($RowRept,39,2);
		$I = substr($RowRept,41,2);
		$J = substr($RowRept,43,3);
		$K = substr($RowRept,46,1);
		$L = substr($RowRept,47,1);
		$M = substr($RowRept,48,1);
		$N = substr($RowRept,49,1);
		$O = substr($RowRept,50,1);
		$P = substr($RowRept,51,6);
		$Q = substr($RowRept,57,15);
		$R = substr($RowRept,72,2);
		$S = substr($RowRept,74,1);
		$T = substr($RowRept,75,2);
		$U = substr($RowRept,77,1);
		$V = substr($RowRept,78,2);
		$W = substr($RowRept,80,1);
		$X = substr($RowRept,81,1);
		$Y = substr($RowRept,82,1);

		//ECHO $count." R type:".$A." secuencial:".$B." bin:".$C." pan:".$D." accion:".$E." flag p:".$F." flag u:".$G." card p :".$H." net:".$I." host:".$J." flag tarjeta:".$K." primer m:".$L." manual:".$M." factura:".$N." puntos:".$O." deptos:".$P." desc:".$Q." frank:".$R." bono:".$S." ty_tnd:".$T." card_ty:".$U."retencion:".$V." subv:".$W."<br>";
		if(strcmp($A,"T1") !== 0){

			$SQLOG="INSERT INTO CO_BINES(ID_BINES,BIN_TARJETA,LON_PAN,COD_OPERACION,FLAG_PROCESAMIENTO,FLAG_USUARIO,CARD_PLAN_ID,NETWORK_ID,TIPO_HOST,TARJ_PERMITIDA,PR_MED_PAGO,AUT_MANUAL,FACT_REQ,AC_PUNTOS,DEPARTAMENTO,DESCRIPCION,ID_FRANQUEO,FLAG_BONO_SOL,P_PAG_RET,RECORD_ID,SUB_CARD_PLAN_ID,PIN,CVC,MONTO_MAYOR,TY_TND) VALUES";

		$SQLOG=$SQLOG."(".$B.",".$C.",".$D.",'".$E."','".$F."','".$G."','".$H."','".$I."','".$J."',".$K.",".$L.",".$M.",".$N.",".$O.",'".$P."','".trim($Q)."','".$R."','".$S."',".$U.",'".$A."','".$V."','".$W."','".$X."','".$Y."','".$T."');";

		ECHO $SQLOG."<br>";

		//$RSL = sqlsrv_query($conn, $SQLOG);

		//oci_execute($RSL);

		}
		

	}

	$count ++;



}





?>