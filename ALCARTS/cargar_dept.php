<?php include("session.inc");?>

<?php

if($_GET["DEPT"]==1)

{

	$RES='<option value="nada">Seleccione Depto</option>';

	$CONSULTA="SELECT * FROM ID_DPT_PS";

	$RS = sqlsrv_query($conn, $CONSULTA);

	//oci_execute($RS);

	while ($row = sqlsrv_fetch_array($RS))

	{

		$RES.='<option value="'.$row["CD_DPT_CER"].'">'.$row["NM_DPT_PS"].'</option>';	

	}

	echo $RES;

}

if(isset($_GET["FAM"]))

{

	$RES='<option value="nada">Seleccione</option>';

	$CONSULTA="SELECT * FROM CO_MRHRC_GP WHERE CD_DPT_CER='".$_GET["FAM"]."'";

	$RS = sqlsrv_query($conn, $CONSULTA);

	//oci_execute($RS);

	while ($row = sqlsrv_fetch_array($RS))

	{

		if($row["NM_MRHRC_GP"]!=null)

		$RES.='<option value="'.$row["CD_MRHRC_CER"].'">'.$row["NM_MRHRC_GP"].'</option>';	

	}

	echo $RES;

}

?>