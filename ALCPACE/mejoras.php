
<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=777;
	$NOMENU=1;
?>
</head>
<body>

<?php include("encabezado.php");?>
<?php include("titulo_menu.php");?>
<table width="100%" height="100%">
<tr>
        <td align="right"  width="200" bgcolor="#FFFFFF"><?php include("menugeneral.php");?></td> 
<td>
<?php
if ($MSJE==1) {$ELMSJ="Mejoras";} 
if ($MSJE <> "") {
?>
<div id="GMessaje" onClick="QuitarGMessage();"><a href="#" onClick="QuitarGMessage();" style="color:#111111;"><?php echo $ELMSJ?></a></div>
<?php }?>
        <table width="100%">
        <tr><td>
        
                <table style="margin:10px 20px; ">
                <tr>
                <td>
                		
                        <div style="width:100%; height:100%; padding:60px 100px">
                        <img style="display:block; float:none;" src="../images/Mejoras.png">
                        <input style=" display:block; float:none; margin:20px 0; padding:16px 32px" type="button" value="volver" onClick="pagina('../msistemas.php');">
                        </div>
                    
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

