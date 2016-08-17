<?php include("session.inc");?>
<?php
			
$ACTDATACLT=$_POST["ACTDATACLT"];
if ($ACTDATACLT<>"") {
		$TR=$_POST["TR"];
		$SN=$_POST["SN"];
		$ID_CPR=$_POST["ID_CPR"];
		$FL_CP=$_POST["FL_CP"];
                
		
		$DIR_CPR=strtoupper($_POST["DIR_CPR"]);
		$COD_CIUDAD=$_POST["COD_CIUDAD"];
		$TEL_CPR=$_POST["TEL_CPR"];
		$COR_CPR=strtolower($_POST["COR_CPR"]);
		$NAC_CPR=strtoupper($_POST["NAC_CPR"]);
		
		//REGISTRO DE CLIENTE
		if($FL_CP==0){
			$S2="UPDATE CO_CPR_CER SET DIRECCION='".$DIR_CPR."', TELEFONO='".$TEL_CPR."', CORREO='".$COR_CPR."', COD_CIUDAD=".$COD_CIUDAD."  WHERE ID_CPR=".$ID_CPR;
			$RS2 = sqlsrv_query($arts_conn, $S2);
			//oci_execute($RS2);
		} else {
			$S2="UPDATE CO_EXT_CER SET DIRECCION='".$DIR_CPR."', TELEFONO='".$TEL_CPR."', CORREO='".$COR_CPR."', NACIONALIDAD='".$NAC_CPR."' WHERE ID_CPR=".$ID_CPR;
			$RS2 = sqlsrv_query($arts_conn, $S2);
			//oci_execute($RS2);
		}
		//FIN REGISTRO CLIENTE

		header("Location:reg_cvmoto.php?CVM=1&SN=".$SN."&TR=".$TR."&FL_TEL=".$FL_TEL."&MSJE=1");
}


?>
