/*SELECTORES*/
function CargaNivel2(valor, forma, campo)
{
sel= forma + "." + campo;
numero=1 ;	
frmHIDEN.location.href = "selectOpc.php?valor="+ valor +"&select="+sel+"&numero="+numero+"";
}
	
function CargaFN2(valor, forma, campo)
{
sel= forma + "." + campo;
numero=2 ;	
frmHIDEN.location.href = "selectOpc.php?valor="+ valor +"&select="+sel+"&numero="+numero+"";
}
	
