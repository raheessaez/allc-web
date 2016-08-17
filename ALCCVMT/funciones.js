/*SELECTORES*/
function CargaTiendaSelect(valor, forma, campo, idusu)
{
sel= forma + "." + campo;
numero=100 ;	
frmHIDEN.location.href = "selectCVMoto.php?idusu="+ idusu +"&valor="+ valor +"&select="+sel+"&numero="+numero+"";
}
function CargaTiendaSelectE(valor, forma, campo)
{
sel= forma + "." + campo;
numero=200 ;	
frmHIDEN.location.href = "selectCVMoto.php?valor="+ valor +"&select="+sel+"&numero="+numero+"";
}

