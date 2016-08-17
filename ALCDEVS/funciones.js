/*SELECTORES*/
function CargaTiendaSelect(valor, forma, campo, idusu)
{
sel= forma + "." + campo;
numero=100 ;	
frmHIDEN.location.href = "selectDevs.php?idusu="+ idusu +"&valor="+ valor +"&select="+sel+"&numero="+numero+"";
}
function CargaTiendaSelectE(valor, forma, campo)
{
sel= forma + "." + campo;
numero=200 ;	
frmHIDEN.location.href = "selectDevs.php?valor="+ valor +"&select="+sel+"&numero="+numero+"";
}
/*VERIFICADORES*/
function RetiraRegistro(val,tipo,cliente) {
var aceptaEntrar = window.confirm("SE ELIMINARA EL REGISTRO DE NOTA DE CREDITO, ESTA SEGURO?");
if (aceptaEntrar)  {
parent.location.href="reg_devols_reg.php?ELMNC=1&ID_DEVS="+val+"&ID_TIPOD="+tipo+"&ID_CPR="+cliente+"";
}  else  { return false; }
}
function ConfirmaRegistro(val_x, val_y) {
var aceptaEntrar = window.confirm("CONFIRMA EL REGISTRO DE NOTA DE CREDITO, ESTA SEGURO?");
if (aceptaEntrar) {
var id_devs = val_x;
var id_tipod = val_y;
parent.location.href="reg_devols_reg.php?REGNC=1&ID_DEVS="+id_devs+"&ID_TIPOD="+id_tipod+"";
}  else  { return false; }
}


