<?php include("conecta.inc");?>
<?php
	$nombRep=@$_GET["nombRep"];
?>
<html><head><meta http-equiv="X-UA-Compatible" content="IE=9">	      <!-- IE9 Standards -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php header('Content-Type: text/html; charset=ISO-8859-1'); ?>
<meta name="robots" content="noarchive"/>
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
<meta name="description" content="Alliances"/>
<meta name="author" content="Design: Alliances | Code: Claudio Arellano">
<title>ARMS | RACE</title>
<link rel="shortcut icon" href="../images/favicon.ico">
<link rel="stylesheet" href="../css/OpenSans.css" media="screen">


<link rel="stylesheet" href="../css/_mng_estilos.css" media="screen">
<script language=JavaScript src="../js/javascript.js"></script>
<script language=JavaScript src="funciones.js"></script>
<style>
#Calendario {
	background-color:#FFF;
	padding:20px;
	overflow:visible;
	-khtml-border-radius: 4px;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	border-radius: 4px;
	-moz-box-shadow: 0 1px 2px #999;
	-webkit-box-shadow: 0 1px 2px #999;
	box-shadow: 0 1px 2px #999;
}
#Calendario Table {
	border-collapse: collapse; /* IE7 and lower */
	border-spacing: 0;
}

#Calendario td{
	background-color:#FFFFFF;
	text-align: left;
	padding:6px;
	border-color:#DFDFDF;
	border-style:solid;
	border-width:1px;
	text-shadow: 0px 1px 0px rgba(255, 255, 255, 0.75);
	min-width:80px;
	font-family: monospace;
	}
	
	#Calendario label{
	text-align: left;
	display: inline;
	}
</style>
</head>

<body>

        <table style="margin:10px 50px;">
        <tr>
                <td>
                    <a href="javascript: window.close();" style="border:none; display:inline; float:right; margin: 6px; width:26px; height:26px; background-image:url(images/ICO_CLOSE24.png); background-repeat:no-repeat" title="Cerrar Ventana"><img src="images/Transpa.png" width="32" /></a>
                    <a href="javascript: window.print();" style="border:none; display:inline; float:right; margin: 6px; width:26px; height:26px; background-image:url(images/ICO_PRINT24.png); background-repeat:no-repeat" title="Imprime Reporte"><img src="images/Transpa.png" width="32"  /></a>
                </td>
        </tr>
        <tr>
        <td>

				<table id="Calendario">
                		<tr>
                        	<td style="text-align:left">
                            	
								<?php
                                        $líneas = file($nombRep);
                                        foreach ($líneas as $num_línea => $línea) {
                                            // if(trim($línea)!=""){
                                                     $EspacioBlanco= "<span style='color:#FFFFFF'>_</span>";
                                                        $línea = str_replace ( " ", $EspacioBlanco, $línea); 
                                                        $línea = str_replace ( "à", "Ó", $línea); 
                                                        $línea = str_replace ( "é", "Ú", $línea); 
                                                        $línea = str_replace ( "Ö", "Í", $línea); 
                                                        echo  $línea."<BR>";
                                             // }
                                        }
                                        ?>
                            </td>
                       </tr>
                </table>
        </td>
        </tr>
        </table>
</body>
</html>