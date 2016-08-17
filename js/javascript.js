/*FUNCIONES DE FORMATO*/
var nav4 = window.Event ? true : false;
function acceptNum(evt){ 
var key = evt.which || evt.keyCode; 
return (key <= 13 || (key >= 48 && key <= 57));
}
function acceptNumpunto(evt){ 
var key = evt.which || evt.keyCode; 
return (key <= 13 || (key >= 48 && key <= 57) || key==46);
}
function ValidarFecha(Cadena){  
var Fecha= new String(Cadena)
var Ano= new String(Fecha.substring(Fecha.lastIndexOf("-")+1,Fecha.length))  
var Mes= new String(Fecha.substring(Fecha.indexOf("-")+1,Fecha.lastIndexOf("-")))  
var Dia= new String(Fecha.substring(0,Fecha.indexOf("-")))  
if (isNaN(Ano) || Ano.length<4 || parseFloat(Ano)<1900){  return false   }  
if (isNaN(Mes) || parseFloat(Mes)<1 || parseFloat(Mes)>12){   return false   }  
if (isNaN(Dia) || parseInt(Dia, 10)<1 || parseInt(Dia, 10)>31){   return false   }  
if (Mes==4 || Mes==6 || Mes==9 || Mes==11 || Mes==2) {  
if (Mes==2 && Dia > 28 || Dia>30) {   return false   }
} return true;
}
function CalcularEdad(dia_nacim,mes_nacim,anio_nacim)
{
fecha_hoy = new Date();
ahora_anio = fecha_hoy.getYear();
ahora_mes = fecha_hoy.getMonth();
ahora_dia = fecha_hoy.getDate();
edad = (ahora_anio + 1900) - anio_nacim;
if ( ahora_mes < (mes_nacim - 1))  { edad--;}
if (((mes_nacim - 1) == ahora_mes) && (ahora_dia < dia_nacim)){ edad--;}
if (edad > 1900) { edad -= 1900; }
if ((edad>=18) && (edad<=99)) {
return true; }
}  

/*FUNCIONES DE ACCION*/
function QuitarGMessage(){
var ElMensaje = document.getElementById("GMessaje");
ElMensaje.style.display = "none";
return true;
}
/*FUNCIONES DE ACTIVACION*/
function ActivarSPS(){
var contenedor = document.getElementById("VentanaSPS");
contenedor.style.display = "block";
return true;
}
function CerrarSPS(){
parent.location.href='SetPaisSuite.php?cierre=1';
}
function MostrarMenuGeneral(){
var menu = document.getElementById("MenuGeneral");
var pestanaOcl = document.getElementById("BTN-OcultarMenuGeneral");
var pestanaVer = document.getElementById("BTN-VerMenuGeneral");
menu.style.display = "table-cell";
pestanaOcl.style.display = "block";
pestanaVer.style.display = "none";
return true;
}
function OcultarMenuGeneral(){
var menu = document.getElementById("MenuGeneral");
var pestanaOcl = document.getElementById("BTN-OcultarMenuGeneral");
var pestanaVer = document.getElementById("BTN-VerMenuGeneral");
menu.style.display = "none";
pestanaOcl.style.display = "none";
pestanaVer.style.display = "block";
return true;
}
function ActivarVentana(){
var contenedor = document.getElementById("Ventana");
contenedor.style.display = "block";
return true;
}

function CerrarVentana(){
var contenedor = document.getElementById("Ventana");
contenedor.style.display = "none";
return true;
}
/*FUNCIONES VENTANA*/
function pagina(pagina) {
parent.location.href=pagina;
}
function VentanaImprime(win){
win2=window.open(win,"","width=750,height=700, left=75, top=10, status=no, scrolls=no, location=no, titlebar=no")
win2.creator=self
}
/*FUNCIONES COMBO*/
function CargaCiudad(valor, forma, campo, pais)
{
sel= forma + "." + campo;
numero=1 ;	
frmHIDEN.location.href = "../selectores.php?pais="+ pais +"&valor="+ valor +"&select="+sel+"&numero="+numero+"";
}
function CargaTienda(valor, forma, campo)
{
sel= forma + "." + campo;
numero=2 ;	
frmHIDEN.location.href = "../selectores.php?valor="+ valor +"&select="+sel+"&numero="+numero+"";
}
function CargaTiendaUsu(valor, forma, campo)
{
sel= forma + "." + campo;
numero=3 ;	
frmHIDEN.location.href = "../selectores.php?valor="+ valor +"&select="+sel+"&numero="+numero+"";
}
function CargaPerfil(valor, forma, campo)
{
sel= forma + "." + campo;
numero=4 ;	
frmHIDEN.location.href = "../selectores.php?valor="+ valor +"&select="+sel+"&numero="+numero+"";
}

