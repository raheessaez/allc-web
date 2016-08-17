<?php include("session.inc");?>

<?php

if(isset($_GET["CARD_ID"]))

{
	$CARD_ID=$_GET["CARD_ID"];
	$RES='<select name="SEL_SUBV" id="SEL_SUBV">';

	$CONSULTA="SELECT * FROM SUB_CARD_PLAN_ID where CARD_ID='".$CARD_ID."' AND ID NOT IN(SELECT SUB_CARD_PLAN_ID FROM CO_BINES WHERE CARD_PLAN_ID='".$CARD_ID."' and SUB_CARD_PLAN_ID<> null) ";

	$RS = sqlsrv_query($conn, $CONSULTA);

	//oci_execute($RS);

	while ($row = sqlsrv_fetch_array($RS))

	{

		$RES.='<option value="'.$row["ID"].'">'.$row["DESC_SUB"].'</option>';	

	}

	echo $RES."</select>";

}


?>