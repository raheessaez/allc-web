<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1123;
	$NOMENU=1;
	$LIST=@$_GET["LIST"];
	$ACT=@$_GET["ACT"];
	if ($ACT=="") {
		 $LIST=1;
	}
	
	
?>
<?php if ($LIST<>1) {?>
<script language="JavaScript">
function validaingreso(theForm){
	
		if (theForm.NM_DPT_PS.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.NM_DPT_PS.focus();
			return false;
	}


} //validaingreso(theForm)


</script>
<?php }?>
</head>

<body>

<?php include("encabezado.php");?>
<?php include("titulo_menu.php");?>
<table width="100%" height="100%">
<tr>
<td align="right"  width="200" bgcolor="#FFFFFF"><?php include("menugeneral.php");?></td> 
<td >
<?php
if ($MSJE==1) {
$ELMSJ="Registro actualizado";
} 
if ($MSJE == 2) {
							$ELMSJ="Registro no disponible, verifique";
} 
if ($MSJE == 3) {
$ELMSJ="Registro realizado";
}
if ($MSJE == 4) {
$ELMSJ="Registro eliminado";
}
if ($MSJE <> "") {
?>
<div id="GMessaje" onClick="QuitarGMessage();"><a href="#" onClick="QuitarGMessage();" style="color:#111111;"><?php echo $ELMSJ?></a></div>
<?php }?>
        <table width="100%">
        <tr><td>

             <table style="margin:10px 20px; ">
                <tr>
                <td>
                
                
<?php
if ($LIST==1) {
?>

                <table id="Listado">
                <tr>
                    <th>Nombre XML</th>
                    <th>Carpeta Contenedora</th>
                    <th>Ver Archivo</th>
                </tr>
                <?php
			
              			?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                
                <?php
																	}
																	?>
    
                </table>                            
                </td>
                </tr>
                </table>
        
        
</td>
</tr>
</table>
</body>
</html>

