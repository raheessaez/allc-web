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
/*ACTIVADORES*/
function ActivarSearchItem(){
var contenedor = document.getElementById("WindowItem");
contenedor.style.display = "block";
return true;
}
function CerrarSearchItem(){
var contenedor = document.getElementById("WindowItem");
contenedor.style.display = "none";
return true;
}
/*VALIDADORES*/
function paginaQuitarExcep(pagina) {
var aceptaEntrar = window.confirm("RETIRA EN FORMA DEFINITIVA LA EXCEPCION DEL PROCESO, PRESIONE ACEPTAR PARA CONTINUAR");
if (aceptaEntrar) {
parent.location.href=pagina;
} else  { return false; }
}
function paginaProcesaExcep(pagina) {
var aceptaEntrar = window.confirm("ESTA ACCION HABILITA EL PROCESO DE LA EXCEPCION, PRESIONE ACEPTAR PARA CONTINUAR");
if (aceptaEntrar)  {
parent.location.href=pagina;
} else  { return false; }
}
function paginaPrint(pagina) {
var aceptaEntrar = window.confirm("VERIFIQUE EL ESTADO DE LA IMPRESORA, PRESIONE ACEPTAR PARA CONTINUAR");
if (aceptaEntrar)  {
parent.location.href=pagina;
}  else   { return false; }
}
function paginaPrintCP(pagina) {
var aceptaEntrar = window.confirm("VERIFIQUE EL ESTADO Y TIPO DE FLEJE (PERCHA) DE LA IMPRESORA, PRESIONE ACEPTAR PARA CONTINUAR E IMPRIMIR");
if (aceptaEntrar) {
parent.location.href=pagina;
}  else  { return false; }
}
function paginaPrintGI(pagina, NumIt) {
var CantidadItems = NumIt;
if(CantidadItems>500){
var NumFlejes = prompt("Indique la Cantidad de Flejes en acuerdo con la Capacidad de su Impresora. Seguido, presione ACEPTAR para generar la(s) Comanda(s) de Impresion de Flejes; o presione CANCELAR para volver atras", "500");
valor = parseInt(NumFlejes) ;
if (isNaN(valor)) { //Compruebo si es un valor numérico 
alert("POR FAVOR, VUELVA A INTENTAR CON UN VALOR NUMERICO ENTRE 500 Y 5.000");
} else {  //Verifica que es mayor a 499 y menor que 5000
if( (valor>499) && (valor<=5000) ){
var aceptaEntrar = window.confirm("INGRESO LA CANTIDAD: "+valor+", ESTA SEGURO?");
if (aceptaEntrar) { parent.location.href=pagina+"&NUM_FLJ="+valor; } else { return false; }
} else {
if(valor<499){ alert("INGRESO UNA CANTIDAD INFERIOR A 500, POR FAVOR VUELVA A INTENTAR CON UN VALOR SUPERIOR");}
if(valor>5000){ alert("INGRESO UNA CANTIDAD SUPERIOR A 5000, POR FAVOR VUELVA A INTENTAR CON UN VALOR INFERIOR");}
}
} 
} else {
parent.location.href=pagina+"&NUM_FLJ="+CantidadItems;
}
}
function paginaSalir(pagina) {
var aceptaEntrar = window.confirm("SE ELIMINARA EL REGISTRO, ESTA SEGURO?");
if (aceptaEntrar)  {
parent.location.href=pagina;
} else { return false; }
}
function paginaActCP(pagina) {
var aceptaEntrar = window.confirm("PRESIONE ACEPTAR PARA INICIAR EL PROCESO DE ACTUALIZACION DE PRECIOS EN LA TIENDA");
if (aceptaEntrar)  {
parent.location.href=pagina;
}  else  { return false; }
}