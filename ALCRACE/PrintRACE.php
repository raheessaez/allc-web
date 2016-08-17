<?php include("conecta.inc");?>
<?php
	$LOCAL=@$_GET["Loc"];
	$RPT=@$_GET["Rpt"];
?>
<html><head><meta http-equiv="X-UA-Compatible" content="IE=9">	      <!-- IE9 Standards -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php header('Content-Type: text/html; charset=ISO-8859-1'); ?>
<meta name="robots" content="noarchive"/>
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
<meta name="description" content="Alliances"/>
<meta name="author" content="Design: Alliances | Code: Claudio Arellano">
<title>ARMS Reportes RACE</title>
<link rel="shortcut icon" href="../images/favicon.ico">
<link rel="stylesheet" href="../css/OpenSans.css" media="screen">
<link rel="stylesheet" href="../css/_mng_estilos.css" media="screen">
<script language=JavaScript src="../js/javascript.js"></script>
<link rel="stylesheet" href="css/_mng_estilos.css" media="screen">
<script language=JavaScript src="funciones.js"></script>

</head>

<body style="background-color:#FFF">


        <table style="width:100%">
        <tr>
                <td style="background-color:#F1F1F1; background-image:url(../images/ARMS.png); background-repeat:no-repeat; background-position: 20px 10px; height:65px; min-height:65px; border:none">
                    <div id="BtnVentana" style="background-image:url(../images/ICO_CloseVN.png); margin-right:16px"  title="Cerrar Ventana"><img src="images/Transpa.png" width="45" height="45" onClick="javascript: window.close();"  /></div>
                    <div id="BtnVentana" style="background-image:url(../images/ICO_PrintVN.png);" title="Imprime Reporte"><img src="images/Transpa.png" width="45" height="45" onClick="javascript: window.print();" /></div>
                </td>
        </tr>
        </table>
        
        <table style="width:100%">
        <tr>
        <td style="padding:20px">

								<table>
								<?php
										$ConRept = file($SYNC_OUT.$LOCAL."/adx_idt4/".$RPT);
										
										foreach ($ConRept as $RowRept) {
											 if(trim($RowRept)!=""){
													 echo "<tr>";
													 echo "<td></td>";
													 echo "<td>";
														$RowRept = iconv("CP857", "ISO-8859-1", $RowRept);
														echo  "<pre>".$RowRept."</pre>";
													 echo "</td>";
													 echo "<td></td>";
													 echo "</tr>";
											 }
										}
										?>
								</table>
        </td>
        </tr>
        </table>



</body>
</html>
