/*SELECTORES*/
function CargaTiendaSelect(valor, forma, campo, idusu)
{
sel= forma + "." + campo;
numero=100 ;	
frmHIDEN.location.href = "selectCotiza.php?idusu="+ idusu +"&valor="+ valor +"&select="+sel+"&numero="+numero+"";
}
function CargaTiendaSelectE(valor, forma, campo)
{
sel= forma + "." + campo;
numero=200 ;	
frmHIDEN.location.href = "selectCotiza.php?valor="+ valor +"&select="+sel+"&numero="+numero+"";
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
/*CONFIRMACION*/
function PaginaSalir(pagina) {
var AceptaEntrar = window.confirm("SE ELIMINARA EL REGISTRO, ESTA SEGURO?");
if (AceptaEntrar) 
{ parent.location.href=pagina; }  else  { return false; }
}
/*ACTIVADORES*/
 function ActivarClienteRegionSi(val){
var TipoID = val;
var Nombre1 = document.getElementById("NOMB_TIPOID1");
var ApellidoP1 = document.getElementById("APPP_TIPOID1");
var ApellidoM1 = document.getElementById("APPM_TIPOID1");
var Genero1 = document.getElementById("GENDER_TIPOID1");
var FecNac1 = document.getElementById("FECNAC_TIPOID1");
var Direccion = document.getElementById("DIRECC");
var Region = document.getElementById("REGION");
var Ciudad = document.getElementById("CIUDAD");
var Telefono = document.getElementById("TELEFONO");
var Email = document.getElementById("CORREO");
var Nombre2 = document.getElementById("NOMB_TIPOID2");
var DocDevol = document.getElementById("DOCDEVOL");
var RegistraNC = document.getElementById("REGISTRA");
if(TipoID==0){
		Nombre1.style.display = "none";
		ApellidoP1.style.display = "none";
		ApellidoM1.style.display = "none";
		Genero1.style.display = "none";
		FecNac1.style.display = "none";
		Direccion.style.display = "none";
		Region.style.display = "none";
		Ciudad.style.display = "none";
		Telefono.style.display = "none";
		Email.style.display = "none";
		Nombre2.style.display = "none";
		DocDevol.style.display = "none";
		RegistraNC.style.display = "none";
}
if(TipoID==1){
		Nombre1.style.display = "table-row";
		ApellidoP1.style.display = "table-row";
		ApellidoM1.style.display = "table-row";
		Genero1.style.display = "table-row";
		FecNac1.style.display = "table-row";
		Direccion.style.display = "table-row";
		Region.style.display = "table-row";
		Ciudad.style.display = "table-row";
		Telefono.style.display = "table-row";
		Email.style.display = "table-row";
		Nombre2.style.display = "none";
		DocDevol.style.display = "table-row";
		RegistraNC.style.display = "table-row";
}
if(TipoID==2){
		Nombre2.style.display = "table-row";
		Nombre1.style.display = "none";
		ApellidoP1.style.display = "none";
		ApellidoM1.style.display = "none";
		Genero1.style.display = "none";
		FecNac1.style.display = "none";
		Direccion.style.display = "table-row";
		Region.style.display = "table-row";
		Ciudad.style.display = "table-row";
		Telefono.style.display = "table-row";
		Email.style.display = "table-row";
		DocDevol.style.display = "table-row";
		RegistraNC.style.display = "table-row";
}
if(TipoID==3){
		Nombre2.style.display = "table-row";
		Nombre1.style.display = "none";
		ApellidoP1.style.display = "none";
		ApellidoM1.style.display = "none";
		Genero1.style.display = "none";
		FecNac1.style.display = "none";
		Direccion.style.display = "table-row";
		Region.style.display = "table-row";
		Ciudad.style.display = "table-row";
		Telefono.style.display = "table-row";
		Email.style.display = "table-row";
		DocDevol.style.display = "table-row";
		RegistraNC.style.display = "table-row";
}
return true;
}
 function ActivarClienteRegionNo(val){
var TipoID = val;
var Nombre1 = document.getElementById("NOMB_TIPOID1");
var ApellidoP1 = document.getElementById("APPP_TIPOID1");
var ApellidoM1 = document.getElementById("APPM_TIPOID1");
var Genero1 = document.getElementById("GENDER_TIPOID1");
var FecNac1 = document.getElementById("FECNAC_TIPOID1");
var Direccion = document.getElementById("DIRECC");
var Ciudad = document.getElementById("CIUDAD");
var Telefono = document.getElementById("TELEFONO");
var Email = document.getElementById("CORREO");
var Nombre2 = document.getElementById("NOMB_TIPOID2");
var DocDevol = document.getElementById("DOCDEVOL");
var RegistraNC = document.getElementById("REGISTRA");
if(TipoID==0){
		Nombre1.style.display = "none";
		ApellidoP1.style.display = "none";
		ApellidoM1.style.display = "none";
		Genero1.style.display = "none";
		FecNac1.style.display = "none";
		Direccion.style.display = "none";
		Ciudad.style.display = "none";
		Telefono.style.display = "none";
		Email.style.display = "none";
		Nombre2.style.display = "none";
		DocDevol.style.display = "none";
		RegistraNC.style.display = "none";
}
if(TipoID==1){
		Nombre1.style.display = "table-row";
		ApellidoP1.style.display = "table-row";
		ApellidoM1.style.display = "table-row";
		Genero1.style.display = "table-row";
		FecNac1.style.display = "table-row";
		Direccion.style.display = "table-row";
		Ciudad.style.display = "table-row";
		Telefono.style.display = "table-row";
		Email.style.display = "table-row";
		Nombre2.style.display = "none";
		DocDevol.style.display = "table-row";
		RegistraNC.style.display = "table-row";
}
if(TipoID==2){
		Nombre2.style.display = "table-row";
		Nombre1.style.display = "none";
		ApellidoP1.style.display = "none";
		ApellidoM1.style.display = "none";
		Genero1.style.display = "none";
		FecNac1.style.display = "none";
		Direccion.style.display = "table-row";
		Ciudad.style.display = "table-row";
		Telefono.style.display = "table-row";
		Email.style.display = "table-row";
		DocDevol.style.display = "table-row";
		RegistraNC.style.display = "table-row";
}
if(TipoID==3){
		Nombre2.style.display = "table-row";
		Nombre1.style.display = "none";
		ApellidoP1.style.display = "none";
		ApellidoM1.style.display = "none";
		Genero1.style.display = "none";
		FecNac1.style.display = "none";
		Direccion.style.display = "table-row";
		Ciudad.style.display = "table-row";
		Telefono.style.display = "table-row";
		Email.style.display = "table-row";
		DocDevol.style.display = "table-row";
		RegistraNC.style.display = "table-row";
}
return true;
}




 





	
