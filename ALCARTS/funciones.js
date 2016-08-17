/*SELECTORES*/

function CargaTiendaSelect(valor, forma, campo, idusu)

{

sel= forma + "." + campo;

numero=100 ;	

frmHIDEN.location.href = "selectArts.php?idusu="+ idusu +"&valor="+ valor +"&select="+sel+"&numero="+numero+"";

}

function CargaTiendaSelectE(valor, forma, campo)

{

sel= forma + "." + campo;

numero=200 ;	

frmHIDEN.location.href = "selectArts.php?valor="+ valor +"&select="+sel+"&numero="+numero+"";

}



function CargaTiendaSelectB(valor, forma, campo)

{

sel= forma + "." + campo;

numero=300;	

frmHIDEN.location.href = "selectArts.php?valor="+ valor +"&select="+sel+"&numero="+numero;

}

	

